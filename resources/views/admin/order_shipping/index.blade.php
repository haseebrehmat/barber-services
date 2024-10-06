@extends('admin.admin_layouts')
@section('admin_content')
<h1 class="h3 mb-3 text-gray-800">Shippings Management</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 mt-2 font-weight-bold text-primary">View Order Shippings</h6>
        <div class="float-right d-inline">
            <a href="{{ route('order_shipping.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add
                New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Code</th>
                        <th>Shipper</th>
                        <th>Carrier</th>
                        <th>Order Date</th>
                        <th>Shipping Date</th>
                        <th>Delivery Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shippings as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->code }}</td>
                        <td>{{ $row->shipper }}</td>
                        <td>{{ $row->carrier }}</td>
                        <td>{{ $row->order_date }}</td>
                        <td>{{ $row->shipping_date }}</td>
                        <td>{{ $row->delivery_date }}</td>
                        <td class="d-flex">
                            <a href="{{ route('order_shipping.edit', $row->id) }}"
                                class="btn btn-warning btn-sm mx-1"><i class="fas fa-edit"></i></a>
                            <form action="{{route('order_shipping.destroy', $row)}}" method="post"
                                id="del-shipping-form-{{$row->id}}">
                                @csrf
                                @method('DELETE')
                                <a href="javascript:;" class="btn btn-danger btn-sm"
                                    onclick="if(confirm('Are you sure?')){$('#del-shipping-form-{{$row->id}}').submit()};">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </form>
                            @if ($row->pdf)
                            <a href="{{ asset('public/uploads/'.$row->pdf) }}" download class="btn btn-sm btn-success mx-1">
                                <i class="fas fa-arrow-alt-circle-down"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
