<?php
class Application_Model_Resource_Stop extends Dm_Model_Resource_Db_Table_Abstract implements Application_Model_Resource_Stop_Interface 
{
    protected $_name = 'stop';
    protected $_primary = 'id';
    protected $_rowClass = 'Application_Model_Resource_Stop_Item';

    protected $_referenceMap = array(
        'Stop' => array(
            'columns' => 'tourId',
            'refTableClass' => 'Application_Model_Resource_Tour',
            'refColumns' => 'id',
        )
    );

    public function getStopById($id)
    {
        return $this->find($id)->current();
    }
}