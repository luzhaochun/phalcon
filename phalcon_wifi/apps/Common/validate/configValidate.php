<?php
namespace Phalcon_wifi\Common\Validate;
class ConfigValidate extends \Phalcon\Validation{
	public function initialize(){
		$this->add('variable_name', new \Phalcon\Validation\Validator\PresenceOf(array(
			'message' => '配置标识不为空'
		)));
		
		$this->add('variable_title', new \Phalcon\Validation\Validator\PresenceOf(array(
			'message' => '配置标题不为空'
		)));
		
		$this->add('sort',new \Phalcon\Validation\Validator\Regex(array(
			'pattern'=>'/^[0-9]\d*$|0$/',
			'message'=>'排序请输入正整数'
		)));
	}
}