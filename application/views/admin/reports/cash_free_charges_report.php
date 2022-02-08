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



    .index-table {
        max-height: 600px;
        overflow-x: auto;
    }
</style>
<div class="box-body index-table">
    <div class="box-header with-border">
        <div class="pull-left">
            <h3 class="box-title" style="font-weight: 600;font-size: 20px;margin-bottom: 20px;"><?php echo trans('cash_free_charges_reports'); ?></h3>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <div class="filter">
                <form name="cash_free" id="cash_free" action="admin_controller/cash_free_charges">
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
                            <th> Order Date</th>
                            <th>Order ID</th>
                            <th>Payment Mode</th>
                            <th>Commission Rate</th>
                            <th>Status</th>
                            <th>Buyer ID</th>
                            <th>Buyer Name</th>
                            <th>Buyer Username</th>
                            <th>Buyer Phone_Number</th>
                            <th>Buyer Email</th>
                            <th>Brand Name</th>
                            <th>Seller PAN Number</th>
                            <th>Seller Shop Name</th>
                            <th>Seller E-Mail</th>
                            <th>Product SKU</th>
                            <th>Product Title</th>
                            <th>Product GST_Rate</th>
                            <th>Product Total_Price</th>
                            <th>Shipping Cost</th>
                            <th>Amount Received</th>
                            <th>Seller Payable</th>
                            <th>Payout Initiated</th>
                            <th>Commission Amount</th>
                            <th>Commission Amount With GST</th>
                            <th>Shipping Charges To Gharobaar</th>
                            <th>TCS Amount</th>
                            <th>TDS Amount</th>
                            <th>Gateway Amount</th>
                            <th>Gateway Amount With_GST</th>
                            <th>Cashfree order ID</th>
                            <th>Cashfree Payment ID</th>

                        </tr>
                    </thead>
                    <tbody id="cash_free_data">

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        table = $('.button').DataTable({


        });

    });

    $("#cash_free").submit(function(e) {

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
                        $('#cash_free_data').append("<tr><td>" + Json_data[i].Order_Date + "</td><td>" + Json_data[i].Order_ID + "</td><td>" + Json_data[i].Payment_Mode + "</td><td>" + Json_data[i].Commission_Rate + "</td><td>" + Json_data[i].Status + "</td><td>" + Json_data[i].Buyer_ID + "</td><td>" + Json_data[i].Buyer_Name + "</td><td>" + Json_data[i].Buyer_Username + "</td><td>" + Json_data[i].Buyer_Phone_Number + "</td><td>" + Json_data[i].Buyer_Email + "</td><td>" + Json_data[i].Brand_Name + "</td><td>" + Json_data[i].Seller_PAN_Number + "</td><td>" + Json_data[i].Seller_Shop_Name + "</td><td>" + Json_data[i].Seller_E_mail + "</td><td>" + Json_data[i].Product_SKU + "</td><td>" + Json_data[i].Product_Title + "</td><td>" + Json_data[i].Product_GST_Rate + "</td><td>" + Json_data[i].Product_Total_Price + "</td><td>" + Json_data[i].Shipping_Cost + "</td><td>" + Json_data[i].Amount_Received + "</td><td>" + Json_data[i].Seller_Payable + "</td><td>" + Json_data[i].Payout_Initiated + "</td><td>" + Json_data[i].Commission_Amount + "</td><td>" + Json_data[i].Commission_Amount_With_GST + "</td><td>" + Json_data[i].Shipping_charges_to_gharobaar + "</td><td>" + Json_data[i].TCS_Amount + "</td><td>" + Json_data[i].TDS_Amount + "</td><td>" + Json_data[i].Gateway_Amount + "</td><td>" + Json_data[i].Gateway_Amount_With_GST + "</td><td>" + Json_data[i].Cashfree_order_ID + "</td><td>" + Json_data[i].Cashfree_Payment_ID + "</td></tr>")
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