<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<style>
  .content {
    background-color: lightgray !important;
  }
</style>

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
</style>


<div class="row">
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box admin-small-box bg-success">
      <div class="inner">
        <h3 class="increase-count"><?php echo $order_count; ?></h3>
        <a href="<?php echo admin_url(); ?>orders">
          <p><?php echo trans("orders"); ?></p>
        </a>
      </div>
      <div class="icon">
        <a href="<?php echo admin_url(); ?>orders">
          <i class="fa fa-shopping-cart"></i>
        </a>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box admin-small-box bg-purple">
      <div class="inner">
        <h3 class="increase-count"><?php echo $product_count; ?></h3>
        <a href="<?php echo admin_url(); ?>products">
          <p><?php echo trans("products"); ?></p>
        </a>
      </div>
      <div class="icon">
        <a href="<?php echo admin_url(); ?>products">
          <i class="fa fa-shopping-basket"></i>
        </a>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box admin-small-box bg-danger">
      <div class="inner">
        <h3 class="increase-count"><?php echo $pending_product_count; ?></h3>
        <a href="<?php echo admin_url(); ?>pending-products">
          <p><?php echo trans("pending_products"); ?></p>
        </a>
      </div>
      <div class="icon">
        <a href="<?php echo admin_url(); ?>pending-products">
          <i class="fa fa-low-vision"></i>
        </a>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box admin-small-box bg-warning">
      <div class="inner">
        <h3 class="increase-count"><?php echo $members_count; ?></h3>
        <a href="<?php echo admin_url(); ?>members">
          <p><?php echo trans("members"); ?></p>
        </a>
      </div>
      <div class="icon">
        <a href="<?php echo admin_url(); ?>members">
          <i class="fa fa-users"></i>
        </a>
      </div>
    </div>
  </div>

</div>
<div class="row">


  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box admin-small-box bg-teal">
      <div class="inner">
        <h3 class="increase-count"><?php echo $service_count; ?></h3>
        <a href="<?php echo admin_url(); ?>services">
          <p>Services</p>
        </a>
      </div>
      <div class="icon">
        <a href="<?php echo admin_url(); ?>services">
          <i class="fa fa-user"></i>
        </a>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box admin-small-box bg-navy">
      <div class="inner">
        <h3 class="increase-count"><?php echo $pending_service_count; ?></h3>
        <a href="<?php echo admin_url(); ?>pending-services">
          <p>Pending Services</p>
        </a>
      </div>
      <div class="icon">
        <a href="<?php echo admin_url(); ?>pending-services">
          <i class="fa fa-eye"></i>
        </a>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box admin-small-box bg-maroon-active">
      <div class="inner">
        <h3 class="increase-count"><?php echo $barter_count; ?></h3>

        <p>Barter Products</p>

      </div>
      <div class="icon">

        <i class="fa fa-eye"></i>

      </div>
    </div>
  </div>

  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box admin-small-box bg-fuchsia-active">
      <div class="inner">
        <h3 class="increase-count"><?php echo $pending_barter_count; ?></h3>

        <p>Pending Barter Products</p>

      </div>
      <div class="icon">

        <i class="fa fa-eye"></i>

      </div>
    </div>
  </div>
</div>
<!-- custom analytics  -->

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

<div class="row">
  <div class="col-lg-6 col-sm-12 col-xs-12">
    <div class="box box-primary box-sm">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo trans("latest_orders"); ?></h3>
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
                <th><?php echo trans("order"); ?></th>
                <th><?php echo trans("total"); ?></th>
                <th><?php echo trans("status"); ?></th>
                <th><?php echo trans("date"); ?></th>
                <th><?php echo trans("details"); ?></th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($latest_orders as $item) : ?>
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
                    <a href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($item->id); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                  </td>
                </tr>

              <?php endforeach; ?>

            </tbody>
          </table>
        </div>
        <!-- /.table-responsive -->
      </div>

      <div class="box-footer clearfix">
        <a href="<?php echo admin_url(); ?>orders" class="btn btn-sm btn-default pull-right"><?php echo trans("view_all"); ?></a>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-sm-12 col-xs-12">
    <div class="box box-primary box-sm">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo trans("latest_transactions"); ?></h3>
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
                <th><?php echo trans("order"); ?></th>
                <th><?php echo trans("payment_amount"); ?></th>
                <th><?php echo trans('payment_method'); ?></th>
                <th><?php echo trans('status'); ?></th>
                <th><?php echo trans("date"); ?></th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($latest_transactions as $item) : ?>
                <tr>
                  <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                  <td style="white-space: nowrap">#<?php
                                                    $order = $this->order_admin_model->get_order($item->order_id);
                                                    if (!empty($order)) :
                                                      echo $order->order_number;
                                                    endif; ?>
                  </td>
                  <td><?php echo price_currency_format($item->payment_amount, $item->currency); ?></td>
                  <td><?= get_payment_method($item->payment_method); ?></td>
                  <td><?php echo trans($item->payment_status); ?></td>
                  <td><?php echo formatted_date($item->created_at); ?></td>
                </tr>

              <?php endforeach; ?>

            </tbody>
          </table>
        </div>
        <!-- /.table-responsive -->
      </div>

      <div class="box-footer clearfix">
        <a href="<?php echo admin_url(); ?>transactions" class="btn btn-sm btn-default pull-right"><?php echo trans("view_all"); ?></a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-6 col-sm-12 col-xs-12">
    <div class="box box-primary box-sm">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo trans("latest_products"); ?></h3>
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
                <th><?php echo trans("name"); ?></th>
                <th><?php echo trans("details"); ?></th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($latest_products as $item) : ?>
                <tr>
                  <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                  <td class="td-product-small">
                    <div class="img-table">
                      <a href="<?php echo generate_product_url($item); ?>" target="_blank">
                        <img src="<?php echo get_product_image($item->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                      </a>
                    </div>
                    <a href="<?php echo generate_product_url($item); ?>" target="_blank" class="table-product-title">
                      <?php echo get_product_title($item); ?>
                    </a>
                    <br>
                    <div class="table-sm-meta">
                      <?php echo time_ago($item->created_at); ?>
                    </div>
                  </td>
                  <td style="width: 10%">
                    <a href="<?php echo admin_url(); ?>product-details/<?php echo html_escape($item->id); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                  </td>
                </tr>

              <?php endforeach; ?>

            </tbody>
          </table>
        </div>
        <!-- /.table-responsive -->
      </div>

      <div class="box-footer clearfix">
        <a href="<?php echo admin_url(); ?>products" class="btn btn-sm btn-default pull-right"><?php echo trans("view_all"); ?></a>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-sm-12 col-xs-12">
    <div class="box box-primary box-sm">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo trans("latest_pending_products"); ?></h3>
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
                <th><?php echo trans("name"); ?></th>
                <th><?php echo trans("details"); ?></th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($latest_pending_products as $item) : ?>
                <tr>
                  <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                  <td class="td-product-small">
                    <div class="img-table">
                      <a href="<?php echo generate_product_url($item); ?>" target="_blank">
                        <img src="<?php echo get_product_image($item->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                      </a>
                    </div>
                    <a href="<?php echo generate_product_url($item); ?>" target="_blank" class="table-product-title">
                      <?php echo get_product_title($item); ?>
                    </a>
                    <br>
                    <div class="table-sm-meta">
                      <?php echo time_ago($item->created_at); ?>
                    </div>
                  </td>
                  <td style="width: 10%;vertical-align: center !important;">
                    <a href="<?php echo admin_url(); ?>product-details/<?php echo html_escape($item->id); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                  </td>
                </tr>

              <?php endforeach; ?>

            </tbody>
          </table>
        </div>
        <!-- /.table-responsive -->
      </div>

      <div class="box-footer clearfix">
        <a href="<?php echo admin_url(); ?>pending-products" class="btn btn-sm btn-default pull-right"><?php echo trans("view_all"); ?></a>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6 col-sm-12 col-xs-12">
    <div class="box box-primary box-sm">
      <div class="box-header with-border">
        <h3 class="box-title">Latest Services</h3>
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
                <th><?php echo trans("name"); ?></th>
                <th><?php echo trans("details"); ?></th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($latest_services as $item) : ?>
                <tr>
                  <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                  <td class="td-product-small">
                    <div class="img-table">
                      <a href="<?php echo generate_product_url($item); ?>" target="_blank">
                        <img src="<?php echo get_product_image($item->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                      </a>
                    </div>
                    <a href="<?php echo generate_product_url($item); ?>" target="_blank" class="table-product-title">
                      <?php echo get_product_title($item); ?>
                    </a>
                    <br>
                    <div class="table-sm-meta">
                      <?php echo time_ago($item->created_at); ?>
                    </div>
                  </td>
                  <td style="width: 10%">
                    <a href="<?php echo admin_url(); ?>service-details/<?php echo html_escape($item->id); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                  </td>
                </tr>

              <?php endforeach; ?>

            </tbody>
          </table>
        </div>
        <!-- /.table-responsive -->
      </div>

      <div class="box-footer clearfix">
        <a href="<?php echo admin_url(); ?>services" class="btn btn-sm btn-default pull-right"><?php echo trans("view_all"); ?></a>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-sm-12 col-xs-12">
    <div class="box box-primary box-sm">
      <div class="box-header with-border">
        <h3 class="box-title">Latest Pending Services</h3>
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
                <th><?php echo trans("name"); ?></th>
                <th><?php echo trans("details"); ?></th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($latest_pending_services as $item) : ?>
                <tr>
                  <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                  <td class="td-product-small">
                    <div class="img-table">
                      <a href="<?php echo generate_product_url($item); ?>" target="_blank">
                        <img src="<?php echo get_product_image($item->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                      </a>
                    </div>
                    <a href="<?php echo generate_product_url($item); ?>" target="_blank" class="table-product-title">
                      <?php echo get_product_title($item); ?>
                    </a>
                    <br>
                    <div class="table-sm-meta">
                      <?php echo time_ago($item->created_at); ?>
                    </div>
                  </td>
                  <td style="width: 10%;vertical-align: center !important;">
                    <a href="<?php echo admin_url(); ?>service-details/<?php echo html_escape($item->id); ?>" class="btn btn-xs btn-info"><?php echo trans('details'); ?></a>
                  </td>
                </tr>

              <?php endforeach; ?>

            </tbody>
          </table>
        </div>
        <!-- /.table-responsive -->
      </div>

      <div class="box-footer clearfix">
        <a href="<?php echo admin_url(); ?>pending-services" class="btn btn-sm btn-default pull-right"><?php echo trans("view_all"); ?></a>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-6 col-sm-12 col-xs-12">
    <div class="box box-primary box-sm">
      <div class="box-header with-border">
        <h3 class="box-title"><?php echo trans("latest_transactions"); ?>&nbsp;<small style="font-size: 13px;">(Featured Products and Services)</small>
        </h3>
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
                <th><?php echo trans('payment_method'); ?></th>
                <th><?php echo trans("payment_amount"); ?></th>
                <th><?php echo trans('status'); ?></th>
                <th><?php echo trans("date"); ?></th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($latest_promoted_transactions as $item) : ?>
                <tr>
                  <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                  <td><?= get_payment_method($item->payment_method); ?></td>
                  <td><?php echo price_currency_format($item->payment_amount, $item->currency); ?></td>
                  <td><?php echo trans($item->payment_status); ?></td>
                  <td><?php echo formatted_date($item->created_at); ?></td>
                </tr>

              <?php endforeach; ?>

            </tbody>
          </table>
        </div>
        <!-- /.table-responsive -->
      </div>

      <div class="box-footer clearfix">
        <a href="<?php echo admin_url(); ?>featured-products-transactions" class="btn btn-sm btn-default pull-right"><?php echo trans("view_all"); ?></a>
      </div>
    </div>
  </div>

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
                <th><?php echo trans("username"); ?></th>
                <th style="width: 60%"><?php echo trans("review"); ?></th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($latest_reviews as $item) : ?>
                <tr>
                  <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                  <td style="width: 25%" class="break-word">
                    <?php echo html_escape($item->user_username); ?>
                  </td>
                  <td style="width: 65%" class="break-word">
                    <div>
                      <?php $this->load->view('admin/includes/_review_stars', ['review' => $item->rating]); ?>
                    </div>
                    <?php echo character_limiter($item->review, 100); ?>
                    <div class="table-sm-meta">
                      <?php echo time_ago($item->created_at); ?>
                    </div>
                  </td>
                </tr>

              <?php endforeach; ?>

            </tbody>
          </table>
        </div>
        <!-- /.table-responsive -->
      </div>

      <div class="box-footer clearfix">
        <a href="<?php echo admin_url(); ?>reviews" class="btn btn-sm btn-default pull-right"><?php echo trans("view_all"); ?></a>
      </div>
    </div>
  </div>
</div>

<div class="row">
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
                <th><?php echo trans("user"); ?></th>
                <th style="width: 60%"><?php echo trans("comment"); ?></th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($latest_comments as $item) : ?>
                <tr>
                  <td style="width: 10%"><?php echo html_escape($item->id); ?></td>
                  <td style="width: 25%" class="break-word">
                    <?php echo html_escape($item->name); ?>
                  </td>
                  <td style="width: 65%" class="break-word">
                    <?php echo character_limiter($item->comment, 100); ?>
                    <div class="table-sm-meta">
                      <?php echo time_ago($item->created_at); ?>
                    </div>
                  </td>
                </tr>

              <?php endforeach; ?>

            </tbody>
          </table>
        </div>
        <!-- /.table-responsive -->
      </div>

      <div class="box-footer clearfix">
        <a href="<?php echo admin_url(); ?>product-comments" class="btn btn-sm btn-default pull-right"><?php echo trans("view_all"); ?></a>
      </div>
    </div>
  </div>

  <div class="no-padding margin-bottom-20">
    <div class="col-lg-6 col-sm-12 col-xs-12">
      <!-- USERS LIST -->
      <div class="box box-primary box-sm">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo trans("latest_members"); ?></h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <ul class="users-list clearfix">
            <?php if (!empty($latest_members)) :
              foreach ($latest_members as $item) : ?>
                <li>
                  <a href="<?php echo generate_profile_url($item->slug); ?>">
                    <img src="<?php echo get_user_avatar($item); ?>" alt="user" class="img-responsive">
                  </a>
                  <a href="<?php echo generate_profile_url($item->slug); ?>" class="users-list-name"><?php echo html_escape($item->username); ?></a>
                  <span class="users-list-date"><?php echo time_ago($item->created_at); ?></span>
                </li>
            <?php endforeach;
            endif; ?>
          </ul>
          <!-- /.users-list -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
          <a href="<?php echo admin_url(); ?>members" class="btn btn-sm btn-default btn-flat pull-right"><?php echo trans("view_all"); ?></a>
        </div>
        <!-- /.box-footer -->
      </div>
      <!--/.box -->
    </div>
  </div>
</div>


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