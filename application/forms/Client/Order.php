<?php

class Application_Form_Client_Order extends Dm_Form_Abstract {

    public function init() {
    
        $this->addElement('select', 'sort', array(
			'filters'   => array('StringTrim'),
			'multiOptions'	=> array(
                'dateCreated'   => 'Date',
				'email'		    => 'Email',
				'isActive'		=> 'Active',
                'canGet'		=> 'Get',
                'canPost'		=> 'Post',
                'canPut'		=> 'Put',
                'canDelete'		=> 'Delete',
			),
            'decorators'	=> array(
				'ViewHelper',
				'Errors',
				array('HtmlTag', array('tag' => 'div', 'class' => 'elementWrapper', 'style' => 'display:inline-block')),
			),
			'required'		=> true,
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
						'id' => 'order-client-submit'
					)
				)
			),
            'label'         => "Order",
        ));

        $this->setAttrib('id', 'order-client-form');
    }
}