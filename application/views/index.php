<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .shop-by {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
        /* padding: 0px; */
    }

    .shop-by-occasion {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        padding: 0px;
    }

    /* .shop-by:hover .top-picks-new-ui {
        transform: scale(1.1);
    }

    .shop-by  img {
        transform: scale(1);
        transition: all 0.3s;
    } */


    @media(max-width:786px) {
        .shop-by {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-between;
            padding: 0px;
            overflow-x: scroll;
        }

        .shop-by-occasion {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-between;
            padding: 0px 10px;
            overflow-x: scroll;
        }

        .top-picks-new-ui {
            border-radius: 20px;
            box-shadow: 2px 2px 5px #808080de;
            height: 200px;
            width: 114px;
        }

        .top-centered {
            position: absolute;
            top: 18px !important;
            right: 14% !important;
            color: white;
            font-size: 16px !important;
            text-align: center;
        }

        .bottom-centered {
            position: absolute;
            top: 141px !important;
            right: 24% !important;
            color: white;
            font-size: 16px !important;
            text-align: center;
        }

        .top-centered-2 {
            position: absolute;
            top: 18px !important;
            right: 16% !important;
            color: white;
            font-size: 16px !important;
            text-align: center;
        }

        .bottom-centered-2 {
            position: absolute;
            top: 159px !important;
            right: 25% !important;
            color: white;
            font-size: 16px !important;
            text-align: center;
        }

        .top-centered-3 {
            position: absolute;
            top: 0% !important;
            right: 24% !important;
            color: white;
            text-align: center;
            font-size: 16px !important;
        }
    }

    .sides-gap-equal {
        padding: 0px;
    }

    .seller-category-name {
        font-size: .875rem;
    }

    .top-centered {
        position: absolute;
        top: 4%;
        left: 13%;
        color: white;
        font-size: 18px;
    }

    .top-centered-2 {
        position: absolute;
        top: 3%;
        left: 11%;
        color: white;
        font-size: 18px;
    }


    .top-centered-3 {
        position: absolute;
        top: 3%;
        left: 18%;
        color: white;
        font-size: 18px;
    }

    .bottom-centered {
        position: absolute;
        bottom: 6%;
        left: 18%;
        color: white;
        font-size: 18px;
    }

    .bottom-centered-2 {
        position: absolute;
        bottom: 6%;
        right: 29%;
        color: white;
        font-size: 18px;
    }

    .top-picks-new-ui {
        box-shadow: 2px 2px 5px #808080de;
        border-radius: 20px;

    }

    .top-sellers-new-ui {
        width: 100%;
        box-shadow: 2px 2px 5px #808080de;
        border-radius: 10px;
    }

    @media(max-width:768px) {
        .top-sellers-new-ui {
            width: 120px;
            height: 140px;
            border-radius: 10px;
            box-shadow: 2px 2px 5px #808080de;
        }

        .bottom-centered-seller {
            position: absolute;
            top: 107px !important;
            left: 5% !important;
            color: white;
        }

        .bottom-centered-seller-1 {
            position: absolute;
            top: 93px !important;
            right: 33px !important;
            color: white;
            text-align: center;
        }

        .bottom-centered-seller-2 {
            position: absolute;
            top: 110px !important;
            left: 7% !important;
            color: white;
        }

        .bottom-centered-seller-jobs {
            position: absolute;
            top: 77px !important;
            right: 33px !important;
            color: white;
            text-align: center;
        }

        /* width */
        .col-12 sides-gap-equal .shop-by-occasion::-webkit-scrollbar {
            width: 4px;
        }

        .col-12 sides-gap-equal .shop-by-occasion {
            scrollbar-color: #fff0 #fff0;
        }

        /* 
        .new-by-occasion {
            border: 1px solid;
            border-radius: 20px;
            padding: 5px;
            font-size: 12px;
            margin-left: 0px !important;
            margin-right: -46%;
        } */

        .chicken-mobile {
            width: 324px;
            border-radius: 30px;
        }

        .chocolate-mobile {
            width: 324px;
            border-radius: 30px;
        }

        #for-chicken-chocolate {
            display: grid !important;
        }

        .find-your-seller {
            font-size: 21px !important;
            font-weight: bolder;
            color: #454545;
        }

        .bottom-centered-seller-3 {
            position: absolute;
            bottom: 28px !important;
            left: 10% !important;
            color: white;
        }

        .seller-category-name {
            font-size: 11px !important;
        }
    }

    .bottom-centered-seller {
        position: absolute;
        top: 193px;
        left: 21%;
        color: white;
    }


    .bottom-centered-seller-1 {
        position: absolute;
        top: 195px;
        left: 14%;
        color: white;
    }

    .new-by-occasion {
        border: 1px solid gray;
        border-radius: 20px;
        padding: 5px 43px;
        margin: 0px 6px;
        color: #454545;
        background-color: #e2e2e2;
        font-weight: 600;
        flex-wrap: nowrap;
        /* word-break: break-all; */
        white-space: nowrap;
    }

    .find-your-seller {
        font-size: 28px;
        font-weight: bolder;
        color: #454545;
    }

    .bottom-centered-seller-2 {
        position: absolute;
        top: 191px;
        left: 20%;
        color: white;
    }

    .bottom-centered-seller-3 {
        position: absolute;
        bottom: 28px;
        left: 21%;
        color: white;
    }

    .bottom-centered-seller-jobs {
        position: absolute;
        top: 195px;
        left: 14%;
        color: white;
    }

    .chicken-mobile {
        border-radius: 30px;
    }

    .chocolate-mobile {
        border-radius: 30px;
    }

    #for-chicken-chocolate {
        display: flex;
    }

    .for-space-between-imgs {
        padding-left: 0px;
    }

    .row-collage {
        display: -ms-flexbox;
        /* IE10 */
        display: flex;
        -ms-flex-wrap: wrap;
        /* IE10 */
        flex-wrap: wrap;
    }

    .row-collage-2 {
        display: -ms-flexbox;
        /* IE10 */
        display: flex;
        -ms-flex-wrap: wrap;
        /* IE10 */
        flex-wrap: wrap;
    }

    /* Create four equal columns that sits next to each other */
    .column-collage {
        -ms-flex: 33.3%;
        /* IE10 */
        flex: 33.3%;
        max-width: 33.3%;
        padding: 0 4px;
    }

    .column-collage-2 {
        -ms-flex: 50%;
        /* IE10 */
        flex: 50%;
        max-width: 50%;
        padding: 0 4px;
    }

    .column-collage img {
        margin-top: 8px;
        vertical-align: middle;
        width: 100%;
    }

    .column-collage-2 img {
        margin-top: 8px;
        vertical-align: middle;
        width: 100%;
    }

    /* collage-for-mobile */
    .column-mobile-collage {
        -ms-flex: 50%;
        /* IE10 */
        flex: 50%;
        max-width: 50%;
        padding: 0 4px;
    }

    .column-mobile-collage-2 {
        -ms-flex: 50%;
        /* IE10 */
        flex: 50%;
        max-width: 50%;
        padding: 0 4px;
    }

    .column-mobile-collage img {
        margin-top: 8px;
        vertical-align: middle;
        width: 100%;
    }

    .column-mobile-collage-2 img {
        margin-top: 8px;
        vertical-align: middle;
        width: 100%;
    }

    /* css-end-for-mobile-collage */

    .hidden-for-web {
        display: none;
    }

    /* Responsive layout - makes a two column-layout instead of four columns */
    @media screen and (max-width: 800px) {
        .column-collage {
            -ms-flex: 33.3%;
            flex: 33.3%;
            max-width: 33.3%;
            padding: 0px 2px;
        }

        .column-collage-2 {
            -ms-flex: 50%;
            flex: 50%;
            max-width: 50%;
            padding: 0px 2px;
        }

        .column-collage img {
            margin-top: 4px !important;
            vertical-align: middle;
            width: 100%;
        }

        .column-collage-2 img {
            margin-top: 4px !important;
            vertical-align: middle;
            width: 100%;
        }


        .column-mobile-collage {
            -ms-flex: 50%;
            /* IE10 */
            flex: 50%;
            max-width: 50%;
            padding: 0 1px;
        }

        .column-mobile-collage img {
            margin-top: 2spx !important;
            vertical-align: middle;
            width: 100%;
        }

        .hidden-for-mobile {
            display: none;
        }

        .hidden-for-web {
            display: flex;
        }

    }

    /* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
    @media screen and (max-width: 600px) {
        .column-collage {
            -ms-flex: 33.3%;
            flex: 33.3%;
            max-width: 33.3%;
            padding: 0px 2px;
        }

        .column-collage-2 {
            -ms-flex: 50%;
            flex: 50%;
            max-width: 50%;
            padding: 0px 2px;
        }

        .column-collage img {
            margin-top: 4px !important;
            vertical-align: middle;
            width: 100%;
        }

        .column-collage-2 img {
            margin-top: 4px !important;
            vertical-align: middle;
            width: 100%;
        }


        .column-mobile-collage {
            -ms-flex: 50%;
            /* IE10 */
            flex: 50%;
            max-width: 50%;
            padding: 0 1px;
        }

        .column-mobile-collage img {
            margin-top: 2px !important;
            vertical-align: middle;
            width: 100%;
        }

        .hidden-for-mobile {
            display: none;
        }

        .hidden-for-web {
            display: flex;
        }

        .justified-collage {
            justify-content: center;
        }

    }

    .pickgradient {
        display: inline-block;
        border-radius: 10px;
        background: -moz-linear-gradient(top, #00000096, #ffffff52 100%);
        /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #ffffff52), color-stop(100%, #00000096));
        /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top, #00000096, #ffffff52 100%);
        /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top, #00000096, #ffffff52 100%);
        /* Opera 11.10+ */
        background: -ms-linear-gradient(top, #00000096, #ffffff52 100%);
        /* IE10+ */
        background: linear-gradient(to top, #00000096, #ffffff00 100%);
        /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=' #00000096', endColorstr='#ffffff52', GradientType=0);
        /* IE6-9 */
    }

    .pickgradient>img {
        position: relative;
        z-index: -1;
    }

    #wrapper {
        padding-bottom: 5px;
    }
</style>

<div class="section-slider">
    <?php if (!empty($slider_items) && $this->general_settings->slider_status == 1) :
        $this->load->view("partials/_main_slider");
    endif; ?>
</div>
<!-- Wrapper -->
<div class="index-wrapper" id="wrapper">
    <div class="container">
        <div class="row shop-by">
            <div class="col-sm-2">
                <a href="<?php echo lang_base_url() . 'shop-by-concern'; ?>">
                    <img class="top-picks-new-ui" src="https://live-gharobaar.s3.ap-south-1.amazonaws.com/assets/img/landing-page-img/new-ui-img-1.png">
                    <p>
                        <strong class="top-centered">Shop By Concern</strong>
                    </p>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo lang_base_url() . 'shop-by-seller'; ?>">
                    <img class="top-picks-new-ui" src="https://live-gharobaar.s3.ap-south-1.amazonaws.com/assets/img/landing-page-img/new-ui-img-2.png">
                    <p>
                        <strong class="bottom-centered">Shop By Seller</strong>
                    </p>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo lang_base_url() . 'shop-by-occasion'; ?>">
                    <img class="top-picks-new-ui" src="https://live-gharobaar.s3.ap-south-1.amazonaws.com/assets/img/landing-page-img/new-ui-img-3.png">
                    <p>
                        <strong class="top-centered-2">Shop By Occasion</strong>
                    </p>
                </a>
            </div>
            <div class="col-sm-2 scroller">
                <a href="#top_picks">
                    <img class="top-picks-new-ui" src="https://live-gharobaar.s3.ap-south-1.amazonaws.com/assets/img/landing-page-img/new-ui-img-4.png">
                    <p>
                        <strong class="bottom-centered-2">Top Picks</strong>
                    </p>
                </a>
            </div>
            <div class="col-sm-2 scroller">
                <a href="#top_discounts">
                    <img class="top-picks-new-ui" src="https://live-gharobaar.s3.ap-south-1.amazonaws.com/assets/img/landing-page-img/new-ui-img-5.png">
                    <p>
                        <strong class="top-centered-3">Top Discounts</strong>
                    </p>
                </a>
            </div>
        </div> <?php if (!empty($promoted_products)) : ?>
            <?php if ($this->general_settings->index_promoted_products == 1 && $this->general_settings->promoted_products == 1 && !empty($promoted_products)) : ?>
                <div class="col-12 sides-gap-equal section section-promoted">
                    <!-- promoted products -->
                    <?php $this->load->view("product/_featured_products"); ?>
                </div>
            <?php endif; ?>
        <?php else : ?>
            <?php if ($this->general_settings->index_promoted_products == 1 && $this->general_settings->promoted_products == 1 && !empty($promoted_products)) : ?>
                <!-- <div class="col-12 sides-gap-equal section section-promoted"> -->
                <!-- promoted products -->
                <? //php $this->load->view("product/_featured_products"); 
                ?>
                <!-- </div> -->
            <?php endif; ?>
        <?php endif; ?>
        <?php $this->load->view("product/_index_banners", ['banner_location' => 'special_offers']); ?>


        <div class="row">
            <h3 style=" padding-left: 16px;" class="find-your-seller">Find Your Seller</h3>
        </div>
        <div class="row shop-by" style="padding-left: 15px;">

            <?php $shop_by_seller = get_lookup_values_by_type("SHOP_BY_SELLER"); ?>
            <?php foreach ($shop_by_seller as $shop_seller) : ?>
                <div class="col-sm-2 for-space-between-imgs">
                    <a href="<?= generate_url("members_speciality") . '?type=' . $shop_seller->meaning; ?>">

                        <?php $img_url = get_lookup_image_url($shop_seller->lookup_code); ?>
                        <div class="pickgradient">
                            <img class="top-sellers-new-ui" src="<?php echo other_base_url() . $img_url; ?>" alt="Avatar">
                        </div>
                    </a>
                    <p style=" text-align: center;position: relative;bottom: 25px;color: white;">
                        <strong class="seller-category-name"><?php
                                                                if ($shop_seller->meaning == "Phoenix (Rising from the ashes)") :
                                                                    echo "Phoenix Sellers";
                                                                else :
                                                                    echo $shop_seller->meaning;
                                                                endif; ?></strong>
                    </p>
                </div>
            <?php endforeach; ?>
            <!-- <div class="col-sm-2 for-space-between-imgs">
                <img class="top-sellers-new-ui" src="assets/img/landing-page-img/your-seller-1.png">
                <p>
                    <strong class="bottom-centered-seller">Phoenix Seller</strong>
                </p>
            </div> -->
            <!-- <div class="col-sm-2 for-space-between-imgs">
                <img class="top-sellers-new-ui" src="assets/img/landing-page-img/your-seller-2.png">
                <p>
                    <strong class="bottom-centered-seller-2 ">Gritty Over 60</strong>
                </p>
            </div>
            <div class="col-sm-2 for-space-between-imgs">
                <img class="top-sellers-new-ui" src="assets/img/landing-page-img/your-seller-3.png">
                <p>
                    <strong class="bottom-centered-seller-jobs">Out Of Regular Job</strong>
                </p>
            </div>
            <div class="col-sm-2 for-space-between-imgs">
                <img class="top-sellers-new-ui" src="assets/img/landing-page-img/your-seller-4.png">
                <p>
                    <strong class="bottom-centered-seller-3">First Venture</strong>
                </p>
            </div>
            <div class="col-sm-2 for-space-between-imgs">
                <img class="top-sellers-new-ui" src="assets/img/landing-page-img/your-seller-5.png">
                <p>
                    <strong class="bottom-centered-seller-1">Cooperative Group</strong>
                </p>
            </div>
            <div class="col-sm-2 for-space-between-imgs">
                <img class="top-sellers-new-ui" src="assets/img/landing-page-img/your-seller-6.png">
                <p>
                    <strong class="bottom-centered-seller-1">Pursuing Passion</strong>
                </p>
            </div> -->
        </div>
    </div>
</div>



<!-- <div class="row" id="second-slider" style="margin-bottom:5%;">
            <div class="section-slider">
                <img style="width:100%;" src="assets/img/landing-page-img/banner-2-img.png">
            </div>
        </div>
    </div>
</div> -->


<div class="section-slider">
    <?php if (!empty($slider_items) && $this->general_settings->slider_status == 1) :
        $this->load->view("partials/_main_slider_2", ["second_slider_items" => $second_slider_items]);
    endif; ?>
</div>






<div class="index-wrapper" id="wrapper">
    <div class="container">
        <h1 class="index-title"><?php echo html_escape($this->settings->site_title); ?></h1>

        <!-- collage-for-web -->
        <div class="col-12 sides-gap-equal" style="margin-top:20px;">
            <h3 class="find-your-seller">Shop By Category</h3>
        </div>
        <div class="row-collage hidden-for-mobile" style="justify-content:center;">
            <div class="column-collage">
                <a href="<?php echo base_url() . "top-categories/fashion"; ?>"><img src="<?php echo other_base_url() . "assets/img/landing-page-img/collage-1.png"; ?>" style="width:100%"></a>
                <a href="<?php echo base_url() . "top-categories/grocery"; ?>"><img src="<?php echo other_base_url() . "assets/img/landing-page-img/collage-4.png"; ?>" style="width:100%"></a>
            </div>
            <div class="column-collage">
                <a href="<?php echo base_url() . "top-categories/kids-corner"; ?>"><img src="<?php echo other_base_url() . "assets/img/landing-page-img/collage-2.png"; ?>" style="width:100%"></a>
                <a href="<?php echo base_url() . "top-categories/home"; ?>"><img src="<?php echo other_base_url() . "assets/img/landing-page-img/collage-5.png"; ?>" style="width:100%"></a>
            </div>
            <div class="column-collage">
                <a href="<?php echo base_url() . "top-categories/gifts-festivities"; ?>"> <img src="<?php echo other_base_url() . "assets/img/landing-page-img/collage-3.png"; ?>" style="width:100%"></a>
                <a href="<?php echo base_url() . "top-categories/home-cooks"; ?>"><img src="<?php echo other_base_url() . "assets/img/landing-page-img/collage-6.png"; ?>" style="width:100%"></a>
            </div>

        </div>

        <div class="row-collage-2 hidden-for-mobile" style="justify-content:center;">
            <div class="column-collage-2">
                <a href="<?php echo base_url() . "top-categories/personal-care-lifestyle"; ?>"><img src="<?php echo other_base_url() . "assets/img/landing-page-img/collage-7.png"; ?>" style="width:100%"></a>
            </div>
            <div class="column-collage-2">
                <a href="<?php echo base_url() . "top-categories/art-stationery"; ?>"><img src="<?php echo other_base_url() . "assets/img/landing-page-img/collage-8.png"; ?>" style="width:100%"></a>
            </div>
        </div>

        <!-- end of web collage -->

        <!-- collage-for-mobile -->
        <div class="row-collage hidden-for-web justified-collage" id="category-app-bar">
            <div class="column-mobile-collage">
                <a href="<?php echo base_url() . "top-categories/fashion"; ?>"><img src="<?php echo other_base_url() . "assets/img/landing-page-img/collage-mobile-1.png"; ?>" style="width:100%"></a>
                <a href="<?php echo base_url() . "top-categories/grocery"; ?>"><img src="<?php echo other_base_url() . "assets/img/landing-page-img/collage-mobile-3.png"; ?>" style="width:100%"></a>
            </div>
            <div class="column-mobile-collage">
                <a href="<?php echo base_url() . "top-categories/kids-corner"; ?>"><img src="<?php echo other_base_url() . "assets/img/landing-page-img/collage-mobile-2.png"; ?>" style="width:100%"></a>
                <a href="<?php echo base_url() . "top-categories/home"; ?>"><img src="<?php echo other_base_url() . "assets/img/landing-page-img/collage-mobile-4.png"; ?>" style="width:100%"></a>
            </div>
        </div>

        <div class="row-collage hidden-for-web justified-collage">
            <div class="column-mobile-collage">
                <a href="<?php echo base_url() . "top-categories/home-cooks"; ?>"><img src="<?php echo other_base_url() . "assets/img/landing-page-img/collage-mobile-5.png"; ?>" style="width:100%"></a>
                <a href="<?php echo base_url() . "top-categories/personal-care-lifestyle"; ?>"> <img src="<?php echo other_base_url() . "assets/img/landing-page-img/collage-mobile-7.png"; ?>" style="width:100%"></a>
            </div>
            <div class="column-mobile-collage">
                <a href="<?php echo base_url() . "top-categories/art-stationery"; ?>"><img src="<?php echo other_base_url() . "assets/img/landing-page-img/collage-mobile-6.png"; ?>" style="width:100%"></a>
                <a href="<?php echo base_url() . "top-categories/gifts-festivities"; ?>"><img src="<?php echo other_base_url() . "assets/img/landing-page-img/collage-mobile-8.png"; ?>" style="width:100%"></a>
            </div>
        </div>
        <!-- end of mobile-collage -->


        <div class="col-12 sides-gap-equal">
            <div class="row-custom row-bn">
                <!--Include banner-->
                <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "index_1", "class" => ""]); ?>
            </div>
        </div>

        <div class="col-12 sides-gap-equal section section-latest-products">
            <h3 class="find-your-seller" id="top_picks">Top Picks</h3>
            <div class="row row-product shop-by" id="top-picks-container">
                <!--print products-->
                <?php foreach ($latest_products as $product) : ?>
                    <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                        <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => false, 'is_slider' => 0, 'discount_label' => 0]); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div id="top-picks-container_nav" class="index-products-slider-nav">
                <button class="prev"><i class="icon-arrow-left"></i></button>
                <button class="next"><i class="icon-arrow-right"></i></button>
            </div>
        </div>



        <div class="col-12 sides-gap-equal">
            <h3 class="find-your-seller">Shop By Occasion</h3>
        </div>
        <div class="col-12 sides-gap-equal shop-by-occasion" style="padding-bottom: 12px;">
            <?php $shop_occasion = get_list_lookup_value_predefined("SHOP_BY_OCCASSION"); ?>
            <?php foreach ($shop_occasion as $occasion) : ?>
                <a href="<?= generate_url("shop_by_occasion") . '/' . strtolower($occasion->lookup_code); ?>">
                    <p class="new-by-occasion"><?php echo $occasion->meaning ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="section-slider">
    <?php if (!empty($slider_items) && $this->general_settings->slider_status == 1) :
        $this->load->view("partials/_main_slider_occasion_new", ["second_slider_items" => $occassion_slider_items]);
    endif; ?>
</div>


<div class="col-12 sides-gap-equal">
    <h3 class="find-your-seller" style="margin-top: 20px;padding: 0px 15px;">Shop By Concern</h3>
</div>
<div class="section-slider">
    <?php if (!empty($slider_items) && $this->general_settings->slider_status == 1) :
        $this->load->view("partials/_main_slider_concern_new", ["second_slider_items" => $concern_slider_items]);
    endif; ?>
</div>



<div class="index-wrapper" id="wrapper">
    <div class="container">
        <?php $this->load->view("product/_index_banners", ['banner_location' => 'featured_products']); ?>
        <?php $product_clothing = get_products_by_discount_order(); ?>
        <?php if (!empty($product_clothing)) : ?>
            <div id="top_discounts" class="col-12 sides-gap-equal section category-style" style="margin-top: 30px;">
                <h3 class="find-your-seller">Top Discounts</h3>
                <div class="row row-product shop-by" id="top-discounts-container">
                    <!--print products-->
                    <?php foreach ($product_clothing as $product) : ?>
                        <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                            <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => false, 'is_slider' => 0, 'discount_label' => 0]); ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="text-center" style="margin-bottom:8%;">
                    <div class="index_btn_text index_btn btn btn-md btn-custom m-t-15">
                        <a href="<?= generate_url("products") . '?sort=' . 'top_discount'; ?>">
                            View More Products</a>
                    </div>
                </div>
                <div id="top-discounts-container_nav" class="index-products-slider-nav">
                    <button class="prev"><i class="icon-arrow-left"></i></button>
                    <button class="next"><i class="icon-arrow-right"></i></button>
                </div>
            </div>
        <?php endif; ?>


        <?php $this->load->view('product/_index_category_products', ['index_categories' => $index_categories]); ?>

        <div class="col-12 sides-gap-equal">
            <div class="row-custom row-bn">
                <!--Include banner-->
                <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "index_2", "class" => ""]); ?>
            </div>
        </div>
        <?php if ($this->general_settings->index_blog_slider == 1 && !empty($blog_slider_posts)) : ?>
            <div class="col-12 sides-gap-equal section section-blog m-0">
                <h3 class="title">
                    <a href="<?= generate_url('blog'); ?>"><?= trans("latest_blog_posts"); ?></a>
                </h3>
                <p class="title-exp"><?php echo trans("latest_blog_posts_exp"); ?></p>
                <div class="row-custom">
                    <!-- main slider -->
                    <?php $this->load->view("blog/_blog_slider", ['blog_slider_posts' => $blog_slider_posts]); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<script>
    var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ? true : false;

    $('.scroller > a').click(function() {
        if (!isMobile) {
            $('html, body').animate({
                scrollTop: $($(this).attr('href')).offset().top - 2 * $("#myHeader").height()
            }, 1000);
            return false;
        } else {
            $('html, body').animate({
                scrollTop: $($(this).attr('href')).offset().top - 2 * $("#myMobileHeader").height()
            }, 1000);
            return false;
        }
    });
</script>
<!-- Wrapper End-->