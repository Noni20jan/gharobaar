<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/progress-tracker.css">
<!-- <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
<style>
    @media(max-width:700px) {
        #track_status {
            text-align: center;
            position: relative;
            top: 45px;
        }
    }

    @media(max-width:700px) {
        #approve {
            width: 50%;
        }
    }

    #cancel {
        color: black !important;
        font-weight: 400;
        outline: 0 !important;
        padding: .25rem .5rem;
        font-size: .8125rem;
        line-height: 1.5;
        border-radius: .1875rem;
    }

    @media(max-width:700px) {
        #cancel {
            color: black !important;
            font-weight: 400;
            outline: 0 !important;

            width: 48%;
            padding: .25rem .5rem;
            font-size: .8125rem;
            line-height: 1.5;
            border-radius: .1875rem;
        }
    }

    @media(max-width:700px) {
        .progress-tracker .progress-tracker--text .progress-tracker--center {
            position: relative;
            right: 42px;
        }
    }

    .new-order-ui-for-mobile {
        background-color: #fff;
        padding: 20px;
        margin-bottom: 2%
    }

    .quntity-total-mobile {
        padding-left: 0px;
        padding-right: 0px;
    }

    .confirm-new-ui {
        background-color: #007C05;
        border-color: #007C05;
        width: 100%;
        font-weight: bolder;
        font-size: 18px;
        padding: 10px;
    }

    .new-units-ui {
        text-align: end;
    }

    .gap-new-units {
        line-height: 30px;
    }

    .details-arrow {
        position: absolute;
        right: 27px;
        bottom: 98px;
    }

    .details-arrow-2 {
        position: absolute;
        right: 25px;
        bottom: 31px;
    }

    .review-for-more-new {
        background: #fff;
        margin-top: 20px;
        padding: 10px;

    }

    .review-heading {
        margin-bottom: 10px;
        color: #454545;
        font-size: 20px;
    }
</style>

<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6 summary-section">
                <?php foreach ($order_products as $item) :

                    if ($item->product_type == 'physical') {
                        $is_order_has_physical_product = true;
                    } ?>
                    <div class="row new-order-ui-for-mobile table-item-product">
                        <div class="left">
                            <div class="img-table">
                                <?php $variation_option = generate_product_variation_image($item);
                                if (!empty($variation_option)) :
                                    if ($variation_option->is_default != 0) : ?>
                                        <a href="<?php echo generate_product_url_by_slug($item->product_slug); ?>" target="_blank">
                                            <img src="<?php echo get_product_image($item->product_id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                                        </a>
                                    <?php else : ?>
                                        <a href="<?php echo generate_product_url_by_slug($item->product_slug); ?>">
                                            <img src="<?php echo get_variation_main_option_image_url($variation_option, null); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                                            <!-- <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_variation_main_option_image_url($variation_option, null); ?>" alt="<?php echo html_escape($item->product_title); ?>" class="lazyload img-fluid img-product" onerror="this.src='<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>'"> -->
                                        </a>
                                    <?php endif;
                                else : ?>
                                    <div class="img-table">
                                        <a href="<?php echo generate_product_url_by_slug($item->product_slug); ?>" target="_blank">
                                            <img src="<?php echo get_product_image($item->product_id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="right">
                            <a href="<?php echo generate_product_url_by_slug($item->product_slug); ?>" target="_blank" class="table-product-title">
                                <?php echo html_escape($item->product_title); ?>
                            </a>
                            <p class="m-b-15">
                                <span>By:</span>
                                <?php $seller = get_user($item->seller_id); ?>
                                <?php if (!empty($seller)) : ?>
                                    <a href="<?php echo generate_profile_url($seller->slug); ?>" target="_blank" class="table-product-title">
                                        <strong class="font-600"><?php echo get_shop_name($seller); ?></strong>
                                    </a>
                                <?php endif; ?>
                            </p>

                        </div>
                    </div><br />
            </div>

            <div class="col-sm-6 quntity-total-mobile">
                <div class="order-total summary-section" style="width: 100%;background-color:#fff;float:right; padding:18px;">
                    <strong style="color:#454545; font-size:20px;">Item details</strong>
                    <div class="row gap-new-units">
                        <div class="col-6 col-left">
                            <?php echo trans("quantity"); ?>
                        </div>
                        <div class="col-6 col-right new-units-ui">
                            <strong class="font-600"><?php echo $item->product_quantity; ?></strong>
                        </div>
                    </div>
                    <div class="row gap-new-units">
                        <div class="col-6 col-left">
                            <?php echo trans("total"); ?>
                        </div>
                        <div class="col-6 col-right new-units-ui">
                            <strong class="font-600"><?php echo price_formatted($order->price_subtotal + $order->price_shipping, $order->price_currency); ?></strong>
                        </div>
                    </div>
                    <?php if ($is_order_has_physical_product) : ?>
                        <div class="row gap-new-units">
                            <div class="col-6 col-left">
                                <?php echo trans("status"); ?>
                            </div>
                            <div class="col-6 col-right new-units-ui">


                                <strong class="font-600"><?php echo trans($item->order_status); ?></strong>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="row gap-new-units">
                        <div class="col-6 col-left">
                            Updated At
                        </div>
                        <div class="col-6 col-right new-units-ui">
                            <strong class="font-600"><?php echo time_ago($item->updated_at); ?></strong>
                        </div>
                    </div>
                    <?php if ($item->order_status == "payment_received" || $item->order_status == "awaiting_payment" || $item->order_status == "processing" || $item->order_status == "waiting") : ?>
                        <?php if (get_product($item->product_id)->add_meet == "Made to stock") : ?>
                            <button type="submit" id="approve" class="btn btn-sm btn-custom" style="background-color:green;" onclick="approve_order_product('<?php echo $item->id; ?>','<?php echo trans("confirm_approve_order"); ?>');">Confirm Order</button>

                            <button class="btn btn-sm btn-custom view-order-details-button" id="cancel" style="" data-id="<?php echo $item->id; ?>" data-toggle="modal" data-target="#rejection_reason_model_<?php echo $item->id; ?>"><?php echo trans("cancel_item"); ?></button>
                        <?php elseif (get_product($item->product_id)->add_meet == "Made to order" && $item->order_status == "waiting") : ?>
                            <button class="btn btn-sm btn-custom" data-id="<?php echo $item->id; ?>" data-toggle="modal" data-target="#rejection_reason_model_<?php echo $item->id; ?>"><?php echo trans("cancel_item"); ?></button>
                        <?php else : ?>
                            <button class="btn btn-sm btn-custom" data-id="<?php echo $item->id; ?>" data-toggle="modal" data-target="#rejection_reason_model_made_to_order"><?php echo trans("cancel_item"); ?></button>
                        <?php endif; ?>


                        <!-- <a data-toggle="modal" data-id="<?php echo $item->id; ?>" class="open-RejectReasonDialog btn btn-md btn-block btn-danger" data-target="#rejection_reason_model"><?php echo trans("cancel_item"); ?></a> -->
                    <?php elseif ($item->order_status == "shipped" || $item->order_status = "out_for_delivery" || $item->order_status = "completed") : ?>

                        <button type="button" class="btn btn-default" style="width:100%; background: #EEEEEE;border-radius: 6px; margin-bottom:19px; color:black;">
                            View order details<i class="fas fa-chevron-right details-arrow"></i>
                        </button>
                        <br>
                        <button type="submit" class="btn btn-sm btn-custom confirm-new-ui" onclick="approve_order_product('<?php echo $item->id; ?>','<?php echo trans("confirm_approve_order"); ?>');"><?php echo trans("confirm_order_received"); ?></button>
                    <?php elseif ($item->order_status == "completed") : ?>
                        <?php if ($item->product_type == 'digital') :
                            $digital_sale = get_digital_sale_by_order_id($item->buyer_id, $item->product_id, $item->order_id);
                            if (!empty($digital_sale)) : ?>
                                <div class="row-custom">
                                    <?php echo form_open('download-purchased-digital-file-post'); ?>
                                    <input type="hidden" name="sale_id" value="<?php echo $digital_sale->id; ?>">
                                    <div class="btn-group btn-group-download m-b-15">
                                        <button type="button" class="btn btn-md btn-custom dropdown-toggle" data-toggle="dropdown">
                                            <i class="icon-download-solid"></i><?php echo trans("download"); ?>&nbsp;&nbsp;<i class="icon-arrow-down m-0"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <button name="submit" value="main_files" class="dropdown-item"><?php echo trans("main_files"); ?></button>
                                            <button name="submit" value="license_certificate" class="dropdown-item"><?php echo trans("license_certificate"); ?></button>
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                        <?php endif;
                        endif; ?>
                    <?php endif; ?>
                    <!-- <div class="fullwidth">

                        <div class="container separator">
                            <h6 id="track_status">Tracking Status</h6>
                            <ul class="progress-tracker progress-tracker--text progress-tracker--center" style="position: relative; right: 42px;">
                                <li class="progress-step is-active" id="ordered_<?php echo $item->id; ?>">
                                    <div class="progress-marker"></div>
                                    <div class="progress-text">
                                        <h6 class="progress-title">Ordered</h6>

                                    </div>
                                </li>
                                <?php if ($item->order_status == "cancelled_by_user" || $item->order_status == "cancelled_by_seller") : ?>
                                    <li class="progress-step" id="cancelled_<?php echo $item->id; ?>">
                                        <div class="progress-marker"></div>
                                        <div class="progress-text">
                                            <h6 class="progress-title">Cancelled</h6>
                                        </div>
                                    </li>
                                <?php else : ?>
                                    <li class="progress-step" id="processing_<?php echo $item->id; ?>">
                                        <div class="progress-marker"></div>
                                        <div class="progress-text">
                                            <h6 class="progress-title">Processing</h6>
                                        </div>
                                    </li>
                                    <li class="progress-step" id="shipped_<?php echo $item->id; ?>">
                                        <div class="progress-marker"></div>
                                        <div class="progress-text">
                                            <h6 class="progress-title">Shipped</h6>
                                        </div>
                                    </li>
                                    <li class="progress-step" id="delivered_<?php echo $item->id; ?>">
                                        <div class="progress-marker"></div>
                                        <div class="progress-text">
                                            <h6 class="progress-title">Delivered</h6>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <br /> -->

                </div>
            <?php endforeach; ?>

            </div>
        </div>

        <div class="row review-for-more-new">
            <strong class="review-heading">Review Item</strong>
            <button type="button" class="btn btn-default" style="width:100%; background: #EEEEEE;border-radius: 6px; margin-bottom:10px; color:black;">
                Write a review of the product<i class="fas fa-chevron-right details-arrow-2"></i>
            </button>
        </div>

    </div>
</div>
</div>
<?php foreach ($order_products as $item) : ?>

    <div class="modal fade" id="rejection_reason_model_<?php echo $item->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-custom">
                <!-- form start -->
                <?php echo form_open('order_controller/cancel_order_product_post'); ?>
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo "Cancellation Reason"; ?></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"><i class="icon-close"></i> </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row tracking-number-container">
                        <div class="col-sm-12">
                            <input type="hidden" value='<?php echo $item->id; ?>' name="order_product_id" id="order_product_id">
                            <div class="form-group">
                                <label class="control-label"><?php echo "Choose Cancellation Reason"/*trans('choose_reject_reason')*/; ?></label>
                                <select name="reject_reason" id="reject_reason_select_<?php echo $item->id; ?>" onchange='check_comments1(this.value);' class="form-control custom-select" data-order-product-id="<?php echo $item->id; ?>" required>
                                    <option value="" disabled>Please select a Cancellation reason</option>
                                    <?php if (!empty($reject_reason)) :
                                        foreach ($reject_reason as $reason) : ?>
                                            <option value="<?php echo html_escape($reason->id); ?>" myTag="<?php $reason->reason ?>"><?php echo $reason->reason ?></option>
                                    <?php endforeach;
                                    endif; ?>
                                </select>
                                <div id="other_comment1" style="display: none;">
                                    <div id="reject_reason_specify_<?php echo $item->id; ?>">
                                        <label class="control-label">Please Specify Reason</label>
                                        <textarea class="form-control" id="other_comment1_text" name="reject_reason_comment1" row='3'></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?php echo trans("close"); ?></button>
                    <button type="submit" value="reject" id="cancel_product_loader" name="submit" class="btn btn-md btn-primary"><?php echo trans("submit"); ?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
        <div id="cover-spin4"></div>
    </div>
    <div class="modal fade" id="rejection_reason_model_made_to_order" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-custom">
                <!-- form start -->

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"><i class="icon-close"></i> </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row tracking-number-container">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">As this is "Made to order product" so You can not cancel it.For More help contact Gharobaar team </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?php echo trans("close"); ?></button>

                </div>

            </div>
        </div>
    </div>
    <?php foreach ($check as $chk) : ?>
    <?php endforeach; ?>
<?php endforeach; ?>

<script>
    function show() {
        var checkBox = document.getElementById("vehicle1");
        var text = document.getElementById("show-billing");
        if (checkBox.checked == true) {
            text.style.display = "block";
        } else {
            text.style.display = "none";
        }
    }
</script>
<script>
    function reason_specify(id) {


        var id_string = toString(id);
        var selectid = "reject_reason_select_" + id;


        // var option = $('option:selected', this).attr('mytag');
        var kb = $("selectid option:selected").attr("myTag");
        // alert(kb);
        // var id_string = toString(id);
        // var reject_reason_select = "reject_reason_select_" + id;
        // var cancel_reason = "cancel_reason_div_" + id;
        // var status = document.getElementById(reject_reason_select).value;
        // if (status == "4")
        //     document.getElementById(cancel_reason).style.display = "block";
        // else
        //     document.getElementById(cancel_reason).style.display = "none";
    }
</script>
<script type="text/javascript">
    function check_comments1(val) {
        var element = $("#other_comment1");
        if (val == '4') {
            element.show();
            document.getElementById('other_comment1_text').required = true;
        } else
            element.hide();
    }
</script>
<script>
    $("#cancel_product_loader").click(function(e) {
        // $('#modalwindow').modal('hide');
        $('#cover-spin4').show();
    });
</script>
<script>
    $(document).ready(function() {
        var item_status = <?php echo json_encode($order_products); ?>;

        for (i = 0; i < item_status.length; i++) {


            console.log(item_status[0].order_status);
            if (item_status[i].order_status == "cancelled_by_user" || item_status[i].order_status == "cancelled_by_seller") {

                $('#ordered_' + item_status[i].id).addClass("is-complete");
            }
            if (item_status[i].order_status == "processing" || item_status[i].order_status == "awaiting_pickup") {

                $('#ordered_' + item_status[i].id).addClass("is-complete");

            }
            if (item_status[i].order_status == "shipped") {
                $('#ordered_' + item_status[i].id).addClass("is-complete");
                $('#processing_' + item_status[i].id).addClass("is-complete");

            }
            if (item_status[i].order_status == "completed") {
                $('#ordered_' + item_status[i].id).addClass("is-complete");
                $('#processing_' + item_status[i].id).addClass("is-complete");

                $('#shipped_' + item_status[i].id).addClass("is-complete");

            }
        }

    });
</script>