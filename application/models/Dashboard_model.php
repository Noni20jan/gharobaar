<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    //get_outstanding_payments
    public function get_outstanding_payments($user_id, $limit)
    {
        $this->db->join('orders', 'orders.id = fact_outstanding_payments.order_id');
        $this->db->select('fact_outstanding_payments.*,orders.order_number,fact_outstanding_payments.payment_status');
        $this->db->group_by('fact_outstanding_payments.id');
        $this->db->where('seller_id', clean_number($user_id));
        $this->db->where('fact_outstanding_payments.payment_status!=', 'payment_received');
        $this->db->order_by('fact_outstanding_payments.order_date', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('fact_outstanding_payments');
        return $query->result();
    }
    //get pending orders
    public function get_pending_orders($user_id, $limit)
    {
        $this->db->join('orders', 'orders.id = fact_pending_orders.order_id');
        $this->db->select('fact_pending_orders.*,orders.order_number');
        $this->db->group_by('fact_pending_orders.id');
        $this->db->where('supplier_id', clean_number($user_id));
        $this->db->where('order_status!=', 'completed');
        $this->db->order_by('fact_pending_orders.order_date', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('fact_pending_orders');
        return $query->result();
    }


    //get cleared payments
    public function get_cleared_payments($user_id, $limit)
    {
        $this->db->join('orders', 'orders.id = fact_cleared_payments.order_id');
        $this->db->select('fact_cleared_payments.*,orders.order_number,fact_cleared_payments.payment_status');
        $this->db->group_by('fact_cleared_payments.id');
        $this->db->where('seller_id', clean_number($user_id));
        $this->db->where('fact_cleared_payments.payment_status', 'payment_received');
        $this->db->order_by('fact_cleared_payments.order_date', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('fact_cleared_payments');
        return $query->result();
    }

    //get growth over last week customer
    public function get_growth_over_last_week($id)
    {
        $this->db->select("growth_rate,week");
        $this->db->where("seller_id", clean_number($id));
        $this->db->limit("2");
        $this->db->order_by("week", "DESC");
        return $this->db->get('fact_growth_over_last_week_customer')->result();
    }

    public function active_customers($seller_id)
    {
        $sql = "SELECT * from fact_active_customers 
WHERE seller_id=$seller_id AND seller_id!=buyer_id AND order_date > now() - INTERVAL 3 MONTH 
GROUP BY seller_id,buyer_id";
        $query = $this->db->query($sql);
        return $query->result();
    }
    //get growth over last week customer
    public function get_new_customers_last_week($id)
    {

        $sql = " SELECT weeks.week, IFNULL(fact_new_customers_in_last_week.customer_count,0) as customer_count
        FROM
          weeks
                LEFT OUTER JOIN
             fact_new_customers_in_last_week ON  weeks.week= fact_new_customers_in_last_week.week where seller_id is NULL OR seller_id=$id order by week desc";
        $query = $this->db->query($sql);
        return $query->result();

        // $this->db->select("customer_count,week");
        // $this->db->where("seller_id", clean_number($id));
        // $this->db->limit("7");
        // $this->db->order_by("week", "DESC");
        // return $this->db->get('fact_new_customers_in_last_week')->result();
    }

    //get no.of transactions in last week
    public function get_no_of_transaction_last_week($id)
    {
        $sql = " SELECT weeks.week, IFNULL(fact_transaction_in_last_one_week.order_id,0) as order_id
        FROM
          weeks
                LEFT OUTER JOIN
             fact_transaction_in_last_one_week ON  weeks.week= fact_transaction_in_last_one_week.week where seller_id is NULL OR seller_id=$id order by week desc";
        $query = $this->db->query($sql);
        return $query->result();
    }

    //get avg taransaction

    public function get_avg_transaction($id)
    {
        $this->db->select("avg_transaction");
        $this->db->where("seller_id", clean_number($id));
        return $this->db->get('fact_avg_transactions')->row();
    }
}
