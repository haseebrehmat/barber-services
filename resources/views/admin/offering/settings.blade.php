@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Service Settings</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">Update Service Settings</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 border py-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active btn" id="v-pills-payment-modes-tab" data-toggle="pill"
                            data-target="#v-pills-payment-modes" type="button" role="tab"
                            aria-controls="v-pills-payment-modes" aria-selected="true">Payment Modes</button>
                        <button class="nav-link btn" id="v-pills-schedule-tab" data-toggle="pill"
                            data-target="#v-pills-schedule" type="button" role="tab" aria-controls="v-pills-schedule"
                            aria-selected="false">Shop Timings</button>
                    </div>
                </div>
                <div class="col-md-9 py-3">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-payment-modes" role="tabpanel"
                            aria-labelledby="v-pills-payment-modes-tab">
                            @include('admin.offering.settings.payment_modes')
                        </div>
                        <div class="tab-pane fade" id="v-pills-schedule" role="tabpanel"
                            aria-labelledby="v-pills-schedule-tab">
                            @include('admin.offering.settings.timings')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
