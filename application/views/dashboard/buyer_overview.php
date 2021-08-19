<?php defined('BASEPATH') or exit('No direct script access allowed');

?>

<head>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
</head>
<div class="row">
    <div class="col-sm-12">
        <div class="">


            <div class="row">

                <div class="row">
                    <center>
                        <h2> YOU ARE AT</h2>
                        <p><b>
                                <h1>BRONZE</h1>
                            </b>
                        </p>
                        <br>

                    </center>
                </div>
                <div class="row" style="margin-left: 40px;margin-right: 40px;">

                    <div class="progress">
                        <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:75%">
                            75%
                        </div>
                    </div>
                    <div class="col-md-3">
                        BRONZE
                    </div>
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-3" style="text-align: right;">
                        SILVER
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="col-md-6">
                            <img src="<?php echo base_url(); ?>assets/img/overview_image.png" />




                        </div>
                        <div class="col-md-6 mustang" style="padding-right: 0px;">
                            <p>

                                It's convenient to pay with saved cards. Your card information will be secure, we use 128-bit encryption
                            </p>
                            <br>



                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    window.onload = function() {
        if (
            document.querySelectorAll(".softprogress").length > 0 &&
            document.querySelectorAll(".softprogress [code-softprogress]").length > 0
        ) {
            document
                .querySelectorAll(".softprogress [code-softprogress]")
                .forEach((x) => runsoftprogress(x));
        }
    };

    function runsoftprogress(el) {
        el.className = "run-softprogress";
        el.setAttribute(
            "style",
            `--run-softprogress:${el.getAttribute("code-softprogress")}%;`
        );
    }
</script>