<?php
require_once 'XML/Unserializer.php';

class Api_TourController extends Zend_Rest_Controller
{

    public function init()
    {
        $this->_tourModel = new Application_Model_Tour();

        //$this->_helper->viewRenderer->setNoRender(true);
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch
            ->addActionContext('index', array('json','xml'))
            ->addActionContext('get', array('json','xml'))
            ->addActionContext('post', array('json','xml'))
            ->addActionContext('put', array('json','xml'))
            ->addActionContext('delete', array('json','xml'))
            ->initContext();
    }

    public function indexAction()
    {
        $toursArray = $this->_tourModel->getTours()->toArray();
        $tours = array('tour'  => $toursArray);
        $this->view->assign('tours', $tours);
    }

    public function getAction()
    {
        $tour = $this->_tourModel->getTourById($this->getRequest()->getParam('id'));
        $tourArray = $tour->toArray();

        $stops = $tour->getStops();
        $stopsArray = array();

        foreach($stops as $stop){
            $stopArray = $stop->toArray();

            $media = $stop->getMedia();
            if($media->count() !== 0){
                $mediaArray = array('file' => $media->toArray());
                $stopArray['media'] = $mediaArray;
            }

            $stopsArray['stop'][] = $stopArray;
        }
        $tourArray['stops'] = $stopsArray;
        $this->view->assign('tour', $tourArray);
    }

    public function postAction()
    {
        $this->getResponse()->setHttpResponseCode(201);
        $params = $this->_helper->getHelper('Params');
        $this->view->assign('tour', $params->getBodyParam('tour'));
    }

    public function putAction()
    {
        $params = $this->_helper->getHelper('Params');
        $this->view->assign('tour', $params->getBodyParam('tour'));
    }

    public function deleteAction()
    {
        $this->getResponse()->setHttpResponseCode(204);
    }
}
