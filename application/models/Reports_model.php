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
        op.order_id as 'GBT_Order_No',
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
        NULL as 'Status_of_COD_Remittance',
	NULL as 'COD_pending_with_Shiprocket',
        sod.shipment_order_id as 'Shiprocket_Order_ID',
        sod.awb_code as 'Shiprockets_AWB_Number',
        NULL as 'Cancellation_chrges'
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
    AND op.created_at >= STR_TO_DATE('$from_date', '%Y-%m-%d %k:%i:%s')
      AND op.created_at <= STR_TO_DATE('$to_date', '%Y-%m-%d %k:%i:%s')
    order by op.order_id";
        $query = $this->db->query($sql);
        return $query->result();
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




    public function format_sale_data($start_date, $end_date)
    {
        $end_date = $end_date . " 23:59:59";
        $sql = "SELECT * FROM sale_data_report where order_date >= STR_TO_DATE('$start_date', '%Y-%m-%d %k:%i:%s') AND order_date <= STR_TO_DATE('$end_date', '%Y-%m-%d %k:%i:%s')
        and order_status NOT IN( 'cancelled', 'cancelled_by_user' , 'cancelled_by_seller' , 'rejected','processing')";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function seller_commision_data($from_date, $to_date)
    {
        $to_date = $to_date . " 23:59:59";
        $sql = "SELECT DATE_FORMAT(sdr.order_date, '%M %Y') as 'Order-Month',
        sdr.seller as Seller,
        sdr.seller_email as Email,
        sdr.seller_phone as 'Phone',
        sdr.shop_name as 'Shop_name',
        sdr.pan_no as 'Pan',
        sdr.gst_no 'GST',
        sdr.seller_address as Address,
        format(sum(sdr.commission_amount),2) as total_commission_amount,
        format(sum(sdr.seller_ship_cost),2) as Total_shipping_cost,
        format(sum(sdr.seller_cod_cost),2) as Total_Cod_cost,
        ifnull(format(sum(csp.gateway_amount/100),2) , 0) as getway_amt,
        -- format(sum(csp.gateway_amount/100),2) as getway_amt,
        '18%' as 'GST_Rate', 
        FORMAT(((sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost) 
                     + sum(sdr.commission_amount) + ifnull(format(sum(csp.gateway_amount/100),2) , 0) ) * 18) / 100, 2) AS GST_Amount,
            IF(STRCMP(upper(u.supplier_state), 'DELHI') = 0, 
                FORMAT((((sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost) 
                     + sum(sdr.commission_amount) + ifnull(format(sum(csp.gateway_amount/100),2) , 0)) * 18) / 100)/2,2), 0 ) as CGST,
                IF(STRCMP(upper(u.supplier_state), 'DELHI') = 0, 
                FORMAT((((sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost) 
                     + sum(sdr.commission_amount) + ifnull(format(sum(csp.gateway_amount/100),2) , 0)) * 18) / 100)/2, 2), 0 ) as SGST,
                    IF(STRCMP(upper(u.supplier_state), 'DELHI') = 0, 0,
                FORMAT(((sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost) 
                     + sum(sdr.commission_amount) + ifnull(format(sum(csp.gateway_amount/100),2) , 0)) * 18) / 100, 2)) as IGST,
                Format ((sum(sdr.commission_amount) + sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost) + ifnull(sum(csp.gateway_amount/100), 0) +  
                (((sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost) 
                     + sum(sdr.commission_amount) + ifnull(sum(csp.gateway_amount/100), 0) ) * 18) / 100) ),2) as TOTAL
        
         -- FORMAT(sum(csp.gateway_amount)/100,2) as Gateway_charges
         FROM sale_data_report as sdr
         LEFT JOIN cashfree_seller_payout as csp 
          ON sdr.order_no = csp.order_id,
          users as u
          where sdr.seller_email = u.email
         and sdr.order_date >= STR_TO_DATE('$from_date', '%Y-%m-%d %k:%i:%s') 
         and sdr.order_date <= STR_TO_DATE('$to_date', '%Y-%m-%d %k:%i:%s')
         and sdr.order_status NOT IN( 'cancelled', 'cancelled_by_user' , 'cancelled_by_seller' , 'rejected','processing') 
         group by sdr.seller ,
        sdr.seller_email ,
        sdr.seller_phone ,
        sdr.shop_name,
        sdr.pan_no,
        sdr.gst_no,
        sdr.seller_address";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function format_tcs_report($start_date, $end_date)
    {
        $end_date = $end_date . " 23:59:59";
        $sql = "SELECT distinct
        concat(u.first_name,' ', u.last_name) as Seller,
        u.email as 'Seller_Email',
        u.phone_number as 'Selle_Phone',
        op.order_id as 'Order_No',
        u.shop_name as 'Shop_Name',
        u.pan_number as 'Pan',
        u.gst_number as 'GST',
        concat(u.house_no,',',u.supplier_area,',', u.supplier_city,',', u.supplier_state,'-', u.pincode) as Address,
        u.account_number as 'Account_No',
        u.acc_holder_name as 'Account_Holder',
        u.ifsc_code as 'IFSC_Code',
        u.bank_branch as 'Bank_Branch',
        op.order_status as 'Order_Status',
        o.payment_method as 'Payment_Method',
        op.commission_rate as 'Commision_Rate', 
        op.product_title as 'Product_Title',
        p.hsn_code as 'HSN_Code',
        op.product_quantity as 'Product_Qty',
        format(op.product_unit_price/100,2) as 'Product_Unit_Price',
        format(op.price_after_discount/100,2) as 'Price_After_Discount',
        format(op.price_excluded_gst/100,2) as 'Price_Excluded_GST',
        format(p.commission_amount/100,2) as 'Commission_Amount',
        p.gst_rate as 'Product_GST_Rate',
        op.product_gst_rate as 'Ordered_Product_GST_Rate',
        format(op.product_igst/100,2) as 'Product_IGST',
        format(op.product_cgst/100,2) as 'Product_CGST',
        format(op.product_sgst/100,2) as 'Product_SGST',
        format((op.product_igst + op.product_cgst + op.product_sgst)/100,2) as 'Product_Total_GST',
        format(op.product_total_price/100,2) as 'Product_Total_Price',
        format(op.product_shipping_cost/100,2) as 'Product_Shipping_Cost',
        format(op.shipping_igst/100,2) as 'Shipping_IGST', 
        format(op.shipping_cgst/100,2) as 'Shipping_CGST',
        format(op.shipping_sgst/100,2) as 'Shipping_SGST',
        format(op.total_shipping_cost/100,2) as 'Total_Shipping_Cost',
        format(op.product_cod_charges/100,2) as 'Product_COD_Charge',
        format(op.cod_igst/100,2) as 'COD_IGST',
        format(op.cod_cgst/100,2) as 'COD_CGST', 
        format(op.cod_sgst/100,2) as 'COD_SGST',
        format(op.total_cod_charges/100,2) as 'Total_COD_Charges',
        format(o.price_total/100,2) as 'Total_Ordered_Value',
        op.product_weight as 'Product_Weight',
        op.product_delivery_partner as 'Product_Delivery_Partner',
        o.total_tax_charges as 'Taxable_Value_Total',
        format((op.product_igst + op.shipping_igst + op.cod_igst)/100,2) as 'IGST_Total',    
        format((op.product_cgst + op.shipping_cgst + op.cod_cgst)/100,2) as 'CGST_Total',	
        format((op.product_sgst + op.shipping_sgst + op.cod_sgst)/100,2) as 'SGST_Total',	
        concat(buyer.first_name,' ', buyer.last_name) as 'Buyer_Name',
        buyer.email as 'Buyer_Email',
        buyer.phone_number as 'Buyer_Phone',
        o.created_at as 'Order_date',
        oship.shipping_state as 'Buyer_State'
    FROM 
        orders as o,
        order_products AS op,
        order_supplier as os,
        order_shipping as oship,
        products as p,
        users as u,
        users as buyer
    WHERE 
        o.id = op.order_id
    and op.order_id = os.order_id
    AND os.seller_id = op.seller_id
    AND o.id = oship.order_id
    AND op.product_id = p.id
    AND op.seller_id = u.id
    AND op.buyer_id = buyer.id
    AND op.created_at >= STR_TO_DATE('$start_date', '%Y-%m-%d %k:%i:%s')
     AND op.created_at <= STR_TO_DATE('$end_date', '%Y-%m-%d %k:%i:%s')";
        $query = $this->db->query($sql);
        return $query->result();
    }


    public function get_sales_data_reports($start_date, $end_date)
    {
        $end_date = $end_date . " 23:59:59";
        $sql = "SELECT * FROM sale_data_report where order_date >= STR_TO_DATE('$start_date', '%Y-%m-%d %k:%i:%s') AND order_date <= STR_TO_DATE('$end_date', '%Y-%m-%d %k:%i:%s')
         and order_status NOT IN( 'cancelled', 'cancelled_by_user' , 'cancelled_by_seller' , 'rejected','processing')";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function get_payment_report($start_date, $end_date)
    {
        $end_date = $end_date . " 23:59:59";
        $sql = "SELECT sdr.seller_id, sdr.order_no,sdr.order_date,
        format(sum(sdr.grand_total_amount),2) as total_product_amt,
        format(sum(sdr.commission_amount),2) as commission_amt,
        format(sum(sdr.seller_ship_cost),2) as shipping_amt,
        sum(sdr.seller_cod_cost) as cod_amt,
        format(sum(csp.gateway_amount/100),2) as getway_amt,
        format(( sum(sdr.commission_amount) + sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost) + sum(csp.gateway_amount/100) ) *18/100,2) as total_deduction,
        format(( csp.total_tcs_amount_product + csp.total_tcs_shipping)/100,2) as tcs_amt,
        format(( csp.total_tds_amount_product + csp.tds_amount_shipping)/100,2) as tds_amt,
        ifnull(format(sum(p.penalty_amount/100),2),0) as penalty_amt,
        ifnull(format((sum((p.penalty_amount/100))*18/100),2),0) as penalty_gst,
        ifnull(format((sum(p.penalty_amount/100) + (sum((p.penalty_amount/100))*18/100)),2),0) as penalty_total,
        format((sum(sdr.grand_total_amount) - 
        (((sum(sdr.commission_amount) + sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost) + sum(csp.gateway_amount/100)) *18/100) + sum(sdr.seller_cod_cost)
        + sum(csp.gateway_amount/100) + sum(sdr.seller_ship_cost) + sum(sdr.commission_amount) + 
        ((csp.total_tcs_amount_product + csp.total_tcs_shipping)/100) + (( csp.total_tds_amount_product + csp.tds_amount_shipping)/100) +
        ifnull((sum(p.penalty_amount/100) + (sum((p.penalty_amount/100))*18/100)),0)
        )),2) as net_balance
        
        FROM sale_data_report as sdr
        LEFT JOIN cashfree_seller_payout as csp 
        ON sdr.order_no = csp.order_id
        LEFT JOIN penalty as p
        ON sdr.seller_id = p.user_id
        where sdr.order_no = csp.order_id
        -- and sdr.order_no = p.order_number
        and sdr.seller_id = csp.vendorId
        and sdr.order_date >= STR_TO_DATE('$start_date', '%Y-%m-%d %k:%i:%s')
        and sdr.order_date <= STR_TO_DATE('$end_date', '%Y-%m-%d %k:%i:%s')
        and csp.is_active = 1
        and csp.is_completed = 1
        GROUP BY sdr.seller_id, sdr.order_no,sdr.order_date";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function get_commission_bill_report($start_date, $end_date)
    {
        $end_date = $end_date . " 23:59:59";
        $sql = "SELECT DATE_FORMAT(sdr.order_date, '%M %Y') as 'Order_Month',
        sdr.seller as Seller,
        sdr.seller_email as Email,
        sdr.seller_phone as 'Phone',
        sdr.shop_name as Shop_name,
        sdr.pan_no as 'Pan',
        sdr.gst_no as 'GST',
        sdr.seller_address as 'Address',
        format(sum(sdr.commission_amount),2) as 'total_commission_amount',
        format(sum(sdr.seller_ship_cost),2) as 'Total_shipping_cost',
        format(sum(sdr.seller_cod_cost),2) as 'Total_Cod_cost',
        ifnull(format(sum(csp.gateway_amount/100),2) , 0) as 'getway_amt',
        -- format(sum(csp.gateway_amount/100),2) as getway_amt,
        '18%' as 'GST_Rate', 
        FORMAT(((sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost) 
                     + sum(sdr.commission_amount) + ifnull(format(sum(csp.gateway_amount/100),2) , 0) ) * 18) / 100, 2) AS GST_Amount,
            IF(STRCMP(upper(u.supplier_state), 'DELHI') = 0,
                FORMAT((((sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost)
                     + sum(sdr.commission_amount) + ifnull(format(sum(csp.gateway_amount/100),2) , 0)) * 18) / 100)/2,2), 0 ) as CGST,
                IF(STRCMP(upper(u.supplier_state), 'DELHI') = 0,
                FORMAT((((sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost)
                     + sum(sdr.commission_amount) + ifnull(format(sum(csp.gateway_amount/100),2) , 0)) * 18) / 100)/2, 2), 0 ) as SGST,
                    IF(STRCMP(upper(u.supplier_state), 'DELHI') = 0, 0,
                FORMAT(((sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost)
                     + sum(sdr.commission_amount) + ifnull(format(sum(csp.gateway_amount/100),2) , 0)) * 18) / 100, 2)) as IGST,
                Format ((sum(sdr.commission_amount) + sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost) + ifnull(sum(csp.gateway_amount/100), 0) +  
                (((sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost) 
                     + sum(sdr.commission_amount) + ifnull(sum(csp.gateway_amount/100), 0) ) * 18) / 100) ),2) as TOTAL
        
         -- FORMAT(sum(csp.gateway_amount)/100,2) as Gateway_charges
         FROM sale_data_report as sdr
         LEFT JOIN cashfree_seller_payout as csp 
          ON sdr.order_no = csp.order_id,
          users as u
          where sdr.seller_email = u.email
         and sdr.order_date >= STR_TO_DATE('$start_date', '%Y-%m-%d %k:%i:%s')
         and sdr.order_date <= STR_TO_DATE('$end_date', '%Y-%m-%d %k:%i:%s')
         and sdr.order_status NOT IN( 'cancelled', 'cancelled_by_user' , 'cancelled_by_seller' , 'rejected','processing')
         group by sdr.seller ,
        sdr.seller_email ,
        sdr.seller_phone ,
        sdr.shop_name,
        sdr.pan_no,
        sdr.gst_no,
        sdr.seller_address";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function get_seller_ledgers_report($start_date, $end_date)
    {
        $end_date = $end_date . " 23:59:59";
        $sql = "SELECT sdr.seller_id,
        format(sum(sdr.grand_total_amount),2) as total_product_amt,
        format(sum(sdr.commission_amount),2) as commission_amt,
        format(sum(sdr.seller_ship_cost),2) as shipping_amt,
        sum(sdr.seller_cod_cost) as cod_amt,
        format(sum(csp.gateway_amount/100),2) as getway_amt,
        format(( sum(sdr.commission_amount) + sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost) + sum(csp.gateway_amount/100) ) *18/100,2) as total_deduction,
        format((sum(csp.total_tcs_amount_product) + sum(csp.total_tcs_shipping))/100,2) as tcs_amt,
        format((sum(csp.total_tds_amount_product) + sum(csp.tds_amount_shipping))/100,2) as tds_amt,
        ifnull(format(sum(p.penalty_amount/100),2),0) as penalty_amt,
        ifnull(format((sum((p.penalty_amount/100))*18/100),2),0) as penalty_gst,
        ifnull(format((sum(p.penalty_amount/100) + (sum((p.penalty_amount/100))*18/100)),2),0) as penalty_total,
        format((sum(sdr.grand_total_amount) - 
        (((sum(sdr.commission_amount) + sum(sdr.seller_ship_cost) + sum(sdr.seller_cod_cost) + sum(csp.gateway_amount/100)) *18/100) + sum(sdr.seller_cod_cost)
        + sum(csp.gateway_amount/100) + sum(sdr.seller_ship_cost) + sum(sdr.commission_amount) +
        ((csp.total_tcs_amount_product + csp.total_tcs_shipping)/100) + (( csp.total_tds_amount_product + csp.tds_amount_shipping)/100) + 
        ifnull((sum(p.penalty_amount/100) + (sum((p.penalty_amount/100))*18/100)),0)
        )),2) as net_balance
        
        FROM sale_data_report as sdr
        LEFT JOIN cashfree_seller_payout as csp 
        ON sdr.order_no = csp.order_id
        LEFT JOIN penalty as p
        ON sdr.seller_id = p.user_id
        where sdr.order_no = csp.order_id
        / and sdr.order_no = p.order_number /
        and sdr.seller_id = csp.vendorId
        and sdr.order_date >= STR_TO_DATE('$start_date', '%Y-%m-%d %k:%i:%s')
        and sdr.order_date <= STR_TO_DATE('$end_date', '%Y-%m-%d %k:%i:%s')
        and csp.is_active = 1
        and csp.is_completed = 1
        GROUP BY sdr.seller_id";
        $query = $this->db->query($sql);
        return $query->result();
    }
    public function cash_free_charges($start_date, $end_date)
    {
        $end_date = $end_date . " 23:59:59";
        $sql = "SELECT DISTINCT
        o.created_at AS 'Order_Date',
        o.id AS 'Order_ID',
        o.payment_method AS 'Payment_Mode',
        csp.commission_rate AS 'Commission_Rate',
        op.order_status AS 'Status',
        op.buyer_id AS 'Buyer_ID',
        ifNULL(CONCAT(buyer.first_name, ' ', buyer.last_name),buyer.first_name) AS 'Buyer_Name',
        buyer.username AS 'Buyer_Username',
        buyer.phone_number AS 'Buyer_Phone_Number',
        buyer.email AS 'Buyer_Email',
        seller.brand_name AS 'Brand_Name',
        seller.pan_number AS 'Seller_PAN_Number',
        seller.shop_name AS 'Seller_Shop_Name',
        seller.email AS 'Seller_E_mail',
        p.sku AS 'Product_SKU',
        op.product_title AS 'Product_Title',
        op.product_gst_rate AS 'Product_GST_Rate',
        format(op.product_total_price/100,2) AS 'Product_Total_Price',
        format(os.total_shipping_cost/100,2) AS 'Shipping_Cost',
        format(o.price_total/100,2) AS 'Amount_Received ',
        format(csp.net_seller_payable/100,2) AS 'Seller_Payable',
        csp.payout_initiated AS 'Payout_Initiated',
        format(csp.commission_amount/100,2) AS 'Commission_Amount',
        format(csp.commission_amount_with_gst/100,2) AS 'Commission_Amount_With_GST',
        format(csp.shipping_charge_to_gharobaar/100,2) AS 'Shipping_charges_to_gharobaar',
        format(csp.tcs_amount/100,2) AS 'TCS_Amount',
        format(csp.tds_amount/100,2) AS 'TDS_Amount',
        format(csp.gateway_amount/100,2) AS 'Gateway_Amount',
        format(csp.gateway_amount_with_gst/100,2) AS 'Gateway_Amount_With_GST',
        trx.cashfree_order_id AS 'Cashfree_order_ID',
        trx.payment_id AS 'Cashfree_Payment_ID',
        format(ref.refund_amount,2) AS 'Refund_Amount'
    FROM
        orders AS o
            JOIN
        order_products AS op ON o.id = op.order_id,
        orders AS o2
            LEFT JOIN
        refunds AS ref ON o2.id = ref.order_id,
        users AS buyer,
        users AS seller,
        products AS p,
        order_supplier AS os,
        cashfree_seller_payout AS csp,
        transactions AS trx
    WHERE
        op.seller_id = seller.id
            AND op.buyer_id = buyer.id
            AND o.buyer_id = op.buyer_id
            AND op.product_id = p.id
            AND o.id = os.order_id
            AND op.seller_id = os.seller_id
            AND seller.id = os.seller_id
            AND o.id = csp.order_id
            AND seller.id = csp.vendorId
            AND o.id = trx.order_id
            AND o.created_at >= STR_TO_DATE('$start_date', '%Y-%m-%d %k:%i:%s')
            AND o.created_at < STR_TO_DATE('$end_date', '%Y-%m-%d %k:%i:%s') 
            AND buyer.id != seller.id
            AND csp.is_active = 1
            AND csp.is_completed = 1
            AND o.id = o2.id";
        $query = $this->db->query($sql);
        return $query->result();
    }
}
