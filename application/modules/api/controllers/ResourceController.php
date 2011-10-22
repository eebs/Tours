<?php

class Api_ResourceController extends Zend_Rest_Controller
{

	public function init()
	{
		$this->_helper->viewRenderer->setNoRender(true);
	}

	public function indexAction()
	{
		$this->getResponse()
			->appendBody("From indexAction() returning all resources from api/resource\n");
	}

	public function getAction()
	{
		$this->getResponse()
			->appendBody("From getAction() returning the requested resource from api/resource\n");
	}

	public function postAction()
	{
		$this->getResponse()
			->appendBody("From postAction() creating the requested resource from api/resource\n");
	}

	public function putAction()
	{
		$this->getResponse()
			->appendBody("From putAction() updating the requested resource from api/resource\n");

	}

	public function deleteAction()
	{
		$this->getResponse()
			->appendBody("From deleteAction() deleting the requested resource from api/resource\n");
	}
}
