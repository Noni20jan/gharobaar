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
    <style>
        .update_wrapper {
            background-color: #fdfdfd9c;
            border: groove;
            border-radius: 20px;
            padding-bottom: 10px;
            padding-top: 10px;
        }
    </style>

</head>
<div id="wrapper" class="update_wrapper">
    <div class="container">
        <div class="row">
            <!-- <div class="col-sm-12 col-md-9"> -->
            <div class="row-custom">
                <div class="profile-tab-content">
                    <!-- include message block -->
                    <?php $this->load->view('partials/_messages'); ?>

                    <?php echo form_open_multipart("update-seller-info-post", ['id' => 'form_validate']); ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-sm-4 m-b-15">

                                <label class="control-label">Select Good Type<span class="Validation_error"> *</span></label>
                                <select name="supplier_type_goods" id="supplier_type_goods" class="form-control auth-form-input" required disabled>
                                    <option value="" disabled selected>Select Good Type</option>
                                    <option value="Food Products" <?php if (html_escape($this->auth_user->supplier_type_goods) == "Food Products") {
                                                                        echo "selected";
                                                                    } ?>>Food Products</option>
                                    <option value="Non Food Products" <?php if (html_escape($this->auth_user->supplier_type_goods) == "Non Food Products") {
                                                                            echo "selected";
                                                                        } ?>>Non Food Products</option>
                                    <option value="Both" <?php if (html_escape($this->auth_user->supplier_type_goods) == "Both") {
                                                                echo "selected";
                                                            } ?>>Both</option>
                                </select>
                                <p class="Validation_error" id="supplier_type_goods_p"></p>
                            </div>
                            <div class="col-12 col-sm-4 m-b-15">
                                <label class="control-label">Company name<span class="Validation_error"> *</span></label>
                                <input type="text" name="shop_name" class="form-control auth-form-input " value="<?php echo html_escape($this->auth_user->shop_name); ?>" disabled>
                                <p class="Validation_error" id="company_name_p"></p>
                            </div>
                            <div class="col-12 col-sm-4 m-b-15">
                                <label class="control-label">Company Type<span class="Validation_error"> *</span></label>
                                <select name="company_type" id="company_type" onchange='CheckCompany(this.value);' class="form-control auth-form-input" placeholder="" disabled>
                                    <option value="" selected disabled>Select</option>
                                    <option value="Partnership" <?php if (html_escape($this->auth_user->company_type) == "Partnership") {
                                                                    echo "selected";
                                                                } ?>>Partnership</option>
                                    <option value="Private Limited" <?php if (html_escape($this->auth_user->company_type) == "Private Limited") {
                                                                        echo "selected";
                                                                    } ?>>Private Limited</option>
                                    <option value="Limited Liability Partnership" <?php if (html_escape($this->auth_user->company_type) == "Limited Liability Partnership") {
                                                                                        echo "selected";
                                                                                    } ?>>Limited Liability Partnership</option>
                                    <option value="Sole Proprietorship" <?php if (html_escape($this->auth_user->company_type) == "Sole Proprietorship") {
                                                                            echo "selected";
                                                                        } ?>>Sole Proprietorship</option>
                                    <option value="One person Company" <?php if (html_escape($this->auth_user->company_type) == "One person Company") {
                                                                            echo "selected";
                                                                        } ?>>One person Company</option>
                                    <option value="NGO" <?php if (html_escape($this->auth_user->company_type) == "NGO") {
                                                            echo "selected";
                                                        } ?>>NGO</option>
                                    <option value="Joint Venture" <?php if (html_escape($this->auth_user->company_type) == "Joint Venture") {
                                                                        echo "selected";
                                                                    } ?>>Joint Venture</option>
                                    <option value="Other" <?php if (html_escape($this->auth_user->company_type) == "Other") {
                                                                echo "selected";
                                                            } ?>>Other</option>
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
                                <label class="control-label">First Name<span class="Validation_error"> *</span></label>
                                <input type="text" value="<?php echo html_escape($this->auth_user->first_name); ?>" class="form-control auth-form-input" placeholder="GST number" disabled>

                            </div>
                            <div class="col-12 col-sm-4 m-b-15">
                                <label class="control-label">Middle Name</label>
                                <input type="text" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->middle_name); ?>" placeholder="Pan number" disabled>

                            </div>
                            <div class="col-12 col-sm-4 m-b-15">
                                <label class="control-label">Last Name <span class="Validation_error"> *</span></label>
                                <input type="number" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->last_name); ?>" placeholder="Last Name" disabled>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-sm-4 m-b-15">
                                <label class="control-label">GST Number<span class="Validation_error"> *</span></label>
                                <input type="text" name="gst_number" id="gst_number" value="<?php echo html_escape($this->auth_user->gst_number); ?>" class="form-control auth-form-input" placeholder="GST number" disabled>
                                <p class="Validation_error" id="gst_number_p"></p>
                            </div>
                            <div class="col-12 col-sm-4 m-b-15">
                                <label class="control-label">Permanent Account Number (PAN)<span class="Validation_error"> *</span></label>
                                <input type="text" name="pan_number" id="pan_number" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->pan_number); ?>" placeholder="Pan number" disabled>
                                <p class="Validation_error" id="pan_number_p"></p>
                            </div>
                            <div class="col-12 col-sm-4 m-b-15">
                                <label class="control-label">Aadhaar Details</label>
                                <input type="number" name="adhaar_number" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->adhaar_number); ?>" placeholder="Aadhaar Details" disabled>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-sm-4 m-b-15">
                                <label class="control-label">Area of operation<span class="Validation_error"> *</span></label>
                                <select name="area_in_operation" id="area_in_operation" class="form-control auth-form-input" placeholder="" required>
                                    <option value="" selected disabled>Select</option>
                                    <option value="Within Locality (Typically 0-5 kms radius)" <?php if (html_escape($this->auth_user->area_in_operation) == "Within Locality (Typically 0-5 kms radius)") {
                                                                                                    echo "selected";
                                                                                                } ?>>Within Locality (Typically 0-5 kms radius)</option>
                                    <option value="Within City (Typically 0-30 km radius)" <?php if (html_escape($this->auth_user->area_in_operation) == "Within City (Typically 0-30 km radius)") {
                                                                                                echo "selected";
                                                                                            } ?>>Within City (Typically 0-30 km radius)</option>
                                    <option value="Nearby areas (including adjacent inter-state areas)" <?php if (html_escape($this->auth_user->area_in_operation) == "Nearby areas (including adjacent inter-state areas)") {
                                                                                                            echo "selected";
                                                                                                        } ?>>Nearby areas (including adjacent inter-state areas)</option>
                                    <option value="Within State" <?php if (html_escape($this->auth_user->area_in_operation) == "Within State") {
                                                                        echo "selected";
                                                                    } ?>>Within State</option>
                                    <!-- <option value="Limited Liability Partnership">PAN India</option> -->
                                    <option value="Pan India" <?php if (html_escape($this->auth_user->area_in_operation) == "Pan India") {
                                                                    echo "selected";
                                                                } ?>>Pan India</option>
                                    <option value="International" <?php if (html_escape($this->auth_user->area_in_operation) == "International") {
                                                                        echo "selected";
                                                                    } ?>>International</option>
                                    <!-- hai ! :d ka likhre -->

                                </select>
                                <p class="Validation_error" id="area_in_operation_p"></p>
                            </div>
                            <div class="col-12 col-sm-4 m-b-15">
                                <label class="control-label">Annual Turnover</label>
                                <select name="turnover" id="turnover" class="form-control auth-form-input" placeholder="">
                                    <option value="" selected disabled>Select</option>
                                    <option value="Less than 5 lakhs" <?php if (html_escape($this->auth_user->turnover) == "Less than 5 lakhs") {
                                                                            echo "selected";
                                                                        } ?>>Less than 5 lakhs</option>
                                    <option value="5-10 lakh" <?php if (html_escape($this->auth_user->turnover) == "5-10 lakh") {
                                                                    echo "selected";
                                                                } ?>>5-10 lakh</option>
                                    <option value="10-20 lakh" <?php if (html_escape($this->auth_user->turnover) == "10-20 lakh") {
                                                                    echo "selected";
                                                                } ?>>10-20 lakh</option>
                                    <option value="5-10 lakh" <?php if (html_escape($this->auth_user->turnover) == "5-10 lakh") {
                                                                    echo "selected";
                                                                } ?>>5-10 lakh</option>
                                </select>

                            </div>
                            <div class="col-12 col-sm-4 m-b-15">
                                <label class="control-label">Active Customers</label>

                                <select name="active_customers" id="active_customers" class="form-control auth-form-input" placeholder="">
                                    <option value="" selected disabled>Select</option>
                                    <option value="Less than 50" <?php if (html_escape($this->auth_user->active_customer) == "Less than 50") {
                                                                        echo "selected";
                                                                    } ?>>Less than 50</option>
                                    <option value="50-100" <?php if (html_escape($this->auth_user->active_customer) == "50-100") {
                                                                echo "selected";
                                                            } ?>>50-100</option>
                                    <option value="100-300" <?php if (html_escape($this->auth_user->active_customer) == "100-300") {
                                                                echo "selected";
                                                            } ?>>100-300</option>
                                    <option value="More than 300" <?php if (html_escape($this->auth_user->active_customer) == "More than 300") {
                                                                        echo "selected";
                                                                    } ?>>More than 300</option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-sm-4 m-b-15">
                                <label class="control-label">USP (Unique Selling Proposition)<span class="Validation_error"> *</span> <i class="fa fa-info-circle" title="A brief description of what makes your product or service exceptional and different from your competitors"></i></label>

                            </div>

                            <div class="col-12 col-sm-8 m-b-15">

                                <div class="col-12 col-sm-8 m-b-15">

                                    <input type="text" list="usp_service" name="usp" class="form-control form-input" value="<?php echo html_escape($this->auth_user->usp); ?>" required /></label>
                                    <p class="Validation_error" id="usp_p"></p>
                                    <datalist id="usp_service">
                                        <option value="Available on all days for classes, including weekends">
                                        <option value="Amongst top 10 teachers ">
                                        <option value="Customised to receiver’s requirements/maturity/skill">
                                        <option value="Specialise in making students crack competitive examinations">
                                        <option value="Physically transformed many people with my workout plans">
                                    </datalist>

                                </div>

                            </div>


                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-sm-6 m-b-15">
                                <label class="control-label">Years in Operation<span class="Validation_error"> *</span></label>
                                <select name="years_in_operation" id="years_in_operation" class="form-control form-input" placeholder="" required>
                                    <option value="" selected disabled>Select</option>
                                    <option value="0-6" <?php if (html_escape($this->auth_user->years_in_operation) == "0-6") {
                                                            echo "selected";
                                                        } ?>>Less than 6 months</option>
                                    <option value="6-24" <?php if (html_escape($this->auth_user->years_in_operation) == "6-24") {
                                                                echo "selected";
                                                            } ?>>6 months to 2 years</option>
                                    <option value="5-10" <?php if (html_escape($this->auth_user->years_in_operation) == "5-10") {
                                                                echo "selected";
                                                            } ?>>2-5 years</option>
                                    <option value="more than 5" <?php if (html_escape($this->auth_user->years_in_operation) == "more than 5") {
                                                                    echo "selected";
                                                                } ?>>More than 5 years</option>


                                </select>
                                <p class="Validation_error" id="years_in_operation_p"></p>
                            </div>
                            <div class="col-12 col-sm-6 m-b-15">
                                <label class="control-label">How Did You hear about us?<span class="Validation_error"> *</span></label>
                                <select name="how_hear_about_us" id="how_hear_about_us" class="form-control form-input" placeholder="" required>
                                    <option value="" disabled>Select</option>
                                    <option value="Facebook" <?php if (html_escape($this->auth_user->how_hear_about_us) == "Facebook") {
                                                                    echo "selected";
                                                                } ?>>Facebook</option>
                                    <option value="Instagram" <?php if (html_escape($this->auth_user->how_hear_about_us) == "Instagram") {
                                                                    echo "selected";
                                                                } ?>>Instagram</option>
                                    <option value="Google" <?php if (html_escape($this->auth_user->how_hear_about_us) == "Google") {
                                                                echo "selected";
                                                            } ?>>Google</option>
                                    <option value="Friends and family " <?php if (html_escape($this->auth_user->how_hear_about_us) == "Friends and family") {
                                                                            echo "selected";
                                                                        } ?>>Friends and family </option>
                                    <option value="Linkedin" <?php if (html_escape($this->auth_user->how_hear_about_us) == "Linkedin") {
                                                                    echo "selected";
                                                                } ?>>Linkedin</option>

                                    <option value="Email" <?php if (html_escape($this->auth_user->how_hear_about_us) == "Email") {
                                                                echo "selected";
                                                            } ?>>Email</option>
                                    <option value="Reference" <?php if (html_escape($this->auth_user->how_hear_about_us) == "Reference") {
                                                                    echo "selected";
                                                                } ?>>Reference</option>
                                </select>
                                <p class="Validation_error" id="hear_about_us_p"></p>
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
                                <input type="radio" name="barter" value="Y" <?php if (html_escape($this->auth_user->barter) == "Y") {
                                                                                echo "checked";
                                                                            } ?>>
                                <label for="y">Yes</label>
                                <input type="radio" name="barter" value="N" <?php if (html_escape($this->auth_user->barter) == "N") {
                                                                                echo "checked";
                                                                            } ?>>
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
                                <select name="assistance" id="assistance" class="form-control form-input" placeholder="" required>
                                    <option value="" selected disabled>Select</option>
                                    <option value="Photography/Videos" <?php if (html_escape($this->auth_user->assistance) == "Photography/Videos") {
                                                                            echo "selected";
                                                                        } ?>>Photography/Videos</option>
                                    <option value="Story writing/Content Writing" <?php if (html_escape($this->auth_user->assistance) == "Story writing/Content Writing") {
                                                                                        echo "selected";
                                                                                    } ?>>Story writing/Content Writing</option>
                                    <option value="Supplier Page designing" <?php if (html_escape($this->auth_user->assistance) == "Supplier Page designing") {
                                                                                echo "selected";
                                                                            } ?>>Supplier Page designing </option>
                                    <option value="Packaging Assistance" <?php if (html_escape($this->auth_user->assistance) == "Packaging Assistance") {
                                                                                echo "selected";
                                                                            } ?>>Packaging Assistance</option>
                                    <option value="Delivery Assistance" <?php if (html_escape($this->auth_user->assistance) == "Delivery Assistance") {
                                                                            echo "selected";
                                                                        } ?>>Delivery Assistance</option>
                                    <option value="Promotional Support" <?php if (html_escape($this->auth_user->assistance) == "Promotional Support") {
                                                                            echo "selected";
                                                                        } ?>>Promotional Support</option>


                                </select>
                                <p class="Validation_error" id="assistance_p1"></p>
                            </div>
                            <div class="col-12 col-sm-4 m-b-15">
                                <label class="control-label">Any Other (Describe in field)</label>
                                <input type="text" name="other_assistance1" value="<?php echo html_escape($this->auth_user->other_assistance); ?>" class="form-control form-input">
                            </div>


                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-sm-3 m-b-15">
                                <label class="control-label">Website Link</label>
                                <input type="url" placeholder="https://example.com" value="<?php echo html_escape($this->auth_user->supplier_website_url); ?>" name="website_url" class="form-control auth-form-input" placeholder="Website Link">
                            </div>
                            <div class="col-12 col-sm-3 m-b-15">


                                <label class="control-label">Facebook Page Link</label>
                                <input type="text" name="facebook_url" value="<?php echo html_escape($this->auth_user->supplier_facebook_url); ?>" class="form-control auth-form-input" placeholder="FaceBook Link">
                            </div>
                            <div class="col-12 col-sm-3 m-b-15">

                                <label class="control-label">Instagram Page Link
                                </label>
                                <input type="text" name="instagram_url" value="<?php echo html_escape($this->auth_user->supplier_instagram_url); ?>" class="form-control auth-form-input" placeholder="Instagram Link">
                            </div>
                            <div class="col-12 col-sm-3 m-b-15">
                                <label class="control-label">Any Other Page Link
                                </label>
                                <input type="text" name="other_url" value="<?php echo html_escape($this->auth_user->supplier_other_url); ?>" class="form-control auth-form-input" placeholder="Any Other Link">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12 col-sm-4 m-b-15">
                                <label class="control-label">Anniversary</label>
                                <input type="date" minlength="10" maxlength="10" name="anniversary" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->anniversary); ?>" placeholder="Anniversary">

                            </div>
                            <div class="col-12 col-sm-4 m-b-15">
                                <label class="control-label">Are you selling on other platforms? </label>
                                <input type="text" name="originally_belongs" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->other_selling_platforms); ?>" placeholder="Other selling platforms">
                            </div>
                            <div class="col-12 col-sm-4 m-b-15">
                                <label class="control-label">Anything else you would like to share with us? </label>
                                <input type="text" name="share" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->share); ?>" placeholder="">

                            </div>


                        </div>
                    </div>



                </div>

                <button type="submit" name="submit" value="update" class="btn btn-lg btn-success pull-right"><?php echo trans("save_changes") ?></button>
                <?php echo form_close(); ?>

            </div>
            <!-- </div> -->
        </div>
    </div>
</div>
</div>
<!-- Wrapper End-->