<?php

namespace app\controllers;

use app\forms\LoginForm;

class LoginCtrl{
	private $form;
	
	public function __construct(){
		$this->form = new LoginForm();
	}
		
	public function validate() {
		$this->form->login = getFromRequest('login');
		$this->form->pass = getFromRequest('pass');

		if (!isset($this->form->login)) return false;
		
		if (empty($this->form->login)) {
			getMessages()->addError('Nie podano loginu');
		}
		if (empty($this->form->pass)) {
			getMessages()->addError('Nie podano hasła');
		}

		if (getMessages()->isError()) return false;
		
		if ($this->form->login == "admin" && $this->form->pass == "admin") {
			addRole('admin');
		} else if ($this->form->login == "user" && $this->form->pass == "user") {
			addRole('user');
		} else {
			getMessages()->addError('Incorrect login or password');
		}
		
		return ! getMessages()->isError();
	}

	public function action_loginShow(){
		$this->generateView(); 
	}
	
	public function action_login(){
		if ($this->validate()){
			getMessages()->addError('User logged into system.');
			redirectTo("personList");
		} else {
			$this->generateView(); 
		}		
	}
	
	public function action_logout(){
		session_destroy();
		redirectTo('login');
	}	
	
	public function generateView(){
		getSmarty()->assign('form',$this->form);
		getSmarty()->display('LoginView.tpl');		
	}
}
