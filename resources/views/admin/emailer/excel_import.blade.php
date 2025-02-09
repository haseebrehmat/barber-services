@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Import Excel Contacts</h1>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div id="account_edit">
                {{-- {{ Form::open(['route' => 'bulk.sms.excel.post', 'method' => 'post', 'id' => 'sms_form', 'files' => true]) }} --}}
                <form action="{{ url('admin/excel_import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div id="upload_excel" class="mb-3">
                                        <label for="excel_file" class="form-label">Upload Excel File:</label>
                                        <input type="file" name="file" class="form-control-file" id="excel_file">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="download_sample_excel" class="mb-3">
                                        <a href="{{ asset('public/demo_excels') }}/demo_bulk.xlsx" download>Download Sample Excel File</a>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 text-right">
                                <button type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto" id="submit-all">{{ __('Import Excel Sheet') }}</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <br>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            {{-- <h6 class="m-0 mt-2 font-weight-bold text-primary">Imported Excel Contact</h6> --}}

        </div>
        <a href="#"  data-toggle="modal" class="btn btn-primary btn-sm btn-block" data-target="#send_email">Send Email to Customers</a>
        
        <a href="{{ URL::to('admin/excel/delete') }}" class="btn btn-danger btn-sm btn-block" onClick="return confirm('You are deleting all Excel Contacts. Are you sure?');">Delete All Imported Contacts</a>
        <div class="card-body">
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
                            {{-- <td>{{ $loop->iteration }}</td> --}}
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->phone }}</td>
                            <td>
                                <div class="d-flex">
                                     <button class="btn btn-sm text-success py-0 edit-contact-btn"
                                         data-url="{{ url('excel_contact/'. $row->id) }}"
                                         data-name="{{ $row->name }}" data-email="{{ $row->email }}" data-phone="{{ $row->phone }}">
                                         <i class="fas fa-pencil-alt"></i> Edit
                                     </button>
                                     <form action="{{ url('excel_contact/'. $row->id) }}" method="post">
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


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
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
              <form action="{{ route('admin.customers.send_email_action.excel') }}" method="post">
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
              <form action="{{ route('admin.customers.send_sms_action.excel') }}" method="post">
                  @csrf
                  <input type="hidden" name="customer_ids" class="customer_ids">
                 <div class="form-group">
                     <textarea class="form-control" name="message" placeholder="Compose SMS"></textarea>
                 </div>
                 <span class="text-danger">{{$smsLimit -$smsSent}} SMS remaining</span>
                  <div class="form-group">
                      <button type="submit" class="btn btn-primary pull-right float-right">Send</button>
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
              <form action="{{ route('admin.customers.send_whatsapp_action.excel') }}" method="post">
                  @csrf
                  <input type="hidden" name="customer_ids" class="customer_ids">
                 <div class="form-group">
                     <textarea class="form-control" name="message" placeholder="Compose SMS"></textarea>
                 </div>
                 <span class="text-danger">{{$whatsappLimit -$whatsappSent}} Whatsapp Messages remaining</span>
                  <div class="form-group">
                      <button type="submit" class="btn btn-primary pull-right float-right">Send</button>
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
                    <h5 class="modal-title" id="edit_contactLabel">Edit Excel Contact</h5>
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



@endsection
