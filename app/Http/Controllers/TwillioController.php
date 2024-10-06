<?php

namespace App\Http\Controllers;

use App\Models\Admin\ScheduleMessages;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\ExcelContact;
use App\Models\LandingPageContact;
use Twilio\Rest\Client;
use Plivo\RestClient;
use Plivo\Resources\Message;



class TwillioController extends Controller
{
    public function admin_manual_messages(){

        return view('admin.manual.index');
    }

    public function send_customers_sms_action(Request $request)
    {

        
        $count=0;
            $data = $request->validate([
                'customer_ids' => 'required',
                'message' => 'required',
            ]);
            $customersIds = explode(",", $data['customer_ids']);
            if (count($customersIds) <= 0) {
                return back()->with('error', 'No customer selected to send message!');
            } else {

                if (isset($request->scheduled) && $request->scheduled == 'on') {
                    if(!isset($request->scheduled_at)) {
                        return back()->with('error', 'Please select date and time to schedule message!');
                    }
                    if(Carbon::parse($request->scheduled_at) < now()) {
                        return back()->with('error', 'Please select future date and time');
                    }

                    ScheduleMessages::create([
                        'msg' => $data['message'],
                        'scheduled_at' => $request->get('scheduled_at'),
                        'user_ids' => $data['customer_ids'],
                        'type' => 'sms',
                        'module' => 'registered_customers',
                        'status' => 'pending',
                    ]);

                    return back()->with('success', 'Promotion SMS are scheduled successfully!');
                }


                $customers = Customer::whereIn('id', $customersIds)->get();
                $message1 = $request->message;
                foreach($customers as $row)
                {
                    // dd($customers);
                    $row->last_message=$request->message.' '.'(SMS)';
                    $row->save();


                    $to = $row->customer_phone;;
                    $text = $message1;


                    try
                    {
                        $client = new RestClient(env('PLIVO_AUTH_ID'), env('PLIVO_AUTH_TOKEN'));
                        $response = $client->messages->create(env('PLIVO_NUMBER'), [$to], $text);
                        $sent = $response->statusCode === 202;
                        if ($response->statusCode === 202) {
                            $count++;
                            // return response()->json(['message' => 'SMS sent successfully']);
                        }
                    } catch (\Exception $exp)
                    {
                        \Log::error('SMS sending failed: ' . $exp->getMessage());
                    }
                   




                    // $count++;
                }

                DB::table('sent_messages')->updateOrInsert(['month' => now()->month], ['sms' => DB::raw('sms +' . $count)]);

                return back()->with('success', $count.' '.'Promotion SMS are sent successfully!');

            }

    }

    public function send_customers_sms_action_landing(Request $request)
    {

        $count=0;
            $data = $request->validate([
                'customer_ids' => 'required',
                'message' => 'required',
            ]);
            $customersIds = explode(",", $data['customer_ids']);
            if (count($customersIds) <= 0) {
                return back()->with('error', 'No customer selected to send message!');
            } else {

                if (isset($request->scheduled) && $request->scheduled == 'on') {
                    if(!isset($request->scheduled_at)) {
                        return back()->with('error', 'Please select date and time to schedule message!');
                    }
                    if(Carbon::parse($request->scheduled_at) < now()) {
                        return back()->with('error', 'Please select future date and time');
                    }

                    ScheduleMessages::create([
                        'msg' => $data['message'],
                        'scheduled_at' => $request->get('scheduled_at'),
                        'user_ids' => $data['customer_ids'],
                        'type' => 'sms',
                        'module' => 'landing_page_contacts',
                        'status' => 'pending',
                    ]);

                    return back()->with('success', 'Promotion SMS are scheduled successfully!');
                }

                $customers = LandingPageContact::whereIn('id', $customersIds)->get();
                $message1 = $request->message;
                foreach($customers as $row)
                {
                    $row->last_message=$request->message.' '.'(SMS)';
                    $row->save();


                    $to = $row->phone;
                    $text = $message1;
                   
                    try
                    {
                        $client = new RestClient(env('PLIVO_AUTH_ID'), env('PLIVO_AUTH_TOKEN'));
                        $response = $client->messages->create(env('PLIVO_NUMBER'), [$to], $text);
                        $sent = $response->statusCode === 202;
                        if ($response->statusCode === 202) {
                            $count++;
                            // return response()->json(['message' => 'SMS sent successfully']);
                        }
                    } catch (\Exception $exp)
                    {
                        \Log::error('SMS sending failed: ' . $exp->getMessage());
                    } 
                    
                }

                DB::table('sent_messages')->updateOrInsert(['month' => now()->month], ['sms' => DB::raw('sms +' . $count)]);

                return back()->with('success', $count.' '.'Promotion SMS are sent successfully!');

            }

    }


    public function admin_manual_sms(Request $request)
    {
            $data = $request->validate([
                'to' => 'required',
                'message' => 'required',
            ]);
           

            $to = $request->to;
            $text = $request->message;


            try
            {
                $client = new RestClient(env('PLIVO_AUTH_ID'), env('PLIVO_AUTH_TOKEN'));
                $response = $client->messages->create(env('PLIVO_NUMBER'), [$to], $text);
                $sent = $response->statusCode === 202;
                if ($response->statusCode === 202) {
                    $count++;
                    // return response()->json(['message' => 'SMS sent successfully']);
                }
            } catch (\Exception $exp)
            {
                \Log::error('SMS sending failed: ' . $exp->getMessage());
            }




            DB::table('sent_messages')->updateOrInsert(['month' => now()->month], ['sms' => DB::raw('sms +' . 1)]);


                return back()->with('success', 'SMS sent successfully!');

    }





    public function send_customers_sms_action_excel(Request $request)
    {


        $count=0;
            $data = $request->validate([
                'customer_ids' => 'required',
                'message' => 'required',
            ]);
            $customersIds = explode(",", $data['customer_ids']);
            if (count($customersIds) <= 0) {
                return back()->with('error', 'No customer selected to send message!');
            } else {

                $customers = [];
                if (isset($request->from) && $request->from == 'contact_us') {
                    $customers = DB::table('messages')->whereIn('id', $customersIds)->get();
                } else {
                    $customers = ExcelContact::whereIn('id', $customersIds)->get();
                }

                $message1 = $request->message;
                foreach($customers as $row)
                {
                    $to = $row->phone;
                    $text = $message1;
                    
                    
                    try
                    {
                        $client = new RestClient(env('PLIVO_AUTH_ID'), env('PLIVO_AUTH_TOKEN'));
                        $response = $client->messages->create(env('PLIVO_NUMBER'), [$to], $text);
                        $sent = $response->statusCode === 202;
                        if ($response->statusCode === 202) {
                            $count++;
                            // return response()->json(['message' => 'SMS sent successfully']);
                        }
                    } catch (\Exception $exp)
                    {
                        \Log::error('SMS sending failed: ' . $exp->getMessage());
                    }



                }

                DB::table('sent_messages')->updateOrInsert(['month' => now()->month], ['sms' => DB::raw('sms +' . $count)]);

                return back()->with('success', $count.' '.'Promotion SMS are sent successfully!');

            }

    }

    public function chnage_customer_call_status(Request $request){

        if($request->table=='landing_page_contacts'){
            $to_update=LandingPageContact::where('id',$request->customer_id)->first();
            $to_update->user_chat_status_id=$request->user_chat_status_id;
            $to_update->save();

            $response = [
                'message' => 'Status updated successfully'
            ];

            return response()->json($response);
        }

        if($request->table=='customers'){
            $to_update=Customer::where('id',$request->customer_id)->first();
            $to_update->user_chat_status_id=$request->user_chat_status_id;
            $to_update->save();

            $response = [
                'message' => 'Status updated successfully'
            ];

            return response()->json($response);
        }


    }

    public function send_customers_whatsapp_action(Request $request)
    {


        $count=0;
            $data = $request->validate([
                'customer_ids' => 'required',
                'message' => 'required',
            ]);
            $customersIds = explode(",", $data['customer_ids']);
            if (count($customersIds) <= 0) {
                return back()->with('error', 'No customer selected to send message!');
            } else {

                if (isset($request->scheduled) && $request->scheduled == 'on') {
                    if(!isset($request->scheduled_at)) {
                        return back()->with('error', 'Please select date and time to schedule message!');
                    }
                    if(Carbon::parse($request->scheduled_at) < now()) {
                        return back()->with('error', 'Please select future date and time');
                    }

                    ScheduleMessages::create([
                        'msg' => $data['message'],
                        'scheduled_at' => $request->get('scheduled_at'),
                        'user_ids' => $data['customer_ids'],
                        'type' => 'whatsapp',
                        'module' => 'registered_customers',
                        'status' => 'pending',
                    ]);

                    return back()->with('success', 'Promotion Whatsapps are scheduled successfully!');
                }


                $customers = Customer::whereIn('id', $customersIds)->get();
                $message1 = $request->message;
                foreach($customers as $row)
                {


                    $row->last_message=$request->message.' '.'(Whatsapp)';
                    $row->save();


                    $sid    = env('TWILIO_ACCOUNT_SID');
                    $token  = env('TWILIO_AUTH_TOKEN');
                    $twilio = new Client($sid, $token);

                    $message = $twilio->messages
                    ->create("whatsapp:".$row->customer_phone, // to
                        array(
                        "from" => "whatsapp:".env('TWILIO_WHATSAPP_FROM'),
                        "body" => $message1
                        )
                    );

                    $count++;
                }

                DB::table('sent_messages')->updateOrInsert(['month' => now()->month], ['whatsapp' => DB::raw('whatsapp +' . $count)]);

                return back()->with('success', $count.' '.'Promotion Whatsapps are sent successfully!');

            }

    }


    public function send_customers_whatsapp_action_landing(Request $request)
    {


        $count=0;
            $data = $request->validate([
                'customer_ids' => 'required',
                'message' => 'required',
            ]);
            $customersIds = explode(",", $data['customer_ids']);
            if (count($customersIds) <= 0) {
                return back()->with('error', 'No customer selected to send message!');
            } else {

                if (isset($request->scheduled) && $request->scheduled == 'on') {
                    if(!isset($request->scheduled_at)) {
                        return back()->with('error', 'Please select date and time to schedule message!');
                    }
                    if(Carbon::parse($request->scheduled_at) < now()) {
                        return back()->with('error', 'Please select future date and time');
                    }

                    ScheduleMessages::create([
                        'msg' => $data['message'],
                        'scheduled_at' => $request->get('scheduled_at'),
                        'user_ids' => $data['customer_ids'],
                        'type' => 'whatsapp',
                        'module' => 'landing_page_contacts',
                        'status' => 'pending',
                    ]);

                    return back()->with('success', 'Promotion Whatsapps are scheduled successfully!');
                }


                $customers = LandingPageContact::whereIn('id', $customersIds)->get();
                $message1 = $request->message;
                foreach($customers as $row)
                {

                    $row->last_message=$request->message.' '.'(Whatsapp)';
                    $row->save();

                    $sid    = env('TWILIO_ACCOUNT_SID');
                    $token  = env('TWILIO_AUTH_TOKEN');
                    $twilio = new Client($sid, $token);

                    $message = $twilio->messages
                    ->create("whatsapp:".$row->phone, // to
                        array(
                        "from" => "whatsapp:".env('TWILIO_WHATSAPP_FROM'),
                        "body" => $message1
                        )
                    );


                    $count++;
                }

                DB::table('sent_messages')->updateOrInsert(['month' => now()->month], ['whatsapp' => DB::raw('whatsapp +' . $count)]);

                return back()->with('success', $count.' '.'Promotion Whatsapps are sent successfully!');

            }

    }


    public function admin_manual_whatsapp(Request $request)
    {

        $data = $request->validate([
            'to' => 'required',
            'message' => 'required',
        ]);

        $sid    = env('TWILIO_ACCOUNT_SID');
                    $token  = env('TWILIO_AUTH_TOKEN');
                    $twilio = new Client($sid, $token);

                    $message = $twilio->messages
                    ->create("whatsapp:".$request->to, // to
                        array(
                        "from" => "whatsapp:".env('TWILIO_WHATSAPP_FROM'),
                        "body" => $request->message
                        )
                    );

        DB::table('sent_messages')->updateOrInsert(['month' => now()->month], ['whatsapp' => DB::raw('whatsapp +' . 1)]);

        return back()->with('success', 'Whatsapps Message sent successfully!');

    }





    public function send_customers_whatsapp_action_excel(Request $request)
    {


        $count=0;
            $data = $request->validate([
                'customer_ids' => 'required',
                'message' => 'required',
            ]);
            $customersIds = explode(",", $data['customer_ids']);
            if (count($customersIds) <= 0) {
                return back()->with('error', 'No customer selected to send message!');
            } else {

                $customers = [];
                if (isset($request->from) && $request->from == 'contact_us') {
                    $customers = DB::table('messages')->whereIn('id', $customersIds)->get();
                } else {
                    $customers = ExcelContact::whereIn('id', $customersIds)->get();
                }

                $message1 = $request->message;
                foreach($customers as $row)
                {

                    $sid    = env('TWILIO_ACCOUNT_SID');
                    $token  = env('TWILIO_AUTH_TOKEN');
                    $twilio = new Client($sid, $token);

                    $message = $twilio->messages
                    ->create("whatsapp:".$row->phone, // to
                        array(
                        "from" => "whatsapp:".env('TWILIO_WHATSAPP_FROM'),
                        "body" => $message1
                        )
                    );

                    $count++;
                }

                DB::table('sent_messages')->updateOrInsert(['month' => now()->month], ['whatsapp' => DB::raw('whatsapp +' . $count)]);

                return back()->with('success', $count.' '.'Promotion Whatsapps are sent successfully!');

            }

    }

    public function sendScheduledMessages()
    {
        $currentDateTime = Carbon::now();

        $records = ScheduleMessages::where('scheduled_at', '<=', $currentDateTime)
            ->where('status', 'pending')
            ->get();

        foreach ($records as $record) {
            try {
                $customersIds = explode(",", $record['user_ids']);
                $message1 = $record['msg'];

                if ($record['module'] == 'registered_customers') {
                    $count1 = 0;
                    try {

                        $customers = Customer::whereIn('id', $customersIds)->get();

                        if ($record['type'] == 'sms') {
                            foreach ($customers as $row) {

                                $row->last_message = $message1 . ' ' . '(SMS)';
                                $row->save();

                                



                                $to = $row->customer_phone;
                                $text = $message1;
                                
                                
                                try
                                {
                                    $client = new RestClient(env('PLIVO_AUTH_ID'), env('PLIVO_AUTH_TOKEN'));
                                    $response = $client->messages->create(env('PLIVO_NUMBER'), [$to], $text);
                                    $sent = $response->statusCode === 202;
                                    if ($response->statusCode === 202) {
                                        $count1++;
                                        // return response()->json(['message' => 'SMS sent successfully']);
                                    }
                                } catch (\Exception $exp)
                                {
                                    \Log::error('SMS sending failed: ' . $exp->getMessage());
                                } 


                            }
                        } else {
                            foreach($customers as $row) {

                                $row->last_message = $message1.' '.'(Whatsapp)';
                                $row->save();

                                $sid    = env('TWILIO_ACCOUNT_SID');
                                $token  = env('TWILIO_AUTH_TOKEN');
                                $twilio = new Client($sid, $token);

                                $twilio->messages
                                ->create("whatsapp:".$row->customer_phone, // to
                                    array(
                                    "from" => "whatsapp:".env('TWILIO_WHATSAPP_FROM'),
                                    "body" => $message1
                                    )
                                );

                                $count1++;
                            }
                        }

                    } catch (\Exception $e) {
                        \Log::error('Message is not sent due to ' . $e->getMessage());
                        continue;
                    }

                    if ($count1 > 0) {
                        if ($record['type'] == 'sms') {
                            DB::table('sent_messages')->updateOrInsert(['month' => now()->month], ['sms' => DB::raw('sms +' . $count1)]);
                        } else {
                            DB::table('sent_messages')->updateOrInsert(['month' => now()->month], ['whatsapp' => DB::raw('whatsapp +' . $count1)]);
                        }
                    }
                }

                if ($record['module'] == 'landing_page_contacts') {
                    $count2 = 0;
                    try {
                        $customers = LandingPageContact::whereIn('id', $customersIds)->get();

                        if ($record['type'] == 'sms') {
                            foreach ($customers as $row) {

                                $row->last_message = $message1 . ' ' . '(SMS)';
                                $row->save();


                                

                                $to = $row->phone;
                                $text = $message1;
                                
                                
                                try
                                {
                                    $client = new RestClient(env('PLIVO_AUTH_ID'), env('PLIVO_AUTH_TOKEN'));
                                    $response = $client->messages->create(env('PLIVO_NUMBER'), [$to], $text);
                                    $sent = $response->statusCode === 202;
                                    if ($response->statusCode === 202) {
                                        $count2++;
                                        // return response()->json(['message' => 'SMS sent successfully']);
                                    }
                                } catch (\Exception $exp)
                                {
                                    \Log::error('SMS sending failed: ' . $exp->getMessage());
                                }  
                                
                                
                            }
                        } else {
                            foreach($customers as $row){

                                $row->last_message = $message1.' '.'(Whatsapp)';
                                $row->save();

                                $sid    = env('TWILIO_ACCOUNT_SID');
                                $token  = env('TWILIO_AUTH_TOKEN');
                                $twilio = new Client($sid, $token);

                                $twilio->messages
                                ->create("whatsapp:".$row->phone, // to
                                    array(
                                    "from" => "whatsapp:".env('TWILIO_WHATSAPP_FROM'),
                                    "body" => $message1
                                    )
                                );
                                $count2++;
                            }
                        }

                    } catch (\Throwable $th) {
                        \Log::error('Message is not sent due to ' . $e->getMessage());
                        continue;
                    }

                    if ($count2 > 0) {
                        if ($record['type'] == 'sms') {
                            DB::table('sent_messages')->updateOrInsert(['month' => now()->month], ['sms' => DB::raw('sms +' . $count2)]);
                        } else {
                            DB::table('sent_messages')->updateOrInsert(['month' => now()->month], ['whatsapp' => DB::raw('whatsapp +' . $count2)]);
                        }
                    }
                }

                $record->update(['status' => 'sent']);
                \Log::info('Scheduled messages sent successfully.');

            } catch (\Exception $th) {
                $record->update(['status' => 'failed']);
                \Log::error('Messages is not sent due to ' . $th->getMessage());
                continue;
            }
        }


    }

}
