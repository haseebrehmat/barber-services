<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Mail\ContactPageMessage;
use App\Models\Admin\Admin;
use App\Models\Admin\StoreTiming;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $g_setting = DB::table('general_settings')->where('id', 1)->first();
        $contact = DB::table('page_contact_items')->where('id', 1)->first();
        $existingTimings = StoreTiming::all();
        $timings = [];
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        foreach ($daysOfWeek as $day)
        {
            $storeTiming = $existingTimings
                ->where('day', $day)
                ->first();
            $timings[$day] = $storeTiming ? $storeTiming->toArray() : [
                'open_time'  => null,
                'close_time' => null,
                'off_day'    => false,
            ];
        }
        return view('pages.contact', compact('contact','g_setting', 'timings'));
    }

    public function send_email(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        // For Options removed at current time
        $options = DB::table('message_options')->get()->pluck('name')->toArray();

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'info' => 'sometimes|max:1000',
            'option' => 'required|in:' . implode(',', $options),
        ]);

        $data['name'] = $request['name'];
        $data['phone'] = $request['phone'];
        $data['organization'] = $request['organization'];
        $data['info'] = $request['info'];
        $data['option'] = $request['option'];

        DB::table('messages')->insert($data);

        // $g_setting = DB::table('general_settings')->where('id', 1)->first();
        // $request->validate([
        //     'visitor_name' => 'required',
        //     'visitor_email' => 'required|email',
        //     'visitor_message' => 'required'
        // ]);

        // if($g_setting->google_recaptcha_status == 'Show') {
        //     $request->validate([
        //         'g-recaptcha-response' => 'required'
        //     ],
        //     [
        //         'g-recaptcha-response.required'    => 'You must have to input recaptcha correctly'
        //     ]);
        // }

        // // Send Email
        // $email_template_data = DB::table('email_templates')->where('id', 1)->first();
        // $subject = $email_template_data->et_subject;
        // $message = $email_template_data->et_content;

        // $message = str_replace('[[visitor_name]]', $request->visitor_name, $message);
        // $message = str_replace('[[visitor_email]]', $request->visitor_email, $message);
        // $message = str_replace('[[visitor_phone]]', $request->visitor_phone, $message);
        // $message = str_replace('[[visitor_message]]', $request->visitor_message, $message);

        // $admin_data = DB::table('admins')->where('id',1)->first();

        // Mail::to($admin_data->email)->send(new ContactPageMessage($subject,$message));

        return redirect()->back()->with('success', 'Message is sent successfully! Admin will contact you soon');
    }

    public function messages()
    {
        $messages = DB::table('messages')->get();
        $options = DB::table('message_options')->get();
        return view('admin.message.index', compact('messages', 'options'));
    }

    public function storeOption(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $data['name'] = $request['name'];
        DB::table('message_options')->insert($data);
        return redirect()->back()->with('success', 'Option added successfully!');
    }

    public function deleteOption($id)
    {
        DB::table('message_options')->where('id', $id)->delete();
        return redirect()->back()->with('info', 'Option deleted successfully!');
    }
}
