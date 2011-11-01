<?php
class Application_Model_Tour extends Dm_Model_Abstract
{   
    public function getTourById($id)
    {
        return $this->getResource('Tour')->getTourById($id);
    }

    public function getTours($paged=null, $order=null)
    {
        return $this->getResource('Tour')->getTours($paged, $order);
    }
}
