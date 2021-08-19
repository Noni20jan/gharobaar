<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (!empty($user)) :

    $video = $this->file_model->get_user_story_video($user->id);
    // var_dump(get_user_video_url($video));
    if (!empty($video)) : ?>
        <div class="dm-uploader-container">
            <div id="drag-and-drop-zone-video" class="dm-uploader dm-uploader-media text-center">
                <ul class="dm-uploaded-files dm-uploaded-media-file">
                    <li class="media li-dm-media-preview">
                        <video id="player" width="350px" style="height: 250px;" playsinline controls>
                            <source src="<?php echo get_user_video_url($video); ?>" type="video/mp4">
                        </video>
                        <!-- <a href="javascript:void(0)" class="btn-img-delete btn-video-delete" onclick="delete_user_video_preview('<?php echo $user->id; ?>','<?php echo trans("confirm_product_video") ?>');">
                            <i class="icon-close"></i>
                        </a> -->
                    </li>
                </ul>
            </div>
        </div>
    <?php else : ?>
        <div class="dm-uploader-container">
            <div id="drag-and-drop-zone-video" class="dm-uploader dm-uploader-media text-center">
                <p class="dm-upload-icon">
                    <i class="icon-user"></i>
                </p>
                <p class="dm-upload-text"><?php echo trans("story_not_uploaded"); ?>&nbsp;</p>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>