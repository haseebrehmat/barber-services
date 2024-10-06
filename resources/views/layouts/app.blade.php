@php
$g_setting = DB::table('general_settings')->where('id', 1)->first();
$s_media = DB::table('social_media_items')->orderBy('social_order', 'asc')->get();
$footer_col_1 = DB::table('footer_columns')->orderBy('column_item_order', 'asc')->where('column_name', 'Column 1')->get();
$footer_col_2 = DB::table('footer_columns')->orderBy('column_item_order', 'asc')->where('column_name', 'Column 2')->get();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>

    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('/public/manifest.json') }}">


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @php
        $navbar_color = \App\Models\Admin\GeneralSetting::where('id',1)->value('navbar_color');
    @endphp
    @php
    $url = Request::path();
    $conName = explode('/',$url);

    if(!isset($conName[1]))
    {
        $conName[1] = '';
    }
    if(!isset($conName[2]))
    {
        $conName[2] = '';
    }
    if(!isset($conName[3]))
    {
        $conName[3] = '';
    }
    @endphp

    @if($conName[0] == '')
        @php
            $item_row = DB::table('page_home_items')->where('id',1)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'about')
        @php
            $item_row = DB::table('page_about_items')->where('id',1)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'services')
        @php
            $item_row = DB::table('page_service_items')->where('id',1)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif



    @if($conName[0] == 'shop')
        @php
            $item_row = DB::table('page_shop_items')->where('id',1)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'cart')
        @php
            $item_row = DB::table('page_other_items')->where('id',2)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'checkout')
        @php
            $item_row = DB::table('page_other_items')->where('id',3)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif



    @if($conName[0] == 'category')
        @php
            $item_row = DB::table('categories')->where('category_slug',$conName[1])->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'blog' && $conName[1]=='')
        @php
            $item_row = DB::table('page_blog_items')->where('id',1)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'blog' && $conName[1]!='')
        @php
            $item_row = DB::table('blogs')->where('blog_slug',$conName[1])->first();
        @endphp




    @endif

    @if($conName[0] == 'career')
        @php
            $item_row = DB::table('page_career_items')->where('id',1)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'job' && $conName[2] == '')
        @php
            $item_row = DB::table('jobs')->where('job_slug',$conName[1])->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'job' && $conName[2] != '')
        @php
            $item_row = DB::table('jobs')->where('job_slug',$conName[2])->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'projects')
        @php
            $item_row = DB::table('page_project_items')->where('id',1)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'project')
        @php
            $item_row = DB::table('projects')->where('project_slug',$conName[1])->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'photo-gallery')
        @php
            $item_row = DB::table('page_photo_gallery_items')->where('id',1)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'video-gallery')
        @php
            $item_row = DB::table('page_video_gallery_items')->where('id',1)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'faq')
        @php
            $item_row = DB::table('page_faq_items')->where('id',1)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'team-members')
        @php
            $item_row = DB::table('page_team_items')->where('id',1)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'team-member')
        @php
            $item_row = DB::table('team_members')->where('slug',$conName[1])->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'contact')
        @php
            $item_row = DB::table('page_contact_items')->where('id',1)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'terms-and-conditions')
        @php
            $item_row = DB::table('page_term_items')->where('id',1)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'privacy-policy')
        @php
            $item_row = DB::table('page_privacy_items')->where('id',1)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'page')
        @php
            $item_row = DB::table('dynamic_pages')->where('dynamic_page_slug',$conName[1])->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'customer' && $conName[1] == 'payment')
        @php
            $item_row = DB::table('page_other_items')->where('id',8)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'customer' && $conName[1] == 'login')
        @php
            $item_row = DB::table('page_other_items')->where('id',4)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if(in_array($conName[0], ['customer', 'employee']) && $conName[1] == 'register')
        @php
            $item_row = DB::table('page_other_items')->where('id',5)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'customer' && $conName[1] == 'forget-password')
        @php
            $item_row = DB::table('page_other_items')->where('id',6)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'customer' && ($conName[1] == 'dashboard' || $conName[1] == 'order' || $conName[1] == 'profile-change' || $conName[1] == 'password-change') )
        @php
            $item_row = DB::table('page_other_items')->where('id',7)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'search')
        @php
            $item_row = DB::table('page_other_items')->where('id',1)->first();
        @endphp
        <meta name="description" content="{{ $item_row->seo_meta_description }}">
        <title>{{ $item_row->seo_title }}</title>
    @endif

    @if($conName[0] == 'reservation')
        <meta name="description" content="Create-Reservation">
        <title>Create Reservation</title>
    @endif

    @if($conName[0] == 'appointment')
        <meta name="description" content="Create-Appointment">
        <title>Create Appointment</title>
    @endif


    @include('layouts.styles')

    <!-- Favicon -->
    <link href="{{ asset('public/uploads/'.$g_setting->favicon) }}" rel="shortcut icon" type="image/png">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400;700&display=swap" rel="stylesheet">

    @include('layouts.scripts')

    <style>
        .top,
        .main-nav nav .navbar-nav .nav-item .dropdown-menu,
        .video-button:before,
        .video-button:after,
        .special .read-more a,
        .service .read-more a,
        .testimonial-bg,
        .project .read-more a,
        .team-text,
        .cta .overlay,
        .blog-area .blog-image .date,
        .blog-area .read-more a,
        .newsletter-area .overlay,
        .footer-social-link ul li a,
        .scroll-top,
        .single-section .read-more a,
        .sidebar .widget .search button,
        .comment button,
        .contact-item:hover .contact-icon,
        .product-item .text button,
        .btn-arf,
        .project-photo-carousel .owl-nav .owl-prev,
        .project-photo-carousel .owl-nav .owl-next,
        .faq h4.panel-title a,
        .team-social li a:hover,
        .doc_detail_social li i,
        .nav-doctor .nav-link.active,
        .product-detail button,
        .product-detail .nav-pills .nav-link.active,
        .contact-form .btn,
        .career-sidebar .widget button,
        .nav-pills .nav-item .nav-link.active {
            background: {{ '#'.$g_setting->theme_color }}!important;
        }
        .mean-bar{
            background-color: #{{$navbar_color}}!important;
        }
        .nav-pills .nav-item .nav-link.active {
            border-radius: 30px !important;
            color: #fff !important;
        }
        .nav-pills .nav-item .nav-link {
            color: {{ '#'.$g_setting->theme_color }}!important;
        }


        .main-nav nav .navbar-nav .nav-item a:hover,
        .main-nav nav .navbar-nav .nav-item:hover a,
        .service .service-item .text h3 a:hover,
        .project .project-item .text h3 a:hover,
        .blog-area .blog-item h3 a:hover,
        .footer-item ul li a:hover,
        .sidebar .widget .type-2 ul li a:hover,
        .sidebar .widget .type-1 ul li:before,
        .sidebar .widget .type-1 ul li a:hover,
        .single-section h3,
        .contact-icon,
        .product-item .text h3 a:hover,
        .career-main-item h3,
        .reg-login-form .new-user a,
        .product-detail .nav-pills .nav-link {
            color: {{ '#'.$g_setting->items_hover_color }}!important;
        }
        .text-animated li a:hover,
        .feature .feature-item {
            background-color: {{ '#'.$g_setting->theme_color }}!important;
        }
        .text-animated li a:hover,
        .special .read-more a,
        .footer-social-link ul li a,
        .contact-item:hover .contact-icon,
        .faq h4.panel-title,
        .team-social li a:hover,
        .contact-form .btn {
            border-color: {{ '#'.$g_setting->theme_color }}!important;
        }

        .main-nav nav .navbar-nav .nav-item .dropdown-menu li a{
            color: {{ '#'.$g_setting->items_color }}!important;
        }

        .main-nav nav .navbar-nav .nav-item .dropdown-menu li a:hover{
            color: {{ '#'.$g_setting->items_hover_color }}!important;
        }


        .contact-item:hover .contact-icon,
        .product-detail .nav-pills .nav-link.active {
            color: #fff!important;
        }
        .feature .feature-item:hover,
        .service .read-more a:hover,
        .project .read-more a:hover,
        .blog-area .read-more a:hover,
        .single-section .read-more a:hover,
        .comment button:hover,
        .doc_detail_social li:hover i,
        .product-detail button:hover,
        .contact-form .btn:hover {
            background: #333!important;
        }
        .footer-social-link ul li a:hover {
            background: transparent!important;
        }
        .special .read-more a:hover {
            background: transparent!important;
            border-color: #fff!important;
        }


        .codeless-add-purchase-button {
    position: fixed;
    bottom: 24px;
    right: 20px;
    height: 70px;
    border: none;
    -webkit-border-radius: 100%;
    border-radius: 100%;
    color: #fff;
    padding: 0;
    padding-right: 10px;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    z-index: 99;
    font-size: 0;
    font-weight: bold;
    color: #fff !important;
    -webkit-transition: all .3s;
    -o-transition: all .3s;
    transition: all .3s;
}


.codeless-add-purchase-button i.icon {
    height: 50px;
    width: 50px;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    position: relative;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -webkit-justify-content: center;
    -ms-flex-pack: center;
    justify-content: center;
    background-color: #F2BC3C;
    -webkit-border-radius: 50%;
    border-radius: 50%;
    margin: 10px 0 10px 10px;
    -webkit-transition: all cubic-bezier(.4, 0, .2, 1) .4s;
    -o-transition: all cubic-bezier(.4, 0, .2, 1) .4s;
    transition: all cubic-bezier(.4, 0, .2, 1) .4s;
}

.codeless-add-purchase-button i.icon svg {
    height: 30px;
    position: relative;
    bottom: 1px;
}

.codeless-add-purchase-button i.icon:after {
    content: "";
    position: fixed;
    display: block;
    height: 70px;
    width: 70px;
    background: rgb(242 188 60 / 40%);
    z-index: -1;
    -webkit-border-radius: 50%;
    border-radius: 50%;
    -webkit-transform: scale(1);
    -ms-transform: scale(1);
    transform: scale(1);
    -webkit-animation: 3s ease-in-out infinite pulse;
    animation: 3s ease-in-out infinite pulse;
}


    .cart-icon {
            position: relative;
        }

    .cart-count {
        position: absolute;
        top: 50%; /* Adjust the vertical position */
        right: 50%; /* Adjust the horizontal position */
        transform: translate(157%, -111%);
        background-color: yellow;
        color: black;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 12px;
    }

@-webkit-keyframes pulse {
    0% {
        -webkit-transform: scale(1);
        transform: scale(1);
        opacity: 0
    }
    25% {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
        opacity: 1
    }
    55% {
        -webkit-transform: scale(1);
        transform: scale(1);
        opacity: 0
    }
    100% {
        -webkit-transform: scale(1);
        transform: scale(1);
        opacity: 0
    }
}

@keyframes  pulse {
    0% {
        -webkit-transform: scale(1);
        transform: scale(1);
        opacity: 0
    }
    25% {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
        opacity: 1
    }
    55% {
        -webkit-transform: scale(1);
        transform: scale(1);
        opacity: 0
    }
    100% {
        -webkit-transform: scale(1);
        transform: scale(1);
        opacity: 0
    }
}


    </style>


</head>
<body>

@if($g_setting->preloader_status == 'Show')
<div id="preloader">
    <div id="status" style="background-image: url({{ asset('public/uploads/'.$g_setting->preloader_photo) }})"></div>
</div>
@endif

@if (Request::getHost()!='prismafreight.com')


    <div class="top">
        <div class="container">
            <div class="row">
                @if( !request()->is('*product*') && !request()->is('*cart*') && !request()->is('*checkout*') && !request()->is('*payment*'))

                @if(request()->is('*shop*') || request()->is('*product*') || request()->is('*cart*') || request()->is('*checkout*') || request()->is('*payment*'))
                    <div class="col-md-4">
                        <div class="top-contact">
                            <ul>
                                <li>
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                    <span>{{ $g_setting->top_bar_email }}</span>
                                    <span> </span><br>
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                    {{-- Office (818) 348-1234 Owner (818) 916-7725 --}}
                                    <a style="color: white;" href="tel: (818) 916-7725">Office (818) 916-7725</a><br>
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                      
                                </li>

                            </ul>
                        </div>
                    </div>
                @else
                    <div class="col-md-4">
                        <div class="top-contact">
                            <ul>
                                <li>
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                    <strong style="font-size: 16px;">{{ $g_setting->top_bar_email }}</strong>
                                </li>
                                <li>
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                    {{-- Office (818) 348-1234 Owner (818) 916-7725 --}}
                                    <strong style="font-size: 16px;"><a style="color: white;" href="tel: (818) 916-7725">Office (818) 916-7725</a></strong><br>
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                    <strong style="font-size: 16px;"><a style="color: white;" href="tel: (818) 703-1890">Shop (818) 703-1890</a></strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif

                @php
                    $today = \Carbon\Carbon::today();
                    $day = $today->format('l');
                    $timing = DB::table('store_timings')->where("day", $day)->first();
                    $currentTime = \Carbon\Carbon::now()->format('H:i');
                    $opened = false;
                    $not_set = false;
                    if ($timing) {
                        if ($timing->off_day) {
                           $status = "Day OFF";
                           $not_set = true;
                        } else {
                            if (isset($timing->open_time) && isset($timing->close_time)) {
                                if ($currentTime >= $timing->open_time && $currentTime <= $timing->close_time) {
                                    $status = 'Open Now';
                                    $opened = true;
                                } else {
                                    $status = 'Closed Now';
                                }
                            } else {
                                $status = "Please set timimgs";
                                $not_set = true;
                            }
                        }
                    } else {
                        $status = "Please set timimgs";
                        $not_set = true;
                    }
                @endphp
                <div class="col-md-4">
                    <div class="top-contact text-center">
                        @if ($not_set)
                            <strong style="font-size: 18px;">
                                {{ $status }}
                            </strong>
                        @else
                            <strong style="font-size: 18px;color: {{ $opened ? $g_setting->shop_open_status_color : $g_setting->shop_close_status_color }};">
                                {{ isset($timing->open_time) ? \Carbon\Carbon::parse($timing->open_time)->format('h:i A') : 'n/a' }} - {{  isset($timing->close_time) ? \Carbon\Carbon::parse($timing->close_time)->format('h:i A') : 'n/a' }} {{ $status }}
                            </strong>
                        @endif
                    </div>
                </div>

                @endif
                @if(request()->is('*shop*') || request()->is('*product*') || request()->is('*cart*') || request()->is('*checkout*') || request()->is('*payment*'))
                    <div class="col-md-4" >
                        <div  class="top-right">
                @else
                    <div class="col-md-4" >
                        <div  class="top-right">
                @endif


                        @if($g_setting->top_bar_social_status == 'Show')
                        <div class="top-social">
                            <ul>
                                @foreach($s_media as $row)
                                    <li><a href="{{ $row->social_url }}" target="_blank"><i class="{{ $row->social_icon }}"></i></a></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @php
                            $menus = DB::table('menus')->get();
                            $menu_arr = array();
                        @endphp

                        @foreach($menus as $row)
                            @php
                                $menu_arr[$row->menu_name] = $row->menu_status;
                            @endphp
                        @endforeach

                        {{-- @if($menu_arr['Shop'] == 'Show') --}}
                        <div class="top-profile">
                            <ul>
                                @if(!session()->get('customer_id'))

                                    {{-- @if(request()->is('*shop*') || request()->is('*product*') || request()->is('*cart*') || request()->is('*checkout*') || request()->is('*payment*'))
                                        @if($g_setting->top_bar_login_status == 'Show')
                                        <li class="login_top_menu">
                                            <a href="{{ route('customer.login') }}">Login</a>
                                        </li>
                                        @endif
                                    @endif --}}

                                 

                                    {{-- @if(request()->is('*shop*') || request()->is('*product*') || request()->is('*cart*') || request()->is('*checkout*') || request()->is('*payment*'))
                                        @if($g_setting->top_bar_registration_status == 'Show')
                                        <li class="registration_top_menu">
                                            <a href="{{ route('customer.registration') }}">Registration</a>
                                        </li>
                                        @endif
                                    @endif --}}
                                    

                                    @if ($g_setting->reservation_status=='true')
                                        @if(request()->is('*shop*') || request()->is('*product*') || request()->is('*cart*') || request()->is('*checkout*') || request()->is('*payment*'))
                                            @if (!in_array(15, $enabled_tools))
                                            <li class="registration_top_menu">

                                                <a href="{{ route('reservation.create') }}">{{$g_setting->reservation_text}}</a>
                                            </li>
                                            @endif
                                        @endif
                                    @endif

                                    {{-- @if (!in_array(16, $enabled_tools))
                                    <li class="registration_top_menu">
                                        <a href="{{ route('appointment.create') }}">Appointment</a>
                                    </li>
                                    @endif --}}

                                @endif

                                @if(session()->get('customer_id'))
                                <li class="registration_top_menu">
                                    <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                                </li>
                                @endif
                                {{-- @if(request()->is('*shop*') || request()->is('*product*') || request()->is('*cart*') || request()->is('*checkout*') || request()->is('*payment*'))
                                    @if($g_setting->top_bar_cart_status == 'Show')
                                    <li class="cart">
                                        <a href="{{ route('front.cart') }}">Cart </a>
                                        @if(session()->get('cart_product_id'))
                                        <div class="number number_cart">{{ count(session()->get('cart_product_id')) }}</div>
                                        @endif
                                    </li>
                                    @endif
                                @endif --}}
                            </ul>
                        </div>
                        {{-- @endif --}}


                    </div>
                </div>
            </div>
        </div>
    </div>

@endif
{{-- 
@if(request()->is('*shop*') || request()->is('*product*') || request()->is('*cart*') || request()->is('*checkout*') || request()->is('*payment*'))
    @include('layouts.nav_shop')
@else --}}
    @include('layouts.nav')
{{-- @endif --}}


@yield('content')

<div class="footer-area" style="background-color: black;">
    <div class="container">
        <div class="row">

            <div class="col-lg-8 col-md-6 col-sm-6">
                <div class="footer-item footer-contact">
                    <h2>{{ $g_setting->footer_column3_heading }}</h2>
                    <ul>
                        <li>{{ $g_setting->footer_address }}</li>
                        <li>{{ $g_setting->footer_email }}</li>
                        <li>{{ $g_setting->footer_phone }}</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="footer-item footer-service">
                    <h2>{{ $g_setting->footer_column4_heading }}</h2>
                    <div class="footer-social-link">
                        <ul>
                            @foreach($s_media as $row)
                                <li><a href="{{ $row->social_url }}" target="_blank"><i class="{{ $row->social_icon }}"></i></a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row footer-end">
            <div class="col-md-6">
                <div class="copyright">
                    <p>{{ $g_setting->footer_copyright }}</p>
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="footer-pages">
                    <ul>
                        <li><a href="{{ route('front.term') }}">Terms and Conditions</a></li>
                        <li><a href="{{ route('front.privacy') }}">Privacy Policy</a></li>
                    </ul>
                </div>
            </div> --}}
        </div>
    </div>
</div>

<div class="scroll-top">
    <i class="fa fa-angle-up"></i>
</div>

@include('layouts.scripts_footer')
<a target="_blank" class="codeless-add-purchase-button" href="https://wa.me/+18189791428"><i class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 39 39"><path fill="#00E676" d="M10.7 32.8l.6.3c2.5 1.5 5.3 2.2 8.1 2.2 8.8 0 16-7.2 16-16 0-4.2-1.7-8.3-4.7-11.3s-7-4.7-11.3-4.7c-8.8 0-16 7.2-15.9 16.1 0 3 .9 5.9 2.4 8.4l.4.6-1.6 5.9 6-1.5z"></path><path fill="#FFF" d="M32.4 6.4C29 2.9 24.3 1 19.5 1 9.3 1 1.1 9.3 1.2 19.4c0 3.2.9 6.3 2.4 9.1L1 38l9.7-2.5c2.7 1.5 5.7 2.2 8.7 2.2 10.1 0 18.3-8.3 18.3-18.4 0-4.9-1.9-9.5-5.3-12.9zM19.5 34.6c-2.7 0-5.4-.7-7.7-2.1l-.6-.3-5.8 1.5L6.9 28l-.4-.6c-4.4-7.1-2.3-16.5 4.9-20.9s16.5-2.3 20.9 4.9 2.3 16.5-4.9 20.9c-2.3 1.5-5.1 2.3-7.9 2.3zm8.8-11.1l-1.1-.5s-1.6-.7-2.6-1.2c-.1 0-.2-.1-.3-.1-.3 0-.5.1-.7.2 0 0-.1.1-1.5 1.7-.1.2-.3.3-.5.3h-.1c-.1 0-.3-.1-.4-.2l-.5-.2c-1.1-.5-2.1-1.1-2.9-1.9-.2-.2-.5-.4-.7-.6-.7-.7-1.4-1.5-1.9-2.4l-.1-.2c-.1-.1-.1-.2-.2-.4 0-.2 0-.4.1-.5 0 0 .4-.5.7-.8.2-.2.3-.5.5-.7.2-.3.3-.7.2-1-.1-.5-1.3-3.2-1.6-3.8-.2-.3-.4-.4-.7-.5h-1.1c-.2 0-.4.1-.6.1l-.1.1c-.2.1-.4.3-.6.4-.2.2-.3.4-.5.6-.7.9-1.1 2-1.1 3.1 0 .8.2 1.6.5 2.3l.1.3c.9 1.9 2.1 3.6 3.7 5.1l.4.4c.3.3.6.5.8.8 2.1 1.8 4.5 3.1 7.2 3.8.3.1.7.1 1 .2h1c.5 0 1.1-.2 1.5-.4.3-.2.5-.2.7-.4l.2-.2c.2-.2.4-.3.6-.5s.4-.4.5-.6c.2-.4.3-.9.4-1.4v-.7s-.1-.1-.3-.2z"></path></svg></i></a>



    <script>
        const preLoad = function () {
    return caches.open("offline").then(function (cache) {
        // caching index and important routes
        return cache.addAll(filesToCache);
    });
    };

    self.addEventListener("install", function (event) {
    event.waitUntil(preLoad());
    });

    const filesToCache = [
    '/',
    '/offline.html'
    ];

    const checkResponse = function (request) {
    return new Promise(function (fulfill, reject) {
        fetch(request).then(function (response) {
            if (response.status !== 404) {
                fulfill(response);
            } else {
                reject();
            }
        }, reject);
    });
    };

    const addToCache = function (request) {
    return caches.open("offline").then(function (cache) {
        return fetch(request).then(function (response) {
            return cache.put(request, response);
        });
    });
    };

    const returnFromCache = function (request) {
    return caches.open("offline").then(function (cache) {
        return cache.match(request).then(function (matching) {
            if (!matching || matching.status === 404) {
                return cache.match("offline.html");
            } else {
                return matching;
            }
        });
    });
    };

    self.addEventListener("fetch", function (event) {
    event.respondWith(checkResponse(event.request).catch(function () {
        return returnFromCache(event.request);
    }));
    if(!event.request.url.startsWith('http')){
        event.waitUntil(addToCache(event.request));
    }
    });
    </script>
    <script>
    if (!navigator.serviceWorker.controller) {
    navigator.serviceWorker.register("/public/sw.js").then(function (reg) {
        console.log("Service worker has been registered for scope: " + reg.scope);
    });
    }
    </script>


</body>
</html>
