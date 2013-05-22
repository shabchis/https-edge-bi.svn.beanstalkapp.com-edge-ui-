<?php

class adScheduling extends Controller {
	
	function index($accountID){

		$facebook = $this->edgeapi->Request('/accounts/'.$accountID.'/campaigns?channel=6');
		$data = array("facebook" => $facebook);

		$this->load->view('pages/adScheduling',$data);	
	}
	
	function load($accountID,$campaign){
		echo $this->edgeapi->Request('/accounts/'.$accountID.'/campaigns/'.$campaign);
	}	

	function save($campaign,$accountID){
		$data = json_decode(file_get_contents("php://input"), true) ;
		$result = $this->edgeapi->Request('/accounts/'.$accountID.'/campaigns/'.$campaign.'', 'POST', true, array('Content-Type: application/json'), $data, true);
	}
}

