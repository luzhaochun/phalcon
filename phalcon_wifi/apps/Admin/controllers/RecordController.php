<?php
namespace Phalcon_wifi\Admin\Controllers;

class RecordController extends ControllerBase {
	public function indexAction () {
		$this->view->disableLevel(\Phalcon\MVC\View::LEVEL_MAIN_LAYOUT);
		$this->view->setVar("title", '用户管理');
		$currentPage = $this->getParam("currentPage", 1);
		$perPage = $this->getParam("perPage", 10);
		$recordModel = new \Phalcon_wifi\Common\Models\Record();
		$records = $recordModel->baseList($currentPage, "id DESC");
		$records["pager"]->uri = $this->createLocalUrl(
				array('for'=>'common', 'controller'=>'Record', 'action'=>'index'));
		$this->view->setVar("records", $records);
		$this->view->setVar("pager", $records["pager"]);
	}
}