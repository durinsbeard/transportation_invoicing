
<?include('includes/connect.php');?>

<meta http-equiv="X-UA-Compatible" content="IE=edge">

<link href="css/jquery-ui.css" rel="stylesheet">
<script src="js/jquery-ui.js" type="text/javascript"></script>


<script>
$(document).ready(function(){ 
	
	$("#customer_phone").mask("(999) 999-9999");
	$("#customer_zip").mask("?99999");
	$("#carrier_phone").mask("(999) 999-9999");
	$("#carrier_zip").mask("?99999");
	
		
	$(".customer_info").click(function(){
		alert($(".customer_info").val);
	});
	
	$(".carrier_info").click(function(){
		alert("hello");
	});
	
	$("#tabs").tabs({
		activate: function(event, ui){}
			
	});
		
	//var valCity = /^[a-zA-z] ?([a-zA-z]|[a-zA-z] )*[a-zA-z]$/;
	//var valAddress = /^[a-zA-Z0-9-\/] ?([a-zA-Z0-9-\/]|[a-zA-Z0-9-\/] )*[a-zA-Z0-9-\/]$/;
		
}); 

function clearFields(){
	document.getElementById("firstName").value = "";;
	document.getElementById("lastName").value = "";
	document.getElementById("email").value = "";
}

function validate_customer(){
		var customer = document.getElementById("new_customer").value;
		if (customer==""){
			alert("You must enter a customer");
			return false;
			document.getElementById("new_customer").focus();
			
			
		}else{
			if(confirm("Are you sure you want to submit?")){
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
if(isset($_GET['message']))
{
	$customer=$_GET['customer'];
	$carrier=$_GET['carrier'];
	
	if($_GET['message']==1)
	{
		echo "<div style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#F6CECE;width:700px;margin-top:50px;height:25px;font-size:20px;font-family:arial;margin-left:-5%''><center>The customer <b>".$customer."</b> already exists.</center></div>";	
	}else if($_GET['message']==2)
	{
		echo "<center><div style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#6E8A37;width:700px;margin-top:50px;height:25px;font-size:20px;font-family:arial;color:white;margin-left:-5%'><center>Successfully added <b>".$customer."</b></center></div></center>";	
	}else if($_GET['message']==3)
	{
		echo "<center><div style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#F6CECE;width:700px;margin-top:50px;height:25px;font-size:20px;font-family:arial;margin-left:-5%''><center>Error submitting data. Please contact support.</center></div></center>";
	}else if($_GET['message']==4)
	{
		echo "<center><div style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#F6CECE;width:700px;margin-top:50px;height:25px;font-size:20px;font-family:arial;margin-left:-5%''><center>The carrier <b>".$carrier."</b> already exists.</center></div></center>";	
	}else if($_GET['message']==5)
	{
		echo "<center><div style='border:1px solid #A4A4A4;border-radius:7px;color:#6E6E6E;background:#6E8A37;width:700px;margin-top:50px;height:25px;font-size:20px;font-family:arial;color:white;margin-left:-5%''><center>Successfully added <b>".$carrier."</b></center></div></center>";	
	}
}
?>
<div id="tabs" class="report_data"  style="border:none;">
	<ul class="report_data" style="height:30px;">
		<li><a href="#tabs-1">Customer Mgt.</a></li>
		<li><a href="#tabs-2">Carrier Mgt.</a></li>
	</ul>
	<div id="tabs-1">
		<form action="submits/new_customer_submit.php" method="post">
			<table id="contentTable">
				<tr>
					<td style="white-space: nowrap;">			
						Customer Name:
					</td>
					<td>
						<input type="text" name="new_customer" id="new_customer" size="40" style="font-size:8px;"/>
					</td>
				</tr>
				<tr>
					<td style="white-space: nowrap;">			
						Customer Street:
					</td>
					<td>
						<input type="text" id="customer_street" name="customer_street" size="60" style="font-size:8px;"/>
					</td>
				</tr>
				<tr>
					<td style="white-space: nowrap;">			
						Customer City:
					</td>
					<td>
						<input type="text" id="customer_city" name="customer_city"  size="50" style="font-size:8px;"/>
					</td>
				</tr>
				<tr>
					<td style="white-space: nowrap;">			
						Customer State:
					</td>
					<td>
						<select name="customer_state" id="customer_state" style="font-size:8px;">
							<?
							$sql_cust_state = "SELECT * from states";
							$qry_cust_state = mysql_query($sql_cust_state,$con);
							while($states=mysql_fetch_array($qry_cust_state))
							{
								?><option value="<?echo $states['state_abrv']?>"><?echo $states['state_abrv']?></option><?
							}  
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td style="white-space: nowrap;">			
						Customer Zip Code:
					</td>
					<td>
						<input type="text" name="customer_zip" id="customer_zip" size="10" style="font-size:8px;"/>
					</td>
				</tr>
				<tr>
					<td style="white-space: nowrap;">			
						Customer Phone Number:
					</td>
					<td>
						<input type="text" name="customer_phone" id="customer_phone" size="20" style="font-size:8px;"/>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-algn:center;">
						<input id="sub_button" name="submit_new_customer" type="submit" value="SUBMIT NEW CUSTOMER" class="wide"  
							   style="margin-top:10px;font-size:8px;margin-left:40%" onclick="return validate_customer()"/>
					</td>
				</tr>
			</table>
		</form>
			<?
			$sql_get_users="SELECT * FROM customers WHERE active = 1";
			$get_users_query=mysql_query($sql_get_users,$con);
			?>
		<form action="submits/user_submit.php" method="post" >
			<table width="100%" class="reportTable" id="reportTable" cellspacing="0" style="margin-top:15px;">
				<thead>
					<tr>
						<th style="font-size:10px;">
							Existing Customers:
						</th>
					</tr>
				</thead>
				<tbody>
				<?
				while($row=mysql_fetch_array($get_users_query)){
				?>
					<tr>
						<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:100px;font-size:10px;">
							<a href="javascript:void(0);" onClick=window.open("edit_customer.php?customer_id=<?echo $row['customer_id']?>","Ratting","width=700,height=500,0,status=0,");>
							   <?echo $row['customer_name']?>
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
	<div id="tabs-2">
		<form action="submits/new_carrier_submit.php" method="post">
			<table id="contentTable">
				<tr>
					<td style="white-space: nowrap;">			
						Carrier Name:
					</td>
					<td>
						<input type="text" name="new_carrier" id="new_carrier" size="40" style="font-size:8px;"/>
					</td>
				</tr>
				<tr>
					<td style="white-space: nowrap;">			
						Carrier Street:
					</td>
					<td>
						<input type="text" id="carrier_street" name="carrier_street"  size="60" style="font-size:8px;"/>
					</td>
				</tr>
				<tr>
					<td style="white-space: nowrap;">			
						Carrier City:
					</td>
					<td>
						<input type="text" id="carrier_city"  name="carrier_city" size="50" style="font-size:8px;"/>
					</td>
				</tr>
				<tr>
					<td style="white-space: nowrap;">			
						Carrier State:
					</td>
					<td>
						<select name="carrier_state" id="carrier_state" style="font-size:8px;">
							<?
								$sql_car_state = "SELECT * from states";
								$qry_car_state = mysql_query($sql_car_state,$con);
								while($states=mysql_fetch_array($qry_car_state))
								{
									?><option value='<?echo $states['state_abrv']?>'><?echo $states['state_abrv']?></option><?
								}  
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td style="white-space: nowrap;">			
						Carrier Zip Code:
					</td>
					<td>
						<input type="text" name="carrier_zip" id="carrier_zip" size="10" style="font-size:8px;"/>
					</td>
				</tr>
				<tr>
					<td style="white-space: nowrap;">			
						Carrier Phone Number:
					</td>
					<td>
						<input type="text" name="carrier_phone" id="carrier_phone" size="20" style="font-size:8px;"/>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-algn:center;">
						<input id="sub_button" name="submit_new_carrier" type="submit" value="SUBMIT NEW CARRIER" class="wide" 
							   style="margin-top:10px;font-size:8px;margin-left:40%" onclick="return validate_carrier()" />
					</td>
				</tr>
			</table>
		</form>
		<?
		$sql_get_users="SELECT * FROM carriers WHERE active = 1";
		$get_users_query=mysql_query($sql_get_users,$con);
		?>
		<form action="submits/user_submit.php" method="post" >
			<table width="100%" class="reportTable" id="reportTable" cellspacing="0" style="margin-top:15px;">
				<thead>
					<tr>
						<th style="font-size:10px;">
							Existing Carriers:
						</th>
					</tr>
				</thead>
				<tbody>
				<?
				while($row=mysql_fetch_array($get_users_query)){
				?>
					<tr>
						<td style="border:1px solid; border-color:#A4A4A4; border-radius:5px; text-align:center;width:100px;font-size:10px;">
							<a href="javascript:void(0);" onClick=window.open("edit_carrier.php?carrier_id=<?echo $row['carrier_id']?>","Ratting","width=700,height=500,0,status=0,");>
							   <?echo $row['carrier_name']?>
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
</div>