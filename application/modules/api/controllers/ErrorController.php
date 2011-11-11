<?php

class Api_ErrorController extends Zend_Controller_Action
{

    public function init()
    {
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch
            ->addActionContext('access', array('json','xml'))
            ->addActionContext('error', array('json','xml'))
            ->initContext();
    }

    public function accessAction()
    {
        $this->view->assign('error_message', $this->getRequest()->getParam('error_message'));
    }

    public function errorAction()
    {
        $error_message = "An unexpected error occurred";

        if(Zend_Registry::isRegistered('error_message')){
            $error_message = Zend_Registry::get('error_message');
        }
        $this->getResponse()->setHttpResponseCode($this->getRequest()->getParam('code', 500));
        $this->view->assign('error_message', $error_message);
    }
}
