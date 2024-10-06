<div class="row" style="background: #B2BEB5">
    @foreach ($designs as $row)
        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
            <div class="card m-3">
                <div class="card-container">
                    <img src="{{ isset($row->thumbnail) ? asset('public/uploads/' . $row->thumbnail) : 'https://dummyimage.com/245x300/e8e8e8/000000.png&text=No+thumbnail+found' }}"
                        class="card-img-top" alt="Thumbnail">

                    @if (session('is_super') == 1)
                        <div class="edit-button text-center">
                            <a href="{{ route('admin.coupon_design.edit', ['coupon_design' => $row]) }}"
                                class="btn btn-primary rounded-pill btn-sm">Edit</a>

                            <a href="{{ route('admin.coupon_design.delete', ['coupon_design' => $row]) }}"
                                class="btn btn-danger rounded-pill btn-sm"
                                onclick="return confirm('Are you sure you want to delete this template?')">Delete</a>
                        </div>
                    @else
                        <div class="edit-button text-center">
                            <div class="d-flex flex-column">
                                @if (isset($row->expired_at))
                                    <a id="copyCouponLink{{ $row->id }}" href="#"
                                        data-clipboard-text="{{ route('admin.coupon_design.show', ['id' => bin2hex(base64_encode($row->id))]) }}"
                                        class="copy-link btn btn-success rounded-pill btn-sm mb-2">
                                        Copy Coupon Link
                                    </a>
                                @endif

                                @if (isset($enable_delete) && $enable_delete)
                                    <a href="{{ route('admin.coupon_design.delete', ['coupon_design' => $row]) }}"
                                        class="btn btn-danger rounded-pill btn-sm mb-2"
                                        onclick="return confirm('Are you sure you want to delete this template?')">Delete</a>
                                    <a href="{{ route('admin.coupon_design.edit', ['coupon_design' => $row]) }}"
                                        class="btn btn-dark rounded-pill btn-sm">
                                        Edit
                                    </a>
                                @else
                                    <a href="{{ route('admin.coupon_design.modify', ['coupon_design' => $row]) }}"
                                        class="btn btn-primary rounded-pill btn-sm">Modify</a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                <h6 class="text-center py-3">{{ $row->title }}</h6>
            </div>
        </div>
    @endforeach
</div>
