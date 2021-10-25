<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script src="<?php echo base_url(); ?>assets/admin/vendor/chart/chart.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/vendor/chart/utils.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/vendor/chart/analyser.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>



<style type="text.css">

    .highcharts-figure, .highcharts-data-table table {
  min-width: 310px; 
  max-width: 800px;
  margin: 1em auto;
}


#container {
  height: 400px;
}

.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
  padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
  padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
  background: #f8f8f8;
}
.highcharts-data-table tr:hover {
  background: #f1f7ff;
}
.new-icons-position{
  position: absolute;
    right: 25px;
    /* top: 0; */
    bottom: 32px;
    margin: auto;
    font-size: 30px;
    color: #9ca9be;
}
/* #svgelem{
            position: relative;
            left: 50%;
            -webkit-transform: translateX(-40%);
            -ms-transform: translateX(-40%);
            transform: translateX(-40%);
         } */
</style>

<div class="row m-b-30">
    <div class="col-sm-12 m-b-15">
        <div class="small-boxes-dashboard">
            <?php if ($this->is_sale_active) : ?>
                <div class="col-lg-3 col-md-6 col-sm-12 p-0">
                    <div class="small-box-dashboard small-box-dashboard-first">
                        <h3 class="total"><?= $total_sales_count; ?></h3>
                        <span class="text-muted"><?= trans("number_of_total_sales"); ?></span>
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cart-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                            <path fill-rule="evenodd" d="M11.354 5.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708 0z" />
                        </svg>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 p-0">
                    <div class="small-box-dashboard">
                        <h3 class="total"><?= price_formatted($this->auth_user->balance, $this->payment_settings->default_currency); ?></h3>
                        <span class="text-muted"><?= trans("balance"); ?></span>
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cash-stack" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 3H1a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1h-1z" />
                            <path fill-rule="evenodd" d="M15 5H1v8h14V5zM1 4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H1z" />
                            <path d="M13 5a2 2 0 0 0 2 2V5h-2zM3 5a2 2 0 0 1-2 2V5h2zm10 8a2 2 0 0 1 2-2v2h-2zM3 13a2 2 0 0 0-2-2v2h2zm7-4a2 2 0 1 1-4 0 2 2 0 0 1 4 0z" />
                        </svg>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($user->supplier_type == "Goods") { ?>
                <div class="col-lg-3 col-md-6 col-sm-12 p-0">
                    <div class="small-box-dashboard" <?= !$this->is_sale_active ? 'style="border-radius: 4px 0 0 4px;"' : ''; ?>>
                        <h3 class="total"><?= $products_count; ?></h3>
                        <span class="text-muted"><?= trans("products"); ?></span>
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-basket" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9H2zM1 7v1h14V7H1zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5z" />
                        </svg>
                    </div>
                </div>
            <?php
            } else if ($user->supplier_type == "Services") { ?>
                <div class="col-lg-3 col-md-6 col-sm-12 p-0">
                    <div class="small-box-dashboard" <?= !$this->is_sale_active ? 'style="border-radius: 4px 0 0 4px;"' : ''; ?>>
                        <h3 class="total"><?= $services_count; ?></h3>
                        <span class="text-muted">Service</span>
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-user" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9H2zM1 7v1h14V7H1zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5z" />
                        </svg>
                    </div>
                </div>
            <?php } else { ?>

            <?php } ?>

            <div class="col-lg-3 col-md-6 col-sm-12 p-0">
                <div class="small-box-dashboard small-box-dashboard-last">
                    <h3 class="total"><?= !empty($total_pageviews_count) ? $total_pageviews_count : '0'; ?></h3>
                    <span class="text-muted"><?= trans("page_views"); ?></span>
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bar-chart" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5h-2v12h2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row m-b-30">

    <div class="col-sm-12 m-b-15">
        <div class="small-boxes-dashboard">
            <?php if ($this->is_sale_active) : ?>
                <div class="col-lg-3 col-md-6 col-sm-12 p-0">
                    <div class="small-box-dashboard small-box-dashboard-first">
                        <h3 class="total"><?= $total_sales_count; ?></h3>
                        <span class="text-muted">Average customer rating</span>
                        <i class="fa fa-star" aria-hidden="true" style="position: absolute;right: 25px;bottom: 32px;font-size: 30px;color: #9ca9be;"></i>
                        <!-- <i class="fas fa-star"></i> -->
                        <!-- <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cart-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
              <path fill-rule="evenodd" d="M11.354 5.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708 0z" />
            </svg> -->
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 p-0">
                    <div class="small-box-dashboard small-box-dashboard-last">
                        <h3 class="total"><?= $avg_transaction->avg_transaction; ?></h3>
                        <span class="text-muted">Average Transaction</span>
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cash-stack" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 3H1a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1h-1z" />
                            <path fill-rule="evenodd" d="M15 5H1v8h14V5zM1 4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H1z" />
                            <path d="M13 5a2 2 0 0 0 2 2V5h-2zM3 5a2 2 0 0 1-2 2V5h2zm10 8a2 2 0 0 1 2-2v2h-2zM3 13a2 2 0 0 0-2-2v2h2zm7-4a2 2 0 1 1-4 0 2 2 0 0 1 4 0z" />
                        </svg>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($user->supplier_type == "Goods") { ?>
                <div class="col-lg-3 col-md-6 col-sm-12 p-0">
                    <div class="small-box-dashboard" <?= !$this->is_sale_active ? 'style="border-radius: 4px 0 0 4px;"' : ''; ?>>
                        <h3 class="total">55%</h3>
                        <span class="text-muted">Customer Index</span>
                        <i class="fa fa-users" aria-hidden="true" style="position: absolute;right: 25px;bottom: 32px;font-size: 30px;color: #9ca9be;"></i>
                        <!-- <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-basket" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9H2zM1 7v1h14V7H1zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5z" />
            </svg> -->
                    </div>
                </div>
            <?php
            } else if ($user->supplier_type == "Services") { ?>
                <div class="col-lg-3 col-md-6 col-sm-12 p-0">
                    <div class="small-box-dashboard" <?= !$this->is_sale_active ? 'style="border-radius: 4px 0 0 4px;"' : ''; ?>>
                        <h3 class="total">55%</h3>
                        <span class="text-muted">Customer Index</span>
                        <i class="fa fa-users" aria-hidden="true" style="position: absolute;right: 25px;bottom: 32px;font-size: 30px;color: #9ca9be;"></i>
                        <!-- <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-user" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9H2zM1 7v1h14V7H1zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5z" />
            </svg> -->
                    </div>
                </div>
            <?php } else { ?>

            <?php } ?>

            <div class="col-lg-3 col-md-6 col-sm-12 p-0">
                <div class="small-box-dashboard small-box-dashboard-last">
                    <h3 class="total">60%</h3>
                    <span class="text-muted">Supplier Index</span>
                    <i class="fa fa-user" aria-hidden="true" style="position: absolute;right: 25px;bottom: 32px;font-size: 30px;color: #9ca9be;"></i>
                    <!-- <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bar-chart" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M4 11H2v3h2v-3zm5-4H7v7h2V7zm5-5h-2v12h2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1h-2zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3z" />
          </svg> -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php foreach ($repeat as $rep) : ?>
<?php endforeach; ?>
<?php foreach ($max_count as $max) : ?>
<?php endforeach; ?>
<?php foreach ($customers_weekly as $cust) : ?>
<?php endforeach; ?>
<div class="row m-b-30">
    <div class="col-sm-12">
        <div class="small-boxes-dashboard">
            <?php if ($this->is_sale_active) : ?>
                <div class="col-lg-4 col-md-6 col-sm-12 p-0">
                    <?php if (empty($rep)) : ?>
                        <div class="small-box-dashboard small-box-dashboard-first">
                            <h3 class="total">0</h3>
                            <span class="text-muted">Repeated Purchases</span>
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cart-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                <path fill-rule="evenodd" d="M11.354 5.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708 0z" />
                            </svg>
                        </div>
                    <?php else : ?>
                        <div class="small-box-dashboard small-box-dashboard-first">
                            <h3 class="total"><?php echo $rep->sum ?></h3>
                            <span class="text-muted">Repeated Purchases</span>
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cart-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                <path fill-rule="evenodd" d="M11.354 5.646a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708 0z" />
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>

            <?php endif; ?>
            <?php if ($user->supplier_type == "Goods") { ?>
                <div class="col-lg-4 col-md-6 col-sm-12 p-0">
                    <?php if (empty($max)) : ?>
                        <div class="small-box-dashboard" <?= !$this->is_sale_active ? 'style="border-radius: 4px 0 0 4px;"' : ''; ?>>
                            <h3 class="total">0</h3>
                            <span class="text-muted">Maximum Orders</span>
                            <i class="fa fa-shopping-cart" aria-hidden="true" style="position: absolute;right: 25px;bottom: 32px;font-size: 30px;color: #9ca9be;"></i>

                        </div>
                    <?php else : ?>
                        <div class="small-box-dashboard" <?= !$this->is_sale_active ? 'style="border-radius: 4px 0 0 4px;"' : ''; ?>>
                            <h3 class="total"><?php echo $max->order_sum; ?></h3>
                            <span class="text-muted">Maximum Orders</span>
                            <i class="fa fa-shopping-cart" aria-hidden="true" style="position: absolute;right: 25px;bottom: 32px;font-size: 30px;color: #9ca9be;"></i>

                        </div>
                    <?php endif; ?>

                </div>
            <?php
            } else if ($user->supplier_type == "Services") { ?>
                <div class="col-lg-4 col-md-6 col-sm-12 p-0">
                    <div class="small-box-dashboard" <?= !$this->is_sale_active ? 'style="border-radius: 4px 0 0 4px;"' : ''; ?>>
                        <h3 class="total"><?= $services_count; ?></h3>
                        <span class="text-muted">Service</span>
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-user" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9H2zM1 7v1h14V7H1zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5z" />
                        </svg>
                    </div>
                </div>
            <?php } else { ?>

            <?php } ?>

            <div class="col-lg-4 col-md-6 col-sm-12 p-0">
                <div class="small-box-dashboard small-box-dashboard-last">

                    <?php if (empty($customers_weekly)) : ?>
                        <h3 class="total">0</h3>
                        <span class="text-muted">Maximum Customers</span>
                        <i class="fa fa-user" aria-hidden="true" style="position: absolute;right: 25px;bottom: 32px;font-size: 30px;color: #9ca9be;"></i>
                    <?php else : ?>
                        <h3 class="total"><?php echo $cust->sum; ?></h3>
                        <span class="text-muted">Maximum Customers</span>
                        <i class="fa fa-user" aria-hidden="true" style="position: absolute;right: 25px;bottom: 32px;font-size: 30px;color: #9ca9be;"></i>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div> <!-- custom analytics -->

<div class="row">
    <label style="padding-left: 15px;"><b>CUSTOMERS</b></label>
    <figure class="highcharts-figure">
        <div class="col-md-6">
            <div id="container"></div>
            <p class="highcharts-description">
            </p>
            <div id="container1"></div>
            <p class="highcharts-description"></p>
        </div>
        <div class="col-md-6">
            <div id="column"></div>
            <p class="highcharts-description"></p>
            <div id="container2"></div>
            <p class="highcharts-description"></p>
        </div>
    </figure>
</div>

<div class="row">
    <div class="col-md-6">
        <figure class="highcharts-figure">
            <label><b>TRANSACTIONAL DATA</b></label>
            <div id="container-fluid"></div>
            <p class="highcharts-description">
            </p>
            <div id="column1"></div>
            <p class="highcharts-description">
            <div id="column2"></div>
            <p class="highcharts-description">
        </figure>
    </div>

    <div class="col-md-6">
        <label><b>SCALE OF OPERATION</b></label>
        <figure class="highcharts-figure">
            <div id="column3"></div>
            <p class="highcharts-description">
            <div id="column4"></div>
            <p class="highcharts-description"></p>
        </figure>
    </div>
</div>

<!-- custom analytics  End-->

<?php if ($this->is_sale_active) : ?>
    <div class="row">
        <?php if (!empty($active_sales_count) || !empty($completed_sales_count)) : ?>
            <div class="col-lg-4 col-sm-12 col-xs-12">
                <div class="box box-primary box-sm">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo trans("sales"); ?></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="index-chart-container">
                            <canvas id="chart_sales"></canvas>
                        </div>
                    </div>
                    <div class="box-footer clearfix"></div>
                </div>
            </div>
            <div class="col-lg-8 col-sm-12 col-xs-12">
                <div class="box box-primary box-sm">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo trans("monthly_sales"); ?></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="index-chart-container">
                            <canvas id="chart_montly_sales"></canvas>
                        </div>
                    </div>
                    <div class="box-footer clearfix"></div>
                </div>
            </div>


        <?php endif; ?>
    </div>
<?php endif; ?>
<div class="row">
    <?php if ($this->is_sale_active) : ?>
        <div class="col-lg-6 col-sm-12 col-xs-12">
            <div class="box box-primary box-sm">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo trans("latest_sales"); ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div><!-- /.box-header -->

                <div class="box-body index-table">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th><?php echo trans("sale"); ?></th>
                                    <th><?php echo trans("total"); ?></th>
                                    <th><?php echo trans("status"); ?></th>
                                    <th><?php echo trans("date"); ?></th>
                                    <th><?php echo trans("options"); ?></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($latest_sales as $item) : ?>
                                    <tr>
                                        <td>#<?php echo $item->order_number; ?></td>
                                        <td><?php echo price_formatted($item->price_total, $item->price_currency); ?></td>
                                        <td>
                                            <?php if ($item->status == 1) :
                                                echo trans("completed");
                                            else :
                                                echo trans("order_processing");
                                            endif; ?>
                                        </td>
                                        <td><?php echo date("Y-m-d / h:i", strtotime($item->created_at)); ?></td>
                                        <td style="width: 10%">
                                            <a href="<?php echo generate_dash_url("sale"); ?>/<?php echo html_escape($item->order_number); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>

                <div class="box-footer clearfix text-right">
                    <a href="<?= generate_dash_url("sales"); ?>" class="btn btn-sm btn-default"><?php echo trans("view_all"); ?></a>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="box box-primary box-sm">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("latest_comments"); ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body index-table">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th><?php echo trans("id"); ?></th>
                                <th><?php echo trans("comment"); ?></th>
                                <th><?php echo trans("product"); ?></th>
                                <th><?php echo trans("date"); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if (!empty($latest_comments)) :
                                foreach ($latest_comments as $item) :
                                    $product = get_active_product($item->product_id); ?>
                                    <tr>
                                        <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                        <td style="width: 35%"><?php echo character_limiter(html_escape($item->comment), 40, '...'); ?></td>
                                        <td style="width: 35%">
                                            <?php if (!empty($product)) : ?>
                                                <a href="<?php echo lang_base_url() . $product->slug; ?>" class="link-black" target="_blank">
                                                    <?php echo character_limiter(get_product_title($product), 40, '...'); ?>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="white-space-nowrap" style="width: 20%"><?php echo formatted_date($item->created_at); ?></td>
                                    </tr>
                            <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

            <div class="box-footer clearfix text-right">
                <a href="<?php echo generate_dash_url("comments"); ?>" class="btn btn-sm btn-default"><?php echo trans("view_all"); ?></a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="box box-primary box-sm">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("latest_reviews"); ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body index-table">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th><?php echo trans("id"); ?></th>
                                <th><?php echo trans("comment"); ?></th>
                                <th><?php echo trans("product"); ?></th>
                                <th><?php echo trans("date"); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if (!empty($latest_reviews)) :
                                foreach ($latest_reviews as $item) :
                                    $product = get_active_product($item->product_id); ?>
                                    <tr>
                                        <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                                        <td class="break-word">
                                            <div class="pull-left" style="width: 100%;">
                                                <?php $this->load->view('admin/includes/_review_stars', ['review' => $item->rating]); ?>
                                            </div>
                                            <p class="pull-left">
                                                <?php echo html_escape($item->review); ?>
                                            </p>
                                        </td>
                                        <td style="width: 35%">
                                            <?php if (!empty($product)) : ?>
                                                <a href="<?php echo lang_base_url() . $product->slug; ?>" class="link-black" target="_blank">
                                                    <?php echo character_limiter(get_product_title($product), 40, '...'); ?>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="white-space-nowrap" style="width: 20%"><?php echo formatted_date($item->created_at); ?></td>
                                    </tr>
                            <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

            <div class="box-footer clearfix text-right">
                <a href="<?php echo generate_dash_url("reviews"); ?>" class="btn btn-sm btn-default"><?php echo trans("view_all"); ?></a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="box box-primary box-sm">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("pending_order"); ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body index-table">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th scope="col"><?php echo trans("order_id"); ?></th>
                                <th scope="col"><?php echo trans("total_amount"); ?></th>
                                <th scope="col"><?php echo trans("status"); ?></th>
                                <th scope="col"><?php echo trans("date"); ?></th>
                                <th scope="col"><?php echo trans("options"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latest_sales1 as $item) : ?>
                                <tr>
                                    <td>#<?php echo $item->order_number; ?></td>
                                    <td><?php echo price_formatted($item->amount, $item->currency); ?></td>
                                    <td>
                                        <?php echo $item->order_status; ?>
                                    </td>
                                    <td><?php echo date("Y-m-d / h:i", strtotime($item->order_date)); ?></td>
                                    <td style="width: 10%">
                                        <a href="<?php echo generate_dash_url("sale"); ?>/<?php echo html_escape($item->order_number); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>


                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

            <div class="box-footer clearfix text-right">
                <a href="<?php echo generate_dash_url("sales"); ?>" class="btn btn-sm btn-default"><?php echo trans("view_all"); ?></a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="box box-primary box-sm">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("outstanding_payments"); ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body index-table">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th scope="col"><?php echo trans("order_id"); ?></th>
                                <th scope="col"><?php echo trans("total_amount"); ?></th>
                                <th scope="col"><?php echo trans("status"); ?></th>
                                <th scope="col"><?php echo trans("date"); ?></th>
                                <th scope="col"><?php echo trans("options"); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if (!empty($latest_sales2)) :
                                foreach ($latest_sales2 as $item) : ?>
                                    <tr>
                                        <td>#<?php echo $item->order_number; ?></td>
                                        <td><?php echo price_formatted($item->amount, $item->currency); ?></td>
                                        <td>
                                            Payment Pending
                                        </td>
                                        <td><?php echo date("Y-m-d / h:i", strtotime($item->order_date)); ?></td>
                                        <td style="width: 10%">
                                            <a href="<?php echo generate_dash_url("sale"); ?>/<?php echo html_escape($item->order_number); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                                        </td>
                                    </tr>
                            <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

            <div class="box-footer clearfix text-right">
                <a href="<?php echo generate_dash_url("sales"); ?>" class="btn btn-sm btn-default"><?php echo trans("view_all"); ?></a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="box box-primary box-sm">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("cleared_payments"); ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body index-table">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th scope="col"><?php echo trans("order_id"); ?></th>
                                <th scope="col"><?php echo trans("total_amount"); ?></th>
                                <th scope="col"><?php echo trans("status"); ?></th>
                                <th scope="col"><?php echo trans("date"); ?></th>
                                <th scope="col"><?php echo trans("options"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latest_sales3 as $item) : ?>
                                <tr>
                                    <td>#<?php echo $item->order_number; ?></td>
                                    <td><?php echo price_currency_format($item->amount, $item->currency); ?></td>
                                    <td>
                                        Payment Cleared
                                    </td>
                                    <td><?php echo date("Y-m-d / h:i", strtotime($item->order_date)); ?></td>
                                    <td style="width: 10%">
                                        <a href="<?php echo generate_dash_url("sale"); ?>/<?php echo html_escape($item->order_number); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>


                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

            <div class="box-footer clearfix text-right">
                <a href="<?php echo generate_dash_url("sales"); ?>" class="btn btn-sm btn-default"><?php echo trans("view_all"); ?></a>
            </div>
        </div>
    </div>
</div>
<div class="row m-b-30">
    <?php if ($this->is_sale_active) : ?>
        <div class="col-lg-6 col-sm-12 col-xs-12">
            <div class="box box-primary box-sm">
                <div class="box-header with-border">
                    <h3 class="box-title">Top Rated Suppliers</h3>
                    <div class="box-tools pull-right">
                        <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                    </div>
                </div><!-- /.box-header -->

                <div class="box-body index-table">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>Shop Name</th>
                                    <th>Sales</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($top_sell as $sel) : ?>
                                    <tr>
                                        <td><?php echo $sel->seller_id; ?></td>
                                        <td><a href="<?php echo base_url() . 'profile/' . $sel->slug; ?>"><?php echo $sel->username; ?></a></td>

                                        <td><?php echo $sel->shop_name; ?></td>
                                        <td><?php echo $sel->sm; ?></td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>

                <!-- <div class="box-footer clearfix text-right">
          <a href="<?= generate_dash_url("sales"); ?>" class="btn btn-sm btn-default"><?php echo trans("view_all"); ?></a>
        </div> -->
            </div>
        </div>
    <?php endif; ?>
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="box box-primary box-sm">
            <div class="box-header with-border">
                <h3 class="box-title">Top Selling Products</h3>
                <div class="box-tools pull-right">
                    <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                </div>
            </div><!-- /.box-header -->

            <div class="box-body index-table">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Shop Name</th>

                                <th><?php echo trans("date"); ?></th>
                                <th>Sales</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($top_selling as $sell) : ?>
                                <?php $product = get_product($sell->product_id) ?>
                                <?php $user = get_user($sell->seller_id); ?>

                                <tr>
                                    <td><?php echo $sell->product_id; ?></td>
                                    <td>
                                        <div class="img-table">
                                            <a href="<?php echo generate_product_url($product); ?>" target="_blank">
                                                <img src="<?php echo get_product_image($product->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                                            </a>
                                        </div>
                                        <a href="<?php echo generate_product_url($product); ?>" target="_blank" class="table-product-title">
                                            <?php echo $sell->product_title; ?>
                                        </a>
                                    </td>
                                    <td><?php echo $product->sku; ?></td>
                                    <td><?php echo $user->shop_name; ?></td>
                                    <td><?php echo $sell->created_at; ?></td>
                                    <td><?php echo $sell->cnt; ?></td>

                                    <!-- <td>
                    <?php echo $sell->sku; ?>
                  </td>
                  <td>
                    <?php echo $sell->product_type; ?>
                  </td>
                  <td>
                    <?php echo $sell->stock; ?>
                  </td> -->
                                    <!-- <td style="width: 10%">
                    <?php echo $sell->created_at; ?>
                  </td> -->
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

            <!-- <div class="box-footer clearfix text-right">
        <a href="<?= generate_dash_url("sales"); ?>" class="btn btn-sm btn-default"><?php echo trans("view_all"); ?></a>
      </div> -->
        </div>
    </div>

</div>
<div class="row m-b-30">

    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="box box-primary box-sm">
            <div class="box-header with-border">
                <h3 class="box-title">Active Customers Placed atleast one order in 3 months</h3>
                <div class="box-tools pull-right">
                    <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                </div>
            </div><!-- /.box-header -->

            <div class="box-body index-table">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Username</th>
                                <th>Mobile No</th>

                                <!-- <th><?php echo trans("date"); ?></th> -->
                                <th>No Of Orders</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($active_customers as $active) : ?>
                                <?php $product = get_product($sell->product_id) ?>
                                <?php $user = get_user($active->buyer_id); ?>

                                <tr>
                                    <td><?php echo $active->buyer_id; ?></td>
                                    <td><?php echo $user->email; ?></td>
                                    <td><?php echo $user->phone_number; ?></td>
                                    <!-- <td><?php echo $active->Period; ?></td> -->
                                    <td><?php echo $active->order_count; ?></td>

                                    <!-- <td>
                    <?php echo $sell->sku; ?>
                  </td>
                  <td>
                    <?php echo $sell->product_type; ?>
                  </td>
                  <td>
                    <?php echo $sell->stock; ?>
                  </td> -->
                                    <!-- <td style="width: 10%">
                    <?php echo $sell->created_at; ?>
                  </td> -->
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

            <!-- <div class="box-footer clearfix text-right">
        <a href="<?= generate_dash_url("sales"); ?>" class="btn btn-sm btn-default"><?php echo trans("view_all"); ?></a>
      </div> -->
        </div>
    </div>

</div>


<?php if (!empty($active_sales_count) || !empty($completed_sales_count)) : ?>
    <script>
        //total sales
        var ctx = document.getElementById('chart_sales').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [
                    "<?= trans("active_sales"); ?> (<?= !empty($active_sales_count) ? $active_sales_count : 0; ?>)",
                    "<?= trans("completed_sales"); ?> (<?= !empty($completed_sales_count) ? $completed_sales_count : 0; ?>)"
                ],
                datasets: [{
                    data: [<?= !empty($active_sales_count) ? $active_sales_count : 0; ?>, <?= !empty($completed_sales_count) ? $completed_sales_count : 0; ?>],
                    backgroundColor: [
                        '#1BC5BD',
                        '#6993FF'
                    ],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutoutPercentage: 70,
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return data['labels'][tooltipItem['index']];
                        }
                    }
                }
            }
        });
    </script>
<?php endif; ?>

<?php if (!empty($sales_sum)) : ?>
    <script>
        //monthly sales
        var months = ["<?= trans("january"); ?>", "<?= trans("february"); ?>", "<?= trans("march"); ?>", "<?= trans("april"); ?>", "<?= trans("may"); ?>", "<?= trans("june"); ?>", "<?= trans("july"); ?>", "<?= trans("august"); ?>", "<?= trans("september"); ?>", "<?= trans("october"); ?>", "<?= trans("november"); ?>", "<?= trans("december"); ?>"];
        var i;
        for (i = 0; i < months.length; i++) {
            months[i] = months[i].substr(0, 3);
        }
        var presets = window.chartColors;
        var utils = Samples.utils;
        var inputs = {
            min: 0,
            max: 100,
            count: 8,
            decimals: 2,
            continuity: 1
        };
        var options = {
            maintainAspectRatio: false,
            spanGaps: false,
            elements: {
                line: {
                    tension: 0.000001
                }
            },
            plugins: {
                filler: {
                    propagate: false
                }
            },
            scales: {
                x: {
                    ticks: {
                        autoSkip: false,
                        maxRotation: 0
                    }
                },
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(label, index, labels) {
                            return "<?= get_currency_sign($this->payment_settings->default_currency); ?>" + label;
                        }
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return data['labels'][tooltipItem['index']] + ": <?= get_currency_sign($this->payment_settings->default_currency); ?>" + data['datasets'][0]['data'][tooltipItem['index']];
                    }
                }
            }
        };
        [false, 'origin', 'start', 'end'].forEach(function() {
            utils.srand(8);
            new Chart('chart_montly_sales', {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        backgroundColor: utils.transparentize("#bfe8e6"),
                        borderColor: "#1BC5BD",
                        data: [<?php for ($i = 1; $i <= 12; $i++) {
                                    echo $i > 1 ? ',' : '';
                                    $total = 0;
                                    foreach ($sales_sum as $sum) {
                                        if (isset($sum->month) && $sum->month == $i) {
                                            $total = $sum->total_amount;
                                            break;
                                        }
                                    }
                                    echo get_price($total, 'decimal');
                                } ?>],
                        label: "<?= trans("sales"); ?> (<?= date("Y") ?>)"
                    }]
                },
                options: Chart.helpers.merge(options, {
                    title: {
                        display: false
                    },
                    elements: {
                        line: {
                            tension: 0.4,
                            borderWidth: 2
                        }
                    }
                })
            });
        });
    </script>
<?php endif; ?>

<script>
    var dataMap;
    // Create the chart
    $(document).ready(function() {
        var data = {
            "test": "test"
        }


        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: 'post',
            url: 'http://localhost/gharobar/Bar_controller/json_data',
            data: data,
            dataType: 'json',
            async: false,
            success: function(data) {

                // console.log(data);
                dataMap = data;
            }
        });
        // console.log(dataMap);
    });


    Highcharts.chart('column', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'New Customers in Last Week'
        },

        xAxis: {
            categories: <?php echo json_encode($days_newCustomer); ?>,
            plotBands: [{ // visualize the weekend
                from: 4.5,
                to: 6.5,
                color: 'white'
            }]
        },
        yAxis: {
            title: {
                text: 'Number of Customers'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' customers'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            line: {
                fillOpacity: 0.5
            }
        },
        series: [{
            name: 'Last Week',
            data: <?php echo json_encode($test); ?>
        }, ]
    });



    $(document).ready(function() {

        var data = {
            "test1": "test1"
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: 'post',
            url: 'http://localhost/gharobar/Line_controller/json_data',
            data: data,
            dataType: 'json',
            async: false,
            success: function(data) {
                // console.log(data);
                dataMap = data;
            }
        });

        Highcharts.chart('column3', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'New markets covered till now'
            },

            xAxis: {
                categories: [
                    'week 1',
                    'week 2',
                    'week 3',
                    'week 4',
                    'week 5',

                ],
                plotBands: [{ // visualize the weekend
                    from: 4.5,
                    to: 6.5,
                    color: 'white'
                }]
            },
            yAxis: {
                title: {
                    text: 'Number of transactions'
                }
            },
            tooltip: {
                shared: true,
                valueSuffix: ' transaction'
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                line: {
                    fillOpacity: 0.5
                }
            },
            series: [{
                name: 'Last Week',
                data: <?php echo json_encode($test3); ?>
            }, ]
        })
        console.log(dataMap);
    });

    Highcharts.chart('column1', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'No. of transactions in the last one week'
        },
        xAxis: {
            categories: <?php echo json_encode($days_newCustomer); ?>,
            plotBands: [{ // visualize the weekend
                from: 4.5,
                to: 6.5,
                color: 'white'
            }]
        },
        yAxis: {
            title: {
                text: 'Number of transactions'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' transaction'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            line: {
                fillOpacity: 0.5
            }
        },
        series: [{
            name: 'Last Week',
            data: <?php echo json_encode($test1); ?>
        }, ]
    });
    $(document).ready(function() {

        var data = {
            "test2": "test2"
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: 'post',
            url: 'http://localhost/gharobar/Line_controller/json_data',
            data: data,
            dataType: 'json',
            async: false,
            success: function(data) {
                // console.log(data);
                dataMap = data;
            }
        });
        console.log(dataMap);
    });

    Highcharts.chart('column2', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'Average value of transactions'
        },
        xAxis: {
            categories: [
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
                'Sunday'
            ],
            plotBands: [{ // visualize the weekend
                from: 4.5,
                to: 6.5,
                color: 'white'
            }]
        },
        yAxis: {
            title: {
                text: 'Number of transactions'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' transaction'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            line: {
                fillOpacity: 0.5
            }
        },
        series: [{
            name: 'Last Week',
            data: <?php echo json_encode($test2); ?>
        }, ]
    });
    // 

    $(document).ready(function() {

        var data = {
            "test3": "test3"
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: 'post',
            url: 'http://localhost/gharobar/Line_controller/json_data',
            data: data,
            dataType: 'json',
            async: false,
            success: function(data) {
                // console.log(data);
                dataMap = data;
            }
        });
        console.log(dataMap);
    });

    Highcharts.chart('column3', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'New markets covered till now'
        },

        xAxis: {
            categories: [
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
                'Sunday'
            ],
            plotBands: [{ // visualize the weekend
                from: 4.5,
                to: 6.5,
                color: 'white'
            }]
        },
        yAxis: {
            title: {
                text: 'Number of transactions'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' transaction'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            line: {
                fillOpacity: 0.5
            }
        },
        series: [{
            name: 'Last Week',
            data: <?php echo json_encode($test3); ?>
        }, ]
    });


    $(document).ready(function() {

        var data = {
            "test4": "test4"
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: 'post',
            url: 'http://localhost/gharobar/Line_controller/json_data',
            data: data,
            dataType: 'json',
            async: false,
            success: function(data) {
                // console.log(data);
                dataMap = data;
            }
        });
        console.log(dataMap);
    });

    Highcharts.chart('column4', {
        chart: {
            type: 'line'
        },
        title: {
            text: 'New markets delivered to in the last one week'
        },
        xAxis: {
            categories: [
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
                'Sunday'
            ],
            plotBands: [{ // visualize the weekend
                from: 4.5,
                to: 6.5,
                color: 'white'
            }]
        },
        yAxis: {
            title: {
                text: 'Number of transactions'
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' transaction'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            line: {
                fillOpacity: 0.5
            }
        },
        series: [{
            name: 'Last Week',
            data: <?php echo json_encode($test4); ?>
        }, ]
    });




    $(document).ready(function() {

        var data = {
            "test5": "test5"
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: 'post',
            url: 'http://localhost/gharobar/Line_controller/json_data',
            data: data,
            dataType: 'json',
            async: false,
            success: function(data) {
                // console.log(data);
                dataMap = data;
            }
        });
        console.log(dataMap);
    });

    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'GROWTH OVER LAST WEEK'
        },
        credits: {
            enabled: false
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total growth percent'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}%'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },

        series: [{
            name: "Days",
            colorByPoint: true,
            data: <?php echo json_encode($test5); ?>
        }],
        drilldown: {
            series: [{
                    name: "SUNDAY",
                    id: "SUNDAY",
                    data: <?php echo json_encode($dd1); ?>
                },
                {
                    name: "MONDAY",
                    id: "MONDAY",
                    data: <?php echo json_encode($dd1); ?>
                },
                {
                    name: "TUESDAY",
                    id: "TUESDAY",
                    data: <?php echo json_encode($dd1); ?>
                },
                {
                    name: "WEDNESDAY",
                    id: "WEDNESDAY",
                    data: <?php echo json_encode($dd1); ?>
                },
                {
                    name: "THRUSDAY",
                    id: "THRUSDAY",
                    data: <?php echo json_encode($dd1); ?>
                },
                {
                    name: "FRIDAY",
                    id: "FRIDAY",
                    data: <?php echo json_encode($dd1); ?>
                },
                {
                    name: "SATURDAY",
                    id: "SATURDAY",
                    data: <?php echo json_encode($dd1); ?>
                },

            ]
        }
    });


    // Create the chart
    $(document).ready(function() {

        var data = {
            "test6": "test6"
        }

        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: 'post',
            url: 'http://localhost/gharobar/Bar_controller/json_data',
            data: data,
            dataType: 'json',
            async: false,
            success: function(data) {

                // console.log(data);
                dataMap = data;
            }
        });
    });
    Highcharts.chart('container-fluid', {
        chart: {
            type: 'column'
        },

        title: {
            text: 'GROWTH OVER LAST WEEK'
        },
        credits: {
            enabled: false
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total transaction percent'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}%'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },

        series: [{
            name: "Days",
            colorByPoint: true,
            data: <?php echo json_encode($test6); ?>
        }],
        drilldown: {
            series: [{
                    name: "SUNDAY",
                    id: "SUNDAY",
                    data: <?php echo json_encode($dd2); ?>
                },
                {
                    name: "MONDAY",
                    id: "MONDAY",
                    data: <?php echo json_encode($dd2); ?>


                },
                {
                    name: "TUESDAY",
                    id: "TUESDAY",
                    data: <?php echo json_encode($dd2); ?>
                },
                {
                    name: "WEDNESDAY",
                    id: "WEDNESDAY",
                    data: <?php echo json_encode($dd2); ?>
                },
                {
                    name: "THRUSDAY",
                    id: "THRUSDAY",
                    data: <?php echo json_encode($dd2); ?>
                },
                {
                    name: "FRIDAY",
                    id: "FRIDAY",
                    data: <?php echo json_encode($dd2); ?>
                },
                {
                    name: "SATURDAY",
                    id: "SATURDAY",
                    data: <?php echo json_encode($dd2); ?>
                },

            ]
        }
    });

    $(document).ready(function() {
        var data = {
            "test7": "test7"
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: 'post',
            url: 'http://localhost/gharobar/Pie_controller/json_data',
            data: data,
            dataType: 'json',
            async: false,
            success: function(data) {

                // console.log(data);
                dataMap = data;
            }
        });
    });

    Highcharts.chart(container1, {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie',
        },

        title: {
            text: 'Active Customer placed order in 3 months'
        },
        credits: {
            enabled: false
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'Customers',
            colorByPoint: true,
            data: <?php echo json_encode($test7); ?>
        }],
        drilldown: {
            series: [{
                    name: "Deepansh",
                    id: "Deepansh",
                    data: <?php echo json_encode($dy1); ?>
                }, {
                    name: "Navin",
                    id: "Navin",
                    data: <?php echo json_encode($dy2); ?>
                },
                {
                    name: "Rajesh",
                    id: "Rajesh",
                    data: <?php echo json_encode($dy3); ?>
                },
                {
                    name: "knight",
                    id: "knight",
                    data: <?php echo json_encode($dy4); ?>
                },
                {
                    name: "Joker",
                    id: "Joker",
                    data: <?php echo json_encode($dy5); ?>
                },
                {
                    name: "Arrow",
                    id: "Arrow",
                    data: <?php echo json_encode($dy6); ?>
                }
            ],
        }
    });

    $(document).ready(function() {
        var data = {
            "test8": "test8"
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: 'post',
            url: 'http://localhost/gharobar/Pie_controller/json_data',
            data: data,
            dataType: 'json',
            async: false,
            success: function(data) {

                // console.log(data);
                dataMap = data;
            }
        });
    });
    Highcharts.chart(container2, {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie',
        },

        title: {
            text: 'Active Customer  not placed order in 3 months'
        },
        credits: {
            enabled: false
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',

                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'Customers',
            colorByPoint: true,
            data: <?php echo json_encode($test8); ?>
        }],
        drilldown: {
            series: [{
                    name: "Deepansh",
                    id: "Deepansh",
                    data: <?php echo json_encode($dy1); ?>
                }, {
                    name: "Navin",
                    id: "Navin",
                    data: <?php echo json_encode($dy2); ?>
                },
                {
                    name: "Rajesh",
                    id: "Rajesh",
                    data: <?php echo json_encode($dy3); ?>
                },
                {
                    name: "knight",
                    id: "knight",
                    data: <?php echo json_encode($dy4); ?>
                },
                {
                    name: "Joker",
                    id: "Joker",
                    data: <?php echo json_encode($dy5); ?>
                },
                {
                    name: "Arrow",
                    id: "Arrow",
                    data: <?php echo json_encode($dy6); ?>
                }
            ],
        }

    });
</script>