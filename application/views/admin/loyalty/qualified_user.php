<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
    thead input {
        width: 100%;
    }

    .p-b-15 {
        padding-bottom: 15px !important;
    }

    .p-t-24 {
        padding-top: 24px !important;
    }

    .cross-color {
        color: red;
    }

    .color-check {
        color: green;
    }
</style>

<div class="row p-b-15">

    <form name="get_qualified_user" id="get_qualified_user" action="offer_controller/get_qualified_user_post">
        <div>
            <h4 class="p-b-15">Qualified Users</h4>
        </div>
        <div class="col-sm-5">
            <label for="meeting-time">Select Quater:</label>
            <select id="meeting-time" name="quater" class="form-control" required>
                <option value="">Select a Quater</option>
                <option value="Q-1">First Quater</option>
                <option value="Q-2">Second Quater</option>
                <option value="Q-3">Third Quater</option>
                <option value="Q-4">Fourth Quater</option>
            </select>
        </div>
        <div class="col-sm-5">
            <label for="meeting-time">Select Year:</label>
            <select id="meeting-time" name="year" class="form-control" required>
                <option value="">Select year</option>
                <?php foreach ($years as $year) : ?>
                    <option value="<?php echo $year->lp_year; ?>"><?php echo $year->lp_year; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-sm-2 p-t-24">
            <button type="submit" class="btn bg-purple">Search <i class="fa fa-search" aria-hidden="true"></i>
            </button>
        </div>
    </form>
</div>
<div id="offer-table">
    <table id="offer_dashboard" class="display" style="width:100%">
        <thead>
            <tr>
                <th>User</th>
                <th>Bronze</th>
                <th>Sliver</th>
                <th>Gold</th>
                <th>Platinum</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $qUser) :
                $user = get_user($qUser->user_id);
            ?>
                <tr class="text-center">
                    <td><?php echo $user->first_name . " " . $user->last_name; ?></td>
                    <td><i class="fa <?php echo (1 <= $qUser->lp_qualified_value && $qUser->lp_qualified_value < 2) ? 'fa-check color-check' : 'fa-times cross-color'; ?>" aria-hidden="true"></i></td>
                    <td><i class="fa <?php echo (2 <= $qUser->lp_qualified_value && $qUser->lp_qualified_value < 3) ? 'fa-check color-check' : 'fa-times cross-color'; ?>" aria-hidden="true"></i></td>
                    <td><i class="fa <?php echo (3 <= $qUser->lp_qualified_value && $qUser->lp_qualified_value < 4) ? 'fa-check color-check' : 'fa-times cross-color'; ?>" aria-hidden="true"></i></td>
                    <td><i class="fa <?php echo (4 <= $qUser->lp_qualified_value && $qUser->lp_qualified_value < 5) ? 'fa-check color-check' : 'fa-times cross-color'; ?>" aria-hidden="true"></i></td>
                    <td><a href="<?php echo (admin_url() . 'qualified-user-details/' . $qUser->id); ?>" style="text-decoration: underline; color:blue !important">Details</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- modal for showing details related to loyelty  -->
<div class="modal fade" id="loyaltyDetailModel" role="dialog">
    <div class="modal-dialog modal-dialog-centered login-modal" role="document">
        <div class="modal-content">
            <div class="auth-box" style="width: 370px;">
                <button type="button" class="close" data-dismiss="modal"><i class="icon-close" onclick="reloadPage()"></i></button>
                <h4 class="title"><?php echo trans("login"); ?></h4>
                <!-- form start -->

                <!-- form end -->
            </div>

        </div>
    </div>
</div>
<!-- end loyalty model  -->


<script>
    $(document).ready(function() {
        $('#offer_dashboard').DataTable();
    });
</script>

<script>
    $("#get_qualified_user").submit(function(e) {

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

        table = $('#offer_dashboard').DataTable();
        table.clear().destroy();

        $.ajax({
            type: "POST",
            url: base_url + url,
            data: d, // serializes the form's elements.
            success: function(data) {
                jsonData = JSON.parse(data);
                if (jsonData.status) {
                    $("#offer-table").html(jsonData.html_content);
                    setTimeout(function() {
                        $('#offer_dashboard').DataTable();
                    }, 200)
                }

            }
        });


    });
</script>