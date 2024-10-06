@extends('admin.admin_layouts')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Video Conferences</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">Video Conferences</h6>
            <div class="float-right d-inline">
                <a href="{{ route('admin.video_conference_create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add New</a>
            </div>
        </div>
        <div class="card-body">
           
            <div id="jitsi-container"></div>
        </div>
        
    </div>
    <script src="https://meet.jit.si/external_api.js"></script>
    <script>
        const domain = 'meet.jit.si';
        const options = {
          roomName: 'vpaas-magic-cookie-60f58e263ab142d79da080220de7ebc7/{{$link}}',
 
          height: 600,
          parentNode: document.querySelector('#jitsi-container'),
        };
        const api = new JitsiMeetExternalAPI(domain, options);
      </script>
@endsection
