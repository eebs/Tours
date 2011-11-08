<?php
class Application_Model_Resource_Media extends Dm_Model_Resource_Db_Table_Abstract implements Application_Model_Resource_Media_Interface 
{
    protected $_name = 'media';
    protected $_primary = 'uniqueFileName';
    protected $_rowClass = 'Application_Model_Resource_Media_Item';
    
    protected $_referenceMap = array(
        'Media' => array(
            'columns' => 'stopNumber',
            'refTableClass' => 'Application_Model_Resource_Stop',
            'refColumns' => 'id',
        )
    );

    public function getMediaByUniqueFileName($uniqueFileName)
    {
        return $this->find($uniqueFileName)->current();
    }
}