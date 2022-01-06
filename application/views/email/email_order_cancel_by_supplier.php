<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view('email/_header', ['title' => trans("email_text_thank_for_order")]); ?>
<table role="presentation" class="main">
    <?php if (!empty($order)) : ?>
        <tr>
            <td class="wrapper">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <h1 style="text-decoration: none; font-size: 24px;line-height: 28px;font-weight: bold"><?php echo trans("email_text_thank_for_order"); ?></h1>
                            <div class="mailcontent" style="line-height: 26px;font-size: 14px;">

                                <p style='text-align: left;color: #555;'>
                                    <?php echo trans("email_text_new_order"); ?>
                                </p><br>
                                Dear &nbsp;<?php echo get_user($order->buyer_id)->first_name; ?>, Thank you placing an order. Every order placed by you helps the homeprenuers realise their dreams and promotes them to create high quality products and provide exceptional service to you. Following is your order summary:
                                <h2 style="margin-bottom: 10px; font-size: 16px;font-weight: 600;"><?php echo trans("order_information"); ?></h2>
                                <p style="color: #555;">
                                    <?php echo trans("order"); ?>:&nbsp;#<?php echo $order->order_number; ?><br>
                                    <?php echo trans("payment_status"); ?>:&nbsp;<?php echo trans($order->payment_status); ?><br>
                                    <?php echo trans("payment_method"); ?>:&nbsp;<?= get_payment_method($order->payment_method); ?>
                                    <br>
                                    <?php echo trans("date"); ?>:&nbsp;<?php echo formatted_date($order->created_at); ?><br>
                                </p>
                            </div>

                            <?php $shipping = get_order_shipping($order->id);
                            if (!empty($shipping)) : ?>
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
                                    <tr>
                                        <td>
                                            <h3 style="margin-bottom: 10px; font-size: 16px;font-weight: 600;"><?php echo trans("shipping_address"); ?></h3>
                                            <p style="color: #555; padding-right: 10px;">
                                                <?php echo trans("first_name"); ?>:&nbsp;<?php echo $shipping->shipping_first_name; ?><br>
                                                <?php echo trans("last_name"); ?>:&nbsp;<?php echo $shipping->shipping_last_name; ?><br>
                                                <?php echo trans("email"); ?>:&nbsp;<?php echo $shipping->shipping_email; ?><br>
                                                <?php echo trans("phone_number"); ?>:&nbsp;<?php echo $shipping->shipping_phone_number; ?><br>
                                                <?php echo trans("address"); ?> 1:&nbsp;<?php echo $shipping->shipping_address_1; ?><br>
                                                <?php echo trans("address_2"); ?> :&nbsp;<?php echo $shipping->shipping_address_2; ?><br>
                                                <?php echo trans("country"); ?>:&nbsp;<?php echo $shipping->shipping_country; ?><br>
                                                <?php echo trans("state"); ?>:&nbsp;<?php echo $shipping->shipping_state; ?><br>
                                                <?php echo trans("city"); ?>:&nbsp;<?php echo $shipping->shipping_city; ?><br>
                                                <?php echo trans("zip_code"); ?>:&nbsp;<?php echo $shipping->shipping_zip_code; ?><br>
                                            </p>
                                        </td>
                                        <td>
                                            <h3 style="margin-bottom: 10px; font-size: 16px;font-weight: 600;"><?php echo trans("billing_address"); ?></h3>
                                            <p style="color: #555; padding-right: 10px;">
                                                <?php echo trans("first_name"); ?>:&nbsp;<?php echo $shipping->billing_first_name; ?><br>
                                                <?php echo trans("last_name"); ?>:&nbsp;<?php echo $shipping->billing_last_name; ?><br>
                                                <?php echo trans("email"); ?>:&nbsp;<?php echo $shipping->billing_email; ?><br>
                                                <?php echo trans("phone_number"); ?>:&nbsp;<?php echo $shipping->billing_phone_number; ?><br>
                                                <?php echo trans("address"); ?> 1:&nbsp;<?php echo $shipping->billing_address_1; ?><br>
                                                <?php echo trans("address_2"); ?> :&nbsp;<?php echo $shipping->billing_address_2; ?><br>
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
                                    <th style="padding: 10px 0; border-bottom: 2px solid #ddd;"><?php echo trans("quantity"); ?></th>
                                    <th style="padding: 10px 0; border-bottom: 2px solid #ddd;"><?php echo trans("shipping"); ?></th>
                                    <th style="padding: 10px 0; border-bottom: 2px solid #ddd;"><?php echo trans("vat"); ?></th>
                                    <th style="padding: 10px 0; border-bottom: 2px solid #ddd;"><?php echo trans("total"); ?></th>
                                </tr>
                                <?php foreach ($order_products as $item) : ?>
                                    <tr>
                                        <td style="width: 40%; padding: 15px 0; border-bottom: 1px solid #ddd;"><?php echo $item->product_title; ?></td>
                                        <td style="padding: 10px 2px; border-bottom: 1px solid #ddd;"><?php echo price_formatted($item->product_unit_price, $item->product_currency); ?></td>
                                        <td style="padding: 10px 2px; border-bottom: 1px solid #ddd;"><?php echo $item->product_quantity; ?></td>
                                        <td style="padding: 10px 2px; border-bottom: 1px solid #ddd;"><?php echo price_formatted($item->product_shipping_cost, $item->product_currency); ?></td>
                                        <?php if (!empty($order->price_gst)) : ?>
                                            <td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">
                                                <?php if (!empty($item->product_gst)) : ?>
                                                    <?php echo price_formatted($item->product_gst, $item->product_currency); ?>&nbsp;(<?php echo $item->product_gst_rate; ?>%)
                                                <?php endif; ?>
                                            </td>
                                        <?php else : ?>
                                            <td style="padding: 10px 2px; border-bottom: 1px solid #ddd;">-</td>
                                        <?php endif; ?>
                                        <td style="padding: 10px 2px; border-bottom: 1px solid #ddd;"><?php echo price_formatted($item->product_total_price, $item->product_currency); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="text-align: right;margin-top: 40px;">
                                <tr>
                                    <td style="width: 70%"><?php echo trans("subtotal"); ?></td>
                                    <td style="width: 30%;padding-right: 15px;font-weight: 600;"><?php echo price_formatted($order->price_subtotal, $order->price_currency); ?></td>
                                </tr>
                                <?php if (!empty($order->price_gst)) : ?>
                                    <tr>
                                        <td style="width: 70%"><?php echo trans("vat"); ?></td>
                                        <td style="width: 30%;padding-right: 15px;font-weight: 600;"><?php echo price_formatted($order->price_gst, $order->price_currency); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td style="width: 70%"><?php echo trans("shipping"); ?></td>
                                    <td style="width: 30%;padding-right: 15px;font-weight: 600;"><?php echo price_formatted($order->price_shipping, $order->price_currency); ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 70%;font-weight: bold"><?php echo trans("total"); ?></td>
                                    <td style="width: 30%;padding-right: 15px;font-weight: 600;"><?php echo price_formatted($order->price_total, $order->price_currency); ?></td>
                                </tr>
                            </table>
                            <?php if ($order->buyer_type != 'guest') : ?>
                                <p style='text-align: center;margin-top: 40px;'>
                                    <a href="<?php echo generate_url("order_details") . '/' . $order->order_number; ?>" style='font-size: 14px;text-decoration: none;padding: 14px 40px;background-color: #DF911E;color: #000000 !important; border-radius: 3px;'>
                                        <?php echo trans("see_order_details"); ?>
                                    </a>
                                </p>
                            <?php else : ?>
                                <p style='text-align: center;margin-top: 40px;'> In order to track your order, please register on the website or write to contact@gharobaar.com</p>
                            <?php endif; ?>
                            In case of MTO - We'd like to share again with you that your order contains product(s) from suppliers who are small scale homeprenuers making these products at home with limited means, hence we give them an option to accept/ reject the order within 2 hours of receiving it. Please note that this product cannot be returned or exchanged, however you may get an exchange or return based on the supplier's discretion. / or In case of MTS - Please note that this product can be returned or exchanged within CCC days or before the dispatch date or only if the dispatch is after the committed date of delivery
                            <br>Your order shall also bring rewards to you, please visit the Gharobaar website to learn more about the loyalty program. We would love to get your feedback about the product, service and the seller, your appreciation would encourage us & our partners to continue serving you to the best of our ability, and your criticism would make us learn and improve.
                            We look forward to serving you again and continue to get your patronage.
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