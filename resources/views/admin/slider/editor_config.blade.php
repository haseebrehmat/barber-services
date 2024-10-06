<script src="https://cdn.tiny.cloud/1/ke6kl5fbofw7k5ek2q1zhsfknxjearp8ybyz4cd3nzdhaqng/tinymce/6/tinymce.min.js"
    referrerpolicy="origin"></script>

<script>
    $(document).ready(function() {
            tinymce.init({
                selector: '.tinymce_editor',
                relative_urls: false,
                convert_urls: false,
                remove_script_host : false,
                height: "200",
                menubar: false,
                plugins: 'wordcount',
                toolbar: 'undo export redo | bold italic underline strikethrough',
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
</script>
