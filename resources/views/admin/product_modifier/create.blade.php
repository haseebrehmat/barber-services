@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Add a New Modifier</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 mt-2 font-weight-bold text-primary">New Modifier</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.modifier.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Modifier Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Modifier Name"
                                value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label>Modifier Unit Price</label>
                            <input type="number" step="0.1" name="unit_price" class="form-control"
                                placeholder="Modifier Unit Price" value="{{ old('unit_price') }}">
                        </div>
                        <div class="form-group">
                            <label>Modifier Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control" accept="image/png, image/jpg, image/jpeg">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('admin.modifier.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
