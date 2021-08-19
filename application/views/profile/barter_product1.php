<?php
$products = get_barter_product_of_current_user();
//var_dump($products);

?>
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3> Your Product For Barter</h3>
            </div>
        </div>


        <div class="row">

            <div class="col-sm-12 col-md-9">
                <div class="profile-tab-content">
                    <div class="row row-product-items row-product">

                        <?php $productprice =($barter_product->listing_price)/100;
                        foreach ($products as $product) : ?>
                            <?php if (!empty($product->listing_price)) : ?>
                                <?php $barter_product = ($product->listing_price)/100;
                                // var_dump ( ($barter_product <=  $productprice + (0.1 * $productprice) && $barter_product >=  $productprice -  (0.1 * $productprice)) ) ;?>

                                <?php if ($barter_product <=  $productprice + (0.1 * $productprice) && $barter_product >=  $productprice -  (0.1 * $productprice)) : ?>


                                    <div class="col-md-6 col-sm-6 col-12">
                                        <?php $this->load->view('product/_product_barter1', ['product' => $product, 'promoted_badge' => true]); ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="product-list-pagination">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
                <div class="row-custom">
                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "profile", "class" => "m-t-30"]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->

<!-- include send message modal -->
<?php $this->load->view("partials/_modal_send_message", ["subject" => null]); ?>
<?php $this->load->view("partials/_request_send_barter", ["subject" => null]); ?>