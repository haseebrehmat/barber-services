@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Preview Template</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2">Template:<span class="font-weight-bold text-primary ml-4">{{ $template->et_name }}</span>
            </h6>
            <div class="float-right d-inline">
                <a href="{{ route('admin.email_template.gallery') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                    <i class="fa fa-arrow-left mr-2"></i> Back To Gallery</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-8 col-sm-12">
                    <div class="border-bottom p-2 mb-3">
                        <span class="mr-2 font-weight-bold text-primary">Subject:</span> {{ $template->et_subject }}
                    </div>
                    <div class="row bg-light">
                        <div class="col-md-12">
                            {!! $template->et_content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
