@extends('admin.admin_layouts')
@section('admin_content')
    @include('admin.email_template.gallery_css')
    <h1 class="h3 mb-3 text-gray-800">Coupon Designs</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">View Coupon Designs</h6>
            @if (session('is_super') == 1)
                <div class="float-right d-inline">
                    <a href="{{ url('admin/coupon_design/create') }}">
                        <button class="bn632-hover bn22"><i class="fa fa-plus mr-2"></i>Create New Design</button>
                    </a>
                </div>
            @endif
        </div>
        <div class="card-body">
            @if (session('is_super') == 1)
                @includeIf('admin.coupon_design.listing', ['designs' => $designs])
            @else
                @php
                    $isActive = session('tab') && session('tab') == 'modified';
                @endphp
                <div class="nav-wrapper text-center">
                    <ul class="nav nav-pills d-flex justify-content-center  flex-wrap w-100" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ $isActive ? '' : 'active' }} rounded-pill" id="by-super-admin-tab"
                                data-toggle="tab" href="#by-super-admin" role="tab" aria-controls="by-super-admin"
                                aria-selected="true">By
                                Super Admin</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ $isActive ? 'active' : '' }} rounded-pill" id="by-yourself-tab"
                                data-toggle="tab" href="#by-yourself" role="tab" aria-controls="by-yourself"
                                aria-selected="false">By Yourself</a>
                        </li>
                    </ul>
                </div>
                <br>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade {{ $isActive ? '' : 'show active' }}" id="by-super-admin" role="tabpanel"
                        aria-labelledby="by-super-admin-tab">
                        @includeIf('admin.coupon_design.listing', ['designs' => $designs])
                    </div>
                    <div class="tab-pane fade {{ $isActive ? 'show active' : '' }}" id="by-yourself" role="tabpanel"
                        aria-labelledby="by-yourself-tab">
                        @includeIf('admin.coupon_design.listing', [
                            'designs' => $modified_designs,
                            'enable_delete' => true,
                        ])
                    </div>
                </div>
            @endif
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>

    <script>
        // Initialize Clipboard.js
        var clipboard = new ClipboardJS('.copy-link');

        clipboard.on('success', function(e) {
            // Show a confirmation or feedback that the link has been copied
            e.trigger.innerHTML = 'Link Copied!';
            setTimeout(function() {
                e.trigger.innerHTML = 'Copy Coupon Link';
            }, 1500); // Reset back to the original text after 1.5 seconds
            e.clearSelection();

            // Prevent the default link behavior
            e.preventDefault();
        });

        clipboard.on('error', function(e) {
            // Handle any errors that may occur during copying
            console.error('Error copying text:', e);
        });
    </script>
@endsection
