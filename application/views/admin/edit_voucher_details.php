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
<?php echo form_open('Coupon_controller/edit_details_coupon'); ?>
<input type="hidden" name="id" value="<?php echo $offer->id; ?>">
<div class="col-12 coupons-from-holder">
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label>Offer Name:</label></div>
            <div class="col-sm-6">
                <input type='text' value="<?php echo $offer->name; ?>" name="offer_name" class="form-control auth-form-input" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label>Type:</label></div>
            <div class="col-sm-6">
                <select class="form-control auth-form-input" name="method_type" id="offer-type" onchange="myFunction()" required>

                    <option <?php if ($offer->type == "Flat") echo 'selected="selected"'; ?>value="Flat">Flat</option>
                    <option <?php if ($offer->type == "Percentage") echo 'selected="selected"'; ?> value="Percentage">Percentage</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label for="cars">Method:</label></div>
            <div class="col-sm-6">
                <!-- <select class="form-control auth-form-input" name="coup_vou" id="method" onchange="couponvoucher()" required> -->
                <input class="form-control auth-form-input" name="coup_vou" type="text" value="vouchers" readonly>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6">
                <label for="meeting-time">Start date & Time:</label>
            </div>
            <div class="col-sm-6">
                <?php
                $t = $offer->start_date;
                $date = strtotime($t);
                $date_time = date("Y-m-d\TH:i:s", $date);
                ?>
                <input type="datetime-local" value="<?php echo $date_time; ?>" class="form-control" id="voucherstart-time" onchange="vouchertime()"  name="start_date" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6">
                <label for="meeting-time">End date & Time:</label>
            </div>
            <div class="col-sm-6">
                <?php
                $t = $offer->end_date;
                $date = strtotime($t);
                $date_time = date("Y-m-d\TH:i:s", $date);
                ?>
                <input type="datetime-local" id="voucherend-time" onchange="vouchertime()" value="<?php echo $date_time; ?>" class="form-control" name="end_date" required>
                <span id="voucher_date1" style="color:red;">Enter a valid date</span>
            </div>
        </div>
    </div>
    <div class="form-group" id="discount_amount">
        <div class="row">
            <div class="col-sm-6"><label>Discount Amount:</label></div>
            <div class="col-sm-6">
                <input type='number' name="discount_amt" value="<?php echo $offer->discount_amt; ?>" class="form-control auth-form-input" id="discount_on_percent">
            </div>
        </div>
    </div>
    <div class="form-group" id="discount_percentage">
        <div class="row">
            <div class="col-sm-6"><label>Discount Percentage:</label></div>
            <div class="col-sm-6">
                <input type='number' name="discount_per" value="<?php echo $offer->discount_percentage; ?>" class="form-control auth-form-input" id="discount_per">
            </div>
        </div>
    </div>
    <div class="form-group" id="allowed_discount">
        <div class="row">
            <div class="col-sm-6"><label>Allowed Maximum Discount:</label></div>
            <div class="col-sm-6">
                <input type='number' name="allowed_max_discount" value="<?php echo $offer->allowed_max_discount; ?>" class="form-control auth-form-input" id="allowed_max_discount">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label>Minimum amount in the cart:</label></div>
            <div class="col-sm-6">
                <input type='number' name="min_discount" value="<?php echo $offer->min_amt_in_cart; ?>" class="form-control auth-form-input" required>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label>Maximum total usage:</label></div>
            <div class="col-sm-6">
                <input type='number' name="max_usage" value="<?php echo $offer->max_total_usage; ?>" class=" form-control auth-form-input" required>
            </div>
        </div>
    </div>
</div>

<div class="col-12 coupons-from-holder" id="for-vouchers">
    <div class="form-group" id="voucher_code">
        <div class="row">
            <div class="col-sm-6"><label>Offer Code:</label></div>
            <div class="col-sm-6">
                <input type='text' name="voucher_code" value="<?php echo $offer->offer_code; ?>" class="form-control auth-form-input" id="code_on_voucher">
            </div>
        </div>
    </div>
    <div class="form-group" id="vouchers_required">
        <div class="row">
            <div class="col-sm-6"><label>Numbers of Vouchers required:</label></div>
            <div class="col-sm-6">
                <input type='number' name="vouchers_required" value="<?php echo $offer->no_off_voucher_req ?>" id="vouchers_required_ese" class="form-control auth-form-input" required>
            </div>
        </div>
    </div>
    <div class="form-group" id="descritiopn_voucher">
        <div class="row">
            <div class="col-sm-6"><label>Description:</label></div>
            <div class="col-sm-6">
                <input type='text' name="description" id="desc_on_voucher" value="<?php echo $offer->description ?>" class="form-control auth-form-input" required>
            </div>
        </div>
    </div>
    <div class="form-group" id="conditions">
        <div class="row">
            <div class="col-sm-6"><label>Add Terms & Conditions</label></div>
            <div class="col-sm-6">
                <input type='text' name="t_c_v" value="<?php echo $offer->terms_and_conditions ?>" class="form-control auth-form-input" id="tc_on_voucher" required>
            </div>
        </div>
    </div>

</div>

<div class="box-footer">
    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
</div>

<?php echo form_close(); ?>
<script>
    function vouchertime() {
        var fromstart = $("#voucherstart-time").val();
        var toend = $("#voucherend-time").val();
        if (fromstart > toend) {
            document.getElementById("voucher_date1").style.display = "block";
        } else {
            document.getElementById("voucher_date1").style.display = "none";
        }
    }
    function myFunction() {
        var x = document.getElementById("offer-type").value;
        if (x == "Flat") {
            document.getElementById("discount_percentage").style.display = "none";
            $('#discount_per').prop('required', false);
            document.getElementById("allowed_discount").style.display = "none";
            $('#allowed_max_discount').prop('required', false);
            document.getElementById("discount_amount").style.display = "block";
            $('#discount_on_percent').prop('required', true);
            $("#discount_per")[0].value = "";
            $("#allowed_max_discount")[0].value = "";
        } else if (x == "Percentage") {
            document.getElementById("discount_amount").style.display = "none";
            $('#discount_amount').prop('required', false);
            document.getElementById("discount_percentage").style.display = "block";
            $('#discount_per').prop('required', true);
            document.getElementById("allowed_discount").style.display = "block";
            $('#allowed_max_discount').prop('required', true);
            $("#discount_on_percent")[0].value = "";
        }
    }



    $(document).ready(function() {
        document.getElementById("voucher_date1").style.display = "none";
        if (document.getElementById("offer-type").value == 'Flat') {
            document.getElementById("discount_percentage").style.display = "none";
            $('#discount_per').prop('required', false);
            document.getElementById("allowed_discount").style.display = "none";
            $('#allowed_max_discount').prop('required', false);
            document.getElementById("discount_amount").style.display = "block";
            $('#discount_on_percent').prop('required', true);
            $("#discount_per")[0].value = "";
            $("#allowed_max_discount")[0].value = "";
        } else {
            document.getElementById("discount_amount").style.display = "none";
            $('#discount_amount').prop('required', false);
            document.getElementById("discount_percentage").style.display = "block";
            $('#discount_per').prop('required', true);
            document.getElementById("allowed_discount").style.display = "block";
            $('#allowed_max_discount').prop('required', true);
            $("#discount_on_percent")[0].value = "";
        }
    });
</script>