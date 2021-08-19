<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_admin_controller extends Admin_Core_Controller
{
	public function __construct()
	{
		parent::__construct();
		//check user
		if (!is_admin()) {
			redirect(admin_url() . 'login');
		}
	}

	/**
	 * Orders
	 */
	public function orders()
	{
		$data['title'] = trans("orders");
		$data['form_action'] = admin_url() . "orders";

		$pagination = $this->paginate(admin_url() . 'orders', $this->order_admin_model->get_orders_count());
		$data['orders'] = $this->order_admin_model->get_paginated_orders($pagination['per_page'], $pagination['offset']);
        $data["session"] = get_user_session();

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/order/orders', $data);
		$this->load->view('admin/includes/_footer');
	}

	/**
	 * Order Details
	 */
	public function order_details($id)
	{
		$data['title'] = trans("order");

		$data['order'] = $this->order_admin_model->get_order($id);
		if (empty($data['order'])) {
			redirect(admin_url() . "orders");
		}
		$data['order_products'] = $this->order_admin_model->get_order_products($id);
        $data["session"] = get_user_session();

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/order/order_details', $data);
		$this->load->view('admin/includes/_footer');
	}

	public function order_product_details($id)
	{
		$data['title'] = trans("order");

		$data['order'] = $this->order_admin_model->get_order($id);
		if (empty($data['order'])) {
			redirect(admin_url() . "orders");
		}
		$data['order_products'] = $this->order_admin_model->get_order_products($id);
        $data["session"] = get_user_session();

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/order/order_details', $data);
		$this->load->view('admin/includes/_footer');
	}

	/**
	 * Order Options Post
	 */
	public function order_options_post()
	{
		$order_id = $this->input->post('id', true);
		$option = $this->input->post('option', true);

		if ($option == "payment_received") {
			$this->order_admin_model->update_order_payment_received($order_id);

			$this->order_admin_model->update_payment_status_if_all_received($order_id);
			$this->order_admin_model->update_order_status_if_completed($order_id);
		}

		$this->session->set_flashdata('success', trans("msg_updated"));
		redirect($this->agent->referrer());
	}

	/**
	 * Delete Order Post
	 */
	public function delete_order_post()
	{
		$id = $this->input->post('id', true);
		if ($this->order_admin_model->delete_order($id)) {
			$this->session->set_flashdata('success', trans("msg_deleted"));
		} else {
			$this->session->set_flashdata('error', trans("msg_error"));
		}
	}

	/**
	 * Update Order Product Status Post
	 */
	public function update_order_product_status_post()
	{
		$id = $this->input->post('id', true);
		$order_product = $this->order_admin_model->get_order_product($id);
		if (!empty($order_product)) {
			if ($this->order_admin_model->update_order_product_status($order_product->id)) {
				$order_status = $this->input->post('order_status', true);
				if ($order_product->product_type == "digital") {
					if ($order_status == 'completed' || $order_status == 'payment_received') {
						$this->order_model->add_digital_sale($order_product->product_id, $order_product->order_id);
						//add seller earnings
						$this->earnings_model->add_seller_earnings($order_product);
					}
				} else {
					if ($order_status == 'completed') {
						//add seller earnings
						$this->earnings_model->add_seller_earnings($order_product);
					} else {
						//check if earning added before
						$order = $this->order_admin_model->get_order($order_product->order_id);
						if (!empty($order) && !empty($this->earnings_model->get_earning_by_user_id($order_product->seller_id, $order->order_number))) {
							//remove seller earnings
							$this->earnings_model->remove_seller_earnings($order_product);
						}
					}
				}
				$this->session->set_flashdata('success', trans("msg_updated"));
			} else {
				$this->session->set_flashdata('error', trans("msg_error"));
			}

			$this->order_admin_model->update_payment_status_if_all_received($order_product->order_id);
			$this->order_admin_model->update_order_status_if_completed($order_product->order_id);
		}
		redirect($this->agent->referrer() . "#t_product");
	}

	/**
	 * Delete Order Product Post
	 */
	public function delete_order_product_post()
	{
		$id = $this->input->post('id', true);
		if ($this->order_admin_model->delete_order_product($id)) {
			$this->session->set_flashdata('success', trans("msg_deleted"));
		} else {
			$this->session->set_flashdata('error', trans("msg_error"));
		}
	}

	/**
	 * Transactions
	 */
	public function transactions()
	{
		$data['title'] = trans("transactions");
		$data['form_action'] = admin_url() . "transactions";

		$pagination = $this->paginate(admin_url() . 'transactions', $this->transaction_model->get_transactions_count());
		$data['transactions'] = $this->transaction_model->get_paginated_transactions($pagination['per_page'], $pagination['offset']);
        $data["session"] = get_user_session();

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/order/transactions', $data);
		$this->load->view('admin/includes/_footer');
	}

	/**
	 * Delete Transaction Post
	 */
	public function delete_transaction_post()
	{
		$id = $this->input->post('id', true);
		if ($this->transaction_model->delete_transaction($id)) {
			$this->session->set_flashdata('success', trans("msg_deleted"));
		} else {
			$this->session->set_flashdata('error', trans("msg_error"));
		}
	}

	/**
	 * Bank Transfer Notifications
	 */
	public function order_bank_transfers()
	{
		$data['title'] = trans("bank_transfer_notifications");
		$data['form_action'] = admin_url() . "order-bank-transfers";

		$pagination = $this->paginate(admin_url() . 'order-bank-transfers', $this->order_admin_model->get_bank_transfers_count());
		$data['bank_transfers'] = $this->order_admin_model->get_paginated_bank_transfers($pagination['per_page'], $pagination['offset']);
        $data["session"] = get_user_session();

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/order/bank_transfers', $data);
		$this->load->view('admin/includes/_footer');
	}

	/**f
	 * Bank Transfer Options Post
	 */
	public function bank_transfer_options_post()
	{
		$id = $this->input->post('id', true);
		$order_id = $this->input->post('order_id', true);
		$option = $this->input->post('option', true);
		if ($this->order_admin_model->update_bank_transfer_status($id, $option)) {
			if ($option == 'approved') {
				$this->order_admin_model->update_order_payment_received($order_id);
			}
			$this->order_admin_model->update_order_status_if_completed($order_id);
			$this->session->set_flashdata('success', trans("msg_updated"));
			redirect($this->agent->referrer());
		} else {
			$this->session->set_flashdata('error', trans("msg_error"));
			redirect($this->agent->referrer());
		}
	}

	/**
	 * Approve Guest Order Product
	 */
	public function approve_guest_order_product()
	{
		$order_product_id = $this->input->post('order_product_id', true);
		if ($this->order_admin_model->approve_guest_order_product($order_product_id)) {
			//order product
			$order_product = $this->order_admin_model->get_order_product($order_product_id);
			//add seller earnings
			$this->earnings_model->add_seller_earnings($order_product);
			//update order status
			$this->order_admin_model->update_order_status_if_completed($order_product->order_id);
		}
		redirect($this->agent->referrer());
	}

	/**
	 * Delete Bank Transfer Post
	 */
	public function delete_bank_transfer_post()
	{
		$id = $this->input->post('id', true);
		if ($this->order_admin_model->delete_bank_transfer($id)) {
			$this->session->set_flashdata('success', trans("msg_deleted"));
		} else {
			$this->session->set_flashdata('error', trans("msg_error"));
		}
	}

    /**
     * Invoices
     */
    public function invoices()
    {
        $data['title'] = trans("invoices");
        $data['form_action'] = admin_url() . "invoices";
        $data["session"] = get_user_session();
        $pagination = $this->paginate(admin_url() . 'invoices', $this->order_admin_model->get_invoices_count());
        $data['invoices'] = $this->order_admin_model->get_paginated_invoices($pagination['per_page'], $pagination['offset']);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/order/invoices', $data);
        $this->load->view('admin/includes/_footer');
    }

	/**
	 * Digital Sales
	 */
	public function digital_sales()
	{
		$data['title'] = trans("digital_sales");
		$data['form_action'] = admin_url() . "digital-sales";
        $data["session"] = get_user_session();
		$pagination = $this->paginate(admin_url() . 'digital-sales', $this->order_admin_model->get_digital_sales_count());
		$data['digital_sales'] = $this->order_admin_model->get_digital_sales($pagination['per_page'], $pagination['offset']);

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/order/digital_sales', $data);
		$this->load->view('admin/includes/_footer');
	}

	/**
	 * Delete Digital Sales Post
	 */
	public function delete_digital_sales_post()
	{
		$id = $this->input->post('id', true);
		if ($this->order_admin_model->delete_digital_sale($id)) {
			$this->session->set_flashdata('success', trans("msg_deleted"));
		} else {
			$this->session->set_flashdata('error', trans("msg_error"));
		}
	}

/**
	 * Fetch All refunds
	 */
	public function refunds()
	{
		$data['title'] = trans("refunds");
		$data['form_action'] = admin_url() . "refunds";
		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/order/refunds', $data);
		$this->load->view('admin/includes/_footer');
	}
/**
	 * Initiate refunds
	 */
	public function initiate_refund()
	{
		$order_product_id = $this->input->post('order_product_id', true);
		$order_id = $this->input->post('order_id', true);
		$order_product = $this->order_model->get_order_product($order_product_id);
		$product_id = $order_product->product_id;
		$payment_refrence_id = $this->input->post('payment_refrence_id', true);
		$order_total_amount = $this->input->post('order_amount', true);
		$order_total_amount_for_db = $order_total_amount*100;
		$product_price = $this->input->post('product_price', true);
		$refund_amount = $this->input->post('refund_amount', true);
		$cashfree_refundurl = $this->general_settings->cashfree_api_base_url .'api/v1/order/refund';
		$data = array(
            "order_id" => $order_id,
            "refund_amount" => $refund_amount,
            "payment_refrence_id" => $payment_refrence_id,
			"order_product_id" => $product_id,
			"order_product_table_id" => $order_product_id,
            "order_total_amount" => $order_total_amount_for_db
        );
		$refund_data = $data;
		$curl = curl_init();
        curl_setopt_array($curl, array(
            // CURLOPT_URL => '%7B%7BBase%20URL%7D%7D/api/v1/order/refund',
            CURLOPT_URL => $cashfree_refundurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'appId' => $this->general_settings->cashfree_app_id,
                'secretKey' => $this->general_settings->cashfree_secret_key,
                'referenceId' => $payment_refrence_id,
                'refundAmount' => $refund_amount,
                'refundNote' => 'Refund initiated by admin',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $responded_data = json_decode($response);
        $refund_data["status"] = $responded_data->status;
        $refund_data["message"] = $responded_data->message;
        $refund_data["refund_id"] = $responded_data->refundId;
		$refund_data["refund_note"] = 'Refund initiated by admin';
		$refund_data["created_by"] = $this->auth_user->id;
		$this->order_model->save_refund_detail($refund_data);
		
		redirect($this->agent->referrer());
	}


}
