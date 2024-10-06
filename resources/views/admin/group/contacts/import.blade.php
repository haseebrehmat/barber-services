<div class="row">
    <div class="col-md-12">
        <div id="account_edit">
            <form action="{{ route('admin.group.contacts.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="group_id" value="{{ $group_id }}">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div id="upload_excel">
                                    <label for="excel_file" class="form-label">
                                        Upload Excel File:
                                    </label>
                                    <input type="file" name="file" class="form-control-file" id="excel_file"
                                        accept=".xlsx, .xls">
                                    @if ($errors->has('file'))
                                        <div class="alert alert-danger">{{ $errors->first('file') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4 text-right">
                                <div id="download_sample_excel" class="mb-1">
                                    <a href="{{ asset('public/demo_excels') }}/demo_bulk.xlsx" download>Download Sample
                                        Excel File</a>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary rounded-pill mr-auto px-3"
                                    id="submit-all">{{ __('Import Excel Sheet') }}</button>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-sm btn-success mr-auto px-3 create-contact-btn"
                                    data-id="{{ $group_id }}">{{ __('Add Contact to Active Group') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
