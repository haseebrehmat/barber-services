@extends('admin.admin_layouts')

@section('admin_content')
<style>
    .col {
        /* Set the width of the parent div */
        width: 300px;
        /* Set the height of the parent div */
        height: 70px;
    }

    .image {
        /* Set the maximum width and height to 100% of the parent div's dimensions */
        max-width: 100%;
        max-height: 100%;
    }
    /* CSS for screens larger than 17 inch laptops */
        @media screen and (min-width: 1600px) {
            .image {
                height: 100%;
            }
        }
        
        /* CSS for screens up to 17-inch laptops */
        @media screen and (max-width: 1599px) {
            .image {
                height: 74%;
            }
        }
        @media screen and (max-width: 767px) {
            .image {
                height: 90%;
              
            }
        }
        /* Default styles for desktop */
        .card_with_text {
        height: 150px;
        }

        /* Styles for mobile devices */
        @media (max-width: 767px) {
        .card_with_text {
            height: 160px;
        }
        }
</style>

    @php
        $dashboard_section = [
            ['key' => 'bercostore','img' => asset("public/uploads/$general_settings_global->bercotool_2"), 'name' => 'Bercostore', 'icon' => 'fas fa-shopping-cart', 'code' => 2],
            ['route' => route('admin.stats'), 'img' => $general_settings_global->bercotool_23 ? asset("public/uploads/$general_settings_global->bercotool_23") : 'https://placehold.co/1600x400?text=Stats', 'icon' => 'fas fa-cog', 'code' => 23],
            ['route' => route('admin.order.grid'), 'img' => $general_settings_global->bercotool_18 ? asset("public/uploads/$general_settings_global->bercotool_18") : 'https://placehold.co/1600x400?text=Display+Orders', 'icon' => 'fas fa-cog', 'code' => 18],
            ['route' => route('admin.follow_up_customer'), 'img' => $general_settings_global->bercotool_27 ? asset("public/uploads/$general_settings_global->bercotool_27") : 'https://placehold.co/1600x400?text=Follow Up Customer', 'icon' => 'fas fa-cog', 'code' => 27],
            ['route' => route('admin.customers.chat'), 'img' => $general_settings_global->bercotool_14 ? asset("public/uploads/$general_settings_global->bercotool_14") : 'https://placehold.co/1600x400?text=Chat+with+Customers', 'icon' => 'fas fa-cog', 'code' => 14],
            ['route' => route('admin.appointments'), 'img' => $general_settings_global->bercotool_16 ? asset("public/uploads/$general_settings_global->bercotool_16") : 'https://placehold.co/1600x400?text=Appointments', 'icon' => 'fas fa-cog', 'code' => 16],
            ['route' => route('admin.video_conference.index'), 'img' => $general_settings_global->bercotool_20 ? asset("public/uploads/$general_settings_global->bercotool_20") : 'https://placehold.co/1600x400?text=Video+Conference', 'icon' => 'fas fa-cog', 'code' => 20],
            ['route' => route('admin.customer.index'), 'img' => $general_settings_global->bercotool_17 ? asset("public/uploads/$general_settings_global->bercotool_17") : 'https://placehold.co/1600x400?text=Registered+Customers', 'icon' => 'fas fa-cog', 'code' => 17],
            ['route' => route('admin.reservations'), 'img' => $general_settings_global->bercotool_15 ? asset("public/uploads/$general_settings_global->bercotool_15") : 'https://placehold.co/1600x400?text=Reservations', 'icon' => 'fas fa-cog', 'code' => 15],
            ['key' => 'subscriber','img' => asset("public/uploads/$general_settings_global->bercotool_3"), 'name' => 'Subscriber Section', 'icon' => 'fas fa-share-alt-square', 'code' => 3],
            ['key' => 'bercoweb', 'img' => asset("public/uploads/$general_settings_global->bercotool_1"), 'name' => 'Bercoweb', 'icon' => 'fas fa-cog', 'code' => 1],
            // ['route' => route('landingpages.index'), 'img' => asset("public/uploads/$general_settings_global->bercotool_5"), 'icon' => 'fa fa-users' , 'code' => 5],
            // ['route' => route('admin.landing_page_messages'), 'img' => asset("public/uploads/$general_settings_global->bercotool_8"), 'icon' => 'fas fa-users', 'code' => 8],
            ['route' => route('admin.coupon_design.index'), 'img' => $general_settings_global->bercotool_24 ? asset("public/uploads/$general_settings_global->bercotool_24") : 'https://placehold.co/1600x400?text=Coupons', 'icon' => 'fas fa-cog', 'code' => 24],
            ['route' => route('coupon.tool.index'), 'img' => $general_settings_global->bercotool_28 ? asset("public/uploads/$general_settings_global->bercotool_28") : 'https://placehold.co/1600x400?text=Flyers', 'icon' => 'fas fa-cog', 'code' => 28],
            ['key' => 'emailer', 'img' => asset("public/uploads/$general_settings_global->bercotool_21"), 'name' => 'Emailer', 'icon' => 'fas fa-cog', 'code' => 21],
            ['key' => 'blogsection', 'img' => asset("public/uploads/$general_settings_global->bercotool_11"), 'name' => 'BercoBlog', 'icon' => 'fas fa-cog', 'code' => 11],
            ['route' => route('admin.messages.index'), 'img' => $general_settings_global->bercotool_19 ? asset("public/uploads/$general_settings_global->bercotool_19") : 'https://placehold.co/1600x400?text=Contact+Form+information', 'icon' => 'fas fa-cog', 'code' => 19],
            ['route' => route('admin.excel.import'), 'img' => asset("public/uploads/$general_settings_global->bercotool_6"), 'icon' => 'fas fa-users' , 'code' => 6],
            ['route' => '#', 'img' => $general_settings_global->bercotool_25 ? asset("public/uploads/$general_settings_global->bercotool_25") : 'https://placehold.co/1600x400?text=Facebook', 'icon' => 'fas fa-cog', 'code' => 25],
            ['route' => '#', 'img' => $general_settings_global->bercotool_26 ? asset("public/uploads/$general_settings_global->bercotool_26") : 'https://placehold.co/1600x400?text=Instagram', 'icon' => 'fas fa-cog', 'code' => 26],
            ['key' => 'administration','img' => asset("public/uploads/$general_settings_global->bercotool_4"), 'name' => 'Administration Users', 'icon' => 'fas fa-user-secret', 'code' => 4],
            ['route' => session('type') === 'admin' ? route('admin.employees.chat') : route('admin.employee.chat'), 'img' => $general_settings_global->bercotool_13 ? asset("public/uploads/$general_settings_global->bercotool_13") : 'https://placehold.co/1600x400?text=Chat+with+Employees', 'icon' => 'fas fa-cog', 'code' => 13],
            ['route' => route('admin.project.index'), 'img' => $general_settings_global->bercotool_22 ? asset("public/uploads/$general_settings_global->bercotool_22") : 'https://placehold.co/1600x400?text=Projects', 'icon' => 'fas fa-cog', 'code' => 22],
            ['route' => route('invoice-builder.index'), 'img' => asset("public/uploads/$general_settings_global->bercotool_12"), 'icon' => 'fas fa-cog', 'code' => 12],
            ['route' => route('signature-pad.draw'), 'img' => asset("public/uploads/$general_settings_global->bercotool_7"), 'icon' => 'fa fa-sticky-note', 'code' => 7],
            ['route' => route('admin.compose_document'), 'img' => asset("public/uploads/$general_settings_global->bercotool_9"), 'icon' => 'fas fa-file', 'code' => 9],
            ['route' => route('file-manager.index'), 'img' => asset("public/uploads/$general_settings_global->bercotool_10"), 'icon' => 'fas fa-archive', 'code' => 10],
            ['route' => route('admin.candidate'), 'img' => asset("public/uploads/$general_settings_global->bercotool_29"), 'icon' => 'fas fa-archive', 'code' => 29],
            // ['route' => route('admin.landing_page.index'), 'img' => asset("public/uploads/$general_settings_global->bercotool_5"), 'icon' => 'fas fa-archive', 'code' => 30],
            

        ];
        $bercoweb = [
            ['route' => route('admin.dashboard'), 'name' => 'Dashboard', 'icon' => 'fas fa-fw fa-home'],
            ['key' => 'general', 'name' => 'General Settings', 'icon' => 'fas fa-cog'],
            ['key' => 'page', 'name' => 'Page Settings', 'icon' => 'fas fa-paste'],
            // ['key' => 'blog', 'name' => 'Blog Section', 'icon' => 'fas fa-cubes'],
            ['key' => 'career', 'name' => 'Career Section', 'icon' => 'fas fa-user-secret'],
            ['route' => route('admin.footer.index'), 'name' => 'Footer Columns', 'icon' => 'fas fa-fw fa-list-alt'],
            ['route' => route('admin.slider.index'), 'name' => 'Sliders', 'icon' => 'fas fa-sliders-h'],
            ['route' => route('admin.dynamic_page.index'), 'name' => 'Dynamic Pages', 'icon' => 'fas fa-cube'],
            ['route' => route('admin.menu.index'), 'name' => 'Menu Manage', 'icon' => 'fas fa-bars'],
            // ['route' => route('admin.project.index'), 'name' => 'Project', 'icon' => 'fas fa-umbrella'],
            ['route' => route('admin.photo.index'), 'name' => 'Photo Gallery', 'icon' => 'fas fa-camera'],
            ['route' => route('admin.video.index'), 'name' => 'Video Gallery', 'icon' => 'fas fa-video'],
            ['route' => route('admin.customer.index'), 'name' => 'Customer Section', 'icon' => 'fas fa-users'],
            ['route' => route('admin.manual.messages'), 'name' => 'Manual Messages/Email', 'icon' => 'fas fa-users'],
            ['route' => route('admin.why_choose.index'), 'name' => 'Why Choose Us', 'icon' => 'fas fa-arrows-alt'],
            ['route' => route('admin.music.index'), 'name' => 'Testimonials Audios', 'icon' => 'fas fa-arrows-alt'],
            ['route' => route('admin.podcast.index'), 'name' => 'Podcast', 'icon' => 'fas fa-arrows-alt'],
            ['route' => route('admin.service.index'), 'name' => 'Service', 'icon' => 'fas fa-certificate'],
            ['route' => route('admin.testimonial.index'), 'name' => 'Testimonial', 'icon' => 'fas fa-award'],
            ['route' => route('admin.team_member.index'), 'name' => 'Team Member', 'icon' => 'fas fa-user-plus'],
            ['route' => route('admin.faq.index'), 'name' => 'FAQ', 'icon' => 'fas fa-question-circle'],
            ['route' => route('admin.email_template.index'), 'name' => 'Email Template', 'icon' => 'fas fa-envelope'],
            ['route' => route('admin.social_media.index'), 'name' => 'Social Media', 'icon' => 'fas fa-basketball-ball'],
            ['route' => route('admin.messages.index'), 'name' => 'Messages', 'icon' => 'fab fa-facebook-messenger'],
            ['route' => route('admin.general_setting.default_homepage'), 'name' => 'Default Homepage', 'icon' => 'fab fa-facebook-messenger'],
            ['route' => route('admin.pricing.index'), 'name' => 'Pricing Section', 'icon' => 'fab fa-facebook-messenger'],
        ];
        $bercostore = [
            ['route' => route('admin.product.index'), 'name' => 'Product', 'icon' => 'fas fa-shopping-cart'],
            ['route' => route('admin.product_category.index'), 'name' => 'Product Categories', 'icon' => 'fas fa-shopping-cart'],
            ['route' => route('admin.variant.index'), 'name' => 'All Variants', 'icon' => 'fas fa-shopping-cart'],
            ['route' => route('admin.modifier.index'), 'name' => 'Modifiers', 'icon' => 'fas fa-shopping-cart'],
            ['route' => route('admin.offering.index'), 'name' => 'Service / Offering', 'icon' => 'fas fa-shopping-cart'],
            ['route' => route('admin.offering.orders'), 'name' => 'Service Orders', 'icon' => 'fas fa-shopping-cart'],
            ['route' => route('admin.offering.settings'), 'name' => 'Service Settings', 'icon' => 'fas fa-shopping-cart'],
            ['route' => route('admin.shipping.index'), 'name' => 'Shipping', 'icon' => 'fas fa-shopping-cart'],
            ['route' => route('admin.slider.index', ['store' => 1]), 'name' => 'Store Sliders', 'icon' => 'fas fa-sliders-h'],
            ['route' => route('admin.coupon.index'), 'name' => 'Coupon', 'icon' => 'fas fa-shopping-cart'],
            ['route' => route('admin.order.index'), 'name' => 'Order Section', 'icon' => 'fas fa-bookmark'],
            ['route' => route('admin.general_setting.stripe_keys'), 'name' => 'Stripe Keys', 'icon' => 'fas fa-bookmark'],
            ['route' => route('admin.general_setting.paypal_keys'), 'name' => 'Paypal Keys', 'icon' => 'fas fa-bookmark'],
            ['route' => route('admin.shop.qrcode'), 'name' => 'Shop QR Code', 'icon' => 'fas fa-bookmark'],
            ['route' => route('admin.status.index'), 'name' => 'All Status', 'icon' => 'fas fa-bookmark'],
            ['route' => route('admin.tables'), 'name' => 'Tables', 'icon' => 'fas fa-bookmark'],
            ['route' => route('admin.shop.settings'), 'name' => 'Shop Settings', 'icon' => 'fas fa-bookmark'],
            ['route' => route('admin.offering.settings'), 'name' => 'Service Settings', 'icon' => 'fas fa-shopping-cart'],
            ['route' => route('admin.timings.edit'), 'name' => 'Shop Timings', 'icon' => 'fas fa-bookmark'],
        ];
        $subscriber = [
            ['route' => route('admin.subscriber.index'), 'name' => 'All Subscribers', 'icon' => 'fas fa-share-alt-square'],
            ['route' => route('admin.subscriber.send_email'), 'name' => 'Send Email to Subscribers', 'icon' => 'fas fa-share-alt-square'],
        ];
        $administration = [
            ['route' => route('admin.role.index'), 'name' => 'Roles', 'icon' => 'fas fa-user-secret'],
            ['route' => route('admin.role.user'), 'name' => 'Users', 'icon' => 'fas fa-user-secret'],
        ];
        $general_settings = [
            ['route' => route('admin.general_setting.logo'), 'name' => 'Logo', 'icon' => 'fas fa-cog'],
            ['route' => route('admin.general_setting.favicon'), 'name' => 'Favicon', 'icon' => 'fas fa-cog'],
            ['route' => route('admin.general_setting.loginbg'), 'name' => 'Login Background', 'icon' => 'fas fa-cog'],
            ['route' => route('admin.general_setting.topbar'), 'name' => 'Top Bar', 'icon' => 'fas fa-cog'],
            ['route' => route('admin.general_setting.banner'), 'name' => 'Banner', 'icon' => 'fas fa-cog'],
            ['route' => route('admin.general_setting.footer'), 'name' => 'Footer', 'icon' => 'fas fa-cog'],
            ['route' => route('admin.general_setting.sidebar'), 'name' => 'Sidebar', 'icon' => 'fas fa-cog'],
            ['route' => route('admin.general_setting.color'), 'name' => 'Color', 'icon' => 'fas fa-cog'],
            ['route' => route('admin.general_setting.preloader'), 'name' => 'Preloader', 'icon' => 'fas fa-cog'],
            ['route' => route('admin.general_setting.stickyheader'), 'name' => 'Sticky Header', 'icon' => 'fas fa-cog'],
            ['route' => route('admin.general_setting.googleanalytic'), 'name' => 'Google Analytic', 'icon' => 'fas fa-cog'],
            ['route' => route('admin.general_setting.googlerecaptcha'), 'name' => 'Google Recaptcha', 'icon' => 'fas fa-cog'],
            ['route' => route('admin.general_setting.tawklivechat'), 'name' => 'Tawk Live Chat', 'icon' => 'fas fa-cog'],
            ['route' => route('admin.general_setting.cookieconsent'), 'name' => 'Cookie Consent', 'icon' => 'fas fa-cog'],
            ['route' => route('admin.general_setting.bg_music'), 'name' => 'Background Music', 'icon' => 'fas fa-cog'],
        ];
        $page_settings = [
            ['route' => route('admin.page_home.edit'), 'name' => 'Home', 'icon' => 'fas fa-paste'],
            ['route' => route('admin.page_about.edit'), 'name' => 'About', 'icon' => 'fas fa-paste'],
            ['route' => route('admin.page_service.edit'), 'name' => 'Service Background', 'icon' => 'fas fa-paste'],
            ['route' => route('admin.page_shop.edit'), 'name' => 'Shop Bar', 'icon' => 'fas fa-paste'],
            ['route' => route('admin.page_blog.edit'), 'name' => 'Blog', 'icon' => 'fas fa-paste'],
            ['route' => route('admin.page_project.edit'), 'name' => 'Project', 'icon' => 'fas fa-paste'],
            ['route' => route('admin.page_faq.edit'), 'name' => 'FAQ', 'icon' => 'fas fa-paste'],
            ['route' => route('admin.page_team.edit'), 'name' => 'Team Member', 'icon' => 'fas fa-paste'],
            ['route' => route('admin.page_photo_gallery.edit'), 'name' => 'Photo Gallery', 'icon' => 'fas fa-paste'],
            ['route' => route('admin.page_video_gallery.edit'), 'name' => 'Video Gallery', 'icon' => 'fas fa-paste'],
            ['route' => route('admin.page_contact.edit'), 'name' => 'Contact', 'icon' => 'fas fa-paste'],
            ['route' => route('admin.page_career.edit'), 'name' => 'Career', 'icon' => 'fas fa-paste'],
            ['route' => route('admin.page_term.edit'), 'name' => 'Term', 'icon' => 'fas fa-paste'],
            ['route' => route('admin.page_privacy.edit'), 'name' => 'Privacy', 'icon' => 'fas fa-paste'],
            ['route' => route('admin.page_other.edit'), 'name' => 'Other', 'icon' => 'fas fa-paste'],
        ];
        $blog_section = [
            ['route' => route('admin.category.index'), 'name' => 'Categories', 'icon' => 'fas fa-cubes'],
            ['route' => route('admin.blog.index'), 'name' => 'Blogs', 'icon' => 'fas fa-cubes'],
            ['route' => route('admin.comment.approved'), 'name' => 'Approved Comments', 'icon' => 'fas fa-cubes'],
            ['route' => route('admin.comment.pending'), 'name' => 'Pending Comments', 'icon' => 'fas fa-cubes'],
        ];
        $career_section = [
            ['route' => route('admin.job.index'), 'name' => 'Jobs', 'icon' => 'fas fa-user-secret'],
            ['route' => route('admin.job.view_application'), 'name' => 'Job Applications', 'icon' => 'fas fa-user-secret'],
        ];
        $emailer = [
            ['route' => route('admin.group.index'), 'name' => 'Added Groups', 'icon' => 'fas fa-cog'],
            ['key' => 'defaultgroups', 'name' => 'Default Groups', 'icon' => 'fas fa-cog'],
            ['key' => 'campaigns', 'name' => 'Campaigns', 'icon' => 'fas fa-cog'],
            // ['route' => route('admin.excel.import.emailer'), 'name' => 'Upload Excel Leads', 'icon' => 'fas fa-share-alt-square'],
            ['route' => route('admin.group.contacts'), 'name' => 'Assign leads to new groups', 'icon' => 'fas fa-cog'],
            // ['key' => 'emaillayouts', 'name' => 'Email Layouts', 'icon' => 'fas fa-paste'],
            ['route' => route('admin.email_template.gallery'), 'name' => 'Send Emails', 'icon' => 'fas fa-share-alt-square'],
            ['route' => route('admin.reports'), 'name' => 'Reports', 'icon' => 'fas fa-share-alt-square'],
            ['key' => 'smtpsetting', 'name' => 'Settings', 'icon' => 'fas fa-paste'],
        ];
        $recipients = [
            ['route' => route('admin.recipient.create'), 'name' => 'Add Recipient', 'icon' => 'fas fa-share-alt-square'],
            ['route' => route('admin.recipient.index'), 'name' => 'All Recipients', 'icon' => 'fas fa-share-alt-square'],
            ['route' => route('admin.tag.create'), 'name' => 'Add Tags', 'icon' => 'fas fa-share-alt-square'],
            ['route' => route('admin.tag.index'), 'name' => 'Tags List', 'icon' => 'fas fa-share-alt-square'],
        ];
        $smtpsetting = [
            ['route' => route('admin.smtp-config.edit'), 'name' => 'SMTP Configuration', 'icon' => 'fas fa-share-alt-square'],
        ];
        // $emaillayouts = [
        //     // ['route' => route('admin.email_template.index', ['et_type' => 'emailer']), 'name' => 'Templates List', 'icon' => 'fas fa-share-alt-square'],
        //     ['route' => route('admin.email_template.gallery'), 'name' => 'Email Templates Gallery', 'icon' => 'fas fa-share-alt-square'],
        // ];
        $campaigns = [
            ['route' => route('admin.campaign.create'), 'name' => 'Prepare new Campaign', 'icon' => 'fas fa-share-alt-square'],
            ['route' => route('admin.campaign.index'), 'name' => 'All Campaigns', 'icon' => 'fas fa-share-alt-square'],
            ['route' => route('admin.campaign.index', ['status' => 'draft']), 'name' => 'Waiting List Campaigns', 'icon' => 'fas fa-share-alt-square'],
            ['route' => route('admin.campaign.index', ['status' => 'sent']), 'name' => 'Sent Campaigns', 'icon' => 'fas fa-share-alt-square'],
        ];
        $defaultgroups = [
            ['key' => 'recipients', 'name' => 'Recipients List', 'icon' => 'fas fa-cog'],
            ['route' => route('admin.get_subscribers'), 'name' => 'Subscribers', 'icon' => 'fas fa-share-alt-square'],
            ['route' => route('admin.landing_page_emails'), 'name' => 'Landing Page', 'icon' => 'fas fa-share-alt-square'],
        ];
        $sections = [
            ['title' => 'Dashboard', 'key' => 'dashboard', 'items' => $dashboard_section],
            ['title' => 'Bercoweb', 'key' => 'bercoweb', 'back' => 'dashboard', 'items' => $bercoweb],
            ['title' => 'Bercostore', 'key' => 'bercostore', 'back' => 'dashboard', 'items' => $bercostore],
            ['title' => 'Subscriber Section', 'key' => 'subscriber', 'back' => 'dashboard', 'items' => $subscriber],
            ['title' => 'Administration Users', 'key' => 'administration', 'back' => 'dashboard', 'items' => $administration],
            ['title' => 'General Settings', 'key' => 'general', 'back' => 'bercoweb', 'items' => $general_settings],
            ['title' => 'Page Settings', 'key' => 'page', 'back' => 'bercoweb', 'items' => $page_settings],
            ['title' => 'Blog Section', 'key' => 'blogsection', 'back' => 'dashboard', 'items' => $blog_section],
            ['title' => 'Career Section', 'key' => 'career', 'back' => 'bercoweb', 'items' => $career_section],
            ['title' => 'Emailer', 'key' => 'emailer', 'back' => 'dashboard', 'items' => $emailer],
            ['title' => 'Default Groups', 'key' => 'defaultgroups', 'back' => 'emailer', 'items' => $defaultgroups],
            ['title' => 'Recipients List', 'key' => 'recipients', 'back' => 'defaultgroups', 'items' => $recipients],
            ['title' => 'Campaigns', 'key' => 'campaigns', 'back' => 'emailer', 'items' => $campaigns],
            // ['title' => 'Eamil Layouts', 'key' => 'emaillayouts', 'back' => 'emailer', 'items' => $emaillayouts],
            ['title' => 'Page Settings', 'key' => 'smtpsetting', 'back' => 'emailer', 'items' => $smtpsetting],
        ];

    @endphp
    @php
        $generalSetting = App\Models\Admin\GeneralSetting::where('id', 1)->select('too_font_size')->first();

    @endphp
    @foreach ($sections as $section)
        <div class="row dashboard-page" id="{{ $section['key'] }}" style="display: @if($loop->iteration > 1) none @endif">
            <div class="col-xl-12 col-md-12 mb-2">
                <h1 class="h3 mb-3 text-gray-800">{{ $section['title'] }}</h1>
            </div>
            @if (isset($section['back']))
                <div class="col-xl-12 col-md-12 mb-5">
                    <a class="btn btn-success mt-3" href="javascript:;" onclick="toggleSection('{{ $section['back'] }}', true)">
                        <i class="fa fa-arrow-left mr-3"></i>Back to {{ ucwords($section['back']) }}
                    </a>
                </div>
            @endif
            @foreach ($section['items'] as $item)
                @if($section['key'] == 'dashboard')
                    @if (isset($assigned))
                        @if(in_array($item['code'], $assigned))
                            @php
                                $text=App\Models\ToolText::where('id',$item['code'])->first();

                            @endphp
                        <div class="col-xl-3 col-md-6 mb-4 card_with_text" @if(isset($item['key'])) onclick="toggleSection('{{ $item['key'] }}')" @endif  style="height: 150px;">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center" >
                                        <div class="col mr-2 text-center">
                                            <a href="{{ isset($item['route']) ? $item['route'] : 'javascript:;' }}">
                                                @if (isset($item['img']))
                                                    <img src="{{ asset($item['img']) }}" alt="" class="image" style=" width: {{$text->width}}%">

                                                    <p style="font-size: {{$generalSetting->too_font_size}}; margin-top:5px;" ><b>{{$text->text}}</b></p>
                                                @else
                                                    <h3>{{ $item['name'] ?? 'No Name' }}</h3>
                                                @endif
                                            </a>
                                        </div>

                                        {{-- <div class="col-auto">
                                            <i class="{{ $item['icon'] }} fa-2x text-gray-300"></i>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @else
                        @if (in_array($item['code'], $enabled_tools))
                            @continue
                        @endif

                        @php
                            $text=App\Models\ToolText::where('id',$item['code'])->first();
                        @endphp
                        <div class="col-xl-3 col-md-6 mb-4 card_with_text" @if(isset($item['key'])) onclick="toggleSection('{{ $item['key'] }}')" @endif  style="height: 150px;">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center" >
                                        <div class="col mr-2 text-center">
                                            <a href="{{ isset($item['route']) ? $item['route'] : 'javascript:;' }}">
                                                @if (isset($item['img']))
                                                    <img src="{{ asset($item['img']) }}" alt="" class="image" style=" width: {{$text->width}}%">

                                                    <p style="font-size: {{$generalSetting->too_font_size}}; margin-top:5px;" ><b>{{$text->text}}</b></p>
                                                @else
                                                    <h3>{{ $item['name'] ?? 'No Name' }}</h3>
                                                @endif
                                            </a>
                                        </div>

                                        {{-- <div class="col-auto">
                                            <i class="{{ $item['icon'] }} fa-2x text-gray-300"></i>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else

                <div class="col-xl-3 col-md-6 mb-4 card_with_text" @if(isset($item['key'])) onclick="toggleSection('{{ $item['key'] }}')" @endif  style="height: 150px;">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center" >
                                <div class="col mr-2 text-center">
                                    <a href="{{ isset($item['route']) ? $item['route'] : 'javascript:;' }}">
                                        @if (isset($item['img']))
                                            <img src="{{ asset($item['img']) }}" alt="" class="image" style=" width: {{$text->width}}%">
                                            @php
                                                $text=App\Models\ToolText::where('id',$item['code'])->first();
                                            @endphp
                                            <p style="font-size: {{$generalSetting->too_font_size}}; margin-top:5px;" ><b>{{$text->text}}</b></p>
                                        @else
                                            <h3>{{ $item['name'] ?? 'No Name' }}</h3>
                                        @endif
                                    </a>
                                </div>

                                {{-- <div class="col-auto">
                                    <i class="{{ $item['icon'] }} fa-2x text-gray-300"></i>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    @endforeach

    <script>
        const keys = ['dashboard', 'bercoweb', 'bercostore', 'subscriber', 'administration', 'general', 'page', 'blog', 'career','blogsection','emailer', 'recipients', 'smtpsetting', 'campaigns', 'emaillayouts', 'defaultgroups']
        function toggleSection(key, back = false)
        {
            const audio = new Audio("{{ asset('public/backend/ping-1.mp3') }}")
            audio.play()
            $(`#${key}`).show()
            keys.filter(elm => elm != key).map(el => $(`#${el}`).hide())
            if (back) {
                window.history.pushState({}, 'New Page', "{{ Request::url() }}" + '?page=1');
            } else {
                window.history.pushState({}, 'New Page', "{{ Request::url() }}" + '?page=2');
            }
        }
    </script>

@endsection
