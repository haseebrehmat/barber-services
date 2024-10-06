@extends('admin.admin_layouts')
@section('admin_content')
    <style>
        .img-flag {
            display: inline-block;
            width: 150px;
            height: 100px;
            margin-right: 10px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .img-flag-selected {
            display: inline-block;
            width: 30px;
            height: 20px;
            margin-right: 10px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: transparent !important;
        }
    </style>
    <h1 class="h3 mb-3 text-gray-800">Add Product Modifiers</h1>

    <form action="{{ route('admin.product.modifiers.save', ['product' => $product]) }}" method="post">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">
                    Add Modifiers to Product: {{ $product->product_name }}
                </h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin.product.index') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> View
                        All</a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">Product Modifier</label>
                    <select class="form-control select2" name="modifier_ids[]" multiple="multiple">
                        <option value=""></option>
                        @foreach ($modifiers as $row)
                            <option value="{{ $row->id }}"
                                data-image="{{ isset($row->thumbnail) && file_exists(public_path('uploads/') . $row->thumbnail) ? asset('public/uploads/' . $row->thumbnail) : 'https://placehold.co/150x100?text= ' . str_replace(' ', '+', $row->name) . '' }}"
                                @if (in_array($row->id, $product->modifiers->pluck('id')->toArray())) selected @endif>
                                {{ $row->name }} (USD {{ $row->unit_price }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('admin.product.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2({
            placeholder: 'Please Select Product Modifiers',
            templateResult: function(data, container) {
                if (!data.id) {
                    return data.text;
                }
                var $element = $(`<span><img src="` + $(data.element).data('image') +
                    `" class="img-flag" /> ` + data.text + `</span>`);
                return $element;
            },
            templateSelection: function(data, container) {
                if (!data.id) {
                    return data.text;
                }
                var $element = $(`<span><img src="` + $(data.element).data('image') +
                    `" class="img-flag-selected" /> ` + data.text + `</span>`);
                return $element;
            }
        });
    </script>
@endsection
