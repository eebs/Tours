<?php
class Tours_Controller_Action_Helper_LastDecline
    extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * Enter description here...
     *
     * @var string
     */
    protected $_namespace = __CLASS__;

    /**
     * Enter description here...
     *
     * @var Zend_Session_Namespace
     */
    protected $_session = null;

    /**
     * Enter description here...
     *
     * @param string $namespace
     * @return ZendY_Controller_Action_Helper_LastDecline
     */
    public function setNamespace($namespace)
    {
        $this->_namespace = $namespace;
        return $this;
    }

    /**
     * Enter description here...
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->_namespace;
    }

    /**
     * Enter description here...
     *
     * @param Zend_Session_Namespace $session
     * @return ZendY_Controller_Action_Helper_LastDecline
     */
    public function setSession($session)
    {
        $this->_session = $session;
        return $this;
    }

    /**
     * Enter description here...
     *
     * @return Zend_Session_Namespace
     */
    public function getSession()
    {
        if (null === $this->_session) {
            $this->_session = new Zend_Session_Namespace($this->getNamespace());
        }
        return $this->_session;
    }

    /**
     * Enter description here...
     *
     * @return Zend_Controller_Action_Helper_Redirector
     */
    protected function _getRedirector()
    {
        return Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');
    }

    /**
     * Enter description here...
     *
     * @param string $requestUri
     * @return ZendY_Controller_Action_Helper_LastDecline
     */
    public function saveRequestUri($requestUri = '')
    {
        if ('' === $requestUri) {
            $requestUri = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
        }
        $this->getSession()->lastRequestUri = $requestUri;

        return $this;
    }

    /**
     *
     * @return bool
     */
    public function hasRequestUri()
    {
        $session = $this->getSession();
        return isset($session->lastRequestUri);
    }

    /**
     * Enter description here...
     *
     * @return string|null
     */
    public function getRequestUri()
    {
        $session = $this->getSession();
        if ($this->hasRequestUri()) {
            $lastRequestUri = $session->lastRequestUri;
            unset($session->lastRequestUri);
            return $lastRequestUri;
        } else {
            return null;
        }
    }

    /**
     * Enter description here...
     *
     */
    public function redirect()
    {
        if (null === ($lastRequestUri = $this->getRequestUri())) {
            $this->_getRedirector()->gotoUrl('/');
        } else {
            $this->_getRedirector()->gotoUrl($lastRequestUri);
        }
    }

    /**
     * Enter description here...
     *
     */
    public function direct()
    {
        $this->redirect();
    }
}