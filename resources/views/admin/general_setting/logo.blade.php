@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Edit Logo</h1>

    <form action="{{ url('admin/setting/general/logo/update') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="current_photo" value="{{ $general_setting->logo }}">

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="form-group">
                    <label for="">Existing Logo</label>
                    <div>
                        <img src="{{ asset('public/uploads/'.$general_setting->logo) }}" alt="" class="w_200">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Change Logo</label>
                    <div>
                        <input type="file" name="logo">
                    </div>
                </div>

                <div class="form-group d-flex align-items-center">
                    <label for="width">Width</label>
                    <input type="number" value="{{$general_setting->logo_width}}" name="logo_width" id="width" class="form-control form-control-sm mx-3" style="width: 120px;" min="1">
                </div>

                <div class="form-group d-flex align-items-center">
                    <label for="height">Height</label>
                    <input type="number" value="{{$general_setting->logo_height}}" name="logo_height" id="height" class="form-control form-control-sm mx-3" style="width: 120px;" min="1">
                </div>

                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </div>
    </form>

@endsection
