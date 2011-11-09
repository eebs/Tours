<?php

class Application_Form_Tour_Create extends Application_Form_Tour_Base {

    public function init() {
        parent::init();

        // specialize this form
        $this->removeElement('id');
    }
}