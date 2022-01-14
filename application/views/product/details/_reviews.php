<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
<style>
    .flexed-reviews {
        display: flex;
        max-height: 200px;
        overflow-y: auto;
    }

    @media screen and (max-width: 800px) {
        .flexed-reviews {
            display: block !important;
            height: auto;
            overflow-y: scroll;
        }

        #reviews-for-mobile-view {
            display: block !important;
        }

        #reviews-for-web {
            display: none !important;
        }
    }

    .reviews-container .list-reviews .media {
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 0px solid rgba(0, 0, 0, 0.08);
    }

    #reviews-for-mobile-view {
        display: none;
    }

    #reviews-for-web {
        display: block;
    }

    /* for see more on reviews */
    .more-review {
        display: none;
    }

    .readmore {
        margin: 0 5px;

        color: green;
        font-size: 13px;
        cursor: pointer;
    }

    .transition {
        -webkit-transform: scale(1.5);
        -moz-transform: scale(1.5);
        -o-transform: scale(1.5);
        transform: scale(1.5);
    }
</style>
<div class="container">
    <div class="reviews-container">
        <div class="row" id="reviews-for-web">
            <div class="col-12">
                <div class="review-total">
                    <label class="label-review"><?php echo trans("reviews"); ?>&nbsp;(<?php echo $review_count; ?>)</label>
                    <?php if ($this->auth_check && $product->listing_type == "ordinary_listing" && $product->user_id != $this->auth_user->id) : ?>
                        <button type="button" class="btn btn-default btn-custom btn-add-review float-right" data-toggle="modal" data-target="#rateProductModal" data-product-id="<?php echo $product->id; ?>"><?php echo trans("add_review") ?></button>
                    <?php endif; ?>
                    <?php if (!empty($reviews)) :
                        $this->load->view('partials/_review_stars', ['review' => $product->rating]);
                    endif; ?>
                </div>
                <?php if (empty($reviews)) : ?>
                    <p class="no-comments-found"><?php echo trans("no_reviews_found"); ?></p>
                <?php else : ?>
                    <div class="row list-unstyled list-reviews flexed-reviews">
                        <?php foreach ($reviews as $review) : ?>
                            <?php if ($product->id == $review->product_id) : ?>
                                <div class="col-6 media">
                                    <img src="<?php echo get_user_avatar_by_id($review->user_id); ?>" alt="<?php echo get_shop_name_by_user_id($review->user_id); ?>">
                                    <div class="media-body">
                                        <div class="row-custom">
                                            <?php $this->load->view('partials/_review_stars', ['review' => $review->rating]); ?>
                                        </div>
                                        <div class="row-custom">

                                            <h5 class="username"><?php echo get_first_last_name_by_user_id($review->user_id); ?></h5>

                                        </div>
                                        <div class="row-custom">
                                            <div class="review">
                                                <p class="content"><?php echo html_escape($review->review); ?></p>
                                            </div>
                                        </div>
                                        <div class="row-custom">

                                            <?php foreach ($review_images as $image) : ?>
                                                <?php if ($review->id == $image->id) : ?>
                                                    <img id="review_image1" class="review_image small" src="<?php echo base_url() . $image->image_url; ?> " style="border-radius:10%;width:100px;height:100px" />
                                                <?php endif ?>
                                            <?php endforeach; ?>

                                        </div>
                                        <div class="row-custom">
                                            <span class="date"><?php echo time_ago($review->created_at); ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row" id="reviews-for-mobile-view">
            <div class="col-12">
                <div class="review-total">
                    <label class="label-review"><?php echo trans("reviews"); ?>&nbsp;(<?php echo $review_count; ?>)</label>
                    <?php if ($this->auth_check && $product->listing_type == "ordinary_listing" && $product->user_id != $this->auth_user->id) : ?>
                        <button type="button" class="btn btn-default btn-custom btn-add-review float-right" data-toggle="modal" data-target="#rateProductModal" data-product-id="<?php echo $product->id; ?>"><?php echo trans("add_review") ?></button>
                    <?php endif; ?>
                    <?php if (!empty($reviews)) :
                        $this->load->view('partials/_review_stars', ['review' => $product->rating]);
                    endif; ?>
                </div>
                <?php if (empty($reviews)) : ?>
                    <p class="no-comments-found"><?php echo trans("no_reviews_found"); ?></p>
                <?php else : ?>
                    <ul class="list-unstyled list-reviews flexed-reviews">
                        <?php foreach ($reviews as $review) : ?>
                            <?php if ($product->id == $review->product_id) : ?>
                                <li class="media">
                                    <a href="<?php echo generate_profile_url($review->user_slug); ?>">
                                        <img src="<?php echo get_user_avatar_by_id($review->user_id); ?>" alt="<?php echo get_shop_name_by_user_id($review->user_id); ?>">
                                    </a>
                                    <div class="media-body">
                                        <div class="row-custom">
                                            <?php $this->load->view('partials/_review_stars', ['review' => $review->rating]); ?>
                                        </div>
                                        <div class="row-custom">
                                            <a href="<?php echo generate_profile_url($review->user_slug); ?>">
                                                <h5 class="username"><?php echo get_shop_name_by_user_id($review->user_id); ?></h5>
                                            </a>
                                        </div>
                                        <div class="row-custom">
                                            <div class="review">
                                                <?php echo html_escape($review->review); ?>
                                            </div>
                                        </div>
                                        <div class="row-custom">
                                            <?php foreach ($review_images as $image) : ?>
                                                <img id="review_image1" class="review_image small" src="<?php echo base_url() . $image->image_url; ?> " style="border-radius:10%;width:100px;height:100px" />
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="row-custom">
                                            <span class="date"><?php echo time_ago($review->created_at); ?></span>
                                        </div>
                                    </div>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.review_image').hover(function() {
            $(this).addClass('transition');
            // other code     
        }, function() {
            $(this).removeClass('transition');
        });
    });
</script>
<!-- see more script -->
<script>
    $(function() {

        var maxL = 40;

        $('.content').each(function() {

            var text = $(this).text();
            if (text.length > maxL) {
                var begin = text.substr(0, maxL),
                    end = text.substr(maxL);

                $(this).html(begin)
                    .append($('<a class="readmore"/>').html(' ...more'))
                    .append($('<div class="more-review" />').html(end));
            }
        });

        $(document).on('click', '.readmore', function() {
            // $(this).next('.readmore').fadeOut("400");
            $(this).next('.more-review').slideToggle(400);

        })
    })
</script>
<!-- end for see more -->
<?php $this->load->view('partials/_modal_rate_product'); ?>