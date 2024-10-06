@extends('admin.admin_layouts')
@section('admin_content')
    <style>
        .select2-container--default .select2-selection--multiple {
            height: 40px;
        }
        .tox-notifications-container {display: none !important;}
    </style>
    <h1 class="h3 mb-3 text-gray-800">Sending Email.....</h1>

    <form action="{{ route('admin.email_template.send') }}" method="post">
        @csrf
        <input type="hidden" name="ref_template_id" value="{{ $template->id }}">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">Compose Email</h6>
                <div class="float-right d-inline">
                    @if (Session::has('landing_page_customer_ids'))
                        <a href="{{ route('landingpages.index') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                            <i class="fa fa-arrow-left mr-2"></i> Back To Landing Pages</a>
                    @else
                        <a href="{{ route('admin.email_template.gallery') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                            <i class="fa fa-arrow-left mr-2"></i> Back To Gallery</a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Template Name *</label>
                            <input type="text" name="et_name" class="form-control" value="{{  $template->et_name }}">
                        </div>
                        <div class="form-group">
                            <label for="">Email Subject *</label>
                            <input type="text" name="et_subject" class="form-control" value="{{ $template->et_subject }}"
                                autofocus>
                        </div>
                        @if (Session::has('landing_page_customer_ids'))
                            <input type="hidden" name="recipients_id[]" value="landing_page">
                        @else
                            <div class="form-group">
                                <label for="">Select Users Groups</label>
                                <select name="recipients_id[]" class="form-control select3" required multiple>
                                    <optgroup label="Default Groups">
                                        <option value="recipients">Recipients</option>
                                        <option value="subscribers">Subscribers</option>
                                        <option value="landing_page">Landingpage Contacts</option>
                                        {{-- <option value="external_data">External Data</option> --}}
                                    </optgroup>
                                    @if (sizeOf($custom_groups) > 0)
                                        <optgroup label="Added Groups">
                                            @foreach ($custom_groups as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                </select>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="">Email Message *</label>
                            <textarea name="et_content"  cols="30" rows="10" id="et_content">{{ $template->et_content }}</textarea>

                            @if (!Session::has('landing_page_customer_ids'))
                                <div class="custom-control custom-switch float-right mt-2">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1" name="modified">
                                    <label class="custom-control-label" for="customSwitch1">Save this changes as
                                        template</label>
                                </div>
                            @endif

                            <div class="d-flex align-items-center mt_20">

                                <div class="font-weight-bold text-danger">Parameters You Can Use: </div>
                                <div><button class="btn btn-sm btn-secondary ml-4" type="button"
                                        onclick="addTag('[[recipient_name]]')">[[recipient_name]]</button> =
                                    Recipient
                                    Name
                                </div>
                                <div><button class="btn btn-sm btn-secondary ml-4" type="button"
                                        onclick="addTag('[[recipient_name]]')">[[recipient_email]]</button> =
                                    Recipient
                                    Email
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success px-5 rounded-pill float-right">
                    <i class="fa fa-paper-plane mr-2"></i> Send
                </button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2({
            placeholder: 'Please Choose Status',
        });
        $('.select3').select2({
            placeholder: 'Please select recipients',
            multiple: true,
            allowClear: true,
            minimumResultsForSearch: 5
        });
    </script>
@endsection
