<?php
class Tours_Controller_Plugin_Logger extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
		$logger = Zend_Registry::get('log');
		$logger->info('Incoming Request');
    }
}
