<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    /* width */
    .col-12 .row .categories-for-mobile::-webkit-scrollbar {
        width: 4px;
    }

    .col-12 .row .categories-for-mobile {
        scrollbar-color: #fff0 #fff0;
    }
</style>
<div id="wrapper">
    <div class="container">
        <div class="row categories-for-mobile" id="only-for-mobile">
            <?php $this->load->view("partials/categories_for_mobile"); ?>
        </div>
        <div class="row shop-by-seller-heading">
            <h3 class="style-for-seller">Shop By Category</h3>
        </div>

        <div class="row shop-by-center">
            <div class="col-2 two-for-mobile">
                <a href="<?php echo generate_url("home-cooks/fresh-home-food"); ?>">
                    <img class="shop_by_seller_imgs" src="assets/img/home_cooks_imgs/home_cooks_1.png">
                    <p>Fresh Baked Items</p>
                </a>
            </div>
            <div class="col-2 two-for-mobile">
                <a href="<?php echo generate_url("home-cooks/fresh-baked-items"); ?>">
                    <img class="shop_by_seller_imgs" src="assets/img/home_cooks_imgs/home_cooks_2.png">
                    <p>Fresh Home Food</p>
                </a>
            </div>
        </div>

        <div class="row shop-by-seller-heading">
            <h3 class="style-for-seller">All in Category</h3>
        </div>
        <div class="row categories-for-mobile" style="padding-bottom: 12px;">
            <p class="all-in-categoty">Category 1</p>
            <p class="all-in-categoty">Category 2</p>
            <p class="all-in-categoty">Category 3</p>
            <p class="all-in-categoty">Category 4</p>
            <p class="all-in-categoty">Category 5</p>
            <p class="all-in-categoty">Category 6</p>
        </div>


        <div class="row" id="top-picks-container">
            <!--print products-->
            <?php foreach ($latest_products as $product) : ?>
                <?php if ($product->is_shop_open == "1") : ?>
                    <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                        <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => false, 'is_slider' => 0, 'discount_label' => 0]); ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div class="col-12 text-center">
            <div class="btn btn-md btn-view-more-new m-t-15 more" style="box-shadow: 2px 2px 5px #808080de !important;">
                <a id="show_more_products" class="view-new-text" href="<?= generate_url("products") ?>">View More Products</a><i class="fa fa-caret-down" style="color:black; margin-left:6px;"></i>
            </div>
        </div>

        <div class="row shop-by-seller-heading">
            <h3 class="style-for-seller">Recently Viewed</h3>
        </div>
        <div class="row categories-for-mobile" id="top-picks-container" style="margin-top: 10px; text-align:inherit !important;">
            <!--print products-->
            <?php foreach ($latest_products as $product) : ?>
                <?php if ($product->is_shop_open == "1") : ?>
                    <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                        <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => false, 'is_slider' => 0, 'discount_label' => 0]); ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

    </div>
</div>