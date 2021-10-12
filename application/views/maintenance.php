<!DOCTYPE HTML>
<html lang="en">

<head>
    <title><?php echo $this->general_settings->maintenance_mode_title; ?> - <?php echo $this->general_settings->application_name; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        html {
            height: 100%;
            width: 100%;
            overflow-x: hidden;
        }

        body {
            width: 100%;
            height: 100%;
            overflow-x: hidden;
            font-family: 'Open Sans', sans-serif;
            font-size: 14px;
            font-weight: 400;
            word-wrap: break-word;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .site-title {
            position: absolute;
            top: 100px;
            left: 0;
            right: 0;
            font-size: 96px;
            font-weight: 400;
        }

        .title {
            font-size: 48px;
            line-height: 52px;
        }

        .description {
            max-width: 560px;
            margin: 0 auto;
            font-size: 20px;
            color: #1F1C2C;
            font-size: 35px;

            font-family: revert;
            text-align: center;
            margin-top: 18%;

        }

        .maintenance {
            position: relative;
            width: 100%;
            min-height: 100%;
            max-height: auto;
            text-align: center;
            background-size: cover;
            background: linear-gradient(to right, #e1e2c5 0%, #f6e0ae 17%, #ffdfa5 28%, #ffdea8 42%, #ffdbc1 71%, #ffd5c8 100%);
            z-index: 1;
        }

        .maintenance:after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: -20;
            opacity: .72;
            background: -webkit-linear-gradient(to right, #928DAB, #1F1C2C);
        }

        .bg_image img {
            max-width: 500px;
        }

        .scooter img {
            max-width: 600px;
            float: left;
        }

        .bg_image {
            padding-top: 50px;
        }

        .maintenance-inner {
            display: table;
            height: 100%;
            width: 100%;
        }

        .maintenance-inner .content {
            display: table-cell;
            vertical-align: middle;
            padding: 20px;
        }

        .scooter {
            padding-top: 50px;
            float: left;
        }

        p {
            text-align: center;
            font-size: 60px;
            margin-top: 0px;
        }

        .timer {
            color: black;
        }

        @media (max-width: 950px) {
            .site-title {
                font-size: 64px;
                position: relative;
                top: -60px;
                text-align: center;
            }

            .bg_image img {
                max-width: 300px;
            }

            .scooter img {
                max-width: 400px;
                float: left;
            }

            .description {
                font-size: 35px;
                font-style: italic;
                font-family: revert;
                text-align: center;
                padding-left: 0px;
            }
        }
    </style>

</head>

<body>

    <div class="maintenance">
        <div class="row">
            <div class="col-md-6">
                <div class="row" style="float: right;">
                    <div class="col-md-12">
                        <div class="bg_image">
                            <img src="assets/img/logo.png">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="content">
                            <p class="description"><?php echo $this->general_settings->maintenance_mode_description; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 scooter">
                <img src="assets/img/scooter.png">
            </div>
        </div>
        <!-- <p id="demo" class="timer">.</p> -->
    </div>
</body>

</html>

<script>
    // Set the date we're counting down to
    var countDownDate = new Date("Jun 12, 2021 16:00:00").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="demo"
        document.getElementById("demo").innerHTML = days + "d " + hours + "h " +
            minutes + "m " + seconds + "s ";

        // If the count down is over, write some text 
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "EXPIRED";
        }
    }, 1000);
</script>

<?php exit(); ?>