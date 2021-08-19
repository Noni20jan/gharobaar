<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->

<head>
    <style>
        /* CSS comes here */
        /* body {
            margin-top: 30px;
        } */
        .nex {
            text-align: right;
        }

        .pre {
            text-align: left;
        }

        .button {
            background-color: #4CAF50;
            /* Green */
            border: none;
            color: white;
            border-radius: 4px;
            padding: 8px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 15px;
            margin: 4px 2px;
            transition-duration: 0.4s;
            cursor: pointer;
        }

        .button1 {
            background-color: white;
            color: black;
            border: 2px solid #4CAF50;
        }

        .button1:hover {
            background-color: #4CAF50;
            color: white;
        }


        .stepwizard-step p {
            margin-top: 0px;
            color: #666;
        }

        .stepwizard-row {
            display: table-row;
        }

        .stepwizard {
            display: table;
            width: 100%;
            position: relative;
        }

        /* .stepwizard .btn.disabled,
        .stepwizard .btn[disabled],
        .stepwizard fieldset[disabled] .btn {
            opacity: 1 !important;
            color: #bbb;
        } */
        .stop-pointer,
        .stop-pointer[disabled] {
            opacity: 1 !important;
            color: #bbb;
            cursor: default !important;
            pointer-events: none;
        }

        .progress {
            top: 13px;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 74%;
            left: 11%;
            height: 4px;
            z-index: 0;
        }

        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -1px;
        }

        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -1px;
        }

        .stepwizard-step {
            display: table-cell;
            text-align: center;
            position: relative;
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 15px;
            background-color: white;
            border-color: lightblue;
        }

        .video {
            border: 1px solid black;
            width: 150px;
            height: 150px;
        }

        .Validation_error {
            color: red;
        }

        .photo {
            border: 1px solid black;
            width: 150px;
            height: 150px;
        }

        .canvas {
            display: none;
        }

        .camera {
            width: 150px;
            display: inline-block;
        }

        .output {
            width: 150px;
            display: inline-block;
        }

        .startbutton {
            display: block;
            position: relative;
            margin-left: auto;
            margin-top: 10px;
            margin-right: auto;
            bottom: 36px;
            padding: 5px;
            background-color: #fff;
            border: 1px solid #000;
            font-size: 14px;
            color: #000;
            cursor: pointer;
        }

        .contentarea {
            font-size: 16px;
            font-family: Arial;
            text-align: center;
        }

        .switch {
            position: absolute;
            left: 15%;
            top: -12%;
            overflow: visible;
            width: 490px;
            white-space: nowrap;
            text-align: left;
            font-family: Century Gothic, sans-serif;
            font-style: normal;
            font-weight: normal;
            font-size: 50px;
            color: rgba(0, 0, 0, 1);
            background: rgba(0, 0, 0, 0.25);
            border-radius: 15px;
        }

        .switch-label {
            position: relative;
            z-index: 2;
            float: left;
            font-size: 15px;
            width: 245px;
            line-height: 26px;
            font-size: 11px;
            color: white;
            text-align: center;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.45);
            cursor: pointer;
        }

        .switch-label:active {
            font-weight: bold;
            font-size: 15px;
        }

        .switch-label-off {
            padding-left: 2px;
            font-size: 15px;
        }

        .switch-label-on {
            padding-right: 3px;
            font-size: 15px;
        }

        .switch-input {
            display: none;
        }

        .switch-input:checked+.switch-label {
            font-weight: bold;
            color: rgba(0, 0, 0, 0.65);
            text-shadow: 0 1px rgba(255, 255, 255, 0.25);
            -webkit-transition: 0.15s ease-out;
            -moz-transition: 0.15s ease-out;
            -o-transition: 0.15s ease-out;
            transition: 0.15s ease-out;
        }

        .switch-input:checked+.switch-label-on~.switch-selection {

            left: 245px;
        }

        .switch-selection {
            display: block;
            position: absolute;
            z-index: 1;
            top: 2px;
            left: 2px;
            width: 242px;
            height: 26px;
            background: #65bd63;
            border-radius: 15px;
            background-image: -webkit-linear-gradient(top, #9dd993, #65bd63);
            background-image: -moz-linear-gradient(top, #9dd993, #65bd63);
            background-image: -o-linear-gradient(top, #9dd993, #65bd63);
            background-image: linear-gradient(to bottom, #9dd993, #65bd63);
            -webkit-box-shadow: inset 0 1px rgba(255, 255, 255, 0.5), 0 0 2px rgba(0, 0, 0, 0.2);
            box-shadow: inset 0 1px rgba(255, 255, 255, 0.5), 0 0 2px rgba(0, 0, 0, 0.2);
            -webkit-transition: left 0.15s ease-out;
            -moz-transition: left 0.15s ease-out;
            -o-transition: left 0.15s ease-out;
            transition: left 0.15s ease-out;
        }

        .form {
            display: none;
        }

        .form.active {
            display: block
        }

        .form-box-head {
            margin-bottom: 25px;
            margin-top: 20px;
        }
    </style>
    <title>My Favorite Sport</title>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/datepicker/css/bootstrap-datepicker.standalone.css">
    <script src="<?php echo base_url(); ?>assets/vendor/datepicker/js/bootstrap-datepicker.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="<?php echo base_url(); ?>assets/js/jquery.tagger.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery.tagger.css">
</head>
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
                    </ol>
                </nav>

                <h1 class="page-title"><?php echo trans("settings"); ?></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-3">
                <div class="row-custom">
                    <!-- load profile nav -->
                    <?php $this->load->view("settings/_setting_tabs"); ?>
                </div>
            </div>

            <div class="col-sm-12 col-md-9">
                <div class="row-custom">
                    <div class="profile-tab-content">
                        <!-- include message block -->
                        <?php $this->load->view('partials/_messages'); ?>

                        <?php echo form_open_multipart("update-settings-post", ['id' => 'form_validate']); ?>

                        <div class="form-group">
                            <div class="row">
                                <?php if ($this->auth_check) : ?>
                                    <?php if ($this->auth_user->gst_issue == 1) {  ?>
                                        <div class="col-12 col-sm-4 m-b-15">
                                            <label class="control-label">GST Number<span class="Validation_error"> *</span></label>
                                            <input type="text" name="gst_number1" id="gst_number" value="<?php echo html_escape($this->auth_user->gst_number); ?>" class="form-control auth-form-input" placeholder="GST number" required minlength="15" maxlength="15" pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}">
                                            <p class="Validation_error" id="gst_number_p"></p>
                                        </div>
                                    <?php } else {
                                    ?>
                                        <div class="col-12 col-sm-4 m-b-15">
                                            <label class="control-label">GST Number<span class="Validation_error"> *</span></label>
                                            <input type="text" readonly name="gst_number1" id="gst_number" value="<?php echo html_escape($this->auth_user->gst_number); ?>" class="form-control auth-form-input" placeholder="GST number" required minlength="15" maxlength="15" pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}">
                                            <p class="Validation_error" id="gst_number_p"></p>
                                        </div>

                                    <?php } ?>
                                    <?php if ($this->auth_user->pan_issue == 1) {  ?>
                                        <div class="col-12 col-sm-4 m-b-15">
                                            <label class="control-label">Permanent Account Number (PAN)<span class="Validation_error"> *</span></label>
                                            <input type="text" name="pan_number1" id="pan_number" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->pan_number); ?>" placeholder="Pan number" required minlength="10" maxlength="10" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}">
                                            <p class="Validation_error" id="pan_number_p"></p>
                                        </div>
                                    <?php } else {
                                    ?>
                                        <div class="col-12 col-sm-4 m-b-15">
                                            <label class="control-label">Permanent Account Number (PAN)<span class="Validation_error"> *</span></label>
                                            <input type="text" readonly name="pan_number1" id="pan_number" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->pan_number); ?>" placeholder="Pan number" required minlength="10" maxlength="10" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}">
                                            <p class="Validation_error" id="pan_number_p"></p>
                                        </div>
                                    <?php } ?>
                                    <?php if ($this->auth_user->adhaar_issue == 1) {  ?>
                                        <div class="col-12 col-sm-4 m-b-15">
                                            <label class="control-label">Aadhaar Details</label>
                                            <input type="number" name="adhaar_number1" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->adhaar_number); ?>" placeholder="Aadhaar Details">
                                        </div>
                                    <?php } else {
                                    ?>
                                        <div class="col-12 col-sm-4 m-b-15">
                                            <label class="control-label">Aadhaar Details</label>
                                            <input type="number" readonly name="adhaar_number1" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->adhaar_number); ?>" placeholder="Aadhaar Details">
                                        </div>
                                    <?php } ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-4 m-b-15">
                                    <label class="control-label">Capture Image With PAN Card<span class="Validation_error"> *</span></label><br>
                                    <small>(Please hold the PAN card near your face in such a way that both PAN card and face are clearly visible)</small>
                                </div>
                                <div class="col-12 col-sm-4 m-b-15">
                                    <div class="camera">
                                        <video id="video" class="video">Video stream not available.</video>
                                        <button id="startbutton" class="startbutton">Take photo</button>
                                    </div>
                                    <div></div>
                                </div>
                                <div class="col-12 col-sm-4 m-b-15">
                                    <canvas id="canvas" class="canvas"></canvas>
                                    <div class="output">
                                        <img id="photo" class="photo" alt="The screen capture will appear in this box.">
                                        <input type="text" id="pan_photo" name="pan_photo" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->image_pancard); ?>" style="display: none;" required>
                                        <p class="Validation_error" id="pan_photo_p"></p>
                                    </div>

                                </div>
                            </div>
                        </div> -->



                    </div>

                    <button type="submit" name="submit" value="update" class="btn btn-lg btn-success pull-right"><?php echo trans("save_changes") ?></button>
                    <?php echo form_close(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Wrapper End-->

<!-- 
<script>
    // / JS comes here /
    (function() {

        var width = 320; // We will scale the photo width to this
        var height = 0; // This will be computed based on the input stream

        var streaming = false;

        var video = null;
        var canvas = null;
        var photo = null;
        var startbutton = null;

        function startup() {
            video = document.getElementById('video');
            canvas = document.getElementById('canvas');
            photo = document.getElementById('photo');
            pan = document.getElementById('pan_photo');
            startbutton = document.getElementById('startbutton');

            navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: false
                })
                .then(function(stream) {
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function(err) {
                    console.log("An error occurred: " + err);
                });

            video.addEventListener('canplay', function(ev) {
                if (!streaming) {
                    height = video.videoHeight / (video.videoWidth / width);

                    if (isNaN(height)) {
                        height = width / (4 / 3);
                    }

                    video.setAttribute('width', width);
                    video.setAttribute('height', height);
                    canvas.setAttribute('width', width);
                    canvas.setAttribute('height', height);
                    streaming = true;
                }
            }, false);

            startbutton.addEventListener('click', function(ev) {
                takepicture();
                ev.preventDefault();
            }, false);

            clearphoto();
        }

        function clearphoto() {
            var context = canvas.getContext('2d');
            context.fillStyle = "#AAA";
            context.fillRect(0, 0, canvas.width, canvas.height);
            var data = canvas.toDataURL('image/png');
            if (pan.getAttribute('value') != null && pan.getAttribute('value') != "") {
                photo.setAttribute('src', pan.getAttribute('value'));
            } else {
                photo.setAttribute('src', data);
                pan.setAttribute('value', "");
            }

        }

        function takepicture() {
            var context = canvas.getContext('2d');
            if (width && height) {
                canvas.width = width;
                canvas.height = height;
                context.drawImage(video, 0, 0, width, height);

                var data = canvas.toDataURL('image/png');
                photo.setAttribute('src', data);
                pan.setAttribute('value', data);
                if ($("#pan_photo-error").length) {
                    // $("#pan_photo-error")[0].innerText = "";
                }

            } else {
                clearphoto();
            }
        }

        window.addEventListener('load', startup, false);
    })();
</script> -->
<script type="text/javascript">
    function CheckServices(val) {

        if (val == 'Education/Skill Development Specialist') {
            document.getElementById('education_type').style.display = 'block';
            // document.getElementById("education_type").required = true;
        } else {
            document.getElementById('education_type').style.display = 'none';
            // document.getElementById("education_type").required = false;
        }
        if (val == 'Creative Field') {
            document.getElementById('creative_type').style.display = 'block';
            // document.getElementById("creative_type").required = true;
        } else {
            document.getElementById('creative_type').style.display = 'none';
            // document.getElementById("creative_type").required = false;
        }
        if (val == 'Others') {
            document.getElementById('other_service_type').style.display = 'block';
            // document.getElementById("other_service_type").required = true;
        } else {
            document.getElementById('other_service_type').style.display = 'none';
            // document.getElementById("other_service_type").required = false;
        }
    }
</script>

<!-- <script type="text/javascript">
       $(document).ready(function() {
           CheckServices(<?php echo $this->auth_user->supplier_type_services ?>);
      
    </script> -->