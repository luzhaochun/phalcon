<?php
namespace Phalcon_wifi\Portal;
class Module implements \Phalcon\Mvc\ModuleDefinitionInterface {
	public function registerAutoloaders() {
		$loader = new \Phalcon\Loader();
		$loader->registerNamespaces(array(
			'Phalcon_wifi\Portal\Controllers' => __DIR__ . '/controllers/',
		));
		$loader->register();
	}

	public function registerServices($di) {
		$di['view'] = function () {
			$view = new \Phalcon\Mvc\View();
			$view->setViewsDir(__DIR__ . '/views/');
			return $view;
		};
	}
}
