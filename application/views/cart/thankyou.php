<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
  @media only screen and (max-width: 600px) {
    .display-3 {
      font-size: 30px;
    }
  }

  .display-3 {
    font-size: 40px;
    font-weight: 500;
  }

  .btn-continue-shopping {
    background-color: #fff;
  }

  .btn:hover {
    background-color: #007C05 !important;

  }

  .btn-custom {
    color: black !important;

  }
</style>


<?php

$order = $this->order_model->get_order_by_order_number($order_number);
$order_products = $this->order_model->get_order_products($order->id);
//die();
// new json array for all product items
if (!empty($order_products)) :
  foreach ($order_products as $products) :

    $myObj = new stdClass();
    $myObj->item_id = $products->product_id;
    $myObj->item_name = $products->product_title;
    $myObj->affiliation = "";
    $myObj->coupon = "";
    $myObj->currency = $products->product_currency;
    $myObj->discount = $products->product_discount_amount;
    $myObj->index = "";
    $myObj->item_brand = "";
    $myObj->item_category = "";
    $myObj->item_category2 = "";
    $myObj->item_category3 = "";
    $myObj->item_category4 = "";
    $myObj->item_category5 = "";
    $myObj->item_list_id = "";
    $myObj->item_list_name = "";
    $myObj->item_variant = "";
    $myObj->location_id = "";
    $myObj->price = $products->product_unit_price;
    $myObj->quantity = $products->product_quantity;

    $myJSON = json_encode($myObj);

  // var_dump($myJSON);
  endforeach;
endif; ?>


<input type="hidden" id="role" value="<?php echo $this->auth_user->user_type; ?>">
<!-- header( "refresh:5;url=wherever.php" ); -->
<div class="container">
  <div class="wrapper">
    <div class="text-center">
      <div><i style="color:#007C05;padding-top: 30px" class='fas fa-check-circle fa-7x'></i><br /></div>
      <h1 class="display-3"><?php echo trans("thankyou_messsage") ?></h1>
    </div>
    <?php if ($this->auth_user->user_type != "guest") : ?>
      <?php if (!empty($order_number)) : ?>
        <div class="row">
          <div class="col-md-12 text-center">
            <p class="lead">
              <a class="btn btn-lg btn-custom btn-place-order" href='<?php echo (generate_url("order_details") . "/" . $order_number) ?>'><?php echo trans("thankyou_track_order") ?></a>
            </p>
          </div>
        </div>
      <?php endif; ?>


      <div class="row">
        <div class="col-md-12 text-center">
          <p class="lead">
            <a class="btn btn-lg btn-custom btn-continue-shopping" href='<?php echo (lang_base_url()) ?>'><?php echo trans("thankyou_continue_shopping") ?></a>
          </p>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php
if (empty($this->session->userdata('thankyou_order_id'))) {

  header("Refresh:2; url=" . lang_base_url());
}

?>
<!-- <script>
  $(document).ready(function() {
    setTimeout(function() {
      $('#logout').load('common_controller/logout');
    }, 10000);
  });
</script> -->
<script>
  $(document).ready(function() {
    var user_type = document.getElementById("role").value;
    if (user_type == "guest") {
      setTimeout(function() {
        window.location.href = base_url + "logout"; // the redirect goes here

      }, 10000); // 10 seconds
    }
  })
</script>

<script>
  gtag("event", "purchase", {
    transaction_id: <?php echo ($order->order_number) ?>,
    affiliation: "Google Merchandise Store",
    value: <?php echo ($order->price_total) ?>,
    tax: <?php echo ($order->price_gst) ?>,
    shipping: <?php echo ($order->price_shipping) ?>,
    currency: "INR",
    coupon: "SUMMER_SALE",
    items: [<?php echo ($myJSON) ?>]
  });
</script>