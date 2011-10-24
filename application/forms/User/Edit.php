<?php

class Application_Form_User_Edit extends Application_Form_User_Base
{
    public function init()
    {
        //call the parent init
        parent::init();

        //customize the form
        $this->getElement('password')->setRequired(false);
        $this->getElement('password_confirm')->setRequired(false);
        $this->getElement('submit')->setLabel('Save User');
        $this->removeElement('role');
    }
}