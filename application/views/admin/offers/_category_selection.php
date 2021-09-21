<?php echo form_open('coupon_controller/tag_cat_coupons_vouchers'); ?>
<div class="col-md-6">
    <div class="form-group">
        <label><?php echo trans('category'); ?></label>
        <select class="form-control" name="category_id[]" onchange="get_subcategories(this.value, 0);" required>
            <option value="0"><?php echo trans('none'); ?></option>
            <?php foreach ($parent_categories as $parent_category) : ?>
                <option value="<?php echo $parent_category->id; ?>"><?php echo category_name($parent_category); ?></option>
            <?php endforeach; ?>
        </select>
        <div id="subcategories_container"></div>
    </div>
    <button type="submit" name="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
</div>
<?php echo form_close(); ?>

<script>
    function get_subcategories(category_id, data_select_id) {
        var subcategories = get_subcategories_array(category_id);
        var date = new Date();
        //reset subcategories
        $('.subcategory-select').each(function() {
            if (parseInt($(this).attr('data-select-id')) > parseInt(data_select_id)) {
                $(this).remove();
            }
        });
        if (category_id == 0) {
            return false;
        }
        if (subcategories.length > 0) {
            var new_data_select_id = date.getTime();
            var select_tag = '<select class="form-control subcategory-select" data-select-id="' + new_data_select_id + '" name="category_id[]" onchange="get_subcategories(this.value,' + new_data_select_id + ');">' +
                '<option value=""><?php echo trans('none'); ?></option>';
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