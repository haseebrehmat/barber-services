<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;

class CandidateController extends Controller
{

    public function index()
    {
        $data = Candidate::all();
        return view('admin.candidates.index', compact('data'));
    }
}
