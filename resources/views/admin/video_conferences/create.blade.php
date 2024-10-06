@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Add Conference</h1>

    <form action="{{ route('admin.video_conference_store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 mt-2 font-weight-bold text-primary">Add Conference</h6>
                        <div class="float-right d-inline">
                            <a href="{{ route('admin.video_conference.index') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> View All</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Title *</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" autofocus required>
                        </div>
                    </div>
                    <div class="card-body">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
