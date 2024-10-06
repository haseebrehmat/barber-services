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
    <h1 class="h3 mb-3 text-gray-800">Edit Coupon Design</h1>

    <form action="{{ route('admin.coupon_design.update', ['coupon_design' => $design]) }}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">Edit Coupon Design</h6>
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
                            <input type="text" name="title" class="form-control" value="{{ $design->title }}"
                                autofocus>
                        </div>
                        @if (session('is_super') != 1 && isset($design->modified_by) && isset($design->expired_at))
                            <div class="form-group">
                                <label for="">Expired At *</label>
                                <input type="datetime-local" name="expired_at" class="form-control" value="{{ $design->expired_at }}"
                                    min="{{ now()->gt($design->expired_at) ? $design->expired_at : now()->format('Y-m-d H:i') }}">
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="coupon_code">Coupon Code *</label>
                            <input type="text" name="code" id="code" class="form-control" value="{{ $design->code }}">
                        </div>

                        <div class="form-group">
                            <label for="type">Coupon Type *</label>
                            <select name="type" id="type" class="form-control">
                                <option value="">Select Type</option>
                                <option value="percentage" {{ $design->type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                <option value="amount" {{ $design->type == 'amount' ? 'selected' : '' }}>Amount</option>
                            </select>
                        </div>

                        <div class="form-group" id="value_field" style="display: none;">
                            <label for="value" id="value_label">Value</label>
                            <input type="number" name="value" id="value" class="form-control" step="0.01" value="{{ $design->value }}">
                        </div>

                        <div class="form-group d-flex flex-column">
                            <label for="">Coupon Content *</label>
                            <textarea name="content" cols="30" rows="10" id="et_content">{{ $design->content }}</textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="form-group text-center mt_20">
                                <label for="fileInput" class="custom-file-upload">
                                    <input type="file" id="fileInput" name="thumbnail" accept=".png, .jpg, .jpeg">
                                    Upload Coupon Image as thumbnail <i class="fa fa-file mx-3"></i>
                                </label>
                                @if (isset($design->thumbnail))
                                    <label class="d-flex align-items-center justify-content-between">
                                        Uploaded Image:
                                        <img src="{{ asset('public/uploads/' . $design->thumbnail) }}"
                                            alt="Thumbnail" width="150" height="150">
                                    </label>
                                @endif
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

                $('#type').on('change', function() {
                    let selectedType = $(this).val();
                    if (selectedType === 'percentage') {
                        $('#value_label').text('Percentage Value (%)');
                        $('#value_field').show();
                    } else if (selectedType === 'amount') {
                        $('#value_label').text('Amount Value (USD)');
                        $('#value_field').show();
                    } else {
                        $('#value_field').hide();
                    }
                });

                $('#type').trigger('change');
            });
        </script>
@endsection
