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
 .btn:hover{
  background-color: #007c05 !important;

}
  .btn-custom {
    color: black !important;

  }
</style>
<div class="container">
  <div class="wrapper">
    <div class="text-center">
      <div><i style="color:green;padding-top: 30px" class='fas fa-check-circle fa-7x'></i><br /></div>
      <h1 class="display-3"><?php echo trans("thankyou_messsage") ?></h1>
    </div>
    <div class="row">
      <div class="col-md-12 text-center">
        <p class="lead">
          <a class="btn btn-lg btn-custom btn-place-order" href='<?php echo (generate_url("order_details") . "/" . $order_number) ?>'><?php echo trans("thankyou_track_order") ?></a>
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-center">
        <p class="lead">
          <a class="btn btn-lg btn-custom btn-continue-shopping" href='<?php echo (lang_base_url()) ?>'><?php echo trans("thankyou_continue_shopping") ?></a>
        </p>
      </div>
    </div>
  </div>
</div>