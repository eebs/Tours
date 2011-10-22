<?php

class Api_TourController extends Zend_Rest_Controller
{

	public function init()
	{
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
		$data = array('tour'	=> array(
				array(
					'name'		=> 'Tour1',
					'location'	=> array(
						'lat'	=> 1,
						'long'	=> 2,
					)
				),
				array(
					'name'		=> 'Tour1',
					'location'	=> array(
						'lat'	=> 1,
						'long'	=> 2,
					)
				),
			)
		);
		$this->view->assign('tours', $data);
	}

	public function getAction()
	{
		$this->getResponse()
			->appendBody("From getAction() returning the requested tour\n");
	}

	public function postAction()
	{
		$this->getResponse()
			->appendBody("From postAction() creating the requested tour\n");
	}

	public function putAction()
	{
		$this->getResponse()
			->appendBody("From putAction() updating the requested tour\n");

	}

	public function deleteAction()
	{
		$this->getResponse()
			->appendBody("From deleteAction() deleting the requested tour\n");
	}
}
