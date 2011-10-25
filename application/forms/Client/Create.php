<?php

class Application_Form_Client_Create extends Dm_Form_Abstract {

    public function init() {
		$this->addElement('submit', 'submit', array(
            'required'		=> false,
            'ignore'		=> true,
            'decorators'	=> array(
				'ViewHelper',
				array(
					'HtmlTag',
					array('
						tag' => 'dd',
						'id' => 'create-client-submit'
					)
				)
			),
            'label'			=> "Generate New Client",
        ));

        $this->setAttrib('id', 'create-client-form');
    }
}