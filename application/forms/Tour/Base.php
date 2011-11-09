<?php

class Application_Form_Tour_Base extends Dm_Form_Abstract {

    public function init() {

        $this->addElement('text', 'title', array(
            'filters'       => array('StringTrim'),
            'validators'    => array(
                array('Alnum', false, array('allowWhiteSpace'   => true)),
                array('StringLength', true, array(2, 128)),
            ),
            'required'      => true,
        ));

        $this->addElement('text', 'description', array(
            'filters'       => array('StringTrim'),
            'validators'    => array(
                array('Alnum', false, array('allowWhiteSpace'    => true)),
            ),
            'required'      => true,
        ));

        $this->addElement('select', 'access', array(
            'filters'       => array('StringTrim'),
            'multiOptions'  => array(
                'Walk'  => 'Walk',
                'Drive' => 'Drive',
            ),
            'required'      => true,
        ));

        $this->addElement('text', 'rating', array(
            'filters'       => array('StringTrim'),
            'validators'    => array(
                'Int',
                array('Between', true, array(1, 5)),
            ),
            'required'      => true,
        ));

        $this->addElement('text', 'tags', array(
            'filters'       => array('StringTrim'),
            'validators'    => array(
                array('Alpha', false, array('allowWhiteSpace'   => true)),
            ),
            'required'      => true,
        ));

        $this->addElement('text', 'numdownloads', array(
            'filters'       => array('StringTrim'),
            'validators'    => array(
                'Int',
            ),
            'required'      => true,
        ));

        $this->addElement('hidden', 'id', array(
            'filters'       => array('StringTrim'),
            'required'      => true,
            'decorators'    => array(
                'viewHelper',
                array(
                    'HtmlTag',
                    array(
                        'tag'   => 'dd',
                        'class' => 'noDisplay'
                    )
                )
            )
        ));
    }
}