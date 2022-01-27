<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php
$user = get_user($this->auth_user->id);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= html_escape($title); ?> - <?= trans("dashboard"); ?> - <?= html_escape($this->general_settings->application_name); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" type="image/png" href="<?php echo get_favicon($this->general_settings); ?>" />
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/admin/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/font-icons/css/mds-icons.min.css" />
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/admin/vendor/bootstrap/css/bootstrap.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/icheck/square/purple.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/admin/vendor/icheck/square/blue.css">
    <!-- Datatables -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/admin/vendor/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/admin/vendor/datatables/jquery.dataTables_themeroller.css">
    <!-- Tags Input -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/admin/vendor/tagsinput/jquery.tagsinput.min.css">

    <link rel="stylesheet" href="<?= base_url(); ?>assets/admin/vendor/pace/pace.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/admin/vendor/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/admin/css/plugins.css">

    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/fselect.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/admin/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/admin/css/skin-black-light.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/file-uploader/css/jquery.dm-uploader.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/file-uploader/css/styles.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/file-manager/file-manager.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/admin/css/main-1.7.css">

    <!-- custom style style -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/custom.css">

    <link rel="stylesheet" href="<?= base_url(); ?>assets/admin/css/dashboard-1.7.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/slick-theme.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/slick.css" />
    <!-- chat systems  -->

    <!-- <script type="text/javascript">
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
    </script> -->
    <script>
        var directionality = "ltr";
    </script>
    <?php if ($this->rtl == true) : ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/rtl.css">
        <script>
            var directionality = "rtl";
        </script>
    <?php endif; ?>
    <!-- jQuery 3 -->
    <script src="<?= base_url(); ?>assets/admin/js/jquery.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/fselect.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/file-uploader/js/jquery.dm-uploader.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/file-uploader/js/ui.js"></script>
    <script src="<?= base_url(); ?>assets/js/plugins-1.7.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        var base_url = "<?= base_url(); ?>";
        var sys_lang_id = "<?= $this->selected_lang->id; ?>";
        var csfr_token_name = "<?= $this->security->get_csrf_token_name(); ?>";
        var csfr_cookie_name = "<?= $this->config->item('csrf_cookie_name'); ?>";
    </script>
    <style>
        .switch-field {
            display: flex;
            margin-top: 10px;
            margin-right: 10px;
            overflow: hidden;
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
            background-color: #e4e4e4;
            color: rgba(0, 0, 0, 0.6);
            font-size: 14px;
            line-height: 1;
            text-align: center;
            padding: 8px 16px;
            margin-right: -1px;
            border: 1px solid rgba(0, 0, 0, 0.2);
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
            transition: all 0.1s ease-in-out;
        }

        .switch-field label:hover {
            cursor: pointer;
        }

        .switch-field input:checked+label {
            background-color: #C00000;
            box-shadow: none;
            color: white;
        }

        .switch-field label:first-of-type {
            border-radius: 20px;
        }

        .switch-field label:last-of-type {
            border-radius: 20px;
        }

        /* This is just for CodePen. */

        .form {
            max-width: 600px;
            font-family: "Lucida Grande", Tahoma, Verdana, sans-serif;
            font-weight: normal;
            line-height: 1.625;
            margin: 8px auto;
            padding: 16px;
        }

        h2 {
            font-size: 18px;
            margin-bottom: 8px;
        }

        .nav_bar_color {
            background-color: white !important;
        }

        .header_color {
            color: #949CB4 !important;
            background: white !important;
        }
    </style>

    <script>
        function shopopenclose(asd, message) {
            var isChecked = $(asd).prop('checked');
            if (isChecked && (<?= $this->auth_user->is_shop_open ?> == $(asd).val())) {
                event.preventDefault();
                return false;
            } else {
                event.preventDefault();
                swal({
                        text: message,
                        icon: "warning",
                        buttons: [sweetalert_cancel, sweetalert_ok],
                        dangerMode: true,
                    })
                    .then(function(willDelete) {
                        if (willDelete) {
                            var base_url = '<?php echo base_url() ?>';
                            var is_shop_open = $(asd).val();
                            var data = {
                                is_shop_open: is_shop_open
                            };
                            data[csfr_token_name] = $.cookie(csfr_cookie_name);
                            $.ajax({
                                url: base_url + "auth_controller/shop_open_close",
                                method: "POST",
                                data: data,
                                success: function(data) {
                                    if (data != "") {
                                        location.reload();
                                    } else {
                                        alert("error");
                                    }
                                }
                            });
                        }
                    });
            }
        }
    </script>

</head>

<body class="hold-transition skin-black-light sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <div class="main-header-inner">
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- <?php if ($this->auth_user->is_shop_open == "1") { ?>
                                <li>
                                    <span style="color:#C00000;"> Welcome To Gharobaar , You are ready to sell your Product or service.<span>
                                </li>
                            <?php } else { ?>
                                <li>
                                    <span style="color:red;">
                                        Your Shop is Close , To Continue with Gharobaar Please Reopen your Shop.
                                    </span>
                                </li>
                            <?php } ?> -->
                            <li>
                                <div class="switch-field">
                                    <input type="radio" id="radio-one" name="is_shop_open" onclick="shopopenclose(this,'Are you sure to open the shop?')" value="1" <?php if ($this->auth_user->is_shop_open == "1") {
                                                                                                                                                                        echo "checked";
                                                                                                                                                                    } ?> />
                                    <label for="radio-one">Open Shop</label>
                                    <input type="radio" id="radio-two" name="is_shop_open" onclick="shopopenclose(this,'Are you sure to close the shop?')" value="0" <?php if ($this->auth_user->is_shop_open == "0") {
                                                                                                                                                                            echo "checked";
                                                                                                                                                                        } ?> />
                                    <label for="radio-two" title="Click here if you do not want to receive any new orders until you open shop again (your products would still be displayed on the website with a disclaimer)">Close Shop</label>
                                </div>
                            </li>
                            <!-- <li>
                                <a class="btn btn-sm btn-success pull-left btn-site-prev" target="_blank" href="<?php echo lang_base_url(); ?>"><i class="fa fa-eye"></i> &nbsp;<span class="btn-site-prev-text"><?php echo trans("view_site"); ?></span></a>
                            </li> -->
                            <?php if ($this->general_settings->multilingual_system == 1 && count($this->languages) > 1) : ?>
                                <li class="nav-item dropdown language-dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                        <img src="<?php echo base_url($this->selected_lang->flag_path); ?>" class="flag"><?php echo html_escape($this->selected_lang->name); ?> <i class="fa fa-caret-down"></i>
                                    </a>
                                    <div class="dropdown-menu">
                                        <?php foreach ($this->languages as $language) : ?>
                                            <a href="<?php echo get_language_dropdown_option($language); ?>" class="<?php echo ($language->id == $this->selected_lang->id) ? 'selected' : ''; ?> " class="dropdown-item">
                                                <img src="<?php echo base_url($language->flag_path); ?>" class="flag"><?php echo $language->name; ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="<?php echo get_user_avatar($this->auth_user); ?>" class="user-image" alt="">
                                    <span class="hidden-xs"><?= get_shop_name($this->auth_user); ?></span>&nbsp;<i class="fa fa-caret-down caret-profile"></i>
                                </a>

                                <ul class="dropdown-menu  pull-right" role="menu" aria-labelledby="user-options">
                                    <?php if ($this->auth_user->role == "admin") : ?>
                                        <li>
                                            <a href="<?php echo admin_url(); ?>"><i class="icon-admin"></i> <?php echo trans("admin_panel"); ?></a>
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <!-- <a href="<?php echo generate_profile_url($this->auth_user->slug); ?>"><i class="fa fa-user"></i> <?php echo trans("profile"); ?></a> -->
                                        <a href="<?php echo generate_dash_url("profile"); ?>"><img src="<?php echo base_url(); ?>assets/img/dashboard-icons/profile-icon.png" alt="" style="width: 15px; height: 15px;" /><?php echo trans("profile"); ?></a>
                                    </li>
                                    <li>
                                        <!-- <a href="<?php echo generate_url("settings"); ?>"><i class="fa fa-cog"></i> <?php echo trans("update_profile"); ?></a> -->
                                        <a href="<?php echo generate_dash_url("update_business_information"); ?>"><img src="<?php echo base_url(); ?>assets/img/dashboard-icons/update-profile-icon.jpg" alt="" style="width: 15px; height: 15px;" /><?php echo trans("update_profile"); ?></a>
                                    </li>
                                    <li>
                                        <a href="<?php echo generate_url("password_settings_seller"); ?>"><img src="<?php echo base_url(); ?>assets/img/dashboard-icons/settings-icon.png" alt="" style="width: 15px; height: 15px;" /><?php echo trans("change_password"); ?></a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>logout"><img src="<?php echo base_url(); ?>assets/img/dashboard-icons/logout.ico" alt="" style="width: 15px; height: 15px;" /></i> <?php echo trans("logout"); ?></a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class=" main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="nav_bar_color sidebar sidebar-scrollbar">
                <div class="logo">
                    <a href="<?php echo base_url(); ?>"><img src="<?php echo get_logo($this->general_settings); ?>" alt="logo"></a>
                </div>
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="image">
                        <!-- <img src="<?php echo base_url(); ?>assets/img/bronze-avatar.png" class="avatar-level" />    -->
                        <!-- style for seller image class="user-img-in-avatar" replace with the style given in img source   -->
                        <img src="<?php echo get_user_avatar($this->auth_user); ?>" style="border-radius:50%;" alt="">
                    </div>
                    <div class="username">
                        <p><?= trans("hi") . ", " . get_full_name($this->auth_user); ?></p>
                        <p><?= get_shop_name($this->auth_user); ?></p>
                    </div>
                </div>

                <!-- /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->

                <ul class="nav_bar_color sidebar-menu" data-widget="tree">
                    <?php if ($this->general_settings->seller_dashboard_navigation == 1) : ?>
                        <li class="header_color header">Dashboard</li>
                        <li class="nav-profile">
                            <a href="<?php echo generate_dash_url(""); ?>">
                                <span>Dashboard</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="header_color header">PROFILE</li>
                    <li class="nav-profile">
                        <a href="<?php echo generate_dash_url("profile"); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/profile-icon.png" alt="" style="width: 20px; height: 20px;" />
                            <span>Profile</span>
                        </a>
                    </li>
                    <li class="nav-update_business_information">
                        <a href="<?php echo generate_dash_url("update_business_information"); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/update-profile-icon.jpg" alt="" style="width: 20px; height: 20px;" />
                            <span>Update Profile</span>
                        </a>
                    </li>
                    <!-- <li class="nav-profile">
                        <a href="<?php echo generate_dash_url("loyalty-level"); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/update-profile-icon.jpg" alt="" style="width: 20px; height: 20px;" />
                            <span>loyalty level</span>
                        </a>
                    </li> -->
                    <!-- <?php if ($this->auth_user->supplier_type == "Goods") : ?>
                        <li class="nav-update_seller_info">
                            <a href="<?php echo generate_dash_url("update_seller_info"); ?>">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/bag-icon.png" alt="" style="width: 20px; height: 20px;" />
                                <span>Business Information</span>
                            </a>
                        </li>
                    <?php elseif ($this->auth_user->supplier_type == "Services") : ?>
                        <li class="nav-update_seller_info_services">
                            <a href="<?php echo generate_dash_url("update_seller_info_services"); ?>">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/bag-icon.png" alt="" style="width: 20px; height: 20px;" />
                                <span>Business Information</span>
                            </a>
                        </li>
                    <?php endif; ?> -->

                    <!-- <li class="header"><?php echo trans("navigation"); ?></li>
                    <li class="nav-home">
                        <a href="<?php echo dashboard_url(); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/house.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("dashboard"); ?></span>
                        </a>
                    </li> -->

                    <?php if ($this->is_sale_active) : ?>
                        <li class="header_color header"><?php echo trans("sales"); ?></li>
                        <li class="treeview<?php is_admin_nav_active(['sales', 'completed-sales', 'sale', 'pending_order', 'accepted_sales', 'awaiting_pickup', 'shipped', 'rejected_sales', 'cancelled_by_user', 'cancelled_by_seller']); ?>">
                            <a href="#">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/cart-icon.png" alt="" style="width: 20px; height: 20px;" />
                                <span><?php echo trans("orders"); ?></span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="nav-sales"><a href="<?= generate_dash_url("sales"); ?>"><?= trans("pending_order"); ?></a></li>
                                <!-- <li class="nav-accepted-sales"><a href="<?= generate_dash_url("accepted_sales"); ?>"><?= trans("accepted_sales"); ?></a></li> -->
                                <li class="nav-awaiting_pickup"><a href="<?= generate_dash_url("awaiting_pickup"); ?>"><?= trans("awaiting_pickup"); ?></a></li>
                                <li class="nav-shipped"><a href="<?= generate_dash_url("shipped"); ?>"><?= trans("shipped"); ?></a></li>
                                <li class="nav-completed-sales"><a href="<?= generate_dash_url("completed_sales"); ?>"><?= trans("completed_orders"); ?></a></li>
                                <li class="nav-rejected-sales"><a href="<?= generate_dash_url("rejected_sales"); ?>"><?= trans("rejected_sales"); ?></a></li>
                                <li class="nav-cancelled_by_user"><a href="<?= generate_dash_url("cancelled_by_user"); ?>"><?= trans("cancelled_by_user"); ?></a></li>
                                <li class="nav-cancelled_by_seller"><a href="<?= generate_dash_url("cancelled_by_seller"); ?>"><?= trans("cancelled_by_seller"); ?></a></li>
                                <li class="nav-cancelled_by_user"><a href="<?= generate_dash_url("return_orders"); ?>">Return Orders</a></li>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <li class="header_color header"><?php echo trans("payments"); ?></li>


                    <li class="nav-earnings">
                        <a href="<?= generate_dash_url("penalties"); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/earnings.jpg" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("penalties"); ?></span>
                        </a>
                    </li>
                    <?php if ($this->general_settings->enable_earning_payout == 1) : ?>
                        <li class="nav-earnings">
                            <a href="<?= generate_dash_url("earnings"); ?>">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/earnings.jpg" alt="" style="width: 20px; height: 20px;" />
                                <span><?php echo trans("earnings"); ?></span>
                            </a>
                        </li>

                        <li class="nav-earnings">
                            <a href="<?= generate_dash_url("total_earning"); ?>">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/earnings.jpg" alt="" style="width: 20px; height: 20px;" />
                                <span><?php echo "Total Earnings"; ?></span>
                            </a>
                        </li>

                        <li class="treeview<?php is_admin_nav_active(['withdraw-money', 'payouts', 'set-payout-account']); ?>">
                            <a href="#">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/payment-icon.png" alt="" style="width: 20px; height: 20px;" />
                                <!-- <i class="fa fa-credit-card-alt" style="font-size: 14px;"></i> -->
                                <span><?php echo trans("payouts"); ?></span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>

                        </li>
                    <?php endif ?>

                    <?php if ($this->general_settings->enable_seller_payout_report == 1) : ?>

                        <li class="treeview<?php is_admin_nav_active(['payment-history']); ?>">
                            <a href="#">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/payment-icon.png" alt="" style="width: 20px; height: 20px;" />
                                <span><?php echo trans("payment_history"); ?></span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <!-- <ul class="treeview-menu">
                            <? //php if ($this->general_settings->membership_plans_system == 1) : 
                            ?>
                                <li class="nav-payment-history"><a href="<?= generate_dash_url("payment_history"); ?>?payment=membership"><?= trans("membership_payments"); ?></a></li>
                            <? //php endif; 
                            ?>
                            <li class="nav-payment-history"><a href="<?= generate_dash_url("payment_history"); ?>?payment=promotion"><?= trans("promotion_payments"); ?></a></li>
                        </ul> -->
                            <ul class="treeview-menu">

                                <li class="nav-payouts"><a href="<?= generate_dash_url("initiatedallpayouts"); ?>"><?= ("Initiated Payouts"); ?></a></li>

                            </ul>
                        </li>
                    <?php endif ?>
                    <?php $barter_view = $this->general_settings->barter_view; ?>
                    <?php if ($barter_view == 1) { ?>
                        <li class="header_color header">Barter</li>
                        <li class="nav-add-product">
                            <a href="<?= generate_dash_url("barter_system"); ?>">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/barter-icon.png" alt="" style="width: 20px; height: 20px;" />
                                <span>Barter System</span>
                            </a>
                        </li>

                        <li class="nav-barter-requests">
                            <a href="<?= generate_dash_url("barter_requests"); ?>">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/barter-req-icon.png" alt="" style="width: 20px; height: 20px;" />
                                <span>Barter Requests</span>
                                <?php $new_quote_requests_count = get_new_barter_requests_count($this->auth_user->id);
                                if (!empty($new_quote_requests_count)) : ?>
                                    <span class="pull-right-container">
                                        <small class="label label-success pull-right"><?= $new_quote_requests_count; ?></small>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if (is_bidding_system_active()) : ?>
                        <li class="nav-quote-requests">
                            <a href="<?= generate_dash_url("quote_requests"); ?>">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/quote-req-icon.jpg" alt="" style="width: 20px; height: 20px;" />
                                <span><?php echo trans("quote_requests"); ?></span>
                                <?php $new_quote_requests_count = get_new_quote_requests_count($this->auth_user->id);
                                if (!empty($new_quote_requests_count)) : ?>
                                    <span class="pull-right-container">
                                        <small class="label label-success pull-right"><?= $new_quote_requests_count; ?></small>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </li>

                    <?php endif; ?>

                    <?php if ($user->supplier_type == "Goods") { ?>
                        <li class="header_color header"><?php echo trans("products"); ?></li>
                        <li class="nav-product-inventory">
                            <a href="<?= generate_dash_url("product_inventory"); ?>">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/product-upload-icon.png" alt="" style="width: 20px; height: 20px;" />
                                <span>Manage Product Inventory</span>
                            </a>
                        </li>
                        <li class="nav-add-product">
                            <a href="<?= generate_dash_url("add_product"); ?>">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/product-upload-icon.png" alt="" style="width: 20px; height: 20px;" />
                                <span><?php echo trans("add_product"); ?></span>
                            </a>
                        </li>
                        <!-- <li class="nav-bulk-product-upload">
                            <a href="<?= generate_dash_url("bulk_product_upload"); ?>">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/bulk-product-icon.png" alt="" style="width: 20px; height: 20px;" />
                                <span><?php echo trans("bulk_product_upload"); ?></span>
                            </a>
                        </li> -->
                        <?php if ($this->general_settings->enable_bulk_upload == 1) : ?>
                            <li class="nav-bulk-product-upload">
                                <a href="<?= generate_dash_url("bulk_product_upload_demo_file"); ?>">
                                    <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/bulk-product-icon.png" alt="" style="width: 20px; height: 20px;" />
                                    <span><?php echo trans("bulk_product_upload"); ?></span>
                                </a>
                            </li>
                        <?php endif; ?>


                        <li class="treeview<?php is_admin_nav_active(['products', 'pending-products', 'hidden-products', 'expired-products', 'drafts']); ?>">
                            <a href="#">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/products-icon.jpg" alt="" style="width: 20px; height: 20px;" />
                                <span><?php echo trans("products"); ?></span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="nav-products"><a href="<?= generate_dash_url("products"); ?>"><?= trans("approved-products"); ?></a></li>
                                <li class="nav-pending-products"><a href="<?= generate_dash_url("pending_products"); ?>"><?= trans("pending_products"); ?></a></li>
                                <li class="nav-hidden-products"><a href="<?= generate_dash_url("hidden_products"); ?>"><?= trans("hidden_products"); ?></a></li>
                                <!-- <li class="nav-products"><a href="<?= generate_dash_url("bulk_product"); ?>">Bulk Product Listing</a></li> -->

                                <?php if ($this->general_settings->membership_plans_system == 1) : ?>
                                    <li class="nav-expired-products"><a href="<?= generate_dash_url("expired_products"); ?>"><?= trans("expired_products"); ?></a></li>
                                <?php endif; ?>
                                <li class="nav-drafts"><a href="<?= generate_dash_url("drafts"); ?>"><?= trans("drafts"); ?></a></li>
                            </ul>
                        </li>
                    <?php } else if ($user->supplier_type == "Services") { ?>
                        <li class="header_color header">Service</li>

                        <li class="nav-add-product">
                            <a href="<?= generate_dash_url("add_service"); ?>">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/any-other-site-icon.png" alt="" style="width: 20px; height: 20px;" />
                                <span>Add Service</span>
                            </a>
                        </li>
                        <li class="nav-bulk-product-upload">
                            <a href="<?= generate_dash_url("bulk_service_upload"); ?>">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/any-other-site-icon.png" alt="" style="width: 20px; height: 20px;" />
                                <span>Bulk Service Upload</span>
                            </a>
                        </li>
                        <li class="treeview<?php is_admin_nav_active(['services', 'pending-services', 'hidden-services', 'expired-services', 'drafts-service']); ?>">
                            <a href="#">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/any-other-site-icon.png" alt="" style="width: 20px; height: 20px;" />
                                <span>Services</span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="nav-products"><a href="<?= generate_dash_url("services"); ?>">Services</a></li>
                                <li class="nav-pending-products"><a href="<?= generate_dash_url("pending_services"); ?>">Pending Services</a></li>
                                <li class="nav-hidden-products"><a href="<?= generate_dash_url("hidden_services"); ?>">Hidden Services</a></li>
                                <?php if ($this->general_settings->membership_plans_system == 1) : ?>
                                    <li class="nav-expired-products"><a href="<?= generate_dash_url("expired_services"); ?>">Expired Services</a></li>
                                <?php endif; ?>
                                <li class="nav-drafts"><a href="<?= generate_dash_url("drafts_service"); ?>"><?= trans("drafts"); ?></a></li>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <li class="header_color header"><?php echo trans("products"); ?></li>

                        <li class="nav-add-product">
                            <a href="<?= generate_dash_url("add_product"); ?>">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/any-other-site-icon.png" alt="" style="width: 20px; height: 20px;" />
                                <span><?php echo trans("add_product"); ?></span>
                            </a>
                        </li>
                        <li class="nav-bulk-product-upload">
                            <a href="<?= generate_dash_url("bulk_product_upload"); ?>">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/any-other-site-icon.png" alt="" style="width: 20px; height: 20px;" />
                                <span><?php echo trans("bulk_product_upload"); ?></span>
                            </a>
                        </li>
                        <li class="treeview<?php is_admin_nav_active(['products', 'pending-products', 'hidden-products', 'expired-products', 'drafts']); ?>">
                            <a href="#">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/products-icon.jpg" alt="" style="width: 20px; height: 20px;" />
                                <span><?php echo trans("products"); ?></span>

                            </a>
                            <ul class="treeview-menu">
                                <li class="nav-products"><a href="<?= generate_dash_url("products"); ?>"><?= trans("products"); ?></a></li>
                                <li class="nav-pending-products"><a href="<?= generate_dash_url("pending_products"); ?>"><?= trans("pending_products"); ?></a></li>
                                <li class="nav-hidden-products"><a href="<?= generate_dash_url("hidden_products"); ?>"><?= trans("hidden_products"); ?></a></li>
                                <?php if ($this->general_settings->membership_plans_system == 1) : ?>
                                    <li class="nav-expired-products"><a href="<?= generate_dash_url("expired_products"); ?>"><?= trans("expired_products"); ?></a></li>
                                <?php endif; ?>
                                <li class="nav-drafts"><a href="<?= generate_dash_url("drafts"); ?>"><?= trans("drafts"); ?></a></li>
                            </ul>
                        </li>
                        <li class="header_color header">Service</li>

                        <li class="nav-add-product">
                            <a href="<?= generate_dash_url("add_service"); ?>">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/any-other-site-icon.png" alt="" style="width: 20px; height: 20px;" />
                                <span>Add Service</span>
                            </a>
                        </li>
                        <li class="nav-bulk-product-upload">
                            <a href="<?= generate_dash_url("bulk_service_upload"); ?>">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/any-other-site-icon.png" alt="" style="width: 20px; height: 20px;" />
                                <span>Bulk Service Upload</span>
                            </a>
                        </li>
                        <li class="treeview<?php is_admin_nav_active(['services', 'pending-services', 'hidden-services', 'expired-services', 'drafts-service']); ?>">
                            <a href="#">
                                <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/any-other-site-icon.png" alt="" style="width: 20px; height: 20px;" />
                                <span>Services</span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="nav-products"><a href="<?= generate_dash_url("services"); ?>">Services</a></li>
                                <li class="nav-pending-products"><a href="<?= generate_dash_url("pending_services"); ?>">Pending Services</a></li>
                                <li class="nav-hidden-products"><a href="<?= generate_dash_url("hidden_services"); ?>">Hidden Services</a></li>
                                <?php if ($this->general_settings->membership_plans_system == 1) : ?>
                                    <li class="nav-expired-products"><a href="<?= generate_dash_url("expired_services"); ?>">Expired Services</a></li>
                                <?php endif; ?>
                                <li class="nav-drafts"><a href="<?= generate_dash_url("drafts-service"); ?>"><?= trans("drafts"); ?></a></li>
                            </ul>
                        </li>
                    <?php } ?>

                    <!-- <li class="header_color header"><?php echo trans("comments"); ?></li>
                    <li class="nav-comments">
                        <a href="<?= generate_dash_url("comments"); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/comment-icon.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("comments"); ?></span>
                        </a>
                    </li> -->
                    <li class="nav-reviews">
                        <a href="<?= generate_dash_url("reviews"); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/reviews-icon.jpg" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("reviews"); ?></span>
                        </a>
                    </li>
                    <!-- Reports section started -->
                    <?php if ($this->general_settings->seller_reports == 1 && $this->auth_user->id == 317) : ?>
                        <li class="header_color header"><?php echo trans("reports"); ?></li>
                        <li class="treeview">
                            <a href="#">
                                <img src="<?php echo base_url(); ?>assets/img/reports.jpg" alt="" style="width: 20px; height: 20px;" />
                                <!-- <i class="fa fa-credit-card-alt" style="font-size: 14px;"></i> -->
                                <span><?php echo trans("reports"); ?></span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="nav-payouts"><a href="<?= generate_dash_url("sales_data"); ?>"><?= trans("sales_data"); ?></a></li>
                                <li class="nav-payouts"><a href="<?= generate_dash_url("payment_reports"); ?>"><?= trans("payment_reports"); ?></a></li>
                                <li class="nav-payouts"><a href="<?= generate_dash_url("commission_bill"); ?>"><?= trans("commission_bill"); ?></a></li>
                                <li class="nav-payouts"><a href="<?= generate_dash_url("seller_ledgers"); ?>"><?= trans("sellers_ledgers"); ?></a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <!-- Report section end -->
                    <li class="header_color header"><?php echo trans("settings"); ?></li>
                    <li class="nav-shop-settings">
                        <a href="<?= generate_dash_url("shop_settings"); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/settings-icon.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("shop_settings"); ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo generate_url("password_settings_seller"); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/settings-icon.png" alt="" style="width: 20px; height: 20px;" />
                            <span>Change Password</span>
                        </a>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <?php
        $segment2 = @$this->uri->segment(2);
        $segment3 = @$this->uri->segment(3);

        $uri_string = $segment2;
        if (!empty($segment3)) {
            $uri_string .= '-' . $segment3;
        } ?>
        <style>
            <?php if (!empty($uri_string)) :
                echo '.nav-' . $uri_string . ' > a{color: #2C344C !important; background-color:#F7F8FC;}';
            else :
                echo '.nav-home > a{color: #2C344C !important; background-color:#F7F8FC;}';
            endif; ?>
        </style>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
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
                                    filtered[0].href = "<?php echo base_url(); ?>assets/img/envelope.jpg";
                                }
                            }, 100);
                        }
                    };
                </script>