<?php

class Importer extends Controller{
	
	function index(){
		
		$this->load->view('importer');		
	}
	
	function upload(){	
		$numOfFiles = count($_FILES['files']['tmp_name']);
		
		$base_dir ="D:/uploads/"; 
		$name = $_COOKIE['edgebi_user']!='' ? $_COOKIE['edgebi_user'] : '000';
		$target_dir = $base_dir .$name."_".rand()."/";
		
		if(mkdir($target_dir , 0777)) 
		{ 	
			$data = array();
			
			for($i=0; $i <$numOfFiles;$i++)
			{
				 $filename =  $_FILES['files']['name'] [$i];
				if (!empty($filename))
				{
					$move_dir = $target_dir . basename( $filename); 
					move_uploaded_file($_FILES['files']['tmp_name'][$i], $move_dir);
					$data["_guids"][$i]=  $this->edgeapi->Request('/accounts/1007/Services/ImporterTester?options=a=b','POST', true, array('Content-Length: 0'));
					$data["_files"][$i]=$filename;	
				}							
			}
			
			$this->load->view('status_page',$data);
		} 
		else 
		{ 
			//do something on error
		}		
	}
	
	function getStatus($guid){
		$status =$this->edgeapi->Request('/accounts/1007/Services?guid='.$guid);  
		
		$data = array(
	 	"status"=>$status
	 		 );
		echo  $data["status"]; 
	}
}