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
}
