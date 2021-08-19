<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box
        }

        body {
            font-family: Verdana, sans-serif;
            margin: 0
        }

        .Slides {
            display: none;
            padding: 1%;
        }

        /* Slideshow container */
        .slide-container {
            max-width: 100%;
            position: relative;
            margin: auto;
            background-color: #ffffffc7;
            border-radius: 20px;
            padding: 3%;
        }

        .slide-cover {
            max-width: 100%;
            position: relative;
            margin: auto;
            background-color: #ffffffc7;
            border-radius: 20px;
            /* padding: 3%; */
        }

        /* Next & previous buttons */
        /* .previous,
        .next-btn {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            color: black;
            font-weight: lighter;
            font-size: 30px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
        } */

        /* Position the "next button" to the right */
        /* .next-btn {
            right: 3%;
            border-radius: 3px 0 0 3px;
        } */

        /* On hover, add a black background color with a little bit see-through */
        /* .previous:hover,
        .next-btn:hover {
            animation: animateLeftRight infinite 1.5s;
        } */

        /* Caption text */
        .text {
            color: #f2f2f2;
            font-size: 15px;
            padding: 8px 12px;
            position: absolute;
            bottom: 8px;
            width: 100%;
            text-align: center;
        }

        /* The dots/bullets/indicators */
        .dot-icon {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.6s ease;
        }

        .active,
        .dot-icon:hover {
            background-color: #717171;
        }

        /* Fading animation */
        /* .fade { */
        /* -webkit-animation-name: fade;
            -webkit-animation-duration: 4s; */
        /* animation-name: fade;
            animation-duration: 4s; */
        /* } */

        @-webkit-keyframes fade {
            from {
                opacity: .4
            }

            to {
                opacity: 1
            }
        }

        @keyframes fade {
            from {
                opacity: .4
            }

            to {
                opacity: 1
            }
        }

        /* On smaller screens, decrease text size */
        @media only screen and (max-width: 300px) {

            .previous,
            .next-btn,
            .text {
                font-size: 11px
            }
        }

        .margin-class {
            padding-left: 4%;
            padding-right: 4%;
        }

        .image-css {
            width: 100%;
            object-fit: cover;
            max-width: 100%;
            max-height: 260px;
            border-radius: 20px;
        }

        .product-desc {
            max-width: 70%;
            margin-left: 15%;
        }

    </style>
</head>

<body>
    <div class="slide-cover">
        <div class="slide-container">
            <?php
            foreach ($promoted_products as $item) : ?>
                <a href="<?php echo generate_product_url($item); ?>">
                    <div class="Slides">
                        <div class="row-x text-center">
                            <div class="col-md-6 text-center margin-class">
                                <img class="image-css" src="<?php echo get_product_image($item->id, 'image_default'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                            </div>
                            <div class="col-md-6 text-center margin-class">
                                <h4><b><?php echo get_product_title($item); ?></b></h4>
                                <br>
                                <p class="product-desc"><?php $text = product_description($item->id);
                                                        $small_text = small_text_generator($text, 200);
                                                        echo $small_text; ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="main-slider-nav">
            <a class="prev" onclick="plus_slides(-1)"><i class="icon-arrow-left"></i></a>
            <a class="next" onclick="plus_slides(1)"><i class="icon-arrow-right"></i></a>
        </div>
    </div>
    <div style="text-align:center">
        <?php $dot_count = 1;
        foreach ($promoted_products as $item) :
            if (!empty($item)) : ?>
                <span class="dot-icon" onclick="current_Slide('<?php echo $dot_count; ?>')"></span>
        <?php endif;
            $dot_count++;
        endforeach; ?>
    </div>

    <script>
        // document.querySelectorAll("p").forEach((x) => {
        //     x.innerText = x.innerText.replace(/\./g, ".\n")
        // })
        var slide_index = 1;
        show_slides(slide_index);

        window.setInterval(function() {
            show_slides(slide_index+=1);
        }, 5000);

        function plus_slides(n) {
            show_slides(slide_index += n);
        }

        function current_Slide(n) {
            show_slides(slide_index = parseInt(n));
        }

        function show_slides(n) {
            var i;
            var slides = document.getElementsByClassName("Slides");
            var dots = document.getElementsByClassName("dot-icon");
            if (n > slides.length) {
                slide_index = 1
            }
            if (n < 1) {
                slide_index = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slide_index - 1].style.display = "block";
            dots[slide_index - 1].className += " active";
        }
    </script>

</body>

</html>