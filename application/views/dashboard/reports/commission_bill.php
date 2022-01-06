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
    }

    @media only screen and (max-width: 768px) {
        .dt-buttons {

            left: 5%;
        }
    }

    .row {

        overflow-x: auto;
    }
</style>
<div class="box-header with-border">
    <div class="pull-left">
        <h3 class="box-title"><?php echo trans('Commission Bill Data'); ?></h3>
    </div>
</div>
<div class="row table-filter-container">
    <div class="col-sm-12">

        <form name="commission_bill_date" id="commission_bill_date" action="dashboard_controller/commission_bill_date">
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
                <button type="submit" class="btn bg-purple" id="commission_bill_report"><?php echo trans("submit"); ?></button>
            </div>
        </form>

    </div>

</div>
<div class="col-lg-12 col-md-12">
    <div class="box">

        <div class="box-body">
            <div class="row">
                <div class="table-responsive">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-striped " id="comission_datatable" role="grid">
                            <thead>
                                <tr role="row">
                                    <th><?php echo ('Order-Month'); ?></th>
                                    <th><?php echo ('Seller'); ?></th>
                                    <th><?php echo ('Email'); ?></th>
                                    <th><?php echo ('Phone'); ?></th>
                                    <th><?php echo ('Shop_name'); ?></th>
                                    <th><?php echo ('Pan'); ?></th>
                                    <th><?php echo ('GST'); ?></th>
                                    <th><?php echo ('Address'); ?></th>
                                    <th><?php echo ('total_commission_amount'); ?></th>
                                    <th><?php echo ('Total_shipping_cost'); ?></th>
                                    <th><?php echo ('Total_Cod_cost'); ?></th>
                                    <th><?php echo ('getway_amt'); ?></th>
                                    <th><?php echo ('GST_Rate'); ?></th>
                                    <th><?php echo ('GST_Amount'); ?></th>
                                    <th><?php echo ('CGST'); ?></th>
                                    <th><?php echo ('SGST'); ?></th>
                                    <th><?php echo ('IGST'); ?></th>
                                    <th><?php echo ('TOTAL'); ?></th>
                                </tr>
                            </thead>
                            <tbody id="commission_bill">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>

<script>
    $("#commission_bill_date").submit(function(e) {


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

        table = $('#comission_datatable').DataTable();
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
                        $('#commission_bill').append("<tr><td>" + Json_data[i].Order_Month + "</td><td>" + Json_data[i].Seller + "</td><td>" + Json_data[i].Email + "</td><td>" + Json_data[i].Phone + "</td><td>" + Json_data[i].Shop_name + "</td><td>" + Json_data[i].Pan + "</td><td>" + Json_data[i].GST + "</td><td>" + Json_data[i].Address + "</td><td>" + Json_data[i].total_commission_amount + "</td><td>" + Json_data[i].Total_shipping_cost + "</td><td>" + Json_data[i].Total_Cod_cost + "</td><td>" + Json_data[i].getway_amt + "</td><td>" + Json_data[i].GST_Rate + "</td><td>" + Json_data[i].GST_Amount + "</td><td>" + Json_data[i].CGST + "</td><td>" + Json_data[i].SGST + "</td><td>" + Json_data[i].IGST + "</td><td>" + Json_data[i].TOTAL + "</td></tr>")

                    }
                }
                $('#comission_datatable').dataTable({
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
        table = $('#comission_datatable').DataTable({
            dom: 'lBfrtip',
            buttons: [
                'excel',

            ],
            // "aLengthMenu": [
            //     [15, 30, 60, 100],
            //     [15, 30, 60, 100, "All"]
            // ],
            "order": [
                [1, "desc"]
            ],

        });

    });
</script> -->