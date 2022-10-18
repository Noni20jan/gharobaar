<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
    .zoom {
        transition: transform .2s;
    }

    #cvl {
        position: absolute;

        left: 114px;

        float: right;
        color: #fff;
        background-color: red;
    }

    .quick-view-options {
        width: auto;
        height: auto;
        position: absolute;
        top: 217px;
        right: 6.2rem;
        text-align: left;
    }

    .auth-box1 {
        background-color: white;
        padding: 30px;
        /* width: 1000px; */
        /* width: 459px; */
        /* max-width: 100%; */
        border-radius: 20px;
        /* margin: 0 auto; */
        /* margin-top: 30px; */
        border: 1px solid #f5f5f5;
        box-shadow: 0 5px 10px 0 rgba(0, 0, 0, .1);
        -moz-box-shadow: 0 5px 10px 0 rgba(0, 0, 0, .1);
        -webkit-box-shadow: 0 5px 10px 0 rgba(0, 0, 0, .1);
        -o-box-shadow: 0 5px 10px 0 rgba(0, 0, 0, .1);
        -ms-box-shadow: 0 5px 10px 0 rgba(0, 0, 0, .1)
    }


    .field-icon {
        float: right;
        padding: 0px 5px;
        margin-right: 8px;
        margin-top: 0px;
        position: relative;
        z-index: 2;
        cursor: pointer;
    }

    .quick-view-options .item-option {
        display: block;
        position: relative;
        right: 10px;
        width: 80px;
        height: 38px;
        line-height: 40px;
        text-align: center;
        background-color: rgba(0, 0, 0, 0.18);
        color: #fff;
        border-radius: 10%;
        font-size: 10px;
        margin-bottom: 10px;
        opacity: 0;
        -webkit-transition: all 0.2s ease-out;
        -moz-transition: all 0.2s ease-out;
        -ms-transition: all 0.2s ease-out;
        -o-transition: all 0.2s ease-out;
        transition: all 0.2s ease-out;
    }

    .product-item:hover .quick-view-options .item-option {
        opacity: 1;
    }


    @media(max-width:700px) {
        #cvl {
            position: absolute;
            font-weight: 400;
            left: 60px;
            float: right;
            color: #fff;
            background-color: red;
        }
    }

    .zoom:hover {
        -ms-transform: scale(1.25);
        /* IE 9 */
        -webkit-transform: scale(1.25);
        /* Safari 3-8 */
        transform: scale(1.25);
    }

    .icon-check {
        color: #90EE90;
    }
</style>
<?php //if ($product->add_meet == "Made to stock") : 
?>
<?php $variation = $this->variation_model->get_product_variations($product->id);

if (!empty($variation)) { ?>

    <?php $variations_stock = 0; //var_dump($variation);
    foreach ($variation as $variations) :
        $variation_option = $this->variation_model->get_variation_options($variations->id);

        foreach ($variation_option as $variation_stock) :
            $variations_stock = $variations_stock + $variation_stock->stock;

        endforeach;
    endforeach; ?>
<?php } ?>
<?php //endif; 
?>
<!-- <span itemscope itemtype="http://schema.org/Product" class="microdata">
    <meta itemprop="image" content="test.png">
    <meta itemprop="name" content="Example Test">
    <meta itemprop="description" content="This is just a boring example">
    <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
        <meta itemprop="price" content="119.99">
        <meta itemprop="priceCurrency" content="USD">
    </span>
</span> -->
<div class="product-item" itemscope itemtype="http://schema.org/Product">
    <div class=" row-custom<?php echo (!empty($product->image_second)) ? ' product-multiple-image' : ''; ?>">
        <a class="item-wishlist-button item-wishlist-enable <?php echo (is_product_in_wishlist($product) == 1) ? 'item-wishlist' : ''; ?>" data-product-id="<?php echo $product->id; ?>"></a>
        <div class="img-product-container">
            <?php if (!empty($is_slider)) : ?>
                <a href="<?php echo generate_product_url($product); ?>">
                    <img itemprop="image" src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-lazy="<?php echo get_product_item_image($product); ?>" alt="<?php echo get_product_title($product); ?>" class="img-fluid img-product">
                    <?php if (!empty($product->image_second)) : ?>
                        <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-lazy="<?php echo get_product_item_image($product, true); ?>" alt="<?php echo get_product_title($product); ?>" class="img-fluid img-product img-second">
                    <?php endif; ?>
                </a>
            <?php else : ?>
                <a href="<?php echo generate_product_url($product); ?>">
                    <img itemprop="image" src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_product_item_image($product); ?>" alt="<?php echo get_product_title($product); ?>" class="lazyload img-fluid img-product">
                    <?php if (!empty($product->image_second)) : ?>
                        <img src="<?php echo base_url() . IMG_BG_PRODUCT_SMALL; ?>" data-src="<?php echo get_product_item_image($product, true); ?>" alt="<?php echo get_product_title($product); ?>" class="lazyload img-fluid img-product img-second">
                    <?php endif; ?>
                </a>
            <?php endif; ?>
            <?php if ($product->add_meet == "Made to order" && get_vendor_shop_status($product->user_id) != 0) : ?>
                <span class="made_to_order">MADE TO ORDER</span>
            <?php endif; ?>
            <?php if ($product->add_meet == "Made to stock" &&  $product->stock > 0 && intval($product->shipping_time == 1) && get_vendor_shop_status($product->user_id) != 0) : ?>
                <span class="made_to_order">NEXT DAY DISPATCH</span>
            <?php endif; ?>
            <?php if (!empty($this->auth_check) && $this->auth_user->role == "vendor" && $product->user_id == $this->auth_user->id) : ?>
                <!-- <div class="cart-top">
                    <a href="javascript:void(0)" class="item-options btn-add-to-cart" data-toggle="tooltip" data-placement="left" data-product-id="<?php echo $product->id; ?>" data-reload="0" title="<?php echo trans("add_to_cart"); ?>">
                        <i class="icon-cart"></i>
                    </a>
                </div> -->
            <?php else : ?>
                <div class="cart-top">
                    <?php $disabled = "";
                    if (empty($variation)) { ?>
                        <?php if (check_product_stock($product)) {
                            $disabled = " disabled"; ?>

                            <a href="javascript:void(0)" class="item-options btn-add-to-cart zoom" data-placement="left" data-product-id="<?php echo $product->id; ?>" data-reload="0" title="<?php echo trans("add_to_cart"); ?>">
                                <i class="icon-cart cart-size"></i>
                            </a>
                        <?php } ?>
                    <?php } else { ?>
                        <?php if ($variations_stock != 0) { ?>
                            <a href="javascript:void(0)" class="item-options btn-add-to-cart zoom" data-placement="left" data-product-id="<?php echo $product->id; ?>" data-reload="0" title="<?php echo trans("add_to_cart"); ?>">
                                <i class="icon-cart cart-size"></i>
                            </a>
                        <?php } ?>
                    <?php } ?>

                </div>
            <?php endif; ?>


            <?php if (!empty($this->auth_check) && $this->auth_user->role == "vendor" && $product->user_id == $this->auth_user->id) : ?>
            <?php else : ?>
                <div class="quick-view-options">
                    <?php $disabled = "";
                    if (empty($variation)) { ?>
                        <?php if (check_product_stock($product)) {
                            $disabled = " disabled"; ?>

                            <a href="javascript:void(0)" id="quickview" class="item-option zoom" data-placement="left" data-product-id="<?php echo $product->id; ?>" data-reload="0" title="<?php echo trans("view"); ?>">
                                <i class="button field-icon openBtn" id="view" value="<?php echo $product->id; ?>" data-toggle="modal" data-target="#quick_<?php echo $product->id ?>">QUICK VIEW</i>
                            </a>
                        <?php } ?>
                    <?php } else { ?>
                        <?php if ($variations_stock != 0) { ?>
                            <a href="javascript:void(0)" id="quickview" class="item-option zoom" data-placement="left" data-product-id="<?php echo $product->id; ?>" data-reload="0" title="<?php echo trans("view"); ?>">
                                <i class="button field-icon openBtn" id="view" value="<?php echo $product->id; ?>" data-toggle="modal" data-target="#quick_<?php echo $product->id ?>">QUICK VIEW</i>
                            </a>

                        <?php } ?>
                    <?php } ?>

                </div>
            <?php endif; ?>


            <!-- <div class="quick-view-options">
                    <a href="javascript:void(0)" id="quickview" class="item-option zoom" data-placement="left" data-product-id="<?php // echo $product->id; 
                                                                                                                                ?>" data-reload="0" title="<?php //echo trans("view"); 
                                                                                                                                                            ?>" data-toggle="modal" data-target="#quickModal">
                        <i class="button field-icon openBtn" id="view" name="<?php // echo $product->id;
                                                                                ?>" value="<?php //echo $product->id; 
                                                                                            ?>" onclick="quickView()";>QUICK VIEW</i>
                        
                    </a>
                </div> -->
            <?php if (empty($variation)) { ?>
                <?php if (!check_product_stock($product)) {
                    if ($product->add_meet == "Made to stock") :
                ?>
                        <span class="badge badge-dark badge-promoted" id="cvl">Out Of Stock</span>
                    <?php else : ?>
                        <span class="badge badge-dark badge-promoted" id="cvl">Not Available</span>
                <?php endif;
                } ?>
            <?php } else { ?>
                <?php if ($variations_stock == 0) {
                    if ($product->add_meet == "Made to stock") :
                ?>
                        <span class="badge badge-dark badge-promoted" id="cvl">Out Of Stock</span>
                    <?php else : ?>
                        <span class="badge badge-dark badge-promoted" id="cvl">Not Available</span>
                <?php endif;
                } ?>
            <?php } ?>
            <?php if (get_vendor_shop_status($product->user_id) == 0) : ?>

                <span class="badge badge-dark badge-promoted" id="cvl">Shop Closed</span>
            <?php else : ?>


                <span class="badge badge-dark badge-promoted" style="display:none"></span>
            <?php endif; ?>

            <div class="product-item-options">
                <?php if ($this->auth_check) : ?>
                    <?php if ($this->auth_user->user_type != "guest") : ?>
                        <a href="javascript:void(0)" class="item-option btn-add-remove-wishlist zoom whishlist-position" onclick="wishlist_login();" data-toggle="tooltip" data-placement="left" data-product-id="<?php echo $product->id; ?>" data-reload="0" title="<?php echo trans("wishlist"); ?>">
                            <?php if (is_product_in_wishlist($product) == 1) : ?>
                                <i class="icon-heart "></i>
                            <?php else : ?>
                                <i class="icon-heart-o"></i>
                            <?php endif; ?>
                        </a>
                    <?php else : ?>
                        <!-- hide wishlist for guest user -->
                        <a href="javascript:void(0)" class="item-option zoom whishlist-position" data-toggle="modal" data-id="0" data-target="#registerModal" title="<?php echo trans("wishlist"); ?>">
                            <?php if (is_product_in_wishlist($product) == 0) : ?>

                                <i class="icon-heart-o"></i>
                            <?php endif; ?>
                            <!-- <li class=" icon-bg">
                            <a href="<?php echo generate_url("wishlist") . "/" . $this->auth_user->slug; ?>">
                                <i class="icon-heart-o"></i>
                            </a>
                            </li> -->
                        <?php endif; ?>
                    <?php else : ?>
                        <a href="javascript:void(0)" class="item-option btn-add-remove-wishlist zoom whishlist-position" onclick="wishlist_login();" data-toggle="tooltip" data-placement="left" data-product-id="<?php echo $product->id; ?>" data-reload="0" title="<?php echo trans("wishlist"); ?>">
                            <i class="icon-heart-o"></i>
                        <?php endif; ?>
            </div>


        </div>
        <!-- <?php if ($product->is_promoted && $this->general_settings->promoted_products == 1 && isset($promoted_badge) && $promoted_badge == true) : ?>
            <span class="badge badge-dark badge-promoted"><?php echo trans("featured"); ?></span>
        <?php endif; ?> -->
    </div>

    <div class="row-custom item-details">
        <h3 class="product-title">
            <a href="<?php echo generate_product_url($product); ?>"><?= get_product_title($product); ?></a>
        </h3>
        <p class="product-user text-truncate">
            <a href="<?php echo generate_profile_url_by_id($product->user_id); ?>">
                <?php echo ucfirst(get_brand_name_product($product)); ?>

            </a>
        </p>
        <div class="item-meta">
            <?php $this->load->view('product/_price_product_item', ['product' => $product]); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="quick_<?php echo $product->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="width:120%; height:80%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Quick View</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="icon-close"></i>
                    <!-- <span aria-hidden="true">&times;</span> -->
                </button>
            </div>
            <div class="modal-body">
                <?php $this->load->view('product/details/product_preview', ['product' => $product]); ?>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<!-- 
<div class="gg" style="height: 700px;width: 700px;" id="pp" >
    <?php //$bb=$this->product_model->get_quick_view_data($product->id); 
    ?>
    <?php //$product_details=$this->product_model->get_product_details($product->id,$this->selected_lang->id, true);
    ?>
    <?php //$this->load->view('product/details/product_preview' , ['product' => $product]); 
    ?> 
</div> -->

<script>
    function wishlist_login() {
        $(this).find('i').toggleClass('icon-heart-o')
        $('#loginModal').modal('show');
    }
</script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-notify.js"></script>
<script>
    // function quickView(id) {
    //     var a = document.getElementById('pp');
    //     $('#pp').show();

        // a[csfr_token_name] = $.cookie(csfr_cookie_name);
        // $.ajax({
        //     type: "POST",
        //     url: base_url + "home_controller/get_product_details",
        //     data: a,
        //     success: function(response){
        //         console.log(response);
        //         if(response.empty=="true"){
        //             $('#quickModal').modal('show');
        //         }
        //         else{
        //             $.notify({
        //                 title: "<strong></strong>",
        //                 message: "Error",
        //             })
        //         }
        //     }
        // })
    // }
</script>