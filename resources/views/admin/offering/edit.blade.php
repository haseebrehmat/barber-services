@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Edit Service</h1>
    <form action="{{ route('admin.offering.update', ['offering' => $offering]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">Edit Service</h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin.offering.index') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                        View All</a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ $offering->name }}" autofocus>
                </div>
                <div class="form-group">
                    <label for="">Regular Rate *</label>
                    <input type="number" min="1" step="0.01" name="regular_rate" class="form-control"
                        value="{{ $offering->regular_rate }}">
                </div>
                <div class="form-group">
                    <label for="">Appointment Rate *</label>
                    <input type="number" min="1" step="0.01" name="appointed_rate" class="form-control"
                        value="{{ $offering->appointed_rate }}">
                </div>
                <div class="form-group">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox"name="is_active" id="rr1"
                            @if ($offering->is_active) checked @endif>
                        <label for="rr1" class="form-check-label font-weight-normal">Is Active *</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Details *</label>
                    <textarea name="details" class="form-control" cols="30" rows="10">{{ $offering->details }}</textarea>
                </div>
                <div class="form-group">
                    <label for="">Existing Featured Photo</label>
                    <div>
                        <img src="{{ asset('public/uploads/' . $offering->photo) }}" alt="" class="w_200">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Featured Photo *</label>
                    <div>
                        <input type="file" name="photo" accept="image/*">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </form>
@endsection
