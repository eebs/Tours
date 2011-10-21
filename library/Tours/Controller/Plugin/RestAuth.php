<?php
class Tours_Controller_Plugin_RestAuth extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
		// If the request is going to the API, check for authorization
        if($request->getControllerName() == "api"){
			$apiKey = $request->getHeader('Authorization');

			if ($apiKey != 'secret') {
				$this->getResponse()
						->setHttpResponseCode(403)
						->appendBody("Invalid API Key\n")
						;
				$request->setModuleName('default')
							->setControllerName('error')
							->setActionName('access')
							->setDispatched(true);
			}
		}
    }
}
