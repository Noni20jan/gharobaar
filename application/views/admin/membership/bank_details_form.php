<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $assistance_array = explode(",", $this->auth_user->assistance); ?>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/main-1.7.js"></script>
    <style>
        .extra-margin {
            margin: 0px 5px;
        }

        /* .huh #div1{
      width: 475px;
      height: 150px;
      border: 1px solid black;
      border-radius: 10px;

    
    } */
        .nxt-cancel-btns {
            text-align: center;
        }


        .nxt-cancel-styls {
            width: 100px;
            background: #185d8c;
            border-color: #185d8c;
            color: white;
        }

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
            width: 140px;
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



    <?php echo form_open("membership_controller/edit_bank_details_post"); ?>
    <div class="profile-tab-content">
        <div class="row">
            <div class="col-sm-12 m-b-30 groove">
                <label id="label1">Your Bank Details</label>
                <?php foreach ($users as $user) : ?>
                <?php endforeach; ?>
                <input type="hidden" name="id" value="<?php echo html_escape($user->id); ?>">

                <div class="form-group">
                    <div class="row Brand-1">
                        <div class="col-md-3"><label id="formlabel2">Account Holder Name<span class="Validation_error"> *</span></label></div>
                        <div class="col-md-9 Brand-name">
                            <input type='text' name="holder_name" class="form-control auth-form-input" value="<?php echo html_escape($user->acc_holder_name); ?>" required>
                        </div>
                    </div>
                    <!-- <input type="text" name="holder_name" class="form-control form-input"  placeholder="Enter Account Holder Name"  required> -->
                </div>
                <div class="form-group">
                    <div class="row Brand-1">
                        <div class="col-md-3"><label id="formlabel2">Account Number<span class="Validation_error"> *</span></label></div>
                        <div class="col-md-9 Brand-name">
                            <input type='password' name="account_number" id="account_number" class="form-control auth-form-input" value="<?php echo html_escape($user->account_number); ?>" required>
                        </div>
                    </div>
                    <div class="row Brand-1">
                        <div class="col-md-3"><label id="formlabel2">Confirm Account Number<span class="Validation_error"> *</span></label></div>
                        <div class="col-md-9 Brand-name">
                            <input type='text' name="confirm_account_number" id="confirm_account_number" class="form-control auth-form-input" value="<?php echo html_escape($user->account_number); ?>" required>
                            <span style="color: red;" id="verity_account"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row Brand-1">
                        <div class="col-md-3"><label id="formlabel2">IFSC Code<span class="Validation_error"> *</span></label></div>
                        <div class="col-md-9 Brand-name">
                            <input type='text' name="ifsc_code" id="ifsc_code" class="form-control auth-form-input" value="<?php echo html_escape($user->ifsc_code); ?>" required onchange="validate_ifsc($( '#ifsc_code').val())">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row Brand-1">
                        <div class="col-md-3"><label id="formlabel2">Bank Branch<span class="Validation_error"> *</span></label></div>
                        <div class="col-md-9 Brand-name">
                            <input type='text' name="bank_branch" id="bank_branch" class="form-control auth-form-input" value="<?php echo html_escape($user->bank_branch); ?>" required readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>



































    </div>
</div>
<div class="row buttons_edit_vendors">
    <button type="submit" name="submit" value="update" class="btn btn-lg btn-success pull-right extra-margin"><?php echo trans("save_changes") ?></button> &nbsp;&nbsp;&nbsp;

    <button type="submit" name="submit" value="0" class="btn btn-lg btn-danger  pull-right extra-margin">
        <i class="fa fa-times option-icon"></i><?php echo trans('decline'); ?>
    </button>
    <button type="submit" name="submit" value="1" class="btn btn-lg btn-warning  pull-right">
        <i class="fa fa-check option-icon"></i><?php echo trans('approve'); ?>
    </button>

    <?php echo form_close(); ?>
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