<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_controller extends Home_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
    }


    public function check_for_mobile_register()
    {
        $phone_number = $this->input->post('phn_num', true);
        // var_dump($phone_number); die();
        $result = $this->auth_model->check_user_mobile_number($phone_number);
        $data = array(
            'result' => false,
            'xyz' => $result
        );
        if ($result == null) {
            $data["result"] = true;
        } else {
            $data["result"] = false;
        }
        echo json_encode($data);
    }
    public function check_for_mobile_register_user()
    {
        $phone_number = $this->input->post('phn_num', true);
        // var_dump($phone_number); die();
        $result = $this->auth_model->check_user_mobile_number_user($phone_number);
        $data = array(
            'result' => false,
            'xyz' => $result
        );
        if ($result == null) {
            $data["result"] = true;
        } else {
            $data["result"] = false;
        }
        echo json_encode($data);
    }
    public function check_for_guest_mobile_register()
    {
        $phone_number = $this->input->post('phn_num', true);
        // var_dump($phone_number); die();
        $result = $this->auth_model->check_guest_mobile_number($phone_number);
        $data = array(
            'result' => false,
            'xyz' => $result
        );
        if ($result == null) {
            $data["result"] = true;
        } else {
            $data["result"] = false;
        }
        echo json_encode($data);
    }
    public function check_for_email_register()
    {
        $email_address = $this->input->post('email_address', true);
        // var_dump($phone_number); die();
        $result = $this->auth_model->check_user_email_register($email_address);
        $data = array(
            'result' => false,
            'xyz' => $result
        );
        if ($result == null) {
            $data["result"] = true;
        } else {
            $data["result"] = false;
        }
        echo json_encode($data);
    }
    public function check_for_email_register_user()
    {
        $email_address = $this->input->post('email_address', true);
        // var_dump($phone_number); die();
        $result = $this->auth_model->check_user_email_register_user($email_address);
        $data = array(
            'result' => false,
            'xyz' => $result
        );
        if ($result == null) {
            $data["result"] = true;
        } else {
            $data["result"] = false;
        }
        echo json_encode($data);
    }
    /**
     * Login Post
     */
    public function login_post()
    {
        //check auth
        if ($this->auth_check) {
            $data = array(
                'result' => 1,
                'user' => $this->auth_user
            );
            echo json_encode($data);
            exit();
        }
        //validate inputs
        $this->form_validation->set_rules('email', trans("email_address"), 'required|xss_clean|max_length[100]');
        $this->form_validation->set_rules('password', trans("password"), 'required|xss_clean|max_length[30]');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            $this->load->view('partials/_messages');
        } else {
            $user = $this->auth_model->login();
            if (!empty($user)) {
                $this->shiprocket();
                $data = array(
                    'result' => 1,
                    'user' => $user
                );
                echo json_encode($data);
            } else {
                $data = array(
                    'result' => 0,
                    'error_message' => $this->load->view('partials/_messages', '', true)
                );
                echo json_encode($data);
            }
            reset_flash_data();
        }
    }

    public function set_user_session_data()
    {
        $mobile_number = $this->input->post('number');
        $user = $this->auth_model->set_user_session_data($mobile_number);
        if (!empty($user)) {
            $data = array(
                'result' => 1,
                'user' => $user
            );
            echo json_encode($data);
        } else {
            $data = array(
                'result' => 0,
                'error_message' => $this->load->view('partials/_messages', '', true)
            );
            echo json_encode($data);
        }
    }

    public function shiprocket()
    {
        $curl = curl_init();
        $shiprocket_login = "sellerhelp@gharobaar.com";
        $shiprocket_password = "Gharobaar@admin1";

        $cred_array = array(
            "email" => $shiprocket_login,
            "password" => $shiprocket_password
        );


        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apiv2.shiprocket.in/v1/external/auth/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($cred_array),
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

    /**
     * Connect with Facebook
     */
    public function connect_with_facebook()
    {
        $fb_url = "https://www.facebook.com/v3.3/dialog/oauth?client_id=" . $this->general_settings->facebook_app_id . "&redirect_uri=" . base_url() . "facebook-callback&scope=email&state=" . generate_unique_id();

        $this->session->set_userdata('fb_login_referrer', $this->agent->referrer());
        redirect($fb_url);
        exit();
    }

    public function why_sell_with_us()
    {
        $data['title'] = "Sell now with us";
        $data['description'] = "Sell now with us" . " - " . $this->app_name;
        $data['keywords'] = "Sell now with us" . "," . $this->app_name;

        // $token = trim($this->input->get("token", true));
        // $data["user"] = $this->auth_model->get_user_by_token($token);

        // if (empty($data["user"])) {
        //     redirect(lang_base_url());
        // }
        // if ($data["user"]->email_status == 1) {
        //     redirect(lang_base_url());
        // }

        // if ($this->auth_model->verify_email($data["user"])) {
        //     $data["success"] = trans("msg_confirmed");
        // } else {
        //     $data["error"] = trans("msg_error");
        // }
        $this->load->view('partials/_header', $data);
        $this->load->view('auth/why_sell_with_us', $data);
        $this->load->view('partials/_footer');
    }


    /**
     * Facebook Callback
     */
    public function facebook_callback()
    {
        require_once APPPATH . "third_party/facebook/vendor/autoload.php";

        $fb = new \Facebook\Facebook([
            'app_id' => $this->general_settings->facebook_app_id,
            'app_secret' => $this->general_settings->facebook_app_secret,
            'default_graph_version' => 'v2.10',
        ]);
        try {
            $helper = $fb->getRedirectLoginHelper();
            $permissions = ['email'];
            if (isset($_GET['state'])) {
                $helper->getPersistentDataHandler()->set('state', $_GET['state']);
            }
            $accessToken = $helper->getAccessToken();
            if (empty($accessToken)) {
                redirect(lang_base_url());
            }
            $response = $fb->get('/me?fields=name,email', $accessToken);
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $user = $response->getGraphUser();
        $fb_user = new stdClass();
        $fb_user->id = $user->getId();
        $fb_user->email = $user->getEmail();
        $fb_user->name = $user->getName();

        $this->auth_model->login_with_facebook($fb_user);

        if (!empty($this->session->userdata('fb_login_referrer'))) {
            redirect($this->session->userdata('fb_login_referrer'));
        } else {
            redirect(base_url());
        }
    }
    public function email_us()
    {



        $message = $this->input->post('messagere', true);
        $email = "contact@gharobaar.com";


        $this->load->model("email_model");
        $this->session->set_flashdata('submit', "send_email");

        if (!empty($email)) {
            if (!$this->email_model->email_us($email, $message)) {
                redirect($this->agent->referrer());
                // exit();
            }
            $this->session->set_flashdata('success', trans("msg_email_sent"));
        } else {
            $this->session->set_flashdata('error', trans("msg_error"));
        }


        redirect($this->agent->referrer());
    }
    public function user_details($id)
    {
        $data['title'] = "User Details";
        $data['user'] = $this->product_admin_model->get_user($id);
        if (empty($data['user'])) {
            redirect($this->agent->referrer());
        }
        $data['user_details'] = $this->auth_model->get_user_details($data["user"]->id, true);

        $data['main_settings'] = get_main_settings();
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/product/user_details', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Connect with Google
     */
    public function connect_with_google()
    {
        require_once APPPATH . "third_party/google/vendor/autoload.php";

        $provider = new League\OAuth2\Client\Provider\Google([
            'clientId' => $this->general_settings->google_client_id,
            'clientSecret' => $this->general_settings->google_client_secret,
            'redirectUri' => base_url() . 'connect-with-google',
        ]);

        if (!empty($_GET['error'])) {
            // Got an error, probably user denied access
            exit('Got error: ' . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'));
        } elseif (empty($_GET['code'])) {

            // If we don't have an authorization code then get one
            $authUrl = $provider->getAuthorizationUrl();
            $_SESSION['oauth2state'] = $provider->getState();
            $this->session->set_userdata('g_login_referrer', $this->agent->referrer());
            header('Location: ' . $authUrl);
            exit();
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
            // State is invalid, possible CSRF attack in progress
            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        } else {
            // Try to get an access token (using the authorization code grant)
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);
            // Optional: Now you have a token you can look up a users profile data
            try {
                // We got an access token, let's now get the owner details
                $user = $provider->getResourceOwner($token);

                $g_user = new stdClass();
                $g_user->id = $user->getId();
                $g_user->email = $user->getEmail();
                $g_user->name = $user->getName();
                $g_user->avatar = $user->getAvatar();

                $this->auth_model->login_with_google($g_user);
                var_dump($user->email);
                //exit();

                if (!empty($this->session->userdata('g_login_referrer'))) {
                    redirect($this->session->userdata('g_login_referrer'));
                    // $this->load->model("email_model");
                    // $this->session->set_flashdata('submit', "send_email");
                    // if (!empty($user->email)) {
                    //     if (!$this->email_model->send_buyer_welcome_email( $user->email,  $user->name)) {
                    //         redirect($this->agent->referrer());
                    //         exit();
                    //     }
                    //     $this->session->set_flashdata('success', trans("msg_email_sent"));
                    // } else {
                    //     $this->session->set_flashdata('error', trans("msg_error"));
                    // }
                } else {
                    redirect(base_url());
                }
            } catch (Exception $e) {
                // Failed to get user details
                exit('Something went wrong: ' . $e->getMessage());
            }
        }
    }

    public function pincode($pincode)
    {
        // $pincode = $this->auth_model->get_pincode($id);
        $data = $this->auth_model->get_pincode($pincode);
        $result =  json_encode($data);
        echo $result;
    }

    /**
     * Connect with VK
     */
    public function connect_with_vk()
    {
        require_once APPPATH . "third_party/vkontakte/vendor/autoload.php";
        $provider = new J4k\OAuth2\Client\Provider\Vkontakte([
            'clientId' => $this->general_settings->vk_app_id,
            'clientSecret' => $this->general_settings->vk_secure_key,
            'redirectUri' => base_url() . 'connect-with-vk',
            'scopes' => ['email'],
        ]);
        // Authorize if needed
        if (PHP_SESSION_NONE === session_status()) session_start();
        $isSessionActive = PHP_SESSION_ACTIVE === session_status();
        $code = !empty($_GET['code']) ? $_GET['code'] : null;
        $state = !empty($_GET['state']) ? $_GET['state'] : null;
        $sessionState = 'oauth2state';

        // No code – get some
        if (!$code) {
            $authUrl = $provider->getAuthorizationUrl();
            if ($isSessionActive) $_SESSION[$sessionState] = $provider->getState();
            $this->session->set_userdata('vk_login_referrer', $this->agent->referrer());
            header("Location: $authUrl");
            die();
        } // Anti-CSRF
        elseif ($isSessionActive && (empty($state) || ($state !== $_SESSION[$sessionState]))) {
            unset($_SESSION[$sessionState]);
            throw new \RuntimeException('Invalid state');
        } // Exchange code to access_token
        else {
            try {
                $providerAccessToken = $provider->getAccessToken('authorization_code', ['code' => $code]);

                $user = $providerAccessToken->getValues();
                //get user details with cURL
                $url = 'http://api.vk.com/method/users.get?uids=' . $providerAccessToken->getValues()['user_id'] . '&access_token=' . $providerAccessToken->getToken() . '&v=5.95&fields=photo_200,status';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                $response = curl_exec($ch);
                curl_close($ch);
                $user_details = json_decode($response);

                $vk_user = new stdClass();
                $vk_user->id = $providerAccessToken->getValues()['user_id'];
                $vk_user->email = $providerAccessToken->getValues()['email'];
                $vk_user->name = @$user_details->response['0']->first_name . " " . @$user_details->response['0']->last_name;
                $vk_user->avatar = @$user_details->response['0']->photo_200;

                $this->auth_model->login_with_vk($vk_user);

                if (!empty($this->session->userdata('vk_login_referrer'))) {
                    redirect($this->session->userdata('vk_login_referrer'));
                } else {
                    redirect(base_url());
                }
            } catch (IdentityProviderException $e) {
                // Log error
                error_log($e->getMessage());
            }
        }
    }

    /**
     * Admin Login
     */
    public function admin_login()
    {
        if ($this->auth_check) {
            redirect(lang_base_url());
        }
        $data['title'] = trans("login");
        $data['description'] = trans("login") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("login") . ', ' . $this->general_settings->application_name;
        $this->load->view('admin/login', $data);
    }

    /**
     * Admin Login Post
     */
    public function admin_login_post()
    {
        //validate inputs
        $this->form_validation->set_rules('email', trans("form_email"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('password', trans("form_password"), 'required|xss_clean|max_length[30]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            redirect($this->agent->referrer());
        } else {
            if ($this->auth_model->login()) {
                redirect(admin_url());
            } else {
                //error
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("login_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Register
     */
    public function register()
    {
        //check if logged in
        if ($this->auth_check) {
            redirect(lang_base_url());
        }
        $data['title'] = trans("register");
        $data['description'] = trans("register") . " - " . $this->app_name;
        $data['keywords'] = trans("register") . "," . $this->app_name;
        $data["session"] = get_user_session();
        $data["via_sell_now"] = 0;

        $this->load->view('partials/_header', $data);
        $this->load->view('auth/register');
        $this->load->view('partials/_footer');
    }

    /**
     * Register seller from seller page
     */
    public function register_seller()
    {
        //check if logged in
        if ($this->auth_check) {
            redirect(lang_base_url());
        }
        $data['title'] = trans("register");
        $data['description'] = trans("register") . " - " . $this->app_name;
        $data['keywords'] = trans("register") . "," . $this->app_name;
        $data["session"] = get_user_session();
        $data["via_sell_now"] = 1;

        $this->load->view('partials/_header', $data);
        $this->load->view('auth/register');
        $this->load->view('partials/_footer');
    }

    public function shop_open_close()
    {

        $data['is_shop_open'] = $this->input->post('is_shop_open', true);

        if ($data['is_shop_open']  == 0) {
            // $data1 = array(
            //     'source' => 'coustomiation',
            //     // 'source_id' => $product_id,
            //     'remark' => $this->auth_user->username . "  " . "closed the shop",
            //     'event_type' => 'Shop Notifications',
            //     'subject' => "shop closed",
            //     'to' => 'admin@gmail.com',
            //     'source' => $this->auth_user->id,
            // );
            // var_dump($data1);

            // die();
            $subject = "Shop Closed!";
            $email_body = "Closed The Shop";
            $message =  "<b>Gharobaar Seller</b>" . " " . $this->auth_user->email  . "<b></br> $email_body</b>";
            $bcc = array("sakshi@gharobaar.com", "aditya@gharobaar.com");
            $data1 = array(
                'source' => '',
                'source_id' => "",
                'event_type' => 'Shop Close',
                'subject' => $subject,
                'message' => $message,
                'to' =>  $this->general_settings->mail_username,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            );

            $this->load->model('email_model');
            $this->email_model->send_email_members($data1, $bcc);
        }
        $response = $this->auth_model->shop_open_close($data);

        echo $response;
    }

    /**
     * Register Post
     */
    public function register_post()
    {
        //check if logged in
        if ($this->auth_check) {
            redirect(lang_base_url());
        }

        // if ($this->recaptcha_status == true) {
        //     if (!$this->recaptcha_verify_request()) {
        //         $this->session->set_flashdata('form_data', $this->auth_model->input_values());
        //         $this->session->set_flashdata('error', trans("msg_recaptcha"));
        //         redirect($this->agent->referrer());
        //         exit();
        //     }
        // }

        //validate inputs
        // $this->form_validation->set_rules('username', trans("username"), 'required|xss_clean|min_length[4]|max_length[100]');
        $this->form_validation->set_rules('email', trans("email_address"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            redirect($this->agent->referrer());
        } else {
            $email = $this->input->post('email', true);
            $phone_number = $this->input->post('phone_number', true);
            // $username = $this->input->post('username', true);
            $unique_register = $this->auth_model->is_unique_register($email);
            if (empty($unique_register)) {
                // create
                $user_id = $this->auth_model->register();
                if ($user_id) {
                    $user = get_user($user_id);
                    if (!empty($user)) {
                        //update slug
                        $this->auth_model->update_slug($user->id);
                        if ($this->general_settings->email_verification != 1) {
                            $this->auth_model->login_direct($user);
                            $this->session->set_flashdata('success', trans("msg_register_success"));
                            // redirect(generate_url(""));
                        }
                    }
                    $data = array(
                        'result' => 1,
                        'user' => $user
                    );
                    echo json_encode($data);
                } else {
                    //error
                    $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                    $this->session->set_flashdata('error', trans("msg_error"));
                    $data = array(
                        'result' => 0,
                        'error_message' => $this->load->view('partials/_messages', '', true)
                    );
                    echo json_encode($data);
                }
            } else {
                if ($unique_register->role == "guest" && $unique_register->user_type == "guest") {
                    $user_id = $this->auth_model->guest_update();
                    if ($user_id) {
                        $user = get_user($user_id);
                        if (!empty($user)) {
                            //update slug
                            $this->auth_model->update_slug($user->id);
                            if ($this->general_settings->email_verification != 1) {
                                $this->auth_model->login_direct($user);
                                $this->session->set_flashdata('success', trans("msg_register_success"));
                                // redirect(generate_url(""));
                            }
                        }
                        $data = array(
                            'result' => 1,
                            'user' => $user
                        );
                        echo json_encode($data);
                    } else {
                        //error
                        $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                        $this->session->set_flashdata('error', trans("msg_error"));
                        $data = array(
                            'result' => 0,
                            'error_message' => $this->load->view('partials/_messages', '', true)
                        );
                        echo json_encode($data);
                    }
                } else {
                    //error message
                    $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                    $this->session->set_flashdata('error', trans("already_registered"));
                    $data = array(
                        'result' => 0,
                        'error_message' => $this->load->view('partials/_messages', '', true)
                    );
                    echo json_encode($data);
                }
            }

            //

            //is email unique
            // if (!$this->auth_model->is_unique_email($email)) {
            //     $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            //     $this->session->set_flashdata('error', trans("msg_email_unique_error"));
            //     $data = array(
            //         'result' => 0,
            //         'error_message' => $this->load->view('partials/_messages', '', true)
            //     );
            //     echo json_encode($data);
            // } else if (!$this->auth_model->is_unique_phone($phone_number)) {
            //     $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            //     $this->session->set_flashdata('error', trans("msg_phone_unique_error"));
            //     $data = array(
            //         'result' => 0,
            //         'error_message' => $this->load->view('partials/_messages', '', true)
            //     );
            //     echo json_encode($data);
            // } else {
            //register
            // $user_id = $this->auth_model->register();
            // if ($user_id) {
            //     $user = get_user($user_id);
            //     if (!empty($user)) {
            //         //update slug
            //         $this->auth_model->update_slug($user->id);
            //         if ($this->general_settings->email_verification != 1) {
            //             $this->auth_model->login_direct($user);
            //             $this->session->set_flashdata('success', trans("msg_register_success"));
            //             // redirect(generate_url(""));
            //         }
            //     }
            //     $data = array(
            //         'result' => 1,
            //         'user' => $user
            //     );
            //     echo json_encode($data);
            // } else {
            //     //error
            //     $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            //     $this->session->set_flashdata('error', trans("msg_error"));
            //     $data = array(
            //         'result' => 0,
            //         'error_message' => $this->load->view('partials/_messages', '', true)
            //     );
            //     echo json_encode($data);
            // }
            // }
            //is username unique
            // if (!$this->auth_model->is_unique_username($username)) {
            //     $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            //     $this->session->set_flashdata('error', trans("msg_username_unique_error"));
            //     redirect($this->agent->referrer());
            // }
        }

        //  $this->load->model("email_model");
        //$this->session->set_flashdata('submit', "send_email");

        // if (1) {
        //     if (!$this->email_model->send_regret_shopmail($user->email,$user->first_name)) {
        //         redirect($this->agent->referrer());
        //        // exit();
        //     }
        //     $this->session->set_flashdata('success', trans("msg_email_sent"));
        // } else {
        //     $this->session->set_flashdata('error', trans("msg_error"));
        // }
    }


    /**
     * Guest Register Post
     */
    public function guest_register_post()
    {
        //check if logged in
        // if ($this->auth_check) {
        //     redirect(lang_base_url());
        // }

        // if ($this->recaptcha_status == true) {
        //     if (!$this->recaptcha_verify_request()) {
        //         $this->session->set_flashdata('form_data', $this->auth_model->input_values());
        //         $this->session->set_flashdata('error', trans("msg_recaptcha"));
        //         redirect($this->agent->referrer());
        //         exit();
        //     }
        // }

        $email = $this->input->post('email', true);
        // $phone_number = $this->input->post('phone_number', true);

        //is email unique
        if (!$this->auth_model->is_unique_email_register($email)) {
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            // $this->session->set_flashdata('error', trans("msg_email_unique_error"));
            $data = array(
                'result' => 0,
                'error_message' => "*You are already registered with us, please login to proceed.",
            );
            echo json_encode($data);
        } else  if (!$this->auth_model->is_unique_email_guest($email)) {
            $user_id = $this->auth_model->guest_login($email);
            if ($user_id) {
                $user = get_user($user_id);
                if (!empty($user)) {
                    //update slug
                    $this->auth_model->update_slug($user->id);
                    if ($this->general_settings->email_verification != 1) {
                        // $this->auth_model->login_direct($user);

                        $this->session->set_flashdata('success', trans("msg_register_success"));
                        // redirect(generate_url(""));
                    }
                }
                $data = array(
                    'result' => 1,
                    'user' => $user
                );
                echo json_encode($data);
            } else {
                //error
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("msg_error"));
                $data = array(
                    'result' => 0,
                    'error_message' => $this->load->view('partials/_messages', '', true)
                );
                echo json_encode($data);
            }
        }
        //  else if (!$this->auth_model->is_unique_phone($phone_number)) {
        //     $this->session->set_flashdata('form_data', $this->auth_model->input_values());
        //     $this->session->set_flashdata('error', trans("msg_phone_unique_error"));
        //     $data = array(
        //         'result' => 0,
        //         'error_message' => $this->load->view('partials/_messages', '', true)
        //     );
        //     echo json_encode($data);
        // } 
        else {
            //guest register
            $user_id = $this->auth_model->guest_register();
            if ($user_id) {
                $user = get_user($user_id);
                if (!empty($user)) {
                    //update slug
                    $this->auth_model->update_slug($user->id);
                    if ($this->general_settings->email_verification != 1) {
                        // $this->auth_model->login_direct($user);

                        $this->session->set_flashdata('success', trans("msg_register_success"));
                        // redirect(generate_url(""));
                    }
                }
                $data = array(
                    'result' => 1,
                    'user' => $user
                );
                echo json_encode($data);
            } else {
                //error
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("msg_error"));
                $data = array(
                    'result' => 0,
                    'error_message' => $this->load->view('partials/_messages', '', true)
                );
                echo json_encode($data);
            }
        }
    }
    /**
     * Confirm Email
     */
    public function confirm_email()
    {
        $data['title'] = trans("confirm_your_account");
        $data['description'] = trans("confirm_your_account") . " - " . $this->app_name;
        $data['keywords'] = trans("confirm_your_account") . "," . $this->app_name;

        $token = trim($this->input->get("token", true));
        $data["user"] = $this->auth_model->get_user_by_token($token);

        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        if ($data["user"]->email_status == 1) {
            redirect(lang_base_url());
        }

        if ($this->auth_model->verify_email($data["user"])) {
            $data["success"] = trans("msg_confirmed");
        } else {
            $data["error"] = trans("msg_error");
        }
        $this->load->view('partials/_header', $data);
        $this->load->view('auth/confirm_email', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Forgot Password
     */
    public function forgot_password()
    {
        //check if logged in
        if ($this->auth_check) {
            redirect(lang_base_url());
        }

        $data['title'] = trans("reset_password");
        $data['description'] = trans("reset_password") . " - " . $this->app_name;
        $data['keywords'] = trans("reset_password") . "," . $this->app_name;

        $this->load->view('partials/_header', $data);
        $this->load->view('auth/forgot_password');
        $this->load->view('partials/_footer');
    }

    /**
     * Forgot Password Post
     */
    public function forgot_password_post()
    {
        //check auth
        if ($this->auth_check) {
            redirect(lang_base_url());
        }

        $email = $this->input->post('email', true);
        //get user
        $user = $this->auth_model->get_user_by_email($email);

        //if user not exists
        if (empty($user)) {
            $this->session->set_flashdata('error', html_escape(trans("msg_reset_password_error")));
            redirect($this->agent->referrer());
        } else {
            $this->load->model("email_model");
            $this->email_model->send_email_reset_password($user->id);
            $this->session->set_flashdata('success', trans("msg_reset_password_success"));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Reset Password
     */
    public function reset_password()
    {
        //check if logged in
        if ($this->auth_check) {
            redirect(lang_base_url());
        }

        $data['title'] = trans("reset_password");
        $data['description'] = trans("reset_password") . " - " . $this->app_name;
        $data['keywords'] = trans("reset_password") . "," . $this->app_name;
        $token = $this->input->get('token', true);
        //get user
        $data["user"] = $this->auth_model->get_user_by_token($token);
        $data["success"] = $this->session->flashdata('success');
        $data["session"] = get_user_session();
        if (empty($data["user"]) && empty($data["success"])) {
            redirect(lang_base_url());
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('auth/reset_password');
        $this->load->view('partials/_footer');
    }

    /**
     * Reset Password Post
     */
    public function reset_password_post()
    {
        $success = $this->input->post('success', true);
        if ($success == 1) {
            redirect(lang_base_url());
        }

        $this->form_validation->set_rules('password', trans("new_password"), 'required|xss_clean|min_length[4]|max_length[50]');
        $this->form_validation->set_rules('password_confirm', trans("password_confirm"), 'required|xss_clean|matches[password]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->profile_model->change_password_input_values());
            redirect($this->agent->referrer());
        } else {
            $token = $this->input->post('token', true);
            $user = $this->auth_model->get_user_by_token($token);
            if (!empty($user)) {
                if ($this->auth_model->reset_password($user->id)) {
                    $this->session->set_flashdata('success', trans("msg_change_password_success"));
                    redirect($this->agent->referrer());
                }
                $this->session->set_flashdata('error', trans("msg_change_password_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Send Activation Email
     */
    public function send_activation_email_post()
    {
        post_method();
        $user_id = $this->input->post('id', true);
        $token = $this->input->post('token', true);
        $type = $this->input->post('type', true);
        if ($type == 'login') {
            $this->session->set_flashdata('success', trans("msg_send_confirmation_email") . "&nbsp;<a href='javascript:void(0)' class='link-resend-activation-email' onclick=\"send_activation_email('" . $user_id . "','" . $token . "');\">" . trans("resend_activation_email") . "</a>");
        } else {
            $this->session->set_flashdata('success', trans("msg_send_confirmation_email") . "&nbsp;<a href='javascript:void(0)' class='link-resend-activation-email' onclick=\"send_activation_email_register('" . $user_id . "','" . $token . "');\">" . trans("resend_activation_email") . "</a>");
        }

        $data = array(
            'result' => 1,
            'success_message' => $this->load->view('partials/_messages', '', true)
        );
        echo json_encode($data);
        reset_flash_data();
        $this->auth_model->send_email_activation($user_id, $token);
    }


    //check unique shopname
    public function check_unique_shopname()
    {
        $shop_name = $this->input->post('shop_name', true);
        $user_id = $this->input->post('user_id', true);
        if (!$this->auth_model->is_unique_shop_name($shop_name, $user_id)) {
            $data = array(
                'result' => 0,
                'msg' => "Shop name already exist! Please select a unique shop name."
            );
        } else {
            $data = array(
                'result' => 1,
                'msg' => "Shop name is unique."
            );
        }
        echo json_encode($data);
    }


    public function calculate_distance()
    {
        $delivery = $this->input->post("delivery");
        $pickup = $this->input->post("pickup");
        $data = $this->profile_model->product_deliverale_or_not($pickup, $delivery);
        echo json_encode($data);
    }

    public function send_otp_verification()
    {
        $label_content = "mobile_otp";
        $email = $this->input->post("email", true);
        $phn_num = $this->input->post("phone_number", true);

        if (!$this->auth_model->is_unique_email($email)) {
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            $this->session->set_flashdata('error', trans("msg_email_unique_error"));
            $data = array(
                'result' => 0,
                'error_message' => $this->load->view('partials/_messages', '', true)
            );
            echo json_encode($data);
        } else if (!$this->auth_model->is_unique_phone($phn_num)) {
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            $this->session->set_flashdata('error', trans("msg_phone_unique_error"));
            $data = array(
                'result' => 0,
                'error_message' => $this->load->view('partials/_messages', '', true)
            );
            echo json_encode($data);
        } else {
            // Authorisation details.
            $username = "chirag.raut@austere.co.in";
            $hash = "495947f08983f416aa4556991fb67b2f2642e45e";

            // Config variables. Consult http://api.textlocal.in/docs for more info.
            $test = "0";

            // Data for text message. This is the text message data.
            $sender = "GHRBAR"; // This is who the message appears to be from.
            $numbers = "$phn_num"; // A single number or a comma-seperated list of numbers
            $otp = rand(100000, 999999);

            $_SESSION['LAST_ACTIVITY'] = time();
            $_SESSION['session_otp'] = $otp;

            $msg_content = get_content($label_content);

            //replace template var with value
            if ($label_content == "mobile_otp") {
                $token = array(
                    'otp'  => $otp,
                    'otp_time' => '3 mins'
                );
            }
            $pattern = '[%s]';
            foreach ($token as $key => $val) {
                $varMap[sprintf($pattern, $key)] = $val;
            }

            $message = strtr($msg_content, $varMap);

            $apikey = "8hnKwcSmxnU-wlltbtQanStuagBcFtJoZBcHG6sQfB";
            $data = array('apikey' => $apikey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);


            $ch = curl_init('https://api.textlocal.in/send/?');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch); // This is the result from the API
            curl_close($ch);

            // $this->send_email_otp("email_otp", $email, $message, $otp, "3 mins");

            if ($label_content == "mobile_otp") {
                $data = array(
                    'html_content1' => "",
                    'otp' => $_SESSION['session_otp'],
                    'message' => $message,
                    'api' => "SENT_OTP",
                    'result' => 1
                );
                $this->session->set_flashdata('success', "OTP Sent Successfully !");
                $data["html_content1"] = $this->load->view('partials/_messages', null, true);
                reset_flash_data();
            }
            echo json_encode($data);
        }
    }
}
