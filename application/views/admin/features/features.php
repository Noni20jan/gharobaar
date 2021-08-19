<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script src="<?php echo base_url(); ?>assets/admin/vendor/sortable/Sortable.js"></script>


<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans('features'); ?></h3>
        </div>
        <div class="right">
            <a href="<?php echo admin_url(); ?>add-feature" class="btn btn-success btn-add-new">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo trans('add_feature'); ?>
            </a>
        </div>
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="col-sm-12">

            <div class="row">

            </div>

            <div class="row row-category-message">
                <?php if (empty($this->session->flashdata('msg_settings'))) :
                    $this->load->view('admin/includes/_messages');
                endif; ?>
            </div>


        </div>
    </div>
</div>


<style>
    .btn-group-option {
        display: inline-block !important;
    }
</style>