<?php
class Application_Model_Tour extends Dm_Model_Abstract
{   
    public function getTourById($id)
    {
        return $this->getResource('Tour')->getTourById($id);
    }
}
