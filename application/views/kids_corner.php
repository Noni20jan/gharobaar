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
                <a href="<?php echo generate_url("kids-corner/accessories"); ?>">
                    <img class="shop_by_seller_imgs" src="assets/img/kids_corner_imgs/kids_corner_1.png">
                    <p>Accessories</p>
                </a>
            </div>
            <div class="col-2 two-for-mobile">
                <a href="<?php echo generate_url("kids-corner/apparel"); ?>">
                    <img class="shop_by_seller_imgs" src="assets/img/kids_corner_imgs/kids_corner_2.png">
                    <p>Apparel</p>
                </a>
            </div>
            <div class=" col-2 two-for-mobile">
                <a href="<?php echo generate_url("kids-corner/diapering-feeding"); ?>">
                    <img class="shop_by_seller_imgs" src="assets/img/kids_corner_imgs/kids_corner_3.png">
                    <p>Diapering & Feeding</p>
                </a>
            </div>
            <div class=" col-2 two-for-mobile">
                <a href="<?php echo generate_url("kids-corner/food-products"); ?>">
                    <img class="shop_by_seller_imgs" src="assets/img/kids_corner_imgs/kids_corner_4.png">
                    <p>Food Products</p>
                </a>
            </div>
            <div class=" col-2 two-for-mobile">
                <a href="<?php echo generate_url("kids-corner/footwear"); ?>">
                    <img class="shop_by_seller_imgs" src="assets/img/kids_corner_imgs/kids_corner_5.png">
                    <p>Footwear</p>
                </a>
            </div>
            <div class=" col-2 two-for-mobile">
                <a href="<?php echo generate_url("kids-corner/fun-learning"); ?>">
                    <img class="shop_by_seller_imgs" src="assets/img/kids_corner_imgs/kids_corner_6.png">
                    <p>Fun & Learning</p>
                </a>
            </div>
            <div class=" col-2 two-for-mobile">
                <a href="<?php echo generate_url("kids-corner/kids-care-products"); ?>">
                    <img class="shop_by_seller_imgs" src="assets/img/kids_corner_imgs/kids_corner_7.png">
                    <p>Kids Care Products</p>
                </a>
            </div>
            <div class=" col-2 two-for-mobile">
                <a href="<?php echo generate_url("kids-corner/kids-room"); ?>">
                    <img class="shop_by_seller_imgs" src="assets/img/kids_corner_imgs/kids_corner_8.png">
                    <p>Kids Room</p>
                </a>
            </div>
            <div class=" col-2 two-for-mobile">
                <a href="<?php echo generate_url("kids-corner/school-stationery"); ?>">
                    <img class="shop_by_seller_imgs" src="assets/img/kids_corner_imgs/kids_corner_9.png">
                    <p>School Stationery</p>
                </a>
            </div>
        </div>

        <div class="row shop-by-seller-heading">
            <h3 class="style-for-seller">All in Category</h3>
        </div>
        <div class="row categories-for-mobile" style="padding-bottom: 12px; flex-wrap: nowrap;overflow-x: scroll;">
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
                    <?php $category = $this->category_model->get_parent_categories_tree($product->category_id); ?>
                        <?php if (!empty($category[0]->id!=2)) :?> 
                    <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                        <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => false, 'is_slider' => 0, 'discount_label' => 0]); ?>
                    </div>
                <?php endif; ?>
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
                    <?php $category = $this->category_model->get_parent_categories_tree($product->category_id); ?>
                        <?php if (!empty($category[0]->id!=2)) :?> 
                    <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                        <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => false, 'is_slider' => 0, 'discount_label' => 0]); ?>
                    </div>
                <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

    </div>
</div>