<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view('email/_header', ['title' => trans("your_order_shipped")]); ?>
<table role="presentation" class="main">
    <?php if (!empty($order)): ?>
        <tr>
            <td class="wrapper">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <h1 style="text-decoration: none; font-size: 24px;line-height: 28px;font-weight: bold"><?php echo trans("your_order_shipped"); ?></h1>
                            <div class="mailcontent" style="line-height: 26px;font-size: 14px;">
                                <h2 style="margin-bottom: 10px; font-size: 16px;font-weight: 600;"><?php echo trans("order_information"); ?></h2>
                                <p style="color: #555;">
                                    <?php echo trans("order"); ?>:&nbsp;#<?php echo $order->order_number; ?><br>
                                    <?php echo trans("payment_status"); ?>:&nbsp;<?php echo trans($order->payment_status); ?><br>
                                    <?php echo trans("payment_method"); ?>:&nbsp;<?= get_payment_method($order->payment_method); ?><br>
                                    <?php echo trans("date"); ?>:&nbsp;<?php echo formatted_date($order->created_at); ?><br>
                                </p>
                            </div>

                            <h3 style="margin-bottom: 10px;font-size: 16px;font-weight: 600;border-bottom: 1px solid #d1d1d1;padding-bottom: 5px; margin-top: 45px;"><?php echo trans("shipped_product"); ?></h3>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="text-align: left" class="table-products">
                                <tr>
                                    <th><?php echo trans("product"); ?></th>
                                    <th><?php echo trans("unit_price"); ?></th>
                                    <th><?php echo trans("quantity"); ?></th>
                                    <th><?php echo trans("shipping"); ?></th>
                                    <th><?php echo trans("price"); ?></th>
                                </tr>
                                <?php if (!empty($order_product)): ?>
                                    <tr>
                                        <td><?php echo $order_product->product_title; ?></td>
                                        <td><?php echo price_formatted($order_product->product_unit_price, $order_product->product_currency); ?></td>
                                        <td><?php echo $order_product->product_quantity; ?></td>
                                        <td><?php echo price_formatted($order_product->product_shipping_cost, $order_product->product_currency); ?></td>
                                        <td><?php echo price_formatted($order_product->product_total_price, $order_product->product_currency); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                            <p style='text-align: center;margin-top: 40px;'>
                                <a href="<?php echo generate_url("order_details") . '/' . $order->order_number; ?>" style='font-size: 14px;text-decoration: none;padding: 14px 40px;background-color: #DF911E;color: #000000 !important; border-radius: 3px;'>
                                    <?php echo trans("see_order_details"); ?>
                                </a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php endif; ?>
</table>
<?php $this->load->view('email/_footer'); ?>
