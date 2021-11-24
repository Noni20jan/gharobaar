<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php echo form_open('dashboard_controller/downlaod_sample_product_upload',['id' => 'download_bulk']); ?>
<div class="row">
    <div class="col-sm-8">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= html_escape($title); ?></h3>
                </div>
            </div>

            <div class="form-group form-group-category">
                <label class="control-label"><?php echo trans("category"); ?><span class="Validation_error"> *</span></label>
                <select id="categories" name="category_id[]" class="form-control custom-select m-0" onchange="get_subcategories(this.value, 0);" required>
                    <option value=""><?php echo trans('select_category'); ?></option>

                    <?php if (!empty($this->parent_categories)) :
                        foreach ($this->parent_categories as $item) : ?>
                            <option value="<?php echo html_escape($item->id); ?>"><?php echo category_name($item); ?></option>
                    <?php endforeach;
                    endif; ?>
                </select>
                <div id="subcategories_container"></div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-8">
    <button type="submit" id="download_file" class="btn btn-lg btn-success pull-right"><?php echo trans("download_sample_file"); ?></button>
</div>
<?php echo form_close(); ?>
<script>
    function get_subcategories(category_id, data_select_id) {
        $("#input_sku").value = "";
        var subcategories = get_subcategories_array(category_id);
        var date = new Date();
        //reset subcategories
        $('#subcategories_container select').each(function() {
            if (parseInt($(this).attr('data-select-id')) > parseInt(data_select_id)) {
                $(this).remove();
            }
        });
        if (category_id == 0) {
            return false;
        }
        if (subcategories.length > 0) {
            var new_data_select_id = date.getTime();
            var select_tag = '<select class="form-control custom-select" name="category_id[]" data-select-id="' + new_data_select_id + '" required onchange="get_subcategories(this.value,' + new_data_select_id + ');">' +
                '<option value=""><?php echo trans("select_category"); ?></option>';
            for (i = 0; i < subcategories.length; i++) {
                select_tag += '<option value="' + subcategories[i].id + '">' + subcategories[i].name + '</option>';
            }
            select_tag += '</select>';
            $('#subcategories_container').append(select_tag);
        }
    }

    function get_subcategories_array(category_id) {
        var categories_array = <?php echo get_categories_json($this->selected_lang->id); ?>;
        var subcategories_array = [];
        for (i = 0; i < categories_array.length; i++) {
            if (categories_array[i].parent_id == category_id) {
                subcategories_array.push(categories_array[i]);
            }
        }
        return subcategories_array;
    }
</script>

<script>
    $(document).ready(function () {

        $("#download_bulk").submit(function (e) {

            // e.preventDefault();
            $("#download_file").attr("disabled", true);

            return true;

        });
    });
</script>