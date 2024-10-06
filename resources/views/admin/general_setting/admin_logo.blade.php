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

    <h1 class="h3 mb-3 text-gray-800">Admin Logo</h1>

    <form action="{{ url('superadmin/post_admin_logo') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow">
            <div class="card-body d-flex align-items-baseline">
                <div class="form-group d-flex flex-column">
                    <input type="file" name="file" accept="image/*">
                    <span>Max size: 5 MBs</span>
                </div>
                <button type="submit" class="btn btn-primary">Upload Admin Logo</button>
            </div>
        </div>
    </form>
    <br> <br><br>

    <h1 class="h3 mb-3 text-gray-800">Admin Logo Dynamic Size in Px</h1>

    <form action="{{ url('superadmin/post_admin_logo_size') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow">
            <div class="card-body d-flex align-items-baseline">
                <input value="{{$general_settings_global->admin_logo_width}}" class="form-control col-md-3" placeholder="Width" type="number" min="1"  name="admin_logo_width" id="">

                <input value="{{$general_settings_global->admin_logo_height}}" class="form-control col-md-3" placeholder="Height" type="number" min="1"  name="admin_logo_height" id="">
                <button type="submit" class="form control col-md-3 btn btn-primary">Update Logo Size</button>
            </div>
        </div>
    </form>
@endsection
