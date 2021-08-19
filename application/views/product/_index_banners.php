<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (!empty($index_banners_array) && !empty($banner_location) && !empty($index_banners_array[$banner_location])) : ?>
    <div class="col-12 section section-index-bn" style="padding:0px 0px;">

        <style>
            .carousel-control-next-icon,
            .carousel-control-prev-icon {
                position: absolute;
                top: 50%;
                z-index: 5;
            }

            .carousel-control-prev-icon {
                left: 20px;
            }

            .carousel-control-next-icon {
                right: 20px;
            }
        </style>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php for ($i = 0; $i < count($index_banners_array[$banner_location]); $i++) : ?>

                    <div class="carousel-item <?php if ($i == 0) : echo 'active';
                                                endif; ?>">
                        <div class="row">
                            <?php if ($index_banners_array[$banner_location][$i]->banner_location == $banner_location) : ?>

                                <div class="col-sm-6 col-index-bn index_bn_<?= $index_banners_array[$banner_location][$i]->id; ?>">
                                    <a href="<?= $index_banners_array[$banner_location][$i]->banner_url; ?>">
                                        <img src="<?= IMG_BASE64_1x1; ?>" data-src="<?= base_url() . $index_banners_array[$banner_location][$i]->banner_image_path; ?>" alt="banner" class="lazyload img-fluid" style="border-radius:20px;">
                                    </a>
                                </div>
                            <?php endif;
                            if ($i < count($index_banners_array[$banner_location]) - 1) :
                                $i++;

                            ?>
                                <?php if ($index_banners_array[$banner_location][$i]->banner_location == $banner_location) : ?>
                                    <div class="col-sm-6 col-index-bn index_bn_<?= $index_banners_array[$banner_location][$i]->id; ?>">
                                        <a href="<?= $index_banners_array[$banner_location][$i]->banner_url; ?>">
                                            <img src="<?= IMG_BASE64_1x1; ?>" data-src="<?= base_url() . $index_banners_array[$banner_location][$i]->banner_image_path; ?>" alt="banner" class="lazyload img-fluid" style="border-radius:20px;">
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                        </div>
                    </div>

                <?php endfor; ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
<?php endif; ?>