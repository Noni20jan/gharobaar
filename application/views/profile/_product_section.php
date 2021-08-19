<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  .round_button {
    border: 1px solid #000000;
    border-radius: 20.5px;
    padding: 7px 16px;
    font-size: 15px;
    background: transparent;
  }

  #now {
    text-align: end;
    left: 3%;
  }

  #sort {
    max-width: 25%;
    left: 2%;
  }

  @media(max-width:768px) {
    .round_button {
      border: 1px solid #000000;
      border-radius: 20.5px;
      padding: 7px 16px;
      font-size: 11px;
      background: transparent;
    }

    #now {
      text-align: end;
      margin-right: 10%;
    }

    /* #time {
      text-align: center;
      margin-top: -37px;
      margin-right: 9%;
    } */

    #sort {
      margin-top: -38px;
      left: 8%;
      max-width: 51%;
    }
  }

  .btn-view-more-new {
    background-color: #fff;
    border-color: #fff;
    border-radius: 20px;
  }

  .view-new-text {
    color: black;
    font-weight: bold;
  }
</style>

<div class="product-heading">
  <div class="row">
    <div class="col-md-4">
      Featured Products
    </div>
    <div class="col-md-2"></div>
    <div class="col-md-3" id="now">
      <button class="round_button" id="in_stock" onclick="myFunction4()">Available now
      </button>
    </div>
    <!-- <div class="col-md-2" id="time" style=left:3%;>
      <button class="round_button" onclick="myFunction4()">Delivery Time
        <i class="fa fa-caret-down" onclick="myFunction4()"></i>
      </button>
    </div> -->
    <div class="col-md-3" id="sort">
      <button class="dropbtn round_button" onclick="myFunction4()">Sort
        <a id="selected_tag" class="dropbtn" style="font-weight:500;">:<?php echo trans("whats_new"); ?></a>
        <i class="fa fa-caret-down dropbtn"></i>
      </button>
      <div class="dropdown-content" id="myDropdown">
        <a href="javascript:void(0);" id="whats_new"><?php echo trans("whats_new"); ?></a>
        <a href="javascript:void(0);" id="better_discount"><?php echo trans("better_discount"); ?></a>
        <a href="javascript:void(0);" id="low_to_high"><?php echo trans("price_low_high"); ?></a>
        <a href="javascript:void(0);" id="high_to_low"><?php echo trans("price_high_low"); ?></a>
      </div>
    </div>
  </div>
</div>


<div class="product-tab-content">
  <div class="row row-product-items row-product" id="product_div_seller">
    <div id="cover-spin"></div>
    <?php if (!empty($products)) :
      $count = 1; ?>
      <?php foreach ($products as $product) :
        if ($count <= 10) : ?>
          <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
            <?php $this->load->view('product/_product_item', ['product' => $product, 'promoted_badge' => true]); ?>
          </div>
      <?php endif;
        $count++;
      endforeach; ?>
    <?php else : ?>
      <div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">
        No Product is available
      </div>
    <?php endif; ?>
  </div>
</div>
<div class="col-12 text-center">
  <div class="btn btn-md btn-view-more-new m-t-15 more" style="box-shadow: 2px 2px 5px #808080de !important;">
    <a id="show_more_products" class="view-new-text" href="<?= generate_url("seller_products") . '/' . $user_id; ?>">View More Products</a><i class="fa fa-caret-down" style="color:black; margin-left:6px;"></i>
  </div>
</div>
<!-- <div class="product-list-pagination">
  <?php echo $this->pagination->create_links(); ?>
</div> -->
<div class="row-custom">
  <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "profile", "class" => "m-t-30"]); ?>
</div>


<script>
  /* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
  function myFunction4() {
    document.getElementById("myDropdown").classList.toggle("show");
  }

  // Close the dropdown if the user clicks outside of it
  window.onclick = function(e) {
    if (!e.target.matches('.dropbtn')) {
      var myDropdown = document.getElementById("myDropdown");
      if (myDropdown.classList.contains('show')) {
        myDropdown.classList.remove('show');
      }
    }
  }

  $("#better_discount").click(function() {
    var str = ":" + "<?php echo trans("better_discount"); ?>";
    highest_discount((<?php echo $user_id; ?>), str);
  })
  $("#low_to_high").click(function() {
    var str = ":" + "<?php echo trans("price_low_high"); ?>";
    priceLow((<?php echo $user_id; ?>), str);
  })
  $("#high_to_low").click(function() {
    var str = ":" + "<?php echo trans("price_high_low"); ?>";
    priceHigh((<?php echo $user_id; ?>), str);
  })
  $("#whats_new").click(function() {
    var str = ":" + "<?php echo trans("whats_new"); ?>";
    newProducts((<?php echo $user_id; ?>), str);
  })

  $("#in_stock").click(function() {
    product_in_stock("<?php echo $user_id; ?>");
  })
</script>