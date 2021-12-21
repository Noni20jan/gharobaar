<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('send_sms_members'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('home_controller/send_sms_members_post');
            ?>

            <div class="box-body">

                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
                <div class="form-group">

                    <label><?php echo trans('emailto'); ?></label><br>

                    <input type="radio" class="selectBox" name="emailall" id="emailall" onclick="emailtoall();" required value="all" />
                    <label for="all">All</label><br>
                    <input type="radio" class="selectBox" id="select_email" name="emailall" onclick="indviduals();" required value="individual" />
                    <label for="individual">Select Phone Number</label><br>
                </div>
                <div class="form-group" id="indvidual_selection">
                    <select name="emailto[]" id="user_selection" class="selectpicker" data-live-search=" true" multiple>
                        <?php $data['email'] = $this->newsletter_model->get_members1(); ?>
                        <?php foreach ($data['email'] as $email) { ?>
                            <option value="<?php echo $email->phone_number; ?>"><?php echo $email->first_name . " " . $email->last_name . "(" . $email->phone_number . ")"; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group" id="event">
                    <label><?php echo trans('event'); ?></label>
                    <select name="event" id="event_selection" class="selectpicker" data-live-search=" true">
                        <?php $data['content'] = $this->page_model->get_event_content(); ?>
                        <?php foreach ($data['content'] as $content) { ?>
                            <option value="<?php echo $content->label; ?>"><?php echo $content->event; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?php echo trans('coupon_code'); ?></label>
                    <input type="text" name="coupon_code" id="coupon_code" class="form-control" placeholder="<?php echo trans('coupon_code'); ?>" required>
                </div>
                <div class="form-group">
                    <label><?php echo trans('discount'); ?></label>
                    <input type="text" name="discount" id="discount" class="form-control" placeholder="<?php echo trans('discount'); ?>" required>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('send_sms'); ?></button>
            </div>
            <!-- /.box-footer -->

            <?php echo form_close();
            ?>
            <!-- form end -->

        </div>
        <!-- /.box -->
    </div>
</div>
<script>
    $(document).ready(
        function() {
            $('#indvidual_selection').hide();
            $('#user_selection').selectpicker({
                multipleSeparator: ','
            });

        });
</script>
<script>
    function emailtoall() {
        var email = document.getElementById('emailall').value;
        $('#indvidual_selection').hide();
        document.getElementById('user_selection').value = "";
        // }
        $('#user_selection').prop('required', false);
    }
</script>
<script>
    function indviduals() {
        var email = document.getElementById('select_email').value;
        $('#indvidual_selection').show();
        document.getElementById('emailall').val = "";
        $('#user_selection').prop('required', true);
        // }
    }

    function send_verification_otp() {
        // var phn_num = document.getElementById('user_selection').value;
        var phn_num = ["9996918198"];
        console.log(phn_num);
        var coupon_code = document.getElementById('coupon_code').value;
        var discount = document.getElementById('discount').value;
        var data = {
            'sys_lang_id': sys_lang_id,
            'phn_num': phn_num,
            'label_content': 'coupon_code',
            'coupon_code': coupon_code,
            'discount': discount
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "home_controller/send_otp_verification/" + phn_num,
            data: data,
            success: function(response) {
                if (response != null) {
                    var i = JSON.parse(response);
                    // console.log(i.otp);
                    // console.log(i.message);
                    console.log(i.html_content1);
                }
            }

        });
    }
</script>
<?php // $this->load->view('admin/includes/_image_file_manager'); 
?>