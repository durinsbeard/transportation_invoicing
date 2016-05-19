<?
include('../includes/connect.php');
$first_name = mysql_real_escape_string($_POST['first_name']);
$last_name = mysql_real_escape_string($_POST['last_name']);
$username = mysql_real_escape_string($_POST['uname']);
$password = mysql_real_escape_string($_POST['password']);
$sqlDup="select * from members where first_name = '".$first_name."' AND last_name = '".$last_name."'";
$checkDup = mysql_query($sqlDup,$con);
	
echo $password;
if (mysql_num_rows($checkDup) <> 0)
{
	header('Location: ../index.php?form=manage_users&user='.$first_name.' '.$last_name.'&message=1');
}else
{
	$sql="insert into members (first_name, last_name, username, password) values ('".$first_name."','".$last_name."','".$username."',PASSWORD('".$password."'))";
	if(mysql_query($sql,$con))
	{
		header('Location: ../index.php?form=manage_users&user='.$first_name.' '.$last_name.'&message=2');
	}else
	{
		header('Location: ../index.php?form=manage_users&user='.$first_name.' '.$last_name.'&message=3');
	}	

}
?>