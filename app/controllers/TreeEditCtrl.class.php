<?php

namespace app\controllers;

use app\forms\TreeEditForm;
use DateTime;
use PDOException;

class TreeEditCtrl {

	private $form;

	public function __construct(){
		$this->form = new TreeEditForm();
	}

	public function validateSave() {
		$this->form->id = getFromRequest('id',true,'Błędne wywołanie aplikacji');
		$this->form->name = getFromRequest('name',true,'Błędne wywołanie aplikacji');
		$this->form->family = getFromRequest('family',true,'Błędne wywołanie aplikacji');

		if ( getMessages()->isError() ) return false;

		if (empty(trim($this->form->name))) {
			getMessages()->addError('Input name');
		}
        
        if (empty(trim($this->form->family))) {
			getMessages()->addError('Input family name');
		}
        
        if ( getMessages()->isError() ) return false;
		
		return ! getMessages()->isError();
	}

	public function validateEdit() {
		$this->form->id = getFromRequest('id',true,'Błędne wywołanie aplikacji');
		return ! getMessages()->isError();
	}
	
	public function action_treeNew(){
		$this->generateView();
	}
	
	public function action_treeEdit(){
		if ( $this->validateEdit() ){
			try {
				$record = getDB()->get("trees", "*",[
					"idtree" => $this->form->id
				]);
				$this->form->id = $record['idtree'];
				$this->form->name = $record['name'];
				$this->form->family= $record['family'];
			} catch (PDOException $e){
				getMessages()->addError('Wystąpił błąd podczas odczytu rekordu');
				if (getConf()->debug) getMessages()->addError($e->getMessage());			
			}	
		} 
		$this->generateView();		
	}

	public function action_treeDelete(){		
		if ( $this->validateEdit() ){
			
			try{
				getDB()->delete("trees",[
					"idtree" => $this->form->id
				]);
				getMessages()->addInfo('Pomyślnie usunięto rekord');
			} catch (PDOException $e){
				getMessages()->addError('Wystąpił błąd podczas usuwania rekordu');
				if (getConf()->debug) getMessages()->addError($e->getMessage());			
			}	
		}
		forwardTo('treeList');		
	}

	public function action_treeSave(){
		if ($this->validateSave()) {
			try {
				if ($this->form->id == '') {
					$count = getDB()->count("trees");
					if ($count <= 20) {
						getDB()->insert("trees", [
							"name" => $this->form->name,
							"family" => $this->form->family,
						]);
					} else {
						getMessages()->addInfo('Ograniczenie: Zbyt dużo rekordów. Aby dodać nowy usuń wybrany wpis.');
						$this->generateView();
						exit();
					}
				} else { 
					getDB()->update("trees", [
						"name" => $this->form->name,
						"family" => $this->form->family,
					], [ 
						"idtree" => $this->form->id
					]);
				}
				getMessages()->addInfo('Pomyślnie zapisano rekord');

			} catch (PDOException $e){
				getMessages()->addError('Wystąpił nieoczekiwany błąd podczas zapisu rekordu');
				if (getConf()->debug) getMessages()->addError($e->getMessage());			
			}
			forwardTo('treeList');

		} else {
			$this->generateView();
		}		
	}
	
	public function generateView(){
		getSmarty()->assign('form',$this->form);
		getSmarty()->display('TreeEdit.tpl');
	}
}
 
