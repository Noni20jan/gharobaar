<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    @media(max-width:768px) {

        .share-icons {
            text-align: center;
            border-top: 0.5px solid #B9B9B9;
            border-bottom: 0.5px solid #B9B9B9;
            padding: 10px 0px;
        }
    }

    .share-icons {
        text-align: center;
        border-top: 0.5px solid #B9B9B9;
        border-bottom: 0.5px solid #B9B9B9;
        padding: 10px 0px;
    }
</style>

<div class="share-icons">

    <a href="javascript:void(0)" onclick='window.open("https://www.facebook.com/sharer/sharer.php?u=<?php echo generate_product_url($product); ?>", "Share This Post", "width=640,height=450");return false'>
        <i class="icon-facebook" style="color:#000; font-size: 25px; padding:0px 20px;"></i>
    </a>

    <a href="javascript:void(0)" onclick='window.open("https://twitter.com/share?url=<?php echo generate_product_url($product); ?>&amp;text=<?php echo get_product_title($product); ?>", "Share This Post", "width=640,height=450");return false'>
        <i class="icon-twitter" style="color:#000; font-size: 25px; padding:0px 20px;"></i>
    </a>

    <a href="https://api.whatsapp.com/send?text=<?php echo str_replace("&", "", get_product_title($product)); ?> - <?php echo generate_product_url($product); ?>" target="_blank">
        <i class="icon-whatsapp" style="color:#000; font-size: 25px; padding:0px 20px;"></i>
    </a>

    <a href="javascript:void(0)" onclick='window.open("http://pinterest.com/pin/create/button/?url=<?php echo generate_product_url($product); ?>&amp;media=<?php echo get_product_image($product->id, 'image_default'); ?>", "Share This Post", "width=640,height=450");return false'>
        <i class="icon-pinterest" style="color:#000; font-size: 25px; padding:0px 20px;"></i>
    </a>

    <!-- <a href="javascript:void(0)" onclick='window.open("http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo generate_product_url($product); ?>", "Share This Post", "width=640,height=450");return false'>
        <i class="icon-linkedin" style="color:#007bb5; font-size: 25px;"></i>
    </a> -->
    <a></a>

</div>