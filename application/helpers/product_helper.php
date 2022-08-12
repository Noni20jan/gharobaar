<?php defined('BASEPATH') or exit('No direct script access allowed');

//get product title
if (!function_exists('get_product_title')) {
    function get_product_title($product)
    {
        if (!empty($product)) {
            if (!empty($product->title)) {
                return $product->title;
            } elseif (!empty($product->second_title)) {
                return $product->second_title;
            }
        }
        return "";
    }
}

//get available product
if (!function_exists('get_active_product')) {
    function get_active_product($id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_active_product($id);
    }
}

if (!function_exists('get_filtervalues_by_filterid_filtergroupid')) {
    function get_filtervalues_by_filterid_filtergroupid($filter_id, $filter_group_id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_filtervalues_by_filterid_filtergroupid($filter_id, $filter_group_id);
    }
}

if (!function_exists('get_filtervalues_by_filterid')) {
    function get_filtervalues_by_filterid($filter_id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_filtervalues_by_filterid($filter_id);
    }
}

if (!function_exists('get_image_product')) {
    function get_image_product($id)
    {
        $ci = &get_instance();
        return $ci->file_model->get_image_product($id);
    }
}

//get product details
if (!function_exists('get_product_details')) {
    function get_product_details($id, $lang_id, $get_main_on_null = true)
    {
        $ci = &get_instance();
        return $ci->product_model->get_product_details($id, $lang_id, $get_main_on_null);
    }
}

if (!function_exists('get_product_details_by_id')) {
    function get_product_details_by_id($id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_product_details_by_id($id);
    }
}

//product location cache key
if (!function_exists('get_location_cache_key')) {
    function get_location_cache_key()
    {
        $ci = &get_instance();
        $key = "";
        if (!empty($ci->default_location->city_id)) {
            $key .= "cty" . $ci->default_location->city_id;
        }
        if (!empty($ci->default_location->state_id)) {
            $key .= "st" . $ci->default_location->state_id;
        }
        if (!empty($ci->default_location->country_id)) {
            $key .= "ctry" . $ci->default_location->country_id;
        }
        if (!empty($key)) {
            $key = '_' . $key;
        }
        return $key;
    }
}

//get parent categories
if (!function_exists('get_parent_categories')) {
    function get_parent_categories()
    {
        $ci = &get_instance();
        if (!empty($ci->categories_array)) {
            if (isset($ci->categories_array[0])) {
                return $ci->categories_array[0];
            }
        }
        return null;
    }
}

//get subcategories
if (!function_exists('get_subcategories')) {
    function get_subcategories($parent_id)
    {
        $ci = &get_instance();
        if (!empty($ci->categories_array)) {
            if (isset($ci->categories_array[$parent_id])) {
                return $ci->categories_array[$parent_id];
            }
        }
        return null;
    }
}

if (!function_exists('get_parent_category_id')) {
    function get_parent_category_id($category_id)
    {
        $ci = &get_instance();
        $category_id = 0;
        $category_ids = $ci->input->post('category_id');
        if (!empty($category_ids)) {
            // $category_ids = array_reverse($category_ids);
            foreach ($category_ids as $category_id) {
                if (!empty($category_id)) {
                    $data['category_id'] = $category_id;
                    break;
                }
            }
        }
        return $category_id;
    }
}
//get category
if (!function_exists('get_category')) {
    function get_category($categories, $id)
    {
        if (!empty($categories)) {
            return array_filter($categories, function ($item) use ($id) {
                return $item->id == $id;
            });
        }
        return null;
    }
}

//get categories json
if (!function_exists('get_categories_json')) {
    function get_categories_json($lang_id)
    {
        $ci = &get_instance();
        return $ci->category_model->get_categories_json($lang_id);
    }
}

if (!function_exists('get_category_by_id')) {
    function get_category_by_id($id)
    {
        $ci = &get_instance();
        return $ci->category_model->get_category($id);
    }
}

//get category
if (!function_exists('get_category_by_id')) {
    function get_category_by_id($id)
    {
        $ci = &get_instance();
        return $ci->category_model->get_category($id);
    }
}

//get category name
if (!function_exists('category_name')) {
    function category_name($category)
    {
        if (!empty($category)) {
            if (!empty($category->name)) {
                return html_escape($category->name);
            } else {
                if (!empty($category->second_name)) {
                    return html_escape($category->second_name);
                }
            }
        }
        return "";
    }
}

//get category image url
if (!function_exists('get_category_image_url')) {
    function get_category_image_url($category)
    {
        if ($category->storage == "aws_s3") {
            $ci = &get_instance();
            return $ci->aws_base_url . $category->image;
        } else {
            return base_url() . $category->image;
        }
    }
}

//get parent categories tree
if (!function_exists('get_parent_categories_tree')) {
    function get_parent_categories_tree($category_id, $only_visible = true, $lang_id = null)
    {
        $ci = &get_instance();
        return $ci->category_model->get_parent_categories_tree($category_id, $only_visible, $lang_id = null);
    }
}

if (!function_exists('get_ids_from_array')) {
    function get_ids_from_array($array, $column = 'id')
    {
        if (!empty($array)) {
            return get_array_column_values($array, $column);
        }
        return array();
    }
}

//generate ids string
if (!function_exists('generate_ids_string')) {
    function generate_ids_string($array)
    {
        if (empty($array)) {
            return "0";
        } else {
            return implode(',', $array);
        }
    }
}


//variation of prducts
if (!function_exists('get_product_variations')) {
    function get_product_variations($product_id)
    {
        $ci = &get_instance();
        $ci->db->where('product_id', clean_number($product_id));
        $query = $ci->db->get('variations');
        return $query->result();
        //return $ci->variation_model->get_product_variations($product_id);
    }
}
//variation of prducts
if (!function_exists('get_variation_options')) {
    function get_variation_options($variation_id)
    {
        $ci = &get_instance();
        $sql = "SELECT * FROM variation_options WHERE variation_id = ? and is_active = '1' ORDER BY id";
        $query = $ci->db->query($sql, array(clean_number($variation_id)));
        return $query->result();
        //return $ci->variation_model->get_product_variations($product_id);
    }
}

//product form data
if (!function_exists('get_product_form_data')) {
    function get_product_form_data($product, $user, $preview = 0)
    {
        $ci = &get_instance();
        $data = new stdClass();
        $data->add_to_cart_url = "";
        $data->button = "";
        $data->button2 = "";

        if (!empty($product)) {
            $disabled = "";
            if (!check_product_stock($product)) {
                $disabled = " disabled";
            }
            if ($preview) {
                $disabled = " disabled";
            }
            if ($product->listing_type == 'sell_on_site') {
                if ($user->is_shop_open == "1") {
                    if ($product->is_free_product != 1) {
                        $data->add_to_cart_url = base_url() . 'add-to-cart';
                        $data->button = '<button type="submit" name="submit" value="add_to_cart" style=" float:left; width:100%; font-weight:bold;" class="btn btn-md btn-block btn-product-cart"' . $disabled . '><i class="icon-cart-solid" style="margin-right:5px;"></i>' . trans("add_to_cart") . '</button>';
                        $data->button2 = '<button type="submit" name="submit" value="buy_now" style="width:45%; margin-right:0%; font-weight:bold;" class="btn btn-md btn-block"' . $disabled . '>' . trans("buy_now") . '</button>';
                    }
                } else {
                    $data->add_to_cart_url = base_url() . 'shop-is-close';
                    $data->button = '<button class="btn btn-md btn-block btn-product-cart"' . $disabled . '><i class="icon-shop-solid"></i>' . "Shop is Closed" . '</button>';
                }
            } elseif ($product->listing_type == 'bidding') {
                $data->add_to_cart_url = base_url() . 'request-quote';
                $data->button = '<button class="btn btn-md btn-block btn-product-cart"' . $disabled . '>' . trans("request_a_quote") . '</button>';
                if (!$ci->auth_check && $product->listing_type == 'bidding') {
                    $data->button = '<button type="button" data-toggle="modal" data-target="#loginModal" class="btn btn-md btn-block btn-product-cart"' . $disabled . '>' . trans("request_a_quote") . '</button>';
                }
            } else {
                if (!empty($product->external_link)) {
                    $data->button = '<a href="' . $product->external_link . '" class="btn btn-md btn-block" target="_blank" rel="nofollow">' . trans("buy_now") . '</a>';
                }
            }
        }
        return $data;
    }
}

//get main settings
if (!function_exists('get_main_settings')) {
    function get_main_settings()
    {
        if (defined('SITE_DOMAIN') && defined('SITE_PRC_CD') && defined('SITE_MDS_KEY')) {
            if (!filter_var(SITE_DOMAIN, FILTER_VALIDATE_IP)) {
                if (SITE_MDS_KEY != @sha1(var_db_prce() . main_iteom())) {
                    @lse_inv();
                }
            }
        } else {
            @lse_inv();
        }
    }
}

//get product item image
if (!function_exists('get_product_item_image')) {
    function get_product_item_image($product, $get_second = false)
    {
        $ci = &get_instance();
        if (!empty($product)) {
            $image = $product->image;
            if (!empty($product->image_second) && $get_second == true) {
                $image = $product->image_second;
            }
            if (!empty($image)) {
                $image_array = explode("::", $image);
                if (!empty($image_array[0]) && !empty($image_array[1])) {
                    if ($image_array[0] == "aws_s3") {
                        return $ci->aws_base_url . "uploads/images/" . $image_array[1];
                    } else {
                        return base_url() . "uploads/images/" . $image_array[1];
                    }
                }
            }
        }
        return base_url() . 'assets/img/no-image.jpg';
    }
}

//get latest products
if (!function_exists('get_latest_products')) {
    function get_latest_products($limit)
    {
        $ci = &get_instance();
        if (empty($ci->general_settings->mds_key) || strlen($ci->general_settings->mds_key) < 25) {
            if (function_exists('lse_inv')) {
                lse_inv();
            }
            exit();
        }
        if ($ci->general_settings->cache_system == 1) {
            $key = "latest_products" . get_location_cache_key();
            $latest_products = get_cached_data($key);
            if (empty($latest_products)) {
                $latest_products = $ci->product_model->get_products_limited($limit);
                set_cache_data($key, $latest_products);
            }
            return $latest_products;
        } else {
            return $ci->product_model->get_products_limited($limit);
        }
    }
}

//get promoted products
if (!function_exists('get_promoted_products')) {
    function get_promoted_products($per_page, $offset)
    {
        $ci = &get_instance();
        if ($ci->general_settings->cache_system == 1) {
            $key = "promoted_products" . get_location_cache_key() . "_" . $per_page . "_" . $offset;
            $promoted_products = get_cached_data($key);
            if (empty($promoted_products)) {
                $promoted_products = $ci->product_model->get_promoted_products_limited($per_page, $offset);
                set_cache_data($key, $promoted_products);
            }
            return $promoted_products;
        } else {
            return $ci->product_model->get_promoted_products_limited($per_page, $offset);
        }
    }
}

//get promoted products count
if (!function_exists('get_promoted_products_count')) {
    function get_promoted_products_count()
    {
        $ci = &get_instance();
        if ($ci->general_settings->cache_system == 1) {
            $key = "promoted_products_count" . get_location_cache_key();
            $count = get_cached_data($key);
            if (empty($count)) {
                $count = $ci->product_model->get_promoted_products_count();
                set_cache_data($key, $count);
            }
            return $count;
        } else {
            return $ci->product_model->get_promoted_products_count();
        }
    }
}

//get index categories products
if (!function_exists('get_index_categories_products_array')) {
    function get_index_categories_products_array($categories)
    {
        $ci = &get_instance();
        $products = null;
        if ($ci->general_settings->cache_system == 1) {
            $key = "index_category_products" . get_location_cache_key();
            $products = get_cached_data($key);
            if (empty($products)) {
                $products = $ci->product_model->get_index_categories_products($categories);
                set_cache_data($key, $products);
            }
        } else {
            $products = $ci->product_model->get_index_categories_products($categories);
        }
        $array = array();
        if (!empty($products)) {
            foreach ($products as $product) {
                if (!empty($product->category_id)) {
                    if (!isset($array[$product->category_id]) || (isset($array[$product->category_id]) && item_count($array[$product->category_id]) < 20)) {
                        $array[$product->category_id][] = $product;
                    }
                }
            }
        }
        return $array;
    }
}

//is product in wishlist
if (!function_exists('is_product_in_wishlist')) {
    function is_product_in_wishlist($product)
    {
        $ci = &get_instance();
        if ($ci->auth_check) {
            if (!empty($product->is_in_wishlist)) {
                return true;
            }
        } else {
            $wishlist = $ci->session->userdata('mds_guest_wishlist');
            if (!empty($wishlist)) {
                if (in_array($product->id, $wishlist)) {
                    return true;
                }
            }
        }
        return false;
    }
}

//get currency
if (!function_exists('get_currency')) {
    function get_currency($currency_key)
    {
        $ci = &get_instance();
        if (!empty($ci->currencies)) {
            if (isset($ci->currencies[$currency_key])) {
                return $ci->currencies[$currency_key]["hex"];
            }
        }
        return "";
    }
}

//get currency sign
if (!function_exists('get_currency_sign')) {
    function get_currency_sign($currency_key)
    {
        $ci = &get_instance();
        if (!empty($ci->currencies)) {
            if (isset($ci->currencies[$currency_key])) {
                return $ci->currencies[$currency_key]["symbol"];
            }
        }
        return "";
    }
}

//calculate product price
if (!function_exists('calculate_product_price')) {
    function calculate_product_price($price, $discount_rate, $gst_rate, $listing_price = 0)
    {
        $price = $price / 100;

        if (!empty($price)) {
            if (!empty($discount_rate)) {
                $price = $price - (round(($price * $discount_rate) / 100));
            }
            // var_dump($price);
            // if (!empty($gst_rate)) {
            //     $price = $price / (1 + ($gst_rate / 100));
            // }
            if (!empty($listing_price)) {
                $price = $listing_price / 100;
            }
            $price = $price * 100;
            return $price;
        }
        return 0;
    }
}

//calculate vat
if (!function_exists('calculate_gst')) {
    function calculate_gst($price_calculated, $gst_rate)
    {
        return ($price_calculated * $gst_rate) / (100 + $gst_rate);
    }
}

//calculate product vat
if (!function_exists('calculate_product_gst')) {
    function calculate_product_gst($product)
    {
        if (!empty($product->price)) {
            $price = 0;
            if (!empty($product->discount_rate)) {
                $price = $product->price - (($product->price * $product->discount_rate) / 100);
            }
            if (!empty($product->gst_rate)) {
                $price = $product->price / (1 + ($product->gst_rate / 100));
            }
            $gst = $product->price - $price;
            return $gst;
        }
        return 0;
    }
}

//calculate earned amount
if (!function_exists('calculate_earned_amount')) {
    function calculate_earned_amount($order_product)
    {
        $ci = &get_instance();
        $product_detail = $ci->product_model->get_product_by_id($order_product->product_id);
        $gst_rate = (int)$product_detail->gst_rate;
        $total_gst_amount = round((($order_product->product_total_price * $gst_rate) / 100), 2);
        $commission_rate = calculate_commission_rate($order_product);
        $commission_gst_rate = $ci->general_settings->commission_gst_rate;
        if (!empty($order_product)) {
            $price = $order_product->product_total_price - $total_gst_amount;
            $commission_amount = ($price * $commission_rate) / 100;
            $earned_amount = $price - (($price * $commission_rate) / 100);
            $earned_amount = $earned_amount - (($commission_amount * $commission_gst_rate) / 100);
            return $earned_amount;
        }
        return 0;
    }
}

//calculate commission rate for supplier product
if (!function_exists('calculate_commission_rate')) {
    function calculate_commission_rate($order_product)
    {
        $ci = &get_instance();
        $commission_product_rate = $ci->earnings_model->seller_product_commission($order_product->seller_id, $order_product->product_id);
        $commission_rate = $ci->earnings_model->seller_commission($order_product->seller_id);
        if (!empty($commission_product_rate)) {
            return floatval($commission_product_rate[0]->commission_rate);
        } else if (!empty($commission_rate)) {
            return floatval($commission_rate[0]->commission_rate);
        } else {
            return $ci->general_settings->commission_rate;
        }
    }
}


//calculate commission rate from seller id and product id
if (!function_exists('calculate_commission_rate_seller')) {
    function calculate_commission_rate_seller($seller_id, $product_id = null)
    {
        $ci = &get_instance();
        if ($product_id != null)
            $commission_product_rate = $ci->earnings_model->seller_product_commission($seller_id, $product_id);

        $commission_rate = $ci->earnings_model->seller_commission($seller_id);

        if (!empty($commission_product_rate)) {
            return floatval($commission_product_rate[0]->commission_rate);
        } else if (!empty($commission_rate)) {
            return floatval($commission_rate[0]->commission_rate);
        } else {
            return $ci->general_settings->commission_rate;
        }
    }
}


//get gst number by seller id
if (!function_exists('get_gst_number_by_sellerid')) {
    function get_gst_number_by_sellerid($seller_id)
    {
        $ci = &get_instance();
        return $ci->cart_model->get_gst_number_by_sellerid($seller_id);
    }
}

//get pan number by seller id
if (!function_exists('get_pan_number_by_sellerid')) {
    function get_pan_number_by_sellerid($seller_id)
    {
        $ci = &get_instance();
        return $ci->cart_model->get_pan_number_by_sellerid($seller_id);
    }
}


//price formatted
if (!function_exists('price_formatted')) {
    function price_formatted($price, $currency, $format = null)
    {
        $ci = &get_instance();
        $price = $price / 100;
        $dec_point = '.';
        $thousands_sep = ',';
        if ($ci->thousands_separator != '.') {
            $dec_point = ',';
            $thousands_sep = '.';
        }
        $price = intval(round($price));
        if (is_int($price)) {
            $price = number_format($price, 0, $dec_point, $thousands_sep);
        } else {
            $price = number_format($price, 2, $dec_point, $thousands_sep);
        }
        $price = price_currency_format($price, $currency);
        return $price;
    }
}

//price formatted without rounding off
if (!function_exists('price_formatted_without_round')) {
    function price_formatted_without_round($price, $currency, $format = null)
    {
        $ci = &get_instance();
        $negative = false;
        if ($price < 0) {
            $negative = true;
            $price = -$price;
        }
        $price = $price / 100;
        $dec_point = '.';
        $thousands_sep = ',';
        if ($ci->thousands_separator != '.') {
            $dec_point = ',';
            $thousands_sep = '.';
        }
        if (is_int($price)) {
            $price = number_format($price, 0, $dec_point, $thousands_sep);
        } else {
            $price = number_format($price, 2, $dec_point, $thousands_sep);
        }
        $price = price_currency_format($price, $currency, $negative);
        return $price;
    }
}


//price currency format
if (!function_exists('price_currency_format')) {
    function price_currency_format($price, $currency, $negative = false)
    {
        $ci = &get_instance();
        $currency = get_currency($currency);
        $space = "";
        if ($ci->payment_settings->space_between_money_currency == 1) {
            $space = " ";
        }
        if ($ci->payment_settings->currency_symbol_format == "left") {
            // $price = "<span>" . $currency . "</span>" . $space . $price;
            $price =  $currency . $price;
        } else {
            $price = $price . $space . "<span>" . $currency . "</span>";
        }
        if ($negative) {
            return "-" . $space . $price;
        } else {
            return $price;
        }
    }
}

//get price
if (!function_exists('get_price')) {
    function get_price($price, $format_type)
    {
        $ci = &get_instance();

        if ($format_type == "input") {
            $price = $price / 100;
            if (is_int($price)) {
                $price = number_format($price, 0, ".", "");
            } else {
                $price = number_format($price, 2, ".", "");
            }
            if ($ci->thousands_separator == ',') {
                $price = str_replace('.', ',', $price);
            }
            return $price;
        } elseif ($format_type == "decimal") {
            $price = $price / 100;
            return number_format($price, 2, ".", "");
        } elseif ($format_type == "database") {
            $price = str_replace(',', '.', $price);
            $price = floatval($price);
            $price = number_format($price, 2, '.', '') * 100;
            return $price;
        } elseif ($format_type == "separator_format") {
            $price = $price / 100;
            $dec_point = '.';
            $thousands_sep = ',';
            if ($ci->thousands_separator != '.') {
                $dec_point = ',';
                $thousands_sep = '.';
            }
            return number_format($price, 2, $dec_point, $thousands_sep);
        }
    }
}

//get variation label
if (!function_exists('get_variation_label')) {
    function get_variation_label($label_array, $lang_id)
    {
        $ci = &get_instance();
        $label = "";
        if (!empty($label_array)) {
            $label_array = unserialize_data($label_array);
            foreach ($label_array as $item) {
                if ($lang_id == $item['lang_id']) {
                    $label = $item['label'];
                    break;
                }
            }
            if (empty($label)) {
                foreach ($label_array as $item) {
                    if ($ci->general_settings->site_lang == $item['lang_id']) {
                        $label = $item['label'];
                        break;
                    }
                }
            }
        }
        return $label;
    }
}

//get variation option name
if (!function_exists('get_variation_option_name')) {
    function get_variation_option_name($names_array, $lang_id)
    {
        $ci = &get_instance();
        $name = "";
        if (!empty($names_array)) {
            $names_array = unserialize_data($names_array);
            foreach ($names_array as $item) {
                if ($lang_id == $item['lang_id']) {
                    $name = $item['option_name'];
                    break;
                }
            }
            if (empty($name)) {
                foreach ($names_array as $item) {
                    if ($ci->general_settings->site_lang == $item['lang_id']) {
                        $name = $item['option_name'];
                        break;
                    }
                }
            }
        }
        return $name;
    }
}


//get variation default option
if (!function_exists('get_variation_default_option')) {
    function get_variation_default_option($variation_id)
    {
        $ci = &get_instance();
        return $ci->variation_model->get_variation_default_option($variation_id);
    }
}

//get variation sub options
if (!function_exists('get_variation_sub_options')) {
    function get_variation_sub_options($parent_id)
    {
        $ci = &get_instance();
        return $ci->variation_model->get_variation_sub_options($parent_id);
    }
}

//is there variation uses different price
if (!function_exists('is_there_variation_uses_different_price')) {
    function is_there_variation_uses_different_price($product_id, $except_id = null)
    {
        $ci = &get_instance();
        return $ci->variation_model->is_there_variation_uses_different_price($product_id, $except_id);
    }
}

//discount rate format
if (!function_exists('discount_rate_format')) {
    function discount_rate_format($discount_rate)
    {
        return $discount_rate . "%" . " Off";
    }
}

//check product stock
if (!function_exists('check_product_stock')) {
    function check_product_stock($product)
    {
        if (!empty($product)) {
            if ($product->product_type == 'digital') {
                return true;
            }
            if ($product->stock > 0) {
                return true;
            }
        }
        return false;
    }
}

//get query string array
if (!function_exists('get_query_string_array')) {
    function get_query_string_array($custom_filters)
    {
        $array_filter_keys = get_array_column_values($custom_filters, 'product_filter_key');
        $category_filter = get_filters();
        foreach ($category_filter as $filter) {
            array_push($array_filter_keys, $filter->name);
        }
        array_push($array_filter_keys, "p_min");
        array_push($array_filter_keys, "p_max");
        array_push($array_filter_keys, "p_min_weight");
        array_push($array_filter_keys, "p_max_weight");
        array_push($array_filter_keys, "product_type");
        array_push($array_filter_keys, "sort");
        array_push($array_filter_keys, "search");
        array_push($array_filter_keys, "rating");
        array_push($array_filter_keys, "food_preference");
        array_push($array_filter_keys, "size");
        array_push($array_filter_keys, "origin_of_product");
        array_push($array_filter_keys, "discount");
        array_push($array_filter_keys, "seller_type");
        array_push($array_filter_keys, "color");
        array_push($array_filter_keys, "jewellery_type");
        array_push($array_filter_keys, "meal_type");
        array_push($array_filter_keys, "food_type");
        array_push($array_filter_keys, "available");
        array_push($array_filter_keys, "cash_on_delivery");
        array_push($array_filter_keys, "blouse_details");
        array_push($array_filter_keys, "gender");
        array_push($array_filter_keys, "saree_length");
        array_push($array_filter_keys, "pet_age");
        array_push($array_filter_keys, "available_for_return_or_exchange");
        array_push($array_filter_keys, "suitable_for");
        array_push($array_filter_keys, "is_personalised");
        array_push($array_filter_keys, "shipping_time");
        array_push($array_filter_keys, "availability");
        array_push($array_filter_keys, "category");

        $queries = array();
        $array_queries = array();
        $str = $_SERVER["QUERY_STRING"];
        $str = str_replace('<', '', $str);
        $str = str_replace('>', '', $str);
        $str = str_replace('*', '', $str);
        $str = str_replace('"', '', $str);
        $str = str_replace('(', '', $str);
        $str = str_replace(')', '', $str);
        @parse_str($str, $queries);
        if (!empty($queries)) {
            foreach ($queries as $key => $value) {
                if (in_array($key, $array_filter_keys)) {
                    $key = str_slug($key);
                    $array_values = explode(',', $value);
                    for ($i = 0; $i < item_count($array_values); $i++) {
                        $array_values[$i] = remove_forbidden_characters($array_values[$i]);
                    }
                    $array_queries[$key] = $array_values;
                }
            }
        }
        return $array_queries;
    }
}

//generate filter url
if (!function_exists('generate_filter_url')) {
    function generate_filter_url($query_string_array, $key, $value)
    {

        // var_dump($query_string_array);
        // die();
        //  var_dump($key);
        //  die();
        $key = @urlencode($key);
        $query = "";
        // var_dump($query_string_array);
        //die();
        if (!empty($key)) {
            if (empty($query_string_array) || !is_array($query_string_array)) {
                // var_dump($query_string_array);
                // die();
                return "?" . $key . "=" . @urlencode($value);
            }

            //add remove the key value
            if (!empty($query_string_array[$key])) {
                if ($key == "sort") {
                    $query_string_array[$key] = [$value];
                } else if ($key == "food_preference") {
                    $query_string_array[$key] = [$value];
                } else {
                    if (in_array($value, $query_string_array[$key])) {
                        $new_array = array();
                        foreach ($query_string_array[$key] as $item) {
                            if (!empty($item) && $item != $value) {
                                $new_array[] = $item;
                            }
                        }
                        $query_string_array[$key] = $new_array;
                    } else {
                        $query_string_array[$key][] = $value;
                    }
                }
            } else {
                $query_string_array[$key][] = $value;
            }
        }

        //generate query string
        $i = 0;
        foreach ($query_string_array as $key => $array_values) {
            if (!empty($array_values)) {
                if ($i == 0) {
                    $query = "?" . generate_filter_string($key, $array_values);
                } else {
                    $query .= "&" . generate_filter_string($key, $array_values);
                }
                $i++;
            }
        }
        return $query;
    }
}

//generate filter string
if (!function_exists('generate_filter_string')) {
    function generate_filter_string($key, $array_values)
    {
        $str = "";
        $j = 0;
        if (!empty($array_values)) {
            foreach ($array_values as $value) {
                if (!empty($value) && !is_array($value)) {
                    $value = urlencode($value);
                    if ($j == 0) {
                        $str = $value;
                    } else {
                        $str .= "," . $value;
                    }
                    $j++;
                }
            }
            $str = $key . "=" . $str;
        }
        return $str;
    }
}

//get query string array to array of objects
if (!function_exists('convert_query_string_to_object_array')) {
    function convert_query_string_to_object_array($query_string_array)
    {
        $array = array();
        if (!empty($query_string_array)) {
            foreach ($query_string_array as $key => $array_values) {
                if (!empty($array_values)) {
                    foreach ($array_values as $value) {
                        $obj = new stdClass();
                        $obj->key = $key;
                        $obj->value = $value;
                        array_push($array, $obj);
                    }
                }
            }
        }
        return $array;
    }
}

//is custom field option selected
if (!function_exists('is_custom_field_option_selected')) {
    function is_custom_field_option_selected($query_string_object_array, $key, $value)
    {
        if (!empty($query_string_object_array)) {
            foreach ($query_string_object_array as $item) {
                if ($item->key == $key && $item->value == $value) {
                    return true;
                    break;
                }
            }
        }
        return false;
    }
}

//generate price filter url
if (!function_exists('generate_price_filter_url')) {
    function generate_price_filter_url($query_string_object_array)
    {
        $query_array = array();
        foreach ($query_string_object_array as $item) {
            if ($item->key != 'p_min' && $item->key != 'p_max') {
                $query_array[] = urlencode($item->key) . '=' . urlencode($item->value);
            }
        }
        return implode('&', $query_array);
    }
}
if (!function_exists('generate_weight_filter_url')) {
    function generate_weight_filter_url($query_string_object_array)
    {
        $query_array = array();
        foreach ($query_string_object_array as $item) {
            if ($item->key != 'p_min_weight' && $item->key != 'p_max_weight') {
                $query_array[] = urlencode($item->key) . '=' . urlencode($item->value);
            }
        }
        return implode('&', $query_array);
    }
}
//get lookup_type values from lookup_type
if (!function_exists('get_lookup_values_by_type')) {
    function get_lookup_values_by_type($lookup_type)
    {
        $ci = &get_instance();
        return $ci->lookup_model->get_lookup_values_by_type($lookup_type);
    }
}

//get lookup_type values from lookup_type
if (!function_exists('get_filters')) {
    function get_filters()
    {
        $ci = &get_instance();
        return $ci->product_model->get_filters();
    }
}


if (!function_exists('get_filter_id_by_cat_id')) {
    function get_filter_id_by_cat_id($category_id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_filter_id_by_cat_id($category_id);
    }
}


if (!function_exists('get_filters_by_id')) {
    function get_filters_by_id($filter_id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_filters_by_id($filter_id);
    }
}


if (!function_exists('get_catg_filter')) {
    function get_catg_filter()
    {
        $ci = &get_instance();
        return $ci->product_model->get_catg_filter();
    }
}
//calculate transit time for home cooks
if (!function_exists('get_transit_time_for_home_cook')) {
    function get_transit_time_for_home_cook($product, $type)
    {
        $ci = &get_instance();
        // return $product;
        return $ci->product_model->get_transit_time_for_home_cook($product->id, $product->lead_days, $product->lead_time, $product->order_capacity, $type);
    }
}

//calculate transit time for made to order
if (!function_exists('get_transit_time_for_made_to_order')) {
    function get_transit_time_for_made_to_order($product, $type)
    {
        $ci = &get_instance();
        // return $product;
        return $ci->product_model->get_transit_time_for_made_to_order($product->id, $product->user_id, $product->lead_days, $product->lead_time, $type);
    }
}

//get lead time for product
if (!function_exists('get_lead_time_product')) {
    function get_lead_time_product($product)
    {

        // return $product->lead_time;
        if (empty($product->lead_days)) {
            if ($product->lead_time == "1") :
                $result = $product->lead_time . " hour";
                return $result;
            else :
                $result = $product->lead_time . " hours";
                return $result;
            endif;
        }
        if (empty($product->lead_time)) {
            if ($product->lead_days == "1") :
                $result = $product->lead_days . " day";
                return $result;
            else :
                $result = $product->lead_days . " days";
                return $result;
            endif;
        }
        $result = $product->lead_days . " days " . $product->lead_time . " hours";
        return $result;
    }
}

//get lead time for product
if (!function_exists('get_lead_time_hours')) {
    function get_lead_time_hours($product)
    {
        $day = (int)($product->lead_days);
        $hour = (int)($product->lead_time);
        $second = (($day * 24 + $hour) * 60) * 60;
        return $second;
    }
}

// check for MADE to ORDER products
if (!function_exists('check_for_made_to_order')) {
    function check_for_made_to_order($product)
    {
        if ($product->add_meet == "Made to order") {
            return true;
        }
        return false;
    }
}

// get product transaction detail for admin refund modal
if (!function_exists('get_product_transaction_details')) {

    function get_product_transaction_details($order_product_table_id)
    {
        $ci = &get_instance();
        $order_product_id = $order_product_table_id;
        $order_product_id = clean_number($order_product_id);
        $order_product = $ci->order_model->get_order_product($order_product_id);
        $order_id = $order_product->order_id;
        $order_detail = $ci->order_model->get_order_detail_by_id($order_id);
        $payment_method = $order_detail[0]->payment_method;
        // if($payment_method=="Cashfree"){
        $product_id = $order_product->product_id;
        $product_quantity = $order_product->product_quantity;
        $product_unit_price = $order_product->product_unit_price;
        $product_discount_rate = $order_product->product_discount_rate;
        $product_gst_rate = $order_product->product_gst_rate;
        $product_name = $order_product->product_title;
        $total_price_with_quantity = $order_product->product_total_price;
        $price_after_discount = calculate_product_price($product_unit_price, $product_discount_rate, $product_gst_rate);
        $product_price = floor($price_after_discount * 100) / 100;
        $product_seller_id = $order_product->seller_id;


        $order_transaction_detail = $ci->order_model->get_transaction_detail($order_id);
        if ($order_transaction_detail) :
            $payment_refrence_id = $order_transaction_detail[0]->payment_id;


            // $refund_amount1 = ($price_after_discount * $product_quantity) / 100;
            // $refund_amount = number_format(floor($refund_amount1 * 100) / 100, 2);
            $refund_amount = $total_price_with_quantity / 100;
            $order_detail = $ci->order_model->get_order_detail_by_id($order_id);
            $product_price = ($refund_amount / $product_quantity) * 100;
            $order_total_amount = $order_detail[0]->price_total;

            // shipping charges seller & product wise
            $shipping_amount_without_round = ($order_product->product_shipping_cost) / 100;
            $shipping_amount = round($shipping_amount_without_round);

            // shipping amount according to complete order
            // $shipping_amount = ($order_detail[0]->price_shipping) / 100;

            //shipping charge check
            $include_shipping = true;
            $order_products =  $ci->order_model->get_order_product_detail($order_id);
            foreach ($order_products as $products) {
                if ((int)$products->id != (int)$order_product_id) {
                    if (($products->order_status == "completed" || $products->order_status == "processing" || $products->order_status == "waiting" || $products->order_status == "awaiting_shipment" || $products->order_status == "awaiting_pickup") && ($products->seller_id == $product_seller_id)) {
                        $include_shipping = false;
                        break;
                    }
                }
            }

            // var_dump($include_shipping);

            if ($include_shipping) {
                // $shipping_amount = ($order_detail[0]->price_shipping) / 100;
                $refund_amount = $refund_amount + $shipping_amount;
            }

            $data = array(
                "order_id" => $order_id,
                "refund_amount" => $refund_amount,
                "payment_refrence_id" => $payment_refrence_id,
                "order_product_id" => $product_id,
                "product_price" => $product_price,
                "refund_amount" => $refund_amount,
                "order_total_amount" => $order_total_amount,
                "order_product_table_id" => $order_product_id,
                "payment_method" => $payment_method
            );
            return $data;
        else :
            return false;
        endif;
        // }
    }
}

// check for number of days for shipping_time of product
if (!function_exists('check_for_days')) {
    function check_for_days($product)
    {
        $ci = &get_instance();
        // $made_to_order= check_for_made_to_order($product);
        if ($product->add_meet == "Made to stock") {
            $days = $ci->product_model->get_product_shipping_days($product->shipping_time);
            $day_count = (int)$days->lookup_int_val;
            return $day_count;
        }
        // if ($made_to_order == false) {
        //     $days=(int)$ci->product_model->get_product_shipping_days($product->shipping_time);
        // }else{
        //     $home_cook = get_parent_categories_tree($product->category_id);
        //     if($home_cook[0]->id == 15){
        //         $min = get_transit_time_for_home_cook($product, "time");
        //         $round_days= secondsToTime($min);
        //         $days= $round_days;
        //     }else{
        //         $min = get_transit_time_for_made_to_order($product, "time");
        //         $round_days= secondsToTime($min);
        //         $days= $round_days;
        //     }
        // }
        return 0;
    }
}

function secondsToTime($seconds)
{
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a');
}
