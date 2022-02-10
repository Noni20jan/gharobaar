<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . "third_party/swiftmailer/vendor/autoload.php";
require APPPATH . "third_party/phpmailer/vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email_model extends CI_Model
{
    //send text email
    public function send_test_email($email, $subject, $message)
    {
        $email_body = "This is test mail";
        $message = "Dear  $email <br> $email_body ";
        if (!empty($email)) {
            $data = array(
                'subject' => $subject,
                'message' => $message,
                'to' => $email,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            );
            return $this->send_email($data);
        }
    }
    //send supplier registration email.
    public function send_supplier_reg_email($email, $name)
    {
        $subject = "You’re one step away!";
        $email_body = get_content("one_step_away");
        $message = "Dear" . ucfirst($name) . ", <br> $email_body";
        if (!empty($email)) {
            $data = array(
                'source' => '',
                'source_id' => "",
                'event_type' => 'supplier_reg',
                'subject' => $subject,
                'message' => $message,
                'to' => $email,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            );
            return $this->send_email($data);
        }
    }


    //send supplier registration email.
    // public function send_supplier_reg_email_to_admin($email)
    // {
    //     $subject = "New Shop Opening Request ";
    //     $email_body = get_content("one_step_away");
    //     $message = "Dear Admin, <br> $email_body";
    //     if (!empty($email)) {
    //         $data = array(
    //             'subject' => $subject,
    //             'message' => $message,
    //             'to' => $email,
    //             'template_path' => "email/email_newsletter",
    //             'subscriber' => "",
    //         );
    //         return $this->send_email($data);
    //     }
    // }

    //send buyer registration email.
    public function send_buyer_welcome_email($email, $name)
    {
        $subject = "Welcome to the Family!";
        $email_body = get_content("buyer_welcome_email");
        $message = "Dear" . ucfirst($name) . ", $email_body";
        if (!empty($email)) {
            $data = array(
                'source' => '',
                'source_id' => "",
                'event_type' => 'buyer_welcome_msg',
                'subject' => $subject,
                'message' => $message,
                'to' => $email,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            );
            return $this->send_email($data);
        }
    }

    //send email verifiction otp
    public function email_verify_otp($email, $message)
    {
        $subject = "OTP Verification for registration";
        $message = $message;
        if (!empty($email)) {
            $data = array(
                'source' => '',
                'source_id' => "",
                'event_type' => 'email_otp',
                'subject' => $subject,
                'message' => $message,
                'to' => $email,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
                'remark' => $message
            );
            return $this->send_email($data);
        }
    }
    //mail for send refferal
    // public function refferal_mail($email, $name, $user_name)
    // {
    //     $subject = "Refferal Mail!";

    //     $message = "Dear " . $name . "<br>" . $user_name . " invited you to join gharobaar. Register Yourself by clicking <a href='" . base_url() . "'>here </a><br>Love<br>Team Gharobaar.";
    //     if (!empty($email)) {
    //         $data = array(
    //             'subject' => $subject,
    //             'message' => $message,
    //             'to' => $email,
    //             'template_path' => "email/email_newsletter",
    //             'subscriber' => "",
    //         );
    //         return $this->send_email($data);
    //     }
    // }

    //open shop Email to supplier.
    public function send_open_shopmail($email, $name)
    {
        $subject = "Welcome to the Family!";
        $email_body = get_content("supplier_welcome_email");
        $message = "Dear" . ucfirst($name) . ", $email_body";
        if (!empty($email)) {
            $data = array(
                'source' => '',
                'source_id' => '',
                'event_type' => 'supplier_welcome',
                'subject' => $subject,
                'message' => $message,
                'to' => $email,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            );
            return $this->send_email($data);
        }
    }
    //send revert mail to buyer related to doc issue.
    public function revert_back($email, $name, $message, $issues)
    {
        $subject = "Need some clarification!";
        $issue = implode(" , ->", $issues);
        $email_body = get_content('need_clarification');
        $email_body_end = get_content('need_clarification_end');
        $final_message = "<p> Dear " . ucfirst($name) . ",<br> $email_body<br> <b>$issue</b> , $message $email_body_end";
        if (!empty($email)) {
            $data = array(
                'source' => '',
                'source_id' => '',
                'event_type' => 'revert_back_supplier',
                'subject' => $subject,
                'message' => $final_message,
                'to' => $email,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            );
            return $this->send_email($data);
        }
    }
    public function email_us($email, $message)
    {
        $subject = "Need some clarification!";

        $final_message = "<p> Dear Admin, <br> $message";
        if (!empty($email)) {
            $data = array(
                'source' => '',
                'source_id' => '',
                'event_type' => 'email_us',
                'subject' => $subject,
                'message' => $final_message,
                'to' => $email,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            );
            return $this->send_email($data);
        }
    }
    public function order_window_update_mail_seller($email, $supplier, $order_product)
    {

        $order_details = get_order($order_product->order_id);


        $subject = "Order number  " . $order_details->order_number . " is Accepted";

        $message = "Dear " . $supplier->first_name . ", Thanks you for accepting the order.  <br>After considering your current orders and capacity, the order has to be dispatched by " . dispatch_time($order_product->lead_time, "date") . " to the buyer. We'd like to thank you again for living up to our philosophy of customer centricity. Together we would continue to work hard towards living up to, and if possible exceeding, buyer expectations. Looking forward to your continued support
        <br><b>order number</b> :" . $order_details->order_number . "<br>
        <b>Product </b> :" . $order_product->product_title . "<br>
        <b>Quantity</b> :" . $order_product->product_quantity . "<br>
        <b>Product Unit Price</b> :" . price_formatted($order_product->product_unit_price, $order_product->product_currency) . "<br>
        <b>Discount Price</b> :" . price_formatted($order_product->product_discount_amount * 100, $order_product->product_currency) . "<br>
        <b>Total Amount</b> :" . price_formatted($order_product->product_total_price, $order_product->product_currency);


        // var_dump($message);
        // die();
        if (!empty($email)) {
            $data = array(
                'source' => '',
                'source_id' => '',
                'event_type' => 'Order Update',
                'subject' => $subject,
                'message' => $message,
                'remark' => "Your Order #" . $order_details->order_number . " has been accepted by the seller and ready for dispatch. Our courier partners shall pick the order latest by tomorrow.",
                'to' => $email,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            );
            return $this->send_email($data);
        }
    }
    public function order_window_update_mail_buyer($email, $buyer, $order_product)
    {

        $seller = get_user($order_product->seller_id);
        $order_details = get_order($order_product->order_id);


        $subject = "Order number  " . $order_details->order_number . " is Accepted";

        $message = "Dear "  . $buyer->first_name . ", Thanks you for placing the order with Gharobaar.<br>We write to share that seller " . $seller->shop_name . " has accepted the order and it would be dispatched by " . dispatch_time($order_product->lead_time) . " to you. We'd like to thank you again for reposing faith in Gharobaar and our supplier partners. We would work hard towards living up to, and if possible exceeding, your expectations. We'd love to hear about your experience of this purchase. Looking forward to hosting you again on Gharobaar.
        <b>order number</b> :" . $order_details->order_number . "<br>
        <b>Product </b> :" . $order_product->product_title . "<br>
        <b>Quantity</b> :" . $order_product->product_quantity . "<br>
        <b>Product Unit Price</b> :" . price_formatted($order_product->product_unit_price, $order_product->product_currency) . "<br>
        <b>Discount Price</b> :" . price_formatted($order_product->product_discount_amount * 100, $order_product->product_currency) . "<br>
        <b>Shipping</b> :" . price_formatted($order_product->product_shipping_cost, $order_product->product_currency) . "<br>
        <b>Total Amount</b> :" . price_formatted($order_product->product_total_price + $order_product->product_shipping_cost, $order_product->product_currency);

        if (!empty($email)) {
            $data = array(
                'source' => '',
                'source_id' => '',
                'event_type' => 'Order Placement',
                'subject' => $subject,
                'message' => $message,
                'remark' => "Your Order for " . $order_product->product_title . " has been succefully placed vide Order #" . $order_details->order_number . " and the product will be dispatched within " . dispatch_time($order_product->lead_time) . ".",
                'to' => $email,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            );
            return $this->send_email($data);
        }
    }

    public function approve_product($product_id)
    {
        // if (get_product($product_id) {
        $product = get_product($product_id);
        $user = get_user($product->user_id);
        $title = $this->product_model->get_title($product_id);
        // var_dump($title);
        // die();
        $subject = "Your Product " . $title->title . " is Approved by seller";
        // var_dump($subject);
        // die();
        $message = "Dear "  . ucfirst($user->first_name) . ",<br>Your product" . $title->title . " is accepted by Admin. Your product is now listed on our website.
            <br>
            <b>Product Details</b>
            <br>
            <b>Product Id</b> :" . $product->id . "<br>
            <b>Product </b> :" . $title->title . "<br>
            <b>Product Unit Price</b> :" . price_formatted($product->listing_price, $product->currency) . "<br><br>Team Gharobaar";
        // } else {
        //     $message = "Dear "  . ucfirst($supplier->first_name) . ",<br> We see that the order has been cancelled by the buyer. We know that cancellations are dissapointing, they are disheartenting for us as well. We hope that such experiences would remain exceptions and more & more buyers would order your products in future.
        //     <br>
        //     <b>Order Details</b>
        //     <br><b>order number</b> :" . $order->order_number . "<br>
        //     <b>Product </b> :" . $order_product->product_title . "<br>
        //     <b>Quantity</b> :" . $order_product->product_quantity . "<br>
        //     <b>Product Unit Price</b> :" . price_formatted($order_product->product_unit_price, $order_product->product_currency) . "<br><br>Team Gharobaar";
        // }
        $data1 = array(
            'source' => 'products',
            'remark' => "Your product " . $title->title . " has been approved and is now live on the platform. Click on the link to view your listing .<a href='" . base_url() . $product->slug . "'>" .  $title->title . "</a>",
            'source_id' => $product_id,
            'event_type' => 'Listings',
            'subject' => $subject,
            'message' => $message,
            'to' => $user->email,
            'template_path' => "email/email_newsletter",
        );
        $this->send_email($data1);
        $sql = "(select follower_id from products join followers on products.user_id=followers.following_id where products.id='$product_id')";
        $query = $this->db->query($sql);
        $followers = $query->result();
        foreach ($followers as $follower) {
            // if (!empty($email)) {
            $data = array(
                'source' => 'products',
                'source_id' => $product_id,
                'remark' => "Your Favourite Seller" . ucfirst($user->first_name) . " has launched a new product <a href='" . base_url() . $product->slug . "'>" .  $title->title . "</a>.",
                'event_type' => 'Gharobaar Updates',
                'subject' => "Hooray Your favourite seller has added new product",
                'message' => "Your Favourite Seller" . ucfirst($user->first_name) . " has launched a new product <a href='" . base_url() . $product->slug . "'>" .  $title->title . "</a>.",
                'to' => $follower->follower_id,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            );
            $this->notification($data);
        }
        return true;
    }
    public function cancel_order_product_mail($email, $supplier, $order_product)
    {
        $order = get_order($order_product->order_id);
        $subject = "Order number  #" . $order->order_number . " is cancelled by Buyer";
        if (get_product($order_product->product_id)->add_meet == "Made to order") {
            $message = "Dear "  . ucfirst($supplier->first_name) . ",<br>We understand that you have not been able to service the order on time, leading to cancelation from buyer. We know that all orders are important to you and you try your best to service them, and an exigency would have prevented you from servicing it on time. Request you to be sure of accepting and committing servicing timelines so that the brand image is not negatively impacted. Together lets work towards driving buyer loyalty by offering exceptional service.
            <br>
            <b>Order Details</b>
            <br>
            <b>order number</b> :" . $order->order_number . "<br>
            <b>Product </b> :" . $order_product->product_title . "<br>
            <b>Quantity</b> :" . $order_product->product_quantity . "<br>
            <b>Product Unit Price</b> :" . price_formatted($order_product->product_unit_price, $order_product->product_currency) . "<br><br>Team Gharobaar";
        } else {
            $message = "Dear "  . ucfirst($supplier->first_name) . ",<br> We see that the order has been cancelled by the buyer. We know that cancellations are dissapointing, they are disheartenting for us as well. We hope that such experiences would remain exceptions and more & more buyers would order your products in future.
            <br>
            <b>Order Details</b>
            <br><b>order number</b> :" . $order->order_number . "<br>
            <b>Product </b> :" . $order_product->product_title . "<br>
            <b>Quantity</b> :" . $order_product->product_quantity . "<br>
            <b>Product Unit Price</b> :" . price_formatted($order_product->product_unit_price, $order_product->product_currency) . "<br><br>Team Gharobaar";
        }

        if (!empty($email)) {
            $data = array(
                'source' => '',
                'source_id' => '',
                'remark' => "We regret to inform you that the Order for " . $order_product->product_title . " vide Order ID # " . $order->order_number . ".has been cencelled by the buyer.",
                'event_type' => 'Order Cancellation by Seller',
                'subject' => $subject,
                'message' => $message,
                'to' => $email,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            );
            return $this->send_email($data);
        }
    }
    public function cancel_order_mail($email, $supplier)
    {
        $order_id=$this->input->post('order_id',true);
        $order=get_order($order_id);
        $order_product=$this->order_model->get_order_products($order_id);
        foreach($order_product as $order_p):
        endforeach;
        $subject = "Order number  #" . $order->order_number . " is cancelled by Buyer";
        if (get_product($order_p->product_id)->add_meet == "Made to order") {
            $message = "Dear "  . ucfirst($supplier->first_name) . ",<br>We understand that you have not been able to service the order on time, leading to cancelation from buyer. We know that all orders are important to you and you try your best to service them, and an exigency would have prevented you from servicing it on time. Request you to be sure of accepting and committing servicing timelines so that the brand image is not negatively impacted. Together lets work towards driving buyer loyalty by offering exceptional service.
            <br>
            <b>Order Details</b>
            <br>
            <b>order number</b> :" . $order->order_number . "<br>
            <b>Product </b> :" . $order_p->product_title . "<br>
            <b>Quantity</b> :" . $order_p->product_quantity . "<br>
            <b>Product Unit Price</b> :" . price_formatted($order_p->product_unit_price, $order_p->product_currency) . "<br><br>Team Gharobaar";
        } else {
            $message = "Dear "  . ucfirst($supplier->first_name) . ",<br> We see that the order has been cancelled by the buyer. We know that cancellations are dissapointing, they are disheartenting for us as well. We hope that such experiences would remain exceptions and more & more buyers would order your products in future.
            <br>
            <b>Order Details</b>
            <br><b>order number</b> :" . $order->order_number . "<br>
            <b>Product </b> :" . $order_p->product_title . "<br>
            <b>Quantity</b> :" . $order_p->product_quantity . "<br>
            <b>Product Unit Price</b> :" . price_formatted($order_p->product_unit_price, $order_p->product_currency) . "<br><br>Team Gharobaar";
        }

        if (!empty($email)) {
            $data = array(
                'source' => '',
                'source_id' => '',
                'remark' => "We regret to inform you that the Order for " . $order_p->product_title . " vide Order ID # " . $order->order_number . ".has been cencelled by the buyer.",
                'event_type' => 'Order Cancellation by Seller',
                'subject' => $subject,
                'message' => $message,
                'to' => $email,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            );
            return $this->send_email($data);
        }
    }
    public function cancel_order_buyer_email($email, $buyer){
        $order_id=$this->input->post('order_id',true);
        $order=get_order($order_id);
        $order_product=$this->order_model->get_order_products($order_id);
        foreach($order_product as $order_p):
        endforeach;
        $subject = "Order number  #" . $order->order_number . " is cancelled by Buyer";
        if (get_product($order_p->product_id)->add_meet == "Made to order") {
            $message = "Dear "  . ucfirst($buyer->first_name) . ",<br>We have taken note of the cancellation made by you. We understand that our servicability has been a concern prompting you to cancel. We shall process the refund within 7 business days. We aplogise for the inconvenience caused and hope to meet your expectations going forward.
            <br>
            <b>Order Details</b>
        <b>order number</b> :" . $order->order_number . "<br>
        <b>Product </b> :" . $order_p->product_title . "<br>
        <b>Quantity</b> :" . $order_p->product_quantity . "<br>
        <b>Product Unit Price</b> :" . price_formatted($order_p->product_unit_price, $order_p->product_currency) . "<br><br>Team Gharobaar";
        } else {

            $message = "Dear "  . ucfirst($buyer->first_name) . ",<br>We understand that you have cancelled Order. As the product is no longer required. We shall process the refund within 7 business days. For future, we seek your help in supporting the homeprenuers, we all get excited on receiving orders and get disheartened when its cancelled. We hope to continue receiving your encouragement.
            <br>
            <b>Order Details</b>
        <b>order number</b> :" . $order->order_number . "<br>
        <b>Product </b> :" . $order_p->product_title . "<br>
        <b>Quantity</b> :" . $order_p->product_quantity . "<br>
        <b>Product Unit Price</b> :" . price_formatted($order_p->product_unit_price, $order_p->product_currency) . "<br><br>Team Gharobaar";
        }
        if (!empty($email)) {
            $data = array(
                'source' => '',
                'source_id' => '',
                'event_type' => 'buyer_cancel_order',
                'subject' => $subject,
                'message' => $message,
                'to' => $email,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            );
            return $this->send_email($data);

                } 
    }

    public function cancel_order_product_mail_buyer($email, $buyer, $order_product)
    {
        $order = get_order($order_product->order_id);
        $subject = "Order number  #" . $order->order_number . " is cancelled by Buyer";
        if (get_product($order_product->product_id)->add_meet == "Made to order") {
            $message = "Dear "  . ucfirst($buyer->first_name) . ",<br>We have taken note of the cancellation made by you. We understand that our servicability has been a concern prompting you to cancel. We shall process the refund within 7 business days. We aplogise for the inconvenience caused and hope to meet your expectations going forward.
            <br>
            <b>Order Details</b>
        <b>order number</b> :" . $order->order_number . "<br>
        <b>Product </b> :" . $order_product->product_title . "<br>
        <b>Quantity</b> :" . $order_product->product_quantity . "<br>
        <b>Product Unit Price</b> :" . price_formatted($order_product->product_unit_price, $order_product->product_currency) . "<br><br>Team Gharobaar";
        } else {

            $message = "Dear "  . ucfirst($buyer->first_name) . ",<br>We understand that you have cancelled Order. As the product is no longer required. We shall process the refund within 7 business days. For future, we seek your help in supporting the homeprenuers, we all get excited on receiving orders and get disheartened when its cancelled. We hope to continue receiving your encouragement.
            <br>
            <b>Order Details</b>
        <b>order number</b> :" . $order->order_number . "<br>
        <b>Product </b> :" . $order_product->product_title . "<br>
        <b>Quantity</b> :" . $order_product->product_quantity . "<br>
        <b>Product Unit Price</b> :" . price_formatted($order_product->product_unit_price, $order_product->product_currency) . "<br><br>Team Gharobaar";
        }
        if (!empty($email)) {
            $data = array(
                'source' => '',
                'source_id' => '',
                'event_type' => 'buyer_cancel_order',
                'subject' => $subject,
                'message' => $message,
                'to' => $email,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            );
            return $this->send_email($data);
        }
    }

    public function revert_back_product($email, $name, $message, $product_id, $remark)
    {
        $subject = "Need some clarification!";

        $final_message = "<p> Dear" . ucfirst($name) . ",<br> <br>   $message";
        if (!empty($email)) {
            $data = array(
                'remark' => $remark,
                'source' => 'products',
                'source_id' => $product_id,
                'event_type' => 'product_revert_back',
                'subject' => $subject,
                'message' => $final_message,
                'to' => $email,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            );
            return $this->send_email($data);
        }
    }
    //regret email to supplier.
    public function send_regret_shopmail($email, $name)
    {
        $subject = "Gharobaar Important!";
        $email_body = get_content("supplier_rejection_email");
        $message = "Dear" . ucfirst($name) . ", $email_body";
        if (!empty($email)) {
            $data = array(
                'source' => '',
                'source_id' => '',
                'event_type' => 'suplier_rejection',
                'subject' => $subject,
                'message' => $message,
                'to' => $email,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            );
            return $this->send_email($data);
        }
    }
    // bank account verification mail
    public function seller_bank_account_detail_verify($user_id)
    {
        $user_id = clean_number($user_id);
        $user = $this->auth_model->get_user($user_id);
        if (!empty($user)) {
            $token = $user->token;
            //check token
            if (empty($token)) {
                $token = generate_token();
                $data = array(
                    'token' => $token
                );
                $this->db->where('id', $user->id);
                $this->db->update('users', $data);
            }

            $data = array(
                'source' => '',
                'source_id' => '',
                'remark' => "Your banking details have been verified and approved by the admin.",
                'event_type' => 'Profile',
                'subject' => "Bank account added",
                'to' => $user->email,
                'template_path' => "email/email_newsletter",
                'token' => $token,
                'message' => "Dear seller,<br> Your bank account details are verified successfully"
            );

            $this->send_email($data);
        }
    }
    // bank account confirmation for seller
    public function seller_bank_account_detail($user_id)
    {
        $user_id = clean_number($user_id);
        $user = $this->auth_model->get_user($user_id);
        if (!empty($user)) {
            $token = $user->token;
            //check token
            if (empty($token)) {
                $token = generate_token();
                $data = array(
                    'token' => $token
                );
                $this->db->where('id', $user->id);
                $this->db->update('users', $data);
            }

            $data = array(
                'source' => '',
                'source_id' => '',
                'event_type' => 'seller_bank_account',
                'subject' => "Bank account added",
                'to' => $this->general_settings->mail_username,
                'template_path' => "email/email_newsletter",
                'token' => $token,
                'message' => "Dear admin,<br> Seller " . $user->username . "(" . $user->shop_name . ") successfully entered bank account details. Please approve.<br> Thank you,<br>Gharobaar."
            );

            $this->send_email($data);
        }
    }
    //send email activation
    public function send_email_activation($user_id)
    {
        $user_id = clean_number($user_id);
        $user = $this->auth_model->get_user($user_id);
        if (!empty($user)) {
            $token = $user->token;
            //check token
            if (empty($token)) {
                $token = generate_token();
                $data = array(
                    'token' => $token
                );
                $this->db->where('id', $user->id);
                $this->db->update('users', $data);
            }

            $data = array(
                'source' => '',
                'source_id' => '',
                'event_type' => 'account_confirmation',
                'subject' => trans("confirm_your_account"),
                'to' => $user->email,
                'template_path' => "email/email_activation",
                'token' => $token
            );

            $this->send_email($data);
        }
    }

    //send email reset password
    public function send_email_reset_password($user_id)
    {
        $user_id = clean_number($user_id);
        $user = $this->auth_model->get_user($user_id);
        if (!empty($user)) {
            $token = $user->token;
            //check token
            if (empty($token)) {
                $token = generate_token();
                $data = array(
                    'token' => $token
                );
                $this->db->where('id', $user->id);
                $this->db->update('users', $data);
            }

            $data = array(
                'source' => '',
                'source_id' => '',
                'event_type' => 'reset_password',
                'subject' => trans("reset_password"),
                'to' => $user->email,
                'template_path' => "email/email_reset_password",
                'token' => $token
            );

            $this->send_email($data);
        }
    }

    //send email newsletter
    public function send_email_newsletter($subscriber, $subject, $message)
    {
        if (!empty($subscriber)) {
            if (empty($subscriber->token)) {
                $this->newsletter_model->update_subscriber_token($subscriber->email);
                $subscriber = $this->newsletter_model->get_subscriber($subscriber->email);
            }

            $data = array(
                'source' => '',
                'source_id' => '',
                'event_type' => 'newsletter',
                'subject' => $subject,
                'message' => $message,
                'to' => $subscriber->email,
                'template_path' => "email/email_newsletter",
                'subscriber' => $subscriber,
            );
            return $this->send_email($data);
        }
    }
    //send email newsletter members
    public function send_email_members_newsletter($emailto, $emailtoall, $subject, $message)
    {
        if ($emailto == "members") {
            if (!empty($emailtoall)) {
                $data = array(
                    'source' => '',
                    'source_id' => '',
                    'event_type' => 'bulk_mail',
                    'subject' => $subject,
                    'message' => $message,
                    'to' =>  $this->general_settings->mail_username,
                    'template_path' => "email/event_template",


                );
                $bcc = array();
                foreach ($emailtoall as $emailtoall) {
                    array_push($bcc, $emailtoall);
                }
                return $this->send_email_members($data, $bcc);
            }
        }
        if ($emailto == "all") {
            if (!empty($emailtoall)) {
                $data = array(
                    'source' => '',
                    'source_id' => '',
                    'event_type' => 'bulk_mail',
                    'subject' => $subject,
                    'message' => $message,
                    'to' => $this->general_settings->mail_username,
                    'template_path' => "email/event_template",
                );
                $bcc = array();
                foreach ($emailtoall as $emailtoall) {
                    array_push($bcc, $emailtoall);
                }
                return $this->send_email_members($data, $bcc);
            }
        }
    }
    public function notification($data)
    {
        if ($this->auth_check) {
            $id = $this->auth_user->id;
        } else {
            $id = '0';
        }
        $notify = array(
            'message' => $data['message'],
            'title' => $data['subject'],
            'created_by' => $id,
            'last_updated_by' => $id,
            'source_id' => $data['source_id'],
            'source' => $data['source'],
            'remark' => $data['remark'],
        );
        $this->db->insert("notifications", $notify);
        $last_id = $this->db->insert_id();
        $notification = array(
            'for_user' => $data['to'],
            'notification_id' => $last_id,
            'notification_type' => 'email',
            'event_type' => 'product',
            'read' => '0',
            'event_type' => $data['event_type'],

            'created_by' => $id,
            'last_updated_by' => $id,
        );
        $this->db->insert("notify_user", $notification);
    }
    public function send_email_members($data, $bcc)
    {
        require dirname(__FILE__) . "/../../sendgrid-php/sendgrid-php.php";

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($this->general_settings->mail_username, "Gharobaar");
        $email->setSubject($data['subject']);
        $email->addTo($this->general_settings->mail_username);
        foreach ($bcc as $bcc) {
            $email->AddBCC($bcc);
        }
        $subject = $this->load->view($data['template_path'], $data, TRUE, 'text/html');

        $email->addContent("text/html", $subject);
        // var_dump($email);
        // die();

        $sendgrid = new \SendGrid("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");

        try {
            $response = $sendgrid->send($email);
            $response->statusCode();
            $response->headers();
            $response->body();
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    }
    public function send_email($data)
    {
        $this->notification($data);
        require dirname(__FILE__) . "/../../sendgrid-php/sendgrid-php.php";
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($this->general_settings->mail_username, "Gharobaar");
        $email->setSubject($data['subject']);
        $email->addTo($data['to']);
        $ip = $this->input->ip_address();
        $request_body = json_decode('{
            "ips": [
                {
                    "ip": "192.168.1.1"
                },
                {
                    "ip": "192.*.*.*"
                },
                {
                    "ip": "223.178.212.176"
                }
            ]
        }');
        $subject = $this->load->view($data['template_path'], $data, TRUE, 'text/html');
        // var_dump($subject);
        $email->addContent("text/html", $subject);

        $sendgrid1 = new \SendGrid("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", ["impersonateSubuser" => "Harshit"]);

        $sendgrid = new \SendGrid("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");

        try {
            $response1 = $sendgrid1->client->access_settings()->whitelist()->post($request_body);
            $response1->statusCode();
            $response1->headers();
            $response1->body();
            $response = $sendgrid->send($email);
            $response->statusCode();
            $response->headers();
            $response->body();
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    }
    //send email
    // public function send_email($data)
    // {
    //     if ($this->general_settings->mail_library == "swift") {
    //         try {
    //             // Create the Transport
    //             $transport = (new Swift_SmtpTransport($this->general_settings->mail_host, $this->general_settings->mail_port, 'tls'))
    //                 ->setUsername($this->general_settings->mail_username)
    //                 ->setPassword($this->general_settings->mail_password);

    //             // Create the Mailer using your created Transport
    //             $mailer = new Swift_Mailer($transport);

    //             // Create a message
    //             $message = (new Swift_Message($this->general_settings->mail_title))
    //                 ->setFrom(array($this->general_settings->mail_username => $this->general_settings->mail_title))
    //                 ->setTo([$data['to'] => ''])
    //                 ->setSubject($data['subject'])
    //                 ->setBody($this->load->view($data['template_path'], $data, TRUE), 'text/html');

    //             //Send the message
    //             $result = $mailer->send($message);
    //             if ($result) {
    //                 return true;
    //             }
    //         } catch (\Swift_TransportException $Ste) {
    //             $this->session->set_flashdata('error', $Ste->getMessage());
    //             return false;
    //         } catch (\Swift_RfcComplianceException $Ste) {
    //             $this->session->set_flashdata('error', $Ste->getMessage());
    //             return false;
    //         }
    //     } elseif ($this->general_settings->mail_library == "php") {
    //         $mail = new PHPMailer(true);
    //         try {
    //             //Server settings
    //             $mail->isSMTP();
    //             $mail->Host = $this->general_settings->mail_host;
    //             $mail->SMTPAuth = true;
    //             $mail->Username = $this->general_settings->mail_username;
    //             $mail->Password = $this->general_settings->mail_password;
    //             $mail->SMTPSecure = 'tls';
    //             $mail->CharSet = 'UTF-8';
    //             $mail->Port = $this->general_settings->mail_port;
    //             //Recipients
    //             $mail->setFrom($this->general_settings->mail_username, $this->general_settings->mail_title);
    //             $mail->addAddress($data['to']);
    //             //Content
    //             $mail->isHTML(true);
    //             $mail->Subject = $data['subject'];
    //             $mail->Body = $this->load->view($data['template_path'], $data, TRUE, 'text/html');
    //             $mail->send();
    //             return true;
    //         } catch (Exception $e) {
    //             $this->session->set_flashdata('error', $mail->ErrorInfo);
    //             return false;
    //         }
    //     } else {
    //         $this->load->library('email');

    //         $settings = $this->settings_model->get_general_settings();
    //         $from = $settings->mail_username;
    //         if (strpos($from, '@') == false) {
    //             $from = "noreply@" . $_SERVER["HTTP_HOST"];
    //         }

    //         $config = array(
    //             'protocol' => 'mail',
    //             'smtp_host' => $settings->mail_host,
    //             'smtp_port' => $settings->mail_port,
    //             'smtp_user' => $settings->mail_username,
    //             'smtp_pass' => $settings->mail_password,
    //             'smtp_timeout' => 30,
    //             'mailtype' => 'html',
    //             'charset' => 'utf-8',
    //             'wordwrap' => TRUE
    //         );
    //         if ($settings->mail_protocol == "sendmail") {
    //             $config['protocol'] = 'sendmail';
    //         }
    //         if ($settings->mail_protocol == "smtp") {
    //             $config['protocol'] = 'smtp';
    //         }

    //         //initialize
    //         $this->email->initialize($config);

    //         //send email
    //         $message = $this->load->view($data['template_path'], $data, TRUE);
    //         $this->email->from($from, $settings->mail_title);
    //         $this->email->to($data['to']);
    //         $this->email->subject($data['subject']);
    //         $this->email->message($message);

    //         $this->email->set_newline("\r\n");

    //         if ($this->email->send()) {
    //             return true;
    //         } else {
    //             $this->session->set_flashdata('error', $this->email->print_debugger(array('headers')));
    //             return false;
    //         }
    //     }
    // }

    // public function send_email_members($data, $bcc)
    // {
    //     if ($this->general_settings->mail_library == "swift") {
    //         try {
    //             // Create the Transport
    //             $transport = (new Swift_SmtpTransport($this->general_settings->mail_host, $this->general_settings->mail_port, 'tls'))
    //                 ->setUsername($this->general_settings->mail_username)
    //                 ->setPassword($this->general_settings->mail_password);

    //             // Create the Mailer using your created Transport
    //             $mailer = new Swift_Mailer($transport);

    //             // Create a message
    //             $message = (new Swift_Message($this->general_settings->mail_title))
    //                 ->setFrom(array($this->general_settings->mail_username => $this->general_settings->mail_title))
    //                 ->setTo([$data['to'] => ''])
    //                 ->setSubject($data['subject'])
    //                 ->setBody($this->load->view($data['template_path'], $data, TRUE), 'text/html');

    //             //Send the message
    //             $result = $mailer->send($message);
    //             if ($result) {
    //                 return true;
    //             }
    //         } catch (\Swift_TransportException $Ste) {
    //             $this->session->set_flashdata('error', $Ste->getMessage());
    //             return false;
    //         } catch (\Swift_RfcComplianceException $Ste) {
    //             $this->session->set_flashdata('error', $Ste->getMessage());
    //             return false;
    //         }
    //     } elseif ($this->general_settings->mail_library == "php") {
    //         $mail = new PHPMailer(true);
    //         try {
    //             //Server settings
    //             $mail->isSMTP();
    //             $mail->Host = $this->general_settings->mail_host;
    //             $mail->SMTPAuth = true;
    //             $mail->Username = $this->general_settings->mail_username;
    //             $mail->Password = $this->general_settings->mail_password;
    //             $mail->SMTPSecure = 'tls';
    //             $mail->CharSet = 'UTF-8';
    //             $mail->Port = $this->general_settings->mail_port;
    //             //Recipients
    //             $mail->setFrom($this->general_settings->mail_username, $this->general_settings->mail_title);
    //             $mail->addAddress($data['to']);
    //             foreach ($bcc as $bcc) {
    //                 $mail->AddBCC($bcc);
    //             }
    //             //Content
    //             $mail->isHTML(true);
    //             $mail->Subject = $data['subject'];
    //             $mail->Body = $this->load->view($data['template_path'], $data, TRUE, 'text/html');
    //             $mail->send();
    //             return true;
    //         } catch (Exception $e) {
    //             $this->session->set_flashdata('error', $mail->ErrorInfo);
    //             return false;
    //         }
    //     } else {
    //         $this->load->library('email');

    //         $settings = $this->settings_model->get_general_settings();
    //         $from = $settings->mail_username;
    //         if (strpos($from, '@') == false) {
    //             $from = "noreply@" . $_SERVER["HTTP_HOST"];
    //         }

    //         $config = array(
    //             'protocol' => 'mail',
    //             'smtp_host' => $settings->mail_host,
    //             'smtp_port' => $settings->mail_port,
    //             'smtp_user' => $settings->mail_username,
    //             'smtp_pass' => $settings->mail_password,
    //             'smtp_timeout' => 30,
    //             'mailtype' => 'html',
    //             'charset' => 'utf-8',
    //             'wordwrap' => TRUE
    //         );
    //         if ($settings->mail_protocol == "sendmail") {
    //             $config['protocol'] = 'sendmail';
    //         }
    //         if ($settings->mail_protocol == "smtp") {
    //             $config['protocol'] = 'smtp';
    //         }

    //         //initialize
    //         $this->email->initialize($config);

    //         //send email
    //         $message = $this->load->view($data['template_path'], $data, TRUE);
    //         $this->email->from($from, $settings->mail_title);
    //         $this->email->to($data['to']);
    //         $this->email->subject($data['subject']);
    //         $this->email->message($message);

    //         $this->email->set_newline("\r\n");

    //         if ($this->email->send()) {
    //             return true;
    //         } else {
    //             $this->session->set_flashdata('error', $this->email->print_debugger(array('headers')));
    //             return false;
    //         }
    //     }
    // }
}
