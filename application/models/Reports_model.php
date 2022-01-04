<?php defined('BASEPATH') or exit('No direct script access allowed');

class Reports_model extends CI_Model
{
    public function sale_data()
    {
        $sql = "SELECT concat(u.first_name,' ', u.last_name) as Seller, u.email as 'Seller_Email',u.phone_number as 'Seller_Phone',u.shop_name as 'Shop_Name',u.pan_number as 'Pan',u.gst_number as 'GST',concat(u.house_no,',',u.supplier_area,',', u.supplier_city,',', u.supplier_state,'-', u.pincode) as Address,  u.account_number as 'Account_No',u.acc_holder_name as 'Account_Holder',u.ifsc_code as 'IFSC_Code',u.bank_branch as 'Bank_Branch',IF(is_profile_approved = 1, 'APPROVED', 'PENDING') as 'Profile_Status',created_at as 'Profile_Created_Date'
    FROM users as u
    WHERE username != 'admin'
    AND role = 'vendor'";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
