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

        .style-for-seller {
            font-size: 20px !important;
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
        cursor: pointer;
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
            <h3 class="style-for-seller">Shop By Seller</h3>
        </div>
        <div class="row shop-by-center">
            <?php $shop_by_seller = get_lookup_values_by_type("SHOP_BY_SELLER"); ?>
            <?php foreach ($shop_by_seller as $shop_seller) : ?>
                <div class="col-2 two-for-mobile">
                    <a href="<?= generate_url("members_speciality") . '?type=' . $shop_seller->meaning; ?>">

                        <?php $img_url = get_lookup_image_url($shop_seller->lookup_code); ?>
                        <img class="shop_by_seller_imgs" src="<?php echo base_url() . $img_url; ?>" alt="Avatar"></a>
                    <strong id="shop_category_style">
                        <p id="shop_category_p_style"><?php
                                                        if ($shop_seller->meaning == "Phoenix (Rising from the ashes)") :
                                                            echo "Phoenix Sellers";
                                                        else :
                                                            echo $shop_seller->meaning;
                                                        endif; ?></p>
                    </strong>
                </div>
            <?php endforeach; ?>
            <!-- <div class="col-2 two-for-mobile">
                <img class="shop_by_seller_imgs" src="assets/img/shop_by_seller_imgs/shop_by_seller_2.png">
                <p>Gritty Over 60</p>
            </div>
            <div class="col-2 two-for-mobile">
                <img class="shop_by_seller_imgs" src="assets/img/shop_by_seller_imgs/shop_by_seller_3.png">
                <p>Out of Regular Job</p>
            </div>
            <div class="col-2 two-for-mobile">
                <img class="shop_by_seller_imgs" src="assets/img/shop_by_seller_imgs/shop_by_seller_4.png">
                <p>First Venture</p>
            </div>
            <div class="col-2 two-for-mobile">
                <img class="shop_by_seller_imgs" src="assets/img/shop_by_seller_imgs/shop_by_seller_5.png">
                <p>Cooperative Group</p>
            </div>
            <div class="col-2 two-for-mobile">
                <img class="shop_by_seller_imgs" src="assets/img/shop_by_seller_imgs/shop_by_seller_6.png">
                <p>Pursuing Passion</p>
            </div> -->
        </div>

        <div class="row shop-by-seller-heading">
            <h3 class="style-for-seller">All in Shop by Seller</h3>
        </div>
        <div class="row categories-for-mobile" style="padding-bottom: 12px;">
            <?php foreach ($shop_by_seller as $shop_seller) : ?>
                <a href="<?= generate_url("members_speciality") . '?type=' . $shop_seller->meaning; ?>">
                    <p class="all-in-categoty"><?php
                                                if ($shop_seller->meaning == "Phoenix (Rising from the ashes)") :
                                                    echo "Phoenix Sellers";
                                                else :
                                                    echo $shop_seller->meaning;
                                                endif; ?></p>
                </a>
            <?php endforeach; ?>
        </div>


        <div class="row categories-for-mobile" id="top-picks-container" style="margin-top: 10px;">
            <!--print products-->
            <?php foreach ($latest_products as $product) : ?>
                <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                    <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => false, 'is_slider' => 0, 'discount_label' => 0]); ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="col-12 text-center">
            <div class="btn btn-md btn-view-more-new m-t-15 m-b-15 more" style="box-shadow: 2px 2px 5px #808080de !important;">
                <a id="show_more_products" class="view-new-text" href="<?= generate_url("products") ?>">View All Products</a><i class="fa fa-caret-down" style="color:black; margin-left:6px;"></i>
            </div>
        </div>

    </div>
</div>