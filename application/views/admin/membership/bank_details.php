<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .view {
        color: #fff;
    }

    .view:hover {
        color: #fff;
    }
</style>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title">Bank Approval Requests</h3>
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
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr role="row">
                                <th width="20"><?php echo trans("id"); ?></th>
                                <th><?php echo trans("image"); ?></th>
                                <th><?php echo trans("username"); ?></th>
                                <th><?php echo trans("shop_name"); ?></th>
                                <th><?php echo trans("shop_description"); ?></th>
                                <th><?php echo trans("location"); ?></th>
                                <!-- <th><?= trans("membership_plan"); ?></th>
                                <th><?= trans("payment"); ?></th> -->
                                <th class="max-width-120"><?php echo trans("options"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) :
                                $membership_plan = $this->membership_model->get_user_plan_by_user_id($user->id); ?>
                                <tr>
                                    <td><?php echo html_escape($user->id); ?></td>
                                    <td>
                                        <a href="<?php echo admin_url(); ?>user-details/<?php echo html_escape($user->id); ?>" target="_blank" class="table-link">
                                            <img src="<?php echo get_user_avatar($user); ?>" alt="user" class="img-responsive" style="width: 50px;">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo admin_url(); ?>user-details/<?php echo html_escape($user->id); ?>" target="_blank" class="table-link"><?php echo html_escape($user->username); ?></a>
                                    </td>
                                    <td><?php echo html_escape($user->shop_name); ?></td>
                                    <td><?php echo html_escape($user->about_me); ?></td>
                                    <td><?php echo get_supplier_location($user); ?></td>
                                    <!-- <td><?= !empty($membership_plan) ? $membership_plan->plan_title : ''; ?></td>
                                    <td><?php if (!empty($membership_plan)) :
                                            echo get_payment_method($membership_plan->payment_method) . "<br>";
                                            if ($membership_plan->payment_status == "awaiting_payment") : ?>
                                                <label class="label label-danger"><?= trans("awaiting_payment"); ?></label>
                                            <?php elseif ($membership_plan->payment_status == "payment_received") : ?>
                                                <label class="label label-success"><?= trans("payment_received"); ?></label>
                                        <?php endif;
                                        endif; ?>
                                    </td> -->
                                    <td>
                                        <?php echo form_open('membership_controller/approve_shop_opening_request'); ?>
                                        <input type="hidden" name="id" value="<?php echo $user->id; ?>">
                                        <div class="modal fade" id="exampleModal_<?php echo $user->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        <h5 class="modal-title" id="exampleModalLabel">Update Commission Rate</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="number" step="0.01" min="0" max="100" class="form-control form-input" name="commission_rate" value="" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        <button type="submit" name="submit" value="1" class="btn btn-primary">
                                                            <i class="fa fa-check option-icon"></i><?php echo trans('approve'); ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" name="submit" value="update" class="btn bg-purple">
                                            <a href="<?php echo admin_url(); ?>edit_bank_details/<?php echo $user->id; ?>" class="view">View Details</a>
                                        </button>
                                        <!-- <ul class="dropdown-menu options-dropdown">
                                                <li>
                                                    <a href="<?php echo admin_url(); ?>edit_bank_details/<?php echo $user->id; ?>"><i class=" fa fa-edit option-icon"></i><?php echo trans('edit_user'); ?></a>
                                                </li>
                                                <li>
                                                    <button type="submit" name="submit" value="1" class="btn-list-button">
                                                        <i class="fa fa-check option-icon"></i><?php echo trans('approve'); ?>
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" class="btn-list-button" data-toggle="modal" data-target="#exampleModal_<?php echo $user->id; ?>">
                                                        <i class="fa fa-check option-icon"></i><?php echo trans('approve'); ?>
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="submit" name="submit" value="0" class="btn-list-button">
                                                        <i class="fa fa-times option-icon"></i><?php echo trans('decline'); ?>
                                                    </button>
                                                </li>
                                            </ul> -->
                </div>
                <?php echo form_close(); ?>
                </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            </table>
            <?php if (empty($users)) : ?>
                <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
            <?php endif; ?>
            </div>
        </div>
        <div class="col-sm-12 text-right">
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
</div>
</div>

<?php if (!empty($this->session->userdata('mds_send_email_data'))) : ?>
    <script>
        $(document).ready(function() {
            var data = JSON.parse(<?php echo json_encode($this->session->userdata("mds_send_email_data")); ?>);
            if (data) {
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                $.ajax({
                    type: "POST",
                    url: base_url + "ajax_controller/send_email",
                    data: data,
                    success: function(response) {}
                });
            }
        });
    </script>
<?php endif;
$this->session->unset_userdata('mds_send_email_data'); ?>