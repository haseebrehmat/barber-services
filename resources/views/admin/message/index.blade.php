@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Messages (Contact Us)</h1>

    <div class="row">
        <div class="col-md-9">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 mt-2 font-weight-bold text-primary">View Messages</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered messages-table" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                @if (count($messages) > 0)
                                    <th scope="col"><input type="checkbox" class="check-all"></th>
                                @endif
                                <th>SL</th>
                                <th>Contact Name</th>
                                <th>Phone Number</th>
                                <th>Organization Name</th>
                                <th>Type</th>
                                <th>Message</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($messages as $row)
                                <tr>
                                    <td scope="row">
                                        <input type="checkbox" class="check" data-id="{{$row->id}}">
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->phone }}</td>
                                    <td>{{ $row->organization }}</td>
                                    <td>{{ $row->option }}</td>
                                    <td>{{ $row->info }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-2 mb-2 bg-light border rounded shadow">
                <div class="d-flex flex-column">
                    <a href="#" data-toggle="modal" class="btn btn-info btn-sm btn-block" data-target="#send_sms">
                        Send SMS to Contacts
                        <span class="font-weight-bold" style="font-size: 18px">({{ $smsSent . ' / ' . $smsLimit }})</span>
                    </a>
                    <a href="#" data-toggle="modal" class="btn btn-success btn-sm btn-block" data-target="#send_whatsapp">
                        Send Whatsapp to Contacts
                        <span class="font-weight-bold" style="font-size: 18px">({{ $whatsappSent . ' / ' . $whatsappLimit }})</span>    
                    </a>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 mt-2 font-weight-bold text-primary">Options</h6>
                    <div class="float-right d-inline">
                        <a href="javascript:;" class="btn btn-primary btn-sm" onclick="$('#create-option-form').toggle()"><i class="fa fa-plus"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="create-option-form" style="display:none;">
                        <form action="{{route('admin.message.option.store')}}" method="post">
                            @csrf
                            <input type="text" name="name" class="form-control">
                            <input type="submit" value="Add" class="btn btn-sm btn-primary my-2">
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($options as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>
                                        <form action="{{route('admin.message.option.delete', $row->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm text-danger border-0 far fa-trash-alt m-0" onclick="if(confirm('Are u sure?')){$(form).submit()}"></button>
                                        </form>
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
    <!--SMS Modal -->
    @if ($smsFlag)
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
                            <input type="hidden" name="from" value="contact_us">
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

    <!--Whatsapp Modal -->
    @if ($whatsappFlag)
        <div class="modal fade" id="send_whatsapp" tabindex="-1" role="dialog" aria-labelledby="send_whatsappLabel"
            aria-hidden="true">
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
                            <input type="hidden" name="from" value="contact_us">
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


    <script>
        $(document).ready(function() {
            $('.messages-table').TableCheckAll()

            $('.check, .check-all').change(function (e) {
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

@endsection
