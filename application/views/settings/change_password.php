<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->


<head>
    <style>
        #message_change {
            display: none;
            background: #f1f1f1;
            color: #000;
            position: relative;
            padding: 3px;
            margin-top: 5px;
        }

        #message_change p {
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

                        <?php echo form_open_multipart("change-password-post", ['id' => 'form_validate']); ?>
                        <?php if (!empty($user->password)) : ?>
                            <div class="form-group">
                                <label class="control-label"><?php echo trans("old_password"); ?></label>
                                <input type="password" name="old_password" class="form-control form-input" value="<?php echo old("old_password"); ?>" placeholder="<?php echo trans("old_password"); ?>" required>
                            </div>
                            <input type="hidden" name="old_password_exists" value="1">
                        <?php else : ?>
                            <input type="hidden" name="old_password_exists" value="0">
                        <?php endif; ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo trans("password"); ?></label>
                            <input type="password" name="password" id="password-field_change" class="form-control form-input" value="<?php echo old("password"); ?>" placeholder="<?php echo trans("password"); ?>" required>
                            <span toggle="#password-field_change" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            <div id="message_change">
                                <p>Password must contain the following:
                                <p>
                                <p id="letter_change" class="invalid">A <b>lowercase</b> letter</p>
                                <p id="capital_change" class="invalid">A <b>capital (uppercase)</b> letter</p>
                                <p id="number_change" class="invalid">A <b>number</b></p>
                                <p id="length_change" class="invalid">Minimum <b>8 characters</b></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo trans("password_confirm"); ?></label>
                            <input type="password" id="password-field1" name="password_confirm" class="form-control form-input" value="<?php echo old("password_confirm"); ?>" placeholder="<?php echo trans("password_confirm"); ?>" required>
                            <span toggle="#password-field1" class="fa fa-fw fa-eye field-icon toggle-password1"></span>
                            <label id="CheckPasswordMatch_change" style="color:red;"></label>

                        </div>

                        <button type="submit" class="btn btn-md btn-custom"><?php echo trans("change_password") ?></button>
                        <?php echo form_close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->

<script>
    var myInput = document.getElementById("password-field_change");
    var letter = document.getElementById("letter_change");
    var capital = document.getElementById("capital_change");
    var number = document.getElementById("number_change");
    var length = document.getElementById("length_change");

    // When the user clicks on the password field, show the message box
    myInput.onfocus = function() {
        document.getElementById("message_change").style.display = "block";
    }

    // When the user clicks outside of the password field, hide the message box
    myInput.onblur = function() {
        document.getElementById("message_change").style.display = "none";
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
        var password = $("#password-field_change").val();
        var confirmPassword = $("#password-field1").val();
        if (password != confirmPassword)
            $("#CheckPasswordMatch_change").html("Passwords do not match!");
        else
            $("#CheckPasswordMatch_change").html("");
    }
    $(document).ready(function() {
        $("#password-field1").keyup(checkPasswordMatch1);
    });
</script>