<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Earnings_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //get paginated earnings
    public function get_paginated_earnings($user_id, $per_page, $offset)
    {
        $this->db->where('user_id', clean_number($user_id));
        $this->filter_earnings();
        $this->db->order_by('earnings.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('earnings');
        return $query->result();
    }

    //get earnings count
    public function get_earnings_count($user_id)
    {
        $this->db->where('user_id', clean_number($user_id));
        $this->filter_earnings();
        return $this->db->count_all_results('earnings');
    }

    //filter earnings
    public function filter_earnings()
    {
        $q = input_get('q');
        if (!empty($q)) {
            $this->db->like('earnings.order_number', $q);
        }
    }

    //add seller earnings
    public function add_seller_earnings($order_product)
    {
        if (!empty($order_product)) {
            $order = $this->order_model->get_order($order_product->order_id);
            if (!empty($order)) {
                //check if earning already added
                $this->db->where('order_number', $order->order_number);
                $this->db->where('order_product_id', $order_product->id);
                $this->db->where('user_id', $order_product->seller_id);
                $query = $this->db->get('earnings');
                $num_rows = $query->num_rows();
                if ($num_rows < 1) {
                    $earned_amount = calculate_earned_amount($order_product);
                    $commission_rate = calculate_commission_rate($order_product);
                    //add earning
                    $data = array(
                        'order_number' => $order->order_number,
                        'order_product_id' => $order_product->id,
                        'user_id' => $order_product->seller_id,
                        'price' => $order_product->product_total_price,
                        'commission_rate' => $commission_rate,
                        'shipping_cost' => $order_product->product_shipping_cost,
                        'earned_amount' => $earned_amount,
                        'currency' => $order_product->product_currency,
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $this->db->insert('earnings', $data);

                    //update seller balance and number of sales
                    $user = get_user($order_product->seller_id);
                    if (!empty($user)) {
                        $new_balance = $user->balance;
                        if ($order->payment_status == "payment_received") {
                            $new_balance = $user->balance + $earned_amount;
                        }
                        $sales = $user->number_of_sales;
                        $sales = $sales + 1;
                        $data = array(
                            'balance' => $new_balance,
                            'number_of_sales' => $sales
                        );
                        $this->db->where('id', $user->id);
                        $this->db->update('users', $data);
                    }
                }
            }
        }
    }

    //remove seller earnings
    public function remove_seller_earnings($order_product)
    {
        if (!empty($order_product)) {
            $earned_amount = calculate_earned_amount($order_product);
            $this->db->where('order_product_id', $order_product->id);
            $this->db->where('user_id', $order_product->seller_id);
            $this->db->delete('earnings');

            //update seller balance and number of sales
            $user = get_user($order_product->seller_id);
            if (!empty($user)) {
                $balance = $user->balance;
                $new_balance = $balance - $earned_amount;
                $sales = $user->number_of_sales;
                $sales = $sales - 1;
                $data = array(
                    'balance' => $new_balance,
                    'number_of_sales' => $sales
                );
                $this->db->where('id', $user->id);
                $this->db->update('users', $data);
            }
        }
    }

    //find commission rate for product of particular seller when product id is not null
    public function seller_product_commission($seller_id, $product_id)
    {
        $this->db->select('commission_rate');
        $this->db->from('seller_product_commission_rate');
        $this->db->where('seller_id', $seller_id);
        $this->db->where('product_id', $product_id);
        $this->db->where('is_active', 1);
        return $this->db->get()->result();
    }

    //find commission rate for product of particular seller when product id is null
    public function seller_commission($seller_id)
    {
        $this->db->select('commission_rate');
        $this->db->from('seller_product_commission_rate');
        $this->db->where('seller_id', $seller_id);
        $this->db->where('product_id is NULL', NULL, TRUE);
        $this->db->where('is_active', 1);
        return $this->db->get()->result();
    }

    //calculate earned amount
    public function calculate_earned_amount($order_product)
    {
        if (!empty($order_product)) {
            $price = $order_product->product_total_price - $order_product->product_shipping_cost;
            $earned = $price - (($price * $order_product->commission_rate) / 100);
            $total_earned_amount = $earned + $order_product->product_shipping_cost;
            return $total_earned_amount;
        }
        return 0;
    }

    //get order earning by user id
    public function get_earning_by_user_id($user_id, $order_number)
    {
        $this->db->where('order_number', $order_number);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('earnings');
        return $query->row();
    }

    //get user payout account
    public function get_user_payout_account($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('users_payout_accounts');
        $row = $query->row();

        if (!empty($row)) {
            return $row;
        } else {
            $data = array(
                'user_id' => $user_id,
                'payout_paypal_email' => "",
                'iban_full_name' => "",
                'iban_country_id' => "",
                'iban_bank_name' => "",
                'iban_number' => "",
                'swift_full_name' => "",
                'swift_address' => "",
                'swift_state' => "",
                'swift_city' => "",
                'swift_postcode' => "",
                'swift_country_id' => "",
                'swift_bank_account_holder_name' => "",
                'swift_iban' => "",
                'swift_code' => "",
                'swift_bank_name' => "",
                'swift_bank_branch_city' => "",
                'swift_bank_branch_country_id' => ""
            );
            $this->db->insert('users_payout_accounts', $data);

            $this->db->where('user_id', $user_id);
            $query = $this->db->get('users_payout_accounts');
            return $query->row();
        }
    }

    //set paypal payout account
    public function set_paypal_payout_account($user_id)
    {
        $user_id = clean_number($user_id);
        $data = array(
            'payout_paypal_email' => $this->input->post('payout_paypal_email', true)
        );
        $this->db->where('user_id', $user_id);
        return $this->db->update('users_payout_accounts', $data);
    }

    //set iban payout account
    public function set_iban_payout_account($user_id)
    {
        $user_id = clean_number($user_id);
        $this->load->model('upload_model');
        $temp_path = $this->upload_model->upload_temp_image('cheque-image');
        if (!empty($temp_path)) {
            //delete old avatar        
            $data["cheque_image_url"] = $this->upload_model->cheque_upload($temp_path);
        }

        $data = array(
            'iban_full_name' => $this->input->post('iban_full_name', true),
            'iban_country_id' => $this->input->post('iban_country_id', true),
            'iban_bank_name' => $this->input->post('iban_bank_name', true),
            'iban_number' => $this->input->post('iban_number', true),

        );
        $this->db->where('user_id', $user_id);
        return $this->db->update('users_payout_accounts', $data);
    }

    //set swift payout account
    public function set_swift_payout_account($user_id)
    {
        $user_id = clean_number($user_id);
        $data = array(
            'swift_full_name' => $this->input->post('swift_full_name', true),
            'swift_address' => $this->input->post('swift_address', true),
            'swift_state' => $this->input->post('swift_state', true),
            'swift_city' => $this->input->post('swift_city', true),
            'swift_postcode' => $this->input->post('swift_postcode', true),
            'swift_country_id' => $this->input->post('swift_country_id', true),
            'swift_bank_account_holder_name' => $this->input->post('swift_bank_account_holder_name', true),
            'swift_iban' => $this->input->post('swift_iban', true),
            'swift_code' => $this->input->post('swift_code', true),
            'swift_bank_name' => $this->input->post('swift_bank_name', true),
            'swift_bank_branch_city' => $this->input->post('swift_bank_branch_city', true),
            'swift_bank_branch_country_id' => $this->input->post('swift_bank_branch_country_id', true)
        );
        $this->db->where('user_id', $user_id);
        return $this->db->update('users_payout_accounts', $data);
    }

    //get paginated payouts
    public function get_paginated_payouts($user_id, $per_page, $offset)
    {
        $this->db->where('user_id', clean_number($user_id));
        $this->db->order_by('payouts.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('payouts');
        return $query->result();
    }

    //get payouts count
    public function get_payouts_count($user_id)
    {
        $this->db->where('user_id', clean_number($user_id));
        return $this->db->count_all_results('payouts');
    }

    //get active payouts
    public function get_active_payouts($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 0);
        $this->db->order_by('payouts.created_at', 'DESC');
        $query = $this->db->get('payouts');
        return $query->result();
    }

    //withdraw money
    public function withdraw_money($data)
    {
        return $this->db->insert('payouts', $data);
    }


    //filter earnings
    public function filter_penalties()
    {
        $q = input_get('q');
        if (!empty($q)) {
            $this->db->like('penalty.order_number', $q);
        }
    }

    //get earnings count
    public function get_penalties_count($user_id)
    {
        $this->db->where('user_id', clean_number($user_id));
        $this->filter_penalties();
        return $this->db->count_all_results('penalty');
    }
    //get paginated earnings
    public function get_paginated_penalties($user_id, $per_page, $offset)
    {
        $this->db->where('user_id', clean_number($user_id));
        $this->filter_penalties();
        $this->db->order_by('penalty.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('penalty');
        return $query->result();
    }

    public function calculate_total_penalty_amount($user_id)
    {
        $query = $this->db->query("select sum(penalty_amount) as total_penalty, user_id, count(order_number)as total_no_penalty FROM penalty where user_id='$user_id' group by user_id");
        return $query->row();
    }

    //get seller reports
    public function get_sales_data_reports($start_date,$end_date)
    {
       $end_date = $end_date . " 23:59:59";
       $sql= "SELECT * FROM sale_data_report where order_date >= STR_TO_DATE('$start_date', '%Y-%m-%d %k:%i:%s') AND order_date <= STR_TO_DATE('$end_date', '%Y-%m-%d %k:%i:%s')";
       $query = $this->db->query($sql);
       return $query->result();
    }

    public function get_payment_report($start_date,$end_date)
    {
        $end_date = $end_date . " 23:59:59";
        $sql = "SELECT sdr.seller_id, sdr.order_no,sdr.order_date,
        format(sum(sdr.grand_total_amount),2) as total_product_amt,
        format(sum(sdr.commission_amount),2) as commission_amt,
        format(sum(sdr.seller_ship_cost),2) as shipping_amt,
        sum(sdr.seller_cod_cost) as cod_amt,
        format(sum(csp.gateway_amount/100),2) as getway_amt,
        format(( sum(sdr.commission_amount) + sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost) + sum(csp.gateway_amount/100) ) *18/100,2) as total_deduction,
        format(( csp.total_tcs_amount_product + csp.total_tcs_shipping)/100,2) as tcs_amt,
        format(( csp.total_tds_amount_product + csp.tds_amount_shipping)/100,2) as tds_amt,
        ifnull(format(sum(p.penalty_amount/100),2),0) as penalty_amt,
        ifnull(format((sum((p.penalty_amount/100))*18/100),2),0) as penalty_gst,
        ifnull(format((sum(p.penalty_amount/100) + (sum((p.penalty_amount/100))*18/100)),2),0) as penalty_total,
        format((sum(sdr.grand_total_amount) - 
        (((sum(sdr.commission_amount) + sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost) + sum(csp.gateway_amount/100)) *18/100) + sum(sdr.seller_cod_cost)
        + sum(csp.gateway_amount/100) + sum(sdr.seller_ship_cost) + sum(sdr.commission_amount) + 
        ((csp.total_tcs_amount_product + csp.total_tcs_shipping)/100) + (( csp.total_tds_amount_product + csp.tds_amount_shipping)/100) +
        ifnull((sum(p.penalty_amount/100) + (sum((p.penalty_amount/100))*18/100)),0)
        )),2) as net_balance
        
        FROM sale_data_report as sdr
        LEFT JOIN cashfree_seller_payout as csp 
        ON sdr.order_no = csp.order_id
        LEFT JOIN penalty as p
        ON sdr.seller_id = p.user_id
        where sdr.order_no = csp.order_id
        -- and sdr.order_no = p.order_number
        and sdr.seller_id = csp.vendorId
        and sdr.order_date >= STR_TO_DATE('$start_date', '%Y-%m-%d %k:%i:%s')
        and sdr.order_date <= STR_TO_DATE('$end_date', '%Y-%m-%d %k:%i:%s')
        and csp.is_active = 1
        and csp.is_completed = 1
        GROUP BY sdr.seller_id, sdr.order_no,sdr.order_date";
        $query = $this->db->query($sql);
        return $query->result();
    }


    public function get_commission_bill_report($start_date,$end_date)
    {
        $end_date = $end_date . " 23:59:59";
        $sql = "SELECT DATE_FORMAT(sdr.order_date, '%M %Y') as 'Order_Month',
        sdr.seller as Seller,
        sdr.seller_email as Email,
        sdr.seller_phone as 'Phone',
        sdr.shop_name as Shop_name,
        sdr.pan_no as 'Pan',
        sdr.gst_no as 'GST',
        sdr.seller_address as 'Address',
        format(sum(sdr.commission_amount),2) as 'total_commission_amount',
        format(sum(sdr.seller_ship_cost),2) as 'Total_shipping_cost',
        format(sum(sdr.seller_cod_cost),2) as 'Total_Cod_cost',
        ifnull(format(sum(csp.gateway_amount/100),2) , 0) as 'getway_amt',
        -- format(sum(csp.gateway_amount/100),2) as getway_amt,
        '18%' as 'GST_Rate', 
        FORMAT(((sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost) 
                     + sum(sdr.commission_amount) + ifnull(format(sum(csp.gateway_amount/100),2) , 0) ) * 18) / 100, 2) AS GST_Amount,
            IF(STRCMP(upper(u.supplier_state), 'DELHI') = 0,
                FORMAT((((sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost)
                     + sum(sdr.commission_amount) + ifnull(format(sum(csp.gateway_amount/100),2) , 0)) * 18) / 100)/2,2), 0 ) as CGST,
                IF(STRCMP(upper(u.supplier_state), 'DELHI') = 0,
                FORMAT((((sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost)
                     + sum(sdr.commission_amount) + ifnull(format(sum(csp.gateway_amount/100),2) , 0)) * 18) / 100)/2, 2), 0 ) as SGST,
                    IF(STRCMP(upper(u.supplier_state), 'DELHI') = 0, 0,
                FORMAT(((sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost)
                     + sum(sdr.commission_amount) + ifnull(format(sum(csp.gateway_amount/100),2) , 0)) * 18) / 100, 2)) as IGST,
                Format ((sum(sdr.commission_amount) + sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost) + ifnull(sum(csp.gateway_amount/100), 0) +  
                (((sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost) 
                     + sum(sdr.commission_amount) + ifnull(sum(csp.gateway_amount/100), 0) ) * 18) / 100) ),2) as TOTAL
        
         -- FORMAT(sum(csp.gateway_amount)/100,2) as Gateway_charges
         FROM sale_data_report as sdr
         LEFT JOIN cashfree_seller_payout as csp 
          ON sdr.order_no = csp.order_id,
          users as u
          where sdr.seller_email = u.email
         and sdr.order_date >= STR_TO_DATE('$start_date', '%Y-%m-%d %k:%i:%s')
         and sdr.order_date <= STR_TO_DATE('$end_date', '%Y-%m-%d %k:%i:%s')
         group by sdr.seller ,
        sdr.seller_email ,
        sdr.seller_phone ,
        sdr.shop_name,
        sdr.pan_no,
        sdr.gst_no,
        sdr.seller_address";
        $query = $this->db->query($sql);
        return $query->result();
    }


    public function get_seller_ledgers_report($start_date,$end_date)
    {
        $end_date = $end_date . " 23:59:59";
        $sql = "SELECT sdr.seller_id,
        format(sum(sdr.grand_total_amount),2) as total_product_amt,
        format(sum(sdr.commission_amount),2) as commission_amt,
        format(sum(sdr.seller_ship_cost),2) as shipping_amt,
        sum(sdr.seller_cod_cost) as cod_amt,
        format(sum(csp.gateway_amount/100),2) as getway_amt,
        format(( sum(sdr.commission_amount) + sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost) + sum(csp.gateway_amount/100) ) *18/100,2) as total_deduction,
        format((sum(csp.total_tcs_amount_product) + sum(csp.total_tcs_shipping))/100,2) as tcs_amt,
        format((sum(csp.total_tds_amount_product) + sum(csp.tds_amount_shipping))/100,2) as tds_amt,
        ifnull(format(sum(p.penalty_amount/100),2),0) as penalty_amt,
        ifnull(format((sum((p.penalty_amount/100))*18/100),2),0) as penalty_gst,
        ifnull(format((sum(p.penalty_amount/100) + (sum((p.penalty_amount/100))*18/100)),2),0) as penalty_total,
        format((sum(sdr.grand_total_amount) - 
        (((sum(sdr.commission_amount) + sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost) + sum(csp.gateway_amount/100)) *18/100) + sum(sdr.seller_cod_cost)
        + sum(csp.gateway_amount/100) + sum(sdr.seller_ship_cost) + sum(sdr.commission_amount) +
        ((csp.total_tcs_amount_product + csp.total_tcs_shipping)/100) + (( csp.total_tds_amount_product + csp.tds_amount_shipping)/100) + 
        ifnull((sum(p.penalty_amount/100) + (sum((p.penalty_amount/100))*18/100)),0)
        )),2) as net_balance
        
        FROM sale_data_report as sdr
        LEFT JOIN cashfree_seller_payout as csp 
        ON sdr.order_no = csp.order_id
        LEFT JOIN penalty as p
        ON sdr.seller_id = p.user_id
        where sdr.order_no = csp.order_id
        / and sdr.order_no = p.order_number /
        and sdr.seller_id = csp.vendorId
        and sdr.order_date >= STR_TO_DATE('$start_date', '%Y-%m-%d %k:%i:%s')
        and sdr.order_date <= STR_TO_DATE('$end_date', '%Y-%m-%d %k:%i:%s')
        and csp.is_active = 1
        and csp.is_completed = 1
        GROUP BY sdr.seller_id";
        $query = $this->db->query($sql);
        return $query->result();
        
    }
}
