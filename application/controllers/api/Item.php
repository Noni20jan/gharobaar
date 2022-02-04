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
                case "Shipped":
                    $data["order_status"] = "shipped";
                    break;
                case "Pickup Exception":
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
                    // default:
                    //     $data["order_status"] = $new_input['order_status'];
            }
            if ($data['order_status'] == 'completed') {
                $title = $this->product_model->get_title($product_array);
                $order_no = $this->order_model->get_order_detail_by_id($order_id);
                $data1 = array(
                    // 'title' => "Your Product is Successfully Delivered",
                    'remark' => "Your order for " . $title->title . " vide Order #" . $order_id . " has been succefully delivered as per our shipping partner.In order to raise any concerns or issue with the products received kindly click on the link <a href='" . base_url() . "order-details/" . $order_no->order_number . "'>Order Details</a>",
                    // 'for_user' =>,
                    'created_by' => '2',
                    'last_updated_by' => '2',
                    'source' => 'orders',
                    'source_id' => $order_id,
                    'event_type' => 'Product delivered',
                    'subject' => "Your Product is Successfully Delivered",
                    // 'message' => $message,
                    'to' => $order_no->buyer_id,
                );
                $seller_id = $this->order_model->get_seller_id_by_awb($new_input['awb_code']);

                $data2 = array(
                    // 'title' => "Your Product is Successfully Delivered",
                    'remark' => "Your Order No #" .  $order_no->order_number . " Has been succefully deliverd to the buyer.",
                    // 'for_user' =>,
                    'created_by' => '2',
                    'last_updated_by' => '2',
                    'source' => 'orders',
                    'source_id' => $order_id,
                    'event_type' => 'Product delivered',
                    'subject' => "Your Product is Successfully Delivered",
                    // 'message' => $message,
                    'to' => $seller_id,
                );
                $this->load->model("email_model");
                $this->email_model->notification($data1);
                $this->email_model->notification($data2);
            }
            if ($data["order_status"] = "RTO Initiated") {
                $seller_id = $this->order_model->get_seller_id_by_awb($new_input['awb_code']);
                $title = $this->product_model->get_title($product_array);
                $order_no = $this->order_model->get_order_detail_by_id($order_id);
                $data3 = array(
                    // 'title' => "Your Product is Successfully Delivered",
                    'remark' => "Please take note that Order No #" . $order_no->order_number . " containing $title->title shipped vide Tracking No. " . $new_input['awb_code'] . " is undeliverrable and shall be returned back to you. To check and track the status of return, kindly click on the link <a href='" . base_url() . "dashboard/sale/" . $order_no->order_number . "'>Link</a>",
                    // 'for_user' =>,
                    'created_by' => '2',
                    'last_updated_by' => '2',
                    'source' => 'orders',
                    'source_id' => $order_id,
                    'event_type' => 'Product undelivered',
                    'subject' => "Your Product is  Undelivered",
                    // 'message' => $message,
                    'to' => $seller_id,
                );
                $this->load->model("email_model");
                $this->email_model->notification($data3);
            }

            // $data["order_status"] = $new_input['order_status'];
            // $data = $this->db->get_where("shiprocket_order_details", ['awb_code' => $id])->row_array();
            $this->db->where("order_id", $order_id);
            $this->db->where_in("product_id", $product_array);
            $this->db->update('order_products', $data);
            $this->order_model->update_whole_order_status($order_id);
            $this->order_model->get_order_item_count($order_id);
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
