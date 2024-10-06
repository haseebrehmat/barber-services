@extends('admin.admin_layouts')
@section('admin_content')

    <h1 class="h3 mb-3 text-gray-800">Customers</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">View Customers</h6>

        </div>
        <a href="#"  data-toggle="modal" class="btn btn-primary btn-sm btn-block" data-target="#send_email">Send Email to Customers</a>
        <a href="#"  data-toggle="modal" class="btn btn-info btn-sm btn-block" data-target="#send_sms">Send SMS to Customers
            <span class="font-weight-bold" style="font-size: 18px">({{ $smsSent . ' / ' . $smsLimit }})</span>
        </a>
        <a href="#"  data-toggle="modal" class="btn btn-success btn-sm btn-block" data-target="#send_whatsapp">Send Whatsapp to Customers
            <span class="font-weight-bold" style="font-size: 18px">({{ $whatsappSent . ' / ' . $whatsappLimit }})</span>
        </a>
        <div class="card-body">
          <a href="{{ URL::to('admin/user_chat_status') }}" class="btn btn-info rounded-pill float-right mb-2">
              <i class="fas fa-file-export ml-1 mr-2"></i>Manage Call Status
          </a>
            <div class="table-responsive">
                <table class="table table-bordered" id="customers-table" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        @if (count($customers) > 0)
                            <th scope="col"><input type="checkbox" class="check-all"></th>
                        @endif
                        {{-- <th>SL</th> --}}
                        <th>Customer Name</th>
                        <th>Customer Email</th>
                        <th>Customer Phone</th>
                        <th>Customer Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($customers as $row)
                        <tr>
                            <th scope="row">
                                <input type="checkbox" class="check" data-id="{{$row->id}}">
                                {{ $row->id }}
                            </th>
                            {{-- <td>{{ $loop->iteration }}</td> --}}
                            <td>{{ $row->customer_name }}</td>
                            <td>{{ $row->customer_email }}</td>
                            <td>{{ $row->customer_phone }}</td>
                            <td>
                                @if($row->customer_status == 'Active')
                                    <span class="text-success">{{ $row->customer_status }}</span>
                                @endif

                                @if($row->customer_status == 'Pending')
                                    <span class="text-danger">{{ $row->customer_status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ URL::to('admin/customer/detail/'.$row->id) }}" class="btn btn-info btn-sm btn-block" target="_blank">Detail</a>
                                @if($row->customer_status == 'Active')
                                    <a href="{{ URL::to('admin/customer/make-pending/'.$row->id) }}" class="btn btn-secondary btn-sm btn-block" onClick="return confirm('Are you sure?');">Make Pending</a>
                                @else
                                    <a href="{{ URL::to('admin/customer/make-active/'.$row->id) }}" class="btn btn-secondary btn-sm btn-block" onClick="return confirm('Are you sure?');">Make Active</a>
                                @endif
                                <a href="{{ URL::to('admin/customer/delete/'.$row->id) }}" class="btn btn-danger btn-sm btn-block" onClick="return confirm('Are you sure?');">Delete</a>
                                <a href="#" onclick="setId('{{$row->id}}')" data-toggle="modal" class="btn btn-primary btn-sm btn-block" data-target="#exampleModal">Send Message</a>
                                @if ($row->last_message!=null)
                                <a href="#" onclick="setId1('{{$row->last_message}}')" data-toggle="modal" class="btn btn-dark btn-sm btn-block" data-target="#exampleModal1">View Last Message</a>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if (isset($scheduled_messages) && sizeof($scheduled_messages) > 0)
        @include('admin.customer.scheduled_messages', ['data' => $scheduled_messages])
    @endif


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Write Message</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('admin.customer.sendmessage') }}" method="post">
                @csrf
                <input type="hidden" name="id" id="id"/>
               <div class="form-group">
                   <textarea class="form-control" name="message" placeholder="Hello"></textarea>
               </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary pull-right float-right">Send</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!--last message Modal -->
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModal1Label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModal1Label">Last Message</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                {{-- <input type="text" name="id1" id="id1"/> --}}
                <p id="id1"></p>
          </div>
        </div>
      </div>
    </div>


    <!--Email Modal -->
    <div class="modal fade" id="send_email" tabindex="-1" role="dialog" aria-labelledby="send_emailLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="send_emailLabel">Write Email</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{ route('admin.customers.send_email_action') }}" method="post">
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
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="send_smsLabel">Write SMS</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{ route('admin.customers.send_sms_action') }}" method="post">
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
                        <label for="scheduled_at" class="col-md-5">Select date and time</label>
                        <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="form-control col-md-6" min="{{ now()->format('Y-m-d H:i') }}">
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
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="send_whatsappLabel">Write Whatsapp Message</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{ route('admin.customers.send_whatsapp_action') }}" method="post">
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
                        <label for="w_scheduled_at" class="col-md-5">Select date and time</label>
                        <input type="datetime-local" name="scheduled_at" id="w_scheduled_at" class="form-control col-md-6" min="{{ now()->format('Y-m-d H:i') }}">
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




    <script>
        function setId(id){
            document.getElementById('id').value = id;
        }
    </script>
    <script>
      function setId1(id){
          $("#id1").text(id);
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
