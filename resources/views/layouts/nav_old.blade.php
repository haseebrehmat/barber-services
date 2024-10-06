@php
$navbar_color = \App\Models\Admin\GeneralSetting::where('id',1)->value('navbar_color');
$menus = DB::table('menus')->get();
$menu_arr = array();
@endphp

@foreach($menus as $row)
    @php
        $menu_arr[$row->menu_key] = [$row->menu_status, $row->menu_name];
    @endphp
@endforeach

<!-- Start Navbar Area -->
<div class="navbar-area" id="stickymenu">

    <!-- Menu For Mobile Device -->
    <div class="mobile-nav">
        <a href="" class="logo">
            <img src="{{ asset('public/uploads/'.$g_setting->logo) }}" alt="">
        </a>
    </div>

    <!-- Menu For Desktop Device -->
    <div class="main-nav" style="background: #{{$navbar_color}} !important;">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('public/uploads/'.$g_setting->logo) }}" alt="logo" class="max-width: {{$g_setting->logo_width}}px !important;max-height: {{$g_setting->logo_height}}px !important;">
                </a>
                <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">

                        @if($menu_arr['Home'][0] == 'Show')
                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link">{{$menu_arr['Home'][1] ?? 'Home'}}</a>
                        </li>
                        @endif

                        @if($menu_arr['About'][0] == 'Show')
                        <li class="nav-item">
                            <a href="{{ route('front.about') }}" class="nav-link ">{{$menu_arr['About'][1] ?? 'About'}}</a>
                        </li>
                        @endif

                        @if($menu_arr['Services'][0] == 'Show')
                        <li class="nav-item">
                            <a href="{{ route('front.services') }}" class="nav-link ">{{$menu_arr['Services'][1] ?? 'Services'}}</a>
                        </li>
                        @endif

                        @if($menu_arr['Shop'][0] == 'Show')
                        <li class="nav-item">
                            <a href="{{ route('front.shop') }}" class="nav-link ">{{$menu_arr['Shop'][1] ?? 'Shop'}}</a>
                        </li>
                        @endif

                        @if($menu_arr['Blog'][0] == 'Show')
                        <li class="nav-item">
                            <a href="{{ route('front.blogs') }}" class="nav-link ">{{$menu_arr['Blog'][1] ?? 'Blog'}}</a>
                        </li>
                        @endif


                        @php
                            $dynamic_pages = DB::table('dynamic_pages')->get();
                        @endphp


                        @if(
                        ($menu_arr['Career'][0] == 'Hide') &&
                        ($menu_arr['Project'][0] == 'Hide') &&
                        ($menu_arr['Photo Gallery'][0] == 'Hide') &&
                        ($menu_arr['Video Gallery'][0] == 'Hide') &&
                        ($menu_arr['FAQ'][0] == 'Hide') &&
                        ($menu_arr['Team Members'][0] == 'Hide') &&
                        (!$dynamic_pages)
                        )

                        @else
                        <li class="nav-item">
                            <a href="javascript:void(0);" class="nav-link dropdown-toggle">Pages</a>
                            <ul class="dropdown-menu">

                                @if($menu_arr['Career'][0] == 'Show')
                                <li class="nav-item">
                                    <a href="{{ route('front.career') }}" class="nav-link">{{$menu_arr['Career'][1] ?? 'Career'}}</a>
                                </li>
                                @endif

                                @if($menu_arr['Project'][0] == 'Show')
                                <li class="nav-item">
                                    <a href="{{ route('front.projects') }}" class="nav-link">{{$menu_arr['Project'][1] ?? 'Projects'}}</a>
                                </li>
                                @endif

                                @if($menu_arr['Photo Gallery'][0] == 'Show')
                                <li class="nav-item">
                                    <a href="{{ route('front.photo_gallery') }}" class="nav-link">{{$menu_arr['Photo Gallery'][1] ?? 'Photo Gallery'}}</a>
                                </li>
                                @endif

                                @if($menu_arr['Video Gallery'][0] == 'Show')
                                <li class="nav-item">
                                    <a href="{{ route('front.video_gallery') }}" class="nav-link">{{$menu_arr['Video Gallery'][1] ?? 'Video Gallery'}}</a>
                                </li>
                                @endif

                                @if($menu_arr['FAQ'][0] == 'Show')
                                <li class="nav-item">
                                    <a href="{{ route('front.faq') }}" class="nav-link">{{$menu_arr['FAQ'][1] ?? 'FAQ'}}</a>
                                </li>
                                @endif

                                @if($menu_arr['Team Members'][0] == 'Show')
                                <li class="nav-item">
                                    <a href="{{ route('front.team_members') }}" class="nav-link">{{$menu_arr['Team Members'][1] ?? 'Team Members'}}</a>
                                </li>
                                @endif


                                @foreach($dynamic_pages as $row)
                                    <li class="nav-item">
                                        <a href="{{ url('page/'.$row->dynamic_page_slug) }}" class="nav-link">{{ $row->dynamic_page_name }}</a>
                                    </li>
                                @endforeach

                            </ul>
                        </li>
                        @endif


                        @if($menu_arr['Contact'][0] == 'Show')
                        <li class="nav-item">
                            <a href="{{ route('front.contact') }}" class="nav-link ">Contact</a>
                        </li>
                        @endif

                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- End Navbar Area -->
