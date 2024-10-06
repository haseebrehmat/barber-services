@extends('admin.admin_layouts')
@section('admin_content')
<h1 class="h3 mb-3 text-gray-800">Edit/Show Product Category</h1>

<form action="{{ route('admin.product_category.update', ['product_category' => $productCategory]) }}" method="post">
    @csrf
    @method('PATCH')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">Edit Product</h6>
            <div class="float-right d-inline">
                <a href="{{ route('admin.product_category.index') }}" class="btn btn-info btn-sm"><i
                        class="fa fa-chevron-left"></i>
                    View All</a>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="">Name *</label>
                <input type="text" name="name" class="form-control" value="{{ $productCategory->name }}"
                    autofocus required>
            </div>
            <div class="form-group">
                <label for="">Description</label>
                <textarea name="description" rows="4"
                    class="form-control">{{ $productCategory->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-success float-right">Update</button>
        </div>
    </div>
</form>

@if (count($productCategory->products) > 0)
<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Products of {{ $productCategory->name }}</h6>
    </div>
    <div class="card-body">
        @include('admin.product.table', ['product' => $productCategory->products])
    </div>
</div>
@endif

@endsection
