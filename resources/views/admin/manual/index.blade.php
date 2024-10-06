@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Manual SMS/Whatsapp/Email</h1>

    <div class="card shadow mb-4">
       <br>

        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <a href="#" data-toggle="modal" class="btn btn-primary btn-lg btn-block" data-target="#send_email">Send Email</a>
            </div>
        </div>

        <br>
        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <a href="#" data-toggle="modal" class="btn btn-info btn-lg btn-block" data-target="#send_sms">Send SMS
                    <span class="font-weight-bold" style="font-size: 18px">({{ $smsSent . ' / ' . $smsLimit }})</span>
                </a>
            </div>
        </div>
        <br>
        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <a href="#" data-toggle="modal" class="btn btn-success btn-lg btn-block" data-target="#send_whatsapp">Send Whatsapp
                    <span class="font-weight-bold" style="font-size: 18px">({{ $whatsappSent . ' / ' . $whatsappLimit }})</span>
                </a>
            </div>
        </div>
        <br>
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
              <form action="{{ route('admin.manual.email') }}" method="post">
                  @csrf
                 <div class="form-group">
                    <input type="email" required class="form-control" name="to" placeholder="To">   <br>
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
              <form action="{{ route('admin.manual.sms') }}" method="post">
                  @csrf
                  <input type="text" required class="form-control" name="to" placeholder="To">   <br>
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
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="send_whatsappLabel">Write Whatsapp Message</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{ route('admin.manual.whatsapp') }}" method="post">
                  @csrf
                  <input type="text" required class="form-control" name="to" placeholder="To">   <br>
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





@endsection
