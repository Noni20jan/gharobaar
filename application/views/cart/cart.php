<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/progress-tracker.css">
<style>
    #keep_shopping {
        position: relative;
        top: 26px;
    }

    @media(max-width:700px) {
        #keep_shopping {
            position: relative;
            top: 11px;
        }
    }

    .login-modal .auth-box {
        width: 100%;
    }

    .out_of_stock {
        width: 100%;
    }

    #remove_cart {
        background-color: #e4e4e4;
        border: 1px solid #e4e4e4;
        padding: .42rem .9rem;
        position: relative;
        /* right: 375px;
        top: 209px; */

    }


    @media (max-width: 700px) {
        #remove_cart {
            background-color: #e4e4e4;
            border: 1px solid #e4e4e4;
            padding: .42rem .9rem;
            border-radius: .1875rem;
            position: relative;
            right: -4px;
            top: 8px;
        }
    }

    #add_to_wishlist {
        position: relative;
        left: 10px;
        /* top: 181px; */
        padding: 0px 5px;
        background-color: #e4e4e4;
    }

    #add_to_wishlist_1 {
        position: relative;
        left: 10px;
        /* top: 181px; */
        padding: 0px 5px;
        background-color: #e4e4e4;
    }


    @media (max-width: 700px) {
        #add_to_wishlist_1 {
            position: relative;
            left: 24px;
            top: 7px;
            padding-left: 5px;
            background-color: #e4e4e4;
        }
    }




    @media (max-width: 700px) {
        #add_to_wishlist {
            position: relative;
            left: 24px;
            top: 7px;
            padding-left: 5px;
            background-color: #e4e4e4;
        }
    }

    .shopping-cart-empty {
        width: 100%;
        text-align: center;
        padding: 60px 0;
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(20px);
        border-radius: 55px;
        font-weight: 900;
        line-height: 30.48px;

    }

    .lone {
        color: #007C05;
        cursor: pointer;
        content: "\A";
        white-space: pre;
    }

    @media (max-width: 700px) {

        .lone {
            color: #007C05;
            cursor: pointer;
            white-space: pre;
        }
    }


    .add_cart {
        font-family: 'Montserrat';
        font-weight: 600;
        font-size: 25px;
        line-height: 30.48px;

    }



    #bookmark_plus {
        width: 4%;
    }

    @media only screen and (max-width: 900px) {
        #bookmark_plus {
            width: 7%;
        }
    }


    #bookmark {
        width: 5%;
    }

    @media only screen and (max-width: 900px) {
        #bookmark {
            width: 7%;
        }
    }

    .whishlist-position {
        bottom: 17px;

    }

    .cart-top .item-options {
        display: block;
        position: relative;
        right: 10px;
        width: 35px;
        height: 35px;
        line-height: 40px;
        text-align: center;
        background-color: #423f3f85;
        color: #fff;
        border-radius: 100%;
        opacity: 0;
        margin-top: -14px;


    }

    .cart-size {
        font-size: 20px;
    }

    @media only screen and (max-width: 600px) {

        #empty_cart {
            margin-left: auto;
            margin-right: auto;
            width: 50%;

        }
    }



    .checkout-steps .divider {
        display: inline-block;
        border-top: 1px solid #696b79;
        height: 7px;
        width: 10%;
    }

    .checkout-steps .active {
        color: #000;
        border-bottom: none;
        font-weight: bold;

    }

    .checkout-steps .step {
        display: inline-block;
        letter-spacing: 0px;
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: bold;
        font-size: 20px;
    }


    /* .discount-rate-cart-new {
        position: relative;
        bottom: 53px;
        left: 6px;
    } */

    @media(max-width:700px) {
        .discount-rate-cart-new {
            position: relative;

        }
    }

    .number-spinner {
        width: 100px;
        position: relative;
        height: 44px;
        border: 1px solid #e4e4e4;
        border-radius: .1875rem;
        /* bottom: 152px;
        left: 413px; */
    }

    .m-t-15-new {
        background-color: black;
        border: none;
    }

    @media (max-width: 700px) {
        .number-spinner {
            width: 100px;
            position: relative;
            height: 44px;
            border: 1px solid #e4e4e4;
            border-radius: .1875rem;
            left: 212px;
            bottom: 151px;
        }
    }
</style>
<style type="text/css">
    p.detail {

        font-weight: 500;
        font-family: 'Montserrat';

    }

    span.name {
        font-weight: 600;
        font-family: 'Montserrat';
    }
</style>
<style>
    .coupons-div-header {
        font-weight: bolder;
        font-size: 18px;
        padding: 0px 0px 7px 0px;
    }

    .coupons-div-content {
        padding-bottom: 12px;
        position: relative;
        border-bottom: 1px solid #f5f5f6;
        padding-left: 36px;
    }

    .coupons-div-label {
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        padding: 7px 0;
    }

    .coupons-div-couponIcon {
        position: absolute;
        left: 0;
        top: 7px;
    }

    .coupons-div-button {
        float: right;
        padding: 4px 16px;
        position: absolute;
        color: #007C05;
        border: 1px solid #007C05;
        border-radius: 3px;
        text-transform: none;
        cursor: pointer;
        font-weight: 600;
        top: 0;
        right: 0;
        background: #fff;
        font-size: 12px;
    }

    .coupons-div-button-remove {
        float: right;
        padding: 4px 16px;
        position: absolute;
        color: #f15e4f;
        border: 1px solid #f15e4f;
        border-radius: 3px;
        text-transform: none;
        cursor: pointer;
        font-weight: 600;
        top: 0;
        right: 0;
        background: #fff;
        font-size: 12px;
    }

    #loading-coupon {
        position: fixed;
        display: none;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        text-align: center;
        opacity: 0.7;
        background-color: #fff;
        z-index: 9999;
    }

    #loading-image {
        position: absolute;
        top: 50%;
        left: 50%;
        z-index: 10000;
    }

    .hide-coupon-button {
        display: none;
    }

    .hide-coupon-discount {
        display: none;
    }

    .coupon-div-applied-label {
        font-size: 12px;
        color: #007C05;
        padding: 2px 10px
    }

    @media (max-width: 700px) {
        .word-cut {

            text-overflow: ellipsis;
            overflow: hidden;
            width: 160px;
            height: 1.2em;
            white-space: nowrap;
            display: block;
        }

        .cart-scroll-for-web {
            overflow-y: inherit !important;
            height: inherit !important;
            /* display: block !important; */
        }
    }

    .cart-scroll-for-web {
        overflow-y: scroll;
        width: 100%;
        overflow-y: auto;
        height: calc(100vh - 40px);

    }

    @media (max-width: 767px) {
        .shopping-cart .item .img-cart-product {
            width: 116px !important;
            height: 116px !important;
            margin: 0;
        }
    }

    .shop-closed-cart {
        text-align: justify;
        margin-bottom: 0px;
    }

    /* .cart-scroll-for-web {
        overflow-y: hidden;

    } */
</style>
<style>
    [title] {
        border-bottom: 1px dashed rgba(0, 0, 0, 0.2);
        border-radius: 2px;
        position: relative;
    }

    body.touched [title]>* {
        user-select: none;
    }

    body.touched [title]:hover>* {
        user-select: auto
    }

    body.touched [title]:hover:after {
        position: absolute;
        top: 100%;
        right: -10%;
        content: attr(title);
        border: 1px solid rgba(0, 0, 0, 0.2);
        background-color: white;
        box-shadow: 1px 1px 3px;
        padding: 0.3em;
        z-index: 1;
    }
</style>

<div id="wrapper" style="background:#fff;">
    <div class="container">
        <div class="fullwidth">
            <div class="container separator">
                <ul class="progress-tracker progress-tracker--text progress-tracker--center">
                    <li class="progress-step">
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
            <div class="col-12">
                <?php if ($cart_items != null) : ?>
                    <div class="shopping-cart">
                        <div class="row">
                            <div class="col-sm-12 col-lg-8">
                                <div class="left">
                                    <div class="delivery-date-container">
                                        <div class="col-sm-12"><b> Delivery Date </b></div>
                                    </div>
                                    <h1 id="total_products" class="cart-section-title">
                                        <input type="checkbox" name="checkbox1" id="checkbox1" checked="true" readonly>
                                        <?php echo get_cart_product_count(); ?>/<?php echo get_cart_product_count(); ?>
                                        <?php echo ("ITEMS SELECTED"); ?>
                                        <span style="float:right; cursor: pointer;">
                                            <a href="javascript:void(0)" onclick="remove_all()" style=" cursor: pointer;"><?php echo trans("remove"); ?></a> |
                                            <span><a onclick="wishlist_all()" style="cursor: pointer;"><?php echo trans("add_to_wishlist"); ?></a></span>
                                        </span>
                                    </h1>
                                    <div class="cart-scroll-for-web">
                                        <?php $is_shop_open = 1;
                                        if (!empty($cart_items)) :
                                            foreach ($cart_items as $cart_item) :
                                                $stock_quantity = (int)get_product($cart_item->product_id)->stock;

                                                $product = get_active_product($cart_item->product_id);

                                                if ($product->is_shop_open == 0) {
                                                    $is_shop_open = 0;
                                                }
                                                if (!empty($product)) :
                                                    $user_id_array = $product->user_id;
                                                    $user_products = get_user_products($user_id_array, $cart_item->product_id);
                                        ?>
                                                    <div class="row" id='<?php echo $cart_item->cart_item_id; ?>' style="width:100%;">
                                                        <div class="item white-box">
                                                            <div class="cart-item-image">
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
                                                                    </a>
                                                                    <br>
                                                                    <a class="lone" data-toggle="modal" data-target="#Modal_info_<?php echo $cart_item->product_id; ?>">Add/Edit Customisation Detail</a>

                                                                    <?php if (empty($cart_item->variation_option)) : ?>
                                                                        <?php if ($is_shop_open == 0) : ?>
                                                                            <div class="lbl-enough-quantity"><?php echo trans("shop_is_closed"); ?>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                        <?php if ($product->add_meet == "Made to stock") : ?>
                                                                            <?php if (!check_product_stock($product)) : ?>
                                                                                <div class="lbl-enough-quantity"><?php echo trans("out_of_stock"); ?>
                                                                                </div>
                                                                            <?php elseif ($product->stock < (int)$cart_item->quantity) : ?>
                                                                                <div class="lbl-enough-quantity">Only <?php echo $product->stock ?> units of this item is available with the seller right now</br>* Kindly change the number of units to <?php echo $product->stock ?> in cart to proceed *
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        <?php else : ?>
                                                                            <?php if (!check_product_stock($product)) : ?>
                                                                                <div class="lbl-enough-quantity"><?php echo trans("not_available"); ?></div>
                                                                            <?php elseif ($product->stock < (int)$cart_item->quantity) : ?>
                                                                                <div class="lbl-enough-quantity"><?php echo trans("not_available"); ?>
                                                                                </div>
                                                                        <?php endif;
                                                                        endif; ?>
                                                                    <?php else : ?>
                                                                        <?php if ($product->add_meet == "Made to stock") : ?>
                                                                            <?php if ($cart_item->variation_option->stock == 0) : ?>
                                                                                <div class="lbl-enough-quantity"><?php echo trans("out_of_stock"); ?></div>
                                                                            <?php endif; ?>
                                                                        <?php else : ?>
                                                                            <?php if ($cart_item->variation_option->stock == 0) : ?>
                                                                                <div class="lbl-enough-quantity"><?php echo trans("not_available"); ?></div>
                                                                        <?php endif;
                                                                        endif; ?>
                                                                    <?php endif; ?>
                                                                    <div class="row">
                                                                        <span id="maximum_stock_reached-<?php echo $cart_item->cart_item_id; ?>" style="color:red; margin-left:15px;"></span>
                                                                    </div>

                                                                </div>
                                                                <div class="list-item seller">
                                                                    <?php echo trans("by"); ?>&nbsp;<a href="<?php echo generate_profile_url($product->user_slug); ?>" title="<?php echo get_brand_name_product($product); ?>" class="word-cut"><?php echo get_brand_name_product($product); ?></a>
                                                                    <p style="margin-bottom:16px;"></p>
                                                                </div>
                                                                <div class="list-item">
                                                                    <label><?php echo trans("unit_price"); ?>:</label>
                                                                    <strong class="lbl-price-new">
                                                                        <?php echo price_formatted($cart_item->unit_price, $cart_item->currency); ?>
                                                                    </strong>
                                                                </div>
                                                                <?php if (($cart_item->discount_rate) != 0) : ?>
                                                                    <div class="list-item">

                                                                        <label>Discount:</label>
                                                                        <del class="discount-original-price-new">
                                                                            <?php echo price_formatted($cart_item->listing_price, $product->currency); ?>
                                                                        </del>
                                                                        <?php if (!empty($cart_item->discount_rate)) : ?>
                                                                            <span class="discount-rate-cart-new">
                                                                                <?php echo discount_rate_format($cart_item->discount_rate); ?>
                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <div class="list-item">
                                                                    <label><?php echo trans("total"); ?>:</label>
                                                                    <strong class="lbl-price-new" id="total_<?php echo $cart_item->cart_item_id; ?>">
                                                                        <?php echo price_formatted($cart_item->unit_price * $cart_item->quantity, $cart_total->currency); ?>
                                                                    </strong>
                                                                </div>

                                                                <?php if (!empty($cart_item->additional_info)) : ?>
                                                                    <div class="list-item" style="margin-top: 2%;">
                                                                        <p>
                                                                            <strong><?php echo trans("customisation_detail"); ?></strong>
                                                                            <?php echo ($cart_item->additional_info); ?>
                                                                        </p>
                                                                    </div>
                                                                <?php endif; ?>


                                                                <div class="list-item">
                                                                    <a href="javascript:void(0)" id="remove_cart" onclick="remove_from_cart('<?php echo $cart_item->cart_item_id; ?>');"> <i class="icon-close"></i><?php echo trans("remove"); ?> </a>
                                                                    <?php
                                                                    $whislist_button_class = "";
                                                                    $whislist_button_class = (empty($product->demo_url) && $product->listing_type == 'ordinary_listing') ? "btn-wishlist-classified" : "";
                                                                    if ($this->auth_check) :
                                                                        if ($this->product_model->is_product_in_wishlist($product->id) == 0) : ?>
                                                                            <?php if (isset($this->auth_check)) : ?>
                                                                                <?php if ($this->auth_user->user_type != "guest") : ?>
                                                                                    <a href="javascript:void(0)" id="add_to_wishlist" class="btn-wishlist btn-add-remove-wishlist <?php echo $whislist_button_class; ?> wishlist-all" data-product-id="<?php echo $product->id; ?>" data-reload="1" onclick="remove_from_cart('<?php echo $cart_item->cart_item_id; ?>');"><?php echo trans("add_to_wishlist"); ?></span></a>
                                                                                <?php else : ?>
                                                                                    <a href="javascript:void(0)" id="add_to_wishlist" class="btn-wishlist" data-toggle="modal" data-id="0" data-target="#registerModal"><?php echo trans("add_to_wishlist"); ?></a>

                                                                                    <!-- <a href="javascript:void(0)" id="add_to_wishlist" class="btn-wishlist btn-add-remove-wishlist <?php echo $whislist_button_class; ?> wishlist-all" data-product-id="<?php echo $product->id; ?>" data-reload="1" onclick="remove_from_cart('<?php echo $cart_item->cart_item_id; ?>');"><?php echo trans("add_to_wishlist"); ?></span></a> -->
                                                                                <?php endif; ?>
                                                                            <?php else : ?>
                                                                                <a href="javascript:void(0)" id="add_to_wishlist" class="btn-wishlist btn-add-remove-wishlist <?php echo $whislist_button_class; ?> wishlist-all" data-product-id="<?php echo $product->id; ?>" data-reload="1" onclick="remove_from_cart('<?php echo $cart_item->cart_item_id; ?>');"><?php echo trans("add_to_wishlist"); ?></span></a>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>
                                                                    <?php else : ?>
                                                                        <a id="add_to_wishlist_1" onclick="cart_wishlist()" class="btn-wishlist btn-add-remove-wishlist <?php echo $whislist_button_class; ?> wishlist-all" data-product-id="<?php echo $product->id; ?>" );><?php echo trans("add_to_wishlist"); ?></span></a>

                                                                    <?php endif; ?>

                                                                </div>
                                                            </div>
                                                            <?php if (empty($cart_item->variation_option)) : ?>
                                                                <input type="hidden" id="s-<?php echo $cart_item->cart_item_id; ?>" value="<?php echo (int)get_product($cart_item->product_id)->stock; ?>">
                                                            <?php else : ?>
                                                                <input type="hidden" id="s-<?php echo $cart_item->cart_item_id; ?>" value="<?php echo (int)($cart_item->variation_option)->stock; ?>">
                                                            <?php endif; ?>
                                                            <div class="cart-item-quantity" style="float:left;">
                                                                <div class="number-spinner">
                                                                    <div class="input-group">

                                                                        <span class="input-group-btn">
                                                                            <button type="button" class="btn btn-default btn-spinner-minus" data-cart-item-id="<?php echo $cart_item->cart_item_id; ?>" data-dir="dwn">-</button>
                                                                        </span>

                                                                        <input type="text" disabled style="background: white;" id="q-<?php echo $cart_item->cart_item_id; ?>" class="form-control text-center" value="<?php echo (int)$cart_item->quantity; ?>" data-product-id="<?php echo $cart_item->product_id; ?>" data-cart-item-id="<?php echo $cart_item->cart_item_id; ?>">
                                                                        <span class="input-group-btn">
                                                                            <?php if (empty($cart_item->variation_option)) : ?>
                                                                                <?php if ((int)get_product($cart_item->product_id)->stock == 1) :
                                                                                ?>
                                                                                    <button type="button" class="btn btn-default" data-cart-item-id="<?php echo $cart_item->cart_item_id; ?>" data-dir="up" data-cart-quantity="<?php echo $cart_item->is_stock_available; ?>">+</button>
                                                                                    <!-- <div> <span>
                                                                                                <label style="color:red;">No More Stock to add</label></span>
                                                                                        </div> -->
                                                                                <?php else : ?>
                                                                                    <button type="button" class="btn btn-default btn-spinner-plus" data-cart-item-id="<?php echo $cart_item->cart_item_id; ?>" data-dir="up" data-cart-quantity="<?php echo $cart_item->is_stock_available; ?>">+</button>
                                                                                <?php endif; ?>
                                                                            <?php else : ?>
                                                                                <?php if ($cart_item->variation_option->stock == 1) :
                                                                                ?>
                                                                                    <button type="button" class="btn btn-default" data-cart-item-id="<?php echo $cart_item->cart_item_id; ?>" data-dir="up" data-cart-quantity="<?php echo $cart_item->is_stock_available; ?>">+</button>

                                                                                    <!-- <div> <span>
                                                                                                <label style="color:red;">No More Stock to add</label></span>
                                                                                        </div> -->
                                                                                <?php else : ?>
                                                                                    <button type="button" class="btn btn-default btn-spinner-plus" data-cart-item-id="<?php echo $cart_item->cart_item_id; ?>" data-dir="up" data-cart-quantity="<?php echo $cart_item->is_stock_available; ?>">+</button>
                                                                                <?php endif; ?>
                                                                            <?php endif; ?>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>



                                                            <!-- </div> -->
                                                            <?php if (!$product->deliverable) : ?>
                                                                <p class="not-avail-product">
                                                                    **Product is not available at your location.**
                                                                </p>
                                                            <?php endif; ?>
                                                            <!-- </div> -->


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
                                                                <button type="button" class="btn btn-md btn-default" data-dismiss="modal" id="closer"><?php echo trans("close"); ?></button>
                                                                <button type="submit" value="add_info" name="submit" class="btn btn-md btn-primary"><?php echo trans("submit"); ?></button>
                                                            </div>
                                                            <?php echo form_close(); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php endforeach;
                                        endif; ?>

                                    </div>
                                </div>
                                <a href="<?php echo lang_base_url(); ?>" id="keep_shopping" class="btn btn-md btn-custom m-t-15"><i class="icon-arrow-left m-r-2"></i><?php echo trans("keep_shopping") ?></a>
                            </div>
                            <div class="col-sm-12 col-lg-4">
                                <div class="right">
                                    <?php
                                    if ($this->general_settings->coupon_functionality) :
                                        $this->load->view("partials/_apply_coupon");
                                    endif; ?>
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
                                            <?php echo ("Discount"); ?><span class="float-right" id="discount_number" style="color: #007C05;">&#8377;<?php echo (round($discount, 2)) ?>/-</span>
                                        </p>
                                    <?php endif; ?>
                                    <?php if ($cart_has_physical_product == true && $this->form_settings->shipping == 1) : ?>
                                        <p>
                                            <?php if ($this->general_settings->flat_ship_enable == 1) : ?>
                                                <?php if ($cart_total->total < 100000) : ?>
                                                    <?php echo trans("shipping"); ?><span class="float-right"><?php echo (price_formatted(10000, $cart_total->currency)); ?></span>
                                                <?php else : ?>
                                                    <?php echo trans("shipping"); ?><span class="float-right"><?php echo (price_formatted(0, $cart_total->currency)); ?></span>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <?php echo trans("shipping"); ?><span class="float-right"><?php echo trans("yet_to_be") ?></span>
                                            <?php endif; ?>
                                        </p>

                                    <?php endif; ?>
                                    <p style="color:#007C05;" id="coupon-discount-tag" class="<?php echo ((!empty($this->session->userdata('mds_shopping_cart_coupon')))) ? '' : 'hide-coupon-discount' ?>">
                                        <strong>
                                            <?php echo "Coupon Discount"; ?>
                                            <span class="float-right" id="coupon-discount-text">
                                                <?php if (!empty($this->session->userdata('mds_shopping_cart_coupon'))) :
                                                    $coupon_applied = $this->session->userdata('mds_shopping_cart_coupon'); ?>
                                                    <?php if ($cart_total->applied_coupon_discount > 0) : ?>
                                                        <?php echo "- " . price_formatted($cart_total->applied_coupon_discount, $this->payment_settings->default_currency) . "/-"; ?>
                                                    <?php elseif (!empty($cart_total->applied_coupon_source_type)) :
                                                        switch ($cart_total->applied_coupon_source_type):
                                                            case "FREESHIP":
                                                                echo "Less Shipping";
                                                                break;
                                                            case "EXHIBITION":
                                                                echo "Less Shipping and COD";
                                                                break;
                                                        endswitch;
                                                    ?>

                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </span>
                                        </strong>
                                    </p>
                                    <p class="line-seperator"></p>

                                    <p>
                                        <!-- <?php var_dump($_SESSION["mds_shopping_cart_total"]->subtotal);  ?> -->


                                        <?php if ($this->general_settings->flat_ship_enable == 1) : ?>

                                            <?php $cart_total->total_price = $cart_total->total_price; ?>
                                            <!-- <strong><?php echo trans("total"); ?><span class="float-right" id="total_final"><?php echo price_formatted($cart_total->total_price, $cart_total->currency); ?>/-</span></strong> -->
                                            <!-- <strong><?php echo trans("total"); ?><span class="float-right" id="total_final"><?php echo (price_formatted(($cart_total->total_price + (($this->general_settings->flat_ship_amount))), $cart_total->currency)); ?>/-</span></strong?> -->
                                            <?php //else:
                                            ?>
                                            <strong><?php echo trans("total"); ?><span class="float-right" id="total_final"><?php echo price_formatted($cart_total->total_price, $cart_total->currency); ?>/-</span></strong>

                                        <?php else : ?>
                                            <?php //if($cart_total->total_price<100000):
                                            ?>
                                            <!-- <strong><?php echo trans("total"); ?><span class="float-right" id="total_final"><?php echo price_formatted($cart_total->total_price, $cart_total->currency); ?>/-</span></strong> -->
                                            <!-- <strong><?php echo trans("total"); ?><span class="float-right" id="total_final"><?php echo price_formatted($cart_total->total_price, $cart_total->currency); ?>/-</span></strong> -->
                                            <?php //else:
                                            ?>
                                            <strong><?php echo trans("total"); ?><span class="float-right" id="total_final"><?php echo price_formatted($cart_total->total_price, $cart_total->currency); ?>/-</span></strong>
                                            <?php //endif;
                                            ?>
                                        <?php endif; ?>

                                        <?php $cart_seller_total = get_cart_seller_total();
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
                                        ?>


                                    </p>
                                    <div id="pay_button">
                                        <?php $this->load->view("cart/payment_button", ["cart_items" => $cart_items, "cart_total" => $cart_total]); ?>
                                    </div>


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
                        <a href="<?php echo lang_base_url(); ?>" id="keep_shopping" class="btn btn-md btn-custom m-t-15"><i class="icon-arrow-left m-r-2"></i><?php echo trans("keep_shopping") ?></a>

                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row text-center">
            <?php if ($this->auth_check) : ?>
                <div class="checkout-steps summary-section add-to-wishlist-container" style="padding: 1%;"> <a href="<?php echo generate_url("wishlist") . "/" . $this->auth_user->slug; ?>"><img src="<?php echo base_url(); ?>assets/img/bookmark-plus_2.svg" alt="bookmark plus icon" id="bookmark"><b> Add more products from Wishlist </b> </a></div>
            <?php else : ?>
                <div onclick="cart_wishlist()" class="checkout-steps summary-section add-to-wishlist-container" style="padding: 1%;"><img src="<?php echo base_url(); ?>assets/img/bookmark-plus_2.svg" alt="bookmark plus icon" id="bookmark_plus"><b> Add more products from Wishlist </b> </a></div>
            <?php endif; ?>
            <b>
            </b>
        </div>
    </div>


    <div class="container">
        <div class="col-sm-12 col-md-12" style="margin-top:25px;">
            <div class="profile-tab-content">
                <p style="margin-bottom:2rem;"><span class="wishlist-products">Products from your Wishlist</span></p>
                <div class="row row-product-items row-product">
                    <?php if (!empty($products)) :
                        foreach ($products as $product) : ?>
                            <?php if ($product->is_shop_open == "1") : ?>
                                <?php $category = $this->category_model->get_parent_categories_tree($product->category_id); ?>
                                <?php if (!empty($category[0]->id != 2)) : ?>
                                    <div class="col-4 col-sm-2 col-md-4 col-lg-2 col-product product-margin">
                                        <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => true]); ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                    <?php endforeach;
                    endif; ?>

                </div>
            </div>
            <div class="no-products">
                <?php if (empty($products)) : ?>
                    <?php echo ("No products to display !") ?>
                <?php endif; ?>
            </div>
            <div claszzion">
                <?php echo $this->pagination->create_links(); ?>
            </div>
            <div class="row-custom">
                <!--Include banner-->
                <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "profile", "class" => "m-t-30"]); ?>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="col-sm-12 col-md-12" style="margin-top:25px;">
            <div class="profile-tab-content">
                <p style="margin-bottom:2rem;"><span class="wishlist-products">You May also Like</span></p>
                <div class="row row-product">
                    <?php $count = 0;
                    if (!empty($user_id_array)) :
                        if (!empty($user_products)) :
                            foreach ($user_products as $item) :
                                if ($item->is_shop_open == "1") :
                                    if ($count < 5) : ?>
                                        <?php $category = $this->category_model->get_parent_categories_tree($product->category_id); ?>
                                        <?php if (!empty($category[0]->id != 2)) : ?>
                                            <div class="col-6 col-sm-2 col-md-4 col-lg-2 col-product product-margin">
                                                <?php $this->load->view('product/_product_item', ['product' => $item]); ?>
                                            </div>
                    <?php endif;
                                    endif;
                                    $count++;
                                endif;
                            endforeach;
                        endif;
                    endif; ?>
                </div>
                <div class="no-products">
                    <?php if (empty($user_products)) : ?>
                        <?php echo ("No products to display !") ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="made_to_order_checkout" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <p class="details">Your order contains product(s) that are made to order by homepreneurs, wherein supplier capacity or availability might be challenged, affecting serviceability. Supplier needs 2 business hours (10 AM to 8 PM) to confirm the order. <span class="name">We shall notify you as soon as the seller accepts or rejects the order. </span>Thanks for your patience & understanding.</p>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="Modal_info_<?php echo $cart_item->product_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?php echo trans("close"); ?></button>
                <?php if ($cart_has_physical_product == true && $this->form_settings->shipping == 1) : ?>
                    <a href="<?php echo generate_url("cart", "shipping"); ?>" class="btn btn-block"> <strong><?php echo trans("continue_to_checkout"); ?> </strong></a>
                <?php else : ?>
                    <a href="<?php echo generate_url("cart", "payment_method"); ?>" class="btn btn-block" onclick="checkreview()"> <strong><?php echo trans("continue_to_checkout"); ?> </strong>
                    </a>
                <?php endif; ?>


            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="shop_is_closed" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <p class="shop-closed-cart">Some products in your cart are not available currently since the seller is working at full capacity. Please try buying them at a later day</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button type="button" class="btn btn-md btn-default" data-dismiss="modal" style="background-color: #007C05; color:white;"><?php echo trans("close"); ?></button>
            </div>

        </div>
    </div>
</div>



<div class="modal fade" id="min_order_val_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-custom">
            <!-- form start -->

            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true"><i class="icon-close"></i> </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row tracking-number-container">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <p class="details">The minimum order value for <strong><?php echo ($shop_name_seller) ?></strong> is <strong><?php echo "₹" . ($check_min_order_value) ?></strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button type="button" class="btn btn-md btn-default" data-dismiss="modal" style="background-color: green; color:white;"><?php echo trans("close"); ?></button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="min_cart_val_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-custom">
            <!-- form start -->

            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true"><i class="icon-close"></i> </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row tracking-number-container">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <p class="details">The minimum order value for cart is <strong><?php echo price_formatted($this->general_settings->min_cart_value, $cart_item->currency); ?></strong></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button type="button" class="btn btn-md btn-default" data-dismiss="modal" style="background-color: green; color:white;"><?php echo trans("close"); ?></button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="out_of_stock" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <p class="details">Some of the items are not in stock. Please remove those to move forward.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button type="button" class="btn btn-md btn-default" data-dismiss="modal" style="background-color: #007C05; color:white;"><?php echo trans("close"); ?></button>
            </div>

        </div>
    </div>
</div>
<div id="remove_product" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-custom">
            <!-- form start -->
            <div class="modal-body" style="text-align: center;">
                <div class="row tracking-number-container">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <input type="hidden" id="cart_item_modal_id">
                            <p class="details">Are you sure you want to remove product from cart.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button type="button" class="btn btn-md btn-default" data-dismiss="modal" id="confirm_remove_no" style="background-color: #007C05; color:white;">No</button>
                <button type="button" class="btn btn-md btn-default" id="confirm_remove_yes" data-dismiss="modal" style="background-color: #007C05; color:white;">Yes</button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="product_not_available" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <p class="details">Some of the items are not deliverable to your address. Please remove those to move forward.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: center;">
                <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?php echo trans("close"); ?></button>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="Modal_info_<?php echo $cart_item->product_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="registerMobileModal" role="dialog" data-backdrop="static">
    <div class="modal-dialog-centered" role="document">
        <div class="modal-dialog modal-lg verifyModalWidth" id="mobile_otp">
            <div class="modal-body-new" style="">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom:none;background-color: #E5E4E2;">
                        <button type="button" class="close" id="cross-btn-cart" data-dismiss="modal" aria-label="Close" onclick="">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title">Verify Mobile Number</h5>
                    </div>
                    <div class="modal-body text-center" style="background-color: #E5E4E2;">
                        <div class="text-center" id="send-otp-result-cart"></div>
                        <center>
                            <label>Enter Mobile Number </label>
                            <!-- <?php echo $_SESSION['session_otp']; ?> -->
                            <input type="text" name="phone_number" id="phn_number" class="form-control auth-form-input phn_number_cart" placeholder="Mobile Number" value="<?php echo old("phone_number"); ?>" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" name="itemConsumption" minlength="10" maxlength="10" required>
                            <br><button type="button" id="verifyOTPbutton" class="btn btn-custom">Verify Mobile Number</button>
                            <br><span id="verify_mobile_span_cart" style="color:red;">*You cannot checkout without Mobile Verification!</span>
                        </center>
                        <br>
                        <div id="verify_otp_button" style="display:none;">
                            <center>
                                <input type="text" name="otp_field" id="otp_field_cart" class="form-control auth-form-input otp_field_width" placeholder="Enter OTP" value="" maxlength="255" required="">
                                <span id="otp_field_span_cart" style="color:red;"></span>
                            </center><br>
                            <div class="row text-center" id="verification_cart" style="justify-content:center;">

                                <button type="button" id="verify_btn_cart" class="btn btn-custom verify_btn_margin">Verify OTP</button>


                                <button type="button" id="resend_otp_cart" class="btn btn-custom verify_btn_margin" onclick="send_verification_otp()">Resend OTP</button>

                            </div>
                            <center><button type="button" id="close_btn_cart" data-dismiss="modal" class="btn btn-custom" style="display:none;">Close</button></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Wrapper End-->
<?php $this->load->view("partials/_modal_send_message", ["subject" => null]); ?>

<script>
    $(document).on("click", ".open_additional_info_dialog", function() {
        var orderProductId = $(this).data('id');
        $(".modal-body #order_product_id").val(orderProductId);
        // As pointed out in comments, 
        // it is unnecessary to have to manually call the modal.
    });
</script>
<script>
    $("#plus-btn").click(function() {
        var qty = parseInt($("#product_quantity").val());
        var res_qty = quantity(qty);
        if (res_qty == true) {
            $('#product_quantity').val(qty - 1);
        }
        var qty = parseInt($("#product_quantity").val());
        var stock = parseInt("<?php echo $product->stock; ?>");
        if (stock > qty && stock != 0) {
            qty += 1;
        }
    });
</script>


<script>
    function checkreview() {
        $.ajax({
            type: "POST",
            url: base_url + "cart_controller/checkReviews",
            data: data,
            success: success,
            dataType: dataType
        });
    }

    function count1() {
        // $('#checkbox_count')[0].innerHTML='';
        const checkboxes = document.querySelectorAll('input[class="checkbox"]:checked').length;
        $('#checkbox_count')[0].innerHTML = checkboxes;
        if ($('#checkbox_count')[0].innerHTML == "0") {
            $("#checkbox1").prop("checked", false);
        }
        if ($('#checkbox_count')[0].innerHTML != "0") {
            $("#checkbox1").prop("checked", true);
        }
    }

    window.onload = (event) => {
        count1();
        count_main();
    };

    function count_main() {
        $('#checkbox_count')[0].innerHTML = '';
        const checkboxes = document.querySelectorAll('input[class="checkbox"]:checked').length;
        $('#checkbox_count')[0].innerHTML = checkboxes;
    }

    $(document).ready(function() {
        // Check or Uncheck All checkboxes
        $("#checkbox1").change(function() {
            var checked = $(this).is(':checked');
            if (checked) {
                $(".checkbox").each(function() {
                    $(this).prop("checked", true);
                });
                $('#checkbox_count')[0].innerHTML = '';
                const checkboxes = document.querySelectorAll('input[class="checkbox"]:checked').length;
                $('#checkbox_count')[0].innerHTML = checkboxes;
            } else {
                $(".checkbox").each(function() {
                    $(this).prop("checked", false);
                });
                $('#checkbox_count')[0].innerHTML = '';
                // const checkboxes = document.querySelectorAll('input[class="checkbox"]:checked').length;
                $('#checkbox_count')[0].innerHTML = 0;
            }
        });

        // Changing state of CheckAll checkbox 
        $(".checkbox").click(function() {

            if ($(".checkbox").length == $(".checkbox:checked").length) {
                $("#checkbox").prop("checked", true);
            } else {
                $("#checkbox").removeAttr("checked");
            }


        });
    });

    function test() {
        var count = $('#checkbox_count')[0].innerHTML;
        return count;
    }

    function remove_all() {
        <?php if (!empty($cart_items)) :
            foreach ($cart_items as $cart_item) :
                $product = get_active_product($cart_item->product_id);
                if (!empty($product)) : ?>
                    remove_from_cart('<?php echo $cart_item->cart_item_id; ?>');
        <?php endif;
            endforeach;
        endif; ?>
    }

    function wishlist_all() {
        $('.wishlist-all').each(function() {
            $(this).trigger('click');
        });
        // remove_all();
    }
</script>
<script>
    $("#phn_number").change(function() {
        document.getElementById("verify_mobile_span_cart").innerHTML = "*You cannot checkout without Mobile Verification!";
    })

    $("#verify_btn_cart").click(function() {
        var input_otp = document.getElementById("otp_field_cart").value;
        var user_id = '<?php echo isset($this->auth_user->id) ? $this->auth_user->id : "0"; ?>';
        var phn_num = document.getElementById("phn_number").value;
        if (input_otp == '') {
            document.getElementById("otp_field_span_cart").innerHTML = "*Please Enter OTP";
        } else {
            document.getElementById("otp_field_span_cart").innerHTML = "";
            otp_verification_cart(input_otp, user_id, phn_num);
        }
    })

    $("#close_btn_cart").click(function() {
        $('#registerMobileModal').modal('hide');
    })

    $("#verifyOTPbutton").click(function() {
        document.getElementById("verify_mobile_span_cart").innerHTML = "";
        var phn_num = document.getElementById("phn_number").value;
        if (phn_num == '') {
            document.getElementById("verify_mobile_span_cart").innerHTML = "*Please enter mobile number !";
        } else if (phn_num.length != 10) {
            document.getElementById("verify_mobile_span_cart").innerHTML = "*Please enter correct mobile number !";
        } else if (phn_num != '' && phn_num.length == 10) {
            // document.getElementById("verify_otp_button").style.display = "block";
            // send_verification_otp_cart(phn_num);
            // if (phn_num.length != 10) {
            //     document.getElementById("verify_mobile_span_cart").innerHTML = "";
            // }
            var register_phn = check_for_mobile_register_js(phn_num);
            console.log(register_phn);
            if (register_phn == true) {
                document.getElementById("verify_mobile_span_cart").innerHTML = "";
                document.getElementById("verify_otp_button").style.display = "block";
                send_verification_otp_cart(phn_num, "mobile_otp");
            } else if (register_phn == false) {
                document.getElementById("verify_mobile_span_cart").innerHTML = "*Mobile number is already registered!";
            }
        }
    })

    $("#cross-btn-cart").click(function() {
        document.getElementById("phn_number").value = "";
        document.getElementById("verify_btn_cart").style.display = "none";
        document.getElementById("resend_otp_cart").style.display = "none";
        document.getElementById("close_btn_cart").style.display = "none";
        document.getElementById("otp_field_cart").style.display = "none";
        document.getElementById("verifyOTPbutton").disabled = false;
        document.getElementById("phn_number").disabled = false;
        document.getElementById("send-otp-result-cart").innerHTML = "";
        document.getElementById("verify_mobile_span_cart").innerHTML = "*You cannot checkout without Mobile Verification!";
    })

    $("#resend_otp_cart").click(function() {
        var phn_num = document.getElementById("phn_number").value;
        send_verification_otp_cart(phn_num, "mobile_otp");
    })
</script>
<script>
    function quantity(qty) {
        var stock = "<?php echo $product->stock; ?>";
        if (qty == parseInt(stock)) {
            return true;
        } else {
            return false;
        }
    }
</script>

<script>
    function cart_wishlist() {
        $('#loginModal').modal('show');
        // alert("ok");
    }
</script>
<script>
    document.body.addEventListener('touchstart', function() {
        document.body.classList.add('touched');
    });
    $(document).on("click", ".couponsForm-enabled", function() {
        var coupon_code = $("#coupon-input-field").val();
        var data = {
            "sys_lang_id": sys_lang_id,
            "coupon_code": coupon_code
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "checked-availability-coupon",
            data: data,
            beforeSend: function() {
                $('#loading-coupon').show();
            },
            success: function(response) {
                var res = JSON.parse(response);
                $('#loading-coupon').hide();
                if (res.status) {
                    $(".couponsForm-textInputContainer").removeClass("couponsForm-textInputError");
                    $(".couponsForm-errorMessage").html("");
                    $("#coupons-div-button-apply").addClass("hide-coupon-button");
                    $("#coupons-div-button-remove").removeClass("hide-coupon-button");
                    $("#coupons-div-label").html("1 Coupon Applied<div class='coupon-div-applied-label'>" + res.coupon_data.offer_code.toUpperCase() + "</div>");
                    $('#couponModalCenter').modal('hide');
                    $('#coupon-discount-tag').removeClass('hide-coupon-discount');
                    $('#coupon-discount-text').html("- ₹" + res.cart_total.applied_coupon_discount / 100 + " /-");
                    $("#total_final")[0].innerText = "₹" + res.cart_total.total_price / 100 + "/-";
                    $('#pay_button')[0].innerHTML = res.payment_button;
                    if (parseInt(res.cart_total.applied_coupon_discount) > 0) {
                        $("#coupon-discount-text")[0].innerText =
                            "- ₹" + res.cart_total.applied_coupon_discount / 100 + "/-";
                    } else {
                        switch (res.cart_total.applied_coupon_source_type) {
                            case "FREESHIP":
                                $("#coupon-discount-text")[0].innerText = "Less Shipping";
                                break;
                            case "EXHIBITION":
                                $("#coupon-discount-text")[0].innerText = "Less Shipping and COD";
                                break;
                        }
                    }

                } else {
                    $(".couponsForm-textInputContainer").addClass("couponsForm-textInputError");
                    $(".couponsForm-errorMessage").html(res.msg);
                }

            }
        });
    });
</script>