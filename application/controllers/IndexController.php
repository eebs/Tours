<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        // Get Client model
        $this->_clientModel = new Application_Model_Client();

        // Get User model
        $this->_userModel = new Application_Model_User();
    }

    public function indexAction()
    {
    }


}

