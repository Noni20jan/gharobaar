<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check user
        if (!is_admin()) {
            redirect(admin_url() . 'login');
        }
    }

    /**
     * Products
     */
    public function products()
    {
        $data['title'] = trans("products");
        $data['form_action'] = admin_url() . "products";
        $data['list_type'] = "products";
        //get paginated products
        $pagination = $this->paginate(admin_url() . 'products', $this->product_admin_model->get_paginated_products_count('products'));
        $data['products'] = $this->product_admin_model->get_paginated_products($pagination['per_page'], $pagination['offset'], 'products');

        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/products', $data);
        $this->load->view('admin/includes/_footer');
    }
    public function approve_products()
    {
        $data['title'] = trans("products");
        $data['form_action'] = admin_url() . "products";
        $data['list_type'] = "products";
        //get paginated products
        $pagination = $this->paginate(admin_url() . 'approve_products', $this->product_admin_model->get_paginated_products_count('products'));
        $data['products'] = $this->product_admin_model->get_paginated_product($pagination['per_page'], $pagination['offset'], 'products');
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/approve_product', $data);
        $this->load->view('admin/includes/_footer');
    }
    public function listed_products()
    {
        $data['title'] = trans("products");
        $data['form_action'] = admin_url() . "listed_products";
        $data['list_type'] = "products";
        //get paginated products
        // $feature_id = $this;


        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/listed_products', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function tagged_products()
    {
        $product_ids = $this->input->post('product_id');

        $user_data = array();
        $group_feature_id = $this->input->post('grp_feature_id');
        $feature_id = $this->input->post('feature_id');
        for ($i = 0; $i < count($product_ids); $i++) {

            $data = array(
                'grp_feature_id' =>   $group_feature_id,
                'feature_id' => $feature_id,
                'product_id' => $product_ids[$i],
                'is_active' => 1

            );
            array_push($user_data, $data);
        }
        $this->db->insert_batch('product_banner_tagging', $user_data);
    }
    public function products_tagging()
    {
        // $data['title'] = trans("users");
        $data['title'] = trans("products");
        $data['form_action'] = admin_url() . "approve_products";
        $data['list_type'] = "products";
        //get paginated products
        $pagination = $this->paginate(admin_url() . 'products', $this->product_admin_model->get_paginated_products_count('products'));
        $data['products'] = $this->product_admin_model->get_paginated_product_tagging('products');


        echo json_encode($data["products"]);
    }
    public function delete_tagging_product()
    {
        $feature_id = $this->input->post('feature_id');
        $product_id = $this->input->post('product_id');

        echo json_encode($this->product_admin_model->delete_tagged_product($feature_id, $product_id));
    }
    public function services()
    {
        $data['title'] = "Services";
        $data['form_action'] = admin_url() . "services";
        $data['list_type'] = "products";
        //get paginated products
        $pagination = $this->paginate(admin_url() . 'services', $this->product_admin_model->get_paginated_services_count('products'));
        $data['products'] = $this->product_admin_model->get_paginated_services($pagination['per_page'], $pagination['offset'], 'products');
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/service/services', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Pending Products
     */
    public function pending_products()
    {
        $data['title'] = trans("pending_products");
        $data['form_action'] = admin_url() . "pending-products";
        $data['list_type'] = "pending_products";
        //get paginated pending products
        $pagination = $this->paginate(admin_url() . 'pending-products', $this->product_admin_model->get_paginated_pending_products_count('pending_products'));
        $data['products'] = $this->product_admin_model->get_paginated_pending_products($pagination['per_page'], $pagination['offset'], 'pending_products');
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/pending_products', $data);
        $this->load->view('admin/includes/_footer');
    }
    public function pending_services()
    {
        $data['title'] = "Pending Services";
        $data['form_action'] = admin_url() . "pending-services";
        $data['list_type'] = "pending_products";
        //get paginated pending products
        $pagination = $this->paginate(admin_url() . 'pending-products', $this->product_admin_model->get_paginated_pending_services_count('pending_products'));
        $data['products'] = $this->product_admin_model->get_paginated_pending_services($pagination['per_page'], $pagination['offset'], 'pending_products');
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/service/pending_services', $data);
        $this->load->view('admin/includes/_footer');
    }
    public function products_tagged()
    {
        // $data['title'] = trans("users");
        $data['title'] = trans("products");
        $data['form_action'] = admin_url() . "listed_products";
        $data['list_type'] = "products";
        $feature_id = $this->input->post('feature_id');
        //get paginated products
        $pagination = $this->paginate(admin_url() . 'listed_products', $this->product_admin_model->get_paginated_products_count('products', $feature_id));
        $data['products'] = $this->product_admin_model->get_paginated_list_product($pagination['per_page'], $pagination['offset'], $feature_id, 'products');
        // echo $data['products'];

        echo json_encode($data["products"]);
    }
    /**
     * Hidden Products
     */
    public function hidden_products()
    {
        $data['title'] = trans("hidden_products");
        $data['form_action'] = admin_url() . "hidden-products";
        $data['list_type'] = "hidden_products";
        //get paginated products
        $pagination = $this->paginate(admin_url() . 'hidden-products', $this->product_admin_model->get_paginated_hidden_products_count('hidden_products'));
        $data['products'] = $this->product_admin_model->get_paginated_hidden_products($pagination['per_page'], $pagination['offset'], 'hidden_products');
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/products', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Hidden Services
     */
    public function hidden_services()
    {
        $data['title'] = "Hidden Services";
        $data['form_action'] = admin_url() . "hidden-services";
        $data['list_type'] = "hidden_products";
        //get paginated products
        $pagination = $this->paginate(admin_url() . 'hidden-services', $this->product_admin_model->get_paginated_hidden_products_count('hidden_products'));
        $data['products'] = $this->product_admin_model->get_paginated_hidden_products($pagination['per_page'], $pagination['offset'], 'hidden_products');
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/service/services', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Expired Products
     */
    public function expired_products()
    {
        $data['title'] = trans("expired_products");
        $data['form_action'] = admin_url() . "expired-products";
        $data['list_type'] = "expired_products";
        //get paginated products
        $pagination = $this->paginate(admin_url() . 'expired-products', $this->product_admin_model->get_paginated_expired_products_count('expired_products'));
        $data['products'] = $this->product_admin_model->get_paginated_expired_products($pagination['per_page'], $pagination['offset'], 'expired_products');
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/products', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Draft
     */
    public function drafts()
    {
        $data['title'] = trans("drafts");
        $data['form_action'] = admin_url() . "drafts";
        $data['list_type'] = "drafts";
        //get paginated drafts
        $pagination = $this->paginate(admin_url() . 'drafts', $this->product_admin_model->get_paginated_drafts_count('drafts'));
        $data['products'] = $this->product_admin_model->get_paginated_drafts($pagination['per_page'], $pagination['offset'], 'drafts');
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/drafts', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Draft
     */
    public function drafts_service()
    {
        $data['title'] = trans("drafts");
        $data['form_action'] = admin_url() . "drafts_service";
        $data['list_type'] = "drafts";
        //get paginated drafts
        $pagination = $this->paginate(admin_url() . 'drafts_service', $this->product_admin_model->get_paginated_drafts_service_count('drafts'));
        $data['products'] = $this->product_admin_model->get_paginated_drafts_service($pagination['per_page'], $pagination['offset'], 'drafts');
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/service/drafts_service', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Deleted Products
     */
    public function deleted_products()
    {
        $data['title'] = trans("deleted_products");
        $data['form_action'] = admin_url() . "deleted-products";
        $data['list_type'] = "deleted_products";
        //get paginated products
        $pagination = $this->paginate(admin_url() . 'deleted-products', $this->product_admin_model->get_paginated_deleted_products_count('deleted_products'));
        $data['products'] = $this->product_admin_model->get_paginated_deleted_products($pagination['per_page'], $pagination['offset'], 'deleted_products');
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/deleted_products', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Deleted Products
     */
    public function deleted_services()
    {
        $data['title'] = "Deleted Service";
        $data['form_action'] = admin_url() . "deleted-services";
        $data['list_type'] = "deleted_products";
        //get paginated products
        $pagination = $this->paginate(admin_url() . 'deleted-services', $this->product_admin_model->get_paginated_deleted_services_count('deleted_products'));
        $data['products'] = $this->product_admin_model->get_paginated_deleted_services($pagination['per_page'], $pagination['offset'], 'deleted_products');
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/service/deleted_services', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Featured Products
     */
    public function featured_products()
    {
        $data['title'] = trans("featured_products");
        $data['form_action'] = admin_url() . "featured-products";
        $data['list_type'] = "featured_products";
        //get paginated featured products
        $pagination = $this->paginate(admin_url() . 'featured-products', $this->product_admin_model->get_paginated_promoted_products_count('promoted_products'));
        $data['products'] = $this->product_admin_model->get_paginated_promoted_products($pagination['per_page'], $pagination['offset'], 'promoted_products');
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/featured/featured_products', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Featured Products
     */
    public function featured_services()
    {
        $data['title'] = "Featured Services";
        $data['form_action'] = admin_url() . "featured-services";
        $data['list_type'] = "featured_products";
        //get paginated featured products
        $pagination = $this->paginate(admin_url() . 'featured-services', $this->product_admin_model->get_paginated_promoted_services_count('promoted_products'));
        $data['products'] = $this->product_admin_model->get_paginated_promoted_services($pagination['per_page'], $pagination['offset'], 'promoted_products');
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/featured/featured_services', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Featured Products Pricing
     */
    public function featured_products_pricing()
    {
        $data['title'] = trans("pricing");
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/featured/pricing', $data);
        $this->load->view('admin/includes/_footer');
    }
    /**
     * Featured Services Pricing
     */
    public function featured_services_pricing()
    {
        $data['title'] = trans("pricing");
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/featured/pricing_service', $data);
        $this->load->view('admin/includes/_footer');
    }


    /**
     * Featured Products Pricing Post
     */
    public function featured_products_pricing_post()
    {
        if ($this->settings_model->update_pricing_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Featured Products Transactions
     */
    public function featured_products_transactions()
    {
        $data['title'] = trans("featured_products_transactions");
        $data['form_action'] = admin_url() . "featured-products-transactions";

        $pagination = $this->paginate(admin_url() . 'featured-products-transactions', $this->promote_model->get_promoted_transactions_count(null));
        $data['transactions'] = $this->promote_model->get_paginated_promoted_transactions(null, $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/featured/transactions', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Featured Services Transactions
     */
    public function featured_services_transactions()
    {
        $data['title'] = "Featured Service Transcations";
        $data['form_action'] = admin_url() . "featured-services-transactions";

        $pagination = $this->paginate(admin_url() . 'featured-services-transactions', $this->promote_model->get_promoted_transactions_count(null));
        $data['transactions'] = $this->promote_model->get_paginated_promoted_transactions(null, $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/featured/transactions_service', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Delete Featured Transaction Post
     */
    public function delete_featured_transaction_post()
    {
        $id = $this->input->post('id', true);
        if ($this->transaction_model->delete_promoted_transaction($id)) {
            $this->session->set_flashdata('success', trans("msg_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Special Offers
     */
    public function special_offers()
    {
        $data['title'] = trans("special_offers");
        $data['form_action'] = admin_url() . "special-offers";
        $data['list_type'] = "special_offers";
        //get paginated special offers
        $pagination = $this->paginate($data['form_action'], $this->product_admin_model->get_paginated_promoted_products_count('special_offers'));
        $data['products'] = $this->product_admin_model->get_paginated_promoted_products($pagination['per_page'], $pagination['offset'], 'special_offers');
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/products', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Product Details
     */
    public function product_details($id)
    {
        $data['title'] = trans("product_details");
        $data['product'] = $this->product_admin_model->get_product($id);
        if (



            empty($data['product'])
        ) {
            redirect($this->agent->referrer());
        }
        $data['product_details'] = $this->product_model->get_product_details($data["product"]->id, $this->selected_lang->id, true);
        $data['review_count'] = $this->review_model->get_review_count($data["product"]->id);
        $data['main_settings'] = get_main_settings();
        $data["product_variations"] = $this->variation_model->get_product_variations($data["product"]->id);
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/product_details', $data);
        $this->load->view('admin/includes/_footer');
    }

    public function get_wrapper()
    {
        echo "hello";
        // $product_id = $this->input->post('product_id', true);
        // $product = $this->product_model->get_product_by_id($product_id);

        // // var_dump($product);
        // // die();
        // if (!empty($product)) {

        //     // $data = array(
        //     //     'status' => 1,
        //     //     'product' => $product

        //     // );
        //     var_dump ($product);
        //     die();
        // }
    }

    public function service_details($id)
    {
        $data['title'] = "Service Details";
        $data['product'] = $this->product_admin_model->get_product($id);
        if (empty($data['product'])) {
            redirect($this->agent->referrer());
        }
        $data['product_details'] = $this->product_model->get_service_details($data["product"]->id, $this->selected_lang->id, true);
        $data['review_count'] = $this->review_model->get_review_count($data["product"]->id);
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/service/service_details', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Approve Product
     */
    public function approve_product()
    {
        $id = $this->input->post('id', true);
        if ($this->product_admin_model->approve_product($id)) {
            $this->session->set_flashdata('success', trans("msg_product_approved"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();

        $redirect_url = $this->input->post('redirect_url', true);
        if (!empty($redirect_url)) {
            redirect($redirect_url);
        }
    }
    public function revert_back()
    {


        $id = $this->input->post('id1', true);
        $message = $this->input->post('messagere', true);

        $email = $this->input->post('email', true);
        $user = get_user($id);



        $this->load->model("email_model");
        $this->session->set_flashdata('submit', "send_email");

        if (!empty($email)) {
            if (!$this->email_model->revert_back_product($email, $user->first_name, $message)) {
                redirect($this->agent->referrer());
                // exit();
            }
            $this->session->set_flashdata('success', trans("msg_email_sent"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }


        redirect($this->agent->referrer());
    }
    /**
     * Approve Service
     */
    public function approve_service()
    {
        $id = $this->input->post('id', true);
        if ($this->product_admin_model->approve_product($id)) {
            $this->session->set_flashdata('success', "Service Successfully Approved");
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();

        $redirect_url = $this->input->post('redirect_url', true);
        if (!empty($redirect_url)) {
            redirect($redirect_url);
        }
    }

    /**
     * Restore Product
     */
    public function restore_product()
    {
        $id = $this->input->post('id', true);
        if ($this->product_admin_model->restore_product($id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        //reset cache
        reset_cache_data_on_change();
    }
    public function restore_service()
    {
        $id = $this->input->post('id', true);
        if ($this->product_admin_model->restore_product($id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        //reset cache
        reset_cache_data_on_change();
    }

    /**
     * Delete Product
     */
    public function delete_product()
    {
        $id = $this->input->post('id', true);
        if ($this->product_admin_model->delete_product($id)) {
            $this->session->set_flashdata('success', trans("msg_product_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();
    }

    public function delete_service()
    {
        $id = $this->input->post('id', true);
        if ($this->product_admin_model->delete_product($id)) {
            $this->session->set_flashdata('success', "Service Deleted Successfully");
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();
    }


    /**
     * Delete Product Permanently
     */
    public function delete_service_permanently()
    {
        $id = $this->input->post('id', true);
        if ($this->product_admin_model->delete_product_permanently($id)) {
            $this->session->set_flashdata('success', trans("msg_product_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();
    }

    /**
     * Delete Selected Products
     */
    public function delete_selected_products()
    {
        $product_ids = $this->input->post('product_ids', true);
        $this->product_admin_model->delete_multi_products($product_ids);

        //reset cache
        reset_cache_data_on_change();
    }

    /**
     * Delete Selected Products Permanently
     */
    public function delete_selected_products_permanently()
    {
        $product_ids = $this->input->post('product_ids', true);
        $this->product_admin_model->delete_multi_products_permanently($product_ids);

        //reset cache
        reset_cache_data_on_change();
    }

    /**
     * Add Remove Featured Products
     */
    public function add_remove_featured_products()
    {
        $product_id = $this->input->post('product_id', true);
        $transaction_id = $this->input->post('transaction_id', true);
        $day_count = $this->input->post('day_count', true);
        $is_ajax = $this->input->post('is_ajax', true);
        if ($this->product_admin_model->add_remove_promoted_products($product_id, $day_count)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();

        if ($is_ajax == 0) {
            redirect($this->agent->referrer());
        }
    }


    /**
     * Add Remove Featured Services
     */
    public function add_remove_featured_services()
    {
        $product_id = $this->input->post('product_id', true);
        $transaction_id = $this->input->post('transaction_id', true);
        $day_count = $this->input->post('day_count', true);
        $is_ajax = $this->input->post('is_ajax', true);
        if ($this->product_admin_model->add_remove_promoted_products($product_id, $day_count)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();

        if ($is_ajax == 0) {
            redirect($this->agent->referrer());
        }
    }

    /**
     * Add Remove Special Offers
     */
    public function add_remove_special_offers()
    {
        $product_id = $this->input->post('product_id', true);
        if ($this->product_admin_model->add_remove_special_offers($product_id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Comments
     */
    public function comments()
    {
        $data['title'] = trans("approved_comments");
        $data['comments'] = $this->comment_model->get_approved_comments();
        $data['top_button_text'] = trans("pending_comments");
        $data['top_button_url'] = admin_url() . "pending-product-comments";
        $data['show_approve_button'] = false;
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/comment/comments', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Pending Comments
     */
    public function pending_comments()
    {
        $data['title'] = trans("pending_comments");
        $data['comments'] = $this->comment_model->get_pending_comments();
        $data['top_button_text'] = trans("approved_comments");
        $data['top_button_url'] = admin_url() . "product-comments";
        $data['show_approve_button'] = true;
        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/comment/comments', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Aprrove Comment Post
     */
    public function approve_comment_post()
    {
        $id = $this->input->post('id', true);
        if ($this->comment_model->approve_comment($id)) {
            $this->session->set_flashdata('success', trans("msg_comment_approved"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Approve Selected Comments
     */
    public function approve_selected_comments()
    {
        $comment_ids = $this->input->post('comment_ids', true);
        $this->comment_model->approve_multi_comments($comment_ids);
    }


    /**
     * Delete Comment
     */
    public function delete_comment()
    {
        $id = $this->input->post('id', true);
        if ($this->comment_model->delete_comment($id)) {
            $this->session->set_flashdata('success', trans("msg_comment_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Delete Selected Comments
     */
    public function delete_selected_comments()
    {
        $comment_ids = $this->input->post('comment_ids', true);
        $this->comment_model->delete_multi_comments($comment_ids);
    }

    /**
     * Reviews
     */
    public function reviews()
    {
        $data['title'] = trans("reviews");
        $data['reviews'] = $this->review_model->get_all_reviews();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/review/reviews', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Delete Review
     */
    public function delete_review()
    {
        $id = $this->input->post('id', true);
        if ($this->review_model->delete_review($id)) {
            $this->session->set_flashdata('success', trans("msg_review_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Delete Selected Reviews
     */
    public function delete_selected_reviews()
    {
        $review_ids = $this->input->post('review_ids', true);
        $this->review_model->delete_multi_reviews($review_ids);
    }
}
