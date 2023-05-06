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
    <?php if ($product->is_shop_open == "1") : ?>

        <input type="hidden" id="empty_data" value="">
        <?php $category = $this->category_model->get_parent_categories_tree($product->category_id); ?>
        <?php if (!empty($category[0]->id != 2)) : ?>
            <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-product">
                <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => true]); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php endforeach; ?>
<!-- <div id="container6565">
                            <div class="loadedcontent"></div>
                        </div> -->
<?php if (empty($products)) :
?>
    <input type="hidden" id="empty_data" value="1">
    <div class="col-12" style="text-align: center;">
        <span class="no-records-found" id="no-more-products"></span>
    </div>
<?php endif;
?>
<!-- </div> -->
<!-- <div class="ajax-load-1 text-center" style="display:none">
    <p><img class="more-products-loading" src="assets/img/dark-loader.gif"></p>
</div> -->
<!-- <script>
    $(window).scroll(function() {
        sessionStorage.scrollTop = $(this).scrollTop();
    });

    $(document).ready(function() {
        if (sessionStorage.scrollTop != "undefined") {
            $(window).scrollTop(sessionStorage.scrollTop);
        }
    });
</script> -->