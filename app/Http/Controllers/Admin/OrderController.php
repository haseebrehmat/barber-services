<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Order;
use App\Models\Admin\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $order = Order::orderBy('id', 'DESC')->get();
        return view('admin.order.index', compact('order'));
    }
    public function grid(Request $request)
    {
        $query = Order::with(['products', 'status']);

        $data = isset($request->status_id) ? $query->where('status_id' , $request->status_id)->get(): $query->get();

        $status = Status::active()->withCount('orders')->get();

        $active = isset($request->status_id) ? Status::find($request->status_id) : collect(['hex' => '36b9cc' , 'title' => 'All']);

        return view('admin.order.grid', compact('data', 'status', 'active'));
    }

    public function detail($id)
    {
        $order_detail = DB::table('orders')->where('id',$id)->first();
        $product_list = DB::table('order_details')->where('order_id',$id)->get();
        $modifier_list = DB::table('order_modifiers')->where('order_id', $id)->get();
        return view('admin.order.detail', compact('order_detail','product_list', 'modifier_list'));
    }

    public function invoice($id)
    {
        $g_setting = DB::table('general_settings')->where('id', 1)->first();
        $order_detail = DB::table('orders')->where('id',$id)->first();
        $product_list = DB::table('order_details')->where('order_id',$id)->get();
        $modifier_list = DB::table('order_modifiers')->where('order_id', $id)->get();
        return view('admin.order.invoice', compact('order_detail','product_list','modifier_list','g_setting'));
    }

    public function invoice_thermal($id)
    {
        $g_setting = DB::table('general_settings')->where('id', 1)->first();
        $order_detail = DB::table('orders')->where('id',$id)->first();
        $product_list = DB::table('order_details')->where('order_id',$id)->get();
        $modifier_list = DB::table('order_modifiers')->where('order_id', $id)->get();
        return view('admin.order.invoice_thermal', compact('order_detail','product_list','modifier_list','g_setting'));
    }

    public function destroy($id)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        DB::table('orders')->where('id', $id)->delete();
        DB::table('order_details')->where('order_id', $id)->delete();
        DB::table('order_modifiers')->where('order_id', $id)->delete();

        return Redirect()->back()->with('success', 'Order is deleted successfully!');
    }

    public function status_change(Request $request, $id)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $order = Order::find($id);

        if (!isset($order)) {
            return back()->with('error', 'No souch order found');
        }

        $request->validate(['status_id' => 'required']);

        $order->update(['status_id' => $request->get('status_id')]);

        return back()->with('success', 'Status updated successfully!');
    }

    public function order_chat($id)
    {
        $data = DB::table('orders_chat')->where('order_id', $id)->get();

        $order = Order::findOrFail($id);
        if (!isset($order))
        {
            return back()->with('error', 'No order found');
        }
        $order_number = $order->order_no;

        return view('admin.order.chat', compact('data', 'order_number', 'id'));
    }

    public function store_order_chat(Request $request)
    {
        try {

            $data = $request->validate([
                'order_id' => 'required',
                'msg' => 'required'
            ]);

            $data['username'] = session()->get('name', 'Guest Admin');
            $data['from'] = 'admin';
            $data['order_id'] = decrypt($request->get('order_id'));

            DB::table('orders_chat')->insert($data);

            return back()->with('success', 'Message is sent successfully');

        } catch (\Exception $e) {

            return back()->with('error', 'There is an error in sending message like '. $e->getMessage());
        }
    }
}
