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
        <h3 class="box-title"><?php echo trans('payment_reports'); ?></h3>
    </div>
</div>
<div class="row table-filter-container">
    <div class="col-sm-12">

        <form name="payment_report_date" id="payment_report_date" action="dashboard_controller/payment_report_date">
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
                <button type="submit" class="btn bg-purple" id="payment_report"><?php echo trans("submit"); ?></button>
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
                        <table class="table table-bordered table-striped dataTable" id="payments_datatable" role="grid" aria-describedby="example1_info">
                            <thead>
                                <tr role="row">
                                    <th><?php echo ('total_product_amt'); ?></th>
                                    <th><?php echo ('commission_amt'); ?></th>
                                    <th><?php echo ('shipping_amt'); ?></th>
                                    <th><?php echo ('cod_amt'); ?></th>
                                    <th><?php echo ('getway_amt'); ?></th>
                                    <th><?php echo ('total_deduction'); ?></th>
                                    <th><?php echo ('tcs_amt'); ?></th>
                                    <th><?php echo ('tds_amt'); ?></th>
                                    <th><?php echo ('penalty_amt'); ?></th>
                                    <th><?php echo ('penalty_gst'); ?></th>
                                    <th><?php echo ('penalty_total'); ?></th>
                                    <th><?php echo ('net_balance'); ?></th>

                                </tr>

                            </thead>
                            <tbody id="payment_data">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>

<script>
    $("#payment_report_date").submit(function(e) {


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

        table = $('#payments_datatable').DataTable();
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
                        $('#payment_data').append("<tr><td>" + Json_data[i].total_product_amt + "</td><td>" + Json_data[i].commission_amt + "</td><td>" + Json_data[i].shipping_amt + "</td><td>" + Json_data[i].cod_amt + "</td><td>" + Json_data[i].getway_amt + "</td><td>" + Json_data[i].total_deduction + "</td><td>" + Json_data[i].tcs_amt + "</td><td>" + Json_data[i].tds_amt + "</td><td>" + Json_data[i].penalty_amt + "</td><td>" + Json_data[i].penalty_gst + "</td><td>" + Json_data[i].penalty_total + "</td><td>" + Json_data[i].net_balance + "</td></tr>")

                    }
                }
                $('#payments_datatable').dataTable({
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