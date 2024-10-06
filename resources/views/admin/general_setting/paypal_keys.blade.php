@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Edit Paypal Keys</h1>

    <form action="{{ url('admin/setting/general/paypal_keys/update') }}" method="post">
        @csrf

        <div class="card shadow mb-4">
            <div class="card-body">

                <div class="form-group d-flex align-items-center">
                    <label for="env_type" class="w-25">PAYPAL ENV TYPE</label>
                    <select name="env_type" id="env_type" class="form-control form-control-sm mr-3">
                        <option value="">Select paypal environment type</option>
                        <option value="production" @if(env('PAYPAL_ENV_TYPE') == 'production') selected @endif>Production</option>
                        <option value="sandbox" @if(env('PAYPAL_ENV_TYPE') == 'sandbox') selected @endif>Sandbox</option>
                    </select>
                </div>

                <div class="form-group d-flex align-items-center">
                    <label for="width" class="w-25">PAYPAL CLIENT ID</label>
                    <input type="text" value="{{ env('PAYPAL_CLIENT_ID') }}" name="client_id" id="width"
                        class="form-control form-control-sm mr-3">
                </div>

                <div class="form-group d-flex align-items-center">
                    <label for="height" class="w-25">PAYPAL SECRET KEY</label>
                    <input type="text" value="{{ env('PAYPAL_SECRET_KEY') }}" name="secret_key" id="height"
                        class="form-control form-control-sm mr-3">
                </div>

                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
    </form>
@endsection
