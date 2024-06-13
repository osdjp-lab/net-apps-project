<?php

namespace app\controllers;

use app\forms\LoginForm;

class LoginCtrl{
    
    private $form;
    private $record;
	
	public function __construct(){
		$this->form = new LoginForm();
	}
		
	public function validate() {
		$this->form->login = getFromRequest('login');
		$this->form->pass = getFromRequest('pass');

		if (!isset($this->form->login)) return false;
		
		if (empty($this->form->login)) {
			getMessages()->addError('No login');
		}
		if (empty($this->form->pass)) {
			getMessages()->addError('No password');
		}

		if (getMessages()->isError()) return false;

        
		return ! getMessages()->isError();
	}

	public function action_loginShow(){
		$this->generateView(); 
    }

	public function action_login(){
		if ($this->validate()){
            try {
				$this->record = getDB()->get("person", "*",[
					"username" => $this->form->login
                ]);
			} catch (PDOException $e){
				getMessages()->addError('Wystąpił błąd podczas odczytu rekordu');
                if (getConf()->debug) getMessages()->addError($e->getMessage());
			}	
            
            if ($this->form->pass == $this->record['password']) {
                getMessages()->addError('User logged into system.');

                $permissions = $this->record['user_access']+$this->record['tree_access']*2+$this->record['herb_access']*4;

                addRole($permissions);
                if ($this->record['user_access'] == 1) {
                    redirectTo("personList");
                }
                if ($this->record['tree_access'] == 1) {
                    redirectTo("treeList");
                }
                if ($this->record['herb_access'] == 1) {
                    redirectTo("herbList");
                }
                else {
                    redirectTo('welcomePage');
                }
		    } else {
		    	getMessages()->addError('Incorrect login or password');
			    $this->generateView(); 
		    }
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
