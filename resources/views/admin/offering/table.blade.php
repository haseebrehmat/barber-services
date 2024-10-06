<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>SL</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Regular Rate</th>
            <th>Appointed Rate</th>
            <th>Details</th>
            <th>Is Active</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($offerings as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><img src="{{ asset('public/uploads/' . $row->photo) }}" alt="" class="w_150">
                </td>
                <td>{{ $row->name }}</td>
                <td>${{ $row->regular_rate }}</td>
                <td>${{ $row->appointed_rate }}</td>
                <td>{!! Str::limit($row->details, 50, '...') !!}</td>
                <td>{{ $row->is_active ? 'Show' : 'Hide' }}</td>
                <td>
                    <a href="{{ route('admin.offering.edit', ['offering' => $row]) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="{{ route('admin.offering.destroy', ['offering' => $row]) }}" class="btn btn-danger btn-sm"
                        onClick="return confirm('Are you sure?');">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
