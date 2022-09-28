<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Newsletter_model extends CI_Model
{

    //add to subscribers
    public function add_to_subscribers($email)
    {
        $data = array(
            'email' => $email,
            'token' => generate_token()
        );
        return $this->db->insert('subscribers', $data);
    }

    //update subscriber token
    public function update_subscriber_token($email)
    {
        $subscriber = $this->get_subscriber($email);
        if (!empty($subscriber)) {
            if (empty($subscriber->token)) {
                $data = array(
                    'token' => generate_token()
                );
                $this->db->where('email', $email);
                $this->db->update('subscribers', $data);
            }
        }
    }

    // //update for seller email status 
    // public function update_member_email_status($email)
    // {
    //     $member = $this->get_members_email($email);
    //     if (!empty($member)) {
    //         if (empty($member->send_email)) {
    //             $data = array(
    //                 'send_email' => 1
    //             );
    //             $this->db->where('email', $email);
    //             $this->db->update('member', $data);
    //         }
    //     }
    // }

    public function update_member_email_status($id)
    {
        foreach ($id as $emailwe){
        $data = array(
            'send_email' => 1
        );
        $this->db->where('id', $$emailwe);
        $this->db->update('users', $data);
        }
    }
    //delete from subscribers
    public function delete_from_subscribers($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        return $this->db->delete('subscribers');
    }

    //get subscribers
    public function get_subscribers()
    {
        $query = $this->db->get('subscribers');
        return $query->result();
    }

    //get user list
    public function get_members()
    {
        $query = $this->db->get('users');
        return $query->result();
    }
    public function get_members1()
    {
        $this->db->where('user_type', 'registered');
        $query = $this->db->get('users');
        return $query->result();
    }

    public function get_members2()
    {
        $this->db->where('send_email', '0');
        $query = $this->db->get('users');
        return $query->result();
    }

    //get member email status
    public function get_members_email()
    {
        $this->db->where('send_email', '0');
        $query = $this->db->get('users');
        return $query->result();
    }
    //get subscriber
    public function get_subscriber($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('subscribers');
        return $query->row();
    }

    //get subscriber
    public function get_subscriber_by_token($token)
    {
        $token = remove_special_characters($token);
        $this->db->where('token', $token);
        $query = $this->db->get('subscribers');
        return $query->row();
    }

    //get subscriber by id
    public function get_subscriber_by_id($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('subscribers');
        return $query->row();
    }

    //unsubscribe email
    public function unsubscribe_email($email)
    {
        $this->db->where('email', $email);
        $this->db->delete('subscribers');
    }
}
