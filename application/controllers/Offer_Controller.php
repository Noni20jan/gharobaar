<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Offer_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check user
        if (!is_admin()) {
            redirect(admin_url() . 'login');
        }
        $this->_user_session = get_user_session();
    }

    /**
     * All offers
     */
    public function offers()
    {
        $data['title'] = trans("offers");
        $data['page_url'] = admin_url() . "members";

        $pagination = $this->paginate($data['page_url'], $this->auth_model->get_users_count_by_role('member'));
        $data['users'] = $this->auth_model->get_paginated_filtered_products('member', $pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/members');
        $this->load->view('admin/includes/_footer');
    }

    // functiona for coupon category tagging 

    public function tag_cat_coupons_vouchers()
    {
        // $id = $this->input->post('id', true);
        if ($this->offer_model->tag_cat_coupons_vouchers()) {
            $this->session->set_flashdata('success', trans("category tagged"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    public function get_qualified_user_post()
    {
        $start_date = $this->input->post('quater', true);
        $end_date = $this->input->post('year', true);
        $dataGet = array(
            "users" => $this->offer_model->get_qualified_users_by_range($start_date, $end_date)
        );
        $data = array(
            "status" => 1,
            "html_content" => $this->load->view("admin/loyalty/table_qualified_user", $dataGet, true)
        );
        echo json_encode($data);
    }
}
