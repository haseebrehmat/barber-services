@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Edit Invoice</h1>

    <form action="{{ route('invoice-builder.update', ['invoice_builder' => $invoice->id]) }}" method="post">
        @csrf
        @method('PUT')
        <div class="card shadow mb-4">
            <div class="card-header py-2">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">Build Invoice</h6>
                <div class="float-right d-inline">
                    <button type="submit" class="btn btn-success btn-sm mx-2">Update</button>
                    <a href="{{ route('invoice-builder.index') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                        View All</a>
                </div>
            </div>
            <div class="card-body row">
                <div class="form-group col-md-6">
                    <label for="">Invoice Number *</label>
                    <input type="text" name="number" class="form-control" value="{{ $invoice->number }}" autofocus
                        required>
                </div>
                <div class="form-group col-md-6">
                    <label for="">Issue Date *</label>
                    <input type="date" name="issue_date" class="form-control" value="{{ $invoice->issue_date }}"
                        required>
                </div>
                <div class="form-group col-md-6">
                    <label for="">Tax</label>
                    <input type="number" max="100" step="0.01" name="tax" class="form-control"
                        value="{{ $invoice->tax }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="">Status *</label>
                    <select name="status" class="form-control select2" required>
                        <option value="draft" @if ($invoice->status == 'draft') selected @endif>Draft</option>
                        <option value="unpaid" @if ($invoice->status == 'unpaid') selected @endif>Unpaid</option>
                        <option value="paid" @if ($invoice->status == 'paid') selected @endif>Paid</option>
                    </select>
                </div>
            </div>
            <div class="card-header py-2">
                <h6 class="m-0 font-weight-bold text-primary">Client Information</h6>
            </div>
            <div class="card-body row">
                <div class="form-group col-md-6">
                    <label for="">Client Name *</label>
                    <input type="text" name="client_name" class="form-control" value="{{ $invoice->client_name }}"
                        required>
                </div>
                <div class="form-group col-md-6">
                    <label for="">Client Email *</label>
                    <input type="email" name="client_email" class="form-control" value="{{ $invoice->client_email }}"
                        required>
                </div>
            </div>
            <div class="card-header py-2">
                <h6 class="m-0 font-weight-bold text-primary">Address</h6>
            </div>
            <div class="card-body row">
                <div class="form-group col-md-3">
                    <label for="">Street</label>
                    <input type="text" name="street" class="form-control" value="{{ $invoice->street }}">
                </div>
                <div class="form-group col-md-3">
                    <label for="">City</label>
                    <input type="text" name="city" class="form-control" value="{{ $invoice->city }}">
                </div>
                <div class="form-group col-md-3">
                    <label for="">State</label>
                    <input type="text" name="state" class="form-control" value="{{ $invoice->state }}">
                </div>
                <div class="form-group col-md-3">
                    <label for="">Country</label>
                    <input type="text" name="country" class="form-control" value="{{ $invoice->country }}">
                </div>
            </div>
            <div class="card-header py-2">
                <h6 class="m-0 font-weight-bold text-primary">Items</h6>
                <div class="float-right d-inline">
                    <button onclick="addInputFields()" type="button" class="btn btn-primary btn-sm"><i
                            class="fa fa-plus"></i> Add Item</button>
                </div>
            </div>
            <div class="card-body" id="items-input-container">
                @foreach ($invoice->items as $key => $row)
                    <div class="form-group row px-2">
                        <input type="hidden" name="items[{{ $key }}][id]" value="{{ $row->id }}">
                        <input type="text" class="form-control col-md-4" name="items[{{ $key }}][description]"
                            placeholder="Enter Description" value="{{ $row->description }}"><br>
                        <input type="number" class="form-control col-md-3" name="items[{{ $key }}][qty]"
                            placeholder="Enter Quantity" value="{{ $row->qty }}"><br>
                        <input type="number" step="0.01" class="form-control col-md-3"
                            name="items[{{ $key }}][unit_price]" placeholder="Enter Unit Price"
                            value="{{ $row->unit_price }}">
                        <a href="{{ URL::to('admin/invoice-builder/item/delete/' . $row->id) }}"
                            class="btn btn-danger btn-sm col-md-2" onClick="return confirm('Are you sure?');"><i
                                class="fas fa-trash-alt"></i> Remove</a>
                        <br>
                    </div>
                @endforeach
            </div>
        </div>
    </form>

    <script>
        function addInputFields() {
            var container = document.getElementById("items-input-container");
            var inputHTML =
                '<div class="form-group row px-2"><input type="text" class="form-control col-md-4" name="items[' + container
                .childElementCount +
                '][description]" placeholder="Enter Description"><br><input type="number" class="form-control col-md-3" name="items[' +
                container.childElementCount +
                '][qty]" placeholder="Enter Quantity"><br><input type="number" class="form-control col-md-3" step="0.01" name="items[' +
                container.childElementCount +
                '][unit_price]" placeholder="Enter Unit Price"><button type="button" class="btn btn-danger btn-sm col-md-2" onclick="removeInputFields(this)"><i class="fas fa-trash-alt"></i> Remove</button><br></div>';
            container.insertAdjacentHTML('beforeend', inputHTML);
        }

        function removeInputFields(button) {
            var div = button.parentNode;
            div.parentNode.removeChild(div);
        }
    </script>
@endsection
