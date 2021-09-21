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

</div>