<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->

<head>
    <style>
        /* Style all input fields */


        /* Style the submit button */

        /* Style the container for inputs */


        /* The message box is shown when the user clicks on the password field */
        #message {
            display: none;
            background: #f1f1f1;
            color: #000;
            position: relative;
            padding: 3px;
            margin-top: 5px;
        }

        #message p {
            /* padding: 3px 5; */
            font-size: 12px;
            margin-bottom: 5px;
        }

        /* Add a green text color and a checkmark when the requirements are right */
        .valid {
            color: #C00000;
        }

        .valid:before {
            position: relative;
            left: -35px;
            content: "✔";
        }

        /* Add a red text color and an "x" when the requirements are wrong */
        .invalid {
            color: red;
        }

        .invalid:before {
            position: relative;
            left: -35px;
            content: "✖";
        }

        .Validation_error {
            color: red;
            font-size: 15px;
        }

        .field-icon {
            float: right;
            margin-right: 8px;
            margin-top: -23px;
            position: relative;
            z-index: 2;
            cursor: pointer;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>
<div id="wrapper">
    <div class="modal fade" id="termsCondition" role="dialog" style="display:none;">
        <div class="modal-dialog modal-dialog-centered login-modal" role="document">
            <div class="modal-content">
                <div class="auth-box">
                    <button type="button" class="close" data-dismiss="modal" onclick="t_c()"><i class="icon-close"></i></button>
                    <h4 class="title">Terms & Conditions</h4>

                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="auth-container">
            <div class="auth-box">
                <div class="row">
                    <div class="col-12">
                        <h1 class="title"><?php echo trans("register"); ?></h1>
                        <!-- form start -->
                        <?php
                        if ($recaptcha_status) {
                            echo form_open('register-post', [
                                'id' => 'form_validate', 'class' => 'validate_terms',
                                'onsubmit' => "var serializedData = $(this).serializeArray();var recaptcha = ''; $.each(serializedData, function (i, field) { if (field.name == 'g-recaptcha-response') {recaptcha = field.value;}});if (recaptcha.length < 5) { $('.g-recaptcha>div').addClass('is-invalid');return false;} else { $('.g-recaptcha>div').removeClass('is-invalid');}"
                            ]);
                        } else {
                            echo form_open('register-post', ['id' => 'form_validate', 'class' => 'validate_terms']);
                        }
                        ?>
                        <div class="social-login-cnt">
                            <?php $this->load->view("partials/_social_login", ['or_text' => 'Or Register with email']); ?>
                        </div>
                        <!-- include message block -->
                        <div id="result-register">
                            <?php $this->load->view('partials/_messages'); ?>
                        </div>
                        <div class="spinner display-none spinner-activation-register">
                            <div class="bounce1"></div>
                            <div class="bounce2"></div>
                            <div class="bounce3"></div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-4 m-b-15">

                                    <label class="control-label">First Name<span class="Validation_error"> *</span></label>

                                </div>
                                <div class="col-12 col-sm-8 m-b-15">
                                    <input type="text" name="first_name" class="form-control auth-form-input" placeholder="<?php echo trans("first_name"); ?>" value="<?php echo old("first_name"); ?>" maxlength="255" required>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-4 m-b-15">

                                    <label class="control-label">Last Name<span class="Validation_error"> *</span></label>

                                </div>
                                <div class="col-12 col-sm-8 m-b-15">
                                    <input type="text" name="last_name" class="form-control auth-form-input" placeholder="<?php echo trans("last_name"); ?>" value="<?php echo old("last_name"); ?>" maxlength="255" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-4 m-b-15">

                                    <label class="control-label">Email<span class="Validation_error"> *</span></label>

                                </div>
                                <div class="col-12 col-sm-8 m-b-15">
                                    <input type="email" name="email" class="form-control auth-form-input" placeholder="<?php echo trans("email_address"); ?>" value="<?php echo old("email"); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-4 m-b-15">

                                    <label class="control-label" style="width:105%;">Phone number<span class="Validation_error"> *</span></label>

                                </div>
                                <div class="col-12 col-sm-8 m-b-15">
                                    <input type="tel" name="phone_number" class="form-control auth-form-input" placeholder="Mobile Number" value="<?php echo old("phone_number"); ?>" minlength="10" maxlength="10" pattern="('^[0-9]{10,12}$')" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-4 m-b-15">

                                    <label class="control-label">Date Of Birth<span class="Validation_error"> *</span></label>

                                </div>
                                <div class="col-12 col-sm-8 m-b-15">
                                    <input onfocus="(this.type='date')" name="date_of_birth" id="dob" class="form-control auth-form-input" placeholder="Date of Birth" value="<?php echo old("date_of_birth"); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-4 m-b-15">

                                    <label class="control-label">Gender<span class="Validation_error"> *</span></label>

                                </div>
                                <div class="col-12 col-sm-8 m-b-15">
                                    <select name="gender" class="form-control auth-form-input" placeholder="Gender" required>
                                        <option value="" selected disabled>Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-4 m-b-15">

                                    <label class="control-label">Password<span class="Validation_error"> *</span></label>

                                </div>
                                <div class="col-12 col-sm-8 m-b-15">
                                    <input type="password" name="password" id="password" class="form-control auth-form-input" placeholder="<?php echo trans("password"); ?>" value="<?php echo old("password"); ?>" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" minlength="8">
                                    <span class="far fa-eye field-icon" id="togglePassword"></span>
                                    <div id="message">
                                        <p>Password must contain the following:
                                        <p>
                                        <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                                        <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                                        <p id="number" class="invalid">A <b>number</b></p>
                                        <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-12 col-sm-4 m-b-15">

                                    <label class="control-label">Confirm Password<span class="Validation_error"> *</span></label>

                                </div>
                                <div class="col-12 col-sm-8 m-b-15">
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control auth-form-input" placeholder="<?php echo trans("password_confirm"); ?>" required>
                                    <span class="far fa-eye field-icon" id="togglePassword1"></span>

                                </div>
                            </div>
                        </div>
                        <div class="form-group m-t-5 m-b-20">
                            <div class="custom-control custom-checkbox custom-control-validate-input">
                                <input type="checkbox" class="custom-control-input" name="terms" id="checkbox_terms" disabled>
                                <label for="checkbox_terms" class="custom-control-label"><?php echo trans("terms_conditions_exp"); ?>&nbsp;
                                    <?php $page_terms = get_page_by_default_name("terms_conditions", $this->selected_lang->id);
                                    if (!empty($page_terms)) : ?>
                                        <strong data-toggle="modal" data-target="#termsCondition"><?= html_escape($page_terms->title); ?></strong>
                                    <?php endif; ?>
                                </label>
                            </div>
                        </div>
                        <?php if ($recaptcha_status) : ?>
                            <div class="recaptcha-cnt">
                                <?php generate_recaptcha(); ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-custom btn-block"><?php echo trans("register"); ?></button>
                        </div>
                        <p class="p-social-media m-0 m-t-15"><?php echo trans("have_account"); ?>&nbsp;<a href="javascript:void(0)" class="link" data-toggle="modal" data-target="#loginModal"><?php echo trans("login"); ?></a></p>

                        <?php echo form_close(); ?>
                        <!-- form end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->
<script>
    //    $( document ).ready(function() {
    // $('#checkbox_terms').attr('disabled', true);
    // });
    function t_c() {
        $('#checkbox_terms').attr('disabled', false);
    }

    $(function() {
        $(document).ready(function() {

            var todaysDate = new Date(); // Gets today's date

            // Max date attribute is in "YYYY-MM-DD".  Need to format today's date accordingly

            var year = todaysDate.getFullYear(); // YYYY
            var month = ("0" + (todaysDate.getMonth() + 1)).slice(-2); // MM
            var day = ("0" + todaysDate.getDate()).slice(-2); // DD

            var maxDate = (year + "-" + month + "-" + day); // Results in "YYYY-MM-DD" for today's date 

            // Now to set the max date value for the calendar to be today's date
            $('#dob input').attr('max', maxDate);

        });
    });
</script>
<script>
    var myInput = document.getElementById("password");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");

    // When the user clicks on the password field, show the message box
    myInput.onfocus = function() {
        document.getElementById("message").style.display = "block";
    }

    // When the user clicks outside of the password field, hide the message box
    myInput.onblur = function() {
        document.getElementById("message").style.display = "none";
    }

    // When the user starts to type something inside the password field
    myInput.onkeyup = function() {
        // Validate lowercase letters
        var lowerCaseLetters = /[a-z]/g;
        if (myInput.value.match(lowerCaseLetters)) {
            letter.classList.remove("invalid");
            letter.classList.add("valid");
        } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
        }

        // Validate capital letters
        var upperCaseLetters = /[A-Z]/g;
        if (myInput.value.match(upperCaseLetters)) {
            capital.classList.remove("invalid");
            capital.classList.add("valid");
        } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
        }

        // Validate numbers
        var numbers = /[0-9]/g;
        if (myInput.value.match(numbers)) {
            number.classList.remove("invalid");
            number.classList.add("valid");
        } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
        }

        // Validate length
        if (myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
        }
    }
</script>
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    togglePassword.addEventListener('click', function(e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });
</script>
<script>
    const togglePassword1 = document.querySelector('#togglePassword1');
    const password1 = document.querySelector('#confirm_password');
    togglePassword1.addEventListener('click', function(e) {
        // toggle the type attribute
        const type = password1.getAttribute('type') === 'password' ? 'text' : 'password';
        password1.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });
</script>