<div class="text-center">
    <div class="spinner-border" role="status">
        <span class="sr-only">Processing</span>
    </div>
    <div class="" role="">
        <span class="">Processing</span>
    </div>
    Your payment is in progress. Please do not refresh the page or click the "Back" or "Close" button of your browser.
</div>
<input type="hidden" value="<?php echo $orderd; ?>" id="order_id">
<input type="hidden" value="<?php echo $ordertoken; ?>" id="ordertoken">
<script>
    $(document).ready(function() {

        var order_id = document.getElementById('order_id').value;
        var order_token = document.getElementById('ordertoken').value;
        console.log(order_id);
        window.location.href = base_url +
            "cashfree-return?orderId={" + order_id + "}&token={" + order_token + "}";
    });
</script>