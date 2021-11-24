<?php
defined('BASEPATH') or exit('No direct script access allowed');
//get route
function getr($key, $rts)
{
    if (!empty($rts)) {
        if (!empty($rts->$key)) {
            return $rts->$key;
        }
    }
    return $key;
}


/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$rts = $this->config->item('routes');

$route['default_controller'] = 'home_controller';
$route['404_override'] = 'home_controller/error_404';
$route['translate_uri_dashes'] = FALSE;
$route['error-404'] = 'home_controller/error_404';

$general_settings = $this->config->item('general_settings');
$languages = $this->config->item('languages');
foreach ($languages as $language) {
    if ($language->status == 1) {
        $key = "";
        if ($general_settings->site_lang != $language->id) {
            $key = $language->short_form . '/';
            $route[$language->short_form] = 'home_controller/index';
            $route[$key . '/error-404'] = 'home_controller/error_404';
        }
        //auth
        $route[$key . getr('register', $rts)]['GET'] = 'auth_controller/register';
        $route[$key . getr('register-seller', $rts)]['GET'] = 'auth_controller/register_seller';
        $route[$key . getr('forgot_password', $rts)]['GET'] = 'auth_controller/forgot_password';
        $route[$key . getr('reset_password', $rts)]['GET'] = 'auth_controller/reset_password';
        $route[$key . 'confirm']['GET'] = 'auth_controller/confirm_email';
        $route[$key . 'why_sell_with_us']['GET'] = 'auth_controller/why_sell_with_us';

        //dashboard
        $route[$key . getr('dashboard', $rts)]['GET'] = 'dashboard_controller/index';

        $route[$key . getr('barterproduct', $rts) . '/(:any)']['GET'] = 'home_controller/any_barter/$1';

        //profile
        $route[$key . getr('barter_product', $rts) . '/(:any)']['GET'] = 'profile_controller/barter_product/$1';

        $route[$key . getr('profile', $rts) . '/(:any)']['GET'] = 'profile_controller/profile/$1';
        $route[$key . getr('profile-buyer', $rts) . '/(:any)']['GET'] = 'profile_controller/buyer_profile/$1';
        $route[$key . getr('update_profile1', $rts) . '/(:any)']['GET'] = 'membership_controller/update_profile1/$1';
        $route[$key . getr('wishlist', $rts) . '/(:any)']['GET'] = 'profile_controller/wishlist/$1';

        $route[$key . getr('pincode', $rts) . '/(:any)']['GET'] = 'auth_controller/pincode/$1';

        $route[$key . getr('wishlist', $rts)]['GET'] = 'home_controller/guest_wishlist/$1';
        $route[$key . getr('followers', $rts) . '/(:any)']['GET'] = 'profile_controller/followers/$1';
        $route[$key . getr('following', $rts) . '/(:any)']['GET'] = 'profile_controller/following/$1';
        $route[$key . getr('stories', $rts) . '/(:any)']['GET'] = 'profile_controller/stories/$1';
        $route[$key . getr('reviews', $rts) . '/(:any)']['GET'] = 'profile_controller/reviews/$1';
        /*settings*/

        $route[$key . getr('settings', $rts)]['GET'] = 'profile_controller/update_profile';
        $route[$key . getr('settings', $rts) . '/' . getr('update_profile', $rts)]['GET'] = 'profile_controller/update_profile';
        $route[$key . getr('settings', $rts) . '/' . getr('update_settings', $rts)]['GET'] = 'profile_controller/update_settings';
        $route[$key . getr('settings', $rts) . '/' . getr('personal_information', $rts)]['GET'] = 'profile_controller/personal_information';
        $route[$key . getr('settings', $rts) . '/' . getr('social_media', $rts)]['GET'] = 'profile_controller/social_media';
        $route[$key . getr('settings', $rts) . '/' . getr('social_media_seller', $rts)]['GET'] = 'profile_controller/social_media_seller';
        $route[$key . getr('settings', $rts) . '/' . getr('change_password', $rts)]['GET'] = 'profile_controller/change_password';
        $route[$key . getr('settings', $rts) . '/' . getr('shipping_address', $rts)]['GET'] = 'profile_controller/shipping_address';
        $route[$key . getr('settings', $rts) . '/' . getr('update_seller_info', $rts)]['GET'] = 'profile_controller/update_seller_info';

        $route[$key . getr('order_test', $rts) . '/(:num)']['GET'] = 'order_controller/order_test/$1';


        $route[$key . getr('profile_settings', $rts)]['GET'] = 'profile_controller/update_profile_dashboard';
        $route[$key . getr('social_media_settings', $rts)]['GET'] = 'profile_controller/social_media_dashboard';
        $route[$key . getr('password_settings', $rts)]['GET'] = 'profile_controller/change_password_dashboard';
        $route[$key . getr('password_settings_seller', $rts)]['GET'] = 'profile_controller/change_password_dashboard_seller';


        //  $route[$key . getr('settings', $rts) . '/' . getr('update_story', $rts)]['GET'] = 'profile_controller/update_story';
        $route[$key . getr('settings', $rts) . '/' . getr('update_seller_info_services', $rts)]['GET'] = 'profile_controller/update_seller_info_services';
        $route[$key . getr('members', $rts)]['GET'] = 'home_controller/members';
        $route[$key . getr('members_speciality', $rts)]['GET'] = 'home_controller/members_speciality';
        $route[$key . getr('members_barter', $rts)]['GET'] = 'dashboard_controller/members_barter';
        /*product*/
        $route[$key . getr('select_membership_plan', $rts)]['GET'] = 'home_controller/renew_membership_plan';
        $route[$key . getr('start_selling', $rts) . '/' . getr('select_membership_plan', $rts)]['GET'] = 'home_controller/select_membership_plan';
        $route[$key . getr('start_selling', $rts)]['GET'] = 'home_controller/start_selling';
        $route[$key . getr('search', $rts)]['GET'] = 'home_controller/search';
        $route[$key . getr('search_member', $rts)]['GET'] = 'dashboard_controller/search_member';
        $route[$key . getr('search_pincode', $rts)]['GET'] = 'home_controller/search_pincode';
        $route[$key . getr('products', $rts)]['GET'] = 'home_controller/products';
        $route[$key . getr('member_products', $rts)]['GET'] = 'home_controller/member_products';
        $route[$key . getr('top_picks_products', $rts)]['GET'] = 'home_controller/top_pick_products';
        $route[$key . getr('shop_by_random', $rts) . '/(:any)']['GET'] = 'home_controller/products_shop_by_random/$1';
        $route[$key . getr('downloads', $rts)]['GET'] = 'profile_controller/downloads';
        $route[$key . getr('shop_by_concern', $rts) . '/(:any)']['GET'] = 'home_controller/products_shop_by_concern/$1';

        $route[$key . getr('shop-by-concern', $rts)]['GET'] = 'home_controller/shop_by_concern';
        //for shop by seller
        $route[getr('shop-by-seller', $rts)] = 'home_controller/shop_by_seller';


        /*blogs*/
        //$route[$key . getr('user_blog', $rts)]['GET'] = 'home_controller/user_blog';
        /*user_blog_1*/
        //$route[$key . getr('user_blog_1', $rts)]['GET'] = 'home_controller/user_blog_1';
        /*user_blog_2*/
        //$route[$key . getr('user_blog_2', $rts)]['GET'] = 'home_controller/user_blog_2';
        /*user_blog_3*/
        //$route[$key . getr('Artisanal-jewellery-amplifying-current-fashion-standards', $rts)]['GET'] = 'home_controller/user_blog_3';
        /*user_blog_4*/
        //$route[$key . getr('Dress-well-first-interview', $rts)]['GET'] = 'home_controller/user_blog_4';
        /*user_blog_5*/
        //$route[$key . getr('affiliate-marketing-passive-income', $rts)]['GET'] = 'home_controller/user_blog_5';
        /*user_blog_6*/
        //$route[$key . getr('Essential-ingredients-online-food-business-home', $rts)]['GET'] = 'home_controller/user_blog_6';
        /*user_blog_7*/
        //$route[$key . getr('Skincare-routine', $rts)]['GET'] = 'home_controller/user_blog_7';
        /*user_blog_8*/
        //$route[$key . getr('logo-creation-basics', $rts)]['GET'] = 'home_controller/user_blog_8';
        /*user_blog_9*/
        //$route[$key . getr('handmade-products', $rts)]['GET'] = 'home_controller/user_blog_9';
        /*user_blog_10*/
        //$route[$key . getr('gender-neutral-outfits-online', $rts)]['GET'] = 'home_controller/user_blog_10';
        /*user_blog_11*/
        //$route[$key . getr('embracing-everything-ethnic', $rts)]['GET'] = 'home_controller/user_blog_11';
        /*user_blog_12*/
        // $route[$key . getr('employee-diwali-gifts', $rts)]['GET'] = 'home_controller/user_blog_12';
        /*user_blog_13*/
        //$route[$key . getr('diwali-gift-ideas', $rts)]['GET'] = 'home_controller/user_blog_13';
        /*user_blog_14*/
        //$route[$key . getr('diwali-decoration-tips', $rts)]['GET'] = 'home_controller/user_blog_14';
        /*user_blog_15*/
        //$route[$key . getr('coolest-ethnic-wear-diwali', $rts)]['GET'] = 'home_controller/user_blog_15';
        /*user_blog_16*/
        //$route[$key . getr('edible-cutlery', $rts)]['GET'] = 'home_controller/user_blog_16';

        $route[getr('admin', $rts) . '/bank-approve-details'] = 'membership_controller/bank_details_approve_requests';


        $route[getr('dashboard', $rts) . '/loyalty-level'] = 'dashboard_controller/loyalty_level';


        //  categories
        $route[getr('category', $rts)] = 'home_controller/categories';
        // personal_care
        $route[getr('personal_care', $rts)] = 'home_controller/personal_care';
        // groceries
        $route[getr('groceries', $rts)] = 'home_controller/groceries';
        // home and lifestyle
        $route[getr('home_lifestyle', $rts)] = 'home_controller/home_lifestyle';
        // gifts for you
        $route[getr('gifts_for_you', $rts)] = 'home_controller/gifts_for_you';
        // stationery and gifts
        $route[getr('stationery_gifts', $rts)] = 'home_controller/stationery_gifts';
        // home cooks
        $route[getr('home_cooks', $rts)] = 'home_controller/home_cooks';
        // fashion
        $route[getr('fashion_all', $rts)] = 'home_controller/fashion';
        // kids corner
        $route[getr('kids_corner', $rts)] = 'home_controller/kids_corner';
        // categories_for_mobile
        $route[getr('categories_for_mobile', $rts)] = 'home_controller/categories_for_mobile';
        //end of categories

        //  Single categories function
        $route[$key . getr('top-categories', $rts) . '/(:any)']['GET'] = 'home_controller/top_categories/$1';
        //end


        $route['home_controller/getindiacities'] = 'home_controller/getindiacities';
        $route[getr('shop-by-seller', $rts)] = 'home_controller/shop_by_seller';
        /*blog*/
        $route[$key . getr('blog', $rts)]['GET'] = 'home_controller/blog';
        $route[$key . getr('blog', $rts) . '/(:any)']['GET'] = 'home_controller/blog_category/$1';
        $route[$key . getr('blog', $rts) . '/' . getr('tag', $rts) . '/(:any)']['GET'] = 'home_controller/tag/$1';
        $route[$key . getr('blog', $rts) . '/(:any)/(:any)']['GET'] = 'home_controller/post/$1/$2';
        /*contact*/
        $route[$key . getr('contact', $rts)]['GET'] = 'home_controller/contact';
        $route[$key . getr('sitemap', $rts)]['GET'] = 'home_controller/siteMap';
        /*messages*/
        $route[$key . getr('messages', $rts)]['GET'] = 'message_controller/messages';
        //$route[$key . getr('barter_requests', $rts)]['GET'] = 'message_controller/barter_requests';
        $route[$key . getr('messages', $rts) . '/' . getr('conversation', $rts) . '/(:num)']['GET'] = 'message_controller/conversation/$1';
        /*rss feeds*/
        $route[$key . getr('rss_feeds', $rts)]['GET'] = 'rss_controller/rss_feeds';
        $route[$key . 'rss/' . getr('latest_products', $rts)]['GET'] = 'rss_controller/latest_products';
        $route[$key . 'rss/' . getr('featured_products', $rts)]['GET'] = 'rss_controller/featured_products';
        $route[$key . 'rss/' . getr('category', $rts) . '/(:any)']['GET'] = 'rss_controller/rss_by_category/$1';
        $route[$key . 'rss/' . getr('seller', $rts) . '/(:any)']['GET'] = 'rss_controller/rss_by_seller/$1';
        $route[$key . getr('seller_products', $rts) . '/' . '(:any)']['GET'] = 'home_controller/seller_products/$1';
        $route[$key . getr('more_products', $rts) . '/' . '(:any)']['GET'] = 'home_controller/more_products/$1';
        /*cart*/
        $route[$key . getr('cart', $rts)]['GET'] = 'cart_controller/cart';
        $route[$key . getr('cart', $rts) . '/' . getr('shipping', $rts)]['GET'] = 'cart_controller/shipping';
        $route[$key . getr('cart', $rts) . '/' . getr('payment_method', $rts)]['GET'] = 'cart_controller/payment_method';
        $route[$key . getr('cart', $rts) . '/' . getr('payment', $rts)]['GET'] = 'cart_controller/payment';
        /*orders*/
        $route[$key . getr('orders', $rts)]['GET'] = 'order_controller/orders';

        $route[$key . getr('orders', $rts) . '/' . getr('completed_orders', $rts)]['GET'] = 'order_controller/completed_orders';
        $route[$key . getr('orders_dashboard', $rts)]['GET'] = 'order_controller/orders_dashboard';
        $route[$key . getr('orders_dashboard_mobile', $rts)]['GET'] = 'order_controller/orders_dashboard_mobile';

        $route[$key . getr('orders', $rts) . '/' . getr('trackstatus', $rts) . '/(:num)']['GET'] = 'order_controller/trackstatus/$1';
        $route[$key . getr('order_test_2', $rts) . '/(:num)']['GET'] = 'order_controller/order_test_2/$1';


        $route[$key . getr('orders', $rts) . '/' . getr('completed_orders_dashboard', $rts)]['GET'] = 'order_controller/completed_orders_dashboard';
        $route[$key . getr('order_details', $rts) . '/(:num)']['GET'] = 'order_controller/order/$1';

        //  $route[$key . getr('thankyou', $rts) . '/(:num)']['GET'] = 'order_controller/thankyou/$1';

        $route[$key . getr('order-completed', $rts)]['GET'] = 'home_controller/thankyou';

        $route[$key . getr('order_product_details', $rts) . '/(:num)']['GET'] = 'order_controller/order_product/$1';
        $route[$key . getr('order_completed', $rts) . '/(:num)']['GET'] = 'cart_controller/order_completed/$1';
        $route[$key . getr('promote_payment_completed', $rts)]['GET'] = 'cart_controller/promote_payment_completed';
        $route[$key . getr('membership_payment_completed', $rts)]['GET'] = 'cart_controller/membership_payment_completed';
        $route[$key . 'invoice/(:num)']['GET'] = 'common_controller/invoice/$1';

        $route[$key . 'invoice_order/(:num)']['GET'] = 'common_controller/invoice_order/$1';
        $route[$key . 'invoice-promotion/(:num)']['GET'] = 'common_controller/invoice_promotion/$1';
        $route[$key . 'invoice-membership/(:num)']['GET'] = 'common_controller/invoice_membership/$1';
        /*bidding*/
        $route[$key . getr('quote_requests', $rts)]['GET'] = 'bidding_controller/quote_requests';
        $route[$key . getr('barter_requests', $rts)]['GET'] = 'bidding_controller/barter_requests';
        /*terms-conditions*/
        $route[$key . getr('terms_conditions', $rts)]['GET'] = 'home_controller/terms_conditions';
        /*career*/
        $route[$key . getr('career', $rts)]['GET'] = 'home_controller/career';
        $route[$key . getr('privacy', $rts)]['GET'] = 'home_controller/privacy';
        /*aboutus*/
        $route[$key . getr('aboutus', $rts)]['GET'] = 'home_controller/aboutus';
        /*shipping_policy*/
        $route[$key . getr('shipping_policy', $rts)]['GET'] = 'home_controller/shipping_policy';
        /*blogs*/
        //$route[$key . getr('user_blog', $rts)]['GET'] = 'home_controller/user_blog';
        /*user_blog_1*/
        //$route[$key . getr('Essential-ingredients-online-food-business', $rts)]['GET'] = 'home_controller/user_blog_1';
        /*user_blog_2*/
        //$route[$key . getr('home-cooked-food-beats-dine-out', $rts)]['GET'] = 'home_controller/user_blog_2';
        /*return_and_exchange*/
        $route[$key . getr('return_and_exchange', $rts)]['GET'] = 'home_controller/return_and_exchange';
        /*shop_by_occasion*/
        $route[$key . getr('shop-by-occasion', $rts)]['GET'] = 'home_controller/shop_by_occasion';
        $route[$key . getr('shop_by_occasion', $rts) . '/(:any)']['GET'] = 'home_controller/products_shop_by_occassion/$1';
        // last product get route

        $route[$key . getr('last_product', $rts)]['GET'] = 'product_controller/last_product_id';
        // $route[$key . getr('last_product', $rts)]['GET'] = 'product_controller/last_product_id';

        /*dashboard*/
        $route[$key . getr('dashboard', $rts) . '/' . getr('update_seller_info', $rts)]['GET'] = 'profile_controller/update_seller_info';
        $route[$key . getr('dashboard', $rts) . '/' . getr('update_seller_info_services', $rts)]['GET'] = 'profile_controller/update_seller_info_services';
        $route[$key . getr('dashboard', $rts) . '/' . getr('add_product', $rts)]['GET'] = 'dashboard_controller/add_product';
        $route[$key . getr('dashboard', $rts) . '/' . getr('product_inventory', $rts)]['GET'] = 'dashboard_controller/product_inventory';
        $route[$key . getr('dashboard', $rts) . '/' . getr('update_business_information', $rts)]['GET'] = 'dashboard_controller/update_story';
        $route[$key . getr('dashboard', $rts) . '/' . getr('profile', $rts)]['GET'] = 'dashboard_controller/update_profile';

        $route[$key . getr('dashboard', $rts) . '/' . getr('buyer_panel', $rts)]['GET'] = 'dashboard_controller/buyer_panel';
        $route[$key . getr('dashboard', $rts) . '/' . getr('add_service', $rts)]['GET'] = 'dashboard_controller/add_service';
        $route[$key . getr('dashboard', $rts) . '/' . getr('product', $rts) . '/' . getr('product_details', $rts) . '/(:num)']['GET'] = 'dashboard_controller/edit_product_details/$1';
        $route[$key . getr('dashboard', $rts) . '/' . getr('service', $rts) . '/' . getr('service_details', $rts) . '/(:num)']['GET'] = 'dashboard_controller/edit_service_details/$1';
        $route[$key . getr('dashboard', $rts) . '/' . getr('edit_product', $rts) . '/(:num)']['GET'] = 'dashboard_controller/edit_product/$1';

        //dashboard get product image count
        $route[$key . getr('dashboard', $rts) . '/check_image_upload_product']['GET'] = 'dashboard_controller/check_image_upload_product';



        $route[$key . getr('dashboard', $rts) . '/' . getr('coupans', $rts)]['GET'] = 'dashboard_controller/coupans';

        $route[$key . getr('dashboard', $rts) . '/' . getr('credits', $rts)]['GET'] = 'dashboard_controller/credits';

        $route[$key . getr('dashboard', $rts) . '/' . getr('saved_cards', $rts)]['GET'] = 'dashboard_controller/saved_cards';

        $route[$key . getr('dashboard', $rts) . '/' . getr('addresses', $rts)]['GET'] = 'dashboard_controller/addresses';

        $route[$key . getr('dashboard', $rts) . '/' . getr('products', $rts)]['GET'] = 'dashboard_controller/products';
        //$route[$key . getr('dashboard', $rts) . '/' . getr('bulk_product', $rts)]['GET'] = 'dashboard_controller/bulk_products';

        $route[$key . getr('dashboard', $rts) . '/' . getr('pending_products', $rts)]['GET'] = 'dashboard_controller/pending_products';

        $route[$key . getr('dashboard', $rts) . '/' . getr('edit_service', $rts) . '/(:num)']['GET'] = 'dashboard_controller/edit_service/$1';

        $route[$key . getr('dashboard', $rts) . '/' . getr('services', $rts)]['GET'] = 'dashboard_controller/services';
        $route[$key . getr('dashboard', $rts) . '/' . getr('pending_services', $rts)]['GET'] = 'dashboard_controller/pending_services';
        $route[$key . getr('dashboard', $rts) . '/' . getr('bulk_product_upload', $rts)]['GET'] = 'dashboard_controller/bulk_product_upload';
        $route[$key . getr('dashboard', $rts) . '/' . getr('bulk_product_upload_demo_file', $rts)]['GET'] = 'dashboard_controller/bulk_product_upload_demo_file';
        $route[$key . getr('dashboard', $rts) . '/' . getr('bulk_service_upload', $rts)]['GET'] = 'dashboard_controller/bulk_service_upload';
        $route[$key . getr('dashboard', $rts) . '/' . getr('barter_system', $rts)]['GET'] = 'dashboard_controller/barter_system';
        $route[$key . getr('dashboard', $rts) . '/' . getr('sales', $rts)]['GET'] = 'dashboard_controller/sales';
        $route[$key . getr('dashboard', $rts) . '/' . getr('accepted_sales', $rts)]['GET'] = 'dashboard_controller/accepted_sales';
        $route[$key . getr('dashboard', $rts) . '/' . getr('rejected_sales', $rts)]['GET'] = 'dashboard_controller/rejected_sales';
        $route[$key . getr('dashboard', $rts) . '/' . getr('awaiting_pickup', $rts)]['GET'] = 'dashboard_controller/awaiting_pickup';
        $route[$key . getr('dashboard', $rts) . '/' . getr('shipped', $rts)]['GET'] = 'dashboard_controller/shipped';
        $route[$key . getr('dashboard', $rts) . '/' . getr('completed_sales', $rts)]['GET'] = 'dashboard_controller/completed_sales';
        $route[$key . getr('dashboard', $rts) . '/' . getr('cancelled_by_user', $rts)]['GET'] = 'dashboard_controller/cancelled_by_user';
        $route[$key . getr('dashboard', $rts) . '/' . getr('cancelled_by_seller', $rts)]['GET'] = 'dashboard_controller/cancelled_by_seller';
        $route[$key . getr('dashboard', $rts) . '/' . getr('sale', $rts) . '/(:num)']['GET'] = 'dashboard_controller/sale/$1';
        $route[$key . getr('dashboard', $rts) . '/' . getr('track_status', $rts) . '/(:num)']['GET'] = 'dashboard_controller/track_status/$1';
        // $route[$key . getr('dashboard', $rts) . '/' . getr('cancelorder', $rts) . '/(:num)']['GET'] = 'dashboard_controller/cancelorder/$1';
        $route[$key . getr('dashboard', $rts) . '/' . getr('return_orders', $rts)]['GET'] = 'dashboard_controller/return_orders';


        $route[$key . getr('dashboard', $rts) . '/' . getr('hidden_products', $rts)]['GET'] = 'dashboard_controller/hidden_products';
        $route[$key . getr('dashboard', $rts) . '/' . getr('expired_products', $rts)]['GET'] = 'dashboard_controller/expired_products';
        $route[$key . getr('dashboard', $rts) . '/' . getr('hidden_services', $rts)]['GET'] = 'dashboard_controller/hidden_services';
        $route[$key . getr('dashboard', $rts) . '/' . getr('expired_services', $rts)]['GET'] = 'dashboard_controller/expired_services';
        $route[$key . getr('dashboard', $rts) . '/' . getr('drafts', $rts)]['GET'] = 'dashboard_controller/drafts';
        $route[$key . getr('dashboard', $rts) . '/' . getr('drafts_service', $rts)]['GET'] = 'dashboard_controller/drafts_service';
        $route[$key . getr('dashboard', $rts) . '/' . getr('earnings', $rts)]['GET'] = 'dashboard_controller/earnings';
        $route[$key . getr('dashboard', $rts) . '/' . getr('penalties', $rts)]['GET'] = 'dashboard_controller/penalties';
        $route[$key . getr('dashboard', $rts) . '/' . getr('total_earning', $rts)]['GET'] = 'dashboard_controller/total_earning';
        $route[$key . getr('dashboard', $rts) . '/' . getr('withdraw_money', $rts)]['GET'] = 'dashboard_controller/withdraw_money';
        $route[$key . getr('dashboard', $rts) . '/' . getr('payouts', $rts)]['GET'] = 'dashboard_controller/payouts';
        $route[$key . getr('dashboard', $rts) . '/' . getr('set_payout_account', $rts)]['GET'] = 'dashboard_controller/set_payout_account';
        $route[$key . getr('dashboard', $rts) . '/' . getr('quote_requests', $rts)]['GET'] = 'dashboard_controller/quote_requests';
        $route[$key . getr('dashboard', $rts) . '/' . getr('barter_requests', $rts)]['GET'] = 'dashboard_controller/barter_requests';
        $route[$key . getr('dashboard', $rts) . '/' . getr('payment_history', $rts)]['GET'] = 'dashboard_controller/payment_history';
        $route[$key . getr('dashboard', $rts) . '/' . getr('comments', $rts)]['GET'] = 'dashboard_controller/comments';
        $route[$key . getr('dashboard', $rts) . '/' . getr('reviews', $rts)]['GET'] = 'dashboard_controller/reviews';
        $route[$key . getr('dashboard', $rts) . '/' . getr('shop_settings', $rts)]['GET'] = 'dashboard_controller/shop_settings';


        $route[$key . getr('admin', $rts) . '/' . 'edit_bank_details/(:num)'] = 'membership_controller/edit_vendor_bank_details/$1';

        $route[$key . getr('dashboard', $rts) . '/' . getr('last_product', $rts)]['GET'] = 'dashboard_controller/last_product';


        $route[$key . 'calculate-loyality-values']['GET'] = 'coupon_controller/calculate_loyality_values';


        /*any*/
        if ($general_settings->site_lang != $language->id) {
            $route[$key . '(:any)/(:any)']['GET'] = 'home_controller/subcategory/$1/$2';
            $route[$key . '(:any)']['GET'] = 'home_controller/any/$1';
        }
        $route[$key . 'preview/(:any)']['GET'] = 'home_controller/preview/$1';
    }
}

//static routes
include_once "routes_static.php";

/*
 *
 * ADMIN ROUTES
 *
 */
$route[getr('admin', $rts)] = 'admin_controller/index';
//login
$route[getr('admin', $rts) . '/login'] = 'common_controller/admin_login';
/*navigation routes*/
$route[getr('admin', $rts) . '/navigation'] = 'admin_controller/navigation';
$route[getr('admin', $rts) . '/homepage-manager'] = 'admin_controller/homepage_manager';
$route[getr('admin', $rts) . '/edit-banner/(:num)'] = 'admin_controller/edit_index_banner/$1';
/*slider routes*/
$route[getr('admin', $rts) . '/slider'] = 'admin_controller/slider';
$route[getr('admin', $rts) . '/update-slider-item/(:num)'] = 'admin_controller/update_slider_item/$1';
/*page routes*/
$route[getr('admin', $rts)] = 'admin_controller/index';
$route[getr('admin', $rts) . '/settings'] = 'admin_controller/settings';
$route[getr('admin', $rts) . '/email-settings'] = 'admin_controller/email_settings';
$route[getr('admin', $rts) . '/social-login'] = 'admin_controller/social_login_settings';

$route[getr('admin', $rts) . '/add-page'] = 'page_controller/add_page';
$route[getr('admin', $rts) . '/update-page'] = 'page_controller/update_page';
$route[getr('admin', $rts) . '/pages'] = 'page_controller/pages';
$route[getr('admin', $rts) . '/pages'] = 'page_controller/pages';
/*order routes*/
$route[getr('admin', $rts) . '/orders'] = 'order_admin_controller/orders';
$route[getr('admin', $rts) . '/order-details/(:num)'] = 'order_admin_controller/order_details/$1';

$route[getr('admin', $rts) . '/order-product-details/(:num)'] = 'order_admin_controller/order_product_details/$1';
$route[getr('admin', $rts) . '/transactions'] = 'order_admin_controller/transactions';
$route[getr('admin', $rts) . '/order-bank-transfers'] = 'order_admin_controller/order_bank_transfers';
$route[getr('admin', $rts) . '/refunds'] = 'order_admin_controller/refunds';
$route[getr('admin', $rts) . '/invoices'] = 'order_admin_controller/invoices';
$route[getr('admin', $rts) . '/digital-sales'] = 'order_admin_controller/digital_sales';
/*product routes*/
$route[getr('admin', $rts) . '/products'] = 'product_controller/products';
$route[getr('admin', $rts) . '/products_offers'] = 'coupon_controller/coupons_products';
$route[getr('admin', $rts) . '/products_coupons'] = 'coupon_controller/get_coupon_data';
$route[getr('admin', $rts) . '/user_vouchers'] = 'coupon_controller/get_voucher_data';
$route[getr('admin', $rts) . '/services'] = 'product_controller/services';

$route[getr('admin', $rts) . '/pending-products'] = 'product_controller/pending_products';
$route[getr('admin', $rts) . '/hidden-products'] = 'product_controller/hidden_products';


$route[getr('admin', $rts) . '/barter-products'] = 'product_controller/barter_products';
$route[getr('admin', $rts) . '/pending-barter'] = 'product_controller/pending_barter';
$route[getr('admin', $rts) . '/expired-products'] = 'product_controller/expired_products';
$route[getr('admin', $rts) . '/drafts'] = 'product_controller/drafts';
$route[getr('admin', $rts) . '/drafts-service'] = 'product_controller/drafts_service';
$route[getr('admin', $rts) . '/deleted-products'] = 'product_controller/deleted_products';
$route[getr('admin', $rts) . '/product-details/(:num)'] = 'product_controller/product_details/$1';
$route[getr('admin', $rts) . '/user-details/(:num)'] = 'auth_controller/user_details/$1';

/*featured product routes*/
$route[getr('admin', $rts) . '/featured-products'] = 'product_controller/featured_products';
$route[getr('admin', $rts) . '/featured-products-transactions'] = 'product_controller/featured_products_transactions';
$route[getr('admin', $rts) . '/featured-products-pricing'] = 'product_controller/featured_products_pricing';

/*featured service routes*/
$route[getr('admin', $rts) . '/featured-services'] = 'product_controller/featured_services';
$route[getr('admin', $rts) . '/featured-services-transactions'] = 'product_controller/featured_services_transactions';
$route[getr('admin', $rts) . '/featured-services-pricing'] = 'product_controller/featured_services_pricing';
/*service routes*/
$route[getr('admin', $rts) . '/pending-services'] = 'product_controller/pending_services';
$route[getr('admin', $rts) . '/hidden-services'] = 'product_controller/hidden_services';
$route[getr('admin', $rts) . '/expired-services'] = 'product_controller/expired_services';

$route[getr('admin', $rts) . '/deleted-services'] = 'product_controller/deleted_services';
$route[getr('admin', $rts) . '/service-details/(:num)'] = 'product_controller/service_details/$1';
/*featured product routes*/

/*special-offers*/
$route[getr('admin', $rts) . '/special-offers'] = 'product_controller/special_offers';
$route[getr('admin', $rts) . '/edit-coupon-details/(:num)'] = 'coupon_controller/edit_offer_details/$1';
$route[getr('admin', $rts) . '/edit-voucher-details/(:num)'] = 'coupon_controller/edit_voucher_details/$1';


/*bidding system*/
$route[getr('admin', $rts) . '/quote-requests'] = 'admin_controller/quote_requests';

$route[getr('admin', $rts) . '/barter-requests'] = 'admin_controller/barter_requests';
/*page routes*/
$route[getr('admin', $rts) . '/pages'] = 'page_controller/pages';
$route[getr('admin', $rts) . '/update-page/(:num)'] = 'page_controller/update_page/$1';
/*category routes*/
$route[getr('admin', $rts) . '/add-category'] = 'category_controller/add_category';
$route[getr('admin', $rts) . '/categories'] = 'category_controller/categories';
$route[getr('admin', $rts) . '/update-category/(:num)'] = 'category_controller/update_category/$1';
$route[getr('admin', $rts) . '/bulk-category-upload'] = 'category_controller/bulk_category_upload';

/*features routes*/
$route[getr('admin', $rts) . '/add-feature'] = 'category_controller/add_feature';
$route[getr('admin', $rts) . '/features'] = 'category_controller/features';
$route[getr('admin', $rts) . '/category-feature-relation'] = 'category_controller/category_feature_relation';
$route[getr('admin', $rts) . '/add-category-feature-relation'] = 'category_controller/add_category_feature_relation';
/*custom fields*/
$route[getr('admin', $rts) . '/add-custom-field'] = 'category_controller/add_custom_field';
$route[getr('admin', $rts) . '/custom-fields'] = 'category_controller/custom_fields';
$route[getr('admin', $rts) . '/update-custom-field/(:num)'] = 'category_controller/update_custom_field/$1';
$route[getr('admin', $rts) . '/custom-field-options/(:num)'] = 'category_controller/custom_field_options/$1';
/*earnings*/
$route[getr('admin', $rts) . '/earnings'] = 'earnings_controller/earnings';
$route[getr('admin', $rts) . '/penalties'] = 'earnings_controller/penalties';

$route[getr('admin', $rts) . '/completed-payouts'] = 'earnings_controller/completed_payouts';
$route[getr('admin', $rts) . '/payout-requests'] = 'earnings_controller/payout_requests';
$route[getr('admin', $rts) . '/initiate-payout-cod'] = 'earnings_controller/initiate_payout';
$route[getr('admin', $rts) . '/initiate-payout-prepaid'] = 'earnings_controller/initiate_payout_prepaid';
$route[getr('admin', $rts) . '/payout-settings'] = 'earnings_controller/payout_settings';
$route[getr('admin', $rts) . '/add-payout'] = 'earnings_controller/add_payout';
$route[getr('admin', $rts) . '/seller-balances'] = 'earnings_controller/seller_balances';
$route[getr('admin', $rts) . '/update-seller-balance/(:num)'] = 'earnings_controller/update_seller_balance/$1';
/*blog routes*/
$route[getr('admin', $rts) . '/blog-add-post'] = 'blog_controller/add_post';
$route[getr('admin', $rts) . '/blog-posts'] = 'blog_controller/posts';
$route[getr('admin', $rts) . '/update-blog-post/(:num)'] = 'blog_controller/update_post/$1';
$route[getr('admin', $rts) . '/blog-categories'] = 'blog_controller/categories';
$route[getr('admin', $rts) . '/update-blog-category/(:num)'] = 'blog_controller/update_category/$1';
/*comment routes*/
$route[getr('admin', $rts) . '/pending-product-comments'] = 'product_controller/pending_comments';
$route[getr('admin', $rts) . '/product-comments'] = 'product_controller/comments';
$route[getr('admin', $rts) . '/pending-blog-comments'] = 'blog_controller/pending_comments';
$route[getr('admin', $rts) . '/blog-comments'] = 'blog_controller/comments';
/*review routes*/
$route[getr('admin', $rts) . '/reviews'] = 'product_controller/reviews';
/*ad spaces routes*/
$route[getr('admin', $rts) . '/ad-spaces'] = 'admin_controller/ad_spaces';
/*seo tools routes*/
$route[getr('admin', $rts) . '/seo-tools'] = 'admin_controller/seo_tools';
/*location*/
$route[getr('admin', $rts) . '/location-settings'] = 'admin_controller/location_settings';
$route[getr('admin', $rts) . '/countries'] = 'admin_controller/countries';
$route[getr('admin', $rts) . '/states'] = 'admin_controller/states';
$route[getr('admin', $rts) . '/add-country'] = 'admin_controller/add_country';
$route[getr('admin', $rts) . '/update-country/(:num)'] = 'admin_controller/update_country/$1';
$route[getr('admin', $rts) . '/add-state'] = 'admin_controller/add_state';
$route[getr('admin', $rts) . '/update-state/(:num)'] = 'admin_controller/update_state/$1';
$route[getr('admin', $rts) . '/cities'] = 'admin_controller/cities';
$route[getr('admin', $rts) . '/add-city'] = 'admin_controller/add_city';
$route[getr('admin', $rts) . '/update-city/(:num)'] = 'admin_controller/update_city/$1';
/*users routes*/
$route[getr('admin', $rts) . '/members'] = 'membership_controller/members';
$route[getr('admin', $rts) . '/vouchers-users'] = 'coupon_controller/vouchers_users';
$route[getr('admin', $rts) . '/vendors'] = 'membership_controller/vendors';
$route[getr('admin', $rts) . '/featured_vendors'] = 'membership_controller/featured_vendors';
$route[getr('admin', $rts) . '/administrators'] = 'membership_controller/administrators';
$route[getr('admin', $rts) . '/shop-opening-requests'] = 'membership_controller/shop_opening_requests';
$route[getr('admin', $rts) . '/update-profile-requests'] = 'membership_controller/update_profile_requests';
$route[getr('admin', $rts) . '/add-administrator'] = 'membership_controller/add_administrator';
$route[getr('admin', $rts) . '/edit-user/(:num)'] = 'membership_controller/edit_user/$1';
$route[getr('admin', $rts) . '/membership-plans'] = 'membership_controller/membership_plans';
$route[getr('admin', $rts) . '/transactions-membership'] = 'membership_controller/transactions_membership';
$route[getr('admin', $rts) . '/edit-plan/(:num)'] = 'membership_controller/edit_plan/$1';
$route[getr('admin', $rts) . '/bank-approve-details'] = 'membership_controller/bank_details_approve_requests';

$route[getr('admin', $rts) . '/cache-system'] = 'admin_controller/cache_system';
$route[getr('admin', $rts) . '/storage'] = 'admin_controller/storage';


/*offers routes*/
$route[getr('admin', $rts) . '/coupons-dashboard'] = 'coupon_controller/coupon_dashboard';
$route[getr('admin', $rts) . '/vouchers-dashboard'] = 'coupon_controller/voucher_dashboard';
$route[getr('admin', $rts) . '/offers-dashboard'] = 'coupon_controller/offers';
$route[getr('admin', $rts) . '/category-coupon'] = 'coupon_controller/category_coupon_select';
$route[getr('admin', $rts) . '/consumption-dashboard'] = 'coupon_controller/consumption_dashboard';

/*languages routes*/
$route[getr('admin', $rts) . '/languages'] = 'language_controller/languages';
$route[getr('admin', $rts) . '/update-language/(:num)'] = 'language_controller/update_language/$1';
$route[getr('admin', $rts) . '/translations/(:num)'] = 'language_controller/update_translations/$1';
$route[getr('admin', $rts) . '/search-phrases'] = 'language_controller/search_phrases';
/*payment routes*/
$route[getr('admin', $rts) . '/payment-settings'] = 'settings_controller/payment_settings';
$route[getr('admin', $rts) . '/visual-settings'] = 'admin_controller/visual_settings';
$route[getr('admin', $rts) . '/system-settings'] = 'admin_controller/system_settings';
// offers routes
$route[getr('admin', $rts) . '/create-offers'] = 'admin_controller/create_offers';
$route[getr('admin', $rts) . '/selection-offers'] = 'admin_controller/vouched';

/*currency*/
$route[getr('admin', $rts) . '/currency-settings'] = 'admin_controller/currency_settings';
$route[getr('admin', $rts) . '/update-currency/(:num)'] = 'admin_controller/update_currency/$1';
//newsletter
$route[getr('admin', $rts) . '/send-email-subscribers'] = 'admin_controller/send_email_subscribers';
$route[getr('admin', $rts) . '/subscribers'] = 'admin_controller/subscribers';
$route[getr('admin', $rts) . '/send-email-members'] = 'admin_controller/send_email_members';
$route[getr('admin', $rts) . '/send-sms-members'] = 'admin_controller/send_sms_members';
//loyalty
$route[getr('admin', $rts) . '/loyalty-criteria'] = 'admin_controller/loyalty_criteria';
$route[getr('admin', $rts) . '/edit-loyalty-criteria/(:num)'] = 'admin_controller/edit_loyalty_criteria/$1';
$route[getr('admin', $rts) . '/user-loyalty-program'] = 'admin_controller/user_loyalty_program';
$route[getr('admin', $rts) . '/edit_kpi/(:num)'] = 'admin_controller/edit_kpi/$1';
$route[getr('admin', $rts) . '/edit-loyalty-program/(:num)'] = 'admin_controller/edit_loyalty_program/$1';
$route[getr('admin', $rts) . '/kpi-form'] = 'admin_controller/kpi_form';
$route[getr('admin', $rts) . '/qualified-user'] = 'admin_controller/qualified_user';
$route[getr('admin', $rts) . '/qualified-user-details/(:num)'] = 'admin_controller/qualified_user_details/$1';

$route[getr('admin', $rts) . '/qualify-criteria'] = 'admin_controller/qualify_criteria';

$route[getr('admin', $rts) . '/contact-messages'] = 'admin_controller/contact_messages';
$route[getr('admin', $rts) . '/preferences'] = 'admin_controller/preferences';

//form settings
$route[getr('admin', $rts) . '/form-settings'] = 'settings_controller/form_settings';
$route[getr('admin', $rts) . '/form-settings/shipping-options'] = 'settings_controller/shipping_options';
$route[getr('admin', $rts) . '/form-settings/edit-shipping-option/(:num)'] = 'settings_controller/edit_shipping_option/$1';

$route[getr('admin', $rts) . '/font-settings'] = 'settings_controller/font_settings';
$route[getr('admin', $rts) . '/update-font/(:num)'] = 'settings_controller/update_font/$1';
$route[getr('admin', $rts) . '/route-settings'] = 'settings_controller/route_settings';
//order window
$route[$key . getr('order-window-update', $rts)]['GET'] = 'order_controller/order_window_update';

$route['(:any)/(:any)']['GET'] = 'home_controller/subcategory/$1/$2';
$route['(:any)']['GET'] = 'home_controller/any/$1';
// $route['(:barter_any)']['GET'] = 'home_controller/barter_any/$1';
