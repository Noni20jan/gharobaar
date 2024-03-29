<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
</link>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
</link>
<style>
    .hide-div {
        display: none;
    }
</style>
<div class="content">
    <div class="col-sm-12">
        <?php echo form_open_multipart('coupon_controller/tag_cat_coupons_vouchers'); ?>
        <?php $this->load->view('admin/includes/_messages'); ?>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <input id='my_match' type='hidden' name='all_selected_check' />
                    <label>Choose a coupon:<label>&nbsp;&nbsp;
                            <select class="form-control" id="offer_id" name="offer_id">
                                <?php foreach ($coupons as $coupon) : ?>
                                    <option value="<?php echo $coupon->id ?>"><?php echo $coupon->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="myradio">Coupon Source Type<span class="Validation_error"> *</span> &nbsp;</label>
            <div class="row">
                <div class="col-12 col-sm-3 col-custom-field">
                    <div class="custom-control custom-radio">
                        <input type="radio" name="source_type" value="all" id="source_all" class="custom-control-input" required>
                        <label for="source_all" class="custom-control-label">All</label>
                    </div>
                </div>
                <div class="col-12 col-sm-3 col-custom-field">
                    <div class="custom-control custom-radio">
                        <input type="radio" name="source_type" value="products" id="source_product" class="custom-control-input" required>
                        <label for="source_product" class="custom-control-label">Products</label>
                    </div>
                </div>
                <div class="col-12 col-sm-3 col-custom-field hide-div">
                    <div class="custom-control custom-radio">
                        <input type="radio" name="source_type" value="category" id="source_category" class="custom-control-input" required>
                        <label for="source_category" class="custom-control-label">Category</label>
                    </div>
                </div>
                <div class="col-12 col-sm-3 col-custom-field">
                    <div class="custom-control custom-radio">
                        <input type="radio" name="source_type" value="freeship" id="source_freeship" class="custom-control-input" required>
                        <label for="source_freeship" class="custom-control-label">Free Shipping</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div id="load_source_view"></div>
            </div>
        </div>

        <div class="row">
            <button type="submit" id="save_button" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            <!-- <button type="submit" name="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button> -->
        </div>
        <?php echo form_close(); ?>
    </div>
    <!-- form end -->
</div>

<script>
    $('input[type=radio][name=source_type]').change(function() {
        var data = {
            "source_type": this.value,
            "sys_lang_id": sys_lang_id,
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "load-source-view-post",
            data: data,
            success: function(response) {
                document.getElementById("load_source_view").innerHTML = response;
                setTimeout(function() {
                    var table = $('#example').DataTable({
                        'columnDefs': [{
                            'targets': 0,
                            "bPaginate": false,
                            "bFilter": false,
                            'searchable': true,
                            'orderable': false,
                            'className': 'dt-body-center',
                        }],
                        // dom: 'lBfrtip',
                        // buttons: [
                        //     'excel'
                        // ],
                        'order': [1, 'asc']
                    });
                    table.clear().destroy();

                    // Handle click on "Select all" control
                    $('#example-select-all').on('click', function() {
                        // Check/uncheck all checkboxes in the table
                        var rows = table.rows({
                            'search': 'applied'
                        }).nodes();
                        $('#product_checkbox', rows).prop('checked', this.checked);
                    });
                }, 100);
            }
        })
    });

    
    $('input[type=radio][name=source_type]').change(function() {
        if (this.value == 'products') {
            $('#save_button').hide();
        } else {
            $('#save_button').show();
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
    $('#offer_id').change(function() {
        table = $('#example').DataTable();
        table.clear().destroy();

        var offer_id = ($('#offer_id').val());
        var data = {
            'offer_id': offer_id
        }
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({

            type: "POST",
            url: base_url + "get-product-coupon",
            data: data,
            success: function(data) {
                var Json_data = JSON.parse(data);
                var len = Json_data.length;

                for (var i = 0; i < len; i++) {

                    $('#insert_data').append("<tr><td>" + Json_data[i].id + "</td><td>" + '<a href="<?php echo base_url(); ?>' + Json_data[i].slug + '"target="_blank" class="table-link">' + Json_data[i].slug + "</td><td>" + Json_data[i].sku + "</td><td>" + Json_data[i].product_type + "</td><td>" + '<input type="checkbox" name="selected_id" id="product_checkbox" value="' + Json_data[i].id + '">' + "</td></tr>");

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
                    dom: 'lBfrtip',
                        buttons: [
                            'excel'
                        ],
                        
                    'order': [1, 'asc']
                });
                // table.clear().destroy();



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
<script>
    $('#source_product').change(function() {
        table = $('#example').DataTable();
        table.clear().destroy();

        var offer_id = ($('#offer_id').val());
        var data = {
            'offer_id': offer_id
        }
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({

            type: "POST",
            url: base_url + "get-product-coupon",
            data: data,
            success: function(data) {
                var Json_data = JSON.parse(data);
                var len = Json_data.length;

                for (var i = 0; i < len; i++) {

                    $('#insert_data').append("<tr><td>" + Json_data[i].id + "</td><td>" + '<a href="<?php echo base_url(); ?>' + Json_data[i].slug + '"target="_blank" class="table-link">' + Json_data[i].slug + "</td><td>" + Json_data[i].sku + "</td><td>" + Json_data[i].product_type + "</td><td>" + '<input type="checkbox" name="selected_id" id="product_checkbox" value="' + Json_data[i].id + '">' + "</td></tr>");

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
<script>
    function submit_data() {
        var arr = [];
        $('input:checked[name=selected_id]').each(function() {
            arr.push($(this).val());
        });

        $('#my_match').val(arr.join(':'));

        console.log(typeof(($('#my_match').val())));

        var source_id = ($('#my_match').val());
        var z = source_id.trim();

        var arr_source_id = (z.split(':'));
        var split_arr = arr_source_id.map(s => s.trim())

        var offer_id = ($('#offer_id').val());
        console.log(offer_id);
        var data = {
            'source_type': 'Product',
            'source_id': split_arr,
            'offer_id': offer_id
        }
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({

            type: "POST",
            url: base_url + "add-product-coupon",

            data: data,

            success: function(data) {
                location.reload();
            },
            error: function() {
                alert("error"); //error occurs
            }
        });
        return false;
    };
</script>