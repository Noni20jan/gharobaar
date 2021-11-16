<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lookup_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_lookup_values_by_type($lookup_type)
    {
        $this->db->where('lookup_type', $lookup_type);
        $query = $this->db->get("lookup_values");
        return $query->result();
    }

    public function get_lookup_values_by_code($lookup_code)
    {
        $this->db->where('lookup_code', $lookup_code);
        $query = $this->db->get("lookup_values");
        return $query->row();
    }

    public function get_lookup_values_by_type_name($lookup_type)
    {
        //     $this->db->where('lookup_type', $lookup_type);
        //     $query = $this->db->get('lookup_values');
        //     $id = $query->row()->lookup_type;

        $this->db->where('lookup_type', $lookup_type);
        $query = $this->db->get("lookup_values");
        return $query->result();
    }

    public function get_list_lookup_value_predefined($lookup_type)
    {
        $this->db->where('lookup_type', $lookup_type);
        if ($lookup_type == "SHOP_BY_OCCASSION") :
            $this->db->where('lookup_int_val', 1001);
        endif;
        $query = $this->db->get("lookup_values");
        return $query->result();
    }
    public function get_lookup_order_return()
    {
        $this->db->select('lookup_code');
        $this->db->where('lookup_type', 'ORDER_RETURN_STATUS');
        $query = $this->db->get('lookup_values');
        return $query->row();
    }

    public function get_lookup_image_url($lookup_code)
    {
        //     $this->db->where('lookup_type', $lookup_type);
        //     $query = $this->db->get('lookup_values');
        //     $id = $query->row()->lookup_type;

        $this->db->where('lookup_value_code', $lookup_code);
        $query = $this->db->get("images_function");
        return $query->row();
    }
}
