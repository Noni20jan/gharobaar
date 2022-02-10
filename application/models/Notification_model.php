<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification_model extends CI_Model
{
    public function get_gharobaar_updates($email)
    {
        $this->db->where('event_type', 'Gharobaar Updates');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->get('notify_user')->result();
    }
    public function get_order_placement($email)
    {
        $this->db->where('event_type', 'Order Placement');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->get('notify_user')->result();
    }
    public function get_order_update($email)
    {
        $this->db->where('event_type', 'Order Update');
        $this->db->or_where('event_type', 'Order Updates');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->get('notify_user')->result();
    }
    public function get_order_cancellation_by_seller($email)
    {
        $this->db->where('event_type', 'Order Cancellation by Seller');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->get('notify_user')->result();
    }
    public function get_order_delivered($email)
    {
        $this->db->where('event_type', 'Order Delivered');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->get('notify_user')->result();
    }
    public function get_promotions($email)
    {
        $this->db->where('event_type', 'Promotions');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->get('notify_user')->result();
    }
    public function get_reviews_followers($email)
    {
        $this->db->where('event_type', 'Rating, Reviews & Followers');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->get('notify_user')->result();
    }
    public function get_listings($email)
    {
        $this->db->where('event_type', 'Listings');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->get('notify_user')->result();
    }
    public function get_profile_notification($email)
    {
        $this->db->where('event_type', 'Profile');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->get('notify_user')->result();
    }
    public function get_payout_notification($email)
    {
        $this->db->where('event_type', 'Payout');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->get('notify_user')->result();
    }
    public function get_customization_notification($email)
    {
        $this->db->where('event_type', 'Customization Notifications');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->get('notify_user')->result();
    }
}
