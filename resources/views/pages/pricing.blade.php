@extends('layouts.app')

@section('content')
    <style>
        .slider-item__backdrop {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            /* Change the opacity value to adjust the darkness of the backdrop */
        }
    </style>
    <style>
        .rounded-1 {
            border-radius: 10px 10px 0px 0px !important;
        }

        .bold {
            font-weight: bolder !important;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .italic {
            font-style: italic;
        }
    </style>

    <div class="container-fluid">
        @if ($page_home->pricing_status == 'Show')
            <div class="team">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="heading wow fadeInUp">
                                <h2>{{ $page_home->pricing_title }}</h2>
                                <h3>{{ $page_home->pricing_subtitle }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="team-carousel owl-carousel">

                                @foreach ($pricing_options as $row)
                                    <div class="team-item wow fadeInUp">
                                        <div class="team-text rounded-top rounded-1 py-4">
                                            <h4 class="uppercase">{{ $row->title }}</h4>
                                            <small class="italic">{{ $row->subtitle }}</small>
                                            <div class="d-flex justify-content-center align-items-end">
                                                <h4 class="bold">{{ $row->currency }}{{ number_format($row->price) }}
                                                </h4>
                                                <small>/ {{ $row->format }}</small>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column p-4">
                                            @forelse ($row->features as $key=> $item)
                                                <div class="d-flex align-items-center mb-3">
                                                    @foreach ($row->tick_cross as $key1=> $item1)
                                                        @if ($key==$key1)
                                                            @if ($item1=='tick')
                                                                <i class="fas fa-check-circle" style="font-size: 20px;color: green;"></i>
                                                            @endif
                                                            @if ($item1=='cross')
                                                                <i class="fas fa-times-circle" style="font-size: 20px;color: red;"></i>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    {{-- <i class="fas fa-check-circle" style="font-size: 20px;color: #4D0101 !important;"></i> --}}
                                                    <span class="ml-2">{{ $item }}</span>
                                                </div>
                                            @empty
                                                <span>No feature found</span>
                                            @endforelse
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection
