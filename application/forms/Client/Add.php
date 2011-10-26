<?php

class Application_Form_Client_Add extends Dm_Form_Abstract {

    public function init() {

        // add path to custom validators
        $this->addElementPrefixPath(
            'Tours_Validate',
            APPLICATION_PATH . '/models/Validate/',
            'validate'
        );

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
				array('UniqueClientEmail', false, array(new Application_Model_Client())),
            ),
            'required'		=> true,
            'label'			=> 'Email:',
        ));
        
        $this->addElement('checkbox', 'isActive', array(
            'required'      => true,
            'label'         => 'Active:',
            'decorators'	=> array(
				'ViewHelper',
                'Label',
                array(
                    'HtmlTag',
                    array(
                        'tag'   => 'dt'
                    )
                ),
			),
        ));

        $this->addElement('checkbox', 'canGet', array(
            'required'      => true,
            'label'         => 'Get:',
            'decorators'	=> array(
				'ViewHelper',
                'Label',
                array(
                    'HtmlTag',
                    array(
                        'tag'   => 'dt'
                    )
                ),
			),
        ));

        $this->addElement('checkbox', 'canPost', array(
            'required'      => true,
            'label'         => 'Post:',
            'decorators'	=> array(
				'ViewHelper',
                'Label',
                array(
                    'HtmlTag',
                    array(
                        'tag'   => 'dt'
                    )
                ),
			),
        ));

        $this->addElement('checkbox', 'canPut', array(
            'required'      => true,
            'label'         => 'Put:',
            'decorators'	=> array(
				'ViewHelper',
                'Label',
                array(
                    'HtmlTag',
                    array(
                        'tag'   => 'dt'
                    )
                ),
			),
        ));

        $this->addElement('checkbox', 'canDelete', array(
            'required'      => true,
            'label'         => 'Delete:',
            'decorators'	=> array(
				'ViewHelper',
                'Label',
                array(
                    'HtmlTag',
                    array(
                        'tag'   => 'dt'
                    )
                ),
			),
        ));

		$this->addElement('submit', 'submit', array(
            'required'		=> false,
            'ignore'		=> true,
            'decorators'	=> array(
				'ViewHelper',
				array(
					'HtmlTag',
					array(
                        'tag'   => 'dd',
						'id'    => 'add-client-submit'
					)
				)
			),
            'label'         => "Add Client",
        ));
    }
}