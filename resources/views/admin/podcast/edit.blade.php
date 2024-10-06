@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Add Podcast Item</h1>

    <form action="{{ url('admin/podcast/update/'.$podcast->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary">Add Podcast Item</h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin.podcast.index') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> View All</a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="upload_type">Choose Upload Type:</label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="upload_song" name="upload_type" value="upload" @if ($podcast->upload_type=='upload')checked @endif>
                        <label class="form-check-label" for="upload_song">Upload From PC</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="embed_code" name="upload_type" value="embed" @if ($podcast->upload_type=='embed')checked @endif>
                        <label class="form-check-label" for="embed_code">Insert Embed Code</label>
                    </div>
                </div>

                <div class="form-group" id="title_cover_sound" style="display: block;">
                    <label for="name">Title *</label>
                    <input type="text" name="title" class="form-control" value="{{$podcast->title}}" autofocus >
                    
                    <label for="image">Cover Photo *</label>
                    <div>
                    
                        <input  type="file" name="image" accept="image/*" >
                    </div>
                    
                    <label for="sound">Sound File *</label>
                    <div>
                        <input type="file" name="sound" accept="audio/*" >
                    </div>
                </div>
                

                <div class="form-group" id="embed_link" style="display: none;">
                    <label for="link">Embed Sound Code *</label>
                    <input type="text" name="link" class="form-control" value="{{$podcast->link}}">
                </div>
                
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>

    <script>
        // JavaScript to show/hide form fields based on radio button selection
        const uploadSongRadio = document.getElementById('upload_song');
        const embedCodeRadio = document.getElementById('embed_code');
        const titleCoverSoundFields = document.getElementById('title_cover_sound');
        const embedLinkField = document.getElementById('embed_link');
        const linkInput = document.querySelector('input[name="link"]');

        // Function to set or remove the required attribute based on radio button selection
        function setRequiredAttribute(element, isRequired) {
            if (isRequired) {
                element.setAttribute('required', 'required');
            } else {
                element.removeAttribute('required');
            }
        }

        uploadSongRadio.addEventListener('change', () => {
            titleCoverSoundFields.style.display = 'block';
            embedLinkField.style.display = 'none';

            // Set fields as required when "Upload From PC" is selected
            setRequiredAttribute(document.querySelector('input[name="name"]'), true);
            setRequiredAttribute(document.querySelector('input[name="image"]'), true);
            setRequiredAttribute(document.querySelector('input[name="sound"]'), true);

            // Remove required attribute from Embed Sound Link
            setRequiredAttribute(linkInput, false);
        });

       // Define a function to handle the changes
        function handleEmbedCodeChange() {
            titleCoverSoundFields.style.display = 'none';
            embedLinkField.style.display = 'block';

            // Remove required attribute from title, cover photo, and sound file
            setRequiredAttribute(document.querySelector('input[name="name"]'), false);
            setRequiredAttribute(document.querySelector('input[name="image"]'), false);
            setRequiredAttribute(document.querySelector('input[name="sound"]'), false);

            // Set Embed Sound Link as required when "Insert Embed Code" is selected
            setRequiredAttribute(linkInput, true);
        }

        // Add the event listener for the change event
        embedCodeRadio.addEventListener('change', handleEmbedCodeChange);

        // Call the function when the page loads if the radio button is already selected
        if (embedCodeRadio.checked) {
            handleEmbedCodeChange();
        }

    </script>
@endsection
