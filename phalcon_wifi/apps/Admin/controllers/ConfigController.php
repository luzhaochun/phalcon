<?php
namespace Phalcon_wifi\Admin\Controllers;
class ConfigController extends ControllerBase{
	public function indexAction(){		
		$where = [];
		$condition=[];
		if(!empty($this->request->get('con_group'))){
			$where[] = "`group` = ".$this->request->get('con_group');
			$condition['con_group'] = $this->request->get('con_group');
		}
		if(!empty($this->request->get('con_type'))){
			$where[] = "`type` = ".$this->request->get('con_type');
			$condition['con_type'] = $this->request->get('con_type');
		}
		if(!empty($this->request->get('con_value'))){
			$where[] = " (`variable_name` like '%" . $this->request->get('con_value') . "%' or `variable_title` like '%" . $this->request->get('con_value')."%') ";
		    $condition['con_value'] = $this->request->get('con_value');
		}
		if(sizeof($where)>0){
			$where = implode($where, " AND ");
		}
		$configModel = new \Phalcon_wifi\Common\Models\Config();
		$currentPage = $this->getParam("currentPage", 1);
		$perPage = $this->getParam("perPage", 10);
		if(!empty($where)){
			$configList = $configModel->baseList($currentPage, 'id desc', $where, $perPage);
		}else{
			$configList = $configModel->baseList($currentPage, 'id desc', true, $perPage);
		}
		$configList['pager']->uri = $this->createLocalUrl(
			array('for'=>'common', 'controller'=>'Config', 'action'=>'index'));
		
		if(sizeof($condition)>0){
			$configList['pager']->getParams = $condition;
		}

		$configSetting = $this->config->get('common')['config_setting'];
		$this->view->setVar('configSetting',$configSetting);
		$this->view->setVar("configList", $configList);
		$this->view->setVar("pager", $configList["pager"]);
		$this->view->setVar('con_group',!empty($this->request->get('con_group')) ? $this->request->get('con_group') : '');
		$this->view->setVar('con_type',!empty($this->request->get('con_type')) ? $this->request->get('con_type') : '');
		$this->view->setVar('con_value',!empty($this->request->get('con_value')) ? $this->request->get('con_value') : '');
		$this->view->disableLevel(\Phalcon\MVC\View::LEVEL_MAIN_LAYOUT);
	}
	
	public function batchDeleteAction(){
		if(!empty($this->request->get('cong_id'))) {
            $config_ids = $this->request->get('cong_id');
            $sql = "delete from tx_config where id in (".implode($config_ids, ',').")";
            $this->db->query($sql);
            $this->forward('Config/index');
		}
	}
	
	public function deleteAction(){
		$this->view->setRenderLevel(\Phalcon\MVC\View::LEVEL_NO_RENDER);
		if(empty($this->request->get('id'))){
			$this->error('删除失败，请重新刷新页面！');
			echo json_encode(["status" => "false", "msg" => "删除失败，请重新刷新页面！"]);
			return false;
		}
		$sql = "delete from tx_config where id =".$this->request->get('id');
		if($this->db->query($sql)){
			echo json_encode(["status" => "true", "msg" => "删除成功！"]);
			return false;
		}else{
			echo json_encode(["status" => "false", "msg" => "删除失败，请重新刷新页面！"]);
			return false;
		}
	}
	
	public function addConfigAction(){
		$this->view->disableLevel(\Phalcon\MVC\View::LEVEL_MAIN_LAYOUT);
		$this->view->setVar('post','');
		if($this->request->getPost()){
		   $validator = new \Phalcon_wifi\Common\Validate\ConfigValidate();
		   $post = $this->request->getPost();
		   $messages = $validator->validate($post); 
		   if(count($messages)){
			   foreach ($messages as $message) {
			   	   echo $message, '|';
			   }
			   $this->view->setVar('post',$post);
			   $this->view->setVar('errorMsg',$message);
			   return false; 
		   }else{
		   	   //save post data
		   	   $config = new \Phalcon_wifi\Common\Models\Config();
		   	   print_r($this->request->getPost());
		   	   $config->variable_name = $this->request->getPost("variable_name");
		   	   $config->variable_title = $this->request->getPost("variable_title");
		   	   $config->sort = $this->request->getPost("sort");
		   	   $config->type = $this->request->getPost("type");
		   	   $config->group = $this->request->getPost("group");
		   	   $config->variable_value = $this->request->getPost("variable_value");
		   	   $config->extra = $this->request->getPost("extra");
		   	   $config->remark = $this->request->getPost("remark");
		   	   $config->status = 0;
		   	   if(!$config->create()) {	   	   
		   	   	   foreach ($products->getMessages() as $message) {
		   	   		   $message = (string)$message;
		   	   	   }
		   	   	   $this->view->setVar('post',$post);
		   	   	   $this->view->setVar('errorMsg',$message);
		   	   	   return false;
		   	   } else {
		   	   	   return $this->forward("Config/index");
		   	   }  
		   	   $this->forward('Config/index');
		   }  
		}
	}
	
	public function editConfigAction(){
		
	}
	
	public function modifyConfigAction(){
		
	}
}