<?php defined('BASEPATH') or exit('No direct script access allowed');
get_index_settings(); ?>

<div class="top-bar-mobile" id="top-bar-mobile">
    <div class="container">
        <div class="row">
            <div class="col-12 text_center">

                <?php echo form_open(generate_url('search_pincode'), ['id' => 'form_validate_pincode_mobile_search', 'class' => 'form_search_pincode_mobile_main form-inline', 'method' => 'get']); ?>
                <div class="text-bold"><?php echo trans("pincode_delivery_text"); ?></div>
                <div class="input-group round-border">
                    <input type="text" name="search_pincode" class="clearable_mobile_search form-control" style="border-radius: 20px" id="search_pincode_mobile" maxlength="6" minlength="6" pattern="[0-9]+" id="input_search_pincode" class="form-control input-search" value="<?php echo (!empty($_SESSION["modesy_sess_user_location"])) ? $_SESSION["modesy_sess_user_location"] : ''; ?>" autocomplete="off">
                    <input type="hidden" class="search_type_input_pincode" name="search_type_pincode" value="pincode">
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-success">Check !</button>
                    </span>
                </div>

                <?php echo form_close(); ?>

            </div>
            <div id="response_pincode_search_mobile_results" class="search-results-ajax"></div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('#search_pincode_mobile').keypress(function(e) {

            var charCode = (e.which) ? e.which : event.keyCode

            if (String.fromCharCode(charCode).match(/[^0-9]/g))

                return false;

        });
        if ($('#search_pincode_mobile').val()) {
            $('#search_pincode_mobile')[togM($('#search_pincode_mobile').val())]("xm");
        }

    });

    function togM(v) {
        return v ? "addClass" : "removeClass";
    }
    $(document).on("mousemove", ".xm", function(e) {
        $(this)[tog(this.offsetWidth - 18 < e.clientX - this.getBoundingClientRect().left)]("onmX");
    }).on("touchstart click", ".onmX", function(ev) {
        ev.preventDefault();
        $(this).removeClass("xm onmX").val("").change();
        $("#form_validate_pincode_mobile_search").submit();
    });



    var lastScrollTop = 0;
    $(window).scroll(function() {
        var st = $(this).scrollTop();
        if (st < 0) {
            st = 0;
        }
        var banner = $('.top-bar-mobile');
        setTimeout(function() {
            if (st > lastScrollTop) {
                banner.addClass('hide');
            } else {
                banner.removeClass('hide');
            }
            lastScrollTop = st;
        }, 100);
    });
</script>