<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="<?= base_url(); ?>assets/admin/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/file-uploader/js/jquery.dm-uploader.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/file-uploader/js/ui.js"></script>
<div id="video_upload_result">
    <?php $this->load->view('dashboard/product/_story_video_res'); ?>
</div>

<!-- File item template -->
<script type="text/html" id="files-template-video">
    <li class="media">
        <div class="media-body">
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </li>
</script>

<script>
    $('#drag-and-drop-zone-video').dmUploader({
        url: '<?php echo base_url(); ?>upload-video-post-story',
        maxFileSize: <?php echo $this->general_settings->max_file_size_video; ?>,
        queue: true,
        extFilter: ["mp4", "webm"],
        multiple: false,
		extraData: function (id) {
			return {
				"user_id": <?php echo $user->id; ?>,
				"<?php echo $this->security->get_csrf_token_name(); ?>": $.cookie(csfr_cookie_name)
			};
		},
        onDragEnter: function () {
            this.addClass('active');
        },
        onDragLeave: function () {
            this.removeClass('active');
        },
        onInit: function () {
        },
        onComplete: function (id) {
        },
        onNewFile: function (id, file) {
            ui_multi_add_file(id, file, "video");
        },
        onBeforeUpload: function (id) {
            ui_multi_update_file_progress(id, 0, '', true);
            ui_multi_update_file_status(id, 'uploading', 'Uploading...');
        },
        onUploadProgress: function (id, percent) {
            ui_multi_update_file_progress(id, percent);
        },
        onUploadSuccess: function (id, user_id) {
            load_video_preview(user_id);
        },
        onUploadError: function (id, xhr, status, message) {
        },
        onFallbackMode: function () {
        },
        onFileSizeError: function (file) {
            $("#drag-and-drop-zone-video .error-message-file-upload").show();
            $("#drag-and-drop-zone-video .error-message-file-upload p").html("<?php echo trans('file_too_large') . ' ' . formatSizeUnits($this->general_settings->max_file_size_video); ?>");
            setTimeout(function () {
                $("#drag-and-drop-zone-video .error-message-file-upload").fadeOut("slow");
            }, 4000)
        },
        onFileTypeError: function (file) {
        },
        onFileExtError: function (file) {
        },
    });
    $(document).ajaxStop(function () {
        $('#drag-and-drop-zone-video').dmUploader({
            url: '<?php echo base_url(); ?>upload-video-post-story',
            maxFileSize: <?php echo $this->general_settings->max_file_size_video; ?>,
            queue: true,
            extFilter: ["mp4", "webm"],
            multiple: false,
			extraData: function (id) {
				return {
					"user_id": <?php echo $user->id; ?>,
					"<?php echo $this->security->get_csrf_token_name(); ?>": $.cookie(csfr_cookie_name)
				};
			},
            onDragEnter: function () {
                this.addClass('active');
            },
            onDragLeave: function () {
                this.removeClass('active');
            },
            onInit: function () {
            },
            onComplete: function (id) {
            },
            onNewFile: function (id, file) {
                ui_multi_add_file(id, file, "video");
            },
            onBeforeUpload: function (id) {
                ui_multi_update_file_progress(id, 0, '', true);
                ui_multi_update_file_status(id, 'uploading', 'Uploading...');
            },
            onUploadProgress: function (id, percent) {
                ui_multi_update_file_progress(id, percent);
            },
            onUploadSuccess: function (id, user_id) {
                load_video_preview(user_id);
            },
            onUploadError: function (id, xhr, status, message) {
            },
            onFallbackMode: function () {
            },
            onFileSizeError: function (file) {
                $("#drag-and-drop-zone-video .error-message-file-upload").show();
                $("#drag-and-drop-zone-video .error-message-file-upload p").html("<?php echo trans('file_too_large') . ' ' . formatSizeUnits($this->general_settings->max_file_size_video); ?>");
                setTimeout(function () {
                    $("#drag-and-drop-zone-video .error-message-file-upload").fadeOut("slow");
                }, 4000)
            },
            onFileTypeError: function (file) {
            },
            onFileExtError: function (file) {
            },
        });
    });

    function load_video_preview(user_id) {
        var data = {
            "user_id": user_id,
            "sys_lang_id": sys_lang_id
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "load-video-preview-post-story",
            data: data,
            success: function (response) {
                setTimeout(function () {
                    document.getElementById("video_upload_result").innerHTML = response;
                    const player = new Plyr('#player');
                }, 15000);
            }
        });
    }
</script>


