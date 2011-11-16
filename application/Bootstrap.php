<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	/**
     * @var Zend_Log
     */
    protected $_logger;

    /**
     * Setup the logging
     */
    protected function _initLogging()
    {
        $this->bootstrap('frontController');
        $logger = new Zend_Log();

        $writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/../data/logs/app.log');
		/* Use a customized Formatting and add custom log Events */
		$formatter = new Zend_Log_Formatter_Simple('[%timestamp%] [%priorityName%] [%ipvisitor%] %requestmethod%: %uri% - %useragent% - %message%' . PHP_EOL);
		$writer->setFormatter($formatter);
		$logger->setEventItem('requestmethod', $_SERVER['REQUEST_METHOD']);
		$logger->setEventItem('uri', $_SERVER['REQUEST_URI']);
		$logger->setEventItem('ipvisitor', $_SERVER['REMOTE_ADDR']);
		$logger->setEventItem('useragent', $_SERVER['HTTP_USER_AGENT']);
		$logger->setEventItem('timestamp', date('m-d-Y H:i:s', time()));
		
        $logger->addWriter($writer);

		if ('production' == $this->getEnvironment()) {
			$filter = new Zend_Log_Filter_Priority(Zend_Log::CRIT);
			$logger->addFilter($filter);
		}

        $this->_logger = $logger;
        Zend_Registry::set('log', $logger);
    }
	
	protected function _initRestRoute()
	{
        $this->bootstrap('frontController');
        $frontController = Zend_Controller_Front::getInstance();
        $restRoute = new Zend_Rest_Route($frontController, array(), array('api' => array('tour')));
        $frontController->getRouter()->addRoute('api', $restRoute);
	}
    
    /**
     * Setup locale
     */
    protected function _initLocale()
    {
        $locale = new Zend_Locale('en_US');
        Zend_Registry::set('Zend_Locale', $locale);
    }

    /**
     * Setup the view
     */
    protected function _initViewSettings()
    {
		$this->bootstrap('view');

		$this->_view = $this->getResource('view');

		// Set encoding and doctype
        $this->_view->setEncoding('UTF-8');
        $this->_view->doctype('XHTML1_STRICT');

		// Set content type and language
        $this->_view
			->headMeta()
			->appendHttpEquiv(
				'Content-Type', 'text/html; charset=UTF-8'
			);
        $this->_view
			->headMeta()
			->appendHttpEquiv('Content-Language', 'en-US');

		// Set css links
        $this->_view
			->headLink()
			->appendStylesheet('/css/style.css');

		// Set favicon
        $this->_view->headLink(array(
                'rel' => 'favicon',
                'href' => '/images/favicon.ico'
        ));

		// Set the site title
        $this->_view->headTitle('iCompute Tours Mobile Application');
		// Set a separator
        $this->_view->headTitle()->setSeparator(' - ');
    }

    /**
     * Setup the navigation
     */
    protected function _initNavigation()
    {
    	$this->bootstrap('layout');
    	$layout = $this->getResource('layout');
    	$view = $layout->getView();
    	$config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');
    	$container = new Zend_Navigation($config);
    	$view->navigation($container);
    }

    /**
     * Setup the Action Helpers
     */
    protected function _initActionHelpers()
    {
        Zend_Controller_Action_HelperBroker::addHelper(new Tours_Controller_Action_Helper_LastDecline());
        Zend_Controller_Action_HelperBroker::addHelper(new Tours_Controller_Action_Helper_Params());
    }
}
