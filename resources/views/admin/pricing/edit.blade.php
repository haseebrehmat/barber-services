@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Edit Pricing</h1>

    <form action="{{ route('admin.pricing.update', ['pricing' => $pricing]) }}" method="post">
        @csrf
        @method('PUT')
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">Edit Pricing</h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin.pricing.index') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                        View All</a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ $pricing->title }}" autofocus>
                </div>
                <div class="form-group">
                    <label for="">Subtitle *</label>
                    <input type="text" name="subtitle" class="form-control" value="{{ $pricing->subtitle }}">
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="">Currency *</label>
                        <input type="text" name="currency" class="form-control" value="{{ $pricing->currency ?? '$' }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Price *</label>
                        <input type="number" name="price" class="form-control" value="{{ $pricing->price }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Price format *</label>
                        <select name="format" class="form-control">
                            <option value="monthly" @if ($pricing->format == 'monthly') selected @endif>Monthly</option>
                            <option value="yearly" @if ($pricing->format == 'yearly') selected @endif>Yearly</option>
                            <option value="weekly" @if ($pricing->format == 'weekly') selected @endif>Weekly</option>
                            <option value="hourly" @if ($pricing->format == 'hourly') selected @endif>Hourly</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-group">
                        <button type="button" id="add-field" class="btn btn-info mb-2">Add Feature</button>
                        <div id="input-fields">
                            @foreach ($pricing->features as $key=> $row)
                                <div class="input-field d-flex my-1">
                                    @foreach ($pricing->tick_cross as $key1=> $row1)
                                        @if ($key==$key1)
                                            <select class="form-control" name="tick_cross[]">
                                                <option value="tick" @if ($row1 == 'tick') selected @endif> &#10004; Tick </option>
                                                <option value="cross" @if ($row1 == 'cross') selected @endif >&#10060; Cross</option>
                                            </select>
                                        @endif
                                    @endforeach
                                    <input type="text" name="features[]" placeholder="Enter features"
                                        class="form-control" value="{{ $row }}">
                                    <button type="button" class="remove-field btn btn-danger mx-2">Remove</button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <button type="submit" class="btn btn-success">Update</button>
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
