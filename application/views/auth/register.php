<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="modal fade" id="termsCondition" role="dialog" style="display:none;">
        <div class="modal-dialog modal-dialog-centered login-modal" role="document">
            <div class="modal-content">
                <div class="register-box">
                    <button type="button" class="close" data-dismiss="modal" onclick="t_c()"><i class="icon-close"></i></button>
                    <h4 class="title">Terms & Conditions</h4>

                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="auth-container">
            <div class="register-box">
                <div class="row">
                    <div id="result-register">
                        <?php $this->load->view('partials/_messages'); ?>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
</div>
<!-- Wrapper End-->