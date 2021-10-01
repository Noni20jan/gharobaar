<div id="loading-coupon">
    <img id="loading-image" src="<?php echo base_url() . 'assets/gif/ajax-loader.gif'; ?>" alt="Loading..." />
</div>
<div>
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
            <button class="coupons-div-button <?php echo (!empty($this->session->userdata('mds_shopping_cart_coupon'))) ? "hide-coupon-button" : ""; ?>" id="coupons-div-button-apply">APPLY</button>
            <button class="coupons-div-button-remove <?php echo (!empty($this->session->userdata('mds_shopping_cart_coupon'))) ? "" : "hide-coupon-button"; ?>" id="coupons-div-button-remove">REMOVE</button>
        </div>
        <div id="coupon-popup-div"></div>
    </div>
</div>
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


    $(document).on("click", ".couponsForm-enabled", function() {
        var coupon_code = $("#coupon-input-field").val();
        var data = {
            "sys_lang_id": sys_lang_id,
            "coupon_code": coupon_code
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "checked-availability-coupon",
            data: data,
            beforeSend: function() {
                $('#loading-coupon').show();
            },
            success: function(response) {
                var res = JSON.parse(response);
                $('#loading-coupon').hide();
                if (res.status) {
                    $(".couponsForm-textInputContainer").removeClass("couponsForm-textInputError");
                    $(".couponsForm-errorMessage").html("");
                    $("#coupons-div-button-apply").addClass("hide-coupon-button");
                    $("#coupons-div-button-remove").removeClass("hide-coupon-button");
                    $("#coupons-div-label").html("1 Coupon Applied<div class='coupon-div-applied-label'>" + res.coupon_data.offer_code.toUpperCase() + "</div>");
                    $('#couponModalCenter').modal('hide');
                    $('#coupon-discount-tag').removeClass('hide-coupon-discount');
                    $('#coupon-discount-text').html("- ₹" + res.cart_total.applied_coupon_discount / 100 + " /-");
                    $("#total_final")[0].innerText = "₹" + res.cart_total.total_price / 100 + "/-";
                    if (parseInt(res.cart_total.applied_coupon_discount) > 0) {
                        $("#coupon-discount-text")[0].innerText =
                            "- ₹" + res.cart_total.applied_coupon_discount / 100 + "/-";
                    } else {
                        switch (res.cart_total.applied_coupon_source_type) {
                            case "FREESHIP":
                                $("#coupon-discount-text")[0].innerText = "Less Shipping";
                                break;
                            case "EXHIBITION":
                                $("#coupon-discount-text")[0].innerText = "Less Shipping and COD";
                                break;
                        }
                    }

                } else {
                    $(".couponsForm-textInputContainer").addClass("couponsForm-textInputError");
                    $(".couponsForm-errorMessage").html(res.msg);
                }

            }
        });
    });
</script>

<script>
    function copy(copyValue) {
        var copy = copyValue;
        for (const copied of copy) {
            copied.addEventListener("copy", function(event) {
                event.preventDefault();
                if (event.clipboardData) {
                    event.clipboardData.setData("text/plain", copied.textContent);
                    console.log(event.clipboardData.getData("text"))
                    $("#coupon-input-field").val(event.clipboardData.getData("text")).change();
                };
            });
            document.execCommand("copy");
        };
    }
</script>