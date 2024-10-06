@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Recipients</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">View Recipients</h6>
            <div class="float-right d-inline">
                <a href="{{ route('admin.recipient.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add
                    New</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Recipient Name</th>
                            <th>Recipient Email</th>
                            <th>Recipient Tags</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->email }}</td>
                                <td>
                                    @forelse ($row->tags as $tag)
                                        <span class="badge badge-pill badge-success p-2">{{ $tag->name }}</span>
                                    @empty
                                        <span>-</span>
                                    @endforelse
                                </td>
                                <td>
                                    <a href="{{ route('admin.recipient.edit', ['recipient' => $row]) }}"
                                        class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.recipient.destroy', ['recipient' => $row]) }}"
                                        method="POST" class="d-inline-flex">
                                        @method('DELETE')
                                        @csrf
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="if(confirm('Are you sure?')){$(form).submit();}">
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
@endsection
