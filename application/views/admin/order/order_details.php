<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .modal_input {
        width: 45%;
        border: none;
        margin-left: 7%;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("order_details"); ?></h3>
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="row" style="margin-bottom: 30px;">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <h4 class="sec-title"><?php echo trans("order"); ?>#<?php echo $order->order_number; ?></h4>
                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?php echo trans("status"); ?></strong>
                            </div>
                            <div class="col-sm-8">
                                <?php $order_products = $this->order_admin_model->get_order_products($order->id)
                                ?>
                                <?php foreach ($order_products as $product_status) :
                                    if (
                                        $product_status->order_status ==
                                        'cancelled_by_user' || $product_status->order_status == 'cancelled_by_seller' || $product_status->order_status == 'cancelled'
                                    ) {
                                        $cancellation = 0;
                                    } elseif ($product_status->order_status == 'completed') {
                                        $cancellation = 2;
                                        break;
                                    } else {
                                        $cancellation = 1;
                                    }                                            // $cancellation = 2; 

                                ?>
                                <?php endforeach ?>



                                <?php if ($cancellation == 1) : ?>
                                    <label class="label label-default"><?php echo trans("order_processing"); ?></label>
                                <?php elseif ($cancellation == 0) : ?>
                                    <label class="label label-default"><?php echo trans("order_cancelled"); ?></label>
                                <?php elseif ($cancellation == 2) : ?>
                                    <label class="label label-default"><?php echo trans("completed"); ?></label>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?php echo trans("order_id"); ?></strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="font-right"><?php echo $order->id; ?></strong>
                            </div>
                        </div>
                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?php echo trans("order_number"); ?></strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="font-right"><?php echo $order->order_number; ?></strong>
                            </div>
                        </div>

                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?php echo trans("payment_method"); ?></strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="font-right">
                                    <?= get_payment_method($order->payment_method); ?>
                                </strong>
                            </div>
                        </div>
                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?php echo trans("currency"); ?></strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="font-right"><?php echo $order->price_currency; ?></strong>
                            </div>
                        </div>
                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?php echo trans("payment_status"); ?></strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="font-right"><?php echo trans($order->payment_status); ?></strong>
                            </div>
                        </div>

                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?php echo trans("updated"); ?></strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="font-right"><?php echo formatted_date($order->updated_at); ?>&nbsp;(<?php echo time_ago($order->updated_at); ?>)</strong>
                            </div>
                        </div>
                        <div class="row row-details">
                            <div class="col-xs-12 col-sm-4 col-right">
                                <strong> <?php echo trans("date"); ?></strong>
                            </div>
                            <div class="col-sm-8">
                                <strong class="font-right"><?php echo formatted_date($order->created_at); ?>&nbsp;(<?php echo time_ago($order->created_at); ?>)</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <h4 class="sec-title"><?php echo trans("buyer"); ?></h4>
                        <?php if ($order->buyer_id == 0) : ?>
                            <div class="row row-details">
                                <div class="col-xs-12">
                                    <div class="table-orders-user">
                                        <img src="<?php echo get_user_avatar(null); ?>" alt="" class="img-responsive" style="height: 120px;">
                                    </div>
                                </div>
                            </div>
                            <?php $shipping = get_order_shipping($order->id);
                            if (!empty($shipping)) : ?>
                                <div class="row row-details">
                                    <div class="col-xs-12 col-sm-4 col-right">
                                        <strong> <?php echo trans("buyer"); ?></strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong class="font-right"><?php echo $shipping->shipping_first_name . " " . $shipping->shipping_last_name; ?> <label class="label bg-olive"><?php echo trans("guest"); ?></label></strong>
                                    </div>
                                </div>
                                <div class="row row-details">
                                    <div class="col-xs-12 col-sm-4 col-right">
                                        <strong> <?php echo trans("phone_number"); ?></strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong class="font-right"><?php echo $shipping->shipping_phone_number; ?></strong>
                                    </div>
                                </div>
                                <div class="row row-details">
                                    <div class="col-xs-12 col-sm-4 col-right">
                                        <strong> <?php echo trans("email"); ?></strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong class="font-right"><?php echo $shipping->shipping_email; ?></strong>
                                    </div>
                                </div>
                            <?php endif; ?>


                        <?php else : ?>
                            <?php $buyer = get_user($order->buyer_id);
                            if (!empty($buyer)) : ?>
                                <div class="row row-details">
                                    <div class="col-xs-12">
                                        <div class="table-orders-user">
                                            <a href="<?php echo generate_profile_url($buyer->slug); ?>" target="_blank">
                                                <img src="<?php echo get_user_avatar($buyer); ?>" alt="" class="img-responsive" style="height: 120px;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-details">
                                    <div class="col-xs-12 col-sm-4 col-right">
                                        <strong> <?php echo trans("username"); ?></strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong class="font-right">
                                            <a href="<?php echo generate_profile_url($buyer->slug); ?>" target="_blank">
                                                <?php echo html_escape($buyer->username); ?>
                                            </a>
                                        </strong>
                                    </div>
                                </div>

                                <div class="row row-details">
                                    <div class="col-xs-12 col-sm-4 col-right">
                                        <strong> <?php echo trans("phone_number"); ?></strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong class="font-right"><?php echo $buyer->phone_number; ?></strong>
                                    </div>
                                </div>

                                <div class="row row-details">
                                    <div class="col-xs-12 col-sm-4 col-right">
                                        <strong> <?php echo trans("email"); ?></strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong class="font-right"><?php echo $buyer->email; ?></strong>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <?php $shipping = get_order_shipping($order->id);
                if (!empty($shipping)) : ?>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <h4 class="sec-title"><?php echo trans("billing_address"); ?></h4>

                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("first_name"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_first_name; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("last_name"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_last_name; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("email"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_email; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("phone_number"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_phone_number; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("address"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_address_1; ?></strong>
                                </div>
                            </div>
                            <!-- <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("address_2"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_address_2; ?></strong>
                                </div>
                            </div> -->
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("area"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_area; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("city"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_city; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("state"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_state; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("country"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_country; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("zip_code"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_zip_code; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("landmark"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->billing_landmark; ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <h4 class="sec-title"><?php echo trans("shipping_address"); ?></h4>

                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("first_name"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_first_name; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("last_name"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_last_name; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("email"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_email; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("phone_number"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_phone_number; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("address"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_address_1; ?></strong>
                                </div>
                            </div>
                            <!-- <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("address_2"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_address_2; ?></strong>
                                </div>
                            </div> -->
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("area"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_area; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("city"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_city; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("state"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_state; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("country"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_country; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("zip_code"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_zip_code; ?></strong>
                                </div>
                            </div>
                            <div class="row row-details">
                                <div class="col-xs-12 col-sm-4 col-right">
                                    <strong> <?php echo trans("landmark"); ?></strong>
                                </div>
                                <div class="col-sm-8">
                                    <strong class="font-right"><?php echo $shipping->shipping_landmark; ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>


            </div><!-- /.box-body -->
        </div>
    </div>
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("products"); ?></h3>
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
                        <div class="table-responsive" id="t_product">
                            <table class="table table-bordered table-striped" role="grid">
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
                                        <th><?php echo "AWB No."; ?></th>
                                        <th><?php echo trans('updated'); ?></th>
                                        <th class="max-width-120"><?php echo trans('options'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $is_order_has_physical_product = false; ?>
                                    <?php foreach ($order_products as $item) :
                                        if ($item->product_type == 'physical') {
                                            $is_order_has_physical_product = true;
                                        } ?>
                                        <?php
                                        $order_detail = $this->order_model->get_order_detail_by_id($item->order_id);
                                        $payment_method = $order_detail[0]->payment_method;
                                        $transaction_detail = $this->order_model->get_transaction_detail($item->order_id);
                                        ?>
                                        <tr>
                                            <td style="width: 80px;">
                                                <?php echo html_escape($item->product_id); ?>
                                            </td>
                                            <td>
                                                <div class="img-table">
                                                    <a href="<?php echo generate_product_url_by_slug($item->product_slug); ?>" target="_blank">
                                                        <img src="<?php echo get_product_image($item->product_id, 'image_small'); ?>" data-src="" alt="" class="lazyload img-responsive post-image" />
                                                    </a>
                                                </div>
                                                <p>
                                                    <?php if ($item->product_type == 'digital') : ?>
                                                        <label class="label bg-black"><i class="icon-cloud-download"></i><?php echo trans("instant_download"); ?></label>
                                                    <?php endif; ?>
                                                </p>
                                                <a href="<?php echo generate_product_url_by_slug($item->product_slug); ?>" target="_blank" class="table-product-title">
                                                    <?php echo html_escape($item->product_title); ?>
                                                </a>
                                                <p>
                                                    <span><?php echo trans("by"); ?></span>
                                                    <?php $seller = get_user($item->seller_id); ?>
                                                    <?php if (!empty($seller)) : ?>
                                                        <a href="<?php echo generate_profile_url($seller->slug); ?>" target="_blank" class="table-product-title">
                                                            <strong><?php echo html_escape($seller->username); ?></strong>
                                                        </a>
                                                    <?php endif; ?>
                                                </p>
                                            </td>
                                            <td><?php echo price_formatted($item->product_unit_price, $item->product_currency); ?></td>
                                            <td><?php echo $item->product_quantity; ?></td>
                                            <td>
                                                <?php if ($item->product_gst) :
                                                    echo price_formatted($item->product_gst, $item->product_currency); ?>&nbsp;(<?php echo $item->product_gst_rate; ?>%)
                                            <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($item->product_type == 'physical') :
                                                    echo price_formatted($item->product_shipping_cost, $item->product_currency);
                                                endif; ?>
                                                
                                            </td>
                                            <td><?php echo price_formatted($item->product_total_price, $item->product_currency); ?></td>
                                            <td>
                                                <strong><?php echo trans($item->order_status); ?></strong><br>
                                                <?php if ($payment_method == "Cashfree") : ?>
                                                    <strong><?php echo "Payment Ref. Id: " . $transaction_detail[0]->payment_id; ?></strong>
                                                <?php endif; ?>
                                                <?php if ($item->buyer_id == 0) : ?>
                                                    <?php if ($item->is_approved == 0) : ?>
                                                        <br>
                                                        <?php echo form_open('order_admin_controller/approve_guest_order_product'); ?>
                                                        <input type="hidden" name="order_product_id" value="<?php echo $item->id; ?>">
                                                        <button type="submit" class="btn btn-xs btn-primary m-t-5"><?php echo trans("approve"); ?></button>
                                                        <?php echo form_close(); ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>

                                                <?php $message = get_refund_message($item->order_id, $item->product_id) ?>
                                                <div>
                                                    <?php if ($message != "") : ?>

                                                        <strong>(<?php echo $message->message ?>)</strong>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td><?php $awb_code = $this->order_model->get_awb_code($item->order_id, $item->product_id); 
                                            if(!empty($awb_code)):?>
                                                <?php echo $awb_code[0]->awb_code;
                                               endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($item->product_type == 'physical') :
                                                    echo time_ago($item->updated_at);
                                                endif; ?>
                                            </td>
                                            <td>
                                                <?php if (($item->product_type == 'digital' && $item->order_status != 'completed' && $item->order_status != 'cancelled') || $item->product_type == 'physical') : ?>
                                                    <div class="dropdown">
                                                        <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?php echo trans('select_option'); ?>
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu options-dropdown">
                                                            <li>
                                                                <a href="#" data-toggle="modal" data-target="#updateStatusModal_<?php echo $item->id; ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('update_order_status'); ?></a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0)" onclick="delete_item('order_admin_controller/delete_order_product_post','<?php echo $item->id; ?>','<?php echo trans("confirm_delete"); ?>');"><i class="fa fa-times option-icon"></i><?php echo trans('delete'); ?></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                <?php endif; ?>

                                                <?php
                                                $payment = get_product_transaction_details($item->id);
                                                if ($payment) :
                                                    $payment_method = $payment["payment_method"];
                                                    $refund_exists = $this->order_model->get_refund_exists($item->id);
                                                    // var_dump($refund_exists);die();
                                                    if ($payment_method == "Cashfree") : ?>
                                                        <?php if ($refund_exists == 0) : ?>
                                                            <div>
                                                                <button class="btn btn-sm btn-custom" style="width: 90%;margin-top: 4%;" data-id="<?php echo $item->id; ?>" data-toggle="modal" data-target="#refund_initiate_model_<?php echo $item->id; ?>"><?php echo trans("initiate_refund"); ?></button>
                                                            </div>
                                                        <?php elseif ($refund_exists > 0) : ?>
                                                            <div>
                                                                <button class="btn btn-sm btn-custom" disabled style="width: 90%;margin-top: 4%;" data-id="<?php echo $item->id; ?>" data-toggle="modal" data-target="#refund_initiate_model_<?php echo $item->id; ?>"><?php echo "Refund Initiated"; ?></button>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php $product_transaction_details = get_product_transaction_details($item->id); ?>
                                        <?php if ($product_transaction_details) : ?>
                                            <div class="modal fade" id="refund_initiate_model_<?php echo $item->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content modal-custom">
                                                        <!-- form start -->
                                                        <?php echo form_open('order_admin_controller/initiate_refund'); ?>
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?php echo trans("initiate_refund"); ?></h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span aria-hidden="true"><i class="icon-close"></i> </span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row tracking-number-container">
                                                                <div class="col-sm-12">
                                                                    <input type="hidden" value='<?php echo $item->id; ?>' name="order_product_id" id="order_product_id">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><?php echo "Order Id"; ?></label>
                                                                        <input type="text" readonly class="modal_input" value='<?php echo $product_transaction_details["order_id"]; ?>' name="order_id" id="order_id">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><?php echo "Payment Ref. Id"; ?></label>
                                                                        <input type="text" readonly class="modal_input" value='<?php echo $product_transaction_details["payment_refrence_id"]; ?>' name="payment_refrence_id" id="payment_refrence_id">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><?php echo "Order Amount(₹)"; ?></label>
                                                                        <input type="text" readonly class="modal_input" value='<?php echo $product_transaction_details["order_total_amount"] / 100; ?>' name="order_amount" id="order_amount">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><?php echo "Product Price(₹)"; ?></label>
                                                                        <input type="text" readonly class="modal_input" value='<?php echo $product_transaction_details["product_price"] / 100; ?>' name="product_price" id="product_price">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label"><?php echo "Refund Amount(₹)"; ?></label>
                                                                        <input type="text" style=" width: 45%;margin-left: 7%;" value='<?php echo $product_transaction_details["refund_amount"]; ?>' name="refund_amount" id="refund_amount">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-md btn-default" data-dismiss="modal"><?php echo trans("close"); ?></button>
                                                            <button type="submit" value="reject" id="order_product_cancel_loader" name="submit" class="btn btn-md btn-primary"><?php echo trans("submit"); ?></button>
                                                        </div>
                                                        <?php echo form_close(); ?>
                                                    </div>
                                                </div>
                                                <div id="cover-spin3"></div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>

                            <?php if (empty($order_products)) : ?>
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
    </div>
    <?php $os=$this->order_model->order_price_subtotal($order->id);
    //var_dump($os);
                //die(); ?>
    <div class="col-sm-12">
        <div class="box-payment-total">

            <div class="row row-details">
                <div class="col-xs-12 col-sm-6 col-right">
                    <strong> <?php echo trans("subtotal"); ?></strong>
                </div>
                <div class="col-sm-6">
                    <strong class="font-right"><?php echo price_formatted($os[0]->subtotal, $order->price_currency); ?></strong>
                
                </div>
            </div>
            <?php //if (!empty($order->price_gst)) : 
            ?>
            <!-- <div class="row row-details">
                    <div class="col-xs-12 col-sm-6 col-right">
                        <strong> <?php echo trans("vat"); ?></strong>
                    </div>
                    <div class="col-sm-6">
                        <strong class="font-right"><?php echo price_formatted($order->price_gst, $order->price_currency); ?></strong>
                    </div>
                </div> -->
            <?php //endif; 
            ?>
            <?php if ($is_order_has_physical_product) : ?>
                <div class="row row-details">
                    <div class="col-xs-12 col-sm-6 col-right">

                        <strong> <?php echo trans("shipping"); ?></strong>
                    </div>
                    <div class="col-sm-6">
                        <?php if ($os[0]->subtotal < 100000) : ?>
                            <strong class="font-right"><?php echo price_formatted(10000, $order->price_currency); ?></strong>
                        <?php else : ?>
                            <strong class="font-right"><?php echo price_formatted(0, $order->price_currency); ?></strong>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($order->total_tax_charges > 0) : ?>
                <div class="row row-details">
                    <div class="col-xs-12 col-sm-6 col-right">
                        <strong><?php echo "Taxes"; ?></strong>
                    </div>
                    <div class="col-sm-6">
                        <strong><span class="float-right"><?php echo price_formatted_without_round($order->total_tax_charges, $this->payment_settings->default_currency); ?>/-</span></strong>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($order->payment_method == "Cash On Delivery") : ?>
                <div class="row row-details">
                    <div class="col-xs-12 col-sm-6 col-right">
                        <strong><?php echo "COD Charges"; ?></strong>
                    </div>
                    <div class="col-sm-6">
                        <strong><span class="float-right"><?php echo price_formatted_without_round($order->total_cod_charges, $this->payment_settings->default_currency); ?>/-</span></strong>
                    </div>
                </div>
            <?php else : ?>
                <!-- <div class="row row-details">
                    <div class="col-xs-12 col-sm-6 col-right">
                        <strong><?php echo "COD Charges"; ?></strong>
                    </div>
                    <div class="col-sm-6">
                        <strong><span class="float-right"><?php echo price_formatted_without_round($order->total_cod_charges, $this->payment_settings->default_currency); ?>/-</span></strong>
                    </div>
                </div> -->
            <?php endif; ?>
            <?php if (!empty($order->offer_id) && $order->offer_id != 0) { ?>
                <div class="row">
                    <div class="col-sm-6 col-xs-6 col-left">

                        <strong>Coupon Applied</strong>
                    </div>

                    <div class="col-sm-6 col-xs-6 col-right">

                        <strong><?php $coupon = $this->auth_model->get_coupon_code_by_id($order->offer_id);
                                if (!empty($coupon->offer_code)) {
                                    echo $coupon->offer_code;
                                } ?></strong>
                    </div>

                    <div class="col-sm-6 col-xs-6 col-left">

                        <strong>Coupon Discount<?php $coupon = $this->auth_model->get_coupon_code_by_id($order->offer_id);
                                                if (!empty($coupon->offer_code && $coupon->discount_percentage)) {
                                                    echo ('(' . $coupon->discount_percentage) . '%)';
                                                } ?>
                        </strong>
                    </div>

                    <div class="col-sm-6 col-xs-6 col-right">

                        <strong>-<?php echo price_formatted($order->coupon_discount, $order->price_currency); ?>/-</strong>
                    </div>
                </div>
                <p style="font-size: 12px;">(The coupon is applied to the total amount of order)</p>
                <strong><?php $coupon = $this->auth_model->get_coupon_code_by_id($order->offer_id); ?>
                    <?php $order_detail = $this->order_model->get_order_details_by_id($order->id); ?>

                    <?php if (!empty($coupon->offer_code && $coupon->discount_percentage)) {
                        if ($order_detail->coupon_discount == $coupon->allowed_max_discount * 100) {

                            echo ('(Please take note that the maximum deduction allowed for this Coupon is Rs.' . ($coupon->allowed_max_discount) . ')');
                        }
                    }
                    ?>
                </strong>
            <?php    } ?>
            <hr>
            <div class="row row-details">
                <div class="col-xs-12 col-sm-6 col-right">
                    <strong> <?php echo trans("total"); ?></strong>
                </div>
                <div class="col-sm-6">
                    
                        <strong class="font-right"><?php echo price_formatted($order->price_total, $order->price_currency); ?></strong>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<?php foreach ($order_products as $item) : ?>
    <!-- Modal -->
    <div id="updateStatusModal_<?php echo $item->id; ?>" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo form_open('order_admin_controller/update_order_product_status_post'); ?>
                <input type="hidden" name="id" value="<?php echo $item->id; ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo trans("update_order_status"); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="table-order-status">
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('status'); ?></label>
                            <select name="order_status" class="form-control">
                                <?php if ($item->product_type == 'physical') : ?>
                                    <option value="Awaiting Pickup" <?php echo ($item->order_status == 'Awaiting Pickup') ? 'selected' : ''; ?>><?php echo trans("Awaiting Pickup"); ?></option>
                                    <option value="RTO Delivered" <?php echo ($item->order_status == 'RTO Delivered') ? 'selected' : ''; ?>><?php echo trans ("RTO Delivered"); ?></option>
                                    <option value="RTO Initiated" <?php echo ($item->order_status == 'RTO Initiated') ? 'selected' : ''; ?>><?php echo trans ("RTO Initiated"); ?></option>
                                    <option value="processing" <?php echo ($item->order_status == 'processing') ? 'selected' : ''; ?>><?php echo trans("order_processing"); ?></option>
                                    <option value="shipped" <?php echo ($item->order_status == 'shipped') ? 'selected' : ''; ?>><?php echo trans("shipped"); ?></option>
                                <?php endif; ?>
                                <?php if ($item->buyer_id != 0 && $item->order_status != 'completed') : ?>
                                    <option value="completed" <?php echo ($item->order_status == 'completed') ? 'selected' : ''; ?>><?php echo trans("completed"); ?></option>
                                <?php endif; ?>
                                <option value="cancelled" <?php echo ($item->order_status == 'cancelled') ? 'selected' : ''; ?>><?php echo trans("cancelled"); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><?php echo trans("save_changes"); ?></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo trans("close"); ?></button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<style>
    .sec-title {
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
        font-weight: 600;
    }

    .font-right {
        font-weight: 600;
        margin-left: 5px;
    }

    .font-right a {
        color: #55606e;
    }

    .row-details {
        margin-bottom: 10px;
    }

    .col-right {
        max-width: 240px;
    }

    .label {
        font-size: 12px !important;
    }

    .box-payment-total {
        width: 400px;
        max-width: 100%;
        float: right;
        background-color: #fff;
        padding: 30px;
    }

    @media (max-width: 768px) {
        .col-right {
            width: 100%;
            max-width: none;
        }

        .col-sm-8 strong {
            margin-left: 0;
        }
    }
</style>
<script>
    $("#order_product_cancel_loader").click(function(e) {
        // $('#modalwindow').modal('hide');
        $('#cover-spin3').show();
    });
</script>