@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Edit a New Variant</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 mt-2 font-weight-bold text-primary">Update Variant</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.variant.update', ['variant' => $variant]) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Variant Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Variant Name"
                                value="{{ $variant->name }}">
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <label>Variant Options</label>
                            <button type="button" class="btn btn-success add-input mb-2">Add More</button>
                        </div>
                        <div class="repeatable-inputs">
                            @if ($variant->options)
                                @foreach ($variant->options as $opt_value)
                                    <div class="input-group mb-3">
                                        <input type="text" name="options[]" class="form-control"
                                            placeholder="Enter option value" value="{{ $opt_value }}">
                                        <div class="input-group-append">
                                            <button type="button"
                                                class="btn btn-danger btn-sm remove-input">Remove</button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-3">
                                    <input type="text" name="options[]" class="form-control"
                                        placeholder="Enter option value">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-danger btn-sm remove-input">Remove</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.variant.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Add more input fields
            $('.add-input').on('click', function() {
                var inputGroup = $('.repeatable-inputs .input-group:first').clone();
                inputGroup.find('input').val('');
                // inputGroup.find('.remove-input').remove();
                $('.repeatable-inputs').append(inputGroup);
            });

            // Remove input field
            $(document).on('click', '.remove-input', function() {
                let totalInputs = $('.repeatable-inputs').children().length;
                if (totalInputs <= 1) {
                    toastr.error('You have to add at least one option.')
                } else {
                    $(this).closest('.input-group').remove();
                }
            });
        });
    </script>
@endsection
