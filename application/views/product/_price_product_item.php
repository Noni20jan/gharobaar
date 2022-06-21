<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .discount_rate {
        float: right;
        color: #fff;
        padding-left: 8px;
        padding-right: 4px;
        background-color: #6c7f5d;
    }

    @media(max-width:700px) {
        .discount_rate {
            float: right;
            color: #fff;
            padding-left: 0px;
            padding-right: 0px;
            background-color: #6c7f5d;
        }
    }
</style>
<?php if ($product->is_free_product == 1) : ?>
    <span class="price-free"><?php echo trans("free"); ?></span>
<?php else : ?>
    <?php if ($product->listing_type == 'bidding') : ?>
        <a href="<?php echo generate_product_url($product); ?>" class="a-meta-request-quote"><?php echo trans("request_a_quote") ?></a>
    <?php else : ?>
        <span class="price" itemprop="price"><?php echo price_formatted(calculate_product_price($product->price, $product->discount_rate, $product->gst_rate), $product->currency); ?></span>

        <?php if (!empty($product->price)) :
            if (!empty($product->discount_rate)) : ?>
                <del class="discount-original-price" style="left:6px;">
                    <?php echo price_formatted($product->price, $product->currency); ?>
                </del>
                <?php if ($product->discount_rate > 10) : ?>
                    <span class="discount_rate">-<?= $product->discount_rate; ?>%</span>
                <?php endif; ?>
            <?php endif; ?>
<?php endif;
    endif;
endif; ?>