<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile_model extends CI_Model
{
    //update profile
    public function update_profile($data, $user_id)
    {
        $user_id = clean_number($user_id);
        $this->load->model('upload_model');
        $temp_path = $this->upload_model->upload_temp_image('file');
        if (!empty($temp_path)) {
            //delete old avatar
            delete_file_from_server($this->auth_user->avatar);
            $data["avatar"] = $this->upload_model->avatar_upload($temp_path);
            $this->upload_model->delete_temp_image($temp_path);
        }
        $this->session->set_userdata('modesy_user_old_email', $this->auth_user->email);

        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }


    //update supllier data
    public function update_seller($data, $user_id)
    {
        $user_id = clean_number($user_id);

        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    //update story model
    public function update_story($data, $user_id)

    {
        $user_id = clean_number($user_id);
        $this->load->model('upload_model');

        // $temp_path = $this->upload_model->upload_temp_image('profile-image');
        // if (!empty($temp_path)) {
        //     //delete old avatar
        //     delete_file_from_server($this->auth_user->avatar);
        //     $data["avatar"] = $this->upload_model->avatar_upload($temp_path);
        //     $this->upload_model->delete_temp_image($temp_path);
        // }
        // $temp_path = $this->upload_model->upload_temp_image('logo-image');
        // if (!empty($temp_path)) {
        //     //delete old avatar
        //     delete_file_from_server($this->auth_user->brand_logo);
        //     $data["brand_logo"] = $this->upload_model->brand_logo_upload($temp_path);
        //     $this->upload_model->delete_temp_image($temp_path);
        // }
        // $temp_path_gst = $this->upload_model->upload_temp_image('gst-image');
        // if (!empty($temp_path_gst)) {
        //delete old avatar
        // delete_file_from_server($this->auth_user->gst_image);


        if ($this->upload_model->upload_pdf_gst_file('gst-image') != null) {
            delete_file_from_server($this->auth_user->gst_image);
            $data["gst_image"] = $this->upload_model->upload_pdf_gst_file('gst-image');
        }

        //     $this->upload_model->delete_temp_image($temp_path_gst);
        // }
        // $temp_path_pan = $this->upload_model->upload_temp_image('pan-image');
        // if (!empty($temp_path_pan)) {

        //     delete_file_from_server($this->auth_user->pan_image);
        if ($this->upload_model->upload_pdf_pan_file('pan-image') != null) {
            delete_file_from_server($this->auth_user->pan_image);
            $data["pan_image"] = $this->upload_model->upload_pdf_pan_file('pan-image');
        }
        //     $this->upload_model->delete_temp_image($temp_path_pan);
        // }
        // $temp_path_adhar = $this->upload_model->upload_temp_image('adhaar-image');
        // if (!empty($temp_path_adhar)) {
        if ($this->upload_model->upload_pdf_adhaar_file('adhaar-image') != null) {
            delete_file_from_server($this->auth_user->adhaar_image);
            $data["aadhar_image"] = $this->upload_model->upload_pdf_adhaar_file('adhaar-image');
        }
        //     $this->upload_model->delete_temp_image($temp_path_adhar);
        // }
        if ($this->upload_model->upload_pdf_file('other-image') != null) {
            delete_file_from_server($this->auth_user->other_image);
            $data["other_image"]  = $this->upload_model->upload_pdf_file('other-image');
        }
        // if (!empty($temp_path_other)) {

        //     delete_file_from_server($this->auth_user->other_image);
        //     $data["other_image"] = $this->upload_model->other_upload($temp_path_other);
        //     $this->upload_model->delete_temp_image($temp_path_other);
        // }

        $this->session->set_userdata('modesy_user_old_email', $this->auth_user->email);
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    // update supplier profile and logo
    public function update_supplier_profile_logo($data, $user_id)
    {

        $user_id = clean_number($user_id);
        $this->load->model('upload_model');


        $temp_path = $this->upload_model->upload_temp_image('profile-image');
        if (!empty($temp_path)) {
            //delete old avatar
            delete_file_from_server($this->auth_user->avatar);
            $data["avatar"] = $this->upload_model->avatar_upload($temp_path);
            $this->upload_model->delete_temp_image($temp_path);
        }


        $temp_path = $this->upload_model->upload_temp_image('logo-image');
        if (!empty($temp_path)) {
            //delete old brand logo
            delete_file_from_server($this->auth_user->brand_logo);
            $data["brand_logo"] = $this->upload_model->brand_logo_upload($temp_path);
            $this->upload_model->delete_temp_image($temp_path);
        }


        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }







    //update story model
    public function update_payout_account($data, $user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    //edit user
    public function edit_user($id)
    {
        $user = $this->auth_model->get_user($id);
        if (!empty($user)) {
            $data = array(
                'username' => $this->input->post('username', true),
                'email' => $this->input->post('email', true),
                'slug' => $this->input->post('slug', true),
                'first_name' => $this->input->post('first_name', true),
                'last_name' => $this->input->post('last_name', true),
                'phone_number' => $this->input->post('phone_number', true),
                'shop_name' => $this->input->post('shop_name', true),
                'about_me' => $this->input->post('about_me', true),
                'fssai_number' => $this->input->post('fssai_number', true),
                'pan_number' => $this->input->post('pan_number', true),
                'gst_number' => $this->input->post('gst_number', true),
                'landmark' => $this->input->post('landmark', true),
                'pincode' => $this->input->post('pincode', true),
                'supplier_area' => $this->input->post('area', true),
                'supplier_state' => $this->input->post('supplier_state', true),
                'supplier_city' => $this->input->post('supplier_city', true),
                'address' => $this->input->post('address', true),
                'house_no' => $this->input->post('house_no', true),
                'facebook_url' => $this->input->post('facebook_url', true),
                'twitter_url' => $this->input->post('twitter_url', true),
                'instagram_url' => $this->input->post('instagram_url', true),
                'pinterest_url' => $this->input->post('pinterest_url', true),
                'linkedin_url' => $this->input->post('linkedin_url', true),
                'vk_url' => $this->input->post('vk_url', true),
                'youtube_url' => $this->input->post('youtube_url', true)
            );

            $this->load->model('upload_model');
            $temp_path = $this->upload_model->upload_temp_image('file');
            if (!empty($temp_path)) {
                $data["avatar"] = $this->upload_model->avatar_upload($temp_path);
                $this->upload_model->delete_temp_image($temp_path);
                //delete old
                delete_file_from_server($user->avatar);
            }

            $this->db->where('id', $user->id);
            return $this->db->update('users', $data);
        }
    }

    //get story of user
    public function get_story_video($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('stories');
        return $query->row();
    }

    //update shop settings
    public function update_shop_settings($shop_name)
    {
        $user_id = $this->auth_user->id;
        $data = array(
            'shop_name' => $shop_name,
            'about_me' => $this->input->post('about_me', true),
            'show_rss_feeds' => $this->input->post('show_rss_feeds', true),
            'send_email_when_item_sold' => $this->input->post('send_email_when_item_sold', true)
        );

        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }
    public function delete_certificate($id)
    {
        if (!empty($id)) {
            delete_file_from_server($this->auth_user->other_image);
            $data = array(
                'other_image' => ''
            );
            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        }
        return false;
    }
    public function delete_gst($id)
    {
        if (!empty($id)) {
            delete_file_from_server($this->auth_user->gst_image);
            $data = array(
                'gst_image' => ''
            );
            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        }
        return false;
    }
    public function delete_adhaar($id)
    {
        if (!empty($id)) {
            delete_file_from_server($this->auth_user->aadhar_image);
            $data = array(
                'aadhar_image' => ''
            );
            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        }
        return false;
    }
    public function delete_pan($id)
    {
        if (!empty($id)) {
            delete_file_from_server($this->auth_user->pan_image);
            $data = array(
                'pan_image' => ''
            );
            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        }
        return false;
    }
    //check email updated
    public function check_email_updated($user_id)
    {
        $user_id = clean_number($user_id);
        if ($this->general_settings->email_verification == 1) {
            $user = $this->auth_model->get_user($user_id);
            if (!empty($user)) {
                if (!empty($this->session->userdata('modesy_user_old_email')) && $this->session->userdata('modesy_user_old_email') != $user->email) {
                    //send confirm email
                    $this->load->model("email_model");
                    $this->email_model->send_email_activation($user->id);
                    $data = array(
                        'email_status' => 0
                    );

                    $this->db->where('id', $user->id);
                    return $this->db->update('users', $data);
                }
            }
            if (!empty($this->session->userdata('modesy_user_old_email'))) {
                $this->session->unset_userdata('modesy_user_old_email');
            }
        }

        return false;
    }

    //update personal information
    public function update_personal_information()
    {
        $user_id = $this->auth_user->id;
        $data = array(
            'first_name' => $this->input->post('first_name', true),
            'last_name' => $this->input->post('last_name', true),
            'country_id' => $this->input->post('country_id', true),
            'state_id' => $this->input->post('state_id', true),
            'city_id' => $this->input->post('city_id', true),
            'address' => $this->input->post('address', true),
            'zip_code' => $this->input->post('zip_code', true),
            'phone_number' => $this->input->post('phone_number', true),
            'show_email' => $this->input->post('show_email', true),
            'show_phone' => $this->input->post('show_phone', true),
            'show_location' => $this->input->post('show_location', true)
        );

        if (empty($data['state_id'])) {
            $data['state_id'] = 0;
        }
        if (empty($data['city_id'])) {
            $data['city_id'] = 0;
        }
        if (empty($data['show_email'])) {
            $data['show_email'] = 0;
        }
        if (empty($data['show_phone'])) {
            $data['show_phone'] = 0;
        }
        if (empty($data['show_location'])) {
            $data['show_location'] = 0;
        }
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    //update shipping address
    public function update_shipping_address()
    {
        $user_id = $this->auth_user->id;
        $data = array(
            'shipping_first_name' => $this->input->post('shipping_first_name', true),
            'shipping_last_name' => $this->input->post('shipping_last_name', true),
            'shipping_email' => $this->input->post('shipping_email', true),
            'shipping_phone_number' => $this->input->post('shipping_phone_number', true),
            'shipping_zip_code' => $this->input->post('shipping_zip_code', true),
            'shipping_state' => $this->input->post('shipping_state', true),
            'shipping_city' => $this->input->post('shipping_city', true),
            'shipping_area' => $this->input->post('shipping_area', true),
            'shipping_address_1' => $this->input->post('shipping_address_1', true),
            'shipping_landmark' => $this->input->post('shipping_landmark', true),
            // 'shipping_country_id' => $this->input->post('shipping_country_id', true),
        );
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }
    public function update_setting()
    {
        $user_id = $this->auth_user->id;
        $data = array(
            'gst_number' => $this->input->post('gst_number1', true),
            'pan_number' => $this->input->post('pan_number1', true),
            // 'image_pancard' => $this->input->post('pan_photo', true),
            'adhaar_number' => $this->input->post('adhaar_number1', true),
            'gst_issue' => 0,
            'pan_issue' => 0,
            'pan_photo_issue' => 0,
            'adhaar_issue' => 0,


            // 'shipping_country_id' => $this->input->post('shipping_country_id', true),
        );
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }


    //update update social media
    public function update_social_media()
    {
        $user_id = $this->auth_user->id;
        $data = array(
            'facebook_url' => $this->input->post('facebook_url', true),
            'twitter_url' => $this->input->post('twitter_url', true),
            'instagram_url' => $this->input->post('instagram_url', true),
            'pinterest_url' => $this->input->post('pinterest_url', true),
            'linkedin_url' => $this->input->post('linkedin_url', true),
            'vk_url' => $this->input->post('vk_url', true),
            'youtube_url' => $this->input->post('youtube_url', true)
        );

        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }
    public function update_social_media_seller()
    {
        $user_id = $this->auth_user->id;
        $data = array(
            'supplier_facebook_url' => $this->input->post('facebook_url', true),
            'supplier_twitter_url' => $this->input->post('twitter_url', true),
            'supplier_instagram_url' => $this->input->post('instagram_url', true),
            'supplier_pinterest_url' => $this->input->post('pinterest_url', true),
            'supplier_linkedin_url' => $this->input->post('linkedin_url', true),
            'vk_url' => $this->input->post('vk_url', true),
            'supplier_youtube_url' => $this->input->post('youtube_url', true)
        );

        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    //change password input values
    public function change_password_input_values()
    {
        $data = array(
            'old_password' => $this->input->post('old_password', true),
            'password' => $this->input->post('password', true),
            'password_confirm' => $this->input->post('password_confirm', true)
        );
        return $data;
    }

    //change password
    public function change_password($old_password_exists)
    {
        $this->load->library('bcrypt');
        $user = $this->auth_user;
        if (!empty($user)) {
            $data = $this->change_password_input_values();
            if ($old_password_exists == 1) {
                //password does not match stored password.
                if (!$this->bcrypt->check_password($data['old_password'], $user->password)) {
                    $this->session->set_flashdata('error', trans("msg_wrong_old_password"));
                    $this->session->set_flashdata('form_data', $this->change_password_input_values());
                    redirect($this->agent->referrer());
                }
            }

            $data = array(
                'password' => $this->bcrypt->hash_password($data['password'])
            );

            $this->db->where('id', $user->id);
            return $this->db->update('users', $data);
        } else {
            return false;
        }
    }

    //follow user
    public function follow_unfollow_user()
    {
        $data = array(
            'following_id' => $this->input->post('following_id', true),
            'follower_id' => $this->input->post('follower_id', true)
        );

        $follow = $this->get_follow($data["following_id"], $data["follower_id"]);
        if (empty($follow)) {
            //add follower
            $this->db->insert('followers', $data);
        } else {
            $this->db->where('id', $follow->id);
            $this->db->delete('followers');
        }
    }

    //get user shipping address
    public function get_user_shipping_address($user_id)
    {
        $user_id = clean_number($user_id);
        $std = new stdClass();
        $std->shipping_first_name = "";
        $std->shipping_last_name = "";
        $std->shipping_email = "";
        $std->shipping_phone_number = "";
        $std->shipping_address_1 = "";
        $std->shipping_address_2 = "";
        $std->shipping_country_id = "";
        $std->shipping_state = "";
        $std->shipping_city = "";
        $std->shipping_zip_code = "";
        $std->shipping_area = "";
        $std->shipping_landmark = "";

        if (empty($user_id)) {
            return $std;
        }

        $row = get_user($user_id);
        if (!empty($row)) {
            return $row;
        } else {
            return $std;
        }
    }


    //follow
    public function get_follow($following_id, $follower_id)
    {
        $following_id = clean_number($following_id);
        $follower_id = clean_number($follower_id);
        $this->db->where('following_id', $following_id);
        $this->db->where('follower_id', $follower_id);
        $query = $this->db->get('followers');
        return $query->row();
    }

    //is user follows
    public function is_user_follows($following_id, $follower_id)
    {
        $following_id = clean_number($following_id);
        $follower_id = clean_number($follower_id);
        $follow = $this->get_follow($following_id, $follower_id);
        if (empty($follow)) {
            return false;
        } else {
            return true;
        }
    }

    //get followers
    public function get_followers($following_id)
    {
        $following_id = clean_number($following_id);
        $this->db->join('users', 'followers.follower_id = users.id');
        $this->db->select('users.*');
        $this->db->where('following_id', $following_id);
        $query = $this->db->get('followers');
        return $query->result();
    }

    public function get_usp()
    {

        $query = $this->db->get('usp_contents');
        return $query->result();
    }

    public function get_user_cards($user_id)
    {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('user_card_details');
        return $query->result();
    }
    public function get_user_addresses($user_id)
    {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('shipping_info');
        return $query->result();
    }

    //exempted goods
    public function get_exempted_food()
    {
        $query = $this->db->get('exempted_goods');
        return $query->result();
    }
    //get followers count
    public function get_followers_count($following_id)
    {
        $following_id = clean_number($following_id);
        $this->db->join('users', 'followers.follower_id = users.id');
        $this->db->select('users.*');
        $this->db->where('following_id', $following_id);
        $query = $this->db->get('followers');
        return $query->num_rows();
    }

    //get following users
    public function get_following_users($follower_id)
    {
        $follower_id = clean_number($follower_id);
        $this->db->join('users', 'followers.following_id = users.id');
        $this->db->select('users.*');
        $this->db->where('follower_id', $follower_id);
        $query = $this->db->get('followers');
        return $query->result();
    }

    //get following users
    public function get_following_users_count($follower_id)
    {
        $follower_id = clean_number($follower_id);
        $this->db->join('users', 'followers.following_id = users.id');
        $this->db->select('users.*');
        $this->db->where('follower_id', $follower_id);
        $query = $this->db->get('followers');
        return $query->num_rows();
    }

    //search members
    public function search_members($search)
    {
        $search = remove_special_characters($search);
        // $this->db->like('users.username', $search);
        $this->db->like('users.shop_name', $search);
        $query = $this->db->get('users');
        return $query->result();
    }

    //search members limited
    public function search_members_limited($search)
    {
        $search = remove_special_characters($search);
        $this->db->like('users.shop_name', $search);
        $this->db->or_like('users.first_name', $search);
        $this->db->or_like('users.brand_name', $search);
        $this->db->limit(8);
        $query = $this->db->get('users');
        return $query->result();
    }

    public function search_member_products_limited($search)
    {
        $search = remove_special_characters($search);
        $this->db->like('users.shop_name', $search);
        $this->db->or_like('users.first_name', $search);
        $this->db->or_like('users.brand_name', $search);
        $this->db->limit(8);
        $query = $this->db->get('users');
        return $query->result();
    }
    //search suppliers
    public function search_suppliers($search)
    {
        $search = remove_special_characters($search);
        $role = "vendor";
        $this->db->where('users.role', $role);
        $this->db->like('users.username', $search);
        $this->db->like('users.shop_name', $search);
        $query = $this->db->get('users');
        return $query->result();
    }

    //search suppliers speciality
    public function search_suppliers_speciality($type)
    {

        $sql = "select * from users where users.id IN(SELECT user_id from products where STATUS=1 GROUP BY user_id) and users.role='vendor' and users.supplier_speciality= ?";
        $query = $this->db->query($sql, array($type));

        return $query->result();
    }

    //get vendor data 
    public function get_vendor_data()
    {
        $role = "vendor";
        $this->db->where('users.role', $role);
        $this->db->where('users.is_promoted', 1);
        $query = $this->db->get('users');
        return $query->result();
    }
    public function get_vendor($id)
    {

        $this->db->where('users.id', $id);
        $query = $this->db->get('users');
        return $query->result();
    }
    //check for delivery possible or not
    public function product_deliverale_or_not($origin, $destination)
    {
        $origin = urlencode($origin);
        $destination = urlencode($destination);
        $key = $this->general_settings->distance_matrix_api_key;
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=[" . $origin . "]&destinations=[" . $destination . "]&key=" . $key . "";
        // create curl resource
        $ch = curl_init();
        // set url
        curl_setopt($ch, CURLOPT_URL, $url);


        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);

        return json_decode($output);
    }

    //update user mobile number when number if verified
    public function update_mobile_number($phn, $id)
    {
        $data['phone_number'] = $phn;
        $this->db->where('users.id', $id);
        return $this->db->update('users', $data);
    }

    //update fssai activity 
    public function update_fssai_undertaking($data, $user_id)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->update('activity', $data);
    }

    //get fssai action
    public function get_fssai_action($user_id)
    {
        $this->db->where('user_id', $user_id);
        $result = $this->db->get('activity');
        return $result->row();
    }

    //get fssai action checking for seller
    public function check_for_fssai_undertaking($user_id)
    {
        $sql = "SELECT DISTINCT user_id FROM products WHERE status = 1 and category_id IN (SELECT child_id FROM category_tree_relation WHERE main_id IN (2 , 3)) and user_id = ?";
        $query = $this->db->query($sql, array(clean_number($user_id)));
        if ($query->num_rows()) {
            $data = array(
                "user_id" => $user_id,
                "activity_code" => "FSSAI_UNDERTAKING"
            );
            $this->db->insert('activity', $data);
            return false;
        } else {
            return true;
        }
    }
}
