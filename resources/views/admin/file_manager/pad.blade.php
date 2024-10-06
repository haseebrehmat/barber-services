{{-- Using signature pad --}}
@extends('admin.admin_layouts')
@section('admin_content')
    <style>
        #canvas {
            border: 1px solid rgba(0, 0, 0, 0.329);
        }
    </style>

    <h1 class="h3 mb-3 text-gray-800">Signature Pad</h1>

    <div class="card shadow my-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">Add your signature and save it.</h6>
        </div>
    </div>
    <canvas id="canvas" width="1565" height="650"></canvas>

    <div class="d-flex align-items-center justify-content-start py-2">
        <button id="clear-pad" class="btn btn-sm btn-primary">Clear</button>
        <button id="save-signature" class="btn btn-sm btn-success mx-3">Save to Pdf</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>

    <script>
        $(document).ready(function() {
            const {
                jsPDF
            } = window.jspdf;
            var canvas = $('#canvas')[0];

            var signaturePad = new SignaturePad(canvas, {
                minWidth: 2.5,
            });

            function clearCanvas() {
                signaturePad.clear();
            }

            function saveAsPDF() {
                var dataURL = signaturePad.toDataURL();
                var doc = new jsPDF();
                var leftMargin = 10; // in mm
                var topMargin = 10; // in mm
                var imageWidth = doc.internal.pageSize.getWidth() - 2 * leftMargin;
                var imageHeight = imageWidth * (canvas.height / canvas.width);
                doc.addImage(dataURL, 'PNG', leftMargin, topMargin, imageWidth, imageHeight);
                doc.save('draw_' + Date.now() + '.pdf');
            }

            $('#clear-pad').on('click', function() {
                clearCanvas();
            });

            $('#save-signature').on('click', function() {
                saveAsPDF();
            });

        });
    </script>
@endsection
