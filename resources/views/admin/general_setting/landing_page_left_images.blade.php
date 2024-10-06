@extends('admin.admin_layouts')
@section('admin_content')
    <style>
        .card-body {
            position: relative;
        }

        .badge {
            position: absolute;
            top: 0;
            right: 0;
            background-color: red;
            color: white;
            padding: 0.35rem;
            font-size: 1rem;
        }
    </style>

    <h1 class="h3 mb-3 text-gray-800">Landing Page Left Side Backgrounds</h1>

    <form action="{{ url('superadmin/landing_page_images') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="is_left" value="1">
        <div class="card shadow">
            <div class="card-body d-flex align-items-baseline">
                <div class="form-group d-flex flex-column">
                    <input type="file" name="file" accept="image/*">
                    <span>Max size: 5 MBs</span>
                </div>
                <button type="submit" class="btn btn-primary">Upload Left Image</button>
            </div>
        </div>
    </form>

    <div class="card-body shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">View Uploaded Left Side Images</h6>
        </div>
        <div class="row">
            @foreach ($images as $row)
                <div class="col-md-3">
                    <div class="card m-3">
                        <div class="card-body text-center">
                            <div class="badge">
                                <a href="{{ route('superadmin.landing_page_images.delete' , ['id' => $row->id]) }}"
                                    class="text-white" onClick="return confirm('Are you sure?');">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </div>
                            <img src="{{ asset('public/uploads/' . $row->file) }}" alt="{{ $row->file }}" class="w_300">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
