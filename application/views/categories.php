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
            <!-- <div class="col-2 two-for-mobile">
                <a href="<?php echo generate_url("top-categories/home-cooks"); ?>">
                    <img class="shop_by_seller_imgs" src="<?php echo base_url(); ?>assets/img/home_cooks_imgs/home_cooks_2.png" alt="home-cooks">
                    <p class="category_page_title">Home Cooks</p>
                </a>
            </div> -->
            <div class="col-2 two-for-mobile">
                <a href="#" data-toggle="modal" data-target="#hide_home_cook">
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
<div class="modal fade" id="hide_home_cook" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <div class="form-group" style="margin-bottom:0px;">
                            <p class="details">This category is under development, we'll soon be ready to take many home cooked delicacies ghar se ghar tak.'</p>
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