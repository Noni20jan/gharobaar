<?php defined('BASEPATH') or exit('No direct script access allowed');

class Reports_model extends CI_Model
{
    public function seller_profile_data($from_date, $to_date)
    {
        $sql = "SELECT concat(u.first_name,' ', u.last_name) as Seller, u.email as 'Seller_Email',u.phone_number as 'Seller_Phone',u.shop_name as 'Shop_Name',u.pan_number as 'Pan',u.gst_number as 'GST',concat(u.house_no,',',u.supplier_area,',', u.supplier_city,',', u.supplier_state,'-', u.pincode) as Address,  u.account_number as 'Account_No',u.acc_holder_name as 'Account_Holder',u.ifsc_code as 'IFSC_Code',u.bank_branch as 'Bank_Branch',IF(is_profile_approved = 1, 'APPROVED', 'PENDING') as 'Profile_Status',created_at as 'Profile_Created_Date'
        FROM users as u
        WHERE username != 'admin'
        AND role = 'vendor'
        AND created_at >= STR_TO_DATE('$from_date', '%Y-%m-%d %k:%i:%s') AND created_at <= STR_TO_DATE('$to_date', '%Y-%m-%d %k:%i:%s')";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function format_shipping_cod_charges($from_date, $to_date)
    {
        $to_date = $to_date . " 23:59:59";
        $sql = "SELECT distinct
        op.created_at as 'Order_Date',
        op.order_id as 'GBT_Order_No.',
        cast(sod.created_at AS date) as 'Schedule_Shipment_Date',
        cast(sod.created_at AS time) as 'Schedule_Shipment_Time',
        sod.pickup_scheduled_date as 'Pickup_Schedule_Date',
        op.order_status as 'Shipment_Status',
        concat(buyer.first_name,' ', buyer.last_name) as 'Buyer',
        buyer.phone_number as 'Buyer_Mobile',
        buyer.email as 'Buyer_Email',
        oship.shipping_state 'Buyer_State', 
        concat(oship.shipping_address_1,',',oship.shipping_area,',', oship.shipping_city,',', oship.shipping_state,'-', oship.shipping_zip_code) as 'Buyer_Address',
        seller.shop_name as 'Seller_Shop_Name',
        seller.email as 'Seller_Registered_Email',
        seller.supplier_state as 'Seller_State',
        p.sku as 'Product_SKU',
        op.product_title as 'Product_Name',
        p.product_weight as 'Product_Weight',
        concat(p.packed_product_length,' x ', p.packed_product_width, ' x ', p.packed_product_height) as 'Sellers_Packaging_Dimenions',
        sod.applied_weight as 'Volumetric_Weight',
        sod.courier_company_name as 'Courier_Service_Provider',
        format(os.total_shipping_cost/100,2) as 'Shipping_amount' ,
        format(os.total_cod_cost/100,2) as 'COD_charges',
        NULL as 'Status_COD_Remittance',
        NULL as 'COD_pending_with_Shiprocket',
        sod.shipment_order_id as 'Shiprocket_Order_ID',
        sod.awb_code as 'Shiprockets_AWB_Number',
        NULL as 'Cancellation_charges'
    FROM order_products as op,
        products as p,
        order_supplier as os,
        shiprocket_order_details as sod,
        users as buyer,
        users as seller,
        order_shipping as oship
    WHERE op.product_id = p.id
    AND op.order_id = sod.order_id
    AND op.seller_id = seller.id
    AND op.buyer_id = buyer.id
    AND op.order_id = os.order_id
    AND op.seller_id = os.seller_id
    AND op.order_id = oship.order_id
    order by op.order_id";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function tcs_report()
    {
    }
    public function tds_report($from_date, $to_date)
    {
        $to_date = $to_date . " 23:59:59";
        $sql =  "SELECT 
        concat(u.first_name,' ', u.last_name) as Seller,
        u.pan_number as 'Pan',
        csp.order_id as 'Order_ID', 
        csp.created_at as 'Pay_Out_Date',
        csp.created_at as 'Date_of_Deduction',
        format(sum(csp.amount),2) as 'Amount_Paid',
        format(sum(csp.tds_amount)/100,2) as 'TDS_Amount'
    FROM cashfree_seller_payout as csp,
         users as u
    WHERE csp.vendorId = u.id
      AND csp.is_completed = 1
      AND csp.is_active = 1
      AND csp.payout_initiated = 1
       AND csp.created_at >= STR_TO_DATE('$from_date', '%Y-%m-%d %k:%i:%s')
      AND csp.created_at <= STR_TO_DATE('$to_date', '%Y-%m-%d %k:%i:%s') 
    GROUP BY 	concat(u.first_name,' ', u.last_name),
        u.pan_number ,
        csp.order_id , 
        csp.created_at ,
        csp.created_at 
    UNION
    SELECT 
        concat(u.first_name,' ', u.last_name) as Seller,
        u.pan_number as 'Pan',
        cdsp.order_id as 'Order_ID', 
        cdsp.created_at as 'Pay_Out_Date',
        cdsp.created_at as 'Date_of_Deduction',
        format(sum(cdsp.amount),2) as 'Amount Paid',
        format(sum(cdsp.tds_amount)/100,2) as 'TDS Amount'
    FROM cod_seller_payable as cdsp,
         users as u
    WHERE cdsp.vendorId = u.id
      AND cdsp.is_active = 1
      AND cdsp.payout_initiated = 1
      AND cdsp.created_at >= STR_TO_DATE('$from_date', '%Y-%m-%d %k:%i:%s')
      AND cdsp.created_at <= STR_TO_DATE('$to_date', '%Y-%m-%d %k:%i:%s')
    GROUP BY 	concat(u.first_name,' ', u.last_name),
        u.pan_number ,
        cdsp.order_id ,
        cdsp.created_at ,
        cdsp.created_at ";
        $query = $this->db->query($sql);
        return $query->result();
    }



    public function cash_free_charges_report()
    {
    }
    public function format_sale_data($start_date, $end_date)
    {
        $end_date = $end_date . " 23:59:59";
        $sql = "SELECT * FROM sale_data_report where order_date >= STR_TO_DATE('$start_date', '%Y-%m-%d %k:%i:%s') AND order_date <= STR_TO_DATE('$end_date', '%Y-%m-%d %k:%i:%s')";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
