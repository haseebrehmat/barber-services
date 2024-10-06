@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Edit a New Modifier</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 mt-2 font-weight-bold text-primary">Update Modifier</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.modifier.update', ['modifier' => $modifier]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Modifier Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Modifier Name"
                                value="{{ $modifier->name }}">
                        </div>
                        <div class="form-group">
                            <label>Modifier Unit Price</label>
                            <input type="number" step="0.1" name="unit_price" class="form-control"
                                placeholder="Modifier Unit Price" value="{{ $modifier->unit_price }}">
                        </div>
                        <div class="form-group">
                            <label>Modifier Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control" accept="image/png, image/jpg, image/jpeg">
                            <div class="d-flex align-items-baseline justify-content-end pt-4">
                                <p class="px-2">Previously Uploaded Thumbnail</p>
                                @if (isset($modifier->thumbnail))
                                    <img src="{{ asset('public/uploads/' . $modifier->thumbnail) }}" alt=""
                                        class="w_150">
                                @else
                                    <img src="https://placehold.co/150x100?text={{ isset($modifier->name) ? str_replace(' ', '+', $modifier->name) : 'Modifier+Thumbnail' }}"
                                        alt="Modifier">
                                @endif
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.modifier.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
