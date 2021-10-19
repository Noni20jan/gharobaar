<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Membership_controller extends Admin_Core_Controller
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
     * Members
     */
    public function members()
    {
        $data['title'] = trans("members");
        $data['page_url'] = admin_url() . "members";

        $pagination = $this->paginate($data['page_url'], $this->auth_model->get_users_count_by_role('member'));
        $data['users'] = $this->auth_model->get_paginated_filtered_products('member', $pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/members');
        $this->load->view('admin/includes/_footer');
    }
    public function edit_details_form($id)
    {

        $data['users'] = $this->product_admin_model->update_bank_details($id);


        $this->load->view('admin/includes/_header');
        $this->load->view('admin/membership/bank_details_form');
        $this->load->view('admin/includes/_footer');
    }
    // }
    // public function update_bank_info()
    // {
    //     //check user
    //     if (!$this->auth_check) {
    //         // redirect(admin_url());
    //     }

    //     $user_id = $this->auth_user->id;
    //     $action = $this->input->post('submit', true);


    //     // if ($action == "resend_activation_email") {
    //     //     //send activation email
    //     //     $this->load->model("email_model");
    //     //     $this->email_model->send_email_activation($user_id);
    //     //     $this->session->set_flashdata('success', trans("msg_send_confirmation_email"));
    //     //     redirect($this->agent->referrer());
    //     // }

    //     //validate inputs
    //     // $this->form_validation->set_rules('username', trans("username"), 'required|xss_clean|max_length[255]');


    //     $ass = $this->input->post('assistance', true);
    //     $data = array(
    //         'acc_holder_name' => $this->input->post('holder_name', true),
    //         'update_profile' => '1',
    //         'ifsc_code' => $this->input->post('ifsc_code', true),
    //         'bank_branch' => $this->input->post('bank_branch', true),
    //         'account_number' => $this->input->post('account_number', true),
    //         'brand_desc' => $this->input->post('brand_desc', true),
    //         'assistance' => implode(',', $ass),
    //         'brand_name' => $this->input->post('brand_name', true),
    //         'supplier_speciality' => $this->input->post('supplier_speciality', true),
    //         'customer_name' => $this->input->post('customer_name', true),
    //         'source' => $this->input->post('source', true),
    //         'different_type_products' => $this->input->post('different_type_products', true),
    //         'testimonial' => $this->input->post('testimonial', true),
    //         // 'about_me' => $this->input->post('about_me', true),
    //         // 'supplier_story_url' => $this->input->post('story_vedio_url', true),

    //     );


    //     if ($action == "update") {

    //         if ($this->profile_model->update_story($data, $user_id)) {
    //             $this->session->set_flashdata('success', trans("msg_updated"));
    //             //check email changed

    //             redirect(admin_url());
    //         } else {
    //             $this->session->set_flashdata('error', trans("msg_error"));
    //             // redirect($this->agent->referrer());
    //         }
    //     } else if ($action == "save_and_next_details") {
    //         if ($this->profile_model->update_story($data, $user_id)) {
    //             $this->session->set_flashdata('success', trans("msg_updated"));
    //             //check email changed

    //             // redirect(generate_dash_url("add_product"));
    //         } else {
    //             $this->session->set_flashdata('error', trans("msg_error"));
    //             // redirect($this->agent->referrer());
    //         }
    //     }
    // }
    /**
     * Vendors
     */
    public function vendors()
    {
        $data['title'] = trans("vendors");
        $data['page_url'] = admin_url() . "vendors";

        $pagination = $this->paginate($data['page_url'], $this->auth_model->get_users_count_by_role('vendor'));
        $data['users'] = $this->auth_model->get_paginated_filtered_products('vendor', $pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/vendors');
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Featured Vendors
     */
    public function featured_vendors()
    {
        $data['title'] = "Featured Vendors";
        $data['page_url'] = admin_url() . "featured_vendors";

        $pagination = $this->paginate($data['page_url'], $this->auth_model->get_featured_users_count_by_role('vendor'));
        $data['featured_users'] = $this->auth_model->get_paginated_featured_users('vendor', $pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/featured_sellers');
        $this->load->view('admin/includes/_footer');
    }
    public function update_profile_requests()
    {
        $data['title'] = "Update Profile Requests";
        $data['page_url'] = admin_url() . "update-profile-requests";

        $pagination = $this->paginate($data['page_url'], $this->auth_model->get_users_profile_count_by_role('vendor'));
        $data['users'] = $this->auth_model->get_paginated_profile_filtered_products('vendor', $pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/update_profile_requests');
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Administrators
     */
    public function administrators()
    {
        $data['title'] = trans("administrators");
        $data['page_url'] = admin_url() . "administrators";

        $pagination = $this->paginate($data['page_url'], $this->auth_model->get_users_count_by_role('admin'));
        $data['users'] = $this->auth_model->get_paginated_filtered_products('admin', $pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/administrators');
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Administrator
     */
    public function add_administrator()
    {
        $data['title'] = trans("add_administrator");

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/add_administrator');
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Administrator
     */
    public function add_administrator_post()
    {
        //validate inputs
        $this->form_validation->set_rules('username', trans("username"), 'required|xss_clean|min_length[4]|max_length[100]');
        $this->form_validation->set_rules('email', trans("email_address"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('password', trans("password"), 'required|xss_clean|min_length[4]|max_length[50]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            redirect($this->agent->referrer());
        } else {
            $email = $this->input->post('email', true);
            $username = $this->input->post('username', true);
            //is username unique
            if (!$this->auth_model->is_unique_username($username)) {
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("msg_username_unique_error"));
                redirect($this->agent->referrer());
            }
            //is email unique
            if (!$this->auth_model->is_unique_email($email)) {
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("msg_email_unique_error"));
                redirect($this->agent->referrer());
            }

            //add user
            if ($this->auth_model->add_administrator()) {
                $this->session->set_flashdata('success', trans("msg_administrator_added"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }

            redirect($this->agent->referrer());
        }
    }

    /**
     * Edit User
     */
    public function edit_user($id)
    {
        $data['title'] = trans("edit_user");
        $data['user'] = $this->auth_model->get_user($id);
        if (empty($data['user'])) {
            redirect(admin_url() . "members");
        }
        $data["countries"] = $this->location_model->get_countries();
        $data["states"] = $this->location_model->get_states_by_country($data['user']->country_id);
        $data["cities"] = $this->location_model->get_cities_by_state($data['user']->state_id);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/edit_user');
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Edit User Post
     */
    public function edit_user_post()
    {
        //validate inputs
        $this->form_validation->set_rules('username', trans("username"), 'required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email', trans("email"), 'required|xss_clean');
        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {
            $data = array(
                'id' => $this->input->post('id', true),
                'username' => $this->input->post('username', true),
                'slug' => $this->input->post('slug', true),
                'email' => $this->input->post('email', true)
            );
            //is email unique
            if (!$this->auth_model->is_unique_email($data["email"], $data["id"])) {
                $this->session->set_flashdata('error', trans("msg_email_unique_error"));
                redirect($this->agent->referrer());
                exit();
            }
            //is username unique
            if (!$this->auth_model->is_unique_username($data["username"], $data["id"])) {
                $this->session->set_flashdata('error', trans("msg_username_unique_error"));
                redirect($this->agent->referrer());
                exit();
            }
            //is slug unique
            if ($this->auth_model->check_is_slug_unique($data["slug"], $data["id"])) {
                $this->session->set_flashdata('error', trans("msg_slug_unique_error"));
                redirect($this->agent->referrer());
                exit();
            }

            if ($this->profile_model->edit_user($data["id"])) {
                $this->session->set_flashdata('success', trans("msg_updated"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Shop Opening Requests
     */
    public function shop_opening_requests()
    {
        $data['title'] = trans("shop_opening_requests");

        $pagination = $this->paginate(admin_url() . "shop-opening-requests", $this->membership_model->get_shop_opening_requests_count());
        $data['users'] = $this->membership_model->get_paginated_shop_opening_requests($pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/shop_opening_requests');
        $this->load->view('admin/includes/_footer');
    }
    public function bank_details_approve_requests()
    {
        $data['title'] = "Bank Approval Requests";
        $pagination = $this->paginate(admin_url() . "bank-approve-details", $this->auth_model->get_users_count_by_role('vendor'));
        $data['users'] = $this->auth_model->get_paginated_filtered_vendors('vendor', $pagination['per_page'], $pagination['offset']);
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/bank_details');
        $this->load->view('admin/includes/_footer');
    }
    /**
     * Approve Shop Opening Request
     */
    public function approve_shop_opening_request()
    {
        $user_id = $this->input->post('id', true);
        $user = get_user($user_id);
        $email = $user->email;

        $message = $this->input->post('message', true);
        // var_dump($this->membership_model->approve_shop_opening_request($user_id));
        // exit;

        $commission_rate = $this->input->post('commission_rate', true);

        $this->auth_model->set_commission_rate($user_id, $commission_rate);

        if ($this->membership_model->approve_shop_opening_request($user_id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));

            $submit = $this->input->post('submit', true);
            $email_body = get_content('supplier_welcome_email');
            $email_reject = get_content('supplier_rejection_email');
            $subject = "Welcome to the Family!";
            $email_content = "<p> Dear $user->first_name, $email_body";
            // $email_button_text = trans("start_selling");
            if ($submit == '0') {
                $email_content = "<p> Dear $user->first_name, $email_reject";
                $email_button_text = trans("view_site");
                $subject = "We are Sorry!";
            }
            //send email

            if (!empty($user) && $this->general_settings->send_email_shop_opening_request == 1) {
                $email_data = array(
                    'email_type' => 'email_general',
                    'to' => $email,
                    'subject' => $subject,
                    'email_content' => $email_content,
                    'email_link' => base_url(),
                    'email_button_text' => $email_button_text
                );

                $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }
    public function edit_vendor_bank_details($id)
    {

        $data['title'] = "Edit Bank Details";
        $data['user'] = $this->auth_model->get_user($id);


        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/bank_details_form');
        $this->load->view('admin/includes/_footer');
    }
    public function edit_bank_details_post()
    {
        //validate inputs
        $user_id = $this->input->post('id', true);
        $user = get_user($user_id);

        $data = array(
            'id' => $this->input->post('id', true),
            'is_bank_details_approved' => 1,
            'acc_holder_name' => $this->input->post('holder_name', true),
            'update_profile' => '1',
            'ifsc_code' => $this->input->post('ifsc_code', true),
            'bank_branch' => $this->input->post('bank_branch', true),
            'account_number' => $this->input->post('account_number', true)
        );

        if ($this->profile_model->edit_vendor_bank_details($user->id)) {
            // $this->load->model("email_model");
            // // $this->email_model->seller_bank_account_detail_verify($user->id);
            // $this->session->set_flashdata('success', trans("msg_updated"));
            $this->payout_settle_cycle_api($user->id);
            // die();
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }
    /**
     * Decline Shop Opening Request
     */
    public function decline_shop_opening_request()
    {
        $user_id = $this->input->post('id', true);
        $user = get_user($user_id);
        $email = $user->email;

        $message = $this->input->post('message', true);


        if ($this->membership_model->decline_shop_opening_request($user_id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));

            $submit = $this->input->post('submit', true);
            $email_body = get_content('supplier_welcome_email');
            $email_reject = get_content('supplier_rejection_email');
            $subject = "Welcome to the Family!";
            $email_content = "<p> Dear $user->first_name, $email_body";

            $email_content = "<p> Dear $user->first_name, $email_reject";
            $email_button_text = trans("view_site");
            $subject = "We are Sorry!";

            if (!empty($user) && $this->general_settings->send_email_shop_opening_request == 1) {
                $email_data = array(
                    'email_type' => 'email_general',
                    'to' => $email,
                    'subject' => $subject,
                    'email_content' => $email_content,
                    'email_link' => base_url(),
                    'email_button_text' => $email_button_text
                );

                $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    public function approve_profile()
    {
        $user_id = $this->input->post('id', true);

        if ($this->membership_model->approve_profile($user_id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }


    // public function approved_shop_opening_request()
    // {
    //     $user_id = $this->input->post('id', true);
    //     $user = get_user($user_id);
    //     $email = $user->email;

    //     $message = $this->input->post('message', true);
    //     // var_dump($this->membership_model->approve_shop_opening_request($user_id));
    //     // exit;

    //     if ($this->membership_model->approve_shop_opening_request($user_id)) {
    //         $this->session->set_flashdata('success', trans("msg_updated"));

    //         $submit = $this->input->post('submit', true);
    //         $email_body = get_content('supplier_welcome_email');
    //         $email_reject = get_content('supplier_rejection_email');
    //         $subject = "Welcome to the Family!";
    //         $email_content = "<p> Dear $user->first_name, $email_body";
    //         $email_button_text = trans("start_selling");
    //         if ($submit == 0) {
    //             $email_content = "<p> Dear $user->first_name, $email_reject";
    //             $email_button_text = trans("view_site");
    //             $subject = "We are Sorry!";
    //         }
    //         //send email

    //         if (!empty($user) && $this->general_settings->send_email_shop_opening_request == 1) {
    //             $email_data = array(
    //                 'email_type' => 'email_general',
    //                 'to' => $email,
    //                 'subject' => $subject,
    //                 'email_content' => $email_content,
    //                 'email_link' => base_url(),
    //                 'email_button_text' => $email_button_text
    //             );

    //             $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
    //         }
    //     } else {
    //         $this->session->set_flashdata('error', trans("msg_error"));
    //     }
    //     redirect($this->agent->referrer());
    // }


    // public function approved_shop_opening_request()
    // {
    //     $user_id = $this->input->post('id', true);
    //     $user = get_user($user_id);
    //     $email = $user->email;

    //     $message = $this->input->post('message', true);
    //     // var_dump($this->membership_model->approve_shop_opening_request($user_id));
    //     // exit;

    //     if ($this->membership_model->approve_shop_opening_request($user_id)) {
    //         $this->session->set_flashdata('success', trans("msg_updated"));

    //         $submit = $this->input->post('submit', true);
    //         $email_body = get_content('supplier_welcome_email');
    //         $email_reject = get_content('supplier_rejection_email');
    //         $subject = "Welcome to the Family!";
    //         $email_content = "<p> Dear $user->first_name, $email_body";
    //         $email_button_text = trans("start_selling");
    //         if ($submit == 0) {

    //             $email_content = "<p> Dear $user->first_name, $email_reject";
    //             $email_button_text = trans("view_site");
    //             $subject = "We are Sorry!";
    //         }
    //         //send email

    //         if (!empty($user) && $this->general_settings->send_email_shop_opening_request == 1) {
    //             $email_data = array(
    //                 'email_type' => 'email_general',
    //                 'to' => $email,
    //                 'subject' => $subject,
    //                 'email_content' => $email_content,
    //                 'email_link' => base_url(),
    //                 'email_button_text' => $email_button_text
    //             );

    //             $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
    //         }
    //     } else {
    //         $this->session->set_flashdata('error', trans("msg_error"));
    //     }
    //     redirect($this->agent->referrer());
    // }
    public function revert_back()
    {


        $id = $this->input->post('id1', true);
        $message = $this->input->post('messagere', true);
        $issues = $this->input->post('issues', true);
        $email = $this->input->post('email', true);
        $user = get_user($id);
        foreach ($issues as $issue) {
            if ($issue == "GST number is not valid")
                $data['gst_issue'] = 1;
            else if ($issue == "PAN number not valid")
                $data['pan_issue'] = 1;
            else if ($issue == "Pan Photo not clear")
                $data['pan_photo_issue'] = 1;
            else
                $data['adhaar_issue'] = 1;
        }
        if ($this->membership_model->insert_issues($id, $data)) {
            echo "Successfully stored";
        } else {
            echo "check issue";
        }

        $this->load->model("email_model");
        $this->session->set_flashdata('submit', "send_email");

        if (!empty($email)) {
            if (!$this->email_model->revert_back($email, $user->first_name, $message, $issues)) {
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
     * Confirm User Email
     */
    public function confirm_user_email()
    {
        $id = $this->input->post('id', true);
        $user = $this->auth_model->get_user($id);
        if ($this->auth_model->verify_email($user)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }




    /**
     * Ban or Remove User Ban
     */
    public function ban_remove_ban_user()
    {
        $id = $this->input->post('id', true);
        // $id = $this->input->post('id', true);
        $user = get_user($id);
        $this->load->model("email_model");
        $this->session->set_flashdata('submit', "send_email");

        if (!empty($user->email)) {
            if (!$this->email_model->send_regret_shopmail($user->email, $user->first_name)) {
                redirect($this->agent->referrer());
                // exit();
            }
            $this->session->set_flashdata('success', trans("msg_email_sent"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        if ($this->auth_model->ban_remove_ban_user($id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Open or Close User Shop
     */
    public function open_close_user_shop()
    {
        $id = $this->input->post('id', true);
        $user = get_user($id);
        $this->load->model("email_model");
        $this->session->set_flashdata('submit', "send_email");

        if (!empty($user->email)) {
            if (!$this->email_model->send_open_shopmail($user->email, $user->first_name)) {
                redirect($this->agent->referrer());
                // exit();
            }
            $this->session->set_flashdata('success', trans("msg_email_sent"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        if ($this->membership_model->open_close_user_shop($id)) {

            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /**
     * Delete User
     */
    public function delete_user_post()
    {
        $id = $this->input->post('id', true);
        if ($this->auth_model->delete_user($id)) {
            $this->session->set_flashdata('success', trans("msg_user_deleted"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    /*
    *------------------------------------------------------------------------------------------
    * MEMBERSHIP PLANS
    *------------------------------------------------------------------------------------------
    */

    /**
     * Membership Plans
     */
    public function membership_plans()
    {
        $data['title'] = trans("membership_plans");
        $data["membership_plans"] = $this->membership_model->get_plans();

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/membership_plans');
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Plan Post
     */
    public function add_plan_post()
    {
        if ($this->membership_model->add_plan()) {
            $this->session->set_flashdata('success', trans("msg_added"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Edit Plan
     */
    public function edit_plan($id)
    {
        $data['title'] = trans("edit_plan");
        $data['plan'] = $this->membership_model->get_plan($id);
        if (empty($data['plan'])) {
            redirect($this->agent->referrer());
            exit();
        }
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/edit_plan');
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Edit Plan Post
     */
    public function edit_plan_post()
    {
        $id = $this->input->post('id', true);
        if ($this->membership_model->edit_plan($id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Settings Post
     */
    public function settings_post()
    {
        if ($this->membership_model->update_settings()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        $this->session->set_flashdata('msg_settings', 1);
        redirect($this->agent->referrer());
    }

    /**
     * Delete Plan Post
     */
    public function delete_plan_post()
    {
        $id = $this->input->post('id', true);
        $this->membership_model->delete_plan($id);
        redirect($this->agent->referrer());
    }

    /**
     * Membership Transactions
     */
    public function transactions_membership()
    {
        $data['title'] = trans("membership_transactions");
        $data['description'] = trans("membership_transactions") . " - " . $this->app_name;
        $data['keywords'] = trans("membership_transactions") . "," . $this->app_name;

        $data['num_rows'] = $this->membership_model->get_membership_transactions_count(null);
        $pagination = $this->paginate(admin_url() . "membership-transactions", $data['num_rows']);
        $data['transactions'] = $this->membership_model->get_paginated_membership_transactions(null, $pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/membership/transactions');
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Approve Payment Post
     */
    public function approve_payment_post()
    {
        $id = $this->input->post('id', true);
        $this->membership_model->approve_transaction_payment($id);
        $this->session->set_flashdata('success', trans("msg_updated"));
        redirect($this->agent->referrer());
    }

    /**
     * Delete Transactions Post
     */
    public function delete_transaction_post()
    {
        $id = $this->input->post('id', true);
        $this->membership_model->delete_transaction($id);
    }

    public function payout_settle_cycle_api($user_id)
    {
        // var_dump($data);die();
        $curl = curl_init();
        $user_id = $user_id;
        $url = $this->general_settings->cashfree_api_base_url . 'api/v2/easy-split/vendors/settlement-cycles';
        $client_id = $this->general_settings->cashfree_app_id;
        $secret_key = $this->general_settings->cashfree_secret_key;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'x-client-id: ' . $client_id,
                'x-client-secret: ' . $secret_key,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $res_decode = json_decode($response);
        $status = json_decode($response)->status;
        $max_settlement_cycle = end($res_decode->settlementCycles)->id;
        if ($status == 'OK') {
            $this->create_vendor_cashfree_easysplit($max_settlement_cycle, $user_id);
        } else {
            echo '<script>alert("Settlement Cycle API error")</script>';
        }
    }

    public function create_vendor_cashfree_easysplit($max_settlement_cycle, $user_id)
    {
        $curl = curl_init();
        $url = $this->general_settings->cashfree_api_base_url . 'api/v2/easy-split/vendors';
        $client_id = $this->general_settings->cashfree_app_id;
        $secret_key = $this->general_settings->cashfree_secret_key;
        $seller_id = $user_id;

        $bank_data = array(
            "accountNumber" => get_user($seller_id)->account_number,
            "accountHolder" => get_user($seller_id)->acc_holder_name,
            "ifsc" => get_user($seller_id)->ifsc_code
        );

        $post_fields = array(
            "email" => get_user($seller_id)->email,
            "status" => "ACTIVE",
            "bank" => $bank_data,
            "phone" => get_user($seller_id)->phone_number,
            "name" => get_user($seller_id)->first_name . ' ' . get_user($seller_id)->last_name,
            "id" => $seller_id,
            "settlementCycleId" => $max_settlement_cycle
        );
        // var_dump($post_fields);die();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($post_fields),
            CURLOPT_HTTPHEADER => array(
                'x-client-id: ' . $client_id,
                'x-client-secret: ' . $secret_key,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response_dec = json_decode($response);
        if ($response_dec->subCode == '200') {
            $msg = trans("msg_updated") . " " . $response_dec->message;
            $this->session->set_flashdata('success', $msg);
        } elseif ($response_dec->message == 'VendorId already exists. Enter unique VendorId.') {
            $this->update_vendor_cashfree_easysplit($max_settlement_cycle, $seller_id);
        } else {
            $msg = trans("msg_updated") . " " . $response_dec->message;
            $this->session->set_flashdata('error', $msg);
        }
    }



    public function update_vendor_cashfree_easysplit($max_settlement_cycle, $user_id)
    {
        $curl = curl_init();
        $url = $this->general_settings->cashfree_api_base_url . 'api/v2/easy-split/vendors';
        $client_id = $this->general_settings->cashfree_app_id;
        $secret_key = $this->general_settings->cashfree_secret_key;
        $seller_id = $user_id;

        $bank_data = array(
            "accountNumber" => get_user($seller_id)->account_number,
            "accountHolder" => get_user($seller_id)->acc_holder_name,
            "ifsc" => get_user($seller_id)->ifsc_code
        );

        $post_fields = array(
            "email" => get_user($seller_id)->email,
            "status" => "ACTIVE",
            "bank" => $bank_data,
            "phone" => get_user($seller_id)->phone_number,
            "name" => get_user($seller_id)->first_name . ' ' . get_user($seller_id)->last_name,
            "id" => $seller_id,
            "settlementCycleId" => $max_settlement_cycle
        );
        // var_dump($post_fields);die();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => json_encode($post_fields),
            CURLOPT_HTTPHEADER => array(
                'x-client-id: ' . $client_id,
                'x-client-secret: ' . $secret_key,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response_dec = json_decode($response);
        if ($response_dec->subCode == '200') {
            $this->session->set_flashdata('success', $response_dec->message);
        } else {
            $this->session->set_flashdata('error', $response_dec->message);
        }
    }
}
