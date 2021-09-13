<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_model extends CI_Model
{
    // public function variation_option_array($order_id){
    //     $order_products = $this->get_order_products($order_id);
    //     if (!empty($order_products)) {
    //         foreach ($order_products as $order_product) {
    //             // $variations_new = $this->variation_model->get_product_variations($order_product->product_id);

    //                 $variation_id = @unserialize($order_product->variation_option_ids);
    //                 $option = $this->variation_model->get_variation_option($variation_id[0]);
    //                 // $variation = $this->variation_model->get_variation($option->variation_id);
    //                 // $option1 = $this->cart_model->get_selected_variations($order_product->product_id);
    //                 return $option;

    //         }
    //     }
    // }

    //add order
    public function add_order($data_transaction)
    {
        $order_product_status = "processing";
        $cart_total = $this->cart_model->get_sess_cart_total();
        if (!empty($cart_total)) {
            $data = array(
                'order_number' => uniqid(),
                'buyer_id' => 0,
                'buyer_type' => "guest",
                'price_subtotal' => $cart_total->total,
                'price_gst' => $cart_total->gst,
                // 'discount' => $cart_total->discount,
                // 'price_shipping' => $this->input->post('price_shipping', true),
                'price_shipping' => $cart_total->shipping_cost,
                'price_total' => $cart_total->total_price,
                'price_currency' => $cart_total->currency,

                'discount' => $cart_total->discount * 100,
                'total_cod_charges' => $cart_total->total_cod_charges,
                'total_tax_charges' => $cart_total->total_tax_charges,


                'status' => 0,
                'payment_method' => $data_transaction["payment_method"],
                'payment_status' => "payment_received",
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            );

            //if cart does not have physical product
            if ($this->cart_model->check_cart_has_physical_product() != true) {
                $data["status"] = 1;
            }
            // if($this->cart_model->check_cart_has_made_to_order_product() ==true)
            // {
            //     $data["status"] = 10;
            // }

            if ($this->auth_check) {
                $data["buyer_type"] = "registered";
                $data["buyer_id"] = $this->auth_user->id;
            }
            if ($this->db->insert('orders', $data)) {
                $order_id = $this->db->insert_id();

                //update order number
                $this->update_order_number($order_id);

                //add order shipping
                $this->add_order_shipping($order_id);

                //add order products
                $this->add_order_products($order_id, $order_product_status, 'payment_received');

                //update shipping cost per product of seller
                $this->update_shipping_cost($order_id, $cart_total);

                $this->add_seller_wise_details($order_id, $cart_total);

                //add digital sales
                $this->add_digital_sales($order_id);

                //add seller earnings
                $this->add_digital_sales_seller_earnings($order_id);

                //add payment transaction
                $this->add_payment_transaction($data_transaction, $order_id);

                //set bidding quotes as completed
                $this->load->model('bidding_model');
                $this->bidding_model->set_bidding_quotes_as_completed_after_purchase();

                //clear cart from db
                $this->cart_model->unset_cart_items_from_db_after_purcahse();

                //clear cart
                $this->cart_model->clear_cart();

                return $order_id;
            }
            return false;
        }
        return false;
    }

    //add order offline payment
    public function add_order_offline_payment($payment_method)
    {
        $order_status = "awaiting_payment";
        $payment_status = "awaiting_payment";
        $order_product_status = "processing";
        if ($payment_method == 'Cash On Delivery') {
            $order_status = "order_processing";
        }
        // if($this->cart_model->check_cart_has_made_to_order_product() ==true)
        // {
        //     $data["order_status"] = "waiting";
        // }

        $cart_total = $this->cart_model->get_sess_cart_total();

        // $Supp_ship_data = json_decode($this->get_shipping_cost($cart_total));
        // var_dump($Supp_ship_data);

        // $this->add_seller_wise_details(1, $cart_total);
        // die();


        if (!empty($cart_total)) {
            $data = array(
                'order_number' => uniqid(),
                'buyer_id' => 0,
                'buyer_type' => "guest",
                'price_subtotal' => round($cart_total->total / 100) * 100,
                'price_gst' => $cart_total->gst,
                // 'discount' => $cart_total->discount,
                'price_shipping' => $cart_total->shipping_cost,
                'price_total' => $cart_total->total_price,
                'price_currency' => $cart_total->currency,

                'discount' => $cart_total->discount * 100,
                'total_cod_charges' => $cart_total->total_cod_charges,
                'total_tax_charges' => $cart_total->total_tax_charges,

                'status' => 0,
                'payment_method' => $payment_method,
                'payment_status' => $payment_status,
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            );

            if ($this->auth_check) {
                $data["buyer_type"] = "registered";
                $data["buyer_id"] = $this->auth_user->id;
            }
            if ($this->db->insert('orders', $data)) {
                $order_id = $this->db->insert_id();

                //update order number
                $this->update_order_number($order_id);

                //add order shipping
                $this->add_order_shipping($order_id);

                //add order products
                $this->add_order_products($order_id, $order_product_status, $payment_status);


                $this->update_shipping_cost($order_id, $cart_total);


                $this->add_seller_wise_details($order_id, $cart_total);


                //set bidding quotes as completed
                $this->load->model('bidding_model');
                $this->bidding_model->set_bidding_quotes_as_completed_after_purchase();

                //add invoice
                $this->add_invoice($order_id);


                //clear cart from db
                $this->cart_model->unset_cart_items_from_db_after_purcahse();

                //clear cart
                $this->cart_model->clear_cart();

                return $order_id;
            }
            return false;
        }
        return false;
    }

    //update order number
    public function update_order_number($order_id)
    {
        $order_id = clean_number($order_id);
        $data = array(
            'order_number' => $order_id + 10000
        );
        $this->db->where('id', $order_id);
        $this->db->update('orders', $data);
    }

    public function accept_reject_order($order_id, $action)
    {
        $order_id = clean_number($order_id);
        if ($action == "reject") {
            $data = array(
                'status' => 5
            );
        }
        if ($action == "accept") {
            $data = array(
                'status' => 0
            );
        }
        $this->db->where('id', $order_id);
        $this->db->update('orders', $data);
    }
    public function dispatch_time($lead_time, $type = "days")
    {
        $lead_days = intval($lead_time / 86400);
        if ($type == "days") :
            if ($lead_days > 1) {
                return $lead_days . " days";
            } else {
                return $lead_days . " day";
            }
        endif;
        $lead_date = time() + $lead_time;
        if ($type == "date")
            return date("d-m-Y", $lead_date);
    }

    public function accept_reject_order_product($id, $action, $reject_reason_before_accept, $reject_reason_comment)
    {
        $id = clean_number($id);
        $order_product = $this->get_order_product($id);
        $order_item_product_id = $order_product->product_id;
        $order_id = $order_product->order_id;
        $reject_reason_before_accept = $reject_reason_before_accept;
        $reject_reason_comment = $reject_reason_comment;
        if ($action == "reject") {

            $data = array(
                'order_status' => 'rejected',
                'reject_reason_before_accept' => $reject_reason_before_accept,
                'reject_reason_comment' => $reject_reason_comment
            );
            $this->increase_product_stock_after_cancel($order_id, $order_item_product_id);
        }
        if ($action == "accept") {
            $data = array(
                'order_status' => 'processing',
                'accepted_at' => date('Y-m-d H:i:s')
            );
            if ($data["order_status"] == 'processing') {
                //send email
                if ($this->general_settings->send_email_order_shipped == 1) {
                    $message = "Dear " . get_user($order_product->seller_id)->first_name . ", 
                    <br> Thanks you for accepting the order   <br> 
                    <b>order number</b> : #" . $order_product->id . " <br>
                    <b> Product</b> : " . $order_product->product_title . "<br> 

<b>Quantity</b> :" . $order_product->product_quantity . "<br>
<b>Product Unit Price</b> :" . price_formatted($order_product->product_unit_price, $order_product->product_currency) . "<br>
<b>Shipping</b> :" . price_formatted($order_product->product_shipping_cost, $order_product->product_currency) .
                        "<br>. After considering your current orders and capacity, the order has to be dispatched by 
                        <b>" . get_product($order_product->product_id)->lead_days . " days</b> to the buyer. We'd like to thank you again for living up to our philosophy of customer centricity. Together we would continue to work hard towards living up to, and if possible exceeding, buyer expectations. Looking forward to your continued support. ";


                    $email_data = array(
                        'email_type' => 'email_general',
                        'to' => get_user($order_product->seller_id)->email,
                        'subject' => "Thankyou for accepting order",
                        'email_content' => $message



                    );
                    $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
                    $email_data = array(
                        'email_type' => 'email_general',
                        'to' => get_user($order_product->buyer_id)->email,
                        'subject' => "Thank you for your order",
                        'email_content' => "Dear " . get_user($order_product->buyer_id)->first_name . ", 
                        <br> Thanks you for placing the following order <br> 
                         <b>order number</b> : #" . $order_product->id . " <br>
                        <b> Product</b> : " . $order_product->product_title . "<br> 
   
    <b>Quantity</b> :" . $order_product->product_quantity . "<br>
    <b>Product Unit Price</b> :" . price_formatted($order_product->product_unit_price, $order_product->product_currency) . "<br>
    <b>Shipping</b> :" . price_formatted($order_product->product_shipping_cost, $order_product->product_currency) . "<br>. We write to share that seller has accepted the order and it would be dispatched by <b>" . get_product($order_product->product_id)->lead_days . " days </b> to you. We'd like to thank you again for reposing faith in Gharobaar and our supplier partners. We would work hard towards living up to, and if possible exceeding, your expectations. We'd love to hear about your experience of this purchase. Looking forward to hosting you again on Gharobaar. ",


                    );
                    $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
                }
            }
        }

        $this->db->where('id', $id);
        $this->db->update('order_products', $data);
    }
    //order 2 hour window
    public function made_to_order_window($order_product_id)
    {
    }
    //add order shipping
    public function add_order_shipping($order_id)
    {
        $order_id = clean_number($order_id);
        if ($this->cart_model->check_cart_has_physical_product() == true && $this->form_settings->shipping == 1) {
            $shipping_address = $this->cart_model->get_sess_cart_shipping_address();
            $data = array(
                'order_id' => $order_id,
                'shipping_first_name' => $shipping_address->shipping_first_name,
                'shipping_last_name' => $shipping_address->shipping_last_name,
                'shipping_email' => $shipping_address->shipping_email,
                'shipping_phone_number' => $shipping_address->shipping_phone_number,
                'shipping_address_1' => $shipping_address->shipping_address_1,
                // 'shipping_address_2' => $shipping_address->shipping_address_2,
                'shipping_country' => 'India',
                'shipping_state' => $shipping_address->shipping_state,
                'shipping_city' => $shipping_address->shipping_city,
                'shipping_area' => $shipping_address->shipping_area,
                'shipping_landmark' => $shipping_address->shipping_landmark,
                'shipping_zip_code' => $shipping_address->shipping_zip_code,
                'billing_first_name' => $shipping_address->billing_first_name,
                'billing_last_name' => $shipping_address->billing_last_name,
                'billing_email' => $shipping_address->billing_email,
                'billing_phone_number' => $shipping_address->billing_phone_number,
                'billing_address_1' => $shipping_address->billing_address_1,
                //'billing_address_2' => $shipping_address->billing_address_2,
                'billing_country' => 'India',
                'billing_state' => $shipping_address->billing_state,
                'billing_city' => $shipping_address->billing_city,
                'billing_area' => $shipping_address->billing_area,
                'billing_landmark' => $shipping_address->billing_landmark,
                'billing_zip_code' => $shipping_address->billing_zip_code,
                'use_same_address_for_billing' => $shipping_address->use_same_address_for_billing
            );

            $data_state = $this->get_state_code($data["shipping_state"]);
            $data["state_code"] = $data_state->gst_state_code;

            // $country = get_country($shipping_address->shipping_country_id);
            // if (!empty($country)) {
            //     $data["shipping_country"] = $country->name;
            // }
            // $country = get_country($shipping_address->billing_country_id);
            // if (!empty($country)) {
            //     $data["billing_country"] = $country->name;
            // }
            $this->db->insert('order_shipping', $data);
        }
    }

    public function add_order_products($order_id, $order_product_status, $payment_status)
    {
        $order_id = clean_number($order_id);
        $shipping_address = $this->cart_model->get_sess_cart_shipping_address();
        $cart_items = $this->cart_model->get_sess_cart_items();
        $cart_total = $this->cart_model->get_sess_cart_total();
        // var_dump($cart_items);
        // die();
        if (!empty($cart_items)) {
            foreach ($cart_items as $cart_item) {
                $product = get_active_product($cart_item->product_id);
                $seller_address = get_seller($product->user_id);
                $num_days = (int)(($product->lead_days) * 24 * 60 * 60);
                $num_hours = (int)(($product->lead_time) * 60 * 60);
                $total_seconds = ($num_days + $num_hours) * ($cart_item->quantity - 1);
                $variation_option_ids = @serialize($cart_item->options_array);
                if (!empty($product)) {
                    $data = array(
                        'order_id' => $order_id,
                        'seller_id' => $product->user_id,
                        'buyer_id' => 0,
                        'buyer_type' => "guest",
                        'product_id' => $product->id,
                        'product_type' => $product->product_type,
                        'product_title' => $cart_item->product_title,
                        'product_slug' => $product->slug,
                        'hsn_code' => $product->hsn_code,
                        'product_unit_price' => round($cart_item->listing_price / 100) * 100, //product MRP
                        'price_excluded_gst' => ($cart_item->unit_price * $cart_item->quantity) - $cart_item->product_gst,
                        'product_quantity' => $cart_item->quantity,
                        'product_currency' => $cart_item->currency,
                        'product_gst_rate' => $product->gst_rate,
                        'product_gst' => $cart_item->product_gst,
                        'payment_status' => $payment_status,
                        'product_discount_rate' => (float)$cart_item->discount_rate,
                        'product_discount_amount' => (float)$cart_item->discount_amount,
                        'price_after_discount' => $cart_item->unit_price, //product listed price
                        'product_shipping_cost' => $cart_item->shipping_cost,
                        'product_total_price' => $cart_item->unit_price * $cart_item->quantity,
                        'variation_option_ids' => $variation_option_ids,
                        'product_weight' => $cart_item->weight, //product weight
                        'product_delivery_distance' => $cart_item->delivery_distance->value, //distance
                        'product_delivery_partner' => $cart_item->delivery_partner, //delivery partner
                        // 'commission_rate' => $this->general_settings->commission_rate,
                        'commission_rate' => calculate_commission_rate_seller($product->user_id, $product->id),
                        'order_status' => $order_product_status,
                        'is_approved' => 0,
                        'shipping_tracking_number' => "",
                        'shipping_tracking_url' => "",
                        'updated_at' => date('Y-m-d H:i:s'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'additional_info' => $cart_item->additional_info,
                        'product_discount_rate' => $product->discount_rate
                    );
                    $price_shipping = 0;
                    if (check_for_made_to_order($product)) {
                        $data["order_status"] = "waiting";
                        $home_cook = get_parent_categories_tree($product->category_id);
                        if ($home_cook[0]->id == 2) {
                            $transit_time = get_transit_time_for_home_cook($product, "time");
                            $total_lead_time = $this->get_home_cook_lead_time($transit_time, $cart_item->quantity, $product);
                            $data["lead_time"] = $total_lead_time;
                        } else {
                            $transit_time = get_transit_time_for_made_to_order($product, "time");
                            $total_lead_time = (int)$transit_time + $total_seconds;
                            $data["lead_time"] = $total_lead_time;
                        }
                    }
                    if ($seller_address->supplier_state == $shipping_address->shipping_state) {
                        $data['product_igst'] = 0;
                        $data['product_cgst'] = $cart_item->product_gst / 2;
                        $data['product_sgst'] = $cart_item->product_gst / 2;

                        $data['shipping_igst'] = 0;
                        $data['shipping_cgst'] = (0.18 * $price_shipping) / 2;
                        $data['shipping_sgst'] = (0.18 *  $price_shipping) / 2;
                    } else {
                        $data['product_igst'] = $cart_item->product_gst;
                        $data['product_cgst'] = 0;
                        $data['product_sgst'] = 0;
                        $data['shipping_igst'] = (0.18 *  $price_shipping);
                        $data['shipping_cgst'] = 0;
                        $data['shipping_sgst'] = 0;
                    }

                    if ($this->auth_check) {
                        $data["buyer_id"] = $this->auth_user->id;
                        $data["buyer_type"] = "registered";
                    }
                    if (!empty($cart_item->expected_delivery_date)) {
                        $data["expected_delivery_date"] = $cart_item->expected_delivery_date;
                    }
                    if (!empty($cart_item->expected_delivery_time)) {
                        $data["expected_delivery_time"] = $cart_item->expected_delivery_time;
                    }

                    //check for new user
                    if ($this->auth_check && !empty($data["buyer_id"]) && !empty($data["seller_id"])) {
                        $num_user = $this->check_new_user($data["seller_id"], $data["buyer_id"]);
                        if ($num_user == 0) {
                            $data["new_user"] = 1;
                        }
                    }
                    //approve if digital product
                    if ($product->product_type == 'digital') {
                        $data["is_approved"] = 1;

                        if ($order_product_status == 'payment_received') {
                            $data["order_status"] = 'completed';
                        } else {
                            $data["order_status"] = $order_product_status;
                        }
                    }
                    $price_shipping = 0;

                    // $data["product_total_price"] = $cart_item->unit_price + $price_shipping;

                    $this->db->insert('order_products', $data);
                }
                // $this->add_orders_data_seller_wise($order_id);
            }
        }
    }

    //insert data into order_spplier table

    public function add_orders_data_seller_wise($order_id)
    {
        $cart_items = $this->cart_model->get_sess_cart_items();
        $cart_total = $this->cart_model->get_sess_cart_total();

        $Supp_ship_data = json_decode($this->get_seller_wise_data_bifurcation($cart_total));
        // var_dump($Supp_ship_data);
        // die();
        if (!empty($cart_items)) {
            foreach ($cart_items as $cart_item) {
                $product = get_active_product($cart_item->product_id);
                $seller_address = get_seller($product->user_id);
                if (!empty($product)) {
                    $data = array(
                        'order_id' => $order_id,
                        'seller_id' => $product->user_id,
                        'review_type' => "CUSTOM REVIEW",
                        'sup_subtotal' => $product->user_id,
                        'Sup_subtotal_prd_gst' => $product->user_id,
                        'Sup_subtotal_prd_cgst' => $product->user_id,
                        'Sup_subtotal_prd_sgst' => $product->user_id,
                        'Sup_subtotal_prd_igst' => $product->user_id,
                        'Sup_total_prd' => $product->user_id,
                        'sup_shipping_cost' => $product->user_id,
                        'Sup_Shipping_gst' => $product->user_id,
                        'shipping_cgst' => $product->user_id,
                        'shipping_sgst' => $product->user_id,
                        'shipping_igst' => $product->user_id,
                        'total_shipping_cost' => $product->user_id,
                        'Sup_cod_cost' => $product->user_id,
                        'Sup_cod_gst' => $product->user_id,
                        'sup_cod_cgst' => $product->user_id,
                        'sup_cod_sgst' => $product->user_id,
                        'sup_cod_igst' => $product->user_id,
                        'total_cod_cost' => $product->user_id,
                        'shipping_cod_gst_rate' => $product->user_id,
                        'total_discount' => $product->user_id,
                        'grand_total_amount' => $product->user_id,
                        'sup_commission_cost' => $product->user_id,
                        'created_by' => $product->user_id,
                        'updated_by' => $product->user_id
                    );
                    $this->db->insert('order_supplier', $data);
                }
            }
        }
    }


    //returns total lead time in seconds for home cook products
    public function get_home_cook_lead_time($transit, $qty, $product)
    {
        $sale_count = get_sale_count_as_per_incomplete_status($product->id);
        $order_capacity = $product->order_capacity;
        $current_order_capacity = ((int)$sale_count % (int)$order_capacity);
        $current_order_capacity += (int)$qty - 1;
        $current_order_capacity_ratio = (($current_order_capacity) / ($order_capacity));
        $total = (int)($transit) + (86400 * $current_order_capacity_ratio);
        return $total;
    }

    //add digital sales
    public function add_digital_sales($order_id)
    {
        $order_id = clean_number($order_id);
        $cart_items = $this->cart_model->get_sess_cart_items();
        $order = $this->get_order($order_id);
        if (!empty($cart_items) && $this->auth_check && !empty($order)) {
            foreach ($cart_items as $cart_item) {
                $product = get_active_product($cart_item->product_id);
                if (!empty($product) && $product->product_type == 'digital') {
                    $data_digital = array(
                        'order_id' => $order_id,
                        'product_id' => $product->id,
                        'product_title' => get_product_title($product),
                        'seller_id' => $product->user_id,
                        'buyer_id' => $order->buyer_id,
                        'license_key' => '',
                        'purchase_code' => generate_purchase_code(),
                        'currency' => $product->currency,
                        'price' => $product->price,
                        'purchase_date' => date('Y-m-d H:i:s')
                    );

                    $license_key = $this->product_model->get_unused_license_key($product->id);
                    if (!empty($license_key)) {
                        $data_digital['license_key'] = $license_key->license_key;
                    }

                    $this->db->insert('digital_sales', $data_digital);

                    //set license key as used
                    if (!empty($license_key)) {
                        $this->product_model->set_license_key_used($license_key->id);
                    }
                }
            }
        }
    }

    //add digital sale
    public function add_digital_sale($product_id, $order_id)
    {
        $product_id = clean_number($product_id);
        $order_id = clean_number($order_id);
        $product = get_active_product($product_id);
        $order = $this->get_order($order_id);
        if (!empty($product) && $product->product_type == 'digital' && !empty($order)) {
            $data_digital = array(
                'order_id' => $order_id,
                'product_id' => $product->id,
                'product_title' => get_product_title($product),
                'seller_id' => $product->user_id,
                'buyer_id' => $order->buyer_id,
                'license_key' => '',
                'purchase_code' => generate_purchase_code(),
                'currency' => $product->currency,
                'price' => $product->price,
                'purchase_date' => date('Y-m-d H:i:s')
            );

            $license_key = $this->product_model->get_unused_license_key($product->id);
            if (!empty($license_key)) {
                $data_digital['license_key'] = $license_key->license_key;
            }

            $this->db->insert('digital_sales', $data_digital);

            //set license key as used
            if (!empty($license_key)) {
                $this->product_model->set_license_key_used($license_key->id);
            }
        }
    }

    //add digital sales seller earnings
    public function add_digital_sales_seller_earnings($order_id)
    {
        $order_id = clean_number($order_id);
        $order_products = $this->get_order_products($order_id);
        if (!empty($order_products)) {
            foreach ($order_products as $order_product) {
                if ($order_product->product_type == 'digital') {
                    $this->earnings_model->add_seller_earnings($order_product);
                }
            }
        }
    }


    //add payment transaction
    public function add_payment_transaction($data_transaction, $order_id)
    {
        $order_id = clean_number($order_id);
        $data = array(
            'payment_method' => $data_transaction["payment_method"],
            'payment_id' => $data_transaction["payment_id"],
            'order_id' => $order_id,
            'user_id' => 0,
            'user_type' => "guest",
            'currency' => "INR",
            'payment_amount' => $data_transaction["payment_amount"],
            'payment_status' => $data_transaction["payment_status"],
            'ip_address' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'txStatus' => $data_transaction["txStatus"],
            'paymentMode' => $data_transaction["payment_mode"],
            'txMsg' => $data_transaction["txMsg"],
            'txTime' => $data_transaction["txTime"],
            'signature' => $data_transaction["cashfree_signature"],
            'cashfree_order_id' => $data_transaction["cashfree_order_id"],
            'paymentOption' => $data_transaction["paymentOption"],
            'paymentCode' => $data_transaction["paymentCode"],
            'paymentModes' => $data_transaction["paymentModes"]
        );
        if ($this->auth_check) {
            $data["user_id"] = $this->auth_user->id;
            $data["user_type"] = "registered";
        }
        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if ($this->db->insert('transactions', $data)) {
            //add invoice
            $this->add_invoice($order_id);
            $this->update_net_seller_payable($data_transaction["cashfree_order_id"]);
        }
    }

    public function update_net_seller_payable($cashfree_order_id)
    {
        $data = array(
            'is_completed' => "1"
        );
        $this->db->where('cashfree_order_id', $cashfree_order_id);
        $this->db->update('cashfree_seller_payable', $data);
    }

    //add payment transaction in case of failure
    public function add_payment_transaction_fail($data_transaction, $order_id = NULL)
    {
        $order_id = clean_number($order_id);
        $data = array(
            'payment_method' => $data_transaction["payment_method"],
            'payment_id' => $data_transaction["payment_id"],
            'order_id' => $order_id,
            'user_id' => 0,
            'user_type' => "guest",
            'currency' => "INR",
            'payment_amount' => $data_transaction["payment_amount"],
            'payment_status' => $data_transaction["payment_status"],
            'ip_address' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'txStatus' => $data_transaction["txStatus"],
            'paymentMode' => $data_transaction["payment_mode"],
            'txMsg' => $data_transaction["txMsg"],
            'txTime' => $data_transaction["txTime"],
            'signature' => $data_transaction["cashfree_signature"],
            'cashfree_order_id' => $data_transaction["cashfree_order_id"]
        );
        if ($this->auth_check) {
            $data["user_id"] = $this->auth_user->id;
            $data["user_type"] = "registered";
        }
        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        $this->db->insert('transactions', $data);
    }


    //update order payment as received
    public function update_order_payment_received($order_id)
    {
        if (!empty($order)) {
            //update product payment status
            $data_order = array(
                'payment_status' => "payment_received",
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $this->db->where('id', $order_id);
            if ($this->db->update('orders', $data_order)) {
                //update order products payment status
                $order_products = $this->get_order_products($order_id);
                if (!empty($order_products)) {
                    foreach ($order_products as $order_product) {
                        $data = array(
                            'order_status' => "payment_received",
                            'updated_at' => date('Y-m-d H:i:s'),
                        );
                        $this->db->where('id', $order_product->id);
                        $this->db->update('order_products', $data);
                    }
                }

                //add invoice
                $this->add_invoice($order_id);
            }
        }
    }

    //get orders count
    public function get_orders_count($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->where('buyer_id', $user_id);
        $this->db->where('status', 0);
        $query = $this->db->get('orders');
        return $query->num_rows();
    }

    //get orders count
    public function get_order_products_count($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->where('buyer_id', $user_id);
        // $this->db->where('order_status!=', 'completed');
        $query = $this->db->get('order_products');
        return $query->num_rows();
    }


    public function send_order_text($phn_num, $label_content, $order_no)
    {
        $label_content = $label_content;
        $order_no = $order_no;
        // Authorisation details.
        $username = "chirag.raut@austere.co.in";
        $hash = "495947f08983f416aa4556991fb67b2f2642e45e";

        // Config variables. Consult http://api.textlocal.in/docs for more info.
        $test = "0";

        // Data for text message. This is the text message data.
        $sender = "GHRBAR"; // This is who the message appears to be from.
        $numbers = "$phn_num"; // A single number or a comma-seperated list of numbers
        $otp = rand(100000, 999999);

        $_SESSION['LAST_ACTIVITY'] = time();
        $_SESSION['session_otp'] = $otp;

        $msg_content = get_content($label_content);

        //replace template var with value

        $token = array(
            'order_no' => $order_no
        );

        $pattern = '[%s]';
        foreach ($token as $key => $val) {
            $varMap[sprintf($pattern, $key)] = $val;
        }

        $message = strtr($msg_content, $varMap);
        $data = "username=" . ($username) . "&hash=" . ($hash) . "&message=" . $message . "&sender=" . $sender . "&numbers=" . $numbers . "&test=" . $test;

        $ch = curl_init('http://api.textlocal.in/send/?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); // This is the result from the API

        curl_close($ch);

        // var_dump($result);
        $data = array(
            'html_content1' => "",
            'order_no' => $order_no,
            'message' => $message
        );

        echo json_encode($data);
    }

    //get paginated orders
    public function get_paginated_orders($user_id, $per_page, $offset)
    {
        $user_id = clean_number($user_id);
        $this->db->where('buyer_id', $user_id);
        $this->db->where('status', 0);
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }

    public function get_order_product_seller_id($seller_id, $order_id)
    {
        $seller_id = clean_number($seller_id);
        $this->db->where('seller_id', $seller_id);
        $this->db->where('order_id', $order_id);

        $query = $this->db->get('order_products');
        return $query->result();
    }

    //get paginated orders
    public function get_paginated_order_products($user_id, $per_page, $offset)
    {
        $user_id = clean_number($user_id);
        $this->db->where('buyer_id', $user_id);
        // $this->db->where('order_status!=', 'completed');
        $this->db->order_by('order_products.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('order_products');
        return $query->result();
    }

    //get completed orders count
    public function get_completed_orders_count($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->where('buyer_id', $user_id);
        $this->db->where('status', 1);
        $query = $this->db->get('orders');
        return $query->num_rows();
    }


    //get completed orders count
    public function get_completed_order_products_count($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->where('buyer_id', $user_id);
        $this->db->where('order_status', 'completed');
        $query = $this->db->get('order_products');
        return $query->num_rows();
    }

    //get paginated completed orders
    public function get_paginated_completed_orders($user_id, $per_page, $offset)
    {
        $user_id = clean_number($user_id);
        $this->db->where('buyer_id', $user_id);
        $this->db->where('status', 1);
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }
    //get paginated completed orders
    public function get_paginated_completed_order_products($user_id, $per_page, $offset)
    {
        $user_id = clean_number($user_id);
        $this->db->where('buyer_id', $user_id);
        $this->db->where('order_status', 'completed');
        $this->db->order_by('order_products.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('order_products');
        return $query->result();
    }

    //get order products
    public function get_order_products($order_id)
    {
        $order_id = clean_number($order_id);
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('order_products');
        return $query->result();
    }
    public function input_values()
    {
        $data = array(
            'shiprocket_shipping_id' => $this->input->post('shipment_id', true)
        );
        return $data;
    }
    //shiprocket-response

    public function shiprocket_response()
    {

        //$order_product_ids = $this->input->post('order_product_ids', true);
        $product_ids = $this->input->post('product_id', true);
        //var_dump(count($product_ids));

        for ($j = 0; $j < count($product_ids); $j++) {
            $data = array(
                'order_id' => trim($this->input->post('order_id', true)),
                'product_id' => $product_ids[$j],
                'reference_order_id' => $this->input->post('reference_order_id', true),
                'shipment_order_id' => trim($this->input->post('shipment_order_id', true)),
                'shipment_id' => trim($this->input->post('shipment_id', true)),
                'awb_code' => trim($this->input->post('awb_code', true)),
                'pickup_scheduled_date' => trim($this->input->post('pickup_scheduled_date', true)),
                'manifest_url' => trim($this->input->post('manifest_url', true)),
                'label_url' => trim($this->input->post('label_url', true)),
                'courier_company_name' => trim($this->input->post('courier_company_name', true)),
                'courier_company_id' => trim($this->input->post('courier_company_id', true)),
                'applied_weight' => trim($this->input->post('applied_weight', true)),
                'pickup_token_number' => trim($this->input->post('pickup_token_number', true)),
                'COD' => trim($this->input->post('COD', true)),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")


            );
            if ($this->auth_check) {

                $data['created_by'] = $this->auth_user->id;
                $data['updated_by'] = $this->auth_user->id;
            } else {
                if (empty($data['created_by'])) {
                    return false;
                }
            }
            $this->db->insert('shiprocket_order_details', $data);
            $this->update_shiprocket_status($data["order_id"], $product_ids[$j]);
        }

        // for ($i = 0; $i < count($product_ids); $i++) {


        // }
    }


    public function update_shiprocket_status($order_id, $product_id)
    {
        // var_dump("hello");
        // die();
        $order_status = array(
            'order_status' => 'awaiting_pickup'
        );

        $this->db->where('order_id', $order_id);
        $this->db->where('product_id', $product_id);

        $this->db->update('order_products', $order_status);
    }
    public function get_shipment_id($order_id)
    {

        $data = $this->order_model->input_values();
        $this->db->where('order_id', $order_id);
        $this->db->update('order_products', $data);
    }

    //get seller order products
    public function get_seller_order_products($order_id, $seller_id)
    {
        $this->db->where('order_id', clean_number($order_id));
        $this->db->where('seller_id', clean_number($seller_id));
        $query = $this->db->get('order_products');
        return $query->result();
    }

    //get order product
    public function get_order_product($order_product_id)
    {
        $this->db->where('id', clean_number($order_product_id));
        $query = $this->db->get('order_products');
        return $query->row();
    }

    public function get_order_product_by_orderid($order_product_id)
    {
        $this->db->where('order_id', clean_number($order_product_id));
        $query = $this->db->get('order_products');
        return $query->row();
    }

    public function get_order_products_by_orderid($order_id)
    {
        $this->db->where('order_id', clean_number($order_id));
        $query = $this->db->get('order_products');
        return $query->result();
    }
    //get order
    public function get_order($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('orders');
        return $query->row();
    }

    //get order by order number
    public function get_order_by_order_number($order_number)
    {
        $this->db->where('order_number', clean_number($order_number));
        $query = $this->db->get('orders');
        return $query->row();
    }

    //update order product status
    public function update_order_product_status($order_product_id, $reject_reason_comment)
    {
        $order_product_id = clean_number($order_product_id);
        $order_product = $this->get_order_product($order_product_id);
        $reject_reason_comment = $reject_reason_comment;
        $order_item_product_id = $order_product->product_id;
        $order_id = $order_product->order_id;
        if (!empty($order_product)) {
            if ($order_product->seller_id == $this->auth_user->id) {
                $data = array(
                    'order_status' => $this->input->post('order_status', true),
                    'reject_reason' => $this->input->post('reject_reason', true),
                    'reject_reason_comment' => $reject_reason_comment,
                    'is_approved' => 0,
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                if ($order_product->product_type == 'digital' && $data["order_status"] == 'payment_received') {
                    $data['order_status'] = 'completed';
                }

                if ($data["order_status"] == 'shipped') {
                    //send email
                    if ($this->general_settings->send_email_order_shipped == 1) {
                        $email_data = array(
                            'email_type' => 'order_shipped',
                            'order_product_id' => $order_product->id
                        );
                        $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
                    }
                }
                if ($data["order_status"] == 'rejected' || $data["order_status"] == 'cancelled_by_user' || $data["order_status"] == 'cancelled_by_seller') {
                    //send email
                    if (get_product($order_product->product_id)->add_meet == "Made to stock") {
                        if ($this->general_settings->send_email_order_shipped == 1) {
                            $email_data = array(
                                'email_type' => 'email_general',
                                'to' => get_user($order_product->buyer_id)->email,
                                'subject' => "Your order has been cancelled by Supplier",
                                'email_content' => "Dear " . ucfirst(get_user($order_product->buyer_id)->first_name) . ", 
                             <br> We apologise for the cancellation made by the seller for the Order. <br> 
                             This is an exception and has happened because the seller did not update the available stock details on the platform. We have taken up the issue with the seller, and would try our best to improve your experience on Gharobaar. We shall process the refund within 7 business days. We once again express our regret for the incovenience caused.
                             <br>
                             <b>Order Details</b>
                             <b>order number</b> : #" . get_order($order_product->order_id)->order_number . " <br>
                            <b> Product</b> : " . $order_product->product_title . "<br> 
       
                             <b>Quantity</b> :" . $order_product->product_quantity . "<br>
                             <b>Product Unit Price</b> :" . price_formatted($order_product->product_unit_price, $order_product->product_currency) . "<br><br>Team Gharobaar"

                            );
                            $this->session->set_userdata('mds_send_email_data', json_encode($email_data));

                            $message = "Dear " . ucfirst(get_user($order_product->seller_id)->first_name) . ", 
                        <br> We understand that you have cancelled the Order.<br>
                        The customer placed the order based on the stock details provided by you on the product page, and your inability to service the order due to stock unavailability has been communicated to the buyer. We are sure that you understand that this is not the experience that we'd like to provide to our buyers, not to mention that its not aligned with our values of customer centricity. With a heavy heart we'd like to inform you that a deduction of <b>INR " . $this->penalty_calculate($order_product->id) . "</b> shall be made from your next pay-out and the same amount shall be offered as a redeemable coupon to the buyer. You are also aware that our performance management program for the partners stresses heavily on timely and complete serviceability of orders, request you to manintain the performance to enjoy the benefits offered by the program. Please let us know if the cancelation is done for any other reason. Looking forward to your continued support.
                        <br>
                        <b>Order Details</b>
                        <b>order number</b> : #" . get_order($order_product->order_id)->order_number . " <br>
                        <b> Product</b> : " . $order_product->product_title . "<br> 
   
                        <b>Quantity</b> :" . $order_product->product_quantity . "<br>
                        <b>Product Unit Price</b> :" . price_formatted($order_product->product_unit_price, $order_product->product_currency) . "<br><br>Team Gharobaar";


                            $email_data1 = array(
                                'email_type' => 'email_general',
                                'to' => get_user($order_product->seller_id)->email,
                                'subject' => "Order Cancel",
                                'email_content' => $message
                            );
                            $this->session->set_userdata('mds_send_email_data_seller', json_encode($email_data1));
                        }
                    } else if (get_product($order_product->product_id)->add_meet == "Made to order") {
                        if ($this->general_settings->send_email_order_shipped == 1) {
                            $email_data = array(
                                'email_type' => 'email_general',
                                'to' => get_user($order_product->buyer_id)->email,
                                'subject' => "Your order has been cancelled by Supplier",
                                'email_content' => "Dear " . ucfirst(get_user($order_product->buyer_id)->first_name) . ", 
                             <br> We apologise for the cancellation made by the seller for the order<br> 
                             We'd like to share again with you that the suppliers are small scale homeprenuers who are making these products at home with limited means, hence we give them an option to accept/ reject the order, after ascertaining their ability to service it. We dont want a scenario wherein they're not able to service an order after accepting it. This is also in line with our philosophy of encouraging convenient and comfortable working for homeprenuers. We shall process the refund within 7 business days. We once again express our regret for not providing you an ideal experience and the incovenience caused. 
                             <br>
                             <b>Order Details</b>
                             <b>order number</b> : #" . get_order($order_product->order_id)->order_number . " <br>
                             <b> Product</b> : " . $order_product->product_title . "<br> 
       
                             <b>Quantity</b> :" . $order_product->product_quantity . "<br>
                             <b>Product Unit Price</b> :" . price_formatted($order_product->product_unit_price, $order_product->product_currency) . "<br><br>Team Gharobaar"


                            );
                            $this->session->set_userdata('mds_send_email_data', json_encode($email_data));

                            $message = "Dear " . ucfirst(get_user($order_product->seller_id)->first_name) . ", 
                            <br> We understand that you have cancelled the Order.  <br> 
                            As a platform designed for homeprenuers, we encourage prioritising life over money, and we are sure that you have cancelled the order as it was in conflict with some other important engagement. You would have seen the options of <b>'Open Shop'</b> and <b>'Close Shop'</b> on the supplier panel, if you think that your servicability could be challenged owing to personal engagement or bandwidth issue, please keep the shop closed, so that the buyers dont end up placing orders. Despite our open and transparent communication, cancelations usually are not received well by buyers, 'Close Shop' option addresses the risk of buyer disengagement. We have informed the buyer about the cancelation and has recommended other suppliers of similar products. Please let us know if the cancelation is done for a reason on which you may require our support. Looking forward to your continued support.
                            <b>order number</b> : #" . get_order($order_product->order_id)->order_number . " <br>
                            <b> Product</b> : " . $order_product->product_title . "<br> 
   
                            <b>Quantity</b> :" . $order_product->product_quantity . "<br>
                            <b>Product Unit Price</b> :" . price_formatted($order_product->product_unit_price, $order_product->product_currency) . "<br><br>Team Gharobaar";


                            $email_data1 = array(
                                'email_type' => 'email_general',
                                'to' => get_user($order_product->seller_id)->email,
                                'subject' => "Order Cancel",
                                'email_content' => $message
                            );
                            $this->session->set_userdata('mds_send_email_data_seller', json_encode($email_data1));
                        }
                    }
                    $this->increase_product_stock_after_cancel($order_id, $order_item_product_id);
                }
                $this->db->where('id', $order_product_id);
                return $this->db->update('order_products', $data);
            }
        }
        return false;
    }

    public function penalty_calculate($order_product_table_id)
    {
        $order_product_table_id = clean_number($order_product_table_id);
        $order_product = $this->order_model->get_order_product($order_product_table_id);
        $order_id = $order_product->order_id;
        $product_id = $order_product->product_id;
        $seller_id = $order_product->seller_id;
        $order_created_at = $order_product->created_at;
        $product_shipping_cost = $order_product->product_shipping_cost;
        $commission_rate = $order_product->commission_rate;
        $total_amount_with_quantity = $order_product->product_total_price;
        // get product detail from product table
        $product = $this->order_model->get_product_detail($product_id);
        // $product_price_excluding_gst = $product[0]->price_exclude_gst;

        // check if product is made to stock or made to order
        $product_type = $product[0]->add_meet;
        $product_price_after_discount = $order_product->price_after_discount;
        $product_gst_rate = $order_product->product_gst_rate;
        $gst_cal = 1 + ($product_gst_rate / 100);
        $product_price_excluding_gst = round($product_price_after_discount / $gst_cal, 0);

        $quantity = $order_product->product_quantity;
        $user_id = $this->auth_user->id;
        $created_date = date('Y-m-d', strtotime($order_created_at));

        // get detail from lookup table
        $lookup_table_data = $this->order_model->get_product_shipping_days_from_db($product[0]->shipping_time);
        $estimated_days = $lookup_table_data->lookup_int_val;
        // $estimated_dispatch_date = date('Y-m-d', strtotime($created_date . +$estimated_days . "days"));
        $cancel_date = date("Y-m-d H:i:s");
        $amount = $product_price_excluding_gst / 100;
        $commission = $commission_rate / 100;
        $commission_amount_without_round = $amount * $commission;
        $commission_amount = round($commission_amount_without_round, 2);
        $gst_on_commission_amount = 0.18 * $commission_amount;
        $penalty_amount_with_gst = $commission_amount + $gst_on_commission_amount;
        $penalty_amount_with_gst_and_quantity = $penalty_amount_with_gst * $quantity;

        // check estimated date of dispatch according to product add meet
        if ($product_type == 'Made to order') {
            $lead_time_in_sec = $order_product->lead_time;
            $order_accepted_at = $order_product->accepted_at;
            $accepted_at_in_sec = strtotime($order_accepted_at);

            $total_estimated_dispatch_in_sec = $accepted_at_in_sec + $lead_time_in_sec;
            $estimated_dispatch_date = date('Y-m-d H:i:s', $total_estimated_dispatch_in_sec);
        } elseif ($product_type == 'Made to stock') {
            $estimated_dispatch_date = date('Y-m-d H:i:s', strtotime($created_date . +$estimated_days . "days"));
        }

        // 100% penalty case before dispatch date
        if ($estimated_dispatch_date >= $cancel_date) {
            $penalty_amount = round($penalty_amount_with_gst_and_quantity, 2);
            echo "100% penalty case before dispatch date";
        } else {
            $penalty_amount_after_dispatch = 1.5 * $penalty_amount_with_gst_and_quantity;
            $penalty_amount = round($penalty_amount_after_dispatch, 2);
            // $penalty_amount=round($penalty_amount_after_dispatch+$gst_on_penalty_amount_after_dispatch);
            echo "150% penalty case after dispatch date";
        }


        return $penalty_amount;
    }

    //add shipping tracking number
    public function add_shipping_tracking_number($order_product_id)
    {
        $order_product_id = clean_number($order_product_id);
        $order_product = $this->get_order_product($order_product_id);
        if (!empty($order_product)) {
            if ($order_product->seller_id == $this->auth_user->id) {
                $data = array(
                    'shipping_tracking_number' => $this->input->post('shipping_tracking_number', true),
                    'self_courier_service' => $this->input->post('courier_service', true),
                    'order_status' => 'shipped',
                    'shipping_tracking_url' => $this->input->post('shipping_tracking_url', true),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $this->db->where('id', $order_product_id);
                return $this->db->update('order_products', $data);
            }
        }
        return false;
    }

    //add bank transfer payment report
    public function add_bank_transfer_payment_report()
    {
        $data = array(
            'order_number' => $this->input->post('order_number', true),
            'payment_note' => $this->input->post('payment_note', true),
            'receipt_path' => "",
            'user_id' => 0,
            'user_type' => "guest",
            'status' => "pending",
            'ip_address' => 0,
            'created_at' => date('Y-m-d H:i:s')
        );
        if ($this->auth_check) {
            $data["user_id"] = $this->auth_user->id;
            $data["user_type"] = "registered";
        }
        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }

        $this->load->model('upload_model');
        $file_path = $this->upload_model->receipt_upload('file');
        if (!empty($file_path)) {
            $data["receipt_path"] = $file_path;
        }

        return $this->db->insert('bank_transfers', $data);
    }

    //get sales count
    public function get_sales_count($user_id)
    {
        $this->filter_sales();
        $user_id = clean_number($user_id);
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.id');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', $user_id);
        $this->db->where('order_products.order_status !=', 'completed');
        $this->filter_sales();
        $query = $this->db->get('orders');
        return $query->num_rows();
    }

    //get paginated sales
    public function get_paginated_sales($user_id, $per_page, $offset)
    {
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.*');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->where('order_products.order_status !=', 'completed');
        $this->db->where('order_products.order_status !=', 'rejected');
        $this->db->where('order_products.order_status !=', 'cancelled_by_user');
        $this->filter_sales();
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }

    //get pending sales count
    public function get_pending_sales_count($user_id)
    {
        $this->filter_sales();
        $user_id = clean_number($user_id);
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.*');
        $this->db->group_by('orders.id');
        // $this->db->where('order_products.seller_id', clean_number($user_id));
        $where = "((`order_products`.`seller_id` = " . clean_number($user_id) . ") AND (`order_status`='processing' OR `order_status`='waiting'))";
        $this->db->where($where);
        $this->filter_sales();
        $query = $this->db->get('orders');
        return $query->num_rows();
    }

    //get paginated pending sales
    public function get_paginated_pending_sales($user_id, $per_page, $offset)
    {
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.*');
        $this->db->group_by('orders.id');
        // $this->db->where('order_products.seller_id', clean_number($user_id));
        $where = "((`order_products`.`seller_id` = " . clean_number($user_id) . ") AND (`order_status`='processing' OR `order_status`='waiting'))";
        $this->db->where($where);
        $this->filter_sales();
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }

    //get completed sales count
    public function get_completed_sales_count($user_id)
    {
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.id');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->where('order_products.order_status', 'completed');
        $this->filter_sales();
        $query = $this->db->get('orders');
        return $query->num_rows();
    }


    //get rejected sales count
    public function get_rejected_sales_count($user_id)
    {
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.id');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->where('order_products.order_status', 'rejected');
        $this->filter_sales();
        $query = $this->db->get('orders');
        return $query->num_rows();
    }

    //get awaiting_pickup sales count
    public function get_awaiting_pickup_sales_count($user_id)
    {
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.id');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->where('order_products.order_status', 'awaiting_pickup');
        $this->filter_sales();
        $query = $this->db->get('orders');
        return $query->num_rows();
    }



    //get shipped sales count
    public function get_shipped_sales_count($user_id)
    {
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.id');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->where('order_products.order_status', 'shipped');
        $this->filter_sales();
        $query = $this->db->get('orders');
        return $query->num_rows();
    }

    public function get_accepted_sales_count($user_id)
    {
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.id');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->where('order_products.order_status', 'processing');
        $this->filter_sales();
        $query = $this->db->get('orders');
        return $query->num_rows();
    }


    //get rejected sales count
    public function get_cancelled_by_user_count($user_id)
    {
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.id');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->where('order_products.order_status', 'cancelled_by_user');
        $this->filter_sales();
        $query = $this->db->get('orders');
        return $query->num_rows();
    }


    //get cancelled bu seller sales count
    public function get_cancelled_by_seller_count($user_id)
    {
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.id');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->where('order_products.order_status', 'cancelled_by_seller');
        $this->filter_sales();
        $query = $this->db->get('orders');
        return $query->num_rows();
    }



    //get paginated completed sales
    public function get_paginated_completed_sales($user_id, $per_page, $offset)
    {
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.*');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->where('order_products.order_status', 'completed');
        $this->filter_sales();
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }



    //get paginated rejected sales
    public function get_paginated_rejected_sales($user_id, $per_page, $offset)
    {
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.*');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->where('order_products.order_status', 'rejected');
        $this->filter_sales();
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }

    //get paginated awaiting_pickup sales
    public function get_paginated_awaiting_pickup_sales($user_id, $per_page, $offset)
    {
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.*');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->where('order_products.order_status', 'awaiting_pickup');
        $this->filter_sales();
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }


    //get paginated shipped sales
    public function get_paginated_shipped_sales($user_id, $per_page, $offset)
    {
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.*');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->where('order_products.order_status', 'shipped');
        $this->filter_sales();
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }


    //get paginated cancelled_by_user sales
    public function get_paginated_cancelled_by_user($user_id, $per_page, $offset)
    {
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.*');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->where('order_products.order_status', 'cancelled_by_user');
        $this->filter_sales();
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }


    //get paginated cancelled_by_seller sales
    public function get_paginated_cancelled_by_seller($user_id, $per_page, $offset)
    {
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.*');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->where('order_products.order_status', 'cancelled_by_seller');
        $this->filter_sales();
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
        return $query->result();
    }


    //get limited sales by seller
    public function get_limited_sales_by_seller($user_id, $limit)
    {
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.*');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('orders');
        return $query->result();
    }

    //filter sales
    public function filter_sales()
    {
        $payment_status = str_slug($this->input->get('payment_status', true));
        $q = str_slug($this->input->get('q', true));

        if (!empty($payment_status) && ($payment_status == "payment_received" || $payment_status == "awaiting_payment")) {
            $this->db->where('orders.payment_status', $payment_status);
        }
        if (!empty($q)) {
            $this->db->where('orders.order_number', $q);
        }
    }

    //get order shipping
    public function get_order_shipping($order_id)
    {
        $order_id = clean_number($order_id);
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('order_shipping');
        return $query->row();
    }

    //check order seller
    public function check_order_seller($order_id)
    {
        $order_id = clean_number($order_id);
        $order_products = $this->get_order_products($order_id);
        $result = false;
        if (!empty($order_products)) {
            foreach ($order_products as $product) {
                if ($product->seller_id == $this->auth_user->id) {
                    $result = true;
                }
            }
        }
        return $result;
    }

    //get seller total price
    public function get_seller_total_price($order_id)
    {
        $order_id = clean_number($order_id);
        $order_products = $this->get_order_products($order_id);
        $total = 0;
        if (!empty($order_products)) {
            foreach ($order_products as $product) {
                if ($product->seller_id == $this->auth_user->id) {
                    $total += $product->product_total_price;
                }
            }
        }
        return $total;
    }

    //approve order product
    public function approve_order_product($order_product_id)
    {
        $order_product_id = clean_number($order_product_id);
        $order_product = $this->get_order_product($order_product_id);

        if (!empty($order_product)) {
            if ($this->auth_user->id == $order_product->buyer_id) {
                $data = array(
                    'is_approved' => 1,
                    'order_status' => "completed",
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $this->db->where('id', $order_product_id);
                return $this->db->update('order_products', $data);
            }
        }

        return false;
    }


    //approve order product
    public function cancel_order_product($order_product_id, $reject_reason, $reject_reason_comment1)
    {
        $order_product_id = clean_number($order_product_id);
        $order_product = $this->get_order_product($order_product_id);
        $reject_reason_comment1 = $reject_reason_comment1;
        $ordered_item_quantity = $order_product->product_quantity;
        $order_item_product_id = $order_product->product_id;
        $order_id = $order_product->order_id;
        $product_actual_stock = get_product($order_item_product_id)->stock;
        $reject_reason = $reject_reason;

        if (!empty($order_product)) {
            if ($this->auth_user->id == $order_product->buyer_id) {
                $data = array(
                    // 'is_approved' => 1,
                    'order_status' => "cancelled_by_user",
                    'updated_at' => date('Y-m-d H:i:s'),
                    'reject_reason' => $reject_reason,
                    'reject_reason_comment' => $reject_reason_comment1
                );
                $this->increase_product_stock_after_cancel($order_id, $order_item_product_id);
                $this->db->where('id', $order_product_id);
                $this->db->update('order_products', $data);
                return true;
            }
        }

        return false;
    }





    //decrease product stock after sale
    public function decrease_product_stock_after_sale($order_id)
    {
        $order_products = $this->get_order_products($order_id);
        if (!empty($order_products)) {
            foreach ($order_products as $order_product) {

                $option_ids = unserialize_data($order_product->variation_option_ids);
                if (!empty($option_ids)) {
                    foreach ($option_ids as $option_id) {
                        $option = $this->variation_model->get_variation_option($option_id);
                        if (!empty($option)) {
                            if ($option->is_default == 1) {
                                $product = $this->product_model->get_product_by_id($order_product->product_id);
                                if (!empty($product)) {
                                    if ($product->add_meet == "Made to stock") {
                                        $stock = $product->stock - $order_product->product_quantity;
                                        if ($stock < 0) {
                                            $stock = 0;
                                        }
                                        $data = array(
                                            'stock' => $stock
                                        );
                                        $this->db->where('id', $product->id);
                                        $this->db->update('products', $data);
                                    }
                                }
                            } else {
                                $product = $this->product_model->get_product_by_id($order_product->product_id);
                                if ($product->add_meet == "Made to stock") {
                                    $stock = $option->stock - $order_product->product_quantity;
                                    if ($stock < 0) {
                                        $stock = 0;
                                    }
                                    $data = array(
                                        'stock' => $stock
                                    );
                                    $this->db->where('id', $option->id);
                                    $this->db->update('variation_options', $data);
                                }
                            }
                        }
                    }
                } else {
                    $product = $this->product_model->get_product_by_id($order_product->product_id);
                    if (!empty($product)) {
                        if ($product->add_meet == "Made to stock") {
                            $stock = $product->stock - $order_product->product_quantity;
                            if ($stock < 0) {
                                $stock = 0;
                            }
                            $data = array(
                                'stock' => $stock
                            );
                            $this->db->where('id', $product->id);
                            $this->db->update('products', $data);
                        }
                    }
                }
            }
        }
    }





    //increase product stock after cancel
    public function increase_product_stock_after_cancel($order_id, $order_product_id)
    {
        $order_products = $this->get_order_products($order_id);
        if (!empty($order_products)) {
            foreach ($order_products as $order_product) {
                if ($order_product->product_id == $order_product_id) {

                    $option_ids = unserialize_data($order_product->variation_option_ids);
                    if (!empty($option_ids)) {
                        foreach ($option_ids as $option_id) {
                            $option = $this->variation_model->get_variation_option($option_id);
                            if (!empty($option)) {
                                if ($option->is_default == 1) {
                                    $product = $this->product_model->get_product_by_id($order_product->product_id);
                                    if (!empty($product)) {
                                        if ($product->add_meet == "Made to stock") {
                                            $stock = $product->stock + $order_product->product_quantity;
                                            if ($stock < 0) {
                                                $stock = 0;
                                            }
                                            $data = array(
                                                'stock' => $stock
                                            );
                                            $this->db->where('id', $product->id);
                                            $this->db->update('products', $data);
                                        }
                                    }
                                } else {
                                    $stock = $option->stock + $order_product->product_quantity;
                                    if ($stock < 0) {
                                        $stock = 0;
                                    }
                                    $data = array(
                                        'stock' => $stock
                                    );
                                    $this->db->where('id', $option->id);
                                    $this->db->update('variation_options', $data);
                                }
                            }
                        }
                    } else {
                        $product = $this->product_model->get_product_by_id($order_product->product_id);
                        if (!empty($product)) {
                            $stock = $product->stock + $order_product->product_quantity;
                            if ($stock < 0) {
                                $stock = 0;
                            }
                            $data = array(
                                'stock' => $stock
                            );
                            $this->db->where('id', $product->id);
                            $this->db->update('products', $data);
                        }
                    }
                }
            }
        }
    }




    //add invoice
    public function add_invoice($order_id)
    {
        $order = $this->get_order($order_id);
        if (!empty($order)) {
            $invoice = $this->get_invoice_by_order_number($order->order_number);
            if (empty($invoice)) {
                $client = get_user($order->buyer_id);
                if (!empty($client)) {
                    $invoice_items = array();
                    $order_products = $this->order_model->get_order_products($order_id);
                    if (!empty($order_products)) {
                        foreach ($order_products as $order_product) {
                            $seller = get_user($order_product->seller_id);
                            $item = array(
                                'id' => $order_product->id,
                                'seller_id' => !empty($seller) ? ($seller->id) : "",
                                'client_id' => !empty($client) ? ($client->id) : "",
                                'seller' => !empty($seller) ? get_shop_name($seller) : "",
                                'shipping_charges' => $order_product->product_shipping_cost,
                                'cod_charges' => $order_product->product_cod_charges,
                                'taxes' => $order_product->product_tax_charges,
                                'total_discount' => $order_product->product_discount_amount,
                                'sub_total' => $order_product->product_total_price

                            );
                            $item["total_amount"] = $item["cod_charges"] + $item["taxes"] + $item["sub_total"];
                            array_push($invoice_items, $item);
                        }
                    }
                    $new_invoice_items = array();
                    foreach ($invoice_items as $dt) {
                        $new = true;
                        for ($i = 0; $i < count($new_invoice_items); $i++) {
                            if ($new_invoice_items[$i]["seller_id"] == $dt["seller_id"]) {
                                $new_invoice_items[$i]["total_discount"] += $dt["total_discount"];
                                $new_invoice_items[$i]["sub_total"] += $dt["sub_total"];
                                $new_invoice_items[$i]["total_amount"] += $dt["total_amount"];
                                $new = false;
                            }
                        }
                        // foreach ($new_invoice_items as $ndt) {
                        //     if ($ndt["seller_id"] == $dt["seller_id"]) {
                        //         $ndt["total_discount"] += $ndt["total_discount"];
                        //         $ndt["sub_total"] += $ndt["sub_total"];
                        //         $ndt["total_amount"] += $ndt["total_amount"];
                        //         $new = false;
                        //     }
                        // }
                        if ($new) {
                            array_push($new_invoice_items, $dt);
                        }
                    }
                    $country = get_country($client->country_id);
                    $state = get_state($client->state_id);
                    $city = get_city($client->city_id);

                    foreach ($new_invoice_items as $new_item) {
                        $data = array(
                            'order_id' => $order->id,
                            'seller_id' => $new_item["seller_id"],
                            'client_id' => $new_item["client_id"],
                            'order_number' => $order->order_number,
                            'client_username' => $client->username,
                            'client_first_name' => $client->first_name,
                            'client_last_name' => $client->last_name,
                            'client_email' => $client->email,
                            'client_phone_number' => $client->phone_number,
                            'client_address' => $client->address,

                            // 'client_area' => $client->area,
                            // 'client_zipcode' => $client->zipcode,
                            // 'client_country' => !empty($country) ? $country->name : '',
                            // 'client_state' => !empty($state) ? $state->name : '',
                            // 'client_city' => !empty($city) ? $city->name : '',

                            'invoice_items' => @serialize($invoice_items),
                            'shipping_charges' => $new_item["shipping_charges"],
                            'cod_charges' => $new_item["cod_charges"],
                            'taxes' => $new_item["taxes"],
                            'total_discount' => $new_item["total_discount"],
                            'sub_total' => $new_item["sub_total"],
                            'total_amount' => $new_item["total_amount"],
                            'created_at' => date('Y-m-d H:i:s')
                        );
                        $order_shipping = $this->get_order_shipping($order->id);
                        if (!empty($order_shipping)) {
                            $data['client_first_name'] = $order_shipping->billing_first_name;
                            $data['client_last_name'] = $order_shipping->billing_last_name;
                            $data['client_email'] = $order_shipping->billing_email;
                            $data['client_phone_number'] = $order_shipping->billing_phone_number;
                            $data['client_address'] = $order_shipping->billing_address_1;
                            $data['client_area'] = $order_shipping->billing_area;
                            $data['client_zipcode'] = $order_shipping->billing_zip_code;
                            $data['client_country'] = $order_shipping->billing_country;
                            $data['client_state'] = $order_shipping->billing_state;
                            $data['client_city'] = $order_shipping->billing_city;
                        }
                        $this->db->insert('invoices', $data);
                    }
                }
            }
        }
        return false;
    }

    //get invoice
    public function get_invoice($id)
    {
        $this->db->where('id', clean_number($id));
        $query = $this->db->get('invoices');
        return $query->row();
    }

    //get invoice by order number
    public function get_invoice_by_order_number($order_number)
    {
        $this->db->where('order_number', clean_number($order_number));
        $query = $this->db->get('invoices');
        return $query->row();
    }

    //get invoice by order number
    public function get_invoice_by_order_id($order_number)
    {
        $this->db->where('order_id', clean_number($order_number));
        $query = $this->db->get('invoices');
        return $query->row();
    }
    //check new user for seller
    public function check_new_user($seller_id, $buyer_id)
    {
        $this->db->where('seller_id', $seller_id);
        $this->db->where('buyer_id', $buyer_id);
        $query = $this->db->get('order_products');
        return $query->num_rows();
    }


    public function get_last_week_customer_data($seller_id)
    {
        $new_customer_per_day = array();
        // $query = $this->db->query("select DATE(created_at) as created_date,DAYNAME(created_at) as created_day, count(order_id) as new_user FROM `Gharobar`.v_new_customers where created_at BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE() and new_user=1 and seller_id=27 group by created_day");
        $query = $this->db->query("select DATE(created_at) as created_date,DAYNAME(created_at) as created_day, count(order_id) as new_user FROM `gharobar-view`.v_new_customers where created_at BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE() and new_user=1 and seller_id=" . $seller_id . " group by created_day");

        $date = new DateTime();
        $date->modify('-7 day');
        while ($date->format('Y-m-d') != date('Y-m-d')) {
            $found = 0;
            foreach ($query->result() as $row) {
                if ($row->created_date ===  $date->format("Y-m-d")) {
                    array_push($new_customer_per_day, $row->new_user);
                    $found = 1;
                }
            }
            if (!$found) {
                array_push($new_customer_per_day, 0);
            }
            $date->modify('+1 day');
        }
        return $new_customer_per_day;
    }


    public function get_order_details($buyer_id)
    {

        $sql = ("Select o.order_number,o.price_total,o.price_currency,o.payment_status,o.created_at,op.product_title,op.seller_id,op.product_slug,op.product_id from orders o,order_products op where o.id = op.order_id and op.buyer_id =?");
        $query = $this->db->query($sql, array(clean_number($buyer_id)));
        return $query->result();
    }

    public function updated_order($oid, $mid)
    {
        $sql = "UPDATE order_products
         INNER JOIN made_to_order ON (made_to_order.order_id = order_products.order_id and made_to_order.product_id=order_products.product_id)
         SET order_products.order_status = 'processing', made_to_order.status ='Yes'
          WHERE made_to_order.status = 'No' and order_products.order_status='waiting' and order_products.id=$oid and made_to_order.id=$mid";
        $query = $this->db->query($sql);
        return $query;
    }
    public function update_mail($mail_order_id)
    {
        $sql = "UPDATE made_to_order set mail_sent=1 where id=? ";
        $query = $this->db->query($sql, $mail_order_id);
        return $query;
    }
    public function order_window_update()
    {
        //  $lastupdatedid=0;
        // $sql="UPDATE order_products
        // INNER JOIN made_to_order ON (made_to_order.order_id = order_products.order_id and made_to_order.product_id=order_products.product_id)
        // SET order_products.order_status = IF(now() > DATE_ADD(made_to_order.created_date,interval 5 minute),'processing', 'waiting'), made_to_order.status = IF(now() > DATE_ADD(made_to_order.created_date,interval 5 minute),'Yes', 'No')
        // ,order_products.id=(SELECT $lastupdatedid:=order_products.id)WHERE made_to_order.status = 'No' and order_products.order_status='waiting'";
        // $query=$this->db->query($sql);
        // return $query;

        // $sql = "Select made_to_order.product_id,order_products.id as oid,made_to_order.order_id,made_to_order.id as mid,made_to_order.seller_id,made_to_order.buyer_id from order_products INNER JOIN made_to_order ON (made_to_order.order_id = order_products.order_id and made_to_order.product_id=order_products.product_id) WHERE now() > DATE_ADD(made_to_order.created_date,interval 5 minute) and order_products.order_status='waiting'";

        $sql = "SELECT 
                    made_to_order.product_id,
                    order_products.id AS oid,
                    made_to_order.order_id,
                    made_to_order.id AS mid,
                    made_to_order.seller_id,
                    made_to_order.buyer_id,
                    made_to_order.created_date
                FROM
                    order_products
                        INNER JOIN
                    made_to_order ON (made_to_order.order_id = order_products.order_id
                        AND made_to_order.product_id = order_products.product_id)
                WHERE
                    order_products.order_status = 'waiting'
                        AND made_to_order.mail_sent != '1'";

        $q = $this->db->query($sql);
        return $q->result();
    }

    public function get_user_order_history($buyer_id)
    {
        $buyer_id = clean_number($buyer_id);
        $this->db->where('buyer_id', $buyer_id);
        // $this->db->where("(order_products.order_status = 'completed' OR order_products.order_status = 'cancelled')");
        $this->db->where("(order_products.order_status = 'completed')");
        $query = $this->db->get('order_products');
        return $query->result();
    }


    public function get_reject_reason()
    {
        $this->db->where('for_seller', '1');
        $this->db->order_by('order', 'asc');
        $query = $this->db->get('reject_reason');
        return $query->result();
    }

    public function get_reject_reason_buyer()
    {
        $this->db->where('for_buyer', '1');
        $this->db->order_by('order', 'asc');
        $query = $this->db->get('reject_reason');
        return $query->result();
    }


    //get reason
    public function get_reason($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('reject_reason');
        return $query->row();
    }


    //get refund message
    public function get_refund_message($order_id, $product_id)
    {
        $order_id = clean_number($order_id);
        $product_id = clean_number($product_id);
        $this->db->where('order_id', $order_id);
        $this->db->where('order_product_id', $product_id);
        $query = $this->db->get('refunds');
        return $query->row();
    }


    public function update_shipping_cost($order_id, $cart_total)
    {
        $shipping_address = $this->cart_model->get_sess_cart_shipping_address();

        $Supp_ship_data = json_decode($this->get_shipping_cost($cart_total));
        if ($Supp_ship_data) {

            foreach ($Supp_ship_data as $sup) {
                $seller_address = get_user($sup->SupplierId);

                $data = array(
                    "product_shipping_cost" => $sup->Supplier_Shipping_cost,
                    "product_cod_charges" => $sup->cod_charges,
                    "product_tax_charges" => $sup->tax_charges,
                    "shipping_cod_gst_rate" => $sup->shipping_cod_gst_rate
                );

                if ($seller_address->supplier_state == $shipping_address->shipping_state) {

                    $data['shipping_igst'] = 0;
                    $data['shipping_cgst'] = $sup->shipping_tax_charges / 2;
                    $data['shipping_sgst'] = $sup->shipping_tax_charges / 2;

                    $data['cod_igst'] = 0;
                    $data['cod_cgst'] = $sup->cod_tax_charges / 2;
                    $data['cod_sgst'] = $sup->cod_tax_charges / 2;
                } else {
                    $data['shipping_igst'] = $sup->shipping_tax_charges;
                    $data['shipping_cgst'] = 0;
                    $data['shipping_sgst'] = 0;

                    $data['cod_igst'] = $sup->cod_tax_charges;
                    $data['cod_cgst'] = 0;
                    $data['cod_sgst'] = 0;
                }

                $data["total_shipping_cost"] = $data["product_shipping_cost"] + $data['shipping_igst'] + $data['shipping_cgst'] + $data['shipping_sgst'];

                $data["total_cod_charges"] = $data["product_cod_charges"] + $data['cod_igst'] + $data['cod_cgst'] + $data['cod_sgst'];


                $this->db->where("seller_id", $sup->SupplierId);
                $this->db->where("order_id", $order_id);
                $this->db->update("order_products", $data);
            }
        }
    }

    public function add_seller_wise_details($order_id, $cart_total)
    {

        $shipping_address = $this->cart_model->get_sess_cart_shipping_address();

        $Supp_ship_data = json_decode($this->get_seller_wise_data_bifurcation($cart_total));


        // var_dump($Supp_ship_data);
        // die();


        if ($Supp_ship_data) {
            foreach ($Supp_ship_data as $sup) {
                $seller_address = get_user($sup->SupplierId);

                $data = array(
                    'order_id' => $order_id,
                    'seller_id' => $sup->SupplierId,
                    'review_type' => "CUSTOM REVIEW",

                    "sup_shipping_cost" => $sup->Supplier_Shipping_cost,
                    "Sup_cod_cost" => $sup->cod_charges,
                    "shipping_cod_gst_rate" => $sup->shipping_cod_gst_rate,

                    'sup_subtotal' => intval($sup->total_product_price_without_gst),
                    'Sup_subtotal_prd_gst' => intval($sup->total_product_gst),
                    'Sup_total_prd' => $sup->total_product_price,

                    'Sup_Shipping_gst' => $sup->shipping_tax_charges,
                    'Sup_cod_gst' => $sup->cod_tax_charges,


                    // 'total_discount' => $product->user_id,
                    // 'sup_commission_cost' => $product->user_id,

                    'created_by' => 1,
                    'updated_by' => 1
                );

                if ($seller_address->supplier_state == $shipping_address->shipping_state) {

                    $data['shipping_igst'] = 0;
                    $data['shipping_cgst'] = $sup->shipping_tax_charges / 2;
                    $data['shipping_sgst'] = $sup->shipping_tax_charges / 2;

                    $data['Sup_subtotal_prd_igst'] = 0;
                    $data['Sup_subtotal_prd_cgst'] = intval($sup->total_product_gst / 2);
                    $data['Sup_subtotal_prd_sgst'] = intval($sup->total_product_gst / 2);

                    $data['sup_cod_igst'] = 0;
                    $data['sup_cod_cgst'] = $sup->cod_tax_charges / 2;
                    $data['sup_cod_sgst'] = $sup->cod_tax_charges / 2;
                } else {
                    $data['shipping_igst'] = $sup->shipping_tax_charges;
                    $data['shipping_cgst'] = 0;
                    $data['shipping_sgst'] = 0;

                    $data['Sup_subtotal_prd_igst'] = intval($sup->total_product_gst);
                    $data['Sup_subtotal_prd_cgst'] = 0;
                    $data['Sup_subtotal_prd_sgst'] = 0;

                    $data['sup_cod_igst'] = $sup->cod_tax_charges;
                    $data['sup_cod_cgst'] = 0;
                    $data['sup_cod_sgst'] = 0;
                }

                $data["total_shipping_cost"] = $data["sup_shipping_cost"] + $data['Sup_Shipping_gst'];

                $data["total_cod_cost"] = $data["Sup_cod_cost"] + $data['Sup_cod_gst'];

                $data['grand_total_amount'] = $data["Sup_total_prd"] + $data["total_shipping_cost"] + $data["total_cod_cost"];


                $this->db->insert('order_supplier', $data);
            }
        }
    }

    public function get_shipping_cost($cart_total = null)
    {

        $cart_product_count = get_cart_product_count();
        $cart_items = $this->cart_model->get_sess_cart_items();

        $shipping_address = $this->cart_model->get_sess_cart_shipping_address();
        if (empty($shipping_address)) {
            return false;
        }
        $sellers_row = $this->order_model->get_supplier();
        $sellers_col = $sellers_row;

        if (!empty($shipping_address->shipping_zip_code)) {
            $Supp_ship_data = $this->order_model->calc_total_shipping_charges($sellers_row, $sellers_col, $cart_product_count);
            return  $Supp_ship_data;
        }

        return  false;
    }

    public function get_seller_wise_data_bifurcation($cart_total = null)
    {
        $cart_product_count = get_cart_product_count();
        $cart_items = $this->cart_model->get_sess_cart_items();

        $shipping_address = $this->cart_model->get_sess_cart_shipping_address();
        if (empty($shipping_address)) {
            return false;
        }
        $sellers_row = $this->order_model->get_supplier();
        $sellers_col = $sellers_row;

        if (!empty($shipping_address->shipping_zip_code)) {
            $Supp_ship_data = $this->calc_total_shipping_charges_by_seller($sellers_row, $sellers_col, $cart_product_count);
            return  $Supp_ship_data;
        }

        return  false;
    }

    public function get_shipping_charges($cart_total)
    {

        $cart_product_count = get_cart_product_count();
        $cart_items = $this->cart_model->get_sess_cart_items();

        $shipping_address = $this->cart_model->get_sess_cart_shipping_address();
        $sellers_row = $this->order_model->get_supplier();
        $sellers_col = $sellers_row;

        $actual_shipping_charges = 0;
        if (!empty($shipping_address->shipping_zip_code)) {
            $actual_shipping_charges = $this->order_model->calc_actual_shipping_charges($sellers_row, $sellers_col, $cart_product_count);
        }


        return  $actual_shipping_charges;
    }
    public function get_actual_shipping_charges($pickuppostcode, $deliverypostcode, $cashond, $weightobject)
    {


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/courier/serviceability',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            $body = '{
                "pickup_postcode": ' . $pickuppostcode . ',
                 "delivery_postcode": ' . $deliverypostcode . ',
                 "cod":' . $cashond . ',
                "weight": ' . $weightobject . '
           
        }',

            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer' . $_SESSION['modesy_sess_user_shiprocket_token'],
            ),

        ));

        $response = curl_exec($curl);
        curl_close($curl);
        // var_dump($response);

        // $shipping_data = array(
        //     'actual_shipping_charges' => json_decode($response)->data->available_courier_companies[0]->rate * 100,
        //     'cod_charges' => json_decode($response)->data->available_courier_companies[0]->cod_charges * 100,
        //     'freight_charges' => json_decode($response)->data->available_courier_companies[0]->freight_charge * 100,
        // );

        $shipping_data = array(
            'actual_shipping_charges_with_gst' => intval((json_decode($response)->data->available_courier_companies[0]->rate) * 100),
            'actual_shipping_charges' => intval((json_decode($response)->data->available_courier_companies[0]->rate / (1 + (18 / 100))) * 100),
            'cod_charges' => intval((json_decode($response)->data->available_courier_companies[0]->cod_charges  / (1 + (18 / 100))) * 100),
            'freight_charges' => intval((json_decode($response)->data->available_courier_companies[0]->freight_charge  / (1 + (18 / 100))) * 100),
        );
        // var_dump($shipping_data);
        $this->session->set_userdata($shipping_data);
        // $shipping_cost = $shipping_data['actual_shipping_charges'] * 100;

        return $shipping_data;
    }

    public function get_supplier()
    {
        $cart_product_count = get_cart_product_count();
        $cart_items = $this->cart_model->get_sess_cart_items();
        $Sup_row = array();
        $i = 0;
        foreach ($cart_items as $cart_item) {
            $product = get_active_product($cart_item->product_id);
            $Sup_row[$i] = get_shop_name_product($product) . "-" .  $cart_item->product_id;
            ++$i;
        }
        return  $Sup_row;
    }

    // FUNCTION: Calc_total_shipping_charges 
    public function calc_total_shipping_charges($s_row, $s_col, $cp_count)
    {
        $cart_items = $this->cart_model->get_sess_cart_items();
        if (empty($cart_items)) {
            return false;
        }
        $shipping_address = $this->cart_model->get_sess_cart_shipping_address();
        $Suppliers = array();
        $product = array();

        $i = 0;

        //==================================== New calculation for shipping =====================================
        $product_seller_details = array();
        foreach ($cart_items as $cart_item) {
            $object = new stdClass();
            $object->seller_id = get_active_product($cart_item->product_id)->user_id;
            $new = true;
            foreach ($product_seller_details as $psd) {
                if ($psd->seller_id == $object->seller_id && $psd->product_pickup_code == $cart_item->product_pincode) {
                    $object_product = new stdClass();
                    $object_product->product_id = $cart_item->product_id;
                    $object_product->parent_category_id = $cart_item->parent_category_id;
                    $object_product->product_pickup_code = $cart_item->product_pincode;
                    $object_product->product_deliverable = $cart_item->product_deliverable;
                    $object_product->product_gst_rate = $cart_item->product_gst_rate;
                    $object_product->delivery_partner = $cart_item->delivery_partner;
                    if (!empty($cart_item->delivery_distance))
                        $object_product->delivery_distance = $cart_item->delivery_distance;
                    if (get_active_product($cart_item->product_id)->shipping_cost_type == "shipping_buyer_pays") {
                        $object_product->free_shipping = 0;
                    } else {
                        $object_product->free_shipping = 1;
                    }
                    $object_product->product_quantity = $cart_item->quantity;
                    $object_product->product_unit_price = $cart_item->unit_price;
                    $object_product->product_total_price = $cart_item->total_price;
                    if (empty($cart_item->options_array) || empty($cart_item->variation_option))
                        $object_product->product_unit_packaged_weight = (int)$cart_item->weight;
                    else
                        $object_product->product_unit_packaged_weight = (int)$cart_item->variation_option->package_weight;
                    $object_product->product_total_packaged_weight = $object_product->product_unit_packaged_weight * $object_product->product_quantity;

                    if (count($psd->products) > 0) {
                        foreach ($psd->products as $prod) {
                            if (floatval($object_product->product_gst_rate) > floatval($prod->product_gst_rate)) {
                                $psd->seller_gst_rate = $object_product->product_gst_rate;
                            }
                        }
                    }

                    array_push($psd->products, $object_product);

                    if (!$object_product->product_deliverable)
                        $psd->total_order_deliverable = $object_product->product_deliverable;

                    if ($object_product->free_shipping)
                        $psd->total_weight += $object_product->product_total_packaged_weight;
                    else
                        $psd->total_weight += $object_product->product_total_packaged_weight;

                    $psd->total_price += $object_product->product_total_price;

                    $new = false;
                }
            }
            if ($new) :
                $object->products = array();
                $object_product = new stdClass();
                $object_product->product_id = $cart_item->product_id;
                $object_product->parent_category_id = $cart_item->parent_category_id;
                $object_product->product_quantity = $cart_item->quantity;
                $object_product->product_deliverable = $cart_item->product_deliverable;
                $object_product->product_gst_rate = $cart_item->product_gst_rate;
                $object_product->delivery_partner = $cart_item->delivery_partner;
                if (!empty($cart_item->delivery_distance))
                    $object_product->delivery_distance = $cart_item->delivery_distance;
                $object_product->product_pickup_code = $cart_item->product_pincode;
                if (get_active_product($cart_item->product_id)->shipping_cost_type == "shipping_buyer_pays") {
                    $object_product->free_shipping = 0;
                } else {
                    $object_product->free_shipping = 1;
                }
                $object_product->product_unit_price = $cart_item->unit_price;
                $object_product->product_total_price = $cart_item->total_price;
                // var_dump($cart_item->options_array);
                if (empty($cart_item->options_array) || empty($cart_item->variation_option))
                    $object_product->product_unit_packaged_weight = (int)$cart_item->weight;
                else
                    $object_product->product_unit_packaged_weight = (int)$cart_item->variation_option->package_weight;
                $object_product->product_total_packaged_weight = $object_product->product_unit_packaged_weight * $object_product->product_quantity;
                array_push($object->products, $object_product);

                $object->product_pickup_code = $cart_item->product_pincode;
                $object->delivery_code = $shipping_address->shipping_zip_code;
                $object->total_order_deliverable = $object_product->product_deliverable;
                $object->seller_gst_rate = $object_product->product_gst_rate;

                if ($object_product->free_shipping)
                    $object->total_weight = $object_product->product_total_packaged_weight;
                else
                    $object->total_weight = $object_product->product_total_packaged_weight;
                $object->total_price = $object_product->product_total_price;

                array_push($product_seller_details, $object);
            endif;
            // var_dump($cart_item);
        }

        // var_dump($product_seller_details);


        $payments = $this->cart_model->get_sess_cart_payment_method();

        $cod = (string)0;
        $check_cod = $this->order_model->check_cod($cart_items, $cp_count);
        if ($check_cod) :

            if (!empty($payments)) {
                $payment = (string)($payments->payment_option);
                if ($payment === 'cash_on_delivery') {
                    $cod = (string)1;
                }
            }
        endif;

        //==================================== New calculation for shipping=====================================
        $whole_order_deliverable = 1;
        foreach ($product_seller_details as $psd) {
            if (!$psd->total_order_deliverable) {
                $whole_order_deliverable = 0;
                break;
            }
        }
        if (!$whole_order_deliverable) {
            return false;
        }

        $supp_data_array_copy = array();
        foreach ($product_seller_details as $psd) {
            $actual_shipping_charges = 0;
            foreach ($psd->products as $prod_details) {

                if ($prod_details->delivery_partner == "NOW-BIKES") {
                    if (!$prod_details->free_shipping) :
                        $dist = $prod_details->delivery_distance->value;

                        $dist = ceil($dist / 1000);
                        if ($dist <= 4) {
                            $actual_shipping_charges = 55;
                        } else {
                            $actual_shipping_charges = 55 + (($dist - 4) * 7);
                        }
                    else :
                        $actual_shipping_charges = 0;
                    endif;


                    //$actual_shipping_charges = ($actual_shipping_charges / (1 + (18 / 100)));

                    $suppqq = array(
                        "SupplierId" => $psd->seller_id,
                        "delivery_partner" => "NOW-BIKES",
                        "Supplier_Shipping_cost" => intval($actual_shipping_charges * 100),
                        "cod_charges" => 0,
                        "tax_charges" => intval(($actual_shipping_charges * (floatval($psd->seller_gst_rate) / 100)) * 100),
                        "shipping_tax_charges" => intval(($actual_shipping_charges * (floatval($psd->seller_gst_rate) / 100)) * 100),
                        "cod_tax_charges" => 0,
                        "shipping_cod_gst_rate" => $psd->seller_gst_rate
                    );
                    if ($psd->seller_gst_rate == 0) {
                        $suppqq["Supplier_Shipping_cost"] = intval($suppqq["Supplier_Shipping_cost"] + ($suppqq["Supplier_Shipping_cost"] * 18 / 100));
                    }
                    $suppqq["Supplier_Shipping_cost_with_gst"] = $suppqq["Supplier_Shipping_cost"] + $suppqq["shipping_tax_charges"];
                    if (!in_array($suppqq, $supp_data_array_copy)) {
                        array_push($supp_data_array_copy, $suppqq);
                    }
                } else if ($prod_details->delivery_partner == "SHIPROCKET") {

                    $shiprocket_charges = $this->order_model->get_actual_shipping_charges($psd->product_pickup_code,   $psd->delivery_code, $cod,  $psd->total_weight / 1000);
                    $Supplier_Shipping_cost_with_gst = intval($shiprocket_charges["freight_charges"] + ($shiprocket_charges["freight_charges"] * 18 / 100));

                    if (!$prod_details->free_shipping) :
                        if ($psd->total_price >= 200000) {
                            $actual_shipping_charges = array(
                                "freight_charges" => 0
                            );
                            if (!$cod) {
                                $actual_shipping_charges["cod_charges"] = 0;
                            } else {
                                $actual_shipping_charges["cod_charges"] = (50) * 100;
                            }
                            $tax_charges = intval((($actual_shipping_charges["freight_charges"] + $actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100)));
                            $actual_shipping_charges["tax_charges"] = $tax_charges;
                        } elseif ($psd->total_price >= 50000 && $psd->total_price < 200000) {
                            $actual_shipping_charges = array(
                                "freight_charges" => 10000
                            );
                            if (!$cod) {
                                $actual_shipping_charges["cod_charges"] = 0;
                            } else {
                                $actual_shipping_charges["cod_charges"] = (50) * 100;
                            }
                            $tax_charges = (($actual_shipping_charges["freight_charges"] + $actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                            $actual_shipping_charges["tax_charges"] = $tax_charges;
                        } else {
                            $actual_shipping_charges = $this->order_model->get_actual_shipping_charges($psd->product_pickup_code,   $psd->delivery_code, $cod,  $psd->total_weight / 1000);
                            $tax_charges = (($actual_shipping_charges["freight_charges"] + $actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                            $actual_shipping_charges["tax_charges"] = $tax_charges;
                        }
                    else :
                        $actual_shipping_charges = array(
                            "freight_charges" => 0,
                            "cod_charges" => (!$cod) ? 0 : 50 * 100
                        );
                        $tax_charges = (($actual_shipping_charges["freight_charges"] + $actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                        $actual_shipping_charges["tax_charges"] = $tax_charges;

                    endif;

                    $shipping_tax_charges = (($actual_shipping_charges["freight_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                    $actual_shipping_charges["shipping_tax_charges"] = $shipping_tax_charges;


                    $cod_tax_charges = (($actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                    $actual_shipping_charges["cod_tax_charges"] = $cod_tax_charges;

                    $suppqq = array(
                        "SupplierId" => $psd->seller_id,
                        "delivery_partner" => "SHIPROCKET",
                        "Supplier_Shipping_cost" => intval($actual_shipping_charges["freight_charges"]),
                        "cod_charges" => intval($actual_shipping_charges["cod_charges"]),
                        "tax_charges" => intval($actual_shipping_charges["tax_charges"]),
                        "shipping_tax_charges" => intval($actual_shipping_charges["shipping_tax_charges"]),
                        "cod_tax_charges" => intval($actual_shipping_charges["cod_tax_charges"]),
                        "shipping_cod_gst_rate" => $psd->seller_gst_rate
                    );

                    if ($psd->seller_gst_rate == 0) {
                        $suppqq["Supplier_Shipping_cost"] = intval($suppqq["Supplier_Shipping_cost"] + ($suppqq["Supplier_Shipping_cost"] * 18 / 100));
                    }
                    $suppqq["Supplier_Shipping_cost_with_gst"] = $Supplier_Shipping_cost_with_gst;

                    if (!in_array($suppqq, $supp_data_array_copy)) {
                        array_push($supp_data_array_copy, $suppqq);
                    }
                } else if ($prod_details->delivery_partner == "SELF") {
                    $actual_shipping_charges = array(
                        "freight_charges" => 0,
                        "cod_charges" => (!$cod) ? 0 : 50 * 100
                    );
                    if (!$prod_details->free_shipping) :
                        $seller_shipping_details = get_user_shipping_type($psd->seller_id);

                        $shipping_threshold = get_user_shipping_threshold($seller_shipping_details->id);
                        foreach ($shipping_threshold as $s_th) {
                            if ($psd->total_price > intval($s_th->min_value) && $psd->total_price < intval($s_th->max_value)) {
                                $actual_shipping_charges["freight_charges"] = $s_th->shipping_charges * 100;
                            }
                        }
                    else :
                        $actual_shipping_charges["freight_charges"] = 0;
                    endif;
                    $suppqq = array(
                        "SupplierId" => $psd->seller_id,
                        "delivery_partner" => "SELF",
                        "Supplier_Shipping_cost" => intval($actual_shipping_charges["freight_charges"]),
                        "cod_charges" => intval($actual_shipping_charges["cod_charges"]),
                        "tax_charges" => 0,
                        "shipping_tax_charges" => 0,
                        "cod_tax_charges" => 0,
                        "shipping_cod_gst_rate" => $psd->seller_gst_rate

                    );
                    $tax_charges = (($actual_shipping_charges["freight_charges"] + $actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                    $suppqq["tax_charges"] = intval($tax_charges);

                    $shipping_tax_charges = (($actual_shipping_charges["freight_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                    $suppqq["shipping_tax_charges"] = intval($shipping_tax_charges);

                    $cod_tax_charges = (($actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                    $suppqq["cod_tax_charges"] = intval($cod_tax_charges);

                    $suppqq["Supplier_Shipping_cost_with_gst"] = $suppqq["Supplier_Shipping_cost"] + $suppqq["shipping_tax_charges"];

                    if (!in_array($suppqq, $supp_data_array_copy)) {
                        array_push($supp_data_array_copy, $suppqq);
                    }
                }
            }
        }

        $ship_data_copy = json_encode($supp_data_array_copy);
        // echo ($ship_data_copy);
        // echo $ship_data_copy;
        return $ship_data_copy;
    }

    // FUNCTION: Calc_total_shipping_charges 
    public function calc_total_shipping_charges_by_seller($s_row, $s_col, $cp_count)
    {
        $cart_items = $this->cart_model->get_sess_cart_items();
        if (empty($cart_items)) {
            return false;
        }
        $shipping_address = $this->cart_model->get_sess_cart_shipping_address();
        $Suppliers = array();
        $product = array();

        $i = 0;

        //==================================== New calculation for shipping =====================================
        $product_seller_details = array();
        foreach ($cart_items as $cart_item) {
            $object = new stdClass();
            $object->seller_id = get_active_product($cart_item->product_id)->user_id;
            $new = true;
            foreach ($product_seller_details as $psd) {
                if ($psd->seller_id == $object->seller_id && $psd->product_pickup_code == $cart_item->product_pincode) {
                    $object_product = new stdClass();
                    $object_product->product_id = $cart_item->product_id;
                    $object_product->parent_category_id = $cart_item->parent_category_id;
                    $object_product->product_pickup_code = $cart_item->product_pincode;
                    $object_product->product_deliverable = $cart_item->product_deliverable;
                    $object_product->product_gst_rate = $cart_item->product_gst_rate;
                    $object_product->delivery_partner = $cart_item->delivery_partner;
                    if (!empty($cart_item->delivery_distance))
                        $object_product->delivery_distance = $cart_item->delivery_distance;
                    if (get_active_product($cart_item->product_id)->shipping_cost_type == "shipping_buyer_pays") {
                        $object_product->free_shipping = 0;
                    } else {
                        $object_product->free_shipping = 1;
                    }
                    $object_product->product_quantity = $cart_item->quantity;
                    $object_product->product_unit_price = $cart_item->unit_price;
                    $object_product->product_total_price = $cart_item->total_price;
                    if (empty($cart_item->options_array) || empty($cart_item->variation_option))
                        $object_product->product_unit_packaged_weight = (int)$cart_item->weight;
                    else
                        $object_product->product_unit_packaged_weight = (int)$cart_item->variation_option->package_weight;
                    $object_product->product_total_packaged_weight = $object_product->product_unit_packaged_weight * $object_product->product_quantity;

                    if (count($psd->products) > 0) {
                        foreach ($psd->products as $prod) {
                            if (floatval($object_product->product_gst_rate) > floatval($prod->product_gst_rate)) {
                                $psd->seller_gst_rate = $object_product->product_gst_rate;
                            }
                        }
                    }

                    array_push($psd->products, $object_product);

                    if (!$object_product->product_deliverable)
                        $psd->total_order_deliverable = $object_product->product_deliverable;

                    if ($object_product->free_shipping)
                        $psd->total_weight += 0;
                    else
                        $psd->total_weight += $object_product->product_total_packaged_weight;

                    $psd->total_price += $object_product->product_total_price;

                    $new = false;
                }
            }
            if ($new) :
                $object->products = array();
                $object_product = new stdClass();
                $object_product->product_id = $cart_item->product_id;
                $object_product->parent_category_id = $cart_item->parent_category_id;
                $object_product->product_quantity = $cart_item->quantity;
                $object_product->product_deliverable = $cart_item->product_deliverable;
                $object_product->product_gst_rate = $cart_item->product_gst_rate;
                $object_product->delivery_partner = $cart_item->delivery_partner;
                if (!empty($cart_item->delivery_distance))
                    $object_product->delivery_distance = $cart_item->delivery_distance;
                $object_product->product_pickup_code = $cart_item->product_pincode;
                if (get_active_product($cart_item->product_id)->shipping_cost_type == "shipping_buyer_pays") {
                    $object_product->free_shipping = 0;
                } else {
                    $object_product->free_shipping = 1;
                }
                $object_product->product_unit_price = $cart_item->unit_price;
                $object_product->product_total_price = $cart_item->total_price;
                // var_dump($cart_item->options_array);
                if (empty($cart_item->options_array) || empty($cart_item->variation_option))
                    $object_product->product_unit_packaged_weight = (int)$cart_item->weight;
                else
                    $object_product->product_unit_packaged_weight = (int)$cart_item->variation_option->package_weight;
                $object_product->product_total_packaged_weight = $object_product->product_unit_packaged_weight * $object_product->product_quantity;
                array_push($object->products, $object_product);

                $object->product_pickup_code = $cart_item->product_pincode;
                $object->delivery_code = $shipping_address->shipping_zip_code;
                $object->total_order_deliverable = $object_product->product_deliverable;
                $object->seller_gst_rate = $object_product->product_gst_rate;

                if ($object_product->free_shipping)
                    $object->total_weight = 0;
                else
                    $object->total_weight = $object_product->product_total_packaged_weight;
                $object->total_price = $object_product->product_total_price;

                array_push($product_seller_details, $object);
            endif;
            // var_dump($cart_item);
        }

        // var_dump($product_seller_details);


        $payments = $this->cart_model->get_sess_cart_payment_method();

        $cod = (string)0;
        $check_cod = $this->order_model->check_cod($cart_items, $cp_count);
        if ($check_cod) :

            if (!empty($payments)) {
                $payment = (string)($payments->payment_option);
                if ($payment === 'cash_on_delivery') {
                    $cod = (string)1;
                }
            }
        endif;

        //==================================== New calculation for shipping=====================================
        $whole_order_deliverable = 1;
        foreach ($product_seller_details as $psd) {
            if (!$psd->total_order_deliverable) {
                $whole_order_deliverable = 0;
                break;
            }
        }
        if (!$whole_order_deliverable) {
            return false;
        }

        $supp_data_array_copy = array();
        foreach ($product_seller_details as $psd) {
            $actual_shipping_charges = 0;
            foreach ($psd->products as $prod_details) {

                if ($prod_details->delivery_partner == "NOW-BIKES") {
                    if (!$prod_details->free_shipping) :
                        $dist = $prod_details->delivery_distance->value;

                        $dist = ceil($dist / 1000);
                        if ($dist <= 4) {
                            $actual_shipping_charges = 55;
                        } else {
                            $actual_shipping_charges = 55 + (($dist - 4) * 7);
                        }
                    else :
                        $actual_shipping_charges = 0;
                    endif;


                    //$actual_shipping_charges = ($actual_shipping_charges / (1 + (18 / 100)));

                    $suppqq = array(
                        "SupplierId" => $psd->seller_id,
                        "delivery_partner" => "NOW-BIKES",
                        "Supplier_Shipping_cost" => intval($actual_shipping_charges * 100),
                        "cod_charges" => 0,
                        "tax_charges" => intval(($actual_shipping_charges * (floatval($psd->seller_gst_rate) / 100)) * 100),
                        "shipping_tax_charges" => intval(($actual_shipping_charges * (floatval($psd->seller_gst_rate) / 100)) * 100),
                        "cod_tax_charges" => 0,
                        "shipping_cod_gst_rate" => $psd->seller_gst_rate,
                        "total_product_price" => 0,
                        "total_product_price_without_gst" => 0,
                        "total_product_gst" => 0
                    );

                    //product wise calculation price and gst
                    $suppqq["total_product_price"] += $prod_details->product_total_price;
                    $suppqq["total_product_price_without_gst"] += $prod_details->product_total_price / (1 + ($prod_details->product_gst_rate / 100));
                    $suppqq["total_product_gst"] += ($prod_details->product_total_price) - ($prod_details->product_total_price / (1 + ($prod_details->product_gst_rate / 100)));


                    if ($psd->seller_gst_rate == 0) {
                        $suppqq["Supplier_Shipping_cost"] = intval($suppqq["Supplier_Shipping_cost"] + ($suppqq["Supplier_Shipping_cost"] * 18 / 100));
                    }
                } else if ($prod_details->delivery_partner == "SHIPROCKET") {

                    if (!$prod_details->free_shipping) :
                        if ($psd->total_price >= 200000) {
                            $actual_shipping_charges = array(
                                "freight_charges" => 0
                            );
                            if (!$cod) {
                                $actual_shipping_charges["cod_charges"] = 0;
                            } else {
                                $actual_shipping_charges["cod_charges"] = (50) * 100;
                            }
                            $tax_charges = intval((($actual_shipping_charges["freight_charges"] + $actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100)));
                            $actual_shipping_charges["tax_charges"] = $tax_charges;
                        } elseif ($psd->total_price >= 50000 && $psd->total_price < 200000) {
                            $actual_shipping_charges = array(
                                "freight_charges" => 10000
                            );
                            if (!$cod) {
                                $actual_shipping_charges["cod_charges"] = 0;
                            } else {
                                $actual_shipping_charges["cod_charges"] = (50) * 100;
                            }
                            $tax_charges = (($actual_shipping_charges["freight_charges"] + $actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                            $actual_shipping_charges["tax_charges"] = $tax_charges;
                        } else {
                            $actual_shipping_charges = $this->order_model->get_actual_shipping_charges($psd->product_pickup_code,   $psd->delivery_code, $cod,  $psd->total_weight / 1000);
                            $tax_charges = (($actual_shipping_charges["freight_charges"] + $actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                            $actual_shipping_charges["tax_charges"] = $tax_charges;
                        }
                    else :
                        $actual_shipping_charges = array(
                            "freight_charges" => 0,
                            "cod_charges" => (!$cod) ? 0 : 50 * 100
                        );
                        $tax_charges = (($actual_shipping_charges["freight_charges"] + $actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                        $actual_shipping_charges["tax_charges"] = $tax_charges;

                    endif;

                    $shipping_tax_charges = (($actual_shipping_charges["freight_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                    $actual_shipping_charges["shipping_tax_charges"] = $shipping_tax_charges;


                    $cod_tax_charges = (($actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                    $actual_shipping_charges["cod_tax_charges"] = $cod_tax_charges;

                    $suppqq = array(
                        "SupplierId" => $psd->seller_id,
                        "delivery_partner" => "SHIPROCKET",
                        "Supplier_Shipping_cost" => intval($actual_shipping_charges["freight_charges"]),
                        "cod_charges" => intval($actual_shipping_charges["cod_charges"]),
                        "tax_charges" => intval($actual_shipping_charges["tax_charges"]),
                        "shipping_tax_charges" => intval($actual_shipping_charges["shipping_tax_charges"]),
                        "cod_tax_charges" => intval($actual_shipping_charges["cod_tax_charges"]),
                        "shipping_cod_gst_rate" => $psd->seller_gst_rate,
                        "total_product_price" => 0,
                        "total_product_price_without_gst" => 0,
                        "total_product_gst" => 0
                    );

                    //product wise calculation price and gst
                    $suppqq["total_product_price"] += $prod_details->product_total_price;
                    $suppqq["total_product_price_without_gst"] += $prod_details->product_total_price / (1 + ($prod_details->product_gst_rate / 100));
                    $suppqq["total_product_gst"] += ($prod_details->product_total_price) - ($prod_details->product_total_price / (1 + ($prod_details->product_gst_rate / 100)));


                    if ($psd->seller_gst_rate == 0) {
                        $suppqq["Supplier_Shipping_cost"] = intval($suppqq["Supplier_Shipping_cost"] + ($suppqq["Supplier_Shipping_cost"] * 18 / 100));
                    }
                } else if ($prod_details->delivery_partner == "SELF") {
                    $actual_shipping_charges = array(
                        "freight_charges" => 0,
                        "cod_charges" => (!$cod) ? 0 : 50 * 100
                    );
                    if (!$prod_details->free_shipping) :
                        $seller_shipping_details = get_user_shipping_type($psd->seller_id);

                        $shipping_threshold = get_user_shipping_threshold($seller_shipping_details->id);
                        foreach ($shipping_threshold as $s_th) {
                            if ($psd->total_price > intval($s_th->min_value) && $psd->total_price < intval($s_th->max_value)) {
                                $actual_shipping_charges["freight_charges"] = $s_th->shipping_charges * 100;
                            }
                        }
                    else :
                        $actual_shipping_charges["freight_charges"] = 0;
                    endif;
                    $suppqq = array(
                        "SupplierId" => $psd->seller_id,
                        "delivery_partner" => "SELF",
                        "Supplier_Shipping_cost" => intval($actual_shipping_charges["freight_charges"]),
                        "cod_charges" => intval($actual_shipping_charges["cod_charges"]),
                        "tax_charges" => 0,
                        "shipping_tax_charges" => 0,
                        "cod_tax_charges" => 0,
                        "shipping_cod_gst_rate" => $psd->seller_gst_rate,
                        "total_product_price" => 0,
                        "total_product_price_without_gst" => 0,
                        "total_product_gst" => 0

                    );


                    //product wise calculation price and gst
                    $suppqq["total_product_price"] += $prod_details->product_total_price;
                    $suppqq["total_product_price_without_gst"] += $prod_details->product_total_price / (1 + ($prod_details->product_gst_rate / 100));
                    $suppqq["total_product_gst"] += ($prod_details->product_total_price) - ($prod_details->product_total_price / (1 + ($prod_details->product_gst_rate / 100)));



                    $tax_charges = (($actual_shipping_charges["freight_charges"] + $actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                    $suppqq["tax_charges"] = intval($tax_charges);

                    $shipping_tax_charges = (($actual_shipping_charges["freight_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                    $suppqq["shipping_tax_charges"] = intval($shipping_tax_charges);

                    $cod_tax_charges = (($actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                    $suppqq["cod_tax_charges"] = intval($cod_tax_charges);
                }
                $exist = 0;
                $duplicate_key = 0;
                foreach ($supp_data_array_copy as $key => $sda) {
                    if ($sda["SupplierId"] == $suppqq["SupplierId"]) {
                        $exist = 1;
                        $duplicate_key = $key;
                    }
                }

                if ($exist) {
                    unset($supp_data_array_copy[$duplicate_key]);
                    array_push($supp_data_array_copy, $suppqq);
                } else {
                    array_push($supp_data_array_copy, $suppqq);
                }
            }
        }

        $ship_data_copy = json_encode($supp_data_array_copy);
        // echo ($ship_data_copy);
        return $ship_data_copy;
    }


    public function check_cod($c_items, $c_count)
    {
        $c_items = $this->cart_model->get_sess_cart_items();
        $cod_count = 0;

        foreach ($c_items as $c_item) {

            if ($c_item->cod_accepted == "Y") {
                $cod_count += 1;
            }
        }
        if ($cod_count == $c_count) {
            return true;
        } else {
            return false;
        }
    }

    public function check_mto($c_items)
    {
        $c_items = $this->cart_model->get_sess_cart_items();
        $mto_count = 0;

        foreach ($c_items as $c_item) {
            $made_to_order = $this->product_model->get_made_to_order($c_item->product_id);
            if ($made_to_order[0]->add_meet == "Made to order") {
                $mto_count += 1;
            }
        }
        if ($mto_count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_transaction_detail($order_id)
    {
        $order_id = clean_number($order_id);
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('transactions');
        return $query->result();
    }
    public function get_order_detail_by_id($order_id)
    {
        $order_id = clean_number($order_id);
        $this->db->where('id', $order_id);
        $query = $this->db->get('orders');
        return $query->result();
    }
    public function save_refund_detail($refund_data)
    {
        $this->db->insert('refunds', $refund_data);
    }
    public function get_order_number_by_cashfree_id($cashfree_order_id)
    {
        $this->db->where('cashfree_order_id', $cashfree_order_id);
        $query = $this->db->get('transactions');
        return $query->result();
    }


    public function get_refund_exists($product_table_id)
    {
        $product_table_id = clean_number($product_table_id);
        $this->db->where('order_product_table_id', $product_table_id);
        $this->db->where('status', 'OK');
        $query = $this->db->get('refunds');
        return $query->num_rows();
    }

    public function get_order_product_detail($order_id)
    {
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('order_products');
        return $query->result();
    }


    public function get_sign_by_seller_id($seller_id)
    {
        $this->db->where('id', $seller_id);
        $query = $this->db->get('users');
        return $query->result();
    }


    public function shiprocket_tracking_status($awb_code)
    {
        $awb_number = $awb_code;
        $url = "https://apiv2.shiprocket.in/v1/external/courier/track/awb/" . $awb_number;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer' . $_SESSION['modesy_sess_user_shiprocket_token'],
            ),

        ));

        $response = curl_exec($curl);
        $arr = json_decode($response);
        curl_close($curl);
        return $arr;
    }

    public function status($awb_code)
    {
        $awb_number = $awb_code;
        $url = "https://apiv2.shiprocket.in/v1/external/courier/track/awb/" . $awb_number;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer' . $_SESSION['modesy_sess_user_shiprocket_token'],
            ),

        ));

        $response = curl_exec($curl);
        $arr = json_decode($response);
        $status = $arr->tracking_data->track_status;
        curl_close($curl);
        return $status;
    }
    public function track_status($awb_number)
    {

        $url = "https://apiv2.shiprocket.in/v1/external/courier/track/awb/" . $awb_number;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer' . $_SESSION['modesy_sess_user_shiprocket_token'],
            ),

        ));

        $response = curl_exec($curl);
        $arr = json_decode($response);

        $statuses = $arr->tracking_data->shipment_track_activities;
        curl_close($curl);
        return $statuses;
    }
    public function current_Status($awb_number)
    {
        $curl = curl_init();

        $url = "https://apiv2.shiprocket.in/v1/external/courier/track/awb/" . $awb_number;

        // $order_id = clean_number($order_id);
        // $product_id = clean_number($product_id);


        // $order = $this->order_model->get_stats($order_id, $product_id);

        curl_setopt_array($curl, array(
            CURLOPT_URL =>  $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer' . $_SESSION['modesy_sess_user_shiprocket_token'],
            ),

        ));

        $response = curl_exec($curl);
        // var_dump($response);
        $arr = json_decode($response);
        $currentStatus = $arr->tracking_data->shipment_track[0]->current_status;

        // var_dump($arr[0]->tracking_data->shipment_track_activities);
        // var_dump($currentStatus);
        curl_close($curl);
        return $currentStatus;
    }

    public function tracking_url($order_id, $product_id)
    {
        $curl = curl_init();
        // $order_id = clean_number($order_id);
        // $product_id = clean_number($product_id);


        // $order = $this->order_model->get_stats($order_id, $product_id);
        $curl = curl_init();
        $awb_number = $this->order_model->get_stats($order_id, $product_id);
        foreach ($awb_number as $awb) : {
            }
        endforeach;
        $url = "https://apiv2.shiprocket.in/v1/external/courier/track/awb/" . $awb->awb_code;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer' . $_SESSION['modesy_sess_user_shiprocket_token'],
            ),

        ));

        $response = curl_exec($curl);
        // var_dump($response);
        $arr = json_decode($response);
        $trackingurl = $arr->tracking_data->track_url;

        // var_dump($arr[0]->tracking_data->shipment_track_activities);
        // var_dump($currentStatus);
        curl_close($curl);
        return $trackingurl;
    }
    public function cancel_order($shipment_order_id)
    {
        //$product_id = $this->get_order_product($order_product_id);
        $curl = curl_init();
        // $shiprocket_detail = $this->get_stats($order_id, $product_id);
        // foreach ($awb_number as $awb) : {
        //     }
        // endforeach;


        $data = array(
            $shipment_order_id
        );



        $r = json_encode($data);



        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/orders/cancel',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
  "ids":  ' . $r . '
}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization:  Bearer' . $_SESSION['modesy_sess_user_shiprocket_token'],
            ),
        ));


        $response = curl_exec($curl);


        curl_close($curl);
        $x = json_decode($response);
        $cancel_shiprocket_details_status = array(
            'is_active' => 0
        );
        $this->db->where('shipment_order_id', $shipment_order_id);

        $this->db->update('shiprocket_order_details', $cancel_shiprocket_details_status);

        $update_order_products = $this->get_shiprocket_detail_by_shipment_orderid($shipment_order_id);
        foreach ($update_order_products as $update_product) {
            $order_status = array(
                'order_status' => 'processing'
            );
            $this->db->where('order_id', $update_product->order_id);
            $this->db->where('product_id', $update_product->product_id);
            $this->db->update('order_products', $order_status);
        }
        return $x->message;
    }
    public function get_stats($order_id, $product_id)
    {

        $order_id = clean_number($order_id);
        $this->db->where('order_id', $order_id);
        $this->db->where('product_id', $product_id);

        $query = $this->db->get('shiprocket_order_details');
        // var_dump($query->result);
        return $query->result();
    }

    public function get_shiprocket_detail_by_shipment_orderid($shipment_order_id)
    {

        $order_id = clean_number($shipment_order_id);
        $this->db->where('shipment_order_id', $shipment_order_id);

        $query = $this->db->get('shiprocket_order_details');
        // var_dump($query->result);
        return $query->result();
    }

    public function get_product_detail($product_id)
    {
        $this->db->where('id', $product_id);
        $query = $this->db->get('products');
        return $query->result();
    }

    //get product category and user_id using product_id
    public function get_product_shipping_days_from_db($shipping)
    {
        $query = $this->db->query("SELECT lookup_int_val from lookup_values where meaning='$shipping'");
        return $query->row();
    }

    public function save_penalty_details($data, $seller_id, $penalty_amount_for_db)
    {
        $this->db->insert('penalty', $data);
    }

    public function get_now_bike_order_product_id($now_bike_id)
    {
        $this->db->where('now_bike_id', $now_bike_id);
        $query = $this->db->get('now_bike_order_details');
        return $query->result();
    }
    public function create_now_bike_order($data)
    {
        $this->db->insert('now_bike_order_details', $data);
        $order_status = array(
            'order_status' => 'awaiting_pickup'
        );

        $this->db->where('id', $data["order_product_id"]);


        $this->db->update('order_products', $order_status);
        return $this->db->insert_id();
    }

    public function cancel_now_bike_order($now_bike_id, $data)
    {
        $data = $data;
        $data['is_active'] = 0;
        $this->db->where('now_bike_id', $now_bike_id);
        $order_products = $this->get_now_bike_order_product_id($now_bike_id);

        foreach ($order_products as $order_product) {
            $order_status = array(
                'order_status' => 'processing'
            );
            $this->db->where('id', $order_product->order_product_id);
            $this->db->update('order_products', $order_status);
        }
        return $this->db->update('now_bike_order_details', $data);
    }

    public function get_shiprocket_order_details_by_awb($awb_number)
    {
        $this->db->where('awb_code', $awb_number);
        $query = $this->db->get('shiprocket_order_details');
        // var_dump($query->result);
        return $query->row();
    }

    public function get_order_product_id($order_id, $product_id)
    {
        $this->db->where('order_id', $order_id);
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('order_products');
        // var_dump($query->result);
        return $query->row();
    }

    public function get_made_to_order_id($order_id, $product_id)
    {
        $this->db->where('order_id', $order_id);
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('made_to_order');
        // var_dump($query->result);
        return $query->row();
    }

    public function get_state_code($state_name)
    {
        $this->db->where('state_name', $state_name);
        $query = $this->db->get('state_code');
        return $query->row();
    }


    public function get_order_id_by_awb($awb)
    {
        $this->db->where('awb_code', $awb);
        $this->db->where('is_active', 1);
        $query = $this->db->get('shiprocket_order_details');
        if (empty($query->row())) {
            return false;
        } else {
            return $query->row()->order_id;
        }
    }

    public function get_product_id_by_awb($awb)
    {
        $this->db->where('awb_code', $awb);
        $this->db->where('is_active', 1);
        $query = $this->db->get('shiprocket_order_details');
        $result = $query->result();

        $product = array();
        if (empty($result)) {
            return $product;
        } else {
            foreach ($result as $res) {
                array_push($product, $res->product_id);
            }
            return $product;
        }
    }

    public function update_whole_order_status($order_id)
    {
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('order_products');
        $total_order_products = $query->num_rows();


        $this->db->where('order_id', $order_id);
        $this->db->where('order_status', "completed");
        $query = $this->db->get('order_products');
        $total_order_products_delivered = $query->num_rows();

        if ($total_order_products === $total_order_products_delivered) :
            $data = array(
                "status" => 1
            );
            $this->db->where('id', $order_id);
            $this->db->update('orders', $data);
        endif;
    }
    public function get_commission_rate_nb_wallet($payment_mode, $code)
    {
        $this->db->where('gateway_code', $payment_mode);
        $this->db->where('option_code', $code);
        $this->db->where('enabled_flag', '1');
        $query = $this->db->get('payment_method_options');
        return $query->row();
    }
    public function save_cashfree_seller_payable($data)
    {
        $this->db->insert('cashfree_seller_payable', $data);
    }

    // get cod charges by order id and seller id
    public function get_charges_seller_wise($sellerid, $order_id)
    {
        $this->db->where('order_id', $order_id);
        $this->db->where('seller_id', $sellerid);
        $query = $this->db->get('order_supplier');
        return $query->row();
    }
}
