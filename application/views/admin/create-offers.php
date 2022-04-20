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
<script>
    function startend() {
        var from = $("#start_date").val();
        var to = $("#end_date").val();
        if (from > to) {
            document.getElementById("btn-submit").disabled = true;
            document.getElementById("spanend_date1").style.display = "block";
        } else {
            document.getElementById("btn-submit").disabled = false;
            document.getElementById("spanend_date1").style.display = "none";

        }


    }
</script>
<?php $this->load->view('admin/includes/_messages'); ?>
<?php echo form_open('admin_controller/save_created_offers'); ?>
<div class="col-12 coupons-from-holder">
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label>Offer Name:</label></div>
            <div class="col-sm-6">
                <input type='text' name="offer_name" class="form-control auth-form-input" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label>Type:</label></div>
            <div class="col-sm-6">
                <select class="form-control auth-form-input" name="method_type" id="offer-type" onchange="myFunction()" required>
                    <option selected="true" disabled="disabled">Please select an option</option>
                    <option value="Flat">Flat</option>
                    <option value="Percentage">Percentage</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label for="cars">Method:</label></div>
            <div class="col-sm-6">
                <select class="form-control auth-form-input" name="coup_vou" id="method" onchange="couponvoucher()" required>
                    <option selected="true" disabled="disabled">Please select an option</option>
                    <option value="coupons">coupons</option>
                    <option value="vouchers">vouchers</option>
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
                <input type="datetime-local" id="start_date" onchange="startend()" class="form-control" name="start_date" value="<?php $date_time = new DateTime();
                                                                                                                                    echo $date_time->format("Y-m-d\TH:i:s"); ?>" required>

            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6">
                <label for="meeting-time">End date & Time:</label>
            </div>
            <div class="col-sm-6">
                <span><input type="datetime-local" id="end_date" onchange="startend()" class="form-control" name="end_date" value="<?php $date_time = new DateTime();
                                                                                                                                    echo $date_time->format("Y-m-d\TH:i:s"); ?>" required></span>
                <span id="spanend_date1" style="color:red;">Enter a valid date</span>
            </div>
        </div>
    </div>
    <div class="form-group" id="discount_amount">
        <div class="row">
            <div class="col-sm-6"><label>Discount Amount:</label></div>
            <div class="col-sm-6">
                <input type='number' name="discount_amt" onkeypress="return(event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" class="form-control auth-form-input" id="discount_on_percent">
            </div>
        </div>
    </div>
    <div class="form-group" id="discount_percentage">
        <div class="row">
            <div class="col-sm-6"><label>Discount Percentage:</label></div>
            <div class="col-sm-6">
                <input type='number' name="discount_per" onkeypress="return(event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" class="form-control auth-form-input" id="discount_per">
            </div>
        </div>
    </div>
    <div class="form-group" id="allowed_discount">
        <div class="row">
            <div class="col-sm-6"><label>Allowed Maximum Discount:</label></div>
            <div class="col-sm-6">
                <input type='number' name="allowed_max_discount" onkeypress="return(event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" class="form-control auth-form-input" id="allowed_max_discount">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label>Minimum amount in the cart:</label></div>
            <div class="col-sm-6">
                <input type='number' onkeypress="return(event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" name="min_discount" class="form-control auth-form-input" required>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label>Maximum total usage:</label></div>
            <div class="col-sm-6">
                <input type='number' name="max_usage"  onkeypress="return(event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" class="form-control auth-form-input" required>
            </div>
        </div>
    </div>
</div>



<div class="col-12 coupons-from-holder" id="for-coupons">
    <div class="form-group" id="coupon_code">
        <div class="row">
            <div class="col-sm-6"><label>Offer Code:</label></div>
            <div class="col-sm-6">
                <input type='text' name="coupon_code" class="form-control auth-form-input" id="code_on_coupon" required>
            </div>
        </div>
    </div>
    <div class="form-group" id="displaying_msg">
        <div class="row">
            <div class="col-sm-6"><label>Message to be displayed in the website:</label></div>
            <div class="col-sm-6">
                <input type='text' name="msg_displayed" class="form-control auth-form-input" id="msg_on_site">
            </div>
        </div>
    </div>
    <div class="form-group" id="max-usage-coupon">
        <div class="row">
            <div class="col-sm-6"><label>Max usage per user:</label></div>
            <div class="col-sm-6">
                <input type='number' name="max_usage_per_user" onkeypress="return(event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" class="form-control auth-form-input" id="usage_per_user_coupon">
            </div>
        </div>
    </div>
    <div class="form-group" id="terms">
        <div class="row">
            <div class="col-sm-6"><label>Add Terms & Conditions</label></div>
            <div class="col-sm-6">
                <input type='text' name="t_c_c" class="form-control auth-form-input" id="tc_on_coupon">
            </div>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" id="btn-submit" class="btn btn-lg btn-custom float-right"><?php echo trans("submit"); ?></button>
    </div>
</div>

<div class="col-12 coupons-from-holder" id="for-vouchers">
    <div class="form-group" id="voucher_code">
        <div class="row">
            <div class="col-sm-6"><label>Offer Code:</label></div>
            <div class="col-sm-6">
                <input type='text' name="voucher_code" class="form-control auth-form-input" id="code_on_voucher">
            </div>
        </div>
    </div>
    <div class="form-group" id="vouchers_required">
        <div class="row">
            <div class="col-sm-6"><label>Numbers of Vouchers required:</label></div>
            <div class="col-sm-6">
                <input type='number' name="vouchers_required" onkeypress="return(event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" id="vouchers_required_ese" class="form-control auth-form-input">
            </div>
        </div>
    </div>
    <div class="form-group" id="descritiopn_voucher">
        <div class="row">
            <div class="col-sm-6"><label>Description:</label></div>
            <div class="col-sm-6">
                <input type='text' name="description_voucher" id="desc_on_voucher" class="form-control auth-form-input">
            </div>
        </div>
    </div>
    <div class="form-group" id="conditions">
        <div class="row">
            <div class="col-sm-6"><label>Add Terms & Conditions</label></div>
            <div class="col-sm-6">
                <input type='text' name="t_c_v" class="form-control auth-form-input" id="tc_on_voucher">
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-lg btn-custom float-right"><?php echo trans("submit"); ?></button>
    </div>
</div>


<?php echo form_close(); ?>


<script>
    $(document).ready(function() {
        document.getElementById("discount_percentage").style.display = "none";
        document.getElementById("allowed_discount").style.display = "none";
        document.getElementById("discount_amount").style.display = "block";
        document.getElementById("for-coupons").style.display = "none";
        document.getElementById("for-vouchers").style.display = "none";
        document.getElementById("spanend_date1").style.display = "none";
    });

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
            $('#discount_on_percent').prop('required', false);
            document.getElementById("discount_percentage").style.display = "block";
            $('#discount_per').prop('required', true);
            document.getElementById("allowed_discount").style.display = "block";
            $('#allowed_max_discount').prop('required', true);
            $("#discount_on_percent")[0].value = "";
        }
    }

    function couponvoucher() {
        var Y = document.getElementById("method").value;
        if (Y == "coupons") {
            document.getElementById("for-coupons").style.display = "block";
            document.getElementById("for-vouchers").style.display = "none";
            $("#vouchers_required_ese")[0].value = "";
            $("#desc_on_voucher")[0].value = "";
            $("#tc_on_voucher")[0].value = "";
            document.getElementById("terms").style.display = "block";
            $('#tc_on_coupon').prop('required', true);
            document.getElementById("conditions").style.display = "none";
            $('#tc_on_voucher').prop('required', false);
            $("#code_on_coupon")[0].value = "";



            document.getElementById("displaying_msg").style.display = "block";
            $('#msg_on_site').prop('required', true);
            document.getElementById("max-usage-coupon").style.display = "block";
            $('#usage_per_user_coupon').prop('required', true);
            document.getElementById("vouchers_required").style.display = "none";
            $('#vouchers_required_ese').prop('required', false);
            document.getElementById("descritiopn_voucher").style.display = "none";
            $('#desc_on_voucher').prop('required', false);

        } else if (Y == "vouchers") {
            document.getElementById("for-coupons").style.display = "none";
            document.getElementById("for-vouchers").style.display = "block";
            // $("#code_on_coupon")[0].value = "";
            $("#msg_on_site")[0].value = "";
            $("#usage_per_user_coupon")[0].value = "";
            $("#tc_on_coupon")[0].value = "";

            document.getElementById("terms").style.display = "none";
            $('#tc_on_coupon').prop('required', false);
            document.getElementById("conditions").style.display = "block";
            $('#tc_on_voucher').prop('required', true);

            document.getElementById("displaying_msg").style.display = "none";
            $('#msg_on_site').prop('required', false);
            document.getElementById("max-usage-coupon").style.display = "none";
            $('#usage_per_user_coupon').prop('required', false);

            document.getElementById("vouchers_required").style.display = "block";
            $('#vouchers_required_ese').prop('required', true);

            document.getElementById("descritiopn_voucher").style.display = "block";
            $('#desc_on_voucher').prop('required', true);
        }
    }
</script>