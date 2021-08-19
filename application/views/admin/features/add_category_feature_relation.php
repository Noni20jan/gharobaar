<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-7 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title">Add Category Feature Relation</h3>
                </div>
                <div class="right">
                    <a href="<?php echo admin_url(); ?>category-feature-relation" class="btn btn-success btn-add-new">
                        <i class="fa fa-list-ul"></i>&nbsp;&nbsp;Category Feature Relation
                    </a>
                </div>
            </div><!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('category_controller/add_category_feature_relation_post'); ?>



            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages_form'); ?>
                <?php $features = get_lookup_values_by_type_custom('FEATURE_TYPE'); ?>
                <?php foreach ($this->languages as $language) : ?>
                    <div class="form-group">
                        <label><?php echo trans("feature_type"); ?> (<?php echo $language->name; ?>)</label>
                        <select class="form-control" name="feature_type" id="feature_type" required>
                            <option disabled selected>Select Feature Type</option>
                            <?php foreach ($features as $feature) : ?>
                                <option value="<?php echo $feature->lookup_code; ?>"><?php echo $feature->meaning; ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                <?php endforeach; ?>

                <div class="form-group" id="group_feature">
                    <label class="control-label"><?php echo trans("feature_name"); ?>
                    </label>
                    <select class="form-control" name="feature_name" id="feature_name" onchange="get_feature_name(this.value);" required>
                        <option disabled selected>Select Feature name</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans("feature_value"); ?>

                    </label>
                    <select class="form-control" name="feature_value" id="feature_value" required>
                        <option disabled selected>Select Feature value</option>

                    </select>
                </div>
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

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_category_feature_relation'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?>
            <!-- form end -->
        </div>

        <!-- /.box -->
    </div>
</div>



<script>
    $('#feature_type').on('change', function() {
        <?php $feature_group_names = get_lookup_values_by_type_custom('GROUP_FEATURE'); ?>
        <?php $feature_individual_names = get_lookup_values_by_type_custom('INDIVIDUAL_FEATURE'); ?>
        <?php $feature_picks_for_you = get_lookup_values_by_type_custom('PICKS_FOR_YOU'); ?>
        // console.log($('#feature_type').val());
        $('#feature_name').html('');
        if ($('#feature_type').val() == "GROUP_FEATURE") {
            $("#feature_name").prop("disabled", false);
            $('#feature_name').append('<option disabled selected>Select Feature name</option>');
            <?php foreach ($feature_group_names as $feature) : ?>
                $('#feature_name').append('<option value="<?php echo $feature->lookup_code; ?>"><?php echo $feature->meaning; ?></option>');
            <?php endforeach; ?>
        } else if ($('#feature_type').val() == "INDIVIDUAL_FEATURE") {
            $("#feature_name").prop("disabled", true);
            <?php foreach ($feature_individual_names as $feature) : ?>
                $('#feature_value').append('<option value="<?php echo $feature->lookup_code; ?>"><?php echo $feature->meaning; ?></option>');
            <?php endforeach; ?>
        } else if ($('#feature_type').val() == "PICKS_FOR_YOU") {
            $("#feature_name").prop("disabled", true);
            <?php foreach ($feature_picks_for_you as $feature) : ?>
                $('#feature_value').append('<option value="<?php echo $feature->lookup_code; ?>"><?php echo $feature->meaning; ?></option>');
            <?php endforeach; ?>
        }
    });
</script>


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
<script>
    function get_feature_name(feature_name) {

        var base_url = '<?php echo base_url() ?>';
        var feature_name = feature_name;

        var data = {
            feature_name: feature_name
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);

        if (feature_name) {
            $.ajax({
                url: base_url + "category_controller/get_feature",
                method: "POST",
                data: data,
                success: function(data) {
                    var e = JSON.parse(data);
                    if (e.result != "") {
                        // console.log(e.feature_names);
                        get_feature_type_values(e.feature_names);
                    } 
                }
            });
        } else {
            // alert("You can not request for barter");
        }

    }

    function get_feature_type_values(feature_names) {
        document.getElementById('feature_value').options.length = 0;
        $('#feature_value').append('<option disabled selected>Select Feature value</option>');
        for (var i = 0; i < feature_names.length; i++) {
            $('#feature_value').append('<option value="' + feature_names[i].lookup_code + '">' + feature_names[i].meaning + '</option>');
        }
    }
</script>