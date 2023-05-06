<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
    .site-map-heading {
        padding-top: 20px;
        padding-bottom: 20px;
        place-content: center;
    }

    .home-page {
        background: #0080009e;
        border-radius: 20px;
        margin-top: 20px;
        padding: 12px;
    }

    .heading-site-map {
        font-size: 18px;
        padding-left: 20px;
    }

    .links-site-map {
        font-size: 18px;
        padding-left: 20px;
        text-decoration: underline;
    }

    .sub-links-site-map {
        font-size: 18px;
        padding-left: 20px;
        text-decoration: underline;
        margin-top: 10px;
    }

    .content-block {
        margin: 0px 14%;
    }

    @media(max-width:768px) {
        .home-page {
            background: #0080009e;
            border-radius: 20px;
            width: 100%;
            margin-top: 20px;
            padding: 12px;
        }

        .links-center {
            padding: 0;
        }

        .content-block {
            margin: 0px;
        }
    }
</style>

<div class="container">
    <div class="wrapper">
        <div class="row site-map-heading">
            <h2>Sitemap</h2>
        </div>
        <div class="content-block">
            <ul class="links-center">
                <li>
                    <div class="home-page">
                        <a class="links-site-map" href="<?php echo base_url(); ?>">Home</a>
                    </div>
                </li>
                <li>
                    <div class="home-page">
                        <a class="links-site-map" href="<?php echo generate_url("why_sell_with_us"); ?>">Sell With Us</a>
                    </div>
                </li>
                <li>
                    <div class="home-page">
                        <span class="heading-site-map">Categories</a>
                    </div>
                    <ul class="links-sub-heading">
                        <li class="sub-links-site-map">
                            <a href="<?php echo base_url() . 'top-categories/fashion'; ?>">Fashion</a>
                        </li>
                        <li class="sub-links-site-map">
                            <a href="<?php echo base_url() . 'top-categories/home-cooks'; ?>">Home Cooks</a>
                        </li>
                        <li class="sub-links-site-map">
                            <a href="<?php echo base_url() . 'top-categories/grocery'; ?>">Grocery</a>
                        </li>
                        <li class="sub-links-site-map">
                            <a href="<?php echo base_url() . 'top-categories/home'; ?>">Home</a>
                        </li>
                        <li class="sub-links-site-map">
                            <a href="<?php echo base_url() . 'top-categories/personal-care-lifestyle'; ?>">Personal Care & Lifestyle</a>
                        </li>
                        <li class="sub-links-site-map">
                            <a href="<?php echo base_url() . 'top-categories/kids-corner'; ?>">Kids Corner</a>
                        </li>
                        <li class="sub-links-site-map">
                            <a href="<?php echo base_url() . 'top-categories/art-stationery'; ?>">Art & Stationery</a>
                        </li>
                        <li class="sub-links-site-map">
                            <a href="<?php echo base_url() . 'top-categories/gifts-festivities'; ?>">Gifts & Festivities</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <div class="home-page">
                        <span class="heading-site-map">Shop by:</a>
                    </div>
                    <ul class="links-sub-heading">
                        <li class="sub-links-site-map">
                            <a href="<?php echo base_url() . 'shop-by-concern'; ?>">Shop by Concern</a>
                        </li>
                        <li class="sub-links-site-map">
                            <a href="<?php echo base_url() . 'shop-by-occasion'; ?>">Shop by Occasion</a>
                        </li>
                        <li class="sub-links-site-map">
                            <a href="<?php echo base_url() . 'shop-by-seller'; ?>">Shop by Seller</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <div class="home-page">
                        <a class="links-site-map" href="<?php echo base_url() . 'career'; ?>">Careers</a>
                    </div>
                </li>
                <li>
                    <div class="home-page">
                        <a class="links-site-map" href="<?php echo base_url() . 'blog'; ?>">Blogs</a>
                    </div>
                </li>
                <li>
                    <div class="home-page">
                        <span class="heading-site-map">Support</a>
                    </div>
                    <ul class="links-sub-heading">
                        <li class="sub-links-site-map">
                            <a href="<?php echo base_url() . 'privacy'; ?>">Privacy Policy</a>
                        </li>
                        <li class="sub-links-site-map">
                            <a href="<?php echo base_url() . 'terms-conditions'; ?>">Terms & Conditions</a>
                        </li>
                        <li class="sub-links-site-map">
                            <a href="<?php echo base_url() . 'shipping_policy'; ?>">Shipping Policy</a>
                        </li>
                        <li class="sub-links-site-map">
                            <a href="<?php echo base_url() . 'return_and_exchange'; ?>">Returns & Exchange</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <div class="home-page">
                        <span class="heading-site-map">About</a>
                    </div>
                    <ul class="links-sub-heading">
                        <li class="sub-links-site-map">
                            <a href="<?php echo base_url() . 'aboutus'; ?>">Who Are We</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <div class="home-page">
                        <span class="heading-site-map">Contact</a>
                    </div>
                    <ul class="links-sub-heading">
                        <li class="sub-links-site-map">
                            <a href="<?php echo base_url() . 'contact'; ?>">Contact Us</a>
                        </li>
                        <li class="sub-links-site-map">
                            <a href="<?php echo base_url() . 'sitemap'; ?>">Site Map</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>