<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo html_escape($title); ?> - <?php echo html_escape($this->general_settings->application_name); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" type="image/png" href="<?php echo get_favicon($this->general_settings); ?>" />
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Bootstrap select css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/bootstrap-select.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/icheck/square/purple.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/admin/vendor/icheck/square/blue.css">
    <!-- Datatables -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/datatables/jquery.dataTables_themeroller.css">
    <!-- New Datatables -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/newdatatables/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/newdatatables/css/fixedHeader.dataTables.min.css">
    <!-- Tags Input -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/tagsinput/jquery.tagsinput.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/pace/pace.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/plugins.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/_all-skins.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/main-1.7.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css" />
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
    <script src="<?php echo base_url(); ?>assets/admin/js/jquery.min.js"></script>

    <!-- New Datatables Js -->

    <script src="<?php echo base_url(); ?>assets/admin/vendor/newdatatables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/vendor/newdatatables/js/dataTables.fixedHeader.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
        var base_url = "<?= base_url(); ?>";
        var csfr_token_name = "<?= $this->security->get_csrf_token_name(); ?>";
        var csfr_cookie_name = "<?= $this->config->item('csrf_cookie_name'); ?>";
        var sys_lang_id = "<?= $this->selected_lang->id; ?>";
    </script>

</head>

<body class="hold-transition skin-blue sidebar-mini">
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
                            <li>
                                <a class="btn btn-sm btn-success pull-left btn-site-prev" target="_blank" href="<?php echo base_url(); ?>"><i class="fa fa-eye"></i> <?php echo trans("view_site"); ?></a>
                            </li>
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="<?php echo get_user_avatar($this->auth_user); ?>" class="user-image" alt="">
                                    <span class="hidden-xs"><?php echo $this->auth_user->username; ?> <i class="fa fa-caret-down"></i> </span>
                                </a>

                                <ul class="dropdown-menu  pull-right" role="menu" aria-labelledby="user-options">
                                    <li>
                                        <a href="<?php echo dashboard_url(); ?>">
                                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/dashboard.png" alt="" style="width: 20px; height: 20px;" />
                                            <?php echo trans("dashboard"); ?></a>
                                    </li>
                                    <li>
                                        <a href="<?php echo generate_profile_url($this->auth_user->slug); ?>">
                                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/profile-icon.png" alt="" style="width: 20px; height: 20px;" />
                                            <?php echo trans("profile"); ?></a>
                                    </li>
                                    <li>
                                        <a href="<?php echo generate_url("settings"); ?>">
                                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/update-profile-icon.jpg" alt="" style="width: 20px; height: 20px;" />
                                            <?php echo trans("update_profile"); ?></a>
                                    </li>
                                    <li>
                                        <a href="<?php echo generate_url("settings", "change_password"); ?>">
                                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/general-settings.png" alt="" style="width: 20px; height: 20px;" />
                                            <?php echo trans("change_password"); ?></a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>logout">
                                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/logout.ico" alt="" style="width: 20px; height: 20px;" />
                                            <?php echo trans("logout"); ?></a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar" style="background-color: #343B4A;">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar sidebar-scrollbar">
                <!-- Logo -->
                <a href="<?php echo admin_url(); ?>" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b><?php echo html_escape($this->general_settings->application_name); ?></b> <?php echo trans("panel"); ?></span>
                </a>
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="<?php echo get_user_avatar($this->auth_user); ?>" class="img-circle" alt="">
                    </div>
                    <div class="pull-left info">
                        <p><?php echo $this->auth_user->username; ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> <?php echo trans("online"); ?></a>
                    </div>
                </div>
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header"><?php echo trans("navigation"); ?></li>
                    <li class="nav-home">
                        <a href="<?php echo admin_url(); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/house.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("home"); ?></span>
                        </a>
                    </li>
                    <li class="nav-navigation">
                        <a href="<?php echo admin_url(); ?>navigation">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/navigation.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("navigation"); ?></span>
                        </a>
                    </li>
                    <li class="nav-slider">
                        <a href="<?php echo admin_url(); ?>slider">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/slider.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("slider"); ?></span>
                        </a>
                    </li>
                    <li class="nav-homepage-manager">
                        <a href="<?php echo admin_url(); ?>homepage-manager">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/homepage-manager.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("homepage_manager"); ?></span>
                        </a>
                    </li>
                    <li class="header"><?php echo trans("membership"); ?></li>
                    <li class="treeview<?php is_admin_nav_active(['membership-plans', 'transactions-membership']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/membership.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("membership"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-membership-plans"><a href="<?php echo admin_url(); ?>membership-plans"> <?php echo trans("membership_plans"); ?></a></li>
                            <li class="nav-transactions-membership"><a href="<?php echo admin_url(); ?>transactions-membership"> <?php echo trans("transactions"); ?></a></li>
                        </ul>
                    </li>
                    <li class="nav-shop-opening-requests">
                        <a href="<?php echo admin_url(); ?>shop-opening-requests">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/shop-opening.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("shop_opening_requests"); ?></span>
                        </a>
                    </li>
                    <li class="nav-update-profile-requests">
                        <a href="<?php echo admin_url(); ?>update-profile-requests">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/shop-opening.png" alt="" style="width: 20px; height: 20px;" />
                            <span>Update Profile Requests</span>
                        </a>
                    </li>
                    <li class="nav-shop-opening-requests">
                        <a href="<?php echo admin_url(); ?>bank-approve-details">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/shop-opening.png" alt="" style="width: 20px; height: 20px;" />
                            <span>Approve Bank Details</span>
                        </a>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['add-administrator', 'administrators', 'vendors', 'members', 'edit-user']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/profile-icon.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("users"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-add-administrator"><a href="<?php echo admin_url(); ?>add-administrator"> <?php echo trans("add_administrator"); ?></a></li>
                            <li class="nav-administrators"><a href="<?php echo admin_url(); ?>administrators"> <?php echo trans("administrators"); ?></a></li>
                            <li class="nav-vendors"><a href="<?php echo admin_url(); ?>vendors"> <?php echo trans("vendors"); ?></a></li>
                            <li class="nav-members"><a href="<?php echo admin_url(); ?>members"> <?php echo trans("members"); ?></a></li>
                            <li class="nav-featured-vendors"><a href="<?php echo admin_url(); ?>featured_vendors"> <?php echo ("Featured Vendors"); ?></a></li>
                        </ul>
                    </li>

                    <li class="header"><?php echo trans("orders"); ?></li>
                    <li class="treeview<?php is_admin_nav_active(['orders', 'transactions', 'order-bank-transfers', 'invoices', 'order-details']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/order-icon.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("orders"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-orders"><a href="<?php echo admin_url(); ?>orders"> <?php echo trans("orders"); ?></a></li>
                            <li class="nav-transactions"><a href="<?php echo admin_url(); ?>transactions"> <?php echo trans("transactions"); ?></a></li>
                            <li class="nav-order-bank-transfers"><a href="<?php echo admin_url(); ?>order-bank-transfers"> <?php echo trans("bank_transfer_notifications"); ?></a></li>
                            <li class="nav-invoices"><a href="<?php echo admin_url(); ?>invoices"> <?php echo trans("invoices"); ?></a></li>
                            <li class="nav-refunds"><a href="<?php echo admin_url(); ?>refunds"> <?php echo trans("refunds"); ?></a></li>
                        </ul>
                    </li>
                    <li class="nav-digital-sales">
                        <a href="<?php echo admin_url(); ?>digital-sales">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/digi-sales.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("digital_sales"); ?></span>
                        </a>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['earnings', 'seller-balances', 'update-seller-balance']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/earnings.jpg" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("earnings"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-earnings"><a href="<?php echo admin_url(); ?>earnings"> <?php echo trans("earnings"); ?></a></li>
                            <li class="nav-earnings"><a href="<?php echo admin_url(); ?>penalties"> <?php echo trans("penalties"); ?></a></li>
                            <li class="nav-seller-balances"><a href="<?php echo admin_url(); ?>seller-balances"> <?php echo trans("seller_balances"); ?></a></li>
                        </ul>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['add-payout', 'payout-requests', 'completed-payouts', 'payout-settings']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/payment-icon.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("payouts"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-add-payout"><a href="<?php echo admin_url(); ?>add-payout"> <?php echo trans("add_payout"); ?></a></li>
                            <!-- <li class="nav-payout-requests"><a href="<?php echo admin_url(); ?>payout-requests"> <?php echo trans("payout_requests"); ?></a></li> -->
                            <li class="nav-payout-requests"><a href="<?php echo admin_url(); ?>initiate-payout"> <?php echo trans("payout_requests"); ?></a></li>
                            <!-- <li class="nav-completed-payouts"><a href="<?php echo admin_url(); ?>completed-payouts"> <?php echo trans("completed_payouts"); ?></a></li>
                            <li class="nav-payout-settings"><a href="<?php echo admin_url(); ?>payout-settings"> <?php echo trans("payout_settings"); ?></a></li> -->
                        </ul>
                    </li>
                    <li class="header"><?php echo trans("products"); ?></li>
                    <li class="treeview<?php is_admin_nav_active(['products', 'special-offers', 'pending-products', 'hidden-products', 'expired-products', 'drafts', 'deleted-products', 'product-details']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/products-icon.jpg" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("products"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo admin_url(); ?>products"> <?php echo trans("approved-products"); ?></a></li>
                            <li class="nav-special-offers"><a href="<?php echo admin_url(); ?>special-offers"> <?php echo trans("special_offers"); ?></a></li>
                            <li class="nav-pending-products"><a href="<?php echo admin_url(); ?>pending-products"> <?php echo trans("pending_products"); ?></a></li>
                            <li class="nav-hidden-products"><a href="<?php echo admin_url(); ?>hidden-products"> <?php echo trans("hidden_products"); ?></a></li>
                            <?php if ($this->general_settings->membership_plans_system == 1) : ?>
                                <li class="nav-expired-products"><a href="<?php echo admin_url(); ?>expired-products"> <?php echo trans("expired_products"); ?></a></li>
                            <?php endif; ?>
                            <li class="nav-drafts"><a href="<?php echo admin_url(); ?>drafts"> <?php echo trans("drafts"); ?></a></li>
                            <li class="nav-deleted-products"><a href="<?php echo admin_url(); ?>deleted-products"> <?php echo trans("deleted_products"); ?></a></li>
                            <li><a href="<?php echo generate_dash_url("add_product"); ?>" target="_blank"> <?php echo trans("add_product"); ?></a></li>
                            <li><a href="<?php echo generate_dash_url("bulk_product_upload"); ?>"> <?php echo trans("bulk_product_upload"); ?></a></li>
                        </ul>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['featured-products', 'featured-products-pricing', 'featured-products-transactions']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/cart-icon.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("featured_products"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-featured-products"><a href="<?php echo admin_url(); ?>featured-products"> <?php echo trans("products"); ?></a></li>
                            <li class="nav-featured-products-pricing"><a href="<?php echo admin_url(); ?>featured-products-pricing"> <?php echo trans("pricing"); ?></a></li>
                            <li class="nav-featured-products-transactions"><a href="<?php echo admin_url(); ?>featured-products-transactions"> <?php echo trans("transactions"); ?></a></li>
                        </ul>
                    </li>
                    <li class="nav-quote-requests">
                        <a href="<?php echo admin_url(); ?>quote-requests">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/quote-req-icon.jpg" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("quote_requests"); ?></span>
                        </a>
                    </li>
                    <li class="nav-barte-requests">
                        <a href="<?php echo admin_url(); ?>barter-requests">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/barter-req-icon.png" alt="" style="width: 20px; height: 20px;" />
                            </i> <span>Barter Requests</span>
                        </a>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['categories', 'add-category', 'update-category', 'bulk-category-upload']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/categories.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("categories"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-categories"><a href="<?php echo admin_url(); ?>categories"> <?php echo trans("categories"); ?></a></li>
                            <li class="nav-add-category"><a href="<?php echo admin_url(); ?>add-category"> <?php echo trans("add_category"); ?></a></li>
                            <?php if (is_admin()) : ?>
                                <li class="nav-bulk-category-upload"><a href="<?php echo admin_url(); ?>bulk-category-upload"> <?php echo trans("bulk_category_upload"); ?></a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['features', 'add-feature', 'category-feature-relation', 'add-category-feature-relation']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/custom-feilds.svg" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("features"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>

                        <ul class="treeview-menu">
                            <li class="nav-features"><a href="<?php echo admin_url(); ?>features"><?php echo trans("features"); ?></a></li>
                            <li class="nav-add-feature"><a href="<?php echo admin_url(); ?>add-feature"><?php echo trans("add_feature"); ?></a></li>
                            <li class="nav-category-feature-relation"><a href="<?php echo admin_url(); ?>category-feature-relation"><?php echo trans("category_feature_relation"); ?></a></li>
                            <li class="nav-add-category-feature-relation"><a href="<?php echo admin_url(); ?>add-category-feature-relation"><?php echo trans("add_category_feature_relation"); ?></a></li>
                        </ul>

                    </li>
                    <li class="treeview<?php is_admin_nav_active(['add-custom-field', 'custom-fields', 'update-custom-field', 'custom-field-options']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/custom-feilds.svg" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("custom_fields"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-add-custom-field"><a href="<?php echo admin_url(); ?>add-custom-field"> <?php echo trans("add_custom_field"); ?></a></li>
                            <li class="nav-custom-fields"><a href="<?php echo admin_url(); ?>custom-fields"> <?php echo trans("custom_fields"); ?></a></li>
                        </ul>
                    </li>

                    <li class="header">Services</li>
                    <li class="treeview<?php is_admin_nav_active(['services', 'special-offers', 'pending-services', 'hidden-services', 'expired-services', 'drafts-service', 'deleted-services', 'service-details']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/service.png" alt="" style="width: 20px; height: 20px;" />
                            <span>Services</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo admin_url(); ?>services"> Services</a></li>
                            <li class="nav-special-offers"><a href="<?php echo admin_url(); ?>special-offers"> <?php echo trans("special_offers"); ?></a></li>
                            <li class="nav-pending-products"><a href="<?php echo admin_url(); ?>pending-services"> Pending Services</a></li>
                            <li class="nav-hidden-products"><a href="<?php echo admin_url(); ?>hidden-services">Hidden Services</a></li>
                            <?php if ($this->general_settings->membership_plans_system == 1) : ?>
                                <li class="nav-expired-products"><a href="<?php echo admin_url(); ?>expired-services"> <?php echo trans("expired_services"); ?></a></li>
                            <?php endif; ?>
                            <li class="nav-drafts"><a href="<?php echo admin_url(); ?>drafts-service"> <?php echo trans("drafts"); ?></a></li>
                            <li class="nav-deleted-products"><a href="<?php echo admin_url(); ?>deleted-services"> Deleted Service</a></li>
                            <li><a href="<?php echo generate_dash_url("add_service"); ?>" target="_blank"> <?php echo trans("add_service"); ?></a></li>
                            <li><a href="<?php echo generate_dash_url("bulk_service_upload"); ?>"> Bulk Service Upload</a></li>
                        </ul>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['featured-services', 'featured-services-pricing', 'featured-services-transactions']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/service.png" alt="" style="width: 20px; height: 20px;" />
                            <span>Featured Services</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-featured-products"><a href="<?php echo admin_url(); ?>featured-services"> Services</a></li>
                            <li class="nav-featured-products-pricing"><a href="<?php echo admin_url(); ?>featured-services-pricing"> <?php echo trans("pricing"); ?></a></li>
                            <li class="nav-featured-products-transactions"><a href="<?php echo admin_url(); ?>featured-services-transactions"> <?php echo trans("transactions"); ?></a></li>
                        </ul>
                    </li>



                    <li class="header"><?php echo trans("content"); ?></li>
                    <li class="treeview<?php is_admin_nav_active(['add-page', 'pages', 'update-page']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/pages.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("pages"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-add-page"><a href="<?php echo admin_url(); ?>add-page"> <?php echo trans("add_page"); ?></a></li>
                            <li class="nav-pages"><a href="<?php echo admin_url(); ?>pages"> <?php echo trans("pages"); ?></a></li>
                        </ul>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['blog-add-post', 'blog-posts', 'blog-categories', 'update-blog-post', 'update-blog-category']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/blog.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("blog"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-blog-add-post"><a href="<?php echo admin_url(); ?>blog-add-post"> <?php echo trans("add_post"); ?></a></li>
                            <li class="nav-blog-posts"><a href="<?php echo admin_url(); ?>blog-posts"> <?php echo trans("posts"); ?></a></li>
                            <li class="nav-blog-categories"><a href="<?php echo admin_url(); ?>blog-categories"> <?php echo trans("categories"); ?></a></li>
                        </ul>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['countries', 'states', 'cities', 'add-country', 'add-state', 'add-city', 'update-country', 'update-state', 'update-city']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/location.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("location"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-countries"><a href="<?php echo admin_url(); ?>countries"> <?php echo trans("countries"); ?></a></li>
                            <li class="nav-states"><a href="<?php echo admin_url(); ?>states"> <?php echo trans("states"); ?></a></li>
                            <li class="nav-cities"><a href="<?php echo admin_url(); ?>cities"> <?php echo trans("cities"); ?></a></li>
                        </ul>
                    </li>

                    <li class="header"><?php echo trans("management_tools"); ?></li>
                    <li class="nav-storage">
                        <a href="<?php echo admin_url(); ?>storage">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/storage.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("storage"); ?></span>
                        </a>
                    </li>
                    <li class="nav-cache-system">
                        <a href="<?php echo admin_url(); ?>cache-system">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/cache.jpg" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("cache_system"); ?></span>
                        </a>
                    </li>
                    <li class="nav-seo-tools">
                        <a href="<?php echo admin_url(); ?>seo-tools">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/seotools.jpeg" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("seo_tools"); ?></span>
                        </a>
                    </li>
                    <li class="nav-ad-spaces">
                        <a href="<?php echo admin_url(); ?>ad-spaces">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/adspaces.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("ad_spaces"); ?></span>
                        </a>
                    </li>
                    <li class="nav-contact-messages">
                        <a href="<?php echo admin_url(); ?>contact-messages">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/contact.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("contact_messages"); ?></span>
                        </a>
                    </li>
                    <li class="nav-reviews">
                        <a href="<?php echo admin_url(); ?>reviews">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/reviews-icon.jpg" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("reviews"); ?></span>
                        </a>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['pending-product-comments', 'pending-blog-comments', 'product-comments', 'blog-comments']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/comment-icon.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("comments"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if ($this->general_settings->comment_approval_system == 1) : ?>
                                <li class="nav-pending-product-comments"><a href="<?php echo admin_url(); ?>pending-product-comments"> <?php echo trans("product_comments"); ?></a></li>
                                <li class="nav-pending-blog-comments"><a href="<?php echo admin_url(); ?>pending-blog-comments"> <?php echo trans("blog_comments"); ?></a></li>
                            <?php else : ?>
                                <li class="nav-product-comments"><a href="<?php echo admin_url(); ?>product-comments"> <?php echo trans("product_comments"); ?></a></li>
                                <li class="nav-blog-comments"><a href="<?php echo admin_url(); ?>blog-comments"> <?php echo trans("blog_comments"); ?></a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['send-email-subscribers', 'subscribers']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/news.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("newsletter"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-send-email-subscribers">
                                <a href="<?php echo admin_url(); ?>send-email-subscribers"><?php echo trans("send_email_subscribers"); ?></a>
                            </li>
                            <li class="nav-subscribers">
                                <a href="<?php echo admin_url(); ?>subscribers"><?php echo trans("subscribers"); ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['send-email-members', 'members']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/news.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("Members"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-send-email-subscribers">
                                <a href="<?php echo admin_url(); ?>send-email-members"><?php echo trans("send_email_members"); ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="header text-uppercase"><?php echo trans("settings"); ?></li>
                    <li class="nav-preferences">
                        <a href="<?php echo admin_url(); ?>preferences">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/preferences .png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("preferences"); ?></span>
                        </a>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['form-settings']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/form.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("form_settings"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-form-settings"><a href="<?php echo admin_url(); ?>form-settings"> <?php echo trans("form_settings"); ?></a></li>
                            <li class="nav-form-settings-shipping-options"><a href="<?php echo admin_url(); ?>form-settings/shipping-options"> <?php echo trans("shipping_options"); ?></a></li>
                        </ul>
                    </li>
                    <li class="nav-payment-settings">
                        <a href="<?php echo admin_url(); ?>payment-settings">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/payment-icon.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("payment_settings"); ?></span>
                        </a>
                    </li>
                    <li class="nav-currency-settings">
                        <a href="<?php echo admin_url(); ?>currency-settings">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/earnings.jpg" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("currency_settings"); ?></span>
                        </a>
                    </li>
                    <li class="nav-email-settings">
                        <a href="<?php echo admin_url(); ?>email-settings">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/email.jpg" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("email_settings"); ?></span>
                        </a>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['visual-settings', 'font-settings']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/settings-icon.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("visual_settings"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-visual-settings"><a href="<?php echo admin_url(); ?>visual-settings"> <?php echo trans("visual_settings"); ?></a></li>
                            <li class="nav-font-settings"><a href="<?php echo admin_url(); ?>font-settings"> <?php echo trans("font_settings"); ?></a></li>
                        </ul>
                    </li>

                    <li class="treeview<?php is_admin_nav_active(['settings', 'languages', 'social-login', 'update-language', 'translations']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/general-settings.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("general_settings"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-settings"><a href="<?php echo admin_url(); ?>settings"> <?php echo trans("general_settings"); ?></a></li>
                            <li class="nav-languages"><a href="<?php echo admin_url(); ?>languages"> <?php echo trans("language_settings"); ?></a></li>
                            <li class="nav-social-login"><a href="<?php echo admin_url(); ?>social-login"> <?php echo trans("social_login"); ?></a></li>
                        </ul>
                    </li>

                    <li class="treeview<?php is_admin_nav_active(['system-settings', 'route-settings']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/system-settings.jpg" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("system_settings"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-system-settings"><a href="<?php echo admin_url(); ?>system-settings"> <?php echo trans("system_settings"); ?></a></li>
                            <li class="nav-route-settings"><a href="<?php echo admin_url(); ?>route-settings"> <?php echo trans("route_settings"); ?></a></li>
                        </ul>
                    </li>
                    <li class="header text-uppercase"><?php echo trans("offer_management"); ?></li>

                    <li class="treeview<?php is_admin_nav_active(['system-settings', 'route-settings']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/dashboard.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("dashboard"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-system-settings"><a href="<?php echo admin_url(); ?>offers-dashboard"> <?php echo trans("offers_dashboard"); ?></a></li>
                            <li class="nav-system-settings"><a href="<?php echo admin_url(); ?>coupons-dashboard"> <?php echo trans("coupons_dashboard"); ?></a></li>
                            <li class="nav-system-settings"><a href="<?php echo admin_url(); ?>vouchers-dashboard"> <?php echo trans("voucher_dashboard"); ?></a></li>
                            <li class="nav-system-settings"><a href="<?php echo admin_url(); ?>consumption-dashboard"> <?php echo trans("consumption_dashboard"); ?></a></li>
                        </ul>
                    </li>
                    <li class="treeview<?php is_admin_nav_active(['system-settings', 'route-settings']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/offers.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans(""); ?>Offers</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-system-settings"><a href="<?php echo admin_url(); ?>create-offers">Offers Creation</a></li>
                            <li class="nav-system-settings"><a href="<?php echo admin_url(); ?>vouchers-users">Voucher Assignment</a></li>
                            <li class="nav-system-settings"><a href="<?php echo admin_url(); ?>category-coupon">Coupon Assignment</a></li>
                            <li class="nav-system-settings"><a href="<?php echo admin_url(); ?>products_coupons">View Assigned Coupon</a></li>
                            <li class="nav-system-settings"><a href="<?php echo admin_url(); ?>user_vouchers">View Assigned Vouchers</a></li>

                        </ul>
                    </li>
                    <li class="header text-uppercase"><?php echo trans("loyalty_program"); ?></li>
                    <li class="treeview<?php is_admin_nav_active(['Loyalty Program', 'program']); ?>">
                        <a href="#">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/news.png" alt="" style="width: 20px; height: 20px;" />
                            <span><?php echo trans("loyalty_program"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="nav-send-email-subscribers">
                                <a href="<?php echo admin_url(); ?>user-loyalty-program"><?php echo trans("user_loyalty_program"); ?></a>
                            </li>
                            <li class="nav-send-email-subscribers">
                                <a href="<?php echo admin_url(); ?>kpi-form"><?php echo trans("add_kpi"); ?></a>
                            </li>
                            <li class="nav-send-email-subscribers">
                                <a href="<?php echo admin_url(); ?>loyalty-criteria"><?php echo trans("loyalty_criteria"); ?></a>
                            </li>
                            <li class="nav-send-email-subscribers">
                                <a href="<?php echo admin_url(); ?>qualify-criteria"><?php echo trans("qualifying_criteria"); ?></a>
                            </li>
                            <li class="nav-send-email-subscribers">
                                <a href="<?php echo admin_url(); ?>qualified-user"><?php echo trans("qualified_user"); ?></a>
                            </li>
                        </ul>
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
                echo '.nav-' . $uri_string . ' > a{color: #fff !important;}';
            else :
                echo '.nav-home > a{color: #fff !important;}';
            endif; ?>
        </style>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">