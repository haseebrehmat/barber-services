@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Add Pricing</h1>

    <form action="{{ route('admin.pricing.store') }}" method="post">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">Add Pricing</h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin.pricing.index') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                        View All</a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" autofocus>
                </div>
                <div class="form-group">
                    <label for="">Subtitle *</label>
                    <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle') }}">
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="">Currency *</label>
                        <input type="text" name="currency" class="form-control" value="{{ old('currency') ?? '$'}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Price *</label>
                        <input type="number" name="price" class="form-control" value="{{ old('price') }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Price format *</label>
                        <select name="format" class="form-control">
                            <option value="monthly" @if (old('format') == 'monthly') selected @endif>Monthly</option>
                            <option value="yearly" @if (old('format') == 'yearly') selected @endif>Yearly</option>
                            <option value="weekly" @if (old('format') == 'weekly') selected @endif>Weekly</option>
                            <option value="hourly" @if (old('format') == 'hourly') selected @endif>Hourly</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" id="add-field" class="btn btn-info mb-2">Add Feature</button>
                    <div id="input-fields">
                        <div class="input-field d-flex">
                            <select class="form-control" name="tick_cross[]">
                                <option value="tick" selected>&#10004; Tick</option>
                                <option value="cross">&#10060; Cross</option>
                            </select>
                            <input type="text" name="features[]" placeholder="Enter features" class="form-control">
                            <button type="button" class="remove-field btn btn-danger mx-2">Remove</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            // Add new input field
            $('#add-field').on('click', function() {
                $('#input-fields').append(`
                    <div class="input-field d-flex my-1">
                        <select class="form-control" name="tick_cross[]">
                            <option value="tick" selected>&#10004; Tick</option>
                            <option value="cross">&#10060; Cross</option>
                        </select>
                        <input type="text" name="features[]" placeholder="Enter data" class="form-control">
                        <button type="button" class="remove-field btn btn-danger mx-2">Remove</button>
                    </div>
                `);
            });

            // Remove input field
            $('#input-fields').on('click', '.remove-field', function() {
                $(this).parent('.input-field').remove();
            });

            // Submit form (you can customize this part)
            $('#repeater-form').on('submit', function(event) {
                event.preventDefault();
                const formData = $(this).serialize();
                console.log(formData); // Handle form data submission
            });
        });
    </script>
@endsection
