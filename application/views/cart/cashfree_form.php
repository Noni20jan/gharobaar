<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<form id="redirectForm" method="post" action=<?= $this->general_settings->cashfree_base_url . $this->general_settings->cashfree_checkout_url ?>>
  <input type="hidden" name="appId" value="<?php echo $appId ?>" />
  <input type="hidden" name="orderId" value="<?php echo $orderId ?>" />
  <input type="hidden" name="orderAmount" value="<?php echo $orderAmount ?>" />
  <?php if($this->general_settings->enable_easysplit==1):?>
  <input type="hidden" name="paymentSplits" value="<?php echo $paymentSplits ?>" />
 <?php endif;?>
  <input type="hidden" name="customerName" value="<?php echo $customerName ?>" />
  <input type="hidden" name="customerPhone" value="<?php echo $customerPhone ?>" />
  <input type="hidden" name="customerEmail" value="<?php echo $customerEmail ?>" />
  <input type="hidden" name="returnUrl" value="<?php echo $returnUrl ?>" />
  <?php if (isset($paymentOption) && isset($paymentCode)) : ?>
    <?php if ($paymentOption == 'nb' || $paymentOption == 'wallet') : ?>
      <input type="hidden" name="paymentOption" value="<?php echo $paymentOption ?>" />
      <input type="hidden" name="paymentCode" value="<?php echo $paymentCode ?>" />
    <?php endif; ?>
  <?php endif; ?>
  <?php if (isset($paymentModes)) : ?>
    <?php if ($paymentModes == 'cc' || $paymentModes == 'dc' || $paymentModes == 'upi') : ?>
      <input type="hidden" name="paymentModes" value="<?php echo $paymentModes ?>" />
    <?php endif; ?>
  <?php endif; ?>
  <input type="hidden" name="signature" value="<?php echo $signature ?>" />
</form>

<script>
  document.getElementById("redirectForm").submit();
</script>