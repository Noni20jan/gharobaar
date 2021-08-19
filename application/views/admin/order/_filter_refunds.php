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
        <?php //echo form_open('order_controller/fetch_all_refunds'); 
        ?>
        <form name="fetch_all_refunds" id="fetch_all_refunds" action="order_controller/fetch_all_refunds">
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
    $("#fetch_all_refunds").submit(function(e) {
        

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

        table = $('#refunds_table').DataTable();
        table.clear().destroy();

        $.ajax({
            type: "POST",
            url: base_url + url,
            data: d, // serializes the form's elements.
            success: function(data) {
                var Json_data = JSON.parse(data);
                var len = Json_data.refunds.length;
                if (len != 0) {
                    for (var i = 0; i < len; i++) {
                        $('#refunds_data').append('<tr><td>' + (j = i + 1) + '</td><td>' + Json_data.refunds[i].refundId + '</td><td>' + Json_data.refunds[i].sys_order_id + '</td><td>' + Json_data.refunds[i].arn + '</td><td>' + Json_data.refunds[i].referenceId + '</td><td>' + Json_data.refunds[i].txAmount + '</td><td>' + Json_data.refunds[i].refundAmount + '</td><td>' + Json_data.refunds[i].note + '</td><td>' + Json_data.refunds[i].processed + '</td><td>' + Json_data.refunds[i].initiatedOn + '</td><td>' + Json_data.refunds[i].processedOn + '</td></tr>')
                    }
                }
                $('#refunds_table').dataTable({
                    paging: true,
                    searching: true
                });
            }

        });


    });
</script>