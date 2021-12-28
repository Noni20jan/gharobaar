<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'>



<style>
    .ui-datepicker {
        width: 16em;
    }
</style>
<div class="row table-filter-container">
    <div class="col-sm-12">
        <?php //echo form_open('order_controller/payout_initiate'); 
        ?>
        <form name="payout_initiate" id="payout_initiate" action="order_controller/initiated_cod_payout">
            <div class="item-table-filter">
                <label><?php echo trans("from_date"); ?></label>
                <input name="from_date" class="form-control" type="text" id="my_date_picker1" autocomplete="off" value="<?php echo html_escape($this->input->get('q', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
            </div>
            <div class="item-table-filter">
                <label><?php echo trans("to_date"); ?></label>
                <input name="to_date" class="form-control" type="text" id="my_date_picker2" autocomplete="off" value="<?php echo html_escape($this->input->get('q', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
            </div>
            <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                <label style="display: block">&nbsp;</label>
                <button type="submit" class="btn bg-purple"><?php echo trans("submit"); ?></button>
            </div>
        </form>
        <?php //echo form_close(); 
        ?>
    </div>

</div>
<script>
    $(document).ready(function() {

        $(function() {
            $("#my_date_picker1").datepicker({
                dateFormat: 'yy-mm-dd'
            });

        });

        $(function() {
            $("#my_date_picker2").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });

        $('#my_date_picker1').change(function() {
            startDate = $(this).datepicker('getDate');
            $("#my_date_picker2").datepicker("option", "minDate", startDate);
        })

        $('#my_date_picker2').change(function() {
            endDate = $(this).datepicker('getDate');
            $("#my_date_picker1").datepicker("option", "maxDate", endDate);
        })
    })
</script>
<script>
    $("#payout_initiate").submit(function(e) {


        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);

        var d = form.serializeArray();
        d.push({
            name: csfr_token_name,
            value: $.cookie(csfr_cookie_name)
        });
        d.push({
            name: "sys_lang_id",
            value: sys_lang_id
        });

        var url = form.attr('action');

        table = $('#cod_offer_dashboard').DataTable();
        table.clear().destroy();

        $.ajax({
            type: "POST",
            url: base_url + url,
            data: d, // serializes the form's elements.
            success: function(data) {
                // console.log("test",data);
                var Json_data = JSON.parse(data);
                console.log(Json_data.length);
                var len = Json_data.length;
                if (len != 0) {
                    for (var i = 0; i < len; i++) {
                        $('#payouts_data').append("<tr><td>" + (j = i + 1) + "</td><td>" + Json_data[i].order_id + "</td><td>" + Json_data[i].shop_name + "</td><td>" + Json_data[i].created_at + "</td><td>" + Json_data[i].status + "</td><td>" + ((Json_data[i].grand_total_amount) / 100).toFixed(2) + "</td><td>" + ((Json_data[i].shipping_charge_to_gharobaar) / 100).toFixed(2) + "</td><td>" + ((Json_data[i].cod_charge) / 100).toFixed(2) + "</td><td>" + (((Json_data[i].Sup_Shipping_gst / 100) + (Json_data[i].Sup_cod_gst / 100) + (Json_data[i].Sup_subtotal_prd_gst / 100))).toFixed(2) + "</td><td>" + ((Json_data[i].net_seller_payable) / 100).toFixed(2) + "</td><td>" + (Json_data[i].referenceId) + "</td><td>" + (Json_data[i].message) + "</td><td>" + (Json_data[i].subCode) + "</td><td>" + (Json_data[i].batch_transfer_id) + "</td></tr>")
                    }
                }
                
                
                
                
                               
                $('#cod_offer_dashboard').dataTable({
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
            }

        });


    });
</script>