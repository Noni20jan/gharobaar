<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    .dt-buttons {
        left: 20%;
        content: "expport to excel";
    }

    @media only screen and (max-width: 768px) {
        .dt-buttons {

            left: 5%;
        }
    }

    .index-table {
        max-height: 600px;
        overflow-x: auto;
    }
</style>


<div class="box-body index-table">
    <div class="box-header with-border">
        <h2 class="box-title" style="font-weight: 600;font-size: 20px;margin-bottom: 20px;"><?php echo trans('product_listing'); ?></h2>

    </div>
    <div class="row">
        <div class="table-responsive">
            <div class="filter">
                <form name="product_data" id="product_data" action="admin_controller/format_product_listing">
                    <div class="item-table-filter">
                        <label><?php echo trans("from_date"); ?></label>
                        <input name="from_date" class="form-control" type="date" id="my_date_picker1" autocomplete="off">
                    </div>
                    <div class="item-table-filter">
                        <label><?php echo trans("to_date"); ?></label>
                        <input name="to_date" class="form-control" type="date" id="my_date_picker2" autocomplete="off">
                    </div>
                    <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                        <label style="display: block">&nbsp;</label>
                        <button type="submit" class="btn bg-purple"><?php echo trans("submit"); ?></button>
                    </div>
                </form>

                <table class="table table-bordered table-striped button" id="extend_datatable" role="grid">
                    <thead>
                        <tr role="row">
                            <th>Seller Name</th>
                            <th>Shop Name</th>
                            <th>Product Title</th>
                            <th>sku</th>
                            <th>category id</th>
                            <th>price</th>
                            <th>Listing Price</th>
                            <th>Price Ex GST</th>
                            <th>currency</th>
                            <th>discount rate</th>
                            <th>gst rate</th>
                            <th>GST Amount</th>
                            <th>available for return or exchange</th>
                            <th>available for barter</th>
                            <th>status</th>
                            <th>is special offer</th>
                            <th>special offer date</th>
                            <th>visibility</th>
                            <th>rating</th>
                            <th>pageviews</th>
                            <th>demo_url</th>
                            <th>stock</th>
                            <th>cod accepted</th>
                            <th>shipping time</th>
                            <th>shipping cost type</th>
                            <th>is deleted</th>
                            <th>is draft</th>
                            <th>add meet</th>
                            <th>weight</th>
                            <th>temperature</th>
                            <th>allergance</th>
                            <th>availability</th>
                            <th>product_pincode</th>
                            <th>product weight</th>
                            <th> product state</th>
                            <th>product address</th>
                            <th>product city</th>
                            <th>product area</th>
                            <th>landmark</th>
                            <th>supplier product type</th>
                            <th>is expire</th>
                            <th>expiry date</th>
                            <th>manufacturing date</th>
                            <th>lead time</th>
                            <th>is organic</th>
                            <th>is sustainable</th>
                            <th>is handicraft</th>
                            <th>is gluten Free</th>
                            <th>is vegan</th>
                            <th>is keto friendly</th>
                            <th>is allergens</th>
                            <th>is personalised</th>
                            <th>is veg nonveg jain</th>
                            <th>is appetisers main course beverages desserts</th>
                            <th>is gold silver precious stones semi precious artificial</th>
                            <th>special delivery requirement</th>
                            <th>delivery area</th>
                            <th>product wash instruction</th>
                            <th>blouse details</th>
                            <th>minimum prior notice</th>
                            <th>hsn code</th>
                            <th>packed product height</th>
                            <th>packed product length</th>
                            <th>packed product width</th>
                            <th>other product wash instruction</th>
                            <th>other blouse details</th>
                            <th>other minimum prior notice</th>
                            <th>other pet age</th>
                            <th>other storage instruction</th>
                            <th>other delivery area</th>
                            <th>shelf life from date of manufacture</th>
                            <th>discounted pric</th>
                            <th>order capacity</th>
                            <th>lead days</th>
                            <th>weight units</th>
                            <th>shelf units</th>
                            <th>special delivery other</th>
                            <th>product pincode</th>
                            <th>product area</th>
                            <th>product address</th>
                            <th>product state</th>
                            <th>product city</th>
                            <th>landmark </th>
                            <th>suitable for</th>
                            <th>created at</th>

                        </tr>
                    </thead>
                    <tbody id="product_data_list">

                    </tbody>
                </table>


            </div>
        </div>
    </div>

</div>
<script>
    $("#product_data").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);

        var d = form.serializeArray();
        d.push({
            name: csfr_token_name,
            value: $.cookie(csfr_cookie_name)
        });
        d.push({
            name: "sys_lang_id",
            value: sys_lang_id
        });

        var url = form.attr('action');

        table = $('#extend_datatable').DataTable();
        table.clear().destroy();

        $.ajax({
            type: "POST",
            url: base_url + url,
            data: d, // serializes the form's elements.
            success: function(data) {
                // console.log("test",data);
                var Json_data = JSON.parse(data);
                console.log(Json_data.length);
                var len = Json_data.length;
                if (len != 0) {
                    for (var i = 0; i < len; i++) {
                        $('#product_data_list').append("<tr><td>" + Json_data[i].Seller_Name + "</td><td>" + Json_data[i].Shop_Name + "</td><td>" + Json_data[i].Product_Title + "</td><td>" + Json_data[i].sku + "</td><td>" + Json_data[i].category_id + "</td><td>" + Json_data[i].price + "</td><td>" + Json_data[i].Listing_Price + "</td><td>" + Json_data[i].Price_Ex_GST + "</td><td>" + Json_data[i].currency + "</td><td>" + Json_data[i].discount_rate + "</td><td>" + Json_data[i].gst_rate + "</td><td>" + Json_data[i].GST_Amount + "</td><td>" + Json_data[i].available_for_return_or_exchange + "</td><td>" + Json_data[i].available_for_barter + "</td><td>" + Json_data[i].status + "</td><td>" + Json_data[i].is_special_offer + "</td><td>" + Json_data[i].special_offer_date + "</td><td>" + Json_data[i].visibility + "</td><td>" + Json_data[i].rating + "</td><td>" + Json_data[i].pageviews + "</td><td>" + Json_data[i].demo_url + "</td><td>" + Json_data[i].stock + "</td><td>" + Json_data[i].cod_accepted + "</td><td>" + Json_data[i].shipping_time + "</td><td>" + Json_data[i].shipping_cost_type + "</td><td>" + Json_data[i].is_deleted + "</td><td>" + Json_data[i].is_draft + "</td><td>" + Json_data[i].add_meet + "</td><td>" + Json_data[i].weight + "</td><td>" + Json_data[i].temperature + "</td><td>" + Json_data[i].allergance + "</td><td>" + Json_data[i].availability + "</td><td>" + Json_data[i].product_pincode + "</td><td>" + Json_data[i].product_weight + "</td><td>" + Json_data[i].product_state + "</td><td>" + Json_data[i].product_address + "</td><td>" + Json_data[i].product_city + "</td><td>" + Json_data[i].product_area + "</td><td>" + Json_data[i].landmark + "</td><td>" + Json_data[i].supplier_product_type + "</td><td>" + Json_data[i].is_expire + "</td><td>" + Json_data[i].expiry_date + "</td><td>" + Json_data[i].manufacturing_date + "</td><td>" + Json_data[i].lead_time + "</td><td>" + Json_data[i].is_organic + "</td><td>" + Json_data[i].is_sustainable + "</td><td>" + Json_data[i].is_handicraft + "</td><td>" + Json_data[i].is_gluten_Free + "</td><td>" + Json_data[i].is_vegan + "</td><td>" + Json_data[i].is_keto_friendly + "</td><td>" + Json_data[i].is_allergens + "</td><td>" + Json_data[i].is_personalised + "</td><td>" + Json_data[i].is_veg_nonveg_jain + "</td><td>" + Json_data[i].is_appetisers_main_course_beverages_desserts + "</td><td>" + Json_data[i].is_gold_silver_precious_stones_semi_precious_artificial + "</td><td>" + Json_data[i].special_delivery_requirement + "</td><td>" + Json_data[i].delivery_area + "</td><td>" + Json_data[i].product_wash_instruction + "</td><td>" + Json_data[i].blouse_details + "</td><td>" + Json_data[i].minimum_Prior_notice + "</td><td>" + Json_data[i].hsn_code + "</td><td>" + Json_data[i].packed_product_height + "</td><td>" + Json_data[i].packed_product_length + "</td><td>" + Json_data[i].packed_product_width + "</td><td>" + Json_data[i].other_product_wash_instruction + "</td><td>" + Json_data[i].other_blouse_details + "</td><td>" + Json_data[i].other_minimum_Prior_notice + "</td><td>" + Json_data[i].other_pet_age + "</td><td>" + Json_data[i].other_storage_instruction + "</td><td>" + Json_data[i].other_delivery_area + "</td><td>" + Json_data[i].shelf_life_from_date_of_manufacture + "</td><td>" + Json_data[i].discounted_price + "</td><td>" + Json_data[i].order_capacity + "</td><td>" + Json_data[i].lead_days + "</td><td>" + Json_data[i].weight_units + "</td><td>" + Json_data[i].shelf_units + "</td><td>" + Json_data[i].special_delivery_other + "</td><td>" + Json_data[i].product_pincode_1 + "</td><td>" + Json_data[i].product_area_1 + "</td><td>" + Json_data[i].product_address_1 + "</td><td>" + Json_data[i].product_state_1 + "</td><td>" + Json_data[i].product_city_1 + "</td><td>" + Json_data[i].landmark_1 + "</td><td>" + Json_data[i].suitable_for + "</td><td>" + Json_data[i].created_at + "</td></tr>")
                    }
                }
                $('#extend_datatable').dataTable({

                    orderCellsTop: true,
                    fixedHeader: true,
                    initComplete: function() {
                        var api = this.api();

                        // For each column
                        api
                            .columns()
                            .eq(0)
                            .each(function(colIdx) {
                                // Set the header cell to contain the input element
                                var cell = $('.filters th').eq(
                                    $(api.column(colIdx + 1).header()).index()
                                );
                                var title = $(cell).text();
                                $(cell).html('<input type="text" style="width:100%" placeholder="' + title + '" />');

                                // On every keypress in this input
                                $(
                                        'input',
                                        $('.filters th').eq($(api.column(colIdx).header()).index())
                                    )
                                    .off('keyup change')
                                    .on('keyup change', function(e) {
                                        e.stopPropagation();

                                        // Get the search value
                                        $(this).attr('title', $(this).val());
                                        var regexr = '({search})'; //$(this).parents('th').find('select').val();

                                        var cursorPosition = this.selectionStart;
                                        // Search the column for that value
                                        api
                                            .column(colIdx)
                                            .search(
                                                this.value != '' ?
                                                regexr.replace('{search}', '(((' + this.value + ')))') :
                                                '',
                                                this.value != '',
                                                this.value == ''
                                            )
                                            .draw();

                                        $(this)
                                            .focus()[0]
                                            .setSelectionRange(cursorPosition, cursorPosition);
                                    });
                            });
                    },
                    dom: 'lBfrtip',
                    buttons: [{
                        extend: 'excel',
                        text: 'Export To Excel'
                    }],
                    "aLengthMenu": [
                        [15, 30, 60, 100],
                        [15, 30, 60, 100, "All"]
                    ],
                    "order": [
                        [0, "desc"]
                    ],
                });
            }

        });


    });
</script>