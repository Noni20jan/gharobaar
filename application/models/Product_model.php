<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends Core_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //add product
    public function add_product()
    {
        $data = array(
            'slug' => str_slug($this->input->post('title_' . $this->selected_lang->id, true)),
            'product_type' => $this->input->post('product_type', true),
            'supplier_product_type' => $this->input->post('product_type1', true),
            'listing_type' => 'sell_on_site',
            'available_for_return_or_exchange' => $this->input->post('return_or_exchange', true),
            'available_for_barter' => $this->input->post('product_barter', true),

            'is_organic' => $this->input->post('is_organic', true),
            'is_sustainable' => $this->input->post('is_sustainable', true),
            'is_handicraft' => $this->input->post('is_handicraft', true),
            'is_gluten_Free' => $this->input->post('is_gluten_Free', true),
            'is_vegan' => $this->input->post('is_vegan', true),
            'order_capacity' => $this->input->post('order_capacity', true),


            'is_keto_friendly' => $this->input->post('is_keto_friendly', true),
            'is_allergens' => $this->input->post('is_allergens', true),
            'is_veg_nonveg_jain' => $this->input->post('is_veg_nonveg_jain', true),
            'is_appetisers_main_course_beverages_desserts' => $this->input->post('is_appetisers_main_course_beverages_desserts', true),
            'is_gold_silver_precious_stones_semi_precious_artificial' => $this->input->post('is_gold_silver_precious_stones_semi_precious_artificial', true),

            'sku' => $this->input->post('sku', true),
            'price' => 0,
            'listing_price' => 0,
            'price_exclude_gst' => 0,
            'net_seller_payable' => 0,
            'currency' => "",
            'discount_rate' => 0,
            'gst_rate' => 0,
            'commission_amount' => 0,
            'gst_on_commission_amount' => 0,
            'gharobaar_commission_amount' => 0,
            'country_id' => 0,
            'state_id' => 0,
            'city_id' => 0,
            'address' => "",
            'zip_code' => "",
            'user_id' => $this->auth_user->id,
            'status' => 0,
            'is_promoted' => 0,
            'promote_start_date' => date('Y-m-d H:i:s'),
            'promote_end_date' => date('Y-m-d H:i:s'),
            'promote_plan' => "none",
            'promote_day' => 0,
            'visibility' => 1,
            'rating' => 0,
            'pageviews' => 0,
            'demo_url' => "",
            'external_link' => "",
            'files_included' => "",
            'stock' => 1,
            'shipping_time' => "",
            'shipping_cost_type' => "",
            'shipping_cost' => $this->input->post('shipping_cost', true),
            'shipping_cost_additional' => 0,
            'is_deleted' => 0,
            'is_draft' => 1,
            'is_free_product' => 0,
            'created_at' => date('Y-m-d H:i:s')
        );

        //set category id
        $data['category_id'] = get_dropdown_category_id();

        return $this->db->insert('products', $data);
    }
    public function add_service()
    {
        $data = array(
            'slug' => str_slug($this->input->post('title_' . $this->selected_lang->id, true)),
            'product_type' => $this->input->post('product_type', true),
            'supplier_product_type' => $this->input->post('product_type1', true),
            'listing_type' => 'sell_on_site',
            'work_day' => $this->input->post('work_day', true),
            'tentative_time' => $this->input->post('tentative_time', true),
            'work_time' => $this->input->post('work_time', true),
            'available_for_return_or_exchange' => $this->input->post('return_or_exchange', true),
            'available_for_barter' => $this->input->post('product_barter', true),
            'sku' => $this->input->post('sku', true),
            'price' => 0,
            'order_capacity' => $this->input->post('order_capacity', true),

            'currency' => "",
            'discount_rate' => 0,
            'is_service' => 1,
            'gst_rate' => 0,
            'gst_amount' => 0,
            'country_id' => 0,
            'state_id' => 0,
            'city_id' => 0,
            'address' => "",
            'zip_code' => "",
            'user_id' => $this->auth_user->id,
            'status' => 0,
            'is_promoted' => 0,
            'promote_start_date' => date('Y-m-d H:i:s'),
            'promote_end_date' => date('Y-m-d H:i:s'),
            'promote_plan' => "none",
            'promote_day' => 0,
            'visibility' => 1,
            'rating' => 0,
            'pageviews' => 0,
            'demo_url' => "",
            'external_link' => "",
            'files_included' => "",
            'stock' => 1,
            'shipping_time' => "",
            'shipping_cost_type' => "",
            'shipping_cost' =>  $this->input->post('shipping_cost', true),
            'shipping_cost_additional' => 0,
            'is_deleted' => 0,
            'is_draft' => 1,
            'is_free_product' => 0,
            'created_at' => date('Y-m-d H:i:s')
        );

        //set category id
        $data['category_id'] = get_dropdown_category_id();

        return $this->db->insert('products', $data);
    }



    //add product title and desc
    public function add_product_title_desc($product_id)
    {
        $main_title = trim($_POST['title_' . $this->site_lang->id]);
        foreach ($this->languages as $language) {
            $title = trim($_POST['title_' . $this->site_lang->id]);
            if (!empty($title)) {
                $data = array(
                    'product_id' => $product_id,
                    'lang_id' => $language->id,
                    'title' => !empty($title) ? $title : $main_title,
                    'description' => $this->input->post('description_' . $language->id, false),
                    'seo_title' => $this->input->post('seo_title_' . $language->id, true),
                    'seo_description' => $this->input->post('seo_description_' . $language->id, true),
                    'seo_keywords' => $this->input->post('seo_keywords_' . $language->id, true)
                );
                $this->db->insert('product_details', $data);
            }
        }
    }

    //edit product title and desc
    public function edit_product_title_desc($product_id)
    {
        $main_title = trim($_POST['title_' . $this->site_lang->id]);
        foreach ($this->languages as $language) {
            $title = trim($_POST['title_' . $this->site_lang->id]);
            $data = array(
                'product_id' => $product_id,
                'lang_id' => $language->id,
                'title' => !empty($title) ? $title : $main_title,
                'description' => $this->input->post('description_' . $language->id, false),
                'seo_title' => $this->input->post('seo_title_' . $language->id, true),
                'seo_description' => $this->input->post('seo_description_' . $language->id, true),
                'seo_keywords' => $this->input->post('seo_keywords_' . $language->id, true)
            );
            $product = get_product($product_id);
            if ($product->status == 1) {
                if (get_product_details_by_id($product_id)->description != $data["description"] && $this->auth_user->role != 'admin') {
                    $data_product["status"] = 0;
                    $this->db->where('id', $product_id);
                    $this->db->update('products', $data_product);
                }
            }
            $row = get_product_details($product_id, $language->id, false);

            if (empty($row)) {
                $this->db->insert('product_details', $data);
            } else {
                $this->db->where('product_id', $product_id)->where('lang_id', $language->id);
                $this->db->update('product_details', $data);
            }
        }
    }

    //edit product details
    public function edit_product_details($id)
    {
        $product = $this->get_product_by_id($id);
        $data = array(
            'available_for_return_or_exchange' => $this->input->post('return_or_exchange', true),
            'available_for_barter' => $this->input->post('product_barter', true),
            'price' => $this->input->post('price', true),
            'listing_price' => $this->input->post('listing_price', true),
            'price_exclude_gst' => $this->input->post('price_exclude_gst', true),
            'net_seller_payable' => $this->input->post('net_seller_payable', true),
            'currency' => $this->input->post('currency', true),
            'discount_rate' => $this->input->post('discount_rate', true),
            'gst_rate' => $this->input->post('gst_rate', true),
            'gst_amount' => $this->input->post('gst_amount_input', true),
            'commission_amount' => $this->input->post('commission_amount_input', true),
            'gst_on_commission_amount' => $this->input->post('gst_on_commission_amount_input', true),
            'gharobaar_commission_amount' => $this->input->post('gharobaar_commission_amount_input', true),
            'hsn_code' => $this->input->post('hsn_code', true),
            'country_id' => $this->input->post('country_id', true),
            'state_id' => $this->input->post('state_id', true),
            'city_id' => $this->input->post('city_id', true),
            'address' => $this->input->post('address', true),
            'zip_code' => $this->input->post('zip_code', true),
            'demo_url' => trim($this->input->post('demo_url', true)),
            'external_link' => trim($this->input->post('external_link', true)),
            'files_included' => trim($this->input->post('files_included', true)),
            'stock' => $this->input->post('stock', true),
            'add_meet' => $this->input->post('add_meet', true),
            'cod_accepted' => $this->input->post('cod_accepted', true),
            'shipping_time' => $this->input->post('shipping_time', true),
            'shipping_cost_type' => $this->input->post('shipping_cost_type', true),
            'is_free_product' => $this->input->post('is_free_product', true),
            'product_wash_instruction' => $this->input->post('product_wash_instruction', true),
            'blouse_details' => $this->input->post('blouse_details', true),
            'pet_age' => $this->input->post('pet_age', true),
            'storage_instruction' => $this->input->post('storage_instruction', true),
            'minimum_Prior_notice' => $this->input->post('minimum_Prior_notice', true),
            'is_organic' => $this->input->post('is_organic', true),
            'is_sustainable' => $this->input->post('is_sustainable', true),
            'is_handicraft' => $this->input->post('is_handicraft', true),
            'is_gluten_Free' => $this->input->post('is_gluten_Free', true),
            'is_vegan' => $this->input->post('is_vegan', true),
            'delivery_area' => $this->input->post('delivery_area', true),
            'is_personalised' => $this->input->post('is_personalised', true),
            'is_keto_friendly' => $this->input->post('is_keto_friendly', true),
            'is_allergens' => $this->input->post('is_allergens', true),
            'is_veg_nonveg_jain' => $this->input->post('is_veg_nonveg_jain', true),
            'is_appetisers_main_course_beverages_desserts' => $this->input->post('is_appetisers_main_course_beverages_desserts', true),
            'is_gold_silver_precious_stones_semi_precious_artificial' => $this->input->post('is_gold_silver_precious_stones_semi_precious_artificial', true),
            'special_delivery_requirement' => $this->input->post('special_delivery', true),
            'special_delivery_other' => $this->input->post('special_delivery_other', true),
            'contains_liquid' => $this->input->post('contains_liquid', true),
            'contains_heat' => $this->input->post('contains_heat', true),
            'is_expire' => $this->input->post('expire', true),
            'order_capacity' => $this->input->post('order_capacity', true),
            'expiry_date' => $this->input->post('expiry_date', true),
            'shelf_life_from_date_of_manufacture' => $this->input->post('shelf_life', true),
            'shelf_units' => trim($this->input->post('shelf_units', true)),
            'manufacturing_date' => $this->input->post('manufacturing_date', true),
            'weight' => $this->input->post('weight', true),
            'product_weight' => $this->input->post('product_weight', true),
            'packed_product_length' => $this->input->post('product_length', true),
            'packed_product_width' => $this->input->post('product_width', true),
            'packed_product_height' => $this->input->post('product_height', true),
            'temperature' => $this->input->post('temperature', true),
            'allergance' => trim($this->input->post('allergance', true)),
            'lead_time' => trim($this->input->post('lead_time', true)),
            'weight_units' => 'grams',
            'lead_days' => trim($this->input->post('lead_days', true)),
            'availability' => implode(",", $this->input->post('availability', true)),
            'product_pincode' => trim($this->input->post('pincode1', true)),
            'product_area' => trim($this->input->post('area', true)),
            'product_state' => trim($this->input->post('supplier_state1', true)),
            'product_city' => trim($this->input->post('supplier_city', true)),
            'product_address' => trim($this->input->post('house_no', true)),
            'landmark' => trim($this->input->post('landmark', true)),

            'product_pincode_1' => trim($this->input->post('pincode2', true)),
            'product_state_1' => trim($this->input->post('supplier_state2', true)),
            'product_city_1' => trim($this->input->post('supplier_city1', true)),
            'product_area_1' => trim($this->input->post('area1', true)),
            'product_address_1' => trim($this->input->post('house_no1', true)),
            'landmark_1' => trim($this->input->post('landmark1', true)),

            'other_product_wash_instruction' => $this->input->post('other_product_wash_instruction', true),
            'other_blouse_details' => trim($this->input->post('other_blouse_details', true)),
            'other_minimum_Prior_notice' => trim($this->input->post('other_minimum_Prior_notice', true)),
            'other_pet_age' => trim($this->input->post('other_pet_age', true)),
            'other_storage_instruction' => trim($this->input->post('other_storage_instruction', true)),
            'other_delivery_area' => trim($this->input->post('other_delivery_area', true)),

            'status' => 0,
            'is_draft' => 0
        );

        if ($product->status == 1) {
            if ($product->lead_days != $data["lead_days"] || $product->product_pincode != $data["product_pincode"] || $product->product_area != $data["product_area"] || $product->product_state != $data["product_state"] || $product->product_city != $data["product_city"] || $product->product_address != $data["product_address"] || $product->landmark != $data["landmark"]) {
                if (empty($data["status"])) {
                    $data["status"] = 0;
                    $data['created_at'] = date('Y-m-d H:i:s');
                }
            } else {
                if (empty($data["status"])) {
                    $data["status"] = 1;
                }
            }
        }
        if ($data["add_meet"] == "Made to order") {
            $data["stock"] = 999;
        }

        $data["price"] = get_price($data["price"], 'database');
        if (empty($data["price"])) {
            $data["price"] = 0;
        }
        $data["listing_price"] = get_price($data["listing_price"], 'database');
        if (empty($data["listing_price"])) {
            $data["listing_price"] = 0;
        }
        $data["price_exclude_gst"] = get_price($data["price_exclude_gst"], 'database');
        if (empty($data["price_exclude_gst"])) {
            $data["price_exclude_gst"] = 0;
        }
        $data["net_seller_payable"] = get_price($data["net_seller_payable"], 'database');
        if (empty($data["net_seller_payable"])) {
            $data["net_seller_payable"] = 0;
        }
        $data["gst_amount"] = get_price($data["gst_amount"], 'database');
        if (empty($data["gst_amount"])) {
            $data["gst_amount"] = 0;
        }
        $data["commission_amount"] = get_price($data["commission_amount"], 'database');
        if (empty($data["commission_amount"])) {
            $data["commission_amount"] = 0;
        }
        $data["gst_on_commission_amount"] = get_price($data["gst_on_commission_amount"], 'database');
        if (empty($data["gst_on_commission_amount"])) {
            $data["gst_on_commission_amount"] = 0;
        }
        $data["gharobaar_commission_amount"] = get_price($data["gharobaar_commission_amount"], 'database');
        if (empty($data["gharobaar_commission_amount"])) {
            $data["gharobaar_commission_amount"] = 0;
        }
        if (empty($data["discount_rate"])) {
            $data["discount_rate"] = 0;
        }
        if (empty($data["gst_rate"])) {
            $data["gst_rate"] = 0;
        }
        if (empty($data["country_id"])) {
            $data["country_id"] = 0;
        }
        if (empty($data["state_id"])) {
            $data["state_id"] = 0;
        }
        if (empty($data["city_id"])) {
            $data["city_id"] = 0;
        }
        if (empty($data["address"])) {
            $data["address"] = "";
        }
        if (empty($data["zip_code"])) {
            $data["zip_code"] = "";
        }
        if (empty($data["external_link"])) {
            $data["external_link"] = "";
        }
        if (empty($data["stock"])) {
            $data["stock"] = 0;
        }
        if (!empty($data["is_free_product"])) {
            $data["is_free_product"] = 1;
        } else {
            $data["is_free_product"] = 0;
        }

        //unset price if bidding system selected
        if ($this->general_settings->bidding_system == 1) {
            $array['price'] = 0;
        }

        if ($this->settings_model->is_shipping_option_require_cost($data["shipping_cost_type"]) == 1) {
            $data["shipping_cost"] = $this->input->post('shipping_cost', true);
            $data["shipping_cost"] = get_price($data["shipping_cost"], 'database');
            $data["shipping_cost_additional"] = $this->input->post('shipping_cost_additional', true);
            $data["shipping_cost_additional"] = get_price($data["shipping_cost_additional"], 'database');
        } else {
            $data["shipping_cost"] = 0;
            $data["shipping_cost_additional"] = 0;
        }

        if ($this->input->post('submit', true) == 'save_as_draft') {
            $data["is_draft"] = 1;
        } else {
            if ($this->general_settings->approve_before_publishing == 0 || $this->auth_user->role == 'admin') {
                $data["status"] = 1;
                $data['created_at'] = date('Y-m-d H:i:s');
            }
        }

        $this->db->where('id', clean_number($id));
        return $this->db->update('products', $data);
    }

    public function edit_service_details($id)
    {
        $product = $this->get_product_by_id($id);
        $data = array(
            'available_for_return_or_exchange' => $this->input->post('return_or_exchange', true),
            'available_for_barter' => $this->input->post('product_barter', true),
            'price' => $this->input->post('price', true),
            'currency' => $this->input->post('currency', true),
            'work_day' => $this->input->post('work_day', true),
            'tentative_time' => $this->input->post('tentative_time', true),
            'work_time' => $this->input->post('work_time', true),
            'discount_rate' => $this->input->post('discount_rate', true),
            'gst_rate' => $this->input->post('gst_rate', true),
            'country_id' => $this->input->post('country_id', true),
            'state_id' => $this->input->post('state_id', true),
            'city_id' => $this->input->post('city_id', true),
            'address' => $this->input->post('address', true),
            'zip_code' => $this->input->post('zip_code', true),
            'demo_url' => trim($this->input->post('demo_url', true)),
            'external_link' => trim($this->input->post('external_link', true)),
            'files_included' => trim($this->input->post('files_included', true)),
            'stock' => 100,
            'shipping_time' => $this->input->post('shipping_time', true),
            'shipping_cost_type' => $this->input->post('shipping_cost_type', true),
            'is_free_product' => $this->input->post('is_free_product', true),
            'is_draft' => 0
        );

        $data["price"] = get_price($data["price"], 'database');
        if (empty($data["price"])) {
            $data["price"] = 0;
        }
        if (empty($data["discount_rate"])) {
            $data["discount_rate"] = 0;
        }
        if (empty($data["gst_rate"])) {
            $data["gst_rate"] = 0;
        }
        if (empty($data["country_id"])) {
            $data["country_id"] = 0;
        }
        if (empty($data["state_id"])) {
            $data["state_id"] = 0;
        }
        if (empty($data["city_id"])) {
            $data["city_id"] = 0;
        }
        if (empty($data["address"])) {
            $data["address"] = "";
        }
        if (empty($data["zip_code"])) {
            $data["zip_code"] = "";
        }
        if (empty($data["external_link"])) {
            $data["external_link"] = "";
        }
        if (empty($data["stock"])) {
            $data["stock"] = 0;
        }
        if (!empty($data["is_free_product"])) {
            $data["is_free_product"] = 1;
        } else {
            $data["is_free_product"] = 0;
        }

        //unset price if bidding system selected
        if ($this->general_settings->bidding_system == 1) {
            $array['price'] = 0;
        }

        if ($this->settings_model->is_shipping_option_require_cost($data["shipping_cost_type"]) == 1) {
            $data["shipping_cost"] = $this->input->post('shipping_cost', true);
            $data["shipping_cost"] = get_price($data["shipping_cost"], 'database');
            $data["shipping_cost_additional"] = $this->input->post('shipping_cost_additional', true);
            $data["shipping_cost_additional"] = get_price($data["shipping_cost_additional"], 'database');
        } else {
            $data["shipping_cost"] = 0;
            $data["shipping_cost_additional"] = 0;
        }

        if ($this->input->post('submit', true) == 'save_as_draft') {
            $data["is_draft"] = 1;
        } else {
            if ($this->general_settings->approve_before_publishing == 0 || $this->auth_user->role == 'admin') {
                $data["status"] = 1;
            }
        }

        $this->db->where('id', clean_number($id));
        return $this->db->update('products', $data);
    }

    //edit product
    public function edit_product($product, $slug)
    {
        $data = array(
            'product_type' => $this->input->post('product_type', true),
            'supplier_product_type' => $this->input->post('product_type1', true),
            'listing_type' => 'sell_on_site',
            'slug' => $slug,
            'sku' => $this->input->post('sku', true)
        );
        //set category id
        $data['category_id'] = get_dropdown_category_id();

        $data["visibility"] = $product->visibility;
        if ($product->is_draft != 1 && is_admin()) {
            $data["visibility"] = $this->input->post('visibility', true);
        }

        if ($product->listing_type == 'ordinary_listing') {
            $data["stock"] = $this->input->post('stock', true);
        }

        $this->db->where('id', $product->id);
        return $this->db->update('products', $data);
    }

    //update custom fields
    public function update_product_custom_fields($product_id)
    {
        $product = $this->get_product_by_id($product_id);
        if (!empty($product)) {
            $custom_fields = $this->field_model->get_custom_fields_by_category($product->category_id);
            if (!empty($custom_fields)) {
                //delete previous custom field values
                $this->field_model->delete_field_product_values_by_product_id($product_id);

                foreach ($custom_fields as $custom_field) {
                    $input_value = $this->input->post('field_' . $custom_field->id, true);
                    //add custom field values
                    if (!empty($input_value)) {
                        if ($custom_field->field_type == 'checkbox') {
                            foreach ($input_value as $key => $value) {
                                $data = array(
                                    'field_id' => $custom_field->id,
                                    'product_id' => $product_id,
                                    'product_filter_key' => $custom_field->product_filter_key
                                );
                                $data['field_value'] = '';
                                $data['selected_option_id'] = $value;
                                $this->db->insert('custom_fields_product', $data);
                            }
                        } else {
                            $data = array(
                                'field_id' => $custom_field->id,
                                'product_id' => clean_number($product_id),
                                'product_filter_key' => $custom_field->product_filter_key,
                            );
                            if ($custom_field->field_type == 'radio_button' || $custom_field->field_type == 'dropdown') {
                                $data['field_value'] = '';
                                $data['selected_option_id'] = $input_value;
                            } else {
                                $data['field_value'] = $input_value;
                                $data['selected_option_id'] = 0;
                            }
                            $this->db->insert('custom_fields_product', $data);
                        }
                    }
                }
            }
        }
    }

    //update slug
    public function update_slug($id)
    {
        $product = $this->get_product_by_id($id);
        if (!empty($product)) {
            if (empty($product->slug) || $product->slug == "-") {
                $data = array(
                    'slug' => $product->id,
                );
            } else {
                if ($this->general_settings->product_link_structure == "id-slug") {
                    $data = array(
                        'slug' => $product->id . "-" . $product->slug,
                    );
                } else {
                    $data = array(
                        'slug' => $product->slug . "-" . $product->id,
                    );
                }
            }
            if (!empty($this->page_model->check_page_slug_for_product($data["slug"]))) {
                $data["slug"] .= uniqid();
            }
            $this->db->where('id', $product->id);
            return $this->db->update('products', $data);
        }
    }
    public function get_supplier_by_supplier_speciality($speciality)
    {

        $sql = "SELECT * FROM users WHERE supplier_speciality =  ?";
        $query = $this->db->query($sql, array($speciality));

        return $query->result();
    }
    public function get_supplier_by_supplier_origin($origin_of_product)
    {

        $sql = "SELECT * FROM users WHERE supplier_state =  ?";
        $query = $this->db->query($sql, array($origin_of_product));

        return $query->result();
    }

    //build sql query string
    public function build_query($type = "active", $compile_query = false, $only_category = false)
    {

        $select = "products.*,
            users.username AS user_username,users.brand_name AS brand_name,users.supplier_speciality AS user_supplier_speciality,users.id AS user_id, users.shop_name AS shop_name, users.role AS user_role, users.slug AS user_slug,
            (SELECT title FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id = " . clean_number($this->selected_lang->id) . " LIMIT 1) AS title,
            (SELECT CONCAT(storage, '::', image_small) FROM images WHERE products.id = images.product_id ORDER BY is_main DESC LIMIT 1) AS image,
            (SELECT CONCAT(storage, '::', image_small) FROM images WHERE products.id = images.product_id ORDER BY is_main DESC LIMIT 1, 1) AS image_second,
            (SELECT COUNT(wishlist.id) FROM wishlist WHERE products.id = wishlist.product_id) AS wishlist_count";
        if (item_count($this->languages) > 1) {
            $select .= ", (SELECT title FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id != " . clean_number($this->selected_lang->id) . " LIMIT 1) AS second_title";
        }
        if ($this->auth_check) {
            $select .= ", (SELECT COUNT(wishlist.id) FROM wishlist WHERE products.id = wishlist.product_id AND wishlist.user_id = " . clean_number($this->auth_user->id) . ") AS is_in_wishlist";
        } else {
            $select .= ", 0 AS is_in_wishlist";
        }

        if ($only_category) {
            $select = "products.category_id as cat_id";
        }

        $status = ($type == 'draft' || $type == 'pending') ? 0 : 1;
        $visibility = ($type == 'hidden') ? 0 : 1;
        $is_draft = ($type == 'draft') ? 1 : 0;

        if ($only_category) {
            $this->db->distinct();
        }
        $this->db->select($select);
        if ($compile_query == true) {
            $this->db->from('products');
        }

        if ($this->general_settings->membership_plans_system == 1) {
            if ($type == "expired") {
                $this->db->join('users', 'products.user_id = users.id AND users.is_membership_plan_expired = 1');
            } else {
                $this->db->join('users', 'products.user_id = users.id AND users.is_membership_plan_expired = 0');
            }
        } else {
            $this->db->join('users', 'products.user_id = users.id');
        }
        if ($type == 'wishlist') {
            $this->db->join('wishlist', 'products.id = wishlist.product_id');
        }
        $this->db->where('users.banned', 0);
        $this->db->where('products.status', $status);
        $this->db->where('products.visibility', $visibility);
        $this->db->where('products.is_draft', $is_draft);
        $this->db->where('products.is_deleted', 0);
        // $this->db->order_by('products.id', 'random');
        if ($type == 'promoted') {
            $this->db->where('products.is_promoted', 1);
        }
        if ($this->general_settings->vendor_verification_system == 1) {
            $this->db->where('users.role !=', 'member');
        }
        //default location
        if (!empty($this->default_location->country_id)) {
            $this->db->where('products.country_id', $this->default_location->country_id);
        }
        if (!empty($this->default_location->state_id)) {
            $this->db->where('products.state_id', $this->default_location->state_id);
        }
        if (!empty($this->default_location->city_id)) {
            $this->db->where('products.city_id', $this->default_location->city_id);
        }
        if (!empty($_SESSION["modesy_sess_user_location"])) {
            $pincode = $_SESSION["modesy_sess_user_location"];
            $seller = $this->get_seller_by_pincode_dist($pincode);
            $this->db->group_start();
            if (count($seller["HOMECOOK"]) > 0) :
                $this->db->where_in('products.user_id', $seller["HOMECOOK"]);
                $this->db->where_in('products.category_id', $this->get_all_cateory_by_type("HOMECOOK"));
            endif;
            if (count($seller["NON-HOMECOOK"]) > 0) :
                $this->db->or_group_start();
                $this->db->where_in('products.user_id', $seller["NON-HOMECOOK"]);
                $this->db->where_in('products.category_id', $this->get_all_cateory_by_type("NON-HOMECOOK"));
                $this->db->group_end();
            endif;
            $this->db->group_end();

            $product_list = $this->product_not_deliver_as_per_delivey_area($pincode);
            if (count($product_list) > 0) :
                $this->db->where_not_in('products.id', $product_list);
            endif;
        }
        // var_dump($this->db->get_compiled_select());
        // die();
        if ($compile_query == true) {

            return $this->db->get_compiled_select() . " ";
        }
    }



    public function build_query_without_pin($type = "active", $compile_query = false)
    {
        $select = "products.*,
            users.username AS user_username,users.brand_name AS brand_name,users.supplier_speciality AS user_supplier_speciality,users.id AS user_id, users.shop_name AS shop_name, users.role AS user_role, users.slug AS user_slug,
            (SELECT title FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id = " . clean_number($this->selected_lang->id) . " LIMIT 1) AS title,
            (SELECT CONCAT(storage, '::', image_small) FROM images WHERE products.id = images.product_id ORDER BY is_main DESC LIMIT 1) AS image,
            (SELECT CONCAT(storage, '::', image_small) FROM images WHERE products.id = images.product_id ORDER BY is_main DESC LIMIT 1, 1) AS image_second,
            (SELECT COUNT(wishlist.id) FROM wishlist WHERE products.id = wishlist.product_id) AS wishlist_count";
        if (item_count($this->languages) > 1) {
            $select .= ", (SELECT title FROM product_details WHERE product_details.product_id = products.id AND product_details.lang_id != " . clean_number($this->selected_lang->id) . " LIMIT 1) AS second_title";
        }
        if ($this->auth_check) {
            $select .= ", (SELECT COUNT(wishlist.id) FROM wishlist WHERE products.id = wishlist.product_id AND wishlist.user_id = " . clean_number($this->auth_user->id) . ") AS is_in_wishlist";
        } else {
            $select .= ", 0 AS is_in_wishlist";
        }

        $status = ($type == 'draft' || $type == 'pending') ? 0 : 1;
        $visibility = ($type == 'hidden') ? 0 : 1;
        $is_draft = ($type == 'draft') ? 1 : 0;

        $this->db->select($select);
        if ($compile_query == true) {
            $this->db->from('products');
        }

        if ($this->general_settings->membership_plans_system == 1) {
            if ($type == "expired") {
                $this->db->join('users', 'products.user_id = users.id AND users.is_membership_plan_expired = 1');
            } else {
                $this->db->join('users', 'products.user_id = users.id AND users.is_membership_plan_expired = 0');
            }
        } else {
            $this->db->join('users', 'products.user_id = users.id');
        }
        if ($type == 'wishlist') {
            $this->db->join('wishlist', 'products.id = wishlist.product_id');
        }
        $this->db->where('users.banned', 0);
        $this->db->where('products.status', $status);
        $this->db->where('products.visibility', $visibility);
        $this->db->where('products.is_draft', $is_draft);
        $this->db->where('products.is_deleted', 0);
        // $this->db->order_by('products.id', 'random');
        if ($type == 'promoted') {
            $this->db->where('products.is_promoted', 1);
        }
        if ($this->general_settings->vendor_verification_system == 1) {
            $this->db->where('users.role !=', 'member');
        }
        //default location
        if (!empty($this->default_location->country_id)) {
            $this->db->where('products.country_id', $this->default_location->country_id);
        }
        if (!empty($this->default_location->state_id)) {
            $this->db->where('products.state_id', $this->default_location->state_id);
        }
        if (!empty($this->default_location->city_id)) {
            $this->db->where('products.city_id', $this->default_location->city_id);
        }
        // var_dump($this->db->get_compiled_select());
        // die();
        if ($compile_query == true) {

            return $this->db->get_compiled_select() . " ";
        }
    }
    //filter products
    public function filter_products($query_string_array = null, $category_id = null, $only_category = false)
    {
        $category_id = clean_number($category_id);
        $p_min = clean_number($this->input->get("p_min", true));
        $p_max = clean_number($this->input->get("p_max", true));
        $sort = str_slug($this->input->get("sort", true));
        $origin_of_product = $this->input->get("origin_of_product", true);
        $jewellery_type = $this->input->get("jewellery_type", true);
        $meal_type = $this->input->get("meal_type", true);
        $food_type = $this->input->get("food_type", true);
        $discount = $this->input->get("discount", true);
        $gender = $this->input->get("gender", true);
        $available = $this->input->get("available", true);
        $pet_age = $this->input->get("pet_age", true);
        $cash_on_delivery = $this->input->get("cash_on_delivery", true);
        $food_preference = $this->input->get("food_preference", true);
        $blouse_details =  str_replace('_', ' ', $this->input->get("blouse_details", true));
        $available_for_return_or_exchange = $this->input->get("available_for_return_or_exchange", true);
        $add_meet = str_replace('_', ' ', $this->input->get("product_type", true));
        $rating = remove_special_characters($this->input->get("rating", true));
        $seller_type = remove_special_characters($this->input->get("seller_type", true));
        $search = remove_special_characters(trim($this->input->get('search', true)));





        if (!empty($search)) {
            $array = explode(' ', $search);
            $array_search_words = array();
            foreach ($array as $item) {
                if (strlen($item) > 1) {
                    array_push($array_search_words, $item);
                }
            }
        }
        //food prefernce 
        if (!empty($food_preference)) {
            $array = explode(' ', $food_preference);
            $array_food_preference = array();
            foreach ($array as $item) {

                array_push($array_food_preference, $item);
            }
        }


        //category ids array
        if (!empty($category_id)) {
            $categories = $this->category_model->get_subcategories_tree($category_id, false);
            $category_ids = get_ids_from_array($categories);
            $this->db->reset_query();
        }

        //check if custom filters selected
        $array_selected_filters = array();

        if (!empty($query_string_array)) {


            foreach ($query_string_array as $key => $array_values) {
                if ($key != "product_type" && $key != "meal_type" && $key != "cash_on_delivery" && $key != "blouse_details" && $key != "pet_age" && $key != "available"  && $key != "gender" && $key != "discount"  && $key != "food_type" && $key != "jewellery_type"  && $key != "rating"  && $key != "p_min" && $key != "p_max" && $key != "sort" && $key != "search" && $key != "seller_type" && $key != "origin_of_product" && $key != "food_preference" && $key != "available_for_return_or_exchange") {
                    $item = new stdClass();
                    $item->key = $key;
                    $updated_array_values = array();
                    foreach ($array_values as $value) {
                        array_push($updated_array_values, serialize(array(array("lang_id" => "1", "option_name" => $value))));
                    }
                    $item->array_values = $updated_array_values;
                    array_push($array_selected_filters, $item);
                }
            }
        }



        if (!empty($array_selected_filters)) {
            $array_queries = array();
            foreach ($array_selected_filters as $filter) {
                $this->db->join('variations', 'variations.id = variation_options.variation_id');
                $this->db->select('product_id');
                $this->db->where('variations.label_names', serialize(array(array("lang_id" => "1", "label" => str_replace('_', ' ', $filter->key)))));
                $this->db->group_start();
                $this->db->where_in('variation_options.option_names', $updated_array_values);
                $this->db->group_end();
                $this->db->from('variation_options');
                $array_queries[] = $this->db->get_compiled_select();
                $this->db->reset_query();
            }
            if (!empty($array_queries)) {
                if (!$only_category) :
                    $this->build_query();
                else :
                    $this->build_query("active", false, true);
                endif;


                foreach ($array_queries as $query) {


                    $this->db->where_in('products.id', $query, FALSE);
                }
            }
        } else {
            if (!$only_category) :
                $this->build_query();
            else :
                $this->build_query("active", false, true);
            endif;
        }


        //add product filter options
        if (!empty($category_ids)) {
            $this->db->where_in("products.category_id", $category_ids, FALSE);
            $this->db->order_by('products.is_promoted', 'DESC');
        }
        //product type array
        $array_product_type = @explode(',', $add_meet);
        if (!empty($array_product_type) && !empty($array_product_type[0])) {
            $this->db->group_start();
            $this->db->where_in("products.add_meet", $array_product_type);
            $this->db->group_end();
        }

        //availability of products

        if (!empty($available)) {
            $this->db->group_start();
            $this->db->where("products.stock>", 0);
            $this->db->group_end();
        }

        if (!empty($cash_on_delivery)) {
            $this->db->group_start();
            $this->db->where("products.cod_accepted", $cash_on_delivery);
            $this->db->where("products.add_meet", "Made to stock");

            $this->db->group_end();
        }

        //blouse details
        $array_blouse_details = @explode(',', $blouse_details);
        if (!empty($array_blouse_details) && !empty($array_blouse_details[0])) {
            $this->db->group_start();
            $this->db->where_in("products.blouse_details", $array_blouse_details);
            $this->db->group_end();
        }
        $array_available_for_return_or_exchange = @explode(',', $available_for_return_or_exchange);
        if (!empty($array_available_for_return_or_exchange) && !empty($array_available_for_return_or_exchange[0])) {
            $this->db->group_start();
            $this->db->where_in("products.available_for_return_or_exchange", $array_available_for_return_or_exchange);
            $this->db->group_end();
        }
        //pet age
        $array_pet_age = @explode(',', $pet_age);
        if (!empty($array_pet_age) && !empty($array_pet_age[0])) {
            $this->db->group_start();
            $this->db->where_in("products.pet_age", $array_pet_age);
            $this->db->group_end();
        }

        //discount rate
        if (!empty($discount)) :
            $discount_array = explode(",", $discount);

            if (count($discount_array) > 0) :
                $this->db->group_start();
                if (in_array("More_than_50", $discount_array)) {
                    $this->db->or_where("cast(products.discount_rate as decimal(16,2)) BETWEEN 51 AND 100");
                }
                if (in_array("25-50", $discount_array)) {
                    $this->db->or_where("cast(products.discount_rate as decimal(16,2)) BETWEEN 25 AND 50");
                }
                if (in_array("0-25", $discount_array)) {
                    $this->db->or_where("cast(products.discount_rate as decimal(16,2)) BETWEEN 1 AND 25");
                }
                if (in_array("No Discount", $discount_array)) {
                    $this->db->or_where("products.discount_rate = 0");
                }
                $this->db->group_end();
            endif;
        endif;
        // if ($discount == "More_than_50" || $discount == "0-25" || $discount == "25-50" || $discount == "0") {
        //     $this->db->group_start();
        //     if ($discount == "More_than_50") {
        //         $this->db->where("cast(products.discount_rate as decimal(16,2)) BETWEEN 51 AND 100");
        //     } else if ($discount == "25-50") {
        //         $this->db->where("cast(products.discount_rate as decimal(16,2)) BETWEEN 25 AND 50");
        //     } else if ($discount == "0-25") {
        //         $this->db->where("products.discount_rate<=", 25);
        //         $this->db->where("products.discount_rate>=", 1);
        //     } else if ($discount == "0") {
        //         $this->db->where("products.discount_rate=0");
        //     }
        //     $this->db->group_end();
        // }

        //seller type
        if (!empty($seller_type)) {
            $user_supplier_speciality = get_supplier_by_supplier_speciality($seller_type);
            $speciality_array = array();
            foreach ($user_supplier_speciality as $speciality) {
                array_push($speciality_array, $speciality->id);
            }
            if (count($speciality_array) > 0) {
                $this->db->group_start();
                $this->db->where_in("products.user_id", $speciality_array);
                $this->db->group_end();
            } else {
                $this->db->where_in("products.user_id", 0);
            }
        }



        //rating
        $array_rating = @explode(',', $rating);
        if (!empty($array_rating) && !empty($array_rating[0])) {
            $this->db->group_start();
            $this->db->where_in("products.rating", $array_rating);
            $this->db->group_end();
        }

        //meal type
        $array_meal_type = @explode(',', $meal_type);

        if (!empty($array_meal_type) && !empty($array_meal_type[0])) {
            $this->db->group_start();
            $this->db->where_in("products.is_appetisers_main_course_beverages_desserts", $array_meal_type);
            $this->db->group_end();
        }


        //food type
        $array_food_type = @explode(',', $food_type);

        if (!empty($array_food_type) && !empty($array_food_type[0])) {
            $this->db->group_start();
            $this->db->where_in("products.is_veg_nonveg_jain", $array_food_type);
            $this->db->group_end();
        }

        //jewellwry type
        $array_jewellery_type = @explode(',', $jewellery_type);

        if (!empty($array_jewellery_type) && !empty($array_jewellery_type[0])) {
            $this->db->group_start();
            $this->db->where_in("products.is_gold_silver_precious_stones_semi_precious_artificial", $array_jewellery_type);
            $this->db->group_end();
        }


        //origin of product
        $array_origin_of_product = @explode(',', $origin_of_product);

        if (!empty($array_origin_of_product) && !empty($array_origin_of_product[0])) {
            $this->db->group_start();
            $this->db->where_in("products.product_state", $array_origin_of_product);
            $this->db->group_end();
        }

        if ($p_min != "") {
            $this->db->where('products.listing_price >=', intval($p_min * 100));
        }
        if ($p_max != "") {
            $this->db->where('products.listing_price <=', intval($p_max * 100));
        }

        //search words
        if (!empty($array_search_words)) {
            $this->db->join('product_details', 'product_details.product_id = products.id');
            $this->db->where('product_details.lang_id', clean_number($this->selected_lang->id));
            $this->db->group_start();
            foreach ($array_search_words as $word) {
                // $user_id=get_user_by_shop_name($word);
                if (!empty($word)) {
                    // $this->db->or_like(array('product_details.title' => $word, 'product_details.description' => $word,'product_details.seo_keywords' => $word,'product_details.seo_title' => $word));


                    $this->db->group_start();
                    $this->db->like('product_details.title', $word);
                    // $this->db->or_like('product_details.description', $word);
                    $this->db->or_like('product_details.seo_title', $word);
                    $this->db->or_like('product_details.seo_keywords', $word);
                    //$this->db->or_like('product_details.user_id', );
                    $this->db->or_like('shop_name', $word);
                    $this->db->or_like('brand_name', $word);

                    $this->db->group_end();
                }
            }
            $this->db->group_end();
            // $this->db->order_by('products.is_promoted', 'DESC');
        }

        //food preference filter
        if (!empty($array_food_preference)) {
            $this->db->group_start();
            foreach ($array_food_preference as $food) {
                if (!empty($food)) {
                    if ($food == "Gluten_Free") {
                        $this->db->where('products.is_gluten_free', 'Y');
                    } else if ($food == "Organic") {
                        $this->db->where('products.is_organic', 'Y');
                    } else if ($food == "Vegan") {
                        $this->db->where('products.is_vegan', 'Y');
                    } else if ($food == "Sustainable") {
                        $this->db->where('products.is_sustainable', 'Y');
                    }
                }
            }
            $this->db->group_end();
        }


        //Gender
        $category_ids_1 = array();
        $category_ids_2 = array();
        $category_ids_3 = array();
        $category_ids_4 = array();

        if (!empty($gender)) {
            $this->db->reset_query();
            if ($gender == "Men") {
                $categories_1 = $this->category_model->get_subcategories_tree(9, false);
                $category_ids_1 = get_ids_from_array($categories_1);
                $this->db->where_in("products.category_id", $category_ids_1);
            } else if ($gender == "Women") {
                $categories_2 = $this->category_model->get_subcategories_tree(10, false);
                $category_ids_2 = get_ids_from_array($categories_2);
                $this->db->where_in("products.category_id", $category_ids_2);
            } else if ($gender == "Kids_Boys") {
                $categories_3 = $this->category_model->get_subcategories_tree(381, false);
                $category_ids_3 = get_ids_from_array($categories_3);
                $this->db->where_in("products.category_id", $category_ids_3);
            } else if ($gender == "Kids_Girls") {
                $categories_4 = $this->category_model->get_subcategories_tree(382, false);

                $category_ids_4 = get_ids_from_array($categories_4);
                $this->db->where_in("products.category_id", $category_ids_4);
            }
            if (!$only_category) :
                $this->build_query();
            else :
                $this->build_query("active", false, true);
            endif;
        }


        //sort products
        if (!empty($sort) && $sort == "lowest_price") {
            $this->db->order_by('products.listing_price');
        } elseif (!empty($sort) && $sort == "highest_price") {
            $this->db->order_by('products.listing_price', 'DESC');
        } elseif (!empty($sort) && $sort == "oldest_first") {
            $this->db->order_by('products.created_at', 'ASC');
        } elseif (!empty($sort) && $sort == "top_discount") {
            $this->db->order_by('cast(products.discount_rate as decimal(16,2)) DESC');
        } else {
            // $this->db->order_by('rand()');
            $this->db->order_by('rand_val');
        }
    }

    //search products (AJAX search)
    public function search_products($search)
    {
        if (!empty($search)) {
            $array = explode(' ', $search);
            $str = "";
            $array_like = array();
            $this->build_query();

            $this->db->join('product_details', 'product_details.product_id = products.id');
            $this->db->where('product_details.lang_id', clean_number($this->selected_lang->id));
            $this->db->group_start();
            foreach ($array as $item) {
                if (strlen($item) > 1) {
                    $this->db->like('product_details.title', $item);
                    // $this->db->or_like('shop_name', clean_str($item));
                    $this->db->or_like('brand_name', $item);
                }
            }
            $this->db->group_end();
            $this->db->order_by('products.is_promoted', 'DESC')->limit(5);
            $query = $this->db->get('products');
            return $query->result();
        }
        return array();
    }




    public function save_search_keyword($search)
    {

        if (!empty($search)) {
            $array = explode(' ', $search);
            $user_id = $this->auth_user->id;
            if (!empty($user_id)) {

                // $sql = "SELECT count(search_text) FROM search_keyword where search_text like   '$search%'   and user_id=$user_id;";
                $sql = "SELECT COUNT(*) as count FROM search_keyword where search_text='$search' AND user_id='$user_id';";
                $query = $this->db->query($sql);
                $count = $query->row();
                // var_dump($count->count);die();
                if ($count->count == 0) {
                    $data = array(
                        'user_id' => $user_id,
                        'search_text' => $search,
                        'created_at' => date('Y-m-d H:i:s')
                    );

                    $this->db->insert('search_keyword', $data);
                }
            }
        }
    }



    //search pincode (AJAX search)
    public function search_pincode($search)
    {
        if (!empty($search)) {
            $array = explode(' ', $search);
            $str = "";
            $array_like = array();

            $this->db->where('pincode', clean_number($this->selected_lang->id));
            $this->db->limit(5);
            $query = $this->db->get('address');
            return $query->result();
        }
        return array();
    }




    //search products (AJAX search)
    public function search_member_products($search)
    {
        if (!empty($search)) {
            $array = explode(' ', $search);
            $str = "";
            $array_like = array();
            $this->build_query();

            $this->db->join('product_details', 'product_details.product_id = products.id');
            $this->db->where('product_details.lang_id', clean_number($this->selected_lang->id));

            $this->db->group_start();
            foreach ($array as $item) {
                if (strlen($item) > 1) {

                    $this->db->like('shop_name', clean_str($item));
                    $this->db->or_like('brand_name', clean_str($item));
                }
            }
            $this->db->group_end();
            // $this->db->where_in('products.user_id', clean_number($this->selected_lang->id));

            $this->db->order_by('products.is_promoted', 'DESC')->limit(10);
            $query = $this->db->get('products');
            // var_dump($query->result());
            // die();
            return $query->result();
        }
        return array();
    }

    //search products (AJAX search)
    //   public function search_member_products($search)
    //   {

    //     if (!empty($search)) {
    //               $array = explode(' ', $search);
    //               $str = "";
    //               $array_like = array();
    //               $this->build_query();

    //     //   if (!empty($search)) {
    //     //       $array = explode(' ', $search);
    //     //       $str = "";
    //     //       $array_like = array();
    //     //       $this->build_query();
    //     //       $this->db->join('users', 'products.user_id = users.id');
    //     //       $this->db->join('product_details', 'product_details.product_id = products.id');
    //     //       $this->db->where('product_details.lang_id', clean_number($this->selected_lang->id));
    //     //       $this->db->where('`user_id`  IN (SELECT `id` FROM `users` where )', NULL, FALSE);
    //     //       $this->db->group_start();
    //     //       foreach ($array as $item) {
    //     //           if (strlen($item) > 1) {
    //     //               $this->db->like('product_details.title', clean_str($item));
    //     //           }
    //     //       }
    //     //       $this->db->group_end();
    //     //       $this->db->order_by('products.is_promoted', 'DESC')->limit(10);
    //     //       $query = $this->db->get('products');
    //     //       return $query->result();
    //     //   }
    //     //   return array();
    //   }
    //get products
    public function get_products()
    {
        $this->build_query();
        // $this->db->order_by('rand()');
        $this->db->order_by('rand_val');
        $query = $this->db->get('products');
        return $query->result();
    }

    public function get_products_all()
    {
        $sql = "SELECT * from products";
        $query = $this->db->query($sql, "1389");
        return $query->result();
    }
    //get limited products
    public function get_products_limited($limit)
    {
        $this->build_query();
        $this->db->limit(clean_number($limit));
        // $this->db->order_by('rand()')->limit(clean_number($limit));
        $this->db->order_by('rand_val')->limit(clean_number($limit));
        $query = $this->db->get('products');
        return $query->result();
    }

    public function get_promoted_products_banner()
    {
        $this->build_query();
        $this->db->where('products.is_promoted', 1);
        // $this->db->order_by('rand()');
        $this->db->order_by('rand_val');
        return $this->db->get('products')->result();
    }

    //get promoted products
    public function get_promoted_products()
    {
        $this->build_query('promoted');
        $this->db->select("(SELECT COUNT(id) FROM products) AS num_rows");
        // $this->db->order_by('rand()');
        $this->db->order_by('rand_val');
        return $this->db->get('products')->result();
    }
    public function get_sale_count($product_id)
    {
        $this->db->where('product_id', $product_id);
        $num_rows = $this->db->count_all_results('order_products');
        return $num_rows;
    }

    public function get_sale_count_as_per_incomplete_status($product_id)
    {
        $order_status = array('processing', 'waiting');
        $this->db->select_sum('product_quantity');
        $this->db->where('product_id', $product_id);
        $this->db->where_in('order_status', $order_status);
        $result =  $this->db->get('order_products');
        return (int)$result->row()->product_quantity;
    }

    public function get_sale_count_as_per_status($product_id, $order_status)
    {

        $this->db->select_sum('product_quantity');
        $this->db->where('product_id', $product_id);
        $this->db->where('order_status', $order_status);
        $result =  $this->db->get('order_products');
        return (int)$result->row()->product_quantity;
    }
    public function get_sale_count_as_per_status_and_user($user_id, $product_id, $order_status)
    {

        $where = "(product_id=" . $product_id . " OR user_id=" . $user_id . ") AND order_status='waiting'";
        $this->db->where($where);
        $num_rows = $this->db->count_all_results('order_products');
        return $num_rows;
    }

    public function get_product_id_by_seller_id($user_id, $order_status)
    {
        $this->db->where("seller_id", $user_id);
        $this->db->where("order_status", $order_status);
        $result = $this->db->get('order_products')->result();
        return $result;
    }

    public function update_stock($id, $stock)
    {
        $data['stock'] = $stock;
        $this->db->where('id', $id);
        $this->db->update('products', $data);
    }

    //get promoted products
    public function get_promoted_products_limited($per_page, $offset)
    {
        $this->build_query('promoted');
        $this->db->order_by('products.promote_start_date', 'DESC')->limit(clean_number($per_page), clean_number($offset));
        $query = $this->db->get('products');
        return $query->result();
    }

    //get promoted products count
    public function get_promoted_products_count()
    {
        $this->build_query('promoted');
        return $this->db->count_all_results('products');
    }

    //check promoted products
    public function check_promoted_products()
    {
        $this->db->where('is_promoted', 1);
        $products = $this->db->get('products')->result();
        if (!empty($products)) {
            foreach ($products as $item) {
                if (date_difference($item->promote_end_date, date('Y-m-d H:i:s')) < 1) {
                    $data = array(
                        'is_promoted' => 0,
                    );
                    $this->db->where('id', $item->id);
                    $this->db->update('products', $data);
                }
            }
        }
    }

    //get special offers
    public function get_special_offers()
    {
        $this->build_query();
        $this->db->where('products.is_special_offer', 1);
        $this->db->order_by('products.special_offer_date', 'DESC');
        return $this->db->get('products')->result();
    }

    //get index categories products
    public function get_index_categories_products($categories)
    {
        $category_ids = array();
        if (!empty($categories)) {
            $category_ids = get_array_column_values($categories, 'id');
        }
        if (!empty($category_ids) && item_count($category_ids) > 0) {
            $this->build_query();
            $this->db->where_in('products.category_id', $category_ids, FALSE);
            // $this->db->order_by('rand()');
            $this->db->order_by('rand_val');
            return $this->db->get('products')->result();
        }
        return array();
    }

    //get paginated filtered products
    public function get_paginated_filtered_products($query_string_array = null, $category_id = null, $per_page, $offset, $only_category = false)
    {
        $this->filter_products($query_string_array, $category_id, $only_category);
        if (!$only_category) :
            $this->db->limit(clean_number($per_page), clean_number($offset));
            return $this->db->get('products')->result();
        else :
            return $this->db->get('products')->result_array();
        endif;
    }

    //get paginated filtered products by seller
    public function get_products_by_seller($query_string_array = null, $category_id = null, $per_page, $offset, $type)
    {
        $this->filter_products($query_string_array, $category_id);
        $this->db->limit(clean_number($per_page), clean_number($offset));
        if (!empty($type)) {
            $this->db->where('user_id', $type);
        }

        return $this->db->get('products')->result();
    }

    //get paginated filtered products by category
    public function get_products_by_category($query_string_array = null, $category_id = null, $per_page, $offset, $type)
    {
        $this->filter_products($query_string_array, $category_id);
        $this->db->limit(clean_number($per_page), clean_number($offset));
        if (!empty($type)) {
            $this->db->where('category_id', $type);
        }
        // $this->db->order_by('rand()');
        $this->db->order_by('rand_val');
        return $this->db->get('products')->result();
    }

    //get paginated filtered products by concern
    public function get_products_shop_by_concern($query_string_array = null, $category_id = null, $per_page, $offset, $type, $only_category = false)
    {
        if (!$only_category) :
            $this->filter_products($query_string_array, $category_id);
        else :
            $this->filter_products($query_string_array, $category_id, $only_category);
        endif;

        $this->db->limit(clean_number($per_page), clean_number($offset));
        $this->db->join('category_feature', 'products.category_id=category_feature.category_id');
        // $this->db->where('category_feature.grp_feature_id',7);
        if (!empty($type)) {
            $tags = "SELECT tag_id FROM category_feature WHERE feature_id=$type AND tag_id is not null";
            $query = $this->db->query($tags)->result();
            if (!empty($query)) {
                $this->db->group_start();
                $this->db->where('category_feature.feature_id', $type);
                foreach ($query as $tag) {
                    $tag_name = $this->get_category_name_from_tag($tag->tag_id);
                    if ($tag_name->lookup_code == 'DESSERTS') {
                        $this->db->or_where('products.is_appetisers_main_course_beverages_desserts', 'Desserts');
                    } else if ($tag_name->lookup_code == 'SUSTAINABLE') {
                        $this->db->or_where('products.is_sustainable', 'Y');
                    } else if ($tag_name->lookup_code == 'ORGANIC') {
                        $this->db->or_where('products.is_organic', 'Y');
                    } else if ($tag_name->lookup_code == 'GLUTEN_FREE') {
                        $this->db->or_where('products.is_gluten_Free', 'Y');
                    } else if ($tag_name->lookup_code == 'VEGAN') {
                        $this->db->or_where('products.is_vegan', 'Y');
                    }
                }
                $this->db->group_end();
            }
            // if ($type == 24) {
            //     $this->db->group_start();
            //     $this->db->where('category_feature.feature_id', $type);
            //     $this->db->where('products.is_gluten_Free', 'Y');
            //     $this->db->or_where('products.is_vegan', 'Y');
            //     $this->db->group_end();
            // } 
            else {
                $this->db->where('category_feature.feature_id', $type);
            }
        }
        $this->db->distinct();

        if (!$only_category) :
            return $this->db->get('products')->result();
        else :
            return $this->db->get('products')->result_array();
        endif;
    }

    //get top picks products
    public function get_top_pick_products($query_string_array = null, $category_id = null, $per_page, $offset, $type)
    {
        $this->filter_products($query_string_array, $category_id);
        $this->db->limit(clean_number($per_page), clean_number($offset));
        $this->db->order_by('products.is_promoted', 'RANDOM');
        $this->db->join('category_feature', 'products.category_id=category_feature.category_id');
        $this->db->where('category_feature.feature_id', $type);
        $this->db->or_where('products.is_promoted', 1);
        $this->db->group_by('products.id');
        return $this->db->get('products')->result();
    }

    public function get_category_products($type_code)
    {
        if (!empty($type_code)) {
            $type = $this->lookup_model->get_lookup_values_by_code($type_code);
            $this->build_query();
            $this->db->order_by('products.is_promoted', 'DESC');
            $this->db->join('category_feature', 'products.category_id=category_feature.category_id');
            $this->db->where('category_feature.feature_id', $type->id);
            $this->db->or_where('products.is_promoted', 1);
            $this->db->group_by('products.id')->limit(10);
            return $this->db->get('products')->result();
        }
    }

    public function get_products_tags($type)
    {
        $sql = "SELECT meaning FROM lookup_values WHERE id=?";
        $query = $this->db->query($sql, $type);
        return $query->result();
    }

    //get paginated filtered products count
    public function get_paginated_filtered_products_count($query_string_array = null, $category_id = null)
    {

        $this->filter_products($query_string_array, $category_id);
        // var_dump($this->db->count_all_results('products'));

        return $this->db->count_all_results('products');
    }

    //get paginated filtered products count as per seller
    public function get_paginated_filtered_products_by_seller($query_string_array = null, $category_id = null, $type_id)
    {
        $this->filter_products($query_string_array, $category_id);
        $this->db->where('user_id', $type_id);
        return $this->db->count_all_results('products');
    }

    //get paginated filtered products count as per category
    public function get_paginated_filtered_products_by_category($query_string_array = null, $category_id = null, $type_id)
    {
        $this->filter_products($query_string_array, $category_id);
        $this->db->where('category_id', $type_id);
        return $this->db->count_all_results('products');
    }

    public function get_paginated_filtered_products_count_category_feature($query_string_array = null, $category_id = null, $type)
    {

        $this->filter_products($query_string_array, $category_id);
        $this->db->order_by('products.is_promoted', 'DESC');
        $this->db->join('category_feature', 'products.category_id=category_feature.category_id');
        if (!empty($type)) {
            $tags = "SELECT tag_id FROM category_feature WHERE feature_id=$type AND tag_id is not null";
            $query = $this->db->query($tags)->result();
            if (!empty($query)) {
                $this->db->group_start();
                $this->db->where('category_feature.feature_id', $type);
                foreach ($query as $tag) {
                    $tag_name = $this->get_category_name_from_tag($tag->tag_id);
                    if ($tag_name->lookup_code == 'DESSERTS') {
                        $this->db->or_where('products.is_appetisers_main_course_beverages_desserts', 'Desserts');
                    } else if ($tag_name->lookup_code == 'SUSTAINABLE') {
                        $this->db->or_where('products.is_sustainable', 'Y');
                    } else if ($tag_name->lookup_code == 'ORGANIC') {
                        $this->db->or_where('products.is_organic', 'Y');
                    } else if ($tag_name->lookup_code == 'GLUTEN_FREE') {
                        $this->db->or_where('products.is_gluten_Free', 'Y');
                    } else if ($tag_name->lookup_code == 'VEGAN') {
                        $this->db->or_where('products.is_vegan', 'Y');
                    }
                }
                $this->db->group_end();
            } else {
                $this->db->where('category_feature.feature_id', $type);
            }
        }
        $this->db->distinct();
        return $this->db->get('products')->num_rows();
    }

    //get products count by category
    public function get_products_count_by_category($category_id)
    {
        return $this->db->where('products.category_id', clean_number($category_id))->count_all_results('products');
    }

    //get related products
    public function get_related_products($product_id, $category_id, $parent_categories_tree)
    {
        $this->build_query();
        return $this->db->where('products.category_id', clean_number($category_id))->where('products.id !=', clean_number($product_id))->limit(5)->get('products')->result();
    }

    //get user products
    public function get_user_products($user_id, $product_id)
    {
        $this->build_query();
        $this->db->where('users.id', clean_number($user_id));
        $this->db->where('products.id != ', clean_number($product_id));
        $this->db->order_by('products.created_at', 'DESC')->limit(10);
        return $this->db->get('products')->result();
    }


    public function get_user_products_by_user_id($user_id)
    {
        $this->build_query();
        $this->db->where('users.id', clean_number($user_id));

        $this->db->order_by('products.created_at', 'DESC')->limit(10);
        return $this->db->get('products')->result();
    }

    //filter related functions
    public function get_filtervalues_by_filterid($filter_id)
    {

        $this->db->where('filter_values.filter_id', clean_number($filter_id));
        return $this->db->get('filter_values')->result();
    }

    public function get_filtervalues_by_filterid_filtergroupid($filter_id, $filter_group_id)
    {

        $this->db->where('filter_values.filter_id', clean_number($filter_id));

        $this->db->where('filter_values.filter_group_id', clean_number($filter_group_id));
        return $this->db->get('filter_values')->result();
    }
    public function get_filter_group_by_filter_id($filter_id)
    {
        $this->db->where('filter_group.filter_id', clean_number($filter_id));

        return $this->db->get('filter_group')->result();
    }
    public function get_filters()
    {
        return $this->db->get('filters')->result();
    }
    public function get_filters_by_id($filter_id)
    {
        $this->db->where('filters.id', clean_number($filter_id));
        return $this->db->get('filters')->row();
    }



    public function get_catg_filter()
    {
        return $this->db->get('catg_filter')->result();
    }

    public function get_filter_id_by_cat_id($category_id)
    {
        $this->db->where('catg_filter.category_id', clean_number($category_id));

        return $this->db->get('catg_filter')->result();
    }




    public function get_user_products_by_user_id_pageview($user_id)
    {
        $this->build_query();
        $this->db->where('products.user_id', $user_id);
        $this->db->where('products.is_deleted', 0);
        $this->db->where('products.is_draft', 0);
        $this->db->order_by('products.pageviews', 'DESC')->limit(10);
        return $this->db->get('products')->result();
    }

    public function get_products_by_pageview()
    {
        $this->build_query();
        $this->db->where('products.is_deleted', 0);
        $this->db->where('products.is_draft', 0);
        $this->db->order_by('products.pageviews', 'DESC')->limit(10);
        return $this->db->get('products')->result();
    }

    //get user products
    public function get_user_barter_products($user_id)
    {
        $this->build_query();
        $this->db->where('products.user_id', $user_id);
        $this->db->where('products.available_for_barter', 'Y');
        $this->db->order_by('products.created_at', 'DESC');
        return $this->db->get('products')->result();
    }
    //get user products count
    public function get_user_barter_products_count($user_id, $list_type = 'active')
    {
        $this->filter_user_products($list_type);
        $this->db->where('users.id', clean_number($user_id));
        $this->db->where('products.available_for_barter', 'Y');
        return $this->db->count_all_results('products');
    }

    public function get_product_price($id)
    {
        $this->build_query();
        $this->db->select('products.price');
        $this->db->where('products.id', $id);
        $query = $this->db->get('products');
        return $query->row();
    }
    public function get_product_listing_price($id)
    {
        $this->build_query();
        $this->db->select('products.listing_price');
        $this->db->where('products.id', $id);
        $query = $this->db->get('products');
        return $query->row();
    }
    //get paginated user products
    public function get_paginated_user_products($user_id, $list_type, $per_page, $offset)
    {
        $this->filter_user_products($list_type);
        $this->db->where('users.id', clean_number($user_id));
        $this->db->order_by('products.created_at', 'DESC')->limit($per_page, $offset);
        $query = $this->db->get('products');
        return $query->result();
    }

    //function to fetch new products of user for sort-whats new
    public function get_new_products_of_user($user_id, $list_type)
    {
        $this->filter_user_products($list_type);
        $this->db->where('user_id', clean_number($user_id));
        $this->db->order_by('products.created_at', 'DESC');
        $query = $this->db->get('products');
        return $query->result();
    }

    //get paginated user products
    // public function get_paginated_user_products_limited($user_id, $list_type)
    // {
    //     $this->filter_user_products($list_type);
    //     $this->db->where('users.id', clean_number($user_id));
    //     $this->db->order_by('products.created_at', 'DESC')->limit(10);
    //     $query = $this->db->get('products');
    //     return $query->result();
    // }

    //discount rate descending order
    public function get_better_discount_products($user_id, $list_type)
    {
        $this->filter_user_products($list_type);
        $this->db->where('users.id', clean_number($user_id));
        $this->db->order_by('cast(products.discount_rate as decimal)', 'DESC');
        $query = $this->db->get('products');
        return $query->result();
    }

    public function avaiable_now($user_id, $list_type)
    {
        $this->filter_user_products($list_type);
        $this->db->where('users.id', clean_number($user_id));
        $this->db->where('products.stock !=', 0);
        $this->db->order_by('products.created_at', 'DESC');
        $query = $this->db->get('products');
        return $query->result();
    }

    //price ascending order
    public function get_price_low_to_high($user_id, $list_type)
    {
        $this->filter_user_products($list_type);
        $this->db->where('users.id', clean_number($user_id));
        $this->db->order_by('products.listing_price', 'ASC');
        $query = $this->db->get('products');
        return $query->result();
    }

    //price descending order
    public function get_price_high_to_low($user_id, $list_type)
    {
        $this->filter_user_products($list_type);
        $this->db->where('users.id', clean_number($user_id));
        $this->db->order_by('products.listing_price', 'DESC');
        $query = $this->db->get('products');
        return $query->result();
    }

    //get paginated user products
    public function get_paginated_barter_user_products($user_id, $list_type, $per_page, $offset)
    {
        $this->filter_user_products($list_type);
        $this->db->where('users.id', clean_number($user_id));
        $this->db->where('products.available_for_barter', 'Y');
        $this->db->order_by('products.created_at', 'DESC')->limit($per_page, $offset);
        $query = $this->db->get('products');
        return $query->result();
    }

    //get user products count
    public function get_user_products_count($user_id, $list_type = 'active')
    {
        $this->filter_user_products($list_type);
        $this->db->where('users.id', clean_number($user_id));
        $this->db->where('products.is_service', "0");
        return $this->db->count_all_results('products');
    }
    //get avg transaction
    public function get_avg_transation($user_id, $list_type = 'active')
    {
        $this->filter_user_products($list_type);
        $this->db->where('seller_id', clean_number($user_id));
        $this->db->where('products.is_service', "0");
        return $this->db->count_all_results('order_products');
    }

    public function get_user_services_count($user_id, $list_type = 'active')
    {
        $this->filter_user_products($list_type);
        $this->db->where('users.id', clean_number($user_id));
        $this->db->where('products.is_service', "1");
        return $this->db->count_all_results('products');
    }

    //filter user products
    public function filter_user_products($list_type)
    {
        $product_type = input_get('product_type');
        $category = clean_number(input_get('category'));
        $subcategory = clean_number(input_get('subcategory'));
        $stock = input_get('stock');
        $q = input_get('q');

        $category_ids = array();
        $category_id = $category;
        if (!empty($subcategory)) {
            $category_id = $subcategory;
        }
        if (!empty($category_id)) {
            $categories = $this->category_model->get_subcategories_tree($category_id, false);
            $category_ids = get_ids_from_array($categories);
        }

        if ($list_type == "pending") {
            $this->build_query('pending', false, false);
        } elseif ($list_type == "draft") {
            $this->build_query('draft', false, false);
        } elseif ($list_type == "hidden") {
            $this->build_query('hidden', false, false);
        } elseif ($list_type == "expired") {
            $this->build_query('expired', false, false);
        } else {
            $this->build_query('active', false, false);
        }

        if ($product_type == "physical" || $product_type == "digital") {
            $this->db->where('products.product_type', $product_type);
        }
        if (!empty($category_ids)) {
            $this->db->where_in("products.category_id", $category_ids, FALSE);
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
        if (!empty($q)) {
            $this->db->join('product_details', 'product_details.product_id = products.id');
            $this->db->where('product_details.lang_id', $this->selected_lang->id);
            $this->db->group_start();
            $this->db->like('product_details.title', $q);
            $this->db->or_like('products.sku', $q);
            $this->db->or_like('products.promote_plan', $q);
            $this->db->group_end();
        }
    }

    //get user wishlist products
    public function get_paginated_user_wishlist_products($user_id, $per_page, $offset)
    {
        $this->build_query('wishlist');
        $this->db->where('wishlist.user_id', clean_number($user_id));
        $this->db->where('is_active', 1);
        // $this->db->order_by('rand()')->limit(clean_number($per_page), clean_number($offset));
        // $this->db->limit(clean_number($per_page), clean_number($offset));
        $this->db->order_by('rand_val')->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('products')->result();
    }

    //get user wishlist products count
    public function get_user_wishlist_products_count($user_id)
    {
        $this->build_query('wishlist');
        $this->db->where('wishlist.user_id', clean_number($user_id));
        $this->db->where('is_active', 1);
        return $this->db->count_all_results('products');
    }


    public function get_user_wishlist_products($user_id)
    {
        $this->build_query('wishlist');
        $this->db->where('wishlist.user_id', clean_number($user_id));
        $this->db->where('is_active', 1);
        return $this->db->get('products')->result();
    }


    //get guest wishlist products
    public function get_paginated_guest_wishlist_products($per_page, $offset)
    {
        $wishlist = $this->session->userdata('mds_guest_wishlist');
        if (!empty($wishlist) && item_count($wishlist) > 0) {
            $this->build_query();
            $this->db->where_in('products.id', $wishlist, FALSE);
            $this->db->order_by('products.created_at', 'DESC')->limit(clean_number($per_page), clean_number($offset));
            return $this->db->get('products')->result();
        }
        return array();
    }

    //get guest wishlist products count
    public function get_guest_wishlist_products_count()
    {
        $wishlist = $this->session->userdata('mds_guest_wishlist');
        if (!empty($wishlist) && item_count($wishlist) > 0) {
            $this->build_query();
            $this->db->where_in('products.id', $wishlist, FALSE);
            return $this->db->count_all_results('products');
        }
        return 0;
    }

    //get paginated downloads
    public function get_paginated_user_downloads($user_id, $per_page, $offset)
    {
        $this->db->where('buyer_id', clean_number($user_id));
        $this->db->order_by('purchase_date', 'DESC')->limit($per_page, $offset);
        return $this->db->get('digital_sales')->result();
    }

    public function get_barter_product_of_current_user()
    {
        $this->build_query();
        $this->db->where('products.available_for_barter', 'Y');
        $this->db->where('products.user_id', $this->auth_user->id);
        $query = $this->db->get('products');
        return $query->result();
    }


    //get user downloads count
    public function get_user_downloads_count($user_id)
    {
        $this->db->where('buyer_id', clean_number($user_id));
        return $this->db->count_all_results('digital_sales');
    }

    //get digital sale
    public function get_digital_sale($sale_id)
    {
        $this->db->where('id', clean_number($sale_id));
        return $this->db->get('digital_sales')->row();
    }

    //get digital sale by buyer id
    public function get_digital_sale_by_buyer_id($buyer_id, $product_id)
    {
        $this->db->where('buyer_id', clean_number($buyer_id));
        $this->db->where('product_id', clean_number($product_id));
        return $this->db->get('digital_sales')->row();
    }

    //get digital sale by order id
    public function get_digital_sale_by_order_id($buyer_id, $product_id, $order_id)
    {
        $this->db->where('buyer_id', clean_number($buyer_id));
        $this->db->where('product_id', clean_number($product_id));
        $this->db->where('order_id', clean_number($order_id));
        return $this->db->get('digital_sales')->row();
    }

    public function get_shiprocket_order_details($order_id, $product_id)
    {
        $this->db->where('order_id', clean_number($order_id));
        $this->db->where('product_id', clean_number($product_id));
        $this->db->where('is_active', 1);
        return $this->db->get('shiprocket_order_details')->row();
    }

    //get product by id
    public function get_product_by_id($id)
    {
        $this->db->where('id', clean_number($id));
        return $this->db->get('products')->row();
    }

    //add to cart withou auth
    public function add_to_cart_without_auth($data)
    {
        return $this->db->insert('add_to_cart', $data);
    }
    //get available product
    public function get_active_product($id)
    {
        $this->build_query();
        $this->db->where('products.id', $id);
        $product_data = $this->db->get('products')->row();
        if (!empty($product_data))
            $product_data->deliverable = 1;
        if (!empty($_SESSION["modesy_sess_user_location"])) {
            if (!empty($product_data)) {
                return $product_data;
            } else {
                $this->build_query_without_pin();
                $this->db->where('products.id', $id);
                $product_data = $this->db->get('products')->row();
                if (!empty($product_data))
                    $product_data->deliverable = 0;
                return $product_data;
            }
        } else {
            return $product_data;
        }
    }

    //get available product
    public function get_active_product_without_pin($id)
    {
        $this->build_query_without_pin();
        $this->db->where('products.id', $id);
        // $this->db->get('products')->row();
        // echo $this->db->last_query();
        // die();
        return $this->db->get('products')->row();
    }

    //get product by slug
    public function get_product_by_slug($slug)
    {
        if ($this->general_settings->membership_plans_system == 1) {
            $this->db->join('users', 'products.user_id = users.id AND users.banned = 0 AND users.is_membership_plan_expired = 0');
        } else {
            $this->db->join('users', 'products.user_id = users.id AND users.banned = 0');
        }
        $this->db->select('products.*, users.username as user_username, users.shop_name as shop_name,users.brand_name as brand_name, users.role as user_role, users.slug as user_slug');
        $this->db->where('products.slug', clean_slug($slug))->where('products.is_deleted', 0);
        if ($this->general_settings->vendor_verification_system == 1) {
            $this->db->where('users.role != ', 'member');
        }
        return $this->db->get('products')->row();
    }

    //get product details
    public function get_product_details($id, $lang_id, $get_main_on_null = true)
    {
        $this->db->where('product_details.product_id', clean_number($id))->where('product_details.lang_id', clean_number($lang_id));
        $row = $this->db->get('product_details')->row();
        if ((empty($row) || empty($row->title)) && $get_main_on_null == true) {
            $this->db->where('product_details.product_id', clean_number($id))->limit(1);
            $row = $this->db->get('product_details')->row();
        }
        return $row;
    }

    //get service details
    public function get_service_details($id, $lang_id, $get_main_on_null = true)
    {
        $this->db->where('product_details.product_id', clean_number($id))->where('product_details.lang_id', clean_number($lang_id));
        $row = $this->db->get('product_details')->row();
        if ((empty($row) || empty($row->title)) && $get_main_on_null == true) {
            $this->db->where('product_details.product_id', clean_number($id))->limit(1);
            $row = $this->db->get('product_details')->row();
        }
        return $row;
    }

    public function get_product_details_by_id($id)
    {
        $id = clean_number($id);
        $this->db->where('product_id', $id);

        $query = $this->db->get('product_details');
        return $query->row();
    }

    //is product in wishlist
    public function is_product_in_wishlist($product_id)
    {
        if ($this->auth_check) {
            $this->db->where('user_id', $this->auth_user->id)->where('product_id', clean_number($product_id))->where('is_active', '1');
            $query = $this->db->get('wishlist');
            if (!empty($query->row())) {
                return true;
            }
        } else {
            $wishlist = $this->session->userdata('mds_guest_wishlist');
            if (!empty($wishlist)) {
                if (in_array($product_id, $wishlist)) {
                    return true;
                }
            }
        }
        return false;
    }

    //get product wishlist count
    public function get_product_wishlist_count($product_id)
    {
        $this->db->where('product_id', clean_number($product_id));
        return $this->db->count_all_results('wishlist');
    }

    //add remove wishlist
    public function add_remove_wishlist($product_id)
    {
        if ($this->auth_check) {
            if ($this->is_product_in_wishlist($product_id)) {
                $this->db->where('user_id', $this->auth_user->id);
                $this->db->where('product_id', clean_number($product_id));
                // $this->db->delete('wishlist');
                $data = array(
                    'user_id' => $this->auth_user->id,
                    'product_id' => clean_number($product_id),
                    'is_active' => 0,
                );
                $this->db->update('wishlist', $data);
                return json_encode($data);
            } else {
                $data = array(
                    'user_id' => $this->auth_user->id,
                    'product_id' => clean_number($product_id),
                    'is_active' => 1
                );
                $this->db->insert('wishlist', $data);
                return json_encode($data);
            }
        } else {
            if ($this->is_product_in_wishlist($product_id)) {
                $wishlist = array();
                if (!empty($this->session->userdata('mds_guest_wishlist'))) {
                    $wishlist = $this->session->userdata('mds_guest_wishlist');
                }
                $new = array();
                if (!empty($wishlist)) {
                    foreach ($wishlist as $item) {
                        if ($item != clean_number($product_id)) {
                            array_push($new, $item);
                        }
                    }
                }
                $this->session->set_userdata('mds_guest_wishlist', $new);
            } else {
                $wishlist = array();
                if (!empty($this->session->userdata('mds_guest_wishlist'))) {
                    $wishlist = $this->session->userdata('mds_guest_wishlist');
                }
                array_push($wishlist, clean_number($product_id));
                $this->session->set_userdata('mds_guest_wishlist', $wishlist);
            }
        }
    }

    //get vendor total pageviews count
    public function get_vendor_total_pageviews_count($user_id)
    {
        $this->db->select('SUM(products.pageviews) as total_pageviews');
        $this->db->where('status', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0)->where('products.user_id', clean_number($user_id));
        $query = $this->db->get('products');
        return $query->row()->total_pageviews;
    }

    //increase product pageviews
    public function increase_product_pageviews($product)
    {
        if (!empty($product)) {
            if (!isset($_COOKIE['modesy_product_' . $product->id])) {
                //increase hit
                setcookie("modesy_product_" . $product->id, '1', time() + (86400 * 300), "/");
                $data = array(
                    'pageviews' => $product->pageviews + 1
                );
                $this->db->where('id', $product->id);
                $this->db->update('products', $data);
            }
        }
    }

    //get related products by category for shop by product section
    public function get_shop_by_product_categories($category_id)
    {
        $categories = $this->category_model->get_subcategories_tree($category_id, true);
        $category_ids = get_ids_from_array($categories);
        if (empty($category_ids) || item_count($category_ids) < 1) {
            return array();
        }
        $this->build_query();
        $this->db->where_in('products.category_id', $category_ids, FALSE);
        $this->db->group_by('products.user_id');
        return $this->db->get('products')->result();
    }

    //get related products by category for top discounts section
    public function get_rss_products_by_category_new($category_id)
    {
        $categories = $this->category_model->get_subcategories_tree($category_id, true);
        $category_ids = get_ids_from_array($categories);
        if (empty($category_ids) || item_count($category_ids) < 1) {
            return array();
        }
        $this->build_query();
        $this->db->where_in('products.category_id', $category_ids, FALSE);
        $this->db->order_by('cast(products.discount_rate as DECIMAL(16,2)) DESC');
        $this->db->group_by('products.user_id');
        return $this->db->get('products')->result();
    }
    public function get_order_id($user_id)
    {

        $this->db->where('buyer_id', $user_id);
        $this->db->where('order_status', 'completed');
        $this->db->order_by('id DESC');
        $this->db->limit(1);
        return $this->db->get('order_products')->row();
    }
    public function get_order_product_id($order_id, $user_id)
    {

        $this->db->where('buyer_id', $user_id);
        $this->db->where('order_id', $order_id);
        $this->db->where('order_status', 'completed');
        return $this->db->get('order_products')->result();
    }
    public function get_rating($product_id, $user_id)
    {
        $this->db->where('product_id', $product_id);
        $this->db->where('user_id', $user_id);
        return $this->db->get('reviews')->row();
    }
    public function get_not_rating_product($product_id, $user_id)
    {
        $sql = "SELECT order_products.id,order_products.product_id,buyer_id from order_products join reviews on order_products.product_id=reviews.product_id and order_products.buyer_id=reviews.user_id where order_products.product_id=$product_id and order_products.buyer_id=$user_id
order by id desc LIMIT 1";
        $query = $this->db->query($sql);
        return $query->result();
    }
    //get related products by category for top discounts section
    public function get_products_by_discount_order()
    {
        $this->build_query();
        $this->db->order_by('cast(products.discount_rate as DECIMAL(16,2)) DESC');
        $this->db->group_by('products.user_id');
        return $this->db->get('products')->result();
    }

    //get rss products by category
    public function get_rss_products_by_category($category_id)
    {
        $categories = $this->category_model->get_subcategories_tree($category_id, true);
        $category_ids = get_ids_from_array($categories);
        if (empty($category_ids) || item_count($category_ids) < 1) {
            return array();
        }
        $this->build_query();
        $this->db->where_in('products.category_id', $category_ids, FALSE);
        // $this->db->order_by('rand()');
        $this->db->order_by('rand_val');
        return $this->db->get('products')->result();
    }

    //get rss products by user
    public function get_rss_products_by_user($user_id)
    {
        $this->build_query();
        $this->db->where('users.id', clean_number($user_id));
        $this->db->order_by('products.created_at', 'DESC');
        return $this->db->get('products')->result();
    }

    //delete product
    public function delete_product($product_id)
    {
        $product = $this->get_product_by_id($product_id);
        //var_dump($product);
        if (!empty($product)) {
            $data = array(
                'is_deleted' => 1
            );
            $this->db->where('id', $product->id);
            return $this->db->update('products', $data);
        }
        return false;
    }

    /*
    *------------------------------------------------------------------------------------------
    * LICENSE KEYS
    *------------------------------------------------------------------------------------------
    */

    //add license keys
    public function add_license_keys($product_id)
    {
        $license_keys = trim($this->input->post('license_keys', true));
        $allow_duplicate = $this->input->post('allow_duplicate', true);

        $license_keys_array = explode(",", $license_keys);
        if (!empty($license_keys_array)) {
            foreach ($license_keys_array as $license_key) {
                $license_key = trim($license_key);
                if (!empty($license_key)) {

                    //check duplicate
                    $add_key = true;
                    if (empty($allow_duplicate)) {
                        $row = $this->check_license_key($product_id, $license_key);
                        if (!empty($row)) {
                            $add_key = false;
                        }
                    }

                    //add license key
                    if ($add_key == true) {
                        $data = array(
                            'product_id' => $product_id,
                            'license_key' => trim($license_key),
                            'is_used' => 0
                        );
                        $this->db->insert('product_license_keys', $data);
                    }
                }
            }
        }
    }

    //get license keys
    public function get_license_keys($product_id)
    {
        $this->db->where('product_id', clean_number($product_id));
        return $this->db->get('product_license_keys')->result();
    }

    //get license key
    public function get_license_key($id)
    {
        $this->db->where('id', clean_number($id));
        return $this->db->get('product_license_keys')->row();
    }

    //get unused license key
    public function get_unused_license_key($product_id)
    {
        $this->db->where('product_id', clean_number($product_id))->where('is_used = 0')->limit(1);
        return $this->db->get('product_license_keys')->row();
    }

    //check license key
    public function check_license_key($product_id, $license_key)
    {
        $this->db->where('product_id', clean_number($product_id))->where('license_key', $license_key);
        return $this->db->get('product_license_keys')->row();
    }

    //set license key used
    public function set_license_key_used($id)
    {
        $data = array(
            'is_used' => 1
        );
        $this->db->where('id', clean_number($id));
        $this->db->update('product_license_keys', $data);
    }

    //delete license key
    public function delete_license_key($id)
    {
        $license_key = $this->get_license_key($id);
        if (!empty($license_key)) {
            $this->db->where('id', $license_key->id);
            return $this->db->delete('product_license_keys');
        }
        return false;
    }
    // public function displayproduct()
    // {
    //     $query = $this->db->query("select (product_details.title) from product_details,products where product_details.product_id=products.id && products.category_id = 17 ");
    //     return $query->result();
    // }
    // public function display()
    // {
    //     $query = $this->db->query("select * from product_details,products,users,order_products,categories where product_details.product_id=products.id && categories.id=products.category_id && order_products.seller_id=users.id");
    //     return $query->result();
    // }
    // public function disp()
    // {
    //     //$query = $this->db->query("select products from product_details INNER JOIN products on product_details.product_id = products.id where products.category_id=17 && products.user_id!=50");
    //     $query = $this->db->query("select products.user_id,products.rating,products.price,product_details.title,products.rating as SRating,product_details.description,product_details.description as PDS_Availability from product_details INNER JOIN products on product_details.product_id = products.id where products.category_id=17 && products.user_id!=50");
    //     return $query->result();
    // }


    public function get_last_record()
    {
        $this->db->select("*");
        $this->db->from("products");
        $this->db->limit(1);
        $this->db->order_by('id', "DESC");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    // get transit time for the home cooks
    public function get_transit_time_for_home_cook($product_id, $lead_days, $lead_time, $order_capacity, $type)
    {
        $count_waiting = get_sale_count_as_per_status($product_id, "waiting");
        $count_processing = get_sale_count_as_per_status($product_id, "processing");
        $count = $count_waiting + $count_processing;

        if (!empty($order_capacity) && $order_capacity != 0) {
            $order_capacity_int = (int)$order_capacity;

            $days_passed = intval($count / $order_capacity_int);

            $days_passed_in_sec = strtotime($days_passed . ' day ', 0);

            $lead_time_in_sec =  strtotime($lead_days . ' day ' . $lead_time . ' hour', 0);


            if ($days_passed_in_sec > 0) {
                $total_transit_time = $days_passed_in_sec + $lead_time_in_sec;
            } else {
                $total_transit_time = $lead_time_in_sec;
            }

            if ($type == "time")
                return $total_transit_time;
            elseif ($type == "string") {
                $dtF = new \DateTime('@0');
                $dtT = new \DateTime("@$total_transit_time");
                return $dtF->diff($dtT)->format('%a days %h hours');
            }
        } else {
            return 0;
        }
    }

    // get transit time for the home cooks
    public function get_transit_time_for_made_to_order($product_id, $user_id, $lead_days, $lead_time, $type)
    {
        $product_waiting = get_product_id_by_seller_id($user_id, "waiting");

        $product_processing = get_product_id_by_seller_id($user_id, "processing");

        $total_lead_time_in_sec = 0;
        foreach ($product_waiting as $order_product) {
            $product_details = get_product($order_product->product_id);
            if ($product_details->add_meet == "Made to order") {
                $total_lead_time_in_sec += strtotime($product_details->lead_days . ' day ' . $product_details->lead_time . ' hour', 0);
                $i = 1;
                while ($order_product->product_quantity > $i) {
                    $total_lead_time_in_sec += $total_lead_time_in_sec;
                    $i++;
                }
                // $total_lead_time_in_sec += $total_lead_time_in_sec * $order_product->product_quantity;
            }
        }

        $lead_time_selected_product =  strtotime($lead_days . ' day ' . $lead_time . ' hour', 0);

        $total_transit_time = $total_lead_time_in_sec + $lead_time_selected_product;
        if ($type == "time")
            return $total_transit_time;
        elseif ($type == "string") {
            $dtF = new \DateTime('@0');
            $dtT = new \DateTime("@$total_transit_time");
            return $dtF->diff($dtT)->format('%a days %h hours');
        }
    }
    //get product category and user_id using product_id
    public function get_product_category($product_id)
    {
        $data = array(
            'product_id' => $product_id
        );
        $query = $this->db->query("SELECT category_id,user_id from products where id=$product_id");
        return $query->result();
    }

    //will show products from different sellers using product category_id 
    public function get_different_product($product_id)
    {
        $category_id = $this->product_model->get_product_category($product_id);
        $ctg = reset($category_id)->category_id;
        $user = reset($category_id)->user_id;
        $data = array(
            'product_id' => $product_id,
        );
        $this->build_query();
        $this->db->where('users.id!=', clean_number($user));
        $this->db->where('products.id != ', clean_number($product_id));
        $this->db->where('products.category_id = ', clean_number($ctg));
        // $this->db->order_by('rand()')->limit(10);
        //$this->db->limit(10);
        $this->db->order_by('rand_val')->limit(10);
        return $this->db->get('products')->result();
    }

    //get add_meet column for a particular product with product id
    public function get_made_to_order($product_id)
    {
        $data = array(
            'product_id' => $product_id
        );
        $query = $this->db->query("SELECT add_meet from products where id=$product_id");
        return $query->result();
    }

    //get product category and user_id using product_id
    public function get_product_shipping_days($shipping)
    {
        $query = $this->db->query("SELECT lookup_int_val from lookup_values where meaning='$shipping'");
        return $query->row();
    }

    //get seller shop's status
    public function get_user_shop_status($user_id)
    {
        $query = $this->db->query("SELECT is_shop_open from users where id='$user_id'");
        return $query->row();
    }

    //get category of maximum product uploads
    public function get_categories_array_with_products($user_id)
    {
        $categories_array = array();
        $categories_array_with_product = array();
        $this->db->select('category_id');
        $this->db->distinct();
        $this->db->where('category_id is NOT NULL');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('products');
        $rows = $query->result();
        if (!(count($rows) > 0)) :
            return false;
        endif;
        foreach ($rows as $row) :
            array_push($categories_array, $row->category_id);
        endforeach;
        $this->db->reset_query();

        foreach ($categories_array as $category) {
            $sql = "SELECT tbl1._id,tbl2.parent_id,tbl2.slug,tbl2.keywords FROM (
                SELECT @r AS _id,
                (SELECT @r := parent_id FROM categories WHERE id = _id) AS parent_id, @l := @l + 1 AS cat_level
                FROM (SELECT @r := " . clean_number($category) . ", @l := 0) vars, categories h WHERE @r <> 0) tbl1
              JOIN categories tbl2 ON tbl1._id = tbl2.id where tbl2.parent_id = 0 ORDER BY tbl1.cat_level DESC";
            $query = $this->db->query($sql);
            $rows = $query->result();
            foreach ($rows as $row) :
                array_push($categories_array_with_product, $row->_id);
            endforeach;
            $this->db->reset_query();
        }
        $a_count = array_count_values($categories_array_with_product);
        arsort($a_count);
        return $a_count;
    }


    public function get_supplier_id_by_shop_name($shop_name)
    {
        // $shop_name = clean_str($shop_name);
        $this->db->where("shop_name", $shop_name);
        $result = $this->db->get('users');
        return $result->row();
    }

    public function get_nowBike_order_details($order_id, $order_product_id)
    {
        $this->db->where("order_id", $order_id);
        $this->db->where("order_product_id", $order_product_id);
        $this->db->where("is_active", "1");
        $result = $this->db->get('now_bike_order_details');
        return $result->row();
    }

    public function get_category_id_by_type($type_id)
    {
        $query = $this->db->query("SELECT category_id FROM category_feature WHERE feature_id='$type_id'");
        return $query->result();
    }

    public function get_category_name_from_tag($tag_id)
    {
        $query = $this->db->query("SELECT * FROM lookup_values WHERE id='$tag_id'");
        return $query->row();
    }
    public function get_lookup_code($lookup_type)
    {
        $query = $this->db->query("SELECT * FROM lookup_values where lookup_code='$lookup_type'");
        return $query->row();
    }
    public function get_seller_by_pincode_dist($pincode)
    {

        $query = $this->db->query("select * from products where user_id in (select pk_id from seller_address where id in (SELECT distinct seller_id FROM distanceMatrix where response like '%110044%' and cast(distanceNumber As DECIMAL) <= 25000));");

        $query = $this->db->query("select pk_id from seller_address where id in (SELECT distinct seller_id FROM distanceMatrix where response like '%110044%' and cast(distanceNumber As DECIMAL) <= 25000)");



        $sql = "SELECT DISTINCT
                new_table.user_id AS seller_ids,
                new_table.product_type AS product_type
            FROM
                (SELECT DISTINCT
                    user_id, 'NON-HOMECOOK' AS product_type
                FROM
                    products
                WHERE
                    category_id IN (SELECT 
                            child_id
                        FROM
                            category_tree_relation
                        WHERE
                            main_id <> 2) UNION SELECT 
                    pk_id AS user_id, 'HOMECOOK' AS product_type
                FROM
                    seller_address
                WHERE
                    id IN (SELECT DISTINCT
                            seller_id
                        FROM
                            distanceMatrix
                        WHERE
                            buyerPincode = '" . clean_number($pincode) . "'
                                AND CAST(distanceNumber AS DECIMAL) <= 25000)) AS new_table";

        $query = $this->db->query($sql);


        // return $query->result();
        $sellers_homecook = array();
        $sellers_non_homecook = array();
        foreach ($query->result_array() as $row) {
            if ($row['product_type'] == "HOMECOOK")
                array_push($sellers_homecook, $row['seller_ids']);
            else
                array_push($sellers_non_homecook, $row['seller_ids']);
        }

        $sellers = [
            'HOMECOOK' => $sellers_homecook,
            'NON-HOMECOOK' => $sellers_non_homecook
        ];

        return $sellers;
    }


    public function product_not_deliver_as_per_delivey_area($pincode)
    {
        $sql = "SELECT 
                    p.id as product_id
                FROM
                    distanceMatrix AS dm,
                    seller_address AS sa,
                    products AS p
                WHERE
                    sa.id = dm.seller_id
                        AND sa.pk_id = p.user_id
                        AND buyerPincode = '" . $pincode . "'
                        AND distanceNumber <= 25000
                        AND (dm.distanceNumber <> ''
                        AND dm.distance <> '')
                        AND dm.distanceNumber / 1000 > CAST(REPLACE(p.delivery_area, 'km', '') AS DECIMAL)
                GROUP BY dm.seller_id , p.slug , p.delivery_area , sa.pk_id , dm.buyerPincode , dm.sellerPincode";


        $query = $this->db->query($sql);

        $product_list = array();
        foreach ($query->result_array() as $row) {
            array_push($product_list, $row['product_id']);
        }
        return $product_list;
    }

    public function get_number_seller_pincode($pincode)
    {
        $sql = "SELECT DISTINCT
                    seller_id
                FROM
                    distanceMatrix
                WHERE
                    response LIKE '%" . clean_number($pincode) . "%'
                        AND CAST(distanceNumber AS DECIMAL) <= 25000";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function get_all_cateory_by_type($type)
    {
        $sql_homecook = "SELECT 
                        child_id
                    FROM
                        category_tree_relation
                    WHERE
                        main_id = 2";
        $sql_non_homecook = "SELECT 
                        child_id
                    FROM
                        category_tree_relation
                    WHERE
                        main_id <> 2";
        if ($type == "HOMECOOK") :
            $query = $this->db->query($sql_homecook);
        elseif ($type == "NON-HOMECOOK") :
            $query = $this->db->query($sql_non_homecook);
        endif;


        $categories = array();
        foreach ($query->result_array() as $row) {
            array_push($categories, $row['child_id']);
        }
        return $categories;
    }

    public function get_category_selected_filters($query_string_array = null, $category_id = null, $per_page, $offset, $only_category = false)
    {
        $categories = $this->get_paginated_filtered_products($query_string_array, $category_id, $per_page, $offset, $only_category);
        $parent_cat_array = array();
        foreach ($categories as $category) {
            $id = $this->category_model->get_parent_categories_tree($category["cat_id"])[0]->id;
            if (!in_array($id, $parent_cat_array)) {
                array_push($parent_cat_array, $id);
            }
        }
        return $parent_cat_array;
    }

    public function get_category_selected_concerned_occasion($query_string_array = null, $category_id = null, $per_page, $offset, $type, $only_category = false)
    {
        $categories = $this->get_products_shop_by_concern($query_string_array, $category_id, $per_page, $offset, $type, $only_category);
        $parent_cat_array = array();
        foreach ($categories as $category) {
            $id = $this->category_model->get_parent_categories_tree($category["cat_id"])[0]->id;
            if (!in_array($id, $parent_cat_array)) {
                array_push($parent_cat_array, $id);
            }
        }
        return $parent_cat_array;
    }

    public function hsn_validity($hsn_val, $hsn_code_len)

    {

        $sql = "SELECT COUNT(*) as count from hsn_with_gst_rate where SUBSTRING(hsn_code,1,$hsn_code_len)='$hsn_val'";

        $query = $this->db->query($sql);

        // $data = $this->db->last_query();
        // return $data;
        $data = $query->row();

        return $data->count;
    }
    public function get_top_picks_products($limit, $user_id)
    {
        // $user_id = $this->auth_user->id;

        $sql = "SELECT search_text FROM search_keyword where user_id = $user_id order by created_at desc limit 10;";
        $query = $this->db->query($sql);
        $data = $query->result();
        $this->build_query();

        $this->db->join('product_details', 'product_details.product_id = products.id');
        $this->db->where('product_details.lang_id', clean_number($this->selected_lang->id));
        $this->db->where('is_service', "0");
        $this->db->where('status', 1)->where('products.is_draft', 0)->where('products.is_deleted', 0);

        if (!empty($data)) :
            $this->db->group_start();
            foreach ($data as $item) {

                $this->db->or_like('title', $item->search_text);
                // $this->db->or_like('shop_name', clean_str($item));
                // $this->db->or_like('brand_name', $item->search_text);
            }
            $this->db->group_end();

        endif;
        $this->db->order_by('products.created_at', 'DESC')->limit(clean_number($limit));
        return $this->db->get('products')->result();
    }

    //Check for exibition enabled
    public function check_exhibition_enabled($product_id)
    {
        $data = array(
            'product_id' => $product_id
        );
        $query = $this->db->query("SELECT 
                count(p.id) count_item
            FROM
                products p,
                users u,
                temp_exhibition_sellers tes
            WHERE
                p.user_id = u.id
                    AND u.email = tes.seller_email
                    AND tes.is_active = 1
                    AND p.id = $product_id");
        $data = $query->row();
        return $data->count_item;
    }
    public function search_products_new($word)
    {
        $metaphone = metaphone($word);
        $soundex = soundex($word);


        // select all words from the dictionary matching the current word
        $sql = "SELECT * FROM word WHERE word ='$word'";
        $wordresult = $this->db->query($sql)->num_rows();
        // $wordnum = mysqli_num_rows($wordresult);
        if ($wordresult == 0) {
            $sql3 = "INSERT INTO word (word,metaphone,soundex) VALUES ('$word','$metaphone','$soundex')";
            $query = $this->db->query($sql3);
        }
        $sql2 = "SELECT * FROM word WHERE soundex ='$soundex'";
        $query1 = $this->db->query($sql2);
        // $count = $query1->num_rows();

        $result1 = $query1->result();
        $i = 1;
        $where = "";
        // while ($worddata = mysqli_fetch_array($wordresult, MYSQLI_ASSOC)) {
        $count = count($result1);
        // echo $count;
        foreach ($result1 as $results) {
            if ($i < $count) {
                $soundword = $results->word;
                // echo $soundword;
                $where .= "title like '%$soundword%' OR brand_name like ('%$soundword%') OR ";
            } else {
                $soundword = $results->word;
                // echo $soundword;
                $where .= "title like '%$soundword%') OR brand_name like ('%$soundword%')";
            }
            $i++;
        }
        $wherecon = "and users.banned ='0' and products.is_draft='0' and products.is_deleted='0' and products.visibility='1' and status='1' order by products.is_promoted desc limit 5) ";
        $sselect = "(SELECT title,brand_name,products.slug FROM product_details join products on products.id=product_details.product_id join users on users.id=products.user_id where (";
        $union = "UNION (select title,brand_name,products.slug from product_details join products on products.id=product_details.product_id join users on users.id=products.user_id where title like ('%$word%') OR brand_name like ('%$word%')";
        $sql5 = $sselect . $where . $wherecon . $union . $wherecon;

        $query8 = $this->db->query($sql5);
        return $query8->result();
    }
}
