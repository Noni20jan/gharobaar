<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<style>
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

<div class="row">
    <div class="col-sm-8">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= html_escape($title); ?></h3>
                </div>
            </div>
            <div class="box-body-new">
                <?php $active_tab = "swift";
                if (empty($active_tab)) {
                    $active_tab = "swift";
                }
                $show_all_tabs = false; ?>
                <!-- <ul class="nav nav-tabs nav-payout-accounts">
                    <?php if ($this->payment_settings->payout_swift_enabled) : $show_all_tabs = true; ?>
                        <li class="<?= $active_tab == 'swift' ? 'active' : ''; ?>">
                            <a data-toggle="pill" href="#tab_swift">Account Details</a>
                        </li>
                    <?php endif; ?> -->

                <!-- <?php if ($this->payment_settings->payout_paypal_enabled) : $show_all_tabs = true; ?>
                        <li class="<?= $active_tab == 'paypal' ? 'active' : ''; ?>">
                            <a data-toggle="pill" href="#tab_paypal"><?= trans("paypal"); ?></a>
                        </li>



                    <?php endif; ?> -->

                <!-- </ul> -->
                <?php $active_tab_content = 'swift'; ?>
                <!-- Tab panes -->
                <?php if ($show_all_tabs) : ?>
                    <div class="tab-content">
                        <div class="tab-pane <?php echo ($active_tab == 'paypal') ? 'active' : 'fade'; ?>" id="tab_paypal">
                            <?php if ($active_tab == "paypal") :
                                $this->load->view('dashboard/includes/_messages');
                            endif; ?>
                            <?php echo form_open('set-paypal-payout-account-post', ['id' => 'form_validate_payout_1']); ?>
                            <div class="form-group">
                                <label><?php echo trans("paypal_email_address"); ?>*</label>
                                <input type="email" name="payout_paypal_email" class="form-control form-input" value="<?php echo html_escape($user_payout->payout_paypal_email); ?>" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-success"><?php echo trans("save_changes"); ?></button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>

                        <div class="tab-pane <?php echo ($active_tab == 'iban') ? 'active' : 'fade'; ?>" id="tab_iban">
                            <?php if ($active_tab == "iban") :
                                $this->load->view('dashboard/includes/_messages');
                            endif; ?>
                            <?php echo form_open_multipart('set-iban-payout-account-post', ['id' => 'form_validate_payout_2']); ?>
                            <div class="form-group">
                                <label><?php echo trans("full_name"); ?>*</label>
                                <input type="text" name="iban_full_name" class="form-control form-input" value="<?php echo html_escape($user_payout->iban_full_name); ?>" required>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 m-b-sm-15">
                                        <label><?php echo trans("country"); ?>*</label>
                                        <select name="iban_country_id" class="form-control custom-select" required>
                                            <option value="" selected><?php echo trans("select_country"); ?></option>
                                            <?php foreach ($this->countries as $item) : ?>
                                                <option value="<?php echo $item->id; ?>" <?php echo ($user_payout->iban_country_id == $item->id) ? 'selected' : ''; ?>><?php echo html_escape($item->name); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label><?php echo trans("bank_name"); ?>*</label>
                                        <input type="text" name="iban_bank_name" class="form-control form-input" value="<?php echo html_escape($user_payout->iban_bank_name); ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?php echo trans("iban_long"); ?>(<?php echo trans("iban"); ?>)*</label>
                                <input type="text" name="iban_number" class="form-control form-input" value="<?php echo html_escape($user_payout->iban_number); ?>" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-md btn-success"><?php echo trans("save_changes"); ?></button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>

                        <div class="tab-pane <?php echo ($active_tab == 'swift') ? 'active' : 'fade'; ?>" id="tab_swift">
                            <?php if ($active_tab == "swift") :
                                $this->load->view('dashboard/includes/_messages');
                            endif; ?>
                            <!-- <? //php echo form_open('set-swift-payout-account-post', ['id' => 'form_validate_payout_3']); 
                                    ?> -->
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
                                        <div class="row Brand-1" style="margin-bottom: 3%;">
                                            <div class="col-md-3"><label id="formlabel2">Account Number<span class="Validation_error"> *</span></label></div>
                                            <div class="col-md-9 Brand-name">
                                                <input type='password' name="account_number" id="account_number" class="form-control auth-form-input" value="<?php echo html_escape($this->auth_user->account_number); ?>" minlength="9" required onkeyup="checkLength()">
                                                <span style="color: red;" id="acc_number"></span>
                                            </div>
                                        </div>
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

                                                    <?php if (!empty($this->auth_user->cheque_image_url)) : ?>
                                                        <small> <a href="<?php echo base_url() . $this->auth_user->cheque_image_url; ?>" target="_blank">View Cheque Image</a></small>
                                                    <?php endif; ?>
                                                    <span style="color: red;" id="cheque_error"></span>

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
                            </div>

                            <div class="form-group">
                                <button type="submit" id="submit" value="update" onclick="cheque_image();" class="btn btn-md btn-success"><?php echo trans("save_changes"); ?></button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>
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


    function checkaccountno() {
        var account = $("#account_number").val();
        var confirm_account = $("#confirm_account_number").val();
        if (account == confirm_account) {
            $("#verity_account").html("");
        } else {
            console.log("not match");
            $("#verity_account").html("Account number does not match!");
            return false;
        }
    }
    $(document).ready(function() {
        $("#submit").click(checkaccountno);
    });
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