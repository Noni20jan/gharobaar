<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->

<head>
    <style>
        .card {
            position: relative;
            display: flex;
            width: 450px;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid #d2d2dc;
            border-radius: 4px;
            /* -webkit-box-shadow: 0px 0px 5px 0px rgb(249, 249, 250); */
            /* -moz-box-shadow: 0px 0px 5px 0px rgba(212, 182, 212, 1); */
            /* box-shadow: 0px 0px 5px 0px rgb(161, 163, 164) */
        }

        .card .card-body {
            padding: 1rem 1rem
        }

        .card-body {
            flex: 1 1 auto;
            padding: 1.25rem
        }


        .cross {
            padding: 10px;
            color: #d6312d;
            cursor: pointer
        }

        .continue:focus {
            outline: none
        }

        .continue {
            border-radius: 5px;
            text-transform: capitalize;
            font-size: 13px;
            padding: 8px 19px;
            cursor: pointer;
            color: #fff;
            background-color: #D50000
        }

        .continue:hover {
            background-color: #D32F2F !important
        }

        .new-header-view {
            background-color: #dbd8d836;
            padding: 35px;
            border-radius: 20px;
        }
    </style>

    <link rel="stylesheet" type="text/css" href="dist/css/style.css">

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.3.1/flatly/bootstrap.min.css"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/MultiStep.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/MultiStep-theme.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/MultiStep.min.js"></script>

</head>
<div class="container">
    <div id="wrapper">
        <div class="row">
            <div class="box box-primary">
                <div class="col-sm-12 white-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Update Profile</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="row ">
                            <div class="profile-tab-content new-header-view" style="margin: 0px 16px;">
                                <!-- include message block -->
                                <?php $this->load->view('partials/_messages'); ?>

                                <?php echo form_open_multipart("update-profile-post", ['id' => 'form_validate']); ?>
                                <div class="form-group">
                                    <p class="text-center">
                                        <img src="<?php echo get_user_avatar($user); ?>" alt="<?php echo $user->username; ?>" class="form-avatar" id="test">
                                    </p>
                                    <p class="text-center">
                                        <a class='btn btn-md btn-secondary btn-file-upload m-r-0'>
                                            Select Your Profile Picture
                                            <input type="file" name="file" size="40" accept=".png, .jpg, .jpeg, .gif" onchange=imageShow(this)>
                                        </a>
                                        <span class='badge badge-info' id="upload-file-info"></span>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo trans("email_address"); ?></label>
                                    <?php if ($this->general_settings->email_verification == 1) : ?>
                                        <?php if ($user->email_status == 1) : ?>
                                            &nbsp;
                                            <small class="text-success">(<?php echo trans("confirmed"); ?>)</small>
                                        <?php else : ?>
                                            &nbsp;
                                            <small class="text-danger">(<?php echo trans("unconfirmed"); ?>)</small>
                                            <button type="submit" name="submit" value="resend_activation_email" class="btn float-right btn-resend-email"><?php echo trans("resend_activation_email"); ?></button>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <input type="email" name="email" class="form-control form-input" value="<?php echo html_escape($user->email); ?>" placeholder="<?php echo trans("email_address"); ?>" required>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 col-md-6 m-b-sm-15">
                                            <label class="control-label"><?php echo trans("first_name"); ?></label>
                                            <input type="text" name="first_name" class="form-control form-input" value="<?php echo html_escape($this->auth_user->first_name); ?>" placeholder="<?php echo trans("first_name"); ?>" required>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="control-label"><?php echo trans("last_name"); ?></label>
                                            <input type="text" name="last_name" class="form-control form-input" value="<?php echo html_escape($this->auth_user->last_name); ?>" placeholder="<?php echo trans("last_name"); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"><?php echo trans("phone_number"); ?></label>
                                    <input type="text" name="phone_number" class="form-control form-input" value="<?php echo html_escape($this->auth_user->phone_number); ?>" placeholder="<?php echo trans("phone_number"); ?>" onKeyPress="if(this.value.length==10) return false;" required>
                                </div>
                                <div class="form-group">
                                    <div class="row">

                                        <div class="col-12 col-sm-4 m-b-15">
                                            <label class="control-label">Pincode
                                            </label>
                                            <input type="number" name="user_pincode" id="pincode" class="form-control auth-form-input" placeholder="Pincode" value="<?php echo html_escape($this->auth_user->zip_code); ?>" maxlength="6" minlength="6" onKeyPress="if(this.value.length==6) return false;" required onkeyup="get_location($('#pincode').val())">
                                            <!-- <p class="Validation_error" id="pincode_p"></p> -->
                                            <span id="pincode_span" style="color: #d43f3a;"></span>
                                        </div>


                                        <div class="col-12 col-sm-4 m-b-15">
                                            <label class="control-label">State
                                            </label>
                                            <input type="text" name="user_state" id="user_state" class="form-control auth-form-input" placeholder="State" value="<?php echo html_escape($this->auth_user->user_state); ?>" readonly>
                                            <!-- <p class="Validation_error" id="state_p"></p> -->
                                        </div>
                                        <div class="col-12 col-sm-4 m-b-15">
                                            <label class="control-label">City
                                            </label>
                                            <input type="text" name="user_city" id="user_city" class="form-control auth-form-input" placeholder="City" value="<?php echo html_escape($this->auth_user->user_city); ?>" readonly>
                                            <!-- <p class="Validation_error" id="city_p"></p> -->
                                        </div>
                                    </div>


                                </div>
                                <div class="form-group">
                                    <div class="row">


                                        <div class="col-12 col-sm-4 m-b-15">
                                            <label class="control-label">Area</label>
                                            <input type="text" name="user_area" id="user_area" class="form-control auth-form-input" placeholder="Area" value="<?php echo html_escape($this->auth_user->user_area); ?>">
                                            <!-- <p class="Validation_error" id="area_p"></p> -->
                                        </div>


                                        <div class="col-12 col-sm-4 m-b-15">
                                            <label class="control-label">House no./Building no./Area
                                            </label>
                                            <input type="text" name="user_house_no" id="user_address" class="form-control auth-form-input" placeholder="House no./Building no./Area" required value="<?php echo html_escape($this->auth_user->address); ?>">
                                            <!-- <p class="Validation_error" id="house_no_p"></p> -->

                                        </div>
                                        <div class="col-12 col-sm-4 m-b-15">
                                            <label class="control-label">Landmark</label>
                                            <input type="text" name="user_landmark" id="user_landmark" class="form-control auth-form-input" placeholder="Landmark" value="<?php echo html_escape($this->auth_user->user_landmark); ?>">
                                            <!-- <p class="Validation_error" id="landmark_p"></p> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-t-10">
                                    <div class="row">
                                        <div class="col-12 col-sm-12">
                                            <label class="control-label"><?php echo trans('email_option_send_email_new_message'); ?></label>
                                        </div>
                                        <div class="col-md-3 col-sm-4 col-12 col-option">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="send_email_new_message" value="1" id="send_email_new_message_1" class="custom-control-input" <?php echo ($user->send_email_new_message == 1) ? 'checked' : ''; ?>>
                                                <label for="send_email_new_message_1" class="custom-control-label"><?php echo trans("yes"); ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-4 col-12 col-option">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="send_email_new_message" value="0" id="send_email_new_message_2" class="custom-control-input" <?php echo ($user->send_email_new_message != 1) ? 'checked' : ''; ?>>
                                                <label for="send_email_new_message_2" class="custom-control-label"><?php echo trans("no"); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" name="submit" value="update" class="btn btn-custom"><?php echo trans("save_changes") ?></button>
                                <?php echo form_close(); ?>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div id="wrapper">
    <div class="container">
        <h3>Change Your Password</h3>
        <div class="profile-tab-content new-header-view">
            <?php $this->load->view('settings/change_password_dashboard');
            ?>
        </div>
    </div>
</div>
<div id="wrapper">
    <div class="container">
        <h3>Social Media</h3>
        <div class="profile-tab-content new-header-view m-t-15">
            <?php $this->load->view('settings/social_media_dashboard');
            ?>
        </div>
    </div>
</div>
<div id="wrapper">
    <div class="container">
        <h3>Edit Your Address</h3>
        <div class="profile-tab-content new-header-view m-t-15">
            <?php $this->load->view('dashboard/addresses');
            ?>
        </div>
    </div>
</div>
<!-- Wrapper End-->

<script>
    $('.modal').MultiStep({
        data: mySteps,
        prevText: 'Previous',
        skipText: 'Skip',
        nextText: 'Next',
        finishText: 'Finish'
    });

    function imageShow(input) {
        $('#upload-file-info').html($(input).val().replace(/.*[\/\\]/, ''));
        readURL(input);
    };

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#test').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
</script>

<script>
    function get_location(pincode) {
        console.log("hello");
        document.getElementById('user_state').value = "";
        document.getElementById('user_city').value = "";
        document.getElementById('user_area').value = "";
        document.getElementById('user_address').value = "";
        document.getElementById('user_landmark').value = "";

        var url = "https://api.postalpincode.in/pincode/" + pincode;
        $.ajax({
            url: url,
            cache: false,
            success: function(html) {
                console.log(html)
                if (html[0].PostOffice == null) {
                    $('#pincode_span')[0].innerHTML = "Please enter a valid pincode.";
                } else {
                    $('#pincode_span')[0].innerHTML = "";

                    $('#user_state').val(html[0].PostOffice[0].State)
                    $('#user_city').val(html[0].PostOffice[0].District)
                    $('#user_area').val(html[0].PostOffice[0].Name)
                }
            }
        })
    }
</script>