<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\Admin\EmployeeChat;
use App\Models\Admin\CustomerChat;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function employees_chat(Request $request)
    {
        // List of employees which have chats
        $employeeIds = EmployeeChat::distinct('employee_id')->pluck('employee_id');
        $users = Admin::whereIn('id', $employeeIds)->get();

        if (isset($request->id)) {

            $id = Crypt::decrypt($request->id);
            $employee = Admin::find($id);

            if (!isset($employee)) {
                return back()->with('error', 'No such employee found with this ID');
            }

            $messages = EmployeeChat::where('employee_id', $id)->get();
        } else {
            // Latest Chat with Emplopyee
            $latestEmployeeId = EmployeeChat::latest('id')->value('employee_id');
            $messages = EmployeeChat::where('employee_id', $latestEmployeeId)->get();

            // Latest Employee
            $employee = Admin::find($latestEmployeeId);
        }
        
        return view('admin.chat.with_employees', compact('messages', 'users', 'employee'));
    }

    public function customers_chat(Request $request)
    {
        // List of customers which have chats
        $customerIds = CustomerChat::distinct('customer_id')->pluck('customer_id');
        $users = Customer::whereIn('id', $customerIds)->get();

        if (isset($request->id)) {

            $id = Crypt::decrypt($request->id);
            $customer = Customer::find($id);

            if (!isset($customer)) {
                return back()->with('error', 'No such customer found with this ID');
            }

            $messages = CustomerChat::where('customer_id', $id)->get();
        } else {
            // Latest Chat with Emplopyee
            $latestCustomerId = CustomerChat::latest('id')->value('customer_id');
            $messages = CustomerChat::where('customer_id', $latestCustomerId)->get();

            // Latest Customer
            $customer = Customer::find($latestCustomerId);
        }

        return view('admin.chat.with_customers', compact('messages', 'users', 'customer'));
    }

    public function create(Request $request)
    {
        $type = Crypt::decrypt($request->type);

        if (!in_array($type, ['employee', 'customer'])) {
            return back()->with('error', 'There is something wrong while loading message box');
        }

        $users = $type === 'employee' ? Admin::where([['is_super', '=', 0], ['id', '!=', session('id')]])->get() : Customer::all();

        return view('admin.chat.new_message', compact('users', 'type'));
    }

    public function store(Request $request)
    {
        $type = Crypt::decrypt($request->type);

        if (!in_array($type, ['employee', 'customer'])) {
            return back()->with('error', 'There is something wrong while loading saving messages');
        }

        if ($type == 'employee') {
            $data = $request->validate([
                'sent_by' => 'required|in:admin,employee',
                'employee_id' => 'required',
                'msg' => 'required'
            ]);

            EmployeeChat::create($data);


            $route = $data['sent_by'] == 'admin' ? 'admin.employees.chat' : 'admin.employee.chat';

        } else {
            $data = $request->validate([
                'sent_by' => 'required|in:admin,customer',
                'customer_id' => 'required',
                'msg' => 'required'
            ]);

            CustomerChat::create($data);

            $route = $data['sent_by'] == 'admin' ? 'admin.customers.chat' : 'customer.chat';
        }

        return redirect()->route($route)->with('success', 'Message sent successfully');
    }

    public function employee_chat()
    {
        $id = session('id');
        $employee = Admin::find($id);

        if (!isset($employee)) {
            return back()->with('error', 'No such employee found with this ID');
        }

        $messages = EmployeeChat::where('employee_id', $id)->get();

        return view('admin.chat.employee', compact('employee', 'messages'));
    }

    public function customer_chat()
    {
        $id = session()->get('customer_id');
        $customer = Customer::where('id', $id)->first();

        if (!isset($customer)) {
            return back()->with('error', 'No such customer found with this ID');
        }

        $messages = CustomerChat::where('customer_id', $id)->get();

        $g_setting = DB::table('general_settings')->where('id', 1)->first();
        
        return view('customer.pages.chat', compact('customer', 'messages', 'g_setting'));
    }


}
