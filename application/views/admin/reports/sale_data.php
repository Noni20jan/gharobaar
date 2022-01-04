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

    .row {

        overflow-x: auto;
    }
</style>
<div class="col-lg-12 col-md-12">
    <div class="box">
        <div class="box-header with-border">
            <div class="pull-left">
                <h3 class="box-title"><?php echo trans('sale-data'); ?></h3>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="table-responsive">
                    <div class="col-sm-12">
                        <table class="table table-bordered table-striped " id="extend_datatable" role="grid">
                            <thead>
                                <tr role="row">
                                    <th>Seller Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Shop</th>
                                    <th>Pan</th>
                                    <th>GST</th>
                                    <th>Address</th>
                                    <th>Account Number</th>
                                    <th>Account Holder</th>
                                    <th>IFSC Code</th>
                                    <th>Branch Name</th>
                                    <th>Profile Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($seller)) : ?>
                                    <?php foreach ($seller as $data) :
                                    ?>
                                        <tr>
                                            <td><?php echo html_escape($data->Seller); ?></td>
                                            <td><?php echo html_escape($data->Seller_Email); ?></td>
                                            <td><?php echo html_escape($data->Seller_Phone); ?></td>
                                            <td><?php echo html_escape($data->Shop_Name); ?></td>
                                            <td><?php echo html_escape($data->Pan); ?></td>
                                            <td><?php echo html_escape($data->GST); ?></td>
                                            <td><?php echo html_escape($data->Address); ?></td>
                                            <td><?php echo html_escape($data->Account_No); ?></td>
                                            <td><?php echo html_escape($data->Account_Holder); ?></td>
                                            <td><?php echo html_escape($data->IFSC_Code); ?></td>
                                            <td><?php echo html_escape($data->Bank_Branch); ?></td>
                                            <td><?php echo html_escape($data->Profile_Created_Date); ?></td>

                                        </tr>



                                    <?php endforeach; ?>

                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        table = $('#extend_datatable').DataTable({
            dom: 'lBfrtip',
            buttons: [
                'excel', 'pdf'
            ],
            "aLengthMenu": [
                [15, 30, 60, 100],
                [15, 30, 60, 100, "All"]
            ],
            "order": [
                [0, "desc"]
            ],

        });

    });
</script>