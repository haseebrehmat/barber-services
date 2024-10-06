@extends('layouts.app')

@section('content')
    <div class="page-banner"
        style="background-image: url({{ asset('public/uploads/' . $general_settings_global->banner_checkout) }})">
        <div class="bg-page"></div>
        <div class="text">
            <h1>Thank you</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Thank you for availing our services</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="page-content pt_50 pb_60">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="alert alert-success p-4 d-flex align-items-center justify-content-center" role="alert">
                        <span style="font-size: 64px">🎊</span>
                        <p class="h5 ml-3">
                            @if ($session_offering['rate_type'] == 'regular')
                                Please take screenshot or picture your order number and show in Barbershop when you
                                arrive at.
                            @else
                                Please arrive 10 min early otherwise if you arrive 3 min late then appointment will be
                                cancel
                                and there is no refund policy existed currently.
                            @endif
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="border border-success text-center py-5 d-flex flex-column">
                        Order Number:
                        <strong class="text-success" style="letter-spacing: 3px;">
                            {{ $order_no }}
                        </strong>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <a class="btn btn-outline-success rounded-pill px-4 my-2" href="{{ url('offering/finish') }}">
                        Finish Order
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
