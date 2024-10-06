@extends('layouts.app')

@section('content')
    <div class="page-banner"
        style="background-image: url({{ asset('public/uploads/' . $general_settings_global->banner_registration) }})">
        <div class="bg-page"></div>
        <div class="text">
            <h1>Create Reservation</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Reservation</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="reg-login-form">
                        <div class="inner">
                            <form action="{{ route('admin.booking.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="type" value="1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Name *</label>
                                            <input type="text" name="name" class="form-control form-control-sm"
                                                value="{{ old('name') }}" autofocus required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Email *</label>
                                            <input type="email" name="email" class="form-control form-control-sm"
                                                value="{{ old('email') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Phone *</label>
                                            <input type="text" name="phone" class="form-control form-control-sm"
                                                value="{{ old('phone') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Reservation Date *</label>
                                            <input type="date" name="date" class="form-control form-control-sm"
                                                value="{{ old('date') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Reservation Time *</label>
                                            <input type="time" name="time" class="form-control form-control-sm"
                                                value="{{ old('time') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Number of Persons *</label>
                                            <input type="number" name="persons" class="form-control form-control-sm"
                                                value="{{ old('persons') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Information</label>
                                    <textarea name="info" class="form-control" rows="4">{{ old('info') }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-arf">Reserve a table</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
