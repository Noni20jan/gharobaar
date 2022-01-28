<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/main-1.7.css"> -->
<style>
	.row-custom {
		padding-right: 15px;
		padding-left: 15px;
	}
</style>

<!-- Wrapper -->
<div id="wrapper">
	<div class="container">
		<div class="row webOrderView">
			<!-- <div class="col-sm-12"> -->
			<div class="box box-primary">
				<div class="box-header with-border">
					<div class="left">
						<h3 class="page-title" style="margin: 0px;"><?php echo $title; ?></h3>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="row-custom">
							<div class="profile-tab-content">
								<!-- include message block -->
								<?php $this->load->view('partials/_messages'); ?>
								<?php if (!empty($orders)) : ?>
									<div class="row-new-view">
										<table class="even table table-striped table-products">
											<thead>
												<tr class="rock">
													<th scope="col"><?php echo trans("order"); ?></th>
													<th scope="col" style="width: 50%;"><?php echo trans("product"); ?></th>
													<th scope="col"><?php echo trans("price"); ?></th>
													<!-- <th scope="col"><?php echo trans("payment"); ?></th> -->
													<th scope="col"><?php echo trans("status"); ?></th>
													<!-- <th scope="col"><?php echo trans("date"); ?></th> -->
													<th></th>
													<th scope="col"><?php echo trans("options"); ?></th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($orders as $order) : ?>

													<tr>
														<td>#<?php echo $order->order_id; ?></td>
														<td style="padding-left:0px;">
															<div class="table-item-product">

																<div class="left">
																	<div class="img-table">

																		<?php $item = $order->product_id;
																		$product =  get_product($item); ?>
																		<a href="<?php echo generate_product_url($product); ?>" target="_blank">
																			<img src="<?php echo get_product_image($product->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
																	</div>
																</div>
																<div class="right">
																	<?php echo $order->product_title; ?>

																	<p><?php echo trans('seller') ?>:<?php $seller = $order->seller_id; ?>
																		<?php $shop = get_user($seller) ?>
																		<?php if (!empty($seller)) : ?>
																			<a href="<?php echo generate_profile_url($shop->slug); ?>" target="_blank" class="table-product-title">
																				<strong class="font-600"><?php echo get_shop_name($shop); ?></strong></a>
																	</p>
																</div>
															</div>
														</td>
														<td><?php echo price_formatted($order->product_total_price, 'INR'); ?>/-</td>
														<!-- <td>
																<?php if ($order->payment_status == 'payment_received') :
																				echo trans("payment_received");
																			else :
																				echo trans("awaiting_payment");
																			endif; ?>
															</td> -->
														<td>
															<strong class="font-600">
																<?php if ($order->order_status == "awaiting_pickup") : ?>
																	<?php echo trans("processing");  ?>
																<?php else : ?>
																<?php echo trans($order->order_status);
																			endif; ?>
															</strong>
														</td>
														<!-- <td><?php echo formatted_date($order->created_at); ?></td> -->
														<?php $items = $order->order_status; ?>

														<td><?php if ($order->order_status == 'shipped') : ?>
																<img src="<?php echo base_url(); ?>assets/img/order_car.png">
															<?php else :
															?>
																<img src="">

															<?php endif; ?>
														</td>

														<td>
															<a href="<?php echo generate_url("order_details") . "/" . get_order($order->order_id)->order_number; ?>" style="color:white; background-color:#d21f3c;" class="btn btn-sm btn-table-info"><?php echo trans("details"); ?></a><br />
															<span>
																<?php $datetime = new DateTime($order->created_at);
																			$formatted_date_month = $datetime->format('M');
																			$format_date_day = $datetime->format('d');
																			$format_date_year = $datetime->format('Y');
																?>
																<p style="margin: 0px;"> <?php if ($order->payment_status == 'awaiting_payment') :
																								// if ($order->payment_method == 'Cash On Delivery') {
																								// 	echo trans("order_processing");
																								// } else {
																								echo trans("awaiting_payment");
																							// }
																							else :
																								if ($order->order_status == 'completed') :
																									echo trans("completed");

																								else :
																									echo trans("order_processing");
																								endif;
																							endif; ?> on <?php echo ($formatted_date_month); ?>&nbsp;<?php echo ($format_date_day); ?>'<?php echo ($format_date_year); ?></p>
															</span>
															<p style="margin: 0px;">Your item is <strong class="font-600"><?php if ($order->order_status == 'completed') : ?> Delivered
																	<?php elseif ($items == "shipped" || $items == "out_for_delivery") : ?>
																		on its way
																	<?php elseif ($items == "cancelled_by_seller" || $items == "cancelled_by_user") : ?>
																		cancelled
																	<?php elseif ($items == "rejected") : ?>
																		rejected
																	<?php else : ?>
																		under process
																	<?php endif; ?>
																</strong></p>
															<!-- <i class="fa fa-star" style="color:#e75480;" ;></i>
																<span style="color:#e75480 ;">Rate & Review the Product</span> -->
														</td>
													</tr>
												<?php endif; ?>
											<?php endforeach; ?>

											</tbody>
										</table>
									</div>
								<?php endif; ?>
								<?php if (empty($orders)) : ?>
									<div class="row">
										<div class="col-sm-12">
											<div class="box box-primary">
												<div class="box-body">
													<div class="row" style="margin: 10px; padding: 15px;border-radius: 20px;">
														<div class="col-12">
															<!-- form start -->
															<center>
																<h1> No Orders To Show </h1>
																<br>
																<p>
																<h4>
																	Order section is empty. After placing order, You can track them from here!
																</h4>
																</p>
																<br>
																<img src="<?php echo base_url() . "/assets/img/order.png" ?>">

															</center>
														</div>

													</div>
												</div>
											</div>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<div class="row-custom m-t-15">
							<div class="text-center">
								<?php echo $this->pagination->create_links(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="mobileOrderView">
		<div class="col-12">
			<div class="box" id="boxbg" style="padding-left:0px;">
				<div class="with-border">
					<div class="left">
						<h3 class="page-title"><?php echo $title; ?></h3>
					</div>
				</div>
				<div class="row">
					<!-- <div class="col-md-12"> -->
					<div class="row-custom">
						<div class="profile-tab-content">
							<!-- include message block -->
							<?php $this->load->view('partials/_messages'); ?>
							<?php if (!empty($orders)) : ?>
								<div class="row-new-view">
									<table class="even table table-striped table-products">
										<thead>
											<tr>
												<th scope="col"><?php echo trans("product"); ?></th>

											</tr>
										</thead>
										<tbody>
											<?php foreach ($orders as $order) : ?>
												<?php $items = $order->order_status; ?>
												<tr>
													<td style="padding-left:0px;background-color: #ebebeb;border-bottom: 1px solid grey;border-top:none;">
														<a href="<?php echo generate_url("order_details") . "/" . get_order($order->order_id)->order_number; ?>">
															<div class="table-item-product" style="width:100%;">

																<div class="left">
																	<div class="img-table">

																		<?php $item = $order->product_id;
																		$product =  get_product($item); ?>
																		<!-- <a href="<?php echo generate_product_url($product); ?>" target="_blank"> -->
																		<img src="<?php echo get_product_image($product->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
																		<!-- </a> -->
																	</div>
																</div>
																<div class="left" style="text-align:center;">

																	<?php if ($order->order_status == 'completed') : ?>
																		<p style="color: black;">&emsp;Your item is <strong class="font-600">Delivered</strong></p>
																	<?php elseif ($items == "shipped" || $items == "out_for_delivery") : ?>
																		<p style="color: #d21f3c;">Your item is <strong class="font-600">on its way</strong></p>
																	<?php elseif ($items == "cancelled_by_seller" || $items == "cancelled_by_user") : ?>
																		<p style="color: red;">Your item is <strong class="font-600">cancelled</strong></p>
																	<?php elseif ($items == "rejected") : ?>
																		<p style="color: red;">Your item is <strong class="font-600">rejected</strong></p>
																	<?php else : ?>
																		<p style="color: #d21f3c;">&emsp;Your item is <strong class="font-600">under process</strong></p>
																	<?php endif; ?>





																</div>
																<div class="right">
																	<i class="icon-arrow-right" style="color:black;float: right;"></i>
																</div>

															</div>
														</a>
													</td>

												</tr>
											<?php endforeach; ?>

										</tbody>
									</table>
								</div>
							<?php endif; ?>
							<?php if (empty($orders)) : ?>
								<div class="row">
									<div class="col-sm-12">
										<div class="box box-primary">
											<div class="box-body">
												<div class="row" style="margin: 10px; padding: 15px;border-radius: 20px;">
													<div class="col-12">
														<!-- form start -->
														<center>
															<h1> No Orders To Show </h1>
															<br>
															<p>
															<h4>
																Order section is empty. After placing order, You can track them from here!
															</h4>
															</p>
															<br>
															<img src="<?php echo base_url() . "/assets/img/order.png" ?>">

														</center>
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
					<div class="row-custom m-t-15">
						<div class="text-center">
							<?php echo $this->pagination->create_links(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</div>
<!-- Wrapper End-->