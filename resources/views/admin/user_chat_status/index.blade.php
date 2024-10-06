@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">User Chat Status</h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 mt-2 font-weight-bold text-primary">View User Chat Status</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Status Title</th>
                                    <th>Status Hex</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->title }}</td>
                                        <td>
                                            <div class="btn p-3 rounded-circle"
                                                style="background-color: #{{ $row->hex }}"></div>
                                            #{{ $row->hex }}
                                        </td>
                                        <td class="d-flex">
                                            <button data-route="{{ route('admin.user_chat_status.update', ['user_chat_status' => $row]) }}"
                                                data-title="{{ $row->title }}" data-hex="{{ $row->hex }}"
                                                class="btn btn-warning btn-sm mr-2 edit-btn"><i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.user_chat_status.destroy', ['user_chat_status' => $row]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm"
                                                    onClick="return confirm('Are you sure?');">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <form action="{{ route('admin.user_chat_status.store') }}" method="post">
                @csrf
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 mt-2 font-weight-bold text-primary">New Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label for="">Color Hex</label>
                            <input type="text" name="hex" class="form-control jscolor"
                                value="{{ old('hex') ? old('hex') : '000000' }}">
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
            <form action="" method="post" id="edit-status-form" style="display: none;">
                @csrf
                @method('PUT')
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 mt-2 font-weight-bold text-primary">Edit Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" name="title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Color Hex</label>
                            <input type="text" name="hex" class="form-control jscolor">
                        </div>
                        <button type="submit" class="btn btn-success">Update</button>
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
