<?php
//core
function dbcon(){
	$user = "root";
	$pass = "";
	$host = "localhost";
	$db = "results_db";
	@mysql_pconnect($host,$user,$pass);
	mysql_select_db($db);
}

?>
