<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\AdminMonthlyPayment;
use PDF;
use DB;
use App\Models\Admin\Admin;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.home');
    }

    public function admin_stats()
    {
        $all_products = DB::table('products')->select('id','product_stock')->get();  
          
        return view('admin.stats', compact('all_products'));
    }

    public function tools()
    {
        $transactions=AdminMonthlyPayment::get()->last();

        $storedDate = Carbon::parse($transactions->valid_till); // assuming the date is stored in a column called date_column

        $currentDate = Carbon::now();
        $valid=null;
        if ($storedDate->isPast()) {
            // the stored date is in the past
            $valid='false';
        } else {
            // the stored date is in the future
            $valid='true';
        }

        if ($valid=='false') {
            return view('admin.pay_to_superadmin');
        }

        $record = DB::table('employee_tools')->where('user_id', session('id'))->first();
        $assigned = session('type') == 'admin' ? null : (isset($record) ? explode(',', $record->codes) : []);

        return view('admin.tools', compact('assigned'));
    }


    public function plan_payment(){
        $transactions=AdminMonthlyPayment::all();

        $status=AdminMonthlyPayment::latest()->get()->last();
        $storedDate = Carbon::parse($status->valid_till); // assuming the date is stored in a column called date_column

        $currentDate = Carbon::now();
        $valid=null;
        if ($storedDate->isPast()) {
            // the stored date is in the past
            $valid='false';
        } else {
            // the stored date is in the future
            $valid='true';
        }

        return view('admin.plan_payment',compact('transactions','valid'));
    }


    public function plan_payment_history(){
        $transactions=AdminMonthlyPayment::all();

        $status=AdminMonthlyPayment::latest()->get()->last();
        $storedDate = Carbon::parse($status->valid_till); // assuming the date is stored in a column called date_column

        $currentDate = Carbon::now();
        $valid=null;
        if ($storedDate->isPast()) {
            // the stored date is in the past
            $valid='false';
        } else {
            // the stored date is in the future
            $valid='true';
        }

        return view('admin.plan_payment_history',compact('transactions','valid'));
    }

    public function invoices(){
        $transactions=AdminMonthlyPayment::all();

        $status=AdminMonthlyPayment::latest()->get()->last();
        $storedDate = Carbon::parse($status->valid_till); // assuming the date is stored in a column called date_column

        $currentDate = Carbon::now();
        $valid=null;
        if ($storedDate->isPast()) {
            // the stored date is in the past
            $valid='false';
        } else {
            // the stored date is in the future
            $valid='true';
        }

        return view('admin.invoices',compact('transactions','valid'));
    }

    public function generate_invoice(Request $request){
        $transaction=AdminMonthlyPayment::where('id',$request->transaction_id)->first();
        $g_setting = DB::table('general_settings')->where('id', 1)->first();
        $admin_data = Admin::where('id',session('id'))->first();


        $pdf = PDF::loadView('admin.invoices.transaction', [
            'transaction' => $transaction,
            'g_setting' => $g_setting,
            'admin_data'=>$admin_data,
        ]);

        return $pdf->download("$transaction->transaction_id.invoice.pdf");

    }

    public function employee_tools($id)
    {
        $record = DB::table('employee_tools')->where('user_id', $id)->first();

        $assigned = isset($record) ? explode(',', $record->codes) : [];

        return view('admin.role.employee_tools', compact('assigned', 'id'));
    }

    public function set_employee_tools(Request $request)
    {
        $data = $request->validate([
            'codes' => 'required|array',
            'user_id' => 'required'
        ], [
            'codes.required' => 'Please select any tool to assign',
        ]);

        DB::table('employee_tools')->updateOrInsert(['user_id' => $data['user_id']], ['codes' => implode(',', $data['codes'])]);

        return back()->with('success', 'Tools are assigned to employee');
    }


}
