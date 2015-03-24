<?php
namespace Phalcon_wifi\Common\Ext;

class DBManager {
	
	public $dir = "../apps/Common/backup/";
	public $error = '';
	
	public $name = '';
	public $pwd = '';
	public $host = '';
	public $dbname = '';
	
	public function __construct($name, $pwd, $host, $dbname) {
		$this->name = $name;
		$this->pwd = $pwd;
		$this->host = $host;
		$this->dbname = $dbname;
	}
	
	//备份数据库
	public function backup() {
		$fileName = $this->dir . date("Y_m_d_H_i_s") . '.sql';
		$result = exec("mysqldump -u{$this->name} -h{$this->host} -p{$this->pwd} {$this->dbname} > $fileName");
		if(!$result) {
			return true;
		}
		$this->error = "备份数据失败";
		return false;
	}
	
	//还原数据库
	public function recovery($fileName) {
		$fileName = $this->dir . $fileName;
		$dsn = "mysql:host={$this->host};dbname={$this->dbname}";
		$db = new \PDO($dsn, $this->name, $this->pwd);
		$rs = $db->query("SHOW TABLES");
		$tables = $rs->fetchAll();
		foreach ($tables as $table) {
			$tmpTable = $table[0];
			$db->exec("TRUNCATE TABLE $tmpTable");
		}
		$db->exec(file_get_contents($fileName));
		return true;
	}
	
	// 返回备份文件名数组
	public function getRecoveryFiles() {
		if (!is_dir($this->dir)) {
			$this->error = "读取文件失败";
			return false;
		}
		if (false != ($handle = opendir($this->dir))) {
			$files = array();
			while (false !== ($file = readdir($handle))) {
				if($file != '.' && $file != '..') $files[] = $file;
			}
			closedir ($handle);
			return $files;
		} else {
			$this->error = "读取文件失败";
			return false;
		}
	}
	
	public function unlinkFile($fileName) {
		$realFile = $this->dir . $fileName;
		if (!file_exists($realFile)) {
			$this->error = "文件不存在";
			return false;
		}
		unlink($realFile);
		return true;
	}
	
	//设置备份文件夹
	public function setDir($dir) {
		$this->dir = $dir;
	}
}