<?
include('../includes/connect.php');

if (isset($_POST['submit_new_customer'])){
	$customer=mysql_real_escape_string($_POST['new_customer']);
	$street=mysql_real_escape_string($_POST['customer_street']);
	$state=mysql_real_escape_string($_POST['customer_state']);
	$city=mysql_real_escape_string($_POST['customer_city']);
	$zip_code=mysql_real_escape_string($_POST['customer_zip']);
	$phone=mysql_real_escape_string($_POST['customer_phone']);
	
	$sql_cust_check_dups = "select * from customers where customer_name = '".$customer."'";
	$cust_check_dups = mysql_query($sql_cust_check_dups,$con);
	
	if (mysql_num_rows($cust_check_dups) != 0)
	{
		header('Location: ../index.php?form=manage_customers_carriers&customer='.$customer.'&message=1');
	}else
	{
		$sql_insert_customer="insert into customers (customer_name,cust_street,cust_city,cust_state,cust_zip,cust_phone) values ('".$customer."','".$street."','".$city."','".$state."','".$zip_code."','".$phone."')";
		if(mysql_query($sql_insert_customer,$con))
		{
			header('Location: ../index.php?form=manage_customers_carriers&customer='.$customer.'&message=2');
		}else
		{
			header('Location: ../index.php?form=manage_customers_carriers&customer='.$customer.'&message=3');
		}	

	}
}

?>