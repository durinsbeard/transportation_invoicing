<?php
	include('variables.php');
	
	$con = mysql_connect($server,$username,$password);
	
	if(!$con)
	{
		die('Could not Connect: ' . mysql_error());
	}
	mysql_select_db($database);
?>