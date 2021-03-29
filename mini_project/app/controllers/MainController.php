<?php

class MainController extends Controller {
	
	function render() {
		$this->f3->set('html_title','Home Page');
		
		$this->f3->set('content','home.htm');
		echo Template::instance()->render('layout.htm');   
		//echo $template->render('template.htm');

	}

}