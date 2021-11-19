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
        <div class="row shop-by-seller-heading">
            <h3 class="style-for-seller">Shop By Category</h3>
        </div>

        <div class="row shop-by-center">
            <div class="col-2 two-for-mobile">
                <a href="<?php echo generate_url("top-categories/fashion"); ?>">
                    <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/fashion_imgs/fashion_2.png" alt="fashion">
                    <p class="category_page_title">Fashion</p>
                </a>
            </div>
            <div class="col-2 two-for-mobile">
                <a href="<?php echo generate_url("top-categories/home-cooks"); ?>">
                    <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/home_cooks_imgs/home_cooks_2.png" alt="home-cooks">
                    <p class="category_page_title">Home Cooks</p>
                </a>
            </div>
            <div class="col-2 two-for-mobile">
                <a href="<?php echo generate_url("top-categories/grocery"); ?>">
                    <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/groceries_imgs/groceries_4.png" alt="grocery">
                    <p class="category_page_title">Grocery</p>
                </a>
            </div>
            <div class="col-2 two-for-mobile">
                <a href="<?php echo generate_url("top-categories/home"); ?>">
                    <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/home_and_lifestyle_imgs/lifestyle_3.png" alt="home">
                    <p class="category_page_title">Home</p>
                </a>
            </div>
            <div class="col-2 two-for-mobile">
                <a href="<?php echo generate_url("top-categories/personal-care-lifestyle"); ?>">
                    <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/personal_care_imgs/personal_care_3.png" alt="personal-care-lifestyle">
                    <p class="category_page_title">Person Care & Lifestyle</p>
                </a>
            </div>
            <div class="col-2 two-for-mobile">
                <a href="<?php echo generate_url("top-categories/kids-corner"); ?>">
                    <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/kids_corner_imgs/kids_corner_5.png" alt="kids-cornor">
                    <p class="category_page_title">Kids Corner</p>
                </a>
            </div>
        </div>

        <div class="row shop-by-center">
            <div class="col-2 two-for-mobile">
                <a href="<?php echo generate_url("top-categories/art-stationery"); ?>">
                    <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/stationary_gifts_imgs/stationary_gifts_2.png" alt="art-stationery">
                    <p class="category_page_title">Art & Stationery</p>
                </a>
            </div>
            <div class="col-2 two-for-mobile">
                <a href="<?php echo generate_url("top-categories/gifts-festivities"); ?>">
                    <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/gifts_for_you_imgs/gifts_for_you_3.png" alt="gifts-festivities">
                    <p class="category_page_title">Gifts & Festivities </p>
                </a>
            </div>
        </div>
    </div>
</div>