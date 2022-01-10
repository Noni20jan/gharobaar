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
<style>
    .dt-buttons {
        left: 20%;
    }

    @media only screen and (max-width: 768px) {
        .dt-buttons {

            left: 5%;
        }
    }

    .row {

        overflow-x: auto;
    }

    div.container {
        width: 80%;
    }

    .index-table {
        max-height: 1000px;
        overflow-x: auto;
    }
</style>



<div class="box-body index-table">
    <div class="row">

        <form name="shipping_cod_charges" id="shipping_cod_charges" action="admin_controller/format_shipping_cod_charges">
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

        <table class="table table-bordered table-striped dataTable" id="extend_datatable">
            <thead>
                <tr role="row">
                    <th>Order Date</th>
                    <th>GBT Order No.</th>
                    <th>Schedule Shipment Date</th>
                    <th>Schedule Shipment Time</th>
                    <th>Pickup Schedule Date</th>
                    <th>Shipment Status</th>
                    <th>Buyer</th>
                    <th>Buyer Mobile</th>
                    <th>Buyer Email</th>
                    <th>Buyer State</th>
                    <th>Buyer's Address</th>
                    <th>Seller Shop Name</th>
                    <th>Seller Registered Email</th>
                    <th>Seller State</th>
                    <th>Product SKU</th>
                    <th>Product Name</th>
                    <th>Product Weight(Gms.)</th>
                    <th>Sellers Packaging Dimenions(cm x cm x cm)</th>
                    <th>Volumetric Weight- kg(s)</th>
                    <th>Courier Service Provider</th>
                    <th>Shipping amount</th>
                    <th>COD charges</th>
                    <th>Shipping amount</th>
                    <th>COD charges</th>
                    <th>Shiprocket's Order ID</th>
                    <th>Shiprockets AWB Number</th>
                    <th>Status of COD Remittance</th>




                </tr>
            </thead>
            <tbody id="shipping_cod">

            </tbody>
        </table>


    </div>
</div>
</div>


<script>
    $("#shipping_cod_charges").submit(function(e) {

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
                        $('#shipping_cod').append("<tr><td>" + Json_data[i].Order_Date + "</td><td>" + Json_data[i].GBT_Order_No + "</td><td>" + Json_data[i].Schedule_Shipment_Date + "</td><td>" + Json_data[i].Schedule_Shipment_Time + "</td><td>" + Json_data[i].Pickup_Schedule_Date + "</td><td>" + Json_data[i].Shipment_Status + "</td><td>" + Json_data[i].Buyer + "</td><td>" + Json_data[i].Buyer_Mobile + "</td><td>" + Json_data[i].Buyer_Email + "</td><td>" + Json_data[i].Buyer_State + "</td><td>" + Json_data[i].Buyer_Address + "</td><td>" + Json_data[i].Seller_Shop_Name + "</td><td>" + Json_data[i].Seller_Registered_Email + "</td><td>" + Json_data[i].Seller_State + "</td><td>" + Json_data[i].Product_SKU + "</td><td>" + Json_data[i].Product_Name + "</td><td>" + Json_data[i].Product_Weight + "</td><td>" + Json_data[i].Sellers_Packaging_Dimenions + "</td><td>" + Json_data[i].Volumetric_Weight + "</td><td>" + Json_data[i].Courier_Service_Provider + "</td><td>" + Json_data[i].Shipping_amount + "</td><td>" + Json_data[i].COD_charges + "</td><td>" + Json_data[i].Status_COD_Remittance + "</td><td>" + Json_data[i].COD_Balance_pending_with_Shiprocket + "</td><td>" + Json_data[i].Shiprockets_Order_ID + "</td><td>" + Json_data[i].Shiprockets_AWB_Number + "</td><td>" + Json_data[i].Cancellation_charges + "</td></tr>")
                    }

                }
                $('#extend_datatable').dataTable({
                    autoWidth: false,
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
</script>