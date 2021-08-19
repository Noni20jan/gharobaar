<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<form id="redirectForm" method="post" action=<?= $this->general_settings->cashfree_base_url . $this->general_settings->cashfree_checkout_url ?>>
  <input type="hidden" name="appId" value="<?php echo $appId ?>" />
  <input type="hidden" name="orderId" value="<?php echo $orderId ?>" />
  <input type="hidden" name="orderAmount" value="<?php echo $orderAmount ?>" />
  <input type="hidden" name="customerName" value="<?php echo $customerName ?>" />
  <input type="hidden" name="customerPhone" value="<?php echo $customerPhone ?>" />
  <input type="hidden" name="customerEmail" value="<?php echo $customerEmail ?>" />
  <input type="hidden" name="returnUrl" value="<?php echo $returnUrl ?>" />
  <input type="hidden" name="signature" value="<?php echo $signature ?>" />
</form>

<script>
  document.getElementById("redirectForm").submit();
</script>