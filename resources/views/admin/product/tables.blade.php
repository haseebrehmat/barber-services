@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Tables</h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 mt-2 font-weight-bold text-primary">View Tables</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Table Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tables as $table)
                                    <tr>
                                        <td>{{ $table->name }}</td>
                                        <td><a href="{{ URL::to('admin/table/delete/'.$table->id) }}" class="btn btn-danger btn-sm"
                                            onClick="return confirm('Are you sure?');"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <form action="{{ route('admin.table.store') }}" method="post">
                @csrf
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 mt-2 font-weight-bold text-primary">New Table</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Table Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
           
        </div>
    </div>

    <script>
        $('.edit-btn').click(function() {
            $('#edit-status-form').attr('action', $(this).data('route'));
            $('#edit-status-form input[name="title"]').val($(this).data('title'));
            $('#edit-status-form input[name="hex"]').val($(this).data('hex'));
            $('#edit-status-form').show();
        });
    </script>
@endsection
