<?php
class Application_Model_Resource_Media extends Dm_Model_Resource_Db_Table_Abstract implements Application_Model_Resource_Media_Interface 
{
    protected $_name = 'media';
    protected $_primary = 'uniqueFileName';
    protected $_rowClass = 'Application_Model_Resource_Media_Item';
    
    protected $_referenceMap = array(
        'Media' => array(
            'columns' => 'tourId',
            'refTableClass' => 'Application_Model_Resource_Tour',
            'refColumns' => 'id',
        )
    );

    public function getMediaById($id)
    {
        return $this->find($id)->current();
    }
}