<?php

echo json_encode($_POST);

$orderId = $_POST["orderId"];
$orderAmount = $_POST["orderAmount"];
$referenceId = $_POST["referenceId"];
$txStatus = $_POST["txStatus"];
$paymentMode = $_POST["paymentMode"];
$txMsg = $_POST["txMsg"];
$txTime = $_POST["txTime"];
$signature = $_POST["signature"];
$data = $orderId . $orderAmount . $referenceId . $txStatus . $paymentMode . $txMsg . $txTime;
$secretKey = $this->general_settings->cashfree_secret_key;
$hash_hmac = hash_hmac('sha256', $data, $secretKey, true);
$computedSignature = base64_encode($hash_hmac);
if ($signature == $computedSignature) {
  // Proceed
  echo "<h1> Payment Successful</h1>";
} else {
  // Reject this call
  echo "<h1> Error in Payment</h1>";
}
