@extends('admin.admin_layouts')
@section('admin_content')
    <style>
        .thumbnail {
            width: 200px;
            height: 250px;
            object-fit: cover;
        }

        .template-name {
            word-wrap: break-word;
        }

        .w-200 {
            width: 200px;
        }
    </style>
    @php
        $status = ['draft' => 'Draft', 'sent' => 'Sent'];
        $selected_recipients = $data->recipients->modelKeys();
    @endphp
    <h1 class="h3 mb-3 text-gray-800">Edit Campaign</h1>

    <form action="{{ route('admin.campaign.update', ['campaign' => $data]) }}" method="post">
        @csrf
        @method('PUT')
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">Edit Campaign</h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin.campaign.index') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                        View All</a>
                </div>
            </div>
            <div class="card-body">
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-block text-left" type="button" data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Edit Basic Details
                                </button>
                            </h2>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                            data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Campaign Name *</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ $data->name ?? old('name') }}" autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="">Campaign Status *</label>
                                    <select name="status" class="form-control select2" required>
                                        @foreach ($status as $key => $value)
                                            <option value="{{ $key }}"
                                                @if ($data->status == $key) selected @endif>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h2 class="mb-0">
                                <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Edit or Choose Templates
                                </button>
                            </h2>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                            data-parent="#accordionExample">
                            <div class="card-body">
                                <ul class="nav nav-pills nav-justified border border-primary rounded-pill w-50"
                                    id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active rounded-pill" id="by-super-admin-tab" data-toggle="tab"
                                            href="#by-super-admin" role="tab" aria-controls="by-super-admin"
                                            aria-selected="true">By
                                            Super Admin</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link rounded-pill" id="by-yourself-tab" data-toggle="tab"
                                            href="#by-yourself" role="tab" aria-controls="by-yourself"
                                            aria-selected="false">By Yourself (Modified)</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="by-super-admin" role="tabpanel"
                                        aria-labelledby="by-super-admin-tab">
                                        <div class="d-flex flex-wrap">
                                            @foreach ($templates as $row)
                                                <label class="d-flex flex-column align-items-center m-2">
                                                    <img src="{{ isset($row['thumbnail']) ? asset('public/uploads/' . $row['thumbnail']) : 'https://dummyimage.com/245x300/e8e8e8/000000.png&text=No+thumbnail+found' }}"
                                                        class="thumbnail" alt="Thumbnail">
                                                    <div class="d-flex align-items-baseline my-2 w-200">
                                                        <input type="radio" name="template_id" value="{{ $row['id'] }}"
                                                            required @if ($data->template_id == $row['id']) checked @endif>
                                                        <span class="ml-2 template-name">{{ $row['et_name'] }}</span>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="by-yourself" role="tabpanel"
                                        aria-labelledby="by-yourself-tab">
                                        <div class="d-flex flex-wrap">
                                            @foreach ($modified_templates as $row)
                                                <label class="d-flex flex-column align-items-center m-2">
                                                    <img src="{{ isset($row['thumbnail']) ? asset('public/uploads/' . $row['thumbnail']) : 'https://dummyimage.com/245x300/e8e8e8/000000.png&text=No+thumbnail+found' }}"
                                                        class="thumbnail" alt="Thumbnail">
                                                    <div class="d-flex align-items-baseline my-2 w-200">
                                                        <input type="radio" name="template_id"
                                                            value="{{ $row['id'] }}" required
                                                            @if ($data->template_id == $row['id']) checked @endif>
                                                        <span class="ml-2 template-name">{{ $row['et_name'] }}</span>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mt-2 px-5 float-right">Update</button>
            </div>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2({
            placeholder: 'Please Choose Status',
        });
        $('.select3').select2({
            placeholder: 'Please select recipients',
            multiple: true,
            allowClear: true,
            minimumResultsForSearch: 5
        });
    </script>
@endsection
