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

        .mySlides {
            display: none
        }

        /* Slideshow container */
        .slideshow-container {
            max-width: 100%;
            position: relative;
            margin: auto;
        }

        /* Next & previous buttons */
        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
        }

        /* Position the "next button" to the right */
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover,
        .next:hover {
            background-color: white;
        }

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
        .dot {
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
        .dot:hover {
            background-color: #717171;
        }

        /* Fading animation */
        /* .fade {
            -webkit-animation-name: fade;
            -webkit-animation-duration: 4s;
            animation-name: fade;
            animation-duration: 4s;
        } */

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

            .prev,
            .next,
            .text {
                font-size: 11px
            }
        }

        .img-product-new {
            display: block;
            height: 136px;
            width: 141px;
            border-radius: 200px;
            margin-top: 4%;
            background-color: white;
        }

        .seller-of-family {
            border-radius: 124px !important;
        }

        #shop-by-seller-alingned-center {
            margin-left: 6%;
        }

        @media(max-width:768px) {
            #shop-by-seller-alingned-center {
                margin-left: 12%;
            }
        }
    </style>
</head>

<body>

    <div class="slideshow-container">
        <?php
        foreach ($user_data as $seller) : ?>
            <div class="mySlides">
                <div class="row-x">
                    <div class="col-md-4 text-center">
                        <h3>Sellers Of Family</h3>
                        <?php if (!empty($seller->avatar)) : ?>
                            <img class="seller-of-family" src="<?php echo base_url() . $seller->avatar; ?>">
                        <?php else : ?>
                            <img class="seller-of-family" src="<?php echo  base_url() . "assets/img/user.png"; ?>">
                        <?php endif; ?>
                        <!-- <img src="<?php echo base_url(); ?>assets/img/landing-page-img/crown .png" id="crown"> -->
                        <h3><?php echo ucfirst($seller->first_name . " " . $seller->last_name); ?></h3>
                        <p><?php echo $seller->supplier_speciality . " Supplier"; ?></p>
                    </div>
                    <div class=" col-md-4">
                        <div class="seller-story ">
                            <h3>The Story</h3>
                            <?php $text = $seller->about_me;
                            $small_text = small_text_generator($text, 600);
                            echo $small_text; ?><br>
                            <a href="<?= generate_url("profile") . '/' . $seller->slug; ?>">
                                <div class="btn btn-md btn-custom m-t-15 "><?php echo "Shop " . ucfirst($seller->first_name) . "'s Products" ?></div>
                            </a>
                        </div>
                    </div>
                    <?php $products = array();
                    $i = 0;
                    if (!empty($user_data)) :
                        // foreach ($user_data as $user) :
                        // while ($i >= 0) :
                        $products = get_vendor_products($seller->id);
                    // $i++;
                    // endwhile;
                    // endforeach;
                    endif;
                    $image = array();
                    $i = 1;
                    foreach ($products as $product) :
                        if ($i <= 4) :
                            $image_product = explode('::', $product->image);
                            array_push($image, $image_product);
                        else :
                            break;
                        endif;
                        $i++;
                    endforeach;
                    ?>
                    <div class="col-md-4" style="text-align:center;">
                        <h3 class="seller-story ">The Product</h3>
                        <div class="row" id="shop-by-seller-alingned-center">
                            <?php $count = 0;
                            foreach ($products as $product) :
                                if (!empty($product) && !empty($image[$count][1])) : ?>
                                    <a href="<?= base_url() . $product->slug; ?>" style="margin-right:3%;">
                                        <img src="<?php echo base_url() . "uploads/images/" . $image[$count][1]; ?>" class="img-product-new" onerror="this.src='<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>'" alt>
                                    </a>
                            <?php endif;
                                $count++;
                            endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>

    </div>
    <br>
    <div style="text-align:center">
        <?php $dot_count = 1;
        foreach ($user_data as $seller) :
            if (!empty($seller)) : ?>
                <span class="dot" onclick="currentSlide('<?php echo $dot_count; ?>')"></span>
        <?php endif;
            $dot_count++;
        endforeach; ?>
    </div>

    <script>
        var slideIndex = 1;
        showSlides(slideIndex);

        window.setInterval(function() {
            showSlides(slideIndex+=1);
        }, 5000);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = parseInt(n));
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length;
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            // setTimeout(showSlides, 2000);
        }

        // var myIndex = 0;
        // carousel();

        // function carousel() {
        //     var i;
        //     var x = document.getElementsByClassName("mySlides");
        //     var dots = document.getElementsByClassName("dot");
        //     for (i = 0; i < x.length; i++) {
        //         x[i].style.display = "none";
        //     }
        //     myIndex++;
        //     if (myIndex > x.length) {
        //         myIndex = 1
        //     }
        //     for (i = 0; i < dots.length; i++) {
        //         dots[i].className = dots[i].className.replace(" active", "");
        //     }
        //     x[myIndex - 1].style.display = "block";
        //     dots[myIndex - 1].className += " active";
        //     setTimeout(carousel, 6000); // Change image every 2 seconds
        // }
    </script>

</body>

</html>