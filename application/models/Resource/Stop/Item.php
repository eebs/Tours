<?php
class Application_Model_Resource_Stop_Item extends Dm_Model_Resource_Db_Table_Row_Abstract implements Application_Model_Resource_Stop_Item_Interface
{
    /**
     * Get media for stop
     *
     * @return Zend_Db_Table_Rowset containing Application_Model_Resource_Media_Item
     */
    public function getMedia()
    {
        return $this->findDependentRowset(
            'Application_Model_Resource_Media',
            'Media'
        );
    }
}
