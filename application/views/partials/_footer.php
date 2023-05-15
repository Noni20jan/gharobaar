<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<link rel="preload" href="<?php echo base_url(); ?>assets/vendor/bootstrap/js/popper.min.js" as="script">
<link rel="preload" href="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js" as="script">
<link rel="preload" href="<?php echo base_url(); ?>assets/js/plugins-1.7.js" as="script">
<link rel="preload" href="<?php echo base_url(); ?>assets/js/speech-input.js" as="script">
<link rel="preload" href="<?php echo base_url(); ?>assets/js/script-1.7.min.js?v=1234qwer" as="script">
<link rel="preload" href="<?php echo base_url(); ?>assets/admin/js/dashboard-1.7.js" as="script">

<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins-1.7.js"></script>
<script src="<?php echo base_url(); ?>assets/js/speech-input.js"></script>
<script src="<?php echo base_url(); ?>assets/js/script-1.7.min.js?v=1234qwer"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/dashboard-1.7.js"></script>

<style>
/* #footer-follow-us {
        margin-bottom: 20%;
    } */
#footer .footer-top {
    padding: 30px 0;
}

#subscribe {
    visibility: hidden;
}


#textEmail1 {
    background-color: #d1d1d1 !important;

}

#footer .footer-social-links {
    width: 100%;
    display: block;
    position: relative;
    float: left;
    right: 42px;
    bottom: 0px;

}

@media only screen and (max-width: 1024px) {
    #footer .newsletter .footer-title {
        color: #222;
        font-size: 18px;
        font-weight: 400;
        line-height: 30px;
        /* max-width: 200px; */
        margin-bottom: 10px;
        text-indent: 3px;
        position: relative;
        left: 10px;
        display: none;
    }

    .newsletter-inner {
        width: 89%;
        margin: 0px auto;
    }
}

#textEmail {
    border-radius: 20px;
    background-color: transparent;
    width: 96%;
    border: 0;
    background-color: #d1d1d1;
    margin-left: -21px;
    width: 200px;

}

#footer .footer-social-links {
    width: 100%;
    display: block;
    position: relative;
    float: left;
    right: 42px;
    bottom: 0px;

}

@media only screen and (max-width: 700px) {
    #textEmail {
        border-radius: 20px;
        background-color: transparent;
        border: 0;

        background-color: #d1d1d1;
    }
}

    {
    /* border-radius: 10px 10px 0px 0; */
    /* border-radius: 10px 10px 0px 0; */
    border-radius: 20px;
    min-height: 40px;
    min-width: 40px;
    background-color: #111;
    /* background-color: #c582b5; */
    color: #fff;
    white-space: nowrap;
    position: absolute;
    left: 34px;
    top: 83px;
}

#footer .newsletter .newsletter-inner input {
    border-radius: 20px;
    border-bottom: 1px solid #e0e0e2;
    border-top: 0;
    border-left: 0;
    border-right: 0;
    background: transparent;
    min-height: 40px;
    font-size: 0.8125rem;
}

#subscribe {
    border-radius: 20px;
    min-height: 40px;
    width: 100%;
    min-width: 40px;
    background-color: #007C05;
    /* background-color: #c582b5; */
    color: #fff;
    white-space: nowrap;
    position: absolute;
    /* left: 0px; */
    /* top: 0px; */
    float: right;
    visibility: visible;
    right: 9px;
}

@media(max-width:700px) {
    #subscribe {
        border-radius: 20px;
        min-height: 40px;

        min-width: 40px;
        background-color: #007C05;
        /* background-color: #c582b5; */
        color: #fff;
        white-space: nowrap;
        position: relative;
        top: 13px;
        /* left: 227px; */
        /* top: 0px; */
        float: right;
        left: 10px;
        visibility: visible;
    }
}

@media only screen and (max-width: 700px) {
    #footer .newsletter .newsletter-inner button {
        border-radius: 20px;
        min-height: 40px;
        min-width: 40px;
        /* background-color: #222; */
        background-color: #111;
        color: #e8e8e8;
        white-space: nowrap;

        position: absolute;
        right: 0px;

    }

    .onlyweb {
        display: none;
    }
}

#footer .footer-social-links ul {
    padding: 0;
    margin: 0;
    float: right;
    margin-top: 1%;
    display: inline-flex;
}

@media only screen and (max-width: 800px) {
    #footer .footer-social-links ul {

        float: left;

        margin-top: 0%;
        margin-bottom: 0rem;



    }
}

@media only screen and (max-width: 1024px) {
    #response {
        word-break: break-all;
    }
}

@media only screen and (max-width: 700px) {
    #respond {
        word-break: break-all;
    }
}


#footer .footer-social-links ul li a {
    font-size: 18px;
    padding: 5px;
    background-color: transparent;
    border-radius: 20px !important;
    border: 1px solid black;
    margin-right: 10px;
    left: 10px;
}

#footer .footer-social-links-mobile ul li a {
    font-size: 18px;
    padding: 5px;
    background-color: transparent;
    border-radius: 20px !important;
    border: 1px solid black;
}

@media (max-width: 800px) {
    #footer .footer-social-links-mobile ul {
        /* list-style-type: none; */
        padding: 0px;
        display: inline-flex;
    }
}

#demo {
    display: inline-block
}


#footer .footer-top .copyright {
    text-align: center;
    color: black;
}

#support-footer-view {
    display: none;
}

#social-links-for-mobile {
    display: none;
}

@media(max-width:767px) {
    #support-mobile-view {
        display: none;
    }

    #shop-hidden {
        display: none;
    }

    #contact-hidden {
        display: none;
    }

    #news-hidden {
        display: none;
    }

    #about-hiddden {
        display: none;
    }

    .hidden-for-mobile {
        display: none;
    }

    #support-footer-view {
        display: block;
    }

    .support-links-mobile-view {
        justify-content: center;
        padding: 0px 8px;
    }

    .mobile-view-links-padding {
        margin-bottom: 0px;
        padding: 0px 3px;
        /* border-right: 1px solid #989595; */
    }

    .dott-between a:after {
        content: '\00a0\00b7\00a0';
        /* display: none; */
        text-align: center;
        vertical-align: middle;
        width: 20px;
    }

    #social-links-for-mobile {
        display: flex;
    }

    #social-links-hidden-for-mobile {
        display: none;
    }

}

.app-bar-content {
    align-items: center;
    display: flex;
    justify-content: space-between;
    width: 100%;
    padding: 9px 19px;
    text-align: center;
    margin-bottom: 0px;
    font-size: 11px;
}

.aap_bar_text {
    margin-bottom: 0;
}

.app-bar-container {
    background-color: white;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
}
</style>

<footer id="footer">
    <div class="container">
        <div class="row">
            <!-- <svg viewBox="0 0 100 25" class="svg-fotter">
                <defs>
                    <pattern id="Wave" x="0" y="0" width="100" height="25" patternUnits="userSpaceOnUse">
                        <path d="M0 25 0 6C20 9 38 11 55 7 72 4 87 4 100 6l0 19z" id="path4" fill="#ffcf93" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#Wave)" />
            </svg> -->
            <div class="col-12">
                <div class="footer-top">

                    <div class="row" id="social-links-for-mobile">
                        <div class="col-12" id="footer-follow-us">
                            <div class="footer-social-links-mobile" style="margin-top: 0px;text-align:center;">
                                <?php $this->load->view('partials/_social_links', ['show_rss' => true]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-2 footer-widget">
                            <div class="row-custom">
                                <div class="footer-logo">
                                    <a href="<?php echo lang_base_url(); ?>"><img
                                            src="<?php echo get_logo($this->general_settings); ?>" alt="logo"></a>
                                </div><br />
                                <div class="copyright">
                                    <?php echo html_escape($this->settings->copyright); ?>
                                </div>
                            </div>
                            <div class="row-custom">
                                <div class="footer-about">
                                    <?php echo html_escape($this->settings->about_footer); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-2 footer-widget" id="about-hiddden">
                            <div class="nav-footer">
                                <div class="row-custom">
                                    <h5 class="footer-title"><?php echo trans("about"); ?></h5>
                                </div>
                                <div class="row-custom">
                                    <ul>
                                        <li><a
                                                href="<?php echo lang_base_url() . 'aboutus'; ?>"><?php echo trans("who_are_we"); ?></a>
                                        </li>
                                        <li><a
                                                href="<?php echo lang_base_url() . 'contact'; ?>"><?php echo trans("contact_us"); ?></a>
                                        </li>




                                        <?php if (!empty($this->menu_links)) :
                                            foreach ($this->menu_links as $menu_link) :
                                                if ($menu_link->location == 'quick_links') :
                                                    $item_link = generate_menu_item_url($menu_link);
                                                    if (!empty($menu_link->page_default_name)) :
                                                        $item_link = generate_url($menu_link->page_default_name);
                                                    endif; ?>
                                        <li><a
                                                href="<?= $item_link; ?>"><?php echo html_escape($menu_link->title); ?></a>
                                        </li>
                                        <?php endif;
                                            endforeach;
                                        endif; ?>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-2 footer-widget" id="support-mobile-view">
                            <div class="nav-footer">
                                <div class="row-custom">
                                    <h4 class="footer-title hidden-for-mobile"><?php echo trans("support") ?></h4>
                                </div>
                                <div class="row-custom">
                                    <ul>
                                        <li><a
                                                href="<?php echo lang_base_url() . 'privacy'; ?>"><?php echo trans("privacy") ?></a>
                                        </li>
                                        <li><a
                                                href="<?php echo lang_base_url() . 'terms_conditions'; ?>"><?php echo trans("terms_conditions") ?></a>
                                        </li>
                                        <li><a
                                                href="<?php echo lang_base_url() . 'shipping_policy' ?>"><?php echo trans("shipping_policy") ?></a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link"
                                                href="<?php echo lang_base_url() . 'return_and_exchange'; ?>"><?php echo trans("return_and_exchange"); ?></a>
                                        </li>


                                        <!-- <?php if (!empty($this->menu_links)) :
                                                    foreach ($this->menu_links as $menu_link) :
                                                        if ($menu_link->location == 'information') :
                                                            $item_link = generate_menu_item_url($menu_link);
                                                            if (!empty($menu_link->page_default_name)) :
                                                                $item_link = generate_url($menu_link->page_default_name);
                                                            endif; ?>
                                            <?php endif;
                                                    endforeach; ?>

                                        <?php endif; ?> -->

                                        <?php if (!empty($this->menu_links)) :
                                            foreach ($this->menu_links as $menu_link) :
                                                if ($menu_link->location == 'information') : ?>
                                        <?php endif;
                                            endforeach;
                                        endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 col-sm-2 footer-widget" id="support-footer-view">
                            <form id="form_validate_newsletter">
                                <div class="newsletter-inner">
                                    <h4 class="footer-title" style="font-size: 14px; left: 100px;">
                                        <?php echo trans("newsletter"); ?></h4>
                                    <div class="d-table-cell">
                                        <input type="text" id="textEmail" name="email"
                                            class="form-control auth-form-input"
                                            placeholder="<?php echo trans("type_email"); ?>">
                                        <p id="demo"></p>
                                    </div>
                                    <div class="d-table-cell">
                                        <!-- <a class="button" id="subscribe"><?php echo trans("subscribe"); ?></a> -->
                                        <button type="button" class="btn btn-default"
                                            id="subscribe"><?php echo trans("subscribe"); ?></button>
                                    </div>
                                </div>
                                <p id="demo" style="color: red;display:none"></p>
                            </form>

                            <div id="newsletter" class="m-t-5">
                                <?php if ($this->session->flashdata('news_error')) :
                                // echo '<span class="text-danger">' . $this->session->flashdata('news_error') . '</span>';
                                endif;
                                if ($this->session->flashdata('news_success')) :
                                // echo '<span class="text-success">' . $this->session->flashdata('news_success') . '</span>';
                                endif; ?>
                            </div>
                            <div class="nav-footer">
                                <div class="row-custom">
                                    <div class="row support-links-mobile-view">
                                        <p class="mobile-view-links-padding dott-between"><a
                                                href="<?php echo lang_base_url() . 'privacy'; ?>"><?php echo trans("privacy") ?></a>
                                        </p>
                                        <p class="mobile-view-links-padding dott-between"><a
                                                href="<?php echo lang_base_url() . 'terms-conditions'; ?>"><?php echo trans("terms_conditions") ?></a>
                                        </p>
                                        <p class="mobile-view-links-padding dott-between"><a
                                                href="<?php echo lang_base_url() . 'shipping_policy' ?>"><?php echo trans("shipping_policy") ?></a>
                                        </p>
                                        <p class="mobile-view-links-padding dott-between" style="padding: 0px 5px;"><a
                                                href="<?php echo lang_base_url() . 'blog' ?>"><?php echo trans("blog") ?></a>
                                        </p>
                                        <p class="nav-item mobile-view-links-padding" style="padding: 0px 5px;"><a
                                                href="<?php echo lang_base_url() . 'return_and_exchange'; ?>"><?php echo trans("return_and_exchange"); ?></a>
                                        </p>


                                        <!-- <?php if (!empty($this->menu_links)) :
                                                    foreach ($this->menu_links as $menu_link) :
                                                        if ($menu_link->location == 'information') :
                                                            $item_link = generate_menu_item_url($menu_link);
                                                            if (!empty($menu_link->page_default_name)) :
                                                                $item_link = generate_url($menu_link->page_default_name);
                                                            endif; ?>
                                            <?php endif;
                                                    endforeach; ?>

                                        <?php endif; ?> -->

                                        <?php if (!empty($this->menu_links)) :
                                            foreach ($this->menu_links as $menu_link) :
                                                if ($menu_link->location == 'information') : ?>
                                        <?php endif;
                                            endforeach;
                                        endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-12 col-sm-2 footer-widget onlyweb" id="contact-hidden">
                            <div class="nav-footer">
                                <div class="row-custom">
                                    <h4 class="footer-title"><?php echo trans("contact"); ?></h4>
                                </div>

                                <div class="row-custom">
                                    <ul>
                                        <li><a href="mailto:trazenwood@gmail.com" id=response>
                                                <?php echo trans("contact_trazenwood"); ?></a></li>
                                        <li><a href="tel:+91-<?php echo $this->settings->contact_phone; ?>"
                                                id="respond"><?php echo trans("customer_care"); ?><?php echo $this->settings->contact_phone; ?></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="footer-social-links" style="margin-top: 0px;text-align:center;">

                                    <?php $this->load->view('partials/_social_links', ['show_rss' => true]); ?>

                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-2 footer-widget onlyweb">
                            <div class="newsletter">
                                <h4 class="footer-title" style="font-size: 14px; left: 100px;">
                                    <?php echo trans("newsletter"); ?></h4><br />
                                <!-- <?php echo form_open('add-to-subscribers-post', [
                                            'id' => 'form_validate_newsletter'
                                        ]); ?> -->
                                <form id="form_validate_newsletter">
                                    <div class="newsletter-inner">
                                        <div class="d-table-cell">
                                            <input type="text" id="textEmail1" name="email"
                                                class="form-control auth-form-input"
                                                placeholder="<?php echo trans("type_email"); ?>">
                                            <p id="demo1"></p>
                                        </div><br />



                                        <div class="d-table-cell">
                                            <!-- <button class="btn btn-default" type="submit" onclick="validateEmail()"><?php echo trans("subscribe"); ?> -->
                                            <button type="button" class="btn btn-default"
                                                id="subscribe1"><?php echo trans("subscribe"); ?></button>

                                        </div>
                                    </div>
                                    <p id="demo1" style="color: red;display:none"></p>
                                </form>

                                <div id="newsletter" class="m-t-5">
                                    <?php if ($this->session->flashdata('news_error')) :
                                    // echo '<span class="text-danger">' . $this->session->flashdata('news_error') . '</span>';
                                    endif;
                                    if ($this->session->flashdata('news_success')) :
                                    // echo '<span class="text-success">' . $this->session->flashdata('news_success') . '</span>';
                                    endif; ?>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="mobile-nav-container app-bar-container">
                <ul class="app-bar-content">
                    <li>
                        <a href="<?php echo lang_base_url(); ?>"><img
                                src="<?php echo base_url(); ?>assets/img/app-bar-imgs/app_bar_home.png">
                            <p class="aap_bar_text">Home</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo generate_url("category"); ?>"><img
                                src="<?php echo base_url(); ?>assets/img/app-bar-imgs/app_bar_categories.png">
                            <p class="aap_bar_text">Categories</p>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo generate_url("cart"); ?>"><img
                                src="<?php echo base_url(); ?>assets/img/app-bar-imgs/app_bar_cart.png">
                            <p class="aap_bar_text">Cart</p>
                        </a>
                    </li>
                    <li>
                        <?php if ($this->auth_check) : ?>
                        <?php if ($this->auth_user->user_type != "guest") : ?>
                        <a href="<?php echo generate_url("wishlist") . "/" . $this->auth_user->slug; ?>">
                            <img src="<?php echo base_url(); ?>assets/img/app-bar-imgs/app_bar_whishlist.png">
                            <p class="aap_bar_text">Wishlist</p>
                        </a>
                        <?php else : ?>
                        <!-- hide wishlist for guest user -->
                        <!-- <li class="icon-bg"> -->
                        <a href="javascript:void(0)" data-toggle="modal" data-id="0" data-target="#registerModal">
                            <img src="<?php echo base_url(); ?>assets/img/app-bar-imgs/app_bar_whishlist.png">
                            <!-- <a href="<?php echo generate_url("wishlist") . "/" . $this->auth_user->slug; ?>"> -->
                            <p class="aap_bar_text">Wishlist</p>
                            <!-- <i class="icon-heart-o"></i> -->
                        </a>
                        <!-- </li> -->
                        <?php endif; ?>
                        <?php else : ?>
                        <a style="font-weight: bold" id='wishlist-mobile-view'>
                            <img src="<?php echo base_url(); ?>assets/img/app-bar-imgs/app_bar_whishlist.png">
                            <p class="aap_bar_text">Wishlist</p>
                        </a>
                    </li>


                    <?php endif; ?>
                    </li>
                    <li>
                        <?php if ($this->auth_check) : ?>
                        <?php if ($this->auth_user->user_type != "guest") : ?>
                        <a href="<?php echo generate_dash_url("buyer_panel"); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/app-bar-imgs/app_bar_profile.png">
                            <p class="aap_bar_text">Profile</p>
                        </a>
                        <?php endif; ?>
                        <?php else : ?>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#OtploginModal">
                            <img src="<?php echo base_url(); ?>assets/img/app-bar-imgs/app_bar_profile.png">
                            <p class="aap_bar_text">Profile</p>
                        </a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<?php if (!isset($_COOKIE["modesy_cookies_warning"]) && $this->settings->cookies_warning) : ?>
<div class="cookies-warning">
    <div class="text"><?php echo $this->settings->cookies_warning_text; ?></div>
    <a href="javascript:void(0)" onclick="hide_cookies_warning();" class="icon-cl"> <i class="icon-close"></i></a>
</div>
<?php endif; ?>
<!-- Scroll Up Link -->
<a href="javascript:void(0)" class="scrollup"><i class="icon-arrow-up"></i></a>

<?php if (!empty($this->session->userdata('mds_send_email_data'))) : ?>
<script>
$(document).ready(function() {
    var data = JSON.parse(<?php echo json_encode($this->session->userdata("mds_send_email_data")); ?>);
    if (data) {
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        data["sys_lang_id"] = sys_lang_id;
        $.ajax({
            type: "POST",
            url: base_url + "send-email-post",
            data: data,
            success: function(response) {}
        });
    }
});
</script>
<?php endif;
$this->session->unset_userdata('mds_send_email_data'); ?>

<?php if (check_cron_time()) : ?>
<script>
$.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>run-internal-cron"
});
</script>
<?php endif; ?>



<script>
$('<input>').attr({
    type: 'hidden',
    name: 'sys_lang_id',
    value: '<?php echo $this->selected_lang->id; ?>'
}).appendTo('form[method="post"]');
</script>
<script>
var sys_lang_id = "<?= $this->selected_lang->id; ?>";
var base_url = "<?= base_url(); ?>";
var lang_base_url = "<?= lang_base_url(); ?>";
var thousands_separator = "<?= $this->thousands_separator; ?>";
var fb_app_id = "<?= $this->general_settings->facebook_app_id; ?>";
var csfr_token_name = "<?= $this->security->get_csrf_token_name(); ?>";
var csfr_cookie_name = "<?= $this->config->item('csrf_cookie_name'); ?>";
var is_recaptcha_enabled = false;
var txt_all = "<?= trans("all"); ?>";
var sweetalert_ok = "<?= trans("ok"); ?>";
var sweetalert_cancel = "<?= trans("cancel"); ?>";
var msg_accept_terms = "<?= trans("msg_accept_terms"); ?>";
var slider_fade_effect = "<?= ($this->general_settings->slider_effect == "fade") ? 1 : 0; ?>";
<?php if ($recaptcha_status == true) : ?>is_recaptcha_enabled = true;
<?php endif; ?><?php if (!empty($index_categories)) : foreach ($index_categories as $category) : ?>
if ($('#category_products_slider_<?= $category->id; ?>').length != 0) {
    $('#category_products_slider_<?= $category->id; ?>').slick({
        autoplay: false,
        autoplaySpeed: 4900,
        infinite: true,
        speed: 200,
        swipeToSlide: true,
        rtl: rtl,
        cssEase: 'linear',
        lazyLoad: 'progressive',
        prevArrow: $('#category-products-slider-nav-<?= $category->id; ?> .prev'),
        nextArrow: $('#category-products-slider-nav-<?= $category->id; ?> .next'),
        slidesToShow: 5,
        slidesToScroll: 1,
        responsive: [{
            breakpoint: 992,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1
            }
        }, {
            breakpoint: 768,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1
            }
        }, {
            breakpoint: 576,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        }]
    });
}
<?php endforeach;
                    endif; ?>
<?php if ($this->general_settings->pwa_status == 1) : ?>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('<?= base_url(); ?>pwa-sw.js').then(function(registration) {},
            function(err) {
                console.log('ServiceWorker registration failed: ', err);
            }).catch(function(err) {
            console.log(err);
        });
    });
} else {
    console.log('service worker is not supported');
}
<?php endif; ?>
</script>
<?php echo $this->general_settings->google_analytics; ?>
<?php echo $this->general_settings->custom_javascript_codes; ?>
<script>
var txt_processing = "<?= trans("processing"); ?>";
var sweetalert_ok = "<?= trans("ok"); ?>";
var sweetalert_cancel = "<?= trans("cancel"); ?>";
</script>
</body>

</html>
<!-- <script>
    function validateEmail() {
        // $("#newsletter").hide();

        var email;
        email = document.getElementById("textEmail").value;

        var reg = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        console.log(reg.test(textEmail.value));

        if (reg.test(textEmail.value) == false) {
            document.getElementById("demo").style.color = "red";
            document.getElementById("demo").innerHTML = "Please enter valid email address";
            // alert('Invalid Email Address ->' + email);
            return false;
        } else if (reg.test(textEmail.value) == true){

            document.getElementById("demo").innerHTML = "";

        }

        return true;


    }
</script> -->
<script>
$(document).ready(function() {
    $('#subscribe').click(function(e) {
        e.preventDefault();
        var email = document.getElementById("textEmail").value;
        console.log(email);
        var reg = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (reg.test(email) == false) {
            document.getElementById("demo").style.color = "red";
            document.getElementById("demo").innerHTML = "Please enter valid email address";
            $("demo").hide();
            // alert('Invalid Email Address ->' + email);
            return false;
        } else {
            var base_url = '<?php echo base_url() ?>';
            var data = {
                "email": email
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "home_controller/add_to_subscribers",
                data: data,
                dataType: 'json',
                async: false,
                success: function(response) {

                    $('#demo')[0].innerText = response.message;
                    if (response.status == '1') {
                        $('#form_validate_newsletter')[0].reset();
                        $('#demo')[0].style.color = "green";
                        $('#demo')[0].innerText = response.message;
                        // $('#demo').show();
                    } else {
                        $('#demo')[0].style.color = "red";
                        $('#demo')[0].innerText = response.message;
                        // $('#demo').hide();

                    }
                }
            });
        }
    });
})
</script>
<script>
$(document).ready(function() {
    $('#subscribe1').click(function(e) {
        e.preventDefault();
        var email = document.getElementById("textEmail1").value;
        console.log(email);
        var reg = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (reg.test(email) == false) {
            console.log(reg.test(email));
            document.getElementById("demo1").style.color = "red";
            document.getElementById("demo1").innerHTML = "Please enter valid email address";
            // $("demo1").hide();
            // alert('Invalid Email Address ->' + email);
            return false;
        } else {
            var base_url = '<?php echo base_url() ?>';
            var data = {
                "email": email
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "home_controller/add_to_subscribers",
                data: data,
                dataType: 'json',
                async: false,
                success: function(response) {

                    $('#demo1')[0].innerText = response.message;
                    if (response.status == '1') {
                        $('#form_validate_newsletter')[0].reset();
                        $('#demo1')[0].style.color = "green";
                        $('#demo1')[0].innerText = response.message;
                        $('#demo1').show();
                        console.log(response.message);
                    } else {
                        $('#demo1')[0].style.color = "red";
                        $('#demo1')[0].innerText = response.message;
                        $('#demo1').show();
                        console.log(response.message);

                    }
                }
            });
        }
    });
})
</script>
<!-- <script>
    $(document).ready(function() {
        $('#subscribe1').click(function(e) {
            e.preventDefault();
            var email = document.getElementById("textEmail1").value;
            console.log(email);
            var reg = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (reg.test(email) ==
                false) {
                console.log(reg.test(email));
                document.getElementById("demo1").style.color = "red";
                document.getElementById("demo1").innerHTML = "Please enter valid email address";
                $("demo1").hide();
                // alert('Invalid Email Address ->' + email);
                return false;
            } else {
                var base_url = '<?php echo base_url() ?>';
                var data = {
                    "email": email
                };
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                $.ajax({
                    type: "POST",
                    url: base_url + "home_controller/add_to_subscribers",
                    data: data,
                    dataType: 'json',
                    async: false,
                    success: function(response) {

                        $('#demo1')[0].innerText = response.message;
                        if (response.status == '1') {
                            $('#form_validate_newsletter')[0].reset();
                            $('#demo1')[0].style.color = "green";
                            $('#demo1')[0].innerText = response.message;
                            // $('#demo1').show();
                        } else {
                            $('#demo1')[0].style.color = "red";
                            $('#demo1')[0].innerText = response.message;
                            // $('#demo1').hide();
                        }
                    }
                });
            }
        });
    })
</script> -->

<script>
$("#wishlist-mobile-view").click(function() {

    $('#loginModal').modal('show');
})
</script>