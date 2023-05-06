<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div id="wrapper">
    <div class="container">
        <div class="row">
            <div id="content" class="col-12">
                <div class="form-add-product">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-12 col-lg-10">
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
        </div>
    </div>
</div>