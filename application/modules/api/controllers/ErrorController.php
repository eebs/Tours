<?php

class Api_ErrorController extends Zend_Controller_Action
{

	public function init()
	{
		$contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('access', array('json','xml'))->initContext();
	}

	public function accessAction()
	{
		$this->view->assign('error_message', $this->getRequest()->getParam('error_message'));
	}
}
