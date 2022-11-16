<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $check_option = true; ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/progress-tracker.css">
<style>
    @media(max-width:700px) {
        .svg-fotter {
            position: absolute;
            top: -6%;
            left: 0;
        }

        .btn-lg {
            width: 100%;
        }
    }

    .checkout-steps .divider {
        display: inline-block;
        border-top: 1px solid #696b79;
        height: 7px;
        width: 10%;
    }

    .checkout-steps .active {
        color: #000;
        border-bottom: none;
        font-weight: bold;

    }

    .checkout-steps .step {
        display: inline-block;
        letter-spacing: 0px;
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: bold;
        font-size: 20px;
    }



    .progress-tracker {
        margin: 0px;
        margin-top: 60px;
    }

    .btn-custom {
        background-color: #007C05;
        border-color: #007C05;
        font-weight: 600 !important;
    }
</style>
<?php $is_all_deliverable = 1;
foreach ($cart_items as $item) {
    if (!$item->product_deliverable) {
        $is_all_deliverable = 0;
        break;
    }
}
?>

<div class="tab-checkout tab-checkout-open summary-section">
    <div class="title">
        <h2 class="title" style="margin-top: 22px; margin-bottom:8px;">
            <?php if (!empty($cart_has_physical_product) && $this->form_settings->shipping == 1 && $mds_payment_type == "sale") {
                echo '2.';
            } else {
                echo '1.';
            } ?>
            &nbsp;<?php echo trans("payment_method"); ?></h2>
        <?php if ($check_exhibition && $this->general_settings->enable_exhibition) : ?>
        <?php elseif (!(($check_cashond) == "true" && ($check_made_to_order) == false)) : ?>
            <span class="cod_text"> <?php echo trans('cod_not_available'); ?></span>
        <?php endif; ?>
    </div>
    <?php echo form_open('payment-method-post', ['id' => 'form_validate', 'class' => 'validate_terms']); ?>
    <input type="hidden" name="mds_payment_type" value="<?php echo $mds_payment_type ?>">




    <!-- <div class="bg-light border-right" id="sidebar-wrapper">
                                        <div class="sidebar-heading pt-5 pb-4"><strong>PAY WITH</strong></div>
                                        <div class="list-group list-group-flush"> <a data-toggle="tab" href="#menu1" id="tab1" class="tabs list-group-item bg-light">
                                                <div class="list-div my-2">
                                                    <div class="fa fa-home"></div> &nbsp;&nbsp; Bank
                                                </div>
                                            </a> <a data-toggle="tab" href="#menu2" id="tab2" class="tabs list-group-item active1">
                                                <div class="list-div my-2">
                                                    <div class="fa fa-credit-card"></div> &nbsp;&nbsp; Card
                                                </div>
                                            </a> <a data-toggle="tab" href="#menu3" id="tab3" class="tabs list-group-item bg-light">
                                                <div class="list-div my-2">
                                                    <div class="fa fa-qrcode"></div> &nbsp;&nbsp;&nbsp; Visa QR <span id="new-label">NEW</span>
                                                </div>
                                            </a> </div>
                                    </div> -->





    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <ul class="payment-options-list">
                    <?php if ($this->payment_settings->paypal_enabled) : ?>
                        <li>
                            <div class="option-payment">
                                <div class="list-left">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="option_paypal" name="payment_option" value="paypal" checked required>
                                        <label class="custom-control-label label-payment-option" for="option_paypal"><?php echo trans("paypal"); ?></label>
                                    </div>
                                </div>
                                <div class="list-right">
                                    <label for="option_paypal">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/visa.svg" alt="visa">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/mastercard.svg" alt="mastercard">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/amex.svg" alt="amex">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/discover.svg" alt="discover">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/paypal.svg" alt="paypal">
                                    </label>
                                </div>
                            </div>
                        </li>
                    <?php $check_option = false;
                    endif; ?>
                    <?php if ($this->payment_settings->stripe_enabled) : ?>
                        <li>
                            <div class="option-payment">
                                <div class="list-left">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="option_stripe" name="payment_option" value="stripe" required <?php echo ($check_option == true) ? 'checked' : ''; ?>>
                                        <label class="custom-control-label label-payment-option" for="option_stripe"><?php echo trans("stripe"); ?></label>
                                    </div>
                                </div>
                                <div class="list-right">
                                    <label for="option_stripe">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/visa.svg" alt="visa">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/mastercard.svg" alt="mastercard">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/amex.svg" alt="amex">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/stripe.svg" alt="stripe">
                                    </label>
                                </div>
                            </div>
                        </li>
                    <?php $check_option = false;
                    endif; ?>
                    <?php if ($this->payment_settings->paystack_enabled) : ?>
                        <li>
                            <div class="option-payment">
                                <div class="list-left">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="option_paystack" name="payment_option" value="paystack" required <?php echo ($check_option == true) ? 'checked' : ''; ?>>
                                        <label class="custom-control-label label-payment-option" for="option_paystack"><?php echo trans("paystack"); ?></label>
                                    </div>
                                </div>
                                <div class="list-right">
                                    <label for="option_paystack">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/visa.svg" alt="visa">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/mastercard.svg" alt="mastercard">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/verve.svg" alt="verve">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/paystack.png" alt="paystack">
                                    </label>
                                </div>
                            </div>
                        </li>
                    <?php $check_option = false;
                    endif; ?>
                    <?php if ($this->payment_settings->razorpay_enabled) : ?>
                        <li>
                            <div class="option-payment">
                                <div class="list-left">
                                    <div class="custom-control custom-radio">
                                        <!-- <input type="radio" class="custom-control-input" id="option_razorpay" name="payment_option" value="razorpay" required <?php echo ($check_option == true) ? 'checked' : ''; ?>>
                                                                        <label class="custom-control-label label-payment-option" for="option_razorpay">Razorpay</label> -->
                                        <input type="radio" class="custom-control-input" id="option_razorpay" name="payment_option" value="cashfree" onclick="changeViewPayment()" required <?php echo ($check_option == true) ? 'checked' : ''; ?>>
                                        <label class="custom-control-label label-payment-option" for="option_razorpay"><?php echo trans("pay_online"); ?></label>
                                    </div>
                                </div>
                                <div class="list-right">
                                    <label for="option_razorpay">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/visa.svg" alt="visa">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/mastercard.svg" alt="mastercard">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/amex.svg" alt="amex">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/maestro.svg" alt="maestro">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/diners.svg" alt="diners">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/rupay.svg" alt="rupay" style="padding: 1px 0;">
                                        <!-- <img src="<?php echo base_url(); ?>assets/img/payment/razorpay.svg" alt="razorpay"> -->
                                    </label>
                                </div>
                            </div>
                        </li>
                    <?php $check_option = false;
                    endif; ?>
                    <?php if ($this->payment_settings->iyzico_enabled) : ?>
                        <li>
                            <div class="option-payment">
                                <div class="list-left">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="option_iyzico" name="payment_option" value="iyzico" required <?php echo ($check_option == true) ? 'checked' : ''; ?>>
                                        <label class="custom-control-label label-payment-option" for="option_iyzico"><?php echo trans("iyzico"); ?></label>
                                    </div>
                                </div>
                                <div class="list-right">
                                    <label for="option_iyzico">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/visa.svg" alt="visa">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/mastercard.svg" alt="mastercard">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/amex.svg" alt="amex">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/troy.png" alt="troy">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/iyzico.svg" alt="iyzico">
                                    </label>
                                </div>
                            </div>
                        </li>
                    <?php $check_option = false;
                    endif; ?>
                    <?php if ($this->payment_settings->pagseguro_enabled) : ?>
                        <li>
                            <div class="option-payment">
                                <div class="list-left">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="option_pagseguro" name="payment_option" value="pagseguro" required <?php echo ($check_option == true) ? 'checked' : ''; ?>>
                                        <label class="custom-control-label label-payment-option" for="option_pagseguro"><?php echo trans("pagseguro"); ?></label>
                                    </div>
                                </div>
                                <div class="list-right">
                                    <label for="option_pagseguro">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/visa.svg" alt="visa">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/mastercard.svg" alt="mastercard">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/amex.svg" alt="amex">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/elo.svg" alt="elo">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/diners.svg" alt="diners">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/hipercard.svg" alt="hipercard">
                                        <img src="<?php echo base_url(); ?>assets/img/payment/pagseguro.png" alt="pagseguro">
                                    </label>
                                </div>
                            </div>
                        </li>
                    <?php $check_option = false;
                    endif; ?>
                    <?php if ($this->payment_settings->bank_transfer_enabled) : ?>
                        <li>
                            <div class="option-payment">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" id="option_bank" name="payment_option" value="bank_transfer" required <?php echo ($check_option == true) ? 'checked' : ''; ?>>
                                    <label class="custom-control-label label-payment-option" for="option_bank"><?php echo trans("bank_transfer"); ?><br><small><?php echo trans("bank_transfer_exp"); ?></small></label>
                                </div>
                            </div>
                        </li>
                    <?php $check_option = false;
                    endif; ?>
                    <?php if ($this->auth_check == 1 && $this->payment_settings->cash_on_delivery_enabled && empty($cart_has_digital_product)  && $mds_payment_type == "sale") : ?>
                        <li>
                            <div class="option-payment">
                                <div class="custom-control custom-radio">
                                    <?php if ($check_exhibition && $this->general_settings->enable_exhibition) : ?>
                                        <input type="radio" class="custom-control-input" id="option_cash_on_delivery" name="payment_option" onclick="changeViewPayment()" value="cash_on_delivery" required <?php echo ($check_option == true) ? 'checked' : ''; ?>>
                                        <label class="custom-control-label label-payment-option" for="option_cash_on_delivery"><?php echo trans("cash_on_delivery_fee"); ?><br><small><?php echo trans("cash_on_delivery_exp"); ?></small></label>
                                    <?php elseif (($check_cashond) == "true" && ($check_made_to_order) == false) : ?>
                                        <?php if ($this->general_settings->enable_freeship_message == 1) : ?>
                                            <?php if ($cart_total->total <= 200000) : ?>
                                                <input type="radio" class="custom-control-input" id="option_cash_on_delivery" name="payment_option" value="cash_on_delivery" onclick="changeViewPayment()" required <?php echo ($check_option == true) ? 'checked' : ''; ?>>
                                                <label class="custom-control-label label-payment-option" for="option_cash_on_delivery"><?php echo trans("cash_on_delivery"); ?><br><small><?php echo trans("cash_on_delivery_exp"); ?></small></label>
                                            <?php elseif ($cart_total->total > 200000) : ?>
                                                <span class="cod_text"> <?php echo trans('cod_disabled'); ?></span>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <?php if ($this->general_settings->enable_freeship_message == 1) : ?>
                                                <?php if ($cart_total->total <= 200000) : ?>
                                                    <input type="radio" class="custom-control-input" id="option_cash_on_delivery" name="payment_option" value="cash_on_delivery" onclick="changeViewPayment()" required <?php echo ($check_option == true) ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label label-payment-option" for="option_cash_on_delivery"><?php echo trans("cash_on_delivery"); ?><br><small><?php echo trans("cash_on_delivery_exp"); ?></small></label>
                                                <?php elseif ($cart_total->total > 200000) : ?>
                                                    <span class="cod_text"> <?php echo trans('cod_disabled'); ?></span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="form-group" style="display: none;">
                <div class="custom-control custom-checkbox custom-control-validate-input">
                    <input type="checkbox" class="custom-control-input" name="terms" id="checkbox_terms_pay" checked>
                    <label for="checkbox_terms_pay" class="custom-control-label"><?php echo trans("terms_conditions_exp"); ?>&nbsp;
                        <?php $page_terms = get_page_by_default_name("terms_conditions", $this->selected_lang->id);
                        if (!empty($page_terms)) : ?>
                            <a href="<?= generate_url($page_terms->page_default_name); ?>" class="link-terms" target="_blank"><strong><?= html_escape($page_terms->title); ?></strong></a>
                        <?php endif; ?>
                    </label>
                </div>
            </div>

            <!-- <div class="form-group m-t-15">
                                                <?php if ($mds_payment_type == "sale") : ?> -->
            <!-- <a href="<?php echo generate_url("cart"); ?>" class="btn btn-lg btn-custom">
                                                        &nbsp;<?php echo trans("return_to_cart"); ?></a> -->
            <!-- <a href="<?php echo generate_url("cart", "shipping"); ?>" class="btn btn-lg btn-custom btn-continue-payment float-left" style="margin-bottom: 10px !important;"> <?php echo trans("change_address"); ?></a>
                                                <?php endif; ?>
                                                <button type="submit" name="submit" value="update" class="btn btn-lg btn-custom btn-continue-payment float-right" <?= $is_all_deliverable ? "" : "disabled"; ?>><?php echo trans("continue_to_payment") ?></button>
                                            </div> -->
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<div class="tab-checkout tab-checkout-closed-bordered">
    <h2 class="title">
        <?php if (!empty($cart_has_physical_product) && $this->form_settings->shipping == 1 && $mds_payment_type == "sale") {
            echo '3.';
        } else {
            echo '2.';
        } ?>
        &nbsp;<?php echo trans("payment"); ?>
    </h2>
    <div id='pay_view_load' style="margin-top: 30px;">
        <?php if (!empty($cart_has_physical_product) && $this->form_settings->shipping == 1 && $mds_payment_type == "sale") {
            $data = array('total_amount' => $total_amount, 'currency' => $currency, 'mds_payment_type' => $mds_payment_type, 'cart_total' => $cart_total, 'cart_items' => $cart_items);
            $this->load->view("cart/payment_methods/cashfree", $data);
        }
        ?>
    </div>
</div>



<!-- Wrapper End-->