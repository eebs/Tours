<?php

class Application_Form_User_Register extends Application_Form_User_Base
{
    public function init()
    {
        // make sure parent is called!
        parent::init();

        // specialize this form
        $this->removeElement('userId');
        $this->getElement('submit')->setLabel('Register');
        $this->removeElement('role');
    }
}
