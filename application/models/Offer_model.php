<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Offer_model extends CI_Model
{
    //get values
    public function get_all_offers()
    {
        $query = $this->db->get('cms_offers');
        return $query->result();
    }

    public function get_all_coupons()
    {
        $this->db->where('method', 'coupons');
        $query = $this->db->get('cms_offers');
        return $query->result();
    }

    public function get_all_vouchers()
    {
        $this->db->where('method', 'vouchers');
        $query = $this->db->get('cms_offers');
        return $query->result();
    }
    public function get_coupon_details($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('cms_offers');
        return $query->row();
    }
    public function edit_coupons_vouchers($id, $data)
    {

        $this->db->where('id', clean_number($id));
        return $this->db->update('cms_offers', $data);
    }
}
