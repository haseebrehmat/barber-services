{{-- @if (sizeof($sliders)>0)
<div class="slider homeSlider">
    <div class="slide-carousel owl-carousel">

        @forelse ($sliders as $row)

        @if ($row->slider_type == 'video')
        <div class="slider-item" >
            <div style="position:absolute;top:0;left:0;width:100%;height:100%;background-color:rgba(0, 0, 0, {{$row->overlay}});"></div>

            @php
                $url = $row->slider_video;
                $video_id = substr($url, strrpos($url, '/') + 1);
            @endphp
            <iframe class="slider-item_video" width="100%" height="800" src="{{ $row->slider_video }}?autoplay=1&mute=1&loop=1&playlist={{ $video_id }}" frameborder="0" autoplay allowfullscreen></iframe>


            <div class="slider-item_video2" style="background:#{{ $theme_color->theme_color }};height: 800px;">
            </div>
            <div class="slider--item__inner">
                <div class="container">
                    <div class="row"
                        style="display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-box-align: center;-ms-flex-align: center;align-items: center;-webkit-box-pack: center;-ms-flex-pack: center;justify-content: center; margin-top: -13%;">
                        <div class="col-md-9 col-sm-12">
                            <div class="slider-table">
                                <div class="slider-text" @if($row->centered) style="text-align: center;" @endif>
                                    <div class="text-animated" style="margin-top: 30%;">
                                        <h1>{{ $row->slider_heading }}</h1>
                                    </div>
                                    <div class="text-animated col-md-11">
                                        <p>
                                            {!! nl2br(e($row->slider_text)) !!}
                                        </p>
                                    </div>
                                    <div class="text-animated"
                                        style="display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-box-align: center;-ms-flex-align: center;align-items: center;-webkit-box-pack: center;-ms-flex-pack: center;justify-content: center;@if($row->centered == 0)margin-left:-10%;@endif">
                                        <ul>
                                            <li><a href="{{ $row->slider_button_url }}">{{ $row->slider_button_text
                                                    }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif ($row->slider_type == 'photo')
        <div class="slider-item"
            style="background-image:url({{ asset('public/uploads/'.$row->slider_photo) }});height: 800px;">
            <div style="position:absolute;top:0;left:0;width:100%;height:100%;background-color:rgba(0, 0, 0, {{$row->overlay}});"></div>
            <div class="slider--item__inner">
                <div class="container">
                    <div class="row"
                        style="display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-box-align: center;-ms-flex-align: center;align-items: center;-webkit-box-pack: center;-ms-flex-pack: center;justify-content: center; margin-top: -13%;">
                        <div class="col-md-9 col-sm-12">
                            <div class="slider-table">
                                <div class="slider-text" @if($row->centered) style="text-align: center;" @endif>
                                    <div class="text-animated" style="margin-top: 30%;">
                                        <h1>{{ $row->slider_heading }}</h1>
                                    </div>
                                    <div class="text-animated col-md-11">
                                        <p>
                                            {!! nl2br(e($row->slider_text)) !!}
                                        </p>
                                    </div>
                                    <div class="text-animated"
                                        style="display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-box-align: center;-ms-flex-align: center;align-items: center;-webkit-box-pack: center;-ms-flex-pack: center;justify-content: center;@if($row->centered == 0)margin-left:-10%;@endif">
                                        <ul>
                                            <li><a href="{{ $row->slider_button_url }}">{{ $row->slider_button_text
                                                    }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif ($row->slider_type == 'color')

        <div class="slider-item" style="background-color:#{{$row->slider_color}};height: 800px;">
            <div style="position:absolute;top:0;left:0;width:100%;height:100%;background-color:rgba(0, 0, 0, {{$row->overlay}});"></div>
            <div class="slider--item__inner">
                <div class="container">
                    <div class="row"
                        style="display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-box-align: center;-ms-flex-align: center;align-items: center;-webkit-box-pack: center;-ms-flex-pack: center;justify-content: center; margin-top: -13%;">
                        <div class="col-md-9 col-sm-12">
                            <div class="slider-table">
                                <div class="slider-text" @if($row->centered) style="text-align: center;" @endif>
                                    <div class="text-animated" style="margin-top: 30%;">
                                        <h1>{{ $row->slider_heading }}</h1>
                                    </div>
                                    <div class="text-animated col-md-11">
                                        <p>
                                            {!! nl2br(e($row->slider_text)) !!}
                                        </p>
                                    </div>
                                    <div class="text-animated"
                                        style="display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-box-align: center;-ms-flex-align: center;align-items: center;-webkit-box-pack: center;-ms-flex-pack: center;justify-content: center;@if($row->centered == 0)margin-left:-10%;@endif">
                                        <ul>
                                            <li><a href="{{ $row->slider_button_url }}">{{ $row->slider_button_text
                                                    }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="slider-item">
            <div style="position:absolute;top:0;left:0;width:100%;height:100%;background-color:rgba(0, 0, 0, {{$row->overlay}});"></div>
            <video class="slider-item_video" width="100%" height="auto" playsinline="playsinline" muted="muted"
                preload="yes" autoplay="autoplay" loop="loop" id="vjs_video_739_html5_api" class="video-js"
                data-setup='{"autoplay":"any"}' controls>
                <source src="{{ asset('public/uploads/'.$row->slider_mp4) }}" type="video/mp4" />
            </video>
            <div class="slider--item__inner">
                <div class="container">
                    <div class="row"
                        style="display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-box-align: center;-ms-flex-align: center;align-items: center;-webkit-box-pack: center;-ms-flex-pack: center;justify-content: center; margin-top: -13%;">
                        <div class="col-md-9 col-sm-12">
                            <div class="slider-table">
                                <div class="slider-text" @if($row->centered) style="text-align: center;" @endif>
                                    <div class="text-animated" style="margin-top: 30%;">
                                        <h1>{{ $row->slider_heading }}</h1>
                                    </div>
                                    <div class="text-animated col-md-11">
                                        <p>
                                            {!! nl2br(e($row->slider_text)) !!}
                                        </p>
                                    </div>
                                    <div class="text-animated"
                                        style="display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-box-align: center;-ms-flex-align: center;align-items: center;-webkit-box-pack: center;-ms-flex-pack: center;justify-content: center;@if($row->centered == 0)margin-left:-10%;@endif">
                                        <ul>
                                            <li><a href="{{ $row->slider_button_url }}">{{ $row->slider_button_text
                                                    }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @empty
        <div class="slider-item" style="background-color:black;height: 800px;">
            <div style="position:absolute;top:0;left:0;width:100%;height:100%;background-color:rgba(0, 0, 0, {{$row->overlay}});"></div>
            <div class="slider--item__inner">
                <div class="container">
                    <div class="row"
                        style="display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-box-align: center;-ms-flex-align: center;align-items: center;-webkit-box-pack: center;-ms-flex-pack: center;justify-content: center; margin-top: -13%;">
                        <div class="col-md-9 col-sm-12">
                            <div class="slider-table">
                                <div class="slider-text" @if($row->centered) style="text-align: center;" @endif>
                                    <div class="text-animated" style="margin-top: 30%;">
                                        <h1>Test Heading</h1>
                                    </div>
                                    <div class="text-animated col-md-11">
                                        <p>
                                            Test Paragraph
                                        </p>
                                    </div>
                                    <div class="text-animated"
                                        style="display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-box-align: center;-ms-flex-align: center;align-items: center;-webkit-box-pack: center;-ms-flex-pack: center;justify-content: center;@if($row->centered == 0)margin-left:-10%;@endif">
                                        <ul>
                                            <li><a href="javascript:;">Read More</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforelse


    </div>
</div>
@endif --}}

<x-swiper-slider :sliders="$sliders" />
