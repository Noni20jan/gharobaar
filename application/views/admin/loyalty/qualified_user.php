<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
    thead input {
        width: 100%;
    }

    .p-b-15 {
        padding-bottom: 15px !important;
    }
</style>

<table id="offer_dashboard" class="display" style="width:100%">

    <div class="row p-b-15">
        <h4 class="text-center p-b-15">Select Period</h4>
        <div class="col-sm-5">
            <label for="meeting-time">From:</label>
            <input type="datetime-local" class="form-control" id="meeting-time" name="start_date" value="2000-01-12T19:30" required>
        </div>
        <div class="col-sm-5">
            <label for="meeting-time">To:</label>
            <input type="datetime-local" id="meeting-time" class="form-control" name="end_date" value="2000-06-12T19:30" required>
        </div>
        <div class="col-sm-2">
            <button><i class="fa fa-search" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <thead>
        <tr>
            <th>User</th>
            <th>Bronze</th>
            <th>Sliver</th>
            <th>Gold</th>
            <th>Platinum</th>
            <th>View</th>
            <!-- <th>%</th>
            <th>Action</th> -->
        </tr>
    </thead>
    <tbody>
        <? //php foreach ($offers as $offer) : 
        ?>
        <!-- <tr>
                <td><?php echo $offer->name; ?></td>
                <td><?php echo $offer->offer_code; ?></td>
                <td><?php echo $offer->creation_date; ?></td>
                <td><?php echo $offer->end_date; ?></td>
                <td><?php echo $offer->status; ?></td>
                <td><?php echo $offer->type; ?></td>
                <td><?php echo $offer->discount_amt; ?></td>
                <td><?php echo $offer->discount_percentage; ?></td>
                <td><a href="<?php echo admin_url(); ?>edit-coupon-details/<?php echo html_escape($offer->id); ?>"><input id="<?php echo html_escape($offer->id); ?>" class="favorite styled" type="button" value="Edit"></a></td>
            </tr> -->
        <? //php endforeach;
        ?>
    </tbody>
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