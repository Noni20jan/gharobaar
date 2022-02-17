<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification_model extends CI_Model
{
    public function get_gharobaar_updates($email)
    {

        $date = date("Y-m-d H:i:s", strtotime("-1 week"));
        // $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Gharobaar Updates');
        $this->db->where('read', 0);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query1 = $this->db->get('notify_user')->result();
        // $date = date("Y-m-d H:i:s", strtotime("-1 week"));
        $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Gharobaar Updates');
        $this->db->where('read', 1);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query2 = $this->db->get('notify_user')->result();
        $query = array_merge($query1, $query2);
        return $query;
    }
    public function get_order_placement($email)
    {
        $date = date("Y-m-d H:i:s", strtotime("-1 week"));
        // $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Order Placement');
        $this->db->where('read', 0);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query1 = $this->db->get('notify_user')->result();
        $date = date("Y-m-d H:i:s", strtotime("-1 week"));
        $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Order Placement');
        $this->db->where('read', 1);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query2 = $this->db->get('notify_user')->result();
        $query = array_merge($query1, $query2);
        return $query;
    }
    public function get_order_update($email)
    {
        $date = date("Y-m-d H:i:s", strtotime("-1 week"));
        // $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Order Update');
        $this->db->or_where('event_type', 'Order Updates');
        $this->db->where('read', 0);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query1 = $this->db->get('notify_user')->result();
        $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Order Update');
        $this->db->or_where('event_type', 'Order Updates');
        $this->db->where('read', 1);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query2 = $this->db->get('notify_user')->result();
        $query = array_merge($query1, $query2);
        return $query;
    }
    public function get_order_cancellation_by_seller($email)
    {
        $date = date("Y-m-d H:i:s", strtotime("-1 week"));
        // $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Order Cancellation by Seller');
        $this->db->where('read', 0);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query1 = $this->db->get('notify_user')->result();
        $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Order Cancellation by Seller');
        $this->db->where('read', 1);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query2 = $this->db->get('notify_user')->result();
        $query = array_merge($query1, $query2);
        return $query;
    }
    public function get_order_delivered($email)
    {
        $date = date("Y-m-d H:i:s", strtotime("-1 week"));
        // $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Order Delivered');
        $this->db->where('read', 0);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query1 = $this->db->get('notify_user')->result();
        $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Order Delivered');
        $this->db->where('read', 1);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query2 = $this->db->get('notify_user')->result();
        $query = array_merge($query1, $query2);
        return $query;
    }
    public function get_promotions($email)
    {
        $date = date("Y-m-d H:i:s", strtotime("-1 week"));
        // $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Promotions');
        $this->db->where('read', 0);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query1 = $this->db->get('notify_user')->result();
        $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Promotions');
        $this->db->where('read', 1);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query2 = $this->db->get('notify_user')->result();
        $query = array_merge($query1, $query2);
        return $query;
    }
    public function get_reviews_followers($email)
    {
        $date = date("Y-m-d H:i:s", strtotime("-1 week"));
        // $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Rating, Reviews & Followers');
        $this->db->where('read', 0);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query1 = $this->db->get('notify_user')->result();
        $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Rating, Reviews & Followers');
        $this->db->where('read', 1);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query2 = $this->db->get('notify_user')->result();
        $query = array_merge($query1, $query2);
        return $query;
    }
    public function get_listings($email)
    {
        $date = date("Y-m-d H:i:s", strtotime("-1 week"));
        // $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Listings');
        $this->db->where('read', 0);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query1 = $this->db->get('notify_user')->result();
        $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Listings');
        $this->db->where('read', 1);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query2 = $this->db->get('notify_user')->result();
        $query = array_merge($query1, $query2);
        return $query;
    }
    public function get_profile_notification($email)
    {
        $date = date("Y-m-d H:i:s", strtotime("-1 week"));
        // $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Profile');
        $this->db->where('read', 0);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query1 = $this->db->get('notify_user')->result();
        $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Profile');
        $this->db->where('read', 1);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query2 = $this->db->get('notify_user')->result();
        $query = array_merge($query1, $query2);
        return $query;
    }
    public function get_payout_notification($email)
    {
        $date = date("Y-m-d H:i:s", strtotime("-1 week"));
        // $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Payout');
        $this->db->where('read', 0);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query1 = $this->db->get('notify_user')->result();
        $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Payout');
        $this->db->where('read', 1);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query2 = $this->db->get('notify_user')->result();
        $query = array_merge($query1, $query2);
        return $query;
    }
    public function get_customization_notification($email)
    {
        $date = date("Y-m-d H:i:s", strtotime("-1 week"));
        // $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Customization Notifications');
        $this->db->where('read', 0);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query1 = $this->db->get('notify_user')->result();
        $this->db->where('read_date >=', $date);
        $this->db->where('event_type', 'Customization Notifications');
        $this->db->where('read', 1);
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        $this->db->order_by("time", "DESC");
        $query2 = $this->db->get('notify_user')->result();
        $query = array_merge($query1, $query2);
        return $query;
    }
    public function get_notification_count()
    {
        $id = $this->auth_user->id;
        $email = $this->auth_user->email;
        $phone = $this->auth_user->phone_number;
        $this->db->group_start();
        $this->db->where('event_type', 'Gharobaar Updates');
        $this->db->or_where('event_type', 'Customization Notifications');
        $this->db->or_where('event_type', 'Listings');
        $this->db->or_where('event_type', 'Rating, Reviews & Followers');
        $this->db->or_where('event_type', 'Order Update');
        $this->db->or_where('event_type', 'Order Updates');
        $this->db->or_where('event_type', 'Order Placement');
        $this->db->or_where('event_type', 'Payout');
        $this->db->or_where('event_type', 'Profile');
        $this->db->or_where('event_type', 'Promotions');
        $this->db->or_where('event_type', 'Order Delivered');
        $this->db->or_where('event_type', 'Order Cancellation by Seller');
        $this->db->group_end();
        $this->db->where('for_user', $email);
        $this->db->where('read', 0);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return  $query1 = $this->db->get('notify_user')->result();
    }
    public function gharobaar_updates_read($email)
    {
        $data['read_date']  = date("Y-m-d H:i:s");
        $data['read'] = 1;
        $this->db->where('event_type', 'Gharobaar Updates');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->update('notify_user', $data);
    }
    public function order_update_read($email)
    {
        $data['read_date']  = date("Y-m-d H:i:s");
        $data['read'] = 1;
        $this->db->where('event_type', 'Order Update');
        $this->db->or_where('event_type', 'Order Updates');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->update('notify_user', $data);
    }
    public function order_placement_read($email)
    {
        $data['read_date']  = date("Y-m-d H:i:s");
        $data['read'] = 1;
        $this->db->where('event_type', 'Order Placement');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->update('notify_user', $data);
    }
    public function order_cancel_seller_read($email)
    {
        $data['read_date']  = date("Y-m-d H:i:s");
        $data['read'] = 1;
        $this->db->where('event_type', 'Order Cancellation by Seller');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->update('notify_user', $data);
    }
    public function order_delivered_read($email)
    {
        $data['read_date']  = date("Y-m-d H:i:s");
        $data['read'] = 1;
        $this->db->where('event_type', 'Order Delivered');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->update('notify_user', $data);
    }
    public function update_promotion_read($email)
    {
        $data['read_date']  = date("Y-m-d H:i:s");
        $data['read'] = 1;
        $this->db->where('event_type', 'Promotions');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->update('notify_user', $data);
    }
    public function update_review_follower_read($email)
    {
        $data['read_date']  = date("Y-m-d H:i:s");
        $data['read'] = 1;
        $this->db->where('event_type', 'Rating, Reviews & Followers');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->update('notify_user', $data);
    }
    public function update_listing_read($email)
    {
        $data['read_date']  = date("Y-m-d H:i:s");
        $data['read'] = 1;
        $this->db->where('event_type', 'Listings');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->update('notify_user', $data);
    }
    public function update_profile_read($email)
    {
        $data['read_date']  = date("Y-m-d H:i:s");
        $data['read'] = 1;
        $this->db->where('event_type', 'Profile');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->update('notify_user', $data);
    }
    public function update_payout_read($email)
    {
        $data['read_date']  = date("Y-m-d H:i:s");
        $data['read'] = 1;
        $this->db->where('event_type', 'Payout');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->update('notify_user', $data);
    }
    public function update_customization_read($email)
    {
        $data['read_date']  = date("Y-m-d H:i:s");
        $data['read'] = 1;
        $this->db->where('event_type', 'Customization Notifications');
        $this->db->where('for_user', $email);
        $this->db->join('notifications', "notifications.id=notify_user.notification_id");
        return $this->db->update('notify_user', $data);
    }
    public function date_compare($element1, $element2)
    {
        $datetime1 = strtotime($element1['created_at']);
        $datetime2 = strtotime($element2['created_at']);
        return $datetime1 - $datetime2;
    }
}
