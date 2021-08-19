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
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">User Details</h3>
            </div><!-- /.box-header -->

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
                <div class="form-group">
                    <p>
                        <img src="<?php echo get_user_avatar($user); ?>" alt="<?php echo $user->username; ?>" class="form-avatar" id="test" style="width: 30%;">
                    </p>

                </div>

                -**


                <!-- <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('status'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php if ($product->status == 1) : ?>
                            <label class="label label-success"><?php echo trans("active"); ?></label>
                        <?php else : ?>
                            <label class="label label-danger"><?php echo trans("pending"); ?></label>
                        <?php endif; ?>
                    </div>
                </div> -->



                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('id'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user->seller_unique_id; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">First name</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo html_escape($user_details->first_name); ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Last name</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo html_escape($user_details->last_name); ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Email</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo html_escape($user_details->email); ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('slug'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user->slug; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Shop name</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->shop_name; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Company Type</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->company_type; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Supplier Type</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->supplier_type; ?>
                    </div>
                </div>
                <?php if ($user_details->supplier_type == "Goods") { ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Supplier Goods Type</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo $user_details->supplier_type_goods; ?>
                        </div>
                    </div>

                <?php } else if ($user_details->supplier_type == "Services") { ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Supplier Services Type</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo $user_details->supplier_type_services; ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Date of Birth</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->date_of_birth; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Gender</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->gender; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">USP</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->usp; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">About Company/Service</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->about_me; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Phone number</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->phone_number; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Alternative Phone</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->alternative_number; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Area in operation</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->area_in_operation; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Have Trademark</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->trademark_yes_no; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">FSSAI Number</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->fssai_number; ?>
                        &nbsp; &nbsp; &nbsp; (<a target="_blank" href="https://foodlicensing.fssai.gov.in/cmsweb/TrackFBO.aspx">Verify</a>)
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Have GST Number</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->have_gst; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Type of Goods</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->type_of_goods; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Selling Exempted Goods</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->selling_exempted_goods; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">GST Number</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->gst_number; ?>
                        &nbsp; &nbsp; &nbsp; (<a target="_blank" href="https://services.gst.gov.in/services/searchtp">Verify</a>)
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">PAN card Number</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->pan_number; ?>
                        &nbsp; &nbsp; &nbsp; (<a target="_blank" href="https://www1.incometaxindiaefiling.gov.in/e-FilingGS/Services/VerifyYourPanDeatils.html?lang=eng">Verify</a>)
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Adharcard Number</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->adhaar_number; ?>
                        &nbsp; &nbsp; &nbsp; (<a target="_blank" href="https://resident.uidai.gov.in/verify">Verify</a>)
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">PAN card Photo</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <img src="<?php echo $user_details->image_pancard; ?>" alt="Pancard" id="myImg" width="150" height="150">

                    </div>
                </div>
                <div id="myModal" class="modal">
                    <span class="close">&times;</span>
                    <img class="modal-content" id="img01">
                    <div id="caption"></div>
                </div>


                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Years In Operation</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->years_in_operation; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">What Type of assistance you want?</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->assistance; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Any Other Assistance</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->other_assistance; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Ready For Barter</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->barter; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Turn Over</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->turnover; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Active Customers</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->active_customer; ?>
                    </div>
                </div>
                <?php if ($user_details->supplier_type == "Services") { ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Affiliations / Certifications</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo $user_details->affiliations_or_certifications; ?>
                        </div>
                    </div>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Institute name</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo $user_details->institute_name; ?>
                        </div>
                    </div>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Specialisation</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo $user_details->specialisation_details; ?>
                        </div>
                    </div>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Open to visit</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo $user_details->open_to_visit; ?>
                        </div>
                    </div>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Willing to travel</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo $user_details->willing_to_travel; ?>
                        </div>
                    </div>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Prefer Day</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo $user_details->prefer_day; ?>
                        </div>
                    </div>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Prefer Time</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo $user_details->prefer_time; ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">House Number</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->house_no; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Supplier Area</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->supplier_area; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Supplier State</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->supplier_state; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Supplier City</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->supplier_city; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Pincode</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->pincode; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">How Hear About Us</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->how_hear_about_us; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Selling In Other Platforms</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->other_selling_platforms; ?>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Anniversary</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php echo $user_details->anniversary; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Facebook Url</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <a href="<?php echo $user_details->supplier_facebook_url; ?>"><?php echo $user_details->supplier_facebook_url; ?> </a>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Instagram Url</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <a href="<?php echo $user_details->supplier_instagram_url; ?>"><?php echo $user_details->supplier_instagram_url; ?></a>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Website Url</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <a href="<?php echo $user_details->supplier_website_url; ?>"><?php echo $user_details->supplier_website_url; ?></a>
                    </div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Any other Url</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <a href="<?php echo $user_details->supplier_other_url; ?>"><?php echo $user_details->supplier_other_url; ?></a>
                    </div>
                </div>





            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <?php if ($user_details->role == "member" && $user_details->is_active_shop_request == 1) { ?>
                    <!-- form start -->


                    <?php echo form_open('membership_controller/approve_shop_opening_request'); ?>
                    <input type="hidden" name="id" value="<?php echo $user->id; ?>">

                    <div class="modal fade" id="exampleModal_<?php echo $user->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h5 class="modal-title" id="exampleModalLabel">Update Commission Rate</h5>
                                </div>
                                <div class="modal-body">
                                    <input type="number" step="0.01" min="0" max="100" class="form-control form-input" name="commission_rate" value="" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button type="submit" name="submit" value="1" class="btn btn-primary">
                                        <i class="fa fa-check option-icon"></i><?php echo trans('approve'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#exampleModal_<?php echo $user->id; ?>">
                        <i class="fa fa-check option-icon"></i><?php echo trans('approve'); ?>
                    </button>

                    <!-- <button type="submit" name="submit" value="1" class="btn btn-success pull-right">
                        <i class="fa fa-check option-icon"></i><?php echo trans('approve'); ?>
                    </button> -->

                    <button type="button" data-toggle="modal" data-target="#reject-modal" class="btn btn-primary pull-right">
                        <i class="fa fa-times option-icon"></i>Reject
                    </button>

                    <div id="reject-modal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                                    <h3>Reasons for rejection</h3>
                                </div>

                                <div class="modal-body">

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" value="<?php echo $user_details->email; ?>" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="message">Reason For Rejection</label>
                                        <textarea name="message" class="form-control form-textarea"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>


                                    <button type="submit" name="submit" value="0" class="btn btn-success">Send Email</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <a href="<?php echo $this->agent->referrer(); ?>" class="btn btn-danger pull-right m-r-5"><?php echo trans('back'); ?></a>
                    <?php echo form_close(); ?>
                <?php } else { ?>
                    <a href="<?php echo $this->agent->referrer(); ?>" class="btn btn-danger pull-right m-r-5"><?php echo trans('back'); ?></a>
                <?php  } ?>
                <?php echo form_open('membership_controller/revert_back'); ?>
                <input type="hidden" name="id1" value="<?php echo $user->id; ?>">
                <?php if ($user_details->is_active_shop_request == 1) : ?>
                    <button class="btn btn-secondary pull-right" type="button" data-toggle="modal" data-target="#contact-modal">
                        <i class="fa fa-check option-icon"></i>Revert
                    </button>
                <?php endif; ?>
                <div id="contact-modal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                                <h3>Revert back</h3>
                            </div>
                            <form id="contactForm" name="contact" role="form">
                                <div class="modal-body">

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" value="<?php echo $user_details->email; ?>" class="form-control">
                                    </div>
                                    <label>Choose reasons for rejection</label>
                                    <div>
                                        <label>
                                            <input type="checkbox" class="option-input checkbox" name="issues[]" id="issue" value="GST number is not valid" />
                                            &nbsp; GST Number Issue
                                        </label><br>
                                        <label>
                                            <input type="checkbox" class="option-input checkbox" name="issues[]" id="issue" value="PAN number not valid" />
                                            &nbsp; PAN card number Issue
                                        </label><br>
                                        <label>
                                            <input type="checkbox" class="option-input checkbox" name="issues[]" id="issue" value="Pan Photo not clear" />
                                            &nbsp; PAN card photo
                                        </label><br>
                                        <label>
                                            <input type="checkbox" class="option-input checkbox" name="issues[]" id="issue" value="Adhar Card Number not valid" />
                                            &nbsp; Adharcard Issue
                                        </label>
                                        <br>
                                    </div>
                                    </br>
                                    <div class="form-group">
                                        <label for="message">Message</label>
                                        <textarea name="messagere" class="form-control form-textarea"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Send Email</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php form_close(); ?>
            </div>
            <!-- /.box-footer -->

        </div>
        <!-- /.box -->
    </div>
</div>

<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById("myImg");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    img.onclick = function() {
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
    }

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
</script>

<?php if (!empty($this->session->userdata('mds_send_email_data'))) : ?>
    <script>
        $(document).ready(function() {
            var data = JSON.parse(<?php echo json_encode($this->session->userdata("mds_send_email_data")); ?>);
            if (data) {
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                $.ajax({
                    type: "POST",
                    url: base_url + "ajax_controller/send_email",
                    data: data,
                    success: function(response) {}
                });
            }
        });
    </script>
<?php endif;
$this->session->unset_userdata('mds_send_email_data'); ?>