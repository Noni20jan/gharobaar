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
    public function get_coupon_consumption()
    {
        $sql = "SELECT
        `c`.`email`,
            `d`.`name`,
            `d`.`method`,
            `d`.`offer_code`,
            `d`.`creation_date`,
            `a`.`total_discount`
        FROM
            `offer_redemptions` `a`
                JOIN
            `orders` `b` ON `b`.`id` = `a`.`order_id`
                JOIN
            `users` `c` ON `c`.`id` = `b`.`buyer_id`
                JOIN
            `cms_offers` `d` ON `d`.`id` = `a`.`offer_id`";
        $query = $this->db->query($sql);
        return $query->result();
    }
    // tag category to coupon/voucher
    public function tag_cat_coupons_vouchers()
    {
        $data = array(
            'offer_id' => 2,
            'source_type' => "category",
            // 'source_id' => 1,
            'source_id' => trim($this->input->post('category_id', true)),
        );

        return $this->db->insert('offer_selection_details', $data);
    }
}
