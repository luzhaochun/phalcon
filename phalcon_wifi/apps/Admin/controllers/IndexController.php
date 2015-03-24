<?php

namespace Phalcon_wifi\Admin\Controllers;

class IndexController extends ControllerBase {
	public function indexAction() {
	}
	
	public function dataAction() {
		$this->view->disableLevel(\Phalcon\MVC\View::LEVEL_MAIN_LAYOUT);
	}
	
	public function getValidateCodeAction() {
		$isAjax = $this->request->get('isAjax');
		if(empty($isAjax)){
			echo $this->validateCodeCreator->getCode(4,60,20);
			$this->view->setRenderLevel(\Phalcon\MVC\View::LEVEL_NO_RENDER);
		} else {
			//do nothing here
		}
	}
	
	public function TestAction($isAjax = false) {
		//echo $this->validateCodeCreator->session->get('validateCode');
		//echo $this->getParam("page");
		$this->view->setRenderLevel(\Phalcon\MVC\View::LEVEL_NO_RENDER);
	}
}
