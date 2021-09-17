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
                <input type="dateTime-local" value="<?php echo $offer->start_date; ?>" class="form-control" id="meeting-time" name="start_date" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6">
                <label for="meeting-time">End date & Time:</label>
            </div>
            <div class="col-sm-6">
                <input type="dateTime-local" id="meeting-time" value="<?php echo $offer->end_date; ?>" class="form-control" name="end_date" required>
            </div>
        </div>
    </div>
    <div class="form-group" id="discount_amount">
        <div class="row">
            <div class="col-sm-6"><label>Discount Amount:</label></div>
            <div class="col-sm-6">
                <input type='number' name="discount_amt" value="<?php echo $offer->discount_amt; ?>" class="form-control auth-form-input" id="discount_on_percent" value=" ">
            </div>
        </div>
    </div>
    <div class="form-group" id="discount_percentage">
        <div class="row">
            <div class="col-sm-6"><label>Discount Percentage:</label></div>
            <div class="col-sm-6">
                <input type='number' name="discount_per" value="<?php echo $offer->discount_percentage; ?>" class="form-control auth-form-input" id="discount_per" value="">
            </div>
        </div>
    </div>
    <div class="form-group" id="allowed_discount">
        <div class="row">
            <div class="col-sm-6"><label>Allowed Maximum Discount:</label></div>
            <div class="col-sm-6">
                <input type='number' name="allowed_max_discount" value="<?php echo $offer->allowed_max_discount; ?>" class="form-control auth-form-input" id="allowed_max_discount" value="">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label>Minimum amount in the cart:</label></div>
            <div class="col-sm-6">
                <input type='number' name="min_discount" value="<?php echo $offer->min_amt_in_cart; ?>" class="form-control auth-form-input" value="" required>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label>Maximum total usage:</label></div>
            <div class="col-sm-6">
                <input type='number' name="max_usage" value="<?php echo $offer->max_total_usage; ?>" class=" form-control auth-form-input" value="" required>
            </div>
        </div>
    </div>
</div>



<div class="col-12 coupons-from-holder" id="for-coupons">
    <div class="form-group" id="coupon_code">
        <div class="row">
            <div class="col-sm-6"><label>Coupon Code:</label></div>
            <div class="col-sm-6">
                <input type='text' name="coupon_code" class="form-control auth-form-input" id="code_on_coupon" value="">
            </div>
        </div>
    </div>
    <div class="form-group" id="displaying_msg">
        <div class="row">
            <div class="col-sm-6"><label>Message to be displayed in the website:</label></div>
            <div class="col-sm-6">
                <input type='text' name="msg_displayed" value="<?php echo $offer->msg_to_be_displayed ?>" class="form-control auth-form-input" id="msg_on_site" value="">
            </div>
        </div>
    </div>
    <div class="form-group" id="max-usage-coupon">
        <div class="row">
            <div class="col-sm-6"><label>Max usage per user:</label></div>
            <div class="col-sm-6">
                <input type='number' name="brand_name" value="<?php echo $offer->max_usage_per_user ?>" class="form-control auth-form-input" id="usage_per_user_coupon" value="">
            </div>
        </div>
    </div>
    <div class="form-group" id="terms">
        <div class="row">
            <div class="col-sm-6"><label>Add Terms & Conditions</label></div>
            <div class="col-sm-6">
                <input type='text' name="t_&_c" value="<?php echo $offer->terms_and_conditions ?>" class="form-control auth-form-input" id="tc_on_coupon" value="">
            </div>
        </div>
    </div>

</div>

<div class="col-12 coupons-from-holder" id="for-vouchers">
    <div class="form-group" id="vouchers_required">
        <div class="row">
            <div class="col-sm-6"><label>Numbers of Vouchers required:</label></div>
            <div class="col-sm-6">
                <input type='number' name="vouchers_required" value="<?php echo $offer->no_off_voucher_req ?>" id="vouchers_required_ese" class="form-control auth-form-input">
            </div>
        </div>
    </div>
    <div class="form-group" id="descritiopn_voucher">
        <div class="row">
            <div class="col-sm-6"><label>Description:</label></div>
            <div class="col-sm-6">
                <input type='text' name="description" id="desc_on_voucher" value="<?php echo $offer->description ?>" class="form-control auth-form-input" value="">
            </div>
        </div>
    </div>
    <div class="form-group" id="conditions">
        <div class="row">
            <div class="col-sm-6"><label>Add Terms & Conditions</label></div>
            <div class="col-sm-6">
                <input type='text' name="t_&_c" value="<?php echo $offer->terms_and_conditions ?>" class="form-control auth-form-input" id="tc_on_voucher" value="">
            </div>
        </div>
    </div>

</div>

<div class="box-footer">
    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
</div>

<?php echo form_close(); ?>