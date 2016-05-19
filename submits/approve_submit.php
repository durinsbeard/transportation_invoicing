<?
include('../includes/connect.php');
if (isset($_REQUEST['aprv_line_items']))
{
	$line_items=$_REQUEST['aprv_line_items'];
	$customer=$_REQUEST['customer_id'];
	$carrier=$_REQUEST['carrier_id'];
	$invoice=$_REQUEST['invoice'];
	$begin_date=$_REQUEST['begin_date'];
	$end_date=$_REQUEST['end_date'];
	//echo $customer;
	//
	//$line_items=unserialize(base64_decode($_REQUEST['line_items']));
	//;
	//$line_items= explode(",",$line_items);
	//$line_items=unserialize(base64_decode($_REQUEST['line_items']));
	$sql="UPDATE dayton set status = 2 WHERE line_item_id IN (".$line_items.")"; 
	//echo $sql;
	
	//echo $sql;
	if(mysql_query($sql,$con)){
		
		header('Location: ../index.php?form=reporting&customer='.$customer.'&carrier='.$carrier.'&invoice='.$invoice.'&from='.$begin_date.'&to='.$end_date.'');
	}
}
?>