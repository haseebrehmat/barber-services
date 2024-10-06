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
                    {!! $about->detail !!}
                </div>
            </div>
        </div>
    </div>
@endsection
