<?php

use Stripe\Coupon;

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_controller extends Home_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->auth_check) {
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                $link = "https";
            } else {
                $link = "http";
            }

            // Here append the common URL characters.
            $link .= "://";

            // Append the host(domain name, ip) to the URL.
            $link .= $_SERVER['HTTP_HOST'];

            // Append the requested resource location to the URL
            $link .= $_SERVER['REQUEST_URI'];
            redirect(lang_base_url() . "?url=" . $link);
        }
        if (is_user_vendor() || is_admin()) {
            $this->session->unset_userdata('modesy_sess_user_location');
        }
        // if (!is_user_vendor()) {
        //     if ($this->general_settings->membership_plans_system == 1) {
        //         redirect(generate_url("start_selling", "select_membership_plan"));
        //         exit();
        //     }
        //     redirect(generate_url("why_sell_with_us"));
        //     exit();
        // }
        $this->per_page = 15;
    }

    /**
     * Index
     */

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
        if ($status == 200) {
            $user_data = array(
                'modesy_sess_user_shiprocket_token' => json_decode($response)->token
            );
            $this->session->set_userdata($user_data);
        }
    }


    public function index()
    {
        $data['title'] = get_shop_name($this->auth_user);
        $data['description'] = get_shop_name($this->auth_user) . " - " . $this->app_name;
        $data['keywords'] = get_shop_name($this->auth_user) . "," . $this->app_name;
        $data["user"] = $this->auth_user;
        $data["user_rating"] = calculate_user_rating($this->auth_user->id);
        $data["active_tab"] = "products";
        $data['active_sales_count'] = $this->order_admin_model->get_active_sales_count_by_seller($this->auth_user->id);
        $data['completed_sales_count'] = $this->order_admin_model->get_completed_sales_count_by_seller($this->auth_user->id);
        $data['total_sales_count'] = $data['active_sales_count'] + $data['completed_sales_count'];
        $data["max_count"] = $this->dashboard_model->max_orders_count($this->auth_user->id);
        $data["repeat"] = $this->dashboard_model->repeated_purchase($this->auth_user->id);
        $data["customers_weekly"] = $this->dashboard_model->max_customers_weekly();
        $data['total_pageviews_count'] = $this->product_model->get_vendor_total_pageviews_count($this->auth_user->id);
        $data['products_count'] = $this->product_model->get_user_products_count($this->auth_user->id);
        $data['services_count'] = $this->product_model->get_user_services_count($this->auth_user->id);
        $data['latest_sales'] = $this->order_model->get_limited_sales_by_seller($this->auth_user->id, 6);
        $data['latest_sales1'] = $this->dashboard_model->get_pending_orders($this->auth_user->id, 6);
        $data['latest_sales2'] = $this->dashboard_model->get_outstanding_payments($this->auth_user->id, 6);
        $data['latest_sales3'] = $this->dashboard_model->get_cleared_payments($this->auth_user->id, 6);
        $data['latest_sales4'] = $this->dashboard_model->top_ten_sellers();
        $data['latest_comments'] = $this->comment_model->get_paginated_vendor_comments($this->auth_user->id, 6, 0);
        $data['latest_reviews'] = $this->review_model->get_paginated_vendor_reviews($this->auth_user->id, 6, 0);
        $data['main_settings'] = get_main_settings();
        $data['sales_sum'] = $this->order_admin_model->get_sales_sum_by_month($this->auth_user->id);
        $data['avg_transaction'] = $this->dashboard_model->get_avg_transaction($this->auth_user->id);
        $data['new_customers_last_week'] = $this->dashboard_model->get_new_customers_last_week($this->auth_user->id);
        $data['no_of_transactions_last_week'] = $this->dashboard_model->get_no_of_transaction_last_week($this->auth_user->id);
        $data['active_customers'] = $this->dashboard_model->active_customers($this->auth_user->id);
        $data['avg_seller_rating'] = $this->dashboard_model->get_seller_rating($this->auth_user->id);
        $data["top_sell"] = $this->dashboard_model->top_selling_products();
        $data["top_selling"] = $this->dashboard_model->products_top_selling($this->auth_user->id);
        // $data['number_market_covered_till_now'] = $this->dashboard_model->number_market_covered_till_now($this->auth_user->id);
        $i = 0;
        $count = sizeof($data["customers_weekly"]);
        $data["z"] = array();
        $data["h"] = array();
        while ($i < $count) {
            $data["z"][] = ($data["customers_weekly"][$i]->week_no);
            $data["h"][] = (int)($data["customers_weekly"][$i]->cnt);
            $i++;
        }
        //data for new coustomer bar graph

        $data['days_newCustomer'] = array();
        $date = new DateTime();
        $date->modify('-7 week');
        while ($date->format('Y-m-d') != date('Y-m-d')) {
            array_push($data['days_newCustomer'], $date->format("W"));
            $i = $date->format("W");
            $date->modify('+1 week');
        }


        $data['test'] = [(int)$data['new_customers_last_week'][$i - 7]->new_customers, (int)$data['new_customers_last_week'][$i - 6]->new_customers, (int)$data['new_customers_last_week'][$i - 5]->new_customers, (int)$data['new_customers_last_week'][$i - 4]->new_customers, (int)$data['new_customers_last_week'][$i - 3]->new_customers, (int)$data['new_customers_last_week'][$i - 2]->new_customers, (int)$data['new_customers_last_week'][$i - 1]->new_customers];
        $ok['ok1'] = $this->dashboard_model->get_growth_over_last_week($this->auth_user->id);

        $data['test1'] = [(int)$data['no_of_transactions_last_week'][57 - $i]->order_id, (int)$data['no_of_transactions_last_week'][56 - $i]->order_id, (int)$data['no_of_transactions_last_week'][55 - $i]->order_id, (int)$data['no_of_transactions_last_week'][54 - $i]->order_id, (int)$data['no_of_transactions_last_week'][53 - $i]->order_id, (int)$data['no_of_transactions_last_week'][52 - $i]->order_id, (int)$data['no_of_transactions_last_week'][51 - $i]->order_id];

        $data['test2'] = [500, 700, 650, 800, 950, 200, 400];
        // $data['test3'] = [500, 700, 650, 800, 950, 700, 400];
        // $data['test4'] = [500, 700, 650, 800, 950, 500, 400];
        if (!empty($ok['ok1'])) {
            $json = '[{"name":"WEEK 1","y":' . $ok['ok1'][0]->growth_rate . ',"drilldown":"WEEK 1"},{"name":"WEEK 2","y":' . $ok['ok1'][1]->growth_rate . ',"drilldown":"WEEK 2"}]';
            $data['test5'] = json_decode($json);
        }

        $json = '[["Product 1",0.1],["Product 2",100.3],["Product 3",53.02],["Product 4",1.4],]';
        $data['dd1'] = json_decode($json);

        // get growth over last week transaction

        $get_growth_over_last_week_transaction['get_growth_over_last_week_transaction1'] = $this->dashboard_model->get_growth_over_last_week_transaction($this->auth_user->id);
        if (!empty($get_growth_over_last_week_transaction['get_growth_over_last_week_transaction1'])) {
            $json = '[{"name":"WEEK 1","y":' . $get_growth_over_last_week_transaction['get_growth_over_last_week_transaction1'][0]->growth_rate . ',"drilldown":"WEEK 1"},{"name":"WEEK 2","y":' . $get_growth_over_last_week_transaction['get_growth_over_last_week_transaction1'][1]->growth_rate . ',"drilldown":"WEEK 2"}]';
            $data['test6'] = json_decode($json);
        }
        //complete//  

        // new market delivered to the last one week
        // $new_market_delivered_to_the_last_one_week['new_market_delivered_to_the_last_one_week'] = $this->dashboard_model->new_market_delivered_to_the_last_one_week($this->auth_user->id);
        // $json = '[{"name":"WEEK 1","y":' . $new_market_delivered_to_the_last_one_week['new_market_delivered_to_the_last_one_week'][0]->growth_rate . ',"drilldown":"WEEK 1"},{"name":"WEEK 2","y":' . $get_growth_over_last_week_transaction['get_growth_over_last_week_transaction1'][1]->growth_rate . ',"drilldown":"WEEK 2"},{"name":"WEEK 3","y":' . $get_growth_over_last_week_transaction['get_growth_over_last_week_transaction1'][2]->growth_rate . ',"drilldown":"WEEK 3"},{"name":"WEEK 4","y":' . $get_growth_over_last_week_transaction['get_growth_over_last_week_transaction1'][3]->growth_rate . ',"drilldown":"WEEK 4"},{"name":"WEEK 5","y":' . $get_growth_over_last_week_transaction['get_growth_over_last_week_transaction1'][4]->growth_rate . ',"drilldown":"WEEK 5"}]';
        // // $data['test4'] = [500, 700, 650, 800, 950, 500, 400];
        // $data['test4'] = json_decode($json);



        //complete

        // new market covered till now

        $new_market_covered_till_now['new_market_covered_till_now'] = $this->dashboard_model->new_market_covered_till_now($this->auth_user->id);
        if (!empty($new_market_covered_till_now['new_market_covered_till_now'])) {
            $json = '[{"name":"WEEK 1","y":' . $new_market_covered_till_now['new_market_covered_till_now'][0]->count_shipping_area . ',"drilldown":"WEEK 1"},{"name":"WEEK 2","y":' . $new_market_covered_till_now['new_market_covered_till_now'][1]->count_shipping_area . ',"drilldown":"WEEK 2"},{"name":"WEEK 3","y":' . $new_market_covered_till_now['new_market_covered_till_now'][2]->count_shipping_area . ',"drilldown":"WEEK 3"},{"name":"WEEK 4","y":' . $new_market_covered_till_now['new_market_covered_till_now'][3]->count_shipping_area . ',"drilldown":"WEEK 4"},{"name":"WEEK 5","y":' . $new_market_covered_till_now['new_market_covered_till_now'][4]->count_shipping_area . ',"drilldown":"WEEK 5"}]';
            // $data['test3'] = [500, 700, 650, 800, 950, 700, 400];
            $data['test3'] = json_decode($json);
            // complete
        }


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
        if ($this->auth_user->role == "vendor") {

            $this->load->view('dashboard/includes/_header', $data);
            $this->load->view('dashboard/index', $data);
            $this->load->view('dashboard/includes/_footer');
        } else {
            $this->load->view('dashboard/includes/_header_buyer', $data);
            // $this->load->view('partials/_header', $data);
            $this->load->view('profile/buyer_profile', $data);
            // $this->load->view('partials/_footer');/
            $this->load->view('dashboard/includes/_footer');
        }
    }
    public function code_referral()
    {
        // $this->order_admin_model->create_referral_code();
        $data['title'] = "Referral";
        $data["description"] = "";
        $data["keywords"] = "";
        $data["user"] = $this->auth_user;
        $this->load->view('dashboard/includes/_header_buyer', $data);
        $this->load->view('dashboard/referral', $data);
        $this->load->view('dashboard/includes/_footer');
    }
    public function submit_code_referral()
    {
        $referred_by = $this->auth_user->id;
        $referrer_user_id = $this->auth_user->id;
        $referral = $this->order_admin_model->details_referral_code($referred_by);
        $email = $this->input->post('person_email', true);
        $mobile = $this->input->post('person_phone', true);

        $sl = $this->input->post('sl', true);



        for ($i = 0; $i <= $sl; $i++) {
            $data = array(
                'email' =>  $email[$i],
                'mobile' => $mobile[$i],
                'referral_id' => $referral,
                'referral_user_id' => $referrer_user_id
                // 'status' => "A",
                // 'created_by' => $this->auth_user->id,
            );


            $this->order_admin_model->create_referral_code($data);
        }
        redirect($this->agent->referrer());
    }

    public function buyer_panel()
    {
        $data['title'] = get_shop_name($this->auth_user);
        $data['description'] = get_shop_name($this->auth_user) . " - " . $this->app_name;
        $data['keywords'] = get_shop_name($this->auth_user) . "," . $this->app_name;
        $data["user"] = $this->auth_user;
        $data["user_rating"] = calculate_user_rating($this->auth_user->id);
        $data["active_tab"] = "profile";


        $data['main_settings'] = get_main_settings();
        $data['sales_sum'] = $this->order_admin_model->get_sales_sum_by_month($this->auth_user->id);
        $this->load->view('dashboard/includes/_header_buyer', $data);
        // $this->load->view('partials/_header', $data);
        $this->load->view('profile/buyer_profile', $data);
        $this->load->view('partials/_footer');
        // $this->load->view('dashboard/includes/_footer');
    }


    // public function buyer_index()
    // {
    //     $data['title'] = get_shop_name($this->auth_user);
    //     $data['description'] = get_shop_name($this->auth_user) . " - " . $this->app_name;
    //     $data['keywords'] = get_shop_name($this->auth_user) . "," . $this->app_name;
    //     $data["user"] = $this->auth_user;
    //     $data["user_rating"] = calculate_user_rating($this->auth_user->id);
    //     $data["active_tab"] = "products";

    //     $data['active_sales_count'] = $this->order_admin_model->get_active_sales_count_by_seller($this->auth_user->id);
    //     $data['completed_sales_count'] = $this->order_admin_model->get_completed_sales_count_by_seller($this->auth_user->id);
    //     $data['total_sales_count'] = $data['active_sales_count'] + $data['completed_sales_count'];

    //     $data['total_pageviews_count'] = $this->product_model->get_vendor_total_pageviews_count($this->auth_user->id);
    //     $data['products_count'] = $this->product_model->get_user_products_count($this->auth_user->id);
    //     $data['services_count'] = $this->product_model->get_user_services_count($this->auth_user->id);
    //     $data['latest_sales'] = $this->order_model->get_limited_sales_by_seller($this->auth_user->id, 6);
    //     $data['latest_comments'] = $this->comment_model->get_paginated_vendor_comments($this->auth_user->id, 6, 0);
    //     $data['latest_reviews'] = $this->review_model->get_paginated_vendor_reviews($this->auth_user->id, 6, 0);
    //     $data['main_settings'] = get_main_settings();
    //     $data['sales_sum'] = $this->order_admin_model->get_sales_sum_by_month($this->auth_user->id);

    //     $data['test'] = [50, 60, 75, 80, 70, 90, 100];

    //     // $data['test'] = $this->order_model->get_last_week_customer_data($this->auth_user->id);

    //     //data for new coustomer bar graph
    //     $data['days_newCustomer'] = array();
    //     $date = new DateTime();
    //     $date->modify('-7 day');
    //     while ($date->format('Y-m-d') != date('Y-m-d')) {
    //         array_push($data['days_newCustomer'], $date->format("l"));
    //         $date->modify('+1 day');
    //     }


    //     // echo json_encode($data['days_newCustomer']);
    //     // die;


    //     $data['test1'] = [500, 700, 650, 800, 950, 400, 300];
    //     $data['test2'] = [500, 700, 650, 800, 950, 200, 400];
    //     $data['test3'] = [500, 700, 650, 800, 950, 700, 400];
    //     $data['test4'] = [500, 700, 650, 800, 950, 500, 400];
    //     $json = '[{"name":"SUNDAY","y":60.62,"drilldown":"SUNDAY"},{"name":"MONDAY","y":62.74,"drilldown":"MONDAY"},{"name":"TUESDAY","y":10.57,"drilldown":"TUESDAY"},{"name":"WEDNESDAY","y":7.23,"drilldown":"WEDNESDAY"},{"name":"THRUSDAY","y":5.58,"drilldown":"THRUSDAY"},{"name":"FRIDAY","y":4.02,"drilldown":"FRIDAY"},{"name":"SATURDAY","y":1.92,"drilldown":"SATURDAY"}]';
    //     $data['test5'] = json_decode($json);
    //     $json = '[["Product 1",0.1],["Product 2",100.3],["Product 3",53.02],["Product 4",1.4],]';
    //     $data['dd1'] = json_decode($json);
    //     $json = '[{"name":"SUNDAY","y":70.62,"drilldown":"SUNDAY"},{"name":"MONDAY","y":52.74,"drilldown":"MONDAY"},{"name":"TUESDAY","y":90.57,"drilldown":"TUESDAY"},{"name":"WEDNESDAY","y":7.23,"drilldown":"WEDNESDAY"},{"name":"THRUSDAY","y":5.58,"drilldown":"THRUSDAY"},{"name":"FRIDAY","y":4.02,"drilldown":"FRIDAY"},{"name":"SATURDAY","y":100.00,"drilldown":"SATURDAY"}]';
    //     $data['test6'] = json_decode($json);
    //     $json = '[["Product 1",100.1],["Product 2",10.3],["Product 3",50.02],["Product 4",70.4]]';
    //     $data['dd2'] = json_decode($json);
    //     $json = '[{"name":"Deepansh","y":40,"drilldown":"Deepansh"},{"name":"Navin","y":20,"drilldown":"Navin"},{"name":"Rajesh","y":10,"drilldown":"Rajesh"},{"name":"knight","y":10,"drilldown":"knight"},{"name":"Joker","y":10,"drilldown":"Joker"},{"name":"Arrow","y":10,"drilldown":"Arrow"}]';
    //     $data['test7'] = json_decode($json);
    //     $json = '[["v65.0",0.1],["v64.0",1.3],["v63.0",53.02],["v62.0",1.4],["v61.0",0.88],["v60.0",0.56]]';
    //     $json = '[["v65.0",0.1],["v64.0",1.3],["v63.0",53.02],["v62.0",1.4],["v61.0",0.88],["v60.0",0.56]]';
    //     $json = '[["v65.0",0.1],["v64.0",1.3],["v63.0",53.02],["v62.0",1.4],["v61.0",0.88],["v60.0",0.56]]';
    //     $json = '[["v65.0",0.1],["v64.0",1.3],["v63.0",53.02],["v62.0",1.4],["v61.0",0.88],["v60.0",0.56]]';
    //     $json = '[["v65.0",0.1],["v64.0",1.3],["v63.0",53.02],["v62.0",1.4],["v61.0",0.88],["v60.0",0.56]]';
    //     $data['dy1'] = json_decode($json);
    //     $data['dy2'] = json_decode($json);
    //     $data['dy3'] = json_decode($json);
    //     $data['dy4'] = json_decode($json);
    //     $data['dy5'] = json_decode($json);
    //     $data['dy6'] = json_decode($json);
    //     $json = '[{"name":"Deepansh","y":30,"drilldown":"Deepansh"},{"name":"Navin","y":20,"drilldown":"Navin"},{"name":"Rajesh","y":20,"drilldown":"Rajesh"},{"name":"knight","y":10,"drilldown":"knight"},{"name":"Joker","y":10,"drilldown":"Joker"},{"name":"Arrow","y":10,"drilldown":"Arrow"}]';
    //     $data['test8'] = json_decode($json);

    //     $this->load->view('dashboard/includes/_header', $data);
    //     $this->load->view('buyer/index', $data);
    //     $this->load->view('dashboard/includes/_footer');
    // }

    /*
    *------------------------------------------------------------------------------------------
    * PROfile with edit button
    *------------------------------------------------------------------------------------------
    */
    public function update_profile()
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

        $data["product_images"] = $this->file_model->get_story_images($data["user"]->id);
        $data['custom_filters'] = $this->field_model->get_custom_filters();
        $data["query_string_array"] = get_query_string_array($data['custom_filters']);
        $data["query_string_object_array"] = convert_query_string_to_object_array($data["query_string_array"]);
        //set pagination
        $data['num_rows'] = $this->product_model->get_user_products_count($data["user"]->id, 'active');
        $pagination = $this->paginate(generate_profile_url($data["user"]->slug), $data['num_rows'], $this->product_per_page);
        $data['products'] = $this->product_model->get_paginated_filtered_user_products($data["user"]->id, 'active', $data["query_string_array"], null, $pagination['per_page'], $pagination['offset']);
        $data['user_categories'] = $this->product_model->get_categories_array_with_products($data["user"]->id);

        $data["user_rating"] = calculate_user_rating($data["user"]->id);

        $data["active_tab"] = "profile";
        $data["session"] = get_user_session();
        if ($data["user"]->role == "vendor") {
            $this->load->view('dashboard/includes/_header', $data);
            $this->load->view('profile/seller_profile', $data);
            $this->load->view('dashboard/includes/_footer');
        } else {
            $this->load->view('dashboard/includes/_header_buyer', $data);
            $this->load->view('profile/buyer_profile', $data);
            $this->load->view('dashboard/includes/_footer_buyer');
        }
    }


    /*
    *------------------------------------------------------------------------------------------
    * PRODUCTS
    *------------------------------------------------------------------------------------------
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
        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('settings/update_story', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    public function coupans()
    {
        $data['title'] = "Coupans";
        $data['description'] = "Coupans" . " - " . $this->app_name;
        $data['keywords'] = "Coupans" . "," . $this->app_name;
        $data["active_tab"] = "coupans";


        $this->load->view('dashboard/includes/_header_buyer', $data);
        $this->load->view('dashboard/coupans', $data);
        $this->load->view('dashboard/includes/_footer');
    }
    public function credits()
    {
        $data['title'] = "Credits";
        $data['description'] = "Credits" . " - " . $this->app_name;
        $data['keywords'] = "Credits" . "," . $this->app_name;;
        $data["active_tab"] = "credits";
        $data['user'] = $this->auth_user;
        $this->load->view('dashboard/includes/_header_buyer', $data);
        $this->load->view('dashboard/credits', $data);
        $this->load->view('dashboard/includes/_footer');
    }
    public function saved_cards()
    {
        $data['title'] = "Saved Cards";
        $data['description'] = "Saved Cards" . " - " . $this->app_name;
        $data['keywords'] = "Saved Cards" . "," . $this->app_name;
        $data['user'] = $this->auth_user;
        $data["active_tab"] = "saved_cards";
        $this->load->view('dashboard/includes/_header_buyer', $data);
        $this->load->view('dashboard/saved_cards', $data);
        $this->load->view('dashboard/includes/_footer');
    }
    public function addresses()
    {
        $data['title'] = "Addresses";
        $data['description'] =  "Addresses" . " - " . $this->app_name;
        $data['keywords'] = "Addresses" . "," . $this->app_name;
        $data["active_tab"] = "addresses";
        $data['user'] = $this->auth_user;
        $data['modesy_images'] = $this->file_model->get_sess_product_images_array();
        $data["file_manager_images"] = $this->file_model->get_user_file_manager_images();
        $data["active_product_system_array"] = $this->get_activated_product_system();
        $data['main_settings'] = get_main_settings();
        $view = !$this->membership_model->is_allowed_adding_product() ? 'plan_expired' : 'add_product';

        $this->load->view('dashboard/includes/_header_buyer', $data);
        $this->load->view('dashboard/addresses', $data);
        $this->load->view('dashboard/includes/_footer');
        // $this->load->view('partials/_footer');
    }

    /**
     * Add Product
     */
    public function add_product()
    {
        $data['title'] = trans("add_product");
        $data['description'] = trans("add_product") . " - " . $this->app_name;
        $data['keywords'] = trans("add_product") . "," . $this->app_name;
        $data["sku"] = $this->product_model->get_sku();

        $data['modesy_images'] = $this->file_model->get_sess_product_images_array();
        $data["file_manager_images"] = $this->file_model->get_user_file_manager_images();
        $data["active_product_system_array"] = $this->get_activated_product_system();
        $data['main_settings'] = get_main_settings();
        $view = !$this->membership_model->is_allowed_adding_product() ? 'plan_expired' : 'add_product';
        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/product/' . $view, $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Add Product Post
     */
    public function add_product_post()
    {
        if (!$this->membership_model->is_allowed_adding_product()) {
            $this->session->set_flashdata('error', trans("msg_plan_expired"));
            redirect($this->agent->referrer());
            exit();
        }
        //validate title
        if (empty(trim($this->input->post('title_' . $this->selected_lang->id, true)))) {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }

        //validate atleast one image uploaded
        if (!$this->file_model->check_product_image()) {
            $this->session->set_flashdata('error', trans("msg_photo_not_added"));
            redirect($this->agent->referrer());
        }


        //add product
        if ($this->product_model->add_product()) {
            //last id
            $last_id = $this->db->insert_id();
            //add product title and desc
            $this->product_model->add_product_title_desc($last_id);
            //update slug
            $this->product_model->update_slug($last_id);
            //add product images
            $this->file_model->add_product_images($last_id);

            redirect(generate_dash_url("product", "product_details") . '/' . $last_id);
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Add Product Post
     */
    public function check_image_upload_product()
    {
        if (!$this->file_model->check_product_image()) {
            $this->session->set_flashdata('error', trans("msg_photo_not_added"));
            $data = array(
                'result' => 0,
                'message' => $this->load->view('dashboard/includes/_messages', '', true)
            );
            echo json_encode($data);
        } else {
            $data = array(
                'result' => 1,
                'message' => $this->load->view('dashboard/includes/_messages', '', true)
            );
            echo json_encode($data);
        }
    }

    public function add_service()
    {
        $data['title'] = trans("add_service");
        $data['description'] = trans("add_service") . " - " . $this->app_name;
        $data['keywords'] = trans("add_service") . "," . $this->app_name;

        $data['modesy_images'] = $this->file_model->get_sess_product_images_array();
        $data["file_manager_images"] = $this->file_model->get_user_file_manager_images();
        $data["active_product_system_array"] = $this->get_activated_product_system();
        $data['main_settings'] = get_main_settings();
        $view = !$this->membership_model->is_allowed_adding_product() ? 'plan_expired' : 'add_service';

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/service/' . $view, $data);
        $this->load->view('dashboard/includes/_footer');
    }


    public function save_cards()
    {

        if ($this->auth_model->add_user_cards()) {


            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }
    public function delete_address()
    {
        $id = $this->input->post('id', true);
        if ($this->auth_model->delete_address($id)) {
            $this->session->set_flashdata('success', "Address sucessfully deleted");
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();
    }

    public function delete_card()
    {
        $id = $this->input->post('id', true);
        if ($this->auth_model->delete_card($id)) {
            $this->session->set_flashdata('success', "Card sucessfully deleted");
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();
    }

    public function save_addresses()
    {
        if ($this->auth_model->add_user_addresses()) {


            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }
    public function schedule_multiple_order_shipment()
    {
        $pickup_location_matched = 0;
        $delivery_partner_matched = 0;
        $products_array = array();
        $items_ids = array();
        $product_ids = $this->input->post('product_ids', true);

        $First_product = get_product(get_order_product($product_ids[0])->product_id);
        $product_address = $First_product->product_address;
        $product_landmark = $First_product->landmark;
        $product_area = $First_product->product_area;
        $product_city = $First_product->product_city;
        $product_state = $First_product->product_state;
        $product_pincode = $First_product->product_pincode;
        $product_delivery_partner = get_order_product($product_ids[0])->product_delivery_partner;

        if (!empty($product_ids)) {

            foreach ($product_ids as $id) {
                if (get_order_product($id)->order_status == "processing") {
                    array_push($items_ids, $id);
                    $product = get_product(get_order_product($id)->product_id);
                    if (strcasecmp($product_address, $product->product_address) == 0 && strcasecmp($product_landmark, $product->landmark) == 0 && strcasecmp($product_area, $product->product_area) == 0 && strcasecmp($product_city, $product->product_city) == 0 && strcasecmp($product_pincode, $product->product_pincode) == 0) {
                        $pickup_location_matched = 0;
                    } else {
                        $pickup_location_matched++;
                    }
                }
            }
        }

        $sale_total_price = 0;
        if (!empty($product_ids)) {
            foreach ($product_ids as $id) {
                $order_product = get_order_product($id);
                if (strcasecmp($product_delivery_partner, $order_product->product_delivery_partner) == 0) {
                    $delivery_partner_matched = 0;
                    $sale_total_price += $order_product->product_total_price / 100;
                } else {
                    $delivery_partner_matched++;
                }
            }
        }

        $order_items = array();

        $total_length = 0;
        $total_weight = 0;
        $total_height = 0;
        $total_width = 0;
        $total_quantity = 0;

        if (!empty($product_ids)) {
            foreach ($product_ids as $id) {

                if (get_order_product($id)->order_status == "processing") {
                    $half_width_product_variations = $this->variation_model->get_half_width_product_variations(get_order_product($id)->product_id);
                    $full_width_product_variations = $this->variation_model->get_full_width_product_variations(get_order_product($id)->product_id);
                    if (empty($half_width_product_variations) && empty($full_width_product_variations)) {
                        $product = get_product(get_order_product($id)->product_id);
                        $order_product = get_order_product($id);
                        $total_length += intval($product->packed_product_length);
                        $total_width += intval($product->packed_product_width);
                        $total_height += intval($product->packed_product_height);
                        $total_weight += intval($order_product->product_weight);
                        array_push($products_array, $product);
                        array_push($order_items, $order_product);
                    } else {
                        $variation = $this->variation_model->get_product_variations(get_order_product($id)->product_id);
                        foreach ($variation as $variations) :
                        endforeach;
                        $option = $this->variation_model->get_variation_options($variations->id);
                        $data = unserialize(get_order_product($id)->variation_option_ids);
                        foreach ($data as $a) {

                            $product = $this->product_model->get_variation_options_by_id(get_order_product($id)->product_id, $a);

                            array_push($products_array, $product);
                        }
                        array_push($order_items, $order_product);


                        $order_product = get_order_product($id);
                        $total_length += intval($product->packed_product_length);
                        $total_width += intval($product->packed_product_width);
                        $total_height += intval($product->packed_product_height);
                        $total_weight += intval($order_product->product_weight);
                    }
                }
            }



            $vars = array(
                "products" => $products_array,
                "total_length" => $total_length,
                "total_width" => $total_width,
                "total_height" => $total_height,
                "total_weight" => $total_weight,
                "pickup_location_matched" => $pickup_location_matched,
                "order_items" => $order_items,
                "delivery_partner_matched" => $delivery_partner_matched,
                "sale_total_price" => $sale_total_price,
                "item_ids" => $items_ids

            );
            $html_content = $this->load->view('dashboard/schedule_shipment_view', $vars, true);
            $data = array(
                'result' => 1,
                'html_content' => $html_content,
                'vars' => $vars
            );
            echo json_encode($data);
        }
    }



    public function edit_addresses()
    {
        $id = $this->input->post('address_id', true);
        if ($this->auth_model->edit_addresses($id)) {


            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }
    public function edit_cards()
    {
        $id = $this->input->post('card_id', true);
        if ($this->auth_model->edit_cards($id)) {


            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }
    /**
     * Add Product Post
     */
    public function add_service_post()
    {
        if (!$this->membership_model->is_allowed_adding_product()) {
            $this->session->set_flashdata('error', trans("msg_plan_expired"));
            redirect($this->agent->referrer());
            exit();
        }
        //validate title
        if (empty(trim($this->input->post('title_' . $this->selected_lang->id, true)))) {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
        //add product
        if ($this->product_model->add_service()) {
            //last id
            $last_id = $this->db->insert_id();
            //add product title and desc
            $this->product_model->add_product_title_desc($last_id);
            //update slug
            $this->product_model->update_slug($last_id);
            //add product images
            $this->file_model->add_product_images($last_id);

            redirect(generate_dash_url("service", "service_details") . '/' . $last_id);
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Edit Product
     */
    public function edit_product($id)
    {
        $data["product"] = $this->product_admin_model->get_product($id);
        if (empty($data["product"])) {
            redirect($this->agent->referrer());
        }
        $data["sku"] = $this->product_model->get_sku();

        if ($data["product"]->is_deleted == 1) {
            if ($this->auth_user->role != "admin") {
                redirect($this->agent->referrer());
            }
        }
        if ($data["product"]->user_id != $this->auth_user->id && $this->auth_user->role != "admin") {
            redirect($this->agent->referrer());
        }

        $data['title'] = $data["product"]->is_draft == 1 ? trans("add_product") : trans("edit_product");
        $data['description'] = $data['title'] . " - " . $this->app_name;
        $data['keywords'] = $data['title'] . "," . $this->app_name;

        $data['category'] = $this->category_model->get_category($data["product"]->category_id);
        $data['parent_categories_array'] = $this->category_model->get_parent_categories_tree($data["product"]->category_id);
        $data['modesy_images'] = $this->file_model->get_product_images_uncached($data["product"]->id);
        $data['all_categories'] = $this->category_model->get_categories_ordered_by_name();
        $data["file_manager_images"] = $this->file_model->get_user_file_manager_images();
        $data["active_product_system_array"] = $this->get_activated_product_system();
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/product/edit_product', $data);
        $this->load->view('dashboard/includes/_footer');
    }
    public function edit_service($id)
    {
        $data["product"] = $this->product_admin_model->get_product($id);
        if (empty($data["product"])) {
            redirect($this->agent->referrer());
        }
        if ($data["product"]->is_deleted == 1) {
            if ($this->auth_user->role != "admin") {
                redirect($this->agent->referrer());
            }
        }
        if ($data["product"]->user_id != $this->auth_user->id && $this->auth_user->role != "admin") {
            redirect($this->agent->referrer());
        }

        $data['title'] = $data["product"]->is_draft == 1 ? trans("add_service") : "Edit Service";
        $data['description'] = $data['title'] . " - " . $this->app_name;
        $data['keywords'] = $data['title'] . "," . $this->app_name;

        $data['category'] = $this->category_model->get_category($data["product"]->category_id);
        $data['parent_categories_array'] = $this->category_model->get_parent_categories_tree($data["product"]->category_id);
        $data['modesy_images'] = $this->file_model->get_product_images_uncached($data["product"]->id);
        $data['all_categories'] = $this->category_model->get_categories_ordered_by_name();
        $data["file_manager_images"] = $this->file_model->get_user_file_manager_images();
        $data["active_product_system_array"] = $this->get_activated_product_system();
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/service/edit_service', $data);
        $this->load->view('dashboard/includes/_footer');
    }
    /**
     * Edit Product Post
     */
    public function edit_product_post()
    {
        //product id
        $product_id = $this->input->post('id', true);
        //user id
        $user_id = 0;
        $product = $this->product_model->get_product_by_id($product_id);

        //count check of product images
        if (count($this->file_model->get_product_images_uncached($product_id)) < 1) {
            $this->session->set_flashdata('error', trans("msg_photo_not_added"));
            redirect($this->agent->referrer());
        }
        if (!empty($product)) {
            if ($product->user_id != $this->auth_user->id && $this->auth_user->role != "admin") {
                redirect($this->agent->referrer());
            }

            //check slug is unique
            $slug = $product->slug;
            if (is_admin()) {
                $slug = $this->input->post('slug', true);
                if (empty($slug)) {
                    $slug = "product-" . $product->id;
                }
                if ($this->db->where('id !=', $product->id)->where('slug', $slug)->get('products')->num_rows() > 0) {
                    $this->session->set_flashdata('error', trans("msg_product_slug_used"));
                    redirect($this->agent->referrer());
                    exit();
                }
            }

            if ($this->product_model->edit_product($product, $slug)) {
                //edit product title and desc
                $this->product_model->edit_product_title_desc($product_id);
                if ($product->is_draft == 1) {
                    redirect(generate_dash_url("product", "product_details") . '/' . $product_id);
                } else {
                    //reset cache
                    reset_cache_data_on_change();
                    reset_user_cache_data($product->user_id);
                    reset_product_img_cache_data($product_id);

                    $this->session->set_flashdata('success', trans("msg_updated"));

                    redirect($this->agent->referrer());
                }
            }
        }
        $this->session->set_flashdata('error', trans("msg_error"));
        redirect($this->agent->referrer());
    }

    public function edit_service_post()
    {
        //product id
        $product_id = $this->input->post('id', true);
        //user id
        $user_id = 0;
        $product = $this->product_model->get_product_by_id($product_id);
        if (!empty($product)) {
            if ($product->user_id != $this->auth_user->id && $this->auth_user->role != "admin") {
                redirect($this->agent->referrer());
            }

            //check slug is unique
            $slug = $product->slug;
            if (is_admin()) {
                $slug = $this->input->post('slug', true);
                if (empty($slug)) {
                    $slug = "product-" . $product->id;
                }
                if ($this->db->where('id !=', $product->id)->where('slug', $slug)->get('products')->num_rows() > 0) {
                    $this->session->set_flashdata('error', trans("msg_product_slug_used"));
                    redirect($this->agent->referrer());
                    exit();
                }
            }

            if ($this->product_model->edit_product($product, $slug)) {
                //edit product title and desc
                $this->product_model->edit_product_title_desc($product_id);
                if ($product->is_draft == 1) {
                    redirect(generate_dash_url("service", "service_details") . '/' . $product_id);
                } else {
                    //reset cache
                    reset_cache_data_on_change();
                    reset_user_cache_data($product->user_id);
                    reset_product_img_cache_data($product_id);

                    $this->session->set_flashdata('success', trans("msg_updated"));
                    redirect($this->agent->referrer());
                }
            }
        }
        $this->session->set_flashdata('error', trans("msg_error"));
        redirect($this->agent->referrer());
    }

    /**
     * Edit Product Details
     */
    public function edit_product_details($id)
    {
        $data['product'] = $this->product_admin_model->get_product($id);
        $data["user"] = $this->product_admin_model->get_user($data['product']->user_id);
        $data["sku"] = $this->product_model->get_sku();

        if (empty($data['product'])) {
            redirect($this->agent->referrer());
        }
        if ($this->auth_user->role != 'admin' && $this->auth_user->id != $data['product']->user_id) {
            redirect($this->agent->referrer());
            exit();
        }

        if ($data['product']->is_draft == 1) {
            $data['title'] = trans("add_product");
            $data['description'] = trans("add_product") . " - " . $this->app_name;
            $data['keywords'] = trans("add_product") . "," . $this->app_name;
        } else {
            $data['title'] = trans("edit_product");
            $data['description'] = trans("edit_product") . " - " . $this->app_name;
            $data['keywords'] = trans("edit_product") . "," . $this->app_name;
        }

        if ($data["product"]->country_id == 0) {
            $data["states"] = $this->location_model->get_states_by_country($this->auth_user->country_id);
        } else {
            $data["states"] = $this->location_model->get_states_by_country($data["product"]->country_id);
        }
        if ($data["product"]->country_id == 0) {
            $data["cities"] = $this->location_model->get_cities_by_state($this->auth_user->state_id);
        } else {
            $data["cities"] = $this->location_model->get_cities_by_state($data["product"]->state_id);
        }

        $data["custom_fields"] = $this->field_model->get_custom_fields_by_category($data["product"]->category_id);
        $data["product_variations"] = $this->variation_model->get_product_variations($data["product"]->id);
        $data["user_variations"] = $this->variation_model->get_variation_by_user_id($data["product"]->user_id);
        $data['form_settings'] = $this->settings_model->get_form_settings();
        $data['license_keys'] = $this->product_model->get_license_keys($data["product"]->id);
        $data['main_settings'] = get_main_settings();
        $data['parent_categories_array'] = $this->category_model->get_parent_categories_tree($data["product"]->category_id);

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/product/edit_product_details', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Edit Product Details Post
     */
    public function edit_product_details_post()
    {
        $product_id = $this->input->post('id', true);
        $product = $this->product_admin_model->get_product($product_id);
        if (empty($product)) {
            redirect($this->agent->referrer());
            exit();
        }
        if ($this->auth_user->role != 'admin' && $this->auth_user->id != $product->user_id) {
            redirect($this->agent->referrer());
            exit();
        }
        //check digital file
        if ($product->product_type == "digital") {
            if ($this->db->where('product_id', $product->id)->get('digital_files')->num_rows() <= 0) {
                $this->session->set_flashdata('error', trans("digital_file_required"));
                redirect($this->agent->referrer());
                exit();
            }
        }
        if ($this->product_model->edit_product_details($product_id)) {
            //edit custom fields
            $this->product_model->update_product_custom_fields($product_id);

            //reset cache
            reset_cache_data_on_change();
            reset_user_cache_data($this->auth_user->id);

            if ($product->is_draft != 1) {
                if ($this->general_settings->approve_before_publishing == 1 && !is_admin()) {
                    $product_updated = get_product($product_id);
                    // var_dump($product_updated->status);
                    if ($product_updated->status == 0) {

                        $this->session->set_flashdata('success', trans("product_added") . " " . trans("product_approve_published"));
                    } else {
                        $this->session->set_flashdata('success', "Product updated successfully");
                    }
                } else {
                    $this->session->set_flashdata('success', trans("product_added"));
                }
                redirect($this->agent->referrer());
            } else {
                //if draft
                if ($this->input->post('submit', true) == 'save_as_draft') {
                    // $this->session->set_flashdata('success', trans("draft_added"));
                    // echo anchor(generate_product_url($product), 'title="My News"', array('target' => '_blank', 'class' => 'new_window'));
                    // //echo anchor_popup(generate_product_url($product), 'Click Me!', array());
                    // redirect(generate_product_url($product));
                    echo "<script>window.open('" . generate_product_preview_url($product) . "', '_blank');
                    window.location.href = '" . $this->agent->referrer() . "';</script>";
                    die();
                    redirect($this->agent->referrer());
                } else {
                    if ($this->general_settings->approve_before_publishing == 1 && !is_admin()) {
                        $this->session->set_flashdata('success', trans("product_added") . " " . trans("product_approve_published"));
                    } else {
                        $this->session->set_flashdata('success', trans("product_added"));
                    }
                    //send email
                    if ($this->general_settings->send_email_new_product == 1) {
                        $email_data = array(
                            'email_type' => 'new_product',
                            'product_id' => $product->id
                        );
                        $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
                    }
                }
                redirect(generate_dash_url("add_product"));
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }
    public function edit_service_details($id)
    {
        $data['product'] = $this->product_admin_model->get_product($id);
        if (empty($data['product'])) {
            redirect($this->agent->referrer());
        }
        if ($this->auth_user->role != 'admin' && $this->auth_user->id != $data['product']->user_id) {
            redirect($this->agent->referrer());
            exit();
        }

        if ($data['product']->is_draft == 1) {
            $data['title'] = trans("add_service");
            $data['description'] = trans("add_service") . " - " . $this->app_name;
            $data['keywords'] = trans("add_service") . "," . $this->app_name;
        } else {
            $data['title'] = "Edit Service";
            $data['description'] = "Edit Service" . " - " . $this->app_name;
            $data['keywords'] = "Edit Service" . "," . $this->app_name;
        }

        if ($data["product"]->country_id == 0) {
            $data["states"] = $this->location_model->get_states_by_country($this->auth_user->country_id);
        } else {
            $data["states"] = $this->location_model->get_states_by_country($data["product"]->country_id);
        }
        if ($data["product"]->country_id == 0) {
            $data["cities"] = $this->location_model->get_cities_by_state($this->auth_user->state_id);
        } else {
            $data["cities"] = $this->location_model->get_cities_by_state($data["product"]->state_id);
        }

        $data["custom_fields"] = $this->field_model->get_custom_fields_by_category($data["product"]->category_id);
        $data["product_variations"] = $this->variation_model->get_product_variations($data["product"]->id);
        $data["user_variations"] = $this->variation_model->get_variation_by_user_id($data["product"]->user_id);
        $data['form_settings'] = $this->settings_model->get_form_settings();
        $data['license_keys'] = $this->product_model->get_license_keys($data["product"]->id);
        $data['main_settings'] = get_main_settings();
        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/service/edit_service_details', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Edit Product Details Post
     */
    public function edit_service_details_post()
    {
        $product_id = $this->input->post('id', true);
        $product = $this->product_admin_model->get_product($product_id);
        if (empty($product)) {
            redirect($this->agent->referrer());
            exit();
        }
        if ($this->auth_user->role != 'admin' && $this->auth_user->id != $product->user_id) {
            redirect($this->agent->referrer());
            exit();
        }
        //check digital file
        if ($product->product_type == "digital") {
            if ($this->db->where('product_id', $product->id)->get('digital_files')->num_rows() <= 0) {
                $this->session->set_flashdata('error', trans("digital_file_required"));
                redirect($this->agent->referrer());
                exit();
            }
        }
        if ($this->product_model->edit_service_details($product_id)) {
            //edit custom fields
            $this->product_model->update_product_custom_fields($product_id);

            //reset cache
            reset_cache_data_on_change();
            reset_user_cache_data($this->auth_user->id);

            if ($product->is_draft != 1) {
                $this->session->set_flashdata('success', trans("msg_updated"));
                redirect($this->agent->referrer());
            } else {
                //if draft
                if ($this->input->post('submit', true) == 'save_as_draft') {
                    $this->session->set_flashdata('success', trans("draft_added"));
                } else {
                    if ($this->general_settings->approve_before_publishing == 1 && !is_admin()) {
                        $this->session->set_flashdata('success', "Service Added Successfully" . " " . trans("product_approve_published"));
                    } else {
                        $this->session->set_flashdata('success', "Service Added Successfully");
                    }
                    //send email
                    if ($this->general_settings->send_email_new_product == 1) {
                        $email_data = array(
                            'email_type' => 'new_product',
                            'product_id' => $product->id
                        );
                        $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
                    }
                }
                redirect(generate_dash_url("add_service"));
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }
    //show address on map
    public function show_address_on_map()
    {
        $country_text = $this->input->post('country_text', true);
        $country_val = $this->input->post('country_val', true);
        $state_text = $this->input->post('state_text', true);
        $state_val = $this->input->post('state_val', true);
        $address = $this->input->post('address', true);
        $zip_code = $this->input->post('zip_code', true);

        $adress_details = $address . " " . $zip_code;
        $data["map_address"] = "";
        if (!empty($adress_details)) {
            $data["map_address"] = $adress_details . " ";
        }
        if (!empty($state_val)) {
            $data["map_address"] = $data["map_address"] . $state_text . " ";
        }
        if (!empty($country_val)) {
            $data["map_address"] = $data["map_address"] . $country_text;
        }

        $this->load->view('product/_load_map', $data);
    }

    //get activated product system
    public function get_activated_product_system()
    {
        $array = array(
            'active_system_count' => 0,
            'active_system_value' => "",
        );
        if ($this->general_settings->marketplace_system == 1) {
            $array['active_system_count'] = $array['active_system_count'] + 1;
            $array['active_system_value'] = "sell_on_site";
        }
        if ($this->general_settings->classified_ads_system == 1) {
            $array['active_system_count'] = $array['active_system_count'] + 1;
            $array['active_system_value'] = "ordinary_listing";
        }
        if ($this->general_settings->bidding_system == 1) {
            $array['active_system_count'] = $array['active_system_count'] + 1;
            $array['active_system_value'] = "bidding";
        }
        return $array;
    }

    /**
     * Products
     */
    public function products()
    {
        $data['title'] = trans("products");
        $data['description'] = trans("products") . " - " . $this->app_name;
        $data['keywords'] = trans("products") . "," . $this->app_name;
        $data['page_url'] = generate_dash_url("products");

        $data['num_rows'] = $this->product_model->get_user_products_count($this->auth_user->id, 'active');
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['products'] = $this->product_model->get_paginated_user_products($this->auth_user->id, 'active', $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/product/products', $data);
        $this->load->view('dashboard/includes/_footer');
    }
    public function bulk_products()
    {
        $data['title'] = trans("products");
        $data['description'] = trans("products") . " - " . $this->app_name;
        $data['keywords'] = trans("products") . "," . $this->app_name;
        $data['page_url'] = generate_dash_url("products");
        if (!empty($this->dashboard_model->products_batch($this->auth_user->id))) {
            $data['products'] = $this->dashboard_model->products_batch($this->auth_user->id);
        }
        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/product/bulk_upload', $data);
        $this->load->view('dashboard/includes/_footer');
    }


    /**
     * Services
     */
    public function services()
    {
        $data['title'] = "Services";
        $data['description'] = "Services" . " - " . $this->app_name;
        $data['keywords'] = "Services" . "," . $this->app_name;
        $data['page_url'] = generate_dash_url("services");

        $data['num_rows'] = $this->product_model->get_user_products_count($this->auth_user->id, 'active');
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['products'] = $this->product_model->get_paginated_user_products($this->auth_user->id, 'active', $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/service/services', $data);
        $this->load->view('dashboard/includes/_footer');
    }


    /**
     * Pending Products
     */
    public function pending_products()
    {
        $data['title'] = trans("pending_products");
        $data['description'] = trans("pending_products") . " - " . $this->app_name;
        $data['keywords'] = trans("pending_products") . "," . $this->app_name;
        $data['page_url'] = generate_dash_url("pending_products");

        $data['num_rows'] = $this->product_model->get_user_products_count($this->auth_user->id, 'pending');
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['products'] = $this->product_model->get_paginated_user_products($this->auth_user->id, 'pending', $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/product/products', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Hidden Products
     */
    public function hidden_products()
    {
        $data['title'] = trans("hidden_products");
        $data['description'] = trans("hidden_products") . " - " . $this->app_name;
        $data['keywords'] = trans("hidden_products") . "," . $this->app_name;
        $data['page_url'] = generate_dash_url("hidden_products");

        $data['num_rows'] = $this->product_model->get_user_products_count($this->auth_user->id, 'hidden');
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['products'] = $this->product_model->get_paginated_user_products($this->auth_user->id, 'hidden', $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/product/products', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Drafts
     */
    public function drafts()
    {
        $data['title'] = trans("drafts");
        $data['description'] = trans("drafts") . " - " . $this->app_name;
        $data['keywords'] = trans("drafts") . "," . $this->app_name;
        $data['page_url'] = generate_dash_url("drafts");

        $data['num_rows'] = $this->product_model->get_user_products_count($this->auth_user->id, 'draft');
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['products'] = $this->product_model->get_paginated_user_products($this->auth_user->id, 'draft', $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/product/products', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Drafts
     */
    public function drafts_service()
    {
        $data['title'] = trans("drafts");
        $data['description'] = trans("drafts") . " - " . $this->app_name;
        $data['keywords'] = trans("drafts") . "," . $this->app_name;
        $data['page_url'] = generate_dash_url("drafts");

        $data['num_rows'] = $this->product_model->get_user_products_count($this->auth_user->id, 'draft');
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['products'] = $this->product_model->get_paginated_user_products($this->auth_user->id, 'draft', $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/service/services', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Expired Products
     */
    public function expired_products()
    {
        if ($this->general_settings->membership_plans_system != 1) {
            redirect(dashboard_url());
            exit();
        }

        $data['title'] = trans("expired_products");
        $data['description'] = trans("expired_products") . " - " . $this->app_name;
        $data['keywords'] = trans("expired_products") . "," . $this->app_name;
        $data['page_url'] = generate_dash_url("expired_products");
        $data['main_settings'] = get_main_settings();

        $data['num_rows'] = $this->product_model->get_user_products_count($this->auth_user->id, 'expired');
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['products'] = $this->product_model->get_paginated_user_products($this->auth_user->id, 'expired', $pagination['per_page'], $pagination['offset']);

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/product/products', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Delete Product
     */
    public function delete_product()
    {
        $id = $this->input->post('id', true);
        //user id
        $user_id = 0;
        $product = $this->product_admin_model->get_product($id);
        if (!empty($product)) {
            $user_id = $product->user_id;
        }
        $result = false;
        if ($this->auth_user->role == "admin" || $this->auth_user->id == $user_id) {
            if ($product->is_draft == 1) {
                $result = $this->product_admin_model->delete_product_permanently($id);
            } else {
                $result = $this->product_model->delete_product($id);
            }
        }
        // var_dump($result);
        // die();
        if ($result) {
            $this->session->set_flashdata('success', trans("msg_product_deleted"));
            //reset cache
            reset_cache_data_on_change();
            reset_user_cache_data($user_id);
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }


    /**
     * Pending Products
     */
    public function pending_services()
    {
        $data['title'] = "Pending Services";
        $data['description'] = "Pending Services" . " - " . $this->app_name;
        $data['keywords'] = "Pending Services" . "," . $this->app_name;
        $data['page_url'] = generate_dash_url("pending_services");

        $data['num_rows'] = $this->product_model->get_user_products_count($this->auth_user->id, 'pending');
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['products'] = $this->product_model->get_paginated_user_products($this->auth_user->id, 'pending', $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/service/services', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Hidden Products
     */
    public function hidden_services()
    {
        $data['title'] = "Hidden Services";
        $data['description'] = "Hidden Services" . " - " . $this->app_name;
        $data['keywords'] = "Hidden Services" . "," . $this->app_name;
        $data['page_url'] = generate_dash_url("hidden_services");

        $data['num_rows'] = $this->product_model->get_user_products_count($this->auth_user->id, 'hidden');
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['products'] = $this->product_model->get_paginated_user_products($this->auth_user->id, 'hidden', $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/service/services', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Drafts
     */
    // public function drafts()
    // {
    //     $data['title'] = trans("drafts");
    //     $data['description'] = trans("drafts") . " - " . $this->app_name;
    //     $data['keywords'] = trans("drafts") . "," . $this->app_name;
    //     $data['page_url'] = generate_dash_url("drafts");

    //     $data['num_rows'] = $this->product_model->get_user_products_count($this->auth_user->id, 'draft');
    //     $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
    //     $data['products'] = $this->product_model->get_paginated_user_products($this->auth_user->id, 'draft', $pagination['per_page'], $pagination['offset']);
    //     $data['main_settings'] = get_main_settings();

    //     $this->load->view('dashboard/includes/_header', $data);
    //     $this->load->view('dashboard/product/products', $data);
    //     $this->load->view('dashboard/includes/_footer');
    // }

    /**
     * Expired Products
     */
    public function expired_services()
    {
        if ($this->general_settings->membership_plans_system != 1) {
            redirect(dashboard_url());
            exit();
        }

        $data['title'] = "Expired Services";
        $data['description'] = "Expired Services" . " - " . $this->app_name;
        $data['keywords'] = "Expired Services" . "," . $this->app_name;
        $data['page_url'] = generate_dash_url("expired_services");
        $data['main_settings'] = get_main_settings();

        $data['num_rows'] = $this->product_model->get_user_products_count($this->auth_user->id, 'expired');
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['products'] = $this->product_model->get_paginated_user_products($this->auth_user->id, 'expired', $pagination['per_page'], $pagination['offset']);

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/service/services', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Delete Product
     */
    public function delete_service()
    {
        $id = $this->input->post('id', true);
        //user id
        $user_id = 0;
        $product = $this->product_admin_model->get_product($id);
        if (!empty($product)) {
            $user_id = $product->user_id;
        }
        $result = false;
        if ($this->auth_user->role == "admin" || $this->auth_user->id == $user_id) {
            if ($product->is_draft == 1) {
                $result = $this->product_admin_model->delete_product_permanently($id);
            } else {
                $result = $this->product_model->delete_product($id);
            }
        }
        if ($result) {
            $this->session->set_flashdata('success', "Service Successfully Deleted");
            //reset cache
            reset_cache_data_on_change();
            reset_user_cache_data($user_id);
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
    }

    //get subcategories
    public function get_subcategories()
    {
        $parent_id = $this->input->post('parent_id', true);
        if (!empty($parent_id)) {
            $subcategories = $this->category_model->get_subcategories_by_parent_id($parent_id);
            foreach ($subcategories as $item) {
                echo '<option value="' . $item->id . '">' . $item->name . '</option>';
            }
        }
    }

    public function shop_open_close()
    {

        $data['is_shop_open'] = $this->input->post('is_shop_open', true);
        //var_dump($data);exit;
        $response = $this->front_model->shop_open_close($data);
        echo $response;
    }

    /*
    *------------------------------------------------------------------------------------------
    * LICENSE KEYS
    *------------------------------------------------------------------------------------------
    */
    //add license keys
    public function add_license_keys()
    {
        post_method();
        $product_id = $this->input->post('product_id', true);
        $product = $this->product_model->get_product_by_id($product_id);

        if (!empty($product)) {
            if ($this->auth_user->id == $product->user_id || $this->auth_user->role == 'admin') {
                $this->product_model->add_license_keys($product_id);
                $this->session->set_flashdata('success', trans("msg_add_license_keys"));
                $data = array(
                    'result' => 1,
                    'success_message' => $this->load->view('dashboard/includes/_messages', '', true)
                );
                echo json_encode($data);
                reset_flash_data();
            }
        }
    }

    //delete license key
    public function delete_license_key()
    {
        post_method();
        $id = $this->input->post('id', true);
        $product_id = $this->input->post('product_id', true);
        $product = $this->product_model->get_product_by_id($product_id);
        if (!empty($product)) {
            if ($this->auth_user->id == $product->user_id || $this->auth_user->role == 'admin') {
                $this->product_model->delete_license_key($id);
            }
        }
    }

    //refresh license keys list
    public function refresh_license_keys_list()
    {
        post_method();
        $product_id = $this->input->post('product_id', true);
        $data['product'] = $this->product_model->get_product_by_id($product_id);
        if (!empty($data['product'])) {
            if ($this->auth_user->id == $data['product']->user_id || $this->auth_user->role == 'admin') {
                $data['license_keys'] = $this->product_model->get_license_keys($product_id);
                $this->load->view("dashboard/product/license/_license_keys_list", $data);
            }
        }
    }

    /*
    *------------------------------------------------------------------------------------------
    * CSV BULK IMPORT
    *------------------------------------------------------------------------------------------
    */

    /**
     * Bulk Product Upload
     */
    public function bulk_product_upload()
    {
        $data['title'] = trans("bulk_product_upload");
        $view = !$this->membership_model->is_allowed_adding_product() ? 'plan_expired' : 'bulk_product_upload';
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/product/' . $view, $data);
        $this->load->view('dashboard/includes/_footer');
    }


    /**
     * Bulk Product Upload NEW
     */
    public function bulk_product_upload_demo_file()
    {
        $data['title'] = trans("bulk_product_upload_sample_download");
        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/product/bulk_upload', $data);
        $this->load->view('dashboard/includes/_footer');
    }


    public function downlaod_sample_product_upload()
    {
        $seller_id = $this->auth_user->id;
        $parent_lvl_cat_id = get_parent_category_id();
        $last_lvl_cat_id = get_dropdown_category_id();
        $last_cat_name = $this->product_model->get_cat_name($last_lvl_cat_id);

        if ($parent_lvl_cat_id == 1) {
            $file_name = 'fashion';
        } elseif ($parent_lvl_cat_id == 2) {
            $file_name = 'homecook';
        } elseif ($parent_lvl_cat_id == 3) {
            $file_name = 'grocery';
        } elseif ($parent_lvl_cat_id == 4) {
            $file_name = 'home';
        } elseif ($parent_lvl_cat_id == 5) {
            $file_name = 'personalcare';
        } elseif ($parent_lvl_cat_id == 6) {
            $file_name = 'kidscorner';
        } elseif ($parent_lvl_cat_id == 7) {
            $file_name = 'art';
        } elseif ($parent_lvl_cat_id == 8) {
            $file_name = 'gifts';
        }

        $data = array(
            'batch_name' => $file_name . "-" . $last_cat_name,
            'seller_id' => $seller_id,
            'category_id' => $last_lvl_cat_id,
            'creation_date' => date('Y-m-d H:i:s')
        );

        $this->product_model->save_batch_download($data);
        $this->download_sample_file($parent_lvl_cat_id);
    }

    public function bulk_service_upload()
    {
        $data['title'] = "Bulk Service Upload";
        $view = !$this->membership_model->is_allowed_adding_product() ? 'plan_expired' : 'bulk_service_upload';
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/service/' . $view, $data);
        $this->load->view('dashboard/includes/_footer');
    }


    /**
     * Download Sample Bulk Product Upload File
     */
    public function download_sample_file($parent_lvl_cat_id)
    {
        $parent_id = $parent_lvl_cat_id;
        if ($parent_id == 1) {
            $this->load->helper('download');
            force_download(FCPATH . "uploads/temp/fashion.xls", NULL);
        } elseif ($parent_id == 2) {
            $this->load->helper('download');
            force_download(FCPATH . "uploads/temp/homecook.xls", NULL);
        } elseif ($parent_id == 3) {
            $this->load->helper('download');
            force_download(FCPATH . "uploads/temp/grocery.xls", NULL);
        } elseif ($parent_id == 4) {
            $this->load->helper('download');
            force_download(FCPATH . "uploads/temp/home.xls", NULL);
        } elseif ($parent_id == 5) {
            $this->load->helper('download');
            force_download(FCPATH . "uploads/temp/personalcare.xls", NULL);
        } elseif ($parent_id == 6) {
            $this->load->helper('download');
            force_download(FCPATH . "uploads/temp/kidscorner.xls", NULL);
        } elseif ($parent_id == 7) {
            $this->load->helper('download');
            force_download(FCPATH . "uploads/temp/art.xls", NULL);
        } elseif ($parent_id == 8) {
            $this->load->helper('download');
            force_download(FCPATH . "uploads/temp/gifts.xls", NULL);
        }
    }


    /**
     * Download CSV Files Post
     */
    public function download_csv_files_post()
    {
        post_method();
        $submit = $this->input->post('submit', true);
        if ($submit == 'csv_template') {
            $this->load->helper('download');
            force_download(FCPATH . "assets/file/csv_product_template.csv", NULL);
        } elseif ($submit == 'csv_example') {
            $this->load->helper('download');
            force_download(FCPATH . "assets/file/csv_product_example.csv", NULL);
        }
    }

    /**
     * Generate CSV Object Post
     */
    public function generate_csv_object_post()
    {
        //delete old txt files
        $files = glob(FCPATH . 'uploads/temp/*.txt');
        $now = time();
        if (!empty($files)) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    if ($now - filemtime($file) >= 60 * 60 * 24) {
                        @unlink($file);
                    }
                }
            }
        }
        $file = null;
        if (isset($_FILES['file'])) {
            if (!empty($_FILES['file']['name'])) {
                $file = $_FILES['file'];
            }
        }
        $file_path = "";
        $config['upload_path'] = './uploads/temp/';
        $config['allowed_types'] = 'csv';
        $config['file_name'] = uniqid();
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
            $data = $this->upload->data();
            if (isset($data['full_path'])) {
                $file_path = $data['full_path'];
            }
        } else {
            $data = array('error' => $this->upload->display_errors());
            echo json_encode($data);
            exit();
        }
        if (!empty($file_path)) {
            $csv_object = $this->product_admin_model->generate_csv_object($file_path);
            if (!empty($csv_object)) {
                $data = array(
                    'result' => 1,
                    'number_of_items' => $csv_object->number_of_items,
                    'txt_file_name' => $csv_object->txt_file_name,
                );
                echo json_encode($data);
                exit();
            }
        }
        $data = array(
            'result' => 0
        );
        echo json_encode($data);
    }

    /**
     * Import CSV Item Post
     */
    public function import_csv_item_post()
    {
        $txt_file_name = $this->input->post('txt_file_name', true);
        $index = $this->input->post('index', true);

        $name = $this->product_admin_model->import_csv_item($txt_file_name, $index);
        if (!empty($name)) {
            $data = array(
                'result' => 1,
                'name' => $name,
                'index' => $index
            );
            echo json_encode($data);
        } else {
            $data = array(
                'result' => 0,
                'index' => $index
            );
            echo json_encode($data);
        }
    }

    /*
    *------------------------------------------------------------------------------------------
    * PROMOTE
    *------------------------------------------------------------------------------------------
    */

    /**
     * Pricing Post
     */
    public function pricing_post()
    {
        $product_id = $this->input->post('product_id', true);
        $product = $this->product_model->get_product_by_id($product_id);
        if (!empty($product)) {
            if ($product->user_id != $this->auth_user->id) {
                $this->session->set_flashdata('error', trans("invalid_attempt"));
                redirect($this->agent->referrer());
                exit();
            }

            $plan_type = $this->input->post('plan_type', true);
            $price_per_day = get_price($this->payment_settings->price_per_day, 'decimal');
            $price_per_month = get_price($this->payment_settings->price_per_month, 'decimal');

            $day_count = $this->input->post('day_count', true);
            $month_count = $this->input->post('month_count', true);
            $total_amount = 0;
            if ($plan_type == "daily") {
                $total_amount = number_format($day_count * $price_per_day, 2, ".", "") * 100;
                $purchased_plan = trans("daily_plan") . " (" . $day_count . " " . trans("days") . ")";
            }
            if ($plan_type == "monthly") {
                $day_count = $month_count * 30;
                $total_amount = number_format($month_count * $price_per_month, 2, ".", "") * 100;
                $purchased_plan = trans("monthly_plan") . " (" . $day_count . " " . trans("days") . ")";
            }
            $data = new stdClass();
            $data->plan_type = $this->input->post('plan_type', true);
            $data->product_id = $product_id;
            $data->day_count = $day_count;
            $data->month_count = $month_count;
            $data->total_amount = $total_amount;
            $data->purchased_plan = $purchased_plan;

            if ($this->payment_settings->free_product_promotion == 1) {
                $this->promote_model->add_to_promoted_products($data);
                redirect($this->agent->referrer());
            } else {
                $this->session->set_userdata('modesy_selected_promoted_plan', $data);
                redirect(generate_url("cart", "payment_method") . "?payment_type=promote");
            }
        }
        $this->session->set_flashdata('error', trans("invalid_attempt"));
        redirect($this->agent->referrer());
    }


    /*
    *------------------------------------------------------------------------------------------
    * Barter System
    *------------------------------------------------------------------------------------------
    */

    /**
     * Barter system
     */
    public function barter_system()
    {
        if (!$this->is_sale_active) {
            redirect(dashboard_url());
        }
        $data['title'] = "Barter System";
        $data['description'] = "Jadh Se Judo,Barter Karo" . " - " . $this->app_name;
        $data['keywords'] = "Barter System" . "," . $this->app_name;
        $data['active_page'] = "barter_system";
        $data['page_url'] = generate_dash_url("barter_system");

        // $data['num_rows'] = $this->order_model->get_sales_count($this->auth_user->id);
        // $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        // $data['sales'] = $this->order_model->get_paginated_sales($this->auth_user->id, $pagination['per_page'], $pagination['offset']);
        // $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/barter/barter_system', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    public function product_inventory()
    {
        if (!$this->is_sale_active) {


            redirect(dashboard_url());
        }
        $data['title'] = "Inventory";
        $data['description'] = "Inventory" . " - " . $this->app_name;
        $data['keywords'] = "Inventory" . "," . $this->app_name;
        $data['active_page'] = "product-inventory";
        $data['page_url'] = generate_dash_url("product_inventory");
        $data['num_rows'] = $this->product_model->get_user_products_count($this->auth_user->id, 'active');
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['products'] = $this->product_model->get_paginated_user_products($this->auth_user->id, 'active', $pagination['per_page'], $pagination['offset']);


        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/product/inventory', $data);
        $this->load->view('dashboard/includes/_footer');
    }
    public function with_variaton_products()
    {
        if (!$this->is_sale_active) {


            redirect(dashboard_url());
        }
        $data['title'] = "Inventory";
        $data['description'] = "Inventory" . " - " . $this->app_name;
        $data['keywords'] = "Inventory" . "," . $this->app_name;
        $data['active_page'] = "product-inventory";
        $data['page_url'] = generate_dash_url("product_inventory");
        $data['num_rows'] = $this->product_model->get_user_products_count($this->auth_user->id, 'active');
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['products'] = $this->product_model->get_paginated_user_products($this->auth_user->id, 'active', $pagination['per_page'], $pagination['offset']);


        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/product/with_variaton_products', $data);
        $this->load->view('dashboard/includes/_footer');
    }
    public function without_variaton_products()
    {
        if (!$this->is_sale_active) {


            redirect(dashboard_url());
        }
        $data['title'] = "Inventory";
        $data['description'] = "Inventory" . " - " . $this->app_name;
        $data['keywords'] = "Inventory" . "," . $this->app_name;
        $data['active_page'] = "product-inventory";
        $data['page_url'] = generate_dash_url("product_inventory");
        $data['num_rows'] = $this->product_model->get_user_products_count($this->auth_user->id, 'active');
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['products'] = $this->product_model->get_paginated_user_products($this->auth_user->id, 'active', $pagination['per_page'], $pagination['offset']);


        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/product/without_variaton_products', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /*
    *------------------------------------------------------------------------------------------
    * SALES
    *------------------------------------------------------------------------------------------
    */

    /**
     * Sales
     */
    public function sales()
    {
        if (!$this->is_sale_active) {
            redirect(dashboard_url());
        }
        $data['title'] = trans("sales");
        $data['description'] = trans("sales") . " - " . $this->app_name;
        $data['keywords'] = trans("sales") . "," . $this->app_name;
        $data['active_page'] = "sales";
        $data['page_url'] = generate_dash_url("sales");

        $data['num_rows'] = $this->order_model->get_pending_sales_count($this->auth_user->id);
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['sales'] = $this->order_model->get_paginated_pending_sales($this->auth_user->id, $pagination['per_page'], $pagination['offset']);

        $data['main_settings'] = get_main_settings();
        $product_id = $this->input->post('product_id');
        $product = $this->product_model->get_product_by_id($product_id);

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/sales/sales', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Completed Sales
     */
    public function completed_sales()
    {
        if (!$this->is_sale_active) {
            redirect(dashboard_url());
        }
        $data['title'] = trans("completed_sales");
        $data['description'] = trans("completed_sales") . " - " . $this->app_name;
        $data['keywords'] = trans("completed_sales") . "," . $this->app_name;
        $data['active_page'] = "completed_sales";
        $data['page_url'] = generate_dash_url("completed_sales");

        $data['num_rows'] = $this->order_model->get_completed_sales_count($this->auth_user->id);
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['sales'] = $this->order_model->get_paginated_completed_sales($this->auth_user->id, $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/sales/sales', $data);
        $this->load->view('dashboard/includes/_footer');
    }


    public function accepted_sales()
    {
        if (!$this->is_sale_active) {
            redirect(dashboard_url());
        }
        $data['title'] = trans("accepted_sales");
        $data['description'] = trans("accepted_sales") . " - " . $this->app_name;
        $data['keywords'] = trans("accepted_sales") . "," . $this->app_name;
        $data['active_page'] = "accepted_sales";
        $data['page_url'] = generate_dash_url("accepted_sales");

        $data['num_rows'] = $this->order_model->get_accepted_sales_count($this->auth_user->id);
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['sales'] = $this->order_model->get_paginated_accepted_sales($this->auth_user->id, $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/sales/sales', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Rejected Sales
     */
    public function rejected_sales()
    {
        if (!$this->is_sale_active) {
            redirect(dashboard_url());
        }
        $data['title'] = trans("rejected_sales");
        $data['description'] = trans("rejected_sales") . " - " . $this->app_name;
        $data['keywords'] = trans("rejected_sales") . "," . $this->app_name;
        $data['active_page'] = "rejected_sales";
        $data['page_url'] = generate_dash_url("rejected_sales");

        $data['num_rows'] = $this->order_model->get_rejected_sales_count($this->auth_user->id);
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['sales'] = $this->order_model->get_paginated_rejected_sales($this->auth_user->id, $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/sales/sales', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Waiting for pickup Sales
     */
    public function awaiting_pickup()
    {
        if (!$this->is_sale_active) {
            redirect(dashboard_url());
        }
        $data['title'] = trans("awaiting_pickup");
        $data['description'] = trans("awaiting_pickup") . " - " . $this->app_name;
        $data['keywords'] = trans("awaiting_pickup") . "," . $this->app_name;
        $data['active_page'] = "awaiting_pickup";
        $data['page_url'] = generate_dash_url("awaiting_pickup");

        $data['num_rows'] = $this->order_model->get_awaiting_pickup_sales_count($this->auth_user->id);
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['sales'] = $this->order_model->get_paginated_awaiting_pickup_sales($this->auth_user->id, $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/sales/sales', $data);
        $this->load->view('dashboard/includes/_footer');
    }


    /**
     * Waiting for pickup Sales
     */
    public function shipped()
    {
        if (!$this->is_sale_active) {
            redirect(dashboard_url());
        }
        $data['title'] = trans("shipped");
        $data['description'] = trans("shipped") . " - " . $this->app_name;
        $data['keywords'] = trans("shipped") . "," . $this->app_name;
        $data['active_page'] = "shipped";
        $data['page_url'] = generate_dash_url("shipped");

        $data['num_rows'] = $this->order_model->get_shipped_sales_count($this->auth_user->id);
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['sales'] = $this->order_model->get_paginated_shipped_sales($this->auth_user->id, $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/sales/sales', $data);
        $this->load->view('dashboard/includes/_footer');
    }


    /**
     * User Cancelled Sales
     */
    public function cancelled_by_user()
    {
        if (!$this->is_sale_active) {
            redirect(dashboard_url());
        }
        $data['title'] = trans("cancelled_by_user");
        $data['description'] = trans("cancelled_by_user") . " - " . $this->app_name;
        $data['keywords'] = trans("cancelled_by_user") . "," . $this->app_name;
        $data['active_page'] = "cancelled_by_user";
        $data['page_url'] = generate_dash_url("cancelled_by_user");

        $data['num_rows'] = $this->order_model->get_cancelled_by_user_count($this->auth_user->id);
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['sales'] = $this->order_model->get_paginated_cancelled_by_user($this->auth_user->id, $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/sales/sales', $data);
        $this->load->view('dashboard/includes/_footer');
    }
    public function return_orders()
    {
        if (!$this->is_sale_active) {
            redirect(dashboard_url());
        }
        $data['title'] = "Return Orders";
        $data['description'] = trans("cancelled_by_user") . " - " . $this->app_name;
        $data['keywords'] = trans("cancelled_by_user") . "," . $this->app_name;
        $data['active_page'] = "RTO";
        $data['page_url'] = generate_dash_url("return_orders");

        $data['num_rows'] = $this->order_model->get_return_orders_count($this->auth_user->id);
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['sales'] = $this->order_model->get_return_orders($this->auth_user->id, $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/sales/return', $data);
        $this->load->view('dashboard/includes/_footer');
    }
    public function get_other_order_status()
    {
        $data['title'] = "Other Orders";
        $data['description'] = trans("cancelled_by_user") . " - " . $this->app_name;
        $data['keywords'] = trans("cancelled_by_user") . "," . $this->app_name;
        $data['active_page'] = "Other Orders";
        $data['page_url'] = generate_dash_url("other_orders");
        $data["num_rows"] = $this->order_model->get_order_count($this->auth_user->id);
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['sales'] = $this->order_model->get_other_order_status($this->auth_user->id, $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/sales/other_orders', $data);
        $this->load->view('dashboard/includes/_footer');
    }
    /**
     * User Cancelled Sales
     */
    public function cancelled_by_seller()
    {
        if (!$this->is_sale_active) {
            redirect(dashboard_url());
        }
        $data['title'] = trans("cancelled_by_seller");
        $data['description'] = trans("cancelled_by_seller") . " - " . $this->app_name;
        $data['keywords'] = trans("cancelled_by_seller") . "," . $this->app_name;
        $data['active_page'] = "cancelled_by_seller";
        $data['page_url'] = generate_dash_url("cancelled_by_seller");

        $data['num_rows'] = $this->order_model->get_cancelled_by_seller_count($this->auth_user->id);
        $pagination = $this->paginate($data['page_url'], $data['num_rows'], $this->per_page);
        $data['sales'] = $this->order_model->get_paginated_cancelled_by_seller($this->auth_user->id, $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/sales/sales', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Sale
     */
    public function sale($order_number)
    {
        if (!$this->is_sale_active) {
            // var_dump("hello");
            // die();
            redirect(dashboard_url());
        }
        $data['title'] = trans("sales");
        $data['description'] = trans("sales") . " - " . $this->app_name;
        $data['keywords'] = trans("sales") . "," . $this->app_name;
        $data["active_tab"] = "";
        $data["order"] = $this->order_model->get_order_by_order_number($order_number);
        // var_dump($data["order"]);
        // die();
        if (empty($data["order"])) {
            redirect(lang_base_url());
        }
        if (!$this->order_model->check_order_seller($data["order"]->id)) {
            redirect(lang_base_url());
        }
        if (empty($_SESSION['modesy_sess_user_shiprocket_token'])) {
            $data["shiprocket"] = $this->shiprocket();
        }
        $data['order_supplier'] = $this->order_model->get_charges_seller_wise1($data['order']->id);
        $data["order_products"] = $this->order_model->get_order_products($data["order"]->id);

        $data["reject_reason"] = $this->order_model->get_reject_reason();
        $data['main_settings'] = get_main_settings();

        $product = array();
        foreach ($data["order_products"] as $order_details) {
            array_push($product, $this->product_model->get_product_by_id($order_details->product_id));
        }
        $data["products"] = $product;
        $data["products_order"] = $this->order_model->get_products_order($data["order"]->id, $this->auth_user->id);
        $data["order_count"] = $this->order_model->count_order_products($data["order"]->id, $this->auth_user->id);
        // $data['check'] = $this->order_model->get_stats($data["order"]->id, ($order_details->product_id));
        $data["orders_count"] = $this->order_model->get_seller_count_order_products($data["order"]->id, $this->auth_user->id);
        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/sales/sale', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    public function track_status($awb_number)
    {
        if (!$this->is_sale_active) {
            redirect(dashboard_url());
        }
        $data['title'] = trans("sales");
        $data['description'] = trans("sales") . " - " . $this->app_name;
        $data['keywords'] = trans("sales") . "," . $this->app_name;
        $data["active_tab"] = "";

        $data["reject_reason"] = $this->order_model->get_reject_reason();

        $data['main_settings'] = get_main_settings();
        $data["check"] = get_shiprocket_order_details_by_awb($awb_number);
        $response = $this->order_model->shiprocket_tracking_status($awb_number);

        $tracking_status = $response->tracking_data->track_status;
        $data['tracking_status'] = $tracking_status;
        if ($tracking_status) {
            $data['track_statuses'] = $response->tracking_data->shipment_track_activities;
            $data['c_status'] = $response->tracking_data->shipment_track[0]->current_status;
            $data['url'] = $response->tracking_data->track_url;
        }

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/sales/order_status', $data);
        $this->load->view('dashboard/includes/_footer');
    }
    // public function cancelorder()
    // {
    //     if (!$this->is_sale_active) {
    //         redirect(dashboard_url());
    //     }
    //     $data['title'] = trans("sales");
    //     $data['description'] = trans("sales") . " - " . $this->app_name;
    //     $data['keywords'] = trans("sales") . "," . $this->app_name;
    //     $data["active_tab"] = "";
    //     $data["order"] = $this->order_model->get_order_by_order_number($order_number);
    //     if (empty($data["order"])) {
    //         redirect(lang_base_url());
    //     }
    //     if (!$this->order_model->check_order_seller($data["order"]->id)) {
    //         redirect(lang_base_url());
    //     }
    //     $data["order_products"] = $this->order_model->get_order_products($data["order"]->id);

    //     $data["reject_reason"] = $this->order_model->get_reject_reason();

    //     $data['main_settings'] = get_main_settings();

    //     $product = array();
    //     foreach ($data["order_products"] as $order_details) {
    //         array_push($product, $this->product_model->get_product_by_id($order_details->product_id));
    //     }
    //     $data["products"] = $product;
    //     $data['order_cancel'] = $this->order_model->cancel_order($data["order"]->id, $order_details->product_id);
    //     $this->load->view('dashboard/includes/_header', $data);
    //     $this->load->view('dashboard/sales/order_cancel', $data);
    //     $this->load->view('dashboard/includes/_footer');
    // }

    /**
     * Update Order Product Status Post
     * 
     */
    public function update_order_product_status_post()
    {
        $id = $this->input->post('id', true);
        // $this->penalty_calculate($id);
        $action = $this->input->post('update', true);
        // var_dump($action);die();
        $reject_reason_comment = $this->input->post('reject_reason_comment1', true);
        $order_product = $this->order_model->get_order_product($id);


        // $payment = get_product_transaction_details($id);
        // $payment_method = $payment["payment_method"];
        $order_product = $this->order_model->get_order_product($id);
        $order_id = $order_product->order_id;
        $order_detail = $this->order_model->get_order_detail_by_id($order_id);
        $payment_method = $order_detail[0]->payment_method;


        if ($this->auth_user->id != $order_product->seller_id) {
            redirect($this->agent->referrer());
            exit();
        }
        if (!empty($order_product)) {
            if ($this->order_model->update_order_product_status($id, $reject_reason_comment)) {
                if ($action == "cancel_order") {
                    $this->penalty_calculate($id);
                    if ($payment_method == "Cashfree") {
                        $this->refund_api_data($id);
                        if ($this->general_settings->enable_easysplit == 0) {
                            $this->order_model->recal_prepaid_seller_payable($order_id);
                        }
                    } else {
                        $this->order_model->recal_cod_seller_payable($order_id);
                    }
                }
                $this->order_admin_model->update_order_status_if_completed($order_product->order_id);
            }
        }
        redirect($this->agent->referrer());
    }

    public function update_stock_without_variation()
    {
        $id = $this->input->post('id', true);
        $stock = $this->input->post('stock', true);
        // $product = $this->product_model->get_product_by_id($id);

        $product = $this->product_model->get_product_by_id($id);

        if (!empty($product)) {
            if ($this->product_model->without_variation_stock_update($id, $stock)) {
            }
        }
        redirect($this->agent->referrer());
    }

    public function update_stock_post()
    {
        $id = $this->input->post('id', true);
        $stock = $this->input->post('stock', true);
        // $product = $this->product_model->get_product_by_id($id);

        $product = $this->product_model->get_product_by_id($id);

        if (!empty($product)) {
            if ($this->product_model->update_stock($id, $stock)) {
            }
        }
        redirect($this->agent->referrer());
        // redirect($this->agent->referrer());
    }
    public function update_stock_post_variation()
    {
        $id = $this->input->post('id', true);
        $stock = $this->input->post('stock_' . $id, true);
        // var_dump($stock);
        // die();
        $product_id = $this->variation_model->get_product_by_variation_id($id);
        // var_dump($product_id);
        // die();
        $product = $this->variation_model->get_variation_option($id);

        if (!empty($product)) {
            if ($this->product_model->update_variation_stock($id, $stock)) {
            }
            if ($product->is_default == 1) {
                $this->product_model->update_stock($product_id[0]->product_id, $stock);
            }
        }

        redirect($this->agent->referrer());
    }

    public function update_stock_without_variation_products()
    {
        $id = $this->input->post('id', true);
        $stock = $this->input->post('stock', true);
        $product_id = $this->variation_model->get_product_by_variation_id($id);
        $product = $this->variation_model->get_variation_option($id);
        // $product = $this->product_model->get_product_by_id($id);

        if (!empty($id)) {
            // $i = 0;
            //foreach ($id as $ids) {
            if ($this->product_model->update_stock($id, $stock)) {
                if ($product->is_default == 1) {
                    $this->product_model->update_stock($product_id[0]->product_id, $stock);
                }
            }
            // $i++;
        }
        // }
        // redirect($this->agent->referrer());
    }
    public function update_stock_variation_product()
    {
        $id = $this->input->post('id', true);
        $stock = $this->input->post('stock', true);
        $product_id = $this->variation_model->get_product_by_variation_id($id);
        $product = $this->variation_model->get_variation_option($id);
        //  var_dump($id);
        // die();
        if (!empty($id)) {
            // $i = 0;
            // foreach ($id as $ids) {
            if ($this->product_model->update_variation_stock($id, $stock)) {
                if ($product->is_default == 1) {
                    $this->product_model->update_stock($product_id[0]->product_id, $stock);
                }
                // $i++;
            }
            // }
        }
        //redirect($this->agent->referrer());
    }




    /**
     * Add Shipping Tracking Number Post
     */
    public function add_shipping_tracking_number_post()
    {
        $id = $this->input->post('id', true);
        $id = json_decode($id);
        for ($i = 0; $i < count($id); $i++) {
            $order_product = $this->order_model->get_order_product($id[$i]);
            if (!empty($order_product)) {
                $this->order_model->add_shipping_tracking_number($id[$i]);
            }
        }
        redirect($this->agent->referrer());
    }

    /*
    *------------------------------------------------------------------------------------------
    * EARNINGS
    *------------------------------------------------------------------------------------------
    */

    /**
     * Earnings
     */
    public function earnings()
    {
        if (!$this->is_sale_active) {
            redirect(dashboard_url());
        }
        $data['title'] = trans("earnings");
        $data['description'] = trans("earnings") . " - " . $this->app_name;
        $data['keywords'] = trans("earnings") . "," . $this->app_name;

        $data['num_rows'] = $this->earnings_model->get_earnings_count($this->auth_user->id);
        $pagination = $this->paginate(generate_dash_url('earnings'), $data['num_rows'], $this->per_page);
        $data['earnings'] = $this->earnings_model->get_paginated_earnings($this->auth_user->id, $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/earnings/earnings', $data);
        $this->load->view('dashboard/includes/_footer');
    }





    /**
     * Penalties
     */
    public function penalties()
    {
        // if (!$this->is_sale_active) {
        //     redirect(dashboard_url());
        // }
        $data['title'] = trans("penalties");
        $data['description'] = trans("penalties") . " - " . $this->app_name;
        $data['keywords'] = trans("penalties") . "," . $this->app_name;

        $data['num_rows'] = $this->earnings_model->get_penalties_count($this->auth_user->id);
        $pagination = $this->paginate(generate_dash_url('penalties'), $data['num_rows'], $this->per_page);
        $data['penalties'] = $this->earnings_model->get_paginated_penalties($this->auth_user->id, $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();
        // var_dump($this->auth_user->id);die();
        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/earnings/penalties', $data);
        $this->load->view('dashboard/includes/_footer');
    }






    public function search_member()
    {
        get_method();
        $search = trim($this->input->get('search', TRUE));
        $search_type = 'member';
        $search = remove_special_characters($search);

        if (empty($search)) {
            redirect(lang_base_url());
        }

        if ($search_type == 'product') {
            redirect(generate_url("products") . '?search=' . $search);
        } else {
            redirect(generate_url("members_barter") . '?search=' . $search);
        }
    }

    /**
     * Members
     */
    public function members_barter()
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

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('barter_member', $data);
        $this->load->view('dashboard/includes/_footer');
    }



    /**
     * Payouts
     */
    public function payouts()
    {
        if (!$this->is_sale_active) {
            redirect(dashboard_url());
        }
        $data['title'] = trans("payouts");
        $data['description'] = trans("payouts") . " - " . $this->app_name;
        $data['keywords'] = trans("payouts") . "," . $this->app_name;

        $data['num_rows'] = $this->earnings_model->get_payouts_count($this->auth_user->id);
        $pagination = $this->paginate(generate_dash_url('payouts'), $data['num_rows'], $this->per_page);
        $data['payouts'] = $this->earnings_model->get_paginated_payouts($this->auth_user->id, $pagination['per_page'], $pagination['offset']);
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/earnings/payouts', $data);
        $this->load->view('dashboard/includes/_footer');
    }
    public function total_earning()
    {
        if (!$this->is_sale_active) {
            redirect(dashboard_url());
        }
        $data['title'] = trans("total_earning");
        $data['description'] = trans("total_earning") . " - " . $this->app_name;
        $data['keywords'] = trans("total_earning") . "," . $this->app_name;

        // $data['num_rows'] = $this->earnings_model->get_payouts_count($this->auth_user->id);
        // $pagination = $this->paginate(generate_dash_url('payouts'), $data['num_rows'], $this->per_page);
        // $data['payouts'] = $this->earnings_model->get_paginated_payouts($this->auth_user->id, $pagination['per_page'], $pagination['offset']);
        // $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/earnings/total_earning', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Withdraw Money
     */
    public function withdraw_money()
    {
        if (!$this->is_sale_active) {
            redirect(dashboard_url());
        }
        $data['title'] = trans("withdraw_money");
        $data['description'] = trans("withdraw_money") . " - " . $this->app_name;
        $data['keywords'] = trans("withdraw_money") . "," . $this->app_name;
        $data['main_settings'] = get_main_settings();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/earnings/withdraw_money', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Withdraw Money Post
     */
    public function withdraw_money_post()
    {
        if (!$this->is_sale_active) {
            redirect(dashboard_url());
        }
        $data = array(
            'user_id' => $this->auth_user->id,
            'payout_method' => $this->input->post('payout_method', true),
            'amount' => $this->input->post('amount', true),
            'currency' => $this->input->post('currency', true),
            'status' => 0,
            'created_at' => date('Y-m-d H:i:s')
        );
        $data["amount"] = get_price($data["amount"], 'database');

        //check active payouts
        $active_payouts = $this->earnings_model->get_active_payouts($this->auth_user->id);
        if (!empty($active_payouts)) {
            $this->session->set_flashdata('error', trans("active_payment_request_error"));
            redirect($this->agent->referrer());
        }

        $min = 0;
        if ($data["payout_method"] == "paypal") {
            //check PayPal email
            $payout_paypal_email = $this->earnings_model->get_user_payout_account($this->auth_user->id);
            if (empty($payout_paypal_email) || empty($payout_paypal_email->payout_paypal_email)) {
                $this->session->set_flashdata('error', trans("msg_payout_paypal_error"));
                redirect($this->agent->referrer());
            }
            $min = $this->payment_settings->min_payout_paypal;
        }
        if ($data["payout_method"] == "iban") {
            $min = $this->payment_settings->min_payout_iban;
        }
        if ($data["payout_method"] == "swift") {
            $min = $this->payment_settings->min_payout_swift;
        }

        if ($data["amount"] <= 0) {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
        if ($data["amount"] < $min) {
            $this->session->set_flashdata('error', trans("invalid_withdrawal_amount"));
            redirect($this->agent->referrer());
        }
        if ($data["amount"] > $this->auth_user->balance) {
            $this->session->set_flashdata('error', trans("invalid_withdrawal_amount"));
            redirect($this->agent->referrer());
        }
        if (!$this->earnings_model->withdraw_money($data)) {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
        $this->session->set_flashdata('success', trans("msg_request_sent"));
        redirect($this->agent->referrer());
    }

    /**
     * Set Payout Account
     */


    public function loyalty_level()
    {

        $this->load->view('dashboard/includes/_header');
        $this->load->view('loyalty_level');
        $this->load->view('dashboard/includes/_footer');
    }

    public function set_payout_account()
    {
        if (!$this->is_sale_active) {
            redirect(dashboard_url());
        }
        $data['title'] = trans("set_payout_account");
        $data['description'] = trans("set_payout_account") . " - " . $this->app_name;
        $data['keywords'] = trans("set_payout_account") . "," . $this->app_name;

        $data['user_payout'] = $this->earnings_model->get_user_payout_account($this->auth_user->id);
        if (empty($this->session->flashdata('msg_payout'))) {
            if ($this->payment_settings->payout_paypal_enabled) {
                $this->session->set_flashdata('msg_payout', "paypal");
            } elseif ($this->payment_settings->payout_iban_enabled) {
                $this->session->set_flashdata('msg_payout', "iban");
            } elseif ($this->payment_settings->payout_swift_enabled) {
                $this->session->set_flashdata('msg_payout', "swift");
            }
        }

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/earnings/set_payout_account', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Set Paypal Payout Account Post
     */
    public function set_paypal_payout_account_post()
    {
        if ($this->earnings_model->set_paypal_payout_account($this->auth_user->id)) {
            $this->session->set_flashdata('msg_payout', "paypal");
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('msg_payout', "paypal");
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Set IBAN Payout Account Post
     */
    public function set_iban_payout_account_post()
    {
        if ($this->earnings_model->set_iban_payout_account($this->auth_user->id)) {
            $this->session->set_flashdata('msg_payout', "iban");
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('msg_payout', "iban");
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Set SWIFT Payout Account Post
     */
    public function set_swift_payout_account_post()
    {
        if ($this->earnings_model->set_swift_payout_account($this->auth_user->id)) {
            $this->session->set_flashdata('msg_payout', "swift");
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('msg_payout', "swift");
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /*
    *------------------------------------------------------------------------------------------
    * QUOTE REQUESTS
    *------------------------------------------------------------------------------------------
    */

    /**
     * Quote Requests
     */
    public function quote_requests()
    {
        $this->load->model('bidding_model');
        if (!is_bidding_system_active()) {
            redirect(dashboard_url());
        }
        $data['title'] = trans("quote_requests");
        $data['description'] = trans("quote_requests") . " - " . $this->app_name;
        $data['keywords'] = trans("quote_requests") . "," . $this->app_name;

        $data['num_rows'] = $this->bidding_model->get_vendor_quote_requests_count($this->auth_user->id);
        $pagination = $this->paginate(generate_dash_url("quote_requests"), $data['num_rows'], $this->per_page);
        $data['quote_requests'] = $this->bidding_model->get_paginated_vendor_quote_requests($this->auth_user->id, $pagination['per_page'], $pagination['offset']);
        $data["session"] = get_user_session();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/quote_requests', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Submit Quote
     */
    public function submit_quote()
    {
        $this->load->model('bidding_model');
        $id = $this->input->post('id', true);
        $quote_request = $this->bidding_model->get_quote_request($id);
        if ($this->bidding_model->submit_quote($quote_request)) {
            //send email
            $buyer = get_user($quote_request->buyer_id);
            if (!empty($buyer) && $this->general_settings->send_email_bidding_system == 1) {
                $email_data = array(
                    'email_type' => 'email_general',
                    'to' => $buyer->email,
                    'subject' => trans("quote_request"),
                    'email_content' => trans("your_quote_request_replied") . "<br>" . trans("quote") . ": " . "<strong>#" . $quote_request->id . "</strong>",
                    'email_link' => generate_url("quote_requests"),
                    'email_button_text' => trans("view_details")
                );
                $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }



    /**
     * barter Requests
     */
    public function barter_requests()
    {
        $this->load->model('bidding_model');
        // if (!is_bidding_system_active()) {
        //     redirect(dashboard_url());
        // }
        $data['title'] = "Barter Requests";
        $data['description'] = "Barter Requests" . " - " . $this->app_name;
        $data['keywords'] = "Barter Requests" . "," . $this->app_name;

        $data['num_rows'] = $this->bidding_model->get_vendor_barter_requests_count($this->auth_user->id);
        $pagination = $this->paginate(generate_dash_url("barter_requests"), $data['num_rows'], $this->per_page);
        $data['quote_requests'] = $this->bidding_model->get_paginated_vendor_barter_requests($this->auth_user->id, $pagination['per_page'], $pagination['offset']);
        $data["session"] = get_user_session();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/barter_requests', $data);
        $this->load->view('dashboard/includes/_footer');
    }



    public function requested_barter()
    {
        $this->load->model('bidding_model');
        // if (!is_bidding_system_active()) {
        //     redirect(dashboard_url());
        // }
        $data['title'] = "Requested Barters";
        $data['description'] = "Requested Barters" . " - " . $this->app_name;
        $data['keywords'] = "Requested Barters" . "," . $this->app_name;

        $data['num_rows'] = $this->bidding_model->get_vendor_barter_requests_count($this->auth_user->id);
        $pagination = $this->paginate(generate_dash_url("barter_requests"), $data['num_rows'], $this->per_page);
        $data['quote_requests'] = $this->bidding_model->get_paginated_vendor_barter_requests($this->auth_user->id, $pagination['per_page'], $pagination['offset']);
        $data["session"] = get_user_session();

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/requested_barters', $data);
        $this->load->view('dashboard/includes/_footer');
    }



    /**
     * Submit barter
     */
    public function submit_barter()
    {
        $this->load->model('bidding_model');
        $id = $this->input->post('id', true);
        $quote_request = $this->bidding_model->get_barter_request($id);
        if ($this->bidding_model->submit_barter($quote_request)) {
            //send email
            $buyer = get_user($quote_request->buyer_id);
            if (!empty($buyer) && $this->general_settings->send_email_bidding_system == 1) {
                $email_data = array(
                    'email_type' => 'email_general',
                    'to' => $buyer->email,
                    'subject' => "Barter Request",
                    'email_content' => trans("your_quote_request_replied") . "<br>" . trans("quote") . ": " . "<strong>#" . $quote_request->id . "</strong>",
                    'email_link' => generate_url("quote_requests"),
                    'email_button_text' => trans("view_details")
                );
                $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
            }
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /*
    *------------------------------------------------------------------------------------------
    * MEMBERSHIP
    *------------------------------------------------------------------------------------------
    */

    /**
     * Payment History
     */
    public function payment_history()
    {
        $payment = input_get("payment");
        if ($payment == "membership") {
            if ($this->general_settings->membership_plans_system != 1) {
                redirect(dashboard_url());
                exit();
            }
            $data['title'] = trans("membership_payments");
            $data['description'] = trans("membership_payments") . " - " . $this->app_name;
            $data['keywords'] = trans("membership_payments") . "," . $this->app_name;

            $data['num_rows'] = $this->membership_model->get_membership_transactions_count($this->auth_user->id);
            $pagination = $this->paginate(generate_dash_url("payment_history") . '?payment=membership', $data['num_rows'], $this->per_page);
            $data['transactions'] = $this->membership_model->get_paginated_membership_transactions($this->auth_user->id, $pagination['per_page'], $pagination['offset']);
            $data["session"] = get_user_session();
            $this->load->view('dashboard/includes/_header', $data);
            $this->load->view('dashboard/payment_history/membership_transactions', $data);
            $this->load->view('dashboard/includes/_footer');
        } elseif ($payment == "promotion") {
            $data['title'] = trans("promotion_payments");
            $data['description'] = trans("promotion_payments") . " - " . $this->app_name;
            $data['keywords'] = trans("promotion_payments") . "," . $this->app_name;

            $data['num_rows'] = $this->promote_model->get_promoted_transactions_count($this->auth_user->id);
            $pagination = $this->paginate(generate_dash_url("payment_history") . '?payment=promotion', $data['num_rows'], $this->per_page);
            $data['transactions'] = $this->promote_model->get_paginated_promoted_transactions($this->auth_user->id, $pagination['per_page'], $pagination['offset']);

            $this->load->view('dashboard/includes/_header', $data);
            $this->load->view('dashboard/payment_history/promotion_transactions', $data);
            $this->load->view('dashboard/includes/_footer');
        } else {
            redirect(dashboard_url());
        }
    }

    /*
    *------------------------------------------------------------------------------------------
    * COMMENTS
    *------------------------------------------------------------------------------------------
    */

    /**
     * Comments
     */
    public function comments()
    {
        $data['title'] = trans("comments");
        $data['description'] = trans("comments") . " - " . $this->app_name;
        $data['keywords'] = trans("comments") . "," . $this->app_name;

        $data['num_rows'] = $this->comment_model->get_vendor_comments_count($this->auth_user->id);
        $pagination = $this->paginate(generate_dash_url("comments"), $data['num_rows'], $this->per_page);
        $data['comments'] = $this->comment_model->get_paginated_vendor_comments($this->auth_user->id, $pagination['per_page'], $pagination['offset']);
        $data["session"] = get_user_session();
        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/comments', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Reviews
     */
    public function reviews()
    {
        $data['title'] = trans("reviews");
        $data['description'] = trans("reviews") . " - " . $this->app_name;
        $data['keywords'] = trans("reviews") . "," . $this->app_name;
        $data["session"] = get_user_session();
        $data['num_rows'] = $this->review_model->get_vendor_reviews_count($this->auth_user->id);
        $pagination = $this->paginate(generate_dash_url("reviews"), $data['num_rows'], $this->per_page);
        $data['reviews'] = $this->review_model->get_paginated_vendor_reviews($this->auth_user->id, $pagination['per_page'], $pagination['offset']);

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/reviews', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /*
    *------------------------------------------------------------------------------------------
    * SHOP SETTINGS
    *------------------------------------------------------------------------------------------
    */

    /**
     * Shop Settings
     */
    public function shop_settings()
    {
        $data['title'] = trans("shop_settings");
        $data['description'] = trans("shop_settings") . " - " . $this->app_name;
        $data['keywords'] = trans("shop_settings") . "," . $this->app_name;
        $data["session"] = get_user_session();
        $data['user_plan'] = $this->membership_model->get_user_plan_by_user_id($this->auth_user->id);
        $data['days_left'] = $this->membership_model->get_user_plan_remaining_days_count($data['user_plan']);
        $data['ads_left'] = $this->membership_model->get_user_plan_remaining_ads_count($data['user_plan']);

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/shop_settings', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    /**
     * Shop Settings Post
     */
    public function shop_settings_post()
    {
        $shop_name = remove_special_characters($this->input->post('shop_name', true));
        if (!$this->auth_model->is_unique_shop_name($shop_name, $this->auth_user->id)) {
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            $this->session->set_flashdata('error', trans("msg_shop_name_unique_error"));
            redirect($this->agent->referrer());
            exit();
        }

        if ($this->profile_model->update_shop_settings($shop_name)) {
            $this->session->set_flashdata('success', trans("msg_updated"));
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }



    //get last product id
    public function last_product()
    {
        $last_item = $this->product_model->get_last_record();

        $data = array(
            'result' => 1,
            'last_record' => $last_item
        );
        echo json_encode($data);
    }
    public function get_shipment()
    {
        post_method();
        $this->order_model->schedule_penalty();
        $check_shipment = $this->order_model->shiprocket_response();
        if ($check_shipment == false) {
            $shipment = 'no';
            echo json_encode($shipment);
        } else {
            $shipment = 'yes';
            echo json_encode($shipment);
        }
    }



    //get last product id
    public function get_variation_option_count()
    {
        $product_id = $this->input->post('product_id');
        $product_sku = $this->input->post('sku');
        $total_options = $this->variation_model->get_all_option_count($product_id);
        $pattern = "A";
        $count = $total_options;
        while ($count > 0) {
            $pattern++;
            $count--;
        }

        $data = array(
            'result' => 1,
            'total_options' => $total_options,
            'sku_option' => $product_sku . $pattern
        );
        echo json_encode($data);
    }

    public function get_sku_code()
    {
        $product_sku = $this->input->post('sku');
        $data["sku"] = $this->product_model->get_sku();
        $data = array(
            'result' => 1,
            'sku_code' => $data["sku"]
        );
        echo json_encode($data);
    }

    public function add_review()
    {
        $data = array(
            'html_content' => ""
        );
        $review_text = $this->input->post('review_text', true);
        $supplier_id = $this->input->post('supplier_id', true);
        $result = $this->message_model->add_review($review_text, $supplier_id);
        if (!empty($result)) {
            $this->session->set_flashdata('success', "Review added Successfully !");
            $data["html_content"] = $this->load->view('partials/_messages', null, true);
            reset_flash_data();
            // redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            // redirect($this->agent->referrer());
            // header($this->agent->referrer());
        }
        echo json_encode($data);
        // redirect($this->agent->referrer());
        // $this->load->view('dashboard/includes/_header', $result);
        // $this->load->view('profile/buyer_profile', $result);
        // $this->load->view('dashboard/includes/_footer');
    }

    public function refund_api_data($order_product_id)
    {
        $order_product_id = clean_number($order_product_id);
        $order_product = $this->order_model->get_order_product($order_product_id);
        $order_id = $order_product->order_id;
        $product_id = $order_product->product_id;
        $product_name = $order_product->product_title;
        $total_price_with_quantity = $order_product->product_total_price;
        $product_seller_id = $order_product->seller_id;


        $order_transaction_detail = $this->order_model->get_transaction_detail($order_id);
        $payment_refrence_id = $order_transaction_detail[0]->payment_id;
        $refund_amount = $total_price_with_quantity / 100;
        $order_detail = $this->order_model->get_order_detail_by_id($order_id);

        // shipping charges seller & product wise
        $shipping_amount_without_round = ($order_product->product_shipping_cost) / 100;
        $shipping_amount = round($shipping_amount_without_round);

        //shipping charge check
        $include_shipping = true;
        $order_products =  $this->order_model->get_order_product_detail($order_id);
        foreach ($order_products as $products) {
            if ((int)$products->id != (int)$order_product_id) {
                if (($products->order_status == "completed" || $products->order_status == "processing" || $products->order_status == "waiting" || $products->order_status == "awaiting_shipment" || $products->order_status == "awaiting_pickup") && ($products->seller_id == $product_seller_id)) {
                    $include_shipping = false;
                    break;
                }
            }
        }

        if ($include_shipping) {
            // $shipping_amount = ($order_detail[0]->price_shipping) / 100;
            $refund_amount = $refund_amount + $shipping_amount;
        }

        $order_total_amount = $order_detail[0]->price_total;
        $data = array(
            "order_id" => $order_id,
            "refund_amount" => $refund_amount,
            "payment_refrence_id" => $payment_refrence_id,
            "order_product_table_id" => $order_product_id,
            "order_product_id" => $product_id,
            "order_total_amount" => $order_total_amount
        );

        $this->refund_api($refund_amount, $payment_refrence_id, $product_name, $data);
    }


    public function refund_api($refund_amount, $payment_refrence_id, $product_name, $data)
    {
        $refund_data = $data;
        $refund_amount = $refund_amount;
        $payment_refrence_id = $payment_refrence_id;
        $product_name = $product_name;
        $curl = curl_init();
        $cashfree_refundurl = $this->general_settings->cashfree_api_base_url . 'api/v1/order/refund';
        curl_setopt_array($curl, array(
            // CURLOPT_URL => '%7B%7BBase%20URL%7D%7D/api/v1/order/refund',
            CURLOPT_URL =>  $cashfree_refundurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'appId' => $this->general_settings->cashfree_app_id,
                'secretKey' => $this->general_settings->cashfree_secret_key,
                'referenceId' => $payment_refrence_id,
                'refundAmount' => $refund_amount,
                'refundNote' => 'Refund for ' . $product_name,
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $responded_data = json_decode($response);
        $refund_data["status"] = $responded_data->status;
        $refund_data["message"] = $responded_data->message;
        $refund_data["refund_id"] = $responded_data->refundId;
        $refund_data["refund_note"] = 'Refund for ' . $product_name;
        $refund_data["created_by"] = $this->auth_user->id;
        $this->order_model->save_refund_detail($refund_data);
    }

    public function hsn_validity_check()
    {
        $hsn_code = $this->input->post('hsn_code');
        $hsn_len = strlen($hsn_code);
        $data["rse"] = $this->product_model->hsn_validity($hsn_code, $hsn_len);
        echo json_encode($data);
    }

    public function penalty_calculate($order_product_table_id)
    {
        $order_product_table_id = clean_number($order_product_table_id);
        $order_product = $this->order_model->get_order_product($order_product_table_id);
        $order_id = $order_product->order_id;
        $product_id = $order_product->product_id;
        $seller_id = $order_product->seller_id;
        $order_created_at = $order_product->created_at;
        $product_shipping_cost = $order_product->product_shipping_cost;
        $commission_rate = $order_product->commission_rate;
        $total_amount_with_quantity = $order_product->product_total_price;
        // get product detail from product table
        $product = $this->order_model->get_product_detail($product_id);
        // $product_price_excluding_gst = $product[0]->price_exclude_gst;

        // check if product is made to stock or made to order
        $product_type = $product[0]->add_meet;
        $product_price_after_discount = $order_product->price_after_discount;
        $product_gst_rate = $order_product->product_gst_rate;
        $gst_cal = 1 + ($product_gst_rate / 100);
        $product_price_excluding_gst = round($product_price_after_discount / $gst_cal, 0);

        $quantity = $order_product->product_quantity;
        $user_id = $this->auth_user->id;
        $created_date = date('Y-m-d', strtotime($order_created_at));

        // get detail from lookup table
        $lookup_table_data = $this->order_model->get_product_shipping_days_from_db($product[0]->shipping_time);
        $estimated_days = $lookup_table_data->lookup_int_val;
        // $estimated_dispatch_date = date('Y-m-d', strtotime($created_date . +$estimated_days . "days"));
        $cancel_date = date("Y-m-d H:i:s");
        $amount = $product_price_excluding_gst / 100;
        $commission = $commission_rate / 100;
        $commission_amount_without_round = $amount * $commission;
        $commission_amount = round($commission_amount_without_round, 2);
        $gst_on_commission_amount = 0.18 * $commission_amount;
        $penalty_amount_with_gst = $commission_amount + $gst_on_commission_amount;
        $penalty_amount_with_gst_and_quantity = $penalty_amount_with_gst * $quantity;

        // check estimated date of dispatch according to product add meet
        if ($product_type == 'Made to order') {
            $lead_time_in_sec = $order_product->lead_time;
            $order_accepted_at = $order_product->accepted_at;
            $accepted_at_in_sec = strtotime($order_accepted_at);

            $total_estimated_dispatch_in_sec = $accepted_at_in_sec + $lead_time_in_sec;
            $estimated_dispatch_date = date('Y-m-d H:i:s', $total_estimated_dispatch_in_sec);
        } elseif ($product_type == 'Made to stock') {
            $estimated_dispatch_date = date('Y-m-d H:i:s', strtotime($created_date . +$estimated_days . "days"));
        }

        // 100% penalty case before dispatch date
        if ($estimated_dispatch_date >= $cancel_date) {
            $penalty_amount = round($penalty_amount_with_gst_and_quantity, 2);
            echo "100% penalty case before dispatch date";
        } else {
            $penalty_amount_after_dispatch = 1.5 * $penalty_amount_with_gst_and_quantity;
            $penalty_amount = round($penalty_amount_after_dispatch, 2);
            // $penalty_amount=round($penalty_amount_after_dispatch+$gst_on_penalty_amount_after_dispatch);
            echo "150% penalty case after dispatch date";
        }


        $penalty_amount_for_db = $penalty_amount * 100;
        $data = array(
            "order_number" => $order_id,
            "order_product_id" => $product_id,
            "quantity" => $quantity,
            "user_id" => $user_id,
            "total_amount_paid_buyer" => $total_amount_with_quantity,
            "commission_rate" => $commission_rate,
            "commission_amount" => $commission_amount * 100,
            "product_price_ex_gst" => $product_price_excluding_gst,
            "shipping_cost" => $product_shipping_cost,
            "penalty_amount" => $penalty_amount_for_db,
            "currency" => 'INR',
            "order_date" => $created_date,
            "dispatch_date" => $estimated_dispatch_date,
            "cancel_date" => $cancel_date,
            "created_at" => date('Y-m-d H:i:s'),
            "add_meet" => $product_type
        );
        $this->order_model->save_penalty_details($data, $seller_id, $penalty_amount_for_db);
    }

    //seller reports
    public function sales_data_report()
    {

        $data['title'] = trans("sales_data");
        $data['description'] = trans("sales_data") . " - " . $this->app_name;
        $data['keywords'] = trans("sales_data") . "," . $this->app_name;
        // $data['sales_data'] = $this->earnings_model->get_sales_data_reports();
        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/reports/sales_data', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    public function sales_data_date()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);
        $sales_data_date = $this->reports_model->get_sales_data_reports($from_date, $to_date);
        echo json_encode($sales_data_date);
    }

    public function payment_report()
    {

        $data['title'] = trans("payment_reports");
        $data['description'] = trans("payment_reports") . " - " . $this->app_name;
        $data['keywords'] = trans("payment_reports") . "," . $this->app_name;
        // $data['payment_reports'] = $this->earnings_model->get_payment_report();
        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/reports/payment_reports', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    public function payment_report_date()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);
        $payment_report_date = $this->reports_model->get_payment_report($from_date, $to_date);
        echo json_encode($payment_report_date);
    }

    public function commission_bill_report()
    {

        $data['title'] = trans("commission_bill");
        $data['description'] = trans("commission_bill") . " - " . $this->app_name;
        $data['keywords'] = trans("commission_bill") . "," . $this->app_name;
        // $data['commission_bill'] = $this->earnings_model->get_commission_bill_report();
        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/reports/commission_bill', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    public function commission_bill_date()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);
        $commission_bill_date = $this->reports_model->get_commission_bill_report($from_date, $to_date);
        echo json_encode($commission_bill_date);
    }

    public function seller_ledgers_report()
    {

        $data['title'] = trans("sellers_ledgers");

        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/reports/seller_ledgers', $data);
        $this->load->view('dashboard/includes/_footer');
    }
    public function seller_ledgers_date()
    {
        $from_date = $this->input->post('from_date', true);
        $to_date = $this->input->post('to_date', true);
        $seller_ledgers_date = $this->reports_model->get_seller_ledgers_report($from_date, $to_date);
        echo json_encode($seller_ledgers_date);
    }


    public function sellerpayouts()
    {
        $seller_id = $this->auth_user->id;
        $data['title'] = ("Initiated Payouts");
        $data['seller_initiated_pay'] = $this->order_model->fetch_seller_payout_inititated($seller_id);
        $this->load->view('dashboard/includes/_header', $data);
        $this->load->view('dashboard/reports/cashfree_initiated_payouts', $data);
        $this->load->view('dashboard/includes/_footer');
    }

    public function hide_products()
    {
        $id = $this->input->post('id', true);
        if ($this->product_admin_model->hide_products($id)) {

            $this->session->set_flashdata('success', trans("msg_product_hide"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();
    }
    public function unhide_products()
    {
        $id = $this->input->post('id', true);
        if ($this->product_admin_model->unhide_products($id)) {

            $this->session->set_flashdata('success', trans("msg_product_hide"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }

        //reset cache
        reset_cache_data_on_change();
    }
}
