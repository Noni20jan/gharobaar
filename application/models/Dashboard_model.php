<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    //get_outstanding_payments
    public function get_outstanding_payments($user_id, $limit)
    {
        $sql = "select distinct order_id,order_status,order_date,fact_outstanding_payments.payment_status,fact_outstanding_payments.seller_id,fact_outstanding_payments.amount,fact_outstanding_payments.currency,orders.order_number from fact_outstanding_payments join orders on orders.id=fact_outstanding_payments.order_id where seller_id='$user_id' AND fact_outstanding_payments.payment_status=	0 and (order_status!='cancelled_by_seller' OR order_status='cancelled_by_user' OR order_status='cancelled') order by fact_outstanding_payments.id desc limit 6 ";
        $query = $this->db->query($sql);
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
        // $this->db->join('orders', 'orders.id = fact_cleared_payments.order_id');
        // $this->db->distinct();
        // $this->db->select('distinct(order_id),amount,currency,order_date,orders.order_number,fact_cleared_payments.payment_status');
        // $this->db->group_by('fact_cleared_payments.id');
        // $this->db->where('seller_id', clean_number($user_id));
        // $this->db->where('fact_cleared_payments.payment_status', '1');
        // $this->db->where('fact_cleared_payments.order_status!=', 'cancelled');
        // $this->db->where_in('fact_cleared_payments.order_status!=', 'cancelled', 'cancelled_by_seller', 'cancelled_by_user');
        // // $this->db->or_where('fact_cleared_payments.order_status!=', 'cancelled');
        // // $this->db->order_by('fact_cleared_payments.order_date', 'DESC');
        // $this->db->limit($limit);
        $sql = "select distinct(order_id),fact_cleared_payments.order_status,amount,currency,order_date,orders.order_number,fact_cleared_payments.payment_status from fact_cleared_payments join orders on orders.id = fact_cleared_payments.order_id where seller_id='$user_id' and fact_cleared_payments.payment_status='1' AND (order_status!='cancelled' OR order_status!='cancelled_by_seller' OR order_status!='cancelled_by_user') order by fact_cleared_payments.id desc limit 6;
        ";
        // $query = $this->db->get('fact_cleared_payments');
        $query = $this->db->query($sql);
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
        WHERE seller_id=$seller_id AND seller_id!=buyer_id AND order_date > now() - INTERVAL 3 MONTH ORDER BY order_count DESC LIMIT 5";
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

    public function top_ten_sellers()
    {
        $sql = "select * from (select seller_id, sum(max_orders) as total_orders ,period from fact_max_orders_weekly where year=year(now()) and period=week(now())-1 group by seller_id,period order by period desc,sum(max_orders) desc) as temp limit 10";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function repeated_purchase($seller_id)
    {
        $seller_id = clean_number($seller_id);
        $sql = "SELECT SUM(Repeat_Count) as sum  from fact_repeat_purchase where seller_id=$seller_id  AND Period=monthname(now()-INTERVAL 1 MONTH)";
        $query = $this->db->query($sql);
        return $query->result();
    }





    //get csv price
    public function max_orders_count($seller_id)
    {
        $sql = "SELECT MAX(max_orders)as order_sum from fact_max_orders_weekly where seller_id=$seller_id  AND Period=WEEK(now())";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function max_customers_weekly()
    {
        $sql = "select week_no, cnt from
        (SELECT Concat('Week ',week(created_at)) as week_no , 0 as cnt
        FROM weeks 
        WHERE weeks.week NOT IN (SELECT distinct week(weeks.created_at) as week_no
                                 FROM weeks
                                 LEFT JOIN stag_max_customers_weekly as smcw
                                   ON weeks.week = week(smcw.user_registered_date) 
                                   WHERE week(weeks.created_at) between week(now())-4 AND week(now())
                                  group by week(user_registered_date))
        UNION
        SELECT Concat('Week ',week(smcw1.user_registered_date)) as week_no, count(user_id) as cnt
        FROM stag_max_customers_weekly as smcw1
        where week(smcw1.user_registered_date) between week(now())-4 AND week(now())
        group by week(smcw1.user_registered_date)
        ) as temp
        order by week_no";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function top_selling_products()
    {
        $sql = "
        SELECT 
                op.seller_id,
                op.created_at,
                u.shop_name,u.slug,u.username,u.email,
                COUNT(o.id) as sm
            FROM
            stag_max_orders_weekly op,
            order_products os,
                orders o,
                users u
            WHERE
            os.order_id=op.order_id AND
            os.order_id=o.id AND
            os.order_status='completed' AND
                   op.order_id = o.id  
                   AND os.seller_id=u.id 
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

        $sql = " Select * from (
            SELECT seller_id as sid, sncl.week as nweek, sncl.customer_count as new_customers
            FROM weeks as w
            JOIN fact_new_customers_in_last_week as sncl
            ON w.week = sncl.week
            where seller_id=$id 
            and sncl.year = year(now())
            group by sncl.week
            UNION
            select 181 as sid, w2.week as nweek, 0 as new_customers from weeks as w2
            where w2.week NOT IN ( select sncl1.week 
                                     from fact_new_customers_in_last_week as sncl1
                                     where sncl1.seller_id = $id)) as temp
                                     order by CAST(temp.nweek AS UNSIGNED )";
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
    public function products_batch($seller_id)
    {
        $sql = "SELECT * from PRODUCT_BATCH where seller_id=$seller_id and category_id Is NOT NULL";
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
    public function get_seller_rating($seller_id)
    {
        $this->db->select("avg_rating");
        $this->db->where("seller_id", clean_number($seller_id));
        return $this->db->get('fact_seller_rating')->row();
    }
    public function products_top_selling($seller_id)
    {
        $sql = "select stsp.seller_id, stsp.category_id, stsp.product_id, count(stsp.product_id) as cnt,DATE_FORMAT(stsp.created_at, '%M') as Month,stsp.product_title,stsp.created_at
        from  stag_top_selling_products as stsp
        where stsp.seller_id != $seller_id
        and stsp.category_id IN (SELECT DISTINCT
                    (category_id)
                FROM
                    order_products
                        INNER JOIN
                    products ON order_products.product_id = products.id
                WHERE
                    seller_id = $seller_id)
        group by stsp.seller_id, stsp.category_id, stsp.product_id,month
        order by count(stsp.product_id) desc LIMIT 5";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
