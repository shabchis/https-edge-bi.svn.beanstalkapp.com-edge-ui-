<?php

class Panorama extends Controller{
	
	function index($accountID){
		
		$result = $this->edgeapi->Request('/accounts/'.$accountID);
		$account = json_decode($result);
		//$this->firephp->log($account);
	
		if (!isset($account->MetaData->Book) || !isset($account->MetaData->ADRole))
			$this->errors->ThrowEx("Account settings not properly defined, please contact administrator.", 500, null, null, false);
			
		$data = array(
			"accountID" => $accountID,
			"book" => $account->MetaData->Book,
			"role" => $account->MetaData->ADRole,
			"level" => $account->Level
		);
		
		$this->load->view('panorama',$data);
	}
	
}