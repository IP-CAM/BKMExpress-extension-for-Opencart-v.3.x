<?php

class ModelSaleBkmexpress extends Model {
	
	public function deleteBkmexpress($bkmexpress_order_id){
		$this->db->query('delete from `'.DB_PREFIX.'bkmexpress_order` WHERE bkmexpress_order_id="'.$bkmexpress_order_id.'"');
	}

	public function getTotalBkmexpresss($data = array()){
		$sql = "SELECT count(po.bkmexpress_order_id) as total from `".DB_PREFIX."bkmexpress_order` po inner join `".DB_PREFIX."order` o on o.order_id = po.order_id";

		$implode = array();

		if (isset($data['filter_bkmexpress_order_id'])) {
			$implode[] = 'po.bkmexpress_order_id="' . $data['filter_bkmexpress_order_id'].'"';
		}

		if (isset($data['filter_order_id'])) {
			$implode[] = 'po.order_id="' . $data['filter_order_id'].'"';
		}

		if (isset($data['filter_transaction_id'])) {
			$implode[] = 'po.transaction_id="' . $data['filter_transaction_id'].'"';
		}

		if (isset($data['filter_status'])) {
			$implode[] = 'po.status="' . $data['filter_status'].'"';
		}

		if (isset($data['filter_client_ip'])) {
			$implode[] = 'po.client_ip="' . $data['filter_client_ip'].'"';
		}

		if (isset($data['filter_date_added'])) {
			$implode[] = 'DATE(po.date_added)="' . $data['filter_date_added'].'"';
		}
		
		if($implode){
			$sql .= ' WHERE '.implode(' AND ', $implode);
		}

		$result = $this->db->query($sql)->row;

		if($result) {
			return $result['total'];
		}
	}

	public function getBkmexpresss($data = array()){
		$sql = "SELECT po.*, o.total from `".DB_PREFIX."bkmexpress_order` po inner join `".DB_PREFIX."order` o on o.order_id = po.order_id";

		$implode = array();

		if (isset($data['filter_bkmexpress_order_id'])) {
			$implode[] = 'po.bkmexpress_order_id="' . $data['filter_bkmexpress_order_id'].'"';
		}

		if (isset($data['filter_order_id'])) {
			$implode[] = 'po.order_id="' . $data['filter_order_id'].'"';
		}

		if (isset($data['filter_transaction_id'])) {
			$implode[] = 'po.transaction_id="' . $data['filter_transaction_id'].'"';
		}

		if (isset($data['filter_status'])) {
			$implode[] = 'po.status="' . $data['filter_status'].'"';
		}

		if (isset($data['filter_client_ip'])) {
			$implode[] = 'po.client_ip="' . $data['filter_client_ip'].'"';
		}

		if (isset($data['filter_date_added'])) {
			$implode[] = 'DATE(po.date_added)="' . $data['filter_date_added'].'"';
		}
		
		if($implode){
			$sql .= ' WHERE '.implode(' AND ', $implode);
		}

		$sql .= " ORDER BY " . $data['sort'];
		$sql .= " ".$data['order'];

		return $this->db->query($sql)->rows;
	}
}
