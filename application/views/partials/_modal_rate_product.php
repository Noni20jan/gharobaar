<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<style>
    .product-imgs-modal {
        height: 118px;
    }

    .form-textarea {
        min-height: 60px;
        border-radius: 15px;
        padding: 10px 12px;
        resize: vertical;
    }

    @media(max-width:768px) {
        .product-imgs-modal {
            height: 84px;
        }

        .scroll-for-mobile {
            overflow-y: scroll !important;
            height: 70vh;
        }

    }


    .upload_image_span {
        margin-left: 8px;
        font-size: 10px;
        color: grey;
    }
</style>
<div class="modal fade" id="rateProductModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-custom">
            <form enctype="multipart/form-data" id="form" class="form" method="POST" role="form" name="form">
                <!-- <?php echo form_open_multipart('add-review-post'); ?> -->
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo trans("rate_this_product"); ?></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"><i class="icon-close"></i> </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row-custom">
                                <div class="rate-product">
                                    <span><?php echo trans("your_rating"); ?></span>
                                    <div class="rating-stars">
                                        <label class="label-star" data-star="5" for="star5"><i class="icon-star-o"></i></label>
                                        <label class="label-star" data-star="4" for="star4"><i class="icon-star-o"></i></label>
                                        <label class="label-star" data-star="3" for="star3"><i class="icon-star-o"></i></label>
                                        <label class="label-star" data-star="2" for="star2"><i class="icon-star-o"></i></label>
                                        <label class="label-star" data-star="1" for="star1"><i class="icon-star-o"></i></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea name="review" id="user_review" class="form-control form-input form-textarea" placeholder="<?php echo trans("write_review"); ?>"></textarea>
                                <input type="hidden" name="rating" id="user_rating">
                                <input type="hidden" name="product_id" id="review_product_id">
                            </div>
                            <div class="upload_image">
                                <input type="file" id="fileuploadbasic" name="file_[]" size="40" multiple="multiple" accept=".jpg, .jpeg,.png">
                            </div>
                            <span class="upload_image_span">*Maximun 4 images allowed</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-md btn-red" data-dismiss="modal"><?php echo trans("close"); ?></button>
                    <button type="submit" class="btn btn-md btn-custom submit" id="submit"><?php echo trans("submit"); ?></button>
                </div>
                <!-- <?php echo form_close(); ?> -->
            </form>
        </div>
    </div>
</div>
<div class="modal" id="feedback_msg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-custom">
            <button type="button" class="close" data-dismiss="modal">
            </button>

            <div class="modal-body" style="padding:0px;">

                <img src="<?php echo base_url(); ?>assets/img/Feedback.png" style="width: 100%;">
            </div>

        </div>
    </div>
</div>
< <script>
    $(function() {

    var
    max_file_number = 4,

    $form = $('form'),

    $file_upload = $('#fileuploadbasic', $form),

    $button = $('.submit', $form);

    // $button.prop('disabled', 'disabled');

    $file_upload.on('change', function() {
    var number_of_images = $(this)[0].files.length;
    if (number_of_images > max_file_number) {
    $(this).val('');
    $button.prop('disabled', 'disabled');
    } else {
    $button.prop('disabled', false);
    }
    });
    });
    </script>
    <script>
        $(document).ready(function() {
            $("#submit").click(function() {
                // alert("wqrw");
                event.preventDefault();
                var reset_data = document.getElementById("form");
                var form = this.form;

                var data = new FormData(form);

                data.append(csfr_token_name, $.cookie(csfr_cookie_name));

                $.ajax({
                    type: "POST",
                    url: base_url + 'home_controller/add_review_post',
                    data: data,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var i = JSON.parse(response);

                        if (i == true) {
                            console.log(i);
                            reset_data.reset();
                            $('#rateProductModal').modal('hide');
                            $('#feedback_msg').modal('show');

                            setTimeout(function() {
                                $('#feedback_msg').modal('hide');
                            }, 6000);
                        } else {
                            reset_data.reset();
                            $('#rateProductModal').modal('hide');
                        }
                    }
                });
            });
        });
    </script>