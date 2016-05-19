<?
include('../includes/connect.php');



if (isset($_POST['edit_user'])){
	
	//$customer_name=mysql_real_escape_string($_POST['customer_name']);
	$first_name=mysql_real_escape_string($_POST['first_name']);
	$last_name=mysql_real_escape_string($_POST['last_name']);
	$username=mysql_real_escape_string($_POST['uname']);
	$password=mysql_real_escape_string($_POST['password']);
	$user_id=mysql_real_escape_string($_POST['user_id']);
	
	echo $username;
					   
	
		$sql_update_user = "UPDATE members SET first_name = '".$first_name."',
											   last_name = '".$last_name."',
											   username = '".$username."',
											   password = PASSWORD('".$password."')
							WHERE user_id = '".$user_id."'";
		echo $sql_update_user;
			if(mysql_query($sql_update_user,$con))
			{
				//echo "success";
				header('Location: ../edit_user.php?&user_id='.$user_id.'');
			}else
			{
				echo "update failed";
				//header('Location: ../index.php?form=manage_customers_carriers&carrier='.$carrier.'&message=3');
			}
	}else{
		header('Location: ../edit_user.php?&message=2&user_id='.$user_id.'');
	}

	

?>