<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style>
    .star-rating {
        direction: rtl;
        display: inline-block;
        padding: 20px
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
        margin: 4em;
        max-width: 30em;
        padding: 2em;
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
                                <?php $this->load->view("product/details/_product_details_preview"); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-7">
                        <div class="col-12 add_to_cart_buy_now">
                            <h4>Description</h4>
                            <p style="text-align:justify;"><?php echo $product_details->description; ?></p>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-5">
                        <div class="row">
                            <div class="col-sm-7 add_to_cart_buy_now">
                                <h4>Net Weight <i class="fa fa-info-circle"></i></h4>
                            </div>
                            <div class="col-sm-5 add_to_cart_buy_now">
                                <h4>Materials</h4>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-sm-4 add_to_cart_buy_now">
                                        <img src="<?php echo base_url(); ?>assets/img/product_image/delivery.png" alt="" style="width: 50px; height: 50px;" />
                                        <h5>Delivery Date</h5>
                                    </div>
                                    <div class="col-sm-4 add_to_cart_buy_now">
                                        <img src="<?php echo base_url(); ?>assets/img/product_image/C-O-D.png" alt="" style="width: 50px; height: 50px;" />
                                        <h5>COD Available</h5>
                                    </div>
                                    <div class="col-sm-4 add_to_cart_buy_now">
                                        <img src="<?php echo base_url(); ?>assets/img/product_image/return.png" alt="" style="width: 50px; height: 50px;" />
                                        <h5>Return Available</h5>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <?php //$this->load->view("product/details/_product_share"); 
                        ?>
                    </div>
                </div>
            </div>
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

<div class="footer_image">
    <div class="container" style="text-align:center;">
        <p style="margin-bottom:0em;">
            <span class="journey">Start Your Journery With Us!</span>
        </p>
        <span class="journey" style="font-weight:bolder; font-size:42px;">#Gharseghartak</span>
    </div>
    <img style="width: 100%;" src="./assets/img/footer2.png">
</div>


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

<script>
    $(function() {
        $('.product-description iframe').wrap('<div class="embed-responsive embed-responsive-16by9"></div>');
        $('.product-description iframe').addClass('embed-responsive-item');
    });

    function set_location_iframe() {
        $('.product-location-map iframe').attr('src', "https://maps.google.com/maps?width=100%&height=600&hl=en&q=<?= get_location($product); ?>&ie=UTF8&t=&z=8&iwloc=B&output=embed&disableDefaultUI=true");
    }
</script>
<script>

</script>


<style>
    .product-slider-content {
        direction: ltr !important;
    }
</style>