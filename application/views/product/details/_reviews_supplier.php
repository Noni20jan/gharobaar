<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="reviews-container">
    <div class="row">
        <div class="col-12">
            <div class="review-total">
                <label class="label-review"><?php echo trans("reviews"); ?>&nbsp;(<?php echo $review_supplier_count; ?>)</label>
                <?php if ($this->auth_check && $product->listing_type == "ordinary_listing" && $product->user_id != $this->auth_user->id) : ?>
                    <button type="button" class="btn btn-default btn-custom btn-add-review float-right" data-toggle="modal" data-target="#rateProductModal" data-product-id="<?php echo $product->id; ?>"><?php echo trans("add_review") ?></button>
                <?php endif; ?>
                <?php //if (!empty($reviews_supplier)) :
                //$this->load->view('partials/_review_stars', ['review' => $product->rating]);
                //endif; 
                ?>
            </div>
            <?php if (empty($reviews_supplier)) : ?>
                <p class="no-comments-found"><?php echo trans("no_reviews_found"); ?></p>
            <?php else : ?>
                <ul class="list-unstyled list-reviews">
                    <?php foreach ($reviews_supplier as $review) : ?>

                        <li class="media">
                            <a href="<?php echo generate_profile_url($review->user_slug); ?>">
                                <img src="<?php echo get_user_avatar_by_id($review->user_id); ?>" alt="<?php echo get_shop_name_by_user_id($review->user_id); ?>">
                            </a>
                            <div class="media-body">
                                <!-- <div class="row-custom">
                                    </*?php $this->load->view('partials/_review_stars', ['review' => $review]); ?*/>
                                </div> -->
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
                                    <span class="date"><?php echo time_ago($review->created_at); ?></span>
                                </div>
                            </div>
                        </li>

                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $this->load->view('partials/_modal_rate_product'); ?>