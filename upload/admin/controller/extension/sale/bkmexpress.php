<?php
class ControllerExtensionSaleBkmexpress extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/sale/bkmexpress');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('extension/sale/bkmexpress');
        $this->getList();
    }

    public function delete() {
        $this->load->language('extension/sale/bkmexpress');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('extension/sale/bkmexpress');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $bkmexpress_order_id) {
                $this->model_sale_bkmexpress->deleteBkmexpress($bkmexpress_order_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_bkmexpress_order_id'])) {
                $url .= '&filter_bkmexpress_order_id=' . $this->request->get['filter_bkmexpress_order_id'];
            }

            if (isset($this->request->get['filter_order_id'])) {
                $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
            }

            if (isset($this->request->get['filter_transaction_id'])) {
                $url .= '&filter_transaction_id=' . $this->request->get['filter_transaction_id'];
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }

            if (isset($this->request->get['filter_client_ip'])) {
                $url .= '&filter_client_ip=' . $this->request->get['filter_client_ip'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('extension/sale/bkmexpress', 'user_token=' . $this->session->data['user_token'] . $url, 'SSL'));
        }

        $this->getList();
    }

    protected function getList() {

        if (isset($this->request->get['filter_bkmexpress_order_id'])) {
            $filter_bkmexpress_order_id = $this->request->get['filter_bkmexpress_order_id'];
        } else {
            $filter_bkmexpress_order_id = null;
        }

        if (isset($this->request->get['filter_order_id'])) {
            $filter_order_id = $this->request->get['filter_order_id'];
        } else {
            $filter_order_id = null;
        }

        if (isset($this->request->get['filter_transaction_id'])) {
            $filter_transaction_id = $this->request->get['filter_transaction_id'];
        } else {
            $filter_transaction_id = null;
        }

        if (isset($this->request->get['filter_status'])) {
            $filter_status = $this->request->get['filter_status'];
        } else {
            $filter_status = null;
        }

        if (isset($this->request->get['filter_client_ip'])) {
            $filter_client_ip = $this->request->get['filter_client_ip'];
        } else {
            $filter_client_ip = null;
        }

        if (isset($this->request->get['filter_date_added'])) {
            $filter_date_added = $this->request->get['filter_date_added'];
        } else {
            $filter_date_added = null;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'po.order_id';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['filter_bkmexpress_order_id'])) {
            $url .= '&filter_bkmexpress_order_id=' . $this->request->get['filter_bkmexpress_order_id'];
        }

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['filter_transaction_id'])) {
            $url .= '&filter_transaction_id=' . $this->request->get['filter_transaction_id'];
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }

        if (isset($this->request->get['filter_client_ip'])) {
            $url .= '&filter_client_ip=' . $this->request->get['filter_client_ip'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/sale/bkmexpress', 'user_token=' . $this->session->data['user_token'] . $url, 'SSL')
        );

        $data['delete'] = $this->url->link('extension/sale/bkmexpress/delete', 'user_token=' . $this->session->data['user_token'] . $url, 'SSL');

        $data['transactions'] = array();

        $filter_data = array(
            'filter_bkmexpress_order_id'        => $filter_bkmexpress_order_id,
            'filter_order_id'         		=> $filter_order_id,
            'filter_transaction_id'         => $filter_transaction_id,
            'filter_status'         		=> $filter_status,
            'filter_client_ip'            	=> $filter_client_ip,
            'filter_date_added'       		=> $filter_date_added,
            'sort'                    		=> $sort,
            'order'                   		=> $order,
            'start'                   		=> ($page - 1) * $this->config->get('config_limit_admin'),
            'limit'                   		=> $this->config->get('config_limit_admin')
        );

        $bkmexpress_total = $this->model_sale_bkmexpress->getTotalBkmexpresss($filter_data);

        $results = $this->model_sale_bkmexpress->getBkmexpresss($filter_data);

        foreach ($results as $result) {
            $data['transactions'][] = array(
                'bkmexpress_order_id'   	=> $result['bkmexpress_order_id'],
                'order_id'      	 	=> $result['order_id'],
                'transaction_id' 	 	=> $result['transaction_id'],
                'total' 			 	=> $result['total'],
                'try_total' 		 	=> $result['try_total'],
                'conversion_rate' 	 	=> $result['conversion_rate'],
                'client_ip'       	 	=> $result['client_ip'],
                'status'            	=> $result['status']?$this->language->get('text_complete'):$this->language->get('text_failed'),
                'date_added'    		=> date($this->language->get('date_format_short'), strtotime($result['date_added']))
            );
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_yes'] = $this->language->get('text_yes');
        $data['text_no'] = $this->language->get('text_no');
        $data['text_complete'] = $this->language->get('text_complete');
        $data['text_failed'] = $this->language->get('text_failed');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');

        $data['column_bkmexpress_order_id'] = $this->language->get('column_bkmexpress_order_id');
        $data['column_order_id'] = $this->language->get('column_order_id');
        $data['column_transaction_id'] = $this->language->get('column_transaction_id');
        $data['column_total'] = $this->language->get('column_total');
        $data['column_try_total'] = $this->language->get('column_try_total');
        $data['column_conversion_rate'] = $this->language->get('column_conversion_rate');
        $data['column_client_ip'] = $this->language->get('column_client_ip');
        $data['column_status'] = $this->language->get('column_status');
        $data['column_date_added'] = $this->language->get('column_date_added');
        $data['column_action'] = $this->language->get('column_action');

        $data['entry_bkmexpress_order_id'] = $this->language->get('entry_bkmexpress_order_id');
        $data['entry_transaction_id'] = $this->language->get('entry_transaction_id');
        $data['entry_bank_id'] = $this->language->get('entry_bank_id');
        $data['entry_client_ip'] = $this->language->get('entry_client_ip');
        $data['entry_order_id'] = $this->language->get('entry_order_id');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_date_added'] = $this->language->get('entry_date_added');

        $data['button_delete'] = $this->language->get('button_delete');
        $data['button_filter'] = $this->language->get('button_filter');

        $data['user_token'] = $this->session->data['user_token'];

        if (isset($this->session->data['error'])) {
            $data['error_warning'] = $this->session->data['error'];

            unset($this->session->data['error']);
        } elseif (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $url = '';


        if (isset($this->request->get['filter_bkmexpress_order_id'])) {
            $url .= '&filter_bkmexpress_order_id=' . $this->request->get['filter_bkmexpress_order_id'];
        }

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['filter_transaction_id'])) {
            $url .= '&filter_transaction_id=' . $this->request->get['filter_transaction_id'];
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }

        if (isset($this->request->get['filter_client_ip'])) {
            $url .= '&filter_client_ip=' . $this->request->get['filter_client_ip'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['sort_bkmexpress_order_id'] = $this->url->link('extension/sale/bkmexpress', 'user_token=' . $this->session->data['user_token'] . '&sort=po.bkmexpress_order_id' . $url, 'SSL');

        $data['sort_order_id'] = $this->url->link('extension/sale/bkmexpress', 'user_token=' . $this->session->data['user_token'] . '&sort=po.order_id' . $url, 'SSL');

        $data['sort_transaction_id'] = $this->url->link('extension/sale/bkmexpress', 'user_token=' . $this->session->data['user_token'] . '&sort=po.transaction_id' . $url, 'SSL');

        $data['sort_total'] = $this->url->link('extension/sale/bkmexpress', 'user_token=' . $this->session->data['user_token'] . '&sort=o.total' . $url, 'SSL');

        $data['sort_try_total'] = $this->url->link('extension/sale/bkmexpress', 'user_token=' . $this->session->data['user_token'] . '&sort=po.try_total' . $url, 'SSL');

        $data['sort_conversion_rate'] = $this->url->link('extension/sale/bkmexpress', 'user_token=' . $this->session->data['user_token'] . '&sort=po.conversion_rate' . $url, 'SSL');

        $data['sort_date_added'] = $this->url->link('extension/sale/bkmexpress', 'user_token=' . $this->session->data['user_token'] . '&sort=po.date_added' . $url, 'SSL');

        $data['sort_status'] = $this->url->link('extension/sale/bkmexpress', 'user_token=' . $this->session->data['user_token'] . '&sort=po.status' . $url, 'SSL');

        $data['sort_client_ip'] = $this->url->link('extension/sale/bkmexpress', 'user_token=' . $this->session->data['user_token'] . '&sort=po.client_ip' . $url, 'SSL');

        $url = '';


        if (isset($this->request->get['filter_bkmexpress_order_id'])) {
            $url .= '&filter_bkmexpress_order_id=' . $this->request->get['filter_bkmexpress_order_id'];
        }

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['filter_transaction_id'])) {
            $url .= '&filter_transaction_id=' . $this->request->get['filter_transaction_id'];
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }

        if (isset($this->request->get['filter_client_ip'])) {
            $url .= '&filter_client_ip=' . $this->request->get['filter_client_ip'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $bkmexpress_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('extension/sale/bkmexpress', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($bkmexpress_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($bkmexpress_total - $this->config->get('config_limit_admin'))) ? $bkmexpress_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $bkmexpress_total, ceil($bkmexpress_total / $this->config->get('config_limit_admin')));

        $data['filter_bkmexpress_order_id']    = $filter_bkmexpress_order_id;
        $data['filter_order_id']            = $filter_order_id;
        $data['filter_transaction_id']      = $filter_transaction_id;
        $data['filter_status']              = $filter_status;
        $data['filter_client_ip']           = $filter_client_ip;
        $data['filter_date_added']          = $filter_date_added;

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/sale/bkmexpress_list', $data));
    }

    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'extension/sale/bkmexpress')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}