<?php
class Application_Model_Resource_Authentication extends Dm_Model_Resource_Db_Table_Abstract implements Application_Model_Resource_Authentication_Interface 
{
    protected $_name = 'authentication';
    protected $_primary = 'publicKey';
    protected $_rowClass = 'Application_Model_Resource_Authentication_Item';

    public function getClientByPublicKey($publicKey)
    {
        return $this->find($publicKey)->current();
    }
}