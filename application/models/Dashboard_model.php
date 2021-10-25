<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    //get_outstanding_payments
    public function get_outstanding_payments($user_id, $limit)
    {
        $this->db->join('orders', 'orders.id = fact_outstanding_payments.order_id');
        $this->db->select('fact_outstanding_payments.*,orders.order_number,fact_outstanding_payments.payment_status');
        $this->db->group_by('fact_outstanding_payments.id');
        $this->db->where('seller_id', clean_number($user_id));
        $this->db->where('fact_outstanding_payments.payment_status!=', '0');
        $this->db->order_by('fact_outstanding_payments.order_date', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('fact_outstanding_payments');
        return $query->result();
    }
    //get pending orders
    public function get_pending_orders($user_id, $limit)
    {
        $this->db->join('orders', 'orders.id = fact_pending_orders.order_id');
        $this->db->select('fact_pending_orders.*,orders.order_number');
        $this->db->group_by('fact_pending_orders.id');
        $this->db->where('supplier_id', clean_number($user_id));
        $this->db->where('order_status!=', 'completed');
        $this->db->order_by('fact_pending_orders.order_date', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('fact_pending_orders');
        return $query->result();
    }


    //get cleared payments
    public function get_cleared_payments($user_id, $limit)
    {
        $this->db->join('orders', 'orders.id = fact_cleared_payments.order_id');
        $this->db->distinct();
        $this->db->select('distinct(order_id),amount,currency,order_date,orders.order_number,fact_cleared_payments.payment_status');
        $this->db->group_by('fact_cleared_payments.id');
        $this->db->where('seller_id', clean_number($user_id));
        $this->db->where('fact_cleared_payments.payment_status', '1');
        $this->db->order_by('fact_cleared_payments.order_date', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('fact_cleared_payments');
        return $query->result();
    }

    //get growth over last week customer
    public function get_growth_over_last_week($id)
    {
        $this->db->select("growth_rate,week");
        $this->db->where("seller_id", clean_number($id));
        $this->db->limit("2");
        $this->db->order_by("week", "DESC");
        return $this->db->get('fact_growth_over_last_week_customer')->result();
    }

    public function active_customers($seller_id)
    {
        $sql = "SELECT * from fact_active_customers 
WHERE seller_id=$seller_id AND seller_id!=buyer_id AND order_date > now() - INTERVAL 3 MONTH 
GROUP BY seller_id,buyer_id";
        $query = $this->db->query($sql);
        return $query->result();
    }
    //get growth over last week transaction
    public function get_growth_over_last_week_transaction($id)
    {
        $this->db->select("growth_rate,week");
        $this->db->where("seller_id", clean_number($id));
        $this->db->limit("2");
        $this->db->order_by("week", "DESC");
        return $this->db->get('fact_growth_last_week_transaction')->result();
    }


    //get new market covered till now
    public function new_market_covered_till_now($id)
    {
        $this->db->select("count_shipping_area,week");
        $this->db->where("seller_id", clean_number($id));
        $this->db->limit("5");
        $this->db->order_by("week", "DESC");
        return $this->db->get('fact_new_market_last_week')->result();
    }




    //get new_market_delivered_to_the_last_one_week
    public function new_market_delivered_to_the_last_one_week($id)
    {
        $sql = "SELECT count(DISTINCT
        shipping_area)
    FROM
        gharobaar_test.stag_new_market_last_week
    WHERE
        seller_id = '$id'
            AND week BETWEEN '1' AND '(week(CURRENT_DATE())-2)'
            AND shipping_area NOT IN (SELECT 
                shipping_area
            FROM
                fact_new_market_last_week
            WHERE
                seller_id = '$id' AND week = '(week(CURRENT_DATE())-1)')";
        $query = $this->db->query($sql);
        return $query->result();
    }



    public function repeated_purchase($seller_id)
    {
        $seller_id = clean_number($seller_id);
        $sql = "SELECT SUM(Repeat_Count) as sum  from fact_repeat_purchase where seller_id=$seller_id and Repeat_Count>1 AND  buyer_id!=seller_id and month(order_date)=month(now())-1 GROUP BY Period";
        $query = $this->db->query($sql);
        return $query->result();
    }


    //get csv price
    public function max_orders_count($seller_id)
    {
        $sql = "SELECT SUM(max_orders)as order_sum from fact_max_orders_weekly where seller_id=$seller_id  and week(order_date)=week(now()) GROUP BY Period";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function max_customers_weekly($seller_id)
    {
        $sql = "SELECT SUM(max_customers) as sum from fact_max_customers_weekly where seller_id=$seller_id AND buyer_id!=seller_id AND week(order_date)=week(now()) GROUP BY Period";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function top_selling_products()
    {
        $sql = "SELECT 
        op.seller_id,
        op.created_at,
        u.shop_name,u.slug,u.username,u.email,
        COUNT(o.id) as sm
    FROM
        order_products op,
        orders o,
        users u
    WHERE
         op.order_status!='cancelled'
            AND op.order_id = o.id  
            AND op.seller_id=u.id
    GROUP BY op.seller_id
    ORDER BY COUNT(o.id) DESC
    LIMIT 5";
        $query = $this->db->query($sql);
        return $query->result();
    }
    //get growth over last week customer
    public function get_new_customers_last_week($id)
    {

        $sql = " SELECT weeks.week, IFNULL(fact_new_customers_in_last_week.customer_count,0) as customer_count
        FROM
          weeks
                LEFT OUTER JOIN
             fact_new_customers_in_last_week ON  weeks.week= fact_new_customers_in_last_week.week where seller_id is NULL OR seller_id=$id order by week desc";
        $query = $this->db->query($sql);
        return $query->result();

        // $this->db->select("customer_count,week");
        // $this->db->where("seller_id", clean_number($id));
        // $this->db->limit("7");
        // $this->db->order_by("week", "DESC");
        // return $this->db->get('fact_new_customers_in_last_week')->result();
    }

    //get no.of transactions in last week
    public function get_no_of_transaction_last_week($id)
    {
        $sql = " SELECT weeks.week, IFNULL(fact_transaction_in_last_one_week.order_id,0) as order_id
        FROM
          weeks
                LEFT OUTER JOIN
             fact_transaction_in_last_one_week ON  weeks.week= fact_transaction_in_last_one_week.week where seller_id is NULL OR seller_id=$id order by week desc";
        $query = $this->db->query($sql);
        return $query->result();
    }

    //get avg taransaction

    public function get_avg_transaction($id)
    {
        $this->db->select("avg_transaction");
        $this->db->where("seller_id", clean_number($id));
        return $this->db->get('fact_avg_transactions')->row();
    }
}
