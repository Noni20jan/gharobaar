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
}
