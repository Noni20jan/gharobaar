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
    background-color: #007c05 !important;

  }

  .btn-custom {
    color: black !important;

  }
</style>

<input type="hidden" id="role" value="<?php echo $this->auth_user->user_type; ?>">
<!-- header( "refresh:5;url=wherever.php" ); -->
<div class="container">
  <div class="wrapper">
    <div class="text-center">
      <div><i style="color:green;padding-top: 30px" class='fas fa-check-circle fa-7x'></i><br /></div>
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