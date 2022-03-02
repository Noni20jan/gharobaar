<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
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
					<table class="table table-bordered table-striped" role="grid">
						<?php $this->load->view('admin/order/_filter_orders'); ?>
						<thead>
						<tr role="row">
							<th><?php echo trans('order'); ?></th>
							<th><?php echo trans('buyer'); ?></th>
							<th><?php echo trans('total'); ?></th>
							<th><?php echo trans('currency'); ?></th>
							<th><?php echo trans('status'); ?></th>
							<th><?php echo trans('payment_status'); ?></th>
							<th><?php echo trans('updated'); ?></th>
							<th><?php echo trans('date'); ?></th>
							<th class="max-width-120"><?php echo trans('options'); ?></th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($orders as $item): ?>
							<tr>
								<td class="order-number-table">
									<button type="button" class="btn btn-success exploder" id="onPlus_order_details_view" onclick="order_summary_on_orders(<?php echo $item->id; ?>);">
									<i class="fa fa-plus" aria-hidden="true"></i>
									</button>
									<a href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($item->id); ?>" class="table-link">
										#<?php echo html_escape($item->order_number); ?>
									</a>
								</td>
										
								<td>
									<?php if ($item->buyer_id == 0): ?>
										<div class="table-orders-user">
											<img src="<?php echo get_user_avatar(null); ?>" alt="buyer" class="img-responsive" style="height: 50px;">
											<?php $shipping = get_order_shipping($item->id);
											if (!empty($shipping)): ?>
												<span><?php echo $shipping->shipping_first_name . " " . $shipping->shipping_last_name; ?></span>
											<?php endif; ?>
											<label class="label bg-olive label-order-guest"><?php echo trans("guest"); ?></label>
										</div>
									<?php else:
										$buyer = get_user($item->buyer_id);
										if (!empty($buyer)):?>
											<div class="table-orders-user">
												<a href="<?php echo generate_profile_url($buyer->slug); ?>" target="_blank">
													<img src="<?php echo get_user_avatar($buyer); ?>" alt="buyer" class="img-responsive" style="height: 50px;">
													<?php echo html_escape($buyer->username); ?>
												</a>
											</div>
										<?php endif;
									endif;
									?>
								</td>
								<td><strong><?php echo price_formatted($item->price_total, $item->price_currency); ?></strong></td>
								<td><?php echo $item->price_currency; ?></td>
								<td>
									<?php if ($item->status == 1): ?>
										<label class="label label-success"><?php echo trans("completed"); ?></label>
									<?php else: ?>
										<label class="label label-default"><?php echo trans("order_processing"); ?></label>
									<?php endif; ?>
								</td>
								<td><?php echo trans($item->payment_status); ?></td>
								<td><?php echo time_ago($item->updated_at); ?></td>
								<td> <?php echo formatted_date($item->created_at); ?></td>
								<td>
									<?php echo form_open_multipart('order_admin_controller/order_options_post'); ?>
									<input type="hidden" name="id" value="<?php echo $item->id; ?>">
									<div class="dropdown">
										<button class="btn bg-purple dropdown-toggle btn-select-option"
												type="button"
												data-toggle="dropdown"><?php echo trans('select_option'); ?>
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu options-dropdown" style="min-width: 190px;">
											<li>
												<a href="<?php echo admin_url(); ?>order-details/<?php echo html_escape($item->id); ?>"><i class="fa fa-info option-icon"></i><?php echo trans('view_details'); ?></a>
											</li>
											<li>
												<?php if ($item->payment_status != 'payment_received'): ?>
													<button type="submit" name="option" value="payment_received" class="btn-list-button">
														<i class="fa fa-check option-icon"></i><?php echo trans('payment_received'); ?>
													</button>
												<?php endif; ?>
											</li>
											<li>
												<a href="javascript:void(0)" onclick="delete_item('order_admin_controller/delete_order_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
											</li>
										</ul>
									</div>
									<?php echo form_close(); ?><!-- form end -->
								</td>
							</tr>
							<tr class="explode hide">
							<td colspan="12" style="display: none;">
								<table class="table table-condensed">
								<thead>
                                    <tr role="row">
                                        <th><?php echo trans('product_id'); ?></th>
                                        <th><?php echo trans('product'); ?></th>
                                        <th><?php echo trans('unit_price'); ?></th>
                                        <th><?php echo trans('quantity'); ?></th>
                                        <th><?php echo trans('vat'); ?></th>
                                        <th><?php echo trans('shipping_cost'); ?></th>
                                        <th><?php echo trans('total'); ?></th>
                                        <th><?php echo trans('status'); ?></th>
                                        <th><?php echo trans('updated'); ?></th>
                                        <!-- <th class="max-width-120"><?php echo trans('options'); ?></th> -->
                                    </tr>
                                </thead>
								<tbody id="table_<?php echo $item->id;?>">                                     
                                </tbody>
							</table>
							</td>
						</tr>
						<?php endforeach; ?>

						</tbody>
					</table>

					<?php if (empty($orders)): ?>
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
	</div>
</div>
<!-- script for collapsible order details -->
<script>
		$(".exploder").click(function(){
		
		$(this).toggleClass("btn-success btn-danger");
		
		$("i", this).toggleClass("fa fa-plus fa fa-times");
		
		$(this).closest("tr").next("tr").toggleClass("hide");
		
		if($(this).closest("tr").next("tr").hasClass("hide")){
			$(this).closest("tr").next("tr").children("td").slideUp();
		}
		else{
			$(this).closest("tr").next("tr").children("td").slideDown(350);
		}
		});
</script>
<!-- script for expandable orders -->
<script>
    
        var dataa=1;
        function order_summary_on_orders(order_number) {
            if(document.getElementById('table_'+order_number).rows.length==0){

            
                    var a = {
                        
                    order_id:order_number,
                    };
                    (a[csfr_token_name] = $.cookie(csfr_cookie_name)),

                    $.ajax({
                        type: "POST",
                        url: base_url + "order_admin_controller/order_details1",
                        data: a,
                        success: function(response) {
                            dataa=0;
                            var Json_data = JSON.parse(response);
                            var len = Json_data.length;

                if (len != 0) {
                    var time_ago_format;
                    for (var i = 0; i < len; i++) {
                        var new_order_status="";
                        if(Json_data[i].order_status=="cancelled_by_user"){
                            new_order_status="Cancelled By User";
                        }
                        else if(Json_data[i].order_status=="completed"){
                            new_order_status="Completed";
                        }
                        else if(Json_data[i].order_status=="processing"){
                            new_order_status="Processing";
                        }
                        else if(Json_data[i].order_status=="cancelled_by_seller"){
                            new_order_status="Cancelled By Seller";
                        }
                        else if(Json_data[i].order_status=="rejected"){
                            new_order_status="Rejected";
                        }
                        else if(Json_data[i].order_status=="cancelled"){
                            new_order_status="Cancelled";
                        }
                        else if(Json_data[i].order_status=="awaiting_pickup"){
                            new_order_status="Awaiting Pickup";
                        }
                        else if(Json_data[i].order_status=="shipped"){
                            new_order_status="Shipped";
                        }
                        else if(Json_data[i].order_status=="waiting"){
                            new_order_status="Waiting";
                        }
                        else if(Json_data[i].order_status=="Return Delivered"){
                            new_order_status="Return Delivered";
                        }
                        else if(Json_data[i].order_status=="RTO Delivered"){
                            new_order_status="RTO Delivered";
                        }
                        else if(Json_data[i].order_status=="RTO Initiated"){
                            new_order_status="RTO Initiated";
                        }
                        var time_format =Json_data[i].updated_at;
                        time_ago_format= time_ago(time_format);
                        $('#table_'+order_number).append("<tr><td>" + Json_data[i].product_id + "</td><td>" + Json_data[i].product_title + "</td><td>" +"₹"+ Json_data[i].product_unit_price/100 + "</td><td>" + Json_data[i].product_quantity + "</td><td>" +"₹"+ Json_data[i].product_gst/100 + "</td><td>" +"₹"+ Json_data[i].product_shipping_cost/100 + "</td><td>" +"₹"+ Json_data[i].product_total_price/100 + "</td><td>" + new_order_status + "</td><td>"+ time_ago_format + "</td><td>")
                    }
                }
                        }
                    }
                    
                    );
                }
            }

    function time_ago(time) {

        switch (typeof time) {
        case 'number':
            break;
        case 'string':
            time = +new Date(time);
            break;
        case 'object':
            if (time.constructor === Date) time = time.getTime();
            break;
        default:
            time = +new Date();
        }
        var time_formats = [
        [60, 'seconds', 1], // 60
        [120, '1 minute ago', '1 minute from now'], // 60*2
        [3600, 'minutes', 60], // 60*60, 60
        [7200, '1 hour ago', '1 hour from now'], // 60*60*2
        [86400, 'hours', 3600], // 60*60*24, 60*60
        [172800, '1 day ago', 'Tomorrow'], // 60*60*24*2
        [604800, 'days', 86400], // 60*60*24*7, 60*60*24
        [1209600, 'Last week', 'Next week'], // 60*60*24*7*4*2
        [2419200, 'weeks', 604800], // 60*60*24*7*4, 60*60*24*7
        [4838400, 'Last month', 'Next month'], // 60*60*24*7*4*2
        [29030400, 'months', 2419200], // 60*60*24*7*4*12, 60*60*24*7*4
        [58060800, 'Last year', 'Next year'], // 60*60*24*7*4*12*2
        [2903040000, 'years', 29030400], // 60*60*24*7*4*12*100, 60*60*24*7*4*12
        [5806080000, 'Last century', 'Next century'], // 60*60*24*7*4*12*100*2
        [58060800000, 'centuries', 2903040000] // 60*60*24*7*4*12*100*20, 60*60*24*7*4*12*100
        ];
        var seconds = (+new Date() - time) / 1000,
        token = 'ago',
        list_choice = 1;

        if (seconds == 0) {
        return 'Just now'
        }
        if (seconds < 0) {
        seconds = Math.abs(seconds);
        token = 'from now';
        list_choice = 2;
        }
        var i = 0,
        format;
        while (format = time_formats[i++])
        if (seconds < format[0]) {
            if (typeof format[2] == 'string')
            return format[list_choice];
            else
            return Math.floor(seconds / format[2]) + ' ' + format[1] + ' ' + token;
        }
        return time;
        }

        // var aDay = 24 * 60 * 60 * 1000;
        // console.log(time_ago(new Date(Date.now() - aDay)));
        // console.log(time_ago(new Date(Date.now() - aDay * 2)));
</script>
<!-- script end for expandable orders -->