@extends('layouts.app')

@section('content')
    {{-- <div class="page-banner" style="background-image: url({{ asset('public/uploads/'.$g_setting->banner_cart) }})">
        <div class="bg-page"></div>
        <div class="text">
            <h1>Cart</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cart</li>
                </ol>
            </nav>
        </div>
    </div> --}}

    <div class="page-content pt_50 pb_60 px-lg-5">
        <div class="container-fluid">
            <div class="row cart">
                <div class="col-md-12">
                    @if(Session::has('cart_product_id'))
                    <form action="{{ url('cart/update') }}" method="post">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr class="table-info">
                                    <th>Serial</th>
                                    <th>Thumbnail</th>
                                    <th>Product Name</th>
                                    <th>Product Variant</th>
                                    <th>Product Modifiers</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $value = '';
                                    $itm = '';
                                    $arr_cart_product_id = array();
                                    $arr_cart_product_qty = array();
                                    $subtotal = 0;
                                @endphp
                                @php $i=0 @endphp
                                @foreach(Session::get('cart_product_id') as $value)
                                    @php
                                        $i++;
                                        $arr_cart_product_id[$i] = $value;
                                    @endphp
                                @endforeach

                                @php $i=0 @endphp
                                @foreach(Session::get('cart_product_qty') as $value)
                                    @php
                                        $i++;
                                        $arr_cart_product_qty[$i] = $value;
                                    @endphp
                                @endforeach
                                @php
                                    $tot1 = 0;
                                    $arr_cart_modifier_id = Session::get('cart_modifier_id');
                                @endphp
                                @for($i=1;$i<=count($arr_cart_product_id);$i++)

                                    @php
                                        $product_arr = explode("--", $arr_cart_product_id[$i]);
                                        $variant = isset($product_arr[1]) ? $product_arr[1] : null;
                                        $all_data = App\Models\Admin\Product::where('id', $product_arr[0])->get();
                                        // $all_data = DB::table('products')->where('id', $product_arr[0])->get();
                                    @endphp

                                    @foreach ($all_data as $itm)
                                        @php
                                            $product_name = $itm->product_name;
                                            $product_slug = $itm->product_slug;
                                            $variant_options = $itm->variant_options;
                                            // $variant_options = json_decode($itm->variant_options, true);
                                            $variant_existed = isset($variant_options[$variant]);
                                            $product_current_price = isset($variant) && isset($variant_options) && $variant_existed
                                                ? $variant_options[$variant]
                                                : $itm->product_current_price;
                                            $product_featured_photo = $itm->product_featured_photo;
                                            $product_modifiers = $itm->modifiers;
                                        @endphp
                                    @endforeach


                                    <input type="hidden" name="product_id[]" value="{{ $arr_cart_product_id[$i] }}">
                                    <tr>
                                        <td class="align-middle">{{ $i }}</td>
                                        <td class="align-middle"><img src="{{ asset('public/uploads/'.$product_featured_photo) }}"></td>
                                        <td class="align-middle">
                                            <a href="{{ url('product/'.$product_slug) }}">{{ $product_name }}</a>
                                        </td>
                                        <td class="align-middle">{{ isset($variant) && $variant_existed ? $variant : '-' }}</td>
                                        <td class="align-middle" @if(sizeOf($product_modifiers) > 0) style="min-width:300px" @endif>
                                            @php $cart_modifier_subtotal = 0 @endphp
                                            @foreach ($product_modifiers as $row)
                                                @php
                                                    $checked = in_array($row->id, $arr_cart_modifier_id[$i - 1]);
                                                    if ($checked) {
                                                        $cart_modifier_subtotal += $row->unit_price;
                                                    }
                                                @endphp
                                                <div class="d-flex align-items-center mb-1 ml-1">
                                                    <input type="checkbox" name="products_modifiers[{{ $i - 1 }}][]" value="{{ $row->id }}"
                                                        @if($checked) checked @endif>
                                                    <label class="form-check-label ml-1">{{ $row->name }} (USD {{ $row->unit_price }})</label>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td class="align-middle">USD {{ $product_current_price }}</td>
                                        <td class="align-middle">
                                            <input type="number" class="form-control" name="product_qty[]" step="1" min="1" max="" pattern="" pattern="[0-9]*" inputmode="numeric" value="{{ $arr_cart_product_qty[$i] }}">
                                        </td>
                                        <td class="align-middle">
                                            USD {{ $subtotal = ($product_current_price * $arr_cart_product_qty[$i]) +  $cart_modifier_subtotal }}
                                        </td>
                                        <td class="align-middle">
                                        <a href="{{ url('cart/delete/'.$arr_cart_product_id[$i]. '/' .($i - 1)) }}" class="cart_button_arefin btn btn-xs btn-danger" onClick="return confirm('Are you sure?');"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>

                                    @php $tot1 = $tot1 + $subtotal; @endphp
                                @endfor

                                @php
                                    $session_modifiers = Session::get('modifiers_added', []);
                                    $session_modifier_qtys = Session::get('modifiers_qtys', []);
                                    $total_price = 0.0;
                                @endphp
                                @if (count($session_modifiers) > 0)
                                    @php
                                        $query = DB::table('modifiers')->whereNull('deleted_at')->whereIn('id', $session_modifiers);
                                        $data = isset($query) ? $query->get() : [];
                                        // $total_price = isset($query) ? $query->sum('unit_price') : 0.0;
                                    @endphp
                                    <tr>
                                        <td class="text-right">Modifiers: </td>
                                        <td colspan="4">
                                            @foreach ($data as $row)
                                                @php
                                                    $qty = isset($session_modifier_qtys[$row->id]) ? $session_modifier_qtys[$row->id] : 1;
                                                    $total_price += $row->unit_price * $qty;
                                                @endphp
                                                <span>{{ $row->name }} (USD {{ $row->unit_price }})
                                                    <span class="ml-1 h5">x {{ $qty }}</span>
                                                    @if (!$loop->last)
                                                        <span class="px-2">||</span>
                                                    @endif
                                                </span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="cart-buttons">
                                                <a href="#edit_modifier_qtys" data-toggle="modal" class="btn btn-sm btn-info btn-arf">
                                                    <i class="fas fa-pencil-alt"></i> Edit Qtys
                                                </a>
                                            </div>
                                        </td>
                                        <td>USD <span class="update_subtotal h4">{{ $total_price }}</span></td>
                                    </tr>
                                @endif

                                <tr>
                                    <td colspan="5" class="text-right">Total: </td>
                                    <td colspan="3">USD <span class="update_subtotal">{{ $tot1 + $total_price }}</span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="cart-buttons">
                                <a href="#add_modifier" data-toggle="modal" class="btn btn-info btn-arf d-none">
                                    <i class="far fa-star"></i>
                                    Please Add {{ count($session_modifiers) > 0 ? 'More' : '' }} Modifiers <i class="far fa-star"></i>
                                </a>
                            </div>
                            <div class="cart-buttons">
                                <a href="{{ route('front.shop') }}" class="btn btn-info btn-arf">Continue Shopping</a>
                                <input type="submit" value="Update Cart" class="btn btn-info btn-arf" name="form1">
                                <a href="{{ route('front.checkout') }}" class="btn btn-info btn-arf">Checkout</a>
                            </div>
                        </div>
                    </form>
                    @includeIf('pages.add_modifer', ['modifiers' => $modifiers, 'session_modifiers' => $session_modifiers])
                    @includeIf('pages.edit_modifier_qtys',
                        ['selected_modifiers' => $selected_modifiers, 'session_modifier_qtys' => $session_modifier_qtys]
                    )
                    @else
                        Cart is empty!
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
