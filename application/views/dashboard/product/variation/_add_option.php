<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<form id="form_add_product_variation_option" novalidate>
    <input type="hidden" name="variation_id" value="<?php echo $variation->id; ?>">
    <div class="modal-header">
        <h5 class="modal-title">Variation Details-Stock and Price<?php //echo trans("add_option"); 
                                                                    ?></h5>
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
            <div class="col-sm-12">
                <div class="variation-options-container">
                    <?php if (!empty($variation_options)) : ?>
                        <table class="table table-striped" style="background-color: #fdfdfda4;">
                            <thead>
                                <tr>
                                    <th scope="col">S.No.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col" <?php if (!empty($type_of_stock) && $type_of_stock == "Made to order") {
                                                        echo "class='hideMe'";
                                                    } ?>>Stock</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Discount</th>
                                    <th scope="col">SKU Code</th>
                                    <th scope="col">Package Weight(in grams)</th>
                                    <th scope="col">Package Length(in cm)</th>
                                    <th scope="col">Package Width(in cm)</th>
                                    <th scope="col">Package Height(in cm)</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1; ?>
                                <?php foreach ($variation_options as $option) : ?>
                                    <tr>
                                        <th scope="row"><?php echo $count; ?></th>
                                        <td><?php echo html_escape(get_variation_option_name($option->option_names, $this->selected_lang->id)); ?></td>
                                        <td <?php if (!empty($type_of_stock) && $type_of_stock == "Made to order") {
                                                echo "class='hideMe'";
                                            } ?> <?php if ($option->is_default) : echo "id='default_stock'";
                                                    endif; ?>><?php if (!$option->is_default) : echo $option->stock;
                                                                endif; ?></td>
                                        <td <?php if ($option->is_default) : echo "id='default_price'";
                                            elseif ($option->use_default_price) : echo "class='use_default_price'";
                                            endif; ?>><?php if (!$option->is_default) : echo get_price($option->price, "input");
                                                        endif; ?></td>
                                        <td <?php if ($option->is_default) : echo "id='default_discount'";
                                            endif; ?>><?php if (!$option->is_default) : echo $option->discount_rate;
                                                        endif; ?></td>
                                        <td><?php if (!$option->is_default) : echo $option->sku_code;
                                            else : echo $product->sku;
                                            endif; ?></td>
                                        <td <?php if ($option->is_default) : echo "id='default_package_weight'";
                                            endif; ?>><?php if (!$option->is_default) : echo $option->package_weight;
                                                        endif; ?></td>
                                        <td <?php if ($option->is_default) : echo "id='default_package_length'";
                                            endif; ?>><?php if (!$option->is_default) : echo $option->variation_packed_length;
                                                        endif; ?></td>
                                        <td <?php if ($option->is_default) : echo "id='default_package_width'";
                                            endif; ?>><?php if (!$option->is_default) : echo $option->variation_packed_width;
                                                        endif; ?></td>
                                        <td <?php if ($option->is_default) : echo "id='default_package_height'";
                                            endif; ?>><?php if (!$option->is_default) : echo $option->variation_packed_height;
                                                        endif; ?></td>

                                        <td><button type="button" class="btn btn-sm btn-default btn-variation-table" onclick='edit_product_variation_option("<?php echo $variation->id; ?>","<?php echo $option->id; ?>");'><i class="icon-edit"></i><?php echo trans('edit'); ?></button>
                                            <button type="button" class="btn btn-sm btn-danger btn-variation-table" onclick='delete_product_variation_option("<?php echo $variation->id; ?>","<?php echo $option->id; ?>","<?php echo trans("confirm_delete"); ?>");'><i class="icon-trash"></i><?php echo trans('delete'); ?></button>
                                        </td>
                                    </tr>
                                    <?php $count++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    <?php else : ?>
                        <p class="text-muted text-center m-t-15"> <?php echo trans("no_records_found"); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 box-variation-options">
                <?php if (!empty($variation->parent_id == 0)) : ?>
                    <div class="form-group m-b-5">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label"><?php echo trans('default_option'); ?>&nbsp;<small class="text-muted">(<?php echo trans('default_option_exp'); ?>)</small></label>
                            </div>
                            <div class="col-md-6 col-sm-12 col-custom-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="is_default" value="1" id="is_default_1" class="custom-control-input">
                                    <label for="is_default_1" class="custom-control-label"><?php echo trans("yes"); ?></label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-custom-option">
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="is_default" value="0" id="is_default_2" class="custom-control-input" checked>
                                    <label for="is_default_2" class="custom-control-label"><?php echo trans("no"); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- <div class="form-group m-b-5">
                    <label class="control-label"><?php echo trans("option_name"); ?></label>
                    <?php if (!empty($this->languages)) : ?>
                        <?php if (count($this->languages) <= 1) : ?>
                            <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" maxlength="255">
                        <?php else : ?>
                            <?php foreach ($this->languages as $language) : ?>
                                <?php if ($language->id == $this->selected_lang->id) : ?>
                                    <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255">
                                <?php else : ?>
                                    <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div> -->
                <div class="form-group">
                    <div class="row">

                        <div class="col-sm-3">
                            <?php if (get_variation_label($variation->label_names, $this->selected_lang->id) == "size" || get_variation_label($variation->label_names, $this->selected_lang->id) == "portion size") : ?>

                                <?php if ($product->category_id == 71) : ?>

                                    <label class="control-label"><?php echo "Select Size"; ?></label>

                                    <?php if (!empty($this->languages)) : ?>
                                        <?php if (count($this->languages) <= 1) : ?>
                                            <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                                <option value="">Select an option</option>
                                                <option value="6 yards">6 yards</option>
                                                <option value="9 yards">9 yards</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        <?php else : ?>
                                            <?php foreach ($this->languages as $language) : ?>
                                                <?php if ($language->id == $this->selected_lang->id) : ?>
                                                    <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                                    <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                        <option value="">Select an option</option>
                                                        <option value="6 yards">6 yards</option>
                                                        <option value="9 yards">9 yards</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php else : ?>
                                                    <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                                    <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                        <option value="">Select an option</option>
                                                        <option value="6 yards">6 yards</option>
                                                        <option value="9 yards">9 yards</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php elseif ($product->category_id == 174 || $product->category_id == 175 || $product->category_id == 174 || $product->category_id == 175 || $product->category_id == 178) : ?>

                                    <label class="control-label"><?php echo "Select Size"; ?></label>

                                    <?php if (!empty($this->languages)) : ?>
                                        <?php if (count($this->languages) <= 1) : ?>
                                            <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                                <option value="">Select an option</option>
                                                <option value="Queen">Queen</option>
                                                <option value="King">King</option>
                                                <option value="Super-King">Super-King</option>
                                                <option value="Single">Single</option>
                                                <option value="Single Pair">Single Pair</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        <?php else : ?>
                                            <?php foreach ($this->languages as $language) : ?>
                                                <?php if ($language->id == $this->selected_lang->id) : ?>
                                                    <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                                    <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                        <option value="">Select an option</option>
                                                        <option value="Queen">Queen</option>
                                                        <option value="King">King</option>
                                                        <option value="Super-King">Super-King</option>
                                                        <option value="Single">Single</option>
                                                        <option value="Single Pair">Single Pair</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php else : ?>
                                                    <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                                    <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                        <option value="">Select an option</option>
                                                        <option value="Queen">Queen</option>
                                                        <option value="King">King</option>
                                                        <option value="Super-King">Super-King</option>
                                                        <option value="Single">Single</option>
                                                        <option value="Single Pair">Single Pair</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php elseif ($parent_categories_array[0]->id == 1 && $parent_categories_array[1]->id == 14) : ?>

                                    <label class="control-label"><?php echo "Select Size"; ?></label>

                                    <?php if (!empty($this->languages)) : ?>
                                        <?php if (count($this->languages) <= 1) : ?>
                                            <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                                <option value="">Select an option</option>
                                                <option value="0">0</option>
                                                <option value="0.5">0.5</option>
                                                <option value="1">1</option>
                                                <option value="1.5">1.5</option>
                                                <option value="2">2</option>
                                                <option value="2.5">2.5</option>
                                                <option value="3">3</option>
                                                <option value="3.5">3.5</option>
                                                <option value="4">4</option>
                                                <option value="4.5">4.5</option>
                                                <option value="5">5</option>
                                                <option value="5.5">5.5</option>
                                                <option value="6">6</option>
                                                <option value="6.5">6.5</option>
                                                <option value="7">7</option>
                                                <option value="7.5">7.5</option>
                                                <option value="8">8</option>
                                                <option value="8.5">8.5</option>
                                                <option value="9">9</option>
                                                <option value="9.5">9.5</option>
                                                <option value="10">10</option>
                                                <option value="10.5">10.5</option>
                                                <option value="11">11</option>
                                                <option value="11.5">11.5</option>
                                                <option value="12">12</option>
                                                <option value="12.5">12.5</option>
                                                <option value="13">13</option>
                                                <option value="13.5">13.5</option>
                                                <option value="14">14</option>
                                                <option value="14.5">14.5</option>
                                                <option value="15">15</option>
                                                <option value="15.5">15.5</option>
                                                <option value="16">16</option>
                                                <option value="16.5">16.5</option>
                                                <option value="17">17</option>
                                                <option value="17.5">17.5</option>
                                                <option value="18">18</option>
                                                <option value="18.5">18.5</option>
                                                <option value="19">19</option>
                                                <option value="19.5">19.5</option>
                                                <option value="20">20</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        <?php else : ?>
                                            <?php foreach ($this->languages as $language) : ?>
                                                <?php if ($language->id == $this->selected_lang->id) : ?>
                                                    <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                                    <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                        <option value="">Select an option</option>
                                                        <option value="0">0</option>
                                                        <option value="0.5">0.5</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1.5</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2.5</option>
                                                        <option value="3">3</option>
                                                        <option value="3.5">3.5</option>
                                                        <option value="4">4</option>
                                                        <option value="4.5">4.5</option>
                                                        <option value="5">5</option>
                                                        <option value="5.5">5.5</option>
                                                        <option value="6">6</option>
                                                        <option value="6.5">6.5</option>
                                                        <option value="7">7</option>
                                                        <option value="7.5">7.5</option>
                                                        <option value="8">8</option>
                                                        <option value="8.5">8.5</option>
                                                        <option value="9">9</option>
                                                        <option value="9.5">9.5</option>
                                                        <option value="10">10</option>
                                                        <option value="10.5">10.5</option>
                                                        <option value="11">11</option>
                                                        <option value="11.5">11.5</option>
                                                        <option value="12">12</option>
                                                        <option value="12.5">12.5</option>
                                                        <option value="13">13</option>
                                                        <option value="13.5">13.5</option>
                                                        <option value="14">14</option>
                                                        <option value="14.5">14.5</option>
                                                        <option value="15">15</option>
                                                        <option value="15.5">15.5</option>
                                                        <option value="16">16</option>
                                                        <option value="16.5">16.5</option>
                                                        <option value="17">17</option>
                                                        <option value="17.5">17.5</option>
                                                        <option value="18">18</option>
                                                        <option value="18.5">18.5</option>
                                                        <option value="19">19</option>
                                                        <option value="19.5">19.5</option>
                                                        <option value="20">20</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php else : ?>
                                                    <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                                    <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                        <option value="">Select an option</option>
                                                        <option value="0">0</option>
                                                        <option value="0.5">0.5</option>
                                                        <option value="1">1</option>
                                                        <option value="1.5">1.5</option>
                                                        <option value="2">2</option>
                                                        <option value="2.5">2.5</option>
                                                        <option value="3">3</option>
                                                        <option value="3.5">3.5</option>
                                                        <option value="4">4</option>
                                                        <option value="4.5">4.5</option>
                                                        <option value="5">5</option>
                                                        <option value="5.5">5.5</option>
                                                        <option value="6">6</option>
                                                        <option value="6.5">6.5</option>
                                                        <option value="7">7</option>
                                                        <option value="7.5">7.5</option>
                                                        <option value="8">8</option>
                                                        <option value="8.5">8.5</option>
                                                        <option value="9">9</option>
                                                        <option value="9.5">9.5</option>
                                                        <option value="10">10</option>
                                                        <option value="10.5">10.5</option>
                                                        <option value="11">11</option>
                                                        <option value="11.5">11.5</option>
                                                        <option value="12">12</option>
                                                        <option value="12.5">12.5</option>
                                                        <option value="13">13</option>
                                                        <option value="13.5">13.5</option>
                                                        <option value="14">14</option>
                                                        <option value="14.5">14.5</option>
                                                        <option value="15">15</option>
                                                        <option value="15.5">15.5</option>
                                                        <option value="16">16</option>
                                                        <option value="16.5">16.5</option>
                                                        <option value="17">17</option>
                                                        <option value="17.5">17.5</option>
                                                        <option value="18">18</option>
                                                        <option value="18.5">18.5</option>
                                                        <option value="19">19</option>
                                                        <option value="19.5">19.5</option>
                                                        <option value="20">20</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                <?php elseif (($parent_categories_array[0]->id == 1 && $parent_categories_array[1]->id == 11) || ($parent_categories_array[0]->id == 1 && $parent_categories_array[1]->id == 12) || ($parent_categories_array[0]->id == 7 && $parent_categories_array[1]->id == 55) || $parent_categories_array[0]->id == 3 || ($parent_categories_array[0]->id == 7 && $parent_categories_array[1]->id == 57) || ($parent_categories_array[0]->id == 5 && $parent_categories_array[1]->id != 37) || $parent_categories_array[0]->id == 3) : ?>

                                    <label class="control-label"><?php echo "Select Size"; ?></label>

                                    <?php if (!empty($this->languages)) : ?>
                                        <?php if (count($this->languages) <= 1) : ?>
                                            <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                                <option value="">Select an option</option>
                                                <option value="Small">Small</option>
                                                <option value="Medium">Medium</option>
                                                <option value="Large">Large</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        <?php else : ?>
                                            <?php foreach ($this->languages as $language) : ?>
                                                <?php if ($language->id == $this->selected_lang->id) : ?>
                                                    <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                                    <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                        <option value="">Select an option</option>
                                                        <option value="Small">Small</option>
                                                        <option value="Medium">Medium</option>
                                                        <option value="Large">Large</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php else : ?>
                                                    <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                                    <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                        <option value="">Select an option</option>
                                                        <option value="Small">Small</option>
                                                        <option value="Medium">Medium</option>
                                                        <option value="Large">Large</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php elseif ($parent_categories_array[0]->id == 5 && $parent_categories_array[1]->id == 37) : ?>

                                    <label class="control-label"><?php echo "Select Size"; ?></label>

                                    <?php if (!empty($this->languages)) : ?>
                                        <?php if (count($this->languages) <= 1) : ?>
                                            <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                                <option value="">Select an option</option>
                                                <option value="XX-Small">XX-Small</option>
                                                <option value="X-small">X-small</option>
                                                <option value="Small">Small</option>
                                                <option value="Medium">Medium</option>
                                                <option value="Large">Large</option>
                                                <option value="X-Large">X-Large</option>
                                                <option value="XX-Large">XX-Large</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        <?php else : ?>
                                            <?php foreach ($this->languages as $language) : ?>
                                                <?php if ($language->id == $this->selected_lang->id) : ?>
                                                    <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                                    <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                        <option value="">Select an option</option>
                                                        <option value="XX-Small">XX-Small</option>
                                                        <option value="X-small">X-small</option>
                                                        <option value="Small">Small</option>
                                                        <option value="Medium">Medium</option>
                                                        <option value="Large">Large</option>
                                                        <option value="X-Large">X-Large</option>
                                                        <option value="XX-Large">XX-Large</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php else : ?>
                                                    <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                                    <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                        <option value="">Select an option</option>
                                                        <option value="XX-Small">XX-Small</option>
                                                        <option value="X-small">X-small</option>
                                                        <option value="Small">Small</option>
                                                        <option value="Medium">Medium</option>
                                                        <option value="Large">Large</option>
                                                        <option value="X-Large">X-Large</option>
                                                        <option value="XX-Large">XX-Large</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php elseif ($parent_categories_array[0]->id == 2) : ?>

                                    <label class="control-label"><?php echo "Select Portion Size"; ?></label>

                                    <?php if (!empty($this->languages)) : ?>
                                        <?php if (count($this->languages) <= 1) : ?>
                                            <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                                <option value="">Select an option</option>
                                                <option value="Serves 1">Serves 1</option>
                                                <option value="1-2 people">1-2 people</option>
                                                <option value="2-3 people">2-3 people</option>
                                                <option value="3-4 people">3-4 people</option>
                                                <option value="4-5 people">4-5 people</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        <?php else : ?>
                                            <?php foreach ($this->languages as $language) : ?>
                                                <?php if ($language->id == $this->selected_lang->id) : ?>
                                                    <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                                    <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                        <option value="">Select an option</option>
                                                        <option value="Serves 1">Serves 1</option>
                                                        <option value="1-2 people">1-2 people</option>
                                                        <option value="2-3 people">2-3 people</option>
                                                        <option value="3-4 people">3-4 people</option>
                                                        <option value="4-5 people">4-5 people</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php else : ?>
                                                    <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                                    <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                        <option value="">Select an option</option>
                                                        <option value="Serves 1">Serves 1</option>
                                                        <option value="1-2 people">1-2 people</option>
                                                        <option value="2-3 people">2-3 people</option>
                                                        <option value="3-4 people">3-4 people</option>
                                                        <option value="4-5 people">4-5 people</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php elseif (($parent_categories_array[0]->id == 6 && $parent_categories_array[1]->id == 38) || ($parent_categories_array[0]->id == 6 && $parent_categories_array[1]->id == 41 && $parent_categories_array[2]->id == 265)) : ?>

                                    <label class="control-label"><?php echo "Select Size"; ?></label>

                                    <?php if (!empty($this->languages)) : ?>
                                        <?php if (count($this->languages) <= 1) : ?>
                                            <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                                <option value="">Select an option</option>
                                                <option value="NewBorn">NewBorn</option>
                                                <option value="0-3 months">0-3 months</option>
                                                <option value="3-6 months">3-6 months</option>
                                                <option value="6-9 months">6-9 months</option>
                                                <option value="9-12 months">9-12 months</option>
                                                <option value="12-18 months">12-18 months</option>
                                                <option value="18-24 months">18-24 months</option>
                                                <option value="2-3 years">2-3 years</option>
                                                <option value="3-4 years">3-4 years</option>
                                                <option value="4-5 years">4-5 years</option>
                                                <option value="5-6 years">5-6 years</option>
                                                <option value="6-7 years">6-7 years</option>
                                                <option value="7-8 years">7-8 years</option>
                                                <option value="8-9 years">8-9 years</option>
                                                <option value="9-10 years">9-10 years</option>
                                                <option value="10-12 years">10-12 years</option>
                                                <option value="12-14 years">12-14 years</option>
                                                <option value="14-16 years">14-16 years</option>
                                                <option value="XX-Small">XX-Small</option>
                                                <option value="X-small">X-small</option>
                                                <option value="Small">Small</option>
                                                <option value="Medium">Medium</option>
                                                <option value="Large">Large</option>
                                                <option value="X-Large">X-Large</option>
                                                <option value="XX-Large">XX-Large</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        <?php else : ?>
                                            <?php foreach ($this->languages as $language) : ?>
                                                <?php if ($language->id == $this->selected_lang->id) : ?>
                                                    <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                                    <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                        <option value="">Select an option</option>
                                                        <option value="NewBorn">NewBorn</option>
                                                        <option value="0-3 months">0-3 months</option>
                                                        <option value="3-6 months">3-6 months</option>
                                                        <option value="6-9 months">6-9 months</option>
                                                        <option value="9-12 months">9-12 months</option>
                                                        <option value="12-18 months">12-18 months</option>
                                                        <option value="18-24 months">18-24 months</option>
                                                        <option value="2-3 years">2-3 years</option>
                                                        <option value="3-4 years">3-4 years</option>
                                                        <option value="4-5 years">4-5 years</option>
                                                        <option value="5-6 years">5-6 years</option>
                                                        <option value="6-7 years">6-7 years</option>
                                                        <option value="7-8 years">7-8 years</option>
                                                        <option value="8-9 years">8-9 years</option>
                                                        <option value="9-10 years">9-10 years</option>
                                                        <option value="10-12 years">10-12 years</option>
                                                        <option value="12-14 years">12-14 years</option>
                                                        <option value="14-16 years">14-16 years</option>
                                                        <option value="XX-Small">XX-Small</option>
                                                        <option value="X-small">X-small</option>
                                                        <option value="Small">Small</option>
                                                        <option value="Medium">Medium</option>
                                                        <option value="Large">Large</option>
                                                        <option value="X-Large">X-Large</option>
                                                        <option value="XX-Large">XX-Large</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php else : ?>
                                                    <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                                    <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                        <option value="">Select an option</option>
                                                        <option value="NewBorn">NewBorn</option>
                                                        <option value="0-3 months">0-3 months</option>
                                                        <option value="3-6 months">3-6 months</option>
                                                        <option value="6-9 months">6-9 months</option>
                                                        <option value="9-12 months">9-12 months</option>
                                                        <option value="12-18 months">12-18 months</option>
                                                        <option value="18-24 months">18-24 months</option>
                                                        <option value="2-3 years">2-3 years</option>
                                                        <option value="3-4 years">3-4 years</option>
                                                        <option value="4-5 years">4-5 years</option>
                                                        <option value="5-6 years">5-6 years</option>
                                                        <option value="6-7 years">6-7 years</option>
                                                        <option value="7-8 years">7-8 years</option>
                                                        <option value="8-9 years">8-9 years</option>
                                                        <option value="9-10 years">9-10 years</option>
                                                        <option value="10-12 years">10-12 years</option>
                                                        <option value="12-14 years">12-14 years</option>
                                                        <option value="14-16 years">14-16 years</option>
                                                        <option value="XX-Small">XX-Small</option>
                                                        <option value="X-small">X-small</option>
                                                        <option value="Small">Small</option>
                                                        <option value="Medium">Medium</option>
                                                        <option value="Large">Large</option>
                                                        <option value="X-Large">X-Large</option>
                                                        <option value="XX-Large">XX-Large</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php elseif ($parent_categories_array[0]->id == 4 && $parent_categories_array[1]->id == 27 && $parent_categories_array[2]->id == 179) : ?>

                                    <label class="control-label"><?php echo "Select Size"; ?></label>

                                    <?php if (!empty($this->languages)) : ?>
                                        <?php if (count($this->languages) <= 1) : ?>
                                            <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                                <option value="">Select an option</option>
                                                <option value="King">King</option>
                                                <option value="Queen">Queen</option>
                                                <option value="Standard">Standard</option>
                                                <option value="Square">Square</option>
                                                <option value="12X12">12X12</option>
                                                <option value="16X16">16X16</option>
                                                <option value="18X18">18X18</option>
                                                <option value="20X20">20X20</option>
                                                <option value="24X24">24X24</option>

                                                <option value="Others">Others</option>
                                            </select>
                                        <?php else : ?>
                                            <?php foreach ($this->languages as $language) : ?>
                                                <?php if ($language->id == $this->selected_lang->id) : ?>
                                                    <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                                    <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                        <option value="">Select an option</option>
                                                        <option value="King">King</option>
                                                        <option value="Queen">Queen</option>
                                                        <option value="Standard">Standard</option>
                                                        <option value="Square">Square</option>
                                                        <option value="12X12">12X12</option>
                                                        <option value="16X16">16X16</option>
                                                        <option value="18X18">18X18</option>
                                                        <option value="20X20">20X20</option>
                                                        <option value="24X24">24X24</option>

                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php else : ?>
                                                    <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                                    <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                        <option value="">Select an option</option>
                                                        <option value="King">King</option>
                                                        <option value="Queen">Queen</option>
                                                        <option value="Standard">Standard</option>
                                                        <option value="Square">Square</option>
                                                        <option value="12X12">12X12</option>
                                                        <option value="16X16">16X16</option>
                                                        <option value="18X18">18X18</option>
                                                        <option value="20X20">20X20</option>
                                                        <option value="24X24">24X24</option>

                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php elseif (($parent_categories_array[0]->id == 1 && ($parent_categories_array[1]->id == 9 || $parent_categories_array[1]->id == 10))) : ?>

                                    <label class="control-label"><?php echo "Select Size"; ?></label>

                                    <?php if (!empty($this->languages)) : ?>
                                        <?php if (count($this->languages) <= 1) : ?>
                                            <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                                <option value="">Select an option</option>
                                                <option value="XX-Small">XX-Small</option>
                                                <option value="X-small">X-small</option>
                                                <option value="Small">Small</option>
                                                <option value="Medium">Medium</option>
                                                <option value="Large">Large</option>
                                                <option value="X-Large">X-Large</option>
                                                <option value="XX-Large">XX-Large</option>
                                                <option value="Free Size">Free Size</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        <?php else : ?>
                                            <?php foreach ($this->languages as $language) : ?>
                                                <?php if ($language->id == $this->selected_lang->id) : ?>
                                                    <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                                    <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                        <option value="">Select an option</option>
                                                        <option value="XX-Small">XX-Small</option>
                                                        <option value="X-small">X-small</option>
                                                        <option value="Small">Small</option>
                                                        <option value="Medium">Medium</option>
                                                        <option value="Large">Large</option>
                                                        <option value="X-Large">X-Large</option>
                                                        <option value="XX-Large">XX-Large</option>
                                                        <option value="Free Size">Free Size</option>


                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php else : ?>
                                                    <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                                    <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                        <option value="">Select an option</option>
                                                        <option value="XX-Small">XX-Small</option>
                                                        <option value="X-small">X-small</option>
                                                        <option value="Small">Small</option>
                                                        <option value="Medium">Medium</option>
                                                        <option value="Large">Large</option>
                                                        <option value="X-Large">X-Large</option>
                                                        <option value="XX-Large">XX-Large</option>
                                                        <option value="Free Size">Free Size</option>


                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php else : ?>

                                    <label class="control-label"><?php echo "Select Size"; ?></label>

                                    <?php if (!empty($this->languages)) : ?>
                                        <?php if (count($this->languages) <= 1) : ?>
                                            <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                                <option value="">Select an option</option>
                                                <option value="Small">Small</option>
                                                <option value="Medium">Medium</option>
                                                <option value="Large">Large</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        <?php else : ?>
                                            <?php foreach ($this->languages as $language) : ?>
                                                <?php if ($language->id == $this->selected_lang->id) : ?>
                                                    <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                                    <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                        <option value="">Select an option</option>
                                                        <option value="Small">Small</option>
                                                        <option value="Medium">Medium</option>
                                                        <option value="Large">Large</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php else : ?>
                                                    <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                                    <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                        <option value="">Select an option</option>
                                                        <option value="Small">Small</option>
                                                        <option value="Medium">Medium</option>
                                                        <option value="Large">Large</option>
                                                        <option value="Others">Others</option>
                                                    </select>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>





                            <?php elseif (get_variation_label($variation->label_names, $this->selected_lang->id) == "weight") : ?>


                                <label class="control-label"><?php echo "Input Weight"; ?></label>
                                <?php if (!empty($this->languages)) : ?>
                                    <?php if (count($this->languages) <= 1) : ?>
                                        <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" maxlength="255">
                                    <?php else : ?>
                                        <?php foreach ($this->languages as $language) : ?>
                                            <?php if ($language->id == $this->selected_lang->id) : ?>
                                                <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255">
                                            <?php else : ?>
                                                <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255">
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endif; ?>


                                <!-- <div class="col-sm-6 pull-right btn-select-dropdown" style="padding-right: 5px;">

                                    <select name="weight_units" class="custom-select" required>

                                        <option value="Kgs">Kgs</option>
                                        <option value="Grams">Grams</option>
                                        <option value="Pounds">Pounds</option>
                                        <option value="Lbs">Lbs</option>
                                        <option value="Litres">Litres</option>
                                        <option value="millilitres">millilitres</option>
                                    </select>
                                </div> -->

                            <?php elseif (get_variation_label($variation->label_names, $this->selected_lang->id) == "packaging type") : ?>

                                <label class="control-label"><?php echo "Select Packaging Type"; ?></label>

                                <?php if (!empty($this->languages)) : ?>
                                    <?php if (count($this->languages) <= 1) : ?>
                                        <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" class="form-control custom-select" required>
                                            <option value="">Select an option</option>
                                            <option value="Glass bottle">Glass bottle</option>
                                            <option value="Plastic bottle">Plastic bottle</option>
                                            <option value="Pouch">Pouch</option>
                                            <option value="Tin">Tin</option>
                                            <option value="Carton Box">Carton Box</option>
                                            <option value="Festive Gift box">Festive Gift box</option>
                                            <option value="Can">Can</option>
                                            <option value="Tetra pack">Tetra pack</option>
                                        </select>
                                    <?php else : ?>
                                        <?php foreach ($this->languages as $language) : ?>
                                            <?php if ($language->id == $this->selected_lang->id) : ?>
                                                <!-- <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255"> -->
                                                <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                    <option value="">Select an option</option>
                                                    <option value="Glass bottle">Glass bottle</option>
                                                    <option value="Plastic bottle">Plastic bottle</option>
                                                    <option value="Pouch">Pouch</option>
                                                    <option value="Tin">Tin</option>
                                                    <option value="Carton Box">Carton Box</option>
                                                    <option value="Festive Gift box">Festive Gift box</option>
                                                    <option value="Can">Can</option>
                                                    <option value="Tetra pack">Tetra pack</option>
                                                </select>
                                            <?php else : ?>
                                                <!-- <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255"> -->
                                                <select id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" required>
                                                    <option value="">Select an option</option>
                                                    <option value="Glass bottle">Glass bottle</option>
                                                    <option value="Plastic bottle">Plastic bottle</option>
                                                    <option value="Pouch">Pouch</option>
                                                    <option value="Tin">Tin</option>
                                                    <option value="Carton Box">Carton Box</option>
                                                    <option value="Festive Gift box">Festive Gift box</option>
                                                    <option value="Can">Can</option>
                                                    <option value="Tetra pack">Tetra pack</option>
                                                </select>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endif; ?>

                            <?php elseif (get_variation_label($variation->label_names, $this->selected_lang->id) == "set of pieces") : ?>

                                <label class="control-label">Input set of pieces</label>
                                <?php if (!empty($this->languages)) : ?>
                                    <?php if (count($this->languages) <= 1) : ?>
                                        <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" maxlength="255">
                                    <?php else : ?>
                                        <?php foreach ($this->languages as $language) : ?>
                                            <?php if ($language->id == $this->selected_lang->id) : ?>
                                                <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255">
                                            <?php else : ?>
                                                <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255">
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endif; ?>

                            <?php elseif (get_variation_label($variation->label_names, $this->selected_lang->id) == "color") : ?>

                                <label class="control-label">Input color name</label>
                                <?php if (!empty($this->languages)) : ?>
                                    <?php if (count($this->languages) <= 1) : ?>
                                        <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" maxlength="255">
                                    <?php else : ?>
                                        <?php foreach ($this->languages as $language) : ?>
                                            <?php if ($language->id == $this->selected_lang->id) : ?>
                                                <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255">
                                            <?php else : ?>
                                                <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255">
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endif; ?>

                            <?php else : ?>

                                <label class="control-label"><?php echo trans("option_name"); ?></label>
                                <?php if (!empty($this->languages)) : ?>
                                    <?php if (count($this->languages) <= 1) : ?>
                                        <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $this->selected_lang->id; ?>" maxlength="255">
                                    <?php else : ?>
                                        <?php foreach ($this->languages as $language) : ?>
                                            <?php if ($language->id == $this->selected_lang->id) : ?>
                                                <input type="text" id="input_variation_option_name" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name; ?>" maxlength="255">
                                            <?php else : ?>
                                                <input type="text" class="form-control form-input input-variation-option" name="option_name_<?php echo $language->id; ?>" placeholder="<?php echo $language->name . ' (' . trans("optional") . ')'; ?>" maxlength="255">
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endif; ?>

                            <?php endif; ?>
                        </div>

                        <?php if (!empty($variation->parent_id != 0)) : ?>

                            <label class="control-label"><?php echo trans('parent_option'); ?></label>
                            <select name="parent_id" class="form-control custom-select">
                                <?php if (!empty($parent_variation_options)) :
                                    foreach ($parent_variation_options as $parent_option) : ?>
                                        <option value="<?php echo $parent_option->id; ?>"><?php echo html_escape(get_variation_option_name($parent_option->option_names, $this->selected_lang->id)); ?></option>
                                <?php endforeach;
                                endif; ?>
                            </select>

                        <?php endif; ?>


                        <div class="col-sm-3 hide-if-default <?php if (!empty($type_of_stock) && $type_of_stock == "Made to order") {
                                                                    echo "hideMe";
                                                                } ?>">
                            <label class="control-label"><?php echo trans('stock'); ?></label>
                            <input type="number" name="option_stock" class="form-control form-input" value="1" min="0">
                        </div>
                        <?php if ($variation->variation_type != "dropdown" && $variation->option_display_type == "color") : ?>
                            <div class="col-sm-2">
                                <label class="control-label"><?php echo trans('color'); ?>&nbsp;</label>
                                <div class="input-group colorpicker">
                                    <input type="text" class="form-control" id="option_color" name="option_color" maxlength="200" placeholder="<?php echo trans('color'); ?>">
                                    <div class="input-group-addon">
                                        <i></i>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>



                        <?php if ($variation->use_different_price == 1) : ?>


                            <div class="col-sm-2 hide-if-default">
                                <div class="row align-items-center">
                                    <div class="col-sm-12">
                                        <label class="control-label"><?php echo trans("price"); ?><span class="Validation_error"> *</span></label>
                                        <div id="price_input_container_variation">
                                            <div class="input-group">
                                                <span class="input-group-addon"><?php echo get_currency($this->payment_settings->default_currency); ?></span>
                                                <input type="text" name="option_price" id="product_price_input_variation" class="form-control form-input price-input validate-price-input m-0" placeholder="<?php echo $this->input_initial_price; ?>" onpaste="return false;" maxlength="32" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 m-t-10">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="use_default_price" id="checkbox_price_variation" value="1">
                                            <label for="checkbox_price_variation" class="custom-control-label"><?php echo trans("use_default_price"); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2 hide-if-default">
                                <div class="row align-items-center">
                                    <div class="col-sm-12">
                                        <label class="control-label"><?php echo trans("discount_rate"); ?><span class="Validation_error"> *</span></label>
                                        <div id="discount_input_container_variation">
                                            <div class="input-group">
                                                <span class="input-group-addon">%</span>
                                                <input type="number" step="0.01" name="option_discount_rate" id="input_discount_rate_variation" class="form-control form-input m-0" value="" min="0" max="99" placeholder="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 m-t-10">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="no_discount" id="checkbox_discount_rate_variation" value="1">
                                            <label for="checkbox_discount_rate_variation" class="custom-control-label"><?php echo trans("no_discount"); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($variation->option_display_type == "image" || $variation->show_images_on_slider == 1) : ?>
                    <div class="form-group hide-if-default">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label"><?php echo trans("images"); ?>&nbsp;<small class="text-muted">(<?php echo trans("optional"); ?>)</small></label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="dm-uploader-container">
                                            <div id="drag-and-drop-zone-variation-image-session" class="dm-uploader text-center">
                                                <p class="dm-upload-icon">
                                                    <i class="icon-upload"></i>
                                                </p>
                                                <p class="dm-upload-text"><?php echo trans("drag_drop_images_here"); ?>&nbsp;<span style="text-decoration: underline"><?php echo trans('browse_files'); ?></span></p>

                                                <a class='btn btn-md dm-btn-select-files'>
                                                    <input type="file" name="file" size="40" multiple="multiple">
                                                </a>
                                                <ul class="dm-uploaded-files" id="files-variation-image-session">
                                                    <?php $variation_images_session = $this->variation_model->get_sess_variation_images_array();
                                                    if (!empty($variation_images_session)) :
                                                        foreach ($variation_images_session as $img_session) : ?>
                                                            <li class="media" id="uploaderFile<?php echo $img_session->file_id; ?>">
                                                                <img src="<?php echo base_url(); ?>uploads/temp/<?php echo $img_session->img_default; ?>" alt="">
                                                                <a href="javascript:void(0)" class="btn-img-delete btn-delete-variation-image-session" data-file-id="<?php echo $img_session->file_id; ?>">
                                                                    <i class="icon-close"></i>
                                                                </a>
                                                                <?php if ($img_session->is_main == 1) : ?>
                                                                    <a href="javascript:void(0)" class="btn btn-xs btn-success btn-is-image-main btn-set-variation-image-main-session"><?php echo trans("main"); ?></a>
                                                                <?php else : ?>
                                                                    <a href="javascript:void(0)" class="btn btn-xs btn-secondary btn-is-image-main btn-set-variation-image-main-session" data-file-id="<?php echo $img_session->file_id; ?>"><?php echo trans("main"); ?></a>
                                                                <?php endif; ?>
                                                            </li>
                                                    <?php endforeach;
                                                    endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- File item template -->
                                        <script type="text/html" id="files-template-variation-image-session">
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

                        <div class="col-sm-6  hide-if-default">
                            <label class="control-label"><?php echo trans("sku"); ?></label>
                            <input type="text" name="sku-variation" id="input_sku_option" onkeyup="sku_code_validation()" class="form-control auth-form-input" placeholder="<?php echo trans("sku_desc"); ?>" required value="">
               
                            <button type="button" class="btn btn-default btn-generate-option-sku" onclick="generateUniqueProductVariationCode($(this),'<?php echo $product->id ?>','<?php echo $product->sku ?>')">
                                <div id="sp-options-add" class="spinner spinner-btn-add-variation spinner-variation-options">
                                    <div class="bounce1"></div>
                                    <div class="bounce2"></div>
                                    <div class="bounce3"></div>
                                </div>
                                <div id="form-variation-option-add-text"><?= trans("generate"); ?></div>
                            </button>
                            <div class="Validation_error hideMe" id="input_sku_check">SKU already exists</div>

                        </div>

                        <div class="col-sm-6  hide-if-default">
                            <label class="control-label">Packaged Weight(in grams)<span class="Validation_error"> *</span></label>
                            <input type="number" required name="package_weight" class="form-control auth-form-input" placeholder="Enter Product Weight After Packaging">
                            <div class="col-sm-6 pull-right btn-select-dropdown display-none" style="padding-right: 5px;">

                                <select name="package_weight_units" class="custom-select" required>
                                    <option value="Kgs">Kgs</option>
                                    <option value="Grams" selected>Grams</option>
                                    <option value="Pounds">Pounds</option>
                                    <option value="Lbs">Lbs</option>
                                    <option value="Litres">Litres</option>
                                    <option value="millilitres">millilitres</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4  hide-if-default">
                            <label class="control-label">Length (in cms)<span class="Validation_error"> *</span></label>
                            <input type="number" required name="variation_packed_length" class="form-control auth-form-input" placeholder="Length (in cms)" value="" required>
                        </div>
                        <div class="col-sm-4 hide-if-default">
                            <label class="control-label">Width (in cms)<span class="Validation_error"> *</span></label>
                            <input type="number" required name="variation_packed_width" class="form-control auth-form-input" placeholder="Width (in cms)" value="" required>
                        </div>
                        <div class="col-sm-4 hide-if-default">
                            <label class="control-label">Height (in cms)<span class="Validation_error"> *</span></label>
                            <input type="number" required name="variation_packed_height" class="form-control auth-form-input" placeholder="Height (in cms)" value="" required>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row-custom">
            <button type="button" id="btn_add_variation_option" class="btn btn-md btn-success color-white float-right">

                <div id="form-option-add-text"> <?php echo trans("add_option"); ?></div>
                <div id="sp-options-add" class="spinner spinner-btn-add-variation">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>

            </button>
            <button type="button" id="btn_save_variation_option" class="btn btn-md btn-custom color-white float-right">

                <div id="form-option-save-text"> <?php echo trans("save"); ?></div>
                <div id="sp-options-add" class="spinner spinner-btn-save-variation">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>

            </button>
            <button type="button" class="btn btn-lg btn-danger color-white float-right " data-dismiss="modal">Close</button>
        </div>
    </div>
</form>
