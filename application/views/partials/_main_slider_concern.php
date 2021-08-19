<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .height-css {
        height: 100% !important;
        margin-top: 1%;
        margin-bottom: 1%;
    }

    .height-css-mobile {
        margin-top: 2%;
        margin-bottom: 5%;
        margin-left: 3%;
        margin-right: 3%;
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

    .height-auto {
        height: auto !important;
    }

    .concern_btn_text_1 {
        font-size: 20px !important;
        font-weight: 900 !important;
    }

    .concern_btn {
        width: 330px !important;
        height: 50px !important;
        border-radius: 28px !important;
    }
</style>
<div class="index-main-slider <?php echo ($this->general_settings->slider_type == "boxed") ? "container container-boxed-slider" : "container-fluid"; ?>">
    <div class="row">
        <div class="slider-container height-auto" <?= $this->rtl == true ? 'dir="rtl"' : ''; ?>>
            <div id="main-slider" class="main-slider height-auto">
                <?php if (!empty($concern_slider_items)) :
                    foreach ($concern_slider_items as $item) :
                        if ($item->category_feature == "SHOP_BY_CONCERN") : ?>
                            <div class="item lazyload height-auto" data-bg="<?php echo base_url() . $item->image; ?>" data-bg-mobile="<?php echo base_url() . $item->image_mobile; ?>">
                                <a href="<?php echo html_escape($item->link); ?>">
                                    <?php if (($item->item_order % 2) != 0) : ?>
                                        <div class="container" style="text-align:center;">
                                            <div class="row row-slider-caption align-items-center height-auto">
                                                <div class="col-1"></div>
                                                <div class="col-6 height-css text-center">
                                                    <div style="text-align:center;">
                                                        <?php if (!empty($item->title)) : ?>
                                                            <h2 class="title" data-animation="<?php echo $item->animation_title; ?>" data-delay="0.1s" style="color: <?php echo $item->text_color; ?>"><?php echo html_escape($item->title); ?></h2><br>
                                                        <?php endif;
                                                        if (!empty($item->description)) : ?>
                                                            <!-- <button class="btn btn-slider" data-animation="<?php echo $item->animation_button; ?>" data-delay="0.9s" style="animation-delay: 0.9s;background-color: #DF911E;border-color: #DF911E;border-radius: 20px;"><?php echo html_escape($item->button_text); ?></button> -->
                                                            <p class="description" data-animation="<?php echo $item->animation_description; ?>" data-delay="0.5s" style="color: <?php echo $item->text_color; ?>;white-space: pre-wrap;"><?php echo html_escape($item->description); ?></p><br>
                                                        <?php endif;
                                                        if (!empty($item->button_text)) : ?>
                                                            <button class="concern_btn_text_1 concern_btn btn btn-slider" data-animation="<?php echo $item->animation_button; ?>" data-delay="0.9s" style="animation-delay: 0.9s;background-color: #DF911E;border-color: #DF911E;border-radius: 20px;"><?php echo html_escape($item->button_text); ?></button>
                                                            <!-- <button class="btn btn-slider" data-animation="<?php echo $item->animation_button; ?>" data-delay="0.9s" style="background-color: <?php echo $item->button_color; ?>;border-color: <?php echo $item->button_color; ?>;color: <?php echo $item->button_text_color; ?>"><?php echo html_escape($item->button_text); ?></button> -->
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-4 height-css">
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
                                                <div class="col-4 height-css">
                                                    <div style="text-align:center;">
                                                        <?php if (!empty($item->slider_image)) : ?>
                                                            <img src="<?php echo base_url() . $item->slider_image ?>" alt="Avatar" class="image-fit image-container">
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-6 height-css text-center">
                                                    <div style="text-align:center;">
                                                        <?php if (!empty($item->title)) : ?>
                                                            <h2 class="title" data-animation="<?php echo $item->animation_title; ?>" data-delay="0.1s" style="color: <?php echo $item->text_color; ?>"><?php echo html_escape($item->title); ?></h2><br>
                                                        <?php endif;
                                                        if (!empty($item->description)) : ?>
                                                            <!-- <button class="btn btn-slider" data-animation="<?php echo $item->animation_button; ?>" data-delay="0.9s" style="animation-delay: 0.9s;background-color: #DF911E;border-color: #DF911E;border-radius: 20px;"><?php echo html_escape($item->button_text); ?></button> -->
                                                            <p class="description" data-animation="<?php echo $item->animation_description; ?>" data-delay="0.5s" style="color: <?php echo $item->text_color; ?>;white-space: pre-wrap;"><?php echo html_escape($item->description); ?></p><br>
                                                        <?php endif;
                                                        if (!empty($item->button_text)) : ?>
                                                            <button class="concern_btn_text_1 concern_btn btn btn-slider" data-animation="<?php echo $item->animation_button; ?>" data-delay="0.9s" style="animation-delay: 0.9s;background-color: #DF911E;border-color: #DF911E;border-radius: 20px;"><?php echo html_escape($item->button_text); ?></button>
                                                            <!-- <button class="btn btn-slider" data-animation="<?php echo $item->animation_button; ?>" data-delay="0.9s" style="background-color: <?php echo $item->button_color; ?>;border-color: <?php echo $item->button_color; ?>;color: <?php echo $item->button_text_color; ?>"><?php echo html_escape($item->button_text); ?></button> -->
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
            <div id="main-slider-nav" class="main-slider-nav">
                <button class="prev"><i class="icon-arrow-left"></i></button>
                <button class="next"><i class="icon-arrow-right"></i></button>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid index-mobile-slider height-auto">
    <div class="row">
        <div class="slider-container height-auto" <?= $this->rtl == true ? 'dir="rtl"' : ''; ?>>
            <div id="main-mobile-slider" class="main-slider height-auto">
                <?php if (!empty($concern_slider_items)) :
                    foreach ($concern_slider_items as $item) :
                        if ($item->category_feature == "SHOP_BY_CONCERN") :
                            $image = $item->image_mobile;
                            if (empty($image)) {
                                $image = $item->image;
                            } ?>
                            <div class="item lazyload height-auto" data-bg="<?php echo base_url() . $image; ?>">
                                <a href="<?php echo html_escape($item->link); ?>">
                                    <?php if (($item->item_order % 2) != 0) : ?>
                                        <div class="container height-auto" style="text-align:center;">
                                            <div class="row height-auto">
                                                <div class="height-css-mobile text-center">
                                                    <!-- <div style="text-align:center;"> -->
                                                    <?php if (!empty($item->title)) : ?>
                                                        <h2 class="title" data-animation="<?php echo $item->animation_title; ?>" data-delay="0.1s" style="color: <?php echo $item->text_color; ?>; max-width: 98%;"><?php echo html_escape($item->title); ?></h2>
                                                    <?php endif;
                                                    if (!empty($item->description)) : ?>
                                                        <p class="description" data-animation="<?php echo $item->animation_description; ?>" data-delay="0.5s" style="color: <?php echo $item->text_color; ?>; max-width: 96%;"><?php echo html_escape($item->description); ?></p>
                                                    <?php endif;
                                                    if (!empty($item->button_text)) : ?>
                                                        <button class="concern_btn_text_1 concern_btn btn btn-slider" data-animation="<?php echo $item->animation_button; ?>" data-delay="0.9s" style="background-color: <?php echo $item->button_color; ?>; max-width: 69%; border-color: <?php echo $item->button_color; ?>;color: <?php echo $item->button_text_color; ?>; "><?php echo html_escape($item->button_text); ?></button>
                                                    <?php endif; ?>
                                                    <!-- </div> -->
                                                </div>
                                                <!-- <div class="col-2"></div> -->
                                            </div>
                                            <div class="row height-auto">
                                                <!-- <div class="col-1"></div> -->
                                                <!-- <div class="col-4 height-css-mobile"> -->
                                                <div class="text-center height-css-mobile">
                                                    <?php if (!empty($item->slider_image)) : ?>
                                                        <img src="<?php echo base_url() . $item->slider_image ?>" alt="Avatar" class="image-fit image-container">
                                                    <?php endif; ?>
                                                </div>
                                                <!-- </div> -->
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="container height-auto" style="text-align:center;">
                                            <div class="row height-auto">
                                                <!-- <div class="col-1"></div> -->
                                                <!-- <div class="col-4 height-css-mobile"> -->
                                                <div class="text-center height-css-mobile">
                                                    <?php if (!empty($item->slider_image)) : ?>
                                                        <img src="<?php echo base_url() . $item->slider_image ?>" alt="Avatar" class="image-fit image-container">
                                                    <?php endif; ?>
                                                </div>
                                                <!-- </div> -->
                                            </div>
                                            <div class="row height-auto">
                                                <div class="height-css-mobile text-center">
                                                    <!-- <div style="text-align:center;"> -->
                                                    <?php if (!empty($item->title)) : ?>
                                                        <h2 class="title" data-animation="<?php echo $item->animation_title; ?>" data-delay="0.1s" style="color: <?php echo $item->text_color; ?>; max-width: 98%;"><?php echo html_escape($item->title); ?></h2>
                                                    <?php endif;
                                                    if (!empty($item->description)) : ?>
                                                        <p class="description" data-animation="<?php echo $item->animation_description; ?>" data-delay="0.5s" style="color: <?php echo $item->text_color; ?>; max-width: 96%;"><?php echo html_escape($item->description); ?></p>
                                                    <?php endif;
                                                    if (!empty($item->button_text)) : ?>
                                                        <button class="concern_btn_text_1 concern_btn btn btn-slider" data-animation="<?php echo $item->animation_button; ?>" data-delay="0.9s" style="background-color: <?php echo $item->button_color; ?>; max-width: 69%; border-color: <?php echo $item->button_color; ?>;color: <?php echo $item->button_text_color; ?>; "><?php echo html_escape($item->button_text); ?></button>
                                                    <?php endif; ?>
                                                    <!-- </div> -->
                                                </div>
                                                <!-- <div class="col-2"></div> -->
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </a>
                            </div>
                <?php endif;
                    endforeach;
                endif; ?>
            </div>
            <div id="main-mobile-slider-nav" class="main-slider-nav">
                <button class="prev"><i class="icon-arrow-left"></i></button>
                <button class="next"><i class="icon-arrow-right"></i></button>
            </div>
        </div>
    </div>
</div>