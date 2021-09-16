<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coupon_controller extends Admin_Core_Controller
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
        $data['page_url'] = admin_url() . "offers-dashboard";

        $data['offers'] = $this->offer_model->get_all_offers();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/offers/dashboard');
        $this->load->view('admin/includes/_footer');
    }

    public function coupon_dashboard()
    {
        $data['title'] = trans("coupons_dashboard");
        $data['main_settings'] = get_main_settings();

        $data['offers'] = $this->offer_model->get_all_coupons();
        
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/offers/coupons_dashboard');
        $this->load->view('admin/includes/_footer');
    }
}
