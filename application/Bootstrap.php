<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload()
	{
	 	 $moduleLoader = new Zend_Application_Module_Autoloader(array(
	  	  'namespace' => '',
	  	  'basePath' => APPLICATION_PATH));

	 	 $loader = Zend_Loader_Autoloader::getInstance();
     $loader->registerNamespace('Np_');
     $loader->registerNamespace('Core_');
	}

  	protected function _initView()
	{
		$config = $this->getOption('twig');
		$config['template_paths'] = array(APPLICATION_PATH . '/views/scripts/',APPLICATION_PATH . '/views/layouts/');

		include_once 'CoreIntegration/Twig/View.php';
		$view = new CoreIntegration_Twig_View($config);

		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
		$viewRenderer->setView($view)
		->setViewScriptPathSpec(':controller/:action.:suffix')
		->setViewScriptPathNoControllerSpec(':action.:suffix')
		->setViewSuffix('twig');
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
		return $view;
	}

}