<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\CouponDesign;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;


class CouponDesignController extends Controller
{
    public function index()
    {
        $designs = CouponDesign::unmodified()->get();
        $modified_designs = CouponDesign::modified()->get();
        return view('admin.coupon_design.index', compact('designs', 'modified_designs'));
    }

    public function create()
    {
        return view('admin.coupon_design.create');
    }

    public function store(Request $request)
    {
        if (env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }
        $data = $this->request_validate($request);
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->upload_thumbnail($request);
        }
        CouponDesign::create($data);
        return redirect()->route('admin.coupon_design.index')->with('success', 'Coupon Design is created successfully!');
    }

    public function show($id)
    {
        try {
            $decrypted = base64_decode(hex2bin($id));
            $coupon = CouponDesign::find($decrypted);
            return view('admin.coupon_design.show', compact('coupon'));
        } catch (Exception $e) {
            return abort(404, $e->getMessage());
        }
    }

    public function edit(CouponDesign $couponDesign)
    {
        return view('admin.coupon_design.edit')->with('design', $couponDesign);
    }

    public function update(Request $request, CouponDesign $couponDesign)
    {
        if (env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }
        $data = $this->request_validate($request, $couponDesign->id);
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->upload_thumbnail($request);
        }
        $couponDesign->update($data);
        return redirect()->route('admin.coupon_design.index')->with('success', 'Coupon Design is updated successfully!');
    }

    public function destroy(CouponDesign $couponDesign)
    {
        $couponDesign->delete();
        return redirect()->route('admin.coupon_design.index')->with('success', 'Coupon Design is deleted successfully!');
    }

    public function modify(CouponDesign $couponDesign)
    {
        return view('admin.coupon_design.modify')->with('design', $couponDesign);
    }

    public function store_modified(Request $request, CouponDesign $couponDesign)
    {
        if (env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }
        $data = $this->request_validate($request);

        $newCouponDesign = $couponDesign->replicate();
        $newCouponDesign->content = $data['content'];
        $newCouponDesign->title = $data['title'];
        $newCouponDesign->modified_by = session('id');
        $newCouponDesign->expired_at = $data['expired_at'];
        $newCouponDesign->save();

        session(['tab' => 'modified']);

        return redirect()->route('admin.coupon_design.index')->with('success', 'Coupon Design is saved as your design successfully!');
    }

    private function request_validate(Request $request, $id = null)
    {
        $data = $request->validate([
            'content' => 'required',
            'title' => 'required',
            'thumbnail' => 'sometimes|mimes:jpg,jpeg,png|max:5000',
            'expired_at' => 'sometimes|date',
            'code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('coupon_designs', 'code')->ignore($id),
            ],
            'type' => 'nullable|in:percentage,amount',
            'value' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('type') === 'percentage' && ($value < 0 || $value > 100)) {
                        $fail('The ' . $attribute . ' must be between 0 and 100 when type is percentage.');
                    }
                    if ($request->input('type') === 'amount' && $value < 0) {
                        $fail('The ' . $attribute . ' must be a positive number when type is amount.');
                    }
                }
            ],
        ]);
        return $data;
    }
    private function upload_thumbnail(Request $request)
    {
        $ext = $request->file('thumbnail')->extension();
        $final_name = 'thumbnail_' . time() . '.' . $ext;
        $request->file('thumbnail')->move(public_path('uploads'), $final_name);
        return $final_name;
    }
}
