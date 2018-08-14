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
        $nonceURL = $this->url->link('extension/payment/bkmexpress/nonce')."&orderId=".$this->session->data['order_id'];
        $installmentsURL = $this->url->link('extension/payment/bkmexpress/installments');
        //get order total from opencart
        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $orderTotal = $this->currency->format($order_info['total'], 'TRY', false, false);
        $orderTotal = number_format($orderTotal, 2, ',', '');
        $bkmExpressParams = $bkmExpressObj->initSale($merchantPrivateKey, $preProdMode, $merchantId, $nonceURL, $installmentsURL, $orderTotal);
        $data['bkm_express_params'] = $bkmExpressParams;
        $data['bkm_express_cancel_url'] = $this->url->link('extension/payment/bkmexpress/refresh');;
        $data['bkm_express_result_url'] = $this->url->link('extension/payment/bkmexpress/result');;
        $data['bkm_express_success_url'] = $this->url->link('extension/payment/bkmexpress/success');
        $data['bkm_express_fail_url'] = $this->url->link('extension/payment/bkmexpress/failure');
        $data['bkm_express_js_url'] = $openCartBaseUrl . '/system/library/bkmexpress/BKMExpress.js';
        $data['bkm_express_order_id'] = $this->session->data['order_id'];


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
        $data = json_decode(file_get_contents('php://input'), True);
        $bkmExpressObj->installments($installmentsArray, $bankConfigArray, $data);
    }

    public function nonce(){
        //get order total from opencart
        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($_GET['orderId']);
        $orderTotal = $this->currency->format($order_info['total'], 'TRY', false, false);
        $orderTotal = number_format($orderTotal, 2, ',', '');
        $orderStatus = ($order_info['order_status_id'] == 0);

        require_once(DIR_SYSTEM . 'library/bkmexpress/BKMExpress.php');
        $bkmExpressObj = new BKMExpress;
        $merchantPrivateKey = $this->config->get('bkmexpress_privatekey');
        $merchantId = $this->config->get('bkmexpress_merchantid');
        $preProdMode = $this->config->get('bkmexpress_preprod');
        $data = json_decode(file_get_contents('php://input'), TRUE);
        //$data = json_decode('{"id":"754acce4-e540-42cc-abde-de82d399af33","path":"bUAvbS85ZDY4MThjNS04ZGE1LTQwNzItZGIxNy1jN2Y1NTliNDRhZWIvdC83NTRhY2NlNC1lNTQwLTQyY2MtYWJkZS1kZTgyZDM5OWFmMzNAZ2UucGJ6Lm94ei5vcmsyLmZyZWlyZS5uY3YuenJlcHVuYWcuY25senJhZy5Dbmx6cmFnR3ZweHJn","issuer":"9d6818c5-8da5-4072-db17-c7f559b44aeb","approver":"0005df9d-00b1-48c4-8020-00000000005","token":"eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJiZXgiLCJzdWIiOiI3NTRhY2NlNC1lNTQwLTQyY2MtYWJkZS1kZTgyZDM5OWFmMzMiLCJpc3N1ZXIiOiI5ZDY4MThjNS04ZGE1LTQwNzItZGIxNy1jN2Y1NTliNDRhZWIiLCJhcHByb3ZlciI6IjAwMDVkZjlkLTAwYjEtNDhjNC04MDIwLTAwMDAwMDAwMDA1Iiwibm9uY2UiOiI0ZDRmM2U1Yi0zNmY5LTQ1YTgtODc0NC0yMmRjZGYxMWQ3MzciLCJzaWQiOiI3NTRhY2NlNC1lNTQwLTQyY2MtYWJkZS1kZTgyZDM5OWFmMzMiLCJ0aWQiOiIvbS85ZDY4MThjNS04ZGE1LTQwNzItZGIxNy1jN2Y1NTliNDRhZWIvdC83NTRhY2NlNC1lNTQwLTQyY2MtYWJkZS1kZTgyZDM5OWFmMzMiLCJjbHMiOiJ0ci5jb20uYmttLmJleDIuc2VydmVyLmFwaS5tZXJjaGFudC5wYXltZW50LlBheW1lbnRUaWNrZXQiLCJleHAiOjE1MzQyNDc1NDZ9.jG5HgBR90TrLXykgL7FofSI-iM9esJwduH2mvfrOnr0","signature":"E6g7YvaPfKFzkcpBBlWpKmTkevlKhw8bMMABkrjjtoIBgQRR8TjB+EyDDPzAJBPnNlxWTRIO5fKzMTZRaJPMEpTXQ7jAE\/7RKDyvgMZOqRkNjuFGEkc0pSPkUga\/Dg6oUdweVYdJ7uj1aM6UiJV\/46rUVafOTjNoXbRID+sikeb0GhfaNiyPyqcoc0KNob5FTi2jasxl9pen3Bpo8QGK3kIRFQT4ORSRw3JI6KKTZ7\/P5ISAWLNIR2NNAiBKHOiEPDXb4Ttodqj80lAD\/\/Z61l3VjZf4hCpXakzErgMMupsQPpUPsJcdmOV\/VpbEiPColdN4XmCIYLBnn7gROHb0pg==","reply":{"ticketId":"754acce4-e540-42cc-abde-de82d399af33","orderId":"754acce4-e540-42cc-abde-de82d399af33","totalAmount":"40,00","totalAmountWithInstallmentCharge":"40,00","numberOfInstallments":1,"hash":"06E4OGYOE6AYKHIV02L8JSJ0\/IHRPLAJQXIKJB\/QVQI="}}', true);
        $result = $bkmExpressObj->nonce($merchantPrivateKey, $preProdMode, $merchantId, $data, $orderTotal, $orderStatus);
    }

    public function refresh(){
        //get order total from opencart
        $this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $orderTotal = $this->currency->format($order_info['total'], 'TRY', false, false);
        $orderTotal = number_format($orderTotal, 2, ',', '');

        require_once(DIR_SYSTEM . 'library/bkmexpress/BKMExpress.php');
        $bkmExpressObj = new BKMExpress;
        $merchantPrivateKey = $this->config->get('bkmexpress_privatekey');
        $preProdMode = $this->config->get('bkmexpress_preprod');
        $merchantId = $this->config->get('bkmexpress_merchantid');
        $nonceURL = $this->url->link('extension/payment/bkmexpress/nonce');
        $installmentsURL = $this->url->link('extension/payment/bkmexpress/installments');
        $bkmExpressObj->refresh($merchantPrivateKey, $preProdMode, $merchantId, $nonceURL, $installmentsURL, $orderTotal);

    }

    public function result(){
        if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' )
        {
            $orderId = $_GET['orderId'];
            $this->load->model('checkout/order');
            $this->model_checkout_order->addOrderHistory($orderId, $this->config->get('bkmexpress_order_status_id'));
            return True;
        }
    }

    public function success(){
        $this->response->redirect($this->url->link('checkout/success'));
    }

    public function failure(){
        $this->response->redirect($this->url->link('checkout/failure'));
    }

}
