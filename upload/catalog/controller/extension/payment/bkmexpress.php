<?php
class ControllerExtensionPaymentBkmexpress extends Controller {

	public function index() {

		$this->language->load('extension/payment/bkmexpress');
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $base_url = $this->config->get('config_ssl');
        } else {
            $base_url = $this->config->get('config_url');
        }

		$data['entry_bkmexpress_amount'] 		= $this->language->get('entry_bkmexpress_amount');
		$data['entry_bkmexpress_total'] 		= $this->language->get('entry_bkmexpress_total');
		$data['button_confirm'] = $this->language->get('button_confirm');
		$data['text_wait'] = $this->language->get('text_wait');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_bkm_explanation'] = $this->language->get('text_bkm_explanation');
        $data['bkmexpress_logo'] = $base_url.'image/bkmexpress/bkmexpress.png';

		$this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$total 		= $this->currency->format($order_info['total'], $order_info['currency_code'], false, true);
		$data['total']         = $total;
        return $this->load->view('extension/payment/bkmexpress', $data);
	}

	public function send(){
		$this->load->model('extension/payment/bkmexpress');

		$json = array();

		$error = $this->validatePaymentData();
		if(count($error)){
			$json['error'] = $error;
			echo json_encode($json);
			exit;
		}

		$response = $this->model_extension_payment_bkmexpress->send();

		//html response
		if(strpos($response, '<form') !== False OR strpos($response, '<html')){
		    $responseData = ['html'=>$response, 'status'=>True];
		}else{
		    $responseData = @json_decode($response, true);
		}

        if(!isset($responseData['status'])){
            $json['error']['general_error'] = 'Bkmexpress gateway connection problem';
            echo json_encode($json);
            exit;
        }

        if(!isset($responseData['status']) OR !$responseData['status']){
            $json['error']['general_error'] = $responseData['ErrorMSG'];
            echo json_encode($json);
            exit;
        }else{
            //success need to print html 3d response
			$this->db->query('insert into `'.DB_PREFIX.'bkmexpress_html_response` SET response_html="'.htmlspecialchars($responseData['html']).'"');
			$this->session->data['response_id'] = $this->db->getLastId();
			$json['success'] = $this->url->link('extension/payment/bkmexpress/secure');
			$json['response_html'] = htmlspecialchars($responseData['html']);
		}
		echo json_encode($json);
	}

	public function validatePaymentData(){
		$this->language->load('extension/payment/bkmexpress');
		$error = [];
		return $error;
	}

    public function secure(){
        try{
            $html = $this->db->query('select response_html from `'.DB_PREFIX.'bkmexpress_html_response` WHERE response_id = "'.$this->session->data['response_id'].'"');
            $html = isset($html->row['response_html'])?$html->row['response_html']:'Bad Request';
            //delete form
            $this->db->query('delete from `'.DB_PREFIX.'bkmexpress_html_response` WHERE response_id = "'.$this->session->data['response_id'].'"');
            echo htmlspecialchars_decode($html);
        } catch (Exception $e){
            echo 'Bad Request';
        }
    }

	public function callback() {
		$this->load->model('extension/payment/bkmexpress');

        $post = $this->request->post;

		//hash
		$merchantPassword = $this->config->get('bkmexpress_password');
		$hash             = self::generateHash($post, $merchantPassword);

		//save response 
		$this->model_extension_payment_bkmexpress->saveResponse($post);

		if (isset($post['passive_data'])) {
			$order_id = $post['passive_data'];
		} else {
			$order_id = 0;
		}

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($order_id);
		if ($order_info && $post['ErrorCode'] == '00' && ($hash == $post["hash"])) {
			$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('bkmexpress_order_status_id'));
			$this->response->redirect($this->url->link('checkout/success'));
		}else{
			$this->response->redirect($this->url->link('checkout/failure'));
		}
	}

    protected static function generateHash($params, $password){
        $arr = [];
        if(isset($params['hash']))  unset($params['hash']);
        if(isset($params['_csrf'])) unset($params['_csrf']);

        foreach($params as $param_key=>$param_val){$arr[strtolower($param_key)]=$param_val;}
        ksort($arr);
        $hashString_char_count = "";
		foreach ($arr as $key=>$val) {
		    $l =  mb_strlen($val);
		    if($l) $hashString_char_count .= $l . $val;
		}
		$hashString_char_count      = strtolower(hash_hmac("sha1", $hashString_char_count, $password));
		return $hashString_char_count;
	}
}
