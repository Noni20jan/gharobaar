<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo trans("followers"); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="profile-page-top">
                    <!-- load profile details -->
                    <?php $this->load->view("profile/_profile_user_info"); ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-3">
                <!-- load profile nav -->
                <?php if ($user->role == 'vendor') {
                        $this->load->view("profile/_profile_user_info");
                    }
                    if ($user->role == 'member') {
                        $this->load->view("profile/_profile_user_info_user");
                    }
                    ?>
            </div>

            <div class="col-sm-12 col-md-9">
                <div class="profile-tab-content">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 m-b-30">
                            <?php $this->load->view("dashboard/product/_story_video_box"); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6">
                            <div id="product_slider_container">
                                <?php $this->load->view("settings/story_details/_preview"); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row-custom">
                        <!--Include banner-->
                        <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "profile", "class" => "m-t-30"]); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Wrapper End-->

<!-- include send message modal -->
<?php $this->load->view("partials/_modal_send_message", ["subject" => null]); ?>

<script src="<?php echo base_url(); ?>assets/vendor/plyr/plyr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/plyr/plyr.polyfilled.min.js"></script>
<script>
    const player = new Plyr('#player');
    $(document).ajaxStop(function() {
        const player = new Plyr('#player');
    });
</script>