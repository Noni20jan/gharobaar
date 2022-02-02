<div class="row table-filter-container">
    <div class="col-sm-12" style="margin-left: 28px;">
        <?php echo form_open($form_action, ['method' => 'GET']); ?>
        <div class="row">
            <div class="item-table-filter" style="width: 80px; min-width: 80px;">
                <label><?php echo trans("show"); ?></label>
                <select name="show" class="form-control">
                    <option value="15" <?php echo ($this->input->get('show', true) == '15') ? 'selected' : ''; ?>>15</option>
                    <option value="30" <?php echo ($this->input->get('show', true) == '30') ? 'selected' : ''; ?>>30</option>
                    <option value="60" <?php echo ($this->input->get('show', true) == '60') ? 'selected' : ''; ?>>60</option>
                    <option value="100" <?php echo ($this->input->get('show', true) == '100') ? 'selected' : ''; ?>>100</option>
                </select>
            </div>

            <div class="item-table-filter">
                <label><?php echo trans('product_type'); ?></label>
                <select name="product_type" class="form-control custom-select">
                    <option value="" selected><?php echo trans("all"); ?></option>
                    <option value="physical" <?= input_get('product_type') == 'physical' ? 'selected' : ''; ?>><?= trans("physical"); ?></option>
                    <option value="digital" <?= input_get('product_type') == 'digital' ? 'selected' : ''; ?>><?= trans("digital"); ?></option>
                </select>
            </div>

            <div class="item-table-filter">
                <label><?php echo trans('category'); ?></label>
                <select id="categories" name="category" class="form-control" onchange="get_filter_subcategories(this.value);">
                    <option value=""><?php echo trans("all"); ?></option>
                    <?php
                    $categories = $this->category_model->get_all_parent_categories();
                    foreach ($categories as $item) : ?>
                        <option value="<?php echo $item->id; ?>" <?php echo ($this->input->get('category', true) == $item->id) ? 'selected' : ''; ?>>
                            <?php echo category_name($item); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="item-table-filter">
                <div class="form-group">
                    <label class="control-label"><?php echo trans('subcategory'); ?></label>
                    <select id="subcategories" name="subcategory" class="form-control" onchange="get_third_categories(this.value);">
                        <option value=""><?php echo trans("all"); ?></option>
                        <?php
                        if (!empty($this->input->get('category', true))) :
                            $subcategories = $this->category_model->get_subcategories_by_parent_id($this->input->get('category', true));
                            if (!empty($subcategories)) {
                                foreach ($subcategories as $item) : ?>
                                    <option value="<?php echo $item->id; ?>" <?php echo ($this->input->get('subcategory', true) == $item->id) ? 'selected' : ''; ?>><?php echo $item->name; ?></option>
                        <?php endforeach;
                            }
                        endif;
                        ?>
                    </select>
                </div>
            </div>



            <div class="item-table-filter">
                <label><?php echo trans('brand_name'); ?></label>
                <select id="brand" name="brand_name" class="form-control">
                    <option value=""><?php echo trans("all"); ?></option>
                    <?php

                    $brand = $this->category_model->get_brandname();
                    if (!empty($brand)) {
                        foreach ($brand as $item) : ?>
                            <option value="<?php echo $item->brand_name; ?>"> <?php echo $item->brand_name; ?></option>
                    <?php endforeach;
                    }

                    ?>
                </select>
            </div>

            <div class="item-table-filter">
                <label><?php echo trans('shop_name'); ?></label>
                <select id="brand" name="shop_name" class="form-control">
                    <option value=""><?php echo trans("all"); ?></option>
                    <?php

                    $shop = $this->category_model->get_shopname();
                    if (!empty($shop)) {
                        foreach ($shop as $item) : ?>
                            <option value="<?php echo $item->shop_name; ?>"> <?php echo $item->shop_name; ?></option>
                    <?php endforeach;
                    }

                    ?>
                </select>
            </div>

            <div class="item-table-filter">
                <label><?php echo ('Seller Email'); ?></label>
                <select id="brand" name="seller_email" class="form-control">
                    <option value=""><?php echo trans("all"); ?></option>
                    <?php

                    $email = $this->category_model->get_seller_email();
                    if (!empty($email)) {
                        foreach ($email as $item) : ?>
                            <option value="<?php echo $item->email; ?>"> <?php echo $item->email; ?></option>
                    <?php endforeach;
                    }

                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="item-table-filter">
                <label><?php echo trans('product_title'); ?></label>
                <select id="brand" name="product_title" class="form-control">
                    <option value=""><?php echo trans("all"); ?></option>
                    <?php

                    $product_title = $this->category_model->get_pending_product_title();
                    if (!empty($product_title)) {
                        foreach ($product_title as $item) : ?>
                            <option value="<?php echo $item->title; ?>"> <?php echo $item->title; ?></option>
                    <?php endforeach;
                    }

                    ?>
                </select>
            </div>



            <div class="item-table-filter">
                <label><?php echo trans('stock'); ?></label>
                <select name="stock" class="form-control custom-select">
                    <option value="" selected><?php echo trans("all"); ?></option>
                    <option value="in_stock" <?= input_get("stock") == "in_stock" ? 'selected' : ''; ?>><?php echo trans("in_stock"); ?></option>
                    <option value="out_of_stock" <?= input_get("stock") == 'out_of_stock' ? 'selected' : ''; ?>><?php echo trans("out_of_stock"); ?></option>
                </select>
            </div>

            <div class="item-table-filter">
                <label><?php echo trans("search"); ?></label>
                <input name="q" class="form-control" placeholder="<?php echo trans("search"); ?>" type="search" value="<?php echo html_escape($this->input->get('q', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
            </div>

            <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                <label style="display: block">&nbsp;</label>
                <button type="submit" class="btn bg-purple"><?php echo trans("filter"); ?></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>