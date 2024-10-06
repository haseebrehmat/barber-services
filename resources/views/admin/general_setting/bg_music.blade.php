@extends('admin.admin_layouts')
@section('admin_content')
    <style>
        .audio-player {
            width: 100%;
            background-color: #c3f0df;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }

        audio {
            width: 100%;
        }

        audio::-webkit-media-controls-play-button {
            background-color: #1cc88a;
            color: white;
            border-radius: 50%;
            height: 35px;
            margin-right: 10px;
            font-size: 24px;
        }

        audio::-webkit-media-controls-progress {
            background-color: #1cc88a;
        }
    </style>

    <h1 class="h3 mb-3 text-gray-800">Edit Background Music Information</h1>

    <form action="{{ url('admin/setting/general/bg_music/update') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="current_music" value="{{ $general_setting->bg_music }}">

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        @if (isset($general_setting->bg_music))
                            <div class="form-group w-100">
                                <label for="">Current Background Music</label>
                                <div class="audio-player">
                                    <audio controls>
                                        <source src="{{ asset('public/uploads/' . $general_setting->bg_music) }}"
                                            type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="">Change Background Music</label>
                            <div>
                                <input type="file" name="bg_music" class="form-control">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('admin.general_setting.bg_music.delete') }}" class="btn btn-primary mt-30" onclick="return confirmDelete();">
                            <i class="fas fa-trash"></i> Delete Sound
                        </a>                         
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        function confirmDelete() {
            // Display a confirmation dialog
            var confirmation = confirm("Are you sure you want to delete?");
            
            // If the user confirms, proceed with the link
            if (confirmation) {
                return true;
            }
            
            // If the user cancels, prevent the link from navigating
            return false;
        }
    </script>
@endsection
