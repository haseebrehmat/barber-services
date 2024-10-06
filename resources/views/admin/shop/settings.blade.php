@extends('admin.admin_layouts')
@section('admin_content')
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #1cc88a;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #1cc88a;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    .text-bold {
        font-weight: 700;
    }
</style>

    <h1 class="h3 mb-3 text-gray-800">Shop Settings</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">Update Shop Settings</h6>
        </div>
        <form action="{{ route('admin.shop.settings.save') }}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="card-body">

                <div class="form-group d-flex flex-column">
                    <label for="text">Shop Heading</label>
                    <input name="shop_heading" type="text" value="{{ $general_setting->shop_heading }}"
                        class="form-control form-control-sm" placeholder="Enter Shop Heading">
                </div>

                <div class="form-group d-flex flex-column">
                    <label for="text">Shop Title</label>
                    <input name="shop_title" type="text" value="{{ $general_setting->shop_title }}"
                        class="form-control form-control-sm" placeholder="Enter Shop Title">
                </div>

                <div class="form-group d-flex flex-column">
                    <label for="text">Shop Subtitle</label>
                    <textarea name="shop_subtitle" class="form-control form-control-sm" placeholder="Enter Shop Subtitle">{{ $general_setting->shop_subtitle }}
                    </textarea>
                </div>


                <div class="form-group d-flex flex-column">
                    <label for="text">Header Reservation Text</label>
                    <input name="reservation_text" type="text" value="{{ $general_setting->reservation_text }}"
                        class="form-control form-control-sm" placeholder="Enter Header Reservation Text">
                </div>

                <div class="d-flex">
                    <label class="switch mb-3">
                        <input type="checkbox" name='reservation_status' @if ($general_setting->reservation_status=='true') checked @endif>
                        <span class="slider"></span>
                    </label>
                    <span class="mx-2 p-1 mt-1 text-bold">Check if you want to Enable Reservations.</span>
                </div>


                <div class="d-flex">
                    <label class="switch mb-3">
                        <input type="checkbox" name='rounded_images' @if ($shop->rounded_images=='true') checked @endif>
                        <span class="slider"></span>
                    </label>
                    <span class="mx-2 p-1 mt-1 text-bold">Check if you want to show Store Product images as Rounded / Circle.</span>
                </div>

                <div class="form-group">
                    <label for="">Product Category Text color (When Category is not selected)</label>
                    <input type="text" name="category_text_color" class="form-control jscolor"
                        value="{{ $shop->category_text_color }}">
                </div>

                <div class="form-group">
                    <label for="">Product Category Background color (When Category is not selected)</label>
                    <input type="text" name="category_background_color" class="form-control jscolor"
                        value="{{ $shop->category_background_color }}">
                </div>

                <div class="form-group">
                    <label for="">Product Category Text color (When Category is selected)</label>
                    <input type="text" name="active_category_text_color" class="form-control jscolor"
                        value="{{ $shop->active_category_text_color }}">
                </div>

                <div class="form-group">
                    <label for="">Product Category Background color (When Category is selected)</label>
                    <input type="text" name="active_category_background_color" class="form-control jscolor"
                        value="{{ $shop->active_category_background_color }}">
                </div>




                <input type="hidden" name="current_photo" value="{{ $general_setting->logo_shop }}">

                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Existing Shop Logo</label>
                            <div>
                                <img src="{{ asset('public/uploads/'.$general_setting->logo_shop) }}" alt="" class="w_200">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Change Logo</label>
                            <div>
                                <input type="file" name="logo">
                            </div>
                        </div>

                        <div class="form-group d-flex align-items-center">
                            <label for="width">Width</label>
                            <input type="number" value="{{$general_setting->logo_shop_width}}" name="logo_shop_width" id="width" class="form-control form-control-sm mx-3" style="width: 120px;" min="1">
                        </div>

                        <div class="form-group d-flex align-items-center">
                            <label for="height">Height</label>
                            <input type="number" value="{{$general_setting->logo_shop_height}}" name="logo_shop_height" id="height" class="form-control form-control-sm mx-3" style="width: 120px;" min="1">
                        </div>

                        
                    </div>
                </div>


                <button class="btn btn-success mt-4 d-block">Save Settings</button>
            </div>

            
            
        </form>
    </div>
    <script></script>
@endsection
