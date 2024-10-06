<div class="row" style="background: #B2BEB5">
    @foreach ($templates as $row)
        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="card m-3">
                <div class="card-container">
                    <img src="{{ isset($row->thumbnail) ? asset('public/uploads/' . $row->thumbnail) : 'https://dummyimage.com/245x300/e8e8e8/000000.png&text=No+thumbnail+found' }}"
                        class="card-img-top" alt="Thumbnail">

                    @if (session('is_super') == 1)
                        <div class="edit-button text-center">
                            <a href="{{ URL::to('admin/email-template/edit/' . $row->id) }}"
                                class="btn btn-primary rounded-pill btn-sm">Edit</a>

                            <a href="{{ route('admin.email_template.delete', ['id' => $row->id]) }}"
                                class="btn btn-danger rounded-pill btn-sm"
                                onclick="return confirm('Are you sure you want to delete this template?')">Delete</a>
                        </div>
                    @else
                        <div class="edit-button text-center">
                            <div class="d-flex flex-column">
                                <a href="{{ route('admin.email_template.select', ['template_id' => $row->id]) }}"
                                    class="btn btn-success rounded-pill btn-sm">Select</a>
                                <a href="{{ route('admin.email_template.preview', ['template' => $row]) }}"
                                    class="btn btn-dark rounded-pill btn-sm my-2">Preview</a>

                                @if (isset($enable_delete) && $enable_delete)
                                    <a href="{{ route('admin.email_template.delete', ['id' => $row->id]) }}"
                                        class="btn btn-danger rounded-pill btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this template?')">Delete</a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                <h6 class="text-center py-3">{{ $row->et_name }}</h6>
            </div>
        </div>
    @endforeach
</div>
