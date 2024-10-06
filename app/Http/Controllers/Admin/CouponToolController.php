<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\CouponTool;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;

class CouponToolController extends Controller
{
    public function __construct()
    {
        // $this->middleware('admin');
    }

    public function index(){
        $coupons = CouponTool::all();
        return view('admin.coupon_tools.index', compact('coupons'));
    }

    public function store(Request $request){
        $coupon = new CouponTool();
        $data = $request->only($coupon->getFillable());
        
        $request->validate([
            'title' => 'required',
            'valid_till' => 'required',
        ]);
        $data['secret']=Str::random(15);
        
        if (isset($request['image']))
        {
            $ext = $request->file('image')->extension();
            $final_name = time().'.'.$ext;
            $request->file('image')->move(public_path('uploads/'), $final_name);

            $data['image']=$final_name;
        }
        if (isset($request['logo']))
        {
            $ext = $request->file('logo')->extension();
            $final_name = time().'logo.'.$ext;
            $request->file('logo')->move(public_path('uploads/'), $final_name);

            $data['logo']=$final_name;
        }
        

        $coupon->fill($data)->save();
        return redirect()->back()->with('success', 'Coupon is added successfully!');
    }

    public function update(Request $request, CouponTool $coupon)
    {
        
        // $data = $request->validate([
        //     'title' => 'required,' . $coupon->id,
        // ]);
        

        $to_update=CouponTool::where('id',$coupon->id)->first();
        $to_update->title=$request->title;
        $to_update->valid_till=$request->valid_till;
        $to_update->hex=$request->hex;
        if (isset($request['image']))
        {
            $ext = $request->file('image')->extension();
            $final_name = time().'.'.$ext;
            $request->file('image')->move(public_path('uploads/'), $final_name);

            $to_update->image=$final_name;
        }
        if (isset($request['logo']))
        {
            $ext = $request->file('logo')->extension();
            $final_name = time().'logo.'.$ext;
            $request->file('logo')->move(public_path('uploads/'), $final_name);

            $to_update->logo=$final_name;
        }


        $to_update->save();

        return back()->with('success', 'Coupon is updated successfully!');
    }

    public function view($secret){
        $coupon=CouponTool::where('secret',$secret)->first();
        $g_setting = DB::table('general_settings')->first(); 
        
        return view('admin.coupon_tools.view', compact('coupon','g_setting'));
    }
    

    
    public function destroy(CouponTool $coupon)
    {
       

        $coupon->deleteOrFail();

        return back()->with('success', 'Coupon is deleted successfully!');
    }



}
