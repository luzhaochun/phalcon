<?php
namespace Phalcon_wifi\Common\Models;
class CommonModels extends \Phalcon\Mvc\Model {
	public static $MAX_PERTABLE_NUMS = "500000";
	
	public $error = "";
	public $db = null;
	
	//本app公共model初始化
	public function initialize() {
		
	}
	
	//基于单表的通用list(包涵分页)
	public function baseList($page, $order, $where = "TRUE", $perPage = 10) {
		$tableName = $this->getSource();
		$sql = "SELECT count(*) AS total FROM {$tableName} WHERE $where";
		$total = $this->getDI()->get("db")->fetchOne($sql)["total"];
		$pager = new \Phalcon_wifi\Common\Ext\Pager($total, $page, $perPage);
		$sql = "SELECT * FROM {$tableName} WHERE $where ORDER BY $order LIMIT {$pager->limitStart}, {$pager->limit}";
		$data = $this->getDI()->get("db")->fetchAll($sql);
		return ["data" => $data, "pager" => $pager];
	}
	
	public function __get($key) {
		return $this->getDI()->get($key);
	}
}