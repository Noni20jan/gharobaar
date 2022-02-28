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
        <div class="pull-left">
            <h3 class="box-title" style="font-weight: 600;font-size: 20px;margin-bottom: 20px;"><?php echo trans('sale_data'); ?></h3>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <div class="filter">
                <form name="sale_data" id="sale_data" action="admin_controller/format_sale_data">
                    <div class="item-table-filter">
                        <label><?php echo trans("from_date"); ?></label>
                        <input name="from_date" class="form-control" type="month" id="my_date_picker1" autocomplete="off">
                    </div>

                    <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                        <label style="display: block">&nbsp;</label>
                        <button type="submit" class="btn bg-purple"><?php echo trans("submit"); ?></button>
                    </div>
                </form>

                <table class="table table-bordered table-striped button" id="extend_datatable" role="grid">
                    <thead>
                        <tr role="row">
                            <th><?php echo ('order_no'); ?></th>
                            <th><?php echo ('order_date'); ?></th>
                            <th><?php echo ('seller_id'); ?></th>
                            <th><?php echo ('seller_name'); ?></th>
                            <th><?php echo ('seller_email'); ?></th>
                            <th><?php echo ('seller_phone'); ?></th>
                            <th><?php echo ('shop_name'); ?></th>
                            <th><?php echo ('pan_no'); ?></th>
                            <th><?php echo ('gst_no'); ?></th>
                            <th><?php echo ('seller_address'); ?></th>
                            <th><?php echo ('account_no'); ?></th>
                            <th><?php echo ('acc_holder_name'); ?></th>
                            <th><?php echo ('ifsc_code'); ?></th>
                            <th><?php echo ('bank_branch'); ?></th>
                            <th><?php echo ('product_title'); ?></th>
                            <th><?php echo ('product_quantity'); ?></th>
                            <th><?php echo ('order_status'); ?></th>
                            <th><?php echo ('commission_rate'); ?></th>
                            <th><?php echo ('commission_amount'); ?></th>
                            <th><?php echo ('actual_product_gst_rate'); ?></th>
                            <th><?php echo ('seller_gst_rate'); ?></th>
                            <th><?php echo ('subtotal_excluding_gst'); ?></th>
                            <th><?php echo ('seller_tprd_gst'); ?></th>
                            <th><?php echo ('seller_tprd_cgst'); ?></th>
                            <th><?php echo ('seller_tprd_sgst'); ?></th>
                            <th><?php echo ('seller_tprd_igst'); ?></th>
                            <th><?php echo ('seller_ship_cost'); ?></th>
                            <th><?php echo ('seller_ship_gst'); ?></th>
                            <th><?php echo ('seller_ship_cgst'); ?></th>
                            <th><?php echo ('seller_ship_sgst'); ?></th>
                            <th><?php echo ('seller_ship_igst'); ?></th>
                            <th><?php echo ('seller_tship_cost'); ?></th>
                            <th><?php echo ('seller_cod_cost'); ?></th>
                            <th><?php echo ('seller_cod_gst'); ?></th>
                            <th><?php echo ('seller_cod_cgst'); ?></th>
                            <th><?php echo ('seller_cod_sgst'); ?></th>
                            <th><?php echo ('seller_cod_igst'); ?></th>
                            <th><?php echo ('seller_tcod'); ?></th>
                            <th><?php echo ('grand_total_amount'); ?></th>
                            <th><?php echo ('buyer'); ?></th>
                            <th><?php echo ('buyer_email'); ?></th>
                            <th><?php echo ('buyer_phone'); ?></th>
                            <th><?php echo ('buyer_state'); ?></th>
                            <th><?php echo ('payment_method'); ?></th>
                            <th><?php echo ('payment_mode'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="sale_data_seller">
                        <?php foreach ($sale as $item) : ?>
                            <tr>
                                <td><?php echo $item->order_no; ?></td>
                                <td><?php echo $item->order_date; ?></td>
                                <td><?php echo $item->seller_id; ?></td>
                                <td><?php echo $item->seller; ?></td>
                                <td><?php echo $item->seller_email; ?></td>
                                <td><?php echo $item->seller_phone; ?></td>
                                <td><?php echo $item->shop_name; ?></td>
                                <td><?php echo $item->pan_no; ?></td>
                                <td><?php echo $item->gst_no; ?></td>
                                <td><?php echo $item->seller_address; ?></td>
                                <td><?php echo $item->account_no; ?></td>
                                <td><?php echo $item->acc_holder_name; ?></td>
                                <td><?php echo $item->ifsc_code; ?></td>
                                <td><?php echo $item->bank_branch; ?></td>
                                <td><?php echo $item->product_title; ?></td>
                                <td><?php echo $item->product_quantity; ?></td>
                                <td><?php echo $item->order_status; ?></td>
                                <td><?php echo $item->commission_rate; ?></td>
                                <td><?php echo $item->commission_amount; ?></td>
                                <td><?php echo $item->actual_product_gst_rate; ?></td>
                                <td><?php echo $item->seller_gst_rate; ?></td>
                                <td><?php echo $item->subtotal_excluding_gst; ?></td>
                                <td><?php echo $item->seller_tprd_gst; ?></td>
                                <td><?php echo $item->seller_tprd_cgst; ?></td>
                                <td><?php echo $item->seller_tprd_sgst; ?></td>
                                <td><?php echo $item->seller_tprd_igst; ?></td>
                                <td><?php echo $item->seller_ship_cost; ?></td>
                                <td><?php echo $item->seller_ship_gst; ?></td>
                                <td><?php echo $item->seller_ship_cgst; ?></td>
                                <td><?php echo $item->seller_ship_sgst; ?></td>
                                <td><?php echo $item->seller_ship_igst; ?></td>
                                <td><?php echo $item->seller_tship_cost; ?></td>
                                <td><?php echo $item->seller_cod_cost; ?></td>
                                <td><?php echo $item->seller_cod_gst; ?></td>
                                <td><?php echo $item->seller_cod_cgst; ?></td>
                                <td><?php echo $item->seller_cod_sgst; ?></td>
                                <td><?php echo $item->seller_cod_igst; ?></td>
                                <td><?php echo $item->seller_tcod; ?></td>
                                <td><?php echo $item->grand_total_amount; ?></td>
                                <td><?php echo $item->buyer; ?></td>
                                <td><?php echo $item->buyer_email; ?></td>
                                <td><?php echo $item->buyer_phone; ?></td>
                                <td><?php echo $item->buyer_state; ?></td>
                                <td><?php echo $item->payment_method; ?></td>
                                <td><?php echo $item->payment_mode; ?></td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>


            </div>
        </div>
    </div>

</div>
<script>
    $("#sale_data").submit(function(e) {

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
                console.log(data);
                var Json_data = JSON.parse(data);
                console.log(Json_data.length);
                var len = Json_data.length;
                if (len != 0) {
                    for (var i = 0; i < len; i++) {
                        $('#sale_data_seller').append("<tr><td>" + Json_data[i].order_no + "</td><td>" + Json_data[i].order_date + "</td><td>" + Json_data[i].seller_id + "</td><td>" + Json_data[i].seller + "</td><td>" + Json_data[i].seller_email + "</td><td>" + Json_data[i].seller_phone + "</td><td>" + Json_data[i].shop_name + "</td><td>" + Json_data[i].pan_no + "</td><td>" + Json_data[i].gst_no + "</td><td>" + Json_data[i].seller_address + "</td><td>" + Json_data[i].account_no + "</td><td>" + Json_data[i].acc_holder_name + "</td><td>" + Json_data[i].ifsc_code + "</td><td>" + Json_data[i].bank_branch + "</td><td>" + Json_data[i].product_title + "</td><td>" + Json_data[i].product_quantity + "</td><td>" + Json_data[i].order_status + "</td><td>" + Json_data[i].commission_rate + "</td><td>" + Json_data[i].commission_amount + "</td><td>" + Json_data[i].actual_product_gst_rate + "</td><td>" + Json_data[i].seller_gst_rate + "</td><td>" + Json_data[i].subtotal_excluding_gst + "</td><td>" + Json_data[i].seller_tprd_gst + "</td><td>" + Json_data[i].seller_tprd_cgst + "</td><td>" + Json_data[i].seller_tprd_sgst + "</td><td>" + Json_data[i].seller_tprd_igst + "</td><td>" + Json_data[i].seller_ship_cost + "</td><td>" + Json_data[i].seller_ship_gst + "</td><td>" + Json_data[i].seller_ship_cgst + "</td><td>" + Json_data[i].seller_ship_sgst + "</td><td>" + Json_data[i].seller_ship_igst + "</td><td>" + Json_data[i].seller_tship_cost + "</td><td>" + Json_data[i].seller_cod_cost + "</td><td>" + Json_data[i].seller_cod_gst + "</td><td>" + Json_data[i].seller_cod_cgst + "</td><td>" + Json_data[i].seller_cod_sgst + "</td><td>" + Json_data[i].seller_cod_igst + "</td><td>" + Json_data[i].seller_tcod + "</td><td>" + Json_data[i].grand_total_amount + "</td><td>" + Json_data[i].buyer + "</td><td>" + Json_data[i].buyer_email + "</td><td>" + Json_data[i].buyer_phone + "</td><td>" + Json_data[i].buyer_state + "</td><td>" + Json_data[i].payment_method + "</td><td>" + Json_data[i].payment_mode + "</td></tr>")
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
<script>
    $(document).ready(function() {
        $('#extend_datatable').DataTable({
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
    });
</script>