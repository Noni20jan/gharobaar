<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="addVariationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-custom modal-variation" role="document">
        <div class="modal-content">
            <form id="form_add_product_variation" novalidate enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo trans("add_variation"); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 tab-variation">
                            <div class="form-group m-b-10">
                                <label class="control-label">Type of Variation<?php //echo trans('label'); 
                                                                                ?></label>
                                <?php foreach ($this->languages as $language) : ?>
                                    <?php if ($language->id == $this->selected_lang->id) : ?>
                                        <select name="label_lang_<?php echo $language->id; ?>" class="form-control custom-select" id="input_variation_label" onchange="change_label('input_variation_label','variation_type_id')" required>
                                            <option selected disabled>Select Variations</option>
                                            <?php if ($parent_categories_array[0]->id == 2) : ?>
                                                <option value="portion size">Portion Size</option>
                                            <?php else : ?>
                                                <option value="size">Size</option>
                                            <?php endif; ?>
                                            <option value="color"><?php echo trans('color'); ?></option>
                                            <option value="weight">Weight</option>
                                            <option value="packaging type">Packaging Type</option>
                                            <option value="set of pieces">Set of pieces</option>
                                            <option value="create your own">Create your own</option>

                                        </select>
                                        <!-- <input type="text" id="input_variation_label" class="form-control form-input input-variation-label" name="label_lang_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255" required> -->
                                    <?php else : ?>
                                        <select name="label_lang_<?php echo $language->id; ?>" class="form-control custom-select" required>
                                            <option selected disabled>Select Variations</option>
                                            <option value="color"><?php echo trans('color'); ?></option>
                                            <option value="weight">Weight</option>
                                            <option value="packaging type">Packaging Type</option>
                                            <option value="set of pieces">Set of pieces</option>
                                            <option value="create your own">Create your own</option>
                                        </select>
                                        <!-- <input type="text" class="form-control form-input input-variation-label" name="label_lang_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                            <div class="form-group" style="display:none;" id="create_your_own">
                                <label class="control-label">Name of Variation<?php //echo trans('label'); 
                                                                                ?></label>
                                <?php foreach ($this->languages as $language) : ?>
                                    <?php if ($language->id == $this->selected_lang->id) : ?>

                                        <input type="text" id="input_variation_label" class="form-control form-input input-variation-label" name="custom-name" placeholder="Input name of variation" maxlength="255" required>
                                    <?php else : ?>

                                        <input type="text" class="form-control form-input input-variation-label" name="custom-name" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255">
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                            <div class="form-group" style="display:none;" id="create_your_own_type">
                                <label class="control-label"><?php echo trans('variation_type'); ?></label>
                                <select name="variation_type" id="variation_type_id" class="form-control custom-select" onchange="show_hide_form_option_images(this.value);" required>
                                    <option selected disabled>Select Variation</option>
                                    <option value="radio_button"><?php echo trans('radio_button'); ?></option>
                                    <option value="dropdown"><?php echo trans('dropdown'); ?></option>
                                    <option value="checkbox"><?php echo trans('checkbox'); ?></option>
                                    <option value="text" checked><?php echo trans('text'); ?></option>
                                    <option value="number"><?php echo trans('number'); ?></option>
                                </select>
                            </div>
                            <!-- <div class="form-group display-none form-group-parent-variation">
                                <label class="control-label"><?php echo trans('parent_variation'); ?></label>
                                <select name="parent_id" class="form-control custom-select">
                                    <option value=""><?php echo trans("none"); ?></option>
                                    <?php if (!empty($product_variations)) :
                                        foreach ($product_variations as $variation) :
                                            if ($variation->variation_type == "dropdown") : ?>
                                                <option value="<?php echo $variation->id; ?>"><?php echo $variation->id . " - " . html_escape(get_variation_label($variation->label_names, $this->selected_lang->id)) . ' - ' . trans($variation->variation_type); ?></option>
                                    <?php endif;
                                        endforeach;
                                    endif; ?>
                                </select>
                            </div> -->
                            <div class="form-group m-0 form-group-display-type hideMe">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="control-label"><?php echo trans('option_display_type'); ?></label>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-custom-option">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="option_display_type" value="text" id="option_display_type_1" class="custom-control-input" checked>
                                            <label for="option_display_type_1" class="custom-control-label"><?php echo trans('text'); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-custom-option">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="option_display_type" value="image" id="option_display_type_2" class="custom-control-input">
                                            <label for="option_display_type_2" class="custom-control-label"><?php echo trans('image'); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-custom-option hideColor">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="option_display_type" value="color" id="option_display_type_3" class="custom-control-input">
                                            <label for="option_display_type_3" class="custom-control-label"><?php echo trans('color'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-show-option-images hideMe">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="control-label"><?php echo trans('show_option_images_on_slider'); ?></label>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-custom-option">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="show_images_on_slider" value="1" id="show_images_on_slider_when_selected_1" class="custom-control-input">
                                            <label for="show_images_on_slider_when_selected_1" class="custom-control-label"><?php echo trans('yes'); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-custom-option">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="show_images_on_slider" value="0" id="show_images_on_slider_when_selected_2" class="custom-control-input" checked>
                                            <label for="show_images_on_slider_when_selected_2" class="custom-control-label"><?php echo trans('no'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-group-show-option-images hideMe">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="control-label"><?php echo trans('use_different_price_for_options'); ?></label>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-custom-option">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="use_different_price" value="1" id="use_different_price_1" class="custom-control-input">
                                            <label for="use_different_price_1" class="custom-control-label"><?php echo trans('yes'); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-custom-option">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="use_different_price" value="0" id="use_different_price_2" class="custom-control-input" checked>
                                            <label for="use_different_price_2" class="custom-control-label"><?php echo trans('no'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="form-group m-0 form-is-visible hideMe">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="control-label"><?php echo trans('visible'); ?></label>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-custom-option">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="is_visible" value="1" id="edit_visible_1" class="custom-control-input" checked>
                                            <label for="edit_visible_1" class="custom-control-label"><?php echo trans('yes'); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-custom-option">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="is_visible" value="0" id="edit_visible_2" class="custom-control-input">
                                            <label for="edit_visible_2" class="custom-control-label"><?php echo trans('no'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="form-group m-0 show-size-chart hideMe">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="barting tooltip-product">Size Chart &nbsp;<i class="fa fa-info-circle"></i><span class="tooltiptext">Please upload a size chart of your product, clearly explaining all possible dimensions and sizes. The more accurate and detailed it is, the lower would be the probability of receiving a return/exchange request</span></label>
                                    </div>
                                    <!-- <div class="col-md-6 col-sm-12 col-custom-option">
                                        <div class="custom-control custom-radio">
                                            <input type="file" name="size-chart" id="fileToUpload">
                                            <img id="blah" src="#" alt="your image" class="hideMe" height="400" width="400" />
                                        </div>
                                    </div> -->
                                    <div class='col-sm-6'>
                                        <div class="row">
                                            <div class="col-sm-16">
                                                <div class="dm-uploader-container" style="padding: 20px;">
                                                    <div id="drag-and-drop-zone" class="dm-uploader text-center">
                                                        <div id="hideShow-sizechart">
                                                            <p class="dm-upload-icon">
                                                                <i class="icon-upload"></i>
                                                            </p>
                                                            <p class="dm-upload-text"><?php echo trans("drag_drop_images_here"); ?>&nbsp;<span style="text-decoration: underline"><?php echo trans('browse_files'); ?></span></p>
                                                            <a class='btn btn-md dm-btn-select-files'>
                                                                <input type="file" id="sizeChartInput" name="file" size="40" required accept="image/jpeg,image/jpg">
                                                            </a>
                                                        </div>
                                                        <ul class="dm-uploaded-files" id="files-image">
                                                            <?php if (!empty($modesy_images)) :
                                                                foreach ($modesy_images as $modesy_image) : ?>
                                                                    <li class="media" id="uploaderFile<?php echo $modesy_image->file_id; ?>">
                                                                        <img src="<?php echo base_url(); ?>uploads/size_charts/<?php echo $modesy_image->img_small; ?>" alt="">
                                                                        <a href="javascript:void(0)" class="btn-img-delete btn-delete-product-img-session-sizeChart" data-file-id="<?php echo $modesy_image->file_id; ?>">
                                                                            <i class="icon-close"></i>
                                                                        </a>
                                                                    </li>
                                                            <?php endforeach;
                                                            endif; ?>
                                                        </ul>
                                                        <div class="error-message-img-upload"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="form-variation-add-button" class="btn btn-md btn-success btn-variation float-right">
                        <div id="form-variation-add-text"><?php echo trans("add_variation"); ?></div>
                        <div id="sp-options-add" class="spinner spinner-btn-add-variation">
                            <div class="bounce1"></div>
                            <div class="bounce2"></div>
                            <div class="bounce3"></div>
                        </div>

                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editVariationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-custom modal-variation" role="document">
        <div class="modal-content">
            <form id="form_edit_product_variation" novalidate>
                <div id="response_product_variation_edit"></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addVariationOptionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-custom modal-variation" role="document">
        <div class="modal-content">
            <div id="response_product_add_variation_option"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewVariationOptionsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-custom modal-variation modal-variation-options" role="document">
        <div class="modal-content">
            <div id="response_product_variation_options_edit"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="editVariationOptionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-custom modal-variation" role="document">
        <div class="modal-content">
            <div id="response_product_edit_variation_option"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="variationModalSelect" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-custom modal-variation" role="document">
        <div class="modal-content">
            <form id="form_select_product_variation" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo trans("created_variations"); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if (empty($user_variations)) : ?>
                        <p class="text-center m-t-20"><?php echo trans("msg_no_created_variations"); ?></p>
                    <?php else : ?>
                        <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('select_variation'); ?></label>
                            <select name="variation_id" class="form-control custom-select" required>
                                <?php foreach ($user_variations as $user_variation) :
                                    if ($user_variation->insert_type == "new") : ?>
                                        <option value="<?php echo $user_variation->id; ?>"><?php echo $user_variation->id . " - " . html_escape(get_variation_label($user_variation->label_names, $this->selected_lang->id)) . ' - ' . trans($user_variation->variation_type); ?></option>
                                <?php endif;
                                endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <?php if (!empty($user_variations)) : ?>
                        <button type="submit" class="btn btn-md btn-success btn-variation"><?php echo trans("select"); ?></button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view("dashboard/product/variation/_js_variations"); ?>
<script>
    function change_label(a, b) {
        $(".form-is-visible").show();
        if (document.getElementById(a).value == 'size' || document.getElementById(a).value == 'portion size') {
            document.getElementById(b).value = 'dropdown';
            show_hide_form_option_images("dropdown");
            if (<?php echo $parent_categories_array[0]->id; ?> == '1' && (<?php echo $parent_categories_array[1]->id; ?> == '9' || <?php echo $parent_categories_array[1]->id; ?> == '10' || <?php echo $parent_categories_array[1]->id; ?> == '14')) {
                $(".show-size-chart").show();
            }
            $("#create_your_own_type").hide();
            $("#create_your_own").hide();
            $(".hideColor").hide();
        } else if (document.getElementById(a).value == 'color') {
            document.getElementById(b).value = 'radio_button';
            show_hide_form_option_images("radio_button");
            $(".show-size-chart").hide();
            $("#create_your_own_type").hide();
            $("#create_your_own").hide();
            $(".hideColor").show();
        } else if (document.getElementById(a).value == 'weight') {
            document.getElementById(b).value = 'radio_button';
            show_hide_form_option_images("radio_button");
            $(".show-size-chart").hide();
            $("#create_your_own_type").hide();
            $("#create_your_own").hide();
            $(".hideColor").hide();
        } else if (document.getElementById(a).value == 'packaging type') {
            document.getElementById(b).value = 'radio_button';
            show_hide_form_option_images("radio_button");
            $(".show-size-chart").hide();
            $("#create_your_own_type").hide();
            $("#create_your_own").hide();
            $(".hideColor").hide();
        } else if (document.getElementById(a).value == 'set of pieces') {
            document.getElementById(b).value = 'radio_button';
            show_hide_form_option_images("radio_button");
            $(".show-size-chart").hide();
            $("#create_your_own_type").hide();
            $("#create_your_own").hide();
            $(".hideColor").hide();
        } else if (document.getElementById(a).value == 'create your own') {
            document.getElementById(b).value = 'radio_button';
            show_hide_form_option_images("radio_button");
            $(".show-size-chart").hide();
            $("#create_your_own").show();
            $("#create_your_own_type").show();
            $(".hideColor").show();
        }
    };
</script>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#blah').attr('src', e.target.result);
                $('#blah').show();
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    $("#fileToUpload").change(function() {
        readURL(this);
    });
</script>


<!-- <div class="row-custom">
    <p class="images-exp"><i class="icon-exclamation-circle"></i><?php echo trans("product_image_exp"); ?></p>
</div> -->
<!-- File item template -->
<script type="text/html" id="files-template-image">
    <li class="media">
        <img class="preview-img" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="bg">
        <div class="media-body">
            <div class="progress">
                <div class="dm-progress-waiting"><?php echo trans("waiting"); ?></div>
                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </li>
</script>

<script>
    $(function() {
        $('#drag-and-drop-zone').dmUploader({
            url: '<?php echo base_url(); ?>upload-image-session-post',
            maxFileSize: <?php echo $this->general_settings->max_file_size_image; ?>,
            maxFiles: 1,
            queue: true,
            allowedTypes: 'image/*',
            extFilter: ["jpg", "jpeg", "gif"],
            extraData: function(id) {
                return {
                    "file_id": id,
                    "<?php echo $this->security->get_csrf_token_name(); ?>": $.cookie(csfr_cookie_name)
                };
            },
            onDragEnter: function() {
                this.addClass('active');
            },
            onDragLeave: function() {
                this.removeClass('active');
            },
            onNewFile: function(id, file) {
                ui_multi_add_file(id, file, "image");
                if (typeof FileReader !== "undefined") {
                    var reader = new FileReader();
                    var img = $('#uploaderFile' + id).find('img');

                    reader.onload = function(e) {
                        img.attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            },
            onBeforeUpload: function(id) {
                $('#uploaderFile' + id + ' .dm-progress-waiting').hide();
                ui_multi_update_file_progress(id, 0, '', true);
                ui_multi_update_file_status(id, 'uploading', 'Uploading...');
            },
            onUploadProgress: function(id, percent) {
                ui_multi_update_file_progress(id, percent);
            },
            onUploadSuccess: function(id, data) {
                var data = {
                    "file_id": id,
                    "sys_lang_id": sys_lang_id
                };
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                $.ajax({
                    type: "POST",
                    url: base_url + "get-sess-uploaded-image-post-sizechart",
                    data: data,
                    success: function(response) {
                        document.getElementById("uploaderFile" + id).innerHTML = response;
                        $("#hideShow-sizechart").hide();
                    }
                });
                ui_multi_update_file_status(id, 'success', 'Upload Complete');
                ui_multi_update_file_progress(id, 100, 'success', false);
            },
            onFileSizeError: function(file) {
                $(".error-message-img-upload").html("<?php echo trans('file_too_large') . ' ' . formatSizeUnits($this->general_settings->max_file_size_image); ?>");
                setTimeout(function() {
                    $(".error-message-img-upload").empty();
                }, 4000);
            },
            onFileExtError: function(file) {
                $(".error-message-img-upload").html("<?php echo trans('invalid_file_type'); ?>");
                setTimeout(function() {
                    $(".error-message-img-upload").empty();
                }, 4000);
            },
            onFilesMaxError: function(file) {
                $(".error-message-img-upload").html("<?php echo trans('file_too_large') . ' ' . formatSizeUnits($this->general_settings->max_file_size_image); ?>");
                setTimeout(function() {
                    $(".error-message-img-upload").empty();
                }, 4000);
            },
        });
    });

    $(function() {
        $("#sizeChartInput").removeAttr("multiple");
    });
</script>