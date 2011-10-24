<?php

interface Application_Model_Resource_User_Interface extends Dm_Model_Resource_Db_Interface 
{
    public function getUserById($id);
    public function getUserByEmail($email, $ignoreUser=null);
    public function getUsers($paged=false, $order=null);
}
