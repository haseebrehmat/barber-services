@extends('admin.admin_layouts')
@section('admin_content')
    <style>
        .card-body {
            position: relative;
        }

        .badge {
            position: absolute;
            top: 0;
            right: 0;
            background-color: red;
            color: white;
            padding: 0.35rem;
            font-size: 1rem;
        }
    </style>

    <h1 class="h3 mb-3 text-gray-800">Update Admin BercoTool Images (Max size: 5 MBs)</h1>

    <form action="{{ url('superadmin/post_bercotool_images') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow">

            <div class="row card-body d-flex align-items-baseline">
                
            </div>
            <div class="row card-body d-flex align-items-baseline col-md-6">
                <span>Tools Text font-size</span>
                    @php
                        $generalSetting = App\Models\Admin\GeneralSetting::where('id', 1)->select('too_font_size')->first();
                        
                    @endphp
                    <input type="text" value="{{$generalSetting->too_font_size}}" name="too_font_size" id="" class="form-control">
            </div>
            <div class="row card-body d-flex align-items-baseline">
                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_1" accept="image/*">
                    <span>BercoWeb</span>
                    @php
                        $text=App\Models\ToolText::where('id',1)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="1" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="1_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="1" @if (in_array(1, $enabled_tools)) checked @endif>
                    @if (in_array(1, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ asset("public/uploads/$general_settings_global->bercotool_1") }}" alt="">
                </div>

                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_2" accept="image/*">
                    <span>BercoStore</span>
                    @php
                        $text=App\Models\ToolText::where('id',2)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="2" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="2_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="2" @if (in_array(2, $enabled_tools)) checked @endif>
                    @if (in_array(2, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ asset("public/uploads/$general_settings_global->bercotool_2") }}" alt="">
                </div>
            </div>

            <div class="row card-body d-flex align-items-baseline">
                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_3" accept="image/*">
                    <span>Bersubscribe</span>
                    @php
                        $text=App\Models\ToolText::where('id',3)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="3" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="3_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="3" @if (in_array(3, $enabled_tools)) checked @endif>
                    @if (in_array(3, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ asset("public/uploads/$general_settings_global->bercotool_3") }}" alt="">
                </div>

                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_4" accept="image/*">
                    <span>BercoManage</span>
                    @php
                        $text=App\Models\ToolText::where('id',4)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="4" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="4_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="4" @if (in_array(4, $enabled_tools)) checked @endif>
                    @if (in_array(4, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ asset("public/uploads/$general_settings_global->bercotool_4") }}" alt="">
                </div>
            </div>

            <div class="row card-body d-flex align-items-baseline">
                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_5" accept="image/*">
                    <span>BercoLand</span>
                    @php
                        $text=App\Models\ToolText::where('id',5)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="5" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="5_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="5" @if (in_array(5, $enabled_tools)) checked @endif>
                    @if (in_array(5, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ asset("public/uploads/$general_settings_global->bercotool_5") }}" alt="">
                </div>

                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_6" accept="image/*">
                    <span>ExcelLeads</span>
                    @php
                        $text=App\Models\ToolText::where('id',6)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="6" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="6_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="6" @if (in_array(6, $enabled_tools)) checked @endif>
                    @if (in_array(6, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ asset("public/uploads/$general_settings_global->bercotool_6") }}" alt="">
                </div>
            </div>

            <div class="row card-body d-flex align-items-baseline">
                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_7" accept="image/*">
                    <span>BercoNote</span>
                    @php
                        $text=App\Models\ToolText::where('id',7)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="7" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="7_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="7" @if (in_array(7, $enabled_tools)) checked @endif>
                    @if (in_array(7, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ asset("public/uploads/$general_settings_global->bercotool_7") }}" alt="">
                </div>

                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_8" accept="image/*">
                    <span>BercoLeads</span>
                    @php
                        $text=App\Models\ToolText::where('id',8)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="8" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="8_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="8" @if (in_array(8, $enabled_tools)) checked @endif>
                    @if (in_array(8, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ asset("public/uploads/$general_settings_global->bercotool_8") }}" alt="">
                </div>
            </div>

            <div class="row card-body d-flex align-items-baseline">
                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_9" accept="image/*">
                    <span>BercoWord</span>
                    @php
                        $text=App\Models\ToolText::where('id',9)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="9" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="9_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="9"
                        @if (in_array(9, $enabled_tools)) checked @endif>
                    @if (in_array(9, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ asset("public/uploads/$general_settings_global->bercotool_9") }}" alt="">
                </div>

                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_10" accept="image/*">
                    <span>BercoBox</span>
                    @php
                        $text=App\Models\ToolText::where('id',10)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="10" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="10_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="10"
                        @if (in_array(10, $enabled_tools)) checked @endif>
                    @if (in_array(10, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ asset("public/uploads/$general_settings_global->bercotool_10") }}" alt="">
                </div>
            </div>

            <div class="row card-body d-flex align-items-baseline">
                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_11" accept="image/*">
                    <span>BercoBlog</span>
                    @php
                        $text=App\Models\ToolText::where('id',11)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="11" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="11_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="11"
                        @if (in_array(11, $enabled_tools)) checked @endif>
                    @if (in_array(11, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ asset("public/uploads/$general_settings_global->bercotool_11") }}" alt="">
                </div>

                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_12" accept="image/*">
                    <span>BercoInvoice</span>
                    @php
                        $text=App\Models\ToolText::where('id',12)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="12" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="12_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="12"
                        @if (in_array(12, $enabled_tools)) checked @endif>
                    @if (in_array(12, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ asset("public/uploads/$general_settings_global->bercotool_12") }}" alt="">
                </div>

            </div>

            <div class="row card-body d-flex align-items-baseline">
                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_13" accept="image/*">
                    <span>Chat with Employees</span>
                    @php
                        $text=App\Models\ToolText::where('id',13)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="13" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="13_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="13"
                        @if (in_array(13, $enabled_tools)) checked @endif>
                    @if (in_array(13, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ isset($general_settings_global->bercotool_13) ? asset("public/uploads/$general_settings_global->bercotool_13") : 'https://placehold.co/640x360?text=Chat+with+Employees' }}"
                        alt="">
                </div>

                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_14" accept="image/*">
                    <span>Chat with Customers</span>
                    @php
                        $text=App\Models\ToolText::where('id',14)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="14" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="14_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="14"
                        @if (in_array(14, $enabled_tools)) checked @endif>
                    @if (in_array(14, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ isset($general_settings_global->bercotool_14) ? asset("public/uploads/$general_settings_global->bercotool_14") : 'https://placehold.co/640x360?text=Chat+with+Customers' }}"
                        alt="">
                </div>

            </div>

            <div class="row card-body d-flex align-items-baseline">
                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_15" accept="image/*">
                    <span>Reservations</span>
                    @php
                        $text=App\Models\ToolText::where('id',15)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="15" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="15_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="15"
                        @if (in_array(15, $enabled_tools)) checked @endif>
                    @if (in_array(15, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ isset($general_settings_global->bercotool_15) ? asset("public/uploads/$general_settings_global->bercotool_15") : 'https://placehold.co/640x360?text=Reservations' }}"
                        alt="">
                </div>

                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_16" accept="image/*">
                    <span>Appointments</span>
                    @php
                        $text=App\Models\ToolText::where('id',16)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="16" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="16_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="16"
                        @if (in_array(16, $enabled_tools)) checked @endif>
                    @if (in_array(16, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ isset($general_settings_global->bercotool_16) ? asset("public/uploads/$general_settings_global->bercotool_16") : 'https://placehold.co/640x360?text=Appointments' }}"
                        alt="">
                </div>

            </div>


            <div class="row card-body d-flex align-items-baseline">
                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_17" accept="image/*">
                    <span>Registered Customers</span>
                    @php
                        $text=App\Models\ToolText::where('id',17)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="17" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="17_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="17"
                        @if (in_array(17, $enabled_tools)) checked @endif>
                    @if (in_array(17, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ isset($general_settings_global->bercotool_17) ? asset("public/uploads/$general_settings_global->bercotool_17") : 'https://placehold.co/640x360?text=Registered+Customers' }}"
                        alt="">
                </div>

                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_18" accept="image/*">
                    <span>Display Orders</span>
                    @php
                        $text=App\Models\ToolText::where('id',18)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="18" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="18_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="18"
                        @if (in_array(18, $enabled_tools)) checked @endif>
                    @if (in_array(18, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ isset($general_settings_global->bercotool_18) ? asset("public/uploads/$general_settings_global->bercotool_18") : 'https://placehold.co/640x360?text=Display+Orders' }}"
                        alt="">
                </div>

            </div>

            <div class="row card-body d-flex align-items-baseline">
                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_19" accept="image/*">
                    <span>Contact Form information</span>
                    @php
                        $text=App\Models\ToolText::where('id',19)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="19" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="19_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="19"
                        @if (in_array(19, $enabled_tools)) checked @endif>
                    @if (in_array(19, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ isset($general_settings_global->bercotool_19) ? asset("public/uploads/$general_settings_global->bercotool_19") : 'https://placehold.co/640x360?text=Contact+Form+information' }}"
                        alt="">
                </div>


                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_20" accept="image/*">
                    <span>Video Conference</span>
                    @php
                        $text=App\Models\ToolText::where('id',20)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="20" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="20_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="20"
                        @if (in_array(20, $enabled_tools)) checked @endif>
                    @if (in_array(20, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ isset($general_settings_global->bercotool_20) ? asset("public/uploads/$general_settings_global->bercotool_20") : 'https://placehold.co/640x360?text=Video+Conference' }}"
                        alt="">
                </div>

               

            </div>

            <div class="row card-body d-flex align-items-baseline">
                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_21" accept="image/*">
                    <span>Emailer</span>
                    @php
                        $text=App\Models\ToolText::where('id',21)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="21" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="21_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="21"
                        @if (in_array(21, $enabled_tools)) checked @endif>
                    @if (in_array(21, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ isset($general_settings_global->bercotool_21) ? asset("public/uploads/$general_settings_global->bercotool_21") : 'https://placehold.co/640x360?text=Emailer' }}"
                        alt="">
                </div>


                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_22" accept="image/*">
                    <span>Projects</span>
                    @php
                        $text=App\Models\ToolText::where('id',22)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="22" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="22_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="22"
                        @if (in_array(22, $enabled_tools)) checked @endif>
                    @if (in_array(22, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ isset($general_settings_global->bercotool_22) ? asset("public/uploads/$general_settings_global->bercotool_22") : 'https://placehold.co/640x360?text=Projects' }}"
                        alt="">
                </div>
                
            </div>


            <div class="row card-body d-flex align-items-baseline">
                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_23" accept="image/*">
                    <span>Stats</span>
                    @php
                        $text=App\Models\ToolText::where('id',23)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="23" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="23_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="23"
                        @if (in_array(23, $enabled_tools)) checked @endif>
                    @if (in_array(23, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ isset($general_settings_global->bercotool_23) ? asset("public/uploads/$general_settings_global->bercotool_23") : 'https://placehold.co/640x360?text=Stats' }}"
                        alt="">
                </div>



                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_24" accept="image/*">
                    <span>Coupons</span>
                    @php
                        $text=App\Models\ToolText::where('id',24)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="24" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="24_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="24"
                        @if (in_array(24, $enabled_tools)) checked @endif>
                    @if (in_array(24, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ isset($general_settings_global->bercotool_24) ? asset("public/uploads/$general_settings_global->bercotool_24") : 'https://placehold.co/640x360?text=Coupons' }}"
                        alt="">
                </div>
                
            </div>



            <div class="row card-body d-flex align-items-baseline">
                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_25" accept="image/*">
                    <span>Facebook</span>
                    @php
                        $text=App\Models\ToolText::where('id',25)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="25" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="25_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="25"
                        @if (in_array(25, $enabled_tools)) checked @endif>
                    @if (in_array(25, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ isset($general_settings_global->bercotool_25) ? asset("public/uploads/$general_settings_global->bercotool_25") : 'https://placehold.co/640x360?text=Facebook' }}"
                        alt="">
                </div>



                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_26" accept="image/*">
                    <span>Instagram</span>
                    @php
                        $text=App\Models\ToolText::where('id',26)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="26" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="26_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="26"
                        @if (in_array(26, $enabled_tools)) checked @endif>
                    @if (in_array(26, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ isset($general_settings_global->bercotool_26) ? asset("public/uploads/$general_settings_global->bercotool_26") : 'https://placehold.co/640x360?text=Instagram' }}"
                        alt="">
                </div>
                
            </div>

            <div class="row card-body d-flex align-items-baseline">
                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_27" accept="image/*">
                    <span>Facebook</span>
                    @php
                        $text=App\Models\ToolText::where('id',27)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="27" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="27_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="27"
                        @if (in_array(27, $enabled_tools)) checked @endif>
                    @if (in_array(27, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ isset($general_settings_global->bercotool_27) ? asset("public/uploads/$general_settings_global->bercotool_27") : 'https://placehold.co/640x360?text=Follow Up Customer' }}"
                        alt="">
                </div>

                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_28" accept="image/*">
                    <span>Flyers</span>
                    @php
                        $text=App\Models\ToolText::where('id',28)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="28" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="28_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="28"
                        @if (in_array(28, $enabled_tools)) checked @endif>
                    @if (in_array(28, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ isset($general_settings_global->bercotool_28) ? asset("public/uploads/$general_settings_global->bercotool_28") : 'https://placehold.co/640x360?text=Flyers' }}"
                        alt="">
                </div>
                
            </div>
            <div class="row card-body d-flex align-items-baseline">
                <div class="form-group d-flex flex-column col-md-2">
                    <input type="file" name="bercotool_29" accept="image/*">
                    <span>Hiring Candidates</span>
                    @php
                        $text=App\Models\ToolText::where('id',29)->first();
                    @endphp
                    <input type="text" value="{{$text->text}}" name="29" id="" class="form-control">
                    <input type="text" value="{{$text->width}}" name="29_width" id="" class="form-control">
                </div>
                <div class="col-md-2">
                    <input type="checkbox" name="codes[]" value="29"
                        @if (in_array(29, $enabled_tools)) checked @endif>
                    @if (in_array(29, $enabled_tools))
                        Uncheck to Enable
                    @else
                        Check to Disable
                    @endif
                </div>
                <div class="col-md-2">
                    <img style="width:100px; height:100px;"
                        src="{{ isset($general_settings_global->bercotool_29) ? asset("public/uploads/$general_settings_global->bercotool_29") : 'https://placehold.co/640x360?text=Hiring Candidates' }}"
                        alt="">
                </div> 
                
            </div>


            <br>
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-primary">Upload BercoTool Images</button>
            </div>
            <br>

        </div>

    </form>
    <br> <br><br>
@endsection
