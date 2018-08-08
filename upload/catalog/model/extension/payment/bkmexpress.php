<?php

class ModelExtensionPaymentBkmexpress extends Model {

	//save transaction history 
	public function saveResponse($data){
	    if(!isset($data['transaction_id'])) return;

		$sql = "insert into `".DB_PREFIX."bkmexpress_order` SET 
		  `order_id` = '".$data['passive_data']."',
		  `transaction_id` = '".$data['transaction_id']."',
		  `status` = '".$data['status']."',
		  `client_ip` = '".$_SERVER['REMOTE_ADDR']."',
		  `ErrorMSG` = '".$data['ErrorMSG']."',
		  `ErrorCode` = '".$data['ErrorCode']."',
		  `conversion_rate` = '".$data['conversion_rate']."',
		  `try_total` = '".$data['total']."',
		  `original` = '".json_encode($data)."',
		  `date_added` = NOW()";

		$this->db->query($sql);
	}

	//send data to bank 
	public function send(){

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$total = $this->currency->format($order_info['total'], $order_info['currency_code'], false, false);

        $params = array(
            "type"            => 'Sale',
            "total"           => $total,
            "currency"        => $order_info['currency_code'],
            "language"        => 'tr',
            "client_ip"       => $_SERVER['REMOTE_ADDR'],
            "payment_title"   => 'Order #'.$order_info['order_id'],
            "return_url"      => $this->url->link('extension/payment/bkmexpress/callback','',true),
            "bank_id"         => 'BKMExpress',
            "installments"    => '1',

            "customer_firstname" => $order_info['firstname'],
            "customer_lastname"  => $order_info['lastname'],
            "customer_email"     => $order_info['email'],
            "customer_phone"     => $order_info['telephone'],

            "passive_data"  => $order_info['order_id'],
        );

        $params['total'] = number_format($params['total'], 2, '.', '');

		return $this->call($params);
	}

	public function call($params){

		$merchantPassword = $this->config->get('bkmexpress_password');

		$params["merchant"] = $this->config->get('bkmexpress_username');

		$api_url = $this->config->get('bkmexpress_endpoint');

		//begin HASH calculation
		ksort($params);
		$hashString = "";
		foreach ($params as $key=>$val) {
		    $l = mb_strlen($val);
            if($l) $hashString .= $l . $val;
		}
		$params["hash"] = hash_hmac("sha1", $hashString, $merchantPassword);
		//end HASH calculation

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
		$response = curl_exec($ch);

		$curlerrcode = curl_errno($ch);
		$curlerr = curl_error($ch);

		return $response;
	}

	public function getMethod($address, $total) {
		$this->load->language('extension/payment/bkmexpress');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('cod_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('bkmexpress_total') > 0 && $this->config->get('bkmexpress_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('bkmexpress_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();


		if ($status) {
			$method_data = array(
				'code'       => 'bkmexpress',
				'title'      => $this->language->get('text_bkmexpress'),
				'terms'      => '',
				'sort_order' => $this->config->get('bkmexpress_sort_order')
			);
		}

		return $method_data;
	}
} 