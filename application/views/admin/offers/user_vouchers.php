<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
    thead input {
        width: 100%;
    }
</style>

<table id="offers" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Offer Id</th>
            <th>Voucher Name</th>

            <th>Email Address</th>
            <th>Voucher Code</th>

            <th>Start Date</th>
            <th>End Date</th>
            <th></th>
        </tr>
    </thead>
    <tbody>


        <?php foreach ($coupons as $coupon) : ?>
            <?php $zak = get_user($coupon->source_id); ?>
            <?php if (!empty($zak)) : ?>
                <tr>
                    <td><?php echo $coupon->offer_id; ?></td>
                    <td><?php echo $coupon->name; ?></td>

                    <td class="source_id"><?php echo $zak->email; ?></td>
                    <td class="source_id"><?php echo $coupon->offer_code; ?></td>

                    <td><?php echo $coupon->start_date; ?></td>
                    <td><?php echo $coupon->end_date; ?></td>


                    <td> <button type="button" id="btn_ckimg_delete" class="btn btn-sm btn-danger color-white pull-left btn-file-delete m-r-3" onclick="delete_item('coupon_controller/delete_coupon','<?php echo $coupon->id; ?>','Are you sure you want to delete the voucher');"><i class="icon-trash"></i>&nbsp;&nbsp;<?php echo trans('delete'); ?></button>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>

    </tbody>

</table>
<script>
    $(document).ready(function() {
        var table = $('#offers').DataTable({

            'columnDefs': [{
                'targets': 0,
                "bPaginate": false,
                "bFilter": false,
                'searchable': true,
                'orderable': false,
                'className': 'dt-body-center',

            }],
            'order': [1, 'asc']
        });


    });
</script>