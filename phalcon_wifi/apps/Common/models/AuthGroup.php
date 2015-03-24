<?php
namespace Phalcon_wifi\Common\Models;
/**
 * 
 * @author qiaoyongchen
 * 所有有关权限的方法几种写在这里
 */
class AuthGroup extends \Phalcon_wifi\Common\Models\CommonModels {
	public $error = "";
	
	public function getSource() {
		return "tx_auth_group";
	}
	
	//通过用户id获取用户权限列表
	public function getRulesByMid($mid) {
		$authGroupItems = \Phalcon_wifi\Common\Models\AuthGroupAccess::find("mid = $mid");
		foreach ($authGroupItems as $item) {
			$authGroupArr[] = $item->group_id;
		}
		$groupIds = implode(",", $authGroupArr);
		$authGroups = $this->db->fetchAll("SELECT * FROM tx_auth_group WHERE id IN ($groupIds)");
		if (empty($authGroups)) {
			return array();
		}
		foreach ($authGroups as $authGroup) {
			$tmpRules = explode(",", $authGroup["rules"]);
			if (!empty($tmpRules)) {
				foreach ($tmpRules as $tmpRule) {
					$rules[] = $tmpRule;
				}
			}
		}
		$rules = implode(",", array_unique(array_filter($rules)));
		$rules = $this->db->fetchAll("SELECT * FROM tx_auth_rule WHERE id IN ($rules)");
		return $rules;
	}
	
	//检查用户权限
	public function checkUserRule($mid, $ruleName) {
		$rules = $this->getRulesByMid($mid);
		if (empty($rules)) {
			return false;
		}
		
		foreach ($rules as $tmpRule) if ($tmpRule["name"] == $ruleName) return true;
		
		return false;
	}
	
	//添加权限组
	public function addAuthGroup($title, $remark) {
		$status = $this->db->execute(
			"INSERT INTO tx_auth_group VALUES (NULL, '$title', '', 'false', 'true', '$remark')");
		if(!$status) {
			$this->error = "添加权限组失败";
			return false;
		}
		return true;
	}
	
	//权限组添加用户
	public function addMemberToAuthGroup($authGroupId, $mid) {
		$status = $this->db->execute(
			"INSERT INTO tx_auth_group_access VALUES ($mid, $authGroupId)");
		if(!$status) {
			$this->error = "权限组添加用户失败";
			return false;
		}
		return true;
	}
	
	//权限组添加权限
	public function addRuleToAuthGroup($authGroupId, $ruleId) {
		$authGroup = self::findFirst($authGroupId);
		$ruleIds = explode(",", $authGroup->rules);
		$ruleIds[] = $ruleId;
		$ruleIds = implode(",", array_unique($ruleIds));
		$authGroup->rules = $ruleIds;
		if(false === $authGroup->save()) {
			$this->error = "权限组添加权限失败";
			return false;
		}
		return true;
	}
}