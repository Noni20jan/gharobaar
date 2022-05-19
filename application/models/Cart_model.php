<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->cart_product_ids = array();
    }

    //all available offers from offers table
    public function available_offers()
    {
        $sql = "SELECT * FROM offers";
        $query = $this->db->query($sql);
        return $query->result();
    }

    //add to cart
    public function add_to_cart($product)
    {
        $cart = $this->cart_model->get_sess_cart_items();
        if ($this->auth_check) {
            if (empty($cart)) {
                // $this->add_cart_db($this->auth_user->id);
                $cart_id = $this->add_cart_db($this->auth_user->id);
            } else {
                $cart_id = $this->get_cart_id_db($this->auth_user->id);
            }
        }

        $quantity = $this->input->post('product_quantity', true);
        $expected_delivery_date = $this->input->post('expected_delivery_date', true);
        $expected_delivery_time = $this->input->post('expected_delivery_time', true);
        if ($quantity < 1) {
            $quantity = 1;
        }
        if ($product->product_type == "digital") {
            $quantity = 1;
        }
        $appended_variations = $this->get_selected_variations($product->id)->str;

        $options_array = $this->get_selected_variations($product->id)->options_array;
        //exit;
        $new_product = true;
        foreach ($cart as $cart_item) {
            if ($cart_item->product_id == $product->id) {
                if ($cart_item->options_array == $options_array) {
                    $cart_item->quantity = $cart_item->quantity + 1;
                    $new_product = false;
                    $this->update_cart_product_quantity_db($cart_item->cart_item_id, $cart_item->product_id, $cart_item->product_title, $cart_item->options_array, $cart_item->quantity);
                    break;
                }
            } else {
                $new_product = true;
            }
        }
        if ($new_product) {
            $item = new stdClass();
            $item->cart_item_id = generate_unique_id();
            $item->product_id = $product->id;
            $item->product_type = $product->product_type;
            $item->product_title = get_product_title($product) . " " . $appended_variations;
            $item->product_deliverable = 1;
            $item->product_delivery_area = $product->delivery_area;
            $item->options_array = $options_array;
            $item->quantity = $quantity;
            $item->unit_price = null;
            $item->total_price = null;
            $item->discount_rate = 0;
            $item->currency = $product->currency;
            $item->product_gst = 0;
            $item->shipping_cost = $product->shipping_cost;
            $item->is_stock_available = null;
            $item->purchase_type = 'product';
            $item->quote_request_id = 0;
            $item->additional_info = '';
            if (!empty($expected_delivery_time)) {
                $item->expected_delivery_time = $expected_delivery_time;
            }
            if (!empty($expected_delivery_date)) {
                $item->expected_delivery_date = $expected_delivery_date;
            }
            array_push($cart, $item);
            if ($this->auth_check && !empty($cart_id)) {
                $this->add_cart_product_details($cart_id, $item);
            }

            $this->session->set_userdata('mds_shopping_cart', $cart);
        }
    }


    public function add_cart_to_session_from_db($cart_details, $onLogin = false)
    {
        $cart = array();
        if ($this->auth_check || $onLogin) {

            if (!empty($cart_details) && count($cart_details) > 0) {

                foreach ($cart_details as $cart_detail) {
                    //exit;
                    $item = new stdClass();
                    $item->cart_item_id = $cart_detail->cart_item_id;
                    $item->product_id = $cart_detail->product_id;
                    $item->product_type = $cart_detail->product_type;
                    $item->product_title = $cart_detail->product_title;
                    $item->options_array = unserialize($cart_detail->options_array);
                    $item->quantity = $cart_detail->quantity;
                    $item->unit_price = $cart_detail->unit_price;
                    $item->total_price = $cart_detail->total_price;
                    $item->discount_rate = $cart_detail->discount_rate;
                    $item->currency = $cart_detail->currency;
                    $item->product_gst = $cart_detail->product_gst;
                    $item->shipping_cost = $cart_detail->shipping_cost;
                    $item->is_stock_available = $cart_detail->is_stock_available;
                    $item->purchase_type = $cart_detail->purchase_type;
                    $item->quote_request_id = $cart_detail->quote_request_id;
                    if (!empty($cart_detail->expected_delivery_time)) {
                        $item->expected_delivery_time = $cart_detail->expected_delivery_time;
                    }
                    if (!empty($cart_detail->expected_delivery_date)) {
                        $item->expected_delivery_date = $cart_detail->expected_delivery_date;
                    }
                    $item->additional_info = $cart_detail->additional_info;
                    array_push($cart, $item);
                }

                $this->session->set_userdata('mds_shopping_cart', $cart);
            }
        }
    }

    public function add_session_to_cart_in_db($user_id)
    {
        $this->session_cart_items = $this->get_sess_cart_items();
        $cart = $this->session_cart_items;
        if (!empty($cart)) {
            if ($this->check_for_cart_by_user_id($user_id)) {
                $cart_id = $this->get_cart_id_db($user_id);
            } else {
                $cart_id = $this->add_cart_db($user_id);
            }
            foreach ($cart as $cart_item) {
                $this->add_cart_product_details($cart_id, $cart_item, $user_id);
            }
        }
    }
    public function add_cart_db($user_id)
    {
        $data = array();
        $data["user_id"] = $user_id;
        $this->db->insert('cart', $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    public function get_cart_id_db($user_id)
    {
        $data = array();
        $data["user_id"] = $user_id;
        $this->db->where('user_id', $user_id);
        $this->db->where('is_active', '1');
        $row = $this->db->get('cart')->row();
        if (!empty($row)) :
            return $row->id;
        else :
            return $row;
        endif;
    }

    public function check_for_cart_by_user_id($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('is_active', '1');
        $query = $this->db->get('cart');
        $result = $query->num_rows();
        return ($result > 0) ? true : false;
    }

    public function get_user_cart_from_db($user_id)
    {
        $data = array();
        $data["user_id"] = $user_id;
        $this->db->where('user_id', $user_id);
        $this->db->where('is_active', '1');
        $row = $this->db->get('cart')->row();
        return $row;
    }

    public function get_cart_details_by_id($user_cart_id)
    {
        $this->db->where('cart_id', $user_cart_id);
        $this->db->where('is_active', '1');
        $query = $this->db->get('cart_product_details');
        return $query->result();
    }

    public function get_cart_shipping_details_by_id($user_cart_id)
    {
        $this->db->where('id', $user_cart_id);
        $this->db->where('is_active', '1');
        // $query = $this->db->get('session_shipping_address');
        $query = $this->db->get('cart');
        return $query->result();
    }

    public function add_cart_product_details($cart_id, $item, $user_id = null)
    {
        $product = $this->product_model->get_active_product($item->product_id);
        $object = $this->get_product_price_and_stock($product, $item->product_title, $item->options_array);
        // var_dump($item);die();
        $cart_details = array(
            "cart_id" => $cart_id,
            "cart_item_id" => $item->cart_item_id,
            "product_id" => $item->product_id,
            "product_type" => $item->product_type,
            "product_title" => $item->product_title,
            "quantity" => $item->quantity,
            "unit_price" => $object->price_calculated,
            "total_price" => $object->price_calculated * $item->quantity,
            "discount_rate" => $object->discount_rate,
            "discount_amount" => round((($object->price) * ($object->discount_rate)) / 10000) * $item->quantity,
            "currency" => $item->currency,
            "listing_price" => $object->price,
            "product_gst" => $item->product_gst,
            "shipping_cost" => $item->shipping_cost,
            "is_stock_available" => $object->is_stock_available,
            "purchase_type" => $item->purchase_type,
            "quote_request_id" => $item->quote_request_id,
            "additional_info" => $item->additional_info
        );
        if (empty($user_id)) {
            $cart_details["created_by"] = $this->auth_user->id;
            $cart_details["updated_by"] = $this->auth_user->id;
        } else {
            $cart_details["created_by"] = $user_id;
            $cart_details["updated_by"] = $user_id;
        }
        if (is_array($item->options_array))
            $cart_details["options_array"] = serialize($item->options_array);
        else
            $cart_details["options_array"] = $item->options_array;


        if (!empty($item->expected_delivery_date)) {
            $cart_details["expected_delivery_date"] = $item->expected_delivery_date;
        }
        if (!empty($item->expected_delivery_time)) {
            $cart_details["expected_delivery_time"] = $item->expected_delivery_time;
        }


        if (!empty($item->variation_option)) {
            $cart_details["variation_option_id"] = $object->variation_option->id;
        }
        $this->db->insert('cart_product_details', $cart_details);
    }

    public function update_cart_product_quantity_db($cart_item_id, $product_id, $product_title, $options_array, $quantity)
    {
        $product = $this->product_model->get_active_product($product_id);
        $object = $this->get_product_price_and_stock($product, $product_title, $options_array);
        $data = array(
            "quantity" => $quantity,
            "discount_amount" => round((($object->price) * ($object->discount_rate)) / 10000) * $quantity,
            "total_price" => $object->price_calculated * $quantity,
        );
        if ($this->auth_check) :
            $cart_id = $this->get_cart_id_db($this->auth_user->id);
            if (!empty($cart_id)) {
                $this->db->where('cart_item_id', $cart_item_id);
                $this->db->where('cart_id', $cart_id);
                $this->db->update('cart_product_details', $data);
            }
        endif;
    }


    //add shipping amount in cart
    public function add_shipping_cost_to_cart($product)
    {
        $cart = $this->cart_model->get_sess_cart_items();
        // var_dump($cart);
        // echo json_encode($cart);
        $shipping_amount = $this->input->post('shipping_amount', true);

        $options_array = $this->get_selected_variations($product->id)->options_array;
        $cart_with_shipping_cost = array();
        foreach ($cart as $cart_item) {
            if ($cart_item->product_id == $product->id) {
                if ($cart_item->options_array == $options_array) {
                    $cart_item->shipping_cost = $shipping_amount;
                }
            }
            array_push($cart_with_shipping_cost, $cart_item);
        }
        // echo json_encode($cart_with_shipping_cost);
        $this->session->set_userdata('mds_shopping_cart', $cart_with_shipping_cost);
    }


    //add shipping amount in cart after seller by calculation
    public function add_shipping_cost_to_cart_by_seller($Supplier_ship_data)
    {
        $cart = $this->cart_model->get_sess_cart_items();
        $sup_array = $Supplier_ship_data;

        $cart_with_shipping_cost_updated = array();
        foreach ($cart as $cart_item) {
            foreach ($sup_array as $sup) {
                if (get_seller_id_by_product_id($cart_item->product_id) == $sup->SupplierId) {
                    $cart_item->shipping_cost = $sup->Supplier_Shipping_cost;
                }
            }
            if (auth_check()) :
                $this->add_shipping_cost_to_cart_by_seller_db($cart_item->cart_item_id, $cart_item->shipping_cost);
            endif;
            array_push($cart_with_shipping_cost_updated, $cart_item);
        }
        $this->session->set_userdata('mds_shopping_cart', $cart_with_shipping_cost_updated);
    }


    public function add_shipping_cost_to_cart_by_seller_db($cart_item_id, $shipping_cost)
    {
        $data = array(
            "shipping_cost" => $shipping_cost
        );
        $cart_id = $this->get_cart_id_db($this->auth_user->id);
        if (!empty($cart_id)) {
            $this->db->where('cart_item_id', $cart_item_id);
            $this->db->where('cart_id', $cart_id);
            $this->db->update('cart_product_details', $data);
        }
    }

    //add to cart quote
    public function add_to_cart_quote($quote_request_id)
    {
        $this->load->model('bidding_model');
        $quote_request = $this->bidding_model->get_quote_request($quote_request_id);

        if (!empty($quote_request)) {
            $product = $this->product_model->get_active_product($quote_request->product_id);
            if (!empty($product)) {
                $cart = $this->cart_model->get_sess_cart_items();
                $item = new stdClass();
                $item->cart_item_id = generate_unique_id();
                $item->product_id = $product->id;
                $item->product_type = $product->product_type;
                $item->product_title = $quote_request->product_title;
                $item->options_array = array();
                $item->quantity = $quote_request->product_quantity;
                $item->unit_price = $quote_request->price_offered / $quote_request->product_quantity;
                $item->total_price = $quote_request->price_offered;
                $item->currency = $quote_request->price_currency;
                $item->product_gst = 0;
                $item->shipping_cost = $quote_request->shipping_cost;
                $item->is_stock_available = 1;
                $item->purchase_type = 'bidding';
                $item->quote_request_id = $quote_request->id;
                array_push($cart, $item);

                $this->session->set_userdata('mds_shopping_cart', $cart);
                return true;
            }
        }
        return false;
    }

    //remove from cart
    public function remove_from_cart($cart_item_id)
    {
        $cart = $this->cart_model->get_sess_cart_items();
        if (!empty($cart)) {
            $new_cart = array();
            foreach ($cart as $item) {
                if ($item->cart_item_id != $cart_item_id) {
                    array_push($new_cart, $item);
                }
            }
            $this->session->set_userdata('mds_shopping_cart', $new_cart);
            if ($this->auth_check) {
                $this->remove_from_cart_product_db($cart_item_id);
                if (count($new_cart) == 0) {
                    $this->remove_from_cart_db($this->auth_user->id);
                }
            }
        }
    }

    //remove from cart product from db
    public function remove_from_cart_product_db($cart_item_id)
    {
        $data["is_active"] = 0;
        $this->db->where('cart_item_id', $cart_item_id);
        return $this->db->update('cart_product_details', $data);
    }

    //remove from cart from db
    public function remove_from_cart_db($user_id)
    {
        $data["is_active"] = 0;
        $this->db->where('user_id', $user_id);
        return $this->db->update('cart', $data);
    }

    //get gst number by seller id
    public function get_gst_number_by_sellerid($user_id)
    {
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        return $query->row()->gst_number;
    }

    //get pan number by seller id
    public function get_pan_number_by_sellerid($user_id)
    {
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        return $query->row()->pan_number;
    }

    //get selected variations
    public function get_selected_variations($product_id)
    {
        $object = new stdClass();
        $object->str = "";
        $object->options_array = array();

        $variations = $this->variation_model->get_product_variations($product_id);
        $str = "";
        if (!empty($variations)) {
            foreach ($variations as $variation) {
                $append_text = "";
                if (!empty($variation) && $variation->is_visible == 1) {
                    $variation_val = $this->input->post('variation' . $variation->id, true);
                    if (!empty($variation_val)) {

                        if ($variation->variation_type == "text" || $variation->variation_type == "number") {
                            $append_text = $variation_val;
                        } else {
                            //check multiselect
                            if (is_array($variation_val)) {
                                $i = 0;
                                foreach ($variation_val as $item) {
                                    $option = $this->variation_model->get_variation_option($item);
                                    if (!empty($option)) {
                                        if ($i == 0) {
                                            $append_text .= get_variation_option_name($option->option_names, $this->selected_lang->id);
                                        } else {
                                            $append_text .= " - " . get_variation_option_name($option->option_names, $this->selected_lang->id);
                                        }
                                        $i++;
                                        array_push($object->options_array, $option->id);
                                    }
                                }
                            } else {
                                $option = $this->variation_model->get_variation_option($variation_val);
                                if (!empty($option)) {
                                    $append_text .= get_variation_option_name($option->option_names, $this->selected_lang->id);
                                    array_push($object->options_array, $option->id);
                                }
                            }
                        }

                        if (empty($str)) {
                            $str .= "(" . get_variation_label($variation->label_names, $this->selected_lang->id) . ": " . $append_text;
                        } else {
                            $str .= ", " . get_variation_label($variation->label_names, $this->selected_lang->id) . ": " . $append_text;
                        }
                    }
                }
            }
            if (!empty($str)) {
                $str = $str . ")";
            }
        }
        $object->str = $str;

        return $object;
    }

    //get product price and stock
    public function get_product_price_and_stock($product, $cart_product_title, $options_array)
    {
        // var_dump($options_array); 
        $object = new stdClass();
        $object->price = 0;
        $object->discount_rate = 0;
        $object->price_calculated = 0;
        $object->is_stock_available = 0;
        $object->gst_rate = 0;
        $object->variation_option = 0;

        if (!empty($product)) {
            //quantity in cart
            $quantity_in_cart = 0;
            if (!empty($this->session->userdata('mds_shopping_cart'))) {
                foreach ($this->session->userdata('mds_shopping_cart') as $item) {
                    if ($item->product_id == $product->id && $item->product_title == $cart_product_title) {
                        $quantity_in_cart += $item->quantity;
                    }
                }
            }

            $stock = $product->stock;
            $object->price = $product->price;
            $object->discount_rate = $product->discount_rate;
            $object->gst_rate = $product->gst_rate;
            $object->listing_price = $product->listing_price;
            $object->weight = $product->weight;
            if (!empty($options_array)) {
                // foreach($options_array as  $option_id){
                $option_id = $options_array[0];
                $option = $this->variation_model->get_variation_option($option_id);
                if (!empty($option)) {
                    $variation = $this->variation_model->get_variation($option->variation_id);
                    // $label_name=@unserialize($variation->label_names);
                    // var_dump($label_name[0]);
                    if ($variation->use_different_price == 1) {
                        // var_dump($option->price);
                        if (isset($option->price)) {
                            $object->price = $option->price;
                        }
                        if (isset($option->discount_rate)) {
                            $object->discount_rate = $option->discount_rate;
                        }
                    }
                    if ($option->is_default != 1) {
                        $stock = $option->stock;
                        $object->variation_option = $option;
                        $object->weight = $option->package_weight;
                    }
                }
            }

            if (empty($object->price) && empty($object->discount_rate)) {
                if (empty($object->price))
                    $object->price = $product->price;
                if (empty($object->discount_rate))
                    $object->discount_rate = $product->discount_rate;
            }
            // var_dump($object);
            if (empty($object->price) && !empty($object->discount_rate)) {
                $object->price = $product->price;
            }
            $object->price_calculated = calculate_product_price($object->price, $object->discount_rate, $object->gst_rate);

            $object->price_calculated = round($object->price_calculated / 100) * 100;

            if ($stock >= $quantity_in_cart) {
                $object->is_stock_available = 1;
            }
            if ($product->product_type == 'digital') {
                $object->is_stock_available = 1;
            }
        }
        return $object;
    }

    //get product shipping cost
    public function get_product_shipping_cost($product, $quantity)
    {
        if (in_array($product->id, $this->cart_product_ids)) {
            return $product->shipping_cost_additional * $quantity;
        } else {
            array_push($this->cart_product_ids, $product->id);
            if ($quantity > 1) {
                return $product->shipping_cost + ($product->shipping_cost_additional * ($quantity - 1));
            } else {
                return $product->shipping_cost * $quantity;
            }
        }
    }

    //update cart product quantity
    public function update_cart_product_quantity($product_id, $cart_item_id, $quantity)
    {
        $product = $this->product_model->get_active_product($product_id);

        if ($quantity < 1) {
            $quantity = 1;
        }
        $cart = $this->cart_model->get_sess_cart_items();
        if (!empty($cart)) {
            foreach ($cart as $item) {
                if ($item->cart_item_id == $cart_item_id) {
                    $item->quantity = $quantity;
                    $this->update_cart_product_quantity_db($item->cart_item_id, $item->product_id, $item->product_title, $item->options_array, $item->quantity);
                }
            }
        }
        $this->session->set_userdata('mds_shopping_cart', $cart);
        // $this->update_cart_product_quantity_db($cart_item_id, $cart_item->product_id, $cart_item->product_title, $cart_item->options_array, $quantity);
    }
    //calculate cart total
    public function calculate_cart_total()
    {
        $cart = $this->cart_model->get_sess_cart_items();
        $cart_total = new stdClass();
        $cart_total->subtotal = 0;
        $cart_total->gst = 0;
        $cart_total->shipping_cost = 0;

        $cart_total->total = 0;

        //coupon code
        $cart_total->applied_coupon_id = 0;
        $cart_total->applied_coupon_source_type = 0;
        $cart_total->applied_coupon_code = 0;
        $cart_total->applied_coupon_discount = 0;
        $cart_total->applied_coupon_product_ids = array();


        $cart_total->currency = $this->payment_settings->default_currency;
        $cart_total->is_stock_available = 1;
        $cart_total->discount = 0;
        $cart_total->order_total = 0;
        $cart_total->actual_shipping_charges = 0;
        $cart_total->total_cod_charges = 0;
        $cart_total->total_tax_charges = 0;
        $cart_total->is_all_product_available = 1;
        $cart_total->min_dispatch_time = 0;
        $cart_total->max_dispatch_time = 0;

        if (!empty($cart)) {
            foreach ($cart as $item) {
                $product = $this->product_model->get_product_by_id($item->product_id);
                if ($item->purchase_type == 'bidding') {
                    $this->load->model('bidding_model');
                    $quote_request = $this->bidding_model->get_quote_request($item->quote_request_id);
                    if (!empty($quote_request)) {
                        $cart_total->subtotal += $quote_request->price_offered;
                    }
                } else {
                    $object = $this->get_product_price_and_stock($product, $item->product_title, $item->options_array);

                    $cart_total->subtotal += $object->price * $item->quantity;
                    $cart_total->gst += $item->product_gst;
                    $cart_total->discount += round((($object->price) * ($object->discount_rate)) / 10000) * $item->quantity;
                }
                if (empty($cart_total->min_dispatch_time)) :
                    $cart_total->min_dispatch_time = $item->product_dispatch_time;
                else :
                    if ($item->product_dispatch_time < $cart_total->min_dispatch_time) :
                        $cart_total->min_dispatch_time = $item->product_dispatch_time;
                    endif;
                endif;

                if (empty($cart_total->max_dispatch_time)) :
                    $cart_total->max_dispatch_time = $item->product_dispatch_time;
                else :
                    if ($item->product_dispatch_time > $cart_total->max_dispatch_time) :
                        $cart_total->max_dispatch_time = $item->product_dispatch_time;
                    endif;
                endif;


                if ($item->is_stock_available != 1) {
                    $cart_total->is_stock_available = 0;
                }
                if ($item->product_deliverable != 1) {
                    $cart_total->is_all_product_available = 0;
                }
                $cart_total->total = $cart_total->subtotal - $cart_total->discount * 100;
            }




            if ($this->auth_check) :
                $Supplier_ship_data = array();
                $Supplier_ship_data = json_decode($this->order_model->get_shipping_cost($cart_total));
                if ($Supplier_ship_data) :
                    foreach ($Supplier_ship_data as $supp) :
                        $cart_total->actual_shipping_charges = $supp->Supplier_Shipping_cost;
                        $cart_total->shipping_cost += $cart_total->actual_shipping_charges;
                        $cart_total->cod_charges = $supp->cod_charges;
                        $cart_total->total_cod_charges += $cart_total->cod_charges;
                        $cart_total->tax_charges = $supp->tax_charges;
                        $cart_total->total_tax_charges += $cart_total->tax_charges;
                    endforeach;
                    $this->add_shipping_cost_to_cart_by_seller($Supplier_ship_data);
                endif;
            elseif ($this->general_settings->guest_checkout == 1) :
                $Supplier_ship_data = array();
                $Supplier_ship_data = json_decode($this->order_model->get_shipping_cost($cart_total));
                if ($Supplier_ship_data) :
                    foreach ($Supplier_ship_data as $supp) :
                        $cart_total->actual_shipping_charges = $supp->Supplier_Shipping_cost;
                        $cart_total->shipping_cost += $cart_total->actual_shipping_charges;
                        $cart_total->cod_charges = $supp->cod_charges;
                        $cart_total->total_cod_charges += $cart_total->cod_charges;
                        $cart_total->tax_charges = $supp->tax_charges;
                        $cart_total->total_tax_charges += $cart_total->tax_charges;
                    endforeach;
                endif;
            else :
                $cart_total->shipping_cost = 0;
                $cart_total->actual_shipping_charges = 0;
                $cart_total->total_cod_charges = 0;
                $cart_total->total_tax_charges = 0;
            endif;


            $payments = $this->cart_model->get_sess_cart_payment_method();
            $cod = (string)0;
            if (!empty($payments)) {
                $payment = (string)($payments->payment_option);
                if ($payment === 'cash_on_delivery') {
                    $cod = (string)1;
                }
            }


            if ($this->general_settings->flat_ship_enable == 1) {
                $cart_total->shipping_cost = $this->general_settings->flat_ship_amount;
                $cart_total->total_tax_charges = 0;
            }


            if ($this->general_settings->flat_cod_enable == 1) {
                $cart_total->total_cod_charges = 0;
            }

            if ($cod) :
                $cart_total->order_total = $cart_total->total + $cart_total->shipping_cost + $cart_total->total_cod_charges + $cart_total->total_tax_charges;
            else :
                $cart_total->order_total = $cart_total->total + $cart_total->shipping_cost + $cart_total->total_tax_charges;
            endif;
            // $cart_total->total_price = round($cart_total->order_total / 100) * 100;
            $cart_total->total_price = $cart_total->order_total;


            //coupon functionality
            $coupon_applied = $this->session->userdata('mds_shopping_cart_coupon');
            if (!empty($coupon_applied)) {
                $cart_total->applied_coupon_id = $coupon_applied->id;
                $cart_total->applied_coupon_source_type = $coupon_applied->source_type;
                $cart_total->applied_coupon_code = $coupon_applied->offer_code;
                switch ($cart_total->applied_coupon_source_type):
                    case "ALL":
                        $coupon_details = $this->offer_model->get_coupon_by_id($cart_total->applied_coupon_id);
                        if (strtoupper($coupon_details->type) == "FLAT") :
                            $cart_total->applied_coupon_discount = $coupon_details->discount_amt * 100;
                        elseif (strtoupper($coupon_details->type) == "PERCENTAGE") :
                            $coupon_discount = $cart_total->total * ($coupon_details->discount_percentage / 100);
                            if ($coupon_discount / 100 > $coupon_details->allowed_max_discount) {
                                $cart_total->applied_coupon_discount = $coupon_details->allowed_max_discount * 100;
                            } else {
                                $cart_total->applied_coupon_discount = $cart_total->total * ($coupon_details->discount_percentage / 100);
                            }
                        endif;
                        break;
                    case "USER":
                        $coupon_details = $this->offer_model->get_coupon_by_id($cart_total->applied_coupon_id);
                        if (strtoupper($coupon_details->type) == "FLAT") :
                            $cart_total->applied_coupon_discount = $coupon_details->discount_amt * 100;
                        elseif (strtoupper($coupon_details->type) == "PERCENTAGE") :
                            $coupon_discount = $cart_total->total * ($coupon_details->discount_percentage / 100);
                            if ($coupon_discount / 100 > $coupon_details->allowed_max_discount) {
                                $cart_total->applied_coupon_discount = $coupon_details->allowed_max_discount * 100;
                            } else {
                                $cart_total->applied_coupon_discount = $cart_total->total * ($coupon_details->discount_percentage / 100);
                            }
                        endif;
                        break;
                    case "PRODUCT":
                        $coupon_details = $this->offer_model->get_coupon_by_id($cart_total->applied_coupon_id);
                        foreach ($coupon_applied->prod_ids as $prod_id) :
                            array_push($cart_total->applied_coupon_product_ids, $prod_id);
                            if (strtoupper($coupon_details->type) == "FLAT") :
                                $cart_total->applied_coupon_discount += $coupon_details->discount_amt * 100;
                            elseif (strtoupper($coupon_details->type) == "PERCENTAGE") :
                                foreach ($cart as $item) {
                                    if ($item->product_id == $prod_id) :
                                        $coupon_discount = $item->total_price * ($coupon_details->discount_percentage / 100);
                                        if ($coupon_discount / 100 > $coupon_details->allowed_max_discount) {
                                            $cart_total->applied_coupon_discount += $coupon_details->allowed_max_discount * 100;
                                        } else {
                                            $cart_total->applied_coupon_discount += $coupon_discount;
                                        }
                                        break;
                                    endif;
                                }
                            endif;
                        endforeach;
                        break;
                    case "CATEGORY":
                        break;
                    case "FREESHIP":
                        $cart_total->applied_coupon_discount = $cart_total->shipping_cost + $cart_total->total_tax_charges;
                        break;
                    case "EXHIBITION":
                        if ($cod) :
                            $cart_total->applied_coupon_discount = $cart_total->shipping_cost + $cart_total->total_cod_charges + $cart_total->total_tax_charges;
                        else :
                            $cart_total->applied_coupon_discount = $cart_total->shipping_cost + $cart_total->total_tax_charges;
                        endif;
                        break;
                endswitch;
                if ($cart_total->total_price < $cart_total->applied_coupon_discount) {
                    $cart_total->applied_coupon_discount = $cart_total->total_price;
                }
                $cart_total->total_price = $cart_total->total_price - $cart_total->applied_coupon_discount;
                if ($cart_total->total_price < 0) {
                    $cart_total->total_price = 0;
                }
            }
            $this->session->set_userdata('mds_shopping_cart_total', $cart_total);
            if ($this->auth_check) {
                $user_id = $this->auth_user->id;
                $this->save_cart_total_db($user_id, $cart_total);
            }
        }
        // return  $cart_total->actual_shipping_charges;
        // var_dump($this->session->get_userdata('mds_shopping_cart_total', $cart_total));die();
    }

    //calculate cart total
    public function set_cart_total_from_db($user_cart)
    {

        $cart_total = new stdClass();
        $cart_total->subtotal = $user_cart->subtotal;
        $cart_total->gst = $user_cart->gst;
        $cart_total->shipping_cost = $user_cart->shipping_cost;
        $cart_total->total = $user_cart->total;
        $cart_total->currency = $user_cart->currency;
        $cart_total->is_stock_available = $user_cart->is_stock_available;
        $cart_total->discount = $user_cart->discount;
        $cart_total->order_total = $user_cart->order_total;
        $cart_total->total_price = $user_cart->total_price;

        //coupon code
        $cart_total->applied_coupon_id = $user_cart->applied_coupon_id;
        $cart_total->applied_coupon_source_type = $user_cart->applied_coupon_source_type;
        $cart_total->applied_coupon_code = $user_cart->applied_coupon_code;
        $cart_total->applied_coupon_discount = $user_cart->applied_coupon_discount;

        //coupon code reset
        $coupon = new stdClass();
        $coupon->id = $user_cart->applied_coupon_id;
        $coupon->source_type = $user_cart->applied_coupon_source_type;
        $coupon->offer_code = $user_cart->applied_coupon_source_type;
        $this->session->set_userdata('mds_shopping_cart_coupon', $coupon);

        $this->session->set_userdata('mds_shopping_cart_total', $cart_total);
    }

    //calculate total vat
    public function calculate_total_gst($price_calculated, $gst_rate, $quantity)
    {
        if (!empty($price_calculated)) {
            $price = $price_calculated / 100;
            $vat = calculate_gst($price, $gst_rate) * $quantity;

            if (!is_int($vat)) {
                $vat = round($vat, 2);
            }
            return $vat * 100;
        }
        return 0;
    }

    //get cart items session
    public function get_sess_cart_items()
    {
        // $_SESSION["mds_shopping_cart"][0]->additional_info = "test";
        // $this->session->set_userdata('additional_info', 'hjg');
        $cart = array();
        $new_cart = array();
        $this->cart_product_ids = array();
        if (!empty($this->session->userdata('mds_shopping_cart'))) {
            $cart = $this->session->userdata('mds_shopping_cart');
        }
        foreach ($cart as $cart_item) {
            $product = $this->product_model->get_active_product($cart_item->product_id);
            $deliverable_by_pin = $product->deliverable;
            if (!empty($product)) {
                //if purchase type is bidding
                if ($cart_item->purchase_type == 'bidding') {
                    $this->load->model('bidding_model');
                    $quote_request = $this->bidding_model->get_quote_request($cart_item->quote_request_id);
                    if (!empty($quote_request) && $quote_request->status == 'pending_payment') {
                        $item = new stdClass();
                        $item->cart_item_id = $cart_item->cart_item_id;
                        $item->product_id = $product->id;
                        $item->product_type = $cart_item->product_type;
                        $item->product_title = $cart_item->product_title;
                        $item->options_array = $cart_item->options_array;
                        $item->quantity = $cart_item->quantity;
                        $item->unit_price = $quote_request->price_offered / $quote_request->product_quantity;
                        $item->total_price = $quote_request->price_offered;
                        $item->discount_rate = 0;
                        $item->currency = $product->currency;
                        $item->product_gst = 0;
                        $item->shipping_cost = $quote_request->shipping_cost;
                        $item->purchase_type = $cart_item->purchase_type;
                        $item->quote_request_id = $cart_item->quote_request_id;
                        $item->is_stock_available = 1;
                        if ($this->form_settings->shipping != 1) {
                            $item->shipping_cost = 0;
                        }
                        array_push($new_cart, $item);
                    }
                } else {

                    $object = $this->get_product_price_and_stock($product, $cart_item->product_title, $cart_item->options_array);
                    $price = calculate_product_price($product->price, $product->discount_rate, $product->gst_rate, $product->listing_price);
                    $item = new stdClass();
                    $item->cart_item_id = $cart_item->cart_item_id;
                    $item->product_id = $product->id;
                    $item->parent_category_id = get_parent_categories_tree($product->category_id)[0]->id;
                    $item->product_type = $cart_item->product_type;
                    $item->product_title = $cart_item->product_title;
                    // $item->product_pickup_address = $product->product_address . " " . $product->product_area . " " . $product->product_city . " " . $product->product_state . " " . $product->product_pincode;

                    $item->product_pickup_address = $product->product_pincode;
                    if (!empty($cart_item->product_deliverable)) :
                        $item->product_deliverable = $cart_item->product_deliverable;
                    else :
                        $item->product_deliverable = $deliverable_by_pin;
                    endif;


                    if ($product->add_meet == 'Made to order') :
                        $item->product_dispatch_time = get_transit_time_for_home_cook($product, "time");
                    else :
                        $item->product_dispatch_time = check_for_days($product) * 86400;
                    endif;

                    $item->product_delivery_area = $product->delivery_area;
                    $item->options_array = $cart_item->options_array;
                    $item->quantity = $cart_item->quantity;

                    if (!empty($cart_item->expected_delivery_date))
                        $item->expected_delivery_date = $cart_item->expected_delivery_date;
                    if (!empty($cart_item->expected_delivery_time))
                        $item->expected_delivery_time = $cart_item->expected_delivery_time;


                    if (!empty($cart_item->delivery_address))
                        $item->delivery_address = $cart_item->delivery_address;
                    if (!empty($cart_item->delivery_distance))
                        $item->delivery_distance = $cart_item->delivery_distance;
                    if (!empty($cart_item->delivery_city))
                        $item->delivery_city = $cart_item->delivery_city;

                    if (!empty($cart_item->parent_category_id)) :
                        if ($cart_item->parent_category_id == 2) :
                            $item->delivery_partner = "NOW-BIKES";
                        else :
                            $item->delivery_partner = "SHIPROCKET";
                        endif;
                    endif;

                    if (!empty($cart_item->delivery_distance)) :
                        $dist_value = $cart_item->delivery_distance->value;
                        $product_area = $cart_item->product_delivery_area;

                        //checking for home cooks
                        if (!empty($cart_item->parent_category_id) && ($cart_item->parent_category_id == 2)) :
                            $NCR_array = ["DELHI", "NEW DELHI", "FARIDABAD", "GURUGRAM", "GURGAON", "NOIDA"];
                            if (in_array(strtoupper($item->delivery_city), $NCR_array)) {
                                $item->product_delivery_in_NCR = 1;
                            } else {
                                $item->product_delivery_in_NCR = 0;
                            }
                            $now_bike_distance = intval($this->general_settings->now_bike_distance);
                            if ($dist_value > $now_bike_distance) {
                                $item->product_deliverable = 0;
                            } else {
                                $item->product_deliverable = 1;
                            }
                            $item->delivery_partner = "NOW-BIKES";
                        endif;

                        //checking for the seller area selected
                        $distance_array = ["5 km", "10 km", "20 km", "30 km", "40 km", "50 km"];

                        if (in_array($product_area, $distance_array)) {
                            $product_area_arr = explode(" ", $product_area);
                            $product_area_val = $product_area_arr[0] * 1000;
                            if ($product_area_val < $dist_value) {
                                $item->product_deliverable = 0;
                            }
                        }

                    endif;

                    if ($deliverable_by_pin != 1) {
                        $item->product_deliverable = $deliverable_by_pin;
                    }

                    //exhibition Check for deliverable
                    if ($this->general_settings->enable_exhibition) :
                        if ($this->product_model->check_exhibition_enabled($item->product_id)) :
                            $item->product_deliverable = 1;
                        endif;
                    endif;

                    //SELF shipment check
                    $seller_shipping_details = get_user_shipping_type($product->user_id);
                    if ($seller_shipping_details) :
                        $item->delivery_partner = $seller_shipping_details->shipping_service_provider;
                    endif;


                    $item->unit_price = $object->price_calculated;
                    $item->total_price = $object->price_calculated * $cart_item->quantity;
                    $item->discount_rate = $object->discount_rate;
                    $item->discount_amount = round((($object->price) * ($object->discount_rate)) / 10000);
                    $item->currency = $product->currency;
                    $item->listing_price = $object->price;
                    $item->product_gst_rate = $product->gst_rate;
                    $item->product_gst = $this->calculate_total_gst($object->price_calculated, $product->gst_rate, $cart_item->quantity);
                    $item->shipping_cost = $this->get_product_shipping_cost($product, $cart_item->quantity);
                    $item->product_pincode = $product->product_pincode;

                    if (empty($object->weight))
                        $item->weight = $product->weight;
                    else
                        $item->weight = $object->weight;

                    $item->cod_accepted = $product->cod_accepted;
                    $item->shipping_cost_type = $product->shipping_cost_type;

                    // $item->shipping_cost = floatval($cart_item->shipping_cost);
                    $item->purchase_type = $cart_item->purchase_type;
                    $item->quote_request_id = $cart_item->quote_request_id;
                    $item->is_stock_available = $object->is_stock_available;
                    $item->variation_option = $object->variation_option;

                    $item->additional_info = $cart_item->additional_info;
                    if ($this->form_settings->shipping != 1) {
                        $item->shipping_cost = 0;
                    }
                    array_push($new_cart, $item);
                }
            }
        }
        $this->session->set_userdata('mds_shopping_cart', $new_cart);
        return $new_cart;
    }
    // get address /
    public function get_shipping_details($user_id)
    {
        $sql = "SELECT * FROM shipping_info WHERE user_id = ? AND is_active = 1 ";
        $query = $this->db->query($sql, array(clean_number($user_id)));
        return $query->result();
    }
    //update shipping info
    public function edit_shipping_address($id)
    {
        $data = array(
            'f_name' => trim($this->input->post('shipping_first_name', true)),
            'l_name' => trim($this->input->post('shipping_last_name', true)),
            'email' => trim($this->input->post('shipping_email', true)),
            'ph_number' => trim($this->input->post('shipping_phone_number', true)),
            'zip_code' => trim($this->input->post('shipping_zip_code', true)),
            'state' => trim($this->input->post('shipping_state', true)),
            'city' => trim($this->input->post('shipping_city', true)),
            'area' => trim($this->input->post('shipping_area', true)),
            'h_no' => trim($this->input->post('shipping_address_1', true)),
            'landmark' => trim($this->input->post('shipping_landmark', true)),
            'address_type' => trim($this->input->post('address_type_modal', true)),
            'created_date' => date("Y-m-d H:i:s"),
            'updated_date' => date("Y-m-d H:i:s"),

        );
        if ($this->auth_check) {
            $data['user_id'] = $this->auth_user->id;
            $data['created_by'] = $this->auth_user->id;
            $data['updated_by'] = $this->auth_user->id;
        } else {
            if (empty($data['user_id'])) {
                return false;
            }
        }
        // $address = $this->get_update_address($id);

        $this->db->where('id', $id);
        return $this->db->update('shipping_info', $data);
    }

    public function get_update_address($id)
    {
        $this->db->where('shipping_info.id', clean_number($id));
        return $this->db->get('shipping_info')->row();
    }

    //shipping address
    public function add_shipping_address()
    {
        $data = array(

            'f_name' => trim($this->input->post('shipping_first_name', true)),
            'l_name' => trim($this->input->post('shipping_last_name', true)),
            'email' => trim($this->input->post('shipping_email', true)),
            'ph_number' => trim($this->input->post('shipping_phone_number', true)),
            'zip_code' => trim($this->input->post('shipping_zip_code', true)),
            'state' => trim($this->input->post('shipping_state', true)),
            'city' => trim($this->input->post('shipping_city', true)),
            'area' => trim($this->input->post('shipping_area', true)),
            'h_no' => trim($this->input->post('shipping_address_1', true)),
            'landmark' => trim($this->input->post('shipping_landmark', true)),
            'address_type' => trim($this->input->post('address_type', true)),
            'created_date' => date("Y-m-d H:i:s"),
            'updated_date' => date("Y-m-d H:i:s"),

        );
        if ($this->auth_check) {
            $data['user_id'] = $this->auth_user->id;
            $data['created_by'] = $this->auth_user->id;
            $data['updated_by'] = $this->auth_user->id;
        } else {
            if (empty($data['user_id'])) {
                return false;
            }
        }
        $this->db->insert('shipping_info', $data);
    }
    //set cart shipping address session
    public function set_sess_cart_shipping_address()
    {
        $cart = $this->cart_model->get_sess_cart_items();
        if ($this->auth_check) {
            $user_id = $this->auth_user->id;
            // if (!empty($cart)) {
            //     $cart_id = $this->get_cart_id_db($this->auth_user->id);
            // }
            if (empty($cart)) {
                // $this->add_cart_db($this->auth_user->id);
                $cart_id = $this->add_cart_db($this->auth_user->id);
            } else {
                $cart_id = $this->get_cart_id_db($this->auth_user->id);
            }
        }

        $std = new stdClass();
        $std->shipping_first_name = $this->input->post('shipping_first_name', true);
        $std->shipping_last_name = $this->input->post('shipping_last_name', true);
        $std->shipping_email = $this->input->post('shipping_email', true);
        $std->shipping_phone_number = $this->input->post('shipping_phone_number', true);
        $std->shipping_zip_code = $this->input->post('shipping_zip_code', true);
        $std->shipping_state = $this->input->post('shipping_state', true);
        $std->shipping_city = $this->input->post('shipping_city', true);
        $std->shipping_area = $this->input->post('shipping_area', true);
        $std->shipping_address_1 = $this->input->post('shipping_address_1', true);
        $std->shipping_landmark = $this->input->post('shipping_landmark', true);
        //$std->shipping_address_2 = $this->input->post('shipping_address_2', true);
        //$std->shipping_country_id = $this->input->post('shipping_country_id', true);
        $std->billing_first_name = $this->input->post('billing_first_name', true);
        $std->billing_last_name = $this->input->post('billing_last_name', true);
        $std->billing_email = $this->input->post('billing_email', true);
        $std->billing_phone_number = $this->input->post('billing_phone_number', true);
        $std->billing_zip_code = $this->input->post('billing_zip_code', true);
        $std->billing_state = $this->input->post('billing_state', true);
        $std->billing_city = $this->input->post('billing_city', true);
        $std->billing_area = $this->input->post('billing_area', true);
        $std->billing_address_1 = $this->input->post('billing_address_1', true);
        $std->billing_landmark = $this->input->post('billing_landmark', true);
        //$std->billing_address_2 = $this->input->post('billing_address_2', true);
        //$std->billing_country_id = $this->input->post('billing_country_id', true);
        $std->use_same_address_for_billing = $this->input->post('use_same_address_for_billing', true);
        if (!isset($std->use_same_address_for_billing)) {
            $std->use_same_address_for_billing = 0;
        }

        if ($std->use_same_address_for_billing == 1) {
            $std->billing_first_name = $std->shipping_first_name;
            $std->billing_last_name = $std->shipping_last_name;
            $std->billing_email = $std->shipping_email;
            $std->billing_phone_number = $std->shipping_phone_number;
            $std->billing_zip_code = $std->shipping_zip_code;
            $std->billing_state = $std->shipping_state;
            $std->billing_city = $std->shipping_city;
            $std->billing_area = $std->shipping_area;
            $std->billing_address_1 = $std->shipping_address_1;
            $std->billing_landmark = $std->shipping_landmark;
        } else {
            if (empty($std->billing_first_name)) {
                $std->billing_first_name = $std->shipping_first_name;
            }
            if (empty($std->billing_last_name)) {
                $std->billing_last_name = $std->shipping_last_name;
            }
            if (empty($std->billing_email)) {
                $std->billing_email = $std->shipping_email;
            }
            if (empty($std->billing_phone_number)) {
                $std->billing_phone_number = $std->shipping_phone_number;
            }
            if (empty($std->billing_address_1)) {
                $std->billing_address_1 = $std->shipping_address_1;
            }
            // if (empty($std->billing_address_2)) {
            //     $std->billing_address_2 = $std->shipping_address_2;
            // }
            // if (empty($std->billing_country_id)) {
            //     $std->billing_country_id = $std->shipping_country_id;
            // }
            if (empty($std->billing_state)) {
                $std->billing_state = $std->shipping_state;
            }
            if (empty($std->billing_city)) {
                $std->billing_city = $std->shipping_city;
            }
            if (empty($std->billing_zip_code)) {
                $std->billing_zip_code = $std->shipping_zip_code;
            }
            if (empty($std->billing_area)) {
                $std->billing_area = $std->shipping_area;
            }
            if (empty($std->billing_landmark)) {
                $std->billing_landmark = $std->shipping_landmark;
            }
        }
        $this->session->set_userdata('mds_cart_shipping_address', $std);
        if (!empty($cart_id)) :
            $this->save_session_shipping_address_db($cart_id, $user_id, $std);
        endif;
        $this->add_delivery_distance();
    }

    //set cart shipping address session
    public function set_sess_cart_shipping_address_from_db($shipping_address)
    {
        $std = new stdClass();
        $std->shipping_first_name = $shipping_address[0]->shipping_first_name;
        $std->shipping_last_name = $shipping_address[0]->shipping_last_name;
        $std->shipping_email = $shipping_address[0]->shipping_email;
        $std->shipping_phone_number = $shipping_address[0]->shipping_phone_number;
        $std->shipping_zip_code = $shipping_address[0]->shipping_zip_code;
        $std->shipping_state = $shipping_address[0]->shipping_state;
        $std->shipping_city = $shipping_address[0]->shipping_city;
        $std->shipping_area = $shipping_address[0]->shipping_area;
        $std->shipping_address_1 = $shipping_address[0]->shipping_address_1;
        $std->shipping_landmark = $shipping_address[0]->shipping_landmark;
        //$std->shipping_address_2 = $this->input->post('shipping_address_2', true);
        //$std->shipping_country_id = $this->input->post('shipping_country_id', true);
        $std->billing_first_name = $shipping_address[0]->billing_first_name;
        $std->billing_last_name = $shipping_address[0]->billing_last_name;
        $std->billing_email = $shipping_address[0]->billing_email;
        $std->billing_phone_number = $shipping_address[0]->billing_phone_number;
        $std->billing_zip_code = $shipping_address[0]->billing_zip_code;
        $std->billing_state = $shipping_address[0]->billing_state;
        $std->billing_city = $shipping_address[0]->billing_city;
        $std->billing_area = $shipping_address[0]->billing_area;
        $std->billing_address_1 = $shipping_address[0]->billing_address_1;
        $std->billing_landmark = $shipping_address[0]->billing_landmark;
        //$std->billing_address_2 = $this->input->post('billing_address_2', true);
        //$std->billing_country_id = $this->input->post('billing_country_id', true);
        $std->use_same_address_for_billing = $shipping_address[0]->use_same_address_for_billing;
        if (!isset($std->use_same_address_for_billing)) {
            $std->use_same_address_for_billing = 0;
        }
        if ($std->use_same_address_for_billing == 1) {
            $std->billing_first_name = $std->shipping_first_name;
            $std->billing_last_name = $std->shipping_last_name;
            $std->billing_email = $std->shipping_email;
            $std->billing_phone_number = $std->shipping_phone_number;
            $std->billing_zip_code = $std->shipping_zip_code;
            $std->billing_state = $std->shipping_state;
            $std->billing_city = $std->shipping_city;
            $std->billing_area = $std->shipping_area;
            $std->billing_address_1 = $std->shipping_address_1;
            $std->billing_landmark = $std->shipping_landmark;
        } else {
            if (empty($std->billing_first_name)) {
                $std->billing_first_name = $std->shipping_first_name;
            }
            if (empty($std->billing_last_name)) {
                $std->billing_last_name = $std->shipping_last_name;
            }
            if (empty($std->billing_email)) {
                $std->billing_email = $std->shipping_email;
            }
            if (empty($std->billing_phone_number)) {
                $std->billing_phone_number = $std->shipping_phone_number;
            }
            if (empty($std->billing_address_1)) {
                $std->billing_address_1 = $std->shipping_address_1;
            }
            // if (empty($std->billing_address_2)) {
            //     $std->billing_address_2 = $std->shipping_address_2;
            // }
            // if (empty($std->billing_country_id)) {
            //     $std->billing_country_id = $std->shipping_country_id;
            // }
            if (empty($std->billing_state)) {
                $std->billing_state = $std->shipping_state;
            }
            if (empty($std->billing_city)) {
                $std->billing_city = $std->shipping_city;
            }
            if (empty($std->billing_zip_code)) {
                $std->billing_zip_code = $std->shipping_zip_code;
            }
            if (empty($std->billing_area)) {
                $std->billing_area = $std->shipping_area;
            }
            if (empty($std->billing_landmark)) {
                $std->billing_landmark = $std->shipping_landmark;
            }
        }
        $this->session->set_userdata('mds_cart_shipping_address', $std);
    }


    // public function add_additional_info()
    // {
    //     $std_new = new stdClass();
    //     $row = null;
    //     $std_new = $this->get_sess_cart_shipping_address();
    //     if ($this->auth_check) {
    //         $row = $this->profile_model->get_user_shipping_address($this->auth_user->id);
    //     } else {
    //         $row = $this->profile_model->get_user_shipping_address(null);
    //     }
    //     $row1 = $this->get_shipping_details($this->auth_user->id);
    //     var_dump($row1);
    // }

    //get cart shipping address session
    public function get_sess_cart_shipping_address()
    {
        if (!empty($this->session->userdata('mds_cart_shipping_address'))) {
            return $this->session->userdata('mds_cart_shipping_address');
        }
        $std = new stdClass();
        $row = null;

        if ($this->auth_check) {
            $row = $this->profile_model->get_user_shipping_address($this->auth_user->id);
        } else {
            $row = $this->profile_model->get_user_shipping_address(null);
        }
        $std->shipping_first_name = $row->shipping_first_name;
        $std->shipping_last_name = $row->shipping_last_name;
        $std->shipping_email = $row->shipping_email;
        $std->shipping_phone_number = $row->shipping_phone_number;
        $std->shipping_zip_code = $row->shipping_zip_code;
        $std->shipping_state = $row->shipping_state;
        $std->shipping_city = $row->shipping_city;
        $std->shipping_area = $row->shipping_area;
        $std->shipping_address_1 = $row->shipping_address_1;
        $std->shipping_landmark = $row->shipping_landmark;
        // $std->shipping_address_2 = $row->shipping_address_2;
        // $std->shipping_country_id = $row->shipping_country_id;
        $std->billing_first_name = $row->shipping_first_name;
        $std->billing_last_name = $row->shipping_last_name;
        $std->billing_email = $row->shipping_email;
        $std->billing_phone_number = $row->shipping_phone_number;
        $std->billing_zip_code = $row->shipping_zip_code;
        $std->billing_state = $row->shipping_state;
        $std->billing_city = $row->shipping_city;
        $std->billing_area = $row->shipping_area;
        $std->billing_address_1 = $row->shipping_address_1;
        $std->billing_landmark = $row->shipping_landmark;
        // $std->billing_address_2 = $row->shipping_address_2;
        // $std->billing_country_id = $row->shipping_country_id;
        $std->use_same_address_for_billing = 1;
        $this->session->unset_userdata('mds_cart_shipping_address');
        return $std;
    }

    //check cart has physical products
    public function check_cart_has_physical_product()
    {
        $cart_items = $this->cart_model->get_sess_cart_items();

        if (!empty($cart_items)) {
            foreach ($cart_items as $cart_item) {
                if ($cart_item->product_type == 'physical') {
                    return true;
                }
            }
        }
        return false;
    }
    public function check_cart_has_made_to_order_product()
    {
        $cart_items = $this->cart_model->get_sess_cart_items();
        if (!empty($cart_items)) {
            foreach ($cart_items as $cart_item) {
                if ($cart_item->add_meet == 'Made to order') {
                    return true;
                }
            }
        }
        return false;
    }

    //check cart has digital products
    public function check_cart_has_digital_product()
    {
        $cart_items = $this->cart_model->get_sess_cart_items();
        if (!empty($cart_items)) {
            foreach ($cart_items as $cart_item) {
                if ($cart_item->product_type == 'digital') {
                    return true;
                }
            }
        }
        return false;
    }

    //validate cart
    public function validate_cart()
    {
        $cart_total = $this->cart_model->get_sess_cart_total();
        if (!empty($cart_total)) {
            if ($cart_total->total <= 0 || $cart_total->is_stock_available != 1) {
                redirect(generate_url("cart"));
                exit();
            }
        }
    }

    //unset cart items session
    public function unset_sess_cart_items()
    {
        if (!empty($this->session->userdata('mds_shopping_cart'))) {
            $this->session->unset_userdata('mds_shopping_cart');
        }
    }

    //unset cart coupon
    public function unset_sess_cart_coupon()
    {
        if (!empty($this->session->userdata('mds_shopping_cart_coupon'))) {
            $this->session->unset_userdata('mds_shopping_cart_coupon');
        }
    }

    //unset cart items session
    public function unset_cart_items_from_db_after_purcahse()
    {
        $cart = $this->cart_model->get_sess_cart_items();
        if (!empty($cart)) {
            foreach ($cart as $item) {
                if ($this->auth_check) {
                    $this->remove_from_cart_product_db($item->cart_item_id);
                }
            }
            $this->remove_from_cart_db($this->auth_user->id);
        }
    }

    //get cart total session
    public function get_sess_cart_total()
    {
        $cart_total = new stdClass();
        if (!empty($this->session->userdata('mds_shopping_cart_total'))) {
            $cart_total = $this->session->userdata('mds_shopping_cart_total');
        }
        return $cart_total;
    }

    //set cart payment method option session
    public function set_sess_cart_payment_method()
    {
        $std = new stdClass();
        $std->payment_option = $this->input->post('payment_option', true);
        $std->terms_conditions = $this->input->post('terms_conditions', true);
        $this->session->set_userdata('mds_cart_payment_method', $std);


        if ($this->auth_check) {
            $user_id = $this->auth_user->id;
            $this->save_cart_payment_method_db($user_id, $std);
        }
    }

    //set cart payment method option session
    public function set_sess_cart_payment_method_from_db($user_cart)
    {
        $std = new stdClass();
        $std->payment_option = $user_cart->payment_option;
        $std->terms_conditions = $user_cart->terms_conditions;
        $this->session->set_userdata('mds_cart_payment_method', $std);
    }

    //get cart payment method option session
    public function get_sess_cart_payment_method()
    {
        if (!empty($this->session->userdata('mds_cart_payment_method'))) {
            return $this->session->userdata('mds_cart_payment_method');
        }
    }

    //unset cart payment method option session
    public function unset_sess_cart_payment_method()
    {
        if (!empty($this->session->userdata('mds_cart_payment_method'))) {
            $this->session->unset_userdata('mds_cart_payment_method');
        }
    }

    //unset cart shipping address session
    public function unset_sess_cart_shipping_address()
    {
        if (!empty($this->session->userdata('mds_cart_shipping_address'))) {
            $this->session->unset_userdata('mds_cart_shipping_address');
        }
    }

    //clear cart
    public function clear_cart()
    {
        $this->unset_sess_cart_items();
        $this->unset_sess_cart_coupon();
        $this->unset_sess_cart_payment_method();
        $this->unset_sess_cart_shipping_address();
    }


    public function save_session_shipping_address_db($cart_id, $user_id, $std)
    {

        $session_shipping = array(
            // "cart_id" => $cart_id,
            // "user_id" => $user_id,
            "shipping_first_name" => $std->shipping_first_name,
            "shipping_last_name" => $std->shipping_last_name,
            "shipping_email" => $std->shipping_email,
            "shipping_phone_number" => $std->shipping_phone_number,
            "shipping_zip_code" => $std->shipping_zip_code,
            "shipping_state" => $std->shipping_state,
            "shipping_city" => $std->shipping_city,
            "shipping_area" => $std->shipping_area,
            "shipping_address_1" => $std->shipping_address_1,
            "shipping_landmark" => $std->shipping_landmark,
            "billing_first_name" => $std->billing_first_name,
            "billing_last_name" => $std->billing_last_name,
            "billing_email" => $std->billing_email,
            "billing_phone_number" => $std->billing_phone_number,
            "billing_zip_code" => $std->billing_zip_code,
            "billing_state" => $std->billing_state,
            "billing_city" => $std->billing_city,
            "billing_city" => $std->billing_city,
            "billing_area" => $std->billing_area,
            "billing_address_1" => $std->billing_address_1,
            "billing_landmark" => $std->billing_landmark,
            "use_same_address_for_billing" => $std->use_same_address_for_billing
        );
        // $this->db->insert('session_shipping_address', $session_shipping);
        $this->db->where('id', $cart_id);
        $this->db->update('cart', $session_shipping);
    }


    public function save_cart_total_db($user_id, $cart_total)
    {
        $cart_total_db = array(
            "subtotal" => $cart_total->subtotal,
            "gst" => $cart_total->gst,
            "shipping_cost" => $cart_total->shipping_cost,
            "total" => $cart_total->total,
            "currency" => $cart_total->currency,
            "is_stock_available" => $cart_total->is_stock_available,
            "discount" => $cart_total->discount,
            "order_total" => $cart_total->order_total,
            "total_price" => $cart_total->total_price,
            "applied_coupon_id" => $cart_total->applied_coupon_id,
            "applied_coupon_source_type" => $cart_total->applied_coupon_source_type,
            "applied_coupon_code" => $cart_total->applied_coupon_code,
            "applied_coupon_discount" => $cart_total->applied_coupon_discount,
            "created_by" => $this->auth_user->id,
            "updated_by" => $this->auth_user->id
        );
        $this->db->where('user_id', $user_id);
        $this->db->where('is_active', '1');
        $this->db->update('cart', $cart_total_db);
    }

    public function save_cart_payment_method_db($user_id, $std)
    {
        $payment_method_db = array(
            "payment_option" => $std->payment_option,
            "terms_conditions" => $std->terms_conditions
        );
        $this->db->where('user_id', $user_id);
        $this->db->where('is_active', '1');
        $this->db->update('cart', $payment_method_db);
    }



    public function set_sess_add_additional_info($product)
    {
        $data = array();
        $additional_info = $this->input->post("additional_info_text_" . $product->id);
        $cart = array();
        $new_cart = array();
        $this->cart_product_ids = array();
        if (!empty($this->session->userdata('mds_shopping_cart'))) {
            $cart = $this->session->userdata('mds_shopping_cart');
        }
        foreach ($cart as $cart_item) {
            if ($cart_item->product_id == $product->id)
                $cart_item->additional_info = $additional_info;
            array_push($new_cart, $cart_item);
        }
        $data["additional_info"] = $additional_info;
        $this->db->where('product_id', $product->id);
        $this->db->where('is_active', '1');
        $this->db->update('cart_product_details', $data);

        $this->session->set_userdata('mds_shopping_cart', $new_cart);
        return $new_cart;
    }
    public function add_delivery_distance()
    {
        $shipping_address = $this->session->userdata('mds_cart_shipping_address');

        $cart = array();
        $new_cart = array();
        $this->cart_product_ids = array();
        if (!empty($this->session->userdata('mds_shopping_cart'))) {
            $cart = $this->session->userdata('mds_shopping_cart');
        }
        foreach ($cart as $cart_item) {
            $product_pickup_address = $cart_item->product_pickup_address;
            // $cart_item->delivery_address = $shipping_address->shipping_area . " " . $shipping_address->shipping_city . " " . $shipping_address->shipping_state . " " . $shipping_address->shipping_zip_code;

            $product_pickup_address1 = $cart_item->product_pickup_address;
            // var_dump($cart_item);
            // die();
            $cart_item->delivery_address = $shipping_address->shipping_zip_code;
            $cart_item->delivery_city = $shipping_address->shipping_city;
            $cart_item->delivery_address1 = $shipping_address->shipping_city . $shipping_address->shipping_zip_code;
            $distance_matrix = $this->profile_model->product_deliverale_or_not($product_pickup_address1, $cart_item->delivery_address1);
            // var_dump($distance_matrix->rows[0]->elements[0]->distance);
            if (isset($distance_matrix->rows[0]->elements[0]->distance)) {
                $cart_item->delivery_distance = $distance_matrix->rows[0]->elements[0]->distance;

                $dist_value = $cart_item->delivery_distance->value;
                $product_area = $cart_item->product_delivery_area;

                $distance_array = ["5 km", "10 km", "20 km", "30 km", "40 km", "50 km"];

                if (in_array($product_area, $distance_array)) {
                    $product_area_arr = explode(" ", $product_area);
                    $product_area_val = $product_area_arr[0] * 1000;
                    if ($product_area_val < $dist_value) {
                        $cart_item->product_deliverable = 0;
                    }
                }
            } else {
                $cart_item->delivery_distance->value = 0;
                $cart_item->product_deliverable = 1;
            }
            //exhibition Check for deliverable
            // if ($this->general_settings->enable_exhibition) :
            //     if ($this->product_model->check_exhibition_enabled($cart_item->product_id)) :
            //         $cart_item->product_deliverable = 1;
            //     endif;
            // endif;

            array_push($new_cart, $cart_item);
        }
        $this->session->set_userdata('mds_shopping_cart', $new_cart);
        // var_dump($_SESSION["mds_shopping_cart"]);
        // die();
        // return $new_cart;
    }

    public function get_payment_modes()
    {
        $this->db->order_by("meaning", "asc");
        $query = $this->db->get('payment_methods');
        return $query->result();
    }
    public function get_nb_banks()
    {
        $this->db->where('gateway_code', 'nb');
        $this->db->where('enabled_flag', '1');
        $this->db->order_by("meaning", "asc");
        $query = $this->db->get('payment_method_options');
        return $query->result();
    }
    public function get_wallets()
    {
        $this->db->where('gateway_code', 'wallet');
        $this->db->where('enabled_flag', '1');
        $this->db->order_by("meaning", "asc");
        $query = $this->db->get('payment_method_options');
        return $query->result();
    }

    //get last ordered products by the buyer
    public function get_last_ordered_products($order_id)
    {
        $order_id = clean_number($order_id);
        $this->db->where('order_id', $order_id);
        $this->db->where('order_status', 'completed');
        $this->db->order_by("updated_at", "desc");
        $query = $this->db->get('order_products');
        return $query->result();
    }

    public function calc_seller_cart_total()
    {
        $cart_items = $this->cart_model->get_sess_cart_items();
        if (empty($cart_items)) {
            return false;
        }
        //creating product list seller wise

        $product_seller_details = array();
        foreach ($cart_items as $cart_item) {
            $object = new stdClass();
            $object->seller_id = get_active_product($cart_item->product_id)->user_id;
            $new = true;
            foreach ($product_seller_details as $psd) {
                if ($psd->seller_id == $object->seller_id) {
                    $object_product = new stdClass();
                    $object_product->product_id = $cart_item->product_id;
                    $object_product->parent_category_id = $cart_item->parent_category_id;
                    $object_product->product_quantity = $cart_item->quantity;
                    $object_product->product_unit_price = $cart_item->unit_price;
                    $object_product->product_total_price = $cart_item->total_price;


                    // if (count($psd->products) > 0) {
                    //     foreach ($psd->products as $prod) {
                    //         if (floatval($object_product->product_gst_rate) > floatval($prod->product_gst_rate)) {
                    //             // $psd->seller_gst_rate = $object_product->product_gst_rate;
                    //         }
                    //     }
                    // }
                    array_push($psd->products, $object_product);

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
                $object_product->product_unit_price = $cart_item->unit_price;
                $object_product->product_total_price = $cart_item->total_price;
                // var_dump($cart_item->options_array);

                array_push($object->products, $object_product);


                // $object->seller_gst_rate = $object_product->product_gst_rate;

                // if ($object_product->free_shipping)
                //     $object->total_weight = $object_product->product_total_packaged_weight;
                // else
                //     $object->total_weight = $object_product->product_total_packaged_weight;
                $object->total_price = $object_product->product_total_price;

                array_push($product_seller_details, $object);
            endif;
            // var_dump($cart_item);
        }
        return $product_seller_details;
    }


    public function get_seller_order_value($seller_id)
    {
        $seller_id = clean_number($seller_id);
        $this->db->where('id', $seller_id);
        $query = $this->db->get('users');
        return $query->row()->min_order_value;
    }
}
