<?php
$coupons = get_coupon_codes();
?>
<div class="row">
    <div class="col-sm-12">
        <div class="">
            <div class="">

            </div><!-- /.box-header -->

            <div class="">
                <div class="row">
                    <?php foreach ($coupons as $coupon) : ?>
                        <?php if ($coupon->is_active == "1") : ?>
                            <div class="col-sm-6" style="margin-bottom: 1%;">
                                <div class="coupon-card">
                               
                                    <div>
                                        <div class="coupon-off-component sprites-couponBackGroundImage sprites-mymyntraCouponSprite">
                                            <div class="coupon-amount">
                                                <!-- react-text: 67 -->
                                                <!-- /react-text -->
                                                <!-- react-text: 68 --><?php echo $coupon->discount_rate . "%"; ?>
                                                <!-- /react-text -->
                                                <!-- react-text: 69 -->
                                                <!-- /react-text -->
                                            </div>
                                            <div class="coupon-offText">OFF </div>
                                        </div>
                                        <div class="coupon-info">

                                            <div><span class="coupon-label"> Code: </span><span class="coupon-coupon-code">
                                                    <input type="text" class="coupon_code" id="coupon_<?php echo $coupon->id; ?>" value="<?php echo $coupon->coupon_code; ?>" spellcheck="false">
                                                    <button onclick="myFunction('coupon_<?php echo $coupon->id; ?>')" class="copy_button"><span class="glyphicon glyphicon-copy copy_code"></span></button>
                                                  


                                                </span></div>
                                        </div>
                                    </div>
                                    <div class="coupon-coupon-detail"><span>Expiry: </span><span class="coupon-expiry-date"><?php echo $coupon->expiry_date; ?></span><span>
                                            <!-- react-text: 86 -->
                                            <!-- /react-text -->
                                            <!-- react-text: 87 --><?php echo $coupon->expiry_time; ?>
                                            <!-- /react-text -->
                                        </span><span class="coupon-details">
                                            <!-- react-text: 89 -->
                                            <!-- /react-text -->

                                            <!-- /react-text -->
                                            <!-- react-text: 91 -->
                                            <!-- /react-text -->
                                        </span>
                                        <ul>
                                            <li>
                                                On minimum purchase of
                                                <!-- react-text: 75 --> Rs.
                                                <!-- /react-text -->
                                                <!-- react-text: 76 --><?php echo $coupon->min_purchase; ?>
                                                <!-- /react-text -->

                                            </li>
                                            <li>
                                                <!-- react-text: 993 -->
                                                <!-- /react-text -->
                                                <!-- react-text: 994 --> Rs.<?php echo $coupon->max_amount; ?> off on minimum purchase of Rs. <?php echo $coupon->min_purchase; ?>
                                                <!-- /react-text -->
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div>

            </div>
        </div>
    </div>
</div>
<script>
    function myFunction(text) {
        var copyText = document.getElementById(text);
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        // echo("Copied the text: " + copyText.value);
        // document.getElementById("promo1").innerHTML = 'Copied to Clipboard';

        // setTimeout(function() {
        //     document.getElementById("promo1").innerHTML = '';
        // }, 3000);
    }
</script>