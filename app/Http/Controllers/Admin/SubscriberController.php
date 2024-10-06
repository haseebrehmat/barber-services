<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Subscriber;
use App\Models\Customer;
use App\Models\ExcelContact;
use App\Models\LandingPageContact;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailToAllSubscribers;
use DB;

class SubscriberController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $subscriber = Subscriber::where('subs_active', 1)->get();
        return view('admin.subscriber.index', compact('subscriber'));
    }

    public function destroy($id)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }
        
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();
        return Redirect()->back()->with('success', 'Subscriber is deleted successfully!');
    }

    public function send_email()
    {
        return view('admin.subscriber.send_email');
    }

    public function send_email_action(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }
        
        $request->validate([
            'subject' => 'required',
            'message' => 'required'
        ]);

        $subject = $request->subject;
        $message = $request->message;

        $all_subscribers = Subscriber::where('subs_active', 1)->get();
        foreach($all_subscribers as $row)
        {
            $subs_email = $row->subs_email;
            Mail::to($subs_email)->send(new MailToAllSubscribers($subject,$message));
        }

        return redirect()->back()->with('success', 'Email is sent successfully to all subscribers!');
    }

    public function send_customers_email_action(Request $request)
    {
       
        
        $count=0;
            $data = $request->validate([
                'customer_ids' => 'required',
                'subject' => 'required',
                'message' => 'required',
            ]);
            $customersIds = explode(",", $data['customer_ids']);
            if (count($customersIds) <= 0) {
                return back()->with('error', 'No customer selected to send message!');
            } else {

                
                $customers = Customer::whereIn('id', $customersIds)->get();
                
                $subject = $request->subject;
                $message = $request->message;

                $all_subscribers = Subscriber::where('subs_active', 1)->get();
                foreach($customers as $row)
                {
                    $subs_email = $row->customer_email;
                    
                    Mail::to($subs_email)->send(new MailToAllSubscribers($subject,$message));
                    $count++;
                }

                return back()->with('success', $count.' '.'Promotion Emails are sent successfully!');

            }
            
    }


    public function admin_manual_email(Request $request)
    {
            $data = $request->validate([
                'to' => 'required',
                'subject' => 'required',
                'message' => 'required',
            ]);

            Mail::to($request->to)->send(new MailToAllSubscribers($request->subject,$request->message));
            return back()->with('success', 'Email sent successfully!');
            
    }



    public function send_customers_email_action_excel(Request $request)
    {
       
        
        $count=0;
            $data = $request->validate([
                'customer_ids' => 'required',
                'subject' => 'required',
                'message' => 'required',
            ]);
            $customersIds = explode(",", $data['customer_ids']);
            if (count($customersIds) <= 0) {
                return back()->with('error', 'No customer selected to send message!');
            } else {

                
                $customers = ExcelContact::whereIn('id', $customersIds)->get();
                
                $subject = $request->subject;
                $message = $request->message;

                $all_subscribers = Subscriber::where('subs_active', 1)->get();
                foreach($customers as $row)
                {
                    $subs_email = $row->email;
                    
                    Mail::to($subs_email)->send(new MailToAllSubscribers($subject,$message));
                    $count++;
                }

                return back()->with('success', $count.' '.'Promotion Emails are sent successfully!');

            }
            
    }

    public function send_subscriber_email(Request $request)
    {
        
       
        
        $count=0;
            $data = $request->validate([
                'customer_ids' => 'required',
                'subject' => 'required',
                'message' => 'required',
            ]);
            $customersIds = explode(",", $data['customer_ids']);
            if (count($customersIds) <= 0) {
                return back()->with('error', 'No Subscriber selected to send message!');
            } else {

                
                $customers = Subscriber::whereIn('id', $customersIds)->get();
                
                
                $subject = $request->subject;
                $message = $request->message;

                // $all_subscribers = Subscriber::where('subs_active', 1)->get();
                foreach($customers as $row)
                {
                    $subs_email = $row->subs_email;
                    
                    Mail::to($subs_email)->send(new MailToAllSubscribers($subject,$message));
                    $count++;
                }

                return back()->with('success', $count.' '.'Promotion Emails are sent successfully!');

            }
            
    }




    public function send_customers_email_action_landing(Request $request)
    {
       
        
        $count=0;
            $data = $request->validate([
                'customer_ids' => 'required',
                'subject' => 'required',
                'message' => 'required',
            ]);
            $customersIds = explode(",", $data['customer_ids']);
            if (count($customersIds) <= 0) {
                return back()->with('error', 'No customer selected to send message!');
            } else {

                
                $customers = LandingPageContact::whereIn('id', $customersIds)->get();
                
                $subject = $request->subject;
                $message = $request->message;

                foreach($customers as $row)
                {
                    $subs_email = $row->email;
                    
                    Mail::to($subs_email)->send(new MailToAllSubscribers($subject,$message));
                    $count++;
                }

                return back()->with('success', $count.' '.'Promotion Emails are sent successfully!');

            }
            
    }








}
