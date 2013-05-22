<?php

class Login extends Controller {
		
		
	function index()
	{
		// don't allow non-ajax requests
		if(!IS_AJAX)
		{
 			$this->errors->ThrowEx('Please enable JavaScript.', 400);
 		}
		
		// Get login parameters from form
		$data = array(
			"operationType" => 'New',
			"email" =>  $this->input->post('email'),
			"password"=>$this->input->post('password')
		);
	
		// Check if valid parameters
		if (!isset($data["email"]) || $data["email"] == '' ||
			!isset($data["password"]) || $data["password"] == '')
		{
			$this->errors->ThrowEx("Invalid login details.", 400);
		}
		
		// Determines whether user/session cookies are reused later
		$remember =  $this->input->post('remember');
		
		// execute the login
		$this->edgeapi->Login($data, $remember, true);
	}	 
	
	function logout()
	{	
		global $APPLICATION_ROOT;
    
		delete_cookie("edgebi_session",null,$APPLICATION_ROOT);
		delete_cookie("edgebi_user",null,$APPLICATION_ROOT);
		delete_cookie("edgebi_child_account",null,$APPLICATION_ROOT);
		delete_cookie("edgebi_parent_account",null,$APPLICATION_ROOT);
		delete_cookie("edgebi_remember",null,$APPLICATION_ROOT);
		
		redirect(config_item('edge_login_url'));
	}

}