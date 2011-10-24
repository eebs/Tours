<?php

class Tours_Controller_Plugin_AcceptHandler extends Zend_Controller_Plugin_Abstract
{
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        if($request->getModuleName() === "api"){
            $this->getResponse()->setHeader('Vary', 'Accept');
            $header = $request->getHeader('Accept');
            switch (true){
                case (FALSE !== strpos($header, 'application/json')):
                    $request->setParam('format', 'json');
                    break;
                case ((FALSE !== strpos($header, 'application/xml'))):
                    $request->setParam('format', 'xml');
                    break;
                default:
                    $request->setParam('format', 'json');
                    break;
            }
        }
    }
}
