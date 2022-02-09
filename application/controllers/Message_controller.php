<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Message_controller extends Home_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        //check user
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
    }

    /**
     * Messages
     */
    public function messages()
    {
        $data['title'] = trans("messages");
        $data['description'] = trans("messages") . " - " . $this->app_name;
        $data['keywords'] = trans("messages") . "," . $this->app_name;

        $data['conversation'] = $this->message_model->get_user_latest_conversation($this->auth_user->id);
        $data["session"] = get_user_session();
        if (!empty($data['conversation'])) {
            $data['unread_conversations'] = $this->message_model->get_unread_conversations($this->auth_user->id);
            $data['read_conversations'] = $this->message_model->get_read_conversations($this->auth_user->id);
            $data['messages'] = $this->message_model->get_messages($data['conversation']->id);
            $this->message_model->set_conversation_messages_as_read($data['conversation']->id);
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('message/messages', $data);
        $this->load->view('partials/_footer');
    }

    public function barter_requests()
    {
        $data['title'] = "Barter Requests";
        $data['description'] = "Barter Requests" . " - " . $this->app_name;
        $data['keywords'] = "Barter Requests" . "," . $this->app_name;

        $data['conversation'] = $this->message_model->get_user_latest_conversation($this->auth_user->id);
        $data["session"] = get_user_session();
        if (!empty($data['conversation'])) {
            $data['unread_conversations'] = $this->message_model->get_unread_conversations($this->auth_user->id);
            $data['read_conversations'] = $this->message_model->get_read_conversations($this->auth_user->id);
            $data['messages'] = $this->message_model->get_messages($data['conversation']->id);
            $this->message_model->set_conversation_messages_as_read($data['conversation']->id);
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('message/requests', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Conversation
     */
    public function conversation($id)
    {
        $data['title'] = trans("messages");
        $data['description'] = trans("messages") . " - " . $this->app_name;
        $data['keywords'] = trans("messages") . "," . $this->app_name;
        $data["session"] = get_user_session();
        $data['conversation'] = $this->message_model->get_user_conversation($id);
        //check message
        if (empty($data['conversation'])) {
            redirect(generate_url("messages"));
        }
        //check message owner
        if ($this->auth_user->id != $data['conversation']->sender_id && $this->auth_user->id != $data['conversation']->receiver_id) {
            redirect(generate_url("messages"));
        }
        $data['unread_conversations'] = $this->message_model->get_unread_conversations($this->auth_user->id);
        $data['read_conversations'] = $this->message_model->get_read_conversations($this->auth_user->id);
        $data['messages'] = $this->message_model->get_messages($data['conversation']->id);
        $this->message_model->set_conversation_messages_as_read($data['conversation']->id);

        $this->load->view('partials/_header', $data);
        $this->load->view('message/messages', $data);
        $this->load->view('partials/_footer');
    }

    public function add_review()
    {
        $review_text = $this->input->post('review_text', true);
        $supplier_id = $this->input->post('supplier_id', true);
        $res = $this->message_model->add_review($review_text, $supplier_id);
        var_dump($res);
        die();
        // var_dump($this->message_model->add_review($review_text, $supplier_id));
        if (!empty($res)) {
            $this->session->set_flashdata('success', trans("msg_updated"));

            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Send Message
     */
    public function send_message()
    {
        $conversation_id = $this->input->post('conversation_id', true);
        if ($this->message_model->add_message($conversation_id)) {
            $conversation = $this->message_model->get_conversation($conversation_id);
            if (!empty($conversation)) {
                //send email
                $sender_id = $this->auth_user->id;
                $receiver_id = $this->input->post('receiver_id', true);
                $message = $this->input->post('message', true);
                $user = get_user($receiver_id);
                $title = $this->input->post('product_title', true);

                if (!empty($user) && $user->send_email_new_message == 1 && !empty($message)) {
                    $email_data = array(
                        'email_type' => 'new_message',
                        'sender_id' => $sender_id,
                        'receiver_id' => $receiver_id,
                        'message_subject' => $conversation->subject,
                        'message_text' => $message
                    );
                    if (!empty($title)) {
                        $data = array(
                            'source' => 'coustomiation',
                            // 'source_id' => $product_id,
                            'remark' => "You have received a query for customization of your product " . $title,
                            'event_type' => 'Customization Notifications',
                            'subject' => "New customization query of your product",
                            // 'message' => "Your Favourite Seller" . ucfirst($user->first_name) . " has launched a new product <a href='" . base_url() . $product->slug . "'>" .  $title->title . "</a>.",
                            'to' => $receiver_id,
                            'template_path' => "email/email_newsletter",
                            'subscriber' => "",
                        );
                        $this->load->model("email_model");
                        $this->email_model->notification($data);
                    }
                    $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
                }
            }
        }
        redirect($this->agent->referrer());
    }

    /**
     * Add Conversation
     */
    public function add_conversation()
    {
        $data = array(
            'result' => 0,
            'sender_id' => 0,
            'html_content' => ""
        );
        if ($this->auth_user->id == $this->input->post('receiver_id', true)) {
            $this->session->set_flashdata('error', trans("msg_message_sent_error"));
            $data["result"] = 1;
            $data["html_content"] = $this->load->view('partials/_messages', null, true);
            reset_flash_data();
        } else {
            $conversation_id = $this->message_model->add_conversation();
            if ($conversation_id) {
                if ($this->message_model->add_message($conversation_id)) {
                    $this->session->set_flashdata('success', trans("msg_message_sent"));
                    $data["result"] = 1;
                    $data["sender_id"] = $this->auth_user->id;
                    $data["html_content"] = $this->load->view('partials/_messages', null, true);
                    reset_flash_data();
                } else {
                    $this->session->set_flashdata('error', trans("msg_error"));
                    $data["result"] = 1;
                    $data["html_content"] = $this->load->view('partials/_messages', null, true);
                    reset_flash_data();
                }
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                $data["result"] = 1;
                $data["html_content"] = $this->load->view('partials/_messages', null, true);
                reset_flash_data();
            }
        }
        echo json_encode($data);
    }

    public function add_request()
    {
        $data = array(
            'result' => 0,
            'sender_id' => 0,
            'html_content' => ""
        );
        if ($this->auth_user->id == $this->input->post('receiver_id', true)) {
            $this->session->set_flashdata('error', trans("msg_message_sent_error"));
            $data["result"] = 1;
            $data["html_content"] = $this->load->view('partials/_requests', null, true);
            reset_flash_data();
        } else {
            $conversation_id = $this->message_model->add_requests();
            if ($conversation_id) {
                if ($this->message_model->add_message($conversation_id)) {
                    $this->session->set_flashdata('success', trans("msg_message_sent"));
                    $data["result"] = 1;
                    $data["sender_id"] = $this->auth_user->id;
                    $data["html_content"] = $this->load->view('partials/_requests', null, true);
                    reset_flash_data();
                } else {
                    $this->session->set_flashdata('error', trans("msg_error"));
                    $data["result"] = 1;
                    $data["html_content"] = $this->load->view('partials/_requests', null, true);
                    reset_flash_data();
                }
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
                $data["result"] = 1;
                $data["html_content"] = $this->load->view('partials/_requests', null, true);
                reset_flash_data();
            }
        }
        echo json_encode($data);
    }
    /**
     * Delete Conversation
     */
    public function delete_conversation()
    {
        $conversation_id = $this->input->post('conversation_id', true);
        $this->message_model->delete_conversation($conversation_id);
    }
}
