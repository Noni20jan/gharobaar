<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style>
    .star-rating {
        direction: rtl;
        display: inline-block;
        padding: 20px
    }

    .question {
        position: relative;
        left: 19px;
    }

    @media(max-width:700px) {
        .question {
            position: relative;
            left: 14px;
        }
    }


    .ask-seller {
        color: blue;
        text-decoration: underline;
        cursor: pointer;


    }

    @media(max-width:700px) {
        .ask-seller {
            color: blue;
            text-decoration: underline;
            cursor: pointer;
            position: relative;

        }
    }

    .ask-seller:active,
    .ask-seller:focus {
        color: blue;
        text-decoration: underline;
        cursor: pointer;

    }

    .ask-seller:hover {
        color: blue;
        text-decoration: underline;
        cursor: pointer;

    }

    #check_pincode {
        position: absolute;
        background-color: green;
        color: #fff;
        border: none;
        top: 12px;
        left: 86%;
        font-weight: bold;
    }

    #messageModal .modal-content {
        position: relative;
        display: -ms-flexbox;
        /* display: flex; */
        -ms-flex-direction: column;
        /* flex-direction: column; */
        width: 100%;
        pointer-events: auto;
        background-color: #fff;
        background-clip: padding-box;
        /* border: 1px solid rgba(0, 0, 0, 0.2); */
        border-radius: 0.3rem;
        outline: 0;
    }

    .seller {
        width: 100%;
        height: 100px;
        /* border-width: 1px; */
        border-color: #aaaaaa;
        /* padding: 1px 45px; */
        border-style: solid;
        background-color: white;
        font-size: 13px;
        font-family: "Georgia";
    }


    .star-rating input[type=radio] {
        display: none
    }

    .star-rating label {
        color: #bbb;
        font-size: 18px;
        padding: 0;
        cursor: pointer;
        -webkit-transition: all .3s ease-in-out;
        transition: all .3s ease-in-out
    }

    .star-rating label:hover,
    .star-rating label:hover~label,
    .star-rating input[type=radio]:checked~label {
        color: #f2b600
    }

    /* explanation */

    article {
        background-color: #ffe;
        box-shadow: 0 0 1em 1px rgba(0, 0, 0, .25);
        color: #006;
        font-family: cursive;
        font-style: italic;
        /* margin: 4em;
        max-width: 30em;
        padding: 2em; */
    }

    *,
    ::after,
    ::before {
        box-sizing: border-box;
    }

    user agent stylesheet table {
        display: table;
        border-collapse: separate;
        box-sizing: border-box;
        text-indent: initial;
        border-spacing: 2px;
        border-color: grey;
    }

    body {
        font-family: "Open Sans", Helvetica, sans-serif;
    }

    body {
        font-size: .875rem;
        font-weight: normal;
        font-style: normal;
        color: #222 !important;
        font-family: 'Open Sans', Helvetica, Arial, sans-serif;
        overflow-x: hidden !important;
    }

    body {
        margin: 0;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        /* font-size: 1rem; */
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: left;
        background-color: #fff;
    }

    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    .comparison_table_first_col {
        width: 14.28% !important;
    }

    .comparison_attribute_name_column {
        padding-left: 10px;
    }

    td,
    th {
        padding: 3px;
    }

    th {
        text-align: left;
    }

    td,
    th {
        vertical-align: top;
    }

    * {
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    user agent stylesheet th {
        display: table-cell;
        vertical-align: inherit;
        font-weight: bold;
        text-align: -internal-center;
    }

    table.a-bordered {
        margin-bottom: 22px;
        border: 1px solid #e7e7e7;
        border-top-color: #eaeaea;
        border-bottom: none;
        border-spacing: 0;
    }

    .a-size-base {
        font-size: 14px !important;
        line-height: 20px !important;
    }

    table {
        margin-bottom: 18px;
        border-collapse: collapse;
        width: 100%;
    }

    user agent stylesheet table {
        border-collapse: separate;
        text-indent: initial;
        border-spacing: 2px;
    }

    HLCXComparisonTable.in-comparison-table {
        table-layout: fixed;
        width: 100%;
        margin-bottom: 0;
    }

    table {
        margin-bottom: 18px;
        border-collapse: collapse;
        width: 100%;
    }

    * {
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    user agent stylesheet table {
        display: table;
        border-collapse: separate;
        box-sizing: border-box;
        text-indent: initial;
        border-spacing: 2px;
        border-color: grey;
    }

    #review-btn {
        width: 40%;
        margin-left: 5%;
    }



    #reviewbutton {
        width: 47%;
    }

    @media(max-width:768px) {

        #reviewbutton {
            width: 47%;
            padding: 2%;
        }

    }

    #offers {
        background-color: #ffffff82;
        padding: 3%;
        border-radius: 2em;
        width: 515px;
        height: 142px;
        margin-left: 6%;
    }

    @media(max-width:1073px) {

        #offers {
            background-color: #ffffff82;
            padding: 3%;
            border-radius: 2em;
            width: 89%;
            margin-left: 5%;
        }

    }

    .morecontent span {
        display: none;

    }

    .morelink {
        display: block;
        color: green;
        font-family: 'Montserrat';
        text-decoration: underline;
    }

    .morelink:hover {
        display: block;
        /* color: green; */
        font-family: 'Montserrat';
        text-decoration: underline;
    }

    .see_more {
        color: green !important;
    }

    /* 
    .gluten-vegan-sustainable {
        float: left;
        margin-top: 15px;
        margin-bottom: 10px;
        margin-left: -16px;
    } */


    #gluten-vegan-sustainable-responsive {
        float: left;
        display: inline-flex;
        width: 22%;
        flex-wrap: wrap;
        text-align: center;
        padding: 12px 0;
        transition: all 0.3s ease;
        font-size: 36px;

    }

    @media(max-width:768px) {

        #gluten-vegan-sustainable-responsive {
            margin-left: 1% !important;
            float: left;
            display: inline-flex;
            width: 22%;
            text-align: center;
            padding: 12px 0;
            transition: all 0.3s ease;
            font-size: 36px;


        }

        #vegan {
            margin-left: 2px;
        }

        #lead_time {
            margin-left: 0%;
        }

    }

    #allergens {
        margin-left: 16%;
    }

    .return-for-mobile-view {
        width: 55px;
        height: 55px;
    }

    .delivery-for-mobile-view {
        width: 55px;
        height: 55px;
    }

    .COD-for-mobile {
        width: 55px;
        height: 55px;
    }

    @media(max-width:768px) {
        .for-mobile-in-a-line {
            font-size: 16px;
        }

        .for-mobile-view {
            width: 128px;
        }

        #for-mobile-allergen {
            width: 104px;
        }

        .return-for-mobile-view {
            width: 32px;
            height: 32px;
        }

        .delivery-for-mobile-view {
            width: 32px;
            height: 32px;
        }

        .COD-for-mobile {
            width: 32px;
            height: 32px;
        }

        .dispatch-COD-return {
            font-size: 13px;
            text-align: center;
            margin: 0;
        }
    }

    .dispatch-COD-return {
        text-align: center;
        margin: 0;
    }

    .product_description {
        font-size: 16px;
    }

    .COD-dispatch-date {
        width: 116px;
    }

    .return-aviable-width {
        width: 127px;
    }

    #grams_btn {
        font-weight: bold;
    }

    #shelf_life {
        font-weight: bold;

    }

    .overflow-text {
        overflow-y: scroll;
        max-height: 70px;
    }

    .overflow-text::-webkit-scrollbar-track {
        background-color: transparent;
    }

    .overflow-text::-webkit-scrollbar {
        width: 6px;
        background-color: transparent;
    }

    .overflow-text::-webkit-scrollbar-thumb {
        background-color: #f5f2f200;
    }
</style>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-products">
                        <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <?php if (!empty($parent_categories_tree)) :
                            foreach ($parent_categories_tree as $item) : ?>
                                <li class="breadcrumb-item"><a href="<?php echo generate_category_url($item); ?>"><?php echo category_name($item); ?></a></li>
                        <?php endforeach;
                        endif; ?>
                        <li class="breadcrumb-item active"><?= html_escape($product_details->title); ?></li>
                    </ol>
                </nav>
            </div>

            <div class="col-12">
                <div class="product-details-container <?php echo ((!empty($video) || !empty($audio)) && item_count($product_images) < 2) ? "product-details-container-digital" : ""; ?>">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-7">
                            <div id="product_slider_container">
                                <?php $this->load->view("product/details/_preview"); ?>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-5">
                            <div id="response_product_details" class="product-content-details">
                                <?php $this->load->view("product/details/_product_details"); ?>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-7">
                            <div class="product-description">
                                <h3 class="product_description">Description</h3>
                                <pre style="margin-top: 3px; white-space:pre-line; font-weight:500; text-align:justify; font-size: 100%; font-family:'Montserrat';" class="more"><?php echo $product_details->description; ?></pre>
                                <?php if ($product->add_meet == "Made to order") : ?>
                                    <div class="summary-section-disclaimer" style="max-width:100%;">
                                        <h5 style="padding:2%; font-size: 15px;"><?php echo get_content("made_to_order"); ?></h5>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-5">
                            <?php if ($parent_categories_tree[0]->id == 15) : ?>
                                <div class="summary-section-disclaimer" style="width: 100%;">
                                    <h5 style="padding:2%; font-family:'Montserrat'; font-size: 15px;"><b style="color:red; font-family:'Montserrat';">DISCLAIMER: </b><?php echo get_content("note_homecook"); ?></h5>
                                </div>
                            <?php endif; ?>
                            <div class="product-content-details">
                                <?php //$this->load->view("product/details/_product_details"); 
                                ?>
                                <div class="row">
                                    <div class="row">
                                        <div class="col-12">
                                            <?php if ($this->auth_check) : ?>
                                                <?php if ($this->auth_user->id != $user->id) : ?>

                                                    <p class="question">Have a question? <a class="ask-seller" data-toggle="modal" data-target="#messageModal">Contact the Seller.</a>
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    <p class="question">Have a question? <a class="ask-seller" data-toggle="modal" data-target="#loginModal">Contact the Seller.</a>
                                                    <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="messageModal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered modal-send-message" role="document">
                                            <div class="modal-content">
                                                <!-- form start -->
                                                <form id="form_send_message" novalidate="novalidate">
                                                    <input type="hidden" name="receiver_id" id="message_receiver_id" value="<?php echo $user->id; ?>">
                                                    <input type="hidden" id="message_send_em" value="<?php echo $user->send_email_new_message; ?>">

                                                    <div class="modal-header">
                                                        <h4 class="title"><?php echo trans("send_message"); ?></h4>
                                                        <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div id="send-message-result"></div>
                                                                <div class="form-group m-b-sm-0">
                                                                    <div class="row justify-content-center m-0">
                                                                        <div class="user-contact-modal text-center">
                                                                            <img src="<?php echo get_user_avatar($user); ?>" alt="<?php echo get_shop_name($user); ?>">
                                                                            <p><?php echo get_shop_name($user); ?></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label"><?php echo trans("subject"); ?></label>
                                                                    <input type="text" name="subject" id="message_subject" value="<?php echo (!empty($subject)) ? html_escape($subject) : ''; ?>" class="form-control form-input" placeholder="<?php echo trans("subject"); ?>" required>
                                                                </div>
                                                                <div class="form-group m-b-sm-0">
                                                                    <label class="control-label"><?php echo trans("message"); ?></label>
                                                                    <textarea name="message" id="message_text" class="form-control form-textarea" placeholder="<?php echo trans("write_a_message"); ?>" required></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-md btn-red" data-dismiss="modal"><i class="icon-times"></i>&nbsp;<?php echo trans("close"); ?></button>
                                                        <button type="submit" class="btn btn-md btn-custom" data-dismiss="modal"><i class="icon-send"></i>&nbsp;<?php echo trans("send"); ?></button>
                                                    </div>
                                                </form>
                                                <!-- form end -->
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-12" id="gluten-vegan-sustainable-responsive">
                                        <?php if ($product->is_gluten_Free == 'Y') : ?>
                                            <div class="col-4 gluten-vegan-sustainable">
                                                <div class="product-description-img">
                                                    <img src="<?php echo base_url(); ?>assets/img/product_image/gluten-free.png" alt="" />
                                                </div>
                                                <p class="product-decription-text">Gluten free</p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($product->is_allergens == 'N') : ?>
                                            <div class=" col-4 gluten-vegan-sustainable">
                                                <div class="product-description-img">
                                                    <img src="<?php echo base_url(); ?>assets/img/product_image/no-allergen.png" alt="" />
                                                </div>
                                                <p class="product-decription-text">No allergen</p>
                                            </div>
                                        <?php elseif ($product->is_allergens == 'Y') : ?>
                                        <?php endif; ?>
                                        <?php if ($product->is_sustainable == 'Y') : ?>
                                            <div class="col-4 gluten-vegan-sustainable">
                                                <div class="product-description-img">
                                                    <img src="<?php echo base_url(); ?>assets/img/product_image/sustainable.png" alt="" />
                                                </div>
                                                <p class="product-decription-text">Sustainable</p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($product->is_vegan == 'Y') : ?>
                                            <div class="col-4 gluten-vegan-sustainable">
                                                <div class="product-description-img">
                                                    <img src="<?php echo base_url(); ?>assets/img/product_image/vegan.png" alt="" />
                                                </div>
                                                <p class="product-decription-text">Vegan</p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($product->is_veg_nonveg_jain == 'Veg') : ?>
                                            <div class="col-4 gluten-vegan-sustainable">
                                                <div class="product-description-img">
                                                    <img src="<?php echo base_url(); ?>assets/img/product_image/veg.png" alt="" />
                                                </div>
                                                <p class="product-decription-text">Veg</p>
                                            </div>
                                        <?php elseif ($product->is_veg_nonveg_jain == 'non_Veg') : ?>
                                            <div class="col-4 gluten-vegan-sustainable">
                                                <div class="product-description-img">
                                                    <img src="<?php echo base_url(); ?>assets/img/product_image/Non-veg.png" alt="" />
                                                </div>
                                                <p class="product-decription-text">Non-veg</p>
                                            </div>
                                        <?php elseif ($product->is_veg_nonveg_jain == 'jain') : ?>
                                            <div class="col-4 gluten-vegan-sustainable">
                                                <div class="product-description-img">
                                                    <img src="<?php echo base_url(); ?>assets/img/product_image/Non-veg.png" alt="" />
                                                </div>
                                                <p class="product-decription-text">Jain</p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($product->is_organic == 'Y') : ?>
                                            <div class="col-4 gluten-vegan-sustainable">
                                                <div class="product-description-img">
                                                    <img src="<?php echo base_url(); ?>assets/img/product_image/organic.png" alt="" />
                                                </div>
                                                <p class="product-decription-text">Organic</p>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <div class="row">

                                    <?php if ($product->add_meet == 'Made to order') :
                                        $home_cook = get_parent_categories_tree($product->category_id);
                                        if ($home_cook[0]->id == 2) : ?>
                                        <?php else : ?>
                                            <div class="col-6 product-details-text for-mobile-view">
                                                <!-- <p id="grams_btn">Net Weight&nbsp;:&nbsp;<?php echo $product->product_weight ?>gms&nbsp;</p> -->

                                            </div>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <div class="col-6 product-details-text for-mobile-view">
                                            <?php
                                            // var_dump($get_full_width_product_variations);
                                            //   var_dump($get_full_width_product_variations);
                                            // die();
                                            ?>
                                            <?php if ((empty($half_width_product_variations)) && (empty($full_width_product_variations))) :
                                            ?>
                                                <p id="grams_btn">Net Weight&nbsp;:&nbsp;<?php echo $product->product_weight ?>g&nbsp;</p>
                                                <?php elseif ((!empty($full_width_product_variations))) :
                                                $variation = $this->variation_model->get_variation($full_width_product_variations[0]->id);

                                                $label =  get_variation_label($variation->label_names, $this->selected_lang->id);
                                                // var_dump($label);
                                                // die();
                                                if ($label == 'weight') : ?>
                                                    <p id="grams_btn">Net Weight&nbsp;:&nbsp;<span id="grams_btn1"><?php echo $product->product_weight
                                                                                                                    ?>g</span>&nbsp;</p>

                                                    <!-- <input type="text" id="variation8777" readonly> -->

                                                <?php else : ?>
                                                    <p id="grams_btn">Net Weight&nbsp;:&nbsp;<?php echo $product->product_weight ?>g&nbsp;</p>
                                                <?php endif; ?>
                                                <?php elseif ((!empty($half_width_product_variations))) :
                                                $variation = $this->variation_model->get_variation($half_width_product_variations[0]->id);

                                                $label =  get_variation_label($variation->label_names, $this->selected_lang->id);
                                                // var_dump($label);
                                                // die();
                                                if ($label == 'weight') : ?>
                                                    <p id="grams_btn">Net Weight&nbsp;:&nbsp;<span id="grams_btn1"><?php echo $product->product_weight
                                                                                                                    ?>g</span>&nbsp;</p>

                                                    <!-- <input type="text" id="variation8777" readonly> -->

                                                <?php else : ?>
                                                    <p id="grams_btn">Net Weight&nbsp;:&nbsp;<?php echo $product->product_weight ?>g&nbsp;</p>
                                                <?php endif; ?>
                                            <?php endif;
                                            ?>
                                            <!-- <input type="text" id="variation8777" readonly> -->
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($product->add_meet == "Made to order" && !empty($product->shelf_life_from_date_of_manufacture)) : ?>
                                        <div class="col-6 product-details-text for-mobile-view">
                                            <p id="shelf_life">Shelf Life&nbsp;:&nbsp;<?php echo $product->shelf_life_from_date_of_manufacture ?><?php echo ($product->shelf_units) ?></p>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($product->add_meet == "Made to stock" && $product->is_expire == 'Y') {
                                        if (!empty($product->manufacturing_date) && !empty($product->expiry_date)) {
                                            $manufacture = $product->manufacturing_date;
                                            $expiry = $product->expiry_date;
                                            $diff = strtotime($expiry) - strtotime($manufacture); ?>
                                            <div class="col-6 product-details-text for-mobile-view">
                                                <p>Shelf Life&nbsp;:&nbsp;<?php echo abs(round($diff / 86400)); ?> Days</p>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>

                                    <?php if (!($product->allergance == 'NULL' or $product->allergance == '')) : ?>
                                        <div class="col-6 product-details-text overflow-text" id="for-mobile-allergen">
                                            <p>Allergens&nbsp;:&nbsp;<?php echo $product->allergance ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!($product->storage_instruction == 'NULL' or $product->storage_instruction == '')) : ?>
                                        <div class="col-6 product-details-text">
                                            <p>Storage Instructions&nbsp;:&nbsp;<?php echo $product->storage_instruction ?></p>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <div class="row">
                                    <div class="col-4 add_to_cart_buy_now COD-dispatch-date">
                                        <div class="text-center">
                                            <img src="<?php echo base_url(); ?>assets/img/product_image/delivery.png" alt="" class="delivery-for-mobile-view" />
                                        </div>
                                        <p class="dispatch-COD-return"><?php echo trans("dispatch_date"); ?></p>
                                        <?php if ($product->add_meet == 'Made to order') : ?>
                                            <p class="dispatch-COD-return"><?php echo trans("within") . " " . get_transit_time_for_home_cook($product, "string"); ?></p>
                                        <?php else : ?>
                                            <?php if (check_for_days($product) == 0) : ?>
                                                <p class="dispatch-COD-return"><?php echo trans("arriving_soon"); ?></p>
                                            <?php elseif (check_for_days($product) == 1) : ?>
                                                <p class="dispatch-COD-return"><?php echo trans("within") . " " . check_for_days($product) . " day"; ?></p>
                                            <?php else : ?>
                                                <p class="dispatch-COD-return"><?php echo trans("within") . " " . check_for_days($product) . " days"; ?></p>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($product->cod_accepted == 'Y') : ?>
                                        <div class="col-4 add_to_cart_buy_now COD-dispatch-date">
                                            <div class="text-center">
                                                <img src="<?php echo base_url(); ?>assets/img/product_image/C-O-D.png" alt="" class="COD-for-mobile" />
                                            </div>
                                            <p class="dispatch-COD-return">COD Available</p>
                                            <p class="dispatch-COD-return"><?php echo $product->cod_accepted ?>es</p>
                                        </div>
                                    <?php elseif ($product->cod_accepted == 'N') : ?>
                                        <div class="col-4 add_to_cart_buy_now COD-dispatch-date">
                                            <div class="text-center">
                                                <img src="<?php echo base_url(); ?>assets/img/product_image/C-O-D.png" alt="" class="COD-for-mobile" />
                                            </div>
                                            <p class="dispatch-COD-return">COD Available</p>
                                            <p class="dispatch-COD-return"><?php echo $product->cod_accepted ?>o</p>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($product->available_for_return_or_exchange == 'return') : ?>
                                        <div class="col-4 add_to_cart_buy_now return-aviable-width">
                                            <div class="text-center">
                                                <img src="<?php echo base_url(); ?>assets/img/product_image/return.png" alt="" class="return-for-mobile-view" />
                                            </div>
                                            <p class="dispatch-COD-return">Return/Exchange</p>
                                            <p class="dispatch-COD-return">Returnable</p>
                                        </div>
                                    <?php elseif ($product->available_for_return_or_exchange == 'exchange') : ?>
                                        <div class="col-4 add_to_cart_buy_now return-aviable-width">
                                            <div class="text-center">
                                                <img src="<?php echo base_url(); ?>assets/img/product_image/return.png" alt="" class="return-for-mobile-view" />
                                            </div>
                                            <p class="dispatch-COD-return">Return/Exchange</p>
                                            <p class="dispatch-COD-return">Exchangeable</p>
                                        </div>
                                    <?php elseif ($product->available_for_return_or_exchange == 'both') : ?>
                                        <div class="col-4 add_to_cart_buy_now return-aviable-width">
                                            <div class="text-center">
                                                <img src="<?php echo base_url(); ?>assets/img/product_image/return.png" alt="" class="return-for-mobile-view" />
                                            </div>
                                            <p class="dispatch-COD-return">Return/Exchange</p>
                                            <p class="dispatch-COD-return">Yes</p>
                                        </div>
                                    <?php else : ?>
                                        <div class="col-4 add_to_cart_buy_now return-aviable-width">
                                            <div class="text-center">
                                                <img src="<?php echo base_url(); ?>assets/img/product_image/return.png" alt="" class="return-for-mobile-view" />
                                            </div>
                                            <p class="dispatch-COD-return">Return/Exchange</p>
                                            <p class="dispatch-COD-return">No</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($this->general_settings->view_product_rating == 1) : ?>
                <?php $this->load->view('product/details/_reviews'); ?>
        </div>
    <?php endif; ?>
    <div class="col-12">
        <div class="row-custom row-bn">
            <!--Include banner-->
            <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "product", "class" => "m-b-30"]); ?>
        </div>
    </div>
    <?php if (!empty($user_products) && $this->general_settings->multi_vendor_system == 1) : ?>
        <div class="col-12 section section-related-products m-t-30">
            <h3 class="title"><?php echo trans("more_from"); ?>&nbsp;<a href="<?php echo generate_profile_url($user->slug); ?>"><?php echo get_shop_name($user); ?></a></h3>
            <div class="row row-product">
                <!--print related posts-->
                <?php $count = 0;
                foreach ($user_products as $item) :
                    if ($count < 5) : ?>
                        <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                            <?php $this->load->view('product/_product_item', ['product' => $item]); ?>
                        </div>
                <?php endif;
                    $count++;
                endforeach; ?>
            </div>
            <?php if (item_count($user_products) > 5) : ?>
                <div class="row-custom text-center">
                    <a href="<?php echo generate_profile_url($product->user_slug); ?>" class="link-see-more"><span><?php echo trans("view_all"); ?>&nbsp;</span><i class="icon-arrow-right"></i></a>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($related_products) && false) : ?>
        <div class="col-12 section section-related-products">
            <h3 class="title"><?php echo trans("you_may_also_like"); ?></h3>
            <div class="row row-product">
                <!--print related posts-->
                <?php foreach ($related_products as $item) : ?>
                    <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                        <?php $this->load->view('product/_product_item', ['product' => $item]); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="col-12">
        <div class="row-custom row-bn">
            <!--Include banner-->
            <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "product_bottom", "class" => "m-b-30"]); ?>
        </div>
    </div>

    <?php if ($this->general_settings->index_latest_products == 1 && !empty($latest_products) && false) : ?>

        <div class="col-12 section section-latest-products">
            <h3 class="title" id="top-picks">Similar Products You May Like</h3>
            <div class="row row-product">
                <!--print products-->
                <?php foreach ($latest_products as $product) : ?>
                    <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                        <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => false, 'is_slider' => 0, 'discount_label' => 0]); ?>
                    </div>
                <?php endforeach; ?>
                <div class="btn btn-md btn-custom m-t-15" id="view-products">View More Products</div>
            </div>
        </div>
    <?php endif; ?>

    <div class="col-12 section section-latest-products">
        <h3 class="title" id="top-picks">Similar Products From Different Seller</h3>
        <div class="row row-product">
            <!--print products-->
            <?php $count = 0;
            if (!empty($diff_prod)) :
                foreach ($diff_prod as $product) :
                    if ($count < 5) : ?>
                        <!-- <div class="col-6 col-sm-2 col-md-4 col-lg-2 col-product product-margin"> -->
                        <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                            <?php $this->load->view('product/_product_item', ['product' =>  $product]); ?>
                        </div>
                <?php endif;
                    $count++;
                endforeach;
            else : ?>
                <div class="m-t-15" id="view-products">No products to display !</div>
            <?php endif; ?>
        </div>
        <?php if (!empty($diff_prod)) : ?>
            <div class="btn btn-md btn-custom m-t-15" id="view-products">
                <a href="<?= generate_url("more_products") . '/' . $product->category_id; ?>">View More Products</a>
            </div>
        <?php endif; ?>
    </div>
    </div>
</div>

</div>


<!-- Wrapper End-->

<!-- include send message modal -->
<?php $this->load->view("partials/_modal_send_message", ["subject" => html_escape($product_details->title)]); ?>
<?php $this->load->view("partials/_request_send_barter", ["subject" => html_escape($product_details->title)]); ?>
<?php if ($this->general_settings->facebook_comment_status == 1) :
    echo $this->general_settings->facebook_comment; ?>
    <script>
        $(".fb-comments").attr("data-href", window.location.href);
    </script>
<?php endif; ?>

<!-- Plyr JS-->
<script src="<?php echo base_url(); ?>assets/vendor/plyr/plyr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/plyr/plyr.polyfilled.min.js"></script>
<script>
    const player = new Plyr('#player');
    $(document).ajaxStop(function() {
        const player = new Plyr('#player');
    });
    const audio_player = new Plyr('#audio_player');
    $(document).ajaxStop(function() {
        const player = new Plyr('#audio_player');
    });
</script>

<!-- <script>
    $(function() {
        $('.product-description iframe').wrap('<div class="embed-responsive embed-responsive-16by9"></div>');
        $('.product-description iframe').addClass('embed-responsive-item');
    });

    function set_location_iframe() {
        $('.product-location-map iframe').attr('src', "https://maps.google.com/maps?width=100%&height=600&hl=en&q=<?= get_location($product); ?>&ie=UTF8&t=&z=8&iwloc=B&output=embed&disableDefaultUI=true");
    }
</script> -->
<script>
    $(document).ready(function() {
        // Configure/customize these variables.
        var showChar = 500; // How many characters are shown by default
        var ellipsestext = "";
        var moretext = "See More";
        var lesstext = "See Less";


        $('.more').each(function() {
            var content = $(this).html();

            if (content.length > showChar) {

                var c = content.substr(0, showChar);
                var h = content.substr(showChar, content.length - showChar);

                var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="see_more morelink" >' + moretext + '</a></span>';

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
</script>

<style>
    .product-slider-content {
        direction: ltr !important;
    }
</style>