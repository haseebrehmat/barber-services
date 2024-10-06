<script src="{{ asset('public/backend/js/sb-admin-2.min.js') }}"></script>
<script src="{{ asset('public/backend/js/custom.js') }}"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script src="{{ asset('public/frontend/js/select2.full.js') }}"></script>

<script>
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            toastr.error('{{ $error }}');
        </script>
    @endforeach
@endif

@if(session()->get('error'))
    <script>
        toastr.error('{{ session()->get('error') }}');
    </script>
@endif

@if(session()->get('success'))
    <script>
        toastr.success('{{ session()->get('success') }}');
    </script>
@endif

{{-- <script>
    var editor1 = new RichTextEditor(".input_editor");
</script> --}}
<script src="https://cdn.tiny.cloud/1/wmdjguceo5alnkqqfjwwwnu8pbkp0be0pvhyc6nyecqyd4gs/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        $(document).ready(function() {
            tinymce.init({
                selector: '.input_editor',
                relative_urls: false,
                convert_urls: false,
                remove_script_host : false,
                height: "500",
                plugins: 'anchor autolink charmap codesample emoticons image link lists  searchreplace table visualblocks wordcount code fullpage',
                toolbar: 'undo export redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image  table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat | code',
                tinycomments_mode: 'embedded',
                cleanup: false,
                valid_elements: '*[*]',
                valid_children: "+body[style]",
                images_upload_url: '/upload-image',

                tinycomments_author: 'Author name',

                mergetags_list: [{
                        value: 'First.Name',
                        title: 'First Name'
                    },
                    {
                        value: 'Email',
                        title: 'Email'
                    },
                ],
            });
        });
    </script>

<script>
    function exportToExcel(id, type, filename) {
        var elt = document.getElementById(id);
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
        return XLSX.writeFile(wb, filename || ('export.' + (type || 'xlsx')));
    }
</script>
