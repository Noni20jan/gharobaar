<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->

<head>
    <style>
        #message1 {
            display: none;
            background: #f1f1f1;
            color: #000;
            position: relative;
            padding: 3px;
            margin-top: 5px;
        }

        #message1 p {
            /* padding: 3px 5; */
            font-size: 12px;
            margin-bottom: 5px;
        }

        /* Add a green text color and a checkmark when the requirements are right */
        .valid {
            color: #d21f3c;
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
            margin-left: -25px;
            margin-top: -25px;
            position: relative;
            z-index: 2;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
</head>
<div id="wrapper">
    <div class="container">
        <div class="auth-container">
            <div class="auth-box">
                <div class="row">
                    <div class="col-12">
                        <h1 class="title"><?php echo trans("reset_password"); ?></h1>
                        <!-- form start -->
                        <?php echo form_open('reset-password-post', ['id' => 'form_validate_reset']); ?>
                        <!-- include message block -->
                        <?php $this->load->view('partials/_messages'); ?>
                        <?php if (!empty($user)) : ?>
                            <input type="hidden" name="token" value="<?php echo $user->token; ?>">
                        <?php endif; ?>
                        <?php if (!empty($success)) : ?>
                            <div class="form-group m-t-30">
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal" class="btn btn-md btn-custom btn-block" style="width: 16%; font-weight:700;"><?php echo trans("login_Now"); ?></a>
                            </div>
                        <?php else : ?>
                            <div class="form-group">
                                <label><?php echo trans("new_password"); ?></label>
                                <input type="password" name="password" id="password-field" class="form-control form-input" value="<?php echo old("password"); ?>" placeholder="<?php echo trans("new_password"); ?>" required>

                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                <div id="message1">
                                    <p>Password must contain the following:
                                    <p>
                                    <p id="letter1" class="invalid">A <b>lowercase</b> letter</p>
                                    <p id="capital1" class="invalid">A <b>capital (uppercase)</b> letter</p>
                                    <p id="number1" class="invalid">A <b>number</b></p>
                                    <p id="length1" class="invalid">Minimum <b>8 characters</b></p>
                                </div>

                            </div>
                            <div class="form-group m-b-30">
                                <label><?php echo trans("password_confirm"); ?></label>
                                <input type="password" name="password_confirm" id="password-field1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" class="form-control form-input" value="<?php echo old("password_confirm"); ?>" placeholder="<?php echo trans("password_confirm"); ?>" required>
                                <span toggle="#password-field1" class="fa fa-fw fa-eye field-icon toggle-password1"></span>
                                <label id="CheckPasswordMatch1" style="color:red;"></label>

                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-custom btn-block"><?php echo trans("submit"); ?></button>
                            </div>
                        <?php endif; ?>
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
    var myInput = document.getElementById("password-field");
    var letter = document.getElementById("letter1");
    var capital = document.getElementById("capital1");
    var number = document.getElementById("number1");
    var length = document.getElementById("length1");

    // When the user clicks on the password field, show the message box
    myInput.onfocus = function() {
        document.getElementById("message1").style.display = "block";
    }

    // When the user clicks outside of the password field, hide the message box
    myInput.onblur = function() {
        document.getElementById("message1").style.display = "none";
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
    $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>
<script>
    $(".toggle-password1").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input1 = $($(this).attr("toggle"));
        if (input1.attr("type") == "password") {
            input1.attr("type", "text");
        } else {
            input1.attr("type", "password");
        }
    });
</script>
<script type="text/javascript">
    function checkPasswordMatch1() {
        var password = $("#password-field").val();
        var confirmPassword = $("#password-field1").val();
        if (password != confirmPassword)
            $("#CheckPasswordMatch1").html("Passwords do not match!");
        else
            $("#CheckPasswordMatch1").html("");
    }
    $(document).ready(function() {
        $("#password-field1").keyup(checkPasswordMatch1);
    });
</script>