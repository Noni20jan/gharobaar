<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Wrapper -->

<style>
    .img-circle {
        border-radius: 50%;
        margin-left: 40%;
    }

    @media only screen and (max-width: 900px) {
        .img-circle {
            border-radius: 50%;
            margin-left: 10%;
            width: 74%;
        }
    }

    #story_vdio_url {
        width: 90%;
    }

    @media only screen and (max-width: 900px) {
        #story_vdio_url {
            width: 76%;
        }
    }


    #edit_profile {
        margin-top: -6px;
        margin-left: 540px;
        margin-bottom: 19px;
        width: 17%;
    }

    @media only screen and (max-width: 900px) {
        #edit_profile {
            margin-top: -6px;
            margin-left: 85px;
            margin-bottom: 19px;
            width: 47%;
        }
    }

    #filters {
        margin-top: -38px;
        width: 8%;
        /* margin-left: 51%; */
        float: right
    }

    @media only screen and (max-width: 700px) {
        #filters {
            margin-left: 78%;
            margin-top: -38spx;
            width: 23%;
        }
    }

    .name {
        margin-left: 4%;
        font-size: 21px;
    }

    @media only screen and (max-width: 700px) {
        .name {

            margin-left: -6%;
            font-size: 21px;
        }
    }

    .follow_information {
        margin-left: 4%;
        font-size: 21px;
    }

    @media (max-width: 700px) {
        .svg-fotter {
            position: absolute;
            top: -6%;
            left: 0;
        }
    }

    @media only screen and (max-width: 700px) {
        .follow_information {

            margin-left: 3%;
            font-size: 21px;
        }
    }
</style>
<div id="wrapper">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
                    </ol>
                </nav>
                <h1 class="page-title"><?php echo $title; ?></h1>
                <!-- <div class="image">
                    <img src="<?php echo get_user_avatar($this->auth_user); ?>" class="img-circle" alt="">
                </div><br />
                <p align="center" class="name"><b><?php echo get_full_name($this->auth_user) ?></b></p>
                <p align="center" class="follow_information"><?php echo get_following_users_count($user->id); ?> Following<span>
                        <?php echo get_followers_count($user->id); ?> followers
                    </span>
                </p>
                <button class="btn btn-md btn-custom btn-sell-now m-r-0" id="edit_profile"><i class="fa fa-pencil"></i><a href="<?php echo lang_base_url(); ?>profile_settings">Edit Profile</a></button><br /> -->
                <!-- <input type="text" name="story_vedio_url" id="story_vdio_url" class="form-control auth-form-input" value="" placeholder="Search your favourite products">
                <button type="button" class="btn btn-custom btn-filter" id="filters">Filters</button> -->
                <div>
                    <br />

                </div>



                <!-- <div class="buttons">

                    <span class="followercount">Edit Profile</span>
                </div> -->
            </div>
        </div>

        <div class="col-12">
            <div class="page-contact">
                <div class="row">
                    <?php if (!empty($products)) :
                        foreach ($products as $product) : ?>
                            <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product" id='<?php echo $product->id; ?>'>
                                <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => false]); ?>
                            </div>
                        <?php endforeach;
                    else : ?>
                        <div class="col-12">
                            <p class="text-center"><?php echo trans("no_products_found"); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="row">
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>

    </div>
</div>

</div>
<!-- Wrapper End-->