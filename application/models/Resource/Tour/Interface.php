<?php

interface Application_Model_Resource_Tour_Interface extends Dm_Model_Resource_Db_Interface 
{
    public function getTourById($id);
}
