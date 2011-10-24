<?php
class Tours_Validate_UniqueEmail extends Zend_Validate_Abstract
{
    const EMAIL_EXISTS = 'emailExists';

    protected $_messageTemplates = array(
        self::EMAIL_EXISTS => '"%value%" is already in use',
    );

    public function __construct(Application_Model_User $model)
    {
        $this->_model = $model;
    }

    public function isValid($value, $context = null)
    {
        $this->_setValue($value);
        $currentUser = isset($context['userId']) ? $this->_model->getUserById($context['userId']) : null;
        $user = $this->_model->getUserByEmail($value, $currentUser);
        
        if (null === $user) {
            return true;
        }

        $this->_error(self::EMAIL_EXISTS);
        return false;
    }
}
