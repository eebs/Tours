<?php

class Tours_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request){
        $acl = new Zend_Acl();

        $acl->addRole(new Zend_Acl_Role('guest'));
        $acl->addRole(new Zend_Acl_Role('user'), 'guest');
        $acl->addRole(new Zend_Acl_Role('admin'), 'user');

        $acl->add(new Zend_Acl_Resource('default'));
        $acl->add(new Zend_Acl_Resource('admin'));
        $acl->add(new Zend_Acl_Resource('api'));

        // Deny all from admin except admins
        $acl->deny(null, 'admin');
        $acl->allow('admin', 'admin');

        // Allow all to default and api modules
        $acl->allow(null, array('default','api'));

        // Admins can do anything
        $acl->allow('admin', null);

        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $identity = $auth->getIdentity();
            $role = strtolower($identity->role);
        }else{
            $role = 'guest';
        }

        $module = $request->module;

        if(!$acl->isAllowed($role, $module)){
            $lastDecline = Zend_Controller_Action_HelperBroker::getStaticHelper('LastDecline');
            $lastDecline->saveRequestUri();

            if($role == 'guest'){
                $request->setControllerName('user');
                $request->setActionName('login');
            }else{
                $request->setControllerName('error');
                $request->setActionName('denied');
            }
        }
    }
}
