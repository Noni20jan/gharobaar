<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {
        opacity: 0.7;
    }

    .row-product-details {
        border-bottom: none;
    }

    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.9);
        /* Black w/ opacity */
    }

    /* Modal Content (image) */
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }


    /* Caption of Modal Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
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
        height: 40px;
        width: 40px;
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
        background: #9faab7;
    }

    .option-input:checked {
        background: #40e0d0;
    }

    .option-input:checked::before {
        height: 40px;
        width: 40px;
        position: absolute;
        content: '✔';
        display: inline-block;
        font-size: 26.66667px;
        text-align: center;
        line-height: 40px;
    }

    .option-input:checked::after {
        -webkit-animation: click-wave 0.65s;
        -moz-animation: click-wave 0.65s;
        animation: click-wave 0.65s;
        background: #40e0d0;
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
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
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

        .background-box {
            background-color: #ffffff78;
            justify-content: center;
            margin: 0px !important;
            padding: 31px;
            border-radius: 20px;
        }

        .email-responsive {
            word-break: break-all;
        }
    }

    .background-box {
        background-color: #ffffff78;
        justify-content: center;
        margin: 0px 15%;
        padding: 31px;
        border-radius: 20px;
    }
</style>
<div id="wrapper">
    <div class="container">
        <h3 class="box-title">Hi , <?php echo html_escape($user->first_name); ?> ! </h3>
        <div class="row background-box m-b-15">
            <!-- <div class="col-sm-12"> -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="text-center">Profile</h3>
                </div><!-- /.box-header -->

                <!-- <div class="box-body"> -->
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <div class="row">
                    <p>
                        <img src="<?php echo get_user_avatar($user); ?>" alt="<?php echo $user->username; ?>" id="test">
                    </p>
                </div>

                <div class="row m-t-10">
                    <div class="col-6">
                        <label class="control-label">Full name</label>
                    </div>
                    <div class="col-6 right">
                        <?php echo html_escape($user->first_name); ?> <?php echo html_escape($user->last_name); ?>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-6">
                        <label class="control-label">Mobile Number</label>
                    </div>
                    <div class="col-6 right">
                        <?php echo html_escape($user->phone_number); ?>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-6">
                        <label class="control-label">Email</label>
                    </div>
                    <div class="col-6 right email-responsive">
                        <?php echo html_escape($user->email); ?>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-6">
                        <label class="control-label">Gender</label>
                    </div>
                    <div class="col-6 right">
                        <?php echo $user->gender; ?>
                    </div>
                </div>
                <center class="m-t-10">
                    <a href="<?php echo generate_url("profile_settings"); ?>" class="btn btn-success">Edit Profile</a>
                </center>

                <!-- </div> -->
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- </div> -->
        </div>
    </div>
</div>


<!-- include send message modal -->
<?php $this->load->view("partials/_modal_send_message", ["subject" => null]); ?>
<?php $this->load->view("partials/_modal_send_review", ["subject" => null]); ?>