@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Flyers</h1>
    @php
        use Carbon\Carbon;
    @endphp
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 mt-2 font-weight-bold text-primary">View Flyers</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Validity</th>
                                    <th>Status</th>
                                    <th>Link</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $coupon)
                                    <tr>
                                        <td>{!! $coupon->title !!}</td>
                                        <td>{{ Carbon::createFromFormat('Y-m-d', $coupon->valid_till)->format('d F Y') }}</td>
                                        <td>
                                            @if (Carbon::createFromFormat('Y-m-d', $coupon->valid_till)->isPast())
                                                <span class="text-danger">Expired</span>
                                            @elseif (Carbon::createFromFormat('Y-m-d', $coupon->valid_till)->isToday())
                                                <span class="text-warning">Expires Today</span>
                                            @else
                                                <span class="text-success">Valid</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a id="copyCouponLink{{ $coupon->id }}"
                                               href="#"
                                               data-clipboard-text="{{ URL::to('coupon/tool/view/'.$coupon->secret) }}"
                                               class="copy-link">
                                               Click to copy Flyer Link
                                            </a>
                                        </td>
                                        <td class="d-flex">
                                            <button data-route="{{ route('admin.coupon.tool.update', ['coupon' => $coupon]) }}"
                                                data-title="{{ $coupon->title }}" data-valid="{{ $coupon->valid_till }}" 
                                                data-hex="{{ $coupon->hex }}" 
                                                class="btn btn-warning btn-sm mr-2 edit-btn"><i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.coupon.tool.destroy', ['coupon' => $coupon]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm"
                                                    onClick="return confirm('Are you sure?');">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <form enctype="multipart/form-data" action="{{ route('coupon.tool.store') }}" method="post">
                @csrf
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 mt-2 font-weight-bold text-primary">New Flyer</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Flyer Title</label>
                            <textarea name="title" class="form-control editor" cols="30" rows="10">{{ old('title') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Background Color</label>
                            <input type="text" name="hex" class="form-control jscolor"
                                value="{{ old('hex') ? old('hex') : '000000' }}">
                        </div>
                        <div class="form-group">
                            <label for="">Logo (Optional)</label>
                            <input type="file" name="logo" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Image</label>
                            <input type="file" name="image" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Flyer Validity</label>
                            <input required type="date" name="valid_till" class="form-control" value="{{ old('valid_till') }}">
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
            <form enctype="multipart/form-data" action="" method="post" id="edit-status-form" style="display: none;">
                @csrf
                @method('PUT')
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 mt-2 font-weight-bold text-primary">Edit Flyer</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Title</label>
                            <input required type="text" name="title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Background Color</label>
                            <input type="text" name="hex" class="form-control jscolor"
                                >
                        </div>
                        <div class="form-group">
                            <label for="">Logo (Optional)</label>
                            <input type="file" name="logo" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Image</label>
                            <input type="file" name="image" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Flyer Validity</label>
                            <input required type="date" name="valid_till" class="form-control" >
                        </div>
                       
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $('.edit-btn').click(function() {
            $('#edit-status-form').attr('action', $(this).data('route'));
            $('#edit-status-form input[name="title"]').val($(this).data('title'));
            $('#edit-status-form input[name="valid_till"]').val($(this).data('valid_till'));
            $('#edit-status-form input[name="hex"]').val($(this).data('hex'));
            $('#edit-status-form').show();
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>

    <script>
        // Initialize Clipboard.js
        var clipboard = new ClipboardJS('.copy-link');
    
        clipboard.on('success', function (e) {
            // Show a confirmation or feedback that the link has been copied
            e.trigger.innerHTML = 'Link Copied!';
            setTimeout(function () {
                e.trigger.innerHTML = 'Click to copy Flyer Link';
            }, 1500); // Reset back to the original text after 1.5 seconds
            e.clearSelection();
            
            // Prevent the default link behavior
            e.preventDefault();
        });
    
        clipboard.on('error', function (e) {
            // Handle any errors that may occur during copying
            console.error('Error copying text:', e);
        });
    </script>
@endsection
