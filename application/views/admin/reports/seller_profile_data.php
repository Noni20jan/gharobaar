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
            <h3 class="box-title" style="font-weight: 600;font-size: 20px;margin-bottom: 20px;"><?php echo trans('seller_profile_data'); ?></h3>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">


            <!-- <form name="saller_profile_data" id="saller_profile_data" action="admin_controller/format_seller_profile_data">
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
            </form> -->
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
                        <th>Pofile Status</th>
                        <th>Profile Created At</th>
                    </tr>
                </thead>
                <tbody id="seller_profile">
                    <?php foreach ($sale as $item) : ?>
                        <tr>
                            <td><?php echo $item->Seller; ?></td>
                            <td><?php echo $item->Seller_Email; ?></td>
                            <td><?php echo $item->Seller_Phone; ?></td>
                            <td><?php echo $item->Shop_Name; ?></td>
                            <td><?php echo $item->Pan; ?></td>
                            <td><?php echo $item->GST; ?></td>
                            <td><?php echo $item->Address; ?></td>
                            <td><?php echo $item->Account_No; ?></td>
                            <td><?php echo $item->Account_Holder; ?></td>
                            <td><?php echo $item->IFSC_Code; ?></td>
                            <td><?php echo $item->Bank_Branch; ?></td>
                            <td><?php echo $item->Profile_Status; ?></td>
                            <td><?php echo $item->Profile_Created_Date; ?></td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>

        </div>
    </div>
</div>
</div>
</div>
<script>
    //     $("#saller_profile_data").submit(function(e) {

    //         e.preventDefault(); // avoid to execute the actual submit of the form.

    //         var form = $(this);

    //         var d = form.serializeArray();
    //         d.push({
    //             name: csfr_token_name,
    //             value: $.cookie(csfr_cookie_name)
    //         });
    //         d.push({
    //             name: "sys_lang_id",
    //             value: sys_lang_id
    //         });

    //         var url = form.attr('action');

    //         table = $('#extend_datatable').DataTable();
    //         table.clear().destroy();

    //         $.ajax({
    //             type: "POST",
    //             url: base_url + url,
    //             data: d, // serializes the form's elements.
    //             success: function(data) {
    //                 // console.log("test",data);
    //                 var Json_data = JSON.parse(data);
    //                 console.log(Json_data.length);
    //                 var len = Json_data.length;
    //                 if (len != 0) {
    //                     for (var i = 0; i < len; i++) {
    //                         $('#seller_profile').append("<tr><td>" + Json_data[i].Seller + "</td><td>" + Json_data[i].Seller_Email + "</td><td>" + Json_data[i].Seller_Phone + "</td><td>" + Json_data[i].Shop_Name + "</td><td>" + Json_data[i].Pan + "</td><td>" + Json_data[i].GST + "</td><td>" + Json_data[i].Address + "</td><td>" + Json_data[i].Account_No + "</td><td>" + Json_data[i].Account_Holder + "</td><td>" + Json_data[i].IFSC_Code + "</td><td>" + Json_data[i].Bank_Branch + "</td><td>" + Json_data[i].Profile_Status + "</td><td>" + Json_data[i].Profile_Created_Date + "</td></tr>")
    //                     }
    //                 }
    //                 $('#extend_datatable').dataTable({

    //                     orderCellsTop: true,
    //                     fixedHeader: true,
    //                     initComplete: function() {
    //                         var api = this.api();

    //                         // For each column
    //                         api
    //                             .columns()
    //                             .eq(0)
    //                             .each(function(colIdx) {
    //                                 // Set the header cell to contain the input element
    //                                 var cell = $('.filters th').eq(
    //                                     $(api.column(colIdx + 1).header()).index()
    //                                 );
    //                                 var title = $(cell).text();
    //                                 $(cell).html('<input type="text" style="width:100%" placeholder="' + title + '" />');

    //                                 // On every keypress in this input
    //                                 $(
    //                                         'input',
    //                                         $('.filters th').eq($(api.column(colIdx).header()).index())
    //                                     )
    //                                     .off('keyup change')
    //                                     .on('keyup change', function(e) {
    //                                         e.stopPropagation();

    //                                         // Get the search value
    //                                         $(this).attr('title', $(this).val());
    //                                         var regexr = '({search})'; //$(this).parents('th').find('select').val();

    //                                         var cursorPosition = this.selectionStart;
    //                                         // Search the column for that value
    //                                         api
    //                                             .column(colIdx)
    //                                             .search(
    //                                                 this.value != '' ?
    //                                                 regexr.replace('{search}', '(((' + this.value + ')))') :
    //                                                 '',
    //                                                 this.value != '',
    //                                                 this.value == ''
    //                                             )
    //                                             .draw();

    //                                         $(this)
    //                                             .focus()[0]
    //                                             .setSelectionRange(cursorPosition, cursorPosition);
    //                                     });
    //                             });
    //                     },
    //                     dom: 'lBfrtip',
    //                     buttons: [{
    //                         extend: 'excel',
    //                         text: 'Export To Excel'
    //                     }],
    //                     "aLengthMenu": [
    //                         [15, 30, 60, 100],
    //                         [15, 30, 60, 100, "All"]
    //                     ],
    //                     "order": [
    //                         [0, "desc"]
    //                     ],
    //                 });
    //             }

    //         });


    //     });
    // 
</script>
<script>
    $(document).ready(function() {
        $('#extend_datatable').DataTable({
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
    });
</script>