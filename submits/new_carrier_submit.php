<?
include('../includes/connect.php');



if (isset($_POST['submit_new_carrier'])){
	$carrier=mysql_real_escape_string($_POST['new_carrier']);
	$street=mysql_real_escape_string($_POST['carrier_street']);
	$state=mysql_real_escape_string($_POST['carrier_state']);
	$city=mysql_real_escape_string($_POST['carrier_city']);
	$zip_code=mysql_real_escape_string($_POST['carrier_zip']);
	$phone=mysql_real_escape_string($_POST['carrier_phone']);
	
	$sql_car_check_dups = "select * from carriers where carrier_name = '".$carrier."'";
	$car_check_dups = mysql_query($sql_car_check_dups,$con);
	
	if (mysql_num_rows($car_check_dup) != 0)
	{
		header('Location: ../index.php?form=manage_customers_carriers&carrier='.$carrier.'&message=4');
	}else
	{
		$sql_insert_carrier = "insert into carriers (carrier_name,car_street,car_city,car_state,car_zip,car_phone) values ('".$carrier."','".$street."','".$city."','".$state."','".$zip_code."','".$phone."')";
		if(mysql_query($sql_insert_carrier,$con))
		{
			header('Location: ../index.php?form=manage_customers_carriers&carrier='.$carrier.'&message=5');
		}else
		{
			header('Location: ../index.php?form=manage_customers_carriers&carrier='.$carrier.'&message=3');
		}	

	}
}
?>