<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        // Get authentication model
		$this->_clientModel = new Application_Model_Client();
    }

    public function indexAction()
    {
    }


}

