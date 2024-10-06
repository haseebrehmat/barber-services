@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Landing Page Backgrounds</h1>

    <form action="{{ url('superadmin/landing_page_images') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="card shadow">
            <div class="card-body d-flex align-items-baseline">
                <div class="form-group d-flex flex-column">
                    <input type="file" name="file" accept="image/*">
                    <span>Max size: 5 MBs</span>
                </div>

                <button type="submit" class="btn btn-success">Upload</button>
            </div>
        </div>
    </form>

    <div class="card-body shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">View Uploaded Backgrounds</h6>
        </div>
        <div class="row">
            @foreach ($images as $row)
                <div class="col-md-3">
                    <div class="card m-3">
                        <div class="card-body text-center">
                            <img src="{{ asset('public/uploads/' . $row->file) }}" alt="{{ $row->file }}" class="w_200">
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    @endsection
