<?php
class Application_Model_Client extends Dm_Model_Abstract
{   
    public function getClientByPublicKey($publicKey)
    {
        return $this->getResource('Client')->getClientByPublicKey($publicKey);
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

    public function createClient($info = array())
    {
        $keypair = $this->generateKeypair();
        $data['publicKey'] = $keypair['public'];
        $data['privateKey'] = $keypair['private'];
        foreach($info as $col => $value){
            $data[$col] = $value;
        }

        return $this->save($data, array('email' => 'eebs@eebs-tech.com'));
    }

    public function updateClient($post)
    {
        return $this->save($post, array('email' => 'eebs@eebs-tech.com'));
    }

    protected function save($data, $defaults=array())
    {
        // apply any defaults
        foreach ($defaults as $col => $value) {
            $data[$col] = $value;
        }

        $user = $this->getResource('Client')->getClientByPublicKey($data['publicKey']);
        return $this->getResource('Client')->saveRow($data, $user);
    }

    public function generateKeypair(){
        $keypair = array(
            'public'    => '',
            'private'   => '',
        );

        $seeds = 'abcdefghijklmnopqrstuvwqyzABCDEFGHIJKLMNOPQRSTUVWQYZ0123456789';
        $length = 64;

        // Seed generator
        list($usec, $sec) = explode(' ', microtime());
        $seed = (float) $sec + ((float) $usec * 100000);
        mt_srand($seed);

        $seedings = 'abcdefghijklmnopqrstuvwqyzABCDEFGHIJKLMNOPQRSTUVWQYZ0123456789';

        // Generate
        $seeds_count = strlen($seeds);
        for ($i = 0; $length > $i; $i++){
            $keypair['public'] .= $seeds{mt_rand(0, $seeds_count - 1)};
        }
        for ($i = 0; $length > $i; $i++){
            $keypair['private'] .= $seeds{mt_rand(0, $seeds_count - 1)};
        }
        return $keypair;
    }
}
