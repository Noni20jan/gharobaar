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
            'offer_id' => $this->input->post('offer_id', true),
            'source_type' => $this->input->post('source_type', true),
            // 'source_id' => 1,
            'source_id' => trim($this->input->post('category_id', true)),
        );

        $data['source_id'] = get_dropdown_category_id();
        return $this->db->insert('offer_selection_details', $data);
    }
    public function loyalty_insert_details($data)
    {
        return $this->db->insert('criteria', $data);
    }
    public function get_parent_detail($data)
    {
        $this->db->where('parent_type', $data);
        $query = $this->db->get('criteria');
        return $query->result();
    }
    public function get_loyalty_program()
    {
        $this->db->where('lookup_type', 'lookup_program');
        $query = $this->db->get('lookup_values');
        return $query->result();
    }
    public function loyalty_program_insert_details($data)
    {
        return $this->db->insert('user_loyalty_programs', $data);
    }
    public function get_user_type()
    {
        $this->db->where('lookup_type', "USER_TYPE");
        $query = $this->db->get('lookup_values');
        return $query->result();
    }
    public function show_data()
    {
        $sql = "SELECT *
        FROM cms_offers INNER JOIN offer_selection_details
        WHERE offer_selection_details.offer_id = cms_offers.id && offer_selection_details.source_id!='NULL'";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function delete_data($id)
    {
        $sql = "Delete from offer_selection_details where id=$id";
        $query = $this->db->query($sql);
    }
    public function get_coupon_by_code($coupon_code)
    {
        $this->db->where('offer_code', $coupon_code);
        $query = $this->db->get('cms_offers');
        return $query->row();
    }

    public function get_all_available_coupons()
    {
        $sql = "SELECT * FROM cms_offers WHERE (end_date > now() or 
                end_date is NULL)
                and start_date <= now()
                and status = 1";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function kpi_insert_details($data)
    {
        return $this->db->insert('kpi', $data);
    }
    public function get_kpi_name()
    {
        $query = $this->db->get('kpi');
        return $query->result();
    }
    public function get_coupon_details_by_code($coupon_code)
    {
        $this->db->select('cms_offers.offer_code,offer_selection_details.*');
        $this->db->join('offer_selection_details', 'cms_offers.id = offer_selection_details.offer_id');
        $this->db->where('offer_code', $coupon_code);
        $query = $this->db->get('cms_offers');
        return $query->result();
    }
    public function get_total_usage_by_id($id)
    {

        $this->db->where('offer_id', $id);
        $query = $this->db->get('offer_redemptions');
        return $query->num_rows();
    }
    public function get_data_users($role,$offer_id,$per_page, $offset)
    {

        $sql = "SELECT  id,slug,banned,email_status, username, email, last_seen, created_at
from users   
where username != 'admin'  and email_status=1  and id NOT IN(
SELECT source_id 
from offer_selection_details,
cms_offers
where   offer_selection_details.offer_id=$offer_id and offer_selection_details.offer_id = cms_offers.id
and source_type='User')
order by created_at desc";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function get_data($id)
    {

        $this->db->where('offer_id', $id);
        $query = $this->db->get('offer_selection_details');
        var_dump($query->num_rows);
        return $query->num_rows();
    }
}