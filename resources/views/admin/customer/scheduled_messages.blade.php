<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 mt-2 font-weight-bold text-primary">Scheduled Messages</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered" id="customers-table" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Message</th>
                    <th>Scheduled At</th>
                    <th>Module</th>
                    <th>Status</th>
                    <th>Message Type</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->msg }}</td>
                        <td>{{ $row->scheduled_at->format('M d, Y H:i A') }}</td>
                        <td>{{ $row->module }}</td>
                        <td>{{ $row->status }}</td>
                        <td>{{ $row->type }}</td>
                        <td>{{ $row->created_at->format('M d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
