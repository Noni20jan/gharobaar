<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check user
        if (!is_admin()) {
            redirect(admin_url() . 'login');
        }
        if (is_admin()) {
            $this->session->unset_userdata('modesy_sess_user_location');
        }
    }

    public function index()
    {
        $data['title'] = trans("admin_panel");
        // $data['cart_items'] = $this->session_cart_items;

        $data['order_count'] = $this->order_admin_model->get_all_orders_count();
        $data['product_count'] = $this->product_admin_model->get_products_count();
        $data['pending_product_count'] = $this->product_admin_model->get_pending_products_count();
        $data['service_count'] = $this->product_admin_model->get_services_count();
        $data['pending_service_count'] = $this->product_admin_model->get_pending_services_count();
        $data['barter_count'] = $this->product_admin_model->barter_count();
        $data['pending_barter_count'] = $this->product_admin_model->get_pending_barter_count();
        $data['blog_posts_count'] = $this->blog_model->get_all_posts_count();
        $data['members_count'] = $this->auth_model->get_all_users_count();

        $data['latest_orders'] = $this->order_admin_model->get_orders_limited(15);

        $data['latest_pending_products'] = $this->product_admin_model->get_latest_pending_products(15);
        $data['latest_products'] = $this->product_admin_model->get_latest_products(15);
        $data['latest_pending_services'] = $this->product_admin_model->get_latest_pending_services(15);
        $data['latest_services'] = $this->product_admin_model->get_latest_services(15);

        $data['latest_reviews'] = $this->review_model->get_latest_reviews(15);
        $data['latest_comments'] = $this->comment_model->get_latest_comments(15);
        $data['latest_members'] = $this->auth_model->get_latest_members(6);
        $data['main_settings'] = get_main_settings();
        $data['latest_transactions'] = $this->transaction_model->get_transactions_limited(15);
        $data['latest_promoted_transactions'] = $this->transaction_model->get_promoted_transactions_limited(15);

        $data['test'] = [50, 60, 75, 80, 70, 90, 100];
        $data['test1'] = [500, 700, 650, 800, 950, 400, 300];
        $data['test2'] = [500, 700, 650, 800, 950, 200, 400];
        $data['test3'] = [500, 700, 650, 800, 950, 700, 400];
        $data['test4'] = [500, 700, 650, 800, 950, 500, 400];
        $json = '[{"name":"SUNDAY","y":60.62,"drilldown":"SUNDAY"},{"name":"MONDAY","y":62.74,"drilldown":"MONDAY"},{"name":"TUESDAY","y":10.57,"drilldown":"TUESDAY"},{"name":"WEDNESDAY","y":7.23,"drilldown":"WEDNESDAY"},{"name":"THRUSDAY","y":5.58,"drilldown":"THRUSDAY"},{"name":"FRIDAY","y":4.02,"drilldown":"FRIDAY"},{"name":"SATURDAY","y":1.92,"drilldown":"SATURDAY"}]';
        $data['test5'] = json_decode($json);
        $json = '[["Product 1",0.1],["Product 2",100.3],["Product 3",53.02],["Product 4",1.4]]';
        $data['dd1'] = json_decode($json);
        $json = '[{"name":"SUNDAY","y":70.62,"drilldown":"SUNDAY"},{"name":"MONDAY","y":52.74,"drilldown":"MONDAY"},{"name":"TUESDAY","y":90.57,"drilldown":"TUESDAY"},{"name":"WEDNESDAY","y":7.23,"drilldown":"WEDNESDAY"},{"name":"THRUSDAY","y":5.58,"drilldown":"THRUSDAY"},{"name":"FRIDAY","y":4.02,"drilldown":"FRIDAY"},{"name":"SATURDAY","y":100.00,"drilldown":"SATURDAY"}]';
        $data['test6'] = json_decode($json);
        $json = '[["Product 1",100.1],["Product 2",10.3],["Product 3",50.02],["Product 4",70.4]]';
        $data['dd2'] = json_decode($json);
        $json = '[{"name":"Deepansh","y":40,"drilldown":"Deepansh"},{"name":"Navin","y":20,"drilldown":"Navin"},{"name":"Rajesh","y":10,"drilldown":"Rajesh"},{"name":"knight","y":10,"drilldown":"knight"},{"name":"Joker","y":10,"drilldown":"Joker"},{"name":"Arrow","y":10,"drilldown":"Arrow"}]';
        $data['test7'] = json_decode($json);
        $json = '[["v65.0",0.1],["v64.0",1.3],["v63.0",53.02],["v62.0",1.4],["v61.0",0.88],["v60.0",0.56]]';
        $json = '[["v65.0",0.1],["v64.0",1.3],["v63.0",53.02],["v62.0",1.4],["v61.0",0.88],["v60.0",0.56]]';
        $json = '[["v65.0",0.1],["v64.0",1.3],["v63.0",53.02],["v62.0",1.4],["v61.0",0.88],["v60.0",0.56]]';
        $json = '[["v65.0",0.1],["v64.0",1.3],["v63.0",53.02],["v62.0",1.4],["v61.0",0.88],["v60.0",0.56]]';
        $json = '[["v65.0",0.1],["v64.0",1.3],["v63.0",53.02],["v62.0",1.4],["v61.0",0.88],["v60.0",0.56]]';
        $data['dy1'] = json_decode($json);
        $data['dy2'] = json_decode($json);
        $data['dy3'] = json_decode($json);
        $data['dy4'] = json_decode($json);
        $data['dy5'] = json_decode($json);
        $data['dy6'] = json_decode($json);
        $json = '[{"name":"Deepansh","y":30,"drilldown":"Deepansh"},{"name":"Navin","y":20,"drilldown":"Navin"},{"name":"Rajesh","y":20,"drilldown":"Rajesh"},{"name":"knight","y":10,"drilldown":"knight"},{"name":"Joker","y":10,"drilldown":"Joker"},{"name":"Arrow","y":10,"drilldown":"Arrow"}]';
        $data['test8'] = json_decode($json);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/index');
        $this->load->view('admin/includes/_footer');
    }

    /*
    * Navigation
    */
    public function navigation()
    {
        $data['title'] = trans("navigation");
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/navigation', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Navigation Post
     */
    public function navigation_post()
    {
        if ($this->settings_model->update_navigation()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    /*
    * Homepage Manager
    */
    public function homepage_manager()
    {
        $data['title'] = trans("homepage_manager");
        $data['parent_categories'] = $this->category_model->get_parent_categories();
        $data['featured_categories'] = $this->category_model->get_featured_categories();
        $data['index_categories'] = $this->category_model->get_index_categories();
        $data['index_banners'] = $this->ad_model->get_index_banners_back_end();
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/homepage_manager/homepage_manager', $data);
        $this->load->view('admin/includes/_footer');
    }

    /*
    * Homepage Manager Post
    */
    public function homepage_manager_post()
    {
        $submit = $this->input->post('submit', true);
        if ($this->input->is_ajax_request()) {
            $category_id = $this->input->post('category_id', true);
        } else {
            $category_id = get_dropdown_category_id();
        }
        if ($submit == "featured_categories") {
            $this->category_model->set_unset_featured_category($category_id);
        }
        if ($submit == "products_by_category") {
            $this->category_model->set_unset_index_category($category_id);
        }
        if (!$this->input->is_ajax_request()) {
            redirect($this->agent->referrer());
        }
    }

    /*
    * Homepage Manager Settings Post
    */
    public function homepage_manager_settings_post()
    {
        $this->settings_model->update_homepage_manager_settings();
        $this->session->set_flashdata('success', trans("msg_updated"));
        $this->session->set_flashdata('msg_settings', 1);
        redirect($this->agent->referrer() . "#form_settings");
    }

    /*
    * Add Index Banner Post
    */
    public function add_index_banner_post()
    {
        if ($this->ad_model->add_index_banner()) {
            $this->session->set_flashdata('success', trans("msg_added"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        $this->session->set_flashdata('msg_banner', 1);
        redirect($this->agent->referrer() . "#form_banners");
    }


    /*
    * Edit Index Banner
    */
    public function edit_index_banner($id)
    {
        $data['title'] = trans("edit_banner");
        //get category
        $data['banner'] = $this->ad_model->get_index_banner($id);
        if (empty($data['banner'])) {
            redirect($this->agent->referrer());
        }
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/homepage_manager/edit_banner', $data);
        $this->load->view('admin/includes/_footer');
    }


    /*
    * Edit Index Banner Post
    */
    public function edit_index_banner_post()
    {
        $id = $this->input->post('id', true);
        if ($this->ad_model->edit_index_banner($id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /*
    * Delete Index Banner Post
    */
    public function delete_index_banner_post()
    {
        $id = $this->input->post('id', true);
        $this->ad_model->delete_index_banner($id);
    }

    /*
    * Slider
    */
    public function slider()
    {
        $data['title'] = trans("slider_items");
        $data['slider_items'] = $this->slider_model->get_slider_items_all();
        $data['lang_search_column'] = 3;
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/slider/slider', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Slider Item Post
     */
    public function add_slider_item_post()
    {
        if ($this->slider_model->add_item()) {
            $this->session->set_flashdata('success_form', trans("msg_slider_added"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error_form', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Update Slider Item
     */
    public function update_slider_item($id)
    {
        $data['title'] = trans("update_slider_item");
        //get item
        $data['item'] = $this->slider_model->get_slider_item($id);

        if (empty($data['item'])) {
            redirect($this->agent->referrer());
        }
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/slider/update_slider', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update Slider Item Post
     */
    public function update_slider_item_post()
    {
        //item id
        $id = $this->input->post('id', true);
        if ($this->slider_model->update_item($id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect(admin_url() . 'slider');
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Update Slider Settings Post
     */
    public function update_slider_settings_post()
    {
        if ($this->slider_model->update_slider_settings()) {
            $this->session->set_flashdata('success_form', trans("msg_updated"));
            $this->session->set_flashdata('msg_settings', 1);
        } else {
            $this->session->set_flashdata('error_form', trans("msg_error"));
            $this->session->set_flashdata('msg_settings', 1);
        }
        redirect($this->agent->referrer());
    }

    /**
     * Delete Slider Item Post
     */
    public function delete_slider_item_post()
    {
        $id = $this->input->post('id', true);
        if ($this->slider_model->delete_slider_item($id)) {
            $this->session->set_flashdata('success', trans("msg_slider_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * BIDDING SYSTEM
    *-------------------------------------------------------------------------------------------------
    */

    /**
     * Quote Requests
     */
    public function quote_requests()
    {
        $this->load->model('bidding_model');
        $data['title'] = trans("quote_requests");
        $data['form_action'] = admin_url() . "quote-requests";
        //get paginated requests
        $pagination = $this->paginate(admin_url() . 'quote-requests', $this->bidding_model->get_admin_quote_requests_count());
        $data['quote_requests'] = $this->bidding_model->get_admin_paginated_quote_requests($pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/bidding/quote_requests', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Delete Quote Request
     */
    public function delete_quote_request_post()
    {
        $this->load->model('bidding_model');
        $id = $this->input->post('id', true);
        if ($this->bidding_model->delete_admin_quote_request($id)) {
            $this->session->set_flashdata('success', trans("msg_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }




    public function barter_requests()
    {
        $this->load->model('bidding_model');
        $data['title'] = "Barter Requests";
        $data['form_action'] = admin_url() . "barter-requests";
        //get paginated requests
        $pagination = $this->paginate(admin_url() . 'barter-requests', $this->bidding_model->get_admin_barter_requests_count());
        $data['quote_requests'] = $this->bidding_model->get_admin_paginated_barter_requests($pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/bidding/barter_requests', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Delete Quote Request
     */
    public function delete_barter_request_post()
    {
        $this->load->model('bidding_model');
        $id = $this->input->post('id', true);
        if ($this->bidding_model->delete_admin_quote_request($id)) {
            $this->session->set_flashdata('success', trans("msg_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }
    /*
    *-------------------------------------------------------------------------------------------------
    * Loyalty Program
    *-------------------------------------------------------------------------------------------------
    */

    public function loyalty_criteria()
    {
        $this->load->model("Offer_model");
        $data['title'] = trans("loyalty_criteria");
        $data['user_type'] = $this->Offer_model->get_user_type();
        $data['kpi'] = $this->Offer_model->get_kpi_name();
        $data['parent_name'] = $this->Offer_model->get_parent_name();
        $data['criteria_detail'] = $this->Offer_model->get_loyalty_criteria();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/loyalty/loyalty_criteria', $data);
        $this->load->view('admin/includes/_footer');
    }
    public function edit_loyalty_criteria($id)
    {
        $this->load->model("Offer_model");
        $data['title'] = trans("loyalty_criteria");
        $data['user_type'] = $this->Offer_model->get_user_type();
        $data['kpi'] = $this->Offer_model->get_kpi_name();
        $data['parent_name'] = $this->Offer_model->get_parent_name();
        $data['criteria_detail'] = $this->Offer_model->get_criteria_detail($id);
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/loyalty/edit_loyalty_criteria', $data);
        $this->load->view('admin/includes/_footer');
    }


    // public function view_qualification()
    // {
    //     // $this->load->model("Offer_model");
    //     $data['title'] = trans("view-qualification");
    //     $data['qualification'] = $this->offer_model->view_qualification();
    //     $this->load->view('admin/includes/_header', $data);
    //     $this->load->view('admin/loyalty/view_qualification', $data);
    //     $this->load->view('admin/includes/_footer');
    // }
    // public function editdata($id)
    // {
    //     // var_dump($id);
    //     // die();
    //     // $this->load->model('Offer_model');
    //     $data['title'] = trans("qualifying_criteria");
    //     $result['data'] = $this->offer_model->edit_qualifying_criteria_model($id);
    //     $this->load->view('admin/includes/_header', $data);
    //     $this->load->view('admin/loyalty/update_qualifying_criteria', $result);
    //     $this->load->view('admin/includes/_footer');
    // }

    // public function update_qualifying_data()
    // {
    //     $id = $this->input->post('id', true);
    //     $data['min_value'] = $this->input->post('min_value', true);
    //     $data['max_value'] = $this->input->post('max_value', true);
    //     $this->load->model('offer_model');
    //     $this->offer_model->update_qualifying_data($data, $id);
    //     $result = "true";
    //     if ($result == true) {
    //         $this->session->set_flashdata('success', trans("edit_successfully_qualified"));
    //     } else {
    //         $this->session->set_flashdata('error', trans("msg_error"));
    //     }
    //     redirect(admin_url() . "view-qualification");
    // }





    public function qualify_criteria()
    {
        $this->load->model("Offer_model");
        $data['title'] = trans("qualifying_criteria");
        $data['user_type'] = $this->Offer_model->get_user_type();
        $data['membership_type'] = $this->Offer_model->get_membership_type();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/loyalty/qualify_criteria', $data);
        $this->load->view('admin/includes/_footer');
    }


    public function loyalty_program_submit()
    {
        $this->load->model("Offer_model");
        $sl = $this->input->post('sl', true);
        $user_type = $this->input->post('user_type', true);
        $kpi_id1 = $this->input->post('kpi_name1', true);
        // $parent_hidden = $this->input->post('parent_hidden', true);
        $kpi_rel_type1 = $this->input->post('kpi_type1', true);
        $parent_id1 = $this->input->post('parent_name1', true);
        $weightage1 = $this->input->post('weightage1', true);
        $j = 0;
        for ($i = 0; $i <= $sl; $i++) {
            if ($kpi_rel_type1[$i] == "Parent" || $kpi_rel_type1[$i] == "Indvidual") {
                $parent_id2[$i] = "";
            } else {
                $parent_id2[$i] = $parent_id1[$j];
                $j++;
            }
        }
        $l = 0;
        for ($i = 0; $i <= $sl; $i++) {
            $data = array(
                'kpi_id' =>  $kpi_id1[$i],
                'kpi_rel_type' => $kpi_rel_type1[$i],
                'parent_id' => $parent_id2[$i][$l],
                'weightage' => $weightage1[$i],
                'user_type' => $user_type,
                'status' => "A",
                'created_by' => $this->auth_user->id,
            );
            $kpi_id_check['kpi_id'] = $this->Offer_model->check_kpi_id($data);
            if (isset($kpi_id_check['kpi_id'])) {
                $data['id'] = $kpi_id_check['kpi_id']->id;
                $this->Offer_model->update_loyalty_criteria($data);
                unset($data);
            } else {
                $this->Offer_model->loyalty_insert_details($data);
                unset($data);
            }
        }
        $result = "true";
        if ($result == true) {
            $this->session->set_flashdata('success', trans("loyalty_criteria_submit"));
        } else {
            $this->session->set_flashdata('error', trans("loyalty_criteria_error"));
        }
        redirect(admin_url() . "loyalty-criteria");
    }
    public function user_loyalty_program()
    {
        $this->load->model("Offer_model");
        $data['title'] = trans("user_loyalty_program");
        $data['loyalty'] = $this->Offer_model->get_loyalty_program();
        $data['get_program_data'] = $this->Offer_model->get_loyalty_data();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/loyalty/user_loyalty_program', $data);
        $this->load->view('admin/includes/_footer');
    }
    public function edit_loyalty_program($id)
    {
        $this->load->model("Offer_model");
        $data['title'] = trans("user_loyalty_program");
        $data['loyalty'] = $this->Offer_model->get_loyalty_program();
        $data['get_program_data'] = $this->Offer_model->get_user_loyalty_data($id);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/loyalty/edit_loyalty_program', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function user_loyalty_program_submit()
    {
        $this->load->model("Offer_model");
        $data['name'] = $this->input->post('name', true);
        $data['user_type'] = $this->input->post('user_type', true);
        $data['loyalty_program'] = $this->input->post('loyalty_type', true);
        $data['description'] = $this->input->post('description', true);
        $data['start_date'] = $this->input->post('start_date', true);
        $data['end_date'] = $this->input->post('end_date', true);
        $data['status'] = "A";
        $data['created_by'] = $this->auth_user->id;
        $this->Offer_model->loyalty_program_insert_details($data);
        $result = "true";
        if ($result == true) {
            $this->session->set_flashdata('success', trans("user_loyalty_program_submit"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    public function edit_loyalty_program_submit()
    {
        $id = $this->input->post('id', true);
        $this->load->model("Offer_model");
        $data['name'] = $this->input->post('name', true);
        $data['user_type'] = $this->input->post('user_type', true);
        $data['loyalty_program'] = $this->input->post('loyalty_type', true);
        $data['description'] = $this->input->post('description', true);
        $data['start_date'] = $this->input->post('start_date', true);
        $data['end_date'] = $this->input->post('end_date', true);
        $data['status'] = "A";
        $data['last_updated_by'] = $this->auth_user->id;
        $this->Offer_model->loyalty_program_update_details($data, $id);
        $result = "true";
        if ($result == true) {
            $this->session->set_flashdata('success', trans("user_loyalty_program_submit"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect(admin_url() . "user-loyalty-program");
    }
    public function kpi_form()
    {
        $this->load->model("Offer_model");
        $data['title'] = trans("kpi_form");
        $data['get_kpi_data'] = $this->Offer_model->get_kpi_data();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/loyalty/kpi_form', $data);
        $this->load->view('admin/includes/_footer');
    }
    public function edit_kpi($id)
    {
        $this->load->model("Offer_model");
        $data['title'] = trans("kpi_form");
        $data['kpi_detail'] = $this->Offer_model->get_kpi_detail($id);
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/loyalty/edit_kpi', $data);
        $this->load->view('admin/includes/_footer');
    }
    public  function kpi_form_submit()
    {
        $this->load->model("Offer_model");
        $data['name'] = $this->input->post('kpi_name', true);
        $data['description'] = $this->input->post('description', true);
        $data['type'] = $this->input->post('kpi_type', true);
        $data['formula'] = $this->input->post('formula', true);
        $data['status'] = "A";
        $data['created_by'] = $this->auth_user->id;
        $kpi_id['id'] = $this->Offer_model->get_kpi_id($data);
        if (isset($kpi_id['id'])) {
            $data['id'] = $kpi_id['id']->id;
            $this->Offer_model->kpi_update_details($data);
        } else {
            $this->Offer_model->kpi_insert_details($data);
        }
        $result = "true";
        if ($result == true) {
            $this->session->set_flashdata('success', trans("kpi_form_submit"));
        } else {
            $this->session->set_flashdata('error', trans("kpi_error"));
        }
        redirect($this->agent->referrer());
    }
    public  function edit_kpi_form_submit()
    {
        $id = $this->input->post('id', true);
        $this->load->model("Offer_model");
        $data['name'] = $this->input->post('kpi_name', true);
        $data['description'] = $this->input->post('description', true);
        $data['type'] = $this->input->post('kpi_type', true);
        $data['formula'] = $this->input->post('formula', true);
        $data['status'] = "A";
        $data['created_by'] = $this->auth_user->id;
        $kpi_id['id'] = $this->Offer_model->get_kpi_id($data);
        if (isset($kpi_id['id'])) {
            $data['id'] = $kpi_id['id']->id;
            $this->Offer_model->kpi_update_details($data);
        } else {
            $this->Offer_model->kpi_edit_details($data, $id);
        }
        $result = "true";
        if ($result == true) {
            $this->session->set_flashdata('success', trans("kpi_form_submit"));
        } else {
            $this->session->set_flashdata('error', trans("kpi_error"));
        }
        redirect(admin_url() . "kpi-form");
    }

    //qualified user listing

    public function qualified_user()
    {
        $this->load->model("Offer_model");
        $data['title'] = trans("");
        $data["users"] = $this->offer_model->get_qualified_users();
        $data["years"] = $this->offer_model->get_distinct_years();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/loyalty/qualified_user', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function qualified_user_details($lp_id)
    {
        $this->load->model("Offer_model");
        $data['title'] = trans("");
        $data["lp_user_data"] = $this->offer_model->get_qualified_users_by_id($lp_id);
        $data["lp_kpi_data"] = $this->offer_model->get_criteria_values($data["lp_user_data"]->lp_period, $data["lp_user_data"]->user_id, $data["lp_user_data"]->lp_year);
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/loyalty/qualified_user_details', $data);
        $this->load->view('admin/includes/_footer');
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * NEWSLETTER
    *-------------------------------------------------------------------------------------------------
    */

    /**
     * Send Email to Subscribers
     */
    public function send_email_subscribers()
    {
        $data['title'] = trans("send_email_subscribers");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/newsletter/send_email', $data);
        $this->load->view('admin/includes/_footer');
    }
    /**
     * Send Email to members
     */
    public function send_email_members()
    {
        $data['title'] = trans("send_email_members");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/newsletter/send_email_members', $data);
        $this->load->view('admin/includes/_footer');
    }
    /**
     * Send sms to members
     */
    public function send_sms_members()
    {
        $data['title'] = trans("send_sms_members");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/newsletter/send_sms_users', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Newsletter Send Email Post
     */
    public function send_email_subscribers_post()
    {
        $this->load->model("email_model");

        $subject = $this->input->post('subject', true);
        $message = $this->input->post('message', false);

        $data['subscribers'] = $this->newsletter_model->get_subscribers();
        $result = false;
        if (!empty($data['subscribers'])) {
            $result = true;
            foreach ($data['subscribers'] as $item) {
                //send email
                if (!$this->email_model->send_email_newsletter($item, $subject, $message)) {
                    $result = false;
                }
            }
        }

        if ($result == true) {
            $this->session->set_flashdata('success', trans("msg_email_sent"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }
    /**
     * Newsletter Send Email Members Post
     */
    public function send_email_members_post()
    {

        $this->load->model("email_model");
        $emailto = $this->input->post('emailto', true);
        $emailall = $this->input->post('emailall', true);
        $subject = $this->input->post('subject', true);
        $message = $this->input->post('message', true);
        if ($emailall == "all") {
            $data['email'] = $this->newsletter_model->get_members();
            $result = false;
            if (!empty($data['email'])) {
                $result = true;
                $emailtoall1 = array();
                foreach ($data['email'] as $emailwe) {
                    if ($emailwe->email_status == 1) {
                        array_push($emailtoall1, $emailwe->email);
                    }
                }
                //send email
                if (!$this->email_model->send_email_members_newsletter($emailall, $emailtoall1, $subject, $message)) {
                    $result = false;
                } else {
                    $result = true;
                }
            }
        }
        if (isset($emailto)) {
            $emailtoall1 = array();
            foreach ($emailto as $emailtoall) {
                array_push($emailtoall1, $emailtoall);
            }
            $emailtoc = "members";
            if (!$this->email_model->send_email_members_newsletter($emailtoc, $emailtoall1, $subject, $message)) {
                $result = false;
            } else {
                $result = true;
            }
        }
        if ($result == true) {
            $this->session->set_flashdata('success', trans("msg_email_sent"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Subscribers
     */
    public function subscribers()
    {
        $data['title'] = trans("subscribers");
        $data['subscribers'] = $this->newsletter_model->get_subscribers();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/newsletter/subscribers', $data);
        $this->load->view('admin/includes/_footer');
    }
    /**
     * Delete Subscriber Post
     */
    public function delete_subscriber_post()
    {
        $id = $this->input->post('id', true);

        $data['subscriber'] = $this->newsletter_model->get_subscriber_by_id($id);

        if (empty($data['subscriber'])) {
            redirect($this->agent->referrer());
        }

        if ($this->newsletter_model->delete_from_subscribers($id)) {
            $this->session->set_flashdata('success', trans("msg_subscriber_deleted"));
            $this->session->set_flashdata("mes_subscriber_delete", 1);
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_subscriber_delete", 1);
        }
    }


    /**
     * Contact Messages
     */
    public function contact_messages()
    {
        $data['title'] = trans("contact_messages");

        $data['messages'] = $this->contact_model->get_contact_messages();
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/contact_messages', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Delete Contact Message Post
     */
    public function delete_contact_message_post()
    {
        $id = $this->input->post('id', true);

        if ($this->contact_model->delete_contact_message($id)) {
            $this->session->set_flashdata('success', trans("msg_message_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Ads
     */
    public function ad_spaces()
    {
        $data['title'] = trans("ad_spaces");

        $data['ad_space'] = $this->input->get('ad_space', true);

        if (empty($data['ad_space'])) {
            redirect(admin_url() . "ad-spaces?ad_space=index_1");
        }

        $data['ad_codes'] = $this->ad_model->get_ad_codes($data['ad_space']);
        if (empty($data['ad_codes'])) {
            redirect(admin_url() . "ad-spaces");
        }
        $data['main_settings'] = get_main_settings();
        $data["array_ad_spaces"] = array(
            "index_1" => trans("index_ad_space_1"),
            "index_2" => trans("index_ad_space_2"),
            "products" => trans("products_ad_space"),
            "products_sidebar" => trans("products_sidebar_ad_space"),
            "product" => trans("product_ad_space"),
            "product_bottom" => trans("product_bottom_ad_space"),
            "blog_1" => trans("blog_ad_space_1"),
            "blog_2" => trans("blog_ad_space_2"),
            "blog_post_details" => trans("blog_post_details_ad_space"),
            "blog_post_details_sidebar" => trans("blog_post_details_sidebar_ad_space"),
            "profile" => trans("profile_ad_space"),
            "profile_sidebar" => trans("profile_sidebar_ad_space"),
        );

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/ad_spaces', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Ads Post
     */
    public function ad_spaces_post()
    {
        $ad_space = $this->input->post('ad_space', true);

        if ($this->ad_model->update_ad_spaces($ad_space)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Google Adsense Code Post
     */
    public function google_adsense_code_post()
    {
        if ($this->ad_model->update_google_adsense_code()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata('mes_adsense', 1);
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata('mes_adsense', 1);
        }
        redirect($this->agent->referrer());
    }

    /*
    * Seo Tools
    */
    public function seo_tools()
    {
        $data['title'] = trans("seo_tools");
        $data["current_lang_id"] = $this->input->get("lang", true);

        if (empty($data["current_lang_id"])) {
            $data["current_lang_id"] = $this->general_settings->site_lang;
            redirect(admin_url() . "seo-tools?lang=" . $data["current_lang_id"]);
        }
        $data['main_settings'] = get_main_settings();
        $data['settings'] = $this->settings_model->get_settings($data["current_lang_id"]);
        $data['languages'] = $this->language_model->get_languages();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/seo_tools', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Seo Tools Post
     */
    public function seo_tools_post()
    {
        if ($this->settings_model->update_seo_tools()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


    /*
    *-------------------------------------------------------------------------------------------------
    * CURRENCY SETTINGS
    *-------------------------------------------------------------------------------------------------
    */


    /*
    * Currency Settings
    */
    public function currency_settings()
    {
        $data['title'] = trans("currency_settings");
        $data['currencies'] = $this->currency_model->get_currencies();
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/currency/currency_settings', $data);
        $this->load->view('admin/includes/_footer');
    }

    /*
    * Currency Settings Post
    */
    public function currency_settings_post()
    {
        if ($this->currency_model->update_currency_settings()) {
            $this->session->set_flashdata('msg_settings', 1);
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('msg_settings', 1);
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /*
    * Add Currency Post
    */
    public function add_currency_post()
    {
        if ($this->currency_model->add_currency()) {
            $this->session->set_flashdata('msg_add', 1);
            $this->session->set_flashdata('success', trans("msg_added"));
        } else {
            $this->session->set_flashdata('msg_add', 1);
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }


    /**
     * Update Currency
     */
    public function update_currency($id)
    {
        $data['title'] = trans("update_currency");

        $data['currency'] = $this->currency_model->get_currency($id);

        //page not found
        if (empty($data['currency'])) {
            redirect($this->agent->referrer());
        }

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/currency/update_currency', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update Currency Post
     */
    public function update_currency_post()
    {
        $id = $this->input->post('id', true);

        if ($this->currency_model->update_currency($id)) {
            $this->session->set_flashdata('msg_table', 1);
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect(admin_url() . "currency-settings");
        } else {
            $this->session->set_flashdata('msg_table', 1);
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


    /*
    * Delete Currency Post
    */
    public function delete_currency_post()
    {
        $id = $this->input->post('id', true);
        if ($this->currency_model->delete_currency($id)) {
            $this->session->set_flashdata('msg_table', 1);
            $this->session->set_flashdata('success', trans("msg_deleted"));
        } else {
            $this->session->set_flashdata('msg_table', 1);
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }


    /*
    *-------------------------------------------------------------------------------------------------
    * EMAIL SETTINGS
    *-------------------------------------------------------------------------------------------------
    */

    /*
    * Email Settings
    */
    public function email_settings()
    {
        $data['title'] = trans("email_settings");

        $data['general_settings'] = $this->settings_model->get_general_settings();

        $data["library"] = $this->input->get('library');
        if (empty($data["library"])) {
            $data["library"] = "swift";
            if (!empty($this->general_settings->mail_library)) {
                $data["library"] = $this->general_settings->mail_library;
            }
            redirect(admin_url() . "email-settings?library=" . $data["library"]);
        }
        $data['main_settings'] = get_main_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/settings/email_settings', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Email Settings Post
     */
    public function email_settings_post()
    {
        if ($this->settings_model->update_email_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata('submit', $this->input->post('submit', true));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata('submit', $this->input->post('submit', true));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Email Verification Post
     */
    public function email_verification_post()
    {
        if ($this->settings_model->update_email_verification()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata('submit', "verification");
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata('submit', "verification");
            redirect($this->agent->referrer());
        }
    }

    /**
     * Email Options Post
     */
    public function email_options_post()
    {
        if ($this->settings_model->update_email_options()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata('submit', "options");
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata('submit', "options");
            redirect($this->agent->referrer());
        }
    }

    /**
     * Send Test Email Post
     */
    public function send_test_email_post()
    {
        $email = $this->input->post('email', true);
        $subject = "Gharobaar Test Email";
        $message = "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                    when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, 
                    but also the leap into electronic typesetting, remaining essentially unchanged.</p>";
        $this->load->model("email_model");
        $this->session->set_flashdata('submit', "send_email");
        if (!empty($email)) {
            if (!$this->email_model->send_test_email($email, $subject, $message)) {
                redirect($this->agent->referrer());
                exit();
            }
            $this->session->set_flashdata('success', trans("msg_email_sent"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * FORM SETTINGS
    *-------------------------------------------------------------------------------------------------
    */

    /*
    * Visual Settings
    */
    public function visual_settings()
    {
        $data['title'] = trans("visual_settings");
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/settings/visual_settings', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Visual Settings Post
     */
    public function visual_settings_post()
    {
        if ($this->settings_model->update_visual_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Update Watermak Category
     */
    public function update_watermark_settings_post()
    {
        $this->settings_model->update_watermark_settings();
        redirect($this->agent->referrer());
    }

    /**
     * Delete Category Watermak
     */
    public function delete_category_watermark_post()
    {
        $this->settings_model->delete_category_watermark();
        redirect($this->agent->referrer());
    }


    /*
    * System Settings
    */
    public function system_settings()
    {
        $data['title'] = trans("system_settings");

        $data['system_settings'] = $this->settings_model->get_system_settings();
        $data['currencies'] = $this->currency_model->get_currencies();
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/settings/system_settings', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * System Settings Post
     */
    public function system_settings_post()
    {
        //check product type
        $physical_products_system = $this->input->post('physical_products_system', true);
        $digital_products_system = $this->input->post('digital_products_system', true);
        if ($physical_products_system == 0 && $digital_products_system == 0) {
            $this->session->set_flashdata('error', trans("msg_error_product_type"));
            redirect($this->agent->referrer());
            exit();
        }

        $marketplace_system = $this->input->post('marketplace_system', true);
        $classified_ads_system = $this->input->post('classified_ads_system', true);
        $bidding_system = $this->input->post('bidding_system', true);
        if ($marketplace_system == 0 && $classified_ads_system == 0 && $bidding_system == 0) {
            $this->session->set_flashdata('error', trans("msg_error_selected_system"));
            redirect($this->agent->referrer());
            exit();
        }

        if ($this->settings_model->update_system_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


    /*
    * Social Login Settings
    */
    public function social_login_settings()
    {
        $data['title'] = trans("social_login");

        $data['general_settings'] = $this->settings_model->get_general_settings();
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/settings/social_login', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Facebook Login Post
     */
    public function facebook_login_post()
    {
        if ($this->settings_model->update_facebook_login()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata("mes_social_facebook", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_social_facebook", 1);
            redirect($this->agent->referrer());
        }
    }

    /**
     * Google Login Post
     */
    public function google_login_post()
    {
        if ($this->settings_model->update_google_login()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata("mes_social_google", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_social_google", 1);
            redirect($this->agent->referrer());
        }
    }

    /**
     * Google Login Post
     */
    public function social_login_vk_post()
    {
        if ($this->settings_model->update_vk_login()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata("mes_social_vk", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_social_vk", 1);
            redirect($this->agent->referrer());
        }
    }

    /**
     * Storage
     */
    public function storage()
    {
        $data['title'] = trans("storage");
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/storage', $data);
        $this->load->view('admin/includes/_footer');
    }


    public function create_offers()
    {
        $data['title'] = trans("");
        $data['main_settings'] = get_main_settings();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/create-offers', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function save_created_offers()
    {
        // $name = $this->input->post('offer_name', true);
        // $type = $this->input->post('method_type', true);
        // $method = $this->input->post('coup_vou', true);
        // $start_date =  $this->input->post('start_date', true);
        // $end_date = $this->input->post('end_date', true);
        // $discount_amt = $this->input->post('discount_amt', true);
        // $discount_percentage = $this->input->post('discount_per', true);
        // $allowed_max_discount = $this->input->post('max_discount', true);
        // $min_amt_in_cart = $this->input->post('min_discount', true);
        // $max_total_usage = $this->input->post('max_usage', true);
        if (!empty($this->input->post('t_c_c', true))) {
            $terms_conditions = $this->input->post('t_c_c', true);
        }
        if (!empty($this->input->post('t_c_v', true))) {
            $terms_conditions = $this->input->post('t_c_v', true);
        }
        if (!empty($this->input->post('coupon_code', true))) {
            $offer_code = $this->input->post('coupon_code', true);
        }
        if (!empty($this->input->post('voucher_code', true))) {
            $offer_code = $this->input->post('voucher_code', true);
        }
        $offer_ = array(
            'name' => $this->input->post('offer_name', true),
            'type' => $this->input->post('method_type', true),
            'method' => $this->input->post('coup_vou', true),
            'start_date' =>  $this->input->post('start_date', true),
            'end_date' => $this->input->post('end_date', true),
            'discount_amt' => $this->input->post('discount_amt', true),
            'discount_percentage' => $this->input->post('discount_per', true),
            'allowed_max_discount' => $this->input->post('allowed_max_discount', true),
            'min_amt_in_cart' => $this->input->post('min_discount', true),
            'max_usage_per_user' => $this->input->post('max_usage_per_user', true),
            'offer_code' => $offer_code,
            'msg_to_be_displayed' => $this->input->post('msg_displayed', true),
            'no_off_voucher_req' => $this->input->post('vouchers_required', true),
            'terms_and_conditions' => $terms_conditions,
            'max_total_usage' => $this->input->post('max_usage', true),
            'description' => $this->input->post('description', true),
        );

        if ($this->product_admin_model->coupons_vouchers($offer_)) {
            $this->session->set_flashdata('success', trans("offer_created"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Storage Post
     */
    public function storage_post()
    {
        if ($this->settings_model->update_storage_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * AWS S3 Post
     */
    public function aws_s3_post()
    {
        if ($this->settings_model->update_aws_s3()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata('mes_s3', 1);
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Cache System
     */
    public function cache_system()
    {
        $data['title'] = trans("cache_system");
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/cache_system', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Cache System Post
     */
    public function cache_system_post()
    {
        if ($this->input->post('action', true) == "reset") {
            reset_cache_data();
            $this->session->set_flashdata('success', trans("msg_reset_cache"));
        } else {
            if ($this->settings_model->update_cache_system()) {
                $this->session->set_flashdata('success', trans("msg_updated"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        }
        redirect($this->agent->referrer());
    }

    /**
     * Preferences
     */
    public function preferences()
    {
        $data['title'] = trans("preferences");
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/preferences', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Preferences Post
     */
    public function preferences_post()
    {
        $form = $this->input->post('submit', true);
        $this->session->set_flashdata('mes_' . $form, 1);
        if ($this->settings_model->update_preferences($form)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            //reset cache
            redirect(admin_url() . "preferences");
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


    /*
     * Settings
     */
    public function settings()
    {
        $data['title'] = trans("settings");

        $data["settings_lang"] = $this->input->get("lang", true);
        if (empty($data["settings_lang"])) {
            $data["settings_lang"] = $this->selected_lang->id;
            redirect(admin_url() . "settings?lang=" . $data["settings_lang"]);
        }

        $data['settings'] = $this->settings_model->get_settings($data["settings_lang"]);
        $data['general_settings'] = $this->settings_model->get_general_settings();
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/settings/settings', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Settings Post
     */
    public function settings_post()
    {
        if ($this->settings_model->update_settings()) {
            $this->settings_model->update_general_settings();
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata("mes_settings", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_settings", 1);
            redirect($this->agent->referrer());
        }
    }


    /**
     * Recaptcha Settings Post
     */
    public function recaptcha_settings_post()
    {
        if ($this->settings_model->update_recaptcha_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata("mes_recaptcha", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_recaptcha", 1);
            redirect($this->agent->referrer());
        }
    }

    /**
     * Maintenance Mode Post
     */
    public function maintenance_mode_post()
    {
        if ($this->settings_model->update_maintenance_mode_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            $this->session->set_flashdata("mes_maintenance", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            $this->session->set_flashdata("mes_maintenance", 1);
            redirect($this->agent->referrer());
        }
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * LOCATION
    *-------------------------------------------------------------------------------------------------
    */

    /**
     * Countries
     */
    public function countries()
    {
        $data['title'] = trans("countries");
        //get paginated products
        $pagination = $this->paginate(admin_url() . 'countries', $this->location_model->get_paginated_countries_count());
        $data['countries'] = $this->location_model->get_paginated_countries($pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/countries', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add Country
     */
    public function add_country()
    {
        $data['title'] = trans("add_country");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/add_country', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add Country Post
     */
    public function add_country_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            if ($this->location_model->add_country()) {
                $this->session->set_flashdata('success', trans("msg_added"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Update Country
     */
    public function update_country($id)
    {
        $data['title'] = trans("update_country");

        //get country
        $data['country'] = $this->location_model->get_country($id);
        if (empty($data['country'])) {
            redirect($this->agent->referrer());
        }

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/update_country', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update Country Post
     */
    public function update_country_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            //country id
            $id = $this->input->post('id', true);
            if ($this->location_model->update_country($id)) {
                $this->session->set_flashdata('success', trans("msg_updated"));
                redirect(admin_url() . 'countries');
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Delete Country Post
     */
    public function delete_country_post()
    {
        $id = $this->input->post('id', true);
        if ($this->location_model->delete_country($id)) {
            $this->session->set_flashdata('success', trans("msg_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }


    /**
     * States
     */
    public function states()
    {
        $data['title'] = trans("states");
        $data['countries'] = $this->location_model->get_countries();
        //get paginated states
        $pagination = $this->paginate(admin_url() . 'states', $this->location_model->get_paginated_states_count());
        $data['states'] = $this->location_model->get_paginated_states($pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/states', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add State
     */
    public function add_state()
    {
        $data['title'] = trans("add_state");
        $data['countries'] = $this->location_model->get_countries();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/add_state', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add State Post
     */
    public function add_state_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            if ($this->location_model->add_state()) {
                $this->session->set_flashdata('success', trans("msg_added"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Update State
     */
    public function update_state($id)
    {
        $data['title'] = trans("update_state");

        //get state
        $data['state'] = $this->location_model->get_state($id);
        if (empty($data['state'])) {
            redirect($this->agent->referrer());
        }
        $data['countries'] = $this->location_model->get_countries();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/update_state', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update State Post
     */
    public function update_state_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            //country id
            $id = $this->input->post('id', true);
            if ($this->location_model->update_state($id)) {
                $this->session->set_flashdata('success', trans("msg_updated"));
                $redirect_url = $this->input->post('redirect_url', true);
                if (!empty($redirect_url)) {
                    redirect($redirect_url);
                } else {
                    redirect(admin_url() . 'states');
                }
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Delete State Post
     */
    public function delete_state_post()
    {
        $id = $this->input->post('id', true);
        if ($this->location_model->delete_state($id)) {
            $this->session->set_flashdata('success', trans("msg_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Cities
     */
    public function cities()
    {
        $data['title'] = trans("cities");
        $data['countries'] = $this->location_model->get_countries();
        $data['states'] = $this->location_model->get_states();
        $data['main_settings'] = get_main_settings();
        //get paginated cities
        $pagination = $this->paginate(admin_url() . 'cities', $this->location_model->get_paginated_cities_count());
        $data['cities'] = $this->location_model->get_paginated_cities($pagination['per_page'], $pagination['offset']);
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/cities', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add Cities
     */
    public function add_city()
    {
        $data['title'] = trans("add_city");
        $data['countries'] = $this->location_model->get_countries();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/add_city', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Add City Post
     */
    public function add_city_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            if ($this->location_model->add_city()) {
                $this->session->set_flashdata('success', trans("msg_added"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Update City
     */
    public function update_city($id)
    {
        $data['title'] = trans("update_city");

        //get city
        $data['city'] = $this->location_model->get_city($id);
        if (empty($data['city'])) {
            redirect($this->agent->referrer());
        }
        $data['countries'] = $this->location_model->get_countries();
        $data['states'] = $this->location_model->get_states_by_country($data['city']->country_id);
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/location/update_city', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Update City Post
     */
    public function update_city_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            //country id
            $id = $this->input->post('id', true);
            if ($this->location_model->update_city($id)) {
                $this->session->set_flashdata('success', trans("msg_updated"));
                $redirect_url = $this->input->post('redirect_url', true);
                if (!empty($redirect_url)) {
                    redirect($redirect_url);
                } else {
                    redirect(admin_url() . 'cities');
                }
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }



    /**
     * Delete City Post
     */
    public function delete_city_post()
    {
        $id = $this->input->post('id', true);
        if ($this->location_model->delete_city($id)) {
            $this->session->set_flashdata('success', trans("msg_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    //get states by country
    public function get_states_by_country()
    {
        $country_id = $this->input->post('country_id', true);
        $states = $this->location_model->get_states_by_country($country_id);

        if (!empty($states)) {
            echo "<option value=''>" . trans('all') . "</option>";
            foreach ($states as $state) {
                echo "<option value='" . $state->id . "'>" . html_escape($state->name) . "</option>";
            }
        }
    }

    //activate inactivate countries
    public function activate_inactivate_countries()
    {
        $action = $this->input->post('action', true);
        $this->location_model->activate_inactivate_countries($action);
    }

    /**
     * Add Remove Featured Sellers
     */
    public function add_remove_featured_sellers()
    {
        $user_id = $this->input->post('user_id', true);
        if ($this->order_admin_model->add_remove_promoted_sellers($user_id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            // redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            // redirect($this->agent->referrer());
        }
    }

    public function sales()
    {
        $data['title'] = trans("sale_data");
        $data['sale'] = $this->reports_model->fetch_sale_data();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/reports/sale_data', $data);
        $this->load->view('admin/includes/_footer');
    }
    public function sale_data_cancellation()
    {
        $data['title'] = trans("sale_data_cancellation");
        $data['sale'] = $this->reports_model->fetch_sale_data_cancellation();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/reports/sale_data_cancellation', $data);
        $this->load->view('admin/includes/_footer');
    }



    public function seller_commission()
    {
        $data['title'] = trans("seller_commission");
        $data['sale'] = $this->reports_model->fetch_seller_commission();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/reports/seller_commision_data', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function seller_commission_cod()
    {
        $data['title'] = trans("seller_commission_data_cod");
        $data['sale'] = $this->reports_model->fetch_seller_commission_cod();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/reports/seller_commisson_for_cod', $data);
        $this->load->view('admin/includes/_footer');
    }


    public function seller_profile_data()
    {
        $data['title'] = trans("seller_profile_data");
        $data['sale'] = $this->reports_model->fetch_profile_data();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/reports/seller_profile_data', $data);
        $this->load->view('admin/includes/_footer');
    }



    public function shipping_cod_charges()
    {
        $data['title'] = trans("shipping_cod_charges");
        $data['sale'] = $this->reports_model->fetch_shipping_cod_charges();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/reports/shipping_cod_charges', $data);
        $this->load->view('admin/includes/_footer');
    }
    public function tcs_report()
    {
        $data['title'] = trans("tcs_report");
        $data['sale'] = $this->reports_model->fetch_tcs_report();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/reports/tcs_report', $data);
        $this->load->view('admin/includes/_footer');
    }
    public function tds_report()
    {
        $data['title'] = trans("tds_report");
        $data['sale'] = $this->reports_model->fetch_tds_report();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/reports/tds_report', $data);
        $this->load->view('admin/includes/_footer');
    }
    public function cash_free_charges_report()
    {
        $data['title'] = trans("cash_free_charges_reports");
        $data['sale'] = $this->reports_model->fetch_cash_free_charges_report();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/reports/cash_free_charges_report', $data);
        $this->load->view('admin/includes/_footer');
    }
    public function cod_charges_report()
    {
        $data['title'] = trans("cod_charges_report");
        $data['sale'] = $this->reports_model->fetch_cod_charges_report();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/reports/cod_charges_report', $data);
        $this->load->view('admin/includes/_footer');
    }
    public function product_listing()
    {
        $data['title'] = trans("product_listing");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/reports/product_listing', $data);
        $this->load->view('admin/includes/_footer');
    }
    public function cart_data_report()
    {
        $data['title'] = trans("cart_data");
        $data['sale'] = $this->reports_model->fetch_cart_data_report();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/reports/cart_data', $data);
        $this->load->view('admin/includes/_footer');
    }



    public function format_sale_data()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);

        $format_sale_data = $this->reports_model->format_sale_data($from_date, $to_date);
        echo json_encode($format_sale_data);
    }




    public function format_seller_profile_data()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);

        $format_selle_profile_data = $this->reports_model->seller_profile_data($from_date, $to_date);
        echo json_encode($format_selle_profile_data);
    }
    public function format_shipping_cod_charges()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);

        $format_cod_charge = $this->reports_model->format_shipping_cod_charges($from_date, $to_date);
        echo json_encode($format_cod_charge);
    }
    public function format_tds()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);

        $format_tds_report = $this->reports_model->tds_report($from_date, $to_date);
        echo json_encode($format_tds_report);
    }
    public function format_seller_commision()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);

        $format_sller_commision = $this->reports_model->seller_commision_data($from_date, $to_date);
        echo json_encode($format_sller_commision);
    }
    public function format_seller_commision_cod()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);

        $format_sller_commision = $this->reports_model->format_seller_commision_data_cod($from_date, $to_date);
        echo json_encode($format_sller_commision);
    }
    public function format_tcs_report()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);

        $format_tcs = $this->reports_model->format_tcs_report($from_date, $to_date);
        echo json_encode($format_tcs);
    }
    public function cash_free_charges()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);

        $cash_free = $this->reports_model->cash_free_charges($from_date, $to_date);
        echo json_encode($cash_free);
    }
    public function format_cod_charges_report()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);

        $cash_free = $this->reports_model->format_cod_charges_report($from_date, $to_date);
        echo json_encode($cash_free);
    }
    public function format_product_listing()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);

        $product_listing = $this->reports_model->format_product_listing($from_date, $to_date);
        echo json_encode($product_listing);
    }
    public function cart_report()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);

        $cart_report = $this->reports_model->format_cart_report($from_date, $to_date);
        echo json_encode($cart_report);
    }
    public function format_sale_data_cancellation()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);
        $format_sale_data = $this->reports_model->format_sale_data_cancellation($from_date, $to_date);
        echo json_encode($format_sale_data);
    }

    public function promotion()
    {
        $data['title'] = trans("promotion_notification");
        $data['state'] = $this->auth_model->get_state_name();

        $data['vendors'] = $this->profile_model->get_vendor_details();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/page/promotions', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function send_promotion_notification()
    {

        $this->load->model("email_model");
        $emailall = $this->input->post('emailall', true);
        $title = $this->input->post('subject', true);
        $message = $this->input->post('message', true);
        $states = $this->input->post('state', true);
        // var_dump($states);
        // var_dump($emailall);
        // var_dump($states);
        // die();
        $vendors = $this->profile_model->get_vendor_details();
        if ($emailall == "all") {
            $data['email'] = $this->newsletter_model->get_members();
            $result = false;
            if (!empty($data['email'])) :
                $result = true;
                foreach ($data['email'] as $email) :
                    echo $email->email;

                    $var = array(


                        'title' =>  $title,
                        'subject' => $title,
                        'source_id' => "",
                        'source' => "",
                        'source' => "",
                        'remark' => "",
                        'to' => $email->email,
                        'message' => $message,
                        'for_user' => $email->email,
                        'event_type' => 'Promotions',


                    );
                    // var_dump($var);
                    // die();

                    if (!$func = $this->email_model->notification($var)) {
                        $result = false;
                    } else {
                        $result = true;
                    }

                endforeach;
            endif;
        } elseif ($emailall == "seller") {
            foreach ($vendors as $vendor) :
                echo $vendor->email;

                $var = array(


                    'title' =>  $title,
                    'message' => $message,
                    'source_id' => "",
                    'subject' => $title,
                    'source' => "",
                    'source' => "",
                    'remark' => "",
                    'to' => $vendor->email,
                    'for_user' => $vendor->email,
                    'event_type' => 'Promotions',
                );
                // var_dump($var);
                // die();

                if (!$func = $this->email_model->notification($var)) {
                    $result = false;
                } else {
                    $result = true;
                }
            endforeach;
        } elseif ($emailall == "individual") {

            foreach ($states as $state1) :
                // var_dump($state1);
                // die();
                $state_email = $this->profile_model->get_state_user_details($state1);
                foreach ($state_email as $state2) :
                echo $state2->email;
                // var_dump($state2->email);
                // die();

                $var = array(


                    'title' =>  $title,
                    'message' => $message,
                    'source_id' => "",
                    'source' => "",
                    'source' => "",
                    'remark' => "",
                    'to' => $state2->email,
                    'remark' => $message,
                    'for_user' => $state2->email,
                    'event_type' => 'Promotions',

                );
                // var_dump($var);
                // die();
                if (!$func = $this->email_model->notification($var)) {
                    $result = false;
                } else {
                    $result = true;
                }
            endforeach;
            endforeach;
        }





        if ($result == true) {
            $this->session->set_flashdata('success', trans("msg_email_sent"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }
}
