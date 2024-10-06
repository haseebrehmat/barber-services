@extends('admin.admin_layouts')
@section('admin_content')
<h1 class="h3 mb-3 text-gray-800">Sliders</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 mt-2 font-weight-bold text-primary">View Sliders</h6>
        <div class="float-right d-inline">
            @if ($is_store)
                <a href="{{ route('admin.slider.create', ['store' => 1]) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> Add New
                </a>

            @else
                <a href="{{ route('admin.slider.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add
                New</a>
            @endif

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Slider Type</th>
                        <th>Slider Value</th>
                        <th>Slider Heading</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=0; @endphp
                    @foreach($slider as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ ucwords($row->slider_type) }}</td>
                        <td>
                            @switch($row->slider_type)
                                @case('photo')
                                    <img src="{{ asset('public/uploads/'.$row->slider_photo) }}" alt="" class="w_150">
                                    @break
                                @case('mp4')
                                    <video width="320" height="240" controls>
                                        <source src="{{ asset('public/uploads/'.$row->slider_mp4) }}" type="video/mp4">
                                    </video>
                                    @break
                                @case('video')
                                    <a href="{{$row->slider_video}}" target="_blank" rel="noopener noreferrer">Video URL...</a>
                                    @break
                                @default
                                    <input type="text" name="" value="{{$row->slider_color}}" class="form-control w-50 jscolor" readonly>
                            @endswitch
                        </td>
                        <td>{!! $row->slider_heading !!}</td>
                        <td>
                            @if ($is_store)
                            <a href="{{ URL::to('admin/slider/edit/'.$row->id) }}?store=1" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>

                            @else
                            <a href="{{ URL::to('admin/slider/edit/'.$row->id) }}" class="btn btn-warning btn-sm"><i
                                class="fas fa-edit"></i></a>
                            @endif

                            <a href="{{ URL::to('admin/slider/delete/'.$row->id) }}" class="btn btn-danger btn-sm"
                                onClick="return confirm('Are you sure?');"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
