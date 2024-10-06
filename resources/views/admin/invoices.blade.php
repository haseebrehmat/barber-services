@extends('admin.admin_layouts')

@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">You Purchase History</h1>


    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="customers-table" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Invoice ID</th>
                        <th>Transaction ID</th>
                        <th>Amount</th>
                        <th>Payment Status</th>
                        <th>Valid Till</th>
                        <th>Status</th>
                        <th>Get Invoice</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $row)
                        <tr>
                            <td>#{{ $row->id }}</td>
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
                            <td>
                                <form action="{{ route('admin.generate_invoice') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="transaction_id" value="{{ $row->id }}">
                                    <button type="submit" class="btn btn-primary">Invoice</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection
