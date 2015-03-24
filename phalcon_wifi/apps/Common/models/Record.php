<?php
namespace Phalcon_wifi\Common\Models;
class Record extends \Phalcon_wifi\Common\Models\CommonModels {
	public $error = "";
	
	public function getSource() {
		return "tx_record";
	}
}