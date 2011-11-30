<?php
class Tours_Controller_Plugin_Logger extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
		$logger = Zend_Registry::get('log');

		$headers = array();
		if (function_exists('apache_request_headers')) {
			$headers = apache_request_headers();
		}
		$logger->info('Incoming Request');
		$logger->debug(print_r($headers,true));
    }
}
