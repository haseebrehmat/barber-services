@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Edit Default Homepage</h1>

    <form action="{{ url('admin/setting/general/default_homepage/update') }}" method="post">
        @csrf

        <div class="card shadow mb-4">
            <div class="card-body">
                <label for="default_homepage">Default Homepage</label>

                <select name="default_homepage" id="default_homepage" class="form-control mb-4 w-100">
                    <option value="website" @if ($general_setting->default_homepage == 'website') selected @endif>Website</option>
                    <option value="ecommerce" @if ($general_setting->default_homepage == 'ecommerce') selected @endif>Ecommerce</option>
                </select>

                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </div>
    </form>
@endsection
