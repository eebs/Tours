<?php
class Application_Model_Authentication extends Dm_Model_Abstract
{   
    public function getClientByPublicKey($publicKey)
    {
        return $this->getResource('Authentication')->getClientByPublicKey($publicKey);
    }

	public function authenticate($authHeader, $dateHeader, $method){

		$currentTimestamp = time();
		$date = new DateTime($dateHeader);
		if(abs($date->getTimestamp() - $currentTimestamp) > 180){
			throw new Tours_Exception_Authentication_DateOutOfBounds("Date header is not within 180 seconds of current GMT time.");
		}

		preg_match('/(.*):(.*)/', $authHeader, $parts);

		$client = $this->getClientByPublicKey($parts[1]);
		if(NULL === $client){
			throw new Tours_Exception_Authentication_InvalidApiKey("Invalid API key.");
		}
		$testValue = 'can'.$method;
		if($client->isActive && $client->$testValue){
			return $parts[2] === base64_encode(sha1($client->privateKey . "\n" . $dateHeader));
		}else{
			throw new Tours_Exception_Authentication_ClientNotAuthorized("Client is not authorized to perform that action.");
		}
	}
}
