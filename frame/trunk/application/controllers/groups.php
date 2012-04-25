<?php

class Groups extends Controller {
  
  function index()
  {
      
     $groups = $this->edgeapi->Request('/groups');  
	 $names=  $this->edgeapi->Request('/users');  
	 $data = array(
	 	"groups"=>$groups,
	 	"users"=>$names
	 );
	 
	 		
	// $this->firephp->log($data);
       		$this->load->view('group_testing',$data);
  }

 function getusers($groupID)
  	{
  		
  		$users =$this->edgeapi->Request('/groups/'.$groupID.'/users');  
		$data = array(
	 	"gusers"=>$users
	 		 );
			//	$this->firephp->log(json_decode($data["gusers"]));
		echo  $data["gusers"]; 

	
	
	
 	}
function gettree(){
	
	$tree = $this->edgeapi->Request('/permissions/tree');  
	
		//$this->firephp->log($tree);
	echo $tree; 

	
}	

function getgroups($ID){

    $groups = $this->edgeapi->Request('/groups/'.$ID.'');
    $data = array(
	 	"groups"=>$groups
	 		 );

   
    echo $data["groups"];
}

function sendGroup($groupID){


     $data = json_decode(file_get_contents("php://input"), true) ;


    $result = $this->edgeapi->Request('/groups/'.$groupID,'PUT', true,array('Content-Type: application/json'),$data ,true );

 //      $this->firephp->log($result);

}

function deleteGroup($groupID){
	
	    $result = $this->edgeapi->Request('/groups/'.$groupID,'DELETE', true,null,null ,true );
	
}
}

 