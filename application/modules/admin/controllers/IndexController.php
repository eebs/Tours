<?php

class Admin_IndexController extends Zend_Controller_Action
{
    public function init()
    {
         // Get the default model
         $this->_clientModel = new Application_Model_Client();

         // Add forms
         $this->view->clientCreateForm = $this->getClientCreateForm();
    }

    public function indexAction(){
        $this->view->clients = $this->_clientModel->getClients($this->_getParam('page', 1), array('dateCreated DESC'));
    }

    public function createclientAction()
    {
        $this->_clientModel->createClient();
        return $this->_helper->redirector('');
    }

    public function getClientCreateForm(){
		$urlHelper = $this->_helper->getHelper('url');

		$this->_forms['clientCreate'] = $this->_clientModel->getForm('clientCreate');
		$this->_forms['clientCreate']->setAction($urlHelper->url(array(
            'module'        => 'admin',
			'controller'	=> 'index',
			'action'		=> 'createclient',
		),
		'default'));
		$this->_forms['clientCreate']->setMethod('post');

		return $this->_forms['clientCreate'];
	}
}
