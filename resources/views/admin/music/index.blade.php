@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Music Items</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">View Music Items</h6>
            <div class="float-right d-inline">
                <a href="{{ route('admin.music.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add New</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Upload Type</th>
                        <th>Photo</th>
                        <th>title</th>
                        <th >Link/Sound</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($music as $row)
                        @if ($row->upload_type=='embed')
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>Embed</td>
                                <td>-</td>
                                <td>-</td>
                                <td class="copy-link" data-link="{{ $row->link }}" style="font-weight: bold; color: blue;">Click to Copy</td>

                                <td>
                                    {{-- <a href="{{ URL::to('admin/music/edit/'.$row->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> --}}
                                    <a href="{{ URL::to('admin/music/delete/'.$row->id) }}" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        @endif

                        @if ($row->upload_type=='upload')
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>Upload</td>
                                <td><img src="{{ asset('public/uploads/'.$row->image) }}" alt="" class="w_100"></td>
                                <td>{{ $row->title }}</td>
                                <td>
                                    <audio controls>
                                        <source src="{{ asset('public/uploads/' . $row->sound) }}"
                                            type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </td>
                                <td>
                                    {{-- <a href="{{ URL::to('admin/music/edit/'.$row->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a> --}}
                                    <a href="{{ URL::to('admin/music/delete/'.$row->id) }}" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        @endif


                        
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const copyLinkCells = document.querySelectorAll('.copy-link');
    
            copyLinkCells.forEach(function (cell) {
                cell.addEventListener('click', function () {
                    const linkToCopy = this.getAttribute('data-link');
    
                    const tempInput = document.createElement('input');
                    tempInput.value = linkToCopy;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);
    
                    alert('Link copied to clipboard');
                });
            });
        });
    </script>
    
@endsection
