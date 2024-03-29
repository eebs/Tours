<?php

class Admin_ClientController extends Zend_Controller_Action
{
    public function init()
    {
         // Get the default model
         $this->_clientModel = new Application_Model_Client();

         // Add forms
         $this->view->clientCreateForm = $this->getClientCreateForm();
         $this->view->clientOrderForm = $this->getClientOrderForm();
         $this->view->clientAddForm = $this->getClientAddForm();
    }

    public function indexAction(){
        $this->_forward('list');
    }

    public function listAction(){
        $sort = $this->_getParam('sort', 'dateCreated');
        $this->view->clients = $this->_clientModel->getClients($this->_getParam('page', 1), array($sort . ' DESC'));
        $this->view->clientOrderForm->getElement('sort')->setValue($sort);
    }

    public function addAction()
    {
    }

    public function addclientAction(){
        $request = $this->getRequest();
		if(!$request->isPost()){
			return $this->_helper->redirector('add');
		}

		// Validate
		$form = $this->_forms['clientAdd'];
		if(!$form->isValid($request->getPost())){
			return $this->render('add');
		}

        $this->_clientModel->createClient($request->getPost());
		return $this->_helper->redirector('');
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
			'controller'	=> 'client',
			'action'		=> 'add',
		),
		'default'));
		$this->_forms['clientCreate']->setMethod('post');

		return $this->_forms['clientCreate'];
	}

    public function getClientOrderForm(){
		$urlHelper = $this->_helper->getHelper('url');

		$this->_forms['clientOrder'] = $this->_clientModel->getForm('clientOrder');
		$this->_forms['clientOrder']->setAction($urlHelper->url(array(
            'module'        => 'admin',
		),
		'default'));
		$this->_forms['clientOrder']->setMethod('post');

		return $this->_forms['clientOrder'];
	}

    public function getClientAddForm(){
		$urlHelper = $this->_helper->getHelper('url');

		$this->_forms['clientAdd'] = $this->_clientModel->getForm('clientAdd');
		$this->_forms['clientAdd']->setAction($urlHelper->url(array(
            'module'        => 'admin',
            'controller'    => 'client',
            'action'        => 'addclient',
		),
		'default'));
		$this->_forms['clientAdd']->setMethod('post');

		return $this->_forms['clientAdd'];
	}
}
