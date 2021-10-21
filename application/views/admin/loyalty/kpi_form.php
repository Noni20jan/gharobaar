<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    /* label {
        display: block;
        font: 1rem 'Fira Sans', sans-serif;
    }

    input,
    label {
        margin: .4rem 0;
    } */

    .coupons-from-holder {
        backdrop-filter: blur(1px);
        background: #ffffffa6;
        padding: 40px;
        border-radius: 10px;
        margin-top: 20px;
    }

    .nxt-cancel-btns {
        text-align: center;
    }

    .nxt-cancel-styls {
        width: 100px;
        background: #185d8c;
        border-color: #185d8c;
        color: white;
    }
</style>
<!-- form start -->
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('add_kpi'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <div class="box-body">
                <?php $this->load->view('admin/includes/_messages'); ?>
                <?php echo form_open('admin_controller/kpi_form_submit'); ?>
                <div class="col-12 coupons-from-holder">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6"><label><?php echo trans('name'); ?></label></div>
                            <div class="col-sm-6">
                                <input type='text' name="kpi_name" class="form-control auth-form-input" value="" placeholder="Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-6"><label><?php echo trans('description'); ?></label></div>
                        <div class="col-sm-6">
                            <input type='text' name="description" class="form-control auth-form-input" value="" placeholder="description" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-6"><label><?php echo trans('type'); ?></label></div>
                        <div class="col-sm-6">
                            <select name="kpi_type" class="form-control auth-form-input" id="kpi_type" required>
                                <option value="direct">Direct</option>
                                <option value="free form">Free form</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-6"><label>Formula</label></div>
                        <div class="col-sm-6">
                            <input type='text' name="formula" class="form-control auth-form-input" value="" placeholder="formula" required>
                        </div>
                    </div>
                </div>

                <div class=" box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('submit'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<h3 class="box-title">View</h3>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary box-sm">

            <div class="table">
                <table class="table no-margin">
                    <thead>
                        <tr>
                            <th scope="col"><?php echo trans("s.no"); ?></th>
                            <th scope="col"><?php echo trans("add_kpi"); ?></th>
                            <th scope="col"><?php echo trans("description"); ?></th>
                            <th scope="col"><?php echo trans("edit"); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php if (!empty($get_kpi_data)) :
                            foreach ($get_kpi_data as $item) : ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $item->name; ?></td>
                                    <td>
                                        <?php echo $item->description; ?>
                                    </td>
                                    <td style="width: 10%">
                                        <a href="<?php echo admin_url(); ?>edit_kpi/<?php echo html_escape($item->id); ?>" class="btn btn-xs btn-info"><?php echo trans('edit'); ?></a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                        <?php endforeach;
                        endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
    </div>
</div>