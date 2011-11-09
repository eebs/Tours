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

    public function createTour($post)
    {
        $form = $this->getForm('tourCreate');
        return $this->save($form, $post);
    }

    public function editTour($post){
        $form = $this->getForm('tourEdit');
        return $this->save($form, $post);
    }

    protected function save($form, $post, $defaults = array()){
        if(!$form->isValid($post)){
            return false;
        }

        $filteredData = $form->getValues();

        $data = $defaults;
        foreach($filteredData as $col => $value){
            $data[$col] = $value;
        }

        $tour = array_key_exists('id', $data) ? $this->getResource('Tour')->getTourById($data['id']) : null;
        return $this->getResource('Tour')->saveRow($data, $tour);
    }
}
