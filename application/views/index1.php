<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="buyerorseller" role="dialog" style="display:none;">
    <div class="modal-dialog modal-dialog-centered login-modal" role="document">
        <div class="modal-content">
            <div class="auth-box">
                <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                <h4 class="title">Terms & Conditions</h4>

            </div>
        </div>
    </div>
</div>
<div class="section-slider">
    <?php if (!empty($slider_items) && $this->general_settings->slider_status == 1) :
        $this->load->view("partials/_main_slider");
    endif; ?>
</div>
<!-- Wrapper -->
<div id="wrapper" class="index-wrapper">
    <div class="container">
        <div class="row">
            <h1 class="index-title"><?php echo html_escape($this->settings->site_title); ?></h1>
            <?php if (item_count($featured_categories) > 0 && $this->general_settings->featured_categories == 1) : ?>
                <div class="col-12 section section-categories">
                    <!-- featured categories -->
                    <?php $this->load->view("partials/_featured_categories"); ?>
                </div>
            <?php endif; ?>
            <?php $this->load->view("product/_index_banners", ['banner_location' => 'featured_categories']); ?>

            <div class="col-12">
                <div class="row-custom row-bn">
                    <!--Include banner-->
                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "index_1", "class" => ""]); ?>
                </div>
            </div>

            <?php $this->load->view('product/_special_offers', ['index_categories' => $index_categories]); ?>
            <?php $this->load->view("product/_index_banners", ['banner_location' => 'special_offers']); ?>

            <?php if ($this->general_settings->index_promoted_products == 1 && $this->general_settings->promoted_products == 1 && !empty($promoted_products)) : ?>
                <div class="col-12 section section-promoted">
                    <!-- promoted products -->
                    <?php $this->load->view("product/_featured_products"); ?>
                </div>
            <?php endif; ?>
            <?php $this->load->view("product/_index_banners", ['banner_location' => 'featured_products']); ?>

            <?php if ($this->general_settings->index_latest_products == 1 && !empty($latest_products)) : ?>
                <div class="col-12 section section-latest-products">
                    <h3 class="title">
                        <a href="<?= generate_url('products'); ?>"><?= trans("new_arrivals"); ?></a>
                    </h3>
                    <p class="title-exp"><?php echo trans("latest_products_exp"); ?></p>
                    <div class="row row-product">
                        <!--print products-->
                        <?php foreach ($latest_products as $product) : ?>
                            <?php $category = $this->category_model->get_parent_categories_tree($product->category_id); ?>
                        <?php if (!empty($category[0]->id!=2)) :?> 
                            <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                                <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => false, 'is_slider' => 0, 'discount_label' => 0]); ?>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php $this->load->view("product/_index_banners", ['banner_location' => 'new_arrivals']); ?>

            <?php $this->load->view('product/_index_category_products', ['index_categories' => $index_categories]); ?>

            <div class="col-12">
                <div class="row-custom row-bn">
                    <!--Include banner-->
                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "index_2", "class" => ""]); ?>
                </div>
            </div>
            <?php if ($this->general_settings->index_blog_slider == 1 && !empty($blog_slider_posts)) : ?>
                <div class="col-12 section section-blog m-0">
                    <h3 class="title">
                        <a href="<?= generate_url('blog'); ?>"><?= trans("latest_blog_posts"); ?></a>
                    </h3>
                    <p class="title-exp"><?php echo trans("latest_blog_posts_exp"); ?></p>
                    <div class="row-custom">
                        <!-- main slider -->
                        <?php $this->load->view("blog/_blog_slider", ['blog_slider_posts' => $blog_slider_posts]); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="footer_image">
    <img style="width: 100%;" src="./assets/img/footer2.png">
</div>
<!-- Wrapper End-->
<div class="modal fade" id="userTypeModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered login-modal" role="document">
        <div class="modal-content">
            <div class="auth-box">
                <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                <h4 class="title">Choose Your Option</h4>

                <div style="text-align: center;">
                    <a href=""><button type="button" class="button">Continue As A Buyer</button></a>
                </div>
                <div style="text-align: center;">
                    <a href="<?php echo generate_dash_url("add_product"); ?>"><button type="button" class="button">Become A Supplier</button></a>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .button {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
    }
</style>

<script>
    $(document).ready(function() {
        if (<?php echo $success_string; ?>)
            $('#userTypeModal').modal('show');
    });
</script>

<!-- model -->