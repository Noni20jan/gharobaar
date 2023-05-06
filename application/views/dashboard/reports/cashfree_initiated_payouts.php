<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
</link>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo $title; ?></h3>
    </div>

    <div class="box-body">
        <div class="row">
        </div>
        <div class="row">
            <div class="col-sm-12" style="overflow-x:scroll">
                <div class="table-responsive">
                    <!-- <? //php $this->load->view('dashboard/reports/filter_seller_cashfree_payouts'); 
                            ?> -->
                    <table id="seller_prepaid_dashboard" class="display" style="width:100%">

                        <thead>
                            <tr role="row">
                                <th><?php echo 'Sr. No.' ?></th>
                                <th><?php echo ('Batch Transfer ID'); ?></th>
                                <th><?php echo ('Order No.') ?></th>
                                <th><?php echo ('Payout Charge'); ?></th>
                                <th><?php echo ('Payout Amount'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="payouts_data">
                            <?php $i=1;?>
                            <?php foreach ($seller_initiated_pay as $sip) : ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $sip->batch_transfer_id; ?></td>
                                    <td><?php echo $sip->order_list; ?></td>
                                    <td><?php echo $sip->payout_charge; ?></td>
                                    <td><?php echo $sip->tot_net_seller_payable; ?></td>

                                </tr>
                               <?php $i++;?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#seller_prepaid_dashboard thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#seller_prepaid_dashboard thead');

        var table = $('#seller_prepaid_dashboard').DataTable({
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
</script>