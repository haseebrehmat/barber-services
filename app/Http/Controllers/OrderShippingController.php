<?php

namespace App\Http\Controllers;

use App\Models\OrderShipping;
use Illuminate\Http\Request;

class OrderShippingController extends Controller
{
    public function index()
    {
        $shippings = OrderShipping::all();
        return view('admin.order_shipping.index', compact('shippings'));
    }

    public function create()
    {
        return view('admin.order_shipping.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'pdf' => 'sometimes|mimes:pdf|max:6000'
        ]);
        $data = $request->all();
        if ($request->hasFile('pdf')) {
            $ext = $request->file('pdf')->extension();
            $final_name = time() . '.' . $ext;
            $request->file('pdf')->move(public_path('uploads'), $final_name);
            $data['pdf'] = $final_name;
        }
        OrderShipping::create($data);
        return redirect()->route('order_shipping.index')->with('success', 'Order Shipping is added successfully!');
    }

    public function edit(OrderShipping $orderShipping)
    {
       return view('admin.order_shipping.edit')->with('shipping', $orderShipping);
    }

    public function update(Request $request, OrderShipping $orderShipping)
    {
        $request->validate([
            'code' => 'required',
            'pdf' => 'sometimes|mimes:pdf|max:6000'
        ]);

        if ($request->hasFile('pdf')) {
            $ext = $request->file('pdf')->extension();
            $final_name = time() . '.' . $ext;
            $request->file('pdf')->move(public_path('uploads'), $final_name);
            $request['pdf'] = $final_name;
        }
        $orderShipping->update($request->all());
        return redirect()->route('order_shipping.index')->with('success', 'Order Shipping is updated successfully!');
    }

    public function destroy(OrderShipping $orderShipping)
    {
        $orderShipping->delete();
        return redirect()->route('order_shipping.index')->with('success', 'Order Shipping is deleted successfully!');
    }
}
