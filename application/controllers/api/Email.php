<?php
// Include library file
require_once APPPATH . 'libraries/Verify_Email.php';
class Email extends Verify_email
{
    public function __construct()
    {
        parent::__construct();
    }
    public function verifyemail()
    {
        $email = $_POST['email'];
        // Initialize library class
        $mail = new Verify_Email();
        // Set the timeout value on stream
        $mail->setStreamTimeoutWait(1);
        // Set email address for SMTP request
        $mail->setEmailFrom('harshitgoyal20jan@gmail.com');
        // Check if email is valid and exist
        if ($mail->check($email)) {
            echo json_encode(['status' => 200, 'message' => 'Email is exist']);
        } elseif (verify_Email::validate($email)) {
            echo json_encode(['status' => 303, 'message' => 'Email is valid but not exist']);
        } else {
            echo json_encode(['status' => 304, 'message' => 'Email is not valid and exist']);
        }
    }
}
