<?php
class Application_Model_Resource_User_Item extends Dm_Model_Resource_Db_Table_Row_Abstract implements Application_Model_Resource_User_Item_Interface
{
    public function getFullname()
    {
        return $this->getRow()->firstname . ' ' . $this->getRow()->lastname;
    }
}