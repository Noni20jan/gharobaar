<style>
    @media (min-width: 480px) {
        .couponsForm-textInputContainer {
            border: 1px solid #d5d6d9;
            padding: 11px 16px 14px;
        }
    }

    .couponsForm-textInputContainer {
        position: relative;
        height: 44px;
        font-size: 14px;
        box-sizing: border-box;
        padding-top: 10px;
        border-radius: 4px;
        margin-bottom: 4px;
    }

    .couponsForm-textInputError {
        border: 1px solid #ff5722;
        padding: 11px 16px 14px;
    }

    .couponsForm-textInputContainer .couponsForm-base-textInput {
        caret-color: #d21f3c;
        padding: 0;
        border: none;
        width: 70%;
        outline: 0;
    }

    .couponsForm-textInputContainer .couponsForm-applyButton {
        position: absolute;
        top: 11px;
        right: 16px;
        font-size: 14px;
        color: #d21f3c;
        font-weight: 600;
        letter-spacing: 1px;
        cursor: not-allowed;
    }

    .couponsForm-textInputContainer .couponsForm-enabled {
        color: #d21f3c;
        cursor: pointer;
    }

    @media (min-width: 480px) {
        .couponsForm-errorMessage {
            margin-top: 4px;
            margin-bottom: 4px;
        }
    }

    .couponsForm-errorMessage {
        text-align: left;
        color: #ff5722;
        font-size: 12px;
        min-height: 20px;
    }

    .coupon_code_apply {
        color: #d21f3c;
        border: 1px dashed #d21f3c;
        border-radius: 3px;
        padding: 8px 12px;
        padding-right: 15px;
        font-weight: 900;
    }

    .coupon_code_block {
        padding: 8px 12px;
        padding-left: 15px;
        padding-right: 15px;
        font-weight: 500;
        max-height: 40vh;
        overflow-y: scroll;
    }

    .next_coupon {
        margin-bottom: 15px;
        border-bottom: 1px solid lightgray;
    }

    .copy {

        cursor: copy;

    }
</style>

<div class="modal fade" id="couponModalCenter" tabindex="-1" role="dialog" aria-labelledby="couponModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" class="modal-base-cancelIcon ">
                            <path fill="#000" fill-rule="evenodd" d="M9.031 8l6.756-6.756a.731.731 0 0 0 0-1.031.732.732 0 0 0-1.031 0L8 6.969 1.244.213a.732.732 0 0 0-1.031 0 .731.731 0 0 0 0 1.03L6.969 8 .213 14.756a.731.731 0 0 0 0 1.031.732.732 0 0 0 1.031 0L8 9.031l6.756 6.756a.732.732 0 0 0 1.031 0 .731.731 0 0 0 0-1.03L9.031 8z"></path>
                        </svg>
                    </span>
                </button>
                <h5 class="modal-title" id="exampleModalLongTitle">Apply Coupons</h5>
            </div>
            <div class="modal-body">
                <div class="couponsForm-textInputContainer">
                    <input id="coupon-input-field" class="couponsForm-base-textInput" placeholder="Enter coupon code">
                    <div class="couponsForm-applyButton" id="couponsForm-applyButton">APPLY</div>
                </div>
                <div class="couponsForm-errorMessage"></div>
                <div class="col-sm-12 coupon_code_block">
                    <?php if (!empty($all_coupons)) :
                        foreach ($all_coupons as $coupons) : ?>
                            <div class="next_coupon">
                                <div style="margin-bottom: 10px;">
                                    <span onclick="copy($(this))" class="coupon_code_apply copy"><?php echo $coupons->offer_code; ?></span>
                                </div>
                                <!-- <div> <?php echo $coupons->discount_percentage; ?> </div>
                    <div> <?php echo $coupons->allowed_max_discount; ?> </div>
                    <div> <?php echo $coupons->min_amt_in_cart; ?> </div> -->
                                <div> <?php echo $coupons->msg_to_be_displayed; ?> </div>
                                <div> <?php echo $coupons->description; ?> </div>
                                <div>Expires on : <?php echo $coupons->end_date; ?> </div>
                                <!-- <div> <?php echo $coupons->terms_and_conditions; ?> </div> -->
                            </div>
                    <?php endforeach;
                    endif; ?>
                </div>

            </div>
            <div class=" modal-footer">
                <!-- <button type="button" class="btn btn-custom text-large">Apply</button> -->
            </div>
        </div>
    </div>
</div>