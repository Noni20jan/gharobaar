<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    @media(max-width:768px) {
        #only-for-mobile {
            display: flex !important;
        }

        .shop_by_seller_imgs {
            width: 100% !important;
            border-radius: 15px;
        }

        .categories-for-mobile {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            text-align: center;
            justify-content: space-between;
            padding: 0px;
            overflow-x: scroll;
        }
    }



    #only-for-mobile {
        display: none;
    }

    .categories_imgs {
        border-radius: 14px;
    }

    .categories_spacing {
        padding: 0px 6px;
    }

    .categories-text {
        font-size: 12px;
    }

    .shop_by_seller_imgs {
        width: 90%;
        border-radius: 15px;
    }

    .shop-by-center {
        text-align: center;
    }

    .shop-by-seller-heading {
        padding: 0 18px;
        margin-top: 20px;
    }

    .all-in-categoty {
        border: 1px solid #454545;
        border-radius: 20px;
        padding: 5px;
        margin: 0px 6px;
        color: #454545;
        /* font-weight: bold; */
        flex-wrap: nowrap;
        /* word-break: break-all; */
        white-space: nowrap;
    }

    .btn-view-more-new {
        background-color: #fff;
        border-color: #fff;
        border-radius: 20px;
    }

    .view-new-text {
        color: black;
        font-weight: bold;
    }

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
            <h3 class="style-for-seller">Shop By Concern</h3>
        </div>
        <div class="row shop-by-center">
            <?php $shop_concern = get_lookup_values_by_type("SHOP_BY_CONCERN"); ?>
            <?php foreach ($shop_concern as $concern) : ?>
                <div class="col-2 two-for-mobile">
                    <a href="<?= generate_url("shop_by_concern") . '/' . strtolower($concern->lookup_code); ?>">
                        <?php $img_url = get_lookup_image_url($concern->lookup_code); ?>
                        <img class="shop_by_seller_imgs" src="<?php echo base_url() . $img_url; ?>">
                        <strong id="shop_category_style">
                            <p id="shop_category_p_style"><?php echo $concern->meaning ?></p>
                        </strong>
                </div>
            <?php endforeach; ?>
        </div>


        <div class="row shop-by-seller-heading">
            <h3 class="style-for-seller">All in Shop by concern</h3>
        </div>
        <div class="row categories-for-mobile" style="padding-bottom: 12px;">
            <?php foreach ($shop_concern as $concern) : ?>
                <a href="<?= generate_url("shop_by_concern") . '/' . strtolower($concern->lookup_code); ?>">
                    <p class="all-in-categoty"><?php echo $concern->meaning ?></p>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="row categories-for-mobile" id="top-picks-container" style="margin-top: 10px;">
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
            <div class="btn btn-md btn-view-more-new m-t-15 m-b-15 more" style="box-shadow: 2px 2px 5px #808080de !important;">
                <a id="show_more_products" class="view-new-text" href="<?= generate_url("products") ?>">View All Products</a><i class="fa fa-caret-down" style="color:black; margin-left:6px;"></i>
            </div>
        </div>



    </div>
</div>