<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Coupon Code</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>/*the complete project is in the following link:
            https://github.com/vkive/coupon-code.git
            Follow me on Codepen
            */
            * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'poppins', sans-serif;
}

.container {
    width: 96%;
    height: 100vh;
    background: #f0fff3;
    display: flex;
    align-items: center;
    justify-content: center;
}

.coupon-card {
    margin-left: 3%;
    background: #{{$coupon->hex}};
    color: #fff;
    text-align: center;
    padding: 6% 5%;
    border-radius: 15px;
    box-shadow: 0 10px 10px 0 rgba(0, 0, 0, 0.15);
    position: relative;
}

.logo {
    width: 60px;
    border-radius: 8px;
    margin-bottom: 10px;
}

.coupon-card h3 {
    font-size: 24px;
    font-weight: 400;
    line-height: 30px;
    margin-bottom: 10px;
}

.coupon-card p {
    font-size: 14px;
}

.coupon-row {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 20px auto;
}

#cpnCode {
    border: 1px dashed #fff;
    padding: 8px;
    border-right: 0;
    margin-bottom: 10px;
}

#cpnBtn {
    border: 1px solid #fff;
    background: #fff;
    padding: 8px;
    color: #7158fe;
    cursor: pointer;
}

.circle1,
.circle2 {
    background: #f0fff3;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
}

.circle1 {
    left: -15px;
}

.circle2 {
    right: -15px;
}

            </style>
    </head>
    <body>
        
        <div class="container">
                <div class="coupon-card">
                @if ($coupon->logo==null)
                    <img src="{{ asset('public/uploads/'.$g_setting->logo) }}" alt="logo" style="width: 300px ;height: 90px ;" class="logo">
                @else
                    <img src="{{ asset('public/uploads/'.$coupon->logo) }}" alt="logo" style="width: 300px ;height: 90px ;" class="logo">
                @endif
                
                <h3>{!!$coupon->title!!}</h3>
                @if ($coupon->image!=null)
                     <img src="{{ asset('public/uploads/'.$coupon->image) }}"  style="width: 300px;" >
                @endif
                
                <br><br>
                <p><b>Valid Till: {{ Carbon\Carbon::createFromFormat('Y-m-d', $coupon->valid_till)->format('d F Y') }}</b></p><br>
                @if (Carbon\Carbon::createFromFormat('Y-m-d', $coupon->valid_till)->isPast())
                    Coupon Status: <span style="color: pink" class="text-danger">Expired</span>
                @elseif (Carbon\Carbon::createFromFormat('Y-m-d', $coupon->valid_till)->isToday())
                    Coupon Status: <span class="text-warning">Expires Today</span>
                @else
                     Coupon Status: <span  >Valid</span>
                @endif
                <div class="circle1"></div>
                <div class="circle2"></div>
            </div>
        </div>
    </body>
    <script>
         var cpnBtn = document.getElementById("cpnBtn");
            var cpnCode = document.getElementById("cpnCode");

            cpnBtn.onclick = function(){
                navigator.clipboard.writeText(cpnCode.innerHTML);
                cpnBtn.innerHTML ="COPIED";
                setTimeout(function(){
                    cpnBtn.innerHTML="COPY CODE";
                }, 3000);
            }
    </script>
</html>