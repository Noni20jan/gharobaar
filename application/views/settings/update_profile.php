<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->

<head>
    <style>
        .fa {
            padding: 20px;
            font-size: 30px;
            width: 50px;
            text-align: center;
            text-decoration: none;
            margin: 5px 2px;
        }

        .Validation_error {
            color: red;
            font-size: 10px;
        }

        .fa:hover {
            opacity: 0.7;
        }

        .fa-facebook {
            background: #3B5998;
            color: white;
        }

        .fa-twitter {
            background: #55ACEE;
            color: white;
        }

        .fa-google {
            background: #dd4b39;
            color: white;
        }

        .fa-linkedin {
            background: #007bb5;
            color: white;
        }

        .fa-youtube {
            background: #bb0000;
            color: white;
        }

        .fa-instagram {
            background: #125688;
            color: white;
        }

        .fa-pinterest {
            background: #cb2027;
            color: white;
        }

        .fa-snapchat-ghost {
            background: #fffc00;
            color: white;
            text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
        }

        .fa-skype {
            background: #00aff0;
            color: white;
        }

        @import url(http://fonts.googleapis.com/css?family=Calibri:400,300,700);





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
            -webkit-box-shadow: 0px 0px 5px 0px rgb(249, 249, 250);
            -moz-box-shadow: 0px 0px 5px 0px rgba(212, 182, 212, 1);
            box-shadow: 0px 0px 5px 0px rgb(161, 163, 164)
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
    </style>

    <link rel="stylesheet" type="text/css" href="dist/css/style.css">

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.3.1/flatly/bootstrap.min.css"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/MultiStep.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/MultiStep-theme.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/MultiStep.min.js"></script>
    <script type="text/javascript">
        <?php if ($user->member == "member") { ?>
            $(document).ready(function() {
                $('.modal').MultiStep({
                    title: 'Complete Your Profile to get Extra offers',
                    data: [{
                        content: `
                <div class="form-group">
                            <label class="control-label">Interest Categories </label>
                            <select name="interest" id="interest" class="form-control auth-form-input" placeholder="" required>
                                <option value="" selected disabled>Select</option>
                                <option value=""></option>
                                <option value=""></option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Are you open to promotions?<a href="#"></a> </label>
                            <br>
                            <input type="radio" id="y1" name="barter" value="Y" required>
                            <label for="y">Yes</label>
                            <input type="radio" id="n1" name="barter" value="N">
                            <label for="n"> No</label>
                        </div>
                `,
                        label: 'Shemes and offers',
                        skip: true
                    }, {
                        content: `
                <div class="form-group">
                            <label class="control-label">Payments Details </label>
                            <input type="text" name="payment" class="form-control auth-form-input" placeholder="Payment">
                        </div>

                        
                `,
                        label: 'Payment Details',
                        skip: true
                    }, {
                        content: `
                <div class="form-group">
                    <label for="exampleInputEmail">Invite friends to join app and get credits for their first successful purchase. 
</label>
                   <br>
<a href="#" class="fa fa-facebook"></a>
<a href="#" class="fa fa-twitter"></a>
<a href="#" class="fa fa-google"></a>
<a href="#" class="fa fa-linkedin"></a>
<a href="#" class="fa fa-youtube"></a>
<a href="#" class="fa fa-instagram"></a>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Promote us on social media for points or discount coupons 
 
</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    
                  </div>
                `,
                        skip: true,
                        label: 'Paid Promotions',
                        skip: true
                    }, {
                        content: `
                <div class="form-group">
                    <label for="exampleInputEmail">Categorise buyer in the database
 
</label>
                    <input type="text" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter email">
                    
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Create custom reports on the identified metrics. 

 
</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    
                  </div>
                `,
                        label: 'Unpaid Promotions',
                        skip: true
                    }],
                    final: 'Profile completed',
                    modalSize: 'lg'
                });
                $('#Modal').modal('show');
            });
        <?php } ?>
    </script>
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
                        <!-- <div id="main_content_wrap" class="outer">
                            <section id="main_content" class="inner">
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#Modal">Open modal</button>
                            </section>
                        </div> -->
                        <div id="Modal" class="multi-step">
                        </div>
                        <!-- <div class="container d-flex justify-content-center">
                            <div class="row">
                                <div class="col-md-6"> <button type="button" class="btn btn-lg btn-warning" data-toggle="modal" data-target="#myModal">Success</button> </div>
                            </div>
                        </div>
                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog">
                                <div class="card">
                                    <div class="text-right cross"> <i class="fa fa-times"></i> </div>
                                    <div class="card-body text-center"> <img src="https://img.icons8.com/bubbles/200/000000/trophy.png">
                                        <h4>CONGRATULATIONS!</h4>
                                        <p>You have won 100 Points in your account</p> <button class="btn btn-out btn-square continue">OK</button>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <?php echo form_open_multipart("update-profile-post", ['id' => 'form_validate']); ?>
                        <div class="form-group">
                            <p>
                                <img src="<?php echo get_user_avatar($user); ?>" alt="<?php echo $user->username; ?>" class="form-avatar" id="test" style="width: 30%;" >
                            </p>
                            <p>
                                <a class='btn btn-md btn-secondary btn-file-upload'>
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
                                    <input type="number" name="user_pincode" id="pincode" class="form-control auth-form-input" placeholder="Pincode" value="<?php echo html_escape($this->auth_user->zip_code); ?>" maxlength="6" minlength="6" onKeyPress="if(this.value.length==6) return false;" required onchange="get_location($('#pincode').val())">
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
                        <!-- <div class="form-group">
                            <label class="control-label"><?php echo trans("username"); ?></label>
                            <input type="text" name="username" class="form-control form-input" value="<?php echo html_escape($user->username); ?>" placeholder="<?php echo trans("username"); ?>" maxlength="<?php echo $this->username_maxlength; ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?php echo trans("slug"); ?></label>
                            <input type="text" name="slug" class="form-control form-input" value="<?php echo html_escape($user->slug); ?>" placeholder="<?php echo trans("slug"); ?>" required>
                        </div> -->

                        <div class="form-group m-t-10">
                            <div class="row">
                                <div class="col-12">
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