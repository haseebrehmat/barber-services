@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Edit Tag</h1>

    <form action="{{ route('admin.tag.update', ['tag' => $data]) }}" method="post">
        @csrf
        @method('PUT')
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">Edit Tag</h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin.tag.index') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                        View All</a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">Tag Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ $data['name'] ?? old('name') }}"
                        autofocus>
                </div>
                <div class="form-group">
                    <label for="">Tag Description</label>
                    <textarea name="description" class="form-control h_100" cols="30" rows="10">{{ $data['description'] ?? old('description') }}</textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>
@endsection
