<style>
    .h-100 {
        height: 100% !important;
    }

    /* Add border, round the nav-link class, and create spacing between buttons */
    .nav-item .nav-link {
        /* border: 1px solid #000; */
        /* Replace #000 with the desired border color */
        /* Remove border-radius to make the edges square */
        padding: 20px 20px;
        /* Adjust the padding as needed */
        text-align: center;
        font-weight: bold;
        font-size: 16px;
        /* Adjust the font size as needed */
        transition: background-color 0.3s, color 0.3s;
        margin-bottom: 5px;
        /* Add 5px bottom margin to create spacing between buttons */
        /* background-color: #{{ $shop->category_text_color }}; */
        color: #{{ $shop->category_background_color }};
    }

    .nav-item .nav-link.active {
        background-color: #{{ $shop->active_category_background_color }};
        /* Change to your desired active background color */
        color: #{{ $shop->active_category_text_color }};
        /* Change to your desired active text color */
    }

    @media screen and (max-width: 767px) {
        #pills-tab {
            margin-top: 13%;
        }
    }

    .slider-item__backdrop {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        /* Change the opacity value to adjust the darkness of the backdrop */
    }

    /* Adjust the style for the left-aligned categories */
    #categories-list {
        list-style: none;
        padding: 0;
    }

    #categories-list li {
        margin-bottom: 10px;
    }

    @if ($shop->rounded_images == 'true')
        .product-item .photo img {
            height: 180px;
            width: 180px;
            border: 6px solid white;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.3);
        }

        .photo img {
            border-radius: 50%;
            /* Other styles you may want to apply */
            width: 100px;
            /* Adjust the width as needed */
            height: 100px;
            /* Adjust the height as needed */
            object-fit: cover;
            /* This property ensures the image covers the entire container */
        }

        @media (max-width: 767px) {
            .product-item .photo img {
                height: 300px;
                width: 300px;
                border: 6px solid white;
                box-shadow: 0 0 6px rgba(0, 0, 0, 0.3);
            }
        }
    @endif
    @if ($shop->rounded_images == 'false')
        .product-item .photo img {
            height: 270px;
            width: 270px;
            border: 6px solid white;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.3);
        }
    @endif
    .product-card {
        transition: border-bottom 0.3s ease;
    }

    .product-card:hover {
        border-bottom: 6px solid #113B30 !important;
    }

    input[type="checkbox"] {
      width: 18px;
      height: 18px;
      margin-right: 5px;
      cursor: pointer;
    }

    input[type="radio"] {
      width: 16px;
      height: 16px;
      cursor: pointer;
    }
</style>
