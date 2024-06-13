<?php

namespace app\controllers;

use app\forms\HerbSearchForm;
use PDOException;

class HerbListCtrl {

	private $form;
	private $records;

	public function __construct(){
		$this->form = new HerbSearchForm();
	}
		
	public function validate() {
		$this->form->name = getFromRequest('sf_name');
	
		return ! getMessages()->isError();
	}
	
	public function action_herbList(){
		$this->validate();
		
		$search_params = [];
		if ( isset($this->form->name) && strlen($this->form->name) > 0) {
			$search_params['name[~]'] = $this->form->name.'%';
		}
		
		$num_params = sizeof($search_params);
		if ($num_params > 1) {
			$where = [ "AND" => &$search_params ];
		} else {
			$where = &$search_params;
		}
		$where ["ORDER"] = "name";
		
		try{
			$this->records = getDB()->select("herbs", [
					"idherb",
                    "name",
                    "family",
				], $where );
		} catch (PDOException $e){
			getMessages()->addError('Table query error!');
			if (getConf()->debug) getMessages()->addError($e->getMessage());			
		}	
        
        if (isset(getConf()->roles['permissions'])){
            $permissions = (int)getConf()->roles['permissions'];

            $herb_access = $permissions & 4;

		    if ($herb_access) {
		        getSmarty()->assign('searchForm',$this->form);
		        getSmarty()->assign('herbs',$this->records);
		        getSmarty()->display('HerbList.tpl');
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
