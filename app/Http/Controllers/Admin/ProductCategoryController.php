<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');

        if (env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }
    }

    public function index()
    {
        $productCategory = ProductCategory::all();
        return view('admin.product_category.index', compact('productCategory'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|max:500',
                'description' => 'required|max:1000',
            ]);
            ProductCategory::create($data);
            return back()->with('success', 'Product Category is added successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something Gone Wrong in creation of product category! ' . $e->getMessage());
        }
    }

    public function edit(ProductCategory $productCategory)
    {
        return view('admin.product_category.edit', compact('productCategory'));
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        try {
            $data = $request->validate([
                'name' => 'required|max:500',
                'description' => 'required|max:1000',
            ]);
            $productCategory->update($data);
            return back()->with('success', 'Product Category is updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something Gone Wrong in updation of product category! ' . $e->getMessage());
        }
    }

    public function destroy(ProductCategory $productCategory)
    {
        try {
            $productCategory->delete();
            return back()->with('success', 'Product Category is deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something Gone Wrong in deletion of product category! ' . $e->getMessage());
        }
    }
}
