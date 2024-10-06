<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VideoConferenceController extends Controller
{
   public function index(){
 
    $data = DB::table('video_conferences')
            ->where('user_id',session('id'))   
            ->get();
        
        return view('admin.video_conferences.index', compact('data'));
   }

   public function video_conference_destroy($id){
  
    if(env('PROJECT_MODE') == 0) {
        return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
    }

    DB::table('video_conferences')
    ->where('id', $id)
    ->delete();

    return Redirect()->back()->with('success', 'Conference  deleted successfully!');
   }


   public function video_conference_create(){
    return view('admin.video_conferences.create');
   }

   public function video_conference_store(Request $request){
    // Generate a 15-character random string
    $randomString = Str::random(15);

    // Create the link by combining the base URL and the random string
    $link = 'https://meet.jit.si/' . $randomString;

    // Save the title and link in the database
    DB::table('video_conferences')->insert([
        'title' => $request->title,
        'link' => $link,
        'user_id' => session('id'),
    ]);

    // Optionally, you can redirect back with a success message
    return redirect('admin/video/conference')->with('success', 'Video conference created successfully!');
   }


   public function video_conference_start($id){
    $data = DB::table('video_conferences')
            ->where('id',$id)   
            ->first();
     
    $link = Str::after($data->link, 'https://meet.jit.si/');

    return view('admin.video_conferences.start_meeting', compact('link'));
       

   }










}
