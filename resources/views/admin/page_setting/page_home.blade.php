@extends('admin.admin_layouts')
@section('admin_content')

    <style>
        .col {
            /* Set the width of the parent div */
            width: 200px;
            /* Set the height of the parent div */
            height: 45px;
        }

        .image {
            /* Set the maximum width and height to 100% of the parent div's dimensions */
            max-width: 100%;
            max-height: 100%;
        }

        .checkboxx {
            width: 20px;
            height: 20px;
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
    @endphp

    <h1 class="h3 mb-3 text-gray-800">Edit Home Page Information</h1>

    <div class="card shadow mb-4 t-left">
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Meta Information</a>
                        <a class="nav-link" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">Why Choose Us Section</a>
                        <a class="nav-link" id="v-pills-13-tab" data-toggle="pill" href="#v-pills-13" role="tab" aria-controls="v-pills-13" aria-selected="false">Mp3 / Audio files</a>
                        <a class="nav-link" id="v-pills-14-tab" data-toggle="pill" href="#v-pills-14" role="tab" aria-controls="v-pills-14" aria-selected="false">Podcasts</a>
                        <a class="nav-link" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="false">Special Section</a>
                        <a class="nav-link" id="v-pills-4-tab" data-toggle="pill" href="#v-pills-4" role="tab" aria-controls="v-pills-4" aria-selected="false">Service Section</a>
                        <a class="nav-link" id="v-pills-5-tab" data-toggle="pill" href="#v-pills-5" role="tab" aria-controls="v-pills-5" aria-selected="false">Testimonial Section</a>
                        <a class="nav-link" id="v-pills-11-tab" data-toggle="pill" href="#v-pills-11" role="tab" aria-controls="v-pills-11" aria-selected="false">Pricing Section</a>
                        <a class="nav-link" id="v-pills-12-tab" data-toggle="pill" href="#v-pills-12" role="tab" aria-controls="v-pills-12" aria-selected="false">Tools Section</a>
                        <a class="nav-link" id="v-pills-6-tab" data-toggle="pill" href="#v-pills-6" role="tab" aria-controls="v-pills-6" aria-selected="false">Project Section</a>
                        <a class="nav-link" id="v-pills-7-tab" data-toggle="pill" href="#v-pills-7" role="tab" aria-controls="v-pills-7" aria-selected="false">Team Member Section</a>
                        <a class="nav-link" id="v-pills-8-tab" data-toggle="pill" href="#v-pills-8" role="tab" aria-controls="v-pills-8" aria-selected="false">Appointment Section</a>
                        <a class="nav-link" id="v-pills-9-tab" data-toggle="pill" href="#v-pills-9" role="tab" aria-controls="v-pills-9" aria-selected="false">Latest Blog Section</a>
                        <a class="nav-link" id="v-pills-10-tab" data-toggle="pill" href="#v-pills-10" role="tab" aria-controls="v-pills-10" aria-selected="false">Newsletter Section</a>
                    </div>
                </div>
                <div class="col-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-1-tab">

                            <!-- Tab 1 -->
                            <form action="{{ url('admin/page/home/1') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="seo_title" class="form-control" value="{{ $page_home->seo_title }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Meta Description</label>
                                    <textarea name="seo_meta_description" class="form-control h_100" cols="30" rows="10">{{ $page_home->seo_meta_description }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                            <!-- // Tab 1 -->

                        </div>
                        <div class="tab-pane fade " id="v-pills-13" role="tabpanel" aria-labelledby="v-pills-13-tab">

                            <!-- Tab 13 -->
                            <form action="{{ url('admin/page/home/13') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="audio_title" class="form-control" value="{{ $page_home->audio_title }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Subtitle</label>
                                    <input type="text" name="audio_subtitle" class="form-control" value="{{ $page_home->audio_subtitle }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="audio_status" id="rr1" value="Show" @if($page_home->audio_status == 'Show') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr1">Show</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="audio_status" id="rr2" value="Hide" @if($page_home->audio_status == 'Hide') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr2">Hide</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                            <!-- // Tab 13 -->

                        </div>

                        <div class="tab-pane fade " id="v-pills-14" role="tabpanel" aria-labelledby="v-pills-14-tab">

                            <!-- Tab 14 -->
                            <form action="{{ url('admin/page/home/14') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="podcast_title" class="form-control" value="{{ $page_home->podcast_title }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Subtitle</label>
                                    <input type="text" name="podcast_subtitle" class="form-control" value="{{ $page_home->podcast_subtitle }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="podcast_status" id="rr1" value="Show" @if($page_home->podcast_status == 'Show') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr1">Show</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="podcast_status" id="rr2" value="Hide" @if($page_home->podcast_status == 'Hide') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr2">Hide</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                            <!-- // Tab 14 -->

                        </div>
                        <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-2-tab">
                            <!-- Tab 2 -->
                            <form action="{{ url('admin/page/home/2') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="why_choose_title" class="form-control" value="{{ $page_home->why_choose_title }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Subtitle</label>
                                    <input type="text" name="why_choose_subtitle" class="form-control" value="{{ $page_home->why_choose_subtitle }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="why_choose_status" id="rr1" value="Show" @if($page_home->why_choose_status == 'Show') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr1">Show</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="why_choose_status" id="rr2" value="Hide" @if($page_home->why_choose_status == 'Hide') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr2">Hide</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                            <!-- // Tab 2 -->
                        </div>
                        <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-3-tab">
                            <!-- Tab 3 -->
                            <form action="{{ url('admin/page/home/3') }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="current_photo" value="{{ $page_home->special_bg }}">
                                <input type="hidden" name="current_photo1" value="{{ $page_home->special_video_bg }}">
                                @csrf
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="special_title" class="form-control" value="{{ $page_home->special_title }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Subtitle</label>
                                    <input type="text" name="special_subtitle" class="form-control" value="{{ $page_home->special_subtitle }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Content</label>
                                    <textarea name="special_content" class="form-control h_200" cols="30" rows="10">{{ $page_home->special_content }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Button Text</label>
                                    <input type="text" name="special_btn_text" class="form-control" value="{{ $page_home->special_btn_text }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Button URL</label>
                                    <input type="text" name="special_btn_url" class="form-control" value="{{ $page_home->special_btn_url }}">
                                </div>
                                <div class="form-group">
                                    <label for="">YouTube Video Preview</label>
                                    <div class="iframe-container-300">
                                        <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $page_home->special_yt_video }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">YouTube Video</label>
                                    <input type="text" name="special_yt_video" class="form-control" value="{{ $page_home->special_yt_video }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Existing Background</label>
                                    <div><img src="{{ asset('public/uploads/'.$page_home->special_bg) }}" alt="" class="w_200"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Change Background</label>
                                    <div><input type="file" name="special_bg"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Existing Video Background</label>
                                    <div><img src="{{ asset('public/uploads/'.$page_home->special_video_bg) }}" alt="" class="w_200"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Change Video Background</label>
                                    <div><input type="file" name="special_video_bg"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="special_status" id="rr1" value="Show" @if($page_home->special_status == 'Show') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr1">Show</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="special_status" id="rr2" value="Hide" @if($page_home->special_status == 'Hide') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr2">Hide</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                            <!-- // Tab 3 -->
                        </div>
                        <div class="tab-pane fade" id="v-pills-4" role="tabpanel" aria-labelledby="v-pills-4-tab">
                            <!-- Tab 4 -->
                            <form action="{{ url('admin/page/home/4') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="service_title" class="form-control" value="{{ $page_home->service_title }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Subtitle</label>
                                    <input type="text" name="service_subtitle" class="form-control" value="{{ $page_home->service_subtitle }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="service_status" id="rr1" value="Show" @if($page_home->service_status == 'Show') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr1">Show</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="service_status" id="rr2" value="Hide" @if($page_home->service_status == 'Hide') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr2">Hide</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                            <!-- // Tab 4 -->
                        </div>
                        <div class="tab-pane fade" id="v-pills-5" role="tabpanel" aria-labelledby="v-pills-5-tab">
                            <!-- Tab 5 -->
                            <form action="{{ url('admin/page/home/5') }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="current_photo" value="{{ $page_home->testimonial_bg }}">
                                @csrf
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="testimonial_title" class="form-control" value="{{ $page_home->testimonial_title }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Subtitle</label>
                                    <input type="text" name="testimonial_subtitle" class="form-control" value="{{ $page_home->testimonial_subtitle }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Existing Background</label>
                                    <div><img src="{{ asset('public/uploads/'.$page_home->testimonial_bg) }}" alt="" class="w_200"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Change Background</label>
                                    <div><input type="file" name="testimonial_bg"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="testimonial_status" id="rr1" value="Show" @if($page_home->testimonial_status == 'Show') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr1">Show</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="testimonial_status" id="rr2" value="Hide" @if($page_home->testimonial_status == 'Hide') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr2">Hide</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                            <!-- // Tab 5 -->
                        </div>
                        <div class="tab-pane fade" id="v-pills-6" role="tabpanel" aria-labelledby="v-pills-6-tab">
                            <!-- Tab 6 -->
                            <form action="{{ url('admin/page/home/6') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="project_title" class="form-control" value="{{ $page_home->project_title }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Subtitle</label>
                                    <input type="text" name="project_subtitle" class="form-control" value="{{ $page_home->project_subtitle }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="project_status" id="rr1" value="Show" @if($page_home->project_status == 'Show') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr1">Show</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="project_status" id="rr2" value="Hide" @if($page_home->project_status == 'Hide') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr2">Hide</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                            <!-- // Tab 6 -->
                        </div>
                        <div class="tab-pane fade" id="v-pills-7" role="tabpanel" aria-labelledby="v-pills-7-tab">
                            <!-- Tab 7 -->
                            <form action="{{ url('admin/page/home/7') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="team_member_title" class="form-control" value="{{ $page_home->team_member_title }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Subtitle</label>
                                    <input type="text" name="team_member_subtitle" class="form-control" value="{{ $page_home->team_member_subtitle }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="team_member_status" id="rr1" value="Show" @if($page_home->team_member_status == 'Show') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr1">Show</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="team_member_status" id="rr2" value="Hide" @if($page_home->team_member_status == 'Hide') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr2">Hide</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                            <!-- // Tab 7 -->
                        </div>
                        <div class="tab-pane fade" id="v-pills-8" role="tabpanel" aria-labelledby="v-pills-8-tab">
                            <!-- Tab 8 -->
                            <form action="{{ url('admin/page/home/8') }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="current_photo" value="{{ $page_home->appointment_bg }}">
                                @csrf
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="appointment_title" class="form-control" value="{{ $page_home->appointment_title }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Text</label>
                                    <textarea name="appointment_text" class="form-control h_100" cols="30" rows="10">{{ $page_home->appointment_text }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Button Text</label>
                                    <input type="text" name="appointment_btn_text" class="form-control" value="{{ $page_home->appointment_btn_text }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Button URL</label>
                                    <input type="text" name="appointment_btn_url" class="form-control" value="{{ $page_home->appointment_btn_url }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Existing Background</label>
                                    <div><img src="{{ asset('public/uploads/'.$page_home->appointment_bg) }}" alt="" class="w_200"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Change Background</label>
                                    <div><input type="file" name="appointment_bg"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="appointment_status" id="rr1" value="Show" @if($page_home->appointment_status == 'Show') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr1">Show</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="appointment_status" id="rr2" value="Hide" @if($page_home->appointment_status == 'Hide') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr2">Hide</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                            <!-- // Tab 8 -->
                        </div>
                        <div class="tab-pane fade" id="v-pills-9" role="tabpanel" aria-labelledby="v-pills-9-tab">
                            <!-- Tab 9 -->
                            <form action="{{ url('admin/page/home/9') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="latest_blog_title" class="form-control" value="{{ $page_home->latest_blog_title }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Subtitle</label>
                                    <input type="text" name="latest_blog_subtitle" class="form-control" value="{{ $page_home->latest_blog_subtitle }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="latest_blog_status" id="rr1" value="Show" @if($page_home->latest_blog_status == 'Show') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr1">Show</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="latest_blog_status" id="rr2" value="Hide" @if($page_home->latest_blog_status == 'Hide') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr2">Hide</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                            <!-- // Tab 9 -->
                        </div>
                        <div class="tab-pane fade" id="v-pills-10" role="tabpanel" aria-labelledby="v-pills-10-tab">
                            <!-- Tab 10 -->
                            <form action="{{ url('admin/page/home/10') }}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="current_photo" value="{{ $page_home->newsletter_bg }}">
                                @csrf
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="newsletter_title" class="form-control" value="{{ $page_home->newsletter_title }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Text</label>
                                    <textarea name="newsletter_text" class="form-control h_100" cols="30" rows="10">{{ $page_home->newsletter_text }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Existing Background</label>
                                    <div><img src="{{ asset('public/uploads/'.$page_home->newsletter_bg) }}" alt="" class="w_200"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Change Background</label>
                                    <div><input type="file" name="newsletter_bg"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="newsletter_status" id="rr1" value="Show" @if($page_home->newsletter_status == 'Show') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr1">Show</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="newsletter_status" id="rr2" value="Hide" @if($page_home->newsletter_status == 'Hide') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr2">Hide</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                            <!-- // Tab 10 -->
                        </div>
                        <div class="tab-pane fade" id="v-pills-11" role="tabpanel" aria-labelledby="v-pills-11-tab">
                            <!-- Tab 11 -->
                            <form action="{{ url('admin/page/home/11') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="pricing_title" class="form-control" value="{{ $page_home->pricing_title }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Subtitle</label>
                                    <input type="text" name="pricing_subtitle" class="form-control" value="{{ $page_home->pricing_subtitle }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="pricing_status" id="rr1" value="Show" @if($page_home->pricing_status == 'Show') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr1">Show</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="pricing_status" id="rr2" value="Hide" @if($page_home->pricing_status == 'Hide') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr2">Hide</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                            <!-- // Tab 11 -->
                        </div>
                        <div class="tab-pane fade" id="v-pills-12" role="tabpanel" aria-labelledby="v-pills-12-tab">
                            <!-- Tab 12 -->
                            <form action="{{ url('admin/page/home/12') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="tools_title" class="form-control" value="{{ $page_home->tools_title }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Subtitle</label>
                                    <input type="text" name="tools_subtitle" class="form-control" value="{{ $page_home->tools_subtitle }}">
                                </div>
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tools_status" id="rr1" value="Show" @if($page_home->tools_status == 'Show') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr1">Show</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tools_status" id="rr2" value="Hide" @if($page_home->tools_status == 'Hide') checked @endif>
                                            <label class="form-check-label font-weight-normal" for="rr2">Hide</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="card-header">Tools to asssign</div>
                                    <div class="row">
                                        @foreach ($tools as $row)
                                            <div class="col-md-4">

                                                <div class="d-flex align-items-center border my-2 py-2 px-3">

                                                    <input type="checkbox" name="home_tools[]" value="{{ $row['code'] }}"
                                                        @if (in_array($row['code'], $assigned)) checked @endif class="checkboxx">

                                                    <div class="col">
                                                        @if (isset($row['img']))
                                                            <img src="{{ asset($row['img']) }}" alt="" class="image">
                                                        @else
                                                            <h3>{{ $row['name'] ?? 'No Name' }}</h3>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Update</button>
                            </form>
                            <!-- // Tab 12 -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
