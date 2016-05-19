<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="css/style.css" />
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>

<script src="js/jquery.maskedinput.js" type="text/javascript"></script>

<script src="js/jquery-ui.js" type="text/javascript"></script>


	
<script>
$(document).ready(function(){ 
	$("#customer_phone").mask("(999) 999-9999");
	$("#customer_zip").mask("?99999");
	
	
}); 


</script>
<?
include('includes/connect.php');
if (isset($_REQUEST['customer_id'])){
	$customer_id	=  $_REQUEST['customer_id'];
	$sql_get_customer = "SELECT * FROM customers 
						 WHERE customer_id = '".$customer_id."'";
	$get_customer_query=mysql_query($sql_get_customer,$con);
?>
<form action="submits/edit_customer_submit.php" method="post">
	<?
	while($row=mysql_fetch_array($get_customer_query)){
	?>
			<center>
			<table id="editTable">
				<tr>
					<td style="white-space: nowrap;">			
						Customer Name:
					</td>
					<td>
						<?echo $row['customer_name']?>
						<input type="hidden" name="customer_name" id="new_customer" size="40" style="font-size:8px;" value="<?echo $row['customer_name']?>"/>
						<input type="hidden" name="customer_id" size="40" style="font-size:8px;" value="<?echo $row['customer_id']?>"/>
					</td>
				</tr>
				<tr>
					<td style="white-space: nowrap;">			
						Customer Street:
					</td>
					<td>
						<input type="text" id="customer_street" name="customer_street"  size="60" style="font-size:8px;" value="<?echo $row['cust_street']?>"/>
					</td>
				</tr>
				<tr>
					<td style="white-space: nowrap;">			
						Customer City:
					</td>
					<td>
						<input type="text" id="customer_city"  name="customer_city" size="50" style="font-size:8px;" value="<?echo $row['cust_city']?>"/>
					</td>
				</tr>
				<tr>
					<td style="white-space: nowrap;">			
						Customer State:
					</td>
					<td>
							<?
							$sql_customer_state="SELECT cust_state FROM customers
												 WHERE customer_id = '".$customer_id."'";
						    $query_customer_state = mysql_query($sql_customer_state,$con);
							$customer_state=mysql_fetch_array($query_customer_state);						
						?>
						<select name="customer_state" id="customer_state" id='company'>
							<option value='<?php echo $customer_state['cust_state']; ?>'><?php echo $customer_state['cust_state']?></option>
							<?
								$sql_car_state = "SELECT * FROM states";
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
						Customer Zip Code:
					</td>
					<td>
						<input type="text" name="customer_zip" id="customer_zip" size="10" style="font-size:8px;" value="<?echo $row['cust_zip']?>"/>
					</td>
				</tr>
				<tr>
					<td style="white-space: nowrap;">			
						Customer Phone Number:
					</td>
					<td>
						<input type="text" name="customer_phone" id="customer_phone" size="20" style="font-size:8px;" value="<?echo $row['cust_phone']?>"/>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-algn:center;">
						<input id="sub_button" name="edit_customer" type="submit" value="SUBMIT INFORMATION" class="wide" 
							   style="margin-top:10px;font-size:8px;margin-left:40%"  />
					</td>
				</tr>
			</table>
			</center>
		</form>
<?
	}
}
?>