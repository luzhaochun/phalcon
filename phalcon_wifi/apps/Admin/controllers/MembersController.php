<?php
namespace Phalcon_wifi\Admin\Controllers;

class MembersController extends ControllerBase {
	public function loginAction(){
		$this->view->setVar("title", '登录');
	}
	
	public function logoutAction() {
		$member = new \Phalcon_wifi\Common\Models\Members();
		$member->logout();
		$this->redirect(
			$this->createLocalUrl(
				array('for'=>'common', 'controller'=>'Members', 'action'=>'login')));
		return false;
	}
	
	public function confirmLoginAction() {
		if($this->request->isPost()){
			$vcode = $this->request->getPost('code');
			if(empty($vcode) || $vcode != $this->session->get('validateCode')){
				$this->redirect($this->createLocalUrl(
						array('for'=>'common', 'controller'=>'Members', 'action'=>'login','params'=>'验证码错误，请重新确认！')));
				return;
			}
			$mname = $this->request->getPost('mname');
			$mpwd = $this->request->getPost('mpwd');
			if(!empty($mname) && !empty($mpwd)){
				$memberModel = new \Phalcon_wifi\Common\Models\Members();
				if($memberModel->login($mname, $mpwd)) {
					$this->redirect($this->createLocalUrl(
						array('for'=>'common', 'controller'=>'Index', 'action'=>'index')));
					return;
				} else {
					$this->redirect($this->createLocalUrl(
						array('for'=>'common', 'controller'=>'Members', 'action'=>'login','params'=>$memberModel->error)));
					return;
				}
			}
		}
	}
	
	public function indexAction() {
		$this->view->disableLevel(\Phalcon\MVC\View::LEVEL_MAIN_LAYOUT);
		$this->view->setVar("title", '用户管理');
		$currentPage = $this->getParam("currentPage", 1);
		$perPage = $this->getParam("perPage", 10);
		$mchild = $this->request->get("mchild");
		$keyword = $this->request->get("keyword");
		$where = "1";
		if ($mchild) {
			$where .= " AND mchild = $mchild ";
		}
		if ($keyword) {
			$where .= " AND mname LIKE '%$keyword%' ";
		}
		$memberModel = new \Phalcon_wifi\Common\Models\Members();
		$members = $memberModel->baseList($currentPage, "mid DESC", $where, $perPage);
		$members["pager"]->getParams["mchild"] = $mchild;
		$members["pager"]->getParams["keyword"] = $keyword;
		$members["pager"]->uri = $this->createLocalUrl(
			array('for'=>'common', 'controller'=>'Members', 'action'=>'index'));
		$this->view->setVar("members", $members);
		$this->view->setVar("pager", $members["pager"]);
	}
	
	//显示修改页面
	public function updateAction() {
		$this->view->disableLevel(\Phalcon\MVC\View::LEVEL_MAIN_LAYOUT);
		$this->view->setVar("title", '用户管理');
		$mid = $this->getParam("mid", "");
		if (!$mid) {
			$this->pageError("页面错误");return false;
		}
		$member = \Phalcon_wifi\Common\Models\Members::findFirst($mid)->toArray();
		if (!$member) {
			$this->pageError("页面错误");return false;
		}
		$mchilds = $this->config["common"]["mchilds"];
		$this->view->setVar("mchilds", $mchilds);
		$this->view->setVar("member", $member);
	}
	
	public function addAction() {
		$this->view->disableLevel(\Phalcon\MVC\View::LEVEL_MAIN_LAYOUT);
		$this->view->setVar("title", '用户管理');
		$mchilds = $this->config["common"]["mchilds"];
		$this->view->setVar("mchilds", $mchilds);
	}
}