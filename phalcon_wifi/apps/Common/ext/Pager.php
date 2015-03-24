<?php
namespace Phalcon_wifi\Common\Ext;
class Pager {
	//总条目数
	public $total;
	//总页数
	public $totalPage;
	//当前页
	public $currentPage;
	//每页条目
	public $perPage;
	//limit开始
	public $limitStart;
	//limit限制
	public $limit;
	//基本url
	public $uri;
	//显示数目
	public $showNum;
	//显示时开始页
	public $start;
	//显示时结束页
	public $end;
	//
	public $getParams = array();
	//
	public $params;
	
	public function __construct($total, $currentPage, $perPage = 10, $showNum = 9) {
		//取数据时需要获取的参数
		$this->total = $total;
		$this->currentPage = $currentPage;
		$this->perPage = $perPage;
		$this->totalPage = ceil($this->total/$this->perPage);
		$this->currentPage = $this->currentPage <= 1 ? 1 : $this->currentPage;
		$this->currentPage = $this->currentPage >= $this->totalPage ? $this->totalPage : $this->currentPage;
		$this->limitStart = $this->totalPage == 0 ? 0 : ($this->currentPage - 1) * $this->perPage;
		$this->limit = $this->perPage;
		$this->showNum = $showNum;
		$this->uri = "";
		//template显示时需要获取的参数
		if ($this->totalPage <= $this->showNum) {
			$this->start = 1;
			$this->end = $this->totalPage;
		}
		$step = ($this->showNum + 1) / 2 - 1;
		if (($this->currentPage - 1) <= $step) {
			$start = 1;
			$end = 1 + $this->showNum - 1;
			$end = $end >= $this->totalPage ? $this->totalPage : $end;
		} else if (($this->totalPage - $this->currentPage) <= $step) {
			$end = $this->totalPage;
			$start = $end - $this->showNum + 1;
			$start = $start <= 1 ? 1 : $start;
		} else {
			$start = $this->currentPage - $step;
			$end = $this->currentPage + $step;
		}
		$this->start = $start;
		$this->end = $end;
	}
	
	public function createUrl() {
		if (!$this->uri) return "";
		if (!empty($this->params)) {
			foreach ($this->params as $key => $val) {
				if ($val !== "") {
					$params[] = $key;$params[] = $val;
				}
			}
		}
		$params[] = "currentPage";
		$params[] = $this->currentPage;
		$params[] = "perPage";
		$params[] = $this->perPage;
		$params = implode("/", $params);
		
		$this->getParams = array_filter($this->getParams);
		if (!empty($this->getParams)) {
			$getPart = http_build_query($this->getParams);
			return trim($this->uri, "/") . "/" . $params . "?" . $getPart;
		}
		return trim($this->uri, "/") . "/" . $params;
	}
}