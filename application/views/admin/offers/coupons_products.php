<style>
    .pull-right {
        float: left !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0px;
    }

    .nxt-cancel-btns {
        text-align: center;

        position: relative;
        top: 50px;
    }
</style>
<div class="box">

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive" style="overflow-x:hidden !important;">
                    <table id="example" class="table table-bordered table-striped" role="grid">
                        <thead>
                            <tr role="row">
                                <th width="20"><?php echo trans('id'); ?></th>
                                <th><?php echo trans('product'); ?></th>
                                <th><?php echo trans('sku'); ?></th>
                                <th><?php echo trans('product_type'); ?></th>

                                <th class="max-width-120"><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
                            </tr>
                        </thead>
                        <tbody id="insert_data">

                            <!-- <?php if (!empty($products)) :
                                        foreach ($products as $item) : ?>
                                    <tr>
                                        <td><?php echo html_escape($item->id); ?></td>
                                        <td class="td-product">
                                            <?php if ($item->is_promoted == 1) : ?>
                                                <label class="label label-success"><?php echo trans("featured"); ?></label>
                                            <?php endif; ?>
                                            <div class="img-table">
                                                <a href="<?php echo generate_product_url($item); ?>" target="_blank">
                                                    <img src="<?php echo get_product_image($item->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                                                </a>
                                            </div>
                                            <a href="<?php echo generate_product_url($item); ?>" target="_blank" class="table-product-title">
                                                <?php echo get_product_title($item); ?>
                                            </a>
                                        </td>
                                        <td><?php echo $item->sku; ?></td>
                                        <td><?php echo trans($item->product_type); ?></td>

                                        <td>
                                            <input type="checkbox" name="selected_id" id="product_checkbox" value="<?php echo $item->id; ?> ">

                                        </td>
                                    </tr>

                            <?php endforeach;
                                    endif; ?> -->

                        </tbody>
                    </table>

                    <?php if (empty($products)) : ?>
                        <p class="text-center">
                            <?php echo trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">
                            <div style="float: right;">
                                <button type="button" onclick="submit_data()" id="submit_val_button" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>