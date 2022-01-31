<?php defined('BASEPATH') or exit('No direct script access allowed');  ?>
<style>
    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {
        opacity: 0.7;
    }

    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.9);
        /* Black w/ opacity */
    }

    /* Modal Content (image) */
    .modal-content {
        margin: auto;
        display: block;

    }


    /* Caption of Modal Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    @keyframes click-wave {
        0% {
            height: 40px;
            width: 40px;
            opacity: 0.35;
            position: relative;
        }

        100% {
            height: 200px;
            width: 200px;
            margin-left: -80px;
            margin-top: -80px;
            opacity: 0;
        }
    }

    .option-input {
        -webkit-appearance: none;
        -moz-appearance: none;
        -ms-appearance: none;
        -o-appearance: none;
        appearance: none;
        position: relative;
        top: 13.33333px;
        right: 0;
        bottom: 0;
        left: 0;
        height: 40px;
        width: 40px;
        transition: all 0.15s ease-out 0s;
        background: #cbd1d8;
        border: none;
        color: #fff;
        cursor: pointer;
        display: inline-block;
        margin-right: 0.5rem;
        outline: none;
        position: relative;
        z-index: 1000;
    }

    .option-input:hover {
        background: #9faab7;
    }

    .option-input:checked {
        background: #40e0d0;
    }

    .option-input:checked::before {
        height: 40px;
        width: 40px;
        position: absolute;
        content: '✔';
        display: inline-block;
        font-size: 26.66667px;
        text-align: center;
        line-height: 40px;
    }

    .option-input:checked::after {
        -webkit-animation: click-wave 0.65s;
        -moz-animation: click-wave 0.65s;
        animation: click-wave 0.65s;
        background: #40e0d0;
        content: '';
        display: block;
        position: relative;
        z-index: 100;
    }

    .option-input.radio {
        border-radius: 50%;
    }

    .option-input.radio::after {
        border-radius: 50%;
    }

    /* Add Animation */
    .modal-content,
    #caption {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {
            -webkit-transform: scale(0)
        }

        to {
            -webkit-transform: scale(1)
        }
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px) {
        .modal-content {
            width: 100%;
        }
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('product_details'); ?></h3>
            </div><!-- /.box-header -->

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <?php $images = get_product_images($product->id);
                if (!empty($images)) : ?>
                    <div class="row row-product-details row-product-images">
                        <div class="col-sm-12">
                            <?php foreach ($images as $image) : ?>
                                <div class="image m-b-10">
                                    <img src="<?php echo get_product_image_url($image, 'image_small'); ?>" alt="">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('link'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <a href="<?php echo generate_product_url($product); ?>" target="_blank"><?php echo generate_product_url($product); ?></a>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('status'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php if ($product->status == 1) : ?>
                            <label class="label label-success"><?php echo trans("active"); ?></label>
                        <?php else : ?>
                            <label class="label label-danger"><?php echo trans("pending"); ?></label>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('visibility'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php if ($product->visibility == 1) : ?>
                            <label class="label label-success"><?php echo trans("visible"); ?></label>
                        <?php else : ?>
                            <label class="label label-danger"><?php echo trans("hidden"); ?></label>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if (!empty($product->id)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label"><?php echo trans('id'); ?></label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo $product->id; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product_details->title)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label"><?php echo trans('title'); ?></label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo html_escape($product_details->title); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->slug)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label"><?php echo trans('slug'); ?></label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo $product->slug; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->supplier_product_type)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label"><?php echo trans('product_type'); ?></label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo ($product->supplier_product_type); ?>
                        </div>
                    </div>
                <?php endif; ?>


                <?php if (!empty($product->category_id)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label"><?php echo trans('category'); ?></label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php
                            $i = 0;
                            $categories = get_parent_categories_tree($product->category_id, false);
                            if (!empty($categories)) {
                                foreach ($categories as $category) {
                                    if ($i != 0) {
                                        echo ", ";
                                    }
                                    echo html_escape($category->name);
                                    $i++;
                                }
                            } ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product_details->description)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Product Description</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo $product_details->description; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->price)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label"><?php echo trans('base_price_gst'); ?></label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo price_formatted($product->price, $product->currency); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->listing_price)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label"><?php echo trans('listing_price'); ?></label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo price_formatted($product->listing_price, $product->currency); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->discount_rate)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label"><?php echo trans("discount_rate"); ?></label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo $product->discount_rate . "%" ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->price_exclude_gst)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label"><?php echo trans("calculated_price_exclude_gst"); ?></label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo price_formatted($product->price_exclude_gst, $product->currency); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->gst_rate)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">GST Rate</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo $product->gst_rate . "%" ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->gst_amount)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">GST Amount</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo price_formatted($product->gst_amount, $product->currency); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->net_seller_payable)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label"><?php echo trans("you_will_earn"); ?></label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo price_formatted($product->net_seller_payable, $product->currency); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->hsn_code)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">HSN Code</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo $product->hsn_code; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->stock)) : ?>

                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label"><?php echo trans('stock'); ?></label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php if ($product->product_type == "digital") :
                                echo trans("in_stock");
                            else :
                                echo $product->stock;
                            endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <div id="response_product_variations" class="col-sm-12">
                        <?php $this->load->view("dashboard/product/variation/_response_variations", ["product_variations" => $product_variations]); ?>
                        <?php $this->load->view("dashboard/product/variation/_js_variations"); ?>
                    </div>
                </div>
                <?php foreach ($product_variations as $variation) :
                    if (!empty($variation->size_chart)) : ?>
                        <div class="row row-product-details">
                            <div class="col-md-3 col-sm-12">
                                <label class="control-label">Size Chart</label>
                            </div>
                            <div class="col-md-9 col-sm-12 right">
                                <img src="<?php echo base_url() . $variation->size_chart ?>" id="myImg" width="100" height="100">
                            </div>
                        </div><?php endif;
                        endforeach; ?>

                <div id="myModal" class="modal">
                    <span class="close">&times;</span>
                    <img class="modal-content" id="img01">
                    <div id="caption"></div>
                </div>
                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('user'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php $user = get_user($product->user_id);
                        if (!empty($user)) : ?>
                            <a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank">
                                <img src="<?php echo get_user_avatar($user); ?>" alt="" style="width: 50px; height: 50px;">
                                &nbsp;<strong><?php echo $user->username; ?></strong>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('promoted'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php if ($product->is_promoted == 1) : ?>
                            <label class="label label-success"><?php echo trans("yes"); ?></label><br><br>

                            <?php if ($product->status == 1) : ?>
                                <label><?php echo trans("start"); ?>: &nbsp;<?php echo $product->promote_start_date; ?></label><br>
                                <label><?php echo trans("end"); ?>: &nbsp;<?php echo $product->promote_end_date; ?></label><br>
                                <label><?php echo trans("remaining_days"); ?>: &nbsp;<strong><?php echo date_difference($product->promote_end_date, date('Y-m-d H:i:s')); ?></strong></label>
                            <?php else : ?>
                                <label><?php echo trans("purchased_plan") . ": " . $product->promote_plan; ?></label>
                            <?php endif; ?>
                        <?php else : ?>
                            <label class="label label-danger"><?php echo trans("no"); ?></label>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('reviews'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php $this->load->view('admin/includes/_review_stars', ['review' => $product->rating]); ?>

                        <style>
                            .rating {
                                float: left;
                                display: inline-block;
                                margin-right: 10px;
                            }
                        </style>
                    </div>
                </div>

                <?php if (!empty($product->pageviews)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label"><?php echo trans('page_views'); ?></label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo $product->pageviews; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->demo_url)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label"><?php echo trans('demo_url'); ?></label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php if (!empty($product->demo_url)) : ?>
                                <a href="<?php echo $product->demo_url; ?>" target="_blank"><?php echo $product->demo_url; ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->external_link)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label"><?php echo trans('external_link'); ?></label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php if (!empty($product->external_link)) : ?>
                                <a href="<?php echo $product->external_link; ?>" target="_blank" rel="nofollow"><?php echo $product->external_link; ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->files_included)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label"><?php echo trans('files_included'); ?></label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php echo $product->files_included; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->is_draft)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label"><?php echo trans('draft'); ?></label>
                        </div>
                        <div class="col-md-9 col-sm-12 right">
                            <?php if ($product->is_draft == 1) : ?>
                                <label class="label label-success"><?php echo trans("yes"); ?></label>
                            <?php else : ?>
                                <label class="label label-danger"><?php echo trans("no"); ?></label>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('video_preview'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php $video = $this->file_model->get_product_video($product->id);
                        if (!empty($video)) : ?>
                            <div style="width: 500px; max-width: 100%;">
                                <video controls style="width: 100%;">
                                    <source src="<?php echo get_product_video_url($video); ?>" type="video/mp4">
                                </video>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label"><?php echo trans('audio_preview'); ?></label>
                    </div>
                    <div class="col-md-9 col-sm-12 right">
                        <?php $audio = $this->file_model->get_product_audio($product->id);
                        if (!empty($audio)) : ?>
                            <div style="width: 500px; max-width: 100%;">
                                <audio controls style="width: 100%;">
                                    <source src="<?php echo get_product_audio_url($audio); ?>" type="audio/mp3" />
                                </audio>
                            </div>
                        <?php endif; ?>
                    </div>
                </div> -->


                <?php if (!empty($product->sku)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">SKU</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->sku; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->description)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label"><?php echo trans('description'); ?></label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product_details->description; ?>
                        </div>
                    </div>
                    <!-- <div class="row row-product-details">
                    <div class="col-md-3 col-sm-12">
                        <label class="control-label">Created_at</label>
                    </div>
                    <div class="col-md-9 col-sm-12 right description">
                        <?php echo $product->created_at; ?>
                    </div>
                </div> -->
                <?php endif; ?>
                <?php if (!empty($product->work_day)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Work_Day</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->work_day; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->work_time)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Work_Time</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->work_time; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->tentative_time)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Tentative Time</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->tentative_time; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->add_meet)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Type of Inventory</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->add_meet; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->contains_liquid)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Liquid</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->contains_liquid; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->contains_heat)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Heat</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->contains_heat; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($product->temperature)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">temperature</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->temperature; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->allergance)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Allergance</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->allergance; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->availability)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Availability</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->availability; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($product->supplier_product_type)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Supplier Type</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->supplier_product_type; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->is_expire)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Is it Expired</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->is_expire; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->expiry_date)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Expiry Date</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->expiry_date; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->lead_time)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Lead time</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->lead_time; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->is_organic)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Is Organic</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->is_organic; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->is_sustainable)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Is Sustainable</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->is_sustainable; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->is_handicraft)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Is Handicraft</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->is_handicraft; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->is_gluten_Free)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Is Gluten free</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->is_gluten_Free; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->is_vegan)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Is Vegan</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->is_vegan; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->is_keto_friendly)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Is Keto Friendly</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->is_keto_friendly; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->is_allergens)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Is it Allergens</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->is_allergens; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->is_personalised)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Is it Personalised</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->is_personalised; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->is_veg_nonveg_jain)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Food Type</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->is_veg_nonveg_jain; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->is_appetisers_main_course_beverages_desserts)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Meal Type</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->is_appetisers_main_course_beverages_desserts; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->is_gold_silver_precious_stones_semi_precious_artificial)) : ?>

                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Type of Jewellery</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->is_gold_silver_precious_stones_semi_precious_artificial; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->special_delivery_requirement)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Special Delivery</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->special_delivery_requirement; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->delivery_area)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label"> Delivery Area </label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->delivery_area; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->product_wash_instruction)) : ?>
                    <?php if ($product->product_wash_instruction == "others") : ?>
                        <div class="row row-product-details">
                            <div class="col-md-3 col-sm-12">
                                <label class="control-label"> Wash Instruction</label>
                            </div>
                            <div class="col-md-9 col-sm-12 right description">
                                <?php echo $product->other_product_wash_instruction; ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="row row-product-details">
                            <div class="col-md-3 col-sm-12">
                                <label class="control-label"> Wash Instruction</label>
                            </div>
                            <div class="col-md-9 col-sm-12 right description">
                                <?php echo $product->product_wash_instruction; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (!empty($product->blouse_details)) : ?>
                    <?php if ($product->blouse_details == "others") : ?>
                        <div class="row row-product-details">
                            <div class="col-md-3 col-sm-12">
                                <label class="control-label"> Blouse Size</label>
                            </div>
                            <div class="col-md-9 col-sm-12 right description">
                                <?php echo $product->other_blouse_details; ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="row row-product-details">
                            <div class="col-md-3 col-sm-12">
                                <label class="control-label"> Blouse Size</label>
                            </div>
                            <div class="col-md-9 col-sm-12 right description">
                                <?php echo $product->blouse_details; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (!empty($product->minimum_Prior_notice)) : ?>
                    <?php if ($product->minimum_Prior_notice == "others") : ?>
                        <div class="row row-product-details">
                            <div class="col-md-3 col-sm-12">
                                <label class="control-label"> Minimum Prior notice</label>
                            </div>
                            <div class="col-md-9 col-sm-12 right description">
                                <?php echo $product->other_minimum_Prior_notice; ?>
                            </div>
                        </div>
                    <?php else : ?>

                        <div class="row row-product-details">
                            <div class="col-md-3 col-sm-12">
                                <label class="control-label"> Minimum Prior notice</label>
                            </div>
                            <div class="col-md-9 col-sm-12 right description">
                                <?php echo $product->minimum_Prior_notice; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (!empty($product->pet_age)) : ?>
                    <?php if ($product->pet_age == "others") : ?>
                        <div class="row row-product-details">
                            <div class="col-md-3 col-sm-12">
                                <label class="control-label"> Pet Age</label>
                            </div>
                            <div class="col-md-9 col-sm-12 right description">
                                <?php echo $product->other_pet_age; ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="row row-product-details">
                            <div class="col-md-3 col-sm-12">
                                <label class="control-label"> Pet Age</label>
                            </div>
                            <div class="col-md-9 col-sm-12 right description">
                                <?php echo $product->pet_age; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (!empty($product->storage_instruction)) : ?>
                    <?php if ($product->storage_instruction == "others") : ?>
                        <div class="row row-product-details">
                            <div class="col-md-3 col-sm-12">
                                <label class="control-label"> Storage Instruction</label>
                            </div>
                            <div class="col-md-9 col-sm-12 right description">
                                <?php echo $product->other_storage_instruction; ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="row row-product-details">
                            <div class="col-md-3 col-sm-12">
                                <label class="control-label">Storage Instruction</label>
                            </div>
                            <div class="col-md-9 col-sm-12 right description">
                                <?php echo $product->storage_instruction; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (!empty($product->weight)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Weight</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->weight . " " . $product->weight_units; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->product_weight)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Product Weight</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->product_weight . " " . $product->weight_units; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->cod_accepted)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">COD Accepted</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->cod_accepted; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->packed_product_height)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Height (After Packaging)</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->packed_product_height . " cm"; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->packed_product_length)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Length (After Packaging)</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->packed_product_length . " cm"; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product->packed_product_width)) : ?>
                    <div class="row row-product-details">
                        <div class="col-md-3 col-sm-12">
                            <label class="control-label">Width (After Packaging)</label>
                        </div>
                        <div class="col-md-9 col-sm-12 right description">
                            <?php echo $product->packed_product_width . " cm"; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <h2>Product Pickup Locations</h2>
                <div>
                    <h3>Pickup Locations 1</h3>
                    <?php if (!empty($product->product_address)) : ?>
                        <div class="row row-product-details">
                            <div class="col-md-3 col-sm-12">
                                <label class="control-label">Address</label>
                            </div>
                            <div class="col-md-9 col-sm-12 right description">
                                <?php echo $product->product_address; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($product->product_area)) : ?>
                        <div class="row row-product-details">
                            <div class="col-md-3 col-sm-12">
                                <label class="control-label">Area</label>
                            </div>
                            <div class="col-md-9 col-sm-12 right description">
                                <?php echo $product->product_area; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($product->product_city)) : ?>
                        <div class="row row-product-details">
                            <div class="col-md-3 col-sm-12">
                                <label class="control-label">City</label>
                            </div>
                            <div class="col-md-9 col-sm-12 right description">
                                <?php echo $product->product_city; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($product->product_state)) : ?>
                        <div class="row row-product-details">
                            <div class="col-md-3 col-sm-12">
                                <label class="control-label">State</label>
                            </div>
                            <div class="col-md-9 col-sm-12 right description">
                                <?php echo $product->product_state; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($product->product_pincode)) : ?>
                        <div class="row row-product-details">
                            <div class="col-md-3 col-sm-12">
                                <label class="control-label">Pincode</label>
                            </div>
                            <div class="col-md-9 col-sm-12 right description">
                                <?php echo $product->product_pincode; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($product->landmark)) : ?>
                        <div class="row row-product-details">
                            <div class="col-md-3 col-sm-12">
                                <label class="control-label">Landmark</label>
                            </div>
                            <div class="col-md-9 col-sm-12 right description">
                                <?php echo $product->landmark; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($product->product_pincode_1)) : ?>
                    <div>
                        <h3>Pickup Locations 2</h3>
                        <?php if (!empty($product->product_address_1)) : ?>
                            <div class="row row-product-details">
                                <div class="col-md-3 col-sm-12">
                                    <label class="control-label">Address</label>
                                </div>
                                <div class="col-md-9 col-sm-12 right description">
                                    <?php echo $product->product_address_1; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($product->product_area_1)) : ?>
                            <div class="row row-product-details">
                                <div class="col-md-3 col-sm-12">
                                    <label class="control-label">Area</label>
                                </div>
                                <div class="col-md-9 col-sm-12 right description">
                                    <?php echo $product->product_area_1; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($product->product_city_1)) : ?>
                            <div class="row row-product-details">
                                <div class="col-md-3 col-sm-12">
                                    <label class="control-label">City</label>
                                </div>
                                <div class="col-md-9 col-sm-12 right description">
                                    <?php echo $product->product_city_1; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($product->product_state_1)) : ?>
                            <div class="row row-product-details">
                                <div class="col-md-3 col-sm-12">
                                    <label class="control-label">State</label>
                                </div>
                                <div class="col-md-9 col-sm-12 right description">
                                    <?php echo $product->product_state_1; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($product->product_pincode_1)) : ?>
                            <div class="row row-product-details">
                                <div class="col-md-3 col-sm-12">
                                    <label class="control-label">Pincode</label>
                                </div>
                                <div class="col-md-9 col-sm-12 right description">
                                    <?php echo $product->product_pincode_1; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($product->landmark_1)) : ?>
                            <div class="row row-product-details">
                                <div class="col-md-3 col-sm-12">
                                    <label class="control-label">Landmark</label>
                                </div>
                                <div class="col-md-9 col-sm-12 right description">
                                    <?php echo $product->landmark_1; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <!-- form start -->

                <?php echo form_open('product_controller/approve_product'); ?>
                <input type="hidden" name="id" value="<?php echo $product->id; ?>">
                <input type="hidden" name="redirect_url" value="<?php echo $this->agent->referrer(); ?>">

                <?php if ($product->status != 1) : ?>
                    <button type="submit" name="option" value="approve" class="btn btn-primary pull-right"><?php echo trans('approve'); ?></button>
                <?php endif; ?>
                <a href="<?php echo generate_dash_url("edit_product"); ?>/<?php echo $product->id; ?>" target="_blank" class="btn btn-info pull-right m-r-5"><?php echo trans('edit'); ?></a>
                <a href="<?php echo $this->agent->referrer(); ?>" class="btn btn-danger pull-right m-r-5"><?php echo trans('back'); ?></a>
                <?php echo form_close(); ?>
                <?php echo form_open('product_controller/revert_back'); ?>
                <input type="hidden" name="id1" value="<?php echo $product->user_id; ?>">

                <button class="btn btn-secondary pull-right" type="button" data-toggle="modal" data-target="#contact-modal">
                    <i class="fa fa-check option-icon"></i>Revert
                </button>

                <div id="contact-modal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                                <h3>Revert back</h3>
                            </div>
                            <form id="contactForm" name="contact" role="form">
                                <div class="modal-body">
                                    <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" readonly name="email" value="<?php echo get_user($product->user_id)->email; ?>" class="form-control">
                                    </div>


                                    </br>Dear seller,<br><br>

                                    You are receiving this mail because Gharobaar team found an issue with your product listing.
                                    <br>
                                    Kindly review the comments and take appropriate actions and resubmit the listing.
                                    <br>
                                    The listed issue details are as follows -<br>
                                    --------------------------------------------
                                    <br>
                                    <!-- 1. The listed issue comment 1.
                                    2. The listed issue comment 2. -->

                                    <div class="form-group">
                                        <label for="message">Message</label>
                                        <textarea name="messagere" class="form-control form-textarea"></textarea>
                                    </div>
                                    --------------------------------------------

                                    <!-- <Product Detail> (As a url link and on click, it's should take the Supplier to product detail page) -->
                                    <br>
                                    Thanks & kind regards
                                    <br>
                                    Gharobaar Admin
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Send Email</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php form_close(); ?>
                <!-- form end -->
            </div>
            <!-- /.box-footer -->

        </div>
        <!-- /.box -->
    </div>
</div>

<div class="modal fade" id="viewVariationOptionsModal" style="background: transparent;" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog-centered " role="document">
        <div class="modal-content" style="width: 80%;">
            <div id="response_product_variation_options_edit"></div>
        </div>
    </div>
</div>

<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById("myImg");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    img.onclick = function() {
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
    }

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
</script>