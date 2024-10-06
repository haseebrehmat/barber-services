@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Pricing Section</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">View Pricing Options</h6>
            <div class="float-right d-inline">
                <a href="{{ route('admin.pricing.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> Add New
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th>Price</th>
                            <th>Price format</th>
                            <th>Features</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->title }}</td>
                                <td>{{ $row->subtitle }}</td>
                                <td>{{ $row->currency }}{{ $row->price }}</td>
                                <td>
                                    <span class="badge badge-pill badge-success p-2">{{ $row->format }}</span>
                                </td>
                                <td>
                                    @forelse ($row->features as $key=> $item)
                                        <div class="d-flex align-items-center mb-2">
                                            @foreach ($row->tick_cross as $key1=> $item1)
                                                @if ($key==$key1)
                                                    @if ($item1=='tick')
                                                        <i class="fas fa-check-circle" style="font-size: 20px;color: green;"></i>
                                                    @endif
                                                    @if ($item1=='cross')
                                                        <i class="fas fa-times-circle" style="font-size: 20px;color: red;"></i>
                                                    @endif
                                                @endif
                                            @endforeach
                                            
                                            <span class="ml-1">{{ $item }}</span>
                                        </div>
                                    @empty
                                        <span>No feature found</span>
                                    @endforelse
                                </td>
                                <td>
                                    <a href="{{ route('admin.pricing.edit', ['pricing' => $row]) }}"
                                        class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>

                                    <form action="{{ route('admin.pricing.destroy', ['pricing' => $row]) }}" method="post"
                                        class="d-inline-flex">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onClick="return confirm('Are you sure?');"><i
                                                class="fas fa-trash-alt"></i></button>
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
