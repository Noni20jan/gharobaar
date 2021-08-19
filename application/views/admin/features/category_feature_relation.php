<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script src="<?php echo base_url(); ?>assets/admin/vendor/sortable/Sortable.js"></script>


<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title">Category Feature Relation</h3>
        </div>
        <div class="right">
            <a href="<?php echo admin_url(); ?>add-category-feature-relation" class="btn btn-success btn-add-new">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;Category Feature Relation
            </a>
        </div>
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable" id="cs_datatable" role="grid" aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                                <th width="20"><?php echo trans('id'); ?></th>
                                <th>Feature Group Name</th>
                                <th>Feature Name</th>


                                <th>Category</th>

                                <th class="th-options"><?php echo trans('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($fields as $item) : ?>
                                <tr>
                                    <td><?php echo html_escape($item->id); ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>



                                    <td>
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <li>
                                                    <a href="#"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" onclick=""><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
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
        </div>
    </div>
</div>


<style>
    .btn-group-option {
        display: inline-block !important;
    }
</style>