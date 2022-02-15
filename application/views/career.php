<style>
    @media (min-width: 500px) {}

    .svg-fotter {
        position: absolute;
        top: -57%;
        left: 0;
    }



    @media only screen and (max-width: 600px) {

        /* .button_span{
            margin-top: 0% !important
        } */
        #image_career {
            width: 100% !important;
        }

        .svg-fotter {
            position: absolute;
            top: -10%;
            left: 0
        }

        .summary-section {
            margin-top: 5% !important;
            width: 100% !important;
            margin-right: 0% !important;
            margin-left: 0% !important;
        }

        h5 {
            font-size: 13px !important;
            padding-bottom: 1% !important;
        }

        .job_des {
            text-align: justify;
            padding-top: 5%;
            padding-left: 5%;
            padding-right: 5%;
            width: 76% !important;
        }

        .job_para {
            font-size: 10px !important
        }

        #brief_img {
            width: 47% !important;
        }

        .btn {
            width: 60% !important;
        }

        .para {
            text-align: justify;
            width: 100% !important;
            margin-left: 0% !important;
            margin-top: 10% !important;
            font-size: 12px !important;
        }

        h3 {
            font-weight: bold;
            font-size: 17px !important;
        }
    }

    .job_des {
        text-align: justify;
        padding-top: 5%;
        padding-left: 5%;
        padding-right: 5%;

        width: 83%;
    }

    .btn {
        display: block;
        margin-left: 4%;
        margin-bottom: 2%;
    }

    @media (max-width: 700px) {

        #subscribe {
            border-radius: 20px;
            min-height: 40px;
            min-width: 93px;
            background-color: #007C05;
            /* background-color: #c582b5; */
            color: #fff;
            white-space: nowrap;
            position: relative;
            top: 15px;
            /* left: 227px; */
            /* top: 0px; */
            float: right;
            visibility: visible;
        }
    }
</style>




<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div id="wrapper" class="index-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <img src="<?php echo base_url(); ?>assets/img/career_img.png" id="image_career" style="width: 45%;" />
                <!-- <h3 style="font-weight:bold">A Curated Career for the Creative Soul</h3>
                <div class="text-center para" style="width: 90%; margin-left:5%; margin-top:2%">
                    <p class="para" style="font-size: 20px; font-weight:bold">Do mass-produced fashion and endless supermarket queues give you the heebie-jeebies? Are you the self-proclaimed Gandalf of your social circle, always leading your friends on new adventures? Do you jump at the prospect of finding something exotic and uncharted?</p>
                    <p class="para" style="font-size: 20px; font-weight:bold">Discover a new way of life with Gharobaar - a curated trove of treasures made by local entrepreneurs. We don’t believe in settling for mass-produced items and prefer a lot more thought and creativity - in our food, clothes, and everything else!</p>
                </div> -->
            </div>
        </div>

        <center>
            <h3 style="font-weight:bold;margin-top:40px"><?php echo trans("hiring_content"); ?></h3>
        </center>

        <!-- <div class="row" style="margin-top: 5%;">
            <div class="col-sm-6 text-center">
                <div class="row summary-section" style="width: 90%; float:right; margin-right: 2%;">
                    <div class="job_des">
                        <h5 style="padding-bottom: 4%;">Junior Graphic Designer</h5>
                        <p class="job_para">We are looking for creative souls who eat, sleep and breathe design. Imagination is in their genes and making beautiful designs is in their D.N.A. Should be adept at standard designing tools such as Photoshop, Illustrator, and Indesign. Should have a positive and responsible attitude towards the tasks at hand. If you think you have these qualities in you, we are waiting forward to seeing you!</p>
                    </div>
                    <span class="button_span" style="margin-top: 20%;">
                        <img src="<?php echo base_url(); ?>assets/img/brief.png" id="brief_img" />
                    </span>
                    <button class="btn btn-md btn-custom"> <i class="fas fa-pencil-alt"></i>Apply Now</button>
                </div>
            </div>
            <div class="col-sm-6 text-center">
                <div class=" row summary-section" style="width: 90%; float:left; margin-left:2%">
                    <div class="job_des">
                        <h5 style="padding-bottom: 4%;">Junior Graphic Designer</h5>
                        <p class="job_para">We are looking for creative souls who eat, sleep and breathe design. Imagination is in their genes and making beautiful designs is in their D.N.A. Should be adept at standard designing tools such as Photoshop, Illustrator, and Indesign. Should have a positive and responsible attitude towards the tasks at hand. If you think you have these qualities in you, we are waiting forward to seeing you!</p>
                    </div>
                    <span class="button_span" style="margin-top: 20%;">
                        <img src="<?php echo base_url(); ?>assets/img/brief.png" id="brief_img" />
                    </span>
                    <button class="btn btn-md btn-custom"> <i class="fas fa-pencil-alt"></i>Apply Now</button>
                </div>
            </div>

        </div> -->





    </div>
</div>
<!-- Wrapper End-->

<script>
    var iframe = document.getElementById("contact_iframe");
    iframe.src = iframe.src;
</script>