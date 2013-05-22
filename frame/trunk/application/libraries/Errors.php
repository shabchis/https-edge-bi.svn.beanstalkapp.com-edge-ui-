<?php

class Errors
{
	function ThrowEx($msg, $statusCode, $data = null, $redirect = false, $preferJson = true )
	{	
		if (IS_AJAX && $preferJson)
		{
			if (!$data)
				$data = new stdClass();
			if ($msg)
				$data->message = $msg;
			if ($redirect)
				$data->redirect = config_item('edge_login_url');
			
			header('HTTP/1.1 '. $statusCode);
			header('Content-Type: application/json');
			echo json_encode($data);
			
			exit();
		}
		else
		{	
			if ($redirect)
				$this->Redirect($statusCode, config_item('edge_login_url') ) ;
			else
				show_error($msg, $statusCode);
		}
	}
	
	function Redirect($statusCode, $url)
	{
		header('HTTP/1.1 '. $statusCode);
		header( 'Location: '.$url) ;
		exit();
	}
}
