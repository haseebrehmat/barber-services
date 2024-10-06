@extends('layouts.app')

@section('content')

@include('pages.shop_css')

@include('sliders')

<div class="container pt_60">

<!-- New section with a smaller image -->
<div class="row wow fadeInUp" data-wow-duration="1s" style="visibility: visible; animation-duration: 1s; animation-name: fadeInUp;">
<div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
    <div class="wsus__section_heading mb_45">
        <h4>{{ $g_setting->shop_heading ?? 'Shop Heading' }}</h4>
        <h2>{{ $g_setting->shop_title ?? 'Shop Title' }}</h2>
        <span>
            <img src="https://i.ibb.co/mvvd7fW/heading-shapes.png" alt="shapes" class="img-fluid w-50">
            <!-- Add a custom class (e.g., w-50) or inline styles to adjust the size -->
        </span>
        <p>{{ $g_setting->shop_subtitle ?? 'Shop Subtitle' }}</p>
    </div>
</div>
</div>
    <div class="row">
        <div class="col-md-3">
            <ul id="categories-list">
                <li class="nav-item">
                    <a class="nav-link h4 active category-link" id="category-tab-00" data-toggle="pill" href="#category-00"
                        role="tab" aria-controls="pills-profile" aria-selected="false">Services</a>
                </li>
                @foreach ($categories as $row)
                    <li class="nav-item">
                        <a class="nav-link h4 category-link" id="category-tab-{{$row->id}}" data-toggle="pill" href="#category-{{$row->id}}"
                            role="tab" aria-controls="pills-profile" aria-selected="false">{{$row->name}}</a>
                    </li>
                @endforeach
                
            </ul>
        </div>

        <div class="col-md-9">
            <!-- Rest of your content -->
            <div class="tab-content" id="pills-tabContent">
                

                @foreach ($categories as $main_row)
                <div class="tab-pane fade" id="category-{{$main_row->id}}" role="tabpanel"
                    aria-labelledby="category-tab-{{$main_row->id}}">
                    <div class="tab-content">
                        <h4>{{$main_row->name}}</h4>
                        <small>{{$main_row->description}}</small>
                    </div>
                    <div class="row">
                        @forelse($main_row->products()->paginate(12) as $row)
                        <div class="col-lg-3 col-md-6 col-sm-12 text-center px-1 mb-2">
                            <div class="px-2 py-3 border rounded-lg d-flex flex-column justify-content-between h-100 product-card">
                                <div class="product-item">
                                    <div class="photo text-center"><a href="{{ url('product/'.$row->product_slug) }}"><img
                                                src="{{ asset('public/uploads/'.$row->product_featured_photo) }}"></a></div>
                                    <div class="text text-center">
                                        <h3><a href="{{ url('product/'.$row->product_slug) }}">{{ $row->product_name }}</a>
                                        </h3>
                                        <div class="price">
                                            @if($row->product_old_price != '')
                                            <del>USD {{ $row->product_old_price }}</del>
                                            @endif
                                            USD {{ $row->product_current_price }}
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-button">
                                    @if (isset($row->variant) && isset($row->variant_options))
                                        <small class="px-2">In Variant</small>
                                    @endif
                                    @if($row->product_stock == 0)
                                    <a href="javascript:void(0);" class="stock-empty w-100-p text-center">Stock is
                                        empty</a>
                                    @else
                                        <button class="add-to-cart-btn" data-product="{{ $row }}">
                                            <i class="fas fa-shopping-bag mr-1"></i>
                                            Add to Cart
                                        </button>
                                        {{-- @if (isset($row->variant))
                                            <button type="button" class="select-variant-btn"
                                                data-product_id="{{ $row->id }}" data-variant="{{ $row->variant }}">
                                                <i class="fas fa-stream mr-1"></i>
                                                Select Variant
                                            </button>
                                        @else
                                            <form action="{{ route('front.add_to_cart') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $row->id }}">
                                                <input type="hidden" name="product_qty" value="1">
                                                <button type="submit">
                                                    <i class="fas fa-shopping-bag mr-1"></i>
                                                    Add to Cart
                                                </button>
                                            </form>
                                        @endif --}}
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <h3 class="mx-auto my-5">No Products are added in this category</h3>
                        @endforelse
                        <div class="col-md-12">
                            {{-- {{ $products->links() }} --}}
                        </div>
                    </div>
                </div>
                @endforeach

                @include('pages.serivce')
            </div>
        </div>
    </div>
</div>
@include('pages.select_variant')
@include('pages.add_to_cart')
<script>
    $(document).ready(function () {
        // Add click event to category tabs
        $('#categories-list a.nav-link').on('click', function (e) {
            e.preventDefault();

            // Remove active class from all tabs
            $('#categories-list a.nav-link').removeClass('active');

            // Add active class to the clicked tab
            $(this).addClass('active');

            // Show the corresponding tab content
            var targetTab = $(this).attr('href');
            $('.tab-pane').removeClass('show active');
            $(targetTab).addClass('show active');
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Smooth scroll to target element on mobile screens
        $('.category-link').on('click', function() {
            if (window.innerWidth <= 767) {
                var offset = $('.tab-content').offset().top - 100; // Adjust the offset as needed
                $('html, body').animate({
                    scrollTop: offset
                }, 800);
            }
        });
    });
</script>

@endsection
