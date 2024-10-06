@extends('admin.admin_layouts')
@section('admin_content')
<style>
    @keyframes blinking {
        0% {
            opacity: 1;
        }
        50% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    .blinking {
        animation: blinking 1s infinite;
    }
</style>

    {{-- @includeIf('admin.order.grid_css', ['color' => $active['hex']]) --}}

    <h1 class="h3 mb-3 text-gray-800">Orders -- {{ strtoupper($active['title']) }}</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex mb-2 align-items-center justify-content-center">
                <a class="btn border-info text-info m-1" href="{{ route('admin.order.grid') }}">
                    All
                </a>
                @foreach ($status as $row)
                    <a class="btn m-1" href="{{ route('admin.order.grid', 'status_id=' . $row->id) }}"
                        style="border-color: #{{ $row->hex }};color: #{{ $row->hex }};">
                        {{ $row->orders_count }} - {{ ucwords($row->title) }}
                    </a>
                @endforeach
            </div>

            <div class="row">
                @forelse ($data as $row)
                    @php
                        $current_active_color = isset($row->status_id) ? App\Models\Admin\Status::find($row->status_id) : collect(['hex' => '36b9cc' , 'title' => 'All']);
                        
                    @endphp
                    <div class="col-md-3 my-2">
                        <div class="card order_card" style="border-color: #6D6E71" >
                            <div class="card-header p-2 d-flex flex-column order_header" @if ($row->status==null) style="background-color: #FF155D;" @else style="background-color: #{{$current_active_color->hex}};"  @endif  >
                                <div class="d-flex justify-content-between">
                                    @if ($row->created_at->diffInMinutes(now()) < 1440 && $row->status==null)
                                        <span class="d-flex w-50 align-items-center justify-content-start">
                                            <img src="{{ asset('public/frontend/images/new_order.gif') }}" alt="gif"
                                                width="35" height="35">
                                            <span @if ($row->status==null) style="color: white;" @endif  class="customer_name">{{ $row->customer_name }}</span>
                                        </span>
                                    @else
                                        <span  @if ($row->status==null) style="color: white;" @endif class="customer_name">{{ $row->customer_name }}</span>
                                    @endif
                                    <span>
                                        <form action="{{ route('admin.order.status_change', ['id' => $row->id]) }}"
                                            method="post">
                                            @csrf
                                            <select  name="status_id" class="form-control form-control-sm"
                                                onchange="$(form).submit()">
                                                <option value=''>Choose status</option>
                                                @foreach ($status as $item)
                                                    <option value="{{ $item->id }}" style="color:#{{ $item->hex }}"
                                                        @if ($row->status_id == $item->id) selected @endif>
                                                        {{ ucwords($item->title) }}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <a  href="{{ URL::to('admin/order/detail/' . $row->id) }}" class="order_no" @if ($row->status==null) style="color: white;" @endif>
                                        #{{ $row->order_no }}
                                    </a>
                                    <span @if ($row->status==null) style="color: white;" @endif>
                                        {{ $row->created_at->format('M d, Y') }}
                                    </span>
                                </div>
                                @if ($row->table_id!=null)
                                    <div class="d-flex justify-content-between mt-1">
                                        <b @if ($row->status==null) style="color: white;" @endif >Table</b>
                                        <span @if ($row->status==null) style="color: white;" @endif>
                                            @php
                                                $table_name = DB::table('tables')
                                                ->where('id', $row->table_id)
                                                ->fIrst();
                                            @endphp
                                            <b>{{$table_name->name}}</b>
                                        </span>
                                    </div>
                                @endif

                            </div>

                            <div  class="card-body py-2 px-3 text-dark">
                                <p  class="card-text d-flex flex-column align-items-center">
                                <p>Products:</p>
                                @forelse ($row->products as $item)
                                    <div class="row border my-1">
                                        <span class="col-md-1">
                                            {{ $item->product_qty }}
                                        </span>
                                        <span class="col-md-11 product_name">
                                            {{ $item->product_name }}
                                        </span>
                                    </div>
                                @empty
                                    <span>No Product found</span>
                                @endforelse
                                </p>
                            </div>
                            <div class="p-2 border-top border-dark d-flex justify-content-between align-items-center" style="background-color: #6D6E71">
                                <div class="d-inline-block">
                                    <a style="color: black; background-color:white;" class="btn btn-sm border-white  rounded-pill m-1"
                                        href="{{ URL::to('admin/order/detail/' . $row->id) }}">
                                        Detail
                                    </a>
                                    <a style="color: black; background-color:white;" href="{{ URL::to('admin/order/invoice/' . $row->id) }}"
                                        class="btn border-white  btn-sm rounded-pill m-1"
                                        target="_blank">Invoice</a>
                                    <a style="color: black; background-color:white;" href="{{ URL::to('admin/order/invoice/thermal/' . $row->id) }}"
                                        class="btn border-white btn-sm rounded-pill m-1"
                                        target="_blank">Thermal
                                        Print</a>
                                    <a style="color: black; background-color:white;" href="{{ URL::to('admin/order/delete/' . $row->id) }}"
                                        class="btn border-white btn-sm rounded-pill m-1"
                                        onClick="return confirm('Are you sure?');">Delete</a>

                                    @php
                                        $query = DB::table('customers')->find($row->customer_id);
                                        $is_waiter = isset($query) && $query->is_waiter == '1';



                                        $messages = DB::table('orders_chat')->where('order_id',$row->id)->count();
                                        
                                    @endphp
                                    @if ($is_waiter)
                                        <a style="color: black; background-color:white;" href="{{ route('admin.order.chat', ['id' => $row->id]) }}"
                                            class="btn border-white btn-sm rounded-pill m-1">
                                            Chat Messages <span @if ($messages>0) class="blinking" @endif  style="color: red; font-size: 20px;"><b>{{$messages}}</b></span>

                                        </a>
                                    @endif

                                </div>
                                <span class="text-white px-2 py-1 clock-wrapper-{{ $row->id }}"></span>
                                <script>
                                    $(document).ready(function() {
                                        var createdAt = "{{ $row->created_at }}";
                                        var orderId = "{{ $row->id }}";
                                        getOrderTime(createdAt, orderId);
                                    });
                                    // Get Each Order Time from its created time
                                    function getOrderTime(start, id) {
                                        var startTime = new Date(start);
                                        setInterval(function() {
                                            var currentTime = new Date();
                                            var timeDiff = currentTime.getTime() - startTime.getTime();
                                            var seconds = Math.floor(timeDiff / 1000);
                                            var minutes = Math.floor(seconds / 60);
                                            var hours = Math.floor(minutes / 60);
                                            var days = Math.floor(hours / 24);

                                            hours %= 12;
                                            minutes %= 60;
                                            seconds %= 60;

                                            var durationText = '';

                                            if (days > 0) {
                                                durationText += days + ' day' + (days > 1 ? 's' : '') + ', ';
                                            }

                                            durationText += hours + ':' +
                                                ('0' + minutes)
                                                .slice(-2) + ':' +
                                                ('0' + seconds).slice(-2);

                                            $(`.clock-wrapper-${id}`).html(durationText);
                                        }, 500);
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                @empty
                    <span>No Orders found on this status</span>
                @endforelse
            </div>
        </div>
    </div>
@endsection
