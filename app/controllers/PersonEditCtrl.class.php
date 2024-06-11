<?php

namespace app\controllers;

use app\forms\PersonEditForm;
use DateTime;
use PDOException;

class PersonEditCtrl {

	private $form;

	public function __construct(){
		$this->form = new PersonEditForm();
	}

	public function validateSave() {
		$this->form->id = getFromRequest('id',true,'Błędne wywołanie aplikacji');
		$this->form->username = getFromRequest('username',true,'Błędne wywołanie aplikacji');
		$this->form->password = getFromRequest('password',true,'Błędne wywołanie aplikacji');
		$this->form->user_access = getFromRequest('user_access',true,'Błędne wywołanie aplikacji');
		$this->form->tree_access = getFromRequest('tree_access',true,'Błędne wywołanie aplikacji');
		$this->form->herb_access = getFromRequest('herb_access',true,'Błędne wywołanie aplikacji');

		if ( getMessages()->isError() ) return false;

		if (empty(trim($this->form->username))) {
			getMessages()->addError('Wprowadź nazwę użytkownika');
		}
        
        if (empty(trim($this->form->password))) {
			getMessages()->addError('Wprowadź hasło użytkownika');
		}
        
        $userAccess = (int) trim($this->form->user_access);

		if ($userAccess !== 0 && $userAccess !== 1) {
			getMessages()->addError('Wybierz wartość user_access');
		}
        
        $treeAccess = (int) trim($this->form->tree_access);
        
		if ($treeAccess !== 0 && $treeAccess !== 1) {
			getMessages()->addError('Wybierz wartość tree_access');
		}
        
        $herbAccess = (int) trim($this->form->herb_access);
        
		if ($herbAccess !== 0 && $herbAccess !== 1) {
			getMessages()->addError('Wybierz wartość herb_access');
		}
        
        if ( getMessages()->isError() ) return false;
		
		return ! getMessages()->isError();
	}

	public function validateEdit() {
		$this->form->id = getFromRequest('id',true,'Błędne wywołanie aplikacji');
		return ! getMessages()->isError();
	}
	
	public function action_personNew(){
		$this->generateView();
	}
	
	public function action_personEdit(){
		if ( $this->validateEdit() ){
			try {
				$record = getDB()->get("person", "*",[
					"idperson" => $this->form->id
				]);
				$this->form->id = $record['idperson'];
				$this->form->username = $record['username'];
				$this->form->password = $record['password'];
				$this->form->user_access = $record['user_access'];
				$this->form->tree_access = $record['tree_access'];
				$this->form->herb_access = $record['herb_access'];
			} catch (PDOException $e){
				getMessages()->addError('Wystąpił błąd podczas odczytu rekordu');
				if (getConf()->debug) getMessages()->addError($e->getMessage());			
			}	
		} 
		$this->generateView();		
	}

	public function action_personDelete(){		
		if ( $this->validateEdit() ){
			
			try{
				getDB()->delete("person",[
					"idperson" => $this->form->id
				]);
				getMessages()->addInfo('Pomyślnie usunięto rekord');
			} catch (PDOException $e){
				getMessages()->addError('Wystąpił błąd podczas usuwania rekordu');
				if (getConf()->debug) getMessages()->addError($e->getMessage());			
			}	
		}
		forwardTo('personList');		
	}

	public function action_personSave(){
		if ($this->validateSave()) {
			try {
				if ($this->form->id == '') {
					$count = getDB()->count("person");
					if ($count <= 20) {
						getDB()->insert("person", [
							"username" => $this->form->username,
							"password" => $this->form->password,
							"user_access" => $this->form->user_access,
							"tree_access" => $this->form->tree_access,
							"herb_access" => $this->form->herb_access,
						]);
					} else {
						getMessages()->addInfo('Ograniczenie: Zbyt dużo rekordów. Aby dodać nowy usuń wybrany wpis.');
						$this->generateView();
						exit();
					}
				} else { 
					getDB()->update("person", [
						"username" => $this->form->username,
						"password" => $this->form->password,
						"user_access" => $this->form->user_access,
						"tree_access" => $this->form->tree_access,
						"herb_access" => $this->form->herb_access,
					], [ 
						"idperson" => $this->form->id
					]);
				}
				getMessages()->addInfo('Pomyślnie zapisano rekord');

			} catch (PDOException $e){
				getMessages()->addError('Wystąpił nieoczekiwany błąd podczas zapisu rekordu');
				if (getConf()->debug) getMessages()->addError($e->getMessage());			
			}
			forwardTo('personList');

		} else {
			$this->generateView();
		}		
	}
	
	public function generateView(){
		getSmarty()->assign('form',$this->form);
		getSmarty()->display('PersonEdit.tpl');
	}
}
 
