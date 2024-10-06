@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">File Manager</h1>

    <div id="uploader"></div>

    <div class="card shadow my-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">View Uploaded Files</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>File</th>
                            <th>Extension</th>
                            <th>Size in MBs</th>
                            <th>Added On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($files as $file)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if (in_array($file->extension, ['png', 'jpg', 'jpeg']))
                                        <img src="{{ asset('storage/app/public/' . $file->hashname) }}"
                                            alt="{{ $file->filename }}" class="w_200">
                                    @else
                                        <span class="d-flex align-items-center">
                                            {{ $file->filename }}
                                            @if ($file->extension == 'pdf' && $file->signature)
                                                <a href="{{ asset('storage/app/public/' . $file->signature) }}" target="_blank"
                                                    class="border border-info rounded-pill px-3 mx-2 py-1 text-muted">
                                                    <i class="fas fa-file-signature"></i>
                                                    Signed on:
                                                    <small>
                                                        {{ \Carbon\Carbon::parse($file->updated_at)->format('d/m/Y h:i A') }}
                                                    </small>
                                                </a>
                                            @endif
                                        </span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $file->extension }}</td>
                                <td class="text-muted">
                                    @php
                                        $sizeInMB = round($file->size / 1048576, 2);
                                        if ($sizeInMB < 1) {
                                            $size = round($file->size / 1024, 2) . ' KB';
                                        } else {
                                            $size = $sizeInMB . ' MB';
                                        }
                                    @endphp
                                    {{ $size }}
                                </td>
                                <td class="text-muted">{{ \Carbon\Carbon::parse($file->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    @if (in_array($file->extension, ['png', 'jpg', 'jpeg', 'pdf']))
                                        <a href="{{ asset('storage/app/public/' . $file->hashname) }}" target="_blank"
                                            class="btn btn-success btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif
                                    <a href="{{ asset('storage/app/public/' . $file->hashname) }}" download
                                        class="btn btn-info btn-sm">
                                        <i class="fas fa-arrow-alt-circle-down"></i>
                                    </a>
                                    <button class="btn btn-success btn-sm copy-link" data-link="{{ asset('storage/app/public/' . $file->hashname) }}">
                                        <i class="fas fa-copy"></i> Copy Link
                                    </button>
                                    <a href="{{ route('file-manager.remove', ['id' => $file->id, 'name' => $file->hashname]) }}"
                                        class="btn btn-secondary btn-sm" onClick="return confirm('Are you sure?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    @if ($file->extension == 'pdf')
                                        <a href="{{ route('signature.take', ['id' => $file->id]) }}" target="_blank"
                                            class="btn btn-light btn-sm border border-danger rounded-circle text-danger">
                                            <i class="fas fa-share-alt"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('public/frontend/js/5x5jqpi.min.js') }}"></script>

    <script>
        $(function() {

            $("#uploader").initUploader({
                destination: "{{ route('file-manager.upload') }}",
                destinationParams: {
                    '_token': "{{ csrf_token() }}"
                },
                fileLimit: 10,
                sizeLimit: 50, // In MBs
                postFn: function(e) {
                    setTimeout(() => {
                        document.location.reload();
                    }, 1000);
                }
            });
        });
    </script>
    <script>
        document.querySelectorAll('.copy-link').forEach(button => {
            button.addEventListener('click', function() {
                const linkToCopy = this.getAttribute('data-link');
                
                // Create a temporary input element to copy the link
                const input = document.createElement('input');
                input.value = linkToCopy;
                document.body.appendChild(input);
    
                // Select and copy the text in the input element
                input.select();
                document.execCommand('copy');
    
                // Remove the temporary input element
                document.body.removeChild(input);
    
                // Change the button text to indicate success
                this.innerHTML = '<i class="fas fa-check"></i> Copied';
    
                // Optional: Reset the button text after a few seconds
                setTimeout(() => {
                    this.innerHTML = '<i class="fas fa-copy"></i> Copy Link';
                }, 2000);
            });
        });
    </script>
    

    {{-- <div id="file-manager">
        <form action="{{ route('file-manager.upload') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file">
            <button type="submit">Upload</button>
        </form>

    </div> --}}

    {{-- One Level Folder Creation --}}
    {{-- <form action="{{ route('file-manager.create-folder') }}" method="post">
    @csrf
    <input type="text" name="folder" placeholder="Folder name" value="{{ old('folder') }}">
    <button type="submit">Create folder</button>
</form> --}}
@endsection
