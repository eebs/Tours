<?php

class Api_IndexController extends Zend_Controller_Action
{
	public function indexAction(){
		$readmeLocation  = APPLICATION_PATH."/../README.md";
		$handle =  fopen($readmeLocation, "r");
		$contents = fread($handle, filesize($readmeLocation));
		$p = new Markdown_Parser();
		$this->view->assign('markdownHTML', $p->transform($contents));
	}
}