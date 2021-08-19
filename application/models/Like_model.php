<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Like_model extends CI_Model
{
    //add like
    public function add_like()
    {
        $data = array(
            'liked_by' => $this->auth_user->id,
            'user_id' => $this->input->post('user_id', true),
            'image_id' => $this->input->post('image_id', true),
            'liked' => $this->input->post('liked', true)
        );

        //check like exists
        $this->db->where('liked_by', $data['liked_by']);
        $this->db->where('user_id', $data['user_id']);
        $this->db->where('image_id', $data['image_id']);
        $query = $this->db->get('image_likes');
        $row = $query->row();

        if (!empty($row)) {
            $this->db->where('id', $row->id);
            $this->db->update('image_likes', $data);
            return $data;
        } else {
            if ($this->db->insert('image_likes', $data)) {
                return $this->db->insert_id();
            } else {
                return false;
            }
        }
    }

    public function count_likes($image_id, $user_id)
    {
        $data = array(
            'user_id' => $user_id,
            'image_id' => $image_id
        );

        //check like exists
        $this->db->where('user_id', $data['user_id']);
        $this->db->where('image_id', $data['image_id']);
        $this->db->where('liked', 1);
        $query = $this->db->get('image_likes');
        $row_count = $query->num_rows();
        return $row_count;
    }

    //liked images
    public function image_liked($image_id, $user_id)
    {
        $data = array(
            'liked_by' => $this->auth_user->id,
            'user_id' => $user_id,
            'image_id' => $image_id
        );
        $this->db->where('liked_by', $data['liked_by']);
        $this->db->where('user_id', $data['user_id']);
        $this->db->where('image_id', $data['image_id']);
        $query = $this->db->get('image_likes');
        $row = $query->row();

        if (!empty($row)) {
            return $row;
        } else {
            return false;
        }
    }

    //get messages
    public function get_messages($conversation_id)
    {
        $conversation_id = clean_number($conversation_id);
        $this->db->where('conversation_id', $conversation_id);
        $query = $this->db->get('conversation_messages');
        return $query->result();
    }




    //get user conversation ids
    public function get_user_conversation_ids_query($user_id)
    {
        $user_id = clean_number($user_id);
        $this->db->select('conversation_id');
        $this->db->group_start();
        $this->db->where('sender_id', $user_id);
        $this->db->or_where('receiver_id', $user_id);
        $this->db->group_end();
        $this->db->where('deleted_user_id !=', $user_id);
        $this->db->distinct();
        $this->db->from('conversation_messages');
        $query = $this->db->get_compiled_select();
        $this->db->reset_query();
        return $query;
    }

    //delete conversation
    // public function delete_conversation($id)
    // {
    //     $id = clean_number($id);
    //     $conversation = $this->get_conversation($id);
    //     if (!empty($conversation)) {
    //         $messages = $this->get_messages($conversation->id);

    //         if (!empty($messages)) {
    //             foreach ($messages as $message) {
    //                 if ($message->sender_id == $this->auth_user->id || $message->receiver_id == $this->auth_user->id) {
    //                     if ($message->deleted_user_id == 0) {
    //                         $data = array(
    //                             'deleted_user_id' => $this->auth_user->id
    //                         );
    //                         $this->db->where('id', $message->id);
    //                         $this->db->update('conversation_messages', $data);
    //                     } else {
    //                         $this->db->where('id', $message->id);
    //                         $this->db->delete('conversation_messages');
    //                     }
    //                 }
    //             }
    //         }

    //         //delete conversation if does not have messages
    //         $messages = $this->get_messages($conversation->id);
    //         if (empty($messages)) {
    //             $this->db->where('id', $conversation->id);
    //             $this->db->delete('conversations');
    //         }
    //     }
    // }

}
