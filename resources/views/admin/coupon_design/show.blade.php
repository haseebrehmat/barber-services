{!! isset($coupon->content) ? $coupon->content : '-' !!}

<!DOCTYPE HTML>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    @if (isset($coupon->expired_at))
        <div class="container-sm text-center my-4">
            <p class="text-muted py-2 fs-5" id="info-text"></p>
            <div id="countdown" class="d-flex justify-content-center flex-wrap"></div>
        </div>

        <script>
            // Set the date we're counting down to
            var countDownDate = new Date("{{ $coupon->expired_at->toDatetimeString() }}").getTime();

            // Rest of your JavaScript code for the countdown timer
            var x = setInterval(function() {
                var now = new Date().getTime();
                var distance = countDownDate - now;

                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("info-text").innerHTML = "This Coupon is ";
                    var expiredText = document.createElement("span");
                    expiredText.className = "text-danger";
                    expiredText.textContent = "EXPIRED";
                    document.getElementById("info-text").appendChild(expiredText);
                } else {
                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    document.getElementById("info-text").innerHTML = "This Coupon Expires in";

                    var mainContainer = document.getElementById("countdown");
                    mainContainer.className = "d-flex justify-content-center flex-wrap";

                    var countdownText = `<div class="d-flex flex-column p-2 text-center">`;

                    countdownText += '<span class="fs-3 fw-bold">' + days +
                        '</span><small class="text-uppercase mt-1">day' + (days > 1 ? 's' : '') + '</small>';

                    countdownText += `</div><span class="fs-3 p-2">:</span><div class="d-flex flex-column p-2 text-center">`;

                    countdownText += '<span class="fs-3 fw-bold">' + hours +
                        '</span><small class="text-uppercase mt-1">hour' + (hours > 1 ? 's' : '') + '</small>';

                    countdownText += `</div><span class="fs-3 p-2">:</span><div class="d-flex flex-column p-2 text-center">`;

                    countdownText += '<span class="fs-3 fw-bold">' + minutes +
                        '</span><small class="text-uppercase mt-1">minute' + (minutes > 1 ? 's' : '') + '</small>';

                    countdownText += `</div><span class="fs-3 p-2">:</span><div class="d-flex flex-column p-2 text-center">`;

                    countdownText += '<span class="fs-3 fw-bold">' + seconds +
                        '</span><small class="text-uppercase mt-1">second' + (seconds > 1 ? 's' : '') + '</small>';

                    countdownText += `</div>`;

                    mainContainer.innerHTML = countdownText;
                }
            }, 1000);
        </script>
    @endif

</body>

</html>
