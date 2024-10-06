@extends('admin.admin_layouts')
@section('admin_content')
    <style>
        .img-flag {
            display: inline-block;
            width: 150px;
            height: 100px;
            margin-right: 10px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .img-flag-selected {
            display: inline-block;
            width: 30px;
            height: 20px;
            margin-right: 10px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .select2-container--default .select2-selection--single {
            min-width: 500px;
            width: auto;
        }


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
    @php
        $bgSetting = $general_setting->lpc_background;
        $hexCode = isset($general_setting->lpc_background) && $bgSetting[0] === '#';
    @endphp

    <h1 class="h3 mb-3 text-gray-800">Landing Page Contact Settings</h1>

    <form action="{{ url('admin/landing_page_contact/setting') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="current_photo" value="{{ $general_setting->logo }}">

        <div class="card shadow mb-4">
            <div class="card-body">

                <div class="d-flex align-items-center justify-content-between">
                    <a target="_blank" class="btn btn-sm btn-primary my-3" href="{{ route('landing_page_contact') }}">Go to
                        Landing Contact Page </a>

                    <a target="_blank" href="{{ route('landing_page_contact') }}">
                        <div id="qrcode"></div>
                    </a>

                </div>

                @includeIf('admin.general_setting.lpc_logo', ['general_setting' => $general_setting])

                <div class="form-group d-flex align-items-center">
                    <label for="text">Text</label>
                    <textarea name="lpc_text" id="text" class="form-control form-control-sm mx-3">{{ $general_setting->lpc_text }}
                </textarea>
                </div>

                <div class="form-group d-flex align-items-center">
                    <label for="text">Title</label>
                    <input name="lpc_title" type="text" id="text" value="{{ $general_setting->lpc_title }}" class="form-control form-control-sm mx-3">
                </div>

                <div class="form-group d-flex align-items-center">
                    <label for="text">On Submit Text Message to send</label>
                    <textarea name="lpc_message_text"  class="form-control form-control-sm mx-3">{{ $general_setting->lpc_message_text }}
                </textarea>
                </div>

                <div class="form-group d-flex align-items-center">
                    <label for="lpc_overlay">Background Overlay Intensity</label>
                    <input type="number" min="0.1" max="1" step="0.1" name="lpc_overlay" id="lpc_overlay"
                        class="form-control form-control-sm mx-3" value="{{ $general_setting->lpc_overlay }}">
                </div>

                <div class="form-group d-flex align-items-center color-div">
                    <label for="background">Submit Button Color</label>
                    <input type="color" value="{{ $general_setting->lpc_btn_color }}" name="lpc_btn_color" id="background"
                        class="form-control form-control-sm mx-3" style="width: 120px;">
                </div>

                <div class="form-group d-flex align-items-center color-div">
                    <label for="lpc_form_bg_color">Contact Form Background Color</label>
                    <input type="color" value="{{ $general_setting->lpc_form_bg_color }}" name="lpc_form_bg_color"
                        id="lpc_form_bg_color" class="form-control form-control-sm mx-3" style="width: 120px;">
                </div>

                <div class="form-group d-flex align-items-center color-div">
                    <label for="lpc_nav_color">Contact Page Navbar Color</label>
                    <input type="color" value="{{ $general_setting->lpc_nav_color }}" name="lpc_nav_color"
                        id="lpc_nav_color" class="form-control form-control-sm mx-3" style="width: 120px;">
                </div>

                <div class="form-group d-flex align-items-center color-div">
                    <label class="col-md-2" for="background">Title Text Styling</label>
                    <input class="col-md-2" type="color" value="{{ $general_setting->lpc_title_color }}" name="lpc_title_color"
                        class="form-control form-control-sm mx-3" >

                    <input name="lpc_title_font_size" placeholder="Font Size" type="text" value="{{ $general_setting->lpc_title_font_size }}" class="form-control form-control-sm mx-3">

                    <select class="form-control" name="lpc_title_font_family">
                        <option @if ($general_setting->lpc_title_font_family=='Arial, sans-serif') selected @endif value="Arial, sans-serif">Arial</option>
                        <option @if ($general_setting->lpc_title_font_family=='Times New Roman, serif') selected @endif value="Times New Roman, serif">Times New Roman</option>
                        <option @if ($general_setting->lpc_title_font_family=='Verdana, sans-serif') selected @endif value="Verdana, sans-serif">Verdana</option>
                        <option @if ($general_setting->lpc_title_font_family=='Georgia, serif') selected @endif value="Georgia, serif">Georgia</option>
                        <option @if ($general_setting->lpc_title_font_family=='Helvetica, sans-serif') selected @endif value="Helvetica, sans-serif">Helvetica</option>
                        <option @if ($general_setting->lpc_title_font_family=='Courier, monospace') selected @endif value="Courier, monospace">Courier</option>
                        <option @if ($general_setting->lpc_title_font_family=='Tahoma, sans-serif') selected @endif value="Tahoma, sans-serif">Tahoma</option>
                        <option @if ($general_setting->lpc_title_font_family=='Palatino, serif') selected @endif value="Palatino, serif">Palatino</option>
                        <option @if ($general_setting->lpc_title_font_family=='Trebuchet MS, sans-serif') selected @endif value="Trebuchet MS, sans-serif">Trebuchet MS</option>
                        <option @if ($general_setting->lpc_title_font_family=='Comic Sans MS, cursive, sans-serif') selected @endif value="Comic Sans MS, cursive, sans-serif">Comic Sans MS</option>
                    </select>

                </div>

                <div class="form-group d-flex align-items-center color-div">
                    <label class="col-md-2" for="background">Paragraph Text Styling</label>
                    <input class="col-md-2" type="color" value="{{ $general_setting->lpc_title_text_color }}" name="lpc_title_text_color"
                        class="form-control form-control-sm mx-3" >

                    <input name="lpc_title_text_font_size" placeholder="Font Size" type="text" value="{{ $general_setting->lpc_title_text_font_size }}" class="form-control form-control-sm mx-3">

                    <select class="form-control" name="lpc_title_text_font_family">
                        <option @if ($general_setting->lpc_title_text_font_family=='Arial, sans-serif') selected @endif value="Arial, sans-serif">Arial</option>
                        <option @if ($general_setting->lpc_title_text_font_family=='Times New Roman, serif') selected @endif value="Times New Roman, serif">Times New Roman</option>
                        <option @if ($general_setting->lpc_title_text_font_family=='Verdana, sans-serif') selected @endif value="Verdana, sans-serif">Verdana</option>
                        <option @if ($general_setting->lpc_title_text_font_family=='Georgia, serif') selected @endif value="Georgia, serif">Georgia</option>
                        <option @if ($general_setting->lpc_title_text_font_family=='Helvetica, sans-serif') selected @endif value="Helvetica, sans-serif">Helvetica</option>
                        <option @if ($general_setting->lpc_title_text_font_family=='Courier, monospace') selected @endif value="Courier, monospace">Courier</option>
                        <option @if ($general_setting->lpc_title_text_font_family=='Tahoma, sans-serif') selected @endif value="Tahoma, sans-serif">Tahoma</option>
                        <option @if ($general_setting->lpc_title_text_font_family=='Palatino, serif') selected @endif value="Palatino, serif">Palatino</option>
                        <option @if ($general_setting->lpc_title_text_font_family=='Trebuchet MS, sans-serif') selected @endif value="Trebuchet MS, sans-serif">Trebuchet MS</option>
                        <option @if ($general_setting->lpc_title_text_font_family=='Comic Sans MS, cursive, sans-serif') selected @endif value="Comic Sans MS, cursive, sans-serif">Comic Sans MS</option>
                    </select>

                </div>

                <div class="form-group d-flex align-items-center color-div">
                    <label class="col-md-2" for="background">Form Text Styling</label>
                    <input class="col-md-2" type="color" value="{{ $general_setting->lpc_form_text_color }}" name="lpc_form_text_color"
                        class="form-control form-control-sm mx-3" >

                    <input name="lpc_form_text_font_size" placeholder="Font Size" type="text" value="{{ $general_setting->lpc_form_text_font_size }}" class="form-control form-control-sm mx-3">

                    <select class="form-control" name="lpc_form_text_font_family">
                        <option @if ($general_setting->lpc_form_text_font_family=='Arial, sans-serif') selected @endif value="Arial, sans-serif">Arial</option>
                        <option @if ($general_setting->lpc_form_text_font_family=='Times New Roman, serif') selected @endif value="Times New Roman, serif">Times New Roman</option>
                        <option @if ($general_setting->lpc_form_text_font_family=='Verdana, sans-serif') selected @endif value="Verdana, sans-serif">Verdana</option>
                        <option @if ($general_setting->lpc_form_text_font_family=='Georgia, serif') selected @endif value="Georgia, serif">Georgia</option>
                        <option @if ($general_setting->lpc_form_text_font_family=='Helvetica, sans-serif') selected @endif value="Helvetica, sans-serif">Helvetica</option>
                        <option @if ($general_setting->lpc_form_text_font_family=='Courier, monospace') selected @endif value="Courier, monospace">Courier</option>
                        <option @if ($general_setting->lpc_form_text_font_family=='Tahoma, sans-serif') selected @endif value="Tahoma, sans-serif">Tahoma</option>
                        <option @if ($general_setting->lpc_form_text_font_family=='Palatino, serif') selected @endif value="Palatino, serif">Palatino</option>
                        <option @if ($general_setting->lpc_form_text_font_family=='Trebuchet MS, sans-serif') selected @endif value="Trebuchet MS, sans-serif">Trebuchet MS</option>
                        <option @if ($general_setting->lpc_form_text_font_family=='Comic Sans MS, cursive, sans-serif') selected @endif value="Comic Sans MS, cursive, sans-serif">Comic Sans MS</option>
                    </select>

                </div>

                <div class="form-group d-flex align-items-center color-div">
                    <label class="col-md-2" for="background">Submit Button Text Styling</label>
                    <input class="col-md-2" type="color" value="{{ $general_setting->lpc_submit_text_color }}" name="lpc_submit_text_color"
                        class="form-control form-control-sm mx-3" >

                    <input name="lpc_submit_text_font_size" placeholder="Font Size" type="text" value="{{ $general_setting->lpc_submit_text_font_size }}" class="form-control form-control-sm mx-3">

                    <select class="form-control" name="lpc_submit_text_font_family">
                        <option @if ($general_setting->lpc_submit_text_font_family=='Arial, sans-serif') selected @endif value="Arial, sans-serif">Arial</option>
                        <option @if ($general_setting->lpc_submit_text_font_family=='Times New Roman, serif') selected @endif value="Times New Roman, serif">Times New Roman</option>
                        <option @if ($general_setting->lpc_submit_text_font_family=='Verdana, sans-serif') selected @endif value="Verdana, sans-serif">Verdana</option>
                        <option @if ($general_setting->lpc_submit_text_font_family=='Georgia, serif') selected @endif value="Georgia, serif">Georgia</option>
                        <option @if ($general_setting->lpc_submit_text_font_family=='Helvetica, sans-serif') selected @endif value="Helvetica, sans-serif">Helvetica</option>
                        <option @if ($general_setting->lpc_submit_text_font_family=='Courier, monospace') selected @endif value="Courier, monospace">Courier</option>
                        <option @if ($general_setting->lpc_submit_text_font_family=='Tahoma, sans-serif') selected @endif value="Tahoma, sans-serif">Tahoma</option>
                        <option @if ($general_setting->lpc_submit_text_font_family=='Palatino, serif') selected @endif value="Palatino, serif">Palatino</option>
                        <option @if ($general_setting->lpc_submit_text_font_family=='Trebuchet MS, sans-serif') selected @endif value="Trebuchet MS, sans-serif">Trebuchet MS</option>
                        <option @if ($general_setting->lpc_submit_text_font_family=='Comic Sans MS, cursive, sans-serif') selected @endif value="Comic Sans MS, cursive, sans-serif">Comic Sans MS</option>
                    </select>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group d-flex align-items-center">
                            <div class="form-group">
                                <label for="">Existing Left Side Image</label>
                                <div>
                                    <img src="{{ !isset($general_setting->lpc_left_bg) ? 'https://placehold.co/400' : asset('public/uploads/' . $general_setting->lpc_left_bg) }}"
                                        alt="" class="w_200" height="200">
                                </div>
                            </div>
                            <div class="form-group mx-4">

                                <div class="">
                                    <span>
                                        <input type="radio" name="lpc_left_image_type" value="upload_left" class="lpc_left_image_type" checked>
                                        Upload yourself
                                    </span>
                                    <span class="mx-3">
                                        <input type="radio" name="lpc_left_image_type" value="choose_left" class="lpc_left_image_type">
                                        Choose from left side backgrounds
                                    </span>
                                </div>

                                <div class="upload-left-div">
                                    <label for="">Change Left Side Background Image</label>
                                    <div>
                                        <input type="file" name="lpc_left_bg">
                                    </div>
                                </div>

                                <div class="choose-left-div" style="display: none">
                                    <select name="left_bg_id" class="form-control select2">
                                        <option value=""></option>
                                        @foreach ($left_backgrounds as $row)
                                            <option value="{{ $row->id }}"
                                                data-image="{{ asset('public/uploads/' . $row->file) }}">
                                                {{ $row->file }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-column">
                            <div class="form-group d-flex align-items-center mb-0">
                                <label for="lpc_bg_type">Choose type of background</label>
                                <span class="mx-3">
                                    <input type="radio" name="lpc_bg_type" value="color" class="lpc_bg_type"
                                        {{ $hexCode ? 'checked' : null }}>
                                    Color
                                </span>
                                <span class="mx-3">
                                    <input type="radio" name="lpc_bg_type" value="image" class="lpc_bg_type"
                                        {{ $hexCode ? null : 'checked' }}>
                                    Image
                                </span>
                            </div>

                            <div class="color-div" style="display: {{ $hexCode ? 'block' : 'none' }}">
                                <div class="form-group d-flex align-items-center">
                                    <label for="background">Background Color</label>
                                    <input type="color" value="{{ $general_setting->lpc_background }}" name="lpc_background_color"
                                        id="background" class="form-control form-control-sm mx-3" style="width: 120px;" min="1">
                                </div>
                            </div>

                            <div class="image-div" style="display: {{ $hexCode ? 'none' : 'block' }}">
                                <div class="form-group">
                                    <label for="">Existing Background Image</label>
                                    <div>
                                        <img src="{{ $bgSetting[0] == '#' ? 'https://placehold.co/400' : asset('public/uploads/' . $general_setting->lpc_background) }}"
                                            alt="" class="w_200" height="200">
                                    </div>
                                </div>
                                <div class="form-group">

                                    <div class="my-2">
                                        <span>
                                            <input type="radio" name="lpc_image_type" value="upload" class="lpc_image_type" checked>
                                            Upload yourself
                                        </span>
                                        <span class="mx-3">
                                            <input type="radio" name="lpc_image_type" value="choose" class="lpc_image_type">
                                            Choose from backgrounds
                                        </span>
                                    </div>

                                    <div class="upload-div">
                                        <label for="">Change Background Image</label>
                                        <div>
                                            <input type="file" name="lpc_background_image">
                                        </div>
                                    </div>


                                    <div class="choose-div" style="display: none">
                                        <select name="background_id" class="form-control select2">
                                            <option value=""></option>
                                            @foreach ($backgrounds as $row)
                                                <option value="{{ $row->id }}"
                                                    data-image="{{ asset('public/uploads/' . $row->file) }}">
                                                    {{ $row->file }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="d-flex">
                                <label class="switch mb-3">
                                    <input type="checkbox" name='lpc_centered' @if (isset($general_setting->lpc_centered) && $general_setting->lpc_centered=='1') checked @endif>
                                    <span class="slider"></span>
                                </label>
                                <span class="mx-2 p-1 mt-1 text-bold">Check if you want to align the Title and Paragraph Text to Center of Form?</span>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Update Settings</button>
                <br>
                <br>

                <a  href="#" class="container-fluid p-1" data-toggle="modal" data-target="#landing_page_guide">
                    <img src="{{ asset('public/frontend/images/dummy-landing-page.jpg') }}" alt="Dummy Landing Image" class="w-100">
                </a>
            </div>
        </div>
    </form>

    @includeIf('admin.general_setting.landing_page_guide')

    <script src="{{ asset('public/frontend/js/qurcode.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {

            $('.lpc_bg_type').on('change', function() {
                if ($(this).val() == 'color') {
                    $('.image-div').hide();
                    $('.color-div').show();
                } else {
                    $('.color-div').hide();
                    $('.image-div').show();
                }
            });

            $('.lpc_image_type').on('change', function() {
                if ($(this).val() == 'upload') {
                    $('.choose-div').hide();
                    $('.upload-div').show();
                } else {
                    $('.upload-div').hide();
                    $('.choose-div').show();
                }
            });

            $('.lpc_left_image_type').on('change', function() {
                if ($(this).val() == 'upload_left') {
                    $('.choose-left-div').hide();
                    $('.upload-left-div').show();
                } else {
                    $('.upload-left-div').hide();
                    $('.choose-left-div').show();
                }
            });

            var qrcode = new QRCode($("#qrcode")[0], {
                text: "{{ route('landing_page_contact') }}",
                width: 200,
                height: 200,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });

            $('.select2').select2({
                placeholder: 'Please choose from backgrounds',
                templateResult: function(data, container) {
                    if (!data.id) {
                        return data.text;
                    }
                    var $element = $(`<span><img src="` + $(data.element).data('image') +
                        `" class="img-flag" /> ` + data.text + `</span>`);
                    return $element;
                },
                templateSelection: function(data, container) {
                    if (!data.id) {
                        return data.text;
                    }
                    var $element = $(`<span><img src="` + $(data.element).data('image') +
                        `" class="img-flag-selected" /> ` + data.text + `</span>`);
                    return $element;
                }
            });
        });
    </script>
@endsection
