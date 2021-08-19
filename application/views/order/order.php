<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    /* .order-details-container {
        background-image: url("<?php echo base_url(); ?>assets/img/cart_bg.png");
        object-fit: cover;
    }*/
    .table-responsive>.navy {
        border-collapse: collapse;
        width: 100%;
        background-color: #fdfdfda4;
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
        border-top-right-radius: 20px;
        padding: 20px
    }

    .table {
        border-collapse: separate;
        border-spacing: 0 1em;
        border-radius: 6px;
        -moz-border-radius: 6px;
    }


    @media only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px) {

        /* Force table to not be like tables anymore */
        table,
        thead,
        tbody,
        th,
        td,
        tr {
            display: block;
        }

        /* Hide table headers (but not display: none;, for accessibility) */
        thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        tr {
            margin: 0 0 1rem 0;
        }

        tr:nth-child(odd) {
            /* background: #ccc; */
        }

        td {
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 50%;
        }

        td:before {
            /* Now like a table header */
            position: absolute;
            /* Top/left values mimic padding */
            top: 0;
            left: 6px;
            width: 45%;
            padding-right: 10px;
            white-space: nowrap;
        }

        td:nth-of-type(1):before {
            content: "order";
        }

        td:nth-of-type(2):before {
            content: "product";
        }

        td:nth-of-type(3):before {
            content: "total";
        }

        td:nth-of-type(4):before {
            content: "payment";
        }

        td:nth-of-type(5):before {
            content: "status";
        }

        td:nth-of-type(6):before {
            content: "date";
        }

        td:nth-of-type(7):before {
            content: "";
        }

        td:nth-of-type(8):before {
            content: "options";
        }

        .details-new-view td:nth-of-type(9):before {
            content: "product";
        }

        .details-new-view td:nth-of-type(10):before {
            content: "status";
        }

        .details-new-view td:nth-of-type(11):before {
            content: "payment_status";
        }

        .details-new-view td:nth-of-type(12):before {
            content: "updated";
        }

        .details-new-view td:nth-of-type(13):before {
            content: "options";
        }

        .details-new-view td:nth-of-type(14):before {
            content: "tracking_status";
        }


    }


    .table-responsive>.navy>thead>tr>th {

        padding: 10px;
        background-color: #fdfdfda4;
        backdrop-filter: blur(10px);
    }

    .table-responsive>.navy>tbody>tr>td {
        padding: 16px;
        background-color: #fdfdfda4;
        backdrop-filter: blur(10px);

        padding-left: 1%;
    }

    @media (max-width: 768px) {
        .invoice_margin {
            margin-top: 35px;
        }
    }

    .order-details-new-ui {
        background-color: #fff;
        border-radius: 10px;
        width: 98%;
        padding: 18px 34px;
    }

    .table-orders tr td {
        padding: 0px 20px !important;
    }
</style>


<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cutive+Mono|Open+Sans:300,400&display=swap">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/progress-tracker.css">
<style>
    @media(max-width:700px) {
        #track_status {
            text-align: center;
            position: relative;
        }
    }

    @media(max-width:700px) {
        #approve {
            height: 32px;
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
            /* font-size: .8125rem; */
            height: 32px;
            font-size: 1.2125rem;
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
        margin-bottom: 2%;
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
</style>


<!-- Wrapper -->
<div id="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <div class="alert-message-lg">
                <!-- include message block -->
                <?php $this->load->view('dashboard/includes/_messages'); ?>
            </div>
        </div>
    </div>
    <div class="row webOrderView">
        <div class="col-sm-12">
            <div class="">
                <div class="order-head" style="margin-left:12px;">
                    <h2 class="title"><?php echo trans("order"); ?>:&nbsp;#<?php echo $order->order_number; ?></h2>
                </div>
                <div class="order-body">
                    <div class="row" style="padding-left:24px">
                        <div class="col-12 order-details-new-ui">
                            <div class="row order-row-item">
                                <div class="col-9">
                                    <h3 style="margin-top:0px;">Delivery Address</h3>
                                </div>
                                <div class="col-3 invoice_margin">
                                    <div class="line-detail" style="min-height:0px;">
                                        <?php $order_status = 0;
                                        foreach ($order_products as $item) :
                                            if ($item->order_status == 'completed' || $item->order_status == 'cancelled_by_seller' || $item->order_status == 'cancelled_by_user' || $item->order_status == 'rejected') {
                                                $order_status = 1;
                                            }
                                        endforeach;
                                        if ($order_status == 1) : ?>

                                            <a href="<?php echo base_url(); ?>invoice/<?php echo $order->order_number; ?>" target="_blank" class="btn btn-sm btn-info-new btn-sale-options btn-view-invoice"><?php echo trans('view_invoice'); ?></a>
                                        <?php else : ?>

                                            <a href="<?php echo base_url(); ?>invoice/<?php echo $order->order_number; ?>" target="_blank" class="btn btn-sm btn-info-new btn-sale-options btn-view-invoice"><?php echo trans('porforma_invoice'); ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row order-row-item">
                                <div class="col-3">
                                </div>
                                <div class="col-9" style="margin-right:1%;">
                                    <?php $shipping = get_order_shipping($order->id);
                                    if (!empty($shipping)) : ?>
                                        <?php echo $shipping->shipping_first_name . " " . $shipping->shipping_last_name; ?> &nbsp;
                                </div>
                            </div>
                            <div class="row order-row-item">
                                <div class="col-3">
                                </div>
                                <div class="col-9" style="margin-right:1%;">
                                    <div class="address-view"><?php echo $shipping->shipping_address_1 . ", " . $shipping->shipping_landmark . ", " . $shipping->shipping_area; ?></div>
                                    <div class="address-view"><?php echo $shipping->shipping_city . ", " . $shipping->shipping_state . ", " . $shipping->shipping_zip_code . ", " . $shipping->shipping_country; ?> </div>
                                </div>
                            </div>
                            <div class="row order-row-item">
                                <div class="col-3">
                                </div>
                                <div class="col-9" style="margin-right:1%;">
                                    <b> <?php echo $shipping->shipping_phone_number; ?></b>
                                </div>
                            </div>
                            <div class="row order-row-item">
                                <div class="col-3">
                                </div>
                                <div class="col-9" style="margin-right:1%;">
                                    <b> <?php echo $shipping->shipping_email; ?></b>
                                </div>
                            </div>

                        <?php endif; ?>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" style="margin-top: .6%;transform: scale(1.5); margin-left:1%" onclick="show()">
                            <label for="vehicle1" style="margin-left: 1%;font-size: 16px;">Show Billing Address</label><br>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="col-12" id="show-billing" style="backdrop-filter:blur;background-color:#fdfdfda4;border-top-left-radius: 20px;border-bottom-left-radius: 20px;border-bottom-right-radius: 20px;border-top-right-radius: 20px;padding:20px; display:none">
                                <div class="row order-row-item">
                                    <div class="col-9">
                                        <h3>Billing Address</h3>
                                    </div>
                                </div>
                                <div class="row order-row-item">
                                    <div class="col-3">
                                    </div>
                                    <div class="col-9" style="margin-right:1%;">
                                        <?php $shipping = get_order_shipping($order->id);
                                        if (!empty($shipping)) : ?>
                                            <?php echo $shipping->billing_first_name . " " . $shipping->billing_last_name; ?> &nbsp;
                                    </div>
                                </div>
                                <div class="row order-row-item">
                                    <div class="col-3">
                                    </div>
                                    <div class="col-9" style="margin-right:1%;">
                                        <div class="address-view"><?php echo $shipping->billing_address_1 . ", " . $shipping->billing_landmark . ", " . $shipping->billing_area; ?></div>
                                        <div class="address-view"><?php echo $shipping->billing_city . ", " . $shipping->billing_state . ", " . $shipping->billing_zip_code . ", " . $shipping->billing_country; ?> </div>
                                    </div>
                                </div>
                                <div class="row order-row-item">
                                    <div class="col-3">
                                    </div>
                                    <div class="col-9" style="margin-right:1%;">
                                        <b> <?php echo $shipping->billing_phone_number; ?></b>
                                    </div>
                                </div>
                                <div class="row order-row-item">
                                    <div class="col-3">
                                    </div>
                                    <div class="col-9" style="margin-right:1%;">
                                        <b> <?php echo $shipping->billing_email; ?></b>
                                    </div>
                                </div>

                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $is_order_has_physical_product = false; ?>
                <div class="row">
                    <div class="col-6 col-table-orders">
                        <h3 style="margin-left:35px;" class="block-title"><?php echo trans("products"); ?></h3>
                    </div>
                    <div class="row">
                        <div class="col-12 order-details-new-ui" style="width: 92%; margin-left: 4%;">
                            <div class="table-responsive">
                                <table class="table table-orders">
                                    <thead>
                                        <tr>
                                            <th scope="col"><?php echo trans("product"); ?></th>
                                            <th scope="col"><?php echo trans("options"); ?></th>
                                            <th scope="col" style="text-align: center;"><?php echo trans("tracking_status"); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($order_products as $item) :
                                            if ($item->product_type == 'physical') {
                                                $is_order_has_physical_product = true;
                                            } ?>
                                            <tr>
                                                <td style="width: 40%">

                                                    <div class="table-item-product">
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
                                                                <span><?php echo trans("seller"); ?>:</span>
                                                                <?php $seller = get_user($item->seller_id); ?>
                                                                <?php if (!empty($seller)) : ?>
                                                                    <a href="<?php echo generate_profile_url($seller->slug); ?>" target="_blank" class="table-product-title">
                                                                        <strong class="font-600"><?php echo get_shop_name($seller); ?></strong>
                                                                    </a>
                                                                <?php endif; ?>
                                                            </p>
                                                            <!-- <p><span class="span-product-dtl-table"><?php echo trans("price"); ?>:</span><?php echo price_formatted($item->product_unit_price, $item->product_currency); ?></p> -->
                                                            <p><span class="span-product-dtl-table"><?php echo trans("quantity"); ?>:</span><?php echo $item->product_quantity; ?></p>
                                                            <p><span class="span-product-dtl-table"><?php echo trans("total"); ?>:</span><?php echo price_formatted($item->product_total_price, $item->product_currency); ?></p>

                                                            <!-- <?php if ($item->product_type == 'physical') : ?>
                                                                    <p><span class="span-product-dtl-table"><?php echo trans("shipping"); ?>:</span><?php echo price_formatted($item->product_shipping_cost, $item->product_currency); ?></p>
                                                                <?php endif; ?>
                                                                <?php if (!empty($item->product_gst)) : ?>
                                                                    <p><span class="span-product-dtl-table"><?php echo trans("vat"); ?>&nbsp;(<?php echo $item->product_gst_rate; ?>%):</span><?php echo price_formatted($item->product_gst, $item->product_currency); ?></p>
                                                                    <p><span class="span-product-dtl-table"><?php echo trans("total"); ?>:</span><?php echo price_formatted($item->product_total_price, $item->product_currency); ?></p>
                                                                <?php else : ?>
                                                                    <p><span class="span-product-dtl-table"><?php echo trans("total"); ?>:</span><?php echo price_formatted($item->product_total_price, $item->product_currency); ?></p>
                                                                <?php endif; ?> -->
                                                        </div>
                                                    </div>
                                                </td>

                                                <td style="width: 25%;">
                                                    <?php if ($item->order_status == "payment_received" || $item->order_status == "awaiting_payment" || $item->order_status == "processing" || $item->order_status == "waiting") : ?>
                                                        <?php if (get_product($item->product_id)->add_meet == "Made to stock") : ?>
                                                            <button class="btn btn-sm buttons-new" data-id="<?php echo $item->id; ?>" data-toggle="modal" data-target="#rejection_reason_model_<?php echo $item->id; ?>"><?php echo trans("cancel_item"); ?></button>
                                                        <?php elseif (get_product($item->product_id)->add_meet == "Made to order" && $item->order_status == "waiting") : ?>
                                                            <button class="btn btn-sm buttons-new" data-id="<?php echo $item->id; ?>" data-toggle="modal" data-target="#rejection_reason_model_<?php echo $item->id; ?>"><?php echo trans("cancel_item"); ?></button>
                                                        <?php else : ?>
                                                            <button class="btn btn-sm buttons-new" data-id="<?php echo $item->id; ?>" data-toggle="modal" data-target="#rejection_reason_model_made_to_order"><?php echo trans("cancel_item"); ?></button>
                                                        <?php endif; ?>

                                                        <!-- <a data-toggle="modal" data-id="<?php echo $item->id; ?>" class="open-RejectReasonDialog btn btn-md btn-block btn-danger" data-target="#rejection_reason_model"><?php echo trans("cancel_item"); ?></a> -->
                                                    <?php elseif ($item->order_status == "shipped") : ?>
                                                        <button type="submit" class="btn btn-sm btn-custom" onclick="approve_order_product('<?php echo $item->id; ?>','<?php echo trans("confirm_approve_order"); ?>');"><i class="icon-check"></i><?php echo trans("confirm_order_received"); ?></button>
                                                        <small class="text-confirm-order-table"><?php echo trans("confirm_order_received_exp"); ?></small>
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

                                                        <?php if ($this->general_settings->reviews == 1 && $item->seller_id != $item->buyer_id) : ?>
                                                            <div class="row-custom">
                                                                <div class="rate-product">
                                                                    <p class="p-rate-product"><?php echo trans("rate_this_product"); ?></p>
                                                                    <div class="rating-stars">
                                                                        <?php $review = get_review($item->product_id, $this->auth_user->id); ?>
                                                                        <label class="label-star label-star-open-modal" data-star="5" data-product-id="<?php echo $item->product_id; ?>" data-toggle="modal" data-target="#rateProductModal"><i class="<?php echo (!empty($review) && $review->rating >= 5) ? 'icon-star' : 'icon-star-o'; ?>"></i></label>
                                                                        <label class="label-star label-star-open-modal" data-star="4" data-product-id="<?php echo $item->product_id; ?>" data-toggle="modal" data-target="#rateProductModal"><i class="<?php echo (!empty($review) && $review->rating >= 4) ? 'icon-star' : 'icon-star-o'; ?>"></i></label>
                                                                        <label class="label-star label-star-open-modal" data-star="3" data-product-id="<?php echo $item->product_id; ?>" data-toggle="modal" data-target="#rateProductModal"><i class="<?php echo (!empty($review) && $review->rating >= 3) ? 'icon-star' : 'icon-star-o'; ?>"></i></label>
                                                                        <label class="label-star label-star-open-modal" data-star="2" data-product-id="<?php echo $item->product_id; ?>" data-toggle="modal" data-target="#rateProductModal"><i class="<?php echo (!empty($review) && $review->rating >= 2) ? 'icon-star' : 'icon-star-o'; ?>"></i></label>
                                                                        <label class="label-star label-star-open-modal" data-star="1" data-product-id="<?php echo $item->product_id; ?>" data-toggle="modal" data-target="#rateProductModal"><i class="<?php echo (!empty($review) && $review->rating >= 1) ? 'icon-star' : 'icon-star-o'; ?>"></i></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td style="width: 20%;">
                                                    <input type="hidden" value="<?php echo $item->order_status; ?>" id="item_status" name="item_status">
                                                    <div class="fullwidth">
                                                        <div class="separator">
                                                            <ul class="progress-tracker progress-tracker--text progress-tracker--center">
                                                                <li class="progress-step is-active" id="ordered_<?php echo $item->id; ?>">
                                                                    <div class="progress-marker"></div>
                                                                    <div class="progress-text">
                                                                        <h6 class="progress-title">Ordered</h6>

                                                                    </div>
                                                                </li>
                                                                <?php if ($item->order_status == "cancelled_by_user" || $item->order_status == "cancelled_by_seller") : ?>
                                                                    <li class="progress-step is-active" id="cancelled_<?php echo $item->id; ?>">
                                                                        <div class="progress-marker">

                                                                        </div>
                                                                        <div class="progress-text">
                                                                            <h6 class="progress-title">Cancelled</h6>
                                                                        </div>
                                                                    </li>
                                                                <?php else : ?>
                                                                    <li class="progress-step <?php if (in_array($item->order_status, array("processing", "shipped", "completed",))) : echo "is-active";
                                                                                                endif; ?>" id="processing_<?php echo $item->id; ?>">
                                                                        <div class="progress-marker"></div>
                                                                        <div class="progress-text">
                                                                            <h6 class="progress-title">Processing</h6>
                                                                        </div>
                                                                    </li>
                                                                    <li class="progress-step <?php if (in_array($item->order_status, array("shipped", "completed",))) : echo "is-active";
                                                                                                endif; ?>" id="shipped_<?php echo $item->id; ?>">
                                                                        <div class="progress-marker"></div>
                                                                        <div class="progress-text">
                                                                            <h6 class="progress-title">Shipped</h6>
                                                                        </div>
                                                                    </li>
                                                                    <li class="progress-step <?php if (in_array($item->order_status, array("completed",))) : echo "is-active";
                                                                                                endif; ?>" id="delivered_<?php echo $item->id; ?>">
                                                                        <div class="progress-marker"></div>
                                                                        <div class="progress-text">
                                                                            <h6 class="progress-title">Delivered</h6>
                                                                        </div>
                                                                    </li>
                                                                <?php endif; ?>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <?php foreach ($check as $chk) : ?>
                                                    <?php endforeach; ?>
                                                    <?php if (!empty($chk->awb_code)) : ?>
                                                        <button class="btn btn-custom"><a href="<?php echo base_url(); ?>orders/trackstatus/<?php echo $chk->awb_code; ?>" style="color:#fff;">
                                                                Track Shipment Status </a>
                                                        </button>
                                                    <?php else : ?>
                                                        <button type="button" disabled> Track Shipment Status </button> </button>

                                                    <?php endif; ?>

                                                    <br />
                                                    <div class="cake">
                                                        <span>
                                                            <?php if ($item->order_status == "processing" || $item->order_status == "awaiting_pickup") : ?>
                                                                <h6 style="padding-bottom:4%;"><?php echo trans("order_under_process") ?></h6>
                                                            <?php endif; ?>
                                                            <?php if ($item->order_status == "shipped") : ?>
                                                                <h6 style="padding-bottom:4%;"><?php echo trans("order_shipped") ?></h6>
                                                            <?php endif; ?>
                                                            <?php if ($item->order_status == "cancelled_by_user" || $item->order_status == "cancelled_by_seller") : ?>
                                                                <h6 style="padding-bottom:4%;">Your order is cancelled</h6>
                                                            <?php endif; ?>
                                                            <?php if ($item->order_status == "out_for_delivery") : ?>
                                                                <h6 style="padding-bottom:4%;"><?php echo trans("out_delivery") ?></h6>
                                                            <?php endif; ?>
                                                            <?php if ($item->order_status == "completed") : ?>
                                                                <h6 style="padding-bottom:4%;"><?php echo trans("order_delivered") ?></h6>
                                                            <?php endif; ?>
                                                            <!-- <i class="fa fa-star" style="color:#e75480 ;"></i>
                                                                <span style="color:#e75480 ;">Rate & Review the Product</span><br />
                                                                <i class="fa fa-star" style="color:#e75480 ;"></i>
                                                                <span style="color:#e75480 ;">Need Help?</span> -->
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>

                                        <?php endforeach;
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="table-responsive">
                    <h3 class="page-title" style="margin-left:12px;
                    ">Other Items In This Order</h3>
                    <table class="table table-orders summary-section" style="padding: 0 15px;">
                        <!-- 
                            <thead>
                                <tr>
                                    <th scope="col">Product Title</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead> -->
                        <tbody>
                            <?php foreach ($order_products_history as $item) : ?>
                                <?php if ($item->product_type == 'physical') {
                                    $is_order_has_physical_product = true;
                                } ?>
                                <tr class="order-details-new-ui">
                                    <td style="width: 50%">
                                        <div class="table-item-product">
                                            <div class="left">
                                                <div class="img-table">
                                                    <a href="<?php echo generate_product_url_by_slug($item->product_slug); ?>" target="_blank">
                                                        <img src="<?php echo get_product_image($item->product_id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="right">
                                                <a href="<?php echo generate_product_url_by_slug($item->product_slug); ?>" target="_blank" class="table-product-title">
                                                    <?php echo html_escape($item->product_title); ?>
                                                </a>
                                                <p class="m-b-15">
                                                    <span><?php echo trans("seller"); ?>:</span>
                                                    <?php $seller = get_user($item->seller_id); ?>
                                                    <?php if (!empty($seller)) : ?>
                                                        <a href="<?php echo generate_profile_url($seller->slug); ?>" target="_blank" class="table-product-title">
                                                            <strong class="font-600"><?php echo get_shop_name($seller); ?></strong>
                                                        </a>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding-bottom: -1%;">
                                        <?php echo price_formatted($item->product_total_price, $item->product_currency); ?><span>/-</span>
                                    </td>
                                    <td>

                                        <span>
                                            <h6 style="padding-bottom:5%;"><?php echo $item->order_status; ?> on <?php echo date('d M Y', strtotime($item->updated_at)) ?></h6>
                                            <?php if ($item->order_status == "cancelled_by_user") : ?>
                                                <h6 style="color:red; padding-bottom:5%;"><?php echo trans("cancelled_by_user"); ?></h6>
                                            <?php endif; ?>

                                        </span>
                                        <i class="fa fa-star" style="color:#e75480 ;"></i>
                                        <a href="<?php echo generate_url("order_details") . "/" . (10000 + $item->order_id); ?>"><span style="color:#e75480 ;">Rate & Review the Product</span></a><br />
                                        <i class="fa fa-star" style="color:#e75480 ;"></i>
                                        <a href="<?php echo lang_base_url() . 'contact'; ?>"> <span style="color:#e75480 ;">Need Help?</span></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>



            </div>
        </div>

        <!-- <?php if (!empty($shipping)) : ?>
                <p class="text-confirm-order">*<?php echo trans("confirm_order_received_warning"); ?></p>
            <?php endif; ?> -->


    </div>
    <div class="container mobileOrderView">
        <div class="row">
            <div class="col-sm-12">
                <div class="order-details-container">
                    <div class="order-head">
                        <h2 class="title" style="text-align: center;"><?php echo trans("order"); ?>:&nbsp;#<?php echo $order->order_number; ?></h2>
                    </div>
                    <div class="order-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row new-order-ui-for-mobile">
                                    <div class="row order-row-item">
                                        <div class="col-9">
                                            <h3>Delivery Address</h3>
                                        </div>

                                    </div>
                                    <div class="row order-row-item">
                                        <div class="col-3">
                                        </div>
                                        <div class="col-9" style="margin-right:1%;">
                                            <?php $shipping = get_order_shipping($order->id);
                                            if (!empty($shipping)) : ?>
                                                <?php echo $shipping->shipping_first_name . " " . $shipping->shipping_last_name; ?> &nbsp;
                                        </div>
                                    </div>
                                    <div class="row order-row-item">
                                        <div class="col-3">
                                        </div>
                                        <div class="col-9" style="margin-right:1%;">
                                            <div class="address-view"><?php echo $shipping->shipping_address_1 . ", " . $shipping->shipping_landmark . ", " . $shipping->shipping_area; ?></div>
                                            <div class="address-view"><?php echo $shipping->shipping_city . ", " . $shipping->shipping_state . ", " . $shipping->shipping_zip_code . ", " . $shipping->shipping_country; ?> </div>
                                        </div>
                                    </div>
                                    <div class="row order-row-item">
                                        <div class="col-3">
                                        </div>
                                        <div class="col-9" style="margin-right:1%;">
                                            <b> <?php echo $shipping->shipping_phone_number; ?></b>
                                        </div>
                                    </div>
                                    <div class="row order-row-item">
                                        <div class="col-3">
                                        </div>
                                        <div class="col-9" style="margin-right:1%;">
                                            <b> <?php echo $shipping->shipping_email; ?></b>
                                        </div>
                                    </div>

                                <?php endif; ?>
                                </div>

                            </div>
                            <?php $is_order_has_physical_product = true; ?>

                            <div class="col-sm-6 quntity-total-mobile">
                                <div class="order-total summary-section" style="width: 100%;background-color:#fff;">
                                    <div class="row">
                                        <div class="col-6 col-left">
                                            <?php echo trans("subtotal"); ?>
                                        </div>
                                        <div class="col-6 col-right">
                                            <strong class="font-600"><?php echo price_formatted($order->price_subtotal, $order->price_currency); ?></strong>
                                        </div>
                                    </div>
                                    <?php if ($is_order_has_physical_product) : ?>
                                        <div class="row">
                                            <div class="col-6 col-left">
                                                <?php echo trans("shipping"); ?>
                                            </div>
                                            <div class="col-6 col-right">
                                                <strong class="font-600"><?php echo price_formatted($order->price_shipping, $order->price_currency); ?></strong>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row-seperator"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 col-left">
                                            <?php echo trans("total"); ?>
                                        </div>
                                        <div class="col-6 col-right">
                                            <strong class="font-600"><?php echo price_formatted($order->price_subtotal + $order->price_shipping, $order->price_currency); ?></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" style="margin-top: .6%;transform: scale(1.5); margin-left:1%" onclick="show1()">
                                <label for="vehicle1" style="margin-left: 1%;font-size: 16px;">Show Billing Address</label><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row new-order-ui-for-mobile" id="show-billing1" style="display: none;">
                                    <div class="row order-row-item">
                                        <div class="col-9">
                                            <h3>Billing Address</h3>
                                        </div>
                                    </div>
                                    <div class="row order-row-item">
                                        <div class="col-3">
                                        </div>
                                        <div class="col-9" style="margin-right:1%;">
                                            <?php $shipping = get_order_shipping($order->id);
                                            if (!empty($shipping)) : ?>
                                                <?php echo $shipping->billing_first_name . " " . $shipping->billing_last_name; ?> &nbsp;
                                        </div>
                                    </div>
                                    <div class="row order-row-item">
                                        <div class="col-3">
                                        </div>
                                        <div class="col-9" style="margin-right:1%;">
                                            <div class="address-view"><?php echo $shipping->billing_address_1 . ", " . $shipping->billing_landmark . ", " . $shipping->billing_area; ?></div>
                                            <div class="address-view"><?php echo $shipping->billing_city . ", " . $shipping->billing_state . ", " . $shipping->billing_zip_code . ", " . $shipping->billing_country; ?> </div>
                                        </div>
                                    </div>
                                    <div class="row order-row-item">
                                        <div class="col-3">
                                        </div>
                                        <div class="col-9" style="margin-right:1%;">
                                            <b> <?php echo $shipping->billing_phone_number; ?></b>
                                        </div>
                                    </div>
                                    <div class="row order-row-item">
                                        <div class="col-3">
                                        </div>
                                        <div class="col-9" style="margin-right:1%;">
                                            <b> <?php echo $shipping->billing_email; ?></b>
                                        </div>
                                    </div>

                                <?php endif; ?>
                                </div>
                                <?php $is_order_has_physical_product = false; ?>
                                <div class="container">
                                    <div class="col-6 col-table-orders">
                                        <h3 class="block-title"><?php echo trans("products"); ?></h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 summary-section">
                                        <?php foreach ($order_products as $item) :

                                            if ($item->product_type == 'physical') {
                                                $is_order_has_physical_product = true;
                                            } ?>
                                            <div class="new-order-ui-for-mobile table-item-product" style="width: 100%;">
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
                                        <div class="order-total summary-section" style="width: 100%;background-color:#fff;float:right;">
                                            <div class="row">
                                                <div class="col-6 col-left">
                                                    <?php echo trans("quantity"); ?>
                                                </div>
                                                <div class="col-6 col-right">
                                                    <strong class="font-600"><?php echo $item->product_quantity; ?></strong>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 col-left">
                                                    <?php echo trans("total"); ?>
                                                </div>
                                                <div class="col-6 col-right">
                                                    <strong class="font-600"><?php echo price_formatted($order->price_subtotal + $order->price_shipping, $order->price_currency); ?></strong>
                                                </div>
                                            </div>
                                            <?php if ($is_order_has_physical_product) : ?>
                                                <div class="row">
                                                    <div class="col-6 col-left">
                                                        <?php echo trans("status"); ?>
                                                    </div>
                                                    <div class="col-6 col-right">


                                                        <strong class="font-600"><?php echo trans($item->order_status); ?></strong>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <div class="row">
                                                <div class="col-6 col-left">
                                                    Updated At
                                                </div>
                                                <div class="col-6 col-right">
                                                    <strong class="font-600"><?php echo time_ago($item->updated_at); ?></strong>
                                                </div>
                                            </div>
                                            <div class="row" style="text-align:center;">
                                                <?php if ($item->order_status == "payment_received" || $item->order_status == "awaiting_payment" || $item->order_status == "processing" || $item->order_status == "waiting") : ?>
                                                    <?php if (get_product($item->product_id)->add_meet == "Made to stock") : ?>
                                                        <button class="btn btn-sm btn-custom" id="cancel" style="border-color:green;background-color:#fff;" data-id="<?php echo $item->id; ?>" data-toggle="modal" data-target="#rejection_reason_model_<?php echo $item->id; ?>"><?php echo trans("cancel_item"); ?></button>
                                                    <?php elseif (get_product($item->product_id)->add_meet == "Made to order" && $item->order_status == "waiting") : ?>
                                                        <button class="btn btn-sm btn-custom" data-id="<?php echo $item->id; ?>" data-toggle="modal" data-target="#rejection_reason_model_<?php echo $item->id; ?>"><?php echo trans("cancel_item"); ?></button>
                                                    <?php else : ?>
                                                        <button class="btn btn-sm btn-custom" data-id="<?php echo $item->id; ?>" data-toggle="modal" data-target="#rejection_reason_model_made_to_order"><?php echo trans("cancel_item"); ?></button>
                                                    <?php endif; ?>

                                                    <!-- <a data-toggle="modal" data-id="<?php echo $item->id; ?>" class="open-RejectReasonDialog btn btn-md btn-block btn-danger" data-target="#rejection_reason_model"><?php echo trans("cancel_item"); ?></a> -->
                                                <?php elseif ($item->order_status == "shipped" || $item->order_status == "out_for_delivery") : ?>
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
                                                    <?php if ($this->general_settings->reviews == 1 && $item->seller_id != $item->buyer_id) : ?>
                                                        <div class="row-custom">
                                                            <div class="rate-product">
                                                                <p class="p-rate-product"><?php echo trans("rate_this_product"); ?></p>
                                                                <div class="rating-stars">
                                                                    <?php $review = get_review($item->product_id, $this->auth_user->id); ?>
                                                                    <label class="label-star label-star-open-modal" data-star="5" data-product-id="<?php echo $item->product_id; ?>" data-toggle="modal" data-target="#rateProductModal"><i class="<?php echo (!empty($review) && $review->rating >= 5) ? 'icon-star' : 'icon-star-o'; ?>"></i></label>
                                                                    <label class="label-star label-star-open-modal" data-star="4" data-product-id="<?php echo $item->product_id; ?>" data-toggle="modal" data-target="#rateProductModal"><i class="<?php echo (!empty($review) && $review->rating >= 4) ? 'icon-star' : 'icon-star-o'; ?>"></i></label>
                                                                    <label class="label-star label-star-open-modal" data-star="3" data-product-id="<?php echo $item->product_id; ?>" data-toggle="modal" data-target="#rateProductModal"><i class="<?php echo (!empty($review) && $review->rating >= 3) ? 'icon-star' : 'icon-star-o'; ?>"></i></label>
                                                                    <label class="label-star label-star-open-modal" data-star="2" data-product-id="<?php echo $item->product_id; ?>" data-toggle="modal" data-target="#rateProductModal"><i class="<?php echo (!empty($review) && $review->rating >= 2) ? 'icon-star' : 'icon-star-o'; ?>"></i></label>
                                                                    <label class="label-star label-star-open-modal" data-star="1" data-product-id="<?php echo $item->product_id; ?>" data-toggle="modal" data-target="#rateProductModal"><i class="<?php echo (!empty($review) && $review->rating >= 1) ? 'icon-star' : 'icon-star-o'; ?>"></i></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="fullwidth">

                                                <div class="container separator">
                                                    <h6 id="track_status">Tracking Status</h6>
                                                    <!-- <ul class="progress-tracker progress-tracker--text progress-tracker--center" style="position: relative; right: 42px;"> -->
                                                    <ul class="progress-tracker progress-tracker--text progress-tracker--center">
                                                        <li class="progress-step is-active" id="ordered_<?php echo $item->id; ?>">
                                                            <div class="progress-marker"></div>
                                                            <div class="progress-text">
                                                                <h6 class="progress-title">Ordered</h6>

                                                            </div>
                                                        </li>
                                                        <?php if ($item->order_status == "cancelled_by_user" || $item->order_status == "cancelled_by_seller") : ?>
                                                            <li class="progress-step is-active" id="cancelled_<?php echo $item->id; ?>">
                                                                <div class="progress-marker"></div>
                                                                <div class="progress-text">
                                                                    <h6 class="progress-title">Cancelled</h6>
                                                                </div>
                                                            </li>
                                                        <?php else : ?>
                                                            <li class="progress-step <?php if (in_array($item->order_status, array("processing", "shipped", "completed",))) : echo "is-active";
                                                                                        endif; ?>" id="processing_<?php echo $item->id; ?>">
                                                                <div class="progress-marker"></div>
                                                                <div class="progress-text">
                                                                    <h6 class="progress-title">Processing</h6>
                                                                </div>
                                                            </li>
                                                            <li class="progress-step <?php if (in_array($item->order_status, array("shipped", "completed",))) : echo "is-active";
                                                                                        endif; ?>" id="shipped_<?php echo $item->id; ?>">
                                                                <div class="progress-marker"></div>
                                                                <div class="progress-text">
                                                                    <h6 class="progress-title">Shipped</h6>
                                                                </div>
                                                            </li>
                                                            <li class="progress-step <?php if (in_array($item->order_status, array("completed",))) : echo "is-active";
                                                                                        endif; ?>" id="delivered_<?php echo $item->id; ?>">
                                                                <div class="progress-marker"></div>
                                                                <div class="progress-text">
                                                                    <h6 class="progress-title">Delivered</h6>
                                                                </div>
                                                            </li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <br />

                                        </div>
                                    <?php endforeach; ?>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->

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
                                    endif; ?>>
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
<!-- Modal -->
<div class="modal fade" id="reportPaymentModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-custom">
            <!-- form start -->
            <?php echo form_open_multipart('bank-transfer-payment-report-post'); ?>
            <div class="modal-header">
                <h5 class="modal-title"><?php echo trans("report_bank_transfer"); ?></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true"><i class="icon-close"></i> </span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="order_number" class="form-control form-input" value="<?php echo $order->order_number; ?>">
                <div class="form-group">
                    <label><?php echo trans("payment_note"); ?></label>
                    <textarea name="payment_note" class="form-control form-textarea" maxlength="499"></textarea>
                </div>
                <div class="form-group">
                    <label><?php echo trans("receipt"); ?>
                        <small>(.png, .jpg, .jpeg)</small>
                    </label>
                    <p>
                        <a class='btn btn-md btn-secondary btn-file-upload'>
                            <?php echo trans('select_image'); ?>
                            <input type="file" name="file" size="40" accept=".png, .jpg, .jpeg" onchange="$('#upload-file-info').html($(this).val());">
                        </a><br>
                        <span class='badge badge-info' id="upload-file-info"></span>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-red" data-dismiss="modal"><?php echo trans("close"); ?></button>
                <button type="submit" class="btn btn-md btn-custom"><?php echo trans("submit"); ?></button>
            </div>
            <?php echo form_close(); ?>
            <!-- form end -->
        </div>
    </div>
</div>

<?php $this->load->view('partials/_modal_rate_product'); ?>

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

    function show1() {
        var checkBox = document.getElementById("vehicle1");
        var text = document.getElementById("show-billing1");
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