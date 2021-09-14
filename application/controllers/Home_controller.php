<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home_controller extends Home_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->comment_limit = 6;
        $this->blog_paginate_per_page = 12;
        $this->promoted_products_limit = $this->general_settings->index_promoted_products_count;
        // shipment api call for secret key
        $this->shiprocket();
    }

    //send otp function
    public function send_otp_verification($phn_num)
    {
        $label_content = $this->input->post("label_content", true);
        $order_no = $this->input->post("order_no", true);
        $email = $this->input->post("email_address", true);
        // Authorisation details.
        $username = "chirag.raut@austere.co.in";
        $hash = "495947f08983f416aa4556991fb67b2f2642e45e";

        // Config variables. Consult http://api.textlocal.in/docs for more info.
        $test = "0";

        // Data for text message. This is the text message data.
        $sender = "GHRBAR"; // This is who the message appears to be from.
        $numbers = "$phn_num"; // A single number or a comma-seperated list of numbers
        $otp = rand(100000, 999999);

        $_SESSION['LAST_ACTIVITY'] = time();
        $_SESSION['session_otp'] = $otp;

        $msg_content = get_content($label_content);

        //replace template var with value
        if ($label_content == "mobile_otp") {
            $token = array(
                'otp'  => $otp,
                'otp_time' => '3 mins'
            );
        } else if ($label_content == "mobile_otp_login") {
            $token = array(
                'otp'  => $otp,
                'otp_time' => '3 mins'
            );
        } else {
            $token = array(
                'order_no' => $order_no
            );
        }
        $pattern = '[%s]';
        foreach ($token as $key => $val) {
            $varMap[sprintf($pattern, $key)] = $val;
        }

        $message = strtr($msg_content, $varMap);



        $data = "username=" . ($username) . "&hash=" . ($hash) . "&message=" . $message . "&sender=" . $sender . "&numbers=" . $numbers . "&test=" . $test;

        $ch = curl_init('http://api.textlocal.in/send/?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); // This is the result from the API
        curl_close($ch);

        $this->send_email_otp("email_otp", $email, $message, $otp, "3 mins");

        if ($label_content == "mobile_otp") {
            $data = array(
                'html_content1' => "",
                'otp' => $_SESSION['session_otp'],
                'message' => $message
            );
            $this->session->set_flashdata('success', "OTP Sent Successfully !");
            $data["html_content1"] = $this->load->view('partials/_messages', null, true);
            reset_flash_data();
        } else if ($label_content == "mobile_otp_login") {
            $data = array(
                'html_content1' => "",
                'otp' => $_SESSION['session_otp'],
                'message' => $message
            );
            $this->session->set_flashdata('success', "OTP Sent Successfully !");
            $data["html_content1"] = $this->load->view('partials/_messages', null, true);
            reset_flash_data();
        } else {
            $data = array(
                'html_content1' => "",
                'order_no' => $order_no,
                'message' => $message
            );
        }
        echo json_encode($data);
    }
    public function send_email_otp($label_content, $email, $message, $otp, $otp_time)
    {
        $label_content = $label_content;
        $email = $email;
        $msg_content = get_content($label_content);

        //replace template var with value
        if ($label_content == "email_otp") {
            $token = array(
                'message' => $message,
                'otp' => $otp,
                'otp_time' => $otp_time
            );
        }
        $pattern = '[%s]';
        foreach ($token as $key => $val) {
            $varMap[sprintf($pattern, $key)] = $val;
        }

        $message = strtr($msg_content, $varMap);

        $this->load->model("email_model");

        $this->email_model->email_verify_otp($email, $message);
    }

    public function session_otp_verification($input_otp)
    {
        $data = array(
            'html_content2' => "",
            'otp' => $_SESSION['session_otp'],
            'input_otp' => $input_otp,
            'result' => false,
            'api' => "CONFIRM_OTP"
        );
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 180)) {
            unset($_SESSION['session_otp']);
            unset($_SESSION['LAST_ACTIVITY']);
            $this->session->set_flashdata('error', "Your OTP expired! Click On Resend OTP Button! ");
            $data["html_content2"] = $this->load->view('partials/_messages', null, true);
            reset_flash_data();
        } else {
            if ($data["otp"] == $data["input_otp"]) {
                $data["result"] = true;
                $this->session->set_flashdata('success', "Mobile Number Verified Successfully !");
                $data["html_content2"] = $this->load->view('partials/_messages', null, true);
                reset_flash_data();
            } else {
                $data["result"] = false;
                $this->session->set_flashdata('error', "You Entered Incorrect OTP. Try Again by entering Correct OTP!");
                $data["html_content2"] = $this->load->view('partials/_messages', null, true);
                reset_flash_data();
            }
        }
        echo json_encode($data);
    }

    /**
     * Index
     */
    public function index()
    {

        get_method();
        $data['title'] = $this->settings->homepage_title;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;

        //products
        $data["user_data"] = $this->profile_model->get_vendor_data();
        $data["promoted_products"] = $this->product_model->get_promoted_products_banner();
        $data["latest_products"] = get_latest_products($this->general_settings->index_latest_products_count);
        if (!empty($this->auth_user->id)) {
            if ($this->auth_user->gender == 'Male') {
                $data["top_picks_products"] = $this->product_model->get_category_products('MALE');
            } else {
                $data["top_picks_products"] = $this->product_model->get_category_products("FEMALE");
            }
        } else {
            $data["top_picks_products"] = $this->product_model->get_products_by_pageview();
        }
        // var_dump($data["category_products"]);
        $data["promoted_products"] = get_promoted_products($this->promoted_products_limit, 0);
        $data["promoted_products_count"] = get_promoted_products_count();
        $data["slider_items"] = $this->slider_model->get_slider_items();
        $data["slider_items"] = $this->slider_model->get_slider_item_by_type("MAIN_BANNER");
        $data["second_slider_items"] = $this->slider_model->get_slider_item_by_type("SECOND_MAIN_BANNER");
        $data["concern_slider_items"] = $this->slider_model->get_slider_item_by_type("SHOP_BY_CONCERN");
        $data["occassion_slider_items"] = $this->slider_model->get_slider_item_by_type("SHOP_BY_OCCASSION");

        $data['featured_categories'] = $this->category_model->get_featured_categories();

        $data["index_categories"] = $this->category_model->get_index_categories();
        $data["index_banners_array"] = $this->ad_model->get_index_banners_array();
        $data["special_offers"] = $this->product_model->get_special_offers();
        $data["category_products"] = $this->product_model->get_paginated_filtered_products(null, 1, 10, 0);
        $data["index_settings"] = get_index_settings();


        //get users details from pincode and distance
        // if (!empty($_SESSION["modesy_sess_user_location"]))
        //     $data["selected_seller_list"] = $this->product_model->get_seller_by_pincode_dist($_SESSION["modesy_sess_user_location"]);

        $register = $this->session->userdata('success');
        if ($register == 'Your account has been created successfully!') {
            $data['success_string'] = 1;
        } else {
            $data['success_string'] = 0;
        }

        //blog slider posts
        $key = "blog_slider_posts_lang_" . $this->selected_lang->id;
        $data["blog_slider_posts"] = get_cached_data($key);
        if (empty($data["blog_slider_posts"])) {
            $data["blog_slider_posts"] = $this->blog_model->get_latest_posts(8);
            set_cache_data($key, $data["blog_slider_posts"]);
        }
        $this->load->view('partials/_header', $data);
        $this->load->view('index', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Contact
     */
    public function contact()
    {
        get_method();
        $page = $this->page_model->get_page_by_default_name('contact', $this->selected_lang->id);
        if (empty($page)) {
            redirect(lang_base_url());
            exit();
        }
        if ($page->visibility == 0) {
            $this->error_404();
        } else {
            $data['title'] = $page->title;
            $data['description'] = $page->description . " - " . $this->app_name;
            $data['keywords'] = $page->keywords . " - " . $this->app_name;
            $data['page'] = $page;
            $data["index_settings"] = get_index_settings();
            $this->load->view('partials/_header', $data);
            $this->load->view('contact', $data);
            $this->load->view('partials/_footer');
        }
    }

    /**
     * Contact Page Post
     */
    public function contact_post()
    {
        post_method();
        //validate inputs
        $this->form_validation->set_rules('name', trans("name"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('email', trans("email_address"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('message', trans("message"), 'required|xss_clean|max_length[5000]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->contact_model->input_values());
            redirect($this->agent->referrer());
        } else {
            if (!$this->recaptcha_verify_request()) {
                $this->session->set_flashdata('form_data', $this->contact_model->input_values());
                $this->session->set_flashdata('error', trans("msg_recaptcha"));
                redirect($this->agent->referrer());
            } else {
                if ($this->contact_model->add_contact_message()) {
                    $this->session->set_flashdata('success', trans("msg_contact_success"));
                    redirect($this->agent->referrer());
                } else {
                    $this->session->set_flashdata('form_data', $this->contact_model->input_values());
                    $this->session->set_flashdata('error', trans("msg_contact_error"));
                    redirect($this->agent->referrer());
                }
            }
        }
    }
    public function any_barter($slug)
    {
        get_method();
        $slug = clean_slug($slug);
        //index page
        if (empty($slug)) {
            redirect(lang_base_url());
        }

        $page = $this->page_model->get_page($slug);
        //if exists
        if (!empty($page)) {
            $this->page($page);
        } else {
            //check category
            $category = $this->category_model->get_parent_category_by_slug($slug);
            if (!empty($category)) {
                $this->category($category);
            } else {
                $this->productbarter($slug);
            }
        }
    }
    public function productbarter($slug)
    {
        get_method();
        $slug = clean_slug($slug);
        $this->comment_limit = 5;

        $data["product"] = $this->product_model->get_product_by_slug($slug);
        $data["barter_product"] = $this->product_model->get_product_by_slug($slug);
        if (empty($data['product'])) {
            $this->error_404();
        } else {
            if ($data['product']->status == 0 || $data['product']->visibility == 0) {
                if (!$this->auth_check) {
                    redirect(lang_base_url());
                }
                if ($data['product']->user_id != $this->auth_user->id && $this->auth_user->role != "admin") {
                    redirect(lang_base_url());
                }
            }
            $data['product_details'] = $this->product_model->get_product_details($data["product"]->id, $this->selected_lang->id, true);
            $data["parent_categories_tree"] = $this->category_model->get_parent_categories_tree($data["product"]->category_id);
            //images
            $data["product_images"] = $this->file_model->get_product_images($data["product"]->id);
            //related products
            $key = "related_products_" . $data["product"]->id;
            $data["related_products"] = get_cached_data($key);
            if (empty($data["related_products"])) {
                $data["related_products"] = $this->product_model->get_related_products($data["product"]->id, $data["product"]->category_id, $data["parent_categories_tree"]);
                set_cache_data($key, $data["related_products"]);
            }

            $data["user"] = $this->auth_model->get_user($data["product"]->user_id);

            //user products
            $key = 'more_products_by_user_' . $data["user"]->id . 'cache';
            $data['user_products'] = get_cached_data($key);
            if (empty($data['user_products'])) {
                $data["user_products"] = $this->product_model->get_user_products($data["user"]->id, $data["product"]->id);
                set_cache_data($key, $data['user_products']);
            }

            $data['reviews'] = $this->review_model->get_reviews($data["product"]->id);
            $data['review_count'] = item_count($data['reviews']);

            $data['comment_count'] = $this->comment_model->get_product_comment_count($data["product"]->id);
            $data['comments'] = $this->comment_model->get_comments($data["product"]->id, $this->comment_limit);
            $data['comment_limit'] = $this->comment_limit;
            $data["custom_fields"] = $this->field_model->get_custom_fields_by_category($data["product"]->category_id);
            $data["half_width_product_variations"] = $this->variation_model->get_half_width_product_variations($data["product"]->id);
            $data["full_width_product_variations"] = $this->variation_model->get_full_width_product_variations($data["product"]->id);
            $data["index_settings"] = get_index_settings();

            $data["video"] = $this->file_model->get_product_video($data["product"]->id);
            $data["audio"] = $this->file_model->get_product_audio($data["product"]->id);

            $data["digital_sale"] = null;
            if ($data["product"]->product_type == 'digital' && $this->auth_check) {
                $data["digital_sale"] = get_digital_sale_by_buyer_id($this->auth_user->id, $data["product"]->id);
            }
            //og tags
            $data['show_og_tags'] = true;
            $data['og_title'] = !empty($data['product_details']->seo_title) ? $data['product_details']->seo_title : $data['product_details']->title;
            $data['og_description'] = $data['product_details']->seo_description;
            $data['og_type'] = "article";
            $data['og_url'] = generate_product_url($data['product']);
            $data['og_image'] = get_product_image($data['product']->id, 'image_default');
            $data['og_width'] = "750";
            $data['og_height'] = "500";
            if (!empty($data['user'])) {
                $data['og_creator'] = $data['user']->username;
                $data['og_author'] = $data['user']->username;
            } else {
                $data['og_creator'] = "";
                $data['og_author'] = "";
            }
            $data['og_published_time'] = $data['product']->created_at;
            $data['og_modified_time'] = $data['product']->created_at;

            $data['title'] = $data['product_details']->title;
            $data['description'] = $data['product_details']->seo_description;
            $data['keywords'] = $data['product_details']->seo_keywords;

            $this->load->view('partials/_header', $data);
            $this->load->view('product/details/product_for_barter', $data);
            $this->load->view('partials/_footer');
            //increase pageviews
            $this->product_model->increase_product_pageviews($data["product"]);
        }
    }
    /**
     * Dynamic Page by Name Slug
     */
    public function any($slug)
    {
        get_method();
        $slug = clean_slug($slug);
        //index page
        if (empty($slug)) {
            redirect(lang_base_url());
        }

        $page = $this->page_model->get_page($slug);
        //if exists
        if (!empty($page)) {
            $this->page($page);
        } else {
            //check category
            $category = $this->category_model->get_parent_category_by_slug($slug);
            if (!empty($category)) {
                $this->category($category);
            } else {
                $this->product($slug);
            }
        }
    }

    /**
     * Product
     */
    public function product_preview($slug)
    {
        get_method();
        $slug = clean_slug($slug);
        $this->comment_limit = 5;

        $data["product"] = $this->product_model->get_product_by_slug($slug);
        $data["similar_products"] = $this->product_model->get_product_category($data["product"]->id);
        $data['diff_prod'] = $this->product_model->get_different_product($data["product"]->id);
        $data["latest_products"] = get_latest_products($this->general_settings->index_latest_products_count);
        if (empty($data['product'])) {
            $this->error_404();
        } else {

            if ($data['product']->status == 0 || $data['product']->visibility == 0) {
                if (!$this->auth_check) {
                    redirect(lang_base_url());
                }
                if ($data['product']->user_id != $this->auth_user->id && $this->auth_user->role != "admin") {
                    redirect(lang_base_url());
                }
            }
            $data['product_details'] = $this->product_model->get_product_details($data["product"]->id, $this->selected_lang->id, true);
            $data["parent_categories_tree"] = $this->category_model->get_parent_categories_tree($data["product"]->category_id);
            //images
            $data["product_images"] = $this->file_model->get_product_images($data["product"]->id);
            //related products
            $key = "related_products_" . $data["product"]->id;
            $data["related_products"] = get_cached_data($key);
            if (empty($data["related_products"])) {
                $data["related_products"] = $this->product_model->get_related_products($data["product"]->id, $data["product"]->category_id, $data["parent_categories_tree"]);
                set_cache_data($key, $data["related_products"]);
            }

            $data["user"] = $this->auth_model->get_user($data["product"]->user_id);

            //user products
            $key = 'more_products_by_user_' . $data["user"]->id . 'cache';
            $data['user_products'] = get_cached_data($key);
            if (empty($data['user_products'])) {
                $data["user_products"] = $this->product_model->get_user_products($data["user"]->id, $data["product"]->id);
                set_cache_data($key, $data['user_products']);
            }


            $data['reviews'] = $this->review_model->get_reviews($data["product"]->id);
            $data['review_count'] = item_count($data['reviews']);

            $data['comment_count'] = $this->comment_model->get_product_comment_count($data["product"]->id);
            $data['comments'] = $this->comment_model->get_comments($data["product"]->id, $this->comment_limit);
            $data['comment_limit'] = $this->comment_limit;
            $data["custom_fields"] = $this->field_model->get_custom_fields_by_category($data["product"]->category_id);
            $data["half_width_product_variations"] = $this->variation_model->get_half_width_product_variations($data["product"]->id);
            $data["full_width_product_variations"] = $this->variation_model->get_full_width_product_variations($data["product"]->id);
            $data["index_settings"] = get_index_settings();

            $data["video"] = $this->file_model->get_product_video($data["product"]->id);
            $data["audio"] = $this->file_model->get_product_audio($data["product"]->id);


            $data["digital_sale"] = null;
            if ($data["product"]->product_type == 'digital' && $this->auth_check) {
                $data["digital_sale"] = get_digital_sale_by_buyer_id($this->auth_user->id, $data["product"]->id);
            }
            //og tags
            $data['show_og_tags'] = true;
            $data['og_title'] = !empty($data['product_details']->seo_title) ? $data['product_details']->seo_title : $data['product_details']->title;
            $data['og_description'] = $data['product_details']->seo_description;
            $data['og_type'] = "article";
            $data['og_url'] = generate_product_url($data['product']);
            $data['og_image'] = get_product_image($data['product']->id, 'image_default');
            $data['og_width'] = "750";
            $data['og_height'] = "500";
            if (!empty($data['user'])) {
                $data['og_creator'] = $data['user']->username;
                $data['og_author'] = $data['user']->username;
            } else {
                $data['og_creator'] = "";
                $data['og_author'] = "";
            }
            $data['og_published_time'] = $data['product']->created_at;
            $data['og_modified_time'] = $data['product']->created_at;

            $data['title'] = $data['product_details']->title;
            $data['description'] = $data['product_details']->seo_description;
            $data['keywords'] = $data['product_details']->seo_keywords;

            $this->load->view('partials/_header', $data);
            $this->load->view('product/details/product_preview', $data);
            $this->load->view('partials/_footer');
            //increase pageviews
            // $this->product_model->increase_product_pageviews($data["product"]);
        }
    }

    public function preview($slug)
    {
        get_method();
        $slug = clean_slug($slug);
        //index page
        if (empty($slug)) {
            redirect(lang_base_url());
        }

        $page = $this->page_model->get_page($slug);
        //if exists
        if (!empty($page)) {
            $this->page($page);
        } else {
            //check category
            $category = $this->category_model->get_parent_category_by_slug($slug);
            if (!empty($category)) {
                $this->category($category);
            } else {
                $this->product_preview($slug);
            }
        }
    }

    /**
     * Page
     */
    private function page($page)
    {
        if (empty($page)) {
            redirect(lang_base_url());
        }
        if ($page->visibility == 0 || !empty($page->page_default_name)) {
            $this->error_404();
        } else {
            $data['title'] = $page->title;
            $data['description'] = $page->description;
            $data['keywords'] = $page->keywords;
            $data['page'] = $page;
            $data["index_settings"] = get_index_settings();
            $this->load->view('partials/_header', $data);
            $this->load->view('page', $data);
            $this->load->view('partials/_footer');
        }
    }

    /**
     * Products
     */
    public function products()
    {
        get_method();
        $data['title'] = trans("products");
        $data['description'] = trans("products") . " - " . $this->app_name;
        $data['keywords'] = trans("products") . "," . $this->app_name;
        $data["index_settings"] = get_index_settings();
        $data['custom_filters'] = $this->field_model->get_custom_filters();
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
        //get paginated posts
        $pagination = $this->paginate(generate_url("products"), $this->product_model->get_paginated_filtered_products_count($data["query_string_array"], null), $this->product_per_page);
        $data['products'] = $this->product_model->get_paginated_filtered_products($data["query_string_array"], null, $pagination['per_page'], $pagination['offset']);
        $data['product_count'] = $this->product_model->get_paginated_filtered_products_count($data["query_string_array"]);
        $data["categories"] = $this->parent_categories;
        $data["all_category_selected"] = $this->product_model->get_category_selected_filters($data["query_string_array"], null, $pagination['per_page'], $pagination['offset'], true);
        $this->load->view('partials/_header', $data);
        $this->load->view('product/products', $data);
        $this->load->view('partials/_footer');
    }


    public function member_products()
    {
        get_method();
        $data['title'] = trans("products");
        $data['description'] = trans("products") . " - " . $this->app_name;
        $data['keywords'] = trans("products") . "," . $this->app_name;
        $data["index_settings"] = get_index_settings();
        $data['custom_filters'] = $this->field_model->get_custom_filters();
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
        //get paginated posts
        $pagination = $this->paginate(generate_url("products"), $this->product_model->get_paginated_filtered_products_count($data["query_string_array"], null), $this->product_per_page);
        $data['products'] = $this->product_model->get_paginated_filtered_products($data["query_string_array"], null, $pagination['per_page'], $pagination['offset']);
        $data['product_count'] = $this->product_model->get_paginated_filtered_products_count($data["query_string_array"]);
        $data["categories"] = $this->parent_categories;

        $this->load->view('partials/_header', $data);
        $this->load->view('product/products', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * top pick Products
     */
    public function top_pick_products()
    {
        get_method();
        $data['title'] = trans("products");
        $data['description'] = trans("products") . " - " . $this->app_name;
        $data['keywords'] = trans("products") . "," . $this->app_name;
        $data["index_settings"] = get_index_settings();
        $data['custom_filters'] = $this->field_model->get_custom_filters();
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
        //get paginated posts
        if (!empty($this->auth_user)) {
            if ($this->auth_user->gender == "Male") {
                $pagination = $this->paginate(generate_url("top_picks_products"), $this->product_model->get_paginated_filtered_products_count_category_feature($data["query_string_array"], null, "MALE"), $this->product_per_page);
                $data["product_count"] = $this->product_model->get_paginated_filtered_products_count_category_feature($data["query_string_array"], null, "MALE");
                $data['products'] = $this->product_model->get_top_pick_products($data["query_string_array"], null, $pagination['per_page'], $pagination['offset'], "MALE");
            } else {
                $pagination = $this->paginate(generate_url("top_picks_products"), $this->product_model->get_paginated_filtered_products_count_category_feature($data["query_string_array"], null, "FEMALE"), $this->product_per_page);
                $data["product_count"] = $this->product_model->get_paginated_filtered_products_count_category_feature($data["query_string_array"], null, "FEMALE");
                $data['products'] = $this->product_model->get_top_pick_products($data["query_string_array"], null, $pagination['per_page'], $pagination['offset'], "FEMALE");
            }
        } else {
            $pagination = $this->paginate(generate_url("products"), $this->product_model->get_paginated_filtered_products_count($data["query_string_array"], null), $this->product_per_page);
            $data['products'] = $this->product_model->get_paginated_filtered_products($data["query_string_array"], null, $pagination['per_page'], $pagination['offset']);
            $data['product_count'] = $this->product_model->get_paginated_filtered_products_count($data["query_string_array"]);
        }
        $data["categories"] = $this->parent_categories;

        $this->load->view('partials/_header', $data);
        $this->load->view('product/products', $data);
        $this->load->view('partials/_footer');
    }

    // categories

    // Single function for categories
    public function top_categories($slug)
    {
        $category = $this->category_model->get_parent_category_by_slug($slug);
        $subcategories = get_subcategories($category->id);

        get_method();
        $data['title'] = !empty($category->title_meta_tag) ? $category->title_meta_tag : $category->name;
        $data['description'] = $category->description;
        $data['keywords'] = $category->keywords;

        $data["category"] = $category;
        $data["subcategories"] = $subcategories;

        $data['custom_filters'] = $this->field_model->get_custom_filters($category->id);
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
        $data["index_settings"] = get_index_settings();

        $limit = 10;
        $offset = 0;
        // $pagination = $this->paginate(generate_category_url($data["category"]), $this->product_model->get_paginated_filtered_products_count($data["query_string_array"], $category->id), $this->product_per_page);
        $data['latest_products'] = $this->product_model->get_paginated_filtered_products($data["query_string_array"], $category->id, $limit, $offset);


        // $data["latest_products"] = get_latest_products($this->general_settings->index_latest_products_count);

        $this->load->view('partials/_header', $data);
        $this->load->view('fashion', $data);
        $this->load->view('partials/_footer');
    }
    //end of single category function


    /*personal_care_page_category*/
    public function personal_care()
    {
        $slug = "personal-care-lifestyle";
        $category = $this->category_model->get_parent_category_by_slug($slug);

        get_method();
        $data['title'] = !empty($category->title_meta_tag) ? $category->title_meta_tag : $category->name;
        $data['description'] = $category->description;
        $data['keywords'] = $category->keywords;

        $data["category"] = $category;

        $data['custom_filters'] = $this->field_model->get_custom_filters($category->id);
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
        $data["index_settings"] = get_index_settings();

        $pagination = $this->paginate(generate_category_url($data["category"]), $this->product_model->get_paginated_filtered_products_count($data["query_string_array"], $category->id), $this->product_per_page);
        $data['latest_products'] = $this->product_model->get_paginated_filtered_products($data["query_string_array"], $category->id, $pagination['per_page'], $pagination['offset']);


        // $data["latest_products"] = get_latest_products($this->general_settings->index_latest_products_count);

        $this->load->view('partials/_header', $data);
        $this->load->view('personal_care', $data);
        $this->load->view('partials/_footer');
    }
    /*end for personal_care*/


    /*groceries category*/
    public function groceries()
    {
        $slug = "grocery";
        $category = $this->category_model->get_parent_category_by_slug($slug);

        get_method();
        $data['title'] = !empty($category->title_meta_tag) ? $category->title_meta_tag : $category->name;
        $data['description'] = $category->description;
        $data['keywords'] = $category->keywords;

        $data["category"] = $category;

        $data['custom_filters'] = $this->field_model->get_custom_filters($category->id);
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
        $data["index_settings"] = get_index_settings();

        $pagination = $this->paginate(generate_category_url($data["category"]), $this->product_model->get_paginated_filtered_products_count($data["query_string_array"], $category->id), $this->product_per_page);
        $data['latest_products'] = $this->product_model->get_paginated_filtered_products($data["query_string_array"], $category->id, $pagination['per_page'], $pagination['offset']);


        // $data["latest_products"] = get_latest_products($this->general_settings->index_latest_products_count);

        $this->load->view('partials/_header', $data);
        $this->load->view('groceries', $data);
        $this->load->view('partials/_footer');
    }
    /*end for groceries*/

    /*home_lifestyles*/
    public function home_lifestyle()
    {
        $slug = "home";
        $category = $this->category_model->get_parent_category_by_slug($slug);

        get_method();
        $data['title'] = !empty($category->title_meta_tag) ? $category->title_meta_tag : $category->name;
        $data['description'] = $category->description;
        $data['keywords'] = $category->keywords;

        $data["category"] = $category;

        $data['custom_filters'] = $this->field_model->get_custom_filters($category->id);
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
        $data["index_settings"] = get_index_settings();

        $pagination = $this->paginate(generate_category_url($data["category"]), $this->product_model->get_paginated_filtered_products_count($data["query_string_array"], $category->id), $this->product_per_page);
        $data['latest_products'] = $this->product_model->get_paginated_filtered_products($data["query_string_array"], $category->id, $pagination['per_page'], $pagination['offset']);


        // $data["latest_products"] = get_latest_products($this->general_settings->index_latest_products_count);

        $this->load->view('partials/_header', $data);
        $this->load->view('home_lifestyle', $data);
        $this->load->view('partials/_footer');
    }
    /*end for home_lifstyles*/



    /*gifts for you*/
    public function gifts_for_you()
    {
        $slug = "gifts-festivities";
        $category = $this->category_model->get_parent_category_by_slug($slug);

        get_method();
        $data['title'] = !empty($category->title_meta_tag) ? $category->title_meta_tag : $category->name;
        $data['description'] = $category->description;
        $data['keywords'] = $category->keywords;

        $data["category"] = $category;

        $data['custom_filters'] = $this->field_model->get_custom_filters($category->id);
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
        $data["index_settings"] = get_index_settings();

        $pagination = $this->paginate(generate_category_url($data["category"]), $this->product_model->get_paginated_filtered_products_count($data["query_string_array"], $category->id), $this->product_per_page);
        $data['latest_products'] = $this->product_model->get_paginated_filtered_products($data["query_string_array"], $category->id, $pagination['per_page'], $pagination['offset']);


        // $data["latest_products"] = get_latest_products($this->general_settings->index_latest_products_count);

        $this->load->view('partials/_header', $data);
        $this->load->view('gifts_for_you', $data);
        $this->load->view('partials/_footer');
    }
    /*end for gifts for you*/




    /*stationary gifts*/
    public function stationery_gifts()
    {
        $slug = "art-stationery";
        $category = $this->category_model->get_parent_category_by_slug($slug);

        get_method();
        $data['title'] = !empty($category->title_meta_tag) ? $category->title_meta_tag : $category->name;
        $data['description'] = $category->description;
        $data['keywords'] = $category->keywords;

        $data["category"] = $category;

        $data['custom_filters'] = $this->field_model->get_custom_filters($category->id);
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
        $data["index_settings"] = get_index_settings();

        $pagination = $this->paginate(generate_category_url($data["category"]), $this->product_model->get_paginated_filtered_products_count($data["query_string_array"], $category->id), $this->product_per_page);
        $data['latest_products'] = $this->product_model->get_paginated_filtered_products($data["query_string_array"], $category->id, $pagination['per_page'], $pagination['offset']);


        // $data["latest_products"] = get_latest_products($this->general_settings->index_latest_products_count);

        $this->load->view('partials/_header', $data);
        $this->load->view('stationery_gifts', $data);
        $this->load->view('partials/_footer');
    }
    /*end for stationery gifts*/

    // home cooks
    public function home_cooks()
    {
        $slug = "home-cooks";
        $category = $this->category_model->get_parent_category_by_slug($slug);

        get_method();
        $data['title'] = !empty($category->title_meta_tag) ? $category->title_meta_tag : $category->name;
        $data['description'] = $category->description;
        $data['keywords'] = $category->keywords;

        $data["category"] = $category;

        $data['custom_filters'] = $this->field_model->get_custom_filters($category->id);
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
        $data["index_settings"] = get_index_settings();

        $pagination = $this->paginate(generate_category_url($data["category"]), $this->product_model->get_paginated_filtered_products_count($data["query_string_array"], $category->id), $this->product_per_page);
        $data['latest_products'] = $this->product_model->get_paginated_filtered_products($data["query_string_array"], $category->id, $pagination['per_page'], $pagination['offset']);


        // $data["latest_products"] = get_latest_products($this->general_settings->index_latest_products_count);

        $this->load->view('partials/_header', $data);
        $this->load->view('home_cooks', $data);
        $this->load->view('partials/_footer');
    }
    /*end for home cooks*/


    // fashion
    // public function fashion()
    // {
    //     $slug = "fashion";
    //     $category = $this->category_model->get_parent_category_by_slug($slug);
    //     $subcategories = get_subcategories($category->id);

    //     get_method();
    //     $data['title'] = !empty($category->title_meta_tag) ? $category->title_meta_tag : $category->name;
    //     $data['description'] = $category->description;
    //     $data['keywords'] = $category->keywords;

    //     $data["category"] = $category;
    //     $data["subcategories"] = $subcategories;

    //     $data['custom_filters'] = $this->field_model->get_custom_filters($category->id);
    //     $data["query_string_array"] = get_query_string_array($data['custom_filters']);
    //     $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
    //     $data["index_settings"] = get_index_settings();

    //     $pagination = $this->paginate(generate_category_url($data["category"]), $this->product_model->get_paginated_filtered_products_count($data["query_string_array"], $category->id), $this->product_per_page);
    //     $data['latest_products'] = $this->product_model->get_paginated_filtered_products($data["query_string_array"], $category->id, $pagination['per_page'], $pagination['offset']);


    //     // $data["latest_products"] = get_latest_products($this->general_settings->index_latest_products_count);

    //     $this->load->view('partials/_header', $data);
    //     $this->load->view('fashion', $data);
    //     $this->load->view('partials/_footer');
    // }
    /*end for fashion*/

    /*kids corner*/
    public function kids_corner()
    {
        $slug = "Kids-corner";
        $category = $this->category_model->get_parent_category_by_slug($slug);

        get_method();
        $data['title'] = !empty($category->title_meta_tag) ? $category->title_meta_tag : $category->name;
        $data['description'] = $category->description;
        $data['keywords'] = $category->keywords;

        $data["category"] = $category;

        $data['custom_filters'] = $this->field_model->get_custom_filters($category->id);
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
        $data["index_settings"] = get_index_settings();

        $pagination = $this->paginate(generate_category_url($data["category"]), $this->product_model->get_paginated_filtered_products_count($data["query_string_array"], $category->id), $this->product_per_page);
        $data['latest_products'] = $this->product_model->get_paginated_filtered_products($data["query_string_array"], $category->id, $pagination['per_page'], $pagination['offset']);


        // $data["latest_products"] = get_latest_products($this->general_settings->index_latest_products_count);

        $this->load->view('partials/_header', $data);
        $this->load->view('kids_corner', $data);
        $this->load->view('partials/_footer');
    }
    /*end for kids corner*/


    // categories_for_mobile

    public function categories_for_mobile()
    {
        get_method();
        $data['title'] = $this->settings->homepage_title;
        $data['description'] = $this->settings->site_description;
        $data['keywords'] = $this->settings->keywords;

        //products
        $data["user_data"] = $this->profile_model->get_vendor_data();
        $data["promoted_products"] = $this->product_model->get_promoted_products_banner();
        $data["latest_products"] = get_latest_products($this->general_settings->index_latest_products_count);
        if (!empty($this->auth_user->id)) {
            if ($this->auth_user->gender == 'Male') {
                $data["top_picks_products"] = $this->product_model->get_category_products(43);
            } else {
                $data["top_picks_products"] = $this->product_model->get_category_products(44);
            }
        } else {
            $data["top_picks_products"] = $this->product_model->get_products_by_pageview();
        }
        // var_dump($data["category_products"]);
        $data["promoted_products"] = get_promoted_products($this->promoted_products_limit, 0);
        $data["promoted_products_count"] = get_promoted_products_count();


        $data["concern_slider_items"] = $this->slider_model->get_slider_item_by_type("CATEGORIES_FOR_MOBILE");
        $data['featured_categories'] = $this->category_model->get_featured_categories();

        $data["index_categories"] = $this->category_model->get_index_categories();
        $data["index_banners_array"] = $this->ad_model->get_index_banners_array();
        $data["special_offers"] = $this->product_model->get_special_offers();
        $data["category_products"] = $this->product_model->get_paginated_filtered_products(null, 1, 10, 0);
        $data["index_settings"] = get_index_settings();
        $register = $this->session->userdata('success');
        if ($register == 'Your account has been created successfully!') {
            $data['success_string'] = 1;
        } else {
            $data['success_string'] = 0;
        }

        //blog slider posts
        $key = "blog_slider_posts_lang_" . $this->selected_lang->id;
        $data["blog_slider_posts"] = get_cached_data($key);
        if (empty($data["blog_slider_posts"])) {
            $data["blog_slider_posts"] = $this->blog_model->get_latest_posts(8);
            set_cache_data($key, $data["blog_slider_posts"]);
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('categories_for_mobile', $data);
        $this->load->view('partials/_footer');
    }
    /*end for categories_for_mobile*/




    /*shop_by_seller_page*/
    public function shop_by_seller()
    {
        get_method();
        $page = $this->page_model->get_page_by_default_name('shop_by_seller', $this->selected_lang->id);
        $data['title'] = $page->title;
        $data['description'] = $page->description . " - " . $this->app_name;
        $data['keywords'] = $page->keywords . " - " . $this->app_name;
        $data['page'] = $page;
        $data["index_settings"] = get_index_settings();

        $data["latest_products"] = get_latest_products($this->general_settings->index_latest_products_count);

        $this->load->view('partials/_header', $data);
        $this->load->view('shop_by_seller', $data);
        $this->load->view('partials/_footer');
    }


    /*end for shop_by_seller*/
    public function shop_by_concern()
    {
        get_method();
        $page = $this->page_model->get_page_by_default_name('shop_by_concern', $this->selected_lang->id);
        $data['title'] = $page->title;
        $data['description'] = $page->description . " - " . $this->app_name;
        $data['keywords'] = $page->keywords . " - " . $this->app_name;
        $data['page'] = $page;
        $data["index_settings"] = get_index_settings();

        $data["latest_products"] = get_latest_products($this->general_settings->index_latest_products_count);

        $this->load->view('partials/_header', $data);
        $this->load->view('shop_by_concern', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Products shop by concern 
     */
    public function products_shop_by_concern($concern_code)
    {
        get_method();
        $data['title'] = trans("products");
        $data['description'] = trans("products") . " - " . $this->app_name;
        $data['keywords'] = trans("products") . "," . $this->app_name;
        $data["index_settings"] = get_index_settings();
        $data['custom_filters'] = $this->field_model->get_custom_filters();
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
        $data["lookup"] = $this->product_model->get_lookup_code(strtoupper($concern_code));
        $data["products_under"] = $data["lookup"]->meaning;
        $type_id = $data["lookup"]->id;
        //get paginated posts
        $pagination = $this->paginate(generate_url("shop_by_concern") . '/' . $concern_code, $this->product_model->get_paginated_filtered_products_count_category_feature($data["query_string_array"], null, $type_id), $this->product_per_page);
        $data['products'] = $this->product_model->get_products_shop_by_concern($data["query_string_array"], null, $pagination['per_page'], $pagination['offset'], $type_id);
        $data['product_count'] = $this->product_model->get_paginated_filtered_products_count_category_feature($data["query_string_array"], null, $type_id);
        $data["categories"] = $this->parent_categories;
        $data['product_count'] = $this->product_model->get_paginated_filtered_products_count_category_feature($data["query_string_array"], null, $type_id);
        $data["categories"] = $this->parent_categories;

        $data["all_category_selected"] = $this->product_model->get_category_selected_concerned_occasion($data["query_string_array"], null, $pagination['per_page'], $pagination['offset'], $type_id, true);


        $this->load->view('partials/_header', $data);
        $this->load->view('product/products', $data);
        $this->load->view('partials/_footer');
    }


    /**
     * Products shop by seller
     */
    public function seller_products($type_id)
    {

        get_method();
        $data['title'] = trans("products");
        $data['description'] = trans("products") . " - " . $this->app_name;
        $data['keywords'] = trans("products") . "," . $this->app_name;
        $data["index_settings"] = get_index_settings();
        $data['custom_filters'] = $this->field_model->get_custom_filters();
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
        $type = $type_id;
        //get paginated posts
        $data['user_categories'] = $this->product_model->get_categories_array_with_products($type_id);
        $pagination = $this->paginate(generate_url("seller_products") . '/' . $type_id, $this->product_model->get_paginated_filtered_products_by_seller($data["query_string_array"], null, $type_id), $this->product_per_page);
        $data['products'] = $this->product_model->get_products_by_seller($data["query_string_array"], null, $pagination['per_page'], $pagination['offset'], $type);
        $data['product_count'] = $this->product_model->get_paginated_filtered_products_by_seller($data["query_string_array"], null, $type_id);
        $data["categories"] = $this->parent_categories;

        $this->load->view('partials/_header', $data);
        $this->load->view('product/products', $data);
        $this->load->view('partials/_footer');
    }


    /**
     * View More Products by category
     */
    public function more_products($type_id)
    {

        get_method();
        $data['title'] = trans("products");
        $data['description'] = trans("products") . " - " . $this->app_name;
        $data['keywords'] = trans("products") . "," . $this->app_name;
        $data["index_settings"] = get_index_settings();
        $data['custom_filters'] = $this->field_model->get_custom_filters();
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
        $type = $type_id;
        //get paginated posts
        $pagination = $this->paginate(generate_url("more_products") . '/' . $type_id, $this->product_model->get_paginated_filtered_products_by_seller($data["query_string_array"], null, $type_id), $this->product_per_page);
        $data['products'] = $this->product_model->get_products_by_category($data["query_string_array"], null, $pagination['per_page'], $pagination['offset'], $type);
        $data['product_count'] = $this->product_model->get_paginated_filtered_products_by_category($data["query_string_array"], null, $type_id);
        $data["categories"] = $this->parent_categories;
        // var_dump($type_id);die();
        $this->load->view('partials/_header', $data);
        $this->load->view('product/products', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Category
     */
    private function category($category)
    {
        if (empty($category)) {
            redirect($this->agent->referrer());
        }

        $data['title'] = !empty($category->title_meta_tag) ? $category->title_meta_tag : $category->name;
        $data['description'] = $category->description;
        $data['keywords'] = $category->keywords;

        $data["category"] = $category;
        $data["parent_category"] = null;
        if ($category->parent_id != 0) {
            $data["parent_category"] = $this->category_model->get_category($category->parent_id);
        }

        $data['custom_filters'] = $this->field_model->get_custom_filters($category->id);
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
        $data["index_settings"] = get_index_settings();
        //get paginated posts
        $pagination = $this->paginate(generate_category_url($data["category"]), $this->product_model->get_paginated_filtered_products_count($data["query_string_array"], $category->id), $this->product_per_page);
        $data['products'] = $this->product_model->get_paginated_filtered_products($data["query_string_array"], $category->id, $pagination['per_page'], $pagination['offset']);
        $data['product_count'] = $this->product_model->get_paginated_filtered_products_count($data["query_string_array"], $category->id);
        $data["parent_categories"] = $this->category_model->get_parent_categories_tree($category->id);

        $this->load->view('partials/_header', $data);
        $this->load->view('product/products', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * SubCategory
     */
    public function subcategory($parent_slug, $slug)
    {
        get_method();
        $slug = clean_slug($slug);
        $category = $this->category_model->get_category_by_slug($slug);
        if (!empty($category)) {
            $this->category($category);
        } else {
            $this->error_404();
        }
    }

    /**
     * Product
     */
    public function product($slug)
    {
        get_method();
        $slug = clean_slug($slug);
        $this->comment_limit = 5;

        $data["product"] = $this->product_model->get_product_by_slug($slug);

        if (empty($data['product'])) {
            $this->error_404();
        } else {

            $data["similar_products"] = $this->product_model->get_product_category($data["product"]->id);
            $data['diff_prod'] = $this->product_model->get_different_product($data["product"]->id);
            // var_dump($data["product"]);
            $data["latest_products"] = get_latest_products($this->general_settings->index_latest_products_count);
            //$data['diff_prod'] = $this->product_model->get_different_product($data["product"]->id);

            if ($data['product']->status == 0 || $data['product']->visibility == 0) {
                if (!$this->auth_check) {
                    redirect(lang_base_url());
                }
                if ($data['product']->user_id != $this->auth_user->id && $this->auth_user->role != "admin") {
                    redirect(lang_base_url());
                }
            }
            $data["similar_products"] = $this->product_model->get_product_category($data["product"]->id);
            $data['diff_prod'] = $this->product_model->get_different_product($data["product"]->id);
            $data["latest_products"] = get_latest_products($this->general_settings->index_latest_products_count);


            $data['product_details'] = $this->product_model->get_product_details($data["product"]->id, $this->selected_lang->id, true);
            $data["parent_categories_tree"] = $this->category_model->get_parent_categories_tree($data["product"]->category_id);
            //images
            $data["product_images"] = $this->file_model->get_product_images($data["product"]->id);
            //related products
            $key = "related_products_" . $data["product"]->id;
            $data["related_products"] = get_cached_data($key);
            if (empty($data["related_products"])) {
                $data["related_products"] = $this->product_model->get_related_products($data["product"]->id, $data["product"]->category_id, $data["parent_categories_tree"]);
                set_cache_data($key, $data["related_products"]);
            }

            $data["user"] = $this->auth_model->get_user($data["product"]->user_id);

            //user products
            $key = 'more_products_by_user_' . $data["user"]->id . 'cache';
            $data['user_products'] = get_cached_data($key);
            if (empty($data['user_products'])) {
                $data["user_products"] = $this->product_model->get_user_products($data["user"]->id, $data["product"]->id);
                set_cache_data($key, $data['user_products']);
            }


            $data['reviews'] = $this->review_model->get_reviews($data["product"]->id);
            $data['reviews_supplier'] = $this->review_model->get_seller_reviews($data["product"]->user_id);

            $data['review_count'] = item_count($data['reviews']);
            $data['review_supplier_count'] = item_count($data['reviews_supplier']);

            $data['comment_count'] = $this->comment_model->get_product_comment_count($data["product"]->id);
            $data['comments'] = $this->comment_model->get_comments($data["product"]->id, $this->comment_limit);
            $data['comment_limit'] = $this->comment_limit;
            $data["custom_fields"] = $this->field_model->get_custom_fields_by_category($data["product"]->category_id);
            $data["half_width_product_variations"] = $this->variation_model->get_half_width_product_variations($data["product"]->id);
            $data["full_width_product_variations"] = $this->variation_model->get_full_width_product_variations($data["product"]->id);
            $data["index_settings"] = get_index_settings();

            $data["video"] = $this->file_model->get_product_video($data["product"]->id);
            $data["audio"] = $this->file_model->get_product_audio($data["product"]->id);





            $data["digital_sale"] = null;
            if ($data["product"]->product_type == 'digital' && $this->auth_check) {
                $data["digital_sale"] = get_digital_sale_by_buyer_id($this->auth_user->id, $data["product"]->id);
            }
            //og tags
            $data['show_og_tags'] = true;
            $data['og_title'] = !empty($data['product_details']->seo_title) ? $data['product_details']->seo_title : $data['product_details']->title;
            $data['og_description'] = $data['product_details']->seo_description;
            $data['og_type'] = "article";
            $data['og_url'] = generate_product_url($data['product']);
            $data['og_image'] = get_product_image($data['product']->id, 'image_default');
            $data['og_width'] = "750";
            $data['og_height'] = "500";
            if (!empty($data['user'])) {
                $data['og_creator'] = $data['user']->username;
                $data['og_author'] = $data['user']->username;
            } else {
                $data['og_creator'] = "";
                $data['og_author'] = "";
            }
            $data['og_published_time'] = $data['product']->created_at;
            $data['og_modified_time'] = $data['product']->created_at;

            $data['title'] = $data['product_details']->title;
            $data['description'] = $data['product_details']->seo_description;
            $data['keywords'] = $data['product_details']->seo_keywords;

            $this->load->view('partials/_header', $data);
            $this->load->view('product/details/product', $data);
            $this->load->view('partials/_footer');
            //increase pageviews
            $this->product_model->increase_product_pageviews($data["product"]);
        }
    }

    /**
     * Load More Promoted Products
     */
    public function load_more_promoted_products()
    {
        post_method();
        $offset = clean_number($this->input->post('offset', true));
        $promoted_products = get_promoted_products($this->promoted_products_limit, $offset);

        $data_json = array(
            'result' => 0,
            'html_content' => "",
            'offset' => $offset + $this->promoted_products_limit,
            'hide_button' => 0,
        );
        $html_content = "";
        if (!empty($promoted_products)) {
            foreach ($promoted_products as $product) {
                $vars = array('product' => $product, 'promoted_badge' => false);
                $html_content .= '<div class="col-6 col-sm-4 col-md-3 col-mds-5 col-product">' . $this->load->view("product/_product_item", $vars, true) . '</div>';
            }
            $data_json['result'] = 1;
            $data_json['html_content'] = $html_content;
            if ($offset + $this->promoted_products_limit >= get_promoted_products_count()) {
                $data_json['hide_button'] = 1;
            }
        }
        echo json_encode($data_json);
    }

    /**
     * Search
     */
    public function search()
    {
        get_method();
        $search = trim($this->input->get('search', TRUE));
        $search_type = $this->input->get('search_type', TRUE);
        //$search = remove_special_characters($search);

        if (empty($search)) {
            redirect(lang_base_url());
        }

        if ($search_type == 'product') {
            redirect(generate_url("products") . '?search=' . $search);
        } else {
            redirect(generate_url("member_products") . '?search=' . $search);
        }
    }

    /**
     * Search by pincode
     */
    public function search_pincode()
    {
        get_method();
        $search = trim($this->input->get('search_pincode', TRUE));

        $user_data = array(
            'modesy_sess_user_location' => $search
        );

        $this->session->set_userdata($user_data);

        redirect($this->agent->referrer());
    }

    /**
     * Members
     */
    public function members()
    {
        get_method();
        $search = trim($this->input->get('search', TRUE));
        $search = remove_special_characters($search);

        if (empty($search)) {
            redirect(lang_base_url());
        }
        //getting all members
        // $data["members"] = $this->profile_model->search_members($search);
        //getting members who are vendors
        $data["members"] = $this->profile_model->search_suppliers($search);
        $data['title'] = $search . " - " . trans("members");
        $data['description'] = $search . " - " . trans("members") . " - " . $this->app_name;
        $data['keywords'] = $search . ", " . trans("members") . "," . $this->app_name;

        $data['filter_search'] = $this->input->get("search");
        $data['search_type'] = "member";
        $data["index_settings"] = get_index_settings();

        $this->load->view('partials/_header', $data);
        $this->load->view('members', $data);
        $this->load->view('partials/_footer');
    }

    public function members_speciality()
    {
        get_method();
        $search = trim($this->input->get('search', TRUE));
        $type = trim($this->input->get('type', TRUE));
        $search = remove_special_characters($search);

        if (empty($search) && empty($type)) {
            redirect(lang_base_url());
        }
        //getting all members
        // $data["members"] = $this->profile_model->search_members($search);
        //getting members who are vendors
        $data["type"] = $type;
        $data["members"] = $this->profile_model->search_suppliers_speciality($type);
        $data['title'] = $search . " - " . trans("members");
        $data['description'] = $search . " - " . trans("members") . " - " . $this->app_name;
        $data['keywords'] = $search . ", " . trans("members") . "," . $this->app_name;


        $data['filter_search'] = $this->input->get("search");
        $data['search_type'] = "member";
        $data["index_settings"] = get_index_settings();

        $this->load->view('partials/_header', $data);
        $this->load->view('members', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Select Membership Plan
     */
    public function select_membership_plan()
    {
        get_method();
        if ($this->general_settings->membership_plans_system != 1) {
            redirect(lang_base_url());
            exit();
        }
        //check auth
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        if ($this->general_settings->email_verification == 1 && $this->auth_user->email_status != 1) {
            $this->session->set_flashdata('error', trans("msg_confirmed_required"));
            redirect(generate_url("settings", "update_profile"));
        }
        if ($this->auth_user->is_active_shop_request == 1) {
            redirect(generate_url("start_selling"));
        }
        $data['title'] = trans("select_your_plan");
        $data['description'] = trans("select_your_plan") . " - " . $this->app_name;
        $data['keywords'] = trans("select_your_plan") . "," . $this->app_name;
        $data['request_type'] = "new";
        $data["membership_plans"] = $this->membership_model->get_plans();
        $data["index_settings"] = get_index_settings();
        $data['user_current_plan'] = $this->membership_model->get_user_plan_by_user_id($this->auth_user->id);
        $data['user_ads_count'] = $this->membership_model->get_user_ads_count($this->auth_user->id);

        $this->load->view('partials/_header', $data);
        $this->load->view('product/select_membership_plan', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Start Selling
     */
    public function start_selling()
    {
        get_method();
        //check auth
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        if (is_user_vendor()) {
            redirect(lang_base_url());
        }
        if ($this->general_settings->email_verification == 1 && $this->auth_user->email_status != 1) {
            $this->session->set_flashdata('error', trans("msg_confirmed_required"));
            redirect(generate_url("settings", "update_profile"));
        }

        $data['title'] = trans("start_selling");
        $data['description'] = trans("start_selling") . " - " . $this->app_name;
        $data['keywords'] = trans("start_selling") . "," . $this->app_name;
        $data["index_settings"] = get_index_settings();
        if ($this->general_settings->membership_plans_system == 1) {
            if ($this->auth_user->is_active_shop_request != 1) {
                $plan_id = clean_number(input_get('plan'));
                if (empty($plan_id)) {
                    redirect(generate_url("select_membership_plan"));
                    exit();
                }
                $data['plan'] = $this->membership_model->get_plan($plan_id);
                if (empty($data['plan'])) {
                    redirect(generate_url("select_membership_plan"));
                    exit();
                }
            }
        }

        // $data["states"] = $this->location_model->get_states_by_country($this->auth_user->country_id);
        // $data["cities"] = $this->location_model->get_cities_by_state($this->auth_user->state_id);

        $this->load->view('partials/_header', $data);
        $this->load->view('product/start_selling', $data);
        $this->load->view('partials/_footer');
    }

    public function getindiacities()
    {
        $this->load->view('partials/ajaxhandler_cities');
    }


    /**
     * Start Selling Post for physical goods
     */
    public function start_selling_post()
    {
        post_method();
        //check auth
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        $data = array(
            'supplier_type' => $this->input->post('supplier_type', true),
            'shop_name' => remove_special_characters($this->input->post('shop_name', true)),
            'supplier_type_goods' => $this->input->post('supplier_type_goods', true),
            'company_type' => remove_special_characters($this->input->post('company_type', true)),
            'other_type' => $this->input->post('other_type', true),
            'area_in_operation' => $this->input->post('area_in_operation', true),
            'alternative_number' => $this->input->post('alternative_number', true),
            'house_no' => $this->input->post('house_no', true),
            'landmark' => $this->input->post('landmark', true),
            'pincode' => $this->input->post('pincode', true),
            'anniversary' => $this->input->post('anniversary', true),
            'other_selling_platforms' => $this->input->post('other_platforms', true),
            'share' => $this->input->post('share', true),
            'first_name' => $this->input->post('first_name', true),
            'last_name' => $this->input->post('last_name', true),
            'phone_number' => $this->input->post('phone_number', true),
            'middle_name' => $this->input->post('middle_name', true),
            'landline' => $this->input->post('landline_number', true),
            'supplier_area' => $this->input->post('area', true),
            'supplier_state' => $this->input->post('supplier_state', true),
            'supplier_city' => $this->input->post('supplier_city', true),
            'about_me' => $this->input->post('about_me', true),
            // 'geography_locations' => $this->input->post('ajax_cities', true),
            'fssai_number' => $this->input->post('fssai_number', true),
            'gst_application_number' => $this->input->post('gst_application_number', true),
            'trademark_yes_no' => $this->input->post('trademark_yes_no', true),
            'gst_number' => $this->input->post('gst_number', true),
            'pan_number' => $this->input->post('pan_number', true),
            'image_pancard' => $this->input->post('pan_photo', true),
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
            'usp' => $this->input->post('usp_goods', true),
            'turnover' => $this->input->post('turnover', true),
            'have_gst' => $this->input->post('gst_yes_no', true),
            'active_customer' => $this->input->post('active_customers', true),
            'selling_exempted_goods' => $this->input->post('selling_exempted_goods', true),


            // 'avg_revenue' => $this->input->post('avg_revenue', true),
            'is_active_shop_request' => 1
        );

        if ($data["have_gst"] == "N") {
            $data["type_of_goods"] = $this->input->post('type_of_goods', true);
        }
        $data['image_pancard'] = "data:image/png;base64," . (trim($data['image_pancard'], "[removed]"));

        //unique seller id
        $data["seller_unique_id"] = $this->auth_model->unique_seller_id($this->auth_user->id, $data);

        if ($this->auth_user->gender == "" || $this->auth_user->date_of_birth == "") {
            $data["gender"] = $this->input->post('gender', true);
            $data["date_of_birth"] = $this->input->post('date_of_birth', true);
        }

        //is shop name unique
        // if (!$this->auth_model->is_unique_shop_name($data['shop_name'], $this->auth_user->id)) {
        //     $this->session->set_flashdata('form_data', $data);
        //     $this->session->set_flashdata('error', trans("msg_shop_name_unique_error"));
        //     redirect($this->agent->referrer());
        // }

        if ($this->general_settings->membership_plans_system == 1) {
            $plan_id = clean_number($this->input->post('plan_id', true));
            if (empty($plan_id)) {
                redirect(generate_url("select_membership_plan"));
                exit();
            }
            $plan = $this->membership_model->get_plan($plan_id);
            if (empty($plan)) {
                redirect(generate_url("select_membership_plan"));
                exit();
            }
            if ($plan->is_free == 1) {
                if ($this->membership_model->add_shop_opening_requests($data)) {
                    $this->membership_model->add_user_free_plan($plan, $this->auth_user->id);
                    redirect(generate_url("start_selling"));
                    exit();
                } else {
                    $this->session->set_flashdata('error', trans("msg_error"));
                    redirect($this->agent->referrer());
                }
            } else {
                $data['is_active_shop_request'] = 0;
                if ($this->membership_model->add_shop_opening_requests($data)) {
                    //go to checkout
                    $this->session->set_userdata('Gharobar_selected_membership_plan_id', $plan->id);
                    $this->session->set_userdata('Gharobar_membership_request_type', "new");
                    redirect(generate_url("cart", "payment_method") . "?payment_type=membership");
                } else {
                    $this->session->set_flashdata('error', trans("msg_error"));
                    redirect($this->agent->referrer());
                }
            }
        } else {
            if ($this->membership_model->add_shop_opening_requests($data)) {
                //send email
                $this->membership_model->send_shop_opening_email();
                //send email to supplier after registration
                $this->load->model("email_model");
                $this->session->set_flashdata('submit', "send_email");
                if (!empty($this->auth_user->email)) {
                    if (!$this->email_model->send_supplier_reg_email($this->auth_user->email, $this->auth_user->first_name)) {
                        redirect($this->agent->referrer());
                        exit();
                    }
                    $this->session->set_flashdata('success', trans("msg_email_sent"));
                } else {
                    $this->session->set_flashdata('error', trans("msg_error"));
                }
                // if (!empty(get_content('admin_email'))) {
                //     if (!$this->email_model->send_supplier_reg_email_to_admin(get_content('admin_email'))) {
                //         redirect($this->agent->referrer());
                //         exit();
                //     }
                //     $this->session->set_flashdata('success', trans("msg_email_sent"));
                // } else {
                //     $this->session->set_flashdata('error', trans("msg_error"));
                // }
                $this->session->set_flashdata('success', trans("msg_start_selling"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }



    /**                                          
     * Start Selling Post for services
     */

    public function start_selling_services()
    {
        post_method();
        //check auth
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        $data = array(
            'supplier_type' => "Services",

            'shop_name' => remove_special_characters($this->input->post('company_name', true)),
            'company_type' => $this->input->post('company_type', true),
            'supplier_type_services' => remove_special_characters($this->input->post('supplier_type_services', true)),
            'education_type' => $this->input->post('education_type', true),
            'creative_type' => $this->input->post('creative_type', true),
            'other_service_type' => $this->input->post('other_service_type', true),
            'area_in_operation' => $this->input->post('area_in_operation', true),
            'alternative_number' => $this->input->post('alternative_number', true),
            'house_no' => $this->input->post('house_no', true),
            'landmark' => $this->input->post('landmark', true),
            'pincode' => $this->input->post('pincode1', true),
            'anniversary' => $this->input->post('anniversary', true),
            'originally_belongs' => $this->input->post('originally_belongs', true),
            'share' => $this->input->post('share', true),
            'first_name' => $this->input->post('first_name', true),
            'last_name' => $this->input->post('last_name', true),
            'phone_number' => $this->input->post('phone_number', true),
            'middle_name' => $this->input->post('middle_name', true),
            'landline' => $this->input->post('landline_number', true),
            'supplier_area' => $this->input->post('area', true),
            'supplier_state' => $this->input->post('supplier_state1', true),
            'supplier_city' => $this->input->post('supplier_city1', true),
            //'about_me' => $this->input->post('about_me', true),
            'about_me' => $this->input->post('details_spec', true),
            'gst_number' => $this->input->post('gst_number1', true),
            'pan_number' => $this->input->post('pan_number1', true),
            'adhaar_number' => $this->input->post('adhaar_number', true),
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
            'image_pancard' => $this->input->post('pan_photo1', true),
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

            'is_active_shop_request' => 1
        );
        $data['image_pancard'] = "data:image/png;base64," . (trim($data['image_pancard'], "[removed]"));

        //unique seller id
        $data["seller_unique_id"] = $this->auth_model->unique_seller_id($this->auth_user->id);
        if ($this->auth_user->gender == "" || $this->auth_user->date_of_birth == "") {
            $data["gender"] = $this->input->post('gender', true);
            $data["date_of_birth"] = $this->input->post('date_of_birth', true);
        }

        //is shop name unique
        if (!$this->auth_model->is_unique_shop_name($data['shop_name'], $this->auth_user->id)) {
            $this->session->set_flashdata('form_data', $data);
            $this->session->set_flashdata('error', trans("msg_shop_name_unique_error"));
            redirect($this->agent->referrer());
        }

        if ($this->general_settings->membership_plans_system == 1) {
            $plan_id = clean_number($this->input->post('plan_id', true));
            if (empty($plan_id)) {
                redirect(generate_url("select_membership_plan"));
                exit();
            }
            $plan = $this->membership_model->get_plan($plan_id);
            if (empty($plan)) {
                redirect(generate_url("select_membership_plan"));
                exit();
            }
            if ($plan->is_free == 1) {
                if ($this->membership_model->add_shop_opening_requests($data)) {
                    $this->membership_model->add_user_free_plan($plan, $this->auth_user->id);
                    redirect(generate_url("start_selling"));
                    exit();
                } else {
                    $this->session->set_flashdata('error', trans("msg_error"));
                    redirect($this->agent->referrer());
                }
            } else {
                $data['is_active_shop_request'] = 0;
                if ($this->membership_model->add_shop_opening_requests($data)) {
                    //go to checkout
                    $this->session->set_userdata('Gharobar_selected_membership_plan_id', $plan->id);
                    $this->session->set_userdata('Gharobar_membership_request_type', "new");
                    redirect(generate_url("cart", "payment_method") . "?payment_type=membership");
                } else {
                    $this->session->set_flashdata('error', trans("msg_error"));
                    redirect($this->agent->referrer());
                }
            }
        } else {
            if ($this->membership_model->add_shop_opening_requests($data)) {
                //send email
                $this->membership_model->send_shop_opening_email();
                $this->load->model("email_model");
                $this->session->set_flashdata('submit', "send_email");
                if (!empty($this->auth_user->email)) {
                    if (!$this->email_model->send_supplier_reg_email($this->auth_user->email, $this->auth_user->first_name)) {
                        redirect($this->agent->referrer());
                        exit();
                    }
                    $this->session->set_flashdata('success', trans("msg_email_sent"));
                } else {
                    $this->session->set_flashdata('error', trans("msg_error"));
                }
                $this->session->set_flashdata('success', trans("msg_start_selling"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Renew Membership Plan
     */
    public function renew_membership_plan()
    {
        get_method();
        if ($this->general_settings->membership_plans_system != 1) {
            redirect(lang_base_url());
            exit();
        }
        if (!is_user_vendor()) {
            redirect(lang_base_url());
        }
        if ($this->general_settings->email_verification == 1 && $this->auth_user->email_status != 1) {
            $this->session->set_flashdata('error', trans("msg_confirmed_required"));
            redirect(generate_url("settings", "update_profile"));
        }
        $data['title'] = trans("select_your_plan");
        $data['description'] = trans("select_your_plan") . " - " . $this->app_name;
        $data['keywords'] = trans("select_your_plan") . "," . $this->app_name;
        $data['request_type'] = "renew";
        $data["membership_plans"] = $this->membership_model->get_plans();
        $data["index_settings"] = get_index_settings();
        $data['user_current_plan'] = $this->membership_model->get_user_plan_by_user_id($this->auth_user->id);
        $data['user_ads_count'] = $this->membership_model->get_user_ads_count($this->auth_user->id);

        $this->load->view('partials/_header', $data);
        $this->load->view('product/select_membership_plan', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Renew Membership Plan Post
     */
    public function renew_membership_plan_post()
    {
        post_method();
        if (!is_user_vendor()) {
            redirect(lang_base_url());
        }
        if ($this->general_settings->email_verification == 1 && $this->auth_user->email_status != 1) {
            $this->session->set_flashdata('error', trans("msg_confirmed_required"));
            redirect(generate_url("settings", "update_profile"));
        }
        $plan_id = $this->input->post('plan_id');
        if (empty($plan_id)) {
            redirect($this->agent->referrer());
            exit();
        }
        $plan = $this->membership_model->get_plan($plan_id);
        if (empty($plan)) {
            redirect($this->agent->referrer());
            exit();
        }

        if ($plan->is_free == 1) {
            $this->membership_model->add_user_free_plan($plan, $this->auth_user->id);
            redirect(generate_dash_url("shop_settings"));
            exit();
        }

        $this->session->set_userdata('Gharobar_selected_membership_plan_id', $plan->id);
        $this->session->set_userdata('Gharobar_membership_request_type', "renew");
        redirect(generate_url("cart", "payment_method") . "?payment_type=membership");
    }


    /*
    *-------------------------------------------------------------------------------------------------
    * BLOG PAGES
    *-------------------------------------------------------------------------------------------------
    */

    /**
     * Blog
     */
    public function blog()
    {
        get_method();
        $page = $this->page_model->get_page_by_default_name('blog', $this->selected_lang->id);
        if (empty($page)) {
            redirect(lang_base_url());
            exit();
        }
        if ($page->visibility == 0) {
            $this->error_404();
        } else {
            $data['title'] = $page->title;
            $data['description'] = $page->description;
            $data['keywords'] = $page->keywords;
            $data["active_category"] = "all";
            $data["index_settings"] = get_index_settings();
            $key = "blog_posts_count_lang_" . $this->selected_lang->id;
            $blog_posts_count = get_cached_data($key);
            if (empty($blog_posts_count)) {
                $blog_posts_count = $this->blog_model->get_posts_count();
                set_cache_data($key, $blog_posts_count);
            }

            //set pagination
            $pagination = $this->paginate(generate_url("blog"), $blog_posts_count, $this->blog_paginate_per_page);
            $key = 'blog_posts_lang_' . $this->selected_lang->id . '_page_' . $pagination['current_page'];
            $data['posts'] = get_cached_data($key);
            if (empty($data['posts'])) {
                $data['posts'] = $this->blog_model->get_paginated_posts($pagination['offset'], $pagination['per_page']);
                set_cache_data($key, $data['posts']);
            }

            $this->load->view('partials/_header', $data);
            $this->load->view('blog/index', $data);
            $this->load->view('partials/_footer');
        }
    }

    /**
     * Blog Category
     */
    public function blog_category($slug)
    {
        get_method();
        $slug = clean_slug($slug);
        $data["category"] = $this->blog_category_model->get_category_by_slug($slug);

        if (empty($data["category"])) {
            redirect(generate_url("blog"));
        }

        $data['title'] = $data["category"]->name;
        $data['description'] = $data["category"]->description;
        $data['keywords'] = $data["category"]->keywords;
        $data["active_category"] = $data["category"]->slug;
        $key = "blog_category_" . $data["category"]->id . "_posts_count_lang_" . $this->selected_lang->id;
        $data["index_settings"] = get_index_settings();
        $blog_posts_count = get_cached_data($key);
        if (empty($blog_posts_count)) {
            $blog_posts_count = count($this->blog_model->get_posts_by_category($data["category"]->id));
            set_cache_data($key, $blog_posts_count);
        }

        //set pagination
        $pagination = $this->paginate(generate_url("blog") . '/' . $data["category"]->slug, $blog_posts_count, $this->blog_paginate_per_page);
        $key = 'blog_category_' . $data["category"]->id . 'posts_lang_' . $this->selected_lang->id . '_page_' . $pagination['current_page'];
        $data['posts'] = get_cached_data($key);
        if (empty($data['posts'])) {
            $data['posts'] = $this->blog_model->get_paginated_category_posts($pagination['offset'], $pagination['per_page'], $data["category"]->id);
            set_cache_data($key, $data['posts']);
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('blog/index', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Tag
     */
    public function tag($slug)
    {
        get_method();
        $slug = clean_slug($slug);
        $data['tag'] = $this->tag_model->get_post_tag($slug);

        if (empty($data['tag'])) {
            redirect(generate_url("blog"));
        }

        $data['title'] = $data['tag']->tag;
        $data['description'] = trans("tag") . ": " . $data['tag']->tag . " - " . $this->app_name;
        $data['keywords'] = trans("tag") . "," . $data['tag']->tag . "," . $this->app_name;
        $data["index_settings"] = get_index_settings();
        //get paginated posts
        $pagination = $this->paginate(generate_url("blog", "tag") . "/" . $data['tag']->tag_slug, $this->blog_model->get_paginated_tag_posts_count($data['tag']->tag_slug), $this->blog_paginate_per_page);
        $data['posts'] = $this->blog_model->get_paginated_tag_posts($pagination['offset'], $pagination['per_page'], $data['tag']->tag_slug);

        $this->load->view('partials/_header', $data);
        $this->load->view('blog/tag', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Post
     */
    public function post($category_slug, $slug)
    {
        get_method();
        $slug = clean_slug($slug);
        $data["post"] = $this->blog_model->get_post_by_slug($slug);

        if (empty($data["post"])) {
            redirect(generate_url("blog"));
        }

        $data['title'] = $data["post"]->title;
        $data['description'] = $data["post"]->summary;
        $data['keywords'] = $data["post"]->keywords;

        $data['related_posts'] = $this->blog_model->get_related_posts($data['post']->category_id, $data["post"]->id);
        $data['latest_posts'] = $this->blog_model->get_latest_posts(3);
        $data['random_tags'] = $this->tag_model->get_random_post_tags();
        $data['post_tags'] = $this->tag_model->get_post_tags($data["post"]->id);
        $data['comments'] = $this->comment_model->get_blog_comments($data["post"]->id, $this->comment_limit);
        $data['comments_count'] = $this->comment_model->get_blog_comment_count($data["post"]->id);
        $data['comment_limit'] = $this->comment_limit;
        $data['post_user'] = $this->auth_model->get_user($data['post']->user_id);
        $data["category"] = $this->blog_category_model->get_category($data['post']->category_id);

        //og tags
        $data['show_og_tags'] = true;
        $data['og_title'] = $data['post']->title;
        $data['og_description'] = $data['post']->summary;
        $data['og_type'] = "article";
        $data['og_url'] = generate_url("blog") . "/" . $data['post']->category_slug . "/" . $data['post']->slug;
        $data['og_image'] = get_blog_image_url($data['post'], 'image_default');
        $data['og_width'] = "750";
        $data['og_height'] = "500";
        $data["index_settings"] = get_index_settings();
        if (!empty($data['post_user'])) {
            $data['og_creator'] = $data['post_user']->username;
            $data['og_author'] = $data['post_user']->username;
        } else {
            $data['og_creator'] = "";
            $data['og_author'] = "";
        }
        $data['og_published_time'] = $data['post']->created_at;
        $data['og_modified_time'] = $data['post']->created_at;
        $data['og_tags'] = $data['post_tags'];

        $this->load->view('partials/_header', $data);
        $this->load->view('blog/post', $data);
        $this->load->view('partials/_footer');
    }


    /**
     * Terms & Conditions
     */
    public function terms_conditions()
    {
        get_method();
        $page = $this->page_model->get_page_by_default_name('terms_conditions', $this->selected_lang->id);
        if (empty($page)) {
            redirect(lang_base_url());
            exit();
        }
        if ($page->visibility == 0) {
            $this->error_404();
        } else {
            $data['title'] = $page->title;
            $data['description'] = $page->description . " - " . $this->app_name;
            $data['keywords'] = $page->keywords . " - " . $this->app_name;
            $data['page'] = $page;

            $this->load->view('partials/_header', $data);
            $this->load->view('page', $data);
            $this->load->view('partials/_footer');
        }
    }
    // career/////
    public function career()
    {
        get_method();
        $page = $this->page_model->get_page_by_default_name('career', $this->selected_lang->id);
        if (empty($page)) {
            redirect(lang_base_url());
            exit();
        }
        if ($page->visibility == 0) {
            $this->error_404();
        } else {
            $data['title'] = $page->title;
            $data['description'] = $page->description . " - " . $this->app_name;
            $data['keywords'] = $page->keywords . " - " . $this->app_name;
            $data['page'] = $page;
            $data["index_settings"] = get_index_settings();
            $this->load->view('partials/_header', $data);
            $this->load->view('career', $data);
            $this->load->view('partials/_footer');
        }
    }



    // about_us////

    public function aboutus()
    {
        get_method();
        $page = $this->page_model->get_page_by_default_name('aboutus', $this->selected_lang->id);
        $data['title'] = $page->title;
        $data['description'] = $page->description . " - " . $this->app_name;
        $data['keywords'] = $page->keywords . " - " . $this->app_name;
        $data['page'] = $page;
        $data["index_settings"] = get_index_settings();
        $this->load->view('partials/_header', $data);
        $this->load->view('aboutus', $data);
        $this->load->view('partials/_footer');
    }
    //shipping_policy///

    public function shipping_policy()
    {
        get_method();
        $page = $this->page_model->get_page_by_default_name('shipping_policy', $this->selected_lang->id);
        $data['title'] = $page->title;
        $data['description'] = $page->description . " - " . $this->app_name;
        $data['keywords'] = $page->keywords . " - " . $this->app_name;
        $data['page'] = $page;
        $data["index_settings"] = get_index_settings();
        $this->load->view('partials/_header', $data);
        $this->load->view('shipping_policy', $data);
        $this->load->view('partials/_footer');
    }

    //blogs//
    public function user_blog()
    {
        get_method();
        $page = $this->page_model->get_page_by_default_name('user_blog', $this->selected_lang->id);
        $data['title'] = $page->title;
        $data['description'] = $page->description . " - " . $this->app_name;
        $data['keywords'] = $page->keywords . " - " . $this->app_name;
        $data['page'] = $page;
        $data["index_settings"] = get_index_settings();
        $this->load->view('partials/_header', $data);
        $this->load->view('user_blog', $data);
        $this->load->view('partials/_footer');
    }
    //user_blog_1//
    public function user_blog_1()
    {
        get_method();
        $page = $this->page_model->get_page_by_default_name('user_blog_1', $this->selected_lang->id);
        $data['title'] = $page->title;
        $data['description'] = $page->description . " - " . $this->app_name;
        $data['keywords'] = $page->keywords . " - " . $this->app_name;
        $data['page'] = $page;
        $data["index_settings"] = get_index_settings();
        $this->load->view('partials/_header', $data);
        $this->load->view('user_blog_1', $data);
        $this->load->view('partials/_footer');
    }
    //user_blog_2//
    public function user_blog_2()
    {
        get_method();
        $page = $this->page_model->get_page_by_default_name('user_blog_2', $this->selected_lang->id);
        $data['title'] = $page->title;
        $data['description'] = $page->description . " - " . $this->app_name;
        $data['keywords'] = $page->keywords . " - " . $this->app_name;
        $data['page'] = $page;
        $data["index_settings"] = get_index_settings();
        $this->load->view('partials/_header', $data);
        $this->load->view('user_blog_2', $data);
        $this->load->view('partials/_footer');
    }

    public function privacy()
    {
        get_method();
        $page = $this->page_model->get_page_by_default_name('privacy', $this->selected_lang->id);
        $data['title'] = $page->title;
        $data['description'] = $page->description . " - " . $this->app_name;
        $data['keywords'] = $page->keywords . " - " . $this->app_name;
        $data['page'] = $page;
        $data["index_settings"] = get_index_settings();
        $this->load->view('partials/_header', $data);
        $this->load->view('privacy', $data);
        $this->load->view('partials/_footer');
    }


    //Return and exchange///
    public function return_and_exchange()
    {
        get_method();
        $page = $this->page_model->get_page_by_default_name('return_and_exchange', $this->selected_lang->id);
        $data['title'] = $page->title;
        $data['description'] = $page->description . " - " . $this->app_name;
        $data['keywords'] = $page->keywords . " - " . $this->app_name;
        $data['page'] = $page;
        $data["index_settings"] = get_index_settings();
        $this->load->view('partials/_header', $data);
        $this->load->view('return_and_exchange', $data);
        $this->load->view('partials/_footer');
    }

    //Shop By Occasion///
    public function shop_by_occasion()
    {
        get_method();
        $page = $this->page_model->get_page_by_default_name('shop_by_occasion', $this->selected_lang->id);
        $data['title'] = $page->title;
        $data['description'] = $page->description . " - " . $this->app_name;
        $data['keywords'] = $page->keywords . " - " . $this->app_name;
        $data['page'] = $page;
        $data["index_settings"] = get_index_settings();
        $data["latest_products"] = get_latest_products($this->general_settings->index_latest_products_count);
        $this->load->view('partials/_header', $data);
        $this->load->view('shop_by_occasion', $data);
        $this->load->view('partials/_footer');
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * REVIEWS
    *-------------------------------------------------------------------------------------------------
    */

    /**
     * Add Review
     */
    public function add_review_post()
    {
        if ($this->auth_check && $this->general_settings->reviews == 1) {
            $rating = $this->input->post('rating', true);
            $product_id = $this->input->post('product_id', true);
            $review_text = $this->input->post('review', true);
            $product = $this->product_model->get_product_by_id($product_id);
            if ($product->user_id != $this->auth_user->id) {
                $review = $this->review_model->get_review($product_id, $this->auth_user->id);
                if (!empty($review)) {
                    $this->review_model->update_review($review->id, $rating, $product_id, $review_text);
                } else {
                    $this->review_model->add_review($rating, $product_id, $review_text);
                }
            }
        }
        redirect($this->agent->referrer());
    }

    /**
     * Delete Review
     */
    public function delete_review()
    {
        $id = $this->input->post('id', true);
        $product_id = $this->input->post('product_id', true);
        $user_id = $this->input->post('user_id', true);
        $limit = $this->input->post('limit', true);

        $review = $this->review_model->get_review($product_id, $user_id);
        if ($this->auth_check && !empty($review)) {
            if ($this->auth_user->role == "admin" || $this->auth_user->id == $review->user_id) {
                $this->review_model->delete_review($id, $product_id);
            }
        }

        $data["product"] = $this->product_model->get_product_by_id($product_id);
        $data["reviews"] = $this->review_model->get_limited_reviews($product_id, $limit);

        $this->load->view('product/details/_make_review', $data);
    }

    /**
     * Guest Wishlist
     */
    public function guest_wishlist()
    {
        $data['title'] = trans("wishlist");
        $data['description'] = trans("wishlist") . " - " . $this->app_name;
        $data['keywords'] = trans("wishlist") . "," . $this->app_name;

        //set pagination
        $pagination = $this->paginate(generate_url("wishlist"), $this->product_model->get_guest_wishlist_products_count(), $this->product_per_page);
        $data['products'] = $this->product_model->get_paginated_guest_wishlist_products($pagination['per_page'], $pagination['offset']);

        $this->load->view('partials/_header', $data);
        $this->load->view('guest_wishlist', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Unsubscribe
     */
    public function unsubscribe()
    {
        $data['title'] = trans("unsubscribe");
        $data['description'] = trans("unsubscribe");
        $data['keywords'] = trans("unsubscribe");

        $token = $this->input->get("token");
        $token = remove_special_characters($token);
        $subscriber = $this->newsletter_model->get_subscriber_by_token($token);

        if (empty($subscriber)) {
            redirect(lang_base_url());
        }
        $this->newsletter_model->unsubscribe_email($subscriber->email);

        $this->load->view('partials/_header', $data);
        $this->load->view('unsubscribe');
        $this->load->view('partials/_footer');
    }

    /**
     * Add to Subscribers
     */
    public function add_to_subscribers()
    {
        //input values
        $email = $this->input->post('email', true);

        if ($email) {
            //check if email exists
            if (empty($this->newsletter_model->get_subscriber($email))) {
                //addd
                if ($this->newsletter_model->add_to_subscribers($email)) {
                    $this->session->set_flashdata('news_success', trans("msg_newsletter_success"));

                    $response_data = array(
                        'status' => '1',
                        'message' => trans("msg_newsletter_success")
                    );
                }
            } else {
                $this->session->set_flashdata('news_error', trans("msg_newsletter_error"));
                $response_data = array(
                    'status' => '0',
                    'message' => trans("msg_newsletter_error")
                );
            }
        }
        echo json_encode($response_data);
    }

    public function cookies_warning()
    {
        setcookie('Gharobar_cookies_warning', '1', time() + (86400 * 10), "/"); //10 days
    }

    public function set_default_location()
    {
        $this->location_model->set_default_location();
        redirect($this->agent->referrer());
    }

    public function error_404()
    {
        get_method();
        header("HTTP/1.0 404 Not Found");
        $data['title'] = "Error 404";
        $data['description'] = "Error 404";
        $data['keywords'] = "error,404";

        $this->load->view('partials/_header', $data);
        $this->load->view('errors/error_404');
        $this->load->view('partials/_footer');
    }

    public function dispdata()
    {
        $result['data'] = $this->auth_model->display_records();
        $this->load->view('display_records', $result);
    }
    public function get_uploaded_image()
    {

        $image_id = $this->input->post('image_id', true);
        $product_image = $this->file_model->get_image($image_id);
        if (!empty($product_image)) {
            echo '<img src="' . get_product_image_url($product_image, 'image_small') . '" alt="">';
        }
    }

    /* shiprocket unique generate*/

    public function shiprocket()
    {
        $curl = curl_init();
        $shiprocket_login = "sellerhelp@gharobaar.com";
        $shiprocket_password = "Gharobaar@admin1";

        $cred_array = array(
            "email" => $shiprocket_login,
            "password" => $shiprocket_password
        );


        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/auth/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($cred_array),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        // var_dump($status);

        curl_close($curl);

        $user_data = array(
            'modesy_sess_user_shiprocket_token' => json_decode($response)->token
        );
        $this->session->set_userdata($user_data);
    }

    public function products_in_stock($user_id)
    {
        $data['title'] = trans("products");
        $data['products'] = $this->product_model->avaiable_now($user_id, 'active');
        $data['main_settings'] = get_main_settings();

        $this->load->view('profile/_product_section_ajax', $data);
    }

    //sort according to highest_discount products
    public function highest_discount_products($user_id)
    {
        $data['title'] = trans("products");
        $data['products'] = $this->product_model->get_better_discount_products($user_id, 'active');
        $data['main_settings'] = get_main_settings();

        $this->load->view('profile/_product_section_ajax', $data);
    }

    //sort products as per price low to high
    public function price_low($user_id)
    {
        $data['title'] = trans("products");
        $data['products'] = $this->product_model->get_price_low_to_high($user_id, 'active');
        $data['main_settings'] = get_main_settings();

        $this->load->view('profile/_product_section_ajax', $data);
    }

    //sort products as per price high to low
    public function price_high($user_id)
    {
        $data['title'] = trans("products");
        $data['products'] = $this->product_model->get_price_high_to_low($user_id, 'active');
        $data['main_settings'] = get_main_settings();

        $this->load->view('profile/_product_section_ajax', $data);
    }

    //sort products as per new products
    public function new_products($user_id)
    {
        $data['title'] = trans("products");
        $data['products'] = $this->product_model->get_new_products_of_user($user_id, 'active');
        $data['main_settings'] = get_main_settings();

        $this->load->view('profile/_product_section_ajax', $data);
    }
    public function products_shop_by_occassion($occassion_code)
    {
        get_method();
        $data['title'] = trans("products");
        $data['description'] = trans("products") . " - " . $this->app_name;
        $data['keywords'] = trans("products") . "," . $this->app_name;
        $data["index_settings"] = get_index_settings();
        $data['custom_filters'] = $this->field_model->get_custom_filters();
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
        $data["lookup"] = $this->product_model->get_lookup_code(strtoupper($occassion_code));
        $type_id = $data["lookup"]->id;
        $data["occasion_under"] = $data["lookup"]->meaning;
        //get paginated posts
        $pagination = $this->paginate(generate_url("shop_by_occasion") . '/' . $occassion_code, $this->product_model->get_paginated_filtered_products_count_category_feature($data["query_string_array"], null, $type_id), $this->product_per_page);
        $data['products'] = $this->product_model->get_products_shop_by_concern($data["query_string_array"], null, $pagination['per_page'], $pagination['offset'], $type_id);
        $data['product_count'] = $this->product_model->get_paginated_filtered_products_count_category_feature($data["query_string_array"], null, $type_id);
        $data["categories"] = $this->parent_categories;

        $data["all_category_selected"] = $this->product_model->get_category_selected_concerned_occasion($data["query_string_array"], null, $pagination['per_page'], $pagination['offset'], $type_id, true);


        $this->load->view('partials/_header', $data);
        $this->load->view('product/products', $data);
        $this->load->view('partials/_footer');
    }
    public function products_shop_by_random($random_code)
    {
        get_method();
        $data['title'] = trans("products");
        $data['description'] = trans("products") . " - " . $this->app_name;
        $data['keywords'] = trans("products") . "," . $this->app_name;
        $data["index_settings"] = get_index_settings();
        $data['custom_filters'] = $this->field_model->get_custom_filters();
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
        $data["lookup"] = $this->product_model->get_lookup_code(strtoupper($random_code));
        $type_id = $data["lookup"]->id;
        //get paginated posts
        $pagination = $this->paginate(generate_url("shop_by_random") . '/' . $random_code, $this->product_model->get_paginated_filtered_products_count_category_feature($data["query_string_array"], null, $type_id), $this->product_per_page);
        $data['products'] = $this->product_model->get_products_shop_by_concern($data["query_string_array"], null, $pagination['per_page'], $pagination['offset'], $type_id);
        $data['product_count'] = $this->product_model->get_paginated_filtered_products_count_category_feature($data["query_string_array"], null, $type_id);
        $data["categories"] = $this->parent_categories;

        $data["all_category_selected"] = $this->product_model->get_category_selected_concerned_occasion($data["query_string_array"], null, $pagination['per_page'], $pagination['offset'], $type_id, true);


        $this->load->view('partials/_header', $data);
        $this->load->view('product/products', $data);
        $this->load->view('partials/_footer');
    }
}
