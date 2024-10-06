@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Landing Page Contacts : {{ $lpc_name }}</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            {{-- <h6 class="m-0 mt-2 font-weight-bold text-primary">View Landing Page Contacts</h6> --}}

        </div>
        {{-- <a href="#"  data-toggle="modal" class="btn btn-primary btn-sm btn-block" data-target="#send_email">Send Email to Customers</a> --}}
        <a href="#"  data-toggle="modal" class="btn btn-info btn-sm btn-block" data-target="#send_sms">Send SMS to Customers
            <span class="font-weight-bold" style="font-size: 18px">({{ $smsSent . ' / ' . $smsLimit }})</span>
        </a>
        <a href="#"  data-toggle="modal" class="btn btn-success btn-sm btn-block" data-target="#send_whatsapp">Send Whatsapp to Customers
            <span class="font-weight-bold" style="font-size: 18px">({{ $whatsappSent . ' / ' . $whatsappLimit }})</span>
        </a><br>
        <a href="{{ URL::to('admin/landing_contacts/delete') }}" class="btn btn-danger btn-sm btn-block" onClick="return confirm('You are deleting all Contacts. Are you sure?');">Delete All Contacts</a>
        <div class="card-body">
            <button class="btn btn-info rounded-pill float-right mb-2" onclick="exportToExcel('customers-table')">
                <i class="fas fa-file-export ml-1 mr-2"></i>Export to Excel
            </button>

            {{-- <a href="{{ URL::to('admin/user_chat_status') }}" class="btn btn-info rounded-pill float-right mb-2">
                <i class="fas fa-file-export ml-1 mr-2"></i>Manage Call Status
            </a> --}}

            <div class="table-responsive">
                <table class="table table-bordered" id="customers-table" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        @if (count($customers) > 0)
                            <th scope="col"><input type="checkbox" class="check-all"></th>
                        @endif
                        <th>Customer Name</th>
                        <th>Customer Phone</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($customers as $row)

                        <tr>
                            <th scope="row">
                                <input type="checkbox" class="check" data-id="{{$row->id}}">
                                {{ $row->id }}
                            </th>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->phone }}</td>
                            <td>
                               <div class="d-flex">
                                    @if ($row->last_message!=null)
                                        <button class="btn btn-sm text-success py-0 edit-contact-btn1"
                                            data-message="{{ $row->last_message }}">
                                            <i class="fas fa-eye"></i> View Last Message
                                        </button>
                                    @else
                                    <p>No Message sent yet &nbsp;&nbsp;&nbsp;</p>
                                    @endif


                                    <button class="btn btn-sm text-success py-0 edit-contact-btn"
                                        data-url="{{ url('landing_page_messages/contact/'. $row->id) }}"
                                        data-name="{{ $row->name }}" data-email="{{ $row->email }}" data-phone="{{ $row->phone }}">
                                        <i class="fas fa-pencil-alt"></i> Edit
                                    </button>

                                    <form action="{{ url('landing_page_messages/contact/'. $row->id .'/delete') }}" method="post">
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
                                        <td>{{ isset($coupon->expired_at) ? $coupon->expired_at->format('d F Y, H:i A') : '-' }}</td>
                                        <td>
                                              @if(isset($coupon->expired_at))
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
                                            <a id="copyCouponLink{{ $coupon->id }}"
                                               href="javascript:void(0)"
                                               data-clipboard-text="{{  route('admin.coupon_design.show', ['id' => bin2hex(base64_encode($coupon->id))]) }}"
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
                                        <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $coupon->valid_till)->format('d F Y') }}</td>
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
                                            <a id="copyCouponLink{{ $coupon->id }}"
                                               href="javascript:void(0)"
                                               data-clipboard-text="{{ URL::to('coupon/tool/view/'.$coupon->secret) }}"
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

  @if (isset($scheduled_messages) && sizeof($scheduled_messages) > 0)
    @include('admin.customer.scheduled_messages', ['data' => $scheduled_messages])
  @endif


    <!--Email Modal -->
    <div class="modal fade" id="send_email" tabindex="-1" role="dialog" aria-labelledby="send_emailLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="send_emailLabel">Write Email</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{ route('admin.customers.send_email_action.landing') }}" method="post">
                  @csrf
                  <input type="hidden" name="customer_ids" class="customer_ids">
                 <div class="form-group">
                     <input type="text" class="form-control" name="subject" placeholder="Email Subject">   <br>
                     <textarea class="form-control" name="message" placeholder="Email Body"></textarea>
                 </div>
                  <div class="form-group">
                      <button type="submit" class="btn btn-primary pull-right float-right">Send</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    @if ($smsFlag)
      <!--SMS Modal -->
    <div class="modal fade" id="send_sms" tabindex="-1" role="dialog" aria-labelledby="send_smsLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="send_smsLabel">Write SMS</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{ route('admin.customers.send_sms_action_landing') }}" method="post">
                  @csrf
                  <input type="hidden" name="customer_ids" class="customer_ids">
                  <div class="form-group">
                     <textarea class="form-control" name="message" placeholder="Compose SMS"></textarea>
                 </div>
                 <div class="d-flex flex-column">
                    <label for="scheduled" class="p-1 d-flex align-items-center">
                        @includeIf('admin.customer.schedule_svg')
                        <input type="checkbox" name="scheduled" id="scheduled" style="width: 20px;height: 20px;">
                        <span class="mx-2">I want to schedule this message?</span>
                    </label>
                    <div class="form-group p-1 row scheduled_at_wrapper" style="display: none">
                        <label for="scheduled_at" class="col-md-2">Select date and time</label>
                        <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="form-control col-md-4" min="{{ now()->format('Y-m-d H:i') }}">
                    </div>
                 </div>
                 <span class="text-danger">{{$smsLimit -$smsSent}} SMS remaining</span>
                  <div class="form-group">
                      <button type="submit" class="btn btn-primary pull-right float-right send_btn">Send</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    @endif

    @if ($whatsappFlag)
      <!--Whatsapp Modal -->
    <div class="modal fade" id="send_whatsapp" tabindex="-1" role="dialog" aria-labelledby="send_whatsappLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="send_whatsappLabel">Write Whatsapp Message</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{ route('admin.customers.send_whatsapp_action_landing') }}" method="post">
                  @csrf
                  <input type="hidden" name="customer_ids" class="customer_ids">
                 <div class="form-group">
                     <textarea class="form-control" name="message" placeholder="Compose SMS"></textarea>
                 </div>
                 <div class="d-flex flex-column">
                    <label for="w_scheduled" class="p-1 d-flex align-items-center">
                        @includeIf('admin.customer.schedule_svg')
                        <input type="checkbox" name="scheduled" id="w_scheduled" style="width: 20px;height: 20px;">
                        <span class="mx-2">I want to schedule this message?</span>
                    </label>
                    <div class="form-group p-1 row w_scheduled_at_wrapper" style="display: none">
                        <label for="w_scheduled_at" class="col-md-2">Select date and time</label>
                        <input type="datetime-local" name="scheduled_at" id="w_scheduled_at" class="form-control col-md-4" min="{{ now()->format('Y-m-d H:i') }}">
                    </div>
                 </div>
                 <span class="text-danger">{{$whatsappLimit -$whatsappSent}} Whatsapp Messages remaining</span>
                  <div class="form-group">
                      <button type="submit" class="btn btn-primary pull-right float-right w_send_btn">Send</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    @endif


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

    <div class="modal fade" id="edit_contact1" tabindex="-1" role="dialog" aria-labelledby="edit_contact1Label"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit_contactLabel">Last Message Sent</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="message_paragraph"></p>
                </div>
            </div>
        </div>
    </div>



    <script>
        function setId(id){
            document.getElementById('id').value = id;
        }
    </script>
    <script>
        let phone;
        $(document).ready(function() {
            $('#customers-table').TableCheckAll()

            $('.check, .check-all').change(function (e) {

                const custIds = getChecked()
                if (custIds.length > 0) {
                    $('.compose-msg-btn').show();
                    $('.customer_ids').val(custIds);
                } else {
                    $('.compose-msg-btn').hide();
                }
            });

            $('.send-btn').click(function (e) {
                phone = $(this).data('number')
                $('#whatsappModal').modal('show')
            });

            $('#inputMessage').change(function (e) {
                let href=`https://api.whatsapp.com/send?phone=${phone}'&text=${e.target.value}`;
                $('.promote-btn').attr('href', href);
            });
        });

        const getChecked = () => {
            const ids = [];
            $('.check:checked').each(function (index, element) {
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
$.fn.TableCheckAll = function (options) {
  // Default options
  var settings = $.extend({
    checkAllCheckboxClass: '.check-all',
    checkboxClass: '.check'
  }, options);
  return this.each(function () {
    $(this).find(settings.checkAllCheckboxClass).on('click', function () {
      if ($(this).is(':checked')) {
        $.each($(this).parents("table").find(settings.checkboxClass), function () {
          $(this).prop('checked', true);
        });
      } else {
        $.each($(this).parents("table").find(settings.checkboxClass), function () {
          $(this).prop('checked', false);
        });
      }
    });
    $(this).find(settings.checkboxClass).on('click', function () {
      var totalCheckbox = $(this).parents("table").find(settings.checkboxClass).length;
      var totalChecked = $(this).parents("table").find(settings.checkboxClass + ":checked").length;

      if (totalCheckbox == totalChecked) {
        if (!$(this).parents("table").find(settings.checkAllCheckboxClass).is(':checked')) {
          $(this).parents("table").find(settings.checkAllCheckboxClass).prop('checked', true);
        }
      }

      if (totalCheckbox != totalChecked && !$(this).is(':checked')) {
        $(this).parents("table").find(settings.checkAllCheckboxClass).prop('checked', false);
      }
    });
  });
};
</script>

    <script>
        $('.edit-contact-btn').click(function () {
            // Set values to form and its inputs
            $("#edit_contact form").attr('action', $(this).data('url'));
            $("#edit_contact input[name='name']").val($(this).data('name'));
            $("#edit_contact input[name='email']").val($(this).data('email'));
            $("#edit_contact input[name='phone']").val($(this).data('phone'));
            // Show modal
            $("#edit_contact").modal('show');
        });
    </script>

<script>
    $('.edit-contact-btn1').click(function () {
         // Get the value of the 'message' data attribute
         var messageValue = $(this).data('message');

        // Set values to form and its inputs
        $("#edit_contact1 input[name='message']").val(messageValue);

        // Set the value to the <p> element
        $("#message_paragraph").text(messageValue);
        // Show modal
        $("#edit_contact1").modal('show');
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>

<script>
    // Initialize Clipboard.js
    var clipboard = new ClipboardJS('.copy-link');

    clipboard.on('success', function (e) {
        // Show a confirmation or feedback that the link has been copied
        e.trigger.innerHTML = 'Link Copied!';
        setTimeout(function () {
            e.trigger.innerHTML = 'Click to copy Coupon Link';
        }, 1500); // Reset back to the original text after 1.5 seconds
        e.clearSelection();

        // Prevent the default link behavior
        e.preventDefault();
    });

    clipboard.on('error', function (e) {
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

    <script>
        $(document).ready(function() {
            $('#scheduled').change(function (e) {
                const checked = e.target.checked
                if (checked) {
                    $('.scheduled_at_wrapper').show();
                    $('.send_btn').text('Schedule');
                } else {
                    $('.scheduled_at_wrapper').hide();
                    $('.send_btn').text('Sent');
                }
            });

            $('#w_scheduled').change(function (e) {
                const checked = e.target.checked
                if (checked) {
                    $('.w_scheduled_at_wrapper').show();
                    $('.w_send_btn').text('Schedule');
                } else {
                    $('.w_scheduled_at_wrapper').hide();
                    $('.w_send_btn').text('Sent');
                }
            });
        });
    </script>
@endsection
