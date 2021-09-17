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



    public function voucher_dashboard()
    {
        $data['title'] = trans("vouchers_dashboard");
        $data['main_settings'] = get_main_settings();

        $data['offers'] = $this->offer_model->get_all_vouchers();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/offers/vouchers_dashboard');
        $this->load->view('admin/includes/_footer');
    }



    public function edit_offer_details($id)
    {
        // $this->load->model("Offer_model");
        $data['title'] = trans("order");

        $data['offer'] = $this->offer_model->get_coupon_details($id);
        //$offers_data = $this->offer_model->get_coupon_details($id);
        // if (empty($data['order'])) {
        //     redirect(admin_url() . "orders");
        // }
        // var_dump($offers_data);
        // die();
        // $data['order_products'] = $this->order_admin_model->get_order_products($id);
        // $data["session"] = get_user_session();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/edit_coupon_details', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function edit_voucher_details($id)
    {
        // $this->load->model("Offer_model");
        $data['title'] = trans("order");

        $data['offer'] = $this->offer_model->get_coupon_details($id);
        //$offers_data = $this->offer_model->get_coupon_details($id);
        // if (empty($data['order'])) {
        //     redirect(admin_url() . "orders");
        // }
        // var_dump($offers_data);
        // die();
        // $data['order_products'] = $this->order_admin_model->get_order_products($id);
        // $data["session"] = get_user_session();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/edit_voucher_details', $data);
        $this->load->view('admin/includes/_footer');
    }




    public function edit_details_coupon()
    {
        $this->load->model("Offer_model");
        $id = $this->input->post('id', true);
        $data['name'] = $this->input->post('offer_name', true);
        $data['type'] = $this->input->post('method_type', true);
        $data['method'] = $this->input->post('coup_vou', true);
        $data['start_date'] =  $this->input->post('start_date', true);
        $data['end_date'] = $this->input->post('end_date', true);
        $data['discount_amt'] = $this->input->post('discount_amt', true);
        $data['discount_percentage'] = $this->input->post('discount_per', true);
        $data['allowed_max_discount'] = $this->input->post('max_discount', true);
        $data['min_amt_in_cart'] = $this->input->post('min_discount', true);
        $data['offer_code'] = $this->input->post('coupon_code', true);
        $data['msg_to_be_displayed'] = $this->input->post('msg_displayed', true);
        $data['no_off_voucher_req'] = $this->input->post('vouchers_required', true);
        $data['terms_and_conditions'] = $this->input->post('t_&_c', true);
        $data['max_total_usage'] = $this->input->post('max_usage', true);
        if (empty($data["name"])) {
            $data["name"] = "";
        }
        if (empty($data["type"])) {
            $data["type"] = "";
        }
        if (empty($data["method"])) {
            $data["method"] = "";
        }
        if (empty($data["start_date"])) {
            $data["start_date"] = "";
        }
        if (empty($data["end_date"])) {
            $data["end_date"] = "";
        }
        if (empty($data["discount_amt"])) {
            $data["discount_amt"] = "";
        }
        if (empty($data["discount_percentage"])) {
            $data["discount_percentage"] = "";
        }
        if (empty($data["allowed_max_discount"])) {
            $data["allowed_max_discount"] = "";
        }
        if (empty($data["min_amt_in_cart"])) {
            $data["min_amt_in_cart"] = "";
        }
        if (empty($data["offer_code"])) {
            $data["offer_code"] = "";
        }
        if (empty($data["msg_to_be_displayed"])) {
            $data["msg_to_be_displayed"] = "";
        }
        if (empty($data["no_off_voucher_req"])) {
            $data["no_off_voucher_req"] = "";
        }
        if (empty($data["terms_and_conditions"])) {
            $data["terms_and_conditions"] = "";
        }
        if (empty($data["max_total_usage"])) {
            $data["max_total_usage"] = "";
        }


        $this->Offer_model->edit_coupons_vouchers($id, $data);
    }
}
