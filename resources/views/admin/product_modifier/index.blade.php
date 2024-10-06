@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Modifiers</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">View Modifiers</h6>
            <div class="float-right d-inline">
                <a href="{{ route('admin.modifier.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                    Add New
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Modifier Thumbnail</th>
                            <th>Modifier Name</th>
                            <th>Modifier Unit Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if (isset($row->thumbnail) && file_exists(public_path('uploads/') . $row->thumbnail))
                                        <img src="{{ asset('public/uploads/' . $row->thumbnail) }}" alt=""
                                            class="w_150">
                                    @else
                                        <img src="https://placehold.co/150x100?text={{ isset($row->name) ? str_replace(' ', '+', $row->name) : 'Modifier+Thumbnail' }}"
                                            alt="Modifier">
                                    @endif
                                </td>
                                <td>{{ ucwords($row->name) }}</td>
                                <td>{{ $row->unit_price }}</td>
                                <td>
                                    <a href="{{ route('admin.modifier.edit', ['modifier' => $row]) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.modifier.destroy', ['modifier' => $row]) }}"
                                        class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
