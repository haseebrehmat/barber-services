<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
</head>
<style type="text/css">
    body{
        font-family: 'Roboto Condensed', sans-serif;
    }
    .m-0{
        margin: 0px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .mt-10{
        margin-top:10px;
    }
    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }
    .w-50{
        width:50%;   
    }
    .w-85{
        width:85%;   
    }
    .w-15{
        width:15%;   
    }
    .logo img{
        width:45px;
        height:45px;
        padding-top:30px;
    }
    .logo span{
        margin-left:8px;
        top:19px;
        position: absolute;
        font-weight: bold;
        font-size:25px;
    }
    .gray-color{
        color:#5D5D5D;
    }
    .text-bold{
        font-weight: bold;
    }
    .border{
        border:1px solid black;
    }
    table tr,th,td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:15px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
    }
    .total-part{
        font-size:16px;
        line-height:12px;
    }
    .total-right p{
        padding-right:20px;
    }
</style>
<body>
<div class="head-title">
    <h1 class="text-center m-0 p-0"> <img style="width: 150px;" src="{{ asset("public/uploads/$general_settings_global->admin_logo") }}"> </h1>
</div>
<div style="width: 100%;" class="add-detail mt-10">
    <div class="w-50 float-left mt-10">
        <p class="m-0 pt-5 text-bold w-100">Invoice Id - <span class="gray-color">#{{$transaction->id}}</span></p>
        <p class="m-0 pt-5 text-bold w-100">trnx Id - <span class="gray-color">#{{$transaction->transaction_id}}</span></p>
        <p  class="m-0 pt-5 text-bold w-100">Transaction Date - <span class="gray-color">{{ \Carbon\Carbon::parse($transaction->valid_till)->format('d M Y') }}</span></p>
        <p class="m-0 pt-5 text-bold w-100">trnx Status - <span class="gray-color">Paid</span></p>
    </div>
    <div style="clear: both;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10" >
        <tr>
            <th class="w-50">To</th>
        </tr>
        <tr>
            <td>
                <div class="box-text">
                    <p>{{$admin_data->name}}</p>
                    <p>{{$admin_data->email}}</p>
                </div>
            </td>
        </tr>
    </table>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-100">Payment Method</th>
        </tr>
        <tr>
            <td><h3>Stripe</h3></td>
        </tr>
    </table>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-100">Subscription</th>
        </tr>
        <tr>
            <td><h3>Monthly</h3></td>
        </tr>
    </table>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">Invoice ID</th>
            <th class="w-50">Transaction ID</th>
            <th class="w-50">Price</th>
            <th class="w-50">Qty</th>
            <th class="w-50">Subtotal</th>
            <th class="w-50">Grand Total</th>
        </tr>
        <tr align="center">
            <td>#{{$transaction->id}}</td>
            <td>#{{$transaction->transaction_id}}</td>
            <td>{{$transaction->amount}}$</td>
            <td>1</td>
            <td>{{$transaction->amount}}$</td>
            <td>{{$transaction->amount}}$</td>
        </tr>
        <tr>
            <td colspan="7">
                <div class="total-part">
                    <div class="total-left w-85 float-left" align="right">
                        <p>Sub Total</p>
                        <p>Total Paid</p>
                    </div>
                    <div class="total-right w-15 float-left text-bold" align="right">
                        <p>{{$transaction->amount}}$</p>
                        <p>{{$transaction->amount}}$</p>
                    </div>
                    <div style="clear: both;"></div>
                </div> 
            </td>
        </tr>
    </table>
</div>
</html>