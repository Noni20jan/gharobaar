<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-8">
        <div class="box box-primary">

            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?php echo trans('edit_user'); ?></h3>
                </div>
            </div><!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('membership_controller/edit_user_post'); ?>

            <input type="hidden" name="id" value="<?php echo html_escape($user->id); ?>">

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <div class="form-group">
                    <label class="label label-success"><?php echo $user->role; ?></label>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-profile">
                            <img src="<?php echo html_escape(get_user_avatar($user)); ?>" alt="avatar" class="thumbnail img-responsive img-update" style="max-width: 200px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-profile">
                            <p>
                                <a class="btn btn-success btn-sm btn-file-upload">
                                    <?php echo trans('select_image'); ?>
                                    <input name="file" size="40" accept=".png, .jpg, .jpeg" onchange="$('#upload-file-info').html($(this).val().replace(/.*[\/\\]/, ''));" type="file">
                                </a>
                            </p>
                            <p class='label label-info' id="upload-file-info"></p>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo trans('email'); ?></label>
                    <input type="email" class="form-control form-input" name="email" placeholder="<?php echo trans('email'); ?>" value="<?php echo html_escape($user->email); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label><?php echo trans('username'); ?></label>
                    <input type="text" class="form-control form-input" name="username" placeholder="<?php echo trans('username'); ?>" value="<?php echo html_escape($user->username); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label><?php echo trans('slug'); ?></label>
                    <input type="text" class="form-control form-input" name="slug" placeholder="<?php echo trans('slug'); ?>" value="<?php echo html_escape($user->slug); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
                <div class="form-group">
                    <label><?php echo trans('first_name'); ?></label>
                    <input type="text" class="form-control form-input" name="first_name" placeholder="<?php echo trans('first_name'); ?>" value="<?php echo html_escape($user->first_name); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
                <div class="form-group">
                    <label><?php echo trans('last_name'); ?></label>
                    <input type="text" class="form-control form-input" name="last_name" placeholder="<?php echo trans('last_name'); ?>" value="<?php echo html_escape($user->last_name); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
                <div class="form-group">
                    <label><?php echo trans('phone_number'); ?></label>
                    <input type="text" class="form-control form-input" name="phone_number"   value="<?php echo html_escape($user->phone_number); ?>"  <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" required>
                    <span class="Validation_error" id="number_valid" style="color: #d43f3a;"></span>

                </div>
                <?php if ($user->role == "vendor") : ?>
                    <?php if (!empty($user->shop_name)) : ?>
                    <div class="form-group">
                        <label><?php echo trans('shop_name'); ?></label>
                        <input type="text" class="form-control form-input" name="shop_name" pattern="[a-zA-Z ]+" title="Please input only english words" placeholder="<?php echo trans('shop_name'); ?>" value="<?php echo html_escape($user->shop_name); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo trans('shop_description'); ?></label>
                        <textarea class="form-control text-area" name="about_me" placeholder="<?php echo trans('shop_description'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>><?php echo html_escape($user->about_me); ?></textarea>
                    </div>
                    <?php endif;?>

                <?php endif; ?>
                <?php if ($user->role == "vendor") : ?>
                <div class="form-group">

                    <div class="row">
                        <div class="col-12 col-sm-4 m-b-15">
                            <label class="control-label">Pincode<span class="Validation_error"> *</span>
                            </label>
                            <input type="text" name="pincode" id="pincode"  class="form-control auth-form-input" value="<?php echo $user->pincode ?>" minlength="6" maxlength="6" required onchange="get_location($( '#pincode').val())">
                            <span class="Validation_error" id="pincode_span"></span>
                        </div>
                        <div class="col-12 col-sm-4 m-b-15">
                            <label class="control-label">State<span class="Validation_error"> *</span>
                            </label>
                            <input type="text" name="supplier_state" id="supplier_state" class="form-control auth-form-input" value="<?php echo html_escape($user->supplier_state); ?>" placeholder="State" required readonly>
                            <p class="Validation_error" id="state_p"></p>
                        </div>
                        <div class="col-12 col-sm-4 m-b-15">
                            <label class="control-label">City<span class="Validation_error"> *</span>
                            </label>
                            <input type="text" name="supplier_city" id="supplier_city" class="form-control auth-form-input" value="<?php echo html_escape($user->supplier_city); ?>" placeholder="City" required readonly>
                            <p class="Validation_error" id="city_p"></p>
                        </div>
                        <!-- <div class="col-12 col-sm-6 m-b-sm-15">
                            <input type="text" name="address" class="form-control form-input" value="<?php echo html_escape($user->address); ?>" placeholder="<?php echo trans("address") ?>">
                        </div> -->
                        <!-- <div class="col-12 col-sm-3">
                            <input type="text" name="zip_code" id="zipcode" class="form-control form-input" value="<?php echo html_escape($user->zip_code); ?>" placeholder="<?php echo trans("zip_code") ?>">
                            <span class="Validation_error" id="pincode_valid" style="color: #d43f3a;"></span>
                        </div> -->
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-4 m-b-15">
                            <label class="control-label">Area<span class="Validation_error"> *</span></label>
                            <input type="text" name="area" class="form-control auth-form-input" value="<?php echo html_escape($user->supplier_area); ?>" placeholder="Area" required>
                            <p class="Validation_error" id="area_p"></p>
                        </div>
                        <div class="col-12 col-sm-6 m-b-15">
                            <label class="control-label">House no./Building no./Area<span class="Validation_error"> *</span></label>
                            <input type="text" name="house_no" class="form-control auth-form-input" value="<?php echo html_escape($user->house_no); ?>" placeholder="Area" required>
                            <p class="Validation_error" id="area_p"></p>
                        </div>
                        <div class="col-12 col-sm-6 m-b-15">
                            <label class="control-label">Landmark</label>
                            <input type="text" name="landmark" class="form-control auth-form-input"  value="<?php echo html_escape($user->landmark); ?>" placeholder="Landmark">
                            <p class="Validation_error" id="landmark_p"></p>
                        </div>
                    </div>
                </div>
                <?php endif;?>

                

                <!-- <?php if ($user->role == "vendor") : ?>
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

                <div class="form-group">
                    <label class="control-label"><?php echo trans('vk_url'); ?></label>
                    <input type="text" class="form-control form-input" name="vk_url" placeholder="<?php echo trans('vk_url'); ?>" value="<?php echo html_escape($user->vk_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('youtube_url'); ?></label>
                    <input type="text" class="form-control form-input" name="youtube_url" placeholder="<?php echo trans('youtube_url'); ?>" value="<?php echo html_escape($user->youtube_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div> -->
            <?php endif; ?>
            <?php if ($user->role == "vendor") : ?>
                <?php if(!empty($user->gst_number)):?>
                <div class="form-group">

                    <label class="control-label">GST Number</label>
                    <input type="text" class="form-control form-input" name="gst_number" placeholder="<?php echo trans('youtube_url'); ?>" value="<?php echo html_escape($user->gst_number); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
                <?php endif;?>
                <?php if(!empty($user->pan_number)):?>
                <div class="form-group">
                    <label class="control-label">Pan Number</label>
                    <input type="text" class="form-control form-input" name="pan_number" placeholder="<?php echo trans('youtube_url'); ?>" value="<?php echo html_escape($user->pan_number); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
                <?php endif;?>

                <?php if($user->supplier_type_goods=="Food Products"):?>
                <div class="form-group">
                    <label class="control-label">FSSAI Number</label>
                    <input type="text" class="form-control form-input" name="fssai_number" placeholder="<?php echo trans('youtube_url'); ?>" value="<?php echo html_escape($user->fssai_number); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
                <?php endif;?>
            </div>
        <?php endif; ?>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
        </div>
        <!-- /.box-footer -->
        <?php echo form_close(); ?>
        <!-- form end -->
    </div>
</div>
</div>

<script>
    function get_states(val, map) {
        $('#select_states').children('option').remove();
        $('#select_cities').children('option').remove();
        $('#get_states_container').hide();
        $('#get_cities_container').hide();
        var data = {
            "country_id": val
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "ajax_controller/get_states",
            data: data,
            success: function(response) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("select_states").innerHTML = obj.content;
                    $('#get_states_container').show();
                } else {
                    document.getElementById("select_states").innerHTML = "";
                    $('#get_states_container').hide();
                }
            }
        });
    }

    function get_cities(val, map) {
        var data = {
            "state_id": val
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "ajax_controller/get_cities",
            data: data,
            success: function(response) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("select_cities").innerHTML = obj.content;
                    $('#get_cities_container').show();
                } else {
                    document.getElementById("select_cities").innerHTML = "";
                    $('#get_cities_container').hide();
                }
            }
        });
    }
</script>
<script>
    function get_location(pincode) {
        var url = "https://api.postalpincode.in/pincode/" + pincode;
        $.ajax({
            url: url,
            cache: false,
            success: function(html) {
                if (html[0].PostOffice == null) {
                    $('#pincode_span')[0].innerHTML = "Please enter a valid pincode.";
                    $('#pincode_span1')[0].innerHTML = "Please enter a valid pincode.";
                } else {
                    $('#pincode_span')[0].innerHTML = "";

                    $('input[name="supplier_state"]').val(html[0].PostOffice[0].State)
                    $('input[name="supplier_city"]').val(html[0].PostOffice[0].District)
                    $('input[name="area"]').val(html[0].PostOffice[0].Name)
                    //$('#supplier_area1').val(html[0].PostOffice[0].Name)
                }
            }
        })
    }
</script>
<script>
    $(document).ready(function() {
        if ($("#phone_number").val() == "") {
            $("#number_valid")[0].innerHTML = "*Field must be filled out";
            $('#phone_number').css({
                'borderColor': 'red'
            });

        } else if ($("#phone_number").val().length != 10) {
            $("#number_valid")[0].innerHTML = "*Enter valid number";
            $('#phone_number').css({
                'borderColor': 'red'
            });

        }

$.validator.addMethod(
    "regex",
    function(value, element, regexp) {
        var re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
    },
    "Please enter valid PAN No."
);
$.validator.addMethod(
    "regexGST",
    function(value, element, regexp) {
        var re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
    },
    "Please enter valid GST No."
);



var regex = $("#pan_number")[0].attributes.pattern.value;
$("#pan_number").rules("add", {
    regex: "^" + regex + "$"
});
    });
</script>