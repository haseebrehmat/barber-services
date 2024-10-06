@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">SMTP Configuration</h1>

    <form action="{{ route('admin.smtp-config.update') }}" method="post">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">Edit SMTP Configuration</h6>
            </div>
            <div class="card-body row">
                <div class="form-group col-md-6">
                    <label for="">MAIL HOST *</label>
                    <input type="text" name="host" class="form-control" value="{{ env('MAIL_HOST') ?? old('host') }}"
                        autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="">MAIL PORT *</label>
                    <input type="number" name="port" class="form-control" value="{{ env('MAIL_PORT') ?? old('port') }}"
                        autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="">MAIL USERNAME *</label>
                    <input type="text" name="username" class="form-control"
                        value="{{ env('MAIL_USERNAME') ?? old('username') }}" autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="">MAIL PASSWORD *</label>
                    <input type="password" name="password" class="form-control"
                        value="{{ env('MAIL_PASSWORD') ?? old('password') }}" autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="">MAIL ENCRYPTION *</label>
                    <input type="text" name="encryption" class="form-control"
                        value="{{ env('MAIL_ENCRYPTION') ?? old('encryption') }}" autofocus>
                </div>
                <div class="form-group col-md-6">
                    <label for="">MAIL FROM ADDRESS *</label>
                    <input type="email" name="from_address" class="form-control"
                        value="{{ env('MAIL_FROM_ADDRESS') ?? old('from_address') }}" autofocus>
                </div>
                <button type="submit" class="btn btn-success  ml-3">Update</button>
            </div>
        </div>
    </form>
@endsection
