<?php

use Phalcon\Mvc\Application;

error_reporting(E_ALL);
ini_set('date.timezone','Asia/Shanghai');
try {
	$loader = new \Phalcon\Loader();
	
	$loader->registerNamespaces(array(
		"Phalcon_wifi\Common\Models" => "../apps/Common/models",
		"Phalcon_wifi\Common\Controllers" => "../apps/Common/controllers",
		"Phalcon_wifi\Common\Config" => "../apps/Common/config",
		"Phalcon_wifi\Common\Ext" => "../apps/Common/ext",
		"Phalcon_wifi\Common\Validate" => "../apps/Common/validate"
	));
	
	$loader->register();
	
	$di = new \Phalcon\DI\FactoryDefault();
	
	$di["router"] = function () {
		$router = new \Phalcon\Mvc\Router();
		$router->setDefaultModule("Admin");
		$router->setDefaultNamespace("Phalcon_wifi\Admin\Controllers");
		$router->add('/:controller/:action/:params', array(
				'module' => 'Admin',
				'controller' => 1,
				'action' => 2,
				'params' => 3
		))->setName("common");
		
		return $router;
	};
	
	$di["url"] = function () use ($di) {
		$url = new \Phalcon\Mvc\Url();
		$url->setBaseUri($di->get("config")->get("common")["baseuri"]);
		return $url;
	};
	
	$di["session"] = function () {
		$session = new \Phalcon\Session\Adapter\Files();
		$session->start();
		return $session;
	};
	
	$di["db"] = function () use($di) {
		$config = $di->get("config")->get("common")["db"];
		$connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
				"host" => $config["host"],
				"username" => $config["username"],
				"password" => $config["password"],
				"dbname" => $config["dbname"],
				"charset" => $config["charset"]
		));
		$eventsManager = new \Phalcon\Events\Manager();
		$dblog = $di->get("config")->get("common")["dblog"];
		$logger = new \Phalcon\Logger\Adapter\File(__DIR__ . $dblog);
		$eventsManager->attach('db:beforeQuery', function($event, $connection) use ($logger) {
			$sqlVariables = $connection->getSQLVariables();
			if (count($sqlVariables)) {
				$logger->log($connection->getSQLStatement() . ' ' . join(', ', $sqlVariables), \Phalcon\Logger::INFO);
			} else {
				$logger->log($connection->getSQLStatement(), \Phalcon\Logger::INFO);
			}
		});
		$connection->setEventsManager($eventsManager);
		return $connection;
	};
	
	$di["dbBackupTool"] = function () use($di) {
		$config = $di->get("config")->get("common")["db"];
		return new \Phalcon_wifi\Common\Ext\DBManager($config["username"], $config["password"], $config["host"], $config["dbname"]);
	};
	
	$di["filter"] = function () {
		return new \Phalcon_wifi\Common\Ext\Filter();
	};
	
	$di["validateCodeCreator"] = function () use($di) {
		return new \Phalcon_wifi\Common\Ext\ValidateCode($di->get('session'));
	};
	
	$di["config"] = function () {
		$config = new \Phalcon_wifi\Common\Config\Config;
		return $config->config;
	};
	
	$di->set('modelsManager', function() {
		return new \Phalcon\Mvc\Model\Manager();
	});
	
	$di->set('auth', function() {
		return new \Phalcon_wifi\Common\Models\AuthGroup();
	});
	
	$application = new Application($di);
	$application->registerModules(array(
		"Admin" => array(
			"className" => "Phalcon_wifi\Admin\Module",
			"path" => __DIR__ . "/../apps/Admin/Module.php"
		),
		"Portal" => array(
			"className" => "Phalcon_wifi\Portal\Module",
			"path" => __DIR__ . "/../apps/Portal/Module.php"
		)
	));
	
	echo $application->handle()->getContent();
} catch (Exception $e) {
	echo $e->getMessage();
}
