{{-- using simple canvas --}}

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
    <canvas id="canvas" width="1565" height="700"></canvas>
    <button id="clear-pad" class="btn btn-sm btn-primary">Clear</button>
    <button id="save-signature" class="btn btn-sm btn-success">Save to Pdf</button>

    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>

    <script>
        $(document).ready(function() {
            const {
                jsPDF
            } = window.jspdf;
            var canvas = $('#canvas');
            var ctx = canvas[0].getContext('2d');
            var drawing = false;
            var lastX = 0;
            var lastY = 0;
            var penColor = "#000000";
            var penWidth = 2;


            canvas.on('mousedown', function(e) {
                drawing = true;
                lastX = e.clientX - canvas.offset().left;
                lastY = e.clientY - canvas.offset().top;
            });

            canvas.on('mousemove', function(e) {
                if (drawing) {
                    var currentX = e.clientX - canvas.offset().left;
                    var currentY = e.clientY - canvas.offset().top;
                    drawLine(lastX, lastY, currentX, currentY);
                    lastX = currentX;
                    lastY = currentY;
                }
            });

            canvas.on('mouseup', function(e) {
                drawing = false;
            });

            function drawLine(x1, y1, x2, y2) {
                ctx.beginPath();
                ctx.moveTo(x1, y1);
                ctx.lineTo(x2, y2);
                ctx.strokeStyle = penColor;
                ctx.lineWidth = penWidth;
                ctx.stroke();
                ctx.closePath();
            }

            function clearCanvas() {
                ctx.clearRect(0, 0, canvas.width(), canvas.height());
            }

            function saveAsPDF() {
                var image = canvas[0].toDataURL("image/png", 1.0);
                var doc = new jsPDF();
                var leftMargin = 10; // in mm
                var topMargin = 10; // in mm
                var imageWidth = doc.internal.pageSize.getWidth() - 2 * leftMargin;
                var imageHeight = imageWidth * (canvas.height() / canvas.width());
                doc.addImage(image, 'PNG', leftMargin, topMargin, imageWidth, imageHeight);
                doc.save('draw_' + Date.now() + '.pdf');
            }

            // this is scalling in pdf
            // function saveAsPDF2() {
            //     var scaleFactor = 0.2;
            //     var image = canvas[0].toDataURL("image/png", 1.0);
            //     var doc = new jsPDF();
            //     doc.addImage(image, 'PNG', 10, 10, canvas.width() * scaleFactor, canvas.height() * scaleFactor);
            //     doc.save('signature.pdf');
            // }


            $('#clear-pad').on('click', function() {
                clearCanvas();
            });

            $('#save-signature').on('click', function() {
                saveAsPDF();
            });
        });
    </script>
@endsection
