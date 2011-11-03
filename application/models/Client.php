<?php
class Application_Model_Client extends Dm_Model_Abstract
{   
    public function getClientByPublicKey($publicKey)
    {
        return $this->getResource('Client')->getClientByPublicKey($publicKey);
    }

    public function getClientByEmail($email)
    {
        return $this->getResource('Client')->getClientByEmail($email);
    }

    public function getClients($paged=false, $order=null)
    {
        return $this->getResource('Client')->getClients($paged, $order);
    }

    public function authenticate($authHeader, $dateHeader, $method){
        preg_match('/(.*):(.*):(.*):(.*)/', $authHeader, $parts);

        $this->authenticateDate($dateHeader);
        $this->authenticateClient($parts, $dateHeader, $method);
        $this->authenticateUser($parts);
        return true;
    }

    private function authenticateDate($dateHeader){
        $currentTimestamp = time();
        $date = new DateTime($dateHeader);
        if(abs($date->getTimestamp() - $currentTimestamp) > 180){
            throw new Tours_Exception_Authentication_DateOutOfBounds("Date header is not within 180 seconds of current GMT time.");
        }
    }

    private function authenticateClient($parts, $dateHeader, $method){
        $client = $this->getClientByPublicKey($parts[1]);
        if(NULL === $client){
            throw new Tours_Exception_Authentication_InvalidApiKey("Invalid API key.");
        }
        $testValue = 'can'.$method;
        if($parts[2] === base64_encode(sha1($client->privateKey . "\n" . $dateHeader))){
            if(!$client->isActive || !$client->$testValue){
                throw new Tours_Exception_Authentication_ClientNotAuthorized("Client is not authorized to perform that action.");
            }
        }else{
            throw new Tours_Exception_Authentication_InvalidApiKey("Invalid API key.");
        }
    }

    private function authenticateUser($parts){
        $userModel = new Application_Model_User();
        $user = $userModel->getUserByEmail(base64_decode($parts[3]));
        if(NULL === $user){
            throw new Tours_Exception_Authentication_InvalidUser('The username or password is incorrect.');
        }
        if($user->password !== sha1(sha1(base64_decode($parts[4])) . $user->salt)){
            throw new Tours_Exception_Authentication_InvalidUser('The username or password is incorrect.');
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

        return $this->save($data);
    }

    public function updateClient($post)
    {
        return $this->save($post);
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
