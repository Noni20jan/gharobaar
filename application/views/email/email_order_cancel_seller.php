<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view('email/_header', ['title' => 'Order cancel']); ?>
<table role="presentation" class="main">
    <?php if (!empty($order)) : ?>
        <tr>
            <td class="wrapper">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <h1 style="text-decoration: none; font-size: 24px;line-height: 28px;font-weight: bold">Order cancel</h1>
                            <div class="mailcontent" style="line-height: 26px;font-size: 14px;">

                                <!-- <p style='text-align: left;color: #555;'>
                                    <?php echo trans("email_text_new_order"); ?>
                                </p><br> -->
                                Dear &nbsp;<?php echo $seller_name; ?>,

                                Following is your order summary:
                                <h2 style="margin-bottom: 10px; font-size: 16px;font-weight: 600;"><?php echo trans("order_information"); ?></h2>
                                <p style="color: #555;">
                                    <?php echo trans("order"); ?>:&nbsp;#<?php echo $order->order_number; ?><br>
                                    <?php echo trans("payment_status"); ?>:&nbsp;<?php echo trans($order->payment_status); ?><br>
                                    <?php echo trans("payment_method"); ?>:&nbsp;<?= get_payment_method($order->payment_method); ?>
                                    <br>
                                    <?php echo trans("date"); ?>:&nbsp;<?php echo formatted_date($order->created_at); ?><br>
                                </p>
                            </div>


                            <?php if ($order->buyer_type != 'guest') : ?>
                                <p style='text-align: center;margin-top: 40px;'>
                                    <a href="<?php echo generate_url("order_details") . '/' . $order->order_number; ?>" style='font-size: 14px;text-decoration: none;padding: 14px 40px;background-color: #DF911E;color: #000000 !important; border-radius: 3px;'>
                                        <?php echo trans("see_order_details"); ?>
                                    </a>
                                </p>
                            <?php else : ?>
                                <p style='text-align: center;margin-top: 40px;'>
                                    <a href="<?php echo generate_url("guest_order") . '/' . $order->order_number .'?user_id='.$order->buyer_id; ?>" style='font-size: 14px;text-decoration: none;padding: 14px 40px;background-color: #DF911E;color: #000000 !important; border-radius: 3px;'>
                                        <?php echo trans("see_order_details"); ?>
                                    </a>
                                </p><?php endif; ?>
                            In case of MTO - We understand that you have not been able to service the order on time, leading to cancelation from buyer. We know that all orders are important to you and you try your best to service them, and an exigency would have prevented you from servicing it on time. Request you to be sure of accepting and committing servicing timelines so that the brand image is not negatively impacted. Together lets work towards driving buyer loyalty by offering exceptional service.
                            <br> In case of MTS - We see that the order , has been cancelled by the buyer. We know that cancellations are dissapointing, they are disheartenting for us as well. We hope that such experiences would remain exceptions and more & more buyers would order your products in future.
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