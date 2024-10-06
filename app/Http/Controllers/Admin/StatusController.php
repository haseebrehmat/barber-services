<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index()
    {
        $data = Status::active()->withCount('orders')->get();
        return view('admin.status.index', compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:250|unique:status,title',
            'hex' => 'required|alpha_dash'
        ]);

        Status::create($data);

        return back()->with('success', 'Status is created successfully!');
    }

    public function update(Request $request, Status $status)
    {
        $data = $request->validate([
            'title' => 'required|max:250|unique:status,title,' . $status->id,
            'hex' => 'required|alpha_dash'
        ]);

        $status->update($data);

        return back()->with('success', 'Status is updated successfully!');
    }

    public function destroy(Status $status)
    {
        if ($status->orders->count() > 0) {

            return back()->with('error', 'This Status cannot be deleted because of some orders are underlying this status! Please remove or change status of these orders to delete this status!');
        }

        $status->deleteOrFail();

        return back()->with('success', 'Status is deleted successfully!');
    }
}
