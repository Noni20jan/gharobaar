<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .button-follow-followers {
        border-color: #DF911E;
        color: #61b720;
        padding: 10px 32px;
        text-align: center;
        display: inline-block;
        border-radius: 20px;
        font-weight: 500;
        font-size: medium;
        width: 60%;
    }

    @media(max-width:768px) {
        .button-follow-followers {
            border-color: #DF911E;
            color: #61b720;
            padding: 10px 32px;
            text-align: center;
            display: inline-block;
            border-radius: 20px;
            font-weight: 500;
            font-size: medium;
            width: 50%;
        }

        #profile-for-web {
            display: none !important;
        }

        #profile-for-mobile {
            display: table !important;
        }

        .new-width-bank {
            max-width: 100% !important;
        }
    }

    /* #profile-for-web {
        display: table;
    } */

    #profile-for-mobile {
        display: none;
    }

    .btn-new-review {
        background-color: #007C05;
        border-color: #007C05;
        border-radius: 20px;
        color: white;
    }

    .new-width-bank {
        max-width: 50%;
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

</style>
<!--user profile info-->
<div class="row-custom">
    <div class="profile-details" id="profile-for-web">
        <div class="col-md-4 left">
            <!-- <img src="<?php echo get_user_avatar($user); ?>" alt="<?php echo get_shop_name($user); ?>" class="img-profile">
            </div>
            <div class="right"> -->
            <div class="row-custom row-profile-username">
                <h1 class="username">
                    <a href="<?php echo generate_profile_url($user->slug); ?>"> <?php echo get_brand_name($user); ?></a>
                </h1>
                <?php if ($user->role == 'vendor' || $user->role == 'admin') : ?>
                    <i class="icon-verified icon-verified-member"></i>
                <?php endif; ?>
            </div>
            <div class="row-custom">
                <p class="p-last-seen">
                    <span class="last-seen <?php echo (is_user_online($user->last_seen)) ? 'last-seen-online' : ''; ?>"> <i class="icon-circle"></i> <?php echo trans("last_seen"); ?>&nbsp;<?php echo time_ago($user->last_seen); ?></span>
                </p>
            </div>
            <?php if ($user->role == 'admin' || $user->role == 'vendor') : ?>
                <div class="row-custom">
                    <p class="description">
                        <?php echo html_escape(ucfirst($user->brand_desc)); ?>
                    </p>
                </div>
            <?php endif; ?>

            <div class="row-custom user-contact">
                <span class="info"><?php echo trans("member_since"); ?>&nbsp;<?php echo helper_date_format($user->created_at); ?></span>
                <?php if ($user->role == "admin" || $this->general_settings->hide_vendor_contact_information != 1) :
                    if (!empty($user->phone_number) && $user->show_phone == 1) : ?>
                        <span class="info"><i class="icon-phone"></i>
                            <a href="javascript:void(0)" id="show_phone_number"><?php echo trans("show"); ?></a>
                            <a href="tel:<?php echo html_escape($user->phone_number); ?>" id="phone_number" class="display-none"><?php echo html_escape($user->phone_number); ?></a>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($user->email) && $user->show_email == 1) : ?>
                        <span class="info"><i class="icon-envelope"></i><?php echo html_escape($user->email); ?></span>
                <?php endif;
                endif; ?>
                <?php if (!empty(get_location($user)) && $user->show_location == 1) : ?>
                    <span class="info"><i class="icon-map-marker"></i><?php echo get_location($user); ?></span>
                <?php endif; ?>
            </div>



            <!-- <div class="row-custom profile-buttons">


                <div class="social">
                    <ul>
                        <?php if (!empty($user->facebook_url)) : ?>
                            <li><a href="<?php echo $user->facebook_url; ?>" target="_blank"><i class="icon-facebook"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->twitter_url)) : ?>
                            <li><a href="<?php echo $user->twitter_url; ?>" target="_blank"><i class="icon-twitter"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->instagram_url)) : ?>
                            <li><a href="<?php echo $user->instagram_url; ?>" target="_blank"><i class="icon-instagram"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->pinterest_url)) : ?>
                            <li><a href="<?php echo $user->pinterest_url; ?>" target="_blank"><i class="icon-pinterest"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->linkedin_url)) : ?>
                            <li><a href="<?php echo $user->linkedin_url; ?>" target="_blank"><i class="icon-linkedin"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->vk_url)) : ?>
                            <li><a href="<?php echo $user->vk_url; ?>" target="_blank"><i class="icon-vk"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->youtube_url)) : ?>
                            <li><a href="<?php echo $user->youtube_url; ?>" target="_blank"><i class="icon-youtube"></i></a></li>
                        <?php endif; ?>
                        <?php if ($this->general_settings->rss_system == 1 && $user->show_rss_feeds == 1 && get_user_products_count($user->id) > 0) : ?>
                            <li><a href="<?php echo lang_base_url() . "rss/" . get_route("seller", true) . $user->slug; ?>" target="_blank"><i class="icon-rss"></i></a></li>
                        <?php endif; ?>
                    </ul>
                </div>

            </div> -->
        </div>
        <div class="col-md-4 left textcenter">
            <img src="<?php echo get_user_logo($user); ?>" alt="<?php echo get_shop_name($user); ?>" class="img-profile">
            <div class="button-follow-followers">
                <?php if ($this->auth_check) : ?>
                    <?php if ($this->auth_user->id != $user->id) : ?>

                        <!--form follow-->
                        <?php echo form_open('follow-unfollow-user-post', ['class' => 'form-inline']); ?>
                        <input type="hidden" name="following_id" value="<?php echo $user->id; ?>">
                        <input type="hidden" name="follower_id" value="<?php echo $this->auth_user->id; ?>">
                        <?php if (is_user_follows($user->id, $this->auth_user->id)) : ?>
                            <button class="btn btn-md btn-secondary btn-new-review"><i class="icon-user-minus"></i><?php echo trans("unfollow"); ?></button>
                        <?php else : ?>
                            <button class="btn btn-md btn-secondary btn-new-review"><i class="icon-user-plus"></i><?php echo trans("follow"); ?></button>
                        <?php endif; ?>
                        <?php echo form_close(); ?>

                    <?php endif; ?>
                <?php else : ?>
                    <button class="btn btn-md btn-secondary btn-custom" data-toggle="modal" data-target="#loginModal"><i class="icon-user-plus"></i><?php echo trans("follow"); ?></button>
                <?php endif; ?>

                <span class="followercount"><?php echo get_followers_count($user->id); ?> Followers</span>
            </div>
        </div>
        <div class=" col-md-4 left textright">
            <div class="row-custom row-profile-username">
                <h1 class="fullname">
                    <?php echo get_full_name($user); ?>
                </h1>
            </div>
            <?php if ($user->role == 'admin' || $user->role == 'vendor') : ?>
                <div class="row-custom">
                    <p class="supplier_type">
                        <?php if ($user_categories) :
                            $i = 0;
                            foreach ($user_categories as $cat_id => $cat_count) :
                                $category = get_category_by_id($cat_id);
                                echo ($category->name . "<br>");
                                $i++;
                                if ($i >= $this->general_settings->max_category_show)
                                    break;
                            endforeach;
                        ?>

                        <?php else : ?>
                            <?php echo html_escape($user->supplier_type); ?>
                        <?php endif; ?>
                    </p>
                </div>
            <?php endif; ?>

            <div class="row-custom user-contact">
                <?php if (!empty(get_supplier_city($user))) : ?>
                    <span class="suppliercity"><i class="icon-map-marker"></i><?php echo get_supplier_city($user); ?></span>
                <?php endif; ?>
            </div>


        </div>

    </div>

</div>
<?php if ($this->auth_check) : ?>
    <?php if ($this->auth_user->account_number == '' && $this->auth_user->role == 'vendor' && $this->auth_user->username == $user->username) : ?>
        <div class="modal" id="bankaccount" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog new-width-bank" role="document" style="max-width:50%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLongTitle">Please Add Bank Account details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="icon-close"></i> </span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open_multipart("update-payout-account", ['id' => 'form_validate']); ?>
                        <!-- <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 m-b-sm-15">
                                        <label><?php echo trans("bank_account_holder_name"); ?>*</label>
                                        <input type="text" name="swift_bank_account_holder_name" class="form-control form-input" value="<?php echo html_escape($user_payout->swift_bank_account_holder_name); ?>" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label id="bank_media"><?php echo trans("bank_name"); ?>*</label>
                                        <input type="text" name="swift_bank_name" class="form-control form-input" value="<?php echo html_escape($user_payout->swift_bank_name); ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 m-b-sm-15">
                                        <label><?php echo trans("acc"); ?>*</label>
                                        <input type="text" name="swift_iban" class="form-control form-input" value="<?php echo html_escape($user_payout->swift_iban); ?>" required>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label id="ifsc_media">IFSC Code *</label>
                                        <input type="text" name="swift_code" class="form-control form-input" value="<?php echo html_escape($user_payout->swift_code); ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">

                                <label><?php echo trans("bank_branch_city"); ?>*</label>
                                <input type="text" name="swift_bank_branch_city" class="form-control form-input" value="<?php echo html_escape($user_payout->swift_bank_branch_city); ?>" required>

                            </div> -->

                        <!-- <div class="col-12 m-b-30"> -->
                        <div class="row" style="justify-content:center;">
                            <label id="label1">Your Bank Details</label>
                        </div>
                        <div class="form-group">
                            <div class="row Brand-1">
                                <div class="col-md-3"><label id="formlabel2">Account Holder Name<span class="Validation_error"> *</span></label></div>
                                <div class="col-md-9 Brand-name">
                                    <input type='text' name="holder_name" class="form-control auth-form-input" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" value="<?php echo html_escape($this->auth_user->acc_holder_name); ?>" required>
                                </div>
                            </div>
                            <!-- <input type="text" name="holder_name" class="form-control form-input"  placeholder="Enter Account Holder Name"  required> -->
                        </div>
                        <div class="form-group">
                            <div class="row Brand-1">
                                <div class="col-md-3"><label id="formlabel2">Account Number<span class="Validation_error"> *</span></label></div>
                                <div class="col-md-9 Brand-name">
                                    <input type='password' name="account_number" id="account_number" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->account_number); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row Brand-1">
                                <div class="col-md-3"><label id="formlabel2">Confirm Account Number<span class="Validation_error"> *</span></label></div>
                                <div class="col-md-9 Brand-name">
                                    <input type='text' name="confirm_account_number" id="confirm_account_number" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->account_number); ?>" required>
                                    <span style="color: red;" id="verity_account"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row Brand-1">
                                <div class="col-md-3"><label id="formlabel2">IFSC Code<span class="Validation_error"> *</span></label></div>
                                <div class="col-md-9 Brand-name">
                                    <input type='text' name="ifsc_code" id="ifsc_code" maxlength="11" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->ifsc_code); ?>" required onchange="validate_ifsc($( '#ifsc_code').val())">
                                    <span style="color: red;" id="pincode_error"></span>
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
                                            <img id="cheque-image" class="upload-documents" src="<?php echo base_url() . 'assets/img/certificate.png'; ?>" style="border-radius:10%" />
                                        <?php endif; ?>
                                        <input type="file" name="cheque-image" id="cheque-logo" required=""  style="display: none;" value="<?php echo (!empty($this->auth_user->cheque_image_url)) ? $this->auth_user->cheque_image_url : ''; ?>" />
                                        <p id="file-upload-filename" style="margin-bottom:0;"></p>
                                        <span style="color: red;" id="cheque_error"></span>

                                        <script>
                                            $('#cheque-image').click(function() {
                                                $('#cheque-logo').click()
                                            })

                                            function cheque_image() {

                                                if (!$('#cheque-logo').val()) {
                                                    $('#cheque_error').html("Please enter cheque image.");
                                                }
                                                $('#cheque_error').html("");
                                            }
                           
                                        </script>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- </div> -->
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <button type="submit" id="account_button" onclick="cheque_image();" value="update" class="btn btn-md btn-success"><?php echo trans("save_changes"); ?></button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<div class="row-custom">
    <div class="profile-details" id="profile-for-mobile">

        <div class="col-md-4 left textcenter" style="text-align:center;">
            <div class="row-custom user-contact">
                <?php if (!empty(get_supplier_city($user))) : ?>
                    <span class="suppliercity"><i class="icon-map-marker"></i><?php echo get_supplier_city($user); ?></span>
                <?php endif; ?>
            </div>
            <img src="<?php echo get_user_logo($user); ?>" alt="<?php echo get_shop_name($user); ?>" class="img-profile">
            <div class="button-follow-followers">
                <?php if ($this->auth_check) : ?>
                    <?php if ($this->auth_user->id != $user->id) : ?>

                        <!--form follow-->
                        <?php echo form_open('follow-unfollow-user-post', ['class' => 'form-inline']); ?>
                        <input type="hidden" name="following_id" value="<?php echo $user->id; ?>">
                        <input type="hidden" name="follower_id" value="<?php echo $this->auth_user->id; ?>">
                        <?php if (is_user_follows($user->id, $this->auth_user->id)) : ?>
                            <button class="btn btn-md btn-secondary btn-custom"><i class="icon-user-minus"></i><?php echo trans("unfollow"); ?></button>
                        <?php else : ?>
                            <button class="btn btn-md btn-secondary btn-custom"><i class="icon-user-plus"></i><?php echo trans("follow"); ?></button>
                        <?php endif; ?>
                        <?php echo form_close(); ?>

                    <?php endif; ?>
                <?php else : ?>
                    <button class="btn btn-md btn-secondary btn-custom" data-toggle="modal" data-target="#loginModal"><i class="icon-user-plus"></i><?php echo trans("follow"); ?></button>
                <?php endif; ?>

                <span class="followercount"><?php echo get_followers_count($user->id); ?> Followers</span>
            </div>
        </div>




        <div class=" col-md-4 left textright" style="text-align:center;">
            <div class="row-custom row-profile-username">
                <h1 class="fullname">
                    <?php echo get_full_name($user); ?>
                </h1>
            </div>
            <?php if ($user->role == 'admin' || $user->role == 'vendor') : ?>
                <div class="row-custom">
                    <p class="supplier_type">
                        <?php if ($user_categories) :
                            $i = 0;
                            foreach ($user_categories as $cat_id => $cat_count) :
                                $category = get_category_by_id($cat_id);
                                echo ($category->name . "<br>");
                                $i++;
                                if ($i >= $this->general_settings->max_category_show)
                                    break;
                            endforeach;
                        ?>

                        <?php else : ?>
                            <?php echo html_escape($user->supplier_type); ?>
                        <?php endif; ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>


        <div class="col-md-4 left">
            <!-- <img src="<?php echo get_user_avatar($user); ?>" alt="<?php echo get_shop_name($user); ?>" class="img-profile">
            </div>
            <div class="right"> -->
            <div class="row-custom row-profile-username">
                <h1 class="username" style="text-align:center;float:none;">
                    <a href="<?php echo generate_profile_url($user->slug); ?>"> <?php echo get_brand_name($user); ?></a>
                    <?php if ($user->role == 'vendor' || $user->role == 'admin') : ?>
                        <i class="icon-verified icon-verified-member" style="float:none;"></i>
                    <?php endif; ?>
                </h1>
            </div>
            <!-- <div class="row-custom">
                <p class="p-last-seen">
                    <span class="last-seen <//?php echo (is_user_online($user->last_seen)) ? 'last-seen-online' : ''; ?>"> <i class="icon-circle"></i> <//?php echo trans("last_seen"); ?>&nbsp;<//?php echo time_ago($user->last_seen); ?></span>
                </p>
            </div> -->
            <?php if ($user->role == 'admin' || $user->role == 'vendor') : ?>
                <!-- <div class="row-custom">
                    <p class="description">
                        <? //php echo html_escape(ucfirst($user->brand_desc)); 
                        ?>
                    </p>
                </div> -->
            <?php endif; ?>

            <!-- <div class="row-custom user-contact">
                <span class="info"><?php echo trans("member_since"); ?>&nbsp;<?php echo helper_date_format($user->created_at); ?></span>
                <?php if ($user->role == "admin" || $this->general_settings->hide_vendor_contact_information != 1) :
                    if (!empty($user->phone_number) && $user->show_phone == 1) : ?>
                        <span class="info"><i class="icon-phone"></i>
                            <a href="javascript:void(0)" id="show_phone_number"><?php echo trans("show"); ?></a>
                            <a href="tel:<?php echo html_escape($user->phone_number); ?>" id="phone_number" class="display-none"><?php echo html_escape($user->phone_number); ?></a>
                        </span>
                    <?php endif; ?>
                    <?php if (!empty($user->email) && $user->show_email == 1) : ?>
                        <span class="info"><i class="icon-envelope"></i><?php echo html_escape($user->email); ?></span>
                <?php endif;
                endif; ?>
                <?php if (!empty(get_location($user)) && $user->show_location == 1) : ?>
                    <span class="info"><i class="icon-map-marker"></i><?php echo get_location($user); ?></span>
                <?php endif; ?>
            </div> -->



            <!-- <div class="row-custom profile-buttons">


                <div class="social">
                    <ul>
                        <?php if (!empty($user->facebook_url)) : ?>
                            <li><a href="<?php echo $user->facebook_url; ?>" target="_blank"><i class="icon-facebook"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->twitter_url)) : ?>
                            <li><a href="<?php echo $user->twitter_url; ?>" target="_blank"><i class="icon-twitter"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->instagram_url)) : ?>
                            <li><a href="<?php echo $user->instagram_url; ?>" target="_blank"><i class="icon-instagram"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->pinterest_url)) : ?>
                            <li><a href="<?php echo $user->pinterest_url; ?>" target="_blank"><i class="icon-pinterest"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->linkedin_url)) : ?>
                            <li><a href="<?php echo $user->linkedin_url; ?>" target="_blank"><i class="icon-linkedin"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->vk_url)) : ?>
                            <li><a href="<?php echo $user->vk_url; ?>" target="_blank"><i class="icon-vk"></i></a></li>
                        <?php endif; ?>
                        <?php if (!empty($user->youtube_url)) : ?>
                            <li><a href="<?php echo $user->youtube_url; ?>" target="_blank"><i class="icon-youtube"></i></a></li>
                        <?php endif; ?>
                        <?php if ($this->general_settings->rss_system == 1 && $user->show_rss_feeds == 1 && get_user_products_count($user->id) > 0) : ?>
                            <li><a href="<?php echo lang_base_url() . "rss/" . get_route("seller", true) . $user->slug; ?>" target="_blank"><i class="icon-rss"></i></a></li>
                        <?php endif; ?>
                    </ul>
                </div>

            </div> -->
        </div>

    </div>

</div>
<script>
    $(document).ready(function() {
        $("#bankaccount").modal('show');
        $(".close").click(function() {
            $("#bankaccount").hide();

        });
    });
</script>
<script>
    function validate_ifsc(ifsc) {
        var url = "https://ifsc.razorpay.com/" + ifsc;
        $.ajax({
            url: url,
            cache: false,
            success: function(html) {
                console.log(html)
                if (!html) {
                    $('#pincode_error').html("Please enter a valid IFSC code.");
                    console.log("invalid");
                    return false;
                } else {
                    $('input[name="bank_branch"]').val(html.BANK + ", " + html.BRANCH);
                    console.log(html.BANK + " " + html.BRANCH);
                    $("#pincode_error").html("");
                    var account_no = $("#verity_account").html();;
                    var ifsc_error = $("#pincode_error").html();;
                    if (account_no == "" && ifsc_error == "") {
                        $('#account_button').prop('disabled', false);
                    } else if (ifsc_error != "" && account_no == "") {
                        $('#account_button').prop('disabled', true);
                    } else {
                        $('#account_button').prop('disabled', true);
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
                if (errorThrown) {
                    $('#pincode_error').html("Please enter a valid IFSC code.");
                    console.log("invalid");
                    $('#account_button').prop('disabled', true);
                }
            }
        })
    }

    function checkaccountMatch() {
        var account = $("#account_number").val();
        var confirm_account = $("#confirm_account_number").val();
        if (account == confirm_account) {
            $("#verity_account").html("");
            var ifsc_error = $("#pincode_error").html();;
            var account_no = $("#verity_account").html();;
            if (ifsc_error == "" && account_no == "") {
                $('#account_button').prop('disabled', false);
            } else if (ifsc_error != "" && account_no == "") {
                $('#account_button').prop('disabled', true);
            } else {
                $('#account_button').prop('disabled', true);
            }
        } else {
            console.log("not match");
            $("#verity_account").html("Account number does not match!");
            $('#account_button').prop('disabled', true);
        }
    }

    $("#confirm_account_number").keyup(checkaccountMatch);
    //{

    // }
    $(document).ready(function() {
        $('#account_button').prop('disabled', true);
    });


    $("#confirm_account_number").keyup(function() {
        var ifsc_error = $("#pincode_error").html();;
        var account_no = $("#verity_account").html();;
        console.log(ifsc_error)
        console.log(account_no)
        if (ifsc_error == "" && account_no == "") {
            $('#account_button').prop('disabled', false);
        } else if (ifsc_error != "" && account_no == "") {
            $('#account_button').prop('disabled', true);
        } else {
            $('#account_button').prop('disabled', true);
        }
    });

    $("#ifsc_code").keyup(function() {
        var ifsc_error = $("#pincode_error").html();
        var account_no = $("#verity_account").html();
        if (ifsc_error == "" && account_no == "") {
            $('#account_button').prop('disabled', false);
        } else if (ifsc_error != "" && account_no == "") {
            $('#account_button').prop('disabled', true);
        } else {
            $('#account_button').prop('disabled', true);
        }
    });

    // function checkaccountno() {
    //     var account = $("#account_number").val();
    //     var confirm_account = $("#confirm_account_number").val();
    //     if (account == confirm_account) {
    //         $("#verity_account").html("");
    //         $('#account_button').prop('disabled', false);
    //     } else {
    //         console.log("not match");
    //         $("#verity_account").html("Account number does not match!");
    //         $('#account_button').prop('disabled', true);
    //         returnfalse;
    //     }
    // }
</script>
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