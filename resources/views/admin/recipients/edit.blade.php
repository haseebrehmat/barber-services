@extends('admin.admin_layouts')
@section('admin_content')
    @php
        $selected_tags = $data->tags->modelKeys();
    @endphp
    <h1 class="h3 mb-3 text-gray-800">Edit Recipient</h1>

    <form action="{{ route('admin.recipient.update', ['recipient' => $data]) }}" method="post">
        @csrf
        @method('PUT')
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">Edit Recipient</h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin.recipient.index') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                        View All</a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">Recipient Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ $data->name ?? old('name') }}"
                        autofocus>
                </div>
                <div class="form-group">
                    <label for="">Recipient Email *</label>
                    <input type="email" name="email" class="form-control" value="{{ $data->email ?? old('email') }}">
                </div>
                <div class="form-group">
                    <label for="">Recipient Description</label>
                    <select name="tag_ids[]" class="form-control select2" required multiple>
                        @foreach ($tags as $key => $value)
                            <option value="{{ $key }}" @if (in_array($key, $selected_tags)) selected @endif>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2({
            placeholder: 'Please select tags',
            multiple: true,
            allowClear: true,
            minimumResultsForSearch: 5
        });
    </script>
@endsection
