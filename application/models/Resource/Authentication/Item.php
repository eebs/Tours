<?php
class Application_Model_Resource_Authentication_Item extends Dm_Model_Resource_Db_Table_Row_Abstract implements Application_Model_Resource_Authentication_Item_Interface
{
	
    /**
     * Is the keypair active
     * 
     * @return boolean 
     */
    public function isActive()
    {
        return 'Yes' === $this->getRow()->isActive ? true : false;
    }
}