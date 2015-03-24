<?php
namespace Phalcon_wifi\Common\Models;
class Members extends \Phalcon_wifi\Common\Models\CommonModels {
	public $error = "";
	
	public function getSource() {
		return "tx_members";
	}
	
	//检查用户名是否存在
	public function checkUsernameExist($username) {
		$user = self::findFirst("mname = '$username'");
		if (!$user) {
			return false;
		}
		return true;
	}
	
	//检查邮箱是否存在
	public function checkEmailExist($email) {
		$user = self::findFirst("email = '$email'");
		if (!$user) {
			return false;
		}
		return true;
	}
	
	//检查手机是否存在
	public function checkMobileExist($mobile) {
		$user = self::findFirst("mobile = '$mobile'");
		if (!$user) {
			return false;
		}
		return true;
	}
	
	//登入
	public function login($name, $pwd) {
		$pwd = md5($pwd);
		$where = "mname = '$name' AND mpwd = '$pwd' AND del = 'false' AND status = 'true'";
		$user = self::findFirst($where);
		if (!$user) {
			$this->error = "登录失败,请确认后重新登录";
			return false;
		}
		$request = new \Phalcon\Http\Request;
		$user->last_login_time = time();
		$user->last_login_ip = $request->getClientAddress();
		$user->login_counts = $user->login_counts + 1;
		
		if(!$user->save()) {
			$this->error = "登录失败,请确认后重新登录";
			return false;
		}
		$this->getDI()->get("session")->set("current_user", $user->mid);
		return true;
	}
	
	//登出
	public function logout() {
		$this->getDI()->get("session")->set("current_user", null);
		return true;
	}
	
	//检查登陆
	public function checkLogin() {
		$currentUserId = $this->getDI()->get("session")->get("current_user");
		return !$currentUserId ? 0 : $currentUserId;
	}
	
	//修改密码
	public function repassword($mid, $pwd, $newPwd) {
		$pwd = md5($pwd);
		$newPwd = md5($newPwd);
		$where = "mid = $mid AND mpwd = '$pwd' AND del = 'false' AND status = 'true'";
		$user = self::findFirst($where);
		if (!$user) {
			$this->error = "身份验证错误,修改密码失败";
			return false;
		}
		$user->mpwd = $newPwd;
		if(!$user->save()) {
			$this->error = "修改密码失败";
			return false;
		}
		return true;
	}
	
	//修改用户status
	public function changeUserStatus($mid) {
		$user = self::findFirst($mid);
		if (!$user) {
			$this->error = "不存在该用户";
			return false;
		}
		$user->status = $user->status == "true" ? "false" : "true";
		if(!$user->save()) {
			$this->error = "更改用户状态出错";
			return false;
		}
		return true;
	}
	
	//修改用户del
	public function changeUserDel($mid) {
		$user = self::findFirst($mid);
		if (!$user) {
			$this->error = "不存在该用户";
			return false;
		}
		$user->del = $user->del == "true" ? "false" : "true";
		if(!$user->save()) {
			$this->error = "更改用户状态出错";
			return false;
		}
		return true;
	}
	
	//修改用户基本资料
	public function updateUser($mid, $mchild, $email, $mobile) {
		$modules = $this->getDI()->get("config")->get("common")["modules"]->toArray();
		if (!in_array($mchild, $modules)) {
			$this->error = "用户类型不符合要求";
			return false;
		}
		$filter = $this->getDI()->get("filter");
		if (!$filter->checkEmail($email)) {
			$this->error = "邮箱不合法";
			return false;
		}
		if (!$filter->checkPhone($mobile)) {
			$this->error = "手机格式不合法";
			return false;
		}
		$user = self::findFirst($mid);
		if (!$user) {
			$this->error = "不存在该用户";
			return false;
		}
		if ($this->checkUsernameExist($mname)) {
			$this->error = "用户名已存在";
			return false;
		}
		$user->mchild = $mchild;
		$user->email = $email;
		$user->mobile = $mobile;
		if(!$user->save()) {
			$this->error = "修改用户资料出错";
			return false;
		}
		return true;
	}
	
	//添加用户
	public function addUser($mname, $mchild, $email, $mobile) {
		$modules = $this->getDI()->get("config")->get("common")["modules"]->toArray();
		if (!in_array($mchild, $modules)) {
			$this->error = "用户类型不符合要求";
			return false;
		}
		$filter = $this->getDI()->get("filter");
		if (!$filter->checkEmail($email)) {
			$this->error = "邮箱不合法";
			return false;
		}
		if (!$filter->checkPhone($mobile)) {
			$this->error = "手机格式不合法";
			return false;
		}
		if (!$filter->checkUsername($mname)) {
			$this->error = "用户名不合法";
			return false;
		}
		if ($this->checkUsernameExist($mname)) {
			$this->error = "用户名已存在";
			return false;
		}
		if ($this->checkEmailExist($email)) {
			$this->error = "邮箱已存在";
			return false;
		}
		if ($this->checkMobileExist($mobile)) {
			$this->error = "手机号码已存在";
			return false;
		}
		$user = new self();
		$user->mname = $mname;
		$user->email = $email;
		$user->mchild = $mchild;
		$user->mobile = $mobile;
		if (!$user->save()) {
			$this->error = "添加用户出错";
			return false;
		}
		return true;
	}
	
	//多用户删除
	public function mulUserDel($mids) {
		$mids = trim($mids, ",");
		$users = self::find("mid in ($mids)");
		foreach ($users as $user) {
			$user->del = "true";
			if(!$user->save()) {
				$this->error = "更改用户状态出错";
				return false;
			}
		}
		return true;
	}
}