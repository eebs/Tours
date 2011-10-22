<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        // Get authentication model
		$this->_authModel = new Application_Model_Authentication();
    }

    public function indexAction()
    {
    }


}

