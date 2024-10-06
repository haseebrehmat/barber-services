<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Campaign;
use App\Models\Admin\EmailTemplate;
use App\Models\Admin\Group;
use App\Models\Admin\Recipient;
use Illuminate\Http\Request;
use App\Mail\SendToRecipients;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin\Subscriber;
use App\Models\LandingPageContact;
use App\Models\ExcelContact;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $data = isset($request->status) ? Campaign::where('status', $request->status)->get() : Campaign::all();

        return view('admin.campaigns.index', compact('data'));
    }

    public function create()
    {
        $recipients = Recipient::pluck('name', 'id')->toArray();

        $custom_groups = Group::pluck('name', 'id')->toArray();

        $templates = EmailTemplate::select('et_name', 'et_subject', 'id', 'thumbnail')->unmodified()->get()->toArray();
        $modified_templates = EmailTemplate::select('et_name', 'et_subject', 'id', 'thumbnail')->modified()->get()->toArray();

        return view('admin.campaigns.create', compact('recipients', 'templates', 'custom_groups', 'modified_templates'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:500',
            'status' => 'required|max:500|in:draft,sent',
            'recipients_id' => 'required',
            'template_id' => 'required'
        ]);


        $campaign = Campaign::create($data);

        $campaign->recipients()->attach($data['recipients_id']);

        return redirect()->route('admin.campaign.index')->with('success', 'Campaign is created successfully');
    }

    public function edit(Campaign $campaign)
    {

        $recipients = Recipient::pluck('name', 'id')->toArray();

        $templates = EmailTemplate::select('et_name', 'et_subject', 'id', 'thumbnail')->unmodified()->get()->toArray();
        $modified_templates = EmailTemplate::select('et_name', 'et_subject', 'id', 'thumbnail')->modified()->get()->toArray();

        $groups = DB::table('campaigns_recipients')
            ->where('campaigns_id', $campaign->id)
            ->get();

        return view('admin.campaigns.edit')->with('data', $campaign)->with('recipients', $recipients)->with('templates', $templates)->with('groups', $groups)->with('modified_templates', $modified_templates);
    }

    public function update(Request $request, Campaign $campaign)
    {
        $data = $request->validate([
            'name' => 'required|max:500',
            'status' => 'required|max:500|in:draft,sent',
            // 'recipients_id' => 'required',
            'template_id' => 'required'
        ]);

        $campaign->update($data);

        // $campaign->recipients()->sync($data['recipients_id']);

        return redirect()->route('admin.campaign.index')->with('success', 'Campaign is updated successfully');
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->recipients()->detach();

        $campaign->delete();

        return redirect()->route('admin.campaign.index')->with('success', 'Campaign is deleted successfully');
    }

    public function send(Request $request, Campaign $campaign)
    {
        try {
            $template = EmailTemplate::find($campaign->template_id);
            $subject = $template->et_subject;
            $message = $template->et_content;
            $total = 0;
            $successful = 0;
            $failed = 0;

            $groups = DB::table('campaigns_recipients')
                ->where('campaigns_id', $campaign->id)
                ->get();

            foreach ($groups as $group) {



                if ($group->recipients_id == 'recipients') {

                    $emails = DB::table('recipients')
                        ->get();

                    if (sizeof($emails) > 0) {

                        foreach ($emails as $row) {
                            try {
                                $message = str_replace('[[recipient_name]]', $row->name, $message);
                                $message = str_replace('[[recipient_email]]', $row->email, $message);

                                Mail::to($row->email)->send(new SendToRecipients($subject, $message));
                                $successful++;
                            } catch (\Exception $th) {
                                $failed++;
                            }

                        }


                    }

                }


                if ($group->recipients_id == 'subscribers') {

                    $emails = DB::table('subscribers')
                        ->get();

                    if (sizeof($emails) > 0) {

                        foreach ($emails as $row) {
                            try {
                                $message = str_replace('[[recipient_email]]', $row->subs_email, $message);
                                Mail::to($row->subs_email)->send(new SendToRecipients($subject, $message));
                                $successful++;
                            } catch (\Exception $th) {
                                $failed++;
                            }

                        }


                    }

                }



                if ($group->recipients_id == 'landing_page') {

                    $emails = DB::table('landing_page_contacts')
                        ->get();


                    if (sizeof($emails) > 0) {

                        foreach ($emails as $row) {
                            try {
                                $message = str_replace('[[recipient_name]]', $row->name, $message);
                                $message = str_replace('[[recipient_email]]', $row->email, $message);

                                Mail::to($row->email)->send(new SendToRecipients($subject, $message));
                                $successful++;
                            } catch (\Exception $th) {
                                $failed++;
                            }
                        }


                    }

                }

                if ($group->recipients_id == 'external_data') {

                    $emails = DB::table('excel_contacts')
                        ->get();


                    if (sizeof($emails) > 0) {

                        foreach ($emails as $row) {
                            try {
                                $message = str_replace('[[recipient_name]]', $row->name, $message);
                                $message = str_replace('[[recipient_email]]', $row->email, $message);

                                Mail::to($row->email)->send(new SendToRecipients($subject, $message));
                                $successful++;
                            } catch (\Exception $th) {
                                $failed++;
                            }
                        }


                    }

                }

                if (!in_array($group->recipients_id, ['recipients', 'subscribers', 'landing_page', 'external_data'])) {
                    $emails = DB::table('group_contacts')->where('group_id', $group->recipients_id)->get();

                    if (sizeof($emails) > 0) {
                        foreach ($emails as $row) {
                            try {
                                $message = str_replace('[[recipient_name]]', $row->name, $message);
                                $message = str_replace('[[recipient_email]]', $row->email, $message);

                                Mail::to($row->email)->send(new SendToRecipients($subject, $message));
                                $successful++;
                            } catch (\Exception $th) {
                                $failed++;
                            }
                        }
                    }

                }

            } //end foreach

            $fixed_groups = ['recipients', 'subscribers', 'landing_page', 'external_data'];

            $default_groups = $groups->filter(function ($item) use ($fixed_groups) {
                return in_array($item->recipients_id, $fixed_groups);
            });

            $custom_groups_ids = $groups->filter(function ($item) use ($fixed_groups) {
                return !in_array($item->recipients_id, $fixed_groups);
            })->pluck('recipients_id')->toArray();

            $custom_groups = DB::table('groups')
                ->select('name AS recipients_id')
                ->whereIn('id',  $custom_groups_ids)
                ->get();

            $groups = $default_groups->merge($custom_groups);
            $groups = $groups->pluck('recipients_id')->toArray();

            $total = $successful + $failed;

            DB::table('sent_emails')->insert([
                'subject' => $subject,
                'message' => $message,
                'groups' => implode(",", $groups),
                'ref_template_id' => $template->id,
                'total_sent' => $total,
                'successful' => $successful,
                'failed' => $failed,
                'module' => 'campaign'
            ]);

            $campaign->update(['status' => 'sent']);
            return redirect()->back()->with('success', 'Campaign is started sending successfully');

            // if (sizeof($campaign->recipients) > 0) {

            //     foreach ($campaign->recipients as $row) {

            //         $message = str_replace('[[recipient_name]]', $row->name, $message);
            //         $message = str_replace('[[recipient_email]]', $row->email, $message);
            //         dd($message);
            //         Mail::to($row->email)->send(new SendToRecipients($subject, $message));
            //     }

            //     $campaign->update(['status' => 'sent']);
            // }

            // return redirect()->back()->with('success', 'Campaign is started sending successfully');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Campaign is not working due to error ' . $e->getMessage());
        }

    }

}
