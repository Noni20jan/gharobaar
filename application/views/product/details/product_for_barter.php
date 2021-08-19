<?php
$products_barter = get_barter_product_of_current_user();
//var_dump($products);

?>
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-products">
                        <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <?php if (!empty($parent_categories_tree)) :
                            foreach ($parent_categories_tree as $item) : ?>
                                <li class="breadcrumb-item"><a href="<?php echo generate_category_url($item); ?>"><?php echo category_name($item); ?></a></li>
                            <?php endforeach;
                        endif; ?>
                        <li class="breadcrumb-item active"><?= html_escape($product_details->title); ?></li>
                    </ol>
                </nav> -->
            </div>

            <div class="col-12">
                <div class="product-details-container <?php echo ((!empty($video) || !empty($audio)) && item_count($product_images) < 2) ? "product-details-container-digital" : ""; ?>">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6">
                            <div id="product_slider_container">
                                <?php $this->load->view("product/details/_preview"); ?>
                            </div>
                            <br>
                            <div id="response_product_details" class="product-content-details">
                                <?php $this->load->view("product/details/_product_details1"); ?>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6">
                            <?php $this->load->view("profile/barter_product1"); ?>
                        </div>
                    </div>
                    <br>

                </div>

            </div>


            <div class="col-12">
                <div class="row-custom row-bn">
                    <!--Include banner-->
                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "product", "class" => "m-b-30"]); ?>
                </div>
            </div>


            <div class="col-12">
                <div class="row-custom row-bn">
                    <!--Include banner-->
                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "product_bottom", "class" => "m-b-30"]); ?>
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
<style>
    .product-slider-content {
        direction: ltr !important;
    }
</style>