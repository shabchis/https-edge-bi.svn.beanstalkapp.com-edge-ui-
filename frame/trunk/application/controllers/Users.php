<?php
class Users extends Controller {

  function index()
  {

     $groups = $this->edgeapi->Request('/groups');
	 $names=  $this->edgeapi->Request('/users');
	 $data = array(
	 	"groups"=>$groups,
	 	"users"=>$names
	 );



       		$this->load->view('users_test',$data);
  }

 function getUsers($userID)
  	{

  		$users =$this->edgeapi->Request('/users/'.$userID);
		$data = array(
	 	"gusers"=>$users
	 		 );
				$this->firephp->log(json_decode($data["gusers"]));
		echo  $data["gusers"];




 	}
function getTree(){

	$tree = $this->edgeapi->Request('/permissions/tree');

		//$this->firephp->log($tree);
	echo $tree;


}

function getgroups($ID){

    $groups = $this->edgeapi->Request('/groups/'.$ID.'');
    $data = array(
	 	"groups"=>$groups
	 		 );

   // $this->firephp->log(json_decode($data["groups"]));
    echo $data["groups"];
}

function sendUser($userID){


     $data = json_decode(file_get_contents("php://input"), true) ;

      $this->firephp->log($data);
    $result = $this->edgeapi->Request('/users/'.$userID,'PUT', true,array('Content-Type: application/json'),$data ,true );

 //      $this->firephp->log($result);

}
function deleteUser($userID){
	  

 $result = $this->edgeapi->Request('/users/'.$userID,'DELETE', true,null,null ,true );
	
}
}

