<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $assistance_array = explode(",", $this->auth_user->assistance); ?>

<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
  <script src="<?php echo base_url(); ?>assets/admin/js/main-1.7.js"></script>
  <style>
    /* .huh #div1{
      width: 475px;
      height: 150px;
      border: 1px solid black;
      border-radius: 10px;

    
    } */
    * {
      box-sizing: border-box;
    }

    .input,
    textarea {
      width: 100%;
      border: 1px solid black;
      border-radius: 10px;
      background: transparent;
    }

    .story {
      position: relative;
      width: 150px;
      height: 150px;
      text-align: center;
      background: white;
      border: 2px dashed #eeeff1;
      border-radius: 150px;
      padding: 15px;
      margin: 5% 0;
    }

    .profileImage {
      position: relative;
      width: 140px;
      height: 140px;
      text-align: center;
      background: white;
      border: 2px dashed #eeeff1;
      border-radius: 80px;
      padding: 1px;
      cursor: pointer;
      margin: 20px;
    }

    .profileImage-default {
      position: relative;
      width: 155px;
      height: 140px;
      text-align: center;
      background: white;
      border: 2px dashed #eeeff1;
      padding: 1px;
      cursor: pointer;
      margin: 20px;
    }

    .upload-documents {
      position: relative;
      width: 200px;
      height: 180px;
      text-align: center;
      background: white;
      border: 2px dashed #eeeff1;
      padding: 1px;
      cursor: pointer;
      margin: 20px;
    }

    #img1 {
      position: relative;
      float: left;
      width: 80px;
      height: 80px;
      text-align: center;
      background: white;
      border: 2px dashed #eeeff1;
      border-radius: 80px;
      padding: 5px;
    }

    #img2 {
      position: relative;
      float: left;
      width: 80px;
      height: 80px;
      text-align: center;
      background: white;
      border: 2px dashed #eeeff1;
      border-radius: 80px;
      padding: 5px;
    }

    #img3 {
      position: relative;
      float: left;
      width: 80px;
      height: 80px;
      text-align: center;
      background: white;
      border: 2px dashed #eeeff1;
      border-radius: 80px;
      padding: 5px;
    }

    #logo {
      position: relative;
      width: 50px;
      height: 50px;
      text-align: center;
      background: #f8f9fb;
      border: 2px dashed #eeeff1;
      border-radius: 50px;
      padding: 5px;
      margin-left: 24px;
    }

    h {
      margin-bottom: 0.5rem;
      font-weight: 500;
      line-height: 1.2;
      font-size: 1.75rem;
    }

    #formlabel {
      display: block;
      text-align: center;
      line-height: 200%;
      font-size: 1em;
      padding-right: 150px;
    }

    .control-label1 {
      margin-right: 2%;
    }

    #formlabel1 {

      padding-left: 240px;

    }

    #formlabel2 {
      font-size: 1em;
      text-align: left;
      padding-left: 30px;
      padding-top: 10px;
    }

    #formlabel3 {
      padding-left: 25%;

    }

    #label1 {
      text-align: left;
      font-size: 1em;
      padding-left: 30px;
      padding-top: 20px;
      font-size: medium;
    }

    #xx {
      width: 250px;
      height: 20px;
      border: 1px solid black;
      border-radius: 5px;
      background: transparent;
    }

    #xy {

      height: 25px;
      border: 1px solid black;
      border-radius: 7px;
      float: left;

    }

    .groove {
      border-radius: 20px;
      /* border: 1px solid black; */
      text-align: justify;
      background: #fdfdfd9c;
    }

    .Brand-name {
      padding-right: 40px;
    }

    .Brand-1 {
      margin-bottom: 1%;
    }

    .tooltip-product {
      display: block;
    }

    .tooltip-product .tooltiptext {
      font-size: 13px !important;
      font-weight: 600 !important;
      font-family: 'Poppins', sans-serif !important;
      top: 25px !important;
      right: 40px !important;
      left: -45% !important;
      padding: 3px;
    }


    #preview-container {
      margin: 50px auto;
      width: 600px;
    }

    #upload-dialog {
      padding: 5px;
      border: 1px solid #336699;
      background-color: white;
      color: #336699;
      background: none;
      font-size: inherit;
      font-family: inherit;
      outline: none;
      display: inline-block;
      vertical-align: middle;
      cursor: pointer;
      border-radius: 2px;
    }

    #pdf-file {
      display: none;
    }

    #pdf-loader {
      display: none;
      vertical-align: middle;
      color: #cccccc;
      font-size: 12px;
    }

    #pdf-preview {
      display: none;
      vertical-align: middle;
      border: 1px solid rgba(0, 0, 0, 0.2);
      border-radius: 2px;
    }

    #pdf-name {
      display: none;
      vertical-align: middle;
      color: #336699;
      margin: 0 15px;
      max-width: 200px;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
    }

    #upload-button {
      padding: 5px;
      border: 1px solid #336699;
      background-color: #336699;
      color: white;
      font-size: inherit;
      font-family: inherit;
      outline: none;
      display: none;
      vertical-align: middle;
      cursor: pointer;
      border-radius: 2px;
    }

    #cancel-pdf {
      display: none;
      vertical-align: middle;
      padding: 0px;
      border: none;
      color: #777777;
      background-color: white;
      font-size: inherit;
      font-family: inherit;
      outline: none;
      vertical-align: middle;
      cursor: pointer;
      margin: 0 0 0 15px;
    }

    .background {
      background: none !important;
    }
  </style>
</head>
<div id="wrapper">
  <div class="profile-tab-content">
    <?php $this->load->view('partials/_messages'); ?>
    <?php echo form_open_multipart("update-supplier-profile-logo", ['id' => 'form_validate1']); ?>
    <div class="row">
      <div class="col-sm-12 m-b-30 groove" style="padding-top: 2%;">
        <div class="col-sm-3 m-b-30">
          <div class="row text-center">
            <?php if (!isset($this->auth_user->avatar)) : ?>
              <img id="image" class="profileImage-default" src="<?php echo base_url() . 'assets/img/upload.jpg'; ?> " style="border-radius:50%" />
            <?php else : ?>
              <img id="image" class="profileImage" src="<?php echo base_url() . $this->auth_user->avatar; ?>" style="border-radius:50%" />
            <?php endif; ?>
            <input type="file" name="profile-image" id="myfile" style="display: none;" onchange="imageShow(this,'image')" />
            <!-- <i class=" fa fa-image fa-4x story"></i> -->
            <script>
              $('#image').click(function() {
                $('#myfile').click()
              })
            </script>
          </div>
          <div class="row text-center">
            <label>Upload Profile Pic</label>
          </div>
        </div>
        <div class="col-sm-6 m-b-30 groove">
          <h><label class="control-label1">Hi <?php echo ucfirst($this->auth_user->first_name); ?><?php echo "!" ?> </label></h>
          <div><textarea class="input" name="about_me" rows="8" cols="30" style="padding:5px; background:white; border:1px solid #ced4da;" placeholder="<?php echo trans("story_placeholder"); ?>"><?php echo $this->auth_user->about_me; ?></textarea></div>
        </div>
        <div class="col-sm-3 m-b-30">
          <div class="row text-center">
            <?php if (!isset($this->auth_user->brand_logo)) : ?>
              <img id="brand-image" class="profileImage-default" src="<?php echo base_url() . 'assets/img/upload.jpg'; ?> " style="border-radius:50%" />
            <?php else : ?>
              <img id="brand-image" class="profileImage" src="<?php echo base_url() . $this->auth_user->brand_logo; ?>" style="border-radius:50%" />
            <?php endif; ?>
            <input type="file" name="logo-image" id="brand-logo" style="display: none;" onchange="imageShow(this,'brand-image')" />
            <!-- <i class=" fa fa-image fa-4x story"></i> -->
            <script>
              $('#brand-image').click(function() {
                $('#brand-logo').click()
              })
            </script>
          </div>
          <div class="row text-center">
            <label>Upload Brand Logo</label>
          </div>
        </div>


        <div class="form-group">
          <div class="row Brand-1">
            <div class="col-md-3" id="formlabel"><label>Your Video URL </label></div>
            <div class="col-md-9 Brand-name">
              <input type='text' name="story_vedio_url" id="story_vedio_url" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->supplier_story_url); ?>">
            </div>
          </div>
        </div>

        <div>

          <button type="submit" name="submit" value="update_profile" style="margin-bottom: 2%;" class="btn btn-lg btn-success pull-right"><?php echo trans("save_profile_brand") ?></button>

        </div>
      </div>
    </div>
  </div>
  <?php echo form_close(); ?>



  <?php echo form_open_multipart("update-story-post", ['id' => 'form_validate']); ?>
  <div class="profile-tab-content">
    <div class="row">
      <div class="col-sm-12 m-b-30 groove">
        <label id="label1">Your Bank Details</label>
        <div class="form-group">
          <div class="row Brand-1">
            <div class="col-md-3"><label id="formlabel2">Account Holder Name<span class="Validation_error"> *</span></label></div>
            <div class="col-md-9 Brand-name">
              <input type='text' name="holder_name" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->acc_holder_name); ?>" required>
            </div>
          </div>
          <!-- <input type="text" name="holder_name" class="form-control form-input"  placeholder="Enter Account Holder Name"  required> -->
        </div>
        <div class="form-group">
          <div class="row Brand-1">
            <div class="col-md-3"><label id="formlabel2">Account Number<span class="Validation_error"> *</span></label></div>
            <div class="col-md-9 Brand-name">
              <input type='password' name="account_number" id="account_number" class="form-control auth-form-input" minlength="9" value="<?php echo html_escape($this->auth_user->account_number); ?>" required onkeyup="checkLength()">
              <span style="color: red;" id="acc_number"></span>

            </div>
          </div>
          <div class="row Brand-1">
            <div class="col-md-3"><label id="formlabel2">Confirm Account Number<span class="Validation_error"> *</span></label></div>
            <div class="col-md-9 Brand-name">
              <input type='text' name="confirm_account_number" id="confirm_account_number" class="form-control auth-form-input" minlength="9" value="<?php echo html_escape($this->auth_user->account_number); ?>" required>
              <span style="color: red;" id="verity_account"></span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row Brand-1">
            <div class="col-md-3"><label id="formlabel2">IFSC Code<span class="Validation_error"> *</span></label></div>
            <div class="col-md-9 Brand-name">
              <input type='text' name="ifsc_code" id="ifsc_code" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->ifsc_code); ?>" required onchange="validate_ifsc($( '#ifsc_code').val())">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row Brand-1">
            <div class="col-md-3"><label id="formlabel2">Bank Branch<span class="Validation_error"> *</span></label></div>
            <div class="col-md-9 Brand-name">
              <input type='text' name="bank_branch" id="bank_branch" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->bank_branch); ?>" required readonly>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row Brand-1">
            <div class="col-md-3"><label id="formlabel2">Add Cheque Image<span class="Validation_error"> *</span></label></div>
            <div class="col-sm-3 m-b-60">
              <div class="row text-center">
                <?php if (empty($this->auth_user->cheque_image_url)) : ?>
                  <img id="cheque-image" class="upload-documents" src="<?php echo base_url() . 'assets/img/upload.jpg'; ?> " style="border-radius:10%" />
                <?php else : ?>
                  <img id="cheque-image" class="upload-documents" src="<?php echo base_url() . 'assets/img/cheque_image.jpeg'; ?>" style="border-radius:10%" />
                <?php endif; ?>
                <input type="file" name="cheque-image" id="cheque-logo" required="" style="display: none;" value="<?php echo (!empty($this->auth_user->cheque_image_url)) ? $this->auth_user->cheque_image_url : ''; ?>required" />

                <p id="file-upload-filename" style="margin-bottom:0;"></p>
                <span style="color: red;" id="cheque_error"></span>

                <?php if (!empty($this->auth_user->cheque_image_url)) : ?>
                  <small> <a href="<?php echo base_url() . $this->auth_user->cheque_image_url; ?>" target="_blank">View Cheque Image</a></small>
                <?php endif; ?>

                <script>
                  $('#cheque-image').click(function() {
                    $('#cheque-logo').click()
                  })
                </script>
                <script>
                  function cheque_image() {
                    let cheque_image = $('#cheque-logo').val();
                    if (cheque_image.length == 0) {
                      $('#cheque_error').html("Please enter cheque image.");
                    } else {
                      $('#cheque_error').html("");
                    }
                  }
                </script>

              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="background col-sm-6 m-b-30 groove">
          <label class="control-label"><?php echo trans("story_images"); ?> (Maximum upload file size : 30 Mb)</label>
          <?php $this->load->view("settings/_story_image_update_box"); ?>
        </div>
        <div class="background col-sm-6 m-b-30 groove">
          <label class="control-label"><?php echo trans("story_video"); ?> (Maximum upload file size : 30 Mb)</label>
          <?php $this->load->view("dashboard/product/_story_video_box"); ?>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 m-b-30 groove">
          <label id="label1">About Your Brand</label>
          <div class="form-group">
            <div class="row Brand-1">
              <div class="col-md-3"><label id="formlabel2">Brand Name<span class="Validation_error"> *</span></label></div>
              <div class="col-md-9 Brand-name">
                <input type='text' name="brand_name" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->brand_name); ?>" required>
              </div>
            </div>
            <!-- <input type="text" name="brand_name" class="form-control form-input"  placeholder="Enter Brand Name" onKeyPress="if(this.value.length==10) return false;" required> -->
          </div>
          <div class="form-group">
            <div class="row Brand-1">
              <div class="col-md-3"><label id="formlabel2">Brand Description<span class="Validation_error"> *</span></label></div>
              <div class="col-md-9 Brand-name">
                <input type='text' name="brand_desc" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->brand_desc); ?>" required>
              </div>
            </div>
            <!-- <input type="text" name="brand_desc" class="form-control form-input"  placeholder="Describe your brand" onKeyPress="if(this.value.length==10) return false;" required> -->
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-sm-12 m-b-30 groove">
          <label id="label1">Assistance (Optional)</label>
          <div class="box-body" style="padding-top:0px">
            <div class="row">
              <!-- include message block -->
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table table-striped dataTable" id="cs_datatable_lang" role="grid" aria-describedby="example1_info">
                    <thead>
                      <tr role="row">
                        <th scope="col"></th>
                        <th scope="col">Service name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Price</th>
                        <th scope="col">Payment</th>
                      </tr>
                    </thead>
                    <tbody>

                      <tr>
                        <td><input type="checkbox" name="assistance[]" value="Photography" <?php echo (in_array("Photography", $assistance_array)) ? 'checked' : ''; ?>></td>
                        <td>Photography</td>
                        <td></td>
                        <td>Basis scope of work</td>
                        <td><a href="#" data-toggle="modal" data-target="#example1Modal">Click Here</a></td>
                      </tr>
                      <tr>
                        <td><input type="checkbox" name="assistance[]" value="Videos" <?php echo (in_array("Videos", $assistance_array)) ? 'checked' : ''; ?>></td>
                        <td>Videos</td>
                        <td></td>
                        <td>6000 + GST</td>
                        <td><a href="#" data-toggle="modal" data-target="#example2Modal">Click Here</a></td>
                      </tr>
                      <tr>
                        <td><input type="checkbox" name="assistance[]" value="Story writing/Content Writing" <?php echo (in_array("Story writing/Content Writing", $assistance_array)) ? 'checked' : ''; ?>></td>
                        <td>Story writing/Content Writing</td>
                        <td></td>
                        <td>500 + GST</td>
                        <td><a href="#" data-toggle="modal" data-target="#example3Modal">Click Here</a></td>
                      </tr>
                      <tr>
                        <td><input type="checkbox" name="assistance[]" value="Product description" <?php echo (in_array("Product description", $assistance_array)) ? 'checked' : ''; ?>></td>
                        <td>Product description</td>
                        <td></td>
                        <td>100 + GST</td>
                        <td><a href="#" data-toggle="modal" data-target="#example4Modal">Click Here</a></td>
                      </tr>
                      <tr>
                        <td><input type="checkbox" name="assistance[]" value="Brand description" <?php echo (in_array("Brand description", $assistance_array)) ? 'checked' : ''; ?>></td>
                        <td>Brand description</td>
                        <td></td>
                        <td>100 + GST</td>
                        <td><a href="#" data-toggle="modal" data-target="#example5Modal">Click Here</a></td>
                      </tr>
                      <tr>
                        <td><input type="checkbox" name="assistance[]" value="Creating Supplier Page" <?php echo (in_array("Creating Supplier Page", $assistance_array)) ? 'checked' : ''; ?>></td>
                        <td>Creating Supplier Page</td>
                        <td></td>
                        <td>2000 + GST</td>
                        <td><a href="#" data-toggle="modal" data-target="#example7Modal">Click Here</a></td>
                      </tr>
                      <tr>
                        <td><input type="checkbox" name="assistance[]" value="Packaging Assistance" <?php echo (in_array("Packaging Assistance", $assistance_array)) ? 'checked' : ''; ?>></td>
                        <td>Packaging Assistance</td>
                        <td></td>
                        <td>Basis scope of work</td>
                        <td><a href="#" data-toggle="modal" data-target="#example1Modal">Click Here</a></td>
                      </tr>
                      <tr>
                        <td><input type="checkbox" name="assistance[]" value="IPR (Intellectual Property Rights)" <?php echo (in_array("IPR (Intellectual Property Rights)", $assistance_array)) ? 'checked' : ''; ?>></td>
                        <td>IPR (Intellectual Property Rights)</td>
                        <td></td>
                        <td>Basis scope of work</td>
                        <td><a href="#" data-toggle="modal" data-target="#example1Modal">Click Here</a></td>
                      </tr>
                      <tr>
                        <td><input type="checkbox" name="assistance[]" value="Promotional Support" <?php echo (in_array("Promotional Support", $assistance_array)) ? 'checked' : ''; ?>></td>
                        <td>Promotional Support</td>
                        <td></td>
                        <td><a href="#" data-toggle="modal" data-target="#contact-modal">Click Here</a></td>
                        <td><a href="#" data-toggle="modal" data-target="#contact-modal">Click Here</a></td>
                      </tr>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
      </div>

      <div class="modal fade" id="example2Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered1" role="document">
          <div class="modal-content1">
            <div class="modal-header1">
              <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
              <h5 class="modal-title" id="exampleModalLabel">Contact vendor</h5>
            </div>
            <br>
            <div class="modal-body"><?php echo get_content("video_shoot_detail"); ?> </div>
            <br>
            <div class="modal-footer1">
              <button type="button" class="btn btn-custom" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="example3Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered1" role="document">
          <div class="modal-content1">
            <div class="modal-header1">
              <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
              <h5 class="modal-title" id="exampleModalLabel">Contact vendor</h5>
            </div>
            <br>
            <div class="modal-body"><?php echo get_content("story_writing_detail"); ?> </div>
            <br>
            <div class="modal-footer1">
              <button type="button" class="btn btn-custom" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="example5Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered1" role="document">
          <div class="modal-content1">
            <div class="modal-header1">
              <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
              <h5 class="modal-title" id="exampleModalLabel">Contact vendor</h5>
            </div>
            <br>
            <div class="modal-body"><?php echo get_content("product_description_detail"); ?> </div>
            <br>
            <div class="modal-footer1">
              <button type="button" class="btn btn-custom" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="example4Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered1" role="document">
          <div class="modal-content1">
            <div class="modal-header1">
              <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
              <h5 class="modal-title" id="exampleModalLabel">Contact vendor</h5>
            </div>
            <br>
            <div class="modal-body"><?php echo get_content("brand_description_detail"); ?> </div>
            <br>
            <div class="modal-footer1">
              <button type="button" class="btn btn-custom" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="example7Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered1" role="document">
          <div class="modal-content1">
            <div class="modal-header1">
              <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
              <h5 class="modal-title" id="exampleModalLabel">Contact vendor</h5>
            </div>
            <br>
            <div class="modal-body"><?php echo get_content("creating_supplier_page"); ?> </div>
            <br>
            <div class="modal-footer1">
              <button type="button" class="btn btn-custom" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12 m-b-30 groove">
          <label id="label1">Supplier Speciality<span class="Validation_error"> *</span></label>
          <div class="form-group">
            <div class="row " style="padding-left: 29px;">
              <div class="col-12 col-sm-3 col-custom-field ">
                <div class="custom-control1 custom-radio">
                  <input type="radio" name="supplier_speciality" value="Out of regular job" id="Out_of_regular_job" class="custom-control-input" required <?php if ($this->auth_user->supplier_speciality == "Out of regular job") {
                                                                                                                                                            echo "checked";
                                                                                                                                                          } ?>>
                  <label for="Out_of_regular_job" class="custom-control-label tooltip-product">Out of regular job <i class="fa fa-info-circle"><span class="tooltiptext">If you are not working either by design (personal choice) or by default (driven by pandemic)</span></i> </label>


                  <!-- <div class="col-12 col-sm-4 col-custom-field">
              <div class="custom-control custom-radio">
                <input type="radio" name="supplier_speciality" value="Phoenix (Rising from the ashes)" id="Phoenix" class="custom-control-input" required <?php if ($this->auth_user->supplier_speciality == "Phoenix (Rising from the ashes)") {
                                                                                                                                                            echo "checked";
                                                                                                                                                          } ?>>
                <label for="Phoenix" class="custom-control-label tooltip-product">Phoenix (Rising from the ashes) <i class="fa fa-info-circle"><span class="tooltiptext"> The going was not smooth earlier, however, you have decided to not give up and are looking to create opportunities despite facing adversities</span></i> </label>
              </div> -->

                </div>
              </div>
              <div class="col-12 col-sm-3 col-custom-field">
                <div class="custom-control1 custom-radio">
                  <input type="radio" name="supplier_speciality" value="Pursuing Passion" id="Pursuing_Passion" class="custom-control-input" required <?php if ($this->auth_user->supplier_speciality == "Pursuing Passion") {
                                                                                                                                                        echo "checked";
                                                                                                                                                      } ?>>
                  <label for="Pursuing_Passion" class="custom-control-label tooltip-product">Pursuing Passion <i class="fa fa-info-circle"><span class="tooltiptext">Work is your passion, your passion has become your work. You are pursuing what you love doing.</span></i> </label>
                </div>
              </div>
              <div class="col-12 col-sm-3 col-custom-field">
                <div class="custom-control1 custom-radio">
                  <input type="radio" name="supplier_speciality" value="Sole Bread Earner" id="Sole_Bread_Earner" class="custom-control-input" required <?php if ($this->auth_user->supplier_speciality == "Sole Bread Earner") {
                                                                                                                                                          echo "checked";
                                                                                                                                                        } ?>>
                  <label for="Sole_Bread_Earner" class="custom-control-label tooltip-product">Sole Bread Earner <i class="fa fa-info-circle"><span class="tooltiptext">You are the superman/woman of your family, providing for all needs and luxuries</span></i> </label>
                </div>
              </div>
              <div class="col-12 col-sm-3 col-custom-field">
                <div class="custom-control1 custom-radio">
                  <input type="radio" name="supplier_speciality" value="Cooperative Groups" id="Cooperative_Groups" class="custom-control-input" required <?php if ($this->auth_user->supplier_speciality == "Cooperative Groups") {
                                                                                                                                                            echo "checked";
                                                                                                                                                          } ?>>
                  <label for="Cooperative_Groups" class="custom-control-label tooltip-product">Cooperative Groups <i class="fa fa-info-circle"><span class="tooltiptext"> You have decided to hunt in packs, and are<br>creating products / providing services in <br>a group.</span></i> </label>
                </div>
              </div>
              <div class="col-12 col-sm-3 col-custom-field">
                <div class="custom-control1 custom-radio">
                  <input type="radio" name="supplier_speciality" value="First Venture" id="First_Venture" class="custom-control-input" required <?php if ($this->auth_user->supplier_speciality == "First Venture") {
                                                                                                                                                  echo "checked";
                                                                                                                                                } ?>>
                  <label for="First_Venture" class="custom-control-label tooltip-product">First Venture <i class="fa fa-info-circle"><span class="tooltiptext"> This is your first attempt at being an entrepreneur and contribute effectively to the objective of nation building</span></i> </label>
                </div>
              </div>
              <div class="col-12 col-sm-3 col-custom-field">
                <div class="custom-control1 custom-radio">
                  <input type="radio" name="supplier_speciality" value="Gritty over Sixty" id="Gritty_over_Sixty" class="custom-control-input" required <?php if ($this->auth_user->supplier_speciality == "Gritty over Sixty") {
                                                                                                                                                          echo "checked";
                                                                                                                                                        } ?>>
                  <label for="Gritty_over_Sixty" class="custom-control-label tooltip-product">Gritty over Sixty <i class="fa fa-info-circle"><span class="tooltiptext"> You choose to continue your entrepreneurial journey even though your peers might have decided to hang up their boots</span></i> </label>
                </div>
              </div>
              <div class="col-12 col-sm-4 col-custom-field">
                <div class="custom-control1 custom-radio">
                  <input type="radio" name="supplier_speciality" value="Phoenix (Rising from the ashes)" id="Phoenix" class="custom-control-input" required <?php if ($this->auth_user->supplier_speciality == "Phoenix (Rising from the ashes)") {
                                                                                                                                                              echo "checked";
                                                                                                                                                            } ?>>
                  <label for="Phoenix" class="custom-control-label tooltip-product">Phoenix (Rising from the ashes) <i class="fa fa-info-circle"><span class="tooltiptext"> The going was not smooth earlier, however, you have decided to not give up and are looking to create opportunities despite facing adversities</span></i> </label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12 m-b-30 groove">
          <div class="form-group">
            <br>
            <div class="row Brand-1">
              <div class="col-md-4"><label id="formlabel2">Number of unique products offered by you<span class="Validation_error"> *</span></label></div>
              <div class="col-md-8 Brand-name">
                <select name="different_type_products" id="different_type_products" class="form-control auth-form-input" placeholder="">
                  <option value="" selected disabled>Select an option</option>
                  <option value="Less than 2" <?php if ($this->auth_user->different_type_products == "Less than 2") {
                                                echo "selected";
                                              } ?>>Less than 2</option>
                  <option value="2-5" <?php if ($this->auth_user->different_type_products == "2-5") {
                                        echo "selected";
                                      } ?>>2-5</option>
                  <option value="5-10" <?php if ($this->auth_user->different_type_products == "5-10") {
                                          echo "selected";
                                        } ?>>5-10</option>
                  <option value="10-15" <?php if ($this->auth_user->different_type_products == "10-15") {
                                          echo "selected";
                                        } ?>>10-15</option>
                  <option value="More than 15" <?php if ($this->auth_user->different_type_products == "More than 15") {
                                                  echo "selected";
                                                } ?>>More than 15</option>
                </select>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="row">
        <!--<div class="col-sm-12 m-b-30 groove">
        <label id="label1">Your Customers Testimonials</label>
        <div class="form-group">
          <div class="row Brand-1">
            <div class="col-md-3"><label id="formlabel2">Customer Name:</label></div>
            <div class="col-md-9 Brand-name">
              <input type='text' name="customer_name" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->customer_name); ?>"></label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row Brand-1">
            <div class="col-md-3"><label id="formlabel2">Testimonial:</label></div>
            <div class="col-md-9 Brand-name">
              <input type='text' name="testimonial" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->testimonial); ?>">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="row Brand-1">
            <div class="col-md-3"><label id="formlabel2">Source:</label></div>
            <div class="col-md-9 Brand-name ">
              <input type='text' name="source" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->source); ?>">
            </div>
          </div>
        </div>
      </div> -->
        <div class="col-sm-3 m-b-30">
          <?php if (!empty($this->auth_user->gst_image)) : ?>
            <a href="javascript:void(0)" class="remove-btn-btn" onclick="delete_item('profile_controller/delete_gst','<?php echo $this->auth_user->id; ?>','Are you sure you want to remove this GST Image?');">
              <i class="icon-close btn-cross"></i></a>
          <?php else : ?>
            <a href="javascript:void(0)" class="remove-btn-btn display-none" id="gst-image-delete" onclick="delete_selected_item($(this),'gst-image','gst-logo','Are you sure you want to remove this GST Image?');">
              <i class="icon-close btn-cross"></i></a>
          <?php endif; ?>
          <div class="row text-center">
            <?php if (empty($this->auth_user->gst_image)) : ?>
              <img id="gst-image" class="upload-documents" src="<?php echo base_url() . 'assets/img/upload.jpg'; ?> " style="border-radius:10%" />
            <?php else : ?>
              <img id="gst-image" class="upload-documents" src="<?php echo base_url() . 'assets/img/certificate.png'; ?>" style="border-radius:10%" />
            <?php endif; ?>
            <input type="file" name="gst-image" id="gst-logo" style="display: none;" value="<?php echo (!empty($this->auth_user->gst_image)) ? $this->auth_user->gst_image : ''; ?>" />
            <p id="file-upload-filename" style="margin-bottom:0;"></p>

            <?php if (!empty($this->auth_user->gst_image)) : ?>
              <small> <a href="<?php echo base_url() . $this->auth_user->gst_image; ?>" target="_blank">View GST</a></small>
            <?php endif; ?>

          </div>
          <script>
            $('#gst-image').click(function() {
              $('#gst-logo').click()
            })
          </script>

          <div class="row text-center">
            <label>Upload GST Photo (Optional)</label>
          </div>
        </div>
        <div class="col-sm-3 m-b-30">
          <?php if (!empty($this->auth_user->pan_image)) : ?>
            <a href="javascript:void(0)" class="remove-btn-btn" onclick="delete_item('profile_controller/delete_pan','<?php echo $this->auth_user->id; ?>','Are you sure you want to remove this PAN Image?');">
              <i class="icon-close btn-cross"></i></a>
          <?php else : ?>
            <a href="javascript:void(0)" class="remove-btn-btn display-none" id="pan-image-delete" onclick="delete_selected_item($(this),'pan-image','pan-logo','Are you sure you want to remove this PAN Image?');">
              <i class="icon-close btn-cross"></i></a>
          <?php endif; ?>
          <div class="row text-center">
            <?php if (empty($this->auth_user->pan_image)) : ?>
              <img id="pan-image" class="upload-documents" src="<?php echo base_url() . 'assets/img/upload.jpg'; ?> " style="border-radius:10%" />
            <?php else : ?>
              <img id="pan-image" class="upload-documents" src="<?php echo base_url() . 'assets/img/certificate.png'; ?>" style="border-radius:10%" />
            <?php endif; ?>
            <input type="file" name="pan-image" id="pan-logo" style="display: none;" value="<?php echo (!empty($this->auth_user->pan_image)) ? $this->auth_user->pan_image : ''; ?>" />
            <p id="file-upload-filename" style="margin-bottom:0;"></p>

            <?php if (!empty($this->auth_user->pan_image)) : ?>
              <small> <a href="<?php echo base_url() . $this->auth_user->pan_image; ?>" target="_blank">View PAN card</a></small>
            <?php endif; ?>

          </div>
          <script>
            $('#pan-image').click(function() {
              $('#pan-logo').click()
            })
          </script>

          <div class="row text-center">
            <label>Upload Pan (Optional)</label>
          </div>
        </div>
        <div class="col-sm-3 m-b-30">
          <?php if (!empty($this->auth_user->aadhar_image)) : ?>
            <a href="javascript:void(0)" id="aadhar" class="remove-btn-btn" onclick="delete_item('profile_controller/delete_adhaar','<?php echo $this->auth_user->id; ?>','Are you sure you want to remove this Aadhaar Image?');">
              <i class="icon-close btn-cross"></i></a>
          <?php else : ?>
            <a href="javascript:void(0)" class="remove-btn-btn display-none" id="adhaar-image-delete" onclick="delete_selected_item($(this),'adhaar-image','adhaar-logo','Are you sure you want to remove this Aadhaar Image?');">
              <i class="icon-close btn-cross"></i></a>
          <?php endif; ?>
          <div class="row text-center">
            <?php if (empty($this->auth_user->aadhar_image)) : ?>
              <img id="adhaar-image" class="upload-documents" src="<?php echo base_url() . 'assets/img/upload.jpg'; ?> " style="border-radius:10%" />
            <?php else : ?>
              <img id="adhaar-image" class="upload-documents" src="<?php echo base_url() . 'assets/img/certificate.png'; ?>" style="border-radius:10%" />
            <?php endif; ?>
            <input type="file" name="adhaar-image" id="adhaar-logo" style="display: none;" value="<?php echo (!empty($this->auth_user->aadhar_image)) ? $this->auth_user->aadhar_image : ''; ?>" />
            <p id="file-upload-filename" style="margin-bottom:0;"></p>

            <?php if (!empty($this->auth_user->aadhar_image)) : ?>
              <small> <a href="<?php echo base_url() . $this->auth_user->aadhar_image; ?>" target="_blank">View Adhaar card</a></small>
            <?php endif; ?>

          </div>
          <script>
            $('#adhaar-image').click(function() {
              $('#adhaar-logo').click()
            })
          </script>

          <div class="row text-center">
            <label>Upload IPR/Trademark(Optional)</label>
          </div>
        </div>
        <div class="col-sm-3 m-b-30">
          <?php if (!empty($this->auth_user->other_image)) : ?>
            <a href="javascript:void(0)" class="remove-btn-btn" onclick="delete_item('profile_controller/delete_certificate','<?php echo $this->auth_user->id; ?>','Are you sure you want to remove this Certificate?');">
              <i class="icon-close btn-cross"></i></a>
          <?php else : ?>
            <a href="javascript:void(0)" class="remove-btn-btn display-none" id="other-image-delete" onclick="delete_selected_item($(this),'other-image','other-logo','Are you sure you want to remove this Certificate?');">
              <i class="icon-close btn-cross"></i></a>
          <?php endif; ?>
          <div class="row text-center">
            <?php if (empty($this->auth_user->other_image)) : ?>
              <img id="other-image" class="upload-documents" src="<?php echo base_url() . 'assets/img/upload.jpg'; ?> " style="border-radius:10%" />
            <?php else : ?>
              <img id="other-image" class="upload-documents" src="<?php echo base_url() . 'assets/img/certificate.png'; ?>" style="border-radius:10%" />
            <?php endif; ?>
            <input type="file" name="other-image" id="other-logo" style="display: none;" value="<?php echo (!empty($this->auth_user->other_image)) ? $this->auth_user->other_image : ''; ?>" />
            <p id="file-upload-filename" style="margin-bottom:0;"></p>

            <?php if (!empty($this->auth_user->other_image)) : ?>
              <small> <a href="<?php echo base_url() . $this->auth_user->other_image; ?>" target="_blank">View Certificate</a></small>
            <?php endif; ?>
            <label class="tooltip-product-other-info1">Upload Certificates (Optional)&nbsp;<i class="fa fa-info-circle"></i><span class="tooltiptext-product" style="top: 50%;">Upload FSSAI license/registration if you're a food provider, any other certificate /license if you're not a food provider</span></label>
          </div>
          <script>
            $('#other-image').click(function() {
              $('#other-logo').click()
            })
          </script>
        </div>
      </div>
    </div>
  </div>
  <?php if ($this->auth_user->update_profile == 1) : ?>
    <button type="submit" name="submit" value="update" onclick="cheque_image();" class="btn btn-lg btn-success pull-right"><?php echo trans("save_changes") ?></button>
  <?php endif; ?>
  <?php if ($this->auth_user->update_profile == 0) : ?>
    <button type="submit" name="submit" value="save_and_next_details" onclick="cheque_image();" class="btn btn-lg btn-success pull-right">Save and Next</button>
  <?php endif; ?>
  <?php echo form_close(); ?>
</div>
<div class="modal fade" id="fee_schedule_modal" data-backdrop="static" role="dialog" style="display:none;">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content" style="overflow-y:scroll;max-height:650px;">
      <?php echo form_open("agree-fee-schedule", ['name' => 'agree_fee_form']); ?>
      <input type="hidden" name="agree_fee_schedule" value="1">
      <div class="modal-header background-gradient text-center">
        <!-- <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button> -->
        <h3>Gharobaar Fee Schedule</h3>
      </div>
      <div class="modal-body background-gradient text-left">

        <p>
          Gharobaar has a simple and transparent fee structure for sellers/ Service Providers with no hidden charges. To sell your Product (s) or Service(s) on Gharobaar, you will pay referral fees, Payment Gateway Fees and Cancellation Charge (Wherever applicable.)
        </p>
        <h3>
          Referral fees*
        </h3>
        <p>
          Seller(s)/ Service Provider(s) have to pay a referral fee on each order placed by the buyer with regard to the item or Services listed by the Seller/Service Provider on Gharobaar Site.
        </p>
        <p>
          For all products listed on the Gharobaar Site by the seller/Service Provider, a 10% percent of the total sales proceeds paid to the seller/Service Provider with regard to their product/Services, excluding the GST or any other applicable taxes paid to the Government Authorities (including the item price which may or may not include any shipping or gift-wrap charges charged by the seller) is deducted as a referral fee (The applicable GST shall be charged on such referral fee as actual).
        </p>
        <h3>Payment Gateway Fee**</h3>

        <p>Sellers/Service Providers have to pay a payment gateway fee for each successful transaction.</p>
        <p>
          For each successful transaction for the purchase of the listed products by the Seller/Service Provider, Seller/Service Provider has to pay payment gateway charges, which along with the applicable GST will be charged extra as actual on each successful online transaction.
        </p>
        <h3>Cancellation charge***</h3>

        <h4>For Sellers</h4>

        <p>Seller will be charged 100% of referral fee (if cancelled on or before Estimated Shipping date) /150% of referral fee (if cancelled after Estimated Shipping date) of the value of items in an order as a Cancellation Charge for the orders that are cancelled under the following scenarios:</p>
        <ol type=1>
          <li>Order is cancelled by seller for any reason other than buyer request. (Only cancellations requested by buyers through the Gharobaar website are considered buyer-requested cancellations and will be exempt from the Cancellation Charge.)
          </li>
          <li>Order is cancelled by Gharobaar because the seller has not shipped and confirmed shipping of the order within 48 hours of Estimated Ship Date.
          </li>
        </ol>
        <p>Seller will not be charged any cancellation charge for the orders that are cancelled under the following scenarios:
        </p>
        <ol type=1>
          <li>For the products that are on the “Made to Order” basis and the seller is unable to process the same due to unavailability of the ready Inventory or seller would not be able to fulfil the order in accordance with the defined shipping SLA’s, provided that seller has cancelled the order within 2 hours of the time order is placed by the buyer, nothing under this Agreement shall prevent or impair Gharobaar’s right to penalize you for your failure to update the inventory reflected on the platform as available and the order placed by the buyer is not fulfilled.
          </li>
        </ol>
        <h4>For Service Providers</h4>

        <p>Service Provider will be charged 100% of referral fee (if cancelled on or before the appointment date) / 150% of referral fee (if cancelled after Appointment date) of the value of services in an order as a Cancellation Charge for the orders that are cancelled under the following scenarios:
        </p>
        <ol type=1>
          <li>Order is cancelled by service provider for any reason other than buyer request. (Only cancellations requested by buyers through the Gharobaar website are considered buyer-requested cancellations and will be exempt from the Cancellation Charge.)
          </li>
          <li>Order is cancelled by Gharobaar because the Service provider did not arrive or provided services with respect to the listed service on the appointment date.
          </li>
        </ol>
        <p>
          * Please note that for the above-mentioned Referral fees, Gharobaar reserves the right to modify and amend Fee Structure for the sellers at any time by informing at an advance notice of minimum 15 days. This fee in the Gharobaar Fee Schedule, charged to the seller(s)/Service Provider(s) does not include any additional paid services availed by the seller(s)/Service Provider(s) through Gharobaar.
        </p>
        <p>
          ** Please note that the Payment Gateway Charges are subject to change by Gharobaar.
        </p>
        <p>
          *** Please note that seller(s)/Service Provider(s) shall bear any Government Charges Levied for the Transaction, in case of any cancellation by the seller(s)/Service Provider(s). Also these cancellations and delays by the seller(s)/Service Provider(s) will affect the seller(s)/Service Provider(s) ratings in the Loyalty Programs.
        </p>

        <div class="col-12" style="text-align: center;">
          <a class="btn btn-custom" href="<?php echo base_url(); ?>assets/file/Gharobaar_Fee_Schedule_new.pdf" download>Download</a>
          <button id="submit-btn" class="btn btn-custom">Agree</button>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<div class="modal fade" id="example1Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered1" role="document">
    <div class="modal-content1">
      <div class="modal-header1">
        <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
        <h5 class="modal-title" id="exampleModalLabel">Contact vendor</h5>
      </div>
      <br>
      <?php echo form_open('auth_controller/email_us'); ?>
      <form id="contactForm" name="contact" role="form">
        <div class="modal-body">

          <?php echo trans("basis_of_work"); ?>

          <div class="form-group">
            <label for="message">Message</label>
            <textarea name="messagere" class="form-control form-textarea"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Send Email</button>
        </div>
      </form>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<div id="contact-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
        <h3>Email us</h3>
      </div>
      <?php echo form_open('auth_controller/email_us'); ?>
      <form id="contactForm" name="contact" role="form">
        <div class="modal-body">



          <div class="form-group">
            <label for="message">Message</label>
            <textarea name="messagere" class="form-control form-textarea"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Send Email</button>
        </div>
      </form>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>


<script>
  function imageShow(input, id) {
    $('#upload-file-info').html($(input).val().replace(/.*[\/\\]/, ''));
    $("#" + id + "-delete").show();
    readURL(input, id);
  };



  function readURL(input, id) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#' + id).attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }
</script>
<script>
  function Saveandnext() {
    window.location.href = base_url + "dashboard/product/add_product";
  }
</script>
<!-- IFSC code validation API -->
<script>
  function validate_ifsc(ifsc) {
    var url = "https://ifsc.razorpay.com/" + ifsc;
    $.ajax({
      url: url,
      cache: false,
      success: function(html) {
        console.log(html)
        if (!html) {
          // $('#pincode_span')[0].innerHTML = "Please enter a valid pincode.";
          console.log("invalid")
        } else {
          $('input[name="bank_branch"]').val(html.BANK + ", " + html.BRANCH);
          console.log(html.BANK + " " + html.BRANCH);
        }
      }
    })
  }
</script>
<script>
  function checkaccountMatch() {
    var account = $("#account_number").val();
    var confirm_account = $("#confirm_account_number").val();
    if (account == confirm_account) {
      $("#verity_account").html("");
    } else {
      console.log("not match");
      $("#verity_account").html("Account number does not match!");
    }
  }
  $(document).ready(function() {
    $("#confirm_account_number").keyup(checkaccountMatch);
  });
</script>

<script>
  $(document).ready(function() {
    var agree_fee_schedule = '<?php echo $this->auth_user->agree_fee_schedule ?>';
    console.log(agree_fee_schedule);
    if (agree_fee_schedule == "0") {
      $("#fee_schedule_modal").modal("show");
    }
  })
</script>

<script>
  $("#submit-btn").click(function() {
    $("form[name='agree_fee_form']").submit();
  })
</script>
<script>
  // var final_ass;
  // var favorite_assistance = [];
  // $.each($("input[name='assistance']:checked"), function() {
  //   favorite_assistance.push($(this).val());
  // });
  // //final_sup = favorite.toString();
  // console.log(favorite_assistance);

  // );
</script>
<script>
  var input = document.getElementById('other-logo');
  var infoArea = document.getElementById('file-upload-filename');

  input.addEventListener('change', showFileName);

  function showFileName(event) {
    $("#other-image-delete").show();
    // the change event gives us the input it occurred in 
    var input = event.srcElement;

    // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
    var fileName = input.files[0].name;
    var id = 'other-image';
    // use fileName however fits your app best, i.e. add it into a div

    extension = fileName.split('.').pop();
    var reader = new FileReader();
    if (extension == 'pdf' || extension == 'docx') {
      console.log("test")
      reader.onload = function(e) {
        $('#' + id).attr('src', '<?php echo base_url() . 'assets/img/certificate.png'; ?>');
      }
      reader.readAsDataURL(input.files[0]);
    } else {
      console.log("image")
      reader.onload = function(e) {
        $('#' + id).attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>

<script>
  var input1 = document.getElementById('adhaar-logo');
  // var infoArea = document.getElementById('file-upload-filename');

  input1.addEventListener('change', showFileName1);

  function showFileName1(event) {
    $("#adhaar-image-delete").show();
    // the change event gives us the input it occurred in 
    var input1 = event.srcElement;

    // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
    var fileName1 = input1.files[0].name;
    var id1 = 'adhaar-image';
    // use fileName however fits your app best, i.e. add it into a div

    extension1 = fileName1.split('.').pop();
    var reader1 = new FileReader();
    if (extension1 == 'pdf' || extension1 == 'docx') {
      console.log("test")
      reader1.onload = function(e) {
        $('#' + id1).attr('src', '<?php echo base_url() . 'assets/img/certificate.png'; ?>');
      }
      reader1.readAsDataURL(input1.files[0]);
    } else {
      console.log("image")
      reader1.onload = function(e) {
        $('#' + id1).attr('src', e.target.result);
      }
      reader1.readAsDataURL(input1.files[0]);
    }
  }
</script>

<script>
  var input2 = document.getElementById('pan-logo');
  // var infoArea = document.getElementById('file-upload-filename');

  input2.addEventListener('change', showFileName2);

  function showFileName2(event) {
    $("#pan-image-delete").show();
    // the change event gives us the input it occurred in 
    var input2 = event.srcElement;

    // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
    var fileName2 = input2.files[0].name;
    var id2 = 'pan-image';
    // use fileName however fits your app best, i.e. add it into a div

    extension2 = fileName2.split('.').pop();
    var reader2 = new FileReader();
    if (extension2 == 'pdf' || extension2 == 'docx') {
      console.log("test")
      reader2.onload = function(e) {
        $('#' + id2).attr('src', '<?php echo base_url() . 'assets/img/certificate.png'; ?>');
      }
      reader2.readAsDataURL(input2.files[0]);
    } else {
      console.log("image")
      reader2.onload = function(e) {
        $('#' + id2).attr('src', e.target.result);
      }
      reader2.readAsDataURL(input2.files[0]);
    }
  }
</script>

<script>
  var input3 = document.getElementById('gst-logo');
  // var infoArea = document.getElementById('file-upload-filename');

  input3.addEventListener('change', showFileName3);

  function showFileName3(event) {
    $("#gst-image-delete").show();
    // the change event gives us the input it occurred in 
    var input3 = event.srcElement;

    // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
    var fileName3 = input3.files[0].name;
    var id3 = 'gst-image';
    // use fileName however fits your app best, i.e. add it into a div

    extension3 = fileName3.split('.').pop();
    var reader3 = new FileReader();
    if (extension3 == 'pdf' || extension3 == 'docx') {
      console.log("test")
      reader3.onload = function(e) {
        $('#' + id3).attr('src', '<?php echo base_url() . 'assets/img/certificate.png'; ?>');
      }
      reader3.readAsDataURL(input3.files[0]);
    } else {
      console.log("image")
      reader3.onload = function(e) {
        $('#' + id3).attr('src', e.target.result);
      }
      reader3.readAsDataURL(input3.files[0]);
    }
  }
</script>
<!-- cheque image -->

<script>
  var input1 = document.getElementById('cheque-logo');
  // var infoArea = document.getElementById('file-upload-filename');

  input1.addEventListener('change', showFileName1);

  function showFileName1(event) {
    $("#cheque-image-delete").show();
    // the change event gives us the input it occurred in 
    var input1 = event.srcElement;

    // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
    var fileName1 = input1.files[0].name;
    var id1 = 'cheque-image';
    // use fileName however fits your app best, i.e. add it into a div

    extension1 = fileName1.split('.').pop();
    var reader1 = new FileReader();
    if (extension1 == 'pdf' || extension1 == 'docx') {
      console.log("test")
      reader1.onload = function(e) {
        $('#' + id1).attr('src', '<?php echo base_url() . 'assets/img/certificate.png'; ?>');
      }
      reader1.readAsDataURL(input1.files[0]);
    } else {
      console.log("image")
      reader1.onload = function(e) {
        $('#' + id1).attr('src', e.target.result);
      }
      reader1.readAsDataURL(input1.files[0]);
    }
  }
</script>
<script>
  function checkLength() {
    var account = $("#account_number").val();
    if (account.length < 9) {
      $("#acc_number").html("Please enter a valid account number");
      console.log("not match");

    } else {
      $("#acc_number").html("");
    }
  }
</script>