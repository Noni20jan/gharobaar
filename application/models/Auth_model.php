<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'username' => remove_special_characters($this->input->post('username', true)),
            'email' => $this->input->post('email', true),
            'first_name' => ucfirst($this->input->post('first_name', true)),
            'last_name' => ucfirst($this->input->post('last_name', true)),
            'password' => $this->input->post('password', true),
            // 'date_of_birth' => $this->input->post('date_of_birth', true),
            'phone_number' => $this->input->post('phone_number', true),
            'gender' => $this->input->post('gender', true),
            'via_sell_now' => $this->input->post('via_sell_now', true)
        );
        return $data;
    }

    //login
    public function login()
    {
        $this->load->library('bcrypt');

        $data = $this->input_values();
        $user = $this->get_user_by_email_register($data['email']);

        if (!empty($user)) {
            //check master key
            if ($this->general_settings->master_key === $data['password']) {
                //set user data
                $user_data = array(
                    'modesy_sess_unique_id' => md5(microtime() . rand()),
                    'modesy_sess_user_id' => $user->id,
                    'modesy_sess_user_email' => $user->email,
                    'modesy_sess_user_role' => $user->role,
                    'modesy_sess_logged_in' => true,
                    'modesy_sess_app_key' => $this->config->item('app_key'),
                );
                $this->session->set_userdata($user_data);

                $this->save_user_login_session_data();

                $this->cart_model->add_session_to_cart_in_db($user->id);

                $user_cart = $this->cart_model->get_user_cart_from_db($user->id);

                if (!empty($user_cart)) {
                    $user_cart_id = $user_cart->id;
                    $cart_details = $this->cart_model->get_cart_details_by_id($user_cart_id);
                    $this->cart_model->add_cart_to_session_from_db($cart_details, true);
                }

                return $user;
            }
            //check password
            if (!$this->bcrypt->check_password($data['password'], $user->password)) {
                $this->session->set_flashdata('error', trans("login_error"));
                return false;
            }
            if ($user->email_status != 1) {
                $this->session->set_flashdata('error', trans("msg_confirmed_required") . "&nbsp;<a href='javascript:void(0)' class='link-resend-activation-email' onclick=\"send_activation_email('" . $user->id . "','" . $user->token . "');\">" . trans("resend_activation_email") . "</a>");
                return false;
            }
            if ($user->banned == 1) {
                $this->session->set_flashdata('error', trans("msg_ban_error"));
                return false;
            }
            //set user data
            $user_data = array(
                'modesy_sess_unique_id' => md5(microtime() . rand()),
                'modesy_sess_user_id' => $user->id,
                'modesy_sess_user_email' => $user->email,
                'modesy_sess_user_role' => $user->role,
                'modesy_sess_logged_in' => true,
                'modesy_sess_app_key' => $this->config->item('app_key'),
            );
            $this->session->set_userdata($user_data);

            $this->save_user_login_session_data();

            $this->cart_model->add_session_to_cart_in_db($user->id);

            $user_cart = $this->cart_model->get_user_cart_from_db($user->id);

            if (!empty($user_cart)) {
                $user_cart_id = $user_cart->id;
                $cart_details = $this->cart_model->get_cart_details_by_id($user_cart_id);
                $this->cart_model->add_cart_to_session_from_db($cart_details, true);
            }
            return $user;
        } else if (empty($user)) {
            $user = $this->get_user_by_mobile($data['email']);
            if (!empty($user)) {
                //check master key
                if ($this->general_settings->master_key === $data['password']) {
                    //set user data
                    $user_data = array(
                        'modesy_sess_unique_id' => md5(microtime() . rand()),
                        'modesy_sess_user_id' => $user->id,
                        'modesy_sess_user_email' => $user->email,
                        'modesy_sess_user_role' => $user->role,
                        'modesy_sess_logged_in' => true,
                        'modesy_sess_app_key' => $this->config->item('app_key'),
                    );
                    $this->session->set_userdata($user_data);
                    return $user;
                }
                //check password
                if (!$this->bcrypt->check_password($data['password'], $user->password)) {
                    $this->session->set_flashdata('error', trans("login_error"));
                    return false;
                }
                if ($user->email_status != 1) {
                    $this->session->set_flashdata('error', trans("msg_confirmed_required") . "&nbsp;<a href='javascript:void(0)' class='link-resend-activation-email' onclick=\"send_activation_email('" . $user->id . "','" . $user->token . "');\">" . trans("resend_activation_email") . "</a>");
                    return false;
                }
                if ($user->banned == 1) {
                    $this->session->set_flashdata('error', trans("msg_ban_error"));
                    return false;
                }
                //set user data
                $user_data = array(
                    'modesy_sess_unique_id' => md5(microtime() . rand()),
                    'modesy_sess_user_id' => $user->id,
                    'modesy_sess_user_email' => $user->email,
                    'modesy_sess_user_role' => $user->role,
                    'modesy_sess_logged_in' => true,
                    'modesy_sess_app_key' => $this->config->item('app_key'),
                );
                $this->session->set_userdata($user_data);

                $this->save_user_login_session_data();

                $this->cart_model->add_session_to_cart_in_db($user->id);

                $user_cart = $this->cart_model->get_user_cart_from_db($user->id);

                if (!empty($user_cart)) {
                    $user_cart_id = $user_cart->id;
                    $cart_details = $this->cart_model->get_cart_details_by_id($user_cart_id);
                    $this->cart_model->add_cart_to_session_from_db($cart_details, true);
                }
                return $user;
            } else {
                $this->session->set_flashdata('error', trans("login_error"));
                return false;
            }
        }
    }


    // get the user session data usign mobile number
    public function set_user_session_data($mobile_number)
    {
        if (empty($user)) {
            $user = $this->get_user_by_mobile($mobile_number);
            if (!empty($user)) {

                if ($user->email_status != 1) {
                    $this->session->set_flashdata('error', trans("msg_confirmed_required") . "&nbsp;<a href='javascript:void(0)' class='link-resend-activation-email' onclick=\"send_activation_email('" . $user->id . "','" . $user->token . "');\">" . trans("resend_activation_email") . "</a>");
                    return false;
                }
                if ($user->banned == 1) {
                    $this->session->set_flashdata('error', trans("msg_ban_error"));
                    return false;
                }
                //set user data
                $user_data = array(
                    'modesy_sess_unique_id' => md5(microtime() . rand()),
                    'modesy_sess_user_id' => $user->id,
                    'modesy_sess_user_email' => $user->email,
                    'modesy_sess_user_role' => $user->role,
                    'modesy_sess_logged_in' => true,
                    'modesy_sess_app_key' => $this->config->item('app_key'),
                );
                $this->session->set_userdata($user_data);

                $this->save_user_login_session_data();

                $this->cart_model->add_session_to_cart_in_db($user->id);

                $user_cart = $this->cart_model->get_user_cart_from_db($user->id);

                if (!empty($user_cart)) {
                    $user_cart_id = $user_cart->id;
                    $cart_details = $this->cart_model->get_cart_details_by_id($user_cart_id);
                    $this->cart_model->add_cart_to_session_from_db($cart_details, true);
                }
                return $user;
            } else {
                $this->session->set_flashdata('error', trans("login_error"));
                return false;
            }
        }
    }

    // save login session data to db
    public function save_user_login_session_data()
    {
        $sessiondata = $this->session->get_userdata();
        $session_user_data = array(
            '__ci_last_regenerate' => $sessiondata["__ci_last_regenerate"],
            'modesy_sess_unique_id' => $sessiondata["modesy_sess_unique_id"],
            'modesy_sess_user_id' => $sessiondata["modesy_sess_user_id"],
            'modesy_sess_user_email' => $sessiondata["modesy_sess_user_email"],
            'modesy_sess_user_role' => $sessiondata["modesy_sess_user_role"],
            'modesy_sess_logged_in' => $sessiondata["modesy_sess_logged_in"],
            'modesy_sess_app_key' => $sessiondata["modesy_sess_app_key"]
        );
        if (!empty($session_user_data)) {
            $this->db->insert('session_user_details', $session_user_data);
        }
    }

    // delete session data from db
    public function delete_user_login_session_data()
    {
        $sessiondata = $this->session->get_userdata();
        $session_user_data = array(
            'is_active' => 0
        );
        if (!empty($session_user_data)) {
            $this->db->where('modesy_sess_unique_id', $sessiondata["modesy_sess_unique_id"]);
            $this->db->update('session_user_details', $session_user_data);
        }
    }

    //login direct
    public function login_direct($user)
    {
        //set user data
        $user_data = array(
            'modesy_sess_unique_id' => md5(microtime() . rand()),
            'modesy_sess_user_id' => $user->id,
            'modesy_sess_user_email' => $user->email,
            'modesy_sess_user_role' => $user->role,
            'modesy_sess_logged_in' => true,
            'modesy_sess_app_key' => $this->config->item('app_key'),
            'ghrobaar_register' => true,
        );

        $this->session->set_userdata($user_data);
        $this->save_user_login_session_data();

        $this->cart_model->add_session_to_cart_in_db($user->id);

        $user_cart = $this->cart_model->get_user_cart_from_db($user->id);

        if (!empty($user_cart)) {
            $user_cart_id = $user_cart->id;
            $cart_details = $this->cart_model->get_cart_details_by_id($user_cart_id);
            $this->cart_model->add_cart_to_session_from_db($cart_details, true);
        }
    }

    //login with facebook
    public function login_with_facebook($fb_user)
    {
        if (!empty($fb_user)) {
            $user = $this->get_user_by_email($fb_user->email);
            //check if user registered
            if (empty($user)) {
                if (empty($fb_user->name)) {
                    $fb_user->name = "user-" . uniqid();
                }
                $username = $this->generate_uniqe_username($fb_user->name);
                $slug = $this->generate_uniqe_slug($username);
                //add user to database
                $data = array(
                    'facebook_id' => $fb_user->id,
                    'email' => $fb_user->email,
                    'email_status' => 1,
                    'token' => generate_token(),
                    'role' => "member",
                    'username' => $username,
                    'first_name' => $fb_user->name,
                    'slug' => $slug,
                    'avatar' => "https://graph.facebook.com/" . $fb_user->id . "/picture?type=large",
                    'user_type' => "facebook",
                    'last_seen' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                );
                if ($this->general_settings->vendor_verification_system != 1) {
                    $data['role'] = "vendor";
                }
                if (!empty($data['email'])) {
                    $this->db->insert('users', $data);
                    $user = $this->get_user_by_email($fb_user->email);
                    $this->login_direct($user);
                }
            } else {
                //login
                $this->login_direct($user);
            }
        }
    }

    //login with google
    public function login_with_google($g_user)
    {
        if (!empty($g_user)) {
            $user = $this->get_user_by_email($g_user->email);
            //check if user registered
            if (empty($user)) {
                if (empty($g_user->name)) {
                    $g_user->name = "user-" . uniqid();
                }
                $username = $this->generate_uniqe_username($g_user->name);
                $slug = $this->generate_uniqe_slug($username);
                //add user to database
                $data = array(
                    'google_id' => $g_user->id,
                    'email' => $g_user->email,
                    'email_status' => 1,
                    'token' => generate_unique_id(),
                    'role' => "member",
                    'username' => $username,
                    'first_name' => $g_user->name,
                    'slug' => $slug,
                    'avatar' => $g_user->avatar,
                    'user_type' => "google",
                    'last_seen' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                );
                if ($this->general_settings->vendor_verification_system != 1) {
                    $data['role'] = "vendor";
                }
                if (!empty($data['email'])) {
                    $this->db->insert('users', $data);
                    $user = $this->get_user_by_email($g_user->email);
                    $this->login_direct($user);
                }
            } else {
                //login
                $this->login_direct($user);
            }
        }
    }

    //login with vk
    public function login_with_vk($vk_user)
    {
        if (!empty($vk_user)) {
            $user = $this->get_user_by_email($vk_user->email);
            //check if user registered
            if (empty($user)) {
                if (empty($vk_user->name)) {
                    $vk_user->name = "user-" . uniqid();
                }
                $username = $this->generate_uniqe_username($vk_user->name);
                $slug = $this->generate_uniqe_slug($username);
                //add user to database
                $data = array(
                    'google_id' => $vk_user->id,
                    'email' => $vk_user->email,
                    'email_status' => 1,
                    'token' => generate_unique_id(),
                    'role' => "member",
                    'username' => $username,
                    'first_name' => $vk_user->name,
                    'slug' => $slug,
                    'avatar' => $vk_user->avatar,
                    'user_type' => "vkontakte",
                    'last_seen' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                );
                if ($this->general_settings->vendor_verification_system != 1) {
                    $data['role'] = "vendor";
                }
                if (!empty($data['email'])) {
                    $this->db->insert('users', $data);
                    $user = $this->get_user_by_email($vk_user->email);
                    $this->login_direct($user);
                }
            } else {
                //login
                $this->login_direct($user);
            }
        }
    }

    //generate uniqe username
    public function generate_uniqe_username($username)
    {
        $new_username = $username;
        if (!empty($this->get_user_by_username($new_username))) {
            $new_username = $username . " 1";
            if (!empty($this->get_user_by_username($new_username))) {
                $new_username = $username . " 2";
                if (!empty($this->get_user_by_username($new_username))) {
                    $new_username = $username . " 3";
                    if (!empty($this->get_user_by_username($new_username))) {
                        $new_username = $username . "-" . uniqid();
                    }
                }
            }
        }
        return $new_username;
    }

    //generate uniqe slug
    public function generate_uniqe_slug($username)
    {
        $slug = str_slug($username);
        if (!empty($this->get_user_by_slug($slug))) {
            $slug = str_slug($username . "-1");
            if (!empty($this->get_user_by_slug($slug))) {
                $slug = str_slug($username . "-2");
                if (!empty($this->get_user_by_slug($slug))) {
                    $slug = str_slug($username . "-3");
                    if (!empty($this->get_user_by_slug($slug))) {
                        $slug = str_slug($username . "-" . uniqid());
                    }
                }
            }
        }
        return $slug;
    }
    // public function get_address($id)
    // {
    //     $this->db->where('shipping_info.id', clean_number($id));
    //     return $this->db->get('shipping_info')->row();
    // }
    // public function delete_address($id)
    // {
    //     $address = $this->get_address($id);
    //     if (!empty($address)) {
    //         $data['is_active'] = 0;

    //         $this->db->where('id', $address->id);
    //         return $this->db->update('shipping_info',$data);
    //     }

    //     return false;
    // }

    //register
    public function register()
    {
        $this->load->library('bcrypt');

        $data = $this->auth_model->input_values();
        $data['username'] = remove_special_characters($data['email']);
        //secure password
        $data['password'] = $this->bcrypt->hash_password($data['password']);
        $data['role'] = "member";
        $data['user_type'] = "registered";
        $data["slug"] = $this->generate_uniqe_slug($data["username"]);
        $data['banned'] = 0;
        $data['last_seen'] = date('Y-m-d H:i:s');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['token'] = generate_token();
        $data['email_status'] = 1;
        if ($this->general_settings->email_verification == 1) {
            $data['email_status'] = 0;
        }
        if ($this->general_settings->vendor_verification_system != 1) {
            $data['role'] = "vendor";
        }
        if ($this->db->insert('users', $data)) {
            $last_id = $this->db->insert_id();
            if ($this->general_settings->email_verification == 1) {
                $user = $this->get_user($last_id);
                if (!empty($user)) {
                    $this->session->set_flashdata('success', trans("msg_register_success") . " " . trans("msg_send_confirmation_email") . "&nbsp;<a href='javascript:void(0)' class='link-resend-activation-email' onclick=\"send_activation_email_register('" . $user->id . "','" . $user->token . "');\">" . trans("resend_activation_email") . "</a>");
                    $this->send_email_activation_ajax($user->id, $user->token);
                }
            } else {
                $user = $this->get_user($last_id);

                $user_data = array(
                    'modesy_sess_unique_id' => md5(microtime() . rand()),
                    'modesy_sess_user_id' => $user->id,
                    'modesy_sess_user_email' => $user->email,
                    'modesy_sess_user_role' => $user->role,
                    'modesy_sess_logged_in' => true,
                    'modesy_sess_app_key' => $this->config->item('app_key'),
                );
                $this->session->set_userdata($user_data);

                $this->save_user_login_session_data();

                $this->cart_model->add_session_to_cart_in_db($user->id);

                $user_cart = $this->cart_model->get_user_cart_from_db($user->id);

                if (!empty($user_cart)) {
                    $user_cart_id = $user_cart->id;
                    $cart_details = $this->cart_model->get_cart_details_by_id($user_cart_id);
                    $this->cart_model->add_cart_to_session_from_db($cart_details, true);
                }
            }
            return $last_id;
        } else {
            return false;
        }
    }


    //guest register
    public function guest_register()
    {
        $this->load->library('bcrypt');

        $data = $this->auth_model->input_values();
        $data['username'] = remove_special_characters("G-" . $data['email']);
        $data['phone_number'] = "9999999999";
        //secure password
        $data['password'] = $this->bcrypt->hash_password("12345678");
        $data['role'] = "guest";
        $data['user_type'] = "guest";
        $data["slug"] = $this->generate_uniqe_slug($data["email"]);
        $data['banned'] = 0;
        $data['last_seen'] = date('Y-m-d H:i:s');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['token'] = generate_token();
        $data['email_status'] = 1;
        if ($this->general_settings->email_verification == 1) {
            $data['email_status'] = 0;
        }
        if ($this->general_settings->vendor_verification_system != 1) {
            $data['role'] = "vendor";
        }
        if ($this->db->insert('users', $data)) {
            $last_id = $this->db->insert_id();
            if ($this->general_settings->email_verification == 1) {
                $user = $this->get_user($last_id);
                if (!empty($user)) {
                    $this->session->set_flashdata('success', trans("msg_register_success") . " " . trans("msg_send_confirmation_email") . "&nbsp;<a href='javascript:void(0)' class='link-resend-activation-email' onclick=\"send_activation_email_register('" . $user->id . "','" . $user->token . "');\">" . trans("resend_activation_email") . "</a>");
                    $this->send_email_activation_ajax($user->id, $user->token);
                }
            } else {
                $user = $this->get_user($last_id);

                $user_data = array(
                    'modesy_sess_unique_id' => md5(microtime() . rand()),
                    'modesy_sess_user_id' => $user->id,
                    'modesy_sess_user_email' => $user->email,
                    'modesy_sess_user_role' => $user->role,
                    'modesy_sess_logged_in' => true,
                    'modesy_sess_app_key' => $this->config->item('app_key'),
                );
                $this->session->set_userdata($user_data);

                $this->save_user_login_session_data();

                $this->cart_model->add_session_to_cart_in_db($user->id);

                $user_cart = $this->cart_model->get_user_cart_from_db($user->id);

                if (!empty($user_cart)) {
                    $user_cart_id = $user_cart->id;
                    $cart_details = $this->cart_model->get_cart_details_by_id($user_cart_id);
                    $this->cart_model->add_cart_to_session_from_db($cart_details, true);
                }
            }
            return $last_id;
        } else {
            return false;
        }
    }
    //guest login 
    //guest register
    public function guest_login($email)
    {
        // $this->load->library('bcrypt');

        // $data = $this->auth_model->input_values();
        // $data['username'] = remove_special_characters("G-" . $data['email']);
        // $data['phone_number'] = "9999999999";
        // //secure password
        // $data['password'] = $this->bcrypt->hash_password("12345678");
        // $data['role'] = "guest";
        // $data['user_type'] = "guest";
        // $data["slug"] = $this->generate_uniqe_slug($data["email"]);
        // $data['banned'] = 0;
        // $data['last_seen'] = date('Y-m-d H:i:s');
        // $data['created_at'] = date('Y-m-d H:i:s');
        // $data['token'] = generate_token();
        // $data['email_status'] = 1;
        // if ($this->general_settings->email_verification == 1) {
        //     $data['email_status'] = 0;
        // }
        // if ($this->general_settings->vendor_verification_system != 1) {
        //     $data['role'] = "vendor";
        // }
        // if ($this->db->insert('users', $data)) {
        $last_id = $this->get_guestid_by_email($email);
        if ($this->general_settings->email_verification == 1) {
            $user = $this->get_user($last_id);
            if (!empty($user)) {
                $this->session->set_flashdata('success', trans("msg_register_success") . " " . trans("msg_send_confirmation_email") . "&nbsp;<a href='javascript:void(0)' class='link-resend-activation-email' onclick=\"send_activation_email_register('" . $user->id . "','" . $user->token . "');\">" . trans("resend_activation_email") . "</a>");
                $this->send_email_activation_ajax($user->id, $user->token);
            }
        } else {
            $user = $this->get_user($last_id);

            $user_data = array(
                'modesy_sess_unique_id' => md5(microtime() . rand()),
                'modesy_sess_user_id' => $user->id,
                'modesy_sess_user_email' => $user->email,
                'modesy_sess_user_role' => $user->role,
                'modesy_sess_logged_in' => true,
                'modesy_sess_app_key' => $this->config->item('app_key'),
            );
            $this->session->set_userdata($user_data);

            $this->save_user_login_session_data();

            $this->cart_model->add_session_to_cart_in_db($user->id);

            $user_cart = $this->cart_model->get_user_cart_from_db($user->id);

            if (!empty($user_cart)) {
                $user_cart_id = $user_cart->id;
                $cart_details = $this->cart_model->get_cart_details_by_id($user_cart_id);
                $this->cart_model->add_cart_to_session_from_db($cart_details, true);
            }
        }
        return $last_id;
        // } else {
        //     return false;
        // }
    }




    //send email activation
    public function send_email_activation($user_id, $token)
    {
        if (!empty($user_id)) {
            $user = $this->get_user($user_id);
            if (!empty($user)) {
                if (!empty($user->token) && $user->token != $token) {
                    exit();
                }
                //check token
                $data['token'] = $user->token;
                if (empty($data['token'])) {
                    $data['token'] = generate_token();
                    $this->db->where('id', $user->id);
                    $this->db->update('users', $data);
                }
                //send email
                $email_data = array(
                    'template_path' => "email/email_general",
                    'to' => $user->email,
                    'subject' => trans("confirm_your_account"),
                    'email_content' => trans("msg_confirmation_email"),
                    'email_link' => lang_base_url() . "confirm?token=" . $data['token'],
                    'email_button_text' => trans("confirm_your_account")
                );
                $this->load->model("email_model");
                $this->email_model->send_email($email_data);
            }
        }
    }

    //send email activation
    public function send_email_activation_ajax($user_id, $token)
    {
        if (!empty($user_id)) {
            $user = $this->get_user($user_id);
            if (!empty($user)) {
                if (!empty($user->token) && $user->token != $token) {
                    exit();
                }
                //check token
                $data['token'] = $user->token;
                if (empty($data['token'])) {
                    $data['token'] = generate_token();
                    $this->db->where('id', $user->id);
                    $this->db->update('users', $data);
                }

                //send email
                $email_data = array(
                    'email_type' => 'email_general',
                    'to' => $user->email,
                    'subject' => trans("confirm_your_account"),
                    'email_content' => trans("msg_confirmation_email"),
                    'email_link' => lang_base_url() . "confirm?token=" . $data['token'],
                    'email_button_text' => trans("confirm_your_account")
                );
                $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
            }
        }
    }

    //add administrator
    public function add_administrator()
    {
        $this->load->library('bcrypt');

        $data = $this->auth_model->input_values();
        //secure password
        $data['password'] = $this->bcrypt->hash_password($data['password']);
        $data['user_type'] = "registered";
        $data["slug"] = $this->generate_uniqe_slug($data["username"]);
        $data['role'] = "admin";
        $data['banned'] = 0;
        $data['email_status'] = 1;
        $data['token'] = generate_token();
        $data['last_seen'] = date('Y-m-d H:i:s');
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->db->insert('users', $data);
    }


    public function add_user_cards()
    {
        $data = array(

            'user_id' => $this->input->post('user_id', true),
            'card_number' => $this->input->post('card_number', true),

            'card_expiry_date' => $this->input->post('card_expiry_date', true),
            'card_holder_name' => $this->input->post('card_holder_name', true),
            'card_type' => $this->input->post('card_type', true),
            'bank_name' => $this->input->post('bank_name', true),

        );




        return $this->db->insert('user_card_details', $data);
    }


    public function edit_cards($id)
    {
        $data = array(


            'card_number' => $this->input->post('card_number', true),

            'card_expiry_date' => $this->input->post('card_expiry_date', true),
            'card_holder_name' => $this->input->post('card_holder_name', true),
            'card_type' => $this->input->post('card_type', true),
            'bank_name' => $this->input->post('bank_name', true),

        );


        $this->db->where('id', $id);

        return $this->db->insert('user_card_details', $data);
    }

    public function delete_address($id)
    {
        $address = $this->get_address($id);
        if (!empty($address)) {
            $data['is_active'] = '0';
            $this->db->where('id', $address->id);
            return $this->db->update('shipping_info', $data);
        }
        return false;
    }
    public function delete_card($id)
    {
        $card = $this->get_card($id);
        if (!empty($card)) {
            $data['is_active'] = '0';
            $this->db->where('id', $card->id);
            return $this->db->update('user_card_details', $data);
        }
        return false;
    }
    public function get_address($id)
    {
        $this->db->where('shipping_info.id', clean_number($id));
        return $this->db->get('shipping_info')->row();
    }
    public function get_card($id)
    {
        $this->db->where('user_card_details.id', clean_number($id));
        return $this->db->get('user_card_details')->row();
    }
    public function add_user_addresses()
    {
        $data = array(

            'user_id' => $this->input->post('user_id', true),
            'f_name' => $this->input->post('full_name', true),

            'ph_number' => $this->input->post('mobile_number', true),
            'zip_code' => $this->input->post('pin_code', true),
            'h_no' => $this->input->post('house_number', true),
            'landmark' => $this->input->post('landmark', true),
            'city' => $this->input->post('city', true),
            'state' => $this->input->post('state', true),
            'address_type' => $this->input->post('address_type', true),
            'area' => $this->input->post('area', true),
            'email' => $this->input->post('email', true),


        );




        return $this->db->insert('shipping_info', $data);
    }

    public function edit_addresses($id)
    {
        $data = array(


            'f_name' => $this->input->post('full_name', true),

            'ph_number' => $this->input->post('mobile_number', true),
            'zip_code' => $this->input->post('pin_code', true),
            'h_no' => $this->input->post('house_number', true),
            'landmark' => $this->input->post('landmark', true),
            'city' => $this->input->post('city', true),
            'state' => $this->input->post('state', true),
            'address_type' => $this->input->post('address_type', true),
            'area' => $this->input->post('area', true),
            'email' => $this->input->post('email', true),


        );


        $this->db->where('id', $id);

        return $this->db->update('shipping_info', $data);
    }
    //update slug
    public function update_slug($id)
    {
        $id = clean_number($id);
        $user = $this->get_user($id);

        if (empty($user->slug) || $user->slug == "-") {
            $data = array(
                'slug' => "user-" . $user->id,
            );
            $this->db->where('id', $id);
            $this->db->update('users', $data);
        } else {
            if ($this->check_is_slug_unique($user->slug, $id) == true) {
                $data = array(
                    'slug' => $user->slug . "-" . $user->id
                );

                $this->db->where('id', $id);
                $this->db->update('users', $data);
            }
        }
    }
    public function shop_open_close($data)
    {
        $this->db->where('id', $this->auth_user->id);
        $this->db->update('users', $data);
        return ($this->db->affected_rows() > 0) ? true : false;
    }

    //logout
    public function logout()
    {
        //clear cart
        $this->cart_model->clear_cart();
        //logout from db
        $this->delete_user_login_session_data();
        //unset user data
        $this->session->unset_userdata('modesy_sess_user_id');
        $this->session->unset_userdata('modesy_sess_user_email');
        $this->session->unset_userdata('modesy_sess_user_role');
        $this->session->unset_userdata('modesy_sess_logged_in');
        $this->session->unset_userdata('modesy_sess_app_key');
        $this->session->unset_userdata('modesy_sess_user_shiprocket_token');
        $this->session->unset_userdata('modesy_sess_user_location');
    }

    //reset password
    public function reset_password($id)
    {
        $id = clean_number($id);
        $this->load->library('bcrypt');
        $new_password = $this->input->post('password', true);
        $data = array(
            'password' => $this->bcrypt->hash_password($new_password),
            'token' => generate_token()
        );
        //change password
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    //delete user
    public function delete_user($id)
    {
        $id = clean_number($id);
        $user = $this->get_user($id);
        if (!empty($user)) {
            $this->db->where('id', $id);
            return $this->db->delete('users');
        }
        return false;
    }

    //update last seen time
    public function update_last_seen()
    {
        if ($this->auth_check) {
            //update last seen
            $data = array(
                'last_seen' => date("Y-m-d H:i:s"),
            );
            $this->db->where('id', $this->auth_user->id);
            $this->db->update('users', $data);
        }
    }

    //is logged in
    public function is_logged_in()
    {
        //check if user logged in
        if ($this->session->userdata('modesy_sess_logged_in') == true && $this->session->userdata('modesy_sess_app_key') == $this->config->item('app_key')) {
            $user = $this->get_user($this->session->userdata('modesy_sess_user_id'));
            if (!empty($user)) {
                if ($user->banned == 0) {
                    return true;
                }
            }
        }
        return false;
    }

    //function get user
    public function get_logged_user()
    {
        if ($this->is_logged_in()) {
            $user_id = $this->session->userdata('modesy_sess_user_id');
            $this->db->where('id', $user_id);
            $query = $this->db->get('users');
            return $query->row();
        }
    }
    public function get_user_details($id, $get_main_on_null = true)
    {
        $this->db->where('users.id', clean_number($id));
        $row = $this->db->get('users')->row();
        if ((empty($row) || empty($row->title)) && $get_main_on_null == true) {
            $this->db->where('users.id', clean_number($id))->limit(1);
            $row = $this->db->get('users')->row();
        }
        return $row;
    }

    //get user by id
    public function get_user($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        return $query->row();
    }

    public function get_pincode($pincode)
    {
        $pincode = clean_number($pincode);
        $this->db->where('pincode', $pincode);
        $query = $this->db->get('pincodes');
        return $query->result();
    }


    public function get_coupon_codes()
    {

        $query = $this->db->get('coupons');
        return $query->result();
    }


    //get user by email
    public function get_user_by_email($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row();
    }
    //get user by email register
    public function get_user_by_email_register($email)
    {
        $this->db->where("user_type!=", "guest");
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row();
    }
    public function get_guestid_by_email($email)
    {
        $this->db->where("user_type", "guest");
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row()->id;
    }
    //get user by email guest
    public function get_user_by_email_guest($email)
    {
        $this->db->where("user_type", "guest");
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row();
    }
    //get user by mobile number
    public function get_user_by_mobile($mobile)
    {
        $this->db->where('phone_number', $mobile);
        $query = $this->db->get('users');
        return $query->row();
    }


    //seller states

    //get user by username
    public function get_user_by_username($username)
    {
        $username = remove_special_characters($username);
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get user by shop name
    public function get_user_by_shop_name($shop_name)
    {
        $shop_name = remove_special_characters($shop_name);
        $this->db->where('shop_name', $shop_name);
        $query = $this->db->get('users');
        return $query->row();
    }
    //get user by phone
    public function get_user_by_phone($phone_number)
    {
        $phone_number = remove_special_characters($phone_number);
        $this->db->where('phone_number', $phone_number);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get user by slug
    public function get_user_by_slug($slug)
    {
        $this->db->where('slug', $slug);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get user by token
    public function get_user_by_token($token)
    {
        $token = remove_special_characters($token);
        $this->db->where('token', $token);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get users
    public function get_users()
    {
        $query = $this->db->get('users');
        return $query->result();
    }

    //get  sellers
    public function get_sellers()
    {
        $this->db->where('role', 'vendor');
        $query = $this->db->get('users');
        return $query->result();
    }


    //get users
    public function get_barter_members()
    {
        $this->db->where('barter', 'Y');
        $this->db->where('role', 'vendor');
        $this->db->where('id!=', $this->auth_user->id);
        $query = $this->db->get('users');
        return $query->result();
    }

    //  public function get_barter_product_of_current_user()
    //  {
    //     $this->db->where('barter', 'Y');
    //      $query = $this->db->get('users');
    //      return $query->result();
    //  }


    //get users count
    public function get_users_count()
    {
        $query = $this->db->get('users');
        return $query->num_rows();
    }

    //get paginated users
    public function get_paginated_filtered_products($role, $per_page, $offset)
    {
        $this->filter_users();
        $this->db->where('role', clean_str($role));
        $this->db->order_by('created_at', 'DESC')->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('users')->result();
    }
    public function get_paginated_filtered_vendors($role, $per_page, $offset)
    {
        $this->filter_users();
        $this->db->where('role', clean_str($role));
        $this->db->where('is_bank_details_approved', 0);
        $this->db->order_by('created_at', 'DESC')->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('users')->result();
    }
    public function get_paginated_filtered_users($role, $per_page, $offset)
    {
        $this->filter_users();
        $this->db->where('role', clean_str($role));
        $this->db->where('email_status', 1);
        $this->db->order_by('created_at', 'DESC')->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('users')->result();
    }
    public function get_bank_details_requests_count()
    {

        $this->db->where('role', 'vendor');
        $this->db->where('is_bank_details_approved', 0);
        $query = $this->db->get('users');

        return $query->num_rows();
    }
    //get paginated featured users
    public function get_paginated_featured_users($role, $per_page, $offset)
    {
        $this->filter_users();
        $this->db->where('role', clean_str($role));
        $this->db->where('is_promoted', 1);
        $this->db->order_by('created_at', 'DESC')->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('users')->result();
    }
    public function get_paginated_profile_filtered_products($role, $per_page, $offset)
    {
        $this->filter_users();
        $this->db->where('role', clean_str($role));
        $this->db->where('is_profile_approved', "0");
        $this->db->order_by('created_at', 'DESC')->limit(clean_number($per_page), clean_number($offset));
        return $this->db->get('users')->result();
    }
    //get users count by role
    public function get_users_count_by_role($role)
    {
        $this->filter_users();
        return $this->db->where('role', clean_str($role))->count_all_results('users');
    }

    //get featured users count by role
    public function get_featured_users_count_by_role($role)
    {
        $this->filter_users();
        $this->db->where('is_promoted', 1);
        return $this->db->where('role', clean_str($role))->count_all_results('users');
    }

    public function get_users_profile_count_by_role($role)
    {
        $this->filter_users();
        return $this->db->where('role', clean_str($role))->where('is_profile_approved', "0")->count_all_results('users');
    }

    //users filter
    public function filter_users()
    {
        $q = input_get('q');
        if (!empty($q)) {
            $this->db->group_start();
            $this->db->like('username', clean_str($q));
            $this->db->or_like('email', clean_str($q));
            $this->db->group_end();
        }
        $status = input_get('status');
        if (!empty($status)) {
            $banned = $status == 'banned' ? 1 : 0;
            $this->db->where('banned', $banned);
        }
        $email_status = input_get('email_status');
        if (!empty($email_status)) {
            $status = $email_status == 'confirmed' ? 1 : 0;
            $this->db->where('email_status', $status);
        }
    }

    //get latest members
    public function get_latest_members($limit)
    {
        $limit = clean_number($limit);
        $this->db->limit($limit);
        $this->db->order_by('users.id', 'DESC');
        $query = $this->db->get('users');
        return $query->result();
    }

    //get last users
    public function get_last_users()
    {
        $this->db->order_by('users.id', 'DESC');
        $this->db->limit(7);
        $query = $this->db->get('users');
        return $query->result();
    }

    //check slug
    public function check_is_slug_unique($slug, $id)
    {
        $id = clean_number($id);
        $this->db->where('users.slug', $slug);
        $this->db->where('users.id !=', $id);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    //check phone no for unique
    // public function get_user_by_phone($phone_number)
    // {
    //     $phone_number = remove_special_characters($phone_number);
    //     $this->db->where('phone_number', $phone_number);
    //     $query = $this->db->get('users');
    //     return $query->row();
    // }
    //check if email is unique for registered user
    public function is_unique_email_register($email, $user_id = 0)
    {
        $user_id = clean_number($user_id);
        $user = $this->auth_model->get_user_by_email_register($email);

        //if id doesnt exists

        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }

        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //email taken
                return false;
            } else {
                return true;
            }
        }
    }
    public function is_unique_email_guest($email, $user_id = 0)
    {
        $user_id = clean_number($user_id);
        $user = $this->auth_model->get_user_by_email_guest($email);

        //if id doesnt exists

        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }

        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //email taken
                return false;
            } else {
                return true;
            }
        }
    }
    //check if email is unique
    public function is_unique_email($email, $user_id = 0)
    {
        $user_id = clean_number($user_id);
        $user = $this->auth_model->get_user_by_email($email);

        //if id doesnt exists

        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }

        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //email taken
                return false;
            } else {
                return true;
            }
        }
    }

    //get user by id
    public function get_seller($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        return $query->row();
    }
    //check if number is unique
    public function is_unique_phone($phone_number, $user_id = 0)
    {
        $user = $this->get_user_by_phone($phone_number);

        //if id doesnt exists
        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }

        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //phone taken
                return false;
            } else {
                return true;
            }
        }
    }

    //check if username is unique
    public function is_unique_username($username, $user_id = 0)
    {
        $user = $this->get_user_by_username($username);

        //if id doesnt exists
        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }

        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //username taken
                return false;
            } else {
                return true;
            }
        }
    }
    // public function is_unique_phone($phone_number, $user_id = 0)
    // {
    //     $user = $this->get_user_by_phone($phone_number);

    //     //if id doesnt exists
    //     if ($user_id == 0) {
    //         if (empty($user)) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     }

    //     if ($user_id != 0) {
    //         if (!empty($user) && $user->id != $user_id) {
    //             //phone taken
    //             return false;
    //         } else {
    //             return true;
    //         }
    //     }
    // }
    //check if shop name is unique
    public function is_unique_shop_name($shop_name, $user_id = 0)
    {
        $user = $this->get_user_by_shop_name($shop_name);
        //if id doesnt exists
        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }

        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //shop name taken
                return false;
            } else {
                return true;
            }
        }
    }

    //verify email
    public function verify_email($user)
    {
        if (!empty($user)) {
            $data = array(
                'email_status' => 1,
                'token' => generate_token()
            );
            $this->db->where('id', $user->id);
            return $this->db->update('users', $data);
        }
        return false;
    }

    //ban or remove user ban
    public function ban_remove_ban_user($id)
    {
        $id = clean_number($id);
        $user = $this->get_user($id);

        if (!empty($user)) {
            $data = array();
            if ($user->banned == 0) {
                $data['banned'] = 1;
            }
            if ($user->banned == 1) {
                $data['banned'] = 0;
            }

            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        }

        return false;
    }


    //unique seller id creation 
    public function unique_seller_id($id, $data)
    {
        $unique_id = "GBS";
        $unique_id .= $this->auth_model->get_seller_type_code($data['supplier_type'], $data['supplier_type_goods']);
        $unique_id .= $this->auth_model->get_state_code($data['supplier_state']);
        $unique_id .= substr($data["pincode"], -2);
        $unique_id .= $this->auth_model->unique_pattern_seller($id);
        return $unique_id;
    }

    //get spplier type 
    public function get_seller_type_code($seller_type, $supplier_type_goods)
    {
        if ($seller_type == "Goods") {
            if ($supplier_type_goods == "Non Food Products") {
                return "01";
            } else if ($supplier_type_goods == "Food Products") {
                return "02";
            } else if ($supplier_type_goods == "Both") {
                return "03";
            }
        }
        //for now always return 04 for services(for food it should be changed depend on the argument we get)
        if ($seller_type == "Services") {
            return "04";
        }
    }

    //get state code from db
    public function get_state_code($state_name)
    {
        $this->db->where("state_name", $state_name);
        $query = $this->db->get('state_code');
        $result = $query->result();
        return $result[0]->state_code;
    }

    //pattern for seller id
    public function unique_pattern_seller($id)
    {
        $number = $id;
        $length = 5;
        $string = substr(str_repeat(0, $length) . $number, -$length);
        $startString = 'AA';
        $round = intval($number / 100000);
        if (intval($number / 100000) <= 0) {
            $uniCode = $startString . $string;
        } else {
            while ($round > 0) {
                $startString++;
                $round--;
            }
            $uniCode = $startString . $string;
        }
        return $uniCode;
    }

    public function get_user_detail_by_unique_sess_id($unique_sess_id)
    {
        $this->db->where('modesy_sess_unique_id', $unique_sess_id);
        $query = $this->db->get('session_user_details');
        return $query->row();
    }

    public function shiprocket_auth_api()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/auth/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
    "email": "sellerhelp@gharobaar.com",
    "password": "Gharobaar@admin1"
}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $user_data = array(
            'modesy_sess_user_shiprocket_token' => json_decode($response)->token
        );
        $this->session->set_userdata($user_data);
    }


    public function get_user_shipping_type($user_id)
    {
        $this->db->where('seller_id', $user_id);
        $query = $this->db->get('seller_shipping_provider');
        return $query->row();
    }

    public function get_user_shipping_threshold($id)
    {
        $this->db->where('seller_shipping_id', $id);
        $query = $this->db->get('seller_shipping_threshold');
        return $query->result();
    }
    public function check_user_mobile_number($mobile)
    {
        $this->db->where('phone_number', $mobile);
        $query = $this->db->get('users');
        return $query->row();
    }
    public function check_user_mobile_number_user($mobile)
    {
        $this->db->where('user_type!=', "guest");
        $this->db->where('phone_number', $mobile);
        $query = $this->db->get('users');
        return $query->row();
    }
    public function check_guest_mobile_number($mobile)
    {
        $this->db->where('phone_number', $mobile);
        $this->db->where('user_type!=', 'guest');
        $query = $this->db->get('users');
        return $query->row();
    }
    public function check_user_email_register($email_address)
    {
        $this->db->where('email', $email_address);
        $query = $this->db->get('users');
        return $query->row();
    }
    public function check_user_email_register_user($email_address)
    {
        $this->db->where('email', $email_address);
        $this->db->where('user_type!=', 'guest');
        $query = $this->db->get('users');
        return $query->row();
    }
    public function set_commission_rate($user_id, $commission_rate)
    {
        $data = array(
            'seller_id' => $user_id,
            'commission_rate' => $commission_rate
        );
        $this->db->insert('seller_product_commission_rate', $data);
    }
    // Guest update data for registration
    public function guest_update()
    {
        $this->load->library('bcrypt');

        $data = $this->auth_model->input_values();
        $data['username'] = remove_special_characters($data['email']);
        //secure password
        $data['password'] = $this->bcrypt->hash_password($data['password']);
        $data['role'] = "member";
        $data['user_type'] = "registered";
        $data["slug"] = $this->generate_uniqe_slug($data["username"]);
        $data['banned'] = 0;
        $data['last_seen'] = date('Y-m-d H:i:s');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['token'] = generate_token();
        $data['email_status'] = 1;
        if ($this->general_settings->email_verification == 1) {
            $data['email_status'] = 0;
        }
        if ($this->general_settings->vendor_verification_system != 1) {
            $data['role'] = "vendor";
        }
        $this->db->where('email', $data['email']);
        // $this->db->where('phone_number', $data['phone_number']);
        if ($this->db->update('users', $data)) {
            $this->db->where('email', $data['email']);
            // $this->db->where('phone_number', $data['phone_number']);
            $this->db->select("id");
            $result =  $this->db->get("users");
            $query = $result->row();
            $last_id = $query->id;

            // $last_id = $this->db->insert_id();
            if ($this->general_settings->email_verification == 1) {
                $user = $this->get_user($last_id);
                if (!empty($user)) {
                    $this->session->set_flashdata('success', trans("msg_register_success") . " " . trans("msg_send_confirmation_email") . "&nbsp;<a href='javascript:void(0)' class='link-resend-activation-email' onclick=\"send_activation_email_register('" . $user->id . "','" . $user->token . "');\">" . trans("resend_activation_email") . "</a>");
                    $this->send_email_activation_ajax($user->id, $user->token);
                }
            } else {
                $user = $this->get_user($last_id);

                $user_data = array(
                    'modesy_sess_unique_id' => md5(microtime() . rand()),
                    'modesy_sess_user_id' => $user->id,
                    'modesy_sess_user_email' => $user->email,
                    'modesy_sess_user_role' => $user->role,
                    'modesy_sess_logged_in' => true,
                    'modesy_sess_app_key' => $this->config->item('app_key'),
                );
                $this->session->set_userdata($user_data);

                $this->save_user_login_session_data();

                $this->cart_model->add_session_to_cart_in_db($user->id);

                $user_cart = $this->cart_model->get_user_cart_from_db($user->id);

                if (!empty($user_cart)) {
                    $user_cart_id = $user_cart->id;
                    $cart_details = $this->cart_model->get_cart_details_by_id($user_cart_id);
                    $this->cart_model->add_cart_to_session_from_db($cart_details, true);
                }
            }
            return $last_id;
        } else {
            return false;
        }
    }
    // check for register unique
    public function is_unique_register($email)
    {
        // $query = array($phone_number,$email);
        // {
        // $this->db->where();
        // $this->db->where();
        // }
        $this->db->where('email', $email);
        // $this->db->where('phone_number', $phone_number);
        // $query=$this->db->where('role !=','member');
        // $query=$this->db->where('user_type !=','registered');
        $query = $this->db->get('users');
        return $query->row();
    }
}
