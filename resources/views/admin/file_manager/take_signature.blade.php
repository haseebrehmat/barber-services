<!DOCTYPE html>
<html>

<head>
    <title>Signature Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <style>
        html {
            height: 100%;
        }

        body {
            padding-inline: 3.5rem;
            padding-block: 2rem;
            background-size: 100% 100%;
            background-repeat: no-repeat;
            color: #fff;
        }

        .bg-gray {
            background-color: rgb(235, 235, 235);
        }

        #canvas {
            border: 1px solid rgba(0, 0, 0, 0.329);
        }
    </style>
</head>

<body>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container-fluid">

        <div class="row">
            <h6 class="font-weight-bold text-info">Read the document</h6>
            <iframe src="{{ asset('public/storage/' . $file->hashname) }}#toolbar=0" width="100%"
                height="800px"></iframe>
        </div>

        <div class="row justify-content-center">
            <div class="p-4 rounded">
                <h6 class="m-0 my-4 font-weight-bold text-info">Add your signature and save it.</h6>

                <form action="{{ route('signature.save', ['id' => $file->id]) }}" method="post" id="signature-form"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="signature" id="signature-input">

                    <div class="bg-gray">
                        <canvas id="canvas" width="700" height="300"></canvas>
                    </div>

                    <div class="d-flex align-items-center justify-content-start py-2">
                        <button id="clear-pad" class="btn btn-sm btn-primary w-25">Clear</button>
                        <button id="save-signature" class="btn btn-sm btn-success mx-3 w-25">Save</button>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    {{-- Signature Pad & JsPDF --}}
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

                $('#signature-input').val(dataURL);

                $('#signature-form').submit();

                // doc.save('draw_' + Date.now() + '.pdf');
            }

            $('#clear-pad').on('click', function() {
                clearCanvas();
            });

            $('#save-signature').on('click', function() {
                saveAsPDF();
                $('#signature-form').submit();
            });

        });
    </script>
</body>

</html>
