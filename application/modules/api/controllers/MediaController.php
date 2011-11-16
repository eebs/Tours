<?php

class Api_MediaController extends Zend_Controller_Action
{
    public function init()
    {
        //$this->_helper->viewRenderer->setNoRender(true);
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch
            ->addActionContext('upload', array('json','xml'))
            ->initContext();
    }

    public function uploadAction(){
        $upload = new Zend_File_Transfer();
        $upload->addValidators(array(
            'Size'      => array(
                'max'   => '5MB',
            ),
            'MimeType'  => array(
                'audio/mpeg',
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ));

        $files = $upload->getFileInfo();

        foreach ($files as $file => $info) {
            if($upload->isValid($file)){
                $newFileName = sha1($info['name'] . mt_rand());
                $destination = '/var/www/tours/data/media/'.$newFileName;

                $upload->addFilter(
                    'Rename',
                    array(
                        'target'    => $destination,
                        'overwrite' => false,
                    ),
                    $info['name']
                );
                $upload->receive($file);
            }
        }
        if($upload->hasErrors()){
            $this->view->assign('result', array('status'=>'error', 'errors'=>$upload->getMessages()));
        }else{
            $this->view->assign('result', array('status'=>'success'));
        }
    }
}
