<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('send_email_members'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/send_email_members_post'); ?>

            <div class="box-body">

                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>
                <div class="form-group">

                    <label><?php echo trans('emailto'); ?></label><br>

                    <input type="radio" class="selectBox" name="emailall" id="emailall" onclick="emailtoall();" required value="all" />
                    <label for="all">All</label><br>
                    <input type="radio" class="selectBox" id="select_email" name="emailall" onclick="indviduals();" required value="individual" />
                    <label for="individual">Select Email ID</label><br>

                  
                </div>
                <div class="form-group" id="indvidual_selection">
                    <select name="emailto[]" id="user_selection" class="selectpicker" data-live-search=" true" multiple>
                        <?php $data['email'] = $this->newsletter_model->get_members2(); ?>
                        <?php foreach ($data['email'] as $email) { ?>
                            <option value="<?php echo $email->email; ?>"><?php echo $email->email; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?php echo trans('subject'); ?></label>
                    <input type="text" name="subject" class="form-control" placeholder="<?php echo trans('subject'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>
                <div class="form-group">
                    <label><?php echo trans('content'); ?></label>
                    <div class="row">
                        <div class="col-sm-12 m-b-5">
                            <button type="button" class="btn btn-success btn-file-manager" data-image-type="editor" data-toggle="modal" data-target="#imageFileManagerModal"><i class="fa fa-image"></i>&nbsp;&nbsp;<?php echo trans("add_image"); ?></button>
                        </div>
                    </div>
                    <textarea class="form-control tinyMCE" id="textarea" name="message"></textarea>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('send_email'); ?></button>
            </div>
            <!-- /.box-footer -->

            <?php echo form_close(); ?>
            <!-- form end -->

        </div>
        <!-- /.box -->
    </div>
</div>
<script>
    $(document).ready(
        function() {
            $('#indvidual_selection').hide();
            $('#user_selection').selectpicker({
                multipleSeparator: ','
            });
            tinymce.init({
                selector: 'textarea',
                menubar: false,
                height: '300px',
                themes: 'modern',
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools responsivefilemanager'
                ],
                toolbar: ['undo redo | styleselect | bold italic | forecolor backcolor | imageupload responsivefilemanager',
                    'alignleft aligncenter alignright | bullist numlist | outdent indent | table | preview'
                ],

                external_filemanager_path: '/responsivefilemanager/filemanager/',
                filemanager_title: 'Responsive Filemanager',
                external_plugins: {
                    'filemanager': '/responsivefilemanager/filemanager/plugin.min.js'
                }
            });

        });
</script>
<script>
    function emailtoall() {
        var email = document.getElementById('emailall').value;
        $('#indvidual_selection').hide();
        document.getElementById('user_selection').value = "";
        // }
        $('#user_selection').prop('required', false);
    }
</script>
<script>
    function indviduals() {
        var email = document.getElementById('select_email').value;
        $('#indvidual_selection').show();
        document.getElementById('emailall').val = "";
        $('#user_selection').prop('required', true);
        // }
    }
</script>
<?php $this->load->view('admin/includes/_image_file_manager'); ?>