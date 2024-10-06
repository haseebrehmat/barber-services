<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Admin\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('customer');
    }

    public function index()
    {
        $g_setting = DB::table('general_settings')->where('id', 1)->first();
        return view('customer.pages.order', compact('g_setting'));
    }

    public function order_chat($id)
    {
        $g_setting = DB::table('general_settings')->where('id', 1)->first();
        $data = DB::table('orders_chat')->where('order_id', $id)->get();

        $order = Order::findOrFail($id);
        if (!isset($order))
        {
            return back()->with('error', 'No order found');
        }
        $order_number = $order->order_no;

        return view('customer.pages.order_chat', compact('g_setting', 'data', 'order_number', 'id'));
    }

    public function store_order_chat(Request $request)
    {
        try {

            $data = $request->validate([
                'order_id' => 'required',
                'msg' => 'required'
            ]);

            $data['username'] = session()->get('customer_name', 'Guest Customer');
            $data['from'] = 'customer';
            $data['order_id'] = decrypt($request->get('order_id'));

            DB::table('orders_chat')->insert($data);

            return back()->with('success', 'Message is sent successfully');

        } catch (\Exception $e) {
            
            return back()->with('error', 'There is an error in sending message like '. $e->getMessage());
        }
    }

}
