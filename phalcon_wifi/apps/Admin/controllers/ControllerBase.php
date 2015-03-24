<?php

namespace Phalcon_wifi\Admin\Controllers;

class ControllerBase extends \Phalcon_wifi\Common\Controllers\CommonController {
	//操作日志记录
	public function record() {
		$operation = $this->controllerName . "/" . $this->actionName;
		$request = new \Phalcon\Http\Request;
		$ip = $request->getClientAddress();
		
		$members = new \Phalcon_wifi\Common\Models\Members();
		$mid = $members->checkLogin();
		$record = new \Phalcon_wifi\Common\Models\Record();
		$record->operation = $operation;
		$record->loginip = $ip;
		$record->mid = $mid;
		$record->log_time = date("Y-m-d H:i:s");
		$record->save();
	}
}
