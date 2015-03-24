<?php
namespace Phalcon_wifi\Common\Models;
class AuthRule extends \Phalcon_wifi\Common\Models\CommonModels {
	public $error = "";
	
	public function getSource() {
		return "tx_auth_rule";
	}
}