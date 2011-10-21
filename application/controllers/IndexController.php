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
        // Get client
		$client = $this->_authModel->getClientByPublicKey('JMoEudX2ESn5ZNiUcMbFd25ynBErffCF7l4ezRWRe959PENv6XVYNckiImF7P34Q');
    }


}

