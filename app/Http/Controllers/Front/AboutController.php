<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AboutController extends Controller
{
    public function index()
    {


        $sliders = DB::table('sliders')->where('page','about_us')->get();
    	$page_home = DB::table('page_home_items')->where('id',1)->first();
    	$why_choose_items = DB::table('why_choose_items')->get();
    	$services = DB::table('services')->get();
    	$testimonials = DB::table('testimonials')->get();
    	$projects = DB::table('projects')->get();
    	$team_members = DB::table('team_members')->get();
    	$blogs = DB::table('blogs')->get();
		$theme_color = DB::table('general_settings')->first();



        $g_setting = DB::table('general_settings')->where('id', 1)->first();
        $about = DB::table('page_about_items')->where('id', 1)->first();
        return view('pages.about', compact('about','g_setting','sliders','page_home','why_choose_items','services', 'testimonials','projects','team_members','blogs','theme_color'));
    }
}
