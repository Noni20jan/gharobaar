<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .blogs-logo {
        float: right;
        width: 100%;
    }

    .blogs-heading {
        text-align: center;
        color: #58585A;
        font-weight: bold;
        font-size: 26px;
    }

    /* .blogs-img {
        float: right;
    } */
    .blog-1-img {
        margin-top: 28px;
    }

    #blog-1-all {
        text-align: -webkit-center;
    }

    #blog-2-all {
        text-align: -webkit-center;
    }

    .blogs-description {
        margin-top: 4%;
        font-weight: bold;
    }

    .brief-content-blog {
        position: relative;
        text-align: left;
        left: 56px;
    }

    .brief-content {
        color: #888;
        font-size: 14px;
    }

    @media(max-width:768px) {
        .blogs-img {
            float: right;
            width: 100%;
        }

        .brief-content-blog {
            position: relative;
            text-align: left;
            left: 0px !important;
        }

        /* .blog-1-bg {
            width: 100%;
            /* height: 400px; */
        /* left: 127px; */
        /* background: #FFFFFF;
        border-radius: 40px;
        cursor: pointer;
    } */

        .blog-1-img {
            width: 100%;
            margin-top: 21px;
        }

        #blog-2-all {
            text-align: -webkit-center;
            margin-top: 5%;
        }
    }
</style>




<div id="wrapper" class="index-wrapper">
    <div class="container">
        <div class="row" style="justify-content:center; padding-top: 15px;">
            <h1 class="blogs-heading">BLOGS</h1>
        </div>
        <div class="row" style="text-align:center;">
            <div class="col-md-6">
                <a href='<?php echo base_url(); ?>user_blog_1'>
                    <img src="<?php echo base_url(); ?>assets/img/Blog-1.png" class="blog-1-img">
                    <div class="brief-content-blog">
                        <h6 class="blogs-description">Essential Ingredients To Start Your Online Food Business</h6>
                        <p class="brief-content">You might have a knack for baking delicious cookies or cooking <br>smoked Barbeque Chicken in your yard...</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href='<?php echo base_url(); ?>user_blog_2'>
                    <img src="<?php echo base_url(); ?>assets/img/Blog-2.png" class="blog-1-img">
                    <div class="brief-content-blog">
                        <h6 class="blogs-description">Why Home Cooked Food Always Beats Dine-out</h6>
                        <p class="brief-content">As they say, there is no place like the home. A person may go anywhere,<br>but the comfort and satisfaction...</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>