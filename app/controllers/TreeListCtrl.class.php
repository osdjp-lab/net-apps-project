<?php

namespace app\controllers;

use app\forms\TreeSearchForm;
use PDOException;

class TreeListCtrl {

	private $form;
	private $records;

	public function __construct(){
		$this->form = new TreeSearchForm();
	}

	public function validate() {
		$this->form->name = getFromRequest('sf_name');
		return ! getMessages()->isError();
	}

	public function action_treeList(){
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
			$this->records = getDB()->select("trees", [
					"idtree",
					"name",
					"family",
				], $where );
		} catch (PDOException $e){
			getMessages()->addError('Table query error!');
			if (getConf()->debug) getMessages()->addError($e->getMessage());
        }
        
        if (isset(getConf()->roles['permissions'])){
            $permissions = (int)getConf()->roles['permissions'];

            $tree_access = $permissions & 2;

            if ($tree_access) {
                getSmarty()->assign('searchForm',$this->form);
		        getSmarty()->assign('trees',$this->records);
		        getSmarty()->display('TreeList.tpl');
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
