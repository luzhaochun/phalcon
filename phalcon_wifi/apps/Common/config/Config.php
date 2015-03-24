<?php 
namespace Phalcon_wifi\Common\Config;

class Config {
	public $config;
	
	public function __construct() {
		//module对应整型数值
		$configs["common"]["modules"] = array("Admin" => 1, "Brand" => 2, "Agent" => 3, "Merchant" => 4);
		
		//缓存文件夹
		$configs["common"]["application"] =  array('cacheDir' => __DIR__ . '/../cache/');
		
		//不需要进行登陆验证的url()
		$configs["common"]["not_check_uri"] =  array("Admin/Members/login", "Admin/Index/getValidateCode", "Admin/Index/test", "Admin/Members/confirmLogin");

		//常用的静态数据
		$configs["common"]["config_setting"] = [
			"group" => [
				1=>"图片配置",
				2=>"路由器配置",
				3=>"短信网关配置",
				4=>"邮件配置",
				5=>"系统配置"
			],
			"type" => [
				1=>"字符",
				2=>"文本",
				3=>"数组",
				4=>"枚举",
				5=>"密码",
				6=>"长文本",
				7=>"加长文本",
				8=>"数字"
			]
		];
		
		//系统版本
		$configs["common"]["version"] =  "0.0.1";
		
		//数据库配置
		$configs["common"]["db"] =  [
			"host" => "192.168.1.77",
			"username" => "tx",
			"password" => "tongxiang",
			"dbname" => "phalcon_wifizn",
			"charset" => "utf8"
		];
		
		//数据库备份文件名
		$configs["common"]["dblog"] = "/../apps/Common/logs/db_" . date("Y_m_d_H") . ".log";
		
		//app baseuri
		$configs["common"]["baseuri"] = "/project_wifi/phalcon_wifi/";
		
		$this->config = new \Phalcon\Config($configs);
	}
}