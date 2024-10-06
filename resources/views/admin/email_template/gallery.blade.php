@extends('admin.admin_layouts')
@section('admin_content')
    @include('admin.email_template.gallery_css')
    <h1 class="h3 mb-3 text-gray-800">Email Templates Gallery</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">View Email Templates Gallery</h6>
            @if (session('is_super') == 1)
                <div class="float-right d-inline">
                    <a href="{{ url('admin/email-template/create') }}">
                        <button class="bn632-hover bn22"><i class="fa fa-plus mr-2"></i>Create New Template</button>
                    </a>
                </div>
            @endif
        </div>
        <div class="card-body">
            @if (session('is_super') == 1)
                @includeIf('admin.email_template.listing', ['templates' => $templates])
            @else
            <div class="nav-wrapper text-center">
                <ul class="nav nav-pills d-flex justify-content-center  flex-wrap w-100" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active rounded-pill" id="by-super-admin-tab" data-toggle="tab" href="#by-super-admin"
                            role="tab" aria-controls="by-super-admin" aria-selected="true">By Super Admin</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link rounded-pill" id="by-yourself-tab" data-toggle="tab" href="#by-yourself" role="tab"
                            aria-controls="by-yourself" aria-selected="false">By Yourself</a>
                    </li>
                </ul>
            </div>
            <br>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="by-super-admin" role="tabpanel"
                        aria-labelledby="by-super-admin-tab">
                        @includeIf('admin.email_template.listing', ['templates' => $templates])
                    </div>
                    <div class="tab-pane fade" id="by-yourself" role="tabpanel" aria-labelledby="by-yourself-tab">
                        @includeIf('admin.email_template.listing', ['templates' => $modified_templates, 'enable_delete' => true])
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
