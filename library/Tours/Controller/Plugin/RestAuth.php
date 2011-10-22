<?php
class Tours_Controller_Plugin_RestAuth extends Zend_Controller_Plugin_Abstract
{

	private $_validMethods = array(
		'Get',
		'Post',
		'Put',
		'Delete',
	);
	
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
		// If the request is going to the API, check for authorization
        if($request->getModuleName() == "api" && $request->getControllerName() != 'index'){
			$isAuthed = false;

			$method = ucfirst(strtolower($request->getMethod()));
			if(!in_array($method, $this->_validMethods)){
				$error = "Method $method is invalid.";
			}else{		
				$authHeader = $request->getHeader('Authorization');
				$dateHeader = $request->getHeader('Date');

				if ($authHeader && $dateHeader) {
					$authModel = new Application_Model_Authentication();
					try{
						$isAuthed = $authModel->authenticate($authHeader, $dateHeader, $method);
					}catch(Tours_Exception_Authentication $e){
						$error = $e->getMessage();
					}
				}else{
					$error = "Authorization or Date header not set.";
				}
			}
			if(!$isAuthed){
				$this->getResponse()
						->setHttpResponseCode(403);
				$request->setParam('error_message', $error);
				$request->setModuleName('api')
						->setControllerName('error')
						->setActionName('access');
			}
		}
    }
}
