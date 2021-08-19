<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="profile-tabs">
    <ul class="nav">
        <!-- <li class="nav-item <?php echo ($active_tab == 'update_profile') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?php echo generate_url("settings"); ?>">
                <span><?php echo trans("update_profile"); ?></span>
            </a>
        </li> -->
        <?php if ($this->auth_user->is_active_shop_request == 1) : ?>
            <li class="nav-item <?php echo ($active_tab == 'update_settings') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo generate_url("settings", "update_settings"); ?>">
                    <span>Update Seller Info</span>
                </a>
            </li>
        <?php endif; ?>
        <!-- <li class="nav-item <?php echo ($active_tab == 'personal_information') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?php echo generate_url("settings", "personal_information"); ?>">
                <span><?php echo trans("personal_information"); ?></span>
            </a>
        </li> -->
        <!-- <?php if ($this->is_sale_active) : ?>
            <li class="nav-item <?php echo ($active_tab == 'shipping_address') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo generate_url("settings", "shipping_address"); ?>">
                    <span><?php echo trans("shipping_address"); ?></span>
                </a>
            </li>
        <?php endif; ?> -->
        <!-- <?php if ($this->auth_user->role == "vendor") : ?>
            <li class="nav-item <?php echo ($active_tab == 'social_media_seller') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo generate_url("settings", "social_media_seller"); ?>">
                    <span><?php echo trans("social_media"); ?></span>
                </a>
            </li>
        <?php else : ?>
            <li class="nav-item <?php echo ($active_tab == 'social_media') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo generate_url("settings", "social_media"); ?>">
                    <span><?php echo trans("social_media"); ?></span>
                </a>
            </li>
        <?php endif; ?> -->
        <!-- <li class="nav-item <?php echo ($active_tab == 'change_password') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?php echo generate_url("settings", "change_password"); ?>">
                <span><?php echo trans("change_password"); ?></span>
            </a>
        </li> -->


    </ul>
</div>