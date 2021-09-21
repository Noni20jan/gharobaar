<style>
    .coupons-div-header {
        font-weight: bolder;
        font-size: 18px;
        padding: 0px 0px 7px 0px;
    }

    .coupons-div-content {
        padding-bottom: 12px;
        position: relative;
        border-bottom: 1px solid #f5f5f6;
        padding-left: 36px;
    }

    .coupons-div-label {
        font-weight: 600;
        font-size: 14px;
        line-height: 16px;
        padding: 7px 0;
    }

    .coupons-div-couponIcon {
        position: absolute;
        left: 0;
        top: 7px;
    }

    .coupons-div-button {
        float: right;
        padding: 4px 16px;
        position: absolute;
        color: #007C05;
        border: 1px solid #007C05;
        border-radius: 3px;
        text-transform: none;
        cursor: pointer;
        font-weight: 600;
        top: 0;
        right: 0;
        background: #fff;
        font-size: 12px;
    }

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

    .couponsForm-textInputContainer .couponsForm-base-textInput {
        caret-color: #007C05;
        padding: 0;
        border: none;
        width: 75%;
        outline: 0;
    }

    .couponsForm-textInputContainer .couponsForm-applyButton {
        position: absolute;
        top: 11px;
        right: 16px;
        font-size: 14px;
        color: #007C0577;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .couponsForm-textInputContainer .couponsForm-enabled {
        color: #007C05;
    }
</style>
<div>
    <div class="coupons-div-header">Offers &amp; Coupons</div>
    <div class="coupons-div-content">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" class="coupons-div-couponIcon">
            <g fill="none" fill-rule="evenodd" transform="rotate(45 6.086 5.293)">
                <path stroke="#000" d="M17.5 10V1a1 1 0 0 0-1-1H5.495a1 1 0 0 0-.737.323l-4.136 4.5a1 1 0 0 0 0 1.354l4.136 4.5a1 1 0 0 0 .737.323H16.5a1 1 0 0 0 1-1z"></path>
                <circle cx="5.35" cy="5.35" r="1.35" fill="#000" fill-rule="nonzero"></circle>
            </g>
        </svg>
        <div class="coupons-div-label">Apply Coupons</div>
        <div><button class="coupons-div-button" data-toggle="modal" data-target="#exampleModalCenter">APPLY</button></div>
    </div>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                        <div class="couponsForm-applyButton" id="couponsForm-applyButton">CHECK</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-custom text-large">Apply</button>
                </div>
            </div>
        </div>
    </div>
</div>