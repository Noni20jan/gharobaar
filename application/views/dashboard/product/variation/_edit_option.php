<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form id="form_edit_product_variation_option" novalidate>
    <input type="hidden" name="variation_id" id="form_edit_variation_id" value="<?php echo $variation->id; ?>">
    <input type="hidden" name="option_id" value="<?php echo $variation_option->id; ?>">
    <div class="modal-header">
        <h5 class="modal-title"><?php echo trans("edit_option"); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="icon-close"></i></span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
                <?php $this->load->view('dashboard/includes/_messages'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 box-variation-options">
                <div class="form-group m-b-5">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="control-label"><?php echo trans('default_option'); ?>&nbsp;<small class="text-muted">(<?php echo trans('default_option_exp'); ?>)</small></label>
                        </div>
                        <div class="col-sm-12 col-md-6 col-custom-option">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="is_default_edit" value="1" id="is_default_1_edit" class="custom-control-input" <?php echo ($variation_option->is_default == 1) ? "checked" : ""; ?>>
                                <label for="is_default_1_edit" class="custom-control-label"><?php echo trans("yes"); ?></label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-custom-option">
                            <div class="custom-control custom-radio">
                                <input type="radio" name="is_default_edit" value="0" id="is_default_2_edit" class="custom-control-input" <?php echo ($variation_option->is_default != 1) ? "checked" : ""; ?>>
                                <label for="is_default_2_edit" class="custom-control-label"><?php echo trans("no"); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="form-group m-b-5">
                    <label class="control-label"><?php echo trans("option_name"); ?></label>
                    <?php if (!empty($this->languages)) : ?>
                        <?php if (count($this->languages) <= 1) : ?>
                            <input type="text" id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" value="<?php echo html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)); ?>" maxlength="255">
                        <?php else : ?>
                            <?php foreach ($this->languages as $language) : ?>
                                <?php if ($language->id == $this->selected_lang->id) : ?>
                                    <input type="text" id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" value="<?php echo html_escape(get_variation_option_name($variation_option->option_names, $language->id)); ?>" placeholder="<?php echo $language->name; ?>" maxlength="255">
                                <?php else : ?>
                                    <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" value="<?php echo html_escape(get_variation_option_name($variation_option->option_names, $language->id)); ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div> -->


                <?php if (get_variation_label($variation->label_names, $this->selected_lang->id) == "size") : ?>
                    <?php if ($product->category_id == 71) : ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo "Select size"; ?></label>

                            <?php if (!empty($this->languages)) : ?>
                                <?php if (count($this->languages) <= 1) : ?>
                                    <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                        <option value="">Select an option</option>
                                        <option value="6 yards" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "6 yards") ? 'selected' : ''; ?>>6 yards</option>
                                        <option value="9 yards" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "9 yards") ? 'selected' : ''; ?>>9 yards</option>
                                        <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                    </select>
                                <?php else : ?>
                                    <?php foreach ($this->languages as $language) : ?>
                                        <?php if ($language->id == $this->selected_lang->id) : ?>
                                            <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                            <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                <option value="">Select an option</option>
                                                <option value="6 yards" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "6 yards") ? 'selected' : ''; ?>>6 yards</option>
                                                <option value="9 yards" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "9 yards") ? 'selected' : ''; ?>>9 yards</option>
                                                <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        <?php else : ?>
                                            <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                            <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                <option value="">Select an option</option>
                                                <option value="6 yards" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "6 yards") ? 'selected' : ''; ?>>6 yards</option>
                                                <option value="9 yards" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "9 yards") ? 'selected' : ''; ?>>9 yards</option>
                                                <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php elseif ($product->category_id == 174 || $product->category_id == 175 || $product->category_id == 174 || $product->category_id == 175 || $product->category_id == 178) : ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo "Select size"; ?></label>

                            <?php if (!empty($this->languages)) : ?>
                                <?php if (count($this->languages) <= 1) : ?>
                                    <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                        <option value="">Select an option</option>
                                        <option value="Queen" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Queen") ? 'selected' : ''; ?>>Queen</option>
                                        <option value="King" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "King") ? 'selected' : ''; ?>>King</option>
                                        <option value="Super-King" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Super-King") ? 'selected' : ''; ?>>Super-King</option>
                                        <option value="Single" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Single") ? 'selected' : ''; ?>>Single</option>
                                        <option value="Single Pair" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Single Pair") ? 'selected' : ''; ?>>Single Pair</option>
                                        <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                    </select>
                                <?php else : ?>
                                    <?php foreach ($this->languages as $language) : ?>
                                        <?php if ($language->id == $this->selected_lang->id) : ?>
                                            <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                            <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                <option value="">Select an option</option>
                                                <option value="Queen" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Queen") ? 'selected' : ''; ?>>Queen</option>
                                                <option value="King" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "King") ? 'selected' : ''; ?>>King</option>
                                                <option value="Super-King" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Super-King") ? 'selected' : ''; ?>>Super-King</option>
                                                <option value="Single" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Single") ? 'selected' : ''; ?>>Single</option>
                                                <option value="Single Pair" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Single Pair") ? 'selected' : ''; ?>>Single Pair</option>
                                                <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        <?php else : ?>
                                            <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                            <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                <option value="">Select an option</option>
                                                <option value="Queen" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Queen") ? 'selected' : ''; ?>>Queen</option>
                                                <option value="King" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "King") ? 'selected' : ''; ?>>King</option>
                                                <option value="Super-King" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Super-King") ? 'selected' : ''; ?>>Super-King</option>
                                                <option value="Single" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Single") ? 'selected' : ''; ?>>Single</option>
                                                <option value="Single Pair" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Single Pair") ? 'selected' : ''; ?>>Single Pair</option>
                                                <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                    <?php elseif ($parent_categories_array[0]->id == 1 && $parent_categories_array[1]->id == 14) : ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo "Select size"; ?></label>

                            <?php if (!empty($this->languages)) : ?>
                                <?php if (count($this->languages) <= 1) : ?>
                                    <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                        <option value="">Select an option</option>
                                        <option value="0" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "0") ? 'selected' : ''; ?>>0</option>
                                        <option value="0.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "0.5") ? 'selected' : ''; ?>>0.5</option>
                                        <option value="1" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "1") ? 'selected' : ''; ?>>1</option>
                                        <option value="1.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "1.5") ? 'selected' : ''; ?>>1.5</option>
                                        <option value="2" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "2") ? 'selected' : ''; ?>>2</option>
                                        <option value="2.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "2.5") ? 'selected' : ''; ?>>2.5</option>
                                        <option value="3" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "3") ? 'selected' : ''; ?>>3</option>
                                        <option value="3.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "3.5") ? 'selected' : ''; ?>>3.5</option>
                                        <option value="4" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "4") ? 'selected' : ''; ?>>4</option>
                                        <option value="4.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "4.5") ? 'selected' : ''; ?>>4.5</option>
                                        <option value="5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "5") ? 'selected' : ''; ?>>5</option>
                                        <option value="5.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "5.5") ? 'selected' : ''; ?>>5.5</option>
                                        <option value="6" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "6") ? 'selected' : ''; ?>>6</option>
                                        <option value="6.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "6.5") ? 'selected' : ''; ?>>6.5</option>
                                        <option value="7" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "7") ? 'selected' : ''; ?>>7</option>
                                        <option value="7.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "7.5") ? 'selected' : ''; ?>>7.5</option>
                                        <option value="8" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "8") ? 'selected' : ''; ?>>8</option>
                                        <option value="8.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "8.5") ? 'selected' : ''; ?>>8.5</option>
                                        <option value="9" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "9") ? 'selected' : ''; ?>>9</option>
                                        <option value="9.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "9.5") ? 'selected' : ''; ?>>9.5</option>
                                        <option value="10" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "10") ? 'selected' : ''; ?>>10</option>
                                        <option value="10.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "10.5") ? 'selected' : ''; ?>>10.5</option>
                                        <option value="11" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "11") ? 'selected' : ''; ?>>11</option>
                                        <option value="11.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "11.5") ? 'selected' : ''; ?>>11.5</option>
                                        <option value="12" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "12") ? 'selected' : ''; ?>>12</option>
                                        <option value="12.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "12.5") ? 'selected' : ''; ?>>12.5</option>
                                        <option value="13" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "13") ? 'selected' : ''; ?>>13</option>
                                        <option value="13.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "13.5") ? 'selected' : ''; ?>>13.5</option>
                                        <option value="14" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "14") ? 'selected' : ''; ?>>14</option>
                                        <option value="14.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "14.5") ? 'selected' : ''; ?>>14.5</option>
                                        <option value="15" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "15") ? 'selected' : ''; ?>>15</option>
                                        <option value="15.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "15.5") ? 'selected' : ''; ?>>15.5</option>
                                        <option value="16" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "16") ? 'selected' : ''; ?>>16</option>
                                        <option value="16.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "16.5") ? 'selected' : ''; ?>>16.5</option>
                                        <option value="17" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "17") ? 'selected' : ''; ?>>17</option>
                                        <option value="17.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "17.5") ? 'selected' : ''; ?>>17.5</option>
                                        <option value="18" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "18") ? 'selected' : ''; ?>>18</option>
                                        <option value="18.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "18.5") ? 'selected' : ''; ?>>18.5</option>
                                        <option value="19" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "19") ? 'selected' : ''; ?>>19</option>
                                        <option value="19.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "19.5") ? 'selected' : ''; ?>>19.5</option>
                                        <option value="20" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "20") ? 'selected' : ''; ?>>20</option>
                                        <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                    </select>
                                <?php else : ?>
                                    <?php foreach ($this->languages as $language) : ?>
                                        <?php if ($language->id == $this->selected_lang->id) : ?>
                                            <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                            <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                <option value="">Select an option</option>
                                                <option value="0" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "0") ? 'selected' : ''; ?>>0</option>
                                                <option value="0.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "0.5") ? 'selected' : ''; ?>>0.5</option>
                                                <option value="1" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "1") ? 'selected' : ''; ?>>1</option>
                                                <option value="1.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "1.5") ? 'selected' : ''; ?>>1.5</option>
                                                <option value="2" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "2") ? 'selected' : ''; ?>>2</option>
                                                <option value="2.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "2.5") ? 'selected' : ''; ?>>2.5</option>
                                                <option value="3" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "3") ? 'selected' : ''; ?>>3</option>
                                                <option value="3.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "3.5") ? 'selected' : ''; ?>>3.5</option>
                                                <option value="4" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "4") ? 'selected' : ''; ?>>4</option>
                                                <option value="4.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "4.5") ? 'selected' : ''; ?>>4.5</option>
                                                <option value="5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "5") ? 'selected' : ''; ?>>5</option>
                                                <option value="5.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "5.5") ? 'selected' : ''; ?>>5.5</option>
                                                <option value="6" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "6") ? 'selected' : ''; ?>>6</option>
                                                <option value="6.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "6.5") ? 'selected' : ''; ?>>6.5</option>
                                                <option value="7" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "7") ? 'selected' : ''; ?>>7</option>
                                                <option value="7.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "7.5") ? 'selected' : ''; ?>>7.5</option>
                                                <option value="8" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "8") ? 'selected' : ''; ?>>8</option>
                                                <option value="8.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "8.5") ? 'selected' : ''; ?>>8.5</option>
                                                <option value="9" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "9") ? 'selected' : ''; ?>>9</option>
                                                <option value="9.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "9.5") ? 'selected' : ''; ?>>9.5</option>
                                                <option value="10" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "10") ? 'selected' : ''; ?>>10</option>
                                                <option value="10.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "10.5") ? 'selected' : ''; ?>>10.5</option>
                                                <option value="11" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "11") ? 'selected' : ''; ?>>11</option>
                                                <option value="11.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "11.5") ? 'selected' : ''; ?>>11.5</option>
                                                <option value="12" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "12") ? 'selected' : ''; ?>>12</option>
                                                <option value="12.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "12.5") ? 'selected' : ''; ?>>12.5</option>
                                                <option value="13" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "13") ? 'selected' : ''; ?>>13</option>
                                                <option value="13.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "13.5") ? 'selected' : ''; ?>>13.5</option>
                                                <option value="14" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "14") ? 'selected' : ''; ?>>14</option>
                                                <option value="14.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "14.5") ? 'selected' : ''; ?>>14.5</option>
                                                <option value="15" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "15") ? 'selected' : ''; ?>>15</option>
                                                <option value="15.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "15.5") ? 'selected' : ''; ?>>15.5</option>
                                                <option value="16" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "16") ? 'selected' : ''; ?>>16</option>
                                                <option value="16.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "16.5") ? 'selected' : ''; ?>>16.5</option>
                                                <option value="17" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "17") ? 'selected' : ''; ?>>17</option>
                                                <option value="17.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "17.5") ? 'selected' : ''; ?>>17.5</option>
                                                <option value="18" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "18") ? 'selected' : ''; ?>>18</option>
                                                <option value="18.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "18.5") ? 'selected' : ''; ?>>18.5</option>
                                                <option value="19" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "19") ? 'selected' : ''; ?>>19</option>
                                                <option value="19.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "19.5") ? 'selected' : ''; ?>>19.5</option>
                                                <option value="20" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "20") ? 'selected' : ''; ?>>20</option>
                                                <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        <?php else : ?>
                                            <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                            <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                <option value="">Select an option</option>
                                                <option value="0" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "0") ? 'selected' : ''; ?>>0</option>
                                                <option value="0.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "0.5") ? 'selected' : ''; ?>>0.5</option>
                                                <option value="1" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "1") ? 'selected' : ''; ?>>1</option>
                                                <option value="1.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "1.5") ? 'selected' : ''; ?>>1.5</option>
                                                <option value="2" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "2") ? 'selected' : ''; ?>>2</option>
                                                <option value="2.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "2.5") ? 'selected' : ''; ?>>2.5</option>
                                                <option value="3" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "3") ? 'selected' : ''; ?>>3</option>
                                                <option value="3.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "3.5") ? 'selected' : ''; ?>>3.5</option>
                                                <option value="4" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "4") ? 'selected' : ''; ?>>4</option>
                                                <option value="4.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "4.5") ? 'selected' : ''; ?>>4.5</option>
                                                <option value="5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "5") ? 'selected' : ''; ?>>5</option>
                                                <option value="5.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "5.5") ? 'selected' : ''; ?>>5.5</option>
                                                <option value="6" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "6") ? 'selected' : ''; ?>>6</option>
                                                <option value="6.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "6.5") ? 'selected' : ''; ?>>6.5</option>
                                                <option value="7" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "7") ? 'selected' : ''; ?>>7</option>
                                                <option value="7.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "7.5") ? 'selected' : ''; ?>>7.5</option>
                                                <option value="8" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "8") ? 'selected' : ''; ?>>8</option>
                                                <option value="8.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "8.5") ? 'selected' : ''; ?>>8.5</option>
                                                <option value="9" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "9") ? 'selected' : ''; ?>>9</option>
                                                <option value="9.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "9.5") ? 'selected' : ''; ?>>9.5</option>
                                                <option value="10" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "10") ? 'selected' : ''; ?>>10</option>
                                                <option value="10.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "10.5") ? 'selected' : ''; ?>>10.5</option>
                                                <option value="11" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "11") ? 'selected' : ''; ?>>11</option>
                                                <option value="11.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "11.5") ? 'selected' : ''; ?>>11.5</option>
                                                <option value="12" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "12") ? 'selected' : ''; ?>>12</option>
                                                <option value="12.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "12.5") ? 'selected' : ''; ?>>12.5</option>
                                                <option value="13" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "13") ? 'selected' : ''; ?>>13</option>
                                                <option value="13.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "13.5") ? 'selected' : ''; ?>>13.5</option>
                                                <option value="14" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "14") ? 'selected' : ''; ?>>14</option>
                                                <option value="14.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "14.5") ? 'selected' : ''; ?>>14.5</option>
                                                <option value="15" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "15") ? 'selected' : ''; ?>>15</option>
                                                <option value="15.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "15.5") ? 'selected' : ''; ?>>15.5</option>
                                                <option value="16" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "16") ? 'selected' : ''; ?>>16</option>
                                                <option value="16.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "16.5") ? 'selected' : ''; ?>>16.5</option>
                                                <option value="17" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "17") ? 'selected' : ''; ?>>17</option>
                                                <option value="17.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "17.5") ? 'selected' : ''; ?>>17.5</option>
                                                <option value="18" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "18") ? 'selected' : ''; ?>>18</option>
                                                <option value="18.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "18.5") ? 'selected' : ''; ?>>18.5</option>
                                                <option value="19" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "19") ? 'selected' : ''; ?>>19</option>
                                                <option value="19.5" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "19.5") ? 'selected' : ''; ?>>19.5</option>
                                                <option value="20" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "20") ? 'selected' : ''; ?>>20</option>
                                                <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                    <?php elseif (($parent_categories_array[0]->id == 1 && $parent_categories_array[1]->id == 11) || ($parent_categories_array[0]->id == 1 && $parent_categories_array[1]->id == 12) || ($parent_categories_array[0]->id == 7 && $parent_categories_array[1]->id == 55) || $parent_categories_array[0]->id == 3 || ($parent_categories_array[0]->id == 7 && $parent_categories_array[1]->id == 57) || ($parent_categories_array[0]->id == 5 && $parent_categories_array[1]->id != 37) || $parent_categories_array[0]->id == 3) : ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo "Select size"; ?></label>

                            <?php if (!empty($this->languages)) : ?>
                                <?php if (count($this->languages) <= 1) : ?>
                                    <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                        <option value="">Select an option</option>

                                        <option value="Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Small") ? 'selected' : ''; ?>>Small</option>
                                        <option value="Medium" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Medium") ? 'selected' : ''; ?>>Medium</option>
                                        <option value="Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Large") ? 'selected' : ''; ?>>Large</option>
                                        <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                    </select>
                                <?php else : ?>
                                    <?php foreach ($this->languages as $language) : ?>
                                        <?php if ($language->id == $this->selected_lang->id) : ?>
                                            <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                            <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                <option value="">Select an option</option>

                                                <option value="Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Small") ? 'selected' : ''; ?>>Small</option>
                                                <option value="Medium" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Medium") ? 'selected' : ''; ?>>Medium</option>
                                                <option value="Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Large") ? 'selected' : ''; ?>>Large</option>
                                                <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        <?php else : ?>
                                            <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                            <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                <option value="">Select an option</option>
                                                <option value="Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Small") ? 'selected' : ''; ?>>Small</option>
                                                <option value="Medium" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Medium") ? 'selected' : ''; ?>>Medium</option>
                                                <option value="Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Large") ? 'selected' : ''; ?>>Large</option>
                                                <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php elseif ($parent_categories_array[0]->id == 5 && $parent_categories_array[1]->id == 37) : ?>

                        <label class="control-label"><?php echo "Select Size"; ?></label>

                        <?php if (!empty($this->languages)) : ?>
                            <?php if (count($this->languages) <= 1) : ?>
                                <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                    <option value="">Select an option</option>
                                    <option value="XX-Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "XX-Small") ? 'selected' : ''; ?>>XX-Small</option>
                                    <option value="X-small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "X-Small") ? 'selected' : ''; ?>>X-small</option>
                                    <option value="Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Small") ? 'selected' : ''; ?>>Small</option>
                                    <option value="Medium" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Medium") ? 'selected' : ''; ?>>Medium</option>
                                    <option value="Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Large") ? 'selected' : ''; ?>>Large</option>
                                    <option value="X-Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "X-Large") ? 'selected' : ''; ?>>X-Large</option>
                                    <option value="XX-Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "XX-Large") ? 'selected' : ''; ?>>XX-Large</option>
                                    <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                </select>
                            <?php else : ?>
                                <?php foreach ($this->languages as $language) : ?>
                                    <?php if ($language->id == $this->selected_lang->id) : ?>
                                        <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                        <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                            <option value="">Select an option</option>
                                            <option value="XX-Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "XX-Small") ? 'selected' : ''; ?>>XX-Small</option>
                                            <option value="X-small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "X-Small") ? 'selected' : ''; ?>>X-small</option>
                                            <option value="Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Small") ? 'selected' : ''; ?>>Small</option>
                                            <option value="Medium" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Medium") ? 'selected' : ''; ?>>Medium</option>
                                            <option value="Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Large") ? 'selected' : ''; ?>>Large</option>
                                            <option value="X-Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "X-Large") ? 'selected' : ''; ?>>X-Large</option>
                                            <option value="XX-Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "XX-Large") ? 'selected' : ''; ?>>XX-Large</option>
                                            <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                        </select>
                                    <?php else : ?>
                                        <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                        <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                            <option value="">Select an option</option>
                                            <option value="XX-Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "XX-Small") ? 'selected' : ''; ?>>XX-Small</option>
                                            <option value="X-small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "X-Small") ? 'selected' : ''; ?>>X-small</option>
                                            <option value="Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Small") ? 'selected' : ''; ?>>Small</option>
                                            <option value="Medium" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Medium") ? 'selected' : ''; ?>>Medium</option>
                                            <option value="Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Large") ? 'selected' : ''; ?>>Large</option>
                                            <option value="X-Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "X-Large") ? 'selected' : ''; ?>>X-Large</option>
                                            <option value="XX-Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "XX-Large") ? 'selected' : ''; ?>>XX-Large</option>
                                            <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                        </select>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php elseif ($parent_categories_array[0]->id == 2) : ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo "Select size"; ?></label>

                            <?php if (!empty($this->languages)) : ?>
                                <?php if (count($this->languages) <= 1) : ?>
                                    <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                        <option value="">Select an option</option>
                                        <option value="Serves 1" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Serves 1") ? 'selected' : ''; ?>>Serves 1</option>
                                        <option value="1-2 people" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "1-2 people") ? 'selected' : ''; ?>>1-2 people</option>
                                        <option value="2-3 people" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "2-3 people") ? 'selected' : ''; ?>>2-3 people</option>
                                        <option value="3-4 people" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "3-4 people") ? 'selected' : ''; ?>>3-4 people</option>
                                        <option value="4-5 people" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "4-5 people") ? 'selected' : ''; ?>>4-5 people</option>
                                        <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                    </select>
                                <?php else : ?>
                                    <?php foreach ($this->languages as $language) : ?>
                                        <?php if ($language->id == $this->selected_lang->id) : ?>
                                            <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                            <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                <option value="">Select an option</option>
                                                <option value="Serves 1" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Serves 1") ? 'selected' : ''; ?>>Serves 1</option>
                                                <option value="1-2 people" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "1-2 people") ? 'selected' : ''; ?>>1-2 people</option>
                                                <option value="2-3 people" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "2-3 people") ? 'selected' : ''; ?>>2-3 people</option>
                                                <option value="3-4 people" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "3-4 people") ? 'selected' : ''; ?>>3-4 people</option>
                                                <option value="4-5 people" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "4-5 people") ? 'selected' : ''; ?>>4-5 people</option>
                                                <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        <?php else : ?>
                                            <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                            <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                <option value="">Select an option</option>
                                                <option value="Serves 1" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Serves 1") ? 'selected' : ''; ?>>Serves 1</option>
                                                <option value="1-2 people" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "1-2 people") ? 'selected' : ''; ?>>1-2 people</option>
                                                <option value="2-3 people" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "2-3 people") ? 'selected' : ''; ?>>2-3 people</option>
                                                <option value="3-4 people" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "3-4 people") ? 'selected' : ''; ?>>3-4 people</option>
                                                <option value="4-5 people" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "4-5 people") ? 'selected' : ''; ?>>4-5 people</option>
                                                <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php elseif (($parent_categories_array[0]->id == 6 && $parent_categories_array[1]->id == 38) || ($parent_categories_array[0]->id == 6 && $parent_categories_array[1]->id == 41 && $parent_categories_array[2]->id == 265)) : ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo "Select size"; ?></label>

                            <?php if (!empty($this->languages)) : ?>
                                <?php if (count($this->languages) <= 1) : ?>
                                    <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                        <option value="">Select an option</option>
                                        <option value="NewBorn" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "NewBorn") ? 'selected' : ''; ?>>NewBorn</option>
                                        <option value="0-3 months" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "0-3 months") ? 'selected' : ''; ?>>0-3 months</option>
                                        <option value="3-6 months" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "3-6 months") ? 'selected' : ''; ?>>3-6 months</option>
                                        <option value="6-9 months" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "6-9 months") ? 'selected' : ''; ?>>6-9 months</option>
                                        <option value="9-12 months" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "9-12 months") ? 'selected' : ''; ?>>9-12 months</option>
                                        <option value="12-18 months" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "12-18 months") ? 'selected' : ''; ?>>12-18 months</option>
                                        <option value="18-24 months" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "18-24 months") ? 'selected' : ''; ?>>18-24 months</option>
                                        <option value="2-3 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "2-3 years") ? 'selected' : ''; ?>>2-3 years</option>
                                        <option value="3-4 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "3-4 years") ? 'selected' : ''; ?>>3-4 years</option>
                                        <option value="4-5 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "4-5 years") ? 'selected' : ''; ?>>4-5 years</option>
                                        <option value="5-6 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "5-6 years") ? 'selected' : ''; ?>>5-6 years</option>
                                        <option value="6-7 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "6-7 years") ? 'selected' : ''; ?>>6-7 years</option>
                                        <option value="7-8 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "7-8 years") ? 'selected' : ''; ?>>7-8 years</option>
                                        <option value="8-9 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "8-9 years") ? 'selected' : ''; ?>>8-9 years</option>
                                        <option value="9-10 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "9-10 years") ? 'selected' : ''; ?>>9-10 years</option>
                                        <option value="10-12 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "10-12 years") ? 'selected' : ''; ?>>10-12 years</option>
                                        <option value="12-14 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "12-14 years") ? 'selected' : ''; ?>>12-14 years</option>
                                        <option value="14-16 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "14-16 years") ? 'selected' : ''; ?>>14-16 years</option>
                                        <option value="XX-Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "XX-Small") ? 'selected' : ''; ?>>XX-Small</option>
                                        <option value="X-small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "X-Small") ? 'selected' : ''; ?>>X-small</option>
                                        <option value="Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Small") ? 'selected' : ''; ?>>Small</option>
                                        <option value="Medium" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Medium") ? 'selected' : ''; ?>>Medium</option>
                                        <option value="Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Large") ? 'selected' : ''; ?>>Large</option>
                                        <option value="X-Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "X-Large") ? 'selected' : ''; ?>>X-Large</option>
                                        <option value="XX-Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "XX-Large") ? 'selected' : ''; ?>>XX-Large</option>

                                        <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                    </select>
                                <?php else : ?>
                                    <?php foreach ($this->languages as $language) : ?>
                                        <?php if ($language->id == $this->selected_lang->id) : ?>
                                            <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                            <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                <option value="">Select an option</option>
                                                <option value="NewBorn" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "NewBorn") ? 'selected' : ''; ?>>NewBorn</option>
                                                <option value="0-3 months" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "0-3 months") ? 'selected' : ''; ?>>0-3 months</option>
                                                <option value="3-6 months" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "3-6 months") ? 'selected' : ''; ?>>3-6 months</option>
                                                <option value="6-9 months" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "6-9 months") ? 'selected' : ''; ?>>6-9 months</option>
                                                <option value="9-12 months" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "9-12 months") ? 'selected' : ''; ?>>9-12 months</option>
                                                <option value="12-18 months" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "12-18 months") ? 'selected' : ''; ?>>12-18 months</option>
                                                <option value="18-24 months" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "18-24 months") ? 'selected' : ''; ?>>18-24 months</option>
                                                <option value="2-3 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "2-3 years") ? 'selected' : ''; ?>>2-3 years</option>
                                                <option value="3-4 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "3-4 years") ? 'selected' : ''; ?>>3-4 years</option>
                                                <option value="4-5 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "4-5 years") ? 'selected' : ''; ?>>4-5 years</option>
                                                <option value="5-6 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "5-6 years") ? 'selected' : ''; ?>>5-6 years</option>
                                                <option value="6-7 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "6-7 years") ? 'selected' : ''; ?>>6-7 years</option>
                                                <option value="7-8 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "7-8 years") ? 'selected' : ''; ?>>7-8 years</option>
                                                <option value="8-9 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "8-9 years") ? 'selected' : ''; ?>>8-9 years</option>
                                                <option value="9-10 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "9-10 years") ? 'selected' : ''; ?>>9-10 years</option>
                                                <option value="10-12 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "10-12 years") ? 'selected' : ''; ?>>10-12 years</option>
                                                <option value="12-14 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "12-14 years") ? 'selected' : ''; ?>>12-14 years</option>
                                                <option value="14-16 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "14-16 years") ? 'selected' : ''; ?>>14-16 years</option>
                                                <option value="XX-Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "XX-Small") ? 'selected' : ''; ?>>XX-Small</option>
                                                <option value="X-small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "X-Small") ? 'selected' : ''; ?>>X-small</option>
                                                <option value="Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Small") ? 'selected' : ''; ?>>Small</option>
                                                <option value="Medium" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Medium") ? 'selected' : ''; ?>>Medium</option>
                                                <option value="Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Large") ? 'selected' : ''; ?>>Large</option>
                                                <option value="X-Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "X-Large") ? 'selected' : ''; ?>>X-Large</option>
                                                <option value="XX-Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "XX-Large") ? 'selected' : ''; ?>>XX-Large</option>
                                                <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        <?php else : ?>
                                            <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                            <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                <option value="">Select an option</option>
                                                <option value="NewBorn" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "NewBorn") ? 'selected' : ''; ?>>NewBorn</option>
                                                <option value="0-3 months" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "0-3 months") ? 'selected' : ''; ?>>0-3 months</option>
                                                <option value="3-6 months" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "3-6 months") ? 'selected' : ''; ?>>3-6 months</option>
                                                <option value="6-9 months" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "6-9 months") ? 'selected' : ''; ?>>6-9 months</option>
                                                <option value="9-12 months" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "9-12 months") ? 'selected' : ''; ?>>9-12 months</option>
                                                <option value="12-18 months" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "12-18 months") ? 'selected' : ''; ?>>12-18 months</option>
                                                <option value="18-24 months" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "18-24 months") ? 'selected' : ''; ?>>18-24 months</option>
                                                <option value="2-3 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "2-3 years") ? 'selected' : ''; ?>>2-3 years</option>
                                                <option value="3-4 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "3-4 years") ? 'selected' : ''; ?>>3-4 years</option>
                                                <option value="4-5 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "4-5 years") ? 'selected' : ''; ?>>4-5 years</option>
                                                <option value="5-6 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "5-6 years") ? 'selected' : ''; ?>>5-6 years</option>
                                                <option value="6-7 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "6-7 years") ? 'selected' : ''; ?>>6-7 years</option>
                                                <option value="7-8 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "7-8 years") ? 'selected' : ''; ?>>7-8 years</option>
                                                <option value="8-9 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "8-9 years") ? 'selected' : ''; ?>>8-9 years</option>
                                                <option value="9-10 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "9-10 years") ? 'selected' : ''; ?>>9-10 years</option>
                                                <option value="10-12 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "10-12 years") ? 'selected' : ''; ?>>10-12 years</option>
                                                <option value="12-14 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "12-14 years") ? 'selected' : ''; ?>>12-14 years</option>
                                                <option value="14-16 years" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "14-16 years") ? 'selected' : ''; ?>>14-16 years</option>
                                                <option value="XX-Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "XX-Small") ? 'selected' : ''; ?>>XX-Small</option>
                                                <option value="X-small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "X-Small") ? 'selected' : ''; ?>>X-small</option>
                                                <option value="Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Small") ? 'selected' : ''; ?>>Small</option>
                                                <option value="Medium" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Medium") ? 'selected' : ''; ?>>Medium</option>
                                                <option value="Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Large") ? 'selected' : ''; ?>>Large</option>
                                                <option value="X-Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "X-Large") ? 'selected' : ''; ?>>X-Large</option>
                                                <option value="XX-Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "XX-Large") ? 'selected' : ''; ?>>XX-Large</option>
                                                <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>



                    <?php elseif ($parent_categories_array[0]->id == 4 && $parent_categories_array[1]->id == 27 && $parent_categories_array[2]->id == 179) : ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo "Select size"; ?></label>

                            <?php if (!empty($this->languages)) : ?>
                                <?php if (count($this->languages) <= 1) : ?>
                                    <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                        <option value="">Select an option</option>
                                        <option value="King" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "King") ? 'selected' : ''; ?>>King</option>
                                        <option value="Queen" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Queen") ? 'selected' : ''; ?>>Queen</option>
                                        <option value="Standard" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Standard") ? 'selected' : ''; ?>>Standard</option>
                                        <option value="Square" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Square") ? 'selected' : ''; ?>>Square</option>
                                        <option value="12X12" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "12X12") ? 'selected' : ''; ?>>12X12</option>
                                        <option value="16X16" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "16X16") ? 'selected' : ''; ?>>16X16</option>
                                        <option value="18X18" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "18X18") ? 'selected' : ''; ?>>18X18</option>
                                        <option value="20X20" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "20X20") ? 'selected' : ''; ?>>20X20</option>
                                        <option value="24X24" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "24X24") ? 'selected' : ''; ?>>24X24</option>

                                        <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                    </select>
                                <?php else : ?>
                                    <?php foreach ($this->languages as $language) : ?>
                                        <?php if ($language->id == $this->selected_lang->id) : ?>
                                            <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                            <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                <option value="">Select an option</option>
                                                <option value="King" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "King") ? 'selected' : ''; ?>>King</option>
                                                <option value="Queen" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Queen") ? 'selected' : ''; ?>>Queen</option>
                                                <option value="Standard" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Standard") ? 'selected' : ''; ?>>Standard</option>
                                                <option value="Square" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Square") ? 'selected' : ''; ?>>Square</option>
                                                <option value="12X12" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "12X12") ? 'selected' : ''; ?>>12X12</option>
                                                <option value="16X16" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "16X16") ? 'selected' : ''; ?>>16X16</option>
                                                <option value="18X18" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "18X18") ? 'selected' : ''; ?>>18X18</option>
                                                <option value="20X20" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "20X20") ? 'selected' : ''; ?>>20X20</option>
                                                <option value="24X24" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "24X24") ? 'selected' : ''; ?>>24X24</option>

                                                <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        <?php else : ?>
                                            <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                            <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                <option value="">Select an option</option>
                                                <option value="King" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "King") ? 'selected' : ''; ?>>King</option>
                                                <option value="Queen" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Queen") ? 'selected' : ''; ?>>Queen</option>
                                                <option value="Standard" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Standard") ? 'selected' : ''; ?>>Standard</option>
                                                <option value="Square" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Square") ? 'selected' : ''; ?>>Square</option>
                                                <option value="12X12" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "12X12") ? 'selected' : ''; ?>>12X12</option>
                                                <option value="16X16" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "16X16") ? 'selected' : ''; ?>>16X16</option>
                                                <option value="18X18" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "18X18") ? 'selected' : ''; ?>>18X18</option>
                                                <option value="20X20" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "20X20") ? 'selected' : ''; ?>>20X20</option>
                                                <option value="24X24" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "24X24") ? 'selected' : ''; ?>>24X24</option>

                                                <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php elseif (($parent_categories_array[0]->id == 1 && ($parent_categories_array[1]->id == 9 || $parent_categories_array[1]->id == 10))) : ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo "Select size"; ?></label>

                            <?php if (!empty($this->languages)) : ?>
                                <?php if (count($this->languages) <= 1) : ?>
                                    <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                        <option value="">Select an option</option>
                                        <option value="XX-Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "XX-Small") ? 'selected' : ''; ?>>XX-Small</option>
                                        <option value="X-small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "X-Small") ? 'selected' : ''; ?>>X-small</option>
                                        <option value="Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Small") ? 'selected' : ''; ?>>Small</option>
                                        <option value="Medium" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Medium") ? 'selected' : ''; ?>>Medium</option>
                                        <option value="Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Large") ? 'selected' : ''; ?>>Large</option>
                                        <option value="X-Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "X-Large") ? 'selected' : ''; ?>>X-Large</option>
                                        <option value="XX-Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "XX-Large") ? 'selected' : ''; ?>>XX-Large</option>
                                        <option value="Free Size" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Free Size") ? 'selected' : ''; ?>>Free Size</option>
                                        <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                    </select>
                                <?php else : ?>
                                    <?php foreach ($this->languages as $language) : ?>
                                        <?php if ($language->id == $this->selected_lang->id) : ?>
                                            <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                            <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                <option value="">Select an option</option>
                                                <option value="XX-Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "XX-Small") ? 'selected' : ''; ?>>XX-Small</option>
                                                <option value="X-small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "X-Small") ? 'selected' : ''; ?>>X-small</option>
                                                <option value="Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Small") ? 'selected' : ''; ?>>Small</option>
                                                <option value="Medium" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Medium") ? 'selected' : ''; ?>>Medium</option>
                                                <option value="Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Large") ? 'selected' : ''; ?>>Large</option>
                                                <option value="X-Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "X-Large") ? 'selected' : ''; ?>>X-Large</option>
                                                <option value="XX-Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "XX-Large") ? 'selected' : ''; ?>>XX-Large</option>
                                                <option value="Free Size" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Free Size") ? 'selected' : ''; ?>>Free Size</option>
                                                <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        <?php else : ?>
                                            <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                            <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                <option value="">Select an option</option>
                                                <option value="XX-Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "XX-Small") ? 'selected' : ''; ?>>XX-Small</option>
                                                <option value="X-small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "X-Small") ? 'selected' : ''; ?>>X-small</option>
                                                <option value="Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Small") ? 'selected' : ''; ?>>Small</option>
                                                <option value="Medium" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Medium") ? 'selected' : ''; ?>>Medium</option>
                                                <option value="Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Large") ? 'selected' : ''; ?>>Large</option>
                                                <option value="X-Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "X-Large") ? 'selected' : ''; ?>>X-Large</option>
                                                <option value="XX-Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "XX-Large") ? 'selected' : ''; ?>>XX-Large</option>
                                                <option value="Free Size" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Free Size") ? 'selected' : ''; ?>>Free Size</option>
                                                <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>





                    <?php else : ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo "Select size"; ?></label>

                            <?php if (!empty($this->languages)) : ?>
                                <?php if (count($this->languages) <= 1) : ?>
                                    <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                        <option value="">Select an option</option>

                                        <option value="Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Small") ? 'selected' : ''; ?>>Small</option>
                                        <option value="Medium" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Medium") ? 'selected' : ''; ?>>Medium</option>
                                        <option value="Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Large") ? 'selected' : ''; ?>>Large</option>
                                        <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                    </select>
                                <?php else : ?>
                                    <?php foreach ($this->languages as $language) : ?>
                                        <?php if ($language->id == $this->selected_lang->id) : ?>
                                            <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                            <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                <option value="">Select an option</option>

                                                <option value="Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Small") ? 'selected' : ''; ?>>Small</option>
                                                <option value="Medium" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Medium") ? 'selected' : ''; ?>>Medium</option>
                                                <option value="Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Large") ? 'selected' : ''; ?>>Large</option>
                                                <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        <?php else : ?>
                                            <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                            <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                <option value="">Select an option</option>
                                                <option value="Small" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Small") ? 'selected' : ''; ?>>Small</option>
                                                <option value="Medium" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Medium") ? 'selected' : ''; ?>>Medium</option>
                                                <option value="Large" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Large") ? 'selected' : ''; ?>>Large</option>
                                                <option value="Others" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Others") ? 'selected' : ''; ?>>Others</option>
                                            </select>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php elseif (get_variation_label($variation->label_names, $this->selected_lang->id) == "weight") : ?>
                    <div class="form-group m-b-5">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label"><?php echo "Input Weight"; ?></label>
                                <?php if (!empty($this->languages)) : ?>
                                    <?php if (count($this->languages) <= 1) : ?>
                                        <input type="text" id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" value="<?php echo html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)); ?>" maxlength="255">
                                    <?php else : ?>
                                        <?php foreach ($this->languages as $language) : ?>
                                            <?php if ($language->id == $this->selected_lang->id) : ?>
                                                <input type="text" id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" value="<?php echo html_escape(get_variation_option_name($variation_option->option_names, $language->id)); ?>" placeholder="<?php echo $language->name; ?>" maxlength="255">
                                            <?php else : ?>
                                                <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" value="<?php echo html_escape(get_variation_option_name($variation_option->option_names, $language->id)); ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255">
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <!-- <div class="col-sm-2 pull-right btn-select-dropdown">
                                <label class="control-label">Weight Units</label>
                                <select name="weight_units" class="custom-select" required>
                                    <option value="">Select an option</option>
                                    <option value="Kgs" <?php echo ($variation_option->weight_units == "Kgs") ? 'selected' : ''; ?>>Kgs</option>
                                    <option value="Grams" <?php echo ($variation_option->weight_units == "Grams") ? 'selected' : ''; ?>>Grams</option>
                                    <option value="Pounds" <?php echo ($variation_option->weight_units == "Pounds") ? 'selected' : ''; ?>>Pounds</option>
                                    <option value="Lbs" <?php echo ($variation_option->weight_units == "Lbs") ? 'selected' : ''; ?>>Lbs</option>
                                    <option value="Litres" <?php echo ($variation_option->weight_units == "Litres") ? 'selected' : ''; ?>>Litres</option>
                                    <option value="millilitres" <?php echo ($variation_option->weight_units == "millilitres") ? 'selected' : ''; ?>>millilitres</option>
                                </select>
                            </div> -->
                        </div>
                    </div>
                <?php elseif (get_variation_label($variation->label_names, $this->selected_lang->id) == "packaging type") : ?>
                    <div class="form-group">
                        <label class="control-label"><?php echo "Select Packaging Type"; ?></label>

                        <?php if (!empty($this->languages)) : ?>
                            <?php if (count($this->languages) <= 1) : ?>
                                <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                    <option value="">Select an option</option>
                                    <option value="Glass bottle" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Glass bottle") ? 'selected' : ''; ?>>Glass bottle</option>
                                    <option value="Plastic bottle" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Plastic bottle") ? 'selected' : ''; ?>>Plastic bottle</option>
                                    <option value="Pouch" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Pouch") ? 'selected' : ''; ?>>Pouch</option>
                                    <option value="Tin" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Tin") ? 'selected' : ''; ?>>Tin</option>
                                    <option value="Carton Box" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Carton Box") ? 'selected' : ''; ?>>Carton Box</option>
                                    <option value="Festive Gift box" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Festive Gift box") ? 'selected' : ''; ?>>Festive Gift box</option>
                                    <option value="Can" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Can") ? 'selected' : ''; ?>>Can</option>
                                    <option value="Tetra pack" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)) == "Tetra pack") ? 'selected' : ''; ?>>Tetra pack</option>
                                </select>
                            <?php else : ?>
                                <?php foreach ($this->languages as $language) : ?>
                                    <?php if ($language->id == $this->selected_lang->id) : ?>
                                        <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                        <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                            <option value="">Select an option</option>
                                            <option value="Glass bottle" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Glass bottle") ? 'selected' : ''; ?>>Glass bottle</option>
                                            <option value="Plastic bottle" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Plastic bottle") ? 'selected' : ''; ?>>Plastic bottle</option>
                                            <option value="Pouch" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Pouch") ? 'selected' : ''; ?>>Pouch</option>
                                            <option value="Tin" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Tin") ? 'selected' : ''; ?>>Tin</option>
                                            <option value="Carton Box" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Carton Box") ? 'selected' : ''; ?>>Carton Box</option>
                                            <option value="Festive Gift box" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Festive Gift box") ? 'selected' : ''; ?>>Festive Gift box</option>
                                            <option value="Can" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Can") ? 'selected' : ''; ?>>Can</option>
                                            <option value="Tetra pack" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Tetra pack") ? 'selected' : ''; ?>>Tetra pack</option>
                                        </select>
                                    <?php else : ?>
                                        <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                        <select id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                            <option value="">Select an option</option>
                                            <option value="Glass bottle" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Glass bottle") ? 'selected' : ''; ?>>Glass bottle</option>
                                            <option value="Plastic bottle" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Plastic bottle") ? 'selected' : ''; ?>>Plastic bottle</option>
                                            <option value="Pouch" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Pouch") ? 'selected' : ''; ?>>Pouch</option>
                                            <option value="Tin" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Tin") ? 'selected' : ''; ?>>Tin</option>
                                            <option value="Carton Box" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Carton Box") ? 'selected' : ''; ?>>Carton Box</option>
                                            <option value="Festive Gift box" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Festive Gift box") ? 'selected' : ''; ?>>Festive Gift box</option>
                                            <option value="Can" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Can") ? 'selected' : ''; ?>>Can</option>
                                            <option value="Tetra pack" <?php echo (html_escape(get_variation_option_name($variation_option->option_names, $language->id)) == "Tetra pack") ? 'selected' : ''; ?>>Tetra pack</option>
                                        </select>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php elseif (get_variation_label($variation->label_names, $this->selected_lang->id) == "set of pieces") : ?>
                    <div class="form-group m-b-5">
                        <div class="col-sm-12">
                            <label class="control-label"><?php echo "Input set of pieces"; ?></label>
                            <?php if (!empty($this->languages)) : ?>
                                <?php if (count($this->languages) <= 1) : ?>
                                    <input type="text" id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" value="<?php echo html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)); ?>" maxlength="255">
                                <?php else : ?>
                                    <?php foreach ($this->languages as $language) : ?>
                                        <?php if ($language->id == $this->selected_lang->id) : ?>
                                            <input type="text" id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" value="<?php echo html_escape(get_variation_option_name($variation_option->option_names, $language->id)); ?>" placeholder="<?php echo $language->name; ?>" maxlength="255">
                                        <?php else : ?>
                                            <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" value="<?php echo html_escape(get_variation_option_name($variation_option->option_names, $language->id)); ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255">
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php elseif (get_variation_label($variation->label_names, $this->selected_lang->id) == "color") : ?>
                    <div class="form-group m-b-5">
                        <div class="col-sm-12">
                            <label class="control-label"><?php echo "Input color name"; ?></label>
                            <?php if (!empty($this->languages)) : ?>
                                <?php if (count($this->languages) <= 1) : ?>
                                    <input type="text" id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" value="<?php echo html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)); ?>" maxlength="255">
                                <?php else : ?>
                                    <?php foreach ($this->languages as $language) : ?>
                                        <?php if ($language->id == $this->selected_lang->id) : ?>
                                            <input type="text" id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" value="<?php echo html_escape(get_variation_option_name($variation_option->option_names, $language->id)); ?>" placeholder="<?php echo $language->name; ?>" maxlength="255">
                                        <?php else : ?>
                                            <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" value="<?php echo html_escape(get_variation_option_name($variation_option->option_names, $language->id)); ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255">
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else : ?>
                    <label class="control-label"><?php echo trans("option_name"); ?></label>
                    <?php if (!empty($this->languages)) : ?>
                        <?php if (count($this->languages) <= 1) : ?>
                            <input type="text" id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" value="<?php echo html_escape(get_variation_option_name($variation_option->option_names, $this->selected_lang->id)); ?>" maxlength="255">
                        <?php else : ?>
                            <?php foreach ($this->languages as $language) : ?>
                                <?php if ($language->id == $this->selected_lang->id) : ?>
                                    <input type="text" id="input_edit_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" value="<?php echo html_escape(get_variation_option_name($variation_option->option_names, $language->id)); ?>" placeholder="<?php echo $language->name; ?>" maxlength="255">
                                <?php else : ?>
                                    <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" value="<?php echo html_escape(get_variation_option_name($variation_option->option_names, $language->id)); ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (!empty($variation->parent_id != 0)) : ?>
                    <div class="form-group">
                        <label class="control-label"><?php echo trans('parent_option'); ?></label>
                        <select name="parent_id" class="form-control custom-select">
                            <?php if (!empty($parent_variation_options)) :
                                foreach ($parent_variation_options as $parent_option) : ?>
                                    <option value="<?php echo $parent_option->id; ?>" <?php echo ($parent_option->id == $variation_option->parent_id) ? "selected" : ""; ?>><?php echo html_escape(get_variation_option_name($parent_option->option_names, $this->selected_lang->id)); ?></option>
                            <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6 hide-if-default <?php echo ($variation_option->is_default == 1) ? "display-none" : ""; ?> <?php echo ($type_of_variation == "Made to order") ? "hideMe" : ""; ?>">
                            <label class="control-label"><?php echo trans('stock'); ?></label>
                            <input type="number" name="option_stock" class="form-control form-input" value="<?php echo $variation_option->stock; ?>" min="0">
                        </div>
                        <?php if ($variation->variation_type != "dropdown" && $variation->option_display_type == "color") : ?>
                            <div class="col-sm-6">
                                <label class="control-label"><?php echo trans('color'); ?>&nbsp;<small class="text-muted">(<?php echo trans("optional"); ?>)</small></label>
                                <div class="input-group colorpicker">
                                    <input type="text" class="form-control" name="option_color" maxlength="200" value="<?php echo html_escape($variation_option->color); ?>" placeholder="<?php echo trans('color'); ?>">
                                    <div class="input-group-addon">
                                        <i></i>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($variation->use_different_price == 1) : ?>
                    <div class="form-group hide-if-default <?php echo ($variation_option->is_default == 1) ? "display-none" : ""; ?>">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row align-items-center">
                                    <div class="col-sm-12">
                                        <label class="control-label"><?php echo trans("price"); ?></label>
                                        <div id="price_input_container_variation_edit" class="<?php echo ($variation_option->use_default_price == 1) ? 'display-none' : ''; ?>">
                                            <div class="input-group">
                                                <span class="input-group-addon"><?php echo get_currency($this->payment_settings->default_currency); ?></span>
                                                <input type="text" name="option_price" id="product_price_input_variation_edit" value="<?php echo get_price($variation_option->price, "input"); ?>" class="form-control form-input price-input validate-price-input m-0" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 m-t-10">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="use_default_price" id="checkbox_price_variation_edit" value="1" <?php echo ($variation_option->use_default_price == 1) ? 'checked' : ''; ?>>
                                            <label for="checkbox_price_variation_edit" class="custom-control-label"><?php echo trans("use_default_price"); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row align-items-center">
                                    <div class="col-sm-12">
                                        <label class="control-label"><?php echo trans("discount_rate"); ?></label>
                                        <div id="discount_input_container_variation_edit" class="<?php echo ($variation_option->no_discount == 1) ? 'display-none' : ''; ?>">
                                            <div class="input-group">
                                                <span class="input-group-addon">%</span>
                                                <input type="number" step="0.01" name="option_discount_rate" id="input_discount_rate_variation_edit" class="form-control form-input m-0" value="<?php echo $variation_option->discount_rate; ?>" min="0" max="99" placeholder="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 m-t-10">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="no_discount" id="checkbox_discount_rate_variation_edit" value="1" <?php echo ($variation_option->no_discount == 1) ? 'checked' : ''; ?>>
                                            <label for="checkbox_discount_rate_variation_edit" class="custom-control-label"><?php echo trans("no_discount"); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($variation->option_display_type == "image" || $variation->show_images_on_slider == 1) : ?>
                    <div class="form-group hide-if-default <?php echo ($variation_option->is_default == 1) ? "display-none" : ""; ?>">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label"><?php echo trans("images"); ?>&nbsp;<small class="text-muted">(<?php echo trans("optional"); ?>)</small></label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="dm-uploader-container">
                                            <div id="drag-and-drop-zone-variation-image" class="dm-uploader text-center">
                                                <p class="dm-upload-icon">
                                                    <i class="icon-upload"></i>
                                                </p>
                                                <p class="dm-upload-text"><?php echo trans("drag_drop_images_here"); ?>&nbsp;<span style="text-decoration: underline"><?php echo trans('browse_files'); ?></span></p>

                                                <a class='btn btn-md dm-btn-select-files'>
                                                    <input type="file" name="file" size="40" multiple="multiple">
                                                </a>
                                                <ul class="dm-uploaded-files" id="files-variation-image">
                                                    <?php if (!empty($variation_option_images)) :
                                                        foreach ($variation_option_images as $image) : ?>
                                                            <li class="media" id="uploaderFile<?php echo $image->id; ?>">
                                                                <img src="<?php echo get_variation_option_image_url($image); ?>" alt="">
                                                                <a href="javascript:void(0)" class="btn-img-delete btn-delete-variation-image" data-variation-id="<?php echo $variation->id; ?>" data-file-id="<?php echo $image->id; ?>">
                                                                    <i class="icon-close"></i>
                                                                </a>
                                                                <?php if ($image->is_main == 1) : ?>
                                                                    <a href="javascript:void(0)" class="btn btn-xs btn-success btn-is-image-main btn-set-variation-image-main"><?php echo trans("main"); ?></a>
                                                                <?php else : ?>
                                                                    <a href="javascript:void(0)" class="btn btn-xs btn-secondary btn-is-image-main btn-set-variation-image-main" data-file-id="<?php echo $image->id; ?>" data-option-id="<?php echo $image->variation_option_id; ?>"><?php echo trans("main"); ?></a>
                                                                <?php endif; ?>
                                                            </li>
                                                    <?php endforeach;
                                                    endif; ?>
                                                </ul>
                                                <input type="hidden" id="variation_option_id" value="<?php echo $variation_option->id ?>">
                                            </div>
                                        </div>

                                        <!-- File item template -->
                                        <script type="text/html" id="files-template-variation-image">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 hide-if-default <?php echo ($variation_option->is_default == 1) ? "display-none" : ""; ?>">
                            <label class="control-label"><?php echo trans("sku"); ?></label>
                            <input type="text" name="sku-variation" id="input_sku" class="form-control auth-form-input" placeholder="<?php echo trans("sku_desc"); ?>" value="<?php echo $variation_option->sku_code ?>" required>
                            <!-- <button type="button" class="btn btn-default btn-generate-option-sku" onclick="get_automated_SKU_option($(this))"><?= trans("generate"); ?></button> -->
                        </div>
                        <div class="col-sm-3 hide-if-default <?php echo ($variation_option->is_default == 1) ? "display-none" : ""; ?>">
                            <label class="control-label">Package Weight(in grams)<span class="Validation_error"> *</span></label>
                            <input type="number" name="package_weight" class="form-control auth-form-input" placeholder="Enter Product Weight After Packaging" value="<?php echo $variation_option->package_weight; ?>">
                            <div class="col-sm-6 pull-right btn-select-dropdown display-none" style="padding-right: 5px;">

                                <select name="package_weight_units" class="custom-select" required>
                                    <option value="Kgs" <?php echo ($variation_option->package_weight_units == "Kgs") ? 'selected' : ''; ?>>Kgs</option>
                                    <option value="Grams" <?php echo ($variation_option->package_weight_units == "Grams") ? 'selected' : ''; ?>>Grams</option>
                                    <option value="Pounds" <?php echo ($variation_option->package_weight_units == "Pounds") ? 'selected' : ''; ?>>Pounds</option>
                                    <option value="Lbs" <?php echo ($variation_option->package_weight_units == "Lbs") ? 'selected' : ''; ?>>Lbs</option>
                                    <option value="Litres" <?php echo ($variation_option->package_weight_units == "Litres") ? 'selected' : ''; ?>>Litres</option>
                                    <option value="millilitres" <?php echo ($variation_option->package_weight_units == "millilitres") ? 'selected' : ''; ?>>millilitres</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2 hide-if-default <?php echo ($variation_option->is_default == 1) ? "display-none" : ""; ?>">
                            <label class="control-label">Length (in cms)<span class="Validation_error"> *</span></label>
                            <input type="number" name="variation_packed_length" class="form-control auth-form-input" placeholder="Length (in cms)" value="<?php echo html_escape($variation_option->variation_packed_length); ?>" required>
                        </div>
                        <div class="col-sm-2 hide-if-default <?php echo ($variation_option->is_default == 1) ? "display-none" : ""; ?>">
                            <label class="control-label">Width (in cms)<span class="Validation_error"> *</span></label>
                            <input type="number" name="variation_packed_width" class="form-control auth-form-input" placeholder="Width (in cms)" value="<?php echo html_escape($variation_option->variation_packed_width); ?>" required>
                        </div>
                        <div class="col-sm-2 hide-if-default <?php echo ($variation_option->is_default == 1) ? "display-none" : ""; ?>">
                            <label class="control-label">Height (in cms)<span class="Validation_error"> *</span></label>
                            <input type="number" name="variation_packed_height" class="form-control auth-form-input" placeholder="Height (in cms)" value="<?php echo html_escape($variation_option->variation_packed_height); ?>" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row-custom">
            <button type="button" id="btn_edit_variation_option" class="btn btn-md btn-info color-white float-right">


                <div id="form-option-edit-text"> <?php echo trans("save_changes"); ?></div>
                <div id="sp-options-add" class="spinner spinner-btn-add-variation">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>

            </button>
        </div>
    </div>
</form>