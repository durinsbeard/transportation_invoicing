<?
include('../includes/connect.php');



if (isset($_POST['edit_customer'])){
	$customer_id=mysql_real_escape_string($_POST['customer_id']);
	//$customer_name=mysql_real_escape_string($_POST['customer_name']);
	$street=mysql_real_escape_string($_POST['customer_street']);
	$state=mysql_real_escape_string($_POST['customer_state']);
	$city=mysql_real_escape_string($_POST['customer_city']);
	$zip_code=mysql_real_escape_string($_POST['customer_zip']);
	$phone=mysql_real_escape_string($_POST['customer_phone']);
	
$sql_update_customer = "UPDATE customers SET cust_street = '".$street."',
										     cust_city = '".$city."',
										     cust_state = '".$state."',
										     cust_zip = '".$zip_code."',
											 cust_phone = '".$phone."'
					   WHERE customer_id = '".$customer_id."'";
		if(mysql_query($sql_update_customer,$con))
		{
			
			//echo "success";
			header('Location: ../edit_customer.php?&customer_id='.$customer_id.'');
		}else
		{
			echo "update failed";
			//header('Location: ../index.php?form=manage_customers_carriers&carrier='.$carrier.'&message=3');
		}	

	
}
?>