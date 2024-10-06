@extends('layouts.app')

@section('content')
    <style>
        @media (min-width: 768px) {
            .custom-margin {
                margin-left: -1%;
            }

            .mobile-card {
                display: none;
            }
        }

        @media (max-width: 767.98px) {
            .custom-margin {
                margin-left: -5%;
            }

            .desktop-table {
                display: none;
            }

            .mobile-card {
                display: block;
                margin-bottom: 15px;
                border: 1px solid #dee2e6;
                padding: 10px;
                border-radius: 5px;
            }

            .mobile-card img {
                width: 100%;
                height: auto;
            }
        }

        .mobile-card label {
            font-weight: bold;
        }

        /* Ensure the dropdown stays within the card on mobile */
        .mobile-card select.select2 {
            width: 100%; /* Make the dropdown take up the full width of its container */
            box-sizing: border-box; /* Ensure padding and borders are included in the width */
            max-width: 100%; /* Prevent overflow */
        }

        /* Adjust the container of the dropdown if needed */
        .mobile-card div {
            overflow: hidden; /* Prevent any overflow */
        }

        /* Optional: Tweak padding or margins if needed */
        .mobile-card .mb-2 {
            padding-right: 10px; /* Add some padding on the right if necessary */
        }
    </style>
    <!-- CSS for input field animation -->
    <style>
        .animated-input {
            transition: all 0.3s ease; /* Smooth transition for the effects */
        }

        .animated-input:focus, .animated-input:hover {
            transform: scale(1.05); /* Slightly enlarge the input field */
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5); /* Add a glowing effect */
            border-color: #007bff; /* Change border color on focus */
        }
    </style>

    <div class="page-banner"
        style="background-image: url({{ asset('public/uploads/' . $general_settings_global->banner_checkout) }})">
        <div class="bg-page"></div>
        <div class="text">
            <h1>Service Checkout</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Service Payment</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="page-content pt_50 pb_60">
        <div class="container-fluid px-5">
            <div class="row cart">
                <!-- Desktop Form -->
                <div class="col-md-12 desktop-table">
                    <form id="desktopServiceForm" action="{{ url('offering/avail/update') }}" method="post">
                        @csrf
                        <div class="d-flex align-items-baseline justify-content-between">
                            <h3>Service</h3>
                            <button class="btn btn-sm btn-primary" type="submit">Update Service</button>
                        </div>

                        <!-- Desktop Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-info table-striped-columns">
                                        <th>Sr</th>
                                        <th>Thumbnail</th>
                                        <th>Service Name</th>
                                        <th>Service Type</th>
                                        <th style="min-width: 250px;">Client Name</th>
                                        <th style="min-width: 250px;">Client Email/Contact</th>
                                        <th>Appointment Details</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="align-middle">1</td>
                                        <td class="align-middle">
                                            <input type="hidden" name="offering_id" value="{{ $session_offering['offering_id'] }}">
                                            <img src="{{ asset('public/uploads/' . $offering->photo) }}" style="width: 70px;">
                                        </td>
                                        <td class="align-middle">{{ $offering->name }}</td>
                                        <td class="align-middle">
                                            <div class="form-check mb-1">
                                                <input class="form-check-input" type="radio" name="rate_type"
                                                    value="regular" required
                                                    @if ($session_offering['rate_type'] == 'regular') checked @endif>
                                                <label class="form-check-label">Walking Rate
                                                    (${{ $offering->regular_rate }})</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="rate_type"
                                                    value="appointed" required
                                                    @if ($session_offering['rate_type'] == 'appointed') checked @endif>
                                                <label class="form-check-label">Appointment Rate
                                                    (${{ $offering->appointed_rate }})</label>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex flex-column">
                                                <small class="mb-0">Your First Name *</small>
                                                <input class="form-control" required type="text" name="client_fname"
                                                    placeholder="John" value="{{ $session_offering['client_fname'] }}">
                                                <small class="mb-0">Your Last Name *</small>
                                                <input class="form-control" required type="text" name="client_lname"
                                                    placeholder="Doe" value="{{ $session_offering['client_lname'] }}">
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex flex-column">
                                                <small class="mb-0">Your Email *</small>
                                                <input class="form-control" required type="email" name="client_email"
                                                    placeholder="john.doe@gmail.com"
                                                    value="{{ $session_offering['client_email'] }}">
                                                <small class="mb-0">Your Contact *</small>
                                                <input class="form-control" required type="text" name="client_phone"
                                                    placeholder="3105558273"
                                                    value="{{ $session_offering['client_phone'] }}">
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            @if ($session_offering['rate_type'] == 'appointed')
                                                <div class="d-flex flex-column">
                                                    @if (isset($general_settings_global->shop_open_time) &&
                                                        isset($general_settings_global->shop_close_time) &&
                                                        isset($general_settings_global->shop_service_interval))
                                                        @php
                                                            $intervals = \Carbon\CarbonPeriod::since($general_settings_global->shop_open_time)
                                                                ->minutes($general_settings_global->shop_service_interval)
                                                                ->until($general_settings_global->shop_close_time)
                                                                ->toArray();
                                                        @endphp
                                                        <small class="mb-0">Choose Time Slot *</small>
                                                        <select name="appointment_time" class="select2" required
                                                                onchange="$(form).submit()">
                                                            <option value="">Please choose available time slot</option>
                                                            @foreach ($intervals as $row)
                                                                <option value="{{ $row->format('H:i') }}"
                                                                        @if ($session_offering['appointment_time'] == $row->format('H:i')) selected @endif
                                                                        @if (in_array($row->format('H:i'), $slots)) disabled @endif>
                                                                    {{ $row->format('g:i A') }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        <span>Opening and Closing times are not set yet</span>
                                                    @endif
                                                </div>
                                            @else
                                                <input type="hidden" name="appointment_time" value="">
                                                <span>---</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">${{ $final_price }}</td>
                                    </tr>

                                    <!-- Updated Total Row -->
                                    @php
                                        $totalAmount = $final_price + ($session_offering['tip_amount'] ?? 0) - ($session_offering['coupon_discount'] ?? 0);
                                        $totalAmount = $totalAmount < 0 ? 0 : $totalAmount;
                                    @endphp
                                    <tr>
                                        <td colspan="7" class="text-right"><strong>Total Amount:</strong></td>
                                        <td>${{ $totalAmount }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>

                <!-- Mobile Form -->
                <div class="col-md-12 mobile-card">
                    <form id="mobileServiceForm" action="{{ url('offering/avail/update') }}" method="post">
                        @csrf
                        <input type="hidden" name="offering_id" value="{{ $session_offering['offering_id'] }}">
                        <div class="mb-2">
                            <img src="{{ asset('public/uploads/' . $offering->photo) }}" alt="Service Thumbnail">
                        </div>
                        <div class="mb-2">
                            <label>Service Name:</label>
                            <p>{{ $offering->name }}</p>
                        </div>
                        <div class="mb-2">
                            <label>Service Type:</label>
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="radio" name="rate_type" value="regular" required
                                    @if ($session_offering['rate_type'] == 'regular') checked @endif>
                                <label class="form-check-label">Walking Rate (${{ $offering->regular_rate }})</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rate_type" value="appointed" required
                                    @if ($session_offering['rate_type'] == 'appointed') checked @endif>
                                <label class="form-check-label">Appointment Rate (${{ $offering->appointed_rate }})</label>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label>Client First Name:</label>
                            <input class="form-control" required type="text" name="client_fname" placeholder="John"
                                value="{{ $session_offering['client_fname'] }}">
                        </div>
                        <div class="mb-2">
                            <label>Client Last Name:</label>
                            <input class="form-control" required type="text" name="client_lname" placeholder="Doe"
                                value="{{ $session_offering['client_lname'] }}">
                        </div>
                        <div class="mb-2">
                            <label>Client Email:</label>
                            <input class="form-control" required type="email" name="client_email" placeholder="john.doe@gmail.com"
                                value="{{ $session_offering['client_email'] }}">
                        </div>
                        <div class="mb-2">
                            <label>Client Contact:</label>
                            <input class="form-control" required type="text" name="client_phone" placeholder="3105558273"
                                value="{{ $session_offering['client_phone'] }}">
                        </div>
                        <div class="mb-2">
                            <label>Appointment Details:</label>
                            @if ($session_offering['rate_type'] == 'appointed')
                                <div>
                                    <select name="appointment_time" class="select2" required onchange="$(form).submit()">
                                        <option value="">Please choose available time slot</option>
                                        @foreach ($intervals as $row)
                                            <option value="{{ $row->format('H:i') }}"
                                                @if ($session_offering['appointment_time'] == $row->format('H:i')) selected @endif
                                                @if (in_array($row->format('H:i'), $slots)) disabled @endif>
                                                {{ $row->format('g:i A') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <input type="hidden" name="appointment_time" value="">
                                <p>---</p>
                            @endif
                        </div>
                        <div class="mb-2">
                            <label>Amount:</label>
                            <p>${{ $final_price }}</p>
                        </div>

                        <!-- Add Update Service Button -->
                        <div class="mb-2">
                            <button class="btn btn-primary w-100" type="submit">Update Service</button>
                        </div>
                    </form>
                </div>

                @if (
                    ($session_offering['rate_type'] == 'appointed' && isset($session_offering['appointment_time'])) ||
                        $session_offering['rate_type'] == 'regular')
                    <div class="col-md-12">
                        <h3>Make Payment</h3>
                        <form id="tipForm" action="{{ url('offering/avail/update-tip') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="tip_amount">Tip Amount (Optional):</label>
                                <div class="input-group col-md-2 custom-margin">
                                    <!-- Add the GIF next to the input field -->
                                    <img src="https://aabsolutebarbersvipnsalons.com/Red-circle.gif" alt="Tip Hint" style="width: 40px; height: 40px;">
                                    <input type="number" name="tip_amount" class="form-control animated-input" min="0" step="0.01" value="{{ $session_offering['tip_amount'] ?? 0 }}" aria-label="Tip amount">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Add Tip</button>
                                    </div>
                                </div>
                            </div>

                        </form>

                        <form id="couponForm" action="{{ url('offering/avail/coupon') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="coupon_code">Apply Coupon Code:</label>
                                <div class="input-group col-md-4 custom-margin">
                                    <input type="text" name="coupon_code" class="form-control animated-input" min="0" step="0.01" value="{{ $session_offering['coupon_code'] ?? ''}}" aria-label="Tip amount">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-sm btn-secondary">Apply</button>
                                    </div>
                                </div>
                                @if (isset($session_offering['coupon_code']))
                                    <small class="p-2">You have already applied coupon ({{ $session_offering['coupon_code'] }}) -> Amount (${{ $session_offering['coupon_discount'] }}).</small>
                                @endif
                            </div>

                        </form>
                        <br>
                        <!-- Updated Total Amount for Mobile -->
                        <div class="mb-2">
                            <label><h4>Total Amount: ${{ $totalAmount }}</h4></label>

                        </div>
                        <div class="row">
                            <div class="col-md-4 col-lg-2">
                                <div class="form-group">
                                    <label for="paymentMethodChange">Select Payment Method</label>
                                    <select name="payment_method" class="form-control select2" id="paymentMethodChange">
                                        <option value="">Select Payment Method</option>
                                        @foreach ($enabled_modes as $mode)
                                            <option value="{{ $mode->method_key }}">{{ $mode->method_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div id="offline_payment" class="col-md-12">
                                <div class="cash-in-shop mt_20">
                                    <h6>You will pay after your service is done in shop</h6>
                                    <a href="{{ url('offering/payment/cash') }}" class="btn btn-sm btn-primary">Proceed Order</a>
                                </div>
                            </div>

                            <div id="paypal_div" class="col-md-12">
                                <div class="paypal mt_20">
                                    <h4>Pay with PayPal</h4>
                                    <div id="paypal-button"></div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="stripe mt_20">
                                    @php
                                        $cents = $totalAmount * 100;
                                    @endphp
                                    <form action="{{ url('offering/payment/stripe') }}" method="post">
                                        @csrf
                                        <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                            data-key="{{ env('ADMIN_STRIPE_PUBLIC_KEY') }}" data-amount="{{ $cents }}"
                                            data-name="{{ env('APP_NAME') }}" data-description="" data-image="{{ asset('public/uploads/stripe_icon.png') }}"
                                            data-currency="usd" data-email="{{ $session_offering['client_email'] }}"></script>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @php
        $paypal_mode = env('PAYPAL_ENV_TYPE');
        $client = env('PAYPAL_CLIENT_ID');
        $secret = env('PAYPAL_SECRET_KEY');
    @endphp

    @if ($paypal_mode == 'sandbox')
        @php
            $paypal_url = 'https://api.sandbox.paypal.com/v1/';
            $env_type = 'sandbox';
        @endphp
    @elseif($paypal_mode == 'production')
        @php
            $paypal_url = 'https://api.paypal.com/v1/';
            $env_type = 'production';
        @endphp
    @endif

    <script>
        paypal.Button.render({
            env: '{{ $env_type }}',
            client: {
                sandbox: '{{ $client }}',
                production: '{{ $client }}'
            },
            locale: 'en_US',
            style: {
                size: 'medium',
                color: 'blue',
                shape: 'rect',
            },
            commit: true, // Allow users to pay without a PayPal account

            // Set up a payment
            payment: function(data, actions) {
                return actions.payment.create({
                    transactions: [{
                        amount: {
                            total: '{{ $final_price }}',
                            currency: 'USD'
                        }
                    }]
                });
            },

            // Execute the payment
            onAuthorize: function(data, actions) {
                return actions.redirect();
            }
        }, '#paypal-button');
    </script>

    <script>
        $(document).ready(function() {
            // Attach a click event listener to all radio boxes with name "rate_type"
            $('input[name="rate_type"]').on('click', function() {
                // Submit the appropriate form based on the screen size
                if ($(window).width() >= 768) {
                    $('#desktopServiceForm').submit();
                } else {
                    $('#mobileServiceForm').submit();
                }
            });
        });
    </script>
@endsection
