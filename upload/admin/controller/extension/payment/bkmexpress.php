<?php
class ControllerExtensionPaymentBkmexpress extends Controller {
	private $error = array();

	public function index() {

        $this->load->language('extension/payment/bkmexpress');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('bkmexpress', $this->request->post);
			//for opencart 3
			$this->model_setting_setting->editSetting('payment_bkmexpress', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));
		}
        $data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');

		$data['entry_yes'] = $this->language->get('entry_yes');
		$data['entry_no'] = $this->language->get('entry_no');

		$data['entry_endpoint'] = $this->language->get('entry_endpoint');
		$data['entry_username'] = $this->language->get('entry_username');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['help_total'] = $this->language->get('help_total');
        $data['entry_total'] = $this->language->get('help_total');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_payment'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/payment/bkmexpress', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/payment/bkmexpress', 'user_token=' . $this->session->data['user_token'], true);
        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true);

		if (isset($this->request->post['bkmexpress_endpoint'])) {
			$data['bkmexpress_endpoint'] = $this->request->post['bkmexpress_endpoint'];
		} else {
			$data['bkmexpress_endpoint'] = $this->config->get('bkmexpress_endpoint');
		}

		if (isset($this->request->post['bkmexpress_username'])) {
			$data['bkmexpress_username'] = $this->request->post['bkmexpress_username'];
		} else {
			$data['bkmexpress_username'] = $this->config->get('bkmexpress_username');
		}

		if (isset($this->request->post['bkmexpress_password'])) {
			$data['bkmexpress_password'] = $this->request->post['bkmexpress_password'];
		} else {
			$data['bkmexpress_password'] = $this->config->get('bkmexpress_password');
		}

		if (isset($this->request->post['bkmexpress_total'])) {
			$data['bkmexpress_total'] = $this->request->post['bkmexpress_total'];
		} else {
			$data['bkmexpress_total'] = $this->config->get('bkmexpress_total');
		}

		if (isset($this->request->post['bkmexpress_order_status_id'])) {
			$data['bkmexpress_order_status_id'] = $this->request->post['bkmexpress_order_status_id'];
		} else {
			$data['bkmexpress_order_status_id'] = $this->config->get('bkmexpress_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['bkmexpress_geo_zone_id'])) {
			$data['bkmexpress_geo_zone_id'] = $this->request->post['bkmexpress_geo_zone_id'];
		} else {
			$data['bkmexpress_geo_zone_id'] = $this->config->get('bkmexpress_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();


		if (isset($this->request->post['bkmexpress_sort_order'])) {
			$data['bkmexpress_sort_order'] = $this->request->post['bkmexpress_sort_order'];
		} else {
			$data['bkmexpress_sort_order'] = $this->config->get('bkmexpress_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/bkmexpress', $data));
	}

	public function install() {
		$this->load->model('extension/payment/bkmexpress');
		$this->model_extension_payment_bkmexpress->install();
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/payment/bkmexpress')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
        return !$this->error;
	}
}