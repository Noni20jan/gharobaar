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

    #heart-icon-1-2 {
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

    .plyr--video {
        max-height: 355px;
    }

    .img-zoom-container {
        position: relative;

    }

    .img-zoom-lens {
        /* border: 1px solid #800000; */

        position: absolute;
        /* background-color: #800000; */
        /*set the size of the lens:*/
        padding: 10px;

        z-index: 500;
        zoom: 3%;
        width: 175px;
        height: 175px;
    }

    .img-zoom-result {
        bottom: 5px;
        border: 1px solid #d4d4d4;
        /* position: absolute; */
        position: fixed;
        left: 55%;
        /*set the size of the result div:*/
        cursor: move;
        /* z-index: 10; */
        width: 600px;
        height: 600px;
        display: none;
        z-index: 500;

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
                    <?php if (item_count($product_images) > 4) : ?>
                        <div id="product-thumbnails-slider-nav" class="product-thumbnails-slider-nav">
                            <button style="display: block; color:black; margin: 4px 2px;  background-color: #fff;border-radius: 50%;margin-left: 47px;" class="prev"><i class="icon-arrow-up"></i></button>
                            <button style="display: block; color:black; margin: 4px 2px;  background-color: #fff;border-radius: 50%;margin-left: 47px;" class=" next"><i class="icon-arrow-down"></i></button>
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
                            <div class="item img-zoom-container">
                                <a href="<?php echo get_product_image_url($image, 'image_big'); ?>" title="">
                                    <img src="<?php echo base_url() . IMG_BG_PRODUCT_SLIDER; ?>" class="img-bg" alt="slider-bg" style="border-radius:20px; ">
                                    <img src="<?php echo get_product_image_url($image, 'image_big'); ?>" style="border-radius:20px; cursor: zoom-in;" id="image_<?php echo ($image->id) ?>" value="<?php echo get_product_image_url($image, 'image_big'); ?>" alt="<?php echo $product->slug; ?>" onmouseover="imageZoom('<?php echo ($image->id) ?>', 'myresult')" onmouseout="zoom('<?php echo ($image->id) ?>', 'myresult')" class="img-product-slider">

                                </a>
                            </div>


                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="item">
                            <a href="javascript:void(0)" title="">
                                <img src="<?php echo base_url() . IMG_BG_PRODUCT_SLIDER; ?>" class="img-bg" alt="slider-bg" style="border-radius:20px;">
                                <img src="<?php echo IMG_BASE64_1x1; ?>" data-lazy="<?php echo base_url() . 'assets/img/no-image.jpg'; ?>" style="border-radius:20px;" alt="<?php echo get_product_title($product); ?>" class="img-product-slider">

                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="product-item-options" style="margin-right:11%">
                    <?php if ($this->auth_check) : ?>
                        <?php if ($this->auth_user->user_type != "guest") : ?>
                            <a href="javascript:void(0)" class="item-option btn-add-remove-wishlist" id="heart-icon-1" data-toggle="tooltip" data-placement="left" data-product-id="<?php echo $product->id; ?>" data-reload="0" title="<?php echo trans("wishlist"); ?>">
                                <?php if (is_product_in_wishlist($product) == 1) : ?>
                                    <i class="icon-heart"></i>
                                <?php else : ?>
                                    <i class="icon-heart-o"></i>
                                <?php endif; ?>
                            </a>
                        <?php else : ?>
                            <!-- hide wishlist for guest user -->
                            <!-- <li class="icon-bg">
                                                    <a href="<?php echo generate_url("wishlist") . "/" . $this->auth_user->slug; ?>">
                                                        <i class="icon-heart-o"></i>
                                                    </a>
                                                </li> -->
                        <?php endif; ?>
                    <?php else : ?>
                        <a href="javascript:void(0)" class="item-option btn-add-remove-wishlist" id="heart-icon-1-2" data-toggle="tooltip" data-placement="left" data-product-id="<?php echo $product->id; ?>" data-reload="0" title="<?php echo trans("wishlist"); ?>"><i class="icon-heart-o"></i></a>
                    <?php endif; ?>
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

<div id="myresult" class="img-zoom-result"></div>

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

<?php if (item_count($product_images) > 10) : ?>
    <style>
        .product-thumbnails-slider .slick-track {
            transform: none !important;
            display: block;
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

<script>
    $("#heart-icon-1-2").click(function() {
        $(this).find('i').toggleClass('icon-heart-o')
        $('#loginModal').modal('show');
        // alert("ok");
    })
</script>
<script>
    function imageZoom(imgID, resultID) {
        var resultID = "myresult";
        var img, lens, result, cx, cy;
        img = document.getElementById("image_" + imgID);
        result = document.getElementById("myresult");
        result.style.display = "block";
        /*create lens:*/
        lens = document.createElement("DIV");
        lens.setAttribute("class", "img-zoom-lens");
        /*insert lens:*/
        img.parentElement.insertBefore(lens, img);
        /*calculate the ratio between result DIV and lens:*/
        // console.log(result.offsetWidth);
        // console.log(lens.offsetWidth);
        // console.log(result.offsetHeight);
        // console.log(lens.offsetHeight);
        cx = result.offsetWidth / lens.offsetWidth;
        cy = result.offsetHeight / lens.offsetHeight;
        // console.log(cx);
        // console.log(cy);
        // console.log(img.width);
        // console.log(img.height)
        /*set background properties for the result DIV:*/
        result.style.backgroundImage = "url('" + img.src + "')";
        console.log(result.style.backgroundImage);
        result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
        /*execute a function when someone moves the cursor over the image, or the lens:*/
        console.log(result.style.backgroundSize);
        lens.addEventListener("mousemove", moveLens);
        img.addEventListener("mousemove", moveLens);
        /*and also for touch screens:*/
        lens.addEventListener("touchmove", moveLens);
        img.addEventListener("touchmove", moveLens);

        function moveLens(e) {
            var pos, x, y;
            /* Prevent any other actions that may occur when moving over the image */
            e.preventDefault();
            /* Get the cursor's x and y positions: */
            pos = getCursorPos(e);
            /* Calculate the position of the lens: */
            x = pos.x - (lens.offsetWidth / 2);
            y = pos.y - (lens.offsetHeight / 2);
            /* Prevent the lens from being positioned outside the image: */
            if (x > img.width - lens.offsetWidth) {
                x = img.width - lens.offsetWidth;
            }
            if (x < 0) {
                x = 0;
            }
            if (y > img.height - lens.offsetHeight) {
                y = img.height - lens.offsetHeight;
            }
            if (y < 0) {
                y = 0;
            }
            /* Set the position of the lens: */
            lens.style.left = x + "px";
            lens.style.top = y + "px";
            /* Display what the lens "sees": */
            result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
        }

        function getCursorPos(e) {
            var a, x = 0,
                y = 0;
            e = e || window.event;
            /*get the x and y positions of the image:*/
            a = img.getBoundingClientRect();
            /*calculate the cursor's x and y coordinates, relative to the image:*/
            x = e.pageX - a.left;
            y = e.pageY - a.top;
            /*consider any page scrolling:*/
            x = x - window.pageXOffset;
            y = y - window.pageYOffset;
            return {
                x: x,
                y: y
            };
        }
    }

    function zoom(imgID, resultID) {
        result = document.getElementById("myresult");
        result.style.display = "none";
    }
</script>