<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
//var_dump($this->auth_user);
$cities = get_india_cities();
$usp_contents = get_usp();
$exempted_goods = get_exempted_food();
$pincode = get_pincode(281204);

// var_dump($usp_contents);

?>
<!-- Wrapper -->
<!doctype html>

<head>
    <style>
        .tooltip-styling {
            background: #ccd6bf !important;
            color: black !important;
        }

        .tooltip .tooltip-inner {
            background-color: black !important;
            color: white;
            font-size: 12px;
        }

        .btn-generate-recommandation {
            position: absolute;
            right: 25px;
            top: 9px;
            padding: 2px 6px;
            font-size: 13px;
            border-radius: 20px;
            color: white;
        }

        /* .modal-header {
            background: linear-gradient(to right, #e1e2c5 0%, #f6e0ae 17%, #ffdfa5 28%, #ffdea8 42%, #ffdbc1 71%, #ffd5c8 100%) !important;
        } */

        .btn-generate-recommandation:hover {
            color: white;
        }

        /* @media (min-width: 576px) { */
        .terms-cond {
            max-width: 1000px;
            margin: 1.75rem auto;
        }

        .modal-content {
            border: 0px;
        }

        /* } */
        .cont p {
            padding: 0 20px;
            font-size: 18px;
        }

        #terms_box.auth-box {
            width: 1000px;
            height: 700px;
            overflow-y: scroll;
            border-radius: 0px;
            /* background: linear-gradient(to right, #e1e2c5 0%, #f6e0ae 17%, #ffdfa5 28%, #ffdea8 42%, #ffdbc1 71%, #ffd5c8 100%); */
            margin: auto;

        }

        #terms_box.auth-box-dialog {
            overflow-y: initial !important
        }

        #terms_box.auth-box-body {
            height: 250px;
            overflow-y: none;
        }

        #myImg {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        #myImg:hover {
            opacity: 0.7;
        }

        .capital {
            text-transform: capitalize;
        }

        .btn-primary1 {
            background-color: #007C05;
            border-radius: 20px;
            color: white;
        }

        .btn-default {
            background-color: #007C05;
            border-radius: 20px;

        }


        @keyframes click-wave {
            0% {
                height: 40px;
                width: 40px;
                opacity: 0.35;
                position: relative;
            }

            100% {
                height: 200px;
                width: 200px;
                margin-left: -80px;
                margin-top: -80px;
                opacity: 0;
            }
        }

        .option-input {
            -webkit-appearance: none;
            -moz-appearance: none;
            -ms-appearance: none;
            -o-appearance: none;
            appearance: none;
            position: relative;
            top: 13.33333px;
            right: 0;
            bottom: 0;
            left: 0;
            height: 25px;
            width: 25px;
            transition: all 0.15s ease-out 0s;
            background: #cbd1d8;
            border: none;
            color: #fff;
            cursor: pointer;
            display: inline-block;
            margin-right: 0.5rem;
            outline: none;
            position: relative;
            z-index: 1000;
        }

        .option-input:hover {
            background: #F1C1BC;
        }

        .option-input:checked {
            background: #F1C1BC;
        }

        .option-input:checked::before {
            height: 25px;
            width: 25px;
            position: absolute;
            content: '✔';
            display: inline-block;
            font-size: 26.66667px;
            text-align: center;
            line-height: 28px;
            color: #58595B;
        }

        .option-input:checked::after {
            -webkit-animation: click-wave 0.65s;
            -moz-animation: click-wave 0.65s;
            animation: click-wave 0.65s;
            background: #F1C1BC;
            content: '';
            display: block;
            position: relative;
            z-index: 100;
        }

        .option-input.radio {
            border-radius: 50%;
        }

        .option-input.radio::after {
            border-radius: 50%;
        }

        /* Add Animation */
        .modal-content,
        #caption {
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
            from {
                -webkit-transform: scale(0)
            }

            to {
                -webkit-transform: scale(1)
            }
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 15px;
            right: 15px;
            color: #020202;
            font-size: 30px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }
        }

        input[type=radio] {
            box-sizing: border-box;
            padding: 0;
            height: 1.125rem;
        }


        /* CSS comes here */
        /* body {
            margin-top: 30px;
        } */
        .next {
            float: right;
        }

        .pre {
            text-align: left;
        }

        .button {
            background-color: #007C05;
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
            border-radius: 20px;
        }

        .button1 {
            background-color: #007C05;
            color: white;
            border: 2px solid #4CAF50;
        }

        .button1:hover {
            background-color: #007C05;
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
            text-align: center;
            color: white;
            text-transform: uppercase;
            font-size: 9px;
            width: 24%;
            float: left;
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

        #know_more_box {
            height: 650px;
            overflow-y: scroll;
            overflow-x: hidden;
            border-radius: 20px;
            margin: auto;
            /* background-image: url(assets/img/background3.png); */
            background-color: #f8f9fad6;
            backdrop-filter: blur(3px);
        }

        #barting {
            text-align: center;
            margin-top: 4%;
            margin-bottom: 4%;
            font-weight: bold;
        }

        #ABOUT_LOGO {
            width: 100%;
            margin: auto auto;
            text-align: center;
            margin-top: 15%;
        }

        #logax {
            width: 253%;
        }

        @media (max-width: 500px) {
            #logax {
                width: 99%;
            }

        }


        #tix {
            margin-left: 1%;
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>

<body>
    <!-- term and conditions model -->
    <div class="modal fade" id="termsCondition" role="dialog" style="display:none;">
        <div class="modal-dialog  terms-cond modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="auth-box" id="terms_box">
                    <button type="button" class="close" data-dismiss="modal" onclick=""><i class="icon-close"></i></button>
                    <!-- <h4 class="title">Terms & Conditions For Sellers</h4> -->
                    <?php echo get_content("supplier_terms_conditions"); ?>
                    <div class="col-12" style="text-align: center;">
                        <a class="btn btn-custom" href="assets/file/Seller_Agreement.pdf" download>Download</a>
                        <button type="button" class="btn btn-custom" data-dismiss="modal" onclick="t_c1()">Accept</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="termsCondition1" role="dialog" style="display:none;">
        <div class="modal-dialog modal-dialog-centered login-modal" role="document">
            <div class="modal-content">
                <div class="auth-box">
                    <button type="button" class="close" data-dismiss="modal" onclick=""><i class="icon-close"></i></button>
                    <h4 class="title">Terms & Conditions</h4>
                    <h3> for services </h3>
                    <center><button type="button" class="btn btn-custom" data-dismiss="modal" onclick="t_c2()">Accept</button></center>

                </div>
            </div>
        </div>
    </div>
    <!-- end here -->

    <div id="wrapper">
        <div class="container">
            <div class="row">

                <!-- <div class="col-12">
                    <div class="seller-selling-image">
                        <img src="<?php echo base_url() . "/assets/img/seller-board.png" ?>" class="img-fluid" alt="Start_selling_png">
                        <h1 class="page-title page-title-product m-b-15"><?php echo trans("start_selling"); ?></h1>
                        <p class="start-selling-description-custom text-muted"><?php echo trans("start_selling_exp"); ?></p>
                    </div>
                </div> -->
                <div id="content" class="col-12">
                    <!-- <nav class="nav-breadcrumb" aria-label="breadcrumb">
                        <ol class="breadcrumb"></ol>
                    </nav> -->
                    <div class="form-add-product">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-12 col-lg-10">

                                <?php if ($this->auth_check) :
                                    if ($this->auth_user->is_active_shop_request == 1) : ?>

                                    <?php elseif ($this->auth_user->is_active_shop_request == 2) : ?>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="alert alert-secondary" role="alert">
                                                    <?php echo trans("msg_shop_request_declined"); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php elseif ($this->auth_user->is_active_shop_request == 3) : ?>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="alert custom-alert" role="alert">
                                                    Welcome to the Gharobaar Family. Your account has been approved, and we will get back to you with the next steps soon.
                                                </div>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="seller-selling-image">
                                                    <!-- <img src="<?php echo base_url() . "/assets/img/seller-board.png" ?>" class="img-fluid" alt="Start_selling_png" id="start_selling_png_image"> -->
                                                    <h1 class="page-title page-title-product m-b-15"><?php echo trans("start_selling"); ?></h1>
                                                    <p class="start-selling-description-custom text-muted"><?php echo trans("start_selling_exp"); ?></p>
                                                </div>
                                            </div>
                                            <div class="col-12" style="padding-left:23px;">
                                                <?php echo form_open('start-selling-post', ['id' => 'form_validate', 'class' => 'validate_terms', 'onkeypress' => "return event.keyCode != 13;"]); ?>
                                                <?php if (!empty($plan)) : ?>
                                                    <input type="hidden" name="plan_id" value="<?php echo $plan->id; ?>">
                                                <?php endif; ?>

                                                <div class="form-box m-b-15 ">
                                                    <div class="next_hide">
                                                        <div class="form-box-head text-center">
                                                            <h3 class="title title-start-selling-box" style="font-weight: bold;">Supplier Type</h3>

                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row" style="text-align: center;">
                                                                <div class="col-6"> <label class="large-radio"><input type="radio" class="form-switch" name="supplier_type" value="Goods" data-id="a" checked> Goods</label></div>
                                                                <div class="col-6"><label class="large-radio"><input type="radio" class="form-switch" name="supplier_type" value="Services" data-id="b"> Services</label> </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- starting form A -->
                                                    <div class="form-box-body form form-a active">

                                                        <div class="form-box-head text-center">
                                                            <h4 class="title title-start-selling-box-custom">Tell us about you</h4>
                                                        </div>
                                                        <div class="container">
                                                            <div class="stepwizard">
                                                                <div class="progress center-block">
                                                                    <div class="progress-bar progress-bar-success active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 13%">
                                                                    </div>
                                                                </div>

                                                                <div class="stepwizard-row setup-panel">
                                                                    <div class="stepwizard-step col-xs-3">
                                                                        <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                                                                        <p><small>Business Details</small></p>
                                                                    </div>
                                                                    <div class="stepwizard-step col-xs-3">
                                                                        <a href="#step-2" type="button" class="btn btn-default btn-circle stop-pointer" disabled="disabled">2</a>
                                                                        <p><small>Contact Information</small></p>
                                                                    </div>
                                                                    <div class="stepwizard-step col-xs-3">
                                                                        <a href="#step-3" type="button" class="btn btn-default btn-circle stop-pointer" disabled="disabled">3</a>
                                                                        <p><small>Product Information</small></p>
                                                                    </div>
                                                                    <div class="stepwizard-step col-xs-3">
                                                                        <a href="#step-4" type="button" class="btn btn-default btn-circle stop-pointer" disabled="disabled">4</a>
                                                                        <p><small>Additional Information(Optional)</small></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="panel panel-primary setup-content" id="step-1">
                                                            <div class="panel-heading">
                                                                <h3 class="panel-title">Business Details</h3>
                                                            </div>
                                                            <div class="panel-body custom-panel">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-6 m-b-15">

                                                                            <label class="control-label">Select Goods Type<span class="Validation_error"> *</span></label>
                                                                            <select name="supplier_type_goods" id="supplier_type_goods" class="form-control auth-form-input" required>
                                                                                <option value="" disabled selected>Select Goods Type</option>
                                                                                <option value="Food Products">Food Products</option>
                                                                                <option value="Non Food Products">Non Food Products</option>
                                                                                <option value="Both">Both</option>


                                                                            </select>
                                                                            <p class="Validation_error" id="supplier_type_goods_p"></p>
                                                                        </div>

                                                                    </div>
                                                                </div>



                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-6 m-b-15">
                                                                            <label class="control-label">Company name<span class="Validation_error"> *</span></label>
                                                                            <input type="text" name="shop_name" class="form-control auth-form-input " placeholder="Enter your company name" required>
                                                                            <p class="Validation_error" id="company_name_p"></p>
                                                                        </div>
                                                                        <div class="col-12 col-sm-6 m-b-15">
                                                                            <label class="control-label">Brand Name<span class="Validation_error"> *</span></label>
                                                                            <input type="text" name="brand_name" class="form-control form-input" maxlength="<?php echo $this->username_maxlength; ?>" required>
                                                                            <p class="Validation_error" id="brand_name_p1"></p>
                                                                        </div>
                                                                        <div class="col-12 col-sm-6 m-b-15">
                                                                            <label class="control-label">Company Type<span class="Validation_error"> *</span></label>
                                                                            <select name="company_type" id="company_type" onchange='CheckCompany(this.value);' class="form-control auth-form-input" placeholder="" required>
                                                                                <option value="" selected disabled>Select</option>
                                                                                <option value="Partnership">Partnership</option>
                                                                                <option value="Private Limited">Private Limited</option>
                                                                                <option value="Limited Liability Partnership">Limited Liability Partnership</option>
                                                                                <option value="Sole Proprietorship">Sole Proprietorship</option>
                                                                                <option value="One person Company">One person Company</option>
                                                                                <option value="NGO">NGO</option>
                                                                                <option value="Joint Venture">Joint Venture</option>
                                                                                <option value="Other">Other</option>
                                                                            </select>

                                                                            <div id="other" style='display:none;'>
                                                                                <label class="control-label">Other (please specify)</label>
                                                                                <input type="text" name="other_type" class="form-control auth-form-input">
                                                                            </div>
                                                                            <p class="Validation_error" id="company_type_p"></p>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label"><?php echo trans("first_name"); ?><span class="Validation_error"> *</span></label>
                                                                            <input type="text" name="first_name" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->first_name); ?>" placeholder="<?php echo trans("first_name"); ?>" required>
                                                                            <p class="Validation_error" id="first_name_p"></p>
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Middle Name</label>
                                                                            <input type="text" name="middle_name" class="form-control auth-form-input" placeholder="Middle Name">

                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label"><?php echo trans("last_name"); ?><span class="Validation_error"> *</span></label>
                                                                            <input type="text" name="last_name" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->last_name); ?>" placeholder="<?php echo trans("last_name"); ?>" required>
                                                                            <p class="Validation_error" id="last_name_p"></p>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Seller's Date of birth<span class="Validation_error"> *</span></label>
                                                                            <input type="text" name="date_of_birth" class="form-control auth-form-input datepick" placeholder="dd-mm-yyyy" onkeypress="return nothingReturn(event)" required>
                                                                            <p class="Validation_error" id="dob_p"></p>
                                                                        </div>
                                                                        <!-- <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Seller's Date of birth<span class="Validation_error"> *</span></label>
                                                                            <input onfocus="(this.type='date')" name="date_of_birth" min='1899-01-01' max='2000-13-13' id="dob" class="form-control auth-form-input" placeholder="Date of Birth" required>
                                                                            <p class="Validation_error" id="dob_p"></p>
                                                                        </div> -->
                                                                        <?php if ($this->auth_user->date_of_birth == "" || $this->auth_user->gender == "") { ?>
                                                                            <div class="col-12 col-sm-4 m-b-15">
                                                                                <label class="control-label">Gender</label>
                                                                                <input type="text" name="gender" class="form-control auth-form-input" value="<?php echo $this->auth_user->gender; ?>" placeholder="Gender">
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label">Do you have GST Number ?<span class="Validation_error"> *</span></label>
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-4 col-custom-field">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" name="gst_yes_no" id="gst_have_yes" value="Y" class="custom-control-input" checked required>
                                                                                <label for="gst_have_yes" class="custom-control-label">Yes</label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-12 col-sm-4 col-custom-field">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" name="gst_yes_no" id="gst_have_no" value="N" class="custom-control-input" required>
                                                                                <label for="gst_have_no" class="custom-control-label">No</label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-12 col-sm-4 col-custom-field">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" name="gst_yes_no" id="gst_applied_for" value="Applied for GST" class="custom-control-input" required>
                                                                                <label for="gst_applied_for" class="custom-control-label">Applied for GST</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row hideMe" id="selected_yes">
                                                                        <div class="col-12 col-sm-6 col-custom-field">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" name="gst" id="gst_have" class="custom-control-input">
                                                                                <label for="gst_have" class="custom-control-label">Have GST Number ?</label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-12 col-sm-6 col-custom-field">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" name="gst" id="gst_do_not_have" class="custom-control-input">
                                                                                <label for="gst_do_not_have" class="custom-control-label">Have GST Application number ?</label>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="selling_exempted_goods" id="selling_ex" class="form-control auth-form-input" value="" />
                                                                    <div class="row hideMe" id="selected_no">
                                                                        <div class="col-12 col-sm-4 col-custom-field mt-3">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" name="type_of_goods" id="food_delivery" value="Food delivery services (Annual turnover less than 20 lakh)" class="custom-control-input">
                                                                                <label for="food_delivery" class="custom-control-label">Food delivery services (Annual turnover less than 20 lakh)</label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-12 col-sm-4 col-custom-field mt-3">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" name="type_of_goods" value="exempted_goods" id="exempted_goods" class="custom-control-input">
                                                                                <label for="exempted_goods" class="custom-control-label">Selling exempted goods</label>

                                                                            </div>
                                                                        </div>

                                                                        <div class="col-12 col-sm-4 col-custom-field mt-3">
                                                                            <div class="custom-control custom-radio">

                                                                                <input type="radio" name="type_of_goods" value="gharobaar_with_gst" id="gharobaar_with_gst" class="custom-control-input">
                                                                                <label for="gharobaar_with_gst" id="gharobaar_gst" title="Even if you do not have a GST Number, you can still sell on the platform by partnering with Gharobaar - You simply have to register using our GST number.  Please write to sellerhelp@gharobaar.com in case you need more information about this" class="custom-control-label">

                                                                                    Use Gharobaar GST
                                                                                    <i class="fa fa-info-circle"></i>
                                                                                </label>



                                                                            </div>
                                                                        </div>

                                                                        <div class="col-12 col-sm-4 col-custom-field mt-3">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" name="type_of_goods" id="none" value="none" class="custom-control-input">
                                                                                <label for="none" class="custom-control-label">None</label>

                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                                <div class="form-group">

                                                                    <div id="have_gst" style="display: none">
                                                                        <label class="control-label">Enter GST Number<span class="Validation_error"> *</span></label>
                                                                        <input type="text" id="gsthave1" name="gst_number" oninput="this.value = this.value.toUpperCase()" class="form-control auth-form-input ">
                                                                        <p class="Validation_error" id="gst_number_p"></p>
                                                                    </div>

                                                                    <div id="not_have_gst" style="display: none">
                                                                        <label class="control-label">Enter GST Application number<span class="Validation_error"> *</span></label>
                                                                        <input type="text" id="gstdonothave1" name="gst_application_number" oninput="this.value = this.value.toUpperCase()" class="form-control auth-form-input ">
                                                                        <p class="Validation_error" id="gst_application_p"></p>
                                                                    </div>
                                                                </div>



                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <!-- <div class="col-12 col-sm-4 m-b-15">
                                                                                <label class="control-label">GST Number<span class="Validation_error"> *</span></label>
                                                                                <input type="text" name="gst_number" id="gst_number" class="form-control auth-form-input" placeholder="GST number" required minlength="15" maxlength="15" pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}">
                                                                                <p class="Validation_error" id="gst_number_p"></p>
                                                                            </div> -->
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Annual Turnover<span class="Validation_error" id="turnover-req"></span></label>
                                                                            <select name="turnover" id="turnover" class="form-control auth-form-input" placeholder="">
                                                                                <option value="" selected disabled>Select</option>
                                                                                <option value="Less than 5 lakhs">Less than 5 lakhs</option>
                                                                                <option value="5-10 lakh">5-10 lakh</option>
                                                                                <option value="10-20 lakh">10-20 lakh</option>
                                                                                <option value="Above 20 lakh">Above 20 lakh</option>
                                                                            </select>
                                                                            <p class="Validation_error" id="turnover_p"></p>
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Permanent Account Number (PAN)<span class="Validation_error"> *</span></label>
                                                                            <input type="text" name="pan_number" id="pan_number" oninput="this.value = this.value.toUpperCase()" class="form-control auth-form-input" placeholder="Pan number" required minlength="10" maxlength="10" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}">
                                                                            <p class="Validation_error" id="pan_number_p"></p>
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Aadhaar Number</label>
                                                                            <input type="text" minlength="12" maxlength="12" name="adhaar_number" class="form-control auth-form-input" placeholder="Aadhaar Number" onKeyPress="if(this.value.length==12) return false; return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label">Do you have a Trademark ? (if no, then please accept the addendum that will open)<span class="Validation_error"> *</span></label>
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-4 col-custom-field">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" name="trademark_yes_no" value="Y" id="trademark_have_yes" class="custom-control-input" checked required>
                                                                                <label for="trademark_have_yes" class="custom-control-label">Yes</label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-12 col-sm-4 col-custom-field">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" name="trademark_yes_no" value="N" id="trademark_have_no" class="custom-control-input" required>
                                                                                <label for="trademark_have_no" class="custom-control-label">No</label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-12 col-sm-4 col-custom-field">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" name="trademark_yes_no" value="Ap" id="trademark_applied_for" class="custom-control-input" required>
                                                                                <label for="trademark_applied_for" class="custom-control-label">Applied for Trademark</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-6 m-b-15 hideMe" id="fssai_div">
                                                                            <label class="control-label">Enter FSSAI License/Registration Number<span class="Validation_error"> *</span></label>
                                                                            <input type="text" name="fssai_number" class="form-control auth-form-input" maxlength="14" minlength="14" onkeypress="return onlyNumberKey(event)" required>
                                                                            <p class="Validation_error" id="fssai_number_p"></p>
                                                                        </div>
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
                                                                                <input type="text" id="pan_photo" name="pan_photo" class="form-control auth-form-input" style="display: none;">
                                                                                <p class="Validation_error" id="pan_photo_p"></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-6 m-b-15">
                                                                            <label class="control-label">Area of operation<span class="Validation_error"> *</span></label>
                                                                            <select name="area_in_operation" id="area_in_operation" class="form-control auth-form-input" placeholder="" required>
                                                                                <option value="" selected disabled>Select</option>
                                                                                <option value="Within Locality (Typically 0-5 kms radius)">Within Locality (Typically 0-5 kms radius)</option>
                                                                                <option value="Within City (Typically 0-30 km radius)">Within City (Typically 0-30 km radius)</option>
                                                                                <option value="Nearby areas (including adjacent inter-state areas)">Nearby areas (including adjacent inter-state areas)</option>
                                                                                <option value="Within State">Within State</option>
                                                                                <!-- <option value="Limited Liability Partnership">PAN India</option> -->
                                                                                <option value="Pan India">Pan India</option>
                                                                                <option value="International">International</option>
                                                                            </select>
                                                                            <p class="Validation_error" id="area_in_operation_p"></p>

                                                                        </div>
                                                                        <div class="col-12 col-sm-6 m-b-15">
                                                                            <label class="control-label">Active Customers</label>
                                                                            <select name="active_customers" id="active_customers" class="form-control auth-form-input" placeholder="">
                                                                                <option value="" selected disabled>Select</option>
                                                                                <option value="Less than 50">Less than 50</option>
                                                                                <option value="50-100">50-100</option>
                                                                                <option value="100-300">100-300</option>
                                                                                <option value="More than 300">More than 300</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-6 m-b-15">
                                                                            <label class="control-label">Minimum Order Value (if any)</label>
                                                                            <input type="text" name="min_order_value" class="form-control auth-form-input" onkeypress='return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57'>
                                                                            <!-- <p class="Validation_error" id="area_in_operation_p"></p> -->
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <?php if ($this->general_settings->enable_ship_selection == 1) : ?>



                                                                    <div class="form-group">
                                                                        <label class="control-label">Shipment Type ?<span class="Validation_error"> *</span></label>
                                                                        <div class="row">
                                                                            <div class="col-12 col-sm-4 col-custom-field">
                                                                                <div class="custom-control custom-radio">
                                                                                    <input type="radio" name="ship_yes_no" id="self_ship_yes" value="gharobaar" class="custom-control-input" checked required>
                                                                                    <label for="self_ship_yes" class="custom-control-label">Gharobaar</label>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-12 col-sm-4 col-custom-field">
                                                                                <div class="custom-control custom-radio">
                                                                                    <input type="radio" name="ship_yes_no" id="self_ship_no" value="self_shipped" class="custom-control-input" required>
                                                                                    <label for="self_ship_no" class="custom-control-label">Self Shipped</label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group hideMe" id="selected_self">
                                                                        <label class="control-label">Shipping Charges ?<span class="Validation_error"> *</span></label>
                                                                        <div class="row ">

                                                                            <div class="col-12 col-sm-4 col-custom-field">
                                                                                <div class="custom-control custom-radio">
                                                                                    <input type="radio" name="ship_charge" id="ship_charge_yes" value="yes" class="custom-control-input">
                                                                                    <label for="ship_charge_yes" class="custom-control-label">Yes</label>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-12 col-sm-4 col-custom-field">
                                                                                <div class="custom-control custom-radio">
                                                                                    <input type="radio" name="ship_charge" id="ship_charge_no" value="no" class="custom-control-input" checked>
                                                                                    <label for="ship_charge_no" class="custom-control-label">No</label>

                                                                                </div>
                                                                            </div>
                                                                        </div>



                                                                    </div>


                                                                    <div class="form-group" id="ship_cod" style="display: none;">
                                                                        <div class="row">
                                                                            <div class="col-12 col-sm-4 m-b-15">
                                                                                <label class="control-label">Minimum Threshold<span class="Validation_error"> *</span></label>
                                                                                <input type="text" id="min_thresh" name="min_thresh" class="form-control auth-form-input" onkeypress='return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57'>
                                                                                <p class="Validation_error" id="min_thresh_v"></p>
                                                                            </div>
                                                                            <div class="col-12 col-sm-4 m-b-15">
                                                                                <label class="control-label">Shipping Amount<span class="Validation_error"> *</span></label>
                                                                                <input type="text" id="ship_amt" name="ship_amt" class="form-control auth-form-input" onkeypress='return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57'>
                                                                                <p class="Validation_error" id="ship_amt_v"></p>
                                                                            </div>
                                                                            <div class="col-12 col-sm-4 m-b-15">
                                                                                <label class="control-label">COD Charges<span class="Validation_error"> *</span></label>
                                                                                <input type="text" id="cod_chrg" name="cod_chrg" class="form-control auth-form-input" onkeypress='return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57'>
                                                                                <p class="Validation_error" id="cod_chrg_v"></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>



                                                                <?php endif; ?>

                                                                <div class="col-md-12">
                                                                    <div class="col-12">
                                                                        <nav>
                                                                            <!-- <div class="pager row"> -->
                                                                            <a class="nextBtn" href="#">
                                                                                <li class="next button button1">Next <span aria-hidden="true">&rarr;</span> </li>
                                                                            </a>
                                                                            <!-- </div> -->
                                                                        </nav>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="panel panel-primary setup-content" id="step-2">
                                                            <div class="panel-heading">
                                                                <h3 class="panel-title">Contact Details</h3>
                                                            </div>
                                                            <div class="panel-body custom-panel">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label"><?php echo trans("phone_number"); ?><span class="Validation_error"> *</span></label>
                                                                            <input type="text" minlength="10" maxlength="10" name="phone_number" class="form-control auth-form-input" placeholder="<?php echo trans("phone_number"); ?>" value="<?php echo html_escape($this->auth_user->phone_number); ?>" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" required>
                                                                            <p class="Validation_error" id="phone_number_p"></p>
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Alternate Mobile Number</label>
                                                                            <input type="number" name="alternative_number" class="form-control auth-form-input" placeholder="Alternative number" onKeyPress="if(this.value.length==10) return false;">
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Landline</label>
                                                                            <input type="number" name="landline_number" class="form-control auth-form-input" pattern="\d{5}([- ]*)\d{6}" placeholder="Landline number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">

                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Pincode<span class="Validation_error"> *</span>
                                                                            </label>
                                                                            <input type="number" name="pincode" id="pincode" class="form-control auth-form-input" placeholder="Pincode" required maxlength="6" minlength="6" required onkeyup="get_location($( '#pincode').val())">
                                                                            <!-- <p class="Validation_error" id="pincode_p"></p> -->
                                                                            <span class="Validation_error" id="pincode_span"></span>
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">State<span class="Validation_error"> *</span>
                                                                            </label>
                                                                            <input type="text" name="supplier_state" id="supplier_state" class="form-control auth-form-input" placeholder="State" required readonly>
                                                                            <p class="Validation_error" id="state_p"></p>
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">City<span class="Validation_error"> *</span>
                                                                            </label>
                                                                            <input type="text" name="supplier_city" id="supplier_city" class="form-control auth-form-input" placeholder="City" required readonly>
                                                                            <p class="Validation_error" id="city_p"></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Area<span class="Validation_error"> *</span></label>
                                                                            <input type="text" name="area" class="form-control auth-form-input" placeholder="Area" required>
                                                                            <p class="Validation_error" id="area_p"></p>
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">House no./Building no./Area<span class="Validation_error"> *</span>
                                                                            </label>
                                                                            <input type="text" name="house_no" class="form-control auth-form-input" placeholder="House no./Building no./Area" required minlength="10">
                                                                            <p class="Validation_error" id="house_no_p"></p>
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Landmark</label>
                                                                            <input type="text" name="landmark" class="form-control auth-form-input" placeholder="Landmark">
                                                                            <p class="Validation_error" id="landmark_p"></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <nav>
                                                                        <a class="prevBtn" href="#">
                                                                            <li class="previous button button1"><span aria-hidden="true">&larr;</span> Previous</li>
                                                                        </a>

                                                                        <a class="nextBtn" href="#">
                                                                            <li class="next button button1">Next <span aria-hidden="true">&rarr;</span></li>
                                                                        </a>
                                                                    </nav>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="panel panel-primary setup-content" id="step-3">
                                                            <div class="panel-heading">
                                                                <h3 class="panel-title">Product Information</h3>
                                                            </div>
                                                            <div class="panel-body custom-panel">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label" data-toggle="tooltip" title="A brief description of what makes your product or service exceptional and different from your competitors" data-placement="right">USP (Unique Selling Proposition)<span class="Validation_error"> *</span> <i class="fa fa-info-circle"></i> </label>
                                                                        </div>
                                                                        <div class="col-12 col-sm-8 m-b-15">
                                                                            <input type="text" name="usp_goods" id="usp_goods" placeholder="You can type and/or select one of the options from Recommendations." class="form-control auth-form-input" required value="" />
                                                                            <p class="Validation_error" id="usp_p"></p>
                                                                            <button type="button" class="btn btn-default btn-generate-recommandation" onclick="ClickTextbox()" style="font-size: smaller;">Recommendations</button>


                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Your Story (Brief background of your company/youself/product)</label>
                                                                    <textarea name="about_me" class="form-control form-textarea" placeholder="Write brief background of your company/youself/product..."></textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-6 m-b-15">
                                                                            <label class="control-label">Years in Operation<span class="Validation_error"> *</span></label>
                                                                            <select name="years_in_operation" id="years_in_operation" class="form-control auth-form-input" placeholder="" required>
                                                                                <option value="" selected disabled>Select</option>
                                                                                <option value="0-6">Less than 6 months</option>
                                                                                <option value="6-24">6 months to 2 years</option>
                                                                                <option value="5-10">2-5 years</option>
                                                                                <option value="more than 5">More than 5 years</option>
                                                                            </select>
                                                                            <p class="Validation_error" id="years_in_operation_p"></p>
                                                                        </div>
                                                                        <div class="col-12 col-sm-6 m-b-15">
                                                                            <label class="control-label">How Did You hear about us?<span class="Validation_error"> *</span></label>
                                                                            <select name="how_hear_about_us" id="how_hear_about_us" class="form-control auth-form-input" placeholder="" required>
                                                                                <option value="" selected disabled>Select</option>
                                                                                <option value="Invited by gharobaar">Invited by gharobaar</option>
                                                                                <option value="Facebook">Facebook</option>
                                                                                <option value="Instagram">Instagram</option>
                                                                                <option value="Google">Google</option>
                                                                                <option value="Friends and family ">Friends and family </option>
                                                                                <option value="Linkedin">Linkedin</option>
                                                                                <option value="Email">Email</option>
                                                                                <option value="Reference">Reference</option>

                                                                            </select>
                                                                            <p class="Validation_error" id="how_hear_about_us_p"></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <br>
                                                                            <label class="control-label">What assistance do you want from our platform? <span class="Validation_error"> *</span></label>
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <br>
                                                                            <input type="text" autocomplete="off" name="assistance" id="assistance" class="form-control auth-form-input" data-toggle="modal" data-target="#assistance-modal">
                                                                            <p class="Validation_error" id="assistance_p"></p>
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Any Other (Describe in field)</label>
                                                                            <input type="text" name="other_assistance" class="form-control auth-form-input">
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-6 m-b-15">
                                                                            <label class="control-label">Open to Barter with other suppliers? <span class="Validation_error"> *</span><a href="#" style="text-decoration:underline;color:blue;" data-toggle="modal" data-target="#knowmore">(Know More)</a></label>
                                                                            <br>
                                                                            &nbsp;&nbsp;<input type="radio" name="barter" value="Y" checked>
                                                                            <label for="y">Yes</label>
                                                                            <input type="radio" name="barter" value="N">
                                                                            <label for="n"> No</label>
                                                                        </div>
                                                                        <p class="Validation_error" id="barter_p"></p>
                                                                    </div>

                                                                </div>


                                                                <div class="col-12">
                                                                    <nav>
                                                                        <a class="prevBtn" href="#">
                                                                            <li class="previous button button1"><span aria-hidden="true">&larr;</span> Previous</li>
                                                                        </a>
                                                                        <a class="nextBtn" href="#">
                                                                            <li class="next button button1">Next <span aria-hidden="true">&rarr;</span></li>
                                                                        </a>
                                                                    </nav>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="panel panel-primary setup-content" id="step-4">
                                                            <div class="panel-heading">
                                                                <h3 class="panel-title">Additional Information(Optional)</h3>
                                                            </div>
                                                            <div class="panel-body custom-panel">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-3 m-b-15">
                                                                            <img src="<?php echo base_url(); ?>assets/img/social-icons/earth-icon.png" alt="" style="width: 28px; height: 28px;margin-bottom:4px 0;" />
                                                                            <label class="control-label">Website Link</label>
                                                                            <input type="url" placeholder="https://example.com" name="website_url" class="form-control auth-form-input" placeholder="Website Link">
                                                                        </div>
                                                                        <div class="col-12 col-sm-3 m-b-15">
                                                                            <img src="<?php echo base_url(); ?>assets/img/social-icons/facebook-icon.png" alt="" style="width: 28px; height: 28px;" />

                                                                            <label class="control-label">Facebook Page Link</label>
                                                                            <input type="text" name="facebook_url" class="form-control auth-form-input" placeholder="FaceBook Link">
                                                                        </div>
                                                                        <div class="col-12 col-sm-3 m-b-15">
                                                                            <img src="<?php echo base_url(); ?>assets/img/social-icons/insta-icon.png" alt="" style="width: 28px; height: 28px;" />
                                                                            <label class="control-label">Instagram Page Link
                                                                            </label>
                                                                            <input type="text" name="instagram_url" class="form-control auth-form-input" placeholder="Instagram Link">
                                                                        </div>
                                                                        <div class="col-12 col-sm-3 m-b-15">
                                                                            <img src="<?php echo base_url(); ?>assets/img/social-icons/any-other-site-icon.png" alt="" style="width: 20px; height: 20px;margin:4px 0;" />
                                                                            <label class="control-label">Any Other Page Link
                                                                            </label>
                                                                            <input type="text" name="other_url" class="form-control auth-form-input" placeholder="Any Other Link">
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Anniversary</label>
                                                                            <input type="date" minlength="10" maxlength="10" name="anniversary" class="form-control auth-form-input" placeholder="Anniversary">

                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Are you selling on other platforms? </label>
                                                                            <input type="text" name="other_platforms" class="form-control auth-form-input" placeholder="platforms">
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Anything else you would like to share...</label>
                                                                            <input type="text" name="share" class="form-control auth-form-input" placeholder="">
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="form-group m-t-15">
                                                                    <div class="custom-control custom-checkbox custom-control-validate-input">
                                                                        <input type="checkbox" class="custom-control-input" name="terms_conditions" id="terms_conditions" value="1" readonly="readonly">
                                                                        <label for="terms_conditions" class="custom-control-label"><?php echo trans("terms_conditions_exp"); ?>&nbsp;
                                                                            <?php $page_terms = get_page_by_default_name("terms_conditions", $this->selected_lang->id);
                                                                            if (!empty($page_terms)) : ?>
                                                                                <strong data-toggle="modal" data-target="#termsCondition"><u style="color: blue;">(Seller Agreement)</u></strong>
                                                                            <?php endif; ?>
                                                                        </label>

                                                                    </div>
                                                                    <small id="small-text" style="display:none;color:red;">(<?php echo trans("seller_agreement_msg"); ?>)</small>
                                                                </div>


                                                                <div class="col-12">
                                                                    <nav>
                                                                        <a class="prevBtn" href="#">
                                                                            <li class="previous button button1"><span aria-hidden="true">&larr;</span> Previous</li>
                                                                        </a>
                                                                        <button type="submit" class="btn btn-lg btn-custom float-right"><?php echo trans("submit"); ?></button>

                                                                    </nav>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php echo form_close(); ?>
                                            </div>

                                            <div class="col-12">
                                                <?php echo form_open('start-selling-services', ['id' => 'form_validate_service', 'class' => 'validate_terms', 'onkeypress' => "return event.keyCode != 13;"]); ?>
                                                <?php if (!empty($plan)) : ?>
                                                    <input type="hidden" name="plan_id" value="<?php echo $plan->id; ?>">
                                                <?php endif; ?>
                                                <div class="form-box m-b-15">

                                                    <!-- starting form B -->
                                                    <div class="form-box-body form form-b">
                                                        <div class="form-box-head text-center">
                                                            <h4 class="title title-start-selling-box-custom">Tell us about your services</h4>
                                                        </div>
                                                        <div class="container">
                                                            <div class="stepwizard">
                                                                <div class="progress center-block">
                                                                    <div class="progress-bar progress-bar-success active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 13%">
                                                                    </div>
                                                                </div>

                                                                <div class="stepwizard-row setup-panel1">
                                                                    <div class="stepwizard-step col-xs-3">
                                                                        <a href="#step1-1" type="button" class="btn btn-default stop-pointer btn-circle">1</a>
                                                                        <p><small>Business Details</small></p>
                                                                    </div>
                                                                    <div class="stepwizard-step col-xs-3">
                                                                        <a href="#step1-2" type="button" class="btn btn-default btn-circle stop-pointer" disabled="disabled">2</a>
                                                                        <p><small>Contact Information</small></p>
                                                                    </div>
                                                                    <div class="stepwizard-step col-xs-3">
                                                                        <a href="#step1-3" type="button" class="btn btn-default btn-circle stop-pointer" disabled="disabled">3</a>
                                                                        <p><small>Service Information</small></p>
                                                                    </div>
                                                                    <div class="stepwizard-step col-xs-3">
                                                                        <a href="#step1-4" type="button" class="btn btn-default btn-circle stop-pointer" disabled="disabled">4</a>
                                                                        <p><small>Additional Information</small></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="panel panel-primary setup-content1" id="step1-1">
                                                            <div class="panel-heading">
                                                                <h3 class="panel-title">Business Details</h3>
                                                            </div>
                                                            <div class="panel-body custom-panel">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-6 m-b-15">
                                                                            <label class="control-label">Select Service Type<span class="Validation_error"> *</span></label>
                                                                            <select name="supplier_type_services" id="supplier_type_services" onchange='CheckServices(this.value);' class="form-control form-input" placeholder="" required>
                                                                                <option value="" selected disabled>Select Service Type</option>
                                                                                <option value="Education/Skill Development Specialist">Education/Skill Development Specialist</option>
                                                                                <option value="CA/Lawyer/Accountant">CA/Lawyer/Accountant</option>
                                                                                <option value="Nutritionist/Dietician">Nutritionist/Dietician</option>
                                                                                <option value="Creative Field">Creative Field</option>
                                                                                <option value="Others">Others</option>
                                                                            </select>
                                                                            <p class="Validation_error" id="supplier_type_services_p"></p>
                                                                        </div>
                                                                        <div class="col-12 col-sm-6 m-b-15">
                                                                            <label class="control-label"></label>
                                                                            <select name="education_type" id="education_type" style='display:none;' class="form-control form-input" placeholder="">
                                                                                <option value="" selected disabled>Select Education/Skill Development Specialist</option>
                                                                                <option value="Tutor">Tutor</option>
                                                                                <option value="Musical Instrument Teacher">Musical Instrument Teacher</option>
                                                                                <option value="Vocal Music Teacher">Vocal Music Teacher</option>
                                                                                <option value="Sports/Games Teacher">Sports/Games Teacher</option>
                                                                                <option value="Yoga/Fitness Coach">Yoga/Fitness Coach</option>
                                                                            </select>
                                                                            <select name="creative_type" id="creative_type" style='display:none;' class="form-control form-input" placeholder="">
                                                                                <option value="" selected disabled>Select Creative Type</option>
                                                                                <option value="Content Writer">Content Writer</option>
                                                                                <option value="Photographer">Photographer</option>
                                                                                <option value="Digital Marketing Specialist">Digital Marketing Specialist</option>
                                                                                <option value="Interior Designer">Interior Designer</option>
                                                                                <option value="Others">Others</option>
                                                                            </select>
                                                                            <input type="text" name="other_service_type" id="other_service_type" style='display:none;' class="form-control form-input" maxlength="<?php echo $this->username_maxlength; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-6 m-b-15">
                                                                            <label class="control-label">Company name<span class="Validation_error"> *</span></label>
                                                                            <input type="text" name="company_name" class="form-control form-input" maxlength="<?php echo $this->username_maxlength; ?>" required>
                                                                            <p class="Validation_error" id="company_name_p1"></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label"><?php echo trans("first_name"); ?><span class="Validation_error"> *</span></label>
                                                                            <input type="text" name="first_name" class="form-control form-input" value="<?php echo html_escape($this->auth_user->first_name); ?>" placeholder="<?php echo trans("first_name"); ?>" required>
                                                                            <p class="Validation_error" id="first_name_p1"></p>
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Middle Name</label>
                                                                            <input type="text" name="middle_name" class="form-control form-input" placeholder="Middle Name">
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label"><?php echo trans("last_name"); ?><span class="Validation_error"> *</span></label>
                                                                            <input type="text" name="last_name" class="form-control form-input" value="<?php echo html_escape($this->auth_user->last_name); ?>" placeholder="<?php echo trans("last_name"); ?>" required>
                                                                            <p class="Validation_error" id="last_name_p1"></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Date of birth</label>
                                                                            <input onfocus="(this.type='date')" name="date_of_birth" min='1899-01-01' max='2000-13-13' id="dob1" class="form-control auth-form-input" placeholder="Date of Birth" value="<?php echo old("date_of_birth"); ?>" required>

                                                                        </div>
                                                                        <?php if ($this->auth_user->date_of_birth == "" || $this->auth_user->gender == "") { ?>
                                                                            <div class="col-12 col-sm-4 m-b-15">
                                                                                <label class="control-label">Gender</label>
                                                                                <input type="text" name="gender" class="form-control auth-form-input" value="<?php echo $this->auth_user->gender; ?>" placeholder="Gender">
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>


                                                                <div class="form-group">
                                                                    <label class="control-label">GST Number<span class="Validation_error"> *</span></label>
                                                                    <div class="row">

                                                                        <div class="col-12 col-sm-4 col-custom-field">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" name="gst1" id="gst_have1" class="custom-control-input" required>
                                                                                <label for="gst_have1" class="custom-control-label">Have GST Number ?</label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-12 col-sm-4 col-custom-field">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" name="gst1" id="gst_do_not_have1" class="custom-control-input" required>
                                                                                <label for="gst_do_not_have1" class="custom-control-label">Have GST Application number ?</label>

                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 col-custom-field">
                                                                            <div class="custom-control custom-radio">
                                                                                <input type="radio" name="gst1" id="gst_none1" class="custom-control-input" checked>
                                                                                <label for="gst_none1" class="custom-control-label">None</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="form-group">
                                                                    <div id="have_gst1" style="display: none">
                                                                        <label class="control-label">Enter GST Number<span class="Validation_error"> *</span></label>
                                                                        <input type="text" id="gsthave2" name="gst_number" class="form-control auth-form-input " oninput="this.value = this.value.toUpperCase()">
                                                                        <p class="Validation_error" id="gst_number_p1"></p>
                                                                    </div>
                                                                    <div id="not_have_gst1" style="display: none">
                                                                        <label class="control-label">Enter GST Application number<span class="Validation_error"> *</span></label>
                                                                        <input type="text" id="gstdonothave2" name="gst_application_number" class="form-control auth-form-input " oninput="this.value = this.value.toUpperCase()">
                                                                        <p class="Validation_error" id="gst_application_p1"></p>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <!-- <div class="col-12 col-sm-4 m-b-15">
                                                                                <label class="control-label">GST Number<span class="Validation_error"> *</span></label>
                                                                                <input type="text" name="gst_number" id="gst_number" class="form-control auth-form-input" placeholder="GST number" required minlength="15" maxlength="15" pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}">
                                                                                <p class="Validation_error" id="gst_number_p"></p>
                                                                            </div> -->
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Permanent Account Number (PAN)<span class="Validation_error"> *</span></label>
                                                                            <input type="text" name="pan_number" id="pan_number1" class="form-control auth-form-input" oninput="this.value = this.value.toUpperCase()" placeholder="Pan number" required minlength="10" maxlength="10" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}">
                                                                            <p class="Validation_error" id="pan_number1_p"></p>
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Aadhaar Number</label>
                                                                            <input type="text" minlength="12" maxlength="12" name="adhaar_number" class="form-control auth-form-input" placeholder="Aadhaar Number" onKeyPress="if(this.value.length==12) return false; return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Capture Image With PAN Card<span class="Validation_error"> *</span></label>
                                                                            <br> <small>(Please hold the PAN card near your face in such a way that both PAN card and face are clearly visible)</small>
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <div class="camera">
                                                                                <video id="video1" class="video">Video stream not available.</video>
                                                                                <button id="startbutton1" class="startbutton">Take photo</button>
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <canvas id="canvas1" class="canvas"></canvas>
                                                                            <div class="output">
                                                                                <img id="photo1" class="photo" alt="The screen capture will appear in this box.">
                                                                                <input type="text" id="pan_photo1" name="pan_photo1" style="display: none;" required>
                                                                                <p class="Validation_error" id="pan_photo_p1"></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="control-label">Area of operation<span class="Validation_error"> *</span></label>
                                                                        <select name="area_in_operation" class="form-control auth-form-input" placeholder="" required>
                                                                            <option value="" selected disabled>Select</option>
                                                                            <option value="Within Locality (Typically 0-5 kms radius)">Within Locality (Typically 0-5 kms radius)</option>
                                                                            <option value="Within City (Typically 0-30 km radius)">Within City (Typically 0-30 km radius)</option>
                                                                            <option value="Nearby areas (including adjacent inter-state areas)">Nearby areas (including adjacent inter-state areas)</option>
                                                                            <option value="Within State">Within State</option>
                                                                            <!-- <option value="Limited Liability Partnership">PAN India</option> -->
                                                                            <option value="Pan India">Pan India</option>
                                                                            <option value="International">International</option>

                                                                        </select>
                                                                        <p class="Validation_error" id="area_in_operation_p"></p>
                                                                    </div>
                                                                    <nav>
                                                                        <div class="pager row">
                                                                            <div class="col-12 nex">
                                                                                <li class="next button button1"><a class="nextBtn1" href="#">Next <span aria-hidden="true">&rarr;</span></a></li>
                                                                            </div>
                                                                        </div>
                                                                    </nav>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="panel panel-primary setup-content1" id="step1-2">
                                                            <div class="panel-heading">
                                                                <h3 class="panel-title">Contact Details</h3>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label"><?php echo trans("phone_number"); ?><span class="Validation_error"> *</span></label>
                                                                            <input type="text" minlength="10" maxlength="10" name="phone_number" class="form-control form-input" placeholder="<?php echo trans("phone_number"); ?>" value="<?php echo html_escape($this->auth_user->phone_number); ?>" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" required>
                                                                            <p class="Validation_error" id="phone_number_p1"></p>
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Alternative Mobile Number</label>
                                                                            <input type="number" name="alternative_number" class="form-control form-input" placeholder="Alternative number" onKeyPress="if(this.value.length==10) return false;">
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Landline</label>
                                                                            <input type="number" name="landline_number" class="form-control form-input" pattern="\d{5}([- ]*)\d{6}" placeholder="Landline number">

                                                                        </div>


                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="row">


                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Pincode<span class="Validation_error"> *</span></label>
                                                                            <input type="number" name="pincode1" id="pincode1" class="form-control auth-form-input" placeholder="Pincode" required maxlength="6" minlength="6" required onkeyup="get_location($( '#pincode1').val())">
                                                                            <p class="Validation_error" id="pincode_p1"></p>
                                                                            <span class="Validation_error error" id="pincode_span1"></span>
                                                                        </div>

                                                                        <div class="col-12 col-sm-4 m-b-15">

                                                                            <label class="control-label">State<span class="Validation_error"> *</span></label>
                                                                            <input type="text" name="supplier_state1" id="supplier_state1" class="form-control auth-form-input" placeholder="State" required readonly>
                                                                            <p class="Validation_error" id="state_p1"></p>
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">City<span class="Validation_error"> *</span></label>
                                                                            <input type="text" name="supplier_city1" id="supplier_city1" class="form-control auth-form-input" placeholder="City" required readonly>
                                                                            <p class="Validation_error" id="city_p1"></p>
                                                                        </div>
                                                                    </div>


                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">


                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Area<span class="Validation_error"> *</span></label>
                                                                            <input type="text" name="area" class="form-control auth-form-input" placeholder="Area" required>
                                                                            <p class="Validation_error" id="area_p1"></p>
                                                                        </div>


                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">House no./Building no./Area<span class="Validation_error"> *</span>
                                                                            </label>
                                                                            <input type="text" name="house_no" class="form-control auth-form-input" placeholder="House no./Building no./Area" required>
                                                                            <p class="Validation_error" id="house_no_p1"></p>

                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Landmark</label>
                                                                            <input type="text" name="landmark" class="form-control auth-form-input" placeholder="Landmark">
                                                                            <p class="Validation_error" id="landmark_p1"></p>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <nav>
                                                                    <div class="pager row">
                                                                        <div class="col-6 pre">
                                                                            <li class="previous button button1"><a class="prevBtn1" href="#"><span aria-hidden="true">&larr;</span> Previous</a></li>
                                                                        </div>
                                                                        <div class="col-6 nex">
                                                                            <li class="next button button1"><a class="nextBtn1" href="#">Next <span aria-hidden="true">&rarr;</span></a></li>
                                                                        </div>
                                                                    </div>
                                                                </nav>

                                                            </div>
                                                        </div>
                                                        <div class="panel panel-primary setup-content1" id="step1-3">
                                                            <div class="panel-heading">
                                                                <h3 class="panel-title">Service Details</h3>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">USP (Unique Selling Proposition)<span class="Validation_error"> *</span> <i class="fa fa-info-circle" title="A brief description of what makes your product or service exceptional and different from your competitors"></i></label>

                                                                        </div>

                                                                        <input type="text" id="usp_services" onclick="ClickTextbox1()" class="form-control auth-form-input" required value="" />
                                                                        <p class="Validation_error" id="usp_p"></p>

                                                                        <div id="usp-modal1" class="modal fade" role="dialog">
                                                                            <div class="modal-dialog  modal-dialog-centered" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                                                                                        <h3>USP of your Service</h3>
                                                                                    </div>
                                                                                    <form id="contactForm" name="contact" role="form">
                                                                                        <div class="modal-body">

                                                                                            <input type="text" name="usp1" class="form-control auth-form-input" placeholder="Enter USP of your Product">
                                                                                            <label>Or you can choose from given list</label>
                                                                                            <div>

                                                                                                <?php foreach ($usp_contents as $usp_c) : ?>
                                                                                                    <?php if ($usp_c->category == "Services") : ?>
                                                                                                        <label>
                                                                                                            <input type="radio" class="option-input checkbox" name="usp" value='<?php echo $usp_c->usp; ?>' />
                                                                                                            &nbsp;<?php echo $usp_c->usp; ?>
                                                                                                        </label><br>
                                                                                                    <?php endif; ?>
                                                                                                <?php endforeach; ?>

                                                                                                <br>
                                                                                            </div>
                                                                                            </br>

                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                            <button type="button" onclick="submit_usp1()" class="btn btn-primary">Save USP</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-6 m-b-15">
                                                                            <label class="control-label">Years in Operation<span class="Validation_error"> *</span></label>
                                                                            <select name="years_in_operation1" id="years_in_operation1" class="form-control form-input" placeholder="" required>
                                                                                <option value="" selected disabled>Select</option>
                                                                                <option value="0-6">Less than 6 months</option>
                                                                                <option value="6-24">6 months to 2 years</option>
                                                                                <option value="5-10">2-5 years</option>
                                                                                <option value="more than 5">More than 5 years</option>


                                                                            </select>
                                                                            <p class="Validation_error" id="years_in_operation_p1"></p>
                                                                        </div>
                                                                        <div class="col-12 col-sm-6 m-b-15">
                                                                            <label class="control-label">How Did You hear about us?<span class="Validation_error"> *</span></label>
                                                                            <select name="hear_about_us1" id="hear_about_us1" class="form-control form-input" placeholder="" required>
                                                                                <option value="" selected disabled>Select</option>
                                                                                <option value="Invited by gharobaar">Invited by gharobaar</option>
                                                                                <option value="Facebook">Facebook</option>
                                                                                <option value="Instagram">Instagram</option>
                                                                                <o(Optional)ption value="Google">Google</option>
                                                                                    <option value="Friends and family ">Friends and family </option>
                                                                                    <option value="Linkedin">Linkedin</option>

                                                                                    <option value="Email">Email</option>
                                                                                    <option value="Reference">Reference</option>
                                                                                    (Optional)
                                                                            </select>
                                                                            <p class="Validation_error" id="hear_about_us_p1"></p>
                                                                        </div>



                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-6 m-b-15">
                                                                            <label class="control-label">Open to Barter with other suppliers? <span class="Validation_error"> *</span><a href="#" style="text-decoration:underline;color:blue;" data-toggle="modal" data-target="#knowmore1">(Know More)</a></label>
                                                                            <br>
                                                                            <div class="modal fade" id="knowmore1" role="dialog">
                                                                                <div class="modal-dialog">

                                                                                    <!-- Modal content-->
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h4 class="modal-title">What is Barter?</h4>
                                                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <p>Some text in the modal.</p>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <input type="radio" name="barter1" value="Y" checked>
                                                                            <label for="y">Yes</label>
                                                                            <input type="radio" name="barter1" value="N">
                                                                            <label for="n"> No</label>
                                                                        </div>
                                                                        <p class="Validation_error" id="barter_p"></p>
                                                                    </div>

                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <br>
                                                                            <label class="control-label">What assistance do you want from our platform? <span class="Validation_error"> *</span></label>

                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <br>
                                                                            <select name="assistance1" id="assistance1" multiple="multiple" class="demo form-control form-input" placeholder="" required>
                                                                                <optgroup>
                                                                                    <option value="None">None</option>
                                                                                    <option value="Photography">Photography</option>
                                                                                    <option value="Videos">Videos</option>
                                                                                    <option value="Product description">Product description</option>
                                                                                    <option value="Brand description">Brand description</option>
                                                                                    <option value="Creating Supplier Page">Creating Supplier Page</option>
                                                                                    <option value="Story writing/Content Writing">Story writing/Content Writing</option>

                                                                                    <option value="Packaging Assistance">Packaging Assistance</option>
                                                                                    <option value="IPR (Intellectual Property Rights)">IPR (Intellectual Property Rights)</option>
                                                                                    <option value="Promotional Support">Promotional Support</option>

                                                                                </optgroup>

                                                                            </select>
                                                                            <!-- <select name="assistance1" id="assistance1" class="form-control form-input" placeholder="" required>
                                                                                <option value="" selected disabled>Select</option>
                                                                                <option value="Photography/Videos">Photography/Videos</option>
                                                                                <option value="Story writing/Content Writing">Story writing/Content Writing</option>
                                                                                <option value="Supplier Page designing">Supplier Page designing </option>
                                                                                <option value="Packaging Assistance">Packaging Assistance</option>
                                                                                <option value="Delivery Assistance">Delivery Assistance</option>
                                                                                <option value="Promotional Support">Promotional Support</option>


                                                                            </select> -->
                                                                            <p class="Validation_error" id="assistance_p1"></p>
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Any Other (Describe in field)</label>
                                                                            <input type="text" name="other_assistance1" class="form-control form-input">
                                                                        </div>


                                                                    </div>
                                                                </div>
                                                                <div class="form-services">

                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <div class="col-12 col-sm-6 m-b-15">


                                                                                <label class="control-label">Open to visit in person ?<span class="Validation_error"> *</span> </label>
                                                                                <br>
                                                                                <input type="radio" name="visit_inperson" value="y" checked>
                                                                                <label for="y">Yes</label>
                                                                                <input type="radio" name="visit_inperson" value="n">
                                                                                <label for="n"> No</label>
                                                                                <p class="Validation_error" id="visit_inperson_p"></p>


                                                                            </div>
                                                                            <div class="col-12 col-sm-6 m-b-15">
                                                                                <label class="control-label">Willing to travel Outside your City ?<span class="Validation_error"> *</span> </label>
                                                                                <br>
                                                                                <input type="radio" id="y" name="travel_outside" value="y" checked>
                                                                                <label for="y">Yes</label>
                                                                                <input type="radio" id="n" name="travel_outside" value="n">
                                                                                <label for="n"> No</label>
                                                                                <p class="Validation_error" id="travel_outside_p"></p>
                                                                            </div>



                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Affiliations/Certifications<span class="Validation_error"> *</span></label>
                                                                        <input type="text" name="certificate_name" id="certificate_name" class="form-control form-input" required>
                                                                        <p class="Validation_error" id="certification_p"></p>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Institute Name</label>
                                                                        <input type="text" name="institute_name" class="form-control form-input">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Details of Specialisation</label>
                                                                        <textarea name="details_spec" class="form-control form-textarea" placeholder="Describe about your specialisation..."><?= $this->auth_user->about_me; ?></textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <div class="col-12 col-sm-4 m-b-15">
                                                                                <label class="control-label">Preferable Timings<span class="Validation_error"> *</span></label>
                                                                            </div>
                                                                            <div class="col-12 col-sm-4 m-b-15">

                                                                                <select name="week" id="week" class="form-control form-input" placeholder="" required>
                                                                                    <option value="" selected disabled>Select</option>
                                                                                    <option value="Weekend">Weekend</option>
                                                                                    <option value="Weekdays">Weekdays</option>
                                                                                    <option value="Both">Both</option>

                                                                                </select>
                                                                                <p class="Validation_error" id="week_p"></p>
                                                                            </div>
                                                                            <div class="col-12 col-sm-4 m-b-15">

                                                                                <select name="day" id="day" class="form-control form-input" placeholder="" required>
                                                                                    <option value="" selected disabled>Select</option>
                                                                                    <option value="Morning">Morning</option>
                                                                                    <option value="Evening">Evening</option>
                                                                                    <option value="Afternoon">Afternoon</option>

                                                                                </select>
                                                                                <p class="Validation_error" id="day_p"></p>
                                                                            </div>


                                                                        </div>
                                                                    </div>

                                                                    <nav>
                                                                        <div class="pager row">
                                                                            <div class="col-6 pre">
                                                                                <li class="previous button button1"><a class="prevBtn1" href="#"><span aria-hidden="true">&larr;</span> Previous</a></li>
                                                                            </div>
                                                                            <div class="col-6 nex">
                                                                                <li class="next button button1"><a class="nextBtn1" href="#">Next <span aria-hidden="true">&rarr;</span></a></li>
                                                                            </div>
                                                                        </div>
                                                                    </nav>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="panel panel-primary setup-content1" id="step1-4">
                                                            <div class="panel-heading">
                                                                <h3 class="panel-title">Additional Information(Optional)</h3>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-3 m-b-15">
                                                                            <label class="control-label">Website Link</label>
                                                                            <input type="url" placeholder="https://example.com" name="website_url" class="form-control form-input" placeholder="Website Link">
                                                                        </div>
                                                                        <div class="col-12 col-sm-3 m-b-15">
                                                                            <a href="https://www.facebook.com/"><img src="<?php echo base_url(); ?>assets/img/social-icons/facebook.png" alt="" style="width: 28px; height: 28px;" /></a>

                                                                            <label class="control-label">Facebook Page Link</label>
                                                                            <input type="text" name="facebook_url" class="form-control form-input" placeholder="FaceBook Link">
                                                                        </div>
                                                                        <div class="col-12 col-sm-3 m-b-15">
                                                                            <a href="https://www.instagram.com/"> <img src="<?php echo base_url(); ?>assets/img/social-icons/instagram.png" alt="" style="width: 28px; height: 28px;" /></a>
                                                                            <label class="control-label">Instagram Page Link
                                                                            </label>
                                                                            <input type="text" name="instagram_url" class="form-control form-input" placeholder="Instagram Link">
                                                                        </div>
                                                                        <div class="col-12 col-sm-3 m-b-15">
                                                                            <label class="control-label">Any Other Page Link
                                                                            </label>
                                                                            <input type="text" name="other_url" class="form-control form-input" placeholder="Any Other Link">
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Anniversary</label>
                                                                            <input type="date" name="anniversary" class="form-control form-input" placeholder="Anniversary">

                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Where are you originally from? </label>
                                                                            <input type="text" name="originally_belongs" class="form-control form-input" placeholder="Your City">
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Anything else you would like to share with us? </label>
                                                                            <input type="text" name="share" class="form-control form-input" placeholder="">

                                                                        </div>


                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Reference checks (Atleast one)<span class="Validation_error"> *</span></label>
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <br>
                                                                            <label class="control-label">Reference 1</label>

                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Name<span class="Validation_error"> *</span></label>
                                                                            <input type="text" name="refname1" class="form-control form-input" required placeholder="Name">
                                                                        </div>
                                                                        <div class="col-12 col-sm-4 m-b-15">
                                                                            <label class="control-label">Contact<span class="Validation_error"> *</span>
                                                                            </label>
                                                                            <input type="tel" name="refcontact1" class="form-control form-input" required placeholder="Contact" maxlength="10" minlength="10">
                                                                        </div>


                                                                    </div>
                                                                    <div class="form-group">

                                                                        <div class="row">
                                                                            <div class="col-12 col-sm-4 m-b-15">
                                                                                <br>
                                                                                <label class="control-label">Reference 2</label>

                                                                            </div>
                                                                            <div class="col-12 col-sm-4 m-b-15">
                                                                                <label class="control-label">Name</label>
                                                                                <input type="text" name="refname2" class="form-control form-input" placeholder="Name">
                                                                            </div>
                                                                            <div class="col-12 col-sm-4 m-b-15">
                                                                                <label class="control-label">Contact
                                                                                </label>
                                                                                <input type="tel" name="refcontact2" class="form-control form-input" placeholder="Contact" maxlength="10" minlength="10">
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">

                                                                        <div class="row">
                                                                            <div class="col-12 col-sm-4 m-b-15">
                                                                                <br>
                                                                                <label class="control-label">Reference 3</label>

                                                                            </div>
                                                                            <div class="col-12 col-sm-4 m-b-15">
                                                                                <label class="control-label">Name</label>
                                                                                <input type="text" name="refname3" class="form-control form-input" placeholder="Name">
                                                                            </div>
                                                                            <div class="col-12 col-sm-4 m-b-15">
                                                                                <label class="control-label">Contact
                                                                                </label>
                                                                                <input type="tel" name="refcontact3" class="form-control form-input" placeholder="Contact" maxlength="10" minlength="10">
                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group m-t-15">
                                                                        <div class="custom-control custom-checkbox custom-control-validate-input">
                                                                            <input type="checkbox" class="custom-control-input" name="terms_conditions" id="terms_conditions1" value="1" readonly="readonly">
                                                                            <label for="terms_conditions1" class="custom-control-label"><?php echo trans("terms_conditions_exp"); ?>&nbsp;
                                                                                <?php $page_terms = get_page_by_default_name("terms_conditions", $this->selected_lang->id);
                                                                                if (!empty($page_terms)) : ?>
                                                                                    <strong data-toggle="modal" data-target="#termsCondition1"><u style="color: blue;">(<?= html_escape($page_terms->title); ?>)</u></strong>
                                                                                <?php endif; ?>
                                                                            </label>

                                                                        </div>
                                                                        <small id="small-text1" style="display:none;color:red;">(before accepting please read the terms & conditions)</small>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <button type="submit" class="btn btn-lg btn-custom float-right"><?php echo trans("submit"); ?></button>
                                                                    </div>
                                                                    <nav>
                                                                        <div class="pager row">
                                                                            <div class="col-6 pre">
                                                                                <li class="previous button button1"><a class="prevBtn1" href="#"><span aria-hidden="true">&larr;</span> Previous</a></li>
                                                                            </div>

                                                                        </div>
                                                                    </nav>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>
                                <?php endif;
                                endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Wrapper End-->

    <!-- modal for selction of exempted goods -->
    <div id="start-exempted-modal" class="modal fade" role="dialog">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header background-gradient text-center">
                    <button type="button" class="close" data-dismiss="modal" onclick="close_selling()"><i class="icon-close"></i></button>
                    <h3>Exempted Goods</h3>

                </div>
                <form id="startexemptedForm" name="startexempted" role="form">
                    <div class="modal-body background-gradient" style="overflow-y:scroll;max-height:400px;">
                        <div>

                            <?php foreach ($exempted_goods as $exempted_good) : ?>
                                <label data-toggle="tooltip" title="<?php echo $exempted_good->hover; ?>" data-placement="left">
                                    <input type="checkbox" required class="option-input checkbox" name="selling_exempted_goods[]" value='<?php echo $exempted_good->title; ?>' />
                                    &nbsp;<?php echo $exempted_good->title; ?>&nbsp;<?php if ($exempted_good->hover != null) : ?><i class="fa fa-info-circle"></i><?php endif; ?>
                                </label><br>
                            <?php endforeach; ?>
                        </div>
                        </br>
                    </div>
                    <div class="modal-footer background-gradient">
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="close_selling()">Close</button>
                        <button type="button" onclick="submit_selling()" id="button_exempted" class="btn btn-primary1 inactive" disabled>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="assistance-modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header background-gradient">
                    <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                    <!-- <div class="row"> -->
                    <h3>Assistance</h3>
                    <!-- </div> -->

                </div>
                <form id="assistanceForm" name="assistance_modal" role="form">
                    <div class="modal-body background-gradient" style="overflow-y:scroll;max-height:400px;">

                        <div>

                            <label>
                                <input type="checkbox" class="option-input checkbox" name="assistance_inputs" style="height: 1.5rem;" value='None' />
                                &nbsp;None
                            </label><br>
                            <label>
                                <input type="checkbox" class="option-input checkbox" name="assistance_inputs" style="height: 1.5rem;" value='Photography/Videos' />
                                &nbsp;Photography/Videos
                            </label><br>
                            <label>
                                <input type="checkbox" class="option-input checkbox" name="assistance_inputs" style="height: 1.5rem;" value='Story writing/Content Writing' />
                                &nbsp;Story writing/Content Writing
                            </label><br>
                            <label>
                                <input type="checkbox" class="option-input checkbox" name="assistance_inputs" style="height: 1.5rem;" value='Packaging Assistance' />
                                &nbsp;Packaging Assistance
                            </label><br>
                            <label>
                                <input type="checkbox" class="option-input checkbox" name="assistance_inputs" style="height: 1.5rem;" value='Delivery Assistance' />
                                &nbsp;Delivery Assistance
                            </label><br>
                            <label>
                                <input type="checkbox" class="option-input checkbox" name="assistance_inputs" style="height: 1.5rem;" value='Promotional Support' />
                                &nbsp;Promotional Support
                            </label><br>

                        </div>
                        </br>

                    </div>
                    <div class="modal-footer background-gradient">
                        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                        <button type="button" onclick="submit_assistance()" class="btn btn-primary1">Save Assistance</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- modal for none selection of gst-->
    <div id="none-modal" class="modal fade" role="dialog">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header background-gradient text-center">
                    <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                    <h3>Must Have GST</h3>
                </div>
                <div class="modal-body background-gradient text-center">
                    <div>
                        It is mandantory to have a GST number to sell on an e-commerce platform. For any queries please reach us at <a href="sellerhelp@gharobaar.com">sellerhelp@gharobaar.com</a>
                    </div>
                    </br>
                    <!-- <div class="modal-footer background-gradient"> -->
                    <center> <button type="button" class="btn btn-primary1" data-dismiss="modal">Close</button>
                    </center>
                </div>
                <!-- </div> -->
            </div>
        </div>
    </div>

    <!-- usp values modal -->
    <!-- <div id="usp-modal" class="modal fade" role="dialog">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                    <h3>USP Of your Product</h3>
                    <small>You can type and/or select one of the options from below aligned to your product.</small>
                </div>
                <form id="contactForm" name="contact" role="form">
                    <div class="modal-body">
                        <input type="text" name="usp_text" id="usp_text" class="form-control auth-form-input" placeholder="Enter USP of your Product">
                        <label>Or you can choose from given list</label>
                        <div>

                            <?php foreach ($usp_contents as $usp_c) : ?>
                                <?php if ($usp_c->category == "Goods") : ?>
                                    <label>
                                        <input type="radio" class="option-input checkbox" name="usp" id="issue1" value='<?php echo $usp_c->usp; ?>' />
                                        &nbsp;<?php echo $usp_c->usp; ?>
                                    </label><br>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        </div>
                        </br>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" onclick="submit_usp()" class="btn btn-primary">Save USP</button>
                    </div>
                </form>
            </div>
        </div>
    </div> -->


    <div id="usp-modal" class="modal fade" role="dialog">
        <div class="modal-dialog  modal-dialog-centered" data-backdrop="static" role="document">
            <div class="modal-content">
                <div class="modal-header background-gradient">
                    <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                    <!-- <div class="row"> -->
                    <h3>USP of your Product</h3>
                    <!-- </div> -->
                    <small>You can type and/or select one of the options from below aligned to your product.</small>
                </div>
                <form id="contactForm" name="contact" role="form">
                    <div class="modal-body background-gradient" style="overflow-y:scroll;max-height:400px;">
                        <input type="text" name="usp_text" id="usp_text" class="form-control auth-form-input" placeholder="Enter USP of your Product">
                        <!-- <label>Or you can choose from given list</label> -->
                        <div>

                            <?php foreach ($usp_contents as $usp_c) : ?>
                                <?php if ($usp_c->category == "Goods") : ?>
                                    <label>
                                        <input type="radio" class="option-input checkbox" name="usp" style="height: 1.5rem;" value='<?php echo $usp_c->usp; ?>' />
                                        &nbsp;<?php echo $usp_c->usp; ?>
                                    </label><br>

                                <?php endif; ?>
                            <?php endforeach; ?>

                        </div>
                        </br>

                    </div>
                    <div class="modal-footer background-gradient">
                        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                        <button type="button" onclick="submit_usp()" class="btn btn-primary1">Save USP</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- barter popup modal -->
    <div class="modal fade" id="knowmore" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-medium" role="document">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="auth_box" id="know_more_box">
                    <div class="row">
                        <div class="col-md-5" style=" width: 100%;  margin: auto auto;  text-align: center;">
                            <img id="ABOUT_LOGO" src="assets/img/barter system new 1.png" class="img-responsive image1">
                        </div>
                    </div>
                    <div>
                        <h4 class="modal-title" id="barting">Jadh se Judho – Barter Karo</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- <div class="modal-body"> -->
                    <div class="cont" style="text-align: center;">

                        <p style="text-align: center;">
                            Let's get back to our roots, and trade the way it was done earlier. We don’t need cash, we just need someone who makes/provides something we want !. </p>
                    </div>
                    <div class="cont">
                        <p style="text-align: center;">
                            Choose ‘Yes’ if you would be keen to explore this option, and choose ‘No’ if you’re not so willing to try this out right now. You always have the option to change your decision later.</p>
                    </div>
                    <div class="cont">
                        <p style="text-align: center;">We are trying to do something unique and different, something that is not the usual practice in e-commerce. We are giving you an option to exchange products with each other, without exchanging any money.
                        </p>
                        <div class="row">
                            <div class="col-md-5">
                                <img id="logax" src="assets/img/Saly-23.png" class="img-responsive image1">
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                    <!-- <div class="modal-footer"> -->
                    <!-- <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button> -->
                    <!-- </div> -->
                </div>
            </div>

        </div>
    </div>

    <!-- trademark popup modal -->
    <div class="modal fade" data-backdrop="static" id="trademark_modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-medium" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body background-gradient" style="overflow-y:scroll;max-height:650px;">
                    <div>
                        <button type="button" class="close" data-dismiss="modal" id="reject_addendum">&times;</button>
                        <h4 class="modal-title text-center">ADDENDUM TO SELLER/SERVICE PROVIDER AGREEMENT</h4>
                        <br>
                    </div>
                    <!-- <div class="modal-body"> -->
                    <ol type="1">
                        <li>
                            It is each seller’s/ Service Provider’s responsibility to source and sell only authentic products. If you sell counterfeit goods or offer Services which violate Intellectual Property of Others, we can immediately suspend or terminate your selling privileges or return, dispose off or destroy inventory in our fulfilment centres in accordance with the terms of the Gharobaar Seller/ Service Provider Agreement, whichever applicable. In addition, if we determine that a seller/ Service Provider account has been used to engage in fraud or other illegal activity, including selling of counterfeit products which might result in a significant number of customer disputes or other claims, remittances and payments can be withheld or forfeited. The sale of counterfeit goods can lead to legal action by rights holders and also result in civil and criminal penalties.
                        </li>
                        <li>
                            Gharobaar does not endorse any Submitted Content or any opinion, recommendation, or advice expressed therein, and Gharobaar expressly disclaims any and all liability in connection with all Submitted Content. Gharobaar does not permit copyright infringing activities and infringement of Intellectual property rights on the Website, and Gharobaar will remove any Data or Submitted Content if properly notified, pursuant to the "take down" notification procedure, that such Listing or Submitted Content infringes on another's intellectual property rights. Gharobaar reserves the right to remove any Data or Submitted Content without prior notice. Gharobaar will also terminate a user's access to the Website, if he or she is determined to be a repeat infringer. A repeat infringer is a Website user who has been notified of infringing activity more than twice and/ or has had Submitted Content removed from the Website more than twice. Gharobaar also reserves the right, in its sole and absolute discretion, to decide whether any Data or Submitted Content is appropriate and complies with these Terms of Use for all violations, in addition to copyright infringement and violations of intellectual property law, including, but not limited to, pornography, obscene or defamatory material, or excessive length. Gharobaar may remove such Submitted Content and/or terminate a user's access for uploading such material in violation of these Terms of Use at any time, without prior notice and in its sole discretion.
                        </li>

                        <li>
                            Seller(s)/ Service Provider(s) are solely responsible for the photos, profiles and other content, including, without limitation, Submitted Content that they publish or display on or through the Website, or transmit to other Website users. Seller(s)/ Service Provider(s) understand and agree that Gharobaar may, in its sole discretion and without incurring any liability, review and delete or remove any Submitted Content that violates the Gharobaar Seller/ Service Provider Agreement, or which might be offensive, illegal, or that might violate the rights, harm, or threaten the safety of Website users or others.
                        </li>
                        <li>
                            Seller(s)/ Service Provider(s) are advised to avoid using any generic trademarks, names [including surnames, maiden names/ parental names etc.] which may attract infringement and violates the rights of the Third-Party rights in the Trade Mark that Gharobaar does not own.
                        </li>
                        <li>
                            Seller(s)/ Service Provider(s) may be exposed to Submitted Content that is inaccurate, offensive, indecent, or objectionable, to the third parties and Seller(s)/ Service Provider(s) agree to waive, and hereby do waive, any legal or equitable rights or remedies you have or may have against Gharobaar with respect thereto, and agree to indemnify and hold Gharobaar, its owners, members, managers, operators, directors, officers, agents, affiliates, and/or licensors, harmless to the fullest extent allowed by law regarding all matters related to your use of the Website.
                        </li>
                    </ol>
                    <!-- </div> -->
                    <div class="text-center">
                        <button type="button" class="btn btn-default text-center" id="accept_addendum" data-dismiss="modal">Agree</button>
                    </div>
                </div>

            </div>

        </div>
    </div>



    <script>
        $('#terms_conditions').click(function() {
            var isReadOnly = $(this).attr("readonly") === undefined ? false : true;

            if (isReadOnly) {
                $(this).prop('checked', false);
                $("#small-text").show();
            }

            // other code never executed if readonly is true.
        });
    </script>

    <script>
        $('#terms_conditions1').click(function() {
            var isReadOnly = $(this).attr("readonly") === undefined ? false : true;

            if (isReadOnly) {
                $(this).prop('checked', false);
                $("#small-text1").show();
            }

            // other code never executed if readonly is true.
        });
    </script>
    <script type="text/javascript">
        function t_c1() {
            $('#small-text').hide();
            $('#terms_conditions').removeAttr('readonly');
            $('#terms_conditions')[0].checked = true;
        }

        function t_c2() {
            $('#small-text1').hide();
            $('#terms_conditions1').removeAttr('readonly');
            $('#terms_conditions1')[0].checked = true;
        }
        $(document).ready(function() {

            $.validator.addMethod(
                "regex",
                function(value, element, regexp) {
                    var re = new RegExp(regexp);
                    return this.optional(element) || re.test(value);
                },
                "Please enter valid PAN No."
            );
            $.validator.addMethod(
                "regexGST",
                function(value, element, regexp) {
                    var re = new RegExp(regexp);
                    return this.optional(element) || re.test(value);
                },
                "Please enter valid GST No."
            );

            $('.form-switch').on('change', function() {
                $('.form').removeClass('active');
                var formToShow = '.form-' + $(this).data('id');
                $(formToShow).addClass('active');
                $('.stepwizard .progress-bar').animate({
                    width: '0%'
                }, 0);
            });

            var regex = $("#pan_number")[0].attributes.pattern.value;
            $("#pan_number").rules("add", {
                regex: "^" + regex + "$"
            });

            // var regexGST = $("#gsthave1")[0].attributes.pattern.value;
            // $("#gsthave1").rules("add", {
            //     regexGST: "^" + regexGST + "$"
            // });
            // var regexGST = $("#gsthave2")[0].attributes.pattern.value;
            // $("#gsthave2").rules("add", {
            //     regexGST: "^" + regexGST + "$"
            // });
            // var regexGST = $("#gstdonothave1")[0].attributes.pattern.value;
            // $("#gsthave1").rules("add", {
            //     regexGST: "^" + regexGST + "$"
            // });
            // var regexGST = $("#gstdonothave2")[0].attributes.pattern.value;
            // $("#gsthave1").rules("add", {
            //     regexGST: "^" + regexGST + "$"
            // });
            var regex = $("#pan_number1")[0].attributes.pattern.value;
            $("#pan_number1").rules("add", {
                regex: "^" + regex + "$"
            });

            // var regexGST = $("#gst_number1")[0].attributes.pattern.value;
            // $("#gst_number1").rules("add", {
            //     regexGST: "^" + regexGST + "$"
            // });
        });

        $(document).ready(function() {
            $('.form-switch').on('change', function() {
                $('.form').removeClass('active');
                var formToShow = '.form-' + $(this).data('id');
                $(formToShow).addClass('active');
                $('.stepwizard .progress-bar').animate({
                    width: '0%'
                }, 0);

            });
        });
    </script>

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

                // navigator.mediaDevices.getUserMedia({
                //         video: true,
                //         audio: false
                //     })
                //     .then(function(stream) {
                //         video.srcObject = stream;
                //         video.play();
                //     })
                //     .catch(function(err) {
                //         console.log("An error occurred: " + err);
                //     });

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
                photo.setAttribute('src', data);
                pan.setAttribute('value', "");
            }

            function takepicture() {


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

                var context = canvas.getContext('2d');
                if (width && height) {
                    canvas.width = width;
                    canvas.height = height;
                    context.drawImage(video, 0, 0, width, height);

                    var data = canvas.toDataURL('image/png');
                    photo.setAttribute('src', data);
                    pan.setAttribute('value', data);
                    if ($("#pan_photo-error").length) {
                        $("#pan_photo-error")[0].innerText = "";
                    }

                } else {
                    clearphoto();
                }
            }

            // window.addEventListener('load', startup, false);
        })();
    </script>
    <script>
        // JS comes here /
        (function() {

            var width = 320; // We will scale the photo width to this
            var height = 0; // This will be computed based on the input stream

            var streaming = false;

            var video = null;
            var canvas = null;
            var photo = null;
            var startbutton = null;

            function startup1() {
                video = document.getElementById('video1');
                canvas = document.getElementById('canvas1');
                photo = document.getElementById('photo1');
                pan1 = document.getElementById('pan_photo1');
                startbutton = document.getElementById('startbutton1');

                // navigator.mediaDevices.getUserMedia({
                //         video: true,
                //         audio: false
                //     })
                //     .then(function(stream) {
                //         video.srcObject = stream;
                //         video.play();
                //     })
                //     .catch(function(err) {
                //         console.log("An error occurred: " + err);
                //     });

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
                    takepicture1();
                    ev.preventDefault();
                }, false);

                clearphoto1();
            }

            function clearphoto1() {
                var context = canvas.getContext('2d');
                context.fillStyle = "#AAA";
                context.fillRect(0, 0, canvas.width, canvas.height);

                var data = canvas1.toDataURL('image/png');
                photo.setAttribute('src', data);
                pan1.setAttribute('value', "");
            }

            function takepicture1() {

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

                var context = canvas1.getContext('2d');
                if (width && height) {
                    canvas.width = width;
                    canvas.height = height;
                    context.drawImage(video, 0, 0, width, height);

                    var data = canvas.toDataURL('image/png');
                    photo.setAttribute('src', data);
                    pan1.setAttribute('value', data);
                    if ($("#pan_photo1-error").length) {
                        $("#pan_photo1-error")[0].innerText = "";
                    }
                } else {
                    clearphoto1();
                }
            }

            window.addEventListener('load', startup1, false);
        })();
    </script>



    <script>
        $(document).ready(function() {
            var myShopUniqueName = {};
            var navListItems = $('div.setup-panel div a'),
                allWells = $('.setup-content'),
                allNextBtn = $('.nextBtn'),
                allPrevBtn = $('.prevBtn');

            allWells.hide();

            navListItems.click(function(e) {
                e.preventDefault();
                var $target = $($(this).attr('href')),
                    $item = $(this);
                var nextStepWizard = $(this).text();

                if (nextStepWizard == 1)
                    $('.stepwizard .progress-bar').animate({
                        width: '0%'
                    }, 0);
                if (nextStepWizard == 2)
                    $('.stepwizard .progress-bar').animate({
                        width: '33%'
                    }, 0);
                if (nextStepWizard == 3)
                    $('.stepwizard .progress-bar').animate({
                        width: '66%'
                    }, 0);
                if (nextStepWizard == 4)
                    $('.stepwizard .progress-bar').animate({
                        width: '100%'
                    }, 0);


                if (!$item.hasClass('disabled')) {
                    navListItems.removeClass('btn-success').addClass('btn-default');
                    //navListItems.addClass('btn-default');
                    $item.addClass('btn-success');
                    allWells.hide();
                    $target.show();
                    // $target.find('input:eq(0)').focus();
                }
            });

            allNextBtn.click(function() {
                var curStep = $(this).closest(".setup-content"),
                    curStepBtn = curStep.attr("id"),
                    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                    curInputs = curStep.find("input[type='text'],input[type='url'],input[type='number'],select,input[type='radio'],input[type='hidden']"),
                    isValid = true,
                    firstInvalid = true;


                $(".form-group").removeClass("has-error");
                for (var i = 0; i < curInputs.length; i++) {
                    // console.log(curInputs);
                    if (!curInputs[i].validity.valid) {
                        if (firstInvalid) {
                            firstInvalid = false;
                            var firstInvalidKey = i;
                        }
                        // console.log(curInputs[i].validity);
                        isValid = false;
                        $(curInputs[i]).closest(".form-group").addClass("has-error");
                        $(curInputs[i])[0].className = 'form-control auth-form-input error';
                        var field_name = $(curInputs[i])[0].name;
                        $(curInputs[i])[0].nextElementSibling.outerHTML = '<label id="' + field_name + '-error" class="error" for="' + field_name + '" style="display: inline-block;">This field is required.</label>';
                    }
                    // if ($(curInputs[i])[0].name == "shop_name" && $(curInputs[i]).val() != "") {
                    //     if (myShopUniqueName.name == undefined || myShopUniqueName.name != $(curInputs[i])[0].value) {
                    //         console.log($(curInputs[i])[0].value);
                    //         var check = check_shop_exist($(curInputs[i])[0].value, <?php echo $this->auth_user->id; ?>);
                    //         if (!check.result) {
                    //             isValid = false;
                    //             firstInvalid = false;
                    //             var firstInvalidKey = i;
                    //             $(curInputs[i]).closest(".form-group").addClass("has-error");
                    //             $(curInputs[i])[0].className = 'form-control auth-form-input error';
                    //             var field_name = $(curInputs[i])[0].name;
                    //             $(curInputs[i])[0].nextElementSibling.outerHTML = '<label id="' + field_name + '-error" class="error" for="' + field_name + '" style="display: inline-block;">' + check.msg + '</label>';
                    //             delete myShopUniqueName.name;
                    //         } else {
                    //             myShopUniqueName.name = $(curInputs[i])[0].value;
                    //         }
                    //     }
                    // }
                }

                if (isValid) {
                    nextStepWizard.removeAttr('disabled').trigger('click');
                    $('.next_hide').css('display', 'none');
                    $('#start_selling_png_image').css('display', 'none');
                }

                if (!firstInvalid) {
                    $(curInputs[firstInvalidKey]).focus();
                    $('html, body').animate({
                        scrollTop: ($(curInputs[firstInvalidKey]).offset().top - 100)
                    }, 1);
                }
            });


            allPrevBtn.click(function() {
                var curStep = $(this).closest(".setup-content"),
                    curStepBtn = curStep.attr("id"),
                    prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

                prevStepWizard.removeAttr('disabled').trigger('click');

            });


            $('div.setup-panel div a.btn-success').trigger('click');
        });
    </script>
    <script>
        $(document).ready(function() {

            var navListItems1 = $('div.setup-panel1 div a'),
                allWells1 = $('.setup-content1'),
                allNextBtn1 = $('.nextBtn1'),
                allPrevBtn1 = $('.prevBtn1');

            allWells1.hide();

            navListItems1.click(function(e) {
                e.preventDefault();
                var $target = $($(this).attr('href')),
                    $item = $(this);
                var nextStepWizard = $(this).text();

                if (nextStepWizard == 1)
                    $('.stepwizard .progress-bar').animate({
                        width: '0%'
                    }, 0);
                if (nextStepWizard == 2)
                    $('.stepwizard .progress-bar').animate({
                        width: '33%'
                    }, 0);
                if (nextStepWizard == 3)
                    $('.stepwizard .progress-bar').animate({
                        width: '66%'
                    }, 0);
                if (nextStepWizard == 4)
                    $('.stepwizard .progress-bar').animate({
                        width: '100%'
                    }, 0);


                if (!$item.hasClass('disabled')) {
                    navListItems1.removeClass('btn-success').addClass('btn-default');
                    //navListItems.addClass('btn-default');
                    $item.addClass('btn-success');
                    allWells1.hide();
                    $target.show();
                    // $target.find('input:eq(0)').focus();
                }
            });

            allNextBtn1.click(function() {
                var curStep = $(this).closest(".setup-content1"),
                    curStepBtn = curStep.attr("id"),
                    nextStepWizard = $('div.setup-panel1 div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                    curInputs = curStep.find("input[type='text'],input[type='radio'],input[type='url'],input[type='number'],select"),
                    isValid = true;

                $(".form-group").removeClass("has-error");
                for (var i = 0; i < curInputs.length; i++) {

                    if (!curInputs[i].validity.valid) {
                        isValid = false;
                        $(curInputs[i]).closest(".form-group").addClass("has-error");
                        $(curInputs[i])[0].className = 'form-control auth-form-input error';
                        var field_name = $(curInputs[i])[0].name;
                        $(curInputs[i])[0].nextElementSibling.outerHTML = '<label id="' + field_name + '-error" class="error" for="' + field_name + '" style="display: inline-block;">This field is required.</label>';
                    }
                }

                if (isValid) {
                    nextStepWizard.removeAttr('disabled').trigger('click');
                    $('.next_hide').css('display', 'none');
                }
            });


            allPrevBtn1.click(function() {
                var curStep = $(this).closest(".setup-content1"),
                    curStepBtn = curStep.attr("id"),
                    prevStepWizard = $('div.setup-panel1 div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

                prevStepWizard.removeAttr('disabled').trigger('click');
            });


            $('div.setup-panel1 div a.btn-success').trigger('click');
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.dropdown-submenu a.test').on("click", function(e) {
                $(this).next('ul').toggle();
                e.stopPropagation();
                e.preventDefault();
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $("#source").change(function() {
                var el = $(this);
                if (el.val() === "ONLINE") {
                    $("#status").append("<option>SHIPPED</option>");
                } else if (el.val() === "MANUAL") {
                    $("#status option:last-child").remove();
                }
            });

        });
    </script>
    <script>
        function get_location(pincode) {
            var url = "https://api.postalpincode.in/pincode/" + pincode;
            $.ajax({
                url: url,
                cache: false,
                success: function(html) {


                    if (html[0].PostOffice == null) {
                        $('#pincode_span')[0].innerHTML = "Please enter a valid pincode.";
                        $('#pincode_span1')[0].innerHTML = "Please enter a valid pincode.";
                    } else {
                        $('#pincode_span')[0].innerHTML = "";
                        $('#pincode_span1')[0].innerHTML = "";
                        $('input[name="supplier_state"]').val(html[0].PostOffice[0].State)
                        $('input[name="supplier_city"]').val(html[0].PostOffice[0].District)
                        $('input[name="area"]').val(html[0].PostOffice[0].Name)
                        $('input[name="supplier_state1"]').val(html[0].PostOffice[0].State)
                        $('input[name="supplier_city1"]').val(html[0].PostOffice[0].District)
                        //$('#supplier_area1').val(html[0].PostOffice[0].Name)
                    }
                }
            })
        }
    </script>
    <script>
        $(function() {
            var base_url = '<?php echo base_url(); ?>';
            var post_url = base_url + "home_controller/getindiacities";
            $('#ajax_cities').tagger({
                ajaxURL: post_url,
                baseURL: 'assets/img/',
                characterThreshold: 1,
                fieldWidth: null
            });

        });
    </script>

    <script>
        $(function() {
            var base_url = '<?php echo base_url(); ?>';
            var post_url = base_url + "home_controller/getindiacities";
            $('#ajax_cities1').tagger({
                ajaxURL: post_url,
                baseURL: 'assets/img/',
                characterThreshold: 1,
                fieldWidth: null
            });

        });
    </script>
    <script type="text/javascript">
        function CheckCompany(val) {
            var element = $("#other");
            if (val == 'Other')
                element.show();
            else
                element.hide();
        }
    </script>
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
    <script type="text/javascript">
        function CheckService(val) {
            var element = document.getElementById('other_service');
            if (val == 'Others') {
                element.style.display = 'block';
                // element.required = true;
            } else {
                element.style.display = 'none';
                // element.required = false;
            }

        }
    </script>
    <script>
        function ClickTextbox1() {
            $('#usp-modal1').modal('show');
        }
    </script>
    <script>
        function submit_selling() {
            var final_sup;
            var exempted = [];
            $.each($("input[name='selling_exempted_goods[]']:checked"), function() {
                exempted.push($(this).val());
            });
            //final_sup = favorite.toString();
            console.log(exempted);
            document.getElementById("selling_ex").value = exempted;
            console.log(document.getElementById("selling_ex").value);
            $('#start-exempted-modal').modal('hide');
        }

        function close_selling() {
            $.each($("input[name='selling_exempted_goods[]']:checked"), function() {
                $(this)[0].checked = false;
            });
        }

        $('input[name="selling_exempted_goods[]"]').click(function() {
            var final_sup;
            var exempted = [];
            $.each($("input[name='selling_exempted_goods[]']:checked"), function() {
                exempted.push($(this).val());
            });
            if (exempted.length > 0) {
                $("#button_exempted")[0].disabled = false;
            } else {
                $("#button_exempted")[0].disabled = true;
            }
        });
    </script>

    <script>
        function submit_usp1() {
            var final_sup;
            var favorite1 = [];
            $.each($("input[name='usp1']:checked"), function() {
                favorite1.push($(this).val());
            });
            //final_sup = favorite.toString();
            console.log(favorite1);
            document.getElementById("usp_services").value = favorite1;
            console.log(document.getElementById("usp_services").value);
            $('#usp-modal1').modal('hide');
            //alert(favorite);
        }
    </script>
    <script>
        function ClickTextbox() {
            $('#usp-modal').modal('show');
        }
    </script>
    <script>
        function submit_usp() {
            var final_sup;
            var usp_text = document.getElementById('usp_text').value;
            var favorite = [];
            $.each($("input[name='usp']:checked"), function() {
                favorite.push($(this).val());
            });
            //final_sup = favorite.toString();
            console.log(favorite);
            if (usp_text != "") {
                document.getElementById("usp_goods").value = usp_text + ", " + favorite;
            } else {
                document.getElementById("usp_goods").value = favorite;
            }
            console.log(document.getElementById("usp_goods").value);
            $('#usp-modal').modal('hide');
            //alert(favorite);
        }
    </script>
    <script>
        $('.demo').fSelect();
    </script>
    <script>
        $(document).ready(function() {
            $("input[name='gst']").click(function() {
                if ($("#gst_have").is(":checked")) {
                    $("#have_gst").show();
                    $("#have_gst3").show();
                    document.getElementById("gsthave1").required = true;
                    document.getElementById("gsthave1").pattern = '[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z,4]{1}[0-9A-Z]{1}';
                    document.getElementById("gsthave1").maxLength = 15;
                    document.getElementById("gsthave1").minLength = 15;
                    var regexGST = $("#gsthave1")[0].attributes.pattern.value;
                    $("#gsthave1").rules("add", {
                        regexGST: "^" + regexGST + "$"
                    });
                    document.getElementById("gstdonothave1").required = false;
                    document.getElementById("turnover").required = false;
                    $("#turnover-req")[0].innerHTML = "";
                    if ($('#turnover option').length < 5) {
                        var o = new Option("Above 20 lakh", "Above 20 lakh");
                        /// jquerify the DOM object 'o' so we can use the html method
                        $(o).html("Above 20 lakh");
                        $("#turnover").append(o);
                    }




                    $("#not_have_gst").hide();

                } else if ($("#gst_do_not_have").is(":checked")) {
                    $("#not_have_gst").show();
                    document.getElementById("gstdonothave1").required = true;
                    // document.getElementById("gstdonothave1").pattern = '[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}';
                    // document.getElementById("gstdonothave1").maxLength = 15;
                    // document.getElementById("gstdonothave1").minLength = 15;
                    // var regexGST = $("#gstdonothave1")[0].attributes.pattern.value;
                    // $("#gstdonothave1").rules("add", {
                    //     regexGST: "^" + regexGST + "$"
                    // });
                    document.getElementById("gsthave1").required = false;
                    document.getElementById("turnover").required = false;
                    $("#turnover-req")[0].innerHTML = "";
                    if ($('#turnover option').length < 5) {
                        var o = new Option("Above 20 lakh", "Above 20 lakh");
                        /// jquerify the DOM object 'o' so we can use the html method
                        $(o).html("Above 20 lakh");
                        $("#turnover").append(o);
                    }
                    $("#have_gst").hide();
                } else {
                    $("#not_have_gst").hide();
                    $("#have_gst").hide();
                    document.getElementById("gstdonothave1").required = false;
                    document.getElementById("gsthave1").required = false;
                    document.getElementById("turnover").required = true;
                    $("#turnover option[value='Above 20 lakh']").remove();


                    $("#turnover-req")[0].innerHTML = " *";
                }
            });


        });

        function byPassGstSelection() {
            if ($("#gst_have").is(":checked")) {
                $("#have_gst").show();
                document.getElementById("gsthave1").required = true;
                document.getElementById("gsthave1").pattern = '[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z,4]{1}[0-9A-Z]{1}';
                document.getElementById("gsthave1").maxLength = 15;
                document.getElementById("gsthave1").minLength = 15;
                var regexGST = $("#gsthave1")[0].attributes.pattern.value;
                $("#gsthave1").rules("add", {
                    regexGST: "^" + regexGST + "$"
                });
                document.getElementById("gstdonothave1").required = false;
                document.getElementById("turnover").required = false;
                $("#turnover-req")[0].innerHTML = "";
                if ($('#turnover option').length < 5) {
                    var o = new Option("Above 20 lakh", "Above 20 lakh");
                    /// jquerify the DOM object 'o' so we can use the html method
                    $(o).html("Above 20 lakh");
                    $("#turnover").append(o);
                }
                $("#not_have_gst").hide();
            } else if ($("#gst_do_not_have").is(":checked")) {
                $("#not_have_gst").show();
                document.getElementById("gstdonothave1").required = true;
                // document.getElementById("gstdonothave1").pattern = '[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}';
                // document.getElementById("gstdonothave1").maxLength = 15;
                // document.getElementById("gstdonothave1").minLength = 15;
                // var regexGST = $("#gstdonothave1")[0].attributes.pattern.value;
                // $("#gstdonothave1").rules("add", {
                //     regexGST: "^" + regexGST + "$"
                // });
                document.getElementById("gsthave1").required = false;
                document.getElementById("turnover").required = false;
                $("#turnover-req")[0].innerHTML = "";
                if ($('#turnover option').length < 5) {
                    var o = new Option("Above 20 lakh", "Above 20 lakh");
                    /// jquerify the DOM object 'o' so we can use the html method
                    $(o).html("Above 20 lakh");
                    $("#turnover").append(o);
                }
                $("#have_gst").hide();
            } else {
                $("#not_have_gst").hide();
                $("#have_gst").hide();
                document.getElementById("gstdonothave1").required = false;
                document.getElementById("gsthave1").required = false;
                document.getElementById("turnover").required = true;
                $("#turnover option[value='Above 20 lakh']").remove();


                $("#turnover-req")[0].innerHTML = " *";
            }
        }

        function onlyNumberKey(evt) {

            // Only ASCII charactar in that range allowed 
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }

        function nothingReturn(evt) {
            // Only ASCII charactar in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (1)
                return false;
            return true;
        }
    </script>
    <script>
        $('input[name="type_of_goods"]').click(function() {
            if ($(this).is(':checked') && $(this).val() == 'exempted_goods') {
                document.getElementById("turnover").required = true;
                $("#turnover-req")[0].innerHTML = "";
                $('#start-exempted-modal').modal('show');
                if ($('#turnover option').length <= 4) {
                    $("#turnover").append(new Option("Above 20 lakh", "Above 20 lakh"));
                }
            }
            if ($(this).is(':checked') && $(this).val() == 'none') {
                document.getElementById("turnover").required = true;
                $("#turnover-req")[0].innerHTML = "";
                $(this)[0].checked = false;
                $('#none-modal').modal('show');
                if ($('#turnover option').length <= 4) {
                    $("#turnover").append(new Option("Above 20 lakh", "Above 20 lakh"));
                }
            }
            if ($(this).is(':checked') && $(this).val() == 'Food delivery services (Annual turnover less than 20 lakh)') {
                $("#turnover option[value='Above 20 lakh']").remove();
                document.getElementById("turnover").required = true;
                $("#turnover-req")[0].innerHTML = " *";
            }
        });

        $('#start-exempted-modal').on('hidden.bs.modal', function() {
            var exempted = [];
            $.each($("input[name='selling_exempted_goods[]']:checked"), function() {
                exempted.push($(this).val());
                document.getElementById("turnover").required = true;
                $("#turnover-req")[0].innerHTML = " *";

            });
            console.log(exempted.length);
            if (exempted.length < 1) {
                $('input[name="type_of_goods"]').each(function() {
                    if ($(this).val() == "Food delivery services (Annual turnover less than 20 lakh)") {
                        $(this)[0].checked = true;
                        $(this).trigger("click")
                    } else {
                        $(this)[0].checked = false;
                    }
                });

            }
        });

        $('#none-modal').on('hidden.bs.modal', function() {
            $('input[name="type_of_goods"]').each(function() {
                if ($(this).val() == "Food delivery services (Annual turnover less than 20 lakh)") {
                    $(this)[0].checked = true;
                    $(this).trigger("click")
                } else {
                    $(this)[0].checked = false;
                }

            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("input[name='gst1']").click(function() {
                if ($("#gst_have1").is(":checked")) {
                    $("#have_gst1").show();
                    document.getElementById("gsthave2").required = true;
                    document.getElementById("gsthave2").pattern = '[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}';
                    document.getElementById("gsthave2").maxLength = 15;
                    document.getElementById("gsthave2").minLength = 15;
                    var regexGST = $("#gsthave2")[0].attributes.pattern.value;
                    $("#gsthave2").rules("add", {
                        regexGST: "^" + regexGST + "$"
                    });
                    document.getElementById("gstdonothave2").required = false;
                    $("#gstdonothave2").rules("remove");
                    // document.getElementById("turnover").required = false;
                    $("#not_have_gst1").hide();
                } else if ($("#gst_do_not_have1").is(":checked")) {
                    $("#not_have_gst1").show();
                    document.getElementById("gstdonothave2").required = true;
                    document.getElementById("gstdonothave2").pattern = '[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}';
                    document.getElementById("gstdonothave2").maxLength = 15;
                    document.getElementById("gstdonothave2").minLength = 15;
                    var regexGST = $("#gstdonothave2")[0].attributes.pattern.value;
                    $("#gstdonothave2").rules("add", {
                        regexGST: "^" + regexGST + "$"
                    });
                    document.getElementById("gsthave2").required = false;
                    $("#gsthave2").rules("remove");
                    // document.getElementById("turnover").required = true;
                    // $("#turnover-req")[0].innerHTML = " *";
                    $("#have_gst1").hide();
                } else {
                    $("#not_have_gst1").hide();
                    $("#have_gst1").hide();
                    document.getElementById("gstdonothave2").required = false;
                    document.getElementById("gsthave2").required = false;
                    // document.getElementById("turnover").required = true;
                }
            });
        });
    </script>
    <script>
        $(function() {
            $(document).ready(function() {

                var todaysDate = new Date(); // Gets today's date

                // Max date attribute is in "YYYY-MM-DD".  Need to format today's date accordingly

                var year = todaysDate.getFullYear(); // YYYY
                var month = ("0" + (todaysDate.getMonth() + 1)).slice(-2); // MM
                var day = ("0" + todaysDate.getDate()).slice(-2); // DD

                var maxDate = (year + "-" + month + "-" + day); // Results in "YYYY-MM-DD" for today's date 

                // Now to set the max date value for the calendar to be today's date
                $('#dateof input').attr('max', maxDate);

            });
        });
    </script>
    <script>
        $("input[name=gst_yes_no]").change(function() {
            if ($(this)[0].id == "gst_have_yes" || $(this)[0].id == "gst_applied_for") {
                if ($(this)[0].id == "gst_have_yes") {
                    $("#gst_have")[0].checked = true;

                }
                if ($(this)[0].id == "gst_applied_for") {
                    $("#gst_do_not_have")[0].checked = true;

                }
                byPassGstSelection();
                $("#turnover option[value='Above 20 lakh']").remove();
                document.getElementById("turnover").required = true;
                $("#turnover-req")[0].innerHTML = " *";
                // $("#selected_yes").removeClass("hideMe");
                $("#selected_no").addClass("hideMe");
                $('input[name=type_of_goods]').each(function() {
                    $(this)[0].required = false;

                });
                $('input[name=gst]').each(function() {
                    $(this)[0].required = true;
                    if (this.checked) {
                        if ($(this)[0].id == "gst_have") {
                            $("#have_gst").show();
                            document.getElementById("gsthave1").required = true;
                            document.getElementById("gsthave1").pattern = '[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z,4]{1}[0-9A-Z]{1}';
                            document.getElementById("gsthave1").maxLength = 15;
                            document.getElementById("gsthave1").minLength = 15;
                            var regexGST = $("#gsthave1")[0].attributes.pattern.value;
                            $("#gsthave1").rules("add", {
                                regexGST: "^" + regexGST + "$"
                            });
                            document.getElementById("gstdonothave1").required = false;
                        } else if ($(this)[0].id == "gst_do_not_have") {
                            $("#not_have_gst").show();
                            document.getElementById("gstdonothave1").required = true;
                            // document.getElementById("gstdonothave1").pattern = '[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}';
                            // document.getElementById("gstdonothave1").maxLength = 15;
                            // document.getElementById("gstdonothave1").minLength = 15;
                            // var regexGST = $("#gstdonothave1")[0].attributes.pattern.value;
                            // $("#gstdonothave1").rules("add", {
                            //     regexGST: "^" + regexGST + "$"
                            // });
                            document.getElementById("gsthave1").required = false;
                        }
                    }
                });
            } else if ($(this)[0].id == "gst_have_no") {

                $('input[name=gst]').each(function() {
                    $(this)[0].required = false;
                });
                $('input[name=type_of_goods]').each(function() {
                    $(this)[0].required = true;
                    if ($(this).val() == "Food delivery services (Annual turnover less than 20 lakh)") {
                        $(this)[0].checked = true;
                    }

                });
                $("#selected_no").removeClass("hideMe");
                $("#selected_yes").addClass("hideMe");
                $("#not_have_gst").hide();
                $("#have_gst").hide();
                document.getElementById("gstdonothave1").required = false;
                document.getElementById("gsthave1").required = false;
                $('input[name=gst]').each(function() {
                    if ($(this)[0].id == "gst_have") {
                        $("#gst_have").rules("remove");
                    } else if ($(this)[0].id == "gst_do_not_have") {
                        $("#gst_do_not_have").rules("remove");

                    }
                });
                if ($('input[name="type_of_goods"]').is(':checked') && $('input[name="type_of_goods"]').val() == 'exempted_goods') {
                    document.getElementById("turnover").required = true;
                    $("#turnover-req")[0].innerHTML = "";
                    $('#start-exempted-modal').modal('show');
                    if ($('#turnover option').length <= 4) {
                        $("#turnover").append(new Option("Above 20 lakh", "Above 20 lakh"));
                    }
                }
                if ($('input[name="type_of_goods"]').is(':checked') && $('input[name="type_of_goods"]').val() == 'none') {
                    document.getElementById("turnover").required = false;
                    $("#turnover-req")[0].innerHTML = "";
                    $('input[name="type_of_goods"]')[0].checked = false;
                    $('#none-modal').modal('show');
                    if ($('#turnover option').length <= 4) {
                        $("#turnover").append(new Option("Above 20 lakh", "Above 20 lakh"));
                    }
                }
                if ($('input[name="type_of_goods"]').is(':checked') && $('input[name="type_of_goods"]').val() == 'Food delivery services (Annual turnover less than 20 lakh)') {
                    $("#turnover option[value='Above 20 lakh']").remove();
                    document.getElementById("turnover").required = true;
                    $("#turnover-req")[0].innerHTML = " *";
                }
            }

        });
        $(document).ready(function() {
            if ($("input[name=gst_yes_no]")[0].id == "gst_have_yes" || $("input[name=gst_yes_no]")[0].id == "gst_applied_for") {
                if ($("input[name=gst_yes_no]")[0].id == "gst_have_yes") {
                    $("#gst_have")[0].checked = true;


                }
                if ($("input[name=gst_yes_no]")[0].id == "gst_have_yes") {
                    $("#gst_have")[0].checked = true;


                }

                if ($("input[name=gst_yes_no]")[0].id == "gst_applied_for") {
                    $("#gst_do_not_have")[0].checked = true;

                }
                byPassGstSelection();
                // $("#selected_yes").removeClass("hideMe");
                console.log('12345678')
                $("#turnover option[value='Above 20 lakh']").remove();
                document.getElementById("turnover").required = true;
                $("#turnover-req")[0].innerHTML = " *";

                $("#selected_no").addClass("hideMe");
                $('input[name=type_of_goods]').each(function() {
                    $("input[name=gst_yes_no]")[0].required = false;
                });
                $('input[name=gst]').each(function() {
                    $("input[name=gst_yes_no]")[0].required = true;
                    if (this.checked) {
                        if ($("input[name=gst_yes_no]")[0].id == "gst_have") {
                            $("#have_gst").show();
                            document.getElementById("gsthave1").required = true;
                            document.getElementById("gsthave1").pattern = '[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z,4]{1}[0-9A-Z]{1}';
                            document.getElementById("gsthave1").maxLength = 15;
                            document.getElementById("gsthave1").minLength = 15;
                            var regexGST = $("#gsthave1")[0].attributes.pattern.value;
                            $("#gsthave1").rules("add", {
                                regexGST: "^" + regexGST + "$"
                            });
                            document.getElementById("gstdonothave1").required = false;


                        } else if ($("input[name=gst_yes_no]")[0].id == "gst_do_not_have") {
                            $("#not_have_gst").show();
                            document.getElementById("gstdonothave1").required = true;
                            // document.getElementById("gstdonothave1").pattern = '[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}';
                            // document.getElementById("gstdonothave1").maxLength = 15;
                            // document.getElementById("gstdonothave1").minLength = 15;
                            // var regexGST = $("#gstdonothave1")[0].attributes.pattern.value;
                            // $("#gstdonothave1").rules("add", {
                            //     regexGST: "^" + regexGST + "$"
                            // });
                            document.getElementById("gsthave1").required = false;
                        }
                    }
                });
            } else if ($("input[name=gst_yes_no]")[0].id == "gst_have_no") {
                $('input[name=gst]').each(function() {
                    $("input[name=gst_yes_no]")[0].required = false;
                });
                $('input[name=type_of_goods]').each(function() {
                    $("input[name=gst_yes_no]")[0].required = true;
                });
                $("#selected_no").removeClass("hideMe");
                $("#selected_yes").addClass("hideMe");
                $("#not_have_gst").hide();
                $("#have_gst").hide();
                document.getElementById("gstdonothave1").required = false;
                document.getElementById("gsthave1").required = false;
                $('input[name=gst]').each(function() {
                    if ($("input[name=gst_yes_no]")[0].id == "gst_have") {
                        $("#gst_have").rules("remove");
                    } else if ($("input[name=gst_yes_no]")[0].id == "gst_do_not_have") {
                        $("#gst_do_not_have").rules("remove");
                    }
                });
            }
        });
    </script>
    <script>
        $("#supplier_type_goods").change(function() {
            if ($(this).val() == "Non Food Products") {
                $("#fssai_div").hide();
                $("input[name='fssai_number'")[0].value = "";
                $("input[name='fssai_number'")[0].required = false;
            } else {
                $("#fssai_div").show();
                $("input[name='fssai_number'")[0].required = true;
            }
        });
    </script>
    <script>
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }

        today = yyyy + '-' + mm + '-' + dd;
        // document.getElementById("dob").setAttribute("max", today);
    </script>
    <script>
        var today1 = new Date();
        var dd1 = today1.getDate();
        var mm1 = today1.getMonth() + 1; //January is 0!
        var yyyy1 = today1.getFullYear();
        if (dd1 < 10) {
            dd1 = '0' + dd1
        }
        if (mm1 < 10) {
            mm1 = '0' + mm1
        }

        today1 = yyyy1 + '-' + mm1 + '-' + dd1;
        document.getElementById("dob1").setAttribute("max", today1);
    </script>
    <script>
        function submit_assistance() {
            var final_ass;
            var favorite_assistance = [];
            $.each($("input[name='assistance_inputs']:checked"), function() {
                favorite_assistance.push($(this).val());
            });
            //final_sup = favorite.toString();
            console.log(favorite_assistance);
            document.getElementById("assistance").value = favorite_assistance;
            console.log(document.getElementById("assistance").value);
            $('#assistance-modal').modal('hide');
            //alert(favorite);
        }
    </script>
    <script>
        $("input[name='trademark_yes_no']").click(function() {
            if ($(this).val() == "N") {
                $('#trademark_modal').modal('show');
                $(this)[0].checked = false;
            }

        });

        $("#accept_addendum").click(function() {
            $("input[name='trademark_yes_no']").each(function() {
                if ($(this).val() == "N") {
                    $(this)[0].checked = true;
                }
            })
        });

        $("#reject_addendum").click(function() {
            $("input[name='trademark_yes_no']").each(function() {
                if ($(this).val() == "Y") {
                    $(this)[0].checked = true;
                }
            })
        })
    </script>

    <script>
        $('.datepick').each(function() {
            $(this).datepicker({
                dateFormat: "dd-mm-yy",
                changeYear: true,
                changeMonth: true,
                changeYear: true,
                yearRange: '1910:',
                // minDate: new Date(1999, 10 - 1, 25),
                setDate: new Date(),
                maxDate: '+90Y',
                inline: true
            });
            $(this).datepicker('option', {
                maxDate: new Date()
            });
        });
    </script>



    <script>
        // $(document).ready(function() {
        $('input[name="ship_yes_no"]').click(function() {
            var ship = $('input[name="ship_yes_no"]:checked').val();
            if (ship == "self_shipped") {
                $("#selected_self").removeClass("hideMe");
                $("input[name=ship_charge]")[0].required = true;
            } else if (ship != "self_shipped") {
                $("#selected_self").addClass("hideMe");
                $("input[name=ship_charge]")[0].required = false;
                document.getElementById('ship_cod').style.display = 'none';
                $("input[name=min_thresh]")[0].required = false;
                $("input[name=ship_amt]")[0].required = false;
                $("input[name=cod_chrg]")[0].required = false;

            }
        });

        $('input[name="ship_charge"]').click(function() {
            var ship_charge = $('input[name="ship_charge"]:checked').val();
            if (ship_charge == 'yes') {
                document.getElementById('ship_cod').style.display = 'block';
                $("input[name=min_thresh]")[0].required = true;
                $("input[name=ship_amt]")[0].required = true;
                $("input[name=cod_chrg]")[0].required = true;
            } else if (ship_charge != 'yes') {
                document.getElementById('ship_cod').style.display = 'none';
                $("input[name=min_thresh]")[0].required = false;
                $("input[name=ship_amt]")[0].required = false;
                $("input[name=cod_chrg]")[0].required = false;
            }
        });
    </script>
    <script>
        $('#gharobaar_gst').tooltip({
            tooltipClass: "tooltip-styling",
            placement: 'bottom'
        });
    </script>
</body>

</html>