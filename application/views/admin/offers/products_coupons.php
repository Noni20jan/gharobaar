<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
    thead input {
        width: 100%;
    }
</style>
<h3>Coupons</h3>
<table id="offers" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Offer Id</th>
            <th>Coupon Name</th>
            <th>Method</th>
            <th>Source Type</th>
            <!-- <th>Source Id</th> -->
            <th>Created Date</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($coupons as $coupon) : ?>
            <tr>
                <td><?php echo $coupon->offer_id; ?></td>
                <td><?php echo $coupon->name; ?></td>
                <td><?php echo $coupon->method; ?></td>
                <td><?php echo $coupon->source_type; ?></td>
                <!-- <td class="source_id"><?php echo $coupon->source_id; ?></td> -->
                <td><?php echo $coupon->creation_date; ?></td>

                <td> <button type="button" id="btn_ckimg_delete" class="btn btn-sm btn-danger color-white pull-left btn-file-delete m-r-3" onclick="delete_item('coupon_controller/delete_coupon','<?php echo $coupon->id; ?>','Are you sure you want to delete the coupon');"><i class="icon-trash"></i>&nbsp;&nbsp;<?php echo trans('delete'); ?></button>
                </td>
            </tr>
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
