<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .occasion{
        position: relative;
        color:#007C05 !important;
    }
</style>
<div id="navMobile" class="nav-mobile">
    <div class="nav-mobile-inner" id="js-opener">
        <div class="row">
            <div class="col-sm-12 mobile-nav-buttons">
                <?php if (is_multi_vendor_active()) :
                    if ($this->auth_check) : ?>
                        <?php if (is_multi_vendor_active()) : ?>
                            <?php if (!is_user_vendor()) : ?>
                                <?php if (!is_user_applied_for_shop()) : ?>
                                    <a href="<?= generate_url("why_sell_with_us"); ?>" class="btn btn-md btn-custom btn-block"><?= trans("sell_now"); ?></a>
                                <?php else : ?>
                                    <a href="<?= generate_url("start-selling"); ?>" class="btn btn-md btn-custom btn-block"><?= trans("sell_now"); ?></a>
                                <?php endif; ?>
                            <?php else : ?>
                                <?php if ($this->auth_user->supplier_type == "Goods") { ?>
                                    <a href="<?= generate_dash_url("add_product"); ?>" class="btn btn-md btn-custom btn-block"><?= trans("sell_now"); ?></a>
                                <?php } else { ?>
                                    <a href="<?= generate_dash_url("add_service"); ?>" class="btn btn-md btn-custom btn-block"><?= trans("sell_now"); ?></a>
                                <?php } ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php else : ?>
                        <!-- <a href="javascript:void(0)" class="btn btn-md btn-custom btn-block close-menu-click" data-toggle="modal" data-target="#loginModal"><?php echo trans("sell_now"); ?></a> -->
                        <a href="<?php echo generate_url("why_sell_with_us"); ?>" class="btn btn-md btn-custom btn-block close-menu-click"><?php echo trans("sell_now"); ?></a>
                <?php endif;

                endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <ul id="navbar_mobile_links" class="navbar-nav">
                    <?php if ($this->auth_check) : ?>
                        <?php if ($this->auth_user->user_type != "guest") : ?>
                            <li class="dropdown profile-dropdown nav-item">
                                <a href="#" class="dropdown-toggle image-profile-drop nav-link" data-toggle="dropdown" aria-expanded="false">
                                    <img src="<?php echo get_user_avatar($this->auth_user); ?>" alt="<?php echo html_escape($this->auth_user->username); ?>">
                                    <?php echo get_shop_name($this->auth_user); ?> <span class="icon-arrow-down"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php if ($this->auth_user->role == "admin") : ?>
                                        <li>
                                            <a href="<?php echo admin_url(); ?>">
                                                <i class="icon-admin"></i>
                                                <?php echo trans("admin_panel"); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (is_user_vendor()) : ?>
                                        <li>
                                            <a href="<?= generate_dash_url("profile"); ?>" target="_blank">
                                                <i class="icon-dashboard"></i>
                                                Supplier Panel
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo generate_dash_url("buyer_panel"); ?>">
                                                <i class="fa fa-user" style="color:#838383" aria-hidden="true"></i>
                                                Buyer Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo generate_url("profile_settings"); ?>">
                                                <i class="fas fa-edit" style="color:#838383"></i> <span>Update Profile</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo generate_url("following") . "/" . $this->auth_user->slug; ?>">
                                                <i class="fas fa-user-plus" style="color:#838383"></i> <span>Following</span>
                                            </a>
                                        </li>
                                        <!-- <li>
                                            <a href="<?php echo generate_dash_url("buyer_panel"); ?>">
                                                <i class="icon-user"></i>
                                                Buyer Panel
                                            </a>
                                        </li> -->
                                    <?php else : ?>
                                        <li>
                                            <a href="<?php echo generate_dash_url("buyer_panel"); ?>">
                                                <i class="icon-dashboard"></i>
                                                Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo generate_url("profile_settings"); ?>">
                                                <i class="fas fa-edit" style="color:#838383"></i> <span>Update Profile</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo generate_url("following") . "/" . $this->auth_user->slug; ?>">
                                                <i class="fas fa-user-plus" style="color:#838383"></i> <span>Following</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <!-- <li>
                                    <a href="<?php echo generate_dash_url("profile"); ?>">
                                        <i class="icon-user"></i>
                                        <?php echo trans("profile"); ?>
                                    </a>
                                </li> -->
                                    <?php if ($this->is_sale_active) : ?>
                                        <?php //if (!is_user_vendor()) : 
                                        ?>
                                        <li>
                                            <a href="<?php echo generate_url("orders_dashboard"); ?>">

                                                <i class="icon-shopping-basket"></i>
                                                <?php echo trans("orders"); ?>
                                            </a>
                                        </li>
                                        <?php //endif; 
                                        ?>


                                    <?php endif; ?>
                                    <!-- <li>
                                    <a href="<?php echo generate_url("messages"); ?>">
                                        <i class="icon-mail"></i>
                                        <?php echo trans("messages"); ?>&nbsp;<?php if ($unread_message_count > 0) : ?>
                                        <span class="span-message-count"><?php echo $unread_message_count; ?></span>
                                    <?php endif; ?>
                                    </a>
                                </li> -->

                                    <li>
                                        <a href="<?php echo generate_url("wishlist") . "/" . $this->auth_user->slug; ?>">
                                            <i class="icon-heart-o"></i>
                                            <?php echo trans("wishlist"); ?>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="<?php echo base_url(); ?>logout" class="logout">
                                            <i class="icon-logout"></i>
                                            <?php echo trans("logout"); ?>
                                        </a>
                                    </li>
                                </ul>
                            </li> <?php else : ?>
                            <!-- hide panel for guest user -->

                        <?php endif; ?>
                    <?php else : ?>
                        <li class="nav-item"><a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal" class="nav-link close-menu-click" id="cta_color"><?php echo trans("login"); ?></a></li>
                        <li class="nav-item"><a href="javascript:void(0)" data-toggle="modal" data-target="#registerModal" class="nav-link close-menu-click" id="cta_color"><?php echo trans("register"); ?></a></li>
                    <?php endif; ?>

                    <?php if ($this->general_settings->multilingual_system == 1 && count($this->languages) > 1) : ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <?php echo trans("language"); ?>
                            </a>
                            <ul class="mobile-language-options">
                                <?php foreach ($this->languages as $language) :
                                    $lang_url = base_url() . $language->short_form . "/";
                                    if ($language->id == $this->general_settings->site_lang) {
                                        $lang_url = base_url();
                                    } ?>
                                    <li>
                                        <a href="<?php echo $lang_url; ?>" class="<?php echo ($language->id == $this->selected_lang->id) ? 'selected' : ''; ?> ">
                                            <?php echo html_escape($language->name); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">

                <div id="navbar_mobile_back_button"></div>
                <ul id="navbar_mobile_categories" class="navbar-nav">
                    <?php if (!empty($this->parent_categories)) :
                        foreach ($this->parent_categories as $category) :
                            if ($category->has_subcategory > 0) : ?>
                                <li class="nav-item">
                                    <a href="javascript:void(0)" class="nav-link" data-id="<?= $category->id; ?>" data-parent-id="<?= $category->parent_id; ?>"><?php echo category_name($category); ?><i class="icon-arrow-right"></i></a>
                                </li>
                            <?php else : ?>
                                <li class="nav-item">
                                    <a href="<?php echo generate_category_url($category); ?>" class="nav-link"><?php echo category_name($category); ?></a>
                                </li>
                            <?php endif; ?>
                    <?php endforeach;
                    endif; ?>
                </ul>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <ul class="navbar-nav">
                <?php $valentines = trans("festival_occasion"); ?>
                <?php if ($this->general_settings->valentine_visibility == 1) : ?>
                   <li class="nav-item"><a class="nav-link" href="<?php echo lang_base_url() . 'banner_by_product' . '/' . $valentines; ?>"><img class="holi" src="<?php echo base_url();?>assets/img/Holi_Specials.png"></a></li>
                <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo lang_base_url() . 'shop-by-concern'; ?>"><?php echo trans("shop_by_concern"); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo lang_base_url() . 'shop-by-occasion'; ?>"><?php echo trans("shop_by_occasion"); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo lang_base_url() . 'shop-by-seller'; ?>"><?php echo trans("shop_by_seller"); ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo lang_base_url() . 'aboutus'; ?>">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo lang_base_url() . 'contact'; ?>"><?php echo trans("contact_us"); ?></a></li>
                </ul>
            </div>
        </div>

    </div>

    <div class="nav-mobile-footer">
        <?php $this->load->view('partials/_social_links', ['show_rss' => true]); ?>
    </div>
</div>

<script>
    function overlay(isShow) {
        var elm = document.getElementById('js-opener')
        if (isShow) {
            elm.style.display = 'block';
        } else {
            elm.style.display = 'none';
        }
    }



    function closeNav() {
        overlay(false);
        document.getElementById('js-opener').style.width = "0"
    }



    // var NAV_WITH = 300;
    // var speed = 200;

    // var swipeOptions = {
    //     triggerOnTouchEnd: true,
    //     swipeStatus: swipeStatus,
    //     allowPageScroll: "vertical",
    //     threshold: 100
    // };

    // $(function() {
    //     nav = $("nav");
    //     nav.swipe(swipeOptions);
    // });

    // /**
    //  * Catch each phase of the swipe.
    //  * move : we drag the div
    //  * cancel : we animate back to where we were
    //  * end : we animate to the next image
    //  */
    // function swipeStatus(event, phase, direction, distance) {

    //     if (phase == "move" && (direction == "left")) {
    //         var duration = 0;

    //         scrollNav(distance, duration);

    //     } else if (phase == "cancel") {
    //         scrollNav(0, speed);
    //     } else if (phase == "end") {
    //         hideNav();
    //     }
    // }

    // function hideNav() {
    //     scrollNav(NAV_WITH, speed);
    // }

    // /**
    //  * Manually update the position of the nav on drag
    //  */
    // function scrollNav(distance, duration) {
    //     nav.css("transition-duration", (duration / 1000).toFixed(1) + "s");
    //     //inverse the number we set in the css
    //     var value = (distance < 0 ? "" : "-") + Math.abs(distance).toString();
    //     nav.css("transform", "translate(" + value + "px,0)");
    // }

    // /**
    //  * Open it again
    //  */
    // document.getElementById("js-opener").onclick = function fun() {
    //     scrollNav(0, speed);
    // }
</script>