<?php
namespace Phalcon_wifi\Common\Controllers;

class CommonController extends \Phalcon\Mvc\Controller {
	
	public $moduleName;
	public $controllerName;
	public $actionName;
	public $params = array();
	
	//公共父类初始化
	public function initialize() {
		$this->view->setVar("title", '后台首页');
		$this->paraseParams();
	}
	
	public function beforeExecuteRoute($dispatcher) {
		$members = new \Phalcon_wifi\Common\Models\Members;
		$this->moduleName = $dispatcher->getModuleName();
		$this->controllerName = $dispatcher->getControllerName();
		$this->actionName = $dispatcher->getActionName();
		$currentRouter = $this->moduleName . '/' . $this->controllerName . '/' . $this->actionName;
		
		if (!$this->ifNotCheckUri($currentRouter)) {
			if(!$members->checkLogin()) {
				$this->redirect($this->createLocalUrl(array('for'=>'common', 'controller'=>'Members', 'action'=>'login')));
				return false;
			}
		}
	}
	
	//检查是否为 不需要检查登陆的路径
	public function ifNotCheckUri($routerUri) {
		$notCheckUris = $this->config->get("common")["not_check_uri"];
		for ($i = 0; $i < count($notCheckUris); $i++)
			if ($notCheckUris[$i] == $routerUri) return true;
		return false;
	}
	
	//利用框架url,产生本地完整url
	public function createLocalUrl($arr) {
		return "http://" . $_SERVER["HTTP_HOST"] . $this->url->get($arr);
	}
	
	//包装框架重定向
	public function redirect($url) {
		$this->response->redirect($url);
	}
	
	//$this->forward('ControllerName/action');
	protected function forward($uri){
		$uriParts = explode('/', $uri);
		$params = array_slice($uriParts, 2);
		return $this->dispatcher->forward(
			array(
				'controller' => $uriParts[0],
				'action' => $uriParts[1],
				'params' => $params
			)
		);
	}
	
	//解析parameter:本app的params规则:key1/val1/key2/val2/key3/val3/.......
	public function paraseParams() {
		$params = $this->dispatcher->getParams();
		if (empty($params)) {
			return;
		}
		if (count($params) % 2 != 0) {
			array_push($params, "");
		}
		for ($i = 0; $i < count($params); $i = $i + 2) {
			$this->params[$params[$i]] = $params[$i+1];
		}
	}
	
	//获取parameter
	public function getParam($key, $default = "") {
		if (!isset($this->params[$key]) || !$this->params[$key]) {
			return $default;
		}
		return $this->params[$key];
	}
	
	//显示页面出错
	public function pageError($msg, $url = "", $seconds = 3) {
		$this->view->setRenderLevel(\Phalcon\MVC\View::LEVEL_NO_RENDER);
		echo $msg;
		return false;
	}
}