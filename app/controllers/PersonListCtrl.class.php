<?php

namespace app\controllers;

use app\forms\PersonSearchForm;
use PDOException;

class PersonListCtrl {

	private $form;
	private $records;

	public function __construct(){
		$this->form = new PersonSearchForm();
	}
		
	public function validate() {
		$this->form->username= getFromRequest('sf_username');
		return ! getMessages()->isError();
	}
	
	public function action_personList(){
		$this->validate();
		
		$search_params = [];
		if ( isset($this->form->username) && strlen($this->form->username) > 0) {
			$search_params['username[~]'] = $this->form->username.'%';
		}
		
		$num_params = sizeof($search_params);
		if ($num_params > 1) {
			$where = [ "AND" => &$search_params ];
		} else {
			$where = &$search_params;
		}
		$where ["ORDER"] = "username";
        
        try{
			$this->records = getDB()->select("person", [
					"idperson",
					"username",
					"user_access",
					"tree_access",
					"herb_access",
				], $where );
		} catch (PDOException $e){
			getMessages()->addError('Table query error!');
			if (getConf()->debug) getMessages()->addError($e->getMessage());
        }

        if (isset(getConf()->roles['permissions'])){
            $permissions = (int)getConf()->roles['permissions'];

            $user_access = $permissions & 1;

		    if ($user_access) {
		        getSmarty()->assign('searchForm',$this->form);
		        getSmarty()->assign('people',$this->records);
                getSmarty()->display('PersonList.tpl');
            } else {
                getMessages()->addError("Access not permitted");
                getSmarty()->display('ErrorPage.tpl');
            }
        } else {
            getMessages()->addError("Access not permitted");
            getSmarty()->display('ErrorPage.tpl');
        }
   	}
}
