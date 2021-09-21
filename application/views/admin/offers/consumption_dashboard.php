<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
    thead input {
        width: 100%;
    }
</style>

<table id="offer_dashboard" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Sr. No.</th>
            <th>Email</th>
            <th>Offer Name</th>
            <th>Offer Type</th>
            <th>Code</th>
            <th>Timestamp</th>
            <th>Total Discount</th>
        </tr>
    </thead>
    <tbody>
        <?php $count = count($consumptions); ?>
        <?php foreach ($consumptions as $consumption) : ?>
            <tr>
                <td>
                    <?php for ($i = 1; $i <= $count; $i++) {
                        echo $i;
                    } ?>
                </td>
                <td><?php echo $consumption->email; ?></td>
                <td><?php echo $consumption->name; ?></td>
                <td><?php echo $consumption->method; ?></td>
                <td><?php echo $consumption->offer_code; ?></td>
                <td><?php echo $consumption->creation_date; ?></td>
                <td><?php echo $consumption->total_discount; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Sr. No.</th>
            <th>Email</th>
            <th>Offer Name</th>
            <th>Offer Type</th>
            <th>Code</th>
            <th>Timestamp</th>
            <th>Total Discount</th>
        </tr>
    </tfoot>
</table>



<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#offer_dashboard thead tr')
            .clone(true)
            .addClass('filters')
            .appendTo('#offer_dashboard thead');

        var table = $('#offer_dashboard').DataTable({
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