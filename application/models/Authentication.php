<?php
class Application_Model_Authentication extends Dm_Model_Abstract
{   
    public function getClientByPublicKey($publicKey)
    {
        return $this->getResource('Authentication')->getClientByPublicKey($publicKey);
    }

	public function authenticate($authHeader, $dateHeader){
		preg_match('/(.*):(.*)/', $authHeader, $parts);

		$client = $this->getClientByPublicKey($parts[1]);
		return $parts[2] === base64_encode(sha1($client->privateKey . '\n' . $dateHeader));
	}
}
