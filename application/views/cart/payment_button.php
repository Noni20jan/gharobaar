<?php
$cart_has_physical_product = $this->cart_model->check_cart_has_physical_product();
$cart_seller_total = get_cart_seller_total();
$shop_name_seller = "";
foreach ($cart_seller_total as $cst) :

    $check_min_order_value = get_seller_order_value($cst->seller_id);
    // var_dump(round($cst->total_price/100,2));
    if ($check_min_order_value == "" || $check_min_order_value == null || round($cst->total_price / 100, 2) >= $check_min_order_value) {
        $matched_min_order_value = true;
    } else {
        $matched_min_order_value = false;
        $shop_name_seller = get_shop_name_by_user_id($cst->seller_id);
        break;
    }

endforeach;

$is_shop_open = 1;
if (!empty($cart_items)) :
    foreach ($cart_items as $cart_item) :
        $stock_quantity = (int)get_product($cart_item->product_id)->stock;

        $product = get_active_product($cart_item->product_id);

        if ($product->is_shop_open == 0) {
            $is_shop_open = 0;
        }
    endforeach;
endif;

?>



<p class="line-seperator"></p>
<?php if (intval(secondsToTime($cart_total->min_dispatch_time)) > 1 || intval(secondsToTime($cart_total->max_dispatch_time)) > 1) :
    $day = " days";
else :
    $day = " day";
endif;
?>
<?php if (secondsToTime($cart_total->min_dispatch_time) != secondsToTime($cart_total->max_dispatch_time)) : ?>
    <p><?php echo trans("min_max_dispatch_days"); ?><?php echo (!empty(secondsToTime($cart_total->min_dispatch_time))) ? secondsToTime($cart_total->min_dispatch_time) . " - " : " "; ?><?php echo (!empty(secondsToTime($cart_total->max_dispatch_time))) ? secondsToTime($cart_total->max_dispatch_time) . $day : "" ?> </p>
<?php else : ?>
    <p><?php echo trans("min_max_dispatch_days"); ?><?php echo (!empty(secondsToTime($cart_total->max_dispatch_time))) ? secondsToTime($cart_total->max_dispatch_time) . $day : "" ?> </p>
<?php endif; ?>
<p class="m-t-30">
    <?php if (empty($cart_total->is_all_product_available)) : ?>
        <a href="#" class="btn btn-block" data-toggle="modal" data-target="#product_not_available"> <strong><?php echo trans("continue_to_checkout"); ?> </strong></a>
    <?php else : ?>
        <?php if (empty($cart_total->is_stock_available)) : ?>
            <strong class="btn btn-block " data-toggle="modal" data-target="#out_of_stock"><?php echo trans("continue_to_checkout"); ?> </strong>
        <?php else : ?>
            <?php if ($is_shop_open == 0) : ?>
                <strong class="btn btn-block " data-toggle="modal" data-target="#shop_is_closed"><?php echo trans("continue_to_checkout"); ?> </strong>
            <?php else : ?>
                <?php if ($this->cart_model->get_sess_cart_total()->total_price <= $this->general_settings->min_cart_value && empty($this->cart_model->get_sess_cart_total()->applied_coupon_discount)) : ?>
                    <strong class="btn btn-block " data-toggle="modal" data-target="#min_cart_val_modal"><?php echo trans("continue_to_checkout"); ?> </strong>
                <?php else : ?>
                    <?php if ($matched_min_order_value == false) : ?>
                        <strong class="btn btn-block " data-toggle="modal" data-target="#min_order_val_modal"><?php echo trans("continue_to_checkout"); ?> </strong>
                    <?php else : ?>
                        <?php if (empty($this->auth_check) && $this->general_settings->guest_checkout != 1) : ?>
                            <a href="#" class="btn btn-block" data-toggle="modal" data-target="#loginModal"> <strong><?php echo trans("continue_to_checkout"); ?> </strong></a>
                        <?php elseif (!empty($this->auth_check)) : ?>
                            <?php if (($this->auth_user->phone_number) == '') : ?>
                                <a href="#" class="btn btn-block" data-toggle="modal" data-target="#registerMobileModal"> <strong><?php echo trans("continue_to_checkout"); ?> </strong></a>
                                <?php else :
                                $is_made_to_order = false;
                                foreach ($cart_items as $cart_item) :
                                    $product = get_product($cart_item->product_id); ?>
                                    <?php if ($product->add_meet == "Made to order") :
                                        $is_made_to_order = true;
                                    endif; ?>
                                <?php endforeach; ?>
                                <?php if ($is_made_to_order) : ?>
                                    <?php if ($this->general_settings->made_to_order_check == 0) : ?>
                                        <a href="<?php echo generate_url("cart", "shipping"); ?>" class="btn btn-block"> <strong><?php echo trans("continue_to_checkout"); ?> </strong></a>
                                    <?php else : ?>
                                        <a href="#" class="btn btn-block" data-toggle="modal" data-target="#made_to_order_checkout"> <strong><?php echo trans("continue_to_checkout"); ?> </strong></a>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <?php if ($cart_has_physical_product == true && $this->form_settings->shipping == 1) : ?>
                                        <a href="<?php echo generate_url("cart", "shipping"); ?>" class="btn btn-block"> <strong><?php echo trans("continue_to_checkout"); ?> </strong></a>
                                    <?php else : ?>
                                        <a href="<?php echo generate_url("cart", "payment_method"); ?>" class="btn btn-block" onclick="checkreview()"> <strong><?php echo trans("continue_to_checkout"); ?> </strong>
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>


                        <?php elseif ($this->general_settings->guest_checkout == 1) : ?>
                            <a href="#" class="btn btn-block" data-toggle="modal" data-target="#loginModal"> <strong><?php echo "Login to Continue"; ?> </strong></a>
<div class="text-center m-b-15"><strong>OR</strong></div>
<a href="#" class="btn btn-block" data-toggle="modal" data-target="#guestLoginModal"> <strong><?php echo "Continue Checkout as Guest"; ?> </strong></a>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>
</p>