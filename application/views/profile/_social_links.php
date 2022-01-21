<style>
    .btn-new-review {
        background-color: #FF3334;
        border-color: #FF3334;
        border-radius: 20px;
        color: white;
    }
</style>



<div class="col-12 col-sm-12 col-md-6">
    <?php if ($this->general_settings->reviews == 1) : ?>
        <div class="profile-rating">
            <?php if ($user_rating->count > 0) :
                $this->load->view('partials/_review_stars', ['review' => $user_rating->rating]); ?>
                &nbsp;</span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="profile-details">
        <div class="textleft">
            <?php if ($this->auth_check) : ?>
                <?php if ($this->auth_user->id != $user->id) : ?>
                    <button class="btn btn-md btn-secondary btn-new-review" data-toggle="modal" data-target="#reviewModal"><i class="icon-envelope"></i><?php echo trans("leave_review") ?></button>
                <?php endif; ?>
            <?php else : ?>
                <button class="btn btn-md btn-secondary btn-new-review" data-toggle="modal" data-target="#loginModal"><i class="icon-envelope"></i><?php echo trans("leave_review") ?></button>
            <?php endif; ?>

            <?php if ($this->auth_check) : ?>
                <?php if ($this->auth_user->id != $user->id) : ?>
                    <button class="btn btn-md btn-secondary btn-new-review" data-toggle="modal" data-target="#messageModal"><i class="icon-envelope"></i><?php echo trans("message_privately") ?></button>
                <?php endif; ?>
            <?php else : ?>
                <button class="btn btn-md btn-secondary btn-new-review" data-toggle="modal" data-target="#loginModal"><i class="icon-envelope"></i><?php echo trans("message_privately") ?></button>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="col-12 col-sm-12 col-md-6" style="margin-top: 2%;">
    <div class="row-custom profile-buttons">
        <div class="social">
            <ul>
                <?php if (!empty($user->facebook_url)) : ?>
                    <li><a href="<?php echo $user->facebook_url; ?>" target="_blank"><i class="icon-facebook" style="color: #3b5998;"></i></a></li>
                <?php endif; ?>
                <?php if (!empty($user->twitter_url)) : ?>
                    <li><a href="<?php echo $user->twitter_url; ?>" target="_blank"><i class="icon-twitter" style="color: #1DA1F2;"></i></a></li>
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
                    <li><a href="<?php echo $user->youtube_url; ?>" target="_blank"><i class="icon-youtube" style="color:#FF0000"></i></a></li>
                <?php endif; ?>
                <?php if ($this->general_settings->rss_system == 1 && $user->show_rss_feeds == 1 && get_user_products_count($user->id) > 0) : ?>
                    <li><a href="<?php echo lang_base_url() . "rss/" . get_route("seller", true) . $user->slug; ?>" target="_blank"><i class="icon-rss"></i></a></li>
                <?php endif; ?>
            </ul>
        </div>

    </div>
</div>