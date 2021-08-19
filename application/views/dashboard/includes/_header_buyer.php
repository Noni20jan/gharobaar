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
            background-color: #DF911E;
            box-shadow: none;
        }

        .switch-field label:first-of-type {
            border-radius: 4px 0 0 4px;
        }

        .switch-field label:last-of-type {
            border-radius: 0 4px 4px 0;
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

        .header_color {
            color: #949CB4 !important;
            background: white !important;
        }

        .nav_bar_color {
            background-color: white !important;
        }
    </style>



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
                                    <?php if ($this->auth_user->role == "vendor") : ?>
                                        <li>
                                            <!-- <a href="<?php echo generate_url("settings"); ?>"><i class="fa fa-cog"></i> <?php echo trans("update_profile"); ?></a> -->
                                            <a href="<?php echo generate_dash_url("update_business_information"); ?>"><img src="<?php echo base_url(); ?>assets/img/dashboard-icons/update-profile-icon.jpg" alt="" style="width: 15px; height: 15px;" /><?php echo trans("update_profile"); ?></a>
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <a href="<?php echo generate_url("password_settings"); ?>"><img src="<?php echo base_url(); ?>assets/img/dashboard-icons/settings-icon.png" alt="" style="width: 15px; height: 15px;" /><?php echo trans("change_password"); ?></a>
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
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="nav_bar_color sidebar sidebar-scrollbar">
                <div class="logo">
                    <a href="<?php echo base_url(); ?>"><img src="<?php echo get_logo($this->general_settings); ?>" alt="logo"></a>
                </div>
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="image">
                        <img src="<?php echo get_user_avatar($this->auth_user); ?>" class="img-circle" alt="">
                    </div>
                    <div class="username">
                        <p><?= trans("hi") . ", " . get_full_name($this->auth_user); ?></p>

                    </div>
                </div>

                <!-- /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <!-- <li class="nav-home">
                        <a href="<?php echo dashboard_url(); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/house.png" alt="" style="width: 20px; height: 20px;" />
                            <span>Overview</span>
                        </a>
                    </li> -->
                    <li class="header_color header"><?php echo trans("orders"); ?></li>
                    <li class="nav-item <?php echo ($active_tab == 'orders_dashboard') ? 'active' : ''; ?>">
                        <a href="<?php echo generate_url("orders_dashboard"); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/order-icon.png" alt="" style="width: 20px; height: 20px;" />
                            <span>Orders</span>
                        </a>
                    </li>
                    <!-- <li class="nav-completed_orders_dashboard">
                        <a href="<?php echo generate_url("orders", "completed_orders_dashboard"); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/cart-icon.png" alt="" style="width: 20px; height: 20px;" />
                            <span>Completed Orders</span>
                        </a>
                    </li> -->
                    <!-- <li class="header_color header">CREDITS</li>
                    <li class="nav-credits">
                        <a href="<?php echo generate_dash_url("credits"); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/qoute-icon.jpg" alt="" style="width: 20px; height: 20px;" />
                            <span>Credits</span>
                        </a>
                    </li> -->
                    <!-- <li class="nav-coupans">
                        <a href="<?php echo generate_dash_url("coupans"); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/qoute-icon.jpg" alt="" style="width: 20px; height: 20px;" />
                            <span>Coupans</span>
                        </a>
                    </li> -->
                    <li class="header_color header">ACCOUNT</li>


                    <li class="nav-item  <?php echo ($active_tab == 'profile') ? 'active' : ''; ?>">
                        <a href="<?php echo generate_dash_url("buyer_panel"); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/profile-icon.png" alt="" style="width: 20px; height: 20px;" />
                            <span>Profile</span>
                        </a>
                    </li>

                    <li class="nav-item <?php echo ($active_tab == 'profile_settings') ? 'active' : ''; ?>">
                        <a href="<?php echo generate_url("profile_settings"); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/update-profile-icon.jpg" alt="" style="width: 20px; height: 20px;" />
                            <span>Update Profile</span>
                        </a>
                    </li>
                    <!-- <li class="nav-saved_cards">
                        <a href="<?php echo generate_dash_url("saved_cards"); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/card.png" alt="" style="width: 20px; height: 20px;" />
                            <span>Saved Cards</span>
                        </a>
                    </li> -->
                    <li class="nav-addresses">
                        <a href="<?php echo generate_dash_url("addresses"); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/location.png" alt="" style="width: 20px; height: 20px;" />
                            <span>Address</span>
                        </a>
                    </li>
                    <li class="header_color header"><?php echo trans("settings"); ?></li>

                    <li class="nav-item <?php echo ($active_tab == 'social_media_settings') ? 'active' : ''; ?>">
                        <a href="<?php echo generate_url("social_media_settings"); ?>">
                            <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/general-settings.png" alt="" style="width: 20px; height: 20px;" />
                            <span>Social Media</span>
                        </a>
                    </li>

                    <li class="nav-item <?php echo ($active_tab == 'password_settings') ? 'active' : ''; ?>">
                        <a href="<?php echo generate_url("password_settings"); ?>">
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