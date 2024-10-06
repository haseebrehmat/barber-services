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
                    {!! $blog->detail !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="single-section">

                        @foreach($blog_items as $row)
                            <div class="blog-item">
                                <div class="featured-photo">
                                    <a href="{{ url('blog/'.$row->id) }}"><img src="{{ asset('public/uploads/'.$row->blog_photo) }}"></a>
                                </div>
                                <div class="text">
                                    <h2><a href="{{ url('blog/'.$row->id) }}">{{ $row->blog_title }}</a></h2>
                                    <p>
                                        {!! nl2br(e($row->blog_content_short)) !!}
                                    </p>
                                    <div class="read-more">
                                        <a href="{{ url('blog/'.$row->id) }}">Read More</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <div>
                        {{ $blog_items->links() }}
                    </div>
                </div>
                <div class="col-md-4">
                    @include('layouts.sidebar_blog')
                </div>
            </div>
        </div>
    </div>

@endsection
