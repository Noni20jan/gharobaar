<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        img {
            border: none;
            -ms-interpolation-mode: bicubic;
            max-width: 100%;
        }

        body {
            background-color: #f6f6f6;
            font-family: sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        table {
            border-collapse: separate;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            width: 100%;
        }

        table td {
            font-family: sans-serif;
            font-size: 14px;
            vertical-align: top;
        }

        .body {
            background-color: #cccccc;
            width: 100%;
        }

        .body1 {
            /* background-color: #FFB300; */
            width: 100%;
        }

        .container {
            display: block;
            Margin: 0 auto !important;
            max-width: 640px;
            padding: 10px;
            width: 640px;
        }

        .content {
            box-sizing: border-box;
            display: block;
            Margin: 0 auto;
            max-width: 640px;
            padding: 10px;
        }

        .main {
            background: #ffffff;
            border-radius: 3px;
            width: 100%;
        }

        .wrapper {
            box-sizing: border-box;
            padding: 30px 20px;
        }

        .content-block {
            padding-bottom: 10px;
            padding-top: 10px;
        }

        .footer {
            clear: both;
            Margin-top: 10px;
            text-align: center;
            width: 100%;
        }

        .footer td,
        .footer p,
        .footer span,
        .footer a {
            color: #999999;
            font-size: 12px;
            text-align: center;
        }

        h1,
        h2,
        h3,
        h4 {
            color: #000000;
            font-family: sans-serif;
            font-weight: 400;
            line-height: 1.4;
            margin: 0;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 35px;
            font-weight: 300;
            text-align: center;
            text-transform: capitalize;
        }

        p,
        ul,
        ol {
            font-family: sans-serif;
            font-size: 14px;
            font-weight: normal;
            margin: 0;
            margin-bottom: 15px;
        }

        p li,
        ul li,
        ol li {
            list-style-position: inside;
            margin-left: 5px;
        }

        a {
            color: #3498db;
            text-decoration: underline;
        }

        .btn {
            box-sizing: border-box;
            width: 100%;
        }

        .btn>tbody>tr>td {
            padding-bottom: 15px;
        }

        .btn table {
            width: auto;
        }

        .btn table td {
            background-color: #ffffff;
            border-radius: 5px;
            text-align: center;
        }

        .btn a {
            background-color: #ffffff;
            border: solid 1px #3498db;
            border-radius: 5px;
            box-sizing: border-box;
            color: #3498db;
            cursor: pointer;
            display: inline-block;
            font-size: 14px;
            font-weight: bold;
            margin: 0;
            padding: 12px 25px;
            text-decoration: none;
            text-transform: capitalize;
        }

        .btn-primary table td {
            background-color: #3498db;
        }

        .btn-primary a {
            background-color: #3498db;
            border-color: #3498db;
            color: #ffffff;
        }

        .last {
            margin-bottom: 0;
        }

        .first {
            margin-top: 0;
        }

        .align-center {
            text-align: center;
        }

        .align-right {
            text-align: right;
        }

        .align-left {
            text-align: left;
        }

        .clear {
            clear: both;
        }

        .mt0 {
            margin-top: 0;
        }

        .mb0 {
            margin-bottom: 0;
        }

        .preheader {
            color: transparent;
            display: none;
            height: 0;
            max-height: 0;
            max-width: 0;
            opacity: 0;
            overflow: hidden;
            mso-hide: all;
            visibility: hidden;
            width: 0;
        }

        .powered-by a {
            text-decoration: none;
        }

        hr {
            border: 0;
            border-bottom: 1px solid #f6f6f6;
            margin: 20px 0;
        }

        @media only screen and (max-width: 620px) {
            table[class=body] h1 {
                font-size: 28px !important;
                margin-bottom: 10px !important;
            }

            table[class=body] p,
            table[class=body] ul,
            table[class=body] ol,
            table[class=body] td,
            table[class=body] span,
            table[class=body] a {
                font-size: 16px !important;
            }

            table[class=body] .wrapper,
            table[class=body] .article {
                padding: 10px !important;
            }

            table[class=body] .content {
                padding: 0 !important;
            }

            table[class=body] .container {
                padding: 0 !important;
                width: 100% !important;
            }

            table[class=body] .main {
                border-left-width: 0 !important;
                border-radius: 0 !important;
                border-right-width: 0 !important;
            }

            table[class=body] .btn table {
                width: 100% !important;
            }

            table[class=body] .btn a {
                width: 100% !important;
            }

            table[class=body] .img-responsive {
                height: auto !important;
                max-width: 100% !important;
                width: auto !important;
            }
        }

        @media all {
            .social-content {
                text-align: center;
                color: black;
                display: flex;
                padding-left: 0;
            }

            .ExternalClass {
                width: 100%;
            }

            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%;
            }

            .apple-link a {
                color: inherit !important;
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                text-decoration: none !important;
            }

            .btn-primary table td:hover {
                background-color: #34495e !important;
            }

            .btn-primary a:hover {
                background-color: #34495e !important;
                border-color: #34495e !important;
            }
        }

        .shop-now {
            width: 30%;
        }

        .coupon-code {
            width: 80%;
        }

        .social-icons {
            padding: 45px 0px 0px 21px;
        }

        .visit-us-at {
            writing-mode: tb-rl;
        }

        .social-link {
            width: 32px;
        }

        .social-content {
            text-align: center;
            color: black;
            display: flex;
            padding-left: 20%;
        }

        .founders-note {
            width: 90%;
        }

        @media(max-width:768px) {}
    </style>
</head>

<body class="">

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
        <tr>
            <td>
                <div>
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body1">
                        <tr>
                            <td style="text-align: center;">

                                <head>



                                    <!-- <style>
                                        td {
                                            font-size: x-large;
                                        }

                                        .container {
                                            padding: 0 20%;
                                        }

                                        @media only screen and (max-width: 600px) {
                                            .container {
                                                width: 100%;
                                                padding: 0 0%;
                                            }

                                            .products {
                                                padding-right: 0% 4%;
                                            }

                                        }
                                    </style> -->
                                </head>

                                <body>
                                    <div class="container">
                                        <div style="width: 100%; background-size: cover; background-image:
                                            url('https://gharobaar.com/assets/img/email_img/Untitled-1%203.png');">
                                            <div>
                                                <br>
                                                <div class="row" style="margin:2% 0;">
                                                    <img class="founders-note" src="https://gharobaar.com/assets/img/valentine_img/FOUNDER%20note.png">
                                                </div>

                                                <div>
                                                    <img src="https://gharobaar.com/assets/img/valentine_img/Group%2023.png" style="height: 129%; width:92%">
                                                </div>
                                                <div class="row">
                                                    <div class="col-8">
                                                        <div class="row" style="text-align:left; margin-left:2%;">
                                                            <img src="https://gharobaar.com/assets/img/valentine_img/Valentine%20Day%20Gifting%20Guide.png">
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-4">
                                                    <div style="text-align:right; margin-right:8%;"><img
                                                            src="https://gharobaar.com/assets/img/email_img/Asset%202%201.png"></div>
                                                </div> -->
                                                </div>
                                            </div>
                                            <!-- <img src="https://gharobaar.com/assets/img/email_img/Capture3.PNG" style="width: 100%; height: 12%;"> -->
                                            <div class="row" style="align-self: center;"><img src="https://gharobaar.com/assets/img/valentine_img/Group%2022%20(1).png" style="width: 100%;">
                                            </div>




                                            <div style="padding: 0% 10%;" class="products">
                                                <div class="row" style="display:flex;">
                                                    <div class="col-md-6">
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/Group%2025.png" style="">
                                                    </div>
                                                    <div class="col-md-6" style="text-align:center; padding-top:13%;">
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/ROSE%20MINI%20DRESS.png"><br>
                                                        <br>
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/Rose%20mini.png">
                                                        <br>
                                                        <br>
                                                        <a href="https://www.gharobaar.com/rose-midi-dress-4647">
                                                            <img src="https://gharobaar.com/assets/img/email_img/Group%201.png"></a>
                                                    </div>
                                                </div>
                                            </div>



                                            <div style="padding: 0% 10%;">
                                                <div class="row" style="display:flex;">
                                                    <div class="col-md-6" style=" text-align:center; padding-right: 10%;">
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/Stained%20glass%20heart%20hanging.png"><br>
                                                        <br>
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/art%20gilheri.png">
                                                        <br>
                                                        <br>
                                                        <a href="https://www.gharobaar.com/rose-midi-dress-4647">
                                                            <img src="https://gharobaar.com/assets/img/email_img/Group%201.png"></a>
                                                    </div>
                                                    <div class="col-md-6" style="height: 90%;">
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/Group%2025%20(1).png" style="">

                                                    </div>
                                                </div>
                                            </div>

                                            <div style="padding: 0% 10%;">
                                                <div class="row" style="display:flex;">
                                                    <div class="col-md-6">
                                                        <!-- <img src="https://gharobaar.com/assets/img/email_img/Ellipse%203.png"
                                                        style="height: 100%; " -->
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/Group%2029.png" style="height: 90%;">
                                                    </div>
                                                    <div class="col-md-6" style="text-align:center; padding-top:13%;">
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/niyor%20perfumes.png"><br>
                                                        <br>
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/Niyor%20perfume.png">
                                                        <br>
                                                        <br>
                                                        <a href="https://www.gharobaar.com/niyor-personalized-perfume-for-gift-customised-label-of-your-choice-perfect-valentines-birthday-gift-7250">
                                                            <img src="https://gharobaar.com/assets/img/email_img/Group%201.png"></a>
                                                    </div>
                                                </div>
                                            </div>


                                            <div style="padding: 0% 10%;">
                                                <div class="row" style="display:flex;">
                                                    <div class="col-md-6" style=" text-align:center; padding-right: 10%;">
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/Alcohol%20Free%20Aftershave.png"><br>
                                                        <br>
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/Geelee%20Mitti.png"><br>
                                                        <br>
                                                        <a href="https://www.gharobaar.com/alcohol-free-aftershave-100-natural-soothing-moisturizing-with-aloe-vera-rose-water-no-irritation-side-effects-100ml-7149">
                                                            <img src="https://gharobaar.com/assets/img/email_img/Group%201.png"></a>

                                                    </div>
                                                    <div class="col-md-6" style="height: 90%;">
                                                        <!-- <img src="https://gharobaar.com/assets/img/email_img/Ellipse%203.png"
                                                        style="height: 230px; "x;"> -->
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/Group%2027.png">

                                                    </div>
                                                </div>
                                            </div>

                                            <div style="padding: 0% 10%;">
                                                <div class="row" style="display:flex;">
                                                    <div class="col-md-6">
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/Group%2026.png" style="height: 90%;">
                                                        <!-- <img src="https://gharobaar.com/assets/img/email_img/Ellipse%203.png"
                                                        style="height: 263px; "> -->
                                                    </div>
                                                    <div class="col-md-6" style="text-align:center; padding-top:7%;">
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/Explosion%20box.png"><br>
                                                        <br>
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/Handy%20Mandy.png"><br>
                                                        <br>
                                                        <a href="https://www.gharobaar.com/heart-shape-explosion-box-7201">
                                                            <img src="https://gharobaar.com/assets/img/email_img/Group%201.png"></a>
                                                    </div>
                                                </div>
                                            </div>



                                            <div style="padding: 0% 10%;">
                                                <div class="row" style="display:flex;">
                                                    <div class="col-md-6" style=" text-align:center; padding-right: 10%;">
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/Rainbow%20Teddy%20Shirt.png"><br>
                                                        <br>
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/Pawgy%20Pet.png"><br>
                                                        <br>
                                                        <a href="https://www.gharobaar.com/rainbow-teddy-shirt-2514">
                                                            <img src="https://gharobaar.com/assets/img/email_img/Group%201.png"></a>


                                                    </div>
                                                    <div class="col-md-6" style="height: 90%;">
                                                        <!-- <img src="https://gharobaar.com/assets/img/email_img/Ellipse%203.png"
                                                        style="height: 209px; "x;"> -->
                                                        <br><img src="https://gharobaar.com/assets/img/valentine_img/Group%2028.png" style="">

                                                    </div>
                                                </div>
                                            </div>


                                            <div style="padding: 0% 10%;">
                                                <div class="row" style="display:flex;">
                                                    <div class="col-md-6">
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/Mask%20Group.png" style="height: 90%;">
                                                    </div>
                                                    <div class="col-md-6" style="text-align:center; padding-top:7%;">
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/Lavender%20candle.png"><br>
                                                        <br>
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/Moum%20candles..png"><br>
                                                        <br>
                                                        <a href="https://www.gharobaar.com/lavender-double-wick-candles-7266">
                                                            <img src="https://gharobaar.com/assets/img/email_img/Group%201.png"></a>

                                                    </div>
                                                </div>
                                            </div>




                                            <div style="padding: 0% 10%;">
                                                <div class="row" style="display:flex;">
                                                    <div class="col-md-6" style=" text-align:center; padding-right: 10%;">
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/Gluten-free%20chocolate.png" style=""><br>
                                                        <br>
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/Piperleaf.png"><br>
                                                        <br>
                                                        <a href="https://www.gharobaar.com/5599">
                                                            <img src="https://gharobaar.com/assets/img/email_img/Group%201.png" style=""></a>

                                                    </div>
                                                    <div class="col-md-6" style="">
                                                        <img src="https://gharobaar.com/assets/img/valentine_img/Mask%20Group%20(1).png" style="height: 90%;">

                                                    </div>
                                                </div>
                                            </div>
                                            <div style="text-align: center;">
                                                <img src="https://gharobaar.com/assets/img/valentine_img/Group%2019.png" style="height: 45%; width: 80%;">
                                            </div>
                                            <div style="background-color: lightpink">
                                                <br>
                                                <br>
                                                <div style="text-align: center;">
                                                    <img src="https://gharobaar.com/assets/img/valentine_img/Group%207.png">
                                                </div>

                                                <div style="text-align: center;">
                                                    <img class="coupon-code" src="https://gharobaar.com/assets/img/valentine_img/coupon%20code.png">
                                                </div>
                                                <div style="text-align: center;">

                                                    <a href="https://gharobaar.com/">
                                                        <img class="shop-now" src="https://gharobaar.com/assets/img/email_img/Shop%20Now%20(002).png"></a>
                                                </div>
                                                <div style="text-align: center;">
                                                    <div class="social-content">
                                                        <div>
                                                            <img src="https://gharobaar.com/assets/img/email_img/Asset%201%201.png">
                                                        </div>
                                                        <div class="visit-us-at">
                                                            <img src="https://gharobaar.com/assets/img/valentine_img/VISIT%20US%20AT.png">
                                                        </div>
                                                        <div class="social-icons">
                                                            <a href="https://www.facebook.com/gharobaar.official" target="_blank" rel="noopener" style="text-decoration: none;">
                                                                <img class="social-link" src="https://gharobaar.com/assets/img/social-icons/facebook.png" />
                                                            </a>
                                                            <a href="https://www.instagram.com/gharobaar_official/" target="_blank" rel="noopener" style="text-decoration: none;">
                                                                <img class="social-link" src="https://gharobaar.com/assets/img/social-icons/instagram.png" />
                                                            </a> <a href="https://www.youtube.com/channel/UC2jOkQl0OR1cIJgo2WJZWqw" target="_blank" rel="noopener" style="text-decoration: none;">
                                                                <img class="social-link" src="https://gharobaar.com/assets/img/social-icons/youtube.png" />
                                                            </a>
                                                            <a href="https://in.pinterest.com/gharobaar_official/_created/" target="_blank" rel="noopener" style="text-decoration: none;">
                                                                <img class="social-link" src="https://gharobaar.com/assets/img/social-icons/pinterest.png" />
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </body>
                            </td>
                        </tr>
                    </table>