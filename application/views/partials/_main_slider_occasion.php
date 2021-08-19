<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .image-container {
        border-radius: 35px;
    }

    .height-css-new {
        height: 100% !important;
        margin-top: 1%;
        margin-bottom: 1%;
    }

    @media (max-width: 480px) {
        .index-mobile-slider .slider-container {
            height: auto !important;
        }
    }

    @media (max-width: 480px) {
        .index-mobile-slider .item {
            height: auto !important;
        }
    }

    .height-css-mobile-new {
        margin-top: 2%;
        margin-bottom: 5%;
        margin-left: 3%;
        margin-right: 3%;
    }

    .occasion_btn_text_1 {
        font-size: 20px !important;
        font-weight: 900 !important;
    }

    .occasion_btn {
        width: 345px !important;
        height: 50px !important;
        border-radius: 28px !important;
    }
</style>
<div class="index-main-slider <?php echo ($this->general_settings->slider_type == "boxed") ? "container container-boxed-slider" : "container-fluid"; ?>">
    <div class="row">
        <div class="slider-container height-auto" <?= $this->rtl == true ? 'dir="rtl"' : ''; ?>>
            <div id="main-slider-new" class="main-slider height-auto">
                <?php if (!empty($occassion_slider_items)) :
                    foreach ($occassion_slider_items as $item) :
                        if ($item->category_feature == "SHOP_BY_OCCASSION") : ?>
                            <div class="item lazyload height-auto" data-bg="<?php echo base_url() . $item->image; ?>" data-bg-mobile="<?php echo base_url() . $item->image_mobile; ?>">
                                <a href="<?php echo html_escape($item->link); ?>">
                                    <?php if (($item->item_order % 2) != 0) : ?>
                                        <div class="container" style="text-align:center;">
                                            <div class="row row-slider-caption align-items-center height-auto">
                                                <div class="col-1"></div>
                                                <div class="col-6 height-css-new text-center">
                                                    <div style="text-align:center;">
                                                        <?php if (!empty($item->title)) : ?>
                                                            <?php $label_date = explode("+", $item->title); ?>
                                                            <h2 class="title" data-animation="<?php echo $item->animation_title; ?>" data-delay="0.1s" style="color: <?php echo $item->text_color; ?>"><?php echo html_escape($label_date[0]); ?></h2>
                                                            <?php
                                                            if (strpos($item->title, '+') !== false) : ?>
                                                                <h4 data-animation="<?php echo $item->animation_title; ?>" data-delay="0.1s" style="color: <?php echo $item->text_color; ?>"><?php echo $label_date[1]; ?></h4><br>
                                                            <?php endif; ?>
                                                        <?php endif;
                                                        if (!empty($item->description)) : ?>
                                                            <p class="description" data-animation="<?php echo $item->animation_description; ?>" data-delay="0.5s" style="color: <?php echo $item->text_color; ?>;white-space: pre-wrap;"><?php echo html_escape($item->description); ?></p><br>
                                                        <?php endif;
                                                        if (!empty($item->button_text)) : ?>
                                                            <button class="occasion_btn_text_1 occasion_btn btn btn-slider" data-animation="<?php echo $item->animation_button; ?>" data-delay="0.9s" style="animation-delay: 0.9s;background-color: #DF911E;border-color: #DF911E;border-radius: 20px;"><?php echo html_escape($item->button_text); ?></button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-4 height-css-new">
                                                    <div style="text-align:center;">
                                                        <?php if (!empty($item->slider_image)) : ?>
                                                            <img src="<?php echo base_url() . $item->slider_image ?>" alt="Avatar" class="image-fit image-container">
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-1"></div>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="container" style="text-align:center;">
                                            <div class="row row-slider-caption align-items-center height-auto">
                                                <div class="col-1"></div>
                                                <div class="col-4 height-css-new">
                                                    <div style="text-align:center;">
                                                        <?php if (!empty($item->slider_image)) : ?>
                                                            <img src="<?php echo base_url() . $item->slider_image ?>" alt="Avatar" class="image-fit image-container">
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-6 height-css-new text-center">
                                                    <div style="text-align:center;">
                                                        <?php if (!empty($item->title)) : ?>
                                                            <?php $label_date = explode("+", $item->title); ?>
                                                            <h2 class="title" data-animation="<?php echo $item->animation_title; ?>" data-delay="0.1s" style="color: <?php echo $item->text_color; ?>"><?php echo html_escape($label_date[0]); ?></h2>
                                                            <?php
                                                            // var_dump($label_date[1]);
                                                            if (strpos($item->title, '+') !== false) : ?>
                                                                <h4 data-animation="<?php echo $item->animation_title; ?>" data-delay="0.1s" style="color: <?php echo $item->text_color; ?>"><?php echo $label_date[1]; ?></h4><br>
                                                            <?php endif; ?>
                                                        <?php endif;
                                                        if (!empty($item->description)) : ?>
                                                            <p class="description" data-animation="<?php echo $item->animation_description; ?>" data-delay="0.5s" style="color: <?php echo $item->text_color; ?>;white-space: pre-wrap;"><?php echo html_escape($item->description); ?></p><br>
                                                        <?php endif;
                                                        if (!empty($item->button_text)) : ?>
                                                            <button class="occasion_btn_text_1 occasion_btn btn btn-slider" data-animation="<?php echo $item->animation_button; ?>" data-delay="0.9s" style="animation-delay: 0.9s;background-color: #DF911E;border-color: #DF911E;border-radius: 20px;"><?php echo html_escape($item->button_text); ?></button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-1"></div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </a>
                            </div>
                <?php endif;
                    endforeach;
                endif; ?>
            </div>
            <div id="main-slider-nav-new" class="main-slider-nav">
                <button class="prev"><i class="icon-arrow-left"></i></button>
                <button class="next"><i class="icon-arrow-right"></i></button>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid index-mobile-slider height-auto">
    <div class="row">
        <div class="slider-container height-auto" <?= $this->rtl == true ? 'dir="rtl"' : ''; ?>>
            <div id="main-mobile-slider-new" class="main-slider height-auto">
                <?php if (!empty($occassion_slider_items)) :
                    foreach ($occassion_slider_items as $item) :
                        if ($item->category_feature == "SHOP_BY_OCCASSION") :
                            $image = $item->image_mobile;
                            if (empty($image)) {
                                $image = $item->image;
                            } ?>
                            <div class="item lazyload" data-bg="<?php echo base_url() . $image; ?>">
                                <a href="<?php echo html_escape($item->link); ?>">
                                    <div class="container height-auto" style="text-align:center;">
                                        <div class="row height-auto">
                                            <!-- <div class="col-1"></div> -->
                                            <!-- <div class="col-4 height-css-mobile"> -->
                                            <div class="text-center height-css-mobile-new">
                                                <?php if (!empty($item->slider_image)) : ?>
                                                    <img src="<?php echo base_url() . $item->slider_image ?>" alt="Avatar" class="image-fit image-container">
                                                <?php endif; ?>
                                            </div>
                                            <!-- </div> -->
                                        </div>
                                        <div class="row height-auto">
                                            <div class="height-css-mobile-new text-center">
                                                <!-- <div style="text-align:center;"> -->
                                                <?php if (!empty($item->title)) : ?>
                                                    <?php $label_date = explode("+", $item->title); ?>
                                                    <h2 class="title" data-animation="<?php echo $item->animation_title; ?>" data-delay="0.1s" style="color: <?php echo $item->text_color; ?>"><?php echo html_escape($label_date[0]); ?></h2><br>
                                                    <?php
                                                    if (strpos($item->title, '+') !== false) : ?>
                                                        <h4 style="color: <?php echo $item->text_color; ?>"><?php echo $label_date[1]; ?></h4><br>
                                                    <?php endif; ?>
                                                <?php endif;
                                                if (!empty($item->description)) : ?>
                                                    <p class="description" data-animation="<?php echo $item->animation_description; ?>" data-delay="0.5s" style="color: <?php echo $item->text_color; ?>;white-space: pre-wrap;"><?php echo html_escape($item->description); ?></p>
                                                <?php endif;
                                                if (!empty($item->button_text)) : ?>
                                                    <button class="btn btn-slider" data-animation="<?php echo $item->animation_button; ?>" data-delay="0.9s" style="animation-delay: 0.9s;background-color: #DF911E;border-color: #DF911E;border-radius: 20px;"><?php echo html_escape($item->button_text); ?></button>
                                                <?php endif; ?>
                                                <!-- </div> -->
                                            </div>
                                            <!-- <div class="col-2"></div> -->
                                        </div>
                                    </div>
                                </a>
                            </div>
                <?php endif;
                    endforeach;
                endif; ?>
            </div>
            <div id="main-mobile-slider-nav-new" class="main-slider-nav">
                <button class="prev"><i class="icon-arrow-left"></i></button>
                <button class="next"><i class="icon-arrow-right"></i></button>
            </div>
        </div>
    </div>
</div>