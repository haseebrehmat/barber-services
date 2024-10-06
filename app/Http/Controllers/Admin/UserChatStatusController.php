<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserChatStatus;
use Illuminate\Http\Request;

class UserChatStatusController extends Controller
{
    public function index()
    {
        $data = UserChatStatus::active()->get();
        return view('admin.user_chat_status.index', compact('data'));
    }

    public function store(Request $request)
    {
        
        $data = $request->validate([
            'title' => 'required|max:250|unique:user_chat_statuses,title',
            'hex' => 'required|alpha_dash'
        ]);

        UserChatStatus::create($data);

        return back()->with('success', 'Status is created successfully!');
    }

    public function update(Request $request, UserChatStatus $user_chat_status)
    {
       
        $data = $request->validate([
            'title' => 'required|max:250|unique:user_chat_statuses,title,' . $user_chat_status->id,
            'hex' => 'required|alpha_dash'
        ]);
        
        $user_chat_status->update($data);

        return back()->with('success', 'Status is updated successfully!');
    }

    public function destroy(UserChatStatus $user_chat_status)
    {
       

        $user_chat_status->deleteOrFail();

        return back()->with('success', 'Status is deleted successfully!');
    }
}
