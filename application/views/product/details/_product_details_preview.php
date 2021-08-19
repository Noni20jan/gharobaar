<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDFvh43Z_rwc8tuVkvhBk59tBHiJ2YnKnM&callback=initAutocomplete&libraries=places&v=weekly" defer></script> -->


<style>
    .label {
        padding-right: 0px;
        margin-top: 10px;
        font-weight: bold;
    }

    .check-button {
        background: lightblue
    }

    .user-product-image {
        width: 70px;
        /* height: 50px; */
        border-radius: 56%;
        margin-top: -11px;
    }

    .rating-review {
        margin-right: 1px;
    }

    #buy_now {
        margin-right: 1px;
        width: 25%;
        margin-left: 10px;
    }

    .product_details {
        font-style: montserrat;
        ;
    }
</style>
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



        <div class="row-custom meta">
            <div class="row">
                <div class="col-sm-2">
                    <div class="product-details-user">
                        <img src="<?php echo get_user_logo($user); ?>" alt="<?php echo get_shop_name($user); ?>" class="user-product-image">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="product-details-user">
                        <div class="row">
                            <?php echo trans("seller"); ?> :&nbsp;<a href="<?php echo generate_profile_url($product->user_slug); ?>"><?php echo character_limiter(get_brand_name_product($product), 30, '..'); ?></a><br>
                        </div>
                        <div class="row">
                            <?php $this->load->view('partials/_review_stars', ['review' => $product->rating]); ?>
                            <span>(<?php echo $review_count; ?>)</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <?php if ($product->status == 0 && $product->is_draft == 1) : ?>
                        <label class="badge badge-warning badge-product-status pull-right">Draft</label>
                    <?php elseif ($product->status == 0) : ?>
                        <label class="badge badge-warning badge-product-status pull-right"><?php echo trans("pending"); ?></label>
                    <?php elseif ($product->visibility == 0) : ?>
                        <label class="badge badge-danger badge-product-status pull-right"><?php echo trans("hidden"); ?></label>
                    <?php endif; ?>
                </div>
            </div><br>


            <!-- <div class="rating-review">
                <?php if ($this->general_settings->product_comments == 1) : ?>
                    <span><i class="icon-comment"></i><?php echo html_escape($comment_count); ?></span>
                <?php endif; ?>
                <?php if ($this->general_settings->reviews == 1) : ?>

                <?php endif; ?>
                <span><i class="icon-heart"></i><?php echo get_product_wishlist_count($product->id); ?></span>
                <span><i class="icon-eye"></i><?php echo html_escape($product->pageviews); ?></span>
            </div> -->


        </div>
        <h1 class="product-title"><?= html_escape($product_details->title); ?></h1>
        <div class="row-custom price">
            <div id="product_details_price_container" class="d-inline-block">
                <?php $this->load->view("product/details/_price_preview", ['product' => $product, 'price' => $product->price, 'discount_rate' => $product->discount_rate]); ?>
                <?php if ($product->listing_type == 'ordinary_listing' && $product->stock < 1) : ?>
                    <strong class="lbl-sold"><?= trans("sold"); ?></strong>
                <?php endif; ?>
            </div>
        </div>

        <div class="row-custom details">
            <?php if ($product->listing_type != 'ordinary_listing' && $product->product_type != 'digital' && $product->is_service != '1') : ?>
                <div class="item-details">
                    <div class="left">
                        <label><?php echo trans("status"); ?></label>
                    </div>
                    <div id="text_product_stock_status" class="right">
                        <?php if (check_product_stock($product)) : ?>
                            <span class="status-in-stock text-success"><?php echo trans("in_stock") ?></span>
                        <?php else : ?>
                            <span class="status-in-stock text-danger"><?php echo trans("out_of_stock") ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else : ?>
                <div class="item-details">
                    <div class="left">
                        <label><?php echo trans("status"); ?></label>
                    </div>
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


        <!-- <?php echo form_open(get_product_form_data($product, $user)->add_to_cart_url, ['id' => 'form_add_cart']); ?>
        <input type="hidden" name="product_id" value="<?php echo $product->id; ?>"> -->

        <div>
            <div class="col-12">
                <div class="row-custom product-variations">
                    <div class="row row-product-variation item-variation">
                        <?php if (!empty($full_width_product_variations)) :
                            foreach ($full_width_product_variations as $variation) :
                                $this->load->view('product/details/_product_variations', ['variation' => $variation]);
                            endforeach;
                        endif;
                        if (!empty($half_width_product_variations)) :
                            foreach ($half_width_product_variations as $variation) :
                                $this->load->view('product/details/_product_variations', ['variation' => $variation]);
                            endforeach;
                        endif; ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12"><?php $this->load->view('product/details/_messages'); ?></div>

        <div>
            <div class="col-12 product-add-to-cart-container">
                <?php if ($product->listing_type != 'ordinary_listing' && $product->product_type != 'digital' && $product->is_service != '1') : ?>
                    <div class="number-spinner">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button type="button" disabled class="btn btn-default btn-spinner-minus" style="margin-top: -8px;" data-dir="dwn">-</button>
                            </span>
                            <input type="text" class="form-control text-center" name="product_quantity" value="1">
                            <span class="input-group-btn">
                                <button type="button" disabled class="btn btn-default btn-spinner-plus" style="margin-top: -8px;" data-dir="up">+</button>
                            </span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="button-container button-container-wishlist">
                <?php
                $whislist_button_class = "";
                $whislist_button_class = (empty($product->demo_url) && $product->listing_type == 'ordinary_listing') ? "btn-wishlist-classified" : "";
                if ($this->product_model->is_product_in_wishlist($product->id) == 1) : ?>
                    <a href="javascript:void(0)" class="btn-wishlist" id="" <?php echo $whislist_button_class; ?>" data-product-id="<?php echo $product->id; ?>" data-reload="1"><i class="icon-heart"></i><span><?php echo trans("remove_from_wishlist"); ?></span></a>
                <?php else : ?>
                    <!-- <div class="btn btn-md btn-custom" id="buy_now">Buy Now</div> -->
                    <a href="javascript:void(0)" class="btn-wishlist <?php echo $whislist_button_class; ?>" data-product-id="<?php echo $product->id; ?>" data-reload="1"><i class="icon-heart-o"></i><span><?php echo trans("add_to_wishlist"); ?></span></a>
                <?php endif; ?>
            </div>
        </div>

        <div class="row" style="width: 100%;">
            <div class="col-6">
                <button style="float:left;width: 100%;" class="btn btn-md btn-block btn-product-cart"><i class="icon-cart-solid"></i><?php echo trans("add_to_cart") ?></button>
            </div>
            <div class="col-6">
                <button style="float:right;width:100%" class="btn btn-md btn-block"><?php echo trans("buy_now"); ?></button>
            </div>
        </div>


        <!-- <?php if (!empty($product->demo_url)) : ?>
            <div class="col-12 product-add-to-cart-container">
                <div class="button-container">
                    <a href="<?php echo $product->demo_url; ?>" target="_blank" class="btn btn-md btn-live-preview"><i class="icon-preview"></i><?php echo trans("live_preview") ?></a>
                </div>
            </div>
        <?php endif; ?> -->

    </div>
    <!-- <?php echo form_close();
            if ($this->auth_check) : ?>
        <?php if ($user->role == "vendor" && $product->available_for_barter == "Y" && $product->user_id != $this->auth_user->id) { ?>
            <a href="<?php echo generate_barterproduct_url($product); ?>">
                <button class="btn btn-md btn-block btn-product-cart">Available for barter</button>
            </a>
    <?php }
            endif; ?> -->

</div>

<script>
    function initAutocomplete() {
        // Create the search box and link it to the UI element.
        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);

        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }
            places.forEach((place) => {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                console.log('{latitude:' + place.geometry.location.lat() + ',longitude:' + place.geometry.location.lng() + '}');
            });
        });
    }
    // });
</script>

<script>
    function buynow(pro_id) {
        $("#form_validate").validate();
        $("#form_validate_service").validate();
        $("#form_validate_search").validate();
        $("#form_validate_search_mobile").validate();
        $("#form_validate_newsletter").validate();
        $("#form_add_cart").validate();
        $("#form_validate_checkout").validate();
        $("#form_add_cart").submit(function() {
            $("#form_add_cart .custom-control-variation input").each(function() {
                if ($(this).hasClass("error")) {
                    var a = $(this).attr("id");
                    $("#form_add_cart .custom-control-variation label").each(function() {
                        if ($(this).attr("for") == a) {
                            $(this).addClass("is-invalid")
                        }
                    })
                } else {
                    var a = $(this).attr("id");
                    $("#form_add_cart .custom-control-variation label").each(function() {
                        if ($(this).attr("for") == a) {
                            $(this).removeClass("is-invalid")
                        }
                    })
                }
            })
        });
    }
</script>