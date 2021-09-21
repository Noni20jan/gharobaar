<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
    thead input {
        width: 100%;
    }
</style>

<table id="offer_dashboard" class="display" style="width:100%">
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
        <?php foreach ($offers as $offer) : ?>
            <tr>
                <td><?php echo $offer->name; ?></td>
                <td><?php echo $offer->offer_code; ?></td>
                <td><?php echo $offer->creation_date; ?></td>
                <td><?php echo $offer->end_date; ?></td>
                <td><?php echo $offer->status; ?></td>
                <td><?php echo $offer->type; ?></td>
                <td><?php echo $offer->discount_amt; ?></td>
                <td><?php echo $offer->discount_percentage; ?></td>
                <td><a href="<?php echo admin_url(); ?>edit-voucher-details/<?php echo html_escape($offer->id); ?>"><input id="<?php echo html_escape($offer->id); ?>" class="favorite styled" type="button" value="Edit"></a></td>
            </tr>
        <?php endforeach; ?>
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