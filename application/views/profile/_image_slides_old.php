<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .card-carousel {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .card-carousel .my-card {
        height: 20rem;
        width: 12rem;
        position: relative;
        z-index: 1;
        -webkit-transform: scale(0.6) translateY(-2rem);
        transform: scale(0.6) translateY(-2rem);
        opacity: 0;
        cursor: pointer;
        pointer-events: none;
        background: #2e5266;
        background: linear-gradient(to top, #2e5266, #6e8898);
        transition: 1s;
    }

    .card-carousel .my-card:after {
        content: '';
        position: absolute;
        height: 2px;
        width: 100%;
        border-radius: 100%;
        background-color: rgba(0, 0, 0, 0.3);
        bottom: -5rem;
        -webkit-filter: blur(4px);
        filter: blur(4px);
    }

    .card-carousel .my-card.active {
        z-index: 3;
        -webkit-transform: scale(1) translateY(0) translateX(0);
        transform: scale(1) translateY(0) translateX(0);
        opacity: 1;
        pointer-events: auto;
        transition: 1s;
    }

    .card-carousel .my-card.prev,
    .card-carousel .my-card.next {
        z-index: 2;
        -webkit-transform: scale(0.8) translateY(-1rem) translateX(0);
        transform: scale(0.8) translateY(-1rem) translateX(0);
        opacity: 0.6;
        pointer-events: auto;
        transition: 1s;
    }

    .card-carousel .my-card:nth-child(0):before {
        content: '0';
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translateX(-50%) translateY(-50%);
        transform: translateX(-50%) translateY(-50%);
        font-size: 3rem;
        font-weight: 300;
        color: #fff;
    }

    .card-carousel .my-card:nth-child(1):before {
        content: '1';
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translateX(-50%) translateY(-50%);
        transform: translateX(-50%) translateY(-50%);
        font-size: 3rem;
        font-weight: 300;
        color: #fff;
    }

    .card-carousel .my-card:nth-child(2):before {
        content: '2';
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translateX(-50%) translateY(-50%);
        transform: translateX(-50%) translateY(-50%);
        font-size: 3rem;
        font-weight: 300;
        color: #fff;
    }

    .card-carousel .my-card:nth-child(3):before {
        content: '3';
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translateX(-50%) translateY(-50%);
        transform: translateX(-50%) translateY(-50%);
        font-size: 3rem;
        font-weight: 300;
        color: #fff;
    }

    .card-carousel .my-card:nth-child(4):before {
        content: '4';
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translateX(-50%) translateY(-50%);
        transform: translateX(-50%) translateY(-50%);
        font-size: 3rem;
        font-weight: 300;
        color: #fff;
    }

    .test {
        cursor: pointer;
        padding: 0 5px;
        display: inline-block;
        /* margin: 0 0 15px; */
        color: #aaa;
        transition: .2s;
        position: absolute;
        top: 85%;
        /* border: 1px red solid; */

    }

    i>span {
        color: red;
    }

    i:hover {
        color: #666;
    }

    .test:before {
        font-family: fontawesome;
        content: '\f004';
        font-style: normal;
    }

    i.press {
        animation: size .4s;
        color: red;
    }



    @keyframes fade {
        0% {
            color: transparent;
        }

        50% {
            color: black;
        }

        100% {
            color: transparent;
        }
    }

    @keyframes size {
        0% {
            padding: 0px 12px;
        }

        50% {
            padding: 0px 16px;
        }

        100% {
            padding: 0px 8px;
        }
    }

    .slick-arrow {
        color: black;
    }

    .items {
        width: 90%;
        margin: 0px auto;
        margin-top: 100px
    }

    .slick-slide {
        margin: 10px
    }

    .slick-slide img {
        width: 100%;
        max-height: 259px;
        border: 0px solid #fff
    }

    .image-heading {
        text-align: left;
        font-size: 24px;
        /*18px for mobile*/
        font-weight: 600;
    }
</style>

<?php $image_count = 0;
if (!empty($product_images)) {
    $image_count = item_count($product_images);
} ?>



<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/slick.min.js"></script>

<div class="image-heading">Seller's Gallery</div>
<?php if ($image_count >= 1) : ?>
    <div class="items">
        <div class="card-carousel">

            <?php foreach ($product_images as $image) : ?>

                <div class="my-card">
                    <div><img src="<?php echo get_story_image_url($image, 'image_default'); ?>" alt="<?php //echo get_product_title($product); 
                                                                                                        ?>" class="img-product-slider">
                        <div class="test2">
                            <?php if ($this->auth_check) : ?>
                                <?php if ($row = story_image_liked($image->id, $user->id)) : ?>
                                    <?php if ($row->liked) : ?>
                                        <i class="test press" id="img-<?php echo $image->id; ?>" onclick="likePic(this)">
                                            <span id="span-<?php echo $image->id; ?>">
                                                <?php echo count_story_image($image->id, $user->id);
                                                if (count_story_image($image->id, $user->id) <= 1) {
                                                    echo " like";
                                                } else {
                                                    echo " likes";
                                                }
                                                ?>
                                            </span>
                                        </i>
                                    <?php else : ?>
                                        <i class="test" id="img-<?php echo $image->id; ?>" onclick="likePic(this)">
                                            <span id="span-<?php echo $image->id; ?>">
                                                <?php echo count_story_image($image->id, $user->id);
                                                if (count_story_image($image->id, $user->id) <= 1) {
                                                    echo " like";
                                                } else {
                                                    echo " likes";
                                                }
                                                ?>
                                            </span>
                                        </i>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <i class="test" id="img-<?php echo $image->id; ?>" onclick="likePic(this)">
                                        <span id="span-<?php echo $image->id; ?>">
                                            <?php echo count_story_image($image->id, $user->id);
                                            if (count_story_image($image->id, $user->id) <= 1) {
                                                echo " like";
                                            } else {
                                                echo " likes";
                                            }
                                            ?>
                                        </span>
                                    </i>
                                <?php endif; ?>
                            <?php else : ?>
                                <i class="test" id="img-<?php echo $image->id; ?>" data-toggle="modal" data-target="#loginModal">
                                    <span id="span-<?php echo $image->id; ?>">
                                        <?php echo count_story_image($image->id, $user->id);
                                        if (count_story_image($image->id, $user->id) <= 1) {
                                            echo " like";
                                        } else {
                                            echo " likes";
                                        }
                                        ?>
                                    </span>
                                </i>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

            <?php endforeach; ?>

        </div>
    </div>
<?php endif; ?>


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

<script>
    $(document).ready(function() {

        $('.items').slick({
            dots: true,
            infinite: false,
            speed: 800,
            autoplay: false,
            autoplaySpeed: 2000,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: false,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }

            ]
        });
    });
</script>
<script>
    function likePic(test) {
        var id = test.id.split("-");
        var classnam = test.className.split(" ");
        $("#img-" + id[1]).toggleClass("press", 1000);
        $("#img-" + id[1]).prop('disabled', true);
        var liked = 1;
        if (classnam[1] != undefined) {
            var liked = 0;
        }

        var num_likes = parseInt($('#span-' + id[1])[0].innerText.split(" ")[0]);
        if (liked) {
            num_likes++;
        } else {
            num_likes--;
        }

        if (num_likes <= 1) {
            $('#span-' + id[1])[0].innerText = num_likes + " like";
        } else {
            $('#span-' + id[1])[0].innerText = num_likes + " likes";
        }

        var data = {
            "image_id": id[1],
            "user_id": <?php echo $user->id; ?>,
            "liked": liked
        }
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            url: base_url + "like_controller/add_like",
            type: "post",
            data: data,
            success: function(response) {
                // location.reload();
                $("#img-" + id[1]).prop('disabled', false);
                console.log(response);
            }
        })
    }
</script>
<script>
    jQuery('.loop-gallery').magnificPopup({
        delegate: '.swiper-slide:not(.swiper-slide-duplicate) a.imageitem',
        type: 'image',
        removalDelay: 500, //delay removal by X to allow out-animation
        callbacks: {
            beforeOpen: function() {
                // just a hack that adds mfp-anim class to markup 
                this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                this.st.mainClass = this.st.el.attr('data-effect');
            }
        },
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
        },
        image: {
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
        }
    });
</script>
<script>
    $num = $('.my-card').length;
    $even = $num / 2;
    $odd = ($num + 1) / 2;

    if ($num % 2 == 0) {
        $('.my-card:nth-child(' + $even + ')').addClass('active');
        $('.my-card:nth-child(' + $even + ')').prev().addClass('prev');
        $('.my-card:nth-child(' + $even + ')').next().addClass('next');
    } else {
        $('.my-card:nth-child(' + $odd + ')').addClass('active');
        $('.my-card:nth-child(' + $odd + ')').prev().addClass('prev');
        $('.my-card:nth-child(' + $odd + ')').next().addClass('next');
    }

    $('.my-card').click(function() {
        $slide = $('.active').width();
        console.log($('.active').position().left);

        if ($(this).hasClass('next')) {
            $('.card-carousel').stop(false, true).animate({
                left: '-=' + $slide
            });
        } else if ($(this).hasClass('prev')) {
            $('.card-carousel').stop(false, true).animate({
                left: '+=' + $slide
            });
        }

        $(this).removeClass('prev next');
        $(this).siblings().removeClass('prev active next');

        $(this).addClass('active');
        $(this).prev().addClass('prev');
        $(this).next().addClass('next');
    });


    // Keyboard nav
    $('html body').keydown(function(e) {
        if (e.keyCode == 37) { // left
            $('.active').prev().trigger('click');
        } else if (e.keyCode == 39) { // right
            $('.active').next().trigger('click');
        }
    });
</script>