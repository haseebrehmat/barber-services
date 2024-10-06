@if (sizeof($sliders) > 0)

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        .swiper {
            width: 100%;
            height: 80vh;
        }

        .swiper-slide h1 {
            color: #fff;
            font-size: 2rem;
            font-weight: 400;
        }

        .swiper-slide h3 {
            color: #fff;
            font-size: 1rem;
            font-weight: 300;
            margin-bottom: 30px;
        }

        .swiper-slide a {
            font-size: 16px;
            font-weight: 500;
            width: fit-content;
            margin-inline: auto;
            background-color: transparent;
            color: #fff;
            border: 2px solid #fff;
            border-radius: 50px;
            padding: 11px 40px;
            text-decoration: none;
        }

        .swiper-slide a:hover {
            background-color: #4D0101 !important;
            border-color: #4D0101 !important;
        }

        @media only screen and (max-width: 767px) {
            .swiper {
                width: 100%;
                height: 50vh;
            }

            .swiper-slide h1 {
                font-size: 0.9rem;
            }

            .swiper-slide h3 {
                font-size: 0.6rem;
            }

            .swiper-slide a {
                font-size: 10px;
                padding: 8px 30px;
            }
        }

      
    </style>

    <div class="swiper mySwiper desktop">
        <div class="swiper-wrapper">

            @foreach ($sliders as $key => $slide)
                <x-slide :slide="$slide" :key="$key + 1" />
            @endforeach

        </div>
    </div>




    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            autoplay: {
                delay: 5000,
            },
        });
        $(document).ready(function() {
            var videoElements = document.getElementsByClassName('vjs_video_739_html5_api');
            for (var i = 0; i < videoElements.length; i++) {
                videoElements[i].play();
            }
        });
    </script>
@endif
