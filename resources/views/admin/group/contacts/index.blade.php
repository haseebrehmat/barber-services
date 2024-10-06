@extends('admin.admin_layouts')
@section('admin_content')
    <style>
        .nav-pills .nav-link {
            color: gray !important;
        }

        .nav-pills .nav-link.active {
            background-color: #1cc88a !important;
        }
    </style>
    <h1 class="h3 mb-3 text-gray-800">Assign Leads to Added Groups (Custom)</h1>
    <div class="card">
        <div class="card-body">
            @if (sizeOf($groups) > 0)
                <div class="row">
                    @includeIf('admin.group.contacts.tabs')
                    <div class="col-9">
                        <div class="tab-content" id="myTabContent">
                            @includeIf('admin.group.contacts.import', ['group_id' => $active_group_id])
                            <div class="table-responsive mt-2">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($contacts as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ isset($item->phone) ? $item->phone : 'N/A' }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <button
                                                            class="btn btn-sm text-success py-0 edit-contact-btn"
                                                            data-url="{{ route('admin.group.contacts.update', ['contact' => $item]) }}"
                                                            data-name="{{ $item->name }}"
                                                            data-email="{{ $item->email }}"
                                                            data-phone="{{ $item->phone }}">
                                                            <i class="fas fa-pencil-alt"></i> Edit
                                                        </button>
                                                        <form
                                                            action="{{ route('admin.group.contacts.destroy', ['contact' => $item]) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm text-danger py-0"
                                                                type="button"
                                                                onclick="if(confirm('Are you sure') == true){$(form).submit()}">
                                                                <i class="far fa-trash-alt"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    No contact found in group
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $contacts->appends(request()->all())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <h4 class="text-center">No Custom Groups added yet</h4>
            @endif
        </div>
    </div>

    @includeIf('admin.group.contacts.edit')
    @includeIf('admin.group.contacts.create')
@endsection
