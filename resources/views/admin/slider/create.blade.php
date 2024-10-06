@extends('admin.admin_layouts')
@section('admin_content')
<h1 class="h3 mb-3 text-gray-800">Add Slider</h1>

<form action="{{ route('admin.slider.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="is_store" value="{{$is_store}}">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">Add Slider</h6>
            <div class="float-right d-inline">
                <a href="{{ route('admin.slider.index') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                    View All</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-8">
                    <label for="">Slider Heading</label>
                    <textarea name="slider_heading" class="tinymce_editor">{{ old('slider_heading') }}</textarea>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Heading Color</label>
                        <input type="text" name="heading_color" class="form-control jscolor" value="{{ old('heading_color') }}"
                        autofocus>
                    </div>
                    <div class="form-group">
                        <label for="">Heading Font Size (px)</label>
                        <input type="number" min="1" name="heading_font_size" class="form-control" value="{{ old('heading_font_size') }}"
                        autofocus>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label for="">Slider Text</label>
                    <textarea name="slider_text" class="tinymce_editor" >{{ old('slider_text') }}</textarea>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Text Color</label>
                        <input type="text" name="text_color" class="form-control jscolor" value="{{ old('text_color') }}"
                        autofocus>
                    </div>
                    <div class="form-group">
                        <label for="">Text Font Size (px)</label>
                        <input type="number" min="1" name="text_font_size" class="form-control" value="{{ old('text_font_size') }}"
                        autofocus>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="">Slider Button Text</label>
                    <textarea name="slider_button_text" class="tinymce_editor">{{ old('slider_button_text') }}</textarea>
                </div>
                <div class="col-md-6 row">
                    <div class="form-group col-md-6">
                        <label for="">Button Text Color</label>
                        <input type="text" name="button_text_color" class="form-control jscolor" value="{{ old('button_text_color') }}"
                        autofocus>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Button Background Color</label>
                        <input type="text" name="button_bg_color" class="form-control jscolor" value="{{ old('button_bg_color') }}"
                        autofocus>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Button Text Font Size (px)</label>
                        <input type="number" min="1" name="button_text_font_size" class="form-control" value="{{ old('button_text_font_size') }}"
                        autofocus>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="">Slider Button URL</label>
                <input type="text" name="slider_button_url" class="form-control" value="{{ old('slider_button_url') }}"
                    autofocus>
            </div>
            <div class="form-group">
                <label for="overlay">Slider Overlay Intensity</label>
                <input type="number" min="0.1" max="1" step="0.1" name="overlay" id="overlay" class="form-control form-control-sm" value="{{ old('overlay') ?? 0.7 }}">
            </div>

            @include('admin.slider.alignment', ['alignment' => old('alignment') ? old('alignment') : 'center'])
            {{-- @include('admin.slider.centered') --}}
            @if ($is_store)
                <div class="form-group" style="display:none;">
                    <select  class="form-control" required name="page">
                        <option value="">Select Page</option>
                        <option  value="home">Home</option>
                        <option value="about_us">About Us</option>
                        <option value="services">Services</option>
                        <option selected value="shop">Shop</option>
                        <option value="blog">Blog</option>
                        <option value="project">Project</option>
                        <option value="tools">Tools</option>
                        <option value="podcast">Podcast</option>
                    </select>
                </div>
            @else
                <div class="form-group">
                    <select  class="form-control" required name="page">
                        <option value="">Select Page</option>
                        <option  value="home">Home</option>
                        <option value="about_us">About Us</option>
                        <option value="services">Services</option>
                        <option value="shop">Shop</option>
                        <option value="blog">Blog</option>
                        <option value="project">Project</option>
                        <option value="tools">Tools</option>
                        <option value="podcast">Podcast</option>
                    </select>
                </div>
            @endif


            <div class="form-group">
                <select id="slider-type-box" class="form-control" required name="slider_type">
                    <option value="">Please Select a Slider Type</option>
                    <option value="photo">Photo</option>
                    <option value="video">Video url</option>
                    <option value="color">Static color</option>
                    <option value="mp4">Video (mp4)</option>
                </select>
            </div>
            <div class="form-group" id="photo" style="display:none">
                <label for="">Slider Photo *</label>
                <div>
                    <input type="file" name="slider_photo">
                </div>
            </div>
            <div class="form-group" id="video" style="display:none">
                <label for="">Slider Video URL *</label>
                <input type="url" name="slider_video" class="form-control">
            </div>
            <div class="form-group" id="color" style="display:none">
                <label for="">Slider Color *</label>
                <input type="text" name="slider_color" class="form-control jscolor">
            </div>
            <div class="form-group" id="mp4" style="display:none">
                <label for="">Slider Video (mp4) *</label>
                <div>
                    <input type="file" name="slider_mp4" accept="video/mp4,video/x-m4v,video/*">
                </div>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
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
