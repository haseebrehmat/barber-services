@if ($type=='color')

<!DOCTYPE html>
<html>
<head>
    <title>Landing Page</title>
    <!-- Bootstrap CSS -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: {{$setting->lpc_background}} ; /* Set background color */
            color: #fff; /* Set font color */
        }
        .nav {
            background-color: {{$setting->lpc_nav_color}}
        }
        .logo-container {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .logo {
            height: {{$setting->lpc_logo_pc_height}}px;
            width: {{$setting->lpc_logo_pc_width}}px;
        }
        .heading {
            /* text-align: justify;
            text-justify: inter-word; */
        }
        .form-container {
            margin-top: 1%;
        }
        .btn-custom {
            background-color: {{$setting->lpc_btn_color}};
            border-color: {{$setting->lpc_btn_color}};
            color: {{$setting->lpc_submit_text_color}};
            font-size: {{$setting->lpc_submit_text_font_size}};
            font-family: {{$setting->lpc_submit_text_font_family}};
        }
        .logo-border {
            border: 3px solid black;
        }
        .space-y > * + * {
            margin-top: 2rem;
        }
        .font-big {
            margin-top: -25px;
            font-size: 3rem;
        }

        .title_dynamic{
            color: {{$setting->lpc_title_color}};
            font-size: {{$setting->lpc_title_font_size}};
            font-family: {{$setting->lpc_title_font_family}};
            line-height: initial;
        }

        .title_text{
            color: {{$setting->lpc_title_text_color}};
            font-size: {{$setting->lpc_title_text_font_size}};
            font-family: {{$setting->lpc_title_text_font_family}};
        }

        .form_label{
            color: {{$setting->lpc_form_text_color}};
            font-size: {{$setting->lpc_form_text_font_size}};
            font-family: {{$setting->lpc_form_text_font_family}};
        }
        .left-bg {
            height: {{$setting->lpc_left_bg_height}}% !important;
            object-fit: fill;
        }

        .left-bg-wrapper {
            height: 85.5vh;
        }
        .left-margin {
            /* margin-left: 11%; */
        }
        .right-bg {
            background-size: cover;
            background-repeat: no-repeat;
            background-image: url('{{ asset("public/uploads/$setting->lpc_background") }}');
        }

        @media (max-width: 767px) {
            .d-flex {
                width: auto !important;
            }
        }
        @media only screen and (max-width: 767px) {
  .title_text {
    text-align: center;
    /* margin-left: -10%; */
  }
}
        @media (max-width: 767px) {
    .form-container {
        width: auto !important;
    }

    .form-container .rounded {
        width: 380px !important;
    }
    .left-margin {
        margin-left: 0;
    }
}

@media (max-width: 767px) {
    .bg-container {
        background-image: none !important;
    }
   
}
@media (max-width: 767px) {
    .logo-container {
        flex-wrap: wrap;
    }
    .logo {
        height: {{$setting->lpc_logo_mobile_height}}px;
        width: {{$setting->lpc_logo_mobile_width}}px;
    }
    .title_text {
        text-align: center;
    }

    .logo-container .col-md-4 {
        flex: 100%;
        max-width: 100%;
        text-align: center;
    }
    .left-bg {
        height: 400px !important;
        object-fit: cover;
    }
    .left-bg-wrapper {
        height: auto;
    }
    .right-bg {
        background: none;
    }
}
  /* Hide 'to_hide_on_desktop' div on screens wider than 768px (desktop) */
  @media only screen and (min-width: 769px) {
        #to_hide_on_desktop {
            display: none !important; /* Ensure importance */
        }
    }

    /* Hide 'to_hide_on_mobile' div on screens up to 768px (mobile) */
    @media only screen and (max-width: 768px) {
        #to_hide_on_mobile {
            display: none !important; /* Ensure importance */
        }
    }
@media only screen and (max-width: 767px) {
footer {
margin-top: 20px;
}
}

@if ($setting->lpc_centered=='1')
@media screen and (max-width: 767px) {
  .heading.font-big.title_dynamic {
    text-align: center;
  }
}
@else
@media screen and (max-width: 767px) {
  .heading.font-big.title_dynamic {
    text-align: left;
  }
}
@endif
    </style>
</head>
<body>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        
      
        <script>
            setTimeout(function(){
                window.location.href = "{{ route('homepage') }}";
            }, 2000); // 2000 milliseconds (2 seconds)
        </script>
    
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container-fluid p-0" style="width: 101%">
        <div class="nav">
            <div class="row logo-container justify-content-center align-items-center w-100">
                <div class="col-md-4">
                    <img src="{{ asset("public/uploads/$setting->lpc_logo") }}" alt="Logo" class="logo">
                </div>
                <div class="col-md-6">
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row align-items-basline">
                <div class="col-md-6 p-0 m-0 left-bg-wrapper" id="to_hide_on_desktop">
                    <img style="width: 101%!important;" src="{{ asset('public/uploads/'. $setting->lpc_left_bg) }}" alt="Left Image" class="w-100">
                </div>
                <div class="col-md-6 p-0 m-0 left-bg-wrapper" id="to_hide_on_mobile" style="display: flex; justify-content: center; align-items: center;">
                    <img id="faizan" style="width: {{$setting->lpc_left_bg_width}}%!important;" src="{{ asset('public/uploads/'. $setting->lpc_left_bg) }}" alt="Left Image" class="w-100 left-bg">
                </div>
                <div  class="col-md-6 pt-5 right-bg">
                    <div class="d-flex flex-column  align-items-center left-margin">
                        {{-- if not center  --}}

                        @if ($setting->lpc_centered=='0')
                            <div class="d-flex flex-column align-items-start" style="width:580px;">
                                <p class="heading font-big title_dynamic">{{$setting->lpc_title}}</p>
                                <p class="heading title_text" style="text-align: justify">{{$setting->lpc_text}}</p>
                            </div>
                        @endif
                        {{-- if center --}}
                        @if ($setting->lpc_centered=='1')
                            <div class="d-flex  flex-column  align-items-center justify-content-center" style="width:550px;">
                                <p class="heading font-big title_dynamic">{{$setting->lpc_title}}</p>
                                <p class="heading title_text" style="text-align: center">{{$setting->lpc_text}}</p>
                            </div>
                        @endif



                        <div class="row form-container justify-content-center mx-1">
                            <div class="p-4 rounded" style="background-color: {{ $setting->lpc_form_bg_color }};width:580px;height:500px;">
                                <form action="{{ route('landing_page_contact.save') }}" method="post" class="space-y">
                                    @csrf
                                    <input type="hidden"  name="landing_page_id"  value="{{$setting->id}}"  >
                                    <div class="form-group">
                                        <label class="form_label" for="name">Name</label>
                                        <input required type="text" name="name" class="form-control" id="name" placeholder="Enter your name">
                                    </div>
                                    <div class="form-group">
                                        <label class="form_label" for="email">Email address</label>
                                        <input required type="email" name="email" class="form-control" id="email" placeholder="Enter your email">
                                    </div>
                                    <div class="form-group">
                                        <label class="form_label" for="phone">Phone number</label>
                                        <div class="d-flex">
                                            
                                            <input required type="tel" name="phone" class="form-control" id="phone" placeholder="Enter your phone number">
                                        </div>
                                    </div>
                                    <button style="width: 100%; margin-top: 10px;" type="submit" class="btn btn-custom">Submit</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <footer class="bg-dark text-white">
            <div class="container py-3">
                <div class="row">
                <div class="col-md-12 text-center">
                    <p>Copyright 2024 {{env('APP_NAME')}} | All Rights Reserved.</p>
                </div>
                </div>
            </div>
        </footer>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    
</body>
</html>

@endif


@if ($type=='image')

<!DOCTYPE html>
<html>
<head>
    <title>Landing Page</title>
    <!-- Bootstrap CSS -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        html{
            height: 100vh;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, {{$setting->lpc_overlay}});
            z-index: -1;
        }
        body {
            background-size: 100% 100%;
            background-repeat: no-repeat;
            color: #fff;
        }
        .nav {
            background-color: {{$setting->lpc_nav_color}};
        }
        .logo-container {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .logo {
            height: {{$setting->lpc_logo_pc_height}}px;
            width: {{$setting->lpc_logo_pc_width}}px;
        }
        .heading {
            /* text-align: justify;
            text-justify: inter-word; */
        }
        .form-container {
            margin-top: 1%;
        }
        .btn-custom {
            background-color: {{$setting->lpc_btn_color}};
            border-color: {{$setting->lpc_btn_color}};
            color: {{$setting->lpc_submit_text_color}};
            font-size: {{$setting->lpc_submit_text_font_size}};
            font-family: {{$setting->lpc_submit_text_font_family}};
        }
        .logo-border {
            border: 3px solid black;
        }
        .space-y > * + * {
            margin-top: 2rem;
        }
        .font-big {
            margin-top: -25px;
            font-size: 3rem;
        }

        .title_dynamic{
            color: {{$setting->lpc_title_color}};
            font-size: {{$setting->lpc_title_font_size}};
            font-family: {{$setting->lpc_title_font_family}};
            line-height: initial;
        }

        .title_text{
            color: {{$setting->lpc_title_text_color}};
            font-size: {{$setting->lpc_title_text_font_size}};
            font-family: {{$setting->lpc_title_text_font_family}};
        }

        .form_label{
            color: {{$setting->lpc_form_text_color}};
            font-size: {{$setting->lpc_form_text_font_size}};
            font-family: {{$setting->lpc_form_text_font_family}};
        }
        .left-bg {
            height: {{$setting->lpc_left_bg_height}}% !important;
            object-fit: fill;
        }

        .left-bg-wrapper {
            height: 85.5vh;
        }
        .left-margin {
            /* margin-left: 11%; */
        }
        .right-bg {
            background-size: cover;
            background-repeat: no-repeat;
            background-image: url('{{ asset("public/uploads/$setting->lpc_background") }}');
        }

        @media (max-width: 767px) {
            .d-flex {
                width: auto !important;
            }
        }
        @media only screen and (max-width: 767px) {
  .title_text {
    text-align: center;
    /* margin-left: -10%; */
  }
}
        @media (max-width: 767px) {
    .form-container {
        width: auto !important;
    }

    .form-container .rounded {
        width: 380px !important;
    }
    .left-margin {
        margin-left: 0;
    }
}

@media (max-width: 767px) {
    .bg-container {
        background-image: none !important;
    }
}
@media (max-width: 767px) {
    .logo-container {
        flex-wrap: wrap;
    }
    
    .logo {
        height: {{$setting->lpc_logo_mobile_height}}px;
        width: {{$setting->lpc_logo_mobile_width}}px;
    }
    .title_text {
        /* display: none; */
    }

    .logo-container .col-md-4 {
        flex: 100%;
        max-width: 100%;
        text-align: center;
    }
    .left-bg {
        height: 400px !important;
        object-fit: cover;
    }
    .left-bg-wrapper {
        height: auto;
    }
    .right-bg {
        background: none;
    }
}
@media screen and (min-width: 20in) {
  /* styles for screens greater than 20 inches go here */
}
@media only screen and (max-width: 767px) {
footer {
margin-top: 20px;
}
}
@if ($setting->lpc_centered=='1')
@media screen and (max-width: 767px) {
  .heading.font-big.title_dynamic {
    text-align: center;
  }
}
@else
@media screen and (max-width: 767px) {
  .heading.font-big.title_dynamic {
    text-align: left;
  }
}
@endif

    </style>
</head>
<body class="bg-container">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    {{-- <div class="container-fluid p-0" style="width: 101%">
        <div class="nav">
            <div class="row logo-container justify-content-center align-items-center w-100">
                <div class="col-md-4 col-12 text-center mb-2 mb-md-0">
                    <img src="{{ asset("public/uploads/$setting->lpc_logo") }}" alt="Logo" class="logo">
                </div>
                <div class="col-md-6 text-right">

                </div>
            </div>
        </div>
    </div> --}}
    <div class="container-fluid p-0" style="width: 101%">
        <div class="nav">
            <div class="row logo-container justify-content-center align-items-center w-100">
                <div class="col-md-4">
                    <img src="{{ asset("public/uploads/$setting->lpc_logo") }}" alt="Logo" class="logo">
                </div>
                <div class="col-md-6">
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row align-items-basline">
                <div class="col-md-6 p-0 m-0 left-bg-wrapper">
                    <img style="width: {{$setting->lpc_left_bg_width}}%!important;" src="{{ asset('public/uploads/'. $setting->lpc_left_bg) }}" alt="Left Image" class="w-100 left-bg">
                </div>
                <div  class="col-md-6 pt-5 right-bg">
                    <div class="d-flex flex-column  align-items-center left-margin">
                        {{-- if not center  --}}

                        @if ($setting->lpc_centered=='0')
                            <div class="d-flex flex-column align-items-start" style="width:580px;">
                                <p class="heading font-big title_dynamic">{{$setting->lpc_title}}</p>
                                <p class="heading title_text" style="text-align: justify">{{$setting->lpc_text}}</p>
                            </div>
                        @endif
                        {{-- if center --}}
                        @if ($setting->lpc_centered=='1')
                            <div class="d-flex  flex-column  align-items-center justify-content-center" style="width:550px;">
                                <p class="heading font-big title_dynamic">{{$setting->lpc_title}}</p>
                                <p class="heading title_text" style="text-align: center">{{$setting->lpc_text}}</p>
                            </div>
                        @endif



                        <div class="row form-container justify-content-center mx-1">
                            <div class="p-4 rounded" style="background-color: {{ $setting->lpc_form_bg_color }};width:580px;height:500px;">
                                <form action="{{ route('landing_page_contact.save') }}" method="post" class="space-y">
                                    @csrf

                                    <input type="hidden"  name="landing_page_id"  value="{{$setting->id}}"  >
                                    <div class="form-group">
                                        <label class="form_label" for="name">Name</label>
                                        <input required type="text" name="name" class="form-control" id="name" placeholder="Enter your name">
                                    </div>
                                    <div class="form-group">
                                        <label class="form_label" for="email">Email address</label>
                                        <input required type="email" name="email" class="form-control" id="email" placeholder="Enter your email">
                                    </div>
                                    <div class="form-group">
                                        <label class="form_label" for="phone">Phone number</label>
                                        <div class="d-flex">
                                            <select id="countryCodes" class="form-control"  name="code">
                                                <option value="">Select Country Code</option>
                                                <option selected value="+1">USA +1</option>
                                                
                                            </select>
                                            <input required type="tel" name="phone" class="form-control ml-1" id="phone" placeholder="Enter your phone number">
                                        </div>
                                    </div>
                                    <button style="width: 100%; margin-top: 10px;" type="submit" class="btn btn-custom" >Submit</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <footer class="bg-dark text-white">
            <div class="container py-3">
              <div class="row">
                <div class="col-md-12 text-center">
                  <p>Copyright 2024 {{env('APP_NAME')}} | All Rights Reserved.</p>
                </div>
              </div>
            </div>
          </footer>

    </div>
     
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

   
</body>
</html>


@endif
