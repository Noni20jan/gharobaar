<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php //var_dump($_SESSION['session_otp']);
?>
<!DOCTYPE html>
<html lang="<?php echo $this->selected_lang->short_form ?>">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/file-uploader/css/jquery.dm-uploader.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/file-uploader/css/styles.css" />

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/file-manager/file-manager.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/slick-theme.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/speech-input.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/slick.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/font-icons/css/mds-icons.min.css" />
<?php echo !empty($this->fonts->font_url) ? $this->fonts->font_url : ''; ?>
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/fselect.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main-1.7.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css" />
<?php if (!empty($this->general_settings->site_color)) : ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/colors/<?php echo $this->general_settings->site_color; ?>.min.css?v=<?php echo $this->general_settings->random_key ?>" />
<?php else : ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/colors/default.min.css?v=<?php echo $this->general_settings->random_key ?>" />
<?php endif; ?>
<style>
    #message {
        display: none;
        background: #f1f1f1;
        color: #000;
        position: relative;
        padding: 3px;
        margin-top: 5px;
    }

    .span-message-count {
        background-color: #d21f3c;
        font-size: 13px;
        font-weight: 600;
    }

    #message p {
        /* padding: 3px 5; */
        font-size: 12px;
        margin-bottom: 5px;
    }

    /* Add a green text color and a checkmark when the requirements are right */
    .valid {
        color: #d21f3c;
    }

    .valid:before {
        position: relative;
        left: -35px;
        content: "✔";
    }

    /* Add a red text color and an "x" when the requirements are wrong */
    .invalid {
        color: red;
    }

    .invalid:before {
        position: relative;
        left: -35px;
        content: "✖";
    }

    .Validation_error {
        color: red;
        font-size: 15px;
    }

    .field-icon {
        float: right;
        margin-right: 15px;
        margin-top: -26px;
        position: relative;
        z-index: 2;
        cursor: pointer;
    }

    @media only screen and (max-width: 600px) {
        .image-1 {
            width: 100%;
        }

    }

    /* .image2 img {
            width: 220px;
            height: auto;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            height: 770px;
            width: 100%;

        } */
</style>
<style>
    .clearable_search {
        background: #fff url("assets/img/cross_icon_red.svg") no-repeat right -20px center;
        border: 1px solid #999;
        padding: 3px 18px 3px 4px;
        /* Use the same right padding (18) in jQ! */
        border-radius: 3px;
        transition: background 0.4s;
    }

    .clearable_search.x {
        background-position: right 5px center;
    }

    /* (jQ) Show icon */
    .clearable_search.onX {
        cursor: pointer;
    }

    /* (jQ) hover cursor style */
    .clearable_search::-ms-clear {
        display: none;
        width: 0;
        height: 0;
    }

    /* Remove IE default X */

    .nav-main {
        margin-top: -2%;
    }

    .top_logo_adjust {
        width: 185px !important;
        height: 161px !important;
        margin-top: -8% !important;
    }

    .mobile-map a {
        color: #d21f3c;
        font-size: 22px;
        position: relative;
        top: 8px;
    }

    .mobile-map a:active {
        color: red;
        font-size: 22px;
        position: relative;
        top: 8px;
    }

    .mobile-map a .pincode_text {
        display: none;
    }

    @media(max-width:700px) {
        .top_logo_adjust {
            width: 185px !important;
            height: 80px !important;
            margin-top: -10% !important;
        }
    }


    .locate-modal {
        max-width: 430px
    }

    @media(max-width:700px) {
        .locate-modal .auth-box {
            background: #454545;
        }
    }

    #location {
        position: relative;
        left: 15px;
        top: 33px;
    }

    @media(max-width:700px) {
        #location {
            position: relative;
            left: 15px;
            top: 33px;
        }
    }

    .input-group-location {
        position: relative;
        width: 81%;
    }

    .nav-item .li-main-nav-right {
        padding-right: 19px;
    }

    .nav .align-items-center .li a {
        padding: 10px;
        display: block;

    }

    .locate-modal-description {
        margin-bottom: 20px;
        color: #999;
        font-size: 13px;
        text-align: center;
    }

    .display-mobile {
        text-align: center;
        padding-top: 4%;
    }


    @media(max-width:800px) {
        .locate-modal-description {
            margin-bottom: 17px;
            color: #fff;
            visibility: visible;
            font-size: 12px;



        }
    }

    .login-modal .locate-modal {
        max-width: 392px;
    }

    .check_pincode {
        position: relative;
        border-radius: 28px;
        background-color: #d21f3c;
        color: #fff;
        padding: 15px;
        border: none;
        bottom: 5px;
        font-weight: bold;
        float: right;
        left: 4px;
    }

    @media(max-width:700px) {
        .check_pincode {
            position: relative;
            border-radius: 28px;
            background-color: #d21f3c;
            color: #fff;
            padding: 15px;
            border: none;
            bottom: 7px;
            float: right;
            font-weight: bold;
            left: 0px;
        }
    }

    #close_open {
        position: relative;
        top: 11px;
    }

    .OtpSendMsg {
        margin-bottom: 10px;
        text-align: center;
        color: #d21f3c;
    }

    .enter_p::placeholder {

        /* Firefox, Chrome, Opera */
        text-align: center;
    }

    .enter_p {
        text-align: center;

    }

    .clearable {
        position: relative;
        display: inline-block;
    }

    .clearable input[type=text] {
        padding-right: 24px;
        width: 100%;
        box-sizing: border-box;
    }

    .clearable__clear {
        display: none;
        position: absolute;
        bottom: 45px;
        left: 537px;

        padding: 0 8px;
        font-style: normal;
        font-size: 1.2em;
        user-select: none;
        cursor: pointer;
    }

    .clearable input::-ms-clear {
        /* Remove IE default X */
        display: none;
    }

    #show_time:hover,
    #show_time:focus {
        color: #fff;
        text-decoration: none;
        cursor: pointer;
    }

    #show_tim {
        color: #d21f3c;
        font-size: 22px;
        position: relative;
        top: 8px;
    }

    #header-login {
        background-color: #555;
        border-color: #222222;
        color: #fff;
        padding: 0.40rem 0.9rem;
        text-align: center;
        display: inline-block;
        border-radius: 20px;
        font-weight: bolder;
        position: relative;
        top: 1px;
    }

    @media (max-width: 1066px) {
        #header-login {
            background-color: #555;
            border-color: #222222;
            color: #fff;
            padding: 0.35rem 0.43rem;
            text-align: center;
            display: inline-block;
            border-radius: 20px;
            font-weight: bolder;
            position: relative;
            top: 1px;
        }
    }

    .top-search-bar .input-search {
        background-color: #f6f6f6;
        border: 1px solid #f0f0f0 !important;
        border-left: 0;
        box-shadow: none !important;
        outline: none !important;
        color: #555;
        padding: 8px;
        padding-right: 40px;
        padding-left: 15px;
        margin-bottom: 6%;
        box-shadow: none;
        border-radius: 20px;
        font-size: 0.8125rem;
        line-height: 21px;
        /* min-height: 37px; */
        width: 610px;
    }

    @media (max-width: 1300px) {
        .top-search-bar .input-search {
            background-color: #f6f6f6;
            border: 1px solid #f0f0f0 !important;
            border-left: 0;
            box-shadow: none !important;
            outline: none !important;
            color: #555;
            padding: 8px;
            /* padding-right: 4px;  */
            /* padding-left: 15px;  */
            margin-bottom: 6%;
            box-shadow: none;
            border-radius: 20px;
            font-size: 0.8125rem;
            line-height: 21px;
            /* min-height: 37px;  */
            width: 420px;
        }
    }

    #loggedinModal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 120px;
        width: 100%;
        height: 100%;
        overflow: hidden;
        opacity: 1;
        -webkit-transition: all 0.3s;
        transition: all 0.3s;
        transition-delay: 2s;


    }

    #myModal1 {
        position: fixed;
        top: 61px;
        /* z-index: 1; */
        /* top: 0px; */
        /* left: 4px; */
        /* top: 75px; */
        width: 100%;
        overflow: hidden;

    }

    .map-icon {
        color: #d21f3c;
        font-size: 22px;
    }


    /* Modal Content */
    .modal_content {
        background-color: #fff;
        margin: auto;
        padding: 20px;
        /* border: 1px solid #888; */
        width: 49%;


        border-radius: 10px;
    }

    @media(max-width:1024px) {
        .modal_content {

            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            /* border: 1px solid #888; */
            width: 61%;
            background: #fefefeba;
            backdrop-filter: blur(20px);
            box-shadow: 2px 2px 5px #808080de;
            border-radius: 10px;
        }
    }

    .mobile_content {
        background-color: #454545;
        margin: auto;
        padding: 20px;
        width: 90%;
        height: 12%;
        /* border: 1px solid #888; */
        position: absolute;
        box-shadow: 2px 2px 5px #808080de;
        border-radius: 10px;
    }

    #close-pin {
        position: absolute;
        top: 15px;
        right: 15px;
        color: #000;
    }

    @media(max-width:700px) {
        #close-pin {
            position: absolute;
            top: 15px;
            right: 15px;
            color: #fff;
        }
    }

    #close-pin:hover,
    #close-pin:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    @media(max-width:700px) {

        #close-pin:hover,
        #close-pin:focus {
            color: #fff;
            text-decoration: none;
            cursor: pointer;
        }
    }

    .close_pin {
        float: right;
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 0;
        color: #fff;
        text-shadow: 0 1px 0 #fff;
        opacity: 0.5;
    }

    .close_pin:hover,
    .close_pin:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    #enter_pin {
        position: relative;
        width: 68%;

        bottom: 40px;
        left: 328px;
    }

    .enter_p {
        padding: 23px;
        position: relative;
        bottom: 4px;
        left: 0px;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    #check_pin {
        position: relative;
        background-color: #d21f3c;
        padding: 14px;
        color: #fff;
        border: none;
        border-radius: 20px;
        bottom: 38px;
        top: 51%;
        font-weight: bold;
        left: 231px;
    }

    /* The Close Button */
    #check_available {
        color: #000;
        position: relative;
        top: 4px;
        right: 10px;
        font-weight: bold;
    }

    .field-icon {
        float: right;
        margin-right: 8px;
        margin-top: -23px;
        position: relative;
        z-index: 2;
        cursor: pointer;
    }

    #mobile_otp {
        width: 40% !important;
        max-width: 40% !important
    }

    @media(max-width:768px) {
        #mobile_otp {
            max-width: 100% !important;
            width: 100% !important;
        }
    }

    #terms-of-use {

        height: 620px;

        overflow-y: scroll;
        border-radius: 0px;
        background-color: white;
        margin: auto;
    }

    .register_color {
        color: blue !important;
    }


    .sticky {
        position: fixed !important;
        top: 0;
        width: 100%;
        -webkit-transform: translateZ(0);
    }

    @media(max-width:700px) {
        .sticky {
            position: fixed !important;
            top: 0;
            width: 100%;
            -webkit-transform: translateZ(0);
            /* overflow: hidden; */
        }
    }

    .caFLbO {
        bottom: 50px !important;
    }

    .notification-count {
        background: red !important;
        position: absolute;
        top: 0;
        border-radius: 20px;
    }

    .notification-button {
        background: #d21f3c;
        border-color: #d21f3c;
        padding: 6px;
        border-radius: 20px;
        color: white;
        font-size: 19px;
    }

    /* width */
    .dropdown-content::-webkit-scrollbar {
        width: 4px;
    }

    .dropdown-content {
        scrollbar-color: #fff0 #fff0;
    }

    /* .mustang img {
        width: 220px;
        height: auto;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        height: 400px;
        width: 100%;

    }



    @media (min-width: 1200px) {
        .modal-medium {
            width: 780px !important;
            max-width: 100% !important;
        }
    }

    @media (min-width: 992px) {

        .modal-medium {
            max-width: 800px
        }
    } */

    /* .auth-box {

        backdrop-filter: blur(10px);
    } */
</style>

<head>
    <!-- onesignal  -->
    <!-- <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
                appId: "0f961239-ad32-4be1-9911-4d8d500728c7",
                safari_web_id: "web.onesignal.auto.5a2165c8-9d94-4308-bfd9-99a8484077b6",
                notifyButton: {
                    enable: true,
                },
                allowLocalhostAsSecureOrigin: true,
            });
        });
    </script> -->

    <!-- onesignal end -->







    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo xss_clean($title); ?> - <?php echo xss_clean($this->settings->site_title); ?></title>
    <meta name="google-site-verification" content="ylZCFiu4192QkhZzF1w0qhJz5laFNzKWncrEenc6YA8" />
    <meta name="description" content="<?php echo xss_clean($description); ?>" />
    <meta name="keywords" content="<?php echo xss_clean($keywords); ?>" />
    <meta name="author" content="Codingest" />

    <link rel="shortcut icon" href="<?php echo get_favicon($this->general_settings); ?>" />

    <script src="<?php base_url(); ?>assets/js/header.min.js"></script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=202708615038039&ev=PageView&noscript=1" /></noscript>

    <meta property="og:locale" content="en-US" />
    <meta property="og:site_name" content="<?php echo xss_clean($this->general_settings->application_name); ?>" />
    <?php if (isset($show_og_tags)) : ?>
        <meta property="og:type" content="<?php echo $og_type; ?>" />
        <meta property="og:title" content="<?php echo $og_title; ?>" />
        <meta property="og:description" content="<?php echo $og_description; ?>" />
        <meta property="og:url" content="<?php echo $og_url; ?>" />
        <meta property="og:image" content="<?php echo $og_image; ?>" />
        <meta property="og:image:width" content="<?php echo $og_width; ?>" />
        <meta property="og:image:height" content="<?php echo $og_height; ?>" />
        <meta property="article:author" content="<?php echo $og_author; ?>" />
        <meta property="fb:app_id" content="<?php echo $this->general_settings->facebook_app_id; ?>" />
        <?php if (!empty($og_tags)) : foreach ($og_tags as $tag) : ?>
                <meta property="article:tag" content="<?php echo $tag->tag; ?>" />
        <?php endforeach;
        endif; ?>
        <meta property="article:published_time" content="<?php echo $og_published_time; ?>" />
        <meta property="article:modified_time" content="<?php echo $og_modified_time; ?>" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@<?php echo xss_clean($this->general_settings->application_name); ?>" />
        <meta name="twitter:creator" content="@<?php echo xss_clean($og_creator); ?>" />
        <meta name="twitter:title" content="<?php echo xss_clean($og_title); ?>" />
        <meta name="twitter:description" content="<?php echo xss_clean($og_description); ?>" />
        <meta name="twitter:image" content="<?php echo $og_image; ?>" />
    <?php else : ?>
        <meta property="og:image" content="<?php echo get_logo($this->general_settings); ?>" />
        <meta property="og:image:width" content="160" />
        <meta property="og:image:height" content="60" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="<?php echo xss_clean($title); ?> - <?php echo xss_clean($this->settings->site_title); ?>" />
        <meta property="og:description" content="<?php echo xss_clean($description); ?>" />
        <meta property="og:url" content="<?php echo base_url(); ?>" />
        <meta property="fb:app_id" content="<?php echo $this->general_settings->facebook_app_id; ?>" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@<?php echo xss_clean($this->general_settings->application_name); ?>" />
        <meta name="twitter:title" content="<?php echo xss_clean($title); ?> - <?php echo xss_clean($this->settings->site_title); ?>" />
        <meta name="twitter:description" content="<?php echo xss_clean($description); ?>" />
    <?php endif; ?>
    <?php if ($this->general_settings->pwa_status == 1) : ?>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="<?= xss_clean($this->general_settings->application_name); ?>">
        <meta name="msapplication-TileImage" content="<?= base_url(); ?>assets/img/pwa/144x144.png">
        <meta name="msapplication-TileColor" content="#2F3BA2">
        <link rel="manifest" href="<?= base_url(); ?>manifest.json">
        <link rel="apple-touch-icon" href="<?= base_url(); ?>assets/img/pwa/144x144.png">
    <?php endif; ?>
    <link rel="canonical" href="<?php echo current_url(); ?>" />
    <?php if ($this->general_settings->multilingual_system == 1) :
        foreach ($this->languages as $language) :
            if ($language->id == $this->site_lang->id) : ?>
                <link rel="alternate" href="<?php echo base_url(); ?>" hreflang="<?php echo $language->language_code ?>" />
            <?php else : ?>
                <link rel="alternate" href="<?php echo base_url() . $language->short_form . "/"; ?>" hreflang="<?php echo $language->language_code ?>" />
    <?php endif;
        endforeach;
    endif; ?>

    <?php $this->load->view("partials/_css_header"); ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
     
    
    <![endif]-->
    <?php echo $this->general_settings->google_adsense_code; ?>
    <style>
        .switch-field {
            display: flex;
            margin-bottom: 36px;
            overflow: hidden;
            border-radius: 25px 0 0 25px;
        }

        .switch-field input {
            position: absolute !important;
            clip: rect(0, 0, 0, 0);
            height: 1px;
            width: 1px;
            border: 0;
            overflow: hidden;
        }

        .switch-field label {
            background-color: #f6f6f6;
            color: rgba(0, 0, 0, 0.6);
            font-size: 14px;
            min-height: 37px;
            text-align: center;
            padding: 8px 16px;
            margin-right: -1px;

            transition: all 0.1s ease-in-out;
        }

        .switch-field label:hover {
            cursor: pointer;
        }

        .switch-field input:checked+label {
            width: 110px;

            box-shadow: none;
            min-height: 37px;
        }

        .switch-field label:first-of-type {
            border-radius: 4px 0 0 4px;
        }

        .switch-field label:last-of-type {
            border-radius: 0 4px 4px 0;
        }

        /* This is just for CodePen. */




        .sticky {
            position: fixed;
            top: 0;
            width: 100%;
        }

        .top_logo_margin {
            margin-top: 3% !important;
        }

        .top_logo_adjust {
            width: 185px !important;
            height: 161px !important;
            margin-top: -8% !important;
        }

        @media(max-width:1024px) {
            .top_logo_adjust {
                width: 185px !important;
                height: 80px !important;
                margin-top: -9% !important;
            }
        }

        .padding_1 {
            padding: 0px !important;
        }

        .logo_size {
            max-width: 186px !important;
            max-height: 80px !important;
            /* margin-top: -9% !important; */
        }

        .icon-bg {
            background-color: #d21f3c;
            border-radius: 50%;
            color: white;
            font-size: 15px;
            line-height: 0px;
        }

        .promo-bar-offset {
            top: 40px;
        }

        #announcement-bar {
            width: 100%;
            position: relative;
            display: block;
            height: 45px;
        }

        @media(max-width:768px) {
            #announcement-bar {
                width: 100%;
                position: relative;
                display: none;
                height: 53px;
            }
        }

        #announcement-mobile-bar {
            width: 100%;
            position: relative;
            display: none;
            height: 53px;
        }

        @media(max-width:768px) {
            #announcement-mobile-bar {
                width: 100%;
                position: relative;
                display: block;
                height: 43px;
            }
        }

        .animationbar {

            position: relative;
            animation-name: example;
            animation-duration: 2s;
            animation-delay: 2s;
            margin: 15px;
            animation-iteration-count: infinite;
        }

        .animation-mobile-bar {

            position: relative;
            animation-name: example;
            animation-duration: 2s;
            animation-delay: 2s;
            margin: -10px;
            animation-iteration-count: infinite;
        }



        .sliding_content {
            display: flow-root;
            text-align: center;
            background-color: #d21f3c;
            font-weight: normal;
            font-style: normal;
            font-family: "Montserrat", Helvetica, sans-serif;
            color: #fff;
        }



        @media screen and (max-width:768px) {
            .sticky-header {
                top: 40px;
            }

            .promo-content-wrapper,
            .promo-bar {
                opacity: 1;
            }
        }
    </style>
    <!-- <script src="<?= base_url(); ?>assets/js/fselect.js"></script> -->
    <style>
        /* @import 'https://fonts.googleapis.com/css?family=Open+Sans'; */

        /* body {
            margin: 0;
            padding: 0;
            font-family: "Open Sans", sans-serif;
        }

        .content {
            padding: 15px;
            margin-top: 60px;
            color: #333;
        } */

        .navigation {
            position: fixed;
            top: 0;
            width: 100%;
            height: 60px;
            background: #3f51b5;
        }

        .navigation .inner-navigation {
            padding: 0;
            margin: 0;
        }

        .navigation .inner-navigation li {
            list-style-type: none;
        }

        .navigation .inner-navigation li .menu-link {
            color: #ff5252;
            line-height: 3.7em;
            padding: 20px 18px;
            text-decoration: none;
            transition: background 0.5s, color 0.5s;
        }

        .navigation .inner-navigation li .menu-link.menu-anchor {
            padding: 20px;
            margin: 0;
            background: #ff5252;
            color: #FFF;
        }

        .navigation .inner-navigation li .menu-link.has-notifications {
            background: #ff5252;
            color: #FFF;
        }

        .navigation .inner-navigation li .menu-link.circle {
            line-height: 3.8em;
            padding: 14px 18px;
            border-radius: 50%;
        }

        .navigation .inner-navigation li .menu-link.circle:hover {
            background: #ff5252;
            color: #FFF;
        }

        .navigation .inner-navigation li .menu-link.square:hover {
            background: #ff5252;
            color: #FFF;
            transition: background 0.5s, color 0.5s;
        }

        .dropdown-container {
            overflow-y: hidden;
        }

        .dropdown-container.expanded .dropdown {
            -webkit-animation: fadein 0.5s;
            -moz-animation: fadein 0.5s;
            -ms-animation: fadein 0.5s;
            -o-animation: fadein 0.5s;
            animation: fadein 0.5s;
            display: block;
        }

        .dropdown-container .dropdown {
            -webkit-animation: fadeout 0.5s;
            -moz-animation: fadeout 0.5s;
            -ms-animation: fadeout 0.5s;
            -o-animation: fadeout 0.5s;
            animation: fadeout 0.5s;
            display: none;
            position: absolute;
            width: 300px;
            height: auto;
            max-height: 600px;
            overflow-y: hidden;
            padding: 0;
            margin: 0;
            background: #fff;
            margin-top: 3px;
            /* margin-right: -15px; */
            border-top: 4px solid #fff;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
            -webkit-box-shadow: 2px 2px 15px -5px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 2px 2px 15px -5px rgba(0, 0, 0, 0.75);
            box-shadow: 2px 2px 15px -5px rgba(0, 0, 0, 0.75);
            /*
            &:before{
                position: absolute;
                content: ' ';
                width: 0; 
                height: 0; 
                top: -13px;
                right: 7px;
                border-left: 8px solid transparent;
                border-right: 8px solid transparent;
                border-bottom: 10px solid $secondary-color; 
            }
            */
        }

        .dropdown-container .dropdown .notification-group {
            border-bottom: 1px solid #e3e3e3;
            overflow: hidden;
            /* min-height: 65px; */
        }

        .dropdown-container .dropdown .notification-group:last-child {
            border-bottom: 0;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        .dropdown-container .dropdown .notification-group .notification-tab {
            padding: 14px 25px;
            /* min-height: 65px; */
        }

        .dropdown-container .dropdown .notification-group .notification-tab:hover {
            cursor: pointer;
            background: #f1f1f1;
        }

        .dropdown-container .dropdown .notification-group .notification-tab:hover .fa,
        .dropdown-container .dropdown .notification-group .notification-tab:hover p,
        .dropdown-container .dropdown .notification-group .notification-tab:hover {
            color: #606060 !important;
            /* display: inline-block; */
        }

        .dropdown-container .dropdown .notification-group .notification-tab:hover {
            background: #f1f1f1;
            border-color: #f1f1f1;
        }

        .dropdown-container .dropdown .notification-group .notification-list {
            padding: 0;
            overflow-y: auto;
            height: 0px;
            max-height: 250px;
            transition: height 0.5s;
        }


        .dropdown-container .dropdown .notification-group .notification-list .notification-list-item {
            padding: 5px 25px;
            border-bottom: 1px solid #e3e3e3;
        }

        .dropdown-container .dropdown .notification-group .notification-list .notification-list-item .message {
            margin: 5px 5px 10px;
            color: gray;
        }

        .dropdown-container .dropdown .notification-group .notification-list .notification-list-item .item-footer a {
            color: #3f51b5;
            text-decoration: none;
        }

        .dropdown-container .dropdown .notification-group .notification-list .notification-list-item .item-footer .date {
            float: right;
        }

        .dropdown-container .dropdown .notification-group .notification-list .notification-list-item:nth-of-type(odd) {
            background: #e3e3e3;
        }

        /* .dropdown-container .dropdown .notification-group .notification-list .notification-list-item:hover {
            cursor: pointer;
        } */

        .dropdown-container .dropdown .notification-group .notification-list .notification-list-item:last-child {
            border-bottom: 0;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
            line-height: 30px;
        }

        .dropdown-container .dropdown .notification-group.expanded .notification-tab {
            background: #e3e3e3;
        }

        .dropdown-container .dropdown .notification-group.expanded .notification-tab .fa,
        .dropdown-container .dropdown .notification-group.expanded .notification-tab h4,
        .dropdown-container .dropdown .notification-group.expanded .notification-tab {
            color: #FFF;
            /* display: inline-block; */
        }

        .dropdown-container .dropdown .notification-group.expanded .notification-tab {
            background: #f1f1f1;
            border-color: #f1f1f1;
        }

        .dropdown-container .dropdown .notification-group.expanded .notification-list {
            height: 250px;
            max-height: 100px;
            transition: height 0.5s;
        }

        .dropdown-container .dropdown .notification-group .fa,
        .dropdown-container .dropdown .notification-group h4,
        .dropdown-container .dropdown .notification-group .label {
            color: #333;
            /* display: inline-block; */
        }

        .dropdown-container .dropdown .notification-group .fa {
            margin-right: 5px;
            margin-top: 25px;
        }

        .dropdown-container .dropdown .notification-group .label {
            float: right;
            margin-top: 20px;
            color: #3f51b5;
            border: 1px solid #3f51b5;
            padding: 0px 7px;
            border-radius: 15px;
        }

        .right {
            float: right;
        }

        .left {
            float: left;
        }

        .notification-head {
            color: #606060 !important;
            margin: 0px 0px 0px;
            padding: 7px 0px 10px 0px;
        }

        .head-notification-count {
            color: gray;
            position: absolute;
            right: 12px;
            /* top: 21px; */
        }

        /* @media only screen and (max-width: 321px) {
                .dropdown-container .dropdown .notification-group .notification-tab h4 {
                    display: none;
                }

                .dropdown-container .dropdown .notification-group .notification-tab:hover h4 {
                    display: none;
                }

                .dropdown-container .dropdown .notification-group.expanded .notification-tab h4 {
                    display: none;
                }
            }

            @media only screen and (max-width: 514px) {
                .dropdown-container .dropdown {
                    width: 100%;
                    margin: 0px;
                    left: 0;
                }
            } */

        /* 
        @keyframes fadein {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @-moz-keyframes fadein {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @-webkit-keyframes fadein {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @-ms-keyframes fadein {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @-o-keyframes fadein {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeout {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        @-moz-keyframes fadeout {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        @-webkit-keyframes fadeout {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        @-ms-keyframes fadeout {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        @-o-keyframes fadeout {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        } */
    </style>
</head>
<div id="tittletoggle"></div>

<body>
    <?php get_method();
    $path_url = $this->input->get('url', true);
    ?>
    <input type="hidden" id="redirect_url" value="<?php echo $path_url; ?>">
    <?php if ($this->general_settings->enable_freeship_message == 1) : ?>
        <div id="announcement-bar">
            <article class="sliding_content" aria-labelledby="promo_bar_label" data-section-id="announcement-bar" data-block-count="1" data-speed="4000" data-autoplay="4000" data-slider="false" data-section-type="announcement" data-language="false" data-currency="false">

                <div class="animationbar">
                    <marquee behaviour="scroll" direction="right">
                        <p class="display"><strong><?php echo trans("free_ship_message"); ?> </strong></p>
                    </marquee>
                </div>
            </article>
        </div>
    <?php endif; ?>
    <header id="header">
        <?php //$this->load->view("partials/_top_bar"); 
        ?>
        <div class="main-menu" id="myHeader">
            <div class="container-fluid">
                <div class="row">

                    <div class="padding_1 nav-top">
                        <div class="container">
                            <div class="row align-items-center">

                                <div class="top_logo_margin col-md-7 nav-top-left">
                                    <div class="row-align-items-center">
                                        <div class="top_logo_adjust logo">
                                            <a href="<?php echo lang_base_url(); ?>"><img src="<?php echo get_logo($this->general_settings); ?>" alt="logo" class="logo_size"></a>
                                        </div>
                                        <div class="top-search-bar<?= $this->general_settings->multi_vendor_system != 1 ? ' top-search-bar-single-vendor' : ''; ?>">
                                            <?php echo form_open(generate_url('search'), ['id' => 'form_validate_search', 'class' => 'form_search_main', 'method' => 'get']); ?>
                                            <?php if ($this->general_settings->multi_vendor_system == 1) : ?>
                                                <!-- <div class="left">
                                                    <div class="dropdown search-select">
                                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                                            <?php if (isset($search_type)) : ?>
                                                                <?php echo trans("supplier"); ?>
                                                            <?php else : ?>
                                                                <?php echo trans("product"); ?>
                                                            <?php endif; ?>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                        <div class="switch-field ">
                                                            <a data-value="product" href="javascript:void(0)"><input type="radio" id="radio-one" name="switch-one" value="yes" checked />
                                                                <label for="radio-one"></label></a>
                                                            <a data-value="member" href="javascript:void(0)"><input type="radio" id="radio-two" name="switch-one" value="no" />
                                                                <label for="radio-two"><?php echo trans("supplier"); ?></label></a>
                                                        </div>
                                                        <a class="dropdown-item" data-value="product" href="javascript:void(0)"><?php echo trans("product"); ?></a>
                                                        <a class="dropdown-item" data-value="member" href="javascript:void(0)"><?php echo trans("supplier"); ?></a>
                                                        </div>
                                                    </div>
                                                    <?php if (isset($search_type)) : ?>
                                                        <input type="hidden" class="search_type_input" name="search_type" value="member">
                                                    <?php else : ?>
                                                        <input type="hidden" class="search_type_input" name="search_type" value="product">
                                                    <?php endif; ?>
                                                </div> -->
                                                <div class="right">
                                                    <div class="pincode" style="text-align:center;font-weight:bold;">
                                                        <?php if (!empty($_SESSION["modesy_sess_user_location"])) : ?>
                                                            Showing results for products deliverable at pincode <?php echo $_SESSION["modesy_sess_user_location"]; ?>
                                                        <?php endif; ?>
                                                        <?php if (empty($_SESSION["modesy_sess_user_location"])) : ?>
                                                            <input type="hidden" id="show_pincode_modal" value="">
                                                        <?php endif; ?>
                                                    </div>
                                                    <div>
                                                        <input type="text" name="search" maxlength="300" pattern=".*\S+.*" id="input_search" class="form-control input-search speech-input" value="<?php echo (!empty($filter_search)) ? $filter_search : ''; ?>" placeholder="<?php echo trans("search_exp"); ?>" required onchange="search_input();" autocomplete="off">
                                                        <input type="hidden" class="search_type_input " name="search_type" value="product">
                                                        <button class="btn btn-default btn-search" style="<?php echo (!empty($_SESSION["modesy_sess_user_location"])) ? 'top:17px' : '';  ?> margin-left:10px;"><i class="icon-search"></i></button>
                                                        <div id="response_search_results" class="search-results-ajax"></div>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <input type="text" name="search" maxlength="300" pattern=".*\S+.*" id="input_search" class="form-control input-search speech-input" value="<?php echo (!empty($filter_search)) ? $filter_search : ''; ?>" placeholder="<?php echo trans("search_products"); ?>" required onchange="search_input();" autocomplete="off">
                                                <input type="hidden" class="search_type_input" name="search_type" value="product">
                                                <button class="btn btn-default btn-search"><i class="icon-search"></i></button>
                                                <div id="response_search_results" class="search-results-ajax"></div>
                                            <?php endif; ?>
                                            <?php echo form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5 nav-top-right">
                                    <ul class="nav align-items-center" style="flex-wrap:nowrap; justify-content:space-evenly; float:none !important;">
                                        <?php if (!empty($_SESSION["modesy_sess_user_location"])) : ?>
                                            <li class="icon-bg" style="background-color:red;">
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#locateModal" class="nav-link btn-modal-location">
                                                    <i class="icon-map-marker"></i></a>
                                            </li>
                                        <?php else : ?>
                                            <li class="icon-bg">
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#locateModal" class="nav-link btn-modal-location">
                                                    <i class="icon-map-marker"></i></a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($this->auth_check) : ?>
                                            <?php if (is_multi_vendor_active()) : ?>
                                                <?php if (!is_user_vendor()) : ?>
                                                    <?php if (!is_user_applied_for_shop()) : ?>
                                                        <li><a href="<?php echo generate_url("why_sell_with_us"); ?>" class="btn btn-md btn-custom btn-sell-now m-r-0" style="margin:0px;"><?= trans("sell_now"); ?></a></li>
                                                    <?php else : ?>
                                                        <li><a href="<?php echo generate_url("start-selling"); ?>" class="btn btn-md btn-custom btn-sell-now m-r-0" style="margin:0px;"><?= trans("sell_now"); ?></a></li>
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    <?php if ($this->auth_user->supplier_type == "Goods") { ?>
                                                        <li><a href="<?php echo generate_dash_url("add_product"); ?>" class="btn btn-md btn-custom btn-sell-now m-r-0" style="margin:0px;"><?= trans("sell_now"); ?></a></li>
                                                    <?php } else { ?>
                                                        <li><a href="<?php echo generate_dash_url("add_service"); ?>" class="btn btn-md btn-custom btn-sell-now m-r-0" style="margin:0px;"><?= trans("sell_now"); ?></a></li>
                                                    <?php } ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <?php if (is_multi_vendor_active()) : ?>
                                                <li><a href="<?php echo generate_url("why_sell_with_us"); ?>" class="btn btn-md btn-custom btn-sell-now m-r-0" style="margin:0px;"><?= trans("sell_now"); ?></a></li>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if ($this->is_sale_active) : ?>
                                            <li class="icon-bg cart-icon-number">
                                                <a class="cart_a" href="<?php echo generate_url("cart"); ?>">
                                                    <i class="icon-cart"></i>
                                                    <?php $cart_product_count = get_cart_product_count();
                                                    if ($cart_product_count > 0) : ?>
                                                        <span class="notification"><?php echo $cart_product_count; ?></span>
                                                    <?php endif; ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($this->auth_check) : ?>
                                            <?php if ($this->auth_user->user_type != "guest") : ?>
                                                <li class="icon-bg">
                                                    <a href="<?php echo generate_url("wishlist") . "/" . $this->auth_user->slug; ?>">
                                                        <i class="icon-heart-o"></i>
                                                    </a>
                                                </li>
                                            <?php else : ?>
                                                <!-- hide wishlist for guest user -->
                                                <li class="icon-bg">
                                                    <a href="javascript:void(0)" data-toggle="modal" data-id="0" data-target="#registerModal">
                                                        <!-- <a href="<?php echo generate_url("wishlist") . "/" . $this->auth_user->slug; ?>"> -->
                                                        <i class="icon-heart-o"></i>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <li class="icon-bg">
                                                <a id='wishlist'>
                                                    <i class="icon-heart-o"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($this->auth_check) : ?>
                                            <li class="icon-bg">
                                                <!--span class="notification-label"></span-->
                                                <div class="dropdown-container">
                                                    <a href="#" data-dropdown="notificationMenu" class="menu-link has-notifications circle">
                                                        <i class="far fa-bell notification-button"></i>
                                                    </a>
                                                    <ul class="dropdown" name="notificationMenu" style="z-index:100;">
                                                        <li class="notification-group">
                                                            <div class="notification-tab">
                                                                <!-- <i class="fa fa-flag"></i> -->
                                                                <p class="notification-head">Gharobaar Updates</p>
                                                                <?php $gharobaar_updates = $this->notification_model->get_gharobaar_updates($this->auth_user->email); ?>
                                                                <label class="head-notification-count"><?php echo count($gharobaar_updates); ?></label>
                                                            </div>
                                                            <!-- tab -->

                                                            <ul class="notification-list">
                                                                <?php foreach ($gharobaar_updates as $gharobaar_update) : ?>
                                                                    <li class="notification-list-item" style="line-height:25px;">
                                                                        <p class="message"><?php echo $gharobaar_update->remark; ?></p>
                                                                        <div class="item-footer" style="color:gray;">
                                                                            <span class="from"><?php echo $gharobaar_update->title; ?></span>
                                                                            <span class="date"><?php echo $gharobaar_update->created_at; ?></span>
                                                                        </div>
                                                                    </li>
                                                                <?php endforeach; ?>

                                                            </ul>
                                                        </li>
                                                        <li class="notification-group">
                                                            <div class="notification-tab">
                                                                <!-- <i class="fa fa-bug"></i> -->
                                                                <p class="notification-head">Order Placement</p>
                                                                <?php $order_placements = $this->notification_model->get_order_placement($this->auth_user->email); ?>
                                                                <label class="head-notification-count"><?php echo count($order_placements); ?></label>
                                                            </div> <!-- tab -->

                                                            <ul class="notification-list">
                                                                <?php foreach ($order_placements as $order_placement) : ?>
                                                                    <li class="notification-list-item" style="line-height:25px;">
                                                                        <p class="message"><?php echo $order_placement->remark; ?></p>
                                                                        <div class="item-footer" style="color:gray;">
                                                                            <span class="from"><?php echo $order_placement->title; ?></span>
                                                                            <span class="date"><?php echo $order_placement->created_at; ?></span>
                                                                        </div>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                            <!-- list -->
                                                        </li>
                                                        <li class="notification-group">
                                                            <div class="notification-tab">
                                                                <!-- <i class="fa fa-envelope"></i> -->
                                                                <p class="notification-head">Order Update</p>
                                                                <?php $order_updates = $this->notification_model->get_order_update($this->auth_user->email); ?>
                                                                <label class="head-notification-count"><?php echo count($order_updates); ?></label>
                                                            </div>

                                                            <ul class="notification-list">
                                                                <?php foreach ($order_updates as $order_update) : ?>
                                                                    <li class="notification-list-item" style="line-height:25px;">
                                                                        <p class="message"><?php echo $order_update->remark; ?></p>
                                                                        <div class="item-footer" style="color:gray;">
                                                                            <span class="from"><?php echo $order_update->title; ?></span>
                                                                            <span class="date"><?php echo $order_update->created_at; ?></span>
                                                                        </div>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </li>
                                                        <li class="notification-group">
                                                            <div class="notification-tab">
                                                                <!-- <i class="fa fa-calendar"></i> -->
                                                                <p class="notification-head">Order Cancellation by Seller</p>
                                                                <?php $order_cancellation_seller_updates = $this->notification_model->get_order_cancellation_by_seller($this->auth_user->email); ?>
                                                                <label class="head-notification-count"><?php echo count($order_cancellation_seller_updates); ?></label>
                                                            </div>

                                                            <ul class="notification-list">
                                                                <?php foreach ($order_cancellation_seller_updates as $order_cancellation_seller_update) : ?>
                                                                    <li class="notification-list-item" style="line-height:25px;">
                                                                        <p class="message"><?php echo $order_cancellation_seller_update->remark; ?></p>
                                                                        <div class="item-footer" style="color:gray;">
                                                                            <span class="from"><?php echo $order_cancellation_seller_update->title; ?></span>
                                                                            <span class="date"><?php echo $order_cancellation_seller_update->created_at; ?></span>
                                                                        </div>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </li>
                                                        <li class="notification-group">
                                                            <div class="notification-tab">
                                                                <!-- <i class="fa fa-trophy"></i> -->
                                                                <p class="notification-head">Order Delivered</p>
                                                                <?php $order_delivered_updates = $this->notification_model->get_order_delivered($this->auth_user->email); ?>
                                                                <label class="head-notification-count"><?php echo count($order_delivered_updates); ?></label>
                                                            </div>

                                                            <ul class="notification-list">
                                                                <?php foreach ($order_delivered_updates as $order_delivered_update) : ?>
                                                                    <li class="notification-list-item" style="line-height:25px;">
                                                                        <p class="message"><?php echo $order_delivered_update->remark; ?></p>
                                                                        <div class="item-footer" style="color:gray;">
                                                                            <span class="from"><?php echo $order_delivered_update->title; ?></span>
                                                                            <span class="date"><?php echo $order_delivered_update->created_at; ?></span>
                                                                        </div>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </li>
                                                        <li class="notification-group">
                                                            <div class="notification-tab">
                                                                <!-- <i class="fa fa-trophy"></i> -->
                                                                <p class="notification-head">Promotions</p>
                                                                <?php $promotions_updates = $this->notification_model->get_promotions($this->auth_user->email); ?>
                                                                <label class="head-notification-count"><?php echo count($promotions_updates); ?></label>
                                                            </div>

                                                            <ul class="notification-list">
                                                                <?php foreach ($promotions_updates as $promotions_update) : ?>
                                                                    <li class="notification-list-item" style="line-height:25px;">
                                                                        <p class="message"><?php echo $promotions_update->remark; ?></p>
                                                                        <div class="item-footer" style="color:gray;">
                                                                            <span class="from"><?php echo $promotions_update->title; ?></span>
                                                                            <span class="date"><?php echo $promotions_update->created_at; ?></span>
                                                                        </div>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </li>
                                                        <?php if (is_user_vendor()) : ?>
                                                            <li class="notification-group">
                                                                <div class="notification-tab">
                                                                    <!-- <i class="fa fa-trophy"></i> -->
                                                                    <p class="notification-head">Rating, Reviews & Followers</p>
                                                                    <?php $reviews_followers_updates = $this->notification_model->get_reviews_followers($this->auth_user->email); ?>
                                                                    <label class="head-notification-count"><?php echo count($reviews_followers_updates); ?></label>
                                                                </div>

                                                                <ul class="notification-list">
                                                                    <?php foreach ($reviews_followers_updates as $reviews_followers_update) : ?>
                                                                        <li class="notification-list-item" style="line-height:25px;">
                                                                            <p class="message"><?php echo $reviews_followers_update->remark; ?></p>
                                                                            <div class="item-footer" style="color:gray;">
                                                                                <span class="from"><?php echo $reviews_followers_update->title; ?></span>
                                                                                <span class="date"><?php echo $reviews_followers_update->created_at; ?></span>
                                                                            </div>
                                                                        </li>
                                                                    <?php endforeach; ?>
                                                                </ul>
                                                            </li>
                                                            <li class="notification-group">
                                                                <div class="notification-tab">
                                                                    <!-- <i class="fa fa-trophy"></i> -->
                                                                    <p class="notification-head">Listings</p>
                                                                    <?php $listings_updates = $this->notification_model->get_listings($this->auth_user->email); ?>
                                                                    <label class="head-notification-count"><?php echo count($listings_updates); ?></label>
                                                                </div>

                                                                <ul class="notification-list">
                                                                    <?php foreach ($listings_updates as $listings_update) : ?>
                                                                        <li class="notification-list-item" style="line-height:25px;">
                                                                            <p class="message"><?php echo $listings_update->remark; ?></p>
                                                                            <div class="item-footer" style="color:gray;">
                                                                                <span class="from"><?php echo $listings_update->title; ?></span>
                                                                                <span class="date"><?php echo $listings_update->created_at; ?></span>
                                                                            </div>
                                                                        </li>
                                                                    <?php endforeach; ?>
                                                                </ul>
                                                            </li>
                                                            <li class="notification-group">
                                                                <div class="notification-tab">
                                                                    <!-- <i class="fa fa-trophy"></i> -->
                                                                    <p class="notification-head">Profile</p>
                                                                    <?php $profile_updates = $this->notification_model->get_profile_notification($this->auth_user->email); ?>
                                                                    <label class="head-notification-count"><?php echo count($profile_updates); ?></label>
                                                                </div>

                                                                <ul class="notification-list">
                                                                    <?php foreach ($profile_updates as $profile_update) : ?>
                                                                        <li class="notification-list-item" style="line-height:25px;">
                                                                            <p class="message"><?php echo $profile_update->remark; ?></p>
                                                                            <div class="item-footer" style="color:gray;">
                                                                                <span class="from"><?php echo $profile_update->title; ?></span>
                                                                                <span class="date"><?php echo $profile_update->created_at; ?></span>
                                                                            </div>
                                                                        </li>
                                                                    <?php endforeach; ?>
                                                                </ul>
                                                            </li>
                                                            <li class="notification-group">
                                                                <div class="notification-tab">
                                                                    <!-- <i class="fa fa-trophy"></i> -->
                                                                    <p class="notification-head">Payout</p>
                                                                    <?php $payout_updates = $this->notification_model->get_payout_notification($this->auth_user->email); ?>
                                                                    <label class="head-notification-count"><?php echo count($payout_updates); ?></label>
                                                                </div>

                                                                <ul class="notification-list">
                                                                    <?php foreach ($payout_updates as $payout_update) : ?>
                                                                        <li class="notification-list-item" style="line-height:25px;">
                                                                            <p class="message"><?php echo $payout_update->remark; ?></p>
                                                                            <div class="item-footer" style="color:gray;">
                                                                                <span class="from"><?php echo $payout_update->title; ?></span>
                                                                                <span class="date"><?php echo $payout_update->created_at; ?></span>
                                                                            </div>
                                                                        </li>
                                                                    <?php endforeach; ?>
                                                                </ul>
                                                            </li>
                                                            <li class="notification-group">
                                                                <div class="notification-tab">
                                                                    <!-- <i class="fa fa-trophy"></i> -->
                                                                    <p class="notification-head">Customization Notifications</p>
                                                                    <?php $customization_updates = $this->notification_model->get_customization_notification($this->auth_user->email); ?>
                                                                    <label class="head-notification-count"><?php echo count($customization_updates); ?></label>
                                                                </div>

                                                                <ul class="notification-list">
                                                                    <?php foreach ($customization_updates as $customization_update) : ?>
                                                                        <li class="notification-list-item" style="line-height:25px;">
                                                                            <p class="message"><?php echo $customization_update->remark; ?></p>
                                                                            <div class="item-footer" style="color:gray;">
                                                                                <span class="from"><?php echo $customization_update->title; ?></span>
                                                                                <span class="date"><?php echo $customization_update->created_at; ?></span>
                                                                            </div>
                                                                        </li>
                                                                    <?php endforeach; ?>
                                                                </ul>
                                                            </li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            </li>
                                        <?php else : ?>
                                            <!-- <li class="icon-bg">
                                                <a id='wishlist'>
                                                    <i class="far fa-bell"></i>
                                                </a>
                                            </li> -->
                                        <?php endif; ?>
                                        <?php if ($this->auth_check) : ?>
                                            <?php if ($this->auth_user->user_type != "guest") : ?>
                                                <li class="nav-item dropdown profile-dropdown p-r-0">
                                                    <a class="nav-link dropdown-toggle a-profile" data-toggle="dropdown" href="javascript:void(0)" aria-expanded="false">
                                                        <img src="<?php echo get_user_avatar($this->auth_user); ?>" alt="<?php echo get_shop_name($this->auth_user); ?>"> <?php if ($unread_message_count > 0) : ?>
                                                            <span class="notification"><?php echo $unread_message_count; ?></span>
                                                        <?php endif; ?>
                                                        <!-- <?php echo character_limiter(get_shop_name($this->auth_user), 15, '..'); ?> -->
                                                        <i class="icon-arrow-down"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <?php if ($this->auth_user->role == "admin") : ?>
                                                            <li>
                                                                <a href="<?php echo admin_url(); ?>">
                                                                    <!-- <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/profile-icon.png" alt="" style="width: 20px; height: 20px;" /> -->
                                                                    <?php echo trans("admin_panel"); ?>
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>
                                                        <?php if (is_user_vendor()) : ?>
                                                            <li>
                                                                <!-- <a href="<?= dashboard_url(); ?>"> -->
                                                                <a href="<?= generate_dash_url("profile"); ?>" target="_blank">
                                                                    <!-- <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/house.png" alt="" style="width: 20px; height: 20px;" /> -->
                                                                    <?php echo trans("supplier_panel"); ?>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo generate_dash_url("buyer_panel"); ?>">
                                                                    <!-- <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/house.png" alt="" style="width: 20px; height: 20px;" /> -->
                                                                    Buyer Profile
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo generate_url("followers") . "/" . $this->auth_user->slug; ?>">
                                                                    <!-- <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/house.png" alt="" style="width: 20px; height: 20px;" /> -->
                                                                    Followers
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>
                                                        <?php if ($this->auth_user->role == "member") { ?>
                                                            <li>
                                                                <a href="javascript:void(0);">
                                                                    <!-- <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/house.png" alt="" style="width: 20px; height: 20px;" /> -->
                                                                    <?php echo character_limiter(get_shop_name($this->auth_user), 15, '..'); ?>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo generate_dash_url("buyer_panel"); ?>">
                                                                    <!-- <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/house.png" alt="" style="width: 20px; height: 20px;" /> -->
                                                                    Profile
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo generate_url("following") . "/" . $this->auth_user->slug; ?>">
                                                                    <!-- <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/house.png" alt="" style="width: 20px; height: 20px;" /> -->
                                                                    Following
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                        <?php if (!is_user_vendor()) : ?>
                                                            <!-- <li>
                                                                <a href="<?php echo generate_dash_url("profile"); ?>">
                                                                    <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/profile-icon.png" alt="" style="width: 20px; height: 20px;" />
                                                                    <?php echo trans("profile"); ?>
                                                                </a>
                                                            </li> -->
                                                        <?php endif; ?>
                                                        <?php if ($this->is_sale_active) : ?>
                                                            <?php if ($this->auth_user->role == "member") : ?>
                                                                <li>
                                                                    <a href="<?php echo generate_url("orders_dashboard"); ?>">
                                                                        <!-- <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/order-icon.png" alt="" style="width: 20px; height: 20px;" /> -->
                                                                        <?php echo trans("orders"); ?>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>
                                                            <?php if ($this->auth_user->role != "member") { ?>
                                                                <?php if (is_bidding_system_active()) : ?>
                                                                    <li>
                                                                        <a href="<?php echo generate_url("quote_requests"); ?>">
                                                                            <!-- <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/qoute-icon.jpg" alt="" style="width: 20px; height: 20px;" /> -->
                                                                            <?php echo trans("quote_requests"); ?>
                                                                        </a>
                                                                    </li>
                                                                <?php endif; ?>
                                                            <?php } ?>
                                                            <?php if ($this->general_settings->digital_products_system == 1) : ?>
                                                                <li>
                                                                    <a href="<?php echo generate_url("downloads"); ?>">
                                                                        <!-- <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/Downloads-icon.png" alt="" style="width: 20px; height: 20px;" /> -->
                                                                        <?php echo trans("downloads"); ?>
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                        <li>
                                                            <a href="<?php echo generate_url("messages"); ?>">
                                                                <!-- <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/comment-icon.jpg" alt="" style="width: 20px; height: 20px;" /> -->
                                                                <?php echo trans("messages"); ?>&nbsp;<?php if ($unread_message_count > 0) : ?>
                                                                <span class="span-message-count"><?php echo $unread_message_count; ?></span>
                                                            <?php endif; ?>
                                                            </a>
                                                        </li>

                                                        <?php if ($this->auth_user->role == "vendor") { ?>
                                                            <!-- <li>
                                        <a href="<?php echo generate_url("barter_requests"); ?>">
                                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/barter-req-icon.png" alt="" style="width: 20px; height: 20px;" />
                                            Barter Requests
                                        </a>
                                    </li> -->
                                                        <?php } ?>
                                                        <?php if (is_user_vendor()) : ?>
                                                            <li>
                                                                <a href="<?php echo generate_url("password_settings_seller"); ?>">
                                                                    <!-- <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/update-profile-icon.jpg" alt="" style="width: 20px; height: 20px;" /> -->
                                                                    <?php echo trans("settings"); ?>
                                                                </a>
                                                            </li>
                                                        <?php else : ?>
                                                            <li>
                                                                <a href="<?php echo generate_url("password_settings"); ?>">
                                                                    <!-- <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/update-profile-icon.jpg" alt="" style="width: 20px; height: 20px;" /> -->
                                                                    <?php echo trans("settings"); ?>
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>
                                                        <?php if ($this->auth_check && $this->auth_user->is_active_shop_request == 1) : ?>
                                                            <?php if ($this->auth_user->gst_issue == 1 || $this->auth_user->pan_issue == 1 || $this->auth_user->adhaar_issue == 1) : ?>
                                                                <li>
                                                                    <a href="<?php echo generate_url("settings", "update_settings"); ?>">
                                                                        Update Seller Info
                                                                    </a>
                                                                </li>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                        <li>
                                                            <a href="<?php echo base_url(); ?>logout" class="logout">
                                                                <!-- <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/logout.ico" alt="" style="width: 20px; height: 20px;" /> -->
                                                                <?php echo trans("logout"); ?>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            <?php endif;
                                            ?>
                                        <?php else : ?>
                                            <li>
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal" id="header-login">Sign in</a>
                                            </li>

                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-main">
                        <?php $this->load->view("partials/_nav_main"); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="mobile-nav-container" id="myMobileHeader">
            <div class="nav-mobile-header">

                <?php //$this->load->view("partials/_top_bar_mobile"); 
                ?>
                <div class="container-fluid">
                    <div class="row">
                        <div class="nav-mobile-header-container">
                            <div class="menu-icon">
                                <a href="javascript:void(0)" class="btn-open-mobile-nav"><i class="icon-menu"></i></a>
                            </div>
                            <div class="mobile-map">
                                <?php if (!empty($_SESSION["modesy_sess_user_location"])) : ?>

                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#locateModal" style="color:red;">
                                        <span class="pincode_text"> Showing results for products deliverable at pincode <?php echo $_SESSION["modesy_sess_user_location"]; ?>
                                        </span>
                                    <?php else : ?>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#locateModal">


                                        <?php endif; ?>
                                        <i class="icon-map-marker"></i></a>

                            </div>

                            <div class="mobile-logo">
                                <a href="<?php echo lang_base_url(); ?>"><img src="<?php echo get_logo($this->general_settings); ?>" alt="logo" class="logo"></a>
                            </div>
                            <div class="mobile-cart<?= !$this->is_sale_active ? ' visibility-hidden' : ''; ?>">
                                <?php if ($this->auth_check) : ?>
                                    <?php if ($this->auth_user->user_type != "guest") : ?>
                                        <a href="<?php echo generate_url("wishlist") . "/" . $this->auth_user->slug; ?>">
                                            <i class="icon-heart-o"></i>
                                        </a>
                                    <?php else : ?>
                                        <!-- hide wishlist for guest user -->
                                        <!-- <li class="icon-bg">
                                                    <a href="<?php echo generate_url("wishlist") . "/" . $this->auth_user->slug; ?>">
                                                        <i class="icon-heart-o"></i>
                                                    </a>
                                                </li> -->
                                    <?php endif; ?>
                                <?php else : ?>
                                    <a id='wishlist-mobile-view-header' ?>
                                        <i class="icon-heart-o"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="mobile-cart">
                                <a class="cart_a" href="<?php echo generate_url("cart"); ?>"><i class="icon-cart"></i>
                                    <?php $cart_product_count = get_cart_product_count();
                                    if ($cart_product_count > 0) : ?>
                                        <span class="notification"><?php echo $cart_product_count; ?></span>
                                    <?php endif; ?>
                                </a>
                            </div>
                            <?php if ($this->auth_check) : ?>
                                <li class="icon-bg">
                                    <!--span class="notification-label"></span-->
                                    <div class="dropdown-container">
                                        <a href="#" data-dropdown="notificationMenu" class="menu-link has-notifications circle">
                                            <i class="far fa-bell notification-button"></i>
                                        </a>
                                        <ul class="dropdown" name="notificationMenu" style="z-index:100;">
                                            <li class="notification-group">
                                                <div class="notification-tab">
                                                    <!-- <i class="fa fa-flag"></i> -->
                                                    <p class="notification-head">Gharobaar Updates</p>
                                                    <?php $gharobaar_updates = $this->notification_model->get_gharobaar_updates($this->auth_user->email); ?>
                                                    <label class="head-notification-count"><?php echo count($gharobaar_updates); ?></label>
                                                </div>
                                                <!-- tab -->

                                                <ul class="notification-list">
                                                    <?php foreach ($gharobaar_updates as $gharobaar_update) : ?>
                                                        <li class="notification-list-item" style="line-height:25px;">
                                                            <p class="message"><?php echo $gharobaar_update->remark; ?></p>
                                                            <div class="item-footer" style="color:gray;">
                                                                <span class="from"><?php echo $gharobaar_update->title; ?></span>
                                                                <span class="date"><?php echo $gharobaar_update->created_at; ?></span>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>

                                                </ul>
                                            </li>
                                            <li class="notification-group">
                                                <div class="notification-tab">
                                                    <!-- <i class="fa fa-bug"></i> -->
                                                    <p class="notification-head">Order Placement</p>
                                                    <?php $order_placements = $this->notification_model->get_order_placement($this->auth_user->email); ?>
                                                    <label class="head-notification-count"><?php echo count($order_placements); ?></label>
                                                </div> <!-- tab -->

                                                <ul class="notification-list">
                                                    <?php foreach ($order_placements as $order_placement) : ?>
                                                        <li class="notification-list-item" style="line-height:25px;">
                                                            <p class="message"><?php echo $order_placement->remark; ?></p>
                                                            <div class="item-footer" style="color:gray;">
                                                                <span class="from"><?php echo $order_placement->title; ?></span>
                                                                <span class="date"><?php echo $order_placement->created_at; ?></span>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                                <!-- list -->
                                            </li>
                                            <li class="notification-group">
                                                <div class="notification-tab">
                                                    <!-- <i class="fa fa-envelope"></i> -->
                                                    <p class="notification-head">Order Update</p>
                                                    <?php $order_updates = $this->notification_model->get_order_update($this->auth_user->email); ?>
                                                    <label class="head-notification-count"><?php echo count($order_updates); ?></label>
                                                </div>

                                                <ul class="notification-list">
                                                    <?php foreach ($order_updates as $order_update) : ?>
                                                        <li class="notification-list-item" style="line-height:25px;">
                                                            <p class="message"><?php echo $order_update->remark; ?></p>
                                                            <div class="item-footer" style="color:gray;">
                                                                <span class="from"><?php echo $order_update->title; ?></span>
                                                                <span class="date"><?php echo $order_update->created_at; ?></span>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                            <li class="notification-group">
                                                <div class="notification-tab">
                                                    <!-- <i class="fa fa-calendar"></i> -->
                                                    <p class="notification-head">Order Cancellation by Seller</p>
                                                    <?php $order_cancellation_seller_updates = $this->notification_model->get_order_cancellation_by_seller($this->auth_user->email); ?>
                                                    <label class="head-notification-count"><?php echo count($order_cancellation_seller_updates); ?></label>
                                                </div>

                                                <ul class="notification-list">
                                                    <?php foreach ($order_cancellation_seller_updates as $order_cancellation_seller_update) : ?>
                                                        <li class="notification-list-item" style="line-height:25px;">
                                                            <p class="message"><?php echo $order_cancellation_seller_update->remark; ?></p>
                                                            <div class="item-footer" style="color:gray;">
                                                                <span class="from"><?php echo $order_cancellation_seller_update->title; ?></span>
                                                                <span class="date"><?php echo $order_cancellation_seller_update->created_at; ?></span>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                            <li class="notification-group">
                                                <div class="notification-tab">
                                                    <!-- <i class="fa fa-trophy"></i> -->
                                                    <p class="notification-head">Order Delivered</p>
                                                    <?php $order_delivered_updates = $this->notification_model->get_order_delivered($this->auth_user->email); ?>
                                                    <label class="head-notification-count"><?php echo count($order_delivered_updates); ?></label>
                                                </div>

                                                <ul class="notification-list">
                                                    <?php foreach ($order_delivered_updates as $order_delivered_update) : ?>
                                                        <li class="notification-list-item" style="line-height:25px;">
                                                            <p class="message"><?php echo $order_delivered_update->remark; ?></p>
                                                            <div class="item-footer" style="color:gray;">
                                                                <span class="from"><?php echo $order_delivered_update->title; ?></span>
                                                                <span class="date"><?php echo $order_delivered_update->created_at; ?></span>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                            <li class="notification-group">
                                                <div class="notification-tab">
                                                    <!-- <i class="fa fa-trophy"></i> -->
                                                    <p class="notification-head">Promotions</p>
                                                    <?php $promotions_updates = $this->notification_model->get_promotions($this->auth_user->email); ?>
                                                    <label class="head-notification-count"><?php echo count($promotions_updates); ?></label>
                                                </div>

                                                <ul class="notification-list">
                                                    <?php foreach ($promotions_updates as $promotions_update) : ?>
                                                        <li class="notification-list-item" style="line-height:25px;">
                                                            <p class="message"><?php echo $promotions_update->remark; ?></p>
                                                            <div class="item-footer" style="color:gray;">
                                                                <span class="from"><?php echo $promotions_update->title; ?></span>
                                                                <span class="date"><?php echo $promotions_update->created_at; ?></span>
                                                            </div>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                            <?php if (is_user_vendor()) : ?>
                                                <li class="notification-group">
                                                    <div class="notification-tab">
                                                        <!-- <i class="fa fa-trophy"></i> -->
                                                        <p class="notification-head">Rating, Reviews & Followers</p>
                                                        <?php $reviews_followers_updates = $this->notification_model->get_reviews_followers($this->auth_user->email); ?>
                                                        <label class="head-notification-count"><?php echo count($reviews_followers_updates); ?></label>
                                                    </div>

                                                    <ul class="notification-list">
                                                        <?php foreach ($reviews_followers_updates as $reviews_followers_update) : ?>
                                                            <li class="notification-list-item" style="line-height:25px;">
                                                                <p class="message"><?php echo $reviews_followers_update->remark; ?></p>
                                                                <div class="item-footer" style="color:gray;">
                                                                    <span class="from"><?php echo $reviews_followers_update->title; ?></span>
                                                                    <span class="date"><?php echo $reviews_followers_update->created_at; ?></span>
                                                                </div>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </li>
                                                <li class="notification-group">
                                                    <div class="notification-tab">
                                                        <!-- <i class="fa fa-trophy"></i> -->
                                                        <p class="notification-head">Listings</p>
                                                        <?php $listings_updates = $this->notification_model->get_listings($this->auth_user->email); ?>
                                                        <label class="head-notification-count"><?php echo count($listings_updates); ?></label>
                                                    </div>

                                                    <ul class="notification-list">
                                                        <?php foreach ($listings_updates as $listings_update) : ?>
                                                            <li class="notification-list-item" style="line-height:25px;">
                                                                <p class="message"><?php echo $listings_update->remark; ?></p>
                                                                <div class="item-footer" style="color:gray;">
                                                                    <span class="from"><?php echo $listings_update->title; ?></span>
                                                                    <span class="date"><?php echo $listings_update->created_at; ?></span>
                                                                </div>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </li>
                                                <li class="notification-group">
                                                    <div class="notification-tab">
                                                        <!-- <i class="fa fa-trophy"></i> -->
                                                        <p class="notification-head">Profile</p>
                                                        <?php $profile_updates = $this->notification_model->get_profile_notification($this->auth_user->email); ?>
                                                        <label class="head-notification-count"><?php echo count($profile_updates); ?></label>
                                                    </div>

                                                    <ul class="notification-list">
                                                        <?php foreach ($profile_updates as $profile_update) : ?>
                                                            <li class="notification-list-item" style="line-height:25px;">
                                                                <p class="message"><?php echo $profile_update->remark; ?></p>
                                                                <div class="item-footer" style="color:gray;">
                                                                    <span class="from"><?php echo $profile_update->title; ?></span>
                                                                    <span class="date"><?php echo $profile_update->created_at; ?></span>
                                                                </div>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </li>
                                                <li class="notification-group">
                                                    <div class="notification-tab">
                                                        <!-- <i class="fa fa-trophy"></i> -->
                                                        <p class="notification-head">Payout</p>
                                                        <?php $payout_updates = $this->notification_model->get_payout_notification($this->auth_user->email); ?>
                                                        <label class="head-notification-count"><?php echo count($payout_updates); ?></label>
                                                    </div>

                                                    <ul class="notification-list">
                                                        <?php foreach ($payout_updates as $payout_update) : ?>
                                                            <li class="notification-list-item" style="line-height:25px;">
                                                                <p class="message"><?php echo $payout_update->remark; ?></p>
                                                                <div class="item-footer" style="color:gray;">
                                                                    <span class="from"><?php echo $payout_update->title; ?></span>
                                                                    <span class="date"><?php echo $payout_update->created_at; ?></span>
                                                                </div>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </li>
                                                <li class="notification-group">
                                                    <div class="notification-tab">
                                                        <!-- <i class="fa fa-trophy"></i> -->
                                                        <p class="notification-head">Customization Notifications</p>
                                                        <?php $customization_updates = $this->notification_model->get_customization_notification($this->auth_user->email); ?>
                                                        <label class="head-notification-count"><?php echo count($customization_updates); ?></label>
                                                    </div>

                                                    <ul class="notification-list">
                                                        <?php foreach ($customization_updates as $customization_update) : ?>
                                                            <li class="notification-list-item" style="line-height:25px;">
                                                                <p class="message"><?php echo $customization_update->remark; ?></p>
                                                                <div class="item-footer" style="color:gray;">
                                                                    <span class="from"><?php echo $customization_update->title; ?></span>
                                                                    <span class="date"><?php echo $customization_update->created_at; ?></span>
                                                                </div>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </li>
                            <?php else : ?>
                                <!-- <li class="icon-bg">
                                                <a id='wishlist'>
                                                    <i class="far fa-bell"></i>
                                                </a>
                                            </li> -->
                            <?php endif; ?>


                            <div class="mobile-search">
                                <a class="search-icon"><i class="icon-search"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="top-search-bar mobile-search-form <?= $this->general_settings->multi_vendor_system != 1 ? ' top-search-bar-single-vendor' : ''; ?>">
                            <?php echo form_open(generate_url('search'), ['id' => 'form_validate_search_mobile', 'method' => 'get']); ?>
                            <?php if ($this->general_settings->multi_vendor_system == 1) : ?>
                                <!-- <div class="left">
                                    <div class="dropdown search-select">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                            <?php if (isset($search_type)) : ?>
                                                <?php echo trans("member"); ?>
                                            <?php else : ?>
                                                <?php echo trans("product"); ?>
                                            <?php endif; ?>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" data-value="product" href="javascript:void(0)"><?php echo trans("product"); ?></a>
                                            <a class="dropdown-item" data-value="member" href="javascript:void(0)"><?php echo trans("member"); ?></a>
                                        </div>
                                    </div>
                                    <?php if (isset($search_type)) : ?>
                                        <input type="hidden" id="search_type_input_mobile" class="search_type_input" name="search_type" value="member">
                                    <?php else : ?>
                                        <input type="hidden" id="search_type_input_mobile" class="search_type_input" name="search_type" value="product">
                                    <?php endif; ?>
                                </div> -->
                                <div class="search_bar" style="width: 95%;">
                                    <input type="hidden" id="search_type_input_mobile" class="search_type_input" name="search_type" value="product">
                                    <input type="text" id="input_search_mobile" name="search" maxlength="300" pattern=".*\S+.*" class="form-control input-search speech-input" value="<?php echo (!empty($filter_search)) ? $filter_search : ''; ?>" placeholder="<?php echo trans("search"); ?>" onchange="search_input();" required>
                                    <button class="btn btn-default btn-search"><i class="icon-search"></i></button>
                                    <div id="response_search_results_mobile" class="search-results-ajax"></div>
                                </div>
                            <?php else : ?>
                                <input type="hidden" id="search_type_input_mobile" class="search_type_input" name="search_type" value="product">
                                <input type="text" id="input_search" name="search" maxlength="300" pattern=".*\S+.*" id="input_search_mobile" class="form-control input-search speech-input" value="<?php echo (!empty($filter_search)) ? $filter_search : ''; ?>" placeholder="<?php echo trans("search_products"); ?>" onchange="search_input();" required autocomplete="off">
                                <button class="btn btn-default btn-search btn-search-single-vendor-mobile"><i class="icon-search"></i></button>
                                <div id="response_search_results_mobile" class="search-results-ajax"></div>
                            <?php endif; ?>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($this->general_settings->enable_freeship_message == 1) : ?>
            <div id="announcement-mobile-bar">
                <article class="sliding_content" aria-labelledby="promo_bar_label" data-section-id="announcement-bar" data-block-count="1" data-speed="4000" data-autoplay="4000" data-slider="false" data-section-type="announcement" data-language="false" data-currency="false">

                    <div class="animation-mobile-bar">
                        <marquee behaviour="scroll" direction="right">
                            <p class="display-mobile"><strong><?php echo trans("free_ship_message"); ?> </strong></p>
                        </marquee>
                </article>
            </div>

            </div>
        <?php endif; ?>
    </header>

    <div id="overlay_bg" class="overlay-bg"></div>
    <!--include mobile menu-->
    <?php $this->load->view("partials/_nav_mobile"); ?>
    <input type="hidden" class="search_type_input" name="search_type" value="product">
    <?php if (!$this->auth_check || $this->auth_user->user_type == "guest") : ?>
        <!-- Login Modal -->
        <div class="modal fade" id="loginModal" role="dialog">
            <div class="modal-dialog modal-dialog-centered login-modal" role="document">
                <div class="modal-content">
                    <div class="auth-box">
                        <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                        <h4 class="title"><?php echo trans("login"); ?></h4>
                        <!-- form start -->
                        <form id="form_login">
                            <div class="social-login-cnt">
                                <?php $this->load->view("partials/_social_login", ["or_text" => trans("login_with_email")]); ?>
                            </div>
                            <!-- include message block -->
                            <div id="result-login" class="font-size-13"></div>
                            <div class="form-group">
                                <input type="text" name="email" class="form-control auth-form-input" id="guest_email_fill" placeholder="<?php echo trans("email_mobile"); ?>" required>
                                <input type="hidden" name="redirect_path" id="redirect_path" value="<?php echo $path_url; ?>">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="password_login" class="form-control auth-form-input" placeholder="<?php echo trans("password"); ?>" minlength="4" required>
                                <span class="far fa-eye field-icon" id="togglePassword_login"></span>
                            </div>
                            <div class="form-group text-right">
                                <a href="<?php echo generate_url("forgot_password"); ?>" class="link-forgot-password"><?php echo trans("forgot_password"); ?></a>
                            </div>
                            <?php if ($this->general_settings->enable_otp_login) : ?>
                                <div style="text-align:center;  margin-bottom:5px">
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#OtploginModal" class="logintoOtp" style="text-decoration: underline; color:blue !important">Login using OTP</a>
                                </div>
                            <?php endif; ?>
                            <div class="form-group" style="text-align:center;">
                                <button type="submit" class="btn btn-md btn-custom btn-block-new-ui"><?php echo trans("login_with_pwd"); ?></button>
                            </div>

                            <p class="p-social-media m-0 m-t-5"><?php echo trans("dont_have_account"); ?>&nbsp; <a href="javascript:void(0)" data-toggle="modal" data-id="0" data-target="#registerModal" class="link"><?php echo trans("register"); ?></a></p>
                        </form>
                        <!-- form end -->


                    </div>

                </div>
            </div>
        </div>

        <!-- add to cart user emial_id contact modal -->

        <div class="modal fade" id="add_to_cart_auth_check" role="dialog">
            <div class="modal-dialog modal-dialog-centered login-modal" role="document">
                <div class="modal-content">
                    <div class="auth-box">
                        <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                        <h4 class="title"><?php echo trans("guest_login"); ?></h4>
                        <!-- form start -->
                        <form id="form_guest_login">
                            <!-- include message block -->
                            <div id="result-login" class="font-size-13"></div>
                            <div class="form-group">
                                <input type="text" name="cart_email" id="guest_email" class="form-control auth-form-input" placeholder="<?php echo trans("email_address"); ?>" required>
                                <span id="email_span_error" style="color:red;"></span>
                            </div>

                            <div class="form-group">
                                <input type="text" name="cart_phone_number" id="guest_phone_number" class="form-control auth-form-input" placeholder="Mobile Number" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" required>
                            </div>
                            <div id="email_phn_exist_msg" style="color: red;">

                            </div>
                            <div class="form-group hide_after_response" id="continue_guest_hide" style="text-align:center;">
                                <button type="submit" class="btn btn-md btn-custom btn-block-new-ui"><?php echo trans("continue"); ?></button>
                            </div>

                        </form>
                        <!-- form end -->
                    </div>
                </div>
                r
            </div>
        </div>







        <!-- Guest Login Modal -->
        <div class="modal fade" id="guestLoginModal" role="dialog">
            <div class="modal-dialog modal-dialog-centered login-modal" role="document">
                <div class="modal-content">
                    <div class="auth-box">
                        <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                        <h4 class="title"><?php echo trans("guest_login"); ?></h4>
                        <!-- form start -->
                        <form id="form_guest_login">
                            <!-- include message block -->
                            <div id="result-login" class="font-size-13"></div>
                            <div class="form-group">
                                <input type="text" name="email" id="guest_email" class="form-control auth-form-input" placeholder="<?php echo trans("email_address"); ?>" required>
                                <span id="email_span_error" style="color:red;"></span>
                            </div>

                            <!-- <div class="form-group">
                                <input type="text" name="phone_number" id="guest_phone_number" class="form-control auth-form-input" placeholder="Mobile Number" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" required>
                            </div> -->
                            <div id="email_phn_exist_msg" style="color: red;">

                            </div>

                            <p class="p-social-media m-0 m-t-5 hide_after_response"><?php echo trans("dont_have_account"); ?>&nbsp; <a href="javascript:void(0)" data-toggle="modal" data-id="0" data-target="#registerModal" class="link"><?php echo trans("register"); ?></a></p>


                            <!-- <div class="form-group show_after_response hideMe">
                                <hr>
                                <input type="text" name="guest_otp" id="guest_otp" class="form-control auth-form-input" placeholder="Enter OTP" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" minlength="6" maxlength="6">

                                <p class="p-social-media m-0 m-t-5"><a href="javascript:void(0)" onclick="guest_resend_otp($('#guest_phone_number'),$('#guest_email'))"><?php echo trans("resend_otp"); ?></a></p>

                            
                            </div> -->

                            <div id="email_phn_exist_msg_login">
                                <a href="#" class="hideguestmodal btn btn-block" data-toggle="modal" data-target="#loginModal">Login</a>
                            </div>
                            <div class="form-group hide_after_response" id="continue_guest_hide" style="text-align:center;">
                                <button type="submit" class="btn btn-md btn-custom btn-block-new-ui"><?php echo trans("continue"); ?></button>
                            </div>
                            <!-- <div class="form-group show_after_response hideMe" style="text-align:center;">
                                <button type="submit" class="btn btn-md btn-custom btn-block-new-ui"><?php echo trans("confirm_otp"); ?></button>
                            </div> -->
                        </form>
                        <!-- form end -->

                        <div class="login_to_avail" style="color:#aaaaa;"> <?php echo trans("login_to_avail"); ?></div>
                    </div>

                </div>
            </div>
        </div>

        <!-- login with OTP model start -->
        <div class="modal fade" id="OtploginModal" role="dialog">
            <div class="modal-dialog modal-dialog-centered login-modal" role="document">
                <div class="modal-content">
                    <div class="auth-box" style="width: 370px;">
                        <button type="button" class="close" data-dismiss="modal"><i class="icon-close" onclick="reloadPage()"></i></button>
                        <h4 class="title"><?php echo trans("login"); ?></h4>
                        <!-- form start -->
                        <form id="form_login_otp">
                            <div class="social-login-cnt">
                                <?php $this->load->view("partials/_social_login", ["or_text" => trans("login_with_email")]); ?>
                            </div>
                            <!-- include message block -->
                            <div id="result-login" class="font-size-13"></div>
                            <div class="OtpSendMsg">
                                <span id="OtpSendMsg"></span>
                            </div>
                            <div class="form-group">
                                <input type="text" name="registeredNumber" class="form-control auth-form-input" placeholder="<?php echo trans("register_mobile"); ?>" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" minlength="10" maxlength="10" required>
                                <span id="login_otp_check" style="color: red;"></span>
                            </div>

                            <div class="form-group">
                                <input type="text" name="loginOtp" id="loginOtp" class="form-control auth-form-input" placeholder="Enter Otp" required maxlength="6">
                                <span id="login_otp_span" style="color: red;"></span>
                            </div>

                            <p class="p-social-media m-0 m-t-5"><a href="javascript:void(0)" id="resend_login_otp" class="link" style="text-decoration: underline; color:blue !important">Resend OTP</a></p>

                            <div class="form-group" style="text-align:center;">
                                <button type="button" id="sendLoginOtp" class="btn btn-md btn-custom btn-block-new-ui">Send OTP</button>
                            </div>
                            <div class="form-group" style="text-align:center;">
                                <button type="button" id="verify_login_otp" class="btn btn-md btn-custom btn-block-new-ui"><?php echo trans("login"); ?></button>
                            </div>
                        </form>
                        <!-- form end -->
                    </div>

                </div>
            </div>
        </div>
        <!-- login using OTP model end  -->





        <div class="modal fade" id="registerModal" role="dialog">
            <div class="modal-dialog modal-dialog-centered login-modal modal-dialog" role="document" style="justify-content: center;">
                <div class="modal-content">

                    <div class="register-box">
                        <button type="button" class="close above-all" data-dismiss="modal"><i class="icon-close"></i></button>
                        <h1 class="title">Register</h1>
                        <!-- form start -->
                        <?php
                        if ($recaptcha_status) {
                            echo form_open('register-post', [
                                'id' => 'form_validate', 'class' => 'validate_terms',
                                'onsubmit' => "var serializedData = $(this).serializeArray();var recaptcha = ''; $.each(serializedData, function (i, field) { if (field.name == 'g-recaptcha-response') {recaptcha = field.value;}});if (recaptcha.length < 5) { $('.g-recaptcha>div').addClass('is-invalid');return false;} else { $('.g-recaptcha>div').removeClass('is-invalid');}"
                            ]);
                        } else {
                            // echo form_open('register-post', ['id' => 'form_validate', 'class' => 'validate_terms']);
                        ?>
                            <form name="register-form" id="form_validate" class="validate_terms" method="post" accept-charset="utf-8" novalidate="novalidate">
                            <?php }
                            ?>
                            <div class="social-login-cnt">
                                <?php $this->load->view("partials/_social_login", ['or_text' => 'Or Register with email']); ?>
                            </div>
                            <!-- include message block -->
                            <div id="result-register-popup">
                                <?php //$this->load->view('partials/_messages'); 
                                ?>
                            </div>
                            <div class="spinner display-none spinner-activation-register">
                                <div class="bounce1"></div>
                                <div class="bounce2"></div>
                                <div class="bounce3"></div>
                            </div>
                            <input type="hidden" id="via_sell_now" name="via_sell_now" style="text-transform: capitalize;" class="form-control auth-form-input" value="0">

                            <div class="form-group">
                                <div class="row">
                                    <!-- <div class="col-12 col-sm-4 m-b-15">

                                        <label class="control-label">First Name<span class="Validation_error"> *</span></label>

                                    </div> -->
                                    <div class="col-12 col-sm-12 m-b-15">
                                        <input type="text" name="first_name" style="text-transform: capitalize;" class="form-control auth-form-input" placeholder="<?php echo trans("first_name"); ?>" value="<?php echo old("first_name"); ?>" maxlength="255" required>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <!-- <div class="col-12 col-sm-4 m-b-15">

                                        <label class="control-label">Last Name<span class="Validation_error"> *</span></label>

                                    </div> -->
                                    <div class="col-12 col-sm-12 m-b-15">
                                        <input type="text" name="last_name" style="text-transform: capitalize;" class="form-control auth-form-input" placeholder="<?php echo trans("last_name"); ?>" value="<?php echo old("last_name"); ?>" maxlength="255" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <!-- <div class="col-12 col-sm-4 m-b-15">

                                        <label class="control-label">Email<span class="Validation_error"> *</span></label>

                                    </div> -->
                                    <div class="col-12 col-sm-12 m-b-15">
                                        <input type="email" name="email" id="email_new" class="form-control auth-form-input" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" placeholder="<?php echo trans("email_address"); ?>" value="<?php echo old("email"); ?>" required>
                                        <span id="email_span_error" style="color:red;"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <!-- <div class="col-12 col-sm-4 m-b-15">

                                        <label class="control-label">Phone <br> Number<span class="Validation_error"> *</span></label>

                                    </div> -->
                                    <div class="col-12 col-sm-12 m-b-15">
                                        <input type="text" name="phone_number" id="phone_number" class="form-control auth-form-input" placeholder="Mobile Number" value="<?php echo old("phone_number"); ?>" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" name="itemConsumption" minlength="10" maxlength="10" required>
                                        <strong id="verify_otp" class="btn btn-md btn-custom btn-block-new-ui">Verify Mobile</strong>
                                        <br><span id="verify_mobile_span" style="color:red;">*You cannot register without Mobile Verification!</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <!-- <div class="col-12 col-sm-4 m-b-15">

                                        <label class="control-label">Gender<span class="Validation_error"> *</span></label>

                                    </div> -->
                                    <div class="col-12 col-sm-12 m-b-15">
                                        <select name="gender" class="form-control auth-form-input" placeholder="Gender" required>
                                            <option value="" selected disabled>Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <!-- <div class="col-12 col-sm-4 m-b-15">

                                        <label class="control-label">Password<span class="Validation_error"> *</span></label>

                                    </div> -->
                                    <div class="col-12 col-sm-12 m-b-15">
                                        <input type="password" name="password" id="password" class="form-control auth-form-input" placeholder="<?php echo trans("password"); ?>" value="<?php echo old("password"); ?>" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{8,25}$" minlength="8" maxlength="25">
                                        <span class="far fa-eye field-icon" id="togglePassword"></span>
                                        <label id="Passwordvalidate" style="color:red;"></label>
                                        <div id="message">
                                            <p>Password must contain the following:
                                            <p>
                                            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                                            <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                                            <p id="number" class="invalid">A <b>number</b></p>
                                            <p id="special_character" class="invalid">A <b>Special Character</b></p>
                                            <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <!-- <div class="col-12 col-sm-4 m-b-15">

                                        <label class="control-label">Confirm Password<span class="Validation_error"> *</span></label>

                                    </div> -->
                                    <div class="col-12 col-sm-12 m-b-15">
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control auth-form-input" placeholder="<?php echo trans("password_confirm"); ?>" required>
                                        <span class="far fa-eye field-icon" id="togglePassword1"></span>

                                        <label id="CheckPasswordMatch" style="color:red;"></label>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-t-5 m-b-20">
                                <div class="custom-control custom-checkbox custom-control-validate-input">
                                    <input type="checkbox" class="custom-control-input" name="terms" id="checkbox_terms" readonly="readonly" required>
                                    <label for="checkbox_terms" class="custom-control-label"><?php echo trans("terms_conditions_exp"); ?>&nbsp;
                                        <?php $page_terms = get_page_by_default_name("terms_conditions", $this->selected_lang->id);
                                        if (!empty($page_terms)) : ?>
                                            <strong data-toggle="modal" data-target="#termsConditionRegister"><u style="color: blue;">(<?= html_escape($page_terms->title); ?>)</u></strong>
                                        <?php endif; ?>
                                    </label>
                                    <small id="small-text-header" style="display:none;color:red;">(<?php echo trans("terms_condition_msg"); ?>)</small>
                                </div>
                            </div>
                            <?php if ($recaptcha_status) : ?>
                                <div class="recaptcha-cnt">
                                    <?php generate_recaptcha(); ?>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <button type="submit" id="btnsubmit_register" class="btn btn-md btn-custom btn-block-new-ui" disabled><?php echo trans("register"); ?></button>
                            </div>
                            <p class="p-social-media m-0 m-t-15"><?php echo trans("have_account"); ?>&nbsp;<a href="javascript:void(0)" class="register_color registertologin" data-toggle="modal" data-target="#loginModal"><?php echo trans("login"); ?></a></p>

                            <?php echo form_close(); ?>
                            <!-- form end -->

                    </div>

                </div>
            </div>
        </div>

    <?php endif; ?>

    <div class="modal fade" id="verifyMobileModal" role="dialog" data-backdrop="static">
        <div class="modal-dialog-centered" role="document">
            <div class="modal-dialog modal-lg verifyModalWidth" id="mobile_otp">
                <div class="modal-body-new" style="border-radius:20px;">
                    <div class="modal-content">
                        <div class="modal-header" style="border:none; text-align:center;">
                            <button type="button" class="close" id="cross-btn" data-dismiss="modal" aria-label="Close" onclick="">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5 class="modal-title">Verify Mobile Number</h5>
                        </div>
                        <div class="modal-body text-center">
                            <div class="text-center" id="send-otp-result"></div>
                            <center>
                                <input type="text" name="otp_field" id="otp_field" class="form-control auth-form-input otp_field_width" placeholder="Enter OTP" value="" maxlength="255" required="">
                                <span id="otp_field_span" style="color:red;"></span>
                            </center><br>
                            <div class="row text-center" id="verification" style="justify-content:center;">

                                <button type="button" id="verify_btn" class="btn btn-custom verify_btn_margin">Verify OTP</button>


                                <button type="button" id="resend_otp" class="btn btn-custom verify_btn_margin" onclick="send_verification_otp()">Resend OTP</button>

                            </div>
                            <center><button type="button" id="close_btn" data-dismiss="modal" class="btn btn-custom" style="display:none;">Close</button></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="termsConditionRegister" role="dialog" data-backdrop="static">
        <div class="modal-dialog-centered terms-condition-modal" role="document">
            <div class="modal-dialog modal-lg" id="buyer_t_c">
                <div class="modal-content">
                    <div class="modal-header" style="border:none; text-align:center;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title">Gharobaar Terms of Use</h5>
                    </div>
                    <div class="modal-body" id="terms-of-use">
                        <?php echo get_content("buyer_terms_conditions"); ?><?php echo get_content("buyer_terms_conditions1"); ?>
                        <center><button type="button" class="btn btn-custom" data-dismiss="modal" onclick="register_popup_t_c()">Accept</button></center>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="locationModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered login-modal location-modal" role="document">
            <div class="modal-content">
                <div class="auth-box">
                    <button type="button" class="close" data-dismiss="modal"><i class="icon-close"></i></button>
                    <h4 class="title"><?php echo trans("select_location"); ?></h4>
                    <p class="location-modal-description"><?php echo trans("location_exp"); ?></p>
                    <div class="form-group m-b-20">
                        <div class="input-group input-group-location">
                            <i class="icon-map-marker"></i>
                            <input type="text" id="input_location" class="form-control form-input" value="<?php echo get_default_location_input(); ?>" placeholder="<?php echo trans("enter_location") ?>" autocomplete="off">
                            <a href="javascript:void(0)" class="btn-reset-location-input<?= (empty($this->default_location->country_id)) ? ' hidden' : ''; ?>"><i class="icon-close"></i></a>
                        </div>
                        <div class="search-results-ajax">
                            <div class="search-results-location">
                                <div id="response_search_location"></div>
                            </div>
                        </div>
                        <div id="location_id_inputs">
                            <input type="hidden" name="country" value="<?= $this->default_location->country_id; ?>" class="input-location-filter">
                            <input type="hidden" name="state" value="<?= $this->default_location->state_id; ?>" class="input-location-filter">
                            <input type="hidden" name="city" value="<?= $this->default_location->city_id; ?>" class="input-location-filter">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" id="btn_submit_location" class="btn btn-md btn-custom btn-block"><?php echo trans("update_location"); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="locateModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered login-modal locate-modal" role="document">
            <div class="modal-content">
                <div class="auth-box">
                    <button type="button" class="close" data-dismiss="modal" id="close-pin"><i class="icon-close"></i></button>
                    <?php echo form_open(generate_url('search_pincode'), ['id' => 'form_validate_pincode_search', 'class' => 'form_search_pincode_main form-inline', 'method' => 'get']); ?>

                    <div id="location">
                        <p class="locate-modal-description">Enter pincode to check availability in your area</p>

                        <div class="form-group m-b-20">
                            <div class="input-group input-group-location">
                                <input type="text" name="search_pincode" class="form-control enter_p clearable_search" id="pincodeSearchField" maxlength="6" minlength="6" pattern="[0-9]+" class="form-control input-search" value="<?php echo (!empty($_SESSION["modesy_sess_user_location"])) ? $_SESSION["modesy_sess_user_location"] : ''; ?>" placeholder="Enter pincode" autocomplete="off">
                                <input type="hidden" class="search_type_input_pincode" name="search_type_pincode" value="pincode">
                                <button class="check_pincode">Go!</button>
                                <div id="response_pincode_search_results" class="search-results-ajax">
                                </div>

                                <?php echo form_close(); ?>
                            </div>
                            <div class="search-results-ajax">
                                <div class="search-results-location">
                                    <div id="response_search_location"></div>
                                </div>
                            </div>
                            <div id="location_id_inputs">
                                <input type="hidden" name="country" value="<?= $this->default_location->country_id; ?>" class="input-location-filter">
                                <input type="hidden" name="state" value="<?= $this->default_location->state_id; ?>" class="input-location-filter">
                                <input type="hidden" name="city" value="<?= $this->default_location->city_id; ?>" class="input-location-filter">
                            </div>
                        </div>
                        <div class="form-group" style="visibility:hidden;">
                            <button type="button" id="btn_submit_location" class="btn btn-md btn-custom btn-block"><?php echo trans("update_location"); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($this->auth_check) : ?>
        <?php if (!get_fssai_action($this->auth_user->id)) : ?>
            <div class="modal fade" data-backdrop="static" id="fssai_undertakingModal" role="dialog">
                <div class="modal-dialog modal-dialog-centered fssai-modal">
                    <!-- Modal content-->
                    <?php echo form_open("agree-fssai-undertaking", ['name' => 'agree_fssai_undertaking']); ?>
                    <input type="hidden" name="action" value="1">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h3 class="text_center">Seller Undertaking</h3>
                            <p>SAI order & its directions for Labelling and Display regulation shall be enforced from November 16, 2021.</p>
                            <ol>
                                <li>Change in Non-veg Logo (from circular shape to triangular shape)</li>
                                <li>llergen Declaration is mandatory on the food product label</li>
                                <li>Additional nutritional information for food with more than one ingredient (added Sugar, Salt, etc.)</li>
                                <li>Symbol (X) for food materials sold on retail that are not meant for human consumption (E.g: Pooja oil, Ghee for diyas, Pooja water, etc.)</li>
                                <li>Expiry Date and Use by Date declaration on the Label.</li>

                            </ol>
                            <p class="text_center fssai_link"><a href="<?php echo base_url() . 'assets/file/fssai_undertaking_doc.pdf'; ?>" target="_blank">Click here for more details</a></p>
                            <p>By clicking on the Accept button, I agree that I have read and acknowledged the FSSAI order & its directions for Labelling and Display regulation.</p>
                            <div class="text_center">
                                <button id="submit-fssai-btn" type="button" class="btn btn-custom">I Accept</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <script>
                $(function() {
                    $('#fssai_undertakingModal').modal('show');
                })
                $("#submit-fssai-btn").click(function() {
                    $("form[name='agree_fssai_undertaking']").submit();
                })
            </script>
        <?php endif; ?>
    <?php endif; ?>
    <?php if ($this->auth_check && $this->general_settings->rate_previous_order) : ?>
        <?php $order_id['order_id'] =  $this->product_model->get_order_id($this->auth_user->id); ?>
        <?php if (!empty($order_id['order_id'])) : ?>
            <?php $order['product_id'] = $this->product_model->get_order_product_id($order_id['order_id']->order_id, $this->auth_user->id); ?>
            <?php foreach ($order['product_id'] as $order1) : ?>
                <?php $not_rating['exist'] = $this->product_model->get_not_rating_product($order1->product_id, $this->auth_user->id); ?>
                <?php if (empty($not_rating['exist'])) : ?>
                    <?php $this->load->view('partials/_modal_rate_last_order');
                    break;
                    ?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
    <!-- <style>
        #pageloader {
            background: rgba(0, 0, 0, 0.8);
            display: none;
            height: 100%;
            position: fixed;
            width: 100%;
            z-index: 9999;
        }

        #pageloader img {
            left: 50%;
            margin-left: -32px;
            margin-top: -32px;
            position: absolute;
            top: 50%;
        }
    </style> -->

    <!-- <div id="pageloader">
        <img src="http://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif" alt="processing..." />
    </div> -->

    <div id="menu-overlay"></div>
    <script>
        window.onload = function() {

            var pageTitle = document.title;
            var attentionMessage = '<?php echo trans('miss_you'); ?>';
            var blinkEvent = null;

            document.addEventListener('visibilitychange', function(e) {
                var isPageActive = !document.hidden;

                if (!isPageActive) {
                    blink();



                } else {
                    document.title = pageTitle;


                    clearInterval(blinkEvent);
                    var links = document.getElementsByTagName("link");

                    filtered = [],
                        i = links.length;
                    while (i--) {
                        links[i].rel === "shortcut icon" && filtered.push(links[i]);
                    }
                    filtered[0].href = "<?php echo get_favicon($this->general_settings); ?>";


                }
            });

            function blink() {
                blinkEvent = setInterval(function() {
                    if (document.title === attentionMessage) {
                        document.title = pageTitle;
                        var links = document.getElementsByTagName("link");

                        filtered = [],
                            i = links.length;
                        while (i--) {
                            links[i].rel === "shortcut icon" && filtered.push(links[i]);
                        }
                        filtered[0].href = "<?php echo get_favicon($this->general_settings); ?>";
                    } else {
                        document.title = attentionMessage;
                        var links = document.getElementsByTagName("link");

                        filtered = [],
                            i = links.length;
                        while (i--) {
                            links[i].rel === "shortcut icon" && filtered.push(links[i]);
                        }
                        filtered[0].href = "<?php echo base_url(); ?>assets/img/envelope_letter.jpg";
                    }
                }, 100);
            }
        };
    </script>
    <!-- <script>
        /**
         * The following code will modify the title of the browser tab on the "blur" event
         * and change it back to the original on the "focus" event.
         */

        // Store the original tab title
        // Consider storing it in localStorage if you need it across the site
        let origTitle = document.title;

        // Change title when focusing on tab
        function oldTitle() {
            document.title = origTitle;
        }

        // Function to change title when un-focusing on tab
        function newTitle() {
            document.title = 'We miss you!';
        }

        // Bind functions to blur and focus events
        window.onblur = newTitle; 
        window.onfocus = oldTitle;


        var cont = 0;
        setInterval(function() {
            if (cont % 2) {
                var myText = oldTitle;
            } else {
                var myText = 'We miss you';
            }
            cont++;
            $('#tittletoggle').html(myText);
        }, 1000);
    </script> -->


    <script>
        var rtl = false;
    </script>
    <?php if ($this->rtl == true) : ?>
        <script>
            var rtl = true;
        </script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/rtl.min.css">
    <?php endif; ?>
    <?php echo $this->general_settings->custom_css_codes; ?>
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBilDMME_y5HiUbj-hbgukMXlvoX4kuJnc&libraries=geometry&language=en&callback" async defer></script> -->


    <!-- chat systems  -->
    <!-- <script src="<?php echo base_url(); ?>assets/js/bootstrap-notify.js"></script> -->

    <?php if ($this->general_settings->is_tawkto_enable == 1) : ?>
        <script type="text/javascript">
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = 'https://embed.tawk.to/60083af3c31c9117cb70a2a8/1esg2ci5l';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
    <?php endif; ?>
    <!-- chat system end -->

    <!-- whatsaap chat -->
    <?php if ($this->general_settings->is_whatsapp_enable == 1) : ?>
        <script src="https://apps.elfsight.com/p/platform.js" defer></script>
        <div class="elfsight-app-d7fdd3c2-f5cd-4c43-9351-85fc2f13684f"></div>
    <?php endif; ?>
    <!-- whatsapp end -->
    <?php if ($this->general_settings->is_tawkto_enable == 1) : ?>
        <!-- <script>
            var def_tawk_bottom = "20px"; /*This is their default style that I want to change*/
            var def_tawk_right = "16px"; /*This is their default style that I want to change*/
            var customize_tawk = ""; /*Interval object*/

            function customize_tawk_widget() {
                var cur_bottom = jQuery("iframe[title='chat widget']").eq(0).css('bottom'); /*Get the default style*/
                var cur_right = jQuery("iframe[title='chat widget']").eq(0).css('right'); /*Get the default style*/
                if (cur_bottom == def_tawk_bottom && cur_right == def_tawk_right) {
                    /*Check if the default style exists then remove it and add my custom style*/
                    jQuery("iframe[title='chat widget']").eq(0).css({
                        'right': '2px',
                        'bottom': '64px'
                    });
                    jQuery("iframe[title='chat widget']").eq(0).addClass("custom-chat-widget");
                    clearInterval(customize_tawk);
                }
            }

            /*Customize the widget as soon as the widget is loaded*/
            Tawk_API = Tawk_API || {};
            Tawk_API.onLoad = function() {
                /*Only for mobile version*/
                if (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent)) {
                    var customize_tawk = setInterval(customize_tawk_widget, 100);
                }
            };

            /*Customize the widget as soon as the widget is minimized*/
            Tawk_API = Tawk_API || {};
            Tawk_API.onChatMinimized = function() {
                /*Only for mobile version*/
                if (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent)) {
                    var customize_tawk = setInterval(customize_tawk_widget, 100);
                }
            };
        </script> -->
    <?php endif; ?>


    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-199516838-1"></script>

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-199516838-1');
    </script>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KGZRFDN" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

    <!-- End Google Tag Manager (noscript) -->

    <!-- this scrip is provided by sakshi -->
    <script>
        (function(h, e, a, t, m, p) {
            m = e.createElement(a);
            m.async = !0;
            m.src = t;
            p = e.getElementsByTagName(a)[0];
            p.parentNode.insertBefore(m, p);
        })(window, document, 'script', 'https://u.heatmap.it/log.js');
        $("#verify_otp").click(function(e) {
            document.getElementById("verify_mobile_span").innerHTML = "";
            var phn_num = document.getElementById("phone_number").value;
            var email_address = document.getElementById("email_new").value;
            email_address = email_address.toLowerCase();
            console.log(email_address);
            if (phn_num == '') {
                document.getElementById("verify_mobile_span").innerHTML = "*Please enter mobile number !";
            } else if (email_address == "") {
                document.getElementById("email_span_error").innerHTML = "";
                document.getElementById("email_span_error").innerHTML = "Please enter email address";
            } else if (IsEmail(email_address) == false) {
                document.getElementById("email_span_error").innerHTML = "";
                document.getElementById("email_span_error").innerHTML = "Please enter a valid email address";
                //invalid emailid
            } else if (phn_num != '' && phn_num.length == 10 && email_address != "") {
                if (phn_num.length != 10) {
                    document.getElementById("verify_mobile_span").innerHTML = "";
                }
                if (email_address != "") {
                    document.getElementById("email_span_error").innerHTML = "";
                }
                var register_phn = check_for_mobile_registered_user_js(phn_num);
                var register_email = check_for_email_registered_user_js(email_address);
                // var register_phn = true;
                // var register_email = true;
                // console.log(register_phn);
                if (register_email == true) {
                    if (register_phn == true) {
                        var emailcheck = "<?php echo $this->general_settings->check_email_validation; ?>";
                        if (emailcheck === "1") {
                            var email = email_address;
                            var name = email.substring(0, email.lastIndexOf("@"));
                            var domain = email.substring(email.lastIndexOf("@") + 1);
                            if (domain == "gmail.com") {

                                var data = {
                                    'email': email_address
                                }
                                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                                $.ajax({
                                    type: "POST",
                                    url: base_url + "api/email/verifyemail",
                                    data: data,
                                    success: function(response) {


                                        var resp = $.parseJSON(response);

                                        if (resp.status == 200) {
                                            $('#verifyMobileModal').modal('show');
                                            send_verification_otp(phn_num, "mobile_otp", email_address);
                                        } else if (resp.status == 303) {
                                            $('#email_span_error').html(resp.message);
                                        } else if (resp.status == 304) {
                                            $('#email_span_error').html(resp.message);
                                        }
                                    }
                                });
                            } else {

                                $('#verifyMobileModal').modal('show');
                                send_verification_otp(phn_num, "mobile_otp", email_address);

                            }


                        } else {
                            $('#verifyMobileModal').modal('show');
                            send_verification_otp(phn_num, "mobile_otp", email_address);
                        }
                    } else if (register_phn == false) {
                        document.getElementById("verify_mobile_span").innerHTML = "*Mobile number is already registered!";
                    }
                } else if (register_email == false) {
                    document.getElementById("verify_mobile_span").innerHTML = "*Email id is already registered!";
                }
            }
        })
    </script>
    <script>
        //Open dropdown when clicking on element
        $(document).on('click', "a[data-dropdown='notificationMenu']", function(e) {
            e.preventDefault();

            var el = $(e.currentTarget);

            // $('body').prepend('<div id="dropdownOverlay" style="background: transparent; height:100%;width:100%;position:fixed;"></div>')

            var container = $(e.currentTarget).parent();
            var dropdown = container.find('.dropdown');
            var containerWidth = container.width();
            var containerHeight = container.height();

            var anchorOffset = $(e.currentTarget).offset();

            dropdown.css({
                'right': containerWidth / 2 + 'px'
            })

            container.toggleClass('expanded')

        });

        //Close dropdowns on document click

        // $(document).click(function() {
        //     $(".dropdown").hide();
        // });
        // $(document).on('click', '#dropdownOverlay', function(e) {
        //     var el = $(e.currentTarget)[0].activeElement;

        //     if (typeof $(el).attr('data-dropdown') === 'undefined') {
        //         $('#dropdownOverlay').remove();
        //         $('.dropdown-container.expanded').removeClass('expanded');
        //     }
        // })

        //Dropdown collapsile tabs
        $('.notification-tab').click(function(e) {
            if ($(e.currentTarget).parent().hasClass('expanded')) {
                $('.notification-group').removeClass('expanded');
            } else {
                $('.notification-group').removeClass('expanded');
                $(e.currentTarget).parent().toggleClass('expanded');
            }
        })
    </script>
    <!-- <script>
        /* When the user clicks on the button, 
        toggle between hiding and showing the dropdown content */
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }
        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var myDropdown = document.getElementById("myDropdown");
                var i;
                for (i = 0; i < myDropdown.length; i++) {
                    var openDropdown = myDropdown[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script> -->