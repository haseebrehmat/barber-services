@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Edit Slider</h1>

    <form action="{{ url('admin/slider/update/'.$slider->id) }}" method="post" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="current_photo" value="{{ $slider->slider_photo }}">
        <input type="hidden" name="is_store" value="{{ $is_store }}">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">Edit Slider</h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin.slider.index') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> View All</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-8">
                        <label for="">Slider Heading</label>
                        <textarea name="slider_heading" class="tinymce_editor">{{ $slider->slider_heading }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Heading Color</label>
                            <input type="text" name="heading_color" class="form-control jscolor" value="{{ $slider->heading_color }}"
                            autofocus>
                        </div>
                        <div class="form-group">
                            <label for="">Heading Font Size (px)</label>
                            <input type="number" min="1" name="heading_font_size" class="form-control" value="{{ $slider->heading_font_size }}"
                            autofocus>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-8">
                        <label for="">Slider Text</label>
                        <textarea name="slider_text" class="tinymce_editor">{{ $slider->slider_text }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Text Color</label>
                            <input type="text" name="text_color" class="form-control jscolor" value="{{ $slider->text_color }}"
                            autofocus>
                        </div>
                        <div class="form-group">
                            <label for="">Text Font Size (px)</label>
                            <input type="number" min="1" name="text_font_size" class="form-control" value="{{ $slider->text_font_size }}"
                            autofocus>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="">Slider Button Text</label>
                        <textarea name="slider_button_text" class="tinymce_editor">{{ $slider->slider_button_text }}</textarea>
                    </div>
                    <div class="col-md-6 row">
                        <div class="form-group col-md-6">
                            <label for="">Button Text Color</label>
                            <input type="text" name="button_text_color" class="form-control jscolor" value="{{ $slider->button_text_color }}"
                            autofocus>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Button Background Color</label>
                            <input type="text" name="button_bg_color" class="form-control jscolor" value="{{ $slider->button_bg_color }}"
                            autofocus>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Button Text Font Size (px)</label>
                            <input type="number" min="1" name="button_text_font_size" class="form-control" value="{{ $slider->button_text_font_size }}"
                            autofocus>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Slider Button URL</label>
                    <input type="text" name="slider_button_url" class="form-control" value="{{ $slider->slider_button_url }}" autofocus>
                </div>


                <div class="form-group">
                    <label for="overlay">Slider Overlay Intensity</label>
                    <input type="number" min="0.1" max="1" step="0.1" name="overlay" id="overlay" class="form-control form-control-sm" value="{{ $slider->overlay }}" autofocus>
                </div>

                @include('admin.slider.alignment', ['alignment' => $slider->alignment])
                {{-- @include('admin.slider.centered', ['centered' => $slider->centered]) --}}
                @if ($is_store)
                    <div class="form-group" style="display: none;">
                @else
                    <div class="form-group" >
                @endif

                    <select  class="form-control" required name="page">
                        <option value="">Select Page</option>
                        <option value="home" {{ $slider->page === 'home' ? 'selected' : '' }}>Home</option>
                        <option value="about_us" {{ $slider->page === 'about_us' ? 'selected' : '' }}>About Us</option>
                        <option value="services" {{ $slider->page === 'services' ? 'selected' : '' }}>Services</option>
                        <option  @if ($is_store==false) style="display: none;" @endif value="shop" {{ $slider->page === 'shop' ? 'selected' : '' }}>Shop</option>
                        <option value="blog" {{ $slider->page === 'blog' ? 'selected' : '' }}>Blog</option>
                        <option value="project" {{ $slider->page === 'project' ? 'selected' : '' }}>Project</option>
                        <option value="tools" {{ $slider->page === 'tools' ? 'selected' : '' }}>Tools</option>
                        <option value="podcast" {{ $slider->page === 'podcast' ? 'selected' : '' }}>Podcast</option>

                    </select>
                </div>
                @if (isset($slider->slider_photo))
                    <div class="form-group">
                        <label for="">Existing Slider Photo</label>
                        <div>
                            <img src="{{ asset('public/uploads/'.$slider->slider_photo) }}" alt="" class="w_200">
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <select id="slider-type-box" class="form-control" required name="slider_type">
                        <option value="">Please Select a Slider Type</option>
                        <option value="photo" @if($slider->slider_type == 'photo') selected @endif>Photo</option>
                        <option value="video" @if($slider->slider_type == 'video') selected @endif>Video url</option>
                        <option value="color" @if($slider->slider_type == 'color') selected @endif>Static color</option>
                        <option value="mp4" @if($slider->slider_type == 'mp4') selected @endif>Video (mp4)</option>
                    </select>
                </div>
                <div class="form-group" id="photo" style="display:{{$slider->slider_type == 'photo' ? 'block' : 'none'}}">
                    <label for="">Slider Photo *</label>
                    <div>
                        <input type="file" name="slider_photo">
                    </div>
                </div>
                <div class="form-group" id="video" style="display:{{$slider->slider_type == 'video' ? 'block' : 'none'}}">
                    <label for="">Slider Video URL *</label>
                    <input type="url" name="slider_video" class="form-control" value="{{$slider->slider_video}}">
                </div>
                <div class="form-group" id="color" style="display:{{$slider->slider_type == 'color' ? 'block' : 'none'}}">
                    <label for="">Slider Color *</label>
                    <input type="text" name="slider_color" class="form-control jscolor" value="{{$slider->slider_color}}">
                </div>
                <div class="form-group" id="mp4" style="display:{{$slider->slider_type == 'mp4' ? 'block' : 'none'}}">
                    <label for="">Slider Video (mp4) *</label>
                    <div>
                        <input type="file" name="slider_mp4" accept="video/mp4,video/x-m4v,video/*">
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </div>
    </form>
    @include('admin.slider.editor_config')
    <script>
        $("#slider-type-box").change(function (e) {
            e.preventDefault();
            $("#photo, #video, #color, #mp4").hide();
            if(e.target.value != "") $(`#${e.target.value}`).show();
        });
    </script>

@endsection
