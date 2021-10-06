<?php
defined('BASEPATH') or exit('No direct script access allowed');

//fixed
$route['cron/update-sitemap'] = 'cron_controller/update_sitemap';
$route['unsubscribe'] = 'home_controller/unsubscribe';
$route['connect-with-facebook'] = 'auth_controller/connect_with_facebook';
$route['facebook-callback'] = 'auth_controller/facebook_callback';
$route['connect-with-google'] = 'auth_controller/connect_with_google';
$route['connect-with-vk'] = 'auth_controller/connect_with_vk';
$route['logout'] = 'common_controller/logout';
//auth
$route['forgot-password-post']['POST'] = 'auth_controller/forgot_password_post';
$route['reset-password-post']['POST'] = 'auth_controller/reset_password_post';
$route['register-post']['POST'] = 'auth_controller/register_post';
//barter
$route['barter-request']['POST'] = 'bidding_controller/barter_request';
//bidding
$route['request-quote']['POST'] = 'bidding_controller/request_quote';
$route['submit-quote-post']['POST'] = 'dashboard_controller/submit_quote';
$route['accept-quote-post']['POST'] = 'bidding_controller/accept_quote';
$route['reject-quote-post']['POST'] = 'bidding_controller/reject_quote';
$route['schedule-multiple-order-shipment']['POST'] = 'dashboard_controller/schedule_multiple_order_shipment';

$route['submit-barter-post']['POST'] = 'dashboard_controller/submit_barter';
$route['accept-barter-post']['POST'] = 'bidding_controller/accept_barter';
$route['reject-barter-post']['POST'] = 'bidding_controller/reject_barter';
$route['complete-barter-post']['POST'] = 'bidding_controller/complete_barter';
$route['close-barter-post']['POST'] = 'bidding_controller/close_barter';
$route['close-barter-buyer-post']['POST'] = 'bidding_controller/close_barter_by_buyer';
$route['review-barter-post']['POST'] = 'bidding_controller/review_barter';
$route['deal-cancel-barter-post']['POST'] = 'bidding_controller/deal_cancel_barter';
//ajax
$route['send-email-post']['POST'] = 'ajax_controller/send_email';
//cart
$route['add-to-cart']['POST'] = 'cart_controller/add_to_cart';
$route['shop-is-close']['POST'] = 'cart_controller/shop_is_close';

$route['add-shipping-amount-to-cart'] = 'cart_controller/add_cart_shipping_cost';

$route['add-to-cart-quote']['POST'] = 'cart_controller/add_to_cart_quote';
$route['update-cart-product-quantity']['POST'] = 'cart_controller/update_cart_product_quantity';
$route['payment-method-post']['POST'] = 'cart_controller/payment_method_post';
$route['shipping-post']['POST'] = 'cart_controller/shipping_post';
$route['bank-transfer-payment-post']['POST'] = 'cart_controller/bank_transfer_payment_post';
$route['cash-on-delivery-payment-post']['POST'] = 'cart_controller/cash_on_delivery_payment_post';
$route['pagseguro-payment-post']['POST'] = 'cart_controller/pagseguro_payment_post';
$route['paypal-payment-post']['POST'] = 'cart_controller/paypal_payment_post';
$route['paystack-payment-post']['POST'] = 'cart_controller/paystack_payment_post';
$route['razorpay-payment-post']['POST'] = 'cart_controller/razorpay_payment_post';
$route['stripe-payment-post']['POST'] = 'cart_controller/stripe_payment_post';
$route['iyzico-payment-post'] = 'cart_controller/iyzico_payment_post';
$route['cashfree-return'] = 'cart_controller/cashfree_payment_post';
//earnings
$route['withdraw-money-post']['POST'] = 'dashboard_controller/withdraw_money_post';
$route['set-paypal-payout-account-post']['POST'] = 'dashboard_controller/set_paypal_payout_account_post';
$route['set-iban-payout-account-post']['POST'] = 'dashboard_controller/set_iban_payout_account_post';
$route['set-swift-payout-account-post']['POST'] = 'dashboard_controller/set_swift_payout_account_post';
//message
$route['send-message-post']['POST'] = 'message_controller/send_message';
//file
$route['upload-audio-post']['POST'] = 'file_controller/upload_audio';
$route['load-audio-preview-post']['POST'] = 'file_controller/load_audio_preview';
$route['upload-digital-files-post']['POST'] = 'file_controller/upload_digital_files';
$route['download-digital-file-post']['POST'] = 'file_controller/download_digital_file';
$route['upload-file-manager-images-post']['POST'] = 'file_controller/upload_file_manager_image';
$route['upload-image-post']['POST'] = 'file_controller/upload_image';
$route['upload-story-image-post']['POST'] = 'file_controller/upload_story_image';
$route['get-uploaded-image-post']['POST'] = 'file_controller/get_uploaded_image';
$route['get-uploaded-story-image-post']['POST'] = 'file_controller/get_uploaded_story_image';
$route['upload-image-session-post']['POST'] = 'file_controller/upload_image_session';
$route['get-sess-uploaded-image-post']['POST'] = 'file_controller/get_sess_uploaded_image';
$route['get-sess-uploaded-image-post-sizechart']['POST'] = 'file_controller/get_sess_uploaded_image_sizechart';
$route['upload-video-post']['POST'] = 'file_controller/upload_video';
$route['upload-video-post-story']['POST'] = 'file_controller/upload_video_story';
$route['load-video-preview-post']['POST'] = 'file_controller/load_video_preview';
$route['load-video-preview-post-story']['POST'] = 'file_controller/load_video_preview_story';
$route['download-purchased-digital-file-post']['POST'] = 'file_controller/download_purchased_digital_file';
$route['download-free-digital-file-post']['POST'] = 'file_controller/download_free_digital_file';
//product
$route['add-product-post']['POST'] = 'dashboard_controller/add_product_post';

$route['add-service-post']['POST'] = 'dashboard_controller/add_service_post';
$route['edit-product-post']['POST'] = 'dashboard_controller/edit_product_post';
$route['edit-product-details-post']['POST'] = 'dashboard_controller/edit_product_details_post';

$route['edit-service-post']['POST'] = 'dashboard_controller/edit_service_post';
$route['edit-service-details-post']['POST'] = 'dashboard_controller/edit_service_details_post';
$route['start-selling-post']['POST'] = 'home_controller/start_selling_post';
$route['start-selling-services']['POST'] = 'home_controller/start_selling_services';
$route['renew-membership-plan-post']['POST'] = 'home_controller/renew_membership_plan_post';
$route['add-remove-wishlist-post']['POST'] = 'ajax_controller/add_remove_wishlist';

//variations
$route['add-variation-post']['POST'] = 'field_controller/add_variation_post';
$route['edit-variation']['POST'] = 'field_controller/edit_variation';
$route['edit-variation-post']['POST'] = 'field_controller/edit_variation_post';
$route['delete-variation-post']['POST'] = 'field_controller/delete_variation_post';

$route['add-variation-option']['POST'] = 'field_controller/add_variation_option';
$route['add-variation-option-post']['POST'] = 'field_controller/add_variation_option_post';
$route['view-variation-options']['POST'] = 'field_controller/view_variation_options';
$route['edit-variation-option']['POST'] = 'field_controller/edit_variation_option';
$route['edit-variation-option-post']['POST'] = 'field_controller/edit_variation_option_post';

$route['edit-address']['POST'] = 'field_controller/edit_address';
$route['edit-card']['POST'] = 'field_controller/edit_card';
$route['edit-address-post']['POST'] = 'field_controller/edit_address_post';
$route['delete-variation-option-post']['POST'] = 'field_controller/delete_variation_option_post';
$route['select-variation-post']['POST'] = 'field_controller/select_variation_post';

$route['upload-variation-image-session']['POST'] = 'field_controller/upload_variation_image_session';
$route['get-uploaded-variation-image-session']['POST'] = 'field_controller/get_sess_uploaded_variation_image';
$route['delete-variation-image-session-post']['POST'] = 'field_controller/delete_variation_image_session_post';
$route['set-variation-image-main-session']['POST'] = 'field_controller/set_variation_image_main_session';
$route['set-variation-image-main']['POST'] = 'field_controller/set_variation_image_main';

$route['upload-variation-image']['POST'] = 'field_controller/upload_variation_image';
$route['get-uploaded-variation-image']['POST'] = 'field_controller/get_uploaded_variation_image';
$route['delete-variation-image-post']['POST'] = 'field_controller/delete_variation_image_post';


$route['get-shipment']['POST'] = 'dashboard_controller/get_shipment';
//select variation
$route['select-variation-option-post']['POST'] = 'ajax_controller/select_product_variation_option';
$route['get-sub-variation-options']['POST'] = 'ajax_controller/get_sub_variation_options';

//profile
$route['check-register-mobile']['POST'] = 'auth_controller/check_for_mobile_register';
$route['check-register-email']['POST'] = 'auth_controller/check_for_email_register';
$route['follow-unfollow-user-post']['POST'] = 'profile_controller/follow_unfollow_user';
$route['change-password-post']['POST'] = 'profile_controller/change_password_post';
$route['personal-information-post']['POST'] = 'profile_controller/personal_information_post';
$route['shipping-address-post']['POST'] = 'profile_controller/shipping_address_post';
$route['shop-settings-post']['POST'] = 'dashboard_controller/shop_settings_post';
$route['social-media-post']['POST'] = 'profile_controller/social_media_post';
$route['social-media-seller-post']['POST'] = 'profile_controller/social_media_seller_post';
$route['update-profile-post']['POST'] = 'profile_controller/update_profile_post';
$route['update-story-post']['POST'] = 'profile_controller/update_story_post';

$route['update-supplier-profile-logo']['POST'] = 'profile_controller/update_supplier_profile_logo';

$route['update-payout-account']['POST'] = 'profile_controller/update_payout_account';
$route['update-settings-post']['POST'] = 'profile_controller/update_settings_post';
$route['update-seller-info-post']['POST'] = 'profile_controller/update_seller_info_post';
$route['update-seller-info-services-post']['POST'] = 'profile_controller/update_seller_info_services_post';
$route['agree-fee-schedule']['POST'] = 'profile_controller/agree_fee_schedule';
$route['agree-fssai-undertaking']['POST'] = 'profile_controller/agree_fssai_undertaking';


//order
$route['update-order-product-status-post']['POST'] = 'dashboard_controller/update_order_product_status_post';
$route['update-stock-post']['POST'] = 'dashboard_controller/update_stock_post';
$route['add-shipping-tracking-number-post']['POST'] = 'dashboard_controller/add_shipping_tracking_number_post';
$route['bank-transfer-payment-report-post']['POST'] = 'order_controller/bank_transfer_payment_report_post';
//promote
$route['pricing-post']['POST'] = 'dashboard_controller/pricing_post';
//home
$route['contact-post']['POST'] = 'home_controller/contact_post';

$route['add-to-subscribers-post']['POST'] = 'home_controller/add_to_subscribers';
$route['set-default-location-post']['POST'] = 'home_controller/set_default_location';

$route['add-review-post']['POST'] = 'home_controller/add_review_post';

$route["run-internal-cron"]['POST']  = "ajax_controller/run_internal_cron";


//variation

$route[$key . getr('dashboard', $rts) . '/' . getr('get_variation_option_count', $rts)]['POST'] = 'dashboard_controller/get_variation_option_count';

// shipment routes
$route['get-product-detail-shipment']['POST'] = 'order_controller/get_wrapper';

// distance calculation
$route['calulate-distance']['POST'] = 'auth_controller/calculate_distance';

$route['update-order-status-after-timer-up']['POST'] = 'order_controller/update_order_status_after_timer_up';

$route['order-status-update']['POST'] = 'api/item/index_post';


$route['add-user-coupon'] = 'coupon_controller/vouchers_data';
$route['add-product-coupon'] = 'coupon_controller/coupons_products_data';
$route['load-source-view-post']['POST'] = 'coupon_controller/load_source_view';

$route['delete-coupon-post']['POST'] = 'coupon_controller/delete_coupon';

// Coupon Management
$route['load-popup-coupon']['POST'] = 'coupon_controller/load_coupon_popup';
$route['checked-availability-coupon']['POST'] = 'coupon_controller/checked_availability_coupon';
$route['get-user-coupon']['POST'] = 'coupon_controller/vouchers_users2';
$route['get-product-coupon']['POST'] = 'coupon_controller/products_users2';
$route['remove-coupon']['POST'] = 'coupon_controller/remove_coupon';
$route['check-hsn-validity']['POST'] = 'dashboard_controller/hsn_validity_check';
