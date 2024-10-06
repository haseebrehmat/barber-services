@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Video Conferences</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">Video Conferences</h6>
            <div class="float-right d-inline">
                <a href="{{ route('admin.video_conference_create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add New</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Link</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $row)
                        
                        <tr>
                            <td>{{ $row->title }}</td>
                            <td><a target="_blank" href="{{ URL::to('admin/video/conference/start/'.$row->id) }}">{{ $row->link }}</a></td>
                            <td>
                                    <a target="_blank" href="{{ URL::to('admin/video/conference/start/'.$row->id) }}" class="btn btn-success btn-sm"><i class="fas fa-video"></i></a>
                                    <a href="{{ URL::to('admin/video/conference/delete/'.$row->id) }}" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
