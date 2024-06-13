<?php

namespace app\controllers;

class HomeCtrl{
	
	public function action_welcomePage(){
		$this->generateView(); 
	}
	
	public function generateView(){
		getSmarty()->display('WelcomePage.tpl');		
	}
}
