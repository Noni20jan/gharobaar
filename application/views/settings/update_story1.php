<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        

        <div class="row">

           
            <div class="col-sm-12 col-md-9">

                <div class="row-custom">
                    <div class="profile-tab-content">
                        <!-- include message block -->
                        <?php $this->load->view('partials/_messages'); ?>
                        <?php echo form_open_multipart("update-story-post", ['id' => 'form_validate']); ?>
                        <div class="row">
                            <div class="col-sm-12" >
                                <h3><label class="control-label">Hi , <?php echo $this->auth_user->first_name?></label></h3>
                                
                            </div>
                        </div>
                        <br>
                       
                        <b> <h5><label class="control-label">Your Story
                        </label></h5></b>
                        <br>
                        <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12" >
                                <label class="control-label"><?php echo trans("story_video"); ?> (Maximum upload file size : 30 Mb)</label>
                                <?php $this->load->view("dashboard/product/_story_video_box"); ?>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 m-b-30">
                                <label class="control-label"><?php echo trans("story_images"); ?> (Maximum upload file size : 30 Mb)</label>
                                <?php $this->load->view("settings/_story_image_update_box"); ?>
                            </div>
                        </div>
                        </div>
                        <br>
                       <b> <h5><label class="control-label">Your Bank Details</label></h5></b>
                        <div class="form-group">
                            <label class="control-label">Account Holder Name*</label>
                            <input type="text" name="holder_name" class="form-control form-input"  placeholder="Enter Account Holder Name"  required>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label">Account Number*</label>
                            <input type="text" name="account_number" pattern="^\d{9,18}$" class="form-control form-input"  placeholder="Enter Account Number"  required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">IFSC Code*</label>
                            <input type="text" name="ifsc_code" class="form-control form-input" pattern= "^[A-Z]{4}0[A-Z0-9]{6}$" placeholder="Enter IFSC Code"  required>
                        </div>
                        <b> <h5><label class="control-label">Brand Information</label></h5></b>
                        
                        <br><div class="form-group">
                            <p>
                                <img src="<?php echo get_user_logo($user); ?>" height="80" width="80" alt="<?php echo $user->username; ?>" class="rounded-circle" id="test1">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                                <a class='btn btn-md btn-secondary btn-file-upload'>
                                    Select Your Brand Logo
                                    <input type="file" name="file1" size="40" accept=".png, .jpg, .jpeg, .gif" onchange=imageShow(this)>
                                </a>
                                <span class='badge badge-info' id="upload-file-info1"></span>
                            </p>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Brand Name*</label>
                            <input type="text" name="brand_name" class="form-control form-input"  placeholder="Enter Brand Name" onKeyPress="if(this.value.length==10) return false;" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Brand Description*</label>
                            <input type="text" name="brand_desc" class="form-control form-input"  placeholder="Describe your brand" onKeyPress="if(this.value.length==10) return false;" required>
                        </div>
                        <b> <h5><label class="control-label">Your Customer Testimonial</label></h5></b>
                        <div class="form-group">
                            <label class="control-label">Customer Name*</label>
                            <input type="text" name="customer_name" class="form-control form-input"  placeholder="Enter Customer Name" onKeyPress="if(this.value.length==10) return false;" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Testimonial*</label>
                            <input type="text" name="testimonial" class="form-control form-input"  placeholder="Testimonial" onKeyPress="if(this.value.length==10) return false;" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Source*</label>
                            <input type="text" name="source" class="form-control form-input"  placeholder="Source" onKeyPress="if(this.value.length==10) return false;" required>
                        </div>
                        <br>
                        <button type="submit" name="submit" value="update" class="btn btn-lg btn-success pull-right"><?php echo trans("save_changes") ?></button>
                        <?php echo form_close(); ?>

                        

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->
<script>
  function imageShow(input) {
        $('#upload-file-info1').html($(input).val().replace(/.*[\/\\]/, ''));
        readURL(input);
    };

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#test1').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
</script>