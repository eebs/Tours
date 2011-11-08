<?php

interface Application_Model_Resource_Media_Interface extends Dm_Model_Resource_Db_Interface 
{
    public function getMediaByUniqueFileName($uniqueFileName);
}
