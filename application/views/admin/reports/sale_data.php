<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="col-lg-12 col-md-12">
    <div class="box">
        <div class="box-header with-border">
            <div class="pull-left">
                <h3 class="box-title"><?php echo trans('sale-data'); ?></h3>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="table-responsive">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-striped dataTable" id="cs_datatable" role="grid" aria-describedby="example1_info">
                            <thead>
                                <tr role="row">
                                    <th width="20"><?php echo trans('id'); ?></th>
                                    <th><?php echo trans('currency'); ?></th>
                                    <th><?php echo trans('currency_code'); ?></th>
                                    <th><?php echo trans('currency_symbol'); ?></th>
                                    <th class="th-options"><?php echo trans('options'); ?></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($currencies as $item) : ?>
                                    <tr>
                                        <td><?php echo html_escape($item->id); ?></td>
                                        <td><?php echo html_escape($item->name); ?>&nbsp;</td>
                                        <td><?php echo html_escape($item->code); ?></td>
                                        <td><?php echo html_escape($item->symbol); ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <li>
                                                        <a href="<?php echo admin_url(); ?>update-currency/<?php echo html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="delete_item('admin_controller/delete_currency_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>