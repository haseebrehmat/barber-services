@if ($page_home->tools_status == 'Show')

    <style>
        .team-photoo {
            position: relative;
            width: 200px;
            /* Adjust the width and height as needed */
            height: 200px;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
        }

        .team-photoo .tool_img {
            display: block;
            width: 100%;
            height: 100%;
            padding: 15px;
            overflow: hidden;
            transition: transform 0.3s ease-in-out;
            border-radius: 10px;
        }

        .team-photoo .tool_img:hover {
            transform: scale(1.1);
            /* Apply zoom-in effect on hover */
        }

        .team-photoo .tool_img img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            /* Ensure the image covers the container while maintaining aspect ratio */
            border-radius: 10px;
        }
        .center-content {
                display: flex;
                justify-content: center; /* Horizontal centering */
                align-items: center; /* Vertical centering */
            }
        .border-left-primary {
            border-left: .25rem solid #4e73df!important
        }
        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1.25rem
        }
        .h-100 {
            height: 100%!important;
        }     
    </style>

    @php
        $tools = [
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
            ['route' => route('landingpages.index'), 'img' => asset("public/uploads/$general_settings_global->bercotool_5"), 'icon' => 'fa fa-users' , 'code' => 5],
            ['route' => route('admin.landing_page_messages'), 'img' => asset("public/uploads/$general_settings_global->bercotool_8"), 'icon' => 'fas fa-users', 'code' => 8],
            ['route' => route('coupon.tool.index'), 'img' => $general_settings_global->bercotool_24 ? asset("public/uploads/$general_settings_global->bercotool_24") : 'https://placehold.co/1600x400?text=Coupons', 'icon' => 'fas fa-cog', 'code' => 24],
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
        ];

        $enabled_codes = isset($theme_color->home_tools) ? explode(',', $theme_color->home_tools) : [];
    @endphp

    <div class="team bg-lightblue">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading wow fadeInUp">
                        <h2>{{ $page_home->tools_title }}</h2>
                        <h3>{{ $page_home->tools_subtitle }}</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">

                        @foreach ($tools as $item)
                            @if (in_array($item['code'], $enabled_codes))
                                {{-- <div class="team-item wow fadeInDown border-0 col-md-3 center-content">
                                    <div class="team-photoo">
                                        <a href="#" class="tool_img">
                                            <img src="{{ $item['img'] }}" alt="Tools Photo">
                                        </a>
                                    </div>
                                </div> --}}


                                @php
                                $text=App\Models\ToolText::where('id',$item['code'])->first();
                                $generalSetting=App\Models\Admin\GeneralSetting::where('id',1)->first();

                                @endphp
                                <div class="col-xl-3 col-md-6 mb-4"  style="height: 150px;">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center" >
                                                <div class="col mr-2 text-center">
                                                    <a href="javascript:void(0)">
                                                        @if (isset($item['img']))
                                                            <img src="{{ asset($item['img']) }}" alt="" class="image" style="height: 68%; width: {{$text->width}}%">

                                                            <p style="font-size: {{$generalSetting->too_font_size}}; margin-top:5px;" ><b>{{$text->text}}</b></p>
                                                        @else
                                                            <h3>{{ $item['name'] ?? 'No Name' }}</h3>
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
