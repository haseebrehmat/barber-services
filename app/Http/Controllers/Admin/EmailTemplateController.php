<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Models\Admin\EmailTemplate;
use App\Models\Admin\Group;
use Illuminate\Http\Request;
use DB;

class EmailTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = EmailTemplate::orderBy('id');

        $email_template = isset($request->et_type) ? $query->where('et_type', 'emailer')->get() : $query->where('et_type', null)->get();

        return view('admin.email_template.index', compact('email_template'));
    }

    public function edit($id)
    {
        $email_template = EmailTemplate::findOrFail($id);

        return view('admin.email_template.edit', compact('email_template', 'id'));
    }

    public function update(Request $request, $id)
    {
        if (env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $email_template = EmailTemplate::findOrFail($id);
        $data = $request->only($email_template->getFillable());

        $request->validate([
            'et_name' => 'required',
            'et_subject' => 'required',
            'et_content' => 'required',
            'thumbnail' => 'sometimes|mimes:jpg,jpeg,png|max:5000'
        ]);

        if ($request->hasFile('thumbnail')) {
            $ext = $request->file('thumbnail')->extension();
            $final_name = 'thumbnail_' . time() . '.' . $ext;
            $request->file('thumbnail')->move(public_path('uploads'), $final_name);
            $data['thumbnail'] = $final_name;
        }

        $email_template->fill($data)->save();

        if (session('is_super') == 1) {
            return redirect()->route('admin.email_template.gallery')->with('success', 'Email Template is created successfully!');

        } else {
            $params = isset($email_template->et_type) ? ['et_type' => $email_template->et_type] : null;

            return redirect()->route('admin.email_template.index', $params)->with('success', 'Email Template is updated successfully!');
        }
    }

    public function create()
    {
        return view('admin.email_template.create');
    }

    public function store(Request $request)
    {
        if (env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $email_template = new EmailTemplate;
        $data = $request->only($email_template->getFillable());

        $request->validate([
            'et_subject' => 'required',
            'et_content' => 'required',
            'et_name' => 'required',
            'thumbnail' => 'sometimes|mimes:jpg,jpeg,png|max:5000'
        ]);

        $data['et_type'] = 'emailer';

        if ($request->hasFile('thumbnail')) {
            $ext = $request->file('thumbnail')->extension();
            $final_name = 'thumbnail_' . time() . '.' . $ext;
            $request->file('thumbnail')->move(public_path('uploads'), $final_name);
            $data['thumbnail'] = $final_name;
        }

        $email_template->fill($data)->save();

        if (session('is_super') == 1) {
            return redirect()->route('admin.email_template.gallery')->with('success', 'Email Template is created successfully!');
        } else {
            return redirect()->route('admin.email_template.index', ['et_type' => 'emailer'])->with('success', 'Email Template is created successfully!');
        }
    }

    public function gallery()
    {
        $templates = EmailTemplate::unmodified()->get();
        $modified_templates = EmailTemplate::modified()->get();
        return view('admin.email_template.gallery', compact('templates', 'modified_templates'));
    }

    public function select($template_id)
    {
        $template = EmailTemplate::findOrFail($template_id);
        $custom_groups = Group::pluck('name', 'id')->toArray();
        return view('admin.email_template.select', compact('template', 'custom_groups'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'et_name' => 'required',
            'et_subject' => 'required',
            'et_content' => 'required',
            'recipients_id' => 'required|array',
            'ref_template_id' => 'required',
            'modified' => 'sometimes'
        ]);

        $name = $request->et_name;
        $subject = $request->et_subject;
        $message = $request->et_content;
        $groups = $request->recipients_id;

        SendEmail::dispatch($subject, $message, $groups, $request->ref_template_id);

        if (isset($request['modified']) && $request['modified'] == 'on') {
            $this->save_as_template($request->get('ref_template_id'), $message, $name);
        }

        // if (!empty($errors)) {
        //     return redirect()->route('admin.email_template.gallery')->with('error', "After sending {$total} emails, these are some errors enlisted as: " . implode("<br>", $errors));
        // }

        if (session()->has('landing_page_customer_ids')) {
            session()->forget('landing_page_customer_ids');

            return redirect()->route('landingpages.index')->with('success', "Emails are started sending in background successfully to customers");
        } else {
            return redirect()->route('admin.email_template.gallery')->with('success', "Emails are started sending in background successfully");
        }

    }
    public function delete($id)
    {
        $email_template = EmailTemplate::findOrFail($id);
        if ($email_template) {
            $email_template->delete();
        }
        return redirect()->route('admin.email_template.gallery')->with('info', "Template is deleted successfully");
    }

    private function save_as_template($id, $new_content, $new_name)
    {
        $previous_template = EmailTemplate::find($id);
        if ($previous_template) {
            $new_template = $previous_template->replicate();
            $new_template->et_content = $new_content;
            $new_template->et_name = $new_name;
            $new_template->modified_by = session('id');
            $new_template->save();
        }
    }

    public function preview(EmailTemplate $template)
    {
        return view('admin.email_template.preview', compact('template'));
    }

    public function reports()
    {
        $modules_hash = ['campaign' => 'Campaigns', 'direct' => 'Direct Sent Emails'];

        $reports = DB::table('sent_emails')->selectRaw('module, SUM(total_sent) as total, SUM(successful) as successful, SUM(failed) as failed')->groupBy('module')->get();

        $reports = $reports->filter(function ($report) use ($modules_hash) {
            $report->module = $modules_hash[$report->module];
            return $report;
        });

        return view('admin.reports.index', compact('reports'));
    }

}
