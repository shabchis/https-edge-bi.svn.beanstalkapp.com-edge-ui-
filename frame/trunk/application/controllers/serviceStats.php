<?php
/**
 * serviceStats controller, retrieves list of services and their statisitics for the requested day
 */
class serviceStats extends Controller{
	
	function index(){
		
		$this->load->view('serviceOutcome');		
	}
	
	function  getServices(){
		
		$date = date('Y-m-d', strtotime($this->input->post('date')));
		$account = $this->input->post('accountID');
		$response = $this->edgeapi->Request('/accounts/'.$account.'/Services?date='.$date);
		echo  $response;
	}
}

?>
