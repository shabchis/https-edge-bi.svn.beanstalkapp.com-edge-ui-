<?php
class AccountValidation extends Controller {

function AccountValidation(){
 parent::Controller();
 $this->load->database();
}
function index(){

//$this->database();
//$this->DBConnenction();
		$data = array();
	/*
	$query = 'SELECT TOP 1000 [Account_ID]
      ,[DayCode]
      ,[Status]
      ,[Service]
      ,[Instance_ID]
      ,[LastUpdated]
      ,[Application]
      ,[Service_name]
  FROM [AccountsServicesLog]';
		
		
	$result = mssql_query($query);

	$numRows = mssql_num_rows($result);
	*/
	//$query = $this->get_records();
	$unique = $this->get_unique_records();
	$status =  $this->get_status();
	$accounts = $this->get_unique_accounts();
	$accountsids = $this->get_unique_accountsids();
	$application =  $this->get_unique_application();
	$daycode=  $this->get_unique_daycode();

	if( $unique && $status){
	
		
	$data=array(
		
		"unique"=>$unique,
		"status"=>$status,
		"accounts"=>$accounts,
		"accountsids"=>$accountsids,
		"application"=>$application,
		"daycode"=>$daycode
	);
	}
	
		
		


// $uniqueResult = array_unique($row);


		$this->load->view('accountValidation2',$data);	
	
}
function DBConnenction($server="192.168.1.151",$User="sa",$Pass="Iuh2sstd",$DB="Source")
{
$dbhandle = mssql_connect($server, $User, $Pass)
  or die("Couldn't connect to SQL Server on $server.". mssql_get_last_message());

//select a database to work with
$selected = mssql_select_db($DB, $dbhandle)
  or die("Couldn't open database $myDB");


 

}
function get_records()
	{
		$this->DBConnenction();
		//$where = "[LastUpdated]
//BETWEEN//  GETDATE() and GETDATE()";
		//	$this->db->where($where);
		$query = $this->db->get('AccountsServicesLog');
		//$spquery = $this->db->call_function('GetAccountsServicesLog',null);
		
		//$this->firephp->log($spquery);
		return $query->result();
	}
function get_unique_records()
	{
		$this->db->select("distinct Service");
		$unique = $this->db->get('AccountsServicesLog');
		
		return $unique->result();
	}
function get_unique_accounts()
	{
	
		$this->db->select("distinct Account_Name");
		$unique = $this->db->get('AccountsServicesLog');
		//var_dump("JSON errors:", $errors[json_last_error()]);
		
		$result = json_encode($unique->result());
	
		return $result;
		//return json_encode($unique->result());
			}
function get_unique_application()
	{
	
		$this->db->select("distinct Application");
		$unique = $this->db->get('AccountsServicesLog');
		
		return json_encode($unique->result());
	}
function get_unique_daycode()
	{
	
		$this->db->select("distinct DayCode");
		$unique = $this->db->get('AccountsServicesLog');
		
		return json_encode($unique->result());
	}
function get_unique_accountsids()
	{
	
		$this->db->select("distinct Account_ID");
		$unique = $this->db->get('AccountsServicesLog');
		
		return json_encode($unique->result());
	}
function get_by_date($from,$to)
	{
		$where = "[LastUpdated]
BETWEEN  '".$from."' and '".$to."'";
		$this->db->select("TOP 1000 [Account_ID]
      ,[DayCode]
      ,[Status]
      ,[Service]
      ,[Instance_ID]
      ,[LastUpdated]
      ,[Application]
      ,[Service_name]");
		$this->db->where($where);
		$unique = $this->db->get('AccountsServicesLog');
		
	//	$this->firephp->log(json_encode($unique->result()));
		echo json_encode($unique->result());
	

}	
function get_status(){
		//$this->db->select("distinct Status");
	
	$this->db->select("distinct case when [Status] =0 OR [Status] =9 then 9	when [Status] =1 OR [Status] =10 then 10 when [Status] is null then null else -1 end");
		$status = $this->db->get('Const_Services_Log_Status');
		//$this->firephp->log($status->result());
		return $status->result();


}
function search($status,$service,$from,$to){
	
	if($status == "200" )
	{
	$status = "'0','1','9','10'";
	}
	if($service == "1"){
	$service = "'1'";
	}
	 if($service == "200" )
	{
	$service = "'6','-1','0','1'";
	}
	 if($status == "9" )
	{
	$status = "'9','0'";
	}
 if($status == "10" )
	{
	$status = "'1','10'";
	}

	
	
		$where =  "[status] in (".$status.") and [Service] in (".$service.") and [LastUpdated]
		BETWEEN  '".$from."' and '".$to."'";
		
		
	$this->db->where($where);

	
	
		$this->db->select('distinct [Account_ID],[Account_Name],[DayCode] ,[Status]  ,[Service]  ,[Instance_ID] ,cast([LastUpdated] as nvarchar(50))  ,[Application] ');
		$search=$this->db->get('AccountsServicesLog');
		$this->firephp->log(json_encode($search->result()));
	echo json_encode($search->result());

}
}