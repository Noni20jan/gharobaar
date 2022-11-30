<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart_controller extends Home_Core_Controller
{
    /*
     * Payment Types
     *
     * 1. sale: Product purchases
     * 2. promote: Promote purchases
     *
     */

    public function __construct()
    {
        parent::__construct();

        $this->session_cart_items = $this->cart_model->get_sess_cart_items();
        $this->cart_model->calculate_cart_total();
    }

    /**
     * Cart
     */
    public function cart()
    {
        $data['title'] = trans("shopping_cart");
        $data['description'] = trans("shopping_cart") . " - " . $this->app_name;
        $data['keywords'] = trans("shopping_cart") . "," . $this->app_name;
        //set pagination
        //$data["user_products"] = $this->product_model->get_user_products_by_user_id($this->auth_user->id); 
        $this->cart_model->unset_sess_cart_shipping_address();
        $this->cart_model->unset_sess_cart_payment_method();
        $this->cart_model->calculate_cart_total();
        if (!empty($this->auth_user))
            $data['products'] = $this->product_model->get_user_wishlist_products($this->auth_user->id);
        $data['cart_items'] = $this->session_cart_items;
        $data['cart_total'] = $this->cart_model->get_sess_cart_total();
        $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();
        $data['main_settings'] = get_main_settings();
        if (!empty($this->session->userdata('mds_shopping_cart_coupon'))) {
            if ($this->session->userdata('mds_shopping_cart_coupon') == '0') {
                $this->session->unset_userdata('mds_shopping_cart_coupon');
            }
        }
        $data["open_rating_modal"] = false;
        if (!empty($this->auth_user)) :
            $order_id['product_id'] =  $this->product_model->get_order_id($this->auth_user->id);
            if (!empty($order_id['product_id'])) :
                $order['order_id'] = $this->product_model->get_order_product_id($order_id['product_id']->order_id, $this->auth_user->id);
                foreach ($order['order_id'] as $order1) :
                    $not_rating['exist'] = $this->product_model->get_not_rating_product($order1->product_id, $this->auth_user->id);
                    if (empty($not_rating['exist'])) :
                        $data["open_rating_modal"] = true;
                        break;
                    endif;
                endforeach;
            endif;
        endif;
        $this->load->view('partials/_header', $data);
        $this->load->view('cart/cart', $data);
        $this->load->view('partials/_footer');
    }
    /**
     * Add to Cart barter
     */
    // public function add_barter_to_cart()
    // {
    //     $product_id = $this->input->post('barter_product_id', true);
    //     $barter_request_id = $this->input->post('id', true);
    //     $product = $this->product_model->get_active_product($product_id);
    //     // if (!empty($this->cart_model->add_barter_to_cart($barter_request_id))) {
    //     //     redirect(generate_url("cart"));
    //     // }
    //     // redirect($this->agent->referrer());
    //     if (!empty($product)) {
    //         if ($product->status != 1) {
    //             $this->session->set_flashdata('product_details_error', trans("msg_error_cart_unapproved_products"));
    //         } else {
    //             $this->cart_model->add_barter_to_cart($product, $barter_request_id);
    //             //redirect(generate_url("cart"));
    //         }
    //     }
    //     redirect($this->agent->referrer());
    // }
    /**
     * Add to Cart
     */
    public function add_to_cart()
    {
        $action = $this->input->post('submit', true);
        if ($action == "add_to_cart") {
            $product_id = $this->input->post('product_id', true);

            $product = $this->product_model->get_active_product($product_id);
            if (!empty($product)) {
                if ($product->status != 1) {
                    $this->session->set_flashdata('product_details_error', trans("msg_error_cart_unapproved_products"));
                } else {
                    $this->cart_model->add_to_cart($product);
                    //redirect(generate_url("cart"));
                }
            }
            redirect($this->agent->referrer());
        } else if ($action == "buy_now") {
            $product_id = $this->input->post('product_id', true);
            $product = $this->product_model->get_active_product($product_id);
            if (!empty($product)) {
                if ($product->status != 1) {
                    $this->session->set_flashdata('product_details_error', trans("msg_error_cart_unapproved_products"));
                } else {
                    $this->cart_model->add_to_cart($product);
                    redirect(generate_url("cart"));
                }
            }
            redirect($this->agent->referrer());
        } else if ($action == "add_to_cart_from_icon") {
            $product_id = $this->input->post('product_id', true);
            $product = $this->product_model->get_active_product($product_id);
            $shop_status = $this->product_model->get_user_shop_status($product->user_id);
            if (!empty($product)) {
                if ($product->status != 1) {
                    $this->session->set_flashdata('product_details_error', trans("msg_error_cart_unapproved_products"));
                } else if ($shop_status->is_shop_open == "1") {
                    if ($product->add_meet == "Made to order") {
                        $p = $this->product_model->get_product_by_id($product->id);
                        $response = array(
                            "status" => 0,
                            "product_url" => generate_product_url($p)
                        );
                        echo json_encode($response);
                    } else {
                        $variations = $this->variation_model->get_product_variations($product->id);

                        if (!empty($variations)) {
                            $p = $this->product_model->get_product_by_id($product->id);
                            $response = array(
                                "status" => 0,
                                "product_url" => generate_product_url($p)
                            );
                            echo json_encode($response);
                        } else {
                            $this->cart_model->add_to_cart($product);
                            $response = array(
                                "status" => 1,
                                "msg" => "Successfully added to cart"
                            );

                            echo json_encode($response);
                        }
                    }
                } else if ($shop_status->is_shop_open == "0") {
                    $p = $this->product_model->get_product_by_id($product->id);
                    $response = array(
                        "status" => 0,
                        "product_url" => generate_product_url($p)
                    );
                    echo json_encode($response);
                }
            }
        }
    }
    /**
     * Add to Cart ajax
     */
    public function add_to_cart_ajax()
    {
        $action = $this->input->post('submit', true);
        if ($action == "add_to_cart") {
            $product_id = $this->input->post('product_id', true);
            $quantity = $this->input->post('product_quantity', true);
            $data['product_id'] =  $this->input->post('product_id', true);
            $data['quantity'] = $this->input->post('product_quantity', true);
            $product = $this->product_model->get_active_product($product_id);
            $data['price'] = $product->listing_price;
            $data['title'] = $product->slug;
            $data['seller_id'] = $product->user_id;
            $data['created_by'] = $this->input->ip_address();
            if (!empty($product)) {
                if ($product->status != 1) {
                    $this->session->set_flashdata('product_details_error', trans("msg_error_cart_unapproved_products"));
                } else {
                    $this->cart_model->add_to_cart($product);
                    if (!$this->auth_check) {
                        $this->product_model->add_to_cart_without_auth($data);
                    }
                }
            }

            $response = array(
                "action" => $action,
                "cart_count" => get_cart_product_count_ajax()
            );
            echo json_encode($response);
            // echo json_encode($action);
            // redirect($this->agent->referrer());
        } else if ($action == "buy_now") {
            $product_id = $this->input->post('product_id', true);
            $product = $this->product_model->get_active_product($product_id);
            if (!empty($product)) {
                if ($product->status != 1) {
                    $this->session->set_flashdata('product_details_error', trans("msg_error_cart_unapproved_products"));
                } else {
                    $this->cart_model->add_to_cart($product);
                    // redirect(generate_url("cart"));
                }
            }
            $response = array(
                "action" => $action
            );
            echo json_encode($response);
            // redirect($this->agent->referrer());
        } else if ($action == "add_to_cart_from_icon") {
            $product_id = $this->input->post('product_id', true);
            $data['product_id'] =  $product_id;
            $data['quantity'] = 1;
            $data['created_by'] = $this->input->ip_address();
            $product = $this->product_model->get_active_product($product_id);
            $data['price'] = $product->listing_price;
            $data['title'] = $product->slug;
            $data['seller_id'] = $product->user_id;
            $shop_status = $this->product_model->get_user_shop_status($product->user_id);
            if (!empty($product)) {
                if ($product->status != 1) {
                    $this->session->set_flashdata('product_details_error', trans("msg_error_cart_unapproved_products"));
                } else if ($shop_status->is_shop_open == "1") {
                    if ($product->add_meet == "Made to order") {
                        $p = $this->product_model->get_product_by_id($product->id);
                        $response = array(
                            "status" => 0,
                            "product_url" => generate_product_url($p)
                        );
                        echo json_encode($response);
                    } else {
                        $variations = $this->variation_model->get_product_variations($product->id);

                        if (!empty($variations)) {
                            $p = $this->product_model->get_product_by_id($product->id);
                            $response = array(
                                "status" => 0,
                                "product_url" => generate_product_url($p)
                            );
                            echo json_encode($response);
                        } else {
                            $this->cart_model->add_to_cart($product);
                            if (!$this->auth_check) {
                                $this->product_model->add_to_cart_without_auth($data);
                            }
                            $response = array(
                                "status" => 1,
                                "msg" => "Successfully added to cart",
                                "action" => $action,
                                "cart_count" => get_cart_product_count_ajax()
                            );

                            echo json_encode($response);
                        }
                    }
                } else if ($shop_status->is_shop_open == "0") {
                    $p = $this->product_model->get_product_by_id($product->id);
                    $response = array(
                        "status" => 0,
                        "product_url" => generate_product_url($p)
                    );
                    echo json_encode($response);
                }
            }
        }
    }

    public function add_cart_shipping_cost()
    {
        $product_id = $this->input->post('product_id', true);
        $product = $this->product_model->get_active_product($product_id);
        if (!empty($product)) {
            if ($product->status != 1) {
                $this->session->set_flashdata('product_details_error', trans("msg_error_cart_unapproved_products"));
            } else {
                $this->cart_model->add_shipping_cost_to_cart($product);
            }
        }
    }

    public function set_sess_add_additional_info()
    {
        $product_id = $this->input->post('order_product_id', true);
        $product = $this->product_model->get_active_product($product_id);
        $this->cart_model->set_sess_add_additional_info($product);
        redirect(generate_url("cart"));
    }

    public function shop_is_close()
    {
        $data['title'] = trans("shopping_cart");
        $data['description'] = trans("shopping_cart") . " - " . $this->app_name;
        $data['keywords'] = trans("shopping_cart") . "," . $this->app_name;

        $data['cart_items'] = $this->session_cart_items;
        $data['cart_total'] = $this->cart_model->get_sess_cart_total();
        $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();
        $data['main_settings'] = get_main_settings();
        $this->load->view('partials/_header', $data);
        $this->load->view('cart/shop_is_close', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Add to Cart qQuote
     */
    public function add_to_cart_quote()
    {
        $quote_request_id = $this->input->post('id', true);
        if (!empty($this->cart_model->add_to_cart_quote($quote_request_id))) {
            redirect(generate_url("cart"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Remove from Cart
     */
    public function remove_from_cart()
    {
        $cart_item_id = $this->input->post('cart_item_id', true);
        $this->cart_model->remove_from_cart($cart_item_id);
        $this->cart_model->calculate_cart_total();

        $cart_items = $this->cart_model->get_sess_cart_items();
        $cart_total = $this->cart_model->get_sess_cart_total();
        $total = $cart_total->total;
        $data['cart_items'] = $this->session_cart_items;
        $data['cart_total'] = $this->cart_model->get_sess_cart_total();
        // var_dump($data['cart_total']);
        // die();
        $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();
        $payment_button = "";
        if (count($cart_items) != 0) {
            $payment_button = $this->load->view('cart/payment_button', $data, true);
        }
        $cart_view_html = $this->load->view("cart/_cart_product_response", ['cart_items' => $cart_items, 'cart_total' => $this->cart_model->get_sess_cart_total(), 'cart_has_physical_product' => $this->cart_model->check_cart_has_physical_product()], true);
        $response = array(
            "cart_item_id" => $cart_item_id,
            "cart_count" => get_cart_product_count_ajax(),
            "total_mrp" => ($_SESSION["mds_shopping_cart_total"]->subtotal) / 100,
            "discount" => $_SESSION["mds_shopping_cart_total"]->discount,
            "total" => ($_SESSION["mds_shopping_cart_total"]->total_price) / 100,
            "subtotal" => ($cart_total->total) / 100,
            "shipping_cost" => ($cart_total->shipping_cost) / 100,
            "order_total" => ($cart_total->order_total) / 100,
            "cart_view" => $cart_view_html,
            'payment_button' => $payment_button
        );
        echo json_encode($response);
    }

    /**
     * Remove from Cart guest
     */
    public function remove_from_cart_guest()
    {
        $user_id = $this->input->post('user_id', true);
        $this->cart_model->remove_from_cart_guest($user_id);
        // $this->cart_model->calculate_cart_total();
        // $cart_items = $this->cart_model->get_sess_cart_items();
        // $cart_total = $this->cart_model->get_sess_cart_total();
        // $cart_view_html = $this->load->view("cart/_cart_product_response", ['cart_items' => $cart_items, 'cart_total' => $this->cart_model->get_sess_cart_total(), 'cart_has_physical_product' => $this->cart_model->check_cart_has_physical_product()], true);
        $response = array(
            //     "cart_item_id" => $cart_item_id,
            //     "cart_count" => get_cart_product_count_ajax(),
            //     "total_mrp" => ($_SESSION["mds_shopping_cart_total"]->subtotal) / 100,
            //     "discount" => $_SESSION["mds_shopping_cart_total"]->discount,
            //     "total" => ($_SESSION["mds_shopping_cart_total"]->total_price) / 100,
            //     "subtotal" => ($cart_total->total) / 100,
            //     "shipping_cost" => ($cart_total->shipping_cost) / 100,
            //     "order_total" => ($cart_total->order_total) / 100,
            //     "cart_view" => $cart_view_html
            "sucess" => "true"
        );

        // echo json_encode($response);
    }

    /**
     * Update Cart Product Quantity
     */
    public function update_cart_product_quantity()
    {
        $product_id = $this->input->post('product_id', true);
        $cart_item_id = $this->input->post('cart_item_id', true);
        $quantity = $this->input->post('quantity', true);
        $this->cart_model->update_cart_product_quantity($product_id, $cart_item_id, $quantity);
        $this->cart_model->calculate_cart_total();
        $carts = $this->cart_model->get_sess_cart_items();
        foreach ($carts as $cart) {
            if ($cart_item_id === $cart->cart_item_id) {
                $product_details = array(
                    "total_price_product" => $cart->total_price
                );
            }
        }


        $data['cart_items'] = $this->session_cart_items;
        $data['cart_total'] = $this->cart_model->get_sess_cart_total();
        $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();

        // $payment_button = $this->load->view("cart/payment_button", ["cart_items" =>  $data['cart_items'], "cart_total" => $data['cart_total']]);
        $data["open_rating_modal"] = false;
        if (!empty($this->auth_user)) :
            $order_id['product_id'] =  $this->product_model->get_order_id($this->auth_user->id);
            if (!empty($order_id['product_id'])) :
                $order['order_id'] = $this->product_model->get_order_product_id($order_id['product_id']->order_id, $this->auth_user->id);
                foreach ($order['order_id'] as $order1) :
                    $not_rating['exist'] = $this->product_model->get_not_rating_product($order1->product_id, $this->auth_user->id);
                    if (empty($not_rating['exist'])) :
                        $data["open_rating_modal"] = true;
                        break;
                    endif;
                endforeach;
            endif;
        endif;
        $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();
        // var_dump($this->load->view('cart/payment_button', $data, true));
        // die();


        $response = array(
            "status" => true,
            "product_details" => ($product_details["total_price_product"]) / 100,
            "total_mrp" => ($_SESSION["mds_shopping_cart_total"]->subtotal) / 100,
            "discount" => $_SESSION["mds_shopping_cart_total"]->discount,
            "total" => ($_SESSION["mds_shopping_cart_total"]->total_price) / 100,
            "payment_button" => $this->load->view('cart/payment_button', $data, true),  // "payment_button" => $this->load->view("cart/payment_button", ["cart_items" =>  $data['cart_items'], "cart_total" => $data['cart_total']]),
        );
        // var_dump($response);
        // die();
        echo json_encode($response);
    }
    /**
     * check product reviews
     */
    public function checkReviews($product)
    {
        echo ("function");
        // var_dump($product);
        exit;
    }


    /**
     * Shipping
     */
    public function shipping()
    {
        $this->cart_model->validate_cart();
        $data['title'] = trans("shopping_cart");
        $data['description'] = trans("shopping_cart") . " - " . $this->app_name;
        $data['keywords'] = trans("shopping_cart") . "," . $this->app_name;
        $data['cart_items'] = $this->cart_model->get_sess_cart_items();
        $data['mds_payment_type'] = 'sale';
        $data['offer'] = $this->cart_model->available_offers();
        $data['cart_total'] = $this->cart_model->get_sess_cart_total();


        if (empty($data['cart_items'])) {
            redirect(generate_url("cart"));
        }
        //check shipping status
        if ($this->form_settings->shipping != 1) {
            redirect(generate_url("cart"));
            exit();
        }
        //check guest checkout
        if (empty($this->auth_check) && $this->general_settings->guest_checkout != 1) {
            redirect(generate_url("cart"));
            exit();
        }

        //check physical products
        if ($this->cart_model->check_cart_has_physical_product() == false) {
            redirect(generate_url("cart"));
            exit();
        }
        $data['cart_total'] = $this->cart_model->get_sess_cart_total();
        if ($data['cart_total']->is_stock_available != 1) {
            redirect(generate_url("cart"));
            exit();
        }

        $data["shipping_address"] = $this->cart_model->get_sess_cart_shipping_address();

        if (!empty($this->auth_check)) :
            $data["get_address"] = $this->cart_model->get_shipping_details($this->auth_user->id);
        endif;


        $this->load->view('partials/_header', $data);
        $this->load->view('cart/shipping', $data);
        $this->load->view('partials/_footer');
    }
    // to store the shipping address in db
    public function shipping_address()
    {
        post_method();
        $this->cart_model->add_shipping_address();
    }
    // edit address
    public function update_shipping_address($id)
    {
        post_method();
        $this->cart_model->edit_shipping_address($id);
    }
    // remove address
    public function remove_address()
    {
        $data["remove"] = $this->cart_model->remove_address($this->auth_user->id);
    }
    // delete address
    public function delete_address()
    {
        $id = $this->input->post('id', true);
        if ($this->auth_model->delete_address($id)) {
            $this->session->set_flashdata('success', "Address sucessfully deleted");
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();
    }

    /**
     * Shipping Post
     */
    public function shipping_post()
    {
        $this->cart_model->set_sess_cart_shipping_address();
        redirect(generate_url("cart", "payment_method") . "?payment_type=sale");
    }

    /**
     * Payment Method
     */
    public function payment_method()
    {
        $data['title'] = trans("shopping_cart");
        $data['description'] = trans("shopping_cart") . " - " . $this->app_name;
        $data['keywords'] = trans("shopping_cart") . "," . $this->app_name;
        $data['offer'] = $this->cart_model->available_offers();
        $data['c_items'] = $this->cart_model->get_sess_cart_items();
        $data['c_count'] = get_cart_product_count();
        $data['check_cashond'] = $this->order_model->check_cod($data['c_items'], $data['c_count']);
        $data['check_made_to_order'] = $this->order_model->check_mto($data['c_items']);
        //check for exhibition enabled products
        $data['check_exhibition'] = $this->order_model->check_exhibition_enabled($data['c_items']);


        $data['mds_payment_type'] = "sale";


        //check is set cart payment method
        $data['cart_payment_method'] = $this->cart_model->get_sess_cart_payment_method();

        $this->cart_model->validate_cart();
        //sale payment
        $data['cart_items'] = $this->cart_model->get_sess_cart_items();
        if ($data['cart_items'] == null) {
            redirect(generate_url("cart"));
        }
        $data['cart_total'] = $this->cart_model->get_sess_cart_total();
        $data["shipping_address"] = $this->cart_model->get_sess_cart_shipping_address();
        $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();
        //total amount
        $data['total_amount'] = $data['cart_total']->total_price;
        $data['currency'] = $this->payment_settings->default_currency;

        $payment_type = input_get('payment_type');
        if ($payment_type != "membership" && $payment_type != "promote") {
            $payment_type = "sale";
        }

        if ($payment_type == "sale") {
            $this->cart_model->validate_cart();
            //sale payment
            $data['cart_items'] = $this->cart_model->get_sess_cart_items();
            $data['mds_payment_type'] = "sale";
            if ($data['cart_items'] == null) {
                redirect(generate_url("cart"));
            }
            //check auth for digital products
            if (!$this->auth_check && $this->cart_model->check_cart_has_digital_product() == true) {
                $this->session->set_flashdata('error', trans("msg_digital_product_register_error"));
                redirect(generate_url("register"));
                exit();
            }
            $data['cart_total'] = $this->cart_model->get_sess_cart_total();
            $user_id = null;
            if ($this->auth_check) {
                $user_id = $this->auth_user->id;
            }

            $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();
            $data['cart_has_digital_product'] = $this->cart_model->check_cart_has_digital_product();
            $this->cart_model->unset_sess_cart_payment_method();
        } elseif ($payment_type == 'membership') {
            //membership payment
            if ($this->general_settings->membership_plans_system != 1) {
                redirect(lang_base_url());
                exit();
            }
            $data['mds_payment_type'] = 'membership';
            $plan_id = $this->session->userdata('modesy_selected_membership_plan_id');
            if (empty($plan_id)) {
                redirect(lang_base_url());
                exit();
            }
            $data['plan'] = $this->membership_model->get_plan($plan_id);
            if (empty($data['plan'])) {
                redirect(lang_base_url());
                exit();
            }
        } elseif ($payment_type == 'promote') {
            //promote payment
            if ($this->general_settings->promoted_products != 1) {
                redirect(lang_base_url());
            }
            $data['mds_payment_type'] = 'promote';
            $data['promoted_plan'] = $this->session->userdata('modesy_selected_promoted_plan');
            if (empty($data['promoted_plan'])) {
                redirect(lang_base_url());
            }
        }
        if ($data['cart_total']->total_price != 0) {

            $this->load->view('partials/_header', $data);
            $this->load->view('cart/payment_method', $data);
            $this->load->view('partials/_footer');
        } else {
            $this->cash_on_delivery_payment_post();
        }
    }

    /**
     * Payment Method Post
     */
    public function payment_method_post()
    {
        $this->cart_model->set_sess_cart_payment_method();

        $mds_payment_type = $this->input->post('mds_payment_type', true);
        if ($mds_payment_type == "sale") {
            redirect(generate_url("cart", "shipping"));
        } elseif ($mds_payment_type == 'membership') {
            $transaction_number = 'bank-' . generate_transaction_number();
            $this->session->set_userdata('mds_membership_bank_transaction_number', $transaction_number);
            redirect(generate_url("cart", "shipping") . "?payment_type=membership");
        } elseif ($mds_payment_type == 'promote') {
            $transaction_number = 'bank-' . generate_transaction_number();
            $this->session->set_userdata('mds_promote_bank_transaction_number', $transaction_number);
            redirect(generate_url("cart", "shipping") . "?payment_type=promote");
        }
        redirect(lang_base_url());
    }

    /**
     * Payment
     */
    public function payment()
    {
        $data['title'] = trans("shopping_cart");
        $data['description'] = trans("shopping_cart") . " - " . $this->app_name;
        $data['keywords'] = trans("shopping_cart") . "," . $this->app_name;
        $data['mds_payment_type'] = "sale";

        //check guest checkout
        if (empty($this->auth_check) && $this->general_settings->guest_checkout != 1) {
            redirect(generate_url("cart"));
            exit();
        }

        //check is set cart payment method
        $data['cart_payment_method'] = $this->cart_model->get_sess_cart_payment_method();
        if (empty($data['cart_payment_method'])) {
            redirect(generate_url("cart", "payment_method"));
        }

        $payment_type = input_get('payment_type');
        if ($payment_type != "membership" && $payment_type != "promote") {
            $payment_type = "sale";
        }

        if ($payment_type == "sale") {
            $this->cart_model->validate_cart();
            //sale payment
            $data['cart_items'] = $this->cart_model->get_sess_cart_items();
            if ($data['cart_items'] == null) {
                redirect(generate_url("cart"));
            }
            $data['cart_total'] = $this->cart_model->get_sess_cart_total();
            $data["shipping_address"] = $this->cart_model->get_sess_cart_shipping_address();
            $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();
            //total amount
            $data['total_amount'] = $data['cart_total']->total_price;
            $data['currency'] = $this->payment_settings->default_currency;
        } elseif ($payment_type == 'membership') {
            //membership payment
            if ($this->general_settings->membership_plans_system != 1) {
                redirect(lang_base_url());
                exit();
            }
            $data['mds_payment_type'] = 'membership';
            $plan_id = $this->session->userdata('modesy_selected_membership_plan_id');
            if (empty($plan_id)) {
                redirect(lang_base_url());
                exit();
            }
            $data['plan'] = $this->membership_model->get_plan($plan_id);
            if (empty($data['plan'])) {
                redirect(lang_base_url());
                exit();
            }
            //total amount
            $data['total_amount'] = $data['plan']->price;
            $data['currency'] = $this->payment_settings->default_currency;
            $data['transaction_number'] = $this->session->userdata('mds_membership_bank_transaction_number');
            $data['cart_total'] = null;
        } elseif ($payment_type == 'promote') {
            //promote payment
            if ($this->general_settings->promoted_products != 1) {
                redirect(lang_base_url());
            }
            $data['mds_payment_type'] = 'promote';
            $data['promoted_plan'] = $this->session->userdata('modesy_selected_promoted_plan');
            if (empty($data['promoted_plan'])) {
                redirect(lang_base_url());
            }
            //total amount
            $data['total_amount'] = $data['promoted_plan']->total_amount;
            $data['currency'] = $this->payment_settings->default_currency;
            $data['transaction_number'] = $this->session->userdata('mds_promote_bank_transaction_number');
            $data['cart_total'] = null;
        }

        //check pagseguro
        if ($data['cart_payment_method']->payment_option == 'pagseguro') {
            $this->load->library('pagseguro');
            $data['session_code'] = $this->pagseguro->get_session_code();
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('cart/payment', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Payment with Paypal
     */
    public function paypal_payment_post()
    {
        $payment_id = $this->input->post('payment_id', true);
        $this->load->library('paypal');

        //validate the order
        if ($this->paypal->get_order($payment_id)) {
            $data_transaction = array(
                'payment_method' => "PayPal",
                'payment_id' => $payment_id,
                'currency' => $this->input->post('currency', true),
                'payment_amount' => $this->input->post('payment_amount', true),
                'payment_status' => $this->input->post('payment_status', true),
            );
            $mds_payment_type = $this->input->post('mds_payment_type', true);

            //add order
            $response = $this->execute_payment($data_transaction, $mds_payment_type, lang_base_url());
            if ($response->result == 1) {
                $this->session->set_flashdata('success', $response->message);
                echo json_encode([
                    'result' => 1,
                    'redirect_url' => $response->redirect_url
                ]);
            } else {
                $this->session->set_flashdata('error', $response->message);
                echo json_encode([
                    'result' => 0
                ]);
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            echo json_encode([
                'result' => 0
            ]);
        }
    }

    /**
     * Payment with Stripe
     */
    public function stripe_payment_post()
    {
        require_once APPPATH . "third_party/stripe/vendor/autoload.php";
        \Stripe\Stripe::setApiKey($this->payment_settings->stripe_secret_key);
        header('Content-Type: application/json');

        $stripe_session = $this->session->userdata('mds_stripe_cart');
        if (empty($stripe_session)) {
            $this->session->set_flashdata('error', trans("invalid_attempt"));
            echo json_encode([
                'result' => 0
            ]);
            exit();
        }

        $json_str = file_get_contents('php://input');
        $json_obj = json_decode($json_str);
        $intent = null;
        try {
            if (isset($json_obj->payment_method_id)) {
                //create the PaymentIntent
                $intent = \Stripe\PaymentIntent::create([
                    'payment_method' => $json_obj->payment_method_id,
                    'amount' => $stripe_session->total_amount,
                    'currency' => $stripe_session->currency,
                    'confirmation_method' => 'manual',
                    'confirm' => true,
                ]);
            }
            if (isset($json_obj->payment_intent_id)) {
                $intent = \Stripe\PaymentIntent::retrieve(
                    $json_obj->payment_intent_id
                );
                $intent->confirm();
            }
            //complete payment
            if ($intent->status == 'requires_action' && $intent->next_action->type == 'use_stripe_sdk') {
                echo json_encode([
                    'requires_action' => true,
                    'payment_intent_client_secret' => $intent->client_secret
                ]);
            } else if ($intent->status == 'succeeded') {
                //add to database
                $data_transaction = array(
                    'payment_method' => "Stripe",
                    'payment_id' => $intent->id,
                    'currency' => $stripe_session->currency,
                    'payment_amount' => get_price($stripe_session->total_amount, 'decimal'),
                    'payment_status' => "Succeeded",
                );

                //add order
                $response = $this->execute_payment($data_transaction, $stripe_session->payment_type, lang_base_url());
                if ($response->result == 1) {
                    @$this->session->unset_userdata('mds_stripe_cart');
                    $this->session->set_flashdata('success', $response->message);
                    echo json_encode([
                        'result' => 1,
                        'redirect_url' => $response->redirect_url
                    ]);
                } else {
                    $this->session->set_flashdata('error', $response->message);
                    echo json_encode([
                        'result' => 0
                    ]);
                }
            } else {
                //invalid status
                http_response_code(500);
                $this->session->set_flashdata('error', 'Invalid PaymentIntent status');
                echo json_encode([
                    'result' => 0
                ]);
            }
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $this->session->set_flashdata('error', $e->getMessage());
            echo json_encode([
                'result' => 0
            ]);
        }
    }

    /**
     * Payment with PayStack
     */
    public function paystack_payment_post()
    {
        $this->load->library('paystack');

        $data_transaction = array(
            'payment_method' => "PayStack",
            'payment_id' => $this->input->post('payment_id', true),
            'currency' => $this->input->post('currency', true),
            'payment_amount' => get_price($this->input->post('payment_amount', true), 'decimal'),
            'payment_status' => $this->input->post('payment_status', true),
        );

        if (empty($this->paystack->verify_transaction($data_transaction['payment_id']))) {
            $this->session->set_flashdata('error', 'Invalid transaction code!');
            echo json_encode([
                'result' => 0
            ]);
        } else {
            $mds_payment_type = $this->input->post('mds_payment_type', true);

            //add order
            $response = $this->execute_payment($data_transaction, $mds_payment_type, lang_base_url());
            if ($response->result == 1) {
                $this->session->set_flashdata('success', $response->message);
                echo json_encode([
                    'result' => 1,
                    'redirect_url' => $response->redirect_url
                ]);
            } else {
                $this->session->set_flashdata('error', $response->message);
                echo json_encode([
                    'result' => 0
                ]);
            }
        }
    }

    /**
     * Payment with Razorpay
     */
    public function razorpay_payment_post()
    {
        $this->load->library('razorpay');

        $data_transaction = array(
            'payment_method' => "Razorpay",
            'payment_id' => $this->input->post('payment_id', true),
            'razorpay_order_id' => $this->input->post('razorpay_order_id', true),
            'razorpay_signature' => $this->input->post('razorpay_signature', true),
            'currency' => $this->input->post('currency', true),
            'payment_amount' => get_price($this->input->post('payment_amount', true), 'decimal'),
            'payment_status' => 'succeeded',
        );

        if (empty($this->razorpay->verify_payment_signature($data_transaction))) {
            $this->session->set_flashdata('error', 'Invalid signature passed!');
            echo json_encode([
                'result' => 0
            ]);
        } else {
            $mds_payment_type = $this->input->post('mds_payment_type', true);
            //add order
            $response = $this->execute_payment($data_transaction, $mds_payment_type, lang_base_url());
            if ($response->result == 1) {
                $this->session->set_flashdata('success', $response->message);
                echo json_encode([
                    'result' => 1,
                    'redirect_url' => $response->redirect_url
                ]);
            } else {
                $this->session->set_flashdata('error', $response->message);
                echo json_encode([
                    'result' => 0
                ]);
            }
        }
    }



    /**
     * Payment with Iyzico
     */
    public function iyzico_payment_post()
    {
        require_once(APPPATH . 'third_party/iyzipay/vendor/autoload.php');
        require_once(APPPATH . 'third_party/iyzipay/vendor/iyzico/iyzipay-php/IyzipayBootstrap.php');

        $token = $this->input->post('token', true);
        $conversation_id = $this->input->get('conversation_id', true);
        $lang = $this->input->get('lang', true);
        $payment_type = $this->input->get('payment_type', true);

        $lang_base_url = lang_base_url();
        if ($lang != $this->selected_lang->short_form) {
            $lang_base_url = base_url() . $lang . "/";
        }

        IyzipayBootstrap::init();
        $options = new \Iyzipay\Options();
        $options->setApiKey($this->payment_settings->iyzico_api_key);
        $options->setSecretKey($this->payment_settings->iyzico_secret_key);
        if ($this->payment_settings->iyzico_mode == "sandbox") {
            $options->setBaseUrl("https://sandbox-api.iyzipay.com");
        } else {
            $options->setBaseUrl("https://api.iyzipay.com");
        }

        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId($conversation_id);
        $request->setToken($token);

        $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, $options);

        if ($checkoutForm->getPaymentStatus() == "SUCCESS") {
            $data_transaction = array(
                'payment_method' => "Iyzico",
                'payment_id' => $checkoutForm->getPaymentId(),
                'currency' => $checkoutForm->getCurrency(),
                'payment_amount' => $checkoutForm->getPrice(),
                'payment_status' => "Succeeded"
            );
            //add order
            $response = $this->execute_payment($data_transaction, $payment_type, $lang_base_url);
            if ($response->result == 1) {
                $this->session->set_flashdata('success', $response->message);
                redirect($response->redirect_url);
            } else {
                $this->session->set_flashdata('error', $response->message);
                redirect($response->redirect_url);
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($lang_base_url . get_route("cart", true) . get_route("shipping"));
        }
    }

    /**
     * Payment with PagSeguro
     */
    public function pagseguro_payment_post()
    {
        $this->load->library('pagseguro');
        $inputs = array(
            'payment_type' => $this->input->post('payment_type', true),
            'token' => htmlspecialchars($this->input->post('token', true)),
            'senderHash' => htmlspecialchars($this->input->post('senderHash', true)),
            'cardNumber' => $this->input->post('cardNumber', true),
            'cardExpiry' => $this->input->post('cardExpiry', true),
            'cardCVC' => $this->input->post('cardCVC', true),
            'total_amount' => $this->input->post('total_amount', true),
            'full_name' => $this->input->post('full_name', true),
            'cpf' => $this->input->post('cpf', true),
            'phone' => $this->input->post('phone', true),
            'email' => $this->input->post('email', true),
            'date_of_birth' => $this->input->post('date_of_birth', true),
            'postal_code' => $this->input->post('postal_code', true),
            'city' => $this->input->post('city', true),
        );

        $result = null;
        $payment_method = 'PagSeguro - Credit Card';
        if ($this->input->post('payment_type', true) == 'credit_card') {
            $result = $this->pagseguro->pay_with_credit_card($inputs);
            if (empty($result)) {
                $this->session->set_flashdata('form_data', $inputs);
                redirect($this->agent->referrer());
            }
        } else {
            $payment_method = 'PagSeguro - Boleto';
            $result = $this->pagseguro->pay_with_boleto($inputs);
            if (empty($result)) {
                $this->session->set_flashdata('form_data', $inputs);
                redirect($this->agent->referrer());
            }
        }

        if (!empty($result->code)) {
            $data_transaction = array(
                'payment_method' => $payment_method,
                'payment_id' => $result->code,
                'currency' => 'BRL',
                'payment_amount' => $inputs['total_amount'],
                'payment_status' => "succeeded",
            );
            $mds_payment_type = $this->input->post('mds_payment_type', true);
            //add order
            $response = $this->execute_payment($data_transaction, $mds_payment_type, lang_base_url());
            if ($response->result == 1) {
                $this->session->set_flashdata('success', $response->message);
                redirect($response->redirect_url);
            } else {
                $this->session->set_flashdata('error', $response->message);
                redirect($response->redirect_url);
            }
        }
    }

    /**
     * Payment with Bank Transfer
     */
    public function bank_transfer_payment_post()
    {
        $mds_payment_type = $this->input->post('mds_payment_type', true);

        if ($mds_payment_type == 'membership') {
            $plan_id = $this->session->userdata('modesy_selected_membership_plan_id');
            $plan = null;
            if (!empty($plan_id)) {
                $plan = $this->membership_model->get_plan($plan_id);
            }
            if (!empty($plan)) {
                $data_transaction = array(
                    'payment_method' => 'Bank Transfer',
                    'payment_status' => 'awaiting_payment',
                    'payment_id' => $this->session->userdata('mds_membership_bank_transaction_number')
                );
                //add user membership plan
                $this->membership_model->add_user_plan($data_transaction, $plan, $this->auth_user->id);
                //add transaction
                $this->membership_model->add_membership_transaction_bank($data_transaction, $plan);
                redirect(generate_url("membership_payment_completed") . "?method=bank_transfer&transaction_number=" . $data_transaction['payment_id']);
            }
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect(generate_url("cart", "shipping") . "?payment_type=membership");
        } elseif ($mds_payment_type == 'promote') {
            $promoted_plan = $this->session->userdata('modesy_selected_promoted_plan');
            if (!empty($promoted_plan)) {
                $transaction_number = $this->session->userdata('mds_promote_bank_transaction_number');
                //add transaction
                $this->promote_model->add_promote_transaction_bank($promoted_plan, $transaction_number);

                $type = $this->session->userdata('mds_promote_product_type');

                if (empty($type)) {
                    $type = "new";
                }
                redirect(generate_url("promote_payment_completed") . "?method=bank_transfer&transaction_number=" . $transaction_number . "&product_id=" . $promoted_plan->product_id);
            }
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect(generate_url("cart", "shipping") . "?payment_type=promote");
        } else {
            //add order
            $order_id = $this->order_model->add_order_offline_payment("Bank Transfer");
            $order = $this->order_model->get_order($order_id);
            if (!empty($order)) {
                //decrease product quantity after sale
                $this->order_model->decrease_product_stock_after_sale($order->id);
                //send email
                if ($this->general_settings->send_email_buyer_purchase == 1) {
                    $email_data = array(
                        'email_type' => 'new_order',
                        'order_id' => $order_id
                    );
                    $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
                }

                if ($order->buyer_id == 0) {
                    $this->session->set_userdata('mds_show_order_completed_page', 1);
                    redirect(generate_url("order_completed") . "/" . $order->order_number);
                } else {
                    $this->session->set_flashdata('success', trans("msg_order_completed"));
                    redirect(generate_url("order_details") . "/" . $order->order_number);
                }
            }

            $this->session->set_flashdata('error', trans("msg_error"));
            redirect(generate_url("cart", "shipping"));
        }
    }

    /**
     * Cash on Delivery
     */
    public function cash_on_delivery_payment_post()
    {
        $this->cart_model->set_sess_cart_payment_method();
        //add order
        $order_id = $this->order_model->add_order_offline_payment("Cash On Delivery");
        $order = $this->order_model->get_order($order_id);
        $order_shipping = $this->order_model->get_order_shipping($order_id);
        if (!empty($order)) {
            //decrease product quantity after sale
            $this->order_model->decrease_product_stock_after_sale($order->id);
            //send email
            if ($this->general_settings->send_email_buyer_purchase == 1) {
                $email_data = array(
                    'email_type' => 'new_order',
                    'order_id' => $order_id
                );
                $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
            }

            if ($order->buyer_id == 0) {
                $this->session->set_userdata('mds_show_order_completed_page', 1);
                redirect(generate_url("order_completed") . "/" . $order->order_number);
            } else {
                $this->session->set_flashdata('success', trans("msg_order_completed"));
                // redirect(generate_url("order_details") . "/" . $order->order_number);

                $arr = [$order_shipping->shipping_first_name, $order->order_number, $order->price_total / 100, $order->payment_method];
                $passed_data = '"' . implode('","', $arr) . '"';

                // redirect(generate_url("thankyou"). "/" . $order->order_number);
                $this->session->set_userdata('thankyou_order_id', $order->order_number);
                $required_data = array(
                    "from" => "918287606650",
                    "to" => "91$order_shipping->shipping_phone_number",
                    "type" => "mediatemplate",
                    "channel" => "whatsapp",
                    "template_name" => "new_ordertext",
                    "params" => $passed_data,
                    "param_url" => "order-details" . "/" . $order->order_number
                );
                $data['order_number'] = $order->order_number;
                $data['order_completed'] = "yes";
                if ($this->general_settings->send_whatsapp == 1) {
                    $this->notification_model->whatsapp($required_data);
                }
                // redirect(generate_url("order-completed"));
            }
        } else {

            $this->session->set_flashdata('error', trans("msg_error"));
            $data['order_completed'] = "no";
        }
        echo json_encode($data);
    }

    /**
     * Execute Sale Payment
     */
    public function execute_payment($data_transaction, $payment_type, $base_url)
    {
        //response object
        $response = new stdClass();
        $response->result = 0;
        $response->message = "";
        $response->redirect_url = "";

        if ($data_transaction["txStatus"] == "SUCCESS") {
            $data_transaction["payment_status"] = "payment_received";
            if ($payment_type == 'sale') {
                //add order
                $order_id = $this->order_model->add_order($data_transaction);
                $order = $this->order_model->get_order($order_id);
                $order_shipping = $this->order_model->get_order_shipping($order_id);
                if (!empty($order)) {
                    //decrease product quantity after sale
                    $this->order_model->decrease_product_stock_after_sale($order->id);
                    //send email
                    $cart_total = $this->cart_model->get_sess_cart_total();

                    $total_price1 = $cart_total->total_price / 100;
                    if ((float)$data_transaction['payment_amount'] == $total_price1 && $data_transaction['match_status'] == "yes") {
                        if ((float)$data_transaction['payment_amount'] == $cart_total->total && $data_transaction['match_status'] == "yes") {
                            if ($this->general_settings->send_email_buyer_purchase == 1) {
                                $email_data = array(
                                    'email_type' => 'new_order',
                                    'order_id' => $order_id
                                );
                                $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
                            }
                        }
                        //set response and redirect URLs
                        $response->result = 1;

                        $arr = [$order_shipping->shipping_first_name, $order->order_number, $order->price_total / 100, $order->payment_method];
                        $parsed_data = '"' . implode('","', $arr) . '"';
                        $require_data = array(
                            "from" => "918287606650",
                            "to" => "91$order_shipping->shipping_phone_number",
                            "type" => "mediatemplate",
                            "channel" => "whatsapp",
                            "template_name" => "new_ordertext",
                            "params" => $parsed_data,
                            "param_url" => "order-details" . "/" . $order->order_number
                        );
                        //  $response->redirect_url = $base_url . get_route("order_details", true) . $order->order_number;
                        //  $response->redirect_url = $base_url . get_route("thankyou", true) ."/". $order->order_number;
                        $this->session->set_userdata('thankyou_order_id', $order->order_number);
                        if ($this->general_settings->send_whatsapp == 1) {
                            $this->notification_model->whatsapp($require_data);
                        }
                        $response->redirect_url = $base_url . get_route("order-completed", true);


                        if ($order->buyer_id == 0) {
                            $this->session->set_userdata('mds_show_order_completed_page', 1);
                            $response->redirect_url = $base_url . get_route("order_completed", true) . $order->order_number;
                        } else {
                            $response->message = trans("msg_order_completed");
                        }
                    } else {
                        //could not added to the database
                        $response->message = trans("msg_payment_database_error");
                        $response->result = 0;
                        $response->redirect_url = $base_url . get_route("cart", true) . get_route("shipping");
                    }
                } elseif ($payment_type == 'membership') {
                    $plan_id = $this->session->userdata('modesy_selected_membership_plan_id');
                    $plan = null;
                    if (!empty($plan_id)) {
                        $plan = $this->membership_model->get_plan($plan_id);
                    }
                    if (!empty($plan)) {
                        //add user membership plan
                        $this->membership_model->add_user_plan($data_transaction, $plan, $this->auth_user->id);
                        //add transaction
                        $this->membership_model->add_membership_transaction($data_transaction, $plan);
                        //set response and redirect URLs
                        $response->result = 1;
                        $response->redirect_url = $base_url . get_route("membership_payment_completed") . "?method=gtw";
                    } else {
                        //could not added to the database
                        $response->message = trans("msg_payment_database_error");
                        $response->result = 0;
                        $response->redirect_url = $base_url . get_route("cart", true) . get_route("shipping") . "?payment_type=membership";
                    }
                } elseif ($payment_type == 'promote') {
                    $promoted_plan = $this->session->userdata('modesy_selected_promoted_plan');
                    if (!empty($promoted_plan)) {
                        //add to promoted products
                        $this->promote_model->add_to_promoted_products($promoted_plan);
                        //add transaction
                        $this->promote_model->add_promote_transaction($data_transaction);
                        //reset cache
                        reset_cache_data_on_change();
                        reset_user_cache_data($this->auth_user->id);
                        //set response and redirect URLs
                        $response->result = 1;
                        $response->redirect_url = $base_url . get_route("promote_payment_completed") . "?method=gtw&product_id=" . $promoted_plan->product_id;
                    } else {
                        //could not added to the database
                        $response->message = trans("msg_payment_database_error");
                        $response->result = 0;
                        $response->redirect_url = $base_url . get_route("cart", true) . get_route("shipping") . "?payment_type=promote";
                    }
                }
            } else {
                $this->order_model->add_payment_transaction_fail($data_transaction);
                // $response->message = trans("msg_payment_database_error");
                $response->message = trans("payment_failed");
                $response->result = 0;
                $response->redirect_url = $base_url . get_route("cart", true) . get_route("shipping");
            }

            return $response;
        }}

    /**
     * Order Completed
     */
    public function order_completed($order_number)
    {
        $data['title'] = trans("msg_order_completed");
        $data['description'] = trans("msg_order_completed") . " - " . $this->app_name;
        $data['keywords'] = trans("msg_order_completed") . "," . $this->app_name;

        $data['order'] = $this->order_model->get_order_by_order_number($order_number);

        if (empty($data['order'])) {
            redirect(lang_base_url());
        }

        if (empty($this->session->userdata('mds_show_order_completed_page'))) {
            redirect(lang_base_url());
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('cart/order_completed', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Membership Payment Completed
     */
    public function membership_payment_completed()
    {
        $data['title'] = trans("msg_payment_completed");
        $data['description'] = trans("msg_payment_completed") . " - " . $this->app_name;
        $data['keywords'] = trans("payment") . "," . $this->app_name;
        $transaction_insert_id = $this->session->userdata('mds_membership_transaction_insert_id');
        if (empty($transaction_insert_id)) {
            redirect(lang_base_url());
        }
        $data["transaction"] = $this->membership_model->get_membership_transaction($transaction_insert_id);
        if (empty($data["transaction"])) {
            redirect(lang_base_url());
            exit();
        }

        $data["method"] = $this->input->get('method');
        $data["transaction_number"] = $this->input->get('transaction_number');


        $this->load->view('partials/_header', $data);
        $this->load->view('cart/membership_payment_completed', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Promote Payment Completed
     */
    public function promote_payment_completed()
    {
        $data['title'] = trans("msg_payment_completed");
        $data['description'] = trans("msg_payment_completed") . " - " . $this->app_name;
        $data['keywords'] = trans("payment") . "," . $this->app_name;
        $transaction_insert_id = $this->session->userdata('mds_promoted_transaction_insert_id');
        if (empty($transaction_insert_id)) {
            redirect(lang_base_url());
        }
        $data["transaction"] = $this->promote_model->get_promotion_transaction($transaction_insert_id);
        if (empty($data["transaction"])) {
            redirect(lang_base_url());
            exit();
        }
        $data["method"] = $this->input->get('method');
        $data["transaction_number"] = $this->input->get('transaction_number');

        $this->load->view('partials/_header', $data);
        $this->load->view('cart/promote_payment_completed', $data);
        $this->load->view('partials/_footer');
    }



    /**
     * Cashfree Payment Gateway
     */

    public function payment_cashfree()
    {
        $this->cart_model->set_sess_cart_payment_method();

        if (!empty($_SESSION["modesy_sess_unique_id"])) :
            $returnUrl = base_url() . "cashfree-return?session_id=" . $_SESSION["modesy_sess_unique_id"];
        else :
            $returnUrl = base_url() . "cashfree-return?session_id=''";
        endif;



        //easy-split start

        $cart_items = $this->cart_model->get_sess_cart_items();
        $cart_total = $this->cart_model->get_sess_cart_total();
        $shipping_detail = json_decode($this->order_model->get_shipping_cost($cart_total));
        $shipping_address = $this->cart_model->get_sess_cart_shipping_address();



        $seller_array = array();
        $amount_array = array();
        $product_seller_details = array();


        // 
        $payment_mode = $this->input->post("payment_mode", true);

        // 

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
                    $psd->total_tds_amount_product_huf_ind = 0;
                    $object_product->product_id = $cart_item->product_id;
                    $object_product->gst_rate = $product_details->gst_rate;
                    $object_product->product_total_price = $cart_item->total_price;

                    $object_product->shipping_cost_type = $product_details->shipping_cost_type;

                    // $commission_rate = $this->general_settings->commission_rate;


                    $gst_cal = 1 + ($object_product->gst_rate / 100);
                    $product_price_excluding_gst = round($object_product->product_total_price / $gst_cal, 0);
                    $amount = $product_price_excluding_gst / 100;
                    $commission = ($object->seller_commission_rate) / 100;
                    $commission_amount_without_round = $amount * $commission;
                    $commission_amount = round($commission_amount_without_round, 2);

                    $object_product->product_price_excluding_gst = $product_price_excluding_gst;

                    $gst_on_commission_amount = $commission_amount * 0.18;
                    $commission_amount_with_gst = $commission_amount + $gst_on_commission_amount;
                    // 

                    $object_product->product_commission_amount = $commission_amount;
                    $object_product->product_gst_on_commission_amount = round($gst_on_commission_amount, 2);
                    $object_product->product_commission_amount_with_gst = round($commission_amount_with_gst, 2);

                    // $object_product->commission_amount = $commission_amount;
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
                $object_product->tds_amount_product_huf_ind = 0;

                $object_product->shipping_cost_type = $product_details->shipping_cost_type;

                if ($object_product->shipping_cost_type == 'shipping_buyer_pays') {
                } elseif ($object_product->shipping_cost_type == 'free_shipping') {
                }

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

                // $object_product->commission_amount = $commission_amount;
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
                $bank_code = $this->input->post("bank_select", true);
                $com = $this->order_model->get_commission_rate_nb_wallet($payment_mode, $bank_code);
                $gateway_charge = $com->gateway_charge;
            } elseif ($payment_mode == 'wallet') {
                $wallet_code = $this->input->post("wallet_select", true);
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
                if ($psd->seller_id == $ship_detail->SupplierId) {
                    $object->shipping = ($ship_detail->Supplier_Shipping_cost);
                    $object->shipping_tax_charge = ($ship_detail->shipping_tax_charges);
                    $object->shipping_charge_with_gst = ($object->shipping) + ($object->shipping_tax_charge);


                    $object->supplier_shipping_cost_with_gst = ($ship_detail->Supplier_Shipping_cost_with_gst);

                    $object->shipping_charge_to_gharobaar = $object->supplier_shipping_cost_with_gst;
                }
            }

            $object->shipping = 0;
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
            $object->shipping_charge_to_gharobaar = 0;
            $object->shipping = 0;
            if (!empty($pan_number)) {
                if ($pan_forth_char[3] == 'P' || $pan_forth_char[3] == 'H') {
                    // $object->tds_amount = 0;
                    $object->shipping = 0;

                    $object->tds_amount_shipping = 0;
                    $object->tds_amount_shipping_huf_ind = 0.01 * ($object->shipping);
                } else {
                    $object->shipping = 0;

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

            // if (!empty($gst_number)) {
            //     $object->tcs_amount = round(($object->total_amount_without_gst + $object->shipping) * 0.01);
            // } else {
            //     $object->tcs_amount = 0;
            // }
            $object->shipping_charge_with_gst = 0;
            $object->gateway_amount = round(($object->shipping_charge_with_gst + $object->total_amount_with_gst) * ($object->gateway_charge / 100));
            $object->gateway_amount_gst = round($object->gateway_amount * 0.18);
            $object->gateway_amount_with_gst = round($object->gateway_amount + $object->gateway_amount_gst);
            $object->total_deduction = round($object->gateway_amount_with_gst + $object->shipping_charge_to_gharobaar + $object->tcs_amount + $object->commission_amount_with_gst + $object->tds_amount);
            $object->net_seller_payable = round($object->total_amount_with_gst + $object->shipping_charge_with_gst - $object->total_deduction);


            $total_amount_paid += $object->net_seller_payable;

            $object->payment_mode = $payment_mode;
            $object->cashfree_order_id = $this->input->post("orderid", true);
            if ($payment_mode == 'nb') {
                $object->bank_code = $this->input->post("bank_select", true);;
            } elseif ($payment_mode == 'wallet') {
                $object->wallet_code = $this->input->post("wallet_select", true);
            }
            array_push($seller_settlement, $object);
        }
        if ($this->general_settings->enable_easysplit == 1) {
            $object = new stdClass();
            $object->vendorId = "Gharobaar";
            $object->cashfree_order_id = $this->input->post("orderid", true);
            $object->net_seller_payable =  $cart_total->total_price - $total_amount_paid;
            array_push($seller_settlement, $object);
        }
        $new_seller_settlement = array();
        foreach ($seller_settlement as $ss) {
            $object = new stdClass();
            $object->vendorId = $ss->vendorId;
            $object->amount =  $ss->net_seller_payable / 100;
            array_push($new_seller_settlement, $object);
        }
        $settelment_json = json_encode($new_seller_settlement);
        $settelment_json_base64 = base64_encode($settelment_json);
        $this->session->set_userdata('settelment_json_base64', $settelment_json_base64);
        $easysplit = $_SESSION['settelment_json_base64'];
        // $data['payment_mode'] = $this->input->post("payment_mode", true);
        // easy-split end
        if ($this->general_settings->enable_easysplit == 1) {
            if (auth_check()) :
                $data = array(
                    "appId" => $this->general_settings->cashfree_app_id,
                    "orderId" => $this->input->post("orderid", true),
                    "orderAmount" => $this->input->post("orderamount", true),
                    // "paymentSplits" => $this->input->post("paymentsplits", true),
                    "paymentSplits" => $easysplit,
                    "customerName" => $this->auth_user->first_name . " " . $this->auth_user->last_name,
                    "customerPhone" => $this->auth_user->phone_number,
                    "customerEmail" => $this->auth_user->email,
                    "returnUrl" => $returnUrl
                );
            else :
                $data = array(
                    "appId" => $this->general_settings->cashfree_app_id,
                    "orderId" => $this->input->post("orderid", true),
                    "orderAmount" => $this->input->post("orderamount", true),
                    // "paymentSplits" => $this->input->post("paymentsplits", true),
                    "paymentSplits" => $easysplit,
                    "customerName" => $shipping_address->shipping_first_name . " " . $shipping_address->shipping_last_name,
                    "customerPhone" => $shipping_address->shipping_phone_number,
                    "customerEmail" => $shipping_address->shipping_email,
                    "returnUrl" => $returnUrl
                );
            endif;
        } elseif ($this->general_settings->enable_easysplit == 0) {
            if (auth_check()) :
                $data = array(
                    "appId" => $this->general_settings->cashfree_app_id,
                    "orderId" => $this->input->post("orderid", true),
                    "orderAmount" => $this->input->post("orderamount", true),
                    "customerName" => $this->auth_user->first_name . " " . $this->auth_user->last_name,
                    "customerPhone" => $this->auth_user->phone_number,
                    "customerEmail" => $this->auth_user->email,
                    "returnUrl" => $returnUrl
                );
            else :
                $data = array(
                    "appId" => $this->general_settings->cashfree_app_id,
                    "orderId" => $this->input->post("orderid", true),
                    "orderAmount" => $this->input->post("orderamount", true),
                    "customerName" => $shipping_address->shipping_first_name . " " . $shipping_address->shipping_last_name,
                    "customerPhone" => $shipping_address->shipping_phone_number,
                    "customerEmail" => $shipping_address->shipping_email,
                    "returnUrl" => $returnUrl
                );
            endif;
        }
        $data['paymentModes'] = $this->input->post("payment_mode", true);
        if (($this->input->post("payment_mode", true)) == "nb") {
            $data["paymentOption"] = $this->input->post("payment_mode", true);
            $data["paymentCode"] = $this->input->post("bank_select", true);
            $data["returnUrl"] = base_url() . "cashfree-return?session_id=" . $_SESSION["modesy_sess_unique_id"] . "&paymentOption=" . $data["paymentOption"] . "&paymentCode=" . $data["paymentCode"];
        } elseif (($this->input->post("payment_mode", true)) == "wallet") {
            $data["paymentOption"] = $this->input->post("payment_mode", true);
            $data["paymentCode"] = $this->input->post("wallet_select", true);
            $data["returnUrl"] = base_url() . "cashfree-return?session_id=" . $_SESSION["modesy_sess_unique_id"] . "&paymentOption=" . $data["paymentOption"] . "&paymentCode=" . $data["paymentCode"];
        } elseif (($this->input->post("payment_mode", true)) == "cc" || ($this->input->post("payment_mode", true)) == "dc" || ($this->input->post("payment_mode", true)) == "upi") {
            $data["paymentModes"] = $this->input->post("payment_mode", true);
            $data["returnUrl"] = base_url() . "cashfree-return?session_id=" . $_SESSION["modesy_sess_unique_id"] . "&paymentModes=" . $data["paymentModes"];
        }

        $data["signature"] = $this->cashfree_gen_signature($data);
        if ($this->general_settings->enable_easysplit == 1) {
            $save_payment = $seller_settlement;
            foreach ($save_payment as $sp) {
                $this->order_model->save_cashfree_seller_payable($sp);
            }
        }
        // cashfree online payment data save for payouts 
        else if ($this->general_settings->enable_easysplit == 0) {
            $save_payment = $seller_settlement;
            foreach ($save_payment as $sp) {
                $this->order_model->save_cashfree_seller_payable_payouts($sp);
            }
        }

        $this->auth_model->update_user_login_session_data($data['orderAmount']);
        $this->session->set_userdata('cashfree_form', $data);

        echo json_encode($data);
    }
    public function cashfree_form()
    {

        $sessiondata = $this->session->userdata("cashfree_form");
        if ($this->general_settings->enable_easysplit == 1) {
            if (auth_check()) :
                $data = array(
                    "appId" => $this->general_settings->cashfree_app_id,
                    "orderId" => $sessiondata->orderId,
                    "orderAmount" =>  $sessiondata['orderAmount'],
                    // "paymentSplits" => $this->input->post("paymentsplits", true),
                    "paymentSplits" => $sessiondata['paymentSplits'],
                    "customerName" => $this->auth_user->first_name . " " . $this->auth_user->last_name,
                    "customerPhone" => $this->auth_user->phone_number,
                    "customerEmail" => $this->auth_user->email,
                    "returnUrl" =>  $sessiondata['returnUrl']
                );
            else :
                $data = array(
                    "appId" => $this->general_settings->cashfree_app_id,
                    "orderId" => $sessiondata['orderId'],
                    "orderAmount" => $sessiondata['orderAmount'],
                    // "paymentSplits" => $this->input->post("paymentsplits", true),
                    "paymentSplits" => $sessiondata['paymentSplits'],
                    "customerName" => $sessiondata['customerName'],
                    "customerPhone" => $sessiondata['customerPhone'],
                    "customerEmail" => $sessiondata['customerEmail'],
                    "returnUrl" =>  $sessiondata['returnUrl']
                );
            endif;
        } elseif ($this->general_settings->enable_easysplit == 0) {
            if (auth_check()) :
                $data = array(
                    "appId" => $this->general_settings->cashfree_app_id,
                    "orderId" => $sessiondata['orderId'],
                    "orderAmount" =>  $sessiondata['orderAmount'],
                    // "paymentSplits" => $this->input->post("paymentsplits", true),
                    // "paymentSplits" => $sessiondata['paymentSplits'],
                    "customerName" => $this->auth_user->first_name . " " . $this->auth_user->last_name,
                    "customerPhone" => $this->auth_user->phone_number,
                    "customerEmail" => $this->auth_user->email,
                    "returnUrl" =>  $sessiondata['returnUrl']
                );
            else :
                $data = array(
                    "appId" => $this->general_settings->cashfree_app_id,
                    "orderId" => $sessiondata['orderId'],
                    "orderAmount" => $sessiondata['orderAmount'],
                    // "paymentSplits" => $this->input->post("paymentsplits", true),
                    // "paymentSplits" => $sessiondata['paymentSplits'],
                    "customerName" => $sessiondata['customerName'],
                    "customerPhone" => $sessiondata['customerPhone'],
                    "customerEmail" => $sessiondata['customerEmail'],
                    "returnUrl" =>  $sessiondata['returnUrl']
                );
            endif;
        }
        if ($sessiondata['paymentModes'] == "nb") {
            $data["paymentOption"] = $sessiondata['paymentOption'];
            $data["paymentCode"] = $sessiondata['paymentCode'];
            $data["returnUrl"] = base_url() . "cashfree-return?session_id=" . $_SESSION["modesy_sess_unique_id"] . "&paymentOption=" . $data["paymentOption"] . "&paymentCode=" . $data["paymentCode"];
        } elseif ($sessiondata['paymentModes'] == "wallet") {
            $data["paymentOption"] = $sessiondata['paymentModes'];
            $data["paymentCode"] = $sessiondata['paymentCode'];
            $data["returnUrl"] = base_url() . "cashfree-return?session_id=" . $_SESSION["modesy_sess_unique_id"] . "&paymentOption=" . $data["paymentOption"] . "&paymentCode=" . $data["paymentCode"];
        } elseif ($sessiondata['paymentModes'] == "cc" || $sessiondata['paymentModes'] == "dc" || $sessiondata['paymentModes'] == "upi") {
            $data["paymentModes"] = $sessiondata['paymentModes'];
            $data["returnUrl"] = base_url() . "cashfree-return?session_id=" . $_SESSION["modesy_sess_unique_id"] . "&paymentModes=" . $data["paymentModes"];
        }
        $data["signature"] = $this->cashfree_gen_signature($data);
        $this->load->view('cart/cashfree_form', $data);
    }

    public function cashfree_gen_signature($data)
    {
        // $secretKey = "9029ca61228bcee18a534e7c5ebb400b9e7fee1d";
        $secretKey = $this->general_settings->cashfree_secret_key;
        $postData = $data;
        // get secret key from your config
        ksort($postData);
        $signatureData = "";
        foreach ($postData as $key => $value) {
            $signatureData .= $key . $value;
        }
        $signature = hash_hmac('sha256', $signatureData, $secretKey, true);
        $signature = base64_encode($signature);
        return $signature;
    }


    public function cashfree_payment_post()
    {
        $sess_unique_id = trim($this->input->get('session_id', TRUE));
        $paymentOption = $this->input->get('paymentOption', TRUE);
        $paymentCode = $this->input->get('paymentCode', TRUE);
        $paymentModes = $this->input->get('paymentModes', TRUE);
        $user_details = $this->auth_model->get_user_detail_by_unique_sess_id($sess_unique_id);
        // var_dump($_SESSION);
        if (!empty($_SESSION["modesy_sess_unique_id"])) {
            // echo "not logout";
            // echo "\n";
            // $this->auth_check = auth_check();
            // if ($this->auth_check) {
            //     $this->auth_user = user();
            // }
            // $user_cart = $this->cart_model->get_user_cart_from_db($this->auth_user->id);
            // $user_cart_id = $user_cart->id;
            // echo "\n";

        }
        if (empty($_SESSION["modesy_sess_unique_id"])) :
            // echo "logout";
            // echo "\n";
            $user_data = array(
                'modesy_sess_unique_id' => $user_details->modesy_sess_unique_id,
                'modesy_sess_user_id' => $user_details->modesy_sess_user_id,
                'modesy_sess_user_email' => $user_details->modesy_sess_user_email,
                'modesy_sess_user_role' => $user_details->modesy_sess_user_role,
                'modesy_sess_logged_in' => true,
                'modesy_sess_app_key' => $user_details->modesy_sess_app_key,
                "cart_total" => $user_details->cart_total,
            );
            $this->session->set_userdata($user_data);

            $this->auth_model->shiprocket_auth_api();

            //check auth
            $this->auth_check = auth_check();
            if ($this->auth_check) {
                $this->auth_user = user();
            }
            $user_cart = $this->cart_model->get_user_cart_from_db($this->auth_user->id);
            $user_cart_id = $user_cart->id;
            // echo "\n";

            if (!empty($user_cart)) {
                $cart_details = $this->cart_model->get_cart_details_by_id($user_cart_id);
                $cart_shipping_details = $this->cart_model->get_cart_shipping_details_by_id($user_cart_id);
                $this->cart_model->add_cart_to_session_from_db($cart_details);
                $this->cart_model->set_sess_cart_shipping_address_from_db($cart_shipping_details);
                $this->cart_model->get_sess_cart_items();
                $this->cart_model->add_delivery_distance();
                $this->cart_model->set_cart_total_from_db($user_cart);
                $cart_total = $this->cart_model->calculate_cart_total();
                $this->cart_model->set_sess_cart_payment_method_from_db($user_cart);
            }
        endif;
        $order_amount =  (int)$this->input->post('orderAmount', true);
        $cart_amount = (int)$user_details->cart_total;
        if ($order_amount != $cart_amount) {
            $match = "no";
        } else {
            $match = "yes";
        }
        $data_transaction = array(
            'payment_method' => "Cashfree",
            'payment_id' => $this->input->post('referenceId', true),
            'cashfree_order_id' => $this->input->post('orderId', true),
            'payment_mode' => $this->input->post('paymentMode', true),
            'cashfree_signature' => $this->input->post('signature', true),
            'payment_status' => $this->input->post('txStatus', true),
            'txMsg' => $this->input->post('txMsg', true),
            'txStatus' => $this->input->post('txStatus', true),
            'txTime' => $this->input->post('txTime', true),
            'currency' => $this->input->post('currency', true),
            'payment_amount' => $this->input->post('orderAmount', true),
            'payment_status' => $this->input->post('txStatus', true),
            'session_id' => $sess_unique_id,
            'paymentOption' => $paymentOption,
            'paymentCode' => $paymentCode,
            'paymentModes' => $paymentModes,
            'match_status' => $match,
            'order_amount' => $order_amount
        );
        // var_dump($data_transaction['payment_amount']);
        // var_dump($user_data['cart_total']);
        // die();
        // if ($user_details->cart_total == $data_transaction['payment_amount']) {

        if (!$this->cashfree_signature_verfication($data_transaction)) {
            // echo "payment success";
            $this->session->set_flashdata('error', 'Invalid signature passed!');
            echo json_encode([
                'result' => 0
            ]);
        } else {
            // echo "payment success";
            // $mds_payment_type = $this->input->post('mds_payment_type', true);
            //add order
            $response = $this->execute_payment($data_transaction, 'sale', lang_base_url());
            if ($response->result == 1) {

                $this->session->set_flashdata('success', $response->message);
                header("Location: $response->redirect_url");
                exit();
            } else {
                $this->session->set_flashdata('error', $response->message);
                header("Location: $response->redirect_url");
                exit();
                // echo json_encode([
                //     'result' => 0
                // ]);
            }
        }
        // } 
        // else {
        //     var_dump("7645758697");
        // }
    }


    public function cashfree_signature_verfication($data_transaction)
    {
        $data = $data_transaction["cashfree_order_id"] . $data_transaction["payment_amount"] . $data_transaction["payment_id"] . $data_transaction["payment_status"] . $data_transaction["payment_mode"] . $data_transaction["txMsg"] . $data_transaction["txTime"];
        // $secretKey = "9029ca61228bcee18a534e7c5ebb400b9e7fee1d";
        $secretKey = $this->general_settings->cashfree_secret_key;
        $hash_hmac = hash_hmac('sha256', $data, $secretKey, true);
        $computedSignature = base64_encode($hash_hmac);
        if ($data_transaction["cashfree_signature"] == $computedSignature) {
            // Proceed
            //$this->order_model->add_payment_cashfree_transaction();
            // echo "matched";
            return true;
        } else {
            // Reject this call
            //echo "<h1> Error in Payment</h1>";

            echo "not matched";
            return false;
        }
    }

    // cashfree payouts authentication token API
    public function init_pay_auth()
    {
        $data_cal = $this->input->post('data_cal', true);
        $mode = $this->input->post('mode', true);
        $data_pay = json_encode($data_cal);


        $transfer_auth_url = ($this->general_settings->payout_batch_transfer_url) . "payout/v1/authorize";
        $transfer_id = $this->general_settings->payout_batch_transfer_id;
        $transfer_key = $this->general_settings->payout_batch_transfer_key;

        // $header_keys = array(
        //     "X-Client-Id" => $transfer_id,
        //     "X-Client-Secret" => $transfer_key
        // );
        // var_dump(json_encode($header_keys)) ;die();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            // CURLOPT_URL => 'https://payout-gamma.cashfree.com/payout/v1/authorize',
            CURLOPT_URL => $transfer_auth_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'X-Client-Id: ' . $transfer_id,
                'X-Client-Secret: ' . $transfer_key
            ),
            // CURLOPT_HTTPHEADER => json_encode($header_keys),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        var_dump($response);

        $token = json_decode($response)->data->token;
        if (json_decode($response)->status == "SUCCESS") {
            $this->init_payout($data_pay, $token, $mode);
        } else {
            echo '<script>alert("Invalid/Expired Token")</script>';
        }
    }

    // Cashfree payouts initiate API
    public function init_payout($data_pay, $token, $mode)
    {
        $header2 = array(
            'Content-Type : application/json',
            'Authorization: Bearer ' . $token
        );

        $sing_arr = array();
        $transfer_url = ($this->general_settings->payout_batch_transfer_url) . "payout/v1/requestBatchTransfer";
        // $length=count($data_pay);
        $timestamp = date('Y-m-d H:i:s');
        // $transfer_id = random_int(10000, 99999);
        $six_digit_random_number = random_int(100000, 999999);

        $data_pay_array = json_decode($data_pay);
        $length = count($data_pay_array);
        for ($i = 0; $i < $length; $i++) {
            $obj = new stdClass();
            $obj_trs = new stdClass();
            $transfer_id = random_int(10000, 99999);
            if ((($data_pay_array[$i]->seller_pay) / 100) < 1000) {
                $payout_charge_with_gst = 2.50 + (0.18 * 2.50);
                $obj->amount = (($data_pay_array[$i]->seller_pay) / 100) - $payout_charge_with_gst;
            } else if ((($data_pay_array[$i]->seller_pay) / 100) >= 1000 && (($data_pay_array[$i]->seller_pay) / 100) < 10000) {
                $payout_charge_with_gst = 5.00 + (0.18 * 5.00);
                $obj->amount = (($data_pay_array[$i]->seller_pay) / 100) - $payout_charge_with_gst;
            } else if ((($data_pay_array[$i]->seller_pay) / 100) >= 10000) {
                $payout_charge_with_gst = 10.00 + (0.18 * 10.00);
                $obj->amount = (($data_pay_array[$i]->seller_pay) / 100) - $payout_charge_with_gst;
            }
            // $obj->amount = ($data_pay_array[$i]->seller_pay) / 100;
            $acc_holder_name = $data_pay_array[$i]->acc_name;
            $acc_name = preg_replace('/[^A-Za-z0-9\ ]/', '', $acc_holder_name);
            // $obj->transferId = $data_pay_array[$i]->seller_id . "-" . $timestamp;
            $obj->transferId = $transfer_id;
            $obj->remarks = "Transfer with Id" . $obj->transferId;

            $obj->name = $acc_name;
            $obj->email = $data_pay_array[$i]->email;
            $obj->phone = $data_pay_array[$i]->phone;
            $obj->bankAccount = $data_pay_array[$i]->acc_no;
            $obj->ifsc = $data_pay_array[$i]->ifsc;
            array_push($sing_arr, $obj);
            $data_pay_array[$i]->transfer_id = $obj->transferId;
            $data1 = array(
                'to' =>  $data_pay_array[$i]->email,
                'remark' => "This is to inform you that payment of Rs" . $data_pay_array[$i]->seller_pay . " Has been initiated and should reflect in your account within the next couple of days.",
                // 'for_user' =>,
                'created_by' => '2',
                'last_updated_by' => '2',
                'source' => 'payouts',
                'source_id' => '',
                'event_type' => 'Payouts',
                'subject' => "Your Paymesnt is initiated",
                'message' => '',
                // 'to' => $seller_id,
            );
            $arr = ["RS " . $data_pay_array[$i]->seller_pay / 100, '3 buiseness days'];
            $passed_data = '"' . implode('","', $arr) . '"';
            $amount = $data_pay_array[$i]->seller_pay / 100;
            $aaa = "'$amount'" . "," . "'3 working days'";
            $aab = trim($aaa, '"');
            $required_data = array(
                "from" => "918287606650",
                "to" => "91$obj->phone",
                "type" => "mediatemplate",
                "channel" => "whatsapp",
                "template_name" => "payout",
                "params" => $passed_data
            );
            if ($this->general_settings->send_whatsapp == 1) {
                $this->notification_model->whatsapp($required_data);
            }
            $this->load->model("email_model");
            $this->email_model->notification($data1);
        }

        $new_data = $sing_arr;
        $post_fields = array(

            "batchTransferId" => "GB" . "-" . $six_digit_random_number,
            "batchFormat" => "BANK_ACCOUNT",
            "batch" => $new_data

        );

        // var_dump($post_fields["batchTransferId"]);die();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            // CURLOPT_URL => 'https://payout-gamma.cashfree.com/payout/v1/requestBatchTransfer',
            CURLOPT_URL => $transfer_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($post_fields),
            CURLOPT_HTTPHEADER => $header2,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;

        $status_code = json_decode($response)->subCode;
        $refrence_id = json_decode($response)->data->referenceId;
        $message = json_decode($response)->message;
        $status = json_decode($response)->status;
        $batch_id = $post_fields["batchTransferId"];

        if ($status_code == "200") {

            for ($i = 0; $i < $length; $i++) {
                $obj = new stdClass();





                if ((($data_pay_array[$i]->seller_pay) / 100) < 1000) {
                    $obj->payout_charge =  2.50;
                } else if ((($data_pay_array[$i]->seller_pay) / 100) >= 1000 && (($data_pay_array[$i]->seller_pay) / 100) < 10000) {
                    $obj->payout_charge =  5.00;
                } else if ((($data_pay_array[$i]->seller_pay) / 100) >= 10000) {
                    $obj->payout_charge =  10.00;
                }




                $obj->seller_id = $data_pay_array[$i]->seller_id;
                $obj->order_id = $data_pay_array[$i]->order_id;
                foreach ($obj->order_id as $order_id) {
                    $this->order_model->update_status_payouts($obj->seller_id, $order_id, $status_code, $refrence_id, $message, $status, $batch_id, $obj->payout_charge, $mode, $data_pay_array[$i]->transfer_id);
                }
            }
            echo $response;
        } else {
            echo  $response;
        }
    }
    //add reviews of last order product
    public function save_rate_last_order()
    {
        if ($this->auth_check && $this->general_settings->reviews == 1) {
            $rating = $this->input->post('rating', true);
            $product_id = $this->input->post('product_id', true);
            $review_text = $this->input->post('review', true);
            // var_dump($rating,$product_id,$review_text);die();


            $rating2 = array();
            foreach ($rating as $rating1) {

                array_push($rating2, $rating1);
            }
            $review_text2 = array();
            foreach ($review_text as $review_text1) {

                array_push($review_text2, $review_text1);
            }
            $i = 0;
            foreach ($product_id as $product_id1) {

                $product = $this->product_model->get_product_by_id($product_id1);

                if ($product->user_id == $this->auth_user->id) {
                    $review = $this->review_model->get_review($product_id1, $this->auth_user->id);
                    //  var_dump($review);die();
                    if (!empty($review)) {
                        $this->review_model->update_review1($review->id, $rating2[$i], $product_id1, $review_text2[$i]);
                        $images = $this->review_model->check_review_images($product_id1, $this->auth_user->id);
                        if (empty($images)) {
                            $this->load->model('upload_model');
                            $this->upload_model->upload_review_image('file_' . $product_id1, $review->id, $product_id1);
                            $reviews = TRUE;
                        } else {
                            $reviews = false;
                        }
                    } else {
                        $this->load->model('upload_model');
                        $last_id = $this->review_model->add_review1($rating2[$i], $product_id1, $review_text2[$i], 'file_'[$i]);
                        $img_path = $this->upload_model->upload_review_image('file_' . $product_id1, $last_id, $product_id1);
                        if (!empty($last_id) || !empty($img_path)) {
                            $reviews = TRUE;
                        } else {
                            $reviews = false;
                        }
                    }
                }
                $i++;
            }
            echo json_encode($reviews);
        }
    }

    public function load_pay_view()
    {

        $pay_method = $this->input->post('pay_method', true);
        $std = new stdClass();
        $std->payment_option = $pay_method;
        $this->session->set_userdata('mds_cart_payment_method', $std);
        $data['mds_payment_type'] = "sale";
        //check is set cart payment method
        $data['cart_payment_method'] = $this->cart_model->get_sess_cart_payment_method();

        $this->cart_model->validate_cart();
        $data['cart_items'] = $this->cart_model->get_sess_cart_items();
        if ($data['cart_items'] == null) {
            redirect(generate_url("cart"));
        }
        $data['cart_payment_method'] = $this->cart_model->get_sess_cart_payment_method();

        $data['cart_total'] = $this->cart_model->get_sess_cart_total();
        $data["shipping_address"] = $this->cart_model->get_sess_cart_shipping_address();
        $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();
        //total amount
        $data['total_amount'] = $data['cart_total']->total_price;
        $data['currency'] = $this->payment_settings->default_currency;

        if ($pay_method == 'cashfree') {
            $pay_view = $this->load->view("cart/payment_methods/cashfree", $data, true);
        } else {
            $pay_view = $this->load->view("cart/payment_methods/_cash_on_delivery", $data, true);
        }
        $response = array(
            "status" => true,
            "pay_view" => $pay_view,

        );
        echo json_encode($response);
    }




    public function shipping_post_test()
    {
        $this->cart_model->set_sess_cart_shipping_address();
        // redirect(generate_url("cart", "payment_method") . "?payment_type=sale");
        $data['keywords'] = trans("shopping_cart") . "," . $this->app_name;
        $data['offer'] = $this->cart_model->available_offers();
        $data['c_items'] = $this->cart_model->get_sess_cart_items();
        $data['c_count'] = get_cart_product_count();
        $data['check_cashond'] = $this->order_model->check_cod($data['c_items'], $data['c_count']);
        $data['check_made_to_order'] = $this->order_model->check_mto($data['c_items']);
        //check for exhibition enabled products
        $data['check_exhibition'] = $this->order_model->check_exhibition_enabled($data['c_items']);


        $data['mds_payment_type'] = "sale";


        //check is set cart payment method
        $data['cart_payment_method'] = $this->cart_model->get_sess_cart_payment_method();

        $this->cart_model->validate_cart();
        //sale payment
        $data['cart_items'] = $this->cart_model->get_sess_cart_items();
        if ($data['cart_items'] == null) {
            redirect(generate_url("cart"));
        }
        $data['cart_total'] = $this->cart_model->get_sess_cart_total();
        $data["shipping_address"] = $this->cart_model->get_sess_cart_shipping_address();
        $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();
        //total amount
        $data['total_amount'] = $data['cart_total']->total_price;
        $data['currency'] = $this->payment_settings->default_currency;

        $payment_type = input_get('payment_type');
        $payment_type = "sale";
        if ($payment_type != "membership" && $payment_type != "promote") {
            $payment_type = "sale";
        }

        if ($payment_type == "sale") {
            $this->cart_model->validate_cart();
            //sale payment
            $data['cart_items'] = $this->cart_model->get_sess_cart_items();
            $data['mds_payment_type'] = "sale";
            if ($data['cart_items'] == null) {
                redirect(generate_url("cart"));
            }
            //check auth for digital products
            if (!$this->auth_check && $this->cart_model->check_cart_has_digital_product() == true) {
                $this->session->set_flashdata('error', trans("msg_digital_product_register_error"));
                redirect(generate_url("register"));
                exit();
            }
            $data['cart_total'] = $this->cart_model->get_sess_cart_total();
            $user_id = null;
            if ($this->auth_check) {
                $user_id = $this->auth_user->id;
            }

            $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();
            $data['cart_has_digital_product'] = $this->cart_model->check_cart_has_digital_product();
            $this->cart_model->unset_sess_cart_payment_method();
        }

        if ($data['cart_total']->total_price != 0) {
            $order_summary = $this->load->view("cart/_order_summary", $data, true);
            $pay_view = $this->load->view('cart/payment_method_ajax', $data, true);
            $response = array(
                "status" => true,
                "pay_view_page" => $pay_view,
                "order_summary" => $order_summary,

            );
            echo json_encode($response);
        } else {
            $this->cash_on_delivery_payment_post();
        }
    }







    public function payment_method_selection()
    {
        // $data['title'] = trans("shopping_cart");
        // $data['description'] = trans("shopping_cart") . " - " . $this->app_name;
        // $data['keywords'] = trans("shopping_cart") . "," . $this->app_name;
        $data['offer'] = $this->cart_model->available_offers();
        $data['c_items'] = $this->cart_model->get_sess_cart_items();
        $data['c_count'] = get_cart_product_count();
        $data['check_cashond'] = $this->order_model->check_cod($data['c_items'], $data['c_count']);
        $data['check_made_to_order'] = $this->order_model->check_mto($data['c_items']);
        //check for exhibition enabled products
        $data['check_exhibition'] = $this->order_model->check_exhibition_enabled($data['c_items']);


        $data['mds_payment_type'] = "sale";


        //check is set cart payment method
        $data['cart_payment_method'] = $this->cart_model->get_sess_cart_payment_method();

        $this->cart_model->validate_cart();
        //sale payment
        $data['cart_items'] = $this->cart_model->get_sess_cart_items();
        if ($data['cart_items'] == null) {
            redirect(generate_url("cart"));
        }
        $data['cart_total'] = $this->cart_model->get_sess_cart_total();
        $data["shipping_address"] = $this->cart_model->get_sess_cart_shipping_address();
        $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();
        //total amount
        $data['total_amount'] = $data['cart_total']->total_price;
        $data['currency'] = $this->payment_settings->default_currency;

        $payment_type = input_get('payment_type');
        $payment_type = "sale";
        if ($payment_type != "membership" && $payment_type != "promote") {
            $payment_type = "sale";
        }

        if ($payment_type == "sale") {
            $this->cart_model->validate_cart();
            //sale payment
            $data['cart_items'] = $this->cart_model->get_sess_cart_items();
            $data['mds_payment_type'] = "sale";
            if ($data['cart_items'] == null) {
                redirect(generate_url("cart"));
            }
            //check auth for digital products
            if (!$this->auth_check && $this->cart_model->check_cart_has_digital_product() == true) {
                $this->session->set_flashdata('error', trans("msg_digital_product_register_error"));
                redirect(generate_url("register"));
                exit();
            }
            $data['cart_total'] = $this->cart_model->get_sess_cart_total();
            $user_id = null;
            if ($this->auth_check) {
                $user_id = $this->auth_user->id;
            }

            $data['cart_has_physical_product'] = $this->cart_model->check_cart_has_physical_product();
            $data['cart_has_digital_product'] = $this->cart_model->check_cart_has_digital_product();
            $this->cart_model->unset_sess_cart_payment_method();
        } elseif ($payment_type == 'membership') {
            //membership payment
            if ($this->general_settings->membership_plans_system != 1) {
                redirect(lang_base_url());
                exit();
            }
            $data['mds_payment_type'] = 'membership';
            $plan_id = $this->session->userdata('modesy_selected_membership_plan_id');
            if (empty($plan_id)) {
                redirect(lang_base_url());
                exit();
            }
            $data['plan'] = $this->membership_model->get_plan($plan_id);
            if (empty($data['plan'])) {
                redirect(lang_base_url());
                exit();
            }
        } elseif ($payment_type == 'promote') {
            //promote payment
            if ($this->general_settings->promoted_products != 1) {
                redirect(lang_base_url());
            }
            $data['mds_payment_type'] = 'promote';
            $data['promoted_plan'] = $this->session->userdata('modesy_selected_promoted_plan');
            if (empty($data['promoted_plan'])) {
                redirect(lang_base_url());
            }
        }
        if ($data['cart_total']->total_price != 0) {

            $this->load->view('partials/_header', $data);
            $this->load->view('cart/payment_method', $data);
            $this->load->view('partials/_footer');
        } else {
            $this->cash_on_delivery_payment_post();
        }
    }
}
