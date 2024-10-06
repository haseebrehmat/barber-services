@extends('layouts.app')

@section('content')
    
<style>
    .slider-item__backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6); /* Change the opacity value to adjust the darkness of the backdrop */
}



.view {
  height: 100%;
}

#mobile-box {
  width: 360px;
}

.card {
  -webkit-border-radius: 10px;
  border-radius: 10px;
}

.card .view {
  -webkit-border-top-left-radius: 10px;
  border-top-left-radius: 10px;
  -webkit-border-top-right-radius: 10px;
  border-top-right-radius: 10px;
}

.card h5 a {
  color: #0d47a1;
}

.card h5 a:hover {
  color: #072f6b;
}

#pButton {
  float: left;
}

#timeline {
  width: 90%;
  height: 2px;
  margin-top: 20px;
  margin-left: 10px;
  float: left;
  -webkit-border-radius: 15px;
  border-radius: 15px;
  background: rgba(0, 0, 0, 0.3);
}

#pButton {
  margin-top: 12px;
  cursor: pointer;
}

#playhead {
  width: 8px;
  height: 8px;
  -webkit-border-radius: 50%;
  border-radius: 50%;
  margin-top: -3px;
  background: black;
  cursor: pointer;
}

</style>
        <div class="feature">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="heading wow fadeInUp">
                            <h2>{{ $page_home->audio_title }}</h2>
                            <h3>{{ $page_home->audio_subtitle }}</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($music as $row)
                    <div class="col-md-4" >
                        @if ($row->upload_type=='embed')
                            {!! $row->link !!}
                        @endif
                
                        @if ($row->upload_type=='upload')
                            <!-- Content -->
                            <div id="mobile-box">
                                <!-- Card -->
                                <div class="card">
                                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                        <img style="height: 300px;" class="card-img-top" src="{{ asset('public/uploads/' . $row->image) }}"
                                            alt="Card image cap">
                                        <a href="#!">
                                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                        </a>
                                    </div>
                                    <div class="card-body text-center">
                                        <p class="mb-0">{{$row->title}}</p>
                                        <audio controls>
                                            <source src="{{ asset('public/uploads/' . $row->sound) }}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                </div>
                                <!-- Card -->
                            </div>
                            <!-- Content -->
                        @endif
                    </div>
                    @endforeach
                </div>
                
            </div>
        </div>
@endsection
