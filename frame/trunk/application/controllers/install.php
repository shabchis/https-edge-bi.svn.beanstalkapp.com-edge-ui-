<?php 
class Install extends Controller {
		
	function index()
	{
		
				 global $APPLICATION_ROOT;
	 if (!isset($_COOKIE['edgebi_wpf'])) {
	 	setcookie("edgebi_wpf",'true',time()+60*60*24*14,$APPLICATION_ROOT);
	
		
			
	 }
	/*else
		{
		delete_cookie("edgebi_wpf",null,$APPLICATION_ROOT);
		
		}
	
		
	}*/
	
}

