<?php

class Tours_Action_Helper_Statistics
	extends Zend_Controller_Action_Helper_Abstract
{
	protected $view;

	public function preDispatch(){
		$view = $this->getView();
		$user = new Application_Model_User();
		$count = $user->getUsers()->getTotalItemCount();
		
		
		$this->view->totalusers = $count;
	}

	public function getView()
	{
		if (null !== $this->view) {
			return $this->view;
		}
		$controller = $this->getActionController();
		$this->view = $controller->view;
		return $this->view;
	}

}
