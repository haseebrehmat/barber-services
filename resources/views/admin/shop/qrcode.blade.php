@extends('admin.admin_layouts')
@section('admin_content')
    <style>
        .disabled-link {
            pointer-events: none;
            cursor: not-allowed;
        }
    </style>

    <h1 class="h3 mb-3 text-gray-800">Shop QR Code</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">View QR Code</h6>
        </div>
        <div class="card-body">

            <p>Here is the Shop QR Code</p>

            <a target="_blank" href="{{ route('front.shop') }}"
                @if ($shop_hidden) class="disabled-link" @endif>
                <div id="qrcode" class="d-inline-block"></div>
            </a>

            <button class="btn btn-sm btn-success mt-4 d-block" onclick="downloadQRCode()">Download QR Code</button>

        </div>
    </div>

    <script src="{{ asset('public/frontend/js/qurcode.min.js') }}"></script>
    <script>
        var qrcode = new QRCode($("#qrcode")[0], {
            text: "{{ route('front.shop') }}",
            width: 200,
            height: 200,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });

        function downloadQRCode() {
            var canvas = $("#qrcode canvas")[0];
            var imageURL = canvas.toDataURL("image/png");
            var link = $("<a></a>").attr({
                download: "qrcode.png",
                href: imageURL
            })[0];
            link.click();
        }
    </script>
@endsection
