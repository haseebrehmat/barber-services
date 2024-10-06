@extends('layouts.app')

@section('content')
    <div class="page-banner" style="background-image: url({{ asset('public/uploads/'.$g_setting->banner_checkout) }})">
        <div class="bg-page"></div>
        <div class="text">
            <h1>Payment</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Payment</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="page-content pt_50 pb_60">
        <div class="container">
            <div class="row cart">
                <div class="col-md-12">

                    <h3>Make Payment</h3>

                    <h5>Select Payment Mode</h5>
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                {{-- <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="payment_type" value="online" />
                                    <label class="form-check-label">Online</label>
                                </div> --}}
                                <div class="form-check form-check-inline ml-5">
                                    <input class="form-check-input" type="radio" name="payment_type" value="offline" />
                                    <label class="form-check-label">Cash Payment</label>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('customer.payment.offline') }}" method="POST" class="offline">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <select name="offline_type" class="form-control offline-select-box">
                                        <option value="">Select Offline Payment Type</option>
                                        <option value="Delivery">Home Delivery</option>
                                        {{-- <option value="Pickup">Pick Up</option> --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row shipping-address">
                            <div class="col-md-12">
                                <span class="font-weight-bold">Shipping Address:</span>
                                {{ session()->get('shipping_address') .', '. session()->get('shipping_country') .' '. session()->get('shipping_state') .' '. session()->get('shipping_city') .', '. session()->get('shipping_zip') }}
                            </div>
                        </div>
                        <div class="mt_20">
                            <button class="btn btn-primary" type="submit">Place Order</button>
                        </div>
                    </form>

                    <div class="row online">
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <select name="payment_method" class="form-control" id="paymentMethodChange">
                                    <option value="">Select Payment Method</option>
                                    <option value="PayPal">PayPal</option>
                                    <option value="Stripe">Card</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="paypal mt_20">
                                <h4>Pay with PayPal</h4>
                                <div id="paypal-button"></div>
                            </div>

                            <div class="stripe mt_20">
                                <h4>Pay with Card</h4>

                                @if(session()->get('shipping_cost'))
                                    @php
                                        $final_price = (session()->get('subtotal') + session()->get('shipping_cost'))-session()->get('coupon_amount');
                                    @endphp
                                @else
                                    @php
                                        $final_price =session()->get('subtotal') - session()->get('coupon_amount');
                                    @endphp
                                @endif

                                @php
                                    $cents = $final_price*100;
                                @endphp

                                @if(session()->get('customer_email'))
                                    @php
                                        $c_email = session()->get('customer_email');
                                    @endphp
                                @else
                                    @php
                                        $c_email = session()->get('billing_email');
                                    @endphp
                                @endif

                                <form action="{{ route('customer.stripe') }}" method="post">
                                    @csrf
                                    <script
                                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                        data-key="{{ env('ADMIN_STRIPE_PUBLIC_KEY') }}"
                                        data-amount="{{ $cents }}"
                                        data-name="{{ env('APP_NAME') }}"
                                        data-description=""
                                        data-image="{{ asset('public/uploads/stripe_icon.png') }}"
                                        data-currency="usd"
                                        data-email="{{ $c_email }}"
                                    >
                                    </script>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    @php
        $paypal_mode = env('PAYPAL_ENV_TYPE');
        $client = env('PAYPAL_CLIENT_ID');
        $secret = env('PAYPAL_SECRET_KEY');
    @endphp

    @if(session()->get('shipping_cost'))
        @php
            $final_price = (session()->get('subtotal') + session()->get('shipping_cost'))-session()->get('coupon_amount');
        @endphp
    @else
        @php
            $final_price =session()->get('subtotal') - session()->get('coupon_amount');
        @endphp
    @endif

    @if($paypal_mode == 'sandbox')
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

            // Set up a payment
            payment: function (data, actions) {
                return actions.payment.create({

                    redirect_urls:{
                        return_url: '{{ url("customer/execute-payment") }}'
                    },

                    transactions: [{
                        amount: {
                            total: '{{ $final_price }}',
                            currency: 'USD'
                        }
                    }]
              });
            },

            // Execute the payment
            onAuthorize: function (data, actions) {
                return actions.redirect();
            }
        }, '#paypal-button');
        </script>

    <script>
        initPaymentTypes()
        $(document).ready(function () {

            $("input[name='payment_type']").change(function (e) {
                e.preventDefault();

                const payment_type = $(this).val();

                if (payment_type == 'online') {
                    $(".offline").hide();
                    $(".online").show();
                } else if (payment_type == 'offline') {
                    $(".online").hide();
                    $(".offline").show();
                } else {
                    initPaymentTypes()
                    toastr.error("Please select valid payment type")
                }
            });

            $("select[name='offline_type']").change(function (e) {
                e.preventDefault();

                const offline_type = $(this).val();
                if (offline_type == 'Delivery') {
                    $(".shipping-address").show();
                } else if (offline_type == 'Pickup') {
                    $(".shipping-address").hide();
                } else {
                    initPaymentTypes()
                    toastr.error("Please select valid offline payment type")
                }
            });

        });

        function initPaymentTypes() {
            $("input[name='payment_type']").prop("checked", false);
            $(".offline-select-box option:selected").prop("selected", false);
            $(".offline").hide();
            $(".online").hide();
            $(".shipping-address").hide();
        }
    </script>

@endsection
