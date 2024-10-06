<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\PageHomeItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;

class PageHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function edit()
    {
        $page_home = PageHomeItem::where('id',1)->first();
        $record = DB::table('general_settings')->where('id', 1)->first();
        $assigned = isset($record) ? explode(',', $record->home_tools) : [];
        return view('admin.page_setting.page_home', compact('page_home', 'assigned'));
    }

    public function update1(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['seo_title'] = $request->input('seo_title');
        $data['seo_meta_description'] = $request->input('seo_meta_description');

        PageHomeItem::where('id',1)->update($data);
        return redirect()->back()->with('success', 'Home Page Meta Information is updated successfully!');
    }

    public function update2(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['why_choose_title'] = $request->input('why_choose_title');
        $data['why_choose_subtitle'] = $request->input('why_choose_subtitle');
        $data['why_choose_status'] = $request->input('why_choose_status');

        PageHomeItem::where('id',1)->update($data);
        return redirect()->back()->with('success', 'Why Choose Us Section is updated successfully!');
    }

    public function update3(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        if($request->hasFile('special_bg'))
        {
            $request->validate([
                'special_bg' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Unlink old photo
            // unlink(public_path('uploads/'.$request->input('current_photo')));

            // Uploading new photo
            $ext = $request->file('special_bg')->extension();
            $final_name = time().'.'.$ext;
            $request->file('special_bg')->move(public_path('uploads/'), $final_name);

            $data['special_bg'] = $final_name;
        }

        if($request->hasFile('special_video_bg'))
        {
            $request->validate([
                'special_video_bg' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Unlink old photo
            // unlink(public_path('uploads/'.$request->input('current_photo1')));

            // Uploading new photo
            $ext = $request->file('special_video_bg')->extension();
            $final_name = time().'.'.$ext;
            $request->file('special_video_bg')->move(public_path('uploads/'), $final_name);

            $data['special_video_bg'] = $final_name;
        }

        $data['special_title'] = $request->input('special_title');
        $data['special_subtitle'] = $request->input('special_subtitle');
        $data['special_content'] = $request->input('special_content');
        $data['special_btn_text'] = $request->input('special_btn_text');
        $data['special_btn_url'] = $request->input('special_btn_url');
        $data['special_yt_video'] = $request->input('special_yt_video');
        $data['special_status'] = $request->input('special_status');

        PageHomeItem::where('id',1)->update($data);
        return redirect()->back()->with('success', 'Special Section is updated successfully!');
    }

    public function update4(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['service_title'] = $request->input('service_title');
        $data['service_subtitle'] = $request->input('service_subtitle');
        $data['service_status'] = $request->input('service_status');

        PageHomeItem::where('id',1)->update($data);
        return redirect()->back()->with('success', 'Service Section is updated successfully!');
    }


    public function update5(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        if($request->hasFile('testimonial_bg'))
        {
            $request->validate([
                'testimonial_bg' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Unlink old photo
            // unlink(public_path('uploads/'.$request->input('current_photo')));

            // Uploading new photo
            $ext = $request->file('testimonial_bg')->extension();
            $final_name = time().'.'.$ext;
            $request->file('testimonial_bg')->move(public_path('uploads/'), $final_name);

            $data['testimonial_bg'] = $final_name;
        }

        $data['testimonial_title'] = $request->input('testimonial_title');
        $data['testimonial_subtitle'] = $request->input('testimonial_subtitle');
        $data['testimonial_status'] = $request->input('testimonial_status');

        PageHomeItem::where('id',1)->update($data);
        return redirect()->back()->with('success', 'Testimonial Section is updated successfully!');
    }

    public function update6(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['project_title'] = $request->input('project_title');
        $data['project_subtitle'] = $request->input('project_subtitle');
        $data['project_status'] = $request->input('project_status');

        PageHomeItem::where('id',1)->update($data);
        return redirect()->back()->with('success', 'Project Section is updated successfully!');
    }

    public function update7(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['team_member_title'] = $request->input('team_member_title');
        $data['team_member_subtitle'] = $request->input('team_member_subtitle');
        $data['team_member_status'] = $request->input('team_member_status');

        PageHomeItem::where('id',1)->update($data);
        return redirect()->back()->with('success', 'Team Member Section is updated successfully!');
    }

    public function update8(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        if($request->hasFile('appointment_bg'))
        {
            $request->validate([
                'appointment_bg' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Unlink old photo
            // unlink(public_path('uploads/'.$request->input('current_photo')));

            // Uploading new photo
            $ext = $request->file('appointment_bg')->extension();
            $final_name = time().'.'.$ext;
            $request->file('appointment_bg')->move(public_path('uploads/'), $final_name);

            $data['appointment_bg'] = $final_name;
        }

        $data['appointment_title'] = $request->input('appointment_title');
        $data['appointment_text'] = $request->input('appointment_text');
        $data['appointment_btn_text'] = $request->input('appointment_btn_text');
        $data['appointment_btn_url'] = $request->input('appointment_btn_url');
        $data['appointment_status'] = $request->input('appointment_status');

        PageHomeItem::where('id',1)->update($data);
        return redirect()->back()->with('success', 'Appointment Section is updated successfully!');
    }

    public function update9(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['latest_blog_title'] = $request->input('latest_blog_title');
        $data['latest_blog_subtitle'] = $request->input('latest_blog_subtitle');
        $data['latest_blog_status'] = $request->input('latest_blog_status');

        PageHomeItem::where('id',1)->update($data);
        return redirect()->back()->with('success', 'Latest Blog Section is updated successfully!');
    }

    public function update10(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        if($request->hasFile('newsletter_bg'))
        {
            $request->validate([
                'newsletter_bg' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Unlink old photo
            // unlink(public_path('uploads/'.$request->input('current_photo')));

            // Uploading new photo
            $ext = $request->file('newsletter_bg')->extension();
            $final_name = time().'.'.$ext;
            $request->file('newsletter_bg')->move(public_path('uploads/'), $final_name);

            $data['newsletter_bg'] = $final_name;
        }

        $data['newsletter_title'] = $request->input('newsletter_title');
        $data['newsletter_text'] = $request->input('newsletter_text');
        $data['newsletter_status'] = $request->input('newsletter_status');

        PageHomeItem::where('id',1)->update($data);
        return redirect()->back()->with('success', 'Newsletter Section is updated successfully!');
    }

    public function update11(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['pricing_title'] = $request->input('pricing_title');
        $data['pricing_subtitle'] = $request->input('pricing_subtitle');
        $data['pricing_status'] = $request->input('pricing_status');

        PageHomeItem::where('id', 1)->update($data);
        return redirect()->back()->with('success', 'Pricing Section is updated successfully!');
    }
    public function update12(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['tools_status'] = $request->input('tools_status');
        $data['tools_title'] = $request->input('tools_title');
        $data['tools_subtitle'] = $request->input('tools_subtitle');
        $tools['home_tools'] = isset($request['home_tools']) ? implode(',', $request->input('home_tools')) : '';

        PageHomeItem::where('id', 1)->update($data);
        DB::table('general_settings')->where('id', 1)->update($tools);

        return redirect()->back()->with('success', 'Tools Section is updated successfully!');
    }

    public function update13(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['audio_title'] = $request->input('audio_title');
        $data['audio_subtitle'] = $request->input('audio_subtitle');
        $data['audio_status'] = $request->input('audio_status');

        PageHomeItem::where('id',1)->update($data);
        return redirect()->back()->with('success', 'Audio Section is updated successfully!');
    }

    public function update14(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['podcast_title'] = $request->input('podcast_title');
        $data['podcast_subtitle'] = $request->input('podcast_subtitle');
        $data['podcast_status'] = $request->input('podcast_status');

        PageHomeItem::where('id',1)->update($data);
        return redirect()->back()->with('success', 'Podcast Section is updated successfully!');
    }

}
