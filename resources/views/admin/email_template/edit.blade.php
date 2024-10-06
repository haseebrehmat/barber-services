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
        .tox-notifications-container {display: none !important;}
    </style>
    <h1 class="h3 mb-3 text-gray-800">Edit Email Template</h1>

    <form action="{{ url('admin/email-template/update/' . $email_template->id) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">Edit Email Template</h6>
                <div class="float-right d-inline">
                    @if (session('is_super') == 1)
                        <a href="{{ route('admin.email_template.gallery') }}"
                            class="btn btn-primary btn-sm rounded-pill px-3">
                            <i class="fa fa-arrow-left mr-2"></i> Back To Gallery</a>
                    @else
                        <a href="{{ isset($email_template->et_type) ? route('admin.email_template.index', ['et_type' => $email_template->et_type]) : route('admin.email_template.index') }}"
                            class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> View All</a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Template Name *</label>
                            <input type="text" name="et_name" class="form-control" value="{{ $email_template->et_subject }}"
                                autofocus>
                        </div>
                        <div class="form-group">
                            <label for="">Subject *</label>
                            <input type="text" name="et_subject" class="form-control"
                                value="{{ $email_template->et_subject }}">
                        </div>
                        <div class="form-group">
                            <label for="">Contact Page Message *</label>
                            <textarea name="et_content"cols="30" rows="10" id="et_content">{{ $email_template->et_content }}</textarea>

                            <div class="font-weight-bold mt_20 text-danger">Parameters You Can Use: </div>

                            @if ($id == 1)
                                <div>[[visitor_name]] = Visitor Name</div>
                                <div>[[visitor_email]] = Visitor Email</div>
                                <div>[[visitor_phone]] = Visitor Phone</div>
                                <div>[[visitor_message]] = Visitor Message</div>
                            @elseif($id == 2)
                                <div>[[person_name]] = Commenter Name</div>
                                <div>[[person_email]] = Commenter Email</div>
                                <div>[[person_message]] = Commenter Message</div>
                                <div>[[comment_see_url]] = Admin panel link where you will see the comment</div>
                            @elseif($id == 3)
                                <div>[[verification_link]] = Subscriber Verification Link</div>
                            @elseif($id == 4)
                                <div>[[post_link]] = News View Link</div>
                            @elseif($id == 5)
                                <div>[[reset_link]] = Reset Password Page Link</div>
                            @elseif($id == 6)
                                <div>[[verification_link]] = Customer Registration Verification Link</div>
                            @elseif($id == 7)
                                <div>[[reset_link]] = Reset Password Page Link</div>
                            @elseif($id == 8)
                                <div>[[customer_name]] = Customer Name</div>
                                <div>[[order_number]] = Order Number</div>
                                <div>[[payment_method]] = Payment Method Details with Card Information</div>
                                <div>[[payment_date_time]] = Payment Date and Time</div>
                                <div>[[transaction_id]] = Transaction Id</div>
                                <div>[[shipping_cost]] = Shipping Cost</div>
                                <div>[[coupon_code]] = Coupon Code</div>
                                <div>[[coupon_discount]] = Coupon Discount</div>
                                <div>[[paid_amount]] = Total Paid Amount</div>
                                <div>[[payment_status]] = Payment Status (Paid or Completed)</div>
                                <div>[[billing_name]] = Billing Name</div>
                                <div>[[billing_email]] = Billing Email</div>
                                <div>[[billing_phone]] = Billing Phone</div>
                                <div>[[billing_country]] = Billing Country</div>
                                <div>[[billing_address]] = Billing Address</div>
                                <div>[[billing_state]] = Billing State</div>
                                <div>[[billing_city]] = Billing City</div>
                                <div>[[billing_zip]] = Billing Zip Code</div>
                                <div>[[shipping_name]] = Shipping Name</div>
                                <div>[[shipping_email]] = Shipping Email</div>
                                <div>[[shipping_phone]] = Shipping Phone</div>
                                <div>[[shipping_country]] = Shipping Country</div>
                                <div>[[shipping_address]] = Shipping Address</div>
                                <div>[[shipping_state]] = Shipping State</div>
                                <div>[[shipping_city]] = Shipping City</div>
                                <div>[[shipping_zip]] = Shipping Zip Code</div>
                                <div>[[product_detail]] = All Product Name, Price and Quantity</div>
                            @else
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div><button class="btn btn-sm btn-secondary my-1" type="button"
                                                onclick="addTag('[[recipient_name]]')">[[recipient_name]]</button> =
                                            Recipient
                                            Name
                                        </div>
                                        <div><button class="btn btn-sm btn-secondary my-1" type="button"
                                                onclick="addTag('[[recipient_name]]')">[[recipient_email]]</button> =
                                            Recipient
                                            Email
                                        </div>
                                    </div>
                                    <div class="form-group d-flex flex-column">
                                        <label for="fileInput" class="custom-file-upload text-center">
                                            <input type="file" id="fileInput" name="thumbnail"
                                                accept=".png, .jpg, .jpeg">
                                            Upload Gallery Image as thumbnail <i class="fa fa-file mx-3"></i>
                                        </label>
                                        @if (isset($email_template->thumbnail))
                                            <label class="d-flex align-items-center justify-content-between">
                                                Uploaded Image:
                                                <img src="{{ asset('public/uploads/' . $email_template->thumbnail) }}"
                                                    alt="Thumbnail" width="150" height="150">
                                            </label>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Update</button>
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
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount code fullpage',
                toolbar: 'undo export redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat | code',
                tinycomments_mode: 'embedded',
                cleanup : false,
                valid_elements : '*[*]',
                valid_children : "+body[style]",
                tinycomments_author: 'Author name',
                images_upload_url: '/upload-image',
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
