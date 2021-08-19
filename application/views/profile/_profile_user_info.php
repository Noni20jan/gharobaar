<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .button-follow-followers {
        border-color: #DF911E;
        color: #61b720;
        padding: 10px 32px;
        text-align: center;
        display: inline-block;
        border-radius: 20px;
        font-weight: 500;
        font-size: medium;
        width: 60%;
    }

    @media(max-width:768px) {
        .button-follow-followers {
            border-color: #DF911E;
            color: #61b720;
            padding: 10px 32px;
            text-align: center;
            display: inline-block;
            border-radius: 20px;
            font-weight: 500;
            font-size: medium;
            width: 50%;
        }

        #profile-for-web {
            display: none !important;
        }

        #profile-for-mobile {
            display: table !important;
        }
    }

    /* #profile-for-web {
        display: table;
    } */

    #profile-for-mobile {
        display: none;
    }

    .btn-new-review {
        background-color: #007C05;
        border-color: #007C05;
        border-radius: 20px;
        color: white;
    }
</style>
<!--user profile info-->
<div class="row-custom">
    <div class="profile-details" id="profile-for-web">
        <div class="col-md-4 left">
            <!-- <img src="<?php echo get_user_avatar($user); ?>" alt="<?php echo get_shop_name($user); ?>" class="img-profile">
            </div>
            <div class="right"> -->
            <div class="row-custom row-profile-username">
                <h1 class="username">
                    <a href="<?php echo generate_profile_url($user->slug); ?>"> <?php echo get_brand_name($user); ?></a>
                </h1>
                <?php if ($user->role == 'vendor' || $user->role == 'admin') : ?>
                    <i class="icon-verified icon-verified-member"></i>
                <?php endif; ?>
            </div>
            <div class="row-custom">
                <p class="p-last-seen">
                    <span class="last-seen <?php echo (is_user_online($user->last_seen)) ? 'last-seen-online' : ''; ?>"> <i class="icon-circle"></i> <?php echo trans("last_seen"); ?>&nbsp;<?php echo time_ago($user->last_seen); ?></span>
                </p>
            </div>
            <?php if ($user->role == 'admin' || $user->role == 'vendor') : ?>
                <div class="row-custom">
                    <p class="description">
                        <?php echo html_escape(ucfirst($user->brand_desc)); ?>
                    </p>
                </div>
            <?php endif; ?>

            <div class="row-custom user-contact">
                <span class="info"><?php echo trans("member_since"); ?>&nbsp;<?php echo helper_date_format($user->created_at); ?></span>
                <?php if ($user->role == "admin" || $this->general_settings->hide_vendor_contact_information != 1) :
                    if (!empty($user->phone_number) && $user->show_phone == 1) : ?>
                        <span class="info"><i class="icon-phone"></i>
                            <a href="javascript:void(0)" id="show_phone_number"><?php echo trans("show"); ?></a>
                            <a href="tel:<?php echo html_escape($user->phone_number); ?>" id="phone_number" class="display-none"><?php echo html_escape($user->phone_number); ?></a>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($user->email) && $user->show_email == 1) : ?>
                        <span class="info"><i class="icon-envelope"></i><?php echo html_escape($user->email); ?></span>
                <?php endif;
                endif; ?>
                <?php if (!empty(get_location($user)) && $user->show_location == 1) : ?>
                    <span class="info"><i class="icon-map-marker"></i><?php echo get_location($user); ?></span>
                <?php endif; ?>
            </div>



            <!-- <div class="row-custom profile-buttons">


                <div class="social">
                    <ul>
                        <?php if (!empty($user->facebook_url)) : ?>
                            <li><a href="<?php echo $user->facebook_url; ?>" target="_blank"><i class="icon-facebook"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->twitter_url)) : ?>
                            <li><a href="<?php echo $user->twitter_url; ?>" target="_blank"><i class="icon-twitter"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->instagram_url)) : ?>
                            <li><a href="<?php echo $user->instagram_url; ?>" target="_blank"><i class="icon-instagram"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->pinterest_url)) : ?>
                            <li><a href="<?php echo $user->pinterest_url; ?>" target="_blank"><i class="icon-pinterest"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->linkedin_url)) : ?>
                            <li><a href="<?php echo $user->linkedin_url; ?>" target="_blank"><i class="icon-linkedin"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->vk_url)) : ?>
                            <li><a href="<?php echo $user->vk_url; ?>" target="_blank"><i class="icon-vk"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->youtube_url)) : ?>
                            <li><a href="<?php echo $user->youtube_url; ?>" target="_blank"><i class="icon-youtube"></i></a></li>
                        <?php endif; ?>
                        <?php if ($this->general_settings->rss_system == 1 && $user->show_rss_feeds == 1 && get_user_products_count($user->id) > 0) : ?>
                            <li><a href="<?php echo lang_base_url() . "rss/" . get_route("seller", true) . $user->slug; ?>" target="_blank"><i class="icon-rss"></i></a></li>
                        <?php endif; ?>
                    </ul>
                </div>

            </div> -->
        </div>
        <div class="col-md-4 left textcenter">
            <img src="<?php echo get_user_logo($user); ?>" alt="<?php echo get_shop_name($user); ?>" class="img-profile">
            <div class="button-follow-followers">
                <?php if ($this->auth_check) : ?>
                    <?php if ($this->auth_user->id != $user->id) : ?>

                        <!--form follow-->
                        <?php echo form_open('follow-unfollow-user-post', ['class' => 'form-inline']); ?>
                        <input type="hidden" name="following_id" value="<?php echo $user->id; ?>">
                        <input type="hidden" name="follower_id" value="<?php echo $this->auth_user->id; ?>">
                        <?php if (is_user_follows($user->id, $this->auth_user->id)) : ?>
                            <button class="btn btn-md btn-secondary btn-new-review"><i class="icon-user-minus"></i><?php echo trans("unfollow"); ?></button>
                        <?php else : ?>
                            <button class="btn btn-md btn-secondary btn-new-review"><i class="icon-user-plus"></i><?php echo trans("follow"); ?></button>
                        <?php endif; ?>
                        <?php echo form_close(); ?>

                    <?php endif; ?>
                <?php else : ?>
                    <button class="btn btn-md btn-secondary btn-custom" data-toggle="modal" data-target="#loginModal"><i class="icon-user-plus"></i><?php echo trans("follow"); ?></button>
                <?php endif; ?>

                <span class="followercount"><?php echo get_followers_count($user->id); ?> Followers</span>
            </div>
        </div>
        <div class=" col-md-4 left textright">
            <div class="row-custom row-profile-username">
                <h1 class="fullname">
                    <?php echo get_full_name($user); ?>
                </h1>
            </div>
            <?php if ($user->role == 'admin' || $user->role == 'vendor') : ?>
                <div class="row-custom">
                    <p class="supplier_type">
                        <?php if ($user_categories) :
                            $i = 0;
                            foreach ($user_categories as $cat_id => $cat_count) :
                                $category = get_category_by_id($cat_id);
                                echo ($category->name . "<br>");
                                $i++;
                                if ($i >= $this->general_settings->max_category_show)
                                    break;
                            endforeach;
                        ?>

                        <?php else : ?>
                            <?php echo html_escape($user->supplier_type); ?>
                        <?php endif; ?>
                    </p>
                </div>
            <?php endif; ?>

            <div class="row-custom user-contact">
                <?php if (!empty(get_supplier_city($user))) : ?>
                    <span class="suppliercity"><i class="icon-map-marker"></i><?php echo get_supplier_city($user); ?></span>
                <?php endif; ?>
            </div>


        </div>

    </div>

</div>


<div class="row-custom">
    <div class="profile-details" id="profile-for-mobile">

        <div class="col-md-4 left textcenter" style="text-align:center;">
            <div class="row-custom user-contact">
                <?php if (!empty(get_supplier_city($user))) : ?>
                    <span class="suppliercity"><i class="icon-map-marker"></i><?php echo get_supplier_city($user); ?></span>
                <?php endif; ?>
            </div>
            <img src="<?php echo get_user_logo($user); ?>" alt="<?php echo get_shop_name($user); ?>" class="img-profile">
            <div class="button-follow-followers">
                <?php if ($this->auth_check) : ?>
                    <?php if ($this->auth_user->id != $user->id) : ?>

                        <!--form follow-->
                        <?php echo form_open('follow-unfollow-user-post', ['class' => 'form-inline']); ?>
                        <input type="hidden" name="following_id" value="<?php echo $user->id; ?>">
                        <input type="hidden" name="follower_id" value="<?php echo $this->auth_user->id; ?>">
                        <?php if (is_user_follows($user->id, $this->auth_user->id)) : ?>
                            <button class="btn btn-md btn-secondary btn-custom"><i class="icon-user-minus"></i><?php echo trans("unfollow"); ?></button>
                        <?php else : ?>
                            <button class="btn btn-md btn-secondary btn-custom"><i class="icon-user-plus"></i><?php echo trans("follow"); ?></button>
                        <?php endif; ?>
                        <?php echo form_close(); ?>

                    <?php endif; ?>
                <?php else : ?>
                    <button class="btn btn-md btn-secondary btn-custom" data-toggle="modal" data-target="#loginModal"><i class="icon-user-plus"></i><?php echo trans("follow"); ?></button>
                <?php endif; ?>

                <span class="followercount"><?php echo get_followers_count($user->id); ?> Followers</span>
            </div>
        </div>




        <div class=" col-md-4 left textright" style="text-align:center;">
            <div class="row-custom row-profile-username">
                <h1 class="fullname">
                    <?php echo get_full_name($user); ?>
                </h1>
            </div>
            <?php if ($user->role == 'admin' || $user->role == 'vendor') : ?>
                <div class="row-custom">
                    <p class="supplier_type">
                        <?php if ($user_categories) :
                            $i = 0;
                            foreach ($user_categories as $cat_id => $cat_count) :
                                $category = get_category_by_id($cat_id);
                                echo ($category->name . "<br>");
                                $i++;
                                if ($i >= $this->general_settings->max_category_show)
                                    break;
                            endforeach;
                        ?>

                        <?php else : ?>
                            <?php echo html_escape($user->supplier_type); ?>
                        <?php endif; ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>


        <div class="col-md-4 left">
            <!-- <img src="<?php echo get_user_avatar($user); ?>" alt="<?php echo get_shop_name($user); ?>" class="img-profile">
            </div>
            <div class="right"> -->
            <div class="row-custom row-profile-username">
                <h1 class="username" style="text-align:center;float:none;">
                    <a href="<?php echo generate_profile_url($user->slug); ?>"> <?php echo get_brand_name($user); ?></a>
                    <?php if ($user->role == 'vendor' || $user->role == 'admin') : ?>
                        <i class="icon-verified icon-verified-member" style="float:none;"></i>
                    <?php endif; ?>
                </h1>
            </div>
            <!-- <div class="row-custom">
                <p class="p-last-seen">
                    <span class="last-seen <//?php echo (is_user_online($user->last_seen)) ? 'last-seen-online' : ''; ?>"> <i class="icon-circle"></i> <//?php echo trans("last_seen"); ?>&nbsp;<//?php echo time_ago($user->last_seen); ?></span>
                </p>
            </div> -->
            <?php if ($user->role == 'admin' || $user->role == 'vendor') : ?>
                <!-- <div class="row-custom">
                    <p class="description">
                        <? //php echo html_escape(ucfirst($user->brand_desc)); 
                        ?>
                    </p>
                </div> -->
            <?php endif; ?>

            <!-- <div class="row-custom user-contact">
                <span class="info"><?php echo trans("member_since"); ?>&nbsp;<?php echo helper_date_format($user->created_at); ?></span>
                <?php if ($user->role == "admin" || $this->general_settings->hide_vendor_contact_information != 1) :
                    if (!empty($user->phone_number) && $user->show_phone == 1) : ?>
                        <span class="info"><i class="icon-phone"></i>
                            <a href="javascript:void(0)" id="show_phone_number"><?php echo trans("show"); ?></a>
                            <a href="tel:<?php echo html_escape($user->phone_number); ?>" id="phone_number" class="display-none"><?php echo html_escape($user->phone_number); ?></a>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($user->email) && $user->show_email == 1) : ?>
                        <span class="info"><i class="icon-envelope"></i><?php echo html_escape($user->email); ?></span>
                <?php endif;
                endif; ?>
                <?php if (!empty(get_location($user)) && $user->show_location == 1) : ?>
                    <span class="info"><i class="icon-map-marker"></i><?php echo get_location($user); ?></span>
                <?php endif; ?>
            </div> -->



            <!-- <div class="row-custom profile-buttons">


                <div class="social">
                    <ul>
                        <?php if (!empty($user->facebook_url)) : ?>
                            <li><a href="<?php echo $user->facebook_url; ?>" target="_blank"><i class="icon-facebook"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->twitter_url)) : ?>
                            <li><a href="<?php echo $user->twitter_url; ?>" target="_blank"><i class="icon-twitter"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->instagram_url)) : ?>
                            <li><a href="<?php echo $user->instagram_url; ?>" target="_blank"><i class="icon-instagram"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->pinterest_url)) : ?>
                            <li><a href="<?php echo $user->pinterest_url; ?>" target="_blank"><i class="icon-pinterest"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->linkedin_url)) : ?>
                            <li><a href="<?php echo $user->linkedin_url; ?>" target="_blank"><i class="icon-linkedin"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->vk_url)) : ?>
                            <li><a href="<?php echo $user->vk_url; ?>" target="_blank"><i class="icon-vk"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->youtube_url)) : ?>
                            <li><a href="<?php echo $user->youtube_url; ?>" target="_blank"><i class="icon-youtube"></i></a></li>
                        <?php endif; ?>
                        <?php if ($this->general_settings->rss_system == 1 && $user->show_rss_feeds == 1 && get_user_products_count($user->id) > 0) : ?>
                            <li><a href="<?php echo lang_base_url() . "rss/" . get_route("seller", true) . $user->slug; ?>" target="_blank"><i class="icon-rss"></i></a></li>
                        <?php endif; ?>
                    </ul>
                </div>

            </div> -->
        </div>

    </div>

</div>