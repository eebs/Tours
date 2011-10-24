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
                $error = new Tours_Exception_Authentication_InvalidMethod("Method $method is invalid.");
            }else{
                $authHeader = $request->getHeader('Authorization');
                $dateHeader = $request->getHeader('Date');

                if ($authHeader && $dateHeader) {
                    $authModel = new Application_Model_Authentication();
                    try{
                        $isAuthed = $authModel->authenticate($authHeader, $dateHeader, $method);
                    }catch(Tours_Exception_Authentication $e){
                        $error = $e;
                    }
                }else{
                    $error = new Tours_Exception_Authentication_HeaderNotSet('Authorization or Date header not set.');
                }
            }
            if(!$isAuthed){
                switch (true){
                    case ($error instanceof Tours_Exception_Authentication_InvalidMethod):
                        $this->getResponse()
                            ->setHttpResponseCode(405);
                        break;
                    case ($error instanceof Tours_Exception_Authentication_InvalidApiKey):
                    case ($error instanceof Tours_Exception_Authentication_HeaderNotSet):
                        $this->getResponse()
                            ->setHttpResponseCode(401);
                        break;
                    case ($error instanceof Tours_Exception_Authentication_ClientNotAuthorized):
                    default:
                        $this->getResponse()
                            ->setHttpResponseCode(403);
                        break;
                }

                $request->setParam('error_message', $error->getMessage());
                $request->setModuleName('api')
                        ->setControllerName('error')
                        ->setActionName('access');
            }
        }
    }
}
