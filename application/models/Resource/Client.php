<?php
class Application_Model_Resource_Client extends Dm_Model_Resource_Db_Table_Abstract implements Application_Model_Resource_Client_Interface 
{
    protected $_name = 'client';
    protected $_primary = 'publicKey';
    protected $_rowClass = 'Application_Model_Resource_Client_Item';

    public function getClientByPublicKey($publicKey)
    {
        return $this->find($publicKey)->current();
    }
}