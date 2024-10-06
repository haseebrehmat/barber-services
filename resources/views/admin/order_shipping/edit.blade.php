@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Add Order Shipping</h1>

    <form action="{{ route('order_shipping.update', $shipping) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">Add Order Shipping</h6>
                <div class="float-right d-inline">
                    <a href="{{ route('order_shipping.index') }}" class="btn btn-primary btn-sm">Back to All</a>
                </div>
            </div>
            <div class="card-body row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Code *</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code') ?? $shipping->code }}" autofocus required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Carrier</label>
                        <input type="text" name="carrier" class="form-control" value="{{ old('carrier') ?? $shipping->carrier }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Shipper</label>
                        <input type="text" name="shipper" class="form-control" value="{{ old('shipper') ?? $shipping->shipper }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Order Date</label>
                        <input type="date" name="order_date" class="form-control" value="{{ old('order_date') ?? $shipping->order_date }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Shipping Date</label>
                        <input type="date" name="shipping_date" class="form-control" value="{{ old('shipping_date') ?? $shipping->shipping_date }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Delivery Date</label>
                        <input type="date" name="delivery_date" class="form-control" value="{{ old('delivery_date') ?? $shipping->delivery_date }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Details (Upload Pdf)</label>
                        <div>
                            <input type="file" name="pdf" accept=".pdf">
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </div>
        </div>
    </form>

@endsection
