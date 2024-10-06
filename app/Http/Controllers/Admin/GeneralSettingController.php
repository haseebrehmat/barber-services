<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\GeneralSetting;
use App\Models\ToolText;
use App\Models\LandingPageContact;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use DB;
use Twilio\Rest\Client;
use Plivo\RestClient;
use Plivo\Resources\Message;

class GeneralSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin', ['except' => ['landing_page_contact','landingpages_view', 'landing_page_contact_save']]);
    }

    public function logo_edit()
    {
        $general_setting = GeneralSetting::where('id',1)->first();
        return view('admin.general_setting.logo', compact('general_setting'));
    }

    public function logo_update(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $request->validate([
            'logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo_width' => 'required|numeric|min:1',
            'logo_height' => 'required|numeric|min:1',
        ]);

        if (isset($request['logo']))
        {
            // Unlink old photo
            // unlink(public_path('uploads/'.$request->current_photo));

            // Uploading new photo
            $ext = $request->file('logo')->extension();
            $final_name = time().'.'.$ext;
            $request->file('logo')->move(public_path('uploads/'), $final_name);

            $data['logo'] = $final_name;
        }

        $data['logo_width'] = $request['logo_width'];
        $data['logo_height'] = $request['logo_height'];

        GeneralSetting::where('id',1)->update($data);

        return redirect()->back()->with('success', 'Logo is updated successfully!');

    }

    public function favicon_edit()
    {
        $general_setting = GeneralSetting::where('id',1)->first();
        return view('admin.general_setting.favicon', compact('general_setting'));
    }

    public function favicon_update(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $request->validate([
            'favicon' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Unlink old photo
        // unlink(public_path('uploads/'.$request->current_photo));

        // Uploading new photo
        $ext = $request->file('favicon')->extension();
        $final_name = time().'.'.$ext;
        $request->file('favicon')->move(public_path('uploads/'), $final_name);

        $data['favicon'] = $final_name;

        GeneralSetting::where('id',1)->update($data);

        return redirect()->back()->with('success', 'Favicon is updated successfully!');

    }


    public function loginbg_edit()
    {
        $general_setting = GeneralSetting::where('id',1)->first();
        return view('admin.general_setting.loginbg', compact('general_setting'));
    }

    public function loginbg_update(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $request->validate([
            'login_bg' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Unlink old photo
        // unlink(public_path('uploads/'.$request->current_photo));

        // Uploading new photo
        $ext = $request->file('login_bg')->extension();
        $final_name = time().'.'.$ext;
        $request->file('login_bg')->move(public_path('uploads/'), $final_name);

        $data['login_bg'] = $final_name;

        GeneralSetting::where('id',1)->update($data);

        return redirect()->back()->with('success', 'Login Background is updated successfully!');
    }



    public function topbar_edit()
    {
        $general_setting = GeneralSetting::where('id',1)->first();
        return view('admin.general_setting.topbar', compact('general_setting'));
    }

    public function topbar_update(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['top_bar_email'] = $request->get('top_bar_email');
        $data['top_bar_phone'] = $request->get('top_bar_phone');
        $data['top_bar_social_status'] = $request->get('top_bar_social_status');
        $data['top_bar_login_status'] = $request->get('top_bar_login_status');
        $data['top_bar_registration_status'] = $request->get('top_bar_registration_status');
        $data['top_bar_cart_status'] = $request->get('top_bar_cart_status');

        GeneralSetting::where('id',1)->update($data);

        return redirect()->back()->with('success', 'Top Bar Information is updated successfully!');
    }

    public function footer_edit()
    {
        $general_setting = GeneralSetting::where('id',1)->first();
        return view('admin.general_setting.footer', compact('general_setting'));
    }

    public function footer_update(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['footer_address'] = $request->get('footer_address');
        $data['footer_email'] = $request->get('footer_email');
        $data['footer_phone'] = $request->get('footer_phone');
        $data['footer_copyright'] = $request->get('footer_copyright');
        $data['footer_column1_heading'] = $request->get('footer_column1_heading');
        $data['footer_column2_heading'] = $request->get('footer_column2_heading');
        $data['footer_column3_heading'] = $request->get('footer_column3_heading');
        $data['footer_column4_heading'] = $request->get('footer_column4_heading');
        GeneralSetting::where('id',1)->update($data);

        return redirect()->back()->with('success', 'Footer Information is updated successfully!');
    }

    public function sidebar_edit()
    {
        $general_setting = GeneralSetting::where('id',1)->first();
        return view('admin.general_setting.sidebar', compact('general_setting'));
    }

    public function sidebar_update(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['sidebar_total_recent_post'] = $request->get('sidebar_total_recent_post');

        GeneralSetting::where('id',1)->update($data);

        return redirect()->back()->with('success', 'Sidebar Information is updated successfully!');
    }


    public function color_edit()
    {
        $general_setting = GeneralSetting::where('id',1)->first();
        return view('admin.general_setting.color', compact('general_setting'));
    }

    public function color_update(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['theme_color'] = $request->get('theme_color');
        $data['navbar_color'] = $request->get('navbar_color');
        $data['items_color'] = $request->get('items_color');
        $data['items_hover_color'] = $request->get('items_hover_color');
        $data['sub_items_bg_color'] = $request->get('sub_items_bg_color');
        $data['sub_items_hover_bg_color'] = $request->get('sub_items_hover_bg_color');

        GeneralSetting::where('id',1)->update($data);

        return redirect()->back()->with('success', 'Color is updated successfully!');
    }


    public function preloader_edit()
    {
        $general_setting = GeneralSetting::where('id',1)->first();
        return view('admin.general_setting.preloader', compact('general_setting'));
    }

    public function preloader_update(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        if($request->file('preloader_photo'))
        {
            $request->validate([
                'preloader_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Unlink old photo
            // unlink(public_path('uploads/'.$request->current_photo));

            // Uploading new photo
            $ext = $request->file('preloader_photo')->extension();
            $final_name = time().'.'.$ext;
            $request->file('preloader_photo')->move(public_path('uploads/'), $final_name);

            $data['preloader_photo'] = $final_name;
        }

        $data['preloader_status'] = $request->get('preloader_status');

        GeneralSetting::where('id',1)->update($data);

        return redirect()->back()->with('success', 'Preloader Information is updated successfully!');
    }


    public function stickyheader_edit()
    {
        $general_setting = GeneralSetting::where('id',1)->first();
        return view('admin.general_setting.stickyheader', compact('general_setting'));
    }

    public function stickyheader_update(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['sticky_header_status'] = $request->get('sticky_header_status');

        GeneralSetting::where('id',1)->update($data);

        return redirect()->back()->with('success', 'Sticky Header Setting is updated successfully!');
    }

    public function googleanalytic_edit()
    {
        $general_setting = GeneralSetting::where('id',1)->first();
        return view('admin.general_setting.googleanalytic', compact('general_setting'));
    }

    public function googleanalytic_update(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['google_analytic_tracking_id'] = $request->get('google_analytic_tracking_id');
        $data['google_analytic_status'] = $request->get('google_analytic_status');

        GeneralSetting::where('id',1)->update($data);

        return redirect()->back()->with('success', 'Google Analytic Setting is updated successfully!');
    }


    public function googlerecaptcha_edit()
    {
        $general_setting = GeneralSetting::where('id',1)->first();
        return view('admin.general_setting.googlerecaptcha', compact('general_setting'));
    }

    public function googlerecaptcha_update(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['google_recaptcha_site_key'] = $request->get('google_recaptcha_site_key');
        $data['google_recaptcha_status'] = $request->get('google_recaptcha_status');

        GeneralSetting::where('id',1)->update($data);

        return redirect()->back()->with('success', 'Google Recaptcha Setting is updated successfully!');
    }




    public function tawklivechat_edit()
    {
        $general_setting = GeneralSetting::where('id',1)->first();
        return view('admin.general_setting.tawklivechat', compact('general_setting'));
    }

    public function tawklivechat_update(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['tawk_live_chat_code'] = $request->get('tawk_live_chat_code');
        $data['tawk_live_chat_status'] = $request->get('tawk_live_chat_status');

        GeneralSetting::where('id',1)->update($data);

        return redirect()->back()->with('success', 'Tawk Live Chat Setting is updated successfully!');
    }


    public function cookieconsent_edit()
    {
        $general_setting = GeneralSetting::where('id',1)->first();
        return view('admin.general_setting.cookieconsent', compact('general_setting'));
    }

    public function cookieconsent_update(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data['cookie_consent_status'] = $request->get('cookie_consent_status');

        GeneralSetting::where('id',1)->update($data);

        return redirect()->back()->with('success', 'Cookie Consent Setting is updated successfully!');
    }

    public function banner_edit()
    {
        $general_setting = GeneralSetting::where('id',1)->first();
        return view('admin.general_setting.banner', compact('general_setting'));
    }

    public function banner_update(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        if($request->hasFile('banner_about'))
        {
            $request->validate([
                'banner_about' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_about')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_about')->move(public_path('uploads/'), $final_name);
            $data['banner_about'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'About Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_service'))
        {
            $request->validate([
                'banner_service' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_service')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_service')->move(public_path('uploads/'), $final_name);
            $data['banner_service'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Service Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_service_detail'))
        {
            $request->validate([
                'banner_service_detail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_service_detail')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_service_detail')->move(public_path('uploads/'), $final_name);
            $data['banner_service_detail'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Service Detail Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_blog'))
        {
            $request->validate([
                'banner_blog' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_blog')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_blog')->move(public_path('uploads/'), $final_name);
            $data['banner_blog'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Blog Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_blog_detail'))
        {
            $request->validate([
                'banner_blog_detail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_blog_detail')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_blog_detail')->move(public_path('uploads/'), $final_name);
            $data['banner_blog_detail'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Blog Detail Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_category'))
        {
            $request->validate([
                'banner_category' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_category')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_category')->move(public_path('uploads/'), $final_name);
            $data['banner_category'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Category Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_project'))
        {
            $request->validate([
                'banner_project' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_project')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_project')->move(public_path('uploads/'), $final_name);
            $data['banner_project'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Project Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_project_detail'))
        {
            $request->validate([
                'banner_project_detail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_project_detail')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_project_detail')->move(public_path('uploads/'), $final_name);
            $data['banner_project_detail'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Project Detail Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_team_member'))
        {
            $request->validate([
                'banner_team_member' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_team_member')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_team_member')->move(public_path('uploads/'), $final_name);
            $data['banner_team_member'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Team Member Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_team_member_detail'))
        {
            $request->validate([
                'banner_team_member_detail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_team_member_detail')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_team_member_detail')->move(public_path('uploads/'), $final_name);
            $data['banner_team_member_detail'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Team Member Detail Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_photo_gallery'))
        {
            $request->validate([
                'banner_photo_gallery' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_photo_gallery')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_photo_gallery')->move(public_path('uploads/'), $final_name);
            $data['banner_photo_gallery'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Photo Gallery Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_video_gallery'))
        {
            $request->validate([
                'banner_video_gallery' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_video_gallery')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_video_gallery')->move(public_path('uploads/'), $final_name);
            $data['banner_video_gallery'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Video Gallery Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_faq'))
        {
            $request->validate([
                'banner_faq' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_faq')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_faq')->move(public_path('uploads/'), $final_name);
            $data['banner_faq'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'FAQ Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_product'))
        {
            $request->validate([
                'banner_product' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_product')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_product')->move(public_path('uploads/'), $final_name);
            $data['banner_product'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Product Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_product_detail'))
        {
            $request->validate([
                'banner_product_detail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_product_detail')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_product_detail')->move(public_path('uploads/'), $final_name);
            $data['banner_product_detail'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Product Detail Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_contact'))
        {
            $request->validate([
                'banner_contact' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_contact')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_contact')->move(public_path('uploads/'), $final_name);
            $data['banner_contact'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Contact Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_search'))
        {
            $request->validate([
                'banner_search' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_search')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_search')->move(public_path('uploads/'), $final_name);
            $data['banner_search'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Search Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_cart'))
        {
            $request->validate([
                'banner_cart' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_cart')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_cart')->move(public_path('uploads/'), $final_name);
            $data['banner_cart'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Cart Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_checkout'))
        {
            $request->validate([
                'banner_checkout' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_checkout')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_checkout')->move(public_path('uploads/'), $final_name);
            $data['banner_checkout'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Checkout Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_login'))
        {
            $request->validate([
                'banner_login' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_login')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_login')->move(public_path('uploads/'), $final_name);
            $data['banner_login'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Login Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_registration'))
        {
            $request->validate([
                'banner_registration' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_registration')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_registration')->move(public_path('uploads/'), $final_name);
            $data['banner_registration'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Registration Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_forget_password'))
        {
            $request->validate([
                'banner_forget_password' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_forget_password')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_forget_password')->move(public_path('uploads/'), $final_name);
            $data['banner_forget_password'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Forget Password Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_customer_panel'))
        {
            $request->validate([
                'banner_customer_panel' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_customer_panel')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_customer_panel')->move(public_path('uploads/'), $final_name);
            $data['banner_customer_panel'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Customer Panel Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_career'))
        {
            $request->validate([
                'banner_career' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_career')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_career')->move(public_path('uploads/'), $final_name);
            $data['banner_career'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Career Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_job'))
        {
            $request->validate([
                'banner_job' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_job')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_job')->move(public_path('uploads/'), $final_name);
            $data['banner_job'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Job Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_job_application'))
        {
            $request->validate([
                'banner_job_application' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_job_application')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_job_application')->move(public_path('uploads/'), $final_name);
            $data['banner_job_application'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Job Application Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_term'))
        {
            $request->validate([
                'banner_term' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_term')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_term')->move(public_path('uploads/'), $final_name);
            $data['banner_term'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Term Page Banner is updated successfully!');
        }

        if($request->hasFile('banner_privacy'))
        {
            $request->validate([
                'banner_privacy' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            // unlink(public_path('uploads/'.$request->current_photo));
            $ext = $request->file('banner_privacy')->extension();
            $final_name = time().'.'.$ext;
            $request->file('banner_privacy')->move(public_path('uploads/'), $final_name);
            $data['banner_privacy'] = $final_name;
            GeneralSetting::where('id',1)->update($data);
            return redirect()->back()->with('success', 'Privacy Page Banner is updated successfully!');
        }

        return redirect()->back()->with('error', 'You must have to select a photo');

    }

    public function landing_page_contact_setting()
    {
        $general_setting = GeneralSetting::where('id',1)->first();
        $backgrounds = DB::table('landing_page_images')->where('is_left', 0)->get();
        $left_backgrounds = DB::table('landing_page_images')->where('is_left', 1)->get();
        return view('admin.general_setting.lpc', compact('general_setting', 'backgrounds', 'left_backgrounds'));
    }

    public function landing_page_contact_setting_update(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $request->validate([
            'lpc_logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lpc_text' => 'sometimes|max:225|string',
            'lpc_title' => 'sometimes|max:50|string',
            'lpc_btn_color' => 'sometimes|starts_with:#',
            'lpc_nav_color' => 'sometimes|starts_with:#',
            'lpc_overlay' => 'sometimes|numeric|min:0.1|max:1',
            'lpc_form_bg_color' => 'sometimes|starts_with:#',
            'lpc_bg_type' => 'required|in:color,image',
            'lpc_background_color' => 'sometimes|starts_with:#',
            'lpc_background_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'background_id' => 'sometimes',
            'lpc_left_bg' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'left_bg_id' => 'sometimes',
        ]);

        if (isset($request['lpc_logo']))
        {
            $ext = $request->file('lpc_logo')->extension();
            $final_name = time().'.'.$ext;
            $request->file('lpc_logo')->move(public_path('uploads/'), $final_name);
            $data['lpc_logo'] = $final_name;
        }

        if ($request['lpc_bg_type'] == 'image')
        {
            if($request->file('lpc_background_image'))
            {
                $ext = $request->file('lpc_background_image')->extension();
                $final_name = time().'.'.$ext;
                $request->file('lpc_background_image')->move(public_path('uploads/'), $final_name);
                $data['lpc_background'] = $final_name;
            }
            else
            {
                if ($request['background_id'] != null) {
                    $background = DB::table('landing_page_images')->find($request['background_id']);
                    $data['lpc_background'] = $background->file;
                }
            }
        }
        else
        {
            $data['lpc_background'] = $request['lpc_background_color'];
        }

        if ($request['lpc_left_bg'] != null) {
            $ext = $request->file('lpc_left_bg')->extension();
            $final_name = time().'.'.$ext;
            $request->file('lpc_left_bg')->move(public_path('uploads/'), $final_name);
            $data['lpc_left_bg'] = $final_name;
        }
        else
        {
            if ($request['left_bg_id'] != null) {
                $background = DB::table('landing_page_images')->find($request['left_bg_id']);
                $data['lpc_left_bg'] = $background->file;
            }
        }

        $data['lpc_text'] = $request['lpc_text'];
        $data['lpc_title'] = $request['lpc_title'];
        $data['lpc_btn_color'] = $request['lpc_btn_color'];
        $data['lpc_nav_color'] = $request['lpc_nav_color'];
        $data['lpc_overlay'] = $request['lpc_overlay'];
        $data['lpc_form_bg_color'] = $request['lpc_form_bg_color'];

        $data['lpc_title_color'] = $request['lpc_title_color'];
        $data['lpc_title_font_size'] = $request['lpc_title_font_size'];
        $data['lpc_title_font_family'] = $request['lpc_title_font_family'];

        $data['lpc_title_text_color'] = $request['lpc_title_text_color'];
        $data['lpc_title_text_font_size'] = $request['lpc_title_text_font_size'];
        $data['lpc_title_text_font_family'] = $request['lpc_title_text_font_family'];

        $data['lpc_form_text_color'] = $request['lpc_form_text_color'];
        $data['lpc_form_text_font_size'] = $request['lpc_form_text_font_size'];
        $data['lpc_form_text_font_family'] = $request['lpc_form_text_font_family'];

        $data['lpc_submit_text_color'] = $request['lpc_submit_text_color'];
        $data['lpc_submit_text_font_size'] = $request['lpc_submit_text_font_size'];
        $data['lpc_submit_text_font_family'] = $request['lpc_submit_text_font_family'];

        $data['lpc_logo_mobile_width'] = $request['lpc_logo_mobile_width'];
        $data['lpc_logo_mobile_height'] = $request['lpc_logo_mobile_height'];
        $data['lpc_logo_pc_width'] = $request['lpc_logo_pc_width'];
        $data['lpc_logo_pc_height'] = $request['lpc_logo_pc_height'];
        $data['lpc_message_text'] = $request['lpc_message_text'];

        $data['lpc_centered']= isset($request['lpc_centered']) ? 1 : 0;;
        // dd($request->all());
        GeneralSetting::where('id',1)->update($data);

        return redirect()->back()->with('success', 'Landing page setting is updated successfully!');

    }


    public function landingpages_update(Request $request)
    {

       
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $request->validate([
            'lpc_logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lpc_text' => 'sometimes|max:225|string',
            'lpc_title' => 'sometimes|max:50|string',
            'lpc_btn_color' => 'sometimes|starts_with:#',
            'lpc_nav_color' => 'sometimes|starts_with:#',
            'lpc_overlay' => 'sometimes|numeric|min:0.1|max:1',
            'lpc_form_bg_color' => 'sometimes|starts_with:#',
            'lpc_bg_type' => 'required|in:color,image',
            'lpc_background_color' => 'sometimes|starts_with:#',
            'lpc_background_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'background_id' => 'sometimes',
            'lpc_left_bg' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'left_bg_id' => 'sometimes',
        ]);

        if (isset($request['lpc_logo']))
        {
            $ext = $request->file('lpc_logo')->extension();
            $final_name = time().'.'.$ext;
            $request->file('lpc_logo')->move(public_path('uploads/'), $final_name);
            $data['lpc_logo'] = $final_name;
        }

        if ($request['lpc_bg_type'] == 'image')
        {
            if($request->file('lpc_background_image'))
            {
                $ext = $request->file('lpc_background_image')->extension();
                $final_name = time().'.'.$ext;
                $request->file('lpc_background_image')->move(public_path('uploads/'), $final_name);
                $data['lpc_background'] = $final_name;
            }
            else
            {
                if ($request['background_id'] != null) {
                    $background = DB::table('landing_page_images')->find($request['background_id']);
                    $data['lpc_background'] = $background->file;
                }
            }
        }
        else
        {
            $data['lpc_background'] = $request['lpc_background_color'];
        }

        if ($request['lpc_left_bg'] != null) {
            $ext = $request->file('lpc_left_bg')->extension();
            $final_name = time().'.'.$ext;
            $request->file('lpc_left_bg')->move(public_path('uploads/'), $final_name);
            $data['lpc_left_bg'] = $final_name;
        }
        else
        {
            if ($request['left_bg_id'] != null) {
                $background = DB::table('landing_page_images')->find($request['left_bg_id']);
                $data['lpc_left_bg'] = $background->file;
            }
        }

        $data['lpc_left_bg_width'] = $request['lpc_left_bg_width'];
        $data['lpc_left_bg_height'] = $request['lpc_left_bg_height'];
        $data['lpc_text'] = $request['lpc_text'];
        $data['lpc_title'] = $request['lpc_title'];
        $data['lpc_btn_color'] = $request['lpc_btn_color'];
        $data['lpc_nav_color'] = $request['lpc_nav_color'];
        $data['lpc_overlay'] = $request['lpc_overlay'];
        $data['lpc_form_bg_color'] = $request['lpc_form_bg_color'];

        $data['lpc_title_color'] = $request['lpc_title_color'];
        $data['lpc_title_font_size'] = $request['lpc_title_font_size'];
        $data['lpc_title_font_family'] = $request['lpc_title_font_family'];

        $data['lpc_title_text_color'] = $request['lpc_title_text_color'];
        $data['lpc_title_text_font_size'] = $request['lpc_title_text_font_size'];
        $data['lpc_title_text_font_family'] = $request['lpc_title_text_font_family'];

        $data['lpc_form_text_color'] = $request['lpc_form_text_color'];
        $data['lpc_form_text_font_size'] = $request['lpc_form_text_font_size'];
        $data['lpc_form_text_font_family'] = $request['lpc_form_text_font_family'];

        $data['lpc_submit_text_color'] = $request['lpc_submit_text_color'];
        $data['lpc_submit_text_font_size'] = $request['lpc_submit_text_font_size'];
        $data['lpc_submit_text_font_family'] = $request['lpc_submit_text_font_family'];

        $data['lpc_logo_mobile_width'] = $request['lpc_logo_mobile_width'];
        $data['lpc_logo_mobile_height'] = $request['lpc_logo_mobile_height'];
        $data['lpc_logo_pc_width'] = $request['lpc_logo_pc_width'];
        $data['lpc_logo_pc_height'] = $request['lpc_logo_pc_height'];
        $data['lpc_message_text'] = $request['lpc_message_text'];
        $data['lpc_name'] = $request['lpc_name'];

        $data['lpc_centered']= isset($request['lpc_centered']) ? 1 : 0;;
        // dd($request->all());
        GeneralSetting::where('id',$request['id'])->update($data);

        return redirect('landingpages_index')->with('success', 'Landing page setting is updated successfully!');

    }

    public function landing_page_contact()
    {

        $setting = GeneralSetting::where('id',1)->first();
        $type=null;
        if(substr($setting->lpc_background, 0, 1) == "#") {
            $type='color';
          } else {
            $type='image';
          }

        return view('landing_page_contact', compact('setting','type'));
    }


    public function landingpages_index()
    {

        $pages = GeneralSetting::select('id', 'lpc_name', 'lpc_logo')->get();

        return view('admin.landingpages.index', compact('pages'));
    }

    public function landingpages_edit($id)
    {
        

        $general_setting = GeneralSetting::where('id',$id)->first();
        $backgrounds = DB::table('landing_page_images')->where('is_left', 0)->get();
        $left_backgrounds = DB::table('landing_page_images')->where('is_left', 1)->get();
        return view('admin.landingpages.edit', compact('general_setting', 'backgrounds', 'left_backgrounds'));
    }


    public function landingpages_create(){
        $general_setting = GeneralSetting::where('id',1)->first();
        $backgrounds = DB::table('landing_page_images')->where('is_left', 0)->get();
        $left_backgrounds = DB::table('landing_page_images')->where('is_left', 1)->get();
        return view('admin.landingpages.create', compact('general_setting', 'backgrounds', 'left_backgrounds'));
    }

    public function landingpages_save(Request $request){
        
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $duplicate_name=GeneralSetting::where('lpc_name',$request->lpc_name)->count();
        if($duplicate_name>0){
            return back()->with('error', 'Landing Page having same name alreadly taken.');
        }

        $request->validate([
            'lpc_logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lpc_text' => 'sometimes|max:225|string',
            'lpc_title' => 'sometimes|max:50|string',
            'lpc_btn_color' => 'sometimes|starts_with:#',
            'lpc_nav_color' => 'sometimes|starts_with:#',
            'lpc_overlay' => 'sometimes|numeric|min:0.1|max:1',
            'lpc_form_bg_color' => 'sometimes|starts_with:#',
            'lpc_bg_type' => 'required|in:color,image',
            'lpc_background_color' => 'sometimes|starts_with:#',
            'lpc_background_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'background_id' => 'sometimes',
            'lpc_left_bg' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'left_bg_id' => 'sometimes',
        ]);

        if (isset($request['lpc_logo']))
        {
            $ext = $request->file('lpc_logo')->extension();
            $final_name = time().'.'.$ext;
            $request->file('lpc_logo')->move(public_path('uploads/'), $final_name);
            $data['lpc_logo'] = $final_name;
        }

        if ($request['lpc_bg_type'] == 'image')
        {
            if($request->file('lpc_background_image'))
            {
                $ext = $request->file('lpc_background_image')->extension();
                $final_name = time().'.'.$ext;
                $request->file('lpc_background_image')->move(public_path('uploads/'), $final_name);
                $data['lpc_background'] = $final_name;
            }
            else
            {
                if ($request['background_id'] != null) {
                    $background = DB::table('landing_page_images')->find($request['background_id']);
                    $data['lpc_background'] = $background->file;
                }
            }
        }
        else
        {
            $data['lpc_background'] = $request['lpc_background_color'];
        }

        if ($request['lpc_left_bg'] != null) {
            $ext = $request->file('lpc_left_bg')->extension();
            $final_name = time().'.'.$ext;
            $request->file('lpc_left_bg')->move(public_path('uploads/'), $final_name);
            $data['lpc_left_bg'] = $final_name;
        }
        else
        {
            if ($request['left_bg_id'] != null) {
                $background = DB::table('landing_page_images')->find($request['left_bg_id']);
                $data['lpc_left_bg'] = $background->file;
            }
        }

        $data['lpc_left_bg_width'] = $request['lpc_left_bg_width'];
        $data['lpc_left_bg_height'] = $request['lpc_left_bg_height'];
        $data['lpc_name'] = $request['lpc_name'];
        $data['lpc_text'] = $request['lpc_text'];
        $data['lpc_title'] = $request['lpc_title'];
        $data['lpc_btn_color'] = $request['lpc_btn_color'];
        $data['lpc_nav_color'] = $request['lpc_nav_color'];
        $data['lpc_overlay'] = $request['lpc_overlay'];
        $data['lpc_form_bg_color'] = $request['lpc_form_bg_color'];

        $data['lpc_title_color'] = $request['lpc_title_color'];
        $data['lpc_title_font_size'] = $request['lpc_title_font_size'];
        $data['lpc_title_font_family'] = $request['lpc_title_font_family'];

        $data['lpc_title_text_color'] = $request['lpc_title_text_color'];
        $data['lpc_title_text_font_size'] = $request['lpc_title_text_font_size'];
        $data['lpc_title_text_font_family'] = $request['lpc_title_text_font_family'];

        $data['lpc_form_text_color'] = $request['lpc_form_text_color'];
        $data['lpc_form_text_font_size'] = $request['lpc_form_text_font_size'];
        $data['lpc_form_text_font_family'] = $request['lpc_form_text_font_family'];

        $data['lpc_submit_text_color'] = $request['lpc_submit_text_color'];
        $data['lpc_submit_text_font_size'] = $request['lpc_submit_text_font_size'];
        $data['lpc_submit_text_font_family'] = $request['lpc_submit_text_font_family'];

        $data['lpc_logo_mobile_width'] = $request['lpc_logo_mobile_width'];
        $data['lpc_logo_mobile_height'] = $request['lpc_logo_mobile_height'];
        $data['lpc_logo_pc_width'] = $request['lpc_logo_pc_width'];
        $data['lpc_logo_pc_height'] = $request['lpc_logo_pc_height'];
        $data['lpc_message_text'] = $request['lpc_message_text'];

        $data['lpc_centered']= isset($request['lpc_centered']) ? 1 : 0;;
        // dd($request->all());
        GeneralSetting::insert($data);

        // return redirect()->back()->with('success', 'Landing page setting saved successfully!');
        return redirect()->route('landingpages.index')->with('success', 'Landing page setting saved successfully!');

    }

    public function landingpages_view($id){
       
        $setting = GeneralSetting::where('lpc_name',$id)->first();
        $type=null;
        if(substr($setting->lpc_background, 0, 1) == "#") {
            $type='color';
          } else {
            $type='image';
          }

        return view('landing_page_contact', compact('setting','type'));
    }

    public function landingpages_delete($id){
        if($id=='1'){
            return back()->with('error', 'You cannot delete Main Landing Page. This landing Page needed as reference to create future Landing Pages..');
        }
        GeneralSetting::find($id)->delete();

        return back()->with('success', 'Landing Page deleted successfully');
    }

    public function landing_page_contact_save(Request $request)
    {
       
        $data = $request->validate([
            'email' => 'required|email',
            'phone' => 'required|max:25',
            // 'code' => 'required',
            'name' => 'required|max:224',
            'landing_page_id' => 'required',
        ]);

        
        $phoneNumber = $data['phone'];
        if (!preg_match('/^\+1|^1/', $phoneNumber)) {
            $data['phone'] = '+1' . $phoneNumber;
        }
        
        $message = GeneralSetting::where('id', $request->landing_page_id)->first();
        

        $recipient_number = $data['phone'];
        $message_body = $message->lpc_message_text;
        try
        {
            $client = new RestClient(env('PLIVO_AUTH_ID'), env('PLIVO_AUTH_TOKEN'));
            $response = $client->messages->create(env('PLIVO_NUMBER'), [$recipient_number], $message_body);
            $sent = $response->statusCode === 202;
            
        } catch (\Exception $exp)
        {
            \Log::error('SMS sending failed: ' . $exp->getMessage());
        }
        // $account_sid = env('TWILIO_ACCOUNT_SID');
        // $auth_token = env('TWILIO_AUTH_TOKEN');
        // $twilio_number = env('TWILIO_PHONE_NUMBER');

        
      
       
        $existingContact = LandingPageContact::where('phone', $data['phone'])->where('landing_page_id',$request->landing_page_id)->first();

        if ($existingContact) {
            return redirect()->back()->with('error', "Phone number already exists: ".$data['phone']);
        }

        $existingEmail = LandingPageContact::where('email', $data['email'])->where('landing_page_id',$request->landing_page_id)->first();

        if ($existingEmail) {
            return redirect()->back()->with('error', "Email already exists: ".$data['email']);
        }

        DB::table('landing_page_contacts')->insert($data);
        
        // try {
        //     $twilio = new Client($account_sid, $auth_token);

        //     $twilio->messages->create(
        //         $recipient_number,
        //         array(
        //             'from' => $twilio_number,
        //             'body' => $message_body
        //         )
        //     );

            

            return redirect()->back()->with('success', 'Thanks for Register!');
        // } catch (\Exception $e) {
        //     // Handle Twilio exception
        //     return redirect()->back()->with('error', 'Failed to send message via Twilio: ' . $e->getMessage());
        // }


    }

    public function getLimits()
    {
        $limits = DB::table('message_limits')->first();
        return view('admin.general_setting.message_limits', ['limits' => $limits]);
    }
    public function setLimits(Request $request)
    {
        $data = $request->validate([
            'sms' => 'required|min:1|numeric',
            'whatsapp' => 'required|min:1',
        ]);

        DB::table('message_limits')->updateOrInsert(['id' => $request['id']], $data);

        return redirect()->back()->with('success', 'Landing page contact is saved successfully!');
    }

    public function landing_page_images()
    {
        $images = DB::table('landing_page_images')->where('is_left', 0)->get();
        return view('admin.general_setting.landing_page_images', compact('images'));
    }
    public function landing_page_left_images()
    {
        $images = DB::table('landing_page_images')->where('is_left', 1)->get();
        return view('admin.general_setting.landing_page_left_images', compact('images'));
    }
    public function delete_landing_page_images($id)
    {
        DB::table('landing_page_images')->where('id', $id)->delete();
        return back()->with('success', 'Landing page background is deleted successfully!');
    }

    public function store_landing_page_images(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);

        $data['is_left'] = isset($request['is_left']) ? 1 : 0;

        if (isset($request['file']))
        {
            $ext = $request->file('file')->extension();
            $final_name = time().'.'.$ext;
            $request->file('file')->move(public_path('uploads/'), $final_name);
            $data['file'] = $final_name;

            DB::table('landing_page_images')->insert($data);
        }

        return redirect()->back()->with('success', 'Landing page background is added successfully!');

    }

    public function logo(){
        return view('admin.general_setting.admin_logo');
    }

    public function store_post_admin_logo(Request $request){
        $setting = GeneralSetting::where('id',1)->first();
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);


        if (isset($request['file']))
        {
            $ext = $request->file('file')->extension();
            $final_name = time().'.'.$ext;
            $request->file('file')->move(public_path('uploads/'), $final_name);

            $setting->admin_logo=$final_name;
            $setting->save();
        }

        return redirect()->back()->with('success', 'Logo Updated successfully!');

    }

    public function store_post_admin_logo_size(Request $request){
        $setting = GeneralSetting::where('id',1)->first();

        $setting->admin_logo_width=$request['admin_logo_width'];
        $setting->admin_logo_height=$request['admin_logo_height'];

        $setting->save();

        return redirect()->back()->with('success', 'Logo Size updated successfully!');
    }

    public function bercotool_images(){
        $setting = GeneralSetting::where('id',1)->first();

        return view('admin.general_setting.bercotool_images');
    }


    public function store_post_bercotool_images(Request $request){


        $validationRules = [];
        $maxFileSize = 5048; // Maximum file size in kilobytes
        $allowedImageTypes = 'jpeg,png,jpg,gif'; // Allowed image MIME types

        for ($i = 1; $i <= 29; $i++) {
            $validationRules["bercotool_{$i}"] = "image|mimes:{$allowedImageTypes}|max:{$maxFileSize}";
        }

        $request->validate($validationRules);


        $setting = GeneralSetting::where('id',1)->first();
        $setting->too_font_size=$request['too_font_size'];
        for ($i = 1; $i <= 29; $i++) {
            $inputName = 'bercotool_' . $i;

            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                $ext = $file->getClientOriginalExtension();
                $randomNumber = rand(10000, 99999);
                $finalName = time() . $randomNumber . '.' . $ext;
                $file->move(public_path('uploads/'), $finalName);

                $setting->$inputName = $finalName;
            }
        }



        $setting->save();

        if(isset($request->codes))
        {
            DB::table('admin_tools')->updateOrInsert(['user_id' => 0], ['codes' => implode(',', $request->codes)]);
        }
        else
        {
            DB::table('admin_tools')->where('user_id', 0)->delete();
        }


        for ($i = 1; $i <= 29; $i++) {
            $to_replace=ToolText::where('id',$i)->first();
            $to_replace->text=$request[$i];
            $to_replace->width=$request[$i.'_width'];
            $to_replace->save();
        }


        return redirect()->back()->with('success', 'Tools Updated successfully!');
    }

    public function superadmin_update_fees(Request $request){
        // dd($request->monthly_fee);
        $setting = GeneralSetting::where('id',1)->first();

        $setting->monthly_fee=$request->monthly_fee;

        $setting->save();
        return redirect()->back()->with('success', 'Updated successfully!');
    }

    public function default_homepage_edit()
    {
        $general_setting = GeneralSetting::where('id',1)->first();
        return view('admin.general_setting.default_homepage', compact('general_setting'));
    }

    public function default_homepage_update(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data = $request->validate([
            'default_homepage' => 'required|in:website,ecommerce',
        ]);
        GeneralSetting::where('id',1)->update($data);
        return redirect()->back()->with('success', 'Default Homepage is updated successfully!');
    }

    public function stripe_keys_edit()
    {
        return view('admin.general_setting.stripe_keys');
    }

    public function stripe_keys_update(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }
        $data = $request->validate([
            'public_key' => 'required|alpha_dash',
            'secret_key' => 'required|alpha_dash',
        ]);
        $this->setEnvironmentValue('ADMIN_STRIPE_PUBLIC_KEY', $data['public_key']);
        $this->setEnvironmentValue('ADMIN_STRIPE_SECRET_KEY', $data['secret_key']);
        return redirect()->back()->with('success', 'Stripe keys are saved successfully!');
    }
    public function paypal_keys_edit()
    {
        return view('admin.general_setting.paypal_keys');
    }

    public function paypal_keys_update(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }
        $data = $request->validate([
            'env_type' => 'required|in:production,sandbox',
            'client_id' => 'required|alpha_dash',
            'secret_key' => 'required|alpha_dash',
        ]);
        $this->setEnvironmentValue('PAYPAL_ENV_TYPE', $data['env_type']);
        $this->setEnvironmentValue('PAYPAL_CLIENT_ID', $data['client_id']);
        $this->setEnvironmentValue('PAYPAL_SECRET_KEY', $data['secret_key']);
        return redirect()->back()->with('success', 'Paypal keys are saved successfully!');
    }

    public function setEnvironmentValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $oldValue = env($envKey);

        $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}", $str);

        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
    }

    public function bg_music_edit()
    {
        $general_setting = GeneralSetting::where('id',1)->first();
        return view('admin.general_setting.bg_music', compact('general_setting'));
    }

    public function bg_music_update(Request $request)
    {
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        if($request->file('bg_music'))
        {
            $request->validate([
                'bg_music' => 'required|mimes:mp3,wav|max:5120'
            ]);

            // Unlink old music
            if (isset($request->current_music) && file_exists(public_path('uploads/'.$request->current_music))) {
                unlink(public_path('uploads/'.$request->current_music));
            }

            $ext = $request->file('bg_music')->extension();
            $final_name = time().'.'.$ext;
            $request->file('bg_music')->move(public_path('uploads/'), $final_name);

            $data['bg_music'] = $final_name;

            GeneralSetting::where('id',1)->update($data);
        }
        return redirect()->back()->with('success', 'Background Music is updated successfully!');
    }

    public function bg_music_delete()
    {
        
        if(env('PROJECT_MODE') == 0) {
            return redirect()->back()->with('error', env('PROJECT_NOTIFICATION'));
        }

        $data=GeneralSetting::where('id',1)->first();
        $data->bg_music=null;
        $data->save();


        return redirect()->back()->with('success', 'Background Music deleted successfully!');
    }



}
