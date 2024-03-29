<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_admin_model extends CI_Model
{
    //build query
    public function build_query($lang_id = null, $type = null)
    {
        if (empty($lang_id)) {
            $lang_id = $this->site_lang->id;
        }
        $this->db->select("products.*");
        $this->db->select("(SELECT title FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id = " . clean_number($lang_id) . " LIMIT 1) AS title");
        if (item_count($this->languages) > 1) {
            $this->db->select("(SELECT title FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id != " . clean_number($lang_id) . " LIMIT 1) AS second_title");
        }
        if ($this->general_settings->membership_plans_system == 1) {
            if ($type == "expired") {
                $this->db->join('users', 'products.user_id = users.id AND users.is_membership_plan_expired = 1');
            } else {
                $this->db->join('users', 'products.user_id = users.id AND users.is_membership_plan_expired = 0');
            }
        }
    }

    //get products
    public function get_products()
    {
        $this->build_query();
        $this->db->where('is_service', "0");
        $this->db->where('status', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        $this->db->order_by('products.created_at', 'DESC');
        return $this->db->get('products')->result();
    }

    //get products
    public function get_services()
    {
        $this->build_query();
        $this->db->where('is_service', "1");
        $this->db->where('status', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        $this->db->order_by('products.created_at', 'DESC');
        return $this->db->get('products')->result();
    }

    //get latest products
    public function get_latest_products($limit)
    {
        $this->build_query();
        $this->db->where('is_service', "0");
        $this->db->where('status', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        $this->db->order_by('products.created_at', 'DESC')->limit(clean_number($limit));
        return $this->db->get('products')->result();
    }

    //get product id //

    public function get_product_id($category_id, $limit)
    {
        $this->product_model->build_query();
        $this->db->where('is_service', "0");
        $this->db->where('status', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        $this->db->where('category_id', $category_id);
        $this->db->order_by('products.created_at', 'DESC')->limit(clean_number($limit));
        return $this->db->get('products')->result();
    }

    //get latest services
    public function get_latest_services($limit)
    {
        $this->build_query();
        $this->db->where('is_service', "1");
        $this->db->where('status', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        $this->db->order_by('products.created_at', 'DESC')->limit(clean_number($limit));
        return $this->db->get('products')->result();
    }

    //get products count
    public function top_selling_products()
    {
        $sql = "SELECT 
        op.seller_id,
        op.created_at,
        u.shop_name,u.slug,u.username,u.email,COUNT(o.price_total)*20 as count,
        FORMAT(SUM(o.price_total),2)
    FROM
        local_gharobaar.order_products op,
        local_gharobaar.orders o,
        local_gharobaar.users u
    WHERE
        DATE(op.created_at) >= '2020-12-30'
            AND DATE(op.created_at) <= '2021-04-30'
            AND op.order_status != 'cancelled' AND op.order_status!='completed'
            AND op.order_id = o.id  
            AND op.seller_id=u.id
    GROUP BY (op.seller_id)
    ORDER BY SUM(op.product_quantity) DESC
    LIMIT 5";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function top_sales()
    {
        $sql = "SELECT 
        op.seller_id, op.created_at,op.product_title,op.product_id,p.sku,p.stock,p.product_type,
        u.shop_name,u.slug,u.username,u.email,COUNT(o.price_total)*20 count,
        FORMAT(SUM(o.price_total),2)
    FROM
       order_products op,
      orders o,
        users u,
       products p,
      product_details as pd WHERE
        DATE(op.created_at) >= '2020-12-30'
            AND DATE(op.created_at) <= '2021-12-31'
            AND op.order_status != 'cancelled' AND op.order_status!='completed'
            AND op.order_id = o.id  
            AND op.seller_id=u.id
            AND op.product_id=p.id
            AND op.product_id=pd.product_id
    GROUP BY (op.product_id)
    ORDER BY SUM(op.product_quantity) DESC
    LIMIT 5";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function get_products_count()
    {
        $this->build_query();
        $this->db->where('is_service', "0");
        $this->db->where('status', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        return $this->db->count_all_results('products');
    }
    //get services count
    public function get_services_count()
    {
        $this->build_query();
        $this->db->where('is_service', "1");
        $this->db->where('status', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        return $this->db->count_all_results('products');
    }
    public function update_bank_details($id)
    {
        $this->db->where('id', $id);
        $this->db->where('role', 'vendor');
        $query = $this->db->get('users');
        return $query->row();
    }
    //get pending products
    public function get_pending_products()
    {
        $this->build_query();
        $this->db->where('is_service', "0");
        $this->db->where('status !=', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        $this->db->order_by('products.created_at', 'DESC');
        return $this->db->get('products')->result();
    }

    //get latest pending products
    public function get_latest_pending_products($limit)
    {
        $this->build_query();
        $this->db->where('is_service', "0");
        $this->db->where('status !=', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        $this->db->order_by('products.created_at', 'DESC')->limit(clean_number($limit));
        return $this->db->get('products')->result();
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
    //get pending products count
    public function get_pending_products_count()
    {
        $this->build_query();
        $this->db->where('is_service', "0");
        $this->db->where('status !=', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        return $this->db->count_all_results('products');
    }


    //get_pending_services
    public function get_pending_services()
    {
        $this->build_query();
        $this->db->where('is_service', "1");
        $this->db->where('status !=', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        $this->db->order_by('products.created_at', 'DESC');
        return $this->db->get('products')->result();
    }

    //get latest pending products
    public function get_latest_pending_services($limit)
    {
        $this->build_query();
        $this->db->where('is_service', "1");
        $this->db->where('status !=', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        $this->db->order_by('products.created_at', 'DESC')->limit(clean_number($limit));
        return $this->db->get('products')->result();
    }
    //get user by id
    public function get_user($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        return $query->row();
    }
    //get pending products count
    public function get_pending_services_count()
    {
        $this->build_query();
        $this->db->where('is_service', "1");
        $this->db->where('status !=', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
        return $this->db->count_all_results('products');
    }
    //get pending products count
    public function get_pending_barter_count()
    {
        $this->build_query();
        $this->db->where('status', "new_barter_request");

        return $this->db->count_all_results('barter_requests');
    }
    public function barter_count()
    {
        $this->build_query();


        return $this->db->count_all_results('barter_requests');
    }


    public function coupons_vouchers($offer_)
    {
        //     $offer_ = array(
        //         'name' => $this->input->post('offer_name', true),
        //         'type' => $this->input->post('method_type', true),
        //         'method' => $this->input->post('coup_vou', true),
        //         'start_date' =>  $this->input->post('start_date', true),
        //         'end_date' => $this->input->post('end_date', true),
        //         'discount_amt' => $this->input->post('discount_amt', true),
        //         'discount_percentage' => $this->input->post('discount_per', true),
        //         'allowed_max_discount' => $this->input->post('max_discount', true),
        //         'min_amt_in_cart' => $this->input->post('min_discount', true),
        //         'max_total_usage' => $this->input->post('max_usage', true),
        //         // 'offer_code' => 0,
        //         // 'msg_to_be_displayed' => $this->input->post('order_capacity', true),
        //         // 'max_usage_per_user' => "",
        //         // 'no_off_voucher_req' => 0,
        //         // 'terms_and_conditions' => 1,
        //         // 'status' => 0,
        //         // 'created_by' => 0,
        //         // 'creation_date' => 0,
        //         // 'last_updated_by' => 0,
        //         // 'last_update_date' => 0,
        //         // 'last_update_login' => "",
        //     );
        if ($this->db->insert('cms_offers', $offer_)) {
            return true;
        } else {
            return false;
        }
    }



    //filter by values
    public function filter_products($list, $category_ids)
    {
        $product_type = input_get('product_type');
        $stock = input_get('stock');
        $q = input_get('q');
        $brand_name = input_get('brand_name');
        $shop_name = input_get('shop_name');
        $seller_email = input_get('seller_email');
        $product_title = input_get('product_title');

        if (!empty($category_ids)) {
            $this->db->where_in("products.category_id", $category_ids);
        }
        if (!empty($q)) {
            $this->db->join('product_details', 'product_details.product_id = products.id');
            $this->db->join('users', 'products.user_id = users.id');
            $this->db->where('product_details.lang_id', $this->selected_lang->id);
            $this->db->group_start();
            $this->db->like('product_details.title', $q);
            $this->db->or_like('products.sku', $q);
            $this->db->or_like('products.promote_plan', $q);
            $this->db->or_like('users.shop_name', $q);
            $this->db->or_like('users.brand_name', $q);
            $this->db->or_like('users.email', $q);
            $this->db->group_end();
        }

        if (!empty($brand_name)) {
            $this->db->join('product_details', 'product_details.product_id = products.id');
            $this->db->join('users', 'products.user_id = users.id');
            $this->db->where('users.brand_name', $brand_name);
        }

        if (!empty($shop_name)) {
            $this->db->join('product_details', 'product_details.product_id = products.id');
            $this->db->join('users', 'products.user_id = users.id');
            $this->db->where('users.shop_name', $shop_name);
        }

        if (!empty($seller_email)) {
            $this->db->join('product_details', 'product_details.product_id = products.id');
            $this->db->join('users', 'products.user_id = users.id');
            $this->db->where('users.email', $seller_email);
        }

        if (!empty($product_title)) {
            $this->db->join('product_details', 'product_details.product_id = products.id');
            $this->db->join('users', 'products.user_id = users.id');
            $this->db->where('product_details.title', $product_title);
        }

        if ($product_type == "physical" || $product_type == "digital") {
            $this->db->where('products.product_type', $product_type);
        }
        if ($stock == "in_stock" || $stock == "out_of_stock") {
            $this->db->group_start();
            if ($stock == "out_of_stock") {
                $this->db->where("products.product_type = 'physical' AND products.stock <=", 0);
            } else {
                $this->db->where("products.product_type = 'digital' OR products.stock >", 0);
            }
            $this->db->group_end();
        }
        if (!empty($list)) {
            if ($list == "products") {
                $this->db->where('products.visibility', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
                $this->db->order_by('products.created_at', 'DESC');
            }
            if ($list == "promoted_products") {
                $this->db->where('products.visibility', 1)->where('products.is_promoted', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
                $this->db->order_by('products.created_at', 'DESC');
            }
            if ($list == "special_offers") {
                $this->db->where('products.visibility', 1)->where('products.is_special_offer', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
                $this->db->order_by('products.special_offer_date', 'DESC');
            }
            if ($list == "pending_products") {
                $this->db->where('products.visibility', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);
                $this->db->order_by('products.created_at', 'DESC');
            }
            if ($list == "hidden_products") {
                $this->db->where('products.visibility', 0)->where('products.is_draft', 0)->where('products.is_deleted', 0);
                $this->db->order_by('products.created_at', 'DESC');
            }
            if ($list == "expired_products") {
                $this->db->where('products.is_draft', 0)->where('products.is_deleted', 0);
                $this->db->order_by('products.created_at', 'DESC');
            }
            if ($list == "drafts") {
                $this->db->where('products.is_draft', 1)->where('products.is_deleted', 0);
                $this->db->order_by('products.created_at', 'DESC');
            }
            if ($list == "deleted_products") {
                $this->db->where('products.is_deleted', 1);
                $this->db->order_by('products.created_at', 'DESC');
            }
        }
    }

    //get filter category ids
    public function get_filter_category_ids()
    {
        $category_id = input_get('category');
        $subcategory_id = input_get('subcategory');
        if (!empty($subcategory_id)) {
            $category_id = $subcategory_id;
        }
        if (!empty($category_id)) {
            $categories = $this->category_model->get_subcategories_tree($category_id, false);
            return get_ids_from_array($categories);
        }
        return null;
    }

    //get paginated products count
    public function get_paginated_products_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.status', 1);
        $this->db->where('products.is_service', "0");
        $this->db->where('products.is_service', "0");
        return $this->db->count_all_results('products');
    }
    public function get_paginated_product_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.status', 1);
        $this->db->where('products.is_service', "0");
        $this->db->where('products.is_service', "0");
        $this->db->where('products.stock>', '0');
        return $this->db->count_all_results('products');
    }
    public function get_paginated_services_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.status', 1);
        $this->db->where('products.is_service', "1");
        return $this->db->count_all_results('products');
    }

    //get paginated products
    public function get_paginated_products($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.status', 1);
        $this->db->where('products.is_service', "0");
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }
    public function get_paginated_product($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.status', 1);
        $this->db->where('products.is_service', "0");
        $this->db->where('products.stock>', '0');
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }
    public function get_paginated_list_products($per_page, $offset, $feature_id, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->join('product_banner_tagging', 'product_banner_tagging.product_id=products.id');
        $this->db->where('product_banner_tagging.feature_id', $feature_id);
        $this->db->where('products.status', 1);
        $this->db->where('products.is_service', "0");
        $this->db->where('products.stock>', '0');
        $this->db->distinct();
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }
    public function get_paginated_list_product($per_page, $offset, $feature_id, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->db->join('images', 'images.product_id=products.id');
        $this->db->join('categories_lang', 'categories_lang.category_id=products.category_id');

        $this->db->join('product_banner_tagging', 'product_banner_tagging.product_id=products.id');
        $this->db->join('product_details', 'product_details.product_id=products.id');
        $this->filter_products($list, $category_ids);

        $this->db->where('product_banner_tagging.feature_id', intval($feature_id));

        $this->db->where('products.status', 1);
        $this->db->where('products.is_service', "0");
        $this->db->where('products.stock>', '0');
        $this->db->group_by('products.id');

        return $this->db->get('products')->result();
        // $this->db->get('products');
        // return $this->db->last_query();
    }
    public function get_paginated_list_product_count($list, $feature_id)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);

        $this->db->join('product_banner_tagging', 'products.id=product_banner_tagging.product_id');
        $this->db->join('images', 'product_banner_tagging.product_id=images.product_id');
        $this->db->join('product_details', 'product_details.product_id=product_banner_tagging.product_id');

        $this->db->where('product_banner_tagging.feature_id', $feature_id);

        $this->db->where('products.status', 1);
        $this->db->where('products.is_service', "0");
        $this->db->where('products.stock>', '0');
        return $this->db->get('products')->num_rows();
    }
    public function get_paginated_product_tagging($list, $feature_id)
    {
        // $category_ids = $this->get_filter_category_ids();
        // $this->build_query();
        // $this->filter_products($list, $category_ids);
        $featured_id = intval($feature_id);
        $sql = "SELECT products.id,products.slug,images.image_small,product_details.title,categories_lang.name,users.shop_name,users.brand_name,products.stock FROM products JOIN images ON images.product_id=products.id JOIN product_details ON product_details.product_id=products.id JOIN categories_lang ON categories_lang.category_id=products.category_id  JOIN users ON products.user_id=users.id WHERE products.visibility = 1 AND products.is_draft = 0 AND products.is_deleted = 0 AND images.is_main=1  AND products.id NOT IN(SELECT product_banner_tagging.product_id from product_banner_tagging where feature_id=$feature_id) AND products.status = 1 AND products.is_service = 0 AND products.stock > 0 AND is_deleted = 0  ORDER BY products.created_at DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function get_paginated_product_tagging_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.status', 1);
        $this->db->where('products.is_service', "0");
        $this->db->where('products.stock>', '0');
        $this->db->where('is_deleted', '0');
        return $this->db->get('products')->num_rows();
    }
    //get paginated products
    public function get_paginated_services($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.status', 1);
        $this->db->where('products.is_service', "1");
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }
    //get paginated promoted products count
    public function get_paginated_promoted_products_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.status', 1);

        return $this->db->count_all_results('products');
    }

    //get paginated promoted products
    public function get_paginated_promoted_products($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.status', 1);
        $this->db->where('products.is_service', "0");
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }

    //get paginated pending products count
    public function get_paginated_pending_products_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.status !=', 1);
        $this->db->where('products.is_service', "0");
        return $this->db->count_all_results('products');
    }
    public function get_reviews()
    {
        $this->db->select('remark');
        return $this->db->get('notifications');
    }

    //get paginated promoted products count
    public function get_paginated_promoted_services_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.status', 1);
        $this->db->where('products.is_service', "1");
        return $this->db->count_all_results('products');
    }

    //get paginated promoted products
    public function get_paginated_promoted_services($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.status', 1);
        $this->db->where('products.is_service', "1");
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }



    //get paginated pending services count
    public function get_paginated_pending_services_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.status !=', 1);
        $this->db->where('products.is_service', "1");
        return $this->db->count_all_results('products');
    }
    public function get_remarks($product_id)
    {
        $this->db->where("source_id", $product_id);
        $this->db->order_by('id', "DESC");
        $this->db->limit('1');
        return $this->db->get("notifications")->row();
    }
    //get paginated pending products
    public function get_paginated_pending_products($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        // $this->db->join('notifications', 'notifications.source_id=products.id', 'left');

        $this->filter_products($list, $category_ids);
        $this->db->where('products.status !=', 1);
        $this->db->where('products.is_service', "0");
        // $this->db->select('*');
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }

    //get paginated pending services
    public function get_paginated_pending_services($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.status !=', 1);
        $this->db->where('products.is_service', "1");
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }

    //get paginated drafts count
    public function get_paginated_drafts_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.is_service', "0");
        return $this->db->count_all_results('products');
    }

    //get paginated drafts
    public function get_paginated_drafts($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.is_service', "0");
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }
    //get paginated drafts count
    public function get_paginated_drafts_service_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.is_service', "1");
        return $this->db->count_all_results('products');
    }

    //get paginated drafts
    public function get_paginated_drafts_service($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.is_service', "1");
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }
    //get paginated hidden product count
    public function get_paginated_hidden_products_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.is_service', "0");
        return $this->db->count_all_results('products');
    }

    //get paginated hidden products
    public function get_paginated_hidden_products($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.is_service', "0");
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }

    //get paginated hidden product count
    public function get_paginated_hidden_services_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.is_service', "1");
        return $this->db->count_all_results('products');
    }

    //get paginated hidden products
    public function get_paginated_hidden_services($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->limit(clean_number($per_page), clean_number($offset));
        $this->db->where('products.is_service', "1");
        return $this->db->get('products')->result();
    }

    //get paginated expired product count
    public function get_paginated_expired_products_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query(null, "expired");
        $this->filter_products($list, $category_ids);
        $this->db->where('products.is_service', "0");
        return $this->db->count_all_results('products');
    }

    //get paginated expired products
    public function get_paginated_expired_products($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query(null, "expired");
        $this->filter_products($list, $category_ids);
        $this->db->limit(clean_number($per_page), clean_number($offset));
        $this->db->where('products.is_service', "0");
        return $this->db->get('products')->result();
    }

    //get paginated deleted product count
    public function get_paginated_deleted_products_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.is_service', "0");
        return $this->db->count_all_results('products');
    }

    //get paginated deleted products
    public function get_paginated_deleted_services($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.is_service', "1");
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }
    //get paginated deleted product count
    public function get_paginated_deleted_services_count($list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.is_service', "1");
        return $this->db->count_all_results('products');
    }

    //get paginated deleted products
    public function get_paginated_deleted_products($per_page, $offset, $list)
    {
        $category_ids = $this->get_filter_category_ids();
        $this->build_query();
        $this->filter_products($list, $category_ids);
        $this->db->where('products.is_service', "0");
        $this->db->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }
    //get product
    public function get_product($id)
    {
        $this->db->where('products.id', clean_number($id));
        return $this->db->get('products')->row();
    }


    //approve product
    public function approve_product($id)
    {
        $product = $this->get_product($id);
        if (!empty($product)) {
            $data = array(
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->where('id', $product->id);
            return $this->db->update('products', $data);
        }
        return false;
    }
    public function get_admin_review($id, $review)
    {
        $product = $this->get_product($id);
        $data = array(
            'admin_remark' => $review
        );
        $this->db->where('id', $product->id);
        return $this->db->update('products', $data);
    }



    //add remove promoted products
    public function add_remove_promoted_products($product_id, $day_count)
    {
        $product = $this->get_product($product_id);
        if (!empty($product)) {
            $transaction = null;
            if ($product->is_promoted == 1) {
                $data = array(
                    'is_promoted' => 0,
                );
            } else {
                $date = date('Y-m-d H:i:s');
                $end_date = date('Y-m-d H:i:s', strtotime($date . ' + ' . clean_number($day_count) . ' days'));
                $data = array(
                    'is_promoted' => 1,
                    'promote_start_date' => $date,
                    'promote_end_date' => $end_date
                );
                $transaction_id = $this->input->post('transaction_id', true);
                $transaction = $this->db->where('id', clean_number($transaction_id))->get('promoted_transactions')->row();
                if (!empty($transaction)) {
                    $data["promote_plan"] = $transaction->purchased_plan;
                    $data["promote_day"] = $transaction->day_count;
                }
            }
            $this->db->where('id', $product->id);
            $result = $this->db->update('products', $data);

            if ($result && !empty($transaction)) {
                $data_transaction = array(
                    'payment_status' => "Completed"
                );
                $this->db->where('id', $transaction->id);
                $this->db->update('promoted_transactions', $data_transaction);
            }

            return $result;
        }
        return false;
    }

    //add remove special offers
    public function add_remove_special_offers($product_id)
    {
        $product = $this->get_product($product_id);
        if (!empty($product)) {
            if ($product->is_special_offer == 1) {
                $data = array(
                    'is_special_offer' => 0,
                    'special_offer_date' => ""
                );
            } else {
                $data = array(
                    'is_special_offer' => 1,
                    'special_offer_date' => date('Y-m-d H:i:s')
                );
            }
            $this->db->where('id', $product->id);
            return $this->db->update('products', $data);
        }
        return false;
    }

    //delete product
    public function delete_product($product_id)
    {
        $product = $this->get_product($product_id);
        if (!empty($product)) {
            $data = array(
                'is_deleted' => 1
            );
            $this->db->where('id', $product->id);
            return $this->db->update('products', $data);
        }
        return false;
    }

    public function delete_address($id)
    {
        $address = $this->get_address($id);
        if (!empty($address)) {

            $this->db->where('id', $address->id);
            return $this->db->delete('shipping_info');
        }
        return false;
    }

    //delete product permanently
    public function delete_product_permanently($id)
    {
        $product = $this->get_product($id);
        if (!empty($product)) {
            //delete images
            $this->file_model->delete_product_images($product->id);
            //delete digital product
            if ($product->product_type == "digital") {
                $this->file_model->delete_digital_file($product->id);
            }
            $this->db->where('id', $product->id);
            return $this->db->delete('products');
        }
        return false;
    }

    //delete multi product
    public function delete_multi_products($product_ids)
    {
        if (!empty($product_ids)) {
            foreach ($product_ids as $id) {
                $this->delete_product($id);
            }
        }
    }

    //delete multi product
    public function delete_multi_products_permanently($product_ids)
    {
        if (!empty($product_ids)) {
            foreach ($product_ids as $id) {
                $this->delete_product_permanently($id);
            }
        }
    }

    //restore product
    public function restore_product($product_id)
    {
        $product = $this->get_product($product_id);
        if (!empty($product)) {
            $data = array(
                'is_deleted' => 0
            );
            $this->db->where('id', $product->id);
            return $this->db->update('products', $data);
        }
        return false;
    }

    /*
    *------------------------------------------------------------------------------------------
    * CSV BULK IMPORT
    *------------------------------------------------------------------------------------------
    */

    //generate CSV object
    public function generate_csv_object($file_path)
    {
        $array = array();
        $fields = array();
        $txt_name = uniqid() . '-' . $this->auth_user->id . '.txt';
        $i = 0;
        $handle = fopen($file_path, "r");
        if ($handle) {
            while (($row = fgetcsv($handle)) !== false) {
                if (empty($fields)) {
                    $fields = $row;
                    continue;
                }
                foreach ($row as $k => $value) {
                    $array[$i][$fields[$k]] = $value;
                }
                $i++;
            }
            if (!feof($handle)) {
                return false;
            }
            fclose($handle);

            if (!empty($array)) {
                $txt_file = fopen(FCPATH . "uploads/temp/" . $txt_name, "w");
                fwrite($txt_file, serialize($array));
                fclose($txt_file);
                $csv_object = new stdClass();
                $csv_object->number_of_items = count($array);
                $csv_object->txt_file_name = $txt_name;
                @unlink($file_path);
                return $csv_object;
            }
        }
        return false;
    }

    //import csv item
    public function import_csv_item($txt_file_name, $index)
    {
        $file_path = FCPATH . 'uploads/temp/' . $txt_file_name;
        $file = fopen($file_path, 'r');
        $content = fread($file, filesize($file_path));
        $array = unserialize_data($content);
        if (!empty($array)) {
            $listing_type = $this->input->post('listing_type', true);
            $currency = $this->input->post('currency', true);
            $country_id = $this->input->post('country_id', true);
            $state_id = $this->input->post('state_id', true);
            $city_id = $this->input->post('city_id', true);
            $address = $this->input->post('address', true);
            $zip_code = $this->input->post('zip_code', true);
            $i = 1;
            foreach ($array as $item) {
                if ($i == $index) {
                    if (!$this->membership_model->is_allowed_adding_product()) {
                        echo "Upgrade your current plan if you want to upload more ads!";
                        exit();
                    }
                    $data = array();
                    $product_title = get_csv_value($item, 'title');
                    $data['slug'] = !empty(get_csv_value($item, 'slug')) ? get_csv_value($item, 'slug') : str_slug($product_title);
                    $data['product_type'] = "physical";
                    $data['listing_type'] = !empty($listing_type) ? $listing_type : 'sell_on_site';
                    $data['sku'] = get_csv_value($item, 'sku');
                    $data['category_id'] = !empty(get_csv_value($item, 'category_id', 'int')) ? get_csv_value($item, 'category_id', 'int') : 1;
                    $data['price'] = $this->get_csv_price(get_csv_value($item, 'price'));
                    $data['currency'] = !empty($currency) ? $currency : 'USD';
                    $data['discount_rate'] = get_csv_value($item, 'discount_rate', 'int');
                    $data['gst_rate'] = get_csv_value($item, 'gst_rate', 'int');
                    $data['country_id'] = !empty($country_id) ? $country_id : 0;
                    $data['state_id'] = !empty($state_id) ? $state_id : 0;
                    $data['city_id'] = !empty($city_id) ? $city_id : 0;
                    $data['address'] = !empty($address) ? $address : "";
                    $data['zip_code'] = !empty($zip_code) ? $zip_code : "";
                    $data['user_id'] = $this->auth_user->id;
                    $data['status'] = 0;
                    $data['is_promoted'] = 0;
                    $data['promote_start_date'] = "";
                    $data['promote_end_date'] = "";
                    $data['promote_plan'] = "none";
                    $data['promote_day'] = 0;
                    $data['visibility'] = 1;
                    $data['rating'] = 0;
                    $data['pageviews'] = 0;
                    $data['demo_url'] = "";
                    $data['external_link'] = "";
                    $data['files_included'] = "";
                    $data['stock'] = get_csv_value($item, 'stock');
                    $data['shipping_time'] = get_csv_value($item, 'shipping_time');
                    $data['shipping_cost_type'] = get_csv_value($item, 'shipping_cost_type');
                    $data['shipping_cost'] = $this->get_csv_price(get_csv_value($item, 'shipping_cost'));
                    $data['shipping_cost_additional'] = 0;
                    $data['is_deleted'] = 0;
                    $data['is_draft'] = 0;
                    $data['is_free_product'] = 0;
                    $data['created_at'] = date('Y-m-d H:i:s');
                    if ($this->general_settings->approve_before_publishing == 0 || $this->auth_user->role == 'admin') {
                        $data["status"] = 1;
                    }
                    if ($this->db->insert('products', $data)) {
                        //last id
                        $last_id = $this->db->insert_id();
                        //update slug
                        $this->product_model->update_slug($last_id);
                        //add product title description
                        $data_title_desc = array(
                            'product_id' => $last_id,
                            'lang_id' => $this->selected_lang->id,
                            'title' => $product_title,
                            'description' => get_csv_value($item, 'description'),
                            'seo_title' => "",
                            'seo_description' => "",
                            'seo_keywords' => ""
                        );
                        $this->db->insert('product_details', $data_title_desc);

                        //upload images
                        $this->upload_product_images_csv(get_csv_value($item, 'image_url'), $last_id);

                        return $product_title;
                    }
                }
                $i++;
            }
        }
    }

    //upload product csv images
    public function upload_product_images_csv($image_url, $product_id)
    {
        if (!empty($image_url)) {
            $this->load->model('upload_model');
            $array_image_urls = explode(',', $image_url);
            if (!empty($array_image_urls)) {
                foreach ($array_image_urls as $url) {
                    $url = trim($url);
                    if (filter_var($url, FILTER_VALIDATE_URL) !== FALSE) {
                        //upload images
                        $save_to = FCPATH . "uploads/temp/temp-" . $this->auth_user->id . ".jpg";
                        @copy($url, $save_to);
                        if (!empty($save_to) && file_exists($save_to)) {
                            $data_image = [
                                'product_id' => $product_id,
                                'image_default' => $this->upload_model->product_default_image_upload($save_to, "images"),
                                'image_big' => $this->upload_model->product_big_image_upload($save_to, "images"),
                                'image_small' => $this->upload_model->product_small_image_upload($save_to, "images"),
                                'is_main' => 0,
                                'storage' => "local"
                            ];
                            $this->upload_model->delete_temp_image($save_to);
                        }
                        //move to s3
                        if ($this->storage_settings->storage == "aws_s3") {
                            $this->load->model("aws_model");
                            $data_image["storage"] = "aws_s3";
                            //move images
                            if (!empty($data_image["image_default"])) {
                                $this->aws_model->put_product_object($data_image["image_default"], FCPATH . "uploads/images/" . $data_image["image_default"]);
                                delete_file_from_server("uploads/images/" . $data_image["image_default"]);
                            }
                            if (!empty($data_image["image_big"])) {
                                $this->aws_model->put_product_object($data_image["image_big"], FCPATH . "uploads/images/" . $data_image["image_big"]);
                                delete_file_from_server("uploads/images/" . $data_image["image_big"]);
                            }
                            if (!empty($data_image["image_small"])) {
                                $this->aws_model->put_product_object($data_image["image_small"], FCPATH . "uploads/images/" . $data_image["image_small"]);
                                delete_file_from_server("uploads/images/" . $data_image["image_small"]);
                            }
                        }
                        @$this->db->close();
                        @$this->db->initialize();
                        $this->db->insert('images', $data_image);
                    }
                }
            }
        }
    }
    public function get_title($product_id)
    {
        $sql = "SELECT title from product_details,products where product_details.product_id=products.id";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function repeated_purchase($seller_id)
    {
        $seller_id = clean_number($seller_id);
        $sql = "SELECT SUM(REPEAT_count) as sum from fact_repeat_purchase where seller_id=$seller_id";
        $query = $this->db->query($sql);
        return $query->result();
    }
    //get csv price
    public function max_orders_count($seller_id)
    {
        $sql = "SELECT COUNT(*) as count from stag_max_orders_weekly where seller_id=$seller_id and week(order_date)=week(created_at)";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function max_customers_weekly($seller_id)
    {
        $sql = "SELECT COUNT(buyer_id) as cnt FROM stag_max_customers_weekly where seller_id=$seller_id AND  WEEK(created_at)=week(now()) AND YEAR(created_at)=YEAR(now()) GROUP BY seller_id,WEEK(created_at) ";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function get_csv_price($price)
    {
        if (!empty($price)) {
            $price = str_replace(',', '.', $price);
            $price = preg_replace('/[^0-9\.,]/', '', $price);
            $price = @number_format($price, 2, '.', '');
            $price = str_replace('.00', '', $price);
            $price = floatval($price);
            return $price * 100;
        }
        return 0;
    }
    public function delete_tagged_product($feature_id, $product_id)
    {
        $sql = "Delete from product_banner_tagging where feature_id=$feature_id and product_id=$product_id";
        $query = $this->db->query($sql);
        // return $query;

    }

    public function hide_products($product_id)
    {
        $product = $this->get_product($product_id);
        if (!empty($product)) {
            $data = array(
                'visibility' => 0
            );
            $this->db->where('id', $product->id);
            return $this->db->update('products', $data);
        }
        return false;
    }
    public function unhide_products($product_id)
    {
        $product = $this->get_product($product_id);
        if (!empty($product)) {
            $data = array(
                'visibility' => 1
            );
            $this->db->where('id', $product->id);
            return $this->db->update('products', $data);
        }
        return false;
    }
    public function get_product_for_quick_view($id)
    {
        $sql = "SELECT products.*, users.username AS user_username,users.brand_name AS brand_name,users.supplier_speciality AS user_supplier_speciality,users.id AS user_id, users.shop_name AS shop_name, users.role AS user_role, users.slug AS user_slug FROM products left join users on products.user_id=users.id Where products.id=$id";
        $query = $this->db->query($sql);
        return $query->row();
    }
}
