<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/main-1.7.js"></script>
    <style>
        .extra-margin {
            margin: 0px 5px;
        }

        .view_cheque_image {
            margin: 61px;
        }

        .back-link {
            color: #fff;
        }

        .back-link:hover {
            color: #fff;
        }

        #myImg {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        #myImg:hover {
            opacity: 0.7;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.9);
            /* Black w/ opacity */
        }

        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        /* Caption of Modal Image */
        #caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        /* Add Animation */
        .modal-content,
        #caption {
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @-webkit-keyframes zoom {
            from {
                -webkit-transform: scale(0)
            }

            to {
                -webkit-transform: scale(1)
            }
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }
        }

        /* The Modal (background) */


        /* .huh #div1{
      width: 475px;
      height: 150px;
      border: 1px solid black;
      border-radius: 10px;

    
    } */
    </style>
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


    <?php $this->load->view('admin/includes/_messages'); ?>
    <?php echo form_open("membership_controller/edit_bank_details_post"); ?>
    <div class="profile-tab-content">
        <div class="row">
            <div class="col-sm-12 m-b-30 groove">
                <label id="label1">Your Bank Details</label>
                <?php foreach ($user as $use) : ?>
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
                            <input type='password' name="account_number" id="account_number" class="form-control auth-form-input" minlength="9" value="<?php echo html_escape($user->account_number); ?>" required>
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
                <div class="form-group">
                    <div class="row Brand-1">
                        <div class="col-md-3"><label id="formlabel2">Cheque Image<span class="Validation_error"> *</span></label></div>
                        <div class="col-md-9 Brand-name">
                            <img id="cheque-image" class="upload-documents" src="<?php echo base_url() . 'assets/img/cheque_image.jpeg'; ?>" style="border-radius:10%" />

                            <input type="file" name="cheque-image" accept="image/*" id="cheque-logo" style="display: none;" value="<?php echo (!empty($user->cheque_image_url)) ? $user->cheque_image_url : ''; ?>" />
                            <br />
                            <small> <a href="<?php echo base_url() . $user->cheque_image_url; ?>" target="_blank" class="view_cheque_image">View Cheque Image</a></small>
                        </div>
                    </div>
                </div>
                <div id="myModal" class="modal">
                    <span class="close">&times;</span>
                    <img class="modal-content" id="img01">
                    <div id="caption"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row buttons_edit_vendors">

    <button type="submit" name="submit" value="update" class="btn btn-lg btn-success pull-right extra-margin"> <i class="fa fa-check option-icon"></i><?php echo trans('approve'); ?></button>
    <button type="submit" name="submit" value="update" class="btn btn-lg btn-danger  pull-right extra-margin">
        <a href="<?php echo admin_url() . 'bank-approve-details'; ?>" class="back-link">Back</a>
    </button>
    <!-- <button type="submit" name="submit" value="1" class="btn btn-lg btn-warning  pull-right">
        <i class="fa fa-check option-icon"></i><?php echo trans('approve'); ?>
    </button> -->

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
    $('#cheque-image').click(function() {
        $('#brand-logo').click()
    })
</script>

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
</script>
<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById("myImg");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    img.onclick = function() {
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
    }

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
</script>