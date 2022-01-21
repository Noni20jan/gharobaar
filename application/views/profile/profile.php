<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .scroll {
        height: 470px;
        overflow: auto;
        margin-bottom: 10px;
    }

    .review-style {
        width: 144px;
        height: 114px;
    }


    .notify-me {
        /* margin-left: 12%; */
        border: 3px solid #FF3334;
        border-radius: 30px;
        width: 100%;
        padding: 3%;
        text-align: center;
        /* margin-bottom: 8%; */
    }

    .notify-button {
        border: none;
        color: white;
        padding: 12px 26px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
    }

    .notify-button1 {
        background-color: #FF3334;
        border-radius: 60px;
    }

    .see-other-brands {
        border: none;
        color: white;
        padding: 15px 32px;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    }

    .SOB2 {
        background-color: #DF9323;
        border-radius: 60px;
    }

    @media(max-width:768px) {
        .profile-details .img-profile {
            width: 240px;
            height: 160px;
            margin-bottom: 20px;
            border-radius: .1875rem;
            margin-top: 1%;
        }

        .notify-button {
            border: none;
            color: white;
            padding: 10px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-weight: 700;
            cursor: pointer;
        }

        .p-notify {
            margin-top: -8%;
        }

        .h4-notify {
            font-size: 17px;
        }

    }


    .shop-by {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-between;
        padding: 0px;
    }

    .top-sellers-new-ui {
        width: 100%;
        box-shadow: 2px 2px 5px #808080de;
        border-radius: 20px;
    }

    #description-for-web {
        display: flex;
    }


    #description-for-mobile {
        display: none;
    }

    @media(max-width:768px) {
        .top-sellers-new-ui {
            width: 120px;
            height: 140px;
            border-radius: 20px;
            box-shadow: 2px 2px 5px #808080de;
        }

        .scroll {
            height: 465px;
            overflow: auto;
            margin-bottom: 10px;
        }

        .shop-by {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: space-between;
            padding: 0px;
            overflow-x: scroll;
        }

        #description-for-web {
            display: none !important;
        }

        #description-for-mobile {
            display: flex !important;
        }

        .review-img-new {
            width: 75% !important;
            border-radius: 50%;
        }
    }

    .morecontent span {
        display: none;

    }

    .morelink {
        display: block;
        color: green;
        font-family: 'Montserrat';
        text-decoration: underline;
    }

    .morelink:hover {
        display: block;
        /* color: green; */
        font-family: 'Montserrat';
        text-decoration: underline;
    }

    #be_review {
        position: relative;
        left: 42%;
    }

    @media(max-width:700px) {
        #be_review {
            position: relative;
            left: 16%;
        }
    }

    #first_review {
        position: relative;
        left: 42%;
    }

    @media(max-width:700px) {
        #first_review {
            position: relative;
            left: 16%;
        }
    }

    .see_more {
        color: green !important;
    }

    .review-img-new {
        width: 60%;
        border-radius: 50%;
    }
</style>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo trans("profile"); ?></li>
                    </ol>
                </nav>
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
            <div class="row" id="description-for-web">
                <div class="col-12">
                    <!-- load profile details -->
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-4 m-b-30 text-center profile-details">
                            <?php //$this->load->view("profile/_story_video_box"); 
                            ?>
                            <img class="img-seller-profile" src="<?php echo get_user_avatar($user); ?>" alt="<?php echo get_shop_name($user); ?>" style="border-radius:50%; margin-right:9%; width:50%;">
                        </div>
                        <div class="col-12 col-sm-12 col-md-8 m-b-30">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12">
                                    <p class="description-aboutme more">
                                        <?php echo html_escape($user->about_me); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row" style="margin-left: -4%;">
                                <?php $this->load->view("profile/_social_links"); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="description-for-mobile">
                <div class="col-12">
                    <!-- load profile details -->
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-4 m-b-30 text-center profile-details" style="margin-bottom:12px !important;">
                            <?php //$this->load->view("profile/_story_video_box"); 
                            ?>
                            <img class="img-seller-profile" src="<?php echo get_user_avatar($user); ?>" alt="<?php echo get_shop_name($user); ?>" style="border-radius:50%;width:50%;">
                        </div>
                        <div class="row-custom">
                            <div class="profile-rating" style="display:grid; place-items:center;">
                                <?php if ($user_rating->count > 0) :
                                    $this->load->view('partials/_review_stars', ['review' => $user_rating->rating]); ?>
                                    &nbsp;</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-8 m-b-30">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12">
                                    <p class="description-aboutme more" style="padding-left:15px;">
                                        <?php echo html_escape($user->about_me); ?>
                                    </p>
                                </div>
                            </div>
                            <!-- <div class="row" style="margin-left: -4%;"> -->
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
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
            </div>


        <?php endif; ?>
        <?php if (($user->role == 'admin' || $user->role == 'vendor') && is_multi_vendor_active()) : ?>

            <div class="profile-page-top">
                <div class="row-custom">
                    <div class="col-12 col-sm-12 col-md-12 m-b-30">
                        <div id="product_slider_container">
                            <!-- <h3 style="padding-left:15px;">Seller�s Activities</h3> -->
                            <!-- <div class="row shop-by" style="padding-left: 9px;">
                                <div class="col-sm-2 for-space-between-imgs">
                                    <img class="top-sellers-new-ui" src="assets/img/landing-page-img/your-seller-1.png">
                                </div>
                                <div class="col-sm-2 for-space-between-imgs">
                                    <img class="top-sellers-new-ui" src="assets/img/landing-page-img/your-seller-2.png">
                                </div>
                                <div class="col-sm-2 for-space-between-imgs">
                                    <img class="top-sellers-new-ui" src="assets/img/landing-page-img/your-seller-3.png">
                                </div>
                                <div class="col-sm-2 for-space-between-imgs">
                                    <img class="top-sellers-new-ui" src="assets/img/landing-page-img/your-seller-4.png">
                                </div>
                                <div class="col-sm-2 for-space-between-imgs">
                                    <img class="top-sellers-new-ui" src="assets/img/landing-page-img/your-seller-5.png">
                                </div>
                                <div class="col-sm-2 for-space-between-imgs">
                                    <img class="top-sellers-new-ui" src="assets/img/landing-page-img/your-seller-6.png">
                                </div>
                            </div> -->
                            <?php $this->load->view("profile/_image_slides", ["user_id" => $user->id]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>


        <?php endif; ?>
        <?php if (($user->role == 'admin' || $user->role == 'vendor') && is_multi_vendor_active() && false) : ?>
            <div class="row">
                <div class="col-12">
                    <?php $this->load->view("profile/_percentage_indecators"); ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($user->is_shop_open == 0) : ?>
            <div class="row-custom" style="margin-top: 19px;">
                <div class="notify-me">
                    <div class="col-md-12" style="padding-right:0px;">
                        <h4 class="h4-notify">Hi! We are working at full capacity right now. </h4>
                        <br>
                        <p class="p-notify">Please click on notify me and we will get back to you.</p>
                        <button class="notify-button notify-button1">Notify Me</button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-12 groove">
                <?php $this->load->view("profile/_product_section", ["user_id" => $user->id]); ?>
            </div>
        </div>
        <div class="col-12 text-center">
            <div class="btn btn-md btn-view-more-new m-t-15 more" style="box-shadow: 2px 2px 5px #808080de !important;">
                <a id="show_more_products" class="view-new-text" href="<?= generate_url("products") . '?search=' . $user->brand_name; ?>">View More Products</a><i class="fa fa-caret-down" style="color:black; margin-left:6px;"></i>
            </div>
        </div>


        <h3 style="text-align:center; padding-top:40px;">Seller Reviews</h3>

        <ul class="list-unstyled list-reviews scroll" id="seller-review-tab" style="margin-bottom:0px;">

            <?php if (!empty($reviews_supplier)) : ?>
                <?php $count = 0; ?>
                <?php foreach ($reviews_supplier as $review) :
                    if ($count < 3) : ?>

                        <li class="media" style="margin-bottom: 15px;">
                            <a class="review-style" href="<?php echo generate_profile_url($review->user_slug); ?>">
                                <img class="review-img-new" src="<?php echo get_user_avatar_by_id($review->user_id); ?>" alt="<?php echo get_shop_name_by_user_id($review->user_id); ?>">
                            </a>
                            <div class="media-body" style="margin-top:20px;">
                                <!-- <div class="row-custom">
                                    </*?php $this->load->view('partials/_review_stars', ['review' => $review]); ?*/>
                                </div> -->
                                <div class="row-custom">
                                    <a href="<?php echo generate_profile_url($review->user_slug); ?>">
                                        <h6 class="username"><?php echo get_shop_name_by_user_id($review->user_id); ?></h6>
                                    </a>
                                </div>
                                <div class="row-custom">
                                    <div class="review">
                                        <?php echo html_escape($review->review); ?>
                                    </div>
                                </div>
                                <!-- <div class="row-custom">
                            <span class="date"><//?php echo time_ago($review->created_at); ?></span>
                        </div> -->
                            </div>
                        </li>

                <?php endif;
                    $count++;
                endforeach; ?>
                <div class="text-center">
                    <div id="more_review" class="index_btn_text index_btn btn btn-md btn-custom m-t-15" style="font-weight: 700;" data-user="<?php echo $user->id ?>">View More Reviews</div>
                </div>
            <?php else : ?>
                <?php if ($this->auth_check) : ?>
                    <?php if ($this->auth_user->id != $user->id) : ?>
                        <button class="btn btn-md btn-secondary btn-new-review" id="first_review" data-toggle="modal" data-target="#reviewModal">Be the first one to review</button>
                    <?php endif; ?>
                <?php else : ?>
                    <button class="btn btn-md btn-secondary btn-new-review" id="be_review" data-toggle="modal" data-target="#loginModal">Be the first one to review</button>
                <?php endif; ?>
            <?php endif; ?>

        </ul>
    </div>
</div>
<!-- Wrapper End-->
<!-- include send message modal -->
<?php $this->load->view("partials/_modal_send_message", ["subject" => null]); ?>
<?php $this->load->view("partials/_modal_send_review", ["subject" => null]); ?>



<script>
    $(document).ready(function() {
        // Configure/customize these variables.
        var showChar = 250; // How many characters are shown by default
        var ellipsestext = "";
        var moretext = "See More";
        var lesstext = "See Less";


        $('.more').each(function() {
            var content = $(this).html();

            if (content.length > showChar) {

                var c = content.substr(0, showChar);
                var h = content.substr(showChar, content.length - showChar);

                var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="see_more morelink" >' + moretext + '</a></span>';

                $(this).html(html);
            }

        });

        $(".morelink").click(function() {
            if ($(this).hasClass("less")) {
                $(this).removeClass("less");
                $(this).html(moretext);
            } else {
                $(this).addClass("less");
                $(this).html(lesstext);
            }
            $(this).parent().prev().toggle();
            $(this).prev().toggle();
            return false;
        });
    });
</script>
<script>
    $(document).on("click", "#more_review", function(b) {
        var user_id = $(this).attr("data-user");
        var data = {
            user_id: user_id
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "profile_controller/get_review_seller",
            data: data,
            success: function(result) {
                res = JSON.parse(result);
                if (res.status == 1) {
                    $("#seller-review-tab")[0].innerHTML = res.html_content;
                } else {
                    alert("No more data");
                }

            }

        })

    });
</script>