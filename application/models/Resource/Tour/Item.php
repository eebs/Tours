<?php
class Application_Model_Resource_Tour_Item extends Dm_Model_Resource_Db_Table_Row_Abstract implements Application_Model_Resource_Tour_Item_Interface
{

    /**
     * Get media for tour
     *
     * @return Zend_Db_Table_Rowset containing Application_Model_Resource_Media_Item
     */
    public function getMedia()
    {
        $select = $this->select();
		$select->from(array('m' => 'media'), array('uniqueFileName'));
        return $this->findDependentRowset('Application_Model_Resource_Media',
            'Media',
            $select
        );
    }
}
