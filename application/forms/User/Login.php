<?php

class Application_Form_User_Login extends Dm_Form_Abstract
{
    public function init()
    {               
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
			),
			'label'			=> "Login",
        ));
		
        $this->setDecorators(array(
            'FormElements',
            array(
				'HtmlTag',
				array(
					'tag' => 'dl',
					'class' => 'zend_form'
				)
			),
            array(
				'Description',
				array(
					'placement' => 'prepend',
					'class' => 'error'
				)
			),
            'Form'
        ));
    }
}
