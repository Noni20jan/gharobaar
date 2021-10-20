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
                <h3 class="box-title"><?php echo trans('loyalty_criteria'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <div class="box-body">
                <?php $this->load->view('admin/includes/_messages'); ?>
                <?php echo form_open('admin_controller/loyalty_program_submit'); ?>
                <div class="col-12 coupons-from-holder">
                    <div class="form-group">
                        <input type="hidden" name="id" value="<?php echo $criteria_detail->id; ?>">
                        <div class="row">
                            <input type="hidden" value="0" name="sl">
                            <div class="col-sm-6"><label>User Type:</label></div>
                            <div class="col-sm-6">
                                <select name="user_type" class="form-control auth-form-input" id="offer-type" required>
                                    <?php foreach ($user_type as $user_type) { ?>
                                        <option <?php if ($criteria_detail->user_type == $user_type->lookup_code) echo 'selected="selected"'; ?>value="<?php echo $user_type->lookup_code; ?>"><?php echo $user_type->meaning; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12"><label>KPI</label></div>

                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <label>NAME:</label>
                            <select name="kpi_name1[]" required id="kpi_name" class="form-control auth-form-input">
                                <?php foreach ($kpi as $kpi1) { ?>
                                    <option <?php if ($criteria_detail->kpi_id == $kpi1->id) echo 'selected="selected"'; ?> value="<?php echo $kpi1->id; ?>"><?php echo $kpi1->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label>KPI Type:</label>
                            <select class="form-control auth-form-input" required name="kpi_type1[]" id="kpi_type" onchange="child_parent_name();">
                                <option <?php if ($criteria_detail->kpi_rel_type == "Parent") echo 'selected="selected"'; ?> value="Parent">Parent</option>
                                <option <?php if ($criteria_detail->kpi_rel_type == "Child") echo 'selected="selected"'; ?> value="Child">Child</option>
                                <option <?php if ($criteria_detail->kpi_rel_type == "Individual") echo 'selected="selected"'; ?> value="Individual">Individual</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label>Relationship</label>
                            <!-- <input type='text' name="parent_name" id="parent_name" placeholder="Parent KPI" class="form-control auth-form-input" value=""> -->
                            <select name="parent_name1[]" id="parent_name" class="form-control auth-form-input" required>
                                <option value="" selected disabled>Parent kpi</option>
                                <?php foreach ($parent_name as $parent_name1) { ?>
                                    <option <?php if ($criteria_detail->parent_id == $parent_name1->id) echo 'selected="selected"'; ?> value="<?php echo $parent_name1->id; ?>"><?php echo $parent_name1->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label>Weightage</label>
                            <input type="number" maxlength="3" value="<?php echo $criteria_detail->weightage; ?>" step=any name="weightage1[]" placeholder="Weightage" class="form-control auth-form-input" value="" required>
                        </div>
                        <!-- <div class="col-sm-4"><label>Formula/SQL</label>

            <input type='text' placeholder="Formula" name="formula" class="form-control auth-form-input" value="" required>
        </div> -->
                    </div>
                    <div class="input_fields_container1">
                    </div>
                </div>
                <div class=" box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('submit'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>


<?php echo form_close(); ?>
<script>
    $(document).ready(function() {
        $('#parent_name').prop('disabled', true);
        // if ($('#parent_name').prop('disabled', true)) {
        //     $('#parent_hidden').val = "";
        // }

    });
</script>
<script>
    function child_parent_name() {
        var kpi_type = document.getElementById('kpi_type').value;
        console.log(kpi_type);
        if (kpi_type == "Child") {
            $('#parent_name').prop('disabled', false);
        } else {
            $('#parent_name').prop('disabled', true);
        }
    }
</script>