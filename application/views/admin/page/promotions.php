<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php echo form_open('admin_controller/send_promotion_notification', array('id' => 'promo')); ?>

<div class="box-body">

    <!-- include message block -->
    <?php //$this->load->view('admin/includes/_messages'); 
    ?>

    <div class="form-group">

        <label><?php echo trans('emailto'); ?></label><br>

        <input type="radio" class="selectBox" name="emailall" id="source_all" onclick="promotion_all();" required value="all" />
        <label for="all">All</label><br>
        <input type="radio" class="selectBox" name="emailall" id="source_seller" onclick="promotion_seller();" required value="seller" />
        <label for="seller">Seller</label><br>
        <input type="radio" class="selectBox" id="source_state" name="emailall" onclick="promotion_state();" required value="individual" />
        <label for="individual">Select State</label><br>
    </div>
    <div class="form-group" id="indvidual_selection">
        <select name="state[]" id="user_selection" class="selectpicker" data-live-search=" true" multiple>
            <?php $data['state'] = $this->auth_model->get_state_name(); ?>
            <?php foreach ($data['state'] as $state) { ?>
                <option value="<?php echo $state->state_name; ?>"><?php echo $state->state_name; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label><?php echo trans('title_promo'); ?></label>
        <input type="text" name="subject" class="form-control" placeholder="<?php echo trans('title_promo'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
    </div>
    <div class="form-group">
        <label><?php echo trans('description_promo'); ?></label>

    </div>
    <textarea class="form-control form-textarea" rows="10" id="textarea" name="message" style="border-radius: 10px;" placeholder="Description of your product..."></textarea>
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
            document.getElementById("btnsubmit").innerHTML='Sending...';
            //e.preventDefault();
            $("#btnsubmit").attr("disabled", true);            
            return true;
        });
    });
</script>