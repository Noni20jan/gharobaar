<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .product-imgs-modal {
        height: 118px;
    }

    .form-textarea {
        min-height: 60px;
        border-radius: 15px;
        padding: 10px 12px;
        resize: vertical;
    }

    @media(max-width:768px) {
        .product-imgs-modal {
            height: 84px;
        }

        .scroll-for-mobile {
            overflow-y: scroll !important;
            height: 70vh;
        }

    }

    .upload_image {
        margin-left: 20px;

    }
</style>
<div class="modal fade" id="rateProductModalorder" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-custom scroll-for-mobile">
            <!-- form start -->
            <?php echo form_open_multipart('cart_controller/save_rate_last_order'); ?>
            <div class="modal-header">
                <h5 class="modal-title"><?php echo trans("rate_last_order"); ?></h5>
                <!-- <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true"><i class="icon-close"></i> </span>
                </button> -->
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php $order_id['product_id'] =  $this->product_model->get_order_id($this->auth_user->id); ?>
                    <?php $order_id = $order_id['product_id']->order_id;
                    $get_last_order = get_last_ordered_products($order_id);
                    ?>
                    <div class="col-12">
                        <?php $i = 1; ?>
                        <?php foreach ($get_last_order as $get_last_order) : ?>
                            <div class="row-custom">
                                <div class="row">
                                    <div class="col-6">
                                        <img class="product-imgs-modal" src="<?php echo get_product_image($get_last_order->product_id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                                    </div>
                                    <div class="col-6">
                                        <?php echo $get_last_order->product_title ?>
                                    </div>
                                </div>
                                <div class="rate-product">
                                    <span><?php echo trans("your_rating"); ?></span>
                                    <div class="rating-stars-<?php echo $i ?>">
                                        <label class="label-star" data-star="5" for="star5"><i class="icon-star"></i></label>
                                        <label class="label-star" data-star="4" for="star4"><i class="icon-star"></i></label>
                                        <label class="label-star" data-star="3" for="star3"><i class="icon-star"></i></label>
                                        <label class="label-star" data-star="2" for="star2"><i class="icon-star"></i></label>
                                        <label class="label-star" data-star="1" for="star1"><i class="icon-star"></i></label>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <textarea name="review[]" id="user_review" class="form-control form-input form-textarea" placeholder="<?php echo trans("write_review"); ?>"></textarea>
                                <input type="hidden" name="rating[]" id="user_rating_<?php echo $i ?>" value="5">
                                <input type="hidden" name="product_id[]" value="<?php echo $get_last_order->product_id ?>" id="review_product_id">
                            </div>
                            <script>
                                $(document).on("click", ".rating-stars-<?php echo $i ?> .label-star", function() {
                                    $("#user_rating_<?php echo $i ?>").val($(this).attr("data-star"));
                                });

                                $(document).on('click', '.rating-stars-<?php echo $i ?> label', function() {
                                    $('.rating-stars-<?php echo $i ?> label i').removeClass("icon-star");
                                    $('.rating-stars-<?php echo $i ?> label i').addClass("icon-star-o");
                                    var selected_star = $(this).attr("data-star");
                                    $('.rating-stars-<?php echo $i ?> label').each(function() {
                                        var star = $(this).attr("data-star");
                                        if (star <= selected_star) {
                                            $(this).find('i').removeClass("icon-star-o");
                                            $(this).find('i').addClass("icon-star");
                                        }
                                    });
                                });
                            </script>

                            <?php $i++; ?>

                        <?php endforeach; ?>

                    </div>
                    <div class="upload_image">

                        <input type="file" class="upload_product_image" name="file" id="upload_review_image" accept=".png, .jpg, .jpeg, .gif" onchange=imageShow(this)>
                        <span class='badge badge-info' id="upload-file-info"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-md btn-red" data-dismiss="modal"><?php echo trans("close"); ?></button> -->
                <button type="submit" class="btn btn-md btn-custom"><?php echo trans("submit"); ?></button>
            </div>
            <?php echo form_close(); ?>

        </div>
    </div>
</div>
<script>
    function imageShow(input) {
        $('#upload-file-info').html($(input).val().replace(/.*[\/\\]/, ''));
        readURL(input);
    };
</script>