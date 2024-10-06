<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\Variant;
use Illuminate\Http\Request;

class VariantController extends Controller
{

    public function index()
    {
        $data = Variant::all();
        return view('admin.product_variant.index', compact('data'));
    }

    public function create()
    {
        return view('admin.product_variant.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255|unique:variants,name',
            'options' => [
                'required',
                'array',
                'min:1',
                function ($attribute, $value, $fail) {
                    foreach ($value as $index => $option) {
                        $position = $index + 1;
                        if (empty($option) && $option !== 0) {
                            $fail("The option at position {$position} is empty or null.");
                        }
                        if (preg_match('/[^A-Za-z0-9\s]/', $option)) {
                            $fail("The option at position {$position} contains empty space or tabs or special characters.");
                        }
                    }
                }
            ],
        ]);
        Variant::create($data);
        return redirect()->route('admin.variant.index')->with('success', 'Variant added successfully');
    }

    public function edit(Variant $variant)
    {
        return view('admin.product_variant.edit')->with('variant', $variant);
    }

    public function update(Request $request, Variant $variant)
    {
        $data = $request->validate([
            'name' => 'required|max:255|unique:variants,name,' . $variant->id,
            'options' => [
                'required',
                'array',
                'min:1',
                function ($attribute, $value, $fail) {
                    foreach ($value as $index => $option) {
                        $position = $index + 1;
                        if (empty($option) && $option !== 0) {
                            $fail("The option at position {$position} is empty or null.");
                        }
                        if (preg_match('/[^A-Za-z0-9\s]/', $option)) {
                            $fail("The option at position {$position} contains empty space or tabs or special characters.");
                        }
                    }
                }
            ],
        ]);
        $variant->update($data);
        return redirect()->route('admin.variant.index')->with('success', 'Variant updated successfully');
    }

    public function destroy(Variant $variant)
    {
        $variant->delete();
        return back()->with('success', 'Variant deleted successfully');
    }
}
