<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
    thead input {
        width: 100%;
    }
</style>

<table id="example" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Coupon Name</th>
            <th>Code</th>
            <th>Date Generated</th>
            <th>Expiry Date</th>
            <th>Status</th>
            <th>Offer Type</th>
            <th>Amount</th>
            <th>%</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Tiger Nixon</td>
            <td>System Architect</td>
            <td>Edinburgh</td>
            <td>61</td>
            <td>2011/04/25</td>
            <td>$320,800</td>
            <td>61</td>
            <td>61</td>
            <td>61</td>
        </tr>
        <tr>
            <td>Garrett Winters</td>
            <td>Accountant</td>
            <td>Tokyo</td>
            <td>63</td>
            <td>2011/07/25</td>
            <td>$170,750</td>
            <td>61</td>
            <td>61</td>
            <td>61</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th>Coupon Name</th>
            <th>Code</th>
            <th>Date Generated</th>
            <th>Expiry Date</th>
            <th>Status</th>
            <th>Offer Type</th>
            <th>Amount</th>
            <th>%</th>
            <th>Action</th>
        </tr>
    </tfoot>
</table>



<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#example thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#example thead');

        var table = $('#example').DataTable({
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
                            $(api.column(colIdx).header()).index()
                        );
                        var title = $(cell).text();
                        $(cell).html('<input type="text" placeholder="' + title + '" />');

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