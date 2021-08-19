<style>
    .image1 {
        width: 72%;
        margin-left: 20%;
        margin-top: -15%;
    }


    .page-title {

        text-align: center;
        font-weight: bolder;
        font-size: xx-large;

    }

    #contact-name {
        margin-bottom: 5%;
        margin-top: 8%;
    }

    #contact-email {
        margin-bottom: 5%;
    }

    #contact-number {
        margin-bottom: 5%;
    }

    #contact-query {
        margin-bottom: 5%;
    }
</style>




<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">

            <div class="col-12 contact-space">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo trans("contact"); ?></li>
                    </ol>
                </nav>
                <h1 class="page-title"><?php echo trans("contact_us"); ?></h1>
            </div>
            <div class="contact-box">
                <div class="col-12">
                    <h2>Details</h2>
                    <div class="page-contact">

                        <div class="row contact-text">
                            <div class="col-12">
                                <?php echo $this->settings->contact_text; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <h2 class="contact-leave-message"><?php echo trans("leave_message"); ?></h2>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-12 order-1 order-lg-0">
                                <!-- include message block -->
                                <?php $this->load->view('partials/_messages'); ?>

                                <!-- form start -->
                                <?php echo form_open('contact-post'); ?>
                                <div class="form-group">
                                    <input id="contact-name" type="text" class="form-control form-input" name="name" placeholder="<?php echo trans("name"); ?>" maxlength="199" minlength="1" pattern=".*\S+.*" value="<?php echo old('name'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                </div>
                                <div class="form-group">
                                    <input id="contact-email" type="email" class="form-control form-input" name="email" maxlength="199" pattern="^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+.[a-zA-Z.]$" placeholder="<?php echo trans("email_address"); ?>" value="<?php echo old('email'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                </div>
                                <div class="form-group">
                                    <input id="contact-number" type="tel" name="phone_number" onKeyPress="if(this.value.length==12) return false; return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" class="form-control auth-form-input" placeholder="Mobile Number" value="" minlength="10" maxlength="10" required="">
                                </div>
                                <div class="form-group">
                                    <textarea id="contact-query" class="form-control form-input form-textarea" name="message" placeholder="<?php echo trans("message"); ?>" maxlength="4970" minlength="5" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required><?php echo old('message'); ?></textarea>
                                </div>
                                <div class="form-group" style="text-align:center;">
                                    <button type="submit" class="btn btn-md btn-custom" style="width:60%;">
                                        <?php echo trans("submit"); ?>
                                    </button>
                                </div>

                                <?php echo form_close(); ?>
                            </div>

                            <div class="col-md-6 col-12 order-0 order-lg-1 contact-right">

                                <!-- <img id="ABOUT_LOGO" src="assets/img/contact.png" class="img-responsive image1"> -->

                                <?php if ($this->settings->contact_phone) : ?>
                                    <div class="col-12 contact-item">
                                        <i class="icon-phone" aria-hidden="true"></i>
                                        <?php echo html_escape($this->settings->contact_phone); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($this->settings->contact_email) : ?>
                                    <div class="col-12 contact-item">
                                        <i class="icon-envelope" aria-hidden="true"></i>
                                        <?php echo html_escape($this->settings->contact_email); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($this->settings->contact_address) : ?>
                                    <div class="col-12 contact-item">
                                        <i class="icon-map-marker" aria-hidden="true"></i>
                                        <?php echo html_escape($this->settings->contact_address); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <?php if (!empty($this->settings->contact_address)) : ?>
        <div class="container">
            <div class="row">
                <div class="contact-map-container">
                    <iframe id="contact_iframe" src="https://maps.google.com/maps?width=100%&height=600&hl=en&q=<?php echo $this->settings->contact_address; ?>&ie=UTF8&t=&z=8&iwloc=B&output=embed&disableDefaultUI=true" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                </div>
            </div>
        </div>
    <?php endif; ?> -->
</div>
<!-- Wrapper End-->
<!-- <script>
    var iframe = document.getElementById("contact_iframe");
    iframe.src = iframe.src;
</script> -->
<style>
    #footer {
        margin-top: 0;
    }
</style>