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
        $cart_total = $this->cart_model->get_sess_cart_total();
        // $total = $cart_total->total_price;
        // if ($total < 50000) {
        //     $total = $total + 10000;
        // } else {
        //     $total = $cart_total->total_price;
        // }
        $total_price1 = $cart_total->total_price / 100;
        if ((float)$data_transaction['payment_amount'] == $total_price1 && $data_transaction['match_status'] == "yes") {
            $order_product_status = "processing";
        } else {
            $order_product_status = "pending";
        }
        $cashfree_order_id = $data_transaction["cashfree_order_id"];

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

                //coupon code
                'offer_id' => $cart_total->applied_coupon_id,
                'coupon_discount' => $cart_total->applied_coupon_discount,


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


            if ($this->general_settings->flat_ship_enable == 1) {
                $data['is_flat_ship'] = 1;
                $data['flat_ship_amount'] = 0;
            }
            if ($this->general_settings->flat_cod_enable == 1) {
                $data['total_cod_charges'] = 0;
            }


            if ($this->auth_check) {
                // $data["buyer_type"] = "registered";
                $data["buyer_id"] = $this->auth_user->id;
                $user = get_user($this->auth_user->id);
                $data["buyer_type"] = $user->user_type;
            }
            if ($this->db->insert('orders', $data)) {
                $order_id = $this->db->insert_id();

                //update order number
                $this->update_order_number($order_id);

                //add order coupon redemption details
                if (!empty($cart_total->applied_coupon_id)) :
                    $this->add_coupon_redeem_details($order_id, $cart_total);
                endif;

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
                //update order id in casfree prepaid payouts
                if ($data_transaction['match_status'] == "yes") {
                    $this->update_orderid_cashfree_prepaid_payouts($cashfree_order_id, $order_id, 1);
                } else {
                    $this->update_orderid_cashfree_prepaid_payouts($cashfree_order_id, $order_id, 0);
                }
                if ((float)$data_transaction['payment_amount'] != $total_price1 || $data_transaction['match_status'] == "no") {
                    $this->load->model("email_model");
                    $this->email_model->wrong_order($data_transaction, $data, $order_id);
                }
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
        // if ($payment_method != 'Cash On Delivery') {
        //     $payment_status = "payment_received";
        // }
        // if($this->cart_model->check_cart_has_made_to_order_product() ==true)
        // {
        //     $data["order_status"] = "waiting";
        // }

        $cart_total = $this->cart_model->get_sess_cart_total();
        if ($cart_total->total_price == 0) {
            $payment_method = "cashfree";
            $payment_status = "payment_received";
        }
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

                //coupon code
                'offer_id' => $cart_total->applied_coupon_id,
                'coupon_discount' => $cart_total->applied_coupon_discount,

                'status' => 0,
                'payment_method' => $payment_method,
                'payment_status' => $payment_status,
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            );

            if ($this->auth_check) {
                $data["buyer_type"] = "registered";
                $data["buyer_id"] = $this->auth_user->id;
                $user = get_user($this->auth_user->id);
                $data["buyer_type"] = $user->user_type;
            }
            // //cod seller payable
            // $this->calc_seller_payable(1);die();
            if ($this->general_settings->flat_ship_enable == 1) {
                $data['is_flat_ship'] = 1;
                $data['flat_ship_amount'] = 0;
            }
            if ($this->general_settings->flat_cod_enable == 1) {
                $data['is_flat_cod'] = 1;
                $data['flat_cod_amount'] = 0;
            }
            if ($this->db->insert('orders', $data)) {
                $order_id = $this->db->insert_id();

                //update order number
                $this->update_order_number($order_id);

                //add order coupon redemption details
                if (!empty($cart_total->applied_coupon_id)) :
                    $this->add_coupon_redeem_details($order_id, $cart_total);
                endif;

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

                // //cod seller payable
                $this->calc_seller_payable($order_id);

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




    public function calc_seller_payable($order_id)
    {
        $order_id = $order_id;

        $cart_items = $this->cart_model->get_sess_cart_items();
        $cart_total = $this->cart_model->get_sess_cart_total();
        $shipping_detail = json_decode($this->order_model->get_shipping_cost($cart_total));
        $total_amount = $cart_total->total_price;



        $seller_array = array();
        $amount_array = array();
        $product_seller_details = array();
        $payment_mode = "COD";


        foreach ($cart_items as $cart_item) {
            $object = new stdClass();
            $product_details = get_active_product($cart_item->product_id);

            $object->seller_id = $product_details->user_id;

            $pan_number = get_pan_number_by_sellerid($object->seller_id);
            $pan_forth_char = str_split($pan_number);

            $object->seller_commission_rate = calculate_commission_rate_seller($object->seller_id);
            $new = true;
            foreach ($product_seller_details as $psd) {
                if ($psd->seller_id == $object->seller_id) {
                    $object_product = new stdClass();
                    $object_product->product_id = $cart_item->product_id;
                    $object_product->gst_rate = $product_details->gst_rate;
                    $object_product->product_total_price = $cart_item->total_price;


                    $gst_cal = 1 + ($object_product->gst_rate / 100);
                    $product_price_excluding_gst = round($object_product->product_total_price / $gst_cal, 0);
                    $amount = $product_price_excluding_gst / 100;
                    $commission = ($object->seller_commission_rate) / 100;
                    $commission_amount_without_round = $amount * $commission;
                    $commission_amount = round($commission_amount_without_round, 2);

                    $object_product->product_price_excluding_gst = $product_price_excluding_gst;

                    $gst_on_commission_amount = $commission_amount * 0.18;
                    $commission_amount_with_gst = $commission_amount + $gst_on_commission_amount;


                    $object_product->product_commission_amount = $commission_amount;
                    $object_product->product_gst_on_commission_amount = round($gst_on_commission_amount, 2);
                    $object_product->product_commission_amount_with_gst = round($commission_amount_with_gst, 2);


                    $psd->total_commission_amount += $object_product->product_commission_amount_with_gst;
                    $psd->total_price += $object_product->product_total_price;
                    $psd->total_price_without_gst += $object_product->product_price_excluding_gst;
                    $psd->seller_earned = ($psd->total_price / 100) - $psd->total_commission_amount;


                    if ($object_product->gst_rate == 0 || $object_product->gst_rate == null) {
                        $object_product->tcs_amount_product = 0;

                        if (!empty($pan_number)) {
                            if ($pan_forth_char[3] == 'P' || $pan_forth_char[3] == 'H') {
                                $object_product->tds_amount_product = 0;
                                $object_product->tds_amount_product_huf_ind = 0.01 * ($object_product->product_total_price);
                            } else {
                                $object_product->tds_amount_product = 0.01 * ($object_product->product_total_price);
                            }
                        } else {
                            $object_product->tds_amount_product = 0.05 * ($object_product->product_total_price);
                        }
                    } elseif ($object_product->gst_rate != 0) {
                        $object_product->tcs_amount_product = $object_product->product_price_excluding_gst * 0.01;
                        if (!empty($pan_number)) {
                            if ($pan_forth_char[3] == 'P' || $pan_forth_char[3] == 'H') {
                                $object_product->tds_amount_product = 0;
                                $object_product->tds_amount_product_huf_ind = 0.01 * ($object_product->product_price_excluding_gst);
                            } else {
                                $object_product->tds_amount_product = 0.01 * ($object_product->product_price_excluding_gst);
                            }
                        } else {
                            $object_product->tds_amount_product = 0.05 * ($object_product->product_price_excluding_gst);
                        }
                    }

                    if (count($psd->products) > 0) {
                        foreach ($psd->products as $prod) {
                            if (floatval($object_product->gst_rate) > floatval($prod->gst_rate)) {
                                $psd->seller_gst_rate = $object_product->gst_rate;
                            }
                        }
                    }
                    $psd->total_tds_amount_product_huf_ind = 0;
                    $psd->total_tcs_amount_product += $object_product->tcs_amount_product;
                    $psd->total_tds_amount_product += $object_product->tds_amount_product;
                    $psd->total_tds_amount_product_huf_ind += 0;
                    array_push($psd->products, $object_product);
                    $new = false;
                }
            }
            if ($new) :
                $object->products = array();
                $object_product = new stdClass();
                $object_product->product_id = $cart_item->product_id;
                $object_product->gst_rate = $product_details->gst_rate;
                $object_product->product_total_price = $cart_item->total_price;



                $gst_cal = 1 + ($object_product->gst_rate / 100);
                $product_price_excluding_gst = round($object_product->product_total_price / $gst_cal, 0);
                $amount = $product_price_excluding_gst / 100;
                $commission = $object->seller_commission_rate / 100;
                $commission_amount_without_round = $amount * $commission;
                $commission_amount = round($commission_amount_without_round, 2);


                $object_product->product_price_excluding_gst = $product_price_excluding_gst;

                $gst_on_commission_amount = $commission_amount * 0.18;
                $commission_amount_with_gst = $commission_amount + $gst_on_commission_amount;

                $object_product->product_commission_amount = $commission_amount;
                $object_product->product_gst_on_commission_amount = round($gst_on_commission_amount, 2);
                $object_product->product_commission_amount_with_gst = round($commission_amount_with_gst, 2);


                $object->total_commission_amount = $object_product->product_commission_amount_with_gst;
                $object->total_price = $object_product->product_total_price;
                $object->total_price_without_gst = $object_product->product_price_excluding_gst;

                if ($object_product->gst_rate == 0 || $object_product->gst_rate == null) {
                    $object_product->tcs_amount_product = 0;

                    if (!empty($pan_number)) {
                        if ($pan_forth_char[3] == 'P' || $pan_forth_char[3] == 'H') {
                            $object_product->tds_amount_product = 0;
                            $object_product->tds_amount_product_huf_ind = 0.01 * ($object_product->product_total_price);
                        } else {
                            $object_product->tds_amount_product = 0.01 * ($object_product->product_total_price);
                        }
                    } else {
                        $object_product->tds_amount_product = 0.05 * ($object_product->product_total_price);
                    }
                } elseif ($object_product->gst_rate != 0) {
                    $object_product->tcs_amount_product = $object_product->product_price_excluding_gst * 0.01;
                    if (!empty($pan_number)) {
                        if ($pan_forth_char[3] == 'P' || $pan_forth_char[3] == 'H') {
                            $object_product->tds_amount_product = 0;
                            $object_product->tds_amount_product_huf_ind = 0.01 * ($object_product->product_price_excluding_gst);
                        } else {
                            $object_product->tds_amount_product = 0.01 * ($object_product->product_price_excluding_gst);
                        }
                    } else {
                        $object_product->tds_amount_product = 0.05 * ($object_product->product_price_excluding_gst);
                    }
                }

                $object->total_tcs_amount_product = $object_product->tcs_amount_product;
                $object->total_tds_amount_product = $object_product->tds_amount_product;

                $object->seller_earned = ($object->total_price / 100) - $object->total_commission_amount;
                // var_dump($object->total_price_without_gst);
                // ;
                $object->seller_gst_rate = $object_product->gst_rate;
                array_push($object->products, $object_product);
                array_push($product_seller_details, $object);
            endif;
            // var_dump($cart_item);
        }

        // var_dump($product_seller_details);;


        $seller_settlement = array();
        $total_amount_paid = 0;
        foreach ($product_seller_details as $psd) {
            $object = new stdClass();
            $object->vendorId = $psd->seller_id;
            $object->seller_gst_rate = $psd->seller_gst_rate;


            $gst_number = get_gst_number_by_sellerid($object->vendorId);

            $object->total_tcs_amount_product = $psd->total_tcs_amount_product;
            $object->total_tds_amount_product = $psd->total_tds_amount_product;


            $object->total_amount_with_gst = $psd->total_price;
            $object->total_amount_without_gst = $psd->total_price_without_gst;
            $object->commission_rate = $psd->seller_commission_rate;
            $object->commission_amount = round($object->total_amount_without_gst * ($object->commission_rate / 100));
            $object->commission_amount_gst = round($object->commission_amount * 0.18);
            $object->commission_amount_with_gst = round($object->commission_amount_gst + $object->commission_amount);


            $object->amount = $psd->seller_earned;


            // $cod_charges = 0;
            // $cod_charges_without_gst = ($this->get_charges_seller_wise($object->vendorId, $order_id))->Sup_cod_cost;
            $cod_charges_without_gst = 0;
            $cod_charges_with_gst = $cod_charges_without_gst + (0.18 * $cod_charges_without_gst);
            $cod_charges_with_product_gst = ($this->get_charges_seller_wise($object->vendorId, $order_id))->total_cod_cost;
            $shipping_cod_gst_rate = ($this->get_charges_seller_wise($object->vendorId, $order_id))->shipping_cod_gst_rate;
            $cod_charges_without_product_gst = $cod_charges_with_product_gst - (($shipping_cod_gst_rate / 100) * $cod_charges_with_product_gst);
            $cod_charges_shiprocket = $cod_charges_without_product_gst + (0.18 * $cod_charges_without_product_gst);
            $cod_inc_gst_in_invoice = $cod_charges_without_product_gst + (($shipping_cod_gst_rate / 100) * $cod_charges_without_product_gst);


            $object->cod_charges_without_gst = $cod_charges_without_product_gst;
            if ($object->seller_gst_rate == 0) {
                $object->cod_charge = $object->cod_charges_without_gst;
            } elseif ($object->seller_gst_rate != 0) {
                $object->cod_charge = $cod_charges_shiprocket;
            }
            $object->shipping = 0;
            $object->shipping_charge_to_gharobaar = 0;
            $object->shipping_charge_with_gst = 0;
            $object->shipping_tax_charge = 0;
            $object->supplier_shipping_cost_with_gst = 0;
            foreach ($shipping_detail as $ship_detail) {
                if ($psd->seller_id == $ship_detail->SupplierId) {
                    $object->shipping = ($ship_detail->Supplier_Shipping_cost);
                    $object->shipping_tax_charge = ($ship_detail->shipping_tax_charges);
                    $object->shipping_charge_with_gst = ($object->shipping) + ($object->shipping_tax_charge);
                    // var_dump($object->shipping);

                    $object->supplier_shipping_cost_with_gst = ($ship_detail->Supplier_Shipping_cost_with_gst);

                    $object->shipping_charge_to_gharobaar = $object->supplier_shipping_cost_with_gst;
                }
            }
            // var_dump($object->shipping_charge_to_gharobaar);
            // die();


            // condition for shipping slabs
            $slab = true;
            // if ($slab == true) {
            //     if ($object->total_amount_with_gst >= 50000) {
            //         $object->shipping_charge_to_gharobaar = ($object->shipping) + (0.18 * $object->shipping);
            //         var_dump($object->shipping_charge_to_gharobaar);
            //         die();
            //     } else if ($object->total_amount_with_gst >= 200000) {
            //         $object->shipping_charge_to_gharobaar = 0;
            //     }
            // }
            if ($slab == true) {
                if ($object->total_amount_with_gst > 0 && $object->total_amount_with_gst < 100000) {
                    $object->shipping_charge_to_gharobaar = ($object->shipping) + (0.18 * $object->shipping);
                } else if ($object->total_amount_with_gst >= 100000) {
                    $object->shipping_charge_to_gharobaar = 0;
                }
            }
            // condition end

            // ;
            // var_dump("asgha");
            // var_dump($object->shipping_charge_to_gharobaar);
            // die();
            if (!empty($pan_number)) {
                if ($pan_forth_char[3] == 'P' || $pan_forth_char[3] == 'H') {
                    $object->tds_amount_shipping = 0;
                    $object->total_tds_cod = 0;
                    $object->tds_amount_shipping_huf_ind = 0.01 * ($object->shipping);
                    $object->total_tds_cod_huf_ind = 0.01 * $object->cod_charges_without_gst;
                } else {
                    $object->tds_amount_shipping = 0.01 * ($object->shipping);
                    $object->total_tds_cod = 0.01 * $object->cod_charges_without_gst;
                }
            } else {
                $object->tds_amount_shipping = 0.05 * ($object->shipping);
                $object->total_tds_cod = 0.05 * $object->cod_charges_without_gst;
            }


            if ($object->total_tcs_amount_product == 0) {
                $object->total_tcs_shipping = 0;
                $object->total_tcs_cod = 0;
            } elseif ($object->total_tcs_amount_product != 0) {
                $object->total_tcs_shipping = ($object->shipping) * 0.01;
                $object->total_tcs_cod = 0.01 * $object->cod_charges_without_gst;
            }

            $object->tcs_amount = $object->total_tcs_amount_product + $object->total_tcs_shipping + $object->total_tcs_cod;


            $object->tds_amount = $object->total_tds_amount_product + $object->tds_amount_shipping + $object->total_tds_cod;
            // var_dump($object->cod_charge);
            // echo "</br>";
            // var_dump($object->shipping_charge_to_gharobaar);
            // echo "</br>";
            // var_dump($object->tcs_amount);
            // echo "</br>";
            // var_dump($object->commission_amount_with_gst);
            // echo "</br>";
            // var_dump($object->tds_amount);
            // echo "</br>";

            $object->total_deduction = round($object->cod_charge + $object->shipping_charge_to_gharobaar + $object->tcs_amount + $object->commission_amount_with_gst + $object->tds_amount);

            $object->net_seller_payable = round($object->total_amount_with_gst + $cod_inc_gst_in_invoice + $object->shipping_charge_with_gst - $object->total_deduction);


            $total_amount_paid += $object->net_seller_payable;

            $object->payment_mode = $payment_mode;
            $object->order_id = $order_id;

            array_push($seller_settlement, $object);
        }
        $new_seller_settlement = array();

        foreach ($seller_settlement as $ss) {
            $object = new stdClass();
            $object->vendorId = $ss->vendorId;
            $object->amount =  $ss->net_seller_payable / 100;
            array_push($new_seller_settlement, $object);
        }
        // var_dump(json_encode($new_seller_settlement));

        $save_payment = $seller_settlement;
        foreach ($save_payment as $sp) {
            $this->order_model->save_cod_seller_payable($sp);
        }
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

    //update coupon redemption
    public function add_coupon_redeem_details($order_id, $cart_total)
    {
        $order_id = clean_number($order_id);
        if (!empty($cart_total->applied_coupon_product_ids)) :
            $final_data = array();
            foreach ($cart_total->applied_coupon_product_ids as $prod_id) :
                $data = array(
                    'order_id' => $order_id,
                    'offer_id' => $cart_total->applied_coupon_id,
                    'total_discount' => $cart_total->applied_coupon_discount,
                    'op_id' => $prod_id
                );
                array_push($final_data, $data);
            endforeach;
            $this->db->insert_batch('offer_redemptions', $final_data);
        else :
            $data = array(
                'order_id' => $order_id,
                'offer_id' => $cart_total->applied_coupon_id,
                'total_discount' => $cart_total->applied_coupon_discount
            );
            $this->db->insert('offer_redemptions', $data);
        endif;
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
                    <b>order number</b> : #" . $order_id . " <br>
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
                        'subject' => "Your order has been accepted",
                        'email_content' => "Dear " . get_user($order_product->buyer_id)->first_name . ", 
                        <br> Thanks you for placing the following order <br> 
                         <b>order number</b> : #" . $order_id . " <br>
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
                        $user = get_user($this->auth_user->id);
                        $data["buyer_type"] = $user->user_type;
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



                    if ($this->general_settings->flat_ship_enable == 1) {

                        $data2 = array();
                        $data2['order_id'] = $order_id;
                        $data2['seller_id'] = $product->user_id;
                        $data2['product_shipping_cost'] = $data['product_shipping_cost'];
                        $data2['shipping_igst'] = $data['shipping_igst'];
                        $data2['shipping_cgst'] = $data['shipping_cgst'];
                        $data2['shipping_sgst'] = $data['shipping_sgst'];

                        $data['product_shipping_cost'] = 0;
                        $data['shipping_igst'] = 0;
                        $data['shipping_cgst'] = 0;
                        $data['shipping_sgst'] = 0;


                        $data['is_order_flat_ship'] = 1;
                    }
                }

                // $data["product_total_price"] = $cart_item->unit_price + $price_shipping;

                $this->db->insert('order_products', $data);
                if ($this->general_settings->flat_ship_enable == 1) {
                    $this->db->insert('applicable_cod_ship_charge', $data2);
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
            'signature' => "",
            'cashfree_order_id' => $data_transaction["cashfree_order_id"],
            'paymentOption' => $data_transaction["paymentOption"],
            'paymentCode' => $data_transaction["paymentCode"],
            'paymentModes' => $data_transaction["paymentModes"]
        );
        if ($this->auth_check) {
            $data["user_id"] = $this->auth_user->id;
            $data["user_type"] = "registered";
            $user = get_user($this->auth_user->id);
            $data["user_type"] = $user->user_type;
        }
        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if ($this->db->insert('transactions', $data)) {
            //add invoice
            $this->add_invoice($order_id);
            if ($this->general_settings->enable_easysplit == 1) {
                $this->update_net_seller_payable($data_transaction["cashfree_order_id"]);
            } else if ($this->general_settings->enable_easysplit == 0) {
                $this->update_cashfree_payout_complete($data_transaction["cashfree_order_id"]);
            }
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
    public function update_cashfree_payout_complete($cashfree_order_id)
    {
        $data = array(
            'is_completed' => "1"
        );
        $this->db->where('cashfree_order_id', $cashfree_order_id);
        $this->db->update('cashfree_seller_payout', $data);
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
            $user = get_user($this->auth_user->id);
            $data["user_type"] = $user->user_type;
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

    //get processing orders count
    public function get_processing_order_products_count($user_id)
    {
        $this->db->select('order_status');
        $this->db->where('seller_id', $user_id);
        $this->db->where('order_status', 'processing');
        $query = $this->db->get('order_products');
        return $query->result();
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


    public function shiprocket_response_admin($id, $order_id, $product_id, $product_weight)
    {

        // $order_product_ids = $this->input->post('order_product_id', true);
        // $product_ids = $this->input->post('product_id', true);
        //var_dump(count($product_ids));
        $order_id = $order_id;
        $shipment_details = $this->get_stat_shipment($order_id, $product_id);
        if (empty($shipment_details)) {
            $orders = get_order($order_id);
            if ($orders->payment_method == 'Cashfree') {
                $cod = 0;
            } else {
                $cod = 1;
            }
            // for ($j = 0; $j < count($product_ids); $j++) {
            $data = array(
                'order_id' => $order_id,
                'product_id' => $product_id,
                'order_product_id' => $id,
                'reference_order_id' => "-",
                'shipment_order_id' => "-",
                'shipment_id' => "-",
                'awb_code' => "-",
                'pickup_scheduled_date' => "-",
                'manifest_url' => "-",
                'label_url' => "-",
                'courier_company_name' => "-",
                'courier_company_id' => "-",
                'applied_weight' => $product_weight,
                'pickup_token_number' => "-",
                'COD' => $cod,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'shipping_company_status' => 'admin'

            );
            if ($this->auth_check) {

                $data['created_by'] = $this->auth_user->id;
                $data['updated_by'] = $this->auth_user->id;
            } else {
                if (empty($data['created_by'])) {
                    return false;
                }
            }
            if ($data['awb_code'] == '') {
                $data['is_active'] = 0;
            }
            $this->db->insert('shiprocket_order_details', $data);
            // $this->update_shiprocket_status($data["order_id"], $product_ids[$j]);
            if ($data['awb_code'] == '') {
                return false;
            } else {
                return true;
            }
        }
        // }

        // for ($i = 0; $i < count($product_ids); $i++) {


        // }
    }
    //shiprocket-response

    public function shiprocket_response()
    {

        $order_product_ids = $this->input->post('order_product_id', true);
        $product_ids = $this->input->post('product_id', true);
        //var_dump(count($product_ids));

        for ($j = 0; $j < count($product_ids); $j++) {
            $data = array(
                'order_id' => trim($this->input->post('order_id', true)),
                'product_id' => $product_ids[$j],
                'order_product_id' => $order_product_ids[$j],
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
                'updated_at' => date("Y-m-d H:i:s"),
                'shipping_company_status' => 'shiprocket'

            );
            if ($this->auth_check) {

                $data['created_by'] = $this->auth_user->id;
                $data['updated_by'] = $this->auth_user->id;
            } else {
                if (empty($data['created_by'])) {
                    return false;
                }
            }
            if ($data['awb_code'] == '') {
                $data['is_active'] = 0;
                return false;
            }
            $this->db->insert('shiprocket_order_details', $data);
            $this->update_shiprocket_status($data["order_id"], $product_ids[$j]);
        }
        return true;
        // if ($data['awb_code'] == '') {
        //     return false;
        // } else {
        //     return true;
        // }
        // for ($i = 0; $i < count($product_ids); $i++) {


        // }
    }


    public function update_shiprocket_status($order_id, $product_id)
    {
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
    public function get_seller_count_order_products($order_id, $seller_id)
    {
        $this->db->where('order_id', clean_number($order_id));
        $this->db->where('seller_id', clean_number($seller_id));
        $this->db->where('order_status', 'processing');
        $query = $this->db->get('order_products');
        return $query->num_rows();
    }

    //get order product
    public function get_order_product($order_product_id)
    {
        $this->db->where('id', clean_number($order_product_id));
        $query = $this->db->get('order_products');
        return $query->row();
    }
    public function get_qunatity_of_order($order_product_id)
    {
        $sql = "SELECT sum(product_quantity) as quantity FROM order_products where order_id=$order_product_id";
        $query = $this->db->query($sql);
        return $query->result();
        // return $this->db->last_query();
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
                            $this->db->where('id', $order_product->product_id);
                            $product_category = $this->db->get('products')->row();
                            $this->db->where('id', $product_category->category_id);
                            $sub_category_id = $this->db->get('categories')->row();
                            $this->db->where('id', $sub_category_id->parent_id);
                            $categoty_id = $this->db->get('categories')->row();
                            $email_data = array(
                                'source' => '',
                                'source_id' => '',
                                'remark' => "We regret to inform you that the Order for " . $order_product->product_title . " placed vide Order #" . get_order($order_product->order_id)->order_number . " has been cancelled by the seller because the seller did not update the available stock details on the platform.",
                                'event_type' => 'Order Cancellation by Seller',
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
                             <b>Product Unit Price</b> :" . price_formatted($order_product->product_unit_price, $order_product->product_currency) . "<br>
                             You can view similer product by clicking <a href='" . base_url() . $categoty_id->slug . "/" . $sub_category_id->slug . "'>here</a>
                             <br>Team Gharobaar"
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
                                'source' => '',
                                'source_id' => '',
                                'remark' => "We regret to inform you that the Order for " . $order_product->product_title . " placed vide Order #" . get_order($order_product->order_id)->order_number . " has been cancelled by the seller because the suppliers are small scale homeprenuers who are making these products at home with limited means, hence we give them an option to accept/ reject the order, after ascertaining their ability to service it.",
                                'event_type' => 'Order Cancellation by Seller',
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
            $user = get_user($this->auth_user->id);
            $data["user_type"] = $user->user_type;
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

    public function get_return_orders_count($user_id)
    {
        // json_decode(json_encode($this->lookup_model->get_lookup_order_return),true)
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->select('orders.id');
        $this->db->group_by('orders.id');
        $this->db->where('order_products.order_status', 'RTO');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->or_where('order_products.order_status', 'RTO Initiated');
        $this->db->where('order_products.seller_id', clean_number($user_id));

        $this->db->or_where('order_products.order_status', 'RTO In Transit');
        $this->db->where('order_products.seller_id', clean_number($user_id));

        $this->db->or_where('order_products.order_status', 'RTO Delivered');
        $this->db->where('order_products.seller_id', clean_number($user_id));

        $this->db->or_where('order_products.order_status', 'Return Initiated');
        $this->db->where('order_products.seller_id', clean_number($user_id));

        $this->db->or_where('order_products.order_status', 'Return Acknowledged');
        $this->db->where('order_products.seller_id', clean_number($user_id));

        $this->db->or_where('order_products.order_status', 'Return Pending');
        $this->db->where('order_products.seller_id', clean_number($user_id));

        $this->db->or_where('order_products.order_status', 'Return In Transit');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->or_where('order_products.order_status', 'Return Delivered');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->or_where('order_products.order_status', 'Return Picked Up');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->or_where('order_products.order_status', 'Return Pickup Generated');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->or_where('order_products.order_status', 'Return Pickup Queued');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->or_where('order_products.order_status', 'RTO NDR');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->or_where('order_products.order_status', 'RTO OFD');
        $this->db->where('order_products.seller_id', clean_number($user_id));

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
    public function get_return_orders($user_id, $per_page, $offset)
    {
        $this->db->join('orders', 'order_products.order_id = orders.id');
        $this->db->join('users', 'order_products.seller_id = users.id');

        $this->db->select('order_products.order_id,order_products.product_id,order_products.product_title,order_products.product_currency,order_products.order_status,orders.created_at,orders.order_number');

        $this->db->where('order_products.order_status', 'RTO');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->or_where('order_products.order_status', 'RTO Initiated');
        $this->db->where('order_products.seller_id', clean_number($user_id));

        $this->db->or_where('order_products.order_status', 'RTO In Transit');
        $this->db->where('order_products.seller_id', clean_number($user_id));

        $this->db->or_where('order_products.order_status', 'RTO Delivered');
        $this->db->where('order_products.seller_id', clean_number($user_id));

        $this->db->or_where('order_products.order_status', 'Return Initiated');
        $this->db->where('order_products.seller_id', clean_number($user_id));

        $this->db->or_where('order_products.order_status', 'Return Acknowledged');
        $this->db->where('order_products.seller_id', clean_number($user_id));

        $this->db->or_where('order_products.order_status', 'Return Pending');
        $this->db->where('order_products.seller_id', clean_number($user_id));

        $this->db->or_where('order_products.order_status', 'Return In Transit');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->or_where('order_products.order_status', 'Return Delivered');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->or_where('order_products.order_status', 'Return Picked Up');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->or_where('order_products.order_status', 'Return Pickup Generated');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->or_where('order_products.order_status', 'Return Pickup Queued');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->or_where('order_products.order_status', 'RTO NDR');
        $this->db->where('order_products.seller_id', clean_number($user_id));
        $this->db->or_where('order_products.order_status', 'RTO OFD');
        $this->db->where('order_products.seller_id', clean_number($user_id));


        $this->filter_sales();
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('order_products');
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

    public function count_order_products($order_id, $seller_id)
    {
        $sql = "SELECT Count(*) as count from order_products where order_id=$order_id and seller_id=$seller_id and order_status='processing'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function cancel_order_seller($order_id, $data1)
    {
        $order_id = $this->input->post('order_id', true);

        $order_product = $this->order_model->get_order_products($order_id);
        foreach ($order_product as $order_p) {
            $ordered_item_quantity = $order_p->product_quantity;
            $order_item_product_id = $order_p->product_id;
        }




        if (!empty($order_product)) {
            if ($this->auth_user->id == $order_p->seller_id) {
                $data = array(
                    // 'is_approved' => 1,
                    'order_status' => "cancelled_by_seller",
                    'updated_at' => date('Y-m-d H:i:s'),


                );
                $this->increase_product_stock_after_cancel($order_id, $order_item_product_id);
                $this->db->where('order_id', $order_id);
                $this->db->where_in('id', $data1);

                $this->db->update('order_products', $data);
                return true;
            }
            return false;
        }
    }
    public function cancel_order_buyer($order_id, $data1, $reject_reason, $reject_reason_comment1)
    {
        $order_id = $this->input->post('order_id', true);


        $order_product = $this->order_model->get_order_products($order_id);
        foreach ($order_product as $order_p) {
            $ordered_item_quantity = $order_p->product_quantity;
            $order_item_product_id = $order_p->product_id;
        }


        if (!empty($order_product)) {
            if ($this->auth_user->id == $order_p->buyer_id) {
                $data = array(
                    // 'is_approved' => 1,
                    'order_status' => "cancelled_by_user",
                    'updated_at' => date('Y-m-d H:i:s'),
                    'reject_reason' => $reject_reason,
                    'reject_reason_comment' => $reject_reason_comment1

                );
                $this->increase_product_stock_after_cancel($order_id, $order_item_product_id);
                $this->db->where('order_id', $order_id);
                $this->db->where_in('id', $data1);
                $this->db->update('order_products', $data);

                return true;
            }
            return false;
        }
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

    public function get_other_order_status($user_id, $per_page, $offset)
    {
        $this->db->join('orders', 'order_products.order_id=orders.id');
        $data = ['processing', 'awaiting_pickup', 'RTO Initiated', 'RTO Acknowledged', 'RTO Delivered', 'RTO In Transit', 'Return In Transit', 'Return Initiated', 'Return Delivered', 'Return Acknowledged', 'Return Pending', 'Return Pickup Generated', 'Return Pickup Queued', 'Return Picked Up', 'delivered', 'completed', 'shipped', 'cancelled_by_seller', 'cancelled_by_user', 'waiting', 'rejected', 'cancelled', 'RTO NDR', 'RTO OFD'];
        $this->db->select('*');
        $this->db->where_not_in('order_status', $data);
        $this->db->where('seller_id', $this->auth_user->id);
        $this->filter_sales();
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('order_products');
        return $query->result();
    }

    public function get_order_count($user_id)
    {
        $this->db->join('orders', 'order_products.order_id=orders.id');
        $data = ['processing', 'awaiting_pickup', 'RTO Initiated', 'RTO Acknowledged', 'Return Initiated', 'RTO Delivered', 'Return Delivered', 'Return Picked Up', 'RTO In Transit', 'Return In Transit', 'Return Acknowledged', 'Return Pending', 'Return Pickup Generated', 'Return Pickup Queued', 'delivered', 'completed', 'shipped', 'cancelled_by_seller', 'cancelled_by_user', 'waiting', 'rejected', 'cancelled', 'RTO NDR', 'RTO OFD'];
        $this->db->select('orders.id');
        $this->db->where_not_in('order_products.order_status', $data);
        $this->db->where('seller_id', $this->auth_user->id);
        $this->filter_sales();
        $query = $this->db->get('order_products');
        return $query->num_rows();
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
                        // $current_invoice_no = $this->get_invoice_number_by_seller_id($new_item["seller_id"]);
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
                            'invoice_items' => @serialize($invoice_items),
                            'shipping_charges' => $new_item["shipping_charges"],
                            'cod_charges' => $new_item["cod_charges"],
                            'taxes' => $new_item["taxes"],
                            'total_discount' => $new_item["total_discount"],
                            'sub_total' => $new_item["sub_total"],
                            'total_amount' => $new_item["total_amount"],
                            // 'invoice_no' => 'GB/22-23/' . $new_item["seller_id"] . '/' . $current_invoice_no[0]->invoice_seq,
                            // 'invoice_seq' => $current_invoice_no[0]->invoice_seq,
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

    public function get_user_order_history($buyer_id, $order_id)
    {
        $buyer_id = clean_number($buyer_id);
        $this->db->where('buyer_id', $buyer_id);
        // $this->db->where("(order_products.order_status = 'completed' OR order_products.order_status = 'cancelled')");
        $this->db->where("(order_products.order_status = 'completed')");
        $this->db->where_not_in('order_products.order_id', $order_id);
        $this->db->order_by('order_products.created_at', 'DESC');
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



                if ($this->general_settings->flat_ship_enable == 1) {

                    $data2['product_shipping_cost'] = $data['product_shipping_cost'];
                    $data2['shipping_igst'] = $data['shipping_igst'];
                    $data2['shipping_cgst'] = $data['shipping_cgst'];
                    $data2['shipping_sgst'] = $data['shipping_sgst'];
                    $data2["total_shipping_cost"] = $data["total_shipping_cost"];
                    $data2['product_shipping_cost'] = $data['product_shipping_cost'];

                    $data['shipping_igst'] = 0;
                    $data['shipping_cgst'] = 0;
                    $data['shipping_sgst'] = 0;
                    $data["total_shipping_cost"] = 0;
                    $data['product_shipping_cost'] = 0;

                    $this->db->where("seller_id", $sup->SupplierId);
                    $this->db->where("order_id", $order_id);
                    $this->db->update("applicable_cod_ship_charge", $data2);
                }

                if ($this->general_settings->flat_cod_enable == 1) {
                    $data2['cod_igst'] =  $data['cod_igst'];
                    $data2['cod_cgst'] = $data['cod_cgst'];
                    $data2['cod_sgst'] = $data['cod_sgst'];
                    $data2["total_cod_charges"] = $data["total_cod_charges"];
                    $data2['product_cod_charges'] = $data['product_cod_charges'];



                    $data['cod_igst'] = 0;
                    $data['cod_cgst'] = 0;
                    $data['cod_sgst'] = 0;
                    $data["total_cod_charges"] = 0;
                    $data['product_cod_charges'] = 0;

                    $this->db->where("seller_id", $sup->SupplierId);
                    $this->db->where("order_id", $order_id);
                    $this->db->update("applicable_cod_ship_charge", $data2);
                }


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
        $cart_items = $this->cart_model->get_sess_cart_items();
        $cart_total = $this->cart_model->get_sess_cart_total();
        if ($Supp_ship_data) {
            foreach ($Supp_ship_data as $sup) {
                $seller_address = get_user($sup->SupplierId);
                $title = "";

                if (!empty($cart_items)) {
                    $i = 1;
                    $count = count($cart_items);
                    foreach ($cart_items as $cart_item) {
                        $product = get_active_product($cart_item->product_id);
                        if ($sup->SupplierId == $product->user_id) {
                            $seller_address = get_seller($product->user_id);
                            $num_days = (int)(($product->lead_days) * 24 * 60 * 60);
                            $num_hours = (int)(($product->lead_time) * 60 * 60);
                            $product_details = $this->product_model->get_product_details_by_id($cart_item->product_id);
                            $title .= $product_details->title;
                            if ($i != $count) {
                                $title .= ",";
                                $i++;
                            }
                        }
                    }
                }

                // var_dump($prod_amount_af_disc);
                // die();
                $data = array(
                    'order_id' => $order_id,
                    'seller_id' => $sup->SupplierId,
                    "sup_shipping_cost" => $sup->Supplier_Shipping_cost,
                    "Sup_cod_cost" => $sup->cod_charges,
                    "shipping_cod_gst_rate" => $sup->shipping_cod_gst_rate,
                    'sup_subtotal' => intval($sup->total_product_price_without_gst),
                    'Sup_subtotal_prd_gst' => intval($sup->total_product_gst),
                    'Sup_total_prd' => $sup->total_product_price,
                    'Sup_Shipping_gst' => $sup->shipping_tax_charges,
                    'Sup_cod_gst' => $sup->cod_tax_charges,
                    'created_by' => 1,
                    'updated_by' => 1,
                    'prod_amount_after_disc' => round($sup->prod_amount_af_disc)
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
                $order_number = get_order($order_id);
                $arr = [$title, $order_number->order_number];
                $passed_data = '"' . implode('","', $arr) . '"';
                $required_data = array(
                    "from" => "918287606650",
                    "to" => "91$seller_address->phone_number",
                    "type" => "mediatemplate",
                    "channel" => "whatsapp",
                    "template_name" => "order_receive",
                    "params" => $passed_data,
                    "param_url" => "dashboard/sale" . "/" . $order_number->order_number
                );
                if ($this->general_settings->send_whatsapp == 1) {
                    $this->notification_model->whatsapp($required_data);
                }
                $data["total_shipping_cost"] = $data["sup_shipping_cost"] + $data['Sup_Shipping_gst'];
                $data["total_cod_cost"] = $data["Sup_cod_cost"] + $data['Sup_cod_gst'];
                $data['grand_total_amount'] = $data["Sup_total_prd"] + $data["total_shipping_cost"] + $data["total_cod_cost"];
                $this->db->insert('order_supplier', $data);
            }
        }
    }

    // function to get the invoice  number
    public function get_invoice_number_by_seller_id($seller_id)
    {
        $this->db->select('invoice_seq');
        $this->db->where('id', $seller_id);
        $query = $this->db->get('users');
        return $query->result();
    }
    // function to update the invoice seq number
    public function update_invoice_number_by_seller_id($seller_id, $seq_number)
    {
        $data = array(
            'invoice_seq' => $seq_number + 1
        );
        $this->db->where('id', $seller_id);
        $this->db->update('users', $data);
    }
    public function update_gb_invoice_seq($current_gb_invoice_seq)
    {
        $data = array(
            'gb_invoice_seq' => $current_gb_invoice_seq
        );
        $this->db->update('general_settings', $data);
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

        if ($this->general_settings->shiprocket_check == 1) {

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
            // die();
            // $shipping_data = array(
            //     'actual_shipping_charges' => json_decode($response)->data->available_courier_companies[0]->rate * 100,
            //     'cod_charges' => json_decode($response)->data->available_courier_companies[0]->cod_charges * 100,
            //     'freight_charges' => json_decode($response)->data->available_courier_companies[0]->freight_charge * 100,
            // );
            // var_dump(json_decode($response)->data);
            $shipping_data = array(
                'actual_shipping_charges_with_gst' => intval((json_decode($response)->data->available_courier_companies[0]->rate) * 100),
                'actual_shipping_charges' => intval((json_decode($response)->data->available_courier_companies[0]->rate / (1 + (18 / 100))) * 100),
                'cod_charges' => intval((json_decode($response)->data->available_courier_companies[0]->cod_charges  / (1 + (18 / 100))) * 100),
                'freight_charges' => intval((json_decode($response)->data->available_courier_companies[0]->freight_charge  / (1 + (18 / 100))) * 100),
            );
            // var_dump($shipping_data);
            // die();
            $this->session->set_userdata($shipping_data);
            // $shipping_cost = $shipping_data['actual_shipping_charges'] * 100;

            return $shipping_data;
        }
    }


    public function get_actual_shipping_chargesonschedule($pickuppostcode, $deliverypostcode, $cashond, $weightobject)
    {

        // if ($this->general_settings->shiprocket_check == 1) {

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
        // die();
        // $shipping_data = array(
        //     'actual_shipping_charges' => json_decode($response)->data->available_courier_companies[0]->rate * 100,
        //     'cod_charges' => json_decode($response)->data->available_courier_companies[0]->cod_charges * 100,
        //     'freight_charges' => json_decode($response)->data->available_courier_companies[0]->freight_charge * 100,
        // );
        // var_dump(json_decode($response)->data);
        $shipping_data = array(
            'actual_shipping_charges_with_gst' => intval((json_decode($response)->data->available_courier_companies[0]->rate) * 100),
            'actual_shipping_charges' => intval((json_decode($response)->data->available_courier_companies[0]->rate / (1 + (18 / 100))) * 100),
            'cod_charges' => intval((json_decode($response)->data->available_courier_companies[0]->cod_charges  / (1 + (18 / 100))) * 100),
            'freight_charges' => intval((json_decode($response)->data->available_courier_companies[0]->freight_charge  / (1 + (18 / 100))) * 100),
        );
        // var_dump($shipping_data);
        // die();
        $this->session->set_userdata($shipping_data);
        // $shipping_cost = $shipping_data['actual_shipping_charges'] * 100;

        return $shipping_data;
        // }
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
    public function get_order_price($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);

        return $this->db->get('orders')->result();
    }

    public function supplier_count($order_number)
    {

        $order_number = clean_number($order_number);
        $this->db->where('order_id', $order_number);

        return $this->db->get('order_products')->result();
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

        //creating product list seller wise

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

        //check the cart items are deliverable or not
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


        //calculation of shipping charges as per different sellers
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
                    if ($this->general_settings->shiprocket_check == 1) {

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
                        // if ($psd->total_price >= 100000) {
                        //     $actual_shipping_charges = array(
                        //         "freight_charges" => 0
                        //     );
                        //     if (!$cod) {
                        //         $actual_shipping_charges["cod_charges"] = 0;
                        //     } else {
                        //         $actual_shipping_charges["cod_charges"] = (50) * 100;
                        //     }
                        //     $tax_charges = intval((($actual_shipping_charges["freight_charges"] + $actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100)));
                        //     $actual_shipping_charges["tax_charges"] = $tax_charges;
                        // } elseif ($psd->total_price >= 0 && $psd->total_price < 100000) {
                        //     $actual_shipping_charges = array(
                        //         "freight_charges" => 10000
                        //     );
                        //     if (!$cod) {
                        //         $actual_shipping_charges["cod_charges"] = 0;
                        //     } else {
                        //         $actual_shipping_charges["cod_charges"] = (50) * 100;
                        //     }
                        //     $tax_charges = (($actual_shipping_charges["freight_charges"] + $actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                        //     $actual_shipping_charges["tax_charges"] = $tax_charges;
                        // } else {
                        //     $actual_shipping_charges = $this->order_model->get_actual_shipping_charges($psd->product_pickup_code,   $psd->delivery_code, $cod,  $psd->total_weight / 1000);
                        //     $tax_charges = (($actual_shipping_charges["freight_charges"] + $actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                        //     $actual_shipping_charges["tax_charges"] = $tax_charges;
                        // }
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
            // }
        }

        $ship_data_copy = json_encode($supp_data_array_copy);
        // echo ($ship_data_copy);
        // die();
        // echo $ship_data_copy;
        return $ship_data_copy;
    }

    // FUNCTION: Calc_total_shipping_charges 
    public function calc_total_shipping_charges_by_seller($s_row, $s_col, $cp_count)
    {
        $cart_items = $this->cart_model->get_sess_cart_items();
        $cart_total = $this->cart_model->get_sess_cart_total();

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
                    $coupon_assignment_details = $this->offer_model->get_coupon_details_by_code($cart_total->applied_coupon_id);
                    foreach ($coupon_assignment_details as $cad) :
                        $coupon_source_type = $cad->source_type;
                        $coupon_source_id = $cad->source_id;
                        break;
                    endforeach;

                    if ($coupon_source_type == 'Product') {
                        if ($coupon_source_id == $cart_item->product_item) {
                            $discountamount = $cart_total->applied_coupon_discount;
                            $discountperc = $discountamount / $object_product->product_total_price * 100;
                            // var_dump($sup->total_product_price);
                            // var_dump($discountperc);
                            // die();
                            $psd->prod_amount_af_disc = $object_product->product_total_price - ($object_product->product_total_price * $discountperc / 100);
                        }
                    } else {
                        $discountamount = $cart_total->applied_coupon_discount;
                        $discountperc = $discountamount / ($cart_total->total_price + $discountamount) * 100;
                        // var_dump($sup->total_product_price);
                        // var_dump($discountperc);
                        // die();
                        $psd->prod_amount_af_disc = $psd->total_price - ($psd->total_price * $discountperc / 100);
                    }
                    $psd->prod_amound_af_disc = $psd->prod_amount_af_disc;
                    $psd->product_total_price_without_gst += $object_product->product_total_price / (1 + ($object_product->product_gst_rate / 100));
                    $psd->total_product_gst += $object_product->product_total_price - $object_product->product_total_price / (1 + ($object_product->product_gst_rate / 100));

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
                $object->product_total_price_without_gst = $object_product->product_total_price / (1 + ($object_product->product_gst_rate / 100));
                $object->total_product_gst = $object_product->product_total_price - $object_product->product_total_price / (1 + ($object_product->product_gst_rate / 100));
                $object->prod_amount_af_disc = $object->total_price;
                // var_dump($cart_total->applied_coupon_id);
                // die();
                $coupon_assignment_details = $this->offer_model->get_coupon_details_by_code($cart_total->applied_coupon_code);
                // var_dump($coupon_assignment_details);
                // die();
                if ($coupon_assignment_details) {
                    foreach ($coupon_assignment_details as $cad) :
                        $coupon_source_type = $cad->source_type;
                        $coupon_source_id = $cad->source_id;
                        break;
                    endforeach;
                    if ($coupon_source_type == 'Product') {
                        if ($coupon_source_id == $cart_item->product_item) {
                            $discountamount = $cart_total->applied_coupon_discount;
                            $discountperc = $discountamount / $object_product->product_total_price * 100;
                            // var_dump($sup->total_product_price);
                            // var_dump($discountperc);
                            // die();
                            $object->prod_amount_af_disc = $object_product->product_total_price - ($object_product->product_total_price * $discountperc / 100);
                        }
                    } else {
                        $discountamount = $cart_total->applied_coupon_discount;
                        $discountperc = $discountamount / ($cart_total->total_price + $discountamount) * 100;
                        // var_dump($sup->total_product_price);
                        // var_dump($discountperc);
                        // die();
                        $object->prod_amount_af_disc = $object_product->product_total_price - ($object_product->product_total_price * $discountperc / 100);
                    }
                }
                $object->prod_amount_af_disc = $object->prod_amount_af_disc;
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
            // var_dump($psd);
            // die();
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
                        "total_product_gst" => 0,
                        'prod_amount_af_disc' => $psd->prod_amount_af_disc
                    );

                    //product wise calculation price and gst
                    $suppqq["total_product_price"] = $psd->total_price;
                    $suppqq["total_product_price_without_gst"] = $psd->product_total_price_without_gst;
                    $suppqq["total_product_gst"] = $psd->total_product_gst;


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
                            $actual_shipping_charges = array(
                                "freight_charges" => 0
                            );
                            $actual_shipping_charges["cod_charges"] = 0;

                            // $actual_shipping_charges = $this->order_model->get_actual_shipping_charges($psd->product_pickup_code,   $psd->delivery_code, $cod,  $psd->total_weight / 1000);
                            $tax_charges = (($actual_shipping_charges["freight_charges"] + $actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                            $actual_shipping_charges["tax_charges"] = $tax_charges;
                        }
                    // if ($psd->total_price >= 100000) {
                    //     $actual_shipping_charges = array(
                    //         "freight_charges" => 0
                    //     );
                    //     if (!$cod) {
                    //         $actual_shipping_charges["cod_charges"] = 0;
                    //     } else {
                    //         $actual_shipping_charges["cod_charges"] = (50) * 100;
                    //     }
                    //     $tax_charges = intval((($actual_shipping_charges["freight_charges"] + $actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100)));
                    //     $actual_shipping_charges["tax_charges"] = $tax_charges;
                    // } elseif ($psd->total_price >= 0 && $psd->total_price < 100000) {
                    //     $actual_shipping_charges = array(
                    //         "freight_charges" => 10000
                    //     );
                    //     if (!$cod) {
                    //         $actual_shipping_charges["cod_charges"] = 0;
                    //     } else {
                    //         $actual_shipping_charges["cod_charges"] = (50) * 100;
                    //     }
                    //     $tax_charges = (($actual_shipping_charges["freight_charges"] + $actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                    //     $actual_shipping_charges["tax_charges"] = $tax_charges;
                    // } else {
                    //     $actual_shipping_charges = $this->order_model->get_actual_shipping_charges($psd->product_pickup_code,   $psd->delivery_code, $cod,  $psd->total_weight / 1000);
                    //     $tax_charges = (($actual_shipping_charges["freight_charges"] + $actual_shipping_charges["cod_charges"]) * (floatval($psd->seller_gst_rate) / 100));
                    //     $actual_shipping_charges["tax_charges"] = $tax_charges;
                    // }
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
                        "total_product_gst" => 0,
                        'prod_amount_af_disc' => $psd->prod_amount_af_disc
                    );

                    //product wise calculation price and gst

                    $suppqq["total_product_price"] = $psd->total_price;
                    $suppqq["total_product_price_without_gst"] = $psd->product_total_price_without_gst;
                    $suppqq["total_product_gst"] = $psd->total_product_gst;

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
                        "total_product_gst" => 0,
                        'prod_amount_af_disc' => $psd->prod_amount_af_disc

                    );


                    //product wise calculation price and gst

                    $suppqq["total_product_price"] = $psd->total_price;
                    $suppqq["total_product_price_without_gst"] = $psd->product_total_price_without_gst;
                    $suppqq["total_product_gst"] = $psd->total_product_gst;


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

    public function check_exhibition_enabled($c_items)
    {
        $c_items = $this->cart_model->get_sess_cart_items();
        $enabled = true;

        foreach ($c_items as $c_item) {
            $enable = $this->product_model->check_exhibition_enabled($c_item->product_id);
            if (!$enable) {
                $enabled = false;
                break;
            }
        }

        return $enabled;
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
    public function get_awb_code($order_id, $product_id)
    {
        $order_id = clean_number($order_id);
        $product_id = clean_number($product_id);
        $this->db->where('order_id', $order_id);
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('shiprocket_order_details');
        return $query->result();
    }

    public function get_awb_code_by_order($order_number)
    {
        $order_number = clean_number($order_number);
        $this->db->where('order_number', $order_number);
        //$this->db->get('orders');
        //$this->db->select('shiprocket_order_details.*');
        $this->db->join('orders', 'shiprocket_order_details.order_id = orders.id');
        return $this->db->get('shiprocket_order_details')->result();
    }

    public function get_order_details_by_id($order_id)
    {
        $order_id = clean_number($order_id);
        $this->db->where('id', $order_id);
        $query = $this->db->get('orders');
        return $query->row();
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

    public function update_flag_shipped($awb)
    {
        $sql = "UPDATE shiprocket_order_details SET is_shipped_active = 1
WHERE awb_code IN (
  SELECT awb_code FROM (
    SELECT awb_code FROM shiprocket_order_details where awb_code ='$awb' group by created_by,awb_code
  ) sod
)";
        $query = $this->db->query($sql);
        return true;
    }

    public function get_msg_send_status($awb)
    {
        $sql = "SELECT is_shipped_active FROM shiprocket_order_details  where awb_code = '$awb'";
        $query = $this->db->query($sql);
        return  $query->row();
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
    public function get_stat_shipment($order_id, $product_id)
    {

        $order_id = clean_number($order_id);
        $this->db->where('order_id', $order_id);
        $this->db->where('product_id', $product_id);
        $this->db->where('is_active', 1);
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
    public function get_seller_id_by_awb($awb)
    {
        $this->db->where('awb_code', $awb);
        $this->db->where('is_active', 1);
        $query = $this->db->get('shiprocket_order_details');
        if (empty($query->row())) {
            return false;
        } else {
            return $query->row()->created_by;
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
    public function get_products_order($order_id, $seller_id)
    {
        $order_id = clean_number($order_id);
        $this->db->where('order_id', $order_id);
        $this->db->where('seller_id', $seller_id);
        $query = $this->db->get('order_products');
        return $query->result();
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
    // online payment payouts:
    public function save_cashfree_seller_payable_payouts($data)
    {
        $this->db->insert('cashfree_seller_payout', $data);
    }

    // get cod charges by order id and seller id
    public function get_charges_seller_wise($sellerid, $order_id)
    {
        $this->db->where('order_id', $order_id);
        $this->db->where('seller_id', $sellerid);
        $query = $this->db->get('order_supplier');
        return $query->row();
    }

    // insert cod seller payable
    public function save_cod_seller_payable($data)
    {
        $this->db->insert('cod_seller_payable', $data);
    }
    public function get_product_slug_value($product_id)
    {
        $this->db->select('slug');
        $this->db->where('id', $product_id);
        $query = $this->db->get('products');
        return $query->row();
    }

    // get cod charges by order id and seller id
    public function fetch_cod_seller_payable($from_date, $to_date)
    {
        $to_date = $to_date . " 23:59:59";

        $sql = "SELECT distinct
        `a`.`order_id`,
        `a`.`net_seller_payable`,
        `e`.`grand_total_amount`,
        `e`.`Sup_Shipping_gst`,
        `e`.`Sup_cod_gst`,
        `e`.`Sup_subtotal_prd_gst`,
        `a`.`shipping_charge_to_gharobaar`,
        `a`.`cod_charge`,
        `b`.`shop_name`,
        `b`.`id`,

        `b`.`phone_number`,
        `b`.`email`,
        `b`.`account_number`,
        `b`.`acc_holder_name`,
        `b`.`ifsc_code`,

        `c`.`created_at`,
        `c`.`order_number`,
        (  
         CASE 
        WHEN `e`.`status` IS NULL OR `e`.`status`  THEN 'pending'
        WHEN `e`.`status` IS NOT NULL THEN `e`.`status`
        END)as 'order_status'
        -- `e`.`status` as 'order_status'
     
    FROM
        `cod_seller_payable` `a`
            JOIN
        `users` `b` ON `b`.`id` = `a`.`vendorId`
            JOIN
        `orders` `c` ON `c`.`id` = `a`.`order_id`
            
        JOIN
        `order_supplier` `e` ON `a`.`order_id` = `e`.`order_id`
        WHERE
        `a`.`vendorId` = `e`.`seller_id`
        AND `c`.`created_at` >= STR_TO_DATE('$from_date', '%Y-%m-%d %k:%i:%s')
            AND `c`.`created_at` <= STR_TO_DATE('$to_date', '%Y-%m-%d %k:%i:%s')
            AND `a`.`payout_initiated`='0' AND `a`.`is_active`='1'";



        // $this->db->get();
        // return $this->db->last_query();

        $query = $this->db->query($sql);
        return $query->result();
    }

    //cod payout initiated
    public function fetch_cod_payout_inititated($from_date, $to_date)
    {
        $to_date = $to_date . " 23:59:59";

        $sql = "SELECT distinct
        `a`.`order_id`,
        `a`.`net_seller_payable`,
        `a`.`referenceId`,
        `a`.`message`,
        `a`.`status`,
        `a`.`subCode`,
        `a`.`batch_transfer_id`,
        `e`.`grand_total_amount`,
        `e`.`Sup_Shipping_gst`,
        `e`.`Sup_cod_gst`,
        `e`.`Sup_subtotal_prd_gst`,
        `a`.`shipping_charge_to_gharobaar`,
        `a`.`cod_charge`,
        `a`.`transfer_id`,
        `b`.`shop_name`,
        `b`.`id`,

        `b`.`phone_number`,
        `b`.`email`,
        `b`.`account_number`,
        `b`.`acc_holder_name`,
        `b`.`ifsc_code`,

        `c`.`created_at`,
        `c`.`order_number`,
        (  
         CASE 
        WHEN `e`.`status` IS NULL OR `e`.`status`  THEN 'pending'
        WHEN `e`.`status` IS NOT NULL THEN `e`.`status`
        END)as 'order_status'
        -- `e`.`status` as 'order_status'
     
    FROM
        `cod_seller_payable` `a`
            JOIN
        `users` `b` ON `b`.`id` = `a`.`vendorId`
            JOIN
        `orders` `c` ON `c`.`id` = `a`.`order_id`
            
        JOIN
        `order_supplier` `e` ON `a`.`order_id` = `e`.`order_id`
        WHERE
        `a`.`vendorId` = `e`.`seller_id`
        AND `c`.`created_at` >= STR_TO_DATE('$from_date', '%Y-%m-%d %k:%i:%s')
            AND `c`.`created_at` <= STR_TO_DATE('$to_date', '%Y-%m-%d %k:%i:%s')
            AND `a`.`payout_initiated`='1' AND `a`.`is_active`='1'";



        // $this->db->get();
        // return $this->db->last_query();

        $query = $this->db->query($sql);
        return $query->result();
    }



    public function update_status_payouts($seller_id, $order_id, $status_code, $refrence_id, $message, $status, $batchid, $payout_charge, $mode, $transfer_id)
    {
        $data = array(
            'payout_initiated' => 1,
            'referenceId' => $refrence_id,
            'message' => $message,
            'status' => $status,
            'subCode' => $status_code,
            'updated_at' => date('Y-m-d H:i:s'),
            'batch_transfer_id' => $batchid,
            'payout_charge' => $payout_charge,
            'transfer_id' => $transfer_id
        );

        $this->db->where('order_id', $order_id);
        $this->db->where('vendorId', $seller_id);
        $this->db->where('is_active', 1);
        if ($mode == 'cod') {
            $this->db->update('cod_seller_payable', $data);
        }
        // cashfree online payment data save for payouts 
        else if ($mode == 'prepaid') {
            $this->db->update('cashfree_seller_payout', $data);
        }
    }

    public function update_orderid_cashfree_prepaid_payouts($cashfree_order_id, $order_id, $active)
    {
        $order_id = clean_number($order_id);
        $data = array(
            'order_id' => $order_id,
            'is_active' => $active
        );
        $this->db->where('cashfree_order_id', $cashfree_order_id);
        $this->db->update('cashfree_seller_payout', $data);
    }

    public function fetch_prepaid_seller_payable($from_date, $to_date)
    {
        $to_date = $to_date . " 23:59:59";

        $sql = "SELECT distinct
        `a`.`order_id`,
        `a`.`net_seller_payable`,
        `a`.`referenceId`,
        `a`.`message`,
        `a`.`status`,
        `a`.`subCode`,
        `a`.`batch_transfer_id`,
        `a`.`gateway_amount_gst`,
        `a`.`gateway_amount`,
        `e`.`grand_total_amount`,
        `e`.`Sup_Shipping_gst`,
        `e`.`Sup_subtotal_prd_gst`,
        `a`.`shipping_charge_to_gharobaar`,
        `b`.`shop_name`,
        `b`.`id`,

        `b`.`phone_number`,
        `b`.`email`,
        `b`.`account_number`,
        `b`.`acc_holder_name`,
        `b`.`ifsc_code`,

        `c`.`created_at`,
        `c`.`order_number`,
        (  
         CASE 
        WHEN `e`.`status` IS NULL OR `e`.`status`  THEN 'pending'
        WHEN `e`.`status` IS NOT NULL THEN `e`.`status`
        END)as 'order_status'
        -- `e`.`status` as 'order_status'
    FROM
        `cashfree_seller_payout` `a`
            JOIN
        `users` `b` ON `b`.`id` = `a`.`vendorId`
            JOIN
        `orders` `c` ON `c`.`id` = `a`.`order_id`
            
        JOIN
        `order_supplier` `e` ON `a`.`order_id` = `e`.`order_id`
        WHERE
        `a`.`vendorId` = `e`.`seller_id`
        AND `c`.`created_at` >= STR_TO_DATE('$from_date', '%Y-%m-%d %k:%i:%s')
            AND `c`.`created_at` <= STR_TO_DATE('$to_date', '%Y-%m-%d %k:%i:%s')
            AND `a`.`payout_initiated`='0' AND `a`.`is_completed`='1' AND `a`.`is_active`='1'";

        $query = $this->db->query($sql);
        return $query->result();
    }

    //prepaide payout initiated
    public function fetch_prepaid_payout_initiated($from_date, $to_date)
    {
        $to_date = $to_date . " 23:59:59";

        $sql = "SELECT distinct
        `a`.`order_id`,
        `a`.`net_seller_payable`,
        `a`.`referenceId`,
        `a`.`message`,
        `a`.`status`,
        `a`.`subCode`,
        `a`.`batch_transfer_id`,
        `a`.`transfer_id`,
        `a`.`gateway_amount_gst`,
        `a`.`gateway_amount`,
        `e`.`grand_total_amount`,
        `e`.`Sup_Shipping_gst`,
        `e`.`Sup_subtotal_prd_gst`,
        `a`.`shipping_charge_to_gharobaar`,
        `b`.`shop_name`,
        `b`.`id`,

        `b`.`phone_number`,
        `b`.`email`,
        `b`.`account_number`,
        `b`.`acc_holder_name`,
        `b`.`ifsc_code`,

        `c`.`created_at`,
        `c`.`order_number`,
        (  
         CASE 
        WHEN `e`.`status` IS NULL OR `e`.`status`  THEN 'pending'
        WHEN `e`.`status` IS NOT NULL THEN `e`.`status`
        END)as 'order_status'
        -- `e`.`status` as 'order_status'
    FROM
        `cashfree_seller_payout` `a`
            JOIN
        `users` `b` ON `b`.`id` = `a`.`vendorId`
            JOIN
        `orders` `c` ON `c`.`id` = `a`.`order_id`
            
        JOIN
        `order_supplier` `e` ON `a`.`order_id` = `e`.`order_id`
        WHERE
        `a`.`vendorId` = `e`.`seller_id`
        AND `c`.`created_at` >= STR_TO_DATE('$from_date', '%Y-%m-%d %k:%i:%s')
            AND `c`.`created_at` <= STR_TO_DATE('$to_date', '%Y-%m-%d %k:%i:%s')
            AND `a`.`payout_initiated`='1' AND `a`.`is_completed`='1' AND `a`.`is_active`='1'";

        $query = $this->db->query($sql);
        return $query->result();
    }


    //get order status count for a perticular order id
    public function get_order_item_count($order_id)
    {
        $sql = "SELECT Count(order_status) as count_val FROM order_products where order_id= $order_id  and order_status not in ('order_rejected','cancelled_by_user','cancelled_by_seller','rejected')";
        $query = $this->db->query($sql);
        $item_count = $query->row();
        $sql1 = "SELECT Count(order_status) as count_val1 FROM order_products where order_id= $order_id  and order_status = 'completed'";
        $query1 = $this->db->query($sql1);
        $order_item_count = $query1->row();
        $sql3 = "SELECT Count(order_status) as count_val2 FROM order_products where order_id= $order_id  and order_status in ('order_rejected','cancelled_by_user','cancelled_by_seller','rejected')";
        $query2 = $this->db->query($sql3);
        $reject_item_count = $query2->row();
        $sql4 = "SELECT Count(order_status) as count_val3 FROM order_products where order_id= $order_id ";
        $query3 = $this->db->query($sql4);
        $total_item_count = $query3->row();

        if ($total_item_count->count_val3 == $reject_item_count->count_val2) {
            $sql2 = "UPDATE orders set status=2 where id = $order_id";
            $query2 = $this->db->query($sql2);
        } elseif ($item_count->count_val == $order_item_count->count_val1) {
            $sql3 = "UPDATE orders set status=1 where id = $order_id";
            $query2 = $this->db->query($sql3);
        }
    }


    public function recal_cod_seller_payable($order_id)
    {
        $order_id = $order_id;

        $order_items = $this->order_model->get_order_products_ex_cancelled($order_id);
        $order_total = $this->order_model->get_order_total($order_id);
        $shipping_detail = $this->order_model->get_shipping($order_id);

        $seller_array = array();
        $amount_array = array();
        $product_seller_details = array();
        $payment_mode = "COD";


        foreach ($order_items as $cart_item) {
            $object = new stdClass();
            $product_details = get_active_product($cart_item->product_id);

            $object->seller_id = $product_details->user_id;

            $pan_number = get_pan_number_by_sellerid($object->seller_id);
            $pan_forth_char = str_split($pan_number);

            $object->seller_commission_rate = calculate_commission_rate_seller($object->seller_id);
            $new = true;
            foreach ($product_seller_details as $psd) {
                if ($psd->seller_id == $object->seller_id) {
                    $object_product = new stdClass();
                    $object_product->product_id = $cart_item->product_id;
                    $object_product->gst_rate = $product_details->gst_rate;
                    $object_product->product_total_price = $cart_item->product_total_price;


                    $gst_cal = 1 + ($object_product->gst_rate / 100);
                    $product_price_excluding_gst = round($object_product->product_total_price / $gst_cal, 0);
                    $amount = $product_price_excluding_gst / 100;
                    $commission = ($object->seller_commission_rate) / 100;
                    $commission_amount_without_round = $amount * $commission;
                    $commission_amount = round($commission_amount_without_round, 2);

                    $object_product->product_price_excluding_gst = $product_price_excluding_gst;

                    $gst_on_commission_amount = $commission_amount * 0.18;
                    $commission_amount_with_gst = $commission_amount + $gst_on_commission_amount;


                    $object_product->product_commission_amount = $commission_amount;
                    $object_product->product_gst_on_commission_amount = round($gst_on_commission_amount, 2);
                    $object_product->product_commission_amount_with_gst = round($commission_amount_with_gst, 2);


                    $psd->total_commission_amount += $object_product->product_commission_amount_with_gst;
                    $psd->total_price += $object_product->product_total_price;
                    $psd->total_price_without_gst += $object_product->product_price_excluding_gst;
                    $psd->seller_earned = ($psd->total_price / 100) - $psd->total_commission_amount;


                    if ($object_product->gst_rate == 0 || $object_product->gst_rate == null) {
                        $object_product->tcs_amount_product = 0;

                        if (!empty($pan_number)) {
                            if ($pan_forth_char[3] == 'P' || $pan_forth_char[3] == 'H') {
                                $object_product->tds_amount_product = 0;
                                $object_product->tds_amount_product_huf_ind = 0.01 * ($object_product->product_total_price);
                            } else {
                                $object_product->tds_amount_product = 0.01 * ($object_product->product_total_price);
                            }
                        } else {
                            $object_product->tds_amount_product = 0.05 * ($object_product->product_total_price);
                        }
                    } elseif ($object_product->gst_rate != 0) {
                        $object_product->tcs_amount_product = $object_product->product_price_excluding_gst * 0.01;
                        if (!empty($pan_number)) {
                            if ($pan_forth_char[3] == 'P' || $pan_forth_char[3] == 'H') {
                                $object_product->tds_amount_product = 0;
                                $object_product->tds_amount_product_huf_ind = 0.01 * ($object_product->product_price_excluding_gst);
                            } else {
                                $object_product->tds_amount_product = 0.01 * ($object_product->product_price_excluding_gst);
                            }
                        } else {
                            $object_product->tds_amount_product = 0.05 * ($object_product->product_price_excluding_gst);
                        }
                    }

                    if (count($psd->products) > 0) {
                        foreach ($psd->products as $prod) {
                            if (floatval($object_product->gst_rate) > floatval($prod->gst_rate)) {
                                $psd->seller_gst_rate = $object_product->gst_rate;
                            }
                        }
                    }

                    $psd->total_tcs_amount_product += $object_product->tcs_amount_product;
                    $psd->total_tds_amount_product += $object_product->tds_amount_product;
                    $psd->total_tds_amount_product_huf_ind += $object_product->tds_amount_product_huf_ind;
                    array_push($psd->products, $object_product);
                    $new = false;
                }
            }
            if ($new) :
                $object->products = array();
                $object_product = new stdClass();
                $object_product->product_id = $cart_item->product_id;
                $object_product->gst_rate = $product_details->gst_rate;
                $object_product->product_total_price = $cart_item->product_total_price;



                $gst_cal = 1 + ($object_product->gst_rate / 100);
                $product_price_excluding_gst = round($object_product->product_total_price / $gst_cal, 0);
                $amount = $product_price_excluding_gst / 100;
                $commission = $object->seller_commission_rate / 100;
                $commission_amount_without_round = $amount * $commission;
                $commission_amount = round($commission_amount_without_round, 2);


                $object_product->product_price_excluding_gst = $product_price_excluding_gst;

                $gst_on_commission_amount = $commission_amount * 0.18;
                $commission_amount_with_gst = $commission_amount + $gst_on_commission_amount;

                $object_product->product_commission_amount = $commission_amount;
                $object_product->product_gst_on_commission_amount = round($gst_on_commission_amount, 2);
                $object_product->product_commission_amount_with_gst = round($commission_amount_with_gst, 2);


                $object->total_commission_amount = $object_product->product_commission_amount_with_gst;
                $object->total_price = $object_product->product_total_price;
                $object->total_price_without_gst = $object_product->product_price_excluding_gst;

                if ($object_product->gst_rate == 0 || $object_product->gst_rate == null) {
                    $object_product->tcs_amount_product = 0;

                    if (!empty($pan_number)) {
                        if ($pan_forth_char[3] == 'P' || $pan_forth_char[3] == 'H') {
                            $object_product->tds_amount_product = 0;
                            $object_product->tds_amount_product_huf_ind = 0.01 * ($object_product->product_total_price);
                        } else {
                            $object_product->tds_amount_product = 0.01 * ($object_product->product_total_price);
                        }
                    } else {
                        $object_product->tds_amount_product = 0.05 * ($object_product->product_total_price);
                    }
                } elseif ($object_product->gst_rate != 0) {
                    $object_product->tcs_amount_product = $object_product->product_price_excluding_gst * 0.01;
                    if (!empty($pan_number)) {
                        if ($pan_forth_char[3] == 'P' || $pan_forth_char[3] == 'H') {
                            $object_product->tds_amount_product = 0;
                            $object_product->tds_amount_product_huf_ind = 0.01 * ($object_product->product_price_excluding_gst);
                        } else {
                            $object_product->tds_amount_product = 0.01 * ($object_product->product_price_excluding_gst);
                        }
                    } else {
                        $object_product->tds_amount_product = 0.05 * ($object_product->product_price_excluding_gst);
                    }
                }

                $object->total_tcs_amount_product = $object_product->tcs_amount_product;
                $object->total_tds_amount_product = $object_product->tds_amount_product;

                $object->seller_earned = ($object->total_price / 100) - $object->total_commission_amount;
                $object->seller_gst_rate = $object_product->gst_rate;
                array_push($object->products, $object_product);
                array_push($product_seller_details, $object);
            endif;
        }
        $seller_settlement = array();
        $total_amount_paid = 0;
        foreach ($product_seller_details as $psd) {
            $object = new stdClass();
            $object->vendorId = $psd->seller_id;
            $object->seller_gst_rate = $psd->seller_gst_rate;


            $gst_number = get_gst_number_by_sellerid($object->vendorId);

            $object->total_tcs_amount_product = $psd->total_tcs_amount_product;
            $object->total_tds_amount_product = $psd->total_tds_amount_product;


            $object->total_amount_with_gst = $psd->total_price;
            $object->total_amount_without_gst = $psd->total_price_without_gst;
            $object->commission_rate = $psd->seller_commission_rate;
            $object->commission_amount = round($object->total_amount_without_gst * ($object->commission_rate / 100));
            $object->commission_amount_gst = round($object->commission_amount * 0.18);
            $object->commission_amount_with_gst = round($object->commission_amount_gst + $object->commission_amount);


            $object->amount = $psd->seller_earned;


            // $cod_charges = 0;
            $cod_charges_without_gst = ($this->get_charges_seller_wise($object->vendorId, $order_id))->Sup_cod_cost;
            $cod_charges_with_gst = $cod_charges_without_gst + (0.18 * $cod_charges_without_gst);
            $cod_charges_with_product_gst = ($this->get_charges_seller_wise($object->vendorId, $order_id))->total_cod_cost;
            $shipping_cod_gst_rate = ($this->get_charges_seller_wise($object->vendorId, $order_id))->shipping_cod_gst_rate;
            $cod_charges_without_product_gst = $cod_charges_with_product_gst - (($shipping_cod_gst_rate / 100) * $cod_charges_with_product_gst);
            $cod_charges_shiprocket = $cod_charges_without_product_gst + (0.18 * $cod_charges_without_product_gst);
            $cod_inc_gst_in_invoice = $cod_charges_without_product_gst + (($shipping_cod_gst_rate / 100) * $cod_charges_without_product_gst);


            $object->cod_charges_without_gst = $cod_charges_without_product_gst;
            if ($object->seller_gst_rate == 0) {
                $object->cod_charge = $object->cod_charges_without_gst;
            } elseif ($object->seller_gst_rate != 0) {
                $object->cod_charge = $cod_charges_shiprocket;
            }

            foreach ($shipping_detail as $ship_detail) {
                if ($psd->seller_id == $ship_detail->seller_id) {
                    // $object->shipping = ($ship_detail->Supplier_Shipping_cost);
                    // $object->shipping_tax_charge = ($ship_detail->shipping_tax_charges);
                    // $object->shipping_charge_with_gst = ($object->shipping) + ($object->shipping_tax_charge);


                    // $object->supplier_shipping_cost_with_gst = ($ship_detail->Supplier_Shipping_cost_with_gst);

                    // $object->shipping_charge_to_gharobaar = $object->supplier_shipping_cost_with_gst;
                    $object->shipping = ($ship_detail->sup_shipping_cost);
                    $object->shipping_tax_charge = ($ship_detail->Sup_Shipping_gst);
                    $object->shipping_charge_with_gst = ($object->shipping) + ($object->shipping_tax_charge);
                    $object->supplier_shipping_cost_with_gst = $object->shipping + (0.18 * $object->shipping);
                    $object->shipping_charge_to_gharobaar = $object->supplier_shipping_cost_with_gst;
                }
            }


            // condition for shipping slabs
            $slab = true;
            if ($slab == true) {
                if ($object->total_amount_with_gst >= 50000) {
                    $object->shipping_charge_to_gharobaar = ($object->shipping) + (0.18 * $object->shipping);
                } else if ($object->total_amount_with_gst >= 200000) {
                    $object->shipping_charge_to_gharobaar = 0;
                }
            }
            // if ($slab == true) {
            //     if ($object->total_amount_with_gst > 0 && $object->total_amount_with_gst < 100000) {
            //         $object->shipping_charge_to_gharobaar = ($object->shipping) + (0.18 * $object->shipping);
            //     } else if ($object->total_amount_with_gst >= 100000) {
            //         $object->shipping_charge_to_gharobaar = 0;
            //     }
            // }
            // condition end


            if (!empty($pan_number)) {
                if ($pan_forth_char[3] == 'P' || $pan_forth_char[3] == 'H') {
                    $object->tds_amount_shipping = 0;
                    $object->total_tds_cod = 0;
                    $object->tds_amount_shipping_huf_ind = 0.01 * ($object->shipping);
                    $object->total_tds_cod_huf_ind = 0.01 * $object->cod_charges_without_gst;
                } else {
                    $object->tds_amount_shipping = 0.01 * ($object->shipping);
                    $object->total_tds_cod = 0.01 * $object->cod_charges_without_gst;
                }
            } else {
                $object->tds_amount_shipping = 0.05 * ($object->shipping);
                $object->total_tds_cod = 0.05 * $object->cod_charges_without_gst;
            }


            if ($object->total_tcs_amount_product == 0) {
                $object->total_tcs_shipping = 0;
                $object->total_tcs_cod = 0;
            } elseif ($object->total_tcs_amount_product != 0) {
                $object->total_tcs_shipping = ($object->shipping) * 0.01;
                $object->total_tcs_cod = 0.01 * $object->cod_charges_without_gst;
            }

            $object->tcs_amount = $object->total_tcs_amount_product + $object->total_tcs_shipping + $object->total_tcs_cod;


            $object->tds_amount = $object->total_tds_amount_product + $object->tds_amount_shipping + $object->total_tds_cod;
            $object->total_deduction = round($object->cod_charge + $object->shipping_charge_to_gharobaar + $object->tcs_amount + $object->commission_amount_with_gst + $object->tds_amount);


            $object->net_seller_payable = round($object->total_amount_with_gst + $cod_inc_gst_in_invoice + $object->shipping_charge_with_gst - $object->total_deduction);


            $total_amount_paid += $object->net_seller_payable;

            $object->payment_mode = $payment_mode;
            $object->order_id = $order_id;

            array_push($seller_settlement, $object);
        }
        $this->disable_cod_seller_payable_payouts($order_id);
        $save_payment = $seller_settlement;
        foreach ($save_payment as $sp) {
            $this->order_model->save_cod_seller_payable($sp);
        }
    }






    //get order products
    public function get_order_products_ex_cancelled($order_id)
    {
        $ignore = array('cancelled', 'cancelled_by_seller', 'cancelled_by_user', 'rejected');
        $order_id = clean_number($order_id);
        $this->db->where('order_id', $order_id);
        $this->db->where_not_in('order_status', $ignore);
        $query = $this->db->get('order_products');
        return $query->result();
    }

    public function get_order_total($order_id)
    {
        $order_id = clean_number($order_id);
        $this->db->where('id', $order_id);
        $query = $this->db->get('orders');
        return $query->result();
    }
    public function get_payment_mode($order_id)
    {
        $order_id = clean_number($order_id);
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('cashfree_seller_payout');
        return $query->row();
    }

    public function get_shipping($order_id)
    {
        $order_id = clean_number($order_id);
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('order_supplier');
        return $query->result();
    }

    public function get_seller_invoice_no($order_id)
    {
        $order_id = clean_number($order_id);
        $this->db->select('invoice_no', 'invoice_seq', 'gb_invoice_no');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('order_supplier');
        return $query->result();
    }

    // online payment payouts is_active=0
    public function disable_cashfree_seller_payable_payouts($order_id)
    {
        $order_id = clean_number($order_id);
        $data = array(
            'is_active' => 0
        );
        $this->db->where('order_id', $order_id);
        $this->db->update('cashfree_seller_payout', $data);
    }

    // cod payouts is_active=0
    public function disable_cod_seller_payable_payouts($order_id)
    {
        $order_id = clean_number($order_id);
        $data = array(
            'is_active' => 0
        );
        $this->db->where('order_id', $order_id);
        $this->db->update('cod_seller_payable', $data);
    }

    public function recal_prepaid_seller_payable($order_id)
    {
        $order_items = $this->order_model->get_order_products_ex_cancelled($order_id);
        $order_total = $this->order_model->get_order_total($order_id);
        $shipping_detail = $this->order_model->get_shipping($order_id);


        $product_seller_details = array();
        $payment_mode_detail = $this->order_model->get_payment_mode($order_id);
        $payment_mode = $payment_mode_detail->payment_mode;
        $cashfree_order_id = $payment_mode_detail->cashfree_order_id;

        if ($payment_mode == 'nb') {
            $bank_code = $payment_mode_detail->bank_code;
        } elseif ($payment_mode == 'wallet') {
            $wallet_code = $payment_mode_detail->wallet_code;
        }


        foreach ($order_items as $cart_item) {
            $object = new stdClass();
            $product_details = get_active_product($cart_item->product_id);
            $object->seller_id = $product_details->user_id;
            $pan_number = get_pan_number_by_sellerid($object->seller_id);
            $pan_forth_char = str_split($pan_number);
            $object->seller_commission_rate = calculate_commission_rate_seller($object->seller_id);
            $new = true;
            foreach ($product_seller_details as $psd) {
                if ($psd->seller_id == $object->seller_id) {
                    $object_product = new stdClass();
                    $object_product->product_id = $cart_item->product_id;
                    $object_product->gst_rate = $product_details->gst_rate;
                    $object_product->product_total_price = $cart_item->product_total_price;

                    $gst_cal = 1 + ($object_product->gst_rate / 100);
                    $product_price_excluding_gst = round($object_product->product_total_price / $gst_cal, 0);
                    $amount = $product_price_excluding_gst / 100;
                    $commission = ($object->seller_commission_rate) / 100;
                    $commission_amount_without_round = $amount * $commission;
                    $commission_amount = round($commission_amount_without_round, 2);

                    $object_product->product_price_excluding_gst = $product_price_excluding_gst;

                    $gst_on_commission_amount = $commission_amount * 0.18;
                    $commission_amount_with_gst = $commission_amount + $gst_on_commission_amount;

                    $object_product->product_commission_amount = $commission_amount;
                    $object_product->product_gst_on_commission_amount = round($gst_on_commission_amount, 2);
                    $object_product->product_commission_amount_with_gst = round($commission_amount_with_gst, 2);

                    $psd->total_commission_amount += $object_product->product_commission_amount_with_gst;
                    $psd->total_price += $object_product->product_total_price;
                    $psd->total_price_without_gst += $object_product->product_price_excluding_gst;
                    $psd->seller_earned = ($psd->total_price / 100) - $psd->total_commission_amount;



                    if ($object_product->gst_rate == 0 || $object_product->gst_rate == null) {
                        $object_product->tcs_amount_product = 0;

                        if (!empty($pan_number)) {
                            if ($pan_forth_char[3] == 'P' || $pan_forth_char[3] == 'H') {
                                $object_product->tds_amount_product = 0;
                                $object_product->tds_amount_product_huf_ind = 0.01 * ($object_product->product_total_price);
                            } else {
                                $object_product->tds_amount_product = 0.01 * ($object_product->product_total_price);
                            }
                        } else {
                            $object_product->tds_amount_product = 0.05 * ($object_product->product_total_price);
                        }
                    } elseif ($object_product->gst_rate != 0) {
                        $object_product->tcs_amount_product = $object_product->product_price_excluding_gst * 0.01;
                        if (!empty($pan_number)) {
                            if ($pan_forth_char[3] == 'P' || $pan_forth_char[3] == 'H') {
                                $object_product->tds_amount_product = 0;
                                $object_product->tds_amount_product_huf_ind = 0.01 * ($object_product->product_price_excluding_gst);
                            } else {
                                $object_product->tds_amount_product = 0.01 * ($object_product->product_price_excluding_gst);
                            }
                        } else {
                            $object_product->tds_amount_product = 0.05 * ($object_product->product_price_excluding_gst);
                        }
                    }

                    $psd->total_tcs_amount_product += $object_product->tcs_amount_product;
                    $psd->total_tds_amount_product += $object_product->tds_amount_product;
                    $psd->total_tds_amount_product_huf_ind += $object_product->tds_amount_product_huf_ind;
                    array_push($psd->products, $object_product);
                    $new = false;
                }
            }
            if ($new) :
                $object->products = array();
                $object_product = new stdClass();
                $object_product->product_id = $cart_item->product_id;
                $object_product->gst_rate = $product_details->gst_rate;
                $object_product->product_total_price = $cart_item->product_total_price;



                $gst_cal = 1 + ($object_product->gst_rate / 100);
                $product_price_excluding_gst = round($object_product->product_total_price / $gst_cal, 0);
                $amount = $product_price_excluding_gst / 100;
                $commission = $object->seller_commission_rate / 100;
                $commission_amount_without_round = $amount * $commission;
                $commission_amount = round($commission_amount_without_round, 2);


                $object_product->product_price_excluding_gst = $product_price_excluding_gst;
                $gst_on_commission_amount = $commission_amount * 0.18;
                $commission_amount_with_gst = $commission_amount + $gst_on_commission_amount;

                $object_product->product_commission_amount = $commission_amount;
                $object_product->product_gst_on_commission_amount = round($gst_on_commission_amount, 2);
                $object_product->product_commission_amount_with_gst = round($commission_amount_with_gst, 2);

                $object->total_commission_amount = $object_product->product_commission_amount_with_gst;
                $object->total_price = $object_product->product_total_price;
                $object->total_price_without_gst = $object_product->product_price_excluding_gst;

                if ($object_product->gst_rate == 0 || $object_product->gst_rate == null) {
                    $object_product->tcs_amount_product = 0;

                    if (!empty($pan_number)) {
                        if ($pan_forth_char[3] == 'P' || $pan_forth_char[3] == 'H') {
                            $object_product->tds_amount_product = 0;
                            $object_product->tds_amount_product_huf_ind = 0.01 * ($object_product->product_total_price);
                        } else {
                            $object_product->tds_amount_product = 0.01 * ($object_product->product_total_price);
                        }
                    } else {
                        $object_product->tds_amount_product = 0.05 * ($object_product->product_total_price);
                    }
                } elseif ($object_product->gst_rate != 0) {
                    $object_product->tcs_amount_product = $object_product->product_price_excluding_gst * 0.01;
                    if (!empty($pan_number)) {
                        if ($pan_forth_char[3] == 'P' || $pan_forth_char[3] == 'H') {
                            $object_product->tds_amount_product = 0;
                            $object_product->tds_amount_product_huf_ind = 0.01 * ($object_product->product_price_excluding_gst);
                        } else {
                            $object_product->tds_amount_product = 0.01 * ($object_product->product_price_excluding_gst);
                        }
                    } else {
                        $object_product->tds_amount_product = 0.05 * ($object_product->product_price_excluding_gst);
                    }
                }

                $object->total_tcs_amount_product = $object_product->tcs_amount_product;
                $object->total_tds_amount_product = $object_product->tds_amount_product;

                $object->seller_earned = ($object->total_price / 100) - $object->total_commission_amount;
                array_push($object->products, $object_product);
                array_push($product_seller_details, $object);
            endif;
        }

        $seller_settlement = array();
        $total_amount_paid = 0;
        foreach ($product_seller_details as $psd) {
            $object = new stdClass();
            $object->vendorId = $psd->seller_id;


            $gst_number = get_gst_number_by_sellerid($object->vendorId);

            $object->total_tcs_amount_product = $psd->total_tcs_amount_product;
            $object->total_tds_amount_product = $psd->total_tds_amount_product;
            $object->total_amount_with_gst = $psd->total_price;
            $object->total_amount_without_gst = $psd->total_price_without_gst;
            $object->commission_rate = $psd->seller_commission_rate;
            $object->commission_amount = round($object->total_amount_without_gst * ($object->commission_rate / 100));
            $object->commission_amount_gst = round($object->commission_amount * 0.18);
            $object->commission_amount_with_gst = round($object->commission_amount_gst + $object->commission_amount);
            $object->amount = $psd->seller_earned;

            if ($payment_mode == 'nb') {
                // $bank_code = $this->input->post("bank_select", true);
                $com = $this->order_model->get_commission_rate_nb_wallet($payment_mode, $bank_code);
                $gateway_charge = $com->gateway_charge;
            } elseif ($payment_mode == 'wallet') {
                // $wallet_code = $this->input->post("wallet_select", true);
                $com = $this->order_model->get_commission_rate_nb_wallet($payment_mode, $wallet_code);
                $gateway_charge = $com->gateway_charge;
            } elseif ($payment_mode == 'cc') {
                // $com = $this->order_model->get_commission_rate_dc_cc_wallet($payment_mode);
                $gateway_charge = 1.85;
            } elseif ($payment_mode == 'upi') {
                $gateway_charge = 0.15;
            } elseif ($payment_mode == 'dc') {
                $payment_amount = $psd->total_price;
                if ($payment_amount < 200000) {
                    $gateway_charge = 0.45;
                } elseif ($payment_amount >= 200000) {
                    $gateway_charge = 0.95;
                }
            }
            $object->gateway_charge = $gateway_charge;

            foreach ($shipping_detail as $ship_detail) {
                if ($psd->seller_id == $ship_detail->seller_id) {
                    $object->shipping = ($ship_detail->sup_shipping_cost);
                    $object->shipping_tax_charge = ($ship_detail->Sup_Shipping_gst);
                    $object->shipping_charge_with_gst = ($object->shipping) + ($object->shipping_tax_charge);
                    $object->supplier_shipping_cost_with_gst = $object->shipping + (0.18 * $object->shipping);
                    $object->shipping_charge_to_gharobaar = $object->supplier_shipping_cost_with_gst;
                }
            }


            // condition for shipping slabs
            $slab = true;
            if ($slab == true) {
                if ($object->total_amount_with_gst >= 50000) {
                    $object->shipping_charge_to_gharobaar = ($object->shipping) + (0.18 * $object->shipping);
                } else if ($object->total_amount_with_gst >= 200000) {
                    $object->shipping_charge_to_gharobaar = 0;
                }
            }
            // if ($slab == true) {
            //     if ($object->total_amount_with_gst > 0 && $object->total_amount_with_gst < 100000) {
            //         $object->shipping_charge_to_gharobaar = ($object->shipping) + (0.18 * $object->shipping);
            //     } else if ($object->total_amount_with_gst >= 100000) {
            //         $object->shipping_charge_to_gharobaar = 0;
            //     }
            // }
            // condition end


            if (!empty($pan_number)) {
                if ($pan_forth_char[3] == 'P' || $pan_forth_char[3] == 'H') {
                    // $object->tds_amount = 0;
                    $object->tds_amount_shipping = 0;
                    $object->tds_amount_shipping_huf_ind = 0.01 * ($object->shipping);
                } else {
                    // $object->tds_amount = 0.01 * ($psd->total_price_without_gst);
                    $object->tds_amount_shipping = 0.01 * ($object->shipping);
                }
            } else {
                // $object->tds_amount = 0.05 * ($psd->total_price_without_gst);
                $object->tds_amount_shipping = 0.05 * ($object->shipping);
            }


            if ($object->total_tcs_amount_product == 0) {
                $object->total_tcs_shipping = 0;
            } elseif ($object->total_tcs_amount_product != 0) {
                $object->total_tcs_shipping = ($object->shipping) * 0.01;
            }

            $object->tcs_amount = $object->total_tcs_amount_product + $object->total_tcs_shipping;


            $object->tds_amount = $object->total_tds_amount_product + $object->tds_amount_shipping;
            $object->gateway_amount = round(($object->shipping_charge_with_gst + $object->total_amount_with_gst) * ($object->gateway_charge / 100));
            $object->gateway_amount_gst = round($object->gateway_amount * 0.18);
            $object->gateway_amount_with_gst = round($object->gateway_amount + $object->gateway_amount_gst);
            $object->total_deduction = round($object->gateway_amount_with_gst + $object->shipping_charge_to_gharobaar + $object->tcs_amount + $object->commission_amount_with_gst + $object->tds_amount);
            $object->net_seller_payable = round($object->total_amount_with_gst + $object->shipping_charge_with_gst - $object->total_deduction);


            $total_amount_paid += $object->net_seller_payable;



            $object->order_id = $order_id;
            $object->cashfree_order_id = $cashfree_order_id;
            $object->payment_mode = $payment_mode;
            if ($object->payment_mode == 'nb') {
                $object->bank_code = $bank_code;
            } elseif ($object->payment_mode == 'wallet') {
                $object->wallet_code = $wallet_code;
            }
            $object->is_completed = 1;

            array_push($seller_settlement, $object);
        }


        if ($this->general_settings->enable_easysplit == 0) {
            $this->order_model->disable_cashfree_seller_payable_payouts($order_id);
            $save_payment = $seller_settlement;
            foreach ($save_payment as $sp) {
                $this->order_model->save_cashfree_seller_payable_payouts($sp);
            }
        }
    }


    public function check_order_exists($user_id)
    {
        $sql = "SELECT count(id) as 'count' from orders where buyer_id=$user_id";
        $query = $this->db->query($sql);
        return $query->row();
    }



    public function get_notification_details($id)
    {
        // $id = $this->auth_user->id;
        // $email = $this->auth_user->email;
        // $phone = $this->auth_user->phone_number;
        $sql = "SELECT * from notifications where notifications.id='$id' ";
        $count = $this->db->query($sql);
        return $count->row();
    }

    public function update_notification_count($id)
    {
        $sql = "UPDATE notify_user SET `read`=1 where notification_id='$id' ";
        return $this->db->query($sql);
    }

    public function get_charges_seller_wise1($order_id)
    {
        $this->db->where('order_id', $order_id);
        $this->db->where('seller_id', $this->auth_user->id);
        return $this->db->get('order_supplier')->row();
        // var_dump($query->result());
    }



    public function fetch_seller_payout_inititated($seller_id)
    {
        $seller_id = clean_number($seller_id);
        $this->db->where('vendorId', $seller_id);
        $query = $this->db->get('seller_payout_report');
        return $query->result();
    }
    public function schedule_penalty()
    {

        $order_id = trim($this->input->post('order_id', true));

        $order_products = $this->order_model->get_order_products($order_id);


        foreach ($order_products as $order_p) {
            $product = $this->order_model->get_product_detail($order_p->product_id);

            $lookup_table_data = $this->order_model->get_product_shipping_days_from_db($product[0]->shipping_time);
            $estimated_days = $lookup_table_data->lookup_int_val;

            $created_date = date('Y-m-d h:i:s', strtotime($order_p->created_at));
            $current_date = date('Y-m-d h:i:s');


            foreach ($product as $p) {
                if ($p->add_meet == 'Made to order') {
                    $lead_time_in_sec = $order_p->lead_time;
                    $order_accepted_at = $order_p->accepted_at;
                    $accepted_at_in_sec = strtotime($order_accepted_at);

                    $total_estimated_dispatch_in_sec = $accepted_at_in_sec + $lead_time_in_sec;
                    $estimated_dispatch_date = date('Y-m-d H:i:s', $total_estimated_dispatch_in_sec);
                } elseif ($p->add_meet == 'Made to stock') {
                    $date = strtotime($created_date);
                    $estimated_dispatch_date = strtotime("$estimated_days day", $date);
                    $dispatch_date = date('Y-m-d h:i:s', $estimated_dispatch_date);
                }


                if ($dispatch_date < $current_date && $order_p->order_status == "processing") {
                    $data = array(
                        'order_number' => $order_p->order_id,
                        'order_product_id' => $order_p->id,
                        "quantity" => $order_p->product_quantity,
                        "user_id" => $this->auth_user->id,
                        "total_amount_paid_buyer" => $order_p->product_total_price,
                        "commission_rate" => $order_p->commission_rate,
                        "commission_amount" => $p->commission_amount,
                        "shipping_cost" => $order_p->product_shipping_cost,
                        "penalty_amount" => $this->general_settings->penalty_amount * 100,
                        "currency" => 'INR',
                        "order_date" =>  $order_p->created_at,
                        "dispatch_date" => $dispatch_date,
                        "created_at" => date('Y-m-d H:i:s'),
                        "add_meet" =>  $p->add_meet


                    );

                    $this->db->insert('penalty', $data);
                    $order_id = $order_p->order_id;
                    $seller_id = $this->auth_user->id;
                    if ($order_p->payment_status == "awaiting_payment") {
                        $cod_seller_payable = $this->order_model->get_cod_seller_payable($order_id, $seller_id);
                        // var_dump($cod_seller_payable);
                        $data1['net_seller_payable'] = $cod_seller_payable[0]->net_seller_payable - ($this->general_settings->penalty_amount * 100);

                        $success = $this->order_model->update_cod_seller_payable($data1, $order_id, $seller_id);
                    } else {
                        $cashfree_seller_payout = $this->order_model->get_cashfree_seller_payout($order_id, $seller_id);
                        // var_dump($cashfree_seller_payout);
                        $data1['net_seller_payable'] = $cashfree_seller_payout[0]->net_seller_payable - ($this->general_settings->penalty_amount * 100);
                        $success = $this->order_model->update_cashfree_seller_payout($data1, $order_id, $seller_id);
                    }
                }
            }
        }
    }



    //check order products status / update if all suborders completed in order supplier table
    public function update_order_status_if_completed_seller_wise($order_id, $seller_id)
    {
        $order_id = clean_number($order_id);
        $status = "";
        $order_products = $this->get_order_products_of_seller($order_id, $seller_id);
        $count_order_items = count($order_products);

        if (!empty($order_products)) {
            $completed = 0;
            $cancelled = 0;
            $shipped = 0;
            $processing = 0;
            $rejected = 0;
            $awaiting_pickup = 0;
            foreach ($order_products as $order_product) {
                if ($order_product->order_status == "completed") {
                    $completed++;
                } else if ($order_product->order_status == "shipped") {
                    $shipped++;
                } else if ($order_product->order_status == "processing") {
                    $processing++;
                } else if ($order_product->order_status == "cancelled" || $order_product->order_status == "cancelled_by_user" || $order_product->order_status == "cancelled_by_seller") {
                    $cancelled++;
                } else if ($order_product->order_status == "rejected") {
                    $rejected++;
                } else if ($order_product->order_status == "awaiting_pickup") {
                    $awaiting_pickup++;
                }
            }

            if ($count_order_items == $completed) {
                $data["status"] = "completed";
            } else if ($count_order_items == $cancelled) {
                $data["status"] = "cancelled";
            } else if ($count_order_items == $shipped) {
                $data["status"] = "shipped";
            } else if ($count_order_items == ($shipped + $cancelled + $rejected)) {
                $data["status"] = "shipped";
            } else if ($count_order_items == $processing) {
                $data["status"] = "processing";
            } else if ($count_order_items == $rejected) {
                $data["status"] = "rejected";
            } else if ($count_order_items == ($completed + $cancelled)) {
                $data["status"] = "completed";
            } else if ($count_order_items == ($completed + $rejected)) {
                $data["status"] = "completed";
            } else if ($count_order_items == ($completed + $rejected + $cancelled)) {
                $data["status"] = "completed";
            } else if ($count_order_items == ($completed + $rejected + $cancelled)) {
                $data["status"] = "completed";
            } else if ($count_order_items == $awaiting_pickup) {
                $data["status"] = "awaiting_pickup";
            } else if ($count_order_items == ($awaiting_pickup + $cancelled + $rejected)) {
                $data["status"] = "awaiting_pickup";
            } else {
                $data["status"] = "pending";
            }
        }

        $this->db->where('order_id', $order_id);
        $this->db->where('seller_id', $seller_id);
        $this->db->update('order_supplier', $data);
    }

    //get order products
    public function get_order_products_of_seller($order_id, $seller_id)
    {
        $order_id = clean_number($order_id);
        $this->db->where('order_id', $order_id);
        $this->db->where('seller_id', $seller_id);
        $query = $this->db->get('order_products');
        return $query->result();
    }

    public function if_preapid_transfer_id($refrence_id)
    {
        $sql = "SELECT count(referenceId) AS 'count' FROM cashfree_seller_payout where referenceId= $refrence_id";
        $query = $this->db->query($sql);
        return $query->row()->count;
    }

    public function if_cod_transfer_id($refrence_id)
    {
        $sql = "SELECT count(referenceId) AS 'count' FROM cod_seller_payable where referenceId= $refrence_id";
        $query = $this->db->query($sql);
        return $query->row()->count;
    }
    public function get_cod_seller_payable($order_id, $seller_id)
    {
        // $order_id = clean_number($order_id);
        $this->db->where('order_id', $order_id);
        $this->db->where('vendorId', $seller_id);
        $query = $this->db->get('cod_seller_payable');
        return $query->result();
    }
    public function update_cod_seller_payable($data, $order_id, $seller_id)
    {
        $this->db->where('order_id', $order_id);
        $this->db->where('vendorId', $seller_id);
        $this->db->update('cod_seller_payable', $data);
    }
    public function get_cashfree_seller_payout($order_id, $seller_id)
    {
        // $order_id = clean_number($order_id);
        $this->db->where('order_id', $order_id);
        $this->db->where('vendorId', $seller_id);
        $query = $this->db->get('cashfree_seller_payout');
        return $query->result();
    }
    public function update_cashfree_seller_payout($data, $order_id, $seller_id)
    {
        $this->db->where('order_id', $order_id);
        $this->db->where('vendorId', $seller_id);
        $this->db->update('cashfree_seller_payout', $data);
    }
    public function count_offer_applied($user_id, $offer_id)
    {

        $sql = " SELECT count(offer_id) as 'count' from orders where buyer_id=$user_id and offer_id=$offer_id";
        $query = $this->db->query($sql);
        return $query->row()->count;
    }

    public function order_price($order_id)
    {
        $sql = "SELECT * from orders where id=$order_id";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function order_price_subtotal($order_id)
    {
        $sql = "SELECT sum(product_total_price) as subtotal from order_products where order_id=$order_id";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
