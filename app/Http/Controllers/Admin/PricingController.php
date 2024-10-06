<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Pricing;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function index()
    {
        $data = Pricing::all();
        return view('admin.pricing.index', compact('data'));
    }

    public function create()
    {
        return view('admin.pricing.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:250',
            'subtitle' => 'required|max:250',
            'currency' => 'required|max:10',
            'price' => 'required|numeric',
            'format' => 'required|in:monthly,yearly,hourly,weekly',
            'features' => 'required|array',
            'features.*' => 'required|max:100',
            'tick_cross' => 'required|array',
            'tick_cross.*' => 'required|max:100'
        ]);

        Pricing::create($data);
        return redirect()->route('admin.pricing.index')->with('success', 'Pricing Option is added successfully!');
    }

    public function edit(Pricing $pricing)
    {
        return view('admin.pricing.edit', compact('pricing'));
    }

    public function update(Request $request, Pricing $pricing)
    {
        $data = $request->validate([
            'title' => 'required|max:250',
            'subtitle' => 'required|max:250',
            'currency' => 'required|max:10',
            'price' => 'required|numeric',
            'format' => 'required|in:monthly,yearly,hourly,weekly',
            'features' => 'required|array',
            'features.*' => 'required|max:100',
            'tick_cross' => 'required|array',
            'tick_cross.*' => 'required|max:100'
        ]);

        $pricing->update($data);
        return redirect()->route('admin.pricing.index')->with('success', 'Pricing Option is updated successfully!');
    }

    public function destroy(Pricing $pricing)
    {
        $pricing->delete();
        return redirect()->route('admin.pricing.index')->with('success', 'Pricing Option is deleted successfully!');
    }
}
