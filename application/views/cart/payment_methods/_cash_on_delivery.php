<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if ($cart_payment_method->payment_option == "cash_on_delivery") : ?>
	<style>
		.shipping_details {
			text-align: justify;
		}

		.block-title {
			text-align: start;
		}

		.cash_free_btn {
			background-color: #007C05 !important;
			cursor: pointer;
			color: #fff !important;
			font-weight: 600 !important;
			padding: .64rem 2.8rem !important;
			min-width: 200px;
			max-width: 100% !important;
		}

		@media only screen and (max-width: 800px) {
			.shipping_details {
				text-align: justify;
				margin-left: 4%;
			}
		}



		#payment_option {
			text-align: start;
		}



		#place_order {
			/* margin-right: 23%; */
			margin-bottom: 11px;
		}

		@media only screen and (max-width: 800px) {
			#place_order {

				/* margin-right: 23%; */
				margin-bottom: 14px;

			}
		}

		.billing_details {
			text-align: justify;
		}

		@media only screen and (max-width: 800px) {
			.billing_details {
				text-align: justify;
				margin-left: 4%;

			}
		}


		@media only screen and (max-width: 800px) {
			#city {
				margin-left: 1%;
			}
		}
	</style>
	<?php $is_all_deliverable = 1;
	foreach ($cart_items as $item) {
		if (!$item->product_deliverable) {
			$is_all_deliverable = 0;
			break;
		}
	}
	?>
	<?php if ($mds_payment_type != 'promote') : ?>
		<!--PRODUCT SALES-->
		<div class="row">
			<div class="col-12">
				<?php $this->load->view('product/_messages'); ?>
			</div>
		</div>
		<?php //echo //form_open('cart_controller/cash_on_delivery_payment_post'); 
		?>
		<div id="payment-button-container">
			<div class="row">
				<div class="col-md-6">
					<h5 class="block-title" id="shipping"><?php echo trans("shipping_address") ?></h5>
					<?php $address = $this->session->userdata("mds_cart_shipping_address") ?>

					<div class="shipping_details">
						<p><?php echo $address->shipping_first_name . " " . $address->shipping_last_name ?></p>
						<p><?php echo $address->shipping_address_1 ?></p>
						<p><?php echo $address->shipping_area ?></p>
						<p><?php echo $address->shipping_landmark ?></p>

						<p><?php echo $address->shipping_city . "," . $address->shipping_state . " -" . $address->shipping_zip_code ?>
						<div id="phone_number"> <label>Phone:</label><span>
								<?php echo $address->shipping_phone_number ?>
							</span>
							</label>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<h5 class="block-title" id="billing"><?php echo trans("billing_address") ?></h5>
					<?php $address = $this->session->userdata("mds_cart_shipping_address") ?>

					<div class="billing_details">
						<p><?php echo $address->billing_first_name . " " . $address->billing_last_name ?></p>
						<p><?php echo $address->billing_address_1 ?></p>
						<p><?php echo $address->billing_area ?></p>
						<p><?php echo $address->billing_landmark ?></p>

						<p><?php echo $address->billing_city . "," . $address->billing_state . "-" . $address->billing_zip_code ?></p>
						<div id="phone_number"> <label>Phone:</label><span>
								<?php echo $address->billing_phone_number ?>
							</span>
							</label>
						</div>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-sm-12">
					<div class="cash_method">
						<div class="row">
							<div class="col-md-6">
								<h5 class="block-title" id="payment"><?php echo trans("payment_method") ?></h5>
							</div>
							<div class="col-md-6">
								<p id="payment_option"><?php echo trans("cash_on_delivery"); ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- <p class="m-b-30">
				<?php echo trans("cash_on_delivery_warning"); ?>
			</p> -->
			<!-- <a class="btn btn-lg btn-custom btn-place-order float-left m-t-30" href='<?php echo generate_url("cart", "payment_method") . "?payment_type=sale" ?>' ><?php echo trans("change_pay_method") ?></a> -->
			<!-- <a href="<?php echo generate_url("cart", "shipping"); ?>" class="cash_free_btn btn btn-sm float-left" style="margin-bottom: 30px;"> <?php echo trans("change_address"); ?></a> -->
			<button onclick="place_cod_orders();" <?= $is_all_deliverable ? "" : "disabled"; ?> class="cash_free_btn btn btn-lg float-right" id="place_order"><?php echo trans("place_order") ?></button>
		</div>
		<?php //echo //form_close(); 
		?>

	<?php endif; ?>

<?php endif; ?>




<script>
	$('form').submit(function() {
		$(".btn-place-order").prop('disabled', true);
	});
</script>