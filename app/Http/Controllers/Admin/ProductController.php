<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\GeneralSetting;
use App\Models\Admin\Modifier;
use App\Models\Admin\PageShopItem;
use App\Models\Admin\Menu;
use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $product = Product::all();
        return view('admin.product.index', compact('product'));
    }

    public function tables()
    {
        $tables = DB::table('tables')->get();

        return view('admin.product.tables', compact('tables'));
    }

    public function table_store(Request $request)
    {
        DB::table('tables')->insert([
            'name' => $request->name,
        ]);
        return redirect()->back()->with('success', 'Table added successfully!');
    }

    public function table_destroy($id)
    {
        DB::table('tables')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Table deleted successfully!');
    }



    public function create()
    {
        $productCategory = ProductCategory::all();
        return view('admin.product.create', compact('productCategory'));
    }

    public function store(Request $request)
    {
        if (env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $product = new Product();
        $data = $request->only($product->getFillable());

        $request->validate([
            'product_name' => 'required',
            'product_slug' => 'unique:products',
            'product_current_price' => 'required',
            'product_stock' => 'required',
            'product_content' => 'required',
            'product_content_short' => 'required',
            'product_featured_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_category_id' => 'required',
        ]);

        if (empty($data['product_slug'])) {
            $data['product_slug'] = Str::slug($request->product_name);
        }

        $statement = DB::select("SHOW TABLE STATUS LIKE 'products'");
        $ai_id = $statement[0]->Auto_increment;

        $ext = $request->file('product_featured_photo')->extension();
        $final_name = time() . '.' . $ext;
        $request->file('product_featured_photo')->move(public_path('uploads/'), $final_name);
        $data['product_featured_photo'] = $final_name;

        $product->fill($data)->save();
        return redirect()->route('admin.product.index')->with('success', 'Product is added successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $productCategory = ProductCategory::all();
        return view('admin.product.edit', compact('product', 'productCategory'));
    }

    public function update(Request $request, $id)
    {
        if (env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $product = Product::findOrFail($id);
        $data = $request->only($product->getFillable());

        if ($request->hasFile('product_featured_photo')) {
            $request->validate([
                'product_name' => 'required',
                'product_slug' => [
                    Rule::unique('products')->ignore($id),
                ],
                'product_current_price' => 'required',
                'product_stock' => 'required',
                'product_content' => 'required',
                'product_content_short' => 'required',
                'product_featured_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'product_category_id' => 'required',
            ]);
            // unlink(public_path('uploads/'.$product->product_featured_photo));
            $ext = $request->file('product_featured_photo')->extension();
            $final_name = time() . '.' . $ext;
            $request->file('product_featured_photo')->move(public_path('uploads/'), $final_name);
            $data['product_featured_photo'] = $final_name;
        } else {
            $request->validate([
                'product_name' => 'required',
                'product_slug' => [
                    Rule::unique('products')->ignore($id),
                ],
                'product_current_price' => 'required',
                'product_stock' => 'required',
                'product_content' => 'required',
                'product_content_short' => 'required',
            ]);
            $data['product_featured_photo'] = $product->product_featured_photo;
        }

        if (empty($data['product_slug'])) {
            unset($data['product_slug']);
            $data['product_slug'] = Str::slug($request->product_name);
        }

        $product->fill($data)->save();
        return redirect()->route('admin.product.index')->with('success', 'Product is updated successfully!');
    }

    public function destroy($id)
    {
        if (env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $product = Product::findOrFail($id);
        $product->modifiers()->detach();
        // unlink(public_path('uploads/'.$product->product_featured_photo));
        $product->delete();
        return Redirect()->back()->with('success', 'Product is deleted successfully!');
    }

    public function qrcode()
    {
        $shop_hidden = Menu::where('menu_key', 'Shop')->value('menu_status') != 'Show';
        return view('admin.shop.qrcode', compact('shop_hidden'));
    }

    public function settings()
    {
        $general_setting = GeneralSetting::where('id',1)->first();
        $shop = DB::table('page_shop_items')->where('id', 1)->first();
        return view('admin.shop.settings', compact('general_setting','shop'));
    }

    public function save_settings(Request $request)
    {

        $general_setting = GeneralSetting::where('id', 1)->first();

        $data = $request->validate([
            'shop_heading' => 'sometimes|max:250',
            'shop_title' => 'sometimes|max:250',
            'shop_subtitle' => 'sometimes|max:1500',
            'reservation_text' => 'sometimes|max:250',
        ]);

        if ($request->reservation_status == 'on') {
            $data['reservation_status'] = 'true';
        } else {
            $data['reservation_status'] = 'false';
        }


        $general_setting->update($data);


        $shop = PageShopItem::where('id', 1)->first();
        $shop->category_text_color=$request->category_text_color;
        $shop->category_background_color=$request->category_background_color;
        $shop->active_category_text_color=$request->active_category_text_color;
        $shop->	active_category_background_color=$request->	active_category_background_color;
        if ($request->rounded_images=='on') {
            $shop->rounded_images='true';
        }else{
            $shop->rounded_images='false';
        }
        $shop->update();


        if (isset($request['logo']))
        {
            // Unlink old photo
            // unlink(public_path('uploads/'.$request->current_photo));

            // Uploading new photo

            $ext = $request->file('logo')->extension();
            $final_name = time().'.'.$ext;
            $request->file('logo')->move(public_path('uploads/'), $final_name);

            $data['logo_shop'] = $final_name;
        }

        $data['logo_shop_width'] = $request->logo_shop_width;
        $data['logo_shop_height'] = $request->logo_shop_height;

        GeneralSetting::where('id',1)->update($data);


        return Redirect()->back()->with('success', 'Shop Settings is saved successfully!');
    }

    public function product_variants(Product $product)
    {
        $variants = Variant::all();
        return view('admin.product.variants', compact('product', 'variants'));
    }

    public function save_product_variants(Request $request, Product $product)
    {
        $data = $request->validate([
            'variant_id' => 'required|numeric',
            'variant_options' => 'required|array',
        ]);
        $product->update($data);
        return redirect()->route('admin.product.index')->with('success', 'Variants to Product is saved successfully!');
    }

    public function product_modifiers(Product $product)
    {
        $modifiers = Modifier::all();
        return view('admin.product.modifiers', compact('product', 'modifiers'));
    }

    public function save_product_modifiers(Request $request, Product $product)
    {
        $data = $request->validate([
            'modifier_ids' => 'required|array',
        ]);
        $product->modifiers()->sync($data['modifier_ids']);
        return redirect()->route('admin.product.index')->with('success', 'Modifiers to Product are saved successfully!');
    }
}
