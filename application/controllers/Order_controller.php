<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_controller extends Home_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->auth_check) {
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                $link = "https";
            } else {
                $link = "http";
            }

            // Here append the common URL characters.
            $link .= "://";

            // Append the host(domain name, ip) to the URL.
            $link .= $_SERVER['HTTP_HOST'];

            // Append the requested resource location to the URL
            $link .= $_SERVER['REQUEST_URI'];
            redirect(lang_base_url() . "?url=" . $link);
        }
        if (!$this->is_sale_active) {
            redirect(lang_base_url());
        }
        $this->order_per_page = 15;
        $this->earnings_per_page = 15;
        $this->user_id = $this->auth_user->id;
    }

    /**
     * Orders
     */
    public function orders()
    {
        $data['title'] = trans("orders");
        $data['description'] = trans("orders") . " - " . $this->app_name;
        $data['keywords'] = trans("orders") . "," . $this->app_name;
        $data["active_tab"] = "active_orders";
        $data['main_settings'] = get_main_settings();
        $pagination = $this->paginate(generate_url("orders"), $this->order_model->get_orders_count($this->user_id), $this->order_per_page);
        $data['orders'] = $this->order_model->get_paginated_orders($this->user_id, $pagination['per_page'], $pagination['offset']);
        // var_dump($data['orders']);

        $this->load->view('partials/_header', $data);
        $this->load->view('order/orders_old', $data);
        $this->load->view('partials/_footer');
    }

    public function orders_dashboard()
    {
        $data['title'] = trans("orders");
        $data['description'] = trans("orders") . " - " . $this->app_name;
        $data['keywords'] = trans("orders") . "," . $this->app_name;
        $data["active_tab"] = "active_orders";
        $data['main_settings'] = get_main_settings();
        // $pagination = $this->paginate(generate_url("orders_dashboard"), $this->order_model->get_orders_count($this->user_id), $this->order_per_page);
        // $data['orders'] = $this->order_model->get_paginated_orders($this->user_id, $pagination['per_page'], $pagination['offset']);

        $pagination = $this->paginate(generate_url("orders_dashboard"), $this->order_model->get_order_products_count($this->user_id), $this->order_per_page);
        $data['orders'] = $this->order_model->get_paginated_order_products($this->user_id, $pagination['per_page'], $pagination['offset']);


        // $data['testing'] =  $this->order_model->get_order_product_by_id();
        $this->load->view('dashboard/includes/_header_buyer', $data);
        $this->load->view('order/orders', $data);
        // $this->load->view('dashboard/includes/_footer');
        $this->load->view('partials/_footer');
    }

    public function orders_dashboard_mobile()
    {
        $data['title'] = trans("orders");
        $data['description'] = trans("orders") . " - " . $this->app_name;
        $data['keywords'] = trans("orders") . "," . $this->app_name;
        $data["active_tab"] = "active_orders";
        $data['main_settings'] = get_main_settings();
        // $pagination = $this->paginate(generate_url("orders_dashboard"), $this->order_model->get_orders_count($this->user_id), $this->order_per_page);
        // $data['orders'] = $this->order_model->get_paginated_orders($this->user_id, $pagination['per_page'], $pagination['offset']);

        $pagination = $this->paginate(generate_url("orders_dashboard_mobile"), $this->order_model->get_order_products_count($this->user_id), $this->order_per_page);
        $data['orders'] = $this->order_model->get_paginated_order_products($this->user_id, $pagination['per_page'], $pagination['offset']);


        // $data['testing'] =  $this->order_model->get_order_product_by_id();
        $this->load->view('dashboard/includes/_header_buyer', $data);
        $this->load->view('order/orders_mobile', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Completed Orders
     */
    public function completed_orders()
    {
        $data['title'] = trans("orders");
        $data['description'] = trans("orders") . " - " . $this->app_name;
        $data['keywords'] = trans("orders") . "," . $this->app_name;
        $data["active_tab"] = "completed_orders";
        $data['main_settings'] = get_main_settings();
        $pagination = $this->paginate(generate_url("orders", "completed_orders"), $this->order_model->get_completed_orders_count($this->user_id), $this->order_per_page);
        $data['orders'] = $this->order_model->get_paginated_completed_orders($this->user_id, $pagination['per_page'], $pagination['offset']);

        $this->load->view('partials/_header', $data);
        $this->load->view('order/orders_old', $data);
        $this->load->view('partials/_footer');
    }


    public function order_test($order_number)
    {
        $data['title'] = trans("orders");
        $data['description'] = trans("orders") . " - " . $this->app_name;
        $data['keywords'] = trans("orders") . "," . $this->app_name;
        $data["active_tab"] = "";
        $data["cart_items"] = $this->cart_model->get_sess_cart_items();
        $data["cart_total"] = $this->cart_model->get_sess_cart_total();
        $data["order"] = $this->order_model->get_order_by_order_number($order_number);
        $data["order_products"] = $this->order_model->get_order_products($data["order"]->id);
        $product = array();
        foreach ($data["order_products"] as $order_details) {
            array_push($product, $this->product_model->get_product_by_id($order_details->product_id));
        }
        $data["products"] = $product;
        $data['check'] = $this->order_model->get_stats($data["order"]->id, ($order_details->product_id));



        if (empty($data["order"])) {
            redirect(lang_base_url());
        }
        if ($data["order"]->buyer_id != $this->user_id) {
            redirect(lang_base_url());
        }
        $data['main_settings'] = get_main_settings();
        $data["reject_reason"] = $this->order_model->get_reject_reason_buyer();
        $data["order_products"] = $this->order_model->get_order_products($data["order"]->id);
        $data["order_products_history"] = $this->order_model->get_user_order_history($this->user_id);
        $data["last_bank_transfer"] = $this->order_admin_model->get_bank_transfer_by_order_number($data["order"]->order_number);

        $this->load->view('partials/_header', $data);
        $this->load->view('order/order_test', $data);
        $this->load->view('partials/_footer');
    }

    public function order_test_2($order_number)
    {
        $data['title'] = trans("orders");
        $data['description'] = trans("orders") . " - " . $this->app_name;
        $data['keywords'] = trans("orders") . "," . $this->app_name;
        $data["active_tab"] = "";
        $data["cart_items"] = $this->cart_model->get_sess_cart_items();
        $data["cart_total"] = $this->cart_model->get_sess_cart_total();
        $data["order"] = $this->order_model->get_order_by_order_number($order_number);
        $data["order_products"] = $this->order_model->get_order_products($data["order"]->id);
        $product = array();
        foreach ($data["order_products"] as $order_details) {
            array_push($product, $this->product_model->get_product_by_id($order_details->product_id));
        }
        $data["products"] = $product;
        $data['check'] = $this->order_model->get_stats($data["order"]->id, ($order_details->product_id));



        if (empty($data["order"])) {
            redirect(lang_base_url());
        }
        if ($data["order"]->buyer_id != $this->user_id) {
            redirect(lang_base_url());
        }
        $data['main_settings'] = get_main_settings();
        $data["reject_reason"] = $this->order_model->get_reject_reason_buyer();
        $data["order_products"] = $this->order_model->get_order_products($data["order"]->id);
        $data["order_products_history"] = $this->order_model->get_user_order_history($this->user_id);
        $data["last_bank_transfer"] = $this->order_admin_model->get_bank_transfer_by_order_number($data["order"]->order_number);

        $this->load->view('partials/_header', $data);
        $this->load->view('order/order_test_2', $data);
        $this->load->view('partials/_footer');
    }


    public function completed_orders_dashboard()
    {
        $data['title'] = trans("orders");
        $data['description'] = trans("orders") . " - " . $this->app_name;
        $data['keywords'] = trans("orders") . "," . $this->app_name;
        $data["active_tab"] = "completed_orders_dashboard";
        $data['main_settings'] = get_main_settings();
        // $pagination = $this->paginate(generate_url("orders", "completed_orders_dashboard"), $this->order_model->get_completed_orders_count($this->user_id), $this->order_per_page);
        // $data['orders'] = $this->order_model->get_paginated_completed_orders($this->user_id, $pagination['per_page'], $pagination['offset']);
        $pagination = $this->paginate(generate_url("orders", "completed_orders_dashboard"), $this->order_model->get_completed_order_products_count($this->user_id), $this->order_per_page);
        $data['orders'] = $this->order_model->get_paginated_completed_order_products($this->user_id, $pagination['per_page'], $pagination['offset']);


        $this->load->view('dashboard/includes/_header_buyer', $data);
        $this->load->view('order/orders', $data);
        $this->load->view('dashboard/includes/_footer');
    }
    /**
     * Order
     */
    public function order($order_number)
    {
        $data['title'] = trans("orders");
        $data['description'] = trans("orders") . " - " . $this->app_name;
        $data['keywords'] = trans("orders") . "," . $this->app_name;
        $data["active_tab"] = "";
        $data["cart_items"] = $this->cart_model->get_sess_cart_items();
        $data["cart_total"] = $this->cart_model->get_sess_cart_total();
        $data["order"] = $this->order_model->get_order_by_order_number($order_number);
        $data["order_products"] = $this->order_model->get_order_products($data["order"]->id);
        $product = array();
        foreach ($data["order_products"] as $order_details) {
            array_push($product, $this->product_model->get_product_by_id($order_details->product_id));
        }
        $data["products"] = $product;
        $data['check'] = $this->order_model->get_stats($data["order"]->id, ($order_details->product_id));



        if (empty($data["order"])) {
            redirect(lang_base_url());
        }
        if ($data["order"]->buyer_id != $this->user_id) {
            redirect(lang_base_url());
        }
        $data['main_settings'] = get_main_settings();
        $data["reject_reason"] = $this->order_model->get_reject_reason_buyer();
        $data["order_products"] = $this->order_model->get_order_products($data["order"]->id);
        $data["order_products_history"] = $this->order_model->get_user_order_history($this->user_id);
        $data["last_bank_transfer"] = $this->order_admin_model->get_bank_transfer_by_order_number($data["order"]->order_number);

        $this->load->view('dashboard/includes/_header_buyer', $data);
        $this->load->view('order/order', $data);
        $this->load->view('partials/_footer', $data);
        // $this->load->view('dashboard/includes/_footer');
    }

    public function order_product($order_product_id)
    {
        $data['title'] = "Order";
        $data['description'] = "Order" . " - " . $this->app_name;
        $data['keywords'] = "Order" . "," . $this->app_name;
        $data["active_tab"] = "";
        $data["cart_items"] = $this->cart_model->get_sess_cart_items();
        $data["cart_total"] = $this->cart_model->get_sess_cart_total();
        // $data["order"] = $this->order_model->get_order_by_order_number($order_number);
        $data["order_product"] = $this->order_model->get_order_product($order_product_id);
        $product =  $this->product_model->get_product_by_id($data["order_product"]->product_id);

        // foreach ($data["order_products"] as $order_details) {
        //     array_push($product, $this->product_model->get_product_by_id($order_details->product_id));
        // }
        // $data["products"] = $product;
        $data['check'] = $this->order_model->get_stats($data["order_product"]->order_id, ($data["order_product"]->product_id));



        if (empty($data["order_product"])) {
            redirect(lang_base_url());
        }
        if ($data["order_product"]->buyer_id != $this->user_id) {
            redirect(lang_base_url());
        }
        $data['main_settings'] = get_main_settings();
        $data["reject_reason"] = $this->order_model->get_reject_reason_buyer();
        // $data["order_products"] = $this->order_model->get_order_products($data["order"]->id);
        $data["order_products_history"] = $this->order_model->get_user_order_history($this->user_id);
        //  $data["last_bank_transfer"] = $this->order_admin_model->get_bank_transfer_by_order_number($data["order"]->order_number);

        $this->load->view('partials/_header', $data);
        $this->load->view('order/order', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Bank Transfer Payment Report Post
     */
    public function bank_transfer_payment_report_post()
    {
        $this->order_model->add_bank_transfer_payment_report();
        redirect($this->agent->referrer());
    }

    public function accept_reject_order()
    {
        $order_id = $this->input->post('order_id', true);
        $action = $this->input->post('submit', true);


        if ($this->order_model->accept_reject_order($order_id, $action)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }


    public function accept_reject_order_product()
    {
        $order_product_id = $this->input->post('order_product_id', true);
        $action = $this->input->post('submit', true);
        $reject_reason_before_accept = $this->input->post('reject_reason_before_accept', true);
        $reject_reason_comment = $this->input->post('reject_reason_comment2', true);
        $order_product = $this->order_model->get_order_product($order_product_id);
        $order_id = $order_product->order_id;
        $order_detail = $this->order_model->get_order_detail_by_id($order_id);
        $payment_method = $order_detail[0]->payment_method;

        if ($action == "reject" && $payment_method == "Cashfree") {
            $this->refund_api_data($order_product_id);
            if ($this->general_settings->enable_easysplit == 0) {
                $this->order_model->recal_prepaid_seller_payable($order_id);
            } else {
                $this->order_model->recal_cod_seller_payable($order_id);
            }
        }
        if ($this->order_model->accept_reject_order_product($order_product_id, $action, $reject_reason_before_accept, $reject_reason_comment)) {

            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }
    /**
     * Approve Order Product
     */
    public function approve_order_product_post()
    {
        $order_id = $this->input->post('order_product_id', true);
        $order_product_id = $this->input->post('order_product_id', true);
        if ($this->order_model->approve_order_product($order_product_id)) {
            //order product
            $order_product = $this->order_model->get_order_product($order_product_id);
            //add seller earnings
            $this->earnings_model->add_seller_earnings($order_product);
            //update order status
            $this->order_admin_model->update_order_status_if_completed($order_product->order_id);
        }
    }


    /**
     * Cancel Order Product
     */
    public function cancel_order_product_post()
    {

        $reject_reason = $this->input->post('reject_reason', true);
        $reject_reason_comment1 = $this->input->post('reject_reason_comment1', true);
        $order_product_id = $this->input->post('order_product_id', true);

        $order_product = $this->order_model->get_order_product($order_product_id);
        $order_id = $order_product->order_id;
        $order_detail = $this->order_model->get_order_detail_by_id($order_id);


        $order_product_id = $this->input->post('order_product_id', true);
        $order_product = get_order_product($order_product_id);
        $supplier = get_user($order_product->seller_id);
        $buyer = get_user($order_product->buyer_id);
        $email = get_user($order_product->seller_id)->email;
        if ($this->order_model->cancel_order_product($order_product_id, $reject_reason, $reject_reason_comment1)) {

            //refund initiation for cancel item (online payments)
            $payment_method = $order_detail[0]->payment_method;
            if ($payment_method == 'Cashfree') {
                //refund api call for cashfree
                $this->refund_api_data($order_product_id);
                if ($this->general_settings->enable_easysplit == 0) {
                    $this->order_model->recal_prepaid_seller_payable($order_id);
                }
            } else {
                $this->order_model->recal_cod_seller_payable($order_id);
            }

            $this->load->model("email_model");
            $this->session->set_flashdata('submit', "send_email");

            if (!empty($supplier->email) && !empty($buyer->email)) {
                if ($this->email_model->cancel_order_product_mail($supplier->email, $supplier, $order_product) && $this->email_model->cancel_order_product_mail_buyer($buyer->email, $buyer, $order_product)) {
                    redirect($this->agent->referrer());
                }
                $this->session->set_flashdata('success', trans("msg_email_sent"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
            redirect($this->agent->referrer());
        }
    }



    public function order_window_update()
    {
        // echo ("test");
        // die();
        //fetching all order products with waiting status
        $order_products = $this->order_model->order_window_update();
        //bussines time start and end
        $start_time = strtotime($this->general_settings->bussiness_start_at);
        $end_time = strtotime($this->general_settings->bussiness_end_at);
        //time window in second
        $time_window = $this->general_settings->time_window;
        //current time stamp
        $current_time = time();
        //one day seconds
        $one_day_seconds = strtotime('1 day', 0);

        foreach ($order_products as $order_product) {

            $order_created_time = $order_product->created_date;
            $order_timestamp = strtotime($order_created_time);
            $order_time = explode(" ", $order_created_time);

            if (strtotime($order_time[1]) <= $start_time) {
                var_dump($order_product->created_date);
                if (($current_time - $start_time) >= $time_window) :
                    echo "hitAPI<br>";
                endif;
            } else if (($start_time < strtotime($order_time[1])) &&  (strtotime($order_time[1]) < $end_time)) {
                var_dump($order_product->created_date);
                if (($end_time - $order_timestamp) >= $time_window) :
                    if (($current_time - $order_timestamp) >= $time_window) :
                        echo "hitAPI<br>";
                    endif;
                else :
                    if (((($end_time - $order_timestamp) - $one_day_seconds) + ($current_time - $start_time)) > $time_window) :
                        echo "hitAPI<br>";
                    endif;
                endif;
            } else {
                var_dump($order_product->created_date);
                if ($order_timestamp < $start_time) :
                    if ((($current_time - $order_timestamp) - ($start_time - $order_timestamp)) >= $time_window) :
                        echo "hitAPI<br>";
                    endif;
                endif;
            }
        }
    }

    function update_order_status_after_window_past($order_product)
    {
        $update_result = $this->order_model->updated_order($order_product->oid, $order_product->mid);

        if ($update_result) {
            $supplier = get_user($order_product->seller_id);
            $buyer = get_user($order_product->buyer_id);
            $this->load->model("email_model");
            $this->session->set_flashdata('submit', "send_email");

            if (!empty($supplier->email) && !empty($buyer->email)) {
                if ($this->email_model->order_window_update_mail_seller($supplier->email, $supplier, $order_product) && $this->email_model->order_window_update_mail_buyer($buyer->email, $buyer, $order_product)) {
                    echo "mail sent";
                }
                $this->order_model->update_mail($order_product->mid);
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        }
    }

    function update_order_status_after_timer_up()
    {

        $order_id = $this->input->post("order_id");
        $product_id = $this->input->post("product_id");

        $m_id = $this->order_model->get_made_to_order_id($order_id, $product_id);

        $op_id = $this->order_model->get_order_product_id($order_id, $product_id);

        $update_result = $this->order_model->updated_order($op_id->id, $m_id->id);

        if ($update_result) {
            $supplier = get_user($m_id->seller_id);
            $buyer = get_user($m_id->buyer_id);
            $this->load->model("email_model");
            $this->session->set_flashdata('submit', "send_email");

            if (!empty($supplier->email) && !empty($buyer->email)) {
                if ($this->email_model->order_window_update_mail_seller($supplier->email, $supplier, $op_id) && $this->email_model->order_window_update_mail_buyer($buyer->email, $buyer, $op_id)) {
                    $data = array(
                        "status" => 1,
                        "res" => "mail sent"
                    );
                    echo json_encode($data);
                }
                $this->order_model->update_mail($m_id->id);
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                $data = array(
                    "status" => 0,
                    "res" => trans("msg_error")
                );
                echo json_encode($data);
            }
        }
    }
    // change sanyam end
    public function trackstatus($awb_number)
    {
        $data['title'] = trans("orders");
        $data['description'] = trans("orders") . " - " . $this->app_name;
        $data['keywords'] = trans("orders") . "," . $this->app_name;
        $data["active_tab"] = "";
        $data["cart_items"] = $this->cart_model->get_sess_cart_items();
        $data["cart_total"] = $this->cart_model->get_sess_cart_total();
        // $data["order"] = $this->order_model->get_order_by_order_number($order_number);
        $data["shipping"] = $this->cart_model->get_shipping_details($this->auth_user->id);

        $data["check"] = get_shiprocket_order_details_by_awb($awb_number);
        $response = $this->order_model->shiprocket_tracking_status($awb_number);

        $tracking_status = $response->tracking_data->track_status;
        $data['tracking_status'] = $tracking_status;
        if ($tracking_status) {
            $data['track_statuses'] = $response->tracking_data->shipment_track_activities;
            $data['c_status'] = $response->tracking_data->shipment_track[0]->current_status;
            $data['url'] = $response->tracking_data->track_url;
        }

        // // var_dump($data['track_statuses']);
        // $product = array();
        // foreach ($data["order_products"] as $order_details) {
        //     array_push($product, $this->product_model->get_product_by_id($order_details->product_id));
        // }
        // $data["products"] = $product;
        $this->load->view('partials/_header', $data);
        $this->load->view('order/orders_details', $data);
        $this->load->view('partials/_footer');
    }


    public function get_wrapper()
    {

        $product_id = $this->input->post('product_id', true);
        $product = $this->product_model->get_product_by_id($product_id);

        // var_dump($product);
        // die();
        if (!empty($product)) {

            $data = array(
                'status' => 1,
                'product' => $product

            );
            echo json_encode($data);
        }
    }
    public function refund_api_data($order_product_id)
    {
        $order_product_id = clean_number($order_product_id);
        $order_product = $this->order_model->get_order_product($order_product_id);
        $order_id = $order_product->order_id;
        $product_id = $order_product->product_id;
        $product_quantity = $order_product->product_quantity;
        $product_unit_price = $order_product->product_unit_price;
        $product_discount_rate = $order_product->product_discount_rate;
        $product_gst_rate = $order_product->product_gst_rate;
        $product_name = $order_product->product_title;
        $total_price_with_quantity = $order_product->product_total_price;
        // $price_after_discount = calculate_product_price($product_unit_price, $product_discount_rate, $product_gst_rate);
        $product_seller_id = $order_product->seller_id;


        $order_transaction_detail = $this->order_model->get_transaction_detail($order_id);
        $payment_refrence_id = $order_transaction_detail[0]->payment_id;
        // $refund_amount1 = ($price_after_discount * $product_quantity) / 100;
        // $refund_amount = number_format(floor($refund_amount1 * 100) / 100, 2);
        $refund_amount = $total_price_with_quantity / 100;
        $order_detail = $this->order_model->get_order_detail_by_id($order_id);

        // shipping charges seller & product wise
        $shipping_amount_without_round = ($order_product->product_shipping_cost) / 100;
        $shipping_amount = round($shipping_amount_without_round);


        // shipping amount according to complete order
        // $shipping_amount = ($order_detail[0]->price_shipping) / 100;

        //shipping charge check
        $include_shipping = true;
        $order_products =  $this->order_model->get_order_product_detail($order_id);
        foreach ($order_products as $products) {
            if ((int)$products->id != (int)$order_product_id) {
                if (($products->order_status == "completed" || $products->order_status == "processing" || $products->order_status == "waiting" || $products->order_status == "awaiting_shipment" || $products->order_status == "awaiting_pickup") && ($products->seller_id == $product_seller_id)) {
                    $include_shipping = false;
                    break;
                }
            }
        }

        // var_dump($include_shipping);

        if ($include_shipping) {
            // $shipping_amount = ($order_detail[0]->price_shipping) / 100;
            $refund_amount = $refund_amount + $shipping_amount;
        }

        // $shipping_amount = ($order_detail[0]->price_shipping) / 100;
        // var_dump($refund_amount);
        // die();
        $order_total_amount = $order_detail[0]->price_total;
        $data = array(
            "order_id" => $order_id,
            "refund_amount" => $refund_amount,
            "payment_refrence_id" => $payment_refrence_id,
            "order_product_table_id" => $order_product_id,
            "order_product_id" => $product_id,
            "order_total_amount" => $order_total_amount
        );

        $this->refund_api($refund_amount, $payment_refrence_id, $product_name, $data);
    }

    public function refund_api($refund_amount, $payment_refrence_id, $product_name, $data)
    {
        $refund_data = $data;
        $refund_amount = $refund_amount;
        $payment_refrence_id = $payment_refrence_id;
        $product_name = $product_name;
        $cashfree_refundurl = $this->general_settings->cashfree_api_base_url . 'api/v1/order/refund';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            // CURLOPT_URL => '%7B%7BBase%20URL%7D%7D/api/v1/order/refund',
            CURLOPT_URL => $cashfree_refundurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'appId' => $this->general_settings->cashfree_app_id,
                'secretKey' => $this->general_settings->cashfree_secret_key,
                'referenceId' => $payment_refrence_id,
                'refundAmount' => $refund_amount,
                'refundNote' => 'Refund for ' . $product_name,
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $responded_data = json_decode($response);
        $refund_data["status"] = $responded_data->status;
        $refund_data["message"] = $responded_data->message;
        $refund_data["refund_id"] = $responded_data->refundId;
        $refund_data["refund_note"] = 'Refund for ' . $product_name;
        $refund_data["created_by"] = $this->auth_user->id;
        $this->order_model->save_refund_detail($refund_data);
    }

    public function fetch_all_refunds()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);
        $cashfree_fetchrefundurl = $this->general_settings->cashfree_api_base_url . 'api/v1/refunds';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            // CURLOPT_URL => '{{Base URL}}/api/v1/refunds',
            CURLOPT_URL => $cashfree_fetchrefundurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'appId' => $this->general_settings->cashfree_app_id,
                'secretKey' => $this->general_settings->cashfree_secret_key,
                'startDate' => $from_date,
                'endDate' => $to_date,
                'count' => '50'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        // echo $response;

        $php_response = json_decode($response);
        $i = 0;
        foreach ($php_response->refunds as $refunds) {
            $transaction_detail = $this->order_model->get_order_number_by_cashfree_id($refunds->orderId);
            $php_response->refunds[$i]->sys_order_id = $transaction_detail[0]->order_id;
            $i++;
        }
        echo json_encode($php_response);
    }



    public function now_bike_order()
    {
        $order_product_id = $this->input->post('order_product_id', true);
        for ($i = 0; $i < count($order_product_id); $i++) {
            $now_bike_id = $this->input->post('now_bike_id', true);
            $order_id = $this->input->post('order_id', true);

            $data = array();
            $data["now_bike_id"] = $now_bike_id;
            $data["order_id"] = $order_id;
            $data["order_product_id"] = $order_product_id[$i];
            $insert_id = $this->order_model->create_now_bike_order($data);
            if ($insert_id) {
                echo true;
            }
        }
    }

    public function now_bike_order_cancel()
    {
        $now_bike_id = $this->input->post('now_bike_id', true);

        $cancel_reason = $this->input->post('cancellation_reason', true);
        $data = array();
        $data["cancellation_reason"] = $cancel_reason;

        $this->order_model->cancel_now_bike_order($now_bike_id, $data);
    }

    public function cancel_shipment()
    {
        $shipment_order_id = $this->input->post('shipment_order_id', true);
        // $order_product_id = $this->input->post('item_id', true);

        $cancel_response = $this->order_model->cancel_order($shipment_order_id);
        $data = array(
            "cancel_response" => $cancel_response
        );

        $html_content = $this->load->view('dashboard/cancel_shiprocket_view', $data, true);


        $result_data = array(
            'result' => 1,
            'html_content' => $html_content,
        );
        echo json_encode($result_data);
    }

    // schedule shiprocket orders

    public function schedule_shiprocket_orders()
    {
        $req_data = $this->input->post('order');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/shipments/create/forward-shipment',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($req_data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $_SESSION['modesy_sess_user_shiprocket_token']
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
    }



    public function now_bike_generate_order_post()
    {
        $url = $this->input->post('url');
        $req_data = $this->input->post('order');

        $data = array(
            "order" => $req_data
        );

        // var_dump($url);
        // var_dump($req_data);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            http_build_query($data)
        );

        // In real life you should use something like:
        // curl_setopt($ch, CURLOPT_POSTFIELDS, 
        //          http_build_query(array('postvar1' => 'value1')));

        // Receive server response ...


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close($ch);

        echo $server_output;
    }

    public function now_bike_order_cancel_post()
    {
        $url = $this->input->post('url');
        $req_data = $this->input->post('order');

        $data = array(
            "order" => $req_data
        );

        // var_dump($url);
        // var_dump($req_data);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            http_build_query($data)
        );

        // In real life you should use something like:
        // curl_setopt($ch, CURLOPT_POSTFIELDS, 
        //          http_build_query(array('postvar1' => 'value1')));

        // Receive server response ...


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close($ch);

        echo $server_output;
    }

    public function get_now_bike_details()
    {
        $url = $this->input->post('url');
        // create & initialize a curl session
        $curl = curl_init();

        // set our url with curl_setopt()
        curl_setopt($curl, CURLOPT_URL, $url);

        // return the transfer as a string, also with setopt()
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // curl_exec() executes the started curl session
        // $output contains the output string
        $output = curl_exec($curl);

        // close curl resource to free up system resources
        // (deletes the variable made by curl_init)
        curl_close($curl);

        echo $output;
    }

    public function payout_initiate()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);

        $cod_seller_payable = $this->order_model->fetch_cod_seller_payable($from_date, $to_date);
        echo json_encode($cod_seller_payable);
    }

    public function prepaid_payout_initiate()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);

        $cod_seller_payable = $this->order_model->fetch_prepaid_seller_payable($from_date, $to_date);
        echo json_encode($cod_seller_payable);
        // die();
    }
    //cod payout initiated
    public function initiated_cod_payout()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);

        $cod_seller_payable = $this->order_model->fetch_cod_payout_inititated($from_date, $to_date);
        echo json_encode($cod_seller_payable);
    }
    //prepaide payout initiated
    public function prepaid_payout_initiated()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);

        $cod_seller_payable = $this->order_model->fetch_prepaid_payout_initiated($from_date, $to_date);
        echo json_encode($cod_seller_payable);
        // die();
    }

    public function qualify_criteria()
    {
        $user_type = $this->input->post('user_type', true);
        $loyalty_type = $this->input->post('loyalty_type', true);

        $data = $this->offer_model->fetch_kpi_data($user_type);
        $final = array(
            "data" => $data,
            "loyalty_type" => $loyalty_type
        );

        echo json_encode($final);
    }



    public function qualify_criteria_submit()
    {
        $form = $this->input->post();

        $type = "";
        $oldPointer = 0;
        $final = array();
        $obj = new stdClass();

        foreach ($form as $keyName => $value) {

            // $keyNode = explode("+",$keyName);
            // array_push($final,$keyNode[0]);

            if ($keyName == "criteria_value_type") :
                $type = $value;
            else :
                $keyNode = explode("+", $keyName);
                if (!empty($keyNode[1])) :
                    $pointer = $keyNode[1];
                    if ($oldPointer != $pointer) :
                        $oldPointer = $pointer;
                        if ($pointer > 1) :
                            array_push($final, $obj);
                        endif;
                        $obj = new stdClass();
                        $obj->criteria_value_type = $type;
                        $obj->{$keyNode[0]} = $value;
                    else :

                        $obj->{$keyNode[0]} = $value;
                    endif;
                endif;

            // $obj["dkhf3"]=>"ljqwdn";
            endif;
        }

        $this->offer_model->save_qualify_criteria($final);
        // var_dump($final);
        // die();

        // // $data = $this->offer_model->fetch_kpi_data($user_type);
        // // echo json_encode($data);
    }
}
