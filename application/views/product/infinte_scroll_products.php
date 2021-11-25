<style type="text/css">
    .ajax-load-1 {
        /* background: #e1e1e1; */
        padding: 10px 0px;
        width: 100%;
    }

    .more-products-loading {
        width: 5%;
    }
</style>
<!-- <div class="row row-product" style="margin-top:20px"> -->
<!--print products-->
<?php foreach ($products as $product) : ?>
    <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-product">
        <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => true]); ?>
    </div>
<?php endforeach; ?>
<!-- <div id="container6565">
                            <div class="loadedcontent"></div>
                        </div> -->
<?php if (empty($products)) : ?>
    <div class="col-12" style="text-align: center;">
        <span class="no-records-found" id="no-more-products"><?php echo trans("no_products_found"); ?></span>
    </div>
<?php endif; ?>
<!-- </div>s -->
<!-- <div class="ajax-load-1 text-center" style="display:none">
    <p><img class="more-products-loading" src="assets/img/dark-loader.gif"></p>
</div> -->