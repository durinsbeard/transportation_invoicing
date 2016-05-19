<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="css/style.css" />
<script>
	function validate_user(){
			var first_name = document.getElementById("first_name").value;
			var last_name = document.getElementById("last_name").value;
			var username = document.getElementById("uname").value;
			var password = document.getElementById("password").value;
			var confirm_password = document.getElementById("confirm_password").value;
			
			if (first_name ==""){
				alert("You must enter a first name");
				return false;
				document.getElementById("first_name").focus();
			}else if (last_name ==""){
					alert("You must enter a last name");
				return false;
				document.getElementById("last_name").focus();
			}else if (username==""){
					alert("You must enter a username");
				return false;
				document.getElementById("username").focus();
			}else if (password ==""){
					alert("You must enter a password");
				return false;
				document.getElementById("password").focus();
			}else if (password != confirm_password){
					alert("Password mismatch! Please re-enter.");
				return false;
				document.getElementById("password").focus();
			}else{
				if(confirm("Are you sure you want to submit?")){
					return true;
				}
				else{
					return false;
				}
			}
	}
</script>
<?
include('includes/connect.php');
if (isset($_REQUEST['user_id'])){
	$user_id	=  $_REQUEST['user_id'];
	$sql_get_user = "SELECT * FROM members WHERE user_id = '".$user_id."'";
	$get_user_query=mysql_query($sql_get_user,$con);
	
	//echo $customer_id;
	//echo $sql_get_customer;
?>

<form action="submits/edit_user_submit.php" method="post">
<?while($row=mysql_fetch_array($get_user_query)){?>
			
	<table id="editTable" style="width:100%;">
		<td style="white-space: nowrap;">			
				First Name:
			</td>
			<td>
				<input type="text" name="first_name" id="first_name" size="40" style="font-size:8px;" value="<?echo $row['first_name']?>"/>
				<input type="hidden" name="user_id" id="first_name" size="40" style="font-size:8px;" value="<?echo $row['user_id']?>"/>
			</td>
		</tr>
		<tr>
			<td style="">			
				Last Name:
			</td>
			<td>
				<input type="text" name="last_name" id="last_name" size="40" style="font-size:8px;" value="<?echo $row['last_name']?>"/>
				
			</td>
		</tr>
		<tr>
			<td style="">			
				Username:
			</td>
			<td>
				<input type="text" name="uname" id="uname" size="40" style="font-size:8px;" value="<?echo $row['username']?>"/>
			</td>
		</tr>
		<tr>
			<td style="">			
				Password:
			</td>
			<td>
				<input type="password" name="password" id="password" size="41" style="font-size:8px;"/>
			</td>
		</tr>
		<tr>
			<td style="">			
				Confirm Password:
			</td>
			<td>
				<input type="password" name="confirm_password" id="confirm_password" size="41" style="font-size:8px;"/>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-algn:center;">
				<input id="sub_button" name="edit_user" type="submit" value="SUBMIT INFORMATION" class="wide" class="wide" 
				style="margin-top:10px;font-size:8px;margin-left:41%"  onclick="return validate_user();"/>
			</td>
		</tr>
	</table>
</form>
<?
	}
}
?>