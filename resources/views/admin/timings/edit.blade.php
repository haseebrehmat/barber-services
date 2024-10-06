@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Edit Store Timings / Status Colors</h1>

    <form action="{{ route('admin.timings.update') }}" method="post">
        @csrf
        @method('PUT')
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">Edit Shop Timings</h6>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-12 row">
                        <div class="col-md-2">Day</div>
                        <div class="col-md-3">Open Time</div>
                        <div class="col-md-3">Close Time</div>
                        <div class="col-md-4">Off Day</div>
                    </div>
                    <hr>
                    @foreach ($timings as $day => $timing)
                        <div class="col-md-12 row my-2">
                            <label class="col-md-2">{{ $day }}:</label>
                            <input type="time" class="form-control form-control-sm col-md-3"
                                name="timings[{{ $day }}][open_time]" value="{{ $timing['open_time'] }}">
                            <input type="time" class="form-control form-control-sm col-md-3"
                                name="timings[{{ $day }}][close_time]" value="{{ $timing['close_time'] }}">
                            <div class="form-check col-md-4 px-3">
                                <input type="checkbox" name="timings[{{ $day }}][off_day]"
                                    {{ $timing['off_day'] ? 'checked' : '' }} class="col-md-2 form-check-input">
                            </div>
                        </div>
                    @endforeach
                    <div class="col-md-12">
                        <button class="btn btn-success" type="submit">Save Timings</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form action="{{ route('admin.shop_status_color.update') }}" method="post">
        @csrf
        @method('PUT')
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">Edit Store Open/Closed Status Colors</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="">Open Status Color</label>
                        <input type="color" name="shop_open_status_color" class="form-control"
                            value="{{ $general_settings_global->shop_open_status_color }}">
                    </div>
                    <div class="col-md-4">
                        <label for="">Close Status Color</label>
                        <input type="color" name="shop_close_status_color" class="form-control mb-3"
                            value="{{ $general_settings_global->shop_close_status_color }}">
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-info" type="submit">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
