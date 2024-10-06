@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Edit Stripe Keys</h1>

    <form action="{{ url('admin/setting/general/stripe_keys/update') }}" method="post">
        @csrf

        <div class="card shadow mb-4">
            <div class="card-body">

                <div class="form-group d-flex align-items-center">
                    <label for="width" class="w-25">STRIPE PUBLIC KEY</label>
                    <input type="text" value="{{ env('ADMIN_STRIPE_PUBLIC_KEY') }}" name="public_key" id="width"
                        class="form-control form-control-sm mr-3">
                </div>

                <div class="form-group d-flex align-items-center">
                    <label for="height" class="w-25">STRIPE SECRET KEY</label>
                    <input type="text" value="{{ env('ADMIN_STRIPE_SECRET_KEY') }}" name="secret_key" id="height"
                        class="form-control form-control-sm mr-3">
                </div>

                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
    </form>
@endsection
