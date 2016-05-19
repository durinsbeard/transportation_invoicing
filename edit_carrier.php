<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link type="text/css" rel="stylesheet" href="css/style.css" />
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="js/jquery-ui.js" type="text/javascript"></script>
<script>
$(document).ready(function(){ 
	$("#carrier_phone").mask("(999) 999-9999");
	$("#carrier_zip").mask("?99999");
	
}); 
</script>
<?
include('includes/connect.php');
if (isset($_REQUEST['carrier_id'])){
	$carrier_id	=  $_REQUEST['carrier_id'];
	$sql_get_carrier = "SELECT * FROM carriers WHERE carrier_id = '".$carrier_id."'";
	$get_carrier_query=mysql_query($sql_get_carrier,$con);
	
	//echo $carrier_id;
	//echo $sql_get_carrier;
?>

<form action="" method="post">
<?while($row=mysql_fetch_array($get_carrier_query)){?>
			<table id="editTable">
				<tr>
					<td style="white-space: nowrap;">			
						Carrier Name:
					</td>
					<td>
						<?echo $row['carrier_name']?>
						<input type="hidden" name="carrier_name" id="new_carrier" size="40" style="font-size:8px;" value="<?echo $row['carrier_name']?>"/>
						<input type="hidden" name="carrier_id" id="new_carrier" size="40" style="font-size:8px;" value="<?echo $row['carrier_id']?>"/>
					</td>
				</tr>
				<tr>
					<td style="white-space: nowrap;">			
						Carrier Street:
					</td>
					<td>
						<input type="text" id="carrier_street" name="carrier_street"  size="60" style="font-size:8px;" value="<?echo $row['car_street']?>"/>
					</td>
				</tr>
				<tr>
					<td style="white-space: nowrap;">			
						Carrier City:
					</td>
					<td>
						<input type="text" id="carrier_city"  name="carrier_city" size="50" style="font-size:8px;" value="<?echo $row['car_city']?>"/>
					</td>
				</tr>
				<tr>
					<td style="white-space: nowrap;">			
						Carrier State:
					</td>
					<td>
						<?
							$sql_carrier_state="SELECT car_state FROM carriers
												WHERE carrier_id = '".$carrier_id."'";
						    $query_carrier_state = mysql_query($sql_carrier_state,$con);
							$carrier_state=mysql_fetch_array($query_carrier_state);						
						?>
						<select name="carrier_state" id="carrier_state" id='company'>
							<option value='<?php echo $carrier_state['car_state']; ?>'><?php echo $carrier_state['car_state']?></option>
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
						Carrier Zip Code:
					</td>
					<td>
						<input type="text" name="carrier_zip" id="carrier_zip" size="10" style="font-size:8px;" value="<?echo $row['car_zip']?>"/>
					</td>
				</tr>
				<tr>
					<td style="white-space: nowrap;">			
						Carrier Phone Number:
					</td>
					<td>
						<input type="text" name="carrier_phone" id="carrier_phone" size="20" style="font-size:8px;" value="<?echo $row['car_phone']?>"/>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-algn:center;">
						<input id="sub_button" name="edit_carrier" type="submit" value="SUBMIT INFORMATION" class="wide" 
							   style="margin-top:10px;font-size:8px;margin-left:40%" onclick="return validate_carrier()" />
					</td>
					
				</tr>
			</table>
		</form>
<?
	}
}
?>