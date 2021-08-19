<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php $image_count = 0;
if (!empty($product_images)) {
    $image_count = item_count($product_images);
} ?>
<style>
    .expanded-view {
        margin-left: 46%;
        /* margin-right: 10%; */
    }

    #heart-icon-1 {
        opacity: 1;
        bottom: 203px;
        left: -10px;
    }

    @media (max-width:768px) {
        .expanded-view {
            margin-left: 25%;
        }
    }

    @media (max-width: 768px) {
        #heart-icon-1 {
            opacity: 1;
            bottom: 203px;
            left: 45px;
        }
    }

    .expanded-view-no-live-preview {
        margin-left: 43%;
    }

    @media (max-width:768px) {
        .expanded-view-no-live-preview {
            margin-left: 27%;
        }
    }

    @media (min-width:568px) {
        .expanded-view-no-live-preview {
            margin-left: 19%;
        }
    }

    @media (max-width: 1024px) {
        .expanded-view-no-live-preview {
            margin-left: 30%;
        }
    }


    @media (max-width:667px) {
        .expanded-view-no-live-preview {
            margin-left: 24%;
        }
    }

    @media (min-width:1366px) {
        .expanded-view-no-live-preview {
            margin-left: 35%;
        }
    }

    /* width */
    .product-slider-content::-webkit-scrollbar {
        width: 4px;
    }

    .product-slider-content {
        scrollbar-color: #fff0 #fff0;
    }
</style>
<?php if ($image_count <= 1 && (!empty($video) || !empty($audio))) :
    if (!empty($video)) : ?>
        <div class="product-video-preview">
            <video id="player" playsinline controls>
                <source src="<?php echo get_product_video_url($video); ?>" type="video/mp4">
            </video>
        </div>
    <?php endif;
    if (!empty($audio)) :
        $this->load->view('product/details/_audio_player');
    endif; ?>
<?php else : ?>
    <div class="product-slider-container">
        <?php if (item_count($product_images) > 1) : ?>
            <div class="left">
                <div class="product-slider-content" style="width:130%; overflow-y:scroll;">
                    <div id="product_thumbnails_slider" class="product-thumbnails-slider">
                        <?php foreach ($product_images as $image) : ?>
                            <div class="item">
                                <div class="item-inner" style="border-radius:15px;">
                                    <img src="<?php echo IMG_BASE64_1x1; ?>" class="img-bg" alt="slider-bg">
                                    <img src="<?php echo IMG_BASE64_1x1; ?>" data-lazy="<?php echo get_product_image_url($image, 'image_small'); ?>" class="img-thumbnail" alt="<?php echo get_product_title($product); ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (item_count($product_images) > 7) : ?>
                        <div id="product-thumbnails-slider-nav" class="product-thumbnails-slider-nav">
                            <button class="prev"><i class="icon-arrow-up"></i></button>
                            <button class="next"><i class="icon-arrow-down"></i></button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="right">
            <div class="product-slider-content" style="margin-left: 15px;">
                <div id="product_slider" class="product-slider gallery">
                    <?php if (!empty($product_images)) :
                        foreach ($product_images as $image) : ?>
                            <div class="item">
                                <a href="<?php echo get_product_image_url($image, 'image_big'); ?>" title="">
                                    <img src="<?php echo base_url() . IMG_BG_PRODUCT_SLIDER; ?>" class="img-bg" alt="slider-bg" style="border-radius:20px;">
                                    <img src="<?php echo IMG_BASE64_1x1; ?>" style="border-radius:20px;" data-lazy="<?php echo get_product_image_url($image, 'image_default'); ?>" alt="<?php echo get_product_title($product); ?>" class="img-product-slider">
                                </a>
                            </div>
                        <?php endforeach;
                    else : ?>
                        <div class="item">
                            <a href="javascript:void(0)" title="">
                                <img src="<?php echo base_url() . IMG_BG_PRODUCT_SLIDER; ?>" class="img-bg" alt="slider-bg" style="border-radius:20px;">
                                <img src="<?php echo IMG_BASE64_1x1; ?>" data-lazy="<?php echo base_url() . 'assets/img/no-image.jpg'; ?>" style="border-radius:20px;" alt="<?php echo get_product_title($product); ?>" class="img-product-slider">
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="product-item-options" style="margin-right:11%">
                    <a href="javascript:void(0)" class="item-option btn-add-remove-wishlist" id="heart-icon-1" data-toggle="tooltip" data-placement="left" data-product-id="<?php echo $product->id; ?>" data-reload="0" title="<?php echo trans("wishlist"); ?>">
                        <?php if (is_product_in_wishlist($product) == 1) : ?>
                            <i class="icon-heart"></i>
                        <?php else : ?>
                            <i class="icon-heart-o"></i>
                        <?php endif; ?>
                    </a>
                </div>

                <?php if (item_count($product_images) > 1) : ?>
                    <div id="product-slider-nav" class="product-slider-nav">
                        <button class="prev"><i class="icon-arrow-left"></i></button>
                        <button class="next"><i class="icon-arrow-right"></i></button>
                    </div>
                <?php endif; ?>
            </div>

            <div class="row-custom text-center">
                <?php if (!empty($video)) : ?>
                    <button class="btn btn-lg btn-video-preview" data-toggle="modal" data-target="#productVideoModal"><i class="icon-play"></i><?php echo trans("video"); ?></button>
                <?php endif; ?>
                <?php if (!empty($audio)) : ?>
                    <button class="btn btn-lg btn-video-preview" data-toggle="modal" data-target="#productAudioModal"><i class="icon-music"></i><?php echo trans("audio"); ?></button>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- <?php if (!empty($product->demo_url)) : ?>
        <span class="expanded-view">Click to see expanded view</span>
    <?php else : ?>
        <span class="expanded-view-no-live-preview">Click to see expanded view</span>
    <?php endif; ?> -->
<?php endif; ?>
<!-- <?php if (!empty($product->demo_url)) : ?>

    <a href="<?php echo $product->demo_url; ?>" target="_blank" class="btn-live-preview"><i class="icon-preview"></i><?php echo trans("live_preview") ?></a>


<?php endif; ?> -->

<?php if ($image_count > 1 && !empty($video)) : ?>
    <div class="modal fade" id="productVideoModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-product-video" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                <div class="product-video-preview m-0">
                    <video id="player" playsinline controls>
                        <source src="<?php echo get_product_video_url($video); ?>" type="video/mp4">
                    </video>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($image_count > 1 && !empty($audio)) : ?>
    <div class="modal fade" id="productAudioModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-product-video" role="document">
            <div class="modal-content">
                <div class="row-custom" style="width: auto !important;">
                    <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                    <?php $this->load->view('product/details/_audio_player'); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".product-video-preview").css("opacity", "1");
        }, 300);
        setTimeout(function() {
            $(".product-audio-preview").css("opacity", "1");
        }, 300);
    });
</script>

<?php if (item_count($product_images) <= 7) : ?>
    <style>
        .product-thumbnails-slider .slick-track {
            transform: none !important;
        }
    </style>
<?php endif; ?>

<script>
    $('#productVideoModal').on('hidden.bs.modal', function(e) {
        $(this).find('video')[0].pause();
    });
    $('#productAudioModal').on('hidden.bs.modal', function(e) {
        Amplitude.pause();
    });
</script>