<?php

class Refund extends Controller{
	
	function index(){
		$this->load->view('pages/refund');		
	}

	function add(){
		
		$data=array(
			"AccountID"=>$this->input->post('accountID'),
			"Month" =>$this->input->post('date'),
			"RefundAmount" =>$this->input->post('refund'),
			"ChannelID"=>$this->input->post('channel')
		);
		$result = $this->edgeapi->Request('/tools/refund', 'POST', true, array('Content-Type: application/json'), $data, true);
	}	
	
	function delete(){
			$data=array(
			"AccountID"=>$this->input->post('accountID'),
			"Month" =>$this->input->post('date'),
			"ChannelID"=>$this->input->post('channel')
		);		
		$result = $this->edgeapi->Request('/tools/deleterefund', 'POST', true, array('Content-Type: application/json'), $data, true);
	}
}