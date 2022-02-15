<?php defined('BASEPATH') or exit('No direct script access allowed');
get_index_settings(); ?>
<style>
    @media only screen and (max-width: 1024px) {

        #check_availability {
            color: #fff;
            position: relative;
            font-weight: bold;

            top: 20px;
            right: 0px
        }
    }

    @media only screen and (max-width: 1024px) {
        #enter_pincode {
            border-radius: 20px;
            border: none;
            position: relative;
            bottom: 8px;
            left: 343px;
        }
    }

    @media only screen and (max-width: 1024px) {
        #check_pincode {
            position: relative;
            background-color: #007C05;
            color: #fff;
            border: none;
            bottom: 7px;
            top: 51%;
            font-weight: bold;
            left: 339px
        }
    }
</style>

<div class="top-bar" id="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-8 col-left">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <div id="check_availability">
                            <?php echo trans("pincode_delivery_text"); ?>
                        </div>
                    </li>
                    <li class="nav-item">
                        <?php echo form_open(generate_url('search_pincode'), ['id' => 'form_validate_pincode_search', 'class' => 'form_search_pincode_main form-inline', 'method' => 'get']); ?>

                        <input type="text" name="search_pincode" class="clearable_search form-control" id="search_pincode" maxlength="6" minlength="6" pattern="[0-9]+" class="form-control input-search" value="<?php echo (!empty($_SESSION["modesy_sess_user_location"])) ? $_SESSION["modesy_sess_user_location"] : ''; ?>" placeholder="<?php echo trans("search_pincode"); ?>" autocomplete="off">
                        <input type="hidden" class="search_type_input_pincode" name="search_type_pincode" value="pincode">
                        <button id="check_pincode">Check !</button>
                        <div id="response_pincode_search_results" class="search-results-ajax"></div>
                        <?php echo form_close(); ?>
                    </li>
                </ul>
            </div>
            <div class="col-4 col-right">
                <ul class="navbar-nav">
                    <?php if (item_count($this->countries) > 0) : ?>
                        <!-- <li class="nav-item">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#locationModal" class="nav-link btn-modal-location">
                                <i class="icon-map-marker"></i><?= !empty($this->default_location_input) ? $this->default_location_input : trans("location"); ?>
                            </a>
                        </li> -->
                    <?php endif; ?>
                    <?php if ($this->general_settings->multilingual_system == 1 && count($this->languages) > 1) : ?>
                        <li class="nav-item dropdown language-dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                <img src="<?php echo base_url($this->selected_lang->flag_path); ?>" class="flag"><?php echo html_escape($this->selected_lang->name); ?><i class="icon-arrow-down"></i>
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
                    <?php if ($this->auth_check) : ?>
                        <li class="nav-item dropdown profile-dropdown p-r-0">
                            <a class="nav-link dropdown-toggle a-profile" data-toggle="dropdown" href="javascript:void(0)" aria-expanded="false">
                                <img src="<?php echo get_user_avatar($this->auth_user); ?>" alt="<?php echo get_shop_name($this->auth_user); ?>">
                                <?php if ($unread_message_count > 0) : ?>
                                    <span class="notification"><?php echo $unread_message_count; ?></span>
                                <?php endif; ?>
                                <?php echo character_limiter(get_shop_name($this->auth_user), 15, '..'); ?>
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
                                        <a href="<?= generate_dash_url("profile"); ?>">
                                            <!-- <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/house.png" alt="" style="width: 20px; height: 20px;" /> -->
                                            <?php echo trans("supplier_panel"); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo generate_dash_url("buyer_panel"); ?>">
                                            <!-- <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/house.png" alt="" style="width: 20px; height: 20px;" /> -->
                                            Buyer Panel
                                        </a>
                                    </li>

                                <?php endif; ?>
                                <?php if ($this->auth_user->role == "member") { ?>
                                    <li>
                                        <a href="<?php echo dashboard_url(); ?>">
                                            <!-- <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/house.png" alt="" style="width: 20px; height: 20px;" /> -->
                                            Buyer Panel
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php if (!is_user_vendor()) : ?>
                                    <li>
                                        <a href="<?php echo generate_dash_url("profile"); ?>">
                                            <!-- <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/profile-icon.png" alt="" style="width: 20px; height: 20px;" /> -->
                                            <?php echo trans("profile"); ?>
                                        </a>
                                    </li>


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
                                <!-- <li>
                                    <a href="<?php echo generate_url("messages"); ?>">
                                        <img src="<?php echo base_url(); ?>assets/img/dashboard-icons/comment-icon.jpg" alt="" style="width: 20px; height: 20px;" />
                                        <?php echo trans("messages"); ?>&nbsp;<?php if ($unread_message_count > 0) : ?>
                                        <span class="span-message-count"><?php echo $unread_message_count; ?></span>
                                    <?php endif; ?>
                                    </a>
                                </li> -->

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
                    <?php else : ?>
                        <li class="nav-item">
                            <a href="javascript:void(0)" data-toggle="modal" data-id="0" data-target="#registerModal" class="nav-link open-via-header" style="font-weight:700;color: #fff;"><?php echo trans("register"); ?></a>
                            <span class="auth-sep"></span>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#loginModal" class="new-top-bar-login"><?php echo trans("login"); ?></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<style>
    @media (max-width:700px) {
        .new-top-bar-login {
            background-color: #CECECE;
            border-color: #222222;
            color: black;
            padding: 0px 10px;
            text-align: center;
            display: inline-block;
            border-radius: 20px;
            font-weight: bolder;
            position: relative;
            top: 13px;
        }
    }

    .new-top-bar-login {
        background-color: #CECECE;
        border-color: #222222;
        color: black;
        padding: 0px 10px;
        text-align: center;
        display: inline-block;
        border-radius: 20px;
        font-weight: bolder;
        position: relative;
        top: 7px;
    }
</style>

<script>
    $(document).ready(function() {

        $('#search_pincode').keypress(function(e) {

            var charCode = (e.which) ? e.which : event.keyCode

            if (String.fromCharCode(charCode).match(/[^0-9]/g))

                return false;

        });
        if ($('#search_pincode').val()) {
            $('#search_pincode')[tog($('#search_pincode').val())]("x");
        }

    });

    function tog(v) {
        return v ? "addClass" : "removeClass";
    }
    $(document).on("mousemove", ".x", function(e) {
        $(this)[tog(this.offsetWidth - 18 < e.clientX - this.getBoundingClientRect().left)]("onX");
    }).on("touchstart click", ".onX", function(ev) {
        ev.preventDefault();
        $(this).removeClass("x onX").val("").change();
        $("#form_validate_pincode_search").submit();
    });
</script>