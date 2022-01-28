<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php echo form_open('cart_controller/payment_cashfree', ['id' => 'form_submit_disable']); ?>
<style>
    .shipping_details {
        text-align: justify;
    }

    .block-title {
        text-align: start;
    }

    .block-title2 {
        margin-top: 5px;
        text-align: start;
    }

    p {
        margin: 5px;
    }

    @media (max-width: 700px) {
        .cash_free_btn {
            background-color: #d21f3c !important;
            cursor: pointer;
            color: #fff !important;
            font-weight: 600 !important;
            padding: .64rem 2.8rem !important;
            min-width: 100% !important;
            max-width: 100% !important;
        }
    }

    @media only screen and (max-width: 800px) {
        .shipping_details {
            text-align: justify;
            margin-left: 4%;
        }

        #place_order {

            margin-right: 23%;
            margin-bottom: 14px;

        }

        .billing_details {
            text-align: justify;
            margin-left: 4%;

        }

        #city {
            margin-left: 1%;
        }

        p {
            margin: 0px;
        }

        a {
            margin-bottom: 10px !important;
        }

        .method_name {
            margin-bottom: 10px;
        }
    }

    #payment_option {
        text-align: start;
    }

    #place_order {
        margin-right: 23%;
        margin-bottom: 11px;
    }

    .billing_details {
        text-align: justify;
    }

    .cash_free_btn {
        background-color: #d21f3c !important;
        cursor: pointer;
        color: #fff !important;
        font-weight: 600 !important;
        padding: .64rem 2.8rem !important;
        min-width: 200px;
        max-width: 100% !important;
    }

    #paynow-for-web {
        display: flex;
    }

    #paynow-for-mobile {
        display: none;
    }

    @media(max-width:768px) {
        #paynow-for-web {
            display: none !important;
        }

        #paynow-for-mobile {
            display: block !important;
        }
    }
</style>


<input type="hidden" name="orderid" value="<?php echo (uniqid()) ?>">
<input type="hidden" name="orderamount" value="<?php echo ($total_amount) / 100 ?>">

<div id="payment-button-container">
    <div class="row">
        <div class="col-12">
            <?php $this->load->view('product/_messages'); ?>
        </div>
    </div>
    <div class="row">

        <div class="col-md-6">
            <h5 class="block-title" id="shipping"><?php echo trans("shipping_address") ?></h5>
            <?php $address = $this->session->userdata("mds_cart_shipping_address") ?>

            <div class="shipping_details">
                <p><?php echo $address->shipping_first_name . " " . $address->shipping_last_name ?></p>
                <p><?php echo $address->shipping_address_1 ?></p>
                <p><?php echo $address->shipping_area ?></p>
                <p><?php echo $address->shipping_landmark ?></p>
                <p><?php echo $address->shipping_city . "," . $address->shipping_state . " -" . $address->shipping_zip_code ?>
                <div id="phone_number"> <label>Phone:</label><span>
                        <?php echo $address->shipping_phone_number ?>
                    </span>
                    </label>
                </div>


            </div>

        </div>
        <div class="col-md-6">
            <div class="cashfree_payment">
                <h5 class="block-title" id="billing"><?php echo trans("billing_address") ?></h5>
                <?php $address = $this->session->userdata("mds_cart_shipping_address") ?>

                <div class="billing_details">
                    <p><?php echo $address->billing_first_name . " " . $address->billing_last_name ?></p>
                    <p><?php echo $address->billing_address_1 ?></p>
                    <p><?php echo $address->billing_area ?></p>
                    <p><?php echo $address->billing_landmark ?></p>

                    <p><?php echo $address->billing_city . "," . $address->billing_state . " -" . $address->billing_zip_code ?>
                    <div id="phone_number"> <label>Phone:</label><span>
                            <?php echo $address->billing_phone_number ?>
                        </span>
                        </label>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />
    <br />
    <div class="row">
        <div class="col-sm-12">
            <div class="cash_method">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="block-title" id="payment"><?php echo trans("payment_method") ?></h5>
                    </div>
                    <div class="col-md-6 method_name">
                        <p id="payment_option"><?php echo trans("pay_online"); ?></p>
                    </div>
                </div>
            </div>

        </div>


    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php $modes = get_payment_modes(); ?>
            <!-- <div class="cash_method"> -->
            <div class="row">
                <div class="col-md-6">
                    <h6 class="block-title" id="payment"><?php echo trans("payment_mode") ?></h6>
                </div>
                <div class="col-md-6 method_name">
                    <select name="payment_mode" id="payment_mode" class="form-control custom-select2" onchange='check_mode(this.value);' required>
                        <option value="" disabled selected>Select Mode</option>
                        <?php foreach ($modes as $mode) : ?>
                            <option value="<?php echo html_escape($mode->gateway_code); ?>" myTag="<?php $mode->meaning ?>"><?php echo $mode->meaning ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <!-- </div> -->

        </div>
    </div>
    <div class="row" id="nb_banks" style="display: none;">
        <div class="col-sm-12">
            <?php $nb_banks = get_nb_banks(); ?>
            <div class="row">
                <div class="col-md-6">
                    <h6 class="block-title" id="payment"><?php echo trans("select_bank") ?></h6>
                </div>
                <div class="col-md-6 method_name">
                    <select name="bank_select" id="bank_select" class="form-control custom-select2">
                        <option value="" disabled selected>Select Bank</option>
                        <?php foreach ($nb_banks as $bank) : ?>
                            <option value="<?php echo html_escape($bank->option_code); ?>" myTag="<?php $bank->meaning ?>"><?php echo $bank->meaning ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="wallets" style="display: none;">
        <div class="col-sm-12">
            <?php $wallets = get_wallets(); ?>
            <div class="row">
                <div class="col-md-6">
                    <h6 class="block-title" id="payment"><?php echo trans("select_wallet") ?></h6>
                </div>
                <div class="col-md-6 method_name">
                    <select name="wallet_select" id="wallet_select" class="form-control custom-select2">
                        <option value="" disabled selected>Select Wallet</option>
                        <?php foreach ($wallets as $wallet) : ?>
                            <option value="<?php echo html_escape($wallet->option_code); ?>" myTag="<?php $wallet->meaning ?>"><?php echo $wallet->meaning ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 3%;" id="paynow-for-web">
        <div class="col-sm-6">
            <a class="cash_free_btn btn btn-sm float-left" style="margin-bottom: 30px;" href='<?php echo generate_url("cart", "payment_method") . "?payment_type=sale" ?>'><?php echo trans("change_pay_method") ?></a>
        </div>
        <div class="col-sm-6">
            <button type="submit" id="cashfreebtn" class="cash_free_btn btn btn-lg float-right" style="margin-bottom: 30px;"><?php echo trans("pay_now") ?></button>
        </div>
    </div>
    <div class="row" style="margin-top: 3%;" id="paynow-for-mobile">
        <div class="col-sm-6">
            <button type="submit" id="cashfreebtn" class="cash_free_btn btn btn-lg float-right" style="margin-bottom: 30px;"><?php echo trans("pay_now") ?></button>
        </div>
        <div class="col-sm-6">
            <a class="cash_free_btn btn btn-sm float-left" style="margin-bottom: 30px;" href='<?php echo generate_url("cart", "payment_method") . "?payment_type=sale" ?>'><?php echo trans("change_pay_method") ?></a>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<script>
    function check_mode(val) {
        var element = $("#nb_banks");
        var element2 = $("#wallets");
        if (val == 'nb') {
            // element.show();
            $("#nb_banks").css("display", "block");
            element2.hide();
            document.getElementById('bank_select').required = true;
            document.getElementById('wallet_select').required = false;
        } else if (val == 'wallet') {
            element2.show();
            element.hide();
            document.getElementById('wallet_select').required = true;
            document.getElementById('bank_select').required = false;
        } else {
            element.hide();
            document.getElementById('bank_select').required = false;
            document.getElementById('bank_select').required = false;
            element2.hide();
        }
    }
</script>
<script>
    $(document).ready(function() {

        $("#form_submit_disable").submit(function(e) {

            // e.preventDefault();
            $("#cashfreebtn").attr("disabled", true);

            return true;

        });
    });
</script>