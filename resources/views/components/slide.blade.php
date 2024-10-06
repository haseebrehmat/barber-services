<style>
    .main-container {
        width: 100%;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .content-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
        z-index: 2;
    }

    .main-container img,
    .main-container video,
    .main-container .solid-color,
    .main-container .embed-responsive {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 0;
    }

    .main-container video {
        background-color: #2c2b2b;
    }

    .overlay-{{ $key }} {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, {{ $slide->overlay }});
        /* backdrop-filter: blur(2px); */
        z-index: 1;
    }

    @media (max-width: 767px) {
        .content-container {
            width: 100%;
        }
    }

    /* Default styles for images in the slider */
    .swiper-slide img {
        width: 100%; /* Make sure the image fills its container */
        height: auto; /* Allow the height to adjust proportionally */
    }

    /* Media query for mobile devices with a maximum width of 767px */
    @media (max-width: 767px) {
        .swiper-slide img {
            height: auto; /* Ensure the height still adjusts proportionally on mobile */
        }



        .main-container{
            height: 50%;
        }




        .pt_60 {
            margin-top: -65%;
        }

        #s-txt-{{ $slide->id }} {
            font-size: 16px !important;
        }

        #s-head-{{ $slide->id }} {
            font-size: 16px !important;
        }

        #s-btn-{{ $slide->id }} {
            font-size: 16px !important;
        }
    }

    #s-txt-{{ $slide->id }} {
        color: #{{ $slide->text_color }};
        font-size: {{ $slide->text_font_size }}px;
    }

    #s-head-{{ $slide->id }} {
        color: #{{ $slide->heading_color }};
        font-size: {{ $slide->heading_font_size }}px;
    }

    #s-btn-{{ $slide->id }}:hover {
        color: #{{ $slide->button_text_color }} !important;
        font-size: {{ $slide->button_text_font_size }}px !important;
        background-color: #{{ $slide->button_bg_color }} !important;
        border: none;
    }

    #s-btn-{{ $slide->id }} {
        color: #{{ $slide->button_text_color }};
        font-size: {{ $slide->button_text_font_size }}px;
        background-color: #{{ $slide->button_bg_color }};
    }

</style>

<div class="swiper-slide desktop">
    <div class="main-container" >
        <div class="overlay-{{ $key }}"></div>

        @if ($slide->slider_type == 'photo')
            <!-- Image -->
            <img src="{{ asset('public/uploads/' . $slide->slider_photo) }}" alt="Image" class="img-fluid">
        @endif

        @if ($slide->slider_type == 'mp4')
        <!-- Video -->
        <div style="position: relative; width: 100%; height: 100%;">
            <video playsinline="playsinline" muted="muted" preload="yes" autoplay="autoplay" loop="loop"
                class="video-js vjs_video_739_html5_api" data-setup='{"autoplay":"any"}' controls
                style="width: 100%; height: 100%; object-fit: cover;">
                <source src="{{ asset('public/uploads/' . $slide->slider_mp4) }}" type="video/mp4" />
            </video>
        </div>
    @endif


        @if ($slide->slider_type == 'color')
            <!-- Color -->
            <div class="solid-color" style="background-color: #{{ $slide->slider_color }} !important;"></div>
        @endif

        @if ($slide->slider_type == 'video')
            <!-- YouTube Video -->
            @php
                $url = $slide->slider_video;
                $video_id = substr($url, strrpos($url, '/') + 1);
            @endphp
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" width="100%" height="auto"
                    src="{{ $slide->slider_video }}?autoplay=1&mute=1&loop=1&playlist={{ $video_id }}"
                    frameborder="0" autoplay allowfullscreen></iframe>
            </div>
        @endif

        @php
            $alignment = 'text-center';
            switch ($slide->alignment) {
                case 'center':
                    $alignment = 'text-center';
                    break;

                case 'left':
                    $alignment = 'text-left px-4';
                    break;

                case 'right':
                    $alignment = 'text-right px-4';
                    break;
            }
            $ID = $slide->id;
        @endphp


            {{-- @php
                $content = strip_tags($slide->slider_button_text);
                $content = strlen($content) > 130 ? substr($content, 0, 130) . "..." : $content;
            @endphp --}}
           
        <!-- Content Container -->
        <div class="content-container {{ $alignment }}">
            <h1 id="s-head-{{ $ID }}">{!! $slide->slider_heading !!}</h1>
            <h3 id="s-txt-{{ $ID }}">{!! $slide->slider_text !!}</h3>
            <a href="{{ $slide->slider_button_url }}" id="s-btn-{{ $ID }}"> {!! preg_replace('/<\/?p>/', '', $slide->slider_button_text) !!}
            </a>
        </div>
    </div>
</div>




