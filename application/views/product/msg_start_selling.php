<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/datepicker/css/bootstrap-datepicker.standalone.css">
<script src="<?php echo base_url(); ?>assets/vendor/datepicker/js/bootstrap-datepicker.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="<?php echo base_url(); ?>assets/js/jquery.tagger.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery.tagger.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div id="content" class="col-12">

                <?php if (!$this->session->flashdata('success')) : ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info" role="alert">
                                <?php echo trans("msg_shop_opening_requests"); ?>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert custom-alert" role="alert">
                                <?php echo $this->session->flashdata('success'); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>