<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Review_model extends CI_Model
{
    //add review
    public function add_review($rating, $product_id, $review_text, $img)
    {
        // var_dump($_FILES['file_']['size'][0]);
        $product = $this->product_model->get_product_by_id($product_id);
        $title = $this->product_model->get_title($product_id);
        $buyer_name = $this->auth_user->first_name;
        $user = get_user($product->user_id);

        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if (!empty($rating) && !empty($product_id)   && empty($review_text) && $_FILES['file_']['size'][0] == 0) {
            $data = array(
                'product_id' => $product_id,
                'user_id' => $this->auth_user->id,
                'rating' => $rating,
                'ip_address' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'is_approved' => 1
            );
            $data1 = array(
                'source' => 'review',
                // 'source_id' => $product_id,
                'remark' => $buyer_name . " has rated your product " . $title->title . " .",
                'event_type' => 'Rating, Reviews & Followers',
                'subject' => "New Review on you product",
                'message' => "",
                'source_id' => "",
                'to' => $user->email,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            );

            $this->load->model("email_model");
            $this->email_model->notification($data1);
        } else {
            $data = array(
                'product_id' => $product_id,
                'user_id' => $this->auth_user->id,
                'rating' => $rating,
                'review' => $review_text,
                'ip_address' => 0,
                'created_at' => date("Y-m-d H:i:s")
            );
        }

        // var_dump($data1);
        // die();
        if (!empty($data['product_id']) && !empty($data['user_id']) && !empty($data['rating'])) {

            $this->db->insert('reviews', $data);
            $last_id = $this->db->insert_id();
        }
        unset($data);
        return $last_id;
    }

    public function add_review1($rating, $product_id, $review_text)
    {
        $seller_id = get_seller_id_by_product_id($product_id);
        $product = $this->product_model->get_product_by_id($product_id);
        $title = $this->product_model->get_title($product_id);
        $buyer_name = $this->auth_user->first_name;
        $user = get_user($product->user_id);
        // var_dump($_FILES['file_' . $product_id]['size']);
        // die();

        if (!empty($rating) && !empty($product_id)   && empty($review_text) && $_FILES['file_' . $product_id]['size'][0] == 0) {
            $data = array(
                'product_id' => $product_id,
                'user_id' => $this->auth_user->id,
                'rating' => $rating,
                'ip_address' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'is_approved' => 1
            );
            $data1 = array(
                'source' => 'review',
                // 'source_id' => $product_id,
                'remark' => $buyer_name . " has rated your product " . $title->title . " .",
                'event_type' => 'Rating, Reviews & Followers',
                'subject' => "New Review on you product",
                'message' => "",
                'source_id' => "",
                'to' => $user->email,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            );
            $this->load->model("email_model");
            $this->email_model->notification($data1);
        } else {
            $data = array(
                'product_id' => $product_id,
                'user_id' => $this->auth_user->id,
                'supplier_id' => $seller_id,
                'rating' => $rating,
                'review' => $review_text,
                'ip_address' => 0,
                'created_at' => date("Y-m-d H:i:s")
            );
            // $buyer_name = $this->auth_user->first_name;
            // $user = get_user($product->user_id);

            // $approved_review = $this->review_model->get_reviews_for_notification($product_id1, $product->user_id);
            // var_dump($approved_review);
            // die();
        }

        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if (!empty($data['product_id']) && !empty($data['user_id']) && !empty($data['rating'])) {
            if ($this->db->insert('reviews', $data)) {
                $last_id = $this->db->insert_id();
            }
            //update product rating
            // $this->update_product_rating($product_id);
        }
        unset($data);
        return $last_id;
    }
    public function upload_review_images($last_id, $path, $product_id1)
    {
        // $seller_id = get_seller_id_by_product_id($product_id);
        $data = array(

            'review_id' => $last_id,
            'image_url' => $path,
            'created_at' => date("Y-m-d H:i:s"),
            'product_id' => $product_id1
        );

        if ($this->db->insert('review_images', $data)) {
        }

        unset($data);
        return $last_id;
    }
    //update review
    public function update_review($review_id, $rating, $product_id, $review_text)
    {

        if (!empty($rating) && !empty($product_id)   && empty($review_text) && $_FILES['file_' . $product_id]['size'][0] == 0) {
            $data = array(
                'rating' => $rating,
                'review' => $review_text,
                'ip_address' => 0,
                'is_approved' => 1,
                'created_at' => date("Y-m-d H:i:s")
            );
        } else {
            $data = array(
                'rating' => $rating,
                'review' => $review_text,
                'ip_address' => 0,
                'created_at' => date("Y-m-d H:i:s")
            );
        }
        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if (!empty($data['rating'])) {
            $this->db->where('product_id', $product_id);
            $this->db->where('user_id', $this->auth_user->id);
            $this->db->update('reviews', $data);

            $feedback = $this->db->last_query();
            if (!empty($feedback)) {
                return TRUE;
            } else {
                return FALSE;
            }
            //update product rating
            // $this->update_product_rating($product_id);
        }
    }
    public function update_review1($review_id, $rating, $product_id, $review_text)
    {
        $data = array(
            'rating' => $rating,
            'review' => $review_text,
            'ip_address' => 0,
            'created_at' => date("Y-m-d H:i:s")
        );
        $ip = $this->input->ip_address();
        if (!empty($ip)) {
            $data['ip_address'] = $ip;
        }
        if (!empty($data['rating']) && !empty($data['review'])) {
            $this->db->where('product_id', $product_id);
            $this->db->where('user_id', $this->auth_user->id);
            $this->db->update('reviews', $data);
            //update product rating
            unset($data);
            // $this->update_product_rating($product_id);
        }
    }

    //get review count
    public function get_review_count($product_id)
    {
        $product_id = clean_number($product_id);
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->where('reviews.product_id', $product_id);
        $this->db->where('reviews.is_approved', '1');
        $query = $this->db->get('reviews');
        return $query->num_rows();
    }

    //get reviews
    public function get_reviews($product_id)
    {
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->select('reviews.*, users.username as user_username, users.slug as user_slug');
        $this->db->where('reviews.is_approved', '1');
        $this->db->where('reviews.product_id', clean_number($product_id));
        $this->db->order_by('reviews.created_at', 'DESC');
        return $this->db->get('reviews')->result();
    }

    public function get_review_images($product_id)
    {
        $this->db->join('review_images', 'review_images.review_id= reviews.id');
        $this->db->select('reviews.*,review_images.image_url');
        $this->db->where('reviews.is_approved', '1');
        $this->db->where('reviews.product_id', clean_number($product_id));
        return $this->db->get('reviews')->result();
    }
    public function check_review_images($product_id, $user_id)
    {
        $this->db->join('review_images', 'review_images.review_id= reviews.id');
        $this->db->select('review_images.image_url');
        $this->db->where('reviews.product_id', clean_number($product_id));
        $this->db->where('reviews.user_id', clean_number($user_id));
        return $this->db->get('reviews')->result();
    }
    //get seller review
    public function get_seller_reviews($supplier_id)
    {
        $this->db->join('users', 'users.id = supplier_review.user_id');
        $this->db->select('supplier_review.*, users.username as user_username, users.slug as user_slug');
        $this->db->where('supplier_review.supplier_id', clean_number($supplier_id));

        $this->db->order_by('supplier_review.created_at', 'DESC');
        return $this->db->get('supplier_review')->result();
    }

    //get all reviews
    public function get_all_reviews()
    {
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->join('products', 'products.id = reviews.product_id');
        $this->db->select('reviews.*, users.username AS user_username, users.slug AS user_slug');
        $this->db->where('reviews.is_approved', '1');

        $this->db->order_by('reviews.created_at', 'DESC');
        $query = $this->db->get('reviews');
        return $query->result();
    }

    //get latest reviews
    public function get_latest_reviews($limit)
    {
        $limit = clean_number($limit);
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->select('reviews.*, users.username as user_username');
        $this->db->order_by('reviews.created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('reviews');
        return $query->result();
    }

    //get limited reviews
    public function get_limited_reviews($product_id, $limit)
    {
        $product_id = clean_number($product_id);
        $limit = clean_number($limit);
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->select('reviews.*, users.username as user_username, users.slug as user_slug');
        $this->db->where('reviews.product_id', $product_id);
        $this->db->order_by('reviews.created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('reviews');
        return $query->result();
    }

    //get review
    public function get_review($product_id, $user_id)
    {
        $product_id = clean_number($product_id);
        $user_id = clean_number($user_id);
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->select('reviews.*, users.username as user_username, users.slug as user_slug');
        $this->db->where('reviews.product_id', $product_id);
        $this->db->where('users.id', $user_id);
        $query = $this->db->get('reviews');
        return $query->row();
    }

    //update product rating
    public function update_product_rating($product_id)
    {
        $product_id = clean_number($product_id);
        $reviews = $this->get_reviews($product_id);
        $data = array();
        if (!empty($reviews)) {
            $count = count($reviews);
            $total = 0;
            foreach ($reviews as $review) {
                $total += $review->rating;
            }
            $data['rating'] = round($total / $count);
        } else {
            $data['rating'] = 0;
        }
        $this->db->where('id', $product_id);
        $this->db->update('products', $data);
    }

    //get paginated vendor reviews
    public function get_paginated_vendor_reviews($user_id, $per_page, $offset)
    {
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->join('products', 'products.id = reviews.product_id');
        $this->db->select('reviews.*, users.username AS user_username, users.slug AS user_slug');
        $this->db->where('products.user_id', clean_number($user_id));
        $this->db->order_by('reviews.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('reviews');
        return $query->result();
    }

    //get vendor reviews count
    public function get_vendor_reviews_count($user_id)
    {
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->join('products', 'products.id = reviews.product_id');
        $this->db->select('reviews.*, users.username as user_username, users.slug as user_slug');
        $this->db->where('products.user_id', clean_number($user_id));
        return $this->db->count_all_results('reviews');
    }

    //calculate user rating
    public function calculate_user_rating($user_id)
    {
        $std = new stdClass();
        $std->count = 0;
        $std->rating = 0;

        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->join('products', 'products.id = reviews.product_id');
        $this->db->select('COUNT(reviews.id) AS count, SUM(reviews.rating) AS total');
        $this->db->where('products.user_id', clean_number($user_id));
        $query = $this->db->get('reviews');
        if (!empty($query->row())) {
            $total = $query->row()->total;
            $count = $query->row()->count;
            if (!empty($total) and !empty($count)) {
                $avg = round($total / $count);
                $std->count = $count;
                $std->rating = $avg;
            }
        }
        return $std;
    }

    //delete review
    public function delete_review($id, $product_id = null)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('reviews');
        $row = $query->row();
        if (empty($row)) {
            return false;
        }
        $product = get_product($row->product_id);
        if (empty($product)) {
            return false;
        }

        $this->db->where('id', $id);
        if ($this->db->delete('reviews')) {
            //update product rating
            // $this->update_product_rating($product->id);
            return true;
        }
        return false;
    }
    public function approve_review($id, $product_id = null)
    {

        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('reviews');
        $row = $query->row();
        if (empty($row)) {
            return false;
        }
        $product = get_product($row->product_id);
        $buyer_name = get_user($row->user_id);
        $title = $this->product_model->get_title($row->product_id);
        $user = get_user($product->user_id);
        if (empty($product)) {
            return false;
        }
        $data = array(
            'is_approved' => 1
        );
        $data1 = array(
            'source' => 'review',
            // 'source_id' => $product_id,
            'remark' => $buyer_name . " has rated your product " . $title->title . " .",
            'event_type' => 'Rating, Reviews & Followers',
            'subject' => "New Review on you product",
            // 'message' => "Your Favourite Seller" . ucfirst($user->first_name) . " has launched a new product <a href='" . base_url() . $product->slug . "'>" .  $title->title . "</a>.",
            'to' => $user->email,
            'template_path' => "email/email_newsletter",
            'subscriber' => "",
        );
        $this->load->model("email_model");
        $this->email_model->notification($data1);
        $this->db->where('id', $id);
        if ($this->db->update('reviews', $data)) {

            return true;
        }
        return false;
    }


    //delete multi reviews
    public function delete_multi_reviews($review_ids)
    {
        if (!empty($review_ids)) {
            foreach ($review_ids as $id) {
                $this->delete_review($id);
            }
        }
    }

    public function get_not_approved_reviews()
    {
        $this->db->join('users', 'users.id = reviews.user_id');
        $this->db->join('products', 'products.id = reviews.product_id');
        $this->db->select('reviews.*, users.username AS user_username, users.slug AS user_slug');
        $this->db->where('reviews.is_approved', '0');
        $this->db->order_by('reviews.created_at', 'DESC');
        $query = $this->db->get('reviews');
        return $query->result();
    }

    public function approve_multi_reviews($review_ids)
    {
        if (!empty($review_ids)) {
            foreach ($review_ids as $id) {
                $this->approve_review($id);
            }
        }
    }
    // public function get_reviews_for_notification($product_id, $user_id)
    // {
    //     $product_ids = clean_number($product_id);

    //     $this->db->where('product_id', $product_ids);
    //     $this->db->where('user_id', $user_id);
    //     $query = $this->db->get('reviews');
    //     return  $query->row();
    // }
}
