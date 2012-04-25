<?php
class DBConn{

function DBConnenction($server="192.168.1.151",$User="sa",$Pass="Iuh2sstd",$DB="Source")
{
$dbhandle = mssql_connect($server, $User, $Pass)
  or die("Couldn't connect to SQL Server on $server.". mssql_get_last_message());

//select a database to work with
$selected = mssql_select_db($DB, $dbhandle)
  or die("Couldn't open database $myDB");

return $dbhandle;
 

}
}
