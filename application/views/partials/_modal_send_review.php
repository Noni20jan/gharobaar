<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Send Message Modal -->
<?php if ($this->auth_check) : ?>
    <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-send-message" role="document">
            <div class="modal-content">
                <!-- form start -->
                <form id="form1" novalidate="novalidate">
                    <input type="hidden" name="supplier_id" id="message_supplier_id" value="<?php echo $user->id; ?>">
                    <div class="modal-header">
                        <h5 class="title"><?php echo trans("review"); ?></h5>
                        <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div id="send-review-result"></div>
                                <div class="form-group m-b-sm-0">
                                    <!-- <label class="control-label"><?php echo trans("review"); ?></label> -->
                                    <textarea name="review" id="review_text" class="form-control form-textarea" placeholder="write a review" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-red" data-dismiss="modal"><i class="icon-times"></i>&nbsp;<?php echo trans("close"); ?></button>
                        <button type="button" id="send_review" class="btn btn-md btn-custom"><i class="icon-send"></i>&nbsp;<?php echo trans("send"); ?></button>
                    </div>
                </form>
                <!-- form end -->
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    $("#send_review").click(function() {
        var user_id = "<?php echo $user->id; ?>";
        add_review(parseInt(user_id));
    })

    $("#review_text").click(function() {
        document.getElementById("send-review-result").innerHTML = "";
    })
</script>