@extends('admin.admin_layouts')
@section('admin_content')
<style>
    .color-circle {
        width: 30px; /* Adjust the width and height as needed */
        height: 30px;
        border-radius: 50%;
        margin: 0 auto; /* Center the circle horizontally */
    }
        
</style>
    <h1 class="h3 mb-3 text-gray-800">Follow Up Customers</h1>

    <div class="card shadow mb-4">
       
        <div class="card-body">
            
            <a href="{{ URL::to('admin/user_chat_status') }}" class="btn btn-info rounded-pill float-right mb-2">
                <i class="fas fa-file-export ml-1 mr-2"></i>Manage Call Status
            </a>
            
            <div class="table-responsive">
                <table class="table table-bordered" id="user-table" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        {{-- <th>SL</th> --}}
                        <th>Customer Name</th>
                        <th>Customer Email</th>
                        <th>Customer Phone</th>
                        <th>Status</th>
                        <th>Indication</th>
                        <th>Comment [Auto save, Just type]</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($landingPageContacts as $row)
                        <tr>
                            {{-- <td>{{ $loop->iteration }}</td> --}}
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->phone }}</td>
                            <td>
                                @if ($row->user_chat_status_id!=null)
                                    {{-- <form action="{{ route('admin.chnage_customer_call_status') }}" method="post" class="status-form"> --}}
                                        {{-- @csrf --}}
                                        <input type="hidden" name="customer_id" value="{{$row->id}}">
                                        <input type="hidden" name="table" value="landing_page_contacts">
                                        <select style="width: auto;"  name="user_chat_status_id" class="form-control status-select" required data-customer-id="{{$row->id}}" data-table-name="landing_page_contacts" data-color="landing{{$row->id}}">
                                            <option value="">Select Status</option>
                                            @foreach ($user_chat_statuses as $user_chat_status)
                                            
                                                <option style="background-color: #{{$user_chat_status->hex}}" value="{{$user_chat_status->id}}" @if ($user_chat_status->id== $row->userChatStatus->id) selected @endif>{{$user_chat_status->title}}</option>
                                            @endforeach
                                        </select>
                                       
                                    {{-- </form> --}}
                                @else
                                    {{-- <form action="{{ route('admin.chnage_customer_call_status') }}" method="post" class="status-form"> --}}
                                        {{-- @csrf --}}
                                        <input type="hidden" name="customer_id" value="{{$row->id}}">
                                        <input type="hidden" name="table" value="landing_page_contacts">
                                        
                                        <select style="width: auto;" name="user_chat_status_id" class="form-control status-select" required data-customer-id="{{$row->id}}" data-table-name="landing_page_contacts" data-color="landing{{$row->id}}">
                                            <option value="">Select Status</option>
                                            @foreach ($user_chat_statuses as $user_chat_status)
                                            
                                                <option style="background-color: #{{$user_chat_status->hex}}" value="{{$user_chat_status->id}}">{{$user_chat_status->title}}</option>
                                            @endforeach
                                        </select>
                                        
                                    {{-- </form> --}}
                                @endif
                                
                            </td>
                            <td>
                                @if (isset($row->userChatStatus->hex))
                                    <div class="color-circle" id="landing{{$row->id}}" style="background-color: #{{ $row->userChatStatus->hex }}"></div>
                                @else
                                   <div class="color-circle" id="landing{{$row->id}}" style="background-color: #000000"></div>
                                @endif
                            </td>
                            <td>
                                <input type="hidden" name="table" value="landing_page_contacts">
                                <input type="text" class="form-control comment-input" name="comment" value="{{ $row->comment }}" data-customer-id="{{ $row->id }}">
                            </td>
                        </tr>                       
                    @endforeach

                    @foreach($customers as $row)
                        <tr>
                            <td>{{ $row->customer_name }}</td>
                            <td>{{ $row->customer_email }}</td>
                            <td>{{ $row->customer_phone }}</td>
                            <td>
                                @if ($row->user_chat_status_id!=null)
                                    <form action="{{ route('admin.chnage_customer_call_status') }}" method="post" class="status-form">
                                        @csrf
                                        <input type="hidden" name="customer_id" value="{{$row->id}}">
                                        <input type="hidden" name="table" value="customers">
                                        <select style="width: auto;" name="user_chat_status_id" class="form-control status-select" required data-customer-id="{{$row->id}}" data-table-name="customers"  data-table-name="landing_page_contacts" data-color="landing{{$row->id}}">
                                            <option value="">Select Status</option>
                                            @foreach ($user_chat_statuses as $user_chat_status)
                                            
                                                <option style="background-color: #{{$user_chat_status->hex}}" value="{{$user_chat_status->id}}" @if ($user_chat_status->id== $row->userChatStatus->id) selected @endif>{{$user_chat_status->title}}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                @else
                                        <input type="hidden" name="customer_id" value="{{$row->id}}">
                                        <input type="hidden" name="table" value="customers">
                                        <select style="width: auto;" name="user_chat_status_id" class="form-control status-select" required data-customer-id="{{$row->id}}" data-table-name="customers"  data-table-name="landing_page_contacts" data-color="landing{{$row->id}}">
                                            <option value="">Select Status</option>
                                            @foreach ($user_chat_statuses as $user_chat_status)
                                            
                                                <option style="background-color: #{{$user_chat_status->hex}}" value="{{$user_chat_status->id}}">{{$user_chat_status->title}}</option>
                                            @endforeach
                                        </select>
                                @endif
                                
                            </td>
                            <td>
                                @if (isset($row->userChatStatus->hex))
                                    <div class="color-circle" id="landing{{$row->id}}" style="background-color: #{{ $row->userChatStatus->hex }}"></div>
                                @else
                                   <div class="color-circle" id="landing{{$row->id}}" style="background-color: #000000"></div>
                                @endif
                            </td>
                            <td>
                                <input type="hidden" name="table" value="customers">
                                <input type="text" class="form-control comment-input1" name="comment" value="{{ $row->comment }}" data-customer-id="{{ $row->id }}">
                            </td>
                        </tr>                       
                    @endforeach
                    </tbody>
                </table>
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
    $(document).ready(function() {
        $('.status-select').on('change', function() {
            var selectedStatusId = $(this).val();
            var customerId = $(this).data('customer-id'); // Get the customer ID from data attribute
            var table_name = $(this).data('table-name');
            var statusForm = $(this).closest('.status-form'); // Find the closest form element
            var color = $(this).data('color');
            var color='#'+color;
            

            var selectedOption = $(this).find('option:selected');

            // Get the background color of the selected option
            var backgroundColor = selectedOption.css('background-color');

            // Convert the background color to hexadecimal format
            var hexColor = rgbToHex(backgroundColor);

           

            $(color).css("background-color", hexColor);
            $.ajax({
                url: "{{ route('admin.chnage_customer_call_status') }}", // Replace with your route URL
                method: "POST",
                data: {
                    user_chat_status_id: selectedStatusId,
                    customer_id: customerId,
                    table: table_name,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    // Update the status message within the current row
                    // statusForm.find('.status-update-message').text(response.message);
                    alert(response.message);
                },
                error: function(xhr, status, error) {
                    // Handle error if necessary
                }
            });
        });

        function rgbToHex(rgbColor) {
            var rgbArray = rgbColor.match(/\d+/g);
            return "#" + rgbArray.map(function (value) {
                return ('0' + parseInt(value).toString(16)).slice(-2);
            }).join('');
        }
    });
</script>
<script>
    $(document).ready(function () {
        $('.comment-input').on('input', function () {
            var input = $(this);
            var customerId = input.data('customer-id');
            var tableValue = input.closest('tr').find('input[name="table"]').val();
            var commentValue = input.val();

            // Prepare data to be sent in the AJAX request
            var data = {
                customer_id: customerId,
                table: tableValue,
                comment: commentValue,
                _token: '{{ csrf_token() }}'
            };

            // Make the AJAX call
            $.ajax({
                url: '{{ route('admin.follow_up_customer_comment') }}', // Replace with your actual route URL
                method: 'get',
                data: data,
                success: function (response) {
                    // Handle the success response if needed
                },
                error: function (xhr, status, error) {
                    // Handle errors if needed
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('.comment-input1').on('input', function () {
            var input = $(this);
            var customerId = input.data('customer-id');
            var tableValue = input.closest('tr').find('input[name="table"]').val();
            var commentValue = input.val();

            // Prepare data to be sent in the AJAX request
            var data = {
                customer_id: customerId,
                table: tableValue,
                comment: commentValue,
                _token: '{{ csrf_token() }}'
            };

            // Make the AJAX call
            $.ajax({
                url: '{{ route('admin.follow_up_customer_comment') }}', // Replace with your actual route URL
                method: 'get',
                data: data,
                success: function (response) {
                    // Handle the success response if needed
                },
                error: function (xhr, status, error) {
                    // Handle errors if needed
                }
            });
        });
    });
</script>
@endsection
