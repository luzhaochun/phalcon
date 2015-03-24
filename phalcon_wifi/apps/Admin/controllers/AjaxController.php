<?php

namespace Phalcon_wifi\Admin\Controllers;

class AjaxController extends AjaxCommon {
	
	//备份当前数据库
	public function dataBackupAction() {
		$result = $this->dbBackupTool->backup();
		if ($result) {
			$this->success();return false;
		}
		$this->error($this->dbBackupTool->error);return false;
	}
	
	//还原指定文件里的数据
	public function dataRecoveryAction() {
		$fileName = $this->getParam("fileName");
		if(!$fileName) {
			$this->error("文件不存在");return false;
		}
		$result = $this->dbBackupTool->recovery($fileName);
		if ($result) {
			$this->success("数据库已还原");return false;
		}
		$this->error();return false;
	}
	
	//删除备份数据文件
	public function dataDeleteAction() {
		$fileName = $this->getParam("fileName");
		if(!$fileName) {
			$this->error("文件不存在");return false;
		}
		$result = $this->dbBackupTool->unlinkFile($fileName);
		if ($result) {
			$this->success();return false;
		}
		$this->error($this->dbBackupTool->error);return false;
	}
	
	//修改用户status
	public function changeUserStatusAction() {
		$mid = $this->getParam("mid");
		$members = new \Phalcon_wifi\Common\Models\Members();
		$result = $members->changeUserStatus($mid);
		if ($result) {
			$this->success();return false;
		}
		$this->error($members->error);return false;
	}
	
	//修改用户status
	public function changeUserDelAction() {
		$mid = $this->getParam("mid");
		$members = new \Phalcon_wifi\Common\Models\Members();
		$result = $members->changeUserDel($mid);
		if ($result) {
			$this->success();return false;
		}
		$this->error($members->error);return false;
	}
	
	//多用户删除
	public function mulUserDelAction() {
		$mids = $this->getParam("mids");
		$members = new \Phalcon_wifi\Common\Models\Members();
		if($members->mulUserDel($mids)) {
			$this->success();return false;
		}
		$this->error($members->error);return false;
	}
	
	//修改用户基本资料
	public function updateUserAction() {
		$mid = $this->getParam("mid", "");
		$mobile = $this->getParam("mobile", "");
		$mchild = $this->getParam("mchild", "");
		$email = $this->getParam("email", "");
		if (!$mid || !$mobile || !$mchild || !$email) {
			$this->error("缺少参数");return false;
		}
		$members = new \Phalcon_wifi\Common\Models\Members();
		$result = $members->updateUser($mid, $mchild, $email, $mobile);
		if ($result) {
			$this->success();return false;
		}
		$this->error($members->error);return false;
	}
	
	//添加用户
	public function addUserAction() {
		$mname = $this->getParam("mname", "");
		$mobile = $this->getParam("mobile", "");
		$mchild = $this->getParam("mchild", "");
		$email = $this->getParam("email", "");
		if (!$mname || !$mobile || !$mchild || !$email) {
			$this->error("缺少参数");return false;
		}
		$members = new \Phalcon_wifi\Common\Models\Members();
		$result = $members->addUser($mname, $mchild, $email, $mobile);
		if ($result) {
			$this->success();return false;
		}
		$this->error($members->error);return false;
	}
}
