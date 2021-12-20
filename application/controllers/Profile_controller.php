<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile_controller extends Home_Core_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Profile
     */
    public function profile($slug)
    {
        $slug = clean_slug($slug);
        $data["user"] = $this->auth_model->get_user_by_slug($slug);
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        if ($data["user"]->update_profile == "1" && $data["user"]->is_profile_approved == "0") {
            return 'javascript:void(0)';
        }

        $data['title'] = get_shop_name($data["user"]);
        $data['description'] = $data["user"]->username . " - " . $this->app_name;
        $data['keywords'] = $data["user"]->username . "," . $this->app_name;
        $data["active_tab"] = "products";
        $data["user_rating"] = calculate_user_rating($data["user"]->id);
        $data["session"] = get_user_session();
        $data["product_images"] = $this->file_model->get_story_images($data["user"]->id);
        $data['custom_filters'] = $this->field_model->get_custom_filters();
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
        $data['num_rows'] = $this->product_model->get_user_products_count($data["user"]->id, 'active');
        $pagination = $this->paginate(generate_profile_url($data["user"]->slug), $data['num_rows'], $this->product_per_page);
        $data['products'] = $this->product_model->get_paginated_filtered_user_products($data["user"]->id, 'active', $data["query_string_array"], null, $pagination['per_page'], $pagination['offset']);

        $data['user_categories'] = $this->product_model->get_categories_array_with_products($data["user"]->id);
        $data['reviews_supplier'] = $this->review_model->get_seller_reviews($data["user"]->id);
        $this->load->view('partials/_header', $data);
        $this->load->view('profile/profile', $data);
        $this->load->view('partials/_footer');
    }

    public function get_review_seller()
    {
        $user_id = $this->input->post('user_id', true);
        $review = $this->review_model->get_seller_reviews($user_id);
        $content = null;
        $data = array(
            'status' => 0,
            'html_content' => ""
        );
        if (!empty($review)) :
            foreach ($review as $review) {
                $content .= '<li class="media" style="margin-bottom: 15px;">
                            <a class="review-style" href="' . generate_profile_url($review->user_slug) . '" >
                                <img class="review-img-new" src="' . get_user_avatar_by_id($review->user_id) . '" alt="' . get_shop_name_by_user_id($review->user_id) . '">
                            </a>
                            <div class="media-body" style="margin-top:20px;">
                                
                                <div class="row-custom">
                                    <a href="' . generate_profile_url($review->user_slug) . '">
                                        <h6 class="username">' . get_shop_name_by_user_id($review->user_id) . '</h6>
                                    </a>
                                </div>
                                <div class="row-custom">
                                    <div class="review">
                                        ' . html_escape($review->review) . '
                                    </div>
                                </div>
                            
                            </div>
                        </li>';
            }
            $data["status"] = 1;
            $data["html_content"] = $content;
        endif;
        echo json_encode($data);
    }
    /**
     * Downloads
     */
    public function downloads()
    {
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        if (!$this->is_sale_active) {
            redirect(lang_base_url());
        }
        if ($this->general_settings->digital_products_system == 0) {
            redirect(lang_base_url());
        }
        $data["user"] = $this->auth_user;
        $data['title'] = trans("downloads");
        $data['description'] = trans("downloads") . " - " . $this->app_name;
        $data['keywords'] = trans("downloads") . "," . $this->app_name;
        $data["active_tab"] = "downloads";
        $data["user_rating"] = calculate_user_rating($data["user"]->id);
        //set pagination
        $pagination = $this->paginate(generate_url("downloads"), $this->product_model->get_user_downloads_count($data["user"]->id), $this->product_per_page);
        $data['items'] = $this->product_model->get_paginated_user_downloads($data["user"]->id, $pagination['per_page'], $pagination['offset']);

        $this->load->view('partials/_header', $data);
        $this->load->view('profile/downloads', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Wishlist
     */
    public function wishlist($slug)
    {
        $slug = clean_slug($slug);
        $data["user"] = $this->auth_model->get_user_by_slug($slug);
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }

        $data['title'] = trans("wishlist");
        $data['description'] = trans("wishlist") . " - " . $this->app_name;
        $data['keywords'] = trans("wishlist") . "," . $this->app_name;
        $data["active_tab"] = "wishlist";
        $data["user_rating"] = calculate_user_rating($data["user"]->id);
        $data["session"] = get_user_session();
        //set pagination
        $pagination = $this->paginate(generate_url("wishlist") . '/' . $data["user"]->slug, $this->product_model->get_user_wishlist_products_count($data["user"]->id), $this->product_per_page);
        $data['products'] = $this->product_model->get_paginated_user_wishlist_products($data["user"]->id, $pagination['per_page'], $pagination['offset']);

        $this->load->view('partials/_header', $data);
        $this->load->view('profile/wishlist', $data);
        $this->load->view('partials/_footer');
    }

    public function stories($slug)
    {
        $slug = clean_slug($slug);
        $data["user"] = $this->auth_model->get_user_by_slug($slug);
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }

        $data['title'] = "Stories";
        $data['description'] = "Stories" . " - " . $this->app_name;
        $data['keywords'] = "Stories" . "," . $this->app_name;
        $data["active_tab"] = "stories";
        $data["product_images"] = $this->file_model->get_story_images($data["user"]->id);
        $data["user_rating"] = calculate_user_rating($data["user"]->id);
        $data["session"] = get_user_session();
        //set pagination
        // $pagination = $this->paginate(generate_url("wishlist") . '/' . $data["user"]->slug, $this->product_model->get_user_wishlist_products_count($data["user"]->id), $this->product_per_page);
        // $data['products'] = $this->product_model->get_paginated_user_wishlist_products($data["user"]->id, $pagination['per_page'], $pagination['offset']);

        $this->load->view('partials/_header', $data);
        $this->load->view('profile/stories', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Followers
     */
    public function followers($slug)
    {
        $slug = clean_slug($slug);
        $data["user"] = $this->auth_model->get_user_by_slug($slug);
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data['title'] = trans("followers");
        $data['description'] = trans("followers") . " - " . $this->app_name;
        $data['keywords'] = trans("followers") . "," . $this->app_name;
        $data["active_tab"] = "followers";
        $data["user_rating"] = calculate_user_rating($data["user"]->id);
        $data["followers"] = $this->profile_model->get_followers($data["user"]->id);
        $data["session"] = get_user_session();
        $this->load->view('partials/_header', $data);
        $this->load->view('profile/followers', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Following
     */
    public function following($slug)
    {
        $slug = clean_slug($slug);
        $data["user"] = $this->auth_model->get_user_by_slug($slug);
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data['title'] = trans("following");
        $data['description'] = trans("following") . " - " . $this->app_name;
        $data['keywords'] = trans("following") . "," . $this->app_name;
        $data["active_tab"] = "following";
        $data["user_rating"] = calculate_user_rating($data["user"]->id);
        $data["following_users"] = $this->profile_model->get_following_users($data["user"]->id);
        $data["session"] = get_user_session();
        $this->load->view('partials/_header', $data);
        $this->load->view('profile/following', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Reviews
     */
    public function reviews($slug)
    {
        $slug = clean_slug($slug);
        if ($this->general_settings->reviews != 1) {
            redirect(lang_base_url());
        }

        $data["user"] = $this->auth_model->get_user_by_slug($slug);
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        if ($data["user"]->role != 'admin' && $data["user"]->role != 'vendor') {
            redirect(lang_base_url());
        }

        $data['title'] = get_shop_name($data["user"]) . " " . trans("reviews");
        $data['description'] = $data["user"]->username . " " . trans("reviews") . " - " . $this->app_name;
        $data['keywords'] = $data["user"]->username . " " . trans("reviews") . "," . $this->app_name;
        $data["active_tab"] = "reviews";
        $data["user_rating"] = calculate_user_rating($data["user"]->id);
        $data["session"] = get_user_session();
        //set pagination
        $pagination = $this->paginate(generate_url("reviews") . "/" . $data["user"]->slug, $this->review_model->get_vendor_reviews_count($data["user"]->id), 10);
        $data['reviews'] = $this->review_model->get_paginated_vendor_reviews($data["user"]->id, $pagination['per_page'], $pagination['offset']);


        $this->load->view('partials/_header', $data);
        $this->load->view('profile/reviews', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Update Profile
     */
    public function update_profile()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        $data['title'] = trans("update_profile");
        $data['description'] = trans("update_profile") . " - " . $this->app_name;
        $data['keywords'] = trans("update_profile") . "," . $this->app_name;
        $data["user"] = $this->auth_user;
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data["active_tab"] = "update_profile";
        $data["session"] = get_user_session();
        $this->load->view('partials/_header', $data);
        $this->load->view('settings/update_profile', $data);
        $this->load->view('partials/_footer');
    }
    public function update_profile_dashboard()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        $data['title'] = trans("update_profile");
        $data['description'] = trans("update_profile") . " - " . $this->app_name;
        $data['keywords'] = trans("update_profile") . "," . $this->app_name;
        $data["user"] = $this->auth_user;
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data["active_tab"] = "profile_settings";
        $data["session"] = get_user_session();
        $this->load->view('dashboard/includes/_header_buyer', $data);
        $this->load->view('settings/update_profile_dashboard', $data);
        // $this->load->view('dashboard/includes/_footer');
        $this->load->view('partials/_footer');
    }

    /**
     * Update Profile Post
     */
    public function update_profile_post()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $user_id = $this->auth_user->id;
        $action = $this->input->post('submit', true);

        if ($action == "resend_activation_email") {
            //send activation email
            $this->load->model("email_model");
            $this->email_model->send_email_activation($user_id);
            $this->session->set_flashdata('success', trans("msg_send_confirmation_email"));
            redirect($this->agent->referrer());
        }

        //validate inputs
        // $this->form_validation->set_rules('username', trans("username"), 'required|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email', trans("email"), 'required|xss_clean');
        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect($this->agent->referrer());
        } else {

            $data = array(
                //'username' => $this->input->post('username', true),
                'first_name' => $this->input->post('first_name', true),
                'last_name' => $this->input->post('last_name', true),
                //'slug' => str_slug($this->input->post('slug', true)),
                'email' => $this->input->post('email', true),
                'zip_code' => $this->input->post('user_pincode', true),
                'user_state' => $this->input->post('user_state', true),
                'user_city' => $this->input->post('user_city', true),
                'user_area' => $this->input->post('user_area', true),
                'address' => $this->input->post('user_house_no', true),
                'user_landmark' => $this->input->post('user_landmark', true),

                'phone_number' => $this->input->post('phone_number', true),
                'send_email_new_message' => $this->input->post('send_email_new_message', true)
            );

            //is email unique
            if (!$this->auth_model->is_unique_email($data["email"], $user_id)) {
                $this->session->set_flashdata('error', trans("msg_email_unique_error"));
                redirect($this->agent->referrer());
                exit();
            }
            // //is username unique
            // if (!$this->auth_model->is_unique_username($data["username"], $user_id)) {
            //     $this->session->set_flashdata('error', trans("msg_username_unique_error"));
            //     redirect($this->agent->referrer());
            //     exit();
            // }
            // //is slug unique
            // if ($this->auth_model->check_is_slug_unique($data["slug"], $user_id)) {
            //     $this->session->set_flashdata('error', trans("msg_slug_unique_error"));
            //     redirect($this->agent->referrer());
            //     exit();
            // }


            // var_dump($this->location_model->search_cities_name("Hisar"));
            // exit();
            $ids = $this->location_model->search_cities_name($data["user_city"]);
            $data["state_id"] = $ids[0]->state_id;
            $data["country_id"] = $ids[0]->country_id;
            $data["city_id"] = $ids[0]->id;

            if ($this->profile_model->update_profile($data, $user_id)) {
                $this->session->set_flashdata('success', trans("msg_updated"));
                //check email changed
                if ($this->profile_model->check_email_updated($user_id)) {
                    $this->session->set_flashdata('success', trans("msg_send_confirmation_email"));
                }
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }
    public function update_story_post()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $user_id = $this->auth_user->id;
        $action = $this->input->post('submit', true);

        // if ($action == "resend_activation_email") {
        //     //send activation email
        //     $this->load->model("email_model");
        //     $this->email_model->send_email_activation($user_id);
        //     $this->session->set_flashdata('success', trans("msg_send_confirmation_email"));
        //     redirect($this->agent->referrer());
        // }

        //validate inputs
        // $this->form_validation->set_rules('username', trans("username"), 'required|xss_clean|max_length[255]');


        $ass = $this->input->post('assistance', true);
        $data = array(
            'acc_holder_name' => $this->input->post('holder_name', true),
            'update_profile' => '1',
            'ifsc_code' => $this->input->post('ifsc_code', true),
            'bank_branch' => $this->input->post('bank_branch', true),
            'account_number' => $this->input->post('account_number', true),
            'brand_desc' => $this->input->post('brand_desc', true),
            'assistance' => implode(',', $ass),
            'brand_name' => $this->input->post('brand_name', true),
            'supplier_speciality' => $this->input->post('supplier_speciality', true),
            'customer_name' => $this->input->post('customer_name', true),
            'source' => $this->input->post('source', true),
            'different_type_products' => $this->input->post('different_type_products', true),
            'testimonial' => $this->input->post('testimonial', true),
            'about_me' => $this->input->post('about_me', true),
            'is_bank_details_approved' => (int)($this->input->post('is_bank_details_approved', true)),
            'supplier_story_url' => $this->input->post('story_vedio_url', true),

        );
        $bank_branch = $this->auth_user->bank_branch;
        $ifsc_code = $this->auth_user->ifsc_code;
        $account_number = $this->auth_user->account_number;
        $cheque_image_url = $this->auth_user->cheque_image_url;
        $account_holder_name = $this->auth_user->acc_holder_name;
        if ($data['bank_branch'] != $bank_branch || $data['ifsc_code'] != $ifsc_code || $data['account_number'] != $account_number || $data['account_holder_name'] != $account_holder_name) {
            $data['is_bank_details_approved'] = 0;
            $this->load->model("email_model");
            $this->email_model->seller_bank_account_detail($user_id);
        } else {
            $data['is_bank_details_approved'] = $this->auth_user->is_bank_details_approved;
        }

        if ($action == "update") {

            if ($this->profile_model->update_story($data, $user_id)) {
                $this->session->set_flashdata('success', trans("msg_updated"));




                //check email changed

                redirect(generate_dash_url("profile"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        } else if ($action == "save_and_next_details") {
            if ($this->profile_model->update_story($data, $user_id)) {
                $this->session->set_flashdata('success', trans("msg_updated"));
                //check email changed

                redirect(generate_dash_url("add_product"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }



    public function update_supplier_profile_logo()
    {

        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $user_id = $this->auth_user->id;
        $data = array(
            'supplier_story_url' => $this->input->post('story_vedio_url', true),
            'about_me' => $this->input->post('about_me', true),
            'update_profile' => '1',



        );



        $this->profile_model->update_supplier_profile_logo($data, $user_id);
        redirect($this->agent->referrer());
    }

    public function update_payout_account()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $user_id = $this->auth_user->id;
        $action = $this->input->post('submit', true);
        // var_dump($action);die();
        $data = array(
            'acc_holder_name' => $this->input->post('holder_name', true),
            'update_profile' => '1',
            'ifsc_code' => $this->input->post('ifsc_code', true),
            'bank_branch' => $this->input->post('bank_branch', true),
            'account_number' => $this->input->post('account_number', true),
            'is_bank_details_approved' => (int)$this->input->post('is_bank_details_aprroved', true),
        );
        $bank_details = $this->auth_user->is_bank_details_approved;

        $bank_branch = $this->auth_user->bank_branch;
        $ifsc_code = $this->auth_user->ifsc_code;
        $account_number = $this->auth_user->account_number;
        $cheque_image_url = $this->auth_user->cheque_image_url;

        $account_holder_name = $this->auth_user->acc_holder_name;
        if ($data['bank_branch'] != $bank_branch || $data['ifsc_code'] != $ifsc_code || $data['account_number'] != $account_number || $data['acc_holder_name'] != $account_holder_name) {

            $data['is_bank_details_approved'] = 0;
            $this->load->model("email_model");
            $this->email_model->seller_bank_account_detail($user_id);
        } else {
            $data['is_bank_details_approved'] = $this->auth_user->is_bank_details_approved;
        }
        // if ($action == "update") {

        if ($this->profile_model->update_payout_account($data, $user_id)) {
            // $this->load->model("email_model");
            // $this->email_model->seller_bank_account_detail($user_id);
            $this->session->set_flashdata('success', trans("msg_updated"));
            //check email changed

            // redirect(generate_dash_url("profile"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
        // }
    }









    /**                                          
     * Gharobaar Fee Schedule Post for seller
     */

    public function agree_fee_schedule()
    {
        post_method();
        //check auth
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        $user_id = $this->auth_user->id;
        $data = array(
            'agree_fee_schedule' => $this->input->post("agree_fee_schedule", true)
        );
        if ($this->profile_model->update_profile($data, $user_id)) {
            $this->session->set_flashdata('success', trans("msg_fee_schedule"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }


    /**                                          
     * Gharobaar FSSAI Undertaking for home-cook and Grocery Gourmet
     */

    public function agree_fssai_undertaking()
    {
        post_method();
        //check auth
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        $user_id = $this->auth_user->id;
        $data = array(
            'action' => $this->input->post("action", true)
        );
        if ($this->profile_model->update_fssai_undertaking($data, $user_id)) {
            $this->session->set_flashdata('success', trans("msg_fee_schedule"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    public function delete_certificate()
    {
        $id = $this->input->post('id', true);
        if ($this->profile_model->delete_certificate($id)) {
            $this->session->set_flashdata('success', "certificate sucessfully deleted");
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();
    }
    public function delete_pan()
    {
        $id = $this->input->post('id', true);
        if ($this->profile_model->delete_pan($id)) {
            $this->session->set_flashdata('success', "pan sucessfully deleted");
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();
    }
    public function delete_gst()
    {
        $id = $this->input->post('id', true);
        if ($this->profile_model->delete_gst($id)) {
            $this->session->set_flashdata('success', "GST Image sucessfully deleted");
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();
    }
    public function delete_adhaar()
    {
        $id = $this->input->post('id', true);
        if ($this->profile_model->delete_adhaar($id)) {
            $this->session->set_flashdata('success', "Aadhaar card sucessfully deleted");
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();
    }

    public function update_seller_info_post()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $user_id = $this->auth_user->id;
        $action = $this->input->post('submit', true);


        // if ($this->form_validation->run() === false) {
        //     $this->session->set_flashdata('errors', validation_errors());
        //     redirect($this->agent->referrer());
        // } else {

        $data = array(
            'shop_name' => remove_special_characters($this->input->post('shop_name', true)),
            'company_type' => remove_special_characters($this->input->post('company_type', true)),
            'area_in_operation' => $this->input->post('area_in_operation', true),
            'anniversary' => $this->input->post('anniversary', true),
            'originally_belongs' => $this->input->post('originally_belongs', true),
            'share' => $this->input->post('share', true),
            'gst_number' => $this->input->post('gst_number', true),
            'pan_number' => $this->input->post('pan_number', true),
            'image_pancard' => strval($this->input->post('pan_photo', true)),
            'adhaar_number' => $this->input->post('adhaar_number', true),
            'supplier_instagram_url' => $this->input->post('instagram_url', true),
            'supplier_facebook_url' => $this->input->post('facebook_url', true),
            'supplier_website_url' => $this->input->post('website_url', true),
            'supplier_other_url' => $this->input->post('other_url', true),
            'years_in_operation' => $this->input->post('years_in_operation', true),
            'barter' => $this->input->post('barter', true),
            'how_hear_about_us' => $this->input->post('how_hear_about_us', true),
            'assistance' => $this->input->post('assistance', true),
            'other_assistance' => $this->input->post('other_assistance', true),
            'usp' => $this->input->post('usp', true),
            'turnover' => $this->input->post('turnover', true),
            'active_customer' => $this->input->post('active_customers', true),

        );
        $data['image_pancard'] = "data:image/png;base64," . (trim($data['image_pancard'], "[removed]"));
        if ($this->profile_model->update_seller($data, $user_id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));

            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
        // }
    }

    public function update_seller_info_services()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        $data['title'] = "Update Supplier Information";
        $data['description'] = "Update Supplier Information" . " - " . $this->app_name;
        $data['keywords'] = "Update Supplier Information" . "," . $this->app_name;
        $data["user"] = $this->auth_user;
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data["active_tab"] = "update_seller_info_services";
        // $data["countries"] = $this->location_model->get_countries();
        $data["session"] = get_user_session();
        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('settings/update_seller_info_services', $data);
        $this->load->view('dashboard/includes/_footer');
    }
    public function update_seller_info_services_post()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $user_id = $this->auth_user->id;
        $action = $this->input->post('submit', true);


        // if ($this->form_validation->run() === false) {
        //     $this->session->set_flashdata('errors', validation_errors());
        //     redirect($this->agent->referrer());
        // } else {

        $data = array(
            'supplier_type' => "Services",
            'shop_name' => remove_special_characters($this->input->post('shop_name', true)),
            'brand_name' => $this->input->post('brand_name', true),
            'supplier_type_services' => remove_special_characters($this->input->post('supplier_type_services', true)),
            'education_type' => $this->input->post('education_type', true),
            'creative_type' => $this->input->post('creative_type', true),
            'other_service_type' => $this->input->post('other_service_type', true),
            'area_in_operation' => $this->input->post('area_in_operation1', true),
            // 'alternative_number' => $this->input->post('alternative_number', true),
            //'house_no' => $this->input->post('house_no', true),
            // 'landmark' => $this->input->post('landmark', true),
            //'pincode' => $this->input->post('pincode1', true),
            'anniversary' => $this->input->post('anniversary', true),
            'originally_belongs' => $this->input->post('originally_belongs', true),
            'share' => $this->input->post('share', true),
            //'first_name' => $this->input->post('first_name', true),
            //'last_name' => $this->input->post('last_name', true),
            //'//phone_number' => $this->input->post('phone_number', true),
            // /'middle_name' => $this->input->post('middle_name', true),
            //  'landline' => $this->input->post('landline_number', true),
            //  'supplier_area' => $this->input->post('area', true),
            // 'supplier_state' => $this->input->post('supplier_state1', true),
            // 'supplier_city' => $this->input->post('supplier_city1', true),
            //'about_me' => $this->input->post('about_me', true),
            'gst_number' => $this->input->post('gst_number1', true),
            'pan_number' => $this->input->post('pan_number1', true),
            'adhaar_number' => $this->input->post('adhaar_number1', true),
            //'email' => $this->input->post('email', true),
            'supplier_instagram_url' => $this->input->post('instagram_url', true),
            'supplier_facebook_url' => $this->input->post('facebook_url', true),
            'supplier_website_url' => $this->input->post('website_url', true),
            'supplier_other_url' => $this->input->post('other_url', true),
            'years_in_operation' => $this->input->post('years_in_operation1', true),
            'barter' => $this->input->post('barter1', true),
            'how_hear_about_us' => $this->input->post('hear_about_us1', true),
            'assistance' => $this->input->post('assistance1', true),
            'other_assistance' => $this->input->post('other_assistance1', true),
            'usp' => $this->input->post('usp', true),
            'image_pancard' => $this->input->post('pan_photo', true),
            'open_to_visit' => $this->input->post('visit_inperson', true),
            'willing_to_travel' => $this->input->post('travel_outside', true),
            'affiliations_or_certifications' => $this->input->post('certificate_name', true),
            'institute_name' => $this->input->post('institute_name', true),
            'specialisation_details' => $this->input->post('details_spec', true),
            'prefer_day' => $this->input->post('week', true),
            'prefer_time' => $this->input->post('day', true),
            'reference_1_name' => $this->input->post('refname1', true),
            'reference_1_contact' => $this->input->post('refcontact1', true),
            'reference_2_name' => $this->input->post('refname2', true),
            'reference_2_contact' => $this->input->post('refcontact2', true),
            'reference_3_name' => $this->input->post('refname3', true),
            'reference_3_contact' => $this->input->post('refcontact3', true),

        );
        $data['image_pancard'] = "data:image/png;base64," . (trim($data['image_pancard'], "[removed]"));
        if ($this->profile_model->update_seller($data, $user_id)) {
            $this->session->set_flashdata('success', trans("msg_updated"));

            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
        // }
    }
    /**
     * Personal Information
     */
    public function personal_information()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $data['title'] = trans("personal_information");
        $data['description'] = trans("personal_information") . " - " . $this->app_name;
        $data['keywords'] = trans("personal_information") . "," . $this->app_name;

        $data["active_tab"] = "personal_information";
        $data["countries"] = $this->location_model->get_countries();
        $data["states"] = $this->location_model->get_states_by_country($this->auth_user->country_id);
        $data["cities"] = $this->location_model->get_cities_by_state($this->auth_user->state_id);
        $data["session"] = get_user_session();
        $this->load->view('partials/_header', $data);
        $this->load->view('settings/personal_information', $data);
        $this->load->view('partials/_footer');
    }

    public function update_settings()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $data['title'] = "Update Settings";
        $data['description'] = "Update Settings" . " - " . $this->app_name;
        $data['keywords'] = "Update Settings" . "," . $this->app_name;

        $data["active_tab"] = "update_settings";
        // $data["countries"] = $this->location_model->get_countries();
        // $data["states"] = $this->location_model->get_states_by_country($this->auth_user->country_id);
        // $data["cities"] = $this->location_model->get_cities_by_state($this->auth_user->state_id);
        $data["session"] = get_user_session();
        $this->load->view('partials/_header', $data);
        $this->load->view('settings/update_settings', $data);
        $this->load->view('partials/_footer');
    }
    public function update_settings_post()
    {
        //check user
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        if ($this->profile_model->update_setting()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }


    /**
     * Personal Information Post
     */
    public function personal_information_post()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        if ($this->profile_model->update_personal_information()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Shipping Address
     */
    public function shipping_address()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        $data['title'] = trans("shipping_address");
        $data['description'] = trans("shipping_address") . " - " . $this->app_name;
        $data['keywords'] = trans("shipping_address") . "," . $this->app_name;
        $data["user"] = $this->auth_user;
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data["active_tab"] = "shipping_address";
        $data["countries"] = $this->location_model->get_countries();
        $data["session"] = get_user_session();
        $this->load->view('partials/_header', $data);
        $this->load->view('settings/shipping_address', $data);
        $this->load->view('partials/_footer');
    }
    public function update_seller_info()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        $data['title'] = "Update Supplier Information";
        $data['description'] = "Update Supplier Information" . " - " . $this->app_name;
        $data['keywords'] = "Update Supplier Information" . "," . $this->app_name;
        $data["user"] = $this->auth_user;
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data["active_tab"] = "update_seller_info";
        // $data["countries"] = $this->location_model->get_countries();
        $data["session"] = get_user_session();
        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('settings/update_seller_info', $data);
        $this->load->view('dashboard/includes/_footer');
    }
    /**
     * Shipping Address Post
     */
    public function shipping_address_post()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        if ($this->profile_model->update_shipping_address()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Social Media
     */
    public function social_media()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $data['title'] = trans("social_media");
        $data['description'] = trans("social_media") . " - " . $this->app_name;
        $data['keywords'] = trans("social_media") . "," . $this->app_name;
        $data["user"] = $this->auth_user;
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data["active_tab"] = "social_media";
        $data["session"] = get_user_session();
        $this->load->view('partials/_header', $data);
        $this->load->view('settings/social_media', $data);
        $this->load->view('partials/_footer');
    }

    public function social_media_dashboard()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        $data['title'] = trans("social_media");
        $data['description'] = trans("social_media") . " - " . $this->app_name;
        $data['keywords'] = trans("social_media") . "," . $this->app_name;
        $data["user"] = $this->auth_user;
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data["active_tab"] = "social_media_settings";
        $data["session"] = get_user_session();
        $this->load->view('dashboard/includes/_header_buyer', $data);
        $this->load->view('settings/social_media_dashboard', $data);
        $this->load->view('dashboard/includes/_footer');
        // $this->load->view('partials/_footer');
    }
    public function social_media_seller()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        $data['title'] = trans("social_media");
        $data['description'] = trans("social_media") . " - " . $this->app_name;
        $data['keywords'] = trans("social_media") . "," . $this->app_name;
        $data["user"] = $this->auth_user;
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data["active_tab"] = "social_media_seller";
        $data["session"] = get_user_session();
        $this->load->view('partials/_header', $data);
        $this->load->view('settings/social_media_seller', $data);
        $this->load->view('partials/_footer');
    }

    public function barter_product($slug)
    {
        $slug = clean_slug($slug);
        $data["user"] = $this->auth_model->get_user_by_slug($slug);
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }

        $data['title'] = get_shop_name($data["user"]);
        $data['description'] = $data["user"]->username . " - " . $this->app_name;
        $data['keywords'] = $data["user"]->username . "," . $this->app_name;
        $data["active_tab"] = "barter_product";
        $data["user_rating"] = calculate_user_rating($data["user"]->id);
        $data["session"] = get_user_session();
        //set pagination
        $data['num_rows'] = $this->product_model->get_user_barter_products_count($data["user"]->id, 'active');
        $pagination = $this->paginate(generate_barter_product_url($data["user"]->slug), $data['num_rows'], $this->product_per_page);
        $data['products'] = $this->product_model->get_paginated_barter_user_products($data["user"]->id, 'active', $pagination['per_page'], $pagination['offset']);

        $this->load->view('partials/_header', $data);
        $this->load->view('profile/barter_product', $data);
        $this->load->view('partials/_footer');
    }


    /**
     * Social Media Post
     */
    public function social_media_post()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        if ($this->profile_model->update_social_media()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }
    public function social_media_seller_post()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        if ($this->profile_model->update_social_media_seller()) {
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }


    /**
     * Change Password
     */
    public function change_password()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $data['title'] = trans("change_password");
        $data['description'] = trans("change_password") . " - " . $this->app_name;
        $data['keywords'] = trans("change_password") . "," . $this->app_name;
        $data["user"] = $this->auth_user;
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data["active_tab"] = "change_password";
        $data["session"] = get_user_session();
        $this->load->view('partials/_header', $data);
        $this->load->view('settings/change_password', $data);
        $this->load->view('partials/_footer');
    }

    public function change_password_dashboard()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $data['title'] = trans("change_password");
        $data['description'] = trans("change_password") . " - " . $this->app_name;
        $data['keywords'] = trans("change_password") . "," . $this->app_name;
        $data["user"] = $this->auth_user;
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data["active_tab"] = "password_settings";
        $data["session"] = get_user_session();
        $this->load->view('dashboard/includes/_header_buyer', $data);
        $this->load->view('settings/change_password_dashboard', $data);
        $this->load->view('dashboard/includes/_footer');
        // $this->load->view('partials/_footer');
    }

    public function change_password_dashboard_seller()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $data['title'] = trans("change_password");
        $data['description'] = trans("change_password") . " - " . $this->app_name;
        $data['keywords'] = trans("change_password") . "," . $this->app_name;
        $data["user"] = $this->auth_user;
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data["active_tab"] = "password_settings";
        $data["session"] = get_user_session();
        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('settings/change_password_dashboard', $data);
        $this->load->view('dashboard/includes/_footer');
    }
    /**
     * Change Password Post
     */
    public function change_password_post()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $old_password_exists = $this->input->post('old_password_exists', true);

        if ($old_password_exists == 1) {
            $this->form_validation->set_rules('old_password', trans("old_password"), 'required|xss_clean');
        }
        $this->form_validation->set_rules('password', trans("password"), 'required|xss_clean|min_length[4]|max_length[50]');
        $this->form_validation->set_rules('password_confirm', trans("password_confirm"), 'required|xss_clean|matches[password]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->profile_model->change_password_input_values());
            redirect($this->agent->referrer());
        } else {
            if ($this->profile_model->change_password($old_password_exists)) {
                $this->session->set_flashdata('success', trans("msg_change_password_success"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_change_password_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Change Password
     */
    public function update_story()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $data['title'] = trans("update_story");
        $data['description'] = trans("update_story") . " - " . $this->app_name;
        $data['keywords'] = trans("update_story") . "," . $this->app_name;
        $data["user"] = $this->auth_user;
        $data['modesy_images'] = $this->file_model->get_story_images_uncached($data["user"]->id);
        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        $data["active_tab"] = "update_story";
        $data["session"] = get_user_session();
        $this->load->view('partials/_header', $data);
        $this->load->view('settings/update_story', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Follow Unfollow User
     */
    public function follow_unfollow_user()
    {
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }

        $this->profile_model->follow_unfollow_user();
        redirect($this->agent->referrer());
    }




    //get location by pincode
    public function get_location_by_pincode()
    {

        echo "helo";
        exit();
        $pincode = $this->input->post('pincode', true);
        var_dump($pincode);
        exit();
        $data = $this->location_model->get_location($pincode);
        return $data;
    }

    //update mobile number of user in table
    public function update_user_mobile_number()
    {
        $phn_num = $this->input->post('phn_num', true);
        $user_id = $this->input->post('user_id', true);
        $result = $this->profile_model->update_mobile_number($phn_num, $user_id);
        return $result;
    }
}
