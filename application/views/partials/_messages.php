<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!--print error messages-->
<style>
    .error_font {

        font-size: 15px !important;
        color: red;

    }
</style>
<?php if ($this->session->flashdata('errors')) : ?>
    <div class="form-group">
        <div class="error-message">
            <?php echo $this->session->flashdata('errors'); ?>
        </div>
    </div>
<?php endif; ?>

<!--print custom error message-->
<?php if ($this->session->flashdata('error')) : ?>
    <?php if ($this->session->flashdata('error') == "Address in mailbox given [] does not comply with RFC 2822, 3.6.2.") : ?>
        <div class="form-group">
            <div class="error-message">
                <p>
                    Please make your email settings from Email Settings Section!
                </p>
            </div>
        </div>
    <?php else : ?>
        <div class="form-group">
            <div class="error-message">
                <p class="error_font">
                    <?php echo $this->session->flashdata('error'); ?>
                </p>
            </div>
        </div>
    <?php endif; ?>
    <!--print custom success message-->
<?php elseif ($this->session->flashdata('success')) : ?>
    <div class="form-group">
        <div class="success-message">
            <p>
                <i class="icon-check"></i>
                <?php echo $this->session->flashdata('success'); ?>
            </p>
        </div>
    </div>
<?php endif; ?>