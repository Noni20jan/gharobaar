<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDFvh43Z_rwc8tuVkvhBk59tBHiJ2YnKnM&callback=initAutocomplete&libraries=places&v=weekly" defer></script> -->
<script src="<?php echo base_url(); ?>assets/js/bootstrap-notify.js"></script>

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

    @media(max-width:700px) {
        .number-spinner {
            width: 100px;
            height: 44px;
            border: 1px solid #e4e4e4;
            background: #fff;
        }
    }

    .rating-review {
        margin-left: 80%;
        margin-top: -7%;
        color: gray;
    }

    #buy_now {
        margin-right: 1px;
        width: 25%;
        margin-left: 10px;
    }

    .check_for_pincode {
        background-color: #DF911E;
        color: #fff;
        border-radius: 25px;
        width: 16%;
        border: none;
    }

    @media only screen and (max-width: 700px) {
        .check_for_pincode {
            background-color: #DF911E;
            color: #fff;
            border-radius: 25px;
            width: 15%;
            border: none;
        }
    }

    @media(max-width:768px) {
        #product-user-img {
            margin-top: 6%;
        }

        .rating-review {
            margin-left: 72%;
            margin-top: -7%;
            color: gray;
        }

        .spinner-width {
            width: 84% !important;
            left: 0 !important;
        }
    }

    @media(max-width:1073px) {
        #postal-code {
            margin-top: 5% !important;
            margin-left: 4% !important;
        }
    }

    #postal-code {
        margin-top: 3%;
        margin-left: 4%;
    }

    #check-button {
        margin-left: 2%;
        background-color: #007C05 !important;
        color: #fff;
        border-radius: 20px !important;
        font-size: 12px;
        font-weight: bold;
    }

    #transit {
        position: relative;
    }

    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0;
    }

    .fa+.sr-only {
        padding: 0.25em;
        margin: 0;
        color: #000;
        background: #eee;
        border: 1px solid #ccc;
        border-radius: 2px;
        font: 11px sans-serif;
        z-index: 2;
    }

    #transit:focus .fa+.sr-only,
    #transit:hover .fa+.sr-only {
        clip: auto;
        width: auto;
        height: auto;
        bottom: 100%;
        left: 100%;
    }

    .for-height {
        height: calc(1.5em + 0.75rem + 2px);
    }

    .number-spinner {
        background-color: #ffffff;
    }

    .spinner-width {
        width: 100%;
    }

    .product-details-review {
        margin-left: 0 !important;
    }

    @media(max-width:768px) {
        .product-details-review {
            margin-left: 15px !important;
        }

    }

    /* .quantity_margin{
        margin-bottom: -13px !important;
    } */
</style>
<?php //var_dump($product);
// die();
?>
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
        <h1 class="product-title"><?= html_escape($product_details->title); ?></h1>
        <div class="row-custom meta">
            <div class="row">
                <div class="col-sm-4">
                    <div class="product-details-user">
                        By&nbsp;<a href="<?php echo generate_profile_url($product->user_slug); ?>"><?php echo character_limiter(ucfirst(get_brand_name_product($product)), 30, '..'); ?></a><br>
                    </div>
                </div>
                <div class="product-details-review">
                    <?php if ($this->general_settings->reviews == 1) {
                        $this->load->view('partials/_review_stars', ['review' => $product->rating]);
                        $count_star = $this->review_model->get_review_count($product->id); ?>
                        <span><b> (<?php echo $count_star; ?>)</b> </span>
                    <?php  } ?>
                </div>
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


        <!-- <?php echo form_open(get_product_form_data($product, $user)->add_to_cart_url, ['id' => 'form_add_cart']); ?> -->
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
                if ($parent_categories_tree[0]->id == 2) :
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




            <!-- <div class="row">

            <?php
            $whislist_button_class = "";
            $whislist_button_class = (empty($product->demo_url) && $product->listing_type == 'ordinary_listing') ? "btn-wishlist-classified" : "";
            if ($this->product_model->is_product_in_wishlist($product->id) == 1) : ?>
                <a href="javascript:void(0)" class="btn-wishlist btn-add-remove-wishlist" id="" <?php echo $whislist_button_class; ?>" data-product-id="<?php echo $product->id; ?>" data-reload="1"><i class="icon-heart"></i></a>
            <?php else : ?>
                <div class="btn btn-md btn-custom" id="buy_now">Buy Now</div>
                <a href="javascript:void(0)" class="btn-wishlist btn-add-remove-wishlist <?php echo $whislist_button_class; ?>" data-product-id="<?php echo $product->id; ?>" data-reload="1"><i class="icon-heart-o"></i></a>
            <?php endif; ?>

        </div> -->

            <div class="row">
                <?php $buttton = get_product_form_data($product, $user)->button;
                $buttton2 = get_product_form_data($product, $user)->button2;
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

            <?php echo form_close(); ?>
    </div>
</div>


<?php $this->load->view("product/details/_product_share"); ?>

<?php if ($this->auth_check) : ?>
    <?php if ($user->role == "vendor" && $product->available_for_barter == "Y" && $product->user_id != $this->auth_user->id) { ?>
        <a href="<?php echo generate_barterproduct_url($product); ?>">
            <!-- <button class="btn btn-md btn-block btn-product-cart">Available for barter</button> -->
        </a>
<?php }
endif; ?>

<script type="text/javascript">
    function quantity(qty) {
        var stock = document.getElementById('product_variation_stock').value;
        if (qty == parseInt(stock)) {
            return true;
        } else {
            return false;
        }
    }

    $("#pin_text").change(function() {
        document.getElementById("check_pincode_text").innerHTML = "";
    });

    function valid() {
        var pin = document.getElementById("pin_text");
        var pin_code = document.getElementById("pin_text").value;
        var length1 = pin_code.length;
        if (length1 < 6) {
            document.getElementById("check_pincode_text").style.color = "red";
            document.getElementById("check_pincode_text").innerHTML = "Pin code should be 6 digits !";
            // console.log("pin_code");
            pin.focus();
            return false;
        }
    }
</script>

<script>
    $("#plus-btn").click(function() {
        var qty = parseInt($("#product_quantity").val());
        var res_qty = quantity(qty);
        if (res_qty == true) {
            $('#product_quantity').val(qty - 1);
            $("#no_stock_id").html("No more stock to add");
        }
        if (("<?php $this->auth_check ?>") != '') {
            document.getElementById("check_pincode_text").innerHTML = "";
        }
        var qty = parseInt($("#product_quantity").val());
        var stock = parseInt("<?php echo $product->stock; ?>");
        if (stock > qty && stock != 0) {
            var transit = '<?php echo get_transit_time_for_made_to_order($product, "time"); ?>';
            // console.log(parseInt(transit));
            if ("<?php echo $product->add_meet ?>" == "Made to order") {
                "<?php $home_cook = get_parent_categories_tree($product->category_id); ?>";
                var homeCook = "<?php echo $home_cook[0]->id; ?>";
                if (parseInt(homeCook) == 2) {
                    qty += 1;
                    transit = '<?php echo get_transit_time_for_home_cook($product, "time"); ?>';
                    // console.log(parseInt(transit));
                    var sale_count = "<?php echo get_sale_count_as_per_incomplete_status($product->id); ?>";
                    var order_capacity = "<?php echo $product->order_capacity ?>";
                    var current_order_capacity = (parseInt(sale_count) % parseInt(order_capacity));
                    current_order_capacity += parseInt(qty);
                    var current_order_capacity_rem = (parseInt(current_order_capacity) % parseInt(order_capacity));
                    var current_order_capacity_ratio = parseInt(parseInt(current_order_capacity) / parseInt(order_capacity));
                    console.log(current_order_capacity);
                    // if (current_order_capacity_rem == 0) {
                    // var total_lead_time = (parseInt(qty)) * (parseInt(lead_time));
                    var total = parseInt(transit) + (86400 * current_order_capacity_ratio);
                    var date_time = ConvertSectoDay(total);
                    // console.log(total);
                    console.log(date_time);
                    $('.lead_time').html(":" + date_time);
                    // current_order_capacity = 0;
                    // }



                } else {
                    var lead_time = "<?php echo get_lead_time_hours($product); ?>";
                    var total_lead_time = (parseInt(qty)) * (parseInt(lead_time));
                    var total = parseInt(transit) + total_lead_time;
                    var date_time = ConvertSectoDay(total);
                    console.log(total);
                    console.log(date_time);
                    $('.lead_time').html(":" + date_time);
                }
            }
        }
    });

    $("#minus-btn").click(function() {
        if (("<?php $this->auth_check ?>") != '') {
            document.getElementById("check_pincode_text").innerHTML = "";
        }
        var qty = parseInt($("#product_quantity").val());

        var stock = parseInt("<?php echo $product->stock; ?>");
        if (qty <= stock) {
            $("#no_stock_id").html("");
        }
        if (qty > 1 && stock > 0) {
            var transit = '<?php echo get_transit_time_for_made_to_order($product, "time"); ?>';
            // console.log(parseInt(transit));
            if ("<?php echo $product->add_meet ?>" == "Made to order") {
                "<?php $home_cook = get_parent_categories_tree($product->category_id); ?>";
                var homeCook = "<?php echo $home_cook[0]->id; ?>";
                if (parseInt(homeCook) == 2) {
                    qty -= 1;
                    console.log(qty);
                    transit = '<?php echo get_transit_time_for_home_cook($product, "time"); ?>';
                    // console.log(parseInt(transit));
                    var sale_count = "<?php echo get_sale_count_as_per_incomplete_status($product->id); ?>";
                    var order_capacity = "<?php echo $product->order_capacity ?>";
                    var current_order_capacity = (parseInt(sale_count) % parseInt(order_capacity));
                    current_order_capacity += parseInt(qty);
                    current_order_capacity_rem = (parseInt(current_order_capacity) % parseInt(order_capacity));
                    var current_order_capacity_ratio = parseInt(parseInt(current_order_capacity) / parseInt(order_capacity));
                    console.log(current_order_capacity);
                    // if (current_order_capacity_rem == 0) {
                    // var total_lead_time = (parseInt(qty)) * (parseInt(lead_time));
                    var total = parseInt(transit) + (86400 * current_order_capacity_ratio);
                    var date_time = ConvertSectoDay(total);
                    if (qty == 1) {
                        date_time = ConvertSectoDay(parseInt(transit));
                    }
                    // console.log(total);
                    console.log(date_time);
                    $('.lead_time').html(":" + date_time);
                    // current_order_capacity = 0;
                    // }
                } else {
                    var transit = $('.lead_time').text();
                    var y = transit.split(":")[1];
                    var split = y.split(" ");
                    var days = parseInt(split[0]) * 24 * 3600;
                    var hours = parseInt(split[2]) * 3600;
                    var tot_seconds = days + hours;
                    if ("<?php echo $product->add_meet ?>" == "Made to order") {
                        var lead_time = "<?php echo get_lead_time_hours($product); ?>";
                    }
                    var total = tot_seconds - parseInt(lead_time);
                    var date_time = ConvertSectoDay(total);
                    $('.lead_time').html(":" + date_time);
                    console.log(total);
                    console.log(date_time);
                }
            }
        }
    });

    function ConvertSectoDay(n) {
        var day = parseInt(n / (24 * 3600));
        n = n % (24 * 3600);
        var hour = parseInt(n / 3600);
        n %= 3600;
        var minutes = n / 60;
        n %= 60;
        var seconds = n;
        return day + " " + "days " + hour + " " + "hours ";
    }

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
<script>
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

    function getdate(dt, days) {
        var date = new Date(dt);
        var day = parseInt(days);

        date.setDate(date.getDate() + day);

        var month = new Array();
        month[0] = "January";
        month[1] = "February";
        month[2] = "March";
        month[3] = "April";
        month[4] = "May";
        month[5] = "June";
        month[6] = "July";
        month[7] = "August";
        month[8] = "September";
        month[9] = "October";
        month[10] = "November";
        month[11] = "December";

        var dd = date.getDate();
        var mm = month[date.getMonth()];
        var y = date.getFullYear();

        var someFormattedDate = mm + ' ' + dd + ',' + y;
        return someFormattedDate;
    }
</script>

<script>
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
    // })
</script>

<script>
    $("#wishlist_btn").click(function() {
        $('#loginModal').modal('show');
        // alert("ok");
    })
</script>