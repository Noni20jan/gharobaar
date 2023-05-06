<div id="loading-coupon">
    <img id="loading-image" src="<?php echo base_url() . 'assets/gif/ajax-loader.gif'; ?>" alt="Loading..." />
</div>
<div>
    <?php if (isset($this->auth_user)) : ?>
        <?php
        if ($this->auth_user->user_type != "guest") :
        ?>
            <div class="coupons-div-header">Offers &amp; Coupons</div>
            <div class="coupons-div-content">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" class="coupons-div-couponIcon">
                    <g fill="none" fill-rule="evenodd" transform="rotate(45 6.086 5.293)">
                        <path stroke="#000" d="M17.5 10V1a1 1 0 0 0-1-1H5.495a1 1 0 0 0-.737.323l-4.136 4.5a1 1 0 0 0 0 1.354l4.136 4.5a1 1 0 0 0 .737.323H16.5a1 1 0 0 0 1-1z"></path>
                        <circle cx="5.35" cy="5.35" r="1.35" fill="#000" fill-rule="nonzero"></circle>
                    </g>
                </svg>
                <div class="coupons-div-label" id="coupons-div-label">
                    <?php if (!empty($this->session->userdata('mds_shopping_cart_coupon'))) :
                        $coupon_applied = $this->session->userdata('mds_shopping_cart_coupon');
                        echo "1 Coupon Applied<div class='coupon-div-applied-label'>" . strtoupper($coupon_applied->offer_code) . "</div>";
                    else : echo "Apply Coupons";
                    endif; ?>
                </div>
                <div>
                    <?php
                    if (isset($this->auth_user)) :
                    ?><?php
                        if ($this->auth_user->user_type != "guest") :
                        ?>
                    <button class="coupons-div-button <?php echo (!empty($this->session->userdata('mds_shopping_cart_coupon'))) ? "hide-coupon-button" : ""; ?>" id="coupons-div-button-apply">APPLY</button>

                <?php
                        endif;
                ?>
            <?php
                    else :
            ?>
                <button class="coupons-div-button" id="coupons-div-button-apply1">APPLY</button>
                <!-- <a href="javascript:void(0)"class="coupons-div-button" style="margin-top:-33px;" data-toggle="modal" data-target="#loginModal" id="header-login">Apply</a> -->
            <?php
                    endif;
            ?>

            <button class="coupons-div-button-remove <?php echo (!empty($this->session->userdata('mds_shopping_cart_coupon'))) ? "" : "hide-coupon-button"; ?>" id="coupons-div-button-remove">REMOVE</button>
                </div>
                <div id="coupon-popup-div"></div>
            </div>
</div>
<?php else :  ?>
    <div class="coupons-div-header">Offers &amp; Coupons</div>
    <div class="coupons-div-content">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" class="coupons-div-couponIcon">
            <g fill="none" fill-rule="evenodd" transform="rotate(45 6.086 5.293)">
                <path stroke="#000" d="M17.5 10V1a1 1 0 0 0-1-1H5.495a1 1 0 0 0-.737.323l-4.136 4.5a1 1 0 0 0 0 1.354l4.136 4.5a1 1 0 0 0 .737.323H16.5a1 1 0 0 0 1-1z"></path>
                <circle cx="5.35" cy="5.35" r="1.35" fill="#000" fill-rule="nonzero"></circle>
            </g>
        </svg>
        <div class="coupons-div-label" id="coupons-div-label">
            <?php if (!empty($this->session->userdata('mds_shopping_cart_coupon'))) :
                $coupon_applied = $this->session->userdata('mds_shopping_cart_coupon');
                echo "1 Coupon Applied<div class='coupon-div-applied-label'>" . strtoupper($coupon_applied->offer_code) . "</div>";
            else : echo "Apply Coupons";
            endif; ?>
        </div>
        <div>
            <?php
            if (isset($this->auth_user)) :
            ?><?php
                if ($this->auth_user->user_type != "guest") :
                ?>
            <button class="coupons-div-button <?php echo (!empty($this->session->userdata('mds_shopping_cart_coupon'))) ? "hide-coupon-button" : ""; ?>" id="coupons-div-button-apply">APPLY</button>

        <?php
                else :
        ?>
            <a href="javascript:void(0)" data-toggle="modal" data-id="0" class="coupons-div-button" data-target=" #registerModal" class="link">Apply</a>
            <!-- <button class="coupons-div-button" id="coupons-div-button-apply1">APPLY</button> -->
        <?php
                endif;
        ?>
    <?php
            else :
    ?>
        <button class="coupons-div-button" id="coupons-div-button-apply1">APPLY</button>
        <!-- <a href="javascript:void(0)"class="coupons-div-button" style="margin-top:-33px;" data-toggle="modal" data-target="#loginModal" id="header-login">Apply</a> -->
    <?php
            endif;
    ?>

    <button class="coupons-div-button-remove <?php echo (!empty($this->session->userdata('mds_shopping_cart_coupon'))) ? "" : "hide-coupon-button"; ?>" id="coupons-div-button-remove">REMOVE</button>
        </div>
        <div id="coupon-popup-div"></div>
    </div>
    </div>
<?php
        endif;
?>
<?php
    else :
?>
    <div class="coupons-div-header">Offers &amp; Coupons</div>
    <div class="coupons-div-content">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" class="coupons-div-couponIcon">
            <g fill="none" fill-rule="evenodd" transform="rotate(45 6.086 5.293)">
                <path stroke="#000" d="M17.5 10V1a1 1 0 0 0-1-1H5.495a1 1 0 0 0-.737.323l-4.136 4.5a1 1 0 0 0 0 1.354l4.136 4.5a1 1 0 0 0 .737.323H16.5a1 1 0 0 0 1-1z"></path>
                <circle cx="5.35" cy="5.35" r="1.35" fill="#000" fill-rule="nonzero"></circle>
            </g>
        </svg>
        <div class="coupons-div-label" id="coupons-div-label">
            <?php if (!empty($this->session->userdata('mds_shopping_cart_coupon'))) :
                $coupon_applied = $this->session->userdata('mds_shopping_cart_coupon');
                echo "1 Coupon Applied<div class='coupon-div-applied-label'>" . strtoupper($coupon_applied->offer_code) . "</div>";
            else : echo "Apply Coupons";
            endif; ?>
        </div>
        <div>
            <?php
            if (isset($this->auth_user)) :
            ?><?php
                if ($this->auth_user->user_type != "guest") :
                ?>
            <button class="coupons-div-button <?php echo (!empty($this->session->userdata('mds_shopping_cart_coupon'))) ? "hide-coupon-button" : ""; ?>" id="coupons-div-button-apply">APPLY</button>

        <?php
                else :
        ?>
            <button class="coupons-div-button" id="coupons-div-button-apply1">APPLY</button>
        <?php
                endif;
        ?>
    <?php
            else :
    ?>
        <button class="coupons-div-button" id="coupons-div-button-apply1">APPLY</button>
        <!-- <a href="javascript:void(0)"class="coupons-div-button" style="margin-top:-33px;" data-toggle="modal" data-target="#loginModal" id="header-login">Apply</a> -->
    <?php
            endif;
    ?>

    <button class="coupons-div-button-remove <?php echo (!empty($this->session->userdata('mds_shopping_cart_coupon'))) ? "" : "hide-coupon-button"; ?>" id="coupons-div-button-remove">REMOVE</button>
        </div>
        <div id="coupon-popup-div"></div>
    </div>
    </div>
<?php
    endif;
?>


<script>
    $(document).on("input keyup paste change", "#coupon-input-field", function() {
        if ($(this).val().length > 0) {
            $("#couponsForm-applyButton").addClass("couponsForm-enabled");
        } else {
            $("#couponsForm-applyButton").removeClass("couponsForm-enabled");
        }
    });

    $(document).on("click", "#coupons-div-button-apply", function() {
        var data = {
            "sys_lang_id": sys_lang_id,
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "load-popup-coupon",
            data: data,
            beforeSend: function() {
                $('#loading-coupon').show();
            },
            success: function(response) {
                document.getElementById("coupon-popup-div").innerHTML = response;
                setTimeout(function() {
                    $('#loading-coupon').hide()
                    $('#couponModalCenter').modal('show');
                }, 200);
            }
        });
    });

    $(document).on("click", "#coupons-div-button-remove", function() {
        remove_coupon_ajax(true);
    });
</script>

<script>
    function copy(copyValue) {
        var copy = copyValue;
        console.log(copy[0].innerText)
        $('#coupon-input-field').val(copy[0].innerText).change();
        // for (const copied of copy) {
        //     copied.addEventListener("copy", function(event) {
        //         if (event.clipboardData) {
        //             event.clipboardData.setData("text/plain", copied.textContent);
        //             console.log(event.clipboardData.getData("text"))
        //             $("#coupon-input-field").val(event.clipboardData.getData("text")).change();
        //         };
        //         event.preventDefault();
        //     });
        //     document.execCommand("copy");
        // };
    }
</script>
<script>
    $('#coupons-div-button-apply1').click(function() {
        $('#loginModal').modal('show');
    })
</script>