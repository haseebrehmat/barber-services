<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <style type="text/css">
        body {
            font-family: 'Roboto Condensed', sans-serif;
            font-size: 12px;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 250px;
            /* Adjust the width to fit the thermal paper width */
            margin: auto;
        }

        .logo img {
            width: 100px;
            /* Adjust the logo size to fit the thermal paper width */
        }

        hr {
            border: 1px solid #d6d4d8;
            margin: 15px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #928f95;
            padding: 5px 8px;
            text-align: left;
        }

        th {
            background-color: #84afc9;
            color: white;
        }

        .total td {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <img style="width: 90px;" src="{{ asset("public/uploads/$general_settings_global->logo") }}">
        </div>
        <hr>
        <div>
            <p>Invoice Number: #{{ $invoice->number }}</p>
            <p>Issue Date: {{ \Carbon\Carbon::parse($invoice->issue_date)->format('d M Y') }}</p>
            <p>Status: Paid</p>
        </div>
        <hr>
        <div>
            <p>To: {{ ucwords($invoice->client_name) }}</p>
            <p>{{ $invoice->street }}, {{ $invoice->state }}</p>
            <p>{{ $invoice->city }}, {{ $invoice->country }}</p>
        </div>
        <hr>
        <div>
            <table>
                <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th align="right">Qty</th>
                    <th align="right">Price</th>
                    <th align="right">Amount</th>
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
                <tr class="total">
                    <td colspan="4" align="right">Sub Total:</td>
                    <td align="right">{{ round($sub_total, 2) }} $</td>
                </tr>
                <tr class="total">
                    <td colspan="4" align="right">Tax ({{ $tax }}%):</td>
                    <td align="right">{{ round($sub_total * ($tax / 100), 2) }} $</td>
                </tr>
                <tr class="total">
                    <td colspan="4" align="right">Total Amount:</td>
                    <td align="right">{{ round($total, 2) }} $</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
