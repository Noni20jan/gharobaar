<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if ($product->listing_type == 'sell_on_site') : ?>
    <div class="form-box form-box-price">
        <div class="form-box-head">
            <h4 class="title">Default <?php echo trans("product_price"); ?><span class="Validation_error"> *</span></h4>
        </div>
        <div class="form-box-body">
            <div id="price_input_container" class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-sm-3 m-b-15">
                        <label class="font-600"><?php echo trans("base_price_gst"); ?></label>
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo get_currency($this->payment_settings->default_currency); ?></span>
                            <input type="hidden" name="currency" value="<?php echo $this->payment_settings->default_currency; ?>">
                            <input type="text" name="price" id="product_price_input" aria-describedby="basic-addon1" class="form-control form-input price-input validate-price-input" value="<?php echo ($product->price != 0) ? get_price($product->price, 'input') : ''; ?>" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" <?= $product->is_free_product != 1 ? 'required' : ''; ?>>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 m-b-15">
                        <label class="font-600"><?php echo trans("listing_price"); ?></label>
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo get_currency($this->payment_settings->default_currency); ?></span>
                            <input type="text" name="listing_price" id="product_listing_price_input" aria-describedby="basic-addon1" class="form-control form-input price-input validate-price-input" value="<?php echo ($product->listing_price != 0) ? get_price($product->listing_price, 'input') : ''; ?>" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" <?= $product->is_free_product != 1 ? 'required' : ''; ?>>
                        </div>
                    </div>
                    <input type="hidden" name="price_exclude_gst" id="price_exclude_gst" aria-describedby="basic-addon1" class="form-control form-input price-input validate-price-input" value="<?php echo ($product->price_exclude_gst != 0) ? get_price($product->price_exclude_gst, 'input') : ''; ?>" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" <?= $product->is_free_product != 1 ? 'required' : ''; ?>>
                    <input type="hidden" name="net_seller_payable" id="net_seller_payable" aria-describedby="basic-addon1" class="form-control form-input price-input validate-price-input" value="<?php echo ($product->net_seller_payable != 0) ? get_price($product->net_seller_payable, 'input') : ''; ?>" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" <?= $product->is_free_product != 1 ? 'required' : ''; ?>>
                    <input type="hidden" name="gst_amount_input" id="gst_amount_input" aria-describedby="basic-addon1" class="form-control form-input price-input validate-price-input" value="<?php echo ($product->gst_amount != 0) ? get_price($product->gst_amount, 'input') : ''; ?>" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" <?= $product->is_free_product != 1 ? 'required' : ''; ?>>
                    <input type="hidden" name="commission_amount_input" id="commission_amount_input" aria-describedby="basic-addon1" class="form-control form-input price-input validate-price-input" value="<?php echo ($product->commission_amount != 0) ? get_price($product->commission_amount, 'input') : ''; ?>" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" <?= $product->is_free_product != 1 ? 'required' : ''; ?>>
                    <input type="hidden" name="gst_on_commission_amount_input" id="gst_on_commission_amount_input" aria-describedby="basic-addon1" class="form-control form-input price-input validate-price-input" value="<?php echo ($product->gst_on_commission_amount != 0) ? get_price($product->gst_on_commission_amount, 'input') : ''; ?>" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" <?= $product->is_free_product != 1 ? 'required' : ''; ?>>
                    <input type="hidden" name="gharobaar_commission_amount_input" id="gharobaar_commission_amount_input" aria-describedby="basic-addon1" class="form-control form-input price-input validate-price-input" value="<?php echo ($product->gharobaar_commission_amount != 0) ? get_price($product->gharobaar_commission_amount, 'input') : ''; ?>" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" <?= $product->is_free_product != 1 ? 'required' : ''; ?>>
                    <div class="col-xs-12 col-sm-3 m-b-15">
                        <div class="row align-items-center">
                            <div class="col-sm-12">
                                <label class="font-600"><?php echo trans("discount_rate"); ?></label>
                                <div id="discount_input_container" class="<?php echo ($product->discount_rate == 0) ? 'display-none' : ''; ?>">
                                    <div class="input-group">
                                        <span class="input-group-addon">%</span>
                                        <input type="hidden" name="currency" value="<?php echo $this->payment_settings->default_currency; ?>">
                                        <input type="text" name="discount_rate" id="input_discount_rate" aria-describedby="basic-addon-discount" class="form-control form-input" value="<?php echo $product->discount_rate; ?>" min="0" max="99">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 m-t-10">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="checkbox_discount_rate" id="checkbox_discount_rate" <?php echo ($product->discount_rate == 0) ? 'checked' : ''; ?>>
                                    <label for="checkbox_discount_rate" class="custom-control-label"><?php echo trans("no_discount"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php if (!empty($user->gst_number)) : ?>
                        <div class="col-xs-12 col-sm-3 m-b-sm-15">
                            <label class="font-600">HSN Code<span class="Validation_error"> *</span></label>
                            <input type="text" name="hsn_code" id="hsn_code" class="form-control auth-form-input" placeholder="Product HSN Code" value="<?php echo $product->hsn_code; ?>" onkeyup="hsn_valid();">
                            <p id="demo"></p>

                        </div>
                    <?php endif; ?>

                    <?php if ($this->general_settings->gst_status == 1) : ?>
                        <div class="col-xs-12 col-sm-3">
                            <div class="row align-items-center">
                                <div class="col-sm-12">
                                    <label class="font-600"><?php echo trans("gst"); ?><small>&nbsp;(<?php echo trans("gst_exp"); ?>)</small></label>
                                    <div id="vat_input_container">
                                        <div class="input-group">
                                            <span class="input-group-addon">%</span>
                                            <input type="hidden" name="currency" value="<?php echo $this->payment_settings->default_currency; ?>">
                                            <input type="number" id="input_gst_rate" class="form-control" name="gst_rate" value="<?php echo ($product->gst_rate != null && !empty($product->gst_rate)) ? $product->gst_rate : 0; ?>">
                                            <!-- <select name="gst_rate" id="input_gst_rate" class="form-control" required>
                                                <option value="" disabled selected>Select GST Rate</option>
                                                <option value="0" <?php echo ($product->gst_rate == "0") ? 'selected' : ''; ?>>0</option>
                                                <option value="3" <?php echo ($product->gst_rate == "3") ? 'selected' : ''; ?>>3</option>
                                                <option value="5" <?php echo ($product->gst_rate == "5") ? 'selected' : ''; ?>>5</option>
                                                <option value="12" <?php echo ($product->gst_rate == "12") ? 'selected' : ''; ?>>12</option>
                                                <option value="18" <?php echo ($product->gst_rate == "18") ? 'selected' : ''; ?>>18</option>
                                                <option value="28" <?php echo ($product->gst_rate == "28") ? 'selected' : ''; ?>>28</option>
                                            </select> -->

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 m-t-10 display-none">
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
                            <strong><?php echo trans("calculated_price_exclude_gst"); ?> (<?php echo get_currency($this->payment_settings->default_currency); ?>):&nbsp;&nbsp;</strong>
                            <b id="calculated_amount" class="earned-price">
                                <?php $earned_amount = $product->price_exclude_gst;
                                $earned_amount = number_format($earned_amount, 2, '.', '');
                                echo get_price($earned_amount, 'input'); ?>
                            </b>
                        </p>
                        <p class="calculated-price calculated_gst_container">
                            <strong><?php echo trans("gst"); ?> (<?php echo get_currency($this->payment_settings->default_currency); ?>):&nbsp;&nbsp;</strong>
                            <b id="gst_amount" class="earned-price">
                                <?php $earned_amount = $product->gst_amount;
                                $earned_amount = number_format($earned_amount, 2, '.', '');
                                echo get_price($earned_amount, 'input'); ?>
                            </b>
                        </p>

                        <p class="calculated-price">
                            <strong><?php echo trans("commission_rate"); ?>:&nbsp;&nbsp;</strong>
                            <b id="commission_rate" class="earned-price">
                                <?php echo calculate_commission_rate_seller($user->id); ?>%
                            </b>
                        </p>
                        <p class="calculated-price">
                            <strong><?php echo trans("commission_amount"); ?> (<?php echo get_currency($this->payment_settings->default_currency); ?>):&nbsp;&nbsp;</strong>
                            <b id="commission_amount" class="earned-price">
                                <?php $earned_amount = $product->commission_amount;
                                $earned_amount = number_format($earned_amount, 2, '.', '');
                                echo get_price($earned_amount, 'input'); ?>
                            </b>
                        </p>
                        <p class="calculated-price">
                            <strong><?php echo trans("gst_on_commission_amount"); ?> (<?php echo get_currency($this->payment_settings->default_currency); ?>):&nbsp;&nbsp;</strong>
                            <b id="gst_on_commission_amount" class="earned-price">
                                <?php $earned_amount = $product->gst_on_commission_amount;
                                $earned_amount = number_format($earned_amount, 2, '.', '');
                                echo get_price($earned_amount, 'input'); ?>
                            </b>
                        </p>
                        <p class="calculated-price">
                            <strong><?php echo trans("gharobaar_commission_amount"); ?> (<?php echo get_currency($this->payment_settings->default_currency); ?>):&nbsp;&nbsp;</strong>
                            <b id="gharobaar_commission_amount" class="earned-price">
                                <?php $earned_amount = $product->gharobaar_commission_amount;
                                $earned_amount = number_format($earned_amount, 2, '.', '');
                                echo get_price($earned_amount, 'input'); ?>
                            </b>
                        </p>
                        <p class="calculated-price">
                            <strong><?php echo trans("you_will_earn"); ?> (<?php echo get_currency($this->payment_settings->default_currency); ?>):&nbsp;&nbsp;</strong>
                            <b id="earned_amount" class="earned-price">
                                <?php $earned_amount = $product->net_seller_payable;
                                $earned_amount = number_format($earned_amount, 2, '.', '');
                                echo get_price($earned_amount, 'input'); ?>
                            </b>

                            &nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?php echo trans("payment_getway_charges"); ?>&nbsp;&nbsp;

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
        var commission_gst_rate = '<?php echo $this->general_settings->commission_gst_rate; ?>';
        $(document).on("input keyup paste change", "#product_price_input", function() {
            calculate_earn_amount();
        });
        $(document).on("input keyup paste change", "#input_discount_rate", function() {
            var base_price = parseInt($('#product_price_input').val());
            var val = parseFloat($(this).val());
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

            $('#product_listing_price_input').val(Math.round(base_price - (Math.round((base_price * val) / 100))));

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

        $(document).on("input keyup paste change", "#product_listing_price_input", function() {
            var base_price = parseInt($('#product_price_input').val());
            var val = parseInt($(this).val());
            if (val == "" || val == null || isNaN(val)) {
                val = 0;
            }
            if (base_price == "" || base_price == null || isNaN(base_price)) {
                val = 0;
            }
            if (val > base_price) {
                val = base_price;
            }
            if ($(this).val() < 0) {
                val = 0;
            }
            $(this).val(val);
            $('#input_discount_rate').val(parseFloat(((base_price - val) / base_price) * 100).toFixed(2));
            if (Math.round(((base_price - val) / base_price) * 100) > 0) {
                $("#checkbox_discount_rate")[0].checked = false;
                $("#checkbox_discount_rate").trigger("change");
            } else {
                $("#checkbox_discount_rate")[0].checked = true;
                $("#checkbox_discount_rate").trigger("change");
            }
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
            var listing_price = 0;
            var calculated_amount = 0;
            var gst_amount = 0;
            var earned_amount = 0;
            var commission_amount = 0;
            var gst_on_commission_amount = 0;
            var gharobaar_commission_amount = 0;
            if (!Number.isNaN(price)) {
                listing_price = parseInt($("#product_listing_price_input").val());
                // listing_price = Math.round(price - ((price * discount) / 100));
                calculated_amount = (listing_price) / (1 + (vat / 100));
                // gst_amount = (calculated_amount * vat) / 100;
                gst_amount = listing_price - (listing_price / (1 + (vat / 100)));
                earned_amount = calculated_amount;
                commission_amount = (earned_amount * commission_rate) / 100;
                earned_amount = earned_amount - ((earned_amount * commission_rate) / 100);
                gst_on_commission_amount = (commission_amount * commission_gst_rate) / 100;
                gharobaar_commission_amount = commission_amount + gst_on_commission_amount;
                earned_amount = earned_amount - ((commission_amount * commission_gst_rate) / 100);
                earned_amount = earned_amount + gst_amount;
                earned_amount = earned_amount.toFixed(2);
                calculated_amount = calculated_amount.toFixed(2);
                commission_amount = commission_amount.toFixed(2);
                gst_on_commission_amount = gst_on_commission_amount.toFixed(2);
                gharobaar_commission_amount = gharobaar_commission_amount.toFixed(2);
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
            $("#price_exclude_gst").val(calculated_amount);
            $("#net_seller_payable").val(earned_amount);
            $("#gst_amount_input").val(gst_amount);

            $("#commission_amount").html(commission_amount);
            $('#gst_on_commission_amount').html(gst_on_commission_amount);
            $('#gharobaar_commission_amount').html(gharobaar_commission_amount);

            $("#commission_amount_input").val(commission_amount);
            $('#gst_on_commission_amount_input').val(gst_on_commission_amount);
            $('#gharobaar_commission_amount_input').val(gharobaar_commission_amount);
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
    // $('#product_listing_price_input').change(function() {
    //     console.log($('#product_price_input').val());
    // });
</script>
<script>
    function updateTextField() {
        var select = document.getElementById('input_gst_rate_dropdown');
        var input = document.getElementById('input_gst_rate');
        select.onchange = function() {
            input.value = select.value;
            console.log(input.value);
        }
    }
</script>
<script>
    function hsn_valid() {
        var hsn_code = ($('#hsn_code').val());
        var hsn_len = hsn_code.length;
        var data = {
            'hsn_code': hsn_code,
            'hsn_len': hsn_len,
        }
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        if (hsn_len >= 4) {
            $.ajax({
                type: "POST",
                url: base_url + "check-hsn-validity",
                data: data,
                success: function(data) {
                    var res = JSON.parse(data);
                    console.log(res);
                    var z = res["rse"];
                    var hsn_length = ($('#hsn_code').val()).length;
                    if (hsn_length >= 4 && z > 0) {
                        document.getElementById("demo").innerHTML = "";
                        document.getElementById("button_to_submit").disabled = false;
                        document.getElementById("button_with_submit").disabled = false;

                    } else {
                        document.getElementById("demo").style.color = "red";
                        document.getElementById("demo").innerHTML = "Please enter valid hsn code";
                        document.getElementById("button_to_submit").disabled = true;
                        document.getElementById("button_with_submit").disabled = true;

                    }
                },
                error: function() {
                    document.getElementById("demo").style.color = "red";
                    document.getElementById("demo").innerHTML = "Please enter valid hsn code";
                    document.getElementById("button_to_submit").disabled = true;
                    document.getElementById("button_with_submit").disabled = true;

                }
            });
        } else {
            document.getElementById("demo").style.color = "red";

            document.getElementById("demo").innerHTML = "Please enter atleast 4 characters";
            document.getElementById("demo").style.fontSize = "12px";
            document.getElementById("button_to_submit").disabled = true;
            document.getElementById("button_with_submit").disabled = true;

        }
    };
</script>