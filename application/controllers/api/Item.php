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
                case "PICKED UP":
                    $data["order_status"] = "shipped";
                    break;
                case "IN TRANSIT":
                    $data["order_status"] = "shipped";
                    break;
                case "RTO INITIATED":
                    $data["order_status"] = "RTO";
                    break;
                case "RTO ACKNOWLEDGED":
                    $data["order_status"] = "RTO";
                    break;
                case "RTO DELIVERED":
                    $data["order_status"] = "RTO";
                    break;
                case "RTO IN TRANSIT":
                    $data["order_status"] = "RTO";
                    break;
                    // default:
                    //     $data["order_status"] = $new_input['order_status'];
            }
            // $data["order_status"] = $new_input['order_status'];

            // $data = $this->db->get_where("shiprocket_order_details", ['awb_code' => $id])->row_array();
            $this->db->where("order_id", $order_id);
            $this->db->where_in("product_id", $product_array);
            $this->db->update('order_products', $data);


            $this->order_model->update_whole_order_status($order_id);

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
