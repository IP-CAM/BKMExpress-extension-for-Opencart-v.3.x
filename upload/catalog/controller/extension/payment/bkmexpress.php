<?php
class ControllerExtensionPaymentBkmexpress extends Controller {

	public function index() {
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $openCartBaseUrl = $this->config->get('config_ssl');
        } else {
            $openCartBaseUrl = $this->config->get('config_url');
        }

	    //prepare BKMExpress parameters for view
        require_once(DIR_SYSTEM . '/library/Bkmexpress/BKMExpress.php');
        $bkmExpressObj = new BKMExpress;
        $merchantPrivateKey = $this->config->get('bkmexpress_privatekey');
        $preProdMode = $this->config->get('bkmexpress_preprod');
        $merchantId = $this->config->get('bkmexpress_merchantid');
        $nonceURL = $this->url->link('extension/payment/bkmexpress/nonce');
        $installmentsURL = $this->url->link('extension/payment/bkmexpress/installments');
        $bkmExpressParams = $bkmExpressObj->initSale($merchantPrivateKey, $preProdMode, $merchantId, $nonceURL, $installmentsURL);
        $data['bkm_express_params'] = $bkmExpressParams;
        $data['bkm_express_cancel_url'] = $this->url->link('extension/payment/bkmexpress/cancel');;
        $data['bkm_express_success_url'] = $this->url->link('extension/payment/bkmexpress/success');;
        $data['bkm_express_js_url'] = $openCartBaseUrl . '/system/library/Bkmexpress/BKMExpress.js';


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

	public function installments(){
        $data['entry_bank_list_array'] = $this->config->get('entry_bank_list_array');
        $installmentsArray = $bankConfigArray = [];
        foreach($data['entry_bank_list_array'] as $bankIdInLoop=>$bankArrayInLoop){
            //bank config
            foreach($bankArrayInLoop['params'] as $bankParamMachineName=>$bankParamTitleValue){
                $openCartMachineNameForField = "bkmexpress_$bankParamMachineName$bankIdInLoop";
                $openCartParamValue = $this->config->get($openCartMachineNameForField);
                $bankConfigArray[$bankIdInLoop]['params'][$bankParamMachineName]['value'] = $openCartParamValue;
            }
            //installments
            for ($x = 2; $x <= 12; $x++) {
                $installmentsArray[$bankIdInLoop] = [$x=>False];
                $bankInstallmentsField = 'bkmexpress_installments_'.$x.'_'.$bankIdInLoop;
                $instActive = $this->config->get($bankInstallmentsField);
                $installmentsArray[$bankIdInLoop][$x] =
                    ( isset($instActive) AND $instActive)?True:False;
            }
        }

        require_once(DIR_SYSTEM . '/library/Bkmexpress/BKMExpress.php');
        $bkmExpressObj = new BKMExpress;
        $bkmExpressObj->installments($installmentsArray);
    }

}
