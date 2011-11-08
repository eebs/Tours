<?php
class Application_Model_Resource_Tour_Item extends Dm_Model_Resource_Db_Table_Row_Abstract implements Application_Model_Resource_Tour_Item_Interface
{
    /**
     * Get stops for tour
     *
     * @return Zend_Db_Table_Rowset containing Application_Model_Resource_Media_Item
     */
    public function getStops()
    {
        return $this->findDependentRowset(
            'Application_Model_Resource_Stop',
            'Stop'
        );
    }
}
