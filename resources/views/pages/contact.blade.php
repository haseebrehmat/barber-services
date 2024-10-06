@extends('layouts.app')

@php
    $options = DB::table('message_options')->get();
@endphp

@section('content')
    <style>
    .contact-tool {
        color: black;
        cursor: pointer;
    }
    </style>

    <div class="page-banner" style="background-image: url({{ asset('public/uploads/'.$g_setting->banner_contact) }})">
        <div class="bg-page"></div>
        <div class="text">
            <h1>{{ $contact->name }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $contact->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {!! $contact->detail !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <a href="https://www.google.com/maps?q={{ urlencode(is_null($contact->contact_address) ? '' : $contact->contact_address) }}" target="_blank" >
                    <div class="contact-item flex">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Address</h4>
                            <a href="https://www.google.com/maps?q={{ urlencode(is_null($contact->contact_address) ? '' : $contact->contact_address) }}" target="_blank" class="contact-tool">
                                {!! nl2br(e($contact->contact_address)) !!}
                            </a>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="tel: {{ empty($numbers) ? '' : $numbers[0] }}"  target="_blank">
                    <div class="contact-item flex">
                        <div class="contact-icon">
                            <i class="fas fa-phone-volume" aria-hidden="true"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Phone Number</h4>
                            @if (isset($contact->contact_phone))
                                @php
                                    $pattern = '/\(\d{3}\) ?\d{3}-\d{4}/';
                                    preg_match_all($pattern, $contact->contact_phone, $matches);
                                    $numbers = $matches[0];
                                @endphp
                                <a href="tel: {{ empty($numbers) ? '' : $numbers[0] }}" class="contact-tool" target="_blank">
                                    {!! nl2br(e($contact->contact_phone)) !!}
                                </a>
                            @endif
                        </div>
                    </div>
                </a>
                </div>
                {{-- <div class="col-md-4">
                    <div class="contact-item flex">
                        <div class="contact-icon">
                            <i class="fas fa-envelope-open" aria-hidden="true"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Email Address</h4>
                            <p>
                                {!! nl2br(e($contact->contact_email)) !!}
                            </p>
                        </div>
                    </div>
                </div> --}}
                <div class="col-md-12">
                    <div class="contact-item flex">
                        <div class="contact-icon">
                            <i class="far fa-clock" aria-hidden="true"></i>
                        </div>
                        <div class="contact-text">
                            <h4>Shop Timings</h4>
                            @foreach ($timings as $day => $timing)
                                <p class="row">
                                    <span class="col-md-4" style="font-weight:bold;font-size:17px;">{{ $day }}</span>
                                    @if ($timing["off_day"])
                                    <span class="col-md-8">Off Day</span>
                                    @else
                                    <span class="col-md-4">
                                        Open at {{ isset($timing['open_time']) ? \Carbon\Carbon::parse($timing['open_time'])->format("h:i A") : 'n/a' }}
                                    </span>
                                    <span class="col-md-4">
                                        Close at {{ isset($timing['close_time']) ? \Carbon\Carbon::parse($timing['close_time'])->format("h:i A") : 'n/a'  }}
                                    </span>
                                    @endif
                                    @if (!$loop->last)
                                     <hr class="my-2">
                                    @endif
                                </p>
                            @endforeach
                            <hr class="my-2">
                            <p class="row">
                                <span class="col-md-4" style="font-weight:bold;font-size:17px;color:red;">Late Hours</span>
                                <span class="col-md-4">
                                    After 8:00 PM Till 9:00 PM
                                </span>
                                <span class="col-md-4">
                                    Original Price : $75.00 <br> Price With Discount: $55.00
                                </span>
                            </p>    
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="row contact-form">
                <div class="col-md-12">
                    <h4 class="contact-form-title mt_50 mb_20">Contact Form</h4>
                    <form action="{{ route('front.contact_form') }}" method="post">
                        @csrf


                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Name (Required)</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Organization Name</label>
                                    <input type="text" class="form-control" name="organization">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Phone Number (Required)</label>
                                    <input type="text" class="form-control" name="phone">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Who are you?</label>
                                    <select name="option" class="form-control">
                                        @forelse ($options as $option)
                                            <option value="{{$option->name}}">{{$option->name}}</option>
                                        @empty
                                            <option value="">No options added</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>



                        <div class="form-group">
                            <label>Message (Required)</label>
                            <textarea name="info" class="form-control h-200" cols="30" rows="10"></textarea>
                        </div>

                        @if($g_setting->google_recaptcha_status == 'Show')
                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="{{ $g_setting->google_recaptcha_site_key }}"></div>
                        </div>
                        @endif

                        <button type="submit" class="btn btn-primary mt_10">Send Message</button>
                    </form>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
