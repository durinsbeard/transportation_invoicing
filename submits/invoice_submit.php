<?
include('../includes/connect.php');
if (isset($_REQUEST['inv_line_items']))
{
	$line_items=mysql_real_escape_string($_REQUEST['inv_line_items']);
	$srcl_inv_num=mt_rand();
	//$service_charge=mysql_real_escape_string($_REQUEST['srv_chrg']);
	//$admin_fee=mysql_real_escape_string($_REQUEST['admin_fee']);
	//$sub_fee=mysql_real_escape_string($_REQUEST['sub_fee']);
	//$srcl_inv_total = $service_charge + $admin_fee + $sub_fee;
	$date = date("d-m-Y");
	if(isset($_REQUEST['invoice'])){
		$invoice=mysql_real_escape_string($_REQUEST['invoice']);
	}else{
		$invoice = "NULL";
	}
	if(isset($_REQUEST['customer_id'])){
		$customer = mysql_real_escape_string($_REQUEST['customer_id']);
	}else{
		$customer = "NULL";
	}
	if(isset($_REQUEST['carrier_id'])){
		$carrier = mysql_real_escape_string($_REQUEST['carrier_id']);
	}else{
		$carrier = "NULL";
	}
	
	if(isset($_REQUEST['begin_date']) && isset($_REQUEST['end_date'])){
		$begin_date = mysql_real_escape_string($_REQUEST['begin_date']);
		$end_date = mysql_real_escape_string($_REQUEST['end_date']);
	}else{
		$begin_date = "--Begin Date--";
		$end_date =  "--End Date--";
	}
	$sql = "INSERT INTO srcl_invoice_table (srcl_inv_num,srcl_inv_date) 
			VALUES ('".$srcl_inv_num."','".$date."')";
	if(mysql_query($sql,$con)){
		$sql="UPDATE dayton SET srcl_inv_id = '".$srcl_inv_num."', status = 3 WHERE line_item_id IN (".$line_items.")"; 
		if(mysql_query($sql,$con)){
			header('Location: ../index.php?form=reporting&customer='.$customer.'&carrier='.$carrier.'&invoice='.$invoice.'&from='.$begin_date.'&to='.$end_date.'');
		}
	}
}
?>
