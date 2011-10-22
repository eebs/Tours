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
		$time = time();
		$date = gmdate('r', $time);
		echo $date;
		echo "<br/>";
		$auth = $client->publicKey .':'. base64_encode(sha1($client->privateKey . "\n" . $date));
		echo "<br/>";
		echo "<br/>";
		echo 'curl -H "Authorization: ' . $auth . '" -H "Date: ' . $date . '" http://eebsy.com/api/resource';
    }


}

