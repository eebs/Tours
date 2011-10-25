<?php

class Admin_IndexController extends Zend_Controller_Action
{
    public function init()
    {
         // Get the default model
         $this->_clientModel = new Application_Model_Client();
    }

    public function indexAction()
    {
    }
}
