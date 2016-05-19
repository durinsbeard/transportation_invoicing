<link type="text/css" rel="stylesheet" href="css/style.css" />
<link href="css/jquery-ui.css" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="css/smoothness/jquery-ui-1.9.2.custom.css" />
<script src="JS/jquery-1.11.1.min.js" type="text/javascript"></script>
<script>
function clearFields(){
	document.getElementById('firstName').value = "";;
	document.getElementById("lastName").value = "";
	document.getElementById("email").value = "";
}

function update_uname(){ 
	first = document.getElementById("firstName").value;
	initial = first.charAt(0).toLowerCase();
	last = document.getElementById("lastName").value;   
	document.getElementById("uname").value = initial+last.toLowerCase();      
} 

function validate(){
		var first = document.getElementById("firstName").value;
		var last = document.getElementById("lastName").value;
		var uname =  document.getElementById("uname").value;
		var password =  document.getElementById("password").value;
		var confirm_password =  document.getElementById("confirm_password").value;
		 if (first==""){
			
			alert("You must enter a first and last name.");
			document.getElementById("firstName").focus();
			return false;
			
		}else if (last==""){
			alert("You must enter a first and last name.");
			document.getElementById("lastName").focus();
			return false;
		
		}else if (uname==""){
			alert("You must enter a username for the user.");
			document.getElementById("uname").focus();
			return false;
		
		}else if (password==""){
			alert("You must enter a password for the user.");
			document.getElementById("password").focus();
			return false;
		
		}else if (confirm_password==""){
			alert("Please confirm password for user.");
			document.getElementById("confirm_password").focus();
			return false;
		
		}else if (password != confirm_password){
			alert("Password do not match.");
			document.getElementById("password").focus();
			return false;
		
		}else{
			if(confirm("Are you sure that you want to submit?")){
				return true;
			}
			else{
				return false;
			}
		}
}
</script> 
<?
if(isset($_GET['message']))
{
	$user=$_GET['user'];
	
	if($_GET['message']==1)
	{
		echo "<center><div style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#F6CECE;width:700px;margin-top:50px;height:25px;font-size:20px;font-family:arial;'><center>The user <b>".$user."</b> already exists.</center></div></center>";	
	}else if($_GET['message']==2)
	{
		echo "<center><div style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#6E8A37;width:700px;margin-top:50px;height:25px;font-size:20px;font-family:arial;color:white;'><center>Successfully added <b>".$user."</b></center></div></center>";	
	}else if($_GET['message']==3)
	{
		echo "<center><div style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#F6CECE;width:700px;margin-top:50px;height:25px;font-size:20px;font-family:arial;'><center>Error submitting data. Please contact support.</center></div></center>";
	}
	
}
?>
<form action="submits/user_submit.php" method="post">
	<legend id="contentLegend" style="margin-top:20px;color:#A4A4A4;">ENTER USER INFORMATION</legend>
	<table id="contentTable" >
		<td style="white-space: nowrap;">			
				First Name:
			</td>
			<td>
				<input type="text" name="firstName" id="firstName" size="40" onkeyup="update_uname"/>
			</td>
		</tr>
		<tr>
			<td style="">			
				Last Name:
			</td>
			<td>
				<input type="text" name="lastName" id="lastName" size="40" onkeyup="update_uname()"/>
			</td>
		</tr>
		<tr>
			<td style="">			
				Username:
			</td>
			<td>
				<input type="text" name="uname" id="uname" size="40" onkeyup="update_uname()"/>
			</td>
		</tr>
		<tr>
			<td style="">			
				Password:
			</td>
			<td>
				<input type="password" name="password" id="password" size="41"/>
			</td>
		</tr>
		<tr>
			<td style="">			
				Confirm Password:
			</td>
			<td>
				<input type="password" name="confirm_password" id="confirm_password" size="41"/>
			</td>
		</tr>
	</table>
	<td colspan="2" align="center">
			<center><input id="sub_button" type="submit" value="SUBMIT" class="wide" style="margin-top:10px" onclick="return validate();"/></center>
	</td>
</form>