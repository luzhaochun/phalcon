<?php
namespace Phalcon_wifi\Common\Models;
class Config extends \Phalcon_wifi\Common\Models\CommonModels {
	//1图片上传配置，2路由器配置，3短信网关配置，4邮件配置，5系统配置
	public static $CONFIG_GROUP_UPLOAD = 1;
	public static $CONFIG_GROUP_ROUTE = 2;
	public static $CONFIG_GROUP_MESSAGE = 3;
	public static $CONFIG_GROUP_EMAIL = 4;
	public static $CONFIG_GROUP_SYSTEM = 5;
	
	//1字符,2文本,3数组,4枚举,5密码,6长文本,7加长文本,8数字
	public static $CONFIG_TYPE_CHAR = 1;
	public static $CONFIG_TYPE_TEXT = 2;
	public static $CONFIG_TYPE_ARRAY = 3;
	public static $CONFIG_TYPE_ENUM = 4;
	public static $CONFIG_TYPE_PASSWORD = 5;
	public static $CONFIG_TYPE_LONGTEXT = 6;
	public static $CONFIG_TYPE_LONGLONGTEXT = 7;
	public static $CONFIG_TYPE_INT = 8;
	
	public function getSource() {
		return "tx_config";
	}
	
	//读配置
	public function getValue($name, $group) {
		$config = $this->db->fetchOne("SELECT * FROM tx_config WHERE variable_name = '$name' AND `group` = $group");
		return !$config || empty($config) ? "" : $config["variable_value"];
	}
	
	//写配置
	public function addConfig($name, $value, $title, $extra, $group, $sort, $remark, $type) {
		$item = new self();
		$item->variable_name = $name;
		$item->variable_value = $value;
		$item->variable_title = $title;
		$item->extra = $extra;
		$item->group = $group;
		$item->sort = $sort;
		$item->remark = $remark;
		$item->type = $type;
		$item->status = 0;
		
		if($item->create() == false) {
			$this->error = "添加配置项出错";
			return false;
		}
		return true;
	}
	
	//获取一组配置
	public function getConfigsByGroupId($groupId) {
		return $this->db->fetchAll("SELECT * FROM tx_config WHERE group = $groupId ORDER BY sort");
	}
}