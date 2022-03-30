<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="<?= base_url(); ?>assets/admin/css/main-8.css">
<!-- Wrapper -->
<style>
    .profile-details .img-profile {
        width: 172px;
        height: 170px;
        margin-bottom: 20px;
        border-radius: .1875rem
    }
    .product-item-options {
    width: auto;
    height: auto;
    position: absolute;
    top: 187px !important;
    right: 0;
    text-align: center;
  }
  @media(max-width:700px){
    .product-item-options {
    width: auto;
    height: auto;
    position: absolute;
    top: 189px !important;
    right: 0;
    text-align: center;
  }
}
    .profile-page-top {
        margin-top: 5%;
    }
</style>
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a href="<?php echo generate_dash_url("update_business_information"); ?>" class="btn btn-custom pull-right " id="fixedbutton">
                    <span>Update Profile</span>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="profile-page-top">
                <!-- load profile details -->
                <?php if ($user->role == 'vendor') {
                    $this->load->view("profile/_profile_user_info");
                }
                if ($user->role == 'member') {
                    $this->load->view("profile/_profile_user_info_user");
                }
                ?>
            </div>
        </div>
        <?php if (($user->role == 'admin' || $user->role == 'vendor') && is_multi_vendor_active()) : ?>
            <div class="row">
                <div class="col-12">
                    <!-- load profile details -->
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-4 m-b-30 text-center profile-details">
                            <img class="img-profile" src="<?php echo get_user_avatar($user); ?>" alt="<?php echo get_shop_name($user); ?>" style="border-radius:50%; margin-right:9%; margin-top: -7%;">
                        </div>
                        <div class="col-12 col-sm-12 col-md-8 m-b-30">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12">
                                    <p class="description-aboutme">
                                        <?php echo html_escape($user->about_me); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row">

                                <?php $this->load->view("profile/_social_links"); ?>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <!-- <div class="row">

            <div class="col-12 col-sm-12 col-md-3">]

                <img src="<?php echo get_user_gst($user); ?>" alt="<?php echo get_shop_name($user); ?>" class="img-profile">
            </div>
            <div class="col-12 col-sm-12 col-md-3">
                <img src="<?php echo get_user_pan($user); ?>" alt="<?php echo get_shop_name($user); ?>" class="img-profile">
            </div>
            <div class="col-12 col-sm-12 col-md-3">
                <img src="<?php echo get_user_adhaar($user); ?>" alt="<?php echo get_shop_name($user); ?>" class="img-profile">
            </div>
            <div class="col-12 col-sm-12 col-md-3">
                <img src="<?php echo get_user_other($user); ?>" alt="<?php echo get_shop_name($user); ?>" class="img-profile">
            </div>
        </div> -->
        <!-- <?php if (($user->role == 'admin' || $user->role == 'vendor') && is_multi_vendor_active()) : ?>
            <?php $video = $this->file_model->get_user_story_video($user->id); ?>

            <div class="row">
                <div class="col-12">
                    <div class="profile-page-top">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 m-b-10">
                                <div class="image-heading">Seller's Video</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-4 m-b-30"></div>
                            <div class="col-12 col-sm-12 col-md-4 m-b-30">

                                <?php if (!empty($video)) : ?>
                                    <center>
                                        <video width="400" controls>
                                            <source src="<?php echo get_user_video_url($video); ?>" type="video/mp4">
                                            Your browser does not support HTML video.
                                        </video>
                                    </center>
                                <?php else : ?>
                                    <div class="dm-uploader-container">
                                        <div id="drag-and-drop-zone-video" class="dm-uploader dm-uploader-media text-center">
                                            <p class="dm-upload-icon">
                                                <i class="icon-user"></i>
                                            </p>
                                            <p class="dm-upload-text"><?php echo trans("story_not_uploaded"); ?>&nbsp;</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 m-b-30"></div>
                        </div>
                    </div>
                </div>
            </div>


        <?php endif; ?> -->

        <?php if (($user->role == 'admin' || $user->role == 'vendor') && is_multi_vendor_active()) : ?>
            <div class="row">
                <div class="col-12">
                    <div class="profile-page-top">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 m-b-30">
                                <div id="product_slider_container">
                                    <?php $this->load->view("profile/_image_slides", ["user_id" => $user->id]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- <?php if (($user->role == 'admin' || $user->role == 'vendor') && is_multi_vendor_active()) : ?>
            <div class="row">
                <div class="col-12">
                    load percentage indecator details
                    <?php $this->load->view("profile/_percentage_indecators"); ?>
                </div>
            </div>
        <?php endif; ?> -->

        <div class="row">
            <!-- <div class="col-sm-12 col-md-1 m-b-30">
            </div> -->
            <div class="col-sm-12 col-md-13 m-b-30">
                <?php $this->load->view("profile/_product_section", ["user_id" => $user->id]); ?>
            </div>
            <!-- <div class="col-sm-12 col-md-1 m-b-30">
            </div> -->
        </div>

        <!-- <?php if (($user->role == 'admin' || $user->role == 'vendor') && is_multi_vendor_active()) : ?>
            <div class="row">
                <div class="col-12">
                   
                    <?php $this->load->view("profile/_details_info"); ?>
                </div>
            </div>
        <?php endif; ?> -->

        <!-- <?php if (($user->role == 'admin' || $user->role == 'vendor') && is_multi_vendor_active()) : ?>
            <div class="row">
                <div class="col-12">
                 
                    <?php $this->load->view("profile/_people_about_us"); ?>
                </div>
            </div>
        <?php endif; ?> -->
    </div>
</div>
<!-- Wrapper End-->

<!-- include send message modal -->
<?php $this->load->view("partials/_modal_send_message", ["subject" => null]); ?>
<?php $this->load->view("partials/_modal_send_review", ["subject" => null]); ?>