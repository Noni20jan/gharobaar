<?php

$details = get_product_details_by_id($product->id);

$image = get_image_product($product->id);
//var_dump($image->image_small);
?>

<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="product-item">
    <div class="row-custom">

        <div>
            <?php if (!empty($is_slider)) : ?>
                <a href="#">
                    <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL_BARTER . $image->image_small; ?>" data-lazy="<?php echo base_url() . IMG_BG_PRODUCT_SMALL_BARTER . $image->image_small; ?>" alt="<?php echo $details->title; ?>" height="200" width="200">
                    <?php if (!empty($product->image_second)) : ?>
                        <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL_BARTER . $image->image_small; ?>" data-lazy="<?php echo base_url() . IMG_BG_PRODUCT_SMALL_BARTER . $image->image_small; ?>" alt="<?php echo $details->title; ?>" height="200" width="200" class="img-fluid img-product img-second">
                    <?php endif; ?>
                </a>
            <?php else : ?>
                <a href="#">
                    <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL_BARTER . $image->image_small; ?>" data-src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL_BARTER . $image->image_small; ?>" alt="<?php echo $details->title; ?>" height="200" width="200">
                    <?php if (!empty($product->image_second)) : ?>
                        <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL_BARTER . $image->image_small; ?>" data-src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL_BARTER . $image->image_small; ?>" alt="<?php echo $details->title; ?>" height="200" width="200" class="lazyload img-fluid img-product img-second">
                    <?php endif; ?>
                </a>
            <?php endif; ?>
            <!-- <div class="product-item-options">
                <a href="javascript:void(0)" class="item-option btn-add-remove-wishlist" data-toggle="tooltip" data-placement="left" data-product-id="<?php echo $product->id; ?>" data-reload="0" title="<?php echo trans("wishlist"); ?>">
                    <?php if (is_product_in_wishlist($product) == 1) : ?>
                        <i class="icon-heart"></i>
                    <?php else : ?>
                        <i class="icon-heart-o"></i>
                    <?php endif; ?>
                </a>
            </div> -->
            <?php if (!empty($product->discount_rate) && !empty($discount_label)) : ?>
                <span class="badge badge-discount">-<?= $product->discount_rate; ?>%</span>
            <?php endif; ?>
        </div>
        <?php if ($product->is_promoted && $this->general_settings->promoted_products == 1 && isset($promoted_badge) && $promoted_badge == true) : ?>
            <span class="badge badge-dark badge-promoted"><?php echo trans("featured"); ?></span>
        <?php endif; ?>
    </div>
    <div class="row-custom item-details">
        <h2 class="product-title">
            <a href="<?php echo generate_product_url($product); ?>"><?= $details->title ?></a>
        </h2>
        <p class="product-user text-truncate">

        </p>
        <?php $category = $this->category_model->get_parent_categories_tree($product->category_id); ?>
        <?php if (!empty($category[0]->id != 2)) : ?>
            <div class="item-meta">
                <?php $this->load->view('product/_price_product_item', ['product' => $product]); ?>
            </div>
        <?php endif; ?>
    </div>
</div>