<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

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
}
