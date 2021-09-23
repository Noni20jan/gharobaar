<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
</link>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<style>
    .nxt-cancel-btns {
        text-align: center;

        position: relative;
        top: 50px;
    }
#offer_id{
    display: initial;
    width: 39%;
    height: 36px;
    background-color: #fff;
    border-radius: 20px;
    outline: none;
}
    .nxt-cancel-styls {
        width: 100px;
        background: #185d8c;
        border-color: #185d8c;
        color: white;
        float: right;
    }
</style>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title">Vouchers </h3>
        </div>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <form id="submit_val">
                    <input id='my_match' type='hidden' name='all_selected_check' />
                    <label for="cars"><b>Choose a voucher:</b></label>

                    <select  id="offer_id">
                    <option selected="true" disabled="disabled">Please select an option</option>
                        <?php foreach ($offers as $voucher) : ?>

                            <option value="<?php echo $voucher->id ?>"><?php echo $voucher->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">

                <label for="cars">Select Users:</label>
                <div class="table-responsive">
                    <!-- <form id="users" name="users" action="membership_controller/user_post" method="post"> -->

                    <table id="example" class="table table-bordered table-striped">
                        <thead>
                            <tr role="row">
                                <th width="20"><?php echo trans("id"); ?></th>
                                <th><?php echo trans("username"); ?></th>
                                <th><?php echo trans("email"); ?></th>
                                <th><?php echo trans("status"); ?></th>
                                <th><?php echo str_replace(":", "", trans("last_seen")); ?></th>
                                <th><?php echo trans("date"); ?></th>
                                <th><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
                            </tr>
                        </thead>
                        <tbody id="insert_data">
                             <!-- <?php foreach ($users as $user) : ?>
                                 <tr>
                                    <td><?php echo html_escape($user->id); ?></td>
                                    <td>
                                        <a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank" class="table-link">
                                            <img src="<?php echo get_user_avatar($user); ?>" alt="user" class="img-responsive" style="width: 50px;">
                                        </a>
                            </td>
                                    <td>
                                        <a href="<?php echo generate_profile_url($user->slug); ?>" target="_blank" class="table-link"><?php echo ($user->username); ?></a>
                                    </td>
                                    <td>
                                        <?php echo html_escape($user->email);
                                        if ($user->email_status == 1) : ?>
                                            <small class="text-success">(<?php echo trans("confirmed"); ?>)</small>
                                        <?php else : ?>
                                            <small class="text-danger">(<?php echo trans("unconfirmed"); ?>)</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($user->banned == 0) : ?>
                                            <label class="label label-success"><?php echo trans('active'); ?></label>
                                        <?php else : ?>
                                            <label class="label label-danger"><?php echo trans('banned'); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo time_ago($user->last_seen); ?></td>
                                    <td><?php echo formatted_date($user->created_at); ?></td>
                                    <td><input type="checkbox" name="selected_id" value="<?php echo $user->id; ?> ">

                                    </td>

                                </tr>
                            <?php endforeach; ?> -->
                        </tbody>
                    </table>

                    <?php if (empty($users)) : ?>
                        <p class="text-center text-muted" style="display:none;"><?= trans("no_records_found"); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <button type="button" id="submit_val_button" class="nxt-cancel-styls">Done</button>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        var table = $('#example').DataTable({

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
      


        // Handle click on "Select all" control
        $('#example-select-all').on('click', function() {
            // Check/uncheck all checkboxes in the table
            var rows = table.rows({
                'search': 'applied'
            }).nodes();
            $('#product_checkbox', rows).prop('checked', this.checked);
        });
        

        // Handle click on checkbox to set state of "Select all" control

    });
</script>
<script>
    $('#submit_val_button').click(function() {
        var arr = [];
        $('input:checked[name=selected_id]').each(function() {
            arr.push($(this).val());
        });

        $('#my_match').val(arr.join(':'));
        alert($('#my_match').val());

        console.log(typeof(($('#my_match').val())));

        var source_id = ($('#my_match').val());
        var z = source_id.trim();

        var arr_source_id = (z.split(':'));
        var split_arr = arr_source_id.map(s => s.trim())

        var offer_id = ($('#offer_id').val());
        console.log(offer_id);
        var data = {
            'source_type': 'Product',
            'source_id': split_arr,
            'offer_id': offer_id
        }
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({

            type: "POST",
            url: base_url + "add-user-coupon",

            data: data,

            success: function(data) {
                location.reload();
            },
            error: function() {
                alert("error"); //error occurs
            }
        });
        return false;
    });
</script>
     <script>
        $('#offer_id').change(function() {
            table = $('#example').DataTable();
        table.clear().destroy();

            var offer_id = ($('#offer_id').val());
            var data = {
                'offer_id': offer_id
            }
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
             $.ajax({

                 type: "POST",
                 url: base_url + "get-user-coupon",
                 data: data,
                success: function(data) {
                    var Json_data = JSON.parse(data);
                    console.log(Json_data);
                    var len = Json_data.length;
                    console.log(len);
                 
                    for (var i = 0; i < len; i++) {
                        
                
                        
                        $('#insert_data').append("<tr><td>"+Json_data[i].id+ "</td><td>" +'<a href="<?php echo base_url()."profile"; ?>/'+Json_data[i].slug+'"target="_blank" class="table-link">'+ Json_data[i].username + "</td><td>"+ Json_data[i].email+ "</td><td>"+'<label class="label label-success">'+'<?php echo trans("active");?>'+'</label>'+"</td><td>"+Json_data[i].last_seen+"</td><td>"+Json_data[i].created_at+"</td><td>"+'<input type="checkbox" name="selected_id" id="product_checkbox" value="'+Json_data[i].id+'">'+"</td></tr>")
                    }
                var table = $('#example').DataTable({

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



// Handle click on "Select all" control
$('#example-select-all').on('click', function() {
// Check/uncheck all checkboxes in the table
var rows = table.rows({
    'search': 'applied'
}).nodes();
$('#product_checkbox', rows).prop('checked', this.checked);
});
}     
             });
            });
    </script>
       
       