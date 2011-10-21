<?php

class ToursController extends Zend_Rest_Controller
{

    public function init()
    {
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction()
    {
        // action body
    }


}

