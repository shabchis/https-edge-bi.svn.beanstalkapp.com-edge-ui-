<?php

class AdScheduling extends Controller {
	
	function index($accountID){

		$facebook = $this->edgeapi->Request('/accounts/'.$accountID.'/campaigns?channel=6');

		
		 $data = array(
	 	"facebook"=>$facebook
	 	
	 );
	 

	 	$this->load->view('AdScheduling',$data);
			
	}
function getscheduler($accountID,$campaign){



   $scheduler = $this->edgeapi->Request('/accounts/'.$accountID.'/campaigns/'.$campaign);

	$data=array(
	"scheduler"=>$scheduler
		);


		echo  $data["scheduler"];
}	

function updateScheduler($campaign,$accountID){


     $data = json_decode(file_get_contents("php://input"), true) ;

	$result = $this->edgeapi->Request('/accounts/'.$accountID.'/campaigns/'.$campaign.'', 'POST', true, array('Content-Type: application/json'), $data, true);


	
}
}

