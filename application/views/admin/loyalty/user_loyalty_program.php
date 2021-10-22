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
<?php $this->load->view('admin/includes/_messages'); ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('user_loyalty_program'); ?></h3>
            </div>
            <?php echo form_open('admin_controller/user_loyalty_program_submit'); ?>
            <div class="col-12 coupons-from-holder">
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6"><label>Loyality Program</label></div>
                        <div class="col-sm-6">
                            <select name="loyalty_type" class="form-control auth-form-input" id="offer-type" required>
                                <?php $data['loyalty'] = $this->Offer_model->get_loyalty_program(); ?>
                                <option value="Bronze">Bronze</option>
                                <option value="Silver">Silver</option>
                                <option value="Gold">Gold</option>
                                <option value="Platinum">Platinum</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6"><label>User Type:</label></div>
                        <div class="col-sm-6">
                            <select name="user_type" class="form-control auth-form-input" id="offer-type" required>
                                <option value="BUYER">Buyer</option>
                                <option value="SUPPLIER">Supplier</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Name:</label>
                        </div>
                        <div class="col-sm-6">
                            <input type='text' name="name" class="form-control auth-form-input" value="" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Description:</label>
                        </div>
                        <div class="col-sm-6">
                            <input type='text' name="description" class="form-control auth-form-input" value="" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Start Date:</label>
                        </div>
                        <div class="col-sm-6">
                            <input type='date' name="start_date" id="start_date" class="form-control auth-form-input" value="" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>End Date:</label>
                        </div>
                        <div class="col-sm-6">
                            <input type='date' name="end_date" id="end_date" class="form-control auth-form-input" value="" required>
                            <span id="end_date1" style="color:red;">End date should be greater than Start date</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('submit'); ?></button>
            </div>
        </div>

        <?php echo form_close(); ?>
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
                            <th scope="col"><?php echo trans("name"); ?></th>
                            <th scope="col"><?php echo trans("description"); ?></th>
                            <th scope="col"><?php echo trans("edit"); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>

                        <?php if (!empty($get_program_data)) :
                            foreach ($get_program_data as $item) : ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $item->name; ?></td>
                                    <td>
                                        <?php echo $item->description; ?>
                                    </td>
                                    <td style="width: 10%">
                                        <a href="edit-loyalty-program/<?php echo html_escape($item->id); ?>" class="btn btn-xs btn-info"><?php echo trans('edit'); ?></a>
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
<script>
    $(document).ready(function() {
        document.getElementById("end_date1").style.display = "none";
    });
</script>
<script>
    $("#end_date").change(function() {
        var startDate = document.getElementById("start_date").value;
        var endDate = document.getElementById("end_date").value;

        if ((Date.parse(endDate) <= Date.parse(startDate))) {
            // alert("End date should be greater than Start date");
            document.getElementById("end_date1").style.display = "block";
            document.getElementById("end_date").value = "";
        } else {
            document.getElementById("end_date1").style.display = "none";
        }
    });
</script>
<script>
    $("#start_date").change(function() {
        var startDate = document.getElementById("start_date").value;
        var endDate = document.getElementById("end_date").value;

        if ((Date.parse(endDate) <= Date.parse(startDate))) {
            // alert("End date should be greater than Start date");
            document.getElementById("end_date1").style.display = "block";
            document.getElementById("start_date").value = "";
        } else {
            document.getElementById("end_date1").style.display = "none";
        }
    });
</script>