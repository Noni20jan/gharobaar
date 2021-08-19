<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo trans("options"); ?>&nbsp;(<?php echo html_escape(get_variation_label($variation->label_names, $this->selected_lang->id)); ?>)</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><i class="icon-close"></i></span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="variation-options-container">
                <?php if (!empty($variation_options)) : ?>
                    <table class="table table-striped" style="background-color: #fdfdfda4;">
                        <thead>
                            <tr>
                                <th scope="col">S.No.</th>
                                <th scope="col">Name</th>
                                <th scope="col" <?php if (!empty($type_of_variation) && $type_of_variation == "Made to order") {
                                                    echo "class='hideMe'";
                                                } ?>>Stock</th>
                                <th scope="col">Price</th>
                                <th scope="col">Discount</th>
                                <th scope="col">SKU Code</th>
                                <th scope="col">Package Weight(in grams)</th>
                                <th scope="col">Package Length(in cm)</th>
                                <th scope="col">Package Width(in cm)</th>
                                <th scope="col">Package Height(in cm)</th>
                                <th scope="col" class="hideMe">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; ?>
                            <?php foreach ($variation_options as $option) : ?>
                                <tr>
                                    <th scope="row"><?php echo $count; ?></th>
                                    <td><?php echo html_escape(get_variation_option_name($option->option_names, $this->selected_lang->id)); ?></td>
                                    <td <?php if (!empty($type_of_variation) && $type_of_variation == "Made to order") {
                                            echo "class='hideMe'";
                                        } ?> <?php if ($option->is_default) : echo "id='default_stock_view'";
                                                endif; ?>><?php if (!$option->is_default) : echo $option->stock;
                                                            endif; ?></td>
                                    <td <?php if ($option->is_default) : echo "id='default_price_view'";
                                        elseif ($option->use_default_price) : echo "class='use_default_price_view'";
                                        endif; ?>><?php if (!$option->is_default) : echo get_price($option->price, "input");
                                                    endif; ?></td>
                                    <td <?php if ($option->is_default) : echo "id='default_discount_view'";
                                        endif; ?>><?php if (!$option->is_default) : echo $option->discount_rate;
                                                    endif; ?></td>
                                    <td><?php if (!$option->is_default) : echo $option->sku_code;
                                        else : echo $product->sku;
                                        endif; ?></td>
                                    <td <?php if ($option->is_default) : echo "id='default_package_weight_view'";
                                        endif; ?>><?php if (!$option->is_default) : echo $option->package_weight;
                                                    endif; ?></td>
                                    <td <?php if ($option->is_default) : echo "id='default_package_length_view'";
                                        endif; ?>><?php if (!$option->is_default) : echo $option->variation_packed_length;
                                                    endif; ?></td>
                                    <td <?php if ($option->is_default) : echo "id='default_package_width_view'";
                                        endif; ?>><?php if (!$option->is_default) : echo $option->variation_packed_width;
                                                    endif; ?></td>
                                    <td <?php if ($option->is_default) : echo "id='default_package_height_view'";
                                        endif; ?>><?php if (!$option->is_default) : echo $option->variation_packed_height;
                                                    endif; ?></td>

                                    <td class="hideMe"><button type="button" class="btn btn-sm btn-default btn-variation-table" onclick='edit_product_variation_option("<?php echo $variation->id; ?>","<?php echo $option->id; ?>");'><i class="icon-edit"></i><?php echo trans('edit'); ?></button>
                                        <button type="button" class="btn btn-sm btn-danger btn-variation-table" onclick='delete_product_variation_option("<?php echo $variation->id; ?>","<?php echo $option->id; ?>","<?php echo trans("confirm_delete"); ?>");'><i class="icon-trash"></i><?php echo trans('delete'); ?></button>
                                    </td>
                                </tr>
                                <?php $count++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                <?php else : ?>
                    <p class="text-muted text-center m-t-15"> <?php echo trans("no_records_found"); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- <div class="row">
        <div class="col-sm-12">
            <div class="variation-options-container">
                <?php if (!empty($variation_options)) : ?>
                    <ul>
                        <?php foreach ($variation_options as $option) : ?>
                            <li>
                                <div class="pull-left">
                                    <strong class="font-500"><?php echo html_escape(get_variation_option_name($option->option_names, $this->selected_lang->id)); ?></strong>
                                    <?php if ($option->is_default != 1) : ?>
                                        <span><?php echo trans("stock"); ?>:&nbsp;<strong><?php echo $option->stock; ?></strong></span>
                                    <?php endif; ?>
                                    <?php if ($option->is_default == 1) : ?>
                                        <label class="label label-success"><?php echo trans("default"); ?></label>
                                    <?php endif; ?>
                                </div>
                                <div class="pull-right">
                                    <button type="button" class="btn btn-sm btn-default btn-variation-table" onclick='edit_product_variation_option("<?php echo $variation->id; ?>","<?php echo $option->id; ?>");'><i class="icon-edit"></i><?php echo trans('edit'); ?></button>
                                    <button type="button" class="btn btn-sm btn-danger btn-variation-table" onclick='delete_product_variation_option("<?php echo $variation->id; ?>","<?php echo $option->id; ?>","<?php echo trans("confirm_delete"); ?>");'><i class="icon-trash"></i><?php echo trans('delete'); ?></button>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p class="text-muted text-center m-t-15"> <?php echo trans("no_records_found"); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div> -->
</div>
<div class="modal-footer">
    <div class="row-custom">
        <button type="submit" class="btn btn-md btn-secondary color-white pull-right" data-dismiss="modal"><?php echo trans("close"); ?></button>
    </div>
</div>