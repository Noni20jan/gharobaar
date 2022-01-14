<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php
$seller_wise_data = get_shipping_cod_changes_seller_wise($this->auth_user->id, $order->id);
// var_dump($seller_wise_data);
if (!empty($seller_wise_data)) :
    $seller_shipping_cod = ($seller_wise_data->total_shipping_cost + $seller_wise_data->total_cod_cost) / 100;
endif;
?>

<style>
    .dispatch_alert {
        color: red;
    }

    .dispatch_late {
        color: red;
    }

    .ajax-loader {
        visibility: hidden;
        background-color: rgba(255, 255, 255, 0.7);
        position: absolute;
        z-index: +100 !important;
        width: 100%;
        height: 100%;
    }

    .left {
        width: 20%;
    }

    .ajax-loader img {
        position: relative;
        top: 35%;
        left: 54%;

    }

    #new-shipping-style {
        background-color: #fdfdfda4;
        border-radius: 20px;
        padding: 20px;
        margin-left: 15px;

        width: 48%;
        margin-bottom: 2%;
    }

    #new-billing-style {
        background-color: #fdfdfda4;
        border-radius: 20px;
        padding: 20px;
        margin-right: 15px;
        width: 48%;
        margin-bottom: 2%;
        float: right;
    }

    .line-detail {
        position: relative;
        display: flex;
        width: 100%;
        float: left;
        min-height: 36px;
    }

    @media(max-width:768px) {
        #new-shipping-style {
            backdrop-filter: blur;
            background-color: #fdfdfda4;
            border-radius: 20px;
            right: 23px;
            padding: 20px;
            width: 100%;
            margin-bottom: 2%;
        }

        #new-billing-style {
            backdrop-filter: blur;
            background-color: #fdfdfda4;
            border-radius: 20px;
            padding: 20px;
            left: 4px;
            width: 100%;
            margin-bottom: 2%;
        }



        .left {
            width: 50%;
        }

        .line-detail {
            position: relative;
            display: flex;
            width: 100%;
            float: left;
            min-height: 36px;
            justify-content: space-between;
        }

        .line-detail .vertical-center {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    }

    .line-detail-2 {
        position: relative;
        display: block;
        width: 100%;
        float: left;
        min-height: 36px;
    }
</style>

<!-- <div class="ajax-loader">
    <img src="<?php echo base_url(); ?>assets/gif/ajax-loader.gif" id="loader-img" />
</div> -->
<div id="cover-spin"></div>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= trans("sale"); ?>:&nbsp;#<?php echo $order->order_number; ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="row m-b-30">

            <div class="line-detail">
                <!-- <div> -->
                <div class="vertical-center">
                    <span><?php echo trans("status"); ?></span>
                </div>
                <?php $order_status = 0;
                foreach ($order_products as $item) :
                    if ($item->order_status == 'completed' || $item->order_status == 'cancelled_by_seller' || $item->order_status == 'cancelled_by_user' || $item->order_status == 'rejected') {
                        $order_status = 1;
                    }
                endforeach;
                if ($order_status == 1) : ?>
                    <div class="vertical-center">
                        <label class="label label-default"><?= trans("completed"); ?></label>
                    </div>
                    <div class="vertical-center">
                        <a href="<?php echo base_url(); ?>invoice/<?php echo $order->order_number; ?>" target="_blank" class="btn btn-sm btn-info btn-sale-options btn-view-invoice"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;<?php echo trans('view_invoice'); ?></a>
                    </div>
                <?php else : ?>
                    <div class="vertical-center">
                        <label class="label label-success"><?= trans("order_processing"); ?></label>
                    </div>
                    <div class="vertical-center">
                        <a href="<?php echo base_url(); ?>invoice/<?php echo $order->order_number; ?>" target="_blank" class="btn btn-sm btn-info btn-sale-options btn-view-invoice"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;<?php echo trans('porforma_invoice'); ?></a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- <div class="line-detail">
                <div class="left">
                    <span><?= trans("payment_status"); ?></span>
                </div>
                <strong class="font-600"><?= trans($order->payment_status); ?></strong>
            </div> -->
            <div class="line-detail">
                <div class="left">
                    <span><?= trans("payment_method"); ?></span>
                </div>
                <?= get_payment_method($order->payment_method); ?>
            </div>
            <div class="line-detail">
                <div class="left">
                    <span><?= trans("date"); ?></span>
                </div>
                <?= formatted_date($order->created_at); ?>
            </div>

            <div class="line-detail">
                <div class="left">
                    <span><?= trans("updated"); ?></span>
                </div>
                <?= time_ago($order->updated_at); ?>
            </div>

            <!-- <div class="col-sm-6">
                <div class="col-sm-6" style="float: right;">
                    <button type="button" class="btn btn-md btn-block btn-info" onclick="nowBike_create_order('<?php echo $order->id; ?>')"> Schedule for Shipment </button>
                    <button type="button" class="btn btn-md btn-block btn-danger" onclick="nowBike_cancle_order()"> Cancle Shipment </button>
                </div>
            </div> -->
        </div>

        <?php $shipping = get_order_shipping($order->id);

        $shipping_json = json_encode($shipping);

        if (!empty($shipping)) : ?>
            <div class="row">
                <div class="col-md-6" id="new-shipping-style">
                    <div class="col-sm-12">
                        <h3 class="block-title"><?php echo trans("shipping_address"); ?></h3>
                        <div class="row order-row-item">
                            <div class="col-3">
                            </div>
                            <div class="col-9">

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
                    </div>
                </div>

                <div class="col-md-6" id="new-billing-style">
                    <div class="col-sm-12">
                        <h3 class="block-title"><?php echo trans("billing_address"); ?></h3>

                        <div class="row order-row-item">
                            <div class="col-3">
                            </div>
                            <div class="col-9" style="margin-right:1%;">

                                <?php echo $shipping->billing_first_name . " " . $shipping->billing_last_name; ?>
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
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- check for schedule shipment buttom -->
        <?php
        $show = 0;
        foreach ($order_products as $item) :
            if ($item->seller_id == $this->auth_user->id) :
                $shiprocket_order_details = get_shiprocket_order_details($order->id, $item->product_id);
                $now_bike_data = get_nowBike_order_details($order->order_number, $item->id);

                if (empty($shiprocket_order_details) && empty($now_bike_data)) :
                    $show = 1;
                endif;
            endif;
        endforeach;
        ?>
        <div class="row">
            <div class="pull-right">
                <?php if ($item->product_delivery_partner == "SHIPROCKET") : ?>
                    <?php if ($show && $item->order_status == "processing") : ?>
                        <button class="btn btn-md btn-block btn-info btn-table-delete" id="schedule_sipment" onclick="Schedule_Multiple_shipment()">Schedule Shipment</button>
                    <?php endif; ?>
                <?php elseif ($item->product_delivery_partner == "NOW-BIKES") : ?>
                    <?php if ($show) : ?>
                        <button class="btn btn-md btn-block btn-info btn-table-delete" id="schedule_sipment" onclick="Schedule_Multiple_shipment()">Schedule Shipment</button>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php if (($item->product_delivery_partner) == "SHIPROCKET") : ?>
            <?php if (empty($shiprocket_order_details)) : ?>
                <?php $product = get_product($item->product_id); ?>
                <?php $current_date = new DateTime(); ?>
                <?php $order_date = strtotime($order->created_at); ?>
                <?php $ordered_date = date("dS M Y", $order_date); ?>
                <?php $shipping_time = $product->shipping_time; ?>

                <?php if (substr_count($shipping_time, "_") > 2) : ?>
                    <?php $ship_time = intval($product->shipping_time[2]); ?>
                    <?php $created_at = strtotime($order->created_at); ?>

                    <?php $order_create = strtotime("$ship_time day", strtotime($order->created_at)); ?>

                    <?php $ship_date = (date("dS M Y", $order_create)); ?>
                    <?php $shipping_date = new DateTime($ship_date); ?>

                    <?php if ($item->order_status == 'processing') : ?>

                        <?php if ($shipping_date > $current_date) : ?>

                            <p class="dispatch_alert"><b>Kindly Schedule the shipment by <?php echo $ship_date; ?></b></p>

                        <?php else : ?>

                            <p class="dispatch_late">SLA Breached – You were unable to schedule the shipment by its due date. Penalty of Rs. 200 for this order shall be charged as per the terms of the agreement.

                                **<br />

                                ** Kindly take note that the seller has to only schedule shipment on or before the due date. If the pickup was not done on time by the Shipping Partners, then no penalty will be levied on the seller.
                            </p>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php elseif (substr_count($shipping_time, "_") == 2) : ?>
                    <?php $shipped_time = intval($product->shipping_time); ?>
                    <?php $created_at = strtotime($order->created_at); ?>
                    <?php $order_create = strtotime("$shipped_time day", $created_at); ?>
                    <?php $shipped_date = (date("dS M Y", $order_create)); ?>
                    <?php $shipp_date = new DateTime($shipped_date); ?>
                    <?php if ($item->order_status == 'processing') : ?>

                        <?php if ($shipp_date > $current_date) : ?>
                            <p class="dispatch_alert"><b>Kindly Schedule the shipment by <?php echo $shipped_date; ?></b></p>

                        <?php else : ?>

                            <p class="dispatch_late">SLA Breached – You were unable to schedule the shipment by its due date. Penalty of Rs. 200 for this order shall be charged as per the terms of the agreement.

                                **<br />

                                ** Kindly take note that the seller has to only schedule shipment on or before the due date. If the pickup was not done on time by the Shipping Partners, then no penalty will be levied on the seller.
                            </p>
                        <?php endif; ?>
                    <?php endif; ?>

                <?php else : ?>
                    <p></p>
                <?php endif; ?>
            <?php endif; ?>

        <?php endif; ?>

        <div class="row">
            <div class="col-sm-12">
                <h3 class="block-title"><?php echo trans("products"); ?></h3>
                <div class="table-responsive">
                    <table class="table table-orders">
                        <thead>
                            <tr>
                                <!-- <th width="20"><input type="checkbox" class="checkbox-table" id="checkAll"></th> -->
                                <th></th>
                                <th scope="col"><?php echo trans("product"); ?></th>
                                <th scope="col"><?php echo trans("status"); ?></th>
                                <th scope="col"><?php echo trans("reject_reason"); ?></th>
                                <th scope="col"><?php echo trans("payment_status"); ?></th>

                                <th scope="col"><?php echo trans("updated"); ?></th>
                                <th scope="col"><?php echo trans("options"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sale_subtotal = 0;
                            $sale_gst = 0;
                            $sale_shipping = 0;
                            $sale_total = 0;
                            $sale_discount = 0;
                            $product_index = 0;
                            foreach ($order_products as $item) :
                                if ($item->seller_id == $this->auth_user->id) :
                                    $sale_subtotal += $item->product_unit_price * $item->product_quantity;
                                    $sale_gst += $item->product_gst;
                                    $sale_shipping = $item->product_shipping_cost;
                                    $sale_discount += $item->product_discount_amount * $item->product_quantity;
                                    $sale_total += $item->product_total_price;
                                    $product_details = get_product($item->product_id);
                                    // var_dump(json_encode($product_details));
                            ?>

                                    <tr>
                                        <td><input type="checkbox" <?php if ($item->order_status != "processing") {
                                                                        echo "disabled";
                                                                    } ?> name="checkbox-table" class="checkbox-table" value="<?php echo $item->id; ?>" checked style="display: none;"></td>
                                        <td style="width: 50%">
                                            <div class="table-item-product">
                                                <div class="left">
                                                    <?php $variation_option = generate_product_variation_image($item);
                                                    if (!empty($variation_option)) :
                                                        if ($variation_option->is_default != 0) : ?>
                                                            <a href="<?php echo generate_product_url_by_slug($item->product_slug); ?>" target="_blank">
                                                                <img src="<?php echo get_product_image($item->product_id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                                                            </a>
                                                        <?php else : ?>
                                                            <a href="<?php echo generate_product_url_by_slug($item->product_slug); ?>">
                                                                <img src="
                                                                
                                                                
                                                                <?php echo get_variation_main_option_image_url($variation_option, null); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
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
                                                    <p><span class="span-product-dtl-table"><?php echo trans("unit_price"); ?>:</span><?php echo price_formatted($item->price_after_discount, $item->product_currency); ?></p>
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
                                            <?php if ($item->expected_delivery_date != "") : ?>
                                                <div class="order-shipping-tracking-number">
                                                    <p><strong><?php echo "Estimated Delivery Date:" ?></strong>&nbsp;&nbsp;<?php echo ($item->expected_delivery_date) ?></p>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($item->expected_delivery_time != "") : ?>
                                                <div class="order-shipping-tracking-number">
                                                    <p><strong><?php echo "Estimated Delivery Time:" ?></strong>&nbsp;&nbsp;<?php echo ($item->expected_delivery_time) ?></p>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($item->additional_info != "") : ?>
                                                <div class="order-shipping-tracking-number">
                                                    <p><strong><?php echo "Customisation Details:" ?></strong>&nbsp;&nbsp;<?php echo ($item->additional_info) ?></p>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($item->product_delivery_partner == "NOW-BIKES") : ?>
                                                <?php $now_bike_data = get_nowBike_order_details($order->order_number, $item->id); ?>
                                                <?php if (!empty($now_bike_data)) : ?>
                                                    <div class="order-shipping-tracking-number">
                                                        <p><strong><?php echo trans("now_bike_msg") ?></strong></p>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if ($product_details->add_meet == "Made to order" && $item->order_status == "waiting") : ?>
                                                <p class="text-more-visible"><strong><?php echo trans("time_left") ?>:&nbsp;&nbsp;</strong><span id="demo_<?= $item->id ?>"></span></p>

                                                <?php
                                                $start_time_text = $this->general_settings->bussiness_start_at;
                                                $end_time_text = $this->general_settings->bussiness_end_at;

                                                $start_time = strtotime($start_time_text);
                                                $end_time = strtotime($end_time_text);

                                                $time_window = $this->general_settings->time_window;


                                                $order_created_time = $item->created_at;
                                                $order_timestamp = strtotime($order_created_time);

                                                $one_day_seconds = strtotime('1 day', 0);

                                                $order_time = explode(" ", $order_created_time);

                                                if (strtotime($order_time[1]) < $start_time) {
                                                    $date = $start_time + $time_window;
                                                    $date_str = date('Y-m-d H:i:s', $date);
                                                } elseif ($start_time <= strtotime($order_time[1]) &&  strtotime($order_time[1]) < $end_time) {
                                                    if (($end_time - $order_timestamp) >= $time_window && ($end_time - $order_timestamp) < $one_day_seconds) :
                                                        $date_str = date('Y-m-d H:i:s', $order_timestamp + $time_window);
                                                    else :
                                                        $date = $start_time + $time_window - ($end_time - strtotime($order_time[1]));
                                                        $date_str = date('Y-m-d H:i:s', $date);
                                                    endif;
                                                } else {
                                                    if ($order_timestamp < $start_time) :
                                                        $date = $start_time + $time_window;
                                                        $date_str = date('Y-m-d H:i:s', $date);
                                                    else :
                                                        $date = $start_time + $one_day_seconds + $time_window;
                                                        $date_str = date('Y-m-d H:i:s', $date);
                                                    endif;
                                                }

                                                ?>
                                                <script>
                                                    // Set the date we're counting down to
                                                    var countDownDate = new Date("<?= $date_str; ?>").getTime();

                                                    var x = setInterval(function() {
                                                        // Get today's date and time
                                                        var now = new Date().getTime();
                                                        // Find the distance between now and the count down date
                                                        var distance = countDownDate - now;
                                                        // Time calculations for days, hours, minutes and seconds
                                                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                                        if (distance < 0) {
                                                            var days = 0;
                                                            var hours = 0;
                                                            var minutes = 0;
                                                            var seconds = 0;
                                                        }

                                                        // Display the result in the element with id="demo"
                                                        if (days > 0) {
                                                            document.getElementById("demo_<?= $item->id ?>").innerHTML = days + "d " + hours + "h " +
                                                                minutes + "m " + seconds + "s ";
                                                        } else {
                                                            document.getElementById("demo_<?= $item->id ?>").innerHTML = hours + "h " +
                                                                minutes + "m " + seconds + "s ";
                                                        }

                                                        // If the count down is finished, write some text
                                                        if (distance < 0) {
                                                            var order_id = parseInt(<?= $item->order_id; ?>);
                                                            var product_id = parseInt(<?= $item->product_id; ?>);

                                                            var data = {
                                                                "order_id": order_id,
                                                                "product_id": product_id,
                                                                "sys_lang_id": sys_lang_id
                                                            };
                                                            data[csfr_token_name] = $.cookie(csfr_cookie_name);

                                                            var url = base_url + "update-order-status-after-timer-up";
                                                            $('#cover-spin').show();
                                                            $.ajax({
                                                                url: url,
                                                                type: "post",
                                                                data: data,
                                                                success: function(e) {
                                                                    var res = JSON.parse(e);
                                                                    location.reload();
                                                                    $('#cover-spin').hide();
                                                                    clearInterval(x);
                                                                }
                                                            })
                                                            clearInterval(x);
                                                            // location.reload();
                                                        }
                                                    }, 1000);
                                                </script>
                                            <?php endif; ?>

                                        </td>
                                        <td style="width: 10%">
                                            <strong><?php echo trans($item->order_status); ?></strong>
                                        </td>
                                        <td style="width: 10%">
                                            <?php if ($item->order_status == "rejected" || "cancelled_by_user") : ?>

                                                <strong>

                                                    <!-- </?php
                                                            // if (!empty($item->reject_reason)) {
                                                            //     if (get_reason($item->reject_reason) != "Other") {
                                                            //         echo get_reason($item->reject_reason);
                                                            //     }
                                                            // }
                                                             ?> -->

                                                    <?php if ($item->reject_reason != null) : ?>
                                                        <strong><?php echo get_reason($item->reject_reason) ?></strong>
                                                    <?php elseif ($item->reject_reason_before_accept != null) : ?>
                                                        <strong><?php echo get_reason($item->reject_reason_before_accept) ?>s</strong>
                                                    <?php endif; ?>


                                                </strong>
                                            <?php endif; ?>
                                        </td>
                                        <td style="width: 10%">

                                            <?php
                                            $order_detail = $this->order_model->get_order_detail_by_id($item->order_id);
                                            $payment_method = $order_detail[0]->payment_method;
                                            $transaction_detail = $this->order_model->get_transaction_detail($item->order_id);
                                            ?>



                                            <strong><?php echo trans($item->payment_status); ?></strong>
                                            <?php if ($payment_method == "Cashfree") : ?>
                                                <strong><?php echo "Ref. Id: " . $transaction_detail[0]->payment_id; ?></strong>
                                            <?php endif; ?>
                                            <?php if ($item->payment_status == "payment_received" && ($item->order_status == "rejected" || $item->order_status == "cancelled_by_user" || $item->order_status == "cancelled_by_seller")) : ?>
                                                <?php if (!empty(get_refund_message($item->order_id, $item->product_id))) : ?>
                                                    <?php if (get_refund_message($item->order_id, $item->product_id)->status == "OK") : ?>
                                                        <strong>(<?php echo get_refund_message($item->order_id, $item->product_id)->message ?>)</strong>
                                                    <?php elseif (get_refund_message($item->order_id, $item->product_id)->status == "ERROR") : ?>
                                                        <strong>(<?php echo trans("refund_error_msg") ?>)</strong>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td style="width: 15%">
                                            <?php if ($item->product_type == 'physical') {
                                                echo time_ago($item->updated_at);
                                            } ?>
                                        </td>
                                        <td style="width: 25%">
                                            <?php if ($item->order_status == "completed") : ?>
                                                <strong class="font-600"><i class="icon-check"></i>&nbsp;<?php echo trans("approved"); ?></strong>
                                            <?php elseif ($item->order_status == "rejected") : ?>
                                                <strong class="font-600"><i class="icon-check"></i>&nbsp;<?php echo "Rejected"/*trans("rejected")*/; ?></strong>
                                            <?php elseif ($item->order_status == "cancelled_by_seller") : ?>
                                                <strong class="font-600"><i class="icon-check"></i>&nbsp;<?php echo "Cancelled"/*trans("rejected")*/; ?></strong>
                                            <?php elseif ($item->order_status == "cancelled_by_user") : ?>
                                                <p></p>
                                            <?php else : ?>
                                                <?php if ($item->order_status == "waiting") : ?>
                                                    <?php echo form_open('order_controller/accept_reject_order_product'); ?>
                                                    <input type="hidden" value='<?php echo $item->id; ?>' name="order_product_id">

                                                    <p class="m-b-5">
                                                        <button type="submit" value="accept" name="submit" class="btn btn-md btn-block btn-success">Accept</button>
                                                    </p>
                                                    <p class="m-b-5">
                                                        <a data-toggle="modal" data-id="<?php echo $item->id; ?>" class="open-RejectReasonDialog btn btn-md btn-block btn-danger" data-target="#rejection_reason_model">Reject</a>
                                                    </p>
                                                    <?php echo form_close(); ?>
                                                <?php else : ?>
                                                    <p class="m-b-5">
                                                        <button type="button" class="btn btn-md btn-block btn-success" data-toggle="modal" data-target="#updateStatusModal_<?php echo $item->id; ?>"><?php echo trans('update_order_status'); ?></button>
                                                    </p>

                                                    <div id='loader' style='display: none;'>
                                                        <img src='reload.gif' width='32px' height='32px'>
                                                    </div>
                                                    <!-- Image loader -->

                                                    <div class='response'></div>

                                                    <?php if ($item->product_delivery_partner == "SHIPROCKET") : ?>
                                                        <?php $shiprocket_order_details = get_shiprocket_order_details($order->id, $item->product_id); ?>

                                                        <?php if (!empty($shiprocket_order_details) && $shiprocket_order_details->is_active == 1) : ?>
                                                            <?php if (!empty($shiprocket_order_details->awb_code)) : ?>
                                                                <p class="m-b-5">
                                                                    <button type="button" style="width:100%; border-radius:20px; color:white" class="btn btn-md btn-block btn-warning"><a style="color:white" href="<?php echo $shiprocket_order_details->manifest_url ?>">Download Manifest</a></button>
                                                                </p>
                                                                <p class="m-b-5">
                                                                    <button type="button" style="width:100%; border-radius:20px; color:white" class="btn btn-md btn-block btn-dark"><a style="color:white" href="<?php echo $shiprocket_order_details->label_url ?>">Download Label</a></button>
                                                                </p>
                                                            <?php endif; ?>

                                                            <p class="m-b-5">
                                                                <button type="button" style="width:100%;" class="btn btn-md btn-block btn-primary" data-toggle="modal"><a style="color:white" href="<?php echo base_url(); ?>dashboard/track_status/<?php echo $shiprocket_order_details->awb_code ?>"> Track Status </a></button>
                                                            </p>
                                                            <?php if (!empty($shiprocket_order_details->awb_code)) : ?>
                                                                <p class="m-b-5">
                                                                    <button type="button" class="btn btn-md btn-block btn-danger" onclick="shiprocket_cancel_order('<?php echo $shiprocket_order_details->shipment_order_id; ?>','Are you sure you want to cancel the shipment?')"> Cancel Shipment </button>
                                                                </p>
                                                            <?php endif; ?>
                                                        <?php endif; ?>



                                                    <?php elseif ($item->product_delivery_partner == "NOW-BIKES") : ?>

                                                        <?php $now_bike_data = get_nowBike_order_details($order->order_number, $item->id); ?>

                                                        <?php if (!empty($now_bike_data)) : ?>
                                                            <p class="m-b-5">
                                                                <button type="button" class="btn btn-md btn-block btn-primary" onclick="nowBike_get_order_details('<?php echo $now_bike_data->now_bike_id; ?>',$(this))"> Check Status </button>
                                                            </p>
                                                            <p class="m-b-5">
                                                                <button type="button" class="btn btn-md btn-block btn-danger" onclick="nowBike_cancle_order('<?php echo $now_bike_data->now_bike_id; ?>','Are you sure you want to cancel the shipment?')"> Cancel Now-Bike Shipment </button>
                                                            </p>
                                                        <?php endif; ?>

                                                    <?php endif; ?>
                                                    <p class="m-b-5">



                                                        <?php $is_made_to_order = false;
                                                        $product = get_product($item->product_id); ?>

                                                        <?php if ($product->add_meet == "Made to order" || $product->add_meet == "Made to stock") :
                                                            $is_made_to_order = true;
                                                        endif; ?>
                                                        <?php if ($is_made_to_order) : ?>
                                                            <button type="button" style="width:100%;" class="btn btn-md btn-block btn-danger" data-toggle="modal" data-target="#made_to_order_cancel_warning_<?php echo $item->id; ?>"> Cancel Order </button>
                                                            <!-- <a href="#" class="btn btn-block" data-toggle="modal" data-target="#made_to_order_checkout"> <strong><?php echo trans("continue_to_checkout"); ?> </strong></a> -->
                                                        <?php else : ?>


                                                            <button type="button" style="width:100%;" class="btn btn-md btn-block btn-danger" data-toggle="modal" data-target="#cancelOrderModal_<?php echo $item->id; ?>"> Cancel Order </button>
                                                        <?php endif; ?>
                                                    </p>





                                                    <?php if ($item->product_type == 'physical') : ?>
                                                        <!-- <p>
                                                            <button type="button" class="btn btn-md btn-block btn-primary" data-toggle="modal" data-target="#addTrackingNumberModal_<?php echo $item->id; ?>"><?php echo trans('add_tracking_number'); ?></button>
                                                        </p> -->
                                                    <?php endif; ?>
                                                <?php endif; ?>

                                            <?php endif; ?>
                                        </td>
                                    </tr>


                                    <?php if ($item->order_status == "waiting" || $item->order_status == "processing" || $item->order_status == "awaiting_pickup" || $item->order_status == "shipped" || $item->order_status == "out_for_delivery" || $item->order_status == "completed") : ?>
                                        <?php $chk = get_shiprocket_order_details($order->id, $item->product_id); ?>
                                        <?php if (!empty($chk) && $chk->is_active == 1) : ?>

                                            <tr class="tr-shipping">

                                                <td colspan="6">


                                                    <div class="order-shipping-tracking-number">

                                                        <p><strong><?php echo trans("shipping") ?></strong></p>
                                                        <p> <?php echo trans("tracking_number") ?>:&nbsp;<?php echo $chk->awb_code; ?></a></p>
                                                        <p> <?php echo trans("courier_name") ?>:&nbsp;<?php echo $chk->courier_company_name; ?></a></p>
                                                        <p> <?php echo trans("pickup_scheduled_date") ?>:&nbsp;<?php echo $chk->pickup_scheduled_date; ?></a></p>
                                                        <?php if (!empty($chk->pickup_token_number)) : ?>
                                                            <p> <?php echo trans("pickup_token_number") ?>:&nbsp;<?php echo $chk->pickup_token_number; ?></a></p>
                                                        <?php else : ?>
                                                            <!-- <p> <?php echo trans("pickup_token_number") ?>:&nbsp;<?php echo $chk->pickup_token_number; ?></a></p> -->
                                                        <?php endif; ?>
                                                        <p> <?php echo trans("shipment_id") ?>:&nbsp;<?php echo $chk->shipment_id; ?></a></p>






                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="tr-shipping-seperator">
                                                <td colspan="4"></td>
                                            </tr>


                                        <?php endif; ?>
                                    <?php else : ?>
                                        <!-- <p>Awb code not generated</p> -->
                                    <?php endif; ?>

                                    <?php if ($item->order_status == "shipped" && $item->product_delivery_partner == "SELF") : ?>
                                        <tr class="tr-shipping">
                                            <td colspan="4">
                                                <div class="order-shipping-tracking-number">
                                                    <p><strong><?php echo trans("shipping") ?></strong></p>
                                                    <p><?php echo trans("tracking_number") ?>:&nbsp;<?php echo html_escape($item->shipping_tracking_number); ?></p>
                                                    <p class="m-0"><?php echo trans("url") ?>: <a href="<?php echo html_escape($item->shipping_tracking_url); ?>" target="_blank" class="link-underlined"><?php echo html_escape($item->shipping_tracking_url); ?></a></p>
                                                    <p class="m-0">Courier Service: &nbsp;<?php echo html_escape($item->self_courier_service); ?> </p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="tr-shipping-seperator">
                                            <td colspan="4"></td>
                                        </tr>
                                    <?php endif; ?>

                            <?php endif;
                                $product_index++;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="order-total">
                    <div class="row">
                        <div class="col-sm-6 col-xs-6 col-left">
                            <?php echo trans("subtotal"); ?>
                        </div>
                        <div class="col-sm-6 col-xs-6 col-right">
                            <strong><?php echo price_formatted($sale_subtotal, $order->price_currency); ?>/-</strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-xs-6 col-left">
                            <?php echo trans("discount"); ?>
                        </div>

                        <div class="col-sm-6 col-xs-6 col-right">
                            <strong><?php echo price_formatted($sale_discount * 100, $order->price_currency); ?>/-</strong>
                        </div>
                    </div>

                    <?php if ($order->payment_method == "Cash On Delivery") : ?>

                        <div class="row">
                            <div class="col-sm-6 col-xs-6 col-left">
                                <strong><?php echo "COD Charges"; ?></strong>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-right">
                                <span class="float-right"><?php echo price_formatted_without_round($order->total_cod_charges, $this->payment_settings->default_currency); ?>/-</span></strong>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($order->total_tax_charges > 0) : ?>
                        <div class="row">
                            <div class="col-sm-6 col-xs-6 col-left">
                                <strong><?php echo "Taxes"; ?></strong>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-right">
                                <strong><span class="float-right"><?php echo price_formatted_without_round($order->total_tax_charges, $this->payment_settings->default_currency); ?>/-</span></strong>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-sm-6 col-xs-6 col-left">
                            <strong><?php echo "Coupon Discount"; ?></strong>
                        </div>

                        <div class="col-sm-6 col-xs-6 col-right">
                            <strong>-<?php echo price_formatted($order->coupon_discount, $order->price_currency); ?>/-</strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 m-b-15">
                            <div class="row-seperator"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6 col-left">
                            <?php echo trans("total"); ?>
                        </div>
                        <div class="col-sm-6 col-xs-6 col-right">
                            <strong><?php echo price_formatted($order->price_total, $order->price_currency); ?>/-</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php foreach ($order_products as $item) :

    if ($item->seller_id == $this->auth_user->id) : ?>
        <div class="modal fade" id="updateStatusModal_<?php echo $item->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-custom">
                    <!-- form start -->
                    <?php echo form_open('update-order-product-status-post'); ?>
                    <input type="hidden" name="id" value="<?php echo $item->id; ?>">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo trans("update_order_status"); ?></h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true"><i class="icon-close"></i> </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label"><?php echo trans('status'); ?></label>
                                    <select name="order_status" id="update_order_status_<?php echo $item->id; ?>" onchange="reason_order_rejected(<?php echo $item->id; ?>)" class="form-control custom-select" data-order-product-id="<?php echo $item->id; ?>">

                                        <option value="processing" <?php echo ($item->order_status == 'processing') ? 'selected' : ''; ?>><?php echo trans("order_processing"); ?></option>
                                        <option value="shipped" <?php echo ($item->order_status == 'shipped') ? 'selected' : ''; ?>><?php echo trans("shipped"); ?></option>

                                    </select>
                                    <!-- 
                                    <div id="cancel_reason_div_<?php echo $item->id; ?>" style="display: none;">
                                        <label class="control-label"><?php echo trans('reject_reason'); ?></label>
                                        <select name="reject_reason" id="reject_reason_select_<?php echo $item->id; ?>" onchange="reason_specify(<?php echo $item->id; ?>)" class="form-control custom-select" data-order-product-id="<?php echo $item->id; ?>">
                                            <?php if ($item->product_type == 'physical') : ?>
                                                <?php if (!empty($reject_reason)) :
                                                    foreach ($reject_reason as $reason) : ?>
                                                        <option value="<?php echo html_escape($reason->id); ?>" myTag="<?php $reason->reason ?>"><?php echo $reason->reason ?></option>
                                                <?php endforeach;
                                                endif; ?>

                                            <?php endif; ?>
                                        </select>
                                        <div id="reject_reason_specify_<?php echo $item->id; ?>" style="display: none;">
                                            <label class="control-label">Comments(optional)</label>
                                            <textarea class="form-control" name="reject_reason_comment" row='3'></textarea>
                                        </div>
                                    </div> -->

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?php echo trans("close"); ?></button>
                        <button type="submit" value="submit" name="update" class="btn btn-md btn-success"><?php echo trans("submit"); ?></button>
                    </div>
                    <?php echo form_close(); ?>
                    <!-- form end -->
                </div>
            </div>
        </div>
        <div class="modal fade" id="cancelOrderModal_<?php echo $item->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-custom">
                    <!-- form start -->
                    <?php echo form_open('update-order-product-status-post'); ?>

                    <input type="hidden" name="id" value="<?php echo $item->id; ?>">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo "Cancel Order Product"/*trans("cancel_order_product")*/; ?></h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true"><i class="icon-close"></i> </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="<?php echo $item->id; ?>">
                                    <input type="hidden" name="order_status" value="cancelled_by_seller">
                                    <label class="control-label"><?php echo "Choose Cancellation Reason"/*trans('cancellation_reason')*/; ?></label>
                                    <select name="reject_reason" id="reject_reason_select_<?php echo $item->id; ?>" onchange='check_comments1(this.value);' class="form-control custom-select" data-order-product-id="<?php echo $item->id; ?>">
                                        <?php if ($item->product_type == 'physical') : ?>
                                            <?php if (!empty($reject_reason)) :
                                                foreach ($reject_reason as $reason) : ?>
                                                    <option value="<?php echo html_escape($reason->id); ?>" myTag="<?php $reason->reason ?>"><?php echo $reason->reason ?></option>
                                            <?php endforeach;
                                            endif; ?>

                                        <?php endif; ?>
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
                        <button type="button" class="btn btn-md btn-success" data-dismiss="modal"><?php echo trans("close"); ?></button>
                        <button type="submit" name="update" value="cancel_order" id="cancel_order_loader" class="btn btn-md btn-danger"><?php echo "Cancel Order"/*trans("submit")*/; ?></button>
                    </div>
                </div>

                <?php echo form_close(); ?>
                <!-- form end -->
            </div>
            <div id="cover-spin1"></div>
        </div>
        <div class="modal fade" id="addTrackingNumberModal_<?php echo $item->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-custom">
                    <!-- form start -->
                    <?php echo form_open_multipart('add-shipping-tracking-number-post'); ?>
                    <input type="hidden" name="id" value="<?php echo $item->id; ?>">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo trans("add_shipping_tracking_number"); ?></h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true"><i class="icon-close"></i> </span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row tracking-number-container">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><?= trans("tracking_number"); ?></label>
                                    <input type="text" name="shipping_tracking_number" class="form-control form-input" value="<?= html_escape($item->shipping_tracking_number); ?>" placeholder="<?= trans("tracking_number"); ?>">
                                </div>
                                <div class="form-group">
                                    <label><?= trans("url"); ?></label>
                                    <input type="text" name="shipping_tracking_url" class="form-control form-input" value="<?= html_escape($item->shipping_tracking_url); ?>" placeholder="<?= trans("url"); ?>">
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?php echo trans("close"); ?></button>
                        <button type="submit" class="btn btn-md btn-primary"><?php echo trans("submit"); ?></button>
                    </div>
                    <?php echo form_close(); ?>
                    <!-- form end -->
                </div>
            </div>
        </div>

        <div class="modal fade" id="made_to_order_cancel_warning_<?php echo $item->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-custom">
                    <!-- form start -->

                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo "The product you are going to cancel is Made To Order/Made To Stock"; ?></h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true"><i class="icon-close"></i> </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row tracking-number-container">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label"><?php echo trans("seller_made_to_order_penalty_warning"); ?></label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-success" data-dismiss="modal"><?php echo trans("close"); ?></button>
                        <button type="button" class="btn btn-md btn-danger" data-dismiss="modal" class="btn btn-md btn-block btn-danger" data-toggle="modal" data-target="#cancelOrderModal_<?php echo $item->id; ?>">Proceed to Cancel Order </button>
                    </div>
                </div>
            </div>
        </div>

        </div>
        <div class="modal fade" id="addTrackingNumberModal_<?php echo $item->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-custom">
                    <!-- form start -->
                    <?php echo form_open_multipart('add-shipping-tracking-number-post'); ?>
                    <input type="hidden" name="id" value="<?php echo $item->id; ?>">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo trans("add_shipping_tracking_number"); ?></h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true"><i class="icon-close"></i> </span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row tracking-number-container">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><?= trans("tracking_number"); ?></label>
                                    <input type="text" name="shipping_tracking_number" class="form-control form-input" value="<?= html_escape($item->shipping_tracking_number); ?>" placeholder="<?= trans("tracking_number"); ?>">
                                </div>
                                <div class="form-group">
                                    <label><?= trans("url"); ?></label>
                                    <input type="text" name="shipping_tracking_url" class="form-control form-input" value="<?= html_escape($item->shipping_tracking_url); ?>" placeholder="<?= trans("url"); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?php echo trans("close"); ?></button>
                        <button type="submit" class="btn btn-md btn-primary"><?php echo trans("submit"); ?></button>
                    </div>
                    <?php echo form_close(); ?>
                    <!-- form end -->
                </div>
            </div>
        </div>
        <div class="modal fade" id="rejection_reason_model" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-custom">
                    <!-- form start -->
                    <?php echo form_open('order_controller/accept_reject_order_product'); ?>
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo "Rejection Reason"; ?></h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true"><i class="icon-close"></i> </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row tracking-number-container">
                            <div class="col-sm-12">
                                <input type="hidden" value='<?php echo $item->id; ?>' name="order_product_id" id="order_product_id">
                                <div class="form-group">
                                    <label class="control-label"><?php echo "Choose Reject Reason"/*trans('choose_reject_reason')*/; ?></label>
                                    <select name="reject_reason_before_accept" id="reject_reason_select_<?php echo $item->id; ?>" onchange='check_comments2(this.value);' class="form-control custom-select" data-order-product-id="<?php echo $item->id; ?>">
                                        <?php if ($item->product_type == 'physical') : ?>
                                            <?php if (!empty($reject_reason)) :
                                                foreach ($reject_reason as $reason) : ?>
                                                    <option value="<?php echo html_escape($reason->id); ?>" myTag="<?php $reason->reason ?>"><?php echo $reason->reason ?></option>
                                            <?php endforeach;
                                            endif; ?>
                                        <?php endif; ?>
                                    </select>
                                    <div id="other_comment2" style="display: none;">
                                        <div id="reject_reason_specify_<?php echo $item->id; ?>">
                                            <label class="control-label">Please Specify Reason</label>
                                            <textarea class="form-control" id="other_comment2_text" name="reject_reason_comment2" row='3'></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?php echo trans("close"); ?></button>
                        <button type="submit" value="reject" name="submit" id="reject_order_loader" class="btn btn-md btn-primary"><?php echo trans("submit"); ?></button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <div id="cover-spin2"></div>
            <?php foreach ($products as $product) : ?>
            <?php endforeach; ?>

        </div>


        <div class="modal fade" id="schedule_multiple_products" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-custom">
                    <!-- form start -->

                    <div id="response_shipment_modal"></div>

                </div>
            </div>
            <div id="cover-spin2"></div>
        </div>

        <div class="modal fade" id="order_shipment_cancel" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-custom">
                    <!-- form start -->

                    <div id="response_cancel_modal"></div>

                </div>
            </div>
            <div id="cover-spin2"></div>
        </div>
    <?php endif; ?>
    <div class="modal fade" id="Now_Bike_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-custom">
                <!-- form start -->
                <div class="modal-header">
                    <h4 class="modal-title">Shipment Details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <table border="0" width="100%">
                        <tbody>
                            <tr>
                                <td>OrderId : </td>
                                <td id="now_order_id"></td>
                            </tr>
                            <tr>
                                <td>Status : </td>
                                <td id="now_status"></td>
                            </tr>
                            <tr>
                                <td>Rider Name : </td>
                                <td id="now_rider_name">-</td>
                            </tr>
                            <tr>
                                <td>Rider Phone Number : </td>
                                <td id="now_rider_phone">-</td>
                            </tr>
                            <tr>
                                <td>Cancellation Reason : </td>
                                <td id="now_cancellation_reason">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>


            </div>
        </div>
    </div>


<?php
endforeach; ?>
<?php
?>
<script>
    function wrapper_multiple_product(products_array, order_items_array) {
        $("#schedule_multiple_products").modal('hide');

        function uuidv4() {
            return 'yxxyxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0,
                    v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }
        var uniqid = uuidv4()
        var result = "null";
        var total_quantity_price = 0;
        var product_id_array = [];
        var order_item_id_array = [];
        var base_url = '<?php echo base_url() ?>';
        var order_items = [];
        var quantity_price_array = [];
        for (var i = 0; i < products_array.length; i++) {
            order_items.push({

                name: order_items_array[i].product_title,
                sku: products_array[i].sku,
                units: order_items_array[i].product_quantity,
                selling_price: order_items_array[i].price_after_discount / 100

            });
            product_id_array.push(products_array[i].id);
            order_item_id_array.push(order_items_array[i].id)
            quantity_price_array.push(order_items_array[i].product_quantity * order_items_array[i].price_after_discount / 100);
        }
        for (var j = 0; j < quantity_price_array.length; j++) {
            total_quantity_price += quantity_price_array[j];
        }
        var ref_order_id = Date.now().toString() + "-" + '<?php echo $order->id; ?>';

        var required_data = {
            "order_id": ref_order_id,
            "order_date": "<?php echo date('Y-m-d H:i', strtotime($order->created_at)) ?>",
            "billing_customer_name": "<?php echo $shipping->billing_first_name ?>",
            "billing_last_name": "<?php echo $shipping->billing_last_name ?>",
            "billing_address": "<?php echo ($shipping->billing_address_1 . ',' . $shipping->billing_area) ?>",
            "billing_address_2": "<?php echo ($shipping->billing_landmark) ?>",
            "billing_city": "<?php echo ($shipping->billing_city) ?>",
            "billing_pincode": <?php echo ($shipping->billing_zip_code) ?>,
            "billing_state": "<?php echo ($shipping->billing_state) ?>",
            "billing_country": "<?php echo ($shipping->billing_country) ?>",
            "billing_email": "<?php echo ($shipping->billing_email) ?>",
            "billing_phone": <?php echo ($shipping->billing_phone_number) ?>,
            "shipping_is_billing": <?php echo ($shipping->use_same_address_for_billing == 1) ? true : false; ?>,
            "shipping_customer_name": "<?php echo $shipping->shipping_first_name ?>",
            "shipping_last_name": "<?php echo $shipping->shipping_last_name ?>",
            "shipping_address": "<?php echo ($shipping->shipping_address_1 . ',' . $shipping->shipping_area) ?>",
            "shipping_address_2": "<?php echo ($shipping->shipping_landmark) ?>",
            "shipping_city": "<?php echo ($shipping->shipping_city) ?>",
            "shipping_pincode": <?php echo ($shipping->shipping_zip_code) ?>,
            "shipping_country": "<?php echo ($shipping->shipping_country) ?>",
            "shipping_state": "<?php echo ($shipping->shipping_state) ?>",
            "shipping_email": "<?php echo ($shipping->shipping_email) ?>",
            "shipping_phone": <?php echo ($shipping->billing_phone_number) ?>,
            "order_items": order_items,
            "payment_method": "<?php echo ($order->payment_method == "Cash On Delivery") ? "COD" : "Prepaid"; ?>",
            "sub_total": <?php echo !empty($seller_wise_data) ? ($order->price_total) / 100 : $total_quantity_price ?>,
            "length": document.getElementById("total_length").value,
            "breadth": document.getElementById("total_width").value,
            "height": document.getElementById("total_height").value,
            "weight": document.getElementById("total_weight").value / 1000,
            "pickup_location": uniqid,
            "vendor_details": {
                "email": "<?php echo $this->auth_user->email ?>",
                "phone": <?php echo $this->auth_user->phone_number ?>,
                "name": "<?php echo $this->auth_user->shop_name ?>",
                "address": "##00-".concat(products_array[0].product_address),
                "address_2": products_array[0].landmark.concat(", ", products_array[0].product_area),
                "city": products_array[0].product_city,
                "state": products_array[0].product_state,
                "country": "India",
                "pin_code": parseInt(products_array[0].product_pincode),
                "pickup_location": uniqid
            }
        };
        var data = {
            "order": required_data,
            sys_lang_id: sys_lang_id
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);

        $.ajax({
            beforeSend: function() {
                $('#cover-spin').show();
            },
            type: "POST",
            url: base_url + "order_controller/schedule_shiprocket_orders",
            data: data,
            success: function(response) {
                var result = JSON.parse(response);
                //result = response;
                if (result.status == 1) {
                    var data = {
                        "shipment_order_id": result.payload.order_id,
                        "reference_order_id": ref_order_id,
                        "order_product_id": order_item_id_array,
                        "product_id": product_id_array,
                        "order_id": <?php echo $order->id; ?>,
                        "shipment_id": result.payload.shipment_id,
                        "awb_code": result.payload.awb_code,
                        "pickup_scheduled_date": result.payload.pickup_scheduled_date,
                        "manifest_url": result.payload.manifest_url,
                        "label_url": result.payload.label_url,
                        "courier_company_name": result.payload.courier_name,
                        "courier_company_id": result.payload.courier_company_id,
                        "applied_weight": result.payload.applied_weight,
                        "pickup_token_number": result.payload.pickup_token_number,
                        "COD": result.payload.COD,

                    };
                    data[csfr_token_name] = $.cookie(csfr_cookie_name);
                    data["sys_lang_id"] = sys_lang_id;
                    $.ajax({
                        "url": base_url + "get-shipment",
                        "method": "POST",
                        "data": data,

                        success: function(data) {
                            window.location.reload()
                        },
                        complete: function() {
                            $('#cover-spin').hide();
                        }
                    })
                } else {
                    $('#cover-spin').hide();
                    alert(response.payload.error_message)
                }
            },
            error: function(response) {
                $('#cover-spin').hide();
                alert(response.responseJSON.message)
            }
        });
    }
</script>

<script>
    function Schedule_Multiple_shipment() {
        var product_ids = [];
        $("input[name='checkbox-table']").each(function() {
            product_ids.push(this.value);
        });
        // $("#schedule_multiple_products").modal("show");
        // $('#items_array').val(product_ids);
        var data = {
            "product_ids": product_ids,
            "sys_lang_id": sys_lang_id
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $('#cover-spin').show();
        $.ajax({
            url: base_url + "schedule-multiple-order-shipment",
            type: "post",
            data: data,
            success: function(response) {
                $('#cover-spin').hide();
                var obj = JSON.parse(response);
                var a = "<?php echo sizeof($order_products); ?>"
                // if (a == 1) {
                //     if (obj.result == 1) {
                //         document.getElementById("response_shipment_modal").innerHTML = obj.html_content;

                //         wrapper_multiple_product(obj.vars.products, obj.vars.order_items);
                //     }

                // }
                // if (a > 1) {

                if (obj.result == 1) {
                    document.getElementById("response_shipment_modal").innerHTML = obj.html_content;
                }
                setTimeout(
                    function() {
                        $("#schedule_multiple_products").modal('show');
                    }, 200);
                // }
            }
        });

        // $('#schedule_sipment').prop('disabled', true);

    }
</script>

<script>
    function reason_order_rejected(id) {
        var id_string = toString(id);
        var update_order = "update_order_status_" + id;
        var cancel_reason = "cancel_reason_div_" + id;
        var status = document.getElementById(update_order).value;
        if (status == "rejected")
            document.getElementById(cancel_reason).style.display = "block";
        else
            document.getElementById(cancel_reason).style.display = "none";
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
<script>
    var result = null;

    function cancel_shipment() {
        $('#cover-spin').show();
        $.ajax({
            "url": "https://apiv2.shiprocket.in/v1/external/orders/cancel",
            "method": "POST",
            "timeout": 0,

            "headers": {
                "Content-Type": "application/json",
                "Authorization": "Bearer <?php echo $_SESSION['modesy_sess_user_shiprocket_token'] ?>"
            },
            "data": JSON.stringify({
                "ids": [result['order_id']

                ],
                success: function(response) {
                    $('#cover-spin').hide();
                    result2 = response;
                }
            })
        })
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

<?php if (!empty($this->session->userdata('mds_send_email_data_seller'))) : ?>
    <script>
        $(document).ready(function() {
            var data = JSON.parse(<?php echo json_encode($this->session->userdata("mds_send_email_data_seller")); ?>);
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
$this->session->unset_userdata('mds_send_email_data_seller'); ?>


<script>
    $(document).on("click", ".open-RejectReasonDialog", function() {
        var orderProductId = $(this).data('id');
        $(".modal-body #order_product_id").val(orderProductId);
        // As pointed out in comments, 
        // it is unnecessary to have to manually call the modal.
        // $('#addBookDialog').modal('show');
    });
</script>
<script type="text/javascript">
    function check_comments1(val) {
        var element = $("#other_comment1");
        if (val == '4') {
            element.show();
            // document.getElementById('other_comment1_text').required=true;
        } else
            element.hide();
    }

    function check_comments2(val) {
        var element = $("#other_comment2");
        if (val == '4') {
            element.show();
            // document.getElementById('other_comment2_text').required=true;
        } else
            element.hide();
    }

    $("#cancel_order_loader").click(function(e) {
        // $('#modalwindow').modal('hide');
        $('#cover-spin1').show();
    });

    $("#reject_order_loader").click(function(e) {
        // $('#modalwindow').modal('hide');
        $('#cover-spin2').show();
    });
</script>
<script>
    function nowBike_multiple_create_order(order_items_array, sale_total_price) {
        var order_item_id_array = [];
        for (var i = 0; i < order_items_array.length; i++) {
            order_item_id_array.push(order_items_array[i].id)
        }
        var shipping_address = JSON.parse('<?php echo $shipping_json; ?>');
        console.log(shipping_address);
        var customer_address;
        if (shipping_address.shipping_address_2) {
            customer_address = shipping_address.shipping_address_1 + ", " + shipping_address.shipping_address_2 + ", " + shipping_address.shipping_area + ", " + shipping_address.shipping_city + ", " + shipping_address.shipping_state;
        } else {
            customer_address = shipping_address.shipping_address_1 + ", " + shipping_address.shipping_area + ", " + shipping_address.shipping_city + ", " + shipping_address.shipping_state;
        }
        var locality = shipping_address.shipping_area;
        var customer_name = shipping_address.shipping_first_name + ", " + shipping_address.shipping_last_name;
        var customer_number = shipping_address.shipping_phone_number;
        var order_id = '<?php echo $order->order_number; ?>';
        var total_amount = parseInt(sale_total_price);
        var required_data = {
            "vendor_name": '<?php echo $seller->first_name . " " . $seller->last_name; ?>',
            "vendor_contact_number": parseInt('<?php echo $seller->phone_number; ?>'),
            "vendor_address": '<?php echo $seller->house_no . ", " . $seller->supplier_area . ", " . $seller->supplier_city . ", " . $seller->supplier_state; ?>',
            "from_lat": '<?= $seller->latitude; ?>',
            "from_lng": '<?= $seller->longitude; ?>',
            "customer_contact_number": customer_number,
            "locality": locality,
            "customer_address": customer_address,
            // "to_approx_lat": 28.5308,
            // "to_approx_lng": 77.2628,
            "amount": total_amount,
            "payment_type": "online",
            "customer_name": customer_name,
            "vendor_order_id": order_id,
            "customer_pic_url": null,
            "store_id": '<?= $seller->store_id; ?>'
        };

        var session_token_nowbike = '<?php echo $this->general_settings->now_bike_session_token; ?>';
        var url = "http://delivery.now.bike/api/v1/orders?session_token=" + session_token_nowbike;
        var data = {
            "order": required_data,
            "url": url,
            sys_lang_id: sys_lang_id
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);

        $('#cover-spin').show();
        $.ajax({
            type: "POST",
            url: base_url + "order_controller/now_bike_generate_order_post",
            // url: url,
            data: data,
            success: function(response) {
                var response_json = JSON.parse(response);
                var url = base_url + "order_controller/now_bike_order";
                var data = {
                    sys_lang_id: sys_lang_id,
                    "now_bike_id": response_json.order.id,
                    "order_id": order_id,
                    "order_product_id": order_item_id_array
                };
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function(response) {
                        $('#cover-spin').hide();
                        // console.log(response);
                        location.reload();
                    }
                });

            }
        });
    }
</script>
<script>
    function nowBike_create_order(order_id, order_product_id, sale_price) {
        var order_item_id_array = [];
        order_item_id_array.push(order_product_id);
        var shipping_address = JSON.parse('<?php echo $shipping_json; ?>');
        console.log(shipping_address);
        var customer_address;
        if (shipping_address.shipping_address_2) {
            customer_address = shipping_address.shipping_address_1 + ", " + shipping_address.shipping_address_2 + ", " + shipping_address.shipping_area + ", " + shipping_address.shipping_city + ", " + shipping_address.shipping_state;
        } else {
            customer_address = shipping_address.shipping_address_1 + ", " + shipping_address.shipping_area + ", " + shipping_address.shipping_city + ", " + shipping_address.shipping_state;
        }
        var locality = shipping_address.shipping_area;
        var customer_name = shipping_address.shipping_first_name + ", " + shipping_address.shipping_last_name;
        var customer_number = shipping_address.shipping_phone_number;
        var order_id = '<?php echo $order->order_number; ?>';
        var total_amount = parseInt(sale_price) / 100;
        var required_data = {
            "vendor_name": '<?php echo $seller->first_name . " " . $seller->last_name; ?>',
            "vendor_contact_number": parseInt('<?php echo $seller->phone_number; ?>'),
            "vendor_address": '<?php echo $seller->house_no . ", " . $seller->supplier_area . ", " . $seller->supplier_city . ", " . $seller->supplier_state; ?>',
            "from_lat": '<?= $seller->latitude; ?>',
            "from_lng": '<?= $seller->longitude; ?>',
            "customer_contact_number": customer_number,
            "locality": locality,
            "customer_address": customer_address,
            // "to_approx_lat": 28.5308,
            // "to_approx_lng": 77.2628,
            "amount": total_amount,
            "payment_type": "online",
            "customer_name": customer_name,
            "vendor_order_id": order_id,
            "customer_pic_url": null,
            "store_id": '<?= $seller->store_id; ?>'
        };


        var session_token_nowbike = '<?php echo $this->general_settings->now_bike_session_token; ?>';

        var url = "http://delivery.now.bike/api/v1/orders?session_token=" + session_token_nowbike;


        var data = {
            "order": required_data
        };
        $('#cover-spin').show();
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(response) {
                var url = base_url + "order_controller/now_bike_order";

                var data = {
                    sys_lang_id: sys_lang_id,
                    "now_bike_id": response.order.id,
                    "order_id": order_id,
                    "order_product_id": order_item_id_array
                };
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function(response) {
                        $('#cover-spin').hide();
                        // console.log(response);
                        location.reload();
                    }
                });

            }
        });
    }

    function nowBike_get_order_details(now_bike_id, element) {
        element.prop("disable", true);
        var session_token_nowbike = '<?php echo $this->general_settings->now_bike_session_token; ?>';
        var url = "http://delivery.now.bike/api/v1/orders/" + now_bike_id + "?session_token=" + session_token_nowbike;
        var data = {
            "url": url,
            sys_lang_id: sys_lang_id

        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $('#cover-spin').show();
        $.ajax({
            type: "post",
            url: base_url + "order_controller/get_now_bike_details",
            data: data,
            success: function(response) {
                var response_json = JSON.parse(response);
                element.prop("disable", false);
                $('#cover-spin').hide();
                var data = [{
                    "id": response_json.order.id,
                    "status": response_json.order.status,
                    "cancellation_reason": response_json.order.cancellation_reason,
                    "rider_name": response_json.order.rider_name,
                    "rider_phone": response_json.order.rider_phone
                }];
                $("#now_status").html(data[0].status);
                $("#now_order_id").html(data[0].id);
                if (data[0].rider_name)
                    $("#now_rider_name").html(data[0].rider_name);
                if (data[0].rider_phone)
                    $("#now_rider_phone").html(data[0].rider_phone);
                if (data[0].cancellation_reason)
                    $("#now_cancellation_reason").html(data[0].cancellation_reason);

                $("#Now_Bike_modal").modal("show");
            }
        });
    }

    function nowBike_cancle_order(now_bike_id, message) {

        var session_token_nowbike = '<?php echo $this->general_settings->now_bike_session_token; ?>';

        var url = "http://delivery.now.bike/api/v1/orders/" + now_bike_id + "/cancel?session_token=" + session_token_nowbike;
        var data = {
            "order": {
                "cancellation_reason": "Wrong Location Selected"
            },
            "url": url,
            sys_lang_id: sys_lang_id

        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        swal({
                text: message,
                icon: "warning",
                buttons: [sweetalert_cancel, sweetalert_ok],
                dangerMode: true,
            })
            .then(function(willDelete) {
                if (willDelete) {
                    $('#cover-spin').show();
                    $.ajax({
                        type: "PUT",
                        url: base_url + "order_controller/now_bike_order_cancel_post",
                        data: data,
                        success: function(response) {
                            var local_url = base_url + "order_controller/now_bike_order_cancel";
                            var data = {
                                sys_lang_id: sys_lang_id,
                                "now_bike_id": now_bike_id,
                                "cancellation_reason": "Wrong Location Selected"
                            };
                            data[csfr_token_name] = $.cookie(csfr_cookie_name);
                            $.ajax({
                                type: "POST",
                                url: local_url,
                                data: data,
                                success: function(response) {
                                    $('#cover-spin').hide();
                                    location.reload();
                                }
                            });
                        }
                    });
                }
            });
    }



    function shiprocket_cancel_order(shipment_order_id, message) {
        swal({
            text: message,
            icon: "warning",
            buttons: true,
            buttons: [sweetalert_cancel, sweetalert_ok],
            dangerMode: true,
        }).then(function(willDelete) {
            if (willDelete) {
                var data = {
                    sys_lang_id: sys_lang_id,
                    'shipment_order_id': shipment_order_id
                };
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                $('#cover-spin').show();
                $.ajax({
                    type: "POST",
                    url: base_url + "order_controller/cancel_shipment",
                    data: data,
                    success: function(response) {
                        $('#cover-spin').hide();
                        var obj = JSON.parse(response);
                        if (obj.result == 1) {
                            document.getElementById("response_cancel_modal").innerHTML = obj.html_content;
                        }
                        setTimeout(
                            function() {
                                $("#order_shipment_cancel").modal('show');
                            }, 200);
                    }
                });
            }
        });
    };
</script>