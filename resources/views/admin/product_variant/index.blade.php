@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Variants</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">View Variants</h6>
            <div class="float-right d-inline">
                <a href="{{ route('admin.variant.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
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
                            <th>Variant Name</th>
                            <th>Variant Options</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucwords($row->name) }}</td>
                                <td>
                                    @forelse ($row->options as $item)
                                        <span class="btn btn-sm btn-success rounded-pill py-0">{{ $item }}</span>
                                    @empty
                                        <span class="text-muted">No Option Added</span>
                                    @endforelse
                                </td>
                                <td>
                                    <a href="{{ route('admin.variant.edit', ['variant' => $row]) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.variant.destroy', ['variant' => $row]) }}"
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
