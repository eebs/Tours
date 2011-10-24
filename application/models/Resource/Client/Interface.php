<?php

interface Application_Model_Resource_Client_Interface extends Dm_Model_Resource_Db_Interface 
{
    public function getClientByPublicKey($publicKey);
}
