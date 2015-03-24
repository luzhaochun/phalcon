<?php
namespace Phalcon_wifi\Admin;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;

class Module implements \Phalcon\Mvc\ModuleDefinitionInterface {
	public function registerAutoloaders() {
		$loader = new \Phalcon\Loader();
		$loader->registerNamespaces(array(
			"Phalcon_wifi\Admin\Controllers" => __DIR__ . "/controllers/",
		));
		$loader->register();
	}

	public function registerServices($di) {
		$di['view'] = function() {
			$view = new \Phalcon\Mvc\View();
			$view->registerEngines(array(
				'.html' => function ($view, $di) {
					$volt = new VoltEngine($view, $di);
					//$volt->setOptions(array(
						//'compiledPath' => $di->get('config')["common"]["application"]['cacheDir'],
						//'compiledSeparator' => '_'
					//));
					return $volt;
				}
				));
			$view->setViewsDir(__DIR__ . '/views/');
			return $view;
		};
	}
}
