<?
include('../includes/connect.php');



if (isset($_POST['edit_carrier'])){
	$carrier_id=mysql_real_escape_string($_POST['carrier_id']);
	//$carrier_name=mysql_real_escape_string($_POST['carrier_name']);
	$street=mysql_real_escape_string($_POST['carrier_street']);
	$state=mysql_real_escape_string($_POST['carrier_state']);
	$city=mysql_real_escape_string($_POST['carrier_city']);
	$zip_code=mysql_real_escape_string($_POST['carrier_zip']);
	$phone=mysql_real_escape_string($_POST['carrier_phone']);
	
$sql_update_carrier = "UPDATE carriers SET car_street = '".$street."',
										   car_city = '".$city."',
										   car_state = '".$state."',
										   car_zip = '".$zip_code."',
										   car_phone = '".$phone."'
					   WHERE carrier_id = '".$carrier_id."'";
		if(mysql_query($sql_update_carrier,$con))
		{
			
			echo "success";
			header('Location: ../edit_carrier.php?&carrier_id='.$carrier_id.'');
		}else
		{
			echo "update failed";
			//header('Location: ../index.php?form=manage_customers_carriers&carrier='.$carrier.'&message=3');
		}	

	
}
?>