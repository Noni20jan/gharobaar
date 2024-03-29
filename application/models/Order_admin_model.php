<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
 * ORDER STATUS
 *
 * 1. awaiting_payment
 * 2. payment_received
 * 3. order_processing
 * 4. shipped
 * 5. completed
 * 6. cancelled
 */

class Order_admin_model extends CI_Model
{
    //update order payment as received
    public function update_order_payment_received($order_id)
    {
        $order_id = clean_number($order_id);
        $order = $this->get_order($order_id);
        if (!empty($order)) {
            //update product payment status
            $data_order = array(
                'payment_status' => "payment_received",
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $this->db->where('id', $order_id);
            $this->db->update('orders', $data_order);

            //update order products payment status
            $order_products = $this->get_order_products($order_id);
            if (!empty($order_products)) {
                foreach ($order_products as $order_product) {
                    $data = array(
                        'order_status' => "payment_received",
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                    if ($order_product->product_type == 'digital') {
                        $data['order_status'] = 'completed';
                        //add digital sale
                        $this->order_model->add_digital_sale($order_product->product_id, $order_id);
                        //add seller earnings
                        $this->earnings_model->add_seller_earnings($order_product);
                    } else {
                        $data['order_status'] = 'completed';
                        //add seller earnings
                        $this->earnings_model->add_seller_earnings($order_product);
                    }
                    $this->db->where('id', $order_product->id);
                    $this->db->update('order_products', $data);
                }
            }
        }
    }

    //update order product status
    public function update_order_product_status($order_product_id)
    {
        $order_product_id = clean_number($order_product_id);
        $order_product = $this->get_order_product($order_product_id);
        if (!empty($order_product)) {
            $data = array(
                'order_status' => $this->input->post('order_status', true),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            if ($data["order_status"] == "completed" || $data["order_status"] == "cancelled") {
                $data['is_approved'] = 1;
            } else {
                $data['is_approved'] = 0;
            }

            $this->db->where('id', $order_product_id);
            return $this->db->update('order_products', $data);
        }
        return false;
    }

    //update order product status
    public function update_order_supplier_status($order_id, $seller_id)
    {
        $order_id = clean_number($order_id);
        $status = "";
        $order_products = $this->order_model->get_order_products_of_seller($order_id, $seller_id);
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
            $data['updated_at'] = date('Y-m-d H:i:s');
        }

        $this->db->where('order_id', $order_id);
        $this->db->where('seller_id', $seller_id);
        $this->db->update('order_supplier', $data);
    }
    //check order products status / update if all suborders completed
    public function update_order_status_if_completed($order_id)
    {
        $order_id = clean_number($order_id);
        $all_complated = true;
        $order_products = $this->get_order_products($order_id);
        if (!empty($order_products)) {
            foreach ($order_products as $order_product) {
                if ($order_product->order_status != "completed" && $order_product->order_status != "cancelled") {
                    $all_complated = false;
                }
            }
            $data = array(
                'status' => 0,
                'updated_at' => date('Y-m-d H:i:s'),
            );
            if ($all_complated == true) {
                $data["status"] = 1;
            }
            $this->db->where('id', $order_id);
            $this->db->update('orders', $data);
        }
    }

    //check order payment status / update if all payments received
    public function update_payment_status_if_all_received($order_id)
    {
        $order_id = clean_number($order_id);
        $all_received = true;
        $order_products = $this->get_order_products($order_id);
        if (!empty($order_products)) {
            foreach ($order_products as $order_product) {
                if ($order_product->order_status == "awaiting_payment" || $order_product->order_status == "cancelled") {
                    $all_received = false;
                }
            }
            $data = array(
                'payment_status' => 'awaiting_payment',
                'updated_at' => date('Y-m-d H:i:s'),
            );
            if ($all_received == true) {
                $data["payment_status"] = 'payment_received';
            }
            $this->db->where('id', $order_id);
            $this->db->update('orders', $data);
        }
    }

    //approve guest order product
    public function approve_guest_order_product($order_product_id)
    {
        $order_product_id = clean_number($order_product_id);
        $order_product = $this->get_order_product($order_product_id);
        if (!empty($order_product)) {
            $data = array(
                'is_approved' => 1,
                'order_status' => "completed",
                'updated_at' => date('Y-m-d H:i:s')
            );
            $this->db->where('id', $order_product_id);
            return $this->db->update('order_products', $data);
        }
        return false;
    }

    //delete order product
    public function delete_order_product($order_product_id)
    {
        $order_product_id = clean_number($order_product_id);
        $order_product = $this->get_order_product($order_product_id);
        if (!empty($order_product)) {
            $this->db->where('id', $order_product_id);
            return $this->db->delete('order_products');
        }
        return false;
    }



    //filter by values
    public function filter_orders()
    {
        $data = array(
            'status' => $this->input->get('status', true),
            'payment_status' => $this->input->get('payment_status', true),
            'dropdown_search' => $this->input->get('dropdown_search', true),
            'q' => $this->input->get('q', true),
            'payment_method' =>  $this->input->get('payment_method', true)
        );

        if (!empty($data['status'])) {
            if ($data['status'] == 'completed') {
                $this->db->where('orders.status', 1);
            } elseif ($data['status'] == 'processing') {
                $this->db->where('orders.status', 0);
            }
        }
        $data['q'] = trim($data['q']);

        if (!empty($data['dropdown_search'] && !empty($data['q']))) {
            if ($data["dropdown_search"] == "order_date") {
                $this->db->like('orders.created_at', $data['q'], 'after');
            }
        }
        if (!empty($data['dropdown_search'] && !empty($data['q']))) {
            if ($data["dropdown_search"] == "OrderId") {

                $this->db->like('orders.order_number', $data['q'], 'after');
            }
        }
        if (!empty($data['dropdown_search'] && !empty($data['q']))) {
            if ($data["dropdown_search"] == "Status") {
                if ($data['q'] == 'completed') {
                    $this->db->where('orders.status', 1);
                } elseif ($data['q'] == 'processing') {
                    $this->db->where('orders.status', 0);
                }
            }
        }
        if (!empty($data['dropdown_search'] && !empty($data['q']))) {
            if ($data["dropdown_search"] == "Payment Method") {
                $this->db->like('orders.payment_method', $data['q'], 'after');
            }
        }
        if (!empty($data['dropdown_search'])) {
            if ($data["dropdown_search"] == "Total Value") {
                $this->db->where('orders.price_total', intval($data['q'] * 100));
            }
        }
        if (!empty($data['dropdown_search'] && !empty($data['q']))) {
            if ($data["dropdown_search"] == "BuyerType") {

                $this->db->like('concat_ws(order_shipping.shipping_first_name,"",order_shipping.shipping_last_name)', ($data['q']));
            }
        }

        if (!empty($data['payment_status'])) {
            $this->db->where('orders.payment_status', $data['payment_status']);
        }
        if (!empty($data['payment_method'])) {
            $this->db->where('orders.payment_method', $data['payment_method']);
        }
    }

    //get orders count
    public function get_orders_count()
    {
        $this->filter_orders();
        $this->db->select('orders.created_at,orders.id,orders.order_number,orders.buyer_id,orders.price_total,orders.price_currency,orders.payment_method,orders.price_currency,orders.updated_at,orders.payment_status,CONCAT(order_shipping.shipping_first_name," ",order_shipping.shipping_last_name) as name,orders.status');
        $this->db->join('order_shipping', 'order_shipping.order_id=orders.id');
        $query = $this->db->get('orders');
        return $query->num_rows();
    }

    //get all orders count
    public function get_all_orders_count()
    {
        $query = $this->db->get('orders');
        return $query->num_rows();
    }

    //get orders limited
    public function get_orders_limited($limit)
    {
        $limit = clean_number($limit);
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('orders');
        return $query->result();
    }

    //get paginated orders
    public function get_paginated_orders($per_page, $offset)
    {
        $this->filter_orders();
        $this->db->select('orders.created_at,orders.id,orders.order_number,orders.buyer_id,orders.price_total,orders.price_currency,orders.payment_method,orders.price_currency,orders.updated_at,orders.payment_status,order_shipping.shipping_first_name,order_shipping.shipping_last_name,CONCAT(order_shipping.shipping_first_name," ", order_shipping.shipping_last_name) as name,orders.status');
        $this->db->join('order_shipping', 'order_shipping.order_id=orders.id');
        $this->db->order_by('orders.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('orders');
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
    public function get_order_products_expandable($order_id)
    {
        $order_id = clean_number($order_id);
        $this->db->where('order_id', $order_id);
        $this->db->join('users', 'order_products.seller_id = users.id');
        $query = $this->db->get('order_products');
        // var_dump($this->db->last_query());
        // die();
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
        $order_number = clean_number($order_number);
        $this->db->where('order_number', $order_number);
        $query = $this->db->get('orders');
        return $query->row();
    }

    //get order product
    public function get_order_product($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('order_products');
        return $query->row();
    }

    //delete order
    public function delete_order($id)
    {
        $id = clean_number($id);
        $order = $this->get_order($id);
        if (!empty($order)) {
            //delete order products
            $order_products = $this->get_order_products($id);
            if (!empty($order_products)) {
                foreach ($order_products as $order_product) {
                    $this->db->where('id', $order_product->id);
                    $this->db->delete('order_products');
                }
            }
            //delete order
            $this->db->where('id', $id);
            return $this->db->delete('orders');
        }
        return false;
    }

    //get digital sale
    public function get_digital_sale($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('digital_sales');
        return $query->row();
    }

    //get digital sales
    public function get_digital_sales($per_page, $offset)
    {
        $q = remove_special_characters(trim($this->input->get('q', true)));
        if (!empty($q)) {
            $this->db->where('purchase_code', $q);
        }

        $this->db->order_by('purchase_date', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('digital_sales');
        return $query->result();
    }

    //get digital sales count
    public function get_digital_sales_count()
    {
        $query = $this->db->get('digital_sales');
        return $query->num_rows();
    }

    //delete digital sale
    public function delete_digital_sale($id)
    {
        $id = clean_number($id);
        $sale = $this->get_digital_sale($id);
        if (!empty($sale)) {
            $this->db->where('id', $id);
            return $this->db->delete('digital_sales');
        }
        return false;
    }

    //filter bank transfers
    public function filter_bank_transfers()
    {
        $data = array(
            'status' => $this->input->get('status', true),
            'q' => $this->input->get('q', true)
        );
        if (!empty($data['status'])) {
            $this->db->where('status', $data['status']);
        }
        $q = trim($data['q']);
        if (!empty($q)) {
            $q = urldecode($q);
            $q = str_replace("#", "", $q);
            $this->db->where('order_number', $q);
        }
    }

    //get bank transfer notifications
    public function get_bank_transfers_count()
    {
        $this->filter_bank_transfers();
        $query = $this->db->get('bank_transfers');
        return $query->num_rows();
    }

    //get paginated bank transfer notifications
    public function get_paginated_bank_transfers($per_page, $offset)
    {
        $this->filter_bank_transfers();
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('bank_transfers');
        return $query->result();
    }

    //get bank transfer
    public function get_bank_transfer($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('bank_transfers');
        return $query->row();
    }

    //get bank transfer by order number
    public function get_bank_transfer_by_order_number($order_number)
    {
        $order_number = clean_number($order_number);
        $this->db->order_by('created_at', 'DESC');
        $this->db->where('order_number', $order_number);
        $query = $this->db->get('bank_transfers');
        return $query->row();
    }

    //update bank transfer status
    public function update_bank_transfer_status($id, $option)
    {
        $id = clean_number($id);
        $transfer = $this->get_bank_transfer($id);
        if (!empty($transfer)) {
            $data = array(
                'status' => $option
            );
            $this->db->where('id', $id);
            return $this->db->update('bank_transfers', $data);
        }
        return false;
    }

    //delete bank transfer
    public function delete_bank_transfer($id)
    {
        $id = clean_number($id);
        $transfer = $this->get_bank_transfer($id);
        if (!empty($transfer)) {
            delete_file_from_server($transfer->receipt_path);
            $this->db->where('id', $id);
            return $this->db->delete('bank_transfers');
        }
        return false;
    }

    //filter by values
    public function filter_invoices()
    {
        $order_number = $this->input->get('order_number', true);
        if (!empty($order_number)) {
            $this->db->like('order_number', $order_number);
        }
    }

    //get invoices count
    public function get_invoices_count()
    {
        $this->filter_invoices();
        $query = $this->db->get('invoices');
        return $query->num_rows();
    }

    //get paginated invoices
    public function get_paginated_invoices($per_page, $offset)
    {
        $this->filter_invoices();
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('invoices');
        return $query->result();
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * SALES STATICS
    *-------------------------------------------------------------------------------------------------
    */

    //get active sales count by seller
    public function get_active_sales_count_by_seller($seller_id)
    {
        $this->db->select('orders.id');
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->where('order_products.seller_id', clean_number($seller_id))->where('order_status != ', 'completed');
        $this->db->distinct();
        return $this->db->count_all_results('orders');
    }

    //get completed sales count by seller
    public function get_completed_sales_count_by_seller($seller_id)
    {
        $this->db->select('orders.id');
        $this->db->join('order_products', 'order_products.order_id = orders.id');
        $this->db->where('order_products.seller_id', clean_number($seller_id))->where('order_status', 'completed');
        $this->db->distinct();
        return $this->db->count_all_results('orders');
    }
    // get sales of current financial year
    public function get_sales_financial_year($seller_id)
    {
        // function get_finacial_year_range() {
        $year = date('Y');
        $month = date('m');
        if ($month < 4) {
            $year = $year - 1;
        }
        $start_date = date('Y-m-d H:i:s', strtotime(($year) . '-04-01 00:00:00'));
        $end_date = date('Y-m-d H:i:s', strtotime(($year + 1) . '-03-31 00:00:00'));
        // var_dump($start_date);
        // var_dump($end_date);
        // $response = array('start_date' => $start_date, 'end_date' => $end_date);
        $sql = "SELECT SUM(product_total_price) AS total_amount FROM order_products WHERE seller_id = ? AND (created_at<='$end_date' and created_at>= '$start_date')";
        $query = $this->db->query($sql, array(clean_number($seller_id)));
        // var_dump($this->db->last_query());
        return $query->result();
        // }
    }
    //get sales sum by month
    public function get_sales_sum_by_month($seller_id)
    {
        $sql = "SELECT SUM(product_total_price) AS total_amount, MONTH(created_at) AS month FROM order_products WHERE seller_id = ? AND YEAR(created_at) = YEAR(CURDATE()) GROUP BY MONTH(created_at)";
        $query = $this->db->query($sql, array(clean_number($seller_id)));
        return $query->result();
    }

    public function get_order_product_by_id($id)
    {
        $this->db->where('order_id', clean_number($id));
        return $this->db->get('order_products')->row();
    }

    public function get_user_by_id($id)
    {
        $this->db->where('id', clean_number($id));
        return $this->db->get('users')->row();
    }

    //add remove promoted products
    public function add_remove_promoted_sellers($id)
    {
        $user = $this->get_user_by_id($id);
        // var_dump($user);
        if (!empty($user)) {
            if ($user->is_promoted == '1') {
                $data = array(
                    'is_promoted' => 0
                );
            } else {
                $data = array(
                    'is_promoted' => 1
                );
            }
            $this->db->where('id', $user->id);
            $result = $this->db->update('users', $data);

            return $result;
        }
        return false;
    }
}
