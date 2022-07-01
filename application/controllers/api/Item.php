<?php

require APPPATH . 'libraries/REST_Controller.php';

class Item extends REST_Controller
{

    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function index_get($id = 0)
    {
        if (!empty($id)) {
            $data = $this->db->get_where("order_products", ['id' => $id])->row_array();
        } else {
            $data = $this->db->get("order_products")->result();
        }
        // var_dump($data);
        $this->response($data['order_status'], REST_Controller::HTTP_OK);
    }


    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function index_post()
    {
        $input = $this->input->post();

        $new_input = array();

        $body_raw = file_get_contents('php://input');
        $body_raw = json_decode($body_raw);

        if (!empty($input)) :
            $new_input['awb_code'] = $input['awb'];
            $new_input['order_status'] = $input['current_status'];
        endif;
        if (!empty($body_raw)) :
            $new_input['awb_code'] = $body_raw->awb;
            $new_input['order_status'] = $body_raw->current_status;
        endif;


        $order_id = $this->order_model->get_order_id_by_awb($new_input['awb_code']);
        $product_array = $this->order_model->get_product_id_by_awb($new_input['awb_code']);

        $seller_id_array = array();
        foreach ($product_array as $pa) {
            $sell_id = get_seller_id_by_product_id($pa);

            if (!in_array($sell_id, $seller_id_array, true)) {
                array_push($seller_id_array, $sell_id);
            }
        }
        if ($order_id) {
            $data = array();

            switch ($new_input['order_status']) {
                case "DELIVERED":
                    $data["order_status"] = "completed";
                    break;
                case "Delivered":
                    $data["order_status"] = "completed";
                    break;
                case "ORDER DELIVERED":
                    $data["order_status"] = "completed";
                    break;
                case "SHIPPED":
                    $data["order_status"] = "shipped";
                    break;
                case "Cancellation Requested":
                    $data["order_status"] = "cancelled_by_seller";
                    break;
                case "Canceled":
                    $data["order_status"] = "cancelled_by_seller";
                    break;
                case "CANCELLATION REQUESTED":
                    $data["order_status"] = "cancelled_by_seller";
                    break;
                case "CANCELED":
                    $data["order_status"] = "cancelled_by_seller";
                    break;
                case "Shipped":
                    $data["order_status"] = "shipped";
                    break;
                case "Pickup Exception":
                    $data["order_status"] = "shipped";
                    break;
                case "PICKUP EXCEPTION":
                    $data["order_status"] = "awaiting_pickup";
                    break;
                case "PICKUP RESCHEDULED":
                    $data["order_status"] = "awaiting_pickup";
                    break;
                case "OUT FOR DELIVERY":
                    $data["order_status"] = "shipped";
                    break;
                case "UNDELIVERED":
                    $data["order_status"] = "shipped";
                    break;
                case "ORDER SHIPPED":
                    $data["order_status"] = "shipped";
                    break;
                case "OUT FOR PICKUP":
                    $data["order_status"] = "awaiting_pickup";
                    break;
                case "PICKED UP":
                    $data["order_status"] = "shipped";
                    break;
                case "IN TRANSIT":
                    $data["order_status"] = "shipped";
                    break;
                case "RTO INITIATED":
                    $data["order_status"] = "RTO Initiated";
                    break;
                case "RTO ACKNOWLEDGED":
                    $data["order_status"] = "RTO Acknowledged";
                    break;
                case "RTO DELIVERED":
                    $data["order_status"] = "RTO Delivered";
                    break;
                case "RTO IN TRANSIT":
                    $data["order_status"] = "RTO In Transit";
                    break;
                case "RETURN IN TRANSIT":
                    $data["order_status"] = "Return In Transit";
                    break;
                case "RETURN INITIATED":
                    $data["order_status"] = "Return Initiated";
                    break;
                case "RETURN ACKNOWLEDGED":
                    $data["order_status"] = "Return Acknowledged";
                    break;
                case "RETURN PENDING":
                    $data["order_status"] = "Return Pending";
                    break;
                case "RETURN PICKUP GENERATED":
                    $data["order_status"] = "Return Pickup Generated";
                    break;
                case "RETURN PICKUP QUEUED":
                    $data["order_status"] = "Return Pickup Queued";
                    break;
                case "RETURN PICKEDUP":
                    $data["order_status"] = "Return Picked Up";
                    break;
                case "RTO NDR":
                    $data["order_status"] = "RTO NDR";
                    break;
                case "RTO OFD":
                    $data["order_status"] = "RTO OFD";
                    break;
                case "RETURN DELIVERED":
                    $data["order_status"] = "Return Delivered";
                    break;
                default:
                    $data["order_status"] = $new_input['order_status'];
            }
            $whatsapp_flag = $this->notification_model->send_whatsapp_flag();
            foreach ($whatsapp_flag as $row) :
            endforeach;
            if ($data['order_status'] == 'completed' && $row->send_whatsapp == 1) {
                $order_shipping = $this->order_model->get_order_shipping($order_id);
                $order = $this->order_model->get_order($order_id);

                $arr = [$order_shipping->shipping_first_name, $order->order_number];
                $passed_data = '"' . implode('","', $arr) . '"';
                $delivered_data = array(
                    "from" => "918287606650",
                    "to" => "91$order_shipping->shipping_phone_number",
                    "type" => "mediatemplate",
                    "channel" => "whatsapp",
                    "template_name" => "order_delivered_new",
                    "params" => $passed_data,
                    "param_url" => "order-details" . '/' . $order->order_number
                );
                $this->notification_model->whatsapp($delivered_data);


                foreach ($product_array as $paid) {
                    $title = $this->product_model->get_title($paid);
                    $order_no = $this->order_model->get_order_details_by_id($order_id);
                    // var_dump($order_no->order_number);
                    // die();
                    $user1 = get_user($order_no->buyer_id);

                    $data1 = array(
                        'message' => "",
                        // 'title' => "Your Product is Successfully Delivered",
                        'remark' => "Your order for " . $title->title . " vide Order #" . $order_id . " has been successfully delivered as per our shipping partner.In order to raise any concerns or issue with the products received kindly click on the link <a href='" . base_url() . "order-details/" . $order_no->order_number . "'>Order Details</a>",
                        // 'for_user' =>,
                        'created_by' => '2',
                        'last_updated_by' => '2',
                        'source' => 'orders',
                        'source_id' => $order_id,
                        'event_type' => 'Order Delivered',
                        'subject' => "Your Product is Successfully Delivered",
                        // 'message' => $message,
                        'to' => $user1->email,
                    );
                    $this->load->model("email_model");
                    $this->email_model->notification($data1);
                }
                $seller_id = $this->order_model->get_seller_id_by_awb($new_input['awb_code']);
                $user = get_user($seller_id);
                $data2 = array(
                    // 'title' => "Your Product is Successfully Delivered",
                    'message' => "",
                    'remark' => "Your Order No #" .  $order_no->order_number . " Has been successfully deliverd to the buyer.",
                    // 'for_user' =>,
                    'created_by' => '2',
                    'last_updated_by' => '2',
                    'source' => 'orders',
                    'source_id' => $order_id,
                    'event_type' => 'Order Delivered',
                    'subject' => "Your Product is Successfully Delivered",
                    // 'message' => $message,
                    'to' => $user->email,
                );
                $this->load->model("email_model");
                $this->email_model->notification($data2);
            }
            if ($data["order_status"] == "RTO Initiated") {
                $seller_id = $this->order_model->get_seller_id_by_awb($new_input['awb_code']);
                foreach ($product_array as $paid) {
                    $title = $this->product_model->get_title($paid);
                    $order_no = $this->order_model->get_order_details_by_id($order_id);
                    $user = get_user($seller_id);
                    $data3 = array(
                        'message' => "",
                        // 'title' => "Your Product is Successfully Delivered",
                        'remark' => "Please take note that Order No #" . $order_no->order_number . " containing $title->title shipped vide Tracking No. " . $new_input['awb_code'] . " is undeliverrable and shall be returned back to you. To check and track the status of return, kindly click on the link <a href='" . base_url() . "dashboard/sale/" . $order_no->order_number . "'>Link</a>",
                        // 'for_user' =>,
                        'created_by' => '2',
                        'last_updated_by' => '2',
                        'source' => 'orders',
                        'source_id' => $order_id,
                        'event_type' => 'Order Updates',
                        'subject' => "Your Product is  Undelivered",
                        // 'message' => $message,
                        'to' => $user->email,
                    );
                    $this->load->model("email_model");
                    $this->email_model->notification($data3);
                }
            }
            $awb_code = $new_input['awb_code'];
            $is_msg_send = $this->order_model->get_msg_send_status($awb_code);
            $flag = $this->order_model->update_flag_shipped($awb_code);
            if ($data['order_status'] == 'shipped' && $flag == true && $row->send_whatsapp == 1) {
                $awb_code = $new_input['awb_code'];
                $title = $this->product_model->get_title($product_array);
                $order_no = $this->order_model->get_order_detail_by_id($order_id);
                $order_shipping = $this->order_model->get_order_shipping($order_id);
                $order = $this->order_model->get_order($order_id);
                $arr = [$order_shipping->shipping_first_name, $order->order_number];
                $passed_data = '"' . implode('","', $arr) . '"';
                $required_data = array(
                    "from" => "918287606650",
                    "to" => "91$order_shipping->shipping_phone_number",
                    "type" => "mediatemplate",
                    "channel" => "whatsapp",
                    "template_name" => "order_shipped_new",
                    "params" => $passed_data,
                    "param_url" => "orders" . "/" . "trackstatus" . "/" . $awb_code
                );
                if ($is_msg_send->is_shipped_active == '0') {
                    $this->notification_model->whatsapp($required_data);
                }
            }


            // $data["order_status"] = $new_input['order_status'];
            // $data = $this->db->get_where("shiprocket_order_details", ['awb_code' => $id])->row_array();
            // $data["order_status"] = $new_input['order_status'];
            // $data = $this->db->get_where("shiprocket_order_details", ['awb_code' => $id])->row_array();
            $this->db->where("order_id", $order_id);
            $this->db->where_in("product_id", $product_array);
            $this->db->update('order_products', $data);
            $this->order_model->update_whole_order_status($order_id);
            $this->order_model->get_order_item_count($order_id);

            foreach ($seller_id_array as $sia) {
                $this->order_model->update_order_status_if_completed_seller_wise($order_id, $sia);
            }

            $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['No Records to update.'], REST_Controller::HTTP_OK);
        }
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function index_put($id)
    {
        $input = $this->put();

        $new_input = array();

        $new_input['awb_code'] = $input['awb'];
        $new_input['order_status'] = $input['current_status'];


        $order_id = $this->order_model->get_order_id_by_awb($new_input['awb_code']);
        $product_array = $this->order_model->get_product_id_by_awb($new_input['awb_code']);
        if ($order_id) {
            $data = array();
            $data["order_status"] = $new_input['order_status'];

            // $data = $this->db->get_where("shiprocket_order_details", ['awb_code' => $id])->row_array();
            $this->db->where("order_id", $order_id);
            $this->db->where_in("product_id", $product_array);
            $this->db->update('order_products', $data);

            $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['No Records to update.'], REST_Controller::HTTP_OK);
        }
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function index_delete($id)
    {
        $this->db->delete('items', array('id' => $id));

        $this->response(['Item deleted successfully.'], REST_Controller::HTTP_OK);
    }
}
