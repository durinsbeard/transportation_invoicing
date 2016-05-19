<?
include('../includes/connect.php');
if (isset($_REQUEST['inv_line_items']))
{

	$srcl_inv_num="srcl_'".uniqid();
	$service_charge=mysql_real_escape_string($_REQUEST['service_charge']);
	$admin_fee=mysql_real_escape_string($_REQUEST['admin_fee']);
	$sub_fee=mysql_real_escape_string($_REQUEST['sub_fee']);
	$srcl_inv_total = $service_charge + $admin_fee + $sub_fee;
	$date = date();
	
	$line_items=mysql_real_escape_string($_REQUEST['inv_line_items']);
	$customer=mysql_real_escape_string($_REQUEST['customer_id']);
	$carrier=mysql_real_escape_string($_REQUEST['carrier_id']);
	$invoice=mysql_real_escape_string($_REQUEST['invoice']);
	$begin_date=mysql_real_escape_string($_REQUEST['begin_date']);
	$end_date=mysql_real_escape_string($_REQUEST['end_date']);
	
	$sql = "INSERT INTO srcl_invoice_table (srcl_inv_num,srcl_srv_chrg,srcl_admin_fee,srcl_sub_fee,srcl_inv_total,src_inv_date) 
			VALUES ('".$srcl_inv_num."','".$service_charge."','".$admin_fee."','".$sub_fee."','".$srcl_inv_total."','".$date."')";
	echo $sql;
	
	/*echo $customer;
	$line_items=unserialize(base64_decode($_REQUEST['line_items']));
	$line_items= explode(",",$line_items);
	$line_items=unserialize(base64_decode($_REQUEST['line_items']));*/
	//$sql="UPDATE dayton SET status = 3 WHERE line_item_id IN (".$line_items.")"; 
	//echo $sql;
	//if(mysql_query($sql,$con)){
		
		//header('Location: ../index.php?form=reporting&customer='.$customer.'&carrier='.$carrier.'&invoice='.$invoice.'&from='.$begin_date.'&to='.$end_date.'');
	//}
}
?>