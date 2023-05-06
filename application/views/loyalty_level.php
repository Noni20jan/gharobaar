<?php defined('BASEPATH') or exit('No direct script access allowed');

?>
<style>
    .white-box {
        background-color: #ffffff5c;
        border-radius: 20px;
    }
</style>

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
                </div>
                <div class="row" style="margin-left: 40px;margin-right: 40px;">
                    <div class="col-sm-6">
                        <strong>BRONZE</strong><br>
                        <img src="<?php echo base_url(); ?>assets/img/bronze-level.png" />
                    </div>
                    <div class="col-sm-6" style="text-align:end;">
                        <strong>SILVER</strong><br>
                        <img src="<?php echo base_url(); ?>assets/img/silver-level.png" />
                    </div>
                </div>
                <div class="row" style="margin-top:10%;">
                    <div class="col-md-3 white-box">
                        <h4>Bronze</h4>
                    </div>
                    <div class="col-md-3 white-box">
                        <h4>Silver</h4>
                    </div>
                    <div class="col-md-3 white-box">
                        <h4>Gold</h4>
                    </div>
                    <div class="col-md-3 white-box">
                        <h4>Platinum</h4>
                    </div>
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