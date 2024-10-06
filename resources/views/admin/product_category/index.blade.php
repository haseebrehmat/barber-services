@extends('admin.admin_layouts')
@section('admin_content')
<h1 class="h3 mb-3 text-gray-800">Product Categories</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 mt-2 font-weight-bold text-primary">View Product Categories</h6>
        <div class="float-right d-inline">
            <a href="javascript:;" data-toggle="modal" data-target="#product-category-modal"
                class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productCategory as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->description }}</td>
                        <td>
                            <a href="{{ URL::to('admin/product_category/'.$row->id.'/edit') }}"
                                class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.product_category.destroy', ['product_category' => $row]) }}"
                                method="post" class="d-inline-flex" id="del-product-category-form-{{$row->id}}">
                                @csrf
                                @method('DELETE')
                                <a href="javascript:;" class="btn btn-danger btn-sm"
                                    onClick="deleteProductCategory({{$row->id}})">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('admin.product_category.create')
<script>
    deleteProductCategory = id => {
        if(confirm('Are you sure?')) {
            $(`#del-product-category-form-${id}`).submit();
        }
    }
</script>
@endsection
