@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Service Orders</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">View Service Orders</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable3" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>SL</th>
                            <th>Order Number</th>
                            <th>Service Name</th>
                            @if (session('type')=='admin')
                                <th>Client Detail (Name, Email, Phone)</th>

                            @else
                                <th>Client Name</th>
                            @endif
                            <th>Service Amount</th>
                            <th>Tip Amount</th>
                            <th>Coupon</th>
                            <th>Fee Amount</th>
                            <th>Net Amount</th>
                            <th>Payment Mode</th>
                            <th>Payment Type</th>
                            <th>Service Type</th>
                            <th>Appointment Details</th>
                            <th>Status</th> <!-- New Status Column -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $row)
                            <tr>
                                <td class="status-indicator">
                                    @if ($row->status == 'Pending')
                                        <img style="width: 50px; height: 50px;" src="https://aabsolutebarbersvipnsalons.com/Red-circle.gif" alt="Red Circle">
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-between">
                                        {{ $loop->iteration }}
                                        @if (\Carbon\Carbon::parse($row->created_at)->diffInMinutes(now()) < 1440)
                                            {{-- <img src="{{ asset('public/frontend/images/new_order.gif') }}" alt="gif" width="35" height="35"> --}}
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $row->order_no }}</td>
                                <td>{{ $row->offering_name }}</td>
                                @if (session('type')=='admin')
                                    <td>
                                        {{ $row->client_fname }} {{ $row->client_lname }}<br>
                                        {{ $row->client_email }}<br>
                                        {{ $row->client_phone }}
                                    </td>

                                @else
                                    <td>
                                        {{ $row->client_fname }} {{ $row->client_lname }}
                                    </td>
                                @endif
                                <td>${{ $row->net_amount }}</td>
                                <td>${{ $row->tip_amount }}</td>
                                <td>
                                    @php $coupon_amount = 0; @endphp
                                    @if($row->coupon_code)
                                    <div class="d-flex flex-column align-items-center">
                                        <span><strong>Coupon: </strong>{{ $row->coupon_code }}</span>
                                        <span><strong>Discount: </strong>${{ $row->coupon_discount ?? 0 }}</span>
                                    </div>
                                    @php $coupon_amount = $row->coupon_discount ?? 0; @endphp
                                    @else
                                        ---
                                    @endif
                                </td>
                                <td>${{ $row->fee_amount }}</td>
                                <td>
                                    @php $net_amount = $row->net_amount+$row->tip_amount-$coupon_amount @endphp
                                    ${{ $net_amount < 0 ? 0 : $net_amount }}
                                </td>
                                <td>{{ ucwords($row->payment_type) }}</td>
                                <td>
                                    @if (ucwords($row->payment_type)=='Cash')
                                        <p style="color: red">Pending Payment</p>
                                    @else
                                        <p style="color: green">Paid</p>
                                    @endif
                                </td>
                                <td>{{ $row->is_appointed ? 'Appointment' : 'Walking' }}</td>
                                <td>
                                    @if ($row->is_appointed)
                                        {{ \Carbon\Carbon::parse($row->appointment_date)->format('M d, Y') }}<br>
                                        {{ \Carbon\Carbon::parse($row->appointment_time)->format('h:i A') }}
                                    @else
                                        ---
                                    @endif
                                </td>

                                <td>
                                    <select class="form-control order-status" data-order-id="{{ $row->id }}" style="width: auto;">
                                        <option value="Pending" {{ $row->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Done" {{ $row->status == 'Done' ? 'selected' : '' }}>Done</option>
                                    </select>
                                </td> <!-- Status Dropdown -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function () {
            $('.order-status').change(function () {
                var status = $(this).val();
                var orderId = $(this).data('order-id');
                var row = $(this).closest('tr');

                $.ajax({
                    url: "{{ route('admin.offering.update_status') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: status,
                        order_id: orderId
                    },
                    success: function (response) {
                        if (response.success) {
                            // Update the status indicator based on the new status
                            var statusIndicator = row.find('.status-indicator');
                            if (status === 'Done') {
                                statusIndicator.empty(); // Remove the red circle
                            } else if (status === 'Pending') {
                                statusIndicator.html('<img style="width: 50px; height: 50px;" src="https://aabsolutebarbersvipnsalons.com/Red-circle.gif" alt="Red Circle">');
                            }
                        }
                    }
                });
            });
        });
    </script>
     <script>
        $(document).ready(function() {
            $('#dataTable3').DataTable({
                ordering: false, // Disable sorting for all columns
                pageLength: 30
            });
        });
    </script>
<audio id="loadSound" src="https://aabsolutebarbersvipnsalons.com/order_sound.mp3"></audio>

    <script>
        $(document).ready(function() {
            let lastOrderCheckTime = '{{ now()->format("Y-m-d H:i:s") }}'; // Track the last time orders were checked

            function checkForNewOrders() {
                $.ajax({
                    url: "{{ route('admin.offering.check_new_orders') }}", // Create this route in your Laravel routes
                    method: "GET",
                    data: {
                        last_check: lastOrderCheckTime,
                    },
                    success: function(response) {
                        if (response.new_orders) {
                            // Play sound
                            document.getElementById('loadSound').play();

                            // Update the last check time
                            lastOrderCheckTime = response.latest_order_time;

                            // Refresh the view to show new orders
                            setTimeout(function() {
                                location.reload();
                            }, 10000); // 5000ms = 5 seconds
                        }
                    }
                });
            }

            // Set an interval to check for new orders every 10 seconds
            setInterval(checkForNewOrders, 10000); // 10000ms = 10 seconds
        });
    </script>


@endsection
