<?php
class ControllerExtensionPaymentBkmexpress extends Controller {

	public function index() {
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $openCartBaseUrl = $this->config->get('config_ssl');
        } else {
            $openCartBaseUrl = $this->config->get('config_url');
        }

	    //prepare BKMExpress parameters for view
        require_once(DIR_SYSTEM . 'library/bkmexpress/BKMExpress.php');
        $bkmExpressObj = new BKMExpress;
        $merchantPrivateKey = $this->config->get('bkmexpress_privatekey');
        $preProdMode = $this->config->get('bkmexpress_preprod');
        $merchantId = $this->config->get('bkmexpress_merchantid');
        $nonceURL = $this->url->link('extension/payment/bkmexpress/nonce');
        $installmentsURL = $this->url->link('extension/payment/bkmexpress/installments');
        //get order total from opencart
        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $orderTotal = $this->currency->format($order_info['total'], 'TRY', false, false);
        $orderTotal = number_format($orderTotal, 2, ',', '');
        $bkmExpressParams = $bkmExpressObj->initSale($merchantPrivateKey, $preProdMode, $merchantId, $nonceURL, $installmentsURL, $orderTotal);
        $data['bkm_express_params'] = $bkmExpressParams;
        $data['bkm_express_cancel_url'] = $this->url->link('extension/payment/bkmexpress/cancel');;
        $data['bkm_express_success_url'] = $this->url->link('extension/payment/bkmexpress/success');;
        $data['bkm_express_js_url'] = $openCartBaseUrl . '/system/library/bkmexpress/BKMExpress.js';


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

	public function installments(){
        require_once(DIR_SYSTEM . 'library/bkmexpress/BKMExpress.php');
        $bkmExpressObj = new BKMExpress;
        $entry_bank_list_array = $bkmExpressObj->getBankList();
        $installmentsArray = $bankConfigArray = [];
        foreach($entry_bank_list_array as $bankIdInLoop=>$bankArrayInLoop){
            //bank config
            foreach($bankArrayInLoop['params'] as $bankParamMachineName=>$bankParamTitleValue){
                $openCartMachineNameForField = "bkmexpress_$bankParamMachineName$bankIdInLoop";
                $openCartParamValue = $this->config->get($openCartMachineNameForField);
                $bankConfigArray[$bankIdInLoop]['params'][$bankParamMachineName]['value'] = $openCartParamValue;
            }
            //installments
            for ($x = 2; $x <= 12; $x++) {
                $installmentsArray[$bankIdInLoop] = isset($installmentsArray[$bankIdInLoop])?$installmentsArray[$bankIdInLoop]:[];
                $installmentsArray[$bankIdInLoop][$x] = isset($installmentsArray[$bankIdInLoop][$x])?$installmentsArray[$bankIdInLoop][$x]:False;

                $bankInstallmentsField = 'bkmexpress_installments_'.$x.'_'.$bankIdInLoop;
                $instActive = $this->config->get($bankInstallmentsField);
                $installmentsArray[$bankIdInLoop][$x] =
                    ( isset($instActive) AND $instActive)?True:False;
            }
        }
        $bkmExpressObj->installments($installmentsArray, $bankConfigArray);
    }

    public function nonce(){
        require_once(DIR_SYSTEM . 'library/bkmexpress/BKMExpress.php');
        $bkmExpressObj = new BKMExpress;
        $merchantPrivateKey = $this->config->get('bkmexpress_privatekey');
        $merchantId = $this->config->get('bkmexpress_merchantid');
        $preProdMode = $this->config->get('bkmexpress_preprod');
        $bkmExpressObj->nonce($merchantPrivateKey, $preProdMode, $merchantId);
    }

}
