<!-- <?php defined('BASEPATH') or exit('No direct script access allowed'); ?> -->
<input type="hidden" name="variation_id" value="<?php echo $variation->id; ?>">
<input type="hidden" name="product_id" value="<?php echo $variation->product_id; ?>">
<?php $modesy_images = get_variation_images_uncached($variation->id); ?>
<?php
?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo trans("edit_variation"); ?></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><i class="icon-close"></i></span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12 tab-variation">
            <div class="form-group">
                <?php if ((get_variation_label($variation->label_names, $this->selected_lang->id) == 'size') || (get_variation_label($variation->label_names, $this->selected_lang->id) == 'portion size') || (get_variation_label($variation->label_names, $this->selected_lang->id) == 'color') || (get_variation_label($variation->label_names, $this->selected_lang->id) == 'weight') || (get_variation_label($variation->label_names, $this->selected_lang->id) == 'packaging type') || (get_variation_label($variation->label_names, $this->selected_lang->id) == 'set of pieces')) : ?>
                    <label class="control-label">Type of Variation<?php //echo trans('label'); 
                                                                    ?></label>
                    <?php foreach ($this->languages as $language) : ?>
                        <?php if ($language->id == $this->selected_lang->id) : ?>
                            <select name="label_lang_<?php echo $language->id; ?>" id="input_variation_label_edit" class="form-control custom-select" id="input_variation_label" onchange="change_label('input_variation_label_edit','variation_type_id_edit')" required>
                                <option selected disabled>Select Variations</option>
                                <?php if (get_variation_label($variation->label_names, $this->selected_lang->id) == 'size') : ?>
                                
                                    <option value="size" <?php echo (get_variation_label($variation->label_names, $this->selected_lang->id) == 'size') ? 'selected' : ''; ?>>Size</option>
                                <?php elseif (get_variation_label($variation->label_names, $this->selected_lang->id) == 'portion size') : ?>
                                    <option value="portion size" <?php echo (get_variation_label($variation->label_names, $this->selected_lang->id) == 'portion size') ? 'selected' : ''; ?>>Portion Size</option>
                                <?php endif; ?>
                                <option value="color" <?php echo (get_variation_label($variation->label_names, $this->selected_lang->id) == 'color') ? 'selected' : ''; ?>><?php echo trans('color'); ?></option>
                                <option value="weight" <?php echo (get_variation_label($variation->label_names, $this->selected_lang->id) == 'weight') ? 'selected' : ''; ?>>Weight</option>
                                <option value="packaging type" <?php echo (get_variation_label($variation->label_names, $this->selected_lang->id) == 'packaging type') ? 'selected' : ''; ?>>Packaging Type</option>
                                <option value="set of pieces" <?php echo (get_variation_label($variation->label_names, $this->selected_lang->id) == 'set of pieces') ? 'selected' : ''; ?>>Set of pieces</option>

                            </select>
                            <!-- <input type="text" id="input_variation_label_edit" class="form-control form-input input-variation-label" name="label_lang_<?php echo $language->id; ?>" value="<?php echo get_variation_label($variation->label_names, $language->id); ?>" placeholder="<?php echo $language->name; ?>" maxlength="255" required> -->
                        <?php else : ?>
                            <select name="label_lang_<?php echo $language->id; ?>" class="form-control custom-select" required>
                                <option selected disabled>Select Variations</option>
                                <?php if (get_variation_label($variation->label_names, $this->selected_lang->id) == 'size') : ?>
                                    <option value="size" <?php echo (get_variation_label($variation->label_names, $this->selected_lang->id) == 'size') ? 'selected' : ''; ?>>Size</option>
                                <?php elseif (get_variation_label($variation->label_names, $this->selected_lang->id) == 'portion size') : ?>
                                    <option value="portion size" <?php echo (get_variation_label($variation->label_names, $this->selected_lang->id) == 'portion size') ? 'selected' : ''; ?>>Portion Size</option>
                                <?php endif; ?>
                                <option value="color" <?php echo (get_variation_label($variation->label_names, $language->id) == 'color') ? 'selected' : ''; ?>><?php echo trans('color'); ?></option>
                                <option value="weight" <?php echo (get_variation_label($variation->label_names, $language->id) == 'weight') ? 'selected' : ''; ?>>Weight</option>
                                <option value="packaging type" <?php echo (get_variation_label($variation->label_names, $language->id) == 'packaging type') ? 'selected' : ''; ?>>Packaging Type</option>
                                <option value="set of pieces" <?php echo (get_variation_label($variation->label_names, $language->id) == 'set off') ? 'selected' : ''; ?>>Set of pieces</option>

                            </select>
                            <!-- <input type="text" class="form-control form-input input-variation-label" name="label_lang_<?php echo $language->id; ?>" value="<?php echo get_variation_label($variation->label_names, $language->id); ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <label class="control-label">Name of Variation<?php //echo trans('label'); 
                                                                    ?></label>
                    <?php foreach ($this->languages as $language) : ?>
                        <?php if ($language->id == $this->selected_lang->id) : ?>
                            <input type="text" id="input_variation_label_edit" class="form-control form-input input-variation-label" name="label_lang_<?php echo $language->id; ?>" value="<?php echo get_variation_label($variation->label_names, $language->id); ?>" placeholder="<?php echo $language->name; ?>" maxlength="255" required>
                        <?php else : ?>
                            <input type="text" class="form-control form-input input-variation-label" name="label_lang_<?php echo $language->id; ?>" value="<?php echo get_variation_label($variation->label_names, $language->id); ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255">
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="form-group" style="display:<?php if ((get_variation_label($variation->label_names, $this->selected_lang->id) == 'size') || (get_variation_label($variation->label_names, $this->selected_lang->id) == 'color') || (get_variation_label($variation->label_names, $this->selected_lang->id) == 'weight') || (get_variation_label($variation->label_names, $this->selected_lang->id) == 'packaging type') || (get_variation_label($variation->label_names, $this->selected_lang->id) == 'set of pieces')) : echo "none";
                                                    else : echo "block";
                                                    endif; ?>;">
                <label class="control-label"><?php echo trans('variation_type'); ?></label>
                <select name="variation_type" id="variation_type_id_edit" class="form-control custom-select" onchange="show_hide_form_option_images(this.value);" required>
                    <option value="radio_button" <?php echo ($variation->variation_type == 'radio_button') ? 'selected' : ''; ?>><?php echo trans('radio_button'); ?></option>
                    <option value="dropdown" <?php echo ($variation->variation_type == 'dropdown') ? 'selected' : ''; ?>><?php echo trans('dropdown'); ?></option>
                    <option value="checkbox" <?php echo ($variation->variation_type == 'checkbox') ? 'selected' : ''; ?>><?php echo trans('checkbox'); ?></option>
                    <option value="text" <?php echo ($variation->variation_type == 'text') ? 'selected' : ''; ?>><?php echo trans('text'); ?></option>
                    <option value="number" <?php echo ($variation->variation_type == 'number') ? 'selected' : ''; ?>><?php echo trans('number'); ?></option>
                </select>
            </div>
            <div class="form-group m-0 form-group-display-type <?php echo ($variation->variation_type != 'radio_button' && $variation->variation_type != 'checkbox') ? 'display-none' : ''; ?>">
                <div class="row">
                    <div class="col-sm-12">
                        <label class="control-label"><?php echo trans('option_display_type'); ?></label>
                    </div>
                    <div class="col-md-4 col-sm-12 col-custom-option">
                        <div class="custom-control custom-radio">
                            <input type="radio" name="option_display_type" value="text" id="option_display_type_edit_1" class="custom-control-input" <?php echo ($variation->option_display_type == 'text') ? 'checked' : ''; ?>>
                            <label for="option_display_type_edit_1" class="custom-control-label"><?php echo trans('text'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-custom-option">
                        <div class="custom-control custom-radio">
                            <input type="radio" name="option_display_type" value="image" id="option_display_type_edit_2" class="custom-control-input" <?php echo ($variation->option_display_type == 'image') ? 'checked' : ''; ?>>
                            <label for="option_display_type_edit_2" class="custom-control-label"><?php echo trans('image'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-custom-option hideColor">
                        <div class="custom-control custom-radio">
                            <input type="radio" name="option_display_type" value="color" id="option_display_type_edit_3" class="custom-control-input" <?php echo ($variation->option_display_type == 'color') ? 'checked' : ''; ?>>
                            <label for="option_display_type_edit_3" class="custom-control-label"><?php echo trans('color'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="form-group <?php echo ($variation->variation_type != "dropdown") ? "display-none" : ""; ?>">
                <label class="control-label"><?php echo trans('parent_variation'); ?></label>
                <select name="parent_id" class="form-control custom-select">
                    <option value=""><?php echo trans("none"); ?></option>
                    <?php if (!empty($product_variations)) :
                        foreach ($product_variations as $item) :
                            if ($item->variation_type == "dropdown") : ?>
                                <option value="<?php echo $item->id; ?>" <?php echo ($variation->parent_id == $item->id) ? 'selected' : ''; ?>><?php echo $item->id . " - " . html_escape(get_variation_label($item->label_names, $this->selected_lang->id)) . ' - ' . trans($item->variation_type); ?></option>
                            <?php endif;
                        endforeach;
                    endif; ?>
                </select>
            </div> -->
            <div class="form-group m-0 form-group-show-option-images <?php echo ($variation->variation_type != 'radio_button' && $variation->variation_type != 'dropdown') ? 'display-none' : ''; ?>">
                <div class="row">
                    <div class="col-sm-12">
                        <label class="control-label"><?php echo trans('show_option_images_on_slider'); ?></label>
                    </div>
                    <div class="col-md-4 col-sm-12 col-custom-option">
                        <div class="custom-control custom-radio">
                            <input type="radio" name="show_images_on_slider" value="1" id="show_images_on_slider_when_selected_edit_1" class="custom-control-input" <?php echo ($variation->show_images_on_slider == 1) ? 'checked' : ''; ?>>
                            <label for="show_images_on_slider_when_selected_edit_1" class="custom-control-label"><?php echo trans('yes'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-custom-option">
                        <div class="custom-control custom-radio">
                            <input type="radio" name="show_images_on_slider" value="0" id="show_images_on_slider_when_selected_edit_2" class="custom-control-input" <?php echo ($variation->show_images_on_slider != 1) ? 'checked' : ''; ?>>
                            <label for="show_images_on_slider_when_selected_edit_2" class="custom-control-label"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <?php //if ((is_there_variation_uses_different_price($variation->product_id, $variation->id)) && $product->listing_type != 'bidding') : 
            ?>
            <div class="form-group form-group-show-option-images">
                <div class="row">
                    <div class="col-sm-12">
                        <label class="control-label"><?php echo trans('use_different_price_for_options'); ?></label>
                    </div>
                    <div class="col-md-4 col-sm-12 col-custom-option">
                        <div class="custom-control custom-radio">
                            <input type="radio" name="use_different_price" value="1" id="use_different_price_edit_1" class="custom-control-input" <?php echo ($variation->use_different_price == 1) ? 'checked' : ''; ?>>
                            <label for="use_different_price_edit_1" class="custom-control-label"><?php echo trans('yes'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-custom-option">
                        <div class="custom-control custom-radio">
                            <input type="radio" name="use_different_price" value="0" id="use_different_price_edit_2" class="custom-control-input" <?php echo ($variation->use_different_price != 1) ? 'checked' : ''; ?>>
                            <label for="use_different_price_edit_2" class="custom-control-label"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <?php //endif; 
            ?>
            <!-- <div class="form-group m-0" style="display: none;">
                <div class="row">
                    <div class="col-sm-12">
                        <label class="control-label"><?php echo trans('visible'); ?></label>
                    </div>
                    <div class="col-md-4 col-sm-12 col-custom-option">
                        <div class="custom-control custom-radio">
                            <input type="radio" name="is_visible" value="1" id="edit_visible_edit_1" class="custom-control-input" <?php echo ($variation->is_visible == 1) ? 'checked' : ''; ?>>
                            <label for="edit_visible_edit_1" class="custom-control-label"><?php echo trans('yes'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-custom-option">
                        <div class="custom-control custom-radio">
                            <input type="radio" name="is_visible" value="0" id="edit_visible_edit_2" class="custom-control-input" <?php echo ($variation->is_visible != 1) ? 'checked' : ''; ?>>
                            <label for="edit_visible_edit_2" class="custom-control-label"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="form-group m-0 show-size-chart" style="display:<?php echo (get_variation_label($variation->label_names, $this->selected_lang->id) == 'size') ? 'block' : 'none'; ?>">
                <div class="row">
                    <div class="col-sm-12">
                        <label class="control-label" id="size-click">Size Chart</label>
                    </div>

                    <div class='col-sm-6'>
                        <div class="row">
                            <div class="col-sm-16">
                                <div class="dm-uploader-container">
                                    <div id="drag-and-drop-zone-edit" class="dm-uploader text-center">
                                        <div id="hide1" style="display:<?php echo (!empty($modesy_images[0]->size_chart)) ? "none" : "block"; ?>;">
                                            <p class="dm-upload-icon">
                                                <i class="icon-upload"></i>
                                            </p>
                                            <p class="dm-upload-text"><?php echo trans("drag_drop_images_here"); ?>&nbsp;<span style="text-decoration: underline"><?php echo trans('browse_files'); ?></span></p>

                                            <a class='btn btn-md dm-btn-select-files'>
                                                <input type="file" id="sizeChartInputNew" name="file_sizeChart" onchange="imageShowSizeChart($(this)[0],id)" size="40" accept="image/jpeg,image/jpg">
                                            </a>
                                        </div>

                                        <ul class="dm-uploaded-files" id="files-image">
                                            <?php if (!empty($modesy_images[0]->size_chart)) :
                                                foreach ($modesy_images as $modesy_image) : ?>
                                                    <li class="media" id="uploaderFile<?php echo $modesy_image->id; ?>">
                                                        <img src="<?php echo get_size_chart_image_url($modesy_image->size_chart); ?>" id="image-src">
                                                        <!-- <a href="javascript:void(0)" class="btn-img-delete btn-delete-sizechart-img" data-file-id="<?php echo $modesy_image->id; ?>">
                                                            <i class="icon-close"></i>
                                                        </a> -->
                                                    </li>
                                                <?php endforeach;
                                                // else : 
                                                ?>
                                                <!-- <li class="media" id="upload_edit_sizechart" style="display:none;">
                                                    <img src="" id="image-src-sizeChart">

                                                    <a href="javascript:void(0)" class="btn-img-delete btn-delete-sizechart-img" data-file-id="">
                                                        <i class="icon-close"></i>

                                                </li> -->
                                            <?php endif; ?>
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
    <div class="row-custom">
        <button type="button" class="btn btn-md btn-danger color-white float-left hidden btn-show-variation-form"><i class="icon-arrow-left"></i><?php echo trans("back") ?></button>
        <button type="submit" id="form-variation-edit-button" class="btn btn-md btn-secondary btn-variation float-right">
            <div id="form-variation-edit-text"><?php echo trans("save_changes"); ?></div>
            <div id="sp-options-add" class="spinner spinner-btn-add-variation">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </button>

    </div>
</div>

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