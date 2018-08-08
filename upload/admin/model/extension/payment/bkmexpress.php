<?php

class ModelExtensionPaymentBkmexpress extends Model {

	public function install() {
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "bkmexpress_order` (
			  `bkmexpress_order_id` int(11) NOT NULL AUTO_INCREMENT,
			  `order_id` int(11) NOT NULL,
			  `transaction_id` varchar(255) NOT NULL,
			  `status` tinyint(1) NOT NULL,
			  `client_ip` varchar(50) NOT NULL,
			  `ErrorMSG` text NOT NULL,
			  `ErrorCode` varchar(255) NOT NULL,
			  `conversion_rate` DECIMAL( 10, 2 ) NOT NULL,
			  `try_total` DECIMAL( 10, 2 ) NOT NULL,
			  `original` text NOT NULL,
			  `date_added` DATETIME NOT NULL,
			  PRIMARY KEY (`bkmexpress_order_id`)
			) ENGINE=MyISAM DEFAULT COLLATE=utf8_general_ci;");
	}
}
