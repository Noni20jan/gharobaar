<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
    .zoom {
        transition: transform .2s;
    }

    #cvl {
        position: absolute;

        left: 114px;
        float: right;
        color: #fff;
        background-color: red;
    }

    @media(max-width:700px) {
        #cvl {
            position: absolute;

            left: 57px;
            float: right;
            color: #fff;
            background-color: red;
        }
    }

    .zoom:hover {
        -ms-transform: scale(1.25);
        /* IE 9 */
        -webkit-transform: scale(1.25);
        /* Safari 3-8 */
        transform: scale(1.25);
    }
</style>
<?php //var_dump($product);
//die();
?>
<?php //if ($product->add_meet == "Made to stock") : 
?>
<?php $variation = $this->variation_model->get_product_variations($product->id);

if (!empty($variation)) { ?>

    <?php $variations_stock = 0; //var_dump($variation);
    foreach ($variation as $variations) :
        $variation_option = $this->variation_model->get_variation_options($variations->id);

        foreach ($variation_option as $variation_stock) :
            $variations_stock = $variations_stock + $variation_stock->stock;
        endforeach;
    endforeach; ?>
<?php } ?>
<?php //endif; 
?>
<div class="product-item">
    <div class="row-custom<?php echo (!empty($product->image_second)) ? ' product-multiple-image' : ''; ?>">
        <a class="item-wishlist-button item-wishlist-enable <?php echo (is_product_in_wishlist($product) == 1) ? 'item-wishlist' : ''; ?>" data-product-id="<?php echo $product->id; ?>"></a>
        <div class="img-product-container">
            <?php if (!empty($is_slider)) : ?>
                <a href="<?php echo generate_product_url($product); ?>">
                    <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-lazy="<?php echo get_product_item_image($product); ?>" alt="<?php echo get_product_title($product); ?>" class="img-fluid img-product">
                    <?php if (!empty($product->image_second)) : ?>
                        <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-lazy="<?php echo get_product_item_image($product, true); ?>" alt="<?php echo get_product_title($product); ?>" class="img-fluid img-product img-second">
                    <?php endif; ?>
                </a>
            <?php else : ?>
                <a href="<?php echo generate_product_url($product); ?>">
                    <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_product_item_image($product); ?>" alt="<?php echo get_product_title($product); ?>" class="lazyload img-fluid img-product">
                    <?php if (!empty($product->image_second)) : ?>
                        <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_product_item_image($product, true); ?>" alt="<?php echo get_product_title($product); ?>" class="lazyload img-fluid img-product img-second">
                    <?php endif; ?>
                </a>
            <?php endif; ?>
            <?php if (!empty($this->auth_check) && $this->auth_user->role == "vendor" && $product->user_id == $this->auth_user->id) : ?>
                <!-- <div class="cart-top">
                    <a href="javascript:void(0)" class="item-options btn-add-to-cart" data-toggle="tooltip" data-placement="left" data-product-id="<?php echo $product->id; ?>" data-reload="0" title="<?php echo trans("add_to_cart"); ?>">
                        <i class="icon-cart"></i>
                    </a>
                </div> -->
            <?php else : ?>
                <div class="cart-top">
                    <?php $disabled = "";
                    if (empty($variation)) { ?>
                        <?php if (check_product_stock($product)) {
                            $disabled = " disabled"; ?>

                            <a href="javascript:void(0)" class="item-options btn-add-to-cart zoom" data-toggle="tooltip" data-placement="left" data-product-id="<?php echo $product->id; ?>" data-reload="0" title="<?php echo trans("add_to_cart"); ?>">
                                <i class="icon-cart cart-size "></i>
                            </a>
                        <?php } ?>
                    <?php } else { ?>
                        <?php if ($variations_stock != 0) { ?>
                            <a href="javascript:void(0)" class="item-options btn-add-to-cart zoom" data-toggle="tooltip" data-placement="left" data-product-id="<?php echo $product->id; ?>" data-reload="0" title="<?php echo trans("add_to_cart"); ?>">
                                <i class="icon-cart cart-size "></i>
                            </a>
                        <?php } ?>
                    <?php } ?>

                </div>
            <?php endif; ?>
            <?php if (empty($variation)) { ?>
                <?php if (!check_product_stock($product)) { ?>
                    <span class="badge badge-dark badge-promoted" id="cvl">Out Of Stock</span>
                <?php } ?>
            <?php } else { ?>
                <?php if ($variations_stock == 0) { ?>
                    <span class="badge badge-dark badge-promoted" id="cvl">Out Of Stock</span>
                <?php } ?>
            <?php } ?>
            <?php if (get_vendor_shop_status($product->user_id) == 0) : ?>

                <span class="badge badge-dark badge-promoted" id="cvl">Shop Closed</span>
            <?php else : ?>


                <span class="badge badge-dark badge-promoted" style="display:none"></span>
            <?php endif; ?>

            <div class="product-item-options">
                <?php if ($this->auth_check) : ?>
                    <?php if ($this->auth_user->user_type != "guest") : ?>
                        <a href="javascript:void(0)" class="item-option btn-add-remove-wishlist zoom whishlist-position" onclick="wishlist_login();" data-toggle="tooltip" data-placement="left" data-product-id="<?php echo $product->id; ?>" data-reload="0" title="<?php echo trans("wishlist"); ?>">
                            <?php if (is_product_in_wishlist($product) == 1) : ?>
                                <i class="icon-heart "></i>
                            <?php else : ?>
                                <i class="icon-heart-o"></i>
                            <?php endif; ?>
                        </a>
                    <?php else : ?>
                        <!-- hide wishlist for guest user -->
                        <a href="javascript:void(0)" class="item-option zoom whishlist-position" data-toggle="modal" data-id="0" data-target="#registerModal" title="<?php echo trans("wishlist"); ?>">
                            <?php if (is_product_in_wishlist($product) == 0) : ?>

                                <i class="icon-heart-o"></i>
                            <?php endif; ?>
                            <!-- <li class=" icon-bg">
                            <a href="<?php echo generate_url("wishlist") . "/" . $this->auth_user->slug; ?>">
                                <i class="icon-heart-o"></i>
                            </a>
                            </li> -->
                        <?php endif; ?>
                    <?php else : ?>
                        <a href="javascript:void(0)" class="item-option btn-add-remove-wishlist zoom whishlist-position" onclick="wishlist_login();" data-toggle="tooltip" data-placement="left" data-product-id="<?php echo $product->id; ?>" data-reload="0" title="<?php echo trans("wishlist"); ?>">
                            <i class="icon-heart-o"></i>
                        <?php endif; ?>
            </div>

            <?php if (!empty($product->discount_rate) && !empty($discount_label)) : ?>
                <span class="badge-discount">-<?= $product->discount_rate; ?>%</span>
            <?php endif; ?>
        </div>
        <?php if ($product->is_promoted && $this->general_settings->promoted_products == 1 && isset($promoted_badge) && $promoted_badge == true) : ?>
            <span class="badge badge-dark badge-promoted"><?php echo trans("featured"); ?></span>
        <?php endif; ?>
    </div>
    <div class="row-custom item-details">
        <h3 class="product-title">
            <a href="<?php echo generate_product_url($product); ?>"><?= get_product_title($product); ?></a>
        </h3>
        <p class="product-user text-truncate">
            <a href="<?php echo generate_profile_url($product->user_slug); ?>">
                <?php echo ucfirst(get_brand_name_product($product)); ?>

            </a>
        </p>
        <div class="item-meta">
            <?php $this->load->view('product/_price_product_item', ['product' => $product]); ?>
        </div>
    </div>
</div>
<script>
    function wishlist_login() {
        $(this).find('i').toggleClass('icon-heart-o')
        $('#loginModal').modal('show');
    }
</script>