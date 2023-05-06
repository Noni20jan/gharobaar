<?php
defined('BASEPATH') or exit('No direct script access allowed');
require(APPPATH . '/libraries/REST_Controller.php');
class Payouts_webhook extends REST_Controller
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
        $data = $_POST;
        $details = array();
        $details['event'] = $_POST["event"];

        $signature = $_POST["signature"];
        unset($data["signature"]); // $data now has all the POST parameters except signature
        ksort($data); // Sort the $data array based on keys
        $postData = "";
        foreach ($data as $key => $value) {
            if (strlen($value) > 0) {
                $postData .= $value;
            }
        }
        $clientSecret = $this->general_settings->cashfree_secret_key;
        $hash_hmac = hash_hmac('sha256', $postData, $clientSecret, true);

        // Use the clientSecret from the oldest active Key Pair.
        $computedSignature = base64_encode($hash_hmac);
        if ($signature == $computedSignature) {
            // Proceed based on $event


            if ($details['event'] == 'TRANSFER_SUCCESS') {
                $details['event_status'] = $_POST["transferId"];
                $details['transferId'] = $_POST["transferId"];
                $details['referenceId'] = $_POST["referenceId"];
                $details['$eventTime'] = $_POST["eventTime"];
                $details['$utr'] = $_POST["utr"];
                $details['signature'] = $_POST["signature"];
            } elseif ($details['event'] == 'TRANSFER_FAILED') {
                $details['event_status'] = $_POST["transferId"];
                $details['transferId'] = $_POST["transferId"];
                $details['referenceId'] = $_POST["referenceId"];
                $details['reason'] = $_POST["reason"];
                $details['signature'] = $_POST["signature"];
            } elseif ($details['event'] == 'TRANSFER_REVERSED') {
                $details['event_status'] = $_POST["transferId"];
                $details['transferId'] = $_POST["transferId"];
                $details['referenceId'] = $_POST["referenceId"];
                $details['eventTime'] = $_POST["eventTime"];
                $details['reason'] = $_POST["reason"];
                $details['signature'] = $_POST["signature"];
            }
            // elseif($details['event']=='CREDIT_CONFIRMATION'){
            //     $details['ledgerBalance']=$_POST["ledgerBalance"];
            //     $details['amount']=$_POST["amount"];
            //     $details['utr']=$_POST["utr"];
            //     $details['signature']=$_POST["signature"];
            // }
            // elseif($event=='TRANSFER_ACKNOWLEDGED'){

            // }
            // elseif($event=='BENEFICIARY_INCIDENT'){

            // }
            // elseif($details['event']=='LOW_BALANCE_ALERT'){

            // }
            if ($details['event_status'] != '') {
                $data2 = array(
                    'event_status' => $details['event_status']
                );
                if (($this->order_model->if_preapid_transfer_id($details['transferId'])) >= 1) {
                    $this->db->where("transferId",  $details['transferId']);
                    $this->db->update('cashfree_seller_payout', $data2);
                    $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
                } else if (($this->order_model->if_cod_transfer_id($details['transferId'])) >= 1) {
                    $this->db->where("transferId",  $details['transferId']);
                    $this->db->update('cod_seller_payable', $data2);
                    $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
                } else {
                    $this->response(['No Records to update.'], REST_Controller::HTTP_OK);
                }
            }
        } else {
            // Reject this call
            $this->response(['No Records to update.'], REST_Controller::HTTP_OK);
        }
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    // public function index_put($id)
    // {
    //     $input = $this->put();

    //     $new_input = array();

    //     $new_input['awb_code'] = $input['awb'];
    //     $new_input['order_status'] = $input['current_status'];


    //     $order_id = $this->order_model->get_order_id_by_awb($new_input['awb_code']);
    //     $product_array = $this->order_model->get_product_id_by_awb($new_input['awb_code']);
    //     if ($order_id) {
    //         $data = array();
    //         $data["order_status"] = $new_input['order_status'];

    //         // $data = $this->db->get_where("shiprocket_order_details", ['awb_code' => $id])->row_array();
    //         $this->db->where("order_id", $order_id);
    //         $this->db->where_in("product_id", $product_array);
    //         $this->db->update('order_products', $data);

    //         $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
    //     } else {
    //         $this->response(['No Records to update.'], REST_Controller::HTTP_OK);
    //     }
    // }

    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    // public function index_delete($id)
    // {
    //     $this->db->delete('items', array('id' => $id));

    //     $this->response(['Item deleted successfully.'], REST_Controller::HTTP_OK);
    // }



}
