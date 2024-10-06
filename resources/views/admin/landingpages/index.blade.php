@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Landing Pages</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            {{-- <h6 class="m-0 mt-2 font-weight-bold text-primary">View Landing Pages</h6> --}}
            <div class="float-right d-inline">
                <a href="{{ route('landingpages.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Landing Page</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Landing Page Name</th>
                        <th>Leads for SMS Marketing</th>
                        <th>Leads for Email Marketing</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->lpc_name }}</td>
                            <td>
                                @php
                                    $count=DB::table('landing_page_contacts')->where('landing_page_id',$row->id)->count();

                                @endphp
                                <a  href="{{ route('admin.landing_page_messages_by_page', ['id' => $row->id]) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-sms"></i> {{$count}}
                                </a>
                            </td>
                            <td>
                                <a  href="{{ route('admin.landing_page_emails_by_page', ['id' => $row->id]) }}" class="btn btn-primary btn-sm">
                                    <i class="far fa-envelope"></i> {{$count}}
                                </a>
                            </td>
                            <td>
                                <a href="{{ URL::to('landingpages_edit/'.$row->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <a target="_blank" href="{{ route('landingpages.view', ['id' => $row->lpc_name]) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-arrow-alt-circle-right"></i> View Landing Page
                                </a>
                                <a href="{{ URL::to('landingpages_delete/'.$row->id) }}" class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
