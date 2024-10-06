@extends('admin.admin_layouts')
@section('admin_content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">Reports</h6>
            <div class="float-right d-inline">
                <a href="{{ route('admin.email_template.gallery') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                    <i class="fa fa-arrow-left mr-2"></i> Back To Gallery</a>
            </div>
        </div>
        <div class="card-body">
            @forelse ($reports as $row)
                <div class="row my-4">
                    <div class="col-md-12 text-center mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">{{ isset($row->module) ? $row->module : 'No Module' }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Total Sent</h5>
                                        <h3 class="card-text text-primary">
                                            {{ isset($row->total) ? number_format($row->total) : 0 }}</h3>
                                    </div>
                                    <i class="fas fa-mail-bulk text-primary" style="font-size: 30px"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Successful</h5>
                                        <h3 class="card-text text-success">
                                            {{ isset($row->successful) ? number_format($row->successful) : 0 }}</h3>
                                    </div>
                                    <i class="fas fa-envelope-open-text text-success" style="font-size: 30px"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">Failed</h5>
                                        <h3 class="card-text text-danger">
                                            {{ isset($row->failed) ? number_format($row->failed) : 0 }}</h3>
                                    </div>
                                    <i class="fas fa-comment-slash text-danger" style="font-size: 30px"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="row">
                    <div class="col-md-6 justify-content-center">
                        No Reports Found yet
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
