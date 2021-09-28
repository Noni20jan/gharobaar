<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
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
                <h3 class="box-title"><?php echo trans('qualifying_criteria'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <div class="box-body">
                <!-- <? //php echo form_open('admin_controller/loyalty_program_submit'); 
                        ?> -->
                <form name="qualify_criteria" id="qualify_criteria" action="order_controller/qualify_criteria">
                    <div class="col-12 coupons-from-holder">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4"><label>User Type:</label></div>
                                <div class="col-sm-4">
                                    <select name="user_type" class="form-control auth-form-input" id="offer-type">
                                        <?php foreach ($user_type as $user_t) { ?>
                                            <option value="<?php echo $user_t->lookup_code; ?>"><?php echo $user_t->meaning; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4"><label>Loyalty Program:</label></div>
                                <div class="col-sm-4">
                                    <select name="loyalty_type" class="form-control auth-form-input" id="loyalty-type">
                                        <?php foreach ($membership_type as $membership_t) { ?>
                                            <option value="<?php echo $membership_t->lookup_code; ?>"><?php echo $membership_t->meaning; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right"><?php echo 'Next'; ?></button>
                    </div>
            </div>
        </div>
    </div>
</div>
</form>


<div class="box">
    <form name="qualify_criteria_sub" id="qualify_criteria_sub" action="order_controller/qualify_criteria_submit">
        <input type="hidden" name="criteria_value_type" id="criteria_value_type_id">
        <div class="box-body">

            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">

                        <table id="payouts_table" class="display" style="width:100%">

                            <thead>
                                <tr role="row">
                                    <th><?php echo 'Sr. No.' ?></th>
                                    <th><?php echo 'KPI' ?></th>
                                    <th><?php echo 'Relationship'; ?></th>
                                    <th><?php echo 'Weightage' ?></th>
                                    <th><?php echo 'Parent'; ?></th>
                                    <th><?php echo 'Min. Value'; ?></th>
                                    <th><?php echo 'Max. Value'; ?></th>

                                </tr>
                            </thead>
                            <tbody id="kpi_data">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div><!-- /.box-body -->
        <div class="row">
            <button type="submit" id="ini_pay_btn" class="btn bg-purple" style="float: right;"><?php echo ("Submit"); ?></button>
        </div>
    </form>
</div>


<script>
    $("#qualify_criteria").submit(function(e) {

        e.preventDefault();
        var form = $(this);
        var d = form.serializeArray();
        d.push({
            name: csfr_token_name,
            value: $.cookie(csfr_cookie_name)
        });
        d.push({
            name: "sys_lang_id",
            value: sys_lang_id
        });

        var url = form.attr('action');

        // table = $('#payouts_table');
        // table.clear().destroy();
        // $('#payouts_table').find('tbody').remove();
        $('#payouts_table').find('tbody').empty();


        $.ajax({
            type: "POST",
            url: base_url + url,
            data: d,
            success: function(response) {
                var data = JSON.parse(response);
                var Json_data = data.data;
                document.getElementById("criteria_value_type_id").value = data.loyalty_type;
                console.log(Json_data.length);
                var len = Json_data.length;
                if (len != 0) {
                    for (var i = 0; i < len; i++) {
                        $('#kpi_data').append("<tr><td>" + (j = i + 1) + "</td><td><input type='hidden' name='criteria_id+" + (j = i + 1) + "' value=" + Json_data[i].id + ">" + Json_data[i].name + "</td><td>" + Json_data[i].kpi_rel_type + "</td><td>" + Json_data[i].weightage + "</td><td>" + Json_data[i].parent_id + "</td><td><input type='text' onkeypress='return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57' name='min_value+" + (j = i + 1) + "' required></td><td><input type='text' onkeypress='return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57' name='max_value+" + (j = i + 1) + "' required></td></tr>")
                    }
                }
            }

        });


    });
</script>
<script>
    $("#qualify_criteria_sub").submit(function(e) {

        e.preventDefault();
        var form = $(this);
        var d = form.serializeArray();
        console.log(d);
        d.push({
            name: csfr_token_name,
            value: $.cookie(csfr_cookie_name)
        });
        d.push({
            name: "sys_lang_id",
            value: sys_lang_id
        });

        var url = form.attr('action');



        $.ajax({
            type: "POST",
            url: base_url + url,
            data: d,
            success: function(data) {
                // console.log(data);
                // var Json_data = JSON.parse(data);
                // console.log(Json_data.length);
                // var len = Json_data.length;

            }

        });

    });
</script>