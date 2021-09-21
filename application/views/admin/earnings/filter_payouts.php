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
        <form name="payout_initiate" id="payout_initiate" action="order_controller/payout_initiate">
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

        table = $('#payouts_table').DataTable();
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
                        $('#payouts_data').append("<tr><td><input type='checkbox' onchange='checkbox(this,"+JSON.stringify(Json_data[i])+")'></td><td>" + (j = i + 1) + "</td><td>" + Json_data[i].order_id + "</td><td>" + Json_data[i].shop_name + "</td><td>" + Json_data[i].created_at + "</td><td>" + Json_data[i].order_status + "</td><td>" + (Json_data[i].net_seller_payable)/100 + "</td></tr>")
                    }
                }
                $('#payouts_table').dataTable({
                    paging: true,
                    searching: true
                });
            }

        });


    });
</script>