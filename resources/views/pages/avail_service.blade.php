
<div class="modal fade" id="avail_offering" tabindex="-1" aria-labelledby="avail_offeringLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('front.avail_offering') }}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="avail_offeringLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="d-flex flex-column">
                        <span class="font-weight-bold">Service Details</span>
                        <div class="details"></div>
                    </div>
                    <input type="hidden" name="offering_id">
                    <div class="row mt-2 align-items-end">
                        <div class="col-md-6">
                            <label class="font-weight-bold">Choose Price Type</label>
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="radio" name="rate_type" value="regular" required>
                                <label class="form-check-label">Walking Rate</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rate_type" value="appointed" required>
                                <label class="form-check-label">Appointment Rate</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border border-2 p-3 text-center h5 regular-rate" style="display:none"></div>
                            <div class="border border-2 p-3 text-center h5 appointed-rate" style="display:none"></div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <span class="col-md-12 font-weight-bold mb-2">Other Information</span>
                        <div class="col-md-6">
                            <div class="d-flex flex-column">
                                <small class="mb-0">Your First Name *</small>
                                <input class="form-control" required type="text" name="client_fname" placeholder="John">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column">
                                <small class="mb-0">Your Last Name *</small>
                                <input class="form-control" required type="text" name="client_lname" placeholder="Doe">
                            </div>
                        </div>
                        <div class="col-md-6 mt-1">
                            <div class="d-flex flex-column">
                                <small class="mb-0">Your Email *</small>
                                <input class="form-control" required type="email" name="client_email"
                                    placeholder="john.doe@gmail.com">
                            </div>
                        </div>
                        <div class="col-md-6 mt-1">
                            <div class="d-flex flex-column">
                                <small class="mb-0">Your Contact *</small>
                                <input class="form-control" required type="text" name="client_phone"
                                    placeholder="3105558273">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 appointment" style="display: none">
                        <span class="col-md-12 mb-2 font-weight-bold">Appointment Details</span>
                        <div class="col-md-12">
                            <div class="d-flex flex-column mt-1">
                                <small class="mb-0">Choose Time Slot *</small>
                                <div class="d-flex flex-wrap">
                                    @php
                                        $today = \Carbon\Carbon::now(); // Get current date and time
                                
                                        // If today is Monday, set the start time to 10:00 AM
                                        $start_time = $today->isMonday() ? \Carbon\Carbon::createFromTime(10, 0, 0) : \Carbon\Carbon::createFromTime(8, 0, 0);
                                
                                        // Set end time to 9:20 PM for all days
                                        $end_time = \Carbon\Carbon::createFromTime(21, 20, 0);
                                
                                        // Service interval of 40 minutes
                                        $interval = 40;
                                
                                        // Generate time slots
                                        $time_slots = \Carbon\CarbonPeriod::create($start_time, $interval . ' minutes', $end_time)->toArray();
                                    @endphp
                                
                                    @foreach ($time_slots as $slot)
                                        @php
                                            // Check if the slot is already taken
                                            $na = in_array($slot->format('H:i'), $appointed_slots);
                                        @endphp
                                        <div class="border p-2 m-1 @if ($na) bg-success @endif">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="slot{{ $loop->index }}" name="appointment_time" class="custom-control-input"
                                                       value="{{ $slot->format('H:i') }}" @if ($na) disabled @endif>
                                                <label class="custom-control-label @if ($na) text-white @endif" for="slot{{ $loop->index }}">
                                                    {{ $slot->format('g:i A') }} <!-- 12-hour format with AM/PM -->
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer cart-button px-2">
                    <p style="text-align: center;">
                        <b>SAME DAY APPOINTMENTS</b>. If you need to talk, please call us
                        <a style="background:	#36454F" href="tel:+18189167725">(818) 916-7725</a>
                    </p>
                    <button type="submit" class="add-to-cart">
                        <i class="fab fa-amazon-pay mr-1"></i>
                        Proceed to Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('.avail-offering-btn').click(function() {
        const offering = $(this).data('offering');
        console.log(offering);

        $("#avail_offering .regular-rate").hide();
        $("#avail_offering .appointed-rate").hide();
        $("#avail_offering .appointment").hide();
        $("#avail_offering input[name='rate_type']").prop("checked", false);
        $("#avail_offering input[name='appointment_time']").prop("checked", false);

        $("#avail_offering input[name='offering_id']").val(offering?.id);
        $("#avail_offering .modal-title").text(`${offering?.name}`);
        $("#avail_offering .details").html(offering?.details);

        $("#avail_offering input[name='rate_type']").change(function(e) {
            e.preventDefault();
            const value = $(this).val();
            if (value == "regular") {
                $("#avail_offering .regular-rate").show();
                $("#avail_offering .regular-rate").text(`USD ${offering?.regular_rate}`);
                $("#avail_offering .appointed-rate").hide();
                $("#avail_offering .appointment").hide();
                $("#avail_offering input[name='appointment_time']").prop("checked", false);
            } else {
                $("#avail_offering .regular-rate").hide();
                $("#avail_offering .appointed-rate").show();
                $("#avail_offering .appointed-rate").text(`USD ${offering?.appointed_rate}`);
                $("#avail_offering .appointment").show();
            }
        });

        $("#avail_offering").modal('show');
    });
</script>
