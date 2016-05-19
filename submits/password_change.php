<?
include('../includes/connect.php');
session_start();
$_SESSION['logged_in']=2;

if ($_POST['user'] != ""){
	$user = $_POST['user'];
	$old_pass = $_POST['old'];
	$new_pass = $_POST['new'];
	
	$sql_check_pass = "SELECT username, password FROM members 
			           WHERE username = '". $user ."'
			           AND password = PASSWORD('". $old_pass ."')";
	$check_pass = mysql_query($sql_check_pass,$con);
	
	if(mysql_num_rows($check_pass) != 0){
		$sql = "UPDATE members SET password = PASSWORD('". $new_pass ."') WHERE username = '". $user ."'";
		if(mysql_query($sql,$con)){
			$sql = "UPDATE login_check SET password = PASSWORD('". $new_pass ."') WHERE user_name = '". $user ."'";
			if(mysql_query($sql,$con)){
				header('Location: ../index.php?form=change_password&message=1&user='. $user .'');
			}else{
				header('Location: ../index.php?form=change_password&message=2&user='. $user .'');
			}
		}else{
			echo $sql." is not valid";
		}
	}else{
		header('Location: ../index.php?form=change_password&message=2&user='. $user .'');
	}
}else{
	header('Location: ../index.php?form=change_password&message=3&user='. $user .'');
}
?>

