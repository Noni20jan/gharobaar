<div class="col-12">
    <?php if ($cart_items != null) : ?>
        <div class="shopping-cart">
            <div class="row">
                <div class="col-sm-12 col-lg-8">
                    <div class="left">
                        <div class="delivery-date-container">
                            <div class="col-sm-12"><b> Delivery Date </b></div>
                        </div>
                        <!-- <div class="offers-container">
                                        <div class="col-sm-12"><b>Available Offers</b> <img src="assets/img/percent.png" width="23" height="23">
                                            <p></p>
                                            <p style="font-size:13px;">10% Instant discount on HDFC credit cards on a minimum spend of 3000/- TCA</p>
                                            <p class="coupons"><span class="float-right"><a href="#" style="color: red;">Show more</a></span></p>
                                        </div>
                                    </div> -->
                        <h1 class="cart-section-title">

                            <input type="checkbox" name="checkbox1" id="checkbox1" checked="true" readonly>
                            <!-- <span id="checkbox_count"></span> -->
                            <span id="cart_count_1"> <?php echo get_cart_product_count(); ?></span>/<span id="cart_count_2"><?php echo get_cart_product_count(); ?></span>
                            <?php echo ("ITEMS SELECTED"); ?>
                            <span style="float:right; cursor: pointer;">
                                <a href="javascript:void(0)" onclick="remove_all()" style=" cursor: pointer;"><?php echo trans("remove"); ?></a> |
                                <span><a onclick="wishlist_all()" style="cursor: pointer;"><?php echo trans("add_to_wishlist"); ?></a></span>
                            </span>
                        </h1>
                        <?php if (!empty($cart_items)) :
                            foreach ($cart_items as $cart_item) :
                                $stock_quantity = (int)get_product($cart_item->product_id)->stock;

                                // var_dump($cart_item);
                                // if(auth_check()):
                                //     $user_products = get_user_products($this->auth_user->id, $cart_item->product_id);
                                // endif;
                                // var_dump(round($cart_total->total_price/100));
                                $product = get_active_product($cart_item->product_id);
                                if (!empty($product)) :
                                    //  if (empty($this->auth_user)) :
                                    $user_id_array = $product->user_id;
                                    $user_products = get_user_products($user_id_array, $cart_item->product_id);
                                    // endif; 
                        ?>
                                    <div class="row" id='<?php echo $cart_item->cart_item_id; ?>' style="width:100%;">
                                        <div class="white-box" style="margin-left:15px;padding:0;">


                                            <div class="item col-sm-12">
                                                <div class="cart-item-image">
                                                    <div class="img-cart-product">
                                                        <?php if (empty($cart_item->variation_option)) : ?>
                                                            <a href="<?php echo generate_product_url($product); ?>">
                                                                <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_product_image($cart_item->product_id, 'image_small'); ?>" alt="<?php echo html_escape($cart_item->product_title); ?>" class="lazyload img-fluid img-product" onerror="this.src='<?php echo get_product_image($cart_item->product_id, 'image_small'); ?>'">
                                                            </a>
                                                        <?php else : ?>
                                                            <a href="<?php echo generate_product_url($product); ?>">
                                                                <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_variation_main_option_image_url($cart_item->variation_option, null); ?>" alt="<?php echo html_escape($cart_item->product_title); ?>" class="lazyload img-fluid img-product" onerror="this.src='<?php echo get_product_image($cart_item->product_id, 'image_small'); ?>'">
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="cart-item-details">
                                                    <?php if ($product->product_type == 'digital') : ?>
                                                        <div class="list-item">
                                                            <label class="label-instant-download label-instant-download-sm"><i class="icon-download-solid"></i><?php echo trans("instant_download"); ?></label>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="list-item">
                                                        <a href="<?php echo generate_product_url($product); ?>">
                                                            <?php echo html_escape($cart_item->product_title); ?>
                                                            <!-- <input type="checkbox" name="checkbox" id="checkbox" class='checkbox' checked="true" value="1" readonly> -->
                                                        </a>
                                                        <br>

                                                        <a style="color: #007C05; cursor:pointer;" data-toggle="modal" data-target="#Modal_info_<?php echo $cart_item->product_id; ?>">Add/Edit Customisation Detail</a>

                                                        <?php if ($product->add_meet == "Made to stock") : ?>
                                                            <?php if (empty(check_product_stock($product))) : ?>
                                                                <div class="lbl-enough-quantity"><?php echo trans("out_of_stock"); ?></div>
                                                            <?php endif; ?>
                                                        <?php else : ?>
                                                            <?php if (empty(check_product_stock($product))) : ?>
                                                                <div class="lbl-enough-quantity"><?php echo trans("not_available"); ?></div>
                                                        <?php endif;
                                                        endif; ?>

                                                    </div>
                                                    <div class="list-item seller">
                                                        <?php echo trans("by"); ?>&nbsp;<a href="<?php echo generate_profile_url($product->user_slug); ?>"><?php echo get_brand_name_product($product); ?></a>
                                                        <p style="margin-bottom:16px;"></p>
                                                    </div>
                                                    <div class="row" style="margin-left: 0%;">
                                                        <span style="float:left;"><a href="#" class="btn qty-block" name="Qty"> <strong> Qty </strong> </a> </span>
                                                        <div class="cart-item-quantity" style="float:left;">
                                                            <?php if ($cart_item->purchase_type == 'bidding') : ?>
                                                                <span><?php echo trans("quantity") . ": " . $cart_item->quantity; ?></span>
                                                            <?php else : ?>
                                                                <div class="number-spinner">

                                                                    <div class="input-group">
                                                                        <span class="input-group-btn">
                                                                            <button type="button" class="btn btn-default btn-spinner-minus" data-cart-item-id="<?php echo $cart_item->cart_item_id; ?>" data-dir="dwn">-</button>
                                                                        </span>
                                                                        <input type="text" id="q-<?php echo $cart_item->cart_item_id; ?>" class="form-control text-center" value="<?php echo $cart_item->quantity; ?>" data-product-id="<?php echo $cart_item->product_id; ?>" data-cart-item-id="<?php echo $cart_item->cart_item_id; ?>">
                                                                        <span class="input-group-btn">
                                                                            <!-- <?php var_dump($cart_item->quantity); ?> -->
                                                                            <?php if ((int)get_product($cart_item->product_id)->stock == 1) :
                                                                            ?>
                                                                                <button type="button" class="btn btn-default" data-cart-item-id="<?php echo $cart_item->cart_item_id; ?>" data-dir="up" data-cart-quantity="<?php echo $cart_item->is_stock_available; ?>">+</button>
                                                                            <?php elseif ((int)$cart_item->quantity >= (int)get_product($cart_item->product_id)->stock) :

                                                                            ?>
                                                                                <button type="button" class="btn btn-default" disabled data-cart-item-id="<?php echo $cart_item->cart_item_id; ?>" data-dir="up" data-cart-quantity="<?php echo $cart_item->is_stock_available; ?>">+</button>
                                                                                <!-- <div> <span>
                                                                                                <label style="color:red;">No More Stock to add</label></span>
                                                                                        </div> -->
                                                                            <?php else : ?>
                                                                                <button type="button" class="btn btn-default btn-spinner-plus" data-cart-item-id="<?php echo $cart_item->cart_item_id; ?>" data-dir="up" data-cart-quantity="<?php echo $cart_item->is_stock_available; ?>">+</button>
                                                                            <?php endif; ?>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>

                                                    </div>

                                                    <?php if (!empty($cart_item->additional_info)) : ?>
                                                        <div class="list-item" style="margin-top: 2%;">
                                                            <p>
                                                                <strong><?php echo trans("customisation_detail"); ?></strong>
                                                                <?php echo ($cart_item->additional_info); ?>
                                                            </p>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="cart-item-quantity">
                                                    <div class="list-item m-t-15">

                                                        <!-- <label><?php echo trans("unit_price"); ?>:</label> -->
                                                        <strong class="lbl-price-new">
                                                            <?php echo price_formatted($cart_item->unit_price, $cart_item->currency); ?>
                                                        </strong>
                                                    </div>
                                                    <div class="list-item">
                                                        <!-- <label><?php echo trans("total"); ?>:</label> -->
                                                        <?php if (($cart_item->discount_rate) != 0) : ?>
                                                            <del class="discount-original-price-new">
                                                                <?php echo price_formatted($cart_item->listing_price, $product->currency); ?>
                                                            </del>

                                                        <?php endif; ?>
                                                        <?php if (($cart_item->discount_rate) == 0) : ?>
                                                            <p></p>
                                                        <?php endif; ?>
                                                        <?php
                                                        if (!empty($cart_item->discount_rate)) : ?>
                                                            <span class="discount-rate-cart-new">
                                                                <?php echo discount_rate_format($cart_item->discount_rate); ?>
                                                            </span>
                                                        <?php endif; ?>

                                                        <!-- <strong class="lbl-price"><?php echo price_formatted($cart_item->total_price, $cart_item->currency); ?></strong> -->
                                                    </div>
                                                    <!-- <?php if (!empty($product->gst_rate)) : ?>
                                                                <div class="list-item">
                                                                    <label><?php echo trans("vat"); ?>&nbsp;(<?php echo $product->gst_rate; ?>%):</label>
                                                                    <strong class="lbl-price"><?php echo price_formatted($cart_item->product_gst, $cart_item->currency); ?></strong>
                                                                </div>
                                                            <?php endif; ?> -->
                                                    <!-- <?php if ($product->product_type != 'digital' && $this->form_settings->shipping == 1) : ?>
                                                                <div class="list-item">
                                                                    <label><?php echo trans("shipping"); ?>:</label>
                                                                    <strong><?php echo price_formatted($cart_item->shipping_cost, $cart_item->currency); ?></strong>
                                                                </div>
                                                            <?php endif; ?> -->
                                                    <span><a href="javascript:void(0)" onclick="remove_from_cart('<?php echo $cart_item->cart_item_id; ?>');"> <?php echo trans("remove"); ?>
                                                            <?php
                                                            $whislist_button_class = "";
                                                            $whislist_button_class = (empty($product->demo_url) && $product->listing_type == 'ordinary_listing') ? "btn-wishlist-classified" : "";

                                                            if ($this->product_model->is_product_in_wishlist($product->id) == 0) : ?>
                                                                <a href="javascript:void(0)" class="btn-wishlist btn-add-remove-wishlist <?php echo $whislist_button_class; ?> wishlist-all" data-product-id="<?php echo $product->id; ?>" data-reload="1" onclick="remove_from_cart('<?php echo $cart_item->cart_item_id; ?>');"><span>|<?php echo trans("add_to_wishlist"); ?></span></a>

                                                            <?php endif; ?>
                                                        </a></span>

                                                </div>
                                                <?php if (!$product->deliverable) : ?>
                                                    <p class="not-avail-product">
                                                        **Product is not available at your location.**
                                                    </p>
                                                <?php endif; ?>
                                            </div>


                                        </div>

                                    </div>
                                <?php endif; ?>
                                <div class="modal fade" id="Modal_info_<?php echo $cart_item->product_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content modal-custom">
                                            <!-- form start -->
                                            <?php echo form_open('cart_controller/set_sess_add_additional_info'); ?>
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?php echo "Add/Edit Customisation Detail"; ?></h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span aria-hidden="true"><i class="icon-close"></i> </span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row tracking-number-container">
                                                    <div class="col-sm-12">
                                                        <input type="hidden" name="order_product_id" id="order_product_id" value="<?php echo $cart_item->product_id; ?>">
                                                        <div class="form-group" id="additional_info_<?php echo $cart_item->product_id; ?>">
                                                            <textarea class="form-control" id="additional_info_text_<?php echo $cart_item->product_id; ?>" name="additional_info_text_<?php echo $cart_item->product_id; ?>" value="<?php echo !empty($cart_item->additional_info) ? $cart_item->additional_info : ""; ?>" row='3'><?php echo !empty($cart_item->additional_info) ? $cart_item->additional_info : ""; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?php echo trans("close"); ?></button>
                                                <button type="submit" value="add_info" name="submit" class="btn btn-md btn-primary"><?php echo trans("submit"); ?></button>
                                            </div>
                                            <?php echo form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                        <?php endforeach;
                        endif; ?>

                    </div>
                    <a href="<?php echo lang_base_url(); ?>" class="btn btn-md btn-custom m-t-15"><i class="icon-arrow-left m-r-2"></i><?php echo trans("keep_shopping") ?></a>
                </div>
                <div class="col-sm-12 col-lg-4">
                    <!-- <div class="coupons-container">
                                    <div class="col-sm-12">
                                        <p><strong> <?php echo ("Coupons"); ?> </strong><img src="assets/img/voucher.png" width="23" height="23"></p>
                                        <p><?php echo ("Apply Coupons"); ?> <span class="float-right"><a href="#" class="btn apply-block" name="Apply"> <strong> Apply </strong> </a> </span> </p>
                                        <?php if ($this->auth_check) : ?>
                                            <input type="text" name="coupon">
                                        <?php else : ?>
                                            <p class="coupons"><a href="javascript:void(0)" style="color: red !important;" class="link registertologin" data-toggle="modal" data-target="#loginModal"><?php echo trans("login"); ?></a> to see the best coupons for you</p>
                                        <?php endif; ?>

                                    </div>
                                </div> -->

                    <div class="right">
                        <p>
                            <strong style="font-size:18px;"><?php echo ("Price Details"); ?></strong>
                        </p>

                        <p>
                            <?php echo ("Total MRP"); ?><span class="float-right" id="total_number"><?php echo price_formatted($cart_total->subtotal, $cart_total->currency); ?>/-</span>
                        </p>
                        <?php if (!empty($cart_total->gst)) : ?>
                            <!-- <p>
                                            <?php echo trans("vat"); ?><span class="float-right"><?php echo price_formatted($cart_total->gst, $cart_total->currency); ?>/-</span>
                                        </p> -->
                        <?php endif; ?>
                        <?php if (!empty($cart_items)) :
                            $discount = 0;
                            foreach ($cart_items as $cart_item) :
                                $product = get_active_product($cart_item->product_id);
                                if (!empty($product)) : ?>
                                    <?php $discount += ($cart_item->discount_amount) * $cart_item->quantity; ?>
                            <?php endif;
                            endforeach; ?>
                            <p>
                                <?php echo ("Discount"); ?><span class="float-right" id="discount_number" style="color: #75f14f;">&#8377;<?php echo (round($discount, 2)) ?>/-</span>
                            </p>
                        <?php endif; ?>
                        <?php if ($cart_has_physical_product == true && $this->form_settings->shipping == 1) : ?>
                            <p>
                                <?php echo trans("shipping"); ?><span class="float-right"><?php echo trans("yet_to_be") ?></span>
                            </p>
                        <?php endif; ?>
                        <p class="line-seperator"></p>
                        <p>
                            <!-- <?php var_dump($_SESSION["mds_shopping_cart_total"]->subtotal);  ?> -->
                            <strong><?php echo trans("total"); ?><span class="float-right" id="total_final"><?php echo price_formatted($cart_total->total, $cart_total->currency); ?>/-</span></strong>
                        </p>
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
                                    <a href="javascript:void(0)" class="btn btn-block"> <strong><?php echo trans("continue_to_checkout"); ?> </strong></a>
                                <?php else : ?>
                                    <?php if (empty($this->auth_check) && $this->general_settings->guest_checkout != 1) : ?>
                                        <a href="#" class="btn btn-block" data-toggle="modal" data-target="#loginModal"> <strong><?php echo trans("continue_to_checkout"); ?> </strong></a>
                                        <?php elseif (!empty($this->auth_check)) :
                                        if (($this->auth_user->phone_number) == '') : ?>
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
                                                <a href="#" class="btn btn-block" data-toggle="modal" data-target="#made_to_order_checkout"> <strong><?php echo trans("continue_to_checkout"); ?> </strong></a>
                                            <?php else : ?>
                                                <?php if ($cart_has_physical_product == true && $this->form_settings->shipping == 1) : ?>
                                                    <a href="<?php echo generate_url("cart", "shipping"); ?>" class="btn btn-block"> <strong><?php echo trans("continue_to_checkout"); ?> </strong></a>
                                                <?php else : ?>
                                                    <a href="<?php echo generate_url("cart", "payment_method"); ?>" class="btn btn-block" onclick="checkreview()"> <strong><?php echo trans("continue_to_checkout"); ?> </strong>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                    <?php endif;
                                    endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </p>

                        <div class="payment-icons">
                            <img src="<?php echo base_url(); ?>assets/img/payment/visa.svg" alt="visa">
                            <img src="<?php echo base_url(); ?>assets/img/payment/mastercard.svg" alt="mastercard">
                            <img src="<?php echo base_url(); ?>assets/img/payment/maestro.svg" alt="maestro">
                            <img src="<?php echo base_url(); ?>assets/img/payment/amex.svg" alt="amex">
                            <img src="<?php echo base_url(); ?>assets/img/payment/discover.svg" alt="discover">
                        </div>
                    </div>
                </div>
            </div>

        </div>

    <?php else : ?>
        <div class="shopping-cart-empty">
            <img src="<?php echo base_url(); ?>assets/img/empty-cart.png" id="empty_cart">
            <p id="ideal_cart"><strong class="font-900"><?php echo trans("ideal_cart"); ?></strong></p>
            <p class="add_cart"><?php echo trans("add_product_cart"); ?></p>
            <!-- <p><strong class="font-600"><?php echo trans("your_cart_is_empty"); ?></strong></p>
                        <a href="<?php echo lang_base_url(); ?>" class="btn btn-lg btn-custom"><i class="icon-arrow-left"></i>&nbsp;<?php echo trans("shop_now"); ?></a> -->
        </div>
    <?php endif; ?>
</div>