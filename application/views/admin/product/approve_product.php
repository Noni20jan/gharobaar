<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
</link>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<style>
    .td-product {
        width: 23%;
    }

    .nxt-cancel-styls {
        width: 100px;
        background: #185d8c;
        border-color: #185d8c;
        color: white;
        float: right;
    }
</style>

<div class="row">
    <form id="submit_val">

        <input id='my_match' type='hidden' name='all_selected_check' />

        <div class="col-md-4">
            <!-- include message block -->
            <?php $this->load->view('admin/includes/_messages_form'); ?>
            <?php $features = get_lookup_values_by_type_custom('FEATURE_TYPE'); ?>
            <?php foreach ($this->languages as $language) : ?>
                <div class="form-group">
                    <label><?php echo trans("feature_type"); ?> (<?php echo $language->name; ?>)</label>
                    <select class="form-control" name="feature_type" id="feature_type" required>
                        <option disabled selected>Select Feature Type</option>
                        <option value="GROUP_FEATURE"><?php echo 'Group Feature'; ?></option>
                    </select>

                </div>
        </div>
    <?php endforeach; ?>
    <div class="col-md-4">
        <div class="form-group" id="group_feature">
            <label class="control-label"><?php echo trans("feature_name"); ?>
            </label>
            <select class="form-control" name="feature_name" id="feature_name">
                <option disabled selected>Select Feature name</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <?php $featured = get_lookup_values_by_type_custom('BANNER_BY_PRODUCT'); ?>
        <div class="form-group">
            <label class="control-label"><?php echo trans("feature_value"); ?>

            </label>
            <select class="form-control" name="feature_value" id="feature_value" required>
                <option disabled selected>Select Feature value</option>
                <?php foreach ($featured as $featur) : ?>
                    <option value="<?php echo $featur->id; ?>"><?php echo $featur->meaning; ?></option>

                <?php endforeach; ?>



            </select>

        </div>
    </div>

</div>
<?php $z = get_lookup_feature_id('GROUP_FEATURE')->id; ?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $title; ?></h3>
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="row">
            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive" style="overflow-x:hidden !important;">
                    <table id="example" class="table table-bordered table-striped">

                        <thead>
                            <tr role="row">
                                <th width="20"><?php echo trans('id'); ?></th>
                                <th>Image</th>
                                <th>Product</th>
                                <th><?php echo trans('category'); ?></th>
                                <th><?php echo trans('stock'); ?></th>
                                <th>Shop Name</th>
                                <th>Brand Name</th>

                                <th><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>

                            </tr>
                        </thead>
                        <tbody id="insert_data">
                            <!-- <?php if (!empty($products)) :
                                        foreach ($products as $item) : ?>

                                    <tr>
                                        <td><input type="checkbox" name="checkbox-table" class="checkbox-table" id="product_checkbox" value="<?php echo $item->id; ?>"></td>
                                        <td><?php echo html_escape($item->id); ?></td>
                                        <td class="td-product">
                                            <?php if ($item->is_promoted == 1) : ?>
                                                <label class="label label-success"><?php echo trans("featured"); ?></label>
                                            <?php endif; ?>
                                            <div class="img-table">
                                                <a href="<?php echo generate_product_url($item); ?>" target="_blank">
                                                    <img src="<?php echo get_product_image($item->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                                                </a>
                                            </div>
                                            <a href="<?php echo generate_product_url($item); ?>" target="_blank" class="table-product-title">
                                                <?php echo get_product_title($item); ?>
                                            </a>
                                        </td>

                                        <td>
                                            <?php $categories = get_parent_categories_tree($item->category_id, false);
                                            if (!empty($categories)) {
                                                foreach ($categories as $category) {
                                                    echo html_escape($category->name) . "<br>";
                                                }
                                            } ?>
                                        </td>
                                        <td>
                                            <?php $user = get_user($item->user_id);
                                            if (!empty($user)) : ?>
                                                <a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank" class="table-username">
                                                    <?php echo html_escape($user->shop_name); ?>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="white-space-nowrap">
                                            <?php if ($item->product_type == "digital") : ?>
                                                <span class="text-success"><?php echo trans("in_stock"); ?></span>
                                                <?php else :
                                                if ($item->stock < 1) : ?>
                                                    <span class="text-danger"><?= $item->listing_type == 'ordinary_listing' ? trans("sold") : trans("out_of_stock"); ?></span>
                                                <?php else : ?>
                                                    <span class="text-success"><?php echo trans("in_stock"); ?>&nbsp;<?= $item->listing_type != 'ordinary_listing' ? "(" . $item->stock . ")" : ''; ?></span>
                                            <?php endif;
                                            endif; ?>
                                        </td>
                                        <td><?php echo formatted_date($item->created_at); ?></td> -->


                            <!-- <?php endforeach; ?>
                        </tr>

                    <?php endif; ?> -->

                        </tbody>
                    </table>
                    </form>


                    <?php if (empty($products)) : ?>
                        <p class="text-center">
                            <?php echo trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">

                            <!-- <div class="pull-right">
                                <?php echo $this->pagination->create_links(); ?>
                            </div> -->
                            <!-- <?php if (count($products) > 0) : ?>
                                <div class="pull-left">
                                    <button class="btn btn-sm btn-danger btn-table-delete" onclick="delete_selected_products('<?php echo trans("confirm_products"); ?>');"><?php echo trans('delete'); ?></button>
                                </div>
                            <?php endif; ?> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="button" id="submit_val_button" class="nxt-cancel-styls">Done</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <?php echo form_open('product_controller/add_remove_featured_products'); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo trans('add_to_featured'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label><?php echo trans('day_count'); ?></label>
                    <input type="hidden" class="form-control" name="product_id" id="day_count_product_id" value="">
                    <input type="hidden" class="form-control" name="is_ajax" value="0">
                    <input type="number" class="form-control" name="day_count" placeholder="<?php echo trans('day_count'); ?>" value="1" min="1" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><?php echo trans("submit"); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo trans("close"); ?></button>
            </div>
            <?php echo form_close(); ?>
            <!-- form end -->
        </div>

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
            $('#feature_name').append('<option value="<?php echo 'BANNER_BY_PRODUCT'; ?>"><?php echo 'Banner For Products'; ?></option>');
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
    // function get_feature_name(feature_name) {

    //     var base_url = '<?php echo base_url() ?>';
    //     var feature_name = feature_name;

    //     var data = {
    //         feature_name: feature_name
    //     };
    //     data[csfr_token_name] = $.cookie(csfr_cookie_name);

    //     if (feature_name) {
    //         $.ajax({
    //             url: base_url + "category_controller/get_feature",
    //             method: "POST",
    //             data: data,
    //             success: function(data) {
    //                 var e = JSON.parse(data);
    //                 if (e.result != "") {
    //                     // console.log(e.feature_names);
    //                     get_feature_type_values(e.feature_names);
    //                 }
    //             }
    //         });
    //     } else {
    //         // alert("You can not request for barter");
    //     }
    //     console.log(data);

    // }

    // function get_feature_type_values(feature_names) {
    //     document.getElementById('feature_value').options.length = 0;
    //     $('#feature_value').append('<option disabled selected>Select Feature value</option>');
    //     for (var i = 0; i < feature_names.length; i++) {
    //         $('#feature_value').append('<option value="' + feature_names[i].lookup_code + '">' + feature_names[i].meaning + '</option>');
    //     }
    // }
</script>
<script>
    $('#feature_name').on('change', function() {
        <?php $feature_group_names = get_lookup_values_by_type_custom('BANNER_BY_PRODUCT'); ?>
        <?php $feature_individual_names = get_lookup_values_by_type_custom('INDIVIDUAL_FEATURE'); ?>
        <?php $feature_picks_for_you = get_lookup_values_by_type_custom('PICKS_FOR_YOU'); ?>
        // console.log($('#feature_type').val());
        $('#feature_value').html('');
        if ($('#feature_name').val() == "BANNER_BY_PRODUCT") {
            $("#feature_value").prop("disabled", false);
            $('#feature_value').append('<option disabled selected>Select Feature Value</option>');
            <?php foreach ($feature_group_names as $feature) : ?>

                $('#feature_value').append('<option value="<?php echo $feature->id; ?>"><?php echo $feature->meaning; ?></option>');
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
</script>
<script>
    $('#submit_val_button').click(function() {

        var arr = [];
        $('input:checked[name=selected_id]').each(function() {
            arr.push($(this).val());
        });

        $('#my_match').val(arr.join(':'));

        var source_id = ($('#my_match').val());
        var z = source_id.trim();
        console.log(z);
        var arr_source_id = (z.split(':'));
        console.log(arr_source_id);
        var split_arr = arr_source_id.map(s => s.trim())
        var grp_feature_id = <?php echo $z; ?>;
        var feature_id = parseInt($('#feature_value').val());

        var data = {

            'grp_feature_id': grp_feature_id,
            'feature_id': feature_id,
            'product_id': split_arr
        }
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({

            type: "POST",
            url: base_url + "add-product-banner",

            data: data,

            success: function(data) {
                location.reload();
            },
            error: function() {
                alert("error"); //error occurs
            }
        });
        return false;
    });
</script>
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({

            'columnDefs': [{
                'targets': 0,
                "bPaginate": false,
                "bFilter": false,
                'searchable': true,
                'orderable': false,
                'className': 'dt-body-center',

            }],
            'order': [1, 'asc']
        });







    });
</script>

<script>
    $('#feature_value').change(function() {
        table = $('#example').DataTable();
        table.clear().destroy();

        var feature_id = parseInt($('#feature_value').val());
        var source_id = ($('#my_match').val());
        var z = source_id.trim();
        console.log(z);
        var arr_source_id = (z.split(':'));
        console.log(arr_source_id);
        var split_arr = arr_source_id.map(s => s.trim())
        var data = {
            'feature_id': feature_id
        }
        console.log(data);
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({

            type: "POST",
            url: base_url + "get-product-banner",
            data: data,
            success: function(data) {
                var Json_data = JSON.parse(data);
                var len = Json_data.length;
                console.log(Json_data);

                for (var i = 0; i < len; i++) {

                    $('#insert_data').append("<tr><td>" + Json_data[i].id + "</td><td> <div class='img-table'><img src=<?php echo base_url(); ?>uploads/images/" + Json_data[i].image_default + "> + </div></td><td>" + '<a href="<?php echo base_url(); ?>' + Json_data[i].slug + '"target="_blank" class="table-link">' + Json_data[i].title + "</td><td>" + Json_data[i].name + "</td><td>" + Json_data[i].stock + "</td><td>" + Json_data[i].shop_name + "</td><td>" + Json_data[i].brand_name + "</td><td>" + '<input type="checkbox" name="selected_id" id="product_checkbox" value="' + Json_data[i].id + '">' + "</td></tr>")


                }
                var table = $('#example').DataTable({

                    'columnDefs': [{
                        'targets': 0,
                        "bPaginate": false,
                        "bFilter": false,
                        'searchable': true,
                        'orderable': false,
                        'className': 'dt-body-center',

                    }],
                    'order': [1, 'asc']
                });



                // Handle click on "Select all" control
                $('#example-select-all').on('click', function() {
                    // Check/uncheck all checkboxes in the table
                    var rows = table.rows({
                        'search': 'applied'
                    }).nodes();
                    $('#product_checkbox', rows).prop('checked', this.checked);
                });
            }
        });
    });
</script>