<?php

class Zend_View_Helper_AuthInfo extends Zend_View_Helper_Abstract
{   
    protected $_authService;
    
    /**
     * Get user info from the auth session
     *
     * @param string|null $info The data to fetch, null to chain
     * @return string|Zend_View_Helper_AuthInfo
     */
    public function authInfo ($info = null)
    {
        if (null === $this->_authService) {
            $this->_authService = new Tours_Service_Authentication();
        }
         
        if (null === $info) {
            return $this;
        }
        
        if (false === $this->isLoggedIn()) {
            return null;
        }
        
        return $this->_authService->getIdentity()->$info;
    }
    
    /**
     * Check if we are logged in
     *
     * @return boolean
     */
    public function isLoggedIn()
    {
        return $this->_authService->getAuth()->hasIdentity();
    }
}
