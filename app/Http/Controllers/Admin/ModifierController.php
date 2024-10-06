<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Modifier;
use Illuminate\Http\Request;

class ModifierController extends Controller
{
    public function index()
    {
        $data = Modifier::all();
        return view('admin.product_modifier.index', compact('data'));
    }

    public function add_modifier_to_cart(Request $request)
    {
        $modifier_qtys = [];
        $modifier_ids = [];
        if (!is_null($request['modifier_ids'])) {
            $modifier_ids = explode(",", $request['modifier_ids']);
            $session_modifier_qtys = session()->get('modifiers_qtys', []);
            foreach ($modifier_ids as $value) {
                $modifier_qtys[$value] = isset($session_modifier_qtys[$value]) ? $session_modifier_qtys[$value] : 1;
            }
        }
        session()->put('modifiers_added', $modifier_ids);
        session()->put('modifiers_qtys', $modifier_qtys);
        return back()->with('success', empty($modifier_ids)
            ? 'No Modifiers is added to the cart. Please select an modifier!'
            : 'Modifiers added to cart');
    }

    public function update_modifier_qtys(Request $request)
    {
        $modifier_qtys = $request->get('modifier_qtys', []);
        session()->put('modifiers_qtys', $modifier_qtys);
        return back()->with('success', 'Modifiers quantities updated successfully!');
    }

    public function create()
    {
        return view('admin.product_modifier.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:225|unique:modifiers,name',
            'unit_price' => 'required|numeric',
            'thumbnail' => 'sometimes|mimes:png,jpg,jpeg'
        ]);
        Modifier::create($data);
        return redirect()->route('admin.modifier.index')->with('success', 'Modifier created successfully');
    }

    public function edit(Modifier $modifier)
    {
        return view('admin.product_modifier.edit', compact('modifier'));
    }

    public function update(Request $request, Modifier $modifier)
    {
        $data = $request->validate([
            'name' => 'required|max:225|unique:modifiers,name,' . $modifier->id,
            'unit_price' => 'required|numeric',
            'thumbnail' => 'sometimes|mimes:png,jpg,jpeg'
        ]);
        $modifier->update($data);
        return redirect()->route('admin.modifier.index')->with('success', 'Modifier updated successfully');
    }

    public function destroy(Modifier $modifier)
    {
        // Delete file before delete
        if ($modifier->thumbnail) {
            $file_path = public_path('uploads/') . $modifier->thumbnail;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        $modifier->products()->detach();
        $modifier->delete();
        return back()->with('success', 'Modifier deleted successfully');
    }
}
