@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Landing Page Contacts : {{ $lpc_name }}</h1>

    <div class="card shadow mb-4">
        <form action="{{ route('admin.select_emails') }}" method="post" class="my-2">
            @csrf
            <input type="hidden" name="landing_page_id" value="{{ $id }}">
            <input type="hidden" name="customer_ids" class="customer_ids">
            <button type="submit" class="btn btn-info btn-sm btn-block">
                Send Emails to Customers
            </button>
        </form>
        <a href="{{ URL::to('admin/landing_contacts/delete') }}" class="btn btn-danger btn-sm btn-block"
            onClick="return confirm('You are deleting all Contacts. Are you sure?');">Delete All Contacts</a>
        <div class="card-body">
            <button class="btn btn-info rounded-pill float-right mb-2" onclick="exportToExcel('customers-table')">
                <i class="fas fa-file-export ml-1 mr-2"></i>Export to Excel
            </button>
            <div class="table-responsive">
                <table class="table table-bordered" id="customers-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            @if (count($customers) > 0)
                                <th scope="col"><input type="checkbox" class="check-all"></th>
                            @endif
                            <th>Customer Name</th>
                            <th>Customer Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $row)
                            <tr>
                                <th scope="row">
                                    <input type="checkbox" class="check" data-id="{{ $row->id }}">
                                    {{ $row->id }}
                                </th>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->email }}</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm text-success py-0 edit-contact-btn"
                                            data-url="{{ url('landing_page_messages/contact/' . $row->id) }}"
                                            data-name="{{ $row->name }}" data-email="{{ $row->email }}"
                                            data-phone="{{ $row->phone }}">
                                            <i class="fas fa-pencil-alt"></i> Edit
                                        </button>
                                        <form action="{{ url('landing_page_messages/contact/' . $row->id . '/delete') }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm text-danger py-0" type="button"
                                                onclick="if(confirm('Are you sure') == true){$(form).submit()}">
                                                <i class="far fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 mt-2 font-weight-bold text-primary">View Coupon Links to copy</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Validity</th>
                                    <th>Status</th>
                                    <th>Link</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $coupon)
                                    <tr>
                                        <td>{!! $coupon->title !!}</td>
                                        <td>{{ isset($coupon->expired_at) ? $coupon->expired_at->format('d F Y, H:i A') : '-' }}
                                        </td>
                                        <td>
                                            @if (isset($coupon->expired_at))
                                                @if ($coupon->expired_at->isPast())
                                                    <span class="text-danger">Expired</span>
                                                @elseif ($coupon->expired_at->isToday())
                                                    <span class="text-warning">Expires Today</span>
                                                @else
                                                    <span class="text-success">Valid</span>
                                                @endif
                                            @else
                                                <span class="text-warning">Expiry Not Set</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a id="copyCouponLink{{ $coupon->id }}" href="javascript:void(0)"
                                                data-clipboard-text="{{ route('admin.coupon_design.show', ['id' => bin2hex(base64_encode($coupon->id))]) }}"
                                                class="copy-link">
                                                Click to copy Coupon Link
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 mt-2 font-weight-bold text-primary">View Flyer Links to copy</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Validity</th>
                                    <th>Status</th>
                                    <th>Link</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $coupon)
                                    <tr>
                                        <td>{!! $coupon->title !!}</td>
                                        <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $coupon->valid_till)->format('d F Y') }}
                                        </td>
                                        <td>
                                            @if (Carbon\Carbon::createFromFormat('Y-m-d', $coupon->valid_till)->isPast())
                                                <span class="text-danger">Expired</span>
                                            @elseif (Carbon\Carbon::createFromFormat('Y-m-d', $coupon->valid_till)->isToday())
                                                <span class="text-warning">Expires Today</span>
                                            @else
                                                <span class="text-success">Valid</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a id="copyCouponLink{{ $coupon->id }}" href="javascript:void(0)"
                                                data-clipboard-text="{{ URL::to('coupon/tool/view/' . $coupon->secret) }}"
                                                class="copy-link">
                                                Click to copy Flyer Link
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_contact" tabindex="-1" role="dialog" aria-labelledby="edit_contactLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_contactLabel">Edit Landing Page Contact</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Customer name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Customer email">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="test" class="form-control" name="phone" placeholder="Customer phone">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary pull-right float-right">Update</button>
                            <button type="button" class="btn float-right" data-dismiss="modal" aria-label="Close">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setId(id) {
            document.getElementById('id').value = id;
        }
    </script>

    <script>
        let phone;
        $(document).ready(function() {
            $('#customers-table').TableCheckAll()

            $('.check, .check-all').change(function(e) {

                const custIds = getChecked()
                if (custIds.length > 0) {
                    $('.compose-msg-btn').show();
                    $('.customer_ids').val(custIds);
                } else {
                    $('.compose-msg-btn').hide();
                }
            });
        });

        const getChecked = () => {
            const ids = [];
            $('.check:checked').each(function(index, element) {
                ids.push($(element).data('id'));
            });
            return ids;
        }
    </script>

    <script>
        /*! @preserve
         * TableCheckAll.js
         * version: 1.0
         * author: Ronard Cauba <ronard@ecomnuggets.com>
         * license: MIT
         * https://codeanddeploy.com/blog/jquery-plugins/jquery-table-check-all-plugin
         */
        $.fn.TableCheckAll = function(options) {
            // Default options
            var settings = $.extend({
                checkAllCheckboxClass: '.check-all',
                checkboxClass: '.check'
            }, options);
            return this.each(function() {
                $(this).find(settings.checkAllCheckboxClass).on('click', function() {
                    if ($(this).is(':checked')) {
                        $.each($(this).parents("table").find(settings.checkboxClass), function() {
                            $(this).prop('checked', true);
                        });
                    } else {
                        $.each($(this).parents("table").find(settings.checkboxClass), function() {
                            $(this).prop('checked', false);
                        });
                    }
                });
                $(this).find(settings.checkboxClass).on('click', function() {
                    var totalCheckbox = $(this).parents("table").find(settings.checkboxClass).length;
                    var totalChecked = $(this).parents("table").find(settings.checkboxClass +
                        ":checked").length;

                    if (totalCheckbox == totalChecked) {
                        if (!$(this).parents("table").find(settings.checkAllCheckboxClass).is(
                                ':checked')) {
                            $(this).parents("table").find(settings.checkAllCheckboxClass).prop(
                                'checked', true);
                        }
                    }

                    if (totalCheckbox != totalChecked && !$(this).is(':checked')) {
                        $(this).parents("table").find(settings.checkAllCheckboxClass).prop('checked',
                            false);
                    }
                });
            });
        };
    </script>

    <script>
        $('.edit-contact-btn').click(function() {
            // Set values to form and its inputs
            $("#edit_contact form").attr('action', $(this).data('url'));
            $("#edit_contact input[name='name']").val($(this).data('name'));
            $("#edit_contact input[name='email']").val($(this).data('email'));
            $("#edit_contact input[name='phone']").val($(this).data('phone'));
            // Show modal
            $("#edit_contact").modal('show');
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>

    <script>
        // Initialize Clipboard.js
        var clipboard = new ClipboardJS('.copy-link');

        clipboard.on('success', function(e) {
            // Show a confirmation or feedback that the link has been copied
            e.trigger.innerHTML = 'Link Copied!';
            setTimeout(function() {
                e.trigger.innerHTML = 'Click to copy Coupon Link';
            }, 1500); // Reset back to the original text after 1.5 seconds
            e.clearSelection();

            // Prevent the default link behavior
            e.preventDefault();
        });

        clipboard.on('error', function(e) {
            // Handle any errors that may occur during copying
            console.error('Error copying text:', e);
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get all the status select elements
            const statusSelects = document.querySelectorAll(".status-select");

            // Attach onchange event handler to each select element
            statusSelects.forEach(select => {
                select.addEventListener("change", function() {
                    // Find the closest form element (status-form)
                    const form = this.closest(".status-form");

                    // Submit the form
                    form.submit();
                });
            });
        });
    </script>
@endsection
