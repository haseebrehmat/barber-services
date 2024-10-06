@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Compose Document and Export to PDF if needed.</h1>

    <div class="card shadow mb-4 p-2">
        <form action="{{ route('admin.compose_document.save') }}" method="post">
            @csrf
            <input type="hidden" name="id" id="doc-id">

            <div class="h6">Document Title</div>

            <input type="text" name="title" id="doc-title" placeholder="Please enter title there" class="form-control">

            <hr>

            <textarea id="compose-doc" name="message">
                Compose your document here, Thanks!
            </textarea>

            <div class="text-center">
                <button class="btn btn-primary mt-2 px-5" type="submit">Save</button>
            </div>

        </form>
    </div>

    <div class="card shadow my-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">Composed Documents</h6>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($documents as $row)
                    <div class="col-md-4">
                        <div class="card border-secondary m-3">
                            <div class="card-body">
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($row->title, 100, $end = '...') }}
                                </p>
                                <div class="float-right d-flex align-items-center">
                                    <button class="btn btn-sm btn-info mr-2" onclick="editDoc(this)"
                                        data-id="{{ $row->id }}" data-msg="{{ $row->message }}"
                                        data-title="{{ $row->title }}">Edit</button>
                                    <a href="{{ URL::to('delete/compose_document/' . $row->id) }}"
                                        class="btn btn-danger btn-sm" onClick="return confirm('Are you sure?');">Delete</a>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <script src="https://cdn.tiny.cloud/1/ke6kl5fbofw7k5ek2q1zhsfknxjearp8ybyz4cd3nzdhaqng/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        $(document).ready(function() {
            tinymce.init({
                selector: '#compose-doc',
                relative_urls: false,
                convert_urls: false,
                remove_script_host : false,
                height: "500",
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo export redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                tinycomments_mode: 'embedded',
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

        function editDoc(e) {
            var editor = tinymce.get('compose-doc');
            editor.setContent($(e).data('msg'));
            $("#doc-id").val($(e).data('id'));
            $("#doc-title").val($(e).data('title'));
        }
    </script>

    {{-- Previous Code of Faizan Bhai --}}
    {{-- <div class="card shadow mb-4">
        <!DOCTYPE html>
        <html>
        <head>
          <script src="https://cdn.tiny.cloud/1/ke6kl5fbofw7k5ek2q1zhsfknxjearp8ybyz4cd3nzdhaqng/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
        </head>
        <body>
          <textarea>
            Compose your document here, Thanks!
          </textarea>
          <script>
            tinymce.init({
              selector: 'textarea',
              height : "700",u
              plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
              toolbar: 'undo export redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
              tinycomments_mode: 'embedded',
              tinycomments_author: 'Author name',
              mergetags_list: [
                { value: 'First.Name', title: 'First Name' },
                { value: 'Email', title: 'Email' },
              ],
            });
          </script>
        </body>
        </html>
    </div> --}}
@endsection
