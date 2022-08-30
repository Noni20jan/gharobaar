<div id="cover-spin"></div>
<?php if (!empty($products)) :
    $count = 1; ?>
    <?php foreach ($products as $product) :
        if ($product->is_shop_open == "1") :
            if ($count <= 10) : ?>
                <?php $category = $this->category_model->get_parent_categories_tree($product->category_id); ?>
                        <?php if (!empty($category[0]->id!=2)) :?> 
                <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
                    <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => true]); ?>
                </div>
                <?php endif; ?>
                <?php $count++; ?>
    <?php endif;

        endif;

    endforeach; ?>
<?php else : ?>
    <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
        No Product is available
    </div>
<?php endif; ?>