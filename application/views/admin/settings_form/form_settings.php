<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-4 col-md-12">
        <?php echo form_open('settings_controller/form_settings_post'); ?>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('form_settings'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("msg_form_settings"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('price') . ' (' . trans("only_for_ordinary_listing") . ') '; ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="price" id="price" value="1" class="square-purple" <?php echo ($this->form_settings->price == 1) ? 'checked' : ''; ?>>
                            <label for="price" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="price_required" id="price_required" value="1" class="square-purple" <?php echo ($this->form_settings->price_required == 1) ? 'checked' : ''; ?>>
                            <label for="price_required" class="option-label"><?php echo trans('required'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('variations'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="variations" id="variations" value="1" class="square-purple" <?php echo ($this->form_settings->variations == 1) ? 'checked' : ''; ?>>
                            <label for="variations" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('shipping'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="shipping" id="shipping" value="1" class="square-purple" <?php echo ($this->form_settings->shipping == 1) ? 'checked' : ''; ?>>
                            <label for="shipping" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="shipping_required" id="shipping_required" value="1" class="square-purple" <?php echo ($this->form_settings->shipping_required == 1) ? 'checked' : ''; ?>>
                            <label for="shipping_required" class="option-label"><?php echo trans('required'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('location'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="product_location" id="product_location" value="1" class="square-purple" <?php echo ($this->form_settings->product_location == 1) ? 'checked' : ''; ?>>
                            <label for="product_location" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('external_link') . ' (' . trans("only_for_ordinary_listing") . ') '; ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="external_link" id="external_link" value="1" class="square-purple" <?php echo ($this->form_settings->external_link == 1) ? 'checked' : ''; ?>>
                            <label for="external_link" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="verification" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
        </div>
        <?php echo form_close(); ?><!-- form end -->
    </div>
    <div class="col-lg-4 col-md-12">
        <?php echo form_open('settings_controller/physical_products_form_post'); ?>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('physical_products'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("msg_physical"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('demo_url'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="physical_demo_url" id="physical_demo_url" value="1" class="square-purple" <?php echo ($this->form_settings->physical_demo_url == 1) ? 'checked' : ''; ?>>
                            <label for="physical_demo_url" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('video_preview'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="physical_video_preview" id="physical_video_preview" value="1" class="square-purple" <?php echo ($this->form_settings->physical_video_preview == 1) ? 'checked' : ''; ?>>
                            <label for="physical_video_preview" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('audio_preview'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="physical_audio_preview" id="physical_audio_preview" value="1" class="square-purple" <?php echo ($this->form_settings->physical_audio_preview == 1) ? 'checked' : ''; ?>>
                            <label for="physical_audio_preview" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="verification" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
        </div>
        <?php echo form_close(); ?><!-- form end -->

        <?php echo form_open('settings_controller/file_upload_form_post'); ?>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('file_upload'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("msg_file_upload"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('max_file_size') . ' (' . trans("image") . ' )'; ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="number" name="max_file_size_image" value="<?php echo round(($this->general_settings->max_file_size_image / 1048576), 2); ?>" min="1" class="form-control" aria-describedby="basic-addon1" required>
                                <span class="input-group-addon" id="basic-addon1">MB</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('max_file_size') . ' (' . trans("video") . ' )'; ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="number" name="max_file_size_video" value="<?php echo round(($this->general_settings->max_file_size_video / 1048576), 2); ?>" min="1" class="form-control" aria-describedby="basic-addon2" required>
                                <span class="input-group-addon" id="basic-addon2">MB</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('max_file_size') . ' (' . trans("audio") . ' )'; ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="number" name="max_file_size_audio" value="<?php echo round(($this->general_settings->max_file_size_audio / 1048576), 2); ?>" min="1" class="form-control" aria-describedby="basic-addon3" required>
                                <span class="input-group-addon" id="basic-addon3">MB</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="verification" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
        </div>
        <?php echo form_close(); ?><!-- form end -->
    </div>
    <div class="col-lg-4 col-md-12">
        <?php echo form_open('settings_controller/digital_products_form_post'); ?>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('digital_products'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("msg_digital"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('demo_url'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="digital_demo_url" id="digital_demo_url" value="1" class="square-purple" <?php echo ($this->form_settings->digital_demo_url == 1) ? 'checked' : ''; ?>>
                            <label for="digital_demo_url" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('video_preview'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="digital_video_preview" id="digital_video_preview" value="1" class="square-purple" <?php echo ($this->form_settings->digital_video_preview == 1) ? 'checked' : ''; ?>>
                            <label for="digital_video_preview" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('audio_preview'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="checkbox" name="digital_audio_preview" id="digital_audio_preview" value="1" class="square-purple" <?php echo ($this->form_settings->digital_audio_preview == 1) ? 'checked' : ''; ?>>
                            <label for="digital_audio_preview" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('allowed_file_extensions'); ?></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input id="input_digital_allowed_file_extensions" type="text" name="digital_allowed_file_extensions" value="<?php echo str_replace('"', '', $this->form_settings->digital_allowed_file_extensions); ?>" class="form-control tags"/>
                            <small>(<?php echo trans('type_extension'); ?>&nbsp;E.g. zip, jpg, doc, pdf..)</small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="verification" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
        </div>
        <?php echo form_close(); ?><!-- form end -->
    </div>
</div>

<style>
    .col-sm-12 label {
        margin-left: 10px;
        font-weight: 400 !important;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    #input_digital_allowed_file_extensions_tag {
        width: auto !important;
    }
</style>

<script>
    $(function () {
        $('#input_digital_allowed_file_extensions').tagsInput({width: 'auto', 'defaultText': ''});
    });
</script>
