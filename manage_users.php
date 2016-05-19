<?include('includes/connect.php');?>

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link href="css/jquery-ui.css" rel="stylesheet">
<script src="js/jquery-ui.js" type="text/javascript"></script>


<script>
$(document).ready(function() { 


	$("table.display").dataTable({
	    //"scrollY": "600px",
		"scrollCollapse": true,
		"paging": true,
		"jQueryUI": true,
		"aoColumns": [{"sType":"string"}]
	});
	
	$("#customer_phone").mask("(999) 999-9999");
	$("#customer_zip").mask("?99999");
	$("#carrier_phone").mask("(999) 999-9999");
	$("#carrier_zip").mask("?99999");
		
	$('#customer_street').blur(function(){
		alert("call validation");
	});
	
	$('.user_info').click(function(){
		alert("call validation");
	});
}); 




function clearFields(){
	document.getElementById('firstName').value = "";;
	document.getElementById("lastName").value = "";
	document.getElementById("email").value = "";
}

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
			if(confirm("Are you sure that you want to submit?")){
				return true;
			}
			else{
				return false;
			}
		}
}

function validate_carrier(){
		var carrier = document.getElementById("new_carrier").value;
		
		
		if (carrier==""){
			alert("You must enter a carrier");
			return false;
			document.getElementById("new_carrier").focus();
			
			
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
	$customer=$_GET['customer'];
	$carrier=$_GET['carrier'];
	
	if($_GET['message']==1)
	{
		echo "<center><div style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#F6CECE;width:700px;margin-top:50px;height:25px;font-size:20px;font-family:arial;'><center>The customer <b>".$customer."</b> already exists.</center></div></center>";	
	}else if($_GET['message']==2)
	{
		echo "<center><div style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#6E8A37;width:700px;margin-top:50px;height:25px;font-size:20px;font-family:arial;color:white;'><center>Successfully added <b>".$customer."</b></center></div></center>";	
	}else if($_GET['message']==3)
	{
		echo "<center><div style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#F6CECE;width:700px;margin-top:50px;height:25px;font-size:20px;font-family:arial;'><center>Error submitting data. Please contact support.</center></div></center>";
	}else if($_GET['message']==4)
	{
		echo "<center><div style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#F6CECE;width:700px;margin-top:50px;height:25px;font-size:20px;font-family:arial;'><center>The carrier <b>".$carrier."</b> already exists.</center></div></center>";	
	}else if($_GET['message']==5)
	{
		echo "<center><div style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#6E8A37;width:700px;margin-top:50px;height:25px;font-size:20px;font-family:arial;color:white;'><center>Successfully added <b>".$carrier."</b></center></div></center>";	
	}
}
?>
<div id="tabs" class="report_data"  style="border:none;">
	<ul class="report_data" style="height:30px;">
		<li><a href="#tabs-1">User Mgt.</a></li>
	</ul>
	<div id="tabs-1">
<form action="submits/user_submit.php" method="post">
	<table id="contentTable" style="margin-left:29%;">
		<tr>
		<td style="white-space: nowrap;">			
				First Name:
			</td>
			<td>
				<input type="text" name="first_name" id="first_name" size="40"  style="font-size:8px;"/>
			</td>
		</tr>
		<tr>
			<td style="">			
				Last Name:
			</td>
			<td>
				<input type="text" name="last_name" id="last_name" size="40" style="font-size:8px;"/>
			</td>
		</tr>
		<tr>
			<td style="">			
				Username:
			</td>
			<td>
				<input type="text" name="uname" id="uname" size="40"  style="font-size:8px;"/>
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
				<input id="sub_button" type="submit" value="SUBMIT USER" class="wide" class="wide" 
				style="margin-top:10px;font-size:8px;margin-left:41%"  onclick="return validate_user();"/>
			</td>
		</tr>
	</table>
</form>
	<?
	  $sql_get_users="SELECT * FROM members WHERE active = 1";
	  $get_users_query=mysql_query($sql_get_users,$con);
	?>
	<form action="submits/user_submit.php" method="post">
		<table width="100%" class="reportTable" id="reportTable" cellspacing="0" style="margin-top:15px;">
			<thead>
				<tr>
				<th style="font-size:10px;">
					Existing Users:
				</th>
			</thead>
			<tbody>
			<?
			while($row=mysql_fetch_array($get_users_query)){
			?>
			
				<tr>
					<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:100px;font-size:10px;">
						<a href="javascript:void(0);" onClick=window.open("edit_user.php?user_id=<?echo $row['user_id']?>","Ratting","width=700,height=500,0,status=0,");>
							<?echo $row['first_name']." ".$row['last_name']?>
						</a>
					</td>
				</tr>
			<?
			}
			?>
			</tbody>
		</table>
	</form>
</div>