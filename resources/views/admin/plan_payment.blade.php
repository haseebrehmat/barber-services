@extends('admin.admin_layouts')

@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">You Billing Details</h1>
    <h5>Please Note : Upon Payment your subscription will be valid for next 30 days only.</h5>


    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="customers-table" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Amount</th>
                        <th>Payment Status</th>
                        <th>Valid Till</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($transactions as $row)
                        <tr>
                            <td>{{ $row->transaction_id }}</td>
                            <td>{{ $row->amount }}$</td>
                            <td>{{ $row->payment_status }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->valid_till)->format('d M Y') }}</td>
                            @php
                                $storedDate = \Carbon\Carbon::parse($row->valid_till); // assuming the date is stored in a column called date_column
                                $currentDate = \Carbon\Carbon::now();
                                $valid=null;
                                if ($storedDate->isPast()) {
                                    // the stored date is in the past
                                    $valid='false';
                                } else {
                                    // the stored date is in the future
                                    $valid='true';
                                }
                            @endphp 
                            <td>
                                @if ($valid=='false')
                                    <p style="color: red;"><b>Expired</b></p>    
                                @endif
                                @if ($valid=='true')
                                    <p style="color: green;"><b>Active</b></p>    
                                @endif
                            </td>
                        </tr>
                        
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @php
        $cents = $general_settings_global->monthly_fee*100;
        
        $admin_data = App\Models\Admin\Admin::where('id',session('id'))->first();
        $c_email=$admin_data->email;
    @endphp
    
    @if ($valid=='false')
        <div style="text-align: center;" class="alert alert-danger">
            Your package has expired. Please Pay to activate Admin panel for next 30 Days. Thanks
            <br><br>

            <form action="{{ route('customer.stripe1') }}" method="post">
                @csrf
                <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="{{ env('STRIPE_PUBLIC_KEY') }}"
                    data-amount="{{ $cents }}"
                    data-name="{{ env('APP_NAME') }}"
                    data-description=""
                    data-image="{{ asset('public/uploads/stripe_icon.png') }}"
                    data-currency="usd"
                    data-email="{{ $c_email }}"
                >
                </script>
            </form>
        </div>
        
    @endif

@endsection
