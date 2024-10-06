@extends('layouts.app')

@section('content')

<style>
    .slider-item__backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6); /* Change the opacity value to adjust the darkness of the backdrop */
}



.view {
  height: 100%;
}
.body1 {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        display: flex;
        flex-direction: row; /* Default layout for larger screens */
        margin: 10px;
        justify-content: center;
        align-items: center;
        /* height: 90vh; */
    }

        .section-container1 {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 5px 5px; /* Padding reducido arriba y abajo */
            max-width: 1200px;
            margin: 10px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            flex-wrap: wrap;
        }

        .image-container1 {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 40%;
            padding: 10px;
        }
        

        .image-container1 img {
            height: 400px; /* Altura fija para formato retrato */
            width: auto;
            max-width: 100%;
            border-radius: 10px;
            object-fit: cover;
        }
        

        .text-container1 {
            flex: 1;
            max-width: 50%;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }
       

        .text-container1 h1 {
            font-size: 28px;
            margin-bottom: 10px;
            color: #333;
        }

        .text-container1 p {
            font-size: 16px;
            color: #666;
            line-height: 1.5;
            text-align: justify;
        }

        @media (max-width: 768px) {
            .section-container1 {
                flex-direction: column;
                padding: 10px; /* Mantener poco padding en pantallas pequeñas también */
            }

            .image-container1, .text-container1 {
                max-width: 100%;
                text-align: center;
            }
            .body1 {
            flex-direction: column; /* Stack image and text vertically on mobile */
            height: auto; /* Adjust height for mobile */
            margin: 0; /* Remove margin for mobile */
            margin-top: -40%;
        }   
            .image-container1 img {
                height: auto;
                width: 80%;
            }

            .text-container1 {
                padding-top: 20px;
                text-align: center;
            }

            .text-container1 p {
                text-align: justify;
            }
        }
#mobile-box {
  width: 360px;
}

.card {
  -webkit-border-radius: 10px;
  border-radius: 10px;
}

.card .view {
  -webkit-border-top-left-radius: 10px;
  border-top-left-radius: 10px;
  -webkit-border-top-right-radius: 10px;
  border-top-right-radius: 10px;
}

.card h5 a {
  color: #0d47a1;
}

.card h5 a:hover {
  color: #072f6b;
}

#pButton {
  float: left;
}

#timeline {
  width: 90%;
  height: 2px;
  margin-top: 20px;
  margin-left: 10px;
  float: left;
  -webkit-border-radius: 15px;
  border-radius: 15px;
  background: rgba(0, 0, 0, 0.3);
}

#pButton {
  margin-top: 12px;
  cursor: pointer;
}

#playhead {
  width: 8px;
  height: 8px;
  -webkit-border-radius: 50%;
  border-radius: 50%;
  margin-top: -3px;
  background: black;
  cursor: pointer;
}

@media (max-width: 767px) {
    /* .content-container{
            display: none;
        }
          .overlay-1,
        .overlay-2,
        .overlay-3,
        .overlay-4,
        .overlay-5,
        .overlay-6,
        .overlay-7,
        .overlay-8,
        .overlay-9,
        .overlay-10 {
            display: none; 
        } */

        .feature {
            margin-top: -15%; 
        }

        .faizan_sound {
            margin-top: -20%; 
        }
        #booksy_to_hide{
            display: none;
        }
}
@media (min-width: 768px) {
    .nav-item.hide-on-desktop {
        display: none;
    }
}
@media (max-width: 767px) {
    #specials {
        margin-top: -30%;
    }
}
</style>
<style>
    
    .btn {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        padding: 15px;
        border: none;
        cursor: pointer;
    }
    .share-button {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 10px;
    }
    .share-button img {
        width: 30px;
        height: 30px;
        cursor: pointer;
    }
    .button-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .button-container a {
        color: #FFFFFF;
        text-decoration: none;
        flex-grow: 1;
        text-align: center;
    }
    @media (max-width: 768px) {
        .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        .button-container {
            justify-content: center;
        }
        .share-button {
            margin-left: 0;
            margin-top: 10px;
        }
    }
    /* Hide elements on mobile */
@media (max-width: 767px) {
    .hide_on_mobile {
        display: none;
    }
}

/* Hide elements on desktop */
@media (min-width: 768px) {
    .hide_on_desktop {
        display: none;
    }
}

</style>
<x-swiper-slider :sliders="$sliders" />




<div class="container mt-3 text-center hide_on_mobile"> <!-- Center align the button -->
    <button onclick="toggleBackgroundMusic()">Toggle Background Music</button>
</div>

<section class="body1" class="section-container1">
    <div class="container mt-3 text-center hide_on_desktop"> <!-- Center align the button -->
        <button onclick="toggleBackgroundMusic()">Toggle Background Music</button>
    </div>
    <div class="image-container1">
        <img src="https://bercodetech.com/2.png" alt="Imagen">
    </div>
    <div class="text-container1">
        <h1><b> The Right Place for Your Hair & Beard</b> </h1>
        <p>Welcome to [Your Salon/Barbershop Name], where style meets precision. Our expert stylists and barbers are dedicated to delivering top-notch haircuts, shaves, and grooming services tailored to your unique look. Enjoy a modern, relaxing atmosphere designed for your comfort. We use the finest products to ensure you leave feeling fresh and confident. Whether it's a classic cut or the latest trend, we've got you covered. Book your appointment today and experience the perfect blend of skill and style.</p>
    </div>
</section>

@if($page_home->special_status == 'Show')

@endif





<br>
<br>
@if($page_home->podcast_status == 'Show')

@endif
@if($page_home->audio_status == 'Show')
<div class="feature faizan_sound">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading wow fadeInUp">
                    <h2>{{ $page_home->audio_title }}</h2>
                    <h3>{{ $page_home->audio_subtitle }}</h3>
                </div>
            </div>
        </div>
        
        
    </div>
</div>
@endif








@if($page_home->special_status == 'Show')
<div class="special" style="background-image: url({{ asset('public/uploads/'.$page_home->special_bg) }});">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 wow fadeInLeft">
                <h2>{{ $page_home->special_title }}</h2>
                <h3>{{ $page_home->special_subtitle }}</h3>
                <p>
                    {!! nl2br(e($page_home->special_content)) !!}
                </p>
                <div class="read-more">
                    <a href="{{ $page_home->special_btn_url }}" class="btn btn-primary btn-arf">{{
                        $page_home->special_btn_text }}</a>
                </div>
            </div>
            <div class="col-md-6 wow fadeInRight">
                <div class="video-section"
                    style="background-image: url({{ asset('public/uploads/'.$page_home->special_video_bg) }})">
                    <div class="bg video-section-bg"></div>
                    <div class="video-button-container">
                        <a class="video-button"
                            href="https://www.youtube.com/watch?v={{ $page_home->special_yt_video }}"><span></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if($page_home->why_choose_status == 'Show')
<div class="feature">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading wow fadeInUp">
                    <h2>{{ $page_home->why_choose_title }}</h2>
                    <h3>{{ $page_home->why_choose_subtitle }}</h3>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($why_choose_items as $row)
            <div class="col-md-4">
                <div class="feature-item wow fadeInUp">
                    <a href="{{$row->link}}" target="_blank">
                        <div class="icon">
                            <img src="{{ asset('public/uploads/'.$row->photo) }}" alt="">
                        </div>
                        <h4>{{ $row->name }}</h4>
                        <p style="color: white">
                            {!! nl2br(e($row->description)) !!}
                        </p>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif







@if($page_home->project_status == 'Show')
<div class="project">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading wow fadeInUp">
                    <h2>{{ $page_home->project_title }}</h2>
                    <h3>{{ $page_home->project_subtitle }}</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="project-carousel owl-carousel">
                    @foreach($projects as $row)
                    <div class="project-item wow fadeInUp">
                        <div class="photo">
                            <a href="{{ url('project/'.$row->project_slug) }}"><img
                                    src="{{ asset('public/uploads/'.$row->project_featured_photo) }}" alt=""></a>
                        </div>
                        <div class="text">
                            <h3><a href="{{ url('project/'.$row->project_slug) }}">{{ $row->project_name }}</a></h3>
                            <p>
                                {!! nl2br(e($row->project_content_short)) !!}
                            </p>
                            <div class="read-more">
                                <a href="{{ url('project/'.$row->project_slug) }}">Read More</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif


@if($page_home->team_member_status == 'Show')
<div class="team bg-lightblue">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading wow fadeInUp">
                    <h2>{{ $page_home->team_member_title }}</h2>
                    <h3>{{ $page_home->team_member_subtitle }}</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="team-carousel owl-carousel">

                    @foreach($team_members as $row)
                    <div class="team-item wow fadeInUp">
                        <div class="team-photo">
                            <a href="{{ url('team-member/'.$row->slug) }}" class="team-photo-anchor">
                                <img src="{{ asset('public/uploads/'.$row->photo) }}" alt="Team Member Photo">
                            </a>
                        </div>
                        <div class="team-text">
                            <h4><a href="{{ url('team-member/'.$row->slug) }}">{{ $row->name }}</a></h4>
                            <p>{{ $row->designation }}</p>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endif

@include('pages.pricing_section')

@if($page_home->service_status == 'Show')
<div class="service" id="specials">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading wow fadeInUp">
                    <h2>{{ $page_home->service_title }}</h2>
                    <h3>{{ $page_home->service_subtitle }}</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="service-carousel owl-carousel">
                    @foreach($services as $row)
                    <div class="service-item wow fadeInUp">
                        <div class="photo">
                            <a  href="{{ url('service/'.$row->slug) }}"><img style="max-width: 100% !important; height: 295px" src="{{ asset('public/uploads/'.$row->photo) }}" alt=""></a>
                        </div>
                        <div class="text">
                            <h3><a href="{{ url('service/'.$row->slug) }}">{{ $row->name }}</a></h3>
                            {{-- <p>
                                {!! nl2br(e($row->short_description)) !!}
                            </p> --}}
                            {!!  $row->description !!}
                            <div class="read-more" style="display: flex; justify-content: center;"> <!-- Add text-center class here -->
                                <a href="tel:+18189167725">Call Us</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endif


@if($page_home->appointment_status == 'Show')
<div class="cta" style="background-image: url({{ asset('public/uploads/'.$page_home->appointment_bg) }});">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="cta-box text-center">
                    <h2>{{ $page_home->appointment_title }}</h2>
                    <p class="mt-3">
                        {!! nl2br(e($page_home->appointment_text)) !!}
                    </p>
                    <a href="{{ $page_home->appointment_btn_url }}" class="btn btn-primary">{{
                        $page_home->appointment_btn_text }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif




@if($page_home->testimonial_status == 'Show')
<div class="testimonial"  style="background-image: url('https://wallpapers.com/images/featured/7sn5o1woonmklx1h.jpg');">
  
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading wow fadeInUp">
                    <h2 style="color: black">{{ $page_home->testimonial_title }}</h2>
                    <h3 style="color: black">{{ $page_home->testimonial_subtitle }}</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="testimonial-carousel owl-carousel">
                    @foreach($testimonials as $row)
                    <div class="testimonial-item wow fadeInUp">
                        <div class="photo">
                            <img src="{{ asset('public/uploads/'.$row->photo) }}" alt="">
                        </div>
                        <div class="text" >
                            <p style="color: black">
                                {!! nl2br(e($row->comment)) !!}
                            </p>
                            <h3 style="color: black">{{ $row->name }}</h3>
                            <h4 style="color: black">{{ $row->designation }}</h4>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@include('pages.home_tools_section')



@if($page_home->latest_blog_status == 'Show')
<div class="blog-area">
    <div class="container wow fadeIn">

        <div class="row">
            <div class="col-md-12">
                <div class="heading wow fadeInUp">
                    <h2>{{ $page_home->latest_blog_title }}</h2>
                    <h3>{{ $page_home->latest_blog_subtitle }}</h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="blog-carousel owl-carousel">

                    @foreach($blogs as $row)
                    <div class="blog-item wow fadeInUp">
                        <a href="{{ url('blog/'.$row->id) }}">
                            <div class="blog-image">
                                <img src="{{ asset('public/uploads/'.$row->blog_photo) }}" alt="Blog Image">
                                <div class="date">
                                    <h3>{{ \Carbon\Carbon::parse($row->created_at)->format('d') }}</h3>
                                    <h4>{{ \Carbon\Carbon::parse($row->created_at)->format('M') }}</h4>
                                </div>
                            </div>
                        </a>
                        <div class="blog-text">
                            <h3><a href="{{ url('blog/'.$row->id) }}">{{ $row->blog_title }}</a></h3>
                            <p>
                                {!! nl2br(e($row->blog_content_short)) !!}
                            </p>
                            <div class="read-more">
                                <a href="{{ url('blog/'.$row->id) }}">Read More</a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endif


@if($page_home->newsletter_status == 'Show')
<div class="newsletter-area" style="background-image: url({{ asset('public/uploads/'.$page_home->newsletter_bg) }});">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 newsletter">
                <div class="newsletter-text wow fadeInUp">
                    <h2>{{ $page_home->newsletter_title }}</h2>
                    <p>
                        {!! nl2br(e($page_home->newsletter_text)) !!}
                    </p>
                </div>
                <div class="newsletter-button wow fadeInUp">
                    <form action="{{ route('front.subscription') }}" method="post"
                        class="frm_newsletter justify-content-center">
                        @csrf
                        <input type="text" placeholder="Enter Your Email" name="subs_email">
                        <input type="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- @if (isset($theme_color->bg_music))
    <audio id="background-audio" muted loop>
        <source src="{{ asset('public/uploads/' . $theme_color->bg_music) }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
@endif

@if (isset($theme_color->bg_music))
    <script>
         $(document).ready(function () {
            $('html, body').click(function () {
                const audio = document.getElementById('background-audio');
                audio.muted = false
                audio.play();
            });
        });
    </script>
@endif --}}

@if (isset($theme_color->bg_music))
        <script type="text/javascript">
            var audio = document.createElement("audio");
            document.body.appendChild(audio);
            audio.src = "{{ asset('public/uploads/' . $theme_color->bg_music) }}";

            var isMusicPlaying = true;

            document.body.addEventListener("mousemove", function () {
                if (isMusicPlaying) {
                    audio.play();
                }
            });

            function toggleBackgroundMusic() {
                if (isMusicPlaying) {
                    audio.pause();
                    isMusicPlaying = false;
                } else {
                    audio.play();
                    isMusicPlaying = true;
                }
            }
        </script>
    @endif

    <script>
        function copyToClipboardAndAlert(platform) {
            let urlToCopy = '';
    
            // Determine the URL based on the selected platform
            switch (platform) {
                case 'website':
                    urlToCopy = 'https://aabsolutebarbersvipnsalons.com';
                    break;
                case 'facebook':
                    urlToCopy = 'https://www.facebook.com';
                    break;
                case 'instagram':
                    urlToCopy = 'https://www.instagram.com/absolutebarbershopnsalons';
                    break;
                default:
                    // Default URL, change it accordingly
                    urlToCopy = 'https://aabsolutebarbersvipnsalons.com';
            }
    
            // Copy URL to clipboard
            const tempInput = document.createElement('input');
            tempInput.value = urlToCopy;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
    
            // Show alert to user
            alert('Link copied! Please Share with others.');
        }
    </script>
     <script>
        function shareLink(url) {
            if (navigator.share) {
                navigator.share({
                    title: document.title,
                    url: url
                }).then(() => {
                    console.log('Thanks for sharing!');
                }).catch(console.error);
            } else {
                // Fallback for browsers that do not support the Web Share API
                alert('Your browser does not support the Web Share API. Please copy and share the link manually: ' + url);
            }
        }
    </script>
@endsection
