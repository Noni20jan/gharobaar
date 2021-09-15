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
<div class="col-12 coupons-from-holder">
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label>Offer Name:</label></div>
            <div class="col-sm-6">
                <input type='text' name="brand_name" class="form-control auth-form-input" value="" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label>Type:</label></div>
            <div class="col-sm-6">
                <select class="form-control auth-form-input" id="offer-type" onchange="myFunction()">
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
                <select class="form-control auth-form-input" id="method" onchange="couponvoucher()">
                    <option selected="true" disabled="disabled">Please select an option</option>
                    <option value="coupons">coupons</option>
                    <option value="vouchers">vouchers</option>
                </select>
                <!-- <input list="method" name="coupon_type" class="form-control auth-form-input"> -->
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6">
                <label for="meeting-time">Start date & Time:</label>
            </div>
            <div class="col-sm-6">
                <input type="datetime-local" class="form-control" id="meeting-time" name="meeting-time" value="2018-06-12T19:30" min="2018-06-07T00:00" max="2018-06-14T00:00">
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6">
                <label for="meeting-time">End date & Time:</label>
            </div>
            <div class="col-sm-6">
                <input type="datetime-local" id="meeting-time" class="form-control" name="meeting-time" value="2018-06-12T19:30" min="2018-06-07T00:00" max="2018-06-14T00:00">
            </div>
        </div>
    </div>
    <div class="form-group" id="da">
        <div class="row">
            <div class="col-sm-6"><label>Discount Amount:</label></div>
            <div class="col-sm-6">
                <input type='number' name="brand_name" class="form-control auth-form-input" value="" required>
            </div>
        </div>
    </div>
    <div class="form-group" id="dp">
        <div class="row">
            <div class="col-sm-6"><label>Discount Percentage:</label></div>
            <div class="col-sm-6">
                <input type='number' name="brand_name" class="form-control auth-form-input" value="" required>
            </div>
        </div>
    </div>
    <div class="form-group" id="amd">
        <div class="row">
            <div class="col-sm-6"><label>Allowed Maximum Discount:</label></div>
            <div class="col-sm-6">
                <input type='number' name="brand_name" class="form-control auth-form-input" value="" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label>Minimum amount in the cart:</label></div>
            <div class="col-sm-6">
                <input type='number' name="brand_name" class="form-control auth-form-input" value="" required>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label>Maximum total usage:</label></div>
            <div class="col-sm-6">
                <input type='number' name="brand_name" class="form-control auth-form-input" value="" required>
            </div>
        </div>
    </div>

</div>



<div class="col-12 coupons-from-holder" id="for-coupons">
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label>Coupon Code:</label></div>
            <div class="col-sm-6">
                <input type='text' name="brand_name" class="form-control auth-form-input" value="" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label>Message to be displayed in the website:</label></div>
            <div class="col-sm-6">
                <input type='text' name="brand_name" class="form-control auth-form-input" value="" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label>Max usage per user:</label></div>
            <div class="col-sm-6">
                <input type='number' name="brand_name" class="form-control auth-form-input" value="" required>
            </div>
        </div>
    </div>
    <div class="row nxt-cancel-btns">
        <button class="nxt-cancel-styls" type="submit" value="Submit">Add Terms & Conditions</button>
    </div>
</div>

<div class="col-12 coupons-from-holder" id="for-vouchers">
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label>Numbers of Vouchers required:</label></div>
            <div class="col-sm-6">
                <input type='number' name="brand_name" class="form-control auth-form-input" value="" required>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label>Description:</label></div>
            <div class="col-sm-6">
                <input type='text' name="brand_name" class="form-control auth-form-input" value="" required>
            </div>
        </div>
    </div>

    <div class="row nxt-cancel-btns">
        <button class="nxt-cancel-styls" type="submit" value="Submit">Add Terms & Conditions</button>
    </div>
</div>





<script>
    $(document).ready(function() {
        document.getElementById("dp").style.display = "none";
        document.getElementById("amd").style.display = "none";
        document.getElementById("da").style.display = "block";
        document.getElementById("for-coupons").style.display = "none";
        document.getElementById("for-vouchers").style.display = "none";
    });

    function myFunction() {
        var x = document.getElementById("offer-type").value;
        if (x == "Flat") {
            document.getElementById("dp").style.display = "none";
            document.getElementById("amd").style.display = "none";
            document.getElementById("da").style.display = "block";

        } else if (x == "Percentage") {
            document.getElementById("da").style.display = "none";
            document.getElementById("dp").style.display = "block";
            document.getElementById("amd").style.display = "block";
        }
    }

    function couponvoucher() {
        var x = document.getElementById("method").value;
        if (x == "coupons") {
            document.getElementById("for-coupons").style.display = "block";
            document.getElementById("for-vouchers").style.display = "none";
        }
        if (x == "vouchers") {
            document.getElementById("for-coupons").style.display = "none";
            document.getElementById("for-vouchers").style.display = "block";
        }
    }
</script>