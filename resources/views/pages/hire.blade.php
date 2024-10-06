@extends('layouts.app')

@section('content')
    <div class="page-banner" style="background-image: url({{ asset('public/uploads/' . $g_setting->banner_registration) }})">
        <div class="bg-page"></div>
        <div class="text">
            <h1>Hiring</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Hiring</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="text-center">Motive</h4>
                    <p class="p-4">
                        You need a place to work and provide barber and beauty salon services, we have private
                        studios, semi-private spaces for you to rent. OPEN YOUR OWN BUSINESS INSIDE ESTABLISHMENT FOR 15
                        YEARS. Please contact us through below appeal form.
                    </p>
                </div>
                <div class="col-md-12">
                    <h4 class="text-center">Appeal Form</h4>
                    <div class="reg-login-form">
                        <div class="inner">
                            <form action="{{ route('front.hire.add_candidate') }}" method="post">
                                @csrf
                                <input type="hidden" name="from" value="website">
                                <div class="form-group">
                                    <label for="">Your Name *</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                        autofocus placeholder="Please enter your name">
                                </div>
                                <div class="form-group">
                                    <label for="">Your Email *</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                        placeholder="Please enter your email">
                                </div>
                                <div class="form-group">
                                    <label for="">Your Phone *</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}"
                                        placeholder="Please enter your phone">
                                </div>
                                <div class="form-group">
                                    <label for="">Your Message <small>(optional)</small></label>
                                    <textarea name="message" class="form-control" rows="5">
                                        {{ old('message') }}
                                    </textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-arf">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
