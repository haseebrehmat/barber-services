<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $data = Tag::all();

        return view('admin.tags.index', compact('data'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:250',
            'description' => 'sometimes',
        ]);

        Tag::create($data);

        return redirect()->route('admin.tag.index')->with('success', 'Tag is created successfully');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit')->with('data', $tag);
    }

    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate([
            'name' => 'required|max:250',
            'description' => 'sometimes',
        ]);

        $tag->update($data);

        return redirect()->route('admin.tag.index')->with('success', 'Tag is updated successfully');
    }

    public function destroy(Tag $tag)
    {
        $tag->recipients()->detach();
        $tag->delete();

        return redirect()->route('admin.tag.index')->with('success', 'Tag is deleted successfully');
    }
}
