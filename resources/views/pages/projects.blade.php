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

</style>
@include('sliders')

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {!! $project->detail !!}
                </div>
            </div>
            <div class="row project pt_0 pb_0">
                @foreach($project_items as $row)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="project-item wow fadeInUp mb_30">
                            <div class="photo">
                                <a href="{{ url('project/'.$row->project_slug) }}"><img src="{{ asset('public/uploads/'.$row->project_featured_photo) }}" alt=""></a>
                            </div>
                            <div class="text">
                                <h3><a href="{{ url('project/'.$row->project_slug) }}">{{ $row->project_name }}</a></h3>
                                <p>{{ $row->project_content_short }}</p>
                                <div class="read-more">
                                    <a href="{{ url('project/'.$row->project_slug) }}">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12">
                    {{ $project_items->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
