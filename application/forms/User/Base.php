<?php

class Application_Form_User_Base extends Dm_Form_Abstract {

    public function init() {
		
		// add path to custom validators
        $this->addElementPrefixPath(
            'Tours_Validate',
            APPLICATION_PATH . '/models/Validate/',
            'validate'
        );
		
		$this->addElement('text', 'firstname', array(
            'filters'		=> array('StringTrim'),
            'validators'	=> array(
                'Alpha',
                array('StringLength', true, array(2, 128))
            ),
            'required'		=> true,
            'label'			=> 'Firstname:',
        ));

        $this->addElement('text', 'lastname', array(
            'filters'		=> array('StringTrim'),
            'validators'	=> array(
                'Alpha',
                array('StringLength', true, array(2, 128))
            ),
            'required'		=> true,
            'label'			=> 'Lastname:',
        ));
	
        $this->addElement('text', 'email', array(
            'filters'		=> array('StringTrim', 'StringToLower'),
            'validators'	=> array(
                array('StringLength', true, array(4, 128)),
                array(
					'Callback',
					true,
					array(
						'callback' => function($value) {
							$validator = new Zend_Validate_EmailAddress(
								array(
									'allow' => Zend_Validate_Hostname::ALLOW_DNS,
									'domain' => true,
									'mx' => false,
									'deep' => false,
								)
							);
	 
							return $validator->isValid($value);
						},
						'messages' => array(
							Zend_Validate_Callback::INVALID_VALUE => 'Email address is invalid',
						),
					),
				),
				array('UniqueEmail', false, array(new Application_Model_User())),
            ),
            'required'		=> true,
            'label'			=> 'Email:',
        ));
		
		$this->addElement('password', 'password', array(
			'filters'		=> array('StringTrim'),
			'validators'	=> array(
				array('StringLength', true, array(6,128))
			),
			'required'		=> true,
			'label'			=> 'Password:',
		));
		
		$this->addElement('password', 'password_confirm', array(
			'filters'		=> array('StringTrim'),
			'validators'	=> array(
				array('identical', false, array(
					'token' 	=> 'password',
					'messages'	=> array(
						'notSame'	=> 'The two password fields do not match',
					),
				)),
			),
			'required'		=> true,
			'label'			=> 'Confirm Password:',
		));
		
		$this->addElement('select', 'role', array(
			'filters'    => array('StringTrim', 'StringToLower'),
			'multiOptions'	=> array(
				'user'		=> 'User',
				'admin'		=> 'Admin',
			),
			'required'		=> true,
			'label'			=> 'Role:',
		));

		$this->addElement('submit', 'submit', array(
            'required'		=> false,
            'ignore'		=> true,
            'decorators'	=> array(
				'ViewHelper',
				array(
					'HtmlTag',
					array('
						tag' => 'dd',
						'id' => 'form-submit'
					)
				)
			)
        ));

         $this->addElement('hidden', 'userId', array(
            'filters'		=> array('StringTrim'),
            'required'		=> true,
            'decorators'	=> array(
				'viewHelper',
				array(
					'HtmlTag',
					array(
						'tag' => 'dd',
						'class' => 'noDisplay'
					)
				)
			)
        ));
    }
}