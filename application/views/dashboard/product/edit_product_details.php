<?php defined('BASEPATH') or exit('No direct script access allowed');
// var_dump($parent_categories_array[0]->id);
?>
<!-- Datepicker -->
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
<!-- <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script> -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/plyr/plyr.css">
<script src="<?php echo base_url(); ?>assets/vendor/plyr/plyr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/plyr/plyr.polyfilled.min.js"></script>

<?php $back_url = generate_dash_url("edit_product") . "/" . $product->id; ?>
<script type="text/javascript">
    history.pushState(null, null, '<?php echo $_SERVER["REQUEST_URI"]; ?>');
    window.addEventListener('popstate', function(event) {
        window.location.assign('<?php echo $back_url; ?>');
    });
</script>
<style>
    #know_more_box {
        height: 650px;
        overflow-y: scroll;
        overflow-x: hidden;
        border-radius: 20px;
        margin: auto;
        /* background-image: url(assets/img/background3.png); */
        background-color: #f8f9fad6;
        backdrop-filter: blur(3px);
    }

    #barting {
        text-align: center;
        margin-top: 4%;
        margin-bottom: 4%;
        font-weight: bold;
    }

    #ABOUT_LOGO {
        width: 40%;
        margin: auto auto;
        text-align: center;
        margin-top: 8%;
    }

    #logax {
        width: 74%;
    }

    @media (max-width: 500px) {
        #logax {
            width: 99%;
            margin-left: 0;
        }

        #ABOUT_LOGO {
            width: 100%;
            margin: auto auto;
            text-align: center;
            margin-top: 15%;
        }

    }


    #tix {
        margin-left: 1%;
    }

    .cont p {
        padding: 0 20px;
        font-size: 18px;
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 15px;
        right: 15px;
        color: #020202;
        font-size: 30px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<?php if ($product->is_draft == 1) : ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="wizard-product">
                <h1 class="product-form-title"><?= trans("add_product"); ?></h1>
                <div class="row">
                    <div class="col-md-12 wizard-add-product">
                        <ul class="wizard-progress">
                            <li class="active" id="step_general"><strong><?= trans("general_information"); ?></strong></li>
                            <li class="active" id="step_dedails"><strong><?= trans("details"); ?></strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-add-product">
            <div class="box-body">
                <?php if ($product->is_draft != 1) : ?>
                    <h1 class="product-form-title"><?= trans("edit_product"); ?></h1>
                <?php endif; ?>
                <div class="alert-message-lg aler-product-form">
                    <?php $this->load->view('dashboard/includes/_messages'); ?>
                </div>
                <?php if ($product->product_type == 'digital') : ?>
                    <div class="row-custom">
                        <?php $this->load->view("dashboard/product/_digital_files_upload_box"); ?>
                    </div>
                <?php endif; ?>

                <?php echo form_open('edit-product-details-post', ['id' => 'form_product_details', 'class' => 'validate_price', 'class' => 'validate_terms', 'onkeypress' => "return event.keyCode != 13;"]); ?>
                <input type="hidden" name="id" value="<?php echo $product->id; ?>">

                <?php if ($product->product_type == 'digital') : ?>
                    <?php $this->load->view("dashboard/product/license/_license_keys", ['product' => $product, 'license_keys' => $license_keys]); ?>

                    <div class="form-box">
                        <div class="form-box-head">
                            <h4 class="title">
                                <?php echo trans('files_included'); ?><br>
                                <small><?php echo trans("files_included_ext"); ?></small>
                            </h4>
                        </div>
                        <div class="form-box-body">
                            <input type="text" name="files_included" class="form-control form-input" value="<?php echo html_escape($product->files_included); ?>" placeholder="<?php echo trans("files_included"); ?>" required>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($custom_fields)) : ?>
                    <div class="form-box">
                        <div class="form-box-head">
                            <h4 class="title"><?php echo trans('details'); ?></h4>
                        </div>
                        <div class="form-box-body">
                            <div class="form-group">
                                <div class="row" id="custom_fields_container">
                                    <?php $this->load->view("dashboard/product/_custom_fields", ["custom_fields" => $custom_fields, "product" => $product]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="form-box">
                    <div class="form-box-head">
                        <h4 class="title">Type Of Inventory<span class="Validation_error"> *</span></h4>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-custom-field">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="add_meet" value="Made to order" id="add_meet_order" class="custom-control-input" onclick="ShowHideDiv()" <?php echo ($product->add_meet == "Made to order") ? 'checked' : ''; ?> required>
                                <label for="add_meet_order" class="custom-control-label ">
                                    <p class="tooltip-product">Made to order &nbsp;<i class="fa fa-info-circle"></i><span class="tooltiptext">Made by the supplier only after receipt of a confirmed order by the buyer.</span></p>
                                </label>

                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-custom-field">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="add_meet" value="Made to stock" id="add_meet_stock" class="custom-control-input" onclick="ShowHideDiv()" <?php echo ($product->add_meet == "Made to stock") ? 'checked' : ''; ?> required>
                                <label for="add_meet_stock" class="custom-control-label">
                                    <p class="tooltip-product">Ready Stock / Inventory &nbsp;<i class="fa fa-info-circle"></i><span class="tooltiptext">Regular selling item for which inventory is maintained by the supplier in the normal course of business.</span></p>
                                </label>
                            </div>
                        </div>
                    </div>

                    <?php if ($product->product_type != 'digital' && $product->listing_type != 'ordinary_listing') : ?>

                        <div id="stocks" style="display: none">
                            <h4 class="title"><?php echo trans('stock'); ?></h4>
                            <!-- <div class="form-box"> -->
                            <!-- <div class="form-box-head">
                            </div> -->
                            <!-- <div class="form-box-body"> -->
                            <div class="form-group">
                                <input type="number" name="stock" id="stock_main" class="form-control form-input max-perc-50" min="0" max="999999999" value="<?php echo ($product->stock != null) ? $product->stock : 0; ?>" placeholder="<?php echo trans("stock"); ?>" required>
                            </div>
                            <!-- </div> -->
                            <!-- </div> -->
                        </div>
                        <div id="leads" style="display:<?php echo ($product->lead_days != null) ? 'block' : 'none'; ?>;">
                            <h4 class="title">Lead Time / Notice Period (time required to create and dispatch the product)</h4>
                            <div class="input-group">
                                <span class="input-group-addon">Days</span>
                                <input type="text" name="lead_days" autocomplete="off" class="form-control form-input max-perc-50" value="<?php echo ($product->lead_days != null) ? $product->lead_days : "0"; ?>" required>
                                <span class="input-group-addon">Hours</span><input type="text" autocomplete="off" name="lead_time" class="form-control form-input max-perc-50" value="<?php echo ($product->lead_time != null) ? $product->lead_time : "0"; ?>" required>
                            </div>
                        <?php else : ?>
                            <input type="hidden" name="stock" value="<?= $product->stock; ?>">
                        <?php endif; ?>
                        </div>
                        <br>
                        <?php $this->load->view("dashboard/product/_edit_price", ['user' => $user]); ?>

                        <?php
                            $categories = get_parent_categories_tree($product->category_id, false);
                            if ($categories[1]->id == 38 && $categories[1]->slug == 'apparel') :
                            ?>
                                <div class="form-box">
                                    <div class="row ">
                                        <div class="col-sm-12 col-md-6 m-b-sm-15">
                                            <label><?php echo ('Product Suitable For'); ?></label><span class="Validation_error"> *</span>
                                            
                                                <select name="suitable_for_kids" id="suitable_for" class="form-control custom-select m-0" required>
                                                    <option disabled selected value> -- Select an option -- </option>
                                                    <option value="male" <?php echo ($product->suitable_for == "male") ? 'selected' : ''; ?>>Male</option>
                                                    <option value="female" <?php echo ($product->suitable_for == "female") ? 'selected' : ''; ?>>Female</option>
                                                    <option value="unisex" <?php echo ($product->suitable_for == "unisex") ? 'selected' : ''; ?>>Unisex</option>
                                                </select>
                                            </div>
                                        
                                    </div>
                                </div>
                            <?php endif;
                            ?>

                        <?php if ($this->form_settings->shipping == 1 && $product->product_type == 'physical') : ?>
                            <div class="form-box">
                                <div class="form-box-head">
                                    <h4 class="title"><?php echo trans('shipping'); ?><span class="Validation_error"> *</span></h4>
                                </div>
                                <div class="form-box-body">

                                    <div class="row">
                                        <?php
                                        $show_shipping_cost_input = $this->settings_model->is_shipping_option_require_cost($product->shipping_cost_type);
                                        $shipping_options = get_grouped_shipping_options();
                                        if (!empty($shipping_options)) : ?>
                                            <div class="col-sm-12 col-md-6 m-b-sm-15">
                                                <label><?php echo trans('shipping_cost'); ?></label>
                                                <select id="select_shipping_cost" name="shipping_cost_type" class="form-control custom-select" required>
                                                    <option value="" disabled><?php echo trans("select_option"); ?></option>
                                                    <?php foreach ($shipping_options as $option) :
                                                        $shipping_option = get_shipping_option_by_lang($option->common_id, $this->selected_lang->id);
                                                        if ($shipping_option->is_visible == 1) : ?>
                                                            <option value="<?php echo $shipping_option->option_key; ?>" data-shipping-cost="<?php echo $shipping_option->shipping_cost; ?>" <?php echo ($product->shipping_cost_type == $shipping_option->option_key) ? 'selected' : ''; ?>><?php echo $shipping_option->option_label; ?></option>
                                                    <?php endif;
                                                        if ($product->shipping_cost_type == $shipping_option->option_key) {
                                                            $show_shipping_cost_input = $shipping_option->shipping_cost;
                                                        }
                                                    endforeach; ?>
                                                </select>
                                            </div>
                                        <?php endif; ?>
                                        <div id="dispatch" style="display: <?php echo ($product->shipping_time != "") ? 'block' : 'none'; ?>;">
                                            <div class="col-sm-12 col-md-6">
                                                <label>Dispatch Time</label>
                                                <select id="shipping_time" name="shipping_time" class="form-control custom-select" <?php echo ($this->form_settings->shipping_required == 1) ? 'required' : ''; ?>>
                                                    <option value="" disabled><?php echo trans("select_option"); ?></option>
                                                    <option value="1_business_day" <?php echo ($product->shipping_time == "1_business_day") ? 'selected' : ''; ?>><?php echo trans("1_business_day"); ?></option>
                                                    <option value="2_3_business_days" <?php echo ($product->shipping_time == "2_3_business_days") ? 'selected' : ''; ?>><?php echo trans("2_3_business_days"); ?></option>
                                                    <option value="4_7_business_days" <?php echo ($product->shipping_time == "4_7_business_days") ? 'selected' : ''; ?>><?php echo trans("4_7_business_days"); ?></option>
                                                    <option value="8_15_business_days" <?php echo ($product->shipping_time == "8_15_business_days") ? 'selected' : ''; ?>><?php echo trans("8_15_business_days"); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-sm-12 col-md-6 m-t-15 shipping-cost-container" style="<?= $show_shipping_cost_input == 1 ? 'display:block;' : 'display:none;'; ?>">
                                    <label><?php echo trans('shipping_cost'); ?></label>
                                    <div class="input-group">
                                        <?php if ($this->payment_settings->default_currency != "all") : ?>
                                            <span class="input-group-addon"><?php echo get_currency($this->payment_settings->default_currency); ?></span>
                                        <?php endif; ?>
                                        <input type="text" name="shipping_cost" aria-describedby="basic-addon3" class="form-control form-input price-input" value="<?php echo $product->shipping_cost != 0 ? get_price($product->shipping_cost, 'input') : ''; ?>" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" <?= $show_shipping_cost_input == 1 ? 'required' : ''; ?>>
                                    </div>
                                </div> -->

                                        <!-- <div class="col-sm-12 col-md-6 m-t-15 shipping-cost-container" style="<?= $show_shipping_cost_input == 1 ? 'display:block;' : 'display:none;'; ?>">
                                    <label><?php echo trans('shipping_cost_per_additional_product'); ?></label>
                                    <div class="input-group">
                                        <?php if ($this->payment_settings->default_currency != "all") : ?>
                                            <span class="input-group-addon"><?php echo get_currency($this->payment_settings->default_currency); ?></span>
                                        <?php endif; ?>
                                        <input type="text" name="shipping_cost_additional" aria-describedby="basic-addon3" class="form-control form-input price-input" value="<?php echo get_price($product->shipping_cost_additional, 'input'); ?>" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" <?= $show_shipping_cost_input == 1 ? 'required' : ''; ?>>
                                    </div>
                                    <small><?php echo trans("shipping_cost_per_additional_product_exp"); ?></small>
                                </div> -->


                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="form-box">
                            <div class="row">
                                <div class="col-12 col-sm-4 col-custom-field">
                                    <label class="control-label">Product Weight(in grams)<span class="Validation_error"> *</span></label>
                                    <input type="number" autocomplete="off" name="product_weight" class="form-control auth-form-input" placeholder="Enter actual product weight" required value="<?php echo (!empty($product->product_weight)) ? $product->product_weight : ''; ?>" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null">
                                </div>
                            </div>
                            <div class="form-box-head">
                                <h4 class="title">
                                    Default Product dimensions and weight details(after product has been packed for final delivery)<span class="Validation_error"> *</span><br>
                                </h4>
                            </div>
                            <div class="form-box-body">

                                <div class="row">
                                    <div class="col-12 col-sm-3">
                                        <label class="barting tooltip-product-other-info tooltip-product">Package Weight(in grams) <span class="Validation_error"> *</span> &nbsp;<i class="fa fa-info-circle"></i><span class="tooltiptext">Please enter the packaged weight of your product after it has been packed completely for shipping. The delivery charges for the customer would be calculated basis this weight</span></label>
                                        <input type="number" name="weight" id="weight_main" class="form-control auth-form-input" placeholder="Enter Product Weight After Packaging" value="<?php echo $product->weight; ?>" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" required>
                                        <!-- <div class="pull-right btn-select-dropdown" style="padding-right: 5px;margin-top: -36px;">

                                            <select name="weight_units" class="custom-select" required>
                                                <option value="Kgs" <?php echo ($product->weight_units == "Kgs") ? 'selected' : ''; ?>>Kgs</option>
                                                <option value="Grams" <?php echo ($product->weight_units == "Grams") ? 'selected' : ''; ?>>Grams</option>
                                                <option value="Pounds" <?php echo ($product->weight_units == "Pounds") ? 'selected' : ''; ?>>Pounds</option>
                                                <option value="Lbs" <?php echo ($product->weight_units == "Lbs") ? 'selected' : ''; ?>>Lbs</option>
                                                <option value="Litres" <?php echo ($product->weight_units == "Litres") ? 'selected' : ''; ?>>Litres</option>
                                                <option value="millilitres" <?php echo ($product->weight_units == "millilitres") ? 'selected' : ''; ?>>millilitres</option>
                                            </select>
                                        </div> -->
                                    </div>
                                    <div class="col-12 col-sm-3 m-b-15">
                                        <label class="control-label">Length (in cm)<span class="Validation_error"> *</span></label>
                                        <input type="number" name="product_length" id="length_main" class="form-control auth-form-input" placeholder="Length (in cm)" value="<?php echo html_escape($product->packed_product_length); ?>" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" required>
                                    </div>
                                    <div class="col-12 col-sm-3 m-b-15">
                                        <label class="control-label">Width (in cm)<span class="Validation_error"> *</span></label>
                                        <input type="number" name="product_width" id="width_main" class="form-control auth-form-input" placeholder="Width (in cm)" value="<?php echo html_escape($product->packed_product_width); ?>" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" required>
                                    </div>
                                    <div class="col-12 col-sm-3 m-b-15">
                                        <label class="control-label">Height (in cm)<span class="Validation_error"> *</span></label>
                                        <input type="number" name="product_height" id="height_main" class="form-control auth-form-input" placeholder="Height (in cm)" value="<?php echo html_escape($product->packed_product_height); ?>" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" required>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (($product->product_type == 'physical' && $this->form_settings->physical_demo_url == 1) || ($product->product_type == 'digital' && $this->form_settings->digital_demo_url == 1)) : ?>
                            <div class="form-box">
                                <div class="form-box-head">
                                    <h4 class="title">
                                        Product Info<span class="Validation_error"> *</span><br>
                                    </h4>
                                </div>
                                <div class="form-box-body">
                                    <label class="myradio"><?php echo trans("return_exchange_label"); ?>: <a href="#" style="text-decoration:underline;color:blue;" data-toggle="modal" data-target="#view_policy">(View Returns & Refund Policy)</a>&nbsp;</label>
                                    <div class="row">
                                        <div class="col-12 col-sm-3 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="return_or_exchange" value="return" id="return" class="custom-control-input" <?php echo ($product->available_for_return_or_exchange == "return") ? 'checked' : ''; ?> required>
                                                <label for="return" class="custom-control-label">Returnable</label>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-3 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="return_or_exchange" value="exchange" id="exchange" class="custom-control-input" <?php echo ($product->available_for_return_or_exchange == "exchange") ? 'checked' : ''; ?> required>
                                                <label for="exchange" class="custom-control-label">Exchangeable</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-3 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="return_or_exchange" value="both" id="both" class="custom-control-input" <?php echo ($product->available_for_return_or_exchange == "both") ? 'checked' : ''; ?> required>
                                                <label for="both" class="custom-control-label">Both</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-3 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="return_or_exchange" value="none" id="none" class="custom-control-input" <?php echo ($product->available_for_return_or_exchange == "none") ? 'checked' : ''; ?> required>
                                                <label for="none" class="custom-control-label">None</label>
                                            </div>
                                        </div>

                                    </div>
                                    <label class="barting">Product Open to Barter <a href="#" style="text-decoration:underline;color:blue;" data-toggle="modal" data-target="#knowmore">(Know More)</a>&nbsp;</label>
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="product_barter" value="Y" id="id_bartery" class="custom-control-input" <?php if (html_escape($product->available_for_barter) == "Y") {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?> required>
                                                <label for="id_bartery" class="custom-control-label">Yes</label>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="product_barter" value="N" id="id_bartern" class="custom-control-input" <?php if (html_escape($product->available_for_barter) == "N") {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?> required>
                                                <label for="id_bartern" class="custom-control-label">No</label>
                                            </div>
                                        </div>

                                    </div>
                                    <label class="barting"> <?php echo trans('cod_accepted') ?> </label>
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="cod_accepted" value="Y" id="cod_yes" class="custom-control-input" <?php if (html_escape($product->cod_accepted) == "Y") {
                                                                                                                                                echo "checked";
                                                                                                                                            } ?> required>
                                                <label for="cod_yes" class="custom-control-label">Yes</label>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="cod_accepted" value="N" id="cod_no" class="custom-control-input" <?php if (html_escape($product->cod_accepted) == "N") {
                                                                                                                                                echo "checked";
                                                                                                                                            } ?> required>
                                                <label for="cod_no" class="custom-control-label">No</label>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="modal fade" id="return_policy" role="dialog" style="display:none;">
                            <div class="modal-dialog modal-dialog-centered login-modal" role="document">
                                <div class="modal-content">
                                    <div class="auth-box">
                                        <button type="button" class="close" data-dismiss="modal" onclick="t_c1()"><i class="icon-close"></i></button>
                                        <h4 class="title">Terms & Conditions related to return and exchange</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-box">
                            <div class="form-box-head">
                                <h4 class="title">
                                    Other Product Information<span class="Validation_error"> *</span>
                                </h4>
                            </div>
                            <div class="form-box-body">

                                <?php if ($product->supplier_product_type == 'Food') : ?>
                                    <label class="myradio">Does the product contains any liquid ?<span class="Validation_error"> *</span> &nbsp;</label>
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="contains_liquid" value="Y" id="contains_liquidy" class="custom-control-input" <?php echo ($product->contains_liquid == "Y") ? "checked" : ""; ?> required>
                                                <label for="contains_liquidy" class="custom-control-label">Yes</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="contains_liquid" value="N" id="contains_liquidn" class="custom-control-input" <?php echo ($product->contains_liquid == "N") ? "checked" : ""; ?> required>
                                                <label for="contains_liquidn" class="custom-control-label">No</label>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($product->supplier_product_type == 'Food') : ?>
                                    <label class="myradio">Is the product heat sensitive ?<span class="Validation_error"> *</span> &nbsp;</label>
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="contains_heat" value="Y" id="contains_heaty" class="custom-control-input" <?php echo ($product->contains_heat == "Y") ? "checked" : ""; ?> required>
                                                <label for="contains_heaty" class="custom-control-label">Yes</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="contains_heat" value="N" id="contains_heatn" class="custom-control-input" <?php echo ($product->contains_heat == "N") ? "checked" : ""; ?> required>
                                                <label for="contains_heatn" class="custom-control-label">No</label>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <!-- <div class="row" style="margin-top: 10px;">
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label class="myradio">Is Product Contains Liquid ? &nbsp;</label>&nbsp;
                                    <input type="radio" id="yes" class="myitm" name="contains_liquid" value="Y"><label for="yes">&nbsp; Yes</label>&ensp;&ensp;
                                    <input type="radio" id="no" class="myitm" name="contains_liquid" value="N"><label for="No">&nbsp; No</label>&nbsp;
                                </div>
                                <div class="col-md-6">
                                    <label class="myradio">Is Product Contains heat ? &nbsp;</label>&nbsp;
                                    <input type="radio" id="yes" class="myitm" name="contains_heat" value="Y"><label for="yes">&nbsp; Yes</label>&ensp;&ensp;
                                    <input type="radio" id="no" class="myitm" name="contains_heat" value="N"><label for="No">&nbsp; No</label>&nbsp;
                                </div>
                            </div>
                        </div> -->
                                <label class="myradio">Is the product expirable ?<span class="Validation_error"> *</span> &nbsp;</label>
                                <div class="row">

                                    <div class="col-12 col-sm-6 col-custom-field">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="expire" value="Y" id="yes_expiry" class="custom-control-input" <?php echo ($product->is_expire == "Y") ? 'checked' : ''; ?> required>
                                            <label for="yes_expiry" class="custom-control-label">Yes</label>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6 col-custom-field">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="expire" value="N" id="no_expiry" class="custom-control-input" <?php echo ($product->is_expire == "N") ? 'checked' : ''; ?> required>
                                            <label for="no_expiry" class="custom-control-label">No</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4" id="manufacturing_date" style="display: <?php echo (!empty($product->manufacturing_date)) ? 'block' : 'none'; ?>;">
                                        <label class="control-label">Manufacturing Date<span class="Validation_error"> *</span></label>
                                        <input type="text" autocomplete="off" id="datepicker" name="manufacturing_date" class="form-control auth-form-input" placeholder="dd-mm-yyyy" value="<?php echo (!empty($product->manufacturing_date)) ? $product->manufacturing_date : ''; ?>" onscrollpress="return nothingReturn(event)">
                                    </div>
                                    <div class="col-12 col-sm-4" id="expiry_date" style="display: <?php echo ($product->expiry_date != null) ? 'block' : 'none'; ?>;">
                                        <label class="control-label">Expiry Date<span class="Validation_error"> *</span></label>
                                        <input type="text" autocomplete="off" id="datepicker_exp" name="expiry_date" class="form-control auth-form-input datepick2" placeholder="dd-mm-yyyy" value="<?php echo (!empty($product->expiry_date)) ? $product->expiry_date : ''; ?>" onkeypress="return nothingReturn(event)">
                                    </div>
                                    <div class="col-12 col-sm-4" id="shelf_life" style="display: <?php echo ($product->shelf_life_from_date_of_manufacture != "") ? 'block' : 'none'; ?>;">
                                        <label class="control-label">Shelf Life from Date of Manufacture<span class="Validation_error"> *</span></label>
                                        <input type="text" autocomplete="off" name="shelf_life" class="form-control form-input" placeholder="Input shelf life" value=<?php echo $product->shelf_life_from_date_of_manufacture; ?>>
                                        <div class="col-sm-4 pull-right btn-select-dropdown">

                                            <select name="shelf_units" class="custom-select">
                                                <option value="Hours" <?php echo ($product->shelf_units == "Hours") ? 'selected' : ''; ?>>Hours</option>
                                                <option value="Days" <?php echo ($product->shelf_units == "Days") ? 'selected' : ''; ?>>Days</option>
                                                <option value="Weeks" <?php echo ($product->shelf_units == "Weeks") ? 'selected' : ''; ?>>Weeks</option>
                                                <option value="Months" <?php echo ($product->shelf_units == "Months") ? 'selected' : ''; ?>>Months</option>
                                                <option value="Years" <?php echo ($product->shelf_units == "Years") ? 'selected' : ''; ?>>Years</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                // if ($parent_categories_array[0]->id == 10 || $parent_categories_array[0]->id == 5 || $parent_categories_array[0]->id == 12 || $parent_categories_array[0]->id == 4 || $parent_categories_array[0]->id == 3 || $parent_categories_array[0]->id == 14 || $parent_categories_array[0]->id == 309 || $parent_categories_array[0]->id == 7 || $parent_categories_array[0]->id == 8 || $parent_categories_array[0]->id == 11) :
                                if ($parent_categories_array[0]->id == 1  && ($parent_categories_array[1]->id == 13 || $parent_categories_array[1]->id == 12 || $parent_categories_array[1]->id == 14 || $parent_categories_array[1]->id == 9 || $parent_categories_array[1]->id == 10) || $parent_categories_array[0]->id == 7 || $parent_categories_array[0]->id == 8 || $parent_categories_array[0]->id == 4 || $parent_categories_array[0]->id == 6 && ($parent_categories_array[1]->id != 45) || $parent_categories_array[0]->id == 5) :
                                ?>
                                    <label class="barting tooltip-product-other-info">Is it a handicraft?<span class="Validation_error"> *</span>&nbsp;<i class="fa fa-info-circle"></i><span class="tooltiptext-product"> Created with hands, without the use of any mechanised production process</span></label>
                                    <div class=" row">
                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_handicraft" value="Y" id="handcraftedy" class="custom-control-input" <?php if (html_escape($product->is_handicraft) == "Y") {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?> required>
                                                <label for="handcraftedy" class="custom-control-label">Yes</label>

                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_handicraft" value="N" id="handcraftedn" class="custom-control-input" <?php if (html_escape($product->is_handicraft) == "N") {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?> required>
                                                <label for="handcraftedn" class="custom-control-label">No</label>

                                            </div>
                                        </div>

                                    </div>
                                <?php endif; ?>
                                <?php
                                //  if ($parent_categories_array[0]->id == 10 || $parent_categories_array[0]->id == 5 || $parent_categories_array[0]->id == 13 || $parent_categories_array[0]->id == 12 || $parent_categories_array[0]->id == 9 || $parent_categories_array[0]->id == 1 || $parent_categories_array[0]->id == 4 || $parent_categories_array[0]->id == 2 || $parent_categories_array[0]->id == 3 || $parent_categories_array[0]->id == 14 || $parent_categories_array[0]->id == 309 || $parent_categories_array[0]->id == 7 || $parent_categories_array[0]->id == 8 || $parent_categories_array[0]->id == 11) : 
                                if ($parent_categories_array[0]->id == 1 || $parent_categories_array[0]->id == 7 || $parent_categories_array[0]->id == 8 || $parent_categories_array[0]->id == 4  || $parent_categories_array[0]->id == 6 && ($parent_categories_array[1]->id != 45) || $parent_categories_array[0]->id == 5) :
                                ?>
                                    <label class="barting tooltip-product-other-info">Is the product sustainable?<span class="Validation_error"> *</span>&nbsp;<i class="fa fa-info-circle"></i><span class="tooltiptext-product">Products that are environment-friendly over their whole life cycle - from raw material extraction to the time they are disposed</span> </label>
                                    <div class="row">

                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_sustainable" value="Y" id="Sustainabley" class="custom-control-input" <?php if (html_escape($product->is_sustainable) == "Y") {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?> required>
                                                <label for="Sustainabley" class="custom-control-label">Yes</label>

                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_sustainable" value="N" id="Sustainablen" class="custom-control-input" <?php if (html_escape($product->is_sustainable) == "N") {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?> required>
                                                <label for="Sustainablen" class="custom-control-label">No</label>

                                            </div>
                                        </div>

                                    </div>
                                <?php endif; ?>
                                <?php
                                // if ($parent_categories_array[0]->id == 13 || $parent_categories_array[0]->id == 12 || $parent_categories_array[0]->id == 9 || $parent_categories_array[0]->id == 1 || $parent_categories_array[0]->id == 4 || $parent_categories_array[0]->id == 2 || $parent_categories_array[0]->id == 14 || $parent_categories_array[0]->id == 309 || $parent_categories_array[0]->id == 8) :
                                if ($parent_categories_array[0]->id == 1  && ($parent_categories_array[1]->id == 9 || $parent_categories_array[1]->id == 10) || $parent_categories_array[0]->id == 3 || $parent_categories_array[0]->id == 2 || $parent_categories_array[0]->id == 6 && ($parent_categories_array[1]->id == 41 || $parent_categories_array[0]->id == 42 || $parent_categories_array[0]->id == 38 || $parent_categories_array[0]->id == 45) || $parent_categories_array[0]->id == 5) :
                                ?>
                                    <label class="barting tooltip-product-other-info">Is the product organic?<span class="Validation_error"> *</span>&nbsp;<i class="fa fa-info-circle" title=""></i> <span class="tooltiptext-product">Made frommaterials produced by protecting natiral resources and conserving biodiversity</span></label>
                                    <div class="row">

                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_organic" value="Y" id="organicy" class="custom-control-input" <?php if (html_escape($product->is_organic) == "Y") {
                                                                                                                                                echo "checked";
                                                                                                                                            } ?> required>
                                                <label for="organicy" class="custom-control-label">Yes</label>

                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_organic" value="N" id="organicn" class="custom-control-input" <?php if (html_escape($product->is_organic) == "N") {
                                                                                                                                                echo "checked";
                                                                                                                                            } ?> required>
                                                <label for="organicn" class="custom-control-label">No</label>

                                            </div>
                                        </div>

                                    </div>
                                <?php endif; ?>
                                <?php
                                // if ($parent_categories_array[0]->id == 9 || $parent_categories_array[0]->id == 1 || $parent_categories_array[0]->id == 2 || ($parent_categories_array[0]->id == 8 && $parent_categories_array[1]->id == 336) || ($parent_categories_array[0]->id == 309 && $parent_categories_array[1]->id == 316) || ($parent_categories_array[0]->id == 14 && $parent_categories_array[1]->id == 424)) :
                                if ($parent_categories_array[0]->id == 3 || $parent_categories_array[0]->id == 2 || $parent_categories_array[0]->id == 6 && ($parent_categories_array[1]->id == 45)) :
                                ?>
                                    <label class="barting tooltip-product-other-info">Is this product Gluten Free?<span class="Validation_error"> *</span>&nbsp;<i class="fa fa-info-circle"></i><span class="tooltiptext-product">Products without proteins found in wheat, barley, rye and oats</span> </label>
                                    <div class="row">

                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_gluten_Free" value="Y" id="gluten_freey" class="custom-control-input" <?php if (html_escape($product->is_gluten_Free) == "Y") {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?> required>
                                                <label for="gluten_freey" class="custom-control-label">Yes</label>

                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_gluten_Free" value="N" id="gluten_freen" class="custom-control-input" <?php if (html_escape($product->is_gluten_Free) == "N") {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?> required>
                                                <label for="gluten_freen" class="custom-control-label">No</label>

                                            </div>
                                        </div>

                                    </div>
                                <?php endif; ?>
                                <?php
                                // if ($parent_categories_array[0]->id == 9 || $parent_categories_array[0]->id == 1 || $parent_categories_array[0]->id == 2 || ($parent_categories_array[0]->id == 8 && $parent_categories_array[1]->id == 336) || ($parent_categories_array[0]->id == 309 && $parent_categories_array[1]->id == 316) || ($parent_categories_array[0]->id == 14 && $parent_categories_array[1]->id == 424)) : 
                                if ($parent_categories_array[0]->id == 3 || $parent_categories_array[0]->id == 2 || $parent_categories_array[0]->id == 6 && ($parent_categories_array[1]->id == 45)) :
                                ?>
                                    <label class="barting tooltip-product-other-info">Is this product Vegan?<span class="Validation_error"> *</span>&nbsp;<i class="fa fa-info-circle"></i> <span class="tooltiptext-product">Products that do not contain any animal ingredients or animal-derived ingredients</span></label>
                                    <div class="row">

                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_vegan" value="Y" id="vegany" class="custom-control-input" <?php if (html_escape($product->is_vegan) == "Y") {
                                                                                                                                            echo "checked";
                                                                                                                                        } ?> required>
                                                <label for="vegany" class="custom-control-label">Yes</label>

                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_vegan" value="N" id="vegann" class="custom-control-input" <?php if (html_escape($product->is_vegan) == "N") {
                                                                                                                                            echo "checked";
                                                                                                                                        } ?> required>
                                                <label for="vegann" class="custom-control-label">No</label>

                                            </div>
                                        </div>

                                    </div>
                                <?php endif; ?>
                                <?php
                                // if ($parent_categories_array[0]->id == 9 || $parent_categories_array[0]->id == 1 || $parent_categories_array[0]->id == 2 || ($parent_categories_array[0]->id == 8 && $parent_categories_array[1]->id == 336) || ($parent_categories_array[0]->id == 309 && $parent_categories_array[1]->id == 316) || ($parent_categories_array[0]->id == 14 && $parent_categories_array[1]->id == 424)) :
                                if ($parent_categories_array[0]->id == 3  || $parent_categories_array[0]->id == 2) :
                                ?>
                                    <label class="barting tooltip-product-other-info">Is this product Keto-Friendly?<span class="Validation_error"> *</span>&nbsp;<i class="fa fa-info-circle"></i> <span class="tooltiptext-product">High-fat, adequate protein and low-carb products</span></label>
                                    <div class="row">

                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_keto_friendly" value="Y" id="keto_friendlyy" class="custom-control-input" <?php if (html_escape($product->is_keto_friendly) == "Y") {
                                                                                                                                                            echo "checked";
                                                                                                                                                        } ?> required>
                                                <label for="keto_friendlyy" class="custom-control-label">Yes</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_keto_friendly" value="N" id="keto_friendlyn" class="custom-control-input" <?php if (html_escape($product->is_keto_friendly) == "N") {
                                                                                                                                                            echo "checked";
                                                                                                                                                        } ?> required>
                                                <label for="keto_friendlyn" class="custom-control-label">No</label>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <label class="barting">Can the product be personalised ?<span class="Validation_error"> *</span> </label>&nbsp;
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-custom-field">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="is_personalised" value="Y" id="personalised_y" class="custom-control-input" <?php if (html_escape($product->is_personalised) == "Y") {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?> required>
                                            <label for="personalised_y" class="custom-control-label">Yes</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-custom-field">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="is_personalised" value="N" id="personalised_n" class="custom-control-input" <?php if (html_escape($product->is_personalised) == "N") {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?> required>
                                            <label for="personalised_n" class="custom-control-label">No</label>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                // if ($parent_categories_array[0]->id == 13 || $parent_categories_array[0]->id == 9 || $parent_categories_array[0]->id == 1 || $parent_categories_array[0]->id == 2 || ($parent_categories_array[0]->id == 8 && $parent_categories_array[1]->id == 336) || ($parent_categories_array[0]->id == 309 && $parent_categories_array[1]->id == 316) || ($parent_categories_array[0]->id == 14 && $parent_categories_array[1]->id == 424)) : 
                                if ($parent_categories_array[0]->id == 3  || $parent_categories_array[0]->id == 2 || $parent_categories_array[0]->id == 6 && ($parent_categories_array[1]->id == 45)) :
                                ?>
                                    <label class="barting tooltip-product-other-info">Does the product/item contain any allergen?<span class="Validation_error"> *</span><i class="fa fa-info-circle" style="margin-left: 0.5%;"></i><span class="tooltiptext-product">A harmless substance that can trigger an allergic reaction in some people</span> </label>
                                    <div class="row">

                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_allergens" value="Y" id="Allergensy" class="custom-control-input" <?php if (html_escape($product->is_allergens) == "Y") {
                                                                                                                                                    echo "checked";
                                                                                                                                                } ?> required>
                                                <label for="Allergensy" class="custom-control-label">Yes</label>

                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-6 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_allergens" value="N" id="Allergensn" class="custom-control-input" <?php if (html_escape($product->is_allergens) == "N") {
                                                                                                                                                    echo "checked";
                                                                                                                                                } ?> required>
                                                <label for="Allergensn" class="custom-control-label">No</label>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="row" style="margin-top: 10px;margin-bottom: 10px; <?php if (html_escape($product->is_allergens) == "Y") {
                                                                                                        echo "display:block;";
                                                                                                    } else {
                                                                                                        echo "display:none;";
                                                                                                    } ?>" id="allergance">
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <label class="control-label">Allergen Information </label>
                                                <input type="text" name="allergance" value="<?php if (html_escape($product->allergance)) {
                                                                                                echo html_escape($product->allergance);
                                                                                            } ?>" class="form-control auth-form-input">
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php
                                // if ($parent_categories_array[0]->id == 9 || $parent_categories_array[0]->id == 2 || ($parent_categories_array[0]->id == 14 && $parent_categories_array[1]->id == 424)) : 
                                if ($parent_categories_array[0]->id == 2 && $parent_categories_array[1]->id == 15 && ($parent_categories_array[2]->id == 105 || $parent_categories_array[2]->id == 106 || $parent_categories_array[2]->id == 109 || $parent_categories_array[2]->id == 104 || $parent_categories_array[2]->id == 107)) :
                                ?>
                                    <label class="myradio">Meal Type<span class="Validation_error"> *</span> &nbsp;</label>
                                    <div class="row">

                                        <div class="col-12 col-sm-3 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_appetisers_main_course_beverages_desserts" value="appetisers" id="Appetisers" class="custom-control-input" <?php if (html_escape($product->is_appetisers_main_course_beverages_desserts) == "appetisers") {
                                                                                                                                                                                            echo "checked";
                                                                                                                                                                                        } ?> required>
                                                <label for="Appetisers" class="custom-control-label">Appetisers</label>

                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-3 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_appetisers_main_course_beverages_desserts" value="main_Course" id="Main_Course" class="custom-control-input" <?php if (html_escape($product->is_appetisers_main_course_beverages_desserts) == "main_Course") {
                                                                                                                                                                                                echo "checked";
                                                                                                                                                                                            } ?> required>
                                                <label for="Main_Course" class="custom-control-label">Main Course</label>

                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-3 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_appetisers_main_course_beverages_desserts" value="beverages" id="Beverages" class="custom-control-input" <?php if (html_escape($product->is_appetisers_main_course_beverages_desserts) == "beverages") {
                                                                                                                                                                                            echo "checked";
                                                                                                                                                                                        } ?> required>
                                                <label for="Beverages" class="custom-control-label">Beverages</label>

                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-3 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_appetisers_main_course_beverages_desserts" value="desserts" id="Desserts" class="custom-control-input" <?php if (html_escape($product->is_appetisers_main_course_beverages_desserts) == "desserts") {
                                                                                                                                                                                        echo "checked";
                                                                                                                                                                                    } ?> required>
                                                <label for="Desserts" class="custom-control-label">Desserts</label>

                                            </div>
                                        </div>

                                    </div>
                                <?php endif; ?>
                                <?php
                                // if ($parent_categories_array[0]->id == 3 || ($parent_categories_array[0]->id == 14 && $parent_categories_array[1]->id == 419)) :
                                if ($parent_categories_array[0]->id == 1 && $parent_categories_array[1]->id == 11 && ($parent_categories_array[2]->id == 81 || $parent_categories_array[2]->id == 79 || $parent_categories_array[2]->id == 80 || $parent_categories_array[2]->id == 78 || $parent_categories_array[2]->id == 84)) :
                                ?>
                                    <label class="myradio">Jewellery Type<span class="Validation_error"> *</span> &nbsp;</label>
                                    <div class="row">

                                        <div class="col-12 col-sm-2 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_gold_silver_precious_stones_semi_precious_artificial" value="gold" id="Gold" class="custom-control-input" <?php if (html_escape($product->is_gold_silver_precious_stones_semi_precious_artificial) == "gold") {
                                                                                                                                                                                            echo "checked";
                                                                                                                                                                                        } ?> required>
                                                <label for="Gold" class="custom-control-label">Gold</label>

                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-2 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_gold_silver_precious_stones_semi_precious_artificial" value="silver" id="silver" class="custom-control-input" <?php if (html_escape($product->is_gold_silver_precious_stones_semi_precious_artificial) == "silver") {
                                                                                                                                                                                                echo "checked";
                                                                                                                                                                                            } ?> required>
                                                <label for="silver" class="custom-control-label">Silver</label>

                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-3 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_gold_silver_precious_stones_semi_precious_artificial" value="Precious Stones" id="Precious_Stones" class="custom-control-input" <?php if (html_escape($product->is_gold_silver_precious_stones_semi_precious_artificial) == "Precious Stones") {
                                                                                                                                                                                                                    echo "checked";
                                                                                                                                                                                                                } ?> required>
                                                <label for="Precious_Stones" class="custom-control-label">Precious Stones</label>

                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-3 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_gold_silver_precious_stones_semi_precious_artificial" value="Semi Precious" id="Semi_Precious" class="custom-control-input" <?php if (html_escape($product->is_gold_silver_precious_stones_semi_precious_artificial) == "Semi Precious") {
                                                                                                                                                                                                                echo "checked";
                                                                                                                                                                                                            } ?> required>
                                                <label for="Semi_Precious" class="custom-control-label">Semi Precious</label>

                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-2 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_gold_silver_precious_stones_semi_precious_artificial" value="Artificial" id="Artificial" class="custom-control-input" <?php if (html_escape($product->is_gold_silver_precious_stones_semi_precious_artificial) == "Artificial") {
                                                                                                                                                                                                        echo "checked";
                                                                                                                                                                                                    } ?> required>
                                                <label for="Artificial" class="custom-control-label">Artificial</label>

                                            </div>
                                        </div>

                                    </div>
                                <?php endif; ?>
                                <?php
                                // if ($parent_categories_array[0]->id == 2 || $parent_categories_array[0]->id == 9 || $parent_categories_array[0]->id == 1 || ($parent_categories_array[0]->id == 8 && $parent_categories_array[1]->id == 336) || ($parent_categories_array[0]->id == 309 && $parent_categories_array[1]->id == 316) || ($parent_categories_array[0]->id == 14 && $parent_categories_array[1]->id == 424)) :
                                if ($parent_categories_array[0]->id == 2) :
                                ?>
                                    <label class="myradio">Food Type<span class="Validation_error"> *</span> &nbsp;</label>
                                    <div class="row">
                                        <div class="col-12 col-sm-4 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_veg_nonveg_jain" value="Veg" id="Veg" class="custom-control-input" <?php if (html_escape($product->is_veg_nonveg_jain) == "Veg") {
                                                                                                                                                    echo "checked";
                                                                                                                                                } ?> required>
                                                <label for="Veg" class="custom-control-label">Veg</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_veg_nonveg_jain" value="non_Veg" id="non_Veg" class="custom-control-input" <?php if (html_escape($product->is_veg_nonveg_jain) == "non_Veg") {
                                                                                                                                                            echo "checked";
                                                                                                                                                        } ?> required>
                                                <label for="non_Veg" class="custom-control-label">Non Veg</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4 col-custom-field">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="is_veg_nonveg_jain" value="Jain" id="Jain" class="custom-control-input" <?php if (html_escape($product->is_veg_nonveg_jain) == "Jain") {
                                                                                                                                                        echo "checked";
                                                                                                                                                    } ?> required>
                                                <label for="Jain" class="custom-control-label">Jain</label>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (1) : ?>
                                    <div class="row" style="margin-top: 10px;">
                                        <div class="form-group">
                                            <?php if ($parent_categories_array[0]->id == 12 || $parent_categories_array[0]->id == 4 || ($parent_categories_array[0]->id == 8 && ($parent_categories_array[1]->id == 330 || $parent_categories_array[1]->id == 331 || $parent_categories_array[1]->id == 337)) || ($parent_categories_array[0]->id == 14 && $parent_categories_array[1]->id == 427) || ($parent_categories_array[0]->id == 14 && $parent_categories_array[1]->id == 413 && $parent_categories_array[2]->id == 879) || ($parent_categories_array[0]->id == 14 && $parent_categories_array[1]->id == 418 && $parent_categories_array[2]->id == 909) || ($parent_categories_array[0]->id == 14 && $parent_categories_array[1]->id == 420 && ($parent_categories_array[2]->id == 912 || $parent_categories_array[2]->id == 914)) || ($parent_categories_array[0]->id == 14 && $parent_categories_array[1]->id == 427) || ($parent_categories_array[0]->id == 14 && $parent_categories_array[1]->id == 423 && $parent_categories_array[2]->id == 920) || ($parent_categories_array[0]->id == 8 && ($parent_categories_array[1]->id == 330 || $parent_categories_array[1]->id == 331 || $parent_categories_array[1]->id == 337))) : ?>
                                                <div class="col-md-4">
                                                    <label class="control-label">Product Wash Instructions?<span class="Validation_error"> *</span>&nbsp;</label>&nbsp;
                                                    <select name="product_wash_instruction" id="product_wash_instruction" onchange='Checkproduct_wash_instruction(this.value);' class="form-control custom-select" required>
                                                        <option value=""><?php echo trans("select_option"); ?></option>
                                                        <option value="Machine Wash" <?php echo ($product->product_wash_instruction == "Machine Wash") ? 'selected' : ''; ?>>Machine Wash</option>
                                                        <option value="Dry Clean Only" <?php echo ($product->product_wash_instruction == "Dry Clean Only") ? 'selected' : ''; ?>>Dry Clean Only</option>
                                                        <option value="Hand Wash" <?php echo ($product->product_wash_instruction == "Hand Wash") ? 'selected' : ''; ?>>Hand Wash</option>
                                                        <option value="Do Not Dry clean" <?php echo ($product->product_wash_instruction == "Do Not Dry clean") ? 'selected' : ''; ?>>Do Not Dry clean</option>
                                                        <option value="Do not Bleach" <?php echo ($product->product_wash_instruction == "Do not Bleach") ? 'selected' : ''; ?>>Do not Bleach</option>
                                                        <option value="Do not Iron" <?php echo ($product->product_wash_instruction == "Do not Iron") ? 'selected' : ''; ?>>Do not Iron</option>
                                                        <option value="Dry in shade" <?php echo ($product->product_wash_instruction == "Dry in shade") ? 'selected' : ''; ?>>Dry in shade</option>
                                                        <option value="Cold Water wash" <?php echo ($product->product_wash_instruction == "Cold Water wash") ? 'selected' : ''; ?>>Cold Water wash</option>
                                                        <option value="Hot water Wash" <?php echo ($product->product_wash_instruction == "Hot water Wash") ? 'selected' : ''; ?>>Hot water Wash</option>
                                                        <option value="First Time Dry-Clean followed by hand wash" <?php echo ($product->product_wash_instruction == "First Time Dry-Clean followed by hand wash") ? 'selected' : ''; ?>>First Time Dry-Clean followed by hand wash</option>
                                                        <option value="First Time Dry-Clean followed by machine wash" <?php echo ($product->product_wash_instruction == "First Time Dry-Clean followed by machine wash") ? 'selected' : ''; ?>>First Time Dry-Clean followed by machine wash</option>
                                                        <option value="Wet Cloth Wipe" <?php echo ($product->product_wash_instruction == "Wet Cloth Wipe") ? 'selected' : ''; ?>>Wet Cloth Wipe</option>
                                                        <option value="Non-washable" <?php echo ($product->product_wash_instruction == "Non-washable") ? 'selected' : ''; ?>>Non-washable</option>
                                                        <option value="Dishwash Safe" <?php echo ($product->product_wash_instruction == "Dishwash Safe") ? 'selected' : ''; ?>>Dishwash Safe</option>
                                                        <option value="Hand Wash" <?php echo ($product->product_wash_instruction == "Hand Wash") ? 'selected' : ''; ?>>Hand Wash</option>
                                                        <option value="Wet Cloth Wipe" <?php echo ($product->product_wash_instruction == "Wet Cloth Wipe") ? 'selected' : ''; ?>>Wet Cloth Wipe</option>
                                                        <option value="Others" <?php echo ($product->product_wash_instruction == "Others") ? 'selected' : ''; ?>>Others</option>
                                                    </select>
                                                    <br>
                                                    <input type="text" name="other_product_wash_instruction" value="<?php echo (!empty($product->other_product_wash_instruction)) ? $product->other_product_wash_instruction : ''; ?>" id="other_product_wash_instruction" style='display:<?php echo ($product->product_wash_instruction == "Others") ? 'block' : 'none'; ?>;' class="form-control auth-form-input" placeholder="Please Specify">
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($product->category_id == 1389) : ?>
                                                <div class="col-md-4">
                                                    <label class="control-label">Blouse Details<span class="Validation_error"> *</span>&nbsp;<i class="fa fa-info-circle" title=""></i> </label>&nbsp;
                                                    <select name="blouse_details" id="blouse_details" onchange='Checkblouse_details(this.value);' class="form-control custom-select" required>
                                                        <option value=""><?php echo trans("select_option"); ?></option>
                                                        <option value="With Blouse Piece" <?php echo ($product->blouse_details == "With Blouse Piece") ? 'selected' : ''; ?>>With Blouse Piece</option>
                                                        <option value="Without Blouse Piece" <?php echo ($product->blouse_details == "Without Blouse Piece") ? 'selected' : ''; ?>>Without Blouse Piece</option>
                                                        <option value="With Stitched Blouse" <?php echo ($product->blouse_details == "With Stitched Blouse") ? 'selected' : ''; ?>>With Stitched Blouse</option>
                                                        <option value="Others" <?php echo ($product->blouse_details == "Others") ? 'selected' : ''; ?>>Others</option>
                                                    </select>
                                                    <br>
                                                    <input type="text" name="other_blouse_details" value="<?php echo (!empty($product->other_blouse_details)) ? $product->other_blouse_details : ''; ?>" id="other_blouse_details" style='display:<?php echo ($product->blouse_details == "Others") ? 'block' : 'none'; ?>;' class="form-control auth-form-input" placeholder="Please Specify">
                                                </div>
                                            <?php endif; ?>
                                            <!-- <?php if ($parent_categories_array[0]->id == 2) : ?>
                                                <div class="col-md-4">
                                                    <label class="control-label">Minimum Prior Notice Time&nbsp;<i class="fa fa-info-circle" title="Minimum number of days notice that you need before the dispatch date."></i></label>&nbsp;
                                                    <select name="minimum_Prior_notice" id="minimum_Prior_notice" onchange='Checkminimum_Prior_notice(this.value);' class="form-control custom-select" required>
                                                        <option value=""><?php echo trans("select_option"); ?></option>
                                                        <option value="24 hours" <?php echo ($product->minimum_Prior_notice == "24 hours") ? 'selected' : ''; ?>>24 hours</option>
                                                        <option value="48 hours" <?php echo ($product->minimum_Prior_notice == "48 hours") ? 'selected' : ''; ?>>48 hours</option>
                                                        <option value="72 hours" <?php echo ($product->minimum_Prior_notice == "72 hours") ? 'selected' : ''; ?>>72 hours</option>
                                                        <option value="Others" <?php echo ($product->minimum_Prior_notice == "Others") ? 'selected' : ''; ?>>Others</option>
                                                    </select>
                                                    <br>
                                                    <input type="text" name="other_minimum_Prior_notice" id="other_minimum_Prior_notice" style='display:none;' class="form-control auth-form-input" placeholder="Please Specify">
                                                </div>
                                            <?php endif; ?> -->
                                            <?php if ($parent_categories_array[0]->id == 309) : ?>
                                                <div class="col-md-4">
                                                    <label class="control-label">Pet age<span class="Validation_error"> *</span>&nbsp;<i class="fa fa-info-circle" title=""></i> </label>&nbsp;
                                                    <select name="pet_age" id="pet_age" class="form-control custom-select" onchange='Checkpet_age(this.value);' required>
                                                        <option value=""><?php echo trans("select_option"); ?></option>
                                                        <option value="Young Adult" <?php echo ($product->pet_age == "Young Adult") ? 'selected' : ''; ?>>Young Adult</option>
                                                        <option value="All Life Stages" <?php echo ($product->pet_age == "All Life Stages") ? 'selected' : ''; ?>>All Life Stages</option>
                                                        <option value="Senior" <?php echo ($product->pet_age == "Senior") ? 'selected' : ''; ?>>Senior</option>
                                                        <option value="Adolescent" <?php echo ($product->pet_age == "Adolescent") ? 'selected' : ''; ?>>Adolescent</option>
                                                        <option value="Adult" <?php echo ($product->pet_age == "Adult") ? 'selected' : ''; ?>>Adult</option>
                                                        <option value="Baby" <?php echo ($product->pet_age == "Baby") ? 'selected' : ''; ?>>Baby</option>
                                                        <option value="Puppy" <?php echo ($product->pet_age == "Puppy") ? 'selected' : ''; ?>>Puppy</option>
                                                        <option value="Kitten" <?php echo ($product->pet_age == "Kitten") ? 'selected' : ''; ?>>Kitten</option>
                                                        <option value="Others" <?php echo ($product->pet_age == "Others") ? 'selected' : ''; ?>>Others</option>
                                                    </select>
                                                    <br>
                                                    <input type="text" name="other_pet_age" value="<?php echo (!empty($product->other_pet_age)) ? $product->other_pet_age : ''; ?>" id="other_pet_age" style='display:<?php echo ($product->pet_age == "Others") ? 'block' : 'none'; ?>;' class="form-control auth-form-input" placeholder="Please Specify">
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($parent_categories_array[0]->id == 9 || ($parent_categories_array[0]->id == 14 && $parent_categories_array[1]->id == 424) || ($parent_categories_array[0]->id == 14 && $parent_categories_array[1]->id == 416 && $parent_categories_array[2]->id == 899)) : ?>
                                                <div class="col-md-4">
                                                    <label class="control-label">Storage Instruction<span class="Validation_error"> *</span> &nbsp;<i class="fa fa-info-circle" title=""></i> </label>&nbsp;
                                                    <select name="storage_instruction" id="storage_instruction" onchange='Checkstorage_instruction(this.value);' class="form-control custom-select" required>
                                                        <option value=""><?php echo trans("select_option"); ?></option>
                                                        <option value="Room Temperature" <?php echo ($product->storage_instruction == "Room Temperature") ? 'selected' : ''; ?>>Room Temperature</option>
                                                        <option value="Refrigerate" <?php echo ($product->storage_instruction == "Refrigerate") ? 'selected' : ''; ?>>Refrigerate</option>
                                                        <option value="Freeze" <?php echo ($product->storage_instruction == "Freeze") ? 'selected' : ''; ?>>Freeze</option>
                                                        <option value="Air Tight" <?php echo ($product->storage_instruction == "Air Tight") ? 'selected' : ''; ?>>Air Tight</option>
                                                        <option value="Others" <?php echo ($product->storage_instruction == "Others") ? 'selected' : ''; ?>>Others</option>
                                                    </select>
                                                    <br>
                                                    <input type="text" name="other_storage_instruction" value="<?php echo (!empty($product->other_storage_instruction)) ? $product->other_storage_instruction : ''; ?>" id="other_storage_instruction" style='display:<?php echo ($product->storage_instruction == "Others") ? 'block' : 'none'; ?>;' class="form-control auth-form-input" placeholder="Please Specify">
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="row" style="margin-top: 10px;">
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label class="barting tooltip-product-other-info">
                                                <p class="tooltip-product">Delivery Area<span class="Validation_error"> *</span> &nbsp;<i class="fa fa-info-circle"></i><span class="tooltiptext">Radius in which this product can be delivered</span></p>
                                            </label>
                                            <select name="delivery_area" id="delivery_area" onchange='Checkdelivery_area(this.value);' class="form-control custom-select" required>
                                                <option value=""><?php echo trans("select_option"); ?></option>
                                                <option value="5 km" <?php echo ($product->delivery_area == "5 km") ? 'selected' : ''; ?>>5 km</option>
                                                <option value="10 km" <?php echo ($product->delivery_area == "10 km") ? 'selected' : ''; ?>>10 km</option>
                                                <option value="20 km" <?php echo ($product->delivery_area == "20 km") ? 'selected' : ''; ?>>20 km</option>
                                                <option value="30 km" <?php echo ($product->delivery_area == "30 km") ? 'selected' : ''; ?>>30 km</option>
                                                <option value="40 km" <?php echo ($product->delivery_area == "40 km") ? 'selected' : ''; ?>>40 km</option>
                                                <option value="50 km" <?php echo ($product->delivery_area == "50 km") ? 'selected' : ''; ?>>50 km</option>
                                                <option value="Inter city" <?php echo ($product->delivery_area == "Inter city") ? 'selected' : ''; ?>>Inter city</option>
                                                <option value="Inter state" <?php echo ($product->delivery_area == "Inter state") ? 'selected' : ''; ?>>Inter state</option>
                                                <option value="Pan India" <?php echo ($product->delivery_area == "Pan India") ? 'selected' : ''; ?>>Pan India</option>
                                                <option value="Others" <?php echo ($product->delivery_area == "Others") ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                            <input type="text" name="other_delivery_area" value="<?php echo (!empty($product->other_delivery_area)) ? $product->other_delivery_area : ''; ?>" id="other_delivery_area" style='display:<?php echo ($product->delivery_area == "Others") ? 'block' : 'none'; ?>;' class="form-control auth-form-input" placeholder="Please Specify">
                                        </div>


                                    </div>

                                </div>
                                <div class="row" style="margin-top:10px;display:<?php echo ($product->order_capacity != null) ? 'block' : 'none'; ?>;" id="capacity">
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label>
                                                <p class="tooltip-product">Order Capacity<span class="Validation_error"> *</span> &nbsp;<i class="fa fa-info-circle"></i><span class="tooltiptext">Maximum no of orders that you can accept in a day for this product</span></p>
                                            </label>

                                            <input type="text" name="order_capacity" id="order_capacity" value="<?php if (html_escape($product->order_capacity)) {
                                                                                                                    echo html_escape($product->order_capacity);
                                                                                                                } ?>" class="form-control auth-form-input" <?php echo ($product->order_capacity != null) ? 'required' : ''; ?>>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 10px;">
                                    <div class="form-group">
                                        <?php if ($parent_categories_array[0]->id == 2) : ?>
                                            <div class="col-md-6">
                                                <label class="myradio">Available days of the week<span class="Validation_error"> *</span> &nbsp;</label>
                                                <select class="demo" multiple="multiple" required name="availability[]">
                                                    <?php
                                                    $avail_days = explode(",", $product->availability);
                                                    ?>
                                                    <optgroup>
                                                        <option value="All days" <?php echo (in_array("All days", $avail_days)) ? 'selected' : ''; ?>>All Days</option>
                                                        <option value="Sunday" <?php echo (in_array("Sunday", $avail_days)) ? 'selected' : ''; ?>>Sunday</option>
                                                        <option value="Monday" <?php echo (in_array("Monday", $avail_days)) ? 'selected' : ''; ?>>Monday</option>
                                                        <option value="Tuesday" <?php echo (in_array("Tuesday", $avail_days)) ? 'selected' : ''; ?>>Tuesday</option>
                                                        <option value="Wednesday" <?php echo (in_array("Wednesday", $avail_days)) ? 'selected' : ''; ?>>Wednesday</option>
                                                        <option value="Thursday" <?php echo (in_array("Thursday", $avail_days)) ? 'selected' : ''; ?>>Thursday</option>
                                                        <option value="Friday" <?php echo (in_array("Friday", $avail_days)) ? 'selected' : ''; ?>>Friday</option>
                                                        <option value="Saturday" <?php echo (in_array("Saturday", $avail_days)) ? 'selected' : ''; ?>>Saturday</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        <?php endif; ?>
                                        <div class="col-md-4">
                                            <label>Special Delivery Requirements<span class="Validation_error"> *</span></label>
                                            <select name="special_delivery" onchange='for_other(this.value);' class="form-control custom-select" required>
                                                <option value=""><?php echo trans("select_option"); ?></option>
                                                <option value="Fragile Delivery" <?php echo ($product->special_delivery_requirement == "Fragile Delivery") ? 'selected' : ''; ?>>Fragile Delivery</option>
                                                <option value="Temperature controlled delivery" <?php echo ($product->special_delivery_requirement == "Temperature controlled delivery") ? 'selected' : ''; ?>>Temperature controlled delivery</option>
                                                <option value="Heavy items delivery" <?php echo ($product->special_delivery_requirement == "Heavy items delivery") ? 'selected' : ''; ?>>Heavy items delivery</option>
                                                <option value="Precious items safe delivery" <?php echo ($product->special_delivery_requirement == "Precious items safe delivery") ? 'selected' : ''; ?>>Precious items safe delivery</option>
                                                <option value="No special requirement" <?php echo ($product->special_delivery_requirement == "No special requirement") ? 'selected' : ''; ?>>No special requirement</option>
                                                <option value="Others" <?php echo ($product->special_delivery_requirement == "Others") ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4" id="other" style='display:<?php echo ($product->special_delivery_requirement == "Others") ? 'block' : 'none'; ?>;'>
                                            <label class="control-label">Other (please specify)<span class="Validation_error"> *</span></label>
                                            <input type="text" id="other_special_delivery_input" autocomplete="off" name="special_delivery_other" value="<?php echo (!empty($product->special_delivery_other)) ? $product->special_delivery_other : ''; ?>" class="form-control auth-form-input" placeholder="Enter other Special Delivery Requirement">
                                        </div>

                                        <div class="col-md-4" id="temp" style='display:<?php echo ($product->special_delivery_requirement == "Temperature controlled delivery") ? 'block' : 'none'; ?>;'>
                                            <label class="control-label">Temperature (In Celsius)<span class="Validation_error"> *</span></label>
                                            <input type="text" id="temperature_input" autocomplete="off" name="temperature" value="<?php echo (!empty($product->temperature)) ? $product->temperature : ''; ?>" class="form-control auth-form-input">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <?php $show_video_prev = false;
                        $show_audio_prev = false;
                        if (($product->product_type == 'physical' && $this->form_settings->physical_video_preview == 1) || ($product->product_type == 'digital' && $this->form_settings->digital_video_preview == 1)) :
                            $show_video_prev = true;
                        endif;
                        if (($product->product_type == 'physical' && $this->form_settings->physical_audio_preview == 1) || ($product->product_type == 'digital' && $this->form_settings->digital_audio_preview == 1)) :
                            $show_audio_prev = true;
                        endif; ?>
                        <?php if ($show_video_prev || $show_audio_prev) : ?>
                            <div class="form-box form-box-preview">
                                <div class="form-box-head">
                                    <h4 class="title">Product Demo</h4>
                                    <small><?php echo trans("demo_url_exp"); ?></small>
                                </div>
                                <div class="form-box-body">
                                    <input type="text" name="demo_url" class="form-control form-input" value="<?= html_escape($product->demo_url); ?>" placeholder="<?= trans("demo_url"); ?>">
                                </div><br>
                                <div class="form-box-body">
                                    <div class="row">
                                        <?php if ($show_video_prev) : ?>
                                            <div class="col-sm-12 col-sm-6 m-b-30">
                                                <label><?php echo trans("video_preview"); ?></label>
                                                <small>(<?php echo trans("video_preview_exp"); ?>)</small>
                                                <small>Maximum sixe 30 MB</small>
                                                <?php $this->load->view("dashboard/product/_video_upload_box"); ?>
                                            </div>
                                        <?php endif;
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="form-box">
                        <div class="form-box-head">
                            <h4 class="title">
                                Product Demo Url<br>
                                <small><?php echo trans("demo_url_exp"); ?></small>
                            </h4>
                        </div>
                        <div class="form-box-body">
                            <input type="text" name="demo_url" class="form-control form-input" value="<?= html_escape($product->demo_url); ?>" placeholder="<?= trans("demo_url"); ?>">
                        </div>
                    </div> -->
                        <?php endif; ?>

                        <?php if ($product->listing_type == 'ordinary_listing' && $this->form_settings->external_link == 1) : ?>
                            <div class="form-box">
                                <div class="form-box-head">
                                    <h4 class="title">
                                        <?php echo trans('external_link'); ?><br>
                                        <small><?php echo trans("external_link_exp"); ?></small>
                                    </h4>
                                </div>
                                <div class="form-box-body">
                                    <input type="text" name="external_link" class="form-control form-input" value="<?php echo html_escape($product->external_link); ?>" placeholder="<?php echo trans("external_link"); ?>">
                                </div>
                            </div>
                        <?php endif; ?>


                        <?php if ($this->form_settings->variations == 1 && $product->listing_type != 'ordinary_listing') : ?>
                            <div class="form-box">
                                <div class="form-box-head">
                                    <h4 class="title">
                                        <?php echo trans('variations'); ?>
                                        <small><?php echo trans("variations_exp"); ?></small>
                                    </h4>
                                </div>
                                <div class="form-box-body">
                                    <div class="row">
                                        <div id="response_product_variations" class="col-sm-12">
                                            <?php $this->load->view("dashboard/product/variation/_response_variations", ["product_variations" => $product_variations]); ?>
                                        </div>
                                        <div class="col-sm-12">
                                            <button type="button" class="btn btn-md btn-secondary btn-variation" data-toggle="modal" data-target="#variationModalSelect">
                                                <?php echo trans("select_existing_variation"); ?>
                                            </button>
                                            <button type="button" class="btn btn-md btn-info btn-variation" data-toggle="modal" data-target="#addVariationModal">
                                                <?php echo trans("add_variation"); ?>
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>



                        <?php if ($this->form_settings->product_location == 1 && $product->product_type == 'physical') :
                            if ($product->country_id == 0) {
                                $country_id = $this->auth_user->country_id;
                                $state_id = $this->auth_user->state_id;
                                $city_id = $this->auth_user->city_id;
                                $address = $this->auth_user->address;
                                $zip_code = $this->auth_user->zip_code;
                            } else {
                                $country_id = $product->country_id;
                                $state_id = $product->state_id;
                                $city_id = $product->city_id;
                                $address = $product->address;
                                $zip_code = $product->zip_code;
                            }
                        ?>
                            <div class="">
                                <div class="form-box-head">
                                    <h4 class="title"><?php echo trans('pick_location'); ?></h4>
                                </div>
                                <div class="form-box-body">
                                    <div id='TextBoxesGroup'>
                                        <div id="TextBoxDiv1">
                                            <div class="row">
                                                <div class="col-12 col-sm-4 m-b-15">
                                                    <label class="control-label">Pincode<span class="Validation_error"> *</span></label>
                                                    <input type="number" name="pincode1" id="pincode1" class="form-control auth-form-input" placeholder="Pincode" value="<?php echo empty($product->product_pincode) ? html_escape($user->pincode) : html_escape($product->product_pincode); ?>" required maxlength="6" minlength="6" required onchange="get_location($( '#pincode1').val())">
                                                    <p class="Validation_error" id="pincode_p1"></p>
                                                    <span class="Validation_error error" id="pincode_span1"></span>
                                                </div>

                                                <div class="col-12 col-sm-4 m-b-15">

                                                    <label class="control-label">State<span class="Validation_error"> *</span></label>
                                                    <input type="text" name="supplier_state1" id="product_state" class="form-control auth-form-input" value="<?php echo empty($product->product_state) ? html_escape($user->supplier_state) : html_escape($product->product_state); ?>" placeholder="State" required readonly>
                                                    <p class="Validation_error" id="state_p1"></p>
                                                </div>
                                                <div class="col-12 col-sm-4 m-b-15">
                                                    <label class="control-label">City<span class="Validation_error"> *</span></label>
                                                    <input type="text" name="supplier_city" id="product_city" class="form-control auth-form-input" value="<?php echo empty($product->product_city) ? html_escape($user->supplier_city) : html_escape($product->product_city); ?>" placeholder="City" required readonly>
                                                    <p class="Validation_error" id="city_p1"></p>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-12 col-sm-4 m-b-15">
                                                    <label class="control-label">Area<span class="Validation_error"> *</span></label>
                                                    <input type="text" name="area" id="product_area" class="form-control auth-form-input" placeholder="Area" value="<?php echo empty($product->product_area) ? html_escape($user->supplier_area) : html_escape($product->product_area); ?>" required>
                                                    <p class="Validation_error" id="area_p1"></p>
                                                </div>
                                                <div class="col-12 col-sm-4 m-b-15">
                                                    <label class="control-label">House no./Building no./Area<span class="Validation_error"> *</span>
                                                    </label>
                                                    <input type="text" name="house_no" id="product_address" minlength="10" class="form-control auth-form-input" placeholder="House no./Building no./Area" value="<?php echo empty($product->product_address) ? html_escape($user->house_no) : html_escape($product->product_address); ?>" required>
                                                    <p class="Validation_error" id="house_no_p1"></p>
                                                </div>
                                                <div class="col-12 col-sm-4 m-b-15">
                                                    <label class="control-label">Landmark</label>
                                                    <input type="text" name="landmark" id="product_landmark" class="form-control auth-form-input" value="<?php echo empty($product->landmark) ? html_escape($user->landmark) : html_escape($product->landmark); ?>" placeholder="Landmark">
                                                    <p class="Validation_error" id="landmark_p1"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if (!empty($product->product_pincode_1)) : ?>
                                            <div id="TextBoxDiv2">
                                                <div class="row">
                                                    <div class="col-12 col-sm-4 m-b-15"><label class="control-label">Pincode<span class="Validation_error"> *</span></label><input type="number" name="pincode2" value="<?php echo html_escape($product->product_pincode_1); ?>" id="pincode2" class="form-control auth-form-input" placeholder="Pincode" required maxlength="6" minlength="6" required onchange="get_location($('#pincode2').val(),2)">
                                                        <p class="Validation_error" id="pincode_p2"></p><span class="Validation_error error" id="pincode_span2"></span>
                                                    </div>
                                                    <div class="col-12 col-sm-4 m-b-15"><label class="control-label">State<span class="Validation_error"> *</span></label><input type="text" name="supplier_state2" id="product_state1" value="<?php echo html_escape($product->product_state_1); ?>" class="form-control auth-form-input" placeholder="State" required readonly>
                                                        <p class="Validation_error" id="state_p2"></p>
                                                    </div>
                                                    <div class="col-12 col-sm-4 m-b-15"> <label class="control-label">City<span class="Validation_error"> *</span></label> <input type="text" name="supplier_city1" id="product_city1" value="<?php echo html_escape($product->product_city_1); ?>" class="form-control auth-form-input" placeholder="City" required readonly>
                                                        <p class="Validation_error" id="city_p2"></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-4 m-b-15"> <label class="control-label">Area<span class="Validation_error"> *</span></label> <input type="text" name="area1" id="area1" value="<?php echo html_escape($product->product_area_1); ?>" class="form-control auth-form-input" placeholder="Area" required>
                                                        <p class="Validation_error" id="area_p1"></p>
                                                    </div>
                                                    <div class="col-12 col-sm-4 m-b-15"> <label class="control-label">House no./Building no./Area<span class="Validation_error"> *</span> </label> <input type="text" name="house_no1" id="house_no1" value="<?php echo html_escape($product->product_address_1); ?>" class="form-control auth-form-input" placeholder="House no./Building no./Area" required>
                                                        <p class="Validation_error" id="house_no_p1"></p>
                                                    </div>
                                                    <div class="col-12 col-sm-4 m-b-15"> <label class="control-label">Landmark</label> <input type="text" name="landmark1" id="landmark1" value="<?php echo html_escape($product->landmark_1); ?>" class="form-control auth-form-input" placeholder="Landmark">
                                                        <p class="Validation_error" id="landmark_p1"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <button class="btn btn-success add-more" id="add_button" onclick="Addmorelocation()" type="button"><i class="glyphicon glyphicon-plus"></i> Add More Location</button>
                                    <button class="btn btn-danger add-more" id="removeButton" onclick="remove()" type="button"><i class="glyphicon glyphicon-plus"></i> Remove Location</button><br>
                                    <!-- <div class="form-group"> -->

                                    <!-- </div> -->
                                </div>
                            </div>

                        <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- <div class="col-sm-12 text-left m-t-15 m-b-15">
        <div class="form-group">
            <div class="custom-control custom-checkbox custom-control-validate-input">
                <?php if ($product->is_draft == 1) : ?>
                    <input type="checkbox" class="custom-control-input" name="terms_conditions" id="terms_conditions" value="1" required>
                <?php else : ?>
                    <input type="checkbox" class="custom-control-input" name="terms_conditions" id="terms_conditions" value="1" checked>
                <?php endif; ?>
                <label for="terms_conditions" class="custom-control-label"><?php echo trans("terms_conditions_exp"); ?>&nbsp;
                    <?php $page_terms = get_page_by_default_name("terms_conditions", $this->selected_lang->id);
                    if (!empty($page_terms)) : ?>
                        <a href="<?= generate_url($page_terms->page_default_name); ?>" class="link-terms" target="_blank"><strong><?= html_escape($page_terms->title); ?></strong></a>
                    <?php endif; ?>
                </label>
            </div>
        </div>
    </div> -->
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="margin-top: 18%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Are You Sure ? </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo trans("product_submit_confirmation"); ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-lg btn-custom btn-form-product-details " data-dismiss="modal">Close</button>
                        <button type="submit" name="submit" value="save_as_draft" class="btn btn-lg btn-secondary btn-form-product-details m-r-10 pull-right">Preview</button>
                        <button type="submit" name="submit" value="submit" class="btn btn-lg btn-success btn-form-product-details pull-right"><?php echo trans("submit"); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group m-t-15">
                <a href="<?php echo generate_dash_url("edit_product") . "/" . $product->id; ?>" class="btn btn-lg btn-dark pull-left"><?php echo trans("back"); ?></a>
                <?php if ($product->is_draft == 1) : ?>
                    <button type="button" id="button_to_submit" class="btn btn-lg btn-success btn-form-product-details pull-right"><?php echo trans("submit"); ?></button>
                    <button type="button" id="button_to_open_modal" class="btn btn-primary hideMe" data-toggle="modal" data-target="#confirmModal"><?php echo trans("save_as_draft"); ?></button>
                    <button type="submit" id="button_with_submit" name="submit" value="save_as_draft" class="btn btn-lg btn-secondary btn-form-product-details m-r-10 pull-right"><?php echo trans("save_as_draft"); ?></button>
                <?php else : ?>
                    <?php if ($user->id == $this->auth_user->id && $product->status == 1) : ?>
                        <a class="btn btn-lg btn-info btn-form-product-details pull-right" style="margin-left:10px;" href="<?= generate_dash_url("products"); ?>"><?php echo trans("close"); ?></a>
                    <?php endif; ?>
                    <button type="submit" name="submit" value="save_changes" class="btn btn-lg btn-success btn-form-product-details pull-right"><?php echo ($user->id == $this->auth_user->id && $product->status == 1) ? trans("resave_changes") : trans("save_changes"); ?></button>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>

    <?php $this->load->view("dashboard/product/variation/_form_variations"); ?>

    <!-- barter popup modal -->
    <div class="modal fade" id="knowmore" role="dialog">
        <div class="modal-dialog modal-dialog-centered1 modal-medium" role="document">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="auth_box" id="know_more_box">
                    <div class="row">
                        <div class="col-md-5" style=" width: 100%;  margin: auto auto;  text-align: center;">
                            <img id="ABOUT_LOGO" src="<?php echo base_url(); ?>assets/img/barter system new 1.png" class="img-responsive image1">
                        </div>
                    </div>
                    <div>
                        <h4 class="modal-title" id="barting">Jadh se Judho – Barter Karo</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- <div class="modal-body"> -->
                    <div class="cont" style="text-align: center;">

                        <p style="text-align: center;">
                            Let's get back to our roots, and trade the way it was done earlier. We don’t need cash, we just need someone who makes/provides something we want !. </p>
                    </div>
                    <div class="cont">
                        <p style="text-align: center;">
                            Choose ‘Yes’ if you would be keen to explore this option, and choose ‘No’ if you’re not so willing to try this out right now. You always have the option to change your decision later.</p>
                    </div>
                    <div class="cont">
                        <p style="text-align: center;">We are trying to do something unique and different, something that is not the usual practice in e-commerce. We are giving you an option to exchange products with each other, without exchanging any money.
                        </p>
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <img id="logax" src="<?php echo base_url(); ?>assets/img/Saly-23.png" class="img-responsive image1">
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                    <!-- <div class="modal-footer"> -->
                    <!-- <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button> -->
                    <!-- </div> -->
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="view_policy" role="dialog">
        <div class="modal-dialog modal-dialog-centered1 modal-medium" role="document">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="auth_box" id="know_more_box">

                    <div>
                        <h4 class="modal-title" id="barting">Returns & Refund Policy</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body"><?php echo get_content("return_refund_policy"); ?></div>
                    <!-- <div class="modal-footer"> -->
                    <!-- <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button> -->
                    <!-- </div> -->
                </div>
            </div>

        </div>
    </div>
    <script type="text/javascript">
        function ShowHideDiv() {
            var add_meet_stock = document.getElementById("add_meet_stock");
            var add_meet_order = document.getElementById("add_meet_order");
            var stock_field = document.getElementById("stocks");
            stock_field.style.display = add_meet_stock.checked ? "block" : "none";
            var lead_field = document.getElementById("leads");
            var dispatch = document.getElementById("dispatch");
            lead_field.style.display = add_meet_order.checked ? "block" : "none";
            dispatch.style.display = add_meet_stock.checked ? "block" : "none";
            if (dispatch.style.display == "block") {
                $('#shipping_time').prop('required', true);
            }
            if (dispatch.style.display == "none") {
                $('#shipping_time').prop('required', false);
            }
            document.getElementById("capacity").style.display = add_meet_order.checked ? "block" : "none";
            if (add_meet_order.checked) {
                $("#order_capacity").prop('required', true);
            } else {
                $("#order_capacity").prop('required', false);
            }
        }

        function Checkproduct_wash_instruction(val) {
            var element = document.getElementById('other_product_wash_instruction');
            if (val == 'Others') {
                element.style.display = 'block';
                $('#other_product_wash_instruction').prop('required', true);
            } else {
                element.style.display = 'none';
                $('#other_product_wash_instruction').prop('required', false);
            }
        }

        function Checkblouse_details(val) {
            var element = document.getElementById('other_blouse_details');
            if (val == 'Others') {
                element.style.display = 'block';
                $('#other_blouse_details').prop('required', true);
            } else {
                element.style.display = 'none';
                $('#other_blouse_details').prop('required', false);
            }
        }

        function Checkminimum_Prior_notice(val) {
            var element = document.getElementById('other_minimum_Prior_notice');
            if (val == 'Others') {
                element.style.display = 'block';
                $('#other_minimum_Prior_notice').prop('required', true);
            } else {
                element.style.display = 'none';
                $('#other_minimum_Prior_notice').prop('required', false);
            }
        }

        function Checkpet_age(val) {
            var element = document.getElementById('other_pet_age');
            if (val == 'Others') {
                element.style.display = 'block';
                $('#other_pet_age').prop('required', true);
            } else {
                element.style.display = 'none';
                $('#other_pet_age').prop('required', false);
            }
        }

        function Checkstorage_instruction(val) {
            var element = document.getElementById('other_storage_instruction');
            if (val == 'Others') {
                element.style.display = 'block';
                $('#other_storage_instruction').prop('required', true);
            } else {
                element.style.display = 'none';
                $('#other_storage_instruction').prop('required', false);
            }
        }

        function Checkdelivery_area(val) {
            var element = document.getElementById('other_delivery_area');
            if (val == 'Others') {
                element.style.display = 'block';
                $('#other_delivery_area').prop('required', true);
            } else {
                element.style.display = 'none';
                $('#other_delivery_area').prop('required', false);
            }
        }
    </script>
    <script>
        // $("input[name=add_meet]").click(function() {
        //     if (this.value == "Made to order") {

        //     } else if (this.value == "Made to stock") {

        //     }
        // });
    </script>
    <script>
        $('.demo').fSelect();
    </script>
    <script>
        const player = new Plyr('#player');
        $(document).ajaxStop(function() {
            const player = new Plyr('#player');
        });
        const audio_player = new Plyr('#audio_player');
        $(document).ajaxStop(function() {
            const player = new Plyr('#audio_player');
        });
        $(window).on("load", function() {
            $(".li-dm-media-preview").css("visibility", "visible");
        });
    </script>
             <script>
                            function sku_code_validation(){
                                $("#input_sku_option").keyup(function(){
var z=$(this).val();
var x=<?php echo json_encode($sku);?>;
if(x.some(e => e.sku_code == z || e.sku==z)){
    document.getElementById("input_sku_check").style.display="block";
    document.getElementById("btn_add_variation_option").disabled=true;
    //   document.getElementById("disable_sku").disabled=true;
    document.getElementById("btn_save_variation_option").disabled=true;

     }
     else{
        document.getElementById("input_sku_check").style.display="none";
        document.getElementById("btn_add_variation_option").disabled=false;
        document.getElementById("btn_save_variation_option").disabled=false;



     }

    })

}
function sku_code_edit_validate(){
    var m=document.getElementById("input_sku").value;
    $("#input_sku").change(function(){
var z=$(this).val();

var x=<?php echo json_encode($sku);?>;
if(x.some(e => e.sku_code == z)){

    document.getElementById("sku_check").style.display="block";
    document.getElementById("btn_edit_variation_option").disabled=true;
     
    }
     else{
        document.getElementById("sku_check").style.display="none";
        document.getElementById("btn_edit_variation_option").disabled=false;

     }
    
    })
    
}

    </script>
    <script>
        $.fn.datepicker.dates['en'] = {
            days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
            daysMin: ["<?= substr(trans("monday"), 0, 3); ?>",
                "<?= substr(trans("tuesday"), 0, 3); ?>",
                "<?= substr(trans("wednesday"), 0, 3); ?>",
                "<?= substr(trans("thursday"), 0, 3); ?>",
                "<?= substr(trans("friday"), 0, 3); ?>",
                "<?= substr(trans("saturday"), 0, 3); ?>",
                "<?= substr(trans("sunday"), 0, 3); ?>"
            ],
            months: ['<?php echo trans("january"); ?>',
                "<?= trans("february"); ?>",
                "<?= trans("march"); ?>",
                "<?= trans("april"); ?>",
                "<?= trans("may"); ?>",
                "<?= trans("june"); ?>",
                "<?= trans("july"); ?>",
                "<?= trans("august"); ?>",
                "<?= trans("september"); ?>",
                "<?= trans("october"); ?>",
                "<?= trans("november"); ?>",
                "<?= trans("december"); ?>"
            ],
            monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            today: "Today",
            clear: "Clear",
            format: "dd/mm/yyyy",
            titleFormat: "MM yyyy",
            weekStart: 0
        };
        $('.datepicker').datepicker({
            language: 'en'
        });

        //validate checkbox
        $(document).on("click", ".btn-form-product-details ", function() {
            $('.checkbox-options-container').each(function() {
                var field_id = $(this).attr('data-custom-field-id');
                var element = "#checkbox_options_container_" + field_id + " .required-checkbox";
                if (!$(element).is(':checked')) {
                    $(element).prop('required', true);
                } else {
                    $(element).prop('required', false);
                }
            });
        });

        $(document).ready(function() {
            var $radios = $('input:radio[name=return_or_exchange]');
            if ($radios.is(':checked') === false) {
                $radios.filter('[value="<?= $product->available_for_return_or_exchange; ?>"]').prop('checked', true);
            }
        });

        $(document).ready(function() {
            var $radios = $('input:radio[name=product_barter]');
            if ($radios.is(':checked') === false) {
                $radios.filter('[value="<?= $product->available_for_barter; ?>"]').prop('checked', true);
            }
        });
    </script>
    <script>
        var counter = <?php echo !empty($product->product_pincode_1) ? 2 : 1; ?>;

        function Addmorelocation() {
            var newDiv = $('<div class="row"><div class="col-12 col-sm-4 m-b-15"><label class="control-label">Pincode<span class="Validation_error"> *</span></label><input type="number" name="pincode2" id="pincode2" class="form-control auth-form-input" placeholder="Pincode" required maxlength="6" minlength="6" required onchange="get_location($(' + "'#pincode2'" + ').val(),2)"><p class="Validation_error" id="pincode_p2"></p><span class="Validation_error error" id="pincode_span2"></span></div><div class="col-12 col-sm-4 m-b-15"><label class="control-label">State<span class="Validation_error"> *</span></label><input type="text" name="supplier_state2" id="product_state1" class="form-control auth-form-input" placeholder="State" required readonly><p class="Validation_error" id="state_p2"></p></div><div class="col-12 col-sm-4 m-b-15">                       <label class="control-label">City<span class="Validation_error"> *</span></label>                                        <input type="text" name="supplier_city1" id="product_city1" class="form-control auth-form-input" placeholder="City" required readonly>                       <p class="Validation_error" id="city_p2"></p>                                    </div>                                </div>                                <div class="row">                                   <div class="col-12 col-sm-4 m-b-15">                                        <label class="control-label">Area<span class="Validation_error"> *</span></label>                                     <input type="text" name="area1" id="area1" class="form-control auth-form-input" placeholder="Area" required>                                        <p class="Validation_error" id="area_p1"></p>                                    </div>                                    <div class="col-12 col-sm-4 m-b-15">                                        <label class="control-label">House no./Building no./Area<span class="Validation_error"> *</span>                                       </label>                                        <input type="text" name="house_no1" id="house_no1" class="form-control auth-form-input" placeholder="House no./Building no./Area" required>                                        <p class="Validation_error" id="house_no_p1"></p>                                    </div>                                    <div class="col-12 col-sm-4 m-b-15">                                        <label class="control-label">Landmark</label>                                        <input type="text" name="landmark1" id="landmark1" class="form-control auth-form-input" placeholder="Landmark">                                        <p class="Validation_error" id="landmark_p1"></p>                                  </div>                         </div>');
            //$('.add_more_location').append(newDiv);

            counter++;
            if (counter <= 2) {
                var newTextBoxDiv = $(document.createElement('div'))
                    .attr("id", 'TextBoxDiv' + counter);

                newTextBoxDiv.after().html(newDiv);

                newTextBoxDiv.appendTo("#TextBoxesGroup");
            } else {
                alert("Can not add more locations");
            }
        }

        function remove() {
            console.log("click");
            if (counter == 1) {
                alert("No more Locations to remove");
                return false;
            }



            $("#TextBoxDiv" + counter).remove();
            counter--;

        }
    </script>

    <script type="text/javascript">
        $(function() {
            var date = new Date();
            var currentMonth = date.getMonth();
            var currentDate = date.getDate();
            var currentYear = date.getFullYear();
            $('#datepicker').datepicker({
                maxDate: new Date(currentYear, currentMonth, currentDate),
                dateFormat: 'dd-mm-yy'
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            var date = new Date();
            var currentMonth = date.getMonth();
            var currentDate = date.getDate();
            var currentYear = date.getFullYear();
            $('#datepicker_exp').datepicker({
                minDate: new Date(currentYear, currentMonth, currentDate),
                dateFormat: 'dd-mm-yy'
            });
        });
    </script>
    </script>
    <script>
        function get_location(pincode, number = 0) {
            if (number > 0) {
                document.getElementById('product_state1').value = "";
                document.getElementById('product_city1').value = "";
                document.getElementById('area1').value = "";
                document.getElementById('house_no1').value = "";
                document.getElementById('landmark1').value = "";
            } else {
                document.getElementById('product_state').value = "";
                document.getElementById('product_city').value = "";
                document.getElementById('product_area').value = "";
                document.getElementById('product_address').value = "";
                document.getElementById('product_landmark').value = "";
            }
            var url = "https://api.postalpincode.in/pincode/" + pincode;
            $.ajax({
                url: url,
                cache: false,
                success: function(html) {
                    console.log(html)
                    if (html[0].PostOffice == null) {
                        // $('#pincode_span')[0].innerHTML = "Please enter a valid pincode.";
                    } else {
                        // $('#pincode_span')[0].innerHTML = "";
                        if (number > 0) {
                            $('#product_state1').val(html[0].PostOffice[0].State)
                            $('#product_city1').val(html[0].PostOffice[0].District)
                            $('#area1').val(html[0].PostOffice[0].Name)
                        } else {
                            $('#product_state').val(html[0].PostOffice[0].State)
                            $('#product_city').val(html[0].PostOffice[0].District)
                            $('#product_area').val(html[0].PostOffice[0].Name)
                        }

                    }
                }
            })
        }
    </script>

    <script>
        function t_c1() {
            $('#small-text').hide();
            $('#return_policy').removeAttr('readonly');
        }
    </script>
    <script>
        $('#return_policy').click(function() {
            var isReadOnly = $(this).attr("readonly") === undefined ? false : true;

            if (isReadOnly) {
                $(this).prop('checked', false);
                $("#small-text").show();
            }

            // other code never executed if readonly is true.
        });
    </script>

    <script>
        $("input[name=is_allergens]").change(function() {
            if (this.value == "Y") {
                $("#allergance").show();
                document.getElementById('#allergance').setAttribute("required", "");
            } else if (this.value == "N") {
                $("#allergance").hide();
                document.getElementById('#allergance').removeAttribute("required");
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            ShowHideDiv();
        });
    </script>
  

    <script>

        function get_automated_SKU_option(button) {
            // console.log("<?php echo $product->sku; ?>");
            // var valid = true;
            // $("select[name='" + element[0].name + "'").each(function() {
            //     if ($(this).val() == "")
            //         valid = false;
            // })
            // if (!valid) {
            //     $("#input_sku_p").show();
            //     button[0].disabled = false;
            //     return false;
            // } else {
            //     $("#input_sku_p").hide();
            //     $("#input_sku").val(generateUniqueProductCode(element, button));
        }
    </script>

    <script type="text/javascript">
        function for_other(val) {
            if (val == 'Others') {
                $("#other").show();
                $('#other_special_delivery_input').prop('required', true);
                $("#temp").hide();
                $('#temperature_input').prop('required', false);
            } else if (val == 'Temperature controlled delivery') {
                $("#other").hide();
                $('#other_special_delivery_input').prop('required', false);
                $("#temp").show();
                $('#temperature_input').prop('required', true);
            } else {
                $("#other").hide();
                $("#temp").hide();
                $('#temperature_input').prop('required', false);
                $('#other_special_delivery_input').prop('required', false);
            }
        }
    </script>

    <script type="text/javascript">
        function for_other(val) {
            if (val == 'Others') {
                $("#other").show();
                $('#other_special_delivery_input').prop('required', true);
                $("#temp").hide();
                $('#temperature_input').prop('required', false);
            } else if (val == 'Temperature controlled delivery') {
                $("#other").hide();
                $('#other_special_delivery_input').prop('required', false);
                $("#temp").show();
                $('#temperature_input').prop('required', true);
            } else {
                $("#other").hide();
                $("#temp").hide();
                $('#temperature_input').prop('required', false);
                $('#other_special_delivery_input').prop('required', false);
            }
        }
    </script>

    <script>
        //expiring date validation
        $("input[name=add_meet]").click(function() {
            var yes_expiry = document.getElementById("yes_expiry");
            var expired = document.getElementById("expiry_date");
            var shelf_life = document.getElementById("shelf_life");
            $("input[name=expire]").each(function() {
                if ($(this)[0].checked) {
                    if ($(this).val() == "Y") {
                        $("input[name=add_meet]").each(function() {
                            if ($(this)[0].checked) {
                                // console.log($(this).val());
                                expired.style.display = ($(this).val() == "Made to stock") ? "block" : "none";
                                manufacturing_date.style.display = ($(this).val() == "Made to stock") ? "block" : "none";
                                shelf_life.style.display = ($(this).val() == "Made to order") ? "block" : "none";
                                if ($(this).val() == "Made to order") {
                                    $("input[name=shelf_life]")[0].required = true;
                                    $("input[name=shipping_time]")[0].required = true;
                                    $("input[name=expiry_date]")[0].required = false;
                                    $("input[name=expiry_date]").val("");
                                    $("input[name=manufacturing_date]")[0].required = false;
                                    $("input[name=manufacturing_date]").val("");
                                }
                                if ($(this).val() == "Made to stock") {
                                    $("input[name=shelf_life]")[0].required = false;
                                    $("input[name=shelf_life]").val("");
                                    $("input[name=shipping_time]")[0].required = false;
                                    $("input[name=expiry_date]")[0].required = true;
                                    $("input[name=manufacturing_date]")[0].required = true;
                                }
                            }




                        })
                    } else if ($(this).val() == "N") {
                        expired.style.display = "none";
                        manufacturing_date.style.display = "none";
                        shelf_life.style.display = "none";

                        $("input[name=shelf_life]")[0].required = false;
                        $("input[name=manufacturing_date]")[0].required = false;
                        $("input[name=expiry_date]")[0].required = false;
                        $("input[name=expiry_date]").val("");
                        $("input[name=manufacturing_date]").val("");
                        $("input[name=shelf_life]").val("");
                    }
                }
            })
        })

        $("input[name=expire]").click(function() {
            var yes_expiry = document.getElementById("yes_expiry");
            var expired = document.getElementById("expiry_date");
            var shelf_life = document.getElementById("shelf_life");
            $("input[name=expire]").each(function() {
                if ($(this)[0].checked) {
                    if ($(this).val() == "Y") {
                        $("input[name=add_meet]").each(function() {
                            if ($(this)[0].checked) {
                                // console.log($(this).val());
                                expired.style.display = ($(this).val() == "Made to stock") ? "block" : "none";
                                manufacturing_date.style.display = ($(this).val() == "Made to stock") ? "block" : "none";
                                shelf_life.style.display = ($(this).val() == "Made to order") ? "block" : "none";
                                if ($(this).val() == "Made to order") {
                                    $("input[name=shelf_life]")[0].required = true;
                                    $("input[name=expiry_date]")[0].required = false;
                                    $("input[name=expiry_date]").val("");
                                    $("input[name=manufacturing_date]")[0].required = false;
                                    $("input[name=manufacturing_date]").val("");
                                }
                                if ($(this).val() == "Made to stock") {
                                    $("input[name=shelf_life]")[0].required = false;
                                    $("input[name=shelf_life]").val("");
                                    $("input[name=expiry_date]")[0].required = true;
                                    $("input[name=manufacturing_date]")[0].required = true;
                                }
                            }
                        })
                    } else if ($(this).val() == "N") {
                        expired.style.display = "none";
                        manufacturing_date.style.display = "none";
                        shelf_life.style.display = "none";

                        $("input[name=shelf_life]")[0].required = false;
                        $("input[name=manufacturing_date]")[0].required = false;
                        $("input[name=expiry_date]")[0].required = false;
                        $("input[name=expiry_date]").val("");
                        $("input[name=manufacturing_date]").val("");
                        $("input[name=shelf_life]").val("");
                    }
                }
            })
        });
        $(document).ready(function() {
            var yes_expiry = document.getElementById("yes_expiry");
            var expired = document.getElementById("expiry_date");
            var shelf_life = document.getElementById("shelf_life");
            $("input[name=expire]").each(function() {
                if ($(this)[0].checked) {
                    if ($(this).val() == "Y") {
                        $("input[name=add_meet]").each(function() {
                            if ($(this)[0].checked) {
                                // console.log($(this).val());
                                expired.style.display = ($(this).val() == "Made to stock") ? "block" : "none";
                                manufacturing_date.style.display = ($(this).val() == "Made to stock") ? "block" : "none";
                                shelf_life.style.display = ($(this).val() == "Made to order") ? "block" : "none";
                                if ($(this).val() == "Made to order") {
                                    $("input[name=shelf_life]")[0].required = true;
                                    $("input[name=expiry_date]")[0].required = false;
                                    $("input[name=manufacturing_date]")[0].required = false;
                                }
                                if ($(this).val() == "Made to stock") {
                                    $("input[name=shelf_life]")[0].required = false;
                                    $("input[name=expiry_date]")[0].required = true;
                                    $("input[name=manufacturing_date]")[0].required = true;
                                }
                            }
                        })
                    } else if ($(this).val() == "N") {
                        expired.style.display = "none";
                        manufacturing_date.style.display = "none";
                        shelf_life.style.display = "none";
                        $("input[name=shelf_life]")[0].required = false;
                        $("input[name=manufacturing_date]")[0].required = false;
                        $("input[name=expiry_date]")[0].required = false;
                    }
                }
            })
        });
    </script>
    <script>
        $(document).on("change", "input[name='add_meet']", function() {
            $("input[name='add_meet']").each(function() {
                if ($(this).prop("checked")) {
                    if ($(this).val() == "Made to order") {
                        $(".stock_made_to_order").hide();
                    } else if ($(this).val() == "Made to stock") {
                        $(".stock_made_to_order").show();
                    }
                }
            })
            console.log("test");
        })
    </script>
    <script>

      
        $("#button_to_submit").click(function() {
            var required = $('input,textarea,select').filter('[required]:visible');
            console.log(required)
            var allRequired = true;
            required.each(function() {
                if ($(this).val() == '') {
                    allRequired = false;
                }
            });
            if (!allRequired) {
                $("#button_with_submit").trigger("click");
            } else {
                $("#button_to_open_modal").trigger("click");
            }
        });
    </script>