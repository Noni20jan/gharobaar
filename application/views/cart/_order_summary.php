<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .m-t-30 {
        margin-top: 70px !important;
    }
</style>
<div id="cart" class="col-sm-12 col-lg-5 order-summary-container">
    <h2 class="cart-section-title" id="cart_quantity"><?php echo trans("order_summary"); ?> (<?php echo get_cart_product_count(); ?>)</h2>
    <!-- <a href="<?php echo generate_url("cart"); ?>">
        <button type="button" class="btn btn-sm btn-custom" style="margin:1rem;"> <i class="icon-cart"></i> EDIT CART</button>
    </a> -->
    <div class="right summary-section">
        <?php $is_physical = false; ?>
        <div class="item" style="background:none;padding:0px;backdrop-filter:none;">
            <a href="<?php echo generate_url("cart"); ?>">
                <button type="button" class="btn btn-sm btn-custom" style="float:right;margin:1rem;background-color: black;
    border: none;"> <i class="icon-cart"></i> EDIT CART</button>
            </a>
        </div>
        <div class="cart-order-details">

            <?php if (!empty($cart_items)) :
                $pincodes = array();
                $total_products = array();
                $all_variation_array = array();
                $total_discount = 0;
                foreach ($cart_items as $cart_item) :
                    $product = get_active_product($cart_item->product_id);
                    array_push($pincodes, $product->product_pincode);
                    array_push($total_products, $product);
                    array_push($all_variation_array, $cart_item->options_array);
                    $discount = 0;
                    $discount = ((($cart_item->listing_price) * ($cart_item->discount_rate)) / 10000) * $cart_item->quantity;
                    $total_discount = 0;
                    // $total_discount += round($discount);
                    if (!empty($product)) :
                        if ($product->product_type == 'physical') {
                            $is_physical = true;
                        } ?>
                        <div class="item" id="<?php echo $cart_item->cart_item_id; ?>">
                            <div class="item-left">
                                <div class="img-cart-product">
                                    <?php if (empty($cart_item->variation_option)) : ?>
                                        <a href="<?php echo generate_product_url($product); ?>">
                                            <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_product_image($cart_item->product_id, 'image_small'); ?>" alt="<?php echo html_escape($cart_item->product_title); ?>" class="lazyload img-fluid img-product" onerror="this.src='<?php echo get_product_image($cart_item->product_id, 'image_small'); ?>'">
                                        </a>
                                    <?php else : ?>
                                        <?php $variation_image = get_variation_main_option_image_url($cart_item->variation_option, null); ?>
                                        <?php if (empty($variation_image)) : ?>
                                            <a href="<?php echo generate_product_url($product); ?>">
                                                <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_product_image($cart_item->product_id, 'image_small'); ?>" alt="<?php echo html_escape($cart_item->product_title); ?>" class="lazyload img-fluid img-product" onerror="this.src='<?php echo get_product_image($cart_item->product_id, 'image_small'); ?>'">
                                                <!-- <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_variation_main_option_image_url($cart_item->variation_option, null); ?>" alt="<?php echo html_escape($cart_item->product_title); ?>" class="lazyload img-fluid img-product" onerror="this.src='<?php echo get_product_image($cart_item->product_id, 'image_small'); ?>'"> -->
                                            </a>
                                        <?php else : ?>
                                            <a href="<?php echo generate_product_url($product); ?>">
                                                <!-- <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_product_image($cart_item->product_id, 'image_small'); ?>" alt="<?php echo html_escape($cart_item->product_title); ?>" class="lazyload img-fluid img-product" onerror="this.src='<?php echo get_product_image($cart_item->product_id, 'image_small'); ?>'"> -->
                                                <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_variation_main_option_image_url($cart_item->variation_option, null); ?>" alt="<?php echo html_escape($cart_item->product_title); ?>" class="lazyload img-fluid img-product" onerror="this.src='<?php echo get_product_image($cart_item->product_id, 'image_small'); ?>'">
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <!-- <a href="<?php echo generate_product_url($product); ?>">
                                        <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_product_image($cart_item->product_id, 'image_small'); ?>" alt="<?php echo get_product_title($product); ?>" class="lazyload img-fluid img-product" onerror="this.src='<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>'">
                                    </a> -->
                                </div>
                            </div>
                            <div class="item-right">
                                <?php if ($product->product_type == 'digital') : ?>
                                    <div class="list-item">
                                        <label class="label-instant-download label-instant-download-sm"><i class="icon-download-solid"></i><?php echo trans("instant_download"); ?></label>
                                    </div>
                                <?php endif; ?>
                                <div class="list-item">
                                    <a href="<?php echo generate_product_url($product); ?>">
                                        <?php echo html_escape($cart_item->product_title); ?>
                                    </a>
                                </div>
                                <?php if (!$cart_item->product_deliverable) : ?>
                                    <div class="list-item" style="color:red;font-weight:bold;font-size:small;">
                                        This item is not deliverable to your address.
                                        <a href="javascript:void(0)" id="remove_cart" onclick="remove_from_cart_checkout('<?php echo $cart_item->cart_item_id; ?>');"> <i class="icon-close"></i><?php echo trans("remove"); ?> </a>
                                    </div>
                                <?php endif; ?>
                                <div class="list-item seller">
                                    <?php echo trans("by"); ?>&nbsp;<a href="<?php echo generate_profile_url($product->user_slug); ?>"><?php echo ucfirst(get_brand_name_product($product)); ?></a>
                                </div>
                                <div class="list-item m-t-15">
                                    <label><?php echo trans("quantity"); ?>:</label>
                                    <strong class="lbl-price"><?php echo $cart_item->quantity; ?></strong>
                                </div>
                                <div class="list-item">
                                    <label><?php echo trans("price"); ?>:</label>
                                    <strong class="lbl-price"><?php echo price_formatted($cart_item->listing_price, $cart_item->currency); ?></strong>
                                </div>
                                <!-- <?php if (!empty($cart_item->product_gst)) : ?>
                                    <div class="list-item">
                                        <label><?php echo trans("vat"); ?>:</label>
                                        <strong><?php echo price_formatted($cart_item->product_gst, $cart_item->currency); ?></strong>
                                    </div>
                                <?php endif; ?> -->
                                <?php if (!empty($cart_item->discount_rate)) : ?>
                                    <div class="list-item">
                                        <label><?php echo trans("discount"); ?>:</label>
                                        <strong style="color: #007C05;"><?php echo price_formatted($cart_item->discount_amount * 100, $cart_item->currency); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if ($product->product_type != 'digital' && $this->form_settings->shipping == 1) : ?>
                                    <div class="list-item">

                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>

                <?php endif;
                endforeach; ?>
                <script>
                    function calling_picode_api(user_pincode) {
                        var pincodes = <?php echo json_encode($pincodes); ?>;
                        var total_products = <?php echo json_encode($total_products); ?>;
                        var all_variation_array = <?php echo json_encode($all_variation_array); ?>;
                        console.log(all_variation_array);
                        for (var i = 0; i < total_products.length; i++) {
                            check_pincode(total_products[i].id, user_pincode, total_products[i].product_pincode, total_products[i].weight, all_variation_array[i]);
                        }
                    }
                </script>
            <?php endif; ?>

        </div>
        <p class="m-t-30">
            <strong><?php echo trans("subtotal"); ?><span class="float-right" id="sub_total"><?php echo price_formatted_without_round($cart_total->total, $this->payment_settings->default_currency); ?>/-</span></strong>
        </p>
        <!-- <?php if (!empty($cart_total->gst)) : ?>
            <p>
                <?php echo trans("vat"); ?><span class="float-right"><?php echo price_formatted($cart_total->gst, $cart_total->currency); ?></span>
            </p>
        <?php endif; ?> -->
        <?php if (!empty($cart_items)) :
            foreach ($cart_items as $cart_item) :
                $product = get_active_product($cart_item->product_id);
                if (!empty($product)) : ?>
                    <?php $total_discount += ($cart_item->discount_amount) * $cart_item->quantity; ?>
            <?php endif;
            endforeach; ?>
            <!-- <p>
                <?php echo trans("total_discount"); ?><span class="float-right" style="color: #007C05;"><?php echo price_formatted($total_discount * 100, $cart_total->currency); ?>/-</span>
            </p> -->
        <?php endif; ?>
        <!-- <?php if (!empty($cart_total->gst)) : ?>
            <p>
                <?php echo trans("total_discount"); ?><span class="float-right" style="color: #007C05;"><?php echo price_formatted($total_discount * 100, $cart_total->currency); ?></span>
            </p>
        <?php endif; ?> -->

        <?php $address = $this->session->userdata("mds_cart_shipping_address") ?>

        <?php if ($is_physical && $this->form_settings->shipping == 1) : ?>
            <?php if (!is_null($address)) : ?>
                <p>
                    <strong><?php echo trans("shipping"); ?><span id="shipping_cost" class="float-right"><?php echo price_formatted_without_round($cart_total->shipping_cost, $this->payment_settings->default_currency); ?>/-</span></strong>
                </p>
            <?php else : ?>
                <p>
                    <!-- <?php echo trans("shipping"); ?> -->
                    <!-- <?php echo trans("shipping"); ?><span class="float-right"><?php echo trans("yet_to_be") ?></span> -->
                    <?php if ($this->general_settings->flat_ship_enable == 1) : ?>
                        <?php if ($cart_total->total < 50000) : ?>
                            <?php echo trans("shipping"); ?><span class="float-right"><?php echo (price_formatted(10000, $cart_total->currency)); ?></span>
                        <?php else : ?>
                            <?php echo trans("shipping"); ?><span class="float-right"><?php echo (price_formatted(0, $cart_total->currency)); ?></span>
                        <?php endif; ?>
                    <?php else : ?>
                        <?php echo trans("shipping"); ?><span class="float-right"><?php echo trans("yet_to_be") ?></span>
                    <?php endif; ?>

                    <!-- <span class="float-right"><?php echo price_formatted(100, $this->payment_settings->default_currency); ?>/-</span> -->


                </p>
            <?php endif; ?>

        <?php endif; ?>
        <?php $payments = $this->cart_model->get_sess_cart_payment_method();
        $cod = (string)0;
        if (!empty($payments)) {
            $payment = (string)($payments->payment_option);
            if ($payment === 'cash_on_delivery') {
                $cod = (string)1;
            }
        }
        ?>
        <?php if ($cod) : ?>
            <p>
                <strong><?php echo "COD Charges"; ?><span class="float-right"><?php echo price_formatted_without_round($cart_total->total_cod_charges, $this->payment_settings->default_currency); ?>/-</span></strong>
            </p>
        <?php endif; ?>

        <?php if ($cart_total->total_tax_charges > 0) : ?>
            <p>
                <strong><?php echo "Taxes"; ?><span class="float-right"><?php echo price_formatted_without_round($cart_total->total_tax_charges, $this->payment_settings->default_currency); ?>/-</span></strong>
            </p>
        <?php endif; ?>

        <?php if ($cart_total->applied_coupon_discount > 0) : ?>
            <p style="color:#007C05;">
                <strong><?php echo "Coupon Discount"; ?><span class="float-right"><?php echo "- " . price_formatted_without_round($cart_total->applied_coupon_discount, $this->payment_settings->default_currency); ?>/-</span></strong>
            </p>
        <?php elseif (!empty($cart_total->applied_coupon_source_type)) : ?>
            <p style="color:#007C05;">
                <strong><?php echo "Coupon Discount"; ?>
                    <span class="float-right">
                        <?php switch ($cart_total->applied_coupon_source_type):
                            case "FREESHIP":
                                echo "Less Shipping";
                                break;
                            case "EXHIBITION":
                                echo "Less Shipping and COD";
                                break;
                        endswitch;
                        ?>
                    </span>
                </strong>
            <?php endif; ?>


            <p class="line-seperator"></p>
            <?php if (!is_null($address) && !is_int(($cart_total->shipping_cost + $cart_total->total_tax_charges) / 100) && false) : ?>
                <p>
                    <?php echo trans("total"); ?><span class="float-right"><?php echo price_formatted_without_round($cart_total->order_total, $cart_total->currency); ?>/-</span>
                </p>
                <p>
                    <?php echo ("Round off amount"); ?><span class="float-right">
                        <?php echo price_formatted_without_round((round($cart_total->order_total / 100) - ($cart_total->order_total / 100)) * 100, $cart_total->currency); ?>/-
                    </span>
                </p>
                <p>
                    <strong><?php echo trans("total") . "<small><b>(after Round off)</b></small>"; ?><span class="float-right"><?php echo price_formatted($cart_total->total_price, $this->payment_settings->default_currency); ?>/-</span></strong>
                </p>
            <?php else : ?>
                <p>
                    <strong><?php echo trans("total"); ?><span id="order_total" class="float-right"><?php echo price_formatted_without_round($cart_total->total_price, $this->payment_settings->default_currency); ?>/-</span></strong>
                </p>
            <?php endif; ?>


    </div>
</div>