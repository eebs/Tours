<?php
class Tours_Validate_UniqueClientEmail extends Zend_Validate_Abstract
{
    const EMAIL_EXISTS = 'emailExists';

    protected $_messageTemplates = array(
        self::EMAIL_EXISTS => '"%value%" is already in use',
    );

    public function __construct(Application_Model_Client $model)
    {
        $this->_model = $model;
    }

    public function isValid($value, $context = null)
    {
        $this->_setValue($value);
        $user = $this->_model->getClientByEmail($value);
        
        if (null === $user) {
            return true;
        }

        $this->_error(self::EMAIL_EXISTS);
        return false;
    }
}
