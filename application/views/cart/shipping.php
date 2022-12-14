<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script src="<?= base_url(); ?>assets/js/main-1.7.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/progress-tracker.css">
<style>
    .order_summary {
        width: 40% !important;
    }

    .col-lg-5 {
        max-width: 100% !important;
    }

    .checkout-steps .divider {
        display: inline-block;
        border-top: 1px solid #696b79;
        height: 7px;
        width: 10%;
    }

    .address-button {
        background-color: black;
        color: #fff;
    }

    .checkout-steps .active {
        color: #000;
        border-bottom: none;
        font-weight: bold;

    }

    .btn-lg {
        padding: .540rem 1.6rem;
        line-height: 1.5;
        border-radius: 0;
    }

    .btn-custom-new {
        color: black;
        /* border-radius: 20px; */
    }

    .checkout-steps .step {
        display: inline-block;
        letter-spacing: 0px;
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: bold;
        font-size: 20px;
    }

    .shopping-cart {
        margin-top: 10px;
        min-height: 600px;
        padding: 34px;
        border-radius: 33px;
        border: none !important;
    }

    @media (max-width: 768px) {
        .order-summary-container {
            margin-top: 0px !important;

        }

        .order_summary {
            width: 100% !important;
        }

        .btn-lg {
            margin-left: 0% !important;
            width: 100% !important;
            margin-bottom: 10px;
        }

        .checkout-steps .step {
            display: inline-block;
            letter-spacing: 0px !important;
        }

        .addressBlocks-base-radioIcon {
            position: absolute;
            left: 0px !important;
            top: 23px !important;
        }

        .addressBlocks-base-block {
            outline: none;
            padding: 19px 16px 0 20px !important;
            margin-bottom: 14px;
            vertical-align: top;
            position: relative;
            cursor: pointer;
        }

        .svg-fotter {
            position: absolute;
            top: -6%;
            left: 0;
        }

        .shopping-cart {
            padding: 0px;
        }

        .progress-tracker {
            margin: 0px;
            margin-top: 10px !important;
        }
    }

    .home_work_btn {
        background-color: #3cb371 !important;
    }





    .btn-custom {
        font-weight: 600 !important;
    }
</style>
<input type="hidden" id="role" value="<?php echo $this->auth_user->user_type; ?>">
<!-- ------------------MODAL---------------------- -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-primary" style="float:right ; outline: none;background-color: black;float: right;color: white;font-weight: bolder; border-radius: 20px;" data-dismiss="modal">Close</button>
                <h4 class="modal-title">Add New Address</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" id="shipping_address_additional">
                    <div class="row">
                        <div class="col-12 cart-form-shipping-address summary-section personal-details">
                            <p class="font-shipping">Contact Details</p>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-md-6 m-b-sm-15">
                                        <label><?php echo trans("first_name"); ?>*</label>
                                        <input type="text" name="shipping_first_name" id="pop_name" class="form-control form-input" required>
                                        <span class="Validation_error" id="fname_valid" style="color: #d43f3a;"></span>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label><?php echo trans("last_name"); ?>*</label>
                                        <input type="text" name="shipping_last_name" id="pop_lname" class="form-control form-input" required>
                                        <span class="Validation_error" id="lname_valid" style="color: #d43f3a;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-md-6 m-b-sm-15">
                                        <label><?php echo trans("email"); ?>*</label>
                                        <input type="email" name="shipping_email" id="pop_email" class="form-control form-inpu" value="<?php echo $this->auth_user->email; ?>" required>
                                        <span class="Validation_error" id="email_valid" style="color: #d43f3a;"></span>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label><?php echo trans("phone_number"); ?>*</label>
                                        <input type="text" name="shipping_phone_number" id="pop_number" onkeyup="return(event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" class="form-control form-input" minlength="10" maxlength="10" value="<?php echo $this->auth_user->phone_number; ?>" required>
                                        <span class="Validation_error" id="number_valid" style="color: #d43f3a;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 cart-form-shipping-address summary-section personal-details">
                            <p class="font-shipping">Address</p>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label><?php echo trans("zip_code"); ?>*</label>
                                        <input type="text" name="shipping_zip_code" id="zipcode" class="form-control form-input" minlength="6" maxlength="6" required onkeyup="get_location($( '#zipcode').val())">
                                        <span class="Validation_error" id="pincode_valid" style="color: #d43f3a;"></span>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label><?php echo trans("state"); ?>*</label>
                                        <input type="text" name="shipping_state" id="shipping_state" class="form-control form-input" placeholder="Shipping state" required readonly>
                                        <span class="Validation_error" id="state_valid" style="color: #d43f3a;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-md-6 m-b-sm-15">
                                        <label><?php echo trans("city"); ?>*</label>
                                        <input type="text" name="shipping_city" id="shipping_city" class="form-control form-input" placeholder="Shipping city" readonly required>
                                        <span class="Validation_error" id="city_valid" style="color: #d43f3a;"></span>
                                    </div>
                                    <div class="col-12 col-md-6 m-b-sm-15">
                                        <label>Area *</label>
                                        <input type="text" name="shipping_area" id="shipping_area" class="form-control form-input" placeholder="Shipping state" required>
                                        <span class="Validation_error" id="area_valid" style="color: #d43f3a;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-md-6 m-b-sm-15">
                                        <label>House no./Building no./Area *
                                        </label>
                                        <input type="text" name="shipping_address_1" id="shipping_address" class="form-control form-input" placeholder="House no./Building no./Area" required>
                                        <span class="Validation_error" id="address_valid" style="color: #d43f3a;"></span>
                                        <!-- <p class="Validation_error" id="house_no_p"></p> -->

                                    </div>
                                    <div class="col-12 col-md-6 m-b-sm-15">
                                        <label><?php echo trans("land_mark"); ?></label>
                                        <input type="text" name="shipping_landmark" id="shipping_landmark" class="form-control form-input" placeholder="Landmark">
                                        <!-- <p class="Validation_error" id="landmark_p"></p> -->
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12 text-center" style="text-align: center;">
                                        <p>Save Address As</p>
                                    </div>
                                    <div class="radio-toolbar text-center col-sm-12">

                                        <!-- <div class="col-sm-6"> -->
                                        <input type="radio" class="home_work_btn" id="radioApple" name="address_type" value="HOME" checked>
                                        <label for="radioApple">HOME</label>
                                        <!-- </div> -->
                                        <!-- <div class="col-sm-6"> -->
                                        <input type="radio" id="radioBanana" name="address_type" value="WORK">
                                        <label for="radioBanana">WORK</label>
                                        <!-- </div> -->

                                    </div>
                                    <div class="text-center col-sm-12" style="margin-top: 3%;">
                                        <button type="submit" id="address-button" onclick="addAddress1()" class="btn btn-lg btn-custom">Save Address</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>


            </div>

        </div>

    </div>
</div>
<!-- -------------------------------EDIT MODAL----------------------------- -->
<div class="modal fade" id="edit-modal" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-primary" style="float:right ; outline: none;background-color: black;float: right;color: white;font-weight: bolder; border-radius: 20px;" data-dismiss="modal">Close</button>
                <h4 class="modal-title">Edit Address</h4>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" id="shipping_address_edit">
                    <div class="row">
                        <div class="col-12 cart-form-shipping-address summary-section personal-details">
                            <p class="font-shipping">Contact Details</p>
                            <input type="hidden" id="modal_id" name="shipping_add_id" class="form-control form-input" required>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-md-6 m-b-sm-15">
                                        <label><?php echo trans("first_name"); ?>*</label>
                                        <input type="text" id="modal_f_name" name="shipping_first_name" class="form-control form-input" required>
                                        <span class="Validation_error" id="fname_validate" style="color: #d43f3a;"></span>

                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label><?php echo trans("last_name"); ?>*</label>
                                        <input type="text" id="modal_l_name" name="shipping_last_name" class="form-control form-input" required>
                                        <span class="Validation_error" id="lname_validate" style="color: #d43f3a;"></span>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-md-6 m-b-sm-15">
                                        <label><?php echo trans("email"); ?>*</label>
                                        <input type="email" name="shipping_email" id="modal_email_id" class="form-control form-input" required>
                                        <span class="Validation_error" id="email_validate" style="color: #d43f3a;"></span>

                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label><?php echo trans("phone_number"); ?>*</label>
                                        <input type="text" name="shipping_phone_number" id="modal_mobile_no" onkeyup="return(event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" class="form-control form-input" minlength="10" maxlength="10" required>

                                        <span class="Validation_error" id="number_validate" style="color: #d43f3a;"></span>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 cart-form-shipping-address summary-section personal-details">
                            <p class="font-shipping">Address</p>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label><?php echo trans("zip_code"); ?>*</label>
                                        <input type="text" name="shipping_zip_code" id="modal_zipcode" class="form-control form-input" minlength="6" maxlength="6" required onkeyup="get_location2($( '#modal_zipcode').val())">
                                        <span class="Validation_error" id="pincode_validate" style="color: #d43f3a;"></span>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label><?php echo trans("state"); ?>*</label>
                                        <input type="text" name="shipping_state" id="modal_shipping_state" class="form-control form-input" placeholder="Shipping state" required readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-md-6 m-b-sm-15">
                                        <label><?php echo trans("city"); ?>*</label>
                                        <input type="text" name="shipping_city" id="modal_shipping_city" class="form-control form-input" placeholder="Shipping city" readonly required>
                                        <span class="Validation_error" id="city_validate" style="color: #d43f3a;"></span>

                                    </div>
                                    <div class="col-12 col-md-6 m-b-sm-15">
                                        <label>Area *</label>
                                        <input type="text" name="shipping_area" id="modal_shipping_area" class="form-control form-input" placeholder="Shipping state" required>
                                        <span class="Validation_error" id="area_validate" style="color: #d43f3a;"></span>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-md-6 m-b-sm-15">
                                        <label>House no./Building no./Area *
                                        </label>
                                        <input type="text" name="shipping_address_1" id="modal_shipping_address" class="form-control form-input" placeholder="House no./Building no./Area" required>
                                        <!-- <p class="Validation_error" id="house_no_p"></p> -->
                                        <span class="Validation_error" id="address_validate" style="color: #d43f3a;"></span>


                                    </div>
                                    <div class="col-12 col-md-6 m-b-sm-15">
                                        <label><?php echo trans("land_mark"); ?></label>
                                        <input type="text" name="shipping_landmark" id="modal_shipping_landmark" class="form-control form-input" placeholder="Landmark">
                                        <!-- <p class="Validation_error" id="landmark_p"></p> -->
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12 text-center" style="text-align: center;">
                                        <p>Save Address As</p>
                                    </div>

                                    <div class="radio-toolbar text-center row" style="margin-left: 30%;">
                                        <div class="col-sm-6" required>
                                            <input type="radio" id="radioApple1" name="address_type_modal" value="HOME">
                                            <label for="radioApple1">HOME</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="radio" id="radioBanana1" name="address_type_modal" value="WORK">
                                            <label for="radioBanana1">WORK</label>
                                        </div>
                                    </div>

                                    <div class="text-center col-sm-12" style="margin-top: 3%;">
                                        <button type="button" id="address-button" onclick="editAddress()" class="btn btn-lg btn-custom" style="background-color:black;color:#fff;">Save Address</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>


            </div>

        </div>

    </div>
</div>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <!-- <div class="row text-center">
            <ol class="checkout-steps summary-section" style="padding: 1%;">
                <li class="step step2 ">Cart</li>
                <li class="divider"></li>
                <li class="step step1 active">Address</li>
                <li class="divider"></li>
                <li class="step step3">Payment</li>

            </ol>
        </div> -->
        <div class="fullwidth">
            <div class="container separator">
                <ul class="progress-tracker progress-tracker--text progress-tracker--center">
                    <li class="progress-step is-active">
                        <div class="progress-marker"></div>
                        <div class="progress-text">
                            <h6 class="progress-title">Cart</h6>
                        </div>
                    </li>
                    <li class="progress-step">
                        <div class="progress-marker">
                            <div class="abc" style="border-color:white ;"></div>
                        </div>
                        <div class="progress-text">
                            <h6 class="progress-title">Address</h6>
                        </div>
                    </li>
                    <li class="progress-step">
                        <div class="progress-marker"></div>
                        <div class="progress-text">
                            <h6 class="progress-title">Payment</h6>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">

            <div class="col-12 background-shipping">
                <div class="shopping-cart shopping-cart-shipping">

                    <div class="row">
                        <div class="col-sm-12 col-lg-7">
                            <div class="left">
                                <h1 class="cart-section-title"><?php echo trans("checkout"); ?></h1>

                                <?php if (!$this->auth_check) : ?>
                                    <div class="row m-b-15">
                                        <div class="col-12 col-md-6">
                                            <p><?php echo trans("checking_out_as_guest"); ?></p>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <p class="text-right"><?php echo trans("have_account"); ?>&nbsp;<a href="javascript:void(0)" class="link-underlined" data-toggle="modal" data-target="#loginModal"><?php echo trans("login"); ?></a></p>
                                        </div>
                                    </div>

                                <?php endif; ?>
                                <!-- <div class="offers-container">
                                    <div class="col-sm-12"><b>Available Offers</b> <img src="assets/img/percent.png" width="23" height="23">
                                        <p></p>
                                        <?php
                                        foreach ($offer as $row) {
                                        ?>
                                            <p style="font-size:13px;"><?php echo $row->offers_name; ?></p>
                                        <?php }
                                        ?>
                                        <p style="font-size:13px;">10% Instant discount on HDFC credit cards on a minimum spend of 3000/- TCA</p>
                                        <p class="coupons"><span class="float-right"><a href="#" style="color: red;">Show more</a></span></p>
                                    </div>
                                </div> -->

                                <!-- <div class="offers-container">
                                        <div class="col-sm-12"><b>Write Your message here -</b> <img src="assets/img/percent.png" width="23" height="23">
                                            <p></p>
                                            <div class="form-group">
                                                <textarea class="form-control" rows="5" id="comment" name="comment" placeholder="Write Your message here"></textarea>
                                                
                                            </div>
                                        </div>
                                    </div> -->

                                <div class="tab-checkout tab-checkout-open m-t-0">
                                    <h2 class="title">1.&nbsp;&nbsp;<?php echo trans("shipping_information"); ?></h2>
                                    <?php if (empty($get_address)) : ?>
                                        <form method="POST" enctype="multipart/form-data" id="shipping_address_default">
                                            <div class="row">
                                                <div class="col-12 cart-form-shipping-address summary-section personal-details">
                                                    <p class="font-shipping">Contact Details</p>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 m-b-sm-15">
                                                                <label><?php echo trans("first_name"); ?>*</label>
                                                                <?php if (empty($shipping_address->shipping_first_name)) : ?>
                                                                    <input type="text" name="shipping_first_name" id="login_fname" class="form-control form-input" value="<?php echo ($this->auth_user->first_name); ?>" required>
                                                                <?php else : ?>
                                                                    <input type="text" name="shipping_first_name" id="login_fname" class="form-control form-input" value="<?php echo $shipping_address->shipping_first_name; ?>" required>
                                                                <?php endif; ?>
                                                                <span class="Validation_error" id="fname_login" style="color: #d43f3a;"></span>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <label><?php echo trans("last_name"); ?>*</label>
                                                                <?php if (empty($shipping_address->shipping_last_name)) : ?>
                                                                    <input type="text" name="shipping_last_name" id="login_lname" class="form-control form-input" value="<?php echo $this->auth_user->last_name; ?>" required>
                                                                <?php else : ?>
                                                                    <input type="text" name="shipping_last_name" id="login_lname" class="form-control form-input" value="<?php echo $shipping_address->shipping_last_name; ?>" required>
                                                                <?php endif; ?>
                                                                <span class="Validation_error" id="lname_login" style="color: #d43f3a;"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 m-b-sm-15">
                                                                <label><?php echo trans("email"); ?>*</label>
                                                                <?php if (empty($shipping_address->shipping_email)) : ?>
                                                                    <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="shipping_email" id="login_email" class="form-control form-input" value="<?php echo $this->auth_user->email; ?>" required>
                                                                <?php else : ?>
                                                                    <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="shipping_email" id="login_email" class="form-control form-input" value="<?php echo $shipping_address->shipping_email; ?>" required>
                                                                <?php endif; ?>
                                                                <span class="Validation_error" id="email_login" style="color: #d43f3a;"></span>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <label><?php echo trans("phone_number"); ?>*</label>

                                                                <?php if (empty($shipping_address->shipping_phone_number)) : ?>
                                                                    <?php if ($this->auth_user->user_type != "guest") : ?>
                                                                        <input type="text" name="shipping_phone_number" onkeypress="return(event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" id="login_number" class="form-control form-input" value="<?php echo $this->auth_user->phone_number; ?>" minlength="10" maxlength="10" required>
                                                                    <?php else : ?>
                                                                        <input type="text" name="shipping_phone_number" onkeypress="return(event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" id="login_number" class="form-control form-input" value="" minlength="10" maxlength="10" required>

                                                                    <?php endif; ?>
                                                                <?php else : ?>
                                                                    <input type="text" name="shipping_phone_number" onkeypress="return(event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" id="login_number" class="form-control form-input" value="<?php echo $shipping_address->shipping_phone_number; ?>" minlength="10" maxlength="10" required>
                                                                <?php endif; ?>
                                                                <span class="Validation_error" id="number_login" style="color: #d43f3a;"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="col-12 cart-form-shipping-address summary-section personal-details">
                                                    <p class="font-shipping">Address</p>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <label><?php echo trans("zip_code"); ?>*</label>
                                                                <input type="text" name="shipping_zip_code" id="shipping_zip_code" class="form-control form-input" value="<?php echo $shipping_address->shipping_zip_code; ?>" minlength="6" maxlength="6" onKeyPress="if(this.value.length==6) return false;" required onkeyup="get_location3($( '#shipping_zip_code').val())">
                                                                <!-- <p class="Validation_error" id="zipcode_p"></p> -->
                                                                <span class="Validation_error" id="pincode_span" style="color: #d43f3a;"></span>
                                                            </div>
                                                            <!-- <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label><?php echo trans("country"); ?>*</label>
                                                        <select id="countries" name="shipping_country_id" class="form-control custom-select" required>
                                                            <option value="" selected><?php echo trans("select_country"); ?></option>
                                                            <?php foreach ($this->countries as $item) : ?>
                                                                <option value="<?php echo $item->id; ?>" <?php echo ($shipping_address->shipping_country_id == $item->id) ? 'selected' : ''; ?>><?php echo html_escape($item->name); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div> -->
                                                            <div class="col-12 col-md-6">
                                                                <label><?php echo trans("state"); ?>*</label>
                                                                <input type="text" name="shipping_state" id="shipping_state_login" class="form-control form-input" placeholder="Shipping state" value="<?php echo $shipping_address->shipping_state; ?>" required>
                                                                <span class="Validation_error" id="state_login" style="color: #d43f3a;"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 m-b-sm-15">
                                                                <label><?php echo trans("city"); ?>*</label>
                                                                <input type="text" name="shipping_city" id="shipping_city_login" class="form-control form-input" placeholder="Shipping city" value="<?php echo $shipping_address->shipping_city; ?>" required>
                                                                <span class="Validation_error" id="city_login" style="color: #d43f3a;"></span>
                                                            </div>
                                                            <div class="col-12 col-md-6 m-b-sm-15">
                                                                <label>Area *</label>
                                                                <input type="text" name="shipping_area" id="shipping_area_login" class="form-control form-input" placeholder="Shipping state" value="<?php echo $shipping_address->shipping_area; ?>" required>
                                                                <span class="Validation_error" id="area_login" style="color: #d43f3a;"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 m-b-sm-15">
                                                                <label>House no./Building no./Area *
                                                                </label>
                                                                <input type="text" name="shipping_address_1" id="shipping_address_login" class="form-control form-input" placeholder="House no./Building no./Area" value="<?php echo $shipping_address->shipping_address_1; ?>" required>
                                                                <span class="Validation_error" id="address1_login" style="color: #d43f3a;"></span>
                                                                <!-- <p class="Validation_error" id="house_no_p"></p> -->

                                                            </div>
                                                            <div class="col-12 col-md-6 m-b-sm-15">
                                                                <label><?php echo trans("land_mark"); ?></label>
                                                                <input type="text" name="shipping_landmark" id="shipping_landmark_login" class="form-control form-input" placeholder="Landmark" value="<?php echo $shipping_address->shipping_landmark; ?>">
                                                                <!-- <p class="Validation_error" id="landmark_p"></p> -->
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-12 text-center" style="text-align: center;">
                                                                <p>Save Address As</p>
                                                            </div>

                                                            <div class="radio-toolbar text-center col-sm-12">
                                                                <input type="radio" id="radioApple2" name="address_type" value="HOME" checked>
                                                                <label for="radioApple2">HOME</label>

                                                                <input type="radio" id="radioBanana2" name="address_type" value="WORK">
                                                                <label for="radioBanana2">WORK</label>


                                                            </div>
                                                            <div class="text-center col-sm-12" style="margin-top: 3%;">
                                                                <button type="button" id="address-button-login" onclick="addAdress()" class="btn btn-lg btn-custom">Save Address</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    <?php else : ?>
                                        <div class="row">

                                            <?php foreach ($get_address as $address) : ?>
                                                <?php if ($address->is_active == "1") : ?>
                                                    <div class="col-12 cart-form-shipping-address summary-section personal-details">
                                                        <div class="addressBlocks-base-block addressBlocks-base-serviceable" id="82517434" data-action="select">
                                                            <input type="radio" name="select-address" onchange="change_address('<?php echo $address->f_name; ?>','<?php echo $address->l_name; ?>','<?php echo $address->address_type; ?>','<?php echo $address->h_no; ?>','<?php echo $address->landmark; ?>','<?php echo $address->area; ?>','<?php echo $address->city; ?>','<?php echo $address->state; ?>','<?php echo $address->zip_code; ?>','<?php echo $address->ph_number; ?>','<?php echo $address->email; ?>')" id="select-address" width="20" height="20" viewBox="0 0 20 20" class="addressBlocks-base-radioIcon" checked="checked" required>

                                                            </input>
                                                            <div>
                                                                <div>
                                                                    <div class="addressDetails-base-desktopAddressTitle">
                                                                        <div class="addressDetails-base-name"><?php echo $address->f_name . " " . $address->l_name; ?></div>
                                                                        <div class="addressDetails-base-addressType"><?php echo $address->address_type; ?></div>
                                                                    </div>
                                                                    <?php if (!empty($address->landmark)) : ?>
                                                                        <div class="addressDetails-base-addressField addressBlocks-base-addressDetail"><?php echo $address->h_no . ", " . $address->landmark . ", " . $address->area . ", " . $address->city . ", " . $address->state . ", " . $address->zip_code; ?></div>
                                                                    <?php else : ?>
                                                                        <div class="addressDetails-base-addressField addressBlocks-base-addressDetail"><?php echo $address->h_no . " " . $address->landmark . ", " . $address->area . ", " . $address->city . ", " . $address->state . ", " . $address->zip_code; ?></div>
                                                                    <?php endif; ?>

                                                                </div>
                                                                <div class="addressDetails-base-mobile"><span>Mobile: </span><span><?php echo $address->ph_number; ?></span></div>
                                                                <div class="addressDetails-base-mobile"><span>Email: </span><span><?php echo $address->email; ?></span></div>

                                                            </div>


                                                            <div class="addressBlocks-base-btns"><a href="javascript:void(0)" onclick="delete_item('cart_controller/delete_address','<?php echo $address->id; ?>','Are you sure you want to delete this address?');"><button class="addressBlocks-base-remove" data-action="remove">Remove</button></a><button class="addressBlocks-base-edit" onclick="edit('<?php echo $address->id; ?>','<?php echo $address->f_name; ?>','<?php echo $address->l_name; ?>','<?php echo $address->address_type; ?>','<?php echo $address->h_no; ?>','<?php echo $address->landmark; ?>','<?php echo $address->area; ?>','<?php echo $address->city; ?>','<?php echo $address->state; ?>','<?php echo $address->zip_code; ?>','<?php echo $address->ph_number; ?>','<?php echo $address->email; ?>')" data-action="showModal">Edit</button></div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 cart-form-shipping-address text-center">
                                                <button type="button" name="select-address" class="btn btn-custom btn-lg" onclick="show()" id="select-address_new" width="16" height="16" viewBox="0 0 16 16" value="0"><i class="glyphicon glyphicon-plus"></i>Add New Address</button>
                                            </div>
                                            <?php echo form_open("", ['name' => 'hidden_ship_fields', 'id' => 'form_validate']); ?>

                                            <div class="col-12 cart-form-shipping-address div-hide">

                                                <p class="font-shipping">Contact Details</p>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6 m-b-sm-15">
                                                            <label><?php echo trans("first_name"); ?>*</label>
                                                            <input type="text" name="shipping_first_name" id="f_name" class="form-control form-input" value="<?php echo $shipping_address->shipping_first_name; ?>" required>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label><?php echo trans("last_name"); ?>*</label>
                                                            <input type="text" name="shipping_last_name" id="l_name" class="form-control form-input" value="<?php echo $shipping_address->shipping_last_name; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6 m-b-sm-15">
                                                            <label><?php echo trans("email"); ?>*</label>
                                                            <input type="email" name="shipping_email" id="email_id" class="form-control form-input" value="<?php echo $shipping_address->shipping_email; ?>" required>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label><?php echo trans("phone_number"); ?>*</label>
                                                            <input type="text" name="shipping_phone_number" onkeypress="return(event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" id="mobile_no" class="form-control form-input" value="<?php echo $shipping_address->shipping_phone_number; ?>" minlength="10" maxlength="10" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- <div class="form-group">
                                                <label><?php echo trans("address_2"); ?> (<?php echo trans("optional"); ?>)</label>
                                                <input type="text" name="shipping_address_2" class="form-control form-input" value="<?php echo $shipping_address->shipping_address_2; ?>">
                                            </div> -->
                                            <div class="col-12 cart-form-shipping-address div-hide">

                                                <p class="font-shipping">Address</p>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6">
                                                            <label><?php echo trans("zip_code"); ?>*</label>
                                                            <input type="text" name="shipping_zip_code" id="zipcode_val" class="form-control form-input" value="<?php echo $shipping_address->shipping_zip_code; ?>" minlength="6" maxlength="6" onKeyPress="if(this.value.length==6) return false;" required onkeyup="get_location($( '#zipcode').val())">
                                                            <!-- <p class="Validation_error" id="zipcode_p"></p> -->
                                                            <span class="Validation_error" id="pincode_span" style="color: #d43f3a;"></span>
                                                        </div>
                                                        <!-- <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label><?php echo trans("country"); ?>*</label>
                                                        <select id="countries" name="shipping_country_id" class="form-control custom-select" required>
                                                            <option value="" selected><?php echo trans("select_country"); ?></option>
                                                            <?php foreach ($this->countries as $item) : ?>
                                                                <option value="<?php echo $item->id; ?>" <?php echo ($shipping_address->shipping_country_id == $item->id) ? 'selected' : ''; ?>><?php echo html_escape($item->name); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div> -->
                                                        <div class="col-12 col-md-6">
                                                            <label><?php echo trans("state"); ?>*</label>
                                                            <input type="text" name="shipping_state" id="shipping_state_val" class="form-control form-input" placeholder="Shipping state" value="<?php echo $shipping_address->shipping_state; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6 m-b-sm-15">
                                                            <label><?php echo trans("city"); ?>*</label>
                                                            <input type="text" name="shipping_city" id="shipping_city_val" class="form-control form-input" placeholder="Shipping city" value="<?php echo $shipping_address->shipping_city; ?>" required>
                                                        </div>
                                                        <div class="col-12 col-md-6 m-b-sm-15">
                                                            <label>Area *</label>
                                                            <input type="text" name="shipping_area" id="shipping_area_val" class="form-control form-input" placeholder="Shipping state" value="<?php echo $shipping_address->shipping_area; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12 col-md-6 m-b-sm-15">
                                                            <label>House no./Building no./Area *
                                                            </label>
                                                            <input type="text" name="shipping_address_1" id="shipping_address_val" class="form-control form-input" placeholder="House no./Building no./Area" value="<?php echo $shipping_address->shipping_address_1; ?>" required>
                                                            <!-- <p class="Validation_error" id="house_no_p"></p> -->

                                                        </div>
                                                        <div class="col-12 col-md-6 m-b-sm-15">
                                                            <label><?php echo trans("land_mark"); ?></label>
                                                            <input type="text" name="shipping_landmark" id="shipping_landmark_val" class="form-control form-input" placeholder="Landmark" value="<?php echo $shipping_address->shipping_landmark; ?>">
                                                            <!-- <p class="Validation_error" id="landmark_p"></p> -->
                                                        </div>

                                                    </div>
                                                    <div class="text-center col-sm-12" style="margin-top: 3%;">

                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-12 text-center" style="text-align: center;">
                                                            <p>Save Address As</p>
                                                        </div>

                                                        <div class="radio-toolbar text-center col-sm-12">
                                                            <input type="radio" id="radioApple" name="address_type_val" value="HOME" checked>
                                                            <label class="home_work_btn" for="radioApple">HOME</label>

                                                            <input type="radio" id="radioBanana" name="address_type_val" value="WORK">
                                                            <label for="radioBanana">WORK</label>


                                                        </div>
                                                        <!-- <div class="text-center col-sm-12" style="margin-top: 3%;">
                                                                <button type="button" name="submit" value="update" class="btn btn-lg btn-custom">Save Address</button>
                                                            </div> -->

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 cart-form-billing-address" <?php echo ($shipping_address->use_same_address_for_billing == 0) ? 'style="display: block;"' : ''; ?>>
                                                <h3 class="title-billing-address"><?php echo trans("billing_address") ?></h3>
                                                <div class="row">
                                                    <div class="col-12 cart-form-shipping-address summary-section" style="margin-bottom: 2%;">
                                                        <p class="font-shipping">Contact Details</p>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6 m-b-sm-15">
                                                                    <label><?php echo trans("first_name"); ?>*</label>
                                                                    <input type="text" id="billing_name" name="billing_first_name" class="form-control form-input" required onkeyup="check_fname()">
                                                                    <p class="Validation_error" id="fname_p"></p>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <label><?php echo trans("last_name"); ?>*</label>
                                                                    <input type="text" id="last_name" name="billing_last_name" class="form-control form-input" required onkeyup="check_lname()">
                                                                    <p class="Validation_error" id="lname_p"></p>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6 m-b-sm-15">
                                                                    <label><?php echo trans("email"); ?>*</label>
                                                                    <input type="text" id="bill_email" name="billing_email" class="form-control form-input" required onkeyup="check_email()">
                                                                    <p class="Validation_error" id="email_p"></p>

                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <label><?php echo trans("phone_number"); ?>*</label>
                                                                    <input type="number" id="bill_mobile" name="billing_phone_number" class="form-control form-input" onkeyup="check_mobile()" required>
                                                                    <p class="Validation_error" id="mobile_p"></p>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 cart-form-shipping-address summary-section">
                                                        <p class="font-shipping">Address</p>
                                                        <div class="form-group">
                                                            <div class="row">

                                                                <div class="col-12 col-md-6">
                                                                    <label><?php echo trans("zip_code"); ?>*</label>
                                                                    <input type="number" name="billing_zip_code" id="billing_zip_code" class="form-control form-input" required minlength="6" maxlength="6" onKeyPress="if(this.value.length==6) return false;" required onkeyup="get_location1($( '#billing_zip_code').val())">
                                                                    <span class="Validation_error" id="pincode_span1" style="color: #d43f3a;"></span>
                                                                </div>
                                                                <!-- <div class="col-12 col-md-6 m-b-sm-15">
                                                        <label><?php echo trans("country"); ?>*</label>
                                                        <select id="countries" name="billing_country_id" class="form-control custom-select" required>
                                                            <option value="" selected><?php echo trans("select_country"); ?></option>
                                                            <?php foreach ($this->countries as $item) : ?>
                                                                <option value="<?php echo $item->id; ?>" <?php echo ($shipping_address->billing_country_id == $item->id) ? 'selected' : ''; ?>><?php echo html_escape($item->name); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div> -->
                                                                <div class="col-12 col-md-6">
                                                                    <label><?php echo trans("state"); ?>*</label>
                                                                    <input type="text" name="billing_state" id="billing_state" class="form-control form-input" readonly required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6 m-b-sm-15">
                                                                    <label><?php echo trans("city"); ?>*</label>
                                                                    <input type="text" name="billing_city" id="billing_city" class="form-control form-input" readonly required>
                                                                </div>
                                                                <div class="col-12 col-md-6 m-b-sm-15">
                                                                    <label>Area *</label>
                                                                    <input type="text" name="billing_area" id="billing_area" class="form-control form-input" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6 m-b-sm-15">
                                                                    <label>House no./Building no./Area *</label>
                                                                    <input type="text" name="billing_address_1" class="form-control form-input" required>
                                                                </div>
                                                                <div class="col-12 col-md-6 m-b-sm-15">
                                                                    <label>Landmark</label>
                                                                    <input type="text" name="billing_landmark" class="form-control form-input">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 ">
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="use_same_address_for_billing" value="1" id="use_same_address_for_billing" <?php echo ($shipping_address->use_same_address_for_billing == 1) ? 'checked' : ''; ?>>
                                                        <label for="use_same_address_for_billing" class="custom-control-label"><?php echo trans("use_same_address_for_billing"); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group m-t-15" id="paymentMethodButtonDiv">
                                    <a href="<?php echo generate_url("cart"); ?>" class="btn btn-lg btn-custom" style="  text-decoration: underline;">
                                        <&nbsp;<?php echo trans("return_to_cart"); ?> </a>
                                            <?php if ($cart_total->total_price != 0) : ?>
                                                <button type="submit" id="payment_button" name="submit" value="update" class="btn btn-lg btn-custom" id="payment" <?php echo (empty($get_address)) ? "disabled" : "" ?>><?php echo trans("continue_to_payment_method") ?></button>
                                            <?php else : ?>
                                                <button type="submit" id="payment_button" name="submit" value="update" class="btn btn-lg btn-custom" id="payment" <?php echo (empty($get_address)) ? "disabled" : "" ?>><?php echo trans("place_order") ?></button>
                                            <?php endif; ?>
                                </div>
                                <?php echo form_close(); ?>
                                <!-- hidden form end to store the shipping and billing data -->

                                <!-- paymemt section start -->
                                <div class="col-12" id='load_payment_page'>
                                    <div class="tab-checkout tab-checkout-closed-bordered">
                                        <h2 class="title">2.&nbsp;&nbsp;<?php echo trans("payment_method"); ?></h2>
                                    </div>

                                    <div class="tab-checkout tab-checkout-closed-bordered border-top-0">
                                        <h2 class="title">3.&nbsp;&nbsp;<?php echo trans("payment"); ?></h2>
                                    </div>
                                </div>
                                <!-- paymemt section end -->
                            </div>
                            <div id="load_payment_page1"></div>

                        </div>
                        <?php if ($mds_payment_type == 'promote') {
                            $this->load->view("cart/_order_summary_promote");
                        } else {
                        ?>
                            <div class="order_summary" id="order_summary">
                                <?php
                                $this->load->view("cart/_order_summary"); ?>
                            </div>
                        <?php
                        } ?>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- Wrapper End-->

<script>
    // function get_additional_info(){
    //     var info = $("textarea[name=comment]").val();
    //     // console.log(info);
    //     sessionStorage.setItem("info",info);
    //     // console.log(sessionStorage.getItem("info"));
    // }

    function get_location(pincode) {

        document.getElementById('shipping_state').value = "";
        document.getElementById('shipping_city').value = "";
        document.getElementById('shipping_area').value = "";
        document.getElementById('shipping_address').value = "";
        document.getElementById('shipping_landmark').value = "";

        var url = "https://api.postalpincode.in/pincode/" + pincode;
        $.ajax({
            url: url,
            cache: false,
            success: function(html) {
                if (html[0].PostOffice == null) {
                    $('#pincode_span')[0].innerHTML = "Please enter a valid pincode.";
                } else {
                    $('#pincode_span')[0].innerHTML = "";

                    $('#shipping_state').val(html[0].PostOffice[0].State)
                    $('#shipping_city').val(html[0].PostOffice[0].District)
                    $('#shipping_area').val(html[0].PostOffice[0].Name)
                }
            }
        })
    }

    function get_location1(pincode) {
        $('input[name^="bill"]').prop('required', true);
        document.getElementById('billing_state').value = "";
        document.getElementById('billing_city').value = "";
        document.getElementById('billing_area').value = "";

        var url = "https://api.postalpincode.in/pincode/" + pincode;
        $.ajax({
            url: url,
            cache: false,
            success: function(html) {
                if (html[0].PostOffice == null) {
                    $('#pincode_span1')[0].innerHTML = "Please enter a valid pincode.";
                } else {
                    $('#pincode_span1')[0].innerHTML = "";

                    $('#billing_state').val(html[0].PostOffice[0].State)
                    $('#billing_city').val(html[0].PostOffice[0].District)
                    $('#billing_area').val(html[0].PostOffice[0].Name)
                }
            }
        })
    }

    function get_location2(pincode) {

        document.getElementById('modal_shipping_state').value = "";
        document.getElementById('modal_shipping_city').value = "";
        document.getElementById('modal_shipping_area').value = "";
        document.getElementById('modal_shipping_address').value = "";
        document.getElementById('modal_shipping_landmark').value = "";

        var url = "https://api.postalpincode.in/pincode/" + pincode;
        $.ajax({
            url: url,
            cache: false,
            success: function(html) {
                if (html[0].PostOffice == null) {
                    $('#pincode_span')[0].innerHTML = "Please enter a valid pincode.";
                } else {
                    $('#pincode_span')[0].innerHTML = "";

                    $('#modal_shipping_state').val(html[0].PostOffice[0].State)
                    $('#modal_shipping_city').val(html[0].PostOffice[0].District)
                    $('#modal_shipping_area').val(html[0].PostOffice[0].Name)
                }
            }
        })
    }

    function get_location3(pincode) {

        document.getElementById('shipping_state_login').value = "";
        document.getElementById('shipping_city_login').value = "";
        document.getElementById('shipping_area_login').value = "";
        document.getElementById('shipping_address_login').value = "";
        document.getElementById('shipping_landmark_login').value = "";

        var url = "https://api.postalpincode.in/pincode/" + pincode;
        $.ajax({
            url: url,
            cache: false,
            success: function(html) {
                if (html[0].PostOffice == null) {
                    $('#pincode_span')[0].innerHTML = "Please enter a valid pincode.";
                } else {
                    $('#pincode_span')[0].innerHTML = "";

                    $('#shipping_state_login').val(html[0].PostOffice[0].State)
                    $('#shipping_city_login').val(html[0].PostOffice[0].District)
                    $('#shipping_area_login').val(html[0].PostOffice[0].Name)
                }
            }
        })
    }
</script>


<script>
    function show() {

        $("#myModal").modal("show");

    }
</script>
<script>
    // $('.cart-form-billing-address').on("click", function() {
    //     $('input[name^="bill"]').prop('required', true);
    // })
    $(document).ready(function() {
        $('#payment_mode').val($("#online_mode a").attr("datavalue"));
        $('input[name^="bill"]').prop('required', false);
        $("#login_number").on("blur", function() {
            var mobNum = $(this).val();
            var filter = /[1-9]{1}[0-9]{9}/;


            if (filter.test(mobNum)) {

                if (mobNum.length == 10) {
                    $("#number_login")[0].innerHTML = "Valid";
                    $("#number_login").css({
                        'color': 'green'
                    });;
                    $('#login_number').css({
                        'borderColor': 'green'
                    });

                } else {
                    $("#number_login")[0].innerHTML = "Enter 10 digit Number"
                    $('#login_number').css({
                        'borderColor': 'red'
                    });
                    return false;
                }
            } else {
                $("#number_login")[0].innerHTML = "Invalid Number"
                $('#login_number').css({
                    'borderColor': 'red'

                });
                $("#number_login").css({
                    'color': 'red'
                });;
                return false;
            }

        });
        $("modal_mobile_no").on("blur", function() {
            var mobNum = $(this).val();
            var filter = /[1-9]{1}[0-9]{9}/;


            if (filter.test(mobNum)) {

                if (mobNum.length == 10) {
                    $("#number_validate")[0].innerHTML = "Verified";
                    $("#number_validate").css({
                        'color': 'green'
                    });;
                    $('modal_mobile_no').css({
                        'borderColor': 'green'
                    });

                } else {
                    $("#number_validate")[0].innerHTML = "Enter 10 digit Number"
                    $('modal_mobile_no').css({
                        'borderColor': 'red'
                    });
                    return false;
                }
            } else {
                $("#number_validate")[0].innerHTML = "Invalid Number"
                $('#modal_mobile_number').css({
                    'borderColor': 'red'

                });
                $("#number_validate").css({
                    'color': 'red'
                });;
                return false;
            }

        });

    });
</script>
<script>
    function check_email() {
        $('input[name^="bill"]').prop('required', true);
        var email_bill = document.getElementById("bill_email").value;
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        if (reg.test(email_bill) == false) {
            $("#email_p")[0].innerHTML = "Please enter valid email";
            $('#bill_email').css({
                'borderColor': 'red'
            })

        }
        if (reg.test(email_bill) == true) {
            $("#email_p")[0].innerHTML = "";
            $('#bill_email').css({
                'borderColor': '#dfe0e6'
            })

        }
        if ($('#bill_email').val() == "") {
            $("#email_p")[0].innerHTML = "Field is required";
            $("#bill_email").attr('required', false);

        }


    }
</script>

<script>
    function check_mobile() {
        var mobile = document.getElementById("bill_mobile").value;
        var reg = /^[7-9][0-9]{9}$/;
        $('input[name^="bill"]').prop('required', true);
        // $('#bill_mobile').attr('maxlength', '10');
        if (reg.test(mobile) == false || mobile.length != 10) {
            $("#mobile_p")[0].innerHTML = "Please enter valid mobile";
            $('#bill_mobile').css({
                'borderColor': 'red'
            })

        }
        if (reg.test(mobile) == true) {
            $("#mobile_p")[0].innerHTML = "";
            $('#bill_mobile').css({
                'borderColor': '#dfe0e6'
            })

        }
        if ($('#bill_mobile').val() == "") {
            $("#mobile_p")[0].innerHTML = "Field is required";
            $("#bill_mobile").attr('required', false);

        }


    }
</script>
<script>
    function check_fname() {
        var name = document.getElementById("billing_name").value;
        var letter = /^[A-Za-z]+$/;
        $('input[name^="bill"]').prop('required', true);
        if (letter.test(name) == false) {
            $("#fname_p")[0].innerHTML = "Please enter only alphabets";
            $('#billing_name').css({
                'borderColor': 'red'
            })
            $("#billing_name").attr('required', false);


        }

        if (letter.test(name) == true) {
            $("#fname_p")[0].innerHTML = "";
            $('#billing_name').css({
                'borderColor': '#dfe0e6'
            })
        }
        if ($('#billing_name').val() == "") {
            $("#fname_p")[0].innerHTML = "Field is required";
            $('#billing_name').css({
                'borderColor': 'red'
            })
            $("#billing_name").attr('required', false);

        }

    }
</script>
<script>
    function chec_fname() {
        var name = document.getElementById("modal_f_name").value;
        var letter = /^[A-Za-z]+$/;
        if (letter.test(name) == false) {
            $("#fname_validate")[0].innerHTML = "Please enter only alphabets";
            $('#modal_f_name').css({
                'borderColor': 'red'
            })

        }

        if (letter.test(name) == true) {
            $("#fname_validate")[0].innerHTML = "";
            $('#modal_f_name').css({
                'borderColor': '#dfe0e6'
            })
        }
        if ($('#modal_f_name').val() == "") {
            $("#fname_validate")[0].innerHTML = "Field is required";
            $("#modal_f_name").attr('required', false);
        }

    }
</script>

<script>
    function check_lname() {
        var lname = document.getElementById("last_name").value;
        var reg = /^[A-Za-z]+$/;
        $('input[name^="bill"]').prop('required', true);
        if (reg.test(lname) == false) {
            $("#lname_p")[0].innerHTML = "Please enter only alphabets";
            $('#last_name').css({
                'borderColor': 'red'
            })
            $("#last_name").attr('required', false);


        }
        if (reg.test(lname) == true) {
            $("#lname_p")[0].innerHTML = "";

            $('#last_name').css({
                'borderColor': '#dfe0e6'
            })
        }
        if ($('#last_name').val() == "") {
            $("#lname_p")[0].innerHTML = "Field is required";
            $("#last_name").attr('required', false);

        }

    }
</script>
<!-- script to store the address -->
<script>
    function addAdress() {

        var myform = document.getElementById("shipping_address_default");
        var fd = new FormData($(myform)[0]);
        var b = $("#shipping_address_default").serializeArray();

        b.push({
            name: csfr_token_name,
            value: $.cookie(csfr_cookie_name)
        });

        b.push({
            name: "sys_lang_id",
            value: sys_lang_id
        });






        if ($("#login_fname").val() == "") {
            $("#fname_login")[0].innerHTML = "*Field must be filled out";
            $('#login_fname').css({
                'borderColor': 'red'
            });

        } else {
            $("#fname_login").hide();
            $('#login_fname').css({
                'borderColor': '#dfe0e6'
            });
        }
        if ($("#login_lname").val() == "") {
            $("#lname_login")[0].innerHTML = "*Field must be filled out";
            $('#login_lname').css({
                'borderColor': 'red'
            });

        } else {
            $("#lname_login").hide();
            $('#login_lname').css({
                'borderColor': '#dfe0e6'
            });
        }
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        if ($("#login_email").val() == "") {
            $("#email_login")[0].innerHTML = "*Field must be filled out";
            $('#login_email').css({
                'borderColor': 'red'
            });

        } else if (reg.test($("#login_email").val()) == false) {
            $("#email_login")[0].innerHTML = "Enter a valid email";
            $('#login_email').css({
                'borderColor': 'red'
            });


        } else {
            $("#email_login").hide();
            $('#login_email').css({
                'borderColor': '#dfe0e6'
            });
        }



        if ($("#login_number").val() == "") {
            $("#number_login")[0].innerHTML = "*Field must be filled out";
            $('#login_number').css({
                'borderColor': 'red'
            });

        } else if ($("#login_number").val().length != 10) {
            $("#number_login")[0].innerHTML = "*Enter valid number";
            $('#login_number').css({
                'borderColor': 'red'
            });

        } else {
            $("#number_login").hide();
            $('#login_number').css({
                'borderColor': '#dfe0e6'
            });
        }
        if ($("#shipping_zip_code").val() == "") {
            $("#pincode_span")[0].innerHTML = "*Field must be filled out";
            $('#shipping_zip_code').css({
                'borderColor': 'red'
            });

        } else if ($("#shipping_zip_code").val().length != 6) {
            $("#pincode_span")[0].innerHTML = "Enter a valid pincode";
            $('#shipping_zip_code').css({
                'borderColor': 'red'
            });


        } else {
            $("#pincode_span").hide();
            $('#shipping_zip_code').css({
                'borderColor': '#dfe0e6'
            });
        }

        if ($("#shipping_state_login").val() == "") {
            $("#state_login")[0].innerHTML = "*Field must be filled out";
            $('#shipping_state_login').css({
                'borderColor': 'red'
            });
            if ($("#shipping_city_login").val() == "") {
                $("#city_login")[0].innerHTML = "*Field must be filled out";
                $('#shipping_city_login').css({
                    'borderColor': 'red'
                });

            }
        }
        if ($("#shipping_area_login").val() == "") {
            $("#area_login")[0].innerHTML = "*Field must be filled out";
            $('#shipping_area_login').css({
                'borderColor': 'red'
            });

        }
        if ($("#shipping_address_login").val() == "") {
            $("#address1_login")[0].innerHTML = "*Field must be filled out";
            $('#shipping_address_login').css({
                'borderColor': 'red'
            });

        } else if (($("#login_fname").val() != "") && ($("#login_lname").val() != "") && ($("#login_email").val() != "") && ($("#login_email").val().match(reg)) && ($("#login_number").val() != "") && ($("#login_number").val().length == 10) && ($("#shipping_zip_code").val() != "") && ($("#shipping_zip_code").val().length == 6) && ($("#shipping_state_login").val() != "") && ($("#shipping_city_login").val() != "") && ($("#shipping_area_login").val() != "") && ($("#shipping_address_login").val() != "")) {
            $.ajax({
                url: base_url + "cart_controller/shipping_address",
                type: "post",
                data: b,
                success: function(data) {
                    $('.Validation_error').hide();
                    $('#login_fname').css({
                        'borderColor': '#dfe0e6'
                    });
                    $('#login_lname').css({
                        'borderColor': '#dfe0e6'
                    });
                    $('#login_email').css({
                        'borderColor': '#dfe0e6'
                    });
                    $("#login_number").css({

                        'borderColor': '#dfe0e6'

                    })
                    $("#shipping_zip_code").css({

                        'borderColor': '#dfe0e6'

                    })
                    $("#shipping_state_login").css({

                        'borderColor': '#dfe0e6'

                    })
                    $("#shipping_city_login").css({

                        'borderColor': '#dfe0e6'

                    })
                    $("#shipping_area_login").css({

                        'borderColor': '#dfe0e6'

                    })
                    $("#shipping_address_login").css({

                        'borderColor': '#dfe0e6'

                    })
                    location.reload();
                }
            })
        }
    }
</script>
<script>
    function change_address(a, b, c, d, e, f, g, h, i, j, k) {

        $('#f_name').val(a)
        $('#l_name').val(b)
        $('#email_id').val(k)
        $('#mobile_no').val(j)
        $('#zipcode_val').val(i)
        $('#shipping_state_val').val(h)
        $('#shipping_city_val').val(g)
        $('#shipping_area_val').val(f)
        $('#shipping_address_val').val(d)
        $('#shipping_landmark_val').val(e)
        $('[name=address_type_val]').val(c)
        $("#load_payment_page")[0].innerHTML = "";
        // $("#order_summary")[0].innerHTML = res.order_summary;
        $("#paymentMethodButtonDiv").show();
    }
</script>
<script>
    $(document).ready(function() {

        change_address('<?php echo $address->f_name; ?>', '<?php echo $address->l_name; ?>', '<?php echo $address->address_type; ?>', '<?php echo $address->h_no; ?>', '<?php echo $address->landmark; ?>', '<?php echo $address->area; ?>', '<?php echo $address->city; ?>', '<?php echo $address->state; ?>', '<?php echo $address->zip_code; ?>', '<?php echo $address->ph_number; ?>', '<?php echo $address->email; ?>')
    });
</script>

<script>
    function edit(id, a, b, c, d, e, f, g, h, i, j, k) {
        $('#modal_id').val(id)
        $('#modal_f_name').val(a)
        $('#modal_l_name').val(b)
        $('#modal_email_id').val(k)
        $('#modal_mobile_no').val(j)
        $('#modal_zipcode').val(i)
        $('#modal_shipping_state').val(h)
        $('#modal_shipping_city').val(g)
        $('#modal_shipping_area').val(f)
        $('#modal_shipping_address').val(d)
        $('#modal_shipping_landmark').val(e)
        // $('[name=address_type_modal]:checked').val(c)
        if ($('#radioApple1').val() == c) {
            document.getElementById("radioApple1").checked = true;
        } else if ($('#radioBanana1').val() == c) {
            document.getElementById("radioBanana1").checked = true;
        }

        $("#edit-modal").modal("show");
    }

    function editAddress() {
        var myform = document.getElementById("shipping_address_edit");
        var fd = new FormData($(myform)[0]);

        var b = $("#shipping_address_edit").serializeArray();
        b.push({
            name: csfr_token_name,
            value: $.cookie(csfr_cookie_name)
        });

        b.push({
            name: "sys_lang_id",
            value: sys_lang_id
        });
        let letters = /^[A-Za-z]+$/;

        if (letters.test($("#modal_f_name").val()) == false) {
            $("#fname_validate")[0].innerHTML = "Please enter only alphabets";
            $('#modal_f_name').css({
                'borderColor': 'red'
            });

        } else {
            $("#fname_validate")[0].innerHTML = "Please enter only alphabets";
            $('#modal_f_name').css({
                'borderColor': '#dfe0e6'
            });

        }

        if ($("#modal_l_name").val() == "") {
            $("#lname_validate")[0].innerHTML = "*Field must be filled out";
            $('#modal_l_name').css({
                'borderColor': 'red'
            });

        }
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;


        if ($("#modal_email_id").val() == "") {
            $("#email_validate")[0].innerHTML = "*Field must be filled out";
            $('#modal_email_id').css({
                'borderColor': 'red'
            });

        } else if (reg.test($("#modal_email_id").val()) == false) {
            $("#email_validate")[0].innerHTML = "Enter a valid email";
            $('#modal_email_id').css({
                'borderColor': 'red'
            });


        } else {
            $("#email_validate").hide();
            $('#modal_email_id').css({
                'borderColor': '#dfe0e6'
            });
        }
        if ($("#modal_mobile_no").val() == "") {
            $("#number_validate")[0].innerHTML = "*Field must be filled out";
            $('#modal_mobile_no').css({
                'borderColor': 'red'
            });


        } else if ($("#modal_mobile_no").val().length != 10) {
            $("#number_validate")[0].innerHTML = "*Enter valid number";
            $('#modal_mobile_no').css({
                'borderColor': 'red'
            });

        } else {
            $("#number_validate").hide();
            $('#modal_mobile_no').css({
                'borderColor': '#dfe0e6'
            });

        }

        if ($("#modal_zipcode").val() == "") {
            $("#pincode_validate")[0].innerHTML = "*Field must be filled out";
            $('#modal_zipcode').css({
                'borderColor': 'red'
            });
        } else if ($("#modal_zipcode").val().length != 6) {
            $("#pincode_validate")[0].innerHTML = "Enter a valid  pincode";
            $('#modal_zipcode').css({
                'borderColor': 'red'
            });


        } else {
            $("#pincode_validate").hide();
            $('#modal_zipcode').css({
                'borderColor': '#dfe0e6'
            });

        }


        if ($("#modal_shipping_state").val() == "") {
            $("#state_validate")[0].innerHTML = "*Field must be filled out";
            $('#modal_shipping_state').css({
                'borderColor': 'red'
            });
            if ($("#modal_shipping_city").val() == "") {
                $("#city_validate")[0].innerHTML = "*Field must be filled out";
                $('#modal_shipping_city').css({
                    'borderColor': 'red'
                });

            }
        }
        if ($("#modal_shipping_area").val() == "") {
            $("#area_validate")[0].innerHTML = "*Field must be filled out";
            $('#modal_shipping_area').css({
                'borderColor': 'red'
            });

        }
        if ($("#modal_shipping_address").val() == "") {
            $("#address_validate")[0].innerHTML = "*Field must be filled out";
            $('#modal_shipping_address').css({
                'borderColor': 'red'
            });


        } else if (($("#modal_f_name").val() != "") && ($("#modal_l_name").val() != "") && ($("#modal_email_id").val() != "") && ($("#modal_email_id").val().match(reg)) && ($("#modal_mobile_no").val() != "") && ($("#modal_mobile_no").val().length == 10) && ($("#modal_zipcode").val() != "") && ($("#modal_zipcode").val().length == 6) && ($("#modal_shipping_state").val() != "") && ($("#modal_shipping_city").val() != "") && ($("#modal_shipping_area").val() != "") && ($("#modal_shipping_address").val() != "")) {


            $.ajax({
                url: base_url + "cart_controller/update_shipping_address/" + b[0].value,
                type: "post",
                data: b,
                success: function(data) {
                    $('.Validation_error').hide();
                    $('#modal_f_name').css({
                        'borderColor': '#dfe0e6'
                    });
                    $('#modal_l_name').css({
                        'borderColor': '#dfe0e6'
                    });
                    $('#modal_email_id').css({
                        'borderColor': '#dfe0e6'
                    });
                    $("#modal_mobile_no").css({

                        'borderColor': '#dfe0e6'

                    })
                    $("#modal_zip_code").css({

                        'borderColor': '#dfe0e6'

                    })
                    $("#modal_shipping_state").css({

                        'borderColor': '#dfe0e6'

                    })
                    $("#modal_shipping_city").css({

                        'borderColor': '#dfe0e6'

                    })
                    $("#modal_shipping_area").css({

                        'borderColor': '#dfe0e6'

                    })
                    $("#modal_shipping_address").css({

                        'borderColor': '#dfe0e6'

                    })



                    location.reload();
                }
            })
        }

    }
</script>
<!-- save new address on db -->
<script>
    function addAddress1() {

        var myform = document.getElementById("shipping_address_additional");
        var fd = new FormData($(myform)[0]);
        var b = $("#shipping_address_additional").serializeArray();
        b.push({
            name: csfr_token_name,
            value: $.cookie(csfr_cookie_name)
        });

        b.push({
            name: "sys_lang_id",
            value: sys_lang_id
        });




        var letters = /^[A-Za-z]+$/;

        if ($("#pop_name").val() == "") {
            $("#fname_valid")[0].innerHTML = "*Field must be filled out";
            $('#pop_name').css({
                'borderColor': 'red'
            });

        }
        if ($("#pop_lname").val() == "") {
            $("#lname_valid")[0].innerHTML = "*Field must be filled out";
            $('#pop_lname').css({
                'borderColor': 'red'
            });

        }
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        if ($("#pop_email").val() == "") {
            $("#email_valid")[0].innerHTML = "*Field must be filled out";
            $('#pop_email').css({
                'borderColor': 'red'
            });

        } else if (reg.test($("#pop_email").val()) == false) {
            $("#email_valid")[0].innerHTML = "Enter a valid email";
            $('#pop_email').css({
                'borderColor': 'red'
            });


        } else {
            $("#email_valid").hide();
            $('#pop_email').css({
                'borderColor': '#dfe0e6'
            });
        }
        if ($("#pop_number").val() == "") {
            $("#number_valid")[0].innerHTML = "*Field must be filled out";
            $('#pop_number').css({
                'borderColor': 'red'
            });

        } else if ($("#pop_number").val().length != 10) {
            $("#number_valid")[0].innerHTML = "*Enter valid number";
            $('#pop_number').css({
                'borderColor': 'red'
            });

        } else {
            $("#number_valid").hide();
            $('#pop_number').css({
                'borderColor': '#dfe0e6'
            });
        }
        if ($("#zipcode").val() == "") {
            $("#pincode_valid")[0].innerHTML = "*Field must be filled out";
            $('#zipcode').css({
                'borderColor': 'red'
            });

        } else if ($("#zipcode").val().length != 6) {
            $("#pincode_valid")[0].innerHTML = "Enter a valid  pincode";
            $('#zipcode').css({
                'borderColor': 'red'
            });


        } else {
            $("#pincode_valid").hide();
            $('#zipcode').css({
                'borderColor': '#dfe0e6'
            });

        }
        if ($("#shipping_state").val() == "") {
            $("#state_valid")[0].innerHTML = "*Field must be filled out";
            $('#shipping_state').css({
                'borderColor': 'red'
            });
        } else if (($("#shipping_state").val() != "")) {
            $("#state_valid").hide();
            $('#shipping_state').css({
                'borderColor': '#dfe0e6'
            });
        }
        if ($("#shipping_city").val() == "") {
            $("#city_valid")[0].innerHTML = "*Field must be filled out";
            $('#shipping_city').css({
                'borderColor': 'red'
            });

        } else if (($("#shipping_city").val() != "")) {
            $("#city_valid").hide();
            $('#shipping_city').css({
                'borderColor': '#dfe0e6'
            });
        }
        if ($("#shipping_area").val() == "") {
            $("#area_valid")[0].innerHTML = "*Field must be filled out";
            $('#shipping_area').css({
                'borderColor': 'red'
            });

        } else if (($("#shipping_area").val() != "")) {
            $("#area_valid").hide();
            $('#shipping_area').css({
                'borderColor': '#dfe0e6'
            });
        }
        if ($("#shipping_address").val() == "") {
            $("#address_valid")[0].innerHTML = "*Field must be filled out";
            $('#shipping_address').css({
                'borderColor': 'red'
            });

        } else if (($("#pop_name").val() != "") && ($("#pop_lname").val() != "") && ($("#pop_email").val() != "") && (reg.test($("#pop_email").val()) == true) && ($("#pop_number").val() != "") && ($("#pop_number").val().length == 10) && ($("#zipcode").val() != "") && ($("#zipcode").val().length = 6) && ($("#shipping_state").val() != "") && ($("#shipping_city").val() != "") && ($("#shipping_area").val() != "") && ($("#shipping_address").val() != "")) {
            $.ajax({
                url: base_url + "cart_controller/shipping_address",
                type: "post",
                data: b,
                success: function(data) {
                    $('.Validation_error').hide();
                    $('#pop_name').css({
                        'borderColor': '#dfe0e6'
                    });
                    $('#pop_lname').css({
                        'borderColor': '#dfe0e6'
                    });
                    $('#pop_email').css({
                        'borderColor': '#dfe0e6'
                    });
                    $("#pop_number").css({

                        'borderColor': '#dfe0e6'

                    })
                    $("#zipcode").css({

                        'borderColor': '#dfe0e6'

                    })

                    $("#shipping_state").css({

                        'borderColor': '#dfe0e6'

                    })
                    $("#shipping_city").css({

                        'borderColor': '#dfe0e6'

                    })
                    $("#shipping_area").css({

                        'borderColor': '#dfe0e6'

                    })
                    $("#shipping_address").css({

                        'borderColor': '#dfe0e6'

                    })
                    location.reload();
                }
            })
        }
    }
</script>

<script>
    function check_pincode(product_id, user_pincode, seller_pincode, weight, variation_array) {
        var result = null;
        var message = null;
        var weight_grams = parseInt(weight) / 1000;
        var settings = {
            "url": "https://apiv2.shiprocket.in/v1/external/courier/serviceability/",
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/json",
                "Authorization": "Bearer <?php echo $_SESSION['modesy_sess_user_shiprocket_token'] ?>"
            },
            "data": {
                "pickup_postcode": seller_pincode,
                "delivery_postcode": user_pincode,
                "cod": 0,
                "weight": weight_grams
            },
        };
        $(document).ready(function() {
            $.ajax(settings).done(function(response) {
                result = response
                var data = {
                    "product_id": product_id,
                    "shipping_amount": result.data.available_courier_companies[0].rate,
                    "variation_array": variation_array
                };
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                $.ajax({
                    type: 'post',
                    url: base_url + 'add-shipping-amount-to-cart',
                    data: data,
                    dataType: 'json',
                    async: false,
                    success: function(data) {
                        console.log(data);
                    }
                });
                if (result['status'] == 404) {
                    message = result['message'];
                }
            });
        });
    }
</script>
<script>
    $(document).ready(function() {


        $("#bill_mobile").on("keyup", function() {
            var mobile = $(this).val();
            var reg = /^[7-9][0-9]{9}$/;

            if (reg.test(mobile) == false) {
                $("#mobile_p")[0].innerHTML = "Please enter valid mobile";
                $('#bill_mobile').css({
                    'borderColor': 'red'
                })
                $('#bill_mobile').attr('minlength', false);
                $('#bill_mobile').attr('maxlength', false);


            }
            if (reg.test(mobile) == true) {
                $("#mobile_p")[0].innerHTML = "";
                $('#bill_mobile').css({
                    'borderColor': '#dfe0e6'
                })

            }
            if ($('#bill_mobile').val() == "") {
                $("#mobile_p")[0].innerHTML = "Field is required";
                $('#bill_mobile').css({
                    'borderColor': 'red'
                })
                $("#bill_mobile").attr('required', false);

            }


        });
    });
</script>
<script type="text/javascript">
    var user_type = document.getElementById('role').value;
    if (user_type == "guest") {
        history.pushState(null, null, location.href);
        window.onpopstate = function() {
            history.go(1);
        };
    }
</script>


<script>
    $("#payment_button").click(function(e) {
        e.preventDefault();
        var form = $('#form_validate');

        $.ajax({
            type: "POST",
            url: base_url + "cart_controller/shipping_post_test",
            data: form.serialize(),
            success: function(e) {
                res = JSON.parse(e);
                $("#load_payment_page")[0].innerHTML = res.pay_view_page;
                $("#order_summary")[0].innerHTML = res.order_summary;
                $("#paymentMethodButtonDiv").hide();
                console.log(e);
                // alert($response.pay_view);
            },
        });

    });
</script>

<script>
    function changeViewPayment() {

        var pay_method = document.querySelector('input[name="payment_option"]:checked').value;
        var t = {
            pay_method: pay_method,
            sys_lang_id: 1,
        };
        t[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "cart_controller/load_pay_view",
            data: t,
            success: function(e) {
                res = JSON.parse(e);
                $("#pay_view_load")[0].innerHTML = res.pay_view;
                console.log(res);
                $(".cash_free_btn").prop('disabled', false);
                // alert($response.pay_view);
            },
        });

    }
</script>
<script>
    function place_cod_orders() {
        $(".cash_free_btn").prop('disabled', true);
        var pay_method = document.querySelector('input[name="payment_option"]:checked').value;
        var t = {
            value: "update"
        };
        t[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "cart_controller/cash_on_delivery_payment_post",
            data: t,
            success: function(e) {
                res = JSON.parse(e);
                var x = ["<?php echo $this->auth_user->first_name ?>", res.order_number, "<?php echo ($cart_total->total_price) / 100 ?>", pay_method]
                var z = '"'.concat(x.join('","')).concat('"');

                function send_buyer() {
                    var required_data = {
                        "from": "918287606650",
                        "to": "91<?php echo $this->auth_user->phone_number; ?>",
                        "type": "mediatemplate",
                        "channel": "whatsapp",
                        "template_name": "new_ordertext",
                        "params": z,
                        "param_url": "view-order-details".concat("/").concat(res.order_number),
                    }
                    var data = {
                        "order": required_data,
                        sys_lang_id: sys_lang_id
                    };
                    data[csfr_token_name] = $.cookie(csfr_cookie_name);
                    $.ajax({
                        type: "POST",
                        url: base_url + "cart_controller/whatsapp",
                        data: data,
                        success: function(response) {
                            result = response;
                        }
                    })
                }
                if (res.order_completed == "yes") {
                    window.location.href = base_url + "order-completed";
                    send_buyer();
                } else {
                    window.location.href = base_url + "cart/payment";
                }
            }
        });
    }
</script>

<script>
    function Payment() {
        $(".cash_free_btn").prop('disabled', true);
        // e.preventDefault();
        // var form = $('#form_submit_disable');
        var payment_mode = $('#payment_mode').val();
        var orderId = $('#orderId').val();
        var orderamount = $('#orderamount').val();
        var bank_select = $('#bank_select').val();
        var wallet_select = $('#wallet_select').val();

        var t = {
            // pay_method: pay_method,
            sys_lang_id: 1,
            payment_mode: payment_mode,
            bank_select: bank_select,
            wallet_select: wallet_select,
            orderid: orderId,
            orderamount: orderamount
        };
        t[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "cart_controller/payment_cashfree",
            data: t,
            success: function(e) {
                res = JSON.parse(e);
                window.location.href = base_url + "cashfree_form";

                // alert($response.pay_view);
            },
        });


    }
</script>
<script>
    function check_mode(val) {
        var element = $("#nb_banks");
        var element2 = $("#wallets");
        if (val == 'nb') {
            // element.show();
            $("#nb_banks").css("display", "block");
            element2.hide();
            document.getElementById('bank_select').required = true;
            document.getElementById('wallet_select').required = false;
        } else if (val == 'wallet') {
            element2.show();
            element.hide();
            document.getElementById('wallet_select').required = true;
            document.getElementById('bank_select').required = false;
        } else {
            element.hide();
            document.getElementById('bank_select').required = false;
            document.getElementById('bank_select').required = false;
            element2.hide();
        }
    }
</script>