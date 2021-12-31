<?php defined('BASEPATH') or exit('No direct script access allowed');
/*
 * Custom Helpers
 *
 */


if (strpos($_SERVER['REQUEST_URI'], '/index.php') !== false) {
    $ci = &get_instance();
    $ci->load->helper('url');
    redirect(current_url());
    exit();
}

//post method
if (!function_exists('post_method')) {
    function post_method()
    {
        $ci = &get_instance();
        if ($ci->input->method(FALSE) != 'post') {
            exit();
        }
    }
}

//get method
if (!function_exists('get_method')) {
    function get_method()
    {
        $ci = &get_instance();
        if ($ci->input->method(FALSE) != 'get') {
            exit();
        }
    }
}

//get
if (!function_exists('input_get')) {
    function input_get($input_name)
    {
        $ci = &get_instance();
        return clean_str($ci->input->get($input_name, true));
    }
}

//unserialize data
if (!function_exists('unserialize_data')) {
    function unserialize_data($serialized_data)
    {
        $data = @unserialize($serialized_data);
        if (empty($data) && preg_match('/^[aOs]:/', $serialized_data)) {
            $serialized_data = preg_replace_callback('/s\:(\d+)\:\"(.*?)\";/s', function ($matches) {
                return 's:' . strlen($matches[2]) . ':"' . $matches[2] . '";';
            }, $serialized_data);
            $data = @unserialize($serialized_data);
        }
        return $data;
    }
}

//check auth
if (!function_exists('lang_base_url')) {
    function lang_base_url()
    {
        $ci = &get_instance();
        return $ci->lang_base_url;
    }
}

//language dropdown option
if (!function_exists('get_language_dropdown_option')) {
    function get_language_dropdown_option($language)
    {
        $ci = &get_instance();
        $page_uri = "";
        $base_url = base_url();
        if (empty($ci->lang_segment)) {
            $page_uri = str_replace($base_url, '', current_url());
        } else {
            $base_url = base_url() . $ci->lang_segment;
            $page_uri = str_replace($base_url, '', current_url());
        }
        $page_uri = trim($page_uri, '/');
        $new_base_url = base_url();
        if ($ci->site_lang->id != $language->id) {
            $new_base_url = base_url() . $language->short_form . "/";
        }
        return $new_base_url . $page_uri;
    }
}

//vendor products by user_id
if (!function_exists('get_vendor_products')) {
    function get_vendor_products($user_id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_user_products_by_user_id_pageview($user_id);
    }
}
if (!function_exists('get_vendor_shop_status')) {
    function get_vendor_shop_status($user_id)
    {
        $ci = &get_instance();
        $name = $ci->profile_model->get_vendor($user_id);
        return $name[0]->is_shop_open;
    }
}
//get product category tags from 
if (!function_exists('get_products_tags')) {
    function get_products_tags($type)
    {
        $ci = &get_instance();
        $name = $ci->product_model->get_products_tags($type);
        return $name[0]->meaning;
    }
}

//products subcategories for clothing
if (!function_exists('categories_clothing')) {
    function categories_clothing()
    {
        $ci = &get_instance();
        return $ci->product_model->get_rss_products_by_category_new(12);
    }
}

//products subcategories for food
if (!function_exists('categories_food')) {
    function categories_food()
    {
        $ci = &get_instance();
        return $ci->product_model->get_rss_products_by_category_new(9);
    }
}

//products subcategories for beauty and personal care
if (!function_exists('categories_beauty')) {
    function categories_beauty()
    {
        $ci = &get_instance();
        return $ci->product_model->get_rss_products_by_category_new(13);
    }
}

//products for discount section
if (!function_exists('get_products_by_discount_order')) {
    function get_products_by_discount_order()
    {
        $ci = &get_instance();
        return $ci->product_model->get_products_by_discount_order();
    }
}

//products subcategories for shop by product section
if (!function_exists('shop_by_product_categories')) {
    function shop_by_product_categories($id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_shop_by_product_categories($id);
    }
}

if (!function_exists('product_description')) {
    function product_description($id)
    {
        $ci = &get_instance();
        $product_details = $ci->product_model->get_product_details($id, $ci->selected_lang->id, true);
        return $product_details->description;
    }
}

if (!function_exists('small_text_generator')) {
    function small_text_generator($string, $string_length)
    {
        if (strlen($string) >= $string_length) {
            $string = substr($string, 0, $string_length);
            $string .= "...";
        }
        return $string;
    }
}

//check auth
if (!function_exists('auth_check')) {
    function auth_check()
    {
        $ci = &get_instance();
        return $ci->auth_model->is_logged_in();
    }
}

//is admin
if (!function_exists('is_admin')) {
    function is_admin()
    {
        $ci = &get_instance();
        if ($ci->auth_check) {
            if ($ci->auth_user->role == "admin") {
                return true;
            }
        }
        return false;
    }
}
// if (!function_exists('is_guest')) {
//     function is_guest()
//     {
//         $ci = &get_instance();
//         if ($ci->auth_check) {
//             if ($ci->auth_user->role == "guest") {
//                 return true;
//             }
//         }
//         return false;
//     }
// }

//get logged user
if (!function_exists('user')) {
    function user()
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        $user = $ci->auth_model->get_logged_user();
        if (empty($user)) {
            $ci->auth_model->logout();
        } else {
            return $user;
        }
    }
}

//get user by id
if (!function_exists('get_user')) {
    function get_user($user_id)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->auth_model->get_user($user_id);
    }
}
if (!function_exists('get_barter_members')) {
    function get_barter_members()
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->auth_model->get_barter_members();
    }
}


if (!function_exists('get_barter_product_of_current_user')) {
    function get_barter_product_of_current_user()
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->product_model->get_barter_product_of_current_user();
    }
}

if (!function_exists('get_full_width_product_variations_custom')) {
    function get_full_width_product_variations_custom($product_id)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->variation_model->get_full_width_product_variations($product_id);
    }
}

if (!function_exists('get_half_width_product_variations_custom')) {
    function get_half_width_product_variations_custom($product_id)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->variation_model->get_half_width_product_variations($product_id);
    }
}

if (!function_exists('get_half_width_product_variations_custom')) {
    function get_half_width_product_variations_custom($product_id)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->variation_model->get_half_width_product_variations($product_id);
    }
}
if (!function_exists('get_user_by_shop_name')) {
    function get_user_by_shop_name($shopname)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->auth_model->get_user_by_shop_name($shopname);
    }
}


//get shop name
if (!function_exists('get_shop_name')) {
    function get_shop_name($user)
    {
        if (!empty($user)) {
            if (!empty($user->shop_name) && ($user->role == 'admin' || $user->role == 'vendor')) {
                return html_escape($user->shop_name);
            } else {
                return html_escape($user->username);
            }
        }
    }
}

if (!function_exists('get_brand_name')) {
    function get_brand_name($user)
    {
        if (!empty($user)) {
            if (!empty($user->brand_name) && ($user->role == 'admin' || $user->role == 'vendor')) {
                return html_escape($user->brand_name);
            } else {
                return html_escape($user->shop_name);
            }
        }
    }
}

// //get brand name
// if (!function_exists('get_brand_name')) {
//     function get_brand_name($user)
//     {
//         if (!empty($user)) {
//             if (!empty($user->brand_name) && ($user->role == 'admin' || $user->role == 'vendor')) {
//                 return html_escape($user->brand_name);
//             } else {
//                 return html_escape($user->username);
//             }
//         }
//     }
// }

//get full name
if (!function_exists('get_full_name')) {
    function get_full_name($user)
    {
        if (!empty($user)) {
            if (!empty($user->first_name) && ($user->role == 'admin' || $user->role == 'vendor' || $user->role == 'member')) {
                $full_name = html_escape($user->first_name);
                if (!empty($user->middle_name)) {
                    $full_name = $full_name . ' ' . html_escape($user->middle_name);
                }
                if (!empty($user->last_name)) {
                    $full_name = $full_name . ' ' . html_escape($user->last_name);
                }
                return $full_name;
            } else {
                return html_escape($user->username);
            }
        }
    }
}

//get shop name product
if (!function_exists('get_shop_name_product')) {
    function get_shop_name_product($product)
    {
        if (!empty($product)) {
            if (!empty($product->shop_name) && ($product->user_role == 'admin' || $product->user_role == 'vendor')) {
                return $product->shop_name;
            } else {
                return html_escape($product->user_username);
            }
        }
    }
}

//get shop name product
if (!function_exists('get_brand_name_product')) {
    function get_brand_name_product($product)
    {
        if (!empty($product)) {
            if (!empty($product->brand_name) && ($product->user_role == 'admin' || $product->user_role == 'vendor')) {
                return $product->brand_name;
            } else {
                return html_escape($product->shop_name);
            }
        }
    }
}

//get get_supplier_id_by_name
if (!function_exists('get_supplier_id_by_shop_name')) {
    function get_supplier_id_by_shop_name($shop_name)
    {
        $ci = &get_instance();
        return $ci->product_model->get_supplier_id_by_shop_name($shop_name);
    }
}




//get shop name product
if (!function_exists('get_seller_id_by_product_id')) {
    function get_seller_id_by_product_id($product_id)
    {
        $product = get_product($product_id);
        if (!empty($product)) {
            return html_escape($product->user_id);
        }
    }
}

//get shop name by user id
if (!function_exists('get_shop_name_by_user_id')) {
    function get_shop_name_by_user_id($user_id)
    {
        $user = get_user($user_id);
        if (!empty($user)) {
            if (!empty($user->shop_name)) {
                return html_escape($user->shop_name);
            } else {
                return html_escape($user->username);
            }
        }
    }
}

//get shop name by user id
if (!function_exists('get_first_last_name_by_user_id')) {
    function get_first_last_name_by_user_id($user_id)
    {
        $user = get_user($user_id);
        if (!empty($user)) {
            return html_escape($user->first_name . " " . $user->last_name);
        }
    }
}

//is multi-vendor active
if (!function_exists('is_multi_vendor_active')) {
    function is_multi_vendor_active()
    {
        $ci = &get_instance();
        $active = true;
        if ($ci->general_settings->multi_vendor_system != 1) {
            $active = false;
        }
        if ($ci->auth_check) {
            if ($ci->auth_user->role == "admin") {
                $active = true;
            }
        }
        return $active;
    }
}

//check is user vendor
if (!function_exists('is_user_vendor')) {
    function is_user_vendor()
    {
        $ci = &get_instance();
        if ($ci->auth_check && is_multi_vendor_active()) {
            if ($ci->general_settings->vendor_verification_system != 1) {
                return true;
            } else {
                if ($ci->auth_user->role == 'vendor' || $ci->auth_user->role == 'admin') {
                    return true;
                }
            }
        }
        return false;
    }
}

//check is user applied for shop opening
if (!function_exists('is_user_applied_for_shop')) {
    function is_user_applied_for_shop()
    {
        $ci = &get_instance();
        if ($ci->auth_check) {
            if ($ci->auth_user->role == 'member' && $ci->auth_user->is_active_shop_request == '1') {
                return true;
            }
        }
        return false;
    }
}

//is marketplace active
if (!function_exists('is_marketplace_active')) {
    function is_marketplace_active()
    {
        $ci = &get_instance();
        if ($ci->general_settings->marketplace_system == 1) {
            return true;
        }
        return false;
    }
}

//is bidding system active
if (!function_exists('is_bidding_system_active')) {
    function is_bidding_system_active()
    {
        $ci = &get_instance();
        if ($ci->general_settings->bidding_system == 1) {
            return true;
        }
        return false;
    }
}

//get translated message
if (!function_exists('trans')) {
    function trans($string)
    {
        $ci = &get_instance();
        if (!empty($ci->language_translations[$string])) {
            return $ci->language_translations[$string];
        }
        return "";
    }
}

//print old form data
if (!function_exists('old')) {
    function old($field)
    {
        $ci = &get_instance();
        if (isset($ci->session->flashdata('form_data')[$field])) {
            return html_escape($ci->session->flashdata('form_data')[$field]);
        }
    }
}

//count item
if (!function_exists('item_count')) {
    function item_count($items)
    {
        if (!empty($items)) {
            return count($items);
        }
        return 0;
    }
}

//admin url
if (!function_exists('admin_url')) {
    function admin_url()
    {
        return base_url() . get_route('admin', true);
    }
}

//dashboard url
if (!function_exists('dashboard_url')) {
    function dashboard_url()
    {
        return lang_base_url() . get_route('dashboard', true);
    }
}

//get route
if (!function_exists('get_route')) {
    function get_route($key, $slash = false)
    {
        $ci = &get_instance();
        $route = $key;
        if (!empty($ci->routes->$key)) {
            $route = $ci->routes->$key;
            if ($slash == true) {
                $route .= '/';
            }
        }
        return $route;
    }
}

//get mobile menu categories
if (!function_exists('get_mobile')) {
    function get_mobile()
    {
        $ci = &get_instance();
        $array = array();

        if (!empty($ci->parent_categories)) {
            foreach ($ci->parent_categories as $parent_category) {
                print_r($ci->parent_categories);
                exit();
            }
        }


        if (!empty($ci->categories_array)) {
            if (isset($ci->categories_array[0])) {
                return $ci->categories_array[0];
            }
        }
    }
}

//get order
if (!function_exists('get_order')) {
    function get_order($order_id)
    {
        $ci = &get_instance();
        return $ci->order_model->get_order($order_id);
    }
}



if (!function_exists('get_order')) {
    function get_order($order_id)
    {
        $ci = &get_instance();
        return $ci->order_model->get_order($order_id);
    }
}

//get order by order number
if (!function_exists('get_order_by_order_number')) {
    function get_order_by_order_number($order_number)
    {
        $ci = &get_instance();
        return $ci->order_model->get_order_by_order_number($order_number);
    }
}

//get payment method
if (!function_exists('get_payment_method')) {
    function get_payment_method($payment_method)
    {
        if ($payment_method == "Bank Transfer") {
            return trans("bank_transfer");
        } elseif ($payment_method == "Cash On Delivery") {
            return trans("cash_on_delivery");
        } else {
            return $payment_method;
        }
    }
}
//get payment status
if (!function_exists('get_payment_status')) {
    function get_payment_status($payment_status)
    {
        if ($payment_status == "payment_received") {
            return trans("payment_received");
        } elseif ($payment_status == "awaiting_payment") {
            return trans("awaiting_payment");
        } else {
            return $payment_status;
        }
    }
}



//get payment mode
if (!function_exists('get_payment_modes')) {
    function get_payment_modes()
    {
        $ci = &get_instance();
        return $ci->cart_model->get_payment_modes();
    }
}
//get net banking banks
if (!function_exists('get_nb_banks')) {
    function get_nb_banks()
    {
        $ci = &get_instance();
        return $ci->cart_model->get_nb_banks();
    }
}
//get wallets
if (!function_exists('get_wallets')) {
    function get_wallets()
    {
        $ci = &get_instance();
        return $ci->cart_model->get_wallets();
    }
}



//generate category url
if (!function_exists('generate_category_url')) {
    function generate_category_url($category)
    {

        if (!empty($category)) {
            if ($category->parent_id == 0) {
                return lang_base_url() . $category->slug;
            } else {
                return lang_base_url() . $category->parent_slug . "/" . $category->slug;
            }
        }
    }
}

//generate product url
if (!function_exists('generate_product_url')) {
    function generate_product_url($product)
    {
        if (!empty($product)) {
            return lang_base_url() . $product->slug;
        }
    }
}
//generate product preview url
if (!function_exists('generate_product_preview_url')) {
    function generate_product_preview_url($product)
    {
        if (!empty($product)) {
            return lang_base_url() . "preview/" . $product->slug;
        }
    }
}

if (!function_exists('generate_barterproduct_url')) {
    function generate_barterproduct_url($product)
    {
        if (!empty($product)) {
            return lang_base_url() . get_route("barterproduct", true) . '/' .  $product->slug;
        }
    }
}

//generate product url by slug
if (!function_exists('generate_product_variation_image')) {
    function generate_product_variation_image($order_product)
    {
        $ci = &get_instance();
        if (!empty($order_product)) {
            $variation_id = @unserialize($order_product->variation_option_ids);
            if (!empty($variation_id)) {
                $option = $ci->variation_model->get_variation_option($variation_id[0]);
                return $option;
            }
        }
    }
}

//generate product url by slug
if (!function_exists('generate_product_url_by_slug')) {
    function generate_product_url_by_slug($slug)
    {
        if (!empty($slug)) {
            return lang_base_url() . $slug;
        }
    }
}

//generate blog url
if (!function_exists('generate_post_url')) {
    function generate_post_url($post)
    {
        if (!empty($post)) {
            return lang_base_url() . get_route("blog", true) . $post->category_slug . '/' . $post->slug;
        }
    }
}

//generate profile url
if (!function_exists('generate_profile_url')) {
    function generate_profile_url($slug)
    {
        $ci = &get_instance();
        $active = true;
        if ($ci->auth_check) {
            if ($ci->auth_user->role != "admin")
                $active = false;
        }
        if (!empty($slug)) {
            $user = get_user_by_slug($slug);
            if ($user->update_profile == "1" && $user->is_profile_approved == "0" && $active) {
                return 'javascript:void(0)';
            } else {
                return lang_base_url() . get_route("profile", true) . $slug;
            }
        }
    }
}

//generate profile url
if (!function_exists('generate_barter_product_url')) {
    function generate_barter_product_url($slug)
    {
        if (!empty($slug)) {
            return lang_base_url() . get_route("barter_product", true) . '/' . $slug;
        }
    }
}

if (!function_exists('generate_pincode_url')) {
    function generate_pincode_url($pincode)
    {
        if (!empty($slug)) {
            return lang_base_url() . get_route("pincode", true) . '/' . $pincode;
        }
    }
}

//generate static url
if (!function_exists('generate_url')) {
    function generate_url($route_1, $route_2 = null)
    {
        if (!empty($route_2)) {
            return lang_base_url() . get_route($route_1, true) . get_route($route_2);
        } else {
            return lang_base_url() . get_route($route_1);
        }
    }
}

//generate dash url
if (!function_exists('generate_dash_url')) {
    function generate_dash_url($route_1, $route_2 = null)
    {
        if (!empty($route_2)) {
            return dashboard_url() . get_route($route_1, true) . get_route($route_2);
        } else {
            return dashboard_url() . get_route($route_1);
        }
    }
}
//get seller by id
if (!function_exists('get_seller')) {
    function get_seller($id)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->auth_model->get_seller($id);
    }
}

//get user_cards
if (!function_exists('get_user_cards')) {
    function get_user_cards($id)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->profile_model->get_user_cards($id);
    }
}

if (!function_exists('get_user_addresses')) {
    function get_user_addresses($id)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->profile_model->get_user_addresses($id);
    }
}

if (!function_exists('get_address')) {
    function get_address($id)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->auth_model->get_address($id);
    }
}

if (!function_exists('get_user_by_slug')) {
    function get_user_by_slug($slug)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->auth_model->get_user_by_slug($slug);
    }
}


if (!function_exists('get_coupon_codes')) {
    function get_coupon_codes()
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->auth_model->get_coupon_codes();
    }
}


if (!function_exists('get_product_price')) {
    function get_product_price($id)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->product_model->get_product_price($id);
    }
}

if (!function_exists('get_shiprocket_order_details')) {
    function get_shiprocket_order_details($order_id, $product_id)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->product_model->get_shiprocket_order_details($order_id, $product_id);
    }
}

if (!function_exists('get_shiprocket_order_details_by_awb')) {
    function get_shiprocket_order_details_by_awb($awb_number)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->order_model->get_shiprocket_order_details_by_awb($awb_number);
    }
}

if (!function_exists('get_nowBike_order_details')) {
    function get_nowBike_order_details($order_id, $product_id)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->product_model->get_nowBike_order_details($order_id, $product_id);
    }
}

if (!function_exists('get_product_listing_price')) {
    function get_product_listing_price($id)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->product_model->get_product_listing_price($id);
    }
}

//get order shipping
if (!function_exists('get_order_shipping')) {
    function get_order_shipping($order_id)
    {
        $ci = &get_instance();
        return $ci->order_model->get_order_shipping($order_id);
    }
}



//generate menu item url
if (!function_exists('generate_menu_item_url')) {
    function generate_menu_item_url($item)
    {
        if (!empty($item)) {
            return lang_base_url() . $item->slug;
        }
    }
}

//delete file from server
if (!function_exists('delete_file_from_server')) {
    function delete_file_from_server($path)
    {
        $full_path = FCPATH . $path;
        if (strlen($path) > 15 && file_exists($full_path)) {
            @unlink($full_path);
        }
    }
}

//get user avatar
if (!function_exists('get_user_avatar')) {
    function get_user_avatar($user)
    {
        if (!empty($user)) {
            if (!empty($user->avatar) && file_exists(FCPATH . $user->avatar)) {
                return base_url() . $user->avatar;
            } elseif (!empty($user->avatar) && $user->user_type != "registered") {
                return $user->avatar;
            } else {
                return base_url() . "assets/img/user.png";
            }
        } else {
            return base_url() . "assets/img/user.png";
        }
    }
}

if (!function_exists('get_user_logo')) {
    function get_user_logo($user)
    {
        if (!empty($user)) {
            if (!empty($user->brand_logo) && file_exists(FCPATH . $user->brand_logo)) {
                return base_url() . $user->brand_logo;
            } elseif (!empty($user->brand_logo) && $user->user_type != "registered") {
                return $user->brand_logo;
            } else {
                return base_url() . "assets/img/brand_logo.jpg";
            }
        } else {
            return base_url() . "assets/img/brand_logo.jpg";
        }
    }
}

if (!function_exists('get_user_gst')) {
    function get_user_gst($user)
    {
        if (!empty($user)) {
            if (!empty($user->gst_image) && file_exists(FCPATH . $user->gst_image)) {
                return base_url() . $user->gst_image;
            } elseif (!empty($user->gst_image) && $user->user_type != "registered") {
                return $user->gst_image;
            } else {
                return base_url() . "assets/img/brand_logo.jpg";
            }
        } else {
            return base_url() . "assets/img/brand_logo.jpg";
        }
    }
}

if (!function_exists('get_user_pan')) {
    function get_user_pan($user)
    {
        if (!empty($user)) {
            if (!empty($user->pan_image) && file_exists(FCPATH . $user->pan_image)) {
                return base_url() . $user->pan_image;
            } elseif (!empty($user->pan_image) && $user->user_type != "registered") {
                return $user->pan_image;
            } else {
                return base_url() . "assets/img/brand_logo.jpg";
            }
        } else {
            return base_url() . "assets/img/brand_logo.jpg";
        }
    }
}

if (!function_exists('get_user_adhaar')) {
    function get_user_adhaar($user)
    {
        if (!empty($user)) {
            if (!empty($user->adhaar_image) && file_exists(FCPATH . $user->adhaar_image)) {
                return base_url() . $user->adhaar_image;
            } elseif (!empty($user->adhaar_image) && $user->user_type != "registered") {
                return $user->adhaar_image;
            } else {
                return base_url() . "assets/img/brand_logo.jpg";
            }
        } else {
            return base_url() . "assets/img/brand_logo.jpg";
        }
    }
}
if (!function_exists('get_user_cheque_image')) {
    function get_user_cheque_image($user)
    {
        if (!empty($user)) {
            if (!empty($user->cheque_image_url) && file_exists(FCPATH . $user->cheque_image_url)) {
                return base_url() . $user->cheque_image_url;
            } elseif (!empty($user->cheque_image_url) && $user->user_type != "registered") {
                return $user->cheque_image_url;
            } else {
                return  base_url() . $user->cheque_image_url;
            }
        }
    }
}
if (!function_exists('get_user_other')) {
    function get_user_other($user)
    {
        if (!empty($user)) {
            if (!empty($user->other_image) && file_exists(FCPATH . $user->other_image)) {
                return base_url() . $user->other_image;
            } elseif (!empty($user->other_image) && $user->user_type != "registered") {
                return $user->other_image;
            } else {
                return base_url() . "assets/img/brand_logo.jpg";
            }
        } else {
            return base_url() . "assets/img/brand_logo.jpg";
        }
    }
}


//get user avatar by id
if (!function_exists('get_user_avatar_by_id')) {
    function get_user_avatar_by_id($user_id)
    {
        $ci = &get_instance();

        $user = $ci->auth_model->get_user($user_id);
        if (!empty($user)) {
            if (!empty($user->avatar) && file_exists(FCPATH . $user->avatar)) {
                return base_url() . $user->avatar;
            } elseif (!empty($user->avatar) && $user->user_type != "registered") {
                return $user->avatar;
            } else {
                return base_url() . "assets/img/user.png";
            }
        } else {
            return base_url() . "assets/img/user.png";
        }
    }
}

//get user avatar by image url
if (!function_exists('get_user_avatar_by_image_url')) {
    function get_user_avatar_by_image_url($image_url, $user_type)
    {
        if (!empty($image_url)) {
            if ($user_type != "registered") {
                return $image_url;
            } else {
                return base_url() . $image_url;
            }
        } else {
            return base_url() . "assets/img/user.png";
        }
    }
}

//get review
if (!function_exists('get_review')) {
    function get_review($product_id, $user_id)
    {
        $ci = &get_instance();
        return $ci->review_model->get_review($product_id, $user_id);
    }
}







//get reject reason
if (!function_exists('get_reason')) {
    function get_reason($id)
    {
        $ci = &get_instance();
        $order_reason = $ci->order_model->get_reason($id);
        return $order_reason->reason;
    }
}

//get refund message
if (!function_exists('get_refund_message')) {
    function get_refund_message($order_id, $product_id)
    {
        $ci = &get_instance();
        return $ci->order_model->get_refund_message($order_id, $product_id);
    }
}





//calculate user rating
if (!function_exists('calculate_user_rating')) {
    function calculate_user_rating($user_id)
    {
        $ci = &get_instance();
        return $ci->review_model->calculate_user_rating($user_id);
    }
}

//date format
if (!function_exists('helper_date_format')) {
    function helper_date_format($datetime)
    {
        $date = date("j M Y", strtotime($datetime));
        $date = str_replace("Jan", trans("january"), $date);
        $date = str_replace("Feb", trans("february"), $date);
        $date = str_replace("Mar", trans("march"), $date);
        $date = str_replace("Apr", trans("april"), $date);
        $date = str_replace("May", trans("may"), $date);
        $date = str_replace("Jun", trans("june"), $date);
        $date = str_replace("Jul", trans("july"), $date);
        $date = str_replace("Aug", trans("august"), $date);
        $date = str_replace("Sep", trans("september"), $date);
        $date = str_replace("Oct", trans("october"), $date);
        $date = str_replace("Nov", trans("november"), $date);
        $date = str_replace("Dec", trans("december"), $date);
        return $date;
    }
}

//get logo
if (!function_exists('get_logo')) {
    function get_logo($settings)
    {
        if (!empty($settings)) {
            if (!empty($settings->logo) && file_exists(FCPATH . $settings->logo)) {
                return base_url() . $settings->logo;
            }
        }
        return base_url() . "assets/img/logo.png";
    }
}

//get logo email
if (!function_exists('get_logo_email')) {
    function get_logo_email($settings)
    {
        if (!empty($settings)) {
            if (!empty($settings->logo_email) && file_exists(FCPATH . $settings->logo_email)) {
                return base_url() . $settings->logo_email;
            }
        }
        return base_url() . "assets/img/logo.png";
    }
}

//get favicon
if (!function_exists('get_favicon')) {
    function get_favicon($settings)
    {
        if (!empty($settings)) {
            if (!empty($settings->favicon) && file_exists(FCPATH . $settings->favicon)) {
                return base_url() . $settings->favicon;
            }
        }
        return base_url() . "assets/img/favicon.png";
    }
}

//get page title
if (!function_exists('get_page_title')) {
    function get_page_title($page)
    {
        if (!empty($page)) {
            return html_escape($page->title);
        } else {
            return "";
        }
    }
}

//get page description
if (!function_exists('get_page_description')) {
    function get_page_description($page)
    {
        if (!empty($page)) {
            return html_escape($page->description);
        } else {
            return "";
        }
    }
}

//get page keywords
if (!function_exists('get_page_keywords')) {
    function get_page_keywords($page)
    {
        if (!empty($page)) {
            return html_escape($page->keywords);
        } else {
            return "";
        }
    }
}

//get page by default name
if (!function_exists('get_page_by_default_name')) {
    function get_page_by_default_name($default_name, $lang_id)
    {
        $ci = &get_instance();
        return $ci->page_model->get_page_by_default_name($default_name, $lang_id);
    }
}

//get call model to get the description
if (!function_exists('get_content')) {
    function get_content($label)
    {
        $ci = &get_instance();
        return $ci->page_model->get_content($label);
    }
}

//get call model to get the id
if (!function_exists('get_content_id')) {
    function get_content_id($label)
    {
        $ci = &get_instance();
        return $ci->page_model->get_content_id($label);
    }
}
// get call model to get the sms event description
//get call model to get the description
if (!function_exists('get_sms_content')) {
    function get_sms_content($label)
    {
        $ci = &get_instance();
        return $ci->page_model->get_sms_content($label);
    }
}

//get settings
if (!function_exists('get_settings')) {
    function get_settings()
    {
        $ci = &get_instance();
        $ci->load->model('settings_model');
        return $ci->settings_model->get_settings();
    }
}

//get general settings
if (!function_exists('get_general_settings')) {
    function get_general_settings()
    {
        $ci = &get_instance();
        $ci->load->model('settings_model');
        return $ci->settings_model->get_general_settings();
    }
}

//get form settings
if (!function_exists('get_form_settings')) {
    function get_form_settings()
    {
        $ci = &get_instance();
        $ci->load->model('settings_model');
        return $ci->settings_model->get_form_settings();
    }
}

//get product
if (!function_exists('get_product')) {
    function get_product($id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_product_by_id($id);
    }
}

//get digital sale by buyer id
if (!function_exists('get_digital_sale_by_buyer_id')) {
    function get_digital_sale_by_buyer_id($buyer_id, $product_id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_digital_sale_by_buyer_id($buyer_id, $product_id);
    }
}


if (!function_exists('get_order_product_seller_id')) {
    function get_order_product_seller_id($seller_id, $order_id)
    {
        $ci = &get_instance();
        return $ci->order_model->get_order_product_seller_id($seller_id, $order_id);
    }
}

//get digital sale by order id
if (!function_exists('get_digital_sale_by_order_id')) {
    function get_digital_sale_by_order_id($buyer_id, $product_id, $order_id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_digital_sale_by_order_id($buyer_id, $product_id, $order_id);
    }
}


if (!function_exists('get_sellers')) {
    function get_sellers()
    {
        $ci = &get_instance();
        return $ci->auth_model->get_sellers();
    }
}

//get product image
if (!function_exists('get_product_image')) {
    function get_product_image($product_id, $size_name)
    {
        $ci = &get_instance();
        $image = $ci->file_model->get_image_by_product($product_id);
        if (empty($image)) {
            return base_url() . 'assets/img/no-image.jpg';
        } else {
            if ($image->storage == "aws_s3") {
                return $ci->aws_base_url . "uploads/images/" . $image->$size_name;
            } else {
                return base_url() . "uploads/images/" . $image->$size_name;
            }
        }
    }
}

//get product image url
if (!function_exists('get_product_image_url')) {
    function get_product_image_url($image, $size_name)
    {
        if ($image->storage == "aws_s3") {
            $ci = &get_instance();
            return $ci->aws_base_url . "uploads/images/" . $image->$size_name;
        } else {
            return base_url() . "uploads/images/" . $image->$size_name;
        }
    }
}
if (!function_exists('get_size_chart_image_url')) {
    function get_size_chart_image_url($image)
    {

        $ci = &get_instance();

        return base_url() . $image;
    }
}

//get story image url
if (!function_exists('get_story_image_url')) {
    function get_story_image_url($image, $size_name)
    {
        if ($image->storage == "aws_s3") {
            $ci = &get_instance();
            return $ci->aws_base_url . "uploads/images/" . $image->$size_name;
        } else {
            return base_url() . "uploads/images/" . $image->$size_name;
        }
    }
}

//get product images
if (!function_exists('get_product_images')) {
    function get_product_images($product_id)
    {
        $ci = &get_instance();
        return $ci->file_model->get_product_images($product_id);
    }
}

if (!function_exists('')) {
    function get_variation_images_uncached($variation_id)
    {
        $ci = &get_instance();
        return $ci->file_model->get_variation_images_uncached($variation_id);
    }
}


//get file manager image
if (!function_exists('get_file_manager_image')) {
    function get_file_manager_image($image)
    {
        $path = base_url() . 'assets/img/no-image.jpg';
        $ci = &get_instance();
        if (!empty($image)) {
            if ($image->storage == "aws_s3") {
                $path = $ci->aws_base_url . "uploads/images-file-manager/" . $image->image_path;
            } else {
                $path = base_url() . "uploads/images-file-manager/" . $image->image_path;
            }
        }
        return $path;
    }
}

//get blog content image
if (!function_exists('get_blog_file_manager_image')) {
    function get_blog_file_manager_image($image)
    {
        $path = base_url() . 'assets/img/no-image.jpg';
        $ci = &get_instance();
        if (!empty($image)) {
            if ($image->storage == "aws_s3") {
                $path = $ci->aws_base_url . $image->image_path;
            } else {
                $path = base_url() . $image->image_path;
            }
        }
        return $path;
    }
}

//get variation main option image url
if (!function_exists('get_variation_main_option_image_url')) {
    function get_variation_main_option_image_url($option, $product_images = null)
    {
        $ci = &get_instance();
        $image_name = "";
        $storage = "";
        if (!empty($option)) {
            if ($option->is_default == 1 && !empty($product_images)) {
                foreach ($product_images as $product_image) {
                    if ($product_image->is_main == 1) {
                        $image_name = $product_image->image_small;
                        $storage = $product_image->storage;
                    }
                }
                if (empty($product_main_image)) {
                    foreach ($product_images as $product_image) {
                        $image_name = $product_image->image_small;
                        $storage = $product_image->storage;
                        break;
                    }
                }
            } else {
                $option_image = $ci->variation_model->get_variation_option_main_image($option->id);
                if (!empty($option_image)) {
                    $image_name = $option_image->image_small;
                    $storage = $option_image->storage;
                } else {
                    return "";
                }
            }
        }
        if ($storage == "aws_s3") {
            return $ci->aws_base_url . "uploads/images/" . $image_name;
        } else {
            return base_url() . "uploads/images/" . $image_name;
        }
    }
}

//get variation option image url
if (!function_exists('get_variation_option_image_url')) {
    function get_variation_option_image_url($option_image)
    {
        $ci = &get_instance();
        if ($option_image->storage == "aws_s3") {
            return $ci->aws_base_url . "uploads/images/" . $option_image->image_small;
        } else {
            return base_url() . "uploads/images/" . $option_image->image_small;
        }
    }
}

//get product video url
if (!function_exists('get_product_video_url')) {
    function get_product_video_url($video)
    {
        $path = "";
        $ci = &get_instance();
        if (!empty($video)) {
            if ($video->storage == "aws_s3") {
                $path = $ci->aws_base_url . "uploads/videos/" . $video->file_name;
            } else {
                $path = base_url() . "uploads/videos/" . $video->file_name;
            }
        }
        return $path;
    }
}


//get user story video url
if (!function_exists('get_user_video_url')) {
    function get_user_video_url($video)
    {
        $path = "";
        $ci = &get_instance();
        if (!empty($video)) {
            // if ($video->storage == "aws_s3") {
            //     $path = $ci->aws_base_url . "uploads/videos/" . $video->story;
            // } else {
            $path = base_url() . "uploads/videos/" . $video->story;
            // }
        }
        return $path;
    }
}

//get product digital file url
if (!function_exists('get_product_digital_file_url')) {
    function get_product_digital_file_url($digital_file)
    {
        $path = "";
        $ci = &get_instance();
        if (!empty($digital_file)) {
            if ($digital_file->storage == "aws_s3") {
                $path = $ci->aws_base_url . "uploads/digital-files/" . $digital_file->file_name;
            } else {
                $path = base_url() . "uploads/digital-files/" . $digital_file->file_name;
            }
        }
        return $path;
    }
}

//get product audio url
if (!function_exists('get_product_audio_url')) {
    function get_product_audio_url($audio)
    {
        $path = "";
        $ci = &get_instance();
        if (!empty($audio)) {
            if ($audio->storage == "aws_s3") {
                $path = $ci->aws_base_url . "uploads/audios/" . $audio->file_name;
            } else {
                $path = base_url() . "uploads/audios/" . $audio->file_name;
            }
        }
        return $path;
    }
}

//get product count by category
if (!function_exists('get_products_count_by_category')) {
    function get_products_count_by_category($category_id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_products_count_by_category($category_id);
    }
}



//get products
if (!function_exists('get_products')) {
    function get_products()
    {
        $ci = &get_instance();
        return $ci->product_model->get_products();
    }
}
//get product count by subcategory
if (!function_exists('get_products_count_by_subcategory')) {
    function get_products_count_by_subcategory($category_id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_products_count_by_subcategory($category_id);
    }
}

//get dropdown category id
if (!function_exists('get_dropdown_category_id')) {
    function get_dropdown_category_id()
    {
        $ci = &get_instance();
        $category_id = 0;
        $category_ids = $ci->input->post('category_id');
        if (!empty($category_ids)) {
            $category_ids = array_reverse($category_ids);
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


//get parent category id
if (!function_exists('get_parent_category_id')) {
    function get_parent_category_id()
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



//get custom field
if (!function_exists('get_custom_field')) {
    function get_custom_field($field_id)
    {
        $ci = &get_instance();
        return $ci->field_model->get_field($field_id);
    }
}

//get custom field name
if (!function_exists('get_custom_field_name')) {
    function get_custom_field_name($name_array, $lang_id, $get_main_name = true)
    {
        $ci = &get_instance();
        if (!empty($name_array)) {
            $name_array = unserialize_data($name_array);
            if (!empty($name_array)) {
                foreach ($name_array as $item) {
                    if ($item['lang_id'] == $lang_id) {
                        return html_escape($item['name']);
                    }
                }
            }
            //if not exist
            if ($get_main_name == true) {
                if (!empty($name_array)) {
                    foreach ($name_array as $item) {
                        if ($item['lang_id'] == $ci->site_lang->id) {
                            return html_escape($item['name']);
                        }
                    }
                }
            }
        }
        return "field";
    }
}

//get custom field option name
if (!function_exists('get_custom_field_option_name')) {
    function get_custom_field_option_name($option)
    {
        if (!empty($option)) {
            if (!empty($option->option_name)) {
                return $option->option_name;
            }
            if (!empty($option->second_name)) {
                return $option->second_name;
            }
        }
        return "";
    }
}

//get membership plan name
if (!function_exists('get_membership_plan_name')) {
    function get_membership_plan_name($title_array, $lang_id)
    {
        $ci = &get_instance();
        if (!empty($title_array)) {
            $array = unserialize_data($title_array);
            if (!empty($array)) {
                $main = "";
                foreach ($array as $item) {
                    if ($item['lang_id'] == $lang_id) {
                        return $item['title'];
                    }
                    if ($item['lang_id'] == $ci->site_lang->id) {
                        $main = $item['title'];
                    }
                }
                return $main;
            }
        }
        return "";
    }
}

//get membership plan features
if (!function_exists('get_membership_plan_features')) {
    function get_membership_plan_features($features_array, $lang_id)
    {
        $ci = &get_instance();
        if (!empty($features_array)) {
            $array = unserialize_data($features_array);
            if (!empty($array)) {
                $main = "";
                foreach ($array as $item) {
                    if ($item['lang_id'] == $lang_id) {
                        if (!empty($item['features'])) {
                            return $item['features'];
                        }
                    }
                    if ($item['lang_id'] == $ci->site_lang->id) {
                        if (!empty($item['features'])) {
                            $main = $item['features'];
                        }
                    }
                }
                return $main;
            }
        }
        return "";
    }
}

//get custom field options
if (!function_exists('get_custom_field_options')) {
    function get_custom_field_options($custom_field, $lang_id)
    {
        $ci = &get_instance();
        return $ci->field_model->get_field_options($custom_field, $lang_id);
    }
}

//get custom field product values
if (!function_exists('get_custom_field_product_values')) {
    function get_custom_field_product_values($custom_field, $product_id, $lang_id)
    {
        $ci = &get_instance();
        if ($custom_field->field_type == "text" || $custom_field->field_type == "textarea" || $custom_field->field_type == "number" || $custom_field->field_type == "date") {
            return $ci->field_model->get_product_custom_field_input_value($custom_field->id, $product_id);
        } else {
            $str = "";
            $i = 0;
            $option_values = $ci->field_model->get_product_custom_field_values($custom_field->id, $product_id, $lang_id);
            foreach ($option_values as $option_value) {
                if (!empty($option_value)) {
                    if ($i == 0) {
                        $str = get_custom_field_option_name($option_value);
                    } else {
                        $str .= ", " . get_custom_field_option_name($option_value);
                    }
                    $i++;
                }
            }
            return $str;
        }
    }
}

//get product wishlist count
if (!function_exists('get_product_wishlist_count')) {
    function get_product_wishlist_count($product_id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_product_wishlist_count($product_id);
    }
}

//get product wishlist count
if (!function_exists('get_user_wishlist_products_count')) {
    function get_user_wishlist_products_count($user_id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_user_wishlist_products_count($user_id);
    }
}

//get followers count
if (!function_exists('get_followers_count')) {
    function get_followers_count($following_id)
    {
        $ci = &get_instance();
        return $ci->profile_model->get_followers_count($following_id);
    }
}

//get following users count
if (!function_exists('get_following_users_count')) {
    function get_following_users_count($follower_id)
    {
        $ci = &get_instance();
        return $ci->profile_model->get_following_users_count($follower_id);
    }
}

//get user products count
if (!function_exists('get_user_products_count')) {
    function get_user_products_count($user_id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_user_products_count($user_id);
    }
}
//get lookup type values for feature type
if (!function_exists('get_lookup_values_by_type_custom')) {
    function get_lookup_values_by_type_custom($lookup_type)
    {
        $ci = &get_instance();
        return $ci->lookup_model->get_lookup_values_by_type_name($lookup_type);
    }
}
if (!function_exists('get_lookup_feature_id')) {
    function get_lookup_feature_id($lookup_type)
    {
        $ci = &get_instance();
        return $ci->lookup_model->get_lookup_feature_id($lookup_type);
    }
}
if (!function_exists('get_lookup_value_id')) {
    function get_lookup_value_id($lookup_type)
    {
        $ci = &get_instance();
        return $ci->lookup_model->get_lookup_value_id($lookup_type);
    }
}
//get lookup type values for feature type
if (!function_exists('get_list_lookup_value_predefined')) {
    function get_list_lookup_value_predefined($lookup_type)
    {
        $ci = &get_instance();
        return $ci->lookup_model->get_list_lookup_value_predefined($lookup_type);
    }
}


//get user products count
if (!function_exists('get_user_products')) {
    function get_user_products($user_id, $product_id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_user_products($user_id, $product_id);
    }
}
//get user products count
if (!function_exists('get_user_barter_products_count')) {
    function get_user_barter_products_count($user_id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_user_barter_products_count($user_id);
    }
}

//get user barter products

if (!function_exists('get_user_barter_products')) {
    function get_user_barter_products($user_id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_user_barter_products($user_id);
    }
}


if (!function_exists('get_supplier_by_supplier_speciality')) {
    function get_supplier_by_supplier_speciality($supplier_speciality)
    {
        $ci = &get_instance();
        return $ci->product_model->get_supplier_by_supplier_speciality($supplier_speciality);
    }
}
if (!function_exists('get_supplier_by_supplier_origin')) {
    function get_supplier_by_supplier_origin($origin_of_product)
    {
        $ci = &get_instance();
        return $ci->product_model->get_supplier_by_supplier_origin($origin_of_product);
    }
}
// if (!function_exists('get_product_by_discount')) {
//     function get_product_by_discount($discount)
//     {
//         $ci = &get_instance();
//         return $ci->product_model->get_product_by_discount($discount);
//     }
// }
//get user drafts count
if (!function_exists('get_user_downloads_count')) {
    function get_user_downloads_count($user_id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_user_downloads_count($user_id);
    }
}

//get product comment count
if (!function_exists('get_product_comment_count')) {
    function get_product_comment_count($product_id)
    {
        $ci = &get_instance();
        return $ci->comment_model->get_product_comment_count($product_id);
    }
}

//get product variation options
if (!function_exists('get_product_variation_options')) {
    function get_product_variation_options($variation_id)
    {
        $ci = &get_instance();
        return $ci->variation_model->get_variation_options($variation_id);
    }
}

//get grouped shipping options
if (!function_exists('get_grouped_shipping_options')) {
    function get_grouped_shipping_options()
    {
        $ci = &get_instance();
        return $ci->settings_model->get_grouped_shipping_options();
    }
}

//get order shipping
if (!function_exists('get_order_shipping')) {
    function get_order_shipping($order_id)
    {
        $ci = &get_instance();
        return $ci->order_model->get_order_shipping($order_id);
    }
}

//get shipping option by lang
if (!function_exists('get_shipping_option_by_lang')) {
    function get_shipping_option_by_lang($common_id, $lang_id)
    {
        $ci = &get_instance();
        return $ci->settings_model->get_shipping_option_by_lang($common_id, $lang_id);
    }
}

//get shipping option by key
if (!function_exists('get_shipping_option_by_key')) {
    function get_shipping_option_by_key($key, $lang_id)
    {
        $ci = &get_instance();
        return $ci->settings_model->get_shipping_option_by_key($key, $lang_id);
    }
}

//check user follows
if (!function_exists('is_user_follows')) {
    function is_user_follows($following_id, $follower_id)
    {
        $ci = &get_instance();
        return $ci->profile_model->is_user_follows($following_id, $follower_id);
    }
}

//get blog post
if (!function_exists('get_post')) {
    function get_post($id)
    {
        $ci = &get_instance();
        return $ci->blog_model->get_post_joined($id);
    }
}

//get blog image url
if (!function_exists('get_blog_image_url')) {
    function get_blog_image_url($post, $size_name)
    {
        if ($post->storage == "aws_s3") {
            $ci = &get_instance();
            return $ci->aws_base_url . $post->$size_name;
        } else {
            return base_url() . $post->$size_name;
        }
    }
}

//get blog categories
if (!function_exists('get_blog_categories')) {
    function get_blog_categories()
    {
        $ci = &get_instance();
        return $ci->blog_category_model->get_categories();
    }
}

//get blog post count by category
if (!function_exists('get_blog_post_count_by_category')) {
    function get_blog_post_count_by_category($category_id)
    {
        $ci = &get_instance();
        return $ci->blog_model->get_post_count_by_category($category_id);
    }
}

//get subcomments
if (!function_exists('get_subcomments')) {
    function get_subcomments($parent_id)
    {
        $ci = &get_instance();
        return $ci->comment_model->get_subcomments($parent_id);
    }
}

//get unread conversations count
if (!function_exists('get_unread_conversations_count')) {
    function get_unread_conversations_count($receiver_id)
    {
        $ci = &get_instance();
        return $ci->message_model->get_unread_conversations_count($receiver_id);
    }
}

//get conversation unread messages count
if (!function_exists('get_conversation_unread_messages_count')) {
    function get_conversation_unread_messages_count($conversation_id)
    {
        $ci = &get_instance();
        return $ci->message_model->get_conversation_unread_messages_count($conversation_id);
    }
}

//get new quote requests count
if (!function_exists('get_new_quote_requests_count')) {
    function get_new_quote_requests_count($user_id)
    {
        $ci = &get_instance();
        $ci->load->model('bidding_model');
        return $ci->bidding_model->get_new_quote_requests_count($user_id);
    }
}
//get new barter requests count
if (!function_exists('get_new_barter_requests_count')) {
    function get_new_barter_requests_count($user_id)
    {
        $ci = &get_instance();
        $ci->load->model('bidding_model');
        return $ci->bidding_model->get_new_barter_requests_count($user_id);
    }
}

//get language
if (!function_exists('get_language')) {
    function get_language($lang_id)
    {
        $ci = &get_instance();
        return $ci->language_model->get_language($lang_id);
    }
}


//get language
if (!function_exists('get_sale_count')) {
    function get_sale_count($product_id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_sale_count($product_id);
    }
}

//check language exist
if (!function_exists('check_language_exist')) {
    function check_language_exist($lang_id)
    {
        $ci = &get_instance();
        $result = 0;
        if (!empty($ci->languages)) {
            foreach ($ci->languages as $language) {
                if ($lang_id == $language->id) {
                    $result = 1;
                    break;
                }
            }
        }
        return $result;
    }
}

//get countries
if (!function_exists('get_countries')) {
    function get_countries()
    {
        $ci = &get_instance();
        return $ci->location_model->get_countries();
    }
}

//get country
if (!function_exists('get_country')) {
    function get_country($id)
    {
        $ci = &get_instance();
        return $ci->location_model->get_country($id);
    }
}

//get state
if (!function_exists('get_state')) {
    function get_state($id)
    {
        $ci = &get_instance();
        return $ci->location_model->get_state($id);
    }
}
if (!function_exists('get_india_cities')) {
    function get_india_cities()
    {
        $ci = &get_instance();
        return $ci->location_model->get_india_cities();
    }
}

if (!function_exists('get_usp')) {
    function get_usp()
    {
        $ci = &get_instance();
        return $ci->profile_model->get_usp();
    }
}
if (!function_exists('get_exempted_food')) {
    function get_exempted_food()
    {
        $ci = &get_instance();
        return $ci->profile_model->get_exempted_food();
    }
}
if (!function_exists('get_pincode')) {
    function get_pincode($pincode)
    {
        $ci = &get_instance();
        return $ci->auth_model->get_pincode($pincode);
    }
}

//get city
if (!function_exists('get_city')) {
    function get_city($id)
    {
        $ci = &get_instance();
        return $ci->location_model->get_city($id);
    }
}


//get states by country
if (!function_exists('get_states_by_country')) {
    function get_states_by_country($country_id)
    {
        $ci = &get_instance();
        return $ci->location_model->get_states_by_country($country_id);
    }
}

//get ad codes
if (!function_exists('get_ad_codes')) {
    function get_ad_codes($ad_space)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->ad_model->get_ad_codes($ad_space);
    }
}

//get recaptcha
if (!function_exists('generate_recaptcha')) {
    function generate_recaptcha()
    {
        $ci = &get_instance();
        if ($ci->recaptcha_status) {
            $ci->load->library('recaptcha');
            echo '<div class="form-group">';
            echo $ci->recaptcha->getWidget();
            echo $ci->recaptcha->getScriptTag();
            echo ' </div>';
        }
    }
}

//reset flash data
if (!function_exists('reset_flash_data')) {
    function reset_flash_data()
    {
        $ci = &get_instance();
        $ci->session->set_flashdata('errors', "");
        $ci->session->set_flashdata('error', "");
        $ci->session->set_flashdata('success', "");
    }
}

//get location
if (!function_exists('get_location')) {
    function get_location($object)
    {
        $ci = &get_instance();
        $location = "";
        if (!empty($object)) {
            if (!empty($object->address)) {
                $location = $object->address;
            }
            if (!empty($object->zip_code)) {
                $location .= " " . $object->zip_code;
            }
            if (!empty($object->city_id)) {
                $city = $ci->location_model->get_city($object->city_id);
                if (!empty($city)) {
                    if (!empty($object->address) || !empty($object->zip_code)) {
                        $location .= " ";
                    }
                    $location .= $city->name;
                }
            }
            if (!empty($object->state_id)) {
                $state = $ci->location_model->get_state($object->state_id);
                if (!empty($state)) {
                    if (!empty($object->address) || !empty($object->zip_code) || !empty($object->city_id)) {
                        $location .= ", ";
                    }
                    $location .= $state->name;
                }
            }
            if (!empty($object->country_id)) {
                $country = $ci->location_model->get_country($object->country_id);
                if (!empty($country)) {
                    if (!empty($object->state_id) || $object->city_id || !empty($object->address) || !empty($object->zip_code)) {
                        $location .= ", ";
                    }
                    $location .= $country->name;
                }
            }
        }
        return $location;
    }
}
if (!function_exists('get_supplier_location')) {
    function get_supplier_location($object)
    {
        $ci = &get_instance();
        $location = "";
        if (!empty($object)) {
            if (!empty($object->house_no)) {
                $location = $object->house_no;
            }

            if (!empty($object->supplier_area)) {

                $location .= " " . $object->supplier_area;
            }
            if (!empty($object->supplier_city)) {

                $location .= " " . $object->supplier_city;
            }
            if (!empty($object->supplier_state)) {
                $location .= " " . $object->supplier_state;
            }
            if (!empty($object->pincode)) {
                $location .= " " . $object->pincode;
            }
            if (!empty($object->country_id)) {
                $location .= " " . 'India';
            }
            return $location;
        }
    }
}

//get city
if (!function_exists('get_supplier_city')) {
    function get_supplier_city($object)
    {
        $ci = &get_instance();
        $location = "";
        if (!empty($object)) {
            if (!empty($object->supplier_city)) {
                $location = $object->supplier_city;
            }
        }
        return $location;
    }
}

//get location input
if (!function_exists('get_default_location_input')) {
    function get_default_location_input()
    {
        $ci = &get_instance();
        return $ci->location_model->get_default_location_input();
    }
}

//set cached data by lang
if (!function_exists('set_cache_data')) {
    function set_cache_data($key, $data)
    {
        $ci = &get_instance();
        if ($ci->general_settings->cache_system == 1) {
            $ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            $ci->cache->save($key, $data, $ci->general_settings->cache_refresh_time);
        }
    }
}

//get cached data by lang
if (!function_exists('get_cached_data')) {
    function get_cached_data($key)
    {
        $ci = &get_instance();
        if ($ci->general_settings->cache_system == 1) {
            $ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            if ($data = $ci->cache->get($key)) {
                return $data;
            }
        }
        return false;
    }
}

//reset cache data
if (!function_exists('reset_cache_data')) {
    function reset_cache_data()
    {
        $ci = &get_instance();
        $path = $ci->config->item('cache_path');
        $cache_path = ($path == '') ? APPPATH . 'cache/' : $path;
        $handle = opendir($cache_path);
        while (($file = readdir($handle)) !== FALSE) {
            //Leave the directory protection alone
            if ($file != '.htaccess' && $file != 'index.html') {
                @unlink($cache_path . '/' . $file);
            }
        }
        closedir($handle);
    }
}

//reset user cache data
if (!function_exists('reset_user_cache_data')) {
    function reset_user_cache_data($user_id)
    {
        $ci = &get_instance();
        $path = $ci->config->item('cache_path');
        $cache_path = ($path == '') ? APPPATH . 'cache/' : $path;
        $handle = opendir($cache_path);
        while (($file = readdir($handle)) !== FALSE) {
            //Leave the directory protection alone
            if ($file != '.htaccess' && $file != 'index.html') {
                if (strpos($file, 'user' . $user_id . 'cache') !== false) {
                    @unlink($cache_path . '/' . $file);
                }
            }
        }
        closedir($handle);
    }
}

//reset product img cache data
if (!function_exists('reset_product_img_cache_data')) {
    function reset_product_img_cache_data($product_id)
    {
        $ci = &get_instance();
        $path = $ci->config->item('cache_path');
        $cache_path = ($path == '') ? APPPATH . 'cache/' : $path;
        $handle = opendir($cache_path);
        while (($file = readdir($handle)) !== FALSE) {
            //Leave the directory protection alone
            if ($file != '.htaccess' && $file != 'index.html') {
                if (strpos($file, 'img_product_' . $product_id) !== false) {
                    @unlink($cache_path . '/' . $file);
                }
            }
        }
        closedir($handle);
    }
}

//reset cache data on change
if (!function_exists('reset_cache_data_on_change')) {
    function reset_cache_data_on_change()
    {
        $ci = &get_instance();
        if ($ci->general_settings->refresh_cache_database_changes == 1) {
            reset_cache_data();
        }
    }
}

//cart product count
if (!function_exists('get_cart_product_count')) {
    function get_cart_product_count()
    {
        $ci = &get_instance();
        if (!empty($ci->session->userdata('mds_shopping_cart'))) {
            return @count($ci->session->userdata('mds_shopping_cart'));
        } else {
            return 0;
        }
    }
}




//cart product count- test
if (!function_exists('get_cart_product_count_ajax')) {
    function get_cart_product_count_ajax()
    {
        $ci = &get_instance();
        if (!empty($ci->session->userdata('mds_shopping_cart'))) {
            return @count($ci->session->userdata('mds_shopping_cart'));
        } else {
            return 0;
        }
    }
}





//date diff
if (!function_exists('date_difference')) {
    function date_difference($end_date, $start_date, $format = '%a')
    {
        $datetime_1 = date_create($end_date);
        $datetime_2 = date_create($start_date);
        $diff = date_diff($datetime_1, $datetime_2);
        $day = $diff->format($format) + 1;
        if ($start_date > $end_date) {
            $day = 0 - $day;
        }
        return $day;
    }
}

//sort array by key
// if (!function_exists('sort_array_by_key')) {
//     function sort_array_by_key($array, $key)
//     {
//         if (!empty($array) && isset($array[$key])) {
//             usort($array, function ($a, $b) {
//                 return $a->$key > $b->$key;
//             });
//         }
//         return $array;
//     }
// }

//get array column values
if (!function_exists('get_array_column_values')) {
    function get_array_column_values($array, $column)
    {
        $values = array();
        if (!empty($array) && !empty($column)) {
            foreach ($array as $item) {
                if (!empty($item)) {
                    if (is_object($item)) {
                        if (!empty($item->$column)) {
                            $values[] = $item->$column;
                        }
                    } else {
                        if (!empty($item[$column])) {
                            $values[] = $item[$column];
                        }
                    }
                }
            }
        }
        return $values;
    }
}

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

//get checkbox value
if (!function_exists('get_checkbox_value')) {
    function get_checkbox_value($input_post)
    {
        if (empty($input_post)) {
            return 0;
        } else {
            return 1;
        }
    }
}

//get product listing type
if (!function_exists('get_product_listing_type')) {
    function get_product_listing_type($product)
    {
        if (!empty($product)) {
            if ($product->listing_type == 'sell_on_site') {
                return trans("add_product_for_sale");
            }
            if ($product->listing_type == 'ordinary_listing') {
                return trans("add_product_services_listing");
            }
        }
    }
}


//is value exists in array
if (!function_exists('is_value_in_array')) {
    function is_value_in_array($value, $array)
    {
        if (empty($array))
            return false;
        if (!is_array($array))
            return false;
        if (in_array($value, $array)) {
            return true;
        }
        return false;
    }
}

//get first value of array
if (!function_exists('get_first_array_value')) {
    function get_first_array_value($array)
    {
        if (empty($array)) {
            return '';
        }
        return html_escape(@$array[0]);
    }
}

//generate unique id
if (!function_exists('generate_unique_id')) {
    function generate_unique_id()
    {
        $id = uniqid("", TRUE);
        $id = str_replace(".", "-", $id);
        return $id . "-" . rand(10000000, 99999999);
    }
}

//generate short unique id
if (!function_exists('generate_short_unique_id')) {
    function generate_short_unique_id()
    {
        $id = uniqid("", TRUE);
        return str_replace(".", "-", $id);
    }
}
//generate order number
if (!function_exists('generate_transaction_number')) {
    function generate_transaction_number()
    {
        $transaction_number = uniqid("", TRUE);
        return str_replace(".", "-", $transaction_number);
    }
}

//generate token
if (!function_exists('generate_token')) {
    function generate_token()
    {
        $token = uniqid("", TRUE);
        $token = str_replace(".", "-", $token);
        return $token . "-" . rand(10000000, 99999999);
    }
}

//generate purchase code
if (!function_exists('generate_purchase_code')) {
    function generate_purchase_code()
    {
        $id = uniqid("", TRUE);
        $id = str_replace(".", "-", $id);
        $id .= "-" . rand(100000, 999999);
        $id .= "-" . rand(100000, 999999);
        return $id;
    }
}

//generate slug
if (!function_exists('str_slug')) {
    function str_slug($str)
    {
        $str = trim($str);
        return url_title(convert_accented_characters($str), "-", true);
    }
}

//clean slug
if (!function_exists('clean_slug')) {
    function clean_slug($slug)
    {
        $ci = &get_instance();
        $slug = urldecode($slug);
        $slug = $ci->security->xss_clean($slug);
        $slug = remove_special_characters($slug, true);
        return $slug;
    }
}

//clean number
if (!function_exists('clean_number')) {
    function clean_number($num)
    {
        $ci = &get_instance();
        $num = @trim($num);
        $num = $ci->security->xss_clean($num);
        $num = intval($num);
        return $num;
    }
}

//clean string
if (!function_exists('clean_str')) {
    function clean_str($str)
    {
        $ci = &get_instance();
        $str = trim($str);
        $str = strip_tags($str);
        $str = $ci->security->xss_clean($str);
        $str = remove_special_characters($str, false);
        return $str;
    }
}

//remove special characters
if (!function_exists('remove_special_characters')) {
    function remove_special_characters($str, $is_slug = false)
    {
        $str = trim($str);
        $str = str_replace('#', '', $str);
        $str = str_replace(';', '', $str);
        $str = str_replace('!', '', $str);
        $str = str_replace('"', '', $str);
        $str = str_replace('$', '', $str);
        $str = str_replace('%', '', $str);
        $str = str_replace('(', '', $str);
        $str = str_replace(')', '', $str);
        $str = str_replace('*', '', $str);
        $str = str_replace('+', '', $str);
        $str = str_replace('/', '', $str);
        $str = str_replace('\'', '', $str);
        $str = str_replace('<', '', $str);
        $str = str_replace('>', '', $str);
        $str = str_replace('=', '', $str);
        $str = str_replace('?', '', $str);
        $str = str_replace('[', '', $str);
        $str = str_replace(']', '', $str);
        $str = str_replace('\\', '', $str);
        $str = str_replace('^', '', $str);
        $str = str_replace('`', '', $str);
        $str = str_replace('{', '', $str);
        $str = str_replace('}', '', $str);
        $str = str_replace('|', '', $str);
        $str = str_replace('~', '', $str);
        if ($is_slug == true) {
            $str = str_replace(" ", '-', $str);
            $str = str_replace("'", '', $str);
        }
        return $str;
    }
}

//remove forbidden characters
if (!function_exists('remove_forbidden_characters')) {
    function remove_forbidden_characters($str)
    {
        $str = str_replace(';', '', $str);
        $str = str_replace('"', '', $str);
        $str = str_replace('$', '', $str);
        $str = str_replace('%', '', $str);
        $str = str_replace('*', '', $str);
        $str = str_replace('/', '', $str);
        $str = str_replace('\'', '', $str);
        $str = str_replace('<', '', $str);
        $str = str_replace('>', '', $str);
        $str = str_replace('=', '', $str);
        $str = str_replace('?', '', $str);
        $str = str_replace('[', '', $str);
        $str = str_replace(']', '', $str);
        $str = str_replace('\\', '', $str);
        $str = str_replace('^', '', $str);
        $str = str_replace('`', '', $str);
        $str = str_replace('{', '', $str);
        $str = str_replace('}', '', $str);
        $str = str_replace('|', '', $str);
        $str = str_replace('~', '', $str);
        return $str;
    }
}

if (!function_exists('time_ago')) {
    function time_ago($timestamp)
    {
        $time_ago = strtotime($timestamp);
        $current_time = time();
        $time_difference = $current_time - $time_ago;
        $seconds = $time_difference;
        $minutes = round($seconds / 60);           // value 60 is seconds
        $hours = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec
        $days = round($seconds / 86400);          //86400 = 24 * 60 * 60;
        $weeks = round($seconds / 604800);          // 7*24*60*60;
        $months = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60
        $years = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60
        if ($seconds <= 60) {
            return trans("just_now");
        } else if ($minutes <= 60) {
            if ($minutes == 1) {
                return "1 " . trans("minute_ago");
            } else {
                return "$minutes " . trans("minutes_ago");
            }
        } else if ($hours <= 24) {
            if ($hours == 1) {
                return "1 " . trans("hour_ago");
            } else {
                return "$hours " . trans("hours_ago");
            }
        } else if ($days <= 30) {
            if ($days == 1) {
                return "1 " . trans("day_ago");
            } else {
                return "$days " . trans("days_ago");
            }
        } else if ($months <= 12) {
            if ($months == 1) {
                return "1 " . trans("month_ago");
            } else {
                return "$months " . trans("months_ago");
            }
        } else {
            if ($years == 1) {
                return "1 " . trans("year_ago");
            } else {
                return "$years " . trans("years_ago");
            }
        }
    }
}

if (!function_exists('is_user_online')) {
    function is_user_online($timestamp)
    {
        $time_ago = strtotime($timestamp);
        $current_time = time();
        $time_difference = $current_time - $time_ago;
        $seconds = $time_difference;
        $minutes = round($seconds / 60);
        if ($minutes <= 2) {
            return true;
        } else {
            return false;
        }
    }
}

//print date
if (!function_exists('formatted_date')) {
    function formatted_date($timestamp)
    {
        return date("Y-m-d / H:i", strtotime($timestamp));
    }
}

//print formatted hour
if (!function_exists('formatted_hour')) {
    function formatted_hour($timestamp)
    {
        return date("H:i", strtotime($timestamp));
    }
}

if (!function_exists('convert_to_xml_character')) {
    function convert_to_xml_character($string)
    {
        return str_replace(array('&', '<', '>', '\'', '"'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $string);
    }
}

//check admin nav
if (!function_exists('is_admin_nav_active')) {
    function is_admin_nav_active($array_nav_items)
    {
        $ci = &get_instance();
        $segment2 = @$ci->uri->segment(2);
        if (!empty($segment2) && !empty($array_nav_items)) {
            if (in_array($segment2, $array_nav_items)) {
                echo ' ' . 'active';
            }
        }
    }
}

//get csv value
if (!function_exists('get_csv_value')) {
    function get_csv_value($array, $key, $data_type = 'string')
    {
        if (!empty($array)) {
            if (!empty($array[$key])) {
                return $array[$key];
            }
        }
        if ($data_type == 'int') {
            return 0;
        }
        return "";
    }
}

//date difference in hours
if (!function_exists('date_difference_in_hours')) {
    function date_difference_in_hours($date1, $date2)
    {
        $datetime_1 = date_create($date1);
        $datetime_2 = date_create($date2);
        $diff = date_diff($datetime_1, $datetime_2);
        $days = $diff->format('%a');
        $hours = $diff->format('%h');
        return $hours + ($days * 24);
    }
}

//check cron time
if (!function_exists('check_cron_time')) {
    function check_cron_time()
    {
        $ci = &get_instance();
        if (empty($ci->general_settings->last_cron_update) || date_difference_in_hours(date('Y-m-d H:i:s'), $ci->general_settings->last_cron_update) >= 6) {
            return true;
        }
        return false;
    }
}

if (!function_exists('add_https')) {
    function add_https($url)
    {
        if (!empty(trim($url))) {
            if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                if (strpos(base_url(), 'https://') !== false) {
                    $url = "https://" . $url;
                } else {
                    $url = "http://" . $url;
                }
            }
            return $url;
        }
    }
}

//like story image functionality
if (!function_exists('story_image_liked')) {
    function story_image_liked($image_id, $user_id)
    {
        $ci = &get_instance();
        return $ci->like_model->image_liked($image_id, $user_id);
    }
}


//count like story image
if (!function_exists('count_story_image')) {
    function count_story_image($image_id, $user_id)
    {
        $ci = &get_instance();
        return $ci->like_model->count_likes($image_id, $user_id);
    }
}


if (!function_exists('get_order_product_by_id')) {
    function get_order_product_by_id($order_id)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->order_admin_model->get_order_product_by_id($order_id);
    }
}
if (!function_exists('get_order_product')) {
    function get_order_product($order_id)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->order_model->get_order_product($order_id);
    }
}
if (!function_exists('get_order_product_by_orderid')) {
    function get_order_product_by_orderid($order_id)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->order_model->get_order_product_by_orderid($order_id);
    }
}

if (!function_exists('get_order_products_by_orderid')) {
    function get_order_products_by_orderid($order_id)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->order_model->get_order_products_by_orderid($order_id);
    }
}
if (!function_exists('get_sale_count_as_per_status')) {
    function get_sale_count_as_per_status($product_id, $order_status)
    {
        $ci = &get_instance();
        return $ci->product_model->get_sale_count_as_per_status($product_id, $order_status);
    }
}

if (!function_exists('get_sale_count_as_per_incomplete_status')) {
    function get_sale_count_as_per_incomplete_status($product_id)
    {
        $ci = &get_instance();
        return $ci->product_model->get_sale_count_as_per_incomplete_status($product_id);
    }
}

if (!function_exists('get_sale_count_as_per_status_and_user')) {
    function get_sale_count_as_per_status_and_user($user_id, $product_id, $order_status)
    {
        $ci = &get_instance();
        return $ci->product_model->get_sale_count_as_per_status_and_user($user_id, $product_id, $order_status);
    }
}

if (!function_exists('get_product_id_by_seller_id')) {
    function get_product_id_by_seller_id($user_id, $order_status)
    {
        $ci = &get_instance();
        return $ci->product_model->get_product_id_by_seller_id($user_id, $order_status);
    }
}

if (!function_exists('get_sign_by_seller_id')) {
    function get_sign_by_seller_id($seller_id)
    {
        $ci = &get_instance();
        return $ci->order_model->get_sign_by_seller_id($seller_id);
    }
}


//get user shipping type by user id
if (!function_exists('get_user_shipping_type')) {
    function get_user_shipping_type($user_id)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->auth_model->get_user_shipping_type($user_id);
    }
}

//get user shipping type by user id
if (!function_exists('get_user_shipping_threshold')) {
    function get_user_shipping_threshold($id)
    {
        // Get a reference to the controller object
        $ci = &get_instance();
        return $ci->auth_model->get_user_shipping_threshold($id);
    }
}


if (!function_exists('dispatch_time')) {
    function dispatch_time($lead_time, $type = "days")
    {
        $lead_days = intval($lead_time / 86400);
        if ($type == "days") :
            if ($lead_days > 1) {
                return $lead_days . " days";
            } else {
                return $lead_days . " day";
            }
        endif;
        $lead_date = time() + $lead_time;
        if ($type == "date")
            return date("d-m-Y", $lead_date);
    }
}

//Formulize a breadcrumb
if (!function_exists('get_group_feature')) {
    function get_group_feature($type)
    {
        $ci = &get_instance();
        $name = $ci->product_model->get_group_feature($type);
        return $name[0]->meaning;
    }
}




//Formulize a breadcrumb
if (!function_exists('get_lookup_image_url')) {
    function get_lookup_image_url($lookup_code)
    {
        $ci = &get_instance();
        $row = $ci->lookup_model->get_lookup_image_url($lookup_code);
        return $row->image_url;
    }
}


if (!function_exists('get_fssai_action')) {
    function get_fssai_action($user_id)
    {
        $ci = &get_instance();
        $row = $ci->profile_model->get_fssai_action($user_id);
        if (!empty($row)) :
            return $row->action;
        else :
            return $ci->profile_model->check_for_fssai_undertaking($user_id);
        endif;
    }
}

//get cod changes and shipping changes seller wise
if (!function_exists('get_shipping_cod_changes_seller_wise')) {
    function get_shipping_cod_changes_seller_wise($sellerid, $order_id)
    {
        $ci = &get_instance();
        return $ci->order_model->get_charges_seller_wise($sellerid, $order_id);
        // return "sanyam";
    }
}

//Formulize a breadcrumb

if (!function_exists('breadcrumbs')) {
    function breadcrumbs()
    {
        $home = '';
        $separator = '';

        // This gets the REQUEST_URI (/path/to/file.php), splits the string (using '/') into an array, and then filters out any empty values
        $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
        // var_dump($_SERVER['HTTP_HOST']);
        // exit;

        $base = base_url();


        // Initialize a temporary array with our breadcrumbs. (starting with our home page, which I'm assuming will be the base URL)
        $breadcrumbs = array();


        // Find out the index for the last value in our path array
        $last = $path[count($path)];


        if ($_SERVER["HTTP_HOST"] == "localhost") {
            array_shift($path);
        }
        // var_dump($path);
        // die();
        // Build the rest of the breadcrumbs
        foreach ($path as $x => $crumb) {
            // Our "title" is the text that will be displayed (strip out .php and turn '_' into a space)
            $title = ucwords(str_replace(array('.php', '_'), array('', ' '), $crumb));
            // If we are not on the last index, then display an <a> tag
            if ($x != count($path) - 1) {
                if (($crumb != 'gharobar' && $crumb != 'gharobaar') || ($title != 'Gharobar' && $title != 'Gharobaar')) {
                    $breadcrumbs[] = "<a href=\"$base#$crumb\">$title</a>";
                }
            } else {
                $breadcrumbs[] = $title;
            }
        }
        // Build our temporary array (pieces of bread) into one big string :)
        // return implode($separator, $breadcrumbs);
        return $breadcrumbs;
    }


    if (!function_exists('get_last_ordered_products')) {
        function get_last_ordered_products($order_id)
        {
            $ci = &get_instance();
            $rate_last_order = $ci->cart_model->get_last_ordered_products($order_id);
            return $rate_last_order;
        }
    }
}
