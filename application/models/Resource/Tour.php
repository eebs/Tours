<?php
class Application_Model_Resource_Tour extends Dm_Model_Resource_Db_Table_Abstract implements Application_Model_Resource_Tour_Interface 
{
    protected $_name = 'tour';
    protected $_primary = 'id';
    protected $_rowClass = 'Application_Model_Resource_Tour_Item';

    public function getTourById($id)
    {
        return $this->find($id)->current();
    }
}