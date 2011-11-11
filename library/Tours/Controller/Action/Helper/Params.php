<?php

require_once 'XML/Unserializer.php';

class Tours_Controller_Action_Helper_Params extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * @var array Parameters detected in raw content body
     */
    protected $_bodyParams = array();

    /**
     * Do detection of content type, and retrieve parameters from raw body if 
     * present
     * 
     * @return void
     */
    public function init()
    {
        $request     = $this->getRequest();
        $contentType = $request->getHeader('Content-Type');
        $rawBody     = $request->getRawBody();
        if (!$rawBody) {
            return;
        }
        switch (true) {
            case (strstr($contentType, 'application/json')):
                $this->setBodyParams(Zend_Json::decode($rawBody));
                break;
            case (strstr($contentType, 'application/xml')):
                $options = array(
                    XML_UNSERIALIZER_OPTION_RETURN_RESULT     => true,
                );
                $unserializer = &new XML_Unserializer($options);
                $configArray = $unserializer->unserialize($rawBody);
                $config = array($unserializer->getRootName() => $configArray);
                $this->setBodyParams($config);
                break;
            default:
                if ($request->isPut()) {
                    parse_str($rawBody, $params);
                    $this->setBodyParams($params);
                }
                break;
        }
    }

    /**
     * Set body params
     * 
     * @param  array $params 
     * @return Scrummer_Controller_Action
     */
    public function setBodyParams(array $params)
    {
        $this->_bodyParams = $params;
        return $this;
    }

    /**
     * Retrieve body parameters
     * 
     * @return array
     */
    public function getBodyParams()
    {
        return $this->_bodyParams;
    }

    /**
     * Get body parameter
     * 
     * @param  string $name 
     * @return mixed
     */
    public function getBodyParam($name)
    {
        if ($this->hasBodyParam($name)) {
            return $this->_bodyParams[$name];
        }
        return null;
    }

    /**
     * Is the given body parameter set?
     * 
     * @param  string $name 
     * @return bool
     */
    public function hasBodyParam($name)
    {
        if (isset($this->_bodyParams[$name])) {
            return true;
        }
        return false;
    }

    /**
     * Do we have any body parameters?
     * 
     * @return bool
     */
    public function hasBodyParams()
    {
        if (!empty($this->_bodyParams)) {
            return true;
        }
        return false;
    }

    /**
     * Get submit parameters
     * 
     * @return array
     */
    public function getSubmitParams()
    {
        if ($this->hasBodyParams()) {
            return $this->getBodyParams();
        }
        return $this->getRequest()->getPost();
    }

    public function direct()
    {
        return $this->getSubmitParams();
    }
}