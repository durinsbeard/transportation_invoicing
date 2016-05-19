<?php
	session_start();
	include('includes/connect.php');
	
	$user = mysql_real_escape_string($_POST['uname']);
	$pword = mysql_real_escape_string($_POST['password']);
	
	$sql = "SELECT * FROM members WHERE username = '".$user."' and password = PASSWORD('".$pword."')";
	$result = mysql_query($sql,$con);
	$count = mysql_num_rows($result);
	if($count == 1)
	{
		$result=mysql_fetch_assoc($result);
		$_SESSION['logged_in']=1;
		$_SESSION['user_name']=$result['username'];
		$currentUser=trim($_SESSION['user_name']);
		//$_SESSION['department']=$result['department_id'];
		//$_SESSION['staff_level']=$result['staff_level'];
		header("location: index.php?form=create_rules&user='".preg_replace('/[^A-Za-z0-9\-]/', '', $user)."'");
		//echo "session"."  ".$_SESSION['logged_in'];
	}
	else
	{
		$sql = "SELECT * FROM login_check WHERE user_name = '".$user."' and password = '".$pword."')";
		$result = mysql_query($sql,$con);
		$count = mysql_num_rows($result);
		if($count==1)
		{
			$_SESSION['logged_in']=2;
			$_SESSION['user_name']="admin";
			$_SESSION['department']="all";
			$_SESSION['staff_level']=10;
			header("location: index.php?form=create_rules&user='".preg_replace('/[^A-Za-z0-9\-]/', '', $user)."'");
			
		}
		else
		{
			header('location: index.php?error=1');
			
		}
	}
	
?>