<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
</link>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $title; ?></h3>
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="row">
            <!-- include message block -->
            <!-- <div class="col-sm-12">
				<? //php $this->load->view('admin/includes/_messages'); 
                ?>
			</div> -->
        </div>
        <div class="row">
            <div class="col-sm-12" style="overflow-x:scroll !important">
                <div class="table-responsive">
                    <?php $this->load->view('admin/earnings/filter_prepaid_payout_initiated'); ?>
                    <!-- <table class="table table-bordered table-striped" role="grid"> -->
                    <table id="prepaid_offer_dashboard" class="display" style="width:100%">

                        <thead>
                            <tr role="row">
                                <!-- <th><input type="checkbox" id="allCheck" name="allCheck" onchange="checkallchecks(this)" value=""></th> -->
                                <!-- <th></th> -->
                                <th><?php echo 'Sr. No.' ?></th>
                                <th><?php echo trans('order_id'); ?></th>
                                <th><?php echo trans('seller') ?></th>
                                <th><?php echo trans('order_date'); ?></th>
                                <!-- <th><?php echo trans('status'); ?></th> -->
                                <th><?php echo ('order status'); ?></th>
                                <th><?php echo ('Order Value'); ?></th>
                                <th><?php echo ('Shipping'); ?></th>
                                <th><?php echo ('COD'); ?></th>
                                <th><?php echo ('Total GST'); ?></th>
                                <th><?php echo ('Seller Payable'); ?></th>
                                <th><?php echo ('ReferenceId'); ?></th>
                                <th><?php echo ('Message'); ?></th>
                                <th><?php echo ('SubCode'); ?></th>
                                <th><?php echo ('Batch Transfer Id'); ?></th>
                                <th><?php echo ('Transfer Id'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="payouts_data">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div><!-- /.box-body -->
    <!-- <div class="row">
        <button type="submit" id="ini_pay_btn" class="btn bg-purple" style="float: right;" onclick="init_pay(data_cal,'prepaid');"><?php echo ("Initiate Payout"); ?></button>
    </div> -->
</div>
<!-- <script>
    $(document).ready(function() {
        $('#payouts_table').DataTable({
            paging: false,
            searching: false,
            'columnDefs': [{
                'targets': [0], // column index (start from 0)
                'orderable': false, // set orderable false for selected columns
            }]
        });
    });
</script> -->
<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#prepaid_offer_dashboard thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#prepaid_offer_dashboard thead');

        var table = $('#prepaid_offer_dashboard').DataTable({
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
        });
    });
</script>


<script>
    var arr = [];
    var fullDataArr = [];
    var duplicateArr = [];
    var data_cal = [];




    function checkbox(ele, data) {
        var obj = {};
        obj.order_id = data.order_id;
        obj.seller_id = data.id;
        obj.phone = data.phone_number;
        obj.email = data.email;
        obj.acc_no = data.account_number;
        obj.acc_name = data.acc_holder_name;
        obj.ifsc = data.ifsc_code;
        obj.seller_pay = parseInt(data.net_seller_payable);


        if (ele.checked) {

            if (data_cal.length > 0) {
                var is_exists = 0;
                for (var i = 0; i < data_cal.length; i++) {
                    var exist_obj = data_cal[i];
                    if (exist_obj.seller_id == obj.seller_id) {
                        exist_obj.seller_pay += parseInt(obj.seller_pay);
                        is_exists = 1;
                    } else {
                        is_exists = 0;
                    }
                }
                if (!is_exists) {
                    data_cal.push(obj);
                }
            } else {
                data_cal.push(obj);
            }


        } else {
            if (data_cal.length > 0) {
                var index_obj = 0;
                for (var i = 0; i < data_cal.length; i++) {
                    var exist_obj = data_cal[i];
                    if (exist_obj.seller_id == obj.seller_id) {
                        exist_obj.seller_pay -= parseInt(obj.seller_pay);
                        if (exist_obj.seller_pay == 0) {
                            index_obj = i;
                            data_cal.splice(index_obj, 1);
                        }
                    }
                }

            }
        }

        console.log(data_cal);
    }

    // function checkallchecks(ele) {
    //     if (ele.checked) {
    //         $("input[type='checkbox']").prop("checked", true);
    //         $('input[type=checkbox]').attr('disabled', true);
    //         document.getElementById("allCheck").disabled = false;

    //         for (i = 0; i < fullDataArr.length; i++) {
    //             duplicateArr[i] = fullDataArr[i];
    //         }
    //     } else {
    //         $('input[type=checkbox]').attr('disabled', false);
    //         $("input[type='checkbox']").prop("checked", false);

    //         duplicateArr = [];
    //         arr = [];
    //     }
    //     console.log(duplicateArr);
    // }
</script>