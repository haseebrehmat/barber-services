<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
</head>
<style type="text/css">
    body {
        font-family: 'Roboto Condensed', sans-serif;
    }

    .m-0 {
        margin: 0px;
    }

    .p-0 {
        padding: 0px;
    }

    .pt-5 {
        padding-top: 5px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .text-center {
        text-align: center !important;
    }

    .w-100 {
        width: 100%;
    }

    .w-50 {
        width: 50%;
    }

    .w-85 {
        width: 85%;
    }

    .w-15 {
        width: 15%;
    }

    .logo img {
        width: 45px;
        height: 45px;
        padding-top: 30px;
    }

    .logo span {
        margin-left: 8px;
        top: 19px;
        position: absolute;
        font-weight: bold;
        font-size: 25px;
    }

    .gray-color {
        color: #928f95;
    }

    .text-bold {
        color: #435d86;
        font-weight: bold;
    }

    .border {
        border: 1px solid black;
    }

    table tr,
    th,
    td {
        border: 1px solid #928f95;
        border-collapse: collapse;
        padding: 7px 8px;
    }

    table tr th {
        background: #84afc9;
        color: white;
        font-size: 15px;
    }

    table tr td {
        font-size: 13px;
    }

    table {
        border-collapse: collapse;
    }

    .box-text p {
        line-height: 10px;
    }

    .float-left {
        float: left;
    }

    .total-part {
        font-size: 16px;
        line-height: 12px;
    }

    .total-right p {
        padding-right: 20px;
    }
    .wrapper {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        width: 100%;
    }
</style>

<body>
    <div class="head-title">
        <h1 class="text-center m-0 p-0"> <img style="width: 150px;"
                src="{{ asset("public/uploads/$general_settings_global->logo") }}"> </h1>
    </div>
    <hr class="w-100" style="color:#d6d4d8;margin-top:15px;margin-bottom:0px;">
    <div class="wrapper">
        <div>
            <div class="mt-10">
                <p class="m-0 pt-5 text-bold w-100">Invoice Number - <span
                        class="gray-color">#{{ $invoice->number }}</span>
                </p>
                <p class="m-0 pt-5 text-bold w-100">Issue Date - <span
                        class="gray-color">{{ \Carbon\Carbon::parse($invoice->issue_date)->format('d M Y') }}</span></p>
                <p class="m-0 pt-5 text-bold w-100">Status - <span class="gray-color">Paid</span></p>
            </div>
            <div style="clear: both;"></div>
        </div>
        <div class="mt-10">
            <div class="mt-10">
                <p class="m-0 pt-5 text-bold w-100"><span class="gray-color">To:</span> <span
                        style="color:#6e99cc">{{ ucwords($invoice->client_name) }}</span></p>
                <p class="m-0 pt-5 gray-color w-100">
                    <span>{{ $invoice->street }}, {{ $invoice->state }}</span><br>
                    <span>{{ $invoice->city }}, {{ $invoice->country }}</span>
                </p>
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th>#</th>
                <th class="w-50">Description</th>
                <th class="w-50" align="right">Qty</th>
                <th class="w-50" align="right">Price</th>
                <th class="w-50" align="right">Amount</th>
            </tr>
            @php
                $sub_total = 0;
                $tax = isset($invoice->tax) ? $invoice->tax : 0;
            @endphp
            @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->description }}</td>
                    <td align="right">{{ $item->qty }}</td>
                    <td align="right">{{ $item->unit_price }} $</td>
                    <td align="right">{{ $item->unit_price * $item->qty }} $</td>
                </tr>
                @php
                    $sub_total += $item->unit_price * $item->qty;
                @endphp
            @endforeach
            @php
                $total = $sub_total + $sub_total * ($tax / 100);
            @endphp
            <tr>
                <td colspan="5">
                    <div class="total-part">
                        <div class="total-left w-85 float-left" align="right">
                            <p>Sub Total</p>
                            <p>Tax</p>
                            <p>Total Amount</p>
                        </div>
                        <div class="total-right w-15 float-left text-bold" align="right">
                            <p>{{ round($sub_total, 2) }} $</p>
                            <p>{{ $tax }} %</p>
                            <p>{{ round($total, 2) }} $</p>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

</html>
