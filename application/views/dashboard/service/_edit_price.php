<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if ($product->listing_type == 'sell_on_site') : ?>
    <div class="form-box form-box-price">
        <div class="form-box-head">
            <h4 class="title">Service Charge per Month</h4>
        </div>
        <div class="form-box-body">
            <div id="price_input_container" class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 m-b-sm-15">
                        <label class="font-600"><?php echo trans("price"); ?></label>
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo get_currency($this->payment_settings->default_currency); ?></span>
                            <input type="hidden" name="currency" value="<?php echo $this->payment_settings->default_currency; ?>">
                            <input type="text" name="price" id="product_price_input" aria-describedby="basic-addon1" class="form-control form-input price-input validate-price-input" value="<?php echo ($product->price != 0) ? get_price($product->price, 'input') : ''; ?>" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" <?= $product->is_free_product != 1 ? 'required' : ''; ?>>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 m-b-sm-15">
                        <div class="row align-items-center">
                            <div class="col-sm-12">
                                <label class="font-600"><?php echo trans("discount_rate"); ?></label>
                                <div id="discount_input_container" class="<?php echo ($product->discount_rate == 0) ? 'display-none' : ''; ?>">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="hidden" name="currency" value="<?php echo $this->payment_settings->default_currency; ?>">
                                        <input type="number" name="discount_rate" id="input_discount_rate" aria-describedby="basic-addon-discount" class="form-control form-input" value="<?php echo $product->discount_rate; ?>" min="0" max="99">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 m-t-10">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="discount_rate" id="checkbox_discount_rate" <?php echo ($product->discount_rate == 0) ? 'checked' : ''; ?>>
                                    <label for="checkbox_discount_rate" class="custom-control-label"><?php echo trans("no_discount"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($this->general_settings->gst_status == 1) : ?>
                        <div class="col-xs-12 col-sm-4">
                            <div class="row align-items-center">
                                <div class="col-sm-12">
                                    <label class="font-600"><?php echo trans("gst"); ?><small>&nbsp;(<?php echo trans("gst_exp"); ?>)</small></label>
                                    <div id="vat_input_container" class="<?php echo ($product->gst_rate == 0) ? 'display-none' : ''; ?>">
                                        <div class="input-group">
                                            <span class="input-group-addon">%</span>
                                            <input type="hidden" name="currency" value="<?php echo $this->payment_settings->default_currency; ?>">
                                            <input type="number" name="gst_rate" id="input_gst_rate" aria-describedby="basic-addon-gst" class="form-control form-input" value="<?php echo $product->gst_rate; ?>" min="0" max="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 m-t-10">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="vat_included" id="checkbox_gst_included" <?php echo ($product->gst_rate == 0) ? 'checked' : ''; ?>>
                                        <label for="checkbox_gst_included" class="custom-control-label"><?php echo trans("gst_included"); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-sm-12 m-t-30">
                        <p class="calculated-price">
                            <strong><?php echo trans("calculated_price"); ?> (<?php echo get_currency($this->payment_settings->default_currency); ?>):&nbsp;&nbsp;</strong>
                            <b id="calculated_amount" class="earned-price">
                                <?php $earned_amount = calculate_product_price($product->price, $product->discount_rate, $product->gst_rate);
                                $earned_amount = number_format($earned_amount, 2, '.', '');
                                echo get_price($earned_amount, 'input'); ?>
                            </b>
                        </p>
                        <p class="calculated-price calculated_gst_container <?php echo ($product->gst_rate == 0) ? 'display-none' : ''; ?>">
                            <strong><?php echo trans("gst"); ?> (<?php echo get_currency($this->payment_settings->default_currency); ?>):&nbsp;&nbsp;</strong>
                            <b id="gst_amount" class="earned-price">
                                <?php $earned_amount = calculate_product_gst($product);
                                $earned_amount = number_format($earned_amount, 2, '.', '');
                                echo get_price($earned_amount, 'input'); ?>
                            </b>
                        </p>
                        <p class="calculated-price">
                            <strong><?php echo trans("you_will_earn"); ?> (<?php echo get_currency($this->payment_settings->default_currency); ?>):&nbsp;&nbsp;</strong>
                            <b id="earned_amount" class="earned-price">
                                <?php $earned_amount = calculate_earned_amount($product);
                                $earned_amount = number_format($earned_amount, 2, '.', '');
                                echo get_price($earned_amount, 'input'); ?>
                            </b>
                            <?php if ($product->product_type != 'digital') : ?>
                                &nbsp;&nbsp;&nbsp;<b>+&nbsp;&nbsp;&nbsp;Travelling Cost</b>&nbsp;&nbsp;
                            <?php endif; ?>
                            <small> (<?php echo trans("commission_rate"); ?>:&nbsp;&nbsp;<?php echo calculate_commission_rate_seller($user->id); ?>%)</small>
                        </p>
                    </div>
                </div>
            </div>
            <?php if ($product->product_type == 'digital') : ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="is_free_product" id="checkbox_free_product" <?php echo ($product->is_free_product == 1) ? 'checked' : ''; ?>>
                            <label for="checkbox_free_product" class="custom-control-label text-danger"><?php echo trans("free_product"); ?></label>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php elseif ($product->listing_type == 'ordinary_listing') :
    if ($this->form_settings->price == 1) : ?>
        <div class="form-box">
            <div class="form-box-head">
                <h4 class="title"><?php echo trans('price'); ?></h4>
            </div>
            <div class="form-box-body">
                <div class="form-group">
                    <div class="row">
                        <?php if ($this->payment_settings->allow_all_currencies_for_classied == 1) : ?>
                            <div class="col-xs-12 col-sm-4 m-b-sm-15">
                                <select name="currency" class="form-control custom-select" required>
                                    <?php if (!empty($this->currencies)) :
                                        foreach ($this->currencies as $key => $value) :
                                            if ($key == $product->currency) : ?>
                                                <option value="<?php echo $key; ?>" selected><?php echo $value["name"] . " (" . $value["hex"] . ")"; ?></option>
                                            <?php else : ?>
                                                <option value="<?php echo $key; ?>"><?php echo $value["name"] . " (" . $value["hex"] . ")"; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-xs-12 col-sm-4 m-b-sm-15">
                                <input type="text" name="price" class="form-control form-input price-input validate-price-input" value="<?php echo ($product->price != 0) ? get_price($product->price, 'input') : ''; ?>" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" <?php echo ($this->form_settings->price_required == 1) ? 'required' : ''; ?>>
                            </div>
                        <?php else : ?>
                            <div class="col-xs-12 col-sm-6 m-b-sm-15">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-group-text-currency" id="basic-addon2"><?php echo get_currency($this->payment_settings->default_currency); ?></span>
                                        <input type="hidden" name="currency" value="<?php echo $this->payment_settings->default_currency; ?>">
                                    </div>
                                    <input type="text" name="price" id="product_price_input" aria-describedby="basic-addon2" class="form-control form-input price-input validate-price-input" value="<?php echo ($product->price != 0) ? get_price($product->price, 'input') : ''; ?>" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" <?php echo ($this->form_settings->price_required == 1) ? 'required' : ''; ?>>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php elseif ($product->listing_type == 'bidding') : ?>
    <input type="hidden" name="currency" value="<?php echo $this->payment_settings->default_currency; ?>">
<?php endif; ?>

<script>
    $(document).on('click', '#checkbox_free_product', function() {
        if ($(this).is(':checked')) {
            $('#price_input_container').hide();
            $(".price-input").prop('required', false);
        } else {
            $('#price_input_container').show();
            $(".price-input").prop('required', true);
        }
    });
</script>
<?php if ($product->is_free_product == 1) : ?>
    <style>
        #price_input_container {
            display: none;
            ;
        }
    </style>
<?php endif; ?>

<?php if ($product->listing_type == 'sell_on_site') : ?>
    <script>
        //calculate product earned value
        var thousands_separator = '<?php echo $this->thousands_separator; ?>';
        var commission_rate = '<?php echo calculate_commission_rate_seller($user->id); ?>';
        $(document).on("input keyup paste change", "#product_price_input", function() {
            calculate_earn_amount();
        });
        $(document).on("input keyup paste change", "#input_discount_rate", function() {
            var val = parseInt($(this).val());
            if (val == "" || val == null || isNaN(val)) {
                val = 0;
            }
            if (val > 99) {
                val = 99;
            }
            if ($(this).val() < 0) {
                val = 0;
            }
            $(this).val(val);
            calculate_earn_amount();
        });
        $(document).on("input keyup paste change", "#input_gst_rate", function() {
            var val = parseInt($(this).val());
            if (val == "" || val == null || isNaN(val)) {
                val = 0;
            }
            if (val > 100) {
                val = 100;
            }
            if ($(this).val() < 0) {
                val = 0;
            }
            $(this).val(val);
            calculate_earn_amount();
        });

        function calculate_earn_amount() {
            var input_price = $("#product_price_input").val();
            var discount = 0;
            var vat = 0;
            if ($('#input_discount_rate').val() != "" && $('#input_discount_rate').val() != null) {
                discount = $("#input_discount_rate").val();
            }
            if ($('#input_gst_rate').val() != "" && $('#input_gst_rate').val() != null) {
                vat = $("#input_gst_rate").val();
            }
            input_price = input_price.replace(',', '.');
            var price = parseFloat(input_price);
            commission_rate = parseInt(commission_rate);

            //calculate
            var calculated_amount = 0;
            var gst_amount = 0;
            var earned_amount = 0;
            if (!Number.isNaN(price)) {
                calculated_amount = price - ((price * discount) / 100);
                gst_amount = (calculated_amount * vat) / 100;
                earned_amount = calculated_amount + gst_amount;
                earned_amount = earned_amount - ((earned_amount * commission_rate) / 100);
                earned_amount = earned_amount.toFixed(2);
                calculated_amount = calculated_amount.toFixed(2);
                gst_amount = gst_amount.toFixed(2);
                if (thousands_separator == ',') {
                    calculated_amount = calculated_amount.replace('.', ',');
                    gst_amount = gst_amount.replace('.', ',');
                    earned_amount = earned_amount.replace('.', ',');
                }
            } else {
                calculated_amount = '0' + thousands_separator + '00';
                gst_amount = '0' + thousands_separator + '00';
                earned_amount = '0' + thousands_separator + '00';
            }
            $("#calculated_amount").html(calculated_amount);
            $("#gst_amount").html(gst_amount);
            $("#earned_amount").html(earned_amount);
        }
    </script>
<?php endif; ?>


<script>
    $('#checkbox_discount_rate').change(function() {
        if (!this.checked) {
            $("#discount_input_container").show();
        } else {
            $('#input_discount_rate').val("0");
            $('#input_discount_rate').change();
            $("#discount_input_container").hide();
        }
    });
    $('#checkbox_gst_included').change(function() {
        if (!this.checked) {
            $("#vat_input_container").show();
            $(".calculated_gst_container").show();
        } else {
            $('#input_gst_rate').val("0");
            $('#input_gst_rate').change();
            $("#vat_input_container").hide();
            $(".calculated_gst_container").hide();
        }
    });
</script>