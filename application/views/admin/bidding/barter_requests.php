<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
	.table-responsive>.even {
		border: inherit;
		border-collapse: separate;
		border-spacing: 0 35px;
	}

	.table-responsive>.even>tbody>tr>td {
		padding: 16px;
		background-color: #fdfdfda4;
		backdrop-filter: blur(10px);
		-webkit-backdrop-filter: blur(10px);
		padding-left: 1%;

	}

	@media only screen and (max-width: 760px),
	(min-device-width: 768px) and (max-device-width: 1024px) {

		/* Force table to not be like tables anymore */
		table,
		thead,
		tbody,
		th,
		td,
		tr {
			display: block;
		}

		/* Hide table headers (but not display: none;, for accessibility) */
		thead tr {
			position: absolute;
			top: -9999px;
			left: -9999px;
		}

		tr {
			margin: 0 0 1rem 0;
		}

		tr:nth-child(odd) {
			background: #ccc;
		}

		td {
			/* Behave  like a "row" */
			border: none;
			border-bottom: 1px solid #eee;
			position: relative;
			padding-left: 50%;
		}

		td:before {
			/* Now like a table header */
			position: absolute;
			/* Top/left values mimic padding */
			top: 0;
			left: 6px;
			width: 45%;
			padding-right: 10px;
			white-space: nowrap;
		}
	}

	.th {
		text-align: center;
	}

	.table-responsive>.even>thead>tr>th:first-child {
		border-top-left-radius: 25px;
		border-bottom-left-radius: 25px;
	}

	.table-responsive>.even>thead>tr>th:last-child {
		border-top-right-radius: 25px;
		border-bottom-right-radius: 25px;
	}

	.table-responsive>.even>tbody>tr>td:first-child {
		border-top-left-radius: 10px;
		border-bottom-left-radius: 10px;
	}

	.table-responsive>.even>tbody>tr>td:last-child {
		border-top-right-radius: 10px;
		border-bottom-right-radius: 10px;
	}

	.table-responsive>.even>thead>tr>th {
		padding: 10px;
		background-color: #fdfdfda4;
		backdrop-filter: blur(10px);
	}

	.table-striped>tbody>tr:nth-of-type(odd) {
		background-color: rgba(255, 255, 255, 0.5);
	}

	.table-bordered>tbody>tr>td {
		border: inherit;
	}

	.table-bordered>thead>tr>th {
		border: transparent;
	}

	.table>thead:first-child>tr:first-child>th {
		color: black;
		border-top: none;
		font-weight: 900;
	}
</style>
<div class="">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $title; ?></h3>
	</div><!-- /.box-header -->

	<div class="box-body">
		<div class="row">
			<!-- include message block -->
			<div class="col-sm-12">
				<?php $this->load->view('admin/includes/_messages'); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table table-bordered table-striped even" role="grid">
						<?php $this->load->view('admin/bidding/_filter_barter_requests'); ?>
						<thead>
							<tr role="row">
								<th style="text-align: center;">Barter</th>
								<th style="text-align: center;">Product 1</th>
								<th style="text-align: center; width:135px;">Seller of Product 1</th>
								<th style="text-align: center;">Product 2</th>
								<th style="text-align: center; width:135px">Seller of Product 2</th>
								<th style="text-align: center;"><?php echo trans('status'); ?></th>

								<th style="text-align: center;"><?php echo trans('updated'); ?></th>
								<th style="text-align: center;"><?php echo trans('date'); ?></th>
								<th class="max-width-120" style="text-align: center;"><?php echo trans('options'); ?></th>
							</tr>
						</thead>
						<tbody>

							<?php foreach ($quote_requests as $item) : ?>
								<tr>
									<td>#<?php echo $item->id; ?></td>
									<td class="td-product">
										<?php $product = get_product($item->product_id);
										if (!empty($product)) : ?>
											<div class="img-table">
												<a href="<?php echo generate_product_url($product); ?>" target="_blank">
													<img src="<?php echo get_product_image($product->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
												</a>
											</div>
											<a href="<?php echo generate_product_url($product); ?>" target="_blank" class="table-product-title">
												<?php echo html_escape($item->product_title); ?>
											</a><br>
											<?php echo trans("quantity") . ": " . $item->product_quantity; ?>
										<?php endif; ?>
									</td>
									<td>


										<?php $seller = get_user($item->seller_id);
										if (!empty($seller)) : ?>
											<a href="<?php echo generate_profile_url($seller->slug); ?>" target="_blank" class="font-600">
												<?= get_shop_name($seller); ?>
											</a>
										<?php endif; ?>
									</td>
									<td class="td-product">
										<?php $product = get_product($item->barter_product_id);
										$product_details = get_product_details_by_id($item->barter_product_id);
										if (!empty($product)) : ?>
											<div class="img-table">
												<a href="<?php echo generate_product_url($product); ?>" target="_blank">
													<img src="<?php echo get_product_image($product->id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
												</a>
											</div>
											<a href="<?php echo generate_product_url($product); ?>" target="_blank" class="table-product-title">
												<?php echo html_escape($product_details->title); ?>
											</a><br>
											<?php echo trans("quantity") . ": " . $item->product_quantity; ?>
										<?php endif; ?>
									</td>
									<td>
										<?php $seller = get_user($item->buyer_id);
										if (!empty($seller)) : ?>
											<a href="<?php echo generate_profile_url($seller->slug); ?>" target="_blank" class="font-600">
												<?= get_shop_name($seller); ?>
											</a>
										<?php endif; ?>
									</td>

									<td><?php echo trans($item->status); ?></td>

									<td><?php echo time_ago($item->updated_at); ?></td>
									<td><?php echo formatted_date($item->created_at); ?></td>
									<td>
										<div class="dropdown">
											<button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?php echo trans('select_option'); ?>
												<span class="caret"></span>
											</button>
											<ul class="dropdown-menu options-dropdown">
												<li>
													<a href="javascript:void(0)" onclick="delete_item('admin_controller/delete_barter_request_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
												</li>
											</ul>
										</div>
									</td>
								</tr>

							<?php endforeach; ?>

						</tbody>
					</table>

					<?php if (empty($quote_requests)) : ?>
						<p class="text-center">
							<?php echo trans("no_records_found"); ?>
						</p>
					<?php endif; ?>
					<div class="col-sm-12 table-ft">
						<div class="row">
							<div class="pull-right">
								<?php echo $this->pagination->create_links(); ?>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div><!-- /.box-body -->
</div>