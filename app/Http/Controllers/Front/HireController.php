<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;
use DB;

class HireController extends Controller
{
    public function index()
    {
        $g_setting = DB::table('general_settings')->where('id', 1)->first();
        return view('pages.hire', compact('g_setting'));
    }

    public function add_candidate(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required',
            'email'   => 'required|email|unique:candidates,email',
            'phone'   => 'required',
            'message' => 'sometimes',
        ]);

        Candidate::create($data);

        return back()->withSuccess('We have received your application. We will get back to you soon.');
    }
}
