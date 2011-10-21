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
        $restRoute = new Zend_Rest_Route($frontController);
        $frontController->getRouter()->addRoute('default', $restRoute);
	}

}
