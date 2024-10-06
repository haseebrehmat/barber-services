<!-- Start Navbar Area -->
<div class="navbar-area" id="stickymenu">
    <!-- Mobile Navbar -->
    <div class="mobile-nav" style="background-color: black;">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Logo on the left -->
            <div class="logo-wrapper" style="text-align: center;
            flex-grow: 1; padding-left: 15%;">
                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ asset('public/uploads/'.$g_setting->logo_shop) }}" alt="" style="height: 90px;">
                </a>
            </div>
            <!-- Hamburger Icon on the right -->
            <button style="color: white; font-size:2.25rem" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mobileNavbar" aria-controls="mobileNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span>
            </button>
        </div>
        <!-- Mobile Menu -->
        <div class="collapse navbar-collapse" id="mobileNavbar">
            <ul class="navbar-nav">
                <!-- Cart Icon - Replace '#' with the actual link for the cart -->
                {{-- <li style="background-color: grey;" class="nav-item">
                    <a style="background-color: black; color:white;" href="{{ route('front.cart') }}" class="nav-link cart-icon" style="font-size: 22px; position: relative;">
                        <i class="fa fa-shopping-basket"></i>
                        <span class="cart-count">
                            @if(session()->get('cart_product_id'))
                                {{ count(session()->get('cart_product_id')) }}
                            @endif
                        </span>
                    </a>
                </li> --}}
                {{-- <!-- Login Button - Replace '#' with the actual link for login -->
                <li style="background-color: grey;" class="nav-item">
                    <a href="#" style="background-color: black; color:white;" class="nav-link">Login</a>
                </li>
                <!-- Register Button - Replace '#' with the actual link for registration -->
                <li style="background-color: grey;" class="nav-item">
                    <a href="#" style="background-color: black; color:white;" class="nav-link">Register</a>
                </li> --}}
                <li style="background-color: grey;" class="nav-item">
                    <a href="#" style="background-color: black; color:white;"  onclick="window.location.href='{{ route('homepage') }}'" class="nav-link">Back to Web</a>
                </li>
            </ul>
        </div>
    </div>
    
 
     <!-- Menu For Desktop Device -->
     <div class="main-nav" style="background: #{{$navbar_color}} !important;">
         <div class="container">
             <nav class="navbar navbar-expand-md navbar-light">
                 <!-- Logo -->
                 <a class="navbar-brand mr-3" href="{{ url('/') }}">
                     <!-- Add margin to the right side of the logo -->
                     <img src="{{ asset('public/uploads/'.$g_setting->logo_shop) }}" alt="logo" style="width: {{ $g_setting->logo_shop_width }}px !important;height: {{ $g_setting->logo_shop_height }}px !important;">
                 </a>
                 <!-- Cart Icon, Login, and Register Buttons -->
                 <div class="navbar-right d-flex align-items-center ml-auto">
                     <!-- Add margin to the left side of the container -->
                     <!-- Cart Icon - Replace '#' with the actual link for the cart -->
                     {{-- <a href="{{ route('front.cart') }}" class="nav-link cart-icon" style="font-size: 22px; position: relative;">
                         <i class="fa fa-shopping-basket"></i>
                         @if(session()->get('cart_product_id'))
                         <span class="cart-count">
                                 {{ count(session()->get('cart_product_id')) }}
                         </span>
                         @endif
                     </a> --}}
 
 
                     <!-- Login Button - Replace '#' with the actual link for login -->
                     <!-- Login Button - Replace '#' with the actual link for login -->
                     <!-- Login Button -->
                     {{-- <button type="button" class="btn btn-primary ml-2" style="border-radius: 15px;" onclick="window.location.href='{{ route('customer.login') }}'">Login</button>
 
                     <!-- Register Button -->
                     <button type="button" class="btn btn-primary ml-2" style="border-radius: 15px;" onclick="window.location.href='{{ route('customer.registration') }}'">Register</button> --}}
                     <button type="button" class="btn btn-info ml-2" style="border-radius: 15px;" onclick="window.location.href='{{ route('homepage') }}'">Back to Web</button>
 
 
                 </div>
                 <!-- Main Menu -->
                 @if(!request()->is('*shop*') && !request()->is('*product*') && !request()->is('*cart*') && !request()->is('*checkout*') && !request()->is('*payment*'))
                 <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                     <ul class="navbar-nav ml-auto" style="background: #{{$navbar_color}} !important;">
 
                         @foreach($menus as $row)
 
                         @if($row->menu_status == 'Show')
 
 
                         @if($row->menu_name=='Home')
                             <li class="nav-item" style="margin-top: -1px;">
                         @else
                             <li class="nav-item">
                         @endif
                             @if (count($row->sub_menu) > 0)
 
                             <a style="color: #{{$settings['items_color']}};" href="javascript:void(0);" class="nav-link dropdown-toggle">{{ $row->menu_name }}</a>
 
                             <ul class="dropdown-menu" style="background-color: #{{$settings['sub_items_bg_color']}} !important;">
 
                                 @foreach ($row->sub_menu as $sub)
 
                                     @if($sub->menu_status == 'Show')
                                         <li class="nav-item">
                                             <a style="color: #{{$settings['items_color']}};" href="{{ $sub->fixed ? route($sub->route) : url($sub->route) }}" class="nav-link" @if ($sub->menu_key == 'Shop') target='_blank' @endif>{{ $sub->menu_name }}</a>
                                         </li>
                                     @endif
 
                                 @endforeach
 
                             </ul>
 
                             @else
                                     @if($row->menu_key=='Home')
                                         <a style="color: #{{$settings['items_color']}}; border-top:none;" href="{{ route($row->route, ['menu' => 1]) }}" class="nav-link">{{ $row->menu_name }}</a>
                                     @else
                                         @if ($row->link==0)
                                             <a style="color: #{{$settings['items_color']}};" href="{{ $row->fixed ? route($row->route) : route($row->route) }}" class="nav-link" @if ($row->menu_key == 'Shop') target='_blank' @endif>{{ $row->menu_name }}</a>
                                         @endif
                                         @if ($row->link==1)
 
                                             <a target="_blank" style="color: #{{$settings['items_color']}};" href="{{ filter_var($row->route, FILTER_VALIDATE_URL) ? $row->route : ($row->fixed ? route($row->route) : route($row->route)) }}" class="nav-link" @if ($row->menu_key == 'Shop') target='_blank' @endif>{{ $row->menu_name }}</a>
 
                                         @endif
 
                                     @endif
                             @endif
 
                         </li>
                         @endif
 
                         @endforeach
 
                         {{-- Dynamic Pages --}}
 
                         @php
                         $dynamic_pages = DB::table('dynamic_pages')->get();
 
                         @endphp
 
                         @if ($dynamic_pages)
 
                         @foreach($dynamic_pages as $row)
 
                                 <li class="nav-item">
                                     <a style="color: #{{$settings['items_color']}};" href="{{ url('page/'.$row->dynamic_page_slug) }}" class="nav-link">{{
                                         $row->dynamic_page_name }}</a>
                                 </li>
 
                                 @endforeach
 
                         @endif
 
                         <li class="nav-item">
                             <a style="color: #{{$settings['items_color']}};" href="{{ route('customer.registration') }}" class="nav-link">Register</a>
                         </li>
                         <li class="nav-item">
                             <a style="color: #{{$settings['items_color']}};" href="{{ route('front.contact') }}" class="nav-link">CONTACT/HOURS</a>
                         </li>
                     </ul>
                 </div>
                 @endif
             </nav>
         </div>
     </div>
 </div>
 <!-- End Navbar Area -->
 