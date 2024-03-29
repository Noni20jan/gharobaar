<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $title; ?></h3>
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="row">
            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <?php $this->load->view('admin/service/_filter_services'); ?>
                        <thead>
                        <tr role="row">
                            <th width="20"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                            <th width="20"><?php echo trans('id'); ?></th>
                            <th>Service</th>
                            <th><?php echo trans('sku'); ?></th>
                            <th>Service Type</th>
                            <th><?php echo trans('category'); ?></th>
                            <th><?php echo trans('purchased_plan'); ?></th>
                            <th><?php echo trans('user'); ?></th>
                            <!-- <th><?php echo trans('stock'); ?></th> -->
                            <th><?php echo trans('page_views'); ?></th>
                            <th><?php echo trans('date'); ?></th>
                            <th class="max-width-120"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($products as $item): ?>
                            <tr>
                                <td><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?php echo $item->id; ?>"></td>
                                <td><?php echo html_escape($item->id); ?></td>
                                <td class="td-product">
                                    <?php if ($item->is_promoted == 1): ?>
                                        <label class="label label-success"><?php echo trans("featured"); ?></label>
                                    <?php endif; ?>
                                    <div class="img-table">
                                        <a href="<?php echo generate_product_url($item); ?>" target="_blank">
                                            <img src="<?php echo get_product_image($item->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image"/>
                                        </a>
                                    </div>
                                    <a href="<?php echo generate_product_url($item); ?>" target="_blank" class="table-product-title">
                                        <?php echo get_product_title($item); ?>
                                    </a>
                                </td>
                                <td><?php echo $item->sku; ?></td>
                                <td><?php echo trans($item->product_type); ?></td>
                                <td>
                                    <?php $categories = get_parent_categories_tree($item->category_id, false);
                                    if (!empty($categories)) {
                                        foreach ($categories as $category) {
                                            echo html_escape($category->name) . "<br>";
                                        }
                                    } ?>
                                </td>
                                <td>
                                    <?php if ($item->is_promoted == 1 && $item->promote_plan != "none"): ?>
                                        <?php echo $item->promote_plan; ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php $user = get_user($item->user_id);
                                    if (!empty($user)): ?>
                                        <a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank" class="table-username">
                                            <?php echo html_escape($user->username); ?>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <!-- <td class="white-space-nowrap">
                                    <?php if ($item->product_type == "digital"): ?>
                                        <span class="text-success"><?php echo trans("in_stock"); ?></span>
                                    <?php else:
                                        if ($item->stock < 1): ?>
                                            <span class="text-danger"><?= $item->listing_type == 'ordinary_listing' ? trans("sold") : trans("out_of_stock"); ?></span>
                                        <?php else: ?>
                                            <span class="text-success"><?php echo trans("in_stock"); ?>&nbsp;<?= $item->listing_type != 'ordinary_listing' ? "(" . $item->stock . ")" : ''; ?></span>
                                        <?php endif;
                                    endif; ?>
                                </td> -->
                                <td><?php echo $item->pageviews; ?></td>
                                <td><?php echo formatted_date($item->created_at); ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                type="button"
                                                data-toggle="dropdown"><?php echo trans("select_option"); ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu options-dropdown">
                                            <li>
                                                <a href="<?php echo admin_url(); ?>service-details/<?php echo html_escape($item->id); ?>"><i class="fa fa-info option-icon"></i><?php echo trans("view_details"); ?></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="approve_service('<?php echo $item->id; ?>');"><i class="fa fa-check option-icon"></i><?php echo trans("approve"); ?></a>
                                            </li>
                                            <li>
                                                <a href="<?= generate_dash_url("edit_service"); ?>/<?= $item->id; ?>" target="_blank"><i class="fa fa-edit option-icon"></i><?php echo trans("edit"); ?></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_item('product_controller/delete_service','<?php echo $item->id; ?>','<?php echo trans("confirm_product"); ?>');"><i class="fa fa-times option-icon"></i><?php echo trans('delete'); ?></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_item('product_controller/delete_service_permanently','<?php echo $item->id; ?>','<?php echo trans("confirm_product_permanent"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete_permanently'); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>

                    <?php if (empty($products)): ?>
                        <p class="text-center">
                            <?php echo trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">

                            <div class="pull-right">
                                <?php echo $this->pagination->create_links(); ?>
                            </div>
                            <?php if (count($products) > 0): ?>
                                <div class="pull-left">
                                    <button class="btn btn-sm btn-danger btn-table-delete" onclick="delete_selected_products('Are you sure you want to delete selected Services?');"><?php echo trans('delete'); ?></button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>
