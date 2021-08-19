-<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
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
            
            <div class="col-sm-12 col-md-9">
                <div class="row-custom">
                    <div class="profile-tab-content">
                        <!-- include message block -->
                        <?php $this->load->view('partials/_messages'); ?>

                        <?php echo form_open_multipart("update-seller-info-services-post", ['id' => 'form_validate']); ?>
                        <div class="form-group">
                            <div class="row">

                                <div class="col-12 col-sm-6 m-b-15">
                                    <label class="control-label">Select Service Type<span class="Validation_error"> *</span></label>
                                    <select name="supplier_type_services" id="supplier_type_services" onchange='CheckServices(this.value);'  class="form-control form-input" placeholder="" required>
                                        <option value="" selected disabled>Select Service Type</option>
                                        <option value="Education/Skill Development Specialist" <?php if (html_escape($this->auth_user->supplier_type_services) == "EducationSkill Development Specialist") {
                                                                                                    echo "selected";
                                                                                                } ?>>Education/Skill Development Specialist</option>
                                        <option value="CA/Lawyer/Accountant" <?php if (html_escape($this->auth_user->supplier_type_services) == "CALawyerAccountant") {
                                                                                    echo "selected";
                                                                                } ?>>CA/Lawyer/Accountant</option>
                                        <option value="Nutritionist/Dietician" <?php if (html_escape($this->auth_user->supplier_type_services) == "NutritionistDietician") {
                                                                                    echo "selected";
                                                                                } ?>>Nutritionist/Dietician</option>
                                        <option value="Creative Field" <?php if (html_escape($this->auth_user->supplier_type_services) == "Creative Field") {
                                                                            echo "selected";
                                                                        } ?>>Creative Field</option>
                                        <option value="Others" <?php if (html_escape($this->auth_user->supplier_type_services) == "Others") {
                                                                    echo "selected";
                                                                } ?>>Others</option>


                                    </select>
                                    <p class="Validation_error" id="supplier_type_services_p"></p>

                                </div>
                                <div class="col-12 col-sm-6 m-b-15">
                                    <label class="control-label"></label>

                                    <select name="education_type" id="education_type" style='display:block;' class="form-control form-input" placeholder="">
                                        <option value=""  disabled>Select Education/Skill Development Specialist</option>
                                        <option value="Tutor" <?php if (html_escape($this->auth_user->education_type) == "Tutor") {
                                                                    echo "selected";
                                                                } ?>>Tutor</option>
                                        <option value="Musical Instrument Teacher" <?php if (html_escape($this->auth_user->education_type) == "Musical Instrument Teacher") {
                                                                                        echo "selected";
                                                                                    } ?>>Musical Instrument Teacher</option>
                                        <option value="Vocal Music Teacher" <?php if (html_escape($this->auth_user->education_type) == "Vocal Music Teacher") {
                                                                                echo "selected";
                                                                            } ?>>Vocal Music Teacher</option>
                                        <option value="Sports/Games Teacher" <?php if (html_escape($this->auth_user->education_type) == "SportsGames Teacher") {
                                                                                    echo "selected";
                                                                                } ?>>Sports/Games Teacher</option>
                                        <option value="Yoga/Fitness Coach" <?php if (html_escape($this->auth_user->education_type) == "YogaFitness Coach") {
                                                                                echo "selected";
                                                                            } ?>>Yoga/Fitness Coach</option>


                                    </select>
                                    <select name="creative_type" id="creative_type" style='display:none;' class="form-control form-input" placeholder="">
                                        <option value=""  disabled>Select Creative Type</option>
                                        <option value="Content Writer" <?php if (html_escape($this->auth_user->creative_type) == "Content Writer") {
                                                                            echo "selected";
                                                                        } ?>>Content Writer</option>
                                        <option value="Photographer" <?php if (html_escape($this->auth_user->creative_type) == "Photographer") {
                                                                            echo "selected";
                                                                        } ?>>Photographer</option>
                                        <option value="Digital Marketing Specialist" <?php if (html_escape($this->auth_user->creative_type) == "Digital Marketing Specialist") {
                                                                                            echo "selected";
                                                                                        } ?>>Digital Marketing Specialist</option>
                                        <option value="Interior Designer" <?php if (html_escape($this->auth_user->creative_type) == "Interior Designer") {
                                                                                echo "selected";
                                                                            } ?>>Interior Designer</option>
                                        <option value="Others" <?php if (html_escape($this->auth_user->creative_type) == "Others") {
                                                                    echo "selected";
                                                                } ?>>Others</option>


                                    </select>
                                    <input type="text" name="other_service_type" id="other_service_type" style='display:none;' value="<?php echo html_escape($this->auth_user->supplier_website_url); ?>" class="form-control form-input" maxlength="<?php echo $this->username_maxlength; ?>">

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-6 m-b-15">
                                    <label class="control-label">Company name<span class="Validation_error"> *</span></label>
                                    <input type="text" name="shop_name" class="form-control auth-form-input " value="<?php echo html_escape($this->auth_user->shop_name); ?>" required>
                                    <p class="Validation_error" id="company_name_p"></p>
                                </div>
                                <div class="col-12 col-sm-6 m-b-15">
                                                                            <label class="control-label">Brand Name(Company Type or what)<span class="Validation_error"> *</span></label>
                                                                            <input type="text" name="brand_name" value="<?php echo html_escape($this->auth_user->brand_name); ?>" class="form-control form-input" maxlength="<?php echo $this->username_maxlength; ?>" required>
                                                                            <p class="Validation_error" id="brand_name_p1"></p>
                                                                        </div>
                                <!-- <div class="col-12 col-sm-6 m-b-15">
                                    <label class="control-label">Company Type<span class="Validation_error"> *</span></label>
                                    <select name="company_type" id="company_type" onchange='CheckCompany(this.value);' class="form-control auth-form-input" placeholder="" required>
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

                                </div> -->
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-4 m-b-15">
                                    <label class="control-label">GST Number<span class="Validation_error"> *</span></label>
                                    <input type="text" name="gst_number1" id="gst_number" value="<?php echo html_escape($this->auth_user->gst_number); ?>" class="form-control auth-form-input" placeholder="GST number" required minlength="15" maxlength="15" pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}">
                                    <p class="Validation_error" id="gst_number_p"></p>
                                </div>
                                <div class="col-12 col-sm-4 m-b-15">
                                    <label class="control-label">Permanent Account Number (PAN)<span class="Validation_error"> *</span></label>
                                    <input type="text" name="pan_number1" id="pan_number" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->pan_number); ?>" placeholder="Pan number" required minlength="10" maxlength="10" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}">
                                    <p class="Validation_error" id="pan_number_p"></p>
                                </div>
                                <div class="col-12 col-sm-4 m-b-15">
                                    <label class="control-label">Aadhaar Details</label>
                                    <input type="number" name="adhaar_number1" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->adhaar_number); ?>" placeholder="Aadhaar Details">
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
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
                        </div>

                        <div class="form-group">

                            <label class="control-label">Area of operation<span class="Validation_error"> *</span></label>
                            <select name="area_in_operation1" id="area_in_operation" class="form-control auth-form-input" placeholder="" required>
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
                                <option value="PAN India" <?php if (html_escape($this->auth_user->area_in_operation) == "PAN India") {
                                                                echo "selected";
                                                            } ?>>PAN India</option>
                                <option value="International" <?php if (html_escape($this->auth_user->area_in_operation) == "International") {
                                                                    echo "selected";
                                                                } ?>>International</option>
                                <!-- hai ! :d ka likhre -->

                            </select>
                            <p class="Validation_error" id="area_in_operation_p"></p>
                        </div>
                       
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-6 m-b-15">
                                    <label class="control-label">Years in Operation<span class="Validation_error"> *</span></label>
                                    <select name="years_in_operation1" id="years_in_operation" class="form-control form-input" placeholder="" required>
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
                                    <select name="hear_about_us1" id="hear_about_us" class="form-control form-input" placeholder="" required>
                                        <option value="" selected disabled>Select</option>
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
                                    <select name="assistance1" id="assistance" class="form-control form-input" placeholder="" required>
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
                                    <label class="control-label">Where are you originally from? </label>
                                    <input type="text" name="originally_belongs" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->originally_belongs); ?>" placeholder="Your City">
                                </div>
                                <div class="col-12 col-sm-4 m-b-15">
                                    <label class="control-label">Anything else you would like to share with us? </label>
                                    <input type="text" name="share" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->share); ?>" placeholder="">

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-6 m-b-15">


                                    <label class="control-label">Open to visit in person ?<span class="Validation_error"> *</span> </label>
                                    <br>
                                    <input type="radio" name="visit_inperson" value="Y" <?php if (html_escape($this->auth_user->open_to_visit) == "Y") {
                                                                                            echo "checked";
                                                                                        } ?>>
                                    <label for="y">Yes</label>
                                    <input type="radio" name="visit_inperson" value="N" <?php if (html_escape($this->auth_user->open_to_visit) == "N") {
                                                                                            echo "checked";
                                                                                        } ?>>
                                    <label for="n"> No</label>
                                    <p class="Validation_error" id="visit_inperson_p"></p>


                                </div>
                                <div class="col-12 col-sm-6 m-b-15">
                                    <label class="control-label">Willing to travel Outside your City ?<span class="Validation_error"> *</span> </label>
                                    <br>
                                    <input type="radio" id="y" name="travel_outside" value="Y" <?php if (html_escape($this->auth_user->willing_to_travel) == "Y") {
                                                                                                    echo "checked";
                                                                                                } ?>>
                                    <label for="y">Yes</label>
                                    <input type="radio" id="n" name="travel_outside" value="N" <?php if (html_escape($this->auth_user->willing_to_travel) == "N") {
                                                                                                    echo "checked";
                                                                                                } ?>>
                                    <label for="n"> No</label>
                                    <p class="Validation_error" id="travel_outside_p"></p>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Affiliations/Certifications<span class="Validation_error"> *</span></label>
                            <input type="text" name="certificate_name" id="certificate_name" value="<?php echo html_escape($this->auth_user->affiliations_or_certifications); ?>" class="form-control form-input" required>
                            <p class="Validation_error" id="certification_p"></p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Institute Name</label>
                            <input type="text" name="institute_name" value="<?php echo html_escape($this->auth_user->institute_name); ?>" class="form-control form-input">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Details of Specialisation</label>
                            <textarea name="details_spec" class="form-control form-textarea"  placeholder="Describe about your specialisation..."><?= $this->auth_user->specialisation_details; ?></textarea>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-4 m-b-15">
                                    <label class="control-label">Preferable Timings<span class="Validation_error"> *</span></label>
                                </div>
                                <div class="col-12 col-sm-4 m-b-15">

                                    <select name="week" id="week" class="form-control form-input" placeholder="" required>
                                        <option value="" selected disabled>Select</option>
                                        <option value="Weekend" <?php if (html_escape($this->auth_user->prefer_day) == "Weekend") {
                                                                    echo "selected";
                                                                } ?>>Weekend</option>
                                        <option value="Weekdays" <?php if (html_escape($this->auth_user->prefer_day) == "Weekdays") {
                                                                        echo "selected";
                                                                    } ?>>Weekdays</option>
                                        <option value="Both" <?php if (html_escape($this->auth_user->prefer_day) == "Both") {
                                                                    echo "selected";
                                                                } ?>>Both</option>

                                    </select>
                                    <p class="Validation_error" id="week_p"></p>
                                </div>
                                <div class="col-12 col-sm-4 m-b-15">

                                    <select name="day" id="day" class="form-control form-input" placeholder="" required>
                                        <option value="" selected disabled>Select</option>
                                        <option value="Morning" <?php if (html_escape($this->auth_user->prefer_time) == "Morning") {
                                                                    echo "selected";
                                                                } ?>>Morning</option>
                                        <option value="Evening" <?php if (html_escape($this->auth_user->prefer_time) == "Evening") {
                                                                    echo "selected";
                                                                } ?>>Evening</option>
                                        <option value="Afternoon" <?php if (html_escape($this->auth_user->prefer_time) == "Afternoon") {
                                                                        echo "selected";
                                                                    } ?>>Afternoon</option>

                                    </select>
                                    <p class="Validation_error" id="day_p"></p>
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
                                    <input type="text" name="refname1" value="<?php echo html_escape($this->auth_user->reference_1_name); ?>" class="form-control form-input" required placeholder="Name">
                                </div>
                                <div class="col-12 col-sm-4 m-b-15">
                                    <label class="control-label">Contact<span class="Validation_error"> *</span>
                                    </label>
                                    <input type="number" name="refcontact1" value="<?php echo html_escape($this->auth_user->reference_1_contact); ?>" class="form-control form-input" maxlength="10" minlength="10" required placeholder="Contact">
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
                                        <input type="text" name="refname2" value="<?php echo html_escape($this->auth_user->reference_2_name); ?>" class="form-control form-input" placeholder="Name">
                                    </div>
                                    <div class="col-12 col-sm-4 m-b-15">
                                        <label class="control-label">Contact
                                        </label>
                                        <input type="number" name="refcontact2" value="<?php echo html_escape($this->auth_user->reference_2_contact); ?>" maxlength="10" minlength="10" class="form-control form-input" placeholder="Contact">
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
                                        <input type="text" name="refname3" value="<?php echo html_escape($this->auth_user->reference_3_name); ?>" class="form-control form-input" placeholder="Name">
                                    </div>
                                    <div class="col-12 col-sm-4 m-b-15">
                                        <label class="control-label">Contact
                                        </label>
                                        <input type="number" name="refcontact3" value="<?php echo html_escape($this->auth_user->reference_3_contact); ?>" maxlength="10" minlength="10" class="form-control form-input" placeholder="Contact">
                                    </div>


                                </div>
                            </div>

                        </div>

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

    <!-- <script type="text/javascript">
       $(document).ready(function() {
           CheckServices(<?php echo $this->auth_user->supplier_type_services ?>);
      
    </script> -->