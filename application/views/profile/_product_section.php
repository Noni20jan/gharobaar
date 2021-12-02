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

  .veg {

    position: absolute;
    right: 76%;
    top: 17%;
    font-size: 13px;
  }

  .swick {
    position: absolute;
    display: inline-block;
    width: 84px;
    height: 28px;
    right: 42%;
    top: 10%;
  }

  @media(max-width:768px) {
    .swick {
      position: relative;
      display: inline-block;
      width: 84px;
      height: 28px;
      /* right: 1%; */
      top: 12%;
      right: -11%;
    }
  }

  .swick input {
    display: none;
  }

  .non {
    position: absolute;
    float: right;
    /* float: right; */
    /* left: 186px; */
    right: 15%;
    top: 22%;
    /* margin-left: 190px; */
    font-size: 13px;
  }

  @media(max-width:768px) {
    .non {

      position: absolute;
      float: right;
      right: 31%;
      /* left: 10%; */
      top: 16%;
      font-size: 18px;

    }
  }

  @media(max-width:768px) {
    .veg {
      position: absolute;
      float: right;
      right: 86%;
      top: 22%;
      font-size: 18px;
    }
  }

  /* .non_veg {
    position: absolute;
    display: inline-block;
    float: right;
    right: -38%;
    top: 11%;
    font-size: 18px;
  } */


  /* .cmd {
    position: relative;
    right: -33%;
    right: 43%;
    top: -13%;
    float: right;
    font-weight: 600;
  }

  @media(max-width:768px) {

    .cmd {
      position: relative;
      right: -33%;
      right: 7%;
      top: 79%;
      float: right;
      font-weight: 600;
    }
  }


  .swatch {
    position: relative;
    display: inline-block;
    width: 90px;
    height: 34px;
    /* right: 1%;
    float: right;
  }

  .swatch input {
    display: none;
  }*/



  .switch {
    position: relative;
    display: inline-block;
    width: 84px;
    height: 28px;
    right: -27%;
    top: 14%;
    float: right;
  }


  @media(max-width: 768px) {
    .switch {
      position: relative;
      display: inline-block;
      width: 84px;
      height: 28px;
      right: 0%;

      /* right: 72px;
            top: 44px; */
      float: right;


    }
  }






  .switch input {
    display: none;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: blue;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .swick input:checked+.slider {
    background-color: #2ab934;
  }

  .swick input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
  }

  .swick input:checked+.slider:before {
    -webkit-transform: translateX(55px);
    -ms-transform: translateX(55px);
    transform: translateX(55px);
  }

  .switch input:checked+.slider {
    background-color: red;
  }

  .switch input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
  }

  .switch input:checked+.slider:before {
    -webkit-transform: translateX(55px);
    -ms-transform: translateX(55px);
    transform: translateX(55px);
  }

  /*------ ADDED CSS ---------*/
  .on {
    display: none;
  }

  .on,
  .off {
    color: white;
    position: absolute;
    transform: translate(-50%, -50%);
    top: 50%;
    left: 50%;
    font-size: 10px;
    font-family: Verdana, sans-serif;
  }

  .swick input:checked+.slider .on {
    display: block;
  }

  .switch input:checked+.slider .on {
    display: block;
  }

  .switch input:checked+.slider .off {
    display: none;
  }

  .swick input:checked+.slider .off {
    display: none;
  }

  /*--------- END --------*/

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
    width: 19px;
    height: 20px;
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
<?php
foreach ($user_categories as $cat_id => $cat_count) :
  $category = get_category_by_id($cat_id);
  break;
endforeach; ?>
<div class="product-heading">
  <div class="row">
    <div class="col-md-4">
      Featured Products
    </div>
    <div class="col-md-3">
      <?php if ($category->id == 2) : ?>

        <label class="switch">
          <input type="checkbox" class="Non" <?= is_custom_field_option_selected($query_string_object_array, "food_type", "non_Veg") ? "checked" : ""; ?>>

          <div class="slider round">
            <!--ADDED HTML -->

            <span class="on">YES</span>

            <span class="off">NO</span>
            <!--END-->
          </div>
          <!-- <label class="non_Veg">Non Veg</label> -->
        </label>
        <label class="veg">Veg</label>

        <label class="non">Non Veg</label>
        <label class="swick">

          <input type="checkbox" class="Veg" <?= is_custom_field_option_selected($query_string_object_array, "food_type", "Veg") ? "checked" : ""; ?>>

          <div class="slider round">
            <!--ADDED HTML -->

            <span class="on">YES</span>

            <span class="off">NO</span>
            <!--END-->
          </div>
        </label>
      <?php endif; ?>
    </div>

    <div class="col-md-2" id="now">

      <button class="round_button" id="in_stock" onclick="myFunction4()" style="font-size:13px;">Available now
      </button>
    </div>
    <!-- <div class="col-md-2" id="time" style=left:3%;>
      <button class="round_button" onclick="myFunction4()">Delivery Time
        <i class="fa fa-caret-down" onclick="myFunction4()"></i>
      </button>
    </div> -->
    <div class="col-md-3" id="sort">
      <button class="dropbtn round_button" onclick="myFunction4()">Sort
        <a id="selected_tag" class="dropbtn">:<?php echo trans("whats_new"); ?></a>
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
        if ($count <= sizeof($products)) : ?>
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
  <!-- <div class="btn btn-md btn-view-more-new m-t-15 more" style="box-shadow: 2px 2px 5px #808080de !important;">
    <a id="show_more_products" class="view-new-text" href="<?= generate_url("seller_products") . '/' . $user_id; ?>">View More Products</a><i class="fa fa-caret-down" style="color:black; margin-left:6px;"></i>
  </div> -->
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
<script>
  $(".Veg").on('change', function() {
    var x = "<?php echo current_url(); ?>"
    var y = "<?php echo generate_filter_url($query_string_array, 'food_type', 'Veg'); ?>";
    z = x + y;
    console.log($(this).val());
    if ($(this).is(':checked')) {
      $(this).attr('value', 'true');
      console.log($(this).val());

      window.location.href = z;






    } else {
      $(this).attr('value', 'false');
      console.log($(this).val());
      window.location.href = x;
    }

  });
</script>
<script>
  $(".Non").on('change', function() {
    var x = "<?php echo current_url(); ?>"
    var y = "<?php echo generate_filter_url($query_string_array, 'food_type', 'non_Veg'); ?>";
    z = x + y;
    console.log($(this).val());
    if ($(this).is(':checked')) {
      $(this).attr('value', 'true');
      console.log($(this).val());

      window.location.href = z;






    } else {
      $(this).attr('value', 'false');
      console.log($(this).val());
      window.location.href = x;
    }

  });
</script>