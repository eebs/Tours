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
        $tour = $this->_tourModel->getTourById((int)$this->getRequest()->getParam('id'));
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
        $params = $this->_helper->getHelper('Params');
        $format = $this->getRequest()->getParam('format');

        if(false === ($id = $this->_tourModel->createTour($params->getBodyParam('tour')))){
            // Get error messages from form and output
            $form = $this->_tourModel->getForm('tourCreate');
            Zend_Registry::set('error_message', $form->getMessages());

            return $this->_forward('error', 'error', 'api', array('format'=>$format));
        }else{
            // Preserve format and return representation
            $this->_forward('get', 'tour', 'api', array(
                'id'        => $id,
                'format'    => $format,
            ));
        }
    }

    public function putAction()
    {
        $params = $this->_helper->getHelper('Params');
        $this->view->assign('tour', $params->getBodyParam('tour'));
    }

    public function deleteAction()
    {
        if($this->_tourModel->deleteTour((int)$this->getRequest()->getParam('id'))){
            $this->getResponse()->setHttpResponseCode(204);
        }else{
            $this->getResponse()->setHttpResponseCode(404);
        }
    }
}
