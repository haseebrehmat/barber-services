<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\CouponDesign;
use App\Models\Admin\ScheduleMessages;
use App\Models\Customer;
use App\Models\Admin\Subscriber;
use App\Models\ExcelContact;
use App\Models\LandingPageContact;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Admin\CouponTool;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\UserChatStatus;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $customers = Customer::all();
        $user_chat_statuses=UserChatStatus::all();
        $scheduled_messages = ScheduleMessages::where('module', 'registered_customers')->orderBy('scheduled_at', 'DESC')->get();
        return view('admin.customer.index', compact('customers','user_chat_statuses', 'scheduled_messages'));
    }

    public function compose_document(){
        $customers = Customer::all();
        $documents = DB::table('composed_documents')->get();
        return view('admin.customer.compose_document', compact('customers', 'documents'));
    }

    public function save_compose_document(Request $request)
    {
        $data = $request->validate([
            'id' => 'nullable',
            'title' => 'required|max:500',
            'message' => 'required|min:10',
        ]);
        DB::table('composed_documents')->updateOrInsert(['id' => $data['id']], ['message' => $data['message'], 'title' => $data['title']]);
        return back()->with('success', 'Message '. ($data['id'] ? 'updated' : 'added') . ' successfully!');
    }
    public function delete_compose_document($id)
    {
        DB::table('composed_documents')->where('id', $id)->delete();
        return back()->with('success', 'Message deleted successfully!');
    }
    public function landing_page_messages()
    {
        // dd('1');
        $coupons_old = CouponTool::all();
        $user_chat_statuses = UserChatStatus::all();
        $coupons = CouponDesign::modified()->get();
        $customers = LandingPageContact::all();
        $scheduled_messages = ScheduleMessages::where('module', 'landing_page_contacts')->orderBy('scheduled_at', 'DESC')->get();
        return view('admin.customer.landing', compact('customers','coupons','coupons_old','user_chat_statuses', 'scheduled_messages'));
    }

    public function landing_page_messages_by_page($id)
    {

        $coupons = CouponTool::all();
        $user_chat_statuses = UserChatStatus::all();

        $customers = LandingPageContact::where('landing_page_id', $id)
        ->orderBy('id', 'desc')
        ->get();

 
        $scheduled_messages = ScheduleMessages::where('module', 'landing_page_contacts')->orderBy('scheduled_at', 'DESC')->get();
        $landing_page_detail =  DB::table('general_settings')->select('lpc_name')->where('id', $id)->first();
        $lpc_name = isset($landing_page_detail) ? $landing_page_detail->lpc_name : 'No Name';
        return view('admin.customer.landing', compact('customers','coupons','user_chat_statuses', 'scheduled_messages', 'lpc_name'));
    }

    public function landing_page_emails_by_page($id)
    {
        $coupons = CouponTool::all();
        $user_chat_statuses = UserChatStatus::all();
        $customers = LandingPageContact::where('landing_page_id', $id)
        ->orderBy('id', 'desc')
        ->get();

        $landing_page_detail =  DB::table('general_settings')->select('lpc_name')->where('id', $id)->first();
        $lpc_name = isset($landing_page_detail) ? $landing_page_detail->lpc_name : 'No Name';
        return view('admin.customer.emails', compact('customers','coupons','user_chat_statuses', 'id', 'lpc_name'));
    }

    public function select_emails(Request $request)
    {
        $data = $request->validate([
            'customer_ids' => 'required',
            'landing_page_id' => 'required',
        ]);
        session(['landing_page_customer_ids' => explode(',', $data['customer_ids'])]);
        return redirect()->route('admin.email_template.gallery')->with('success', 'Customer are selected for emails marketing');
    }

    public function follow_up_customer()
    {

        $customers = Customer::all();
        $landingPageContacts = LandingPageContact::all();
        foreach ($customers as $key0 => $customer) {
            foreach ($landingPageContacts as $key1 => $landingPageContact) {
                if($customer->customer_email==$landingPageContact->email){
                    unset($customers[$key0]);
                }
            }
        }

        $user_chat_statuses = UserChatStatus::all();

        // $customers = LandingPageContact::all();
        return view('admin.customer.follow_up_customer', compact('landingPageContacts','customers','user_chat_statuses'));
    }

    public function follow_up_customer_comment(Request $request){
        if($request->table=='landing_page_contacts'){
            $to_update=LandingPageContact::where('id',$request->customer_id)->first();
            $to_update->comment=$request->comment;
            $to_update->save();

            // return back()->with('success','Status updated successfully!');
        }

        if($request->table=='customers'){
            $to_update=Customer::where('id',$request->customer_id)->first();
            $to_update->comment=$request->comment;
            $to_update->save();

            // return back()->with('success','Status updated successfully!');
        }
    }



    public function landing_page_emails()
    {
        // dd('1');
        $customers = LandingPageContact::all();
        return view('admin.emailer.landing_emails', compact('customers'));
    }


    public function import_excel_contacts(){

        $customers = ExcelContact::all();
        $coupons = CouponDesign::modified()->get();
        $coupons_old = CouponTool::all();

        return view('admin.excel.excel_import', compact('customers','coupons','coupons_old'));
    }


    public function import_excel_contacts_emailer(){

        $customers = ExcelContact::all();
        return view('admin.emailer.excel_import', compact('customers'));
    }

    public function get_subscribers(){
        $subscribers = Subscriber::where('subs_active', 1)->get();
        return view('admin.emailer.subscriber_emailer', compact('subscribers'));
    }

    public function subscriber_delete($id)
    {
        Subscriber::find($id)->delete();

        return back()->with('success', 'Subscriber deleted successfully');
    }


    public function excel_import(Request $request){
        $data = $request->validate([
            'file' => 'required',
        ]);


        $file = $request->file('file');

        $data = Excel::toArray([], $file)[0];


        $data = array_filter($data, function($row) {
            return !empty(array_filter($row, function($value) {
                return !is_null($value);
            }));
        });

        // Re-index the array
        $data = array_values($data);
        unset($data['0']);

        if(sizeof($data)>0){
            foreach ($data as $key => $value) {
                $to_save = new ExcelContact;
                $to_save->name=$value['0'];
                $to_save->email=$value['1'];
                $to_save->phone=$value['2'];

                $to_save->save();
            }
        }

        return back()->with('success', 'Contacts Added successfully!');
    }


    public function send_message(Request $request)
    {
       $customer = Customer::where('id', $request->id)->first();
       return redirect('https://wa.me/'.$customer->customer_phone.'?text='.$request->message);
    }

    public function detail($id)
    {
        $customer_detail = DB::table('customers')->where('id',$id)->first();
        return view('admin.customer.detail', compact('customer_detail'));
    }

    public function make_active($id)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['customer_status'] = 'Active';
        DB::table('customers')->where('id',$id)->update($data);

        return redirect()->route('admin.customer.index')->with('success', 'Customer status is changed to active successfully!');
    }

    public function make_pending($id)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['customer_status'] = 'Pending';
        DB::table('customers')->where('id',$id)->update($data);

        return redirect()->route('admin.customer.index')->with('success', 'Customer status is changed to pending successfully!');
    }

    public function destroy($id)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        DB::table('customers')->where('id', $id)->delete();

        return Redirect()->back()->with('success', 'Customer is deleted successfully!');
    }

    public function excel_delete()
    {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        DB::table('excel_contacts')->truncate();

        return Redirect()->back()->with('success', 'All Contacts deleted successfully!');
    }


    public function landing_contacts_delete()
    {

        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        DB::table('landing_page_contacts')->truncate();

        return Redirect()->back()->with('success', 'All Contacts deleted successfully!');
    }

    public function updateLandingPageContact(Request $request, $id)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'phone' => 'required|max:25',
            'name' => 'required|max:224',
        ]);

        DB::table('landing_page_contacts')->where('id', $id)->update($data);

        return back()->with('success', 'Landing Page Contact updated successfully');
    }

    public function deleteLandingPageContact($id)
    {
        DB::table('landing_page_contacts')->where('id', $id)->delete();

        return back()->with('success', 'Landing Page Contact deleted successfully');
    }

    public function updateExcelContact(Request $request, $id)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'phone' => 'required|max:25',
            'name' => 'required|max:224',
        ]);

        $contact = ExcelContact::find($id);
        $contact->name = $data['name'];
        $contact->email = $data['email'];
        $contact->phone = $data['phone'];
        $contact->save();

        return back()->with('success', 'Excel Contact updated successfully');
    }

    public function deleteExcelContact($id)
    {
        ExcelContact::find($id)->delete();

        return back()->with('success', 'Excel Contact deleted successfully');
    }






}
