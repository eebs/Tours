<?php
class Tours_Controller_Plugin_RestAuth extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
		// If the request is going to the API, check for authorization
        if($request->getModuleName() == "api" && $request->getControllerName() != 'index'){
			$authHeader = $request->getHeader('Authorization');
			$dateHeader = $request->getHeader('Date');

			// maybe check date to see if it's within 180 seconds of current time?
			$isAuthed = false;

			if ($authHeader && $dateHeader) {
				$authModel = new Application_Model_Authentication();
				$method = ucfirst(strtolower($request->getMethod()));
				$isAuthed = $authModel->authenticate($authHeader, $dateHeader, $method);
			}

			if(!$isAuthed){
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
