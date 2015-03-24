<?php
namespace Phalcon_wifi\Admin\Controllers;

class AjaxCommon extends ControllerBase {
	//ajax初始化
	public function initialize() {
		parent::initialize();
		$this->record();
		$this->view->setRenderLevel(\Phalcon\MVC\View::LEVEL_NO_RENDER);
	}
	//操作成功
	public function success($msg = "操作成功", $data = array()) {
		echo json_encode(["status" => "true", "msg" => $msg, "data" => $data]);
	}
	//操作失败
	public function error($msg = "操作失败", $data = array()) {
		echo json_encode(["status" => "false", "msg" => $msg, "data" => $data]);
	}
}
?>