<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    #wrapper {
        background: #ffffff00;
    }
</style>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="row-custom">
                                <div class="profile-tab-content">
                                    <!-- include message block -->
                                    <?php //$this->load->view('partials/_messages'); 
                                    ?>
                                    <?php echo form_open("social-media-post", ['id' => 'form_validate']); ?>
                                    <div class="form-group">
                                        <label class="control-label"><?php echo trans('facebook_url'); ?></label>
                                        <input type="text" class="form-control form-input" name="facebook_url" placeholder="<?php echo trans('facebook_url'); ?>" value="<?php echo html_escape($user->facebook_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"><?php echo trans('twitter_url'); ?></label>
                                        <input type="text" class="form-control form-input" name="twitter_url" placeholder="<?php echo trans('twitter_url'); ?>" value="<?php echo html_escape($user->twitter_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"><?php echo trans('instagram_url'); ?></label>
                                        <input type="text" class="form-control form-input" name="instagram_url" placeholder="<?php echo trans('instagram_url'); ?>" value="<?php echo html_escape($user->instagram_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"><?php echo trans('pinterest_url'); ?></label>
                                        <input type="text" class="form-control form-input" name="pinterest_url" placeholder="<?php echo trans('pinterest_url'); ?>" value="<?php echo html_escape($user->pinterest_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label"><?php echo trans('linkedin_url'); ?></label>
                                        <input type="text" class="form-control form-input" name="linkedin_url" placeholder="<?php echo trans('linkedin_url'); ?>" value="<?php echo html_escape($user->linkedin_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                                    </div>

                                    <!-- <div class="form-group">
                            <label class="control-label"><?php echo trans('vk_url'); ?></label>
                            <input type="text" class="form-control form-input" name="vk_url"
                                   placeholder="<?php echo trans('vk_url'); ?>" value="<?php echo html_escape($user->vk_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div> -->

                                    <div class="form-group">
                                        <label class="control-label"><?php echo trans('youtube_url'); ?></label>
                                        <input type="text" class="form-control form-input" name="youtube_url" placeholder="<?php echo trans('youtube_url'); ?>" value="<?php echo html_escape($user->youtube_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                                    </div>
                                    <button type="submit" class="btn btn-md btn-custom" style="float:right;"><?php echo trans("save_changes") ?></button>
                                    <?php echo form_close(); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Wrapper End-->
    </div>
</div>
</div>