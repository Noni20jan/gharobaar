<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view('email/_header', ['title' => trans("you_have_new_order")]); ?>
<table role="presentation" class="main">
    <?php if (!empty($order)) : ?>
        <tr>
            <td class="wrapper">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <h1 style="text-decoration: none; font-size: 24px;line-height: 28px;font-weight: bold"><?php echo trans("you_have_new_order"); ?></h1>
                            <div class="mailcontent" style="line-height: 26px;font-size: 14px;">
                                Dear &nbsp;<?php echo ucfirst($seller_name); ?>,<br>
                                Congratulations on receiving order from <?php echo get_user($order->buyer_id)->first_name; ?>. Every order received is a vindication of the hard work put by you in creating products and offering exceptional service to the customers.
                                <?php $is_mts = 0;
                                $is_mto = 0;
                                foreach ($order_products as $item) :
                                    if (get_product($item->product_id)->add_meet == "Made to order") :
                                        $is_mto++;;

                                    elseif (get_product($item->product_id)->add_meet == "Made to stock") :
                                        $is_mts++;
                                    endif;
                                endforeach; ?>
                                <?php if ($is_mto > 0 && $is_mts > 0) : ?>
                                    <small><br>Please note that the order is accepted based on the availability of the product shown on the platform, hope you are ready with the inventory to service the order on time. Cancellation of order would reflect badly on both Gharobaar as a platform and your brand, not to mention the penalties that it'll attract</small>
                                    <small><br>Please note that we are cognizant of the scale at which you are operating, and as a platform we encourage you to prioritise your life over business, hence in case you're unable to service the order, please reject and update the reason on the portal within 2 hours. While it may impact the connect with the buyer and may expose us to the risk of negative comments, at-least we'd stick to our promise of promptly letting them know about the cancellation. Hope you understand that the delayed cancellation would attract penalties and we'd have to offer some compensation for inconvenience to the buyer with that amount, to keep their loyalty and patronage intact.</small>
                                <?php elseif ($is_mts > 0) : ?>
                                    <small><br>Please note that the order is accepted based on the availability of the product shown on the platform, hope you are ready with the inventory to service the order on time. Cancellation of order would reflect badly on both Gharobaar as a platform and your brand, not to mention the penalties that it'll attract</small>
                                <?php elseif ($is_mto > 0) : ?>
                                    <small> <br>Please note that we are cognizant of the scale at which you are operating, and as a platform we encourage you to prioritise your life over business, hence in case you're unable to service the order, please reject and update the reason on the portal within 2 hours. While it may impact the connect with the buyer and may expose us to the risk of negative comments, at-least we'd stick to our promise of promptly letting them know about the cancellation. Hope you understand that the delayed cancellation would attract penalties and we'd have to offer some compensation for inconvenience to the buyer with that amount, to keep their loyalty and patronage intact.</small>
                                <?php
                                endif; ?>

                                <br><br>Timely servicing of order, experience that you provide to buyer and their feedback, would bring rewards for you, please visit the Gharobaar website to learn more about the loyalty program. Please let us know if you need any assistance or clarification from the Gharobaar team. Lets together provide an amazing experience to our buyers. <br>
                                Following is the order summary:
                                <h2 style="margin-bottom: 10px; font-size: 16px;font-weight: 600;"><?php echo trans("order_information"); ?></h2>
                                <p style="color: #555;">
                                    <?php echo trans("order"); ?>:&nbsp;#<?php echo $order->order_number; ?><br>
                                    <?php echo trans("payment_status"); ?>:&nbsp;<?php echo trans($order->payment_status); ?><br>
                                    <?php echo trans("payment_method"); ?>:&nbsp;<?= get_payment_method($order->payment_method); ?><br>
                                    <?php echo trans("date"); ?>:&nbsp;<?php echo date("Y-m-d / h:i", strtotime($order->created_at)); ?><br>
                                </p>
                            </div>

                            <?php $shipping = get_order_shipping($order->id);
                            if (!empty($shipping)) : ?>
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
                                    <tr>
                                        <td>
                                            <h3 style="margin-bottom: 10px; font-size: 16px;font-weight: 600;"><?php echo trans("shipping_address"); ?></h3>
                                            <p style="color: #555; padding-right: 10px;">
                                                <?php echo trans("name"); ?>:&nbsp;<?php echo $shipping->shipping_first_name; ?> &nbsp;<?php echo $shipping->shipping_last_name; ?><br>
                                                <?php echo trans("email"); ?>:&nbsp;<?php echo $shipping->shipping_email; ?><br>
                                                <?php echo trans("phone_number"); ?>:&nbsp;<?php echo $shipping->shipping_phone_number; ?><br>
                                                <?php echo trans("address"); ?> 1:&nbsp;<?php echo $shipping->shipping_address_1; ?><br>
                                                <?php echo trans("area"); ?> :&nbsp;<?php echo $shipping->shipping_area; ?><br>
                                                <?php echo trans("country"); ?>:&nbsp;<?php echo $shipping->shipping_country; ?><br>
                                                <?php echo trans("state"); ?>:&nbsp;<?php echo $shipping->shipping_state; ?><br>
                                                <?php echo trans("city"); ?>:&nbsp;<?php echo $shipping->shipping_city; ?><br>
                                                <?php echo trans("zip_code"); ?>:&nbsp;<?php echo $shipping->shipping_zip_code; ?><br>
                                            </p>
                                        </td>
                                        <td>
                                            <h3 style="margin-bottom: 10px; font-size: 16px;font-weight: 600;"><?php echo trans("billing_address"); ?></h3>
                                            <p style="color: #555; padding-right: 10px;">
                                                <?php echo trans("name"); ?>:&nbsp;<?php echo $shipping->billing_first_name; ?>&nbsp;<?php echo $shipping->billing_last_name; ?><br>
                                                <?php echo trans("email"); ?>:&nbsp;<?php echo $shipping->billing_email; ?><br>
                                                <?php echo trans("phone_number"); ?>:&nbsp;<?php echo $shipping->billing_phone_number; ?><br>
                                                <?php echo trans("address"); ?> 1:&nbsp;<?php echo $shipping->billing_address_1; ?><br>
                                                <?php echo trans("area"); ?> :&nbsp;<?php echo $shipping->billing_area; ?><br>
                                                <?php echo trans("country"); ?>:&nbsp;<?php echo $shipping->billing_country; ?><br>
                                                <?php echo trans("state"); ?>:&nbsp;<?php echo $shipping->billing_state; ?><br>
                                                <?php echo trans("city"); ?>:&nbsp;<?php echo $shipping->billing_city; ?><br>
                                                <?php echo trans("zip_code"); ?>:&nbsp;<?php echo $shipping->billing_zip_code; ?><br>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            <?php endif; ?>

                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="text-align: left" class="table-products">
                                <tr>
                                    <th style="padding: 10px 0; border-bottom: 2px solid #ddd;"><?php echo trans("product"); ?></th>
                                    <th style="padding: 10px 0; border-bottom: 2px solid #ddd;"><?php echo trans("unit_price"); ?></th>
                                    <th style="padding: 10px 0; border-bottom: 2px solid #ddd;"><?php echo trans("discount"); ?></th>
                                    <th style="padding: 10px 0; border-bottom: 2px solid #ddd;"><?php echo trans("quantity"); ?></th>
                                    <!-- <th style="padding: 10px 0; border-bottom: 2px solid #ddd;"><?php echo trans("shipping"); ?></th>
                                    <th style="padding: 10px 0; border-bottom: 2px solid #ddd;"><?php echo trans("vat"); ?></th> -->
                                    <th style="padding: 10px 0; border-bottom: 2px solid #ddd;"><?php echo trans("total"); ?></th>
                                </tr>
                                <?php foreach ($order_products as $item) : ?>
                                    <tr>
                                        <td style="width: 40%; padding: 15px 0; border-bottom: 1px solid #ddd;"><?php echo $item->product_title; ?></td>
                                        <td style="padding: 10px 2px; border-bottom: 1px solid #ddd;"><?php echo price_formatted($item->product_unit_price, $item->product_currency); ?></td>
                                        <td style="padding: 10px 2px; border-bottom: 1px solid #ddd;"><?php echo price_formatted(($item->product_discount_amount * 100), $item->product_currency); ?></td>
                                        <td style="padding: 10px 2px; border-bottom: 1px solid #ddd;"><?php echo $item->product_quantity; ?></td>
                                        <!-- <td style="padding: 10px 2px; border-bottom: 1px solid #ddd;"><?php echo price_formatted($item->product_shipping_cost, $item->product_currency); ?></td>
                                        <?php if (!empty($order->price_gst)) : ?>
                                            <td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">
                                                <?php if (!empty($item->product_gst)) : ?>
                                                    <?php echo price_formatted($item->product_gst, $item->product_currency); ?>&nbsp;(<?php echo $item->product_gst_rate; ?>%)
                                                <?php endif; ?>
                                            </td>
                                        <?php else : ?>
                                            <td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">-</td>
                                        <?php endif; ?> -->
                                        <td style="padding: 10px 2px; border-bottom: 1px solid #ddd;"><?php echo price_formatted($item->product_total_price, $item->product_currency); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <p style='text-align: center;margin-top: 40px;'>
                                <a href="<?php echo generate_dash_url("sale") . '/' . $order->order_number; ?>" style='font-size: 14px;text-decoration: none;padding: 14px 40px;background-color: #DF911E;color: #000000  !important; border-radius: 3px;'>
                                    <?php echo trans("see_order_details"); ?>
                                </a>
                            </p>

                            <br>
                            <br>

                            <b>Team Gharobaar </b>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php endif; ?>
</table>
<?php $this->load->view('email/_footer'); ?>