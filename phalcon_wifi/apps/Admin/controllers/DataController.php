<?php
namespace Phalcon_wifi\Admin\Controllers;

class DataController extends ControllerBase {
	//数据备份首页
	public function indexAction() {
		$this->view->disableLevel(\Phalcon\MVC\View::LEVEL_MAIN_LAYOUT);
		$files = $this->dbBackupTool->getRecoveryFiles();
		$this->view->setVar("files", $files);
	}
}