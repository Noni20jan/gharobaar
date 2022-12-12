<style>
    .product-slider-content {
        height: auto;
        overflow: hidden;
        position: relative;
    }

    .discount-rate {
        float: right;
        color: #007C05;
        margin-top: 0%;
    }
 
</style>
<html>

<body>
    <?php $image_count = 0;
    if (!empty($product_images)) {
        $image_count = item_count($product_images);
    } ?>
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
            <?php if (item_count($product_image) > 1) : ?>
                <div class="left">
                    <div class="product-slider-content" style="width:130%; overflow-y:scroll;">
                        <div id="product_thumbnails_slider" class="product-thumbnails-slider">
                            <?php foreach ($product_image as $image) : ?>
                                <div class="item">
                                    <div class="item-inner" style="border-radius:15px;">
                                        <img src="<?php echo IMG_BASE64_1x1; ?>" class="img-bg" alt="slider-bg">
                                        <img src="<?php echo get_product_image_url($image, 'image_small'); ?>" data-lazy="<?php echo get_product_image_url($image, 'image_small'); ?>" class="img-thumbnail" alt="<?php echo get_product_title($product); ?>">

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (item_count($product_image) > 4) : ?>
                            <div id="product-thumbnails-slider-nav" class="product-thumbnails-slider-nav">
                                <button style="display: block; color:black; margin: 4px 2px;  background-color: #fff;border-radius: 50%;margin-left: 47px;" class="prev"><i class="icon-arrow-up"></i></button>
                                <button style="display: block; color:black; margin: 4px 2px;  background-color: #fff;border-radius: 50%;margin-left: 47px;" class=" next"><i class="icon-arrow-down"></i></button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="right">
                <div class="product-slider-content" style="text-align: center;height: auto;">
                    <div id="product_slider" class="product-slider gallery">
                        <?php if (!empty($product_images)) :
                            foreach ($product_images as $image) : ?>
                                <div class="item img-zoom-container">
                                    <a href="<?php echo get_product_image_url($image, 'image_big'); ?>" title="">
                                        <img src="<?php echo get_product_image_url($image, 'image_default'); ?>" style="border-radius:20px; max-width: 500px; height: 500px;" id="image_<?php echo ($image->id) ?>" value="<?php echo get_product_image_url($image, 'image_default'); ?>" alt="<?php echo $product->slug; ?>">

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
            <div class="row">
                <div class="col-12">
                    <?php if ($product->product_type == 'digital') :
                        if ($product->is_free_product == 1) :
                            if ($this->auth_check) : ?>
                                <div class="row-custom m-t-10">
                                    <?php echo form_open('download-free-digital-file-post'); ?>
                                    <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                                    <button class="btn btn-instant-download"><i class="icon-download-solid"></i><?php echo trans("download") ?></button>
                                    <?php echo form_close(); ?>
                                </div>
                            <?php else : ?>
                                <div class="row-custom m-t-10">
                                    <button class="btn btn-instant-download" data-toggle="modal" data-target="#loginModal"><i class="icon-download-solid"></i><?php echo trans("download") ?></button>
                                </div>
                            <?php endif; ?>
                        <?php else : ?>
                            <?php if (!empty($digital_sale)) : ?>
                                <div class="row-custom m-t-10">
                                    <?php echo form_open('download-purchased-digital-file-post'); ?>
                                    <input type="hidden" name="sale_id" value="<?php echo $digital_sale->id; ?>">
                                    <button class="btn btn-instant-download"><i class="icon-download-solid"></i><?php echo trans("download") ?></button>
                                    <?php echo form_close(); ?>
                                </div>
                            <?php else : ?>
                                <label class="label-instant-download"><i class="icon-download-solid"></i><?php echo trans("instant_download"); ?></label>
                    <?php endif;
                        endif;
                    endif; ?>


                    <?php if ($product->status == 0 && $product->is_draft == 1) : ?>
                        <label class="badge badge-warning badge-product-status">Draft</label>
                    <?php elseif ($product->status == 0) : ?>
                        <label class="badge badge-warning badge-product-status"><?php echo trans("pending"); ?></label>
                    <?php elseif ($product->visibility == 0) : ?>
                        <label class="badge badge-danger badge-product-status"><?php echo trans("hidden"); ?></label>
                    <?php endif; ?>
                    <?php $categories = get_parent_category_id($product->category_id);
                    $sub_categories = get_parent_categories_tree($product->category_id);
                    $product_weight = false;
                    foreach ($sub_categories as $sub) :
                        if ($sub->id == 3) :
                            $product_weight = true;
                        endif;
                    endforeach;
                    ?>
                    <?php $variations = get_product_variations($product->id);
                    $option = count($variations); ?>
                    <?php if (!empty($option != 0 && $categories == 0 && $product_weight == true)) : ?>
                        <h3 class="product-title"><?= html_escape($product_details->title); ?><span id="selected_variation">&nbsp;<?= html_escape('(' . $product->product_weight . 'g)'); ?></span></h3>
                        <?php elseif ($categories == 0) :
                        if ($product_weight == true) : ?>
                            <h3 class="product-title"><?= html_escape($product_details->title); ?>&nbsp;<?= html_escape('(' . $product->product_weight . 'g)'); ?></h3>
                        <?php else : ?>
                            <h3 class="product-title"><?= html_escape($product_details->title); ?><span id="selected_variation"></span></h3>
                        <?php endif; ?>
                    <?php endif;  ?>
                    <div class="row-custom meta">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="product-details-user">
                                    By&nbsp;<a href="<?php echo generate_profile_url_by_id($product->user_id); ?>"><?php echo character_limiter(ucfirst(get_brand_name_product($product)), 30, '..'); ?></a><br>
                                </div>
                            </div>
                            <div class="product-details-review">
                                <?php if ($this->general_settings->reviews == 1) {
                                    $this->load->view('partials/_review_stars', ['review' => $product->rating]);
                                    $count_star = $this->review_model->get_review_count($product->id); ?>
                                    <span><b> (<?php echo $count_star; ?>)</b> </span>
                                <?php  } ?>
                            </div>
                            <span><i class="icon-eye"></i><?php echo html_escape($product->pageviews); ?></span>
                        </div>
                    </div>
                    <div class="row-custom price">
                        <div id="product_details_price_container" class="d-inline-block">
                            <?php $this->load->view("product/details/_price", ['product' => $product, 'price' => $product->price, 'discount_rate' => $product->discount_rate]); ?>
                            <?php if ($product->listing_type == 'ordinary_listing' && $product->stock < 1) : ?>
                                <strong class="lbl-sold"><?= trans("sold"); ?></strong>
                            <?php endif; ?>
                        </div>
                        <div class="align-middle float-right">
                            <?php if ($product->listing_type != 'ordinary_listing' && $product->product_type != 'digital' && $product->is_service != '1') : ?>
                                <div class="item-details">
                                    <input type="hidden" id="product_variation_stock" value="<?php echo $product->stock; ?>">
                                    <div id="text_product_stock_status" class="right">
                                        <?php if ($product->add_meet == "Made to stock") : ?>
                                            <?php if (check_product_stock($product)) : ?>
                                                <span class="status-in-stock text-success"><?php echo trans("in_stock") ?></span>
                                            <?php else : ?>
                                                <span class="status-in-stock text-danger"><?php echo trans("out_of_stock") ?></span>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <?php if (check_product_stock($product)) : ?>
                                                <span class="status-in-stock text-success"><?php echo trans("available") ?></span>
                                            <?php else : ?>
                                                <span class="status-in-stock text-danger"><?php echo trans("not_available") ?></span>
                                        <?php endif;
                                        endif; ?>
                                    </div>

                                </div>
                            <?php else : ?>
                                <div class="item-details">
                                    <div id="text_product_stock_status" class="right">
                                        <?php if (check_product_stock($product)) : ?>
                                            <span class="status-in-stock text-success"><?php echo "Available" ?></span>
                                        <?php else : ?>
                                            <span class="status-in-stock text-danger"><?php echo "Unavailable" ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>


                            <!-- <?php if (!empty($product->sku)) : ?>
                <div class="item-details">
                    <div class="left">
                        <label><?php echo trans("sku"); ?></label>
                    </div>
                    <div class="right">
                        <span><?php echo html_escape($product->sku); ?></span>
                    </div>
                </div>
            <?php endif; ?> -->


                            <?php if ($product->product_type == 'digital') : ?>
                                <div class="item-details">
                                    <div class="left">
                                        <label><?php echo trans("files_included"); ?></label>
                                    </div>
                                    <div class="right">
                                        <span><?php echo html_escape($product->files_included); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($product->listing_type == 'ordinary_listing') : ?>
                                <div class="item-details">
                                    <div class="left">
                                        <label><?php echo trans("uploaded"); ?></label>
                                    </div>
                                    <div class="right">
                                        <span><?php echo time_ago($product->created_at); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>


                    <form id="form_add_cart" class="product_detail1" method="post">
                        <input type="hidden" name="product_id" id="product_id" value="<?php echo $product->id; ?>">





                        <div class="row-custom product-variations mb-0">
                            <div class="row row-product-variation item-variation">
                                <?php if (!empty($half_width_product_variations)) :
                                    foreach ($half_width_product_variations as $variation) :
                                        $this->load->view('product/details/_product_variations', ['variation' => $variation]);
                                    endforeach;
                                endif;
                                if (!empty($full_width_product_variations)) :
                                    foreach ($full_width_product_variations as $variation) :
                                        $this->load->view('product/details/_product_variations', ['variation' => $variation]);
                                    endforeach;
                                endif; ?>
                            </div>
                        </div>
                        <div>
                            <span class="input-group-btn">
                                <label id="no_stock_id" style="color:red;"> </label>
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6 mb-2">
                                <?php if (!empty($variation)) : ?>
                                    <?php if ($product->listing_type != 'ordinary_listing' && $product->product_type != 'digital' && $product->is_service != '1') : ?>
                                        <div>
                                            <label class="label-product-variation mb-3" style="font-weight:600;">Quantity</label>
                                            <div class="cart-item-quantity">
                                                <div class="number-spinner for-height spinner-width">
                                                    <div class="input-group">
                                                        <span class="input-group-btn for-height">
                                                            <button type="button" class="btn btn-default btn-spinner-minus" id="minus-btn" style=" padding: 6px 8px;" data-dir="dwn">-</button>
                                                        </span>
                                                        <input type="text" class="form-control text-center" id="product_quantity" name="product_quantity" value="1" readonly="" style="background-color:white; height: calc(1.5em + 0.75rem + 0px);">

                                                        <span class="input-group-btn for-height">
                                                            <button type="button" class="btn btn-default btn-product-plus" id="plus-btn" style=" padding: 6px 8px;border-left:1px solid #e4e4e4;" data-dir="up">+</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if (empty($variation)) : ?>
                                    <div>
                                        <label class="label-product-variation mb-3" style="font-weight:600;">Quantity</label>
                                        <div class="cart-item-quantity">
                                            <div class="number-spinner for-height spinner-width">
                                                <div class="input-group ">
                                                    <span class="input-group-btn for-height">
                                                        <button type="button" class="btn btn-default btn-spinner-minus" id="minus-btn" style=" padding: 6px 8px;" data-dir="dwn">-</button>
                                                    </span>
                                                    <input type="text" class="form-control text-center" id="product_quantity" name="product_quantity" value="1" readonly="" style="background-color:white; height: calc(1.5em + 0.75rem + 0px);">

                                                    <span class="input-group-btn for-height">
                                                        <button type="button" class="btn btn-default btn-product-plus" id="plus-btn" style=" padding: 6px 8px;border-left:1px solid #e4e4e4;" data-dir="up">+</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-12 col-lg-6 mb-2">
                                <label class="label-product-variation mb-3" style="font-weight:600; white-space:nowrap;">Enter PIN Code To Check Delivery</label>
                                <div class="input-group">
                                    <input type="text" name="pin_text" id="pin_text" class="form-control text-center input-product-pincode" autocomplete="off" maxlength=6 oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    <button type="button" class="btn btn-md" id="check-button">Go!</button>
                                </div>
                                <p id="check_pincode_text"></p>
                            </div>

                        </div>

                        <!-- <div class="row">
                <div class="col-12 col-lg-6 mb-2">
                    <?php if (!empty($variation)) : ?>
                        <?php if ($product->listing_type != 'ordinary_listing' && $product->product_type != 'digital' && $product->is_service != '1') : ?>
                            <div>
                                <label class="label-product-variation mb-3" style="font-weight:600;">Quantity</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-center input-product-pincode" id="product_quantity" name="product_quantity" value="1" max="<?php echo $product->stock; ?>" style="background-color:white;">
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if (empty($variation)) : ?>
                        <div style="margin-top:20px;">
                            <label class="label-product-variation mb-3" style="font-weight:600;">Quantity</label>
                            <div class="input-group">
                                <input type="text" class="form-control text-center input-product-pincode" id="product_quantity" name="product_quantity" value="1" max="<?php echo $product->stock; ?>" style="background-color:white;">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-12 col-lg-6 mb-2">
                    <label class="label-product-variation mb-3" style="font-weight:600;">Enter PIN Code To Check Delivery</label>
                    <div class="input-group">
                        <input type="text" name="pin_text" id="pin_text" class="form-control text-center input-product-pincode" autocomplete="off" maxlength=6 oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        <button type="button" class="btn btn-md" id="check-button">Go!</button>
                    </div>
                    <p id="check_pincode_text"></p>
                </div>
            </div> -->
                        <?php if ($product->add_meet == "Made to order") :
                        $cat = $this->category_model->get_parent_categories_tree($product->category_id);
                            if ($cat[0]->id == 2) :
                                $this->load->view('product/details/_expected_date_time', ['product' => $product]);
                            else : ?>
                                <div class="row" style="width:100%;">
                                    <div class="col-md-12" id="postal-code">
                                        <span><b>Lead Time <a id="transit" href="javascript:void(0);"><i class="fa fa-info-circle" aria-hidden="true"></i>
                                                    <p class="sr-only">Lead Time means the time a product would take to be <br>ready for dispatch.</p>
                                                </a></i></b></span>
                                        <span class="lead_time">:<?php echo get_transit_time_for_made_to_order($product, "string"); ?></span>
                                        <!-- <b style="margin-left: 9px;">Lead Time <a id="transit" href="#"><i class="fa fa-info-circle" aria-hidden="true"></i>
                            <p class="sr-only">Lead Time means the time a product would take to be <br>ready for dispatch.</p>
                        </a></i><span class="lead_time">:<?php echo get_transit_time_for_made_to_order($product, "string"); ?>
                        </span> -->
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>


                        <div class="row">
                            <?php $buttton = get_product_form_data($product, $users)->button;
                            $buttton2 = get_product_form_data($product, $users)->button2;
                            if (!empty($buttton)) : ?>

                                <div class="col-6"><?php echo $buttton; ?> </div>
                                <div class="col-6">
                                    <?php
                                    $whislist_button_class = "";
                                    $whislist_button_class = (empty($product->demo_url) && $product->listing_type == 'ordinary_listing') ? "btn-wishlist-classified" : "";
                                    if ($this->product_model->is_product_in_wishlist($product->id) == 1) : ?>

                                        <a href="javascript:void(0)" style="width:100%;" class="btn btn-md btn-product-wishlist btn-add-remove-wishlist <?php echo $whislist_button_class; ?>" data-product-id="<?php echo $product->id; ?>" data-reload="1">Remove from Wishlist</a>
                                    <?php else : ?>
                                        <?php if (!empty($this->auth_check)) : ?>
                                            <?php if ($this->auth_user->user_type != "guest") : ?>
                                                <a href="javascript:void(0)" style="width:100%;" class="btn btn-md btn-product-wishlist btn-add-remove-wishlist <?php echo $whislist_button_class; ?>" data-product-id="<?php echo $product->id; ?>" data-reload="1">Add to Wishlist</i></a>
                                            <?php else : ?>
                                                <!-- hide wishlist for guest user -->
                                                <a href="javascript:void(0)" data-toggle="modal" style="width:100%;" data-id="0" class="btn btn-md btn-product-wishlist" data-target=" #registerModal" class="link"><?php echo trans("add_to_wishlist"); ?></a>
                                                <!-- <a id="wishlist_btn" style="width:100%;" class="btn btn-md btn-product-wishlist btn-add-remove-wishlist <?php echo $whislist_button_class; ?>" data-product-id="0">Add to Wishlist</i></a> -->

                                            <?php endif; ?>
                                        <?php else : ?>
                                            <a id="wishlist_btn" style="width:100%;" class="btn btn-md btn-product-wishlist btn-add-remove-wishlist <?php echo $whislist_button_class; ?>" data-product-id="0">Add to Wishlist</i></a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                                <!-- <div class="col-6"><?php echo $buttton2; ?></div> -->

                            <?php endif; ?>

                        </div>
                        <div class="product-description">
                            <h3 class="product_description">Description</h3>
                            <pre style="margin-top: 3px; white-space:pre-line; font-weight:500; text-align:justify; font-size: 107%; font-family:'poppins',sans-serif;" class="more"><?php echo $product_details->description; ?></pre>
                        </div>

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



    <?php $this->load->view("product/details/_product_share"); ?>

</body>

</html>
<?php if ($this->auth_check) : ?>
    <?php if ($user->role == "vendor" && $product->available_for_barter == "Y" && $product->user_id != $this->auth_user->id) { ?>
        <a href="<?php echo generate_barterproduct_url($product); ?>">
            <!-- <button class="btn btn-md btn-block btn-product-cart">Available for barter</button> -->
        </a>
<?php }
endif; ?>
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
<script>
    $(document).ready(function() {
        // Configure/customize these variables.
        var showChar = 100; // How many characters are shown by default
        var ellipsestext = "";
        var moretext = "See More";
        var lesstext = "See Less";

        $('.more').each(function() {
            var content = $(this).html();

            var content_length = content.split(' ').length;


            const splitWords = (text, numWords) => {
                const words = text.split(' ')
                let part1 = '',
                    part2 = ''
                words.forEach((word, idx) => {
                    if (idx < numWords) {
                        part1 += ' ' + word
                    } else {
                        part2 += ' ' + word
                    }
                })
                return [part1.trim(), part2.trim()]
            }

            const [part1, part2] = splitWords(content, showChar);


            if (content_length > showChar) {

                var c = part1;
                var h = part2;

                var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span> <span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="see_more morelink" >' + moretext + '</a></span>';

                $(this).html(html);
            }

        });
        $(".morelink").click(function() {
            if ($(this).hasClass("less")) {
                $(this).removeClass("less");
                $(this).html(moretext);
            } else {
                $(this).addClass("less");
                $(this).html(lesstext);
            }
            $(this).parent().prev().toggle();
            $(this).prev().toggle();
            return false;
        });
    });
    $(document).on('click', '.product_detail1 button', function() {
        $('.product_detail1 button').removeClass('clicked');
        $(this).addClass('clicked');
    });
    $(document).ready(function() {
        $('#form_add_cart').submit(function(e) {
            e.preventDefault();
            var action = $(this).find('button.clicked').prop('value');
            var product_id = document.getElementById("product_id").value;
            var base_url = '<?php echo base_url() ?>';
            var data = {
                "submit": action,
                "product_id": product_id,
                "formdata": $('#form_add_cart').serialize()
            };

            var formdata = $('#form_add_cart').serializeArray();

            formdata.push({
                name: 'submit',
                value: action
            });
            formdata.push({
                name: csfr_token_name,
                value: $.cookie(csfr_cookie_name)
            });
            console.log(formdata);


            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            console.log($("#form_add_cart").validate());
            if ($('#form_add_cart')[0].checkValidity()) {
                $.ajax({
                    type: "POST",
                    url: base_url + "cart_controller/add_to_cart_ajax",
                    data: formdata,
                    dataType: 'json',
                    async: false,

                    success: function(response) {
                        console.log(response);
                        console.log($('#form_add_cart').serializeArray());
                        if (response.action == "add_to_cart") {
                            console.log(response.cart_count);
                            // var x = '<?php echo get_product_image($product->id, 'image_small'); ?>'
                            // console.log(x);
                            // var str = "<img src=\"" + x + "\"\/>"
                            if ($(".notification").length == 0) {
                                $(".cart_a").append("<span class='notification'></span>");
                                $(".notification").text(response.cart_count);
                                $.notify({
                                    title: "<strong></strong> ",
                                    message: "Added To Cart"

                                });
                            } else {
                                $(".notification").text(response.cart_count);
                                $.notify({
                                    title: "<strong></strong> ",
                                    // icon: '<img src="<?php echo base_url(); ?>assets/img/img_bg_product_small.png">',
                                    message: "Added To Cart"

                                });
                            }
                        } else if (response.action == "buy_now") {
                            location.href = '<?php echo (generate_url("cart")); ?>'
                        }

                    }
                });
            }

        });
    })

    $("#check-button").click(function() {
        valid();
        var pin = document.getElementById("pin_text");
        var pin_code = document.getElementById("pin_text").value;
        var url = "https://api.postalpincode.in/pincode/" + document.getElementById("pin_text").value;
        $.ajax({
            url: url,
            cache: false,
            async: false,
            success: function(res) {

                if (res[0].Status === "Error") {
                    document.getElementById("check_pincode_text").style.color = "red";
                    document.getElementById("check_pincode_text").innerHTML = "Enter a valid pincode !";
                    // console.log("pin_code");
                    pin.focus();
                    return false;
                } else {
                    var distance_response = getDistance($('#pin_text').val(), '<?php echo $product->product_pincode; ?>');
                    var data = {
                        "delivery": $('#pin_text').val(),
                        "pickup": '<?php echo $product->product_pincode; ?>'
                    };
                    data[csfr_token_name] = $.cookie(csfr_cookie_name);

                    var category = <?php echo json_encode(get_parent_categories_tree($product->category_id)); ?>;

                    if (category[0].id == 2) {
                        $.ajax({
                            url: base_url + "calulate-distance",
                            type: "post",
                            data: data,
                            async: false,
                            success: function(response) {

                                var total_distance = JSON.parse(response);
                                var dist_in_km = parseInt(total_distance.rows[0].elements[0].distance.value / 1000);
                                console.log(dist_in_km);
                                var product = '<?php echo $product->delivery_area; ?>';
                                // var product_json = JSON.parse(product);
                                var delivery_area = product;

                                var delivery_areas = ["5 km", "10 km", "20 km", "30 km", "40 km", "50 km"];

                                if (delivery_areas.includes(delivery_area)) {
                                    var distance = parseInt(delivery_area.split(" ")[0]);

                                    if (dist_in_km > distance) {
                                        document.getElementById("check_pincode_text").innerHTML = "This item is not deliverable to this address";
                                        document.getElementById("check_pincode_text").style.color = "red";
                                        return false;
                                    }

                                } else {
                                    console.log("not included");
                                }
                                var category = <?php echo json_encode(get_parent_categories_tree($product->category_id)); ?>;

                                if (category[0].id == 2) {
                                    if (dist_in_km > parseInt('<?php echo $this->general_settings->now_bike_distance; ?>') / 1000) {
                                        document.getElementById("check_pincode_text").innerHTML = "This item is not deliverable to this address";
                                        document.getElementById("check_pincode_text").style.color = "red";
                                        return false;
                                    } else {
                                        if ("<?php echo $product->add_meet ?>" == "Made to order") {
                                            var transit = $('.lead_time').text();
                                            var str = transit.split(":")[1];
                                            var split = str.split(" ");
                                            var day = parseInt(split[0]) * 24 * 3600;
                                            var hours = parseInt(split[2]) * 3600;
                                            var tot_seconds = day + hours;
                                            days = ConvertSectoDay(tot_seconds);
                                            // console.log(days);
                                        } else {
                                            days = "<?php echo check_for_days($product); ?>";
                                            // console.log(days);
                                        }
                                        var dt = new Date();
                                        var updated = getdate(dt, days);
                                        console.log(updated);
                                        document.getElementById("check_pincode_text").innerHTML = "Estimated Delivery by" + " " + '<span>' + updated + '</span>';
                                        document.getElementById("check_pincode_text").style.color = "green";
                                        return true;
                                    }
                                }

                            }
                        })
                    } else {

                        var product = '<?php echo $product->delivery_area; ?>';
                        // var product_json = JSON.parse(product);
                        var delivery_area = product;

                        var delivery_areas = ["5 km", "10 km", "20 km", "30 km", "40 km", "50 km"];

                        if (delivery_areas.includes(delivery_area)) {
                            $.ajax({
                                url: base_url + "calulate-distance",
                                type: "post",
                                data: data,
                                async: false,
                                success: function(response) {

                                    var total_distance = JSON.parse(response);
                                    var dist_in_km = parseInt(total_distance.rows[0].elements[0].distance.value / 1000);

                                    console.log(dist_in_km);

                                    var distance = parseInt(delivery_area.split(" ")[0]);

                                    if (dist_in_km > distance) {
                                        document.getElementById("check_pincode_text").innerHTML = "This item is not deliverable to this address";
                                        document.getElementById("check_pincode_text").style.color = "red";
                                        return false;
                                    } else {
                                        var result = null;
                                        var message = null;
                                        var settings = {
                                            "url": "https://apiv2.shiprocket.in/v1/external/courier/serviceability/",
                                            "method": "GET",
                                            "timeout": 0,
                                            "headers": {
                                                "Content-Type": "application/json",
                                                "Authorization": "Bearer <?php echo !empty($_SESSION['modesy_sess_user_shiprocket_token']) ? $_SESSION['modesy_sess_user_shiprocket_token'] : ''; ?>"
                                            },
                                            "data": {
                                                "pickup_postcode": <?php echo $product->product_pincode; ?>,
                                                "delivery_postcode": $('#pin_text').val(),
                                                "cod": 0,
                                                "weight": <?php echo (floatval($product->weight) / 1000) ?>
                                            },
                                        };
                                        $(document).ready(function() {
                                            $.ajax(settings).done(function(response) {

                                                result = response;
                                                console.log(result);
                                                if (result['status'] == 404) {
                                                    document.getElementById("check_pincode_text").innerHTML = "Delivery Pincode not Serviceable";
                                                    document.getElementById("check_pincode_text").style.color = "red";
                                                } else if (result['status_code'] == 422) {
                                                    document.getElementById("check_pincode_text").innerHTML = result.errors.delivery_postcode[0];
                                                    document.getElementById("check_pincode_text").style.color = "red";
                                                } else {
                                                    var days;
                                                    if ("<?php echo $product->add_meet ?>" == "Made to order") {
                                                        var transit = $('.lead_time').text();
                                                        var str = transit.split(":")[1];
                                                        var split = str.split(" ");
                                                        var day = parseInt(split[0]) * 24 * 3600;
                                                        var hours = parseInt(split[2]) * 3600;
                                                        var tot_seconds = day + hours;
                                                        days = ConvertSectoDay(tot_seconds);
                                                        console.log(days);
                                                    } else {
                                                        days = "<?php echo check_for_days($product); ?>";
                                                    }
                                                    console.log(days);
                                                    var x = response['data']['available_courier_companies'][0]['etd'];
                                                    var dt = new Date(x);
                                                    var dt_new_format = dt.toLocaleDateString();
                                                    var updated = getdate(dt, days);
                                                    console.log(x);
                                                    console.log(updated);
                                                    var y = response['data']['available_courier_companies'][0]['rate'];
                                                    // document.getElementById("check_pincode_text").innerHTML = "Delivery by" + " " + '<span>' + x + '</span>' + " " + '<span> | ' + '₹' + '</span>' + y + '</span>';
                                                    document.getElementById("check_pincode_text").innerHTML = "Estimated Delivery by" + " " + '<span>' + updated + '</span>';
                                                    document.getElementById("check_pincode_text").style.color = "green";
                                                }
                                            });
                                        })
                                    }


                                }
                            })
                        } else {
                            var result = null;
                            var message = null;
                            var settings = {
                                "url": "https://apiv2.shiprocket.in/v1/external/courier/serviceability/",
                                "method": "GET",
                                "timeout": 0,
                                "headers": {
                                    "Content-Type": "application/json",
                                    "Authorization": "Bearer <?php echo !empty($_SESSION['modesy_sess_user_shiprocket_token']) ? $_SESSION['modesy_sess_user_shiprocket_token'] : ''; ?>"
                                },
                                "data": {
                                    "pickup_postcode": <?php echo $product->product_pincode; ?>,
                                    "delivery_postcode": $('#pin_text').val(),
                                    "cod": 0,
                                    "weight": <?php echo (floatval($product->weight) / 1000) ?>
                                },
                            };
                            $(document).ready(function() {
                                $.ajax(settings).done(function(response) {

                                    result = response;
                                    console.log(result);
                                    if (result['status'] == 404) {
                                        document.getElementById("check_pincode_text").innerHTML = "Delivery Pincode not Serviceable";
                                        document.getElementById("check_pincode_text").style.color = "red";
                                    } else if (result['status_code'] == 422) {
                                        document.getElementById("check_pincode_text").innerHTML = result.errors.delivery_postcode[0];
                                        document.getElementById("check_pincode_text").style.color = "red";
                                    } else {
                                        var days;
                                        if ("<?php echo $product->add_meet ?>" == "Made to order") {
                                            var transit = $('.lead_time').text();
                                            var str = transit.split(":")[1];
                                            var split = str.split(" ");
                                            var day = parseInt(split[0]) * 24 * 3600;
                                            var hours = parseInt(split[2]) * 3600;
                                            var tot_seconds = day + hours;
                                            days = ConvertSectoDay(tot_seconds);
                                            console.log(days);
                                        } else {
                                            days = "<?php echo check_for_days($product); ?>";
                                        }
                                        console.log(days);
                                        var x = response['data']['available_courier_companies'][0]['etd'];
                                        var dt = new Date(x);
                                        var dt_new_format = dt.toLocaleDateString();
                                        var updated = getdate(dt, days);
                                        console.log(x);
                                        console.log(updated);
                                        var y = response['data']['available_courier_companies'][0]['rate'];
                                        // document.getElementById("check_pincode_text").innerHTML = "Delivery by" + " " + '<span>' + x + '</span>' + " " + '<span> | ' + '₹' + '</span>' + y + '</span>';
                                        document.getElementById("check_pincode_text").innerHTML = "Estimated Delivery by" + " " + '<span>' + updated + '</span>';
                                        document.getElementById("check_pincode_text").style.color = "green";
                                    }
                                });
                            })
                        }


                    }
                }
            }
        })

    });

    function getDistance(delivery, pickup) {
        // var distanceService = new google.maps.DistanceMatrixService();
        // distanceService.getDistanceMatrix({
        //         origins: [delivery],
        //         destinations: [pickup],
        //         travelMode: google.maps.TravelMode.WALKING,
        //         unitSystem: google.maps.UnitSystem.METRIC,
        //         durationInTraffic: true,
        //         avoidHighways: false,
        //         avoidTolls: false
        //     },
        //     function(response, status) {
        //         if (status !== google.maps.DistanceMatrixStatus.OK) {
        //             console.log('Error:', status);
        //         } else {
        //             return response;
        //         }
        //     });

        var data = {
            "delivery": delivery,
            "pickup": pickup
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            url: base_url + "calulate-distance",
            type: "post",
            data: data,
            async: false,
            success: function(response) {
                return response;
            }
        })
    }
    $(document).on("click", ".btn-add-remove-wishlist", function() {
        var e = $(this).attr("data-product-id"),
            t = $(this).attr("data-reload");
        "0" == t &&
            ($(this).find("i").hasClass("icon-heart-o") ?
                ($(this).find("i").removeClass("icon-heart-o"),
                    $(this).find("i").addClass("icon-heart")) :
                ($(this).find("i").removeClass("icon-heart"),
                    $(this).find("i").addClass("icon-heart-o")));
        var a = {
            product_id: e,
            sys_lang_id: sys_lang_id
        };
        (a[csfr_token_name] = $.cookie(csfr_cookie_name)),
        $.ajax({
            type: "POST",
            url: base_url + "add-remove-wishlist-post",
            data: a,
            success: function(response) {
                var i = JSON.parse(response);
                if (i.is_active == "1") {
                    ($(".cart_a").append(),
                        $.notify({
                            title: "<strong></strong> ",
                            message: "Added To Wishlist",
                        }))
                }
            },
        });
    })
    $(document).on('click', '.product_detail1 button', function() {
            $('.product_detail1 button').removeClass('clicked');
            $(this).addClass('clicked');
        });
        
        $("#wishlist_btn").click(function() {
            $('#loginModal').modal('show');
            // alert("ok");
        })
</script>
<?php if (item_count($product_images) > 10) : ?>
    <style>
        .product-thumbnails-slider .slick-track {
            transform: none !important;
            display: block;
        }
    </style>
<?php endif; ?>