<?php
class Application_Model_Authentication extends Dm_Model_Abstract
{   
    public function getClientByPublicKey($publicKey)
    {
        return $this->getResource('Authentication')->getClientByPublicKey($publicKey);
    }
}