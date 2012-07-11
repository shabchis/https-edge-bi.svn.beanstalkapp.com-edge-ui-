<?php
/**
 *Importer  controller, handles file import and getting status of progress and outcome
 */
class Importer extends Controller{
	
	function index(){
		
		$this->load->view('importer');		
	}
	
	function upload(){	
		//Get accountID from cookie
		$account = $_COOKIE['edgebi_parent_account']!='' ? $_COOKIE['edgebi_parent_account'] : '000';
		
		$numOfFiles = count($_FILES['files']['tmp_name']);
		
		//Set destination location. Folder name based on userID and random number
		$base_dir ="D:/uploads/"; //Directory location
		$name = $_COOKIE['edgebi_user']!='' ? $_COOKIE['edgebi_user'] : '000';
		$target_dir = $base_dir .$name."_".rand()."/";//Full path
		
		//Get service to run according to imort type
		$sevice  = $_POST["importType"];
		
		if(mkdir($target_dir , 0777)) 
		{ 	
			$data = array();
			//Go over files (If there will be an option to upload more than one)
			for($i=0; $i <$numOfFiles;$i++)
			{
				 $filename =  $_FILES['files']['name'] [$i];
				if (!empty($filename))
				{
					//Move files to destination folder
					$move_dir = $target_dir . basename( $filename); 
					move_uploaded_file($_FILES['files']['tmp_name'][$i], $move_dir);
					
					//Request to run service for account (returns guid for tracking progress)
					$data["_guids"][$i]=  $this->edgeapi->Request('/accounts/'.$account.'/Services/'.$sevice.'?options=a=b','POST', true, array('Content-Length: 0'));
					$data["_files"][$i]=$filename;	
				}							
			}
			
			//Call status page and forward guids and filenames
			$this->load->view('status_page',$data);
		} 
		else 
		{ 
			//do something on error
		}		
	}
	
	function getStatus($guid){
		
		$account = $_COOKIE['edgebi_parent_account']!='' ? $_COOKIE['edgebi_parent_account'] : '000';
		
		//Request  status of service for account and guid
		$status =$this->edgeapi->Request('/accounts/'.$account.'/Services?guid='.$guid);  
		
		$data = array(
	 	"status"=>$status
	 	 );
		
		//Return status to view
		echo  $data["status"]; 
	}
}