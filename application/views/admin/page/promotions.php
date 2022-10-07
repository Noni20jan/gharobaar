<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php echo form_open('admin_controller/send_promotion_notification', array('id' => 'promo')); ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h2><strong><?php echo "Promotions" ?></strong></h2>
            </div>

            <div class="box-body">

                <!-- include message block -->
                <?php //$this->load->view('admin/includes/_messages'); 
                ?>

                <div class="form-group">

                    <label style="font-size: 15px"><?php echo trans('emailto'); ?></label><br>

                    <input type="radio" class="selectBox" name="emailall" id="source_all" onclick="promotion_all();" required value="all" />
                    <label for="all" style="font-size: 20px">All</label><br>
                    <input type="radio" class="selectBox" name="emailall" id="source_seller" onclick="promotion_seller();" required value="seller" />
                    <label for="seller" style="font-size: 20px">Seller</label><br>
                    <input type="radio" class="selectBox" id="source_state" name="emailall" onclick="promotion_state();" required value="individual" />
                    <label for="individual" style="font-size: 20px">Select State</label><br>
                </div>
                <div class="form-group" id="indvidual_selection">
                    <select name="state[]" id="user_selection" class="selectpicker" data-live-search=" true" multiple>
                        <?php $data['state'] = $this->auth_model->get_state_name(); ?>
                        <?php foreach ($data['state'] as $state) { ?>
                            <option value="<?php echo $state->state_name; ?>"><?php echo $state->state_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <br>
                <br>
                <div class="form-group">
                    <label style="font-size: 20px"><?php echo trans('title_promo'); ?></label>
                
                <br>
                <input type="text" name="subject" style="font-size: 20px" class="form-control" placeholder="<?php echo trans('title_promo'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>
                <br>
                <div class="form-group">
                    <label style="font-size: 20px"><?php echo trans('description_promo'); ?></label>
                
                <br>
                <textarea class="form-control form-textarea" style="font-size: 20px" rows="10" id="textarea" name="message" style="border-radius: 10px;" placeholder="Description of your product..."></textarea>
                </div>
            </div>
            <button id="btnsubmit" type="submit" class="btn btn-primary pull-right"><?php echo trans('send_notification'); ?></button>
        </div>
        <?php echo form_close(); ?>
        <script>
            $(document).ready(
                function() {
                    $('#indvidual_selection').hide();

                })
        </script>
        <script>
            function promotion_all() {
                var chks = document.getElementById('source_all').value;
                $('#indvidual_selection').hide();

            }
        </script>

        <script>
            function promotion_seller() {
                var chks = document.getElementById('source_seller').value;
                $('#indvidual_selection').hide();
            }
        </script>
        <script>
            function promotion_state() {
                var chks = document.getElementById('source_state').value;
                $('#indvidual_selection').show();
            }
        </script>
        <script>
            $(document).ready(function() {
                $("#promo").submit(function(e) {
                    document.getElementById("btnsubmit").innerHTML = 'Sending...';
                    //e.preventDefault();
                    $("#btnsubmit").attr("disabled", true);
                    return true;
                });
            });
        </script>