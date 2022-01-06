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
</style>
<style>
    .ui-datepicker {
        width: 16em;
    }
</style>
<div class="box-header with-border">
    <div class="pull-left">
        <h3 class="box-title"><?php echo trans ('sales_data'); ?></h3>
    </div>
</div>
<div class="row table-filter-container">
    <div class="col-sm-12">

        <form name="sales_data_date" id="sales_data_date" action="dashboard_controller/sales_data_date">
            <div class="item-table-filter">
                <label><?php echo trans("from_date"); ?></label>
                <input name="from_date" class="form-control" type="date" id="my_date_picker1" autocomplete="off" value="<?php echo html_escape($this->input->get('q', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
            </div>
            <div class="item-table-filter">
                <label><?php echo trans("to_date"); ?></label>
                <input name="to_date" class="form-control" type="date" id="my_date_picker2" autocomplete="off" value="<?php echo html_escape($this->input->get('q', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
            </div>
            <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                <label style="display: block">&nbsp;</label>
                <button type="submit" class="btn bg-purple" id="sale_data_report"><?php echo trans("submit"); ?></button>
            </div>
        </form>

    </div>

</div>
<div class="col-lg-12 col-md-12">
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="table-responsive">
                    <div class="col-sm-12" style="overflow-x:scroll">
                        <table class="table table-bordered table-striped dataTable" id="sales_datatable" role="grid" aria-describedby="example1_info">
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
                            <tbody id="sales_data">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>

<!-- <script>
    $(document).ready(function() {
        $('#sales_datatable').DataTable({
            dom: 'lBfrtip',
            buttons: [
                'excel',
            ],
            "aLengthMenu": [
                [15, 30, 60, 100],
                [15, 30, 60, 100, "All"]
            ],
            "order": [
                [0, "desc"]
            ],
        });

    });
</script> -->

<script>
    $("#sales_data_date").submit(function(e) {


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

        table = $('#sales_datatable').DataTable();
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
                        // $('#sales_data').append("<tr><td><input type='checkbox' onchange='checkbox(this," + JSON.stringify(Json_data[i]) + ")'></td><td>" + (j = i + 1) + "</td><td>" + Json_data[i].order_id + "</td><td>" + Json_data[i].shop_name + "</td><td>" + Json_data[i].created_at + "</td><td>" + Json_data[i].order_status + "</td><td>" + ((Json_data[i].grand_total_amount) / 100).toFixed(2) + "</td><td>" + ((Json_data[i].shipping_charge_to_gharobaar) / 100).toFixed(2) + "</td><td>" + ((Json_data[i].cod_charge) / 100).toFixed(2) + "</td><td>" + (((Json_data[i].Sup_Shipping_gst / 100) + (Json_data[i].Sup_cod_gst / 100) + (Json_data[i].Sup_subtotal_prd_gst / 100))).toFixed(2) + "</td><td>" + ((Json_data[i].net_seller_payable) / 100).toFixed(2) + "</td></tr>")
                        $('#sales_data').append("<tr><td>" + Json_data[i].order_no + "</td><td>" + Json_data[i].order_date + "</td><td>" + Json_data[i].seller_id + "</td><td>" + Json_data[i].seller_name + "</td><td>" + Json_data[i].seller_email + "</td><td>" + Json_data[i].seller_phone + "</td><td>" + Json_data[i].shop_name + "</td><td>" + Json_data[i].pan_no + "</td><td>" + Json_data[i].gst_no + "</td><td>" + Json_data[i].seller_address + "</td><td>" + Json_data[i].account_no + "</td><td>" + Json_data[i].acc_holder_name + "</td><td>" + Json_data[i].ifsc_code + "</td><td>" + Json_data[i].bank_branch + "</td><td>" + Json_data[i].product_title + "</td><td>" + Json_data[i].product_quantity + "</td><td>" + Json_data[i].order_status + "</td><td>" + Json_data[i].commission_rate + "</td><td>" + Json_data[i].commission_amount + "</td><td>" + Json_data[i].actual_product_gst_rate + "</td><td>" + Json_data[i].seller_gst_rate + "</td><td>" + Json_data[i].subtotal_excluding_gst + "</td><td>" + Json_data[i].seller_tprd_gst + "</td><td>" + Json_data[i].seller_tprd_cgst + "</td><td>" + Json_data[i].seller_tprd_sgst + "</td><td>" + Json_data[i].seller_tprd_igst + "</td><td>" + Json_data[i].seller_ship_cost + "</td><td>" + Json_data[i].seller_ship_gst + "</td><td>" + Json_data[i].seller_ship_cgst + "</td><td>" + Json_data[i].seller_ship_sgst + "</td><td>" + Json_data[i].seller_ship_igst + "</td><td>" + Json_data[i].seller_tship_cost + "</td><td>" + Json_data[i].seller_cod_cost + "</td><td>" + Json_data[i].seller_cod_gst + "</td><td>" + Json_data[i].seller_cod_cgst + "</td><td>" + Json_data[i].seller_cod_sgst + "</td><td>" + Json_data[i].seller_cod_igst + "</td><td>" + Json_data[i].seller_tcod + "</td><td>" + Json_data[i].grand_total_amount + "</td><td>" + Json_data[i].buyer + "</td><td>" + Json_data[i].buyer_email + "</td><td>" + Json_data[i].buyer_phone + "</td><td>" + Json_data[i].buyer_state + "</td><td>" + Json_data[i].payment_method + "</td><td>" + Json_data[i].payment_mode + "</td></tr>")

                    }
                }
                $('#sales_datatable').dataTable({
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
                    buttons: [
                        'excel',
                    ],
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


<!-- <script>
    $(document).ready(function() {

        $(function() {
            $("#my_date_picker1").datepicker({
                dateFormat: 'yy-mm-dd'
            });

        });

        $(function() {
            $("#my_date_picker2").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });

        $('#my_date_picker1').change(function() {
            startDate = $(this).datepicker('getDate');
            $("#my_date_picker2").datepicker("option", "minDate", startDate);
        })

        $('#my_date_picker2').change(function() {
            endDate = $(this).datepicker('getDate');
            $("#my_date_picker1").datepicker("option", "maxDate", endDate);
        })
    })
</script> -->