@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Add Product Variants</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 mt-2 font-weight-bold text-primary">Add Variants to Product: {{ $product->product_name }}
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.product.variants.save', ['product' => $product]) }}">
                        @csrf
                        <div class="form-group">
                            <label>Select Variant</label>
                            <select name="variant_id" class="form-control variant_select">
                                <option value=""></option>
                                @foreach ($variants as $row)
                                    <option value="{{ $row->id }}" @if ($row->id == $product->variant_id) selected @endif
                                        data-options="{{ isset($row->options) ? implode(',', $row->options) : '' }}">
                                        {{ $row->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <table class="table table-bordered mt-4" id="variant-options" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Variant Name</th>
                                    <th>Variant Unit Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($product->variant_options))
                                    @foreach ($product->variant_options as $variant_name => $variant_price)
                                        <tr>
                                            <td>{{ $variant_name }}</td>
                                            <td>
                                                <input type="number" name="variant_options[{{ $variant_name }}]"
                                                    class="form-control" value="{{ $variant_price }}" min="1">
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.variant_select').select2({
                placeholder: 'Please Choose Variant',
            });
        });

        $(document).ready(function() {
            $('.variant_select').on('change', function() {
                var selectedVariant = $(this).find(':selected');
                var value = selectedVariant.val();
                var options = selectedVariant.data('options');
                
                const variants = options.split(',');
                const variantOptionsTable = $('#variant-options tbody');
                variantOptionsTable.empty(); // Clear existing rows

                variants.forEach(function(variant) {
                    var newRow = $('<tr>');
                    newRow.html('<td>' + variant + '</td>' +
                        '<td><input type="number" name="variant_options[' + variant +
                        ']" class="form-control" value="0" min="1"></td>');
                    variantOptionsTable.append(newRow);
                });
            });
        });

    </script>
@endsection
