<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Admin Panel</title>

    @include('admin.includes.styles')

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400;700&display=swap" rel="stylesheet">
    @include('admin.includes.scripts')
    <style>
        #main_logo_mobile {
          /* default width and height based on Laravel variables */
          width: {{$general_settings_global->admin_logo_width}}px;
          height: {{$general_settings_global->admin_logo_height}}px;
        }

        @media (max-width: 767px) {
          #main_logo_mobile {
            /* override width and height for mobile screens */
            width: 100px;
            height: 50px;
          }
        }


        #menu_text1,#menu_text2,#menu_text3 {
          /* default width and height based on Laravel variables */
          font-size: 20px;
        }
        .collapse-item{
            font-size: 18px;
        }
        @media (max-width: 767px) {
            #menu_text1,#menu_text2,#menu_text3 {
            /* default width and height based on Laravel variables */
               font-size: 15px;
            }
        }

        @media (max-width: 767px) {
            .collapse-item{
                font-size: 15px;

            }
        }

      </style>
</head>

<body id="page-top" >

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion " id="accordionSidebar">

         <!-- Sidebar - Brand -->
         <img class="img-profile" id="main_logo_mobile"  src="{{ asset("public/uploads/$general_settings_global->admin_logo") }}">

        <!-- Divider -->
        <hr class="sidebar-divider my-0">


        @if(session('is_super') == 0)
        @php


        $url = Request::path();
        $conName = explode('/',$url);
        if(!isset($conName[3]))
        {
            $conName[3] = '';
        }
        if(!isset($conName[2]))
        {
            $conName[2] = '';
        }
        @endphp


        {{-- {{dd($conName)}} --}}
        @php

            if(Request::path()=='import_excel_contacts')
                {

                    $conName[1] = 'import_excel_contacts';
                }

                if(Request::path()=='admin_manual_messages')
                {

                    $conName[1] = 'admin_manual_messages';
                }
                if(Request::path()=='landing_page_messages')
                {

                    $conName[1] = 'landing_page_messages';
                }
                if(Request::path()=='compose_document')
                {

                    $conName[1] = 'compose_document';
                }
                if(Request::path()=='tools')
                {

                    $conName[1] = 'tools';
                }
                if(Request::path()=='file-manager')
                {

                    $conName[1] = 'file-manager';
                }
                if(Request::path()=='plan_payment')
                {

                    $conName[1] = 'plan_payment';
                }
                if(Request::path()=='plan_payment_history')
                {

                    $conName[1] = 'plan_payment_history';
                }

                if(Request::path()=='invoices')
                {

                    $conName[1] = 'invoices';
                }
                if(Request::path()=='get_subscribers')
                {

                    $conName[1] = 'get_subscribers';
                }
                if(Request::path()=='landing_page_emails')
                {

                    $conName[1] = 'landing_page_emails';
                }
                if(Request::path()=='import_excel_contacts_emailer')
                {

                    $conName[1] = 'import_excel_contacts_emailer';
                }
                if(Request::path()=='follow_up_customer')
                {

                    $conName[1] = 'follow_up_customer';
                }
                if(Request::path()=='landingpages_create')
                {

                    $conName[1] = 'landingpages_create';
                }
                if(Request::path()=='landingpages_index')
                {

                    $conName[1] = 'landingpages_index';
                }
        @endphp


        @php $arr_one = array(); @endphp
        @if(session('role_id')!=1)
            @php
                $row = array();
                $access_data = DB::table('role_permissions')
        ->join('role_pages', 'role_permissions.role_page_id', 'role_pages.id')
        ->where('role_id', session('role_id'))
        ->get();
            @endphp
            @foreach($access_data as $row)
                @php
                    if($row->access_status == 1):
                    $arr_one[] = $row->page_title;
                    endif;
                @endphp
            @endforeach
        @endif



        <li style="margin-top: 39px;"  class="nav-item active">
            <a class="nav-link" href="{{ route('admin.tools', 'page=1') }}">
                <i class="fas fa-link"></i>
                <span id="menu_text1">Bercotools</span>
            </a>
        </li>

        <li  class="nav-item active">
            <a class="nav-link" href="{{ route('admin.profile_change') }}">
                <i class="fas fa-user-circle"></i>
                <span id="menu_text2">Profile</span>
            </a>
        </li>
        <!-- Admin Users Section -->

        @if (session('type') === 'admin')
        <li class="nav-item  active ">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdminUser" aria-expanded="true" aria-controls="collapseAdminUser">
                <i class="fas fa-credit-card"></i>
                <span id="menu_text3">Payments</span>
            </a>
            <div id="collapseAdminUser" class="collapse @if($conName[1] == 'plan_payment' ||$conName[1] == 'invoices' || $conName[1] == 'plan_payment_history') show @endif" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div style="background: #4e73df" class="py-2 collapse-inner rounded">
                    <a style="background: none; color:white;" class="collapse-item" href="{{ route('admin.plan_payment') }}">Billing</a>
                    <a style="background: none; color:white;" class="collapse-item" href="{{ route('admin.plan_payment_history') }}">Purchase History</a>
                    <a style="background: none; color:white;" class="collapse-item" href="{{ route('admin.invoices') }}">Invoice</a>
                </div>
            </div>
        </li>
        @else
        {{-- <li  class="nav-item active">
            <a class="nav-link" href="{{ route('admin.employee.chat') }}">
                <i class="fas fa-comment"></i>
                <span id="menu_text2">Chat</span>
            </a>
        </li> --}}
        @endif

        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/clear-cache') }}">
                <i class="fas fa-circle-notch"></i>
                <span id="menu_text3">Clear Cache</span>
            </a>
        </li>


        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

        @else

        <li class="nav-item active">
            <a class="nav-link" href="{{ route('superadmin.message.limit') }}">
                <i class="fas fa-sliders-h"></i>
                <span>Software Limits</span>
            </a>
        </li>

        <li class="nav-item active">
            <a class="nav-link" href="{{ route('superadmin.landing_page_images') }}">
                <i class="fas fa-image"></i>
                <span>Landing Page Images</span>
            </a>
        </li>

        <li class="nav-item active">
            <a class="nav-link" href="{{ route('superadmin.landing_page_left_images') }}">
                <i class="fas fa-photo-video"></i>
                <span>Left Side Images</span>
            </a>
        </li>

        <li class="nav-item active">
            <a class="nav-link" href="{{ route('superadmin.logo') }}">
                <i class="fas fa-photo-video"></i>
                <span>Admin Logo</span>
            </a>
        </li>


        <li class="nav-item active">
            <a class="nav-link" href="{{ route('admin.plan_payment') }}">
                <i class="fas fa-credit-card"></i>
                <span>Admin Billing</span>
            </a>
        </li>

        <li class="nav-item active">
            <a class="nav-link" href="{{ route('superadmin.bercotool_images') }}">
                <i class="fas fa-photo-video"></i>
                <span>BercoTools Images</span>
            </a>
        </li>

        <li class="nav-item active">
            <a class="nav-link" href="{{ route('admin.email_template.gallery') }}">
                <i class="fas fa-th-large"></i>
                <span>Template Gallery</span>
            </a>
        </li>

        <li class="nav-item active">
            <a class="nav-link" href="{{ route('admin.coupon_design.index') }}">
                <i class="fab fa-flipboard"></i>
                <span>Coupon Designs</span>
            </a>
        </li>

        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/clear-cache') }}">
                <i class="fas fa-circle-notch"></i>
                <span>Clear Cache</span>
            </a>
        </li>

        @endif
    </ul>
    <!-- End of Sidebar -->


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">


                    <!-- Nav Item - Alerts -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="btn btn-info btn-sm mt-3" href="{{ $general_settings_global->default_homepage == 'website' ? url('/') : url('/shop') }}" target="_blank">
                            Visit Website
                        </a>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>
                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ session('name') }}</span>
                            <img class="img-profile rounded-circle" src="{{ asset('public/uploads/'.session('photo')) }}">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                            @if(session('id') == 1)
                            <a class="dropdown-item" href="{{ route('admin.profile_change') }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Change Profile
                            </a>
                            @endif

                            <a class="dropdown-item" href="{{ route('admin.password_change') }}">
                                <i class="fas fa-unlock-alt fa-sm fa-fw mr-2 text-gray-400"></i> Change Password
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.photo_change') }}">
                                <i class="fas fa-image fa-sm fa-fw mr-2 text-gray-400"></i> Change Photo
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('admin.logout') }}">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- End of Topbar -->
            <!-- Begin Page Content -->
            <div class="container-fluid">

                @yield('admin_content')

            </div>
            <!-- /.container-fluid -->
            <div class="py-2 px-4 float-right mr-5">
                <button class="btn btn-secondary" onClick="window.history.back();">
                    <i class="fas fa-hand-point-left"></i> Go Back
                </button>
            </div>
        </div>
        <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

@include('admin.includes.scripts-footer')
<script>
    $(document).ready(function() {
        // Check if the screen size is smaller than desktop
        if ($(window).width() < 992) {
            // Remove the 'show' class from the div with id 'collapseAdminUser'
            $('#collapseAdminUser').removeClass('show');
        }
    });
</script>
<script>
    function toggleClassOnMobile() {
       var divElement = document.getElementById('accordionSidebar');
       if (window.innerWidth <= 768) { // Adjust the breakpoint as needed
          divElement.classList.add('toggled');
       } else {
          divElement.classList.remove('toggled');
       }
    }

    // Initial check on page load
    toggleClassOnMobile();

    // Listen for window resize events
    window.addEventListener('resize', toggleClassOnMobile);
 </script>
<script>
    function hideWarning() {
        // Get the element with the specified class
        var warningElement = document.querySelector('.tox-notification--warning');

        // Check if the element is found
        if (warningElement) {
            // Hide the warning by setting display to none
            warningElement.style.display = 'none';
        }
    }

    // Use setTimeout to delay the execution of the script by 5 seconds
    setTimeout(hideWarning, 500); // 1000 milliseconds = 1 second
    setTimeout(hideWarning, 1000); // 1000 milliseconds = 1 second
    setTimeout(hideWarning, 3000); // 3000 milliseconds = 3 seconds
    setTimeout(hideWarning, 6000); // 6000 milliseconds = 6 seconds
</script>

</body>
</html>
