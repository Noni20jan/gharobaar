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
}
