<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    /* label {
        display: block;
        font: 1rem 'Fira Sans', sans-serif;
    }

    input,
    label {
        margin: .4rem 0;
    } */

    .coupons-from-holder {
        backdrop-filter: blur(1px);
        background: #ffffffa6;
        padding: 40px;
        border-radius: 10px;
        margin-top: 20px;
    }

    .nxt-cancel-btns {
        text-align: center;
    }

    .nxt-cancel-styls {
        width: 100px;
        background: #185d8c;
        border-color: #185d8c;
        color: white;
    }
</style>
<!-- form start -->
<?php echo form_open('admin_controller/loyalty_program_submit'); ?>
<div class="col-12 coupons-from-holder">
    <div class="form-group">
        <div class="row">
            <div class="col-sm-6"><label>User Type:</label></div>
            <div class="col-sm-6">
                <select name="user_type" class="form-control auth-form-input" id="offer-type">
                    <?php foreach ($user_type as $user_type) { ?>
                        <option value="<?php echo $user_type->id; ?>"><?php echo $user_type->lookup_code; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-sm-12"><label>KPI</label></div>
            <div class="input_fields_container">
                <button class="btn btn-sm btn-primary add_more_button">Add More Rows</button>
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-3">
            <label>NAME:</label>
            <input type='text' name="kpi_name" class="form-control auth-form-input" value="" placeholder="Name" required>
        </div>
        <div class="col-sm-3">
            <label>KPI Type:</label>
            <select class="form-control auth-form-input" name="kpi_type" id="kpi_type" onchange="child_parent_name();">
                <option value="parent">Parent</option>
                <option value="child">Child</option>
                <option value="individual">Individual</option>
            </select>
        </div>
        <div class="col-sm-3">
            <label>Parent KPI</label>
            <input type='text' name="parent_name" id="parent_name" placeholder="Parent KPI" class="form-control auth-form-input" value="">
        </div>
        <div class="col-sm-2">
            <label>Weightage</label>
            <input type="number" maxlength="3" name="weightage" placeholder="Weightage" class="form-control auth-form-input" value="" required>
        </div>
        <!-- <div class="col-sm-4"><label>Formula/SQL</label>

            <input type='text' placeholder="Formula" name="formula" class="form-control auth-form-input" value="" required>
        </div> -->
    </div>
    <div class="input_fields_container1">
    </div>
</div>



<div class=" box-footer">
    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('submit'); ?></button>
</div>


<?php echo form_close(); ?>
<script>
    $(document).ready(function() {
        $('#parent_name').prop('disabled', true);
        var max_fields_limit = 10;
        // set limit  for maximum input fields
        var x = 1; //initialize counter for text box
        $('.add_more_button').click(function(e) { //click event on add more fields button having class add_more_button
            e.preventDefault();
            if (x < max_fields_limit) { //check conditions
                x++; //counter increment
                $('.input_fields_container1').append('<div id="row' + x + '"><div class="row form-group">' +
                    '<div class="col-sm-3">' +
                    '<input type="text" name="kpi_name" placeholder="Name" class="form-control auth-form-input" value="" required> </div><div class="col-sm-3"> <select class="form-control auth-form-input" name="kpi_type" id="kpi_type' + x + '" onchange="child_parent_name1(' + x + ');"> <option value="parent">Parent</option><option value="child">Child</option><option value="individual">Individual</option></select></div>' +
                    ' <div class="col-sm-3"> <input type="text" id="parent_name' + x + '" disabled placeholder="Parent KPI" name="parent_name" class="form-control auth-form-input" value=""> </div>' +
                    ' <div class="col-sm-2"> <input type="number" maxlength="3" name="weightage"placeholder="Weihtage" class="form-control auth-form-input" value="" required> </div>' +
                    '<button type="button" name="remove"" id="' + x + '" class="btn btn-danger remove_field"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d = "M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />' +
                    '<path fill - rule = "evenodd" d = "M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" / ></svg><i class="bi bi-trash"></i > </button></div></div></div > ');
                // add input field

                //<div class="col-sm-4"><input type="text" name="formula"placeholder="Formula" class="form-control auth-form-input" value="" required> 
            }
        });
        $('.input_fields_container1').on("click", ".remove_field", function(e) {
            //user click on remove text links
            e.preventDefault();
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
            x--;
        })
    });
</script>

<script>
    function child_parent_name() {
        var kpi_type = document.getElementById('kpi_type').value;
        console.log(kpi_type);
        if (kpi_type == "child") {
            $('#parent_name').prop('disabled', false);
        } else {
            $('#parent_name').prop('disabled', true);
        }
    }
</script>
<script>
    function child_parent_name1(x) {
        var kpi_type = document.getElementById('kpi_type' + x).value;
        console.log(kpi_type + x);
        if (kpi_type == "child") {
            $('#parent_name' + x).prop('disabled', false);
        } else {
            $('#parent_name' + x).prop('disabled', true);
        }
    }
</script>