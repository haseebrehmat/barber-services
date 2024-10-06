@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Tasks related {{ $project->project_name }}</h1>
    <form action="{{ route('admin.project.task-store') }}" method="post">
        @csrf

        <input type="hidden" name="project_id" value="{{ $project->id }}">

        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">Add Project Task</h6>
                <div class="float-right d-inline">
                    <button type="button" class="btn btn-primary btn-sm" id="openCalendarModal"><i class="fa fa-calendar"></i> See Calendar</button>
                    <a href="{{ route('admin.project.index') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Back to Projects</a>
                </div>
            </div>
            
            
            <div class="card-body">
                <div class="form-group">
                    <label for="">Task Detail</label>
                    <textarea name="detail" rows="3" class="form-control">{{ old('detail') }}</textarea>
                </div>
                <div class="row align-items-center">
                    <div class="form-group col-md-3">
                        <label for="">Date & Time</label>
                        <input type="datetime-local" name="date" class="form-control" value="{{ old('date') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Status</label>
                        <select name="status" class="form-control">
                            <option class="text-primary" value="pending" @if (old('status') == 'pending') selected @endif>
                                Pending</option>
                            <option class="text-danger" value="canceled" @if (old('status') == 'canceled') selected @endif>
                                Canceled</option>
                            <option class="text-success" value="completed"
                                @if (old('status') == 'completed') selected @endif>
                                Completed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success col-md-1">Add</button>
                </div>
            </div>
        </div>
    </form>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Detail</th>
                            <th>Date & Time</th>
                            <th>Added By</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $row->detail }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($row->date)->format('d M Y H:i') }}</td>
                                <td>
                                    {{ isset($row->created_by) ? $row->created_by : 'N/A' }}
                                </td>
                                <td>
                                    <form action="{{ route('admin.project.task.status.update', ['projectTask' => $row]) }}"
                                        method="post">
                                        @csrf
                                        @method('PUT')
                                        <select name="status"
                                            class="btn btn-sm p-0 ml-2 @if ($row->status == 'pending') text-primary border-primary @elseif($row->status == 'canceled') text-danger border-danger @else text-success border-success @endif"
                                            onchange="if(confirm('Are you sure to change status') == true){$(form).submit()}">
                                            <option class="text-primary" value="pending"
                                                @if ($row->status == 'pending') selected @endif>
                                                Pending</option>
                                            <option class="text-danger" value="canceled"
                                                @if ($row->status == 'canceled') selected @endif>
                                                Canceled</option>
                                            <option class="text-success" value="completed"
                                                @if ($row->status == 'completed') selected @endif>
                                                Completed</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('admin.project.task-delete', ['projectTask' => $row]) }}"
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
    <!-- Modal -->
    <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="calendarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="calendarModalLabel">Project Calendar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @includeIf('admin.project.tasks_calendar')
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#openCalendarModal').on('click', function () {
                $('#calendarModal').modal('show');
            });
        });
    </script>
    
@endsection
