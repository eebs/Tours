<?php

class UserController extends Zend_Controller_Action {
	protected $_model;

	public function init(){
		 // Get the default model
		 $this->_model = new Application_Model_User();

		 $this->_authService = new Tours_Service_Authentication();

		 // Add forms
		 $this->view->registerForm = $this->getRegistrationForm();
		 $this->view->loginForm = $this->getLoginForm();
		 $this->view->userForm = $this->getUserForm();
	}

	public function loginAction(){

	}

	public function authenticateAction(){
		$request = $this->getRequest();
		if(!$request->isPost()){
			return $this->_helper->redirector('login');
		}

		// Validate
		$form = $this->_forms['login'];
		if(!$form->isValid($request->getPost())){
			return $this->render('login');
		}
		if(false === $this->_authService->authenticate($form->getValues())){
			$form->setDescription('Login failed, please try again');
			return $this->render('login');
		}
		$redirector = $this->getHelper('redirector');
		return $redirector->gotoSimple('index', 'index');
	}

	public function logoutAction(){
		$this->_authService->clear();
		$redirector = $this->getHelper('redirector');
		return $redirector->gotoSimple('index', 'index');
	}

	public function indexAction(){

		if(!$this->_authService->getAuth()->hasIdentity()){
			return $this->_helper->redirector('login');
		}

		$this->view->user = $this->_model->getUserById($this->_authService->getIdentity()->userId);
		$this->view->userForm = $this->getUserForm()->populate($this->view->user->toArray());
	}

	public function saveAction(){
		$request = $this->getRequest();

		if(!$request->isPost()){
			return $this->_helper->redirector('index');
		}

		if(false === $this->_model->saveUser($request->getPost())){
			return $this->render('index');
		}

		$user = $this->_model->getUserById($this->_authService->getIdentity()->userId);

		$auth = $this->_authService->getAuth();
		$auth->getStorage()->write($user);

		return $this->_helper->redirector('index');
	}

	public function registerAction(){

	}

	public function completeRegistrationAction(){
		$request = $this->getRequest();

		if(!$request->isPost()){
			return $this->_helper->redirector('register');
		}

		if(false === ($id = $this->_model->registerUser($request->getPost()))){
			return $this->render('register');
		}
	}

	public function getRegistrationForm(){
		$urlHelper = $this->_helper->getHelper('url');

		$this->_forms['register'] = $this->_model->getForm('userRegister');
		$this->_forms['register']->setAction($urlHelper->url(array(
			'controller'	=> 'user',
			'action'		=> 'complete-registration',
		),
		'default'));
		$this->_forms['register']->setMethod('post');

		return $this->_forms['register'];
	}

	public function getUserForm(){
		$urlHelper = $this->_helper->getHelper('url');

		$this->_forms['userEdit'] = $this->_model->getForm('userEdit');
		$this->_forms['userEdit']->setAction($urlHelper->url(array(
			'controller'	=> 'user',
			'action'		=> 'save',
		),
		'default'));
		$this->_forms['userEdit']->setMethod('post');

		return $this->_forms['userEdit'];
	}

	public function getLoginForm(){
        $urlHelper = $this->_helper->getHelper('url');

        $this->_forms['login'] = $this->_model->getForm('userLogin');
        $this->_forms['login']->setAction($urlHelper->url(array(
            'controller' => 'user',
            'action'     => 'authenticate',
            ),
            'default'
        ));
        $this->_forms['login']->setMethod('post');

        return $this->_forms['login'];
    }
}
