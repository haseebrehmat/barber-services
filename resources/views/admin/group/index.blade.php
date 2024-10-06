@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Added Groups</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">View Added Groups</h6>
            <div class="float-right d-inline">
                <a class="btn btn-outline-primary rounded-pill px-4" data-toggle="modal" href="#create_group" role="button">
                    Add New Group <i class="fa fa-plus pl-2"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Group Name</th>
                            <th>Total Group Contacts</th>
                            <th>Details</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groups as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->name }}</td>
                                <td>
                                    <span
                                        class="px-2 py-1 bg-success text-white rounded-sm">{{ $row->contacts_count }}</span>
                                </td>
                                <td>{{ isset($row->detail) ? $row->detail : 'No Details' }}</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-outline-success rounded-pill edit-group-btn mr-2"
                                            data-url="{{ route('admin.group.update', ['group' => $row]) }}"
                                            data-name="{{ $row->name }}" data-detail="{{ $row->detail }}">
                                            Edit <i class="fas fa-pencil-alt pl-1"></i>
                                        </button>
                                        <form action="{{ route('admin.group.destroy', ['group' => $row]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger rounded-pill" type="button"
                                                onclick="if(confirm('Are you sure') == true){$(form).submit()}">
                                                Delete <i class="far fa-trash-alt pl-1"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @includeIf('admin.group.create')
    @includeIf('admin.group.edit')
@endsection
