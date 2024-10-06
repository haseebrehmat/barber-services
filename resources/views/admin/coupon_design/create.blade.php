@extends('admin.admin_layouts')
@section('admin_content')
    <style>
        .custom-file-upload {
            display: inline-block;
            padding: 10px 20px;
            background-color: #36b9cc;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .custom-file-upload input[type="file"] {
            display: none;
        }

        .custom-file-upload:hover {
            background-color: #36b9cc;
        }

        .tox-notifications-container {
            display: none !important;
        }
    </style>
    <h1 class="h3 mb-3 text-gray-800">Add Coupon Design</h1>

    <form action="{{ route('admin.coupon_design.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">Add Coupon Design</h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin.coupon_design.index') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                        <i class="fa fa-arrow-left mr-2"></i> Back To Coupon Designs</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Coupon Title *</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" autofocus>
                        </div>
                        <div class="form-group d-flex flex-column">
                            <label for="">Coupon Content *</label>
                            <textarea name="content" cols="30" rows="10" id="et_content">{{ old('content') }}</textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="form-group text-center mt_20">
                                <label for="fileInput" class="custom-file-upload">
                                    <input type="file" id="fileInput" name="thumbnail" accept=".png, .jpg, .jpeg">
                                    Upload Coupon Image as thumbnail <i class="fa fa-file mx-3"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
    </form>

    <script src="https://cdn.tiny.cloud/1/ke6kl5fbofw7k5ek2q1zhsfknxjearp8ybyz4cd3nzdhaqng/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>

        <script>
            $(document).ready(function() {
                tinymce.init({
                    selector: '#et_content',
                    relative_urls: false,
                    convert_urls: false,
                    remove_script_host : false,
                    height: "500",
                    plugins: 'anchor autolink charmap codesample emoticons image link lists  searchreplace table visualblocks wordcount code fullpage',
                    toolbar: 'undo export redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image  table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat | code',
                    tinycomments_mode: 'embedded',
                    cleanup : false,
                    valid_elements : '*[*]',
                    valid_children : "+body[style]",
                    images_upload_url: '/upload-image',
    
                    tinycomments_author: 'Author name',
    
                    mergetags_list: [{
                            value: 'First.Name',
                            title: 'First Name'
                        },
                        {
                            value: 'Email',
                            title: 'Email'
                        },
                    ],
                });
            });
        </script>
@endsection
