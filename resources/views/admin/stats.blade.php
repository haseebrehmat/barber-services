@extends('admin.admin_layouts')

@section('admin_content')
    
    @php
    use Carbon\Carbon;
    $total_completed_orders = DB::table('orders')->where('payment_status','Completed')->count();
    $total_pending_orders = DB::table('orders')->where('payment_status','Pending')->count();

    
        // Get the current date
    $currentDate = Carbon::now();

    // Calculate the date 7 days ago from today
    $sevenDaysAgo = $currentDate->subDays(7)->toDateTimeString();

    // Get the total sales amount for pending orders in the last 7 days
    $totalSalesLastSevenDays = DB::table('orders')
        ->where('payment_status', 'Completed')
        ->where('created_at', '>=', $sevenDaysAgo)
        ->sum('net_amount');


    
    $thirtyDaysAgo = Carbon::now()->subDays(30)->toDateTimeString();
    $productSales = \DB::table('order_details')
        ->select('product_id' ,'product_name', \DB::raw('SUM(product_qty) as total_qty'))
        ->where('created_at', '>=', $thirtyDaysAgo)
        ->groupBy('product_name','product_id')
        ->get();

    
    // dd($productSales);

        
    @endphp

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-2">
            <h1 class="h3 mb-3 text-gray-800">Stats</h1>
        </div>
    </div>

    <!-- Box Start -->
    <div class="row dashboard-page">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h4 font-weight-bold text-success mb-1">Completed Orders</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_completed_orders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-globe fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h4 font-weight-bold text-success mb-1">Pending Orders</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_pending_orders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h4 font-weight-bold text-success mb-1">last 7 days Sales amount</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSalesLastSevenDays }}$</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-award fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">Top Selling products in last 30 days</h6>
        </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Units Sold</th>
                    <th>Stock Pending</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($productSales as $row)
                    
                    <tr>
                        <td>{{ $row->product_name }}</td>
                        <td>{{ $row->total_qty }}</td>
                        @foreach ($all_products as $product)
                              @if ($product->id==$row->product_id)
                                  @php
                                      $pending_stock=($product->product_stock)-($row->total_qty);
                                  @endphp
                                  <td>{{$pending_stock}}</td>
                              @endif  
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- // Box End -->
@endsection
