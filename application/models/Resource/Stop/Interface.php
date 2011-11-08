<?php

interface Application_Model_Resource_Stop_Interface extends Dm_Model_Resource_Db_Interface 
{
    public function getStopById($id);
}
