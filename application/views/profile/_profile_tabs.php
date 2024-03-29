<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!--profile page tabs-->
<div class="profile-tabs">
    <ul class="nav">
        <?php if (is_multi_vendor_active() && 0) :
            if ($user->role == 'admin' || $user->role == 'vendor') : ?>
                <?php if ($user->supplier_type == "Goods") { ?>
                    <li class="nav-item <?php echo ($active_tab == 'products') ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo generate_profile_url($user->slug); ?>">
                            <span><?php echo trans("products"); ?></span>
                            <span class="count">(<?php echo get_user_products_count($user->id); ?>)</span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo ($active_tab == 'barter_product') ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo generate_url("barter_product") . "/" . $user->slug; ?>">
                            <span>Products available for Barter</span>
                            <span class="count">(<?php echo get_user_barter_products_count($user->id); ?>)</span>
                        </a>
                    </li>
                <?php } else if ($user->supplier_type == "Services") { ?>
                    <li class="nav-item <?php echo ($active_tab == 'products') ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo generate_profile_url($user->slug); ?>">
                            <span>Services</span>
                            <span class="count">(<?php echo get_user_products_count($user->id); ?>)</span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo ($active_tab == 'barter_product') ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?php echo generate_url("barter_product") . "/" . $user->slug; ?>">
                            <span>Products available for Barter</span>
                            <span class="count">(<?php echo get_user_barter_products_count($user->id); ?>)</span>
                        </a>
                    </li>
                <?php } ?>
        <?php endif;
        endif; ?>
        <?php if (0) : ?>
            <li class="nav-item <?php echo ($active_tab == 'wishlist') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo generate_url("wishlist") . "/" . $user->slug; ?>">
                    <span><?php echo trans("wishlist"); ?></span>
                    <span class="count">(<?php echo get_user_wishlist_products_count($user->id); ?>)</span>
                </a>
            </li>
        <?php endif; ?>
        <?php if (is_multi_vendor_active() && 0) : ?>
            <?php if ($this->auth_check && $this->auth_user->id == $user->id && $this->is_sale_active && $this->general_settings->digital_products_system == 1) : ?>
                <li class="nav-item <?php echo ($active_tab == 'downloads') ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?php echo generate_url("downloads"); ?>">
                        <span><?php echo trans("downloads"); ?></span>
                        <span class="count">(<?php echo get_user_downloads_count($user->id); ?>)</span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endif; ?>
        <li class="nav-item <?php echo ($active_tab == 'followers') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?php echo generate_url("followers") . "/" . $user->slug; ?>">
                <span><?php echo trans("followers"); ?></span>
                <span class="count">(<?php echo get_followers_count($user->id); ?>)</span>
            </a>
        </li>
        <?php if (($user->role == 'admin' || $user->role == 'vendor') && is_multi_vendor_active() && 0) : ?>
            <li class="nav-item <?php echo ($active_tab == 'stories') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo generate_url("stories") . "/" . $user->slug; ?>">
                    <span>Stories</span>
                    <span class="count">(<?php echo get_followers_count($user->id); ?>)</span>
                </a>
            </li>
        <?php endif; ?>
        <li class="nav-item <?php echo ($active_tab == 'following') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?php echo generate_url("following") . "/" . $user->slug; ?>">
                <span><?php echo trans("following"); ?></span>
                <span class="count">(<?php echo get_following_users_count($user->id); ?>)</span>
            </a>
        </li>
        <?php if (($this->general_settings->reviews == 1) && ($user->role == 'admin' || $user->role == 'vendor') && is_multi_vendor_active()) : ?>
            <li class="nav-item <?php echo ($active_tab == 'reviews') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo generate_url("reviews") . "/" . $user->slug; ?>">
                    <span><?php echo trans("reviews"); ?></span>
                    <span class="count">(<?php echo $user_rating->count; ?>)</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>

<div class="row-custom">
    <!--Include banner-->
    <?php $this->load->view("partials/_ad_spaces_sidebar", ["ad_space" => "profile_sidebar", "class" => "m-t-30"]); ?>
</div>